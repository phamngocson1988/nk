<table class="table table-condensed table-hover">
    <thead>
        <tr>
            <th>Mã phiếu</th>
            <th>Tên phiếu</th>
            <th>Kho chuyển</th>
            <th>Kho nhận</th>
            <th>Người tạo</th>
            <th>Ngày tạo</th>
            <th>Ngày xác nhận</th>
            <th>Tổng tiền</th>
            <th>Ghi chú</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(!$countData):
                echo '<tr><td colspan="9">Không có dữ liệu!</td></tr>'; 
            else:
            foreach ($listData as $key => $value):
            	$id = $value['id'];
            	$disDelete  = '';
                $disUpdate  = '';
                $disConfirm = '';
                if($value['status'] == 1){
                    $disDelete  = '';
                    $disUpdate  = '';
                    $disConfirm = '';
                }else{ 
                    $disDelete  = 'disabled';
                    $disUpdate  = 'disabled';
                    $disConfirm = 'disabled';
                }
                if($group_id == 22){
                    $disUpdate = 'disabled';
                    $disDelete  = 'disabled';
                }
        ?>
        	<tr data-toggle="collapse" data-target="#tr<?php echo $key;?>" class="accordion-toggle <?php if($key%2==0) echo "tr_col"; ?>">
        		<td><?php echo $value['code']; ?></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['repository_transfer']; ?></td>
                <td><?php echo $value['repository_receipt']; ?></td>
                <td><?php echo $value['name_user']; ?></td>
                <td><?php echo date_format(date_create($value['create_date']),'d-m-Y'); ?></td>
                <td><?php if($value['confirmation_date']) echo date_format(date_create($value['confirmation_date']),'d-m-Y'); ?></td>
                <td><?php echo number_format($value['sum_amount'],0,",","."); ?></td>
                <td><?php echo $value['note']; ?></td>
                <td>
                	<?php 
	                	if($value['status'] == 1){
	                		echo '<span class="err">Chưa xác nhận</span>';
	                	}elseif($value['status'] == 2){
	                		echo '<span class="success">Đã xác nhận</span>';
	                	} 
                	?>
                </td>
        	</tr>
        	<tr>
                <input type="hidden" name="id_stock_transfer" value="<?php echo $value['id']; ?>">
                <td colspan="7" class="hiddenRow">
                    <div class="accordian-body collapse col-xs-12" id="tr<?php echo $key;?>">
                        <div class="col-md-12 oViewB">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mã nguyên vật liệu</th>
                                        <th>Tên nguyên vật liệu</th>
                                        <th>Ngày hết hạn</th>
                                        <th>Đơn vị tính</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $listDetails = array_filter($listDetail,function($v) use ($id){
                                            if($v['id_stock_transfer'] == $id)
                                                return true;
                                        });
                                        foreach ($listDetails as $key => $d):
                                    ?>
                                        <tr>
                                            <td><?php echo $d['code_material']; ?></td>
                                            <td><?php echo $d['name_material']; ?></td>
                                            <td><?php echo date_format(date_create($d['expiration_date']),'d-m-Y'); ?> </td>
                                            <td><?php echo $d['unit']; ?></td>
                                            <td><?php echo $d['qty']; ?></td>
                                            <td><?php echo number_format($d['amount'],0,",","."); ?></td>
                                            <td><?php echo number_format($d['sum_amount'],0,",","."); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="text-left mt-20">
                                <button <?php echo $disUpdate;?> class="btn oBtnDetail btnUpdate" data-toggle="modal" data-target="#updateModal">Cập nhật</button>
                                <button type="button" class="btn oBtnDetail btnPrint">In phiếu</button>
                                <button type="button" class="btn oBtnDetail btnConfirm" <?php echo $disConfirm; ?>>Xác nhận</button>
                                <span class="pull-right">
                                    <button <?php echo $disDelete;?> type="button" class="btn btn-danger btnDelete">Hủy phiếu</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php
        	endforeach;
            endif;
        ?>
    </tbody>
</table>
<div style="clear:both"></div>
<div id="" class="row fix_bottom">
    <?php if($pageList) echo $pageList;?> 
</div> 