<?php
$this->breadcrumbs=array(
	'Cs Materials'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List CsMaterial','url'=>array('index')),
array('label'=>'Create CsMaterial','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('cs-material-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3 class='text-center'>Manage Materials</h3>

<div class="search-form">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'cs-material-grid',
'dataProvider'=>$model->search(),
'columns'=>array(
		array(
            'value'=>function($data){
                echo $data->getNameMaterialGroup($data->id_material_group);
            },
            'name' => 'id_material_group',
            'header' => Yii::t('app','Nhóm nguyên vật liệu'),
            'htmlOptions' => array('width' => '15%'),
        ),
        array(
            'name' => 'name',
            'htmlOptions' => array('width' => '20%'),
        ),
        'code',
		'accounting',
		array(
            'name' => 'description',
            'htmlOptions' => array('width' => '30%'),
        ),
        'unit',
		'create_date',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
