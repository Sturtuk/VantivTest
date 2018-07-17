<?php
$this->renderPartial('/front/default-header',array(
   'h1'=>t("Browse Restaurant"),
   'sub_text'=>t("choose from your favorite restaurant")
));
?>




<div class="sections section-grey2 section-browse" id="section-browse">
  
 <div class="container">

    <div class="tabs-wrapper">
      <ul id="tabs">
		  <li class="<?php echo $tabs==1?"active":''?> noclick"  >
		    <a href="<?php echo Yii::app()->createUrl('/store/browse')?>">
		    <i class="ion-coffee"></i>
		     <span><?php echo t("Restaurant List")?></span>
		    </a>
		  </li>
		  <li class="<?php echo $tabs==2?"active":''?> noclick">
		    <a href="<?php echo Yii::app()->createUrl('/store/browse/?tab=2')?>">
		    <i class="ion-pizza"></i>
		     <span><?php echo t("Newest")?></span>
		    </a>
		  </li>
		  <li class="<?php echo $tabs==3?"active":''?> noclick" >
		    <a href="<?php echo Yii::app()->createUrl('/store/browse/?tab=3')?>">
		    <i class="ion-fork"></i>
		      <span><?php echo t("Featured")?></span>
		    </a>
		  </li>
		  <li class="full-maps nounderline">				  
		    <a href="javascript:;" >
		    <i class="ion-android-globe"></i>    
		     <span><?php echo t("View Restaurant by map")?></span>	    
		  </li>
		   </a>
      </ul>		    
      
      <ul id="tab">
          <li class="<?php echo $tabs==1?"active":''?>" >            
            <?php
            if ( $tabs==1):
	            if (is_array($list['list']) && count($list['list'])>=1){
		            $this->renderPartial('/front/browse-list',array(
					   'list'=>$list,
					   'tabs'=>$tabs
					));
	            } else echo '<p class="text-danger">'.t("No restaurant found").'</p>';
            endif;
            ?>
          </li>
          <li class="<?php echo $tabs==2?"active":''?>" >
          <?php          
            if ( $tabs==2):
	            if (is_array($list['list']) && count($list['list'])>=1){
		            $this->renderPartial('/front/browse-list',array(
					   'list'=>$list,
					   'tabs'=>$tabs			   
					));
	            } else echo '<p class="text-danger">'.t("No restaurant found").'</p>';
            endif;
            ?>
          </li>
          <li class="<?php echo $tabs==3?"active":''?>" >
          
          <?php          
            if ( $tabs==3):
	            if (is_array($list['list']) && count($list['list'])>=1){
		            $this->renderPartial('/front/browse-list',array(
					   'list'=>$list,
					   'tabs'=>$tabs
					));
	            } else echo '<p class="text-danger">'.t("No restaurant found").'</p>';
            endif;
            ?>
          
          </li>
          
          <li>
            <div class="full-map-wrapper" >
               <div id="full-map"></div>
               <a href="javascript:;" class="view-full-map green-button"><?php echo t("View in fullscreen")?></a>
            </div> <!--full-map-->
          </li>          
      </ul>     
      
    </div> <!--tabs-wrapper-->
 
 </div><!-- container-->

</div> <!--sections-->


 <div class="inner line-top relative" id="custommmm">
        
           <i class="order-icon your-order-icon"></i>
            
         
           <p class="bold center"><?php echo t("Your Order")?></p>
       <div class="item-order-wrap item-hello "></div>
     
      <a href="javascript:;" class="clear-cart"><?php echo t("Clear Order")?></a>



      </div> 
<!-- <script>
      function getcartcount(){
	setTimeout(function(){
		var cnt = 0;
	jQuery("body .item-order-wrap.item-hello.nagu .a").each(function(){ 
	 cnt += parseInt(jQuery(this).text());
	 $('.cart-icon').html(cnt);
	});
	},2000);
}
</script> -->