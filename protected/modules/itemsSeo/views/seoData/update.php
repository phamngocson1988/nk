<?php
$this->breadcrumbs=array(
	'Seo Datas'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List SeoData','url'=>array('index')),
	array('label'=>'Create SeoData','url'=>array('create')),
	array('label'=>'View SeoData','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SeoData','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>