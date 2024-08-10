<?php
$this->breadcrumbs=array(
	'Pinfrastructure Types',
);

$this->menu=array(
array('label'=>'Create PInfrastructureType','url'=>array('create')),
array('label'=>'Manage PInfrastructureType','url'=>array('admin')),
);
?>

<h1>Pinfrastructure Types</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
