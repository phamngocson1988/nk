<?php 
$baseUrl = Yii::app()->getBaseUrl();
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>'pimages-type-form',
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(  
    'enctype' => 'multipart/form-data'
    ),
)); ?>
<div id="box_title_content" class="row clearfix" >
    <label class="col-xs-8 col-sm-9 col-md-9">
        <?php if($model->isNewRecord == 1){ ?>
            <h3>Create Images Type</h3>
        <?php }else{ ?>
        <h3>Update Images Type <?php echo $model->id; ?></h3>
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

    <?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>100,'required'=>'required')))); ?>
    <?php echo $form->textFieldGroup($model,'url_action',array('widgetOptions'=>array('htmlOptions'=>array('value' =>'upload/images_type','maxlength'=>200,'required'=>'required')))); ?>
    <?php echo $form->fileFieldGroup($model, 'name_upload'); ?>
    <?php echo $form->textFieldGroup($model,'name_upload',array('widgetOptions'=>array('htmlOptions'=>array('class' =>'hidden')))); ?>
    <input type="hidden" name="name_upload" value="<?php echo $model->name_upload; ?>">

    <?php if(isset($model->name_upload) && $model->name_upload) { ?>
        <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/images_type/md/'.$model->name_upload ?>" ><br><br>
    <?php }else{ ?>
        <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/images_type/no_image.png'?>" ><br><br>
    <?php } ?>
    <?php echo $form->switchGroup($model, 'block',
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
// $("#ProductImage_update_time").datepicker({dateFormat: 'yy-mm-dd',showAnim:'fold', });
$('#PImagesType_name_upload').on('change', function(evt) {
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
// img
// $('#img').change(function(){
//  alert($('#img').var());
// });

</script>