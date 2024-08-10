<style type="text/css">
p, a, td {
	word-wrap: break-word;
    font-size: 10pt;
}
.ivDt {
	width: 100%;
	max-width: 100%;
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


<page backtop="15mm" backbottom="5mm" backleft="10mm" backright="10mm" format="A4" backcolor="#fff" style="font: arial;font-family:freeserif ; margin-top:20px;">
	<p style="text-align: center;font-size: 20px;margin-top:20px;">BÁO CÁO GIAO NHẬN LABO</p>
	<p style="text-align: center; padding-top:11px; font-size:15px;"><?php echo $title  ?></p>
	<div style="margin-top: 10pt; width: 100%" >
		<table class="ivDt" style="width: 100%">
		  	<thead>
		  		<tr>
			        <th>Ngày giờ giao</th>               
			        <th>Bác sĩ</th>
			        <th>Tên KH</th>
			        <th>Mã KH</th>
			        <th>Nội dung</th>
			        <th>Tên Labo</th>
			        <th>Người giao</th>
			        <th>Khay giao</th>
			        <th>Người nhận</th>
			        <th>Khay nhận</th>
			        <th>Ngày giờ nhận</th>
			        <th>Bảo vệ</th>
			        <th>Nha tá nhận</th>
			    </tr>
		  	</thead>
		  	<tbody>
		  		<?php if ($total == 0) { ?>
					<tr><td colspan="13">Không có dử liệu</td></tr>
				<?php } else { 
					foreach($data as $record):
					?>
					<tr>
						<td style="width:7%"><?php echo $record['sent_date'] ?></td>
						<td style="width:8%"><?php echo $record['gp_users_name'] ?></td>
						<td style="width:8%"><?php echo $record['customer_name'] ?></td>
						<td style="width:7%"><?php echo $record['code_number'] ?></td>
						<td style="width:10%"><?php echo $record['description'] ?></td>
						<td style="width:8%"><?php echo $record['labo_name'] ?></td>
						<td style="width:7%"><?php echo $record['sent_person'] ?></td>
						<td style="width:7%"><?php echo $record['sent_tray'] ?></td>
						<td style="width:7%"><?php echo $record['receive_person'] ?></td>
						<td style="width:7%"><?php echo $record['receive_tray'] ?></td>
						<td style="width:7%"><?php echo $record['receive_date'] ?></td>
						<td style="width:7%"><?php echo $record['security'] ?></td>
						<td style="width:7%"><?php echo $record['receive_assistant'] ?></td>
					</tr>
				<?php endforeach; } ?>
		  	</tbody>
		</table>
	</div>
</page>