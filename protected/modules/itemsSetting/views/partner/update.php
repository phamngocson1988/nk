<div class="modal-dialog modal-md">
    <div class="modal-content order-container">
        <div class="modal-header sHeader" style="text-align: center;text-transform: uppercase;">
            Chỉnh sửa đối tác
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
		<?php 
			$form = $this->beginWidget(
				'booster.widgets.TbActiveForm',
				array(
					'id' => 'frm-update',
					'enableClientValidation'=>true,
					'htmlOptions' => array('enctype' => 'multipart/form-data'), // for inset effect
				)
			);
		?>
		<div class="modal-body">
			<div class="form-group">
				<div class="row" style="padding-bottom: 15px;">
					<div class="col-sm-12">
						<label>Tên đối tác</label>
						<input type='hidden' name='id_partner' value='<?php echo $partner->id;?>'/>
						<?php echo $form->textField($partner,'name',array('class'=>'form-control'));?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row" style="padding-bottom: 15px;">
					<div class="col-sm-12">
						<label>Mã đối tác</label>
						<?php echo $form->textField($partner,'code',array('class'=>'form-control'));?>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row" style="padding-bottom: 15px;">
					<div class="col-sm-12">
						<label>Mô tả</label>
						<?php echo $form->textarea($partner,'description',array('class'=>'form-control', "rows"=>"4"));?>
					</div>
				</div>
			</div>
			<div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <label>Chọn bảng giá</label>
                        
                        <?php echo $form->dropDownList($partner,'id_price_book', CHtml::listData(PriceBook::model()->findAll(array('order' => 'id')),'id','name'),array('empty'=>'--Chọn bảng giá--','class'=>'form-control',));?>
                        
                    </div>
                </div>
            </div>
		</div>
		<div class="modal-footer">
			<input type="submit" class="btn btn-default" value="Lưu" style="" />
			<button type="button" class="btn btn-default" data-dismiss="modal" id='close_up'>Hủy</button>
		</div>
		<?php 
		    $this->endWidget();
		?>
	</div>
</div>

<script>
    $('form#frm-update').submit(function(e){
        e.preventDefault();
        var formData = new FormData($("#frm-update")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ type:"POST",
                url:"<?php echo CController::createUrl('Partner/saveUpdate')?>",
                data: formData,
                datatype:'json',
                success:function(data){
                    if(data==1){
                        alert('Chỉnh sửa thành công');
                        location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSetting/Partner/View';
                    }
                    if(data==-1){
                        alert('Mã đối tác đã được tạo!');
                    }
                },
                error: function(data) {
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