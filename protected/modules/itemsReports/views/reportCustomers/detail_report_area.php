<p class="tt" style="float:left;">Danh Sách Khách Hàng Theo Khu vực</p>
<p style="float: right;"> <?php echo $title;?></p>

	<div class="table">
	  <table class="table table-hover" id="list_export">
	  	<thead class="headertable">
	  		<tr>
	  			<td colspan="10" style="display: none; text-align: center; font-size: 20px;">
		  			Danh Sách Khách Hàng Theo Khu vực
		  		</td>
		  	</tr>
	  		<tr>
	  			<td colspan="10" style="display: none; text-align: center;">
		  			<?php echo $title; ?>
		  		</td>
		  	</tr>
	  		<tr>
	  			<th>Mã số</th>
	  			<th>Họ và Tên</th>
	  			<th>Số điện thoại</th>
	  			<th>Địa chỉ</th>
	  			<th>Quốc gia</th>
	  			<th>Tỉnh/Thành</th>
	  			<th>Quận/Huyện</th>
	  		</tr>
	  	</thead>
	  	<tbody>
	  	<?php 
	  	foreach ($cs as $key => $value){
	  		
	  	?>
	  		<tr class="sort-field">
	  			<td><a class="id-report" href="<?php echo yii::app()->request->baseUrl;?>/itemsCustomers/Accounts/admin?code_number=<?php echo $value["code_number"]; ?>"><?php echo $value['code_number']; ?></a></td>
	  			<td><?php echo $value['fullname']; ?></td>
	  			<td><?php echo $value['phone']; ?></td>
	  			<td><?php echo $value['address']; ?></td>
				<td>
					<?php 
						$countryList = Customer::model()->getListCountry();
						foreach ($countryList as $key => $country) {
							if ($value['id_country'] == $country['code']) {
								echo $country['country']; 
							}
						}
					?>
				</td>
				<td>
					<?php 
						$city = LocaltionProvince::model()->findByPk($value['city']);
						echo $city?$city->provinceDescriptionVn:''; 
					?>
				</td>
				<td>
					<?php 
						$district = LocaltionDistrict::model()->findByPk($value['county']);
						echo $district?$district->districtDescriptionVn:''; 
					?>
				</td>	  				  			
	  		</tr>
	  	<?php } ?>
	  		<tr>
	  			<td colspan="10"><div class="total-customer">Tổng số khách hàng: <?php echo $count?></div></td>
	  		</tr>
	  	</tbody>
	  </table>
	</div>
	<div align="center">
             
</div>

