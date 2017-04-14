<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 22/03/2016
 * Time: 11:31 ΠΜ
 */

function get_countries2(){

    $sql="select * FROM countries ";

    return execute_select($sql);
}



function execute_select($sql){

    global $wpdb;
    $results = $wpdb->get_results($sql, ARRAY_A);

    if (!empty($results)) {
        return $results;
    } else {
        return false;
    }
}


function get_currencies(){

    $data=execute_select("SELECT * FROM forex_groups group by currency_name;");

    return $data;

}


function exist_lead($account_id){

    $data=execute_select("SELECT * FROM leads WHERE account_id='$account_id';");

    return $data;

}


function get_country_by_id($country_id){

    $data=execute_select("SELECT * FROM countries WHERE guid='$country_id';");

    return $data[0];

}

function get_country_by_name($country_name){

    $data=execute_select("SELECT * FROM countries WHERE name='$country_name';");

    return $data[0];

}