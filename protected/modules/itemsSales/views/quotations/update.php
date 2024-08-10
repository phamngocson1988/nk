<style>
    .quote-table select.select2-hidden-accessible {bottom: 1%;}
    .quote-table .select2-container {min-width: 10px !important;}
    .quote-table span.select2-container--disabled span.select2-selection {background: white; border: 0;}
    .quote-table span.select2-container--disabled span.select2-selection .select2-selection__arrow {display: none;}

    .widthChooseService {border-top: 1px solid rgb(102, 175, 233) !important; width: 350px !important;}
    .widthChooseService .select2-results__options--nested li {padding-left: 30px !important;}

    .quote-table {padding: 0 19px;}

    .quote-table table thead {display: table; width: 100%; table-layout: fixed;}
    .quote-table table tbody {display: block; overflow: auto; max-height: 200px;}
    .quote-table table tbody tr {display: table; width: 100%; table-layout: fixed;}

    .quote-table table tr th {text-align: center; background: white; color: black; padding: 5px 0 7px;}
    .quote-table table tr td {padding: 4px 1px !important; border: 0;}

    .quote-table table tr .form-control {padding: 6px 5px;}
    .quote-table table tr .form-control[disabled] {background: white; border: 0; box-shadow: none; cursor: default;}
    .quote-table table tr img {width: 17px;}

    .frm-handl-quote #sSumo {padding-top: 10px; border-top: 2px solid #ddd;}
    .frm-handl-quote #sInvoice {border-bottom: 2px groove #ddd;}

    .frm-handl-quote .cal_ans {background: white; border: 0; box-shadow: none; cursor: default; text-align: right;}
    .frm-handl-quote .sbtnAdd {padding: 2px 6px; background: #94c63f; color: white;}
    .frm-handl-quote .Submit { background: #94c63f;}
    .frm-handl-quote .q_label {margin-top: 8px;}

    .qc1{width: 8%;} /* Ma dich vu */
    .qc2{width: 20%;} /* Ten dich vu */
    .qc3{width: 13%;} /* Nguoi thuc hien */
    .qc4{width: 13%;} /* So rang */
    .qc5{width: 11%;} /* Don gia */
    .qc6{width: 8%;} /* So luong */
    .qc7{width: 13%;} /* Thanh tien */
    .qc8{width: 6%; position: relative;} /* Dieu tri */
    .qc8 span:first-child {position: absolute; left: 10px; top: 10px;}
    .qc8 span:nth-child(2) {position: absolute; left: 30px; top: 8px;}
</style>

<div class="modal-dialog modal-lg" style="width: 1000px;">
    <div class="modal-content quote-edit-container">

    <div class="modal-header sHeader">
        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h3 id="modalTitle" class="modal-title">CẬP NHẬT BÁO GIÁ</h3>
    </div>

    <div class="modal-body">
        <div class="row">
            <?php
                $baseUrl = Yii::app()->getBaseUrl();
                $user_name = Yii::app()->user->getState('name');
                $user_id = Yii::app()->user->getState('user_id');
                $user_group = Yii::app()->user->getState('group_id');
                $user_branch = Yii::app()->user->getState('user_branch');
            ?>

            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'frm-update-quote',
                    'htmlOptions' => array('class' => 'frm-handl-quote', 'enctype' => 'multipart/form-data')
            )); ?>

            <div class="quote_info">
                <div class='col-md-4'>
                    <?php echo $form->dropDownListGroup($quote, 'id_branch', array(
                        'widgetOptions' => array(
                            'data' => $branchList,
                            'htmlOptions' => array('disabled' => true)
                        )));
                    ?>
                </div>

                <div class='col-md-2'>
                    <?php echo $form->textFieldGroup($quote, 'create_date', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'class' => 'frm_datepicker',
                                    'value' => date_format(date_create($quote['create_date']), 'd/m/Y'),
                                    'readOnly' => true
                        ))));
                    ?>
                </div>

                <div class='col-md-2'>
                    <?php echo $form->textFieldGroup($quote, 'complete_date', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'class' => 'frm_datepicker',
                                    'value' => date_format(date_create($quote['complete_date']), 'd/m/Y'),
                                )
                            ),
                        ));
                    ?>
                </div>

                <div class='col-md-3'>
                    <?php
                        echo $form->labelEx($quote, 'id_author');
                        echo CHtml::textField('author', $this->getUserName($quote['id_author']), array('class' => 'form-control', 'readOnly' => true));
                    ?>
                </div>

                <div class='clearfix'></div>

                <div class='col-md-4'>
                    <?php
                    if ($customerObj) {
                        echo $form->dropDownListGroup($quote, 'id_customer', array(
                                'widgetOptions' => array(
                                    'data' => CHtml::listData($customerObj, 'id', 'fullname'),
                                    'htmlOptions' => array('required' => true, 'readonly' => true)
                            )));
                    } else {
                        echo $form->dropDownListGroup($quote, 'id_customer', array(
                                'widgetOptions' => array(
                                    'htmlOptions' => array('required' => true)
                            )));
                    }
                    ?>
                </div>

                <?php $displaySegment = (!empty($customerSegment)) ? "" : "style='display:none;'"; ?>
                <div class='col-md-3 showSeg' <?php echo $displaySegment; ?>>
                    <?php
                        echo $form->dropDownListGroup($quote, 'id_segment', array(
                            'widgetOptions' => array(
                                'data' => CHtml::listData($customerSegment, 'id_segment', 'name'),
                                'htmlOptions' => array('class' => 'choseSeg', 'readOnly' => true),
                            )));
                    ?>
                </div>
            </div>

            <div class="quote_hidden">
                <?php echo $form->hiddenField($quote,'id'); ?>
                <input type="hidden" name="Quotation[id_group_history]" value="<?php echo $quote['id_group_history']; ?>">
                <input type="hidden" name="Quotation[id_schedule]" value="<?php echo $id_schedule; ?>">
                <input type="hidden" name="Quotation[priceBook]" id="priceBook">
            </div>

            <div id="usProduct" class="col-md-12 product quote-table">
                <table class="table sItem tableQuote">
                    <thead>
                        <tr>
                            <th class="qc1">Mã dịch vụ</th>
                            <th class="qc2">Tên dịch vụ</th>
                            <th class="qc3">Người thực hiện</th>
                            <th class="qc4">Số răng</th>
                            <th class="qc5">Đơn giá</th>
                            <th class="qc6">Số lượng</th>
                            <th class="qc7">Thành tiền</th>
                            <th class="qc8">Điều trị</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>
            </div>

            <div id="sSumo" class="col-md-12">
                <div class="row">
                    <div id="sMore" class="col-md-4">
                        <button id="upAddServices" class="btn sbtnAdd upsbtnAdd">
                            <span class="glyphicon glyphicon-plus"></span>
                            Dịch vụ
                        </button>
                    </div>

                    <div id="sInvoice" class="col-md-6 pull-right">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="margin-top: 8px;" class="col-md-6 text-right q_label control-label" for="sum_amount">Tổng cộng</label>
                                <div class='col-md-4'>
                                    <?php echo $form->textField($quote, 'sum_amount', array('required' => true, 'readOnly' => true, 'class' => 'cal_ans autoNum form-control')); ?>
                                </div>

                                <div class="col-md-2" id="upAddDis">
                                    <label class="control-label q_label">VND</label>
                                </div>

                                <div class="clearfix"></div>

                                <label style="margin-top: 8px;" class="col-md-6 text-right q_label control-label"></label>
                                <div class='col-md-4'>
                                    <?php echo $form->textField($quote, 'sum_amount_usd', array('required' => true, 'readOnly' => true, 'class' => 'cal_ans autoNum form-control')); ?>
                                </div>

                                <div class="col-md-2" id="upAddDis">
                                    <label class="control-label q_label">USD</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="sCheck" class="col-md-12">
                <div class="col-md-6">
                <a href="#" class="sNote">Thêm ghi chú</a>
                </div>
            </div>

            <div id="usAddNote" class="col-md-12 hidden">
                <?php echo $form->textAreaGroup($quote, 'note', array('labelOptions' => array("label" => 'Ghi chú'))); ?>
            </div>

            <div id="sFooter" class="col-md-12">
                <div class="pull-left">
                    <button type="button" onclick="exportQuote(<?php echo $quote['id']; ?>);" class="btn Submit">In báo giá</button>
                </div>

                <div class="pull-right">
                    <button class="btn sCancel" id="printQuote" data-dismiss="modal">Hủy</button>
                    <?php if ($createQuote == 1) : ?>
                        <button class="btn Submit" id="sSubmit" type="submit">Xác nhận</button>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'update_js.php';?>
<?php $this->endWidget(); unset($form);?>