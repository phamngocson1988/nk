<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'faq-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(  
        'enctype' => 'multipart/form-data'
		),
)); ?>
<script src="<?php echo Yii::app()->baseUrl.'/ckeditor/ckeditor.js'; ?>"></script>
<div id="box_title_content" class="row clearfix" >
        <label class="col-xs-8 col-sm-9 col-md-9">
            <?php if($model->isNewRecord == 1){ ?>
                <h3>Create FAQ</h3>
            <?php }else{ ?>
            <h3>Update FAQ <?php echo $model->id; ?></h3>
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
        <li class="active"><a data-toggle="tab" href="#d1">Question Vi</a></li>
        <li><a data-toggle="tab" href="#d2">Question En</a></li>
    </ul>
    <div class="tab-content" style="padding:15px 0;">
        <div id="d1" class="tab-pane fade in active">
          <?php echo $form->textFieldGroup($model,'question',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>755)))); ?>
        </div>
        <div id="d2" class="tab-pane fade in ">
          <?php echo $form->textFieldGroup($model,'question_en',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>755)))); ?>
        </div>
    </div>
	
	<ul class="nav nav-tabs" style="margin-top: 15px;">
        <li class="active"><a data-toggle="tab" href="#answer1">Answer Vi</a></li>
        <li><a data-toggle="tab" href="#answer2">Answer En</a></li>
    </ul>
	<div class="tab-content" style="padding:15px 0;">
        <div id="answer1" class="tab-pane fade in active">
          	<?php echo $form->labelEx($model,'answer'); ?>
		    <?php echo $form->textArea($model, 'answer', array('id'=>'editor1')); ?>
		    <?php echo $form->error($model,'answer'); ?>
		 
			<script type="text/javascript">
			     CKEDITOR.replace( 'editor1', {
		         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
		         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
		         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
		         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
		         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
		         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
		    });
			</script>
        </div>
        <div id="answer2" class="tab-pane fade in ">
          	<?php echo $form->labelEx($model,'answer_en'); ?>
		    <?php echo $form->textArea($model, 'answer_en', array('id'=>'editor2')); ?>
		    <?php echo $form->error($model,'answer_en'); ?>
		 
			<script type="text/javascript">
			     CKEDITOR.replace( 'editor2', {
		         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
		         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
		         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
		         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
		         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
		         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
		    });
			</script>
        </div>
    </div>

	<?php
	    //  echo $form->switchGroup($model, 'status_hiden',
		// 	array(
		// 		'widgetOptions' => array(
		// 			'events'=>array(
		// 				'switchChange'=>'js:function(event, state) {
		// 				  console.log(this); // DOM element
		// 				  console.log(event); // jQuery event
		// 				  console.log(state); // true | false
		// 				}'
		// 			)
		// 		)
		// 	)
		// ); 
	?>

	<?php 
		// echo $form->switchGroup($model, 'status',
		// array(
		// 		'widgetOptions' => array(
		// 			'events'=>array(
		// 				'switchChange'=>'js:function(event, state) {
		// 				  console.log(this); // DOM element
		// 				  console.log(event); // jQuery event
		// 				  console.log(state); // true | false
		// 				}'
		// 			)
		// 		)
		// 	)
		// ); 
	?>
<?php $this->endWidget(); ?>
<script>
	$( "#Faq_id_faq_type").change(function() {
	     returnfaqline();
	});
function returnfaqline(){
	var idtype = $("#Faq_id_faq_type").val();
	jQuery.ajax({ 
		type:"POST",
	    url :"<?php echo CController::createUrl('Faq/ajax_faq_line')?>",
	    data: {"idtype" : idtype},
	    success: function(data)
	    {
	      $("#Faq_id_faq_line").html(data);
	     }
	  });
}
</script>