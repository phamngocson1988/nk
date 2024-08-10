<?php $baseUrl = Yii::app()->baseUrl;?>
<?php $group_id =  Yii::app()->user->getState('group_id');?>

<!-- Customer Information -->
<div class="customerDetailsContainer">
    
	<!-- tabs -->
	<div id="tabcontent" class="tabbable">
	  <ul class="nav nav-tabs">
	  	<?php if($group_id == 18 ){ ?>
	    <li class="active"><a href="#tab_information" data-toggle="tab">Hồ sơ</a></li>
	    <?php }else{ ?>
	    <li class="active"><a href="#tab_information" data-toggle="tab">Hồ sơ</a></li>
	    <li><a href="#tab_agenda" data-toggle="tab">Lịch làm việc</a></li>
	    <li><a href="#tab_goal" data-toggle="tab">Chỉ tiêu</a></li>
	    <li><a href="#tab_performance" data-toggle="tab">Hiệu suất</a></li>
	    <li><a href="#tab_compensation" data-toggle="tab">Chấm công</a></li>
	    <li><a href="#tab_doctor_salary" data-toggle="tab">Lương</a></li>
	    <?php } ?>
	  </ul>
	  <div class="tab-content">
	    <div class="tab-pane active" id="tab_information">
	      <?php include("staff_detail.php"); ?>
	      <!-- <p style="margin-top:15px;">Đang cập nhật chỉ tiêu</p> -->
	    </div>
		
	    <div class="tab-pane row" id="tab_agenda">
	     	<?php include("staff_working_hours.php"); ?>
	    </div>
		
	    <div class="tab-pane" id="tab_goal">
			<?php include("staff_goal.php"); ?>		
	    </div>

	    <div class="tab-pane" id="tab_performance">
	       <p style="margin-top:15px;">Đang cập nhật hiệu suất</p>
	    </div>

	    <div class="tab-pane" id="tab_compensation">
	      	<!--<p style="margin-top:15px;">Đang cập nhật chấm công</p>-->
			<?php include("staff_time_keeping.php"); ?>
	    </div>

	    <div class="tab-pane" id="tab_doctor_salary">
			<?php include("tab_doctor_salary.php"); ?>		
	    </div>

	   </div>
	</div>
	<!-- /tabs -->

</div>

<script type="text/javascript">

$(window).resize(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .nav-tabs").height();

    // $('#profileSideNav').height(windowHeight-header);

    $('#content_tab_agenda').height(windowHeight-header-tab_menu-36);
     $('#content_tab_information').height(windowHeight-header-tab_menu-36);
    
    
});
$( document ).ready(function() {

    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .nav-tabs").height();

    // $('#profileSideNav').height(windowHeight-header);

    $('#content_tab_agenda').height(windowHeight-header-tab_menu-36);
    $('#content_tab_information').height(windowHeight-header-tab_menu-36);
    $('#content_tab_doctor_salary').height(windowHeight-header-tab_menu-66);

});
</script>
