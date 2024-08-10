<?php 
    $baseUrl = Yii::app()->getBaseUrl(); 
    $user_name  =  Yii::app()->user->getState('name');
    $user_id    = Yii::app()->user->getState('user_id');
    $user_group = Yii::app()->user->getState('group_id');     
?>

<style> 
    .sHeader{background: #0eb1dc; color: white; padding: 8px 30px; font-size: 18px;}
    .padding_left_0 {padding-left: 0 !important;}
    #frm-order .form-group{margin: 0;}
    #frm-order input[type=checkbox] {margin: 30px 21px 0px;}
    #frm-order #sAddNote {margin-bottom: 15px;}
    #frm-order table th,#frm-order table th{background: white; color: black;}
    #sProduct table td {padding: 0 5px; border: 0;}
    a.sCDiscount img {width: 17px;margin-top: 26px;}
    #frm-order .cal_ans {background: white; border: 0; box-shadow: none; cursor: default;text-align: center;} 
    #frm-order .form-control[disabled] {background: white; border: 0; box-shadow: none; cursor: default;}
    #sProduct {max-height: 250px; overflow: auto;}
    .sbtnAdd {padding: 2px 6px; background: #94c63f; color: white;}
    .Submit { background: #94c63f;}
    #sSumo {padding-top: 10px; border-top: 2px solid #ddd; margin-top: 10px;}
    #sInvoice {border-bottom: 2px groove #ddd;}
    #sIFax {border-bottom: 1px solid #ddd;margin-bottom: 8px;}

    .q_label {margin-top: 8px;} 
    select.select2-hidden-accessible {bottom: 1%;}

    .inp_price {padding: 6px 4px;}

  

</style>

<div class="modal-dialog modal-lg">
    <div class="modal-content order-container">

        <div class="modal-header sHeader">
            Lập Hóa Đơn
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
            <div class="row">

            <?php /** @var TbActiveForm $form */
            $form = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                 array(
                    'id' => 'frm-order', 
                    'enableAjaxValidation'=>true,
                    'clientOptions' => array(
                        'validateOnSubmit'=>true,
                        'validateOnChange'=>true,
                        'validateOnType'=>true,
                    ),
                    'enableClientValidation'=>true,
                    'htmlOptions'=>array(  
                        'enctype'   => 'multipart/form-data'                        
                    ),
                )
            ); ?>
            <input type="hidden" name="" id="code_number" value="<?php echo $code_number;?>">
            <?php
                $branch             =   Branch::model()->findAll();
                $branchList         =   CHtml::listData($branch, 'id', 'name');
                
                echo "<div class='col-md-4'>";      // văn phòng
                echo $form->dropDownListGroup($order, 'id_branch',
                    array(
                        'widgetOptions' => array(
                            'required'    =>true,
                            'data'        => $branchList,
                            'htmlOptions' => array('required'=>true),
                )));
                echo "</div>";
                echo "<div class='col-md-4' style='margin-bottom:15px;'>";      // Người tạo
                echo $form->labelEx($order,'id_author');
                echo $form->hiddenField($order,'id_author',array('value'=>$user_id));
                echo CHtml::textField('author',$user_name,
                    array('class'=>'form-control', 'readOnly'=>true,'required'=>true
                ));
                echo "</div>";
                ?>
                <div class='col-md-4'>
                    <p style="font-weight: 700;color:#333">Người đặt hàng</p>
                    <select id="Order_id_customer" name="Order[id_customer]" class="form-control" required="required">
                    </select>
                </div>
                <div class='clearfix'></div> 
                <div class='col-md-4'>
                    <label  class='col-md-12 row'>Hình thức thanh toán</label>
                        <select id="Order_payments" name="Order[payments]" class="form-control">
                            <option value="1">Tiền mặt</option>
                            <option value="2">Chuyển khoản</option>
                            <option value="3">Thẻ tín dụng</option>
                         </select>
                </div>
                <div class='col-md-4'>
                    <label  class='col-md-12 row'>Trạng thái</label>
                        <select id="Order_status" name="Order[status]" class="form-control">
                            <option value="1">New</option>
                            <option value="2">Padding</option>
                            <option value="3">Completed</option>
                            <option value="4">Cancel</option>
                         </select>
                </div> 

                <div class='clearfix'></div>
                <div style="margin-top: 30px; margin-left:15px;">
                    <ul class="nav nav-tabs">
                      <li class="active"><a data-toggle="tab" href="#sanpham">Sản phẩm</a></li>
                      <li><a data-toggle="tab" href="#khachhang">Khách hàng nhận</a></li>
                    </ul>
                </div>  
                <div class="tab-content" style="padding-top: 20px;">
                  <div id="sanpham" class="tab-pane fade in active">        
                    <div id="sProduct" class="col-md-12">
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
                            <?php   
                                    $dataProduct = array();
                                    $unit = 0;
                                    $sum = 0;
                                    if($product) {
                                        $dataProduct = array($product['id']=>$product['name']);
                                        $unit = (int)$product['price'];
                                        $sum = $unit;
                                 } ?>
                               <?php $this->renderPartial('create_item',array(
                                        'orderdetail'    =>  $orderdetail,
                                        'form'           =>  $form,
                                        'dataProduct'    =>  $dataProduct,
                                        'unit'           =>  $unit,
                                        'sum'            =>  $sum,
                                        'i'              =>  $i,
                                    )); ?>
                     
                            </tbody>
                        </table>
                    </div>

                    <div id="sSumo" class="col-md-12">
                        <div class="row">
                            <div id="sMore" class="col-md-4">
                                <button id="addProduct" class="btn sbtnAdd "><span class="glyphicon glyphicon-plus"></span> Sản phẩm</button>
                            </div>
                            <div id="sInvoice" class="col-md-6 pull-right">
                        
                                    <div class="form-group">
                                        <label class="col-md-5 text-right q_label control-label" for="sum_amount">Tổng cộng:</label>
                                        <div class='col-md-5'>
                                            <input required="required" readonly="1" class="cal_ans autoNum form-control" type="text"  name="sum_amount" id="sum_amount_t">
                                            <input id="sum_amount_h" name="Order[sum_amount]"  type="hidden">
                                        </div>
                                    </div>
                                </div> 
                                            
                             </div>
                        </div>
                      </div> <!-- end div sanpham -->
                      <div id="khachhang" class="tab-pane fade">
                         <?php 
                            echo "<div class='col-md-4'>";  
                            echo $form->textFieldGroup($order_recipient,'name_recipient',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control')),'labelOptions' => array("label" => 'Khách hàng'))); 
                            echo "</div>";
                            echo "<div class='col-md-4'>";
                            echo $form->numberFieldGroup($order_recipient,'phone_recipient',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control')),'labelOptions' => array("label" => 'Phone'))); 
                            echo "</div>";
                            echo "<div class='col-md-4'>";
                            echo $form->emailFieldGroup($order_recipient,'email_recipient',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control')),'labelOptions' => array("label" => 'Email'))); 
                            echo "</div>";
                            echo "<div class='clearfix'></div>";
                            
                            echo "<div class='col-md-8'>";
                            echo $form->textAreaGroup($order_recipient,'address_recipient',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control')),'labelOptions' => array("label" => 'Địa chỉ'))); 
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

                    <div id="sAddNote" class="col-md-12 hidden">
                        <?php echo $form->textAreaGroup($order,'note',array('widgetOptions'=>array('htmlOptions'=>array()),'labelOptions' => array("label" => 'Ghi chú'))); ?>
                    </div>
                    
                    <div id="sFooter" class="col-md-12 text-right"> 
                        <button class="btn sCancel" data-dismiss="modal">Hủy</button>
                        <button class="btn Submit" id="sSubmit" type="submit">Xác nhận</button>
                    </div>
            </div>
        </div>
    </div>
</div>

<?php $this->renderPartial('create_js',array(
        'x'=>1,
        'orderdetail'=>$orderdetail,
        'form'=>$form,
        'id_customer'=>$id_customer,
    )); ?> 
<?php
$this->endWidget();
unset($form);?>