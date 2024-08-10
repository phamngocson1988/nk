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
	<p style="text-align: center;font-size: 20px;">TỔNG LƯỢT ĐIỀU TRỊ CỦA KHÁCH HÀNG</p>
	<p style="text-align: right;">
		<?php echo $title; ?>
	</p>
	<div style="margin-top: 20pt; width: 100%;" >
	 	<table class="ivDt">
		  	<thead >
		  		<tr>
		  			<th style="width: 10%">Mã số</th>
		  			<th style="width: 15%">Họ và Tên</th>
		  			<th style="width: 7%">Giới tính</th>
		  			<th style="width: 10%">Số điện thoại</th>
		  			<th style="width: 20%">Địa chỉ</th>
		  			<th style="width: 8%">Nguồn</th>
		  			<th style="width: 10%">Nhóm</th>
		  			<th style="width: 7%">Giới Thiệu</th>
		  			<th style="width: 13%">Tổng lượt điều trị</th>	  					
		  		</tr>
		  	</thead>
		  	<tbody>

				<?php 
				  	foreach ($cs as $key => $value){
				  		$source = Source::model()->findByPk($value['id_source']);
				  		$nameSegment = Segment::model()->getNameSegment($value['id']);
				  	?>
				  		<tr class="sort-field">
				  			<td style="width: 10%"><a class="id-report" href="<?php echo yii::app()->request->baseUrl;?>/itemsCustomers/Accounts/admin?code_number=<?php echo $value["code_number"]; ?>"><?php echo $value['code_number']; ?></a></td>
				  			<td style="width: 15%"><?php echo $value['fullname']; ?></td>
				  			<td style="width: 7%"><?php if ($value['gender']==0){ echo 'Nam'; }else{ echo "Nữ";}  ?></td>
				  			<td style="width: 10%"><?php echo $value['phone']; ?></td>
				  			<td style="width: 20%"><?php echo $value['address']; ?></td>
				  			<td style="width: 8%"><?php if($source) echo $source->name;?></td>
				  			<td style="width: 10%"><?php echo $nameSegment;?></td>
				  			<td style="width: 7%"><?php echo $value['introducer']; ?></td>
				  			<td style="width: 13%"><?php echo $value['total']; ?></td>  			
				  		</tr>
				<?php } ?>
		  	</tbody>
		</table>
	</div>

 </page>