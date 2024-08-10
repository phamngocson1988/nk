<style type="text/css">
	.stacked-list {
	    list-style: none;
	    margin-left: 0px;
	}
	.staff-breaks-list, .staff-hour-list {
	    margin-left: 30px;
	    margin-top: 10px;
	}
	.staff-breaks-list .active label:first-child span, .staff-hour-list label:first-child span {
	    border-radius: 50px;
	    background-color: #dff6f5;
	    color: #455862 !important;
	    font-weight: 400;
	    cursor: default;
	}
	.sliders {
	    line-height: 23px;
	    float: left;
	    width: 60px;
	    position: absolute;
	    color: #ffffff !important;
	    font-size: 11px !important;
	    font-weight: 800 !important;
	}
	.slider_off {
    background: url('../../images/switch-bg.png') -57px 0px no-repeat;
    left: 60px;
    text-indent: 26px;
    color: #ffffff !important;
	}
	.slider_on {
    background: url('../../images/switch-bg.png') 0px 0px no-repeat;
    text-indent: 10px;
    left: 2px;
	}
	.slider_switch {
    background: url('../../images/switch-btn.png') left top no-repeat;
    height: 24px;
    left: 38px;
    position: absolute;
    width: 25px;
	}
	.btn-group {
	    position: relative;
	    display: inline-block;
	    font-size: 0;
	    vertical-align: middle;
	    white-space: nowrap;
	}
	.staff-hour-list li.active span.span6 .btn-group .btn.dropdown-toggle {
    border: 1px solid #cccccc;
    color: #455862;
	}
	.staff-hour-list li span.span6 .btn-group .btn.dropdown-toggle:first-child {
    margin-right: 10px;
    margin-bottom: 3px;
    background: white;
	}
	.staff-hour-list li span.span6 .btn-group .btn.dropdown-toggle:first-child {
    width: 75px;
	}
	.stacked-list .btn {
		border: 1px solid #ccc !important;
	    padding: 2px 15px !important;
	    color: #455862 !important;
	}
	.stacked-list li{
		height: 40px;
	}
	.active_off{
		background-color: inherit !important;
    	color: #ccc !important;
	}
	span.active_off{
		color: #ccc !important;
	}
	.slider_holder{
		font-family: helveticaneuelight;
	}
</style>
<?php
	//include_once('modal.php');
	//include_once('modal_update.php');
 	function In_thu($number)
 	{
 		switch ($number) {
 			case 1:
 				echo 'Thứ Hai';
 				break;
 			case 2:
 				echo 'Thứ Ba';
 				break;
 			case 3:
 				echo 'Thứ Tư';
 				break;
 			case 4:
 				echo 'Thứ Năm';
 				break;
 			case 5:
 				echo 'Thứ Sáu';
 				break;
 			case 6:
 				echo "Thứ Bảy";
 				break;
 			case 0:
 				echo 'Chủ Nhật';
 				break;
 		}
 	}
 	function get_times_defaulf($time) 
	 {

	    $output = '';
	    $output.='<option value="">Chọn</option>';
	    for($hours=12; $hours<=13; $hours++)// the interval for hours is '1'
	    {
	    	for($mins=0; $mins<=30; $mins+=15) // the interval for mins is '30'
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
	    return $output;
	}
 	function get_times($time) 
 	{

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
	function select_branch($number)
	{
		$output="";
		for ($i=1; $i<=2 ; $i++) { 
			if($i==$number)
			{
				$output.='<option selected="selected" value="'.$i.'">Cơ Sở '.$i.'</option>';
			}
			else 
			{
				$output.='<option value="'.$i.'">Cơ Sở '.$i.'</option>';
			}
		}
		return $output;
	}
?>
<style type="text/css">
	.btn_remove_listwork{
		border: 1px solid #ccc;
		width: 26px;
		height: 26px;
		border-radius: 5px;
		padding: 1px;
		text-align: center;
		background: #da4f49;
		color: #fff;
		font-size: 15px;
		font-weight: bold;
		cursor: pointer;
	}
	.btn_add_listwork{
		border: 1px solid #ccc;
		width: 26px;
		height: 26px;
		border-radius: 5px;
		padding: 0px;
		text-align: center;
		background: #10b1dd;
		color: #fff;
		font-size: 20px;
		font-weight: bold;
		cursor: pointer;
	}
	
</style>
<div id="content_tab_agenda" style="width: 100%;overflow: auto;padding-left: 15px" class="row">
	<div class="col-md-12" style="margin-top: 20px">
		<p style="font-size: 25px;font-weight: bold;">Thời gian làm việc</p>
		<ul id="stacked-list" class="stacked-list staff-hour-list">
        <?php
		for($i=1;$i<=6;$i++){?>
		    <li class="row" id="row_<?php echo $i;?>">
				<label class="col-md-2">
					<span style="background-color: #fff;color: #ccc"><?php $thu = In_thu($i); ?></span>
				</label>
				<span class="col-md-2" style="width: 12%;">
					<div onclick="" id="slider_holder_<?php echo $i;?>" class="slider_holder staffhours sliderdone">
						<input type="hidden" value="1">
						<span style="left: 1px;" class="slider_off sliders"> TẮT </span>
						<span style="left: -57px;" class="slider_on sliders"> BẬT </span>
						<span style="left: 1px;" class="slider_switch"></span>
					</div>
				</span>
				<?php 
                /*
					$list_time = CsScheduleChair::model()->findAllByAttributes(array('id_chair'=>$id_chair,'dow'=>$i));
					$count_list_time = count($list_time);
					foreach ($list_time as $item) {
						if(strtotime($item['end']) == strtotime('20:00:00')){
							$status_time_end = 1;
						}else{
							$status_time_end = 0;
						}
					}*/
				?>
				<ul class="col-md-8">
					<?php
					/*
					 if(isset($list_time) && $list_time)
					 {
						$j=1;
						foreach($list_time as $item)
						{*/
                    for($j=0;$j<=3;$j++){?>

					<li>
						<div class="col-md-6">
							<span>
								<select onchange="change_time_start(<?php echo $i;?>,<?php echo $j;?>,<?php echo $id_chair;?>)" name="time_start_<?php echo $i.$j;?>" id="time_start_<?php echo $i.$j;?>" style="height: 26px;width: 39%;border-radius: 4px;">
									<?php echo get_times(''); ?>
								</select>
							</span>
							<span class="staff-hours-to">đến</span>
							<span>
								<select onchange="change_time_end(<?php echo $i;?>,<?php echo $j;?>,<?php echo $id_chair;?>)" name="time_end_<?php echo $i.$j;?>" id="time_end_<?php echo $i.$j;?>" style="height: 26px;width: 39%;border-radius: 4px;">
									<?php echo get_times(''); ?>
								</select>
							</span>
						</div>
						<div  class="col-md-3">
							<select onchange="change_branch();" id="address_<?php echo $i.$j;?>"  style="height: 26px;width: 85%;border-radius: 4px;">
								<?php
									echo select_branch(1);
								?>
							</select>
						</div>
						<div  class="col-md-2" style="padding-right: 0px;">
							<select onchange="change_chair(<?php echo $id_chair;?>,<?php echo $i; ?>,<?php echo '';?>)" id="chair_<?php echo '';?>" style="height: 26px;width: 100%;border-radius: 4px;">

							<?php 
								$list_chair = GpUsers::model()->findAll('group_id=:st',array(':st'=>3));
								 ?>
									
							
								<option value="NULL">Chọn</option>
								<?php  if(isset($list_chair) && $list_chair)
								{
									foreach ($list_chair as $value) 
									{
										
								?>	
									<option value="<?php echo $value['id']; ?>">
										<?php echo $value['name']; ?>
									</option>
								
										
								<?php }}?>
						</select>
						</div>
						
					</li>
					<?php }?>
					
					
				</ul>
			</li>
		  
	<?php }?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#stacked-list li').each(function(index){
		$("#slider_holder_"+index).click(function(){
			var id_dentist = $('input[name=id_dentist]').val();
			var value = $("#slider_holder_"+index+" input").val();
			if(value =="0")
			{
				$('#row_'+index+' label:first-child span').css({'background-color':'#fff','color':'#ccc'});
				$('#row_'+index+' .btn-group a').css({'background-color':'#F5F5F5','color':'#ccc'});
				$('#slider_holder_'+index+' .slider_off').css({'left':'1px'});
				$('#slider_holder_'+index+' .slider_on').css({'left':'-57px'});
				$('#slider_holder_'+index+' .slider_switch').css({'left':'1px'});
				
				$('#slider_holder_'+index+' input').val("1");
			}
			if (value=="1"){
				$('#row_'+index+' label:first-child span').css({'background-color':'#dff6f5'});
				$('#row_'+index+' .btn-group a').css({'background-color':'#fff','color':'#455862'});
				$('#slider_holder_'+index+' .slider_off').css({'left':'1px'});
				$('#slider_holder_'+index+' .slider_on').css({'left':'2px'});
				$('#slider_holder_'+index+' .slider_switch').css({'left':'38px'});
				
				$('#slider_holder_'+index+' input').val("0");
			}	
		});
	});
});
	
</script>
	