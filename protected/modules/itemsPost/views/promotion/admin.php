<?php
$this->breadcrumbs=array(
	'Promotions'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Promotion','url'=>array('index')),
array('label'=>'Create Promotion','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('promotion-grid', {
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
'id'=>'promotion-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		
		
		'title',
		array(
                 'value'=>function($data){
                    echo $data->rel_user->name;
                },
                'name' => 'id_user',
                'header' => Yii::t('app','User'),
            ),
		array(
		'name'=>'image',
		'type'=>'raw',
		'value'=>'(!empty($data->image))?CHtml::image(Yii::app()->baseUrl . "/upload/post/promotion/lg/".$data->image,"",array("width"=>"50px" ,"height"=>"50px")):CHtml::image(Yii::app()->baseUrl . "/upload/no_image.png","",array("width"=>"50px" ,"height"=>"50px"))',
            ),
		'description',
		
		array(
                'class' => 'booster.widgets.TbToggleColumn',
               
                'name' => 'status_hiden',
                'header' => Yii::t('app','Status&nbsp;hiden'),
            ),
	
array(
'class'=>'booster.widgets.TbButtonColumn',
'header'=>'Action',
),
),
)); ?>
