<?php
require_once APPPATH . 'third_party/twitter/oauth/twitteroauth.php';

/**
 *  Twitter Class
 */
#[\AllowDynamicProperties]
class Twitter
{
	private $consumer_key = 'UJpJpRjgNfeUs8IatjTS22hu4'; 
	private $consumer_secret = 'CpMPBOuBSHyAY0Cs9Vf3vfvpemVvU0P1SC7LN9NNRBQIZRil6Q'; 
	private $access_token = '';
	private $access_token_secret = '';

	private $redirect_uri;
	public $errors = array();

	public function __construct() {
        $this->CI = &get_instance();
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

	public function getClient()
	{
		$client = new TwitterOAuth($this->consumer_key, $this->consumer_secret); 
		return $client;
	}

	public function getClientAuth()
	{
		$client = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->access_token, $this->access_token_secret);
		return $client;
	}

	public function getClientAuth2($access_token, $access_token_secret)
	{
		$client = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $access_token, $access_token_secret);
		return $client;
	}

	public function getRefreshToken($client)
	{
		$this->redirect_uri = base_url() . 'api/twitter-access';
		$request_token = $client->getRequestToken($this->redirect_uri);
		return $request_token;
	}

	public function setupTokenData($token_data,$switch=false) {

		if( json_validator($token_data['screen_name']) ){

		}else{
			$screen_name = json_encode(array('name' => $token_data['screen_name'], 'user_name' => $token_data['screen_name']));
			$token_data['screen_name'] = $screen_name;
		}

		if( !isset($token_data['customer_id']) ){
			$token_data['customer_id'] = $token_data['user_id'];
		}

		if ($switch==true) {
			return $tokens = array(
				"oauth_token" => $token_data['access_token'],
				"oauth_token_secret" => $token_data['token_secret'],			
				"customer_id" => $token_data['customer_id'],			
				"screen_name" => $token_data['screen_name']		
			);
		} else {
			// DB
			return $tokens = array(
				"access_token" => $token_data['oauth_token'],
				"token_secret" => $token_data['oauth_token_secret'],			
				"customer_id" => $token_data['customer_id'],			
				"screen_name" => $token_data['screen_name']
			);
		}
	}

	public function upload_image($image_data, $client)
	{
		try{
			$params = array(
				'media_data' => $image_data,
				'media_category' => 'tweet_image'
			);
			$result = $client->post_media('media/upload', $params);
			return $result;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public function post_tweet($client, $twittContent, $media)
	{
		try{
			$params = array(
				'status' => $twittContent,
				'media_ids' => $media
			);
			$result = $client->post('statuses/update', $params);
			return $result;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public function schedule_post($client, $postContent) {
		$url = "accounts/{$postContent['account_id']}/scheduled_tweets";
		//return $url;
		try{
			$params = array(
				'account_id' => $postContent['account_id'],
				'scheduled_at' => $postContent['scheduled_at'],
				'as_user_id' => $postContent['as_user_id'],
				'text' => $postContent['text'],
				'media_keys' => $postContent['media_keys']
			);
			$result = $client->post($url, $params);
			return $result;
		}catch(Exception $e){
			return $e->getMessage();
		}	
	}

	public function get_account($client) {
		try{
			$result = $client->get_schedule('accounts'); 
			return $result;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public function getHtmlForUnauth($user_id)
	{
		
		$this->redirect_uri = base_url() . 'api/twitter-access';

		$client = $this->getClient();
		$request_token = $client->getRequestToken($this->redirect_uri);

		$htmlBody = '<h2>Setup your Twitter Account:</h2>
			<p>+ Please login to your Twitter Account</p>';

		$newdata = array(
			'oauth_token' => $request_token['oauth_token'], // Temp Token
			'oauth_token_secret' => $request_token['oauth_token_secret'] // Temp Secret
		);

		$this->CI->session->set_userdata($newdata);

		switch ($client->http_code) {
			case 200:
				$loginUrl = $client->getAuthorizeURL($request_token['oauth_token']);
				$htmlBody .= '<a class="it_btn" href="'.$loginUrl.'">CLICK HERE</a>';
				break;
			default:
			$htmlBody .= 'Could not connect to Twitter. Refresh the page or try again later.';
		}

		return $htmlBody;
	}
	
	public function getLoginUrl(){
		
		$this->redirect_uri = base_url() . 'api/twitter_access';

		$client = $this->getClient();
		
		$request_token = $client->getRequestToken($this->redirect_uri);
		
		$htmlBody = '<h2>Setup your Twitter Account:</h2>
			<p>+ Please login to your Twitter Account</p>';

		$newdata = array(
			'oauth_token' => isset($request_token['oauth_token']) ? $request_token['oauth_token'] : '', // Temp Token
			'oauth_token_secret' => isset($request_token['oauth_token_secret']) ? $request_token['oauth_token_secret'] : '' // Temp Secret
		);

		$this->CI->session->set_userdata($newdata);
		$loginUrl = '';
		switch ($client->http_code) {
			case 200:
				$loginUrl = $client->getAuthorizeURL($request_token['oauth_token']);
				$htmlBody .= '<a class="ha_btn" href="'.$loginUrl.'">CLICK HERE</a>';
				break;
			default:
			$htmlBody .= 'Could not connect to Twitter. Refresh the page or try again later.';
		}

		return $loginUrl;

	}

	public function getHtmlForAuth($user_id, $token)
	{
		$is_valid_key = $this->setupTokenData($token[0],true);

		$htmlBody = '';
		// check is file valid and set access token
		if($is_valid_key["oauth_token"] && $is_valid_key["oauth_token_secret"]) {
			$client = $this->getClient();
			$client = $this->getClientAuth2($is_valid_key["oauth_token"], $is_valid_key["oauth_token_secret"]);

			$get_profile = $client->get('users/show', array('user_id' => $is_valid_key["customer_id"])); 
			if (isset($get_profile->errors[0]->message)) {
				return $this->getHtmlForUnauth($user_id);
			} else {
				$htmlBody .= "<h2>Twitter Account</h2>";
				
				$htmlBody .= '<img class="sw_auth_img" src="'.$get_profile->profile_image_url.'" alt="'.$get_profile->name.'"><br />';	
				$htmlBody .= '<h3 class="sw_auth_name">' . $get_profile->name . '</h3>';	

				$htmlBody .= user_setup_form_logout('twitter');

				$screen_name = json_encode(array('name' => $get_profile->name, 'user_name' => $get_profile->screen_name));
				update_blog_details("twitter",$screen_name,$screen_name);
			}	
			// exit;
		} else {
			// echo "not valid";		
		}

		return $htmlBody;
	}
}