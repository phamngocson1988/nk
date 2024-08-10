<?php $baseUrl = Yii::app()->getBaseUrl(); ?>
<?php $this->renderPartial('calendar_css'); ?>

<?php $val = '';
      $chair = '<option value="2">Ghế khám</option>';
      $disabled = '';
if($role == 0){
  $val = '<option value="'.$id_user.'">'.$name_user.'</option>';
  $chair = '';
  $disabled = 'disabled';
} 

for ($i=0; $i < 90 ; $i+=5) { 
    $time_range[$i] = $i;
}
$time_range[0] = 'N/A';
?>

<input type="hidden" id="idUserLog" value="<?php echo Yii::app()->user->getState('user_id'); ?>">
<input type="hidden" id="codeNumberExp" value="<?php echo $codeNumberExp; ?>">

<div class="col-md-4 side-left padding-0" style="z-index: 11;">
	<div class="col-md-5 padding-0">
		<select name="" id="at_srch" class="form-control search" <?php echo $disabled; ?>>
    <?php echo $val; ?>
		</select>
	</div>

	<div class="col-md-3 padding-left-0">
		<select name="sr_val" id="sr_val" class="form-control">
			<?php echo $chair; ?>
      <option value="1">Nha sỹ</option>
		</select>
	</div>
    <div class="col-md-4 padding-0">
    <?php echo CHtml::dropDownList('id_branch','',$branch, array('class'=>'form-control',$disabled=>$disabled)); ?>
    </div>
</div>

<!-- tạo lịch hẹn -->
<?php include 'create_event.php'; ?>

	<!-- calendar -->
<div id="calendar"></div>
</div>

	<!-- update schedule -->
<?php include 'update_event.php'; ?>
  <!-- send_sms -->
<?php include 'send_sms.php'; ?>

	<!-- quotation -->
<div id="quote_modal" class="modal fade">
</div>

  <!-- order -->
<div id="order_modal" class="modal fade">
</div>

<!-- pop up information -->
<div class="modal" id="info" role="dialog" style="padding-top: 60px;">
    <div class="modal-dialog">
  
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header sHeader">
                <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3 id="info_head" class="modal-title">Thông báo</h3>
            </div>

            <div class="modal-body">
                <p id="info_content">Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    
    </div>
</div>

<!-- pop up confirm -->
<div class="modal" id="confirm" role="dialog" style="padding-top: 60px;">
    <div class="modal-dialog">
  
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="cf_head">Thông báo</h3>
            </div>
            <div class="modal-body">
                <p id="cf_content">Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn_close" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-default cf_submit">Đồng ý</button>
            </div>
        </div>
    
    </div>
</div>

<!-- pop up add code number -->
<div class="modal" id="upCode" role="dialog" style="padding-top: 60px;">
    <div class="modal-dialog" style="width: 30%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="cf_head">Thông báo</h3>
            </div>
            <div class="modal-body" style="padding-bottom: 0">
                <p id="cf_content">Nhập mã khách hàng.</p>
                <div class="form-group">
                  <div class="Customer_up_code_number_remain" data-toggle="tooltip" data-placement="right" title="" data-original-title="">
                    <input placeholder="Mã khách hàng" class="form-control" id="updateCodeNumber" type="number" value="" />
                    <input id="Customer_info_id" type="hidden" value="" />
                    <input id="updateCodeNumberRe" type="hidden" value="" />
                  </div>
                </div>
                <div class="error text-center"></div>
                <div class="Customer_info" style="display:none;">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Họ tên</td>
                        <td id="Customer_info_fullname"></td>
                      </tr>
                      <tr>
                        <td>Ngày sinh</td>
                        <td id="Customer_info_birthdate"></td>
                      </tr>
                      <tr>
                        <td>SĐT</td>
                        <td id="Customer_info_phone"></td>
                      </tr>
                      <tr>
                        <td>Địa chỉ</td>
                        <td id="Customer_info_address"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
            <div class="modal-footer" style="padding: 8px;">
                <button type="button" class="btn btn-default btn_close" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-default btnUpCode">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

	<!-- notify -->
<div id="noti_modal" class="modal noti" style="padding-top: 60px;">
	<div class="modal-dialog modal-sm">
  		<div class="modal-content">

          <div class="modal-header sHeader">
              <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h3 id="modalTitle" class="modal-title">THÔNG BÁO </h3>
          </div>


      		<div class="body">
	  			<input type="hidden" name="" value="" class="chkT" id="noti_chkT">
	  			<input type="hidden" name="" value="" class="chkSch" id="noti_chkSch">
        		<div class="alert alert-warning">
        			<div class="error_mes"></div>
        		</div>
        		<div class="alert alert-success" style="display: none;">
        			<div class="success_mes"></div>
        		</div>
      		</div>
      		<div class="modal-footer" id="noti_submit" style="display: none;">
        		<button type="button" class="btn btn-default btn_close" data-dismiss="modal">Hủy</button>
        		<button type="button" class="btn btn_book" id='btn_noti' data-dismiss="modal">Xác nhận</button>
      		</div>
      		<div class="modal-footer" id="noti_foot">
        		<button type="button" class="btn btn_book btn_close" data-dismiss="modal">Đóng</button>
      		</div>
  		</div>
  	</div>
</div>

<?php include 'calendar_js.php'; ?>