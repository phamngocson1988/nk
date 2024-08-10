<style>
#cr_info {background: white; padding-bottom: 40px;}
#cr_info h2.line {color: #14a9de; font-weight: bold; margin: 50px 0;}
#cr_info .line:before {border-color: #14a9de; top: 80%;}
#cr_tt {color: #9ec63c; font-size: 24px; font-weight: bold; line-height: 35px;}
#cr_tt span {font-size: 40px; margin-right: 0px;}
#cr_tt hr {border: 1px solid #ddd; width: 60%; margin-left: 0;}
#cr_cir {width: 13px;height: 13px;border-radius: 100%;background: #848484;position: absolute;top: -5px;right: 39%;}
#cr_main {background: #f4f5f5; padding-top: 20px;}
#cr_main hr {width: 60%; border: 1px dashed #ddd; margin: 10px auto;}
.cr_box {padding-top: 15px; padding-bottom: 20px;}
.cr_view {font-size: 12px; font-style: italic;padding: 1px 0;}
.cr_view span{ margin-right: 20px; }
.xem{width: 17px;text-align: center;margin-right: 5px;}
.cmt{width: 15px;text-align: center;display: none;}
.line span{padding-right: 15px !important;}
.pagination>.active>a{color: #fff !important;background-color: #808285 !important;}
.paging .pagination li a {margin-right: 5px;border: 1px solid #808285 !important;color: #808285;border-radius: 0;}
h2{text-transform: uppercase;  }
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
</style>
<div >
<div  class="container" id="cr_info">
	<div class="row">
		<h2 class="col-md-12 line"><span style="background:white;"><?php echo Yii::t('translate','job'); ?></span></h2>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-5">
					<img src="<?php echo Yii::app()->params['image_url']; ?>/images/doi ngu bs-vuong.jpg" alt="" class="img-responsive">
				</div>
				<?php $introduce =  PInfrastructure::model()->findAll(); ?>
				<div class="col-md-7">
					<div id="cr_tt">
						<p><span>&ldquo;</span>
							<?php 
								if($lang=='vi'){
									echo $introduce[7]['title']; 
								}else{
									echo $introduce[7]['title_en']; 
								}
							?>
						</p>
						<div style="position:relative;">
							<hr>
							<div id="cr_cir"></div>
						</div>
					</div>
					<div>
						<?php
							if($lang=='vi'){
								echo $introduce[7]['content']; 
							}else{
								echo $introduce[7]['content_en']; 
							} 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<div  id="cr_main">
	<div class="container">
		<div class="row">
		<?php
		$dem =0;
		foreach($show_km as $gt){?>
			<div class="col-sm-12 col-md-6 cr_box">

				<div class="row">

					<div class="col-sm-5 ">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/recruitment/lg/<?php echo $gt['image']?>" alt="" class="img-responsive">
					</div>

					<div class="col-sm-6 ">
						<h4 class="title_news">
							<?php if($lang=='vi'){echo $gt['title'];}else{echo $gt['title_en'];}?>
						</h4>
						<div class="cr_view">
							<span class="text-muted"><i><?php echo Yii::t('translate','date'); ?> <?php echo date_format(date_create($gt['createdate']),'d-m-Y'); ?></i></span>
							<span class="text-muted"><img src="<?php echo Yii::app()->params['image_url']; ?>/images/xem.png" class="xem"><?php echo $gt['total_view'];?></span>
							<span class="text-muted"><img src="<?php echo Yii::app()->params['image_url']; ?>/images/cmt.png" class="cmt"></span>
						</div>
						<div style="line-height:19px; margin-top: 1px;">
							<span class="text-muted">
								<?php 
								if($lang=='vi'){
									echo mb_substr($gt['description'],0,90,'UTF-8').'...';
								}else{
									echo mb_substr($gt['description_en'],0,90,'UTF-8').'...';
								}
								?>
							</span>
						</div>
						<?php $str_title = $this->convert_vi_to_en($gt['title']); ?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/nghe-nghiep/<?php echo $str_title;?>-<?php echo $gt['id'];?>/lang/<?php echo $lang;?>"><button type="button" class="btn btn_green" style="font-size: 10px !important;text-transform: uppercase; "><?php echo Yii::t('translate','see_more'); ?></button>
						</a>
					</div>
				</div>
			</div>

			<?php $dem++;
			if($dem%2==0){?>
			<div class="col-sm-12">
				     <hr>
			</div>
		
		<?php }}?>
			<div class="paging col-sm-12">
				<ul class="pagination pull-right">
					<?php echo $lst?>
				</ul>
			</div>
		</div>
	</div>

</div>
</div>
<script>
$(window).load(function () {
	$('body').delay(1000) //wait 5 seconds
	    .animate({
	        'scrollTop': $('#cr_info').offset().top
	    }, 300);
});
</script>