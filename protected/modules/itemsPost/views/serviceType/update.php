<?php
$this->breadcrumbs=array(
	'Service Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List ServiceType','url'=>array('index')),
	array('label'=>'Create ServiceType','url'=>array('create')),
	array('label'=>'View ServiceType','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ServiceType','url'=>array('admin')),
	);
	?>

	<h1>Update ServiceType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>