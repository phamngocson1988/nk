
<style type="text/css">
.content-text-service .text-service{
color: #6e6e6e;
}
#hdnk{
height:165px;
}
.ns_img {
overflow: hidden;
position: relative;
}
</style>

<?php
if($lang=='vi'){
	if($service){
		foreach($service as $tg){
		?>
		<div id="title_sv" style="font-size: 25px;color: #19a8e0;font-weight: bold;text-transform: uppercase;"><?php echo $tg['name']?></div><br>

		<div style="min-height:500px;">
		<?php 
		echo $tg['content']!=""?$tg['content']:"Dữ liệu đang cập nhật"; ?>

		<?php   $id = $tg['id'];
				$service_1 = Service::model()->findAll();
			    $serviceDetails = array_filter($service_1,function($v) use ($id){
	            return $v['id_service_type'] == $id;
	        });
		?>  
			<?php foreach ($serviceDetails as $key => $value) { ?>
			<?php 
				$nametype = ServiceType::model()->findByPK($id);
				$str_type = $this->convert_vi_to_en($nametype['name']);
				$str_title = $this->convert_vi_to_en($value['name']);
			?>
				
			<div class="col-sm-6 col-sm-4 col-md-3"  > 
				<div class="grid-item" style="border: 1px solid #ccc;margin-bottom:20px;">
					<div class="ns_img" id="hdnk">
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu/<?php echo $str_type; ?>/<?php echo $str_title; ?>-<?php echo $value['id'];?>/lang/vi" >
							<img  src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/service/lg/<?php echo $value['image']?>" class="img-responsive" alt="" style="width:100%;">
						</a>
					</div>
					<div class="pr_ct" style="text-align:center;padding:10px;" >
						<p style="text-align:center;margin-top: 15px; "><?php echo $value['name'];?></p>
						<?php 
							$description = strip_tags($value['content']);
							if (strlen($description) > 80) {

							    $stringCut = substr($description, 0, 80);

							    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
							} ?> 

						<p style="color: #919190;"><?php echo $description; ?></p>
						
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu/<?php echo $str_type; ?>/<?php echo $str_title; ?>-<?php echo $value['id'];?>/lang/vi" >
						<button type="button" class="btn btn_green" style="margin-bottom: 15px; ">XEM THÊM</button> </a>
					</div>
				</div>
			</div>
			<?php }?>
		<?php }
	}else{
		echo "Dữ liệu đang cập nhật";
	}
}else{
	if($service){
		foreach($service as $tg){
		?>
		<div id="title_sv" style="font-size: 25px;color: #19a8e0;font-weight: bold;text-transform: uppercase;"><?php echo $tg['name_en']?></div><br>

		<div style="min-height:500px;">
		<?php 
		echo $tg['content_en']!=""?$tg['content_en']:"Updating!"; ?>

		<?php   $id = $tg['id'];
				$service_1 = Service::model()->findAll();
			    $serviceDetails = array_filter($service_1,function($v) use ($id){
	            return $v['id_service_type'] == $id;
	        });
		?>  
			<?php foreach ($serviceDetails as $key => $value) { ?>
			<?php 
				$nametype = ServiceType::model()->findByPK($id);
				$str_type = $this->convert_vi_to_en($nametype['name']);
				$str_title = $this->convert_vi_to_en($value['name']);
			?>
				
			<div class="col-sm-6 col-sm-4 col-md-3"  > 
				<div class="grid-item" style="border: 1px solid #ccc;margin-bottom:20px;">
					<div class="ns_img" id="hdnk">
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu/<?php echo $str_type; ?>/<?php echo $str_title; ?>-<?php echo $value['id'];?>/lang/en" >
							<img  src="<?php echo Yii::app()->request->baseUrl; ?>/upload/post/service/lg/<?php echo $value['image']?>" class="img-responsive" alt="" style="width:100%;">
						</a>
					</div>
					<div class="pr_ct" style="text-align:center; padding:10px" >
						<p style="text-align:center;margin-top:15px"><?php echo $value['name_en'];?></p>
						<?php 
							$description = strip_tags($value['content_en']);
							if (strlen($description) > 80) {

							    $stringCut = substr($description, 0, 80);

							    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
							} ?> 

						<p style="color: #919190;"><?php echo $description; ?></p>
						
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/dich-vu/<?php echo $str_type; ?>/<?php echo $str_title; ?>-<?php echo $value['id'];?>/lang/en" >
						<button type="button" class="btn btn_green" style="margin-bottom: 15px; ">SEE MORE</button> </a>
					</div>
				</div>
			</div>
			<?php }?>
		<?php }
	}else{
		echo "Updating!";
	}

}?>

	<br><br>
	</div>
<script type="text/javascript">
	 $('html, body').animate({
		        scrollTop: $("#title_sv").offset().top - 240
		    }, 2000);
</script>