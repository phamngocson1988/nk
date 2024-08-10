<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'supplier-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<div class="col-xs-6">
			<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->textFieldGroup($model,'contact_person',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->textFieldGroup($model,'phone',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->textFieldGroup($model,'address',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>755)))); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->textFieldGroup($model,'total_amount',array('widgetOptions'=>array('htmlOptions'=>array('readonly'=>'readonly')))); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->textFieldGroup($model,'total_debt',array('widgetOptions'=>array('htmlOptions'=>array('readonly'=>'readonly')))); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
				'buttonType'=>'submit',
				'context'=>'primary',
				'label'=>$model->isNewRecord ? 'Lưu' : 'Lưu',
			)); ?>
	</div>
<?php $this->endWidget(); ?>
