<div class="row">
	<?php if ($listInvoice == -1): ?>
		<div class="no-data" style="display: table-cell; vertical-align: middle; text-align: center;">
			<div style="text-align: center;">
				<img src="<?php Yii::app()->params['image_url']; ?>/images/no-data.png" style="width:200px; height: auto;"><br>
				<p style="color: #464646; font-size: 15px;">Không có dữ liệu !</p>
			</div>
		</div>
		<?php exit(); ?>
	<?php else: ?>
		<tr class="hidden">
			<td><input type="hidden" class="invoice_page" value="<?php echo $page; ?>"></td>
			<td><input type="hidden" class="invoice_num_page" value="<?php echo $numPage; ?>"></td>
		</tr>
		<?php foreach ($listInvoice as $key => $dt):
			$idInv = $dt->id;

			$listInvoiceDetail = VInvoiceDetail::model()->findAllByAttributes(array('id_invoice' => $dt->id));

			if (!$listInvoiceDetail) {
				continue;
			}

		?>
		<div class="col-md-12" style="background-color:#F6F6F5; margin:20px 0; border-radius: 7px; padding-bottom: 20px;">
			<div class="row" style="padding-left: 60px;padding-top: 10px;">
				<h4 class="tt col-md-8">Mã hóa đơn: <span><?php echo $dt->code; ?></span>
					<?php if ($dt->vat): ?>
						<span class="label" style="background: #f1b51b;">VAT</span>
					<?php endif ?>
				</h4>
				<a target="_blank" href="<?php echo Yii::app()->getBaseUrl() . '/itemsSales/invoices/View?id='. $idInv; ?>" class="actionMedicalHistory">Hóa đơn</a>
			</div>

				<div class="row">
					<div class="col-md-12" style="margin-bottom: 15px;">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-5 text-right"><b>Văn phòng:</b></div>
								<div class="col-md-7"><?php echo $dt->branch_name; ?></div>
							</div>
							<div class="row">
								<div class="col-md-5 text-right"><b>Ngày tạo:</b></div>
								<div class="col-md-7"><?php echo date('d/m/Y',strtotime($dt->create_date)); ?></div>
							</div>
							<div class="row">
								<div class="col-md-5 text-right"><b>Người thực hiện:</b></div>
								<div class="col-md-7"><?php echo $dt->author_name; ?></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="row">
								<div class="col-md-5 text-right"><b>Tổng tiền:</b></div>
								<div class="col-md-5 text-right"><?php echo number_format($dt->sum_amount,0,'','.'); ?> VND</div>
							</div>
							<div class="row">
								<div class="col-md-5 text-right"><b>Còn nợ:</b></div>
								<div class="col-md-5 text-right"><?php echo number_format($dt->balance,0,'','.'); ?> VND</div>
							</div>
							<div class="row">
								<div class="col-md-5 text-right"><b>Nhóm khách hàng:</b></div>
								<div class="col-md-5"><?php echo $dt->name_price_book; ?></div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 table-responsive">
					<table class="table table-bordered table-inv">
				    	<thead style="background: #8ca7ae; color: white;">
							<tr>
						        <th>Mã dịch vụ</th>
						        <th>Sản phẩm và Dịch vụ</th>
						        <th>Số lượng</th>
						        <th>Số răng</th>
						        <th>Đơn giá</th>
						        <th>Tổng tiền</th>
							</tr>
						</thead>

						<tbody style="background: #f1f5f6; color: black;">
							<?php if (!$listInvoiceDetail): ?>
								<tr>
								    <td colspan="6" class="text-center">Không có dữ liệu!</td>
								</tr>

							<?php else: ?>
								<?php foreach ($listInvoiceDetail as $k => $r): ?>
								<?php if ($r['status'] == -2): ?>
									<?php continue; ?>

								<?php endif; ?>
									<tr>
								        <td>
											<?php echo $r['code_service']; ?>
											<?php if ($r['status'] == -1): ?>
												<span class="label label-danger">Hủy</span>
											<?php elseif ($r['status'] == -2): ?>
												<span class="label label-warning">Chuyển</span>
											<?php endif; ?>
										</td>
								        <td><?php echo $r['description']; ?></td>
								        <td><?php echo $r['qty']; ?></td>
								        <td><?php echo $r['teeth']; ?></td>
								        <td><?php echo number_format($r['unit_price'],0,'','.'); ?></td>
								        <td><?php echo number_format($r['amount'],0,'','.'); ?></td>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
			    </div>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>