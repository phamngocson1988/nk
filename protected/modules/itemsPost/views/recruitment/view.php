<?php
$this->breadcrumbs=array(
	'News'=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>'List News','url'=>array('index')),
array('label'=>'Create News','url'=>array('create')),
array('label'=>'Update News','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete News','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage News','url'=>array('admin')),
);
?>

<h1>View News #<?php echo $model->id; ?></h1>
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
		'value'=>CHtml::image(Yii::app()->baseUrl. '/upload/post/recruitment/lg/'.$ima,"",array("width"=>"50px" ,"height"=>"50px")),
            ),
		'description',
		'content',
		'createdate',
		'postdate',
		'total_view',
		'status_hiden',
		'status',
),
)); ?>
