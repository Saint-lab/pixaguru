<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editor extends CI_Controller {
	
	private $g_userID;
	function __construct() {
		parent::__construct();
		$this->g_userID = $this->session->userdata( 'user_id' );
		if( !$this->session->userdata( 'member_login' ) && !$this->session->userdata( 'admin_member_login' ) ){
			redirect( 'authentication', 'refresh' );
        }else{
		    if($this->session->userdata('member_login')){
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
		redirect( 'dashboard', 'refresh' );
	}	
	public function edit( $campaign_id = '', $template_id = '', $sub_user_id = '' ){
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
			$this->load->view( 'editor', $data );
		}else{
			redirect( 'dashboard', 'refresh' );
		}
	}
	
	public function upload_media(){
		if(isset($_FILES['mediafile'])){
			$filename = $_FILES['mediafile']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$ext = empty($ext) ? 'jpg' : $ext;
			$name = random_generator();
			$name .= '.'.$ext;
			$userID = $this->g_userID;
			if(!$userID) return false;
			$path = './uploads/user_'.$userID.'/images/';
				
			$config['upload_path']  	= $path;
			$config['file_name']  	= $name;
			$config['allowed_types']  = '*';
			$config['max_size']       = 1024*10;
			
			$this->load->library('upload', $config);
			$this->load->library('image_lib');
			$this->upload->initialize($config);
			
			if ( ! $this->upload->do_upload('mediafile')){
				$result = array('error' => $this->upload->display_errors());
			}else{
				
				$resize = array();
				$resize['image_library'] = 'gd2';
				$resize['source_image'] = $path.'/'.$name;
				$resize['create_thumb'] = TRUE;
				$resize['maintain_ratio'] = FALSE;
				$resize['width']     = 80;
				$resize['height']   = 80;
				$resize['new_image'] = $path.'/'.$name;	

				$this->image_lib->clear();
				$this->image_lib->initialize($resize);
				$this->image_lib->resize();
				
				$thumb_name = filename_withoutext( $name );
				$original_name = filename_withoutext( $filename );				
				$array = array(
					'user_id' => $userID,
					'image_url' => 'uploads/user_'.$userID.'/images/' . $name,
					'thumb_url' => 'uploads/user_'.$userID.'/images/' .$thumb_name . '_thumb.' . $ext
				);
				
				$insert_id = $this->Common_DML->put_data( 'user_image', $array );
				
				$result['thumb_url'] = base_url(). 'uploads/user_'.$userID.'/images/' .$thumb_name . '_thumb.' . $ext;
				$result['image_url'] = base_url(). 'uploads/user_'.$userID.'/images/' . $name;
				$result['success'] = 1;
				$result['id'] = $insert_id;
				
			}
			echo json_encode($result);
		}
		die();
	}
	
	public function deleteimage(){
		if(!empty($_POST['id']) && $_POST['delete'] == 'confirm'){
			$where = array( 'id' => html_escape($_POST['id']));
			$image = $this->Common_DML->get_data( 'user_image', $where );
			$userID = $this->g_userID;
			if(!empty($image)){
				$full_path = $image[0]['image_url'];
				$thumb_path = $image[0]['thumb_url'];
				
				if(unlink($full_path) && unlink($thumb_path)){
					$this->Common_DML->delete_data( 'user_image', $where );
					echo json_encode( array( 'result' => true ) );
				}else{
					echo json_encode( array( 'result' => false ) );
				}
				
			}else{
				echo json_encode( array( 'result' => 'notexist' ) );
			}
		}
	}
	 
	public function save_template(){
		if(isset($_POST['template_data']) && $_POST['template_id'] == 0){
			$userID = $this->g_userID;
			$fileData = base64_decode( str_replace( 'data:image/jpeg;base64,', '', $_POST['thumb'] ) );
			$name = random_generator() . '.jpg';
			$path = './uploads/user_'.$userID.'/templates/'.$name;
			$myfile = fopen( $path, "w" );
			file_put_contents( $path, $fileData );
			fclose($myfile);
            $template_name = ''; 
			if(isset($_POST['template_name'])):
			 $template_name = html_escape($_POST['template_name']);
			endif;
			$template_data = '';
			if(isset($_POST['template_data'])):
			 $template_data = html_escape($_POST['template_data']);
			endif; 
			$what = array(
				'user_id' => $userID,
				'template_name' => $template_name,
				'template_data' => $template_data,
				'thumb' =>  'uploads/user_'.$userID.'/templates/' . $name,
				'datetime' => date('Y-m-d H:i:s'),
				'status' => 1
			);
			$insert_id = $this->Common_DML->put_data( 'user_templates', $what );
			echo json_encode( array( 'status' => 1, 'insert_id' => $insert_id ) );
			
		}else if(isset($_POST['template_data']) && $_POST['template_id']){
			$where = array( 'template_id' => $_POST['template_id'] );
			$image = $this->Common_DML->get_data( 'user_templates', $where );
			$size = '';
			if(!count($image)){
				echo json_encode( array( 'status' => 0, 'msg' => 'Campaign or Template have been deleted.' ) );
				die();
			}
			
			/***** delete image *****/
			if(!empty($image[0]['thumb'])){
				$full_path = $image[0]['thumb'];
				if(file_exists($full_path)){
					unlink($full_path);
				}
			}
			/***** delete image *****/
			if(!empty($image[0]['template_size'])){
				$size = $image[0]['template_size'];
			}
			
			$userID = $this->g_userID;
			$fileData = base64_decode( str_replace( 'data:image/jpeg;base64,', '', $_POST['thumb'] ) );
			$name = random_generator() . '.jpg';
			$path = './uploads/user_'.$userID.'/templates/'.$name;
			$myfile = fopen( $path, "w" );
			file_put_contents( $path, $fileData );
			fclose($myfile);
			
			$what = array(
				'template_data' => $_POST['template_data'],
				'gradient_background' => isset($_POST['gradient_background']) ? $_POST['gradient_background'] : '',
				'thumb' =>  'uploads/user_'.$userID.'/templates/' . $name,
				'modifydate' => date('Y-m-d H:i:s')
			);
			
			$this->Common_DML->set_data( 'user_templates', $what, $where );
			
			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_editor_save_template_msg2')), 'thumb' => 'uploads/user_'.$userID.'/templates/' . $name, 'size' => $size, 'access_level' => $this->session->userdata( 'access_level' ) ) );
		}
		
// 		if(isset($_POST['template_data']) && $_POST['template_id']){
// 			$where = array( 'template_id' => html_escape($_POST['template_id']) );
// 			$image = $this->Common_DML->get_data( 'user_templates', $where );
// 			$size = '';
// 			if(!count($image)){
// 				echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_editor_save_template_msg1'))) );
// 				die();
// 			}
			
// 			/***** delete image *****/
// 			if(!empty($image[0]['thumb'])){
// 				$full_path = $image[0]['thumb'];
// 				if(file_exists($full_path)){
// 					unlink($full_path);
// 				}
// 			}
// 			/***** delete image *****/
// 			if(!empty($image[0]['template_size'])){
// 				$size = $image[0]['template_size'];
// 			}
			
// 			$userID = $this->g_userID;
// 			$fileData = base64_decode( str_replace( 'data:image/jpeg;base64,', '', html_escape($_POST['thumb']) ) );
// 			$name = random_generator() . '.jpg';
// 			$path = './uploads/user_'.$userID.'/templates/'.$name;
// 			$myfile = fopen( $path, "w" );
// 			file_put_contents( $path, $fileData );
// 			fclose($myfile);
			
// 			$what = array(
// 				'template_data' => $_POST['template_data'],
// 				'gradient_background' => isset($_POST['gradient_background']) ? $_POST['gradient_background'] : '',
// 				'thumb' =>  'uploads/user_'.$userID.'/templates/' . $name,
// 				'modifydate' => date('Y-m-d H:i:s')
// 			);
			
// 			$this->Common_DML->set_data( 'user_templates', $what, $where );
			
// 			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_editor_save_template_msg2')), 'thumb' => 'uploads/user_'.$userID.'/templates/' . $name, 'size' => $size, 'access_level' => $this->session->userdata( 'access_level' ) ) );
// 		}
		
	}
	
	public function get_object(){
		if(isset($_POST['template_id'])){
			$userID = $this->g_userID;
			
			if(isset($_POST['sub_user_id']) && !empty($_POST['sub_user_id'])){
				$sub_users = $this->Common_DML->get_data( 'sub_users', array('parent_user_id'=>$userID,'sub_user_id'=>$_POST['sub_user_id'],'status'=>1) );
				if(count($sub_users) == 1){
					$userID = html_escape($_POST['sub_user_id']);
				}
			}
			$template_id = html_escape($_POST['template_id']);
			$where = array( 'user_id' => $userID, 'template_id' => $template_id );
			
			if(!$this->session->userdata( 'admin_member_login' )){
				$where['status'] = 1;
			}
			$template_data = $this->Common_DML->get_data( 'user_templates', $where, 'template_data,gradient_background,sub_cat_id,template_size,template_custom_size', array() );
			if(isset($template_data[0])){
				$suggestion = $tips = '';
				if(!$this->session->userdata( 'admin_member_login' )){
					$access_level = $this->session->userdata( 'access_level' );
					if($access_level == 1){
						$w_suggestion = array( 'sub_cat_id' => $template_data[0]['sub_cat_id'], 'frontend' => 1 );
						$w = array( 'frontend' => 1 );
					}else{
						$w_suggestion = array( 'sub_cat_id' => $template_data[0]['sub_cat_id'] );
						$w = array();
					}
					$suggestion = $this->Common_DML->get_data( 'suggestion', $w );
					$tips = $this->Common_DML->get_data( 'suggestion', $w_suggestion, '*' );
				}
				$template_size = '600*600';
				if($template_data[0]['template_size'] =='create_custom_size'):
					$template_size = $template_data[0]['template_custom_size'];
				else:
					$template_size = $template_data[0]['template_size'];
				endif;
				echo json_encode( array( 'status' => 1, 'data' => $template_data[0]['template_data'], 'gradient_background' => $template_data[0]['gradient_background'], 'suggestion' => $suggestion, 'tips' => $tips, 'size' =>$template_size ) );
			}else{
				echo json_encode( array( 'status' => 0 ) );
			}
		}
		die();
	}
	
	public function admin_edit( $template_id = '' ){
		if($template_id == '') redirect( 'admin/templates', 'refresh' );
		$userID = $this->g_userID;
		$data['images'] = $this->Common_DML->get_data( 'user_image', array( 'user_id' => $userID ), '*', array( 'id'=>'DESC' ) );
		$data['userID'] = $userID;
		$data['template'] = $this->Common_DML->get_data( 'user_templates', array( 'template_id' => $template_id ), '*', array() );
		$data['template_id'] = $template_id;
		$data['theme_setting'] = $this->Common_DML->get_data( 'theme_setting', '', '*', array() );
// 		echo "<pre>";print_r(	$data['theme_setting']);
//         die;
		if(empty($data['template'])){
		  redirect( 'dashboard', 'refresh' );
		}
		$this->load->view( 'editor', $data );
	}
	    
	public function more_images(){
		if(isset($_POST['page'])){
			$userID = $this->g_userID;
			$page = html_escape($_POST['page']);
			$s = 21 * $page;
			$e = $s + 21;
			$images = $this->Common_DML->get_data_limit( 'user_image', array( 'user_id' => $userID ), '*', array($s,$e), 'id','DESC' );
			if(count($images)){
				echo json_encode( array( 'status' => 1, 'data' => $images ) );
			}else{
				echo json_encode( array( 'status' => 0 ) );
			}			
		}
	}
	
}
