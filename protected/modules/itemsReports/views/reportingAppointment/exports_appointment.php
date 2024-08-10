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
<page backtop="15mm" backbottom="5mm" backleft="10mm" backright="10mm" format="Letter" backcolor="#fff" style="font: arial;font-family:freeserif ; margin-top:50px;">
	<p style="text-align: center;font-size: 20px;">TỔNG HỢP LỊCH HẸN</p>
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
		  			<th ><strong>Ngày </strong></th>
		  			<th ><strong>Văn phòng</strong></th>
		  			<th ><strong>Khách hàng</strong></th>
		  			<th ><strong>Nhân viên</strong></th>
		  			<th ><strong>Bắt đầu</strong></th>
		  			<th ><strong>Kết thúc</strong></th>
		  			<th ><strong>Nội dung</strong></th>
		  			<th ><strong>Người tạo</strong></th>
		  			<th ><strong>Trạng thái</strong></th>
		  			<th ><strong>Tổng tiền</strong></th>
		  			<th ><strong>Hóa đơn</strong></th>
		  		</tr>
		  	</thead>
		  	<tbody>

				<?php foreach ($export_appointmentList as $key => $v): ?>
					<tr>
						<td style="width:10%; "><?php echo date_format(date_create($v['create_date']),'d-m-Y'); ?></td>
						<td style="width:8%; "><?php 
							$id_branch = $v['id_branch'];
							$branch =  Branch::model()->findByPk($id_branch);
							if($branch){ echo $branch->name;  }else{ echo  ""; }
							?>
						</td>
						<td style="width:10%; "><?php echo $v['fullname'];?></td>
						<td style="width:10%; "><?php echo $v['name_dentist'];?></td>
						<td style="width:10%; "><?php echo date_format(date_create($v['start_time']),'d-m-Y'); ?></td>
						<td style="width:10%; "><?php echo date_format(date_create($v['end_time']),'d-m-Y'); ?></td>
						<td style="width:8%; "><?php echo $v['name_service'];?></td>
						<td style="width:8%; "><?php echo $v['author'];?></td>
						<td style="width:8%; "><?php if($v['status']==-1){echo "Hẹn lại";}
								  elseif($v['status']==0){echo "Không làm việc";}
								  elseif($v['status']==1){echo "Lịch mới";}
								  elseif($v['status']==2){echo "Đang chờ";}
								  elseif($v['status']==3){echo "Điều trị";}
								  elseif($v['status']==4){echo "Hoàn tất";}
								  elseif($v['status']==5){echo "Bỏ về";}
								  elseif($v['status']==6){echo "Vào khám";}
								  elseif($v['status']==-2){echo "Bỏ hẹn";}
								  elseif($v['status']==7){echo "Xác nhận";}
								  else{echo "Không đến";} ?></td>

						<?php $id_quotation = $v['id_quotation'];
							  $id_sch = $v['id'];

					  	if($id_quotation ==''){ ?>

					   	<td style="width:8%; ">N/A</td>
					   	<?php }else{
					   		$quotation = Quotation::model()->findByPk($id_quotation); ?>
					   		<td style="width:8%; "><?php if($quotation){echo number_format($quotation->sum_amount,0,'','.');}else{echo  "N/A";}?></td>
					   		
					   	<?php }?>
						<td style="width:8%; ">N/A</td>
					</tr>
				<?php endforeach ?>
		  	</tbody>
		</table>
	</div>

 </page>