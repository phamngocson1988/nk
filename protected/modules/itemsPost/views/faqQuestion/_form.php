<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'faq-question-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(  
        'enctype' => 'multipart/form-data'
		),
)); ?>
<script src="<?php echo Yii::app()->baseUrl.'/ckeditor/ckeditor.js'; ?>"></script>
<div id="box_title_content" class="row clearfix" >
        <label class="col-xs-8 col-sm-9 col-md-9">
            <?php if($model->isNewRecord == 1){ ?>
                <h3>Create Faq Question</h3>
            <?php }else{ ?>
            <h3>Update Faq Question <?php echo $model->id; ?></h3>
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

	
	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>200)))); ?>
	<?php echo $form->textFieldGroup($model,'email',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>200)))); ?>
	<?php echo $form->textFieldGroup($model,'phone',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>200)))); ?>
    
    <input type="file" name="faq_img" id="faq_img"/><br> 
    <?php if(isset($model->img)!=""){ ?>
        <img style="width:10%" id="imgUpload" src="<?php echo  Yii::app()->baseUrl.'/upload/post/faq/'.$model->img?>" ><br><br>
    <?php }else{?>
        <img style="width:10%" id="imgUpload" src="<?php echo  Yii::app()->baseUrl.'/upload/post/faq/no_image.png'?>" ><br><br>
    <?php }?>

	<?php echo $form->labelEx($model,'content'); ?>
    <?php echo $form->textArea($model, 'content', array('id'=>'editor1')); ?>
    <?php echo $form->error($model,'content'); ?>
 
	<script type="text/javascript">
	     CKEDITOR.replace( 'editor1', {
         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
    });
	</script>

	<?php echo $form->labelEx($model,'answer'); ?>
    <?php echo $form->textArea($model, 'answer', array('id'=>'editor2')); ?>
    <?php echo $form->error($model,'answer'); ?>
 
	<script type="text/javascript">
	     CKEDITOR.replace( 'editor2', {
         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
    });
	</script>

	<?php echo $form->switchGroup($model, 'status',
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
<script>
	$('#faq_img').on('change', function(evt) {
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