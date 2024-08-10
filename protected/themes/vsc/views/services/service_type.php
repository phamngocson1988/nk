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
	.line{text-align: left;font-size: 28px;color: #14a9de;text-transform: uppercase; position: relative;z-index: 1;}
	.line:before {border-top: 2px solid #14a9de;content: "";position: absolute;top: 60%;left: 0;right: 0;bottom: 0;z-index: -1;}
	.line span{padding-left: 0; padding-right: 10px;}
	.item-service{margin-top: 20px}
	.item-service a{ color:  #333 !important}
	.item-service .img{ height: 180px; overflow: hidden; }
	.item-service .name-service{ color: #333; font-size: 22px; margin-bottom: 5px}
	.item-service .xem {width: 20px;text-align: center; margin-left: 10px; cursor: pointer;}
	.item-service .ns_view{font-size: 13px;font-style: italic; margin-bottom: 5px;}
	.item-service .img img{transition: all 0.7s ease;}
	.item-service .img img:hover {-moz-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-transform: scale(1.3);transform: scale(1.3);}
	#key_search{float:left;width:100%;height:41px;}
	#img_search{z-index: 10;right: 0%;cursor:pointer;width:43px;position:absolute;padding:10px;background-color: #14a9de;}
	.list-service-right .title-1 {font-size: 20px;font-family: Helvetica-Bold;text-transform: uppercase;color: #000; margin-top: 10px; margin-bottom: 10px;}
	.list-service-right .title-2{font-size: 14px;font-family: Helvetica-Bold;margin-bottom:4px; color: #000; line-height: 1.2}
	.menu-service-f {list-style-type: none;padding: 0px; background: #fff;}
	.menu-service-f li {padding: 12px 0px;border-bottom: 1px solid #e3e3e3;}
	.menu-service-f li a {color: #696868;text-decoration: none;font-size: 16px;}
	.menu-service-f .active a {color: #000;font-weight: bold;}
	.menu-service-f li a img{width: 17px;margin-top:-3px; margin-right: 5px;}
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
    $count_all 	= ServiceType::model()->getCountService(0);
?>

<div class="container margin-top-20 margin-bottom-50">
	<div class="col-xs-12 col-xs-12 col-md-8 margin-top-50" id="list_service">
		<div class="line">
			<span>
				<?php 
					if($lang=='vi'){
						echo $type['name'];
					}else{
						echo $type['name_en'];
					}
			 	?>
			</span>
		</div>
		<?php 
			if($data_service):
				foreach ($data_service as $key => $data):
					$str = $this->convert_vi_to_en($data['name']);
		?>
				<div class="row item-service">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu-chi-tiet/<?php echo $str;?>-<?php echo $data['id'];?>/lang/<?php echo $lang;?>">
						<div class="col-sm-5 margin-top-20">
							<div class="img">
								<?php if($data['image']): ?>
									<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/service/lg/<?php echo $data['image']; ?>" class="img-responsive">
								<?php else: ?>
									<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/service/no_image.png" class="img-responsive">
								<?php endif;?>
							</div>
						</div>
						<div class="col-sm-7 margin-top-20">
							<div class="name-service">
								<?php
	                            	if($lang=='en'){
	                            		echo $data['name_en'];
	                            	}else if($lang == 'vi'){
	                            		echo $data['name'];
	                            	}
	                        	?>
							</div>
							<div class="ns_view">
								<span>
									<?php echo Yii::t('translate','date'); ?>:
									<?php echo date_format(date_create($data['createdate']),'d-m-Y'); ?>
								</span>
							</div>
							<div class="content">
								<?php 
									if($lang=='vi'){
										$description = strip_tags($data['content']);
										if (strlen($description) > 200) {
										    $stringCut = substr($description, 0, 200);
										    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
										} 
									}else{
										$description = strip_tags($data['content_en']);
										if (strlen($description) > 200) {
										    $stringCut = substr($description, 0, 200);
										    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
										}
									}
									echo $description;
								?>
							</div>
							<button type="button" class="btn btn_blue margin-top-10">
								<?php if($lang=='vi'){echo "Xem thêm";}else{echo "See more";}?>
							</button>
						</div>
					</a>
				</div>
	<?php 
				endforeach;
			else:
				echo "<p style='margin-top:30px; text-align:center'>".Yii::t('translate','no_post')."</p>";
			endif;
	?>
		<div class="paging margin-top-20">
			<ul class="pagination pull-left">
			<?php 
				if(isset($lst))
					{ echo $lst;}
				else{?>
					<li></li>
			<?php }?>
			</ul>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4 margin-top-50 list-service-right ">
		<div class="col-xs-12">
            <div class="title-1"><?php echo Yii::t('translate','category');?></div>
            <ul class="menu-service-f margin-bottom-50">
				<?php if($lang == 'vi'){ ?>
					<li>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu">
							<span>Tất cả bài viết</span>
							<span class="all_new"><?php echo  $count_all;?></span>
						</a>
					</li>
				<?php }else{ ?>
					<li>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/services">
							<span>All posts</span>
							<span class="all_new"><?php echo  $count_all;?></span>
						</a>
					</li>
				<?php } ?>
				<?php 
					$serviceType= ServiceType::model()->getListServiceType(); 
					foreach ($serviceType as $key => $val):
						$str 	= $this->convert_vi_to_en($val['name']);
						$count 	= ServiceType::model()->getCountService($val['id']);
				?>
					<li class="<?php if($val['id'] == $type['id']){ echo "active";} ?>">
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu/<?php echo $str; ?>-<?php echo $val['id']; ?>/lang/<?php echo $lang;?>">
							<span>
								<?php
									if($lang == 'vi'){
										echo $val['name'];
									}else{
										echo $val['name_en'];
									}
								?>
							</span>
							<span class="all_new">
								<?php echo  $count; ?>
							</span>
						</a>
					</li>
				<?php endforeach; ?>           
			</ul>
		</div>
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