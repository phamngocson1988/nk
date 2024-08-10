<div style="min-height:750px">
	<style type="text/css">
		.content-text-service .text-service{
			color: #6e6e6e;
		}
		#content_service img{
			width: 100%;
		}
	</style>
	<?php 
		$service = 	PIntroduceServices::model()->findByPk(1);
	?>
	<?php if($lang=='vi'){?>
		<div id="content_service">
			<div style="font-size: 25px;color: #19a8e0;font-weight: bold;text-transform: uppercase; margin-bottom: 20px"><?php echo $service->title; ?></div>

			<?php echo $service->content; ?>
		</div>
	<?php }else{?>
		<div id="content_service">
			<?php if($service->title_en && $service->content_en){?>
				<div style="font-size: 25px;color: #19a8e0;font-weight: bold;text-transform: uppercase; margin-bottom: 20px"><?php echo $service->title_en; ?></div>

				<?php echo $service->content_en; ?>
			<?php }else{ echo "Updating!";}?>
		</div>
	<?php }?>
</div>
