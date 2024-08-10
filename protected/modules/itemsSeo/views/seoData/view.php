<?php
$this->breadcrumbs=array(
	'Seo Datas'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List SeoData','url'=>array('index')),
array('label'=>'Create SeoData','url'=>array('create')),
array('label'=>'Update SeoData','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete SeoData','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage SeoData','url'=>array('admin')),
);
?>

<h1>View SeoData #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'meta_title',
		'meta_keywords',
		'meta_description',
),
)); ?>
