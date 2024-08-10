<?php
$arrayDichVu = explode(",",$dichvu);
?>
<div class="table table-responsive executive" id="list_export" name="luong">
	<table border="1px" class="table table-bordered table-hover">
		<thead class="headertable">
			<tr>
				<td colspan=4>
					<center>
						<p>
							Lương bác sĩ : <?php
							if ($dentist[0] != 0) {
								$string = "";
								foreach ($dentist as $key => $value) {
									$string .= $nameDentist[$value]." - ";
								}
								echo rtrim($string," - ");
							}
							?>
							<br>
							Từ ngày <?php echo $fromtime;?> đến ngày <?php echo $totime;?>
						</p>
					</center>
				</td>
			</tr>
			<tr>
				<td>Nhóm DV</td>
				<td>Doanh số</td>
				<td>Phần trăm</td>
				<td>Lương</td>
			</tr>
		</thead>
		<tbody>
			<?php if ((int)$dichvu != 0): ?>
				<tr>
					<td><b style="color: #10b1dd;">Tổng</b></td>
					<td>
						<?php 
						$doanhso = 0;
						foreach ($arrayList as $key => $value):
							$doanhso += (int)$value["sum"];
						endforeach ?>
						<b style="color: #10b1dd;"><?php echo number_format($doanhso);?></b>
					</td>
					<td>
						-
					</td>
					<td>
						<?php 
						$luong = 0;
						foreach ($arrayList as $key => $value):
							$luong += (int)$value["luong"];
						endforeach ?>
						<b style="color: #10b1dd;"><?php echo number_format($luong);?></b>
					</td>
				</tr>
				<?php foreach ($arrayDichVu as $key => $value): ?>

					<?php if (array_key_exists($value, $arrayList)): ?>
						<tr>
							<td><?php echo $arrayServiceType[$value] ?></td>
							<td>
								<?php
								$item = $arrayList[$value];
								echo number_format($item["sum"]);
								?>
							</td>
							<td>
								<?php echo implode(",", $item["percent"]);?> 
							</td>
							<td>
								<?php
								echo number_format($item["luong"]);
								?>
							</td>
						</tr>
					<?php endif ?>
				<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="3"><center>Không có dữ liệu!</center></td>
					</tr>
				<?php endif ?>

			</tbody>
		</table>
	</div>
