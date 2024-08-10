<div class="modal-dialog modal-md">
    <div class="modal-content order-container">
        <div class="modal-header sHeader" style="text-align: center;text-transform: uppercase;">
            Chỉnh sửa labo
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
						<label>Tên labo</label>
						<input type='hidden' name='id_labo' value='<?php echo $labo->id;?>'/>
						<?php echo $form->textField($labo,'name',array('class'=>'form-control'));?>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row" style="padding-bottom: 15px;">
					<div class="col-sm-12">
						<label>Địa chỉ</label>
						<?php echo $form->textarea($labo,'address',array('class'=>'form-control', "rows"=>"4"));?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row" style="padding-bottom: 15px;">
					<div class="col-sm-12">
						<label>Sdt Liên hệ</label>
						<?php echo $form->textField($labo,'phone',array('class'=>'form-control'));?>
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
                url:"<?php echo CController::createUrl('listLabo/saveUpdate')?>",
                data: formData,
                datatype:'json',
                success:function(data){
                    if(data==1){
                        alert('Chỉnh sửa thành công !');
                        location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSetting/listLabo/View';
                    }
                    if(data==-1){
                        alert('Tên Labo đã tồn tại !');
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