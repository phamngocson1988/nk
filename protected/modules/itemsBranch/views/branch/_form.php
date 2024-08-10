<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'branch-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(  
        'enctype' => 'multipart/form-data',
),
)); ?>

<div id="box_title_content" class="row clearfix" >
        <label class="col-xs-8 col-sm-9 col-md-9">
            <?php if($model->isNewRecord == 1){ ?>
                <h3>Create Branch</h3>
            <?php }else{ ?>
            <h1>Update Branch <?php echo $model->id; ?></h1>
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
        <li class="active"><a data-toggle="tab" href="#n1">Name Vi</a></li>
        <li><a data-toggle="tab" href="#n2">Name En</a></li>
    </ul>
    <div class="tab-content" style="padding:15px 0;">
        <div id="n1" class="tab-pane fade in active">
          	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required')))); ?>
        </div>
        <div id="n2" class="tab-pane fade in ">
          <?php echo $form->textFieldGroup($model,'name_en',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required')))); ?>
        </div>
    </div>

    <ul class="nav nav-tabs" style="margin-top: 15px;">
        <li class="active"><a data-toggle="tab" href="#add1">Address Vi</a></li>
        <li><a data-toggle="tab" href="#add2">Address En</a></li>
    </ul>
    <div class="tab-content" style="padding:15px 0;">
        <div id="add1" class="tab-pane fade in active">
          	<?php echo $form->textFieldGroup($model,'address',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required')))); ?>
        </div>
        <div id="add2" class="tab-pane fade in ">
          <?php echo $form->textFieldGroup($model,'address_en',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required')))); ?>
        </div>
    </div>
	

	<?php echo $form->textFieldGroup($model,'email',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'required'=>'required')))); ?>
	
	<?php echo $form->dropDownListGroup($model,'id_country',array('widgetOptions'=>array('data'=>CHtml::listData(CsCountry::model()->findAll(),'code', 'country'),'htmlOptions'=>array('empty'=>'--Choose Country--','required'=>'required')))); ?>
	
	<?php echo $form->dropDownListGroup($model,'id_city',array('widgetOptions'=>array('data'=>CHtml::listData(CsCity::model()->findAll(),'id', 'name_long'),'htmlOptions'=>array('empty'=>'--Choose City--','required'=>'required')))); ?>
	
	<?php echo $form->textFieldGroup($model,'hotline1',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>25,'required'=>'required')))); ?>

	<?php echo $form->textFieldGroup($model,'hotline2',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>25,'required'=>'required')))); ?>

	<?php echo $form->textFieldGroup($model,'point_x',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>25,'required'=>'required')))); ?>

	<?php echo $form->textFieldGroup($model,'point_y',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>25,'required'=>'required')))); ?>

	

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
