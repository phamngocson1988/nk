<?php
$this->breadcrumbs=array(
	'Faq Types'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List FaqType','url'=>array('index')),
array('label'=>'Create FaqType','url'=>array('create')),
array('label'=>'Update FaqType','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete FaqType','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage FaqType','url'=>array('admin')),
);
?>

<h1>View FaqType #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'status_hiden',
		'status',
),
)); ?>
