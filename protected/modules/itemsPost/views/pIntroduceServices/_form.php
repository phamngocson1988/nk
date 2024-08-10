<?php 	
	$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'about-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(  
        'enctype' => 'multipart/form-data'
		),
)); ?>
<script src="<?php echo Yii::app()->baseUrl.'/ckeditor/ckeditor.js'; ?>"></script>
<div id="box_title_content" class="row clearfix" >
		<label class="col-xs-8 col-sm-9 col-md-9">
			<?php if($model->isNewRecord == 1){ ?>
				<h3>Create About</h3>
			<?php }else{ ?>
			<h1>Update About</h1>
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

	
	<ul class="nav nav-tabs" style="margin-top: 15px;">
        <li class="active"><a data-toggle="tab" href="#n1">Title Vi</a></li>
        <li><a data-toggle="tab" href="#n2">Title En</a></li>
    </ul>
    <div class="tab-content" style="padding:15px 0;">
        <div id="n1" class="tab-pane fade in active">
          <?php echo $form->textFieldGroup($model,'title',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required')))); ?>
        </div>
        <div id="n2" class="tab-pane fade in ">
          <?php echo $form->textFieldGroup($model,'title_en',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required')))); ?>
        </div>
    </div>

	<ul class="nav nav-tabs" style="margin-top: 15px;">
        <li class="active"><a data-toggle="tab" href="#add1">Content Vi</a></li>
        <li><a data-toggle="tab" href="#add2">Content En</a></li>
    </ul>
    <div class="tab-content" style="padding:15px 0;">
        <div id="add1" class="tab-pane fade in active">
            <?php echo $form->labelEx($model,'content'); ?>
            <?php echo $form->textArea($model, 'content', array('id'=>'editor3')); ?>
            <?php echo $form->error($model,'content'); ?>
         
            <script type="text/javascript">
                 CKEDITOR.replace('editor3', {
                 filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
                 filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
                 filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
                 filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
                 filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
                 filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
            });
            </script>
        </div>
        <div id="add2" class="tab-pane fade in ">
           <?php echo $form->labelEx($model,'content_en'); ?>
            <?php echo $form->textArea($model, 'content_en', array('id'=>'editor4')); ?>
            <?php echo $form->error($model,'content_en'); ?>
         
            <script type="text/javascript">
                 CKEDITOR.replace('editor4', {
                 filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
                 filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
                 filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
                 filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
                 filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
                 filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
            });
            </script>
        </div>
    </div>

<?php $this->endWidget(); ?>
