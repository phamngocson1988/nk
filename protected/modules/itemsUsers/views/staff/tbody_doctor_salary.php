<?php
	if (!empty($listTransactionInvoice)) :
		$doctor_salary = 0;

		foreach ($listTransactionInvoice as $key => $value) :
			$name_customer = Customer::model()->findByPk($value['id_customer'])->fullname;
			$create_date = date('d/m/Y', strtotime($value['create_date']));
			$pay_date = $value['pay_date'] ? date('d/m/Y', strtotime($value['pay_date'])) : "";

			if ($value['debt'] == 0) {
				$doctor_salary += $value['amount'] * $value['percent'] / 100;
			}
?>

	<tr>
	  	<td><?php if($value['id_service_type_tk']) echo CsServiceTypeTk::model()->findByPk($value['id_service_type_tk'])->name;?></td>
	  	<td><?php echo $name_customer;?></td>
	  	<td><?php echo $value['description'];?></td>

	  <td><?php echo number_format($value['amount'],0,",",".");?></td>

	  <td><?php echo GpUsers::model()->findByPk($value['id_user'])->name;?></td>

	  <td><?php echo Invoice::model()->findByPk($value['id_invoice'])->code;?></td>

	  <td><?php echo $create_date;?></td>

	  <td><?php echo $pay_date;?></td>

	  <td><?php if($value['debt'] == 1) echo "Nợ"; else echo "Đã thanh toán";?></td>

	 <?php /* <td><?php if($value['type'] == 1) echo "Thu";?></td> */ ?>
		<td>
			<button type="button" class="btn btn-default" data-toggle="modal" data-target="#updateTransactionInvoiceModal" onclick="setTransactionInvoiceModal(<?php echo $value['id'] . ',' . $value['id_customer'] . ',' . "'" .$name_customer. "'" . ',' . $value['id_service'] . ',' . "'" .$value['description']. "'" . ',' . $value['amount'] . ',' . $value['percent'] . ',' . "'" .$create_date. "'" . ',' . "'" .$pay_date. "'" . ',' . $value['debt'];?>);">
			  <span class="glyphicon glyphicon-pencil"></span>
			</button>
			<button type="button" class="btn btn-default" onclick="deleteTransactionInvoice(<?php echo $value['id'];?>);">
			  <span class="glyphicon glyphicon-trash"></span>
			</button>
		</td>
	</tr>

<?php

  endforeach;


?>

        <tr>

          <td colspan="5">Lương bác sĩ:</td>

          <td colspan="5"><?php echo number_format($doctor_salary,0,",",".");?></td>

        </tr>

  <?php

  else:


  ?>

  <tr>

    <td colspan="10"><?php echo "Không có dữ liệu!";?></td>

  </tr>

  <?php

  endif;

  ?>
