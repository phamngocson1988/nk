<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'cs-material-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListGroup($model,'id_material_group',array('widgetOptions'=>array('data'=>CHtml::listData(CsMaterialGroup::model()->findAll(),'id', 'name'),'htmlOptions'=>array('empty'=>'--Chọn nhóm--','required'=>'required')))); ?>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required')))); ?>
	<?php echo $form->textFieldGroup($model,'code',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>50,'required'=>'required')))); ?>
	<?php echo $form->textFieldGroup($model,'accounting',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>50)))); ?>
	<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>
	<?php echo $form->textFieldGroup($model,'unit',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>50)))); ?>
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

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Lưu' : 'Lưu',
		)); ?>
</div>

<?php $this->endWidget(); ?>
