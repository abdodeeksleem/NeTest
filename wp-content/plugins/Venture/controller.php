<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 29/01/2016
 * Time: 11:08 ΠΜ
 */


require_once('controller/venture-controller.class.php');

$Vent_controller= new VentureController();

switch ($_POST['submit']){

    case "create_lead":
        $result=$Vent_controller->create_lead($_POST);
        echo $result;
        break;

    case "real-step1":
        $result=$Vent_controller->create_lead($_POST);
        echo $result;
        break;

    case "real-step3":
        $result=$Vent_controller->convert_lead_to_client($_POST);
        echo $result;
        break;

    case "real-step":
        $result=$Vent_controller->convert_lead_to_client($_POST);
        echo $result;
        break;

    case "login":
        $email=$_POST['username'];
        $password=$_POST['password'];

        if(is_numeric($email))
            $response=$Vent_controller->login_user_with_tp_account($email,$password); //!Login with TP Account
        else
            $response=$Vent_controller->login_user($email,$password); //!Login with Portal Account

        echo $response;
        break;

    case "forgot-password":
        $result=$Vent_controller->portal_forgot_password($_POST);
        echo $result;
        break;

    case "reset-password":
        $result=$Vent_controller->portal_reset_password($_POST);
        echo $result;
        break;

    case "edit-userinformation":
        $result=$Vent_controller->portal_update_userinformation($_POST);
        echo $result;
        break;

    case "forgot_tpaccount_password" ;
        $result=$Vent_controller->forgot_TP_password($_POST);
        echo $result;
        break;


    case "reset_tpaccount_password" ;
        $result=$Vent_controller->reset_TP_password($_POST);
        echo $result;
        break;

    case "get_tpaccount_history" ;
        $result=$Vent_controller->get_tpaccount_history($_POST);
        echo $result;
        break;

    case "create_withdrawal":
        $result=$Vent_controller->create_withdraw_monetary_transaction($_POST);
        echo $result;
        break;

    case "user_docs":
        $result=$Vent_controller->get_user_docs();
        echo $result;
        break;

    case "additional-account":
        $result=$Vent_controller->register_additional_account($_POST);
        echo $result;
        break;

    case "real-short-step1" :
        $result=$Vent_controller->register_real_account_1step($_POST);
        echo $result;
        break;

}

exit();