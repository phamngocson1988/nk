<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'prices-form',
	'enableAjaxValidation'=>false,
)); ?>

<div id="box_title_content" class="row clearfix" >
    <label class="col-xs-8 col-sm-9 col-md-9">
          <?php if($model->isNewRecord == 1){ ?>
            <h3>Create Service</h3>
        <?php }else{ ?>
        <h3>Update Service <?php echo $model->id; ?></h3>
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

    <?php echo $form->dropDownListGroup($model,'id_prices_type',array('widgetOptions'=>array('data'=>CHtml::listData(PricesType::model()->findAll(),'id', 'name'),'htmlOptions'=>array('empty'=>'--Choose Type Prices--','required'=>'required')))); ?>
	
    <?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

	<?php echo $form->textFieldGroup($model,'description',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>500)))); ?>

	<?php echo $form->ckEditorGroup($model,'content', array('widgetOptions'=>array('editorOptions' => array(
						'fullpage' => 'js:true',
					),'htmlOptions'=>array('rows'=>3, 'cols'=>50)))); 
                    ?>

    <?php echo $form->switchGroup($model, 'status_hiden',
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
