<?php
$this->breadcrumbs=array(
	'Prices Types'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List PricesType','url'=>array('index')),
array('label'=>'Create PricesType','url'=>array('create')),
array('label'=>'Update PricesType','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PricesType','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PricesType','url'=>array('admin')),
);
?>

<h1>View PricesType #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'description',
		'createdate',
		'status_hiden',
		'status',
),
)); ?>
