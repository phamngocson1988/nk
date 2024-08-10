<?php
$this->breadcrumbs=array(
	'News Lines'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List NewsLine','url'=>array('index')),
	array('label'=>'Create NewsLine','url'=>array('create')),
	array('label'=>'View NewsLine','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage NewsLine','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>