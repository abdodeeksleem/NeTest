<?php
include_once('config.php');
include_once('SoapProxy.php');
include_once('LeverateCrm.php');

function view($viewName, $values) {
    extract($values);
    $isServicesConfigured = true;
    include_once(VENTURE_VIEWS.'/main.php');
}

function getCrm($config) {
    return new LeverateCrm($config['wsdl'], array(
        'login' => $config['username'],
        'password' => $config['password'],
        'location' => $config['apiLocation'],
        'encoding'=>'UTF-8',
        'cache_wsdl' => $config['wsdlCache'],
        'trace' => true,
    ));
}
