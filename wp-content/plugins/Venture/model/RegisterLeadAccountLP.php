<?php

add_shortcode ( 'lead_registration_lp', 'lead_registration_lp_short' );

function lead_registration_lp_short() {
    ob_start ();
    lead_registration_lp();
    return ob_get_clean ();
}

function lead_registration_lp(){

    //! This Global config will be change and added as part of base class

    //!Find Country with geoip
    $data['ip']=(isset( $_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    $data['lang']=ICL_LANGUAGE_CODE;
    $data['country']= geoip_country_name_by_name($data['ip']);
    $countries=get_countries2();

    //!Enqueue our Scripts for this Specific Form
    wp_enqueue_script( 'js-lead', '/wp-content/plugins/Venture/assets/js/lead-val.js', array(), 1.0, true );

    //!Our View Function For Lead Registration
    view('RegisterLeadAccountLP', array(
        'pageTitle' => 'Register Lead Account',
        'data' => $data,
        'countries' => $countries
    ));


}