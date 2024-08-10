<style>
    .form-inline .form-group {padding-right: 2em;}
    .form-inline .form-group label {padding-right: 0.4em;}

    #blood_test-list {padding-top: 1.5em;}
    #blood_test-list td {vertical-align: middle !important;}
</style>

<?php $baseUrl = Yii::app()->baseUrl; ?>

<input type="hidden" class="baseUrl" value="<?php echo $baseUrl; ?>">

<div class="col-md-12" style="position: relative; margin-top: 1em;">
    <input type="hidden" class="blood_test-id_customer" value="<?php echo $id_customer; ?>">
    <div class="form-inline">
        <div class="form-group">
            <label>Thời gian</label>
            <select class="form-control" id="blood_test-time">
                <option value="5">Chọn thời gian</option>
                <option value="1" selected>Tất cả</option>
                <option value="2">Hôm nay</option>
                <option value="3">7 ngày trước</option>
                <option value="4">Tháng trước</option>
            </select>
        </div>

        <div class="form-group search_date" style="display: none;">
            <label>Bắt đầu</label>
            <input type="text" class="form-control frm-datepicker" id="blood_test-start">
        </div>

        <div class="form-group search_date" style="display: none;">
            <label>Kết thúc</label>
            <input type="text" class="form-control frm-datepicker" id="blood_test-end">
        </div>
    </div>

    <a style="position: absolute; top: 0px; right: 45px;" class="btn_plus blood_test-update_layout"></a>
</div>

<div class="col-md-12">
    <div id="blood_test-list" class="row"></div>
</div>

<div id="blood_test-modal" class="modal"></div>

<?php include 'customer_view_js.php'; ?>