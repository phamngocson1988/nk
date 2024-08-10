<?php
$this->breadcrumbs=array(
	'Pinfrastructure Types'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PInfrastructureType','url'=>array('index')),
array('label'=>'Manage PInfrastructureType','url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>