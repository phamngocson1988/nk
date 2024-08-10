<?php
$this->breadcrumbs=array(
	'Abouts'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Introduce Services','url'=>array('index')),
array('label'=>'Create Introduce Services','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('about-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Introduce Services</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'about-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'title',
		'content',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
