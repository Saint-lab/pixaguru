<?php
defined('BASEPATH') OR exit('Access Denied');

class Tumblr {
    protected $CI;

	//OAuth Consumer Key
    private $client_id = '3tq1vQpK8Koi7oQuxwScHaBhHmSsePRIehAAkZuWFnWBSUQBIJ';
	
	//Secret Key
    private $client_secret = '5CWrQWP1vPEiTUxazplPhmraOaH0ATi1KvZcdWaJUBhJ9qKkDi';
	
    public function __construct() {
        $this->CI = &get_instance();
    }

    public function getLoginUrl() {
		$clientid = $this->client_id;
		$redirect =  base_url().'api/tumblr_access';
		
		$auth_url = 'https://www.tumblr.com/oauth2/authorize?state='.time().'&scope=basic write offline_access&response_type=code&approval_prompt=auto&redirect_uri='.$redirect.'&client_id='.$clientid;
		
        return htmlspecialchars($auth_url);
    }
	
	public function getAccessToken($code){
		$clientid = $this->client_id;
		$secret = $this->client_secret;
		$redirect = base_url().'api/tumblr_access';
	
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.tumblr.com/v2/oauth2/token',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => array(
		  'grant_type' => 'authorization_code',
		  'code' => $code,
		  'client_id' => $clientid,
		  'client_secret' => $secret,
		  'redirect_uri' => $redirect
		  )
		));

		$response = curl_exec($curl);

		$res = json_decode($response);
		
		if(!isset($res->error)){
			$access_token = $res->access_token;
			$expires_in = $res->expires_in;
			$refresh_token = $res->refresh_token;
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.tumblr.com/v2/user/info',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$access_token
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$res = json_decode($response);
			if($res->meta->status == 200){
				$username = $res->response->user->name;
			}else{
				$username = '';
			}
			return json_encode(array( 'access_token' => $access_token,'expires_in' => $expires_in, 'refresh_token' => $refresh_token, 'username' => $username ));
		}else{
			return $response;
		}
	}
	
	public function getRefreshToken($rtoken){
		
		$curl = curl_init();
		$clientid = $this->client_id;
		$secret = $this->client_secret;
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.tumblr.com/v2/oauth2/token',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => array(
			'grant_type' => 'refresh_token',
			'client_id' => $clientid,
			'client_secret' => $secret,
			'refresh_token' => $rtoken
		  )
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
		
		// $res = json_decode($response);
		// if(!isset($res->error)){
			// return $res;
		// }else{
			
		// }

	}
	
}
