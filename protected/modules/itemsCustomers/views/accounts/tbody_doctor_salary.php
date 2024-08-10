<?php
if (!empty($listTransactionInvoice)) :
	foreach ($listTransactionInvoice as $key => $value) :
		$id_service_type = $value['id_service_type'];
		$user   = GpUsers::model()->findByPk($value['id_user']);
		$name_user = ($user) ? $user->name : '';
		$create_date = date('d/m/Y', strtotime($value['create_date']));
		$pay_date    = $value['pay_date'] ? date('d/m/Y', strtotime($value['pay_date'])) : "";
		?>


<tr style="color: <?php
	if ($value['debt'] == TransactionInvoice::ThanhToan) { echo "green"; }
	elseif ($value['debt'] == TransactionInvoice::ConNo) { echo "black"; }
	elseif ($value['debt'] == TransactionInvoice::HoanTra) { echo "blue"; }
	elseif ($value['debt'] == TransactionInvoice::Delay) { echo "#909090"; }
	elseif ($value['debt'] == TransactionInvoice::NHAN) { echo "#f4c505"; }
	elseif ($value['debt'] == TransactionInvoice::CHUYEN) { echo "#f4c505"; }
	elseif ($value['debt'] == TransactionInvoice::KhuyenMai) { echo "green"; }
	else { echo "red"; }
?>">

	<td><?php echo $value['code']; ?></td>

	<td><?php echo $value['description']; ?></td>

	<td><?php echo number_format($value['amount'], 0, ",", "."); ?></td>

	<td><?php echo $name_user; ?></td>

	<td><?php $code_invoice = Invoice::model()->findByPk($value['id_invoice']);
				echo ($code_invoice) ? $code_invoice->code : "";
				//echo Invoice::model()->findByPk($value['id_invoice'])->code;
				?>
	</td>

	<td><?php echo $create_date; ?></td>
	<td><?php echo $pay_date; ?></td>
	<td>
		<?php
			if ($value['debt'] == TransactionInvoice::ThanhToan) { echo "TT"; }
			elseif ($value['debt'] == TransactionInvoice::ConNo) { echo "Nợ"; }
			elseif ($value['debt'] == TransactionInvoice::HoanTra) { echo "TR"; }
			elseif ($value['debt'] == TransactionInvoice::Delay) { echo "DL"; }
			elseif ($value['debt'] == TransactionInvoice::NHAN) { echo "Nhận"; }
			elseif ($value['debt'] == TransactionInvoice::CHUYEN) { echo "Chuyển"; }
			elseif ($value['debt'] == TransactionInvoice::KhuyenMai) { echo "KM"; }
			else { echo "PKC"; }
		?>
	</td>

	<td class="hide">
		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#updateTransactionInvoiceModal" onclick="setTransactionInvoiceModal(<?php echo $value['id'] . ',' . $value['id_user'] . ',' . "'" . $name_user . "'" . ',' . $value['id_service'] . ',' . "'" . $value['description'] . "'" . ',' . $value['amount'] . ',' . $value['percent'] . ',' . "'" . $create_date . "'" . ',' . "'" . $pay_date . "'" . ',' . $value['debt'] . ',' . $value['id_service_type_tk']; ?>);">
			<span class="glyphicon glyphicon-pencil"></span>
		</button>
		<button type="button" class="btn btn-default" onclick="deleteTransactionInvoice(<?php echo $value['id']; ?>);">
			<span class="glyphicon glyphicon-trash"></span>
		</button>
	</td>
</tr>

<?php
	endforeach;
else :
?>

<tr>
	<td colspan="9"><?php echo "Không có dữ liệu!"; ?></td>
</tr>

<?php endif; ?>

<script type="text/javascript">
	$('#tbody_doctor_salary tr').hover(function() {
		$(this).children().last().removeClass('hide');
	}, function() {
		$(this).children().last().addClass('hide');
	});
</script>