<style>
    #oSrchRight .form-group {padding-right: 0.9em;}
    #oSrchRight .form-group.search_date {padding-top: 0.9em;}
</style>

<?php $baseUrl = Yii::app()->baseUrl; ?>

<div id="oSrchBar" class="col-md-12">
    <form class="form-inline">
        <div id="oSrchRight" class="pull-left" style="width: 69%">
            <div class="form-group">
                <label>Thời gian</label>
                <select class="form-control" id="invoice_time">
                    <option value="5">Chọn thời gian</option>
                    <option value="1" selected>Tất cả</option>
                    <option value="2">Hôm nay</option>
                    <option value="3">7 ngày trước</option>
                    <option value="4">Tháng trước</option>
                </select>
            </div>

            <div class="form-group">
                <label>Văn phòng</label>
                <?php echo CHtml::dropDownList('branch', '', $branch, array('class' => 'form-control', 'id' => 'invoice_branch'));  ?>
            </div>

            <div class="form-group">
                <label>Khách hàng</label>
                <select class="form-control" id="invoice_customer"></select>
            </div>

            <div class="form-group">
                <label>Loại</label>
                <select class="form-control" id="invoice_type">
                    <option value="" selected>Tất cả</option>
                    <option value="1">Xác nhận</option>
                    <option value="0">Chưa xác nhận</option>
                </select>
            </div>

            <div class="clearfix"></div>

            <div class="form-group search_date" style="display: none;">
                <label>Bắt đầu</label>
                <input type="text" class="form-control frm-datepicker" id="invoice_start">
            </div>

            <div class="form-group search_date" style="display: none;">
                <label>Kết thúc</label>
                <input type="text" class="form-control frm-datepicker" id="invoice_end">
            </div>
        </div>

        <div id="oSrchLeft" class="pull-right">
            <div class="input-group">
                <input type="text" class="form-control" id="invoice_code" placeholder="Tìm kiếm theo mã hóa đơn">
                <div class="input-group-addon" id="invoice_srch"><span class="glyphicon glyphicon-search"></span></div>
            </div>
        </div>
    </form>
</div>

<div class="col-md-12">
    <div id="InvoiceList"></div>
</div>

<!-- order pay modal -->
<div id="invoice_pay_modal" class="modal fade">

</div>

<!-- confirm_invoice_modal -->
<div id="confirm_invoice_modal" class="modal fade">

</div>

<!-- model send email quotation -->
<div class="modal pop_bookoke" id="mailinfo" role="dialog">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">

            <div class="modal-header popHead">
                <a class="btn_close" data-dismiss="modal" aria-label="Close"></a>
                <h5 id="">THÔNG BÁO</h5>
            </div>
            <div class="modal-body text-center">
                <div id="mail_send"></div>
                <div id="mail_content">
                    <p>Hóa đơn <span class="code_quote"></span> sẽ được gửi đến khách hàng qua địa chỉ email:</p>
                    <div id="code_error" style="color: red; font-style: italic;"></div>
                    <input type="text" class="form-control" name="" id="mail_inpt" placeholder="Nhập địa chỉ email!">
                </div>
                <div class="text-right" style="margin-top: 10px;">
                    <button type="button" id="mailAcpt" class="btn btn_bookoke">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'q_js.php'; ?>