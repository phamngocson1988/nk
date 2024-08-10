<?php
$this->breadcrumbs=array(
	'Pnews Types'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List PNewsType','url'=>array('index')),
array('label'=>'Create PNewsType','url'=>array('create')),
array('label'=>'Update PNewsType','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PNewsType','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PNewsType','url'=>array('admin')),
);
?>

<h1>View News Type #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'status_hiden',
		'status',
),
)); ?>
