<?php
$this->breadcrumbs=array(
	'Cs Materials',
);

$this->menu=array(
array('label'=>'Create CsMaterial','url'=>array('create')),
array('label'=>'Manage CsMaterial','url'=>array('admin')),
);
?>

<h1>Cs Materials</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
