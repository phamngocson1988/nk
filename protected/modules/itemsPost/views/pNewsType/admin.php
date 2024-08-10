<?php
$this->breadcrumbs=array(
	'Pnews Types'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List PNewsType','url'=>array('index')),
array('label'=>'Create PNewsType','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('pnews-type-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<div id="box_search_info" class="row clearfix search-form" style="text-align:center" >
	<?php 
	$temp_id = '';
        if(isset($id)){
            $temp_id = $id;
        }
	$this->renderPartial('_search',array('model'=>$model,'id'=>$temp_id)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'pnews-type-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		// 'id',
		'name',
		// 'status_hiden',
		array(
                'class' => 'booster.widgets.TbToggleColumn',
               	'toggleAction' => 'PNewsType/toggle',
                'name' => 'status_hiden',
                'header' => Yii::t('app','Status&nbsp;hiden'),
            ),
		// 'status',
		array(
                'class' => 'booster.widgets.TbToggleColumn',
               	'toggleAction' => 'PNewsType/toggle',
                'name' => 'status',
                'header' => Yii::t('app','Status'),
            ),
array(
'class'=>'booster.widgets.TbButtonColumn',
'header'=>'Action',
),
),
)); ?>
