

<div id="oSrchBar" class="col-md-12">
  <?php include_once('_frmSearch.php') ?>
</div>
<div id="idwaiting_search"></div>
<div class="col-md-12 margin-top-20" id="return_content" style="overflow: auto;">
  <?php include_once('executive.php') ?>
</div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.table2excel.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.tabletoCSV.js" charset="utf-8"></script>

<script type="text/javascript">
    $('.excel').click(function () {
      	$('#list_export').table2excel({
      		name: "file",
      		filename: "DanhSach",
      		fileext: ".xls"
      	});
    });
    $('.word').click(function () {
      	$('#list_export').table2excel({
      		name: "file",
      		filename: "DanhSach",
      		fileext: ".doc"
    	});
    });
    $(function () {
      	$(".csv").click(function () {
      		$("#list_export").tableToCSV();
      	});
    });
</script>
