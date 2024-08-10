<div class="table table-responsive executive">
	<table class="table table-bordered table-hover" id="list_export">
		<thead class="headertable">
			<tr>
				<th>Mã khách hàng</th>
				<th>Khách hàng</th>
				<th>Dịch vụ</th>
				<th>Răng</th>
				<th>Phí</th>
				<th>Bác sĩ</th>
				<th>Phần trăm</th>
				<th>Lương</th>
				<th>Mã hóa đơn</th>
				<th>Ngày trả</th>
				<th>Tình trạng</th>
			</tr>
		</thead>

		<tbody>
			<?php
				if (isset($listTransactionInvoice) && !empty($listTransactionInvoice)):
					$i = 0;
					$len = count($listTransactionInvoice);
					$total_service = 0;
					$total_pkc = 0;
					$total_salary =  0;

					foreach ($listTransactionInvoice as $key => $value) :
						$name_service_type = $value['id_service_type'] ? CsServiceType::model()->findByPk($value['id_service_type'])->name : "";

						if(!isset($id_service_type)) {
							echo '<tr>
							<td colspan="11" style="text-align: center;"><h3>'.$name_service_type.'</h3></td>
							</tr>';
						} elseif ($value['id_service_type'] != $id_service_type) {
							echo '<tr>
							<td colspan="3"><h4>Total service: '.number_format($total_service,0,",",".").'</h4></td>
							<td colspan="4"><h4>Total PKC: '.number_format($total_pkc,0,",",".").'</h4></td>
							<td colspan="4"><h4>Total salary: '.number_format($total_salary,0,",",".").'</h4></td>
							</tr>';

							$total_service = 0;
							$total_pkc = 0;
							$total_salary = 0;

							echo '<tr>
							<td colspan="11" style="text-align: center;"><h3>'.$name_service_type.'</h3></td>
							</tr>';
						}

						$id_service_type = $value['id_service_type'];

						$customer = Customer::model()->findByPk($value['id_customer']);
						$gp_user  = GpUsers::model()->findByPk($value['id_user']);
						$pay_date = $value['pay_date'] ? date('d/m/Y',strtotime($value['pay_date'])) : "";

						if ($value['debt'] == TransactionInvoice::ThanhToan) {
							$total_service += $value['amount'];
							$total_salary += $value['amount'] * $value['percent'] / 100;
						} elseif ($value['debt'] == TransactionInvoice::PhongKhamChuyen) {
							$total_pkc += $value['amount'];
							$total_salary += $value['amount'] * $value['percent'] / 100;
						} elseif ($value['debt'] == TransactionInvoice::HoanTra) {
							$total_service -= $value['amount'];
							$total_salary -= $value['amount'] * $value['percent'] / 100;
						} elseif ($value['debt'] == TransactionInvoice::NHAN) {
							$total_service += $value['amount'];
							$total_salary += $value['amount'] * $value['percent'] / 100;
						} elseif ($value['debt'] == TransactionInvoice::CHUYEN) {
							$total_service += $value['amount'];
							$total_salary -= $value['amount'] * $value['percent'] / 100;
						}
			?>

			<tr style="color: <?php
					if($value['debt'] == TransactionInvoice::ThanhToan) {echo "green";}
					elseif ($value['debt'] == TransactionInvoice::ConNo) {echo "black";}
					elseif ($value['debt'] == TransactionInvoice::HoanTra) {echo "blue";}
					elseif ($value['debt'] == TransactionInvoice::Delay) {echo "#909090";}
					elseif ($value['debt'] == TransactionInvoice::NHAN) {echo "#f4c505";}
					elseif ($value['debt'] == TransactionInvoice::CHUYEN) {echo "#f4c505";}
					else {echo "red";}
				?>">
				<td><?php if($customer){echo $customer->code_number;}else echo "N/A"; ?></td>
				<td><?php if($customer){echo $customer->fullname;}else echo "N/A"; ?></td>
				<td><?php echo $value['description'];?></td>
				<td><?php echo $value['teeth'];?></td>
				<td><?php echo number_format($value['amount'],0,",",".");?></td>
				<td><?php if($gp_user){echo $gp_user->name;}else echo "N/A"; ?></td>
				<td><?php echo $value['percent'];?></td>
				<td><?php echo number_format($value['amount'] * $value['percent'] / 100,0,",",".");?></td>
				<td><?php echo $value['code'];?></td>
				<td><?php echo $pay_date;?></td>
				<td><?php
					if($value['debt'] == TransactionInvoice::ThanhToan) {echo "TT";}
					elseif ($value['debt'] == TransactionInvoice::ConNo) {echo "Nợ";}
					elseif ($value['debt'] == TransactionInvoice::HoanTra) {echo "TR";}
					elseif ($value['debt'] == TransactionInvoice::Delay) {echo "DL";}
					elseif ($value['debt'] == TransactionInvoice::NHAN) {echo "Nhận";}
					elseif ($value['debt'] == TransactionInvoice::CHUYEN) {echo "Chuyển";}
					else {echo "PKC";}
				?></td>
			</tr>

			<?php
						if ($i == $len - 1) {
							echo '<tr>
							<td colspan="3"><h4>Total service: '.number_format($total_service,0,",",".").'</h4></td>
							<td colspan="4"><h4>Total PKC: '.number_format($total_pkc,0,",",".").'</h4></td>
							<td colspan="4"><h4>Total salary: '.number_format($total_salary,0,",",".").'</h4></td>
							</tr>';
						}

						$i++;
					endforeach;
				else:
			?>

			<tr>
				<td colspan="11" style="text-align: center;"><?php echo "Không có dữ liệu!";?></td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>