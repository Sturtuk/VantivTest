<?php
require_once 'vendor/autoload.php';


use litle\sdk\XmlParser;
/**
* @author Edwin Sturt
*/
class VantivPay
{
	var $sale_info = [];
	var $saleResponse;

	public function PaymentData(array $data){

        $initialize = new litle\sdk\LitleOnlineRequest();
        $saleResponse =   $initialize->authorizationRequest($data);

        print_r($saleResponse);

        $response = XmlParser::getNode($saleResponse,'response');
        $message = XmlParser::getNode($saleResponse,'message');
        $transid =  XmlParser::getNode($saleResponse,'litleTxnId');

        $data =  [
            'status'    =>  $response,
            'msg'       =>  $message,
            'transId'   =>  $transid,
        ];

        echo json_encode($data);

	}

}

$VApp = new VantivPay();


