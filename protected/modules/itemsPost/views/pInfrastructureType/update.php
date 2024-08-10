<?php
$this->breadcrumbs=array(
	'Pinfrastructure Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List PInfrastructureType','url'=>array('index')),
	array('label'=>'Create PInfrastructureType','url'=>array('create')),
	array('label'=>'View PInfrastructureType','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PInfrastructureType','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>