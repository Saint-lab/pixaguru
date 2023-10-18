<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Authentication extends CI_Controller {
	private $g_userID;
	function __construct() {

		parent::__construct();
		$this->g_userID = $this->session->userdata( 'user_id' );
		$this->load->library('Stripe');
		if( $this->session->userdata( 'member_login' ) ){
			redirect( 'images', 'refresh' );
			$current_date = date("Y-m-d H:i:s"); 
			$where = array('user_id' =>$this->g_userID,'plan_period_end >'=> $current_date);
			$result = $this->Common_DML->get_data('user_subscriptions', $where);
			if(empty($result[0]['stripe_subscription_id'])){
				$array_items = array( 'user_id', 'email', 'member_login' );
				$this->session->unset_userdata( $array_items );
				$this->session->sess_destroy();
				redirect('authentication/subscription_plan', 'refresh');
			}
		}
		if( $this->session->userdata( 'admin_member_login' ) ){
			redirect( 'admin', 'refresh' );
		}
		
	}
	public function index(){
		$cookie_value = get_cookie('member');
		$data = array('login'=>true);
		if($cookie_value != null){
			$array = json_decode( base64_decode( $cookie_value ), true );
			$email = isset($array['email']) ? $array['email'] : '';
			$password = isset($array['password']) ? $array['password'] : '';
			$data['email'] = $email;
			$data['password'] = $password;
		}
		$this->load->view('common/header_auth');
		$this->load->view('login',$data);
		$this->load->view('common/footer_auth');
	}
	public function forgot(){
		$data = array('forgot'=>true);
		$this->load->view('common/header_auth');
		$this->load->view('login',$data);
		$this->load->view('common/footer_auth');
	}
	public function forgot_password(){
		if(!empty($_POST['email'])){
			$this->load->helper('email');
			if(valid_email( html_escape($_POST['email']) )){
				$where = array( 'email' => html_escape($_POST['email']), 'status' => 1 );
				$result = $this->Common_DML->get_data( 'users', $where, 'id, name, COUNT(*) As total' );
				if(!empty($result) && $result[0]['total'] == 1){
					$userDetail= array( 'email' => html_escape($_POST['email']) );
					$username = $result[0]['name'];
					$code = random_generator();
					$reset_link = base_url() . 'authentication/reset_password/'. $result[0]['id']. '/'.$code;
					$mail = array(
						"email" => $userDetail['email'],
						"name" => $username,
					);
					$template_name = 'media-forgot-password';
					$var = '[
						{
						"name": "USERNAME",
						"content": "'.$username.'"
						},
						{
						"name": "RESET_LINK",
						"content": "'.$reset_link.'"
						}
					]';
					$mresult = sendmailTemplate( $template_name, $mail, $var );
					$this->Common_DML->set_data( 'users', array('code'=>$code), array('id'=>$result[0]['id']) );
					
					echo json_encode( array( 'status' => 1, 'msg' => html_escape($this->lang->line('ltr_auth_forgot_password_msg1'))) );
				}else{
					echo json_encode( array( 'status'=>0, 'msg'=>html_escape($this->lang->line('ltr_auth_forgot_password_msg2'))) );
				}
			}else{
				echo json_encode( array( 'status'=>0, 'msg'=>html_escape($this->lang->line('ltr_auth_forgot_password_msg3'))) );
			}
		}else{
			redirect( 'authentication', 'refresh' );
		}
		die();
	}
	
	public function login(){
		if(!empty($_POST['email']) && !empty($_POST['password'])){
			$this->load->helper('email');
			if(valid_email( $_POST['email'] )){
				$where = array( 'email' => html_escape($_POST['email']), 'password' => md5(html_escape($_POST['password'])), 'status' => 1 );
				$result = $this->Common_DML->get_data( 'users', $where, '*' );
				if(!empty($result) && count($result) == 1){
					if($_POST['remeber']){
						set_cookie( 
							'member', 
							base64_encode( json_encode( array( 'email' => html_escape($_POST['email']), 'password' => html_escape($_POST['password'])) ) ), 
							86400 * 30 
						);
					}
					
					$datetime = $result[0]['datetime'];
					$access_level = $result[0]['access_level'];
					$diff = date_diffrence( date('Y-m-d'), date( 'Y-m-d', strtotime( $datetime ) ) );
					if($access_level == 1 && $diff > 30 && $result[0]['role'] == 'user'){
						$this->Common_DML->set_data( 'users', array('status'=>0), array('id'=>$result[0]['id']) );
						echo json_encode( array( 'status'=>0, 'msg'=>html_escape($this->lang->line('ltr_auth_login_msg1'))) );
						die();
					}elseif($access_level == 2 && $diff > 365 && $result[0]['role'] == 'user'){
						$this->Common_DML->set_data( 'users', array('status'=>0), array('id'=>$result[0]['id']) );
						echo json_encode( array( 'status'=>0, 'msg'=>html_escape($this->lang->line('ltr_auth_login_msg2'))) );
						die();
					}
					
					$profile_pic = !empty($result[0]['profile_pic']) ? $result[0]['profile_pic'] : '';
					$data = array(
						'user_id' => $result[0]['id'],
						'email' => html_escape($_POST['email']),
						'member_login' => $result[0]['role'] == 'user' ? true : false,
						'admin_member_login' => $result[0]['role'] == 'admin' ? true : false,
						'access_level' => $result[0]['access_level'],
						'profile_pic' => $profile_pic,
						'name' => $result[0]['name']
					);
					$where = array( 'user_id' => $result[0]['id'], 'status' => 1 );
					$fb_detail_data = $this->Common_DML->get_data( 'fb_details', $where, '*' );
					if(!empty($fb_detail_data) && count($fb_detail_data) == 1 && $fb_detail_data[0]['access_token'] != '' && $fb_detail_data[0]['app_id'] != '' && $fb_detail_data[0]['app_secret'] != '' && $result[0]['access_level'] >= 3){
						$data['facebook_post'] = true;
						$data['facebook_access_token'] = $fb_detail_data[0]['access_token'];
						$data['facebook_app_id'] = $fb_detail_data[0]['app_id'];
						$data['facebook_app_secret'] = $fb_detail_data[0]['app_secret'];
						$data['facebook_account_id'] = $fb_detail_data[0]['account_id'];
						$data['facebook_expire_access_token'] = $fb_detail_data[0]['expire_access_token'];
					}else{
						$data['facebook_post'] = false;
					}
					$this->session->set_userdata( $data );
					if($result[0]['role'] == 'user'){
						$url = base_url() . 'images';
					}else{
						$url = base_url() . 'admin';
					}
					echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_auth_login_msg3')), 'url' => $url ) );
				}else{
					
					$where = array( 'email' => html_escape($_POST['email']), 'password' => md5(html_escape($_POST['password'])) );
					$result = $this->Common_DML->get_data( 'users', $where, '*' );
					if(!empty($result) && count($result) == 1){
						$datetime = $result[0]['datetime'];
						$access_level = $result[0]['access_level'];
						$diff = date_diffrence( date('Y-m-d'), date( 'Y-m-d', strtotime( $datetime ) ) );
						if($access_level == 1 && $diff > 30){
							echo json_encode( array( 'status'=>0, 'msg'=>html_escape($this->lang->line('ltr_auth_login_msg4'))) );
							die();
						}elseif($access_level == 2 && $diff > 365){
							echo json_encode( array( 'status'=>0, 'msg'=>html_escape($this->lang->line('ltr_auth_login_msg4'))) );
							die();
						}
					}
					
					echo json_encode( array( 'status'=>0, 'msg'=>html_escape($this->lang->line('ltr_auth_login_msg5'))) );
				}
			}else{
				echo json_encode( array( 'status'=>0, 'msg'=>html_escape($this->lang->line('ltr_auth_login_msg6'))) );
			}
		}else{
			redirect( 'authentication', 'refresh' );
		}
		die();
	}
	public function reset_password( $id, $code ){
		$where = array( 'id' => $id, 'code' => $code, 'status' => 1 );
		$result = $this->Common_DML->get_data( 'users', $where, '*' );
		if(count($result) == 1){
			$data = array( 'reset_password' => true, 'user_id' => $id, 'code' => $code );
			$this->load->view('common/header_auth');
			$this->load->view('login',$data);
			$this->load->view('common/footer_auth');
		}else{
			redirect( 'authentication', 'refresh' );
		}
	}
	public function reset(){
		if(isset($_POST['password']) && !empty(html_escape($_POST['password'])) && !empty(html_escape($_POST['user_id']))){
			$what = array( 'password' => md5(html_escape($_POST['password'])), 'code' => '' );
			$where = array( 'id' => html_escape($_POST['user_id']), 'code' => html_escape($_POST['code']) );
			$this->Common_DML->set_data( 'users', $what, $where ); 
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_auth_reset_msg1')), 'url' => base_url() . 'authentication' ) );
		}else{
			echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_auth_reset_msg2'))) );
		}
		die();
	}
	public function signup(){
		redirect( 'authentication', 'refresh' );
		exit();
		$data = array( 'signup' => true );
		$this->load->view('common/header_auth');
		$this->load->view('login',$data);
		$this->load->view('common/footer_auth');
	}
	public function register(){
		if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])){
			$where = array( 'email' => html_escape($_POST['email'] ));
			$result = $this->Common_DML->get_data( 'users', $where, 'COUNT(*) As total' );
			if(!empty($result) && $result[0]['total'] == 0){
				$array = array(
					'name' => trim(html_escape($_POST['name'])),
					'email' => trim(html_escape($_POST['email'])),
					'password' => md5(html_escape($_POST['password'])),
					'status' => 1,
					'datetime' => date('Y-m-d H:i:s')
				);
				$insert_id = $this->Common_DML->put_data( 'users', $array );
				$folder = 'user_'.$insert_id;
				if (!is_dir('uploads/'.$folder)) {
					mkdir('./uploads/' . $folder, 0777, TRUE);
					mkdir('./uploads/' . $folder . '/campaigns', 0777, TRUE);
					mkdir('./uploads/' . $folder . '/images', 0777, TRUE);
					mkdir('./uploads/' . $folder . '/templates', 0777, TRUE);
				}
				$data = array(
					'user_id' => $insert_id,
					'email' => html_escape($_POST['email']),
					'member_login' => true,
					'access_level' => 1,
					'profile_pic' => '',
					'name' => html_escape($_POST['name'])
				);
				$this->session->set_userdata( $data );
				echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_auth_reset_msg3')), 'url' => base_url() . 'dashboard' ) );	
			}else{
				echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_auth_reset_msg4'))) );
			}
			die();	
		}
		echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_auth_reset_msg5'))) );
		die();		
	}
	public function activate( $userID, $user_id, $code ){
		if(empty($code)) redirect( 'dashboard', 'refresh' );
		$where = array( 'id' => $user_id, 'code' => $code );
		$result = $this->Common_DML->get_data( 'users', $where, 'COUNT(*) As total' );
		if(!empty($result) && $result[0]['total'] == 1){
			$what = array( 'status' => 1, 'code' => '' );
			$this->Common_DML->set_data( 'users', $what, $where );
			$where = array( 'parent_user_id' => $userID, 'sub_user_id' => $user_id, 'code' => $code );
			$what = array( 'status' => 1, 'code' => '' );
			$this->Common_DML->set_data( 'sub_users', $what, $where );
			redirect('authentication/login', 'refresh');
		}else{
			redirect('authentication/login', 'refresh');
		}
	}
 
	/**
     * Customer View Plan
     */  
    public function subscription_plan(){
		$data = array('subscription'=>true);
		$data['metaDescription'] = html_escape('Apppixaguru');
        $data['metaKeywords'] = html_escape('Apppixaguru');
        $data['title'] = html_escape("Apppixaguru");
        $data['breadcrumbs'] = array('apppixaguru' => '#'); 
		$currency_sym = array( 
			'AED' => 'د.إ',  
			'AFN' => '؋',  
			'ALL' => 'L',  
			'AMD' => 'AMD',  
			'ANG' => 'ƒ',  
			'AOA' => 'Kz',  
			'ARS' => '$',  
			'AUD' => '$',  
			'AWG' => 'ƒ',  
			'AZN' => 'AZN',  
			'BAM' => 'KM',  
			'BBD' => '$',  
			'BDT' => '৳ ',  
			'BGN' => 'лв.',  
			'BHD' => '.د.ب',  
			'BIF' => 'Fr',  
			'BMD' => '$',  
			'BND' => '$',  
			'BOB' => 'Bs.',  
			'BRL' => 'R$',  
			'BSD' => '$',  
			'BTC' => '฿',  
			'BTN' => 'Nu.',  
			'BWP' => 'P',  
			'BYR' => 'Br',  
			'BZD' => '$',  
			'CAD' => '$',  
			'CDF' => 'Fr',  
			'CHF' => 'CHF',  
			'CLP' => '$',  
			'CNY' => '¥',  
			'COP' => '$',  
			'CRC' => '₡',  
			'CUC' => '$',  
			'CUP' => '$',  
			'CVE' => '$',  
			'CZK' => 'Kč',  
			'DJF' => 'Fr',  
			'DKK' => 'DKK',  
			'DOP' => 'RD$',  
			'DZD' => 'د.ج',  
			'EGP' => 'EGP',  
			'ERN' => 'Nfk',  
			'ETB' => 'Br',  
			'EUR' => '€',  
			'FJD' => '$',  
			'FKP' => '£',  
			'GBP' => '£',  
			'GEL' => 'ლ',  
			'GGP' => '£',  
			'GHS' => '₵',  
			'GIP' => '£',  
			'GMD' => 'D',  
			'GNF' => 'Fr',  
			'GTQ' => 'Q',  
			'GYD' => '$',  
			'HKD' => '$',  
			'HNL' => 'L',  
			'HRK' => 'Kn',  
			'HTG' => 'G',  
			'HUF' => 'Ft',  
			'IDR' => 'Rp',  
			'ILS' => '₪',  
			'IMP' => '£',  
			'INR' => '₹',  
			'IQD' => 'ع.د',  
			'IRR' => '﷼',  
			'IRT' => 'تومان',  
			'ISK' => 'kr.',  
			'JEP' => '£',  
			'JMD' => '$',  
			'JOD' => 'د.ا',  
			'JPY' => '¥',  
			'KES' => 'KSh',  
			'KGS' => 'сом',  
			'KHR' => '៛',  
			'KMF' => 'Fr',  
			'KPW' => '₩',  
			'KRW' => '₩',  
			'KWD' => 'د.ك',  
			'KYD' => '$',  
			'KZT' => 'KZT',  
			'LAK' => '₭',  
			'LBP' => 'ل.ل',  
			'LKR' => 'රු',  
			'LRD' => '$',  
			'LSL' => 'L',  
			'LYD' => 'ل.د',  
			'MAD' => 'د.م.',  
			'MDL' => 'MDL',  
			'MGA' => 'Ar',  
			'MKD' => 'ден',  
			'MMK' => 'Ks',  
			'MNT' => '₮',  
			'MOP' => 'P',  
			'MRO' => 'UM',  
			'MUR' => '₨',  
			'MVR' => '.ރ',  
			'MWK' => 'MK',  
			'MXN' => '$',  
			'MYR' => 'RM',  
			'MZN' => 'MT',  
			'NAD' => '$',  
			'NGN' => '₦',  
			'NIO' => 'C$',  
			'NOK' => 'kr',  
			'NPR' => '₨',  
			'NZD' => '$',  
			'OMR' => 'ر.ع.',  
			'PAB' => 'B/.',  
			'PEN' => 'S/.',  
			'PGK' => 'K',  
			'PHP' => '₱',  
			'PKR' => '₨',  
			'PLN' => 'zł',  
			'PRB' => 'р.',  
			'PYG' => '₲',  
			'QAR' => 'ر.ق',  
			'RMB' => '¥',  
			'RON' => 'lei',  
			'RSD' => 'дин.',  
			'RUB' => '₽',  
			'RWF' => 'Fr',  
			'SAR' => 'ر.س',  
			'SBD' => '$',  
			'SCR' => '₨',  
			'SDG' => 'ج.س.',  
			'SEK' => 'kr',  
			'SGD' => '$',  
			'SHP' => '£',  
			'SLL' => 'Le',  
			'SOS' => 'Sh',  
			'SRD' => '$',  
			'SSP' => '£',  
			'STD' => 'Db',  
			'SYP' => 'ل.س',  
			'SZL' => 'L',  
			'THB' => '฿',  
			'TJS' => 'ЅМ',  
			'TMT' => 'm',  
			'TND' => 'د.ت',  
			'TOP' => 'T$',  
			'TRY' => '₺',  
			'TTD' => '$',  
			'TWD' => 'NT$',  
			'TZS' => 'Sh',  
			'UAH' => '₴',  
			'UGX' => 'UGX',  
			'USD' => '$',  
			'UYU' => '$',  
			'UZS' => 'UZS',  
			'VEF' => 'Bs F',  
			'VND' => '₫',  
			'VUV' => 'Vt',  
			'WST' => 'T',  
			'XAF' => 'Fr',  
			'XCD' => '$',  
			'XOF' => 'Fr',  
			'XPF' => 'Fr',  
			'YER' => '﷼',  
			'ZAR' => 'R',  
			'ZMW' => 'ZK',  
		   );
		$data['currency_sym'] = $currency_sym;
		$data['subscription_plans'] = $this->Common_DML->get_data_limit('plans', array(), '*', array(), 'pl_id', 'ASC' );
        $this->load->view('subscription_plan',$data);
	} 

	/**
	 * Verify Cupon Code
	 */
    public function verify_coupon_code(){
		$coupon_code = $this->input->post('coupon_code');
		$current_date = date("Y-m-d H:i:s");
        $where = array('coupon_code' => $coupon_code,'discount_expire_time >' =>$current_date); 
		$result = $this->Common_DML->get_data('coupon_code', $where);
		if($result){
		    echo json_encode(array('status' => 1, 'msg' =>html_escape($this->lang->line('ltr_auth_verify_coupon_code_msg1'))) );	
		}else{
			echo json_encode(array('status' => 0, 'msg' =>html_escape($this->lang->line('ltr_auth_verify_coupon_code_msg2'))) );
		}
    die();	
	}
    
	/**
	 * Create Subscription
	 */
	public function create_subscription(){
		$data['metaDescription'] = html_escape($this->lang->line('ltr_auth_create_subscription_metaDescription'));
        $data['metaKeywords'] = html_escape($this->lang->line('ltr_auth_create_subscription_metaKeywords'));
        $data['title'] = html_escape($this->lang->line('ltr_auth_create_subscription_title'));
        $data['breadcrumbs'] = array('apppixaguru' => '#');
        
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
		$token  = $this->input->post('stripeToken');
		$user_name  = $this->input->post('user_name');
		$user_password  = $this->input->post('user_password');
		$user_send_email  = $this->input->post('send_mail');
        $email  = $this->input->post('stripeEmail');
        $plan_name  = $this->input->post('plan');
		$plan_id  = base64_decode($this->input->post('plan_id')); 
        $interval  = $this->input->post('interval');
        $price  = $this->input->post('price');
        $currency  = $this->input->post('currency');
		$coupon_code = $this->input->post('coupon_code');
		if(!empty($coupon_code)):
			$where = array('coupon_code' => $coupon_code); 
			$result = $this->Common_DML->get_data('coupon_code', $where);
			print_r($result[0]['discount_set']);
			if($result[0]['discount_set'] == 'percentage'){
				$discount_amout = $result[0]['discount_per_price'];
				$dis_price = $price * ($discount_amout/100);
				if($price > $dis_price){
				  $price = $price - $dis_price;
				}
			}else{
				$discount_amout = $result[0]['discount_per_price'];
				if($price > $discount_amout){
				  $price = $price - $discount_amout;
				}
			}
		endif;
        $time = time();
        $plan = \Stripe\Plan::create(array( 
            "product" => [
                "name" => $plan_name,
                "type" => "service"
            ],
            "nickname" => $plan_name,
            "interval" => $interval,
            "interval_count" => "1",
            "currency" => $currency,
            "amount" => ($price*100) ,
        ));

        $customer = \Stripe\Customer::create([
            'email' => $email,
            'source'  => $token,
        ]);

        $subscription = \Stripe\Subscription::create(array(
            "customer" => $customer->id,
            "items" => array(
                array(
                    "plan" => $plan->id,
                  ),
            ),
        ));  
		if($subscription->id){
			$array = array(
				'name' => $user_name,
				'email' => $email,
				'password' => md5($user_password),
				'access_level' => '5',
				'status' => 1,
				'datetime' => date('Y-m-d H:i:s')
			);
            $where = array( 'email' => $email );
			$result = $this->Common_DML->get_data( 'users', $where, 'COUNT(*) As total' );
            $result_id = $this->Common_DML->get_data( 'users', $where);
			if(!empty($result) && $result[0]['total'] == 0){
				$insert_id = $this->Common_DML->put_data( 'users', $array );
				$folder = 'user_'.$insert_id;
				if (!is_dir('uploads/'.$folder)) {
					mkdir('./uploads/' . $folder, 0777, TRUE);
					mkdir('./uploads/' . $folder . '/campaigns', 0777, TRUE);
					mkdir('./uploads/' . $folder . '/images', 0777, TRUE);
					mkdir('./uploads/' . $folder . '/templates', 0777, TRUE);
				}
			}else{	
				$where = array('email' =>$email);
				$this->Common_DML->set_data( 'users', $array, $where );
				$insert_id = $result_id[0]['id'];
			} 

            if($insert_id){
                
				if($subscription){ 
					// Check whether the subscription activation is successful 
					//if($subscription->status == 'active'){ 
						// Subscription info 
						$subscrID = $subscription->id; 
						$custID = $subscription->customer; 
						$planID = $subscription->plan->id; 
						$planAmount = ($subscription->plan->amount/100); 
						$planCurrency = $subscription->plan->currency; 
						$planInterval = $subscription->plan->interval; 
						$planIntervalCount = $subscription->plan->interval_count; 
						$created = date("Y-m-d H:i:s", $subscription->created); 
						$current_period_start = date("Y-m-d H:i:s", $subscription->current_period_start); 
						$created = date("Y-m-d H:i:s"); 
						$current_period_start = date("Y-m-d H:i:s"); 
						$current_time = date("Y-m-d H:i:s",time());
						$future_timestamp = strtotime("+".$planIntervalCount); 
						$final_future = date("Y-m-d H:i:s",+$future_timestamp);
						$current_period_end = $final_future; 
						//$current_period_end = date("Y-m-d H:i:s", $subscription->current_period_end); 
						$status = $subscription->status; 
						 
						// Insert tansaction data into the database 
						$subscripData = array( 
							'user_id' => $insert_id, 
							'plan_id' => $plan_id, 
							'stripe_subscription_id' => $subscrID, 
							'stripe_customer_id' => $custID, 
							'stripe_plan_id' => $planID, 
							'plan_amount' => $planAmount, 
							'plan_amount_currency' => $planCurrency, 
							'plan_interval' => $planInterval, 
							'plan_interval_count' => $planIntervalCount, 
							'plan_period_start' => $current_period_start, 
							'plan_period_end' => $current_period_end, 
							'payer_email' => $email, 
							'created' => $created, 
							'status' => $status 
						   ); 
						$subscription_id = $this->Common_DML->put_data('user_subscriptions', $subscripData);
						// Update subscription id in the users table  
						if($subscription_id && !empty($insert_id)){ 
							$data = array('subscription_id' => $subscription_id); 
							$where = array('id' =>$insert_id);
							$this->Common_DML->set_data( 'users', $data, $where );
						} 
					//}
				} 
                    
				/**
				 * Send Email Data
				 */
                $subject = $user_name.' credentials info';
				$str = "Username : ".$email.", Password : ".$user_password;
				if($user_send_email){
					$link = base_url();
					$mail = array(
						"email" => $email,
						"name" => $user_name,
					);
					$template_name = 'media-access';
					$var = '[
						{
						"name": "USERNAME",
						"content": "'.$user_name.'"
						},
						{
						"name": "EMAIL",
						"content": "'.$email.'"
						},
						{
						"name": "PASSWORD",
						"content": "'.$user_password.'"
						}
					]';
					$mail_result = sendmailTemplate( $template_name, $mail, $var );		
				}
				json_encode( array( 'status' => 1, 'msg' => html_escape($this->lang->line('ltr_auth_create_subscription_msg1'))) );	
			    $data['price'] = $price;
			    $this->session->set_flashdata('price', $price);  
			    redirect('authentication/thankyou');
		     }
	    }
	}
    /**
	 * Free Create Subscription
	 */ 
	public function create_free_subscription(){
	    $data['metaDescription'] = html_escape($this->lang->line('ltr_auth_create_subscription_metaDescription'));
        $data['metaKeywords'] = html_escape($this->lang->line('ltr_auth_create_subscription_metaKeywords'));
        $data['title'] = html_escape($this->lang->line('ltr_auth_create_subscription_title'));
        $data['breadcrumbs'] = array('apppixaguru' => '#');
        $token  = $this->input->post('stripeToken');
		$user_name  = $this->input->post('user_name');
		$user_password  = $this->input->post('user_password');
		$user_send_email  = $this->input->post('user_send_mail');
        $email  = $this->input->post('stripeEmail');
        $plan_name  = $this->input->post('plan');
		$plan_id  = base64_decode($this->input->post('plan_id')); 
        $interval  = $this->input->post('interval');
        $price  = $this->input->post('price');
        $currency  = $this->input->post('currency');
		$coupon_code = $this->input->post('coupon_code');
		
        $array = array(
				'name' => $user_name,
				'email' => $user_send_email,
				'password' => md5($user_password),
				'access_level' => '5',
				'status' => 1,
				'datetime' => date('Y-m-d H:i:s')
			);
		$where = array( 'email' => $email );
		$result = $this->Common_DML->get_data( 'users', $where, 'COUNT(*) As total' );
        $result_id = $this->Common_DML->get_data( 'users', $where);
		if(!empty($result) && $result[0]['total'] == 0){
			$insert_id = $this->Common_DML->put_data( 'users', $array );
			$folder = 'user_'.$insert_id;
			if (!is_dir('uploads/'.$folder)) {
				mkdir('./uploads/' . $folder, 0777, TRUE);
				mkdir('./uploads/' . $folder . '/campaigns', 0777, TRUE);
				mkdir('./uploads/' . $folder . '/images', 0777, TRUE);
				mkdir('./uploads/' . $folder . '/templates', 0777, TRUE);
			}
		}else{	
			$where = array('email' =>$email);
			$this->Common_DML->set_data( 'users', $array, $where );
			$insert_id = $result_id[0]['id'];
		} 
		
		 if($insert_id){
		    // Subscription info 
			$subscrID = rand().'_free'; 
			$custID = $insert_id; 
			$planID = $this->input->post('plan_id'); 
			$planAmount = $price; 
			$planCurrency = $currency; 
			$planInterval = $interval; 
			$planIntervalCount = 1; 
			$created = date("Y-m-d H:i:s"); 
			$current_period_start = date("Y-m-d H:i:s"); 
			$current_time = date("Y-m-d H:i:s",time());
			$future_timestamp = strtotime("+1 month"); 
			$final_future = date("Y-m-d H:i:s",+$future_timestamp);
			$current_period_end = $final_future; 
			$status = 'active'; 
			// Insert tansaction data into the database 
			$subscripData = array( 
					'user_id' => $insert_id, 
					'plan_id' => $plan_id, 
					'stripe_subscription_id' => $subscrID, 
					'stripe_customer_id' => $custID, 
					'stripe_plan_id' => $planID, 
					'plan_amount' => $planAmount, 
					'plan_amount_currency' => $planCurrency, 
					'plan_interval' => $planInterval, 
					'plan_interval_count' => $planIntervalCount, 
					'plan_period_start' => $current_period_start, 
					'plan_period_end' => $current_period_end, 
					'payer_email' => $user_send_email, 
					'created' => $created, 
					'status' => $status 
			    	); 
			$subscription_id = $this->Common_DML->put_data('user_subscriptions', $subscripData);
			// Update subscription id in the users table  
			if($subscription_id && !empty($insert_id)){ 
				$data = array('subscription_id' => $subscription_id); 
				$where = array('id' =>$insert_id);
				$this->Common_DML->set_data( 'users', $data, $where );
			 }
		    /**
			 * Send Email Data
			 */
            $subject = $user_name.' credentials info';
			$str = "Username : ".$email.", Password : ".$user_password;
			if($user_send_email){
				$link = base_url();
				$mail = array(
					"email" => $email,
					"name" => $user_name,
				);
				$template_name = 'media-access';
				$var = '[
					{
					"name": "USERNAME",
					"content": "'.$user_name.'"
					},
					{
					"name": "EMAIL",
					"content": "'.$email.'"
					},
					{
					"name": "PASSWORD",
					"content": "'.$user_password.'"
					}
				]';
				$mail_result = sendmailTemplate( $template_name, $mail, $var );		
			}
			ob_start();
			echo json_encode( array( 'status' => 1, 'msg' => html_escape($this->lang->line('ltr_auth_create_subscription_msg1'))) );	
		    $data['price'] = $price;
		    $this->session->set_flashdata('price', $price);  
		    redirect('authentication/thankyou');
		 }
	    
	}
   /**
	 * Successfully pay
	 */
	public function thankyou() {
        $data['metaDescription'] = html_escape($this->lang->line('ltr_auth_create_subscription_metaDescription'));
        $data['metaKeywords'] = html_escape($this->lang->line('ltr_auth_create_subscription_metaKeywords'));
        $data['title'] = html_escape($this->lang->line('ltr_auth_create_subscription_title'));
        $data['breadcrumbs'] = array('apppixaguru' => '#');
        $data['price'] = $this->session->flashdata('price');
        $this->load->view('thankyou', $data);   
    }

}