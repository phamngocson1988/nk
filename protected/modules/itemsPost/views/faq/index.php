<?php
$this->breadcrumbs=array(
	'Faqs',
);

$this->menu=array(
array('label'=>'Create Faq','url'=>array('create')),
array('label'=>'Manage Faq','url'=>array('admin')),
);
?>

<h1>Faqs</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
