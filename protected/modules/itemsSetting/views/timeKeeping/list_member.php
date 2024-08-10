<style>
.hover_list{
	cursor:pointer
}
.hover_list:hover{
	background-color:#c1c1c1
}
</style>
<input type='hidden' id='id_user' value='<?php echo $id_user;?>'/>
<table class="table table-bordered">
		<thead>
			<tr>
			    <th style='text-align:left;'>Tên Nhân Sự</th>
			    <th style='text-align:left;'>Tên Nhóm </th>
				<th>Comison(%)</th>
				<!--
				<?php foreach($CsServiceTypeTk as $gt){?>
					<th class='hover_list' id='service_type_<?php echo $gt['id'];?>' onclick='update_service_type(<?php echo $gt['id'];?>);' style='font-weight:bold'><?php echo $gt['name'].' (%)';?></th>
				<?php }?>-->
			</tr> 
		</thead>
		<tbody>
			<?php
			if(!empty($list_data['data'])){               
				foreach($list_data['data'] as $k=> $value){ 
					?>
				<?php for($i=0;$i<count($CsServiceTypeTk);$i++){
					$cus = CsPercentTk::model()->findAll('st = 1 and id_gp_users=:st and id_service_type_tk=:dd',array(':st'=>$value['id'],':dd'=>$CsServiceTypeTk[$i]['id']));
					$val_per = $cus?$cus[0]['percent']:'00';
					?>
				<tr>
				<td style='text-align:left;'><?php echo $value['name'];?></td>
				<td style='text-align:left;'>
					<button id='service_type_<?php echo $CsServiceTypeTk[$i]['id'];?>' onclick='update_service_type(<?php echo $CsServiceTypeTk[$i]['id'];?>);' type="button" style='text-align:center' class="btn btn-default" value=''>
						<?php echo $CsServiceTypeTk[$i]['name'];?>
					</button> 
				</td>
				<td style='text-align:center;'>
					<button id='id_cusser_<?php echo $value['id'];?>_<?php echo $CsServiceTypeTk[$i]['id'];?>' type="button" style='text-align:center' class="btn btn-default myBtnChange" value='<?php echo $CsServiceTypeTk[$i]['id'].'|'.$value['id'];?>'><?php echo $val_per;?></button>
				</td>
				</tr>
				<?php }?>
			<?php } }else{?>
			<tr>
			<?php for($i=0;$i<count($CsServiceTypeTk)+1;$i++){?>
				<td><h3>Không có dữ liệu !!!</h3></td>
			<?php }?>
			</tr>
			<?php }?>
		</tbody>
	</table>
		
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style='background-color:#ffffff;color:#000000'>
			<button type="button" class="close" style='color:#000000' data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Chỉnh Sửa</h4>
        </div>
        <div class="modal-body">
		    <div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<div class="row" style="padding-bottom: 15px;">
							<div class="col-sm-12">
							<form class="form-horizontal">
							    <div class="form-group">
								  <label class="control-label col-sm-3" for="email">Phần Trăm:</label>
								  <div class="col-sm-9">
									<input type='text' id='text_change' class='form-control'/>
									<input type='hidden' id='id_user' class='form-control'/>
									<input type='hidden' id='id_service_type' class='form-control'/>
								  </div>
								</div>
							</form>
							</div>
						</div>				
					</div>
				</div>
	        </div>
		</div>
		<div class="modal-footer">
            <button type="button" class="btn btn-default" onclick='change_percen();'>Xác Nhận</button> <button type="button" id='cusser_close' class="btn btn-default" data-dismiss="modal">Thoát</button>
        </div>
    </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(".myBtnChange").click(function(){ 
	    var str = $.trim($(this).html());
		var str2 = $(this).val();
	    $("#myModal2").modal();
        $("#text_change").val(str);
        $("#id_user").val(str2.split("|")[1]); 	
        $("#id_service_type").val(str2.split("|")[0]);		
        //alert(str.split("|")[1]);		
    });
});

function update_service_type(id){
	var id_user = $('#id_user').val();
	$.ajax({
		type:'POST',
		url: '<?php echo Yii::app()->baseUrl;?>'+'/itemsSetting/TimeKeeping/updateTimeKeeping', 	
		data: {
			"id":id,
			"id_user":id_user
		},   
		success:function(data){
			$("#myModalUpdate").modal();
			$(".content_update").html(data);		
		},
		error: function(data){
		console.log("error");
		console.log(data);
		}
	});
}
</script>