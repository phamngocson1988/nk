<script>
    var searchQuote   = {};
    var id_customer   = '<?php echo isset($customer['id']) ? $customer['id'] : ""; ?>';
    var name_customer = '<?php echo isset($customer['fullname']) ? $customer['fullname'] : ""; ?>';
    var branch        = $('#quote_branch').val();
</script>

<script>
    function formatState (data) {
        if (!data.id) { return data.text; }

        datas = '<div class="col-xs-4">' + data.text + '</div>';
        if(moment(data.birthdate).isValid()){
            datas = datas + '<div class="col-xs-2">' + moment(data.birthdate).format("DD/MM/YYYY") + '</div>';
        } else {
            datas += '<div class="col-xs-2"> &nbsp </div>';
        }

        datas +=  '<div class="col-xs-2">' + data.phone + '</div>';
        datas += '<div class="col-xs-4" style="font-size:12px; padding-right: 0;">' + data.adr + '</div>';
        datas += '<div class="clearfix"></div>';
        var $data = $(datas);
        return $data;
    };

    function customer(code_number) {
        $('.select2-search__field').val(code_number);
        $('#quote_customer').select2({
            language        : 'vi',
            placeholder     : 'Khách hàng',
            templateResult  : formatState,
            width           : '150px',
            dropdownCssClass: "changeW",
            allowClear      : true,
            ajax: {
                dataType : "json",
                url      : '<?php echo CController::createUrl('quotations/getCustomerList'); ?>',
                type     : "post",
                delay    : 50,
                data : function (params) {
                    if(code_number && params.term == '')
                        q = code_number;
                    else
                        q = params.term;

                    return {
                        q: q, // search term
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more:true
                        }
                    };
                },
                cache: true,
            },
        });
    }

    function loadQuotation(searchParams) {
        $('.cal-loading').fadeIn('fast');

        $.ajax({
            type    : "POST",
            url     : "<?php echo Yii::app()->createUrl('itemsSales/quotations/loadQuotation')?>",
            dataType: 'html',
            data: searchParams,
            success:function(data){
                if(data) {
                    $("#QuotationList").html(data);
                    $('.cal-loading').fadeOut('fast');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }

    function pagingQuote(page) {
        searchQuote['page'] = page;
        loadQuotation(searchQuote);
    }

    function deleteQuotation(id_quotation,order) {
        if(order == 1) {
            alert("Báo giá đã có đơn hàng! Bạn không được xóa!");
            return false;
        }
        if(confirm("Bạn có thực sự muốn xóa?")) {
            $.ajax({
                type:"POST",
                url:"<?php echo Yii::app()->createUrl('itemsSales/quotations/deleteQuotation')?>",
                data: {
                   id_quotation: id_quotation,
                },
                success:function(data){
                    if(data == 0){
                        alert("Mã báo giá không tồn tại!");
                    } else if(data == 1) {
                        alert("Xóa thành công!");
                        loadQuotation(1,'');
                    } else if(data == -1) {
                        alert(data);
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
        }
    }

    function exportQuote(idQuote, lang) {
        var url="<?php echo CController::createUrl('quotations/exportQuatation')?>?id_quote="+idQuote+"&lang="+lang;
        window.open(url,'name');
    }

    function mailClick(email,code, id_quote){
        $('#mail_content').show();
        $('#mailAcpt').show();
        $('#mail_send').text("");

        $('#mail_inpt').val(email);
        $('.code_quote').text(code);

        $('#mailAcpt').click(function (e) {
            newMail = $('#mail_inpt').val();
            if(!newMail) {return;}

            $.ajax({
                type:"POST",
                url:"<?php echo Yii::app()->createUrl('itemsSales/quotations/sendMailQuotation')?>",
                data: {
                    mailTo  : newMail,
                    id_quote: id_quote,
                },
                success:function(data){
                   if(data == 1){
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
</script>

<script>

$(document).ready(function() {
    $.fn.select2.defaults.set( "theme", "bootstrap" );
    $('#quote_customer').html('<option value="'+id_customer+'">'+name_customer+'</option>');

    $('#QuotationList').on('show.bs.collapse','.collapse', function () {
        $('.collapse.in').collapse('hide');
    });

    $('.frm-datepicker').datetimepicker({
        defaultDate: moment(),
        format     : 'DD/MM/YYYY'
    });

    customer();
    searchQuote['page']        = 1;
    searchQuote['branch']      = branch;
    searchQuote['id_customer'] = id_customer;

    loadQuotation(searchQuote);

    // ----- search quotation
        // -- search time
            $('#quote_time').change(function(e) {
                searchQuote['time'] = $(this).val();
                searchQuote['page'] = 1;

                if ($(this).val() == 5) {
                    $('.search_date').show();
                } else {
                    $('.search_date').hide();
                    loadQuotation(searchQuote);
                }
            });
        // -- search date
            $('.frm-datepicker').on('dp.change', function (e) {
                quote_start = $('#quote_start').val();
                quote_end   = $('#quote_end').val();

                if (quote_end < quote_start) {
                    $('#quote_end').val(quote_start);
                }

                searchQuote['page'] = 1;
                searchQuote['start'] = moment(quote_start, 'DD/MM/YYYY').format('YYYY-MM-DD');
                searchQuote['end'] = moment(quote_end, 'DD/MM/YYYY').format('YYYY-MM-DD');

                loadQuotation(searchQuote);
            });
        // -- search branch
            $('#quote_branch').change(function(e) {
                searchQuote['page'] = 1;
                searchQuote['branch'] = $(this).val();

                loadQuotation(searchQuote);
            });
        // -- search customer
            $('#quote_customer').change(function(e) {
                searchQuote['page'] = 1;
                searchQuote['id_customer'] = $(this).val();

                loadQuotation(searchQuote);
            });
        // -- search customer
            $('#quote_srch').click(function(e) {
                searchQuote['page'] = 1;
                searchQuote['code'] = $('#quote_code').val();
                loadQuotation(searchQuote);
            });

            $('#quote_code').keypress(function(e) {
                if (e.which == 13) {
                    searchQuote['page'] = 1;
                    searchQuote['code'] = $(this).val();
                    loadQuotation(searchQuote);
                }
            });

    $('#oAdds').click(function (e) {
        e.preventDefault();
        x = 1;
        $('.group').html('');
        $('.currentRow').nextAll('tr').remove();
        $('.sNote').show();
        $('#sAddNote').addClass('hidden');
        $('.DisPop').hide();
        $('#Quotation_note').val('');
        $('#Quotation_id_customer').html('');
        $('.showSeg').hide();
        $('.cal_ans').val(0);
        $('#QuotationService_1_id_user').html('');
        $('.sbtnAdd').addClass('unbtn');
    });

    if($('#quote_modal div').length == 0){
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSales/quotations/create')?>",
            datatype:'json',
            success:function(data){
                if(data){
                    $("#quote_modal").html(data);
                    $('.cal-loading').fadeOut('slow');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    };

    $('#QuotationList').on('click','.qUpdate',function(e){
        var id_quotation = $(this).parents('tr').find('input:hidden[name=id_quotation]').val();

        if(!id_quotation) return;

        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type    :"POST",
            url     :"<?php echo Yii::app()->createUrl('itemsSales/quotations/updateQuotation')?>",
            datatype:'json',
            data    : {id_quotation: id_quotation,},
            success:function(data){
                if(data) {
                    $("#update_quote_modal").html(data);
                    $('.cal-loading').fadeOut('slow');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    });
});

</script>