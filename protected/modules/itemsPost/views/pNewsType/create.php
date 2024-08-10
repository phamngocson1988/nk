<?php
$this->breadcrumbs=array(
	'Pnews Types'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PNewsType','url'=>array('index')),
array('label'=>'Manage PNewsType','url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>