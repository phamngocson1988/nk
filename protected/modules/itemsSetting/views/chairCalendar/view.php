<?php $baseUrl = Yii::app()->baseUrl;?>
<!--Font Awesome and Bootstrap Main css-->

<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jqtransform.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/setting.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/customers_new.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/js/fullcalendar/fullcalendar.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/js/fullcalendar/scheduler.css" />
<link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/bootstrap-multiselect.css" type="text/css"/>

<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl?>"/>
<input type="hidden" id="height_calendar" value=""/>

<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap-multiselect.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/js/fullcalendar/fullcalendar.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/js/fullcalendar/scheduler.js" type="text/javascript"></script>
<script src='<?php echo Yii::app()->request->baseUrl;?>/js/fullcalendar/locale/vi.js'></script>

<style type="text/css">
#profileSideNav ul li a i{
    font-size:2em;  
}
 #tabcontent {
    padding: 30px 30px 10px 30px;
} 
.text-time {
    display: table-cell;
    text-align: right;
    color: #8b8a8a;
    font-size: 0.8em;
    padding-right: 5px;
}
</style>
<!-- Contact Customers -->

<div class='row' style='background-color:#f1f5f7'>
	<div class='col-sm-3' id='height_select' style='padding-top:26px'> 
		<select class="form-control" id="dow_search" onchange="loadResources();">
			<option value=''>--Chọn thứ--</option>
			<option value='1'>Thứ hai</option>
			<option value='2'>Thứ ba</option>
			<option value='3'>Thứ tư</option>
			<option value='4'>Thứ năm</option>
			<option value='5'>Thứ sáu</option>
			<option value='6'>Thứ bảy</option>
		</select>
	</div>
	
	<div class='col-sm-3' style='padding-top:26px'> 
		<select class="form-control" id="branch_search" onchange="loadResources();">
		    <?php $branch = Branch::model()->findAll('status=:st',array(':st'=>1));
			foreach($branch as $gt){?> 
			<option value='<?php echo $gt['id'];?>'><?php echo $gt['name'];?></option>
			<?php }?>
			
		</select>
	</div>
	
	<div class='col-sm-2' style='padding-top:26px;text-align:right'> 
		<button type="button" class="btn btn-default" onclick='addChair();'>Add Chair</button>
	</div>
	
	<div class='col-sm-12' style='padding-top:26px;padding-bottom:2px'>
	    <div id='content_calender' style='overflow:auto'> 
		
		</div>
	</div>	
</div>
<div class="modal fade" id="modalUpdate" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content content_update_chair">
			
		</div>
	</div>
</div>
<div class="modal fade" id="modalSave" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content content_save_chair">
			
		</div>
	</div>
</div>

<div class="modal fade" id="modalAdd" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content content_add_chair">
			
		</div>
	</div>
</div>
<?php 
   //date_default_timezone_set('Asia/Ho_Chi_Minh');
   //$date = date('Ymd');
   
  // echo $date;
?>

<?php //include('_style.php'); ?>

<script type="text/javascript"> 

$(window).resize(function() {
    var windowHeight = $(window).height();
    var header       = $("#headerMenu").height();
	var height_select = $("#height_select").height();
    $('#height_calendar').val(windowHeight-header-height_select);
	$('#rightsidebar').height("padding", "0");
});
$( document ).ready(function() {
    var windowHeight =  $(window).height();
    var header       =  $("#headerMenu").height();
    var height_select = $("#height_select").height();
    $('#height_calendar').val(windowHeight-header-height_select);
	$('#rightsidebar').height("padding", "0");
});


</script>
<?php include('_js.php'); ?>
