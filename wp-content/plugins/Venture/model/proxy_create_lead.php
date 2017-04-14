<?php

add_shortcode ( 'create_lead_page', 'create_lead_page_short' );

function create_lead_page_short() {
    ob_start ();
    create_lead_page();
    return ob_get_clean ();
}

function create_lead_page(){

    if ($_POST['validation_id']!='952369'){

        echo 'error with validation code';
        exit;
    }




    $country_array=get_country_by_name($_POST['countryname']);

    if (empty($country_array)||empty($country_array['guid'])){
      $_POST['countryId']='1339c10a-fdb0-df11-ab2e-005056990011';
    }else{
	$_POST['countryId']=$country_array['guid'];
  }

    //!Validate data that GET from create lead

    $_POST['phoneCountryCode']='00000';

    if(empty($_POST['email'])||empty($_POST['countryId'])||empty($_POST['firstName'])||empty($_POST['lastName'])||empty($_POST['phoneNumber'])){

        echo 'parameters are missing';
        exit;

    }

    require_once(VENTURE_PLUGIN_PATH.'controller/venture-controller.class.php');


    $Vent_controller= new VentureController();
    $result_json=$Vent_controller->create_lead($_POST);

    $result = json_decode($result_json, true);
    //!Case of Successful registration and redirect with token
    if($result['Code']=='Success'){

        echo 'Account ID :'.  $result['AccountId'];
        exit();

    }else{

        echo 'Error on Creation Message :'.$result['Message'];
        exit;
    }








}
