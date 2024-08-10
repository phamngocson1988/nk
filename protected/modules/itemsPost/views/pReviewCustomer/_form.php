<?php 
	$baseUrl = Yii::app()->getBaseUrl();
	$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'preview-customer-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(  
        'enctype' => 'multipart/form-data'
		),
)); ?>
<div id="box_title_content" class="row clearfix" >
        <label class="col-xs-8 col-sm-9 col-md-9">
            <?php if($model->isNewRecord == 1){ ?>
                <h3>Create News</h3>
            <?php }else{ ?>
            <h3>Update News <?php echo $model->id; ?></h3>
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
          	<?php echo $form->textFieldGroup($model,'r_name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>100)))); ?>
        </div>
        <div id="n2" class="tab-pane fade in ">
          <?php echo $form->textFieldGroup($model,'name_en',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>100)))); ?>
        </div>
    </div>

	<input type="file" name="PReviewCustomer[r_img]" id="PReviewCustomer_r_img"/><br>
    <?php 
	if(isset($model->r_img)!="")
	{?>
    <input type="hidden" name="image_name" value="<?php echo $model->r_img?>">
    <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/post/review/lg/'.$model->r_img?>" ><br><br>
	<?php }else{?>
    <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/post/review/no_image.png'?>" ><br><br>
	<?php }?>

	<ul class="nav nav-tabs" style="margin-top: 15px;">
        <li class="active"><a data-toggle="tab" href="#t1">Content Vi</a></li>
        <li><a data-toggle="tab" href="#t2">Content En</a></li>
    </ul>
    <div class="tab-content" style="padding:15px 0;">
        <div id="t1" class="tab-pane fade in active">
          	<?php echo $form->ckEditorGroup($model,'r_content', array('widgetOptions'=>array('editorOptions' => array(
						'fullpage' => 'js:true'),'htmlOptions'=>array('rows'=>3, 'cols'=>50)))); ?>
        </div>
        <div id="t2" class="tab-pane fade in ">
          <?php echo $form->ckEditorGroup($model,'content_en', array('widgetOptions'=>array('editorOptions' => array(
						'fullpage' => 'js:true'),'htmlOptions'=>array('rows'=>3, 'cols'=>50)))); ?>
        </div>
    </div>

	<?php echo $form->switchGroup($model, 'status_hidden',
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
<script>
$('#PReviewCustomer_r_img').on('change', function(evt) {
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            document.getElementById('imgUpload').src = fr.result;
        }
        fr.readAsDataURL(files[0]);
    }
});

$('#img').change(function(){
	alert($('#img').var());
});

</script>