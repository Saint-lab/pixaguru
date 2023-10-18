<?php
defined('BASEPATH') OR exit('Access Denied');

require_once APPPATH . 'third_party/Facebook/autoload.php';

class Instagram {
    protected $CI;

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
		$this->redirect_uri = base_url() . 'api/instagram_access';
		
        $fb = $this->getFBClient();

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email','pages_show_list', 'instagram_basic', 'instagram_content_publish']; // Optional permissions
        $loginUrl = $helper->getLoginUrl($this->redirect_uri, $permissions);

        return htmlspecialchars($loginUrl);
    }

    public function getAccessToken()
    {
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
                //echo "Error: " . $helper->getError() . "\n";
                //echo "Error Code: " . $helper->getErrorCode() . "\n";
                //echo "Error Reason: " . $helper->getErrorReason() . "\n";
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
           // $response = $fb->get('/me?fields=id,name,email', $accessToken);
			$response = $fb->get('/me/accounts?fields=connected_instagram_account,name', $accessToken);
			
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return 'Graph returned an error:--- ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }

       $data = $response->getBody();
	   $user = json_decode($data, true);
		
        //$email = $user->getEmail();
        $name = $user['data'][0]['name'];
        $insta_userid = $user['data'][1]['connected_instagram_account']['id'];
        
        $token = array(
            'token' => $accessToken->getValue(),
            //'expireTime' => $accessToken->getExpiresAt()
        );

        $return = array('name' => $name, 'userid' => $insta_userid, 'access_token' => $token);
        return $return;
    }

    public function getAllPages($accessToken)
	{
		$fb = $this->getFBClient();
		
		try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me/accounts?fields=connected_instagram_account,name,picture{url}', $accessToken);
            
            //return $pagesEdge = $response->getGraphEdge();
            //return $graphnode = $response->getGraphNode();
            $data = $response->getBody();
			return json_decode($data, true);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
		
	}

    public function uploadPhoto($in_user_id, $access_token, $url, $title)
    {
        $fb = $this->getFBClient();

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post(
                '/'.$in_user_id.'/media',
                array (
                    'caption' => html_entity_decode($title),
                    'image_url' => $url
                ),
                $access_token
            );

            $graphNode = $response->getGraphNode();
            return json_decode($graphNode, true);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }
    
    public function uploadVideo($in_user_id, $access_token, $url, $title)
    {
        $fb = $this->getFBClient();

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post(
                '/'.$in_user_id.'/media',
                array (
                    'media_type' => 'VIDEO',
                    'caption' => html_entity_decode($title),
                    'video_url' => $url
                ),
                $access_token
            );

            $graphNode = $response->getGraphNode();

            $result = json_decode($graphNode, true);

            if(isset($result['id'])){
                $a = true;
                while($a){
                    $response = $fb->get(
                        '/'.$result['id'].'?fields=status,status_code',
                        $access_token
                    );

                    $data = json_decode($response->getBody(), true);
			        if($data['status_code'] == 'PUBLISHED' || $data['status_code'] == 'FINISHED'){
                        $a = false;
                    }elseif($data['status_code'] == 'ERROR'){
                        $a = false;
                        $result = $data['status'];
                    }  
                    sleep(10);
                }
            }

            return $result;
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }
    
    public function uploadMultiplePhoto($in_user_id, $access_token, $urls, $title)
    {
        $fb = $this->getFBClient();

        try {
            // Returns a `Facebook\FacebookResponse` object
            $idcontainer = array();
            for($i=0;$i<count($urls);$i++){
                $response = $fb->post(
                    '/'.$in_user_id.'/media',
                    array (
                        'is_carousel_item' => true,
                        'image_url' => $urls[$i]
                    ),
                    $access_token
                );
                $r = $response->getGraphNode();
                $dr = json_decode($r, true);
                if(isset($dr['id'])){
                    $idcontainer[] = $dr['id'];
                }
            }

            if(!empty($idcontainer)){
                $response = $fb->post(
                    '/'.$in_user_id.'/media',
                    array (
                        'media_type' => 'CAROUSEL',
                        'children' => $idcontainer,
                        'caption' => $title
                    ),
                    $access_token
                );
            }

            $graphNode = $response->getGraphNode();
            return json_decode($graphNode, true);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }

    public function publishPhoto($in_user_id, $access_token, $creation_id)
    {
        $fb = $this->getFBClient();

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post(
                '/'.$in_user_id.'/media_publish',
                array (
                    'creation_id' => $creation_id
                ),
                $access_token
            );

            $graphNode = $response->getGraphNode();
            return json_decode($graphNode, true);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }
	
	public function get_permalink_of_media($postID, $access_token){
		 
		$fb = $this->getFBClient();

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/'.$postID.'?fields=permalink', $access_token);
			$data = $response->getBody();
			return json_decode($data, true);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
	}
}