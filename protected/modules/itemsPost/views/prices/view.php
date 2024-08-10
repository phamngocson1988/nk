<?php
$this->breadcrumbs=array(
	'Prices'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Prices','url'=>array('index')),
array('label'=>'Create Prices','url'=>array('create')),
array('label'=>'Update Prices','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Prices','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Prices','url'=>array('admin')),
);
?>

<h1>View Prices #<?php echo $model->id; ?></h1>
<?php $ima=isset($model->image)!=""?$model->image:'no_image.png'; ?>
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'id_prices_type',
		'name',
		'description',
		'content',
		'createdate',
		'status_hiden',
		'status',
),
)); ?>
