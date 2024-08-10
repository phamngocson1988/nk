<?php
$this->breadcrumbs=array(
	'Pimages Types'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List PImagesType','url'=>array('index')),
array('label'=>'Create PImagesType','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('pimages-type-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<div id="box_search_info" class="row clearfix search-form" style="text-align:center" >
	<?php 
	$temp_id = '';
        if(isset($id)){
            $temp_id = $id;
        }
	$this->renderPartial('_search',array('model'=>$model,'id'=>$temp_id)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'pimages-type-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'name',
		array(
		'name'=>'name_upload',
		'type'=>'raw',
		'value'=>'(!empty($data->name_upload))?CHtml::image(Yii::app()->baseUrl."/upload/images_type/md/".$data->name_upload,"",array("width"=>"70px" ,"height"=>"70px")):CHtml::image(Yii::app()->baseUrl . "/upload/no_image.png","",array("width"=>"70px" ,"height"=>"70px"))',
            ),
		'url_action',
		array(
            'class' => 'booster.widgets.TbToggleColumn',
           	'toggleAction' => 'PImagesType/toggle',
            'name' => 'block',
            'header' => Yii::t('app','Block'),
        ),
		array(
            'class' => 'booster.widgets.TbToggleColumn',
           	'toggleAction' => 'PImagesType/toggle',
            'name' => 'status_hidden',
            'header' => Yii::t('app','Status&nbspHidden'),
        ),
array(
'class'=>'booster.widgets.TbButtonColumn',
'header'=>'Action',
),
),
)); ?>
