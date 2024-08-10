<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Supplier','url'=>array('index')),
array('label'=>'Create Supplier','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('supplier-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3 class="text-center">Manage Suppliers</h3>

<div class="search-form" >
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'supplier-grid',
'dataProvider'=>$model->search(),

'columns'=>array(
		'name',
		'contact_person',
		'phone',
		'address',
		'total_amount',
		'total_debt',
		'create_date',
		array(
		'class'=>'booster.widgets.TbButtonColumn',
		),
),
)); ?>
