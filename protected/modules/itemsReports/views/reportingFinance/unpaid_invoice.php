
<div class="col-md-12 margin-top-20" id="return_content">
<p class="title-report tt">HÓA ĐƠN CHƯA THANH TOÁN</p>
<p class="time-report">
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
	
	<div class="table table-responsive">
	  <table class="table table-bordered table-hover">
	  	<thead class="headertable">
	  		<tr>
	  			<th>Mã số</th>
	  			<th colspan="">Ngày xuất</th>
	  			<th colspan="">Ngày hết hạn</th>
	  			<th colspan="">Khách hàng</th>
	  			<th>Người xuất</th>
	  			<th>Tổng tiền</th>
	  			<th>Đã thanh toán</th>
	  			<th colspan="" >Còn lại</th>
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<?php if ($invoiceList == -2): ?>
			    <tr><td colspan="8" rowspan="" headers="">Không có dữ liệu!</td></tr>
			<?php else: ?>
				<?php foreach ($invoiceList as $key => $v): ?>
				
			  		<tr class="sort-field">
			  			<td><?php echo $v['code']; ?></td>
			  			<td><?php echo $v['create_date'];?></td>
			  			<td><?php echo $v['complete_date']; ?></td>
			  			<td><?php $id_customer = $v['id_customer'];
							$customer = Customer::model()->findByPk($id_customer); 
							echo $customer->fullname;
							?></td>
			  			<td><?php echo $v['author_name'];?></td>
			  			
			  			<td class="autoNum"><?php echo $v['sum_amount'];?></td>
			  			
			  			<td class="autoNum"><?php echo($v['sum_amount'] - $v['balance'] );?></td>
			  			<td class="autoNum"><?php echo $v['balance'];?></td>
			  		</tr>
				<?php endforeach ?>
			<?php endif ?>
			  		<tr>
			  			<td  colspan="8" style="text-align: center;">Tổng : <?php echo $count;?> (Hóa đơn)</td>
			  		
			  			
			  		</tr>
	  	</tbody>
	  </table>
	</div>
	<!--table excel -->
	<div class="table table-responsive" style="display: none">
	  <table class="table table-bordered table-hover" id="list_export">
	  	<thead class="headertable">
	  		<tr>
	  			<th>Mã số</th>
	  			<th colspan="">Ngày xuất</th>
	  			<th colspan="">Ngày hết hạn</th>
	  			<th colspan="">Khách hàng</th>
	  			<th>Người xuất</th>
	  			<th>Tổng tiền</th>
	  			<th>Đã thanh toán</th>
	  			
	  			<th colspan="" >Còn lại</th>
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<?php if ($exportList == -2): ?>
			    <tr><td colspan="8" rowspan="" headers="">Không có dữ liệu!</td></tr>
			<?php else: ?>
				<?php foreach ($exportList as $key => $val): ?>
				
			  		<tr class="sort-field">
			  			<td><?php echo $val['code']; ?></td>
			  			<td><?php echo $val['create_date'];?></td>
			  			<td><?php echo $val['complete_date']; ?></td>
			  			<td><?php $id_cus = $val['id_customer'];
							$cus = Customer::model()->findByPk($id_cus); 
							echo $cus->fullname;
							?></td>
			  			<td><?php echo $val['author_name'];?></td>
			  			
			  			<td class="autoNum"><?php echo $val['sum_amount'];?></td>
			  			
			  			<td class="autoNum"><?php echo($val['sum_amount'] - $val['balance'] );?></td>
			  			<td class="autoNum"><?php echo $val['balance'];?></td>
			  		</tr>
				<?php endforeach ?>
			<?php endif ?>
			 
	  	</tbody>
	  </table>
	</div>
	</div>
<script type="text/javascript">
$(function(){
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('.autoNum').autoNumeric('init',numberOptions);
});

</script>
