<?php $baseUrl = Yii::app()->baseUrl; ?>

<div id="medical_record"> 
	<?php 
	if($model->id){
		include("medical_record.php");
	}
	?>
</div>