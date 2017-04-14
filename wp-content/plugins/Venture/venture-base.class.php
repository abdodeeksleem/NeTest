<?php

/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 28/01/2016
 * Time: 9:27 ΜΜ
 */



class VentureBase {

    const VIEW_SLIDER = "slider";


    /**
     * the constructor
     */

    public function __construct(){

        $this->init();

    }


    /**
     * init our Soap Service to CRM
     */
    private function init(){
        //! Load Scripts and Styles that will be used for all Form Functionality
        wp_enqueue_script( 'js-form', '/wp-content/plugins/Venture/assets/js/jquery.form.min.js', array(), 1.0, true );
        wp_enqueue_style ('css-form', '/wp-content/plugins/Venture/assets/css/form.css', array(), 1.0, true );
        wp_enqueue_script( 'js-validate', '/wp-content/plugins/Venture/assets/js/jquery.validate.js', array(), 1.0, true );

        add_action('wp', array($this, 'rtl_language'));

        //!Set the Connection //!Need to add variable for this config
        include_once('util/init.php');
        include_once('util/util.php');

        //! Register Shortcodes
        require_once('model/RegisterLeadAccount.php');
        require_once('model/RegisterRealAccount.php');
        require_once('model/portal_login.php');
        require_once('model/portal_forgotpassword.php');
        require_once('model/portal_resetpassword.php');
        require_once('model/portal_userarea.php');
        require_once('model/userarea_upload_file.php');
        require_once('model/RegisterRealAccount1Step.php');
        require_once('model/portal_trade.php');
        require_once('model/RegisterLeadAccountLP.php');
        require_once('model/proxy_create_lead.php');
    }

    public function rtl_language() {

        $rtl_languages = array("ar");

        if (defined('ICL_LANGUAGE_CODE')) {
            if (in_array(ICL_LANGUAGE_CODE, $rtl_languages)) {
                wp_enqueue_style ('rtl-css-form', '/wp-content/plugins/Venture/assets/css/form-rtl.css', array(), 1.0, true );
            }
        }

    }
}
?>