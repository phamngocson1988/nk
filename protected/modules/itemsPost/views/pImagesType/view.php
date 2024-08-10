<?php
$this->breadcrumbs=array(
	'Pimages Types'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List PImagesType','url'=>array('index')),
array('label'=>'Create PImagesType','url'=>array('create')),
array('label'=>'Update PImagesType','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PImagesType','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PImagesType','url'=>array('admin')),
);
?>

<h1>View PImagesType #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'block',
		'status_hidden',
),
)); ?>
