<?php
$this->breadcrumbs=array(
	'FaqQuestions'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List FaqQuestion','url'=>array('index')),
array('label'=>'Manage FaqQuestion','url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>