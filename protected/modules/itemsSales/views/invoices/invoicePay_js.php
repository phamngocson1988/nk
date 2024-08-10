<script>
	const TABS = ['cashType', 'creditType', 'transferType', 'insuranceType', 'depositType'];
	const TAB_CASH = 1, TAB_CREDIT = 2, TAB_TRANSFER = 3, TAB_INSURANCE = 4, TAB_DEPOSITE = 5;
	var currentPayId = TAB_CASH;
	var numberOptions = { aSep: '.', aDec: ',', mDec: 3, aPad: false };

	//#region --- KIEM TRA GIA TRI NHAP
	function checkNum() {
		var pay_type = $('.pay_type').val();
		var pay_amount = parseInt($('.pay_amount').autoNumeric('get')); // tien tra
		var reCurr = parseInt($('#reCurr').autoNumeric('get')); // tien nhan
		var mustPay = parseInt($('.pay_customer_need').autoNumeric('get')); // tien phai thu

		var check = 1;

		if (currentPayId == TAB_INSURANCE) {
			var insuranceSum = $('.Invoice-sum_insurance').autoNumeric('get');
			if (insuranceSum <= 0 || insuranceSum > mustPay) check = 0;
		}

		if (currentPayId == TAB_DEPOSITE) {
			var depositeCustomer = $('#sum_deposit').autoNumeric('get');
			if (pay_amount > depositeCustomer) {
				check = 0;
			}
		}

		if (check == 1) {
			$('.Invoice-sum_insurance').css('border', '1px solid #ccc');
			$('.pay_amount').css('border', '1px solid #ccc');
			$('#reCurr').css('border', '1px solid #ccc');
			return 1;
		}

		$('.Invoice-sum_insurance').css('border', '1px solid red');
		$('.pay_amount').css('border', '1px solid red');
		$('#reCurr').css('border', '1px solid red');

		return 0;
	}
	//#endregion

	//#region --- TINH TIEN CON NO
	function getBalance() {
		var pay_amount = 0;
		if (currentPayId == TAB_INSURANCE) {
			pay_amount = parseInt($('.Invoice-sum_insurance').autoNumeric('get'));
		} else {
			pay_amount = parseInt($('.pay_amount').autoNumeric('get'));
		}

		if (currentPayId == TAB_CREDIT) {
			var promotion = parseInt($('#Receipt_pay_promotion').autoNumeric('get'));
			pay_amount = pay_amount + promotion;
		}

		var mustPay = $('.pay_customer_need').autoNumeric('get');

		var minus = mustPay - pay_amount;
		minus = (minus > 0) ? minus : 0;

		$('.balance').autoNumeric('set', minus);
	}
	//#endregion

	//#region --- TINH TIEN CHUYEN VAO DEPOSIT
	function getDeposit() {
		if (currentPayId == TAB_CASH || currentPayId == TAB_CREDIT) {
			var pay_amount = parseInt($('.pay_amount').autoNumeric('get'));
			var mustPay = parseInt($('.pay_customer_need').autoNumeric('get'));

			var deposit = 0;
			if (pay_amount > mustPay) {
				deposit = pay_amount - mustPay;
			}

			$('.pay_deposite').autoNumeric('set', deposit);
		}
	}
	//#endregion

	//#region --- TINHH TONG TIEN THANH TOAN
	function getSumPayment() {
		var pay_amount = !isNaN(parseInt($('.pay_amount').autoNumeric('get'))) ? parseInt($('.pay_amount').autoNumeric('get')) : 0;
		var transFee = !isNaN(parseInt($('.transFee').autoNumeric('get'))) ? parseInt($('.transFee').autoNumeric('get')) : 0;
		var pay_promotion = !isNaN(parseInt($('#Receipt_pay_promotion').autoNumeric('get'))) ? parseInt($('#Receipt_pay_promotion').autoNumeric('get')) : 0;

		$('.feeSumCard').autoNumeric('set', pay_amount + transFee + pay_promotion);
	}
	//#endregion

	$(function() {
		$('.autoNum').autoNumeric('init', numberOptions);

		var today = moment().format('YYYY-MM-DD HH:mm:ss');
		var day = moment().format('DD/MM/YYYY');
		var addrVat = '<?php echo $adr; ?>';

		$('#vat_date').datepicker();

		$('.today').text(today);
		$('.pay_type').val(1);
		$('#card_percent').val('');

		//#region --- CHON HINH THUC THANH TOAN
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			var payTypeId = $(e.target).attr('id');
			var pay_amount = $('.pay_amount').autoNumeric('get');
			currentPayId = payTypeId;

			$('.pay_type').val(payTypeId);
			$('#ckCurr').attr('checked', false);
			$('.dCurr').hide();

			for (var idx = 0; idx < TABS.length; idx++) {
				var tab = TABS[idx]
				$(`.${tab}`).hide();
			}

			$(`.${TABS[parseInt(payTypeId) - 1]}`).show();

			if (payTypeId != TAB_CREDIT) {
				$('.transFee').val(0);
				$('.feeSumCard').val(pay_amount);
			}

			getBalance();
		});
		//#endregion

		//#region --- NHAP TIEN KHACH TRA
		$('.pay').keyup(function(e) {
			getBalance();
			getDeposit();
			getSumPayment();
		})
		//#endregion

		//#region --- NHAP KHUYEN MAI
		$('#Receipt_pay_promotion').on('keyup keypress input', function() {
			getSumPayment();
			getBalance();
		});
		//#endregion

		//#region --- NHAP PHI GIAO DICH
		$('.transFee').on('keyup keypress input', function() {
			getSumPayment();
		});
		//#endregion

		//#region --- NHAP BAO LANH BAO HIEM
		$('.Invoice-sum_insurance').on('keyup keypress', function() {
			getBalance();
		});
		//#endregion

		//#region --- CHON VAT
		$('#ck_VAT').change(function(e) {
			var ck = $('#ck_VAT').is(':checked');

			if (ck == true) {
				$('.dVAT').show();
				$('#vat_date').val(day);
				$('#vat_place').val(addrVat);
			} else {
				$('.dVAT').hide();
				$('#vat_date').val('');
				$('#vat_place').val('');
			}
		});
		//#endregion

		//#region --- SUBMIT FORM
		$('form#frm-pay-invoice').submit(function(e) {
			e.preventDefault();

			if (!checkNum()) return false;

			var dis = $('#ck_VAT').is('[disabled]');
			if (dis == false) {
				date_vat = $('#vat_date').val();
				ch = moment(date_vat, 'DD/MM/YYYY').format('YYYY-MM-DD HH:mm:ss');
				$('#vat_date').val(ch);
			}

			$('.autoNum').each(function(i) {
				var self = $(this);
				try {
					var v = self.autoNumeric('get');
					self.autoNumeric('destroy');
					self.val(v);
				} catch (err) {
					console.log("Not an autonumeric field: " + self.attr("name"));
				}
			});

			var formData = new FormData($("#frm-pay-invoice")[0]);

			if (!formData.checkValidity || formData.checkValidity()) {
				$('.cal-loading').fadeIn('fast');
				$.ajax({
					type: "POST",
					url: "<?php echo CController::createUrl('invoices/invoicesPay') ?>",
					data: formData,
					dataType: 'json',

					cache: false,
					contentType: false,
					processData: false,

					success: function(data) {
						if (data >= 0) location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSales/invoices/View?id=' + data;

						$('.cal-loading').fadeOut('fast');
						$('.autoNum').autoNumeric('init', numberOptions);
					},
					error: function(data) {
						$('.cal-loading').fadeOut('fast');
						$('.autoNum').autoNumeric('init', numberOptions);
						alert("Error occured.Please try again!");
					},
				});
			}
			return false;
		})
		//#endregion
	});
</script>