<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'repository-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>

	<div class="col-xs-12" style="margin-bottom: 15px;">
        <div class="row">
            <label style="margin-right: 20px;">Loại kho</label>
            <label class="radio-inline">
              	<input required="required" type="radio" disabled="disabled" name="Repository[type_repository]"  value="1" <?php if($model->type_repository==1){echo "checked";}?>> Kho tổng
            </label>
            <label class="radio-inline">
              	<input required="required" type="radio" name="Repository[type_repository]"  value="2" <?php if($model->type_repository==2){echo "checked";}?>>Kho cơ sở
            </label>
            <label class="radio-inline">
              	<input required="required" type="radio" name="Repository[type_repository]"  value="3" <?php if($model->type_repository==3){echo "checked";}?>>Kho tầng
            </label>
        </div>
    </div>

	<?php echo $form->dropDownListGroup($model,'id_branch',array('widgetOptions'=>array('data'=>CHtml::listData(Branch::model()->findAll(),'id', 'name'),'htmlOptions'=>array('empty'=>'--Chọn chi nhánh--', 'required'=>true)))); ?>

	<?php echo $form->textFieldGroup($model,'code',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>50,'required'=>true)))); ?>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>true)))); ?>

	<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>

	<div class="form-actions" style="margin-bottom: 20px;">
		<?php $this->widget('booster.widgets.TbButton', array(
				'buttonType'=>'submit',
				'context'=>'primary',
				'label'=>$model->isNewRecord ? 'Create' : 'Save',
			)); ?>
	</div>

<?php $this->endWidget(); ?>
