<style type="text/css">
.pagination>.active>a{color: #fff !important;background-color: #808285 !important;}
.paging .pagination li a {margin-right: 5px;border: 1px solid #808285 !important;color: #808285;border-radius: 0;}
.ns_box h4:hover p{color: #1fa8e0;}
.div_trang {width: 30px;padding: 6px 12px;;text-align: center;border: 1px solid #808285 !important;margin: 2px;
</style>

<h3 class="line">
	<span style="background: white !important;text-transform: uppercase;">
	<?php if(isset($type) && $type)
		{ 
			echo $type['name'];
		}
		else if(isset($search) && $search){
			echo $search;
		} else 
			echo Yii::t('translate','new_news');
	?>
	</span>
</h3>

<?php if (!$news_line) { ?>
	<div class="col-md-offset-5 col-xs-offset-4">
		<p style="font-style: italic;font-weight: bold;"> <?php echo Yii::t('translate','no_post'); ?></p>
	</div>
 
<?php } else { 
	foreach ($news_line as $item){ ?>
	
<div class="col-md-12 ns_box">
	<div class="row">
		<div class="col-md-5 ns_img ns_box_img">
		<?php 
			$name_line = NewsLine::model()->findByPK($item['id_news_line']);
			$str_line = $this->convert_vi_to_en($name_line['name']);
			$str_title = $this->convert_vi_to_en($item['title']);
		?>
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line?>/<?php echo $str_title?>-<?php echo $item['id']?>/lang/<?php echo $lang;?>"><img style="width: 100%" src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/new/
			<?php 
			if(isset($item['image']))
			{
				echo "sm/".$item['image'];
			}
			else{
				echo "no_image.png";
			}
			?>" 
			alt="" class="img-responsive"></a>
		</div>
		<div class="col-md-7">
			<h4><a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line?>/<?php echo $str_title?>-<?php echo $item['id']?>/lang/<?php echo $lang;?>">
				<?php 
					if($lang=='vi'){
						$title = strip_tags($item['title']);
						if (strlen($title) > 42) {
						    $stringCut = substr($title, 0, 42);
						    $title = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
						} 
					}else{
						$title = strip_tags($item['title_en']);
						if (strlen($title) > 42) {
						    $stringCut = substr($title, 0, 42);
						    $title = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
						}
					}
				?>
				<p><?php echo $title; ?></p>
			</a></h4>
			<div class="ns_view">
				<span><?php echo Yii::t('translate','date'); ?> <?php echo $item['createdate']; ?></span>
				<span><img src="<?php echo Yii::app()->params['image_url']; ?>/images/xem.png" class="xem"><?php echo $item['total_view']; ?></span>
		<span><img src="<?php echo Yii::app()->params['image_url']; ?>/images/cmt.png" class="cmt"></span>
			</div>
			<div style="color: rgb(33, 32, 32)">
				<?php 
					if($lang=='vi'){
						$description = strip_tags($item['description']);
						if (strlen($description) > 130) {
						    $stringCut = substr($description, 0, 130);
						    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
						} 
					}else{
						$description = strip_tags($item['description_en']);
						if (strlen($description) > 130) {
						    $stringCut = substr($description, 0, 130);
						    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
						}
					}
				?>
				<p style="min-height:57px;"><?php echo $description; ?></p>
			</div>
			<div>
				
				<p><a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line?>/<?php echo $str_title?>-<?php echo $item['id']?>/lang/<?php echo $lang;?>"><button type="button" class="btn btn_blue"><?php if($lang=='vi'){echo "Xem thêm";}else{echo "See more";}?></button></a></p>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="paging">
	<ul class="pagination pull-left">
	<?php 
		if(isset($lst))
			{ echo $lst;}
		else{?>
			<li></li>
	<?php }?>
	</ul>
</div>
<?php } ?>