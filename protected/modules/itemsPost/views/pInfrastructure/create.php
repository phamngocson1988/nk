<?php
$this->breadcrumbs=array(
	'Pinfrastructures'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PInfrastructure','url'=>array('index')),
array('label'=>'Manage PInfrastructure','url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>