<?php
$this->breadcrumbs=array(
	'Pimages Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List PImagesType','url'=>array('index')),
	array('label'=>'Create PImagesType','url'=>array('create')),
	array('label'=>'View PImagesType','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PImagesType','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>