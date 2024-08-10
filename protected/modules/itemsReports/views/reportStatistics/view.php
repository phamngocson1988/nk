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
.btn {
	color: #333;
}
</style>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-multiselect.js" charset="utf-8"></script> 
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-multiselect.css" type="text/css"/>
<div class="row" style="margin-top: 10px;">
	
	<div class="col-md-2">
		<label>Loại: </label>
		<select id="select" class="form-control" onchange="search_data()">
			<option value="1">Hóa đơn</option>
			<option value="2">Giao dịch</option>
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
	<div class="col-md-2">
		<label>Dịch vụ: </label>
		<br>
		<select id="dichvu" multiple="multiple" searchable="Search here..">
			<?php foreach ($listService as $key => $value): ?>
				<option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="col-md-2" style="margin-top: 17px">
		<button type="button" class="btn btn_bookoke" onclick="search_data()"><i class="fa fa-search-plus"></i>&nbsp;Xem</button>
	</div>
	<div class="col-md-12 show" style="margin-top: 10px;overflow: scroll;height: 600px;"></div>
</div>
<script type="text/javascript">
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
		selectAllNumber: false
	});
	$('#dichvu').multiselect({
		includeSelectAllOption: true,
		selectAllNumber: false
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
		$('.cal-loading').fadeIn('fast');
		if (option==1) {
			jQuery.ajax({
				type:"POST",
				url:"<?php echo CController::createUrl('ReportStatistics/ShowStatistics')?>",
				data:{
					fromtime:fromtime,
					totime:totime,
					dentist:dentist,
					dichvu:dichvu,
				},
				beforeSend: function() {
					$('#idwaiting_main').html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/waitingmain.gif" alt="loading....." />');
				},
				success: function(data){
					$('.cal-loading').fadeOut('fast');
					$(".show").html(data);
				},error: function(xhr, ajaxOptions, thrownError){ 
					alert(xhr.status);
					alert(thrownError);
				}
			});
		} else {
			jQuery.ajax({
				type:"POST",
				url:"<?php echo CController::createUrl('ReportStatistics/Showdeal')?>",
				data:{
					fromtime:fromtime,
					totime:totime,
					dentist:dentist,
					dichvu:dichvu,
				},
				beforeSend: function() {
					$('#idwaiting_main').html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/waitingmain.gif" alt="loading....." />');
				},
				success: function(data){
					$('.cal-loading').fadeOut('fast');
					$(".show").html(data);
				},error: function(xhr, ajaxOptions, thrownError){ 
					alert(xhr.status);
					alert(thrownError);
				}
			});
		}
	}
</script>