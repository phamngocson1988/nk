<style>
	.sHeader{background: #0eb1dc; color: white; padding: 8px 30px; font-size: 18px;}
	.alert{margin-bottom: 0px;}
	.Submit { background: #94c63f;color: white;}

	.pay_date {padding: 10px;}

	.text input, .text .input-group-addon {border: 0; background: white !important; box-shadow: none;}
	.red {color: red;}
</style>
<div class="modal-dialog modal-lg">
    <div class="modal-content quote-edit-container">
    	<div class="modal-header sHeader">
	        Thanh toán đơn hàng số <?php echo $orderPay['code']; ?>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    </div>
<?php /** @var TbActiveForm $form */
	$form = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		 array(
	        'id' => 'frm-pay-invoice',
	        'type' => 'horizontal',
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
	   	<div class="modal-body">
			<div class="alert alert-success"">
			<input type="hidden" name="hidden_balance" value="<?php echo $balance; ?>">
				<table>
					<tr>
						<th class="text-right">Tổng tiền đơn hàng</th>
						<td class="text-left"><span class="autoNum"><?php echo $orderPay['sum_amount']; ?></span> VNĐ</td>
					</tr>
					<tr>
						<th class="text-right">Số tiền còn nợ</th>
						<td class="text-left"><span class="autoNum"><?php  echo $balance; ?></span> VNĐ</td>
					</tr>
				</table>
			</div>

			<div class="alert">
		
				<h3>Hình thức thanh toán</h3>
				
				<ul class="nav nav-tabs">
				  	<li class="active"><a data-toggle="tab" id="1" href="#cash">Tiền mặt</a></li>
				  	<li><a data-toggle="tab" id="2" href="#credit">Thẻ tín dụng</a></li>
				  	<li><a data-toggle="tab" id="3" href="#transfer">Chuyển khoản</a></li>
				  	<li class="pull-right pay_date">Ngày thanh toán: <span class="today"></span></li>
				</ul>

<div class="tab-content">
	<div id="cash" class="tab-pane fade in active">
		<div class="alert">
			
		</div>
	</div>

	<div id="credit" class="tab-pane fade">
		<div class="alert">
			
		</div>
	</div>

	<div id="transfer" class="tab-pane fade">
		<div class="alert">
			
		</div>
	</div>

	<?php 
		echo $form->hiddenField($orderPay,'id');
		echo $form->hiddenField($invoice_pay,'pay_type',array('class'=>'pay_type'));

		echo "<div class='col-sm-6'>";		// số tiền thanh toán
		echo $form->textFieldGroup($invoice_pay, 'pay_amount',
			array(
				'wrapperHtmlOptions' 	=> array('class' => 'col-sm-7',),
				'append' 				=> 'VNĐ',
				'widgetOptions' 		=> array(
					'htmlOptions' 		=> array(
						'value'	=>	$balance,
						'class'	=>	'autoNum text-right pay_amount pay refund'),),
				'labelOptions' =>array('class'=>"col-sm-5"),
		));
		echo "</div>";

		echo "<div class='col-sm-6'>";		// bảo hiểm trả
		echo $form->textFieldGroup($invoice_pay, 'pay_insurance',
			array(
				'wrapperHtmlOptions' 	=> array('class' => 'col-sm-7',),
				'append' 				=> 'VNĐ',
				'widgetOptions' 		=> array(
					'htmlOptions' 		=> array(
						'value'	=>	'0',
						'class'	=>	'autoNum text-right pay_insurance pay'),),
				'labelOptions' =>array('class'=>"col-sm-4"),
		));
		echo "</div>"; ?>

		<div class="clearfix"></div>

		<!-- tien nhan tu khach -->
		<div class="col-sm-6">
			<div class="form-group">
    			<label for="pay_receive" class="col-sm-5 control-label">Số tiền nhận</label>
			    <div class="col-sm-7">
			    	<div class="input-group">
					  	<input type="text" class="autoNum form-control text-right refund" id="pay_receive" value="<?php echo $balance; ?>" aria-describedby="basic-addon1">
					  	<span class="input-group-addon">VNĐ</span>
					</div>
			    </div>
			</div>
		</div>

		<?php 
			echo "<div class='col-sm-6'>";		// khuyến mãi
			echo $form->textFieldGroup($invoice_pay, 'pay_promotion',
				array(
					'wrapperHtmlOptions' 	=> array('class' => 'col-sm-7',),
					'append' 				=> 'VNĐ',
					'widgetOptions' 		=> array(
						'htmlOptions' 		=> array(
							'value'	=>	'0',
							'class'	=>	'autoNum text-right pay_promotion pay'),),
					'labelOptions' =>array('label'=>'Khuyến mãi','class'=>"col-sm-4"),
			));
			echo "</div>";
		?>
	
		<div class="clearfix"></div>

		<!-- tien trả cho khach -->
		<div class="col-sm-6 text">
			<div class="form-group">
    			<label for="pay_refund" class="col-sm-5 control-label">Số tiền hoàn trả</label>
			    <div class="col-sm-7">
			    	<div class="input-group">
					  	<input type="text" class="form-control text-right refund autoNum" id="pay_refund" placeholder="0" aria-describedby="basic-addon1">
					  	<span class="input-group-addon">VNĐ</span>
					</div>
			    </div>
			</div>
		</div>

		<?php echo "<div class='col-sm-6 text'>";		// còn nợ
		echo $form->textFieldGroup($invoice, 'balance',
			array(
				'wrapperHtmlOptions' => array('class' => 'col-sm-7',),
				'append' => 'VNĐ',
				'widgetOptions' => array(
					'htmlOptions' => array('readOnly'=>true,'class'	=>'autoNum text-right balance red','value'=>'0'),),
				'labelOptions' =>array('class'=>"col-sm-4"),
		));
		echo "</div>"; ?>

		<div class="clearfix"></div>
		
	<div class="ocf text-right" >
		<button type="button" class="btn" data-dismiss="modal">Hủy</button>
		<button type="submit" class="btn Submit">Xác nhận</button>
	</div>
<?php
$this->endWidget();
unset($form);?>
				</div>
			</div>
	    </div>
    </div>
</div>

<?php include 'orderPay_js.php'; ?>