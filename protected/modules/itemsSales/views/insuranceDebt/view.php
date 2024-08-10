<style>
    .form-inline .form-group {padding-right: 2em;}
    .form-inline .form-group label {padding-right: 0.4em;}
    .form-inline .form-group.search_date {padding-top: 0.9em;}

    #insurance-list td {vertical-align: middle !important;}
</style>

<?php $baseUrl = Yii::app()->baseUrl; ?>

<input type="hidden" class="baseUrl" value="<?php echo $baseUrl; ?>">

<div id="oSrchBar" class="col-md-12" style="position: relative;">
    <div class="form-inline">
        <input type="hidden" class="insurance-code-url" value="<?php echo $code; ?>">
        <div class="form-group">
            <label>Thời gian</label>
            <select class="form-control" id="insurance-time">
                <option value="5">Chọn thời gian</option>
                <option value="1" selected>Tất cả</option>
                <option value="2">Hôm nay</option>
                <option value="3">7 ngày trước</option>
                <option value="4">Tháng trước</option>
            </select>
        </div>

        <div class="form-group">
            <label>Văn phòng</label>
            <?php echo CHtml::dropDownList('branch', Yii::app()->user->getState('branch_id'), $branch, array('class' => 'form-control', 'id' => 'insurance-id_branch'));  ?>
        </div>

        <div class="form-group">
            <label>Khách hàng</label>
            <select class="form-control insurance-id_customer-list" id="insurance-id_customer"></select>
        </div>

        <div class="form-group">
            <label>Đối tác</label>
            <select class="form-control insurance-id_partner-list" id="insurance-id_partner"></select>
        </div>

        <div class="form-group">
            <label>Mã hóa đơn</label>
            <input type="text" class="form-control" id="insurance-code_invoice" placeholder="Mã hóa đơn">
        </div>

        <div class="clearfix"></div>

        <div class="form-group search_date" style="display: none;">
            <label>Bắt đầu</label>
            <input type="text" class="form-control frm-datepicker" id="insurance-start">
        </div>

        <div class="form-group search_date" style="display: none;">
            <label>Kết thúc</label>
            <input type="text" class="form-control frm-datepicker" id="insurance-end">
        </div>
    </div>

    <a style="position: absolute; top: 18px; right: 45px;" class="btn oBtnAdd btn_plus" data-toggle="modal" data-target="#insurance-create"></a>
</div>

<div class="col-md-12">
    <div id="insurance-list"></div>
</div>

<div id="insurance-create" class="modal fade">
    <?php include 'create.php'; ?>
</div>

<div id="insurance-modal" class="modal fade"></div>

<?php include '_js.php'; ?>