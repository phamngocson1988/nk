<?php
$this->breadcrumbs=array(
	'Prices Types',
);

$this->menu=array(
array('label'=>'Create PricesType','url'=>array('create')),
array('label'=>'Manage PricesType','url'=>array('admin')),
);
?>

<h1>Prices Types</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
