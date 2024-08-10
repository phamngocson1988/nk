<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<?php 
    $model->received_date = date("Y-m-d");  
    $model->number = $model->getArNumber(date("Y-m-d"));

    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'View-Frm-Account-Receivable',
        'enableClientValidation'=>false,
        'enableAjaxValidation'  =>false,
        'htmlOptions'           =>array (   
            'onsubmit'  =>  "return false;",
            'enctype'   => 'multipart/form-data',
    ),)); 
?>
    
    <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success">
            <button type="button" data-dismiss="alert" class="close">×</button>
            <?php echo Yii::app()->user->getFlash('success')?>
        </div>
    <?php endif?>

    <?php if(Yii::app()->user->hasFlash('error')):?>
        <div class="alert alert-error">
        	<button data-dismiss="alert" class="close">×</button>
            <?php echo Yii::app()->user->getFlash('error')?>
        </div>
    <?php endif?>

    <div class="box_form form-horizontal">
    <?php echo $form->errorSummary($model,'<button type="button" class="close" data-dismiss="alert">&times;</button>','',array('class'=>'alert alert-block')); ?>

        <div class="col-md-6">
            <!-- Payer -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label"><span style="color: red;">*</span>Người nhận:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textField($model,'name',array('value'=>$model->name,'required'=>'required','class'=>'form-control')); ?>
                    <span class="error_message"><?php echo $form->error($model,'name',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Địa chỉ:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textField($model,'address',array('value'=>$model->address,'class'=>'form-control')); ?>
                    <span class="error_message"><?php echo $form->error($model,'address',array('class'=>'alert fade in')); ?></span>
                </div> 
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label"><span style="color: red;">*</span>Điện thoại:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textField($model,'phone',array('value'=>$model->phone,'required'=>'required','class'=>'form-control','pattern'=>'[0-9]+','title'=>'Please enter the number!')); ?>
                    <span class="error_message"><?php echo $form->error($model,'phone',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
            <!-- Amount -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label"><span style="color: red;">*</span>Số tiền:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textField($model,'amount',array('value'=>$model->amount,'required'=>'required','class'=>'form-control','type'=>'number','pattern'=>'[0-9]+','title'=>'Please enter the number!')); ?>
                    <span class="error_message"><?php echo $form->error($model,'amount',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
            <!-- In Words -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">In words:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textField($model,'in_words',array('value'=>$model->in_words,'class'=>'form-control')); ?>
                    <span class="error_message"><?php echo $form->error($model,'in_words',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
            <!-- Description -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label"><span style="color: red;">*</span>Mô tả:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textArea($model,'description',array('value'=>$model->description,'rows'=>4,'class'=>'form-control','required'=>'required')); ?>
                    <span class="error_message"><?php echo $form->error($model,'description',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Number -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Mã phiếu chi:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textField($model,'number',array('value'=>$model->number,'required'=>'required',"readonly"=>"readonly",'class'=>'form-control')); ?>
                    <span class="error_message"><?php echo $form->error($model,'number',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
            <!-- Type -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label"><span style="color: red;">*</span>Loại:</label>
                <div class="col-sm-8 col-md-8">
                    <?php 
                        $listdata      = array();
                        $listdata['']  = "Select Type";
                        $listdata['0'] = "Revenue";
                        $listdata['1'] = "Investment";
                        $listdata['3'] = "Refund money to customer";
                        $listdata['2'] = "Others";
                        echo $form->dropDownList($model,'type',$listdata,array('required'=>'required','style'=>'width: 205px;','class'=>'form-control','options'=>array($model->type =>array('selected'=>true))));
                    ?>
                    <span class="error_message"><?php echo $form->error($model,'type',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
            <!-- Payment Status -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label"><span style="color: red;">*</span>Thanh toán:</label>
                <div class="col-sm-8 col-md-8">
                    <?php 
                        $listdata      = array();
                        $listdata['1'] = "Cash";
                        $listdata['2'] = "Creadit Card";
                        $listdata['3'] = "Check";
                        echo $form->dropDownList($model,'payment_status',$listdata,array('required'=>'required','style'=>'width: 205px;','class'=>'form-control'));
                    ?>
                    <span class="error_message"><?php echo $form->error($model,'payment_status',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
            <!-- Requester date -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Ngày yêu cầu:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textField($model,'received_date',array('value'=>$model->received_date,'required'=>'required','class'=>'form-control',"readonly"=>"readonly")); ?>
                    <span class="error_message"><?php echo $form->error($model,'received_date',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
            <!-- Approval date -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Ngày xác nhận:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textField($model,'confirmed_date',array('value'=>$model->confirmed_date,"disabled"=>"disabled",'class'=>'form-control')); ?>
                    <span class="error_message"><?php echo $form->error($model,'confirmed_date',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
            <!-- Cashier -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Người thực hiện:</label>
                <div class="col-sm-8 col-md-8">
                    <input type="text" value="<?php echo Yii::app()->user->getState('name'); ?>" class="form-control" readonly>
                    <?php echo $form->hiddenField($model,'id_user',array('value'=>Yii::app()->user->getState("user_id"))); ?>
                    <span class="error_message"><?php echo $form->error($model,'id_user',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>
            <!-- Notes -->
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Ghi chú:</label>
                <div class="col-sm-8 col-md-8">
                    <?php echo $form->textArea($model,'note',array('value'=>$model->note,'rows'=>2,'class'=>'form-control')); ?>
                    <span class="error_message"><?php echo $form->error($model,'note',array('class'=>'alert fade in')); ?></span>
                </div>
            </div>    
        </div>

        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="form-actions text-right">
              <button class="btn sCancel" data-dismiss="modal">Hủy</button>
              <button id="btn-add-payable" type="submit" class="btn btn_book">Xác nhận</button>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
<?php $this->endWidget(); ?>

<!-- BG POPUP -->

<script>
$(document).ready(function(){
    
    $('#View-Frm-Account-Receivable').submit(function(e) {
		//Prevent the default action, which in this case is the form submission.
		e.preventDefault();
		//Serialize the form data and store to a variable.
		var formData = new FormData($("#View-Frm-Account-Receivable")[0]);

        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ 
                type:"POST",
                url:"<?php echo CController::createUrl('Receivable/addnew_'.$model->tableName().'')?>",
                data:formData,
                datatype:'json',
                beforeSend: function() {
                    jQuery("#view_payment_voucher").slideUp();
                    $('#idwaiting_main').html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/waitingmain.gif" alt="loading....." />');
                },
                success:function(data){
                    if(data!='-1' || data != "" ){
                        jQuery("#idwaiting_main").html('');
                        var cur_page = $("#id_text_page").val();
                        search_cus(cur_page);
                    }
                },
                error: function(data) { 
                    jQuery("#view_payment_voucher").slideDown();
                    $('#idwaiting_main').html('');
                    alert("Error occured.Please try again!");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
	});
    
    $(function() {
        $( "#VReceivable_received_date" ).datepicker({
            changeMonth: true,
    		changeYear: true,
            dateFormat: 'yy-mm-dd'
    	});
    });
});
</script>