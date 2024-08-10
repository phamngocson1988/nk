<div class='col-md-12' style='padding-top:4%'>
    <?php 
		$form = $this->beginWidget(
			'booster.widgets.TbActiveForm',
			array(
				'id' => 'updateChair',
				'enableClientValidation'=>true,
				'htmlOptions' => array('enctype' => 'multipart/form-data','class' => "form-horizontal"), // for inset effect
			)
		);
	?>
	
    <div class="form-group">
	    <input type='hidden' id='headId' name='headId' value='<?php echo $Chair->id;?>'/>
		<label class="control-label col-sm-2" for="chair_name_up">Tên ghế:</label>
		<div class="col-sm-10">          
			<input type="text" class="form-control" id="chair_name_up" placeholder="Tên ghế" name="chair_name_up" value='<?php echo $Chair->name;?>'/>
		</div>
    </div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="chair_branch_up">Chi nhánh:</label>
		<div class="col-sm-10">          
			<select class="form-control" name='chair_branch_up' id='chair_branch_up'>
			    <?php
				foreach(Branch::model()->findAll('status=:st',array(':st'=>1)) as $temp){
					$selected = $Chair->id_branch==$temp['id']?'selected':'';
					?>
					<option <?php echo $selected;?> value='<?php echo $temp['id'];?>'><?php echo $temp['name'];?></option>
				<?php }?>
			</select>
		</div>
    </div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="chair_type_up">Chọn loại ghế:</label>
		<div class="col-sm-10">          
		    <select class="form-control" name='chair_type_up' id='chair_type_up'>
			<?php 
			if($Chair->type==1){?>
				<option value="2">Ghế điều trị</option>
				<option value="1" selected="true">Ghế khám</option>
			<?php }else{?>
				<option value="2" selected="true">Ghế điều trị</option>
				<option value="1" >Ghế khám</option>
			<?php }?>
			</select>
		</div>
    </div>
	<div class="form-group">
		<div class="col-sm-12" style='text-align: right;'>          
			<button type="submit" class="btn btn-primary" style='margin-right:20px'>Sửa</button>
			<button type="button" class="btn btn-primary" onclick='deleteChair(<?php echo $Chair->id;?>);'>Xóa</button>
		</div>
    </div>
	<?php 
		$this->endWidget();
	?>
</div>
<script>
function deleteChair(id){
    var r = confirm("Bạn có chắc muốn xóa !!!");
	var baseUrl = $('#baseUrl').val();
	if(r == true){
		$.ajax({
			type:'POST',
			url: baseUrl+'/itemsSetting/Placement/DeleteChair',	
			data: {"id":id},   
			success:function(data){   	
				if(data == 1){
					window.location.assign(baseUrl+"/itemsSetting/Placement/View");
				}else{
					alert('Xóa thất bại !!!');
				}         
			},
			error: function(data){
			console.log("error");
			console.log(data);
			}
		});
    }
}
$(document).ready(function(){
    $('#updateChair').submit(function(e) {
		var baseUrl = $('#baseUrl').val();
		var headId = $('#headId').val();
        e.preventDefault();
        if($.trim($("#chair_name_up").val())==""){
            alert('Xin nhập tên!!!');return false;
        } 
        var formData = new FormData($("#updateChair")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ 
                type:"POST",
                url:baseUrl+'/itemsSetting/Placement/UpdateChair',
                data:formData,
                datatype:'json',
                success:function(data){
					if(data != 0){
						$('#c'+headId).find("label").html(data);
						alert('Cập nhật thành công !!!');
					}else{
						alert('Cập nhật thất bại !!!');
					}
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