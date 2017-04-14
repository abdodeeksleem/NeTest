<?php

require_once '/var/www/vhosts/ettemad.com/http/wp-content/plugins/Venture/assets/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';



$fb = new Facebook\Facebook([
    'app_id' => '238728033148956', // Replace {app-id} with your app id
    'app_secret' => '506747891ada5b39a37ec35aac5598ad',
    'default_graph_version' => 'v2.2',
]);

$handle = fopen("list.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $lead=explode(":",$line);
        // process the line read.
	echo $lead[1]; 
       $response = $fb->get('/'.(int)$lead[1].'/','EAADZAHzOdIBwBABQzQTrxlwOrqA6HvztGu5qXdvBZC4CYw5ZC5RKp2PwZAuTSll5cMhLtLgMtTk9DLDzBpH4OGX00eODtZBk6qiZC8fRDrce23sUY0ZBxrIVrV7Lg5jbsYrZCZCG2InmgZAXz63kgS2qiYJqkywYtEUbwZD');
//$response = $fb->get('/553746121471844/','CAADZAHzOdIBwBAN5ZBbO8iwjluBhsOUBmNDeBiXuXZCz1rZBMJ2ZBySmCjsIHDTojoTotV3DBHyrsTFOJtDirV15OBRB0RuPRDruuZCMTdy06Xbc3fwlumvjCC9uAuvPZB9zZCuNgIoi9TPVwoX2GzYWl3DgZANjjUp2kh5tp8ev3YGY9bThDCjjievcPcI45F3uL4q4Sywpz8QZDZD');
//$response= (array)$response;
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
        curl_setopt($ch, CURLOPT_URL,"https://www.ettemad.com/proxy-lead");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,0);
        $curl_response=curl_exec($ch);
        var_dump($curl_response);
    }

    fclose($handle);
} else {
    // error opening the file.
}



?>
