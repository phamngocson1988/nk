<?php
$this->breadcrumbs=array(
	'Tags'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Tags','url'=>array('index')),
array('label'=>'Create Tags','url'=>array('create')),
array('label'=>'Update Tags','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Tags','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Tags','url'=>array('admin')),
);
?>

<h1>View Tags #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'status',
),
)); ?>
