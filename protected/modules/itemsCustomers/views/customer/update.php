<?php
$this->breadcrumbs=array(
	'Customers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Customer','url'=>array('index')),
	array('label'=>'Create Customer','url'=>array('create')),
	array('label'=>'View Customer','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Customer','url'=>array('admin')),
	);
	?>

	

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>