<table class="table table-condensed table-hover">
    <thead>
        <tr>
            <th>Mã phiếu</th>
            <th>Tên phiếu</th>
            <th>Kho đề xuất</th>
            <th>Người tạo</th>
            <th>Ngày tạo</th>
            <th>Ghi chú</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(!$countData):
                echo '<tr><td colspan="5">Không có dữ liệu!</td></tr>'; 
            else: 
            foreach ($listData as $key => $value):
                $id = $value['id'];
                $disDelete  = '';
                $disUpdate  = '';
                $disConfirm = '';
                $txtStatus  = '';
                if($value['status'] == 0){
                    $disDelete  = '';
                    $disUpdate  = '';
                    $disConfirm = '';
                }elseif($value['status'] == 1){
                    $disDelete  = 'disabled';
                    $disUpdate  = 'disabled';
                    $disConfirm = 'disabled';
                }
                if($group_id == 21 || $group_id == 22){
                    $disConfirm = 'disabled';
                }
        ?>
            <tr data-toggle="collapse" data-target="#tr<?php echo $key;?>" class="accordion-toggle <?php if($key%2==0) echo "tr_col"; ?>">
                <td>
                    <?= $value['code']; ?>
                </td>
                <td>
                    <?= $value['name']; ?>
                </td>
                <td>
                    <?= $value['name_repository']; ?>
                </td>
                <td>
                    <?= $value['name_user']; ?>
                </td>
                <td>
                    <?php echo date_format(date_create($value['create_date']),'d-m-Y'); ?> 
                </td>
                <td>
                    <?= $value['note']; ?>
                </td>
                <td>
                    <?php 
                        if($value['status'] == 1){
                            echo '<span class="success">Đã duyệt</span>';
                        }else if($value['status'] == 0){
                            echo '<span class="err">Chưa duyệt</span>';
                        } 
                    ?>
                </td>
                <tr>
                    <input type="hidden" name="id_purchase_requisition" value="<?php echo $id; ?>">
                    <td colspan="7" class="hiddenRow">
                        <div class="accordian-body collapse col-xs-12" id="tr<?php echo $key;?>">
                            <div class="col-md-12 oViewB">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Mã nguyên vật liệu</th>
                                            <th>Tên nguyên vật liệu</th>
                                            <th>Số lượng</th>
                                            <th>Đơn vị tính</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $listDetails = array_filter($listDetail,function($v) use ($id){
                                                if($v['id_purchase_requisition'] == $id)
                                                    return true;
                                            });
                                            foreach ($listDetails as $key => $d):
                                        ?>
                                            <tr>
                                                <td><?php echo $d['code_material']; ?></td>
                                                <td><?php echo $d['name_material']; ?></td>
                                                <td><?php echo $d['qty']; ?></td>
                                                <td><?php echo $d['unit']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="text-left mt-20">
                                    <button  class="btn oBtnDetail btnUpdate" data-toggle="modal" data-target="#updateModal" <?php echo $disUpdate; ?>>Cập nhật</button>
                                    <button type="button" class="btn oBtnDetail btnPrint">In phiếu</button>
                                    
                                    <button type="button" class="btn oBtnDetail btnConfirm" data-toggle="modal" data-target="#goodsReceiptModal" <?php echo $disConfirm; ?>>Nhập kho</button>
                                    
                                    <span class="pull-right">
                                        <button type="button" class="btn btn-danger btnDelete" <?php echo $disDelete; ?>>Hủy phiếu</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<div style="clear:both"></div>
<div id="" class="row fix_bottom">
    <?php if($pageList) echo $pageList;?> 
</div> 