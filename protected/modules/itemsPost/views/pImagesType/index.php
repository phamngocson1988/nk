<?php
$this->breadcrumbs=array(
	'Pimages Types',
);

$this->menu=array(
array('label'=>'Create PImagesType','url'=>array('create')),
array('label'=>'Manage PImagesType','url'=>array('admin')),
);
?>

<h1>Pimages Types</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
