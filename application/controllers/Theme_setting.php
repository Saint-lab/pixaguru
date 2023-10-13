<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Theme_setting extends CI_Controller {
    private $g_userID;
    function __construct() {
		parent::__construct();
		if(!$this->session->userdata('admin_member_login')){
			redirect('authentication', 'refresh');
		}
		$this->g_userID = $this->session->userdata( 'user_id' );
	}
    /**
     * Theme Setting
     */
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
     * Google Analytics - Tracking Scripts Option
     */
    public function google_analytics_script(){

        $data = $header = array();
		$userID = $this->session->userdata( 'user_id' );

        $where = array('user_id'=>$userID,'data_key' =>'google_analytics_header_script');
        $result_header_script = $this->Common_DML->get_data( 'theme_setting', $where);
        $data['result_header_script'] =$result_header_script; 

        $where = array('user_id'=>$userID,'data_key' =>'google_analytics_footer_script');
        $result_footer_script = $this->Common_DML->get_data( 'theme_setting', $where);
        $data['result_footer_script'] =$result_footer_script; 
        
        $header['google_analytics'] = html_escape('active');
        $this->load->view('admin/common/header', $header);
		$this->load->view('google_analytics',$data);
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

    /**
     * Google Analytics Header Script 
     */
    public function google_analytics_header_script_save(){
        $header_script = '';
        if(!empty($_POST['header_script'])):
            $header_script = $_POST['header_script'];  
        endif;
        $userID = $this->session->userdata('user_id');
        $where = array('user_id'=>$userID,'data_key' =>'google_analytics_header_script');
		$result = $this->Common_DML->get_data( 'theme_setting', $where, 'COUNT(*) As total' );
        if($result[0]['total'] > 0){
            $theme_data = array('data_value'=>$header_script);
            $where = array('data_key'=>'google_analytics_header_script');     
            $update_logo =$this->Common_DML->set_data('theme_setting', $theme_data, $where);   
        }else{
            $theme_data = array(
                'user_id' =>$userID,
                'data_key'=>'google_analytics_header_script',
                'data_value'=>$header_script
                );
            $this->Common_DML->put_data('theme_setting', $theme_data, $where);
        }
        $success = [
                'status'=>true,
                'msg' => 'Preloader File upload',
                ];
        echo json_encode($success);
     die();
    }
    /**
     * Google Analytics Footer Script 
     */
    public function google_analytics_footer_script_save(){
        $script_footer = '';
        if(!empty($_POST['footer_script'])):
            $script_footer = $_POST['footer_script'];  
        endif; 
        $userID = $this->session->userdata('user_id');
        $where = array('user_id'=>$userID,'data_key' =>'google_analytics_footer_script');
		$result = $this->Common_DML->get_data( 'theme_setting', $where, 'COUNT(*) As total' );
        if($result[0]['total'] > 0){
            $theme_data = array('data_value'=>$script_footer);
            $where = array('data_key'=>'google_analytics_footer_script');     
            $update_logo =$this->Common_DML->set_data('theme_setting', $theme_data, $where);   
        }else{
            $theme_data = array(
                'user_id' =>$userID,
                'data_key'=>'google_analytics_footer_script',
                'data_value'=>$script_footer
                );
            $this->Common_DML->put_data('theme_setting', $theme_data, $where);
        }
        $success = [
                'status'=>true,
                'msg' => 'Preloader File upload',
                ];
        echo json_encode($success);
     die();
    }
}