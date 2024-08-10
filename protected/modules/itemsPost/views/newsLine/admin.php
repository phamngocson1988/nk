<?php
$this->breadcrumbs=array(
	'News Lines'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List NewsLine','url'=>array('index')),
array('label'=>'Create NewsLine','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('news-line-grid', {
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
'id'=>'news-line-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		// 'id',
		// 'id_news_type',
		array(
                 'value'=>function($data){
                    echo $data->rel_type->name;
                },
                'name' => 'id_news_type',
                'header' => Yii::t('app','Product Type'),
            ),
		'name',
		array(
                'class' => 'booster.widgets.TbToggleColumn',
               	'toggleAction' => 'NewsLine/toggle',
                'name' => 'status_hiden',
                'header' => Yii::t('app','Status&nbsp;hiden'),
            ),
		// 'status',
		array(
                'class' => 'booster.widgets.TbToggleColumn',
               	'toggleAction' => 'NewsLine/toggle',
                'name' => 'status',
                'header' => Yii::t('app','Status'),
            ),
array(
'class'=>'booster.widgets.TbButtonColumn',
'header'=>'Action',
),
),
)); ?>
