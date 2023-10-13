<?php
function remove_http($url) {
   $disallowed = array('http://', 'https://');
   foreach($disallowed as $d) {
      if(strpos($url, $d) === 0) {
         return str_replace($d, '', $url);
      }
   }
   return $url;
}

function random_generator($s = 0, $e = 8){
	$now = substr( md5(time().uniqid()), $s, $e );
	return $now;
}

function filename_withoutext( $filename ){
	$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
	return $withoutExt;
}

function super_unique($array){
  $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
  return $result;
}

function get_first_letter( $str ){
	$acronym = "";
	if(!empty($str)){
		$words = explode(" ", $str);
	
		foreach ($words as $w) {
			$acronym .= isset($w[0]) ? $w[0] : '';
		}
	}
	return $acronym;
}

function remove_directory($directory){
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            remove_directory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}

function file_get_contents_curl($url){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

// array( 'to' => '', 'from' => '', 'subject' => '', 'message' => '' )
function send_mail( $mail ){
	include('mandrill/Mandrill.php');
	try {
		$mandrill = new Mandrill('Llm23oJb5EprI7xnVulIXA');
		$message = array(
			'html' => $mail['html'],
			'subject' => $mail['subject'],
			'from_email' => $mail['from_email'],
			'from_name' => $mail['from_name'],
			'to' => $mail['to'],
			'headers' => $mail['headers'],
		);
		
		if(!empty($attachment)){
			$message['attachments']='[
				{
					"type": "text/plain",
					"name": "myfile.txt",
					"content": "ZXhhbXBsZSBmaWxl"
				}
			]';
		}
		
		$async = true;
		$ip_pool = 'Main Pool';
		$send_at = null;
		$result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
		
		if(isset($result[0]['status']) && $result[0]['status'] == 'sent'){
			return $result[0]['email'];
		}else{
			return $result;
		}
		/*
		Array
		(
			[0] => Array
				(
					[email] => recipient.email@example.com
					[status] => sent
					[reject_reason] => hard-bounce
					[_id] => abc123abc123abc123abc123abc123
				)
		
		)
		*/
	} catch(Mandrill_Error $e) {
		// Mandrill errors are thrown as exceptions
		echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
		// A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
		throw $e;
	}
}

function sendmailTemplate($template_name, $mail, $var){
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, 'https://mandrillapp.com/api/1.0/messages/send-template.json');
	curl_setopt($ch,CURLOPT_POSTFIELDS, '{
		"key":"NtSxVXvKNB_5JQOjv5bFTw",
		"template_name":"'.$template_name.'",
		"template_content":[],
		"message":{
			"to":[
				{"email":"'.$mail['email'].'",
				"name":"'.$mail['name'].'",
				"type":"to"}
			],
			"headers": {
				"Reply-To": "no-reply@app.pixaguru.com"
			},
			"merge": true,
			"global_merge_vars": '.$var.'
		},
		"async":false,
		"ip_pool":"Main Pool"
	}');

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$result = curl_exec($ch);
	
	return $result;
}

function date_diffrence( $d1, $d2 ){
	$now = strtotime( $d1 ); // or your date as well
	$your_date = strtotime( $d2 );
	$datediff = $now - $your_date;

	return round($datediff / (60 * 60 * 24));
}