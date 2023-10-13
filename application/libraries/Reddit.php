<?php
defined('BASEPATH') OR exit('Access Denied');

class Reddit {
    protected $CI;

    private $client_id = 'HWifWaFuvHLjjQrvNVvS2Q';
    private $app_secret = 'yXg3DaOZur5SDFsd_qyOd91Eqq4dbQ';
       
    public function __construct() {
        $this->CI = &get_instance();
    }

    public function getLoginUrl() {
		$clientid = $this->client_id;
		$redirect = base_url().'api/reddit_access';
		$auth_url = 'https://www.reddit.com/api/v1/authorize?client_id='.$clientid.'&response_type=code&state=assas&redirect_uri='.$redirect.'&duration=permanent&scope=identity,submit,subscribe';
		
        return htmlspecialchars($auth_url);
    }
	
	public function getAccessToken($code){
		$clientid = $this->client_id;
		$secret = $this->app_secret;
		$redirect = base_url().'api/reddit_access';
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://www.reddit.com/api/v1/access_token',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_USERPWD => $clientid.":".$secret,
		  CURLOPT_POSTFIELDS => array('grant_type' => 'authorization_code','code' => $code,'redirect_uri' => $redirect),
		  
		));

		$response = curl_exec($curl);
		$tokData = json_decode($response);
		if(isset($tokData->access_token)){
			$token = $tokData->access_token;
			  curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://oauth.reddit.com/api/v1/me',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
				'User-Agent: UNIQUESTRING',
				'Authorization: bearer '.$token
			  ),
			));

			$response = curl_exec($curl);
			$res = json_decode($response);
			curl_close($curl);
			
			$name = isset($res->name) ? $res->name : '';
			
			return json_encode(array( 'token' => $token, 'username' => $name ));
		}else{
			return $response;
		}
	}
	
	
}
