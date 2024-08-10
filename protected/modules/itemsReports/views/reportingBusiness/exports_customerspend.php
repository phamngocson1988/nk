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
	<p style="text-align: center;font-size: 20px;">CHI TIÊU CỦA KHÁCH HÀNG</p>
	<p style="text-align: right;">
		<?php if($search_time == "1"){
		$fromdate = date("d-m-Y");
		$todate= "";
		echo $fromdate;
	} elseif($search_time == "2"){
		$fromdate = date("d-m-Y",strtotime('monday this week'));
		$todate= date("d-m-Y",strtotime('sunday this week'));
		echo $fromdate .' đến '.$todate;
	}elseif($search_time == "3"){
		 $fromdate = date("01-m-Y", strtotime("first day of this month"));
		 $todate= date("t-m-Y", strtotime("last day of this month"));
		 echo $fromdate .' đến '.$todate;
	}elseif($search_time == "4"){
		$fromdate = date("d-m-Y", strtotime('first day of last month'));
    	$todate= date("d-m-Y", strtotime('last day of last month'));
		echo $fromdate .' đến '.$todate;
	}else{
		echo $fromtime .' đến '.$totime;
	}
	?>,
	<?php if($branch == ""){
		echo "Tất cả vị trí";
	} else{
		$branchList =  Branch::model()->findByPk($branch);
		echo 'Văn phòng:'.$branchList->name;
	}?>,
	<?php if($user == ""){
		echo "Tất cả nhân viên";
	} else{
		$userList =  GpUsers::model()->findByPk($user);
		echo 'Bác sĩ:'.$userList->name;
	}?>
	</p>
	<div style="margin-top: 20pt; width: 100%;" >
	 	<table class="ivDt">
		  	<thead>
		  		<tr>
		  			<th style="width:16%">Khách hàng</th>
		  			<th style="width:7%">Số lịch hẹn</th>
		  			<th style="width:7%">Số dịch vụ</th>
		  			<th style="width:14%">Báo giá</th>
		  			<th style="width:14%">Hóa đơn</th>
		  			<th style="width:14%">Khuyến mãi</th>
		  			<th style="width:14%">Thanh toán</th>
		  			<th style="width:14%">Công nợ</th>
		  		</tr>
			</thead>
			<tbody>
			<?php foreach ($lstCustomer as $value): ?>
				<tr>
					<td><?php echo $value['fullname']; ?></td>
					<td><?php echo $value['totalSchedule']; ?></td>
					<td><?php echo $value['totalService']; ?></td>
					<td><?php echo ($value['sum_amount'])?number_format($value['sum_amount'],0, ',', '.').' vnđ':'0'; ?></td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
				</tr>
			<?php endforeach ?>		
				<tr>
					<td>Tổng</td>
					<td><?php echo $dataTotal['total_Schedule']; ?></td>
					<td><?php echo $dataTotal['total_Service']; ?></td>
					<td><?php echo ($dataTotal['total_Quotation'])?number_format($dataTotal['total_Quotation'],0, ',', '.').' vnđ':'0'; ?></td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
				</tr>
			</tbody>
		</table>
	</div>
</page>