<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Tạo Ghế</h4>
</div>
<div class="modal-body">
<?php

?>
	<form id="updateChair" class='form-horizontal'>
	<div class="form-group">

		<label class="control-label col-sm-2" for="pwd">Chi nhánh:</label>
		<div class="col-sm-10">
			<select class="form-control" id='add_id_branch' name="add_id_branch">
				<?php $Branch = Branch::model()->findAll('status=:st',array(':st'=>1));
				foreach($Branch as $gt){?>
				<option value='<?php echo $gt['id']?>'><?php echo $gt['name'];?></option>
				<?php }?>
			</select>
		</div>
    </div>
	
	<div class="form-group">
		<label class="control-label col-sm-2" for="pwd">Tên ghế:</label>
		<div class="col-sm-10">
		    <input type="text" class="form-control" id="add_name_chair" name="add_name_chair"/>
		</div>
    </div>
	
	<div class="form-group">
		<label class="control-label col-sm-2" for="pwd">Loại ghế:</label>
		<div class="col-sm-10">
		    <select class="form-control" id='add_type_chair' name="add_type_chair">
			    <option value='2'>Ghế điều trị</option>
				<option value='1'>Ghế khám</option>
			</select>
		</div>
    </div>
</div>
	<div class="modal-footer">
	    <button type="button" class="btn btn-default" onclick='addChairDB();'>Lưu</button>
		<button type="button" class="btn btn-default" id='close_chair_saveDB' data-dismiss="modal">Thoát</button>
	</div>
	
    </form>

<script>
   
//ghế điều trị (2)
//ghế khám (1)
	function addChairDB(){
		if($("#add_name_chair").val()==""){
			alert('Xin nhập tên ghế !!!');return false;
		}  
		var add_id_branch = $('#add_id_branch').val();
		var add_name_chair = $('#add_name_chair').val();
		var add_type_chair = $('#add_type_chair').val();
		$.ajax({  
			type    : "post",
			url: '<?php echo Yii::app()->createUrl('itemsSetting/ChairCalendar/AddChair')?>',
			data    : {
				add_id_branch	: add_id_branch,
				add_name_chair	: add_name_chair,
				add_type_chair	: add_type_chair,
			},
			success: function(data){
				//$('#update_id_user').html('');
				if(data == 1){
					alert("Thành công !!!");
					$('#close_chair_saveDB').click();
					loadResources();
				}else if(data == -1){
					alert("Tên ghế bị trùng !!!");
				}else{
					alert("Thất bại !!!");
				}
			},
			error: function(data) {
				alert("Error occured.Please try again!");
			},
		});
	}
	
</script>
