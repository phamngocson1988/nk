<?php $baseUrl = Yii::app()->baseUrl;?>


<!-- Customer Information -->
<div class="customerDetailsContainer">
    
	<!-- tabs -->
	<div id="tabcontent" class="tabbable">
	  <ul class="nav nav-tabs">

	    <li class="active"><a href="#tab_information" data-toggle="tab">Hồ sơ</a></li>
	    <!--<li><a href="#tab_agenda" data-toggle="tab">Lịch làm việc</a></li>-->
	    
	  </ul>
	  <div class="tab-content">
	    <div class="tab-pane active" id="tab_information">
	        <?php include("chair_detail.php");?>
	    </div>
		<!--
	    <div class="tab-pane row" id="tab_agenda">
	     	<?php //include("chair_calendar.php");?>
	    </div>-->

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
