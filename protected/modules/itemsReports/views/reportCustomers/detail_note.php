<p class="tt" style="float:left;">Danh Sách Ghi Chú Khách Hàng</p>
<p style="float: right;"> <?php echo $title;?></p>
	<div class="table table-responsive">
	  <table class="table table-hover" id="list_export">
	  	<thead class="headertable">
	  		<tr>
	  			<td colspan="7" style="display: none; text-align: center; font-size: 20px;">
		  			GHI CHÚ KHÁCH HÀNG
		  		</td>
		  	</tr>
	  		<tr>
	  			<td colspan="7" style="display: none; text-align: center;">
		  			<?php echo $title; ?>
		  		</td>
		  	</tr>

            <tr>
                <th class="text-align-center" colspan="3">Khách hàng</th>               
                <th rowspan="2" style="padding-top: 25px !important ">Phân loại</th>
                <th rowspan="2" style="padding-top: 25px !important ">Trạng thái</th>
                <th rowspan="2" style="width: 30%;padding-top: 25px !important ">Nội dung</th>
                <th rowspan="2" style="padding-top: 25px !important ">Nhân viên</th>
                                    
            </tr>
            <tr>
                <th>ID</th>         
                <th>Họ và Tên</th>
                <th>Số điện thoại</th>                            
            </tr>
        </thead>
	  	<tbody>
	  	<?php 
	  	foreach ($cs as $key => $value){
	  		# code...
	  	?>
	  		<tr class="sort-field">
	  			<td><a class="id-report" href="<?php echo yii::app()->request->baseUrl;?>/itemsCustomers/Accounts/admin?code_number=<?php echo $value["code_number"]; ?>"><?php echo $value['code_number']; ?></a></td>
	  			<td><?php echo $value['fullname']; ?></td>
	  			<td><?php echo $value['phone']; ?></td>
	  			
	  			<td><?php if($value['flag']==1){ echo "Lịch hẹn" ;}elseif ($value['flag']==2){echo "Hoạt động";}elseif ($value['flag']==3){echo "Điều trị";}elseif ($value['flag']==4){echo "Báo giá";} ?></td>
	  			<td><?php if($value['note_status']==1){ echo "Ghi nhận"; }elseif ($value['note_status']==2){echo "Đang giải quyết";}elseif ($value['note_status']==3){echo "Hoàn tất";}else{echo "Hủy"; } ?></td>
	  			<td><?php echo $value['note']; ?></td>
	  			<td><?php echo $value['user_name']; ?></td>
               
              					
	  		</tr>
	  	<?php } ?>
	  		<tr>
	  			<td colspan="7"><div class="total-customer">Tổng số khách hàng: <?php echo $count; ?></div></td>
	  		</tr>
	  	</tbody>
	  </table>
	</div>