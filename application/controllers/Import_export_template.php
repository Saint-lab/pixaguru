<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Import_export_template extends CI_Controller {
    private $g_userID;
    function __construct() {
		parent::__construct();
	    if( !$this->session->userdata( 'admin_member_login' ) ){
			redirect( 'authentication', 'refresh' );
		}
		$this->g_userID = $this->session->userdata( 'user_id' );
	}
	
	/**
	 * Template import
	 */ 
	public function download(){

        $data = $header = array();
	    $header['import_export'] = 'active';
        if($_GET):
            $query = $this->Common_DML->get_data('user_download_mange');
            if($_GET['status'] != $query[0]['status']):
               $array = array(
                    'payment_details' => json_encode($_GET),
                    'status' => $_GET['status']
                    );
                $newsletter_id = $this->Common_DML->put_data('user_download_mange', $array);
            endif;
        endif;  
        $this->load->view('admin/common/header', $header);
		$this->load->view('templates_import_export',$data);
	    $this->load->view('admin/common/footer');
    }
   
	public function import_ajax_request(){
	    
	    $json = file_get_contents('https://app.pixaguru.com/import_export_template/export');
        $json_data = json_decode($json,true);
        if($json_data){
            $template_id = 0;
            foreach($json_data as $datas){
                
                $user_id = $datas['user_id'];
                $campaign_id = $datas['campaign_id'];
                $cat_id = $datas['cat_id'];
                $sub_cat_id = $datas['sub_cat_id'];
                $template_size = $datas['template_size'];
                $template_name = $datas['template_name'];
                $template_data = $datas['template_data'];
                if($template_data){
                   $current_domain = "https://app.ajay.com";
                   $pathe_template_replace = str_replace('https://app.pixaguru.com', $current_domain, $template_data);
                }
               
               
               $array = array(
    				'template_name' => $template_name,
    				'campaign_id' => $campaign_id,
    				'user_id' => $user_id,
    				'cat_id' =>$cat_id,
    				'template_data' => $pathe_template_replace,
    				'template_size' => $template_size,
    				'sub_cat_id' => $sub_cat_id,
    				'datetime' => date('Y-m-d H:i:s'),
    				'modifydate' => date('Y-m-d H:i:s'),
    				'status' => 1
		  	      );
		  	   
		       $template_id = $this->Common_DML->put_data( 'user_templates', $array );
		      
             $template_id++;
            }
        }
	    /**/
	    
	  die(); 
	}

	/**
	 * Export
	 */ 
	public function export(){
	  $sub_category = $this->Common_DML->get_data('user_templates');
	  echo json_encode($sub_category);
	}
    /**
     * Download Files 
     */
    function download_threehundertem(){
        $url = 'https://app.pixaguru.com/data/300_template.zip';
        header("Location: $url");
        exit();
    }
   /**
     * Subscribe Newsletter
     */
    public function pix_subscribe_newsletter(){
        extract($_POST);
        $listID = 'uW7xi';
        $args = array(
             'campaign' => array('campaignId'=>$listID),
             'email' => $email,
             'name'  => $name,
             'dayOfCycle'=>0,
            );                                                                  
        $data_string = json_encode($args);
        $ch = curl_init('https://api.getresponse.com/v3/contacts');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(    
            'X-Auth-Token:api-key 7p55ps3l2j6rvww0e7xyi0ir94pzv6j5',                                                                      
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
            );
        $result = curl_exec($ch);
        if(empty($result)):
            echo json_encode(
                        array(
                            'status'=>true,
                            'message'=>'Thank you for Subscribe',
                            'download_url'=> base_url().'/import_export_template/download_threehundertem'
                            )
                        );    
        else:
            echo $result;
        endif;  
    die();  
    }
} 