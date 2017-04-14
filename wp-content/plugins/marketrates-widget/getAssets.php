<?php

$ch = curl_init();
// set url
curl_setopt($ch, CURLOPT_URL, "https://webrates.forexwebservices.com/MarketRates/GetData?crosses=DJIA%2CFTSE%2CNSDQ%2CSP500%2CEURUSD%2CUSDJPY%2CGBPUSD%2CUSDCHF%2CCrudeOil%2CGold%2CSilver%2CNaturalGas");

//curl_setopt($ch, CURLOPT_URL, "https://webrates.forexwebservices.com/MarketRates/GetData?crosses=DJIA%2CFTSE%2CNSDQ%2CSP500%2CDAX%2CEURUSD%2CUSDJPY%2CGBPUSD%2CUSDCHF%2CUSDCAD%2CCrudeOil%2CGold%2CSilver%2CNaturalGas");

// set header
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// $output contains the output string
$output = curl_exec($ch);
// close curl resource to free up system resources
curl_close($ch);
// Output admin widget options form
echo json_encode(trim($output, '()'));

exit;