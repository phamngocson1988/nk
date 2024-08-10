<style type="text/css">
    .text {
        background: transparent !important;
        border: 0;
        box-shadow: none;
        cursor: default;
        text-align: center;
    }

    .tableInvoiceDetail thead,
    .tableInvoiceDetail tfoot,
    .tableInvoiceDetail tbody {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .tableInvoiceDetail tbody {
        max-height: 200px;
        overflow: auto;
    }

    .tableInvoiceDetail>thead>tr>th,
    .tableInvoiceDetail>tbody>tr>td,
    .tableInvoiceDetail>tfoot>tr>td {
        padding: 2px;
        vertical-align: middle;
        word-wrap: break-word;
    }

    .row1 {
        width: 25%
    }

    td.row1 {
        text-align: left;
    }

    .row2 {
        width: 10%
    }

    .row3 {
        width: 6%
    }

    .row4 {
        width: 10%
    }

    .row5 {
        width: 10%
    }

    .row6 {
        width: 5%
    }

    .row7 {
        width: 5%
    }
</style>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header sHeader">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h3 class="modal-title">Xác nhận hóa đơn số <?php echo $invoice['code']; ?></h3>
        </div>

        <form id="formConfirmInvoice" class="form-horizontal">
            <input type="hidden" id="Invoice-id" name="id_invoice" value="<?php echo $invoice['id']; ?>">
            <input type="hidden" id="Invoice-id_customer" name="id_customer" value="<?php echo $invoice['id_customer']; ?>">

            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-3">Đối tác</label>
                    <div class="col-sm-9">
                        <select onchange="getNewListInvoiceDetail();" class="form-control" name="partnerID" id="price_book">
                            <option value="">Chọn Đối tác</option>
                            <?php foreach ($partnerList as $key => $value) : ?>
                                <option value="<?php echo $value['id'] ?>" data-pricebook="<?php echo $value['id_price_book'] ?>"><?php echo $value['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Nhập phần trăm cần giảm</label>

                    <div class="col-sm-9">
                        <div class="input-group">
                            <input value="0" id="percent_decrease_all" placeholder="Nhập phần trăm cần giảm" min="0" max="100" class="form-control" type="number">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-xs-offset-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Tỷ giá</label>

                        <div class="col-sm-5">
                            <div class="row input-group">
                                <input value="1" id="curreny_exchange_value" placeholder="Nhập tỷ giá" class="form-control autoNum" type="text" name="exchange_rate">
                                <span class="input-group-addon">VND / USD</span>
                            </div>
                        </div>

                        <div class="col-sm-3 text-center">
                            <button class="btn btn-info curreny_exchange"><i class="glyphicon glyphicon-transfer"></i></button>
                        </div>
                    </div>
                </div>

                <table class="table tableInvoiceDetail">
                    <thead>
                        <tr>
                            <th class="row1">Tên DV</th>
                            <th class="row2">Giá</th>
                            <th class="row3">Giảm %</th>
                            <th class="row4">Số lượng</th>
                            <th class="row5">Thành tiền</th>
                            <th class="row7">Đơn vị tính</th>
                            <th class="row6">Áp dụng</th>
                        </tr>
                    </thead>

                    <tbody class="tbodyListInvoiceDetail">
                        <?php $total = 0;

                        foreach ($listInvoiceDetail as $key => $value) {
                            $total += $value['unit_price'] * $value['qty'];
                            ?>

                            <tr class="tick item-s-<?php echo $value['id_service']; ?>" id="item<?php echo $value['id']; ?>">
                                <td class="row1">
                                    <input name="InvoiceDetail[<?php echo $key; ?>][id_invoice_detail]" type="hidden" value="<?php echo $value['id']; ?>">
                                    <input name="InvoiceDetail[<?php echo $key; ?>][id_service]" type="hidden" value="<?php echo $value['id_service']; ?>">
                                    <input name="InvoiceDetail[<?php echo $key; ?>][amount_old]" type="hidden" value="<?php echo $value['amount']; ?>">

                                    <?php echo $value['services_name']; ?>
                                </td>

                                <td class="row2">
                                    <input name="InvoiceDetail[<?php echo $key; ?>][unit_price]" readonly type="text" class="form-control autoNum text unit_price" style="text-align: right;" value="<?php echo $value['unit_price']; ?>">
                                </td>

                                <td class="row3">
                                    <input name="InvoiceDetail[<?php echo $key; ?>][percent_decrease]" value="0" placeholder="Giảm %" min="0" max="100" class="form-control percent_decrease_input" type="number" oninput="calculatorInvoiceValue();">
                                </td>

                                <td class="row4">
                                    <input name="InvoiceDetail[<?php echo $key; ?>][qty]" readonly type="text" class="form-control text qty" value="<?php echo $value['qty']; ?>">
                                </td>

                                <td class="row5">
                                    <input name="InvoiceDetail[<?php echo $key; ?>][amount]" readonly type="text" class="form-control autoNum text amount" style="text-align: right;" value="<?php echo $value['amount']; ?>">
                                </td>

                                <td class="row7">
                                    <?php echo ($value['flag_price'] == 1) ? 'VND' : 'USD'; ?>
                                </td>

                                <td class="row6">
                                    <input name="InvoiceDetail[<?php echo $key; ?>][accept]" type="checkbox" class="accept_input" value="1">
                                </td>

                                <input type="hidden" class="price_book_view" value="<?php echo $value['unit_price']; ?>">
                                <input type="hidden" class="unit_price_view" value="<?php echo $value['unit_price']; ?>">
                                <input type="hidden" class="flag_price" value="<?php echo $value['flag_price']; ?>">
                                <input type="hidden" class="amount_view" value="<?php echo $value['amount']; ?>">
                            </tr>
                        <?php  } ?>
                    </tbody>

                    <tfoot class="tfootListInvoiceDetail">
                        <tr>
                            <td colspan="4" style="vertical-align: middle; text-align: right; width: 82%">Tổng cộng</td>
                            <td colspan="2"><input name="total" readonly type="text" class="form-control autoNum text sum_amount" style="text-align: right;" value="<?php echo $total; ?>"></td>
                        </tr>

                        <tr>
                            <td colspan="4" style="vertical-align: middle; text-align: right; width: 82%">Giảm giá</td>
                            <td colspan="2"><input name="amount_reduced" class="form-control autoNum text sum_percent_decrease" type="text" value="0" style="text-align: right;"></td>
                        </tr>

                        <tr>
                            <td colspan="4" style="vertical-align: middle; text-align: right; width: 82%">Phải thu</td>
                            <td colspan="2"><input name="sum_amount" readonly type="text" class="form-control autoNum text sum_total" style="text-align: right;" value="<?php echo $total; ?>"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="modal-footer" style="border: 0;">
                <button type="button" class="btn btn_cancel" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn oBtnDetail">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

<script>
    const VND = 1, USD = 2;

    var tbody_list_invoice_detail = $(".tbodyListInvoiceDetail").clone();
    var tfoot_list_invoice_detail = $(".tfootListInvoiceDetail").clone();

    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false };
    $('.autoNum').autoNumeric('init', numberOptions);

    //#region --- TINH GIA TRI HOA DON
        function calculatorInvoiceValue() {
            $('.autoNum').autoNumeric('init', numberOptions);

            var curreny_exchange = parseInt($('#curreny_exchange_value').autoNumeric('get'));
            var amount_reduced = 0, sum_amount = 0, sum_total = 0;

            $('.tick').each(function (index, element) {
                var el = $(element);

                var price_book_view = parseInt(el.find('.price_book_view').val());
                var unit_price = price_book_view;

                var percent = parseInt(el.find('.percent_decrease_input').val());
                var qty = parseInt(el.find('.qty').val());

                var flag_price = el.find('.flag_price').val();
                if (flag_price == USD) {
                    unit_price = price_book_view * curreny_exchange;
                }

                var amount = unit_price * qty
                var percent_decrease = amount * percent/100;
                var total = amount - percent_decrease;

                el.find('.unit_price').autoNumeric('set', unit_price)
                el.find('.amount').autoNumeric('set', total);

                amount_reduced += percent_decrease;
                sum_amount += amount;
                sum_total += total;
            });

            $('.sum_percent_decrease').autoNumeric('set', amount_reduced);
            $('.sum_amount').autoNumeric('set', sum_amount);
            $('.sum_total').autoNumeric('set', sum_total);
        }
    //#endregion

    //#region --- CAP NHAT GIA DICH VU THEO BANG GIA CUA DOI TAC
        function getNewListInvoiceDetail() {
            var id_pricebook = $('#price_book option:selected').data('pricebook');
            var id_invoice = $('#Invoice-id').val();

            $('#curreny_exchange_value').val(1);
            $('.curreny_exchange').show();
            $('#percent_decrease_all').val(0);

            if (id_pricebook && id_invoice) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createUrl('itemsSales/invoices/getNewListInvoiceDetail') ?>",
                    data: {
                        id_pricebook: id_pricebook,
                        id_invoice: id_invoice,
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            var amount_reduced = 0, sum_amount = 0, total = 0;

                            $.each(data, function(k, v) {
                                var id_service = v.id_service;
                                var price = parseInt(v.price);

                                $('.item-s-' + id_service + ' .price_book_view').val(price);
                            });

                            calculatorInvoiceValue();
                        }
                    },
                    error: function(data) {
                        alert("Error occured. Please try again!");
                    }
                });
            } else {
                $(".tbodyListInvoiceDetail").replaceWith(tbody_list_invoice_detail.clone());
                $(".tfootListInvoiceDetail").replaceWith(tfoot_list_invoice_detail.clone());

                calculatorInvoiceValue();
            }
        }
    //#endregion

    $('#formConfirmInvoice').on('input', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#percent_decrease_all").on('input', function(e) {
        e.preventDefault();

        var percent_decrease = $('#percent_decrease_all').val();
        $('.percent_decrease_input').val(percent_decrease);

        calculatorInvoiceValue();
    });

    $('#curreny_exchange_value').on('keyup', function(e) {
        e.preventDefault();
        $('.curreny_exchange').show();
    });

    $('.curreny_exchange').click(function(e) {
        e.preventDefault();

        $('.curreny_exchange').hide();
        calculatorInvoiceValue();
    });

    $('#formConfirmInvoice').submit(function(e) {
        e.preventDefault();

        var name_price_book = '', id_price_book = '';

        if ($('#price_book').val()) {
            var name_price_book = $("#price_book option:selected").text();
            var id_price_book = $('#price_book :selected').data('pricebook');
        }

        var check = 0;
        $.each($('.accept_input'), function() {
            if ($(this).is(":checked")) {
                check ++;
            }
        });

        if (check <= 0) {
            alert("Hoá đơn không có dịch vụ được áp dụng!");
            return;
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

        var percent_decrease_of_invoice = $("#percent_decrease_all").val();
        var formData = new FormData($("#formConfirmInvoice")[0]);

        formData.append('check', check);
        formData.append('name_price_book', name_price_book);
        formData.append('id_price_book', id_price_book);
        formData.append('percent_decrease_of_invoice', percent_decrease_of_invoice);

        if (!formData.checkValidity || formData.checkValidity()) {
            $('.cal-loading').fadeIn('fast');
            $.ajax({
                type: "POST",
                url: "<?php echo CController::createUrl('invoices/confirmInvoice') ?>",
                data: formData,
                dataType: 'json',
                success: function(data) {
                    $('.cal-loading').fadeOut('fast');

                    if (data['status'] == '1') {
                        location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSales/invoices/View?id=' + data['id_invoice'];
                    } else {
                        alert(data['error-message']);
                        $('.autoNum').autoNumeric('init', numberOptions);
                    }
                },
                error: function(data) {
                    $('.cal-loading').fadeOut('fast');
                    $('.autoNum').autoNumeric('init', numberOptions);
                    alert("Error occured. Please try again!");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    });
</script>