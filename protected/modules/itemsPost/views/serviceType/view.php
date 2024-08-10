<?php
$this->breadcrumbs=array(
	'Service Types'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List ServiceType','url'=>array('index')),
array('label'=>'Create ServiceType','url'=>array('create')),
array('label'=>'Update ServiceType','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete ServiceType','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage ServiceType','url'=>array('admin')),
);
?>

<h1>View ServiceType #<?php echo $model->id; ?></h1>
<?php $ima=isset($model->image)!=""?$model->image:'no_image.png'; ?>
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		array(
		'name'=>'image',
		'type'=>'raw',
		'value'=>CHtml::image(Yii::app()->baseUrl . '/upload/post/serviceType/lg/'.$ima,"",array("width"=>"50px" ,"height"=>"50px")),
            ),
		'description',
		'createdate',
		'status_hiden',
		'status',
),
)); ?>
