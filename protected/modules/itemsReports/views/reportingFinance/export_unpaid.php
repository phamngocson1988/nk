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
<?php 
    $dt =  date("d-m-Y");  
    $from = date("d-m-Y", strtotime('first day of this month'));
    $to= date("d-m-Y", strtotime('last day of this month'));
?>
<page backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm" format="Letter" backcolor="#fff" style="font: arial;font-family:freeserif ; margin-top:50px;">
	<p style="text-align: center;font-size: 20px;margin-top:50px;">HÓA ĐƠN CHƯA THANH TOÁN</p>
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
		  	<thead >
		  		<tr>
		  			<th style="width: 8%">Mã số</th>
		  			<th style="width: 10%">Ngày xuất</th>
		  			<th style="width: 10%">Ngày hết hạn</th>
		  			<th style="width: 15%">Khách hàng</th>
		  			<th style="width: 15%">Người xuất</th>
		  			<th style="width: 14%">Tổng tiền</th>
		  			<th style="width: 14%">Đã thanh toán</th>
		  			<th style="width: 14%">Còn lại</th>
		  		</tr>
		  	</thead>
		  	<tbody>

				<?php
				 	foreach ($exportList as $key => $v): ?>
					<tr class="sort-field">
			  			<td><?php echo $v['code']; ?></td>
			  			<td><?php echo date_format(date_create($v['create_date']),'d-m-Y'); ?></td>
			  			<td><?php echo date_format(date_create($v['complete_date']),'d-m-Y'); ?></td>
			  			<td><?php $id_customer = $v['id_customer'];
							$customer = Customer::model()->findByPk($id_customer); 
							echo $customer->fullname;
							?></td>
			  			<td><?php echo $v['author_name'];?></td>
			  			<td><?php echo number_format(($v['sum_amount']),0,'','.');?></td>
			  			<td><?php echo number_format(($v['sum_amount'] - $v['balance'] ),0,'','.');?></td>
			  			<td><?php echo number_format(($v['balance']),0,'','.');?></td>
			  		</tr>
				<?php endforeach ?>
		  	</tbody>
		</table>
	</div>

 </page>