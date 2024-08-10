<?php
$this->breadcrumbs=array(
	'Services'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Service','url'=>array('index')),
array('label'=>'Create Service','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('service-grid', {
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
'id'=>'service-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),

'filter'=>$model,
'pager' => array(
           'class' => 'booster.widgets.TbPager',
           'displayFirstAndLast' => true,
    ),
'columns'=>array(
		array(
		'name'=>'image',
		'type'=>'raw',
		'value'=>'(!empty($data->image))?CHtml::image(Yii::app()->baseUrl . "/upload/post/service/lg/".$data->image,"",array("width"=>"50px" ,"height"=>"50px")):CHtml::image(Yii::app()->baseUrl . "/upload/no_image.png","",array("width"=>"50px" ,"height"=>"50px"))',
            ),
		array(
                'name'=>'id_service_type',
                'value'=>function($data){
                    echo $data->rel_service_type->name;
                },
				'header' => Yii::t('app','Service type'),
            ),
		'name',
		'content',
		'content_en',
		'stt',
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'header'=>'Action',
		),
    ),
)); ?>
<div class="margin-top-20"></div>
