<a href="#" class="btn btn-success" data-toggle="modal" data-target="#searchCustomerModal">Search</a>
<div id="searchCustomerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-body">
            <input type="text" id="txtSearchCustomer" placeholder="nhập tên khách hàng">
            <p id="searchProcess">Kết quả...</p>
            <div id="searchCustomerResult"></div>
        </div>
    </div>
</div>

<div id="sortLabel" class="sortLabel importAndSort" style="margin-left: 15px; display: inline-block;">
    <i class="fa fa-list"></i>                                            
</div> 

<div id="searchCustomerPopup" class="popover bottom open">
    <div class="popover-content">

        <h5>SẮP XẾP</h5>

        <input class="SortBy" type="radio" name="sort" value="0" checked onkeypress="runScript_search(event);"> Sắp xếp theo lịch hẹn<br>
        <input class="SortBy" type="radio" name="sort" value="1" onkeypress="runScript_search(event);"> Sắp xếp theo họ và tên<br>
        <input class="SortBy" type="radio" name="sort" value="2" onkeypress="runScript_search(event);"> Sắp xếp theo mã số<br>                                

        <h5>TÌM KIẾM</h5>

        <input id="iptSearchEmail" class="form-control" type="text" placeholder="Email" onkeypress="runScript_search(event);">
        
        <?php
            $list_country = array(); 
            foreach($model->getListCountry() as $value){
                $list_country[$value['code']] = $value['country'];
            }
            echo CHtml::dropDownList('iptSearchCountry','',$list_country,array('class'=>'form-control','empty' => 'Chọn quốc tịch','onkeypress' => 'runScript_search(event);'));
        ?> 
        <input id="iptSearchIdentityCardNumber" class="form-control" type="text" placeholder="CMND/Passport" onkeypress="runScript_search(event);">
        <?php
        $list_source = array();                          
        foreach($model->getListSource() as $value){
            $list_source[$value['id']] = $value['name'];
        }                               
        echo CHtml::dropDownList('iptSearchSource','',$list_source,array('class'=>'form-control','empty' => 'Chọn nguồn','onkeypress' => 'runScript_search(event);'));
        ?>  
        <?php                   
        $list_segment = array();                                       
        foreach($model->getListSegment() as $value){
            $list_segment[$value['id']] = $value['name'];
        }                                     
        echo CHtml::dropDownList('iptSearchSegment','',$list_segment,array('class'=>'form-control','empty' => 'Chọn nhóm','onkeypress' => 'runScript_search(event);'));
        ?>  

        <button onclick="advanceSearch();" class="new-gray-btn new-green-btn">TÌM</button>
    </div>
</div>

<style type="text/css">
	.autoNum {
		text-align: right !important;
		padding-right: 10px !important;
	}

	table.table-inv th,
	table.table-inv td {
		border: 1px solid white;
	}

	table.table-inv td {
		color: black;
	}

	h4.tt {
		color: #455862 !important;
	}
</style>

<?php
	$waitingSchedule = $model->checkWaitingSchedule($model->id);
	$group_id =  Yii::app()->user->getState('group_id');
?>

<!-- POP UP DAT LICH HEN -->
<div id="CalendarModal" class="modal fade"></div>

<!-- CUSTOMER INFORMATION -->
<div class="customerDetailsContainer">
	<input type="hidden" id="id_customer" value="<?php echo $model->id; ?>">

	<!-- TABS -->
	<div id="tabcontent" class="tabbable">
		<?php $tabProfile = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_dentist'], Yii::app()->params['id_group_assistant'], Yii::app()->params['id_group_receptionist'], Yii::app()->params['id_group_customer_service'], Yii::app()->params['id_group_accountant'], Yii::app()->params['id_group_marketing'], Yii::app()->params['id_group_maintenance'], Yii::app()->params['id_group_operation'], Yii::app()->params['id_group_nhapbenhan']); ?>

		<?php $tabSchedule = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_dentist'], Yii::app()->params['id_group_assistant'], Yii::app()->params['id_group_receptionist'], Yii::app()->params['id_group_customer_service'], Yii::app()->params['id_group_operation'], Yii::app()->params['id_group_nhapbenhan']); ?>

		<?php $tabMedical = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_dentist'], Yii::app()->params['id_group_assistant'], Yii::app()->params['id_group_receptionist'], Yii::app()->params['id_group_customer_service'], Yii::app()->params['id_group_maintenance'], Yii::app()->params['id_group_operation'], Yii::app()->params['id_group_nhapbenhan']); ?>

		<?php $tabInvoice = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_receptionist'], Yii::app()->params['id_group_customer_service'], Yii::app()->params['id_group_accountant'], Yii::app()->params['id_group_dentist'], Yii::app()->params['id_group_operation'], Yii::app()->params['id_group_nhapbenhan']); ?>

		<?php $tabMember = array(0); ?>

		<?php $tabNote = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_dentist'], Yii::app()->params['id_group_assistant'], Yii::app()->params['id_group_receptionist'], Yii::app()->params['id_group_customer_service'], Yii::app()->params['id_group_marketing'], Yii::app()->params['id_group_maintenance'], Yii::app()->params['id_group_operation']); ?>

		<?php $tabStatistical = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_receptionist'], Yii::app()->params['id_group_customer_service'], Yii::app()->params['id_group_marketing'], Yii::app()->params['id_group_operation']); ?>

		<?php $tabTransaction = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_receptionist'], Yii::app()->params['id_group_dentist'], Yii::app()->params['id_group_accountant'], Yii::app()->params['id_group_operation']); ?>

		<?php $tabProduct = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_receptionist'], Yii::app()->params['id_group_dentist'], Yii::app()->params['id_group_operation']); ?>

		<?php $tabRefund = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_receptionist'], Yii::app()->params['id_group_dentist'], Yii::app()->params['id_group_operation']); ?>

		<?php $tabDeposit = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_receptionist']); ?>

		<?php $tabBloodTest = array(Yii::app()->params['id_group_admin'], Yii::app()->params['id_group_subadmin'], Yii::app()->params['id_group_receptionist']); ?>

		<ul class="nav nav-tabs menuTabDetail">
			<!-- HO SO -->
			<?php if (in_array($group_id, $tabProfile)) { ?>
				<li class="active"><a href="#tab_medical_record" data-toggle="tab">Hồ sơ</a></li>
			<?php } ?>

			<!-- LICH HEN -->
			<?php if (in_array($group_id, $tabSchedule)) { ?>
				<li><a href="#appointment_schedule" data-toggle="tab">Lịch hẹn</a></li>
			<?php } ?>

			<!-- BENH AN -->
			<?php if (in_array($group_id, $tabMedical)) { ?>
				<li><a target="_blank" href="<?php echo Yii::app()->request->baseUrl ?>/itemsMedicalRecords/AccountsCus/admin?code_number=<?php echo $model->code_number; ?>">Bệnh án</a></li>
			<?php } ?>

			<!-- HOA DON -->
			<?php if (in_array($group_id, $tabInvoice)) { ?>
				<li><a href="#tab_treatment_history" data-toggle="tab">Hóa đơn</a></li>
			<?php } ?>

			<!-- HOI VIEN -->
			<?php if (in_array($group_id, $tabMember)) { ?>
				 <li><a href="#tab_hoivien" data-toggle="tab">Hội viên</a></li>
			<?php } ?>

			<!-- GHI CHU -->
			<?php if (in_array($group_id, $tabNote)) { ?>
				<li><a href="#tab_note" data-toggle="tab">Ghi chú</a></li>
			<?php } ?>

			<!-- THONG KE -->
			<?php if (in_array($group_id, $tabStatistical)) { ?>
				<li><a href="#tab_statistical" data-toggle="tab">Thống kê</a></li>
			<?php } ?>

			<!-- GIAO DICH -->
			<?php if (in_array($group_id, $tabTransaction)) { ?>
				<li><a id="tab-doctor-salary" href="#tab_doctor_salary" data-toggle="tab">Giao dịch</a></li>
			<?php } ?>

			<!-- SAN PHAM -->
			<?php if (in_array($group_id, $tabProduct)) { ?>
				<li><a id="tab-tabProduct" href="#tab_product" data-toggle="tab">Sản phẩm</a></li>
			<?php } ?>

			<!-- HOAN TRA -->
			<?php if (in_array($group_id, $tabRefund)) { ?>
				<li><a id="tab-receiverable" href="#tab_receiverable" data-toggle="tab">Hoàn trả</a></li>
			<?php } ?>

			<!-- DEPOSIT -->
			<?php if (in_array($group_id, $tabDeposit)) { ?>
				<li><a id="tab-deposit" href="#tab_deposit" data-toggle="tab">Deposit</a></li>
			<?php } ?>

			<!-- XET NGHIEM MAU -->
			<?php if (in_array($group_id, $tabBloodTest)) { ?>
				<li><a id="tab-blood_test" href="#tab_blood_test" data-toggle="tab">Xét nghiệm máu</a></li>
			<?php } ?>
		</ul>

		<div class="tab-content">
			<!-- HO SO -->
			<?php if (in_array($group_id, $tabProfile)) { ?>
				<div class="tab-pane active" id="tab_medical_record">
					<div class="statsTabContent tabContentHolder scrollbox">
						<div class="scrollbox-content">
							<?php include('tab_medical_record.php') ?>
						</div>
					</div>
				</div>
			<?php } ?>

			<!-- LICH HEN -->
			<?php if (in_array($group_id, $tabSchedule)) { ?>
				<div class="tab-pane" id="appointment_schedule"></div>
			<?php } ?>

			<!-- BENH AN -->
			<?php if (in_array($group_id, $tabMedical)) { ?>
				<div class="tab-pane" id="tab_medical_report">
					<div class="statsTabContent tabContentHolder">
						<div id="medical_record">
						</div>
					</div>
				</div>
			<?php } ?>

			<!-- HOA DON -->
			<?php if (in_array($group_id, $tabInvoice)) { ?>
				<div class="tab-pane" id="tab_treatment_history">
					<input type="hidden" id="tab_treatment_history_page" value="1">
					<div class="statsTabContent tabContentHolder tab_invoice" style="height: 850px;">
						<?php
						?>
					</div>
				</div>
			<?php } ?>

			<!-- HOI VIEN -->
			<?php if (in_array($group_id, $tabMember)) { ?>
				<div class="tab-pane " id="tab_hoivien">
					<div class="statsTabContent tabContentHolder">
						<?php //include('tab_member.php') ?>
					</div>
				</div>
			<?php } ?>

			<!-- GHI CHU -->
			<?php if (in_array($group_id, $tabNote)) { ?>
				<div class="tab-pane" id="tab_note">
					<div class="statsTabContent tabContentHolder">
						<?php include('tab_activity_history.php') ?>
					</div>
				</div>
			<?php } ?>

			<!-- THONG KE -->
			<?php if (in_array($group_id, $tabStatistical)) { ?>
				<div class="tab-pane" id="tab_statistical">
					<div class="statsTabContent tabContentHolder">
						<?php //include('tab_statistical.php') ?>
					</div>
				</div>
			<?php } ?>

			<!-- GIAO DICH -->
			<?php if (in_array($group_id, $tabTransaction)) { ?>
				<div class="tab-pane" id="tab_doctor_salary">
					<div class="statsTabContent tabContentHolder">
						<div id="doctor_salary"></div>
					</div>
				</div>
			<?php } ?>

			<!-- SAN PHAM -->
			<?php if (in_array($group_id, $tabProduct)) { ?>
				<div class="tab-pane" id="tab_product">
					<div class="statsTabContent tabContentHolder">
						<div id="product_tabs"></div>
					</div>
				</div>
			<?php } ?>

			<!-- HOAN TRA -->
			<?php if (in_array($group_id, $tabRefund)) { ?>
				<div class="tab-pane" id="tab_receiverable">
					<div class="tableList" style="padding: 10px 0;">
						<table class="table">
							<thead>
								<tr>
									<th>Mã</th>
									<th style="width: 40%;">Mô tả</th>
									<th>Số tiền</th>
									<th>Người thực hiện</th>
									<th>Ngày thực hiện</th>
									<th>Thao tác</th>
								</tr>
							</thead>
							<tbody style="max-height: 350px;">
							</tbody>
						</table>
					</div>
				</div>
			<?php } ?>

			<!-- DEPOSIT -->
			<?php if (in_array($group_id, $tabDeposit)) : ?>
				<div class="tab-pane" id="tab_deposit">
					<div class="tab-deposit-content"></div>
				</div>
			<?php endif; ?>

			<!-- XET NGHIEM MAUB -->
			<?php if (in_array($group_id, $tabBloodTest)) : ?>
				<div class="tab-pane" id="tab_blood_test">
					<div class="tab-blood_test-content"></div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	function loadCustomerSchedule(id_cus) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsCustomers/Accounts/loadCustomerSchedule",
			data: {
				id_customer: id_cus
			},
			success: function(data) {
				$('#appointment_schedule').html(data);
			},
		});
	}

	function loadMedicalReport(id_cus, treatment) {
		var code_number = "<?php echo $model->code_number; ?>";

		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsCustomers/Accounts/loadMedicalReport",
			data: {
				id_customer: id_cus,
				treatment: treatment,
			},
			success: function(data) {
				$('#medical_record').html(data);
			},
		});
	}

	function loadTabDoctorSalary(id_cus) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsCustomers/Accounts/loadTabDoctorSalary",
			data: {
				id_customer: id_cus,
			},
			success: function(data) {
				$('#doctor_salary').html(data);
			},
		});
	}

	function loadTabProduct(id_cus) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsCustomers/Accounts/loadTabProduct",
			data: {
				id_customer: id_cus,
			},
			success: function(data) {
				$('#product_tabs').html(data);
			},
		});
	}

	function loadTabInvoice(page, id_cus) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsCustomers/Accounts/loadTabInvoice",
			data: {
				id_customer: id_cus,
				page: page
			},
			success: function(data) {
				if (data.trim() != "") {
					$('#tab_treatment_history_page').val(parseInt(page) + 1);
					$('#tab_treatment_history .tabContentHolder').append(data);
				}
			},
		});
	}

	function loadTabReceiverable(page, id_cus) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsCustomers/Accounts/LoadTabReceivable",
			data: {
				id_customer: id_cus,
				page: page
			},
			dataType: 'html',
			success: function(data) {
				if (data.trim() != "") {
					$('#tab_receiverable tbody').append(data);
				}
			},
		});
	}

	function loadTabDeposit(idCus) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsAccounting/Deposit/LoadTabDeposit",
			data: {
				id_customer: idCus,
			},
			dataType: 'html',
			success: function(data) {
				$('.tab-deposit-content').html(data);
			},
		});
	}

	function loadTabBloodTest(idCus) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsAccounting/bloodTest/LoadTabBloodTest",
			data: {
				id_customer: idCus,
			},
			dataType: 'html',
			success: function(data) {
				$('.tab-blood_test-content').html(data);
			},
		});
	}
</script>

<script type="text/javascript">
	$(window).resize(function() {
		var w_ct = $("#tabcontent").width();
		var h_ct = $(".statsTabContent").height();

		$('#tabcontent .no-data').css('width', w_ct);
		$('#tabcontent .no-data').css('height', h_ct - 90);
	});

	$(document).ready(function() {
		var w_ct = $("#tabcontent").width();
		var h_ct = $(".statsTabContent").height();

		$('#tabcontent .no-data').css('width', w_ct);
		$('#tabcontent .no-data').css('height', h_ct - 90);

		var idCus = '<?php echo $model->id; ?>';

		// click chon tab
		$('.tabbable').on('click', 'a', function(e) {
			idTab = $(this).attr('href');

			switch (idTab) {
				case '#appointment_schedule': // Lich hen
					loadCustomerSchedule(idCus);
					break;

				case '#tab_medical_report': // Benh an
					loadMedicalReport(idCus);
					break;

				case '#tab_doctor_salary': // Giao dich
					loadTabDoctorSalary(idCus);
					break;

				case '#tab_product': // San pham
					loadTabProduct(idCus);
					break;

				case '#tab_receiverable': // Hoan tra
					$('#tab_receiverable tbody').empty();
					loadTabReceiverable(1, idCus);
					break;

				case '#tab_treatment_history': // Hoa don
					$('#tab_treatment_history_page').val(1);
					$('#tab_treatment_history .statsTabContent').empty();
					loadTabInvoice(1, idCus);
					break;

				case '#tab_statistical': // Hoan tra
					$('#tab_receiverable tbody').empty();
					loadTabStatistical(1, idCus);
					break;

				case '#tab_deposit': // deposit
					loadTabDeposit(idCus);
					break;

				case '#tab_blood_test': // blood_test
					loadTabBloodTest(idCus);
					break;

				default:
					console.log(idTab);
					break;
			}
		});

		$('#tab_treatment_history div').on('scroll', function() {
			if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 10) {
				if ($(this).find('.no-data').length != 0) {
					return;
				}
				page = parseInt($('.invoice_num_page:last').val()) - parseInt($('.invoice_page:last').val());
				if (page > 0) {
					loadTabInvoice(parseInt($('.invoice_page:last').val()) + 1, idCus);
				}
			}
		});

		$('#tab_receiverable tbody').on('scroll', function() {
			if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
				if ($(this).find('.no-data').length != 0) {
					return;
				}

				page = parseInt($('.receivable_num_page:last').val()) - parseInt($('.receivable_page:last').val());
				if (page > 0) {
					loadTabReceiverable(page + 1, idCus);
				}
			}
		})
	});


	<?php if ($waitingSchedule) { ?>
		$(document).ready(function() {
			var w_ct = $("#tabcontent").width();
			var h_ct = $(".statsTabContent").height();

			$('#tabcontent .no-data').css('width', w_ct);
			$('#tabcontent .no-data').css('height', h_ct - 90);

			// click chon tab
			$('.tabbable').on('click', 'a', function(e) {
				idTab = $(this).attr('href');
				idCus = '<?php echo $model->id; ?>';

				switch (idTab) {

					case '#tab_medical_report': // benh an

						if (confirm("Bạn có muốn cập nhật lịch hẹn đang chờ sang điều trị?")) {

							$('#appointmentList li select').each(function() {
								if ($(this).val() == 2) {
									$(this).val(3).change();
								}
							});
						}
						break;
				}
			});
		});
	<?php } ?>

	$.urlParam = function(name) {
		var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if (results == null) {
			return null;
		} else {
			return decodeURI(results[1]) || 0;
		}
	}

	if ($.urlParam('id_invoice') != null) {
		$("#tab-doctor-salary").click();
	}

	function loadTabStatistical(page, idCus) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsCustomers/Accounts/LoadTabStatistical",
			data: {
				id_customer: idCus,
				page: page
			},
			success: function(data) {
				$('#tab_statistical .tabContentHolder').html(data);
			},
		});
	}
</script>

<script>
	var numberOptions = {
		aSep: '.',
		aDec: ',',
		mDec: 3,
		aPad: false
	};
	$('.autoNum').autoNumeric('init', numberOptions);
</script>

<?php include('_style.php'); ?>
<?php include('_js.php'); ?>