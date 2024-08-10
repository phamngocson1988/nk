<?php
$this->breadcrumbs=array(
	'Faq Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List FaqType','url'=>array('index')),
	array('label'=>'Create FaqType','url'=>array('create')),
	array('label'=>'View FaqType','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage FaqType','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>