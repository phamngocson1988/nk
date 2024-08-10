<?php
$this->breadcrumbs=array(
	'Pinfrastructures',
);

$this->menu=array(
array('label'=>'Create PInfrastructure','url'=>array('create')),
array('label'=>'Manage PInfrastructure','url'=>array('admin')),
);
?>

<h1>Pinfrastructures</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
