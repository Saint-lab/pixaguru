<?php
include('FB_Basic/autoload.php');
include('FB_Ads/autoload.php');

if (!function_exists('get_userdata')){
    function get_userdata($key){
        $CI = get_instance();
        $CI->load->library('session');
        return $CI->session->userdata($key);
    }
}

define('APP_ID', get_userdata( 'facebook_app_id' )); // FaceBook App Id

define('APP_SECRET', get_userdata( 'facebook_app_secret' )); // FaceBook App Secret Key

define('DOMAIN_URL', base_url().'profile'); // Domain on which you are going to use , with trailing slash

/* accessMyProfileDetail */
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
/* accessMyProfileDetail */

/*get_image_hash */
use FacebookAds\Object\AdImage;
use FacebookAds\Object\Fields\AdImageFields;
/*get_image_hash */

/* create_campaign */
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
/* create_campaign */

/* create_adset */
use FacebookAds\Object\TargetingSearch;
use FacebookAds\Object\Search\TargetingSearchTypes;
use FacebookAds\Object\Targeting;
use FacebookAds\Object\Fields\TargetingFields;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Values\AdSetBillingEventValues;
use FacebookAds\Object\Values\AdSetOptimizationGoalValues;
/* create_adset */

/* adcreative */
use FacebookAds\Object\Fields\AdFields;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\AdCreativeLinkData;
use FacebookAds\Object\Fields\AdCreativeLinkDataChildAttachmentFields;
use FacebookAds\Object\AdCreativeLinkDataChildAttachment;
use FacebookAds\Object\Fields\AdCreativeLinkDataFields;
use FacebookAds\Object\AdCreativeObjectStorySpec;
use FacebookAds\Object\Fields\AdCreativeObjectStorySpecFields;
use FacebookAds\Object\Fields\AdCreativeFields;
/* adcreative */

/* AdAccount */
use FacebookAds\Object\AdAccount;
/* AdAccount */

use FacebookAds\Api;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdUser;

function facebook_init( $access_token ){
	Api::init(
		APP_ID, 
		APP_SECRET,
		$access_token // Your user access token
	);
}

function get_login_url( $permissions ){
	$fb = new Facebook([
	  'app_id' => APP_ID,
	  'app_secret' => APP_SECRET,
	]);

	$helper = $fb->getRedirectLoginHelper();
	
	$loginUrl = $helper->getLoginUrl( DOMAIN_URL, $permissions);
	
	return $loginUrl;
}

function get_access_token(){
	$fb = new Facebook([
		'app_id' => APP_ID,
		'app_secret' => APP_SECRET,
	]);
	
	$helper = $fb->getRedirectLoginHelper();

	try {
	  $access_token = (string) $helper->getAccessToken();
	} catch(FacebookResponseException $e) {
		return array( 'status' => 0, 'msg' => 'Graph returned an error: ' . $e->getMessage() );
	}catch(FacebookSDKException $e) {
		return array( 'status' => 0, 'msg' => 'Facebook SDK returned an error: ' . $e->getMessage() );
	}
	return array( 'status' => 1, 'access_token' => $access_token );
}

function get_long_time_access_token( $access_token ){
	$url = 'https://graph.facebook.com/oauth/access_token?client_id='.APP_ID.'&client_secret='.APP_SECRET.'&grant_type=fb_exchange_token&fb_exchange_token='.$access_token;
	$tokenData = file_get_contents($url);
	$resp = json_decode($tokenData, true);
	if(isset($resp['error'])){
		return array( 'status' => 0, 'msg' => $resp['error']['message'] );
	}else{
		return array( 'status' => 1, 'access_token' => $resp['access_token'] );
	}
}

function get_profile_details( $access_token ) {
	$fb = new Facebook([
		'app_id' => APP_ID,
		'app_secret' => APP_SECRET,
	]);
	try {        
		$resp = $fb->get('/me?fields=id,name,email,picture', $access_token);
	} catch(FacebookResponseException $e) {
		return 'Graph returned an error: ' . $e->getMessage();
	} catch(FacebookSDKException $e) {
		return 'Facebook SDK returned an error: ' . $e->getMessage();
	}
	$user = $resp->getGraphUser();
	return $user;
}

function get_page_list( $access_token ){
	$fb = new Facebook([
	  'app_id' => APP_ID,
	  'app_secret' => APP_SECRET,
	]);
	
	$pages = [];
	try {
		$resp = $fb->get('/me/accounts?fields=id,name,likes,picture{url},is_published&limit=100000', $access_token);
		$results = $resp->getGraphEdge();
		foreach ($results as $result) {        
			if ($result['is_published']) {
				if (empty($result['likes'])) $result['likes'] = 0;
				$pages[ $result['id'] ] = array( 'pic' => $result['picture']['url'], 'name' => $result['name'] );
			}
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	return $pages;
}

function get_account_id( $user_id ){
	$me = new AdUser($user_id);
	$my_adaccount = $me->getAdAccounts()->current();
	$account_details = $my_adaccount->getData();
	$account_id = $account_details['account_id'];
	return $account_id;
}

function get_image_hash( $account_id, $image_path ){
	$image = new AdImage(null, 'act_'.$account_id);
	$image->{AdImageFields::FILENAME} = $image_path;

	$image->create();
	return $image->{AdImageFields::HASH}.PHP_EOL;
}

function create_campaign( $account_id, $j_data ){
	$campaign = new Campaign(null, 'act_'.$account_id);
	$campaign->setData(array(
	  CampaignFields::NAME => $j_data['campaign'],
	  CampaignFields::OBJECTIVE => $j_data['objective'],
	));
	
	$campaign->create(array(
	  Campaign::STATUS_PARAM_NAME => $j_data['status'], // or ACTIVE
	));
	$campaign_arr = $campaign->getData();
	return $campaign_arr['id'];
}

function create_adset( $account_id, $j_data, $campaign_id ){
	$targeting = new Targeting();
	
	$country = $j_data['country'];
	
	$location = array(
		'countries' => $country
	);
	
	if(!empty($j_data['city']) && $j_data['city'][0] != 'none'){
		$city = array();
		for($g=0;$g<count($j_data['city']);$g++){
			$city[] = array(
				'key' => $j_data['city'][$g],
				'radius' => $j_data['radius'],
				'distance_unit' => $j_data['distance_unit'],
			);
		}
		$location['cities'] = $city;
	}
	
	$targeting->{TargetingFields::GEO_LOCATIONS} = $location;
	
	if( $j_data['gender'] != 'All' )  {
		$targeting->{TargetingFields::GENDERS} =
			array(
				$j_data['gender']
		);
	}
	
	$targeting->{TargetingFields::AGE_MIN} =$j_data['min_age'];
	$targeting->{TargetingFields::AGE_MAX} =$j_data['max_age'];
	 
	$interest_arr = explode(',',$j_data['interest']);
	$final_in_array = array();
	for($i=0;$i<count($interest_arr);$i++) {
		$interest = trim($interest_arr[$i]);
		
		$result = TargetingSearch::search(
			TargetingSearchTypes::INTEREST,
			null,
		$interest);
		
		for( $j=0; $j<count($result); $j++ ) {
			$in_arr = array();
			$a = ((array)$result[$j]);
			foreach($a as $k=>$v){
				if(strpos($k,'data') && isset($v['id'])) {
					$in_arr['id'] = $v['id'];						
					$in_arr['name'] = $v['name'];						
				}
			}
			if(!empty($in_arr)) {
				array_push($final_in_array,$in_arr);
			}
		}

	}
	$targeting->{TargetingFields::INTERESTS} = $final_in_array;
	/*******/
	
	
	$start_time = (new \DateTime("now"))->format(DateTime::ISO8601);
	
	if( $j_data['end_time'] != 0 ) {
		$endWeek = "+".$j_data['end_time']." week";
		$end_time = (new \DateTime($endWeek))->format(DateTime::ISO8601);
	}
	else {
		$end_time = 0;
	}

	$adset = new AdSet(null, 'act_'.$account_id);
	
	$dArr = array(
	  AdSetFields::NAME => $j_data['adname'],
	  AdSetFields::OPTIMIZATION_GOAL => AdSetOptimizationGoalValues::REACH,
	  AdSetFields::BILLING_EVENT => AdSetBillingEventValues::IMPRESSIONS, 
	  AdSetFields::DAILY_BUDGET => $j_data['daily_budget'],
	  /*AdSetFields::BID_AMOUNT => $j_data['bid'],*/
	  AdSetFields::CAMPAIGN_ID => $campaign_id,
	  AdSetFields::TARGETING => $targeting,
	  AdSetFields::START_TIME => $start_time,
	  AdSetFields::END_TIME => $end_time,
	);
	
	if( $j_data['autobid'] == 1 ) {
		$dArr[ AdSetFields::IS_AUTOBID ] = true;
	}else {
		$dArr[ AdSetFields::BID_AMOUNT ] = $j_data['bid'];
	}
	
	$adset->setData($dArr);
	$adset->create(array(
	  AdSet::STATUS_PARAM_NAME => AdSet::STATUS_ACTIVE,
	));
	
	$adset_arr = $adset->getData();
	return $adset_arr['id'];
}

function adcreative( $account_id, $image_hash, $j_data ){
	$link_data = new AdCreativeLinkData();
	$link_data->setData(array(
	  AdCreativeLinkDataFields::MESSAGE => $j_data['title'],
	  AdCreativeLinkDataFields::NAME => $j_data['product_heading'],
	  AdCreativeLinkDataFields::DESCRIPTION => $j_data['description'],
	  AdCreativeLinkDataFields::LINK => $j_data['link'],
	  AdCreativeLinkDataFields::IMAGE_HASH => $image_hash,
	  AdCreativeLinkDataFields::CALL_TO_ACTION => array("type"=>$j_data['call_to_action'],"value" => array("link"=>$j_data['link']))
	));
	
	$object_story_spec = new AdCreativeObjectStorySpec();
	$object_story_spec->setData(array(
	  AdCreativeObjectStorySpecFields::PAGE_ID => $j_data['page_id'],
	  AdCreativeObjectStorySpecFields::LINK_DATA => $link_data,
	));

	$creative = new AdCreative(null, 'act_'.$account_id);

	$creative->setData(array(
	  AdCreativeFields::NAME => 'First Creative',
	  AdCreativeFields::OBJECT_STORY_SPEC => $object_story_spec,
	));
	$creative->create();
	return $creative->id;
}

function adcreative_carousel( $account_id, $j_data ){
	$link_data = new AdCreativeLinkData();
	
	$child_attachments = array();
	
	for($i=0;$i<$j_data['index'];$i++){
		$child_attachments[] = (new AdCreativeLinkDataChildAttachment())->setData(array(
			AdCreativeLinkDataChildAttachmentFields::LINK => $j_data['c_destination_link'.$i],
			AdCreativeLinkDataChildAttachmentFields::NAME => $j_data['c_product_heading'.$i],
			AdCreativeLinkDataChildAttachmentFields::DESCRIPTION => $j_data['c_product_desc'.$i],
			AdCreativeLinkDataChildAttachmentFields::IMAGE_HASH => get_image_hash($account_id, $j_data['c_pg_image_data'.$i])
		));
	}
	
	$link_data->setData(array(
		AdCreativeLinkDataFields::LINK => $j_data['c_product_link'],
		AdCreativeLinkDataFields::MESSAGE => $j_data['c_product_title'],
		AdCreativeLinkDataFields::CALL_TO_ACTION => array("type"=>$j_data['c_ad_call_to_action'],"value" => array("link"=>$j_data['c_product_link'])),
		AdCreativeLinkDataFields::CHILD_ATTACHMENTS => $child_attachments
	));
	
	$object_story_spec = new AdCreativeObjectStorySpec();
	$object_story_spec->setData(array(
	  AdCreativeObjectStorySpecFields::PAGE_ID => $j_data['fb_page_id'],
	  AdCreativeObjectStorySpecFields::LINK_DATA => $link_data,
	));

	$creative = new AdCreative(null, 'act_'.$account_id);

	$creative->setData(array(
	  AdCreativeFields::NAME => 'First Creative',
	  AdCreativeFields::OBJECT_STORY_SPEC => $object_story_spec,
	));
	$creative->create();
	return $creative->id;
}

function get_geo_location(){
	$result = TargetingSearch::search(
		TargetingSearchTypes::GEOLOCATION,
		null,
		null,
		array(
			'location_types' => array('country'),
			'limit' => 250
		)
	);
	$content = $result->getResponse()->getContent();
	
	if (isset($content['data']) && is_array($content['data'])) {
		$data = $content['data'];
		return $data;
    }
	return $content;
}

function get_audience( $account_id ){
	$account = new AdAccount( 'act_'.$account_id );
	$audiences = $account->getCustomAudiences(array('name','approximate_count'));
	$content = $audiences->getResponse()->getContent();
	
	if (isset($content['data']) && is_array($content['data'])) {
		$data = $content['data'];
		return $data;
    }
	return $content;
}

function fb_insights($ads_id, $access_token){
	$fb = new Facebook([
	  'app_id' => APP_ID,
	  'app_secret' => APP_SECRET,
	  'default_graph_version' => 'v2.12'
	]);
	try {
		$resp = $fb->get("$ads_id/insights?fields=actions,impressions,reach,clicks,spend", $access_token);
		$results = $resp->getDecodedBody();
		return $results;
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

function get_geo_location_cities($letter){
	$result = TargetingSearch::search(
		TargetingSearchTypes::GEOLOCATION,
		null,
		$letter,
		array(
			'location_types' => array('city'),
		)
	);
	$content = $result->getResponse()->getContent();
	
	if (isset($content['data']) && is_array($content['data'])) {
		$data = $content['data'];
		return $data;
    }
	return $content;
}

function get_ads_id($account_id, $access_token){
	$fb = new Facebook([
	  'app_id' => APP_ID,
	  'app_secret' => APP_SECRET,
	  'default_graph_version' => 'v2.12'
	]);
	try {
		$resp = $fb->get("act_$account_id/ads?fields=id,name", $access_token);
		$results = $resp->getDecodedBody();
		return $results;
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}