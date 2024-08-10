<style type="text/css">
	.error{border: 0px solid rgba(216, 51, 51, 0.69);}
	.success{font-size: 20px;text-align: center;}
	.text{font-size: 13px;font-weight: bold;color: rgba(216, 51, 51, 0.69);}
</style>
<?php   $baseUrl = Yii::app()->getBaseUrl(); 
        $controller = Yii::app()->getController()->getAction()->controller->id;
        $action     = Yii::app()->getController()->getAction()->controller->action->id;
        $lang = Yii::app()->request->getParam('lang','');
        if ($lang != '') {
	        Yii::app()->session['lang'] = $lang;
	    } else {
	        if (isset(Yii::app()->session['lang'])) {
	            $lang = Yii::app()->session['lang'];
	        } else {
	            $lang = 'vi';
	        }
	    }  
	    Yii::app()->setLanguage($lang);
?>

<?php 
$baseUrl = yii::app()->request->baseUrl;
if($model->id && Yii::app()->user->getFlash('success')) { ?>
	
	<div class="text-center" id="re_tt">
		<h2><?php echo Yii::t('translate','notify'); ?></h2>
	</div>
	<div  class="container">
		<div class="row">
			<div class="col-xs-12 col-md-offset-1 col-md-10 col-lg-offset-1 col-lg-10" id="re_info">

				<div class="row" id="log">
					<div class="col-md-10 col-md-offset-1 text-center">
	     				<?php echo Yii::t('translate','thanks'); ?>
					</div>
				</div>
					
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function () {
		    setTimeout(function(){
		    	$("#login-customer-modal").modal({backdrop: true});
		    	$("#LoginCustomerForm_username").val(<?php echo $model->phone; ?>);
		    }, 5000);
		});
	</script>

<?php }else{ ?>

<div class="text-center" id="re_tt">
	<h2><?php echo Yii::t('translate','register_account'); ?></h2>
</div>
<div  class="container">
	<div class="row">
		<div class="col-xs-12 col-md-offset-1 col-md-10 col-lg-offset-1 col-lg-10" id="re_info">
			<div class="row">

				<div class="row" id="log">
					<div class="col-md-10 col-md-offset-1">
						<p class="createregister"><?php echo Yii::t('translate','have_account'); ?> <button type="button" data-toggle="modal" data-target="#login-customer-modal" class="btn btn_blue btnLoginRegister"> <?php echo Yii::t('translate','login'); ?> </button>&nbsp; | &nbsp;&nbsp; <?php echo Yii::t('translate','no_account'); ?></p>
						 
					</div>

				</div>

				<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
					'id'=>'View-Frm-Customer',
					//'action' => Yii::app()->createUrl('/profile'),
					'enableAjaxValidation'=>false,
					'htmlOptions'=>array(  
					'enctype' => 'multipart/form-data',
				),
				)); ?>
				<div class="row">

						<div class="col-md-5 col-sm-offset-1">

							<div class="form-group ">
								<?php echo $form->textFieldGroup($model,'fullname',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required','placeholder'=>'*'. Yii::t('translate','full_name'),'id'=>'fullname')),'labelOptions' => array("label" => false) )); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textFieldGroup($model,'email',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'placeholder'=>'*Email','id'=>'email')),'labelOptions' => array("label" => false))); ?>
								<p class="texterror text"></p>
							</div>

							

							<div class="form-group">
								<?php echo $form->passwordFieldGroup($model,'password',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'required'=>'required','placeholder'=>'*'.Yii::t('translate','password'),'id'=>'password')),'labelOptions' => array("label" => false))); ?>
								<p class="texterrormk1 text"></p>
							</div>
							<div class="form-group">
								<?php echo $form->passwordFieldGroup($model,'repeatpassword',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'required'=>'required','placeholder'=>'*'.Yii::t('translate','enter_password'),'id'=>'repeatpassword')),'labelOptions' => array("label" => false) )); ?>
								<p class="texterrormk text"></p>
							</div>
							<div class="form-group">
								<p><i><?php echo Yii::t('translate','note'); ?></i></p>
							</div>

						</div>
						<div class="col-md-5  col-sm-offset-1">

							<div class="form-group">
								<?php 
									$defaultGender = "VN";
									if($model->gender){
										$defaultGender = $model->gender;
									}
									echo $form->dropDownListGroup($model,'gender',array('widgetOptions'=>array('data'=>array('0'=>'Nam','1'=>'Nữ'),'htmlOptions'=>array('options'=>array($defaultGender=>array('selected'=>'selected')), 'id'=>'gender')),'labelOptions' => array("label" => false))); 
								?>
							</div>

							<div class="form-group">
								<?php echo $form->datePickerGroup($model,'birthdate',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'placeholder'=>Yii::t('translate','date_birth'), 'id'=>'birthdate')),'labelOptions' => array("label" => false))); ?>
							</div>

							<div class="form-group">
									<?php 
									$defaultCountry = "VN";
									if($model->id_country){
										$defaultCountry = $model->id_country;
									}
									echo $form->dropDownListGroup($model,'id_country',array('widgetOptions'=>array('data'=>CHtml::listData(CsCountry::model()->findAll("flag=1"),'code', 'country'),'htmlOptions'=>array('required'=>'required', 'options'=>array($defaultCountry=>array('selected'=>'selected')), 'id'=>'id_country')),'labelOptions' => array("label" => false))); 
									?>
							</div>
							
							<div class="form-group">
								<?php echo $form->textFieldGroup($model,'phone',array('widgetOptions'=>array('htmlOptions'=>array('required'=>'required','placeholder'=>'*'.Yii::t('translate','phone1'), 'id'=>'phone')),'labelOptions' => array("label" => false)) ); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textFieldGroup($model,'address',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'placeholder'=>Yii::t('translate','address'), 'id'=>'address')),'labelOptions' => array("label" => false))); ?>
							</div>
						</div>
						
						<div  class="col-md-10 col-md-offset-1 checkbox">
							<label class="labelFrmDkRule"><input required="required" type="checkbox" id="check_ale" name="Customer[check_ale]" value="1">
							 <span><?php echo Yii::t('translate','agree'); ?> </span>
							 <span class="DkRegister"><?php echo Yii::t('translate','terms_service'); ?></span>
							</label>
						</div>

						<div class="col-md-11 col-md-offset-1 text-right">
							<button type="button" class="btn btn_blue" ><?php echo Yii::t('translate','cancel'); ?></button>
							<button type="button" id="myBtn"  class="btn btn_blue"><?php echo Yii::t('translate','register'); ?></button>
						</div>

				</div>
				<?php $this->endWidget();  ?>


			</div>
			
		</div>
	</div>
</div>
     <div class="alert alert-danger" id="canhbao" style="    position: fixed;
    margin-left: -182px;
    left: 591px;
    top: 181px;
    z-index: 99999;
    box-shadow: 0 5px 15px #999;
    display:none;"><p class="value"></p></div>
<!-- data-toggle="modal" data-target="#log_info"-->

<?php } ?>
<script type="text/javascript">
	$(function(){

	$('#anext').click(function(e){
		e.preventDefault();
		var chk_code = $('#chk_code').val();
		if(chk_code)
			checkcode(chk_code);
		else{
			$('#noti_mess').html('Mã xác nhận không được để trống!');
			$('#notify_modal').modal('show');
			$('#noti_cf').click(function(){
				$('#notify_modal').modal('hide');
			})
		}
	})
	var send = 1;
	
	$('#btn_send').click(function(e){
		e.preventDefault();
			send++;

			sendAgain(send);
	})
})

function checkcode(id) {
	var lang = '<?php echo $lang;?>';
	var code = $('#code_sms').val();
	if(code == ''){
		//if (!code) { document.forms['View-Frm-Customer'].repeatpassword.focus(); }
		if(lang=='vi'){
			$('#status').html('Mã xác nhận không rỗng');
		}else{
			$('#status').html('Confirmation is not empty');
		}
		return false;
	}
	$.ajax({
		dataType 	: 'json',
		url 		: '<?php echo CController::createUrl('Register/checkCodesms'); ?>',
		type 		: 'post',
		data 		: {
			id		: 		id,
			code 	: 		code
		},
		success 	: function(data) {
			//var message = 'Lỗi không xác định!';
			
			if(data == 1) {
				if(lang=='vi'){
					$('#re_info').html('<p class="success" >Bạn đã đăng ký thành công ! vui lòng đăng nhập Nha khoa 2000 &nbsp; <button type="button" data-toggle="modal" data-target="#login-customer-modal" class=""> Đăng nhập </button> </p>');
				}else{
					$('#re_info').html('<p class="success"> You have registered successfull!Please login DENTAL CLINIC 2000 &nbsp; <button type="button" data-toggle="modal" data-target="#login-customer-modal" class=""> Login</button> </p>');
				}
			}
			else if (data == 0) {
				if(lang=='vi'){
					$('#status').html('Nhập sai mã xác nhận');
				}else{
					$('#status').html('Enter confirmation code wrong');
				}
			}
			else {
				message = 'Có lỗi xảy ra! Xin vui lòng thử lại sau!';
			}

			
		}
	})
}

function sendAgain(id) {
	var lang = '<?php echo $lang;?>';
	var sumsend = parseInt($('#sumsend').val());
	if(sumsend > 3)
	{	if(lang=='vi'){
			alert('quá số lần đăng ký và tài khoản bạn đăng ký đã khóa lại');
		}else{
			alert('Too many registrations and accounts have been blocked');
		}
		return false;
		
		//return false;
	}else{
		$('#sumsend').val(sumsend+1);
		$.ajax({
		dateType 	: 'json',
		url 		: '<?php echo CController::createUrl('Register/sendAgain'); ?>',
		type 		: 'post',
		data 		: {
				id 	: id
		},
		success 	: function(data) {
			var message = 'Lỗi không xác định!';
			if(data > 6) {
				message = 'Nha Khoa 2000 đã gửi lại mã xác nhận đến điện thoại của quý khách!';
			}
			else if(data == -2) {
				message = 'Đã gửi tin nhắn thứ 3!';
			}
			else {
				message = 'Không thể gửi tin nhắn!';
				$('#chk_code').val('');
			}
			
			
			
		}
	})
	}
	
}

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
<script type="text/javascript">


function isEmail(s)
{if(s=="") return false;
if(s.indexOf(" ")>0) return false;
if(s.indexOf("@")==-1)return false;
var i=1; var sLength=s.length;
if(s.indexOf(".")==-1) return false;
if(s.indexOf("..")!=-1)return false;
if(s.indexOf("@")!=s.lastIndexOf("@")) return false;
if(s.lastIndexOf(".")==s.length-1)return false;
var str="abcdefghikjlmnopqrstuvwxyz-@._0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
for(var j=0;j<s.length;j++)
if(str.indexOf(s.charAt(j))==-1)
return false;return true;
}
	$(document).ready(function(){
		
		$('#myBtn').click(function(){
			registercus();
	  	});
	})
	function registercus(){
		var lang = '<?php echo $lang;?>';
		var fullname 	= $('#fullname').val();
		var email 		= $('#email').val();
		var phone		= $('#phone').val();
		var password 	= $('#password').val();
		var repeatpassword = $('#repeatpassword').val();
		var gender 		= $('#gender').val();
		var birthdate	= $('#birthdate').val();
		var id_country 	= $('#id_country').val();
		var address		= $('#address').val();
		var checked 	= $('#check_ale').val();
		
		if(fullname == '' || email == '' || phone == '' || password == '' || repeatpassword =='')
		{
			
			if (!phone) { document.forms['View-Frm-Customer'].phone.focus(); }
			
			if (!repeatpassword) { document.forms['View-Frm-Customer'].repeatpassword.focus(); }
			if (!password) { document.forms['View-Frm-Customer'].password.focus(); }
			if (!email) { document.forms['View-Frm-Customer'].email.focus(); }
			if (!fullname) { document.forms['View-Frm-Customer'].fullname.focus(); }
			return false;
		}
		 if(!isEmail(email)) {
		 		$('#email').addClass('error');
		 		if(lang=='vi'){
   				 	$('.texterror').html('Email không đúng định dạng !');
   				}else{
   				 	$('.texterror').html('Email format invalid !');
   				}
   				return false;
 			 }else{
 			 	$('#email').removeClass('error');
   				 $('.texterror').html('');
 			 } 
		if(password.length < 6)
		{
			document.forms['View-Frm-Customer'].password.focus();
			if(lang=='vi'){
				$('.texterrormk1').html('Mật khẩu không được ít hơn 6 ký tự !');
			}else{
				$('.texterrormk1').html('Password not less than 6 characters!');
			}
			return false;
		}
		if (password != repeatpassword) {
			$('#password').addClass('error');
			$('#repeatpassword').addClass('error');
			/*$('#canhbao').fadeIn();
    		$('#canhbao').fadeOut(6000);*/
    		if(lang =='vi'){
	    		$('.texterrormk').html('Mật khẩu không trùng khớp !');
	    	}else{
	    		$('.texterrormk').html('Password do not match !');
	    	}

    		return false;
		}
		if($('#check_ale').prop("checked") == false)
		{
			$('#check_ale').focus();
			return false;
		}
		$.ajax({
				type :"POST",
				url  :"<?php echo CController::createUrl('Register/Register') ?>",
				data : {
                      	'fullname'			: fullname,
						'email'				: email,
						'phone'				: phone,
						'password'			: password,
						'repeatpassword'	: repeatpassword,
						'gender'			: gender,
						'birthdate'			: birthdate,
						'id_country'		: id_country,
						'address'			: address
				},
				success : function(data)
				{
					// alert(data);
					// return false;
					if(data >= 1){
					$('.createregister').css({'display':'none'});
					$('.success').css({'display':'block'});
					/**/
					if(lang=='vi'){
						$('#re_info').html('<div class="col-md-10 col-md-offset-1">'+
						'<label style="font-size:20px;">Xác thực thông tin</label> <br>'+
						'<p >Chúng tôi đã gửi mã xác nhận, vui lòng kiểm tra tin nhắn</p>'+
							'<input type="text" class="form-control" placeholder="Nhập mã xác nhận" style="width: 400px; float: left; " id="code_sms"> &nbsp; <button type="button" class="btn btn_blue btnLoginRegister" onclick="checkcode('+data+')"> Xác nhận </button> <br><p id="status" class="text"></p>' +
							'<p style="margin-top:10px;">Nhận lại mã xác nhận: <a href="#" id="sendAgain" onclick="sendAgain('+data+')" > Gửi lại </a>  </p><br></div><input type="text" id="sumsend" class="hidden" value="1">');
					}else{
						$('#re_info').html('<div class="col-md-10 col-md-offset-1">'+
						'<label style="font-size:20px;">Validate information</label> <br>'+
						'<p >We have sent a confirmation code, please check the message</p>'+
							'<input type="text" class="form-control" placeholder="Enter the confirmation code" style="width: 400px; float: left; " id="code_sms"> &nbsp; <button type="button" class="btn btn_blue btnLoginRegister" onclick="checkcode('+data+')"> Confirm </button> <br><p id="status" class="text"></p>' +
							'<p style="margin-top:10px;">Get confirmation code: <a href="#" id="sendAgain" onclick="sendAgain('+data+')" > Send </a>  </p><br></div><input type="text" id="sumsend" class="hidden" value="1">');
					}

					$('#LoginCustomerForm_username').val(email);
					//return false;
					} else if(data == -1)
					{
						$('#email').addClass('error');
						if(lang=='vi'){
							$('.texterror').html('Email đã được sử dụng !');
						}else{
							$('.texterror').html('Email has been used !');
						}
					return false;
					}else if(data == -2)
					{
						if(lang=='vi'){
							alert('Tài khoản của quý khách đã bị khóa quý khách vui lòng liên hệ với Nha khoa 2000 để kiểm tra lại !');
						}else{
							alert('Your account is locked. Please contact DENTAL CLINIC 2000 to check again !');
						}
					}
					else{
						if(lang=='vi'){
							alert('Thêm thất bại ! mong quý khách hàng kiểm tra lại thông tin');
						}else{
							alert('More failures. Hope customers check the information!');
						}
					}
				},
			});

	}
</script>
