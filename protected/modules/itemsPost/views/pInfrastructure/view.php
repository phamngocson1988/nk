<?php
$this->breadcrumbs=array(
	'Pinfrastructures'=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>'List PInfrastructure','url'=>array('index')),
array('label'=>'Create PInfrastructure','url'=>array('create')),
array('label'=>'Update PInfrastructure','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PInfrastructure','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PInfrastructure','url'=>array('admin')),
);
?>

<h1>View PInfrastructure #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'id_type',
		'title',
		'content',
		'date_upload',
		'status_hidden',
),
)); ?>
