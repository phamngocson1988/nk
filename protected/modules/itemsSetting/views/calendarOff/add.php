
<?php 
	$form = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		array(
			'id' => 'addInsurrance',
			'enableClientValidation'=>true,
			'htmlOptions' => array('enctype' => 'multipart/form-data'), // for inset effect
		)
	);
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
?>
<div class="modal-header"> 
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Thêm</h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
				<label>Tên chi nhánh</label>
				<select class="form-control" id="add_cn" name="add_cn" onchange="changeBS1();"> 
				<?php 
				$bran = Branch::model()->findAll('status=:st',array(':st'=>1));
				foreach($bran as $gt){?>
					<option value='<?php echo $gt['id'];?>'><?php echo $gt['name'];?></option>
				<?php }?>
				</select>
			</div>
		</div>
		<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
				<label>Tên bác sĩ</label>
				<div id='bs_content1'>
					<select class="form-control" disabled id='name_add' name='name_add'>
						<option value=''>--Chọn bác sĩ--</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
			    <label>Từ ngày</label>
				<input type="text" class="form-control" id="date_add1" name="date_add1"/>
				
			</div>
		</div>
		<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
			    <label>Từ giờ (Nếu nghỉ cả ngày thì khỏi chọn)</label>
				<select class="form-control" id='time_add1' name="time_add1">
					<?php echo get_times('');?>
				</select>
			</div>
		</div>
		<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
			    <label>Tới ngày (Nếu nghỉ 1 ngày thì chọn trùng ngày trên)</label>
				<input type="text" class="form-control" id="date_add2" name="date_add2"/>
				
			</div>
		</div>
		<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
			    <label>Tới giờ (Nếu nghỉ cả ngày thì khỏi chọn)</label>
				<select class="form-control" id='time_add2' name="time_add2">
					<?php echo get_times('');?>
				</select>
			</div>
		</div>
	</div>
	
	
</div>
<div class="modal-footer">
	<input type="submit" class="btn btn-default" value="Thêm" style="" />
	<button type="button" class="btn btn-default" data-dismiss="modal" id='close_add'>Close</button>
</div>
<?php 
            $this->endWidget();
        ?>
<script>

$('#date_add1').datepicker({
	//changeMonth: true, 
	//changeYear: true,       
	dateFormat: 'dd/mm/yy',
	yearRange: '2000:+0',
	todayHighlight: true, 
	minDate:new Date(),
}); 

$('#date_add2').datepicker({
	//changeMonth: true, 
	//changeYear: true,       
	dateFormat: 'dd/mm/yy',
	yearRange: '2000:+0',
	todayHighlight: true, 
	minDate:new Date(),
});
changeBS1();
function changeBS1(){
	var st = $("#add_cn").val();
	var tb = 'name_add';
    jQuery.ajax({
       type:"POST",
       url: '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/CalendarOff/ChangeBS',
	   data : { 
			"st": st,
			"tb": tb,
		},
       success:function(data){
		    $("#bs_content1").html(data);
       }  
    });
}

function truDate(date1 ,date2){

	var arr = date1.split('/');
	var arr_text = arr[2]+arr[1]+arr[0];
	
	var arr2 = date2.split('/');
	var arr_text2 = arr2[2]+arr2[1]+arr2[0];
	
	if((Number(arr_text)-Number(arr_text2)) == 0){
		return false;
	}else if((Number(arr_text)-Number(arr_text2)) < 0){
		return false;
	}else{
		return true;
	}
}

$(document).ready(function(){
	
    $('#addInsurrance').submit(function(e) {
        e.preventDefault();
	setTimeout(function(){
		if($.trim($("#add_cn").val())==""){
            alert('Xin chọn chi nhánh !!!');return false;
        }
		
        if($.trim($("#name_add").val())==""){
            alert('Xin nhập tên bác sĩ !!!');return false;
        }
		
		if($.trim($("#date_add1").val())==""){
            alert('Xin chọn ngày bắt đầu !!!');return false;
        }
		
		if($.trim($("#date_add1").val())==""){
            alert('Xin chọn ngày kết thúc !!!');return false;
        }
		
		if(truDate($('#date_add1').val() ,$('#date_add2').val())){
			alert('Xin nhập thời nắt đầu phải nhỏ hơn thời gian kết thúc !!!');
			return false;
		}
		
        var formData = new FormData($("#addInsurrance")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ 
                type:"POST",
                url: '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/CalendarOff/Add',
                data:formData,
                datatype:'json',
                
                success:function(data){
					
					if(data != 0){
						$("#listHeader").html(data);
						$("#close_add").click();
					}else{
						alert('Bác sĩ đã nghỉ trong thời gian này !!!');
						return false;
					}
					
                },
                cache: false,
                contentType: false,
                processData: false 
            });
        }
        return false;
	}, 600);  
    });
	
});



</script>
