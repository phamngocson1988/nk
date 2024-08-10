<style type="text/css">
	.green td {
		color: green !important;
	}
	.red td, .red td a {
		color: red !important;
	}

	#page.pagination>li>a,
	#page.pagination>li>span {
		position: relative;
		float: left;
		padding: 6px 12px;
		margin-left: -1px;
		line-height: 1.42857143;
		color: #337ab7;
		text-decoration: none;
		background-color: #fff;
		border: 1px solid #ddd;
	}

	.info {
		margin: 10px 0;
	}
</style>

<?php
	$stringInvoice = ""; $stringReceipt = ""; $stringPromotion = "";

	foreach ($dataReceipt as $key => $value) {
		$stringReceipt .= '<tr class="green">';
		$stringReceipt .= '<td>' . date("Y-m-d", strtotime($value["pay_date"])) . '</td>';
		$stringReceipt .= '<td>TT</td>';
		$stringReceipt .= '<td>' . Invoice::$invoice_type[$value["pay_type"]] . '</td><td></td>';
		$stringReceipt .= '<td>' . number_format($value["pay_amount"], 0, ",", ".") . '</td><td></td></tr>';

		if ($value['pay_promotion'] > 0) {
			$stringPromotion .= '<tr class="red">';
			$stringPromotion .= '<td>' . date("Y-m-d", strtotime($value["pay_date"])) . '</td>';
			$stringPromotion .= '<td>KM</td>';
			$stringPromotion .= '<td><a href="'.Yii::app()->baseUrl.'/itemsSales/invoices/View?id='.$value['id_invoice'].'">' . $value['code'] . '</a></td><td></td>';
			$stringPromotion .= '<td>' . number_format($value["pay_promotion"], 0, ",", ".") . '</td><td></td></tr>';
		}
	}

	foreach ($dataInvoice as $key => $value) {
		$stringInvoice .= "<tr>";
		$stringInvoice .= "<td>" . $value["create_date"] . "</td>";
		$stringInvoice .= "<td>" . $value["code"] . "</td>";
		$stringInvoice .= "<td>" . $value["name"] . "</td>";
		$stringInvoice .= "<td>" . $value["teeth"] . "</td>";
		$stringInvoice .= "<td>" . number_format($value["amount"] , 0, ",", ".") . "</td>";
		$stringInvoice .= "<td>" . $value["nameDoctor"] . "</td>";

		$stringInvoice .= "</tr>";
	}
?>

<div class="info">
	<div class="col-md-2">
		<label>Tổng chi phí: </label> <?php echo number_format($sumAmount, 0, ",", "."); ?>
	</div>

	<div class="col-md-2">
		<label>Thanh toán: </label> <?php echo number_format($sumPayAmount, 0, ",", "."); ?>
	</div>

	<div class="col-md-2">
		<label>Khuyến mãi: </label> <?php echo number_format($sumPromotionAmount, 0, ",", "."); ?>
	</div>

	<div class="col-md-2">
		<label>Hoàn Trả: </label> <?php echo number_format($sumRefundAmount, 0, ",", "."); ?>
	</div>

	<div class="col-md-2">
		<label>Còn nợ: </label> <?php echo number_format($sumDebtAmount, 0, ",", "."); ?>
	</div>

	<div class="clearfix"></div>
</div>

<div class="table">
	<div class="col-md-12 table-responsive">
		<table class="table table-bordered table-inv">
			<thead style="background: #8ca7ae; color: white;">
				<tr>
					<th>Ngày</th>
					<th>Mã DV</th>
					<th>Tên DV</th>
					<th>Răng</th>
					<th>Chi phí</th>
					<th>Bác sĩ</th>
				</tr>
			</thead>

			<tbody style="background: #f1f5f6; color: black;">
				<?php echo $stringPromotion . $stringReceipt . $stringInvoice; ?>
			</tbody>
		</table>
	</div>
</div>