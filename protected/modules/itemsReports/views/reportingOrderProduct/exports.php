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
	<div style="margin-top: 20pt; width: 100%;" >
	 	<table class="ivDt">
		  	<thead >
		  		<tr>
		  			<th style="width: 9%">Chi nhánh</th>
		  			<th style="width: 9%">Khách hàng</th>
		  			<th style="width: 9%">Đơn hàng</th>
		  			<th style="width: 20%">Sản phẩm</th>
		  			<th style="width: 9%">Số lượng</th>
		  			<th style="width: 12%">Đơn giá</th>
		  			<th style="width: 12%">Tổng tiền</th>
		  			<th style="width: 9%">Ngày tạo</th>
		  			<th style="width: 9%">Trạng thái</th>
		  		</tr>
		  	</thead>
		  	<tbody>
	  		<?php if($count == 0){ ?>
	  		 	<tr><td colspan="9" rowspan="" headers="">Không có dữ liệu!</td></tr>
	  		<?php 
	  			}else{ 
	  				foreach ($list_data as $key => $value) {
	  		?>
	  					<tr>
	  						<td style="width: 7%">
	  							<?php 
									$id_branch = $value['id_branch'];
									$branch =  Branch::model()->findByPk($id_branch);
									if($branch){
										echo $branch->name;
									}else{
										echo "N/A";
									}
								?>
							</td>
	  						<td style="width: 7%">
	  							<?php 
									$id_cus = $value['id_customer'];
									$cus =  Customer::model()->findByPk($id_cus);
									if($cus){
										echo $cus->fullname;
									}else{
										echo "N/A";
									}
								?>
	  						</td>
	  						<td style="width: 9%"><?php echo $value['code'];?></td>
	  						<td style="width: 20%"><?php echo $value['product_name'];?></td>
	  						<td style="width: 9%"><?php echo $value['qty'];?></td>
	  						<td style="width: 9%"><?php echo ($value['unit_price'])?number_format($value['unit_price'],0, ',', '.').' VND':'0 '; ?></td>
	  						<td style="width: 12%"><?php echo ($value['amount'])?number_format($value['amount'],0, ',', '.').' VND':'0 '; ?></td>
	  						<td style="width: 12%"><?php echo date_format(date_create($value['create_date']),'d-m-Y'); ?></td>
	  						<td style="width: 9%">
	  							<?php
	  								if($value['status']==1){
	  									echo "<span class='label label-primary'>new</span>";
	  								}else if($value['status']==2){
	  									echo "<span class='label label-warning'>pending</span>";
	  								}else if($value['status']==3){
	  									echo "<span class='label label-success'>completed</span>";
	  								}else if($value['status']==4){
	  									echo "<span class='label label-danger'>cancel</span>";
	  								}
	  							?>
	  						</td>
	  					</tr>
	  		<?php 
	  				} 
	  			} 
	  		?>
	  	</tbody>
		</table>
	</div>

 </page>