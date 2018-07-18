<?php
require_once 'vendor/autoload.php';

/**
* @author Edwin Sturt
*/
class VantivPay
{
	var $sale_info = [];
	var $output;


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
            'OrderID'   =>  $data['orderId'],
        ];

        $this->output = json_encode($res_data);
        return $this;
	}

	public function SendSms($mobile = '',$msg){
        $sid = "AC1c193f28ca84f5765defc58d17452c0e"; // Your Account SID from www.twilio.com/console
        $token = "b58fe761181e136bf154163957984a69"; // Your Auth Token from www.twilio.com/console

        $client = new Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
            $mobile, // Text this number
            array(
                'from' => '918296585594', // From a valid Twilio number
                'body' => $msg
            )
        );

        return $this;
    }

    public function getOutput(){
	    return $this->output;
    }

}




