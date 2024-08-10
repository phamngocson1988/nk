<?php
$this->breadcrumbs=array(
	'Preview Customers',
);

$this->menu=array(
array('label'=>'Create PReviewCustomer','url'=>array('create')),
array('label'=>'Manage PReviewCustomer','url'=>array('admin')),
);
?>

<h1>Preview Customers</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
