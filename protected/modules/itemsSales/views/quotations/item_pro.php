<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<tr class="currentRow t<?php echo $i; ?>">
 <?php 

    echo "<td class='padding_left_0 qc1'>";
    echo $form->hiddenField($quote_services,"[$i]id_discount",array('value'=>'id_discount_val'));
    echo $form->textFieldGroup($quote_services,"[$i]description",array('widgetOptions'=>array('htmlOptions'=>array('required'=>false,'class'=>'cal_ans cal','readonly'=>true, 'value'=>'discount_val')),'labelOptions' => array("label" => '')));
    echo "</td>";

    // dentist
    $arrUser = array();
    if(Yii::app()->user->getState('group_id') == Yii::app()->params['id_group_dentist']) {
        $arrUser = array(Yii::app()->user->getState('user_id')=>Yii::app()->user->getState('user_name'));
    }
    echo "<td class='qc2'>";
    echo $form->dropDownListGroup($quote_services, "[$i]id_user",array('widgetOptions'=>array('data'=>$arrUser,'htmlOptions'=>array('required'=>false,'placeholder'=>'Số lượng','class'=>'group_dentist')),'labelOptions' => array("label" => ''))); 
    echo "</td>";

    // so rang
    echo "<td class='qc3'>";
    echo $form->textFieldGroup($quote_services,"[$i]teeth",array('widgetOptions'=>array('htmlOptions'=>array('required'=>false,'placeholder'=>'Số răng','value'=>'1','class'=>'', 'readonly' => true)),'labelOptions' => array("label" => '')));
    echo $form->hiddenField($quote_services,"[$i]qty",array('class'=>'cal_qty','value' => 1));
    echo "</td>"; ?>

    <!-- đơn giá -->
    <td class='qc4'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('unit_price','unit_price_val',array('placeholder'=>'Đơn giá','class'=>' group_unit cal_ans autoNum form-control')); 
            echo $form->hiddenField($quote_services,"[$i]unit_price",array('class'=>'s_group_unit','value'=>'unit_price_val'));
        ?>
    </div>
    </td>

    <!-- Thuế -->
    <td class='qc5'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('tax',0,array('placeholder'=>'N/A','readOnly' => true,'class'=>'inp_price group_tax cal_ans cal_tax autoNum form-control')); 
            echo $form->hiddenField($quote_services,"[$i]tax",array('class'=>'s_group_tax'));
        ?>
    </div>
    </td>

    <!-- Thành tiền -->
    <td class='qc6'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('amount','unit_price_val',array('placeholder'=>'Thành tiền','readOnly' => true,'class'=>'inp_price group_amount cal_ans cal_sum autoNum form-control')); 
            echo $form->hiddenField($quote_services,"[$i]amount",array('class'=>'s_group_amount','value'=>'unit_price_val'));
        ?>
    </div>
    </td>

<?php
    echo "<td class='qc7'>";
    echo '<span data-toggle="tooltip" title="" data-original-title="Điều trị">';
        echo $form->checkBox($quote_services,"[$i]status",array('class'=>'chk'));
        echo $form->hiddenField($quote_services,"[$i]quote_old",array('value'=>'0'));
        echo $form->hiddenField($quote_services,"[$i]id");
    echo "</span>";
?>
    <span style="padding: 4px;">
        <a href="" data-toggle="tooltip" title="Xóa" class="sCDiscount"><img style=" width: 15px;" src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon remove_field" alt=""></a>
    </span>
    </td>
</tr>

<script>
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
        $('.autoNum').autoNumeric('init',numberOptions);
    $('[data-toggle="tooltip"]').tooltip();
</script>