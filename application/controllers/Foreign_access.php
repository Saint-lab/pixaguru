<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foreign_access extends CI_Controller {
    
	public function __construct()
    {
		parent::__construct();
		if(isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != 'https://saas.templatebundle.net'){
		    die('<h1 style="text-align:center">'.html_escape($this->lang->line('ltr_foreign_access_construct_msg1')).'</h1>');
		}
	}

	public function direct_access(){

		if($_SERVER['HTTP_ORIGIN'] != 'https://saas.templatebundle.net'){
		    redirect('foreign_access/unauthorizedAccess');
		} else {
		    $where = array('email' => $_POST['cust_email']);
			$result = $this->Common_DML->get_data( 'users', $where, '*' );
			if(isset($result) && !empty($result)){
				if($result[0]['status'] == 1){
					$profile_pic = !empty($result[0]['profile_pic']) ? $result[0]['profile_pic'] : '';
				    $data = array(
							'user_id' => $result[0]['id'],
							'email' => $result[0]['email'],
							'member_login' => $result[0]['role'] == 'user' ? true : false,
							'admin_member_login' => $result[0]['role'] == 'admin' ? true : false,
							'access_level' => $result[0]['access_level'],
							'profile_pic' => $profile_pic,
							'name' => $result[0]['name']
						);
					$this->session->set_userdata( $data );
					if($result[0]['role'] == 'user'){
						redirect('dashboard');
					}else{
						redirect('admin');
					}
				} else{
					redirect('https://saas.templatebundle.net/account_inactive');
				}
			}else{
				redirect('https://saas.templatebundle.net/account_not_found');
			}
		}
	}

	public function unauthorizedAccess(){
		die('<h1 style="text-align:center">'.html_escape($this->lang->line('ltr_foreign_access_construct_msg1')).'</h1>');
	}

	public function create_user(){

		if(isset($_POST['cust_email']) && isset($_POST['cust_pass'])){
			$insert_id = $this->Common_DML->put_data( 'm_records', array('rec_data'=>json_encode($_POST)) );

            /*
            We just check for email because email field is unique so we can't do multiple entry 
            for same email address with access level.
            If we found email address then we will update user data for access level 2
            */

            $userDetails = $this->Common_DML->get_data( 'users', array( 'email' => $_POST['cust_email']) );
            
            $m_productsDetails = $this->Common_DML->get_data( 'jv_product', array( 'product_id' => '222' ) );

            if(!empty($m_productsDetails)) {
                if(!empty($userDetails)) {
                    $this->Common_DML->set_data( 'users', array( 'access_level' => $m_productsDetails[0]['access_level'], 'datetime' => date('Y-m-d H:i:s'), 'status' => 1 ), array( 'email' => $_POST['cust_email'] ) );
					echo json_encode( array( 'status' => 'sucssess','action'=>'EXIST', 'msg' =>html_escape($this->lang->line('ltr_foreign_access_create_user_msg1')), 'data' => json_encode($userDetails) ) );
                } else {
                	
                    $prodName = $m_productsDetails[0]['product_name'];
                    $fullname = $_POST['cust_name'];
                    $randomPwd = md5($_POST['cust_pass']);

                    $ipn_arr = array(
						'name' => $fullname,
						'password' => $randomPwd,
						'access_level' => 2,
						'email' => $_POST['cust_email'],
						'datetime' => date('Y-m-d H:i:s'),
						'source' => 'Web App Bundle',
						'status' => 1
					);

					$insert_id = $this->Common_DML->put_data( 'users', $ipn_arr );

					$folder = 'user_'.$insert_id;
					if (!is_dir('uploads/'.$folder)) {
						mkdir('./uploads/' . $folder, 0777, TRUE);
						mkdir('./uploads/' . $folder . '/campaigns', 0777, TRUE);
						mkdir('./uploads/' . $folder . '/images', 0777, TRUE);
						mkdir('./uploads/' . $folder . '/templates', 0777, TRUE);
					}
					echo json_encode( array( 'status' => 'sucssess','action'=>'NEW', 'msg' =>html_escape($this->lang->line('ltr_foreign_access_create_user_msg2')), 'data' => json_encode($ipn_arr) ) );
                }
            } else {
	        	echo json_encode( array( 'status' => 'error','action'=>'', 'msg' =>html_escape($this->lang->line('ltr_foreign_access_create_user_msg3')), 'data' => '' ) );
	        }	
        } else{
        	echo json_encode( array( 'status' => 'error','action'=>'', 'msg' =>html_escape($this->lang->line('ltr_foreign_access_create_user_msg4')), 'data' => '' ) );
        }
	}
	
	public function account_status(){
		if(isset($_POST['cust_email'])) {
		    $status = isset($_POST['status']) && $_POST['status'] == 'active' ? 1 : 2;
		   	$check_user = $this->Common_DML->get_data( 'users', array( 'email' => $_POST['cust_email'], 'access_level' => 2 ) );
		   	if(!empty($check_user)) {
		   		$this->Common_DML->set_data( 'users', array( 'status' => $status ), array( 'id' => $check_user[0]['id'] ) );
				echo json_encode( array( 'status' => 'sucssess','action'=>'UPDATE', 'msg' => 'User Account '.ucfirst($_POST['status']).' Successfully.', 'data' => '' ) );
		   	} else {
				echo json_encode( array( 'status' => 'error','action'=>'', 'msg' =>html_escape($this->lang->line('ltr_foreign_access_account_status_msg1')), 'data' => '' ) );
			}
		}
		else {
			echo json_encode( array( 'status' => 'error','action'=>'', 'msg' =>html_escape($this->lang->line('ltr_foreign_access_account_status_msg2')), 'data' => '' ) );
		}
		die();	
	}
}
