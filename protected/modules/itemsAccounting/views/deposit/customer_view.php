<style>
    .form-inline .form-group {padding-right: 2em;}
    .form-inline .form-group label {padding-right: 0.4em;}

    #deposit-list {padding-top: 1.5em;}
    #deposit-list td {vertical-align: middle !important;}
</style>

<?php $baseUrl = Yii::app()->baseUrl; ?>

<input type="hidden" class="baseUrl" value="<?php echo $baseUrl; ?>">

<div class="col-md-12" style="position: relative; margin-top: 1em;">
    <input type="hidden" class="deposit-id_customer" value="<?php echo $id_customer; ?>">
    <div class="form-inline">
        <div class="form-group">
            <label>Thời gian</label>
            <select class="form-control" id="deposit-time">
                <option value="5">Chọn thời gian</option>
                <option value="1" selected>Tất cả</option>
                <option value="2">Hôm nay</option>
                <option value="3">7 ngày trước</option>
                <option value="4">Tháng trước</option>
            </select>
        </div>

        <div class="form-group search_date" style="display: none;">
            <label>Bắt đầu</label>
            <input type="text" class="form-control frm-datepicker" id="deposit-start">
        </div>

        <div class="form-group search_date" style="display: none;">
            <label>Kết thúc</label>
            <input type="text" class="form-control frm-datepicker" id="deposit-end">
        </div>

        <div class="form-group">
            <label>Mã hóa đơn</label>
            <input type="text" class="form-control" id="deposit-code_invoice" placeholder="Mã hóa đơn">
        </div>
    </div>

    <a style="position: absolute; top: 0px; right: 45px;" class="btn_plus deposit-update_layout"></a>
</div>

<div class="col-md-12">
    <div id="deposit-list" class="row"></div>
</div>

<div id="deposit-modal" class="modal"></div>

<?php include 'customer_view_js.php'; ?>