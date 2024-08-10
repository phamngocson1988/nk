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
	<p style="text-align: center;font-size: 20px;">DOANH THU DỊCH VỤ</p>
	
	<div style="margin-top: 20pt; width: 100%;" >
	 	<table class="ivDt">
		  	<thead >
		  		<tr>
		  			  <th style="width: 25% ">Dịch vụ</th>
				      <th style="width: 10% ">Số lịch hẹn</th>
				      <th style="width: 10% ">Thời lượng</th>
				      <th style="width: 10% ">Số khách hàng</th>
				      <th style="width: 15% ">Số lượng</th>
				      <th style="width: 10% ">Đơn giá</th>
				      <th style="width: 15% ">Doanh thu</th>
		  		</tr>
			</thead>
			<tbody>
		    <?php if(!$listService){?>
		       <tr>
		        <td colspan="6">Chưa có dữ liệu</td>
		      </tr>
		    <?php
		        }else {
		        	  $totalSchedule_1        = 0;
			          $lenghtSchedule_1       =0;
			          $totalCustomerService_1 = 0;
			          $totalServices_1        = 0;
			          $totalInvoiceService_1  = 0;
		        foreach ($listService as $value) { ?>
		          <tr>
		         <?php if($value['totalServices'] >0){
		         		$totalSchedule_1        += $value['totalSchedule'];
			            $lenghtSchedule_1       += $value['lenghtSchedule'];
			            $totalCustomerService_1 += $value['totalCustomerService'];
			            $totalServices_1        += $value['totalServices'];
			            $totalInvoiceService_1  += $value['totalInvoiceService'];
		         ?>
			            <td style="width: 25% "><?php echo $value['name']; ?></td>
			            <td><?php echo $value['totalSchedule']; ?></td>
			            <td><?php if($value['lenghtSchedule']){echo $value['lenghtSchedule'].' phút';}else { echo "0 phút";} ?></td>
			            <td><?php if($value['totalCustomerService']){echo $value['totalCustomerService'];}else { echo "0 ";} ?> </td>
			            <td><?php if($value['totalServices']){echo $value['totalServices'];}else { echo "0 ";} ?></td>
			            <td><?php echo ($value['price'])?number_format($value['price'],0, ',', '.').' VND':'0 '; ?></td>
			            <td><?php echo ($value['totalInvoiceService'])?number_format($value['totalInvoiceService'],0, ',', '.').' VND':'0 VND'; ?></td>
		         <?php }?>
		           </tr>
		       <?php }} ?>
		       		 <tr>
			            <td style="width: 25% ">Tổng</td>
			            <td><?php echo $totalSchedule_1; ?></td>
			            <td><?php if($lenghtSchedule_1){echo $lenghtSchedule_1;}else{ echo "0" ;} ?> phút</td>
			            <td><?php if($totalCustomerService_1){echo $totalCustomerService_1;}else{ echo "0" ;}  ?></td>
			            <td><?php if($totalServices_1){echo $totalServices_1;}else{ echo "0" ;}  ?></td>
			            <td>N/A</td>
			            <td><?php echo ($totalInvoiceService_1)?number_format($totalInvoiceService_1,0, ',', '.').' VND':'0 VND'; ?></td>
			        </tr>
		    </tbody>
		</table>
	</div>
</page>