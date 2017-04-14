<?php
/**
 * Description: Go to platform functionality
 * User: Andreas Hadjicostas
 * Date: 15/03/2016
 * Details : Shortcode "trade_toPlatform" added for this functionality
 */


$DOCUMENT_ROOT = $_SERVER ['DOCUMENT_ROOT'];
require_once ($DOCUMENT_ROOT . '/wp-load.php');

add_shortcode ( 'trade_toPlatform', 'trade_platform_short' );
function trade_platform_short() {
    ob_start ();
    trade_to_platform ();
    return ob_get_clean ();

}

function trade_to_platform(){

    global $wpdb;
    $table_name = 'wp_venture_plugin_settings';
    $option = $wpdb->get_results("select option_value FROM $table_name WHERE option_category='email'", ARRAY_A );
    $data=json_decode($option['0']['option_value'],true);

    $url_redirect = $data['platform_url'];
    wp_redirect ( $url_redirect );
    exit ();

}

