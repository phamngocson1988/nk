<?php 
 	$user_name 	= Yii::app()->user->getState('name');
    $user_id 	= Yii::app()->user->getState('user_id');
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header sHeader">
	        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        <h3 id="modalTitle" class="modal-title">Phiếu chuyển kho</h3>
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
                    	echo $form->textFieldGroup($stockTransfer, 'name', array(
	                        'widgetOptions' => array(
	                            'htmlOptions' => array()
	                    )));
                    ?>
                </div>
                <div class='col-md-4'>
                    <?php echo $form->dropDownListGroup($stockTransfer,'id_repository_transfer',array('widgetOptions'=>array('data'=>CHtml::listData($listRepository,'id', 'name'),'htmlOptions'=>array('required'=>'required')))); ?>
                </div> 
                <div class='col-md-4'>
                    <?php echo $form->dropDownListGroup($stockTransfer,'id_repository_receipt',array('widgetOptions'=>array('data'=>CHtml::listData($listRepository,'id', 'name'),'htmlOptions'=>array('empty'=>'--Chọn kho nhận--','required'=>'required')))); ?>
                </div> 
                <div class="clearfix"></div>
                <div class='col-md-4'>
                    <?php 
                        echo $form->labelEx($stockTransfer, 'id_user');
                        echo $form->hiddenField($stockTransfer, 'id_user', array('value' => $user_id));
                        echo CHtml::textField('author', $user_name, array('class' => 'form-control', 'readOnly' => true, 'required' => true));
                    ?>
                </div>
	            <div class='col-md-4'>
	                <?php 
	                	echo $form->textFieldGroup($stockTransfer, 'create_date', array(
	                        'widgetOptions' => array(
	                            'htmlOptions' => array('class' => 'frm_datepicker create_date', 'disabled' => true)
	                    )));
	                ?>
	            </div>
	            <div class="col-md-8">
	            	<?php echo $form->textAreaGroup($stockTransfer,'note', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>3, 'cols'=>30)))); ?>
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
	                	<input type="hidden" id="total-amount" name="StockTransfer[sum_amount]" value="0">
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
	var tbody 		= $('.tableMaterial.create tbody');
	var i 			= 1;
	var itemDetail 	= <?php echo CJSON::encode($this->renderPartial('item_detail', array('i' => 'iTemp','form' => $form, 'stockTransferDetail'=>$stockTransferDetail), true)); ?>;
	$(document).ready(function(){
		$('#frmCreate .create_date').datepicker({
			dateFormat: 'dd/mm/yy',
			minDate: 'today',
		});
		$("#frmCreate .create_date").datepicker("setDate", new Date());
		$(tbody).append(itemDetail.replace(/iTemp/g, i));
		//danh sách nguyên vật liệu
		var id_repository_transfer = $('#StockTransfer_id_repository_transfer').val();
		listMaterial(id_repository_transfer);
		var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    	$('.autoNum').autoNumeric('init',numberOptions);
	});

	/***** Thêm nguyên vật liệu *****/
	$('#addMaterial').click(function (e) {
		i++;
		$(tbody).append(itemDetail.replace(/iTemp/g, i));
		var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    	$('.autoNum').autoNumeric('init',numberOptions);
		var id_repository_transfer = $('#StockTransfer_id_repository_transfer').val();
		listMaterial(id_repository_transfer);
	});
	/***** Xóa nguyên vật liệu *****/	
	$(tbody).on("click", ".remove_field", function (e) {
		e.preventDefault();
		$(this).parents('.currentRow').remove();
		sumTotalAmount();
		sumTotalQty();
	});
  	/***** Search nguyên vật liệu *****/	
	function listMaterial(id_repository) {
		$('.listMaterial').select2({
			placeholder: 'Nguyên vật liệu',
			width: '100%',
			dropdownCssClass: "chooseMaterial",
			dropdownAutoWidth: true,
			templateResult : formatMaterial,
			ajax: {
				dataType: "json",
				url: '<?php echo CController::createUrl('stockTransfer/getListMaterial'); ?>',
				type: "post",
				delay: 1000,
				data: function (params) {
					return {
						id_repository: id_repository,
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

	function formatMaterial (data) {
		if (!data.id) { return data.text; }
		datas  = '<div class="col-xs-5">' + data.text + '</div>';
		datas += '<div class="col-xs-4">' + data.expiration_date + '</div>';
		datas += '<div class="col-xs-3 text-right">' + formatNumber(data.amount) + '</div>';
		datas += '<div class="clearfix"></div>';
		var $data = $(datas);
		return $data;
	};
	function formatNumber (num) {
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
	}

	/***** Thay đổi nguyên vật liệu *****/	
	$(tbody).on('change', '.listMaterial', function (e) {
		var select = $(this);
		var data = select.select2('data');
		if (data.length == 0) {return;}
		var unit 			= data[0].unit;
		var amount 			= data[0].amount;
		var expiration_date = data[0].expiration_date;
		var qty 			= data[0].qty;
		var divTr 			= $(this).parents('tr');
		var qtyTr 			= 1;
		var sum_amount 		= amount * qtyTr;
		divTr.find('.qty').val(qtyTr);
		divTr.find('.unit').val(unit);
		divTr.find('.amount').autoNumeric('set', amount);
		divTr.find('.expiration_date').val(moment(expiration_date).format('DD/MM/YYYY') );
		divTr.find('.sumamount').autoNumeric('set', sum_amount);
		divTr.find('.qty').attr({"max" : qty,"min" : 1});
		sumTotalAmount();
		sumTotalQty();
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
	function maxLengthCheck(object)
	{
	    if (parseInt(object.value) > parseInt(object.max)){
	    	object.value = object.max;
	    }else if(parseInt(object.value) < 1){
	    	object.value = 1;
	    }
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
				url: "<?php echo CController::createUrl('stockTransfer/create')?>",
				data: formData,
				success: function (data) {
					$('.cal-loading').fadeOut('fast');
					var josn = JSON.parse(data);
					if (josn.status == 'successful') {
						$('#createModal').modal('hide');
						loadStockTransfer(searchParam);
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