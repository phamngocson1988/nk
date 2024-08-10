<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header sHeader">
            <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h3 id="info_head" class="modal-title">Cập nhật ghi chú</h3>
        </div>

        <div class="modal-body">
            <form id="frmUpdateTreatmentNote" enctype="multipart/form-data" class="form-horizontal" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $model->id ?>" id="id">
                <div class="margin-top-20">
                    <div class="form-group">
                        <span class="col-md-4 control-label">Dịch vụ:</span>
                        <div class="col-md-8">
                        <?php
                            echo CHtml::dropDownList('service_code','',AfterTreatmentNote::model()->serviceCustomer,array('class'=>'form-control','empty' => 'N/A', 'options' => array($model->service_code => array('selected' => true))));
                        ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Tên khách hàng:</span>
                        <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $model->customer_fullname ?>" id="customer_fullname" name="customer_fullname">
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Mã khách hàng:</span>
                        <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $model->code_number ?>" id="code_number" name="code_number">
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Chẩn đoán:</span>
                        <div class="col-md-8">
                        <textarea class="form-control" id="diagnose" name="diagnose"><?php echo $model->diagnose ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Bác sĩ chẩn đoán:</span>
                        <div class="col-md-8">
                        <textarea class="form-control" id="diagnose_doctor" name="diagnose_doctor"><?php echo $model->diagnose_doctor ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Điều trị:</span>
                        <div class="col-md-8">
                        <textarea class="form-control" id="treatment" name="treatment"><?php echo $model->treatment ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Bác sĩ điều trị:</span>
                        <div class="col-md-8">
                        <textarea class="form-control" id="treatment_doctor" name="treatment_doctor"><?php echo $model->treatment_doctor ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Không điều trị:</span>
                        <div class="col-md-8">
                        <textarea class="form-control" id="no_treatment" name="no_treatment"><?php echo $model->no_treatment ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Bác sĩ không điều trị:</span>
                        <div class="col-md-8">
                        <textarea class="form-control" id="no_treatment_doctor" name="no_treatment_doctor"><?php echo $model->no_treatment_doctor ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Đối tác:</span>
                        <div class="col-md-8">
                        <?php $partner_list = Partner::model()->findAllByAttributes(array('status' => 1));
                            $partner_list_value = array();
                            foreach ($partner_list as $key => $value) {
                                $partner_list_value[$value->id] = $value->name;
                            }
                         ?>
                        <?php
                            echo CHtml::dropDownList('partner','',$partner_list_value,array('class'=>'form-control','empty' => 'N/A', 'options' => array($model->partner => array('selected' => true))));
                        ?>
                        <!-- <textarea class="form-control" id="partner" name="partner"><?php echo $model->partner ?></textarea> -->
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Thời gian cs:</span>
                        <div class="col-md-8">
                            <input required type="text" class="form-control col-sm-6" id="cs_time" name="cs_time" value="<?php echo $model->cs_time ?>">
                        </div>
                    </div>
                                                                        
                    <div class="form-group">
                        <span class="col-md-4 control-label">Phản hồi: </span>
                        <div class="col-md-8">
                            <input required type="text" class="form-control col-sm-6" id="feedback" name="feedback" value="<?php echo $model->feedback ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-md-4 control-label">Chất lượng:</span>
                        <div class="col-md-8">
                            <?php                                                                                   
                                echo CHtml::dropDownList('quality','',AfterTreatmentNote::model()->listQuality,array('class'=>'form-control','empty' => 'N/A', 'options' => array($model->quality => array('selected' => true))));
                            ?>  
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Hẹn:</span>
                        <div class="col-md-8">
                        <?php
                            echo CHtml::dropDownList('appointment','',AfterTreatmentNote::model()->appointmentList,array('class'=>'form-control','empty' => 'N/A', 'options' => array($model->appointment => array('selected' => true))));
                        ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Hẹn tiếp:</span>
                        <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $model->next_schedule ?>" id="next_schedule" name="next_schedule">
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Thời gian:</span>
                        <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $model->next_schedule_time ?>" id="next_schedule_time" name="next_schedule_time">
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Tên KH giới thiệu:</span>
                        <div class="col-md-8">
                            <input required type="text" class="form-control" id="ref_customer" name="ref_customer" value="<?php echo $model->ref_customer ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Mã KH:</span>
                        <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $model->ref_customer_code ?>" id="ref_customer_code" name="ref_customer_code">
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-4 control-label">Ghi chú:</span>
                        <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $model->note ?>" id="note" name="note">
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="updateNote()" class="btn btn-primary" id="update_note_submit">Lưu</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        </div>
    </div>

</div>

<script type="text/javascript">
    function updateNote() {
        var formData = new FormData($("#frmUpdateTreatmentNote")[0]);
        jQuery.ajax({   
            type:"POST",
            url:"<?php echo CController::createUrl('reportingTreatmentAfter/updateNote')?>",
            data: formData,
            datatype: 'json',
            beforeSend: function() {
                jQuery("#idwaiting_search").html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/vtbusy.gif" alt="waiting....." />'); 
            },
            success:function(data){
                if(data == '-1'){
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Có lỗi',
                        'closeOnClick': true
                    });
                }else if(data != ''){
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Thành công',
                        'closeOnClick': true
                    });
                    $('#updateTreatmentModal').modal('hide');
                    search_treatment();
                    resizeWindows();
                }else{
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Có lỗi',
                        'closeOnClick': true
                    });
                }
                jQuery("#idwaiting_search").html('');
            },
            processData: false,
            contentType: false,
        });
        return false;
    }
</script>