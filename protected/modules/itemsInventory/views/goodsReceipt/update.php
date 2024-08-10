<div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header sHeader">
	        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        <h3 id="modalTitle" class="modal-title">Chỉnh sửa phiếu nhập kho</h3>
	    </div>
	    <div class="modal-body">
	    	<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => 'frmUpdate',
                'htmlOptions' 	=> array(
                    'class' 	=> '',
                    'enctype' 	=> 'multipart/form-data'
                ),
            )); ?> 
            <div class="row">
            	<div class='col-md-4'>
                    <?php
                    	echo $form->textFieldGroup($infoItem, 'name', array(
	                        'widgetOptions' => array(
	                            'htmlOptions' => array()
	                    )));
                    ?>

                </div>
                <div class='col-md-4'>
            		<div class="form-group">
            			<?php 
	                        echo $form->labelEx($infoItem, 'id_repository');
	                        echo $form->hiddenField($infoItem, 'id_repository', array('value' => $repository['id']));
	                        echo CHtml::textField('repository', $repository['name'], array('class' => 'form-control', 'readOnly' => true, 'required' => true));

	                        echo $form->hiddenField($infoItem, 'id', array('value' => $infoItem['id']));
	                    ?>
					</div>
            	</div>
            	<div class='col-md-4'>
                    <?php 
                        echo $form->labelEx($infoItem, 'id_user');
                        echo $form->hiddenField($infoItem, 'id_user', array('value' => $user['id']));
                        echo CHtml::textField('author', $user['name'], array('class' => 'form-control', 'readOnly' => true, 'required' => true));
                    ?>
                </div>
                <div class="clearfix"></div>
            	<div class='col-md-4'>
                    <?php 
	                	echo $form->textFieldGroup($infoItem, 'create_date', array(
	                        'widgetOptions' => array(
	                            'htmlOptions' => array('class' => 'frm_datepicker create_date', 'readOnly' => true)
	                    )));
	                ?>
                </div> 
                <div class='col-md-4'>
	                <?php echo $form->dropDownListGroup($infoItem,'status',array('widgetOptions'=>array('data'=>array('0' => 'Chưa hoàn tất', '1' => 'Hoàn tất'),'htmlOptions'=>array('required'=>'required')))); ?>
	            </div>
	            <div class="col-md-8">
	            	<?php echo $form->textAreaGroup($infoItem,'note', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>3, 'cols'=>30)))); ?>
	            </div>
	            <div class="col-xs-12 mt-30 tableMaterial update">
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
	                            <th class="td8"></th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	
	                    </tbody>
	                </table>
	                <div class="divSumQty">
	                	<b>Tổng số lượng:</b>
	                	<span class="text-total-qty">0</span>
	                </div>
	                <div class="divSum">
	                	<b>Tổng tiền:</b>
	                	<span class="textTotalAmount autoNum"><?php echo $infoItem['sum_amount']; ?></span>
	                	<input type="hidden" class="autoNum"  id="totalAmountUpdate" name="GoodsReceipt[sum_amount]" value="<?php echo $infoItem['sum_amount']; ?>">
	                </div> 
	                <div class="col-xs-12">
		            	<div class="row">
			            	<div id="sMore" class="mt-10">
		                        <div id="upMaterial" class="btn sbtnAdd newbtnAdd">
		                            <span class="glyphicon glyphicon-plus"></span>
		                           Nguyên vật liệu
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div id="sFooter" class="col-md-12 text-right">
	                	<button class="btn sCancel" data-dismiss="modal">Hủy</button>
		                <button class="btn Submit" id="sSubmit" type="submit">Lưu</button>
		            </div>
	            </div>
            </div>
	    </div>
	</div>
</div>
<script>
	var i = 1;
	var tableUpdate 		= $('.tableMaterial.update table');
	var tbodyUpdate 		= $(".tableMaterial.update tbody");
	var infoItemDetail 		= JSON.parse('<?php echo $infoItemDetail; ?>');
	var itemDetailUpdate 	= <?php echo CJSON::encode($this->renderPartial('item_detail', array('i' => 'iTemp','form' => $form, 'goodsReceiptDetail'=>$goodsReceiptDetail), true)); ?>;
	$(document).ready(function(){
		var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    	$('.autoNum').autoNumeric('init',numberOptions);
		showItemDetail();
		listMaterial();
		sumTotalQtyUpdate();
		$('.frm_datepicker').datepicker({
			dateFormat: 'dd/mm/yy',
			minDate: 'today',
		});
		
	});
/***** Chi tiết phiếu *****/	
	function showItemDetail(){
		$.each(infoItemDetail, function(key, list) {
			var ids = key +1;
			$(tbodyUpdate).append(itemDetailUpdate.replace(/iTemp/g, ids));
			var expiration_date = moment(list.expiration_date).format('DD/MM/YYYY');
			$(tbodyUpdate).find("tr.t" + ids + " .frm_datepicker").val(expiration_date);
			$(tbodyUpdate).find("tr.t" + ids + " .qty").val(list.qty);
			$(tbodyUpdate).find("tr.t" + ids + " .unit").val(list.unit);
			var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
			$('.autoNum').autoNumeric('init',numberOptions);
			$(tbodyUpdate).find("tr.t" + ids + " .amount").autoNumeric('set',list.amount);
			$(tbodyUpdate).find("tr.t" + ids + " .sumamount").autoNumeric('set',list.sumamount);
			var materialInfo = "<option value='" + list.id_material + "'>" + list.name_material + "</option>";
			$(tbodyUpdate).find("tr.t" + ids + " .listMaterial").html(materialInfo); 
			$(tbodyUpdate).find("tr.t" + ids + " .listMaterial").attr('disabled', 'disabled');
			$(tbodyUpdate).find("tr.t" + ids + " .delOld").val(1);
			$(tbodyUpdate).find("tr.t" + ids + " .id_detail").val(list.id);
			i++;
		});
	} 
/***** Thêm nguyên vật liệu *****/
	$('#upMaterial').click(function (e) {
		$(tbodyUpdate).append(itemDetailUpdate.replace(/iTemp/g, i));
		listMaterial();
		i++;
		$('.frm_datepicker').datepicker({
			dateFormat: 'dd/mm/yy',
		});
		var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    	$('.autoNum').autoNumeric('init',numberOptions);
    	sumTotalQtyUpdate();
	});
/***** Xóa nguyên vật liệu *****/	
	$(tbodyUpdate).on("click", ".remove_field", function (e) {
		e.preventDefault();
		var delOld = $(this).parents('tr').find('.delOld').val();
		if(delOld == 1){
			$(this).parents('.currentRow').css('display', 'none');
			$(this).parents('tr').find('.statusNK').val(-1);
		}else{
			$(this).parents('.currentRow').remove();
		}
		sumTotalAmountUpdate();
		sumTotalQtyUpdate();
	});
/***** Thay đổi nguyên vật liệu *****/	
	$(tbodyUpdate).on('change', '.listMaterial', function (e) {
		var select = $(this);
		var data = select.select2('data');
		if (data.length == 0) {
			return;
		}
		var unit = data[0].unit;
		var divTr = $(this).parents('tr');
		divTr.find('.unit').val(unit);
		sumTotalAmountUpdate();
	});
/***** Change số lượng *****/
	$(tbodyUpdate).on('keyup', '.qty', function (e) {
		var qty  		= $(this).val();
		var tableTr 	= $(this).parents('tr');
		var amount 		= tableTr.find('.amount').autoNumeric('get');
		var sumAmount 	= parseInt(qty) * parseInt(amount);
		tableTr.find('.sumamount').autoNumeric('set', sumAmount);
		sumTotalAmountUpdate();
		sumTotalQtyUpdate();
	});
/***** Change giá *****/
	$(tbodyUpdate).on('keyup', '.amount', function (e) {
		var tableTr 	= $(this).parents('tr');
		var qty  		= tableTr.find('.qty').val();
		var amount 		= $(this).autoNumeric('get');
		var sumAmount 	= parseInt(qty) * parseInt(amount);
		tableTr.find('.sumamount').autoNumeric('set', sumAmount);
		sumTotalAmountUpdate();
	});
/***** Tổng tiền *****/
	function sumTotalAmountUpdate(){
		var total 		= 0;
		$(".tableMaterial.update tbody tr").each(function( index ) {
			var statusNK= $(this).find('.statusNK').val();
			if(statusNK != -1){
				var rowTotal= $(this).find('.sumamount').autoNumeric('get');
				total 		= parseInt(total) + parseInt(rowTotal);
			}
		});
		$('.tableMaterial.update').find('.textTotalAmount').html(formatNumber(total));
		$('.tableMaterial.update').find('#totalAmountUpdate').val(total);
	}

/***** Tổng số lượng *****/
	function sumTotalQtyUpdate(){
		var totalQty 		= 0;
		$(".tableMaterial.update tbody tr").each(function( index ) {
			var statusNK= $(this).find('.statusNK').val();
			if(statusNK != -1){
				var rowTotalQty = $(this).find('.qty').val();
				totalQty 		= parseInt(totalQty) + parseInt(rowTotalQty);
			}
		});

		$(".tableMaterial.update").find('.text-total-qty').html(totalQty);
	}

/***** formatNumber *****/
	function formatNumber (num) {
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
	}
/***** Search nguyên vật liệu *****/	
	function listMaterial() {
		$('.listMaterial').select2({
			placeholder: 'Nguyên vật liệu',
			width: '100%',
			dropdownCssClass: "chooseMaterial",
			dropdownAutoWidth: true,
			ajax: {
				dataType: "json",
				url: '<?php echo CController::createUrl('goodsReceipt/getListMaterial'); ?>',
				type: "post",
				delay: 1000,
				data: function (params) {
					return {
						q: params.term, // search term
						page: params.page || 1,
					};
				},
				processResults: function (data, params) {
					params.page = params.page || 1;
					return {
						results: data,
						pagination: {
							more: true
						}
					};
				},
			},
		});
	}
/***** Update *****/	
	$('form#frmUpdate').submit(function(e) {
		e.preventDefault();
		$('form#frmUpdate input').each(function() {
			if ($(this).hasClass('autoNum')) {
				var number = $(this).val();
				$(this).val(number.replace(/\./g, ""));
			}
		});
		var formData = new FormData($("#frmUpdate")[0]);
		if (!formData.checkValidity || formData.checkValidity()) {
			$('.cal-loading').fadeIn('fast');
			$.ajax({
				type: "POST",
				url: "<?php echo CController::createUrl('goodsReceipt/update')?>",
				data: formData,
				success: function (data) {
					$('.cal-loading').fadeOut('fast');
					$('#updateModal').modal('hide');
					loadGoodsReceipt();
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