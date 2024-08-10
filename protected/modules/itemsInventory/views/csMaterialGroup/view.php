<?php
$this->breadcrumbs=array(
	'Cs Material Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List CsMaterialGroup','url'=>array('index')),
array('label'=>'Create CsMaterialGroup','url'=>array('create')),
array('label'=>'Update CsMaterialGroup','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete CsMaterialGroup','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage CsMaterialGroup','url'=>array('admin')),
);
?>

<h3>View Material Group #<?php echo $model->id; ?></h3>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'description',
		'type',
		'create_date',
		'update_date',
		'status',
),
)); ?>
