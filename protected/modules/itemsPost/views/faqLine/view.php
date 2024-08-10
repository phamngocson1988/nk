<?php
$this->breadcrumbs=array(
	'Faq Lines'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List FaqLine','url'=>array('index')),
array('label'=>'Create FaqLine','url'=>array('create')),
array('label'=>'Update FaqLine','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete FaqLine','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage FaqLine','url'=>array('admin')),
);
?>

<h1>View FaqLine #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'id_faq_type',
		'name',
		'status_hiden',
		'status',
),
)); ?>
