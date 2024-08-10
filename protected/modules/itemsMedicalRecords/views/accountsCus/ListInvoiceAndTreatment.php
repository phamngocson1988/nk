<table class="table table-list2 margin-top-10">
	<thead>
		<tr>
			<th style="width: 10%">Ngày</th>
			<th style="width: 16%">Răng</th>
			<th style="width: 10%">Mã DV</th>
			<th style="width: 32%">Công tác điều trị</th>
			<th style="width: 17%">Chi phí</th>
			<th style="width: 15%">Bác sĩ</th>
		</tr>
	</thead>

	<tbody id="InvoiceAndTreatment">
		<?php
		if ($data) :
			foreach ($data as $key => $v) :
				$status_invoice = isset($v['status_invoice']) ? $v['status_invoice'] : 1;
				$confirm = isset($v['confirm']) ? $v['confirm'] : 1;

				if ($status_invoice == -3) { continue; }

				if ($status_invoice == -1 && $confirm == 0) { continue; }
				?>

				<tr class="invoiceTreatment<?php echo $key + 1; ?>">
					<td style="width: 10%">
						<?php
						if (isset($v['create_date'])) {
							if ($v['create_date'] != "0000-00-00" && $v['create_date'] != "") {
								echo date_format(date_create($v['create_date']), 'd-m-Y');
							}
						}
						?>
					</td>

					<td style="width: 16%; word-break: break-word;">
						<?php
						if (isset($v['teeth'])) {
							echo str_replace(",", " ", $v['teeth']);
						} elseif (isset($v['tooth_numbers'])) {
							echo str_replace(",", " ", $v['tooth_numbers']);
						}
						?>
					</td>

					<?php
					$code = (isset($v['code_service'])) ? $v['code_service'] : '';
					$type = 1;
					if ($code) { $type = 2; }
					?>

					<td style="width: 10%" class="serviceCodeAction cursorHover" data-idx="<?php echo $key + 1; ?>" data-id="<?php echo $v['id']; ?>" data-code="<?php echo $code; ?>" data-i-id="<?php echo (isset($v['id_invoice'])) ? $v['id_invoice'] : ''; ?>" data-sv-name="<?php echo (isset($v['services_name'])) ? $v['services_name'] : ''; ?>" data-sv-price="<?php echo (isset($v['amount'])) ? $v['amount'] : ''; ?>" data-dt-name="<?php echo (isset($v['user_name'])) ? $v['user_name'] : ''; ?>" data-status="<?php echo (isset($status_invoice)) ? $status_invoice : ''; ?>" data-confirm="<?php echo $confirm;?>" data-allow_cancel="<?php echo (isset($v['id_invoice'])) ? (int)$allowCancel[$v['id_invoice']] : 0;?>">
						<?php if ($confirm == 0): ?>
							<div style="height: 20px; width: 2px; background: #53647e; padding: 0; float: left;"></div>
						<?php endif; ?>

						<?php echo $code; ?>
						<?php if ($status_invoice == -1) : ?>
							<span class="label label-danger">Hủy</span>
						<?php endif; ?>
						<?php if ($status_invoice == -2) : ?>
							<span class="label label-warning">CH</span>
						<?php endif; ?>
					</td>

					<td style="width: 32%">
						<?php
						if (isset($v['services_name'])) {
							$ct =  strip_tags($v['services_name']);
							if (strlen($ct) > 50) {
								$stringCut = substr($ct, 0, 50);
								$ct = substr($stringCut, 0, strrpos($stringCut, ' ')) . ' ...';
							}
							echo $ct;
						} elseif (isset($v['treatment_work'])) {
							$ct =  strip_tags($v['treatment_work']);
							if (strlen($ct) > 50) {
								$stringCut = substr($ct, 0, 50);
								$ct = substr($stringCut, 0, strrpos($stringCut, ' ')) . ' ...';
							}
							echo $ct;
						}
						?>
						<span>
							<i class="fa fa-pencil" style="font-size:20px; float: right;cursor: pointer;" onclick="updateNote(<?php echo $type . ',' . $v['id'] ?>);"></i>
						</span>
					</td>

					<td style="width: 17%">
						<?php $amount = isset($v['amount']) ? $v['amount'] : 0; echo number_format($amount, 0, '', '.'); ?>
					</td>

					<td style="width: 15%">
						<?php if (isset($v['user_name'])) { echo $v['user_name']; } ?>
					</td>
				</tr>

				<?php
				if (isset($v['description'])) :
					if ($v['description']) :
						?>
						<tr>
							<td colspan="6"> Ghi chú :  <?php echo $v['description']; ?></td>
						</tr>
					<?php
					endif;
				endif;
				if (isset($v['note'])) :
					if ($v['note']) :
						?>
						<tr>
							<td colspan="6"> Ghi chú : <?php echo $v['note']; ?></td>
						</tr>
					<?php
					endif;
				endif;
				?>
			<?php
			endforeach;
		else :
			echo  '<tr><td colspan="6">Không có dữ liệu!</td></tr>';
		endif;
		?>
	</tbody>
</table>

<div id="updateNoteModal" class="modal fade in">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header sHeader">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h3 id="modalTitle" class="modal-title">Chỉnh sửa ghi chú</h3>
			</div>
			<div class="modal-body col-xs-12">
				<form id="frmUpdateNote" method="post" enctype="multipart/form-data">
					<div class="col-xs-12">
						<input type="hidden" class="form-control" name="typeUpdate" id="typeUpdate">
						<input type="hidden" class="form-control" name="idUpdate" id="idUpdate">
						<div class="row margin-top-10">
							<span class="col-md-4 control-label">Ghi chú:</span>
							<div class="col-md-8">
								<textarea class="form-control" placeholder="Ghi chú" rows="5" name="dataNote" id="dataNote"></textarea>
							</div>
						</div>
						<div class="col-xs-12 text-right margin-top-10">
							<button type="submit" class="btn btn-primary">Lưu</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	//type: 1 công tác điều trị, 2 là của hóa đơn
	function updateNote(type, id) {
		$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->createUrl('itemsMedicalRecords/AccountsCus/updateNote') ?>",
			data: {
				type: type,
				id: id,
			},
			success: function(data) {
				$('#typeUpdate').val(type);
				$('#idUpdate').val(id);
				$("#dataNote").val(data);
				$('#updateNoteModal').modal('show');
			},
			error: function(data) {
				alert("Error occured.Please try again!");
			},
		});
	}

	$('#frmUpdateNote').submit(function(e) {
		e.preventDefault();
		var formData = new FormData($("#frmUpdateNote")[0]);
		formData.append('id_customer', $('#id_customer').val());
		formData.append('id_mhg', $('#id_mhg').val());
		if (!formData.checkValidity || formData.checkValidity()) {
			$('.cal-loading').fadeIn('fast');
			jQuery.ajax({
				type: "POST",
				url: baseUrl + '/itemsMedicalRecords/AccountsCus/saveUpdateNote',
				data: formData,
				datatype: 'json',
				success: function(data) {

					$("#updateNoteModal").removeClass("in");
					$(".modal-backdrop").remove();
					$('#updateNoteModal').modal('hide');
					$("body").removeClass('modal-open');
					$("body").css('padding-right', '0');
					$('#tab_medical_records').html(data);
					e.stopPropagation();
					$('.cal-loading').fadeOut('fast');
				},
				error: function(data) {
					alert("Error occured. Please try again!");
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}
		return false;
	});
</script>