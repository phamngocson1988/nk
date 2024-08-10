<?php
$this->breadcrumbs=array(
	'Pimages'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List PImages','url'=>array('index')),
array('label'=>'Create PImages','url'=>array('create')),
array('label'=>'Update PImages','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PImages','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PImages','url'=>array('admin')),
);
?>

<h1>View PImages #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'id_type',
		'name',
		'url_action',
		'name_upload',
		'update_time',
		'status_hidden',
),
)); ?>
