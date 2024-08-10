<style type="text/css">
p, a, td {
	word-wrap: break-word;
    font-size: 10pt;
}
.ivDt {
	width: 100%;
	border-collapse: collapse;
}
.ivDt thead tr{
	background: #8FAAB1;
	font-size: 10pt;
}
.ivDt thead th, .ivDt tbody td{
	padding: 8px auto;
	text-align: center;
	color: #fff;
	border: 1px solid #ccc;
}
.ivDt tbody td{
	color: #000;	
}
</style>
<page backtop="15mm" backbottom="5mm" backleft="10mm" backright="10mm" format="Letter" backcolor="#fff" style="font: arial;font-family:freeserif ; margin-top:50px;">
	<p style="text-align: center;font-size: 20px;">TÓM TẮT HOẠT ĐỘNG TRONG THÁNG</p>
	<?php 
		$search_month = explode(',', $s_month);
	?>
	<p style="text-align: right;">
	<?php  if($search_month){foreach ($search_month as $key => $val) { echo 'Tháng '.$val.'-'.$search_year.','; }} ?>
	<?php if($id_branch == ""){
		echo "Tất cả vị trí";
	} else{
		$branchList =  Branch::model()->findByPk($id_branch);
		echo 'Văn phòng:'.$branchList->name;
	}?>,
	<?php if($search_user == ""){
		echo "Tất cả nhân viên";
	}?>
	</p>
	<div style="margin-top: 20pt; width: 100%;" >
	 	<table class="ivDt">
		  	<thead >
		  		<tr>
		  			<th></th>
		  			<?php  foreach ($search_month as $key => $v) { ?>
		  			<th><?php echo 'Tháng '.$v.'-'.$search_year;?></th>
		  			<?php }?>
		  			<th>Tổng</th>
		  		</tr>
			</thead>
			<tbody>
				<tr>
					<td>Tổng số lịch hẹn</td>
					<?php 
						$totalSchedule= 0;
						foreach ($search_month as $key => $v) {
						$totalSchedule_month = CsSchedule::model()->getTotalSchedule($id_branch,$v,$search_year);
						$totalSchedule += $totalSchedule_month;
					?>

					<td><?php echo $totalSchedule_month; ?></td>	
					<?php } ?>
					<td><?php echo $totalSchedule;?></td>
				</tr>
				<tr>
					<td>Tổng số khách hàng mới</td>
					<?php 
						$getNewCustomer= 0;
						foreach ($search_month as $key => $v) {
						$getNewCustomerByMonth =VSchedule::model()->getNewCustomerByMonth($id_branch,$v,$search_year);
						$getNewCustomer += $getNewCustomerByMonth;
					?>

					<td><?php echo $getNewCustomerByMonth; ?></td>	
					<?php } ?>
					<td><?php echo  $getNewCustomer; ?></td>
				</tr>
				<tr>
					<td>Tổng số báo giá</td>
					<?php 
						$totalQuotation= 0;
						foreach ($search_month as $key => $v) {
						$totalQuotationMonth =VQuotations::model()->totalQuotation('count',$id_branch,$v,$search_year,'');
						$totalQuotation += $totalQuotationMonth[0]['totalQuotation'];
			 		?>

					<td><?php echo $totalQuotationMonth[0]['totalQuotation']; ?></td>	
					<?php } ?>
					<td><?php echo  $totalQuotation; ?></td>
				</tr>
				<tr>
					<td>Tổng giá trị báo giá</td>
					<?php 
						$totalSumAmount_VND= 0;
						foreach ($search_month as $key => $v) {
						$amount_VND =VQuotations::model()->totalQuotation('sum',$id_branch,$v,$search_year,'VND');
						$totalSumAmount_VND += $amount_VND[0]['totalSumAmount'];
					?>
					<td>
						<?php echo ($amount_VND[0]['totalSumAmount'])?number_format($amount_VND[0]['totalSumAmount'],0, ',', '.'):'0';?>    	
					</td>	
					<?php } ?>
					<td>
						<?php echo ($totalSumAmount_VND)?number_format($totalSumAmount_VND,0, ',', '.'):'0 ';?>
					</td>
				</tr>
				<tr>
					<td>Tổng số điều trị</td>
					<?php 
						$totalTreatment = 0;
						foreach ($search_month as $key => $v) {
						$totalTreatmentMonth= CsSchedule::model()->getTotalTimesCure($id_branch,"",$v,$search_year);
						$totalTreatment +=$totalTreatmentMonth;
					?>
					<td><?php echo $totalTreatmentMonth;?></td>	
					<?php } ?>
					<td><?php echo $totalTreatment;?></td>
				</tr>
				<tr>
					<td>Tổng số điều trị hoàn tất</td>
					<?php 
						$totalTreatmentComplete = 0;
						foreach ($search_month as $key => $v) {
						$totalTreatmentCompleteMonth= CsSchedule::model()->getTotalTimesCure($id_branch,4,$v,$search_year);
						$totalTreatmentComplete +=$totalTreatmentCompleteMonth;
					?>
					<td><?php echo $totalTreatmentCompleteMonth;?></td>	
					<?php } ?>
					<td><?php echo $totalTreatmentComplete;?></td>
				</tr>
				<tr>
					<td>Tổng số giờ điều trị</td>
					<?php 
						$totalTimeCure = 0;
						foreach ($search_month as $key => $v) {
						$totalTimeMonth = CsSchedule::model()->getTotalTimeCure($id_branch,$v,$search_year);
						$totalTimeCure += $totalTimeMonth;
					?>
					<td><?php echo $totalTimeMonth; ?> phút</td>	
					<?php } ?>
					<td><?php echo $totalTimeCure; ?> phút</td>
				</tr>
				<tr>
					<td>Tổng giá trị điều trị</td>
					<?php 
						foreach ($search_month as $key => $v) {
					?>
					<td>N/A</td>	
					<?php } ?>
					<td>N/A</td>
				</tr>
				<tr>
					<td>Tổng giá trị hóa đơn</td>
					<?php 
						$totalInvoice_VND = 0;
						foreach ($search_month as $key => $v) {
						$totalInvoiceMonth_VND = VReceipt::model()->totalValueInvoice($id_branch,$v,$search_year);
						$totalInvoice_VND += $totalInvoiceMonth_VND;
					?>
					<td> 
						<?php echo ($totalInvoiceMonth_VND)?number_format($totalInvoiceMonth_VND,0, ',', '.'):'0';?>
					</td>	
					<?php } ?>
					<td>
						<?php echo ($totalInvoice_VND)?number_format($totalInvoice_VND,0, ',', '.'):'0';?>
					</td>
				</tr>
				<tr>
					<td>Tổng giá trị thanh toán</td>
					<?php 
						$totalReceipt_VND = 0;
						foreach ($search_month as $key => $v) {
						$totalReceiptMonth_VND = VReceipt::model()->totalValueReceipt($id_branch,$v,$search_year);
						$totalReceipt_VND += $totalReceiptMonth_VND;
					?>
					<td>
						<?php echo ($totalReceiptMonth_VND)?number_format($totalReceiptMonth_VND,0, ',', '.'):'0';?>
					</td>
					<?php } ?>
					<td>
						<?php echo ($totalReceipt_VND)?number_format($totalReceipt_VND,0, ',', '.'):'0';?>
					</td>
				</tr>
				<tr>
					<td>Tổng giá trị công nợ</td>
					<?php 
						$totalBalance_VND = 0;
						foreach ($search_month as $key => $v) {
						$totalBalanceMonth_VND = VReceipt::model()->totalValueBalance($id_branch,$v,$search_year);
						$totalBalance_VND += $totalBalanceMonth_VND;
					?>
					<td>
						<?php echo ($totalBalanceMonth_VND)?number_format($totalBalanceMonth_VND,0, ',', '.'):'0';?>
					</td>	
					<?php } ?>
					<td>
						<?php echo ($totalBalance_VND)?number_format($totalBalance_VND,0, ',', '.'):'0';?>
					</td>

				</tr>
				<tr>
					<td>Tổng giá trị bán hàng</td>
					<?php 
						foreach ($search_month as $key => $v) {
					?>
					<td>N/A</td>	
					<?php } ?>
					<td>N/A</td>
				</tr>
				<tr class="total">
					<td>Tổng</td>
					<?php 
						foreach ($search_month as $key => $v) {
					?>
					<td>N/A</td>	
					<?php } ?>
					<td>N/A</td>
				</tr>
			</tbody>
		</table>
	</div>
</page>