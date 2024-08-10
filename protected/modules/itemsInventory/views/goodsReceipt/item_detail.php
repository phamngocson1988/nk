<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<tr class="currentRow t<?php echo $i; ?>">
	<td style="padding-top: 15px;">
		<?php echo $i; ?>	
	</td>
	<td>
		<?php 
			echo $form->dropDownList($goodsReceiptDetail, "[$i]id_material", array(), array(
                'class' 		=> 'form-control listMaterial',
                'required' 		=> true
            ));
		?>
	</td>
	<td>
		<?php
            echo $form->textField($goodsReceiptDetail, "[$i]expiration_date", array(
                'class' 		=> 'form-control frm_datepicker expiration_date',
                'value'			=> '',
                'placeholder' 	=> 'Ngày hết hạn',
                'required'		=> 'true'
            ));
        ?>
	</td>
	<td>
		<?php
            echo $form->textField($goodsReceiptDetail, "[$i]qty", array(
                'class' 		=> 'form-control qty',
                'placeholder' 	=> 'Số lượng',
                'required' 		=> true,
                'value'         => 1
            ));
        ?>
	</td>
	<td>
		<?php
            echo $form->textField($goodsReceiptDetail, "[$i]unit", array(
                'class' 		=> 'form-control unit',
                'placeholder' 	=> 'Đơn vị tính'
            ));
        ?>
	</td>
	<td>
		<?php
            echo $form->textField($goodsReceiptDetail, "[$i]amount", array(
                'class' 		=> 'form-control amount autoNum',
                'value'			=> 0,
                'placeholder' 	=> 'Đơn giá',
                'required' 		=> true
            ));
        ?>
	</td> 
	<td>
		<?php
            echo $form->textField($goodsReceiptDetail, "[$i]sumamount", array(
                'class' 		=> 'form-control sumamount autoNum',
                'value'			=> 0,
                'placeholder' 	=> 'Thành tiền',
                'readonly'		=> 'readonly'
            ));
            echo $form->hiddenField($goodsReceiptDetail, "[$i]id", array('class' => 'id_detail'));
            echo $form->hiddenField($goodsReceiptDetail,"[$i]status",array('class'=>'statusNK'));
        ?>
        <input class="delOld"  id="delOld" type="hidden" value="0">
	</td>
    <td style="padding-top: 15px;">
        <span class="remove_field">
            <img src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon " alt="">
        </span>
    </td>
</tr>
