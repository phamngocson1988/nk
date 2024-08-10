<style type="text/css">
.text {
    background: transparent !important;
    border: 0;
    box-shadow: none;
    cursor: default;
    text-align: center;
}
.tableInvoiceDetail thead, .tableInvoiceDetail tfoot, .tableInvoiceDetail tbody {
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
.row1 {width:  25%}
td.row1 {text-align: left;}
.row2 {width:  10%}
.row3 {width:  6%}
.row4 {width:  10%}
.row5 {width:  10%}
.row6 {width:  5%}
</style>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <div class="modal-header sHeader">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h3 class="modal-title">Xoá hóa đơn số <?php echo $invoice['code']; ?></h3>
        </div>

        <form id="formDelInvoice" class="form-horizontal">
            <input type="hidden" name="id_invoice" value="<?php echo $invoice['id'];?>">
            <input type="hidden" name="id_customer" value="<?php echo $invoice['id_customer'];?>">

            <div class="modal-body">
                <table class="table tableInvoiceDetail">
                    <thead>
                        <tr>
                            <th class="row1">Tên DV</th>
                            <th class="row2">Giá</th>
                            <th class="row3">Giảm %</th>
                            <th class="row4">Số lượng</th>
                            <th class="row5">Thành tiền</th>
                            <th class="row6">Xoá</th>
                        </tr>
                    </thead>

                    <tbody class="tbodyListInvoiceDetail">
                        <?php foreach ($listInvoiceDetail as $key => $value) : ?>
                            <?php $id = $value['id']; ?>
                            <tr class="tick" id="item<?php echo $value['id']; ?>">
                                <input name="id_invoice_detail[]" type="hidden" value="<?php echo $value['id'];?>">
                                <input name="id_service[]" type="hidden" value="<?php echo $value['id_service'];?>">
                                <input name="id_user[]" type="hidden" value="<?php echo $value['id_user'];?>">
                                <input name="teeth[]" type="hidden" value="<?php echo $value['teeth'];?>">
                                <input name="unit_price[]" type="hidden" value="<?php echo $value['unit_price'];?>">
                                <input name="percent_decrease[]" type="hidden" value="<?php echo $value['percent_decrease'];?>">
                                <input name="qty[]" type="hidden" value="<?php echo $value['qty'];?>">
                                <input name="amount[]" type="hidden" value="<?php echo $value['amount'];?>">
                                <input name="code_service[]" type="hidden" value="<?php echo $value['code_service'];?>">
                                <input name="services_name[]" type="hidden" value="<?php echo $value['description'];?>">
                                <input name="user_name[]" type="hidden" value="<?php //echo $value['user_name'];?>">

                                <td class="row1"><?php echo $value['description'];?></td>
                                <td class="row2 autoNum" style="text-align: right;"><?php echo $value['unit_price'];?></td>
                                <td class="row3"><?php echo $value['percent_decrease']; ?></td>
                                <td class="row4"><?php echo $value['qty'];?></td>
                                <td class="row5 autoNum" style="text-align: right;"><?php echo $value['amount'];?></td>
                                <td class="row6"><input name="accept_del[]" type="checkbox" class="accept_del" value="<?php echo $value['id'];?>"></td>
                            </tr>
                        <?php  endforeach; ?>
                    </tbody>

                    <tfoot class="tfootListInvoiceDetail">
                        <tr>
                            <td colspan="4" style="vertical-align: middle; text-align: right; width: 82%">Tổng cộng</td>
                            <td colspan="2" ><input name="total" readonly type="text" class="form-control autoNum text" style="text-align: right;" value="<?php echo $invoice->sum_amount;?>"></td>
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

<script type="text/javascript">

var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
$('.autoNum').autoNumeric('init',numberOptions);

$('#formDelInvoice').submit(function(e) {
    e.preventDefault();

    var isCheck = false;
    $.each($('.accept_del'), function () {
        if($(this).is(":checked")){
            isCheck = true;
            return false;
        }
    });
    if (!isCheck) {
        alert("Không có dịch vụ được chọn!");
        return;
    }

    var formData = new FormData($("#formDelInvoice")[0]);

    if (!formData.checkValidity || formData.checkValidity()) {
        jQuery.ajax({
            type    :"POST",
            url     :"<?php echo CController::createUrl('invoices/invoicesDelConfirm')?>",
            data    :formData,
            datatype:'json',
            success:function(data){
                var getData = JSON.parse(data);
                if (getData['status'] == 'successful') {
                    alert("Xoá hoá đơn thành công!");
                    setTimeout(function(){location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSales/invoices/View?id='+getData['id_invoice']; }, 500);
                } else {
                    alert(getData['error-message']);
                }
            },
            error: function(data) {
                alert("Error occured. Please try again!");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    return false;
});

</script>