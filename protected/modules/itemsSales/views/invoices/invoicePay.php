<style>
	input:disabled:hover, input:read-only:hover {
		cursor: default;
	}
	input:read-only:focus, input:disabled:focus {
		outline: none !important;
		box-shadow: none !important;
	}

	.alert {
		margin-bottom: 10px;
		padding: 3px;
	}

	.pay_info .form-group {
		margin-bottom: 0px;
	}

	.Submit {
		background: #94c63f;
		color: white;
	}

	.pay_date {
		padding: 10px;
	}

	.input-group-addon {
		cursor: default;
	}

	.selCol {
		color: black !important;
	}

	.dVAT .form-group {
		margin-bottom: 5px;
	}

	.dVAT label {
		padding-top: 8.5px !important;
	}

	.text input,
	.text textarea,
	.text .input-group-addon {
		border: 0;
		background: transparent !important;
		box-shadow: none;
	}

	.red {
		color: red;
	}

	.clsPro {
		position: relative;
	}

	.imgPro {
		position: absolute;
		top: 5px;
		right: 20px;
	}

	.imgPro img {
		width: 24px;
		cursor: pointer;
	}

	#crCard {
		display: table;
	}

	#crCard label {
		display: table-cell;
	}

	#inp_sel {
		background: #7cc9ac;
		color: white;
	}

	#inp_sel:hover,
	#inp_sel:focus {
		background: #48b64e !important;
		color: white !important;
	}
</style>

<div class="modal-dialog modal-lg pop_bookoke">
	<div class="modal-content quote-edit-container">

		<div class="modal-header sHeader">
			<button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h3 id="modalTitle" class="modal-title">Thanh toán hóa đơn số <?php echo $inv['code']; ?></h3>
		</div>

		<?php $form = $this->beginWidget(
			'booster.widgets.TbActiveForm',
			array(
				'clientOptions' => array(
					'validateOnSubmit' => true,
					'validateOnChange' => true,
					'validateOnType' => true,
				),
				'id' => 'frm-pay-invoice',
				'type' => 'horizontal',
				'enableAjaxValidation' => true,
				'enableClientValidation' => true,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)
		); ?>

		<div class="modal-body">
			<div class="alert alert-success">
				<input type="hidden" name="hidden_balance" value="<?php echo $inv['balance']; ?>">
				<input type="hidden" name="Invoice[id]" id="id_invoice" value="<?php echo $inv['id']; ?>">
				<input type="hidden" id="id_branch" value="<?php echo $inv['id_branch']; ?>">
				<input type="hidden" id="id_segment">

				<div class="row pay_info">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="sumWTax" class="col-sm-5 control-label">Tổng tiền đơn hàng:</label>
							<div class="col-sm-6 text">
								<div class="input-group">
									<input type="text" name="Invoice[sum_amount]" class="autoNum form-control text-right" id="sumWTax" value="<?php echo $inv['sum_amount']; ?>" readOnly>
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="sumWTax" class="col-sm-5 control-label">Tiền deposit:</label>
							<div class="col-sm-6 text">
								<div class="input-group">
									<input type="text" class="autoNum form-control text-right" id="sum_deposit" value="<?php echo $deposit; ?>" readOnly>
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="sumWTax" class="col-sm-5 control-label">Số tiền còn nợ:</label>
							<div class="col-sm-6 text">
								<div class="input-group">
									<input type="text" class="autoNum form-control text-right" id="sumWOwe" value="<?php echo $inv['balance']; ?>" readOnly>
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="sumWTax" class="col-sm-5 control-label">Bảo hiểm bảo lãnh:</label>
							<div class="col-sm-6 text">
								<div class="input-group">
									<input type="text" class="autoNum form-control text-right" id="sumWTax" value="<?php echo $inv['sum_insurance']; ?>" readOnly>
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6" id="dvTaxVat" <?php echo (!$inv['vat']) ? 'style="display: none;"' : ''; ?>>
					<div class="form-group">
						<label for="sumWTax" class="col-sm-5 control-label">Thuế hóa đơn GTGT:</label>
						<div class="col-sm-6 text">
							<div class="input-group">
								<input type="text" <?php if ($inv['vat']) echo "disabled"; ?> name="Invoice[vat]" class="autoNum form-control text-right" id="taxVat" value="<?php echo $inv['sum_amount'] - $inv['sum_no_vat']; ?>">
								<span class="input-group-addon">VND</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="alert">
				<div class="col-sm-12" style="font-size: 18px; font-weight: bold">Hình thức thanh toán</div>

				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" id="1" href="#cash">Tiền mặt</a></li>
					<li><a data-toggle="tab" id="2" href="#credit">Thẻ tín dụng</a></li>
					<li><a data-toggle="tab" id="3" href="#transfer">Chuyển khoản</a></li>
					<li><a data-toggle="tab" id="5" href="#transfer">Deposit</a></li>
					<li <?php echo ($inv['sum_insurance']) ? 'class="disabled"' : ''; ?>>
						<a <?php echo (!$inv['sum_insurance']) ? 'data-toggle="tab"' : ''; ?> id="4" href="#insurance">Bảo hiểm bảo lãnh</a>
					</li>
					<li class="pull-right pay_date">Ngày thanh toán: <span class="today"></span></li>
				</ul>

				<div class="tab-content">
					<div id="cash" class="tab-pane fade in active">
						<div class="alert"></div>
					</div>

					<div id="credit" class="tab-pane fade">
						<div class="alert">
							<div class="col-sm-3 text-right" style="display: none;">
								<h5>Loại thẻ tín dụng:</h5>
							</div>
							<div class="col-sm-9" id="crCard" style="display: none;">
								<input type="hidden" name="Receipt[card_percent]" id="card_percent">
								<label class="radio-inline"><input type="radio" value="1" data-fee='0' class="cardType feeCard" name="Receipt[card_type]" checked>Visa</label>
								<label class="radio-inline"><input type="radio" value="2" data-fee='0' class="cardType feeCard" name="Receipt[card_type]">Master</label>
							</div>
						</div>
					</div>

					<div id="transfer" class="tab-pane fade">
						<div class="alert"></div>
					</div>

					<div id="deposit" class="tab-pane fade">
						<div class="alert"></div>
					</div>

					<div id="insurance" class="tab-pane fade">
						<div class="alert"></div>
					</div>

					<?php
						$brAdrs = Branch::model()->findByPk(Yii::app()->user->getState('user_branch'));
						$adr = $brAdrs['name'] . '-' . $brAdrs['address'];
						echo $form->hiddenField($rpt, 'id');
						echo $form->hiddenField($rpt, 'pay_type', array('class' => 'pay_type'));
					?>

					<div class="col-sm-7">
						<div class="form-group text">
							<label class="col-sm-4 control-label">Tiền phải thu</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" class="autoNum form-control pay_customer_need text-right" value="<?php echo $inv['balance']; ?>" disabled>
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group cashType creditType transferType depositType">
							<label class="col-sm-4 control-label">Khách trả</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input value="<?php echo $inv['balance']; ?>" placeholder="0" class="autoNum text-right pay_amount chgCurr pay refund feeCardInp form-control" name="Receipt[pay_amount]" id="Receipt_pay_amount" type="text">
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group creditType" style="display: none;">
							<label class="col-sm-4 control-label">Khuyến mãi</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input value="0" placeholder="0" class="autoNum text-right form-control" name="Receipt[pay_promotion]" id="Receipt_pay_promotion" type="text">
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group text cashType creditType">
							<label class="col-sm-4 control-label">Deposit</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input value="0" placeholder="0" class="autoNum text-right form-control pay_deposite" name="deposit" type="text" readOnly>
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group creditType transferType" style="display: none;">
							<label class="col-sm-4 control-label">Đối tượng thanh toán</label>
							<div class="col-sm-7">
								<label><?php echo CHtml::checkbox('Receipt[is_company]'); ?> Công ty</label>
							</div>
						</div>

						<div class="form-group insuranceType" style="display: none;">
							<label class="col-sm-4 control-label">Bảo hiểm bảo lãnh</label>
							<div class="col-sm-7">
								<div class="input-group">
									<?php $isInsurance = ($inv['sum_insurance'] > 0) ? "disabled" : ""; ?>
									<input value="<?php echo $inv['sum_insurance'] ?>" class="form-control autoNum text-right Invoice-sum_insurance" name="Receipt[sum_insurance]" type="text" <?php echo $isInsurance ;?>>
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group creditType " style="display: none;">
							<label class="col-sm-4 control-label">Phí giao dịch</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" name="Receipt[card_val]" class="autoNum form-control text-right transFee" value="0">
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group text creditType" style="display: none;">
							<label class="col-sm-4 control-label">Tổng tiền thanh toán</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" name="Receipt[pay_sum]" class="autoNum form-control text-right feeSumCard cuspayForIv" value="0" readOnly>
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group cashType hidden">
							<label class="col-sm-4 control-label">Tiền nhận</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" name="Receipt[curr_amount]" class="autoNum refund form-control pay text-right chgCurr" id="reCurr" value="0">
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group text cashType hidden">
							<label for="pay_refund" class="col-sm-4 control-label">Hoàn lại</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" class="form-control text-right refund autoNum" id="pay_refund" value="0">
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="Invoice_balance">Còn nợ</label>
							<div class="col-sm-7 text">
								<div class="input-group">
									<input readOnly class="autoNum text-right balance red form-control" value="0" placeholder="Balance" name="Invoice[balance]" id="Invoice_balance" type="text">
									<span class="input-group-addon">VND</span>
								</div>
							</div>
						</div>

						<div class="col-sm-6 cashType creditType transferType">
							<div class="form-group">
								<label class="col-sm-5 control-label" for="Receipt_currency">Ngoại tệ</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input class="autoNum text-right form-control" value="0" placeholder="Currency" name="Receipt[currency]" id="Receipt_currency" type="text">
										<span class="input-group-addon">USD</span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6 cashType creditType transferType">
							<div class="form-group">
								<label class="col-sm-4 control-label" for="Receipt_exchange_rate">Tỷ giá</label>
								<div class="col-sm-8">
									<div class="input-group">
										<input class="autoNum text-right form-control" value="0" placeholder="Exchange Rate" name="Receipt[exchange_rate]" id="Receipt_exchange_rate" type="text">
										<span class="input-group-addon">VND</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-5">
						<div class="form-group">
							<label class="col-sm-12 control-label" for="Invoice_note">Ghi chú</label>
							<div class="col-sm-12">
								<textarea class="text-left form-control" rows="10" placeholder="Ghi chú" name="Invoice[note]" id="Invoice_note"></textarea>
							</div>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>

				<?php
					$vatRO = ''; $vatCk = ''; $vatCls = ''; $vatStyle = 'style="display: none"';

					if ($inv['isVat']) {
						$vatRO = 'disabled'; $vatCk = 'checked'; $vatCls = 'text'; $vatStyle = '';
					}
				?>

				<div class="checkbox col-sm-offset-1">
					<?php $checkVat = ($inv['isVat']) ? true : false; ?>
					<label><?php echo CHtml::checkbox('Invoice[checkVat]', $checkVat, array('id' => 'ck_VAT', 'disabled' => $vatRO)); ?>Hóa đơn GTGT</label>
				</div>

				<div class="dVAT <?php echo $vatCls; ?>" <?php echo $vatStyle; ?>>
					<div class="form-group">
						<label for="vat_date" class="col-sm-3 control-label">Ngày xuất hóa đơn</label>
						<div class="col-sm-3">
							<input name="Invoice[date_vat]" value="<?php echo date_format(date_create($inv['date_vat']), 'd/m/Y'); ?>" type="text" class="form-control" id="vat_date" <?php echo $vatRO; ?>>
						</div>

						<label style="display: none;" for="vat_value" class="col-sm-1 control-label">Giá trị</label>
						<div style="display: none;" class="col-sm-1">
							<input name="Invoice[vat]" value="<?php echo $inv['vat']; ?>" type="text" class="form-control" id="vat_value" <?php echo $vatRO; ?>>
						</div>
						<label style="display: none;" for="vat_value" class="control-label">%</label>
					</div>

					<div class="form-group">
						<label for="vat_place" class="col-sm-3 control-label">Thông tin xuất hóa đơn đỏ</label>
						<div class="col-sm-5">
							<textarea name="Invoice[place_vat]" class="form-control" id="vat_place" <?php echo $vatRO; ?>><?php echo $inv['place_vat'] ?></textarea>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="ocf text-right">
					<button type="button" class="btn btn_cancel" data-dismiss="modal">Hủy</button>
					<button type="submit" class="btn oBtnDetail">Xác nhận</button>
				</div>
			</div>
		</div>

		<?php $this->endWidget(); unset($form); ?>
	</div>
</div>

<div class="modal pop_bookoke" id="info" role="dialog">
	<div class="modal-dialog" style="width: 350px;">
		<div class="modal-content">

			<div class="modal-header popHead">
				<a class="btn_close" data-dismiss="modal" aria-label="Close"></a>
				<h5 id="info_head">THÔNG BÁO</h5>
			</div>

			<div class="modal-body text-center">
				<p id="info_content"></p>
			</div>
		</div>
	</div>
</div>

<?php include 'invoicePay_js.php'; ?>