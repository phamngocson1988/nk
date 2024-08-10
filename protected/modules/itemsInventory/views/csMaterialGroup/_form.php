<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'cs-material-group-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>

<div class="form-group">
    <label class=" control-label">Loại</label>
    <div>
        <select required="required" class="form-control" name="CsMaterialGroup[type]" id="CsMaterialGroup_type">
            <option value="">--Choose--</option>
            <option value="1" <?php if($model->type == 1){echo "selected";} ?>>
               Dụng cụ
            </option>
            <option value="2" <?php if($model->type == 2){echo "selected";} ?>>
                Hàng hóa
            </option>
            <option value="3" <?php if($model->type == 3){echo "selected";} ?>>
                Vật liệu
            </option>
        </select>
    </div>
</div>
<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>
<?php $this->endWidget(); ?>