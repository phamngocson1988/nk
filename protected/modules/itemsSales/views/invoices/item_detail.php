<?php $baseUrl = Yii::app()->getBaseUrl(); ?>

<tr class="currentRow t<?php echo $i; ?>">
    <!-- MA DICH VU -->
    <td class='qc1'>
        <?php
            echo $form->dropDownList($invoice_detail, "[$i]id_service", array(), array(
                'class' => 'form-control group_services preventUpdate',
                'required' => true
            ));
            echo $form->hiddenField($invoice_detail, "[$i]code_service", array('class' => 'group_code_service'));
            echo $form->hiddenField($invoice_detail, "[$i]id_invoice_item", array('class' => 'group_id', 'value' => 0));
            echo $form->hiddenField($invoice_detail, "[$i]id_quotation_item", array('class' => 'group_id_quotation', 'value' => 0));
        ?>
    </td>

    <!-- TEN DICH VU -->
    <td class='qc2'>
        <?php
            echo $form->textField($invoice_detail, "[$i]description", array(
                'class' => 'form-control group_des cal_ans',
                'placeholder' => 'Tên dịch vụ',
                'readOnly' => true,
            ));
        ?>
    </td>

    <!-- BAC SY -->
    <td class='qc3'>
        <?php
            $dt = array();
            if (Yii::app()->user->getState("group_id") == 3) {
                $dt = array(Yii::app()->user->getState("user_id") => Yii::app()->user->getState("name"));
            }
            echo $form->dropDownList($invoice_detail, "[$i]id_user", $dt, array(
                'class' => 'form-control group_dentist preventUpdate',
                'required' => false,
            ));
        ?>
    </td>

    <!-- SO RANG -->
    <td class='qc4' data-toggle="tooltip">
        <?php
            echo $form->textField($invoice_detail, "[$i]teeth", array(
                'class' => 'form-control group_teeth preventUpdate',
                'placeholder' => 'Răng số'
            ));
        ?>
    </td>

    <!-- DON GIA -->
    <td class='qc5'>
        <?php
            echo $form->textField($invoice_detail, "[$i]unit_price", array(
                'class' => 'form-control group_unit autoNum text-right preventUpdate cal_ans',
                'placeholder' => '0',
                'readOnly' => true
            ));
            echo $form->hiddenField($invoice_detail, "[$i]flag_price", array('class' => 'flag_price', 'value' => 1));
        ?>
    </td>

    <!-- SO LUONG -->
    <td class='qc6'>
        <?php
            echo $form->textField($invoice_detail, "[$i]qty", array(
                'class' => 'form-control group_qty autoNum text-right preventUpdate',
                'value' => '1',
            ));
        ?>
    </td>

    <!-- THANH TIEN -->
    <td class='qc7'>
        <?php
            echo $form->textField($invoice_detail, "[$i]amount", array(
                'class' => 'form-control group_amount autoNum text-right cal_sum cal_ans preventUpdate',
                'value' => '0',
                'readOnly' => true
            ));
        ?>
    </td>

    <!-- DIEU TRI -->
    <td class="qc8">
        <span data-toggle="tooltip" title="Điều trị">
            <?php
                echo $form->hiddenField($invoice_detail, "[$i]status", array('value' => 1));
                echo $form->hiddenField($invoice_detail, "[$i]isDel", array('class'=>'group_delete', 'value' => '0'));
            ?>
        </span>

        <span>
            <a data-toggle="tooltip" title="Xóa" class="sCDiscount">
                <img src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon remove_field" alt="">
            </a>
        </span>
    </td>
</tr>