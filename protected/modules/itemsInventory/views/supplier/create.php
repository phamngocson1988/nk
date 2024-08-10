<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Supplier','url'=>array('index')),
array('label'=>'Manage Supplier','url'=>array('admin')),
);
?>

<h3 class="text-center">Create Supplier</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>