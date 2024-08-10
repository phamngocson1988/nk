
<style>
	@media (min-width: 1200px){
		.container {
		    width: 1170px !important;
		}
	}
	.margin-top-50{margin-top: 50px}
	.margin-bottom-50{margin-bottom: 50px}
	.margin-top-20{margin-top: 20px}
	.margin-bottom-20{margin-bottom: 20px}
	.margin-top-10{margin-top: 10px}
	.xem {width: 20px;text-align: center; margin-left: 10px;}
	.list-service-right .title-1 {font-size: 20px;font-family: Helvetica-Bold;text-transform: uppercase;color: #000; margin-top: 10px; margin-bottom: 20px;}
	.list-service-right .title-2{font-size: 14px;font-family: Helvetica-Bold;margin-bottom:4px; color: #000; line-height: 1.2}
	.list-service-right .img-service-more {height: 60px; width: 65px; overflow:hidden;}
	.list-service-right .img-service-more img{height: 100%}
	.span-date{background:#14a9de;padding: 3px 15px 3px;color: #fff;font-size: 12px;}
	.all_new{height: 30px;width: 30px; border-radius: 50%; background: #ccc; color: #fff; float: right;text-align: center;padding:3px 0;font-size: 12px;}
	.pagination>.active>a{color: #fff !important;background-color: #808285 !important;}
	.paging .pagination li a {margin-right: 5px;border: 1px solid #808285 !important;color: #808285;border-radius: 0;}
</style>
<?php   
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
<div class="container margin-bottom-50">
	<div class="col-xs-12 col-xs-12 col-md-8 margin-top-50" id="list_service">
		<p style="font-size: 25px;font-weight: bold;">
			<?php if($lang=='vi'){echo $detail['name'];}else{echo $detail['name_en'];} ?>
		</p>
		<div class="ns_view">
			<span><?php echo $detail['createdate']; ?></span>
			<span><img src="<?php echo Yii::app()->params['image_url']; ?>/images/xem.png" class="xem"> <?php echo $detail['total_view']; ?></span>
		</div>
		<div class="img margin-top-20 margin-bottom-20">
			<?php if($detail['image']): ?>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/service/lg/<?php echo  $detail['image']; ?>" class="img-responsive">
			<?php endif;?>
		</div>
		<div  id="news_content">
			<?php   
				if($lang=='vi'){
					if(!$detail['content']){
						echo "<p>Đang cập nhật dữ liệu !</p>";
					}else{ 
						echo $detail['content']; 
				    }
				}else{
					if(!$detail['content_en']){
						echo "<p>Updating !</p>";
					}else{ 
						echo $detail['content_en']; 
				    }
				}
			?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4 margin-top-50 list-service-right ">
		<div class="col-xs-12">
			<p class="title-1 ">
				<?php
					if($lang == 'vi'){
						echo "Tin xem nhiều";
					}else{
						echo "Most viewed post";
					}
				?>
			</p>
			<?php 
				if($view_more):
					foreach ($view_more as $key => $view):
						$str_w = $this->convert_vi_to_en($view['name']);
			?>
					<div class="row margin-bottom-20">
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu-chi-tiet/<?php echo $str_w;?>-<?php echo $view['id'];?>/lang/<?php echo $lang;?>">
							<div class="col-xs-3" style="padding-right: 0">
								<div class="img-service-more">
									<?php if($view['image']): ?>
										<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/service/lg/<?php echo  $view['image']; ?>" class="img-responsive">
									<?php else: ?>
										<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/service/no_image.png" class="img-responsive">
									<?php endif;?>
								</div>
							</div>
							<div class="col-xs-9">
								<p class="title-2">
									<?php
		                            	if($lang=='en'){
		                            		echo $view['name_en'];
		                            	}else if($lang == 'vi'){
		                            		echo $view['name'];
		                            	}
		                        	?>
								</p>
								<span class="span-date">
									<?php echo date_format(date_create($view['createdate']),'d-m-Y'); ?>
								</span> 
							</div>
						</div>
					</a>
			<?php 
					endforeach;
				endif; 
			?>
		</div>
	</div>
</div>