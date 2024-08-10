<div class='col-md-12' style='padding-top:4%'>
	<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
		'id' => 'updateSettingSms',
		'enableClientValidation' => true,
		'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => "form-horizontal"),
	)); ?>

	<div class="col-xs-12 col-lg-8" style="border-right: 2px dashed #ccc;">
		<input type='hidden' class="setting-id" name='id' value='<?php echo $smsSetting->id; ?>' />
		<div class="form-group">
			<label class="control-label col-sm-3">Hình thức:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" value='<?php echo SettingSms::$_TYPE_NAME[$smsSetting->type]; ?>' readonly />
				<input type="hidden" name="type" class="form-control setting-type" value='<?php echo $smsSetting->type; ?>'>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-3">Tên:</label>
			<div class="col-sm-8">
				<input type="text" name="name" class="form-control setting-name" placeholder="Tên thiết lập SMS" value='<?php echo $smsSetting->name; ?>' required>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-3">Nội dung tin nhắn:</label>
			<div class="col-sm-8">
				<textarea id="sms-content" class="form-control setting-content" name="content" cols="30" rows="7" required><?php echo $smsSetting->content; ?></textarea>
			</div>

			<?php $char = 160; ?>
			<?php $contentLength = strlen($smsSetting->content); ?>
			<?php $num = ceil($contentLength/$char) || 1; ?>

			<input type="hidden" class="sms-char" value="<?php echo $char; ?>">
			<div class="col-sm-offset-3 col-sm-8"> Tin <span class="sms-num"><?php echo $num; ?></span> - Còn <span class="sms-remain"><?php echo $char*$num - $contentLength; ?></span> ký tự</div>
			<div class="col-sm-offset-3 col-sm-8" style="color: red;"><i> Tin nhắn không hỗ trợ tiếng Việt có dấu! </i></div>
		</div>

		<div class="form-group">
			<?php $times = ($smsSetting->time_start) ? date_create($smsSetting->time_start) : date_create('00:00:00'); ?>
			<label class="control-label col-sm-3">Thời gian bắt đầu</label>
			<div class="col-xs-3 col-md-2" style="padding-right: 0;">
				<select class="form-control setting-hours" name="hours">
					<?php for ($i=0; $i <= 23; $i++) {
						$selected = ($i == (int)date_format($times, 'H')) ? 'selected' : '';
						echo "<option value='$i' $selected>".sprintf("%02d", $i)."</option>";
					} ?>
				</select>
			</div>

			<div class="col-xs-2 col-md-1" style="line-height: 30px; font-size: 2em; vertical-align: middle; font-weight: bold; text-align: center;"> : </div>

			<div class="col-xs-3 col-md-2" style="padding-left: 0;">
				<select class="form-control setting-minutes" name="minutes">
					<?php for ($i=0; $i <= 59; $i+=5) {
						$selectedI = ($i == (int)date_format($times, 'i')) ? 'selected' : '';
						echo "<option value='$i' $selectedI>".sprintf("%02d", $i)."</option>";
					} ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-3">Kích hoạt</label>
			<div class="col-sm-8">
				<div id="slider" onclick="activeSetting()" class="slider_holder staffhours sliderdone">
					<input class="sms-active setting-active" name="active" type="hidden" value="<?php echo $smsSetting->active; ?>">
					<span class="slider_off sliders <?php if ($smsSetting->active == 0) echo "Off"; ?>"> TẮT </span>
					<span class="slider_on sliders <?php if ($smsSetting->active == 0) echo "On"; ?>"> BẬT </span>
					<span class="slider_switch <?php if ($smsSetting->active == 0) echo "Switch"; ?>"></span>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-11" style='text-align: right;'>
				<button type="submit" class="btn btn-primary">Cập nhật</button>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-lg-4" style="display: none;">
		<div><b>Ghi chú:</b></div>
	</div>

	<?php $this->endWidget(); ?>
</div>

<script>
	var baseUrl = $('#baseUrl').val() + '/itemsSetting/settingSms/';

	function activeSetting() {
        var $id = "#slider";

        $($id + " .slider_on").toggleClass("On");
        $($id + " .slider_off").toggleClass("Off");
        $($id + " .slider_switch").toggleClass("Switch");

        if ($('.sms-active').val() == 0) {
            $('.sms-active').val(1);
        } else {
            $('.sms-active').val(0);
        }
    }

	$(document).ready(function() {
		$('#sms-content').on('keypress keydown input', function(e){
			var text = $(this).val();
			var length = text.length;
			var maxSms = $('.sms-char').val();

			var num = Math.ceil(length/maxSms);
			var remain = maxSms*num - length;

			$('.sms-num').text(num);
			$('.sms-remain').text(remain);
		});

		$('#updateSettingSms').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($("#updateSettingSms")[0]);

			if (!formData.checkValidity || formData.checkValidity()) {
				jQuery.ajax({
					type: "POST",
					url: baseUrl + 'update',
					data: formData,
					dataType: 'json',
					success: function(data) {
						if (data.status == 1) {
							$('#alert-success').append('<div class = "alert alert-success" id="success-alert"><a href = "#" class = "close" data-dismiss = "alert" style="font-size: 22px; color:#333;">&times;</a><strong>Thành Công!</strong> Đã cập nhật...</div>');
							var element = $('.alert-success');
							for (var i = element.length; i >= 0; i--) {
								$(element[i]).fadeTo(2000, 500).slideUp(500, function() {
									$(this).remove();
								});
							}

							var smsSetting = data.data;

							Object.keys(smsSetting).forEach(setting => {
								$('.setting-'+setting).val(smsSetting[setting]);
							});
							var time = smsSetting.time_start;
							$('.setting-hours').val(moment(time, 'HH:mm:ss').format('H'));
							$('.setting-minutes').val(moment(time, 'HH:mm:ss').format('m'));
						} else if (data.status == 0) {
							var error = data['error-message'];

							if (typeof error == 'string') {
								$('#alert-success').append('<div class = "alert alert-danger"><a href = "#" class = "close" data-dismiss = "alert" style="font-size: 22px; color:#333;">&times;</a><strong>Thất bại!</strong> <br>'+error+' </div>');

								var element = $('.alert-danger');
								for (var i = element.length; i >= 0; i--) {
									$(element[i]).fadeTo(2000, 500).slideUp(500, function() {
										$(this).remove();
									});
								}
							} else if (Object.keys(error).length > 0) {
								Object.keys(error).forEach(ms => {
									$('#alert-success').append('<div class = "alert alert-danger"><a href = "#" class = "close" data-dismiss = "alert" style="font-size: 22px; color:#333;">&times;</a><strong>Thất bại!</strong> <br>'+error[ms][0]+' </div>');

									var element = $('.alert-danger');
									for (var i = element.length; i >= 0; i--) {
										$(element[i]).fadeTo(2000, 500).slideUp(500, function() {
											$(this).remove();
										});
									}
								});
							}
						}
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