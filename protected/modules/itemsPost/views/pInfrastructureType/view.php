<?php
$this->breadcrumbs=array(
	'Pinfrastructure Types'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List PInfrastructureType','url'=>array('index')),
array('label'=>'Create PInfrastructureType','url'=>array('create')),
array('label'=>'Update PInfrastructureType','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PInfrastructureType','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PInfrastructureType','url'=>array('admin')),
);
?>

<h1>View PInfrastructureType #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'upload_name',
		'status_hidden',
),
)); ?>
