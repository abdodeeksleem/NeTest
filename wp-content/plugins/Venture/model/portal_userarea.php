<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 22/02/2016
 * Time: 12:30 ΜΜ
 */

add_shortcode ( 'portal_userarea', 'portal_userarea_short' );

function portal_userarea_short() {

    ob_start ();
    portal_userarea();
    return ob_get_clean ();

}

function portal_userarea(){

    if(!is_user_logged_in()) {
        $url_redirect='/login';
        $url_redirect=((ICL_LANGUAGE_CODE=='ar') ? $url_redirect : ('/'.ICL_LANGUAGE_CODE.'/'.$url_redirect) );
        wp_redirect($url_redirect);
        exit();
    }

    //! PSP Integration post !//
    if (isset($_POST['submit']) && $_POST['submit'] =='create_deposit'){

        //!Get User by email
        global $current_user;
        $user_email =$current_user->user_email;

        //!Get User Details from table customers filtered by email
        $user_data=get_user_data($user_email);

        $array_account_usd=explode('|', $_POST['inputTPAccountNameDeposit']);

        $data_transaction['email']=$user_data['email'];
        $data_transaction['last_name']=$user_data['last_name'];
        $data_transaction['first_name']=$user_data['first_name'];
        $data_transaction['country']=$user_data['country'];
        $data_transaction['phone_number']=$user_data['phone_number'];
        $data_transaction['account_no']=$array_account_usd[0];
        $data_transaction['account_currency']=$array_account_usd[1];
        $data_transaction['tpaccount_id']=$array_account_usd[2];
        $data_transaction['amount'] = $_POST['AmountDeposit'];
        $data_transaction['street'] = $_POST['address1Deposit'];
        $data_transaction['city'] = $_POST['cityDeposit'];
        $data_transaction['zip'] = $_POST['post_codeDeposit'];
        $data_transaction['ip']=(isset( $_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
        //!Create Unique Merchant ID
        $data_transaction['transaction_ref'] =create_transaction_id($data_transaction['account_no']);

        //!insert Details to array
        insert_payment($data_transaction);

        session_start();
        //!Unset the transaction if  is set from before
        if (isset ( $_SESSION ['transaction'] )) {
            unset ( $_SESSION ['transaction'] );
        }

        $_SESSION ['transaction'] = $data_transaction['transaction_ref'] ;
        wp_redirect ( '/depositpayment/');
        exit ();
    }



    //!Enqueue our Scripts for this Specific Form
    wp_enqueue_script( 'js-userarea', '/wp-content/plugins/Venture/assets/js/userarea-val.js', array(), 1.0, true );
    wp_enqueue_script( 'js-dropzone', '/wp-content/plugins/Venture/assets/js/dropzone.js', array(), 2.0, true );
    wp_enqueue_script( 'js-ui', '/wp-content/plugins/Venture/assets/js/jquery-ui.min.js', array(), 2.0, true );
    wp_enqueue_script( 'js-userarea', '/wp-content/plugins/Venture/assets/js/psp.js', array(), 1.0, true );

    //Date Field Firefox
//    wp_register_script ('modernizr_userarea_js', 'http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js');
//    wp_enqueue_script('modernizr_userarea_js');
//    wp_register_script ('polyfiller_userarea_js', 'http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js');
//    wp_enqueue_script('polyfiller_userarea_js');

    //!End of Scripts

    global $config;

    $bu_name='bu_'.ICL_LANGUAGE_CODE;

    $data['ip']=(isset( $_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    $data['lang']=ICL_LANGUAGE_CODE;

    $config_bu=$config[$bu_name];

    foreach($config_bu['tradingPlatforms'] as $key => $value) {
        $platforms_data=explode('-',$key);
        $plaforms[$key]=$key;
    }


    //!Get User by email
    global $current_user;
    $user_email =$current_user->user_email;

    //!Get User Details from table customers filtered by email (Client Level)
    $user_data=get_user_data($user_email);
    $countries=get_countries($user_data['business_unit']);
    $accountsinfo=get_portal_user_tpaccounts($user_email,$user_data['business_unit']);
    $currencies=get_currencies();


    //!Our View Function For Lead Registration
    view('portal_userarea', array(
        'pageTitle' => 'Portal Area',
        'data' => $user_data,
        'countries' => $countries->CountryInfo,
        'accountsinfo'=>$accountsinfo,
        'currencies' => $currencies,
        'platforms' => $plaforms
    ));

}


function get_user_data($email)
{
    global $wpdb;
    $user = $wpdb->get_row("select * FROM customers WHERE  email = '$email'", ARRAY_A);
    //!Unique Users for Portal
    if (!empty($user['email'])) {
        return $user;
    } else {
        return false;
    }
}

function get_countries($business_unit)
{
    global $config;
    $config_bu=$config[$business_unit];

    try {
        $gc = new GetCountries();
        $gc->businessUnitName = $config_bu['businessUnitName'];
        $gc->organizationName = $config_bu['organization'];
        $gc->ownerUserId = $config_bu['ownerUserId'];

        $leverateCrm = getCrm($config_bu);

        $CountriesResponse = new GetCountriesResponse();
        $CountriesResponse = $leverateCrm->GetCountries($gc);
        $countries = $CountriesResponse->GetCountriesResult;

        return $countries;

    } catch (Exception $e) {
        print  'Caught exception: ' . $e . "\n";
        return false;
    }
}


function get_portal_user_tpaccounts($email,$business_unit){

    global $config;
    $config_bu=$config[$business_unit];

    try {

        $ownerUserId = new guid();
        $ownerUserId = $config_bu['ownerUserId'];

        $request = new AccountDetailsRequest();
        $request->FilterType = 'Email';
        $request->FilterValue = $email;

        $getAccountDetails = new GetAccountDetails();
        $getAccountDetails->ownerUserId = $ownerUserId;
        $getAccountDetails->organizationName = $config_bu['organization'];
        $getAccountDetails->businessUnitName = $config_bu['businessUnitName'];
        $getAccountDetails->accountDetailsRequest = $request;

        $leverateCrm = getCrm($config_bu);

        $response = new GetAccountDetailsResponse();
        $response =$leverateCrm->GetAccountDetails($getAccountDetails);
        $result = $response->GetAccountDetailsResult->Result->Message;
        //!Special Case for NO Lead Creation
        if($result=='1 accounts found.'){
            $accountsinfo= $response->GetAccountDetailsResult->AccountsInfo;
            return $accountsinfo;
        }
        $accountsinfo= $response->GetAccountDetailsResult->AccountsInfo->AccountInfo;
        return $accountsinfo;

    } catch (Exception $e) {


        return false;
    }

}



//Create Generator OrderNumber
function create_transaction_id($user_id,$prefix='DEP'){

    require_once(VENTURE_PLUGIN_PATH. '/assets/PasswordGenerator/pass_generator.php');

    $unique_char = PasswordGenerator::getAlphaNumericPassword(8);

    //!TRANSACTION PREFIX + USER ID + UNIQUE CHAR
    $uniqueID=$prefix.$user_id.$unique_char;
    return $uniqueID;

}

function insert_payment($data_transaction){

    $data_transaction['country']=get_country_iso_by_id($data_transaction['country']);

    //!Create Unique Merchant ID
    global $wpdb;

    $sql = $wpdb->insert ( $wpdb->prefix . 'payment_status', array (
        'transaction_id' =>$data_transaction['transaction_ref'] ,
        'amount' => $data_transaction['amount'] ,
        'tpaccount_id'=>$data_transaction['tpaccount_id'],
        'provider' => "solid payments",
        'status' => "created",
        'phone' => $data_transaction['phone_number'],
        'currency' => $data_transaction['account_currency'],
        'first_name' => $data_transaction['first_name'],
        'last_name' => $data_transaction['last_name'],
        'email' => $data_transaction['email'],
        'ipaddress' => $data_transaction['ip'],
        'street1' => $data_transaction['street'],
        'city' => $data_transaction['city'],
        'country' => $data_transaction['country'],
        'postcode' => $data_transaction['zip']
    ));

    $wpdb->query ( $sql );

}


function get_country_iso_by_id($country_id){
    global $wpdb;
    $result = $wpdb->get_results ( ( "SELECT  iso2  FROM countries where guid ='$country_id'"), ARRAY_A );
    return $result[0]['iso2'];
}

