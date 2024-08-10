<?php
$this->breadcrumbs=array(
	'Cs Material Groups'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List CsMaterialGroup','url'=>array('index')),
array('label'=>'Manage CsMaterialGroup','url'=>array('admin')),
);
?>

<h3>Create Material Group</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>