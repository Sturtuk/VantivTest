<?php
require_once 'vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request;
use litle\sdk\XmlParser;
/**
* @author Edwin Sturt
*/
class VantivPay
{
	var $sale_info = [];
	var $saleResponse;

	public function PaymentData(Request $request){
		$sale_info = [
		     	 'orderId' => $request->get('first_name'),
	             'amount'  => $request->get('first_name'),
	             'orderSource' => 'ecommerce',
	             'billToAddress' => 
	             		 [
				             'name' 			=>  $request->get('first_name'),
				             'addressLine1' 	=>  $request->get('first_name'),
				             'city' 			=>  $request->get('first_name'),
				             'state' 			=>  $request->get('first_name'),
				             'zip' 				=>  $request->get('first_name'),
				             'country' 			=> 	$request->get('first_name')
				         ],
				'card' => 
				         [
				             'number' => $request->get('first_name'),
				             'expDate' => $request->get('first_name'),
				             'cardValidationNum' => $request->get('first_name'),
				             'type' => $request->get('first_name')
				         ]
	            ];
        $initialize = new litle\sdk\LitleOnlineRequest();
        $this->saleResponse =$initialize->saleRequest($sale_info);
	            
		return $this;

	}
	public function ProcessPayment(){
				$response = (XmlParser::getNode($this->saleResponse,'response'));
				$message = XmlParser::getNode($this->saleResponse,'message');
				echo ("Vantiv eCommerce Transaction ID: " . XmlParser::getNode($this->saleResponse,'litleTxnId'));
	}

	public function processPay(){

	    $this->PaymentData()->ProcessPayment();
    }
}

$App = new VantivPay();


