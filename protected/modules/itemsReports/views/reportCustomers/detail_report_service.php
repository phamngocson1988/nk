
<p class="tt" style="float:left;">Danh Sách Khách Hàng sử dụng dịch vụ</p>
<p style="float: right;"> <?php echo $title;?></p>
	<div class="table table-responsive">
	  <table class="table table-hover" id="list_export">
	  	<thead class="headertable">
	  	
	  		<tr>
	  			<th>Mã số</th>
	  			<th>Họ và Tên</th>
	  			<th>BS điều trị</th>
	  			<th>Dịch vụ</th>
	  			<th>Số răng</th>
	  			<th>Số lượng</th>
	  			<th>Đơn giá</th>
	  			<th>Thành tiền</th>	
	  		</tr>
	  	</thead>
	  	<tbody>
	  	<?php 
	  	foreach ($cs as $key => $value){
			$service 	= CsService::model()->findByPk($value['id_service']);
			$user 		= GpUsers::model()->findByPk($value['id_user']);
			$source     = Source::model()->findByPk($value['id_source']);
		?>
	  		<tr class="sort-field">
	  			<td>
	  				<a class="id-report" href="<?php echo yii::app()->request->baseUrl;?>/itemsCustomers/Accounts/admin?code_number=<?php echo $value["code_number"]; ?>"><?php echo $value['code_number']; ?></a>
	  			</td>
	  			
	  			<td>
	  				<?php echo $value['fullname']; ?>	
	  			</td>
	  			<td>
	  				<?php if($user){echo $user['name'];}else{ echo "N/A";} ?>
	  			</td>	
	  			<td>
	  				<?php if($service){echo $service['name'];}else{ echo $value['description'];} ?>	
	  			</td>
	  			<td><?php echo $value['teeth']; ?>	</td>
	  			<td><?php echo $value['qty']; ?>	</td>
	  			<td><?php echo (string)number_format($value['unit_price'] ,0,",",",") ; ?></td>
	  			<td><?php echo (string)number_format($value['amount'] ,0,",",",") ; ?></td>
	  		</tr>
	  	<?php } ?>
	  		<tr>
	  			<td colspan="8"><div class="total-customer">Tổng số khách hàng: <?php echo $count; ?></div></td>
	  		</tr>
	  	</tbody>
	  </table>
	</div>

	
