<?php

add_shortcode ( 'real_registration_1_step', 'real_registration_1_step_short' );

function real_registration_1_step_short() {
    ob_start ();
    real_registration_1_step();
    return ob_get_clean ();
}

function real_registration_1_step(){


    if (is_user_logged_in()){
        $url_redirect='my-account/#request-additional-account';
        $url_redirect=((ICL_LANGUAGE_CODE=='ar') ? $url_redirect : ('/'.ICL_LANGUAGE_CODE.'/'.$url_redirect) );
        wp_redirect($url_redirect);
        exit;
    }


    //!If has id then check if is valid and do actions in order to convert it
    if(isset($_GET['id'])) {
        $user_data = exist_lead($_GET['id']);
        //!Lead Exist
        if (!empty($user_data)){
            $return_data=$user_data[0];
            $country_row=get_country_by_id($return_data['country']);
            //!Set the language right
            $data['lang']=$return_data['reg_lang'];
            $data['first_name']=$return_data['first_name'];
            $data['last_name']=$return_data['last_name'];
            $data['email']=$return_data['email'];
            $data['country']=$country_row['name'];
            $data['account_id']=$return_data['account_id'];
            $data['phonecode']=$return_data['phone_ccode'];
            $data['phone']=$return_data['phone'];
        }else{
            wp_redirect('/');
            exit();
        }
    }

    //!Get Variables that is nessecary for configuration
    $data['ip']=(isset( $_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    $data['lang']=(isset($data['lang'])?$data['lang']:ICL_LANGUAGE_CODE);
    $data['country']=(isset($data['country'])?$data['country']:geoip_country_name_by_name($data['ip']));

    //! This Global config will be change and added as part of base class
    global $config;
    $bu_name='bu_'.ICL_LANGUAGE_CODE;
    $config_bu=$config[$bu_name];

    foreach($config_bu['tradingPlatforms'] as $key => $value) {
        $platforms_data=explode('-',$key);
        $plaforms[$key]=$key;
    }

    $countries =get_countries2();
    $currencies=get_currencies();

    //!Enqueue our Scripts for this Specific Form
    wp_enqueue_script( 'js-real-1step', '/wp-content/plugins/Venture/assets/js/real-1-step-val.js', array(), 1.0, true );

    view('RegisterRealAccount1Step', array(
        'pageTitle' => 'Register Real Account',
        'countries' => $countries,
        'data'=>$data,
        'platforms' => $plaforms,
        'currencies'=>$currencies
    ));
}