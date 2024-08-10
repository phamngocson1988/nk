<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Supplier','url'=>array('index')),
	array('label'=>'Create Supplier','url'=>array('create')),
	array('label'=>'View Supplier','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Supplier','url'=>array('admin')),
	);
	?>

	<h3 class="text-center">Update Supplier <?php echo $model->id; ?></h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>