<?php
$this->breadcrumbs=array(
	'Seo Datas',
);

$this->menu=array(
array('label'=>'Create SeoData','url'=>array('create')),
array('label'=>'Manage SeoData','url'=>array('admin')),
);
?>

<h1>Seo Datas</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
