<?php
$this->breadcrumbs=array(
	'Preview Customers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List PReviewCustomer','url'=>array('index')),
	array('label'=>'Create PReviewCustomer','url'=>array('create')),
	array('label'=>'View PReviewCustomer','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PReviewCustomer','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>