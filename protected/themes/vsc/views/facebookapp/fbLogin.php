<div class="col-xs-6 col-xs-offset-3" id="fb_book_login_form">
	<h5 class="text-center">Đăng nhập bằng tài khoản NHA KHOA 2000</h5>

    <div class="alert alert-warning hidden error">
        <div class="text-center error-text"></div>
    </div>
	
	<div class="col-xs-12" id="fb_book_login_info">
		<?php 
		$form = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                array(
                    'id' => 'frm-fb-login-customer',
                    'enableAjaxValidation'=>false,
                    'clientOptions' => array(
                        'validateOnSubmit'=>true,
                        'validateOnChange'=>true,
                        'validateOnType'=>true,
                    ),
                )
            );
             
            echo $form->textFieldGroup($model, 'username',array('widgetOptions'=>array('htmlOptions'=>array('required'=>'required','placeholder'=>'Phone')),'labelOptions' => array("label" => false)));
            echo $form->passwordFieldGroup($model, 'password',array('widgetOptions'=>array('htmlOptions'=>array('required'=>'required')),'labelOptions' => array("label" => false)));
			
            $this->widget(
                'booster.widgets.TbButton',
                array(
				'buttonType' => 'submit', 
                'label' => 'Đăng nhập',
                'htmlOptions' => array('class'=> 'login loginmodal-submit btn_blue')
                )
            );
             
            $this->endWidget();
            unset($form);
		?>
		<div class="login-help">
            <a href="<?php echo Yii::app()->getBaseUrl(); ?>/facebookapp/fbCustomer">Đăng ký</a> - <a href="#">Quên mật khẩu</a>
        </div>
	</div>
</div>

<script>
    $(document).ready(function(){

        $('#frm-fb-login-customer').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($("#frm-fb-login-customer")[0]);

            if (!formData.checkValidity || formData.checkValidity()) {
                jQuery.ajax({ 
                    type        :"POST",
                    url         :"<?php echo CController::createUrl('facebookapp/fbLogin')?>",
                    data        :formData,
                    datatype    :'json',

                    success     :function(data){
                        console.log(data);
                        if(data == '1')
                            location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/facebookapp/fbCustomer';
                        else {
                            $('.error-text').html("Tài khoản hoặc mật khẩu của bạn không đúng!");
                            $('.error').removeClass('hidden');
                            return false;
                        }
                    },
                    error       :function(data) {
                        alert("Error occured.Please try again!");
                    },
                    cache       : false,
                    contentType : false,
                    processData : false
                });
            }
            return false;

        });
    });
</script>