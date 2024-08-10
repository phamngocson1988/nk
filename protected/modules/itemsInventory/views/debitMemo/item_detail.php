<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<tr class="currentRow t<?php echo $i; ?>">
	<td style="padding-top: 25px;" class="th1">
		<?php echo $i; ?>	
	</td>
	<td style="padding-top: 20px;" class="th2">
		<?php 
			echo $form->dropDownList($modelDetail, "[$i]id_material", array(), array(
                'class' 		=> 'form-control listMaterial',
                'required' 		=> true
            ));
		?>
	</td>
    <td  style="padding-top: 20px;" class="th3">
        <?php
            echo $form->textField($modelDetail, "[$i]expiration_date", array(
                'class'         => 'form-control expiration_date',
                'value'         => '',
                'placeholder'   => 'Ngày hết hạn',
                'required'      => 'true',
                'readonly'      => true,
            ));
        ?>
    </td>
	<td style="padding-top: 20px;" class="th4">
		<?php
            echo $form->textField($modelDetail, "[$i]qty", array(
                'class' 		=> 'form-control qty',
                'value'			=> '1',
                'placeholder' 	=> 'Số lượng',
                'oninput'       => 'maxLengthCheck(this)',
                'required' 		=> true
            ));
        ?>
	</td>
	<td style="padding-top: 20px;" class="th5">
		<?php
            echo $form->textField($modelDetail, "[$i]unit", array(
                'class' 		=> 'form-control unit',
                'placeholder' 	=> 'Đơn vị tính',
                'readonly'      => true
            ));
        ?>
	</td> 
	<td style="padding-top: 20px;" class="th6">
		<?php
            echo $form->textField($modelDetail, "[$i]amount", array(
                'class' 		=> 'form-control amount autoNum',
                'value'			=> 0,
                'placeholder' 	=> 'Đơn giá',
                'readonly' 		=> true
            ));
        ?>
	</td>
	<td class="th7">
		<?php
            echo $form->textArea($modelDetail, "[$i]note", array(
                'class' 		=> 'form-control',
                'placeholder' 	=> 'Nhập lý do trả',
            ));
        ?>
	</td>  
	<td style="padding-top: 25px;" class="td8">
        <span class="remove_field">
            <img src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon " alt="">
        </span>
    </td>
</tr> 