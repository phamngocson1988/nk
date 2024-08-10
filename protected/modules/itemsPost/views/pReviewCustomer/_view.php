<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('r_name')); ?>:</b>
	<?php echo CHtml::encode($data->r_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('r_img')); ?>:</b>
	<?php echo CHtml::encode($data->r_img); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('r_content')); ?>:</b>
	<?php echo CHtml::encode($data->r_content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_hidden')); ?>:</b>
	<?php echo CHtml::encode($data->status_hidden); ?>
	<br />


</div>
