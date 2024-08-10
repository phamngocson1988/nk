<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Lưu lịch</h4>
</div>
<div class="modal-body">
<?php

?>
	<form id="updateChair" class='form-horizontal'>
	<div class="form-group">
	    <input type="hidden" id='id_chair' value='<?php echo $id_chair;?>'/>
		<input type="hidden" id='start' value='<?php echo $start;?>'/>
		<input type="hidden" id='end' value='<?php echo $end;?>'/>
		<input type="hidden" id='dow_search_save' value='<?php echo $dow_search_save;?>'/>
		<label class="control-label col-sm-2" for="pwd">Chi nhánh:</label>
		<div class="col-sm-10">
			<select class="form-control" id='save_id_branch' disabled name="save_id_branch" onchange='saveIdUser();'>
				<?php $Branch = Branch::model()->findAll('id = :id and status=:st',array(':st'=>1,':id'=>$branch_search_save));
				foreach($Branch as $gt){?>
				<option value='<?php echo $gt['id']?>'><?php echo $gt['name'];?></option>
				<?php }?>
			</select>
		</div>
    </div>
	<div class="form-group">
		<label class="control-label col-sm-2">Bác sĩ:</label>
		<div class="col-sm-10" id='content_save_id_user'>
			
		</div>
    </div>
	<!--
	<div class="form-group"> 
		<label class="control-label col-sm-2">Lịch nghỉ:</label>
		<div class="col-sm-2">
		    <input type="hidden" id="chk_date_s" name="chk_date_s" value='0'/>
		    <input type="checkbox" style='width:20px;height:20px' onclick='check_ups();' id="chk_date_s1"/>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" disabled id="dates_update" name="dates_update"/>
		</div>
    </div>-->
</div>
	<div class="modal-footer">
	    <button type="button" class="btn btn-default" onclick='saveChair();'>Lưu</button>
		<button type="button" class="btn btn-default" id='close_chair_save' data-dismiss="modal">Thoát</button>
	</div>
	
    </form>

<script>

    saveIdUser();
	/*
	 $('#dates_update').datepicker({
		//changeMonth: true, 
		//changeYear: true,       
		dateFormat: 'dd/mm/yy',
		yearRange: '2000:+0'
	}); 
	function check_ups(){
		if ($('#chk_date_s1').prop('checked')) {
			$('#chk_date_s').val(1);
			$("#dates_update").prop('disabled', false);
			return false;
		}else{
			$('#chk_date_s').val(0);
			$("#dates_update").prop('disabled', true);
			return false;
		}
	}*/
	function saveIdUser(){
		//alert('aaa');
		var save_id_branch = $('#save_id_branch').val();
	    if(save_id_branch == ""){
			$('#content_save_id_user').html("");
			return false;
		}
		$.ajax({  
			type    : "post",
			url: '<?php echo Yii::app()->createUrl('itemsSetting/ChairCalendar/SaveChangeUser')?>',
			data    : {
				id	: save_id_branch,
			},
			success: function(data){
				//$('#update_id_user').html('');
				$('#content_save_id_user').html(data);
			},
			error: function(data) {
				alert("Error occured.Please try again!");
			},
		});
	}
	function saveChair(){
		if($("#save_id_branch").val()==""){
			alert('Chọn chi nhánh !!!');return false;
		}  
		if($("#save_id_user").val()==""){
			alert('Chọn bác sĩ !!!');return false;
		}
		var save_id_branch = $("#save_id_branch").val();
		var save_id_user = $("#save_id_user").val();
		/*
		var user_id = '<?php //echo Yii::app()->user->getState('user_id');?>';
		var dates_update = '';
		var chk_date_s = $('#chk_date_s').val();
		
		var date = '<?php echo date('Ymd');?>';
		
		if ($('#chk_date_s1').prop('checked')){ 
			if($('#dates_update').val() == ''){
				alert('Xin chọn ngày tháng !!!');
				return false;
			}
		}
		
		if($('#dates_update').val() != ''){
			var dates_update = $('#dates_update').val();
			var arr = dates_update.split('/');
			var arr_text = arr[2]+arr[1]+arr[0];
			if((Number(arr_text)-Number(date)) < 0){
				alert('Xin nhập thời gian tương lai !!!');
				return false;
			}
		}*/
		
		var id_chair = $("#id_chair").val();
		var start = $("#start").val();
		var end = $("#end").val();
		var dow_search_save = $("#dow_search_save").val();
		$.ajax({  
			type    : "post",
			url: '<?php echo Yii::app()->createUrl('itemsSetting/ChairCalendar/SaveChair')?>',
			data    : {
				save_id_branch	: save_id_branch,
				save_id_user	: save_id_user,
				
				id_chair1	: id_chair,
				start1	: start,
				end1	: end,
				dow_search_save1	: dow_search_save,
				/*
				user_id	: user_id, 
				dates_update : dates_update,
				chk_date_s : chk_date_s,*/
			},
			success: function(data){
				//$('#update_id_user').html('');
				if(data == 1){
					alert("Thành công !!!");
					$('#close_chair_save').click();
					loadResources();
				}else if(data == -1){
					alert("Bác sĩ này hiện đã có lịch ở ghế khác ,xin chọn lại bác sĩ !");
				}else{
					alert("Thất bại !!!");
				}
			},
			error: function(data) {
				alert("Error occured.Please try again!");
			},
		});
	}
	
</script>
