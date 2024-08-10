<div id="ns_srch_tt">
	<h4>- BẢNG GIÁ -</h4>
</div>
<div id="wrapper">
	<dl>
	<?php
		$type_price = PricesType::model()->findAll();
		foreach($type_price as $item){ 
	?>
		<dt><a href="#"><?php echo $item['name'] ?></a></dt>
		<?php 
			$id_type = $item['id'];
			$name_price = Prices::model()->findAllByAttributes(array('id_prices_type'=>$id_type));
			if($name_price)
			{
		?>
		<dd>
			<ul>
			<?php	
				foreach($name_price as $item){
				$str = $item['name'];
				$str = $this->convert_vi_to_en($str);
			?>
				<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/bang-gia/<?php echo $str;?>-<?php echo $item['id']; ?>"><?php echo $item['name'];?></a></li>
			<?php } ?>
			</ul>
		</dd> 
		<?php } ?>
	<?php } ?>
	</dl>
</div>