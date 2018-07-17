<?php
require_once 'vendor/autoload.php';
ini_set("display_errors","on");
use Symfony\Component\HttpFoundation\Request;
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
	            
		return $this;

	}
	public function ProcessPayment(){
				$response = (XmlParser::getNode($this->saleResponse,'response'));
				$message = XmlParser::getNode($this->saleResponse,'message');
				echo ("Vantiv eCommerce Transaction ID: " . XmlParser::getNode($this->saleResponse,'litleTxnId'));
	}

}

$VApp = new VantivPay();


