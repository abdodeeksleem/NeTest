<?php

add_shortcode ( 'facebook_webhook', 'facebook_webhook_short' );

function facebook_webhook_short() {
    ob_start ();
    facebook_webhook();
    return ob_get_clean ();
}

function facebook_webhook()
{
    require_once __DIR__ . '/wp-content/plugins/Venture/assets/facebook-sdk-v4-5.0.0/autoload.php';
    $challenge = $_REQUEST['hub_challenge'];
    $verify_token= $_REQUEST['hub_verify_token'];
    if($verify_token==='ettemad123'){
        echo $challenge;
    }
    $input = json_decode(file_get_contents('php://input'),true);
    error_log(print_r($input,true));
    $file = 'leads.txt';
// Open the file to get existing content
    $current = file_get_contents($file);
// Append a new person to the file
    $lead=$input['entry'][0]['changes'][0][value]['leadgen_id'];
    $current .= $lead."\n test";
// Write the contents back to the file
    file_put_contents($file, $current);
}

?>