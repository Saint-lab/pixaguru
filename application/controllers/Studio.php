<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Studio extends CI_Controller {

	private $g_userID;

	function __construct() {

		parent::__construct();  
        $this->g_userID = $this->session->userdata( 'user_id' );
		if( !$this->session->userdata('member_login')){
             redirect( 'authentication', 'refresh' );
        }else{
            if($this->session->userdata( 'member_login' )){
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

		
	}


	public function mockup($campaign_id = '', $template_id = '', $sub_user_id = '')	{

		if($template_id !='' && $campaign_id != ''){
			$data = array();
			$userID = $this->g_userID;
			$data['images'] = $this->Common_DML->get_data_limit( 'user_image', array( 'user_id' => $userID ), '*', array(0,21), 'id','DESC' );
			
			if(isset($sub_user_id) && !empty($sub_user_id)){
				$sub_users = $this->Common_DML->get_data( 'sub_users', array('parent_user_id'=>$userID,'sub_user_id'=>$sub_user_id,'status'=>1) );
				if(count($sub_users) == 1){
					$userID = $sub_user_id;
				}
			}
			
			$data['userID'] = $userID;
			$data['template'] = $this->Common_DML->get_data( 'user_templates', array( 'user_id' => $userID, 'campaign_id' => $campaign_id, 'template_id' => $template_id, 'status' => 1 ), '*', array() );
			$data['theme_setting'] = $this->Common_DML->get_data( 'theme_setting', '', '*', array() );
			
			$data['template_id'] = $template_id;
			$data['campaign_id'] = $campaign_id;
			$data['suggestion_category'] = $this->Common_DML->get_data( 'suggestion_category' );
		
			if(empty($data['template'])) redirect( 'dashboard', 'refresh' );
			//$this->load->view( 'editor', $data );
		}
		
		$this->load->view('studios/header');
		$this->load->view('studios/mockup', $data);
		$this->load->view('common/footer');	
	}


	public function boxshot($campaign_id = '', $template_id = '', $sub_user_id = '')	{

		if($template_id !='' && $campaign_id != ''){
			$data = array();
			$userID = $this->g_userID;
			$data['images'] = $this->Common_DML->get_data_limit( 'user_image', array( 'user_id' => $userID ), '*', array(0,21), 'id','DESC' );
			
			if(isset($sub_user_id) && !empty($sub_user_id)){
				$sub_users = $this->Common_DML->get_data( 'sub_users', array('parent_user_id'=>$userID,'sub_user_id'=>$sub_user_id,'status'=>1) );
				if(count($sub_users) == 1){
					$userID = $sub_user_id;
				}
			}
			
			$data['userID'] = $userID;
			$data['template'] = $this->Common_DML->get_data( 'user_templates', array( 'user_id' => $userID, 'campaign_id' => $campaign_id, 'template_id' => $template_id, 'status' => 1 ), '*', array() );
			$data['theme_setting'] = $this->Common_DML->get_data( 'theme_setting', '', '*', array() );
			
			$data['template_id'] = $template_id;
			$data['campaign_id'] = $campaign_id;
			$data['suggestion_category'] = $this->Common_DML->get_data( 'suggestion_category' );
		
			if(empty($data['template'])) redirect( 'dashboard', 'refresh' );
			//$this->load->view( 'editor', $data );
		}
		
		$this->load->view('studios/header');
		$this->load->view('studios/boxshot', $data);
		$this->load->view('common/footer');	
	}

}














