<?php
$this->breadcrumbs=array(
	'Cs Materials'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List CsMaterial','url'=>array('index')),
	array('label'=>'Create CsMaterial','url'=>array('create')),
	array('label'=>'View CsMaterial','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage CsMaterial','url'=>array('admin')),
	);
	?>

	<h3>Update Material <?php echo $model->id; ?></h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>