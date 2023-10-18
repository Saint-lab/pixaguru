<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Subscription extends CI_Controller { 

    private $g_userID;
	function __construct() {
		parent::__construct();
		if( !$this->session->userdata( 'admin_member_login' ) ){
			redirect( 'authentication', 'refresh' );
		}
        $this->g_userID = $this->session->userdata('user_id');
	}
    /**
     * Plan Mange
     */
    public function index(){ 
        $header = array();
		$data = array('subscription'=>array());
        $header['subscription'] = 'active'; 
		$recordsTotal = $this->Common_DML->get_data('plans', array(), 'COUNT(pl_id) as total' );
        $data['recordsTotal'] = isset($recordsTotal[0]['total']) ? $recordsTotal[0]['total'] : 0;
		$this->load->view('admin/common/header', $header);
		$this->load->view('admin/subscription_plan', $data);
		$this->load->view('admin/common/footer'); 
    }  
	public function subscription_list(){

		$header = array();
		$data = array('subscription_list'=>array());
        $header['subscription_list'] = 'active'; 
		$recordsTotal = $this->Common_DML->get_data('user_subscriptions', array(), 'COUNT(usp_id) as total' );
        $data['recordsTotal'] = isset($recordsTotal[0]['total']) ? $recordsTotal[0]['total'] : 0;
		$this->load->view('admin/common/header', $header);
		$this->load->view('admin/subscription_list', $data);
		$this->load->view('admin/common/footer'); 
	} 
    /**
	 * Create Plan
	 */
	public function create_subscription_plan(){
        if(!empty($_POST['plan_name']) && !empty($_POST['currency_set'])){
			$user_id = $this->g_userID;
            $array = array(
				'pl_name' => trim(html_escape($_POST['plan_name'])),
				'pl_price' => trim(html_escape($_POST['plan_price'])),
				'pl_currency' => trim(html_escape($_POST['currency_set'])),
				'interval' => trim(html_escape($_POST['interval_set'])),
				'plan_description' => html_escape($_POST['plane_description']),
				'create_datetime' => date('Y-m-d H:i:s'),
				'update_datetime' => date('Y-m-d H:i:s'),
				'user_id' => $user_id
			   );  
			$insert_id = $this->Common_DML->put_data('plans', $array);
            echo json_encode( array('status' => 1, 'msg' =>html_escape($this->lang->line('ltr_subscription_msg1')), 'url' => base_url() .'admin/subscription'));	
		}else{
	        echo json_encode( array('status' => 0, 'msg' =>html_escape($this->lang->line('ltr_subscription_msg2'))));
        }
     die();
	}
    /**
     * Plan View Data
     */
    public function view(){   
        $page = isset($_REQUEST['start']) ? html_escape($_REQUEST['start']) : $page;
		$length = isset($_REQUEST['length']) ? html_escape($_REQUEST['length']) : 10;
		if(isset($_REQUEST['search']) && $_REQUEST['search']['value']){
			$text = html_escape($_REQUEST['search']['value']);
			$where = "pl_name LIKE '%".$text."%' OR pl_price LIKE '%".$text."%'";
			$users = $this->Common_DML->get_data_limit('plans', $where, '*', array($page,$length), 'pl_id', 'DESC' );
			$recordsTotal = $this->Common_DML->get_data('plans', array(), 'COUNT(pl_id) as total' );
		}else{
			$users = $this->Common_DML->get_data_limit('plans', array(), '*', array($page,$length), 'pl_id', 'DESC' );
			$recordsTotal = $this->Common_DML->get_data('plans', array(), 'COUNT(pl_id) as total' );
		}  
		$u = array();
		$i = 0;
		foreach($users as $user){
            $u[] = array(
				++$i,
				$user['pl_name'],
				$user['pl_price'],
				$user['pl_currency'],
				$user['interval'].' days',
				'<div class="pg-btn-group">
					<a href="'.base_url().'subscription/get_popup/user/'.$user['pl_id'].'" class="pg-btn pg-edit-user-link"><span class="pg-edit-icon"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 477.873 477.873"><g><path d="M392.533 238.937c-9.426 0-17.067 7.641-17.067 17.067V426.67c0 9.426-7.641 17.067-17.067 17.067H51.2c-9.426 0-17.067-7.641-17.067-17.067V85.337c0-9.426 7.641-17.067 17.067-17.067H256c9.426 0 17.067-7.641 17.067-17.067S265.426 34.137 256 34.137H51.2C22.923 34.137 0 57.06 0 85.337V426.67c0 28.277 22.923 51.2 51.2 51.2h307.2c28.277 0 51.2-22.923 51.2-51.2V256.003c0-9.425-7.641-17.066-17.067-17.066z" /><path d="M458.742 19.142A65.328 65.328 0 0 0 412.536.004a64.85 64.85 0 0 0-46.199 19.149L141.534 243.937a17.254 17.254 0 0 0-4.113 6.673l-34.133 102.4c-2.979 8.943 1.856 18.607 10.799 21.585 1.735.578 3.552.873 5.38.875a17.336 17.336 0 0 0 5.393-.87l102.4-34.133c2.515-.84 4.8-2.254 6.673-4.13l224.802-224.802c25.515-25.512 25.518-66.878.007-92.393zm-24.139 68.277L212.736 309.286l-66.287 22.135 22.067-66.202L390.468 43.353c12.202-12.178 31.967-12.158 44.145.044a31.215 31.215 0 0 1 9.12 21.955 31.043 31.043 0 0 1-9.13 22.067z" /></g></svg></span></a>
					<a href="#" data-plan_id="'.$user['pl_id'].'" class="pg-btn pg-delete-plan-id">
						<span class="pg-delete-icon">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 512 512"><g><path d="M436 60h-75V45c0-24.813-20.187-45-45-45H196c-24.813 0-45 20.187-45 45v15H76c-24.813 0-45 20.187-45 45 0 19.928 13.025 36.861 31.005 42.761L88.76 470.736C90.687 493.875 110.385 512 133.604 512h244.792c23.22 0 42.918-18.125 44.846-41.271l26.753-322.969C467.975 141.861 481 124.928 481 105c0-24.813-20.187-45-45-45zM181 45c0-8.271 6.729-15 15-15h120c8.271 0 15 6.729 15 15v15H181V45zm212.344 423.246c-.643 7.712-7.208 13.754-14.948 13.754H133.604c-7.739 0-14.305-6.042-14.946-13.747L92.294 150h327.412l-26.362 318.246zM436 120H76c-8.271 0-15-6.729-15-15s6.729-15 15-15h360c8.271 0 15 6.729 15 15s-6.729 15-15 15z" /><path d="m195.971 436.071-15-242c-.513-8.269-7.67-14.558-15.899-14.043-8.269.513-14.556 7.631-14.044 15.899l15 242.001c.493 7.953 7.097 14.072 14.957 14.072 8.687 0 15.519-7.316 14.986-15.929zM256 180c-8.284 0-15 6.716-15 15v242c0 8.284 6.716 15 15 15s15-6.716 15-15V195c0-8.284-6.716-15-15-15zM346.927 180.029c-8.25-.513-15.387 5.774-15.899 14.043l-15 242c-.511 8.268 5.776 15.386 14.044 15.899 8.273.512 15.387-5.778 15.899-14.043l15-242c.512-8.269-5.775-15.387-14.044-15.899z"/></g></svg>
						</span>
					</a>
				</div>'
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
	/**
     * Subscription View Data
     */
    public function subscription_view(){   
        $page = isset($_REQUEST['start']) ? html_escape($_REQUEST['start']) : $page;
		$length = isset($_REQUEST['length']) ? html_escape($_REQUEST['length']) : 10;
		if(isset($_REQUEST['search']) && $_REQUEST['search']['value']){
			$text = html_escape($_REQUEST['search']['value']);
			$where = "plan_amount LIKE '%".$text."%' OR payer_email LIKE '%".$text."%'";
			$users = $this->Common_DML->get_data_limit('user_subscriptions', $where, '*', array($page,$length), 'usp_id', 'DESC' );
			$recordsTotal = $this->Common_DML->get_data('user_subscriptions', array(), 'COUNT(usp_id) as total' );
		}else{
			$users = $this->Common_DML->get_data_limit('user_subscriptions', array(), '*', array($page,$length), 'usp_id', 'DESC' );
			$recordsTotal = $this->Common_DML->get_data('user_subscriptions', array(), 'COUNT(usp_id) as total' );
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
			"draw" => html_escape($_REQUEST['draw']),
			"recordsTotal" =>  isset($recordsTotal[0]['total']) ? $recordsTotal[0]['total'] : 0,
			"recordsFiltered" => isset($recordsTotal[0]['total']) ? $recordsTotal[0]['total'] : 0,
			"data" => $u
		);
		echo json_encode($res);                    
    } 
    /**
     * Plan Edite 
     */
    public function get_popup($form = 'user', $id = ''){
        $data = array();
		$where = array('pl_id' => $id );
		$data['subscription_plans'] = $this->Common_DML->get_data('plans', $where);
		$this->load->view('admin/plan_popup', $data);
    } 
    /**
     * Plan Destroy
     */
    public function destroy_plan(){
        if(isset($_POST['action']) && $_POST['action'] == 'delete'){
			if(!empty($_POST['plan_id'])){
				$where = array('pl_id' => html_escape($_POST['plan_id']) );
				$this->Common_DML->delete_data('plans', $where);
                echo json_encode(array('status' => 1, 'msg' =>html_escape($this->lang->line('ltr_subscription_msg3'))));	
			}else{
				echo json_encode(array('status' => 0, 'msg' =>html_escape($this->lang->line('ltr_subscription_msg4'))));
			}
		}
    }
    /**
     * Plan Update
     */
    public function update_plan(){
        if(isset($_POST['action']) && $_POST['action'] == 'update'){
			$where = array('pl_id' => html_escape($_POST['plan_id']));
			$result = $this->Common_DML->get_data('plans', $where, '*' );
			if(!empty($result) && count($result) == 1){
				$user_id = $this->g_userID;
                $array = array(
					'pl_name' => trim(html_escape($_POST['plan_name'])),
					'pl_price' => trim(html_escape($_POST['plan_price'])),
					'pl_currency' => trim(html_escape($_POST['currency_set'])),
					'interval' => trim(html_escape($_POST['interval_set'])),
					'plan_description' => html_escape($_POST['plane_description']),
					'update_datetime' => date('Y-m-d H:i:s'),
					'user_id' => $user_id
				   );  
				$where = array('pl_id' => html_escape($_POST['plan_id'])); 
				$update_data = $this->Common_DML->set_data('plans', $array, $where );
                if($update_data){
				   echo json_encode(array('status' => 1, 'msg' =>html_escape($this->lang->line('ltr_subscription_msg5'))));	
                }else{
                   echo json_encode(array('status' => 1, 'msg' =>html_escape($this->lang->line('ltr_subscription_msg6'))));	
                } 
			}else{
				  echo json_encode(array('status' => 0, 'msg' =>html_escape($this->lang->line('ltr_subscription_msg7'))) );
			}
		}
        
    }
} 