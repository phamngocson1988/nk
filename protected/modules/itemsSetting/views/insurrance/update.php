
<?php 
	$form = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		array(
			'id' => 'updateInsurrance',
			'enableClientValidation'=>true,
			'htmlOptions' => array('enctype' => 'multipart/form-data'), // for inset effect
		)
	);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Sửa bảo hiểm</h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
				<label>Tên bảo hiểm</label>
				<input type='hidden' name='headId' value='<?php echo $InsurranceType->id;?>'/>
				<?php echo $form->textField($InsurranceType,'name',array('class'=>'form-control'));?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
				<label>Mã bảo hiểm</label>
				<?php echo $form->textField($InsurranceType,'code',array('class'=>'form-control'));?>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
				<label>Miêu tả</label>
				<?php echo $form->textarea($InsurranceType,'description',array('class'=>'form-control', "rows"=>"4"));?>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<input type="submit" class="btn btn-default" value="Sửa" style="" />
	<button type="button" class="btn btn-default" data-dismiss="modal" id='close_up'>Close</button>
</div>
<?php 
            $this->endWidget();
        ?>
<script>
function validatepricetable(e) {
    var keypressed = null;
    if (window.event){
        keypressed = window.event.keyCode;
    }
    else{ 
        keypressed = e.which;
    }
    if ((keypressed < 48 || keypressed > 57)&&keypressed!=46){
        if (keypressed == 8 || keypressed == 9){
            return;
        }
        return false;
    }
}
$(document).ready(function(){
    $('#updateInsurrance').submit(function(e) {
        e.preventDefault();
	setTimeout(function(){
        if($.trim($("#InsurranceType_name").val())==""){
            alert('Xin nhập tên !!!');return false;
        }
		
		if($.trim($("#InsurranceType_code").val())==""){
            alert('Xin nhập code !!!');return false;
        }
        var formData = new FormData($("#updateInsurrance")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ 
                type:"POST",
                url: '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/Insurrance/Update',
                data:formData,
                datatype:'json',
                success:function(data){
					if(data == -1){
						alert('Mã bảo hiểm đã tồn tại !!!');
					}else if(data == -2){
						alert('Tên bảo hiểm đã tồn tại !!!');
					}else{
						$("#listHeader").html(data);
						$("#close_add").click();
					}
                },
                cache: false,
                contentType: false,
                processData: false 
            });
        }
        return false;
	}, 600);  
    });
	
});



</script>
