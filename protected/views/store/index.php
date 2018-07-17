
<?php
$kr_search_adrress = FunctionsV3::getSessionAddress();



$home_search_text=Yii::app()->functions->getOptionAdmin('home_search_text');
if (empty($home_search_text)){
	$home_search_text=Yii::t("default","Find restaurants near you");
}

$home_search_subtext=Yii::app()->functions->getOptionAdmin('home_search_subtext');
if (empty($home_search_subtext)){
	$home_search_subtext=Yii::t("default","Order Delivery Food Online From Local Restaurants");
}

$home_search_mode=Yii::app()->functions->getOptionAdmin('home_search_mode');
$placholder_search=Yii::t("default","Street Address,City,State");

if ( $home_search_mode=="postcode" ){
	$placholder_search=Yii::t("default","Enter your postcode");
}
$placholder_search=Yii::t("default",$placholder_search);
?>

<?php if ( $home_search_mode=="address" || $home_search_mode=="") :?>
<img class="mobile-home-banner" src="<?php echo assetsURL()."/images/home-top-1.jpg"?>">

<div id="parallax-wrap" class="parallax-container parallax-home" 
data-parallax="scroll" data-position="top" data-bleed="10" 
data-image-src="<?php echo assetsURL()."/images/home-top-1.jpg"?>">
<?php 
if ( $enabled_advance_search=="yes"){
	$this->renderPartial('/front/advance_search',array(
	  'home_search_text'=>$home_search_text,
	  'kr_search_adrress'=>$kr_search_adrress,
	  'placholder_search'=>$placholder_search,
	  'home_search_subtext'=>$home_search_subtext,
	  'theme_search_merchant_name'=>getOptionA('theme_search_merchant_name'),
	  'theme_search_street_name'=>getOptionA('theme_search_street_name'),
	  'theme_search_cuisine'=>getOptionA('theme_search_cuisine'),
	  'theme_search_foodname'=>getOptionA('theme_search_foodname'),
	  'theme_search_merchant_address'=>getOptionA('theme_search_merchant_address'),
	));
} else $this->renderPartial('/front/single_search',array(
      'home_search_text'=>$home_search_text,
	  'kr_search_adrress'=>$kr_search_adrress,
	  'placholder_search'=>$placholder_search,
	  'home_search_subtext'=>$home_search_subtext
));
?>
 <!--parallax-container-->
<div class="col-md-5 search_second hidden">
      <div class="input-group">
   <input type="text" class="form-control" placeholder="Search" id="txtSearch"/>
   <div class="input-group-btn">
        <button class="btn btn-primary" type="submit">
        <span class="glyphicon glyphicon-search"></span>
        </button>
   </div>
   </div>
    </div>

      <div class="col-xs-2 col-md-2 hidden">
        <button type="button" class="btn">Basic</button>
            </div>
  </div>
 <!--parallax-container-->
<?php else :?>

<!--SEARCH USING LOCATION-->
<img class="mobile-home-banner" src="<?php echo assetsURL()."/images/b6.jpg"?>">

<div id="parallax-wrap" class="parallax-container parallax-home" 
data-parallax="scroll" data-position="top" data-bleed="10" 
data-image-src="<?php echo assetsURL()."/images/b6.jpg"?>">

  <?php 
  $location_type=getOptionA("admin_zipcode_searchtype");  
  $this->renderPartial('/front/location-search-'.$location_type,array(
   'location_search_type'=>$location_type
  ));
  ?>

</div> <!--parallax-container-->

<?php endif;?>

<?php if ($theme_hide_how_works<>2):?>
<!--HOW IT WORKS SECTIONS-->
<div class="sections section-how-it-works">
<div class="container">
 <h2><?php echo t("How it works")?></h2>
 <p class="center"><?php echo t("Get your favourite food in 4 simple steps")?></p>
 
 <div class="row">
   <div class="col-md-3 col-sm-3 center">
      <div class="steps step1-icon">
        <img src="<?php echo assetsURL()."/images/Search.png"?>">
      </div>
      <h3><?php echo t("Search")?></h3>
      <p><?php echo t("Find all restaurants available near you")?></p>
   </div>
   <div class="col-md-3 col-sm-3 center">
      <div class="steps step2-icon">
         <img src="<?php echo assetsURL()."/images/Choose.png"?>">
      </div>
      <h3><?php echo t("Choose")?></h3>
      <p><?php echo t("Browse hundreds of menus to find the food you like")?></p>
   </div>
   <div class="col-md-3 col-sm-3  center">
      <div class="steps step2-icon">
        <img src="<?php echo assetsURL()."/images/Payment.png"?>">
      </div>
      <h3><?php echo t("Pay")?></h3>
      <p><?php echo t("It's quick, secure and easy")?></p>
   </div>
   <div class="col-md-3 col-sm-3  center">
     <div class="steps step2-icon">
       <img src="<?php echo assetsURL()."/images/Enjoy.png"?>">
     </div>
      <h3><?php echo t("Enjoy")?></h3>
      <p><?php echo t("Food is prepared & delivered to your door")?></p>
   </div>   
 </div>

 </div> <!--container-->
</div> <!--section-how-it-works-->
<?php endif;?>



<!--CART-->
       <div class="inner line-top relative" id="custommmm">
        <p>hhh</p>
           <i class="order-icon your-order-icon"></i>
            
         
           <p class="bold center"><?php echo t("Your Order")?></p>
       <div class="item-order-wrap item-hello nagu "></div>
     
      <a href="javascript:;" class="clear-cart"><?php echo t("Clear Order")?></a>



      </div> 

           
           <!--VOUCHER STARTS HERE-->
           <?php //Widgets::applyVoucher($merchant_id);?>
           <!--VOUCHER STARTS HERE-->
           
           <!--MAX AND MIN ORDR-->
           
              
          
           
        </div> <!--inner-->
        <!--END CART-->



<!--FEATURED RESTAURANT SECIONS-->
<?php if ($disabled_featured_merchant==""):?>
<?php if ( getOptionA('disabled_featured_merchant')!="yes"):?>
<?php if ($res=FunctionsV3::getFeatureMerchant()):?>
<div class="sections choose_from_restaurant">
<div class="container">

  <?php $cuisine_list=Yii::app()->functions->Cuisine(true);?>

  <h2><?php echo t("CHOOSE FROM MOST POPULAR")?></h2>
  <h4><?php echo t("Explore restaurants, bars, and cafés by locality")?></h4>
  
  <div class="row">
  <?php foreach ($res as $val): //dump($val);?>
  <?php $address= $val['city']." ".$val['state'];
        
        
        $ratings=Yii::app()->functions->getRatings($val['merchant_id']);
  ?>   
  
    <!--<a href="<?php echo Yii::app()->createUrl('/store/menu/merchant/'. trim($val['restaurant_slug']) )?>">-->
    <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>">
    <div class="col-md-4 border-light ">
    
        <div class="col-md-12 col-sm-12 choose_from_restaurant_box">
          <img class="choose_from_restaurant_box_img" src="<?php echo FunctionsV3::getMerchantLogo($val['merchant_id'],$val['logo']);?>">
  

           <div class=" merchantopentag">
            <?php echo FunctionsV3::merchantOpenTag($val['merchant_id'])?>   
            </div>
           <div class="rating-stars" data-score="<?php echo $ratings['ratings']?>"></div>   
        </div> <!--col-->
        
        <div class="col-md-12 col-sm-12 choose_from_restaurant_box_desc">
        
          <div class="row">
            
	          
          </div>
          
          <h4 class="concat-text"><?php echo clearString($val['restaurant_name'])?></h4>
          
          <p class="concat-text">
          <?php //echo wordwrap(FunctionsV3::displayCuisine($val['cuisine']),50,"<br />\n");?>
          <?php echo FunctionsV3::displayCuisine($val['cuisine_id'],$cuisine_list);?>
          </p>


                                       
          <?php echo FunctionsV3::displayServicesList($val['service'])?>  
         <div class="min-order">
             
              </div>
         
          
          <div class="row_bottom">
            
            <div class="bottom_background col-md-12">
            <div class="col-md-2 logo-takeoutlist">
            <img class="logo-small" src="<?php echo FunctionsV3::getMerchantLogo($val['merchant_id'],$val['logo']);?>">
            </div>
            <div class="col-md-6 detail_adjst">
           <div class="text-holder">
                         <p class="concat-text"><?php echo $address?></p>           
                 <div class="deliver-time">
                 <div class="icon-motorcycle2"><i class="fa fa-bicycle" aria-hidden="true"></i> 10 min &nbsp;&nbsp;</div>
                <div class="icon-clock4"><i class="fa fa-clock-o" aria-hidden="true"></i> 15 min</div></p>

                </div>
                </div>
</div>
 <div class="order_now col-md-4 col-xs-6">
              
               <a class="ordernow-btn bgcolor" href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>">Order Now</a>
 </div>
         
            
            </div>
          </div>       
        </div> <!--col-->
        
    </div> <!--col-6-->
    </a>
    
      
  <?php endforeach;?>
  </div> <!--end row-->

  
</div> <!--container-->
</div>
<?php endif;?>
<?php endif;?>
<?php endif;?>
<!--END FEATURED RESTAURANT SECIONS-->













<!--FEATURED RESTAURANT SECIONS-->

<?php if ($disabled_featured_merchant==""):?>
<?php if ( getOptionA('disabled_featured_merchant')!="yes"):?>
<?php if ($res=FunctionsV3::getFeatureMerchant()):?>
<div class="sections section-feature-resto">
<div class="container">

  <?php $cuisine_list=Yii::app()->functions->Cuisine(true);?>

  <h2><?php echo t("FEATURED RESTAURANTS")?></h2>
  
  <div class="row">

  <?php foreach ($res as $val): //dump($val);?>
  <?php $address= $val['street']." ".$val['city'];
        $address.=" ".$val['state']." ".$val['post_code'];
        
        $ratings=Yii::app()->functions->getRatings($val['merchant_id']);
  ?>   
  
    <!--<a href="<?php echo Yii::app()->createUrl('/store/menu/merchant/'. trim($val['restaurant_slug']) )?>">-->
    <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>">
    <div class="col-md-5 border-light ">
    
        <div class="col-md-3 col-sm-3">
           <img class="logo-small1" src="<?php echo FunctionsV3::getMerchantLogo($val['merchant_id'],$val['logo']);?>">
          
        </div> <!--col-->
        
        <div class="col-md-9 col-sm-9">
        
          <div class="row">
              <div class="col-sm-5">
              <div class="rating-stars" data-score="<?php echo $ratings['ratings']?>"></div>   
            </div>
            <div class="col-sm-2 merchantopentag">
            <?php echo FunctionsV3::merchantOpenTag($val['merchant_id'])?>   
            </div>
          </div>
          
          <h4 class="concat-text"><?php echo clearString($val['restaurant_name'])?></h4>
          
          <p class="concat-text">
          <?php //echo wordwrap(FunctionsV3::displayCuisine($val['cuisine']),50,"<br />\n");?>
          <?php echo FunctionsV3::displayCuisine($val['cuisine'],$cuisine_list);?>
          </p>
          <p class="concat-text"><?php echo $address?></p>                             
          <?php echo FunctionsV3::displayServicesList($val['service'])?>          
        </div> <!--col-->
        
    </div> <!--col-6-->
    </a>
    <div class="col-md-1"></div>
      
  <?php endforeach;?>
  </div> <!--end row-->

  
</div> <!--container-->
</div>
<?php endif;?>
<?php endif;?>
<?php endif;?>
<!--END FEATURED RESTAURANT SECIONS-->


<div class="container">

<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 "><div class="element-title align-center company-logo_title"><h2>YOUR BEST CHOICES</h2></div><div class="company-logo fancy"><ul><li><figure><a href="javascript:void(0)"> <img src="<?php echo assetsURL()."/images/part1.png"?>"></a></figure></li><li><figure><a href="javascript:void(0)"> <img src="<?php echo assetsURL()."/images/part2.png"?>"></a></figure></li><li><figure><a href="javascript:void(0)"> <img src="<?php echo assetsURL()."/images/part3.png"?>"></a></figure></li><li><figure><a href="javascript:void(0)"> <img src="<?php echo assetsURL()."/images/part4.png"?>"></a></figure></li><li><figure><a href="javascript:void(0)"> <img src="<?php echo assetsURL()."/images/part5.png"?>"></a></figure></li></ul></div></div></div>

</div>

















<div class="page-section  cs-page-sec-457627 parallex-bg nopadding cs-nomargin" data-type="background">
                        <!-- Container Start -->

            <div class="container "> 
                                    <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="cs-section-title" style="text-align:center!important;">
                                                                    <h2 style="color: !important;">WHAT ARE CUSTOMERS SAYING</h2>
                                                            </div>
</div>
                        <div class="section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 "><div class="row"><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="testimonial"><div class="img-holder"><figure><img src="<?php echo assetsURL()."/images/review1.jpg"?>" alt=""></figure></div><div class="text-holder"> <p>@TakeoutList I love you, TakeoutList Just ordered me some grub, and I tell you, you folks make that part of my life easy. Thanks!</p><div class="author-detail"><div class="auther-name"><span>@mangafox</span></div></div></div></div></div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="testimonial"><div class="img-holder"><figure><img src="<?php echo assetsURL()."/images/review2.jpg"?>" alt=""></figure></div><div class="text-holder"> <p>Made my first @TakeoutList order today. So great to be able to order food and not have to talk to anyone.</p><div class="author-detail"><div class="auther-name"><span>@mangafox</span></div></div></div></div></div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="testimonial"><div class="img-holder"><figure><img src="<?php echo assetsURL()."/images/review3.jpg"?>" alt=""></figure></div><div class="text-holder"> <p>Shout out to Food Bakeryfor making my life so so easy!</p><div class="author-detail"><div class="auther-name"><span>@ReddPhoeno</span></div></div></div></div></div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="testimonial"><div class="img-holder"><figure><img src="<?php echo assetsURL()."/images/review4.jpg"?>" alt=""></figure></div><div class="text-holder"> <p>Seriously, @TakeoutList makes it easy for my coworkers and I to order food and get it to our office in a jiffy. FOOD!</p><div class="author-detail"><div class="auther-name"><span>@HubWub</span></div></div></div></div></div> </div></div></div><!-- end section row --></div>                    </div>
                                </div>  <!-- End Container Start -->
        </div>











<?php if ($theme_hide_cuisine<>2):?>
<!--CUISINE SECTIONS-->
<?php if ( $list=FunctionsV3::getCuisine() ): ?>
<div class="sections section-cuisine">
<div class="container  nopad">

<div class="col-md-3 nopad">
<img src="<?php echo assetsURL()."/images/mapp.png"?>" class="img-cuisine">
</div>

<div class="col-md-9  nopad">

  <h2 class="Browse_head"><?php echo t("Browse by cuisine")?></h2>
  <p class="sub-text center"><?php echo t("choose from your favorite cuisine")?></p>
  
  <div class="row">
    <?php $x=1;?>
    <?php foreach ($list as $val): ?>
    
    <div class="col-md-4 col-sm-4 indent-5percent nopad">
      <a href="<?php echo Yii::app()->createUrl('/store/cuisine',array("category"=>$val['cuisine_id']))?>" 
     class="<?php echo ($x%2)?"even":'odd'?>">
      <?php 
      $cuisine_json['cuisine_name_trans']=!empty($val['cuisine_name_trans'])?json_decode($val['cuisine_name_trans'],true):'';  
      echo qTranslate($val['cuisine_name'],'cuisine_name',$cuisine_json);
      if($val['total']>0){
        echo "<span>(".$val['total'].")</span>";
      }
      ?>
      </a>
    </div>   
    <?php $x++;?>
    <?php endforeach;?>
  </div> 

</div>
  
</div> <!--container-->
</div> <!--section-cuisine-->
<?php endif;?>
<?php endif;?>






<!--<div class="container-fluid">
<div class="col-md-12  nopad">

  <h2 class="Browse_head"><?php //echo t("Browse by city")?></h2>
  <p class="sub-text center"><?php //echo t("choose from your favorite city")?></p>
  </div>

<div class="row"></div>
<div class="company-logo fancy">

<ul>
<li><figure><p>Daphne</p><a href="/searcharea?s=Daphne%2C+AL%2C+USA"> <img src="<?php //echo assetsURL()."/images/daphane1.jpg"?>"><div class="overlay"><div class="overlay"></div></a></figure></li>

<li><figure><p>Mobile</p><a href="/searcharea?s=Mobile%2C+AL%2C+USA"> <img src="<?php// echo assetsURL()."/images/mobile1.jpg"?>"><div class="overlay"></div></a></figure></li>
<li><figure><p>Spanish Fort</p><a href="/searcharea?s=Spanish+Fort%2C+AL%2C+USA"> <img src="<?php //echo assetsURL()."/images/spanish1.jpg"?>"><div class="overlay"></div></a></figure></li>
<li><figure><p>Gulf Shores</p><a href="/searcharea?s=Gulf+Shores%2C+AL%2C+USA"> <img src="<?php //echo assetsURL()."/images/gulf1.jpg"?>"><div class="overlay"></div></a></figure></li>
<li><figure><p>Semmens</p><a href="/searcharea?s=Semmes%2C+AL%2C+USA"> <img src="<?php //echo assetsURL()."/images/sem1.jpg"?>"><div class="overlay"></div></a></figure></li>
</ul></div></div></div>

</div>
-->

<div class="container">
<div class="col-md-12  nopad">

  <h2 class="Browse_head"><?php echo t("Browse by city")?></h2>
  <p class="sub-text center"><?php echo t("choose from your favorite city")?></p>
  </div>
  <div class="row">
    <div class="span12">
          <div class="col-sm-12"> 
                <div id="myCarousel" class="carousel slide" style="padding: 0;margin: 0;">
                 
               <!-- <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol> -->
                 
                <!-- Carousel items -->
                <div class="carousel-inner">
                    
                <div class="item active">
                  <div class="row-fluid">
                    <div class="span3"><a href="#x" class="thumbnail"><img src="<?php echo assetsURL()."/images/daphane1.jpg"?>" alt="Image" style="max-width:100%;" /><div class="overlay"></div></a></div>
                    <div class="span3"><a href="#x" class="thumbnail"><img src="<?php echo assetsURL()."/images/mobile1.jpg"?>" style="max-width:100%;" /><div class="overlay"></div></a></div>
                    <div class="span3"><a href="#x" class="thumbnail"><img src="<?php echo assetsURL()."/images/spanish1.jpg"?>" style="max-width:100%;" /><div class="overlay"></div></a></div>
                    <div class="span3"><a href="#x" class="thumbnail"><img src="<?php echo assetsURL()."/images/sem1.jpg"?>" alt="Image" style="max-width:100%;" /><div class="overlay"></div></a></div>
                  </div><!--/row-fluid-->
                </div><!--/item-->
                 
                <div class="item">
                  <div class="row-fluid">
                    <div class="span3"><a href="#x" class="thumbnail"><img src="<?php echo assetsURL()."/images/spanish1.jpg"?>" alt="Image" style="max-width:100%;" /><div class="overlay"></div></a></div>
                    <div class="span3"><a href="#x" class="thumbnail"><img src="<?php echo assetsURL()."/images/mobile1.jpg"?>" alt="Image" style="max-width:100%;" /><div class="overlay"></div></a></div>
                    <div class="span3"><a href="#x" class="thumbnail"><img src="<?php echo assetsURL()."/images/gulf1.jpg"?>" alt="Image" style="max-width:100%;" /><div class="overlay"></div></a></div>
                    <div class="span3"><a href="#x" class="thumbnail"><img src="<?php echo assetsURL()."/images/daphane1.jpg"?>" alt="Image" style="max-width:100%;" /><div class="overlay"></div></a></div>
                  </div><!--/row-fluid-->
                </div><!--/item-->
                 
                
                 
                </div><!--/carousel-inner-->
                 
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                </div><!--/myCarousel-->
                 
            </div><!--/well-->   
    </div>
  </div>
</div>





<?php if ($theme_show_app==2):?>
<!--MOBILE APP SECTION-->
<div id="mobile-app-sections" class="container">
<div class="container-medium">
  <div class="row">
     <div class="col-xs-12 col-sm-5 into-row border app-image-wrap">
       <img class="app-phone" src="<?php echo assetsURL()."/images/getapp-3.png"?>">
     </div> <!--col-->
     <div class="col-xs-12 col-sm-7 into-row border">
       <h2><?php echo getOptionA('website_title')." ".t("in your mobile")?>! </h2>
       <h3 class="green-text"><?php echo t("Get our app, it's the fastest way to order food on the go")?>.</h3>
       
<div class="column-text_bottom"><a class="app-btn" href="#"><img src="http://foodbakery.chimpgroup.com/homev1/wp-content/uploads/app-img1-1.png" alt=""></a>

<a class="app-btn" href=""><img src="http://foodbakery.chimpgroup.com/homev1/wp-content/uploads/app-img2-1.png" alt="" style="height:45px;width:125px;"></a><form><div class="field-holder">
<br>
<input class="field-input" style="height:30px;" type="email" placeholder="Your Email"><label class="field-label-btn"><input class="field-btn" type="submit" value="Send Link"></label></div></form></div>


</div>










       <div class="row border" id="getapp-wrap">
       <?php if(!empty($theme_app_ios) && $theme_app_ios!="http://"):?>
         <div class="col-xs-4 border">                      
           <a href="<?php echo $theme_app_ios?>" target="_blank">
           <img class="get-app" src="<?php echo assetsURL()."/images/get-app-store.png"?>">
           </a>           
         </div>
         <?php endif;?>
         
         <?php if(!empty($theme_app_android) && $theme_app_android!="http://"):?>
         <div class="col-xs-4 border">
           <a href="<?php echo $theme_app_android?>" target="_blank">
             <img class="get-app" src="<?php echo assetsURL()."/images/get-google-play.png"?>">
           </a>
         </div>
         <?php endif;?>
         
       </div> <!--row-->
       
     </div> <!--col-->
  </div> <!--row-->
  </div> <!--container-medium-->
  
  <div class="mytable border" id="getapp-wrap2">
     <?php if(!empty($theme_app_ios) && $theme_app_ios!="http://"):?>
     <div class="mycol border">
           <a href="<?php echo $theme_app_ios?>" target="_blank">
           <img class="get-app" src="<?php echo assetsURL()."/images/get-app-store.png"?>">
           </a>
     </div> <!--col-->
     <?php endif;?>
     <?php if(!empty($theme_app_android) && $theme_app_android!="http://"):?>
     <div class="mycol border">
          <a href="<?php echo $theme_app_android?>" target="_blank">
             <img class="get-app" src="<?php echo assetsURL()."/images/get-google-play.png"?>">
           </a>
     </div> <!--col-->
     <?php endif;?>
  </div> <!--mytable-->
  
  
</div> <!--container-->
<!--END MOBILE APP SECTION-->
<?php endif;?>


 <script>
 $(function() {
  $('#ChangeToggle').click(function() {
    $('#navbar-hamburger').toggleClass('hidden');
    $('#navbar-close').toggleClass('hidden');  
  });
});
 </script>

 <script>
 
  function myFunction(x) {
    x.classList.toggle("change");
    $(".takkk").toggle();
   // $('html').hide(".dropdown");

   
}


 
 </script>

 <script>
 $(document).ready(function() {
    $('#myCarousel').carousel({
      interval: 10000
  })

});
</script>
 
<!--
 <script>
$(document).ready(function(){
    
    $(".ee").click(function(){
     
        $(".drop").show();
    });
});
</script>

-->








 

</script>


<script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                     $(this).toggleClass('active');
                 });
             });
         </script>