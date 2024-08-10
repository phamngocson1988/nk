<p class="tt" style="float:left;">Danh Sách Chi Tiêu Khách Hàng</p>
<p style="float: right;"> <?php echo $title;?></p>
	<div>
	  <table class="table table-hover" id="list_export">
	  	<thead class="headertable">
	  		<tr>
	  			<td colspan="14" style="display: none; text-align: center; font-size: 20px;">
		  			 CHI TIÊU KHÁCH HÀNG
		  		</td>
		  	</tr>
	  		<tr>
	  			<td colspan="14" style="display: none; text-align: center;">
		  			<?php echo $title; ?>
		  		</td>
		  	</tr>
	  		<tr>
	  			<th class="text-align-center" colspan="7" style="width: 50%;">Khách hàng</th> 	  			
	  			<th style="padding-top: 25px !important;" rowspan="2">Số dịch vụ</th>
	  			<th style="padding-top: 25px !important;" rowspan="2">Báo giá</th>
	  			<th style="padding-top: 25px !important;" rowspan="2">Hóa đơn</th>
	  			<th style="padding-top: 25px !important;" rowspan="2">Thanh toán</th>
	  			<th style="padding-top: 25px !important;" rowspan="2">Công nợ</th>	  		
	  		</tr>
            <tr>
                <th>Mã khách hàng</th>         
                <th>Họ và Tên</th>
                <th>Giới tính</th>
                <th>Số điện thoại</th>   
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Nguồn</th>            
            </tr>
	  	</thead>
	  	<tbody>
	  		<?php
	  			if($cs){
	  				foreach ($cs as $key => $value) {
	  					$source     = Source::model()->findByPk($value['id_source']);
	  		?>
	  		<tr>
	  			<td><?php echo $value['code_number']; ?></td>
	  			<td><?php echo $value['fullname']; ?></td>
	  			<td><?php if ($value['gender']==0){echo 'Nam'; }else{ echo "Nữ";}  ?></td>
	  			<td><?php echo $value['phone']; ?></td>
	  			<td><?php echo $value['email']; ?></td>
	  			<td><?php echo $value['address']; ?></td>
	  			<td>
	  				<?php if($source){echo $source['name'];}else{ echo "N/A";} ?>
	  			</td>	
	  			
	  			<td><?= $value['totalService'] ?></td>
	  			<td><?= (string)number_format($value['sum_amount'] ,0,".",".")?>  VND</td>
	  			<td><?= (string)number_format($value['sum_invoice'] ,0,".",".")?> VND</td>
	  			<td><?= (string)number_format($value['payment'] ,0,".",".")  ?>   VND</td>
	  			<td><?= (string)number_format($value['balance'] ,0,".",".")  ?>   VND</td>
	  		</tr>
	  		<?php 
	  				}
	  			}
	  		?>
	  	</tbody>
	  </table>
	</div>