<style type="text/css">
	p, a, td {
		word-wrap: break-word;
		font-size: 10pt;
	}

	.ivDt {
		width: 100%;
		border-collapse: collapse;
	}

	.ivDt thead tr {
		background: #8FAAB1;
		font-size: 10pt;
	}

	.ivDt thead th, .ivDt tbody td {
		padding: 8px auto;
		text-align: center;
		color: #fff;
		border: 1px solid #ccc;
	}

	.ivDt tbody td {
		color: #000;
	}
</style>

<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" format="Letter" backcolor="#fff" style="font: arial;font-family:freeserif ;">

	<div style="margin-top: 20pt; width: 100%;" >
	 	<table class="ivDt">

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
			  	<?php if (isset($listTransactionInvoice) && !empty($listTransactionInvoice)): ?>
					<?php $i = 0; ?>
					<?php $len = count($listTransactionInvoice); ?>
					<?php $total_service = 0; $total_salary =  0; ?>

					<?php foreach ($listTransactionInvoice as $key => $value): ?>
						<?php $name_service_type = $value['id_service_type'] ? CsServiceType::model()->findByPk($value['id_service_type'])->name : ""; ?>

						<?php if (!isset($id_service_type)): ?>
							<tr><td colspan="11" style="text-align: center;"><h3><?php echo $name_service_type; ?></h3></td></tr>
						<?php else : ?>
							<tr>
								<td colspan="5"><h4>Total service: <?php echo number_format($total_service,0,",","."); ?></h4></td>
								<td colspan="6"><h4>Total salary: <?php echo number_format($total_salary,0,",","."); ?></h4></td>
							</tr>

							<?php $total_service = 0; $total_salary = 0; ?>

							<tr><td colspan="11" style="text-align: center;"><h3><?php echo $name_service_type; ?></h3></td></tr>
						<?php endif; ?>

						<?php $id_service_type = $value['id_service_type']; ?>

						<?php $customer = Customer::model()->findByPk($value['id_customer']); ?>

						<?php $code_number = ($customer) ? $customer->code_number: ''; ?>
						<?php $name_customer = ($customer) ? $customer->fullname: ''; ?>

						<?php $user = GpUsers::model()->findByPk($value['id_user']); ?>

						<?php $name_user = ($user) ? $user->name : ''; ?>
						<?php $pay_date = $value['pay_date'] ? date('d/m/Y',strtotime($value['pay_date'])) : ""; ?>

						<?php if ($value['debt'] == 0): ?>
							<?php $total_service += $value['amount']; ?>
							<?php $total_salary += $value['amount'] * $value['percent'] / 100; ?>
						<?php elseif ($value['debt'] == 2) : ?>
							<?php $total_salary += $value['amount'] * $value['percent'] / 100; ?>
						<?php endif; ?>

						<tr>
							<td><?php echo $code_number;?></td>
							<td><?php echo $name_customer;?></td>
							<td><?php echo $value['description'];?></td>
							<td><?php echo $value['teeth'];?></td>
							<td><?php echo number_format($value['amount'],0,",",".");?></td>
							<td><?php echo $name_user;?></td>
							<td><?php echo $value['percent'];?></td>
							<td><?php echo number_format($value['amount'] * $value['percent'] / 100,0,",",".");?></td>
							<td><?php echo Invoice::model()->findByPk($value['id_invoice'])->code;?></td>
							<td><?php echo $pay_date;?></td>
							<td><?php if($value['debt'] == 0) echo "Đã thanh toán"; elseif($value['debt'] == 1) echo "Nợ"; else echo "Phòng khám chuyển";?></td>
						</tr>

						<?php if ($i == $len - 1): ?>
							<tr>
								<td colspan="5"><h4>Total service: <?php echo number_format($total_service,0,",","."); ?></h4></td>
								<td colspan="6"><h4>Total salary: <?php echo number_format($total_salary,0,",","."); ?></h4></td>
							</tr>
						<?php endif; ?>
						<?php $i++; ?>
					<?php endforeach; ?>
				<?php else : ?>
					<tr><td colspan="11" style="text-align: center;"><?php echo "Không có dữ liệu!";?></td></tr>
				<?php endif; ?>
		  	</tbody>
		</table>
	</div>
</page>