<?php
$this->breadcrumbs=array(
	'Faq Lines'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List FaqLine','url'=>array('index')),
array('label'=>'Create FaqLine','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('faq-line-grid', {
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
'id'=>'faq-line-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'id',
		//'id_faq_type',
		array(
                 'value'=>function($data){
                    echo $data->rel_type->name;
                },
                'name' => 'id_faq_type',
                'header' => Yii::t('app','FAQ Type'),
            ),
		'name',
		array(
                'class' => 'booster.widgets.TbToggleColumn',
               	'toggleAction' => 'FaqLine/toggle',
                'name' => 'status_hiden',
                'header' => Yii::t('app','Status&nbsp;hiden'),
            ),
		// 'status',
		array(
                'class' => 'booster.widgets.TbToggleColumn',
               	'toggleAction' => 'FaqLine/toggle',
                'name' => 'status',
                'header' => Yii::t('app','Status'),
            ),
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
