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

<page backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm" format="Letter" backcolor="#fff" style="font: arial;font-family:freeserif ; ">
	<p style="text-align: center;font-size: 20px;">Danh Sách Khách Hàng sử dụng dịch vụ</p>
	<div style="text-align: right;"><?php echo $title;?></div>
	<div style=" width: 100%; margin-top:20px" >
	 	<table class="ivDt">
		  	<thead >
			  	<tr>
		  			<th style="width: 10%">Mã số</th>
		  			<th style="width: 15%">Họ và Tên</th>
		  			<th style="width: 15%">BS điều trị</th>
		  			<th style="width: 15%">Dịch vụ</th>
		  			<th style="width: 8%">Số răng</th>
		  			<th style="width: 7%">Số lượng</th>
		  			<th style="width: 15%">Đơn giá</th>
		  			<th style="width: 15%">Thành tiền</th>	
		  		</tr>
		  	</thead>
		  	<tbody>
		  	<?php 
		  	foreach ($cs as $key => $value){
				$service 	= CsService::model()->findByPk($value['id_service']);
				$user 		= GpUsers::model()->findByPk($value['id_user']);
			?>
		  		<tr class="sort-field">
		  			<td style="width: 10%">
		  				<a class="id-report" href="<?php echo yii::app()->request->baseUrl;?>/itemsCustomers/Accounts/admin?code_number=<?php echo $value["code_number"]; ?>"><?php echo $value['code_number']; ?></a>
		  			</td>
		  			
		  			<td style="width: 15%">
		  				<?php echo $value['fullname']; ?>	
		  			</td>
		  			<td style="width: 15%">
		  				<?php if($user){echo $user['name'];}else{ echo "N/A";} ?>
		  			</td>	
		  			<td style="width: 15%">
		  				<?php if($service){echo $service['name'];}else{ echo $value['description'];} ?>	
		  			</td>
		  			<td style="width: 8%"><?php echo $value['teeth']; ?>	</td>
		  			<td style="width: 7%"><?php echo $value['qty']; ?>	</td>
		  			<td style="width: 15%"><?php echo (string)number_format($value['unit_price'] ,0,",",",") ; ?></td>
		  			<td style="width: 15%"><?php echo (string)number_format($value['amount'] ,0,",",",") ; ?></td>
		  		</tr>
		  	<?php } ?>
		  		<tr>
		  			<td colspan="8" style="text-align: center;">Tổng số khách hàng: <?php echo $count; ?></td>
		  		</tr>
		  	</tbody>
		</table>
	</div>

 </page>