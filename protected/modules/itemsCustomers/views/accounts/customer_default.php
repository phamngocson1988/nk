<!-- Customer Information -->

<div class="customerDetailsContainer">
    
	<!-- tabs -->
	<div id="tabcontent" class="tabbable">

	  <ul class="nav nav-tabs menuTabDetail">
	    <li class="active"><a href="#tab_medical_record" data-toggle="tab">Hồ sơ</a></li>
	    <li><a href="#appointment_schedule" data-toggle="tab">Lịch hẹn</a></li>
	    <li><a href="#tab_medical_report" data-toggle="tab">Bệnh án</a></li>
	    <li><a href="#tab_treatment_history" data-toggle="tab">Hóa đơn</a></li>
	    <!-- <li><a href="#tab_insurance_information" data-toggle="tab">Bảo hiểm</a></li> -->
	    <!-- <li><a href="#tab_hoivien" data-toggle="tab">Hội viên</a></li> -->
	    <li><a href="#tab_note" data-toggle="tab">Ghi chú</a></li>
	    <li><a href="#tab_statistical" data-toggle="tab">Thống kê</a></li>
	    <li><a href="#tab_doctor_salary" data-toggle="tab">Giao dịch</a></li>
	    <li><a href="#tab_product" data-toggle="tab">Sản phẩm</a></li>
	  </ul>

	  <div class="tab-content">
	    <div class="tab-pane active" id="tab_medical_record">
	    	<div class="statsTabContent tabContentHolder" >
	        	<?php include('tab_medical_record.php') ?>
	        </div>
	    </div>
		
	    <div class="tab-pane" id="appointment_schedule">
	    	<div class="statsTabContent tabContentHolder" >
	        	<?php // include('tab_appointment_schedule.php') ?>
	        </div>
	    </div>

	    <div class="tab-pane" id="tab_medical_report">
	    	<div class="statsTabContent tabContentHolder" >
				<?php // include('tab_medical_report.php') ?>
	        </div>
	    </div>
		
	    <div class="tab-pane" id="tab_treatment_history">
	        <?php // include('tab_treatment_history.php') ?>
	    </div>


	    <!-- <div class="tab-pane" id="tab_insurance_information">
	    	<div class="statsTabContent tabContentHolder" >
	        <?php /* include('tab_insurance_information.php') */ ?>
	        </div>
	    </div> -->

	    <div class="tab-pane " id="tab_hoivien">
	    	<div class="statsTabContent tabContentHolder" >
	        	<?php // include('tab_member.php') ?>
	        </div>
	    </div>

	    <div class="tab-pane" id="tab_note">
	    	<div class="statsTabContent tabContentHolder" >		    	
		        <?php // include('tab_note.php') ?>
	        </div>
	    </div>

	    <div class="tab-pane" id="tab_statistical">
	    	<div class="statsTabContent tabContentHolder" >		    	
		        <?php // include('tab_statistical.php') ?>
	        </div>
	    </div>

	    <div class="tab-pane" id="tab_doctor_salary">
	    	<div class="statsTabContent tabContentHolder" >		    	
		        <?php // include('tab_doctor_salary.php') ?>
	        </div>
	    </div>
	    <div class="tab-pane" id="tab_product">
	    	<div class="statsTabContent tabContentHolder" >		    	
		        <?php // include('tab_product.php') ?>
	        </div>
	    </div>

	   </div>
	</div>
	<!-- /tabs -->

</div>



