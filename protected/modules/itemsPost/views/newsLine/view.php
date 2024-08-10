<?php
$this->breadcrumbs=array(
	'News Lines'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List NewsLine','url'=>array('index')),
array('label'=>'Create NewsLine','url'=>array('create')),
array('label'=>'Update NewsLine','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete NewsLine','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage NewsLine','url'=>array('admin')),
);
?>

<h1>View NewsLine #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'id_news_type',
		'name',
		'status_hiden',
		'status',
),
)); ?>
