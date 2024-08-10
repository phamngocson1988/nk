<?php $baseUrl = Yii::app()->getBaseUrl(); ?>

<tr class="currentRow t<?php echo $i; ?>">
    <!-- MA DICH VU -->
    <td class='qc1'>
        <?php
            echo $form->dropDownList($quote_services, "[$i]id_service", array(), array(
                'class' => 'form-control group_services preventUpdate',
                'required' => true
            ));
            echo $form->hiddenField($quote_services, "[$i]code_service", array('class' => 'quote_code_service'));
            echo $form->hiddenField($quote_services, "[$i]id", array('class' => 'group_id'));
        ?>
    </td>

    <!-- TEN DICH VU -->
    <td class='qc2'>
        <?php
            echo $form->textField($quote_services, "[$i]description", array(
                'class' => 'form-control quote_des cal_ans',
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
            echo $form->dropDownList($quote_services, "[$i]id_user", $dt, array(
                'class' => 'form-control group_dentist preventUpdate',
                'required' => false,
            ));
        ?>
    </td>

    <!-- SO RANG -->
    <td class='qc4' data-toggle="tooltip">
        <?php
            echo $form->textField($quote_services, "[$i]teeth", array(
                'class' => 'form-control group_teeth preventUpdate',
                'placeholder' => 'Răng số'
            ));
        ?>
    </td>

    <!-- DON GIA -->
    <td class='qc5'>
        <?php
            echo $form->textField($quote_services, "[$i]unit_price", array(
                'class' => 'form-control group_unit autoNum text-right preventUpdate',
                'placeholder' => '0',
            ));
            echo $form->hiddenField($quote_services, "[$i]flag_price", array('class' => 'flag_price', 'value' => 1));
        ?>
    </td>

    <!-- SO LUONG -->
    <td class='qc6'>
        <?php
            echo $form->textField($quote_services, "[$i]qty", array(
                'class' => 'form-control group_qty autoNum text-right preventUpdate',
                'placeholder' => '1',
            ));
        ?>
    </td>

    <!-- THANH TIEN -->
    <td class='qc7'>
        <?php
            echo $form->textField($quote_services, "[$i]amount", array(
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
                echo $form->checkBox($quote_services, "[$i]status", array('class' => 'chk preventUpdate'));
                echo $form->hiddenField($quote_services, "[$i]isDel", array('class'=>'group_delete','value' => '0'));
            ?>
        </span>

        <span>
            <a data-toggle="tooltip" title="Xóa" class="sCDiscount">
                <img src="<?php echo $baseUrl; ?>/images/icon_sb_left/delete-def.png" class="sIcon remove_field" alt="">
            </a>
        </span>
    </td>
</tr>