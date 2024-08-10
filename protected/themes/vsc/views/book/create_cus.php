<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<style>
.iconFb {width: 28px; margin-bottom: 8px;}
.oclick {cursor: pointer;}
</style>
<div class="col-md-12" id="bk_register_info">
	<h4 class="pl30">THÔNG TIN CỦA BẠN</h4>
	<div id="Cus_info">
		<div class="form-group" id="remain_login" style="text-align: left;">
			<p style="padding-left: 50px">Tôi đã có tài khoản <a href="#" class="btn btn_green" data-toggle="modal" data-target="#login-customer-modal">Đăng nhập</a> hoặc
			<span class="oclick" id="loginAccFb"><img class="iconFb" src="<?php echo Yii::app()->getBaseUrl(); ?>/images/icon_fb/ic_fb.jpg" alt=""></span >
	      	<span class="oclick" id="loginAccGg"><img class="iconFb" src="<?php echo Yii::app()->getBaseUrl(); ?>/images/icon_fb/ic_gg.jpg" alt=""></span ></p>
			<p  style="padding-left: 50px"> Chưa có tài khoản, vui lòng nhập thông tin</p>
		</div>
	
		<?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
			'id'                   =>'Register-Book-Customer',
			'action'               => Yii::app()->createUrl('book/create_cus'),
			'enableAjaxValidation' =>false,
			'type'                 => 'horizontal',
			'htmlOptions' =>array(  
				'enctype' => 'multipart/form-data',
			),
			'clientOptions' => array(
				'validateOnSubmit' =>true,
				'validateOnChange' =>true,
				'validateOnType'   =>true,
	        ),
		)); ?>

		<?php
			// họ tên
			echo $form->textFieldGroup($model,'fullname',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-5'),
				'widgetOptions'      => array('htmlOptions'=>array('required'=>'required')),
				'labelOptions'       => array("label" => 'Họ tên *', 'class'=>'col-md-4'))); 
			echo "<div class='col-sm-offset-3 error Customer_fullname'></div>";

			// giới tính
			$defaultGender = "0";
			if($model->gender){
				$defaultGender = $model->gender;
			}
			echo $form->dropDownListGroup($model,'gender',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-3'),
				'widgetOptions'      => array('data'=>array('0'=>'Nam','1'=>'Nữ'),
				'htmlOptions'        => array(
					'options'   => array($defaultGender=>array('selected'=>'selected')))),
				'labelOptions'       => array("label" => 'Giới tính','class'=>'col-md-4')));

			// số điện thoại
			echo $form->textFieldGroup($model,'phone',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-4'),
				'widgetOptions'      =>array('htmlOptions'=>array('required'=>'required')),
				'labelOptions'       => array("label" => 'Số điện thoại *', 'class'=>'col-md-4')));
			echo "<div class='col-sm-offset-3 error Customer_phone'></div>";

			// ngày tháng năm sinh
			echo $form->datePickerGroup($model,'birthdate',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-3'),
				'widgetOptions'      => array('htmlOptions'=>array()),
				'labelOptions'       => array("label" => 'Ngày tháng năm sinh', 'class'=>'col-md-4')));

			// địa chỉ
			echo $form->textFieldGroup($model,'address',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-5'),
				'widgetOptions'      => array('htmlOptions'=>array()),
				'labelOptions'       => array("label" => 'Địa chỉ', 'class'=>'col-md-4')));

			echo '<div class="line_dot col-md-8 pull-right" style="margin-bottom: 15px;"></div>';
			echo '<div class="clearfix"></div>';

			// email
			echo $form->textFieldGroup($model,'email',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-4'),
				'widgetOptions'      => array('htmlOptions'=>array('required'=>'required')),
				'labelOptions'       => array("label" => 'Email *', 'class'=>'col-md-4')));
			echo "<div class='col-sm-offset-3 error Customer_email'></div>";

			// nhập mật khẩu
			echo $form->passwordFieldGroup($model,'password',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-4'),
				'widgetOptions'      => array('htmlOptions'=>array('required'=>'required')),
				'labelOptions'       => array("label" => 'Mật khẩu *', 'class'=>'col-md-4')));
			echo "<div class='col-sm-offset-3 error Customer_password'></div>";

			// nhập lại mật khẩu
			echo $form->passwordFieldGroup($model,'repeatpassword',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-4'),
				'widgetOptions'      => array('htmlOptions'=>array('required'=>'required')),
				'labelOptions'       => array("label" => 'Nhập lại mật khẩu *', 'class'=>'col-md-4')));
			echo "<div class='col-sm-offset-3 error Customer_repeatpassword'></div>";
		?>				
		<div class="col-md-4" id="bk_res_log_info">
			Nhập email và mật khẩu để tạo tài khoản, thông tin của bạn sẽ được lưu trữ lại
		</div>

		<div class="clearfix"></div>

		<div class="col-sm-12">
			<div class="col-sm-offset-4" id="html_element"></div>
		</div>

		<div class="col-md-12" id="bk_rule">
			<div class="checkbox" style="margin-left: 40px;">
				<label class="labelFrmDkRule">
					<input required="required" type="checkbox" id="check_ale" name="Customer[check_ale]" value="1">
						<span>Tôi đồng ý với tất cả </span>
						<span class="DkRegister">Điều khoản dịch vụ</span>
				</label>
			</div>
		</div>

		<div class="col-md-12" style="margin: 15px">
			<button type="submit" class="btn btn_blue pull-right">TIẾP TỤC</button>
		</div>

		<?php $this->endWidget();  ?>
	</div> <!-- end Custormer_info -->	

	<div id="update_Cus_info" style="display: none;">
		<div class="form-group" id="remain_login" style="text-align: left;">
			<p style="padding-left: 50px">Cập nhật thông tin tài khoản</p>
		</div>
	
		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
			'id'                   =>'update-Book-Customer',
			'action'               => Yii::app()->createUrl('book/updateFBGGCus'),
			'enableAjaxValidation' =>false,
			'type'                 => 'horizontal',
			'htmlOptions'          =>array(  
				'enctype' => 'multipart/form-data',
			),
			'clientOptions' => array(
	            'validateOnSubmit'=>true,
	            'validateOnChange'=>true,
	            'validateOnType'=>true,
	        ),
		)); ?>

		<?php
			// hidden field facebook and google
			echo $form->hiddenField($model,'id_fb');
			echo $form->hiddenField($model,'name_fb');
			echo $form->hiddenField($model,'id_gg');
			echo $form->hiddenField($model,'name_gg');

			// họ tên
			echo $form->textFieldGroup($model,'fullname',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-5'),
				'widgetOptions'      => array('htmlOptions'=>array('required'=>'required', 'id' => 'up_cus_fullname')),
				'labelOptions'       => array("label" => 'Họ tên *', 'class'=>'col-md-4'))); 
			echo "<div class='col-sm-offset-3 error Customer_fullname'></div>";

			// email
			echo $form->textFieldGroup($model,'email',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-5'),
				'widgetOptions'      => array('htmlOptions'=>array('required'=>true, 'id'=> 'up_cus_email')),
				'labelOptions'       => array("label" => 'Email *', 'class'=>'col-md-4')));
			echo "<div class='col-sm-offset-3 error Customer_email'></div>";

			// số điện thoại
			echo $form->textFieldGroup($model,'phone',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-4'),
				'widgetOptions'      => array('htmlOptions'=>array('required'=>'required')),
				'labelOptions'       => array("label" => 'Số điện thoại *', 'class'=>'col-md-4')));
			echo "<div class='col-sm-offset-3 error Customer_phone'></div>";

			// giới tính
			$defGender = "0";
			if($model->gender){
				$defaultGender = $model->gender;
			}
			echo $form->dropDownListGroup($model,'gender',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-3'),
				'widgetOptions'      => array('data'=>array('0'=>'Nam','1'=>'Nữ'),
				'htmlOptions'        => array('options'=>array($defGender=>array('selected'=>'selected')))),
				'labelOptions'       => array("label" => 'Giới tính','class'=>'col-md-4')));


			// ngày tháng năm sinh
			echo $form->datePickerGroup($model,'birthdate',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-3'),
				'widgetOptions'      => array('htmlOptions'=>array()),
				'labelOptions'       => array("label" => 'Ngày tháng năm sinh', 'class'=>'col-md-4')));

			// địa chỉ
			echo $form->textFieldGroup($model,'address',array(
				'wrapperHtmlOptions' => array('class' => 'col-md-5'),
				'widgetOptions'      => array('htmlOptions'=>array()),
				'labelOptions'       => array("label" => 'Địa chỉ', 'class'=>'col-md-4')));
			
		?>
			<div class="col-md-12" id="bk_rule">
				<div class="checkbox">
					<label class="labelFrmDkRule"><input required="required" type="checkbox" id="check_ale" name="Customer[check_ale]" value="1"> <span>Tôi đồng ý với tất cả </span><span class="DkRegister">Điều khoản dịch vụ</span></label>
				</div>
			</div>

			<div class="col-md-12" style="margin: 15px">
				<button type="submit" class="btn btn_blue pull-right">TIẾP TỤC</button>
			</div>
		</div> <!-- end Custormer_info -->	
	</div>

	<?php $this->endWidget();  ?>

</div>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>	
<script>
	$('#Register-Book-Customer').submit(function(e) {
		e.preventDefault();

		var isCaptchaValidated = false;
		var response = grecaptcha.getResponse();

		if(response.length == 0) {
		    isCaptchaValidated = false;
		    alert('Please verify that you are a Human.');
		} else {
		    isCaptchaValidated = true;
		}

		if (!isCaptchaValidated ) {
		    return;
		}

		//Serialize the form data and store to a variable.
	    var formData = new FormData($("#Register-Book-Customer")[0]);

	    if (!formData.checkValidity || formData.checkValidity()) {
	        jQuery.ajax({ 
				type    : 	"POST",
				url     : 	"<?php echo CController::createUrl('book/create_cus')?>",
				data    : 	formData,
				dataType: 	'json',
				success : 	function(data){
					if(data == 1){
						location.href = '<?php echo($baseUrl); ?>/book/verify_schedule';
					}
	                if(data.status == '1'){
	                	$('.error').addClass('hidden');
	                	
	                    return false;
	                }
	                else if(data.status == '0'){
	                	$('.error').addClass('hidden');
	                	$.each(data.error, function (k, v) {
		            		$('.Customer_' + k +'').text(v[0]);
		            		$('.Customer_' + k +'').removeClass('hidden');
		            	})
	                }
	            },
	            error: function(data) {
	                alert("Error occured.Please try again!");
	            },
				cache      : false,
				contentType: false,
				processData: false
	        });
	    }
	    return false;
	});

	$('#update-Book-Customer').submit(function(e) {
		e.preventDefault();
		//Serialize the form data and store to a variable.
	    var formData = new FormData($("#update-Book-Customer")[0]);

	    if (!formData.checkValidity || formData.checkValidity()) {
	        $.ajax({ 
				type    : 	"POST",
				url     : 	"<?php echo CController::createUrl('book/upCusFBGG')?>",
				data    : 	formData,
				dataType: 	'json',
				success : 	function(data){
					console.log(data);
					return;
					if(data == 1){
						location.href = '<?php echo($baseUrl); ?>/book/verify_schedule';
					}
	                if(data.status == '1'){
	                	$('.error').addClass('hidden');
	                	
	                    return false;
	                }
	                else if(data.status == '0'){
	                	$('.error').addClass('hidden');
	                	$.each(data.error, function (k, v) {
		            		$('.Customer_' + k +'').text(v[0]);
		            		$('.Customer_' + k +'').removeClass('hidden');
		            	})
	                }
	            },
	            error: function(data) {
	                alert("Error occured.Please try again!");
	            },
				cache      : false,
				contentType: false,
				processData: false
	        });
	    }
	    return false;
	});
</script>