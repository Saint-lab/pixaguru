<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	private $g_userID;
	
	function __construct() {
		parent::__construct();

		$this->g_userID = $this->session->userdata( 'user_id' );

		if(!$this->session->userdata('member_login')){
			redirect('authentication', 'refresh');
        }else{
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
		
	}
	
	public function index(){
		$userID = $this->g_userID; 
		$data = array();
		// $sql = "SELECT * FROM (SELECT `campaign`.*, GROUP_CONCAT( `user_templates`.`thumb` ) templ_thumb FROM `campaign` LEFT JOIN `user_templates` ON `campaign`.`campaign_id`=`user_templates`.`campaign_id` WHERE `campaign`.`user_id` = '".$userID."' AND `campaign`.`status` = 1 GROUP BY `campaign`.`campaign_id` ORDER BY `campaign`.`campaign_id` DESC, `user_templates`.`modifydate` DESC ) rt GROUP BY rt.campaign_id ORDER BY campaign_id DESC";

		$sql = "SELECT *
			FROM (
				SELECT 
					c.*,
					GROUP_CONCAT(ut.thumb) AS templ_thumb,
					MAX(ut.modifydate) AS max_modifydate  -- Get the maximum modifydate within each group
				FROM campaign c
				LEFT JOIN user_templates ut ON c.campaign_id = ut.campaign_id
				WHERE c.user_id = '".$userID."' AND c.status = 1
				GROUP BY c.campaign_id
			) rt
			ORDER BY rt.max_modifydate DESC, rt.campaign_id DESC";
 
		$campaign = $this->Common_DML->query( $sql );
		$where = array( 'parent_user_id' => $userID, 'su.status' => 1, 'u.status' => 1 );
		$sub_users = $this->Common_DML->get_join_data( 'sub_users su', 'users u', 'su.sub_user_id=u.id', $where, '*', array('su.datetime'=>'DESC', 'LEFT') );
		$sub_user_campaign = array();
		if(!empty($sub_users)){
			$i=0;
			foreach($sub_users as $id){
				$sub_user_campaign[$i]['id'] = $id['sub_user_id'];
				$sub_user_campaign[$i]['name'] = $id['name'];
				$sql = "SELECT * FROM (SELECT `campaign`.*, GROUP_CONCAT( `user_templates`.`thumb` ) templ_thumb FROM `campaign` LEFT JOIN `user_templates` ON `campaign`.`campaign_id`=`user_templates`.`campaign_id` WHERE `campaign`.`user_id` = '".$id['sub_user_id']."' AND `campaign`.`status` = 1 GROUP BY `campaign`.`campaign_id` ORDER BY `campaign`.`campaign_id` DESC, `user_templates`.`modifydate` DESC ) rt GROUP BY rt.campaign_id ORDER BY campaign_id DESC";
				$sub_user_campaign[$i]['campaign'] = $this->Common_DML->query( $sql );
				$i++;
			}
		}
		
		$data['campaign'] = $campaign;
		$data['user_id'] = $userID;
		$data['sub_user_campaign'] = $sub_user_campaign;
		$header = array();
		$header['menu'] = 'dashboard';
		$this->load->view('common/header',$header);
		$this->load->view('dashboard', $data);
		$this->load->view('common/footer');
	}
	
	public function logout(){
		$array_items = array( 'user_id', 'email', 'member_login' );
		$this->session->unset_userdata( $array_items );
		redirect( 'authentication', 'refresh' );
	}
	
	public function create_campaign(){
		if(isset($_POST['campaign_name']) && !empty($_POST['campaign_name'])){
			$userID = $this->g_userID;
			$campaign_name = $_POST['campaign_name'];
			$campaign = $this->Common_DML->get_data( 'campaign', array( 'user_id'=>$userID, 'name'=>$campaign_name, 'status'=>1 ) );
			if(!count($campaign)){
				$what = array( 
					'name' => trim($campaign_name),
					'user_id' => $userID,
					'datetime' => date('Y-m-d H:i:s'),
					'status' => 1
				);
				$insert_id = $this->Common_DML->put_data( 'campaign', $what );
				$what['insert_id'] = $insert_id;
				$url = base_url(). 'dashboard/layout/'.$insert_id;
				echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_dashboard_create_campaign_msg1')), 'data' => $what  ) );
			}else{
				echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_dashboard_create_campaign_msg2'))) );
			}
		}else{
			echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_dashboard_create_campaign_msg3'))) );
		}
		die();
	}
	
	public function api(){
		$userID = $this->g_userID;
		$api = $this->Common_DML->get_data( 'api', array( 'user_id'=>$userID ) );
		$header['menu'] = 'api';
		$data['api'] = $api;
		$this->load->view('common/header',$header);
		$this->load->view('api', $data);
		$this->load->view('common/footer');
	}
	
	public function api_generate(){
		$userID = $this->g_userID;
		
		$getapi = $this->Common_DML->get_data( 'api', array( 'user_id'=>$userID ), '*' );
		if(count($getapi) < 5){
			$api = random_generator(0, 32);
			$api .= '-'.base64_encode($userID);
			$what = array(
				'user_id' => $userID,
				'api' => $api,
				'status' => 0
			);
			$insert_id = $this->Common_DML->put_data( 'api', $what );
		}
		redirect('dashboard/api');
	}
	
	/**
	 * Subsciption Plan
	 */
	 public function subscription_plan(){
		$userID = $this->g_userID;
		$header = array();
		$data = array('subscription_plan'=>array());
		$header['menu'] = 'subscription_plan'; 
        $recordsTotal = $this->Common_DML->get_data('user_subscriptions', array('user_id'=>$userID), 'COUNT(usp_id) as total' );
        $data['recordsTotal'] = isset($recordsTotal[0]['total']) ? $recordsTotal[0]['total'] : 0;
		$this->load->view('common/header',$header);
		$this->load->view('subscription_user', $data);
		$this->load->view('common/footer');
	} 
   
	/**
     * Subscription View Data
     */
    public function subscription_view(){   
		$userID = $this->g_userID;
        $page = isset($_REQUEST['start']) ? $_REQUEST['start'] : $page;
		$length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;
		if(isset($_REQUEST['search']) && $_REQUEST['search']['value']){
			$text = $_REQUEST['search']['value'];
			$where = "plan_amount LIKE '%".$text."%' OR payer_email LIKE '%".$text."%'";
			$users = $this->Common_DML->get_data_limit('user_subscriptions', $where, '*', array($page,$length), 'usp_id', 'DESC' );
			$recordsTotal = $this->Common_DML->get_data('user_subscriptions', array('user_id'=>$userID), 'COUNT(usp_id) as total' );
		}else{
			$users = $this->Common_DML->get_data_limit('user_subscriptions', array('user_id'=>$userID), '*', array($page,$length), 'usp_id', 'DESC' );
			$recordsTotal = $this->Common_DML->get_data('user_subscriptions', array('user_id'=>$userID), 'COUNT(usp_id) as total' );
		}   
		$u = array();
		$i = 0;
		foreach($users as $user){
            $u[] = array(
				++$i,
				$user['plan_id'],
				$user['payer_email'],
				$user['payment_method'],
				$user['plan_amount_currency'],
				$user['plan_amount'],
				$user['stripe_subscription_id'],
				$user['plan_interval'],
				$user['plan_period_start'],
				$user['plan_period_end']
			);
		}  
		$res = array(
			"draw" => $_REQUEST['draw'],
			"recordsTotal" =>  isset($recordsTotal[0]['total']) ? $recordsTotal[0]['total'] : 0,
			"recordsFiltered" => isset($recordsTotal[0]['total']) ? $recordsTotal[0]['total'] : 0,
			"data" => $u
		);
		echo json_encode($res);                    
    } 

       public function getSwift()
  {
   		$header['menu'] = 'swift';
        $this->load->view('common/header',$header);
		$this->load->view('otos/swift');
		$this->load->view('common/footer');
  }

  public function getLimitless()
  {
   		$header['menu'] = 'limitless';
       $this->load->view('common/header',$header);
		$this->load->view('otos/limitless');
		$this->load->view('common/footer');
  }

  public function getFranchise()
  {
   		$header['menu'] = 'franchise';
        $this->load->view('common/header',$header);
		$this->load->view('otos/franchise');
		$this->load->view('common/footer');
  }

  public function getIncome()
  {
   		$header['menu'] = 'income';
        $this->load->view('common/header',$header);
		$this->load->view('otos/income');
		$this->load->view('common/footer');
  }

  public function getAgency()
  {
  	    $header['menu'] = 'agency';
  	    $data['users'] = $this->Common_DML->get_data( 'users', array('reseller_id'=> $this->g_userID) );
  	    
        $this->load->view('common/header',$header);
		$this->load->view('otos/agency',$data);
		$this->load->view('common/footer');
  }

public function postAgency()
{

		$user_name  = $this->input->post('user_name');
		$user_password  = $this->input->post('user_password');
		$user_send_email  = $this->input->post('user_send_mail');
        
		
		
        $array = array(
				'name' => $user_name,
				'email' => $user_send_email,
				'password' => md5($user_password),
				'access_level' => '5',
				'status' => 1,
				'datetime' => date('Y-m-d H:i:s'),
				'reseller_id' => $this->g_userID, 
			);
		$where = array( 'email' => $user_send_email );
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
			$planID = "Ng=="; 
			$planAmount = 0.00; 
			$planCurrency = "USD"; 
			$planInterval = "year"; 
			$planIntervalCount = 1; 
			$created = date("Y-m-d H:i:s"); 
			$current_period_start = date("Y-m-d H:i:s"); 
			$current_time = date("Y-m-d H:i:s",time());
			$future_timestamp = strtotime("+1 year"); 
			$final_future = date("Y-m-d H:i:s",+$future_timestamp);
			$current_period_end = $final_future; 
			$status = 'active'; 
			// Insert tansaction data into the database 
			$subscripData = array( 
					'user_id' => $insert_id, 
					'plan_id' => 6, 
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

		} 

	redirect( 'dashboard/getAgency', 'refresh' );	

}

public function deleteAgency($id)
{
	$image = $this->Common_DML->get_data_row( 'users', array( 'id' => $id) );
	$folder = './uploads/user_'.$id;
	if($image){
	$this->deleteDir($folder);
	$query = ['id' => $id];
   $this->Common_DML->delete_data('users', $query);
   $data = ['user_id' => $id];
   $this->Common_DML->delete_data('user_subscriptions', $data);
    $result = array('status' => 'ok');
    echo json_encode($result);
	}
		
}


public static function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}


}
