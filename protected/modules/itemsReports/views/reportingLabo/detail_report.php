<p class="tt" style="float:left;">Báo cáo giao nhận Labo</p>
<p style="float: right;"> <?php echo $title;?></p>
<div class="table table-responsive">
	<table class="table table-hover" id="list_export">
		<thead class="headertable">
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
		        <th></th>
		    </tr>
		</thead>
		<tbody>
			<?php if ($total == 0) { ?>
				<tr><td colspan="14">Không có dử liệu</td></tr>
			<?php } else { 
				foreach($data as $record):
				?>
				<tr>
					<td><?php echo $record['sent_date'] ?></td>
					<td><?php echo $record['gp_users_name'] ?></td>
					<td><?php echo $record['customer_name'] ?></td>
					<td><?php echo $record['code_number'] ?></td>
					<td><?php echo $record['description'] ?></td>
					<td><?php echo $record['labo_name'] ?></td>
					<td><?php echo $record['sent_person'] ?></td>
					<td><?php echo $record['sent_tray'] ?></td>
					<td><?php echo $record['receive_person'] ?></td>
					<td><?php echo $record['receive_tray'] ?></td>
					<td><?php echo $record['receive_date'] ?></td>
					<td><?php echo $record['security'] ?></td>
					<td><?php echo $record['receive_assistant'] ?></td>
					<td><a href="#" class="print-labo" data-id="<?php echo $record['id'] ?>"><i class="fa fa-print"></i>&nbsp;In</a></td>
				</tr>
			<?php endforeach; } ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$('.print-labo').on("click",function(){
		var id = $(this).data("id");
		var url="<?php echo CController::createUrl('reportingLabo/printLabo') ?>?id="+id;
            window.open(url,'name');
	});
</script>