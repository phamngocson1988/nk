<?php $baseUrl = Yii::app()->baseUrl; 
	$today = date('m/d/Y ');
  $month = strtotime(date("m/d/Y", strtotime($today)) . " +1 month");
  $month = strftime("%m/%d/%Y", $month);
?> 

<div class="col-md-12 margin-top-20" id="return_content">
<p class="title-report tt">Tóm lược giao dịch</p>
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
	<!-- <hr style="border: 1px solid #484848;"> -->
	<div class="table table-responsive">
	 <table class="table table-bordered table-hover" >
	  	<thead class="headertable" >
	  		<tr>
	  			<th>STT </th>
	  			<th colspan="">Số hóa đơn</th>
	  			<th colspan="">Loại hình</th>
	  			<th colspan="">Số tiền</th>
	  			<th>Ngày giao dịch</th>
	  			<th>Người nhận</th>
	  			<th colspan="" >Khách hàng</th>
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<?php if ($receiptList == -2): ?>
			    <tr><td colspan="7" rowspan="" headers="">Không có dữ liệu!</td></tr>
			<?php else: ?>
				<?php 
				$i =0;
				foreach ($receiptList as $key => $v): ?>
		  		<tr>
		  			<td><?php echo ++$i; ?></td>
		  			<td><?php echo $v['code'];?></td>
		  			<td><?php if($v['pay_type']==1){echo 'Tiền mặt';}
		  					  elseif($v['pay_type']==2){echo 'Thẻ tín dụng';}
		  					  elseif($v['pay_type']==3){echo 'Chuyển khoản';}
		  					  elseif($v['pay_type']==4){echo 'Bảo hiểm';} ?></td>
		  			<td class="autoNum"><?php echo $v['pay_amount'];?></td>
		  			<td><?php echo $v['pay_date'];?></td>
		  			<td>
		  				<?php $id_author = $v['id_author'];
						$author = GpUsers::model()->findByPk($id_author); 
						echo $author->name;
						?>
		  			</td>
		  			<td>
			  			<?php $id_customer = $v['id_customer'];
						$customer = Customer::model()->findByPk($id_customer); 
						if(!$customer){
							echo "N/A";
						}else{
							echo $customer->fullname;
						}
						?>
					</td>
		  			
		  		</tr>

		  	<?php endforeach ?>
	  	<?php  endif ?>
	  			<tr>
			  		<td  colspan="7" style="text-align: center;">Tổng : <?php echo $count;?>(Lượt giao dịch)</td>	
			  	</tr>
	  	</tbody>
	  </table>
	</div>
	<!-- table excel-->
	<div class="table table-responsive" style="display: none;">
	 <table class="table table-bordered table-hover" id="list_export">
	  	<thead class="headertable">
	  		<tr>
	  			<th>STT </th>
	  			<th colspan="">Số hóa đơn</th>
	  			<th colspan="">Loại hình</th>
	  			<th colspan="">Số tiền</th>
	  			<th>Ngày giao dịch</th>
	  			<th>Người nhận</th>
	  			<th colspan="" >Khách hàng</th>
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<?php if ($exportList == -2): ?>
			    <tr><td colspan="7" rowspan="" headers="">Không có dữ liệu!</td></tr>
			<?php else: ?>
				<?php 
				$i =0;
				foreach ($exportList as $key => $val): ?>
		  		<tr>
		  			<td><?php echo ++$i; ?></td>
		  			<td><?php echo $val['code'];?></td>
		  			<td><?php if($val['pay_type']==1){echo 'Tiền mặt';}
		  					  elseif($val['pay_type']==2){echo 'Thẻ tín dụng';}
		  					  elseif($val['pay_type']==3){echo 'Chuyển khoản';}
		  					  elseif($val['pay_type']==4){echo 'Bảo hiểm';} ?></td>
		  			<td class="autoNum"><?php echo $val['pay_amount'];?></td>
		  			<td><?php echo $val['pay_date'];?></td>
		  			<td>
		  				<?php $id_aut = $val['id_author'];
						$aut = GpUsers::model()->findByPk($id_aut); 
						echo $aut->name;
						?>
		  			</td>
		  			<td>
			  			<?php  $id_cus = $val['id_customer'];
						 $cus = Customer::model()->findByPk($id_cus); 
						 if(!$cus){
						 	echo "N/A";
						 }else
						 	echo $cus->fullname;
						?>
					</td>
		  			
		  		</tr>

		  	<?php endforeach ?>
	  	<?php  endif ?>
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