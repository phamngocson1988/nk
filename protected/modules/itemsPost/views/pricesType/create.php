<?php
$this->breadcrumbs=array(
	'Prices Types'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PricesType','url'=>array('index')),
array('label'=>'Manage PricesType','url'=>array('admin')),
);
?>

<h1>Create PricesType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>