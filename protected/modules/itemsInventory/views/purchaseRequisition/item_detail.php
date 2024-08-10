<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<tr class="currentRow t<?php echo $i; ?>">
	<td style="padding-top: 15px;" class="th1">
		<?php echo $i; ?>	
	</td>
	<td>
		<?php 
			echo $form->dropDownList($purchaseRequisitionDetail, "[$i]id_material", array(), array(
                'class' 		=> 'form-control listMaterial',
                'required' 		=> true
            ));
		?>
	</td>
	<td>
		<?php
            echo $form->textField($purchaseRequisitionDetail, "[$i]qty", array(
                'class' 		=> 'form-control qty',
                'value'			=> '1',
                'placeholder' 	=> 'Số lượng',
                'required' 		=> true
            ));
        ?>
	</td>
	<td>
		<?php
            echo $form->textField($purchaseRequisitionDetail, "[$i]unit", array(
                'class' 		=> 'form-control unit',
                'placeholder' 	=> 'Đơn vị tính',
            ));
            echo $form->hiddenField($purchaseRequisitionDetail, "[$i]id", array('class' => 'id_detail'));
            echo $form->hiddenField($purchaseRequisitionDetail,"[$i]status",array('class'=>'statusPX'));
        ?>
        <input class="delOld"  id="delOld" type="hidden" value="0">
	</td>
	<td style="padding-top: 15px;">
		<span class="remove_field">
	        <img src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon " alt="">
	    </span>
	</td>
</tr>