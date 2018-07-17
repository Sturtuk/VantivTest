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

//        $initialize = new litle\sdk\LitleOnlineRequest();
//        $this->saleResponse =$initialize->authorizationRequest($data);

        $auth_info = array(
            'orderId' => '1',
            'amount' => '10010',
            'id'=> '456',
            'orderSource'=>'ecommerce',
            'billToAddress'=>array(
                'name' => 'John Smith',
                'addressLine1' => '1 Main St.',
                'city' => 'Burlington',
                'state' => 'MA',
                'zip' => '01803-3747',
                'country' => 'US'
            ),
            'paypage'=>array(
                'paypageRegistrationId' =>'4457010000000009',
                'expDate' => '0112',
                'cardValidationNum' => '349'
            )
        );

        $initialize = new litle\sdk\LitleOnlineRequest();
        $this->saleResponse = $initialize->authorizationRequest($auth_info);
	            
		return $this;

	}
	public function ProcessPayment(){
	    print_r($this->saleResponse);
//				$response = (XmlParser::getNode($this->saleResponse,'response'));
//				$message = XmlParser::getNode($this->saleResponse,'message');
//				echo ("Vantiv eCommerce Transaction ID: " . XmlParser::getNode($this->saleResponse,'litleTxnId'));
	}

}

$VApp = new VantivPay();


