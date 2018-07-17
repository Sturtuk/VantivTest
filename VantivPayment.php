<?php
require_once 'vendor/autoload.php';

/**
* @author Edwin Sturt
*/
class VantivPay
{
	var $sale_info = [];

	function __construct($argument)
	{
		
	}
	public function PaymentData($data = ''){
		$sale_info = [
		     	 'id' => $data[''],
	             'orderId' => $data[''],
	             'amount'  => $data[''],
	             'orderSource' => 'ecommerce',
	             'billToAddress' => 
	             		 [
				             'name' 			=>  $data[''],
				             'addressLine1' 	=>  $data[''],
				             'city' 			=>  $data[''],
				             'state' 			=>  $data[''],
				             'zip' 				=>  $data[''],
				             'country' 			=> 	$data['']
				         ],
				'card' => 
				         [
				             'number' => $data[''],
				             'expDate' => $data[''],
				             'cardValidationNum' => $data[''],
				             'type' => $data['']
				         ]
	            ];
	            
		return $this;

	}
	public function ProcessPayment(){
		
				$initialize = new litle\sdk\LitleOnlineRequest();
				$saleResponse =$initialize->saleRequest($sale_info);
				#display results
				echo ("Response: " . (litle\sdk\XmlParser::getNode($saleResponse,'response')) . "<br>");
				echo ("Message: " . litle\sdk\XmlParser::getNode($saleResponse,'message') . "<br>");
				echo ("Vantiv eCommerce Transaction ID: " . litle\sdk\XmlParser::getNode($saleResponse,'litleTxnId'));
	}

	public function processPay($data ){
	    $this->PaymentData()->ProcessPayment();
    }
}

