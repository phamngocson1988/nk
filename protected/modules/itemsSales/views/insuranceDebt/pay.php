<style>
    .insurance-popup input:disabled, .insurance-popup input:read-only {
        background: transparent; border: none; box-shadow: none;
    }

    .insurance-popup .insurance-info .form-group {margin-bottom: 0.1em;}

    .insurance-popup input:disabled:hover, .insurance-popup input:read-only:hover {
        cursor: default;
    }

    .insurance-popup input:read-only:focus, .insurance-popup input:disabled:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .insurance-popup .isRead * { background: transparent; border: none; box-shadow: none; }
</style>

<div class="modal-dialog modal-lg pop_bookoke insurance-popup">
    <div class="modal-content">
        <div class="modal-header sHeader">
            <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h3 id="modalTitle" class="modal-title">Thanh toán công nợ BH - hóa đơn #<?php echo $insurance['code_invoice']; ?></h3>
        </div>

        <div class="modal-body">
            <form id="frm-insurance-paid">
                <input type="hidden" name="id_insurance" value="<?php echo $insurance['id']; ?>">
                <div class="col-sm-12 insurance-info">
                    <div class="alert alert-success col-sm-12 form-horizontal insurance-info">
                        <div class="col-sm-6 form-group">
                            <label class="col-sm-5 control-label">Mã khách hàng:</label>
                            <div class="col-sm-6 text">
                                <input type="text" class="form-control text-right" readOnly value="<?php echo $insurance['customer']['code_number']; ?>">
                            </div>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="col-sm-5 control-label">Đối tác:</label>
                            <div class="col-sm-6 text">
                                <input type="text" class="form-control text-right" readOnly value="<?php echo (isset($insurance['partner'])) ? $insurance['partner']['name'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="col-sm-5 control-label">Khách hàng:</label>
                            <div class="col-sm-6 text">
                                <input type="text" class="form-control text-right" readOnly value="<?php echo $insurance['customer']['fullname']; ?>">
                            </div>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="col-sm-5 control-label">Mã hóa đơn:</label>
                            <div class="col-sm-6 text">
                                <input type="text" class="form-control text-right" readOnly value="<?php echo $insurance['code_invoice']; ?>">
                            </div>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="col-sm-5 control-label">Tổng BH Bảo lãnh:</label>
                            <div class="col-sm-6 text">
                                <div class="input-group isRead">
                                    <input type="text" class="autoNum form-control text-right insurance-amount" readOnly value="<?php echo $insurance['amount']; ?>">
                                    <span class="input-group-addon">VND</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="col-sm-5 control-label">Công nợ BH:</label>
                            <div class="col-sm-6 isRead">
                                <div class="input-group isRead">
                                    <input type="text" class="autoNum form-control text-right insurance-balance" readOnly value="<?php echo $insurance['balance']; ?>">
                                    <span class="input-group-addon">VND</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 insurance-note" style="color: red; font-size: 0.85em; display: none;"></div>

                <div class="col-sm-12 insurance-handle" style="margin-top: 0.5em; margin-bottom: 2em; padding-top: 2em; border-top: 1px dotted #ccc">
                    <div class="form-horizontal">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-5">Hình thức:</label>
                                <div class="col-sm-7">
                                    <select class="form-control insurance-type" name="type" required>
                                        <?php foreach (InsuranceTransaction::$_typePay as $value): ?>
                                            <option data-cal="<?php echo InsuranceTransaction::$_type[$value]['calculation']; ?>" value='<?php echo $value; ?>'><?php echo InsuranceTransaction::$_type[$value]['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Số tiền thanh toán<span class="text-danger">*</span>:</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" name="amount_paid" class="form-control autoNum text-right insurance-amount_paid" value="0">
                                        <span class="input-group-addon">VND</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Còn nợ:</label>
                                <div class="col-sm-7">
                                    <div class="input-group isRead">
                                        <input type="text" name="amount_balance" class="form-control autoNum text-right insurance-amount_balance" readOnly value="<?php echo $insurance['balance']; ?>">
                                        <span class="input-group-addon">VND</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Lý do:</label>
                                <div class="col-sm-8">
                                    <textarea name="reason" class="form-control" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="insurance-button text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="color: black; margin-right: 0.4em;">Hủy</button>
                    <button type="submit" class="btn oBtnDetail">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('#insurance-modal .autoNum').autoNumeric('init', numberOptions);

//#region --- KIEM TRA DU LIEU SUBMIT
    function checkSubmitFrmPaid($frm) {
        var isValid = true, error = '';

        var amount_paid = parseInt($($frm + ' .insurance-amount_paid').autoNumeric('get'));
        var amount_balance = parseInt($($frm + ' .insurance-amount_balance').autoNumeric('get'));

        if (amount_paid <= 0) {
            error += "Số tiền thanh toán nhỏ hơn 0.<br>";
            isValid = false;
        }

        if (amount_balance < 0) {
            error += "Số tiền còn nợ nhỏ hơn 0.<br>";
            isValid = false;
        }

        $($frm + ' .insurance-note').html(error);
        $($frm + ' .insurance-note').show();

        return isValid;
    }
//#endregion

//#region --- TINH GIA TRI THANH TOAN BAO HIEM
    function calSumInsurance() {
        var balance = parseInt($('#frm-insurance-paid .insurance-balance').autoNumeric('get'));

        var cal = $('#frm-insurance-paid .insurance-type').find(':selected').data('cal');
        var amount = parseInt($('#frm-insurance-paid .insurance-amount_paid').autoNumeric('get'));

        var update_amount = balance;

        if (cal == '+') {
            update_amount = balance + amount;
        } else if (cal == '-') {
            update_amount = balance - amount;
        }

        $('#frm-insurance-paid .insurance-amount_balance').autoNumeric('set', update_amount);
    }
//#endregion

    $(document).ready(function () {
        $('#frm-insurance-paid .insurance-type').change(function (e) {
            e.preventDefault();
            calSumInsurance();
        });

        $('#frm-insurance-paid .insurance-amount_paid').on('keypress keyup', function (e) {
            e.preventDefault();
            calSumInsurance();
        });

        $('form#frm-insurance-paid').submit(function(e) {
            e.preventDefault();

            if (!checkSubmitFrmPaid('#frm-insurance-paid')) {
                return false;
            }

            $('#frm-insurance-paid .autoNum').each(function(i) {
                var self = $(this);
                try {
                    var v = self.autoNumeric('get');
                    self.autoNumeric('destroy');
                    self.val(v);
                } catch (err) {
                    console.log("Not an autonumeric field: " + self.attr("name"));
                }
            });

            var formData = new FormData($("#frm-insurance-paid")[0]);

            if (!formData.checkValidity || formData.checkValidity()) {
                $('.cal-loading').fadeIn('fast');

                $.ajax({
                    type: "POST",
                    url: "<?php echo CController::createUrl('insuranceDebt/paid')?>",
                    data: formData,
                    dataType: 'json',
                    success: function (dataStr) {
                        $('.cal-loading').fadeOut('fast');

                        if (dataStr.status == 1) {
                            var data = dataStr.data;
                            var pay = parseInt(data.amount) - parseInt(data.balance);

                            $('.insurance-view-' + data.id + ' .insurance-view-amount').text(formatNumber(data.amount));
                            $('.insurance-view-' + data.id + ' .insurance-view-balance').text(formatNumber(data.balance));
                            $('.insurance-view-' + data.id + ' .insurance-view-pay').text(formatNumber(pay));

                            loadInsuranceDetail(data.id);

                            $('#insurance-modal').modal('hide');
                        } else {
                            alert(dataStr['error-message']);
                        }
                        $('.autoNum').autoNumeric('init', numberOptions);
                    },
                    error: function (data) {
                        $('#insurance-modal .autoNum').autoNumeric('init', numberOptions);
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