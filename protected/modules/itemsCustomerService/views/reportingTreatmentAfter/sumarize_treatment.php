<div class="container" style="margin-top: 20px;margin-bottom: 20px;">
	<div class="row">
		<div class="col-sm-12 col-md-6">
			<table class="table table-bordered" width="100%">
				<thead class="headertable">
					<tr>
						<td colspan="3">THỐNG KÊ CSKH SAU ĐIỀU TRỊ</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach(AfterTreatmentNote::model()->listQuality as $key => $value):?>
						<tr>
							<td><?php echo $key ?></td>
							<td><?php echo $value ?></td>
							<td>
								<?php 
									$flag_cs = false;
									foreach($count_cs as $cs){
										if ($cs['quality'] == $key) {
											echo $cs['total'];
											$flag_cs = true;
										}
									} 
									if (!$flag_cs) {
										echo 0;
									}
								?>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-12 col-md-6">
			<table class="table table-bordered" width="100%">
				<thead class="headertable">
					<tr>
						<td colspan="2">THỐNG KÊ SỐ LƯỢNG ĐIỀU TRỊ</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach(AfterTreatmentNote::model()->appointmentList as $key => $value):?>
						<tr>
							<td><?php echo $value ?></td>
							<td>
								<?php 
									$flag_appointment = false;
									foreach($count_treatment as $appointment){
										if ($appointment['appointment'] == $key) {
											echo $appointment['total'];
											$flag_appointment = true;
										}
									} 
									if (!$flag_appointment) {
										echo 0;
									}
								?>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-12 col-md-6">
			<table class="table table-bordered" width="100%">
				<thead class="headertable">
					<tr>
						<td colspan="3">THỐNG KÊ SỐ LƯỢNG KHÁCH HÀNG</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach(AfterTreatmentNote::model()->serviceCustomer as $key => $value):?>
						<tr>
							<td><?php echo $key ?></td>
							<td><?php echo $value ?></td>
							<td>
								<?php 
									$flag_service_code = false;
									foreach($count_customer as $service_code){
										if ($service_code['service_code'] == $key) {
											echo $service_code['total'];
											$flag_service_code = true;
										}
									} 
									if (!$flag_service_code) {
										echo 0;
									}
								?>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-12 col-md-6">
			<table class="table table-bordered" width="100%">
				<thead class="headertable">
					<tr>
						<td colspan="2">THỐNG KÊ KHÁCH HÀNG ĐỐI TÁC</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($count_partner as $key => $value): ?>
						<tr>
							<!-- <td><?php echo $value['code'] ?></td> -->
							<td><?php echo $value['name'] ?></td>
							<td>
								<?php echo $value['count'] ?>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>