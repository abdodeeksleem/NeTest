<?php

add_shortcode ( 'real_registration', 'real_registration_short' );

function real_registration_short() {
    ob_start ();
    real_registration();
    return ob_get_clean ();
}

function real_registration()
{
    //! This Global config will be change and added as part of base class
    global $config;
    $bu_name='bu_'.ICL_LANGUAGE_CODE;

    $data['ip']=(isset( $_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    $data['lang']=ICL_LANGUAGE_CODE;

    $config_bu=$config[$bu_name];

    foreach($config_bu['tradingPlatforms'] as $key => $value) {
        $platforms_data=explode('-',$key);
        if ($platforms_data[0]!=='DEMO')
            $plaforms[$key]=$key;
    }

    $ip = (isset( $_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    //!Find Country with geoip
    $data['country']= geoip_country_name_by_name($ip);
    $countries=get_countries2();


    //!Enqueue our Scripts for this Specific Form
    wp_register_script ('modernizr_js', 'https://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js');
    wp_enqueue_script('modernizr_js');
    wp_register_script ('polyfiller_js', 'https://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js');
    wp_enqueue_script('polyfiller_js');

    $rtl_languages = array("ar");
    if (in_array(ICL_LANGUAGE_CODE, $rtl_languages)) {
        wp_enqueue_script( 'js-lead-rtl', '/wp-content/plugins/Venture/assets/js/real-val-rtl.js', array(), 1.0, true );
    } else {
        wp_enqueue_script( 'js-lead', '/wp-content/plugins/Venture/assets/js/real-val.js', array(), 1.0, true );
    }

    $result = null;
    $success = 'Success';
    $message = null;

    view('RegisterRealAccount', array(
        'pageTitle' => 'Register new Real Account',
        'result' => $result,
        'isResultSuccess' => ($success == 'Success'),
        'errorMessage' => $message,
        'data'=>$data,
        'countries' => $countries,
        'platforms' => $plaforms
    ));
}