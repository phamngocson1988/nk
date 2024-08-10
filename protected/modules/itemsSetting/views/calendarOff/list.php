<?php
if($list_data)
{
    $list_info = $list_data['data'];
    $paging    = $list_data['paging'];
    $num_row   = $paging['num_row']; // Tong so recode
    $num_page  = $paging['num_page']; // Tong so phan trang
    $cur_page  = $paging['cur_page'];// So trang hien tai
    $lpp       = $paging['lpp'];// So recode phan trang 1 page
    
    $start_number = $num_row -($cur_page-1)*$lpp;
    $previous     = $cur_page - 1; 
    $next         = $cur_page + 1;
    if($num_row < ($lpp*$cur_page)){
        $num_row_end = $num_row;
    }else{
        $num_row_end = ($lpp*$cur_page);
        //$num_row_end = ($lpp*$cur_page) - $num_row + $start_number ;
    }
    
?>
<div class="col-sm-12 clearfix">
    <div class="table-responsive">
    	<table class="table table-bordered">
            <thead>
        		<tr style="background-color: #f2eded;">
        			<th style="text-align: center"><span id="abc">#</span></th>
                    <th style="text-align: center"><span id="abc">Chi nhánh</span></th>
					<th style="text-align: center"><span id="abc">Tên bác sĩ</span></th>
					<th style="text-align: center"><span id="abc">Từ ngày</span></th>
					<th style="text-align: center"><span id="abc">Từ giờ</span></th>
					<th style="text-align: center"><span id="abc">Tới ngày</span></th>
					<th style="text-align: center"><span id="abc">Tới giờ</span></th>
                    <th style="text-align: center"><span id="abc">Hành động</span></th>
        		</tr>
            </thead>
            <tbody>
                <?php 
                if($list_info){ 
                    
                    foreach($list_info as $row){
						$ar1 = explode(' ',trim($row['start']));
						$arr1 = explode('-', $ar1[0]);
						$date1 = $arr1[2].'/'.$arr1[1].'/'.$arr1[0];
						$time1 = $ar1[1] == '00:00:00'?'Cả ngày':$ar1[1];
						
						$ar2 = explode(' ',trim($row['end']));
						$arr2 = explode('-', $ar2[0]);
						$date2 = $arr2[2].'/'.$arr2[1].'/'.$arr2[0];
						$time2 = $ar2[1] == '23:59:00'?'Cả ngày':$ar2[1];
						?>
						<tr id="headerlist<?php echo $row['id']?>" class="headerlist">   
							<td style="text-align: center;padding-top: 15px;"><span id="abc"><?php echo $start_number; ?></span></td>
							<td style="text-align: center;">
							<?php 
							$country = Branch::model()->findAll('id=:st',array(':st'=>$row['id_branch']));
							echo $country[0]['name'];
							//echo $row['id_branch'];?></td>
							<td style="text-align: center;">
							<?php 
							    $country = GpUsers::model()->findAll('id=:st',array(':st'=>$row['id_dentist']));
								echo $country[0]['name'];
							?></td>
							
							<td style="text-align: center;"><?php echo $date1;?></td>
							<td style="text-align: center;"><?php echo $time1;?></td>
							
							<td style="text-align: center;"><?php echo $date2;?></td>
							<td style="text-align: center;"><?php echo $time2;?></td>
							
							<td style="text-align: center;">
                                <?php if ($upRole == 1): ?>
                                    <button type="button" class="btn btn-sm btn-border-radius-default" title="Edit" onclick="editunit('<?php echo $row['id']?>');">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </button>    
                                <?php endif ?>
                                <?php if ($delRole == 1): ?>
                                    <button type="button" class="btn btn-sm btn-border-radius-default" title="Delete" onclick="deleteunit('<?php echo $row['id']?>');">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>    
                                <?php endif ?>
							</td>
						</tr>
                <?php 
                    $start_number=$start_number-1;
                    } }else{ ?>
                    <tr>
                        <td></td>
                        <td  style="text-align: center;color: #000;" colspan="12">Not found!</td>
                    </tr>
                <?php } ?>
            </tbody>
            
    	</table>
    </div>
</div>
<div class="col-md-12 col-lg-12" style="padding-top: 5px;padding-bottom: 5px;">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
            <select class="form-control" onchange="changePagepagelistheader(1);" style="width: 75px;" id="pagelisthead_text_page">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>
        <!-- PHONE DISPLAY -->
        <div class="col-xs-12 col-sm-12 visible-xs-block visible-sm-block text-center margin-top-10">
            <div class="row">
                <div class="col-xs-4 col-sm-4 text-left">
                    <button type="button" class="btn btn-sm btn-border-radius-default" onclick="pagelistheader(<?php if($cur_page == 1){ echo '1'; }else{ echo $previous; }?>)">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </button>
                    <label>Page</label>
                </div>
                <div class="col-xs-4 col-sm-4">
                    <input type="text" size="3" value="<?php echo $cur_page; ?>"  onkeypress="runpagelistheader(event);" class="form-control  input-sm"/>
                </div>
                <div class="col-xs-4 col-sm-4 text-right" >
                    <label> of <?php echo $num_page ;?></label>
                    <button type="button" class="btn btn-sm btn-border-radius-default" onclick="pagelistheader(<?php echo $next?>)">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </button>
                </div>
            </div>    
        </div>
        <!-- DESKTOP DISPLAY -->
        <div class="form-inline col-md-8 col-lg-6 text-right visible-md visible-lg">
            <div class="form-group">
                <button type="button" class="btn btn-sm btn-border-radius-default" onclick="pagelistheader(<?php if($cur_page == 1){ echo '1'; }else{ echo $previous; } ?>)">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </button>
                <label>Page</label>
            </div>
            <div class="form-group">
                <input type="text" size="3" value="<?php echo $cur_page; ?>" onkeypress="runpagelistheader(event);" id="id_text_pagelistheader" class="form-control  input-sm"/>
            </div>
            <div class="form-group">
                <label> of <?php echo $num_page ;?></label>
                <button type="button" class="btn btn-sm btn-border-radius-default" onclick="pagelistheader(<?php echo $next?>)">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="headerdetail" class="col-sm-12">
</div>
<?php } else { echo "-1"; }?>
<script>
$("#pagelisthead_text_page option[value=<?php echo $value12; ?>]").attr("selected", "selected");
function editunit(idhead){
    $(".headerlist").removeClass('activestore');
    $("#headerlist"+idhead).addClass('activestore');
    var lpp=$("#pagelisthead_text_page").val();
	var cur_page=$("#id_text_pagelistheader").val();
 
    jQuery.ajax({
       type:"POST", 
       url: '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/CalendarOff/Update',
       data:{
            "idhead":idhead, 
       },
	   beforeSend:function(request){
            $("#content_add").html('');
       },
       success:function(data){
            //$("#content_admin").html(data);
			$("#content_add").html(data);
		    $("#myModal2").modal({backdrop: false});
       } 
    });
}
function deleteunit(idhead){
	//confirm("Do you want delete!");
	var r = confirm("Bạn có muốn xóa !");
	if(r == true){
		jQuery.ajax({
		   type:"POST",  
		   url: '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/CalendarOff/Delete',
		   data:{
				"idhead":idhead, 
		   },
		   success:function(data){
				if(data != '-1'){
					$("#listHeader").html(data);
				}else{
					alert('Data not found','Notice');
				}
		   } 
		});
	}
}
</script>