<?php
$this->breadcrumbs=array(
	'Pricess'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Prices','url'=>array('index')),
array('label'=>'Manage Prices','url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>