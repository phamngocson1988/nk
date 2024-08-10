
<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
    'Login',
);
?>

<style>
.bg-admin-login {
    background: url("images/banner_01w.jpg") top center ;
    background-size: 100% auto;
    background-repeat: no-repeat;
}
.btn-login-admin{
    font-size: 17px;
    width: 100%;
    padding-top: 8px;
    padding-bottom: 8px;
    border-radius: 0px;
    border:none;
    color:#fff !important;
    background-color: #8dbf46 ;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;

}
.btn-login-admin:hover{
   background-color: #84b341 !important ;
}
</style>

<div class="bg-admin-login" style="max-height: 917px;position: relative;">
	<div style="width:100%; height:100%;background-color: rgba(0,0,0,.4);"><div>
    <div class="container-fluid">
        <div style="margin: 10em auto;max-width: 425px;border-radius:5px;background-color: #f5f5f5;border-radius:5px;padding:0px; ">
            <?php
            /** @var TbActiveForm $form */
            $form = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                array(
                    'id' => 'login-form',
                    'enableAjaxValidation'=>false,
                    'clientOptions' => array(
                        'validateOnSubmit'=>true,
                        'validateOnChange'=>true,
                        'validateOnType'=>true,
                    ),
                )
            ); ?>

            <div style="padding:15px 15px 0px 15px;">
                <h5 style="color:#02a9dc;font-size:29px;text-align:center;font-weight: bold;">Welcome Nha Khoa 2000!</h5>
                <p style="text-align:center;color:#8c8b8b;font-size:12px;margin:0px;">Please fill out the following form with your login credentials</p>

                <div style="padding:20px 75px 15px 75px;">
                    <?php
                        echo $form->textFieldGroup($model, 'username',array('widgetOptions'=>array('htmlOptions'=>array('required'=>'required')),'labelOptions' => array("label" => false)));

                        echo $form->passwordFieldGroup($model, 'password',array('widgetOptions'=>array('htmlOptions'=>array('required'=>'required')),'labelOptions' => array("label" => false)));

                        echo $form->checkboxGroup($model, 'rememberMe');
                    ?>
                </div>
            </div>

            <?php 

            $this->widget(
                'booster.widgets.TbButton',
                array('buttonType' => 'submit',
                    'label' => 'Login',
                    'htmlOptions' => array('class'=> 'btn-login-admin')
                )
            );

            $this->endWidget();
            unset($form);
            ?>
        </div>
    </div>
</div>

