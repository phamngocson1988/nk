<?php
$this->breadcrumbs=array(
	'Cs Material Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List CsMaterialGroup','url'=>array('index')),
	array('label'=>'Create CsMaterialGroup','url'=>array('create')),
	array('label'=>'View CsMaterialGroup','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage CsMaterialGroup','url'=>array('admin')),
	);
	?>

	<h3>Update Material Group <?php echo $model->id; ?></h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>