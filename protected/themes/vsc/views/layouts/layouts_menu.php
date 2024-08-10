<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="Content-Security-Policy: default-src https://nhakhoa2000.com; child-src 'none'; object-src 'none'" content="block-all-mixed-content">

    <link rel="shortcut icon" href="<?php echo Yii::app()->params['image_url']; ?>/images/Logo-NK-2000.png"/>

    <meta name="author" content="BookOke Co.Ltd"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <meta property="og:title" content="Home | Nha Khoa 2000"/>
    <meta property="og:image" content="/images/Logo NK 2000_color-01.png"/>
    <meta property="og:site_name" content="Chào mừng bạn đến với NHA KHOA 2000"/>
    <meta property="og:description" content="Là một trong những trung tâm nha khoa đi đầu tại Việt Nam, chúng tôi đã mang đến nhiều thành tựu trong lĩnh vực cấy ghép Implant, chỉnh hình răng mặt và nha khoa thẩm mỹ được thực hiện bởi những chuyên gia răng miệng, viện trưởng bệnh viện hàng đầu Việt Nam" />


    <link href="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jAlert.css" rel="stylesheet" type="text/css" />

    <?php
    $cs  = Yii::app()->getClientScript();
    $cs->registerCssFile(Yii::app()->baseUrl.'/css/font-awesome/css/font-awesome.min.css');
    $cs->registerCssFile(Yii::app()->baseUrl.'/css/admin/tab.css');
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    ?>
    <script src='<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2.full.min.js'></script>
    <script src='<?php echo Yii::app()->request->baseUrl; ?>/js/select2/i18n/vi.js'></script>

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/moment.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/autoNumeric.js" type="text/javascript"></script>
    <script src='<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datetimepicker.min.js'></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jAlert.min.js" type="text/javascript"></script>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bookoke.js" type="text/javascript"></script>

    <script>
	// select2 set default
		$.fn.select2.defaults.set('language', 'vi');
	// end select2 set default
    </script>

</head>

<body>
	<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl;?>"/>
	<input type="hidden" id="user_id" value="<?php echo Yii::app()->user->getState('user_id');?>"/>
	<style>
	.btn {border-radius: 0 !important;}
	.btn_book {
	    background: #93c541 !important;
	    color: white !important;
	}
	.unbtn{background: lightgray !important; cursor: default;}
	.close {
	    font-size: 36px;
	    color: white;
	    opacity: 1;
	    font-weight: lighter;
	}
	.sHeader {
	    background: #0eb1dc;
	    color: white;
	    padding: 8px 30px;
	    font-size: 18px;
	    border: 0px;
	}

	.modal-header .close {
	    font-size: 36px;
	    color: white;
	    opacity: 1;
	    font-weight: lighter;
	}
	.modal-header h3{
	    font-size: 20px !important;
	    line-height: 1.7em;
	    font-weight: normal;
	    text-transform: uppercase;
	}
	.modal-content{
		border: 0px;
	}
	.popover-title{
		text-transform: uppercase;
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

		#oSrchLeft .menu-export li{
			border-top: none;
		}
		#oSrchLeft .menu-export{
			min-width: 96px;
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



		/* active = -2 */
		.label_sch_xoa{
			background-color: #000000;
		}

		/* Status = -2 */
		.label_sch_bohen{
			background-color: #965050;
		}

		/* Status = -1 */
		.label_sch_henlai{
			background-color: rgb(24, 24, 163);
		}

		/* Status = 0 */
		.label_notworking{
			background-color: #b4b4b4;
		}

		/* Status = 1 */
		.label_sch_moi{
			background-color: rgb(0, 176, 240);
		}

		/* Status = 2 */
		.label_sch_dangcho{
			background-color: rgb(255, 255, 0);
		}

		/* Status = 3 */
		.label_sch_dieutri{
			background-color: rgb(0, 255, 0);
		}

		/* Status = 4 */
		.label_sch_hoantat{
			background-color: rgb(255, 0, 0);
		}

		/* Status = 5 */
		.label_sch_bove{
			background-color: rgb(228, 108, 10);
		}

		/* Status = 6 */
		.label_sch_vaokham{
			background-color: rgb(0, 255, 0);
		}

		/* Status = 7 */
		.label_sch_xacnhan{
			background-color: rgb(255, 51, 204);

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
		.btn_nhakhoa2000{
			background: #10b1dd;
			color: white;
		}
		/* call-animation-css*/
		.call-animation {
		    background: #fff;
		    width: 50px;
		    height: 50px;
		    position: relative;
		    margin: 0 auto;
		    border-radius: 100%;
		    border: solid 5px #fff;
		    animation: play 2s ease infinite;
		    -webkit-backface-visibility: hidden;
		    -moz-backface-visibility: hidden;
		    -ms-backface-visibility: hidden;
		    backface-visibility: hidden;

		}
		 .img-circle {
		 	cursor: pointer;
		    width: 50px;
		    height: 50px;
		    border-radius: 100%;
		    position: absolute;
		    left: -5px;
		    top: -5.6px;
		    }
		@keyframes play {

		    0% {
		        transform: scale(1);
		    }
		    15% {
		        box-shadow: 0 0 0 5px rgba(97, 203, 235, 0.4);
		    }
		    25% {
		        box-shadow: 0 0 0 10px rgba(97, 203, 235, 0.4), 0 0 0 20px rgba(97, 203, 235, 0.2);
		    }
		    25% {
		        box-shadow: 0 0 0 15px rgba(97, 203, 235, 0.4), 0 0 0 30px rgba(97, 203, 235, 0.2);
		    }

		}
		.navbar .nav>li>a:hover {
		    color: #10b1dd !important;
		    text-decoration: none;
		}
		#sumBoxNotification{
			display: inline-block;
		    position: absolute;
		    background-color: #c52626;
		    color: #fff;
		    line-height: 15px;
		    text-align: center;
		    top: 7px;
		    left: -5px;
		    border-radius: 15%;
		    font-size: 11px;
		    padding: 2px 5px;
		}
	</style>
	<div id="ring-call"></div>
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
				    		<li><a href="#" style="padding: 7px;margin-left:10px;">
				    			<img src="<?php echo Yii::app()->params['image_url']; ?>/images/logo-line-white.png" alt="Nha Khoa 2000" style="width:35px;"></a></li>
				    	</ul>
				      <ul class="nav navbar-nav menuMain">

				      <?php $group_id =  Yii::app()->user->getState('group_id');?>

				      	<?php //if($group_id == 1 ||$group_id == 2 ||$group_id == 3 || $group_id == 17) { ?>
				        <!-- <li><a href="<?php //echo Yii::app()->baseUrl.'/itemsDashBoard/DashBoardBusiness/index'; ?>" title="" class="<?php //if(Yii::app()->controller->id == 'dashBoardBusiness'){ echo "active"; } ?>">Tổng quan<span class="sr-only">(current)</span></a></li> -->
				        <?php //} ?>

				        <?php if($group_id == 1 ||$group_id == 2 ||$group_id == 3 || $group_id == 4 ||$group_id == 5 || $group_id == 11 || $group_id == 16  || $group_id == 17) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsSchedule/calendar/index'; ?>" title="" class="<?php if(Yii::app()->controller->id == 'calendar'){ echo "active"; } ?>">Lịch hẹn</a></li>
				        <?php } ?>

				        <?php if($group_id == 1 ||$group_id == 2 ||$group_id == 3 || $group_id == 4 || $group_id == 5 || $group_id == 16  || $group_id == 17 || $group_id == 11) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsCustomers/Accounts/admin'; ?>" class="<?php if(Yii::app()->controller->module->id == 'itemsCustomers' || Yii::app()->controller->id == 'opportunity' ){ echo "active"; } ?>" >Khách hàng</a></li>
				        <?php } ?>

				        <?php if($group_id == 1 ||$group_id == 2 ||$group_id == 3 || $group_id == 4 || $group_id == 16 || $group_id == 17) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsUsers/Notifications/View'; ?>" class="<?php if(Yii::app()->controller->id == 'notifications' || Yii::app()->controller->id == 'sms'){ echo "active"; } ?>" >Tin nhắn</a></li>
				        <?php } ?>

				        <?php if($group_id == 1 ||$group_id == 2 || $group_id == 4 || $group_id == 11 ||  $group_id == 16 || $group_id == 17 || $group_id == 5) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsSales/quotations/view'; ?>" class="<?php if(Yii::app()->controller->module->id == 'itemsSales'){ echo "active"; } ?>">Kinh doanh</a></li>
				        <?php } ?>

				        <?php if($group_id == 1 ||$group_id == 2 ) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsProducts/ProductService/View'; ?>" class="<?php if(Yii::app()->controller->module->id == 'itemsProducts'){ echo "active"; } ?>">Hàng hóa</a></li>
				        <?php }elseif($group_id == 3 ){ ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsProducts/Material/View'; ?>" class="<?php if(Yii::app()->controller->module->id == 'itemsProducts'){ echo "active"; } ?>">Hàng hóa</a></li>
				        <?php } ?>

				        <?php if($group_id == 1 ||$group_id == 20 || $group_id == 21 || $group_id == 22 ) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsInventory/csMaterial/admin'; ?>" class="<?php if(Yii::app()->controller->module->id == 'itemsInventory'){ echo "active"; } ?>">Kho</a></li>
				        <?php } ?>

				        <?php if($group_id == 1 || $group_id == 2 ) { ?>
				        <li>
					        <a href="<?php echo Yii::app()->baseUrl.'/itemsAccounting/Payable/Index'; ?>" class="
					        <?php
					        if(Yii::app()->controller->id == 'payable' || Yii::app()->controller->id == 'receivable' || Yii::app()->controller->id == 'cashflow'){ echo "active"; }

					        ?>">Tài chính</a>
				        </li>
				        <?php } ?>

				        <?php if($group_id == 1 ||$group_id == 2 ||$group_id == 3 || $group_id == 4 || $group_id == 5 || $group_id == 8 || $group_id == 11 || $group_id == 12 || $group_id == 13 || $group_id == 14 || $group_id == 15 || $group_id == 16 || $group_id == 17) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsUsers/Staff/View'; ?>" class="<?php if(Yii::app()->controller->id  == 'staff'){ echo "active"; } ?>">Nhân sự</a></li>
				        <?php } ?>

				        <?php if($group_id == 1 || $group_id == 2 || $group_id == 5) { ?>
				        	<li><a href="<?php echo Yii::app()->baseUrl.'/itemsCustomerService/reportingTreatmentAfter/view'; ?>" class="<?php if(Yii::app()->controller->module->id == 'itemsCustomerService'){ echo "active"; } ?>">CSKH</a></li>
				        <?php } ?>

				        <?php if($group_id == 1 ||$group_id == 2 || $group_id == 4 ) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsReports/reportingSalary/View'; ?>" class="<?php if(Yii::app()->controller->module->id == 'itemsReports'){ echo "active"; } ?>">Báo cáo</a></li>
				        <?php } ?>

				        <?php if($group_id == 16) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsReports/ReportingAppointment/view'; ?>" class="<?php if(Yii::app()->controller->module->id == 'itemsReports'){ echo "active"; } ?>">Báo cáo</a></li>
				        <?php }elseif ($group_id ==3  || $group_id == 19) { ?>
				        <li><a href="<?php echo Yii::app()->baseUrl.'/itemsReports/ReportCustomers/View'; ?>" class="<?php if(Yii::app()->controller->module->id == 'itemsReports'){ echo "active"; } ?>">Báo cáo</a></li>
				        <?php } ?>

				        <?php if($group_id == 1 ||$group_id == 2 || $group_id == 4 || $group_id == 16) { ?>
				        	<li><a href="<?php echo Yii::app()->baseUrl.'/itemsSetting/Business/View'; ?>" class="<?php if(Yii::app()->controller->id == 'insurrance' || Yii::app()->controller->id == 'chairCalendar' || Yii::app()->controller->id == 'placement' || Yii::app()->controller->id == 'timeKeeping' || Yii::app()->controller->id == 'business' || Yii::app()->controller->id == 'role' || Yii::app()->controller->id == 'settingLocations' ){ echo "active"; } ?>">Thiết lập</a></li>
				        <?php } ?>

				      </ul>

						<ul class="nav navbar-nav navbar-right" id="mn_ad">
				      		<li class="dropdown">


						     <ul class="dropdown-menu dropdown-alerts" style="padding: 0;width: 332px;" >

						    	<div id="activity_notification_header">THÔNG BÁO</div>

						    	<ul  id="activity_notification_list">
					            </ul>
					            <div>
					            	 <a class="text-center" href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsUsers/Notifications/View">
					                    <h5>Xem tấc cả <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></h5>
					                </a>
					            </div>
						    </ul>


						    <a class="dropdown-toggle icon_vsc" style="position: relative;" data-toggle="dropdown" href="#">
						        <i class="fa fa-bell fa-fw"></i>
						        <span  id="sumBoxNoti"></span>
						        <input id="sumNotification" type="hidden"  value="">
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
	<div class="updateEventAllLayout"></div>
	<?php //include_once('notifications.php'); ?>
	<?php //include_once('ipcc.php'); ?>
</body>
