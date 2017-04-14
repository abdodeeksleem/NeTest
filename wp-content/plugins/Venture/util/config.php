<?php
//! This Global config will be change and added as part of base class
global $config;



$config = array(
    'bu_en' => array(
        'wsdl' => 'http://ettemad.tradingcrm.com:8085/mex',
        'apiLocation' => 'https://ettemad.tradingcrm.com:8086/CrmServiceBasic',
        'organization' => 'Ettemad',
        'businessUnitName' => 'Arabic',
        'ownerUserId' => '13957118-BCC5-E511-80CE-005056B11811',
        'username' => 'ettemad',
        'password' => 'JneIKq4Kg5',
        'tradingPlatforms' => array(
            /*     'DEMO-SIRIX' => array(
                     'name' => 'TPSIRIXDemo',
                     'id' => '0fe6f702-bdc5-e511-80ce-005056b11811'),*/
            'REAL-SIRIX' => array(
                'name' => 'TPSIRIXReal',
                'id' =>  '75416E34-BDC5-E511-80CE-005056B11811'),
        ),
        'wsdlCache' => WSDL_CACHE_MEMORY
    ),
    'bu_ar' => array(
        'wsdl' =>'http://ettemad.tradingcrm.com:8085/mex',
        'apiLocation' => 'https://ettemad.tradingcrm.com:8086/CrmServiceBasic',
        'organization' => 'Ettemad',
        'businessUnitName' => 'Arabic',
        'ownerUserId' => '13957118-BCC5-E511-80CE-005056B11811',
        'username' => 'ettemad',
        'password' => 'JneIKq4Kg5',
        'tradingPlatforms' => array(
            /*'DEMO-SIRIX' => array(
                'name' => 'TPSIRIXDemo',
                'id' => '0fe6f702-bdc5-e511-80ce-005056b11811'),*/
            'REAL-SIRIX' => array(
                'name' => 'TPSIRIXReal',
                'id' =>  '75416E34-BDC5-E511-80CE-005056B11811',
            ),
        ),
        'wsdlCache' => WSDL_CACHE_MEMORY
    )
);
