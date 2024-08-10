<div class="table table-responsive executive">
	<table border="1px" class="table table-bordered table-hover" id="list_export" name="taichinh">
		<thead class="headertable">
			<tr>
				<td colspan=14>
					<center>
						<p>Doanh thu <br> Từ ngày <?php echo $fromtime; ?> đến ngày <?php echo $totime; ?> 
						<?php if (count($dentistList)) {?>
							<br> Bác sĩ : <?php echo implode(" - ", array_values($dentistList)); ?>
						<?php }?>
						</p>
					</center>
				</td>
			</tr>
			<tr>
				<td>STT</td>
				<td>Nhóm DV</td>
				<td>Doanh số</td>
				<td>Chiết khấu</td>
				<td>Phòng khám chuyển</td>
				<td>Doanh số (sau CK)</td>
				<td>Thực thu</td>
				<td>Công nợ</td>
				<td>Bảo hiểm</td>
				<td>Tiền mặt</td>
				<td>Thẻ công ty</td>
				<td>Thẻ cá nhân</td>
				<td>CK công ty</td>
				<td>CK cá nhân</td>
			</tr>
		</thead>

		<tbody>
			<?php if (count($data)): ?>
				<tr>
					<td colspan="2"><b style="color: #10b1dd;">Tổng</b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["revenue_gross"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["discount"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["pkc"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["revenue_net"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["debt"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_insurrance"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_cash"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_credit_company"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_credit_individual"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_transfer_company"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_transfer_individual"], 0, '', '.'); ?></b></td>
				</tr>
				<?php foreach ($data as $no => $value) : ?>
				<tr data-service-id="<?php echo $value['id'];?>">
					<td><?php echo  ($no + 1) ?></td>
					<td><?php echo $value['name'] ?></td>
					<td class="table-cell-number"><?php echo number_format($value["revenue_gross"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["discount"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["pkc"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["revenue_net"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["paid"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["debt"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["paid_insurrance"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["paid_cash"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["paid_credit_company"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["paid_credit_individual"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["paid_transfer_company"], 0, '', '.'); ?></td>
					<td class="table-cell-number"><?php echo number_format($value["paid_transfer_individual"], 0, '', '.'); ?></td>
				</tr>
				<?php endforeach ?>
				<tr>
					<td colspan="2"><b style="color: #10b1dd;">Tổng</b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["revenue_gross"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["discount"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["pkc"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["revenue_net"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["debt"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_insurrance"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_cash"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_credit_company"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_credit_individual"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_transfer_company"], 0, '', '.'); ?></b></td>
					<td class="table-cell-number"><b style="color: #10b1dd;"><?php echo number_format($sum["paid_transfer_individual"], 0, '', '.'); ?></b></td>
				</tr>
			<?php else : ?>
				<tr>
					<td colspan="14">
						<center>Không có dữ liệu!</center>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<style type="text/css">
	.table-cell-number { text-align: right; }
</style>