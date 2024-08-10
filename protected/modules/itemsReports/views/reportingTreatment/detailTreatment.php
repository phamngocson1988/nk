<?php $status=array("Thanh Toán","Còn Nợ","Phòng khám Chuyển","Hoàn trả","Delay","Nhận","Chuyển");?>
<?php $loop = array();?>
<div class="table table-responsive executive">
	<table border="1px" class="table table-bordered table-hover" id="list_export"  name="chitietdieutri">
		<thead class="headertable">
			<tr>
				<td colspan="7">
					<center>
						<p>Chi tiết dịch vụ
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
				<td>Ngày</td>
				<td>Mã hóa đơn</td>
				<td>Họ tên Khách hàng</td>
				<td>Dich vụ</td>
				<td>Mã DV</td>
				<td>Răng</td>
				<td>Phí</td>
			</tr>
		</thead>

		<tbody>
			<?php if (count($arrayList)>0): ?>
				<tr>
					<?php foreach ($serviceTypeShow as $key => $arrayserviceTypeShow): ?>
						<tr>
							<td colspan="6">
								<b style="color: #10b1dd;">
									<?php 
									echo $arrayServiceType[$arrayserviceTypeShow];
									$sum = 0;
									$string = "";
									?>
								</b>
								<?php foreach ($list as $key => $listValue): 
									
									?>
									<?php if ($arrayserviceTypeShow == $listValue["id_service_type"]): ?>
										<?php 
										$string .= '<tr>';
										$string .= '<td>'.$listValue["create_date"].'</td>';
										$string .= '<td>'.$listValue["code"].'</td>';
										$string .= '<td>'.$listValue["fullname"].'</td>';
										$string .= '<td>'.$arrayService[$listValue["id_service"]]["name"].'</td>';
										$string .= '<td>'.$listValue["code_service"].'</td>';
										$string .= '<td>'.$listValue["teeth"].'</td>';
										$string .= '<td>'.number_format($listValue["amount"]).'</td>';
										
										$string .= '</tr>';
										$sum += $listValue["amount"];

										?>
										<?php unset($list[$key]); ?>
									<?php endif ?>
									
								<?php endforeach ?>
							</td>
							<td colspan="2">
								<b style="color: #10b1dd;">
									<?php echo number_format($sum);?>
								</b>
							</td>
						</tr>
						<?php echo $string; ?>
					<?php endforeach ?>
				</tr>
			<?php else: 
				?>
				<tr>
					<td colspan="8"><center>Không có dữ liệu!</center></td>
				</tr>
			<?php endif ?>

		</tbody>
	</table>
</div>
