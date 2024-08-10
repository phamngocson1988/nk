<div id="fb_book_edit_form">
	
	<div class="col-xs-12" id="fb_book_resgiter_info">
		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
			'id'=>'fb_book_edit',
			'enableAjaxValidation'=>false,
			'action' 				=> 	Yii::app()->createUrl('facebookapp/fbEditCus'),
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
		echo $form->textFieldGroup($model,'fullname',array('wrapperHtmlOptions' => array('class' => 'col-xs-5'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required','placeholder'=>'')),'labelOptions' => array("label" => 'Họ tên', 'class'=>'col-xs-3'))); 
	
		// giới tính
		$defaultGender = "VN";
		if($model->gender){
			$defaultGender = $model->gender;
		}
		echo $form->dropDownListGroup($model,'gender',array('wrapperHtmlOptions' => array('class' => 'col-xs-3'),'widgetOptions'=>array('data'=>array('0'=>'Nam','1'=>'Nữ'),'htmlOptions'=>array('options'=>array($defaultGender=>array('selected'=>'selected')))),'labelOptions' => array("label" => 'Giới tính','class'=>'col-xs-3')));
	
		// ngày tháng năm sinh
		echo $form->datePickerGroup($model,'birthdate',array('wrapperHtmlOptions' => array('class' => 'col-xs-3'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'placeholder'=>'')),'labelOptions' => array("label" => 'Ngày tháng năm sinh', 'class'=>'col-xs-3')));
	
		// email
		echo $form->textFieldGroup($model,'email',array('wrapperHtmlOptions' => array('class' => 'col-xs-5'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'placeholder'=>'')),'labelOptions' => array("label" => 'Email', 'class'=>'col-xs-3')));
	
		// địa chỉ
		echo $form->textFieldGroup($model,'address',array('wrapperHtmlOptions' => array('class' => 'col-xs-5'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'placeholder'=>'')),'labelOptions' => array("label" => 'Địa chỉ', 'class'=>'col-xs-3')));
	
		echo '<div class="line_dot col-xs-8 col-xs-offset-3" style="margin-bottom: 15px;"></div>';
		echo '<div class="clearfix"></div>';
	
		// số điện thoại
		echo $form->textFieldGroup($model,'phone',array('wrapperHtmlOptions' => array('class' => 'col-xs-5'),'widgetOptions'=>array('htmlOptions'=>array('required'=>'required','placeholder'=>'','readOnly'=>true)),'labelOptions' => array("label" => 'Số điện thoại', 'class'=>'col-xs-3')));
	
		// nhập mật khẩu
		echo $form->passwordFieldGroup($model,'password',array('wrapperHtmlOptions' => array('class' => 'col-xs-5'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'required'=>'required','placeholder'=>'','value'=>'')),'labelOptions' => array("label" => 'Mật khẩu', 'class'=>'col-xs-3')));
	
		?>
	
		<div class="col-xs-4" id="bk_res_log_info">
			Nhập mật khẩu để thay đổi thông tin cá nhân.
		</div>
	
		<div class="clearfix"></div>
		<div class="col-xs-12" id="bk_rule">
			<div class="checkbox">
				<label class="labelFrxskRule"><input required="required" type="checkbox" id="check_ale" name="Customer[check_ale]" value="1"> <span>Tôi đồng ý với tất cả </span><span class="DkRegister">Điều khoản dịch vụ</span></label>
			</div>
		</div>
	
		<div class="col-md-12 text-right" style="margin: 15px">
			<button type="submit" class="btn btn_blue">CHỈNH SỬA</button>
			<?php
			$url = Yii::app()->getBaseUrl() . '/facebookapp/fbVerify';
			echo CHtml::ajaxLink('TIẾP TỤC',
		            Yii::app()->createUrl("facebookapp/addSchedules"),
		            array(
		                "type"=>"POST",
		                "data"=>array(
		                	'phone'=>$phone,
		                ),
		                "success"=>"js:function(data){                                                              
							if(data == 1)
								location.href = '$url';
		                }",
		            ),array('class'=>'btn btn_blue')); 
			?>
		</div>
	<?php $this->endWidget();  ?>
</div>