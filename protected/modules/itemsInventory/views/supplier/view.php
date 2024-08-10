<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Supplier','url'=>array('index')),
array('label'=>'Create Supplier','url'=>array('create')),
array('label'=>'Update Supplier','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Supplier','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Supplier','url'=>array('admin')),
);
?>

<h1>View Supplier #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'contact_person',
		'phone',
		'address',
		'total_amount',
		'total_debt',
		'create_date',
		'update_date',
),
)); ?>
