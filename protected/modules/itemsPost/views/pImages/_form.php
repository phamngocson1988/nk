<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/cropimages/imgareaselect-default.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/cropimages/jquery.awesome-cropper.css">

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/cropimages/jquery.awesome-cropper.js" charset="utf-8"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/cropimages/jquery.imgareaselect.js" charset="utf-8"></script>

<?php 
$baseUrl = Yii::app()->getBaseUrl();
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'pimages-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(  
    'enctype' => 'multipart/form-data'
	),
)); ?>
<div id="box_title_content" class="row clearfix" >
    <label class="col-xs-8 col-sm-9 col-md-9">
        <?php if($model->isNewRecord == 1){ ?>
            <h3>Create Images</h3>
        <?php }else{ ?>
        <h3>Update Images<?php echo $model->id; ?></h3>
        <?php } ?>     
    </label>  
    <div class="col-xs-4 col-sm-3 col-md-3 form-actions text-right margin-top-10">  
        <?php 
            $this->widget(
                'booster.widgets.TbButton',
                array(
                    'context' => 'success',
                    'label' => $model->isNewRecord ? 'Add' : 'Save',
                    'buttonType' => 'submit',
                )
            );
        ?>
    </div>
</div>
<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListGroup($model,'id_type',array('widgetOptions'=>array('data'=>CHtml::listData(PImagesType::model()->findAll(),'id', 'name'),'htmlOptions'=>array()))); ?>

	
    <ul class="nav nav-tabs" style="margin-top: 15px;">
        <li class="active"><a data-toggle="tab" href="#n1">Name Vi</a></li>
        <li><a data-toggle="tab" href="#n2">Name En</a></li>
    </ul>
    <div class="tab-content" style="padding:15px 0;">
        <div id="n1" class="tab-pane fade in active">
          <?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>200)))); ?>
        </div>
        <div id="n2" class="tab-pane fade in ">
          <?php echo $form->textFieldGroup($model,'name_en',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>200)))); ?>
        </div>
    </div>
    

	<?php echo $form->textFieldGroup($model,'url_action',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>200)))); ?>

	<?php echo $form->fileFieldGroup($model, 'name_upload'); ?>
    <?php echo $form->textFieldGroup($model,'name_upload',array('widgetOptions'=>array('htmlOptions'=>array('class' =>'hidden')))); ?>
    <input type="hidden" name="name_upload" value="<?php echo $model->name_upload; ?>">
    <?php if(isset($model->name_upload) && $model->name_upload) { ?>
        <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/images/lg/'.$model->name_upload ?>" ><br><br>
    <?php }else{ ?>
        <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/no_image.png'?>" ><br><br>
    <?php } ?>

	<?php echo $form->textFieldGroup($model,'update_time',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>
    <input type="text" style='display:none' class="form-control col-md-6" id="PImages_update_time" name="PImages_update_time" />
	<?php echo $form->switchGroup($model, 'status_hidden',
		array(
			'widgetOptions' => array(
				'events'=>array(
					'switchChange'=>'js:function(event, state) {
					  console.log(this); // DOM element
					  console.log(event); // jQuery event
					  console.log(state); // true | false
					}'
				)
			)
		)
	); ?>

<?php $this->endWidget(); ?>
<script type="text/javascript">

   $("#PImages_update_time").datepicker({dateFormat: 'yy-mm-dd',showAnim:'fold', });


   $('#PImages_name_upload').on('change', function(evt) {
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            document.getElementById('imgUpload').src = fr.result;
        }
        fr.readAsDataURL(files[0]);
    }
});
</script>
