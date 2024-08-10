<?php
$this->breadcrumbs=array(
	'Seo Datas'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List SeoData','url'=>array('index')),
array('label'=>'Manage SeoData','url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>