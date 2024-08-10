<?php 
 	$user_name = Yii::app()->user->getState('name');
    $user_id = Yii::app()->user->getState('user_id');
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header sHeader">
	        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        <h3 id="modalTitle" class="modal-title">Lập phiếu đề xuất mua hàng</h3>
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
                    	echo $form->textFieldGroup($purchaseRequisition, 'name', array(
	                        'widgetOptions' => array(
	                            'htmlOptions' => array()
	                    )));
                    ?>
                </div>
            	<div class='col-md-4'>
                    <?php echo $form->dropDownListGroup($purchaseRequisition,'id_repository',array('widgetOptions'=>array('data'=>CHtml::listData($listRepository,'id', 'name'),'htmlOptions'=>array('empty'=>'--Chọn kho--','required'=>'required')))); ?>
                </div> 
            	<div class='col-md-4'>
                    <?php 
                        echo $form->labelEx($purchaseRequisition, 'id_user');
                        echo $form->hiddenField($purchaseRequisition, 'id_user', array('value' => $user_id));
                        echo CHtml::textField('author', $user_name, array('class' => 'form-control', 'readOnly' => true, 'required' => true));
                    ?>
                </div>
                <div class="clearfix"></div>
	            <div class='col-md-4'>
	                <?php 
	                	echo $form->textFieldGroup($purchaseRequisition, 'create_date', array(
	                        'widgetOptions' => array(
	                            'htmlOptions' => array('class' => 'frm_datepicker create_date', 'readOnly' => true)
	                    )));
	                ?>
	            </div>
	            <div class='col-md-4'>
	                <?php echo $form->dropDownListGroup($purchaseRequisition,'status',array('widgetOptions'=>array('data'=>array('0' => 'Chưa duyệt', '1' => 'Đã duyệt'),'htmlOptions'=>array('required'=>'required')))); ?>
	            </div>
	            <div class="col-md-8">
	            	<?php echo $form->textAreaGroup($purchaseRequisition,'note', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>3, 'cols'=>30)))); ?>
	            </div>
	            <div class="col-xs-12 mt-30 tableMaterial">
	            	<table class="table sItem">
	                    <thead>
	                        <tr>
	                            <th class="th1">STT</th>
	                            <th class="th2">Nguyên vật liệu</th>
	                            <th class="th3">Số lượng</th>
	                            <th class="th4">Đơn vị tính</th>
	                            <th class="th5"></th>	
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	
	                    </tbody>
	                </table>
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
/***** Item nguyên vật liệu *****/
	var itemDetail 	= <?php echo CJSON::encode($this->renderPartial('item_detail', array('i' => 'iTemp','form' => $form, 'purchaseRequisitionDetail'=>$purchaseRequisitionDetail), true)); ?>;
	var table 		= $('.tableMaterial table');
	var tbody 		= $(".tableMaterial tbody");
	var i 			= 1;
	$(document).ready(function(){
		$('.frm_datepicker').datepicker({
			dateFormat: 'dd/mm/yy',
		});
		$(".frm_datepicker").datepicker("setDate", new Date());
		if (table.find('tbody tr').length <= 0) {
			$(tbody).append(itemDetail.replace(/iTemp/g, i));
		}
		listMaterial();
	});
/***** Thêm nguyên vật liệu *****/
	$('#addMaterial').click(function (e) {
		i++;
		$(tbody).append(itemDetail.replace(/iTemp/g, i));
		listMaterial();
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
				url: '<?php echo CController::createUrl('purchaseRequisition/getListMaterial'); ?>',
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
	});
/***** Xóa nguyên vật liệu *****/	
	$(tbody).on("click", ".remove_field", function (e) {
		e.preventDefault();
		$(this).parents('.currentRow').remove();
	});
/***** Tạo mới phiếu đề xuất *****/	
	$('form#frmCreate').submit(function(e) {
		e.preventDefault();
		var formData = new FormData($("#frmCreate")[0]);
		if (!formData.checkValidity || formData.checkValidity()) {
			$('.cal-loading').fadeIn('fast');
			$.ajax({
				type: "POST",
				url: "<?php echo CController::createUrl('purchaseRequisition/create')?>",
				data: formData,
				success: function (data) {
					$('#createModal').modal('hide');
					loadPurchaseRequisition();
					$('.cal-loading').fadeOut('fast');
					console.log(data);
					return;
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