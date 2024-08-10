<?php 
    $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' =>'horizontal',
	'method'=>'get',
)); ?>
      
      <!-- BOX TITLE -->
        <div id="box_title_content" class="clearfix">
            <label class="col-xs-12 col-sm-6 col-md-9"><h3>News Manager</h3></label>
            <div class="col-xs-12 col-sm-6 col-md-3 form-actions text-right">
                <?php

                $this->widget('booster.widgets.TbButton', array(
        			'buttonType' => 'submit',
        			'context'=>'success',
        			'label'=>'Apply filter',
                    'htmlOptions'=>array('class'=>'margin-top-10'),
        		)); ?>
                <?php echo CHtml::link('Create',array('News/create'),array('class'=>'margin-top-10 btn btn-success')); ?>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4 clearfix">
       
       <?php echo $form->dropDownListGroup($model,'id_news_line',array('widgetOptions'=>array('data'=>CHtml::listData(NewsLine::model()->findAll(),'id', 'name'),'htmlOptions'=>array('empty'=>'--Choose Line--','required'=>'required')))); ?>

		<?php //echo $form->textFieldGroup($model,'id_user',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

		<?php echo $form->textFieldGroup($model,'title',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

		<?php echo $form->textFieldGroup($model,'createdate',array('widgetOptions'=>array('htmlOptions'=>array()))); 
		
		?>
         <input type="text" style='display:none' class="form-control col-md-6" id="News_createdate" name="News_createdate" />
		

		<?php echo $form->textFieldGroup($model,'total_view',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

		

	
	</div>

<?php $this->endWidget(); ?>

<script>

$("#News_createdate").datepicker({dateFormat: 'yy-mm-dd',showAnim:'fold', });

</script>
