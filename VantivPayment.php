<?php
require_once 'vendor/autoload.php';

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


        $response =  (litle\sdk\XmlParser::getNode($saleResponse,'response'));
        $message = (litle\sdk\XmlParser::getNode($saleResponse,'message'));
        $transid =  (litle\sdk\XmlParser::getNode($saleResponse,'litleTxnId'));

        $res_data =  [
            'status'    =>  $response,
            'msg'       =>  $message,
            'transId'   =>  $transid,
        ];

        echo json_encode($res_data);

	}

}

$VApp = new VantivPay();


