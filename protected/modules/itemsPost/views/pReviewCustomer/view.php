<?php
$this->breadcrumbs=array(
	'Preview Customers'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List PReviewCustomer','url'=>array('index')),
array('label'=>'Create PReviewCustomer','url'=>array('create')),
array('label'=>'Update PReviewCustomer','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PReviewCustomer','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PReviewCustomer','url'=>array('admin')),
);
?>

<h1>View PReviewCustomer #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'r_name',
		'r_img',
		'r_content',
		'status_hidden',
),
)); ?>
