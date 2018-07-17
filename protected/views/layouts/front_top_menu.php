
<!--<div class="top-menu-wrapper <?php echo "top-".$action;?>">
<div class="container border" >
  <div class="col-md-3 col-xs-3 border col-a">
    <?php if ( $theme_hide_logo<>2):?>
    <a href="<?php echo websiteUrl()?>">
     <img src="<?php echo FunctionsV3::getDesktopLogo();?>" class="logo logo-desktop">
     <img src="<?php echo FunctionsV3::getMobileLogo();?>" class="logo logo-mobile">
    </a>
    <?php endif;?>
  </div>
  
  <div class="col-xs-1 menu-nav-mobile border relative">
     <a href="#"><i class="ion-android-menu"></i></a>
  </div> 
  
  <?php if ( Yii::app()->controller->action->id =="menu"):?>
  <div class="col-xs-1 cart-mobile-handle border relative">     
      <div class="badge cart_count"></div>
     <a href="<?php echo Yii::app()->createUrl('store/cart')?>">       
       <i class="ion-ios-cart"></i>
     </a>
  </div> 
  <?php endif;?>
  
  
  <div class="col-md-9 border col-b">
    <?php $this->widget('zii.widgets.CMenu', FunctionsV3::getMenu() );?> 
    <div class="clear"></div>
  </div>
  
</div> 

</div> 

<div class="menu-top-menu">
    <?php $this->widget('zii.widgets.CMenu', FunctionsV3::getMenu('mobile-menu') );?> 
    <div class="clear"></div>
</div> menu-top-menu-->

<div class="container">
   <nav class="navbar navbar-inverse navbb">
  <div class="container-fluid">
  <div class="navbar-header">
    <a href="http://c41673.takeoutlist.com/">  <img src="http://www.takeoutlist.com/wp-content/uploads/2018/01/tl_logo_01.png" alt="Restaurant | Take-out List" style="margin: 0px 10px;height: 37px;"> </a>
    </div>
   <ul class="nav navbar-nav mdnav">
   

    <li class="dropdown">
   <a class="dropdown-toggle" data-toggle="dropdown" href="#" >
 
          <div class="navbar-header">
             <div class="ee"  onclick="myFunction(this)" style="cursor: pointer;">
              <div class="bar1"></div>
              <div class="bar2"></div>
              <div class="bar3"></div>
          </div>

    </a>     



         <!-- <div class="base col-sm-12"> -->
         
		  <ul id="tak" class="nav takkk" style="background:transparent;position: absolute; width: 300px;top: 53px; left: 0;display: none;">
			   
				<li><a href="#" id="btn-1" data-toggle="collapse" data-target="#submenu1" aria-expanded="false">Demos<span class="caret"></span></a>
					<ul class="nav collapse" id="submenu1" role="menu" aria-labelledby="btn-1">
						<li><a href="#">Takeout List</a></li>
						<li><a href="#">Mexican Restaurants</a></li>
						<li><a href="#">RTL Demo</a></li>
					</ul>
				</li>
				 <li><a href="#">Restaurants</a></li>
				
				<li><a href="#" id="btn-2" data-toggle="collapse" data-target="#submenu2" aria-expanded="false">Pages<span class="caret"></span></a>
					<ul class="nav collapse" id="submenu2" role="menu" aria-labelledby="btn-2">
						<li><a href="#">Price Plans</a></li>
                            <li><a href="#">How it works</a></li>
                            <li><a href="#">FAQ's</a></li>
                             <li><a href="#">404</a></li>
                              <li><a href="#">Search Result</a></li>
                               <li><a href="#">Contact</a></li>
					</ul>
				</li>

				<li><a href="#" id="btn-3" data-toggle="collapse" data-target="#submenu3" aria-expanded="false">Blog<span class="caret"></span></a>
					<ul class="nav collapse" id="submenu3" role="menu" aria-labelledby="btn-3">
						<li><a href="#">Blog Large</a></li>
                        <li><a href="#">Blog Medium</a></li>
                        <li><a href="#">Blog Masonry</a></li>
                        <li><a href="#">Blog Detail Page</a></li>
					</ul>
				</li>

			</ul> 
			
<!--	</div> -->

      </li>
     
 <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="icon-compass-with-white-needles"></i>  FEEL LIKE EATING
        <span class="caret"></span></a>
        <ul class="dropdown-menu scrol_btn">
          
          <li>
         <!-- <img alt="" src="http://foodbakery.chimpgroup.com/wp-content/uploads/food-icon-05-1.png"> -->
<?php if ($theme_hide_cuisine<>2):?>
<!--CUISINE SECTIONS-->
<?php if ( $list=FunctionsV3::getCuisine() ): ?>
          <?php $x=1;?>
    <?php foreach ($list as $val): ?>
    
      <a href="<?php echo Yii::app()->createUrl('/store/cuisine',array("category"=>$val['cuisine_id']))?>" 
     class="<?php echo ($x%2)?"even":'odd'?>">
      <?php 
      echo $val['cuisine_name'];
      $cuisine_json['cuisine_name_trans']=!empty($val['cuisine_name_trans'])?json_decode($val['cuisine_name_trans'],true):'';  
      $r= qTranslate($val['cuisine_name'],'cuisine_name',$cuisine_json);
      
      if($val['total']>0){
        //echo "<span>(".$val['total'].")</span>";
      }
      ?>
      </a>
   
    <?php $x++;?>
    <?php endforeach;?>
 
  

<?php endif;?>
<?php endif;?>
          
          
          
           
 </li>
          
        </ul>
      </li>


      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">CHOOSE LOCATION
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/searcharea?s=Daphne%2C+AL%2C+USA">Daphne</a></li>
          <li><a href="/searcharea?s=Mobile%2C+AL%2C+USA">Mobile</a></li>
          <li><a href="/searcharea?s=Semmes%2C+AL%2C+USA">Semmens</a></li>
          <li><a href="/searcharea?s=Gulf+Shores%2C+AL%2C+USA">Gulf Shores</a></li>
          <li><a href="/searcharea?s=Spanish+Fort%2C+AL%2C+USA">Spanish Fort</a></li>
        </ul>
      </li>

      <li><a class=""  href="http://c41673.takeoutlist.com/browse">Browse by restaurant
       </a> </li>

    <li class="log_hov">   <a class="dropdown-toggle log_reg" data-toggle="" href="http://c41673.takeoutlist.com/signup" style="color: #000 !important;">LOGIN/REGISTER</a> </li>
	<li class="reg_hov">  <a class="get-start-btn reg_btn" href=" " style="color: #fff !important;padding-bottom: 5px;padding-top: 5px;"> Register Restaurant  </a></li>
    <!------------------ custom code for showing cart count starts ----------------------->
	<span class="cart-icon">
		<?php 
		/*
			$session_cart_qty = Yii::app()->session['var']; 
			//print_r($session_cart_qty);
			foreach($session_cart_qty as $key=>$count){
				$count_qty += $count['qty'];
			}
			print $count_qty;
			*/
		?>
	</span>
	 <!------------------ custom code for showing cart count ends ----------------------->
 </ul>
 <div class="text-right head_btns hidden">
    <a class="dropdown-toggle log_reg" data-toggle="" href="http://c41673.takeoutlist.com/signup">LOGIN/REGISTER</a> 
    <a class="get-start-btn reg_btn" href="http://c41673.takeoutlist.com/signup"> Register Restaurant  </a>
</div>

<div id="dialog" title="Cart Details">

<!--DELIVERY INFO-->
        

   

                
                        <!--CART-->
        
        <!--END CART-->
 </div>

<span id="opener" class="icon-bag mainNavIcon"></span>




<!--CART-->
       <!--  <div class="inner line-top relative" id="custommmm">
        
           <i class="order-icon your-order-icon"></i>
         
           <p class="bold center"><?php echo t("Your Order")?></p>
       <div class="item-order-wrap item-hello "></div>
     
      <a href="javascript:;" class="clear-cart"><?php echo t("Clear Order")?></a>

      </div> -->

           
           <!--VOUCHER STARTS HERE-->
           <?php //Widgets::applyVoucher($merchant_id);?>
           <!--VOUCHER STARTS HERE-->
           
           <!--MAX AND MIN ORDR-->
           
              
          
           
        </div> <!--inner-->
        <!--END CART-->


</div> 
  
</nav>
</div>
</div>
<script>
//     $(document).on("click", function(event){
//         var $trigger = $(".dropdown");
//         if($trigger !== event.target && !$trigger.has(event.target).length){
//             $(".takkk").slideUp("fast");
// 				$(".ee").removeClass("change");
//         }            
//     });

// 	$( function() {
// 		$( "#dialog" ).dialog({
// 		  autoOpen: false,
// 		  show: {
		   
// 			duration: 1000
// 		  },
// 		  hide: {
		  
// 			duration: 1000
// 		  }
// 		});
	 
// 		$( "#opener" ).on( "click", function() {
// 		  $( "#dialog" ).dialog( "open" );
// 		});
// 	});

//  $(document).ready(function() {

//   function getcartcount(){
//     setTimeout(function(){
//       var cnt = 0;
//     jQuery("body .item-order-wrap.item-hello.nagu .a").each(function(){ 
//      cnt += parseInt(jQuery(this).text());
//      $('.cart-icon').html(cnt);
//     });
//     },1000);
//   }
//   getcartcount();

// });
</script>



