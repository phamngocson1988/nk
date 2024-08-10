<script>
	$('[data-toggle="tooltip"]').tooltip();

	$.fn.select2.defaults.set( "theme", "bootstrap" );
	$.fn.select2.defaults.set("language", "vi");

	var today = moment().format('DD/MM/YYYY');

	var Item = <?php echo CJSON::encode($this->renderPartial('item_detail', array('invoice_detail' => $invoice_detail, 'teeth' => $teeth, 'form' => $form, 'i' => 'iTemp'), true)); ?>;
	var teethRemain = '<?php echo $teeth; ?>';

	var table = $('.invoice-new table');
	var wrapper = $(".invoice-new tbody");

	var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
	var max_fields = 50;
	var i = 1;
</script>

<script>
/* ------------  DANH SACH KHACH HANG  ------------ */
	function customerList() {
		$('#Quotation_id_customer').select2({
		    placeholder: 'Khách hàng',
		    	width: '100%',
		    	language: "vi",
		    	dropdownAutoWidth: true,
		    	ajax: {
		    		dataType: "json",
		    		url: '<?php echo CController::createUrl('quotations/getCustomerList'); ?>',
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
/* ------------  DANH SACH DICH VU  --------------- */
	function formatService (data) {
	    if (!data.id) { return data.text; }
	    return data.name;
	};

	function serviceList(id_prB) {
		$('.group_services').select2({
			placeholder: 'Dịch vụ',
			width: '100%',
			templateResult: formatService,
			dropdownCssClass: "widthChooseService",
			dropdownAutoWidth: true,
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
/* ------------  DANH SACH NHA SY  ---------------- */
	function dentistList() {
		$('.group_dentist').select2({
			dropdownAutoWidth: true,
			placeholder: 'Người thực hiện',
			language: "vi",
			width: '100%',
			ajax: {
				dataType: "json",
				url: '<?php echo CController::createUrl('quotations/getDentistList2 '); ?>',
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
/* ------------  GIAO DIEN KICH THUOC BANG  ------- */
	function resizeTable() {
		tableH = $('.sItem tbody').height();

		if(tableH <= 176) {
			$('.sItem tbody').css('margin-right',0);
		} else {
			$('.sItem tbody').css('margin-right','-17px');
		}
	}
/* ------------  TONG GIA TRI DICH VU  ------------ */
	function getSumAmount() {
		var sum = 0;
		var sumUSD = 0;

		$('#frm-invoice .group_amount').each(function() {
			var divTr = $(this).parents('tr');
			var flag = divTr.find('.flag_price').val();

			if (divTr.find('.flag_price').val() == 1) {
				sum += +$(this).autoNumeric('get');
			} else {
				sumUSD += +$(this).autoNumeric('get');
			}
		});

		$('#Invoice_sum_amount').autoNumeric('set', sum);
		$('#Invoice_sum_amount_usd').autoNumeric('set', sumUSD);
	}
/* ------------  DANH SACH NHOM KHACH HANG  ------------ */
	function choseSeg(id_customer) {
		$.ajax({
			type: "POST",
			url: "<?php echo CController::createUrl('quotations/getCustomerSegment') ?>",
			data: {
				id_customer: id_customer
			},
			dataType: 'json',
			success: function (data) {
				opSeg = '';
				$f = true;
				$sv = '';
				if (data.length > 0) {
					$.each(data, function (k, v) {
						if ($f == true) {
							$sv = v.id_segment;
							$svDe = v.name;
							$f = false;
						}
						opSeg = opSeg + '<option value="' + v.id_segment + '">' + v.name + '</option>';
					});

					$('.choseSeg').html(opSeg);
					$('.segTxt').val($svDe);
					$('.showSeg').show();
				} else {
					$('.showSeg').hide();
				}
			},
			error: function (data) {
				alert("Error occured.Please try again!");
			},
        });
	}
/* ------------  TAO BAO GIA CHO KHACH HANG KHAC  ------------ */
	function resetTable(teeth) {
		wrapper.find('tr').remove();
		wrapper.append(Item.replace(/iTemp/g, 1));
		if (teeth) {
			wrapper.find('.group_teeth').val(teeth);

			var teethArray = (teeth.split(',')).filter(function (el) {
				return el != "";
			});

			var qty = teethArray.length;

			wrapper.find('.group_qty').val(qty);
		}

    	$('.autoNum').autoNumeric('init', numberOptions);
		$('.newbtnAdd').addClass('unbtn');

		dentistList();
		serviceList();
	}

/* ------------  XU LY THAY DOI THONG TIN DICH VU   ---------- */
	function getQuotePrice(divTr) {
		var price = divTr.find('.group_unit').autoNumeric('get');
		var qty = divTr.find('.group_qty').val();
		var sum_amount = parseInt(price)*parseInt(qty);

		divTr.find('.group_amount').autoNumeric('set', sum_amount);
	}
$(document).ready(function(){
/* ------------  KHOI TAO GIA TRI --------------- */
	$('.frm_datepicker').datepicker({
		dateFormat: 'dd/mm/yy',
	});

	$('.frm_datepicker').change(function(e){
		var create_date = $('.create_date').datepicker("getDate");
		var last_date = $('.complete_date').datepicker("getDate");
		if (create_date >= last_date) {
			$('.complete_date').datepicker("setDate", create_date);
		}
	});

	$('.create_date').val(today);
	$('.complete_date').val(today);

	<?php if(!$id_customer){ ?>
		customerList();
	<?php } ?>

/* ------------  THEM TRUONG DICH VU MOI -------- */
	if (table.find('tbody tr').length <= 0) {
		resetTable(teethRemain);
	}

	$('.sbtnAdd').click(function(e){
		e.preventDefault();
		$('.invoice-new table tbody').animate({
       		scrollTop: $('.invoice-new table tbody')[0].scrollHeight}, 1000);
	});

	$('#addServices').click(function (e) {
		var btnActive = $('.newbtnAdd');
		if (btnActive.hasClass('unbtn')) {
			return;
		}
		btnActive.addClass('unbtn');

		i ++;
		$(wrapper).append(Item.replace(/iTemp/g, i));

		var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    	$('.autoNum').autoNumeric('init',numberOptions);

		$('[data-toggle="tooltip"]').tooltip();

		resizeTable();
		dentistList();
		serviceList();
	});
/* ------------  XOA DICH VU -------------------- */
	$(wrapper).on("click", ".remove_field", function (e) {
		e.preventDefault();

		$(this).parents('.currentRow').remove();
		resizeTable();

		var itemValue = $('.sItem tr:last').find('.group_services').val();

		if (itemValue || typeof itemValue == 'undefined') {
			$('.newbtnAdd').removeClass('unbtn');
		} else {
			$('.newbtnAdd').addClass('unbtn');
		}
	})
/* ------------  GHI CHU ------------------------ */
	$('.sNote').click(function (e) {
		e.preventDefault();
		$('.sNote').hide();
		$('#sAddNote').removeClass('hidden');
	});
/* ------------  CHON DICH VU ------------------- */
	$(wrapper).on('change', '.group_services', function (e) {
		var divTr = $(this).parents('tr');
		var select = $(this);

		var data = select.select2('data');
		if (data.length == 0) {
			return;
		}

		var price = data[0].price;
		var flag_price = data[0].flag_price;

		divTr.find('.group_des').val(data[0].name);
		divTr.find('.group_code_service').val(data[0].code);

		divTr.find('.group_unit').autoNumeric('set', price);
		divTr.find('.flag_price').val(flag_price);

		getQuotePrice(divTr);
		getSumAmount();

		$('.newbtnAdd').removeClass('unbtn');
	});

/* ------------  NHAP SO RANG ------------------- */
	$(wrapper).on('keyup', '.group_teeth', function (e) {
		var divTr = $(this).parents('tr');

		var teeth = $(this).val();
		var teethArray = (teeth.split(',')).filter(function (el) {
			return el != "";
		});

		var qty = teethArray.length;

		divTr.find('.group_qty').val(qty);

		getQuotePrice(divTr);
		getSumAmount();
	});
/* ------------  NHAP DON GIA ------------------- */
	$(wrapper).on('keyup','.group_unit',function(e){
		var divTr = $(this).parents('tr');

		getQuotePrice(divTr);
		getSumAmount();
	});
/* ------------  NHAP SO LUONG ------------------ */
	$(wrapper).on('keyup','.group_qty',function(e){
		var divTr = $(this).parents('tr');

		getQuotePrice(divTr);
		getSumAmount();
	});
/* ------------  CHON KHACH HANG ---------------- */
	$('#Quotation_id_customer').change(function (e) {
		var id_customer = $('#Quotation_id_customer').val();
		resetTable();

		if(id_customer) {
			choseSeg(id_customer);
		}
	});
/* ------------  XU LY LUU TRU ---------------- */
	$('form#frm-invoice').submit(function(e) {
		e.preventDefault();

		$('form#frm-invoice input, form#frm-invoice select').each(function() {
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
		var id_schedule = $('#id_schedule').val();

		var formData = new FormData($("#frm-invoice")[0]);

		if (!formData.checkValidity || formData.checkValidity()) {
			$('.cal-loading').fadeIn('fast');
			$.ajax({
				type: "POST",
				url: "<?php echo CController::createUrl('invoices/create')?>",
				data: formData,
				success: function (dataStr) {
					$('.cal-loading').fadeOut('fast');
					var data = JSON.parse(dataStr);

					if (id_customer) {
						$("#invoice_modal").modal('hide');

						var id_invoice = "", id_mhg = "";
						if (typeof data.data.invoice != 'undefined') {
							id_invoice = data.data.invoice.id;
							id_mhg = data.data.invoice.id_group_history;
						}

						$('.id_invoice').val(id_invoice);

						var search_tooth = $("#search_tooth").val();
						var search_code_service = $("#search_code_service").val();
						getListInvoiceAndTreatment(id_mhg, id_customer, search_tooth, search_code_service);

						return false;
					}

					location.reload();
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
	});
})
</script>