<style>
    .blood_test-modal input:disabled, .blood_test-modal input:read-only {
        background: transparent; border: none; box-shadow: none;
    }

    .blood_test-modal .blood_test-info .form-group {margin-bottom: 0.1em;}

    .blood_test-modal input:disabled:hover, .blood_test-modal input:read-only:hover {
        cursor: default;
    }

    .blood_test-modal input:read-only:focus, .blood_test-modal input:disabled:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .blood_test-modal .isRead * { background: transparent; border: none; box-shadow: none; }
</style>

<div class="modal-dialog modal-lg pop_bookoke blood_test-modal" style="width: 40%;">
    <div class="modal-content">
        <div class="modal-header sHeader">
            <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h3 id="modalTitle" class="modal-title">Phiếu thu / trả Xét nghiệm máu</h3>
        </div>

        <div class="modal-body">
            <form id="frm-blood_test-update">
                <input type="hidden" name="id_customer" class="blood_test-id_customer" value="<?php echo $customer['id_customer']; ?>">

                <div class="col-sm-12 blood_test-note" style="color: red; font-size: 0.85em; display: none;"></div>

                <div class="col-sm-12 blood_test-handle" style="margin-top: 0.5em; margin-bottom: 1em;">
                    <div class="form-horizontal">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-5">Khách hàng:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" readOnly value="<?php echo $customer['fullname']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Hình thức:</label>
                                <div class="col-sm-7">
                                    <select class="form-control blood_test-type" name="type" required>
                                        <option value=''>Chọn hình thức</option>
                                        <?php foreach (BloodTest::$_typeBloodTest as $value): ?>
                                            <option data-cal="<?php echo BloodTest::$_type[$value]['calculation']; ?>" value='<?php echo $value; ?>'><?php echo BloodTest::$_type[$value]['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Số tiền<span class="text-danger">*</span>:</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" name="amount_update" class="form-control autoNum text-right blood_test-amount_update" value="0">
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

                <div class="blood_test-button text-right">
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

        var amount_update = parseInt($($frm + ' .blood_test-amount_update').autoNumeric('get'));

        if (amount_update <= 0) {
            error += "Chi phí xét nghiệm nhỏ hơn 0.<br>";
            isValid = false;
        }

        $($frm + ' .blood_test-note').html(error);
        $($frm + ' .blood_test-note').show();

        return isValid;
    }
//#endregion

    $(document).ready(function () {
        $('form#frm-blood_test-update').submit(function(e) {
            e.preventDefault();

            if (!checkSubmitFrmPaid('#frm-blood_test-update')) {
                return false;
            }

            $('#frm-blood_test-update .autoNum').each(function(i) {
                var self = $(this);
                try {
                    var v = self.autoNumeric('get');
                    self.autoNumeric('destroy');
                    self.val(v);
                } catch (err) {
                    console.log("Not an autonumeric field: " + self.attr("name"));
                }
            });

            var formData = new FormData($("#frm-blood_test-update")[0]);

            if (!formData.checkValidity || formData.checkValidity()) {
                $('.cal-loading').fadeIn('fast');

                $.ajax({
                    type: "POST",
                    url: "<?php echo CController::createUrl('bloodTest/add')?>",
                    data: formData,
                    dataType: 'json',
                    success: function (dataStr) {
                        $('.cal-loading').fadeOut('fast');

                        if (dataStr.status == 1) {
                            $('#blood_test-modal').modal('hide');

                            var data = dataStr.data;

                            $('#blood_test-list .tableList tbody').prepend(`
                                <tr>
                                    <td>${moment(data.create_date).format('HH:mm DD/MM/YYYY')}</td>
                                    <td>${data.user_name}</td>
                                    <td>${data.type_name}</td>
                                    <td>${formatNumber(data.amount)}</td>
                                    <td>${data.note}</td>
                                    <td>
                                        <a href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsAccounting//bloodTest/print?id=${data.id}&amp;idc=${data.id_customer}&amp;lang=vi" target="_blank" title="" class="label label-success">In-vi</a>
                                        <a href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsAccounting//bloodTest/print?id=${data.id}&amp;idc=${data.id_customer}&amp;lang=en" target="_blank" title="" class="label label-success">In-en</a>
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