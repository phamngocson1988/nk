<script>
//#region --- VARIABLE
    var searchData = {}, timer;
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
//#endregion

//#region --- LIST CUSTOMER
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
        $('.insurance-id_customer-list').select2({
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
//#endregion

//#region --- LIST PATNER
    function partner() {
        $('.insurance-id_partner-list').select2({
            language: 'vi',
            placeholder: 'Đối tác',
            width: '150px',
            dropdownAutoWidth: true,
            allowClear: true,
            ajax: {
                dataType: "json",
                url: '<?php echo CController::createUrl('insuranceDebt/getPatnerList'); ?>',
                type: "post",
                delay: 50,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(dataObj, params) {
                    params.page = params.page || 1;

                    var data = $.map(dataObj.data, function(obj) {
                        obj.text = obj.code + ' - ' + (obj.text || obj.name);
                        return obj
                    });

                    return {
                        results: data,
                        pagination: {
                            more: params.page < dataObj.page
                        }
                    };
                },
                cache: true,
            },
        });
    }
//#endregion

//#region --- LIST INSURANCE
    function loadInsurance(searchParams) {
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('itemsSales/insuranceDebt/loadInsurance') ?>",
            dataType: 'html',
            data: searchParams,
            success: function(data) {
                $('.cal-loading').fadeOut('fast');
                if (data) {
                    $("#insurance-list").html(data);
                }
            },
            error: function(data) {
                $('.cal-loading').fadeOut('fast');
                alert("Error occured.Please try again!");
            },
        });
    }
//#endregion

//#region --- LIST INSURANCE DETAIL
    function loadInsuranceDetail(id_insurance) {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('itemsSales/insuranceDebt/loadInsuranceDetail') ?>",
            data: {id_insurance: id_insurance},
            dataType: 'json',
            success: function(data) {
                var trData;
                if (data.length > 0) {
                    $.each(data, function (idx, val) {
                        var color = (val['type'] == 3) ? 'color: brown' : '';
                        trData += `
                            <tr style="${color}">
                                <td>${parseInt(idx) + 1}</td>
                                <td>${val['author']}</td>
                                <td>${moment(val['create_date']).format('HH:mm DD/MM/YYYY')}</td>
                                <td>${val['type_name']}</td>
                                <td>${formatNumber(val['amount'])}</td>
                                <td>${val['reason']}</td>
                            </tr>
                        `;
                    });
                } else {
                    trData = `
                        <tr>
                            <td colspan="6">Chưa có lịch sử giao dịch!</td>
                        </tr>
                    `;
                }

                $('#insurance-list tbody.insurance-info').html(trData);
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }
//#endregion

//#region --- PHAN TRANG
function insurancePaging(page) {
    searchData['page'] = page;
    loadInsurance(searchData);
}
//#endregion

    $(document).ready(function() {
    //#region --- INIT
        $.fn.select2.defaults.set("theme", "bootstrap");

        $('#insurance-list').on('show.bs.collapse', '.collapse', function() {
            $('.collapse.in').collapse('hide');
        });

        $('.frm-datepicker').datetimepicker({
            defaultDate: moment(),
            format: 'DD/MM/YYYY'
        });

        searchData.page = 1;
        searchData.id_branch = $('#insurance-id_branch').val();
    //#endregion

        customer();
        partner();
        searchData['code'] = $('.insurance-code-url').val();
        loadInsurance(searchData);

    //#region --- LOC DU LIEU
        $('#insurance-time').change(function(e) {
            e.preventDefault();
            searchData['time'] = $(this).val();
            searchData['page'] = 1;

            if ($(this).val() == 5) {
                $('.search_date').show();
            } else {
                $('.search_date').hide();
                loadInsurance(searchData);
            }
        });

        $('.frm-datepicker').on('dp.change', function(e) {
            var start = $('#insurance-start').val();
            var end = $('#insurance-end').val();

            if (end < start) {
                $('#insurance-end').val(start);
            }

            searchData['page'] = 1;
            searchData['start'] = moment(start, 'DD/MM/YYYY').format('YYYY-MM-DD');
            searchData['end'] = moment(end, 'DD/MM/YYYY').format('YYYY-MM-DD');

            loadInsurance(searchData);
        });

        $('#insurance-id_branch').change(function(e) {
            searchData['page'] = 1;
            searchData['id_branch'] = $(this).val();

            loadInsurance(searchData);
        });

        $('#insurance-id_customer').change(function(e) {
            searchData['page'] = 1;
            searchData['id_customer'] = $(this).val();

            loadInsurance(searchData);
        });

        $('#insurance-id_partner').change(function(e) {
            searchData['page'] = 1;
            searchData['id_partner'] = $(this).val();

            loadInsurance(searchData);
        });

        $('#insurance-code_invoice').on('input', function(e) {
            if (timer) {
                clearTimeout(timer);
            }

            timer = setTimeout(function() {
                searchData['page'] = 1;
                searchData['code_invoice'] = $('#insurance-code_invoice').val();

                loadInsurance(searchData);
            }, 500);
        });
    //#endregion

    //#region --- XEM CHI TIET
        $('#insurance-list').on('click', '.insurance-view', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var isExpand = $(this).attr('aria-expanded');

            if (isExpand == 'false') {
                loadInsuranceDetail(id);
            }
        });
    //#endregion

    //#region --- CAP NHAT
        $('#insurance-list').on('click', '.insurance-update', function(e) {
            var id_insurance = $(this).parents('tr').find('.insurance-id').val();
            if (!id_insurance) return;

            $('.cal-loading').fadeIn('fast');

            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('itemsSales/insuranceDebt/updateLayout') ?>",
                data: { id_insurance: id_insurance, },
                success: function(data) {
                    $('.cal-loading').fadeOut('fast');

                    if (data) {
                        $("#insurance-modal").html(data);
                        $('#insurance-modal').modal('show');
                        $('#insurance-modal .insurance-note').html('');
                        $('#insurance-modal .insurance-note').hide();
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
        });
    //#endregion

    //#region --- THANH TOAN
        $('#insurance-list').on('click', '.insurance-paid', function(e) {
            var id_insurance = $(this).parents('tr').find('.insurance-id').val();
            if (!id_insurance) return;

            $('.cal-loading').fadeIn('fast');

            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('itemsSales/insuranceDebt/PaidLayout') ?>",
                data: { id_insurance: id_insurance, },
                success: function(data) {
                    $('.cal-loading').fadeOut('fast');

                    if (data) {
                        $("#insurance-modal").html(data);
                        $('#insurance-modal').modal('show');
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
        });
    //#endregion

    //#region --- HUY
        $('#insurance-list').on('click', '.insurance-cancel', function(e) {
            var id_insurance = $(this).parents('tr').find('.insurance-id').val();
            if (!id_insurance) return;

            if (confirm("Bạn có muốn hủy công nợ bảo hiểm này không>")) {
                $('.cal-loading').fadeIn('fast');

                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createUrl('itemsSales/insuranceDebt/Cancel') ?>",
                    data: { id_insurance: id_insurance, },
                    success: function(data) {
                        $('.cal-loading').fadeOut('fast');

                        if (data.status == 0) {
                            alert(data['error-message']);
                        } else {
                            location.reload();
                        }
                    },
                    error: function(data) {
                        alert("Error occured.Please try again!");
                    },
                });
            }
        });
    //#endregion
    });
</script>