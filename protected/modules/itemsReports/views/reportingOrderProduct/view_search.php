<?php include 'style.php' ?>
<div class="table table-responsive">
	<table class="table table-bordered table-hover" id="list_export">
	  	<thead class="headertable">
	  		<tr>
	  			<th>Chi nhánh</th>
	  			<th>Khách hàng</th>
	  			<th>Đơn hàng</th>
	  			<th>Sản phẩm</th>
	  			<th>Số lượng</th>
	  			<th>Đơn giá</th>
	  			<th>Tổng tiền</th>
	  			<th>Ngày tạo</th>
	  			<th>Trạng thái</th>
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
	  						<td>
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
	  						<td>
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
	  						<td><?php echo $value['code'];?></td>
	  						<td><?php echo $value['product_name'];?></td>
	  						<td><?php echo $value['qty'];?></td>
	  						<td><?php echo ($value['unit_price'])?number_format($value['unit_price'],0, ',', '.').' VND':'0 '; ?></td>
	  						<td><?php echo ($value['unit_price'])?number_format($value['amount'],0, ',', '.').' VND':'0 '; ?></td>
	  						<td><?php echo date_format(date_create($value['create_date']),'d-m-Y'); ?></td>
	  						<td>
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