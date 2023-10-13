<?php
defined('BASEPATH') OR exit('Access Denied');

require_once APPPATH . 'third_party/Facebook/autoload.php';

class Facebook {
    protected $CI;

    //Grafikky facebook app
    private $app_id = '525129846194033';
    private $app_secret = '30db981a9525789514aefdca39d89465';
    private $default_graph_version = 'v5.0';
    private $redirect_uri = '';
    
    public function __construct() {
        $this->CI = &get_instance();
    }

    public function getFBClient()
    {
        $fb = new Facebook\Facebook([
            'app_id' => $this->app_id, 
            'app_secret' => $this->app_secret,
            'default_graph_version' => 'v5.0',
        ]);

        return $fb;
    }

    public function getLoginUrl() {
		$this->redirect_uri = base_url() . 'api/facebook_access';
		
        $fb = $this->getFBClient();

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email','pages_show_list','pages_manage_posts', 'pages_read_engagement']; // Optional permissions
        $loginUrl = $helper->getLoginUrl($this->redirect_uri, $permissions);

        return htmlspecialchars($loginUrl);
    }
	
	public function getLogoutUrl() {
		$this->redirect_uri = base_url() . 'api/facebook_access';
		
        //return user_setup_form_logout('facebook');

        //return htmlspecialchars($loginUrl);
    }

    public function getAccessToken() {
        
		$fb = $this->getFBClient();
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                return "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                return 'Bad request';
            }
        }

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId($this->app_id); 
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
          // Exchanges a short-lived access token for a long-lived one
          try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                return "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
            }
        }

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name,email', $accessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        $user = $response->getGraphUser();
		
        $id = $user->getId();
        $email = $user->getEmail();
        $name = $user->getName();

        $return = array('id' => $id, 'name' => $name, 'email' => $email, 'access_token' => $accessToken);
        return $return;
    }
	
	public function getAllPages($accessToken)
	{
		$fb = $this->getFBClient();
		
		try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me/accounts', $accessToken);
			//print_r($response);
            //$pagesEdge = $response->getGraphEdge();
            //return $graphnode = $pagesEdge->getGraphNode();
            $data = $response->getBody();
			return json_decode($data, true);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
		
	}

    public function uploadPhoto($page_id, $access_token, $url, $title, $content)
    {
        $fb = $this->getFBClient();

		$params = array(
			"url" => $url,
			"published" => false
		);

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post( '/'.$page_id.'/photos', $params, $access_token );

            $graphNode = $response->getGraphNode();
            return json_decode($graphNode, true);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }
	
	public function publishMultiPhotoStory($page_id, $caption, $photoIdArray, $access_token){
			$fb = $this->getFBClient();
            $params = array( "message" => $caption );
            foreach($photoIdArray as $k => $photoId) {
                $params["attached_media"][$k] = '{"media_fbid":"' . $photoId . '"}';
            }
            try {
                $response = $fb->post('/'.$page_id.'/feed', $params, $access_token);
				$graphNode = $response->getGraphNode();
				return json_decode($graphNode, true);
            } catch (FacebookResponseException $e) {
                // display error message
                return $e->getMessage();
                exit();
            } catch (FacebookSDKException $e) {
                return $e->getMessage();
                exit();
            }

    }

    public function createPost($page_id, $access_token, $url, $title, $content)
    {
        $fb = $this->getFBClient();
        
        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->post(
                '/'.$page_id.'/feed',
                array (
                  'link' => $url,
                  'message' => $content,
                  'published' => '1'
                ),
                $access_token
            );
            
            $graphNode = $response->getGraphNode();
            return json_decode($graphNode, true);
        } catch(FacebookExceptionsFacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(FacebookExceptionsFacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }

    public function schedulePost($page_id, $access_token, $postData)
    {
        $fb = $this->getFBClient();
        
        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->post(
                '/'.$page_id.'/photos',
                array (
                    'caption' => $postData['title'],
                    'url' => $postData['url'],
                    'published' => 'false',
                    'scheduled_publish_time' => $postData['publish_time']
                ),
                $access_token
            );
            
            $graphNode = $response->getGraphNode();
            return json_decode($graphNode, true);
        } catch(FacebookExceptionsFacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(FacebookExceptionsFacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }
	
	public function getHtmlForAuth($user_id, $token)
	{
		$client = $this->getFBClient();
		$htmlBody = '';
		
		$pages = $this->getAllPages($token[0]['access_token']);
		
		$htmlBody .= "<h2>Facebook Account</h2>";
		
		if( is_array($pages) ){
	        $pagedata = array();
	        $htmlBody .= "<h3>Pages:</h3>";
	        if( isset($pages['data']) ){
	            foreach($pages['data'] as $page){
	                $pagedata[] = array('page_id' => $page['id'], 'access_token' => $page['access_token'], 'name' => $page['name']);
	                $htmlBody .= "<h4>".$page['name']."</h4>";
	            }
	        }else{
	            $htmlBody .= "<h4>You don't have any pages on this account</h4>";
	        }
	        $htmlBody .= user_setup_form_logout('facebook');

	        $pagedata = json_encode($pagedata);
	        update_blog_details("facebook",false,$pagedata);
	    }else{
            $htmlBody .= user_setup_form_logout('facebook');
        }
	    
	    return $htmlBody;
	}
	
	public function getHtmlForUnauth($user_id)
	{
		$authUrl = $this->getLoginUrl();
		if(is_array($authUrl)){
			$htmlBody = $authUrl['error'];
		}else{
			$htmlBody = '<h2>Setup your Facebook Account:</h2>
			<p>+ Please login to your Facebook Account</p>
			<a class="it_btn" href="'.$authUrl.'">CLICK HERE</a>';
		}
		
		return $htmlBody;
	}

}
