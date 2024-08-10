<?php
$this->breadcrumbs=array(
	'Promotions',
);

$this->menu=array(
array('label'=>'Create Promotion','url'=>array('create')),
array('label'=>'Manage Promotion','url'=>array('admin')),
);
?>

<h1>Promotions</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
