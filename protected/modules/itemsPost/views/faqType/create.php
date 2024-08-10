<?php
$this->breadcrumbs=array(
	'Faq Types'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List FaqType','url'=>array('index')),
array('label'=>'Manage FaqType','url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>