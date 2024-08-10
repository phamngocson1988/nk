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
                    'id' => 'updateTimeKeeping',
                    'enableClientValidation'=>true,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'), // for inset effect
                )
            ); 
        ?>
		<div class="form-group">
			<div class="row" style="padding-bottom: 15px;">
				<div class="col-sm-6">
					<label>Tên loại nhóm:</label>
					<input type='hidden' id='id_ser' name='id_ser' value='<?php echo $CsServiceTypeTk->id;?>'/>
					<input type='hidden' id='id_user_update' name='id_user_update' value='<?php echo $id_user_update;?>'/>
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
				    <select style='color:#000000' name="list_service[]" class="mang_service_update" multiple="multiple">
						<?php
						/*
						$arr = array();
						$CsServiceType = CsServiceType::model()->findAll("status = 1");
						$CsService1 = CsService::model()->findAll("id in (select b.id_cs_service from cs_service_tk b where b.st = 1 and b.id_service_type_tk = :st)",array(':st'=>$CsServiceTypeTk->id));
						foreach($CsService1 as $gt){}
                        foreach($CsService as $gt){
						    $sec = in_array($gt['id'], $arr)?'selected':'';}*/?>
						
						<?php
						$arr = array();
						$CsServiceType = CsServiceType::model()->findAll("status = 1");
						$CsService1 = CsService::model()->findAll("id in (select b.id_cs_service from cs_service_tk b where b.st = 1 and b.id_service_type_tk = :st) and status = 1",array(':st'=>$CsServiceTypeTk->id));
						//$CsService2 = CsService::model()->findAll("id in (select b.id_cs_service from cs_service_tk b where b.st = 1)");
                        foreach($CsService1 as $gg){
							$arr[] = $gg['id'];
						}
						
						foreach($CsServiceType as $gt){
						//$CsService = CsService::model()->findAll("id_service_type = ".$gt['id']);
						$CsService = CsService::model()->findAll("id_service_type = :dd and id not in (select b.id_cs_service from cs_service_tk b where b.st = 1 and b.id_service_type_tk <> :st) and status = 1",array(':dd'=>$gt['id'],':st'=>$CsServiceTypeTk->id));
							if(count($CsService)>0){?>
							<optgroup label='<?php echo $gt['name'];?>'>
							<?php foreach($CsService as $tg){
								$sec = in_array($tg['id'], $arr)?'selected':'';
								?>
								<option <?php echo $sec;?> value='<?php echo $tg['id'];?>'><?php echo $tg['name'];?></option>
							<?php }?> 
						    </optgroup>
						<?php }}?>
                    </select>
				</div>
				<?php 
				/*
					echo '<pre>';
					print_r($arr);
					echo '</pre>';*/
				?>
		
			</div>
			</div>				
		</div>
             
		<div class="form-group">
			<div class="row">
				<div class="col-sm-12 text-right">
					<input type="submit" class="btn btn-default" value="Sửa" style="color:#000000"/>
					<input type="button" class="btn btn-default" onclick='delete_service();' value="Xóa" style="color:#000000"/> 
					<input type="button" id='' class="btn btn-default close_up" value="Thoát" data-dismiss="modal" style="color:#000000;margin-left: 15px;"/>
				</div>
			</div>  
		</div>
		
        <?php 
            $this->endWidget();
        ?>
    </div> 
</div>
<?php 
    //$CsService = CsService::model()->findAll();
    //$CsService1 = CsService::model()->findAll("id not in (select b.id_cs_service from cs_service_tk b where b.id_service_type_tk <> :st)",array(':st'=>6));
    //$CsService2 = CsService::model()->findAll("id not in (select b.id_cs_service from cs_service_tk b)");?> 
<script>


function delete_service(){
	var id_ser = $('#id_ser').val();
	var id_user_update = $('#id_user_update').val();
	if(confirm("Bạn có chắc muốn xóa !!!")){
		$.ajax({
			type:'POST',
			url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/deleteTimeKeeping', 	
			data: {
				"id":id_ser,
				"id_user_update":id_user_update,
			},   
			success:function(data){
				//window.location.assign('<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/view');		
			    $('#searchService2').val('');
				if(  data != '-1'){
					jQuery("#height_service").fadeOut( 100 , function() {
						jQuery(this).html( data);
					}).fadeIn( 600 );
				}else{
					alert('Không có dữ liệu !!!');
				}
				
				$('.close_up').click();
				//$('#myModalUpdate').modal().hide();
			},
			error: function(data){
			console.log("error");
			console.log(data);
			}
		});
	}
}
$(document).ready(function(){
	//$('.inselect').select2();
	$('.mang_service_update').multiselect({
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableFiltering: true
	});
    $('#updateTimeKeeping').submit(function(e) {
        e.preventDefault(); 
		var id_ser = $('#id_ser').val();
		if($.trim($("#CsServiceTypeTk_name").val())==""){
            alert('Xin nhập Tên loại nhóm!!!');return false;
        }
		if($.trim($(".mang_service_update").val())==""){
            alert('Xin chọn Dịch vụ!!!');return false;
        }
        var formData = new FormData($("#updateTimeKeeping")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ 
                type:"POST",
                url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/updateTimeKeeping',
                data:formData,
                datatype:'json',
                
                success:function(data){
					//alert(data);close_up
					$('#searchService2').val('');
					$('#service_type_'+id_ser).html(data);
					$('.close_up').click();
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