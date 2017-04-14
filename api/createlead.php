<?php
$DOCUMENT_ROOT = $_SERVER ['DOCUMENT_ROOT'];
require_once ($DOCUMENT_ROOT . '/wp-load.php');
require_once ($DOCUMENT_ROOT . '/wp-content/plugins/Venture/controller/venture-controller.class.php');


//if ($_GET['validation_id']!='952369'){
//    echo 'error with validation code';
//    exit;
//}


//$country_array=get_country_by_name($_GET['countryname']);
//
//if (empty($country_array)||empty($country_array['guid'])){
//    $data['countryId']='a539c10a-fdb0-df11-ab2e-005056990011';
//}else{
//    $data['countryId']=$country_array['guid'];
//}
//
////!Validate data that GET from create lead
//$_GET['phoneCountryCode']='00000';

if(empty($_GET['email'])||empty($_GET['firstName'])||empty($_GET['lastName'])||empty($_GET['phoneNumber'])){
    echo 'parameters are missing';
    exit;

}

$data['phoneCountryCode']=$_GET['phoneCountryCode'];
$data['countryId']=$_GET['countryId'];
$data['email']=$_GET['email'];
$data['firstName']=$_GET['firstName'];
$data['lastName']=$_GET['lastName'];
$data['phoneNumber']=$_GET['phoneNumber'];


$Vent_controller= new VentureController();
$result_json=$Vent_controller->create_lead($data);

$result = json_decode($result_json, true);
//!Case of Successful registration and redirect with token
if($result['Code']=='Success'){
    echo 'Account ID :'.  $result['AccountId'];
    exit();
}else{
    echo 'Error on Creation Message :'.$result['Message'];
    exit;
}