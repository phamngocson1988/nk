<?php
$this->breadcrumbs=array(
	'News'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List News','url'=>array('index')),
array('label'=>'Create News','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('news-grid', {
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
'id'=>'news-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
        array(
		'name'=>'image',
		'type'=>'raw',
		'value'=>'(!empty($data->image))?CHtml::image(Yii::app()->baseUrl."/upload/post/recruitment/lg/".$data->image,"",array("width"=>"50px" ,"height"=>"50px")):CHtml::image(Yii::app()->baseUrl . "/upload/post/recruitment/no_image.png","",array("width"=>"50px" ,"height"=>"50px"))',
            ),
		
		'title',
		'description',
		
array(
'class'=>'booster.widgets.TbButtonColumn',
'header'=>'Action',
),
),
)); ?>
