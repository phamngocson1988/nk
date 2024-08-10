<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<tr class="currentRow">
 <?php 
    echo "<td class='padding_left_0 qc1'>";
    echo $i;
    echo "</td>";
    
   echo "<td class='padding_left_0 qc1'>";
    echo $form->dropDownListGroup($orderdetail, "[$i]id_product",array('widgetOptions'=>array('htmlOptions'=>array('required'=>true,'placeholder'=>'Số lượng','class'=>'group_product cal group')),'labelOptions' => array("label" => ''))); 
    echo "</td>";



    // qty
    echo "<td class='qc3'>";
    echo $form->textFieldGroup($orderdetail,"[$i]qty",array('widgetOptions'=>array('htmlOptions'=>array('required'=>false,'placeholder'=>'Số lượng','value'=>1,'class'=>'group_qty cal')),'labelOptions' => array("label" => '')));
    echo "</td>"; ?>

    <!-- đơn giá -->
    <td class='qc4'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('unit_price','',array('placeholder'=>'Đơn giá','readOnly' => true,'class'=>'inp_price group_unit cal_ans autoNum form-control')); 
            echo $form->hiddenField($orderdetail,"[$i]unit_price",array('class'=>'s_group_unit'));
        ?>
    </div>
    </td>


    <!-- Thành tiền -->
    <td class='qc6'>
    <div class="form-group">
        <label></label>
        <?php 
            echo CHtml::textField('amount','',array('placeholder'=>'Thành tiền','readOnly' => true,'class'=>'inp_price group_amount cal_ans cal_sum autoNum form-control')); 
            echo $form->hiddenField($orderdetail,"[$i]amount",array('class'=>'s_group_amount'));
        ?>
    </div>
    </td>

<?php
    echo $form->hiddenField($orderdetail,"[$i]order_old",array('value'=>'0'));
    echo $form->hiddenField($orderdetail,"[$i]id");
?>
    <td>
        <div class="form-group">
            <a href="" title="Xóa" class="sCDiscount"><img src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon remove_field" alt=""></a>
        </div>
    </td>
</tr>
<?php $this->renderPartial('_js'); ?>