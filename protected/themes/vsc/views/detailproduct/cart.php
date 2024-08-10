<?php  $baseUrl = Yii::app()->getBaseUrl();  ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2/autonumeric.js"></script>
<style type="text/css">
.title{
    font-size: 30px;
    color: rgb(75, 75, 75);
    font-weight: bold;
    margin-top: 30px;
    margin-bottom: 30px;
}
.table{
    border-collapse: collapse;
    border: 1px solid #ccc;
    
}
.table .table-title{
    color: rgb(75, 75, 75);
    font-size: 16px;
    font-weight: bold;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    line-height: 1.5;
    border-top: none;
    text-align: center;
    border: 1px solid #ccc;
}
.title-1{
    font-size: 25px;
    color: rgb(75, 75, 75);
    margin-top: 10px;
    margin-bottom: 20px;
}
 
.btn{
background: #fff;
border: 1px solid #ccc;
padding: 10px 10px;
font-size: 18px;
margin-top: 30px;
margin-right: 10px;
}
.btncar{
color: #FFF;
background:#9ec63b;
}
.cart-table .item-img figure {
    width: 120px;
    float: left;
    margin-right: 30px;
}
.item-name {
    font-size: 16px;
    line-height: 24px;
    margin-top: 50px;
    text-align: left;
}
.item-price-special{
    font-size: 16px;

}
.tt{
    width: 85%;
    float: right;
}
.item-td{
    margin-top: 50px;
}

@media only screen and (min-width:300px) and (max-width: 765px){

.table{ 
border-collapse: collapse;
border: 1px solid #ccc;

}
.table .table-title{
color: rgb(75, 75, 75);
font-size: 16px;
font-weight: bold;
}
.table td {
border: 1px solid #ccc;
text-align: center;
padding: 0px 7px 0px 10px;
background: #ffffff;
}
.table tr td { 
background: #FFF;    
color: #47433F;

}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
line-height: 1.5;
border-top: none;
text-align: center;
border: 0px solid #ccc;
}
#shop-cart thead {
display: none;
}
#shop-cart tr {
display: block;
}
#shop-cart td {
display: block;
text-align: right;
font-size: 13px;
border-bottom: 0px solid #ccc;

}
#shop-cart .rowItems{
margin-top: 50px;
border-top: 1px solid #ccc;
}
#shop-cart td:last-child {
border-bottom: 0;
}
#shop-cart td:before {
content: attr(data-label);
float: left;
text-transform: uppercase;
font-weight: bold;
}
.table #shop-cart {
width: 100%;
}
.qty{
    width: 30%;
}
.cart-table .item-img figure {
    width: 100%;
    float: left;
    margin-right: 30px;
}
.tt{
    width: 100%;
    
}
.item-td{
    margin-top: 0px;
}
}
tr:hover i {
    display: inline;
}
.glyphicon-trash {
    display: none;
    cursor: pointer;
    margin-left: 10px;
}
</style>

<div class="container" style="min-height: 1020px; ">
    <div class="row">
        <div class="col-md-12">
            <p class="title">GIỎ HÀNG</p>
            <div class="row">
                <div class="col-md-12 " id="shop-cart">
                    <table class="table cart-table">
                        <thead>
                        <tr>
                            <th class="table-title">Sản phẩm</th>
                            <th class="table-title">Giá</th>
                            <th class="table-title">Số lượng</th>
                            <th class="table-title">Tổng cộng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($cart){
                              foreach($cart as $key => $val){ 
                                $id_product = $val['id'];
                                $img = ProductImage::model()->findByAttributes(array('id_product'=>$id_product));
                                $sl_gia = $val['price']*$val['qty'];
                               
                        ?>
                                <tr class="rowItems">
                                
                                    <td class="item-img" >
                                        <figure><img class="img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?php echo $img['url_action'] ?>/lg/<?php echo $img['name_upload'] ?>"/></figure>
                                        <header class="item-name">
                                          <?php echo $val['name'];?>
                                        </header>
                                    </td>
                                    <td data-label="Giá">
                                        <input  type="hidden" name="key" class="key" value="<?php echo $key; ?>">
                                        <p class="item-price-special autoNum item-td" ><?php echo $val['price']; ?></p>
                                         <input style="display: none;" id="priceRow<?php echo $key; ?>" value="<?php echo $val['price']; ?>" >
                                    </td>
                                    <td data-label="Số lượng" >
                                        <input style="width:150px;border-radius: 2px;border: 1px solid #ccc;padding: 3px 15px;" class="item-td" onchange="sumNumberPriceRow(<?php echo $key; ?>);" type="number" min="1" class="qty" id="qtyRow<?php echo $key; ?>" value="<?php echo $val['qty']; ?>">
                                        <input type="hidden" id="stock<?php echo $key; ?>" value="<?php echo $val['stock']; ?>">

                                    </td>
                                    <td class="item-total-col" data-label="Tổng cộng">
                                        <p class="item-price-special autoNum hidden item-td " id="subtotalRow<?php echo $key; ?>"> 
                                        </p> 
                                        <p id="hidden<?php echo $key; ?>" class="item-td"><?php echo number_format($sl_gia,0, ',', '.');?>
                                        </p>
                                        <i class="glyphicon glyphicon-trash"  onclick="removeShopingCart(<?php echo $key;?>);" style="cursor: pointer;" ></i>
                                        <input style="display: none;" type="rowItemsTotal" class="rowItemsTotal" class="amount" id="subtotal<?php echo $key; ?>" value="<?php echo $val['price']*$val['qty']; ?>">
                                    </td>
                                    
                                </tr>
                        <?php   }
                               }
                        ?>
                        
                        </tbody>
                    </table>
                </div> <!-- end table-->
            </div> <!-- end row-->
           
            <div class="row">
                <div class="col-md-6 " style=" margin-top:30px;">
                   <p class="title-1">THÔNG TIN KHÁCH HÀNG</p>
                    <?php
                         $id_customer = Yii::app()->user->getState('customer_id'); 
                         $model = Customer::model()->findByPk($id_customer);
                    ?>
                        <form>
                            <div class="form-group">
                                <label >Họ tên<span style="color: #FF6D00">*</span></label>
                                <input class="form-control" type="text" id="name" name="name" value="<?php echo $model->fullname;?>" required style="width:80%" />
                            </div>
                            <div class="form-group">
                                <label>SDT <span style="color: #FF6D00">*</span></label>
                                <input class="form-control" type="number"  id="phone" name="phone" value="<?php echo $model->phone;?>" required style="width:80%" />
                            </div>
                            <div class="form-group">
                                <label >Email </label>
                                <input class="form-control" type="email"  id="email" name="email" value="<?php echo $model->email;?>" required style="width:80%"/>
                            </div>
                            <div class="form-group">
                                <label >Địa chỉ <span style="color: #FF6D00">*</span></label>
                                <input class="form-control"  id="address" name="address" value="<?php echo $model->address;?>" required style="width:80%"/>
                            </div>
                            <div class="form-group">
                                <label >Ghi chú</label>
                                <input class="form-control" type="text"  id="note" name="note" style="width:80%"/>
                            </div>
                            <p><i>Phần có dấu (<span style="color: #FF6D00">*</span>) là phần nội dung bắt buộc</i></p>
                        </form>
                </div>

                <div class="col-md-6 col-sm-12 col-xs-12" style="margin-top:30px;">
                    <div class="tt" >
                    <p class="title-1">THANH TOÁN</p>
                    <table class="table total-table ">
                        <tbody>
                       
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="table-title">Tổng tiền:
                            <input id="sumTotalCart" value="" style="display: none;" /></td>
                            <td class="item-price-special" ><span id="sumTotalCart1" class="autoNum"></span>  VND</td>
                        </tr>
                        
                        </tfoot>
                    </table>
                    <div class="md-margin"></div>
                    <button  id="order" class="col-xs-12 col-md-8 col-md-offset-2 btn  btncar"> ĐẶT MUA</button>
                    <a href="<?php echo $baseUrl; ?>/san-pham/"><button  class="col-xs-12 col-md-8 col-md-offset-2 btn  btncar" style="margin-bottom: 20px; ">SẢN PHẨM KHÁC</button> </a>
                 </div>
                </div> <!-- div 6-->
            </div> <!-- row 2 -->
        </div> <!-- div col-12-->
    </div><!-- row 3 -->
</div><!-- container -->
<div id="notify_sch" class="modal fade">
    <div class="modal-dialog" style="margin-top: 18%;">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center; font-size: 23px; background: rgb(25, 168, 224);color: #fff; ">
                Thông báo
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="noti_mess" style="text-align: center; ">Bạn đã đặt hàng thành công!</div>
            </div>
        </div>
    </div>
</div>
<script>
$('#notify_sch').on('hidden.bs.modal', function () {
    location.href = '<?php echo Yii::app()->params['url_base_http'] ?>/detailproduct/cart';
})
function changeSession(key, id, qty, amount,stock) {
    jQuery.ajax({
        type:"POST",
        url:"<?php echo CController::createUrl('detailproduct/changeSession')?>",
        data:{
            'key'   :  key,
            'id'    :  id,
            'qty'   :  qty,
            'amount':  amount,
            'stock':  stock,
        },
        success:function(data){
            
        },
    });
}
function removeShopingCart(rowCart){
    jQuery.ajax({
        type : "POST",
        url : "<?php echo CController::createUrl("detailproduct/removeShopingCart");?>",
        data : {
            "rowCart" : rowCart,
        },
        success : function(data){
            if(data){
               window.location.href = '<?php echo CController::createUrl("detailproduct/cart");?>';
            }
        }
     });

}
$(document).ready(function(){
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('.autoNum').autoNumeric('init',numberOptions);
    $('tr.rowItems').on('change','.qty', function() {
        var key = $(this).parents('tr').find('.key').val();
        var id = 1;
        var qty = $(this).parents('tr').find('.qty').val();
        var amount = $(this).parents('tr').find('.rowItemsTotal').val();
        var stock = $(this).parents('tr').find('.stock').val();
        changeSession(key, id, qty, amount,stock);

    });
    sumTotalCart();
});

function sumNumberPriceRow(id) {
    var price =  $("#priceRow"+id).val();
    var qty =  $("#qtyRow"+id).val();
    var stock =  $("#stock"+id).val();

    if(qty >stock){
        alert('Số lượng hiện tại không đủ. Vui lòng chọn lại!');
        var qty =  $("#qtyRow"+id).val(1);
        var totalPriceRow = 1 * parseInt(price);
        $("#subtotal"+id).val(totalPriceRow);
        $("#subtotalRow"+id).autoNumeric('set',totalPriceRow);
        $("#subtotalRow"+id).removeClass('hidden');
        $("#hidden"+id).addClass('hidden');
         sumTotalCart();
         
    }
    else{
        var totalPriceRow = parseInt(price)*parseInt(qty);
        $("#subtotal"+id).val(totalPriceRow);
        $("#subtotalRow"+id).autoNumeric('set',totalPriceRow);
       
        $("#subtotalRow"+id).removeClass('hidden');
        $("#hidden"+id).addClass('hidden');
         sumTotalCart();
    }
   
}

function sumTotalCart(){
    var total = 0;
     $(".rowItems").each(function( index ) {
        var rowTotal = $(this).find('.rowItemsTotal').val();
        total = parseInt(total) + parseInt(rowTotal);
    });
    $("#sumTotalCart").val(total);
    $("#sumTotalCart1").autoNumeric('set',total);     
}    
 $(document).ready(function(){
        $('#order').click(function(){
            var name            = $("#name").val();
            var phone           = $("#phone").val();
            var email           = $("#email").val();
            var address         = $("#address").val();
            var note            = $("#note").val();
            var sumTotalCart    = $("#sumTotalCart").val();
            jQuery.ajax({   
            type:"POST",
            url:"<?php echo CController::createUrl('detailproduct/AddCart')?>",
            data:{
                'name':  name,
                'phone':  phone,
                'email':  email,
                'address':  address,
                'note':  note,
                'sumTotalCart' :sumTotalCart,
            },
            
            success:function(data){
                console.log(data); 
                if(data == -1){
                    alert('Vui lòng điền đầy đủ thông tin! ');
                }
                if(data >0){
                    $('#notify_sch').modal('show'); 
                }   
            },
            });
        });
});
</script>