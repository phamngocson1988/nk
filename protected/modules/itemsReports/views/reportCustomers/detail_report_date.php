<p class="tt" style="float:left;">Danh Sách Khách Hàng Theo Ngày Tạo</p>
<p style="float: right;"> <?php echo $title;?></p>
	<div class="table">
	  <table class="table table-hover" id="list_export">
	  	<thead class="headertable">
	  		<tr>
	  			<td colspan="15" style="display: none; text-align: center; font-size: 20px;">
		  			DANH SÁCH KHÁCH HÀNG THEO NGÀY TẠO
		  		</td>
		  	</tr>
	  		<tr>
	  			<td colspan="15" style="display: none; text-align: center;">
		  			<?php echo $title; ?>
		  		</td>
		  	</tr>

	  		<tr>
	  			<th>Mã số</th>
	  			<th>Ngày tạo</th>
	  			<th>Họ và Tên</th>
	  			<th>ID</th>
	  			<th>Ngày sinh</th>
	  			<th>Giới tính</th>
	  			<th>Email</th>
	  			<th>Số điện thoại</th>
	  			<th>Địa chỉ</th>
	  			<th>Nghề nghiệp</th>
	  			<th>Hội viên</th>
	  			<th>Nguồn</th>
	  			<th>Bảo hiểm</th>
	  			<th>Ngày hẹn cuối</th>	  					
	  		</tr>
	  	</thead>
	  	<tbody>
	  	<?php 
	  	foreach ($cs as $key => $value){
	  		$source = Source::model()->findByPk($value['id_source']);
	  	
	  	?>
	  		<tr class="sort-field">
	  			<td><a class="id-report" href="<?php echo yii::app()->request->baseUrl;?>/itemsCustomers/Accounts/admin?code_number=<?php echo $value["code_number"]; ?>"><?php echo $value['code_number']; ?></a></td>
	  			<td><?php echo $value['createdate']; ?></td>
	  			<td><?php echo $value['fullname']; ?></td>
	  			<td><?php echo $value['id']; ?></td>
	  			<td><?php if( $value['birthdate'] != ''){ echo $value['birthdate']; }else {
	  				# code...
	  			echo "N/A";} ?></td>
	  			<td><?php if ($value['gender']==0){ echo 'Nam'; }else{ echo "Nữ"; } ?></td>
	  			<td><?php echo $value['email']; ?></td>
	  			<td><?php echo $value['phone']; ?></td>
	  			<td><?php echo $value['address']; ?></td>
	  			<td>N/A</td>
	  			<td>N/A</td>
	  			<td><?php if($source) echo $source->name;?></td>
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
	<div align="center">
             
</div>

