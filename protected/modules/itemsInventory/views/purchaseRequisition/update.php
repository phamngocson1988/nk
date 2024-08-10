<div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header sHeader">
	        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        <h3 id="modalTitle" class="modal-title">Chỉnh sửa phiếu đề xuất mua hàng</h3>
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
	                <?php echo $form->dropDownListGroup($infoItem,'status',array('widgetOptions'=>array('data'=>array('0' => 'Chưa duyệt', '1' => 'Đã duyệt'),'htmlOptions'=>array('required'=>'required')))); ?>
	            </div>
                <div class="col-md-8">
	            	<?php echo $form->textAreaGroup($infoItem,'note', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>3, 'cols'=>30)))); ?>
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

<script>
	var table 			= $('.tableMaterial table');
	var tbody 			= $(".tableMaterial tbody");
	var i 				= 0;
	var infoItemDetail 	= JSON.parse('<?php echo $infoItemDetail; ?>');
	var itemDetail 	= <?php echo CJSON::encode($this->renderPartial('item_detail', array('i' => 'iTemp','form' => $form, 'purchaseRequisitionDetail'=>$purchaseRequisitionDetail), true)); ?>;

/***** Chi tiết phiếu *****/	
	function showItemDetail(){
		$.each(infoItemDetail, function(key, list) {
			var ids = key +1;
			$(tbody).append(itemDetail.replace(/iTemp/g, ids));
			$(tbody).find("tr.t" + ids + " .qty").val(list.qty);
			$(tbody).find("tr.t" + ids + " .unit").val(list.unit);
			var materialInfo = "<option value='" + list.id_material + "'>" + list.name_material + "</option>";
			$(tbody).find("tr.t" + ids + " .listMaterial").html(materialInfo);
			$(tbody).find("tr.t" + ids + " .listMaterial").attr('disabled', 'disabled');
			$(tbody).find("tr.t" + ids + " .delOld").val(1);
			$(tbody).find("tr.t" + ids + " .id_detail").val(list.id);
			i++;
		});
	} 
/***** Thêm nguyên vật liệu *****/
	$('#upMaterial').click(function (e) {
		i++;
		$(tbody).append(itemDetail.replace(/iTemp/g, i));
		listMaterial();
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
	});
/***** Xóa nguyên vật liệu *****/	
	$(tbody).on("click", ".remove_field", function (e) {
		e.preventDefault();
		var delOld = $(this).parents('tr').find('.delOld').val();
		if(delOld == 1){
			$(this).parents('.currentRow').css('display', 'none');
			$(this).parents('tr').find('.statusPX').val(-1);
		}else{
			$(this).parents('.currentRow').remove();
		}	
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

	$(document).ready(function(){
		showItemDetail();
		listMaterial();
	});

/***** Update phiếu đề xuất *****/	
	$('form#frmUpdate').submit(function(e) {
		e.preventDefault();
		var formData = new FormData($("#frmUpdate")[0]);
		if (!formData.checkValidity || formData.checkValidity()) {
			$('.cal-loading').fadeIn('fast');
			$.ajax({
				type: "POST",
				url: "<?php echo CController::createUrl('purchaseRequisition/update')?>",
				data: formData,
				success: function (data) {
					$('#updateModal').modal('hide');
					loadPurchaseRequisition();
					$('.cal-loading').fadeOut('fast');
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
