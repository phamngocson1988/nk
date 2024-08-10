<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.table2excel.min.js"></script> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.tabletoCSV.js" charset="utf-8"></script>
<style>
	.input_product{width: 250px !important;}
</style>
<div id="oSrchBar" class="col-md-12">
  <?php include_once('_frmSearch.php') ?>
</div>
<div id="idwaiting_search"></div>
<div class="col-md-12 margin-top-20" id="return_content" style="overflow: auto;">
  
</div>
<script>
	  $('.excel').click(function(){
	      $('#list_export').table2excel({
	          name: "file",
	          filename: "DanhSachSanPham",
	          fileext: ".xls"
	      });
	   });  
		$('.word').click(function(){
	      $('#list_export').table2excel({
	          name: "file",
	          filename: "DanhSachSanPham",
	          fileext: ".doc"
	      });
	   });  
		$(function(){
            $(".csv").click(function(){
                $("#list_export").tableToCSV(
                );
            });
	   });
</script>