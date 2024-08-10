<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' =>'horizontal',
	'method'=>'get',
)); ?>
<!-- BOX TITLE -->
        <div id="box_title_content" class="clearfix">
            <label class="col-xs-12 col-sm-6 col-md-9"><h3>News Line Manager</h3></label>
            <div class="col-xs-12 col-sm-6 col-md-3 form-actions text-right">
                <?php

                $this->widget('booster.widgets.TbButton', array(
        			'buttonType' => 'submit',
        			'context'=>'success',
        			'label'=>'Apply filter',
                    'htmlOptions'=>array('class'=>'margin-top-10'),
        		)); ?>
                <?php echo CHtml::link('Create',array('NewsLine/create'),array('class'=>'margin-top-10 btn btn-success')); ?>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 clearfix">
		<?php //echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

		<?php echo $form->dropDownListGroup($model,'id_news_type',array('widgetOptions'=>array('data'=>CHtml::listData(PNewsType::model()->findAll(),'id', 'name'),'htmlOptions'=>array('empty'=>'--Choose Country--','required'=>'required')))); ?>

		<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>200)))); ?>

		<?php //echo $form->textFieldGroup($model,'status_hiden',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

		<?php //echo $form->textFieldGroup($model,'status',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>
		</div>

<?php $this->endWidget(); ?>
