<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		echo json_encode( array( 'error' =>html_escape($this->lang->line('ltr_api_index_msg1'))) );
		die();
	}
	 
	public function get(){
		if(isset($_POST['api_key']) && !empty($_POST['api_key'])){
			$api_key = html_escape($_POST['api_key']);
			$site = remove_http(html_escape($_POST['site_url']));
			$api = $this->Common_DML->get_data( 'api', array( 'api' => $api_key ) );
			if(count($api)){
				$data = array(
					'api_key' => $api[0]['api'],
					'site_url' => $api[0]['site'],
					'activate_at' => $api[0]['active_datetime'],
					'status' => $api[0]['status'],
				);
				if($api[0]['site'] == $site){
					echo json_encode( array( 'error' => 0, 'msg' =>html_escape($this->lang->line('ltr_api_index_msg2')), 'data' => $data ) );
				}else{
					if(empty($api[0]['site'])){
						echo json_encode( array( 'success' => 1, 'msg' =>html_escape($this->lang->line('ltr_api_index_msg3')), 'data' => $data ) );
					}else{
						echo json_encode( array( 'error' => 0, 'msg' =>html_escape($this->lang->line('ltr_api_index_msg4'))) );
					}
				}
			}else{
				echo json_encode( array( 'error' => 0, 'msg' =>html_escape($this->lang->line('ltr_api_index_msg5')).json_encode(html_escape($_POST))  ) );
			}
		}else{
			echo json_encode( array( 'error' => 0, 'msg' => html_escape($this->lang->line('ltr_api_index_msg6'))) );
		}
		die();
	}
	
	public function activate(){
		if(isset($_POST['api_key']) && !empty($_POST['api_key'])){
			$api_key = html_escape($_POST['api_key']);
			$site = remove_http(html_escape($_POST['site_url']));
			$api = $this->Common_DML->get_data( 'api', array( 'api' => $api_key ) );
			if(count($api)){
				if(empty($api[0]['site'])){
					$date = date('Y-m-d H:i:s');
					$data = array(
						'api_key' => $api[0]['api'],
						'site_url' => $site,
						'activate_at' => $date,
						'status' => 1,
					);
					$what = array( 'site' => $site, 'active_datetime' => $date, 'status' => 1 );
					$where = array( 'api' => $api_key );
					$this->Common_DML->set_data( 'api', $what, $where );
					echo json_encode( array( 'success' => 1, 'msg' =>html_escape($this->lang->line('ltr_api_activate_msg1')), 'data' => $data ) );
				}else{
					if($api[0]['site'] == $site){
						echo json_encode( array( 'error' => 0, 'msg' =>html_escape($this->lang->line('ltr_api_activate_msg2'))) );
					}else{
						echo json_encode( array( 'error' => 0, 'msg' =>html_escape($this->lang->line('ltr_api_activate_msg2'))) );
					}
				}
			}else{
				echo json_encode( array( 'error' => 0, 'msg' =>html_escape($this->lang->line('ltr_api_activate_msg3')).json_encode($_POST) ) );
			}
		}else{
			echo json_encode( array( 'error' => 0, 'msg' => html_escape($this->lang->line('ltr_api_activate_msg4'))) );
		}
		die();
	}
	
	public function get_campaigns(){
		if(isset($_POST['api_key']) && !empty($_POST['api_key'])){
			$api_key = html_escape($_POST['api_key']);
			$site = remove_http(html_escape($_POST['site_url']));
			$api = $this->Common_DML->get_data( 'api', array( 'api' => $api_key, 'site' => $site, 'status' => 1 ) );
			if(count($api)){
				$ex = explode('-',$api_key);
				$userID = base64_decode( $ex[1] );
				$campaign = $this->Common_DML->get_data( 'campaign', array( 'user_id' => $userID, 'status' => 1 ), 'campaign_id as id,name,datetime,status' );
				echo json_encode( array( 'success' => 1, 'msg' =>html_escape($this->lang->line('ltr_api_get_campaigns_msg1')), 'data' => $campaign ) );
			}else{
				echo json_encode( array( 'error' => 0, 'msg' =>html_escape($this->lang->line('ltr_api_get_campaigns_msg2'))) );
			}
		}else{
			echo json_encode( array( 'error' => 0, 'msg' =>html_escape($this->lang->line('ltr_api_get_campaigns_msg3'))) );
		}
		die();
	}
	
	public function get_images(){
	    header('Access-Control-Allow-Origin: *'); 
		if(isset($_POST['api_key']) && !empty($_POST['api_key'])){
			$api_key = html_escape($_POST['api_key']);
			$site = remove_http(html_escape($_POST['site_url']));
			$campaign_id = html_escape($_POST['campaign_id']);
			$api = $this->Common_DML->get_data( 'api', array( 'api' => $api_key, 'site' => $site, 'status' => 1 ) );
			if(count($api)){
				$ex = explode('-',$api_key);
				$userID = base64_decode( $ex[1] );
				$image = $this->Common_DML->get_data( 'user_templates', array( 'user_id' => $userID, 'campaign_id' => $campaign_id, 'status' => 1 ), 'thumb as image, template_name as name' );
				echo json_encode( array( 'success' => 1, 'msg' =>html_escape($this->lang->line('ltr_api_get_images_msg1')), 'data' => $image, 'url' => base_url() ) );
			}else{
				echo json_encode( array( 'error' => 0, 'msg' =>html_escape($this->lang->line('ltr_api_get_images_msg2')) ) );
			}
		}else{
			echo json_encode( array( 'error' => 0, 'msg' => html_escape($this->lang->line('ltr_api_get_images_msg3')) ) );
		}
		die();
	}
}  