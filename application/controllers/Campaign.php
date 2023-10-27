<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Campaign extends CI_Controller {
	private $g_userID;
	function __construct() {
		parent::__construct();
		if( !$this->session->userdata( 'member_login' ) ){
			redirect( 'authentication', 'refresh' );
		}
		$this->g_userID = $this->session->userdata( 'user_id' );
	}
	public function index(){
		redirect( 'dashboard', 'refresh' );
	}
	public function i( $campaign_id = null, $template_id = null ){
		$bool = true;
		if(!empty($campaign_id) && !empty($template_id)){
			$userID = $this->g_userID;
			$templates = $this->Common_DML->get_data( 'user_templates', array( 'user_id'=>$userID, 'save_as_template'=>1, 'status'=>1 ) );
			$template_size = $this->Common_DML->get_data( 'user_templates', array( 'template_id'=>$template_id, 'status'=>1 ) );
			if(!empty($template_size)){
				$size = $template_size[0]['template_size'];
			}else{
				$size = '1200x628';
			}
			$access_level = $this->session->userdata( 'access_level' );
			$pre_templates = array();
			$adminUserID = $this->Common_DML->get_data( 'users', array('role'=>'admin'), 'id' );
			if(!empty($adminUserID)){
				if($size == '1200x628'){
					$blank_templates = $this->Common_DML->get_data( 'user_templates', array( 'template_id' => 1 ), '*' );
				}else{
					$blank_templates = $this->Common_DML->get_data( 'user_templates', array( 'template_id' => 2 ), '*' );
				}
				$pre_templates = $this->Common_DML->get_data_limit( 
					'user_templates', 
					 array( 'user_id' => $adminUserID[0]['id'], 'campaign_id' => 1, 'status' => 1, 'template_size' => $size, 'access_level <=' => $access_level ), 
					'template_id,thumb,template_name,template_size,status,datetime,user_id', 
					array(0,12),
					'modifydate',
					'DESC'
				);
				$pre_templates_count = $this->Common_DML->query( "SELECT COUNT(*) as total FROM `user_templates` WHERE `user_id` = ".$adminUserID[0]['id']." AND `campaign_id` = 1 AND `status` = 1 AND template_size = '".$size."' AND `template_id` NOT IN(1,2) AND access_level <= $access_level ORDER BY `modifydate` DESC" );
			}
			$data['templates'] = array_merge($blank_templates, $pre_templates, $templates);
			$data['use'] = true;
			$data['size'] = $size;
			$data['total'] = !empty($pre_templates_count) ? $pre_templates_count[0]['total'] : 0;
			$data['subcat'] = $this->Common_DML->get_data( 'sub_category', array( 'cat_id' => 1, 'sub_cat_id !=' => 8 ) );
			
			$session_data = array(
				'campaign_id' => $campaign_id,
				'template_id' => $template_id
			); 
			$this->session->set_userdata( $session_data );
			$this->load->view('common/header');
			$this->load->view('prebuild_templates', $data);
			$this->load->view('common/footer');
			$bool = false;
		}
		if(!empty($campaign_id) && $bool === true){
			$userID = $this->g_userID;
			$where = array( 'campaign_id' => $campaign_id, 'user_id' => $userID, 'status' => 1 );
			$campaign = $this->Common_DML->get_data( 'campaign', $where );
			if(!empty($campaign)){
				$templates = $this->Common_DML->get_data( 'user_templates', $where, '*', array( 'template_id'=>'DESC' ) );
				$data = array();
				$data['campaign'] = $campaign[0];
				$data['templates'] = $templates;
				$footer = array();
				$footer['isotope'] = true;	
				$this->load->view('common/header');
				$this->load->view('templates', $data);
				$this->load->view('common/footer',$footer);
			}else{
				redirect( 'dashboard', 'refresh' );
			}
		}
		if(empty($campaign_id)){
			redirect( 'dashboard', 'refresh' );
		}
	}
	public function o($campaign_id = '', $user_id = '', $template_id = ''){
		$userID = $this->g_userID;
		$where = array( 'parent_user_id' => $userID, 'sub_user_id' => $user_id, 'status' => 1 );
		$sub_users = $this->Common_DML->get_data( 'sub_users', $where );
		if(empty($sub_users)){
			redirect( 'dashboard', 'refresh' );
			exit();
		}
		$bool = true;
		if(!empty($campaign_id) && !empty($template_id)){
			$templates = $this->Common_DML->get_data( 'user_templates', array( 'user_id'=>$userID, 'save_as_template'=>1, 'status'=>1 ) );
			$template_size = $this->Common_DML->get_data( 'user_templates', array( 'template_id'=>$template_id, 'status'=>1 ) );
			if(!empty($template_size)){
				$size = $template_size[0]['template_size'];
			}else{
				$size = '1200x628';
			}
			$access_level = $this->session->userdata( 'access_level' );
			$pre_templates = array();
			$adminUserID = $this->Common_DML->get_data( 'users', array('role'=>'admin'), 'id' );
			if(!empty($adminUserID)){
				if($size == '1200x628'){
					$blank_templates = $this->Common_DML->get_data( 'user_templates', array( 'template_id' => 1 ), '*' );
				}else{
					$blank_templates = $this->Common_DML->get_data( 'user_templates', array( 'template_id' => 2 ), '*' );
				}
				$pre_templates = $this->Common_DML->get_data_limit( 
					'user_templates', 
					 array( 'user_id' => $adminUserID[0]['id'], 'campaign_id' => 1, 'status' => 1, 'template_size' => $size, 'access_level <=' => $access_level ), 
					'template_id,thumb,template_name,template_size,status,datetime,user_id', 
					array(0,12),
					'modifydate',
					'DESC'
				);
				$pre_templates_count = $this->Common_DML->query( "SELECT COUNT(*) as total FROM `user_templates` WHERE `user_id` = ".$adminUserID[0]['id']." AND `campaign_id` = 1 AND `status` = 1 AND template_size = '".$size."' AND `template_id` NOT IN(1,2) AND access_level <= $access_level ORDER BY `modifydate` DESC" );
			}
			$data['templates'] = array_merge($blank_templates, $pre_templates, $templates);
			$data['use'] = true;
			$data['size'] = $size;
			$data['total'] = !empty($pre_templates_count) ? $pre_templates_count[0]['total'] : 0;
			$data['subcat'] = $this->Common_DML->get_data( 'sub_category', array( 'cat_id' => 1, 'sub_cat_id !=' => 8 ) );
			$session_data = array(
				'campaign_id' => $campaign_id,
				'template_id' => $template_id,
				'sub_user_id' => $user_id 
			);
			$this->session->set_userdata( $session_data );
			$this->load->view('common/header');
			$this->load->view('prebuild_templates', $data);
			$this->load->view('common/footer');
			$bool = false;
		}
		if((!empty($campaign_id) || !empty($user_id)) && $bool === true){
			$where = array( 'campaign_id' => $campaign_id, 'user_id' => $user_id, 'status' => 1 );
			$campaign = $this->Common_DML->get_data( 'campaign', $where );
			if(!empty($campaign)){
				$templates = $this->Common_DML->get_data( 'user_templates', $where, '*', array( 'template_id'=>'DESC' ) );
				$data = array();
				$data['campaign'] = $campaign[0];
				$data['templates'] = $templates;			
				$data['sub_user'] = $user_id;			
				$footer = array();
				$footer['isotope'] = true;	
				$this->load->view('common/header');
				$this->load->view('templates', $data);
				$this->load->view('common/footer',$footer);
			}else{
				redirect( 'dashboard', 'refresh' );
				exit();
			}
		}
		if(empty($campaign_id) || empty($user_id)){
			redirect( 'dashboard', 'refresh' );
			exit();
		}
	}
	public function add_template(){
		if(isset($_POST['campaign_id']) && !empty($_POST['campaign_id'])){
			$campaign_id = html_escape($_POST['campaign_id']);
			$template_name = html_escape($_POST['template_name']);
			$template_size = html_escape($_POST['template_size']);
			$userID = $this->g_userID;
			$bool = false;
			if(isset($_POST['sub_user_id']) && !empty($_POST['sub_user_id'])){
				$sub_users = $this->Common_DML->get_data( 'sub_users', array('parent_user_id'=>$userID,'sub_user_id'=>html_escape($_POST['sub_user_id']),'status'=>1) );
				if(count($sub_users) == 1){
					$userID = html_escape($_POST['sub_user_id']);
					$bool = true;
				}
			}
			$date = date('Y-m-d H:i:s');
			$what = array(
				'user_id' => $userID,
				'template_name' => $template_name,
				'template_size' => $template_size,
				'campaign_id' => $campaign_id,
				'datetime' => $date,
				'modifydate' => $date,
				'status' => 1
			);
			$insert_id = $this->Common_DML->put_data( 'user_templates', $what );
			if($bool === false){
				$url = base_url() . 'campaign/i/'.$campaign_id.'/'.$insert_id;
			}else{
				$url = base_url() . 'campaign/o/'.$campaign_id.'/'.$userID.'/'.$insert_id;
			}
			echo json_encode( array( 'status' => 1, 'url' => $url  ) );
		}else{
			echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_campaign_add_template_msg1'))) );
		}
		die();
	}
	public function use_template( $userID = '', $get_template_id = '' ){
		if( $userID == '' || $get_template_id == '' ){
			redirect( 'dashboard', 'refresh' );
		}
		$bool = false;
		$campaign_id = $this->session->userdata( 'campaign_id' );
		$template_id = $this->session->userdata( 'template_id' );
		$sub_user_id = $this->session->userdata( 'sub_user_id' );
		$template_data = $this->Common_DML->get_data( 'user_templates', array( 'user_id' => $userID, 'template_id' => $get_template_id, 'status' => 1 ), 'template_data,gradient_background,cat_id,sub_cat_id', array() );
		if(!empty($template_data)){
			$what = $template_data[0];
			$where = array( 'campaign_id' => $campaign_id, 'template_id' => $template_id );
			$this->Common_DML->set_data('user_templates', $what, $where);
			if($sub_user_id != ''){
				$sub_users = $this->Common_DML->get_data( 'sub_users', array('parent_user_id'=>$this->g_userID,'sub_user_id'=>$sub_user_id,'status'=>1) );
				if(count($sub_users) == 1){
					$bool = true;
				}
			}
		}else{
			redirect( 'dashboard', 'refresh' );
		}
		$data = array(
			'campaign_id' => '',
			'template_id' => '',
			'sub_user_id' => ''
		);
		$this->session->set_userdata( $data );
		if($bool === true){
			redirect( 'editor/edit/'.$campaign_id.'/'.$template_id.'/'.$sub_user_id, 'refresh' );
			exit();
		}
		$admin = $this->Common_DML->get_data( 'users', array('role'=>'admin'), 'id' );
		$adminUserID = '';
		if(!empty($admin)){
			$adminUserID = $admin[0]['id'];
		}
		if($userID == $adminUserID || $userID == $this->g_userID){
			redirect( 'editor/edit/'.$campaign_id.'/'.$template_id, 'refresh' );
			exit();
		}else{
			redirect( 'dashboard', 'refresh' );
			exit();
		}
	}
	public function action(){
		if(!isset( $_POST['campaign_id'] )){ echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_campaign_action_msg1'))) ); die(); }
		$userID = $this->g_userID;
		if(isset($_POST['sub_user_id']) && !empty($_POST['sub_user_id'])){
			$sub_users = $this->Common_DML->get_data( 'sub_users', array('parent_user_id'=>$userID,'sub_user_id'=> html_escape($_POST['sub_user_id']),'status'=>1) );
			if(count($sub_users) == 1){
				$userID = html_escape($_POST['sub_user_id']);
			}
		}
		$where = array( 'campaign_id' => $_POST['campaign_id'], 'user_id' => $userID, 'status' => 1 );
		$campaign = $this->Common_DML->get_data( 'campaign', $where );
		if(empty($campaign)){ echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_campaign_action_msg2')) ) ); die(); }
		if(isset($_POST['action']) && $_POST['action'] == 'delete'){
			$templates = $this->Common_DML->get_data( 'user_templates', $where );
			for($i=0;$i<count($templates);$i++){
				$path = $templates[$i]['thumb'];
				if($templates[$i]['type'] != ""){
				if(!empty($path)) unlink($path);
			     }
				$where = array( 'template_id' => $templates[$i]['template_id'], 'user_id' => $userID );
				$this->Common_DML->delete_data( 'user_templates', $where );	
			}
			$where = array( 'campaign_id' => $_POST['campaign_id'], 'user_id' => $userID, 'status' => 1 );
			$this->Common_DML->delete_data( 'campaign', $where );	
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_campaign_action_msg3'))) );
		}
		if(isset($_POST['action']) && $_POST['action'] == 'rename'){
			$what = array( 'name' => html_escape($_POST['campaign_rename']), 'datetime' => date('Y-m-d H:i:s') );
			$this->Common_DML->set_data( 'campaign', $what, $where );
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_campaign_action_msg4'))) );
		}
		die();
	}
}