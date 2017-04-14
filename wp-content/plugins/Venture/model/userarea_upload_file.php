<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 22/02/2016
 * Time: 12:30 ΜΜ
 */

add_shortcode ( 'userarea_upload_file', 'userarea_upload_file_short' );

function userarea_upload_file_short() {
    ob_start ();
    userarea_upload_file();
    return ob_get_clean ();

}

function userarea_upload_file(){

    upload_documents();
    exit;
}

function upload_documents(){

    //! Get Current User Email
    global $current_user;
    $user_email = $current_user->user_email;

    //!Save the Image
    $data['image']= addslashes($_FILES['file']['tmp_name']);
    $data['file_name']= addslashes($_FILES['file']['name']);
    $data['file_content']= file_get_contents($data['image']);
    $data['image_file']= base64_encode($data['image']);
    $data['tmp_path']=$_FILES['file']['tmp_name'];
    $data['email']=$user_email;
    $data['document_type']=$_POST['document_type'];

    require_once(VENTURE_PLUGIN_PATH.'controller/venture-controller.class.php');
    $Vent_controller= new VentureController();

    return   $Vent_controller->upload_file_account($data);

}


