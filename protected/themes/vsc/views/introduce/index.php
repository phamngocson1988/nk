<?php
	$this->metaKeywords = $data_seo[0]['meta_keywords'];
	$this->metaDescription = $data_seo[0]['meta_description'];
	$this->pageTitle = $data_seo[0]['meta_title'];
	// $this->canonical = $model->getAbsoluteUrl(); // canonical URLs should always be absolute
?>
<style type="text/css">

	h1,h2,h3,h4{
		padding: 0px;
		margin: 0px;
	}

	.caption-style-2{
		list-style-type: none;
		margin: 0px;
		padding: 0px;
		
	}

	.caption-style-2 li{
		float: left;
		padding: 10px;
		position: relative;
		overflow: hidden;
		width: 33%
	}

	.caption-style-2 li:hover .caption{
		opacity: 1;
		transform: translateY(-100px);
		-webkit-transform:translateY(-100px);
		-moz-transform:translateY(-100px);
		-ms-transform:translateY(-100px);
		-o-transform:translateY(-100px);

	}


	.caption-style-2 img{
		margin: 0px;
		padding: 0px;
		float: left;
		z-index: 4;
		width: 100%;
	}


	.caption-style-2 .caption{
		cursor: pointer;
		position: absolute;
		opacity: 0;
		top:300px;
		-webkit-transition:all 0.15s ease-in-out;
		-moz-transition:all 0.15s ease-in-out;
		-o-transition:all 0.15s ease-in-out;
		-ms-transition:all 0.15s ease-in-out;
		transition:all 0.15s ease-in-out;

	}
	.caption-style-2 .blur{
		background-color: rgba(0,0,0,0.7);
		height: 110px;
		width: 400px;
		z-index: 5;
		position: absolute;
	}

	.caption-style-2 .caption-text h1{
		text-transform: uppercase;
		font-size: 18px;
	}
	.caption-style-2 .caption-text{
		z-index: 10;
		color: #fff;
		position: absolute;
		width: 400px;
		height: 300px;
		text-align: center;
		top:20px;
	}
	.actioncontent{
		display: block !important;
	}
	.action{
		display: block;
	}
	.material-feature {
    	text-align: center;
	}
	.material-feature label{
		color: #0875b8;
		text-transform: uppercase;
	}
	.clearfix {
	    clear: both;
	}
		.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover
	{
		border: none;
	}
	.nav-tabs>li>a:hover
	{
		color: #fff !important;
		background-color: #fff;
		border-color: #fff;
	}
	</style>
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

<div class="container">
	<div class="row" style="padding-top: 35px; padding-bottom: 35px;">
		<div class="col-sm-12 default-padding">
			<ul class="nav nav-tabs" role="tablist">
					<li class="col-xs-12 col-sm-4 text-center material-feature active">
						<a href="#aboutus" data-toggle="tab">
	                        <div class="icon-about-us"></div>
	                        <label class="control-label text-center"><?php echo Yii::t('translate','about_us'); ?></label>
                    	</a>
					</li>
					<li class="col-xs-12 col-sm-4 text-center material-feature">
						<a href="#doingubacsi" data-toggle="tab">
	                        <div class="icon-doctor"></div>
	                        <label class="control-label text-center"><?php echo Yii::t('translate','team_medical'); ?></label>
                    	</a>
					</li>
					<li class="col-xs-12 col-sm-4 text-center material-feature">
						<a href="#vatchat" data-toggle="tab">
	                        <div class="icon-facility"></div>
	                        <label class="control-label text-center"><?php echo Yii::t('translate','equipment'); ?></label>
                    	</a>
					</li>
			</ul>
            <div class="clearfix"></div>
            <hr style="border-top:1px solid #9ec63b; margin-top: 0px">
        </div>
        <div class="col-sm-12 tab-content clearfix">
            <div id="aboutus" class="tab-pane active">
            	<?php include('about_us.php'); ?>
            </div>
            <div id="doingubacsi" class="tab-pane">
            	<?php include('bacsi.php'); ?>
            </div>
            <div id="vatchat" class="tab-pane">
            	<?php include('cosovatchat.php'); ?>
            </div>
        </div>
	</div>
</div>
<script>
$(document).ready(function (){
		$(function() {
	    var hash = window.location.hash;
	    hash && $('ul.nav a[href="' + hash + '"]').tab('show');
	});
});
$(window).load(function () {
	$('body').delay(1000) //wait 5 seconds
	    .animate({
	        'scrollTop': $('#scroll').offset().top
	    }, 200);
});
</script>