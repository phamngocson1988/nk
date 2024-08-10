<?php
$this->breadcrumbs=array(
	'Pimages'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PImages','url'=>array('index')),
array('label'=>'Manage PImages','url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>