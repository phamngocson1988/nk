<?php
$this->breadcrumbs=array(
	'Advertises'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Advertise','url'=>array('index')),
array('label'=>'Create Advertise','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('advertise-grid', {
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
'id'=>'advertise-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
	
		'name',
		'language',
		array(
		'name'=>'image',
		'type'=>'raw',
		'value'=>'(!empty($data->image))?CHtml::image(Yii::app()->baseUrl . "/upload/post/slider/lg/".$data->image,"",array("width"=>"50px" ,"height"=>"50px")):CHtml::image(Yii::app()->baseUrl . "/upload/no_image.png","",array("width"=>"50px" ,"height"=>"50px"))',
            ),
		'url',
		array(
                'class' => 'booster.widgets.TbToggleColumn',
               	'toggleAction' => 'Advertise/toggle',
                'name' => 'status',
                'header' => Yii::t('app','Status&nbsp;'),
            ),
	
array(
'class'=>'booster.widgets.TbButtonColumn',
'header'=>'Action',
),
),
)); ?>
