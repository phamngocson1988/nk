<?php
$this->breadcrumbs=array(
	'Prices'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Prices','url'=>array('index')),
	array('label'=>'Create Prices','url'=>array('create')),
	array('label'=>'View Prices','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Prices','url'=>array('admin')),
	);
	?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>