<?php
/**
 *  Snapchat Class
 */
class Snapchat
{
	private $client_id = '2f872eda-9f5d-457c-91e8-0bf3c5ba9374'; // Enter your Client ID here
	private $client_secret = 'c13da48feb662efbf3be'; // Enter your Client Secret here
	private $redirect_uri;
	private $api_url = 'https://adsapi.snapchat.com/v1';
	public $errors = array();
	
	public function __construct() {
        $this->CI = &get_instance();
    }
	
	public function getAuthUrl()
	{
		$this->redirect_uri = base_url() . 'api/snapchat-access';
		$state = mt_rand();

        $params = array(
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code',
            'scope' => 'snapchat-marketing-api',
            'state' => $state
        );

        $url = "https://accounts.snapchat.com/login/oauth2/authorize?" . http_build_query($params);

        $array = array('state' => $state);
        $this->CI->session->set_userdata($array);

        return $url;
	}

	public function getAccessToken($code)
    {
        $this->redirect_uri = base_url() . 'api/snapchat-access';

        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirect_uri
        );

        $url = "https://accounts.snapchat.com/login/oauth2/access_token";
        $data = $this->post_request($url, $params);

        return json_decode($data, true);
    }

    public function regenerateToken($refresh_token)
    {
    	$this->redirect_uri = base_url() . 'api/snapchat-access';

        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token
        );

        $url = "https://accounts.snapchat.com/login/oauth2/access_token";
        $data = $this->post_request($url, $params);

        return json_decode($data, true);
    }

    public function isTokenExpired($token)
    {
    	$tm = time();
    	$expire_at = strtotime($token[0]['expires_at']);

    	if($expire_at > $tm){
    		return false;
    	}else{
    		return true;
    	}
    }
	
	public function setupTokenData($token)
	{
		$token_data = array(
			"access_token" => $token['access_token'],
			"expires_in" => $token['expires_in'],		
			"refresh_token" => $token['refresh_token'],
			"token_type" => $token['token_type']		
		);

		if( isset($token['scope']) ){
			$token_data["scope"] = $token['scope'];
		}

		return $token_data;
	}

	public function getUserProfile($access_token)
	{
		$url = $this->api_url .'/me';
        $data = $this->get_request($url, $access_token);

        return json_decode($data, true);
	}

	public function getAllAdAccount($organization_id, $access_token)
	{
		$url = $this->api_url ."/organizations/{$organization_id}/adaccounts";
        $data = $this->get_request($url, $access_token);

        return json_decode($data, true);
	}

	public function create_media($image_name, $ad_account_id, $access_token)
	{
		$body = new \stdClass();

		$m['name'] = $image_name;
		$m['type'] = 'IMAGE';
		$m['ad_account_id'] = $ad_account_id;
		
		$body->media = array( (object) $m );
		$body_json = json_encode($body, true);

		$url = $this->api_url;
		$method = "/adaccounts/{$ad_account_id}/media";

		$headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'authorization: Bearer '. $access_token;

        $data = $this->post_request($url, $body, $method, $headers);

        return json_decode($data, true);
	}
	
	public function getHtmlForUnauth($user_id)
	{
		$authUrl = $this->getAuthUrl();
		if(is_array($authUrl)){
			$htmlBody = $authUrl['error'];
		}else{
			$htmlBody = '<h2>Setup your Snapchat Account:</h2>
			<p>+ Please login to your Snapchat Account</p>
			<a class="ha_btn" href="'.$authUrl.'">CLICK HERE</a>';
		}
		
		return $htmlBody;
	}
	
	public function getHtmlForAuth($user_id, $token)
	{
		$htmlBody = '';
		$access_token = '';

		if($this->isTokenExpired($token)){
			$token = $this->regenerateToken($token[0]['refresh_token']);
			if( isset($token['access_token']) )	{
				$access_token = $token['access_token'];
				$token_data = $this->setupTokenData($token);
				insert_new_token("snapchat", $token_data);
			}
		}else{
			$access_token = $token[0]['access_token'];
		}

		// Success Print User Blog Data
		$htmlBody .= "<h2>Snapchat Account</h2>";

		$profile = $this->getUserProfile($access_token);

		//print_r($profile);

		if( isset($profile['me']['id']) ){
			$screen_arr = array('id' => $profile['me']['id'], 'name' => $profile['me']['display_name'], 'email' => $profile['me']['email'], 'organization_id' => $profile['me']['organization_id']);

			$htmlBody .= "<h3>".$profile['me']['display_name']."</h3>";
			$htmlBody .= "<h3>".$profile['me']['email']."</h3>"; 

			$screen_name = json_encode( $screen_arr );
			update_blog_details("snapchat",$screen_name,$screen_name);
		}

		$htmlBody .= user_setup_form_logout('snapchat');
		
		return $htmlBody;
	}

	public function get_request($url, $access_token="")
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        if( $access_token ){
        	curl_setopt_array($curl, [
	            CURLOPT_RETURNTRANSFER => 1,
	            CURLOPT_URL => $url,
	            CURLOPT_USERAGENT => USER_AGENT,
	            CURLOPT_HTTPHEADER => array(
				    "authorization: Bearer {$access_token}"
				)
	        ]);
        }else{
        	curl_setopt_array($curl, [
	            CURLOPT_RETURNTRANSFER => 1,
	            CURLOPT_URL => $url,
	            CURLOPT_USERAGENT => USER_AGENT
	        ]);
        }
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if($http_status == 404){
            return json_encode(array('error' => 1, 'error_description' => 'Request Error: 404'));
        }
        
        /*if($http_status != 200){
            $error = 'Request Error:' . curl_error($curl);
            return json_encode(array('error' => 1, 'error_description' => $error));
        }*/

        // Close request to clear up some resources
        curl_close($curl);

        return $resp;
    }

    public function post_request($url, $postdata=array(), $method='', $headers=array())
    {
        if($method){
            $url = $url . $method;
        }

        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        if( !empty($headers) ){
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => USER_AGENT,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => http_build_query($postdata),
                CURLOPT_HTTPHEADER => $headers
            ]);
        }else{
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => USER_AGENT,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => http_build_query($postdata)
            ]);
        }
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if($http_status == 404){
            return json_encode(array('error' => 1, 'error_description' => 'Request Error: 404'));
        }
        
        if($http_status != 200){
            $error = 'Request Error:' . curl_error($curl);
            return json_encode(array('error' => 1, 'error_description' => $error));
        }

        // Close request to clear up some resources
        curl_close($curl);

        return $resp;
    }

    public function request($url, $postdata="", $method='', $headers=array())
    {
        if($method){
            $url = $url . $method;
        }

        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        if( !empty($headers) ){
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => USER_AGENT,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => $headers
            ]);
        }else{
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => USER_AGENT,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => http_build_query($postdata)
            ]);
        }
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if($http_status == 404){
            return json_encode(array('error' => 1, 'error_description' => 'Request Error: 404'));
        }
        
        /*if($http_status != 200){
            $error = 'Request Error:' . curl_error($curl);
            return json_encode(array('error' => 1, 'error_description' => $error));
        }*/

        // Close request to clear up some resources
        curl_close($curl);

        return $resp;
    }
}