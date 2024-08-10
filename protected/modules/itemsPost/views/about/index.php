<?php
$this->breadcrumbs=array(
	'Abouts',
);

$this->menu=array(
array('label'=>'Create About','url'=>array('create')),
array('label'=>'Manage About','url'=>array('admin')),
);
?>

<h1>Abouts</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
