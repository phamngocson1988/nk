<div class="table table-responsive executive">
	<table border="1px" class="table table-bordered table-hover" id="list_export" name="taichinh">
		<thead class="headertable">
			<tr>
				<td colspan=2>
					<center>
						<?php if ($option == 0) : ?>
							<p>Doanh thu <br> Từ ngày <?php echo $fromtime; ?> đến ngày <?php echo $totime; ?> <br> Bác sĩ :
							<?php echo implode(" - ", array_values($dentistList)); ?>
							</p>
						<?php else : ?>
							<p> Công nợ <br> Từ ngày <?php echo $fromtime; ?> đến ngày <?php echo $totime; ?> </p>
						<?php endif ?>
					</center>
				</td>
			</tr>
			<tr>
				<td>Nhóm DV</td>
				<td>Doanh số</td>
			</tr>
		</thead>

		<tbody>
			<?php if ($data): ?>
				<tr>
					<td><b style="color: #10b1dd;">Tổng</b></td>
					<td>
						<b style="color: #10b1dd;">
							<?php echo number_format($sum["sumAmount"], 0, '', '.'); ?>
						</b>
					</td>
				</tr>

				<?php if ($option == 0): ?>
					<tr>
						<td><b style="color: #10b1dd;">Khuyến mãi</b></td>
						<td>
							<b style="color: #10b1dd;">
								<?php echo number_format($promotion["sumAmount"], 0, '', '.'); ?>
							</b>
						</td>
					</tr>
				<?php endif; ?>

				<?php foreach ($data as $key => $value) : ?>
					<tr>
						<td><?php echo $value['name'] ?></td>
						<td><?php echo number_format($value["sumAmount"], 0, '', '.'); ?></td>
					</tr>
				<?php endforeach ?>

			<?php else : ?>
				<tr>
					<td colspan="3">
						<center>Không có dữ liệu!</center>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>