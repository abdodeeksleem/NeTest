<?php
/*
Plugin Name: Venture Plugin
Plugin URI: http://www.venture.dgmedialink.com/
Description: Venture Plugin
Author: Andreas H. dgmedialink
Version: 1.0.0
Author URI: http://dgmedialink.com
*/


// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

function venture_activate() {
    //!Initialization of Plugin
    //!Create the tables
    global $wpdb;
    $table_name = $wpdb->prefix.'venture_plugin_settings';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        //table not in database. Create new table
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
          option_id int(9) NOT NULL AUTO_INCREMENT,
          option_name VARCHAR (20) NOT NULL,
          option_category VARCHAR(10) NOT NULL,
          option_value text,
          UNIQUE KEY  (option_id)) $charset_collate";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $array_settings=array('option_name'=>'email_settings','option_category'=> 'email');
        $sql = $wpdb->insert ($table_name, $array_settings);
        $wpdb->query ( $sql );
    }


    $table_name = 'customers';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        //table not in database. Create new table
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
               id int(32) NOT NULL AUTO_INCREMENT,
              first_name varchar(45) DEFAULT NULL,
              last_name varchar(45) DEFAULT NULL,
              email varchar(45) DEFAULT NULL,
              date_created timestamp NULL DEFAULT CURRENT_TIMESTAMP,
              account_id varchar(45) DEFAULT NULL,
              main_tp_account varchar(45) DEFAULT NULL,
              phone_ccode varchar(10) DEFAULT NULL,
              phone_acode varchar(10) DEFAULT NULL,
              phone_number varchar(45) DEFAULT NULL,
              country varchar(45) DEFAULT NULL,
              address1 varchar(45) DEFAULT NULL,
              address2 varchar(45) DEFAULT NULL,
              city varchar(45) DEFAULT NULL,
              state varchar(45) DEFAULT NULL,
              post_code varchar(45) DEFAULT NULL,
              token varchar(100) DEFAULT NULL,
              business_unit varchar(10) DEFAULT NULL,
              PRIMARY KEY (id),
              UNIQUE KEY  (id)
     ) $charset_collate";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

    $table_name = 'leads';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        //table not in database. Create new table
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id int(32) NOT NULL AUTO_INCREMENT,
            first_name varchar(45) DEFAULT NULL,
            last_name varchar(45) DEFAULT NULL,
            email varchar(45) DEFAULT NULL,
            country varchar(45) DEFAULT NULL,
            date_created timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            account_id varchar(75) DEFAULT NULL,
            phone varchar(45) DEFAULT NULL,
            converted tinyint(2) DEFAULT '0',
            PRIMARY KEY (id),
            UNIQUE KEY  (id)
     ) $charset_collate";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }


    $table_name = 'error_logs';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        //table not in database. Create new table
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
                  id int(11) NOT NULL AUTO_INCREMENT,
                  date_created timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                  service varchar(45) DEFAULT NULL,
                  request text,
                  response text,
                  PRIMARY KEY (id),
                  UNIQUE KEY  (id)) $charset_collate";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }


    $table_name = 'customer_documents';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
                  id int(11) NOT NULL AUTO_INCREMENT,
                  email varchar(45) DEFAULT NULL,
                  document_type varchar(45) DEFAULT NULL,
                  file_name text DEFAULT NULL,
                  date_uploaded timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                  request_id varchar(45) DEFAULT NULL,
                  PRIMARY KEY (id),
                  UNIQUE KEY (id)) $charset_collate";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    //!Add the values on database From Connection to CRM
}


//! Register Hook - On Activate Plugin
register_activation_hook( __FILE__, 'venture_activate' );


//! Remove Admin Bar Action
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'remove_admin_bar');


//!Define Our Paths for this Plugin
define( 'VENTURE_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'VENTURE_PLUGIN_FILE_PATH', __FILE__ );
define( 'VENTURE_VIEWS', VENTURE_PLUGIN_PATH.'views' );

require_once ($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

//!If User is Admin then Extend the Functionality
if (true) {
    //! pending
    require_once(VENTURE_PLUGIN_PATH.'admin/venture-admin.class.php');
    $admin_class= new VentureAdmin();
}

$DOCUMENT_ROOT = $_SERVER ['DOCUMENT_ROOT'];
require_once ($DOCUMENT_ROOT . '/wp-load.php');
require_once('venture-base.class.php');
$base_class= new VentureBase();



?>