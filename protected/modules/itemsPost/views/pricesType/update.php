<?php
$this->breadcrumbs=array(
	'Prices Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List PricesType','url'=>array('index')),
	array('label'=>'Create PricesType','url'=>array('create')),
	array('label'=>'View PricesType','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PricesType','url'=>array('admin')),
	);
	?>

	<h1>Update PricesType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>