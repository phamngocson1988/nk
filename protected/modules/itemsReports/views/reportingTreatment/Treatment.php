<div class="table table-responsive executive" id="list_export" name="nhomdichvu">
	<table border="1px" class="table table-bordered table-hover">
		<thead class="headertable">
			<tr>
				<td colspan="4">
					<center>
						<p>Nhóm dịch vụ
							<br>
							Từ ngày <?php echo $fromtime;?> đến ngày <?php echo $totime;?>
							<br>
							bác sĩ : <?php
							if ($dentist[0] != 0) {
								$string = "";
								foreach ($dentist as $key => $value) {
									$string .= $nameDentist[$value]." - ";
								}
								echo rtrim($string," - ");
							}
							?>
						</p>
					</center>
				</td>
			</tr>
			<tr>
				<td>Nhóm DV</td>
				<td>Số lượng</td>
				<td>Phí</td>
				<td>Trung bình</td>
			</tr>
		</thead>
		<tbody>
			<?php if (count($arrayList) != 0): ?>
				<tr>
					<td>Tổng</td>
					<td>
						<?php 
						$soluong = 0;
						$tong = 0;
						$trungbinh = 0;
						foreach ($arrayList as $key => $value):
							$soluong += (int)$value["soluong"];
							$tong += (int)$value["tong"];
							$trungbinh += (int)$value["trungbinh"];
						endforeach ?>
						<?php echo $soluong;?>
					</td>
					<td>
						<?php echo number_format($tong);?>
					</td>
					<td>
						<?php echo number_format($trungbinh);?>
					</td>
				</tr>
				<?php foreach ($arrayList as $key => $value): ?>
					<tr>
						<td><?php echo $arrayServiceType[$value["id"]];?></td>
						<td>
							<?php echo $value["soluong"];?>
						</td>
						<td>
							<?php echo number_format($value["tong"]);?>
						</td>
						<td>
							<?php echo number_format($value["trungbinh"]);?>
						</td>
					</tr>
				<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="4"><center>Không có dữ liệu!</center></td>
					</tr>
				<?php endif ?>

			</tbody>
		</table>
	</div>
