<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 26/01/2016
 * Time: 11:13 ΠΜ
 */

function venture_activate() {
    //!Initialization of Plugin

    //!Create the tables
    global $wpdb;
    $table_name = $wpdb->prefix.'venture_plugin_settings';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        //table not in database. Create new table
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
          option_id mediumint(9) NOT NULL AUTO_INCREMENT,
          option_name VARCHAR (20) NOT NULL,
          option_category VARCHAR(10) NOT NULL
          UNIQUE KEY  (id)) $charset_collate";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
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
              phone_number varchar(45) DEFAULT NULL,
              country varchar(45) DEFAULT NULL,
              address1 varchar(45) DEFAULT NULL,
              city varchar(45) DEFAULT NULL,
              state varchar(45) DEFAULT NULL,
              post_code varchar(45) DEFAULT NULL,
              token varchar(100) DEFAULT NULL,
              PRIMARY KEY (id),
              UNIQUE KEY account_id_UNIQUE (account_id)
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
            UNIQUE KEY id_UNIQUE (id)
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
                  PRIMARY KEY (id)
     ) $charset_collate";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }



}