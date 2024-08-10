<?php
$this->breadcrumbs=array(
	'Faq Lines'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List FaqLine','url'=>array('index')),
	array('label'=>'Create FaqLine','url'=>array('create')),
	array('label'=>'View FaqLine','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage FaqLine','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>