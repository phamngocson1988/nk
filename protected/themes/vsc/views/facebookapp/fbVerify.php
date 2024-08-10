<?php include 'fb_app_css.php'; ?>
<style>
#cus table th, #cus table td{font-size: 14px; border: 0;}
#cus table th {width: 7%; text-align: right;}
</style>
<?php 	$baseUrl = Yii::app()->getBaseUrl();
		$session = Yii::app()->session;
		$sms = $session['sms'];
 ?>

 <div class="col-xs-12 fb_book" id="bk_st_tt">
	<h4>XÁC NHẬN LỊCH HẸN</h4>
</div>

<div class="col-xs-10 col-xs-offset-1 fb_book" id="fb_book_verify">
	<div class="col-xs-3" id="bk_cf">
		<img src="<?php echo Yii::app()->params['image_url']; ?>/images/xac-nhan.png" alt="">
	</div>
	<div class="col-xs-8">
		<div class="form-group">
			<p> Chúng tôi đã gửi tin nhắn, vui lòng kiểm tra tin nhắn! </p>
			<input type="text" name="chk_code" id="chk_code" value="" placeholder="Nhập mã xác nhận tại đây" class="form-control">
		</div>

		<div class="form-group">
			<label>Gửi lại mã xác nhận bằng:</label>
			<label class="radio-inline"><input type="radio" name="send_code" checked="">Tin nhắn</label>
			<label class="radio-inline"><input type="radio" name="send_code">Cuộc gọi thoại</label>
			<button type="button" class="btn btn_black btn-block" id="send_again">GỬI LẠI TIN NHẮN</button>
		</div>
	</div>
</div>

<div class="col-xs-12 fb_book">
	<div class="panel panel-success">
	  	<div class="panel-heading"><b>Quý khách có muốn: </b></div>
	  	<div class="panel-body">
	  		<div class="col-xs-6">
				<p>Nhận thông tin lịch hẹn qua:</p>
				<select name="" class="form-control" style="width: 70%;">
					<option value="">Không nhận</option>
					<option value="">Qua email đã đăng ký</option>
					<option value="">Qua điện thoại đã đăng ký</option>
				</select>
			</div>

			<div  class="col-xs-6">
				<p>Nhắc nhở lịch hẹn cho bệnh nhân:</p>
				<select name="" class="form-control" style="width: 70%;">
					<option value="">Không nhắc nhở</option>
					<option value="">Nhắc nhở trước một giờ</option>
					<option value="">Nhắc nhở trước một ngày</option>
					<option value="">Nhắc nhở trước hai ngày</option>
				</select>
			</div>
			<div class="col-xs-12 text-center" style="margin-top: 10px;">
				<i>Dịch vụ không bắt buộc, quý khách có thể chọn "Không nhắc nhở"</i>
			</div>
	  	</div>
	</div>
</div>

<div class="col-xs-12 fb_book">
	<a href="#" id="anext" class="btn btn_blue pull-right">HOÀN TẤT</a>
</div>


<!-- modal -->
<div id="notify_modal" class="modal fade">
	<div class="modal-dialog" style="margin-top: 18%;">
   		<div class="modal-content">
   			<div class="modal-header">
   				Thông báo
   				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   			</div>
   			<div class="modal-body">
   				<div id="noti_mess"></div>
   			</div>
   			<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
		        <button type="button" class="btn btn-primary" id="noti_cf">Xác nhận</button>
		    </div>
    	</div>
    </div>
</div>


<script>
$(function(){
	$('#anext').click(function(e){
		e.preventDefault();

		var chk_code = $('#chk_code').val();

		if(chk_code)
			checkcode(chk_code);

		else{
			$('#noti_mess').html('Mã xác nhận không được để trống!');
			$('#notify_modal').modal('show');

			$('#noti_cf').click(function(){
				$('#notify_modal').modal('hide');
			})
		}

	})

	var send = 1;
	
	$('#send_again').click(function(e){
		e.preventDefault();
			send++;

			sendAgain(send);
	})
})

function checkcode(code_cus) {
	$.ajax({
		dateType 	: 'json',
		url 		: '<?php echo CController::createUrl('facebookapp/checkCode'); ?>',
		type 		: 'post',
		data 		: {
			code_confirm_cus		: 		code_cus,
		},
		success 	: function(data) {

			var message = 'Lỗi không xác định!';

			if(data == 1) {
				message = 'Cảm ơn quý khách đã đặt lịch hẹn tại Nha Khoa 2000!';
			}
			else if (data == -1) {
				message = 'Nhập sai mã xác nhận. Xin vui lòng nhập lại!';
				$('#chk_code').val('');
			}
			else {
				message = 'Đặt lịch thất bại!';
			}

			$('#noti_mess').html(message);
			$('#notify_modal').modal('show');

			$('#noti_cf').click(function(){
				if(data == 1)
					location.href = '<?php echo $baseUrl; ?>/facebookapp/index';
				else
					$('#notify_modal').modal('hide');
			})
		}
	})
}
function sendAgain(send) {
	$.ajax({
		dateType 	: 'json',
		url 		: '<?php echo CController::createUrl('book/sendAgain'); ?>',
		type 		: 'post',
		data 		: {
			send 	: send
		},
		success 	: function(data) {
			var message = 'Lỗi không xác định!';
			if(data > 6) {
				message = 'Nha Khoa 2000 đã gửi lại mã xác nhận đến điện thoại của quý khách!';
			}
			else if(data == -2) {
				message = 'Đã gửi tin nhắn thứ 3!';
			}
			else {
				message = 'Không thể gửi tin nhắn!';
				$('#chk_code').val('');
			}
			
			$('#noti_mess').html(message);
			$('#notify_modal').modal('show');

			$('#noti_cf').click(function(){
				$('#notify_modal').modal('hide');
			})
			
		}
	})
}
</script>