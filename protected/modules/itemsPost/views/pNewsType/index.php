<?php
$this->breadcrumbs=array(
	'Pnews Types',
);

$this->menu=array(
array('label'=>'Create PNewsType','url'=>array('create')),
array('label'=>'Manage PNewsType','url'=>array('admin')),
);
?>

<h1>Pnews Types</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
