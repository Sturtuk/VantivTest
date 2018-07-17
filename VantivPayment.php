<?php
require_once 'vendor/autoload.php';
ini_set("display_errors","on");

use Symfony\Component\HttpFoundation\Response;
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
        $saleResponse =   $initialize->saleRequest($data);

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


