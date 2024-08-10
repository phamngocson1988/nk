<?php
$this->breadcrumbs=array(
	'Promotions'=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>'List Promotion','url'=>array('index')),
array('label'=>'Create Promotion','url'=>array('create')),
array('label'=>'Update Promotion','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Promotion','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Promotion','url'=>array('admin')),
);
?>

<h1>View Promotion #<?php echo $model->id; ?></h1>
<?php $ima=isset($model->image)!=""?$model->image:'no_image.png'; ?>
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'id_user',
		'title',
		array(
		'name'=>'image',
		'type'=>'raw',
		'value'=>CHtml::image(Yii::app()->baseUrl . '/upload/post/promotion/lg/'.$ima,"",array("width"=>"50px" ,"height"=>"50px")),
            ),
		'description',
		'content',
		'createdate',
		'postdate',
		'status_hiden',
		'status',
),
)); ?>
