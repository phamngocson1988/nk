<?php 
$baseUrl = Yii::app()->getBaseUrl();
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'gp-users-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(  
        'enctype' => 'multipart/form-data',
),
)); ?>
    <script src="<?php echo Yii::app()->baseUrl.'/ckeditor/ckeditor.js'; ?>"></script>
    <div id="box_title_content" class="row clearfix" >
        <label class="col-xs-8 col-sm-9 col-md-9">
            <?php if($model->isNewRecord == 1){ ?>
                <h3>Create UsersCcp</h3>
            <?php }else{ ?>
            <h1>Update UsersCcp <?php echo $model->id; ?></h1>
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
    <p class="help-block">Fields with <span class="required">*</span> are required.</p>
    
    <?php echo $form->dropDownListGroup($model,'group_id',array('widgetOptions'=>array('data'=>CHtml::listData(GpGroup::model()->findAll(),'id', 'group_name'),'htmlOptions'=>array('empty'=>'--Choose Group--','required'=>'required')))); ?>

    

    <?php echo $form->fileFieldGroup($model, 'image'); ?>

    <input type="hidden" name="image_name" value="<?php echo $model->image; ?>">

    <?php if(isset($model->image)!="") { ?>
        <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/users/md/'.$model->image?>" ><br><br>
    <?php }else{ ?>
        <img style="width:10%" id="imgUpload" src="<?php echo $baseUrl.'/upload/users/user-default.png'?>" ><br><br>
    <?php } ?>

	<?php echo $form->textFieldGroup($model,'username',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'required'=>'required')))); ?>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'required'=>'required')))); ?>

	<?php echo $form->passwordFieldGroup($model,'password',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'required'=>'required')))); ?>
    
    <?php echo $form->passwordFieldGroup($model,'repeatpassword',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128,'required'=>'required')))); ?>
    
	<?php echo $form->textFieldGroup($model,'email',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>128)))); ?>

    
    <ul class="nav nav-tabs" style="margin-top: 15px;">
        <li class="active"><a data-toggle="tab" href="#n1">Language Vi</a></li>
        <li><a data-toggle="tab" href="#n2">Language En</a></li>
    </ul>
    <div class="tab-content" style="padding:15px 0;">
        <div id="n1" class="tab-pane fade in active">
          <?php echo $form->textAreaGroup(
                $model,
                'language',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array('rows' => 2),
                    )
                )
            ); ?>
        </div>
        <div id="n2" class="tab-pane fade in ">
          <?php echo $form->textAreaGroup(
                $model,
                'language_en',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array('rows' => 2),
                    )
                )
            ); ?>
        </div>
    </div>
    <?php echo $form->textAreaGroup(
            $model,
            'exp',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array('rows' => 5),
                )
            )
        ); ?>

        <?php echo $form->redactorGroup(
            $model,
            'diploma',
            array(
                'widgetOptions' => array(
                    'editorOptions' =>array(
                        'class' => 'span4', 
                        'rows' => 5, 
                        'options' => array('plugins' => array('clips', 'fontfamily'), 'lang' => 'sv')
                    )
                )
            )
        ); ?>
        

      <?php echo $form->redactorGroup(
        $model,
        'certificate',
        array(
            'widgetOptions' => array(
                'editorOptions' =>array(
                    'class' => 'span4', 
                    'rows' => 5, 
                    'options' => array('plugins' => array('clips', 'fontfamily'), 'lang' => 'sv')
                )
            )
        )
    ); ?>

    <ul class="nav nav-tabs" style="margin-top: 15px;">
        <li class="active"><a data-toggle="tab" href="#add1">Description Vi</a></li>
        <li><a data-toggle="tab" href="#add2">Description En</a></li>
    </ul>
    <div class="tab-content" style="padding:15px 0;">
        <div id="add1" class="tab-pane fade in active">
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textArea($model, 'description', array('id'=>'editor3')); ?>
            <?php echo $form->error($model,'description'); ?>
         
            <script type="text/javascript">
                 CKEDITOR.replace('editor3', {
                 filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
                 filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
                 filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
                 filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
                 filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
                 filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
            });
            </script>
        </div>
        <div id="add2" class="tab-pane fade in ">
           <?php echo $form->labelEx($model,'description_en'); ?>
            <?php echo $form->textArea($model, 'description_en', array('id'=>'editor4')); ?>
            <?php echo $form->error($model,'description_en'); ?>
         
            <script type="text/javascript">
                 CKEDITOR.replace('editor4', {
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
<script type="text/javascript">
    $('#GpUsers_image').on('change', function(evt) {
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