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

		//$this->load->view('prebuild_templates', $data);
		$this->load->view('home', $data);

		$this->load->view('common/footer');

	}

	public function action(){

		if(!isset( $_POST['template_id'] )){ echo json_encode( array( 'status' => 0, 'msg' => html_escape($this->lang->line('ltr_images_action_msg1'))) ); die(); }

		$userID = $this->g_userID;

		if(isset($_POST['sub_user_id']) && !empty($_POST['sub_user_id'])){

			$sub_users = $this->Common_DML->get_data( 'sub_users', array('parent_user_id'=>$userID,'sub_user_id'=>html_escape($_POST['sub_user_id']),'status'=>1) );

			if(count($sub_users) == 1){

				$userID = html_escape($_POST['sub_user_id']);

			}

		}

		$where = array( 'template_id' => $_POST['template_id'], 'user_id' => $userID, 'status' => 1 );

		$template = $this->Common_DML->get_data( 'user_templates', $where );

		if(empty($template)){ echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_images_action_msg2'))) ); die(); }

		if(isset($_POST['action']) && $_POST['action'] == 'copy'){

			unset($template[0]['template_id']);

			$template[0]['datetime'] = date('Y-m-d H:i:s');

			$file = './'.$template[0]['thumb'];

			$name = random_generator() . '.jpg';

			$newfile = './uploads/user_'.$userID.'/templates/'.$name;

			if (!copy($file, $newfile)) {

				echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_images_action_msg3'))) );

				die();

			}

			$template[0]['thumb'] = 'uploads/user_'.$userID.'/templates/'.$name;
            $what = $template[0];
            $insert_id = $this->Common_DML->put_data( 'user_templates', $what );
            echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_images_action_msg4')), 'insert_id' => $insert_id, 'data' => $what ) );

		}

		if(isset($_POST['action']) && $_POST['action'] == 'delete'){

			$path = $template[0]['thumb'];

			if(!empty($path)) unlink($path);

			$this->Common_DML->delete_data( 'user_templates', $where );	

			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_images_action_msg5'))) );

		}

		if(isset($_POST['action']) && $_POST['action'] == 'rename'){

			$what = array( 'template_name' => html_escape($_POST['template_rename']) );

			$this->Common_DML->set_data( 'user_templates', $what, $where );

			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_images_action_msg6'))) );

		}

		if(isset($_POST['action']) && $_POST['action'] == 'save_as_template'){

			$what = array( 'save_as_template' => 1 );

			$this->Common_DML->set_data( 'user_templates', $what, $where );

			echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_images_action_msg7'))) );

		}

		die();

	}

	public function campaign_template(){

		$campaign_id = html_escape($_POST['campaign_id']);
        $template_id = '';
        $userID = $this->g_userID;

		if(!empty($_POST['campaign_name'])){

			$campaign_name = html_escape($_POST['campaign_name']);

			$what = array( 

				'name' => trim($campaign_name),

				'user_id' => $userID,

				'datetime' => date('Y-m-d H:i:s'),

				'status' => 1

			);

			$campaign_id = $this->Common_DML->put_data( 'campaign', $what );

		}

		if(!empty($campaign_id)){

			$template_name = html_escape($_POST['template_name']);
            $get_template_id = html_escape($_POST['get_template_id']);
            $template_userID = html_escape($_POST['template_userID']);
            $template_data = $this->Common_DML->get_data( 'user_templates', array( 'user_id' => $template_userID, 'template_id' => $get_template_id, 'status' => 1 ), 'template_data,template_size,cat_id,sub_cat_id', array() );
            if(!empty($template_data)){

				$what = $template_data[0];

				$date = date('Y-m-d H:i:s');

				$what['user_id'] = $userID;

				$what['template_name'] = $template_name;

				$what['campaign_id'] = $campaign_id;

				$what['datetime'] = $date;

				$what['modifydate'] = $date;

				$what['status'] = 1;

				$template_id = $this->Common_DML->put_data( 'user_templates', $what );

				$url = base_url() . 'editor/edit/'.$campaign_id.'/'.$template_id;

				echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_images_campaign_template_msg1')), 'url' => $url ) );

			}else{

				$template_data = $this->Common_DML->get_data( 'user_templates', array( 'template_id' => 1, 'status' => 1 ), 'template_data,cat_id,sub_cat_id', array() );

				$what = $template_data[0];

				$date = date('Y-m-d H:i:s');

				$what['user_id'] = $userID;

				$what['template_size'] = html_escape($_POST['template_size']);

				$what['template_name'] = $template_name;

				$what['campaign_id'] = $campaign_id;

				$what['datetime'] = $date;

				$what['modifydate'] = $date;

				$what['status'] = 1;

				$template_id = $this->Common_DML->put_data( 'user_templates', $what );

				$url = base_url() . 'editor/edit/'.$campaign_id.'/'.$template_id;

				echo json_encode( array( 'status' => 1, 'msg' =>html_escape($this->lang->line('ltr_images_campaign_template_msg1')), 'url' => $url ) );

			}			

		}else{

			echo json_encode( array( 'status' => 0, 'msg' =>html_escape($this->lang->line('ltr_images_campaign_template_msg2'))) );

		}
        die();
    }
    public function get_more_template(){

		if(isset($_POST['reach'])){

			$userID = $this->g_userID;

			$adminUserID = $this->Common_DML->get_data( 'users', array('role'=>'admin'), 'id' );

			$pre_templates = array();

			$count = array();

			$templates = $this->Common_DML->get_data( 'user_templates', array( 'user_id'=>$userID, 'save_as_template'=>1, 'status'=>1 ) );

			$size = html_escape($_POST['size']);

			$access_level = $this->session->userdata( 'access_level' );

			if(!empty($adminUserID)){

				$subcat = $search = '';

				if($_POST['sub_cat_id'] != 'all'){ $subcat = 'AND cat_id = 1 AND sub_cat_id = '.html_escape($_POST['sub_cat_id']); }

				if(isset($_POST['q']) && !empty($_POST['q'])){

					$search = 'AND template_name LIKE "%'.html_escape($_POST['q']).'%"';

				}

				if($_POST['use']){

					$where = array( 'user_id' => $adminUserID[0]['id'], 'campaign_id' => 1, 'status' => 1, 'template_size' => $size );

					if($_POST['sub_cat_id'] != 'all'){

						$where['cat_id'] = 1;

						$where['sub_cat_id'] = html_escape($_POST['sub_cat_id']);

					}

					if(isset($_POST['q']) && !empty($_POST['q'])){

						$where['template_name LIKE'] = '%'.html_escape($_POST['q']).'%';

					}

					$pre_templates = $this->Common_DML->get_data_limit( 
                                'user_templates', 
                                $where, 
                                'template_id,thumb,template_name,template_size,status,datetime,user_id', 
                                array(html_escape($_POST['reach']),12),
                                'modifydate',
                                'DESC'
                            );
                    $count = $this->Common_DML->query( "SELECT template_id FROM `user_templates` WHERE `user_id` = ".$adminUserID[0]['id']." AND `campaign_id` = 1 AND `status` = 1 AND template_size = '".$size."' $subcat $search ORDER BY `modifydate` DESC LIMIT ".(html_escape($_POST['reach'])+12).",12" );

				}else{

					$sql = "SELECT template_id,thumb,user_id,template_name,template_size,status,DATE_FORMAT(datetime, \"%d/%m/%Y\") as datetime FROM `user_templates` WHERE `user_id` = ".$adminUserID[0]['id']." AND `campaign_id` = 1 AND `status` = 1 AND template_size = '".$size."' AND `template_id` NOT IN(1,2) $subcat $search ORDER BY `modifydate` DESC LIMIT ".html_escape($_POST['reach']).",12";

					$pre_templates = $this->Common_DML->query( $sql );

					$count = $this->Common_DML->query( "SELECT template_id FROM `user_templates` WHERE `user_id` = ".$adminUserID[0]['id']." AND `campaign_id` = 1 AND `status` = 1 AND template_size = '".$size."' AND `template_id` NOT IN(1,2) $subcat $search ORDER BY `modifydate` DESC LIMIT ".(html_escape($_POST['reach'])+12).",12" );

				}

			}

			$response = array(
                'status' => 1,
                'reach' => html_escape($_POST['reach']) + count( array_merge($pre_templates, $templates) ),
                'data' => array_merge($pre_templates, $templates),
                'hide' => count($count) > 0 ? 0 : 1
                );
            echo json_encode( $response );
            die();
        }

	}

	/**
	 * Embed Code Template Images
	 */
	public function embed_code_template_images($id){
		$temp_id = base64_encode($id);
		$templates = $this->Common_DML->get_data('user_templates', array('template_id'=>$temp_id));
		if(!empty($templates[0]['thumb'])):
		 echo "<img src='".base_url().$templates[0]['thumb']."' alt='".$templates[0]['template_name']."' width='500' height='300'>";
		else:
		 echo "Not Found !";	
		endif;
	}

	// Image Effects session

	public function bkRemove(){
    $header = array();
		$header['menu'] = 'Background Remover';
		$data['images'] = $this->Common_DML->get_data( 'al_image', array( 'user_id'=>$this->g_userID, 'type'=> 'bkremover') );
		$this->load->view('common/header',$header);
		$this->load->view('img/bkremover', $data);
		$this->load->view('common/footer');
	}

	public function bkRemovePost(){
		$key = $this->Common_DML->get_data_row( 'api_table', array( 'user_id' => 1) );
     $image_name = "";

     if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload'])){
				$filename = $_FILES['fileUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/bkImage/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				
				//$this->upload->initialize($config); 
				
				if ( ! $this->upload->do_upload('fileUpload')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
				
 $curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://techhk.aoscdn.com/api/tasks/visual/segmentation');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "X-API-KEY: ".$key->api_key,
      "Content-Type: multipart/form-data",
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('sync' => 1,'image_file' => new CURLFILE($image_name)));
$output = curl_exec($curl);
$output = curl_errno($curl) ? curl_error($curl) : $output;
curl_close($curl);
$response = json_decode($output , true);
if($response != NULL){
if(strpos($response['data']['image'], "\u0026") !== FALSE){
	$output = str_replace("\u0026", "&", $response['data']['image']);
  	}else{
$output = $response['data']['image'];
}
file_put_contents("imagebk".$this->g_userID.".data",$output);
$foutput=file_get_contents("imagebk".$this->g_userID.".data");
if(isset($foutput) && $foutput != ""){
     $path2 = './uploads/user_'.$userID.'/bkImage/generated/';
        if (!file_exists($path2)) {
    mkdir($path2, 0777, true);
}
 $temp = time();
file_put_contents($path2.$temp."image.png", file_get_contents($foutput));
 $query = [
           'user_id'=> $this->g_userID,
           //'name' =>  request("name"),
           'image_url' => $path2.$temp."image.png",
           //'original' => $image_name,
           'type' => 'bkremover',
       ];
       $this->Common_DML->put_data('al_image', $query);
      if (file_exists("imagebk".$this->g_userID.".data")) {
    unlink("imagebk".$this->g_userID.".data");
    }
if (file_exists($path.$name)) {
    unlink($path.$name);
    }

}
   
redirect( 'images/bkRemove', 'refresh' );

			}else{
			redirect( 'images/bkRemove', 'refresh' );	
			}

		}

		}


public function addWhiteBk(){
    $header = array();
		$header['menu'] = 'Add White Background';
		$data['images'] = $this->Common_DML->get_data( 'al_image', array( 'user_id'=>$this->g_userID, 'type'=> 'whitebk') );
		$this->load->view('common/header',$header);
		$this->load->view('img/whitebk', $data);
		$this->load->view('common/footer');
	}

	public function addWhiteBkPost(){
		$key = $this->Common_DML->get_data_row( 'api_table', array( 'user_id' => 1) );
     $image_name = "";

     if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload'])){
				$filename = $_FILES['fileUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/whiteBk/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				
				//$this->upload->initialize($config); 
				
				if ( ! $this->upload->do_upload('fileUpload')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
				
 $curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://techhk.aoscdn.com/api/tasks/visual/segmentation');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "X-API-KEY: ".$key->api_key,
      "Content-Type: multipart/form-data",
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('sync' => 1,'image_file' => new CURLFILE($image_name)));
$output = curl_exec($curl);
$output = curl_errno($curl) ? curl_error($curl) : $output;
curl_close($curl);
$response = json_decode($output , true);
if($response != NULL){
if(strpos($response['data']['image'], "\u0026") !== FALSE){
	$output = str_replace("\u0026", "&", $response['data']['image']);
  	}else{
$output = $response['data']['image'];
}
file_put_contents("imagewhitebk".$this->g_userID.".data",$output);
$foutput=file_get_contents("imagewhitebk".$this->g_userID.".data");
if(isset($foutput) && $foutput != ""){
     $path2 = './uploads/user_'.$userID.'/whiteBk/generated/';
        if (!file_exists($path2)) {
    mkdir($path2, 0777, true);
}
 $temp = time();
file_put_contents($path2.$temp."image.png", file_get_contents($foutput));
 $query = [
           'user_id'=> $this->g_userID,
           //'name' =>  request("name"),
           'image_url' => $path2.$temp."image.png",
           //'original' => $image_name,
           'type' => 'whitebk',
       ];
       $this->Common_DML->put_data('al_image', $query);
      if (file_exists("imagewhitebk".$this->g_userID.".data")) {
    unlink("imagewhitebk".$this->g_userID.".data");
    }
if (file_exists($path.$name)) {
    unlink($path.$name);
    }

}
   
redirect( 'images/addWhiteBk', 'refresh' );

			}else{
			redirect( 'images/addWhiteBk', 'refresh' );	
			}

		}

		}

 


public function colorization(){
    $header = array();
		$header['menu'] = 'Colorization';
		$data['images'] = $this->Common_DML->get_data( 'al_image', array( 'user_id'=>$this->g_userID, 'type'=> 'colorization') );
		$this->load->view('common/header',$header);
		$this->load->view('img/color', $data);
		$this->load->view('common/footer');
	}

public function colorizationPost(){
  
  	$key = $this->Common_DML->get_data_row( 'api_table', array( 'user_id' => 1) );
     $image_name = "";

     if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload'])){
				$filename = $_FILES['fileUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/colorImage/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('fileUpload')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
				
 $curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://techhk.aoscdn.com/api/tasks/visual/colorization');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "X-API-KEY: ".$key->api_key,
      "Content-Type: multipart/form-data",
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('sync' => 1,'file' => new CURLFILE($image_name)));
$output = curl_exec($curl);
$output = curl_errno($curl) ? curl_error($curl) : $output;
curl_close($curl);
$response = json_decode($output , true);
if(strpos($response['data']['image'], "\u0026") !== FALSE){
	$output = str_replace("\u0026", "&", $response['data']['image']);
  	}else{
$output = $response['data']['image'];
}
file_put_contents("imagecolor".$this->g_userID.".data",$output);
$foutput=file_get_contents("imagecolor".$this->g_userID.".data");
if(isset($foutput)){
     $path2 = './uploads/user_'.$userID.'/colorImage/generated/';
        if (!file_exists($path2)) {
    mkdir($path2, 0777, true);
}
 $temp = time();
file_put_contents($path2.$temp."image.png", file_get_contents($foutput));
 $query = [
           'user_id'=> $this->g_userID,
           //'name' =>  request("name"),
           'image_url' => $path2.$temp."image.png",
           //'original' => $image_name,
           'type' => 'colorization',
       ];
       $this->Common_DML->put_data('al_image', $query);
      if (file_exists("imagecolor".$this->g_userID.".data")) {
    unlink("imagecolor".$this->g_userID.".data");
    }
if (file_exists($path.$name)) {
    unlink($path.$name);
    }

}
   
redirect( 'images/colorization', 'refresh' );

			}

		}


public function enhencement(){
    $header = array();
		$header['menu'] = 'Enhencement';
		$data['images'] = $this->Common_DML->get_data( 'al_image', array( 'user_id'=>$this->g_userID, 'type'=> 'enhencement') );
		$this->load->view('common/header',$header);
		$this->load->view('img/enhencement', $data);
		$this->load->view('common/footer');
	}

public function enhencementPost(){
  
  	$key = $this->Common_DML->get_data_row( 'api_table', array( 'user_id' => 1) );
     $image_name = "";

     if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload'])){
				$filename = $_FILES['fileUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/enhencementImage/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('fileUpload')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
				
 $curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://techhk.aoscdn.com/api/tasks/visual/scale');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "X-API-KEY: ".$key->api_key,
      "Content-Type: multipart/form-data",
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('sync' => 1, 'type' => 'face', 'image_file' => new CURLFILE($image_name)));
$output = curl_exec($curl);
$output = curl_errno($curl) ? curl_error($curl) : $output;
curl_close($curl);
$response = json_decode($output , true);
if(strpos($response['data']['image'], "\u0026") !== FALSE){
	$output = str_replace("\u0026", "&", $response['data']['image']);
  	}else{
$output = $response['data']['image'];
}
file_put_contents("imageenhec".$this->g_userID.".data",$output);
$foutput=file_get_contents("imageenhec".$this->g_userID.".data");
if(isset($foutput)){
     $path2 = './uploads/user_'.$userID.'/enhenceImage/generated/';
        if (!file_exists($path2)) {
    mkdir($path2, 0777, true);
}
 $temp = time();
file_put_contents($path2.$temp."image.png", file_get_contents($foutput));
 $query = [
           'user_id'=> $this->g_userID,
           //'name' =>  request("name"),
           'image_url' => $path2.$temp."image.png",
           //'original' => $image_name,
           'type' => 'enhencement',
       ];
       $this->Common_DML->put_data('al_image', $query);
      if (file_exists("imageenhec".$this->g_userID.".data")) {
    unlink("imageenhec".$this->g_userID.".data");
    }
if (file_exists($path.$name)) {
    unlink($path.$name);
    }

}
   
redirect( 'images/enhencement', 'refresh' );

			}

		}		



public function compression(){
    $header = array();
		$header['menu'] = 'Compression';
		$data['images'] = $this->Common_DML->get_data( 'al_image', array( 'user_id'=>$this->g_userID, 'type'=> 'compress') );
		$this->load->view('common/header',$header);
		$this->load->view('img/compression', $data);
		$this->load->view('common/footer');
	}

public function compressionPost(){
  
  	$key = $this->Common_DML->get_data_row( 'api_table', array( 'user_id' => 1) );
     $image_name = "";

     if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload'])){
				$filename = $_FILES['fileUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/compressImage/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('fileUpload')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
				
 $curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://techhk.aoscdn.com/api/tasks/visual/imgcompress');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "X-API-KEY: ".$key->api_key,
      "Content-Type: multipart/form-data",
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('sync' => 1, 'file' => new CURLFILE($image_name)));
$output = curl_exec($curl);
$output = curl_errno($curl) ? curl_error($curl) : $output;
curl_close($curl);
$response = json_decode($output , true);
if(strpos($response['data']['image'], "\u0026") !== FALSE){
	$output = str_replace("\u0026", "&", $response['data']['image']);
  	}else{
$output = $response['data']['image'];
}
file_put_contents("imagecompress".$this->g_userID.".data",$output);
$foutput=file_get_contents("imagecompress".$this->g_userID.".data");
if(isset($foutput)){
     $path2 = './uploads/user_'.$userID.'/compressImage/generated/';
        if (!file_exists($path2)) {
    mkdir($path2, 0777, true);
}
 $temp = time();
file_put_contents($path2.$temp."image.png", file_get_contents($foutput));
 $query = [
           'user_id'=> $this->g_userID,
           //'name' =>  request("name"),
           'image_url' => $path2.$temp."image.png",
           //'original' => $image_name,
           'type' => 'compress',
       ];
       $this->Common_DML->put_data('al_image', $query);
      if (file_exists("imagecompress".$this->g_userID.".data")) {
    unlink("imagecompress".$this->g_userID.".data");
    }
if (file_exists($path.$name)) {
    unlink($path.$name);
    }

}
   
redirect( 'images/compression', 'refresh' );

			}

		}	


public function croping(){
    $header = array();
		$header['menu'] = 'Croping';
		$data['images'] = $this->Common_DML->get_data( 'al_image', array( 'user_id'=>$this->g_userID, 'type'=> 'croping') );
		$this->load->view('common/header',$header);
		$this->load->view('img/croping', $data);
		$this->load->view('common/footer');
	}

public function cropingPost(){
  
  	$key = $this->Common_DML->get_data_row( 'api_table', array( 'user_id' => 1) );
     $image_name = "";

     if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload'])){
				$filename = $_FILES['fileUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/cropingImage/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('fileUpload')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
				
 $curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://techhk.aoscdn.com/api/tasks/visual/correction');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "X-API-KEY: ".$key->api_key,
      "Content-Type: multipart/form-data",
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('sync' => 1, 'image_file' => new CURLFILE($image_name)));
$output = curl_exec($curl);
$output = curl_errno($curl) ? curl_error($curl) : $output;
curl_close($curl);
$response = json_decode($output , true);
if(strpos($response['data']['image'], "\u0026") !== FALSE){
	$output = str_replace("\u0026", "&", $response['data']['image']);
  	}else{
$output = $response['data']['image'];
}
file_put_contents("imagecrop".$this->g_userID.".data",$output);
$foutput=file_get_contents("imagecrop".$this->g_userID.".data");
if(isset($foutput)){
     $path2 = './uploads/user_'.$userID.'/cropingImage/generated/';
        if (!file_exists($path2)) {
    mkdir($path2, 0777, true);
}
 $temp = time();
file_put_contents($path2.$temp."image.png", file_get_contents($foutput));
 $query = [
           'user_id'=> $this->g_userID,
           //'name' =>  request("name"),
           'image_url' => $path2.$temp."image.png",
           //'original' => $image_name,
           'type' => 'croping',
       ];
       $this->Common_DML->put_data('al_image', $query);
      if (file_exists("imagecrop".$this->g_userID.".data")) {
    unlink("imagecrop".$this->g_userID.".data");
    }
if (file_exists($path.$name)) {
    unlink($path.$name);
    }

}
   
redirect( 'images/croping', 'refresh' );

			}

		}	


public function imageToText(){
    $header = array();
		$header['menu'] = 'Croping';
		$this->load->view('common/header',$header);
		$this->load->view('img/textimage');
		$this->load->view('common/footer');
	}

public function imageToTextPost(){
  
  	$key = $this->Common_DML->get_data_row( 'api_table', array( 'user_id' => 1) );
     $image_name = "";

     if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload'])){
				$filename = $_FILES['fileUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/imageToText/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('fileUpload')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
				
 $curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://techhk.aoscdn.com/api/tasks/document/ocr');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "X-API-KEY: ".$key->api_key,
      "Content-Type: multipart/form-data",
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('file' => new CURLFILE($image_name)));
$output = curl_exec($curl);
$output = curl_errno($curl) ? curl_error($curl) : $output;
curl_close($curl);
var_dump($output);
die();
$response = json_decode($output , true);
if(strpos($response['data']['task_id'], "\u0026") !== FALSE){
	$output = str_replace("\u0026", "&", $response['data']['task_id']);
  	}else{
$output = $response['data']['task_id'];
}
var_dump($output);
die();
file_put_contents("imagecrop".$this->g_userID.".data",$output);
$foutput=file_get_contents("imagecrop".$this->g_userID.".data");
if(isset($foutput)){
     $path2 = './uploads/user_'.$userID.'/cropingImage/generated/';
        if (!file_exists($path2)) {
    mkdir($path2, 0777, true);
}
 $temp = time();
file_put_contents($path2.$temp."image.png", file_get_contents($foutput));
 $query = [
           'user_id'=> $this->g_userID,
           //'name' =>  request("name"),
           'image_url' => $path2.$temp."image.png",
           //'original' => $image_name,
           'type' => 'croping',
       ];
      if (file_exists("imagecrop".$this->g_userID.".data")) {
    unlink("imagecrop".$this->g_userID.".data");
    }
if (file_exists($path.$name)) {
    unlink($path.$name);
    }

}
   
redirect( 'images/croping', 'refresh' );

			}

		}	



public function objectRemover(){
    $header = array();
		$header['menu'] = 'ObjectRemover';
		$data['images'] = $this->Common_DML->get_data( 'al_image', array( 'user_id'=>$this->g_userID, 'type'=> 'objremover') );
		$this->load->view('common/header',$header);
		$this->load->view('img/objremover', $data);
		$this->load->view('common/footer');
	}

public function objectRemoverPost(){
  
  	$key = $this->Common_DML->get_data_row( 'api_table', array( 'user_id' => 1) );
     $image_name = "";

     if(isset($_FILES['fileUpload1']) && !empty($_FILES['fileUpload1'])){
				$filename = $_FILES['fileUpload1']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/objremover/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('fileUpload1')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name1 = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
		}

if(isset($_FILES['fileUpload2']) && !empty($_FILES['fileUpload2'])){
				$filename = $_FILES['fileUpload2']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/objremover/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('fileUpload2')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name2 = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
		}				
				
 $curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://techhk.aoscdn.com/api/tasks/visual/inpaint');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "X-API-KEY: ".$key->api_key,
      "Content-Type: multipart/form-data",
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, array(
'sync' => 1, 
'rectangles'=>'[{"x": 0,"y": 0,"width": 100,"height": 100}]',
'image_file' => new CURLFILE($image_name1), 
'mask_file' => new CURLFILE($image_name2))
);
$output = curl_exec($curl);
$output = curl_errno($curl) ? curl_error($curl) : $output;
curl_close($curl);
$response = json_decode($output , true);
if(strpos($response['data']['image'], "\u0026") !== FALSE){
	$output = str_replace("\u0026", "&", $response['data']['image']);
  	}else{
$output = $response['data']['image'];
}
file_put_contents("imageobj".$this->g_userID.".data",$output);
$foutput=file_get_contents("imageobj".$this->g_userID.".data");
if(isset($foutput)){
     $path2 = './uploads/user_'.$userID.'/objImage/generated/';
        if (!file_exists($path2)) {
    mkdir($path2, 0777, true);
}
 $temp = time();
file_put_contents($path2.$temp."image.png", file_get_contents($foutput));
 $query = [
           'user_id'=> $this->g_userID,
           //'name' =>  request("name"),
           'image_url' => $path2.$temp."image.png",
           //'original' => $image_name,
           'type' => 'objremover',
       ];
       $this->Common_DML->put_data('al_image', $query);
      if (file_exists("imageobj".$this->g_userID.".data")) {
    unlink("imageobj".$this->g_userID.".data");
    }
if (file_exists($path.$name)) {
    unlink($path.$name);
    }

}
   
redirect( 'images/objremover', 'refresh' );

			

		}	



public function idPhoto(){
    $header = array();
		$header['menu'] = 'ID Photo';
		$data['images'] = $this->Common_DML->get_data( 'al_image', array( 'user_id'=>$this->g_userID, 'type'=> 'idphoto') );
		$this->load->view('common/header',$header);
		$this->load->view('img/idphoto',$data);
		$this->load->view('common/footer');
	}

public function idPhotoPost(){
  
  	$key = $this->Common_DML->get_data_row( 'api_table', array( 'user_id' => 1) );
     $image_name = "";

     if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload'])){
				$filename = $_FILES['fileUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = empty($ext) ? 'jpg' : $ext;
				$name = time().$ext;
				$userID = $this->g_userID;
				if(!$userID) return false;
				$path = './uploads/user_'.$userID.'/idPhoto/';
				      if (!file_exists($path)) {
                         mkdir($path, 0777, true);
                       }
					
				$config['upload_path']  	= $path;
				$config['file_name']  	= $name;
				$config['overwrite']  	= true;
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['max_size']       = 10240;
				
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('fileUpload')){
					$result = array('error' => $this->upload->display_errors());
				}else{
					$image_name = $this->upload->data()['full_path'];
				   $type = $this->upload->data()['file_type'];
				   $fname = $this->upload->data()['file_name'];
				}
$size = '480x640';				
				
 $curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://techhk.aoscdn.com/api/tasks/visual/idphoto');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "X-API-KEY: ".$key->api_key,
      "Content-Type: multipart/form-data",
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('sync' => 1,'size' => $size, 'image_file' => new CURLFILE($image_name)));
$output = curl_exec($curl);
$output = curl_errno($curl) ? curl_error($curl) : $output;
curl_close($curl);
var_dump($output);
die();
$response = json_decode($output , true);
if(strpos($response['data']['image'], "\u0026") !== FALSE){
	$output = str_replace("\u0026", "&", $response['data']['image']);
  	}else{
$output = $response['data']['image'];
}
var_dump($output);
die();
file_put_contents("imageid".$this->g_userID.".data",$output);
$foutput=file_get_contents("imageid".$this->g_userID.".data");
if(isset($foutput)){
     $path2 = './uploads/user_'.$userID.'/idImage/generated/';
        if (!file_exists($path2)) {
    mkdir($path2, 0777, true);
}
 $temp = time();
file_put_contents($path2.$temp."image.png", file_get_contents($foutput));
 $query = [
           'user_id'=> $this->g_userID,
           //'name' =>  request("name"),
           'image_url' => $path2.$temp."image.png",
           //'original' => $image_name,
           'type' => 'idphoto',
       ];
       $this->Common_DML->put_data('al_image', $query);
      if (file_exists("imageid".$this->g_userID.".data")) {
    unlink("imageid".$this->g_userID.".data");
    }
if (file_exists($path.$name)) {
    unlink($path.$name);
    }

}
   
redirect( 'images/idPhoto', 'refresh' );

			}

		}

public function deleteGeneratedImage($id, $page="")
{
	$image = $this->Common_DML->get_data_row( 'al_image', array( 'id' => $id) );
	if($image){
	 	if (file_exists($image->image_url)) {
    unlink($image->image_url);
    }
	$query = ['id' => $id];
   $this->Common_DML->delete_data('al_image', $query);
redirect( 'images/'.$page, 'refresh' );
	}
		
}

public function downloadGeneratedImage($id, $page="")
{
	$image = $this->Common_DML->get_data_row( 'al_image', array( 'id' => $id) );
	if($image){
	 if (file_exists($image->image_url)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($image->image_url).'"');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: '.filesize($image->image_url));
		readfile($image->image_url);
		exit;
		}
	
redirect( 'images/'.$page, 'refresh' );
	}
		
}

public function imageLib(){
     $this->load->view('common/header');
		$this->load->view('img/imagelib');
		$this->load->view('common/footer');
    } 
    
    public function videoLib(){
     $this->load->view('common/header');
		$this->load->view('img/videolib');
		$this->load->view('common/footer');
    }

public function imageToVideo(){
     $this->load->view('common/header');
		$this->load->view('img/imagevideo');
		$this->load->view('common/footer');
    }














}

