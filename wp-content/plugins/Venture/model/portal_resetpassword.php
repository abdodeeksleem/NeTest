<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 09/02/2016
 * Time: 2:41 ΜΜ
 */

add_shortcode ( 'portal_resetpassword', 'portal_resetpassword_short' );

function portal_resetpassword_short() {
    ob_start ();
    portal_resetpassword();
    return ob_get_clean ();
}

function portal_resetpassword(){

    //!Redirect variable used for checking if the user is eligible for this page
    $redirect=true;

    //!three checks - not logged in - set the url with email and hash
    if ( !is_user_logged_in() && isset($_GET['email']) && isset($_GET['hash'])) {

        $email = esc_html ( $_GET ['email'] );
        $token = esc_html ( $_GET ['hash'] );

        //!The most Important Check email+token
        $user=get_user_reset($email,$token);

        if(!empty($user['email'])) {

            $redirect=false;
            //!Enqueue our Scripts for this Specific Form
            wp_enqueue_script('js-reset', '/wp-content/plugins/Venture/assets/js/reset-val.js', array(), 1.0, true);

            //!Our View Function For Lead Registration
            view('portal_resetpassword', array(
                'pageTitle' => 'Reset Password',
                 'token' => $token,
                'email' => $email
            ));
        }
    }

    if($redirect){
        $redirect_to = '/';
        wp_redirect ( $redirect_to );
    }

}



function get_user_reset($email,$token)
{
    global $wpdb;
    $user = $wpdb->get_row("select * FROM customers WHERE  email = '$email' AND  token='$token'", ARRAY_A);
    //!Unique Users for Portal
    if (!empty($user['email'])) {
        return $user;
    } else {
        return false;
    }
}