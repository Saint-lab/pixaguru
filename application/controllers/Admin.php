<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	private $g_userID;
	function __construct() {
		parent::__construct();
		if( !$this->session->userdata( 'admin_member_login' ) ){
			redirect( 'authentication', 'refresh' );
		}
		$this->g_userID = $this->session->userdata( 'user_id' );
	}
	/**
	 * Admin User View
	 */
	public function index(){
		$this->users();
	} 
	/** 
	 * Admin Template View
	 */
	public function templates( $size = '1200x628',$active_tem=1){
		$data = $header = array();
		$userID = $this->session->userdata( 'user_id' );
		$header['templates'] = html_escape('active');
		$data['category'] = $this->Common_DML->get_data('category');
		$data['templates'] = $this->Common_DML->get_data_limit( 
			'user_templates', 
			array( 'user_id' => $userID, 'template_size' => $size, 'status' => $active_tem), 
			'template_id,thumb,template_name,template_size,status,datetime', 
			array(0,24),
			'modifydate',
			'DESC'
		  );
		$data['active_templates'] = $this->Common_DML->get_data('user_templates', array('user_id'=>$userID,'template_size'=>$size, 'status'=>1), 'COUNT(*) as total');
		$data['inactive_templates'] = $this->Common_DML->get_data('user_templates', array('user_id'=>$userID,'template_size'=>$size, 'status'=>0), 'COUNT(*) as total' );
		$data['size'] = $size;
		$data['active_tem'] = $active_tem;
		$template_size_count = $this->Common_DML->query('SELECT template_size, COUNT(*) as tot FROM `user_templates` WHERE user_id = '.$userID.' && status = 1 GROUP BY template_size');
		$tot_A = $this->Common_DML->query('SELECT COUNT(*) as total FROM `user_templates` WHERE user_id = '.$userID.' && status = 1');
		$tot_I = $this->Common_DML->query('SELECT COUNT(*) as total FROM `user_templates` WHERE user_id = '.$userID.' && status = 0');
		$tot_T = $this->Common_DML->query('SELECT COUNT(*) as total FROM `user_templates` WHERE user_id = '.$userID);
		$data['template_size_count'] = $template_size_count;
		$data['tot_A'] = $tot_A;
		$data['tot_I'] = $tot_I;
		$data['tot_T'] = $tot_T;
		$this->load->view('admin/common/header', $header);
		$this->load->view('admin/templates',$data);
		$this->load->view('admin/common/footer');
    }
    /** 
	 * Admin Template Action
	 */
	public function template_action(){
		if(!isset( $_POST['template_id'] )){ echo json_encode( array( 'status' => 0, 'msg' => html_escape($this->lang->line('ltr_admin_templates_msg0')) ) ); die(); }
		$userID = $this->g_userID;		
		$where = array( 'template_id' => html_escape($_POST['template_id']), 'user_id' => $userID, 'status' => 1 );
		$template = $this->Common_DML->get_data( 'user_templates', $where );
		if(empty($template)){ echo json_encode( array( 'status' => 0, 'msg' => html_escape($this->lang->line('ltr_admin_templates_msg1')) ) ); die(); }
		if(isset($_POST['action']) && $_POST['action'] == 'copy'){
			unset($template[0]['template_id']);
			$template[0]['datetime'] = date('Y-m-d H:i:s');
			$file = './'.$template[0]['thumb'];
			$name = random_generator() . '.jpg';
			$newfile = './uploads/user_'.$userID.'/templates/'.$name;
			if (!copy($file, $newfile)) {
				echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_admin_templates_msg1'))) );
				die();
			}
			$template[0]['thumb'] = 'uploads/user_'.$userID.'/templates/'.$name;
			$what = $template[0];
			$insert_id = $this->Common_DML->put_data( 'user_templates', $what );
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_templates_msg3')), 'insert_id' => $insert_id, 'data' => $what ) );
		}
		if(isset($_POST['action']) && $_POST['action'] == 'delete'){
			$path = $template[0]['thumb'];
			if(!empty($path)) unlink($path);
			$this->Common_DML->delete_data( 'user_templates', $where );	
			echo json_encode( array( 'status' => 1, 'msg' => html_escape($this->lang->line('ltr_admin_templates_msg4')) ) );
		}
	}
	/**
	 * Admin Get Sub Category
	 */
	public function get_sub_category(){
		if(isset($_POST['cat_id'])){
			$where = array( 'cat_id' => html_escape($_POST['cat_id']) );
			$sub_category = $this->Common_DML->get_data( 'sub_category', $where, 'sub_cat_id,name' );
			echo json_encode( array( 'status' => 1, 'data' => $sub_category ) );
		}
	}
	/**
	 * Admin All User Data Views
	 */
    public function users(){
		$header = array();
		$data = array('users'=>array());
		$recordsTotal = $this->Common_DML->get_data( 'users', array( 'role' => 'user' ), 'COUNT(id) as total' );
		$header['users'] = html_escape('active');
		$data['recordsTotal'] = isset($recordsTotal[0]['total']) ? html_escape($recordsTotal[0]['total']) : 0;
		$this->load->view('admin/common/header', $header);
		$this->load->view('admin/users', $data);
		$this->load->view('admin/common/footer');
	}
    /**
	 * Admin All User Data Loads
	 */ 

	public function get_user($page = 0){
		$page = isset($_REQUEST['start']) ? html_escape($_REQUEST['start']) : html_escape($page);
		$length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;
		if(isset($_REQUEST['search']) && $_REQUEST['search']['value']){
			$text = html_escape($_REQUEST['search']['value']);  
			$where = "role = 'user' AND name LIKE '%".$text."%' OR email LIKE '%".$text."%'";
			$users = $this->Common_DML->get_data_limit( 'users', $where, '*', array($page,$length), 'id', 'DESC' );
			$recordsTotal = $this->Common_DML->get_data( 'users', array( 'role' => 'user' ), 'COUNT(id) as total' );
		}else{
			$users = $this->Common_DML->get_data_limit( 'users', array( 'role' => 'user' ), '*', array($page,$length), 'id', 'DESC' );
			$recordsTotal = $this->Common_DML->get_data( 'users', array( 'role' => 'user' ), 'COUNT(id) as total' );
		}
		$u = array();
		$i = 0;
		foreach($users as $user){
			if($users[$i]['access_level'] == 1){
				$agency = html_escape('Monthly');
			}
			if($users[$i]['access_level'] == 2){
				$agency = html_escape('Yearly');
			}
			if($users[$i]['access_level'] == 3){
				$agency = html_escape('OTO2');
			}
			if($users[$i]['access_level'] == 4){
				$agency = html_escape('OTO3');
			}
			if($users[$i]['access_level'] == 5){
				$agency = html_escape('OTO4');
			}
			$u[] = array(
				++$i,
				'<span class="pg-t-username">'.html_escape($user['name']).'</span>',
				'<span class="pg-t-mail">'.html_escape($user['email']).'</span>',
				'<span class="pg-t-access-level">'.html_escape($agency).'</span>',
				html_escape($user['status']) == 1 ? '<span class="pg-active-user">'.html_escape($this->lang->line('ltr_user_active_action')).'</span>' : '<span class="pg-inactive-user">'.html_escape($this->lang->line('ltr_user_deactivate_action')).'</span>',
				'<span class="pg-user-source">'.html_escape($user['source']).'</span>',
				'<div class="pg-btn-group">
					<a href="'.base_url().'admin/get_popup/user/'.html_escape($user['id']).'" class="pg-btn pg-edit-user-link"><span class="pg-edit-icon">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 477.873 477.873"><g><path d="M392.533 238.937c-9.426 0-17.067 7.641-17.067 17.067V426.67c0 9.426-7.641 17.067-17.067 17.067H51.2c-9.426 0-17.067-7.641-17.067-17.067V85.337c0-9.426 7.641-17.067 17.067-17.067H256c9.426 0 17.067-7.641 17.067-17.067S265.426 34.137 256 34.137H51.2C22.923 34.137 0 57.06 0 85.337V426.67c0 28.277 22.923 51.2 51.2 51.2h307.2c28.277 0 51.2-22.923 51.2-51.2V256.003c0-9.425-7.641-17.066-17.067-17.066z" /><path d="M458.742 19.142A65.328 65.328 0 0 0 412.536.004a64.85 64.85 0 0 0-46.199 19.149L141.534 243.937a17.254 17.254 0 0 0-4.113 6.673l-34.133 102.4c-2.979 8.943 1.856 18.607 10.799 21.585 1.735.578 3.552.873 5.38.875a17.336 17.336 0 0 0 5.393-.87l102.4-34.133c2.515-.84 4.8-2.254 6.673-4.13l224.802-224.802c25.515-25.512 25.518-66.878.007-92.393zm-24.139 68.277L212.736 309.286l-66.287 22.135 22.067-66.202L390.468 43.353c12.202-12.178 31.967-12.158 44.145.044a31.215 31.215 0 0 1 9.12 21.955 31.043 31.043 0 0 1-9.13 22.067z" /></g></svg>
				</span></a>
					<a href="#" data-user_id="'.html_escape($user['id']).'" class="pg-btn pg-delete-user"><span class="pg-delete-icon">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 512 512"><g><path d="M436 60h-75V45c0-24.813-20.187-45-45-45H196c-24.813 0-45 20.187-45 45v15H76c-24.813 0-45 20.187-45 45 0 19.928 13.025 36.861 31.005 42.761L88.76 470.736C90.687 493.875 110.385 512 133.604 512h244.792c23.22 0 42.918-18.125 44.846-41.271l26.753-322.969C467.975 141.861 481 124.928 481 105c0-24.813-20.187-45-45-45zM181 45c0-8.271 6.729-15 15-15h120c8.271 0 15 6.729 15 15v15H181V45zm212.344 423.246c-.643 7.712-7.208 13.754-14.948 13.754H133.604c-7.739 0-14.305-6.042-14.946-13.747L92.294 150h327.412l-26.362 318.246zM436 120H76c-8.271 0-15-6.729-15-15s6.729-15 15-15h360c8.271 0 15 6.729 15 15s-6.729 15-15 15z" /><path d="m195.971 436.071-15-242c-.513-8.269-7.67-14.558-15.899-14.043-8.269.513-14.556 7.631-14.044 15.899l15 242.001c.493 7.953 7.097 14.072 14.957 14.072 8.687 0 15.519-7.316 14.986-15.929zM256 180c-8.284 0-15 6.716-15 15v242c0 8.284 6.716 15 15 15s15-6.716 15-15V195c0-8.284-6.716-15-15-15zM346.927 180.029c-8.25-.513-15.387 5.774-15.899 14.043l-15 242c-.511 8.268 5.776 15.386 14.044 15.899 8.273.512 15.387-5.778 15.899-14.043l15-242c.512-8.269-5.775-15.387-14.044-15.899z"/></g></svg>
				</span></a>
				</div>' 
			);
		}
		$res = array(
			"draw" => html_escape($_REQUEST['draw']),
			"recordsTotal" =>  isset($recordsTotal[0]['total']) ? html_escape($recordsTotal[0]['total']) : 0,
			"recordsFiltered" => isset($recordsTotal[0]['total']) ? html_escape($recordsTotal[0]['total']) : 0,
			"data" => $u
		);
		echo json_encode($res);
	}
    /**
	 * Admin All User Popup Model
	 */
	public function get_popup( $form = 'user', $id = '' ){
		if($form == 'user' && $id != ''){
			$data = array();
			$where = array( 'id' => $id );
			$data['users'] = $this->Common_DML->get_data( 'users', $where );
			$this->load->view('admin/admin_popup', $data);
		}
		if($form == 'sub_cat' && $id != ''){
			$data = array();
			$where = array( 'sub_cat_id' => $id );
			$data['sub_category'] = $this->Common_DML->get_data( 'sub_category', $where );
			$this->load->view('admin/admin_popup', $data);
		}
		if($form == 'suggestion' && $id != ''){
			$data = array();
			$where = array( 'suggestion_id' => $id );
			$data['suggestion'] = $this->Common_DML->get_data( 'suggestion', $where );
			$data['ts_categories'] = $this->Common_DML->get_data( 'sub_category', array(), '*', array( 'cat_id' => 1, 'status' => 1 ) );
			$data['s_categories'] = $this->Common_DML->get_data( 'suggestion_category', array(), '*', array( 's_id' => 'DESC' ) );
			$this->load->view('admin/admin_popup', $data);
		}
		if($form == 'template' && $id != ''){
			$data = array();
			$where = array( 'template_id' => $id );
			$data['category'] = $this->Common_DML->get_data( 'category' );
			$data['template'] = $this->Common_DML->get_data( 'user_templates', $where, 'template_name,cat_id,sub_cat_id,template_id,template_size,access_level' );
			$data['t_sub_category'] = $this->Common_DML->get_data( 'sub_category', array( 'cat_id' => $data['template'][0]['cat_id'] ) );
			$this->load->view('admin/admin_popup', $data);
		}
		if($form == 'tduplicate' && $id != ''){
			$data = array();
			$data['duplicate'] = true;
			$data['template_id'] = $id;
			$this->load->view('admin/admin_popup', $data);
		}
	}
	/**
	 * Admin All User Action
	 */
	public function user_action(){
		if(isset($_POST['action']) && $_POST['action'] == 'create'){
			$where = array( 'email' => html_escape($_POST['email']) );
			$result = $this->Common_DML->get_data( 'users', $where, 'COUNT(*) As total' );
			if(!empty($result) && $result[0]['total'] == 0){
				$array = array(
					'name' => trim(html_escape($_POST['name'])),
					'email' => trim(html_escape($_POST['email'])),
					'password' => md5(html_escape($_POST['password'])),
					'access_level' => html_escape($_POST['access_level']),
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
				$subject = $_POST['name'].html_escape(' credentials info');
				$str = "Username : ".html_escape($_POST['email']).", Password : ".html_escape($_POST['password']);
				if($_POST['send_mail']){
					$link = base_url();
					$mail = array(
						"email" => html_escape($_POST['email']),
						"name" => html_escape($_POST['name']),
					);
					$template_name = html_escape('media-access');
					$var = '[
						{
						"name": "'.html_escape('USERNAME').'",
						"content": "'.html_escape($_POST['name']).'"
						},
						{
						"name": "'.html_escape('EMAIL').'",
						"content": "'.html_escape($_POST['email']).'"
						},
						{
						"name": "'.html_escape('PASSWORD').'",
						"content": "'.html_escape($_POST['password']).'"
						}
					]';
					$mail_result = sendmailTemplate( $template_name, $mail, $var );		
				}
				echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_user_action_msg1'))) );	
			}else{
				echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_admin_user_action_msg2'))) );
			}
		}
		if(isset($_POST['action']) && $_POST['action'] == 'update'){
			$where = array( 'email' => $_POST['email'] );
			$result = $this->Common_DML->get_data( 'users', $where, '*' );
			if(!empty($result) && count($result) == 1){
				$array = array(
					'name' => trim(html_escape($_POST['name'])),
					'email' => trim(html_escape($_POST['email'])),
					'access_level' => html_escape($_POST['access_level']),
					'status' => html_escape($_POST['status'])
				);
				if(!empty(trim($_POST['password']))){
					$array['password'] = md5(html_escape($_POST['password']));
				} 
				$where = array( 'id' => html_escape($_POST['user_id']) );
				$this->Common_DML->set_data( 'users', $array, $where );
				$subject = $_POST['name'].html_escape(' credentials info');
				$str = "Username : ".html_escape($_POST['email']).", Password : ".html_escape($_POST['password']);
				echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_user_action_msg3')) ) );	
			}else{
				echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_admin_user_action_msg2'))) );
			}
		}
		if(isset($_POST['action']) && $_POST['action'] == 'delete'){
			if(!empty($_POST['user_id'])){
				$where = array( 'id' => html_escape($_POST['user_id']));
				$this->Common_DML->delete_data( 'users', $where );
				$this->Common_DML->delete_data( 'user_image', array( 'user_id' => html_escape($_POST['user_id'] )) );
				$this->Common_DML->delete_data( 'user_templates', array( 'user_id' => html_escape($_POST['user_id'] )) );
				$this->Common_DML->delete_data( 'campaign', array( 'user_id' => html_escape($_POST['user_id'] )) );
				remove_directory( 'uploads/user_'.html_escape($_POST['user_id']));
				echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_user_action_msg3'))) );	
			}else{
				echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_admin_user_action_msg4')) ) );
			}
		}
	}
	
	/**
	 * Admin category Option
	 */
	public function category(){
		if(isset($_POST['action']) && $_POST['action'] == 'create'){
			$cat_name = $_POST['name'];
			$data = array( 
				'name' => $cat_name,
				'cat_id' => html_escape($_POST['cat_id']),
				'status' => 1,
				'datetime' => date('Y-m-d H:i:s')
			);
			$id = $this->Common_DML->put_data( 'sub_category', $data );
			if($id > 0){
				echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_category_msg1'))) );
			}else{
				echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_admin_category_msg2'))) );
			}
			die();
		} 
		if(isset($_POST['action']) && $_POST['action'] == 'update'){
			$cat_name = html_escape($_POST['name']);
			$data = array( 
				'name' => $cat_name,
				'datetime' => date('Y-m-d H:i:s')
			);
			$where = array( 'sub_cat_id' => $_POST['sub_cat_id'] );
			$id = $this->Common_DML->set_data( 'sub_category', $data, $where );
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_category_msg3'))) );
			die();
		}
		if(isset($_POST['action']) && $_POST['action'] == 'delete'){
			$where = array( 'sub_cat_id' => html_escape($_POST['sub_cat_id']) );
			$this->Common_DML->delete_data( 'sub_category', $where );
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_category_msg4'))) );
			die();
		}
		$data = $header = array();
	
		$categories = $this->Common_DML->get_join_data( 'sub_category sc', 'user_templates ut', 'ut.sub_cat_id = sc.sub_cat_id', array('user_id'=>$this->g_userID), 'sc.*, COUNT(ut.template_id) as tot', array( 'sub_cat_id' => 'DESC' ), 'LEFT', 'sc.sub_cat_id' );
		
		$categories =  $this->Common_DML->get_data('sub_category',$where = array(), $field = '*', array( 'sub_cat_id' => 'DESC' ));
		$data['categories'] = $categories;
		$header['category'] = html_escape('active');
		$this->load->view('admin/common/header', $header);
		$this->load->view('admin/category', $data);
		$this->load->view('admin/common/footer');
	}
	/**
	 * Admin Create Template
	 */
	public function create_template(){
		if(isset($_POST['template_id'])){
			$array = array(
				'template_name' => html_escape($_POST['template_name']),
				'cat_id' => html_escape($_POST['cat_id']),
				'template_size' => html_escape($_POST['template_size']),
				'sub_cat_id' => html_escape($_POST['sub_cat_id']),
			  );
			$this->Common_DML->set_data( 'user_templates', $array, array( 'template_id' => html_escape($_POST['template_id'])) );
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_create_template_msg1')), 'url' => base_url() . 'admin/templates' ) );
			die();
		}
		if(isset($_POST['template_name'])){
			$array = array(
				'template_name' => html_escape($_POST['template_name']),
				'campaign_id' => 1,
				'user_id' => html_escape($this->session->userdata( 'user_id' )),
				'cat_id' =>1,
				'template_size' => html_escape($_POST['template_size']),
				'sub_cat_id' => html_escape($_POST['sub_cat_id']),
				'datetime' => date('Y-m-d H:i:s'),
				'modifydate' => date('Y-m-d H:i:s'),
				'status' => 1,
				'template_custom_size' =>html_escape($_POST['custom_size'])
			  );
			$template_id = $this->Common_DML->put_data( 'user_templates', $array );
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_create_template_msg2')), 'url' => base_url() . 'editor/admin_edit/'.$template_id ) );
		}
		die();
	}
	/**
	 * Admin Template Status
	 */
	public function template_status_update(){
		if(isset($_POST['template_id'])){
			$array = array(
				'status' => html_escape($_POST['status'])
			);
			$this->Common_DML->set_data( 'user_templates', $array, array( 'template_id' => html_escape($_POST['template_id'] )) );
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_admin_template_status_update_msg1'))) );
			die();
		}
	} 
	/**
	 * Admin Load More Template
	 */
	public function get_more_template(){
	    if(isset($_POST['reach'])){
			$userID = $this->g_userID;
			$size = html_escape($_POST['size']);
			$active_inactive = html_escape($_POST['active_inactive']);
			$templates = $this->Common_DML->get_data_limit( 
				'user_templates', 
				array( 'user_id' => $userID, 'template_size' => $size, 'status' => $active_inactive), 
				'template_id,thumb,template_name,template_size,status,DATE_FORMAT(datetime, "%d/%m/%Y") as datetime', 
				array(html_escape($_POST['reach']), 24),
				'modifydate',
				'DESC'
			); 
			$count = $this->Common_DML->get_data_limit( 
				'user_templates', 
				array( 'user_id' => $userID, 'template_size' => $size , 'status' => $active_inactive), 
				'template_id', 
				array(html_escape($_POST['reach'])+24, 24),
				'modifydate',
				'DESC'
			   );
			$response = array(
				'status' => 1,
				'reach' => html_escape($_POST['reach']) + 24,
				'data' => $templates,
				'hide' => count($count) > 0 ? 0 : 1
			);
			echo json_encode( $response );
			die();
		}
	}
	/**
	 * Admin Download Template Option
	 */
	public function download_template($access_level = 1,$template_size = '1200x628'){
		 $r = $this->Common_DML->get_data( 'user_templates', array('access_level'=>$access_level,'user_id'=>20,'template_size'=>$template_size,'status'=>1), 'template_id,thumb' );
		 $this->load->library('zip');
		 for($i=0;$i<count($r);$i++){
			 if(!empty($r[$i]['thumb'])){
				$this->zip->read_file($r[$i]['thumb']);
			 }
		 }
		 $this->zip->download('files_backup.zip');
	}
	/**
	 * Admin Logout Option
	 */
	public function logout(){
		$array_items = array( 'admin_member_login', 'access_level', 'profile_pic','name','facebook_post','user_id', 'email','member_login' );
		$this->session->unset_userdata( $array_items );
		 redirect( 'authentication', 'refresh' );
	}  
	/**
	 * Admin Get Total Template
	 */
	public function get_total_temp(){
		$res = $this->Common_DML->query('SELECT template_size, COUNT(*) as tot FROM `user_templates` WHERE user_id = 20 && status = 1 GROUP BY template_size');
		$tot = $this->Common_DML->query('SELECT COUNT(*) as total FROM `user_templates` WHERE user_id = 20 && status = 1');
		print_r($tot);
		print_r($res);
	}
	/**
	 * Admin Copy All Size Template
	 */
	public function copy_all_size(){
		if(isset($_POST['template_id']) && !empty($_POST['template_id'])){
			$r = $this->Common_DML->get_data( 'user_templates', array('template_id'=> html_escape($_POST['template_id']),'user_id'=>20), '*' );
			unset( $r[0]['template_id'] );
			$array = $r[0]; 
			if(!empty($_POST['template_size'])){
				$array['template_name'] = html_escape($_POST['template_name']);
				for($i=0;$i<count($_POST['template_size']);$i++){
					$array['template_size'] = html_escape($_POST['template_size'][$i]);
					$array['thumb'] = '';
					$this->Common_DML->put_data('user_templates', $array );
				}
			}
			redirect( 'admin/templates', 'refresh' );	
		}	
	}

	/**
	 * Admin Profile Update
	 */
	public function admin_profile(){
        $data = array();
		$userID = $this->g_userID;
		$data['user'] = $this->Common_DML->get_data( 'users', array( 'id' => $userID, 'status' => 1 ) );
		if(count($data['user']) != 1) redirect( 'authentication', 'refresh' );
		if(isset($_GET['code']) && isset($_GET['state'])){
			$insert_id = $this->Common_DML->set_data( 'fb_details', $fb_data, array( 'user_id' => $this->g_userID ) );
			if($insert_id > 0){
				redirect( 'profile', 'refresh' );
			}
		}
		 
		$header = array();
		$header['menu'] = 'profile';
		$this->load->view('admin/common/header',$header);
		$this->load->view('profile', $data);
		$this->load->view('admin/common/footer');
    }
  public function theme_setting_option(){
        $data = $header = array();
		$userID = $this->session->userdata( 'user_id' );

        $where = array('user_id'=>$userID,'data_key' =>'pg_logo_image');
        $result_logo = $this->Common_DML->get_data( 'theme_setting', $where);
        $data['logo_images'] =$result_logo; 

        $where = array('user_id'=>$userID,'data_key' =>'pg_favicon_image');
        $result_favicon = $this->Common_DML->get_data( 'theme_setting', $where);
        $data['favicon_images'] =$result_favicon; 

        $where = array('user_id'=>$userID,'data_key' =>'pg_preloader_image');
        $result_preloader = $this->Common_DML->get_data( 'theme_setting', $where);
        $data['preloader_images'] =$result_preloader; 
        
        $header['theme_setting'] = html_escape('active');
        $this->load->view('admin/common/header', $header);
		$this->load->view('admin/theme_setting',$data);
		$this->load->view('admin/common/footer');
    }

    /**
     * Logo Images changes
     */
    public function logo_changes(){
        header('Content-Type: application/json');
        $config['upload_path']   = './uploads/logo'; 
        $config['allowed_types'] = 'gif|jpg|png'; 
        $config['max_size']      = 1024;
        $this->load->library('upload', $config);
		if(!$this->upload->do_upload('logo_images_file')) {
            $error = array(
                        'status' =>false,
                        'msg' => 'Something went wrong!',
                        'data_file'=>$this->upload->display_errors()
                        ); 
            echo json_encode($error);
        }else { 
             $data = $this->upload->data();
             $userID = $this->session->userdata( 'user_id' );
             $where = array('user_id'=>$userID,'data_key' =>'pg_logo_image');
			 $result = $this->Common_DML->get_data( 'theme_setting', $where, 'COUNT(*) As total' );
            if($result[0]['total'] > 0){
               $theme_data = array('data_value'=>$data['file_name']);
               $where = array('data_key'=>'pg_logo_image');     
               $update_logo =$this->Common_DML->set_data('theme_setting', $theme_data, $where);   
            }else{
                $theme_data = array(
                    'user_id' =>$userID,
                    'data_key'=>'pg_logo_image',
                    'data_value'=>$data['file_name']
                   );
                $this->Common_DML->put_data('theme_setting', $theme_data, $where);
            }
            $success = [
                    'status'=>true,
                    'msg' => 'Logo File upload',
                    'data_file'=>$data['file_name']
                    ];
            echo json_encode($success);
        }
    die();   
    }
    /**
     * Favicon change
     */
    public function favicon_changes(){
        header('Content-Type: application/json');
        $config['upload_path']   = './uploads/logo'; 
        $config['allowed_types'] = 'gif|jpg|png'; 
        $config['max_size']      = 1024;
        $this->load->library('upload', $config);
		if(!$this->upload->do_upload('favicon_images_file')) {
            $error = array(
                        'status' =>false,
                        'msg' => 'Something went wrong!',
                        'data_file'=>$this->upload->display_errors()
                        ); 
            echo json_encode($error);
        }else { 
             $data = $this->upload->data();
             $userID = $this->session->userdata( 'user_id' );
             $where = array('user_id'=>$userID,'data_key' =>'pg_favicon_image');
			 $result = $this->Common_DML->get_data( 'theme_setting', $where, 'COUNT(*) As total' );
            if($result[0]['total'] > 0){
               $theme_data = array('data_value'=>$data['file_name']);
               $where = array('data_key'=>'pg_favicon_image');     
               $update_logo =$this->Common_DML->set_data('theme_setting', $theme_data, $where);   
            }else{
                $theme_data = array(
                    'user_id' =>$userID,
                    'data_key'=>'pg_favicon_image',
                    'data_value'=>$data['file_name']
                   );
                $this->Common_DML->put_data('theme_setting', $theme_data, $where);
            }
            $success = [
                    'status'=>true,
                    'msg' => 'Favicon File upload',
                    'data_file'=>$data['file_name']
                    ];
            echo json_encode($success);
        }
    die();   
    }
    /**
     * Preloader Images
     */
    public function preloader_changes(){
        header('Content-Type: application/json');
        $config['upload_path']   = './uploads/logo'; 
        $config['allowed_types'] = 'gif|jpg|png'; 
        $config['max_size']      = 1024;
        $this->load->library('upload', $config);
		if(!$this->upload->do_upload('preloader_images_file')) {
            $error = array(
                        'status' =>false,
                        'msg' => 'Something went wrong!',
                        'data_file'=>$this->upload->display_errors()
                        ); 
            echo json_encode($error);
        }else { 
             $data = $this->upload->data();
             $userID = $this->session->userdata( 'user_id' );
             $where = array('user_id'=>$userID,'data_key' =>'pg_preloader_image');
			 $result = $this->Common_DML->get_data( 'theme_setting', $where, 'COUNT(*) As total' );
            if($result[0]['total'] > 0){
               $theme_data = array('data_value'=>$data['file_name']);
               $where = array('data_key'=>'pg_preloader_image');     
               $update_logo =$this->Common_DML->set_data('theme_setting', $theme_data, $where);   
            }else{
                $theme_data = array(
                    'user_id' =>$userID,
                    'data_key'=>'pg_preloader_image',
                    'data_value'=>$data['file_name']
                   );
                $this->Common_DML->put_data('theme_setting', $theme_data, $where);
            }
            $success = [
                    'status'=>true,
                    'msg' => 'Preloader File upload',
                    'data_file'=>$data['file_name']
                    ];
            echo json_encode($success);
        }
    die();   
    }

    /**
     * Delete Images
     */
    public function delete_images_changes(){
        $file_name = '';
        if(!empty($_POST['file_name'])):
         $file_name = $_POST['file_name'];
        endif;
        $image_type = '';
        if(!empty($_POST['image_type'])):
         $image_type = $_POST['image_type'];
        endif;
        $where = array('data_key' => $image_type);
	    $this->Common_DML->delete_data('theme_setting', $where );
        $m_img_real= $_SERVER['DOCUMENT_ROOT'].'/uploads/logo/'.$file_name;
        unlink($m_img_real);
        $success = [
            'status'=>true,
            'msg' => 'Done',
           ];
        echo json_encode($success);
    }	
    function testing(){
        $header['admin/testing'] = html_escape('active');
        $this->load->view('admin/common/header', $header);
		$this->load->view('admin/testing',$data);
		$this->load->view('admin/common/footer');
    }
    function ChangeURLSQL(){
        $dbHost     = 'localhost';
    	$dbUname    = 'kamleshyadav_pixaguru';
    	$dbPass     = '.W8bX9!g&}$,';
    	$dbName     = 'kamleshyadav_pixaguru';
    	 
		$filename   = 'import_1';
    	$filePath = 'uploads/'.$filename; 
    	
        $file_content = file_get_contents($filePath); 
        $mime_type = mime_content_type($filePath);

    	if(file_exists($filePath)){	
    
         // Connect & select the database
    		$db = new mysqli($dbHost, $dbUname, $dbPass, $dbName); 
    		
    		// Temporary variable, used to store current query
    		$templine = '';
    		
    		// Read in entire file
    		$lines = file($filePath);
    	
    		$error = '';
    		
    		// Loop through each line
    		foreach ($lines as $line){
    			// Skip it if it's a comment
    			if(substr($line, 0, 2) == '--' || $line == ''){
    				continue;
    			}
    			
    			// Add this line to the current segment
    			$templine .= $line;
    			
    			// If it has a semicolon at the end, it's the end of the query
    			if (substr(trim($line), -1, 1) == ';'){
    				// Perform the query
    				if(!$db->query($templine)){
    					$error .= 'Error importing query "<b>' . $templine . '</b>": ' . $db->error . '<br /><br />';
    				}
    				
    				// Reset temp variable to empty
    				$templine = '';
    			}
    		}
		}
    }

    public function uploadeMedia()
    {
    	$data['images'] = $this->Common_DML->get_data( 'user_templates', array( 'user_id'=>$this->g_userID, 'type'=> 'croping') );
    	$data['images'] = $this->Common_DML->query( "SELECT * FROM `user_templates` WHERE `user_id` = ".$this->g_userID." AND `campaign_id` = 1 AND `status` = 1 AND `type` != '' AND `template_id` NOT IN(1,2) ORDER BY `template_id` DESC LIMIT 0,30" );
    	$this->load->view('admin/common/header');
		$this->load->view('admin/uploadmedia', $data);
		$this->load->view('admin/common/footer');
    }

    public function uploadmediaPost()
    {
    	$type = isset($_POST['type'])?html_escape($_POST['type']):'';
    	$tname = isset($_POST['name'])?html_escape($_POST['name']):'';
		
    	if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload'])){
				$filename = $_FILES['fileUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = $type.'-'.time().'.'.$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/mediaFiles/'.$type.'/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 102400;
				
				$this->load->library('upload', $config);
				
				//$this->upload->initialize($config); 
				
				if ( ! $this->upload->do_upload('fileUpload')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					
				}
			}
         $what = array(
				'user_id' => $this->g_userID,
				'campaign_id' => 1,
				'cat_id' => 1,
				'template_name' => $tname,
				'thumb' =>  $path.$name,
				'datetime' => date('Y-m-d H:i:s'),
				'status' => 1,
				'access_level' => 1,
				'template_access_leavel' => 1,
				'type' => $type,
			);
			$insert_id = $this->Common_DML->put_data( 'user_templates', $what );
		redirect( 'admin/uploadeMedia', 'refresh' );	

    }

    public function deleteMedia($id)
    {
    	$image = $this->Common_DML->get_data_row( 'user_templates', array( 'template_id' => $id) );
	if($image){
	 	if (file_exists($image->thumb)) {
    unlink($_SERVER['DOCUMENT_ROOT'].$image->thumb);
    }
	$query = ['template_id' => $id];
   $this->Common_DML->delete_data('user_templates', $query);
redirect( 'admin/uploadeMedia', 'refresh' );
	}
    }
  
}