<style>
    .hiddenRow{ background-color: transparent !important;}
    .accordian-body {background: #fff;}
    .tableList{padding: 0px;}
    #frm-order .cal_ans{border: 1px solid #ccc !important;}
    #sInvoice{padding-bottom: 20px;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2.min.css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/select2.full.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/autonumeric.js"></script>
<a class="btn_plus create_order" data-toggle="modal" data-target="#order_modal" style="float: right;margin-bottom: 10px;margin-top: 10px;"></a>
<input type="hidden"  id="code_number" value="<?php echo $model->code_number;?>">
<div class="col-md-12 tableList" id="OrderList"> 
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
       <tbody style="background: #f3f3f3;">
        <?php if ($orderList == -1): ?>
            <tr><td colspan="8" rowspan="" headers="">Không có dữ liệu!</td></tr>
        <?php else: ?>

        <?php foreach ($orderList as $key => $v): 
            $id = $v['id']; 
        ?>
            <tr data-toggle="collapse" data-target="#q<?php echo $v['id'];?>" class="accordion-toggle" style="border-bottom: 1px solid #fff;">
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
                <td colspan="7" class="hiddenRow" style=" padding: 0 !important;">
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
                                    <button  class="btn " style="background:#ccc;">cập nhật</button>
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

<div id="order_modal" class="modal fade">

</div>

<div id="update_order_modal" class="modal fade">

</div>
<script>
$( document ).ready(function() {
    //create 
     $('.create_order').click(function(e){
        $('.cal-loading').fadeIn('fast');
        var code_number = $("#code_number").val();
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSales/order/create')?>",
            datatype:'json',
            data: {
                'code_number'        : code_number,
            },
            success:function(data){
                
                if(data){
                    $("#order_modal").html(data);
                    $('.cal-loading').fadeOut('slow');
                }
            },
            
        });
    });
    // export excel
    $('#OrderList').on('click','.print',function(e){
        var id_order = $(this).parents('tr').find('input:hidden[name=id_order]').val();
        var url="<?php echo Yii::app()->createUrl('itemsSales/order/exportOrder')?>?id_order="+id_order;
        window.open(url,'name');
       
    });

    //update

    $('#OrderList').on('click','.qUpdate',function(e){
         var id_order = $(this).parents('tr').find('input:hidden[name=id_order]').val();
       
    if(!id_order)
            return;
        $('.cal-loading').fadeIn('fast');
        var code_number = $("#code_number").val();
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSales/order/updateOrder')?>",
            datatype:'json',
            data: {
                id_order        : id_order,
                code_number     : code_number
            },
            success:function(data){
               
                if(data){
                    
                    $("#update_order_modal").html(data);
                    $('.cal-loading').fadeOut('slow');
                   
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },     
           
        });
    });
});

$(function(){
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('.autoNum').autoNumeric('init',numberOptions);
})

function deleteOrder(id_order) {
    if(confirm("Bạn có thực sự muốn hủy đơn hàng?")) {
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSales/order/deleteOrder')?>",
            data: {
               id_order: id_order,
            },
            success:function(data){
                if(data == 1){
                    alert("Hủy thành công!");
                    location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsCustomers/Accounts/admin?code_number=<?php echo $model->code_number;?>'
                }
                else if(data == -1)
                    alert(data);
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    } 
}

 
</script>
