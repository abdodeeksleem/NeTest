<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 09/02/2016
 * Time: 2:41 ΜΜ
 */

add_shortcode ( 'portal_login', 'portal_login_short' );

function portal_login_short() {

    ob_start ();
    portal_login();
    return ob_get_clean ();

}

function portal_login(){

    //!Enqueue our Scripts for this Specific Form
    wp_enqueue_script( 'js-login', '/wp-content/plugins/Venture/assets/js/login-val.js', array(), 2.0, true );

    //!Our View Function For Lead Registration
    view('portal_login', array(
        'pageTitle' => 'Login to Portal'
    ));

}