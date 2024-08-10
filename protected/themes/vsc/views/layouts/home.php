<!DOCTYPE html>
<html lang="vi">
<?php $baseUrl = Yii::app()->getBaseUrl(true);  ?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="language" content="vi">
		<meta name="author" content="BookOke Co.Ltd"/>
		<?php
			if (!empty($this->pageOgTitles))
			{
			  echo '<meta property="og:title" content="' . $this->pageOgTitles . '" />';
			} 
			if (!empty($this->pageOgImg))
			{
			  echo '<meta property="og:image" content="' . $this->pageOgImg . '" />';
			} 
			if (!empty($this->pageOgDes))
			{
			  echo '<meta property="og:description" content="' . $this->pageOgDes . '" />';
			} 
		?>

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>

		<!--Meta Seo website-->
		<?php Yii::app()->controller->widget('ext.seo.widgets.SeoHead',
	        array(
	        	'defaultKeywords'    => "Nha Khoa 2000, Kĩ thuật Nha Khoa , Nha Khoa Hiện Đại, Cơ sở vật chất Nha Khoa , Nha Khoa Nhi, Chăm Sóc Răng Miệng, Sản Phẩm Nha Khoa,...",
	            'defaultDescription' => "Nha Khoa 2000 - You Smile , We Smile",  
	        )
    	); ?>

	  	
	  	<!-- main.css -->
		<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/home.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/animate.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/font-awesome/css/font-awesome.min.css">
		<link rel="shortcut icon" href="<?php echo $baseUrl; ?>/images/Logo-NK-2000.png"/>


		<?php //Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

		<!-- Add mousewheel plugin (this is optional) -->
		<script src="<?php echo $baseUrl; ?>/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
		<!-- Add fancyBox -->
		<link rel="stylesheet" href="<?php echo $baseUrl; ?>/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
		<script src="<?php echo $baseUrl; ?>/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
		<!-- Optionally add helpers - button, thumbnail and/or media -->
		<link rel="stylesheet" href="<?php echo $baseUrl; ?>/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
		<script  src="<?php echo $baseUrl; ?>/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
		<script  src="<?php echo $baseUrl; ?>/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
		<link rel="stylesheet" href="<?php echo $baseUrl; ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
		<script  src="<?php echo $baseUrl; ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
		<script  src="<?php echo $baseUrl; ?>/js/wow.min.js"></script>
		<script src="<?php echo $baseUrl; ?>/js/jquery.elevatezoom.js"></script>
		<script src="<?php echo $baseUrl; ?>/js/jssor.slider-21.1.6.min.js" ></script>
		<!-- bxSlider Javascript file -->
		<script src="<?php echo $baseUrl; ?>/js/jquery.bxslider.js"></script>
		<!-- bxSlider CSS file -->
		<link href="<?php echo $baseUrl; ?>/css/jquery.bxslider.css" rel="stylesheet" />
		<!-- momentjs -->
		<script src="<?php echo $baseUrl; ?>/js/moment-with-locales.js" ></script>
		<!-- autonumber -->
		<script src="<?php echo $baseUrl; ?>/js/autoNumeric.js" ></script>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-114690625-1"></script>
		<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());
			  gtag('config', 'UA-114690625-1');
		</script>
		<!-- Global site tag (gtag.js) - AdWords: 815388581 -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=AW-815388581"></script>
		<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());
			  gtag('config', 'AW-815388581');
		</script>
		<!-- Facebook Pixel Code -->
		<script>
		  !function(f,b,e,v,n,t,s)
		  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		  n.queue=[];t=b.createElement(e);t.async=!0;
		  t.src=v;s=b.getElementsByTagName(e)[0];
		  s.parentNode.insertBefore(t,s)}(window, document,'script',
		  'https://connect.facebook.net/en_US/fbevents.js');
		  fbq('init', '282336759173160');
		  fbq('track', 'PageView');
		</script>
		<noscript><img height="1" width="1" style="display:none"
		  src="https://www.facebook.com/tr?id=282336759173160&ev=PageView&noscript=1"
		/></noscript>
		<!-- End Facebook Pixel Code -->

		
		<style>

			body {
			padding-right:0px !important;
			margin-right:0px !important;
			}
			.dropdown {
			    position: relative !important;
			    display: inline-block;
			}

			.dropdown-content {
			    display: none;
			    position: absolute;
			    background-color: #FFF;
			    /*min-width: 200px;*/
				z-index:1;
				width: 200px;
				color:#000;
				/*text-align:left;*/
				
			}
			.dropdown:hover .dropdown-content {
			    display: block;
			}
			.dropdown-content ul{
				/*background-color: #ffffff !important;*/
				padding: 0px !important;

			}
			.dropdown-content ul li{
				background-color: #ffffff !important;
				float: left !important;
			}

			.dropdown-content ul li a{
				color: #919190 !important;
				float: left;
				padding: 10px 0px !important;
				background-color: #ffffff !important;
			}
			ul.menu-footer{	
				list-style: none inside;
				margin-bottom: 0px;
				padding: 5px 0px;
			}
			ul.menu-footer li{
				display: inline-block;
				padding: 0px 10px;
			}
			ul.menu-footer li a{
				color: #ffffff;
			}

			/*  .active{
			  color: #a11c4a !important;
			}*/
			@keyframes mybounce {
				0%, 20%, 50%, 80%, 100% {
			    transform:translateY(0);
			  }
				40% {
			    transform:translateY(-30px);
			  }
				60% {
			    transform:translateY(-15px);
			  }
			}
			.mybounce {
			  animation :mybounce 3s infinite;
			}
			#cart{
				float: right !important;
			    width: 40px;
			    height: auto;
			    padding: 0;
			    cursor: pointer;
			    position: relative;
			    font-size: 14px;
			}
			.counter{
				color: #FFFFFF !important;
			    text-align: center;
			    overflow: hidden;
			    text-overflow: ellipsis;
			    white-space: nowrap;
			    font-weight: normal!important;
			    position: absolute;
			    right: 0px;
			    top: 0px;
			    width: 25px;
			    height: 16px;
			    line-height: 16px;
			    font-size: 11px;
			    padding: 0 3px;
			}
			.nav-section .dropdown-menu{padding:0 15px !important;}
			.nav-section .dropdown-menu li{ float: left !important;background: #fff !important; color: #333!important; width: 100%; border-bottom: 1px solid #ccc; text-align: left !important; padding: 0;}
			.nav-section .dropdown-menu li a{background: #fff !important; color: #333!important;padding: 10px!important; text-transform: none !important;}
			.nav-section .dropdown-submenu {position:relative;}
			.nav-section .dropdown-submenu>.dropdown-menu {top:0;left:105%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:6px 6px 6px 6px; }  
			.nav-section .dropdown-menu > li > a:hover, .dropdown-menu > .active > a:hover {text-decoration: none;color: rgb(25, 168, 224) !important;}  
			@media (min-width: 768px) { 
				ul.nav li:hover > ul.dropdown-menu {display: block;}
			}
			.nav-section .arr-menu{width: 10px !important;float: left;margin-right: 5px;margin-top: 5px;}
			/*.nav-section .dropdown-submenu .dropdown-menu li a{color: rgb(25, 168, 224) !important;}*/
		</style>
</head>
<body>
<?php 	
$baseUrl = Yii::app()->getBaseUrl(true); 
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

<!-- HEAD -->
<div id="call" style="background-color: #94c640; height: 45px; width:240px;display:block; position: fixed;right: -190px; top: 120px; border-top-left-radius: 25px; border-bottom-left-radius: 25px ;">
	<img src="<?php echo $baseUrl; ?>/images/call-24.png" alt="call-nhakhoa2000" style="width: 38px;margin-top: 5.5px;margin-left: 7px;">
	<div style=" color: #fff;position: absolute;top:0px;left: 60px;font-size: 13px;"><b>Worldwide</b> (+1) 714 587 2789</div>
  <div style="color: #ffffff; position: absolute;top:18px;left: 60px;font-size: 13px"><b>Việt Nam</b> 1900 7799 20</div>
</div>
<div style="position: fixed;top: 175px;right: -5px;z-index: 999;cursor: pointer;">
	<a href="https://www.facebook.com/nhakhoa2000">
	<img src="<?php echo $baseUrl; ?>/images/link_fb.png" alt="link-fb-nhakhoa2000" style="width: 45px;">
	</a>
</div>
	<div id="header">
		<div class="container-fluid">
			<div class="row">
				<!-- LOGO-->
				<div class="col-xs-3 hidden-xs col-sm-3 col-md-3 margin-top-10 padding-default">
					<a href="<?php echo $baseUrl; ?>/index.php/"><img src="<?php echo $baseUrl; ?>/images/logo_nhakhoa2000.png" alt="Logo nhakhoa2000" style=" width: 65%;margin: 0px auto; max-width: 230px" class="img-responsive"></a>
				</div> 
				
				<!-- SETTING INFO -->
				<div class="col-xs-8 hidden-xs col-sm-9 col-md-9 margin-top-10 padding-default">
					<div  id="head">
						<ul class="list-inline">
							<li class="mybounce"><a href="<?php echo $baseUrl; ?>/book/index" class="btn_book"><?php echo Yii::t('translate','booking'); ?></a></li>

							<li style="margin-right: 20px;">
								<ul class="list-inline" id="log">
								<?php if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false) { ?>
									<li><a id="name_customer" href="<?php echo $baseUrl; ?>/profile">Hi, <?php echo yii::app()->user->getState('customer_name'); ?></a></li>
									<li><a  href="<?php echo $baseUrl; ?>/home/logout"><?php echo Yii::t('translate','logout'); ?></a></li>	
								<?php }else{ ?>
									<li>  <?php if ($lang == 'vi') { ?>
			                              <a href="<?php echo $baseUrl; ?>/dang-ky/"  >
			                           <?php }else if($lang == 'en'){ ?>
			                              <a href="<?php echo $baseUrl; ?>/register/"  >
			                           <?php } ?>
			                           <?php echo Yii::t('translate','register'); ?> </a>
				                    </li>

									<li><a href="#" data-toggle="modal" data-target="#login-customer-modal"><?php echo Yii::t('translate','login') ?></a></li>
								<?php } ?>
									<li>
										<div id="cart" data-toggle="modalCart" >
											<img src="<?php echo $baseUrl; ?>/images/iconhome/cart-icon.png" alt="cart-nhakhoa2000" style=" width: 90%;margin: 0px auto;" class="img-responsive">
						                    <span class="counter"><?php echo count(Yii::app()->session['cart']);?></span>
						                </div>
									</li>
								</ul>
							</li>
							<li>	
								<div class="" style="padding-left: 0px;padding-right: 0px">
									<select name="language" class="language-site">
									<?php $val = array('vi' => 'Tiếng Việt', 'en'=>'English'); 
										foreach ($val as $key => $value) {
											echo "<option value='$key'";
											if ($lang == $key) {
												echo " selected='selected'";
											}
											echo ">$value</option>";
										}
									?>
								</select>
								</div>
							</li>
							
						</ul>
					</div>
				</div> 

				<!-- MENU -->
				<div class="col-xs-12 col-sm-12 col-md-9 margin-top-10 padding-default  nav-section">
					<nav class="navbar navbar-default box_menu">
						<div class="navbar-header">
						    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						    	<span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>                        
						    </button>
						     <div class="visible-xs" style="float: right;margin-right: 10px;margin-top: 5px;">
						    	<a style="font-size: 12px;padding: 8px 12px;" href="<?php echo $baseUrl; ?>/book/index" class="btn_book"><?php echo Yii::t('translate','booking'); ?></a>
						    </div>
						    <div class="logo-mobile hidden-sm hidden-md hidden-lg">
									<a href="<?php echo $baseUrl; ?>/index.php/"><img src="<?php echo $baseUrl; ?>/images/logo_nhakhoa2000.png" alt="Logo Nha khoa 2000" class="img-responsive"></a>
							</div>
							<div class="clear"></div>
						</div>

						<!-- <div class="collapse navbar-collapse " id="myNavbar"> -->
						<div class="collapse navbar-collapse" data-hover="dropdown" data-animations="fadeInDown fadeInRight fadeInUp fadeInLeft" id="myNavbar">
							<ul id="menu" class="nav navbar-nav"> 
			                    <li class="hidden-sm hidden-md hidden-lg">  
			                   	<?php if ($lang == 'vi') { ?>
		                              <a href="<?php echo $baseUrl; ?>/trang-chu/" <?php if ($controller == 'home') echo 'class="menu-active"'; ?> >
		                           <?php }else if($lang == 'en'){ ?>
		                              <a href="<?php echo $baseUrl; ?>/home/" <?php if ($controller == 'home') echo 'class="menu-active"'; ?> >
		                           <?php } ?>
		                           <?php echo Yii::t('translate','home'); ?> </a>
			                    </li>

			                    <li>  <?php if ($lang == 'vi') { ?>
		                              <a style="padding-right: 30px;" href="<?php echo $baseUrl; ?>/contact/" <?php if ($controller == 'contact') echo 'class="menu-active"'; ?> >
		                           <?php }else if($lang == 'en'){ ?>
		                              <a style="padding-right: 30px;" href="<?php echo $baseUrl; ?>/contact/" <?php if ($controller == 'contact') echo 'class="menu-active"'; ?> >
		                           <?php } ?>
		                           <?php echo Yii::t('translate','contact'); ?> </a>
			                    </li>
			                  	<li>
			                  		<?php if ($lang == 'vi') { ?>
				                  		<a href="<?php echo $baseUrl; ?>/hoi-dap" <?php if ($controller == 'faq') echo 'class="menu-active"'; ?>>
				                  			<?php echo Yii::t('translate','faq'); ?>		
				                  		</a>
			                  		<?php }else if($lang == 'en'){ ?>
			                  			<a href="<?php echo $baseUrl; ?>/faq" <?php if ($controller == 'faq') echo 'class="menu-active"'; ?>>
				                  			<?php echo Yii::t('translate','faq'); ?>		
				                  		</a>
			                  		 <?php } ?>
			                  	</li>
			                    <li>  
			                    	<?php if ($lang == 'vi') { ?>
		                              <a href="<?php echo $baseUrl; ?>/tin-tuc/" <?php if ($controller == 'news') echo 'class="menu-active"'; ?> >
		                            <?php }else if($lang == 'en'){ ?>
		                              <a href="<?php echo $baseUrl; ?>/news/" <?php if ($controller == 'news') echo 'class="menu-active"'; ?> >
		                            <?php } ?>
		                            <?php echo Yii::t('translate','news'); ?> </a>
			                    </li>
			                    <li>  <?php if ($lang == 'vi') { ?>
					                  <a href="<?php echo $baseUrl; ?>/khuyen-mai" <?php if ($controller == 'promotion') echo 'class="menu-active"'; ?>>
					               <?php }else if($lang == 'en'){ ?>
					                  <a href="<?php echo $baseUrl; ?>/promotion" <?php if ($controller == 'promotion') echo 'class="menu-active"'; ?>>
					               <?php } ?>
					               <?php echo Yii::t('translate','promotion'); ?> </a>
					            </li>
					          
					            <li>  <?php if ($lang == 'vi') { ?>
					                  <a href="<?php echo $baseUrl; ?>/career" <?php if ($controller == 'career') echo 'class="menu-active"'; ?>>
					               <?php }else if($lang == 'en'){ ?>
					                  <a href="<?php echo $baseUrl; ?>/career" <?php if ($controller == 'career') echo 'class="menu-active"'; ?>>
					               <?php } ?>
					               <?php echo Yii::t('translate','job'); ?> </a>
					            </li>
			                    <li>  <?php if ($lang == 'vi') { ?>
		                              <a href="<?php echo $baseUrl; ?>/san-pham" <?php if ($controller == 'shopping') echo 'class="menu-active"'; ?> >
		                           <?php }else if($lang == 'en'){ ?>
		                              <a href="<?php echo $baseUrl; ?>/product" <?php if ($controller == 'shopping') echo 'class="menu-active"'; ?> >
		                           <?php } ?>
		                           <?php echo Yii::t('translate','product'); ?> </a>
			                    </li>

			                    <li class="dropdown">
			                    	<?php if ($lang == 'en') { ?>
				                      	<a href="<?php echo $baseUrl; ?>/services" class="dropdown-toggle">
				                      		<?php echo Yii::t('translate','service'); ?>
				                      	</a> 
				                    <?php }else if($lang == 'vi'){ ?>
										<a href="<?php echo $baseUrl; ?>/dich-vu" class="dropdown-toggle">
				                      		<?php echo Yii::t('translate','service'); ?>
				                      	</a>
				                    <?php } ?>
			                        <ul class="dropdown-menu">
			                        	<?php 
			                        		$serviceType= ServiceType::model()->getListServiceType();
			                        		foreach ($serviceType as $key => $type) :
			                        			$service = ServiceType::model()->getListServiceOfType($type['id']);
			                        			$str =ServiceType::model()->convert_vi_to_en($type['name']);

			                        	?>
				                            <li class="<?php if($service){ echo "dropdown dropdown-submenu" ;} ?>">
				                            	<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu/<?php echo $str; ?>-<?php echo $type['id']; ?>/lang/<?php echo $lang;?>" <?php if($service){ echo "class='dropdown-toggle'" ;} ?>>
				                            		<img src="<?php echo $baseUrl; ?>/images/right-arrows.png" alt="" class="arr-menu">
					                            	<?php
						                            	if($lang=='en'){
						                            		echo $type['name_en'];
						                            	}else if($lang == 'vi'){
						                            		echo $type['name'];
						                            	}
					                            	?>
					                            </a>
					                            <?php if($service): ?>
					                            	<ul class="dropdown-menu">
						                            	<?php 
						                            		foreach ($service as $key => $s) : 
						                            			$str_s =ServiceType::model()->convert_vi_to_en($s['name']);
						                            	?>	
						                                    <li>
						                                    	<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu-chi-tiet/<?php echo $str_s; ?>-<?php echo $s['id']; ?>/lang/<?php echo $lang;?>">
						                                    		<img src="<?php echo $baseUrl; ?>/images/right-arrows.png" alt="" class="arr-menu">
						                                    		<?php
										                            	if($lang=='en'){
										                            		echo $s['name_en'];
										                            	}else if($lang == 'vi'){
										                            		echo $s['name'];
										                            	}
									                            	?>
						                                    	</a>
						                                    </li>  
						                                <?php endforeach; ?>                     
													</ul>
					                            <?php endif; ?>
				                            </li>
			                       		<?php endforeach; ?>                
			                        </ul>
			                    </li>
			                    <li>  
			                    	<?php if ($lang == 'vi') { ?>
		                              <a href="<?php echo $baseUrl; ?>/gioi-thieu" <?php if ($controller == 'introduce') echo 'class="menu-active"'; ?> >
		                            <?php }else if($lang == 'en'){ ?>
		                              <a href="<?php echo $baseUrl; ?>/introduce" <?php if ($controller == 'introduce') echo 'class="menu-active"'; ?> >
		                            <?php } ?>
		                            <?php echo Yii::t('translate','introduce'); ?> </a>
			                    </li>

			                    <?php if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false) { ?>
									<li class="hidden-sm hidden-md hidden-lg">
										<a id="name_customer" href="<?php echo $baseUrl; ?>/profile">Hi, <?php echo yii::app()->user->getState('customer_name'); ?></a>
										<a href="<?php echo $baseUrl; ?>/home/logout"><?php echo Yii::t('translate','logout'); ?></a>
									</li>
								<?php }?>
							 	<li id="box_w" class="hidden-xs"></li>	
							</ul>
				    	</div>
					</nav>
				</div> 
			</div>
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="content" id="body_content">
		<?php echo $content; ?>
	</div>
	<!-- <hr style="margin-bottom: 0px"> -->
	<div class="clearfix"></div>
	<div id="footer" class="col-xs-12">
		<div class="col-xs-12 col-sm-6 text_footer" style="padding: 5px 0px;">Nha Khoa 2000  &copy; 2017. Privacy Policy</div>
		<div class="col-xs-12 col-sm-6" style="padding: 0px;">
			<ul class="menu-footer text_footer">
	          
			</ul>
		</div
	</div>
	<div class="clearfix"></div>
</div>
<!-- LOGIN MODAL -->
<div class="modal fade" id="login-customer-modal" role="dialog" >

</div>
<!--Forget password -->
<div class="modal fade" id="forget-pass" role="dialog" >
	
</div>
<!-- Modal HTML -->
<div id="VideoModal" class="modal fade">
    <div class="modal-dialog padding-top-video">
        <div class="modal-content">
            <div class="modal-body">
               	<div id="iframeVideo" style="width:100%;height:auto;min-height:300px;"></div>
            </div>
        </div>
    </div>
</div>

<script >
			$(document).ready(function(){
				
				$('.language-site').change(function(){
					var lang = $(this).val();
					var baseUrl = <?php echo json_encode($baseUrl); ?>;
					var controller = <?php echo json_encode($controller); ?>;
					var action = <?php echo json_encode($action); ?>;
					if(action == 'index'|| action =='cart' || action =='register_info'){
				      var link = baseUrl+'/'+controller+'/'+action+'/lang/'+lang+'/';
				      window.location.href = link;
				    }else{
				      var string = window.location.pathname;
				      path = string.substring(0, string.length -8);
				      window.location.href =  path+"/"+"lang/"+lang;
				    }
				});

				if($('#login-customer-modal div').length == 0){
					if($("#name_customer").length > 0){
						return false;
					}else{
						jQuery.ajax({ type:"POST",
						    url:"<?php echo CController::createUrl('home/login')?>",
						    datatype:'json',
						    success:function(data){
						        if(data){
						            $("#login-customer-modal").html(data);
						        }
						    },
						    error: function(data) {
						        alert("Error occured.Please try again!");
						    },
						    cache: false,
						    contentType: false,
						    processData: false
						});

					}
					
				}
				if ($('#forget-pass div').length==0) {
					if ($('#login-customer-modal').length < 0) {
						return false;
					}else {
						jQuery.ajax({ type:"POST",
						    url:"<?php echo CController::createUrl('home/forgetpass')?>",
						    datatype:'json',
						    success:function(data){
						        if(data){
						            $("#forget-pass").html(data);
						        }
						    },
						    error: function(data) {
						        alert("Error occured.Please try again!");
						    },
						    cache: false,
						    contentType: false,
						    processData: false
						});
					}
				}

				new WOW().init();

				$("#call").hover(function(){
					$(this).animate({ right: "0px" });}, 
					function() {
					$(this).animate({ right: "-195px" });
				});

			});
		</script>
<script>
	$(document).ready(function(){
		<?php if(isset($_SESSION['activation'])){ ?>
		alert("Tài khoản của bạn đã khôi phục! Vui lòng thay đổi mật khẩu mới ngay!");
		<?php unset($_SESSION['activation']);}?>
		<?php if(isset($_SESSION['activated'])){ ?>
		alert("Mật khẩu đã được thay đổi!");
		<?php unset($_SESSION['activated']);}?> 
		<?php if(isset($_SESSION['error_activated'])){ ?>
		  alert("Lỗi xác nhận!");
		<?php unset($_SESSION['error_activated']);}?>
	});
	function email()
	{
		var reg_mail = /^[A-Za-z0-9]+([_\.\-]?[A-Za-z0-9])*@[A-Za-z0-9]+([\.\-]?[A-Za-z0-9]+)*(\.[A-Za-z]+)+$/;
		var email = $('#send_email').val();
		if(email=="")
		{
			alert("Vui lòng nhập email!");
			document.forms['form_email'].send_email.focus();
		}
		else if(reg_mail.test(email)==false)
		{
			alert("Email này không hợp lệ! vui lòng nhập lại");
			document.forms['form_email'].send_email.focus();
		}
		else{
			$.ajax({
				type : "POST",
				url  : "<?php echo CController::createUrl('home/sendemail') ?>",
				data : {
					  "email"     : email,
				},
				success : function(data)
				{
					alert(data);
				},
				complete : function()
				{
					$('#send_email').val("");
				}
			});
		}
	}

	$('#cart').click(function(){
		<?php  if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false) { ?>
		  	window.location.href = '<?php echo CController::createUrl("detailproduct/cart");?>';
		<?php  }else{ ?>
		  	$("#login-customer-modal").modal({backdrop: true});
		<?php  } ?>
	});
</script>
<script>

var a = $("#menu").offset().top;

$(document).scroll(function(){
		if($(this).scrollTop() > a){   
			$('#menu li a').css({"background-color":"#FFF"});
			$('#menu li ').css({"background-color":"#FFF"});
			$('#menu li a').css({"color":"#2d2d2d"});
			$('#menu .menu-active').css({'box-shadow':" inset 0px -3px 0px  rgb(25, 168, 224)"});
			$('#header').css({"position":"fixed"});
			
		}else{
			
			$('#menu li ').css({"background-color":"rgb(25, 168, 224)"});
			$('#menu li a').css({"background-color":"#19a8e0"});
			$('#menu li a').css({"color":"white"});
			$('#menu .menu-active').css({'box-shadow':"inset 0px -3px 0px #FFF"});
			$('#header').css({"position":"relative"});
		}
});
$(".nav-section .dropdown-menu li a").hover(function(){
    $(this).find(".arr-menu").attr('src', '<?php echo Yii::app()->request->baseUrl ?>/images/right-arrows-act.png');
},function(){
    $(this).find(".arr-menu").attr('src', '<?php echo Yii::app()->request->baseUrl ?>/images/right-arrows.png');
});

</script>


</body>
</html>