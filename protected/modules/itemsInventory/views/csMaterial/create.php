<?php
$this->breadcrumbs=array(
	'Cs Materials'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List CsMaterial','url'=>array('index')),
array('label'=>'Manage CsMaterial','url'=>array('admin')),
);
?>

<h3>Create Material</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>