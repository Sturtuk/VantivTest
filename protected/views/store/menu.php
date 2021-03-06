<?php
/*POINTS PROGRAM*/
if (FunctionsV3::hasModuleAddon("pointsprogram")){
	unset($_SESSION['pts_redeem_amt']);
	unset($_SESSION['pts_redeem_points']);
}

$merchant_photo_bg=getOption($merchant_id,'merchant_photo_bg');
if ( !file_exists(FunctionsV3::uploadPath()."/$merchant_photo_bg")){
	$merchant_photo_bg='';
} 

/*RENDER MENU HEADER FILE*/

/*GET MINIMUM ORDER*/

$min_fees=FunctionsV3::getMinOrderByTableRates($merchant_id,
   $distance,
   $distance_type,
   $data['minimum_order']
);

$ratings=Yii::app()->functions->getRatings($merchant_id);   
$merchant_info=array(   
  'merchant_id'=>$merchant_id ,
  //'minimum_order'=>$data['minimum_order'],
  'minimum_order'=>$min_fees,
  'ratings'=>$ratings,
  'merchant_address'=>$data['merchant_address'],
  'cuisine'=>$data['cuisine'],
  'restaurant_name'=>$data['restaurant_name'],
  'background'=>$merchant_photo_bg,
  'merchant_website'=>$merchant_website,
  'merchant_logo'=>FunctionsV3::getMerchantLogo($merchant_id),
  'contact_phone'=>$data['contact_phone'],
  'restaurant_phone'=>$data['restaurant_phone'],
  'social_facebook_page'=>$social_facebook_page,
  'social_twitter_page'=>$social_twitter_page,
  'social_google_page'=>$social_google_page,
);
$this->renderPartial('/front/menu-header',$merchant_info);

/*ADD MERCHANT INFO AS JSON */
$cs = Yii::app()->getClientScript();
$cs->registerScript(
  'merchant_information',
  "var merchant_information =".json_encode($merchant_info)."",
  CClientScript::POS_HEAD
);		

/*PROGRESS ORDER BAR*/
$this->renderPartial('/front/order-progress-bar',array(
   'step'=>3,
   'show_bar'=>true
));

$now=date('Y-m-d');
$now_time='';

$checkout=FunctionsV3::isMerchantcanCheckout($merchant_id); 
$menu=Yii::app()->functions->getMerchantMenu($merchant_id , isset($_GET['sname'])?$_GET['sname']:'' ); 
//dump($menu);die();

//dump($checkout);

echo CHtml::hiddenField('is_merchant_open',isset($checkout['code'])?$checkout['code']:'' );

/*hidden TEXT*/
echo CHtml::hiddenField('restaurant_slug',$data['restaurant_slug']);
echo CHtml::hiddenField('merchant_id',$merchant_id);
echo CHtml::hiddenField('is_client_login',Yii::app()->functions->isClientLogin());

echo CHtml::hiddenField('website_disbaled_auto_cart',
Yii::app()->functions->getOptionAdmin('website_disbaled_auto_cart'));

$hide_foodprice=Yii::app()->functions->getOptionAdmin('website_hide_foodprice');
echo CHtml::hiddenField('hide_foodprice',$hide_foodprice);

echo CHtml::hiddenField('accept_booking_sameday',getOption($merchant_id
,'accept_booking_sameday'));

echo CHtml::hiddenField('customer_ask_address',getOptionA('customer_ask_address'));

echo CHtml::hiddenField('merchant_required_delivery_time',
  Yii::app()->functions->getOption("merchant_required_delivery_time",$merchant_id));   
  
/** add minimum order for pickup status*/
$merchant_minimum_order_pickup=Yii::app()->functions->getOption('merchant_minimum_order_pickup',$merchant_id);
if (!empty($merchant_minimum_order_pickup)){
	  echo CHtml::hiddenField('merchant_minimum_order_pickup',$merchant_minimum_order_pickup);
	  
	  echo CHtml::hiddenField('merchant_minimum_order_pickup_pretty',
         displayPrice(baseCurrency(),prettyFormat($merchant_minimum_order_pickup)));
}
 
$merchant_maximum_order_pickup=Yii::app()->functions->getOption('merchant_maximum_order_pickup',$merchant_id);
if (!empty($merchant_maximum_order_pickup)){
	  echo CHtml::hiddenField('merchant_maximum_order_pickup',$merchant_maximum_order_pickup);
	  
	  echo CHtml::hiddenField('merchant_maximum_order_pickup_pretty',
         displayPrice(baseCurrency(),prettyFormat($merchant_maximum_order_pickup)));
}  

/*add minimum and max for delivery*/
//$minimum_order=Yii::app()->functions->getOption('merchant_minimum_order',$merchant_id);
$minimum_order=$min_fees;
if (!empty($minimum_order)){
	echo CHtml::hiddenField('minimum_order',unPrettyPrice($minimum_order));
	echo CHtml::hiddenField('minimum_order_pretty',
	 displayPrice(baseCurrency(),prettyFormat($minimum_order))
	);
}
$merchant_maximum_order=Yii::app()->functions->getOption("merchant_maximum_order",$merchant_id);
 if (is_numeric($merchant_maximum_order)){
 	echo CHtml::hiddenField('merchant_maximum_order',unPrettyPrice($merchant_maximum_order));
    echo CHtml::hiddenField('merchant_maximum_order_pretty',baseCurrency().prettyFormat($merchant_maximum_order));
 }

$is_ok_delivered=1;
if (is_numeric($merchant_delivery_distance)){
	if ( $distance>$merchant_delivery_distance){
		$is_ok_delivered=2;
		/*check if distance type is feet and meters*/
		//if($distance_type=="ft" || $distance_type=="mm" || $distance_type=="mt"){
		if($distance_type=="ft" || $distance_type=="mm" || $distance_type=="mt" || $distance_type=="meter"){
			$is_ok_delivered=1;
		}
	}
} 

echo CHtml::hiddenField('is_ok_delivered',$is_ok_delivered);
echo CHtml::hiddenField('merchant_delivery_miles',$merchant_delivery_distance);
echo CHtml::hiddenField('unit_distance',$distance_type);
echo CHtml::hiddenField('from_address', FunctionsV3::getSessionAddress() );

echo CHtml::hiddenField('merchant_close_store',getOption($merchant_id,'merchant_close_store'));
/*$close_msg=getOption($merchant_id,'merchant_close_msg');
if(empty($close_msg)){
	$close_msg=t("This restaurant is closed now. Please check the opening times.");
}*/
echo CHtml::hiddenField('merchant_close_msg',
isset($checkout['msg'])?$checkout['msg']:t("Sorry merchant is closed."));

echo CHtml::hiddenField('disabled_website_ordering',getOptionA('disabled_website_ordering'));
echo CHtml::hiddenField('web_session_id',session_id());

echo CHtml::hiddenField('merchant_map_latitude',$data['latitude']);
echo CHtml::hiddenField('merchant_map_longtitude',$data['lontitude']);
echo CHtml::hiddenField('restaurant_name',$data['restaurant_name']);


echo CHtml::hiddenField('current_page','menu');

if ($search_by_location){
	echo CHtml::hiddenField('search_by_location',$search_by_location);
}

echo CHtml::hiddenField('minimum_order_dinein',FunctionsV3::prettyPrice($minimum_order_dinein));
echo CHtml::hiddenField('maximum_order_dinein',FunctionsV3::prettyPrice($maximum_order_dinein));

/*add meta tag for image*/
Yii::app()->clientScript->registerMetaTag(
Yii::app()->getBaseUrl(true).FunctionsV3::getMerchantLogo($merchant_id)
,'og:image');

$remove_delivery_info=false;
if($data['service']==3 || $data['service']==6 || $data['service']==7 ){	
	$remove_delivery_info=true;
}

/*CHECK IF MERCHANT SET TO PREVIEW*/
$is_preview=false;
if ($food_viewing_private==2){		
	if (isset($_GET['preview'])){
		if($_GET['preview']=='true'){
			if(!isset($_GET['token'])){
				$_GET['token']='';
			}
			if (md5($data['password'])==$_GET['token']){
			   $is_preview=true;
			}
		}
	}
	if($is_preview==false){
		$menu='';
		$enabled_food_search_menu='';
	}
}
?>

<div class="sections section-menu section-grey2">
<div class="container">
  <div class="row">

     <div class="col-md-8 border menu-left-content">
         
        <div class="tabs-wrapper" id="menu-tab-wrapper">
	    <ul id="tabs">
		    <li class="active">
		       <span><?php echo t("Menu")?></span>
		       <i class="ion-fork"></i>
		    </li>
		    
		    <?php if ($theme_hours_tab==""):?>
		    <li>
		       <span><?php echo t("Opening Hours")?></span>
		       <i class="ion-clock"></i>
		    </li>
		    <?php endif;?>
		    
		    <?php if ($theme_reviews_tab==""):?>
		    <li class="view-reviews">
		       <span><?php echo t("Reviews")?></span>
		       <i class="ion-ios-star-half"></i>
		    </li>
		    <?php endif;?>
		    
		    <?php if ($theme_map_tab==""):?>
		    <li class="view-merchant-map">
		       <span><?php echo t("Map")?></span>
		       <i class="ion-ios-navigate-outline"></i>
		    </li>
		    <?php endif;?>
		    
		    <?php if ($booking_enabled):?>
		      <li>
		      <span><?php echo t("Book a Table")?></span>
		      <i class="ion-coffee"></i>
		      </li>
		    <?php endif;?>
		    
		    <?php if ($photo_enabled):?>
		      <li class="view-merchant-photos">
		       <span><?php echo t("Photos")?></span>
		       <i class="ion-images"></i>
		      </li>
		    <?php endif;?>
		    
		    <?php if ($theme_info_tab==""):?>
		    <li>
		      <span><?php echo t("Information")?></span>
		      <i class="ion-ios-information-outline"></i>
		    </li>
		    <?php endif;?>
		    
		    <?php if ( $promo['enabled']==2 && $theme_promo_tab==""):?>
		      <li>
		       <span><?php echo t("Promos")?></span>
		       <i class="ion-pizza"></i>
		      </li>
		    <?php endif;?>
		</ul>

<!-- demooooooooo -->






 



		<ul id="tab">

		<!--MENU-->
	    <li class="active">
			<!-- <div class="food_fix">
			<?php foreach ($menu as $val):?>
				<div class="exp">
					<ul id="tabs">		  
					    
					   <?php if ($theme_menuu_tab==""):?>
					    <li class="click">
					        <span> <?php echo qTranslate($val['category_name'],'category_name',$val)?></span>
					       <i class="ion-clock"></i>
					    </li>
					    <?php endif;?>
					    
					</ul>
				</div>

					 <?php endforeach;?>
					 </div>
					</li>
		<!-- demoooooooooooooooo --> 

	        <div class="row">
			
			 <div class="col-md-8 col-xs-8 border" id="menu-list-wrapper">
			 
			 <?php if($enabled_food_search_menu==1):?>
			 <form method="GET" class="frm-search-food">			   
			 
			 <?php 
			 if($is_preview==true){
				 if(isset($_GET['preview'])){
				 	echo CHtml::hiddenField('preview','true');
				 }
				 if(isset($_GET['token'])){
				 	echo CHtml::hiddenField('token',$_GET['token']);
				 }
			 }
			 ?>
			 
			 <div class="search-food-wrap">						   
			   <?php echo CHtml::textField('sname',
			   isset($_GET['sname'])?$_GET['sname']:''
			   ,array(
			     'placeholder'=>t("Search"),
			     'class'=>"form-control search_foodname required"
			   ))?>
			   <button type="submit"><i class="ion-ios-search"></i></button>
			 </div>
			 
			 <?php if (isset($_GET['sname'])):?> 
			     <a href="<?php echo Yii::app()->createUrl('store/menu-'.$data['restaurant_slug'])?>">
			     [<?php echo t("Clear")?>]
			     </a>
			     <div class="clear"></div>
			   <?php endif;?>
			 </form>
			 <?php endif;?>
			 
			 <?php 
			 $admin_activated_menu=getOptionA('admin_activated_menu');			 
			 $admin_menu_allowed_merchant=getOptionA('admin_menu_allowed_merchant');
			 if ($admin_menu_allowed_merchant==2){			 	 
			 	 $temp_activated_menu=getOption($merchant_id,'merchant_activated_menu');			 	 
			 	 if(!empty($temp_activated_menu)){
			 	 	 $admin_activated_menu=$temp_activated_menu;
			 	 }
			 }			 
			 
			 $merchant_tax=getOption($merchant_id,'merchant_tax');
			 if($merchant_tax>0){
			    $merchant_tax=$merchant_tax/100;
			 }
				
			 switch ($admin_activated_menu)
			 {
			 	case 1:
			 		$this->renderPartial('/front/menu-merchant-2',array(
					  'merchant_id'=>$merchant_id,
					  'menu'=>$menu,
					  'disabled_addcart'=>$disabled_addcart
					));
			 		break;
			 		
			 	case 2:			 		
			 		$this->renderPartial('/front/menu-merchant-3',array(
					  'merchant_id'=>$merchant_id,
					  'menu'=>$menu,
					  'disabled_addcart'=>$disabled_addcart
					));
			 		break;
			 			
			 	default:	
				 	$this->renderPartial('/front/menu-merchant-1',array(
					  'merchant_id'=>$merchant_id,
					  'menu'=>$menu,
					  'disabled_addcart'=>$disabled_addcart,
					  'tc'=>$tc,
					  'merchant_apply_tax'=>getOption($merchant_id,'merchant_apply_tax'),
					  'merchant_tax'=>$merchant_tax>0?$merchant_tax:0,
					));
			    break;
			 }			 
			 ?>			
			 </div> <!--col-->
			</div> <!--row-->
	    </li>
	    <!--END MENU-->
	    
	    

<!--OPENING HOURS-->
	    <?php if ($theme_menuu_tab):?>
	    <li>	       	     
	    <?php
	    $this->renderPartial('/front/menu-merchant-1',array(
	      'merchant_id'=>$merchant_id
	    )); ?>           
	    </li>
	    <?php endif;?>
	    <!--END OPENING HOURS-->


	    <!--OPENING HOURS-->
	    <?php if ($theme_hours_tab==""):?>
	    <li>	       	     
	    <?php
	    $this->renderPartial('/front/merchant-hours',array(
	      'merchant_id'=>$merchant_id
	    )); ?>           
	    </li>
	    <?php endif;?>
	    <!--END OPENING HOURS-->


	    
	    <!--MERCHANT REVIEW-->
	    <?php if ($theme_reviews_tab==""):?>
	    <li class="review-tab-content">	       	     
	    <?php $this->renderPartial('/front/merchant-review',array(
	      'merchant_id'=>$merchant_id
	    )); ?>           
	    </li>
	    <?php endif;?>
	    <!--END MERCHANT REVIEW-->
	    
	    <!--MERCHANT MAP-->
	    <?php if ($theme_map_tab==""):?>
	    <li>	        	
	    <?php $this->renderPartial('/front/merchant-map'); ?>        
	    </li>
	    <?php endif;?>
	    <!--END MERCHANT MAP-->
	    
	    <!--BOOK A TABLE-->
	    <?php if ($booking_enabled):?>
	    <li>
	    <?php $this->renderPartial('/front/merchant-book-table',array(
	      'merchant_id'=>$merchant_id
	    )); ?>        
	    </li>
	    <?php endif;?>
	    <!--END BOOK A TABLE-->
	    
	    <!--PHOTOS-->
	    <?php if ($photo_enabled):?>
	    <li>
	    <?php 
	    $gallery=Yii::app()->functions->getOption("merchant_gallery",$merchant_id);
        $gallery=!empty($gallery)?json_decode($gallery):false;
	    $this->renderPartial('/front/merchant-photos',array(
	      'merchant_id'=>$merchant_id,
	      'gallery'=>$gallery
	    )); ?>        
	    </li>
	    <?php endif;?>
	    <!--END PHOTOS-->
	    
	    <!--INFORMATION-->
	    <?php if ($theme_info_tab==""):?>
	    <li>
	        <div class="box-grey rounded " style="margin-top:0;">
	          <?php echo getOption($merchant_id,'merchant_information')?>
	        </div>
	    </li>
	    <?php endif;?>
	    <!--END INFORMATION-->
	    
	    <!--PROMOS-->
	    <?php if ( $promo['enabled']==2 && $theme_promo_tab==""):?>
	    <li>
	    <?php $this->renderPartial('/front/merchant-promo',array(
	      'merchant_id'=>$merchant_id,
	      'promo'=>$promo
	    )); ?>        
	    </li>
	    <?php endif;?>
	    <!--END PROMOS-->
	    
	    
	   </ul>
	   </div>
     
     </div> <!-- menu-left-content-->
     
     <?php if (getOptionA('disabled_website_ordering')!="yes"):?>
     <div id="menu-right-content" class="col-md-4 border menu-right-content <?php echo $disabled_addcart=="yes"?"hide":''?>" >
     
     <div class="theiaStickySidebar">
      <div class="box-grey rounded  relative">
              
        <!--DELIVERY INFO-->
        <?php if ($remove_delivery_info==false):?>
        <div class="star-float"></div>
        <div class="inner center">
         <button type="button" class="close modal-close-btn" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button> 
                   
            <?php if ($data['service']==3):?>
            <p class="bold"><?php echo t("Distance Information")?></p>
            <?php else :?>
	        <p class="bold"><?php echo t("Information")?></p>
	        <?php endif;?>
	        
	        <p>
	        <?php 
	        if(!$search_by_location){
		        if ($distance){
		        	echo t("Distance").": ".number_format($distance,1)." $distance_type";
		        } else echo  t("Distance").": ".t("not available");
	        }
	        ?>
	        </p>
	        
	        <p class="delivery-fee-wrap">
	        <?php echo t("Delivery Est")?>: <?php echo FunctionsV3::getDeliveryEstimation($merchant_id)?></p>
	        
	        <p class="delivery-fee-wrap">
	        <?php 
	        if(!$search_by_location){
		        if (!empty($merchant_delivery_distance)){
		        	echo t("Delivery Distance Covered").": ".$merchant_delivery_distance." $distance_type_orig";
		        } else echo  t("Delivery Distance Covered").": ".t("not available");
	        }
	        ?>
	        </p>
	        
	        <p class="delivery-fee-wrap">
	        <?php 
	        if ($delivery_fee){
	             echo t("Delivery Fee").": ".FunctionsV3::prettyPrice($delivery_fee);
	        } else echo  t("Delivery Fee").": ".t("Free Delivery");
	        ?>
	        </p>
	        
	        <?php if($search_by_location):?>
	        <a href="javascript:;" class="top10 green-color change-location block text-center">
	        [<?php echo t("Change Location here")?>]
	        </a>
	        <?php else:?>
	        <a href="javascript:;" class="top10 green-color change-address block text-center">
	        [<?php echo t("Change Your Address here")?>]
	        </a>
	        <?php endif;?>
	        
        </div>
        <!--END DELIVERY INFO-->
        <?php else :?>
        
        <?php endif;?>
        


        <!--CART-->
        <div class="inner line-top relative">
        
           <i class="order-icon your-order-icon"></i>
         
           <p class="bold center"><?php echo t("Your Order")?></p>
		   <div class="item-order-wrap item-hello dhan"></div>
			<!---------------- Code to show active order starts ------------------------------>
			<?php 

			$session_cart = Yii::app()->session['var']; 
			//print $session_cart.$merchant_id;
			if((count($session_cart)>0) && ($session_cart != $merchant_id)){ //echo "hello"; ?>




				<script>
					$( document ).ready(function() {
						$('#myModalalready').modal({show:true});
						setTimeout(function() {
							$('.item-order-list.item-row,body #menu-right-content .summary-wrap').hide();
						}, 1000);
					});
				</script>
			<?php }  ?>
			<!---------------- Code to show active order ends ------------------------------>
			<a href="javascript:;" class="clear-cart"><?php echo t("Clear Order")?></a>

  		</div>

           
           <!--VOUCHER STARTS HERE-->
           <?php //Widgets::applyVoucher($merchant_id);?>
           <!--VOUCHER STARTS HERE-->
           
           <!--MAX AND MIN ORDR-->
           <?php if ($minimum_order>0):?>
           <div class="delivery-min">
              <p class="small center"><?php echo Yii::t("default","Subtotal must exceed")?> 
              <?php echo displayPrice(baseCurrency(),prettyFormat($minimum_order,$merchant_id))?>
           </div>
           <?php endif;?>
           
           <?php if ($merchant_minimum_order_pickup>0):?>
           <div class="pickup-min">
              <p class="small center"><?php echo Yii::t("default","Subtotal must exceed")?> 
              <?php echo displayPrice(baseCurrency(),prettyFormat($merchant_minimum_order_pickup,$merchant_id))?>
           </div>
           <?php endif;?>
                      
           <?php if($minimum_order_dinein>0):?>
           <div class="dinein-min">
              <p class="small center"><?php echo Yii::t("default","Subtotal must exceed")?> 
              <?php echo FunctionsV3::prettyPrice($minimum_order_dinein)?>
           </div>
           <?php endif;?>
              
	        
           
        </div> <!--inner-->
        <!--END CART-->
        
        <!--DELIVERY OPTIONS-->
        <div class="inner line-top relative delivery-option center">
           <i class="order-icon delivery-option-icon"></i>
          
           <?php if ($remove_delivery_info==false):?>
             <p class="bold"><?php echo t("Delivery Options")?></p>
           <?php else :?>
             <p class="bold"><?php echo t("Options")?></p>
           <?php endif;?>
           
           <?php echo CHtml::dropDownList('delivery_type',$now,
           (array)Yii::app()->functions->DeliveryOptions($merchant_id),array(
             'class'=>'grey-fields'

           ))?>
         
           <?php echo CHtml::hiddenField('delivery_date',$now)?>
           <?php echo CHtml::textField('delivery_date1',
            FormatDateTime($now,false),array('class'=>"j_date grey-fields dta",'data-id'=>'delivery_date'))?>
           
           <div class="delivery_asap_wrap">            
            <?php $detect = new Mobile_Detect;?>           
            <?php if ( $detect->isMobile() ) :?>
             <?php                           
             echo CHtml::dropDownList('delivery_time',$now_time,
             (array)FunctionsV3::timeList()
             ,array(
              'class'=>"grey-fields"
             ))
             ?>
            <?php else :?>                       
	         <?php echo CHtml::textField('delivery_time',$now_time,
	          array('class'=>" grey-fields dto",'placeholder'=>Yii::t("default","Delivery Time")))?>
	       <?php endif;?>  	          	  

	          <?php if ( $checkout['is_pre_order']==2):?>         
	          <span class="delivery-asap">
	           <?php echo CHtml::checkBox('delivery_asap',false,array('class'=>"icheck"))?>
	            <span class="text-muted"><?php echo Yii::t("default","Delivery ASAP?")?></span>	          
	         </span>       	         	        	     
	         <?php endif;?>    
	         
           </div><!-- delivery_asap_wrap-->
           
           <?php if ( $checkout['code']==1):?>
              <a href="javascript:;" class="orange-button medium checkout"><?php echo $checkout['button']?></a>
           <?php else :?>
              <?php if ( $checkout['holiday']==1):?>
                 <?php echo CHtml::hiddenField('is_holiday',$checkout['msg'],array('class'=>'is_holiday'));?>
                 <p class="text-danger"><?php echo $checkout['msg']?></p>
              <?php else :?>
                 <p class="text-danger"><?php echo $checkout['msg']?></p>
                 <p class="small">
                 <?php echo Yii::app()->functions->translateDate(date('F d l')."@".timeFormat(date('c'),true));?></p>
              <?php endif;?>
           <?php endif;?>
                                                                
        </div> <!--inner-->
        <!--END DELIVERY OPTIONS-->



        
      </div> <!-- box-grey-->
      </div> <!--end theiaStickySidebar-->
     
     </div> <!--menu-right-content--> 
     <?php endif;?>
  
  </div> <!--row-->
</div> <!--container-->
</div> <!--section-menu-->


 <div class="modal fade" id="myModalalready" role="dialog">
    <div class="modal-dialog" >
    
     
      <div class="modal-content">
     
        
    
<div class="border descrip_img modal-des">
        </div>

             <div class="col-md-12  border full_img modal-body" >
				<div class="active-order">

					<div class="sentence">You already have an active order at <a href="<?php echo "menu-".$cart_res_name[0]['restaurant_slug']; ?>"><?php echo $cart_res_name[0]['restaurant_name']; ?></a></div>
					<div class="return_order"><a href="<?php echo "menu-".$cart_res_name[0]['restaurant_slug']; ?>">Return To the order</a></div>
					<div class="close_anchor "><a href="javascript:;" class="clear-cart"><?php echo t("Clear Order")?></a></div>

				</div>           
          
           </div> 

      </div>
      
    </div>
  </div> 



<script>




$('.dto').timepicker({
	timeFormat: 'h:mm p',
    interval: 15,
    minTime: '08',
    maxTime: '11:00pm',
   
    startTime: '08:00', 
    dynamic: false,
    dropdown: true,
    scrollbar: true
});



//$('#delivery_time').timepicker({ 'scrollDefault': 'now', 'minuteStep' : 15 });
</script>

<!-- <script>
$("div").addClass( "active-order yourClass" );
</script> -->
<script type="text/javascript">
		$(document).ready(function(){

	    $(".exp:nth-child(1)").click(function() {
		$('html,body').animate({
		scrollTop: $(".menu-1:nth-child(2) ").offset().top},
		1500);
		});	

		$(".exp:nth-child(2)").click(function() {
		
		$('html,body').animate({
		scrollTop: $(".menu-1:nth-child(3) ").offset().top},
		1500);
		});

		$(".exp:nth-child(3)").click(function() {
		
		$('html,body').animate({
		scrollTop: $(".menu-1:nth-child(4) ").offset().top},
		1500);
		});

		$(".exp:nth-child(4)").click(function() {
		
		$('html,body').animate({
		scrollTop: $(".menu-1:nth-child(5) ").offset().top},
		1500);
		});

		$(".exp:nth-child(5)").click(function() {
		
		$('html,body').animate({
		scrollTop: $(".menu-1:nth-child(6) ").offset().top},
		1500);
		});

		$(".exp:nth-child(6)").click(function() {
		
		$('html,body').animate({
		scrollTop: $(".menu-1:nth-child(7) ").offset().top},
		500);
		});

		$(".exp:nth-child(7)").click(function() {
		
		$('html,body').animate({
		scrollTop: $(".menu-1:nth-child(8) ").offset().top},
		1500);
		});

		$(".exp:last").click(function() {
		
		$('html,body').animate({
		scrollTop: $(".menu-1:last ").offset().top},
		1500);
		});


		$(window).scroll(function(e){ 
			  var $el = $('.food_fix'); 
			  var isPositionFixed = ($el.css('position') == 'fixed');
			  if ($(this).scrollTop() > 550 && !isPositionFixed){ 
			    $('.food_fix').css({'position': 'fixed', 'top': '0px', 'width': '100%'}); 
			  }
			  if ($(this).scrollTop() < 100 && isPositionFixed)
			  {
			    $('.food_fix').css({'position': 'static', 'top': '0px'}); 
			  } 
			});

		
		
});

</script>
