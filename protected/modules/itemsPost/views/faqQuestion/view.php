<?php
$this->breadcrumbs=array(
	'FaqQuestions'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Faq Question','url'=>array('index')),
array('label'=>'Create Faq Question','url'=>array('create')),
array('label'=>'Update Faq Question','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Faq Question','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Faq Question','url'=>array('admin')),
);
?>

<h1>View Faq Question #<?php echo $model->id; ?></h1>
<?php $ima=isset($model->image)!=""?$model->image:'no_image.png'; ?>
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'phone',
		'email',
		array(
			'name'=>'image',
			'type'=>'raw',
			'value'=>CHtml::image(Yii::app()->baseUrl. '/upload/post/faq/'.$ima,"",array("width"=>"50px" ,"height"=>"50px")),
        ),
		'content',
		'answer',
),
)); ?>
