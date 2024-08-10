
<script>
	var table = $('#usProduct table');
	var wrapper = $("#usProduct tbody");
	var i = 0;

	var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
	var currentItem, userList;
	try {
		currentItem = JSON.parse('<?php echo $quote_services; ?>');
		userList = JSON.parse('<?php echo $userList; ?>');
	} catch (error) {}

	var uItem = <?php echo CJSON::encode($this->renderPartial('item_detail', array('quote_services' => $quote_up, 'teeth' => '', 'form' => $form, 'i' => 'iTemp'), true)); ?>;
	var teethRemain = '<?php echo $teeth; ?>';

	$('.autoNum').autoNumeric('init', numberOptions);
	$('[data-toggle="tooltip"]').tooltip();

	$.fn.select2.defaults.set("theme", "bootstrap");
</script>

<script>
/* ---------  LAY TEN NHAN VIEN --------- */
	function getUserName(id_user) {
		var name = ""
		if (typeof userList != 'undefined') {
			name = (typeof userList[id_user] != "undefined") ? userList[id_user] : "";
		}
		return name;
	}
/* ---------  KHOI TAO GIA TRI --------- */
	function showQuoteDetailData(teeth) {
		var mainTable = $(wrapper);
		currentItem.forEach(el => {
			var idx = el.id;
			i = Math.max(idx, i);

			mainTable.append(uItem.replace(/iTemp/g, idx));

			$('.autoNum').autoNumeric('init', numberOptions);

			var servicesObj = "<option value='" + el.id_service + "'>" + el.code_service + "</option>";
			mainTable.find("tr.t" + idx + " .group_services").html(servicesObj);
			mainTable.find("tr.t" + idx + " .quote_code_service").val(el.code_service);

			if (el.id_user != null) {
				var userObj = "<option value='" + el.id_user + "'>" + getUserName(el.id_user) + "</option>";
				mainTable.find("tr.t" + idx + " .group_dentist").html(userObj);
			}

			mainTable.find("tr.t" + idx + " .group_id").val(idx);
			mainTable.find("tr.t" + idx + " .quote_des").val(el.description);
			mainTable.find("tr.t" + idx + " .group_teeth").val(el.teeth);
			mainTable.find("tr.t" + idx + " .group_unit").autoNumeric('set', el.unit_price);
			mainTable.find("tr.t" + idx + " .group_qty").val(el.qty);
			mainTable.find("tr.t" + idx + " .group_amount").autoNumeric('set', el.amount);
			mainTable.find("tr.t" + idx + " .flag_price").val(el.flag_price);

			var typeQuote = el.status;

			if (typeQuote == 1) {
				mainTable.find("tr.t" + idx + ' .preventUpdate').prop('disabled', true);
				mainTable.find("tr.t"+idx+" .sCDiscount").hide();
				mainTable.find("tr.t"+idx+" .chk").prop('checked', true);
			}
		});

		if (teeth) {
			i++;
			mainTable.append(uItem.replace(/iTemp/g, i));
			$('.autoNum').autoNumeric('init', numberOptions);

			mainTable.find("tr.t" + i + " .group_teeth").val(teeth);

			var teethArray = (teeth.split(',')).filter(function (el) {
				return el != "";
			});

			var qty = teethArray.length;

			mainTable.find("tr.t" + i + " .group_qty").val(qty);

			mainTable.animate({
				scrollTop: 210
			}, 800);
		}

		resizeTable();
		dentistList();
		serviceList();
	}
/* ---------  XU LY THAY DOI THONG TIN DICH VU   ---------- */
	function getUpQuotePrice(divTr) {
		var price = divTr.find('.group_unit').autoNumeric('get');
		var qty = divTr.find('.group_qty').val();
		var sum_amount = parseInt(price) * parseInt(qty);

		divTr.find('.group_amount').autoNumeric('set', sum_amount);
	}
/* ---------  IN BAO GIA ------------ */
	function exportQuote(idQuote) {
		var url = "<?php echo CController::createUrl('quotations/exportQuatation')?>?id_quote=" + idQuote;
		window.open(url, 'name');
	}
/* ---------  DANH SACH NHA SY --------- */
	function dentistList() {
		$('.group_dentist').select2({
			dropdownAutoWidth: true,
			placeholder: 'Người thực hiện',
			language: "vi",
			width: '100%',
			ajax: {
				dataType: "json",
				url: '<?php echo CController::createUrl('quotations/getDentistList2'); ?>',
				type: "post",
				delay: 1000,
				data: function (params) {
					return {
						q: params.term, // search term
						page: params.page || 1
					};
				},
				processResults: function (data, params) {
					params.page = params.page || 1;

					return {
						results: data,
						pagination: {
							more: true
						}
					};
				},
				cache: true,
			},
		});
	}
/* ---------  DANH SACH DICH VU --------- */
	function formatService(data) {
		if (!data.id) {
			return data.text;
		}
		return data.name;
	};

	function serviceList() {
		$('.group_services').select2({
			dropdownCssClass: "widthChooseService",
			templateResult: formatService,
			placeholder: 'Dịch vụ',
			width: '100%',
			ajax: {
				dataType: "json",
				url: '<?php echo CController::createUrl('quotations/getServicesList'); ?>',
				type: "post",
				delay: 1000,
				data: function (params) {
					return {
						q: params.term, // search term
						page: params.page || 1,
					};
				},
				processResults: function (data, params) {
					params.page = params.page || 1;
					return {
						results: data,
						pagination: {
							more: true
						}
					};
				},
			},
		});
	}
/* ---------  GIAO DIEN KIECH THUOC BANG --------- */
	function resizeTable() {
		tableH = $('#usProduct .sItem tbody').height();
		if (tableH <= 176) {
			$('#usProduct .sItem tbody').css('margin-right', 0);
		} else {
			$('#usProduct .sItem tbody').css('margin-right', '-17px');
		}
	}
/* --------- TONG GIA TRI DICH VU --------- */
	function getSumAmountUpdate() {
		var sum = 0;
		var sum_usd = 0;

		$('#frm-update-quote .group_amount').each(function () {
			var divTr = $(this).parents('tr');
			if (!divTr.is(":visible")) {
				return true;
			}
			if (divTr.find('.flag_price').val() == 1) {
				sum += +$(this).autoNumeric('get');
			} else {
				sum_usd += +$(this).autoNumeric('get');
			}
		});

		$('#frm-update-quote #Quotation_sum_amount').autoNumeric('set', sum);
		$('#frm-update-quote #Quotation_sum_amount_usd').autoNumeric('set', sum_usd);
	}
$(function () {
/* ---------  KHOI TAO GIA TRI ----------------- */
	$('.frm_datepicker').datepicker({
		dateFormat: 'dd/mm/yy',
	});

	showQuoteDetailData(teethRemain);

/* ---------  THEM TRUONG DICH VU MOI  --------- */
	$('.sbtnAdd').click(function (e) {
		e.preventDefault();
		$(wrapper).animate({
			scrollTop: $(wrapper)[0].scrollHeight
		}, 800);
	})

	$('#upAddServices').click(function (e) {
		var btnActive = $('.upsbtnAdd');
		if (btnActive.hasClass('unbtn')) {
			return;
		}
		btnActive.addClass('unbtn')

		i++;
		$(wrapper).append(uItem.replace(/iTemp/g, i));
		$('.autoNum').autoNumeric('init', numberOptions);

		resizeTable();
		dentistList();
		serviceList();
	});
/* ---------  XOA DICH VU --------- */
	$(wrapper).on("click", ".remove_field", function (e) {
		e.preventDefault();

		var divTr = $(this).parents('tr');
		var quoteId = divTr.find('.group_id').val();

		if (quoteId) {
			divTr.hide();
			divTr.find('.group_delete').val(1);
		} else {
			divTr.remove();
		}

		getSumAmountUpdate();
		resizeTable();

		var itemValue = wrapper.find('tr:last .group_services').val();

		if (itemValue || typeof itemValue == 'undefined') {
			$('.upsbtnAdd').removeClass('unbtn');
		} else {
			$('.upsbtnAdd').addClass('unbtn');
		}
	})
/* ---------  GHI CHU  ---------- */
	$('.sNote').click(function (e) {
		e.preventDefault();
		$('.sNote').hide();
		$('#usAddNote').removeClass('hidden');
	})
/* ---------  CHON DICH VU  ------------- */
	$(wrapper).on('change', '.group_services', function (e) {
		var divTr = $(this).parents('tr');
		var select = $(this);

		var data = select.select2('data');
		if (data.length == 0) {
			return;
		}

		var price = data[0].price;
		var flag_price = data[0].flag_price;

		divTr.find('.quote_des').val(data[0].name);
		divTr.find('.quote_code_service').val(data[0].code);

		divTr.find('.group_unit').autoNumeric('set', price);
		divTr.find('.flag_price').val(flag_price);

		if (divTr.find('.group_services option').length >= 2) {
			divTr.find('.group_services option:first-child').remove();
		}

		getUpQuotePrice(divTr);
		getSumAmountUpdate();

		$('.upsbtnAdd').removeClass('unbtn');
	});
/* ---------  NHAP SO RANG  ------------- */
	$(wrapper).on('keyup', '.group_teeth', function (e) {
		var divTr = $(this).parents('tr');

		var teeth = $(this).val();
		var teethArray = (teeth.split(',')).filter(function (el) {
			return el != "";
		});

		var qty = teethArray.length;

		divTr.find('.group_qty').val(qty);

		getUpQuotePrice(divTr);
		getSumAmountUpdate();
	});
/* ---------  NHAP DON GIA  ------------- */
	$(wrapper).on('keyup', '.group_unit', function (e) {
		var divTr = $(this).parents('tr');

		getUpQuotePrice(divTr);
		getSumAmountUpdate();
	});
/* ---------  NHAP SO LUONG ------------- */
	$(wrapper).on('keyup', '.group_qty', function (e) {
		var divTr = $(this).parents('tr');

		getUpQuotePrice(divTr);
		getSumAmountUpdate();
	});
/* ---------  CAP NHAT BAO GIA  --------- */
	$('form#frm-update-quote').submit(function (e) {
		e.preventDefault();

		$('form#frm-update-quote input, form#frm-update-quote select').each(function () {
			if ($(this).hasClass('frm_datepicker')) {
				var datetime = $(this).val();
				$(this).val(moment(datetime, 'DD/MM/YYYY').format('YYYY-MM-DD'));
			}
			if ($(this).hasClass('autoNum')) {
				var number = $(this).val();
				$(this).val(number.replace(/\./g, ""));
			}
		});

		var id_customer = $('#id_customer').val();

		var formData = new FormData($("#frm-update-quote")[0]);

		if (!formData.checkValidity || formData.checkValidity()) {
			$('.cal-loading').fadeIn('fast');
			jQuery.ajax({
				type: "POST",
				url: "<?php echo CController::createUrl('quotations/updateQuotation'); ?>",
				data: formData,
				datatype: 'json',

				success: function (dataStr) {
					$('.cal-loading').fadeOut('fast');
					var data = JSON.parse(dataStr);

					if (data.status == 'successful') {
						if (id_customer) {
							$("#quote_modal").modal('hide');

							var id_mhg = "";
							if (typeof data.data.quotation != 'undefined') {
								id_mhg = data.data.quotation.id_group_history;
							} else if (typeof data.data.invoice != 'undefined') {
								id_mhg = data.data.invoice.id_group_history;
							}

							var search_tooth = $("#search_tooth").val();
							var search_code_service = $("#search_code_service").val();
							getListInvoiceAndTreatment(id_mhg, id_customer, search_tooth, search_code_service);

							return false;
						} else {
							location.reload();
						}
					} else {
						alert("Có lỗi xảy ra! Xin vui lòng thử lại sau!");
					}

					return false;
				},
				error: function (data) {
					alert("Error occured.Please try again!");
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}

		return false;
	})

})
</script>