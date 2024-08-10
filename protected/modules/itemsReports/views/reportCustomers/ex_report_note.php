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
	<p style="text-align: center;font-size: 20px;">Danh Sách Ghi Chú Khách Hàng</p>
	<p style="text-align: right;"><?php echo $title;?></p>
	<div style=" width: 100%;" >
	 	<table class="ivDt">
		  	<thead >
			   <tr>
	                <th class="text-align-center" colspan="3">Khách hàng</th>               
	                <th rowspan="2" style="padding-top: 25px; width: 10%">Phân loại</th>
	                <th rowspan="2" style="padding-top: 25px;width: 10%">Trạng thái</th>
	                <th rowspan="2" style="padding-top: 25px;width: 30% ">Nội dung</th>
	                <th rowspan="2" style="padding-top: 25px;width: 10%">Nhân viên</th>              
	            </tr>
	            <tr>
	                <th style="width: 10%">ID</th>         
	                <th style="width: 15%">Họ và Tên</th>
	                <th style="width: 10%">Số điện thoại</th>                            
	            </tr>
		  	</thead>
		  	<tbody>
			  	<?php 
			  	foreach ($cs as $key => $value){
			  	?>
			  		<tr class="sort-field">
			  			<td style="width: 10%"><a class="id-report" href="<?php echo yii::app()->request->baseUrl;?>/itemsCustomers/Accounts/admin?code_number=<?php echo $value["code_number"]; ?>"><?php echo $value['code_number']; ?></a></td>
			  			<td style="width: 10%"><?php echo $value['fullname']; ?></td>
			  			<td style="width: 10%"><?php echo $value['phone']; ?></td>
			  			<td style="width: 10%"><?php if($value['flag']==1){ echo "Lịch hẹn" ;}elseif ($value['flag']==2){echo "Hoạt động";}elseif ($value['flag']==3){echo "Điều trị";}elseif ($value['flag']==4){echo "Báo giá";} ?></td>
			  			<td style="width: 10%"><?php if($value['note_status']==1){ echo "Ghi nhận"; }elseif ($value['note_status']==2){echo "Đang giải quyết";}elseif ($value['note_status']==3){echo "Hoàn tất";}else{echo "Hủy"; } ?></td>
			  			<td style="width: 30%"><?php echo $value['note']; ?></td>
			  			<td style="width: 10%"><?php echo $value['user_name']; ?></td>     
		              					
			  		</tr>
			  	<?php } ?>
			  		<tr>
			  			<td colspan="7" style="text-align: center;">Tổng số khách hàng: <?php echo $count; ?></td>
			  		</tr>
			</tbody>
		</table>
	</div>

 </page>