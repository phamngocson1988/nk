<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upload_name')); ?>:</b>
	<?php echo CHtml::encode($data->upload_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_hidden')); ?>:</b>
	<?php echo CHtml::encode($data->status_hidden); ?>
	<br />


</div>
