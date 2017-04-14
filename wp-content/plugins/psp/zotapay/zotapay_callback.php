<?php
/**
 * Created by PhpStorm.
 * User: APanaretou
 * Date: 5/17/2016
 * Time: 5:51 PM
 */
session_start();
add_shortcode ( 'zotapay_callback', 'zotapay_callback_shortcode' );
function zotapay_callback_shortcode() {
    ob_start ();
    zotapay_callback ();
    return ob_get_clean ();
}
function zotapay_callback() {

    global $wpdb;

    $payment_order=$_REQUEST['merchant_order'];
    $post_variable=json_encode($_REQUEST);

    $sql = $wpdb->update ( 'wp_payment_status',array('callback'=>$post_variable),array('transaction_id'=>$payment_order));
    $wpdb->query ( $sql );


    return  true ;

}