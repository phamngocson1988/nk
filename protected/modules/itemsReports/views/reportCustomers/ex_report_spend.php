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
	<p style="text-align: center;font-size: 20px;">Danh Sách Chi Tiêu Khách Hàng</p>
	<p style="text-align: right;">
		<?php echo $title; ?>
	</p>
	<div style="margin-top: 20pt; width: 100%;" >
	 	<table class="ivDt">
		  	<thead >
		  		<tr>
		  			<th class="text-align-center" colspan="7" >Khách hàng</th> 	  			
		  			<th style="padding-top: 25px ; width: 7%" rowspan="2">Số dịch vụ</th>
		  			<th style="padding-top: 25px ;width: 7%" rowspan="2">Báo giá</th>
		  			<th style="padding-top: 25px ;width: 7%" rowspan="2">Hóa đơn</th>
		  			<th style="padding-top: 25px ;width: 7%" rowspan="2">Thanh toán</th>
		  			<th style="padding-top: 25px ;width: 7%" rowspan="2">Công nợ</th>	  		
		  		</tr>
	            <tr >
	                <th style="width: 7%">Mã khách hàng</th>         
	                <th style="width: 7%">Họ và Tên</th>
	                <th style="width: 7%">Giới tính</th>
	                <th style="width: 8%">Số điện thoại</th>   
	                <th style="width: 20%">Email</th>
	                <th style="width: 7%">Địa chỉ</th>
	          
	                <th style="width: 7%">Giới thiệu</th>                       
	            </tr>
		  	</thead>
		  		<tbody>
			  		<?php
			  			if($cs){
			  				foreach ($cs as $key => $value) {
			  					$source     = Source::model()->findByPk($value['id_source']);
			  		?>
			  		<tr>
			  			<td style="width: 7%"><?php echo $value['code_number']; ?></td>
			  			<td style="width: 7%"><?php echo $value['fullname']; ?></td>
			  			<td style="width: 7%"><?php if ($value['gender']==0){echo 'Nam'; }else{ echo "Nữ";}  ?></td>
			  			<td style="width: 7%"><?php echo $value['phone']; ?></td>
			  			<td style="width: 7%"><?php echo $value['email']; ?></td>
			  			<td style="width: 7%"><?php echo $value['address']; ?></td>
			  			<td style="width: 7%">
			  				<?php if($source){echo $source['name'];}else{ echo "N/A";} ?>
			  			</td>	
			  			<td style="width: 7%"><?= $value['totalService'] ?></td>
			  			<td style="width: 7%"><?= (string)number_format($value['sum_amount'] ,0,".",".")?>  VND</td>
			  			<td style="width: 7%"><?= (string)number_format($value['sum_invoice'] ,0,".",".")?> VND</td>
			  			<td style="width: 7%"><?= (string)number_format($value['payment'] ,0,".",".")  ?>   VND</td>
			  			<td style="width: 7%"><?= (string)number_format($value['balance'] ,0,".",".")  ?>   VND</td>
			  		</tr>
			  		<?php 
			  				}
			  			}
			  		?>
			  	</tbody>
		</table>
	</div>

 </page>