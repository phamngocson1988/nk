<?php 
 	$user_name = Yii::app()->user->getState('name');
    $user_id = Yii::app()->user->getState('user_id');
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header sHeader">
	        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        <h3 id="modalTitle" class="modal-title">Phiếu nhập hàng</h3>
	    </div>
	    <div class="modal-body">
	    	<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => 'frmCreateGR',
                'htmlOptions' 	=> array(
                    'class' 	=> '',
                    'enctype' 	=> 'multipart/form-data'
                ),
            )); ?>
            <div class="row">
            	<div class='col-md-4'>
	                <?php 
	                	echo $form->textFieldGroup($goodsReceipt, 'name', array(
	                        'widgetOptions' => array(
	                            'htmlOptions' => array()
	                    )));
	                ?>
	            </div>
            	<div class='col-md-4'>
            		<div class="form-group">
            			<label class="control-label">Kho</label>
            			<div>
		            		<select required="required" class="form-control" placeholder="Kho" name="GoodsReceipt[id_repository]">
								<option value="">--Chọn kho--</option>
								<?php 
									foreach ($listRepository as $key => $r):
										
										echo '<option value="'.$r['id'].'" '.(($r['id']==$infoItem['id_repository'])?'selected="selected"':"").'>'.$r['name'].'</option>';
									endforeach;
								?>
							</select>
							<input type="hidden" name="GoodsReceipt[id_purchase_requisition]" value="<?php echo $infoItem['id']; ?>">
						</div>
					</div>
            	</div>
            	<div class='col-md-4'>
                    <?php 
                        echo $form->labelEx($goodsReceipt, 'id_user');
                        echo $form->hiddenField($goodsReceipt, 'id_user', array('value' => $user_id));
                        echo CHtml::textField('author', $user_name, array('class' => 'form-control', 'readOnly' => true, 'required' => true));
                    ?> 
                </div>
                <div class="clearfix"></div>
                <div class='col-md-4'>
	                <?php 
	                	echo $form->textFieldGroup($goodsReceipt, 'create_date', array(
	                        'widgetOptions' => array(
	                            'htmlOptions' => array('class' => 'frm_datepicker create_date', 'readOnly' => true)
	                    )));
	                ?>
	            </div>
	            <div class='col-md-4'>
	                <?php echo $form->dropDownListGroup($goodsReceipt,'status',array('widgetOptions'=>array('data'=>array('1' => 'Hoàn tất'),'htmlOptions'=>array('required'=>'required', 'readOnly'=>true)))); ?>
	            </div>
	            <div class="col-md-8">
	            	<?php echo $form->textAreaGroup($goodsReceipt,'note', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>3, 'cols'=>30)))); ?>
	            </div>
	            <div class="col-xs-12 mt-30 tableMaterial">
	            	<table class="table sItem">
	                    <thead>
	                        <tr>
	                        	<th class="td1">STT</th>
	                            <th class="td2">Nguyên vật liệu</th>
	                            <th class="td3">Ngày hết hạn</th>
	                            <th class="td4">Số lượng</th>
	                            <th class="td5">Đơn vị tính</th>
	                            <th class="td6">Đơn giá</th>
	                            <th class="td7">Thành tiền</th>	
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<?php 
	                    		foreach ($infoItemDetail as $key => $d):
	                    		$infoMaterial = CsMaterial::model()->findByPk($d['id_material']);
	                    	?>
	                    		<tr class="currentRow t<?php echo $key; ?>">
	                    			<td><?php echo $key+1; ?></td>
	                    			<td>
										<?php
								            echo $form->textField($goodsReceiptDetail, "", array(
								                'class' 		=> 'form-control',
								                'value'			=> $infoMaterial['name'],
								                'placeholder' 	=> 'Nguyên vật liệu',
								                'readonly'		=> 'readonly'
								            ));
								        ?>
										<input type="hidden" value="<?php echo $infoMaterial['id']; ?>" name="GoodsReceiptDetail[<?php echo $key; ?>][id_material]">
	                    			</td>
	                    			<td>
						                <?php
								            echo $form->textField($goodsReceiptDetail, "[$key]expiration_date", array(
								                'class' 		=> 'form-control frm_datepicker',
								                'value'			=> '',
								                'placeholder' 	=> 'Ngày hết hạn',
								                'required'		=> 'true'
								            ));
								        ?>
	                    			</td>
	                    			<td>
	                    				<?php
								            echo $form->textField($goodsReceiptDetail, "[$key]qty", array(
								                'class' 		=> 'form-control qty',
								                'value'			=> $d['qty'],
								                'placeholder' 	=> 'Số lượng',
								                'required' 		=> true
								            ));
								        ?>
	                    			</td>
	                    			<td>
	                    				<?php
								            echo $form->textField($goodsReceiptDetail, "[$key]unit", array(
								                'class' 		=> 'form-control unit',
								                'value'			=> $d['unit'],
								                'placeholder' 	=> 'Đơn vị tính',
								                'readonly'		=> 'readonly'
								            ));
								        ?>
	                    			</td>
	                    			<td>
	                    				<?php
								            echo $form->textField($goodsReceiptDetail, "[$key]amount", array(
								                'class' 		=> 'form-control amount autoNum',
								                'value'			=> 0,
								                'placeholder' 	=> 'Đơn giá',
								                'required' 		=> true
								            ));
								        ?>
	                    			</td>
	                    			<td>
	                    				<?php
								            echo $form->textField($goodsReceiptDetail, "[$key]sumamount", array(
								                'class' 		=> 'form-control sumamount autoNum',
								                'value'			=> 0,
								                'placeholder' 	=> 'Thành tiền',
								                'readonly'		=> 'readonly'
								            ));
								        ?>
	                    			</td>
	                    		</tr>
	                    	<?php endforeach;?>
	                    	<tr>
	                    		<td colspan="7" class="text-right">
	                    			<b>Tổng tiền:</b>
	                    			<span class="text-total-amount amount"></span>
	                    			<input type="hidden" id="total-amount" name="GoodsReceipt[sum_amount]" value="">
	                    		</td>
	                    	</tr>
	                    </tbody>
	                </table>

	            </div>
	            <div id="sFooter" class="col-md-12 text-right mt-30">
		        	<button class="btn sCancel" data-dismiss="modal">Hủy</button>
		            <button class="btn Submit" id="sSubmit" type="submit">Lưu</button>
		        </div>
            </div>
	    </div>
	</div>
</div>
<script>
	var table 			= $('.tableMaterial table');
	var tbody 			= $(".tableMaterial tbody");
	$(document).ready(function(){
		$('.frm_datepicker').datepicker({
			minDate: 'today',
			dateFormat: 'dd/mm/yy',
		});
		$("#frmCreateGR .create_date").datepicker("setDate", new Date());
		var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    	$('.autoNum').autoNumeric('init',numberOptions);
    	sumTotalAmount();
	});
	/***** Thay đổi nguyên vật liệu *****/	
	$(tbody).on('change', '.listMaterial', function (e) {
		var select = $(this);
		var data = select.select2('data');
		if (data.length == 0) {
			return;
		}
		var unit = data[0].unit;
		var divTr = $(this).parents('tr');
		divTr.find('.unit').val(unit);
		sumTotalAmount();
	});
	/***** Change số lượng *****/
	var table = $(".tableMaterial tbody");
	$(table).on('keyup', '.qty', function (e) {
		var qty  		= $(this).val();
		var tableTr 	= $(this).parents('tr');
		var amount 		= tableTr.find('.amount').autoNumeric('get');
		var sumAmount 	= parseInt(qty) * parseInt(amount);
		tableTr.find('.sumamount').autoNumeric('set', sumAmount);
		sumTotalAmount();
	});
	/***** Change giá *****/
	$(table).on('keyup', '.amount', function (e) {
		var tableTr 	= $(this).parents('tr');
		var qty  		= tableTr.find('.qty').val();
		var amount 		= $(this).autoNumeric('get');
		var sumAmount 	= parseInt(qty) * parseInt(amount);
		tableTr.find('.sumamount').autoNumeric('set', sumAmount);
		sumTotalAmount();
	});
	/***** Tổng tiền *****/
	function formatNumber (num) {
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
	}
	function sumTotalAmount(){
		var total 		= 0;
		$(".tableMaterial tbody .sumamount").each(function( index ) {
			var rowTotal= $(this).autoNumeric('get');
			total 		= parseInt(total) + parseInt(rowTotal);
		});

		$(".tableMaterial tbody tr").find('.text-total-amount').html(formatNumber(total));
		$(".tableMaterial tbody tr").find('#total-amount').val(total);
	}
	/***** Tạo mới phiếu đề xuất *****/	
	$('form#frmCreateGR').submit(function(e) {
		e.preventDefault();
		$('form#frmCreateGR input').each(function() {
			if ($(this).hasClass('autoNum')) {
				var number = $(this).val();
				$(this).val(number.replace(/\./g, ""));
			}
		});
		var formData = new FormData($("#frmCreateGR")[0]);
		if (!formData.checkValidity || formData.checkValidity()) {
			$('.cal-loading').fadeIn('fast');
			$.ajax({
				type: "POST",
				url: "<?php echo CController::createUrl('purchaseRequisition/createGR')?>",
				data: formData,
				success: function (data) {
					$('.cal-loading').fadeOut('fast');
					var josn = JSON.parse(data);
					if (josn.status == 'successful') {
						$('#goodsReceiptModal').modal('hide');
						loadPurchaseRequisition();
					}else{
						$.jAlert({
	                        'title': "Thông báo",
	                        'content': "Có lổi xảy ra vui lòng thử lại."
	                    });
	                    $('#goodsReceiptModal').modal('hide');
					}
				},
				error: function (data) {
					alert("Error occured.Please try again!");
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}
		return false;
	});
</script>
<?php $this->endWidget(); unset($form);?>