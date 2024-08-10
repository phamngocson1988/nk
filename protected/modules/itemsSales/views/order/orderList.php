<div class="col-md-12 tableList"> 
    <table class="table table-condensed table-hover" id="oListT" style="border-collapse:collapse;">
        <thead>
            <tr>
               <th>Mã đơn hàng</th>
                <th>Khách hàng tạo</th>
                <th>Ngày tạo</th>
                <th>Người nhận</th> 
                <th>Ghi chú</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
          </tr>
       </thead>
       <tbody>


<?php if ($orderList == -1): ?>
    <tr><td colspan="8" rowspan="" headers="">Không có dữ liệu!</td></tr>
<?php else: ?>

<?php foreach ($orderList as $key => $v): 
    $id = $v['id']; 
?>
    <tr data-toggle="collapse" data-target="#q<?php echo $v['id'];?>" class="accordion-toggle <?php if($key%2!=0) echo "tr_col"; ?>">
        <td><?php echo $v['code']; ?></td>
        <td><?php if($v['id_customer']){
                $customer = Customer::model()->findByPK($v['id_customer']);
                echo $customer['fullname'];
            }else{ echo ""; } ?>     
        </td>
        <td><?php echo $v['create_date']; ?></td>
        <td><?php echo $v['name_recipient']; ?></td>
        <td><?php echo $v['note']; ?></td>
        <td class="autoNum"><?php echo $v['sum_amount']; ?></td>
        <td> 
            <?php 
            if($v['status']== '1'){
                echo '<span class="label label-primary">new</span>';
            }
            if($v['status']== '2'){
                 echo '<span class="label label-warning">pending</span>';
            }
            if($v['status']== '3'){
                echo '<span class="label label-success">completed</span>';
            }
            if($v['status']== '4'){
                echo '<span class="label label-danger">cancel</span>';
            }
        ?>
        </td>
    </tr>
    <tr >
        <input type="hidden" name="id_order" value="<?php echo $v['id']; ?>">
        <td colspan="7" class="hiddenRow">
            <div class="accordian-body collapse oView col-md-12" id="q<?php echo $v['id'];?>">
                <div class="oViewDetail col-md-12">
    <div id="oInfo" class="col-md-12">
    <div class="col-md-6 text-left">
        <div class="row">
            <table>
                <tbody>
                    
                    <tr>
                        <th class="text-left">Mã đơn hàng: </th>
                        <td class="text-left"><?php echo $v['code']; ?></td>
                    </tr>
                    <tr>
                        <th  class="text-left">Ngày tạo : </th>
                        <td  class="text-left"><?php echo $v['create_date']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <table class="pull-right">
                <tbody>
                     <tr>
                        <th class="text-left">Người nhận: </th>
                        <td class="text-left"><?php echo $v['name_recipient']; ?></td>
                    </tr>
                    <tr>
                        <th class="text-left">SDT người nhận: </th>
                        <td class="text-left"><?php echo $v['phone_recipient']; ?></td>
                    </tr>
                     <tr>
                        <th class="text-left">Đ/C người nhận: </th>
                        <td class="text-left"><?php echo $v['address_recipient']; ?></td>
                    </tr>

                    
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="col-md-12 text-right"><span>Đơn vị: VNĐ</span></div>
    <div class="col-md-12 oViewB">
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
    <?php $orderDetails = array_filter($orderDetail,function($v) use ($id){
            if($v['id_order'] == $id)
                return true;
        });
    ?>
    <?php foreach ($orderDetails as $key => $value): ?>
                <tr>
                    
                    <td><?php echo $value['product_name']; ?></td>
                    <td><?php echo $value['qty']; ?></td>
                    <td class="autoNum"><?php echo $value['unit_price']; ?></td>
                 
                    <td class="autoNum"><?php echo $value['amount']; ?></td>
                </tr>
        
    <?php endforeach ?>

            </tbody>
        </table>
        <div class="col-md-6 pull-right">
            <table class="table sum">
                <tbody>
                    <tr>
                        <td class="text-right"><b>Tổng tiền:</b></td>
                        <td class="text-left"><b class="autoNum"><?php echo $v['sum_amount']; ?></b> VNĐ</td>
                    </tr>                               
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        <div id="pBtn" class="text-left">
            <button type="button" class="btn oBtnDetail print"  >In đơn hàng</button>
            <?php if($v['status']== '3' || $v['status']== '4'){ ?>
            <button  class="btn detail " style="background:#ccc;">cập nhật</button>
            <?php }else{ ?>
            <a type="" class="btn oBtnDetail qUpdate" data-toggle="modal" data-target="#update_order_modal" title="" style="color: #fff;">Cập nhật</a>
            <?php } ?>
        </div>
        <?php if(($v['status'] == 3) || ($v['status'] == 4)) {?>
        <div id="pBtn" class="text-right">
            <button  class="btn detail " style="background:#ccc;">Hủy đơn hàng</button>
            
        </div>
        <?php  }else{?>

        <div id="pBtn" class="text-right">
            <button  class="btn btn-danger" onclick="deleteOrder(<?php echo $id; ?>);">Hủy đơn hàng</button>
            
        </div>
        <?php } ?>
    </div>
</div>
            </div>
        </td>
    </tr>
    
<?php endforeach ?>
<?php endif ?>
       </tbody>
    </table>
</div>

<div style="clear:both"></div>
<div id="" class="row fix_bottom">
    <?php if($page_list) echo $page_list;?>
</div>

<script>
$(function(){
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('.autoNum').autoNumeric('init',numberOptions);
})
</script>