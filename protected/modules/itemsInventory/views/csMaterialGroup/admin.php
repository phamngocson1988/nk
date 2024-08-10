<?php
$this->breadcrumbs=array(
	'Cs Material Groups'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List CsMaterialGroup','url'=>array('index')),
array('label'=>'Create CsMaterialGroup','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('cs-material-group-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3 class="text-center">Manage Material Groups</h3>

<div class="search-form">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'cs-material-group-grid',
'dataProvider'=>$model->search(),
'columns'=>array(
		array(
            'name' => 'name',
            'htmlOptions' => array('width' => '20%'),
        ),
		array(
            'name' => 'description',
            'htmlOptions' => array('width' => '30%'),
        ),
		array(
            'name'=>'type',
            'value'=>'$data->getSource()',
	    ),
		'create_date',
		'update_date',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
