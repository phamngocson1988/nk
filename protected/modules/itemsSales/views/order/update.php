 <?php $baseUrl = Yii::app()->getBaseUrl(); 
   $user_name  =  Yii::app()->user->getState('name');
    $user_id    = Yii::app()->user->getState('user_id');
    $user_group = Yii::app()->user->getState('group_id');     ?>

<style> 
.sHeader{background: #0eb1dc; color: white; padding: 8px 30px; font-size: 18px;}
    .padding_left_0 {padding-left: 0 !important;}
    #frm-update-order .form-group{margin: 0;}
    #frm-update-order input[type=checkbox] {margin: 28px 21px 0px;}
    #frm-update-order #sAddNote {margin-bottom: 15px;}
    #frm-update-order table th,#frm-update-order table th{background: white; color: black;}
    #usProduct table td {padding: 0 5px; border: 0;}
    #frm-update-order .cal_ans {background: white; border: 0; box-shadow: none; cursor: default; text-align: center;}
    #frm-update-order .select2-container--disabled .select2-selection{cursor: default;}
    #usProduct {max-height: 250px; overflow: auto;}

    .sbtnAdd {padding: 2px 6px; background: #94c63f; color: white;}
    .Submit { background: #94c63f;}
    #sSumo {padding-top: 10px; border-top: 2px solid #ddd; margin-top: 10px;}
    #sInvoice {padding-bottom: 10px; border-bottom: 2px groove #ddd;}
    #sIFax {padding-bottom: 8px;margin-bottom: 8px;}
    a.sCDiscount img {
    width: 17px; 
    margin-top: 26px;}  
   


</style>

<div class="modal-dialog modal-lg">
    <div class="modal-content order-edit-container">
 
    <div class="modal-header sHeader">
        Cập Nhật hóa đơn
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body">
        <div class="row">

            <?php /** @var TbActiveForm $form */
            $form = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                 array(
                    'id' => 'frm-update-order',
                    'enableAjaxValidation'=>false,
                    'clientOptions' => array(
                        'validateOnSubmit'=>true,
                        'validateOnChange'=>true,
                        'validateOnType'=>true,
                    ),
                    'htmlOptions'=>array(  
                        'enctype'   => 'multipart/form-data'                        
                    ),
                )
            ); ?>
             <?php echo CHtml::errorSummary($order) ?> 
            <!--   -->
            <input type="hidden" name="" id="code_number" value="<?php echo $code_number;?>">
            <?php 
                echo $form->hiddenField($order,'id');
                $branch     = Branch::model()->findAll();
                $branchList = CHtml::listData($branch, 'id', 'name');
                echo "<div class='col-md-4'>";      // văn phòng
                echo $form->dropDownListGroup($order, 'id_branch',
                    array(
                        'widgetOptions' => array(
                            'data' => $branchList,
                            'htmlOptions' => array(),
                )));
                echo "</div>";

                echo "<div class='col-md-4'>";      // Người tạo
                echo $form->labelEx($order,'Người tạo');
                $id_user = $order['id_author'];
                $user = GpUsers::model()->findByAttributes(array('id'=>$id_user));
                echo CHtml::textField('author',$user['name'],
                    array('class'=>'form-control', 'readOnly'=>true
                ));
                echo "</div>"; 
                echo "<div class='col-md-4'>";      // Người đặt hàng
                echo $form->labelEx($order,'Người đặt hàng');
                $id_customer = $order['id_customer'];
                $customer = Customer::model()->findByAttributes(array('id'=>$id_customer));
                echo CHtml::textField('customer',$customer['fullname'],
                    array('class'=>'form-control', 'readOnly'=>true
                ));
                echo "</div>"; 
            ?>
                <div class="clearfix" style="margin-top: 10px;"></div>
                <div class='col-md-3'>
                     <label  class='col-md-12 row'>Hình thức thanh toán</label>
                        <select id="VOrder_payments" name="VOrder[payments]" class="form-control">
                            <option <?php if($order['payments'] == 1){ echo "selected"; }?> value="1">Tiền mặt</option>
                            <option <?php if($order['payments'] == 2){ echo "selected"; }?> value="2">Chuyển khoản</option>
                            <option <?php if($order['payments'] == 3){ echo "selected"; }?> value="3">Thẻ tín dụng</option>
                         </select>
                </div> 
                <div class='col-md-3'>
                     <label  class='col-md-12 row'>Trạng thái</label>
                        <select id="Order_status" name="VOrder[status]" class="form-control">
                            <?php if($order['status'] == 1){ ?>
                            <option <?php if($order['status'] == 1){ echo "selected"; }?> value="1">New</option>
                            <option <?php if($order['status'] == 2){ echo "selected"; }?> value="2">Pending</option>
                            <option <?php if($order['status'] == 3){ echo "selected"; }?> value="3">Completed</option>
                            <option <?php if($order['status'] == 4){ echo "selected"; }?> value="4">Cancel</option>
                            <?php } elseif($order['status'] == 2){ ?>
                            <option <?php if($order['status'] == 2){ echo "selected"; }?> value="2">Pending</option>
                            <option <?php if($order['status'] == 3){ echo "selected"; }?> value="3">Completed</option>
                            <option <?php if($order['status'] == 4){ echo "selected"; }?> value="4">Cancel</option>
                            <?php  } elseif($order['status'] == 3){?>
                            <option <?php if($order['status'] == 3){ echo "selected"; }?> value="3">Completed</option>
                            <?php } elseif($order['status'] == 4){ ?>
                            <option <?php if($order['status'] == 4){ echo "selected"; }?> value="4">Cancel</option>?>
                            <?php }?>
                         </select>
                </div> 
             
                <div class='clearfix'></div>
                <div style="margin-top: 30px; margin-left:15px;">
                    <ul class="nav nav-tabs">
                      <li class="active"><a data-toggle="tab" href="#sanpham1">Sản phẩm</a></li>
                      <li><a data-toggle="tab" href="#khachhang1">Khách hàng nhận</a></li>
                    </ul>
                </div>
                <div class="tab-content" style="padding-top: 10px;">
                     <div id="sanpham1" class="tab-pane fade in active">   
                        <div id="usProduct" class="col-md-12 product">
                            <table class="table sItem">
                                <thead>
                                    <tr>
                                        <th class="qc1">STT</th>
                                        <th class="qc1">Sản phẩm</th>
                                        <th class="qc3">Số lượng</th>
                                        <th class="qc4">Đơn giá</th>
                                        <th class="qc6">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $this->renderPartial('update_item',array(
                                        'orderdetail'=>$orderdetail,
                                        'form'          =>$form,
                                        'i'             =>$i,
                                    ));?>

                                </tbody>
                            </table>
                        </div> <!--table san pham -->

                        <div id="sSumo" class="col-md-12">
                            <div class="row">
                                <div id="sMore" class="col-md-4">
                                    <button id="upAddProduct" class="btn sbtnAdd "><span class="glyphicon glyphicon-plus"></span> Sản phẩm</button>
                                </div>
                                <div id="sInvoice" class="col-md-6 pull-right">
                                    <div id="" class="col-md-10" style="text-align: right; float: right;">
                                        <div class="form-group">
                                            <label class="col-md-6 text-right q_label control-label" for="sum_amount">Tổng cộng</label>
                                            <div class='col-md-5 row'>
                                                <input required="required" readonly="1" class="cal_ans autoNum form-control" type="text"  name="t_sum_amount" id="t_sum_amount"  value="<?php echo $order['sum_amount'];?>">
                                                <input id="h_sum_amount" name="VOrder[sum_amount]"  type="hidden" value="<?php echo $order['sum_amount'];?>">
                                            </div>
                                        </div>

                                <!-- end-->
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div> <!-- end div sanpham -->
                    <div id="khachhang1" class="tab-pane fade">
                         <?php
                            echo "<div class='clearfix' style='margin-bottom:15px;'></div>";

                            echo "<div class='col-md-4'>";
                            echo $form->textFieldGroup($order,'name_recipient',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control')),'labelOptions' => array("label" => 'Khách hàng'))); 
                            echo "</div>";

                            echo "<div class='col-md-4'>";
                            echo $form->numberFieldGroup($order,'phone_recipient',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control')),'labelOptions' => array("label" => 'Phone'))); 
                            echo "</div>";
                            echo "<div class='col-md-4'>";
                            echo $form->emailFieldGroup($order,'email_recipient',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control')),'labelOptions' => array("label" => 'Email'))); 
                            echo "</div>";

                            echo "<div class='col-md-8'>";
                            echo $form->textAreaGroup($order,'address_recipient',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control')),'labelOptions' => array("label" => 'Địa chỉ'))); 
                            echo "</div>";
                        ?>
                        <div class='clearfix'></div>
                           
                    </div><!-- end div khachhang -->
                </div> <!-- div content tab-->
                <div id="sCheck" class="col-md-4">
                    <div class="col-md-6">
                      <a href="#" class="sNote">Thêm ghi chú</a>
                    </div>
                </div>

                <div id="usAddNote" class="col-md-12 hidden">
                    <?php echo $form->textAreaGroup($order,'note',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control')),'labelOptions' => array("label" => 'Ghi chú'))); ?>
                </div>
                <div id="sFooter" class="col-md-12 text-right"> 
                    <button class="btn sCancel" data-dismiss="modal">Hủy</button>
                    <button class="btn Submit" id="sSubmit" type="submit">Xác nhận</button>
                </div>
        </div>
    </div>
  </div>
</div>
<?php $this->renderPartial('update_js',array(
        'x'=>$i,
        'orderdetail'=>$orderdetail,
        'order_up'=>$order_up,
        'form'=>$form,
    )); ?> 
<?php
$this->endWidget();
unset($form);?>
