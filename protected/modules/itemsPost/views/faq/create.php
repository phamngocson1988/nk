<?php
$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Faq','url'=>array('index')),
array('label'=>'Manage Faq','url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>