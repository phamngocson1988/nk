<?php
$this->breadcrumbs=array(
	'Cs Material Groups',
);

$this->menu=array(
array('label'=>'Create CsMaterialGroup','url'=>array('create')),
array('label'=>'Manage CsMaterialGroup','url'=>array('admin')),
);
?>

<h1>Cs Material Groups</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
