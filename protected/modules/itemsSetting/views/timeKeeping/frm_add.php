<style>
	#mn_nav .dropdown-menu {
		right: auto;
		color: black;
		overflow: auto;
		height: 200px;
	}
</style>
<div class="row">
    <div class="col-sm-12">
        <?php 
            $form = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                array(
                    'id' => 'addNewTimeKeeping',
                    'enableClientValidation'=>true,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'), // for inset effect
                )
            );
        ?>
		<div class="form-group">
			<div class="row" style="padding-bottom: 15px;">
				<div class="col-sm-6">
				    <input type='hidden' id='id_user_add' name='id_user_add' value='<?php echo $id_user_add;?>'/>
					<label>Tên loại nhóm:</label>
					<?php 
					echo $form->textField($CsServiceTypeTk,'name',array('class'=>'form-control'));
					?>
				</div>
			</div>				
		</div>
		<div class="form-group">
			<div class="row" style="padding-bottom: 15px;">
			<div class="col-sm-12">
				<label>Dịch vụ:</label>
				 
				<div class='example'>
				    <select style='color:#000000' name="list_service[]" class="mang_service" multiple="multiple">
						
						<?php
						$CsServiceType = CsServiceType::model()->findAll("status = 1");
                        foreach($CsServiceType as $gt){
						$CsService = CsService::model()->findAll("id not in (select b.id_cs_service from cs_service_tk b where b.st = 1) and status = 1 and id_service_type = ".$gt['id']);
							if(count($CsService)>0){?>
							<optgroup label='<?php echo $gt['name'];?>'>
							<?php foreach($CsService as $tg){?>
								<option value='<?php echo $tg['id'];?>'><?php echo $tg['name'];?></option>
							<?php }?> 
						    </optgroup>
						<?php }}?>
					</select>
				</div>
		
			</div>
			</div>				
		</div>
             
		<div class="form-group">
			<div class="row">
				<div class="col-sm-12 text-right">
					<input type="submit" class="btn btn-default" value="Xác Nhận" style="color:#000000" />
					<input type="button" class="btn btn-default" id='addClose' value="Thoát" data-dismiss="modal" style="color:#000000;margin-left: 15px;" />
				</div>
			</div>  
		</div>
		
        <?php 
            $this->endWidget();
        ?>
    </div> 
</div>
<?php //$country = CsService::model()->findAll();?>
<script>

$(document).ready(function(){
	//$('.inselect').select2();
	//$('#optgroup').multiSelect({ selectableOptgroup: true });
	$('.mang_service').multiselect({
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableFiltering: true
	});
    $('#addNewTimeKeeping').submit(function(e) {
        e.preventDefault(); 
		if($.trim($("#CsServiceTypeTk_name").val())==""){
            alert('Xin nhập Tên loại nhóm!!!');return false;
        }
		if($.trim($(".mang_service").val())==""){
            alert('Xin chọn Dịch vụ!!!');return false;
        }
        var formData = new FormData($("#addNewTimeKeeping")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ 
                type:"POST",
                url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/addNewTimeKeeping',
                data:formData,
                datatype:'json',
                
                success:function(data){
					//alert(data);
					$('#searchService2').val('');
					if(  data != '-1'){
						jQuery("#height_service").fadeOut( 100 , function() {
							jQuery(this).html( data);
						}).fadeIn( 600 );
					}else{
						alert('Không có dữ liệu !!!');
					}
					
					$('#addClose').click();
					//window.location.assign('<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/view');
                },
                cache: false,
                contentType: false,
                processData: false 
            });
        }
        return false;
    });
});
</script>