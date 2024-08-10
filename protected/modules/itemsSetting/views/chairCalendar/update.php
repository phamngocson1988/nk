<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Sửa lịch</h4>
</div>
<div class="modal-body">
<?php
function get_times($time){
    $output = '';
    $output.='<option value="">Chọn</option>';
    for($hours=8; $hours<=11; $hours++)// the interval for hours is '1'
    {
    	for($mins=0; $mins<60; $mins+=15) // the interval for mins is '30'
        {	
        	$time_cur = ''.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'';
        	$so_sanh = $time_cur == $time;
        	if($so_sanh)
        	{
        		$output.= '<option selected="selected" value='.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                       .str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                       .str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'</option>';
        	}
        	else
        	{
        		$output.= '<option value='.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                       .str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                       .str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'</option>';
        	}
        	
        }
        
    }
    if('12:00:00'==$time){
    	$output.='<option selected="selected" value="12:00:00">12:00:00</option>';
    }
    else {
    	$output.='<option value="12:00:00">12:00:00</option>';
    }if('13:30:00'==$time){
    	$output.='<option selected="selected" value="13:30:00">13:30:00</option>';
    }
    else {
    	$output.='<option value="13:30:00">13:30:00</option>';
    }
    for($hours=14; $hours<=19; $hours++)// the interval for hours is '1'
    {
    	for($mins=0; $mins<60; $mins+=15) // the interval for mins is '30'
        {	
        	$time_cur = ''.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'';
        	$so_sanh = $time_cur == $time;
        	if($so_sanh)
        	{
        		$output.= '<option selected="selected" value='.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                       .str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                       .str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'</option>';
        	}
        	else
        	{
        		$output.= '<option value='.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                       .str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                       .str_pad($mins,2,'0',STR_PAD_LEFT).':00'.'</option>';
        	}
        	
        }
        
    }
    if('20:00:00'==$time){
    	$output.='<option selected="selected" value="20:00:00">20:00:00</option>';
    }
    else {
    	$output.='<option value="20:00:00">20:00:00</option>';
    }
    return $output;
}
 
if($CsScheduleChair){ 
?>
	<form id="updateChair" class='form-horizontal'>
	<input type='hidden' id='idChair' name='idChair' value='<?php echo $CsScheduleChair->id;?>'/>
	<div class="form-group">
		<label class="control-label col-sm-2" for="pwd">Chi nhánh:</label>
		<div class="col-sm-10">
			<select class="form-control" id='update_id_branch' name="update_id_branch" onchange='updateIdUser();'>
			    <option value=''>--Chọn--</option>
				<?php $Branch = Branch::model()->findAll('status=:st',array(':st'=>1));
				foreach($Branch as $gt){
					$selected = $CsScheduleChair->id_branch==$gt['id']?'selected':'';
				?>
				<option <?php echo $selected;?> value='<?php echo $gt['id']?>'><?php echo $gt['name'];?></option>
				<?php }?>
			</select>
		</div>
    </div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="pwd">Bác sĩ:</label>
		<div class="col-sm-10" id='content_update_id_user'>
			<select class="form-control" id='update_id_user' name="update_id_user">
			    <option value=''>--Chọn--</option>
				<?php $GpUsers = GpUsers::model()->findAll('id_branch=:st order by `name` ASC ',array(':st'=>$CsScheduleChair->id_branch));
				foreach($GpUsers as $gt){
					$selected = $CsScheduleChair->id_dentist==$gt['id']?'selected':'';
				?>
				<option <?php echo $selected;?> value='<?php echo $gt['id']?>'><?php echo $gt['name'];?></option>
				<?php }?>
			</select>  
			<script>
				$('#update_id_user').select2({
					placeholder: 'Chọn Bác Sĩ',
					width: '100%',
				});
			</script>
		</div>
    </div>
	<!--
	<div class="form-group"> 
	    <?php 
		/*
		$csto = CsScheduleTimeOff::model()->findAll('id_cs_schedule_chair = :st',array(':st' => $CsScheduleChair->id));
		$disabled = 'disabled';
		$date = '';
		$checked = '';
		$chkvl = 0;
		if($csto || count($csto)){
			$disabled = '';
			$date = $csto[0]['date'];
			$checked = 'checked';
			$chkvl = 1;
		}*/
		?>
		<label class="control-label col-sm-2">Lịch nghỉ:</label>
		<div class="col-sm-2">
		    <input type="hidden" id="chk_date" name="chk_date" value='<?php //echo $chkvl;?>'/>
		    <input type="checkbox" style='width:20px;height:20px' <?php //echo $checked;?> onclick='check_up();' id="chk_date1"/>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" <?php //echo $disabled;?> value='<?php //echo $date;?>' onchange='change_dateup();' id="date_update" name="date_update"/>
		</div>
    </div>-->
</div>
	<div class="modal-footer">
	    
	    <button type="button" class="btn btn-default" id="updateChairButton" onclick='updateChair();'>Sửa</button>
		<button type="button" class="btn btn-default" id="deleteChairButton" onclick='deleteChair();'>Xóa</button>
		<button type="button" class="btn btn-default" id='close_chair' data-dismiss="modal">Thoát</button>
	</div>
	
    </form>
<?php }?> 
<script>
/*
    $('#date_update').datepicker({
		//changeMonth: true, 
		//changeYear: true,       
		dateFormat: 'dd/mm/yy',
		yearRange: '2000:+0'
	}); 
	
	function change_dateup(d){
		var date_update = $('#date_update').val();
		var arr = date_update.split('/');
		var arr_text = arr[2]+arr[1]+arr[0];
		var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		var mo = Number(arr[1]) - 1;
		var Xmas95 = new Date(months[mo]+' '+arr[0]+', '+arr[2]+' 12:00:00');
		//var Xmas95 = new Date('December 25, 1995 23:15:30');
		var weekday = Xmas95.getDay();
		
		alert(weekday);
	}
	function check_up(){
		if ($('#chk_date1').prop('checked')) {
			$('#chk_date').val(1);
			$("#date_update").prop('disabled', false);
			return false;
		}else{
			$('#chk_date').val(0);
			$("#date_update").prop('disabled', true);
			return false;
		}
	}*/
	function updateIdUser(){
		//alert('aaa');
		
		var update_id_branch = $('#update_id_branch').val();
		
	    if(update_id_branch == ""){
			$('#content_update_id_user').html("");
			return false;
		}
		
		$.ajax({  
			type    : "post",
			url: '<?php echo Yii::app()->createUrl('itemsSetting/ChairCalendar/ChangeUser')?>',
			data    : {
				id	: update_id_branch,
			},
			success: function(data){
				//$('#update_id_user').html('');
				$('#content_update_id_user').html(data);
			},
			error: function(data) {
				alert("Error occured.Please try again!");
			},
		});
	}
	function updateChair(){
		if($("#update_id_branch").val()==""){
			alert('Chọn chi nhánh !!!');return false;
		}  
		if($("#update_id_user").val()==""){
			alert('Chọn bác sĩ !!!');return false;
		}
		var update_id_branch = $("#update_id_branch").val();
		var update_id_user = $("#update_id_user").val();
		var idChair = $("#idChair").val();
		/*
		var user_id = '<?php //echo Yii::app()->user->getState('user_id');?>';
		var date_update = '';
		var chk_date = $('#chk_date').val();
		
		var date = '<?php echo date('Ymd');?>';
		if($('#date_update').val() != ''){
			var date_update = $('#date_update').val();
			var arr = date_update.split('/');
			var arr_text = arr[2]+arr[1]+arr[0];
			if((Number(arr_text)-Number(date)) < 0){
				alert('Xin nhập thời gian tương lai !!!');
				return false;
			}
		}*/
		
		$.ajax({  
			type    : "post",
			url: '<?php echo Yii::app()->createUrl('itemsSetting/ChairCalendar/UpdateChair')?>',
			data    : {
				update_id_branch	: update_id_branch,
				update_id_user	: update_id_user,
				idChair	: idChair, 
				/*
				user_id	: user_id, 
				date_update	: date_update,
				chk_date	: chk_date,*/
			},
			success: function(data){
				//$('#update_id_user').html('');
				if(data == 1){
					alert("Thành công !!!");
					$('#close_chair').click();
					loadResources();
				}else{
					alert(data);
				}
			},
			error: function(data) {
				alert("Error occured.Please try again!");
			},
		});
	}
	function deleteChair(){
		var r = confirm("Bạn có muốn xóa ???");
		if(r == true){
			var idChair = $("#idChair").val();
			$.ajax({  
				type    : "post",
				url: '<?php echo Yii::app()->createUrl('itemsSetting/ChairCalendar/DeleteChair')?>',
				data    : {
					idChair	: idChair, 
				},
				success: function(data){
					//$('#update_id_user').html('');
					if(data == 1){
						alert("Thành công !!!");
						$('#close_chair').click();
						loadResources();
					}else{
						alert("Thất bại !!!");
					}
				},
				error: function(data) {
					alert("Error occured.Please try again!");
				},
			});
		}
	}
	
</script>
