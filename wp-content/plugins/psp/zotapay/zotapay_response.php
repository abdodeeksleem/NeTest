<?php

add_shortcode ( 'zotapay_response', 'zotapay_response_shortcode' );
function zotapay_response_shortcode() {
    ob_start ();
    zotapay_response ();
    return ob_get_clean ();
}

function zotapay_response() {

    $merchant_order= $_REQUEST['merchant_order'];
    $orderid= $_REQUEST['orderid'];
    $sn=$_SESSION['serial-number'];
    $endpoint_id=$_SESSION['endpointID'];
    $login_name='ettemad';
    $merchant_control= "6AC8481E-E972-4F37-B304-B387E08E0CF5";


    $file = '1stlog.txt';
// Open the file to get existing content
    $current = file_get_contents($file);
// Append a new person to the file
    $current .= $orderid.",".date("h:i:sa")."\n";
// Write the contents back to the file
    file_put_contents($file, $current);


    $requestFields = array(
        'login' => $login_name,
        'client_orderid' => $merchant_order,
        'orderid' => $orderid,
        'by-request-sn' => $sn,
        'control' => sha1($login_name.$merchant_order.$orderid.$merchant_control)
    );
    $url = 'https://gate.zotapay.com/paynet/api/v2/status/'.$endpoint_id;
    $responseFieldsResponse = sendRequestResponse($url, $requestFields);

    //! Clear Transaction end !//


    //!Log the clear Transaction to db
    $response_json_format=json_encode($responseFieldsResponse,true);
    log_response_transaction($response_json_format,$merchant_order,$responseFieldsResponse['status']);

    //!Go to Function for redirecting
    success($merchant_order,$responseFieldsResponse);

}



function success($merchant_order,$responseFieldsResponse){

    $value=$responseFieldsResponse['status'];
    $orderstage=$responseFieldsResponse['order-stage'];

    //!4 Cases for redirecting
    if(strpos($value, 'approved')===0) {
        //!Create the deposit
        response_success($merchant_order);
        wp_redirect ( '/deposit-success/?transaction='.$merchant_order);
        exit ();

    }elseif(strpos($value, 'declined')===0){
        wp_redirect ( '/deposit-failed');
        exit ();
    }
    elseif(strpos($value, 'unknown')===0){
        wp_redirect ( '/deposit-unknown');
        exit ();
    }elseif(strpos($orderstage, 'sale_cancelled')===0){
        wp_redirect ( '/my-account/#deposit');
        exit ();
    }else{
        wp_redirect ( '/deposit-unknown');
        exit ();
    }

}


function sendRequestResponse($url, array $requestFields){

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

    $responseFieldsResponse = array();

    parse_str($response, $responseFieldsResponse);

    return $responseFieldsResponse;
}


function log_response_transaction($data,$transaction_id,$status){

    global $wpdb;

    $status_log=preg_replace('~[\r\n]+~', '', $status).'-pending-cleared';
    $data=preg_replace('~[\r\n]+~', '', $data);
    $sql = $wpdb->update ( 'wp_payment_status',array('response_clear_transaction'=>$data),array('transaction_id'=>$transaction_id));
    $wpdb->query ( $sql );


    $sql = $wpdb->update ( 'wp_payment_status',array('status'=>$status_log),array('transaction_id'=>$transaction_id));
    $wpdb->query ( $sql );

}



function response_success($orderNumber){

    global $wpdb;
    $payment_status_table = $wpdb->prefix . 'payment_status';
    $result = $wpdb->get_results ( $wpdb->prepare ( "SELECT *  FROM $payment_status_table WHERE transaction_id = %s", $orderNumber ) );
    $email = $result [0]->email;
    $amount = $result [0]->amount;


    if($result[0]->status=='approved-pending-cleared') {


        $file = '2ndlog.txt';
// Open the file to get existing content
        $current = file_get_contents($file);
// Append a new person to the file
        $current .= $orderNumber.",before_update_status,".date("h:i:sa")."\n";
// Write the contents back to the file
        file_put_contents($file, $current);


        $sql = $wpdb->update ( 'wp_payment_status',array('status'=>'approved-cleared'),array('transaction_id'=>$result [0]->transaction_id));
        $wpdb->query ( $sql );



        $file = '3rdlog.txt';
// Open the file to get existing content
        $current = file_get_contents($file);
// Append a new person to the file
        $current .= $orderNumber.",after_update_status,".date("h:i:sa")."\n";
// Write the contents back to the file
        file_put_contents($file, $current);

        $platformDeposit = create_deposit($email, $amount, $orderNumber);

        $file = '4thlog.txt';
// Open the file to get existing content
        $current = file_get_contents($file);
// Append a new person to the file
        $current .= $orderNumber.",after_create_deposit,".date("h:i:sa").",crm_response:".$platformDeposit."\n";
// Write the contents back to the file
        file_put_contents($file, $current);

    }

}


//Create deposit Leverate
function create_deposit($email, $amount,$orderNumber){

    $http_code='';

    //!Monetary Transaction According to Status of PSP
    //!Solid has 4 cases-error-codes , Success 0 ,Success 1, Pending 2, Fail 3
    $data2['IsCancellationTransaction'] = false;
    $data2['ShouldAutoApprove'] =  true;
    $data2['UpdateTPOnApprove'] = true;
    $data2['amount'] = $amount;
    $data2['merchantTransactionId'] = $orderNumber;
    $error_code='';


    require_once($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/controller/venture-controller.class.php');
    $Vent_controller = new VentureController();

    $result = $Vent_controller->create_create_creditcard_deposit($email, $amount, $error_code, $data2);

    return $result;
}