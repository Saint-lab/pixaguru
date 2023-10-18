<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	
	private $g_userID;
	function __construct() {
		parent::__construct();
		if( !$this->session->userdata( 'member_login' ) && !$this->session->userdata('admin_member_login')){
		 redirect( 'authentication', 'refresh' );
		}
		$this->g_userID = $this->session->userdata( 'user_id' );
	}
	public function index(){
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
		$this->load->view('common/header',$header);
		$this->load->view('profile', $data);
		$this->load->view('common/footer');
	}
	
	public function update(){
		if(isset($_POST['profile_update']) && $_POST['profile_update'] == 'update'){
			$profile_pic = '';
			
			if(isset($_FILES['pic_file']) && !empty($_FILES['pic_file'])){
				$filename = $_FILES['pic_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = 'profile_pic.'.$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/';
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png';
				$config['max_size']       = 1024*10;
				
				$this->load->library('upload', $config);
				$this->load->library('image_lib');
				$this->upload->initialize($config);
				
				if ( ! $this->upload->do_upload('pic_file')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					
					$resize = array();
					$resize['image_library'] = 'gd2';
					$resize['source_image'] = $path.'/'.$name;
					$resize['create_thumb'] = FALSE;
					$resize['maintain_ratio'] = FALSE;
					$resize['width']     = 100;
					$resize['height']   = 100;

					$this->image_lib->clear();
					$this->image_lib->initialize($resize);
					$this->image_lib->resize();
					
				   $profile_pic = 'uploads/user_'.$userID.'/'.$name;
					
				}
			}
			
			$what = array(
				'name' => trim($_POST['name']),
				'phone_no' => $_POST['phone_no']
			);
			
			$data = array(
				'name' => $_POST['name']
			);
			
			if($_POST['profile_pic_remove']){
				$what['profile_pic'] = '';
				$data['profile_pic'] = '';
			}
			
			if($profile_pic != ''){
				$what['profile_pic'] = $profile_pic;
				$data['profile_pic'] = $profile_pic;
			}
						
			$this->session->set_userdata( $data );
			
			if(!empty($_POST['password']) && $_POST['password'] == $_POST['confirm_password']){
				$what['password'] = md5($_POST['password']);
			}
			$where = array( 'id' => $this->g_userID );
			$this->Common_DML->set_data('users', $what, $where);

			if($this->session->userdata('admin_member_login')){
				redirect( 'admin/profile?msg=1', 'refresh' );
			}else{
				redirect( 'profile?msg=1', 'refresh' );
			}
			exit();
		}
		if($this->session->userdata('admin_member_login')){
            redirect( 'admin/profile', 'refresh' );
		}else{
			redirect( 'profile', 'refresh' );
		}
	}

	public function fb_details(){
		$fb_data = array( 'user_id' => $this->g_userID );
		$this->Common_DML->delete_data( 'fb_details', $fb_data );
		$data = array(
			'user_id' => $this->g_userID, 
			'app_id' => $_POST['app_id'],
			'app_secret' => $_POST['app_secret'],
			'datetime' => date('Y-m-d H:i:s'),
			'status' => 1
		);
		$insert_id = $this->Common_DML->put_data( 'fb_details', $data );
		if($insert_id > 0){
			$sess = array(
				'facebook_app_id' => $_POST['app_id'],
				'facebook_app_secret' => $_POST['app_secret']
			);
			$this->session->set_userdata( $sess );
			$this->load->helper('facebook_helper');
			$url = get_login_url( ['pages_show_list,ads_management,manage_pages'] );
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_profile_msg1')), 'url' => $url ) );
		}else{
			echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_profile_msg2'))) );
		}
	}

}
