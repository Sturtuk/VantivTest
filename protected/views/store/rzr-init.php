<?php
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Payment"),
   'sub_text'=>t("")
));

$this->renderPartial('/front/order-progress-bar',array(
   'step'=>4,
   'show_bar'=>true
));
//dump($credentials);
?>
<div class="sections section-grey2 section-orangeform">
  <div class="container">
  <div class="row top30">
  <div class="inner">
  <h1><?php echo t("Pay using")." ".t("Vantiv Payment Gateway")?></h1>
  <div class="box-grey rounded">
  <?php if ( !empty($error)):?>
  <p class="text-danger"><?php echo $error;?></p>
  <?php else :?>


  	<div class="row top10">
	  <div class="col-md-3"><?php echo t("Amount")?></div>
	  <div class="col-md-8">
	    <?php echo FunctionsV3::prettyPrice($amount_to_pay)?>
	  </div>
	</div>

	<div class="row top10">
	<div class="col-md-12">

	<form action="<?php echo Yii::app()->createUrl('/store/top10',array('xid'=>$data['order_id']))?>" method="POST">
    <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $credentials['key_id']?>"
    data-amount="<?php echo $amount;?>"
    data-buttontext="<?php echo t("Pay Now")?>"
    data-name="<?php echo clearString($data['merchant_name'])?>"
    data-description="<?php echo $payment_description?>"
    data-image="<?php //echo FrontFunctions::getLogoURL();?>"
    data-prefill.name="<?php echo $_SESSION['kr_client']['first_name']." ".$_SESSION['kr_client']['last_name']?>"
    data-prefill.email="<?php echo $_SESSION['kr_client']['email_address']?>"
    data-prefill.contact="<?php echo $_SESSION['kr_client']['contact_phone']?>"
    data-theme.color="#F37254"></script>
    <input type="hidden" value="<?php echo $data['order_id']?>" name="hidden">


        <div class="row top10">
            <div class="credit-card">

                <img src="https://prismic-io.s3.amazonaws.com/mozu/7abbe19bd88b2346e5711f34b6b58649852fdfd5_90b14467-ca1f-4a6c-9287-a3f63324bedc.png" alt="Vantiv Ecommerce">

                <div class="form-header">
                    <h4 class="title">Credit card detail</h4>
                </div>

                <div class="form-body">

                    <!-- Card Number -->
                    <input type="text" name="card-number" class="card-number" placeholder="Card Number" data-validation="required" data-validation-allowing="visa, mastercard, amex">

                    <!-- Date Field -->
                    <div class="date-field">
                        <div class="month">
                            <select data-validation="required" name="Month">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="year">
                            <select data-validation="required" name="Year">
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                    </div>

                    <!-- Card Verification Field -->
                    <div class="card-verification">
                        <div class="cvv-input">
                            <input name="ccv" data-validation="required" type="text" placeholder="CVV">
                        </div>
                        <div class="cvv-details">
                            <p>3 or 4 digits usually found <br> on the signature strip</p>
                        </div>
                    </div>

                    <input type="button" value="Process Payment" id="VantivPayBtn" >


                </div>


            </div>
        </div>

    <p style="margin-top:20px;" class="text-small">
    <?php echo t("Please don't close the window during payment, wait until you redirected to receipt page")?></p>

    </form>

    </div>
    </div>

  <?php endif;?>

   <div class="top25">
     <a href="<?php echo Yii::app()->createUrl('/store/paymentoption')?>">
     <i class="ion-ios-arrow-thin-left"></i> <?php echo Yii::t("default","Click here to change payment option")?></a>
    </div>

    </div>
   </div>
  </div>
 </div>
</div>