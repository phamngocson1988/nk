<?php
$this->breadcrumbs=array(
	'Pimages'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List PImages','url'=>array('index')),
	array('label'=>'Create PImages','url'=>array('create')),
	array('label'=>'View PImages','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PImages','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>