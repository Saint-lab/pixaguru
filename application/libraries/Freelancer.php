<?php
defined('BASEPATH') OR exit('Access Denied');

class Freelancer {
    protected $CI;
    private $client_id = "cf7de68e-4a5b-48cd-947b-283527f17094";
    private $client_secret = "878ff28f919ee6873a92413a8f14582394a8f61aff58d3b87c4143bc70000cb11271c16887271dd5452fb8ea5c300c9255692eb2a47d1c0f6fbf987faa0d6c33";
    private $redirect_uri = '';
    private $auth_url = 'https://accounts.freelancer.com';
    private $api_url = 'https://www.freelancer.com';
    
    public function __construct() {
        $this->CI = &get_instance();
    }

    public function get_request($url, $headers=array())
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        if( !empty($headers) ){
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => USER_AGENT,
                CURLOPT_HTTPHEADER => $headers
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
        
        if($http_status != 200){
            $error = 'Request Error:' . curl_error($curl);
            return json_encode(array('error' => 1, 'error_description' => $error));
        }

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

    public function getAuthUrl(){
        $this->redirect_uri = base_url() . 'api/freelancer-access';

        $params = array(
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'scope' => 'basic',
            'prompt' => 'select_account',
            'advanced_scopes' => '1 2 6'
        );

        $url = $this->auth_url . "/oauth/authorize?" . http_build_query($params);

        return $url;
    }

    public function getAccessToken($code)
    {
        $this->redirect_uri = base_url() . 'api/freelancer-access';

        $params = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri
        );

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';

        $url = $this->auth_url . "/oauth/token";
        $data = $this->post_request($url, $params, '', $headers);

        return json_decode($data, true);
    }

    public function regenerateToken($refresh_token)
    {
        $this->redirect_uri = base_url() . 'api/freelancer-access';

        $params = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri
        );

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';

        $url = $this->auth_url . "/oauth/token";
        $data = $this->post_request($url, $params, '', $headers);

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
        $url = $this->api_url .'/api/users/0.1/self/';
        $headers = array();
        $headers[] = "Freelancer-Oauth-V1: {$access_token}";

        $data = $this->get_request($url, $headers);

        return json_decode($data, true);
    }

    public function searchJobs($access_token, $keywords)
    {
        $params = array(
            'job_names[]' => $keywords
        );

        $url = $this->api_url .'/api/projects/0.1/jobs/search/?' . http_build_query($params);
        $headers = array();
        $headers[] = "Freelancer-Oauth-V1: {$access_token}";

        $data = $this->get_request($url, $headers);

        return json_decode($data, true);
    }

    public function searchProjects($access_token, $keywords)
    {
        $params = array(
            'query' => $keywords,
            'location_details' => true,
            'user_details' => true,
            'user_country_details' => true,
            'user_location_details' => true,
            'limit' => 50
        );

        $url = $this->api_url .'/api/projects/0.1/projects/active/?' . http_build_query($params);
        $headers = array();
        $headers[] = "Freelancer-Oauth-V1: {$access_token}";

        $data = $this->get_request($url, $headers);

        return json_decode($data, true);
    }

    public function listCategories($access_token)
    {
        $url = $this->api_url .'/api/projects/0.1/categories/';
        $headers = array();
        $headers[] = "Freelancer-Oauth-V1: {$access_token}";

        $data = $this->get_request($url, $headers);

        return json_decode($data, true);
    }

    public function getHtmlForUnauth($user_id)
    {
        $authUrl = $this->getAuthUrl();
        if(is_array($authUrl)){
            $htmlBody = $authUrl['error'];
        }else{
            $htmlBody = '<h2>Setup your Freelancer Account:</h2>
            <p>+ Please login to your Freelancer Account</p>
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
            if( isset($token['access_token']) ) {
                $access_token = $token['access_token'];
                $token_data = $this->setupTokenData($token);
                insert_new_token("freelancer", $token_data);
            }
        }else{
            $access_token = $token[0]['access_token'];
        }
        
        $profile = $this->getUserProfile($access_token);

        if( isset($profile['result']['display_name']) ){
            $name = $profile['result']['display_name'];
            // Success Print User Blog Data
            $htmlBody .= "<h2>Freelancer Account</h2>";
            $htmlBody .= "<h3>".$name."</h3>";

            $htmlBody .= user_setup_form_logout('freelancer');
            // Update Screen Name & Thumb in DB
            $screen_name = json_encode(array('name' => $name));
            update_blog_details("freelancer",$screen_name,$screen_name);
        }
        
        return $htmlBody;
    }
    
}
