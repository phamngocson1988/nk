<?php $baseUrl = Yii::app()->getBaseUrl(); ?>

<?php foreach ($quote_services as $key => $value): ?>
<tr class="currentRow t<?php echo $key; ?>">

<?php $readOnly = $value['status']?'readOnly':'';
    $disabled = $value['status']?true:false;
    $key      = $key + 1;

    // service
    echo "<td class='padding_left_0 qc1'>";
     if ($value['id_service'] != '' && $value['id_service'] != 0) {
        echo $form->dropDownListGroup($value, "[$key]id_service",array('widgetOptions'=>array('data'=>array($value['id_service']=>$value['code_service']),'htmlOptions'=>array('required'=>true,'class'=>'group_services cal group','disabled'=>$disabled)),'labelOptions' => array("label" => ''))); 
    }
    elseif ($value['id_product'] != '' && $value['id_product'] != 0) {
        echo $form->dropDownListGroup($value, "[$key]id_product",array('widgetOptions'=>array('data'=>array($value['id_product']=>$value['description']),'htmlOptions'=>array('required'=>true,'placeholder'=>'Số lượng','class'=>'group_product cal group','disabled'=>$disabled)),'labelOptions' => array("label" => ''))); 
    }
    elseif ($value['id_discount'] != '' && $value['id_discount'] !=0) {
        echo $form->hiddenField($value,"[$key]id_discount",array('value'=>$value['id_discount']));
        echo $form->textFieldGroup($value,"[$key]description",array('widgetOptions'=>array('htmlOptions'=>array('required'=>false,'class'=>'cal_ans cal','readonly'=>true, 'value'=>$value['description'])),'labelOptions' => array("label" => '')));
    }
    echo $form->hiddenField($value,"[$key]code_service",array('class'=>'quote_code_service'));
    echo "</td>";

    // Ten dich vu
    echo "<td class=''>";
    echo $form->textFieldGroup($value,"[$key]description",array('widgetOptions'=>array('htmlOptions'=>array('readOnly' => true,'placeholder'=>'Tên dịch vụ','class'=>'quote_des cal_ans')),'labelOptions' =>array("label" => '')));
    echo "</td>";
 
    // dentist
    echo "<td class='qc2'>";
    echo $form->dropDownListGroup($value, "[$key]id_user",array('widgetOptions'=>array('data'=>array($value['id_user']=>$value['user_name']),'htmlOptions'=>array('required'=>false,'placeholder'=>'Số lượng','class'=>'group_dentist','disabled'=>$disabled)),'labelOptions' => array("label" => ''))); 
    echo "</td>";

    // so rang
    echo "<td class='qc3'>";
    echo $form->textFieldGroup($value,"[$key]teeth",array('widgetOptions'=>array('htmlOptions'=>array('required'=>true,'placeholder'=>'Số răng','value'=>$value['teeth'],'class'=>'cal_teeth',$readOnly=>$readOnly)),'labelOptions' => array("label" => '')));
    echo $form->hiddenField($value,"[$key]qty",array('class'=>'cal_qty','value'=>$value['qty']));
    echo "</td>"; ?>

    <!-- đơn giá -->
    <td class='qc4'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('unit_price',$value['unit_price'],array('placeholder'=>'Đơn giá','class'=>'group_unit autoNum form-control',$readOnly=>$readOnly)); 
            echo $form->hiddenField($value,"[$key]unit_price",array('class'=>'s_group_unit'));
            echo $form->hiddenField($value,"[$key]flag_price",array('class'=>'flag_price'));
       ?>
    </div>
    </td>

     <!-- Thuế -->
    <td class='qc5'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('tax',$value['tax'],array('placeholder'=>'Thuế','readOnly' => true,'class'=>' group_tax cal_tax cal_ans autoNum form-control')); 
            echo $form->hiddenField($value,"[$key]tax",array('class'=>'s_group_tax'));
        ?>
    </div>
    </td>

    <!-- Thành tiền -->
    <td class='qc6'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('amount',$value['amount'],array('placeholder'=>'Thành tiền','readOnly' => true,'class'=>'inp_price group_amount cal_ans cal_sum autoNum form-control')); 
            echo $form->hiddenField($value,"[$key]amount",array('class'=>'s_group_amount'));
        ?>
    </div>
    </td>

    <td class="qc7">
    <span data-toggle="tooltip" title="Điều trị">
<?php 
    echo $form->checkBox($value,"[$key]status",array('class'=>'chk chk_remove','disabled'=>$disabled));
    $status = $value['status'];
    echo $form->hiddenField($value,"[$key]quote_old",array('value'=>$status));
    echo $form->hiddenField($value,"[$key]id");
    echo $form->hiddenField($value,"[$key]del",array('value'=>0, 'class'=>'quote_del'));
?>
    </span>
    <span style="">
        <?php if ($value['amount'] >0): ?>
            <a href="" data-toggle="tooltip" title="Khuyến mãi" class="sCDiscount"><img src="<?php echo $baseUrl; ?>/images/icon_sb_left/sale.png" class="sIcon addIDis" alt=""></a>
        <?php endif ?>
    </span>
    <span>
        <?php if ($status == 0): ?>
            <a href="" title="Xóa" class="sCDiscount"><img src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon remove_field_hidden" alt=""></a>
        <?php endif ?>
    </span>
    </td>

</tr>
<?php endforeach ?>