<?php
$this->breadcrumbs=array(
	'Pinfrastructures'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List PInfrastructure','url'=>array('index')),
	array('label'=>'Create PInfrastructure','url'=>array('create')),
	array('label'=>'View PInfrastructure','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PInfrastructure','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>