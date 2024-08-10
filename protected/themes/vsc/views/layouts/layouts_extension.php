<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="<?php echo Yii::app()->params['image_url']; ?>/images/Logo-NK-2000.png"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <?php
    $cs  = Yii::app()->getClientScript();
    $cs->registerCssFile(Yii::app()->baseUrl.'/css/font-awesome/css/font-awesome.min.css'); 
    $cs->registerCssFile(Yii::app()->baseUrl.'/css/admin/tab.css');
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    ?>
    <script src='<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2.full.min.js'></script>
   
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/moment.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/autoNumeric.js" type="text/javascript"></script>
</head>
<body>

	<style>
	.btn {border-radius: 0;}

		/* button */
	.btn:hover {
		color: white;
	}
	.btn_bookoke{
		background: #7cc9ac;
		color: white;
	}
	.btn_bookoke:hover {
		background: #48b64e !important;
		color: white;
	}
	.btn_unactive, .btn_cancel {
		background: #c0bfbf;
		color: white;
	}
	.btn_unactive {
		cursor: not-allowed !important;
	}
	
	.cal-loading {
		  position: fixed;
		  left: 0px;
		  top: 0px;
		  width: 100%;
		  height: 100%;
		  z-index: 9999;
		  background: url('../../images/icon_sb_left/loading.gif') 50% 40% no-repeat rgba(221,221,221,0.5);
		  background-size: 5% auto;
	 }
		#mn_nav .navbar {border: 0; background: #2e363e; border-radius: 0;}
		#mn_nav ul.menuMain li a {color: #737271; padding-bottom: 13px; font-size: 14px;text-transform: capitalize;}
		#mn_nav ul.menuMain  li a:hover {color: #10b1dd;}
		#mn_ad ul.menuMain  li {margin-right: 5px;}
		#mn_nav .navbar-default .navbar-nav>.open>a, #mn_nav .navbar-default .navbar-nav>.open>a:focus, #mn_nav .navbar-default .navbar-nav>.open>a:hover {background: transparent; color: #10b1dd;}

		#mn_nav  #headerMenu .dropdown-menu {right: 0; left:auto;  border-radius: 0;color: white;}

		#mn_nav #headerMenu .dropdown-menu li a {color: white;}
		ul.nav li.dropdown:hover > ul.dropdown-menu {display: block;}
		#mn_nav #headerMenu .dropdown-menu>li>a:focus, #mn_nav #headerMenu .dropdown-menu>li>a:hover {background: #94c63f; color: white;}

		#mn_nav #mn_ad .dropdown-menu {background: #fff;}
		#mn_nav #mn_ad .dropdown-menu>li>a {color: black;}

		#mn_ad .dropdown-menu, #mn_ad .dropdown-menu>li>a:focus,#mn_ad .dropdown-menu>li>a:hover {background: #e6e6e5;color: black;}
		
		#mn_nav ul.menuMain li .active {color: #10b1dd;}


		#mn_ad .dropdown-menu>li>a:focus,
		#mn_ad .dropdown-menu>li>a:hover {
		    color: #10b1dd;
		    text-decoration: none;
		    background-color: #fff;
		}

		.dropdown-multi {
		    width: 415px;
		}
		/* custom inclusion of right, left and below tabs */

		.tabs-below > .nav-tabs,
		.tabs-right > .nav-tabs,
		.tabs-left > .nav-tabs {
		  border-bottom: 0;
		}

		.tab-content > .tab-pane,
		.pill-content > .pill-pane {
		  display: none;
		}

		.tab-content > .active,
		.pill-content > .active {
		  display: block;
		}

		.tabs-below > .nav-tabs {
		  border-top: 1px solid #ddd;
		}

		.tabs-below > .nav-tabs > li {
		  margin-top: -1px;
		  margin-bottom: 0;
		}

		.tabs-below > .nav-tabs > li > a {
		  -webkit-border-radius: 0 0 4px 4px;
		     -moz-border-radius: 0 0 4px 4px;
		          border-radius: 0 0 4px 4px;
		}

		.tabs-below > .nav-tabs > li > a:hover,
		.tabs-below > .nav-tabs > li > a:focus {
		  border-top-color: #ddd;
		  border-bottom-color: transparent;
		}

		.tabs-below > .nav-tabs > .active > a,
		.tabs-below > .nav-tabs > .active > a:hover,
		.tabs-below > .nav-tabs > .active > a:focus {
		  border-color: transparent #ddd #ddd #ddd;
		}

		.tabs-left > .nav-tabs > li,
		.tabs-right > .nav-tabs > li {
		  float: none;
		}

		.tabs-left > .nav-tabs > li > a,
		.tabs-right > .nav-tabs > li > a {
		  min-width: 74px;
		  margin-right: 0;
		  margin-bottom: 3px;
		}

		.tabs-left > .nav-tabs {
		  float: left;
		  margin-right: 19px;
		  border-right: 1px solid #ddd;
		}

		.tabs-left > .nav-tabs > li > a {
		  margin-right: -1px;
		  -webkit-border-radius: 4px 0 0 4px;
		     -moz-border-radius: 4px 0 0 4px;
		          border-radius: 4px 0 0 4px;
		}

		.tabs-left > .nav-tabs > li > a:hover,
		.tabs-left > .nav-tabs > li > a:focus {
		  border-color: #eeeeee #dddddd #eeeeee #eeeeee;
		}

		.tabs-left > .nav-tabs .active > a,
		.tabs-left > .nav-tabs .active > a:hover,
		.tabs-left > .nav-tabs .active > a:focus {
		  border-color: #ddd transparent #ddd #ddd;
		  *border-right-color: #ffffff;
		}

		.tabs-right > .nav-tabs {
		  float: right;
		  margin-left: 19px;
		  border-left: 1px solid #ddd;
		}

		.tabs-right > .nav-tabs > li > a {
		  margin-left: -1px;
		  -webkit-border-radius: 0 4px 4px 0;
		     -moz-border-radius: 0 4px 4px 0;
		          border-radius: 0 4px 4px 0;
		}

		.tabs-right > .nav-tabs > li > a:hover,
		.tabs-right > .nav-tabs > li > a:focus {
		  border-color: #eeeeee #eeeeee #eeeeee #dddddd;
		}

		.tabs-right > .nav-tabs .active > a,
		.tabs-right > .nav-tabs .active > a:hover,
		.tabs-right > .nav-tabs .active > a:focus {
		  border-color: #ddd #ddd #ddd transparent;
		  *border-left-color: #ffffff;
		}
		#mn_nav #headerMenu .dropdown-menu>li>a:hover {
		    color: #262626;
		    text-decoration: none;
		    background-color: #f5f5f5;
		}
		#activity_notification_list .watched{
			background-color: rgba(204, 204, 204, 0.21);
		}

		#activity_notification_list_holder {
			padding: 5px 0px;
			border-bottom: 1px solid rgba(204, 204, 204, 0.21);
		}

		#activity_notification_list{
			list-style: none;
		  	margin: 0px !important;
		    padding: 0px  !important;
			max-height: 425px;
			width: 330px;
			overflow-y: auto !important;
		}
		#activity_notification_list li{
			cursor: pointer;
			padding: 0px 15px;
			color: #ccc;
		}

		#activity_notification_header{
			text-align: left;
			padding: 10px 25px !important;
		    border-bottom: 2px solid #E4EBF1;
		    background:#e6e6e5 !important;
		    color: #5a5a5a !important;
			font-size: 15px;
		    font-family: inherit;

		}

		.label_bookoke{
			padding: 0.4em 0.5em;
			float: right;
		}

		.label_sch_hoantat{
			background-color: rgb(102, 134, 157);
			
		}
		.label_notworking{
			background-color: rgb(180, 180, 180);
		}

		.label_sch_moi{
			background-color: rgb(89, 179, 90);
		}

		.label_sch_khongden{
			background-color: rgb(150, 80, 80);
		}

		.label_sch_daden{
			background-color: rgb(59, 179, 168);
		}

		.label_sch_vaokham{
			background-color: rgb(8, 100, 170);
		}

		.label_sch_bove{
			background-color: rgb(160, 130, 100);
		}
	
		.label_sch_huy{
			background-color: rgb(219, 189, 90);
		}
		

		

		.activity_icon img {
			width: 30px;
			height: auto;
		}

		.activity_icon .create{
		    color: rgb(89, 179, 90) !important;
		}
		.activity_icon .update {
		    color: rgb(59, 179, 168) !important;
		}
		.activity_icon .delete {
		    color: #ED6060 !important;
		}

		.btn_plus{
			height: 30px;
    		width: 30px;
			float: right;
			cursor: pointer;
			background: url('<?php echo Yii::app()->params['image_url']; ?>/images/icon_add/add-def.png');
			background-size: 100%;
	   		background-repeat: no-repeat;
		}
/*		.btn_plus:hover{
			height: 30px;
    		width: 30px;
			float: right;
			cursor: pointer;
			background: url('<?php echo Yii::app()->params['image_url']; ?>/images/icon_add/add-act.png');
			background-size: 100%;
	   		background-repeat: no-repeat;
		}*/
		.btn_bookoke_w{
			width: 98px;
		}
		.btn_w{
			width: 86px;
		}
		.btn_material_w{
			width: 93px;
		}
		.btn_delete {
			background: #C0BFBF;
			color: white;
		}


	</style>
	<div class="cal-loading"></div>
	<div class="container-fluid" id="mn_nav">
		<div id="headerMenu" class="row">
			<nav class="navbar navbar-default">
	
			    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="navbar-collapse">
				    	<ul class="nav navbar-nav">
				    		<li><a href="#" style="padding: 7px;margin-left:10px;"><img src="<?php echo Yii::app()->params['image_url']; ?>/images/logo-line-white.png" alt="" style="width:35px;"></a></li>
				    	</ul>
				      
				      	<ul class="nav navbar-nav navbar-right" id="mn_ad">
				      	<li class="dropdown">
						    

						    <ul class="dropdown-menu dropdown-alerts" style="padding: 0;" >

						    	<div id="activity_notification_header">THÔNG BÁO</div>


						    	<ul  id="activity_notification_list">
							      

					            </ul>

					            <div>
					            	 <a class="text-center" href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsUsers/Notifications/View">
					                    <h5>Xem tấc cả <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></h5>
					                    
					                </a>
					            </div>
						    </ul>

						    <a class="dropdown-toggle icon_vsc" data-toggle="dropdown" href="#">
						        <i class="fa fa-bell fa-fw"></i>
						        <span id="sumNotification"  value="<?php //echo $sumNotification; ?>"><?php //echo $sumNotification; ?></span>
						        <i class="fa fa-caret-down"></i>
						    </a>

						    <!-- /.dropdown-alerts -->
						</li>
				        <li class="dropdown">
					        <a class="dropdown-toggle icon_vsc" data-toggle="dropdown" href="#" style="font-size:17px;">
					            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
					        </a>
					        <ul class="dropdown-menu dropdown-user">
					            <li>
						            <a href="#"><i class="fa fa-user fa-fw"></i>
						            	<?php echo Yii::app()->user->name;?>
						            </a>
					            </li>
					            <li>
					            	<a href="<?php echo Yii::app()->baseUrl;?>/index.php/admin/index"><i class="fa fa-gear fa-fw"></i> Settings</a>
					            </li>
					            <li>
						            <a href="<?php echo Yii::app()->baseUrl;?>/index.php/admin/logout">
						            <i class="fa fa-sign-out fa-fw"></i> Logout</a>
					            </li>
					        </ul>
					        <!-- /.dropdown-user -->
					    </li>

				      </ul>

				    </div><!-- /.navbar-collapse -->
			</nav>
		</div>
		<?php echo $content; ?>
	</div>	
	<?php  //include_once('notifications.php'); ?>
</body>
