<?php
$this->breadcrumbs=array(
	'Preview Customers'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PReviewCustomer','url'=>array('index')),
array('label'=>'Manage PReviewCustomer','url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>