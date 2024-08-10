<?php
$this->breadcrumbs=array(
	'Tags',
);

$this->menu=array(
array('label'=>'Create Tags','url'=>array('create')),
array('label'=>'Manage Tags','url'=>array('admin')),
);
?>


<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
