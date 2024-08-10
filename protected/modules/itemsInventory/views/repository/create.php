<?php
$this->breadcrumbs=array(
	'Repositories'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Repository','url'=>array('index')),
array('label'=>'Manage Repository','url'=>array('admin')),
);
?>

<h3>Create Repository</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>