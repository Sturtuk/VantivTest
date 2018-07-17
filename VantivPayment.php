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
        $this->saleResponse =$initialize->saleRequest($data);
        $response = (XmlParser::getNode($this->saleResponse,'response'));
        $message = XmlParser::getNode($this->saleResponse,'message');
        $transid =  XmlParser::getNode($this->saleResponse,'litleTxnId');

        $data =  [
            'status'    =>  $response,
            'msg'       =>  $message,
            'transId'   =>  $transid,
        ];

        echo json_encode($data);

	}

}

$VApp = new VantivPay();


