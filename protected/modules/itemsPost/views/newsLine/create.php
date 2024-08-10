<?php
$this->breadcrumbs=array(
	'News Lines'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List NewsLine','url'=>array('index')),
array('label'=>'Manage NewsLine','url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>