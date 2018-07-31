<?php
require_once 'protected/components/Functions.php';
require_once 'vendor/autoload.php';

/**
* @author Edwin Sturt
*/
class VantivPay
{
	var $sale_info = [];
	var $output;
    var $enableSMS =true;

	public function setSMS($bool){
	    $this->enableSMS = $bool;
	    return $this;
    }

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
	    if($this->enableSMS) {
            $sid = "AC47f21a90f34e179176e30f2e16cf196a"; // Your Account SID from www.twilio.com/console
            $token = "53790b10d4fd38e0907af88d2ff8a280"; // Your Auth Token from www.twilio.com/console
$twilio_number = "+12512205568";
            $client = new Twilio\Rest\Client($sid, $token);
            $message = $client->messages->create(
                $mobile, // Text this number
                array(
                      'from' => $twilio_number, // From a valid Twilio number
                    'body' => $msg
                )
            );
        }

        return $this;
    }


    public function sendEmails($to='',$from='',$subject='',$body='' , $record_id='')
    {                
             
       
                     $mail=Yii::app()->Smtpmail;

                 Yii::app()->Smtpmail->class='application.extensions.smtpmail.PHPMailer';
                Yii::app()->Smtpmail->Host='smtp.gmail.com';
                Yii::app()->Smtpmail->Username='dhananjaya@zolipe.com';
                Yii::app()->Smtpmail->Password='9740738448';
                Yii::app()->Smtpmail->Port='465';
                Yii::app()->Smtpmail->SMTPSecure='ssl';
                //Yii::app()->Smtpmail->CharSet="utf-8";
                
                $mail->SetFrom($from, '');
                $mail->Subject = $subject;
                $mail->MsgHTML($body);
                $mail->AddAddress($to, "");
                if(!$mail->Send()) {                    
                    $mail->ClearAddresses();    
                    $send_msg=t("error occurred")." ".$mail->ErrorInfo;
                } else {                    
                    $mail->ClearAddresses();
                    $send_status=true;
                    $send_msg="sent";
                }                       
               return $this;
        }

    public function getOutput(){
	    
        // if (isset($this->data['email'])){
        //     $content="This is a test email vantivvv";
        // }
        return $this->output;
       // echo $this->sendEmail('dhananjaya@zolipe.com','dhananjaya@zolipe.com', 'hello', 'msg','1');
    }

}




