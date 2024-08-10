<?php
$this->breadcrumbs=array(
	'Tags'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Tags','url'=>array('index')),
array('label'=>'Manage Tags','url'=>array('admin')),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>