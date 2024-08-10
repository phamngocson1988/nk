<style>
    .insurance-popup input:disabled,
    .insurance-popup input:read-only {
        background: transparent;
        border: none;
        box-shadow: none;
    }

    .insurance-popup .insurance-info .form-group {
        margin-bottom: 0.1em;
    }

    .insurance-popup input:disabled:hover,
    .insurance-popup input:read-only:hover {
        cursor: default;
    }

    .insurance-popup input:read-only:focus,
    .insurance-popup input:disabled:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .insurance-popup .isRead * {
        background: transparent;
        border: none;
        box-shadow: none;
    }
</style>

<div class="modal-dialog modal-lg pop_bookoke insurance-popup">
    <div class="modal-content">
        <div class="modal-header sHeader">
            <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h3 id="modalTitle" class="modal-title">Tạo mới công nợ BH</h3>
        </div>

        <div class="modal-body">
            <form id="frm-insurance-create">
                <div class="col-sm-12 insurance-handle" style="margin-top: 0.8em; margin-bottom: 2em;">
                    <div class="form-horizontal">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-5">Đối tác<span class="text-danger">*</span>:</label>
                                <div class="col-sm-7">
                                    <select class="form-control insurance-id_partner-list" name="id_partner" required></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Khách hàng<span class="text-danger">*</span>:</label>
                                <div class="col-sm-7">
                                    <select class="form-control insurance-id_customer-list" name="id_customer" required></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Nguồn<span class="text-danger">*</span>:</label>
                                <div class="col-sm-7">
                                    <select class="form-control insurance-type" name="source" required>
                                        <?php foreach (Insurance::$_typeInsurance as $value) : ?>
                                            <option value='<?php echo $value; ?>'><?php echo Insurance::$_type[$value]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group insurance-code_invoice-div" style="display: none;" >
                                <label class="control-label col-sm-5">Mã hóa đơn<span class="text-danger">*</span>:</label>
                                <div class="col-sm-7">
                                    <input type="text" name="code_invoice" class="form-control insurance-code_invoice">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Bảo hiểm bảo lãnh<span class="text-danger">*</span>:</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" name="amount" class="form-control autoNum text-right insurance-amount" value="0" required>
                                        <span class="input-group-addon">VND</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-5">Chi nhánh<span class="text-danger">*</span>:</label>
                                <div class="col-sm-7">
                                    <?php echo CHtml::dropDownList('id_branch', Yii::app()->user->getState('branch_id'), $branch, array('class' => 'form-control', 'id' => 'insurance-id_branch'));  ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Ngày thực hiện</label>
                                <div class="col-sm-7">
                                    <input type="text" name="create_date" class="form-control" value="<?php echo date_format(date_create(), 'H:i d/m/Y') ?>" readOnly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-5">Ghi chú:</label>
                                <div class="col-sm-7">
                                    <textarea name="note" class="form-control" rows="6" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="insurance-info" style="color: red; font-style: italic; padding-left: 15em;"></div>
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
    var numberOptions = { aSep: '.', aDec: ',', mDec: 3, aPad: false };

    //#region --- XAC THUC DU LIEU
    function validFrom(frm) {
        var error = '';

        var id_partner = $(frm + ' .insurance-id_partner-list').val();
        if (!id_partner) {
            error += 'Đối tác không được để trống! <br>';
        }

        var id_customer = $(frm + ' .insurance-id_customer-list').val();
        if (!id_customer) {
            error += 'Khách hàng không được để trống! <br>';
        }

        var type = $(frm + ' .insurance-type').val();
        if (!type) {
            error += 'Nguồn không được để trống! <br>';
        }

        var code_invoice = $(frm + ' .insurance-code_invoice').val();
        if (type == 1 && !code_invoice) {
            error += 'Mã hóa đơn không được để trống khi chọn nguồn hóa đơn! <br>';
        }

        var amount = $(frm + ' .insurance-amount').autoNumeric('get');
        if (amount <= 0) {
            error += 'Bảo hiểm bảo lãnh không được nhỏ hơn 0! <br>';
        }

        return error;
    }
    //#endregion

    //#region --- TINH GIA TRI TONG CONG BAO HIEM
    function calSumInsurance() {
        var sum_amont = parseInt($('#frm-insurance-create .insurance-amount').autoNumeric('get'));

        var cal = $('#frm-insurance-create .insurance-type').find(':selected').data('cal');
        var amount = parseInt($('#frm-insurance-create .insurance-amount_change').autoNumeric('get'));

        var update_amount = sum_amont

        if (cal == '+') {
            update_amount = sum_amont + amount;
        } else if (cal == '-') {
            update_amount = sum_amont - amount;
        }

        $('#frm-insurance-create .insurance-amount_update').autoNumeric('set', update_amount);
    }
    //#endregion

    $(document).ready(function() {
        $('.autoNum').autoNumeric('init', numberOptions);

        $('#frm-insurance-create .insurance-type').change(function(e) {
            e.preventDefault();
            var type = $(this).val();

            if (type == 1) {
                $('.insurance-code_invoice-div').show();
            } else {
                $('.insurance-code_invoice-div').hide();
            }
        });

        $('form#frm-insurance-create').submit(function(e) {
            e.preventDefault();

            var error = validFrom('form#frm-insurance-create');
            if (error) {
                $('form#frm-insurance-create .insurance-info').html(error);
                return false;
            } else {
                $('form#frm-insurance-create .insurance-info').html('');
            }

            $('#frm-insurance-create .autoNum').each(function(i) {
                var self = $(this);
                try {
                    var v = self.autoNumeric('get');
                    self.autoNumeric('destroy');
                    self.val(v);
                } catch (err) {
                    console.log("Not an autonumeric field: " + self.attr("name"));
                }
            });

            var formData = new FormData($("#frm-insurance-create")[0]);

            if (!formData.checkValidity || formData.checkValidity()) {
                $('.cal-loading').fadeIn('fast');

                $.ajax({
                    type: "POST",
                    url: "<?php echo CController::createUrl('insuranceDebt/create') ?>",
                    data: formData,
                    dataType: 'json',
                    success: function(dataStr) {
                        $('.cal-loading').fadeOut('fast');

                        if (dataStr.status == 1) {
                            location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSales/insuranceDebt/index?code=' + dataStr.code;
                        } else {
                            alert(dataStr['error-message']);
                        }
                        $('.autoNum').autoNumeric('init', numberOptions);
                    },
                    error: function(data) {
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