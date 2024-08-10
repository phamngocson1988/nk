<?php
$this->breadcrumbs=array(
	'Faq Lines'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List FaqLine','url'=>array('index')),
array('label'=>'Manage FaqLine','url'=>array('admin')),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>