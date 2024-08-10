<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.table2excel.min.js"></script> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.tabletoCSV.js" charset="utf-8"></script> 

<?php
include 'style.php';
?>

<div id="oSrchBar" class="col-md-12">
	<?php include '_frmSearch.php'; ?>
</div>

<div id="idwaiting_search"></div>
<div class="col-md-12 margin-top-20" id="return_content" style="overflow: auto;">

</div>