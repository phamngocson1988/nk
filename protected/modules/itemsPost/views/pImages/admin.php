<?php
$this->breadcrumbs=array(
	'Pimages'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List PImages','url'=>array('index')),
array('label'=>'Create PImages','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('pimages-grid', {
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
'id'=>'pimages-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		// 'id_type',
		array(
                 'value'=>function($data){
                    echo $data->rel_type->name;
                },
                'name' => 'id_type',
                'header' => Yii::t('app','Images Type'),
            ),
		'name',
		'url_action',
		array(
		'name'=>'name_upload',
		'type'=>'raw',
		'value'=>'(!empty($data->name_upload))?CHtml::image(Yii::app()->baseUrl."/upload/images/md/".$data->name_upload,"",array("width13"=>"70px" ,"height"=>"70px")):CHtml::image(Yii::app()->baseUrl . "/upload/no_image.png","",array("width"=>"70px" ,"height"=>"70px"))',
            ),
		'update_time',
        array(
        'name'=>'data_upload',
        'type'=>'raw',
        'value'=>'(!empty($data->data_upload))?CHtml::image($data->data_upload,"",array("width"=>"50px" ,"height"=>"50px")):CHtml::image(Yii::app()->baseUrl . "/upload/no_image.png","",array("width"=>"50px" ,"height"=>"50px"))',
            ),
        
       array(
        'class' => 'booster.widgets.TbToggleColumn',
       	'toggleAction' => 'PImages/toggle',
        'name' => 'status_hidden',
        'header' => Yii::t('app','Status&nbspHidden'),
        ),
array(
'class'=>'booster.widgets.TbButtonColumn',
'header'=>'Action',
),
),
)); ?>
