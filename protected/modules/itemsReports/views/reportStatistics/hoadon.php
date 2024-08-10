<?php
$arrayDichVu = explode(",",$dichvu);
?>
<div class="table table-responsive executive">
	<table border="1px" class="table table-bordered table-hover">
		<thead class="headertable">
			<tr>
				<td>Nhóm DV</td>
				<td>Doanh số</td>
			</tr>
		</thead>
		<tbody>
			<?php if ((int)$dichvu != 0): ?>
				<tr>
					<td>Tổng</td>
					<td>
						<?php 
						$doanhso = 0;
						foreach ($arrayList as $key => $value): 
							$doanhso += (int)$value;
						endforeach ?>
						<?php echo number_format($doanhso, 0, ',', '.');?>
					</td>
				</tr>
				<?php foreach ($arrayDichVu as $key => $value): ?>
					<tr>
						<td><?php echo $arrayServiceType[$value] ?></td>
						<td>
							<?php
							if (array_key_exists($value, $arrayList)) {
								echo number_format($arrayList[$value], 0, ',', '.');
							} else {
								echo "0";
							}
							?>
						</td>
					</tr>
				<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="3"><center>Không có dử liệu!</center></td>
					</tr>
				<?php endif ?>

			</tbody>
		</table>
	</div>
