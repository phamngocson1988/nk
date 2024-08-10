<p class="tt" style="float:left;">Danh Sách Chi Tiêu Khách Hàng</p>
<!-- 	<p style="font-size: 20pt;font-weight: 400;">Elite Dental</p>
 -->	<p style="float:right; padding-top:11px; font-size:15px;"><?php echo ' Từ '.$fromdate.' đến '.$todate.', '.$data.', '.$nhanvien.'';  ?></p>
	<!-- <hr> -->
	<div class="table table-responsive">
	  <table class="table table-hover">
	  	<thead class="headertable">
	  		<tr>
	  			<th class="text-align-center" colspan="3">Khách hàng</th> 	  			
	  			<th>Số lịch hẹn</th>
	  			<th>Số dịch vụ</th>
	  			<th>Báo giá</th>
	  			<th>Hóa đơn</th>
	  			<th>Khuyến mãi</th>
	  			<th>Thanh toán</th>
	  			<th>Công nợ</th>	  					
	  		</tr>
            <tr>
                <th>ID</th>         
                <th>Họ và Tên</th>
                <th>Số điện thoại</th>   
                <th></th>  
                <th></th>  
                <th></th>  
                <th></th>  
                <th></th>  
                <th></th>  
                <th></th>                             
            </tr>
	  	</thead>
	  	<tbody>
	  	<?php 
	  	foreach ($cs as $key => $value){
	  		# code...
	  	?>
	  		<tr class="sort-field">
	  			<td><a class="id-report" href="<?php echo CController::createUrl('itemsCustomers/Accounts/admin?code_number='.$value["code_number"].'')?>"><?php echo $value['code_number']; ?></a></td>
	  			<td><?php echo $value['fullname']; ?></td>
	  			<td><?php echo $value['phone']; ?></td>
	  			<td><?php echo Customer::model()->getcountlichhen($value['id']); ?></td>
	  			<td><?php echo Customer::model()->getcountservice($value['id']); ?></td>
	  			<td><?php $data = Customer::model()->getsuminvoice($value['id']); foreach($data as $key ){  if($key['sumnount']!= "") { echo $key['sumnount'];}else { echo "N/A";} }?></td>
	  			<td>N/A</td>
                <td>N/A</td>  
                <td>N/A</td>
                <td>N/A</td>					
	  		</tr>
	  	<?php } ?>
	  		<tr>
	  			<td colspan="21"><div class="total-customer">Tổng số khách hàng: <?php echo $count; ?></div></td>
	  		</tr>
	  	</tbody>
	  </table>
	</div>