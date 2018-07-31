
<?php if(is_array($menu) && count($menu)>=1):?>

<?php 
/*dump($merchant_apply_tax);
dump($merchant_tax);*/
?>




<?php foreach ($menu as $val):?>
<div class="menu-1 box-grey rounded ppp" style="margin-top:0;">
<div class="col-md-12 col-sm-12 choose_from_restaurant_box">
          
           </div>
           
   <div class="food_order  menu-cat cat-<?php echo $val['category_id']?> ">
     <a href="javascript:;">       
       <span class="bold">
          <i class="<?php echo $tc==2?"ion-ios-arrow-thin-down":'ion-ios-arrow-thin-right'?>"></i>
         <?php echo qTranslate($val['category_name'],'category_name',$val)?>
       
       </span>
       <b></b>
     </a>
          
     <?php $x=0?>
     
     <div class="items-row sad1 col-sm-12 <?php echo $tc==2?"hide":''?>">
     
     <?php if (!empty($val['category_description'])):?>
     <p class="small">
       <?php echo qTranslate($val['category_description'],'category_description',$val)?>
       
     </p>
    
    
    
     <?php endif;?>

 
    
    
    
    


     <?php echo Widgets::displaySpicyIconNew($val['dish'],"dish-category")?>
     
     <?php if (is_array($val['item']) && count($val['item'])>=1):?>
     <?php foreach ($val['item'] as $val_item):?>
     
     <?php 
      $atts='';
      if ( $val_item['single_item']==2){
        $atts.='data-price="'.$val_item['single_details']['price'].'"';
        $atts.=" ";
        $atts.='data-size="'.$val_item['single_details']['size'].'"';
      }
    ?>       


    

     <div class="row <?php echo $x%2?'odd':'even'?>  demo" data-toggle="modal">
     <!-- img  -->


            <div class="border descrip_img modal-title thumbnail dish_name">
         <p class="descrip_img_head " title="Image 1"> <?php echo qTranslate($val_item['item_name'],'item_name',$val_item)?></p>
          <p class="descrip_img_detail "><?php echo stripslashes($val_item['item_description'])?></p>
          <p class="food-price-wrap price1"><?php echo FunctionsV3::getItemFirstPrice($val_item['prices'],$val_item['discount'],
           $merchant_apply_tax,$merchant_tax) ?></p>
        </div>

             <div class="col-md-12  border full_img thumbnail th1 ccc">
               <p style="display: none"> <?php echo qTranslate($val_item['photo'],'photo',$val_item)?> </p>

                <?php $pic = stripslashes($val_item['photo']);
                if(!empty($pic)){
                ?>
                <img class="choose_from_restaurant_box_img  "  data-target=""   src="/upload/<?php echo stripslashes($val_item['photo'])?>">

                <?php }else{
                ?> 

               <!-- <p><img class="choose_from_restaurant_box_img" src="/upload/<?php //echo stripslashes("NoImageAvailable.png")?>"></p>  -->

                <?php
                }

                ?>
           </div>



        
        
    
     <div class="qty thumbnail" >
          <div class="qtyname"><span class="bold"><?php echo t("Quantity")?></span></div>
          <div class="qnbtn">
            <button class="qtnbtn qtb1" data-act="-" data-cate="<?php echo $val['category_id']?>">-</button>
            <input type="text" readonly="" class="quantity<?php echo $val['category_id']?> qty_text" value="1">
            <button class="qtnbtn" data-act="+" data-cate="<?php echo $val['category_id']?>">+</button>
          </div>
        </div> 

    
    
         <div class="relative food-price-wrap food-price-add border thumbnail" data-dismiss="modal">
          <?php if ( $disabled_addcart==""):?>
          
          <a href="javascript:;" class="dsktop menu-item <?php echo $val_item['not_available']==2?"item_not_available":''?>" 
            rel="<?php echo $val_item['item_id']?>"
            data-single="<?php echo $val_item['single_item']?>" 
            <?php echo $atts;?>
            data-category_id="<?php echo $val['category_id']?>"
           >
           <i class="ion-ios-plus green-color bold"></i>
          </a>
         
          <!-- <a href="javascript:;" class="mbile menu-item <?php echo $val_item['not_available']==2?"item_not_available":''?>" 
            rel="<?php echo $val_item['item_id']?>"
            data-single="<?php echo $val_item['single_item']?>" 
            <?php echo $atts;?>
            data-category_id="<?php echo $val['category_id']?>"
           >
          <p> Add to Cart</p>
          </a> -->

          
          <?php endif;?>
        </div>
     </div> <!--row-->
     <?php $x++?>
     <?php endforeach;?>
    <?php else :?> 
      <p class="small text-danger"><?php echo t("no item found on this category")?></p>
     <?php endif;?>
    </div> 
    
  </div> <!--menu-cat-->

</div> <!--menu-1-->
<?php endforeach;?>

<?php else :?>
<p class="text-danger"><?php echo t("This restaurant has not published their menu yet.")?></p>
<?php endif;?>


<!-- Modal -->
  <div class="modal fade modal-pad ddde" id="myModal" role="dialog">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content order_popup">
     
        
     <!-- img  -->
<div class="border descrip_img modal-des">
         <p class="descrip_img_head"> <?php echo qTranslate($val_item['item_name'],'item_name',$val_item)?></p>
       <p class="descrip_img_head"> <?php echo qTranslate($val_item['item_name'])?></p>
          <p class="descrip_img_detail"><?php echo stripslashes($val_item['item_description'])?></p>
        </div>

             <div class="col-md-12  my_model_popup border full_img modal-body" >
           
               <p style="display: none"> <?php echo qTranslate($val_item['photo'],'photo',$val_item)?> </p>

                <?php $pic = stripslashes($val_item['photo']);
 
                if(!empty($pic)){
                ?>
                <!-- <p><img src="/upload/<?php echo stripslashes($val_item['photo'])?>">
               
 </p>   -->

                <?php }else{
                ?> 

               <!-- <p><img class="choose_from_restaurant_box_img" src="/upload/<?php //echo stripslashes("NoImageAvailable.png")?>"></p>  -->

                <?php
                }

                ?>
                 
          
           </div> 

           
        

        
      


        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"></button>
        </div>
      </div>
      
    </div>
  </div>

 <div class="modal fade" id="myModal1" role="dialog">
    
    
     

             <!--DELIVERY OPTIONS-->
        <div class="inner line-top relative  delivery-option center modal-des1 modal-del">
           <i class="order-icon delivery-option-icon"></i>
           <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"></button>
        </div>
           <?php if ($remove_delivery_info==false):?>
             <p class="bold"><?php echo t("Delivery Options")?></p>
           <?php else :?>
             <p class="bold"><?php echo t("Options")?></p>
           <?php endif;?>
           
           <?php echo CHtml::dropDownList('delivery_type',$now,
           (array)Yii::app()->functions->DeliveryOptions($merchant_id),array(
             'class'=>'grey-fields'
           ))?>
           
           <?php echo CHtml::hiddenField('delivery_date2',$now)?>
           <?php echo CHtml::textField('delivery_date12',
            FormatDateTime($now,false),array('class'=>"j_date grey-fields",'data-id'=>'delivery_date2'))?>
           
           <div class="delivery_asap_wrap">            
            <?php $detect = new Mobile_Detect;?>           
            <?php if ( $detect->isMobile() ) :?>
             <?php                           
             echo CHtml::dropDownList('delivery_time1',$now_time,
             (array)FunctionsV3::timeList()
             ,array(
              'class'=>"grey-fields"
             ))
             ?>
            <?php else :?>                       
           <?php echo CHtml::textField('delivery_time1',$now_time,
            array('class'=>" grey-fields dto",'placeholder'=>Yii::t("default","Delivery Time")))?>
         <?php endif;?>                 

            <?php if ( $checkout['is_pre_order']==2):?>         
            <span class="delivery-asap">
             <?php echo CHtml::checkBox('delivery_asap',false,array('class'=>"icheck"))?>
              <span class="text-muted"><?php echo Yii::t("default","Delivery ASAP?")?></span>           
           </span>                                 
           <?php endif;?>    
           
           </div><!-- delivery_asap_wrap-->
           
           
          <button class="pickupoption">Submit</button>                                                      
        </div> <!--inner-->
        <!--END DELIVERY OPTIONS-->
      
  
  
  </div>
 
 
 
 
 
 
 
 
 
 <script>

 $(document).ready(function() {
    window.$extElementVar;
    setTimeout(function() {
      if($('body .item-order-wrap .item-order-list').length > 0){
      var ops = localStorage.getItem("pickup").split(",");
      console.log(ops);
      console.log('adsf');
      $('.theiaStickySidebar select#delivery_type').val(ops[0]);
      $('.theiaStickySidebar input#delivery_date1').val(ops[1]);
      $('.theiaStickySidebar input#delivery_time').val(ops[2]);
    }
    }, 500);
    
$('.thumbnail').click(function(){
  $extElementVar = $(this);
      if($('.item-order-wrap .item-order-list').length > 0){
        $('.modal-des').empty();
        var title = $(this).parent('p').attr("title");
        $('.modal-title').html(title);
        $($(this).parents('div').html()).appendTo('.modal-des');
        $('#myModal').modal({show:true});
      } else {
        $('#myModal1').modal({show:true});
      }  
     e.preventDefault();
});

function addtocartoption() {
        $('.modal-des').empty();
        var title = $extElementVar.parent('p').attr("title");
        $('.modal-title').html(title);
        $($extElementVar.parents('div').html()).appendTo('.modal-des');
        $('#myModal').modal('show');
}
$('.dto').change(function(){
  console.log($(this).val());
  $('.dto').val($(this).val());
});
$('.pickupoption').click(function(){
  var opt = $('select#delivery_type').val();
  var date = $('input#delivery_date12').val();
  var time = $('input#delivery_time1').val();
  if(date == '' || date == 'undefined') {
    alert('Please select the date');
  } 
  else if(time == '' || time == 'undefined') {
    alert('Please select the time');
  } else {
    var arr = [opt, date, time] ;
    localStorage.setItem("pickup", arr);
    $('.theiaStickySidebar select#delivery_type').val(opt);
    $('.theiaStickySidebar input#delivery_date1').val(date);
    $('.theiaStickySidebar input#delivery_time').val(time);
    $('#myModal1').modal('hide');
    addtocartoption();
  }
});

$('body').on('click', '.qtnbtn', function(){
  
  var action = $(this).attr('data-act');
  var ctg = $(this).attr('data-cate');
  var qtn = parseInt($('#myModal .quantity'+ctg).val());
  if(qtn > 1) {
    if(action == "-") {
      $('#myModal .quantity'+ctg).val(qtn-1);
    } else {
      $('#myModal .quantity'+ctg).val(qtn+1);
    }
  } else if (qtn == 1) {
    if(action == "+") {
      $('#myModal .quantity'+ctg).val(qtn+1);
    }
  }
});
function getcartcount(){
  setTimeout(function(){
    var cnt = 0;
  jQuery("body .item-order-wrap.item-hello .a").each(function(){ 
   cnt += parseInt(jQuery(this).text());
   $('.cart-icon').html(cnt);
  });
  },2000);
}
var k = 1;
$('body').on('click', '#myModal a', function(event){
  if(typeof event.originalEvent != "undefined"){
    var cid = $(this).attr('data-category_id');
    var qn = parseInt($('#myModal .quantity'+cid).val());
    if(qn > 1){
      for(var j=1; j<qn; j++){
        $('#myModal a').click();
    if(j+1==qn){
      getcartcount();
    }
      } 
    } else if(qn==1){
    getcartcount();
  }
  }
});
getcartcount();
$(document).ajaxComplete(function(event,xhr,options){ 
  var ajaxcall = options.data; 
  console.log(ajaxcall);
  if (ajaxcall.indexOf("action=deleteItem") >= 0) {
    getcartcount();
  } else if (ajaxcall.indexOf("action=clearCart") >= 0){
  console.log("hello");
    location.reload(true);
    
  }
});
$(".full_img img").click(function() { 
  $(".qty").toggleClass("quantity-add");
});

});


</script>
