<?php
$this->breadcrumbs=array(
	'Pimages',
);

$this->menu=array(
array('label'=>'Create PImages','url'=>array('create')),
array('label'=>'Manage PImages','url'=>array('admin')),
);
?>

<h1>Pimages</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
