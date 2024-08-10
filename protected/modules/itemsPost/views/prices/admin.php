<?php
$this->breadcrumbs=array(
	'Prices'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Prices','url'=>array('index')),
array('label'=>'Create Prices','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('prices-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<div id="box_search_info" class="row clearfix search-form" >
	<?php 
	$temp_id = '';
        if(isset($id)){
            $temp_id = $id;
        }
	$this->renderPartial('_search',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'prices-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),

'filter'=>$model,
'pager' => array(
       'class' => 'booster.widgets.TbPager',
       'displayFirstAndLast' => true,
),
'columns'=>array(
		'id',
		array(
            'name'=>'id_prices_type',
            'value'=>function($data){
                echo $data->rel_prices_type->name;
            },
			'header' => Yii::t('app','Prices type'),
        ),
		'name',
		array(
            'class' => 'booster.widgets.TbToggleColumn',
            'toggleAction' => 'Prices/ToggleBlock',
            'name' => 'status_hiden',
            'header' => Yii::t('app','Status&nbsp;hiden'),

        ),
        array(
		'class'=>'booster.widgets.TbButtonColumn',
		'header'=>'Action',
		),
),
)); ?>

<div class="margin-top-20"></div>
