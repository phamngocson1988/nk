<?php
$this->breadcrumbs=array(
	'Tags'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Tags','url'=>array('index')),
	array('label'=>'Create Tags','url'=>array('create')),
	array('label'=>'View Tags','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Tags','url'=>array('admin')),
	);
	?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>