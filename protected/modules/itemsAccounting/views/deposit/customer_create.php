<style>
    .deposite-modal input:disabled, .deposite-modal input:read-only {
        background: transparent; border: none; box-shadow: none;
    }

    .deposite-modal .deposite-info .form-group {margin-bottom: 0.1em;}

    .deposite-modal input:disabled:hover, .deposite-modal input:read-only:hover {
        cursor: default;
    }

    .deposite-modal input:read-only:focus, .deposite-modal input:disabled:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .deposite-modal .isRead * { background: transparent; border: none; box-shadow: none; }
</style>

<div class="modal-dialog modal-lg pop_bookoke deposite-modal">
    <div class="modal-content">
        <div class="modal-header sHeader">
            <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h3 id="modalTitle" class="modal-title">Cập nhật deposit của khách hàng</h3>
        </div>

        <div class="modal-body">
            <form id="frm-deposite-update">
                <input type="hidden" name="id_customer" class="deposit-id_customer" value="<?php echo $customer['id_customer']; ?>">

                <div class="col-sm-12 deposite-info">
                    <div class="alert alert-success col-sm-12 form-horizontal deposite-info">
                        <div class="col-sm-6 form-group">
                            <label class="col-sm-5 control-label">Mã khách hàng:</label>
                            <div class="col-sm-6 text">
                                <input type="text" class="form-control text-right" readOnly value="<?php echo $customer['code_number']; ?>">
                            </div>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="col-sm-5 control-label">Khách hàng:</label>
                            <div class="col-sm-6 text">
                                <input type="text" class="form-control text-right" readOnly value="<?php echo $customer['fullname']; ?>">
                            </div>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="col-sm-5 control-label">Deposit:</label>
                            <div class="col-sm-6 text">
                                <div class="input-group isRead">
                                    <input type="text" class="autoNum form-control text-right deposite-amount" readOnly value="<?php echo $customer['deposit']; ?>">
                                    <span class="input-group-addon">VND</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 deposite-note" style="color: red; font-size: 0.85em; display: none;"></div>

                <div class="col-sm-12 deposite-handle" style="margin-top: 0.5em; margin-bottom: 2em; padding-top: 2em; border-top: 1px dotted #ccc">
                    <div class="form-horizontal">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-5">Hình thức:</label>
                                <div class="col-sm-7">
                                    <select class="form-control deposite-type" name="type" required>
                                        <option value=''>Chọn hình thức</option>
                                        <?php foreach (DepositTransaction::$_typeUpdate as $value): ?>
                                            <option data-cal="<?php echo DepositTransaction::$_type[$value]['calculation']; ?>" value='<?php echo $value; ?>'><?php echo DepositTransaction::$_type[$value]['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Số tiền deposit cập nhật<span class="text-danger">*</span>:</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" name="amount_update" class="form-control autoNum text-right deposite-amount_update" value="0">
                                        <span class="input-group-addon">VND</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Tổng deposit:</label>
                                <div class="col-sm-7">
                                    <div class="input-group isRead">
                                        <input type="text" name="amount_deposit" class="form-control autoNum text-right deposite-amount_sum" readOnly value="<?php echo $customer['deposit']; ?>">
                                        <span class="input-group-addon">VND</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Ghi chú:</label>
                                <div class="col-sm-8">
                                    <textarea name="note" class="form-control" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="deposite-button text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="color: black; margin-right: 0.4em;">Hủy</button>
                    <button type="submit" class="btn oBtnDetail">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('.autoNum').autoNumeric('init', numberOptions);

//#region --- KIEM TRA DU LIEU SUBMIT
    function checkSubmitFrmPaid($frm) {
        var isValid = true, error = '';

        var amount_update = parseInt($($frm + ' .deposite-amount_update').autoNumeric('get'));
        var amount_sum = parseInt($($frm + ' .deposite-amount_sum').autoNumeric('get'));

        if (amount_update <= 0) {
            error += "Số tiền deposite cập nhật thêm nhỏ hơn 0.<br>";
            isValid = false;
        }

        if (amount_sum < 0) {
            error += "Tổng deposit nhỏ hơn 0.<br>";
            isValid = false;
        }

        $($frm + ' .deposite-note').html(error);
        $($frm + ' .deposite-note').show();

        return isValid;
    }
//#endregion

//#region --- TINH GIA TRI DEPOSIT
    function calSumDeposit() {
        var deposit = parseInt($('#frm-deposite-update .deposite-amount').autoNumeric('get'));

        var cal = $('#frm-deposite-update .deposite-type').find(':selected').data('cal');
        var amount_update = parseInt($('#frm-deposite-update .deposite-amount_update').autoNumeric('get'));

        var deposit_sum = deposit;

        if (cal == '+') {
            deposit_sum = deposit + amount_update;
        } else if (cal == '-') {
            deposit_sum = deposit - amount_update;
        }

        $('#frm-deposite-update .deposite-amount_sum').autoNumeric('set', deposit_sum);
    }
//#endregion

    $(document).ready(function () {
        $('#frm-deposite-update .deposite-type').change(function (e) {
            e.preventDefault();
            calSumDeposit();
        });

        $('#frm-deposite-update .deposite-amount_update').on('keypress keyup', function (e) {
            e.preventDefault();
            calSumDeposit();
        });

        $('form#frm-deposite-update').submit(function(e) {
            e.preventDefault();

            if (!checkSubmitFrmPaid('#frm-deposite-update')) {
                return false;
            }

            $('#frm-deposite-update .autoNum').each(function(i) {
                var self = $(this);
                try {
                    var v = self.autoNumeric('get');
                    self.autoNumeric('destroy');
                    self.val(v);
                } catch (err) {
                    console.log("Not an autonumeric field: " + self.attr("name"));
                }
            });

            var formData = new FormData($("#frm-deposite-update")[0]);

            if (!formData.checkValidity || formData.checkValidity()) {
                $('.cal-loading').fadeIn('fast');

                $.ajax({
                    type: "POST",
                    url: "<?php echo CController::createUrl('deposit/update')?>",
                    data: formData,
                    dataType: 'json',
                    success: function (dataStr) {
                        $('.cal-loading').fadeOut('fast');

                        if (dataStr.status == 1) {
                            $('#deposit-modal').modal('hide');

                            var data = dataStr.data;
                            console.log(data);
                            $('#deposit-list .tableList tbody').prepend(`
                                <tr>
                                    <td>${moment(data.create_date).format('HH:mm DD/MM/YYYY')}</td>
                                    <td>${data.user_name}</td>
                                    <td>${data.code_invoice}</td>
                                    <td>${data.type_name}</td>
                                    <td>${formatNumber(data.amount)}</td>
                                    <td>${data.note}</td>
                                    <td>
                                        <a href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsAccounting/deposit/printDeposit?id=${data.id}&amp;idc=${data.id_customer}&amp;lang=vi" target="_blank" title="" class="label label-success">In-vi</a>
                                        <a href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsAccounting/deposit/printDeposit?id=${data.id}&amp;idc=${data.id_customer}&amp;lang=en" target="_blank" title="" class="label label-success">In-en</a>
                                    </td>
                                </tr>
                            `);
                        } else {
                            alert(dataStr['error-message']);
                        }
                        $('.autoNum').autoNumeric('init', numberOptions);
                    },
                    error: function (data) {
                        $('.cal-loading').fadeOut('fast');
                        $('.autoNum').autoNumeric('init', numberOptions);
                        alert("Error occured.Please try again!");
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

            return false;
        });
    });
</script>