<style type="text/css">
    .btn_close {
    background: url(<?php echo Yii::app()->params['image_url']; ?>/images/icon_sb_left/ic_close.png);
    height: 10px;
    width: 10px;
    float: right;
    cursor: pointer;
    background-size: 100%;
    background-repeat: no-repeat;
}

</style>
<?php 
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
<div class="modal-dialog" style="margin-top: 10%">
    <div class="loginmodal-container">
        <a class="btn_close" data-dismiss="modal" aria-label="Close"></a>
        <h1><?php echo Yii::t('translate','nhakhoa2000'); ?> </h1> <br>
            <?php 
			$form = $this->beginWidget(
                    'booster.widgets.TbActiveForm',
                    array(
                        'id' => 'frm-login-customer',
                        'enableAjaxValidation'=>false,
                        'clientOptions' => array(
                            'validateOnSubmit'=>true,
                            'validateOnChange'=>true,
                            'validateOnType'=>true,
                        ),
                    )
                );
                 
                echo $form->textFieldGroup($model, 'username',array('widgetOptions'=>array('htmlOptions'=>array('placeholder'=>'Email')),'labelOptions' => array("label" => false)));
                echo $form->passwordFieldGroup($model, 'password',array('widgetOptions'=>array('htmlOptions'=>array('placeholder'=> Yii::t('translate','password'))),'labelOptions' => array("label" => false))); ?>
 
               <?php  if($lang=='vi'){echo $form->checkboxGroup($model, 'rememberMe');}else{ ?>
                <div>
                    <div class="checkbox">
                        <input id="ytLoginCustomerForm_rememberMe" type="hidden" value="0" name="LoginCustomerForm[rememberMe]">
                        <label><input name="LoginCustomerForm[rememberMe]" id="LoginCustomerForm_rememberMe" value="1" type="checkbox"> Remember login</label>
                    </div>
                </div>
               <?php  }
                $this->widget(
                    'booster.widgets.TbButton',
                    array(
					'buttonType' => 'submit', 
                    'label' => Yii::t('translate','login'),
                    'htmlOptions' => array('class'=> 'login loginmodal-submit btn-success')
                    )
                );
                 
                $this->endWidget();
                unset($form);
				
			?>

            <div class="login-help">
                <?php if($lang == 'en'){ ?>
                    <a href="<?php echo Yii::app()->params['url_base_http'] ?>/register">
                <?php }else{?>
                    <a href="<?php echo Yii::app()->params['url_base_http'] ?>/dang-ky">
                <?php }?>

                    <?php echo Yii::t('translate','register'); ?></a> - <a href="#" id="close-login" data-toggle="modal" data-target="#forget-pass"><?php echo Yii::t('translate','forgot_password'); ?></a>
            </div>
    </div>
</div>

<script>

$('#frm-login-customer').submit(function(e) {
    //Prevent the default action, which in this case is the form submission.
    e.preventDefault();


    //Serialize the form data and store to a variable.
    var formData = new FormData($("#frm-login-customer")[0]);

    var urlProfile = "<?php echo Yii::app()->getBaseUrl(); ?>";

    var urlC = location.pathname;


    if (!formData.checkValidity || formData.checkValidity()) {
        jQuery.ajax({ type:"POST",
            url:"<?php echo CController::createUrl('home/login')?>",
            data:formData,
            datatype:'json',

            success:function(data){
              
                if(data == 'success'){
                    if(urlC.search("book") == -1)
                        location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/profile';
                    else
                        location.href= '<?php echo Yii::app()->getBaseUrl(); ?>/book/register_info';
                    return false;
                }
				$("#login-customer-modal").html(data);
				
				
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    return false;

});
$("#close-login").click(function(){
    // alert("asdasdasd");
    $('#login-customer-modal').modal("hide");
});    
</script>