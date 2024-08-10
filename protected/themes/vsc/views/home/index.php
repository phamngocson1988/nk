<?php   $baseUrl = Yii::app()->getBaseUrl(); 
        $controller = Yii::app()->getController()->getAction()->controller->id;
        $action     = Yii::app()->getController()->getAction()->controller->action->id;

        $lang = Yii::app()->request->getParam('lang',''); 
        if ($lang != '') {
            Yii::app()->session['lang'] = $lang;
        } else {
            if (isset(Yii::app()->session['lang'])) {
                $lang = Yii::app()->session['lang'];
            } else {
                $lang = 'vi';
            }
        }  
        Yii::app()->setLanguage($lang);
?>
<?php
	$this->metaKeywords = $data_seo[0]['meta_keywords'];
	$this->metaDescription = $data_seo[0]['meta_description'];
	$this->pageTitle = $data_seo[0]['meta_title'];
	// $this->canonical = $model->getAbsoluteUrl(); // canonical URLs should always be absolute
?>

<script type="text/javascript">

	jQuery(function($) {
		// Asynchronously Load the map API 
		var script = document.createElement('script');
		script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCFAVSpXPepjSP87AkCiaXnyYj-VYm6yZc";

		document.body.appendChild(script);
	});

	jQuery.fn.exists = function(){return this.length>0;}

	function initialize() {

	if ($("#map_canvas").exists()) {
	
		var map;
		var bounds = new google.maps.LatLngBounds();
		var mapOptions = {
		    mapTypeId: 'roadmap'
		};
		                
		// Display a map on the page
		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		map.setTilt(45);
		    
		// Multiple Markers
		var markers = [
		    ['Nha Khoa 2000',10.762774,106.691045],
		    ['Nha Khoa 2000',10.759070,106.668309]
		];
		                    
		// Info Window Content
		var infoWindowContent = [
		    ['<div class="info_content">' +
		    '<h4>Nha Khoa 2000 CS1</h4>' +
		    '<p></p>' +        '</div>'],
		    ['<div class="info_content">' +
		    '<h4>Nha Khoa 2000 CS2</h4>' +
		    '<p></p>' +
		    '</div>']
		];
		    
		// Display multiple markers on a map
		var infoWindow = new google.maps.InfoWindow(), marker, i;

		// Loop through our array of markers & place each one on the map  
		for( i = 0; i < markers.length; i++ ) {
		    var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
		    bounds.extend(position);
		    marker = new google.maps.Marker({
		        position: position,
		        map: map,
		        title: markers[i][0],
		        label: markers[i][0],
		    });

		    marker.setMap(map);
		    
		    // Allow each marker to have an info window    
		    google.maps.event.addListener(marker, 'click', (function(marker, i) {
		        return function() {
		            infoWindow.setContent(infoWindowContent[i][0]);
		            infoWindow.open(map, marker);
		        }
		    })(marker, i));

		    // Automatically center the map fitting all markers on the screen
		    map.fitBounds(bounds);
		}

		// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
		var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
		    this.setZoom(15);
		    google.maps.event.removeListener(boundsListener);
		});

		}
	}

</script>

<style>
.contentwrap {position: relative;z-index: 5;}
.bg_home {overflow: hidden;}
#bg_01,#bg_02{height: 12em;}
.margin_text_right{margin-bottom: 50px;}
.t1{margin-bottom: 0px;}
.t2{margin-bottom: 20px;}
.baiviet_box h4 {font-weight: bold;font-size: 20px !important;}
.choose_slider {height: 380px;position: relative;}
.current_item .text_active{display: block !important;}
.btn-in-banner{color: #fff !important;background: rgba(211,211,211,0.6);width: 170px;text-align: center;height: 45px;padding: 10px;border-radius: 10px;cursor: pointer;}
.btn-in-banner a{color: #fff;}
.text-banner-home{color: #fff;}
.position-text-banner-home{position: absolute;background: rgba(0, 0, 0, .3);}
#owl_partner .item_partner{margin: 0px 30px;}

#next {position: absolute;top: 45%;right: 0%;width: 50px;height: 50px;background: url(<?php echo Yii::app()->params['image_url']; ?>/images/next.png) no-repeat;background-size: 100% 100%;}
#prev {position: absolute;top: 45%;left: 15px;width: 50px;height: 50px;background: url(<?php echo Yii::app()->params['image_url']; ?>/images/prev.png) no-repeat;background-size: 100% 100%;}
@media only screen and (max-width: 768px){
    #next {position: absolute;top: 20%;right: 0%;width: 50px;height: 50px;background: url(<?php echo Yii::app()->params['image_url']; ?>/images/next.png) no-repeat;background-size: 100% 100%;}
    #prev {position: absolute;top: 20%;left: 15px;width: 50px;height: 50px;background: url(<?php echo Yii::app()->params['image_url']; ?>/images/prev.png) no-repeat;background-size: 100% 100%;}
    .text-banner-home{color: #fff;font-size: 20px}
}

</style>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- owl-carousel-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/owl-carousel/owl.carousel.css">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/owl-carousel/owl.carousel.js"></script>
<!-- Campaign specific CSS & JS -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cssslider.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animated-slider.css"/>
<?php 
    $list_banner = Advertise::model()->findAllByAttributes(array('language'=>$lang));
?>
<div id="banner">
    <div id="owl-banner" class="owl-carousel" >
    <?php 
        foreach ($list_banner as $key => $item){
    ?>
        <div class="item_banner" style="position: relative; ">
           
            <a href="<?php echo $item['url'] ; ?>">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/slider/lg/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="img-responsive">
            </a>
            <?php if( $item['name']){?>
                <div class="wow fadeInUp position-text-banner-home" data-wow-duration="2s">
                    <p class="text-banner-home"><?php echo $item['name']; ?></p>
                </div>
            <?php }?>
        </div>
    <?php }?>
    </div>
    <div>
        <div id="prev" class="prev"></div>
        <div id="next" class="next"></div>
    </div>
    <div id="scroll"></div>
</div>

<!--end banner slider-->
<div id="intro">
	<div class="container">
	<div class="row" style="position: relative;">
		<div class="col-sm-5 hidden-xs">
            <input type="hidden" id="numIMG" value="<?php echo count(PImages::model()->findAllByAttributes(array('id_type'=>7))); ?>">
			<img style="left: 0px;top: 0px;" name="myimage" src="<?php echo Yii::app()->params['image_url']; ?>/images/section_1.png" alt="" class="img-responsive">
		</div> <!-- position: absolute;-->
		<div class="col-sm-7 margin-top-15 margin-bottom-25" id="intro_text">
			    <h2 class="text_green"><?php echo Yii::t('translate','welcome'); ?></h2>
                <h1 style="color: #6a8d2c;"><?php echo Yii::t('translate','nhakhoa2000'); ?></h1>
                <hr/>
			<div>
            <?php if($lang =='vi'){?>
				<p><?php echo $gioithieu[0]['content']; ?></p>
            <?php }else{?>
                <p><?php echo $gioithieu[0]['content_en']; ?></p>
            <?php }?>
			</div>
		</div>
	</div>
	</div>
</div>

<div id="info" style="display: none;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="choose_slider">
                    <div class="choose_slider_items">
                        <ul id="mySlider1">
                        <?php
                            $data_review = PReviewCustomer::model()->findAllByAttributes(array('status_hidden'=>1));
                            if($data_review)
                            {
                                foreach ($data_review as $item) 
                                {
                        ?>
                                <li class="current_item">
                                    <a>
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/review/lg/<?php echo $item['r_img']; ?>" alt="<?php echo $item['r_name']; ?>" />
                                    </a>
                                    <div class="info_name_job">
                                    	<p style="margin-bottom: 0px"><?php echo $item['r_name']; ?></p>
                                    </div>
                                    <div style="display: none;margin-top: 30px;" class="text_active">
                                    <p style="text-align: left;">

                                        <img style="width: 5%" src="<?php echo Yii::app()->params['image_url']; ?>/images/iconhome/ngoac-mo.png"  alt="review-ngoac-mo"/></p>
                                        <?php if($lang=='vi'){?>
                                            <div style="font-size: 14px;padding: 0px 20px;">
                                                <?php echo $item['r_content']; ?>
                                            </div>
                                        <?php }else{?>
                                             <div style="font-size: 14px;padding: 0px 20px;">
                                                <?php echo $item['content_en']; ?>
                                            </div>
                                        <?php }?>

                                    <p style="text-align: right;"><img style="width: 5%" src="<?php echo Yii::app()->params['image_url']; ?>/images/iconhome/ngoac-dong.png"  alt="review-ngoac-dong"/></p>
                                    </div>
                                </li>
                        <?php 
                                }
                            }
                        ?>
                        </ul>
                    </div>
                </div>
                <div class="btn_next_pre" style="text-align: center;margin-bottom: 30px;">
                	<span style="margin-right: 6px;">
                        <a id="btn_next1" href="#">
                            <img id="next" src="<?php echo Yii::app()->params['image_url']; ?>/images/iconhome/lui-rv-def.png" alt="next-nhakhoa2000" style="width: 2%"/>
                        </a>
                    </span>
                	<span>
                        <a id="btn_prev1" href="#">
                            <img id="prev" src="<?php echo Yii::app()->params['image_url']; ?>/images/iconhome/toi-rv-def.png" style="width: 2%"/>
                        </a>
                    </span>
                </div>
                
			</div>
		</div>
	</div>	
</div> <!-- hidden-xs  -->
<!-- hidden-xs -->
<div class="hidden-xs" id="info">
    <div class="" style="width: 50%; margin: 0px 25%;">
        <div id="owl_infor" class="owl-carousel">
            <?php
                $data_review_xs = PReviewCustomer::model()->findAllByAttributes(array('status_hidden'=>1));
                if($data_review_xs)
                {
                    foreach ($data_review_xs as $item_xs) 
                    {
            ?>
                    <div class="item">
                        <a>
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/review/lg/<?php echo $item_xs['r_img']; ?>" style="margin:20px 30% 0px 30%; width: 40%;" />
                        </a>
                        <div class="info_name_job">
                            <p style="margin-bottom: 0px; margin-top: 20px; text-align: center;">
                                <?php 
                                    if($lang=='vi'){
                                        echo $item_xs['r_name'];
                                    }else{

                                        if($item_xs['name_en']==''){
                                         echo $item_xs['r_name'];
                                        }else{
                                            echo $item_xs['name_en'];
                                        }
                                    }
                                ?>
                            </p>
                        </div>
                        <div style="margin-top: 10px;" class="text_active">
                            <p style="text-align: left;"><img style="width: 3%" src="<?php echo Yii::app()->params['image_url']; ?>/images/iconhome/ngoac-mo.png" alt="ngoac-mo"/></p>
                            <div style="font-size: 14px;padding: 0px 10px;">
                                <?php 
                                    if($lang=='vi'){
                                        echo $item_xs['r_content'];
                                    }else{
                                        echo $item_xs['content_en'];
                                    } 
                                ?>
                            </div>
                            <p style="text-align: right;"><img style="width: 3%" src="<?php echo Yii::app()->params['image_url']; ?>/images/iconhome/ngoac-dong.png" alt="ngoac-dong"/></p>
                        </div>
                    </div>
            <?php 
                    }
                }
            ?>
        </div>
    </div>
</div>
<!--  visible-xs"-->
<div class="visible-xs" id ="info">
    <div class="container">
        <div id="owl_infor_xs" class="owl-carousel">
            <?php
                $data_review_xs = PReviewCustomer::model()->findAllByAttributes(array('status_hidden'=>1));
                if($data_review_xs)
                {
                    foreach ($data_review_xs as $item_xs) 
                    {
            ?>
                    <div class="item">
                        <a>
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/review/lg/<?php echo $item_xs['r_img']; ?>" style="margin:20px 30% 0px 30%; width: 40%;" />
                        </a>
                        <div class="info_name_job">
                            <p style="margin-bottom: 0px; margin-top: 10px; text-align: center;"><?php echo $item_xs['r_name']; ?></p>
                        </div>
                        <div style="margin-top: 10px;" class="text_active">
                            <p style="text-align: left;"><img style="width: 3%" src="<?php echo Yii::app()->params['image_url']; ?>/images/iconhome/ngoac-mo.png" alt="ngoac-mo" /></p>
                            <div style="font-size: 14px;padding: 0px 10px;">
                                <?php 
                                    if($lang=='vi'){
                                        echo $item_xs['r_content']; 
                                    }else{
                                         echo $item_xs['content_en']; 
                                    }
                                ?>
                            </div>
                            <p style="text-align: right;"><img style="width: 3%" src="<?php echo Yii::app()->params['image_url']; ?>/images/iconhome/ngoac-dong.png" alt="ngoac-mo"/></p>
                        </div>
                    </div>
            <?php 
                    }
                }
            ?>
        </div>
    </div>
</div>


<!-- CHI NHANH NHA KHOA 2000 -->
<div  class="contentwrap" id="nhakhoa">
	<div class="container">
		<div class="row">
			<h2 class="text_green"><?php echo Yii::t('translate','nhakhoa2000'); ?></h2>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-6">
						<ul class="list-unstyled" id="time">
							<li><p><b><?php echo Yii::t('translate','monday_saturday'); ?>:</b></p>
								<ul class="list-unstyled" id="t27">
                                <?php if($lang=='vi'){?>
									<li><p>Sáng: 8h đến 12h</p></li>
									<li><p>Chiều: 13h30 đến 20h</p></li>
                                <?php }else{?>
                                    <li><p>Morning: 8 am to 12 am</p></li>
                                    <li><p>Afternoon: 1:30 pm to 08:00 pm</p></li>
                                <?php }?>
								</ul>
							</li>
							<li><p><?php echo Yii::t('translate','sunday_holiday'); ?></p></li>
						</ul>
						<img src="<?php echo Yii::app()->params['image_url']; ?>/images/olock.png" alt="olock" id="clock">	
					</div>
					<div class="col-sm-6" id="branch">
						<h3><?php echo Yii::t('translate','all_branch'); ?></h3>
                        <?php 
                        $branch = Branch::model()->findAllByAttributes(array('status'=>1)); 
                        if(count($branch) > 0){
                            foreach ($branch as $key => $value) {
                                if($lang=='vi'){
                        ?>
    						<div id="br<?php echo $key+1; ?>">
    							<span style="color: #333"><b><?php echo $value['name']; ?>:</b></span>
    							<span><?php echo $value['address']; ?></span>
    							<span>ĐT: <?php echo $value['hotline1']; ?> - <?php echo $value['hotline2']; ?></span>
    						</div>
                            <?php }else{?>
                            <div id="br<?php echo $key+1; ?>">
                                <span style="color: #333"><b><?php echo $value['name_en']; ?>:</b></span>
                                <span><?php echo $value['address_en']; ?></span>
                                <span>Phone: <?php echo $value['hotline1']; ?> - <?php echo $value['hotline2']; ?></span>
                            </div>
                        <?php } } } ?>			
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- đối tác-->
<div class="partner" style="background: #F4F4F4; padding: 15px 0px; ">
    <div class="container">
        <div class="row">   
            <div id="owl_partner" class="owl-carousel" >
            <?php $img_partner = PImages::model()->findAllByAttributes(array('id_type'=>8)); 
                if($img_partner):
                    foreach ($img_partner as $key => $logo_partner):          
            ?>
                        <div class="item_partner">
                             <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/images/lg/<?php echo $logo_partner['name_upload']; ?>" alt="logo_partner_<?php echo $logo_partner['name']; ?>" class="img-responsive">
                        </div>
                       
                    <?php  endforeach; ?>
                            
            <?php  endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- GOOGLE MAP -->
<div id="map_wrapper" style="height:400px">
    <div id="map_canvas" class="mapping" style="height:400px"></div>
</div> 

<!-- DAT LICH && FACEBOOK  -->


<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.parallaxscrolling.js"></script>
<script>
   $(document).ready(function(){

        $.parallax({
            speed: .95
        });
    });

$(document).ready(function() {
      var owl = $("#owl_infor");
      owl.owlCarousel({
          // autoPlay: 3000,
          items : 1, 
          itemsDesktop : [1000,1], 
          itemsDesktopSmall : [900,1], 
          itemsTablet: [600,1], 
          itemsMobile : [400,1] 
      });

      var owl = $("#owl_infor_xs");
      owl.owlCarousel({
          autoPlay: 3000,
          items : 1, 
          itemsDesktop : [1000,1], 
          itemsDesktopSmall : [900,1], 
          itemsTablet: [600,1], 
          itemsMobile : [400,1] 
      });

      var owl = $("#owl_partner");
      owl.owlCarousel({
          autoPlay: 3000,
          items :6, 
          itemsDesktop : [1000,5], 
          itemsDesktopSmall : [900,4], 
          itemsTablet: [600,3], 
          itemsMobile : [400,1] 
      });
});
</script>

<script>
var current = 1;
var numIMG = $('#numIMG').val();

function switchImage(){
  current++;
  $.ajax({
    type :"POST",
    url  :"<?php echo CController::createUrl('home/SearchAvatar') ?>",
    data : {
          "current"     : current,
    },
    success : function(data)
    { 
        // Thay thế hình
        document.images['myimage'].src ='<?php echo Yii::app()->baseUrl?>/upload/images/lg/'+data;
    },
  });
  
  // Gọi lại hàm nếu thõa đk
  if(current == numIMG){current =0;}
	setTimeout("switchImage()", 8000);
}

$(document).ready(function(){
    		
		switchImage();

    	var next=document.getElementById('next');

    	$('#next').mouseleave(function(){
        	next.src="<?php echo Yii::app()->baseUrl?>/images/iconhome/lui-rv-def.png";
	    });

	    $('#next').mousemove(function(){
	        next.src="<?php echo Yii::app()->baseUrl?>/images/iconFAQ/lui-rv-act.png";
	    });

	    var prev=document.getElementById('prev');

    	$('#prev').mouseleave(function(){
        	prev.src="<?php echo Yii::app()->baseUrl?>/images/iconhome/toi-rv-def.png";
	    });

	    $('#prev').mousemove(function(){
	        prev.src="<?php echo Yii::app()->baseUrl?>/images/iconFAQ/toi-rv-act.png";
	    });

        $("#mySlider1").AnimatedSlider( { prevButton: "#btn_prev1", 
                                         nextButton: "#btn_next1",
                                         visibleItems: 3,
                                         infiniteScroll: true,
                                         willChangeCallback: function(obj, item) { $("#statusText").text("Will change to " + item); },
                                         changedCallback: function(obj, item) { $("#statusText").text("Changed to " + item); }
        });
        
});

window.onload = initialize;


$(document).ready(function() {
   var owl = $("#owl-banner");
   $("#owl-banner").owlCarousel({
     autoPlay:true,
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true
   });
   $(".next").click(function(){
      owl.trigger('owl.next');
    })
    $(".prev").click(function(){
      owl.trigger('owl.prev');
    })
 
});
</script>