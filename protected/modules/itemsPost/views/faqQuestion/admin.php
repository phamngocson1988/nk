<style>
    /*.update , .delete{display: none;}*/
</style>

<?php
$this->breadcrumbs=array(
	'FaqQuestions'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List FaqQuestion','url'=>array('index')),
array('label'=>'Create FaqQuestion','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('faqQuestion-grid', {
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
'id'=>'faqQuestion-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'name',
		'email',
		'phone',
		'content',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
