<?php 
     $baseUrl = Yii::app()->getBaseUrl();
     $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'advertise-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(  
        'enctype' => 'multipart/form-data',
		),
)); ?> 

<div id="box_title_content" class="row clearfix" >
        <label class="col-xs-8 col-sm-9 col-md-9">
            <?php if($model->isNewRecord == 1){ ?>
                <h3>Create Banner</h3>
            <?php }else{ ?>
            <h3>Update Banner<?php echo $model->id; ?></h3>
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


<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>
    <input type="file" name="Advertise_images" id="Advertise_images" ><br>
    <?php
	if(isset($model->image)!="")
	{?>
    <input type="hidden" name="image_name" value="<?php echo $model->image?>">
    <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/post/slider/lg/'.$model->image?>" ><br><br>
	<?php }else{?>
    <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/no_image.png'?>" ><br><br>
	<?php }?>

	<?php echo $form->textFieldGroup($model,'url',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>
     <div class="form-group">
        <label class="control-label">Language</label>
        <div>
            <select name="Advertise[language]" id="Advertise_language" class="form-control" required>
                <option value="vi" <?php if($model->language == "vi"){echo "selected";}?>>Tiếng việt</option>
                <option value="en" <?php if($model->language == "en"){echo "selected";}?>>Tiếng anh</option>
            </select>
        </div>
    </div>
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
<script>

$('h1').html('');
$('.required').html('');
$("#Promotion_postdate").datepicker({dateFormat: 'yy-mm-dd',showAnim:'fold', });
$('#Advertise_images').on('change', function(evt) {
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
</script>