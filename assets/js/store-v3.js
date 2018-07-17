var smap; /*global map variable*/
var otables;

jQuery(document).ready(function() {		
	
	if ( $(".tab-byaddress").exists()){
	    $(".tab-byaddress").fadeIn("slow");
	}
	
	/*DESKTOP MENU*/
	
	if ( $(".search-menu").exists() )
	{
		var selected=$(".search-menu li:first-child");
		var class_name=selected.find("a").attr("data-tab");
		$(".forms-search").hide();
		$("."+class_name).fadeIn("slow");	
	}
	
	$( document ).on( "click", ".search-menu a", function() {
		var tab = $(this).data("tab");		
		$(".search-menu a").removeClass("selected");
		$(this).addClass("selected");		
		
		$(".forms-search").hide();
		$("."+tab).fadeIn("slow");		
				
		switch (tab)
		{
			case "tab-byaddress":			
			$(".home-search-text").html( $("#find_restaurant_by_address").val() );
			break;
			
			case "tab-byname":
			$(".home-search-text").html( js_lang.find_restaurant_by_name );
			break;
			
			case "tab-bystreet":
			$(".home-search-text").html( js_lang.find_restaurant_by_streetname );
			break;
			
			case "tab-bycuisine":
			$(".home-search-text").html( js_lang.find_restaurant_by_cuisine );
			break;
			
			case "tab-byfood":
			$(".home-search-text").html( js_lang.find_restaurant_by_food );
			break;
		}
		
	});
	
	/*MOBILE MENU*/
	$( document ).on( "click", ".mobile-search-menu a", function() {
		var tab = $(this).data("tab");		

		$(".mobile-search-menu a").removeClass("selected");
		$(this).addClass("selected");		
		
		$(".forms-search").hide();
		$("."+tab).fadeIn("slow");		
		
		switch (tab)
		{
			case "tab-byaddress":			
			$(".home-search-text").html( $("#find_restaurant_by_address").val() );
			break;
			
			case "tab-byname":
			$(".home-search-text").html( js_lang.find_restaurant_by_name );
			break;
			
			case "tab-bystreet":
			$(".home-search-text").html( js_lang.find_restaurant_by_streetname );
			break;
			
			case "tab-bycuisine":
			$(".home-search-text").html( js_lang.find_restaurant_by_cuisine );
			break;
			
			case "tab-byfood":
			$(".home-search-text").html( js_lang.find_restaurant_by_food );
			break;
		}
		
	});
	
	
	/*RATING STARS*/
	if ( $(".rating-stars").exists() ){
	   initRating();
	}
	
	if ( $(".raty-stars").exists() ){
		$('.raty-stars').raty({ 
		   readOnly: false, 		
		   hints:'',
		   path: sites_url+'/assets/vendor/raty/images',
		   click: function (score, evt) {
		   	   $("#initial_review_rating").val(score);
		   }
        });    
	}

	/*FILTER BOX*/
	$( document ).on( "click", ".filter-box a", function() {
		var parent=$(this).parent();
		var t=$(this);
		var i=t.find("i");		
		if ( i.hasClass("ion-ios-arrow-thin-right")){
			i.removeClass("ion-ios-arrow-thin-right");
			i.addClass("ion-ios-arrow-thin-down");
		} else {
			i.addClass("ion-ios-arrow-thin-right");
			i.removeClass("ion-ios-arrow-thin-down");
		}
		var parent2 = parent.find("ul").slideToggle( "fast", function() {
			 parent2.removeClass("hide");
        });
	});
				
    if ( $(".infinite-container").exists()) { 	
		var infinite = new Waypoint.Infinite({
	       element: $('.infinite-container')[0],       
	       onBeforePageLoad : function() {
	       	  dump('onBeforePageLoad');
	       	  $(".search-result-loader").show();
	       },
	       onAfterPageLoad : function() {
	       	  dump('onAfterPageLoad');
	       	  $(".search-result-loader").hide();
	       	  initRating();
	       	  removeFreeDelivery();
	       	  if ( $("#restuarant-list").exists() ){
	    	       plotMap();
	          }           
	       }
	    }); 
   }
   
   $( document ).on( "click", ".display-type", function() {   	   
   	   $("#display_type").val( $(this).data("type") );   	   
   	   research_merchant(); 
   });    
        
   $('.filter_promo').on('ifChecked', function(event){      
      $(".non-free").fadeOut("fast");
   });
   
   $('.filter_promo').on('ifUnchecked', function(event){       
       $(".non-free").fadeIn("fast");
   });        

   /*SEARCH MAP TOOGLE*/  
   $( document ).on( "click", ".search-view-map, #mobile-viewmap-handle", function() {   	   
   	   if ( $(".search-map-results").hasClass("down") ){
   	   	 $(".search-map-results").slideUp( 'slow', function(){ 
   	      	   $(".search-map-results").removeClass("down")
   	      });
   	   } else {
   	      $(".search-map-results").slideDown( 'slow', function(){ 
   	      	   $(".search-map-results").addClass("down");
   	      	   dump('load map');   	 
   	      	   map = new GMaps({
					div: '.search-map-results',
					lat: $("#clien_lat").val(),
					lng: $("#clien_long").val(),
					scrollwheel: false ,
					styles: [ {stylers: [ { "saturation":-100 }, { "lightness": 0 }, { "gamma": 1 } ]}],
				    markerClusterer: function(map) {
                        return new MarkerClusterer(map);
                    }
			   });      	   
   	      	   callAjax('loadAllRestoMap','');  	      	   
   	      }); /*end slidedown*/
   	   }
   });
   

    /*TABS*/
    $("ul#tabs li").click(function(e){
    	if ( $(this).hasClass("noclick") ){
    		return;    		
    	}
        if (!$(this).hasClass("active")) {
            var tabNum = $(this).index();
            var nthChild = tabNum+1;
            $("ul#tabs li.active").removeClass("active");
            $(this).addClass("active");
            $("ul#tab li.active").removeClass("active");
            $("ul#tab li:nth-child("+nthChild+")").addClass("active");
        }
    });
   /*END TABS*/   

   /*SET MENU STICKY*/
   var disabled_cart_sticky=$("#disabled_cart_sticky").val();
   if ( $(".menu-right-content").exists() ){	   
   	   dump(disabled_cart_sticky);
   	   if (disabled_cart_sticky!=2){
		   jQuery('.menu-right-content, .category-list').theiaStickySidebar({      
		      additionalMarginTop: 8
		   }); 
   	   }
   }
   if ( $(".sticky-div").exists() ){	   	  
   	   if (disabled_cart_sticky!=2){ 
		   jQuery('.sticky-div').theiaStickySidebar({      
		      additionalMarginTop: 8
		   }); 
   	   }
   }  
    
   /*MENU 1*/  
   $( document ).on( "click", ".menu-1 .menu-cat a", function() {
		var parent=$(this).parent();		
		var t=$(this);
		var i=t.find("i");		
		if ( i.hasClass("ion-ios-arrow-thin-right")){
			i.removeClass("ion-ios-arrow-thin-right");
			i.addClass("ion-ios-arrow-thin-down");
		} else {
			i.addClass("ion-ios-arrow-thin-right");
			i.removeClass("ion-ios-arrow-thin-down");
		}

		var parent2 = parent.find(".items-row").slideToggle( "fast", function() {
			 parent2.removeClass("hide");
        });
	});
	
	/*READ MORE*/
	initReadMore();
				
	$( document ).on( "click", ".view-reviews", function() {	
		if ( $(".merchant-review-wrap").html()=="" ){
		    load_reviews();			
		    initReadMore();
		}
	});	
	
	$( document ).on( "click", ".write-review-new", function() {		
		$(".review-input-wrap").slideToggle("fast");
	});
	
	
	$( document ).on( "click", ".view-merchant-map", function() {	
		 	
		 $(".direction_output").css({"display":"none"});	
		 
		 var lat=$("#merchant_map_latitude").val();
		 var lng=$("#merchant_map_longtitude").val();	
		 	 
		 if (empty(lat)){
		 	 uk_msg(js_lang.trans_9);
		 	 $(".direction-action").hide();
		 	 return;
		 }
		 if (empty(lng)){
		 	 uk_msg(js_lang.trans_9);
		 	 $(".direction-action").hide();
		 	 return;
		 }		 		 		 
		 
		 $(".direction-action").show();
		 		 		 
		 smap = new GMaps({
			div: '#merchant-map',
			lat: lat,
			lng: lng,
			scrollwheel: false ,
			styles: [ {stylers: [ { "saturation":-100 }, { "lightness": 0 }, { "gamma": 1 } ]}]
		 });      	  		 
		 
		 var resto_info='';	
		 if ( !empty(merchant_information)){
			 resto_info+='<div class="marker-wrap">';
		   	   resto_info+='<div class="row">';
			   	   resto_info+='<div class="col-md-4 ">';
			   	   resto_info+='<img class="logo-small" src="'+merchant_information.merchant_logo+'" >';
			   	   resto_info+='</div>';
			   	   resto_info+='<div class="col-md-8 ">';
				   	   resto_info+='<h3 class="orange-text">'+merchant_information.restaurant_name+'</h3>'; 
				   	   resto_info+='<p class="small">'+merchant_information.merchant_address+'</p>';				   	   
				   resto_info+='</div>';
		   	   resto_info+='</div>';
	   	    resto_info+='<div>';  
		 } else {
		 	resto_info='';
		 }		 
		 smap.addMarker({
			lat: lat,
			lng: lng,
			title: $("#restaurant_name").val(),
			icon : map_marker ,
			infoWindow: {
			  content: resto_info
			}
		});			
	});
	
	/*MERCHANT PHOTOS*/	
	$( document ).on( "click", ".view-merchant-photos", function() {	
		if ( $("#photos").exists() ){
		   $("#photos").justifiedGallery();
		}
	});	
	
	if( $('.section-payment-option').exists()) {	
       load_cc_list();
    }
            
    $('.payment_option').on('ifChecked', function(event){   	      	
    	var seleted_payment=$(this).val();
    	dump(seleted_payment);
    	    	
    	if ( seleted_payment=="cod"){
    		if ( $("#cod_change_required").val()==2 ){
			   $("#order_change").attr("data-validation","required");
			} else {
				$("#order_change").removeAttr("data-validation");
			}
    	} else {
    		$("#order_change").removeAttr("data-validation");
    	}
    	
    	switch (seleted_payment)
    	{
    		case "ocr":    		
    		$(".credit_card_wrap").show();
    		$(".change_wrap").hide();
    		$(".payment-provider-wrap").hide();
    		break;
    		
    		case "cod":
    		$(".credit_card_wrap").hide();
    		$(".change_wrap").show();
    		$(".payment-provider-wrap").hide();
    		break;
    		
    		case "pyr":
    		$(".payment-provider-wrap").show();
    		$(".credit_card_wrap").hide();
    		$(".change_wrap").hide();
    		break;
    		
    		default:
    		$(".credit_card_wrap").hide();
    		$(".change_wrap").hide();
    		$(".payment-provider-wrap").hide();
    		break;
    	}
    });  


    if ($("#contact-map").exists()){
    	dump(website_location);    	
    	map = new GMaps({
			div: '#contact-map',
			lat: website_location.map_latitude ,
			lng: website_location.map_longitude ,
			scrollwheel: false ,
			disableDefaultUI: true,
			styles: [ {stylers: [ { "saturation":-100 }, { "lightness": 0 }, { "gamma": 1} ]}]
	    });      	    
	    map.addMarker({
			lat: website_location.map_latitude,
			lng: website_location.map_longitude ,			
			icon : map_marker			
		}); 	    	    
    }
    
    if ( $("#restuarant-list").exists() ){
    	plotMap();
    }
    
    if ( $(".section-merchant-payment").exists() ){
    	load_cc_list_merchant();
    }
    
    $( document ).on( "change", "#change_package", function() {	
		var package_id=$(this).val();
		window.location.href=$("#change_package_url").val()+package_id;
	});	
	
	/*CAPCHA*/
	setTimeout('onloadMyCallback()', 2100);
			
	if ( $(".section-address-book").exists() ){
		if ( $("#table_list_info").exists() ){
		} else {
			table();
		}
	}
				
	$( document ).on( "click", ".row_remove", function() {
		var ans=confirm(js_lang.deleteWarning);        
        if (ans){        	
        	var table = $(this).data("table");
		    var whereid = $(this).data("whereid");
		    var id = $(this).data("id");
		    rowRemove(id, table, whereid, $(this) );		
        }		
	});
		
	if ( $(".otable").exists() ){
		initOtable();
	}
	
	if( $('#uploadavatar').exists() ) {    	
       createUploader('uploadavatar','uploadAvatar');
    }    
      
    
    if ( $(".search_resto_name").exists() ){    	
    	iniRestoSearch('search_resto_name','AutoResto');  
    	iniRestoSearch('street_name','AutoStreetName');  
    	iniRestoSearch('cuisine','AutoCategory');  
    	iniRestoSearch('foodname','AutoFoodName'); 
    }
    if ( $(".search-by-postcode").exists() ){
    	dump('d2x');
    	iniRestoSearch('zipcode','AutoZipcode'); 
    }
    
    $( document ).on( "click", ".full-maps", function() {    	
    	dump(country_coordinates);     	
    	map = new GMaps({
			div: '#full-map',
			lat: country_coordinates.lat ,
			lng: country_coordinates.lng ,
			scrollwheel: false ,
			styles: [ {stylers: [ { "saturation":-100 }, { "lightness": 0 }, { "gamma": 1 } ]}],
			zoom: 6,
		    markerClusterer: function(map) {
                return new MarkerClusterer(map);
            }
	    });      	   
    	
    	callAjax("loadAllMerchantMap")
    });    
    
    $( document ).on( "click", ".view-full-map", function() {        		   
        $(".full-map-wrapper").toggleClass("full-map");
        if ( $(".full-map-wrapper").hasClass("full-map") ) {
        	$(this).html(js_lang.close_fullscreen);
        	$(".view-full-map").removeClass("green-button");
        	$(".view-full-map").addClass("orange-button");
        } else {
        	$(this).html(js_lang.view_fullscreen);     	
        	$(".view-full-map").addClass("green-button");
        	$(".view-full-map").removeClass("orange-button");
        }
    });    
    
    $( document ).on( "click", ".menu-nav-mobile a", function() { 
       $(".menu-top-menu").slideToggle("fast");
    });	
    
  
    $( document ).on( "click", "#mobile-filter-handle", function() { 
    	 
         toogleModalFilter("#mobile-search-filter");
         
         $('.filter_by').on('ifChecked', function(event){
            research_merchant();       
         });
         $('.filter_by').on('ifUnchecked', function(event){
            research_merchant();   
         }); 
         $('.filter_by_radio').on('ifChecked', function(event){  
	       $(".filter_minimum_clear").show();   
	       research_merchant();   
	     });
	     $('.filter_promo').on('ifChecked', function(event){      
		      $(".non-free").fadeOut("fast");
		 });
	     $('.filter_promo').on('ifUnchecked', function(event){       
	        $(".non-free").fadeIn("fast");
	     });    
    });
    
    /*$( document ).on( "click", ".cart-mobile-handle", function() { 
         toogleModalFilter("#menu-right-content");
    });*/
    
    /*MOBILE SINGLE PAGE FOR FOOD ITEM*/
    if ( $("#mobile-view-food-item").exists()){
    	var hide_foodprice=$("#hide_foodprice").val();	
		if ( hide_foodprice=="yes"){
			$(".hide-food-price").hide();
			$("span.price").hide();		
			$(".view-item-wrap").find(':input').each(function() {			
				$(this).hide();
			});
		}
		var price_cls=$(".price_cls:checked").length; 	
		if ( price_cls<=0){
			var x=0
			$( ".price_cls" ).each(function( index ) {
				if ( x==0){
					dump('set check');
					$(this).attr("checked",true);
				}
				x++;
			});
		}
    }
    
    $( document ).on( "change", ".language-options", function() {
    	if ( $(this).val() != ""){    		
    		window.location.href=$(this).val();
    	}
    });
    
   $( document ).on( "click", ".view-receipt-front", function() {    	       	 	
   	   var params="order_id="+ $(this).data("id")+"&post_type=get";
   	   params+="&lang="+lang;
       fancyBoxFront('viewReceipt',params);
   });	
   
   /*COOKIE LAW*/
   if ( $(".cookie-wrap").exists() ){
   	   var kr_cookie_law =$.cookie('kr_cookie_law');	
   	   dump("kr_cookie_law:"+kr_cookie_law);
   	   if (empty(kr_cookie_law)){
   	   	  $(".cookie-wrap").fadeIn("fast");
   	   }
   }
   $( document ).on( "click", ".accept-cookie", function() { 
   	   $(".cookie-wrap").fadeOut("slow");
   	   $.cookie('kr_cookie_law', '2', { expires: 500, path: '/' }); 
   });
   
   $( document ).on( "click", ".cookie-close", function() { 
   	   $(".cookie-wrap").fadeOut("slow");
   });
   
   $( document ).on( "click", ".resend-email-code", function() { 
        callAjax('resendEmailCode','client_id='+$("#client_id").val());
   });
   
                   
}); /*end docu*/

function fancyBoxFront(action,params)
{  	  	  	  	
	var is_modal;
	switch (action)  	
	{
		case "ShowLocationFee":
		case "AgeRestriction":
		is_modal=true;
		break;
				
		default:
		is_modal=false;
		break;
	}
	
	params+="&lang="+lang;
	
	var URL=front_ajax+"/"+action+"/?"+params;
		$.fancybox({        
		maxWidth:800,
		closeBtn : false,          
		autoSize : true,
		padding :0,
		margin :2,
		modal:is_modal,
		type : 'ajax',
		href : URL,
		openEffect :'elastic',
		closeEffect :'elastic',
		helpers: {
		    overlay: {
		      locked: false
		    }
		 }
	});   
}

$('#mobile-search-filter').on('hidden.bs.modal', function (e) {
   $("#mobile-search-filter").removeClass("fade");
   $("#mobile-search-filter").removeClass("modal");
   $(".modal-close-btn").hide();
});


$('#menu-right-content').on('hidden.bs.modal', function (e) {
   $("#menu-right-content").removeClass("fade");
   $("#menu-right-content").removeClass("modal");
   $(".modal-close-btn").hide();
});

function toogleModalFilter(id)
{

   if ( id=="#menu-right-content"){
   	   $(id).css("overflow",'');
   	   $(id).css("position",'');
   }
	
   if ( $(id).hasClass("modal") ){
   	   $(id).removeClass("fade");
       $(id).removeClass("modal");
   	   $(id).modal('hide');
   	   $(".modal-close-btn").hide();
   } else {  	   
       $('.icheck').iCheck({
	       checkboxClass: 'icheckbox_minimal',
	       radioClass: 'iradio_flat'
	   });
   	   $(id).addClass("fade");
   	   $(id).addClass("modal");
   	   $(id).modal('show');
   	   $(".modal-close-btn").show();
   	   
   	   if ( id=="#menu-right-content"){
   	   	  load_item_cart();
   	   }
   	   
   }
}

$.validate({ 	
	language : jsLanguageValidator,
    form : '#frm-addressbook',    
    onError : function() {      
    },
    onSuccess : function() {     
      form_submit('frm-addressbook');
      return false;
    }  
});

$.validate({ 	
	language : jsLanguageValidator,
    form : '.krms-forms',    
    onError : function() {      
    },
    onSuccess : function() {     
      var params=$(".krms-forms").serialize();
      var action=$(".krms-forms").find("#action").val();
      callAjax(action,params, $(".krms-forms-btn") );
      return false;
    }  
});

function plotMap()
{
	dump('plotMap');
	$( ".browse-list-map.active" ).each(function( index ) {
							
		var lat=$(this).data("lat");
		var lng=$(this).data("long");
		
		map = new GMaps({
			div: this,
			lat: lat ,
			lng: lng ,
			scrollwheel: false ,			
			styles: [ {stylers: [ { "saturation":-100 }, { "lightness": 0 }, { "gamma": 1} ]}]
	    });      

	    map.addMarker({
			lat: lat,
			lng: lng ,			
			icon : map_marker			
		}); 	    

		$(this).removeClass("active"); 
			     			
	});
}

function initReadMore()
{
	if ( $(".read-more").exists() ){				
	    $('.read-more').readmore({
	    	moreLink:'<a class="small" href="javascript:;">'+js_lang.read_more+'</a>',
	    	lessLink:'<a class="small" href="javascript:;">'+js_lang.close+'</a>'
	    });
	}
}

function initRating()
{
	$('.rating-stars').raty({ 
		readOnly: true, 
		score: function() {
             return $(this).attr('data-score');
       },
		path: sites_url+'/assets/vendor/raty/images',
		hints:''
    });    
}

function removeFreeDelivery()
{
	var filter_promo=$(".filter_promo:checked").val();	
	if ( filter_promo=="free-delivery"){		
		$(".non-free").fadeOut("fast");
	}
}

/*mycall*/
var call_ajax_handle;

function callAjax(action,params,buttons)
{
	dump(action);
	dump(params);	
	var buttons_text='';	
	
	if (!empty(buttons)){
		buttons_text=buttons.html();
		buttons.html('<i class="fa fa-refresh fa-spin"></i>');
		buttons.css({ 'pointer-events' : 'none' });
	}
	
	if(!empty(lang)){
		params+="&lang="+lang;
	}
	
    call_ajax_handle = $.ajax({    
    type: "POST",
    url: front_ajax+"/"+action,
    data: params,
    timeout: 6000,
    dataType: 'json',       
    beforeSend: function() {	 	
	 	if(call_ajax_handle != null) {
	 	   call_ajax_handle.abort();	 	   
	 	   busy(false);
	       showPreloader(false);
	 	} else {
	 	   busy(true);
	       showPreloader(true);
	 	}
	},
	complete: function(data) {					
		call_ajax_handle= (function () { return; })();		
		busy(false);
	    showPreloader(false);
	},
    success: function(data){     	
    	if (!empty(buttons)){
    		buttons.html(buttons_text);
		    buttons.css({ 'pointer-events' : 'auto' });
    	}
    	
    	if (data.code==1){
    		switch (action)
    		{
    			case "loadAllMerchantMap":
    			case "loadAllRestoMap":    		
    			
    			   var last_lat='';
    			   var last_lng='';
    			   var bounds = [];
    			   
    			   $.each(data.details, function( index, val ) {
    			   	   
    			   	   resto_info='';
    			   	       			   	   
    			   	   resto_info+='<div class="marker-wrap">';
	    			   	   resto_info+='<div class="row">';
		    			   	   resto_info+='<div class="col-md-4 ">';
		    			   	   resto_info+='<img class="logo-small" src="'+val.logo+'" >';
		    			   	   resto_info+='</div>';
		    			   	   resto_info+='<div class="col-md-8 ">';
			    			   	   resto_info+='<h3 class="orange-text">'+val.restaurant_name+'</h3>'; 
			    			   	   resto_info+='<p class="small">'+val.merchant_address+'</p>'; 
			    			   	   resto_info+='<a class="orange-button" href="'+val.link+'">'+js_lang.trans_37+'</a>';
			    			   resto_info+='</div>';
	    			   	   resto_info+='</div>';
    			   	   resto_info+='<div>';    		
    			   	   
    			   	   last_lat=val.latitude;
    			   	   last_lng=val.lontitude;
    			   	  
    			   	   var latlng = new google.maps.LatLng( last_lat , last_lng );
    			   	   bounds.push(latlng);
    			   	    
    			   	    map.addMarker({
							lat: val.latitude,
							lng: val.lontitude,
							title: val.restaurant_name,
							icon : map_marker ,
							infoWindow: {
							  content: resto_info
							}
						});		     
						
    			   });    			   
    			
    			   if ( $("#full-map").exists() ){
    			   	   //map.setCenter(last_lat,last_lng);
    			   	   map.fitLatLngBounds(bounds);
    			   }
    			   
    			   if ( $(".search-map-results").exists() ){
    			   	   dump('fitLatLngBounds');
    			   	   map.fitLatLngBounds(bounds);
    			   }
    			   
    			break;
    			
    			case "SetLocationSearch":
    			   window.location.href=data.details;
    			break;
    			
    			case "CheckLocationData":
    			   if( !empty($("#merchant_id").val())){
    			     fancyBoxFront("ShowLocationFee", "merchant_id="+$("#merchant_id").val() );
    			   } else {
    			   	  window.location.href= sites_url;
    			   }
    			break;
    			
    			case "SetLocationFee":
    			  close_fb();
    			  window.location.reload();
    			break;

    			case "LoadCityList":
    			 $("#city_id").html(data.details);
    			break;
    			
    			case "LoadArea":
    			 $("#area_id").html(data.details);
    			break;
    					    
    			case "LoadPostCodeByArea":
    			  $("#zipcode").val(data.details);
    			break;
    						    			
    			default:
    			   uk_msg_sucess(data.msg);
    			   if (!empty(data.details)){
    			   	   if (!empty(data.details.redirect)){
    			   	   	   dump(data.details.redirect);
    			   	   	   window.location.href=data.details.redirect;
    			   	   	   return;
    			   	   }
    			   }    			   
    			break;
    		}
    	} else { // my failed
    		
    		switch (action){
    			
    			case "CheckLocationData":
    			//silent
    			break;
    			
    			case "LoadPostCodeByArea":
    			  $("#zipcode").val('');
    			break;
    			
    			default: 
    			uk_msg(data.msg);
    			break;
    			   			
    		}    		    		
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    	showPreloader(false);
    	if (!empty(buttons)){
    		buttons.html(buttons_text);
		    buttons.css({ 'pointer-events' : 'auto' });
    	}
    }		
    });   	     	  
}

function onloadMyCallback()
{				
	//dump('init kapcha');
	if ( $("#kapcha-1").exists()){
	   if ( $("#kapcha-1").html()=="" ){
	        recaptcha1=grecaptcha.render(document.getElementById('kapcha-1'), {'sitekey' : captcha_site_key});    
	   } 
	}
	if ( $("#kapcha-2").exists()){
		if ( $("#kapcha-2").html()=="" ){
	        recaptcha1=grecaptcha.render(document.getElementById('kapcha-2'), {'sitekey' : captcha_site_key});    
		}
	}
}

function initOtable()
{
	dump('otables');	
	otables = $('.otable').dataTable({
	"bProcessing": true, 
	"bServerSide": false,	    
	"bFilter":false,
	"bLengthChange":false,	
	"sAjaxSource": front_ajax+"/" + $("#otable_action").val() ,
	"oLanguage":{
		 "sInfo": js_lang.trans_13 ,
		 "sEmptyTable": sEmptyTable,
		 "sInfoEmpty":  js_lang.tablet_3,
		 "sProcessing": "<p>"+js_lang.tablet_7+" <i class=\"fa fa-spinner fa-spin\"></i></p>",
		 "oPaginate": {
	        "sFirst":    js_lang.tablet_10,
	        "sLast":     js_lang.tablet_11,
	        "sNext":     js_lang.tablet_12,
	        "sPrevious": js_lang.tablet_13
	  }
	},
	"fnInitComplete": function (oSettings, json){ 	  
	}
	});		
}

function OtableReload()
{
	otables.fnReloadAjax(); 
}

 function rowRemove(id,tbl,whereid,object)
{			
	busy(true);
	var params="action=rowDelete&tbl="+tbl+"&row_id="+id+"&whereid="+whereid;	
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){
        	busy(false);
        	if (data.code==1){               		
        		tr=object.closest("tr");
                tr.fadeOut("slow");
        	} else {      
        		uk_msg(data.msg);
        	}        	        	
        }, 
        error: function(){	        	        	
        	busy(false);
        	uk_msg(js_lang.trans_14);
        }		
    });
}

function uploadAvatar(data)
{
	dump(data);
	if ( data.code==1){
		$(".avatar-wrap").html( '<img src="'+upload_url+"/"+data.details.file +'" class="img-circle" />' );
		callAjax("saveAvatar",'filename='+data.details.file );
	} else {
		uk_msg(data.msg);
	}
}

function iniRestoSearch(fields,actions)
{
	var parent=$("."+fields).parent().parent();	
	var button=parent.find("i");
	
	var options = {
	  url: function(phrase) {
	    return home_url+"/"+actions;
	  },		
	  getValue: function(element) {
	    return element.name;
	  },		
	  ajaxSettings: {
	    dataType: "json",
	    method: "POST",
	    data: {
	      dataType: "json"
	    },
	    beforeSend: function(xhr, opts){	    	
	    	busy(true);
	    },
	    complete: function(data) {
	    	busy(false);
	    	dump(data);
	    },
	  },		
	  preparePostData: function(data) {
	    data.search = $("."+fields).val();
	    
	    if ( $("#merchant_id").exists() ){
	    	data.merchant_id = $("#merchant_id").val();
	    }
	    
	    return data;
	  },
      requestDelay: 500
   };      
   $("."+fields).easyAutocomplete(options);
}


/*JQUERY BROWSER*/
var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
/*JQUERY BROWSER*/



jQuery(document).ready(function() {		
	
	$( document ).on( "click", ".language-selection a", function() {
		$(".language-selection-wrap").slideDown("fast");
	});
	$( document ).on( "click", ".language-selection-close", function() {
		$(".language-selection-wrap").fadeOut("slow");
	});
	$( document ).on( "click", ".lang-selector", function() {
		$(".lang-selector").removeClass("highlight");
		$(this).addClass("highlight");
		$(".change-language").attr("href", home_url+"/setlanguage/Id/"+ $(this).data("id")  );
	});
	
	$( document ).on( "click", ".goto-reviews-tab", function() {
	   $(".view-reviews").click();
	   scroll_class('view-reviews');
	});
	
	if ( $("#theme_time_pick").val() == "2"){	
		var is_twelve_period=false;
		if ( $("#website_time_picker_format").exists() ){		
			if ( $("#website_time_picker_format").val()=="12"){
				is_twelve_period=true;
			}
		}
		var time_format='hh:mm p';
		if (!is_twelve_period){
			dump('24 hour');
			time_format='H:mm';
		} 
		$('.timepick').timepicker({
			timeFormat: time_format,
			//interval:15
		});
	    $('#booking_time').timepicker({
	    	timeFormat: time_format
            //timeFormat: 'H:mm'
        });	
	}
	
	$( document ).on( "click", ".back-map-address", function() {
		$(this).hide();
				
		$("#street").attr("data-validation","required");
  	    $("#city").attr("data-validation","required");
  	    $("#state").attr("data-validation","required");
   	          	  
		$(".address_book_wrap").show();		
		$("#map_address_toogle").val(1);
		$(".map-address-wrap-inner").hide();	
		$(".map-address").show();		
	});
	
	
	/*if ( $("#s").exists() ){
		$('#s').keypress(function (e) {
			if (e.which == 13) {				
				$("#forms-search").submit();
			}
		});
	}*/	
	
}); /*ready*/


jQuery(document).ready(function() {		
	
	if($("#menu-right-content").exists()){
		if($("#menu-right-content").hasClass("hide")){
			$(".cart-mobile-handle").hide();
		}
	}
		
	if( $('.cart-mobile-handle').is(':visible') ) {			
		showMobileCartNos();		
	}
	
}); /*ready*/

function showMobileCartNos()
{
	busy(true);
	var params="action=getCartCount&tbl=cart";	
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){
        	busy(false);
        	if (data.code==1){    
        		$(".cart_count").html(data.details);       
        		$(".cart_count").show();
        	} else {      	        		
        		$(".cart_count").html(0);       
        		$(".cart_count").hide();
        	}        	        	
        }, 
        error: function(){	        	        	
        	busy(false);	        	
        }		
    });
}

/*VERSION 4.0*/
jQuery(document).ready(function() {		
		
	 $( "#s" ).on( "keydown", function(event) {
	 	if(event.which == 13){
	 	   $("#forms-search").submit();
	 	}
	 });
	 
	 $( document ).on( "click", ".apply_tip", function() {
	 	 var tip_type = $(".tips.active").data("type");	 
	 	 dump(tip_type);	 	 
	 	 if ( tip_type=="tip"){
	 	 	 var tips = $(".tips.active").data("tip");	 	 
	 	 	 $("#cart_tip_percentage").val( tips );
	 	 } else {
	 	 	 $("#cart_tip_percentage").val( $("#cart_tip_cash_percentage").val() );
	 	 }	 	 
	 	 load_item_cart();
	 });
	 
	 if ( $(".search_foodname").exists() ){    	
    	iniRestoSearch('search_foodname','autoFoodItem');  
	 }	
	 
	 if ( $("#location_search_type").exists()){	 	 
	 	 switch ($("#location_search_type").val()){
	 	 	case "2":	
	 	 	case 2:
	 	 	locationLoadState();
	 	 	locationLoadArea( $(".typhead_city"), $("#city_id") , $("#state_id") ,'state_id' , 'CityList' );
	 	 	break
	 	 	
	 	 	case "3":
	 	 	case 3:
	 	 	locationLoadPostalCode();
	 	 	break
	 	 		 	 	
	 	 	default:
	 	 	locationLoadCity();
	 	 	locationLoadArea( $(".typhead_area"), $("#area_id") , $("#city_id") ,'city_id' , 'AreaList' );
	 	 	break
	 	 }
	 }
	 
	 $.validate({ 	
		language : jsLanguageValidator,
	    form : '#frm-location-search',    
	    onError : function() {      
	    },
	    onSuccess : function() {     
	      var params=$(".frm-location-search").serialize();
	      callAjax( $("#location_action").val() , params , $(".location-search-submit") )
	      return false;
	    }  
	});
	
	if ( $("#search_by_location").exists() ){
		if ($("#search_by_location").val()==1){
			callAjax("CheckLocationData", "delivery_type="+$("#delivery_type").val() );
		}
	}

	$( document ).on( "click", ".change-location", function() {
		fancyBoxFront("ShowLocationFee", "merchant_id="+$("#merchant_id").val() );
	});
		
	$("#state_id").change(function() {		
		if (!empty($(this).val())){
		   $("#state").val( $("#state_id option:selected").text()  );
		   callAjax("LoadCityList","state_id="+$(this).val());
		} else {
		  $("#state").val('');
		  $("#city_id").html('');
		  $("#area_id").html('');
		}
	});
	$("#city_id").change(function() {		
		if (!empty($(this).val())){
		   $("#city").val( $("#city_id option:selected").text()  );
		   callAjax("LoadArea","city_id="+$(this).val());
		} else {
		   $("#area_id").html('');
		   $("#city").val('');
		}
	});
	$("#area_id").change(function() {		
		if (!empty($(this).val())){
			$("#area_name").val( $("#area_id option:selected").text()  );
		   callAjax("LoadPostCodeByArea","area_id="+$(this).val());
		} else {
			$("#area_name").val('');
			$("#zipcode").val('');
		}
	});
	
	/*AGE RESTRICION*/		
	if ( age_restriction==1 ){
		var kr_cookie_age =$.cookie('kr_cookie_age');	
		dump("kr_cookie_age=>"+kr_cookie_age);
		if (empty(kr_cookie_age)){
		    fancyBoxFront("AgeRestriction","");
		}
	}
		
	$( document ).on( "click", ".age-exit", function() {
		close_fb();
		window.location.href=restriction_exit_link;		
	});
	
	$( document ).on( "click", ".age-accept", function() {
	    close_fb();
	    $.cookie('kr_cookie_age', '1', { expires: 500, path: '/' }); 
	});
	
	$( document ).on( "change", ".merchant_type_selection", function() {
		if ( $(this).val()==3){
			$(".invoice_terms_wrap").show();
		} else {
			$(".invoice_terms_wrap").hide();
		}
	});
	
}); /*end doc*/

function showPreloader(busy)
{
	if(busy){
	   $(".main-preloader").show(); 
	} else {
	   $(".main-preloader").hide(); 
	}
}

function locationLoadCity()
{	
	$.get( front_ajax + "/CityList", function(data){		
	   $(".typhead_city").typeahead({ 
	    	source:data,
	    	autoSelect: true,	  
	        showHintOnFocus:true
	   });
	},'json');
	
	$(".typhead_city").change(function() {
	  var current = $(".typhead_city").typeahead("getActive");  
	  if(current){	     
	     $("#city_id").val( current.id );  
	     $("#city_name").val( current.name );  
	     
	     $("#area_id").val( "" );  
	     $("#location_area").val( "" );  
	  }
	});
	
	$( document ).on( "click", ".typhead_city", function() {	 
	 	 $(this).val("");
	});
	$( document ).on( "focusout", ".typhead_city", function() {	 
		 var city_name=$("#city_name").val();
	 	 $(this).val( city_name );
	}); 
}

function locationLoadArea( type_head, text_field , text_field2 , variable_1 , action )
{		 	 
	type_head.typeahead({
	 	autoSelect: true,	  	 
	 	delay:100,   
	 	minLength:2,
        source: function (query, process) {
            return ajaxArea(query,process,text_field2,variable_1 , action);
        }
    });
    type_head.change(function() {
	  var current = type_head.typeahead("getActive");  
	  if(current){	     
	     text_field.val( current.id );  
	     switch (action)
	     {
	     	case "CityList":
	     	$("#city_name").val( current.name );
	     	break;
	     }
	  }
	});
}

var ajax_area;

function ajaxArea(query,process,text_field2,variable_1 , action)
{	
	if(query==""){
		dump("empty query");
		return false;
	}
	var ajax_area = $.ajax({    
    type: "GET",
    //url: front_ajax+"/AreaList",
    url: front_ajax+"/"+action,
    data: "q="+query + "&"+variable_1+"=" + text_field2.val() ,
    timeout: 6000,		
    dataType: 'json',       
    beforeSend: function() {
    	if(ajax_area != null) {
    	   ajax_area.abort();
    	   locationLoader(false);
    	} else {
    	   locationLoader(true);
    	}    	
    },
    complete: function(data) {
    	locationLoader(false);
    },
    success: function(data){ 	      
	      return process(data);
	  }, 
    error: function(){	        	    	
    	locationLoader(false);
    }		
    });   	   
}

function locationLoader(busy)
{
	if(busy){
		$(".typhead_area").attr("disabled",true);
        $(".location-loader").show();
	} else {
		$(".typhead_area").attr("disabled",false);
        $(".location-loader").hide();
	}	
}

function locationLoadState()
{	
	$.get( front_ajax + "/StateList", function(data){		
	   $(".typhead_state").typeahead({ 
	    	source:data,
	    	autoSelect: true,	  
	        showHintOnFocus:true
	   });
	},'json');
	
	$(".typhead_state").change(function() {
	  var current = $(".typhead_state").typeahead("getActive");  
	  if(current){	     
	     $("#state_id").val( current.id );  
	     $("#state_name").val( current.name );  
	     
	     $("#location_city").val('');
	     $("#city_id").val('');
	     $("#city_name").val('');
	  }
	});
	
	$( document ).on( "click", ".typhead_state", function() {	 
	 	 $(this).val("");
	});
	$( document ).on( "focusout", ".typhead_state", function() {	 
		 var state_name=$("#state_name").val();
	 	 $(this).val( state_name );
	}); 
}

function locationLoadPostalCode()
{	
	$.get( front_ajax + "/PostalCodeList", function(data){		
	   $(".typhead_postalcode").typeahead({ 
	    	source:data,
	    	autoSelect: true,	  
	        showHintOnFocus:true
	   });
	},'json');
	
	$(".typhead_postalcode").change(function() {
	  var current = $(".typhead_postalcode").typeahead("getActive");  
	  if(current){	     	     
	     $("#postal_code").val( current.name );  	     	    
	  }
	});
	
	$( document ).on( "click", ".typhead_postalcode", function() {	 
	 	 $(this).val("");
	});
	$( document ).on( "focusout", ".typhead_postalcode", function() {	 
		 var postal_code=$("#postal_code").val();
	 	 $(this).val( postal_code );
	}); 
}

/*VERSION 4.2*/

$.validate({ 	
	language : jsLanguageValidator,
    form : '#forms-review',    
    onError : function() {      
    },
    onSuccess : function() {           
      form_submit('forms-review');
      return true;
    }  
});

/**
* @author dhananjaya
menu-merchant1

**/

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

$(".full_img img").click(function() { 
  $(".qty").toggleClass("quantity-add");
});


// menu.php

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

$('#btnClick').on('click',function(){
	$("#merchant-map").removeAttr("style");
	$('twoo').attr('src', '/assets/images/map.png'); 
    if($('#bag').css('display')!='none')
    {
    	$('#twoo').show().siblings('div').hide();
		 
    }
    else if($('#twoo').css('display')!='none')
    {
        $('#bag').show().siblings('div').hide(); 
    }
});

});
$("#btnClick").click(function() { $("#btnClick").toggleClass("important");
$(this).text($(this).text() == 'Details' ? 'Zones' : 'Details');



$('#sidebarCollapse').on('click', function () {
             $('#sidebar').toggleClass('active');
             $(this).toggleClass('active');
         });
   
var $trigger = $(".dropdown");
if($trigger !== event.target && !$trigger.has(event.target).length){
    $(".takkk").slideUp("fast");
		$(".ee").removeClass("change");
}







});

//VantivPayBtn


$(".submitOrderPay").on('click',function(){
    $("#frm-delivery").submit();
})


$("#VantivPayBtn").on('click',function(){

    var Postdata = $("#ProcessVntPay").serialize();
    $.ajax({
        url: '/admin/ajax',
        method: 'post',
        data: Postdata
    }).done(function(resp){
        console.log(resp);
        var d = JSON.parse(resp);

        if(d.status == '000') {
            swal('info',d.msg,'success');
            window.location = 'receipt?id='+d.OrderID;
        }

        if(d.status == '010') {
            swal('info',d.msg,'success');
        }


    })


})


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

(function(){var t,e,n,r,a,i,o,l,u,c,h,s,p,f,g,d,v,m,y,C,T,w,$,D,S=[].slice,k=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++)if(e in this&&this[e]===t)return e;return-1};(t=window.jQuery||window.Zepto||window.$).payment={},t.payment.fn={},t.fn.payment=function(){var e,n;return n=arguments[0],e=2<=arguments.length?S.call(arguments,1):[],t.payment.fn[n].apply(this,e)},a=/(\d{1,4})/g,t.payment.cards=r=[{type:"visaelectron",pattern:/^4(026|17500|405|508|844|91[37])/,format:a,length:[16,17,18,19],cvcLength:[3],luhn:!0},{type:"maestro",pattern:/^(5(018|0[23]|[68])|6(39|7))/,format:a,length:[12,13,14,15,16,17,18,19],cvcLength:[3],luhn:!0},{type:"forbrugsforeningen",pattern:/^600/,format:a,length:[16,17,18,19],cvcLength:[3],luhn:!0},{type:"dankort",pattern:/^5019/,format:a,length:[16,17,18,19],cvcLength:[3],luhn:!0},{type:"visa",pattern:/^4/,format:a,length:[13,14,15,16,17,18,19],cvcLength:[3],luhn:!0},{type:"mastercard",pattern:/^(5[1-5]|2[2-7])/,format:a,length:[16,17,18,19],cvcLength:[3],luhn:!0},{type:"amex",pattern:/^3[47]/,format:/(\d{1,4})(\d{1,6})?(\d{1,5})?/,length:[15,16,17,18,19],cvcLength:[3,4],luhn:!0},{type:"dinersclub",pattern:/^3[0689]/,format:/(\d{1,4})(\d{1,6})?(\d{1,4})?/,length:[14,15,16,17,18,19],cvcLength:[3],luhn:!0},{type:"discover",pattern:/^6([045]|22)/,format:a,length:[16,17,18,19],cvcLength:[3],luhn:!0},{type:"unionpay",pattern:/^(62|88)/,format:a,length:[16,17,18,19],cvcLength:[3],luhn:!1},{type:"jcb",pattern:/^35/,format:a,length:[16,17,18,19],cvcLength:[3],luhn:!0}],e=function(t){var e,n,a;for(t=(t+"").replace(/\D/g,""),n=0,a=r.length;n<a;n++)if((e=r[n]).pattern.test(t))return e},n=function(t){var e,n,a;for(n=0,a=r.length;n<a;n++)if((e=r[n]).type===t)return e},p=function(t){var e,n,r,a,i,o;for(r=!0,a=0,i=0,o=(n=(t+"").split("").reverse()).length;i<o;i++)e=n[i],e=parseInt(e,10),(r=!r)&&(e*=2),e>9&&(e-=9),a+=e;return a%10==0},s=function(t){var e;return null!=t.prop("selectionStart")&&t.prop("selectionStart")!==t.prop("selectionEnd")||!(null==("undefined"!=typeof document&&null!==document&&null!=(e=document.selection)?e.createRange:void 0)||!document.selection.createRange().text)},$=function(t,e){var n,r;try{n=e.prop("selectionStart")}catch(t){t,n=null}if(r=e.val(),e.val(t),null!==n&&e.is(":focus"))return n===r.length&&(n=t.length),e.prop("selectionStart",n),e.prop("selectionEnd",n)},m=function(t){var e,n,r,a,i,o,l,u;for(null==t&&(t=""),r="０１２３４５６７８９",a="0123456789",o="",l=0,u=(n=t.split("")).length;l<u;l++)e=n[l],(i=r.indexOf(e))>-1&&(e=a[i]),o+=e;return o},v=function(e){return setTimeout(function(){var n,r;return r=(n=t(e.currentTarget)).val(),r=(r=m(r)).replace(/\D/g,""),$(r,n)})},g=function(e){return setTimeout(function(){var n,r;return r=(n=t(e.currentTarget)).val(),r=m(r),r=t.payment.formatCardNumber(r),$(r,n)})},l=function(n){var r,a,i,o,l,u,c;if(i=String.fromCharCode(n.which),/^\d+$/.test(i)&&(r=t(n.currentTarget),c=r.val(),a=e(c+i),o=(c.replace(/\D/g,"")+i).length,u=16,a&&(u=a.length[a.length.length-1]),!(o>=u||null!=r.prop("selectionStart")&&r.prop("selectionStart")!==c.length)))return(l=a&&"amex"===a.type?/^(\d{4}|\d{4}\s\d{6})$/:/(?:^|\s)(\d{4})$/).test(c)?(n.preventDefault(),setTimeout(function(){return r.val(c+" "+i)})):l.test(c+i)?(n.preventDefault(),setTimeout(function(){return r.val(c+i+" ")})):void 0},i=function(e){var n,r;if(n=t(e.currentTarget),r=n.val(),8===e.which&&(null==n.prop("selectionStart")||n.prop("selectionStart")===r.length))return/\d\s$/.test(r)?(e.preventDefault(),setTimeout(function(){return n.val(r.replace(/\d\s$/,""))})):/\s\d?$/.test(r)?(e.preventDefault(),setTimeout(function(){return n.val(r.replace(/\d$/,""))})):void 0},d=function(e){return setTimeout(function(){var n,r;return r=(n=t(e.currentTarget)).val(),r=m(r),r=t.payment.formatExpiry(r),$(r,n)})},u=function(e){var n,r,a;if(r=String.fromCharCode(e.which),/^\d+$/.test(r))return n=t(e.currentTarget),a=n.val()+r,/^\d$/.test(a)&&"0"!==a&&"1"!==a?(e.preventDefault(),setTimeout(function(){return n.val("0"+a+" / ")})):/^\d\d$/.test(a)?(e.preventDefault(),setTimeout(function(){return n.val(a+" / ")})):void 0},c=function(e){var n,r,a;if(r=String.fromCharCode(e.which),/^\d+$/.test(r))return a=(n=t(e.currentTarget)).val(),/^\d\d$/.test(a)?n.val(a+" / "):void 0},h=function(e){var n,r,a;if("/"===(a=String.fromCharCode(e.which))||" "===a)return r=(n=t(e.currentTarget)).val(),/^\d$/.test(r)&&"0"!==r?n.val("0"+r+" / "):void 0},o=function(e){var n,r;if(n=t(e.currentTarget),r=n.val(),8===e.which&&(null==n.prop("selectionStart")||n.prop("selectionStart")===r.length))return/\d\s\/\s$/.test(r)?(e.preventDefault(),setTimeout(function(){return n.val(r.replace(/\d\s\/\s$/,""))})):void 0},f=function(e){return setTimeout(function(){var n,r;return r=(n=t(e.currentTarget)).val(),r=(r=m(r)).replace(/\D/g,"").slice(0,4),$(r,n)})},w=function(t){var e;return!(!t.metaKey&&!t.ctrlKey)||32!==t.which&&(0===t.which||(t.which<33||(e=String.fromCharCode(t.which),!!/[\d\s]/.test(e))))},C=function(n){var r,a,i,o;if(r=t(n.currentTarget),i=String.fromCharCode(n.which),/^\d+$/.test(i)&&!s(r))return o=(r.val()+i).replace(/\D/g,""),(a=e(o))?o.length<=a.length[a.length.length-1]:o.length<=16},T=function(e){var n,r;if(n=t(e.currentTarget),r=String.fromCharCode(e.which),/^\d+$/.test(r)&&!s(n))return!((n.val()+r).replace(/\D/g,"").length>6)&&void 0},y=function(e){var n,r;if(n=t(e.currentTarget),r=String.fromCharCode(e.which),/^\d+$/.test(r)&&!s(n))return(n.val()+r).length<=4},D=function(e){var n,a,i,o,l;if(l=(n=t(e.currentTarget)).val(),o=t.payment.cardType(l)||"unknown",!n.hasClass(o))return a=function(){var t,e,n;for(n=[],t=0,e=r.length;t<e;t++)i=r[t],n.push(i.type);return n}(),n.removeClass("unknown"),n.removeClass(a.join(" ")),n.addClass(o),n.toggleClass("identified","unknown"!==o),n.trigger("payment.cardType",o)},t.payment.fn.formatCardCVC=function(){return this.on("keypress",w),this.on("keypress",y),this.on("paste",f),this.on("change",f),this.on("input",f),this},t.payment.fn.formatCardExpiry=function(){return this.on("keypress",w),this.on("keypress",T),this.on("keypress",u),this.on("keypress",h),this.on("keypress",c),this.on("keydown",o),this.on("change",d),this.on("input",d),this},t.payment.fn.formatCardNumber=function(){return this.on("keypress",w),this.on("keypress",C),this.on("keypress",l),this.on("keydown",i),this.on("keyup",D),this.on("paste",g),this.on("change",g),this.on("input",g),this.on("input",D),this},t.payment.fn.restrictNumeric=function(){return this.on("keypress",w),this.on("paste",v),this.on("change",v),this.on("input",v),this},t.payment.fn.cardExpiryVal=function(){return t.payment.cardExpiryVal(t(this).val())},t.payment.cardExpiryVal=function(t){var e,n,r;return e=(r=t.split(/[\s\/]+/,2))[0],2===(null!=(n=r[1])?n.length:void 0)&&/^\d+$/.test(n)&&(n=(new Date).getFullYear().toString().slice(0,2)+n),{month:e=parseInt(e,10),year:n=parseInt(n,10)}},t.payment.validateCardNumber=function(t){var n,r;return t=(t+"").replace(/\s+|-/g,""),!!/^\d+$/.test(t)&&(!!(n=e(t))&&(r=t.length,k.call(n.length,r)>=0&&(!1===n.luhn||p(t))))},t.payment.validateCardExpiry=function(e,n){var r,a,i;return"object"==typeof e&&"month"in e&&(e=(i=e).month,n=i.year),!(!e||!n)&&(e=t.trim(e),n=t.trim(n),!!/^\d+$/.test(e)&&(!!/^\d+$/.test(n)&&(1<=e&&e<=12&&(2===n.length&&(n=n<70?"20"+n:"19"+n),4===n.length&&(a=new Date(n,e),r=new Date,a.setMonth(a.getMonth()-1),a.setMonth(a.getMonth()+1,1),a>r)))))},t.payment.validateCardCVC=function(e,r){var a,i;return e=t.trim(e),!!/^\d+$/.test(e)&&(null!=(a=n(r))?(i=e.length,k.call(a.cvcLength,i)>=0):e.length>=3&&e.length<=4)},t.payment.cardType=function(t){var n;return t&&(null!=(n=e(t))?n.type:void 0)||null},t.payment.formatCardNumber=function(n){var r,a,i,o;return n=n.replace(/\D/g,""),(r=e(n))?(i=r.length[r.length.length-1],n=n.slice(0,i),r.format.global?null!=(o=n.match(r.format))?o.join(" "):void 0:null!=(a=r.format.exec(n))?(a.shift(),(a=t.grep(a,function(t){return t})).join(" ")):void 0):n},t.payment.formatExpiry=function(t){var e,n,r,a;return(n=t.match(/^\D*(\d{1,2})(\D+)?(\d{1,4})?/))?(e=n[1]||"",r=n[2]||"",(a=n[3]||"").length>0?r=" / ":" /"===r?(e=e.substring(0,1),r=""):2===e.length||r.length>0?r=" / ":1===e.length&&"0"!==e&&"1"!==e&&(e="0"+e,r=" / "),e+r+a):""}}).call(this);
(function(){var n,t,r,e=[].indexOf||function(n){for(var t=0,r=this.length;t<r;t++)if(t in this&&this[t]===n)return t;return-1};r=function(){function n(){this.trie={}}return n.prototype.push=function(n){var t,r,e,i,a,l,u;for(n=n.toString(),a=this.trie,u=[],r=e=0,i=(l=n.split("")).length;e<i;r=++e)null==a[t=l[r]]&&(r===n.length-1?a[t]=null:a[t]={}),u.push(a=a[t]);return u},n.prototype.find=function(n){var t,r,e,i,a,l;for(n=n.toString(),a=this.trie,r=e=0,i=(l=n.split("")).length;e<i;r=++e){if(t=l[r],!a.hasOwnProperty(t))return!1;if(null===a[t])return!0;a=a[t]}},n}(),t=function(){function n(n){if(this.trie=n,this.trie.constructor!==r)throw Error("Range constructor requires a Trie parameter")}return n.rangeWithString=function(t){var e,i,a,l,u,o,c,h,f;if("string"!=typeof t)throw Error("rangeWithString requires a string parameter");for(t=(t=t.replace(/ /g,"")).split(","),f=new r,e=0,a=t.length;e<a;e++)if(u=(o=t[e]).match(/^(\d+)-(\d+)$/))for(l=i=c=u[1],h=u[2];c<=h?i<=h:i>=h;l=c<=h?++i:--i)f.push(l);else{if(!o.match(/^\d+$/))throw Error("Invalid range '"+u+"'");f.push(o)}return new n(f)},n.prototype.match=function(n){return this.trie.find(n)},n}(),(n=jQuery).fn.validateCreditCard=function(r,i){var a,l,u,o,c,h,f,s,g,p,v,d,m,y,_,w;for(o=[{name:"amex",range:"34,37",valid_length:[15,16,17,18,19]},{name:"jcb",range:"3528-3589",valid_length:[16,17,18,19]},{name:"visa",range:"4",valid_length:[13,14,15,16,17,18,19]},{name:"mastercard",range:"51-55,2221-2720",valid_length:[16,17,18,19]},{name:"discover",range:"6011, 622126-622925, 644-649, 65",valid_length:[16,17,18,19]},{name:"unionpay",range:"62",valid_length:[16,17,18,19]}],a=!1,r&&("object"==typeof r?(i=r,a=!1,r=null):"function"==typeof r&&(a=!0)),null==i&&(i={}),null==i.accept&&(i.accept=function(){var n,t,r;for(r=[],n=0,t=o.length;n<t;n++)l=o[n],r.push(l.name);return r}()),s=0,g=(v=i.accept).length;s<g;s++)if(u=v[s],e.call(function(){var n,t,r;for(r=[],n=0,t=o.length;n<t;n++)l=o[n],r.push(l.name);return r}(),u)<0)throw Error("Credit card type '"+u+"' is not supported");return c=function(n){var r,a,c;for(r=0,a=(c=function(){var n,t,r,a;for(a=[],n=0,t=o.length;n<t;n++)r=(l=o[n]).name,e.call(i.accept,r)>=0&&a.push(l);return a}()).length;r<a;r++)if(u=c[r],t.rangeWithString(u.range).match(n))return u;return null},f=function(n){var t,r,e,i,a,l;for(l=0,i=r=0,e=(a=n.split("").reverse()).length;r<e;i=++r)t=+(t=a[i]),l+=i%2?(t*=2)<10?t:t-9:t;return l%10==0},h=function(n,t){var r;return r=n.length,e.call(t.valid_length,r)>=0},m=function(n){var t,r;return r=!1,t=!1,null!=(u=c(n))&&(r=f(n),t=h(n,u)),{card_type:u,valid:r&&t,luhn_valid:r,length_valid:t}},y=this,d=function(){var t;return t=p(n(y).val()),m(t)},p=function(n){return n.replace(/[ -]/g,"")},a?(this.on("input.jccv",(_=this,function(){return n(_).off("keyup.jccv"),r.call(_,d())})),this.on("keyup.jccv",(w=this,function(){return r.call(w,d())})),r.call(this,d()),this):d()}}).call(this);



var expiryDate, validateExpiryDate, cvvNumber,
    expiry_icon = $('.valid_inputCardExpiry').closest('.expiry-date').find('i'),
    cvv_icon = $('.valid_cc_cscv').closest('.cvv-number').find('i');

// Check MM/YY
function checkExpiry()
{
    expiryDate = $.payment.cardExpiryVal($('.valid_inputCardExpiry').val());
    validateExpiryDate = $.payment.validateCardExpiry(expiryDate.month, expiryDate.year);

    if (validateExpiryDate == true || (isNaN(expiryDate.month) && isNaN(expiryDate.year)))
    {
        hideExpiryError();
    }
    else
    {
        expiry_icon.closest('.expiry-date').addClass('validation-error');
    }
}

function hideExpiryError()
{
    expiry_icon.removeClass();
    expiry_icon.closest('.expiry-date').removeClass('validation-error');
}

function checkCVV()
{
    cvvNumber = $.payment.validateCardCVC($('.valid_cc_cscv').val());
    if ( cvvNumber == true || !$('.valid_cc_cscv').val() )
    {
        hideCVVError();
    }
    else
    {
        cvv_icon.closest('.cvv-number').addClass('validation-error');
    }
}

function hideCVVError()
{
    cvv_icon.removeClass();
    cvv_icon.closest('.cvv-number').removeClass('validation-error');
}

function validateCC()
{
    $('.valid_cc_number').validateCreditCard(function(result)
    {
        var cc_icon = $('.valid_cc_number').closest('.card-number').find('i'), cc_name;
        var cc_empty = $('input[name=cc_number]').val() == '';

        if (cc_empty)
        {
            cc_icon.removeClass();
            cc_icon.closest('.card-number').removeClass('validation-error');
        }
        else
        {
            if ( result.card_type == null && !cc_empty )
            {
                cc_icon.removeClass();
                cc_icon.closest('.card-number').addClass('validation-error');
                cc_icon.addClass('input-validation-icon zmdi zmdi-alert-circle-o');
            }
            else
            {
                cards = [];

                cards.push('amex');
                cards.push('discover');
                cards.push('jcb');
                cards.push('mastercard');
                cards.push('visa');
                cards.push('unionpay');

                if ($.inArray(result.card_type.name, cards) !== -1)
                {
                    cc_icon.closest('.card-number').removeClass('validation-error');
                    cc_icon.removeClass();
                    cc_icon.addClass('icon ccicon_'+result.card_type.name);
                }
                else
                {
                    cc_icon.removeClass();
                    cc_icon.addClass('input-validation-icon zmdi zmdi-alert-circle-o');
                    cc_icon.closest('.card-number').addClass('validation-error');
                }
            }
        }
    });
}


$(document).ready(function()
{


    $('.valid_inputCardExpiry').payment('formatCardExpiry');
    $('.valid_cc_number').payment('formatCardNumber');

    // Show cc icon on page load.
    if ($('.valid_cc_number').val().length > 0)
    {
        validateCC();
    }

    // CC CHECK LISTENERS
    $('.valid_cc_number').keyup(function()
    {
        if ($('.valid_cc_number').val().length == 0)
        {
            var cc_icon = $('.valid_cc_number').closest('.card-number').find('i'), cc_name;

            cc_icon.removeClass();
            cc_icon.closest('.card-number').removeClass('validation-error');
        }

        if ($('.valid_cc_number').val().length >= 13)
        {
            validateCC();
        }
    });

    $('.valid_cc_number').focusout(function()
    {
        var cc_icon = $('.valid_cc_number').closest('.card-number').find('i'), cc_name;
        var cc_empty = $('input[name=cc_number]').val() == '';

        if ($(this).val().length > 0)
        {
            $(this).validateCreditCard(function(result)
            {
                if (!result.length_valid)
                {
                    cc_icon.removeClass();
                    cc_icon.addClass('input-validation-icon zmdi zmdi-alert-circle-o');
                    cc_icon.closest('.card-number').addClass('validation-error');
                }
            });
        }
    });

    // EXPIRY CHECK LISTENERS.
    $('.valid_inputCardExpiry').on('keyup', function()
    {
        var expiry_max_length = 7;
        if ($(this).val().length == expiry_max_length)
        {
            checkExpiry();
        }

        if ($(this).val().length == 0)
        {
            hideExpiryError();
        }
    });

    $('.valid_inputCardExpiry').on('focusout', function()
    {
        checkExpiry();
    });


    // CVV CHECK LISTENERS.
    $('.valid_cc_cscv').on('keyup', function()
    {
        var cvv_min_length = 3;
        if ($(this).val().length >= cvv_min_length)
        {
            checkCVV();
        }

        if ($(this).val().length == 0)
        {
            hideCVVError();
        }
    });

    $('.valid_cc_cscv').on('focusout', function()
    {
        checkCVV();
    });

});
