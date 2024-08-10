<style type="text/css">
	.headertable {
		background-color: #8ca7ae;
	}
	.executive tbody td, .monthly tbody td, .customerspend tbody td, .servicevenue tbody td {
		background-color: #f1f5f6;
	}
	.multiselect-container{
		overflow: scroll;
		height: 300px;
	}
	.btn{
		color: black;
	}
</style>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.table2excel.min.js"></script> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.tabletoCSV.js" charset="utf-8"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-multiselect.js" charset="utf-8"></script> 
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-multiselect.css" type="text/css"/>
<div class="row contentDiv" style="margin-top: 10px;">
	<div id="search">
		<div class="col-md-2">
			<label>Loại: </label>
			<select id="select" class="form-control">
				<option value="1">Nhóm Dịch vụ</option>
				<option value="2">Chi tiết Dịch vụ</option>
			</select>
		</div>
		<div class="col-md-2">
			<label>Từ ngày: </label> 
			<input  type="text" id="fromtime" class="form-control" value="<?php echo date("Y-m-d"); ?>">
		</div>
		<div class="col-md-2">
			<label>Đến ngày: </label>
			<input  type="text" id="totime" class="form-control" value="<?php echo date("Y-m-d"); ?>">
		</div>
		<div class="col-md-2">
			<label>Bác sỹ: </label>
			<br>
			<select id="dentist" multiple="multiple" searchable="Search here..">
				<?php foreach ($dentist as $key => $value): ?>
					<option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="col-md-2 divdichvu"  style="display: none">
			<label>Dịch Vụ: </label>
			<br>
			<select id="dichvu" multiple="multiple" searchable="Search here..">
				<?php foreach ($listserviceType as $key => $serviceType): ?>
					<optgroup label="<?php echo $serviceType['name']?>">
						<?php foreach ($listCsService as $key => $CsService): ?>
							<?php if ($serviceType['id']==$CsService['id_service_type']): ?>
								<option value="<?php echo $CsService['id']?>"><?php echo $CsService['name']?></option>
								<?php 
								unset($listCsService[$key]);
							endif ?>
						<?php endforeach ?>
					</optgroup>
				<?php endforeach ?>
			</select>
		</div>
		<div id="oSrchLeft" class="pull-right col-xs-2" style="margin-top: 17px;">
			<!-- Split button -->
			<div class="btn-group">
				<button type="button" class="btn btn_bookoke" onclick="search_data()"><i class="fa fa-search-plus"></i>&nbsp;Xem</button>
				<button type="button" class="btn btn_bookoke dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu menu-export">
					<li><a href="#" class="print"><i class="fa fa-print"></i>&nbsp;In</a></li>
					<li><a href="#" class="btn_excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a></li>
					<li><a href="#" class="word"><i class="fa fa-file-word-o"></i>&nbsp;Word</a></li>
					<li><a href="#" class="pdf"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</a></li>
					<li><a href="#" class="csv"><i class="fa fa-file-o"></i>&nbsp;CSV</a></li>
				</ul>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="col-md-12 show" style="margin-top: 10px;overflow-y: auto;"></div>
</div>
<script type="text/javascript">
	$("#select").change(function(){
		if ($(this).val()==2) {
			$(".divdichvu").show();
		} else {
			$(".divdichvu").hide();
		}
	});
	$('.btn_excel').click(function(){
		var filename = $('#list_export').attr("name");
		var option = $("#select").val();
		$('#list_export').table2excel({
			name: "file",
			filename: filename,
			fileext: ".xls"
		});
	}); 
	$(function () {
		$('#fromtime').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
		$('#totime').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});
	$('#dentist').multiselect({
		includeSelectAllOption: true,
		selectAllNumber: false,
		enableFiltering: true,
		enableCaseInsensitiveFiltering:true,
	});
	$('#dichvu').multiselect({
		includeSelectAllOption: true,
		selectAllNumber: false,
		enableFiltering: true,
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableCaseInsensitiveFiltering:true,
	});
	function search_data() {
		var option = $("#select").val();
		var fromtime = $("#fromtime").val();
		var totime = $("#totime").val();
		var dentist = $("#dentist").val();
		var dichvu = $("#dichvu").val();

		if (dentist ==null) {
			dentist = 0;
		}else{
			dentist = dentist.toString();
		}

		if (dichvu ==null) {
			dichvu = 0;
		}else{
			dichvu = dichvu.toString();
		}


		if (option==1) {
			$('.cal-loading').fadeIn('fast');
			jQuery.ajax({
				type:"POST",
				url:"<?php echo CController::createUrl('ReportingTreatment/ShowTreatment')?>",
				data:{
					fromtime:fromtime,
					totime:totime,
					dentist:dentist,
					
				},
				beforeSend: function() {
					$('#idwaiting_main').html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/waitingmain.gif" alt="loading....." />');
				},
				success: function(data){
					$('.cal-loading').fadeOut('slow');
					$(".show").html(data);
				},error: function(xhr, ajaxOptions, thrownError){ 
					alert(xhr.status);
					alert(thrownError);
				}
			});
		} else {
			$('.cal-loading').fadeIn('fast');
			jQuery.ajax({
				type:"POST",
				url:"<?php echo CController::createUrl('ReportingTreatment/ShowDetailTreatment')?>",
				data:{
					fromtime:fromtime,
					totime:totime,
					dentist:dentist,
					status:dichvu,
				},
				beforeSend: function() {
					$('#idwaiting_main').html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/waitingmain.gif" alt="loading....." />');
				},
				success: function(data){
					$('.cal-loading').fadeOut('slow');
					$(".show").html(data);
				},error: function(xhr, ajaxOptions, thrownError){ 
					alert(xhr.status);
					alert(thrownError);
				}
			});
		}
	}
	$(document).ready(function(){
		var heightDocument = $(window).height();
		var headerMenu = $("#headerMenu").height();
		var search = $("#search").height();
		$(".show").height(heightDocument-headerMenu-search-10);
	});
</script>