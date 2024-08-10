<?php
$this->breadcrumbs=array(
	'Pnews Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List PNewsType','url'=>array('index')),
	array('label'=>'Create PNewsType','url'=>array('create')),
	array('label'=>'View PNewsType','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PNewsType','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>