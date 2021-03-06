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
<style>
    /*
   * === CC VALIDATION BEGIN ===
   */

    .card-number .icon {
        position: absolute;
        right: 17px;
        top: 50%;
        color: #1e88e5;
        font-size: 34px;
        margin-top: -17px;
    }

    .card-number-color .icon {
        color: #1e88e5;
    }

    .card-number .ccicon_visa,
    .card-number .ccicon_discover,
    .card-number .ccicon_mastercard,
    .card-number .ccicon_amex,
    .card-number .ccicon_jcb,
    .card-number .ccicon_unionpay {
        font-size: 26px;
        margin-top: -13px;
    }

    .floatinglabel > div.input-validation-error {
        color: #e53935;
    }

    .input-validation-icon {
        position: absolute;
        right: 17px;
        top: 60%;
        color: #fff;
        font-size: 20px;
        margin-top: -15px;
    }

    /* Hide validation error by default. */
    .input-validation-error {
        display :none;
    }

    /* Apply display logic to validation error. */
    label.validation-error > .input-validation-error {
        display: block;
        font-size: 12px;
        position: absolute;
        bottom: -25px;
        left: 2px;
    }

    label.validation-error > .input-validation-icon {
        color: red;
    }

    label.validation-error > .valid_inputCardExpiry,
    label.validation-error > .valid_cc_cscv,
    label.validation-error > .valid_cc_number {
        border-color: red;
    }

    @media only screen and (min-width : 320px) and (max-width : 700px) {
        label.card-number,
        label.expiry-date,
        label.cvv-number {
            margin-bottom:24px;
        }
    }


    /*
    * === CC VALIDATION END ===
    */

</style>
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

	<form id="ProcessVntPay" onsubmit="return false;" method="POST">

        <input type="hidden" name="action" value="VntProcessPay">
    <input type="hidden" value="<?php echo $data['order_id']?>" name="order_id">


        <div class="row top10">
            <div class="credit-card">

                <img src="https://prismic-io.s3.amazonaws.com/mozu/7abbe19bd88b2346e5711f34b6b58649852fdfd5_90b14467-ca1f-4a6c-9287-a3f63324bedc.png" alt="Vantiv Ecommerce">

                <div class="form-header">
                    <h4 class="title">Credit card detail</h4>
                </div>

                <div class="form-body">

                    <label class="floatinglabel flexwidthhalfcc responsiveccfullwidth card-number card-number-color">
                        <span>Card Number</span>
                        <input class="form-control valid_cc_number" type="text" name="cc_number" value="" autocomplete="off" placeholder="Card Number" required>
                        <i></i>
                        <div class="input-validation-error">Invalid Card Number</div>
                    </label>
                    <label class="floatinglabel flexwidthquartercc responsiveccfullwidth expiry-date">
                        <span>MM/YY</span>
                        <input class="form-control valid_inputCardExpiry" type="text" name="cc_expiry" value="" placeholder="MM/YY" autocomplete="off" maxlength="7" required>
                        <i></i>
                        <div class="input-validation-error">Invalid Date</div>
                    </label>
                    <label class="floatinglabel flexwidthquartercc responsiveccfullwidth cvv-number">
                        <span>CVV</span>
                        <input class="form-control valid_cc_cscv" type="text" name="cc_cscv" value="" autocomplete="off" placeholder="CVV" maxlength="4" required>
                        <i></i>
                        <div class="input-validation-error">Invalid CVV</div>
                    </label>

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