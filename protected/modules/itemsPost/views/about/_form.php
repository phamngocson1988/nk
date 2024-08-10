<?php 	
	$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'about-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(  
        'enctype' => 'multipart/form-data'
		),
)); ?>

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

	<?php echo $form->textFieldGroup($model,'title',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required')))); ?>

	<?php echo $form->ckEditorGroup($model,'description', array('widgetOptions'=>array('editorOptions' => array(
						'fullpage' => 'js:true',						
					),'htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>

<?php $this->endWidget(); ?>
