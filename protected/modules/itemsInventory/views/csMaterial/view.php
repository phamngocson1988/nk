<?php
$this->breadcrumbs=array(
	'Cs Materials'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List CsMaterial','url'=>array('index')),
array('label'=>'Create CsMaterial','url'=>array('create')),
array('label'=>'Update CsMaterial','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete CsMaterial','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage CsMaterial','url'=>array('admin')),
);
?>

<h3>View Material #<?php echo $model->id; ?></h3>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'id_material_group',
		'name',
		'code',
		'accounting',
		'description',
		'create_date',
		'update_date',
		'status',
),
)); ?>
