<div style="padding: 10px">
	<img src="<?php echo Yii::app()->params['url_base_http'] ?>/images/Logo%20NK%202000_color-01.png" style="width: 140px;">
	<div style="padding-left: 15px;">
		<p>Xin chào <?php echo $fullname ?></p>
		<p>Xin vui lòng bấm vào đường dẫn bên dưới để tiến hành các bước phục hồi mật khẩu cho tài khoản của bạn.</p>
		<p>Với mật khẩu mặc định là : <?php echo $password ?></p>
		<a style="text-transform: uppercase;color: #fff;text-decoration:none" target="_blank" href="<?php echo Yii::app()->params['url_base_http'] ?>/home/resetpass/<?php echo $activation; ?>/<?php echo $password; ?>">
			<div style="text-align: center;">
				<span style="padding: 10px 15px;font-size: 12px;background-color: #48b64e;display: inline-block;">Phục hồi Mật khẩu</span>
			</div>
		</a>
		<p>Bạn nhận được email yêu cầu khôi phục mật khẩu do bạn hay một ai đó đã gửi yêu cầu này trên trang NhaKhoa2000, nếu bạn không có thực hiện yêu cầu này, xin vui lòng bỏ qua email này.</p>
		<p>Trân trọng!</p>
		<p>Bộ phận Dịch vụ Khách hàng</p>
		<p>| www.nhakhoa2000.com | Cơ sở 1: (08) 39 255 634 - (08) 39 252 684 | Cơ sở 2: (08) 35 040 421 - (08) 39 570 304</p>
	</div>
	<!--  -->
</div>