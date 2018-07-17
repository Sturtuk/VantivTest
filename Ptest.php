<?php
require_once 'vendor/autoload.php';
#sale
$sale_info = array(
      'user' => 'JoesStore',
   'password' => 'JoeyIsTheBe$t',
   'currency_merchant_map'    =>    [
            'DEFAULT'  =>    'USD'
      ],
   'proxy'  =>    '',
      'reportGroup' => 'Default Report Group',

           'id' => '12345',
             'orderId' => '1',
             'amount'  => '10010',
             'orderSource' => 'ecommerce',
             'billToAddress' => array(
             'name' => 'John Smith' ,
             'addressLine1' => ' 1 Main St.',
             'city' => 'Burlington' ,
             'state' => 'MA' ,
             'zip' => '0183-3747',
             'country' => 'US'),
             'card' => array(
             'number' => '5112010000000003',
             'expDate' => '0112',
             'cardValidationNum' => '349',
             'type' => 'MC' )
            );
$initialize = new litle\sdk\LitleOnlineRequest();
$saleResponse =$initialize->saleRequest($sale_info);
#display results
echo ("Response: " . (litle\sdk\XmlParser::getNode($saleResponse,'response')) . "<br>");
echo ("Message: " . litle\sdk\XmlParser::getNode($saleResponse,'message') . "<br>");
echo ("Vantiv eCommerce Transaction ID: " . litle\sdk\XmlParser::getNode($saleResponse,'litleTxnId'));