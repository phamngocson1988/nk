
<style>
.sHeader{background: #0eb1dc; color: white; padding: 8px 30px; font-size: 18px;}
/****************/
#send_sms label {
	width: 35%;
}
#send_sms input, #send_sms textarea {
	background: white;
	border: 1px solid #ccc !important;
}
</style>

<?php $templates = Yii::app()->zalo->getTemplates(); ?>
<?php
$params = [];
foreach ($templates as $template) {
	$params = array_merge($params, $template['param']);
}
$params = array_unique($params);
?>
<div class="modal-dialog" style="width: 380px; padding-top: 100px;">
	<div class="modal-content">

		<div class="modal-header sHeader">
			<button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h3 id="modalTitle" class="modal-title">GỬI TIN NHẮN </h3>
		</div>


		<div class="modal-body">
			<form enctype="multipart/form-data" class="form-horizontal" id="send_sms" action="" method="post">  
				<div class="form-group">
					<label class="col-xs-4 control-label">Mẫu tin</label>
					<div class="col-xs-7">
						<select name="Sms[templateId]" id="templateId" class="form-control" placeholder="Mẫu tin">
							<option value="">Chọn mẫu tin</option>
							<?php foreach ($templates as $key => $template) { ?>
							<?php $templateTitle = explode("\n", $template['content'])[0];?>
							<option value="<?php echo $template['template_id']?>" data-content="<?php echo $template['content'];?>" data-param="<?php echo join(",",$template['param']);?>"><?php echo $templateTitle;?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">Số điện thoại</label>
					<div class="col-xs-7">
						<input type="text" name="Sms[phone]" id="Sms_phone" value="<?php echo $model->phone; ?>" placeholder="Số điện thoại" class="form-control">
						<input type="hidden" id="Sms_cus" value="">
						<input type="hidden" id="Sms_id_cus" value="">								               			
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">Nội dung</label>
					<div class="col-xs-7">
							<textarea class="form-control" placeholder="Nội dung" name="Sms[content]" id="Sms_content" rows=5></textarea>
						<div class="clearfix"></div>
						<div class="charLeft">Tin <span id="smsNum"> 1 </span> - Còn <span id="charNum">160</span> ký tự</div>
					</div>
				</div>
				<?php foreach ($params as $param) { ?>
				<div class="form-group" id="template_param_<?php echo $param;?>" style="display: none">
					<label class="col-xs-4 control-label"><?php echo $param;?></label>
					<div class="col-xs-7">
						<input type="text" name="Sms[template][<?php echo $param;?>]" class="form-control">
					</div>
				</div>
				<?php } ?>
				<div class="form-group">
					<div class="col-xs-9 text-center" style="line-height: 33px;">
						Tin nhắn không hỗ trợ tiếng Việt có dấu!
					</div>
					<div class="col-xs-3 text-right" style="padding: 0; padding-right: 40px;">
						<button type="submit" class="btn" style="background: #93c541; color: white;">Gửi</button>
					</div>
				</div>
				
			</form>
		</div>
	</div>
</div>

<div id="sendSmsRs" class="modal pop_bookoke">
   	<div class="modal-dialog" style="width: 380px; padding-top: 100px;">
      	<div class="modal-content">
         	<div class="modal-header popHead">
            	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">close</span></button>
            	<span>THÔNG BÁO</span>
         	</div>
   
         	<div class="modal-body">
        		<p>Gửi tin nhắn thành công</p>
          	</div>
        </div>
    </div>
</div>
<script>
$('#sendsSmsPop').on('hide.bs.modal', function () {
  $('#Sms_content').val('');
  $('#Sms_phone').val('');
});
$('#Sms_content').on('keydown keypress',function (e) {
	smsLen = 160; 		// ky tu toi da trong 1 tin
	maxLen = (smsLen * 3) - 1;	// 3 tin toi da

	len = $("#Sms_content").val().length;
	var key = (e.which) ? e.which : e.keyCode;

	if(maxLen - len < 0) {
		if(key!= 8 && !(37<=key&&key<40)){
			e.preventDefault();
		}
	}

	smsNum = Math.ceil(parseInt(len)/smsLen);

	$('#charNum').text(smsLen*smsNum - len);
	if(smsLen*smsNum - len < 0)
		$('#charNum').text(160);

	$('#smsNum').text(smsNum);
});

$('#send_sms').submit(function (e) {
	e.preventDefault();

	phone  = $('#Sms_phone').val();
	text   = $('#Sms_content').val();
	cus    = $('#Sms_cus').val();
	id_cus = $('#Sms_id_cus').val();
	const templateId = $('#templateId').val();
	const templateData = {};
	console.log('templateid', templateId);
	if (templateId) {
		const params = $(this).find('option[value="'+templateId+'"]').data('param');
		params.split(',').forEach(function(param) {
			templateData[param] = $('#template_param_' + param).find('input').val();
		});
	}

	$.ajax({
		type: "post",
		dataType: 'json',
		url: '<?php echo Yii::app()->createUrl('itemsUsers/Sms/sendSMS'); ?>',
		data: {
			phone : phone,
			text  : text,
			source: 1,
			id_cus: id_cus,
			cus   : cus,
			id_template: templateId,
			template_data: templateData
		},
		success: function(data) {
			if(data == 1) {
				$('#sendsSmsPop').modal('hide');
				$('#smsSendRs').text('Gửi tin nhắn thành công!')
				$('#sendSmsRs').modal('show');
			}
			else {
				$('#sendsSmsPop').modal('hide');
				$('#smsSendRs').text('Gửi tin nhắn thất bại!')
				$('#sendSmsRs').modal('show');
			}
		},
	});
});
$('#templateId').on('change', function() {
	const hideAllTemplateParams = () => {
		const elements = $('div[id^=template_param_]');
		$.each(elements, function( index, e ) {
			$(e).hide();
		});
	}
	// If template id is empty: show content
	// Else disable content and show template data controls
	const templateId = $(this).val();
	const params = $(this).find('option[value="'+templateId+'"]').data('param');
	if (!templateId) {
		$('#Sms_content').val('').attr('readonly', false);
		hideAllTemplateParams();
	} else {
		const content = $(this).find('option[value="'+templateId+'"]').data('content');
		$('#Sms_content').val(content).attr('readonly', true);
		hideAllTemplateParams();
		params.split(',').forEach(function(param) {
			$('#template_param_' + param).show();
		});
		

	}
});
</script>