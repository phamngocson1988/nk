<?php
$this->breadcrumbs=array(
	'News Lines',
);

$this->menu=array(
array('label'=>'Create NewsLine','url'=>array('create')),
array('label'=>'Manage NewsLine','url'=>array('admin')),
);
?>

<h1>News Lines</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
