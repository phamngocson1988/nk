<?php $baseUrl = Yii::app()->getBaseUrl(); ?>

<?php foreach ($orderdetail as $key => $value): ?>
<tr class="currentRow">

<?php $readOnly = $value['status']?'readOnly':'';
    $disabled = $value['status']?true:false;
    $key = $key + 1;

    // service
    echo "<td class='padding_left_0 qc1'>";
    echo $key;
    echo "</td>";
    echo "<td class='padding_left_0 qc1'>";
    if ($value['id_product'] != '' && $value['id_product'] != 0) {
        echo $form->dropDownListGroup($value, "[$key]id_product",array('widgetOptions'=>array('data'=>array($value['id_product']=>$value['product_name']),'htmlOptions'=>array('required'=>true,'placeholder'=>'Số lượng','class'=>'group_product cal group','disabled'=>$disabled)),'labelOptions' => array("label" => ''))); 
    } 
    echo "</td>";

    // qty
    echo "<td class='qc3'>";
    echo $form->textFieldGroup($value,"[$key]qty",array('widgetOptions'=>array('htmlOptions'=>array('required'=>false,'placeholder'=>'Số lượng','class'=>'group_qty cal',$readOnly=>$readOnly)),'labelOptions' => array("label" => '')));
    echo "</td>"; ?>

    <!-- đơn giá -->
    <td class='qc4'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('unit_price',$value['unit_price'],array('placeholder'=>'Đơn giá','readOnly' => true,'class'=>'inp_price group_unit cal_ans autoNum form-control')); 
            echo $form->hiddenField($value,"[$key]unit_price",array('class'=>'s_group_unit'));
            
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

<?php 
    $status = $value['status'];
    echo $form->hiddenField($value,"[$key]order_old",array('value'=>$status));
   echo $form->hiddenField($value,"[$key]id");
    echo $form->hiddenField($value,"[$key]del",array('value'=>0, 'class'=>'order_del'));
?>

<td>
<?php if ($status == 1): ?>
    <div class="form-group">
        <a href="" title="Xóa" class="sCDiscount" ><img src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon remove_field_hidden" alt=""></a>
    </div>
<?php endif ?>
</td>

</tr>
<?php endforeach ?>
