<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type' =>'horizontal',
)); ?>
<!-- BOX TITLE -->
        <div id="box_title_content" class="clearfix">
            <label class="col-xs-12 col-sm-6 col-md-9"><h3>FAQ Question</h3></label>
            <div class="col-xs-12 col-sm-6 col-md-3 form-actions text-right">
	            <?php echo CHtml::link('Create',array('FaqQuestion/create'),array('class'=>'margin-top-10 btn btn-success')); ?>
	        </div>
        </div>
<?php $this->endWidget(); ?>
