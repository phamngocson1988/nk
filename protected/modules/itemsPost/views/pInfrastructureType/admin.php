<?php
$this->breadcrumbs=array(
	'Pinfrastructure Types'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List PInfrastructureType','url'=>array('index')),
array('label'=>'Create PInfrastructureType','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('pinfrastructure-type-grid', {
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
'id'=>'pinfrastructure-type-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'name',
		// 'upload_name',
		array(
		'name'=>'upload_name',
		'type'=>'raw',
		'value'=>'(!empty($data->upload_name))?CHtml::image(Yii::app()->baseUrl."/upload/infrastructure_type/md/".$data->upload_name,"",array("width"=>"70px" ,"height"=>"70px")):CHtml::image(Yii::app()->baseUrl . "/upload/no_image.png","",array("width"=>"70px" ,"height"=>"70px"))',
            ),
		'status_hidden',
array(
'class'=>'booster.widgets.TbButtonColumn',
'header'=>'Action',
),
),
)); ?>
