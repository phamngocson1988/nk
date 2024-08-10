<style type="text/css">
p, a, td {
	word-wrap: break-word;
    font-size: 12pt;
    padding: 10px;
}
.ivDt {
	width: 100%;
	border-collapse: collapse;
}
.ivDt tdead tr{
	background: #8FAAB1;
	font-size: 10pt;
}
.ivDt tdead td, .ivDt tbody td{
	padding: 8px auto;
	text-align: center;
	color: #fff;
	border: 1px solid #ccc;
}
.ivDt tbody td{
	color: #000;	
}
</style>

<page backtop="15mm" backbottom="5mm" backleft="10mm" backright="10mm" format="A5" backcolor="#fff" style="font: arial;font-family:freeserif ; margin-top:50px;">
	<p style="text-align: center;font-size: 20px; font-weight: bold">THÔNG TIN GIAO NHẬN LABO</p>
	<div style="margin-top: 20pt; width: 100%" >
	 	<table class="ivDt">
			<tr>
				<td style="width: 30%"><b>Tên KH</b></td><td style="width:60%"><?php echo $labo['customer_name'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Mã KH</b></td><td style="width:60%"><?php echo $labo['code_number'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Bác sĩ</b></td><td style="width:60%"><?php echo $labo['gp_users_name'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Tên Labo</b></td><td style="width:60%"><?php echo $labo['labo_name'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Ngày giờ giao</b></td><td style="width:60%"><?php echo $labo['sent_date'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Người giao</b></td><td style="width:60%"><?php echo $labo['sent_person'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Khay giao</b></td><td style="width:60%"><?php echo $labo['sent_tray'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Ngày giờ nhận</b></td><td style="width:60%"><?php echo $labo['receive_date'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Người nhận</b></td><td style="width:60%"><?php echo $labo['receive_person'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Khay nhận</b></td><td style="width:60%"><?php echo $labo['receive_tray'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Bảo vệ</b></td><td style="width:60%"><?php echo $labo['security'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Nha tá nhận</b></td><td style="width:60%"><?php echo $labo['receive_assistant'] ?></td>
			</tr>
			<tr>
				<td style="width: 30%"><b>Nội dung</b></td><td style="width:60%"><?php echo $labo['description'] ?></td>
			</tr>
		</table>
	</div>
</page>