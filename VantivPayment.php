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
        $sid = "AC47f21a90f34e179176e30f2e16cf196a"; // Your Account SID from www.twilio.com/console
        $token = "53790b10d4fd38e0907af88d2ff8a280"; // Your Auth Token from www.twilio.com/console

        $client = new Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
            'ZOLIPE', // Text this number
            array(
                'from' => $mobile, // From a valid Twilio number
                'body' => $msg
            )
        );

        return $this;
    }

    public function getOutput(){
	    return $this->output;
    }

}




