<?php
$this->breadcrumbs=array(
	'Pimages Types'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PImagesType','url'=>array('index')),
array('label'=>'Manage PImagesType','url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>