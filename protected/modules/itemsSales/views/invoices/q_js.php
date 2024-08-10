<script>
    var id = '<?php echo $id ? $id : 0; ?>';
    var id_customer = '<?php echo isset($customer['id']) ? $customer['id'] : ""; ?>';
    var name_customer = '<?php echo isset($customer['fullname']) ? $customer['fullname'] : ""; ?>';
    var branch = $('#invoice_branch').val();

    var searchInvoice = {};
</script>

<script>
    function formatState(data) {
        if (!data.id) {
            return data.text;
        }

        datas = '<div class="col-xs-4">' + data.text + '</div>';
        if (moment(data.birthdate).isValid()) {
            datas = datas + '<div class="col-xs-2">' + moment(data.birthdate).format("DD/MM/YYYY") + '</div>';
        } else {
            datas += '<div class="col-xs-2"> &nbsp </div>';
        }

        datas += '<div class="col-xs-2">' + data.phone + '</div>';
        datas += '<div class="col-xs-4" style="font-size:12px; padding-right: 0;">' + data.adr + '</div>';
        datas += '<div class="clearfix"></div>';
        var $data = $(datas);
        return $data;
    };

    function customer() {
        $('#invoice_customer').select2({
            language: 'vi',
            placeholder: 'Khách hàng',
            templateResult: formatState,
            width: '150px',
            dropdownCssClass: "changeW",
            allowClear: true,
            ajax: {
                dataType: "json",
                url: '<?php echo CController::createUrl('quotations/getCustomerList'); ?>',
                type: "post",
                delay: 50,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
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

    function exportRpt(evnt, id, idRct, lang) {
        evnt.preventDefault();
        if (idRct) {
            var url = "<?php echo CController::createUrl('invoices/printReceipt') ?>?id=" + id + "&idRpt=" + idRct + "&lang=" + lang;
        } else {
            var url = "<?php echo CController::createUrl('invoices/printReceipt') ?>?id=" + id + "&idRpt=" + idRct + "&lang=" + lang;
        }
        window.open(url, 'name');
    }

    function mailClick(email, code, id_inv, idRct) {
        $('#mail_content').show();
        $('#mailAcpt').show();
        $('#mail_send').text("");

        $('#mail_inpt').val(email);
        $('.code_quote').text(code);

        $('#mailAcpt').click(function(e) {
            newMail = $('#mail_inpt').val();
            if (!newMail)
                return;

            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('itemsSales/invoices/sendMailInvoice') ?>",
                data: {
                    mailTo: newMail,
                    id_inv: id_inv,
                    id_rct: idRct,
                },
                success: function(data) {
                    if (data == 1) {
                        $('#mail_send').text("Gửi mail thành công!");
                        $('#mailAcpt').hide();
                        $('#mail_content').hide();
                    }
                },
                error: function(data) {
                    $('#mail_send').text("Có lỗi xảy ra! xin vui lòng gửi lại sau!");
                    $('#mailAcpt').hide();
                    $('#mail_content').hide();
                },
            });
        })
    }

    function loadInvoice(searchParams) {
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('itemsSales/invoices/loadInvoice') ?>",
            dataType: 'html',
            data: searchParams,
            success: function(data) {
                $('.cal-loading').fadeOut('fast');
                if (data) {
                    $("#InvoiceList").html(data);
                }
            },
            error: function(data) {
                $('.cal-loading').fadeOut('fast');
                alert("Error occured.Please try again!");
            },
        });
    }

    function pagingInvoice(page) {
        searchInvoice['page'] = page;
        loadInvoice(searchInvoice);
    }

    // lay thong tin nhom khach hang
    function getSegment(id_customer) {
        console.log(id_customer);
        $.ajax({
            type: "POST",
            url: "<?php echo CController::createUrl('quotations/getCustomerSegment') ?>",
            data: {
                id_customer: id_customer
            },
            dataType: 'json',

            success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(k, v) {
                        $('#id_segment').val(v['id_segment']);
                    });
                }
            },
        });
    }

    //#region --- XAC NHAN HOA DON
    function confirmInvoice(id_invoice) {
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('itemsSales/invoices/showConfirmInvoiceModal') ?>",
            datatype: 'json',
            data: {
                id_invoice: id_invoice,
            },
            success: function(data) {
                if (data) {
                    $("#confirm_invoice_modal").html(data);
                    $("#confirm_invoice_modal").modal("show");
                }
                $('.cal-loading').fadeOut('fast');
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }
    //#endregion

    //#region --- THANH TOAN HOA DON
    function payInvoice(id_invoice) {
        var id_customer = $(this).parents('tr').find('input:hidden[name=id_customer]').val();
        var lstServices = $(this).parents('tr').find('input:hidden[name=lstServices]').val();
        var lstProducts = $(this).parents('tr').find('input:hidden[name=lstProducts]').val();

        $('.cal-loading').fadeIn('fast');

        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('itemsSales/invoices/invoicesPayLayout') ?>",
            datatype: 'json',
            data: {
                id_invoice: id_invoice,
            },
            success: function(data) {
                if (data) {
                    $("#invoice_pay_modal").html(data);
                    $("#invoice_pay_modal").modal("show");

                    $('#lstProducts').val(lstProducts);
                    $('#lstServices').val(lstServices);

                    getSegment(id_customer);
                }
                $('.cal-loading').fadeOut('slow');
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }
    //#endregion
</script>

<script>
    $(document).ready(function() {
        $.fn.select2.defaults.set("theme", "bootstrap");

        $('#InvoiceList').on('show.bs.collapse', '.collapse', function() {
            $('.collapse.in').collapse('hide');
        });

        $('#invoice_customer').html('<option value="' + id_customer + '">' + name_customer + '</option>');

        $('.frm-datepicker').datetimepicker({
            defaultDate: moment(),
            format: 'DD/MM/YYYY'
        });

        searchInvoice['page'] = 1;
        searchInvoice['id'] = id;
        searchInvoice['id_customer'] = id_customer;
        searchInvoice['branch'] = branch;

        customer();
        loadInvoice(searchInvoice);

        //#region --- IN
        $('#InvoiceList').on('click', '.ivLang', function(e) {
            lang = $(this).data("val");
            id_invoice = $(this).parents('tr').find('input:hidden[name=id_invoice]').val();

            exportRpt(e, id_invoice, 0, lang);
        });
        //#endregion

        //#region --- SEARCH INVOICE
        // -- search time
        $('#invoice_time').change(function(e) {
            searchInvoice['time'] = $(this).val();
            searchInvoice['page'] = 1;

            if ($(this).val() == 5) {
                $('.search_date').show();
            } else {
                $('.search_date').hide();
                loadInvoice(searchInvoice);
            }
        });

        // -- search date
        $('.frm-datepicker').on('dp.change', function(e) {
            invoice_start = $('#invoice_start').val();
            invoice_end = $('#invoice_end').val();

            if (invoice_end < invoice_start) {
                $('#invoice_end').val(invoice_start);
            }

            searchInvoice['page'] = 1;
            searchInvoice['start'] = moment(invoice_start, 'DD/MM/YYYY').format('YYYY-MM-DD');
            searchInvoice['end'] = moment(invoice_end, 'DD/MM/YYYY').format('YYYY-MM-DD');

            loadInvoice(searchInvoice);
        });

        // -- search branch
        $('#invoice_branch').change(function(e) {
            searchInvoice['page'] = 1;
            searchInvoice['branch'] = $(this).val();

            loadInvoice(searchInvoice);
        });

        // -- search customer
        $('#invoice_customer').change(function(e) {
            searchInvoice['page'] = 1;
            searchInvoice['id_customer'] = $(this).val();

            loadInvoice(searchInvoice);
        });

        // -- search type
        $('#invoice_type').change(function(e) {
            searchInvoice['page'] = 1;
            searchInvoice['confirm'] = $(this).val();

            loadInvoice(searchInvoice);
        });

        // -- search code
        $('#invoice_srch').click(function(e) {
            searchInvoice['page'] = 1;
            searchInvoice['code'] = $('#invoice_code').val();
            loadInvoice(searchInvoice);
        });

        $('#invoice_code').keypress(function(e) {
            if (e.which == 13) {
                searchInvoice['page'] = 1;
                searchInvoice['code'] = $(this).val();
                loadInvoice(searchInvoice);
            }
        });
        //#endregion

        //#region --- PAY
        $('#InvoiceList').on('click', '.iPay', function(e) {
            var id_invoice = $(this).parents('tr').find('input:hidden[name=id_invoice]').val();
            var confirm = $(this).parents('tr').find('input:hidden[name=confirm]').val();

            if (!id_invoice) return;

            if (confirm == 1) {
                payInvoice(id_invoice);
            } else {
                confirmInvoice(id_invoice);
            }
        });
        //#endregion
    });
</script>