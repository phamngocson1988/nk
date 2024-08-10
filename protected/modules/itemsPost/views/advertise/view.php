<?php
$this->breadcrumbs=array(
	'Advertises'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Advertise','url'=>array('index')),
array('label'=>'Create Advertise','url'=>array('create')),
array('label'=>'Update Advertise','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Advertise','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Advertise','url'=>array('admin')),
);
?>

<h1>View Banner #<?php echo $model->id; ?></h1>
<?php $ima=isset($model->image)!=""?$model->image:'no_image.png'; ?>
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		array(
		'name'=>'image',
		'type'=>'raw',
		'value'=>CHtml::image(Yii::app()->baseUrl . '/upload/post/slider/lg/'.$ima,"",array("width"=>"50px" ,"height"=>"50px")),
            ),
		'url',
		'status',
),
)); ?>
