<style type="text/css">
.pagination>.active>a{color: #fff !important;background-color: #808285 !important;}
.paging .pagination li a {margin-right: 5px;border: 1px solid #808285 !important;color: #808285;border-radius: 0;}
.ns_box{    margin-bottom: 20px;}
.ns_box h4:hover p{color: #1fa8e0;}
.div_trang {width: 30px;padding: 6px 12px;;text-align: center;border: 1px solid #808285 !important;margin: 2px;}
.ns_img {overflow: hidden; position: relative;}
#ns_20 {padding-left: 5px;}
#ns_2 {height: 230px;}
#ns_3 {padding-top: 5px; padding-right: 0;}

#ns_31 {padding-right: 1px; height: 235px;}
#ns_32 {padding-left: 1px; height: 235px; width: 47.8%;}
.ns_img_1 {height: 470px;}
.ns_img_2 {margin-top: -10%;height: auto;}
.ns_img_txt {position: absolute; bottom: 0; left: 15px; background: rgba(0, 0, 0, 0.3); width: 100%; height: 100%; transition: 1s;}
.ns_img_txt div {position: absolute; bottom: 13%; left: 30px;}
.ns_img_txt h4 {font-size: 22px; font-weight: normal; color: white;letter-spacing: 1.5px; margin-right: 20px;}
.ns_img_txt:hover {
background: linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d);
background: -webkit-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Safari 5.1 to 6.0 */
background: -o-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Opera 11.1 to 12.0 */
background: -moz-linear-gradient(to bottom, rgba(255,0,0,0), #4d4d4d); /* For Firefox 3.6 to 15 */
}
/***********/
#ns_page {padding-top: 5px; padding-bottom: 35px;}
#ns_page h3 {text-align: left; font-size: 28px; color: #94c640; padding: 30px 0;}
.ns_box h4{font-weight: bold; margin-bottom: 0;margin-top:0;  cursor: pointer;}
.ns_view {font-size: 12px; font-style: italic;padding: 5px 0;color: #6e6e6e}
.ns_view span{margin-right: 20px;}
.ns_box a {color: #333;display: block;overflow: hidden;
}
.ns_box img {margin-right: 6px; -webkit-transition: all 0.7s ease;transition: all 0.7s ease;
}
.ns_box img:hover{-moz-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);box-shadow: -1px 0px 11px rgba(0, 0, 0, 0.2);-webkit-transform:scale(1.3);transform:scale(1.3);}
.ns_box_img {height: 158px;border: 0px solid rgba(204, 204, 204, 1.46);padding: 0px}
#ns_str .ns_box {margin-bottom: 50px;}
#ns_str .ns_box h4 {margin: 0;}
#ns_srch #ns_srch_tt h4 {background: #19a8e0;padding: 12px;margin: 0;text-align: center;font-weight: bold;color: white;}
#ns_srch .panel-body {border: 0;}
#ns_srch .panel-heading {border: 0; border-radius: 0;}
#ns_srch .panel-heading:hover {background: #c5c4c4; color: white;}
#ns_srch .panel-body {padding: 0 0 0 40px;}
#ns_tag {background: #f6f6fb; padding: 20px;}
#ns_tag hr {border: 1px solid #797877;}
.ns_tg_tags {margin: 8px 0px; display: inline-block;}
.ns_tg_tags a{padding: 7px 5px; border: 1px solid #ddd; color: #797877;}
.xem{width: 20px;text-align: center;}
.cmt{width: 15px;text-align: center;display: none;}
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
			echo "Tin Mới";
	?>
	</span>
</h3>

<?php if (!$news_line) { ?>
	<div class="col-md-offset-5 col-xs-offset-4">
		<p style="font-style: italic;font-weight: bold;">Không có dữ liệu</p>
	</div>
 
<?php } else { 
	foreach ($news_line as $item){ ?>
	
<div class="col-md-12 ns_box">
	<div class="row">
		<div class="col-md-5 ns_img ns_box_img">
		<?php 
			$str_title = $this->convert_vi_to_en($item['name']);
			$nametype = ServiceType::model()->findByPK($item['id_service_type']);
			$str_type = $this->convert_vi_to_en($nametype['name']);
		?>
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu/<?php echo $str_type;?>/<?php echo $str_title;?>-<?php echo $item['id'];?>/lang/vi"><img style="width: 100%" src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/service/
			<?php 
			if(isset($item['image']))
			{
				echo "lg/".$item['image'];
			}
			else{
				echo "no_image.png";
			}
			?>" 
			alt="" class="img-responsive"></a>
		</div>
		<div class="col-md-7">
			<h4><a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu/<?php echo $str_type;?>/<?php echo $str_title;?>-<?php echo $item['id'];?>/lang/vi">
				<?php $title = strip_tags($item['name']);

				if (strlen($title) > 42) {

				    $stringCut = substr($title, 0, 42);

				    $title = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
				} ?>
				<p><?php echo $title; ?></p>
			</a></h4>
			<div class="ns_view">
				<span>Ngày <?php echo $item['createdate']; ?></span>
				<span><img src="<?php echo Yii::app()->params['image_url']; ?>/images/xem.png" class="xem"><?php echo $item['total_view']; ?></span>
		<span><img src="<?php echo Yii::app()->params['image_url']; ?>/images/cmt.png" class="cmt"></span>
			</div>
			<div style="color: rgb(33, 32, 32)">
				<?php $description = strip_tags($item['content']);

				if (strlen($description) > 130) {

				    $stringCut = substr($description, 0, 130);

				    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
				} ?>
				<p style="height:50px;"><?php echo $description; ?></p>
			</div>
			<div>
				
				<p><a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu/<?php echo $str_type;?>/<?php echo $str_title;?>-<?php echo $item['id'];?>/lang/vi"><button type="button" class="btn btn_blue">XEM THÊM</button></a></p>
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