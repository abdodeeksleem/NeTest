<?php
session_start();
add_shortcode ( 'zotapay_payment', 'zotapay_payment_shortcode' );
function zotapay_payment_shortcode() {
    ob_start ();
    zotapay_payment ();
    return ob_get_clean ();
}
function zotapay_payment() {


    if (isset ( $_SESSION ['transaction'] ) && is_user_logged_in()) {
        $transaction = $_SESSION ['transaction'];
        unset ($_SESSION ['transaction']);
    }else{
        wp_redirect ( '/my-account/');
        exit ();
    }

    global $current_user;
    global $wpdb;
    $user_email = $current_user->user_email;
    $crm_user = $wpdb->prefix . 'payment_status';
    $data = $wpdb->get_results("select * FROM $crm_user WHERE email='$user_email' and transaction_id='$transaction' ", ARRAY_A );

    $fname = $data [0]['first_name'];
    $lname = $data [0]['last_name'];
    $email = $data [0]['email'];
    $amnt = $data [0]['amount'];

    $street= $data[0]['street1'];
    $city=$data[0]['city'];
    $country=$data[0]['country'];
    $zip=$data[0]['postcode'];
    $phone=$data[0]['phone'];
    $ip_address=$data[0]['ipaddress'];
    $currency=strtoupper($data[0]['currency']);
    if($currency == 'USD')
    {
        $endpointID ='2340';
    }
    elseif($currency == 'EUR')
    {
        $endpointID ='2341';
    }
    elseif($currency == 'GBP')
    {
        $endpointID ='1034';
    }
    if (isset ( $_SESSION ['endpointID'] )) {
        unset ( $_SESSION ['endpointID'] );
    }

    $_SESSION ['endpointID'] = $endpointID;
    $merchant_control= "6AC8481E-E972-4F37-B304-B387E08E0CF5";

    $amount=getMoneyAsCents($amnt);
    if($country != 'USA'  || $country != 'CANADA' || $country != 'AUSTRALIA')
    {
        $state= 'XX';
    }

    $url = "https://gate.zotapay.com/paynet/api/v2/sale-form/". $endpointID;
    $sha=$endpointID . $transaction .$amount . $email .$merchant_control;

    $redirect_url=site_url().'/deposit-response/';
    $callback_url=site_url().'/payment/';

    $requestFields = array(
        'client_orderid' => $transaction,
        'order_desc' => 'Deposit',
        'first_name' => $fname,
        'last_name' => $lname,
        'address1' => $street,
        'city' => $city,
        'state' => $state,
        'zip_code' => $zip,
        'country' => $country,
        'phone' => $phone,
        'amount' => $amnt,
        'email' => $email,
        'currency' => $currency,
        'ipaddress' => $ip_address,
        'site_url' => site_url(),
        'redirect_url' => $redirect_url,
        'server_callback_url' => $callback_url,
        'merchant_data' => 'VIP customer',
        'control' => sha1($sha)
    );

    $responseFields = sendRequest($url, $requestFields);

    //!Log the Create Response from ZotaPay
    $data_encode=json_encode($responseFields);
    log_create_transaction($data_encode,$transaction);


    if (isset ( $_SESSION ['serial-number'] )) {
        unset ( $_SESSION ['serial-number'] );
    }

    $_SESSION ['serial-number'] = $responseFields['serial-number'];
    $sandbox_redirect=$responseFields['redirect-url'];
    wp_redirect ($sandbox_redirect);
    exit;

}


function getMoneyAsCents($value)
{
    // strip out commas
    $value = preg_replace("/\,/i","",$value);
    // strip out all but numbers, dash, and dot
    $value = preg_replace("/([^0-9\.\-])/i","",$value);
    // make sure we are dealing with a proper number now, no +.4393 or 3...304 or 76.5895,94
    if (!is_numeric($value))
    {
        return 0.00;
    }
    // convert to a float explicitly
    $value = (float)$value;
    return round($value,2)*100;
}

function sendRequest($url, array $requestFields)
{
    $curl = curl_init($url);

    curl_setopt_array($curl, array
    (
        CURLOPT_HEADER         => 0,
        CURLOPT_USERAGENT      => 'Zotapay-Client/1.0',
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST           => 1,
        CURLOPT_RETURNTRANSFER => 1
    ));

    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestFields));

    $response = curl_exec($curl);

    if(curl_errno($curl))
    {
        $error_message  = 'Error occurred: ' . curl_error($curl);
        $error_code     = curl_errno($curl);
    }
    elseif(curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200)
    {
        $error_code     = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error_message  = "Error occurred. HTTP code: '{$error_code}'";
    }

    curl_close($curl);

    if (!empty($error_message))
    {
        throw new RuntimeException($error_message, $error_code);
    }

    if(empty($response))
    {
        throw new RuntimeException('Host response is empty');
    }

    $responseFields = array();

    parse_str($response, $responseFields);


    return $responseFields;
}


function log_create_transaction($data,$transaction_id){

    global $wpdb;
    $sql = $wpdb->update ( 'wp_payment_status',array('response_create_token'=>$data),array('transaction_id'=>$transaction_id));
    $wpdb->query ( $sql );

}
