<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<tr class="currentRow t<?php echo $i; ?>" id="">

 <?php 
    $label = array("label" => '');
    // Ma dich vu
    echo "<td class='padding_left_0 qc1'>";
    echo $form->dropDownListGroup($quote_services,"[$i]id_service",array('widgetOptions'=>array('data'=>$dataService,'htmlOptions'=>array('required'=>true,'class'=>'group_services cal group')),'labelOptions' => $label));
    //echo $form->hiddenField($quote_services,"[$i]description",array('class'=>'quote_des','value'=>$serName));
    echo $form->hiddenField($quote_services,"[$i]code_service",array('class'=>'quote_code_service','value'=>''));
    echo "</td>";

    // Ten dich vu
    echo "<td class=''>";
    echo $form->textFieldGroup($quote_services,"[$i]description",array('widgetOptions'=>array('htmlOptions'=>array('readOnly' => true,'placeholder'=>'Tên dịch vụ','value'=>'','class'=>'quote_des cal_ans')),'labelOptions' => $label));
    echo "</td>";

    // Bac sy
    $dt = array();
    if (Yii::app()->user->getState("group_id") == 3) {
        $dt = array(Yii::app()->user->getState("user_id") => Yii::app()->user->getState("username"));
    }
    echo "<td class='qc2'>";
    echo $form->dropDownListGroup($quote_services, "[$i]id_user",array('widgetOptions'=>array('data'=>$dt,'htmlOptions'=>array('required'=>false,'placeholder'=>'Người thực hiện','class'=>'group_dentist')),'labelOptions' => array("label" => '')));
    echo "</td>";

    // so rang
    echo "<td class='qc3'>";
    echo $form->textFieldGroup($quote_services,"[$i]teeth",array('widgetOptions'=>array('htmlOptions'=>array('required'=>true,'placeholder'=>'Số răng','value'=>'1','class'=>'cal_teeth')),'labelOptions' => array("label" => '')));
    echo $form->hiddenField($quote_services,"[$i]qty",array('class'=>'cal_qty','value'=>1));
    echo "</td>"; ?>

    <!-- đơn giá -->
    <td class='qc4'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('unit_price',$unit,array('placeholder'=>'Đơn giá','class'=>'inp_price group_unit autoNum form-control text-right')); 
            echo $form->hiddenField($quote_services,"[$i]unit_price",array('class'=>'s_group_unit','value'=>$unit));
            echo $form->hiddenField($quote_services,"[$i]flag_price",array('class'=>'flag_price', 'value'=>1));
        ?>
    </div>
    </td>

    <!-- Thuế -->
    <td class='qc5'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('tax',$tax,array('placeholder'=>'Thuế','readOnly' => true,'class'=>'inp_price group_tax cal_tax cal_ans autoNum form-control')); 
            echo $form->hiddenField($quote_services,"[$i]tax",array('class'=>'s_group_tax','value'=>$tax));
        ?>
    </div>
    </td>

    <!-- Thành tiền -->
    <td class='qc6'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('amount',$sum,array('placeholder'=>'Thành tiền','readOnly' => true,'class'=>'inp_price group_amount cal_ans cal_sum autoNum form-control')); 
            echo $form->hiddenField($quote_services,"[$i]amount",array('class'=>'s_group_amount','value'=>$sum));
        ?>
    </div>
    </td>

    <td class="qc7">
    <span data-toggle="tooltip" title="Điều trị">
<?php    
    echo $form->checkBox($quote_services,"[$i]status",array('class'=>'chk'));
    echo $form->hiddenField($quote_services,"[$i]quote_old",array('value'=>'0'));
?>      
    </span>
    <span style="padding: 4px;">
        <a href="" data-toggle="tooltip" title="Khuyến mãi" class="sCDiscount"><img src="<?php echo $baseUrl; ?>/images/icon_sb_left/sale.png" class="sIcon addIDis" alt=""></a>
    </span>
    <span>
        <a href="" data-toggle="tooltip" title="Xóa" class="sCDiscount"><img src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon remove_field" alt=""></a>
    </span>
    
    </td>
</tr>

<script>
    $(function(){
        var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
        $('.autoNum').autoNumeric('init',numberOptions);
    })
</script>