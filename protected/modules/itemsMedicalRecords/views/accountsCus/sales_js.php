<script id="quote_val">
    var id_quotation = "";
    var id_invoice = "";
    var id_customer = $('#id_customer').val();
    var id_mhg = $('#id_mhg').val();
    var id_schedule = $('#id_schedule').val();
</script>

<script id="quote_func">
    // ----- HIEN THI GIAO DIEN TAO BAO GIA
        function addNewQuote(teethNumber) {
            $.ajax({
	        	type: 'POST',
	        	url: baseUrl + '/itemsSales/quotations/create',
	        	data: {
	        		"id_customer": id_customer,
	        		"id_mhg": id_mhg,
	        		"teeth": teethNumber,
	        		"id_schedule": id_schedule
	        	},
	        	success: function (data) {
	        		$('#quote_modal').html(data);
                    $('#quote_modal').modal('show');

                    $('.cal-loading').fadeOut('fast');
	        	},
	        	error: function (data) {
	        	}
	        });
        }

    // ----- HIEN THI GIAO DIEN CAP NHAT BAO GIA
        function updateQuote(teethNumber) {
            $.ajax({
                type: "POST",
                url: baseUrl + '/itemsSales/quotations/updateQuotation',
                data: {
                    id_quotation: id_quotation,
                    teeth: teethNumber,
                    id_schedule: id_schedule
                },
                success: function (data) {
                    $('.cal-loading').fadeOut('fast');
                    if (data == -1) {
                        addNewQuote(teethNumber);
                    } else {
                        $("#quote_modal").html(data);
                        $('#quote_modal').modal('show');
                    }
                },
                error: function (data) {
                    alert("Error occured.Please try again!");
                },

            });
        }

    // ----- LAY ID HOA DON
        function getIdInvoice(id_mhg) {
            $.ajax({
                type: "POST",
                url: baseUrl + '/itemsSales/Invoices/CheckInvoiceWithHistoryGroup',
                data: {id_mhg: id_mhg},
                success: function (data) {
                    id_invoice = data;
                    $('.id_invoice').val(data);
                },
                error: function (data) {
                    alert("Error occured.Please try again!");
                },
            });
        }

    // ----- HIEN THI GIAO DIEN TAO HOA DON
        function addNewInvoice(teethNumber) {
            $.ajax({
	        	type: 'POST',
	        	url: baseUrl + '/itemsSales/Invoices/invoiceLayout',
	        	data: {
	        		id_customer: id_customer,
	        		id_mhg: id_mhg,
	        		teeth: teethNumber,
	        		id_schedule: id_schedule,
                    id_invoice: id_invoice
	        	},
	        	success: function (data) {
	        		$('#invoice_modal').html(data);
                    $('#invoice_modal').modal('show');

                    $('.cal-loading').fadeOut('fast');
	        	},
	        	error: function (data) {
                    console.log(data);
                    alert("Error!");
	        	}
	        });
        }

    // ----- HIEN THI GIAO DIEN CAP NHAT HOA DON
        function updateInvoice(teethNumber) {
            $.ajax({
                type: "POST",
                url: baseUrl + '/itemsSales/Invoices/updateInvoice',
                data: {
                    id_invoice: id_invoice,
                    teeth: teethNumber,
                    id_schedule: id_schedule
                },
                success: function (data) {
                    $('.cal-loading').fadeOut('fast');
                    if (data == -1) {
                        addNewInvoice(teethNumber);
                    } else {
                        $("#invoice_modal").html(data);
                        $('#invoice_modal').modal('show');
                    }
                },
                error: function (data) {
                    alert("Error occured.Please try again!");
                },

            });
        }
</script>

<script id="quote_call">
    getIdInvoice(id_mhg);

    // ----- MO GIAO DIEN XU LY BAO GIA
        $('.quote_open').click(function (e) {
            $('#toggle-dental').fadeOut('fast');
            $('.cal-loading').fadeIn('fast');

            var teethNumber = "";
            if ($(this).data('teeth') == 1) {
                teethNumber = $('#hidden_string_number').val();
            }

            id_quotation = $('#id_quotation').val();

            if (id_quotation == "") {
                addNewQuote(teethNumber);
            } else {
                updateQuote(teethNumber);
            }
        });
    // ----- MO GIAO DIEN XU LY HOA DON
        $('.invoice_open').click(function (e) {
            $('#toggle-dental').fadeOut('fast');
            $('.cal-loading').fadeIn('fast');

            if (id_invoice == "") {
                getIdInvoice(id_mhg);
            }

            var teethNumber = "";
            if ($(this).data('teeth') == 1) {
                teethNumber = $('#hidden_string_number').val();
            }

            id_invoice = $('#id_invoice').val();

            addNewInvoice(teethNumber);

            // if (id_invoice == 0) {
            //     addNewInvoice(teethNumber);
            // } else {
            //     updateInvoice(teethNumber);
            // }
        });
</script>

<script id="transaction">
    var transactionID, transactionChange;
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};

    $.fn.select2.defaults.set( "theme", "bootstrap" );
	$.fn.select2.defaults.set("language", "vi");

    //#region --- LAY DANH SACH BAC SY
        function dentistList() {
            $('.change_dentist').select2({
                dropdownAutoWidth: true,
                placeholder: 'Người thực hiện',
                language: "vi",
                width: '100%',
                ajax: {
                    dataType: "json",
                    url: baseUrl+'/itemsMedicalRecords/AccountsCus/GetDentistList',
                    type: "post",
                    delay: 800,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (dataObj, params) {
                        params.page = params.page || 1;

                        var data = $.map(dataObj.data, function (obj) {
                            obj.text = obj.text || obj.name;
                            return obj;
                        });

                        return {
                            results: data,
                            pagination: {
                                more: (dataObj.paging.num_page > dataObj.paging.cur_page)
                            }
                        };
                    },
                    cache: true,
                },
            });
        }
    //#endregion

    dentistList();
    viewTreatment();

    //#region --- HIEN THI POP UP CHON THAO TAC HUY / CHUYEN
        function showPopupChooseActionCancel() {
            $('td.serviceCodeAction').mouseover(function (e) {
                e.preventDefault();

                var code = $(this).data('code');
                var TrIdx = $(this).data('idx');
                var status = $(this).data('status');
                var confirm = $(this).data('confirm');
                var allowCancel = $(this).data('allow_cancel');

                if (!code || status == -1 || allowCancel == 0) {
                    return;
                }

                $('.autoNum').autoNumeric('init', numberOptions);

                var w = $('#left_medical_records').outerWidth() + $('#ds_dieutri th:nth-child(1)').outerWidth() + $('#ds_dieutri th:nth-child(2)').outerWidth() + 40;
                var t = $('.exam_result').outerHeight() + $('.treatmen_result_1').outerHeight() + $('.treatmen_result_2').outerHeight() + $('#ds_dieutri tr:nth-child(1)').outerHeight() + 47;

                for (let index = 1; index <= TrIdx; index++) {
                    t += $('.invoiceTreatment' + index).outerHeight();
                }

                var scroll = $('#InvoiceAndTreatment').scrollTop();

                if (scroll > 0) {
                    t = t - scroll;
                }

                $('#actionInvoiceTransaction').css({
                    top: t +'px',
                    left: w + 'px',
                });

                $('#actionInvoiceTransaction').show();
                $('.servicesName').text(code);
                // if (confirm == '1') {
                //     $('.transactionCancel, hr.invoiceTransaction').hide();
                // } else {
                //     $('.transactionCancel, hr.invoiceTransaction').show();
                // }

                transactionID = TrIdx;
            });

            $(document).mouseover(function (e) {
                e.preventDefault();

                var parentCls = e.target.parentNode.className;
                var parentID = e.target.parentNode.id;
                var cls = $(e.target)[0].className;

                if (typeof cls == 'undefined' || typeof parentCls == 'undefined') {
                    $('#actionInvoiceTransaction').hide();
                }

                if (cls.indexOf('serviceCodeAction') >= 0) {
                    var code = $($(e.target)[0]).data('code');
                    if (!code) {
                        $('#actionInvoiceTransaction').hide();
                    }
                }

                if (parentCls.indexOf('invoiceTransaction') < 0 && cls.indexOf('serviceCodeAction') < 0 && parentID !== 'tab_medical_records') {
                    $('#actionInvoiceTransaction').hide();
                }
            });

            actionTransaction();
            actionTransactionCheck();
            actionTransactionSubmit();
        }
    //#endregion

    //#region --- LAY THONG TIN CHI TIET DICH VU
    function getInvoiceDetail(id_invoice_detail) {
        return $.ajax({
            type: "POST",
            url: baseUrl + '/itemsSales/invoices/GetInvoiceDetail',
            data: {
                id_invoice_detail: id_invoice_detail
            },
            dataType: "json",
        });
    }
    //#endregion

    //#region --- THAO TAC XU LY CHON HUY / CHUYEN
        function actionTransaction() {
            $('.transactionCancel').click(function (e) {
                e.preventDefault();

                if (transactionID) {
                    $('.autoNum').autoNumeric('init',numberOptions);

                    var data = $('.invoiceTreatment'+transactionID).find('.serviceCodeAction').data();

                    $('#actionTransactionCancel').modal('show');
                    $('#actionTransactionCancel form')[0].reset();

                    $.when(getInvoiceDetail(data.id)).then(function (dataI) {
                        $('#actionTransactionCancel .transaction-id').val(data.id);
                        $('#actionTransactionCancel .transaction-idi').val(data.iId);
                        $('#actionTransactionCancel .transaction-service_name').val(data.svName);
                        $('#actionTransactionCancel .transaction-amount, #actionTransactionCancel .transaction-refund').autoNumeric('set', dataI.amount);
                        $('#actionTransactionCancel .transaction-dentist_name').val(dataI.user_name);
                        $('#actionTransactionCancel .transaction-id_dentist').val(dataI.id_user);
                    });
                }
            });

            $('.transactionChange').click(function (e) {
                e.preventDefault();

                if (transactionID) {
                    $('.autoNum').autoNumeric('init',numberOptions);

                    var data = $('.invoiceTreatment'+transactionID).find('.serviceCodeAction').data();

                    $('#actionTransactionChange').modal('show');
                    $('#actionTransactionChange form')[0].reset();

                    $.when(getInvoiceDetail(data.id)).then(function (dataI) {
                        var maxPercent = 100 - parseInt(dataI.percent_change);
                        var maxRefund = maxPercent * parseInt(dataI.amount) / 100;
                        $('#actionTransactionChange .transaction-id').val(dataI.id);
                        $('#actionTransactionChange .transaction-idi').val(data.iId);
                        $('#actionTransactionChange .transaction-service_name').val(data.svName);
                        $('#actionTransactionChange .transaction-amount').autoNumeric('set', dataI.amount);
                        $('#actionTransactionChange .transaction-refund').autoNumeric('set', maxRefund);
                        $('#actionTransactionChange .transaction-dentist_name').val(dataI.user_name + ' (' + maxPercent + '%)');
                        $('#actionTransactionChange .transaction-refund_percent').attr('max', maxPercent).val(maxPercent);
                    });
                }
            });
        }
    //#endregion

    //#region --- THAO TAC XU LY CLIENT
        function actionTransactionCheck() {
            $('.transaction-refund').on('keyup keypress', function (e) {
                e.preventDefault();

                var amount = parseInt($(this).parents('form').find('.transaction-amount').autoNumeric('get'));
                var refund = parseInt($(this).autoNumeric('get'));

                if (refund > amount) {
                    $(this).autoNumeric('set', amount);
                }

                if (refund < 0) {
                    $(this).autoNumeric('set', 0);
                }

                var percent = (refund/amount * 100);
                if (percent > 100) {
                    percent = 100;
                }

                $(this).parents('form').find('.transaction-refund_percent').val(percent);
            });

            $('.transaction-refund_percent').on('input', function (e) {
                e.preventDefault();

                var amount = parseInt($(this).parents('form').find('.transaction-amount').autoNumeric('get'));
                var percent = parseFloat($(this).val());

                if (percent > 100) {percent = 100;}
                if (!percent) {percent = 0;}

                var refund = Math.ceil(amount*percent/100);

                $(this).val(percent);
                $(this).parents('form').find('.transaction-refund').autoNumeric('set', refund);
            });
        }
    //#endregion

    //#region --- THAO TAC SUBMIT
        var transactionCancel;
        function actionTransactionSubmit() {
            $('#invoiceTransactionCancel').submit(function (e) {
                e.preventDefault();

                $('form#invoiceTransactionCancel input').each(function() {
                    if ($(this).hasClass('autoNum')) {
                        var number = $(this).val();
                        $(this).val(number.replace(/\./g, ""));
                    }
                });

                var formData = new FormData($("#invoiceTransactionCancel")[0]);
                formData.append('id_mhg', id_mhg);

                if (!formData.checkValidity || formData.checkValidity()) {
                    transactionCancel = $.ajax({
                        type: "POST",
                        url: baseUrl + '/itemsSales/invoices/TransCancel',
                        data: formData,
                        beforeSend: function (xhr) {
                            if (!(typeof transactionCancel == 'undefined' || transactionCancel == null)) {
                                xhr.abort();
                            }
                        },
                        success: function (data, status, xhr) {
                            if (xhr.status == 200) {
                                transactionCancel = null;
                            }

                            try {
                                data = JSON.parse(data);
                            } catch (error) {
                                showMessages(data);
                                return;
                            }

                            if (typeof data == 'string') {
                                showMessages(data);
                                return;
                            }

                            if (data.status == 1) {
                                $('#actionTransactionCancel').modal('hide');
                                showMessages("Hủy dịch vụ thành công!");

                                var dataObj = data.data;
                                var confirm = data.confirm;

                                if (typeof dataObj == 'object' && confirm != 0) {

                                    var id_dentist = dataObj.id_user;
                                    var teeth = dataObj.teeth;
                                    teethArr = teeth.split(",");

                                    var reason = (typeof data.reason != 'undefined') ? data.reason : '';
                                    var percent = (typeof dataObj.percent_change != 'undefined') ? dataObj.percent_change : '0';

                                    var treatment = "Hoàn trả " + parseFloat(percent).toFixed(2) + "% (" + formatNumber(dataObj.amount) + " VND)";
                                    treatment += (reason) ? " do " + reason : "";

                                    $('#frm-save-medical-history .tooth_numbers').val(teethArr);
                                    $('#frm-save-medical-history .treatment_work').val(treatment);
                                    $('#frm-save-medical-history .id_dentist').val(id_dentist);
                                    $('#frm-save-medical-history').submit();
                                }

                                getListInvoiceAndTreatment(id_mhg, id_customer, '', '');
                            } else {
                                showErrorMessage(data);
                            }
                        },
                        error: function (data) {
                            alert("Error occured.Please try again!");
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            });

            $('#invoiceTransactionChange').submit(function (e) {
                e.preventDefault();

                $('form#invoiceTransactionChange input').each(function() {
                    if ($(this).hasClass('autoNum')) {
                        var number = $(this).val();
                        $(this).val(number.replace(/\./g, ""));
                    }
                });

                var formData = new FormData($("#invoiceTransactionChange")[0]);
                formData.append('id_mhg', id_mhg);

                if (!formData.checkValidity || formData.checkValidity()) {
                    transactionChange = $.ajax({
                        type: "POST",
                        url: baseUrl + '/itemsSales/invoices/TransChange',
                        data: formData,
                        beforeSend: function (xhr) {
                            if (!(typeof transactionChange == 'undefined' || transactionChange == null)) {
                                xhr.abort();
                            }
                        },
                        success: function (data, status, xhr) {
                            if (xhr.status == 200) {
                                transactionChange = null;
                            }

                            data = JSON.parse(data);

                            if (typeof data == 'string') {
                                showMessages(data);
                                return;
                            }

                            if (data.status == 1) {
                                $('#actionTransactionChange').modal('hide');
                                showMessages("Chuyển dịch vụ thành công!");

                                var dataObj = data.invoicedetail;

                                if (typeof dataObj == 'object') {
                                    var id_dentist = $('#invoiceTransactionChange .change_dentist').val();
                                    var teeth = dataObj.teeth;
                                    var code = dataObj.code_service;
                                    var dentist_name = dataObj.user_name;
                                    var dateCreate = moment(dataObj.create_date).format('DD-MM-YYYY');

                                    var reason = (typeof data.reason != 'undefined') ? data.reason : '';

                                    teethArr = teeth.split(",");
                                    $('#frm-save-medical-history .tooth_numbers').val(teethArr);

                                    var treatment = dateCreate + " chuyển " + code + ". " + reason;

                                    $('#frm-save-medical-history .treatment_work').val(treatment);
                                    $('#frm-save-medical-history .id_dentist').val(id_dentist);
                                    $('#frm-save-medical-history').submit();
                                }
                            } else {
                                showErrorMessage(data);
                            }
                        },
                        error: function (data) {
                            alert("Error occured.Please try again!");
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            });
        }
    //#endregion

</script>