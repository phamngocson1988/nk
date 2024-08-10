<?php
$this->breadcrumbs=array(
	'Branches',
);

$this->menu=array(
array('label'=>'Create Branch','url'=>array('create')),
array('label'=>'Manage Branch','url'=>array('admin')),
);
?>

<h1>Branches</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
