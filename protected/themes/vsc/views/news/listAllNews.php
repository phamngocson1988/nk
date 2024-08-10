<style type="text/css">
	.pagination>.active>a{
    color: #fff !important;
    background-color: #808285 !important;
}
.paging .pagination li a {
    margin-right: 5px;
    border: 1px solid #808285 !important;
    color: #808285;
    border-radius: 0;
}
.ns_img {overflow: hidden; position: relative;}
.ns_box {margin: 25px 0;}
.ns_box h4{font-weight: bold; margin-bottom: 0; margin-top: 15px; cursor: pointer;}
	.ns_view {font-size: 12px; font-style: italic;padding: 5px 0;color: #6e6e6e}
	.ns_view span{margin-right: 20px;}

	.ns_box a {
		color: #333;
		display: block;
    	overflow: hidden;
	}
	.ns_box img {
		margin-right: 6px; 
		-webkit-transition: all 0.7s ease;
		transition: all 0.7s ease;
	}
	.ns_box img:hover{
		-moz-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);
		-webkit-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);
		box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);
		-webkit-transform:scale(1.3);
		transform:scale(1.3);

	}
	.ns_box_img {height: 158px;border: 1px solid rgba(204, 204, 204, 0.46);}

#ns_str .ns_box {margin-bottom: 50px;}
#ns_str .ns_box h4 {margin: 0;}
#ns_sr {margin-top: 30px;}
#ns_srch {border: 1px solid #19a8e0; margin: 30px 0;}
#ns_srch #ns_srch_tt h4 {background: #19a8e0;
    padding: 12px;
    margin: 0;
    text-align: center;
    font-weight: bold;
    color: white;}
#ns_srch .panel-body {border: 0;}
#ns_srch .panel-heading {border: 0; border-radius: 0;}
#ns_srch .panel-heading:hover {background: #c5c4c4; color: white;}
#ns_srch .panel-body {padding: 0 0 0 40px;}
#ns_tag {background: #f6f6fb; padding: 20px;}
#ns_tag hr {border: 1px solid #797877;}
.ns_tg_tags {margin: 8px 0px; display: inline-block;}
.ns_tg_tags a{padding: 7px 5px; border: 1px solid #ddd; color: #797877;}
.xem{
    width: 20px;text-align: center;
}
.ns_info {padding-left: 20px; margin: -15px 0 0;}
.ns_box h4:hover p{color: #1fa8e0;}
</style>
<div class="container">
	<div class="col-md-8">
	<div class="row " id="content_news">
		<h3 class="line" style="text-align: left !important;">
			<span style="background: white !important;color: #94c640;">TIN MỚI</span>
		</h3>
			
			<?php 
			 foreach ($allnews as $item){ ?>
			<div class="col-md-12 ns_box">
				<div class="row">
					<div class="col-md-5 ns_img ns_box_img">
					<?php 
						$name_line = NewsLine::model()->findByPK($item['id_news_line']);
						$str_line = $this->convert_vi_to_en($name_line['name']);
						$str_title = $this->convert_vi_to_en($item['title']);
					?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line?>/<?php echo $str_title?>-<?php echo $item['id']?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/new/
						<?php 
						if(isset($item['image']))
						{
							echo "lg/".$item['image'];
						}
						else{
							echo "no_image.png";
						}
						?>" 
						alt="" class=""></a>
					</div>
					<div class="col-md-7 ns_info">
						<h4><a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line?>/<?php echo $str_title?>-<?php echo $item['id']?>">
							<?php $title = strip_tags($item['title']);
			
							if (strlen($title) > 30) {
			
							    $stringCut = substr($title, 0, 30);
			
							    $title = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
							} ?>
							<p><?php echo $title; ?></p>
						</a></h4>
						<div class="ns_view">
							<span>Ngày <?php echo $item['createdate']; ?></span>
							<span><img src="<?php echo Yii::app()->params['image_url']; ?>/images/xem.png" class="xem"><?php echo $item['total_view']; ?></span>
						</div>
						<div style="color: rgb(33, 32, 32)">
							<?php $description = strip_tags($item['description']);
			
							if (strlen($description) > 130) {
			
							    $stringCut = substr($description, 0, 130);
			
							    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
							} ?>
							<p><?php echo $description; ?></p>
						</div>
						<div>
							
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str_line?>/<?php echo $str_title?>-<?php echo $item['id']?>"><button type="button" class="btn btn_blue">XEM THÊM</button></a>
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
			</div>
		</div>
		<div class="col-md-4" id="ns_sr">
			<h4><b>Tìm kiếm</b></h4>
			<div class="col-md-12" style="padding-left: 0px;">
				<input id="key_search" style="float:left;width:100%;height:41px;" type="text" class="form-control" placeholder="Nhập từ khóa...">
				<img id="img_search" style="z-index: 10;right: 0%;cursor:pointer;width:43px;position:absolute;padding:10px;background-color: #94c640;" src="<?php echo Yii::app()->params['image_url']; ?>/images/icon_search.png" alt="Search">
			</div>
			<div class="col-md-12" id="ns_srch">
				<div class="row">
					<div id="ns_srch_tt">
						<h4>- CHUYÊN MỤC -</h4>
					</div>
					<div>
						<dl>
						<?php $newstype = NewsLine::model()->findAll();
							foreach($newstype as $type){
								$str = $type['name'];
								$str = $this->convert_vi_to_en($str);
						?>
							<dt><a href="<?php echo Yii::app()->request->baseUrl; ?>/tin-tuc/<?php echo $str;?>-<?php echo $type['id']; ?>"><?php echo $type['name']; ?></a></dt>
					<?php } ?>	
						</dl>
					</div>
				</div>
			</div>
			<div class="col-md-12" id="ns_tag">
				<h4><i>Tags</i></h4>
				<hr>
				<div>
				<?php foreach($tags as $item){
					$str = $this->convert_vi_to_en($item['name']);
				?>
		
					<div class="ns_tg_tags"><a href="<?php echo Yii::app()->request->baseUrl; ?>/tags/<?php echo $str; ?>">&#9679 <?php echo $item['name'] ?></a></div>
				<?php } ?>
				</div>
			</div>
	</div>
</div>

