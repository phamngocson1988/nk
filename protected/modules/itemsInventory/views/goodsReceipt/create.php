<?php
 	$user_name = Yii::app()->user->getState('name');
    $user_id = Yii::app()->user->getState('user_id');
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header sHeader">
	        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        <h3 id="modalTitle" class="modal-title">Phiếu nhập kho</h3>
	    </div>
	    <div class="modal-body">
	    	<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => 'frmCreate',
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
                    <?php echo $form->dropDownListGroup($goodsReceipt,'id_repository',array('widgetOptions'=>array('data'=>CHtml::listData($listRepository,'id', 'name'),'htmlOptions'=>array('empty'=>'--Chọn kho--','required'=>'required')))); ?>
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
	                            'htmlOptions' => array('class' => 'frm_datepicker create_date', 'disabled' => true)
	                    )));
	                ?>
	            </div>
	            <div class='col-md-4'>
	                <?php echo $form->dropDownListGroup($goodsReceipt,'status',array('widgetOptions'=>array('data'=>array('0' => 'Chưa hoàn tất', '1' => 'Hoàn tất'),'htmlOptions'=>array('required'=>'required')))); ?>
	            </div>
	            <div class="col-md-8">
	            	<?php echo $form->textAreaGroup($goodsReceipt,'note', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>3, 'cols'=>30)))); ?>
	            </div>
	            <div class="col-xs-12 mt-30 tableMaterial create">
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
	                	<span class="text-total-amount autoNum">0</span>
	                	<input type="hidden" id="total-amount" name="GoodsReceipt[sum_amount]" value="0">
	                </div> 
	            </div>
	            <div class="col-xs-12">
	            	<div class="row">
		            	<div id="sMore" class="col-md-4 mt-10">
	                        <div id="addMaterial" class="btn sbtnAdd newbtnAdd">
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
<script>
	var table 		= $('.tableMaterial.create table');
	var tbody 		= $(".tableMaterial.create tbody");
	var i 			= 1;
	var itemDetail 	= <?php echo CJSON::encode($this->renderPartial('item_detail', array('i' => 'iTemp','form' => $form, 'goodsReceiptDetail'=>$goodsReceiptDetail), true)); ?>;
	$(document).ready(function(){
		$(tbody).append(itemDetail.replace(/iTemp/g, i));
		$('.frm_datepicker').datepicker({
			dateFormat: 'dd/mm/yy',
			minDate: 'today',
		});
		$("#frmCreate .create_date").datepicker("setDate", new Date());
		var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    	$('.autoNum').autoNumeric('init',numberOptions);	
		listMaterial();
		sumTotalAmount();
		sumTotalQty();
	});
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
/***** Thêm nguyên vật liệu *****/
	$('#addMaterial').click(function (e) {
		i++;
		$(tbody).append(itemDetail.replace(/iTemp/g, i));
		$('.frm_datepicker').datepicker({
			dateFormat: 'dd/mm/yy',
			minDate: 'today',
		});
		var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    	$('.autoNum').autoNumeric('init',numberOptions);
    	listMaterial();
    	sumTotalQty();
	});
/***** Xóa nguyên vật liệu *****/	
	$(tbody).on("click", ".remove_field", function (e) {
		e.preventDefault();
		$(this).parents('.currentRow').remove();
		sumTotalAmount();
		sumTotalQty();
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
	$(tbody).on('keyup', '.qty', function (e) {
		var qty  		= $(this).val();
		var tableTr 	= $(this).parents('tr');
		var amount 		= tableTr.find('.amount').autoNumeric('get');
		var sumAmount 	= parseInt(qty) * parseInt(amount);
		tableTr.find('.sumamount').autoNumeric('set', sumAmount);
		sumTotalAmount();
		sumTotalQty();
	});
/***** Change giá *****/
	$(tbody).on('keyup', '.amount', function (e) {
		var tableTr 	= $(this).parents('tr');
		var qty  		= tableTr.find('.qty').val();
		var amount 		= $(this).autoNumeric('get');
		var sumAmount 	= parseInt(qty) * parseInt(amount);
		tableTr.find('.sumamount').autoNumeric('set', sumAmount);
		sumTotalAmount();
	});
/***** Tổng tiền *****/
	function sumTotalAmount(){
		var total 		= 0;
		$(".tableMaterial.create tbody tr").each(function( index ) {
			var rowTotal= $(this).find('.sumamount').autoNumeric('get');
			total 		= parseInt(total) + parseInt(rowTotal);
		});

		$(".tableMaterial.create").find('.text-total-amount').html(formatNumber(total));
		$(".tableMaterial.create").find('#total-amount').val(total);
	}
/***** Tổng số lượng *****/
	function sumTotalQty(){
		var totalQty 		= 0;
		$(".tableMaterial.create tbody tr").each(function( index ) {
			var rowTotalQty = $(this).find('.qty').val();
			totalQty 		= parseInt(totalQty) + parseInt(rowTotalQty);
		});

		$(".tableMaterial.create").find('.text-total-qty').html(totalQty);
	}
/***** formatNumber *****/
	function formatNumber (num) {
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
	}
/***** Tạo mới *****/	
	$('form#frmCreate').submit(function(e) {
		e.preventDefault();
		$('form#frmCreate input').each(function() {
			if ($(this).hasClass('autoNum')) {
				var number = $(this).val();
				$(this).val(number.replace(/\./g, ""));
			}
		});
		var formData = new FormData($("#frmCreate")[0]);
		if (!formData.checkValidity || formData.checkValidity()) {
			$('.cal-loading').fadeIn('fast');
			$.ajax({
				type: "POST",
				url: "<?php echo CController::createUrl('goodsReceipt/create')?>",
				data: formData,
				success: function (data) {
					$('.cal-loading').fadeOut('fast');
					var josn = JSON.parse(data);
					if (josn.status == 'successful') {
						$('#createModal').modal('hide');
						loadGoodsReceipt();
					}else{
						$.jAlert({
	                        'title': "Thông báo",
	                        'content': "Có lổi xảy ra vui lòng thử lại."
	                    });
	                    $('#createModal').modal('hide');
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