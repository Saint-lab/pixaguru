<?php
defined('BASEPATH') OR exit('Access Denied');

class Guru {
    protected $CI;
    private $client_id = "GCLI03142407T";
    private $client_secret = "4B6C296C-10A6-473E-9190-A7C1AB1AD44A";
    private $redirect_uri = '';
    
    public function __construct() {
        $this->CI = &get_instance();
    }

    public function getAccessToken()
    {
    	$curl = curl_init();    

    	curl_setopt_array($curl, array(  
    		CURLOPT_URL => "https://www.guru.com/api/v1/oauth/token/access",    
    		CURLOPT_RETURNTRANSFER => true,    
    		CURLOPT_ENCODING => "",    
    		CURLOPT_MAXREDIRS => 10,    
    		CURLOPT_TIMEOUT => 30,    
    		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,    
    		CURLOPT_CUSTOMREQUEST => "PUT",    
    		CURLOPT_POSTFIELDS => "client_secret={$this->client_secret}&grant_type=client_credentials&client_id={$this->client_id}",  
    	));

    	$response = curl_exec($curl);  
    	$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    	$err = curl_error($curl);    
    	curl_close($curl);  

    	if($http_status == 404){
            return json_encode(array('error' => 1, 'error_description' => 'Request Error: 404'));
        }

        if($err){    
    		return json_encode(array('error' => 1, 'error_description' => $err));
    	}
        
        if($http_status != 200){
            $error = 'Request Error:' . curl_error($curl);
            return json_encode(array('error' => 1, 'error_description' => $error));
        }

        return $response;
    }

    public function getNewAccessToken($refreshToken)
    {
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://www.guru.com/api/v1/oauth/token/access",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "refresh_token={$refreshToken}&client_id={$this->client_id}&grant_type=refresh_token",
		));

		$response = curl_exec($curl);
		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		$err = curl_error($curl);
		curl_close($curl);

		if($http_status == 404){
            return json_encode(array('error' => 1, 'error_description' => 'Request Error: 404'));
        }

        if($err){    
    		return json_encode(array('error' => 1, 'error_description' => $err));
    	}
        
        if($http_status != 200){
            $error = 'Request Error:' . curl_error($curl);
            return json_encode(array('error' => 1, 'error_description' => $error));
        }

        return $response;
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
            "token_type" => $token['token_type'],
            "customer_id" => $token['client_id'],
            "blog_config" => json_encode($token)     
        );

        return $token_data;
    }

    public function authenticate()
    {
        $result_enc = $this->getAccessToken();
        $result = json_decode($result_enc, true);

        if(isset($result['access_token'])){
            $token_data = $this->setupTokenData($result);

            if(insert_new_token("guru",$token_data)) {
                return array('status' => 1, 'msg' => '', 'data' => $token_data );
            }
        }else{
            return array('status' => 0, 'msg' => 'Something went wrong.', 'data' => $result );
        }
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

    public function searchProjects($token, $keywords)
    {
    	$access_token = '';
        if($this->isTokenExpired($token)){
            $result = $this->getNewAccessToken($token[0]['refresh_token']);
            $token = json_decode($result, true);
            if( isset($token['access_token']) ) {
                $access_token = $token['access_token'];
                $token_data = $this->setupTokenData($token);
                insert_new_token("guru", $token_data);
            }
        }else{
            $access_token = $token[0]['access_token'];
        }

        $params = array(
            'pagenumber' => 1,
            'pagesize' => 10,
            'sorttype' => 0,
            'searchterm' => $keywords,
            'submittedBys' => '',
            'agreementTypes' => '',
            'employerSpends' => 4,
            'quoteStatus' => 1,
            'quotesFilter' => 'all'
        );

        $url = "https://www.guru.com/api/v1/freelancer/quotes/filter/" . join("/", $params);
        $headers = array();
        $headers[] = "Authorization: Bearer {$access_token}";
        $headers[] = "Content-Type: application/json";

        $data = $this->get_request($url, $headers);

        return json_decode($data, true);
    }
    
}
