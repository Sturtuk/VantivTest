<?php
require_once 'vendor/autoload.php';


$initialize = new litle\sdk\LitleOnlineRequest();
$saleResponse =$initialize->saleRequest($_REQUEST);
#display results
echo ("Response: " . (litle\sdk\XmlParser::getNode($saleResponse,'response')) . "<br>");
echo ("Message: " . litle\sdk\XmlParser::getNode($saleResponse,'message') . "<br>");
echo ("Vantiv eCommerce Transaction ID: " . litle\sdk\XmlParser::getNode($saleResponse,'litleTxnId'));