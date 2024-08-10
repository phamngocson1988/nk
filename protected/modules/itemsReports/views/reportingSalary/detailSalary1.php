<?php $status=array("Thanh Toán","Còn Nợ","Phòng khám chuyên","Hoàn trả","Delay","Nhận","Chuyển");?>
<?php $loop = array();?>
<div class="table table-responsive executive">
	<table border="1px" class="table table-bordered table-hover" id="list_export"  name="chitietluong">
		<thead class="headertable">
			<tr>
				<td colspan=8>
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
				<td>Ngày</td>
				<td>Mã hóa đơn</td>
				<td>Họ tên Khách hàng</td>
				<td>Dich vụ</td>
				<td>Mã DV</td>
				<td>Răng</td>
				<td>Phí</td>
				<td>TT</td>
			</tr>
		</thead>
		<tbody>
			<?php if (count($arrayList) != 0): ?>
				<?php foreach ($arrayList as $key => $arrayListValue): ?>
					<tr>
						<td><?php 
						echo $arrayServiceType[$arrayListValue];
						$string = "";
						$sum = 0;
						?>
						<?php foreach ($list as $key => $listValue): ?>
							<?php if ($arrayListValue == $listValue["id"] && !in_array($listValue["code"], $loop)): ?>
								<?php 
								array_push($loop,$listValue["code"]);
								$string .= '<tr>';
								$string .= '<td>'.$listValue["date"].'</td>';
								$string .= '<td>'.$listValue["code"].'</td>';
								$string .= '<td>'.$listValue["fullname"].'</td>';
								$string .= '<td>'.$arrayService[$listValue["id_service"]]["name"].'</td>';
								$string .= '<td>'.$arrayService[$listValue["id_service"]]["code"].'</td>';
								$string .= '<td>'.$listValue["teeth"].'</td>';
								$string .= '<td>'.number_format($listValue["amount"]).'</td>';
								$string .= '<td>'.$status[$listValue["debt"]].'</td>';
								$string .= '</tr>';
								$sum += $listValue["amount"]; 
								?>
								<?php unset($list[$key]); ?>
							<?php endif ?>
						<?php endforeach ?>
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?php echo number_format($sum);?></td>
					<td></td>
				</tr>
				<?php echo $string; ?>
			<?php endforeach ?>
			<?php else: ?>
				<tr>
					<td colspan="8"><center>Không có dử liệu!</center></td>
				</tr>
			<?php endif ?>

		</tbody>
	</table>
</div>
