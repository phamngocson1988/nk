<?php
$this->breadcrumbs=array(
	'Preview Customers'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List PReviewCustomer','url'=>array('index')),
array('label'=>'Create PReviewCustomer','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('preview-customer-grid', {
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
'id'=>'preview-customer-grid',
'type' => 'striped bordered condensed',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'id',
		'r_name',
		//'r_img',
		array(
		'name'=>'r_img',
		'type'=>'raw',
		'value'=>'(!empty($data->r_img))?CHtml::image(Yii::app()->baseUrl."/upload/post/review/lg/".$data->r_img,"",array("width"=>"50px" ,"height"=>"50px")):CHtml::image(Yii::app()->baseUrl . "/upload/post/review/no_image.png","",array("width"=>"50px" ,"height"=>"50px"))',
            ),
		'r_content',
		//'status_hidden',
		array(
        'class' => 'booster.widgets.TbToggleColumn',
       	'toggleAction' => 'PReviewCustomer/toggle',
        'name' => 'status_hidden',
        'header' => Yii::t('app','Status&nbspHidden'),
        ),
array(
'class'=>'booster.widgets.TbButtonColumn',
'header'=>'Action',
),
),
)); ?>
