<?php
include_once APPPATH . 'third_party/linkedin/vendor/autoload.php';
// import client class
use GuzzleHttp\Client;

/**
*   Linkedin Class
*/
#[\AllowDynamicProperties]
class Linkedin
{
	private $client_id = '77zqw6pocjgfnv'; // Enter your Client ID here
	private $client_secret = '06S7ieUfLUmvapIY'; // Enter your Client Secret here
	private $redirect_uri;
	public $errors = array();
	
	public function __construct() {
        $this->CI = &get_instance();
    }

    public function post_request($url, $postdata="", $method='', $headers=array())
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
		$client = new Client(['base_uri' => 'https://www.linkedin.com']);
		return $client;
	}
	
	public function getAuthClient()
	{
		$client = new Client(['base_uri' => 'https://api.linkedin.com']);
		return $client;
	}
	
	public function getProfile($client) {
		$profile = $client->get(
			'people/~:(id,email-address,first-name,last-name)'
		);
		$output = "<h3>Email: " . $profile['emailAddress'] . "</h3>";
		$output .= "<h3>First Name: " . $profile['firstName'] . "</h3>";
		$output .= "<h3>Last Name: " . $profile['lastName'] . "</h3>";
		
		return $output;
	}
	
	//Share post with Image Latest code
	public function share_post_with_image($title,$description,$image_url,$access_token,$linkedin_id) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.linkedin.com/v2/shares',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"content": {
				"contentEntities": [
					{
						"entityLocation": "https://viralbag.in/",
						"thumbnails": [
							{
								"resolvedUrl": "'.$image_url.'"
							}
						]
					}
				],
				"title": "'.$title.'"
			},
			"distribution": {
				"linkedInDistributionTarget": {}
			},
			"owner": "urn:li:person:'.$linkedin_id.'",
			"subject": "Qute Generator",
			"text": {
				"text": "'.$title.'"
			}
		}',
		  CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer '.$access_token,
			'Content-Type: application/json',
			'Cookie: bcookie="v=2&5546720f-8de1-45d1-8048-d0ae069d8247"'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
		
	}
	
	public function newPostv($title,$description,$image_url,$access_token,$linkedin_id)
	{
		//echo $access_token; die();
		$body = new \stdClass();
		
		$body->author = 'urn:li:person:'.$linkedin_id;
		$body->lifecycleState = 'PUBLISHED';
		
		$specificCon = new \stdClass();
		$specificCon->shareCommentary['text'] = $title;
		$specificCon->shareMediaCategory = 'ARTICLE';
		
		$m['status'] = 'READY';
		$m['description']['text'] = '';
		$m['originalUrl'] = $image_url;
		$m['title']['text'] = $title;
		
		
		$specificCon->media = array( (object) $m );
		
		$body->specificContent['com.linkedin.ugc.ShareContent'] = $specificCon;
		$body->visibility['com.linkedin.ugc.MemberNetworkVisibility'] = 'PUBLIC';
		$body_json = json_encode($body, true);
		
		try {
			$client = new Client(['base_uri' => 'https://api.linkedin.com']);
			$response = $client->request('POST', '/v2/ugcPosts', [
				'headers' => [
					"Authorization" => "Bearer " . $access_token,
					"Content-Type"  => "application/json",
					"x-li-format"   => "json",
					"x-restli-protocol-version: 2.0.0"
				],
				'body' => $body_json,
			]);
		 
			if ($response->getStatusCode() !== 201) {
				return $response->getLastBody()->errors[0]->message;
			}
			
			$data = json_decode($response->getBody()->getContents(), true);
		 
			return $data;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	public function upload_file($upload_url, $image, $access_token)
	{	
		$params = array(
			'upload-file' => $image
		);

		$encparams = json_encode($params, true);

		$headers = array();
        $headers[] = 'authorization: Bearer '. $access_token;
        $headers[] = 'Content-Type: application/json';

        $result = $this->post_request($upload_url, $encparams, '', $headers);

        return $result;
	}

	public function register_image($access_token,$linkedin_id)
	{
		$body = new \stdClass();
		
		$body->registerUploadRequest["recipes"] = array("urn:li:digitalmediaRecipe:feedshare-image");
		$body->registerUploadRequest["owner"] = 'urn:li:person:'.$linkedin_id;

		$r['relationshipType'] = 'OWNER';
		$r['identifier'] = 'urn:li:userGeneratedContent';

		$body->registerUploadRequest["serviceRelationships"] = array( (object) $r );
		$body_json = json_encode($body, true);

		$headers = array();
        $headers[] = 'authorization: Bearer '. $access_token;
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'x-li-format: json';
        $headers[] = 'x-restli-protocol-version: 2.0.0';

        $url = "https://api.linkedin.com/v2/assets?action=registerUpload";
        $result = $this->post_request($url, $body_json, '', $headers);

        return json_decode($result, true);
	}

	public function share_image($title,$description,$media_asset,$access_token,$linkedin_id)
	{
		$body = new \stdClass();
		
		$body->author = 'urn:li:person:'.$linkedin_id;
		$body->lifecycleState = 'PUBLISHED';
		
		$specificCon = new \stdClass();
		$specificCon->shareCommentary['text'] = $title;
		$specificCon->shareMediaCategory = 'IMAGE';
		
		$m['status'] = 'READY';
		$m['description']['text'] = $description;
		$m['media'] = $media_asset;
		$m['title']['text'] = $title;
		
		$specificCon->media = array( (object) $m );
		
		$body->specificContent['com.linkedin.ugc.ShareContent'] = $specificCon;
		$body->visibility['com.linkedin.ugc.MemberNetworkVisibility'] = 'PUBLIC';
		$body_json = json_encode($body, true);
		
		try {
			$client = new Client(['base_uri' => 'https://api.linkedin.com']);
			$response = $client->request('POST', '/v2/ugcPosts', [
				'headers' => [
					"Authorization" => "Bearer " . $access_token,
					"Content-Type"  => "application/json",
					"x-li-format"   => "json",
					"x-restli-protocol-version: 2.0.0"
				],
				'body' => $body_json,
			]);
		 
			if ($response->getStatusCode() !== 201) {
				return $response->getLastBody()->errors[0]->message;
			}
			
			$data = json_decode($response->getBody()->getContents(), true);
		 
			return $data;
		} catch(Exception $e) {
			echo $e->getMessage();
			return $e->getMessage();
		}
	}
	
	public function setupTokenData($token_data,$switch=false)
	{
		if ($switch==true) {
			return $token_data = array(
				"token" => $token_data['access_token'],
				"expiresAt" => $token_data['expires_at'],			
			);
		} else {
			return $token_data = array(
				"access_token" => $token_data['access_token'],
				"expires_in" => $token_data['expires_in'],			
			);
		}
	}
	
	public function getNewAccessToken($code, $client)
	{
		$redirect_url = base_url() . 'api/linkedin_access'; 
		
		$data = '';
		
		try {
			$response = $client->request('POST', '/oauth/v2/accessToken', [
				'form_params' => [
						"grant_type" => "authorization_code",
						"code" => $code,
						"redirect_uri" => $redirect_url,
						"client_id" => $this->client_id,
						"client_secret" => $this->client_secret,
				],
			]);
			$data = json_decode($response->getBody()->getContents(), true);
		} catch(Exception $e) {
			return $e->getMessage();
		}
		
		return $data;
		
	}
	
	public function getAuthUrl()
	{
		$redirect_url = base_url() . 'api/linkedin_access';
		// define desired list of scopes
		$scopes = 'r_emailaddress,r_liteprofile,w_member_social';
		
		$state = substr(str_shuffle("0123456789abcHGFRlki"), 0, 10);
		
		$loginUrl = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=".$this->client_id."&redirect_uri=".$redirect_url."&scope=".$scopes."&state=".$state;
		
		return $loginUrl;
	}
	
	public function getHtmlForUnauth($user_id)
	{
		$loginUrl = $this->getAuthUrl();
		
		$htmlBody = '<h2>Setup your LinkedIn Account:</h2>
		<p>+ Please login to your LinkedIn Account</p>
		<a class="it_btn" href="'.$loginUrl.'">CLICK HERE</a>';
		
		return $loginUrl;
	}
	
	public function getLoginUrl()
	{
		$loginUrl = $this->getAuthUrl();
		return $loginUrl;
	}
	
	public function getHtmlForAuth($user_id, $token)
	{
		$htmlBody = '';
		try {           
			$access_token = $token[0]['access_token'];
			// GET PROFILE INFO
            $htmlBody .= '<h2>LinkedIn Account</h2>';
			
			$client = new Client(['base_uri' => 'https://api.linkedin.com']);
			$response = $client->request('GET', '/v2/me', [
				'headers' => [
					"Authorization" => "Bearer " . $access_token,
				],
			]);
			
			$profile = json_decode($response->getBody()->getContents(), true);
			
			if ( isset($profile['pictureUrl']) ) {
				$htmlBody .= "<img src=\"". $profile['pictureUrl'] . "\" title=\"LinkedIn\" /><br />";
			}else{
				$profile['pictureUrl'] = '';
			}
			
			$htmlBody .= "<h3 class=\"sw_auth_name\">" . $profile['localizedFirstName'] . " " . $profile['localizedLastName'] . "</h3>";
			
			// PUT PROFILE INFO IN JSON
			$name = $profile['localizedFirstName']." ".$profile['localizedLastName'];
			$screen_name = json_encode( array('name' => $name, 'id' => $profile['id']) );
			
			update_blog_details("linkedin",$screen_name,$screen_name);
			
			$htmlBody .= user_setup_form_logout('linkedin');
            
        } catch(Exception $e) {
			$htmlBody .= $e->getMessage();
			$htmlBody .= user_setup_form_logout('linkedin');
		}
		
		return $htmlBody;
	}
}