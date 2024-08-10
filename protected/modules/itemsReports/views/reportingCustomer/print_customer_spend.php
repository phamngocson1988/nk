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

<page   style="font: arial;font-family:freeserif ;">

<p style="text-align: center;font-size: 20px;margin-top:50px;"><?php echo $total; ?></p><!-- 	<p style="font-size: 20pt;font-weight: 400;">Elite Dental</p>
 -->	<p style="text-align: center; padding-top:11px; font-size:15px;"><?php echo ''.$fromdate.' đến '.$todate.', '.$data.', '.$nhanvien.'';  ?></p>
	 
	  <table class="ivDt " style="width: 100%; padding: 20px 35px;">
	  	<thead class="">
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
	  			<td><?php echo $value['code_number']; ?></td>
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
	  		
	  	</tbody>
	  </table>
	
</page>

