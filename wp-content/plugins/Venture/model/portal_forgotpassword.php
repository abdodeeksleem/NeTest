<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 10/02/2016
 * Time: 11:07 ΠΜ
 */

add_shortcode ( 'portal_forgotpassword', 'portal_forgotpassword_short' );

function portal_forgotpassword_short() {

    ob_start ();
    portal_forgot();
    return ob_get_clean ();

}

function portal_forgot(){

    //!Enqueue our Scripts for this Specific Form
    wp_enqueue_script( 'js-forgot', '/wp-content/plugins/Venture/assets/js/forgot-val.js', array(), 1.0, true );

    //!Our View Function For Lead Registration
    view('portal_forgotpassword', array(
        'pageTitle' => 'Forgot Password'
    ));

}