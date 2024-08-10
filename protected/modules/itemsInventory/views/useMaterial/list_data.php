<table class="table table-condensed table-hover">
    <thead>
        <tr>
            <th>Mã phiếu</th>
            <th>Tên phiếu</th>
            <th>Kho trả</th>
            <th>Người tạo</th>
            <th>Ngày tạo</th>
            <th>Tổng tiền</th>
            <th>Ghi chú</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(!$countData):
                echo '<tr><td colspan="7">Không có dữ liệu!</td></tr>'; 
            else:
            foreach ($listData as $key => $value):
            	$id = $value['id'];
        ?>
        	<tr data-toggle="collapse" data-target="#tr<?php echo $key;?>" class="accordion-toggle <?php if($key%2==0) echo "tr_col"; ?>">
        		<td><?php echo $value['code']; ?></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['name_repository']; ?></td>
                <td><?php echo $value['name_user']; ?></td>
                <td><?php echo date_format(date_create($value['create_date']),'d-m-Y'); ?></td>
                <td><?php echo number_format($value['sum_amount'],0,",","."); ?></td>
                <td><?php echo $value['note']; ?></td>
        	</tr>
        	<tr>
                <input type="hidden" name="id_cancel_material" value="<?php echo $value['id']; ?>">
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
                                        <th>Lý do</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $listDetails = array_filter($listDetail,function($v) use ($id){
                                            if($v['id_cancel_material'] == $id)
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
                                            <td>
                                            	<?php 
                                            		$sum_amount = $d['qty'] * $d['amount'];
                                            		echo number_format($sum_amount,0,",",".");
                                             	?>
                                            </td>
                                            <td><?php echo $d['note']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="text-left mt-20">
                                <button type="button" class="btn oBtnDetail btnPrint">In phiếu</button>         
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
    <?php if ($pageList) echo $pageList; ?>
</div>