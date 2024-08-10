<?php
$this->breadcrumbs=array(
	'Repositories'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Repository','url'=>array('index')),
array('label'=>'Create Repository','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('repository-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3 class="text-center">Manage Repositories</h3>

<div class="search-form">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'repository-grid',
'dataProvider'=>$model->search(),
'columns'=>array(
		array(
            'value'=>function($data){
                echo $data->getNameBranch($data->id_branch);
            },
            'name' => 'id_branch',
            'header' => Yii::t('app','Chi nhánh'),
        ),
		'code',
		'name',
		'description',
		array(
            'name'=>'type_repository',
            'value'=>'$data->getSource()',
	    ),
		'create_date',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
