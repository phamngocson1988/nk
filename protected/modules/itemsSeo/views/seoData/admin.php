<?php
$this->breadcrumbs=array(
	'Seo Datas'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List SeoData','url'=>array('index')),
array('label'=>'Create SeoData','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('seo-data-grid', {
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
'id'=>'seo-data-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'name',
		'meta_title',
		'meta_keywords',
		'meta_description',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
