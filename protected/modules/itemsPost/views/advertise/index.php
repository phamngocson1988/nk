<?php
$this->breadcrumbs=array(
	'Advertises',
);

$this->menu=array(
array('label'=>'Create Advertise','url'=>array('create')),
array('label'=>'Manage Advertise','url'=>array('admin')),
);
?>

<h1>Advertises</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
