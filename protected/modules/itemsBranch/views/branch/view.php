<?php
$this->breadcrumbs=array(
	'Branches'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Branch','url'=>array('index')),
array('label'=>'Create Branch','url'=>array('create')),
array('label'=>'Update Branch','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Branch','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Branch','url'=>array('admin')),
);
?>

<h1>View Branch #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'address',
		'id_country',
		'id_city',
		'hotline1',
		'hotline2',
		'status',
),
)); ?>
