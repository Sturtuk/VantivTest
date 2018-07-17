<?php
require_once 'vendor/autoload.php';

print_r($_REQUEST);
#sale
$sale_info = array(

           'id' => $_REQUEST['id'],
             'orderId' => $_REQUEST['orderId'],
             'amount'  => $_REQUEST['amount'],
             'orderSource' => 'ecommerce',
             'billToAddress' => [
                             'name' => 'John Smith' ,
                             'addressLine1' => ' 1 Main St.',
                             'city' => 'Burlington' ,
                             'state' => 'MA' ,
                             'zip' => '0183-3747',
                             'country' => 'US'
             ],
             'card' => [
                         'number' => '5112010000000003',
                         'expDate' => '0112',
                         'cardValidationNum' => '349',
                         'type' => 'MC'
                 ]
            );
$initialize = new litle\sdk\LitleOnlineRequest();
$saleResponse =$initialize->saleRequest($sale_info);
#display results
echo ("Response: " . (litle\sdk\XmlParser::getNode($saleResponse,'response')) . "<br>");
echo ("Message: " . litle\sdk\XmlParser::getNode($saleResponse,'message') . "<br>");
echo ("Vantiv eCommerce Transaction ID: " . litle\sdk\XmlParser::getNode($saleResponse,'litleTxnId'));