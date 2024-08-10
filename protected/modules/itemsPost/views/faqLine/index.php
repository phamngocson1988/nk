<?php
$this->breadcrumbs=array(
	'Faq Lines',
);

$this->menu=array(
array('label'=>'Create FaqLine','url'=>array('create')),
array('label'=>'Manage FaqLine','url'=>array('admin')),
);
?>

<h1>Faq Lines</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
