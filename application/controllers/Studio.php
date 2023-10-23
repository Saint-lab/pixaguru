<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Images extends CI_Controller {

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

	public function index(){

		$this->size( '1200x628' );

	}

	public function size( $size = '1200x628' ){

		$access_level = $this->session->userdata( 'access_level' );

		$data = array();

		$userID = $this->g_userID;

		$adminUserID = $this->Common_DML->get_data( 'users', array('role'=>'admin'), 'id' );

		$pre_templates = $pre_templates_count = array();

		$templates = $this->Common_DML->get_data( 'user_templates', array( 'user_id'=>$userID, 'save_as_template'=>1, 'status'=>1 ) );

		if(!empty($adminUserID)){

			$pre_templates = $this->Common_DML->query( "SELECT * FROM `user_templates` WHERE `user_id` = ".$adminUserID[0]['id']." AND `campaign_id` = 1 AND `status` = 1 AND template_size = '".$size."' AND `template_id` NOT IN(1,2) ORDER BY `modifydate` DESC LIMIT 0,12" );

			$pre_templates_count = $this->Common_DML->query( "SELECT COUNT(*) as total FROM `user_templates` WHERE `user_id` = ".$adminUserID[0]['id']." AND `campaign_id` = 1 AND `status` = 1 AND template_size = '".$size."' AND `template_id` NOT IN(1,2) ORDER BY `modifydate` DESC" );

			$templates_count = $this->Common_DML->query( "SELECT COUNT(*) as total FROM `user_templates` WHERE `user_id` = ".$adminUserID[0]['id']." AND `campaign_id` = 1 AND `status` = 1 AND `template_id` NOT IN(1,2) ORDER BY `modifydate` DESC" );

			$template_size_count = $this->Common_DML->query('SELECT template_size, COUNT(*) as tot FROM `user_templates` WHERE `user_id` = '.$adminUserID[0]['id'].' AND `campaign_id` = 1 AND status = 1 AND `template_id` NOT IN(1,2) GROUP BY template_size');

		}

		$campaigns = $this->Common_DML->get_data( 'campaign', array( 'user_id' => $userID ) );

		$data['templates'] = array_merge($pre_templates, $templates);

		$data['campaigns'] = $campaigns;

		$data['size'] = $size;

		$data['template_size_count'] = $template_size_count;

		$data['sizetotal'] = !empty($pre_templates_count) ? $pre_templates_count[0]['total'] : 0;

		$data['total'] = 3137;

		$data['subcat'] = $this->Common_DML->get_data( 'sub_category', array( 'cat_id' => 1, 'sub_cat_id !=' => 8 ) );

		$header = array();

		$header['menu'] = 'images';

		$this->load->view('common/header',$header);

		// $this->load->view('prebuild_templates', $data);
		$this->load->view('home', $data);

		$this->load->view('common/footer');

	}



}





















}

