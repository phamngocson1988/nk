<?php $baseUrl = Yii::app()->getBaseUrl(); 
 $controller = Yii::app()->getController()->getAction()->controller->id;
    $action     = Yii::app()->getController()->getAction()->controller->action->id;
    $lang = Yii::app()->request->getParam('lang','');
    if($lang == ''){
        $lang =  'vi';
    }
    Yii::app()->setLanguage($lang);
    ?>
<div class="col-md-12" id="bk_register_info">
	<h4 class="pl30" style="text-transform: uppercase;"><?php echo Yii::t("translate","book_info_personal"); ?></h4>
	<div id="Cus_info">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'Register-Book-Customer',
	'action' => Yii::app()->createUrl('book/update_cus'),
	'enableAjaxValidation'=>false,
	'type' => 'horizontal',
	'htmlOptions'=>array(  
		'enctype' => 'multipart/form-data',
	),
	'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
    ),
)); ?>
		
	<?php 
		// họ tên
		echo $form->textFieldGroup($model,'fullname',array('wrapperHtmlOptions' => array('class' => 'col-md-5'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required','placeholder'=>'','readOnly'=>true)),'labelOptions' => array("label" => Yii::t("translate","full_name"), 'class'=>'col-md-4'))); 

		// giới tính
		$defaultGender = "VN";
		if($model->gender){
			$defaultGender = $model->gender;
		}
		echo $form->dropDownListGroup($model,'gender',array('wrapperHtmlOptions' => array('class' => 'col-md-3'),'widgetOptions'=>array('data'=>array('0'=>'Nam','1'=>'Nữ'),'htmlOptions'=>array('readOnly'=>true,'options'=>array($defaultGender=>array('selected'=>'selected')))),'labelOptions' => array("label" => Yii::t("translate","gender"),'class'=>'col-md-4')));

		// số điện thoại
		echo $form->textFieldGroup($model,'phone',array('wrapperHtmlOptions' => array('class' => 'col-md-4'),'widgetOptions'=>array('htmlOptions'=>array('required'=>'required','placeholder'=>'','readOnly'=>true)),'labelOptions' => array("label" => Yii::t("translate","phone"), 'class'=>'col-md-4')));

		// ngày tháng năm sinh
		echo $form->datePickerGroup($model,'birthdate',array('wrapperHtmlOptions' => array('class' => 'col-md-3'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'placeholder'=>'','readOnly'=>true)),'labelOptions' => array("label" => Yii::t("translate","date_birth"), 'class'=>'col-md-4')));

		// địa chỉ
		echo $form->textFieldGroup($model,'address',array('wrapperHtmlOptions' => array('class' => 'col-md-5'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'placeholder'=>'','readOnly'=>true)),'labelOptions' => array("label" => Yii::t("translate","address"), 'class'=>'col-md-4')));

		echo '<div class="clearfix"></div>';

		// email
		echo $form->textFieldGroup($model,'email',array('wrapperHtmlOptions' => array('class' => 'col-md-5'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'placeholder'=>'','readOnly'=>true)),'labelOptions' => array("label" => 'Email', 'class'=>'col-md-4')));

		// nhập mật khẩu
		/*echo $form->passwordFieldGroup($model,'password',array('wrapperHtmlOptions' => array('class' => 'col-md-4'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'required'=>'required','placeholder'=>'', 'value'=>'')),'labelOptions' => array("label" => 'Mật khẩu', 'class'=>'col-md-4')));*/

	?>
		<!-- 	<div class="col-md-offset-3">
				<p>Nhập mật khẩu để thay đổi thông tin cá nhân.</p>
			</div> -->
		
		<div class="clearfix"></div>
		<div class="col-md-12" id="bk_rule">
			<div class="checkbox">
				<label class="labelFrmDkRule"><input required="required" type="checkbox" id="check_ale" name="Customer[check_ale]" value="1"> <span><?php echo Yii::t("translate","agree"); ?> </span><span class="DkRegister"><?php echo Yii::t("translate","terms_service"); ?></span></label>
			</div>
		</div>
	</div> <!-- end Custormer_info -->
</div>
<div class="col-md-12 text-right" style="margin: 15px"><!-- 
<button type="submit" class="btn btn_blue"></button> -->

	<?php
	$url = $baseUrl . '/book/verify_schedule';
	echo CHtml::ajaxLink(Yii::t("translate","book_hover"),
            Yii::app()->createUrl("book/addSchedules"),
            array(
                "type"=>"POST",
                'dataType' => "json",
                "success"=>"js:function(data){
					if(data['new']['status'] == 1){
						$('#noti_mess').text('Cảm ơn quý khách đã đặt lịch hẹn tại Nha Khoa 2000!');
						if(data['old']){
							getNoti(data['old'], 'update', 0, data['new']['success']['id_dentist']);
						}
						setTimeout(function(){
							getNoti(data['new']['success']['id'], 'add', 0, data['new']['success']['id_dentist']);
						},1500);
					}
					else
					{
						$('#noti_mess').html('Đã có khách hàng đặt lịch hẹn trong khoảng thời gian này.<br>Xin vui lòng chọn vào thời gian khác!');
					}
					setTimeout(function(){
						$('#notify_sch').modal('show');
					},500);
                }",
            ),array('class'=>'btn btn_blue'));
	?>
</div>
<?php $this->endWidget();  ?>
</div>

<!-- modal -->
<div id="notify_sch" class="modal fade">
	<div class="modal-dialog" style="margin-top: 18%;">
   		<div class="modal-content">
   			<div class="modal-header">
   				Thông báo
   				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   			</div>
   			<div class="modal-body">
   				<div id="noti_mess">Đã có khách hàng đặt lịch hẹn trong khoảng thời gian này.<br>Xin vui lòng chọn vào thời gian khác!</div>
   			</div>
   			<div class="modal-footer">
		        <a href="<?php echo $baseUrl; ?>/book" class="btn btn-primary" id="noti_cf">Xác nhận</a>
		    </div>
    	</div>
    </div>
</div>

<script>
	$('#notify_sch').on('hidden.bs.modal', function () {
		  	location.href = '<?php echo Yii::app()->params['url_base_http'] ?>/book';
		 })

	function getNoti(id_schedule, action, author, id_dentist) {
	    $.ajax({
			url     : '<?php echo CController::createUrl('book/getNoti'); ?>',
			type    : "post",
			dataType: 'json',
			data    : {
				id_schedule: id_schedule,
				action     : action,
				id_author  : author,
				id_dentist :id_dentist,
			}
	    })
	}
</script>