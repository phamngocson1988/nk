<label class="fl">Quận huyện</label>
<select class="custProfileInput yellow_hover blue_focus fl" onchange="updateCustomer(<?php echo $id; ?>)" id="county">
	<option value="0">Chọn quận huyện</option>
	<?php foreach ($Localtiondistrict as $key => $value): ?>
		<?php
		$selected = "";
		if ($county == $value["districtID"]) {
			$selected = "selected";
		}
		?>
		<option value="<?php echo $value["districtID"];?>" <?php echo $selected; ?>>
			<?php echo $value["districtDescriptionVn"];?>
		</option>
	<?php endforeach ?>
</select>                       
<div class="clearfix"></div>