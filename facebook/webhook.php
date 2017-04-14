<?php
$challenge = $_REQUEST['hub_challenge'];
$verify_token= $_REQUEST['hub_verify_token'];
require_once '/var/www/vhosts/ettemad.com/http/wp-content/plugins/Venture/assets/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
if($verify_token==='ettemad123'){
	echo $challenge;
}
$input = json_decode(file_get_contents('php://input'),true);
error_log(print_r($input,true));
$file = 'leads.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$lead=$input['entry'][0]['changes'][0]['value']['leadgen_id'];

$current .= $lead."\n test";
// Write the contents back to the file
file_put_contents($file, $current);

$fb = new Facebook\Facebook([
  'app_id' => '238728033148956', // Replace {app-id} with your app id
  'app_secret' => '506747891ada5b39a37ec35aac5598ad',
  'default_graph_version' => 'v2.2',
  ]);

$response = $fb->get('/'.(int)$lead.'/','EAADZAHzOdIBwBABQzQTrxlwOrqA6HvztGu5qXdvBZC4CYw5ZC5RKp2PwZAuTSll5cMhLtLgMtTk9DLDzBpH4OGX00eODtZBk6qiZC8fRDrce23sUY0ZBxrIVrV7Lg5jbsYrZCZCG2InmgZAXz63kgS2qiYJqkywYtEUbwZD');
//$response = $fb->get('204652239920173','CAADZAHzOdIBwBAAu7uGSEOFnVkHofnAWBPu2MKrmpqRRtCKlS826xZCP7HPyo7qWZAYgAqMPcZAwrFnIDP7heW12eJH2riahzuWSgYT9tpczZB15yiPEfbaOqJfQsCxPpuKhRiUQniH6OwQkEpTi7ZBrfM8Bgjfi1eNYRq3QvQQbTlGApWwgPAO1MzlBv7xoMZD');

$response=json_decode($response->getBody(),true);
foreach($response['field_data'] as $facebook_field){
	if($facebook_field['name']=='first_name')
		$firstName=$facebook_field['values'][0];
	if($facebook_field['name']=='last_name')
                $lastName=$facebook_field['values'][0];
        if($facebook_field['name']=='email')
                $email=$facebook_field['values'][0];
	 if($facebook_field['name']=='phone_number')
                $phoneNumber=$facebook_field['values'][0];
	 if($facebook_field['name']=='country')
                $country=$facebook_field['values'][0];
}

$ch = curl_init();
$vars = array("reg_lang"=>'ar',"validation_id"=>'952369',"email"=>$email,"firstName"=>$firstName,"phoneNumber"=>$phoneNumber,"countryname"=>$country,"lastName"=>$lastName);
var_dump($vars);
error_log(print_r($vars,true));
curl_setopt($ch, CURLOPT_URL,"https://www.ettemad.com/proxy-lead");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
curl_setopt($ch, CURLOPT_RETURNTRANSFER,0);
$curl_response=curl_exec($ch);
var_dump($curl_response);
?>
