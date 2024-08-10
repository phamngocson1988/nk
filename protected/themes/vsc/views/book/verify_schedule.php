<style>
#cus table th, #cus table td{font-size: 14px; border: 0;}
#cus table th {width: 7%; text-align: right;}
</style>
<?php $baseUrl = Yii::app()->getBaseUrl();
 ?>

<div  class="container" id="bk_step">
	<div class="row">
		<div class="col-sm-12">
			<div class="row" id="bk_st_tt">
				<h3>ĐẶT LỊCH KHÁM</h3>
				<div id="bk_action">
					<ul class="list-inline">
						<li class="bk_fn"><a href="<?php echo $baseUrl; ?>/index.php/book/">1. ĐẶT LỊCH HẸN</a></li>
						<li class="bk_fn"><a href="<?php echo $baseUrl; ?>/index.php/book/register_info">2. ĐĂNG KÝ THÔNG TIN</a></li>
						<li class="bk_fn"><a href="<?php echo $baseUrl; ?>/index.php/book/verify_schedule">3. XÁC NHẬN LỊCH HẸN</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="bk_step_num">
		3
</div>
<div  class="container" id="bk_info">
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-md-6 col-md-offset-4">
					<div id="cus"></div>
				</div>
				<div class="col-md-12">
					<div class="col-md-4" id="bk_cf">
						<img src="<?php echo Yii::app()->params['image_url']; ?>/images/xac-nhan.png" alt="">
					</div>
					<div class="col-md-5" id="bk_code">
						<div class="col-md-12">
							<div class="bk_ver_ali">
								<p>Chúng tôi đã gửi tin nhắn, vui lòng kiểm tra tin nhắn!</p>
							</div>
							<div class="bk_ver_ali">
								<input type="text" name="chk_code" id="chk_code" value="" placeholder="Nhập mã xác nhận tại đây" class="form-control">
							</div>
							<form action="" method="get" accept-charset="utf-8" class="form-inline">
								<div class="form-group">
									<label>Nhận mã code bằng:</label>
									<label class="radio-inline"><input type="radio" name="send_code" checked="">Tin nhắn</label>
									<label class="radio-inline"><input type="radio" name="send_code">Cuộc gọi thoại</label>
								</div>
								<div class="bk_ver_ali">
									<button type="button" class="btn btn_black btn-block" id="btn_send">GỬI LẠI TIN NHẮN</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-10 col-md-offset-1" id="bk_confirm">
					<div class="col-md-12 text-center" style="padding: 10px;">
						<b>Quý khách có muốn: </b>
					</div>
					<div class="col-md-6">
						<p><b>Nhận thông tin lịch hẹn qua:</b></p>
						<select name="" class="form-control" style="width: 70%;">
							<option value="">Không nhận</option>
							<option value="">Qua email đã đăng ký</option>
							<option value="">Qua điện thoại đã đăng ký</option>
						</select>
						<h6><i>Dịch vụ không bắt buộcc, quý khách có thể chọn "Không nhận"</i></h6>
					</div>
					<div class="col-md-6">
						<p><b>Nhắc nhở lịch hẹn cho bệnh nhân:</b></p>
						<select name="" class="form-control" style="width: 70%;">
							<option value="">Không nhắc nhở</option>
							<option value="">Nhắc nhở trước một giờ</option>
							<option value="">Nhắc nhở trước một ngày</option>
							<option value="">Nhắc nhở trước hai ngày</option>
						</select>
						<h6><i>Dịch vụ không bắt buộcc, quý khách có thể chọn "Không nhắc nhở"</i></h6>
					</div>
				</div>
				
				<div class="col-md-12">
					<a href="#" id="anext" class="btn btn_blue pull-right">HOÀN TẤT</a>
				</div>
			</div>
		</div>
	</div>
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
$(window).load(function () {
	$('body').delay(100) //wait 5 seconds
	    .animate({
	        'scrollTop': $('#bk_st_tt').offset().top
	    });
});

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
	
	$('#btn_send').click(function(e){
		e.preventDefault();
			send++;

			sendAgain(send);
	})
})

function checkcode(code_cus) {
	$.ajax({
		dataType 	: 'json',
		url 		: '<?php echo CController::createUrl('book/checkCode'); ?>',
		type 		: 'post',
		data 		: {
			code_confirm_cus		: 		code_cus,
		},
		success 	: function(data) {
			var message = 'Lỗi không xác định!';
			
			if(data.st == 1) {
				message = 'Cảm ơn quý khách đã đặt lịch hẹn tại Nha Khoa 2000!';
				dt = data.dt;
				getNoti(dt.id, 'add', dt.id_author, dt.id_dentist);
			}
			else if (data == 0) {
				message = 'Nhập sai mã xác nhận. Xin vui lòng nhập lại!';
				$('#chk_code').val('');
			}
			else {
				message = 'Có lỗi xảy ra! Xin vui lòng thử lại sau!';
			}

			$('#noti_mess').html(message);
			$('#notify_modal').modal('show');
			$('#noti_cf').click(function(){
				if(data.st == 1)
					location.href = '<?php echo $baseUrl; ?>/book';
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

function getNoti(id_schedule, action, author, id_dentist) {
    $.ajax({
		url     : '<?php echo CController::createUrl('book/getNoti'); ?>',
		type    : "post",
		dataType: 'json',
		data    : {
			id_schedule: id_schedule,
			action     : action,
			id_author  : author,
			id_dentist :id_dentist,
		}
    })
}

</script>