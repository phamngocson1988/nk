<?php
$this->breadcrumbs=array(
	'Repositories'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Repository','url'=>array('index')),
array('label'=>'Create Repository','url'=>array('create')),
array('label'=>'Update Repository','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Repository','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Repository','url'=>array('admin')),
);
?>

<h3>View Repository #<?php echo $model->id; ?></h3>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'id_branch',
		'code',
		'name',
		'description',
		'type_repository',
		'create_date',
		'update_date',
		'status',
),
)); ?>
