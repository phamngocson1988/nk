<div class="modal-dialog" role="document">
  	<div class="modal-content">
		<div class="modal-header sHeader">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        <h3 id="modalTitle" class="modal-title">THÔNG TIN GIAO NHẬN LABO</h3>
	    </div>		       
	    <div class="modal-body">
	      	<form id="frm-lab" class="form-horizontal" onsubmit="return false;">
		      	<input type="hidden" id="id_medical_history_lab" name="id_medical_history_lab" value="<?php echo $id_medical_history; ?>">
		      	<div class="row margin-top-20">
		      		<div class="col-md-6">
		      			<div class="form-group">
		   					<span class="col-md-4 control-label">Nha khoa:</span>
							<div class="col-md-8">
								<?php 
									if($labo['id_branch']){
								  		$selected_branch = $labo['id_branch'];
								  	}else{
								  		$selected_branch = yii::app()->user->getState('user_branch');
								  	}		
									$list_branch = array();														
									foreach($model->getListBranch() as $temp){
										$list_branch[$temp['id']] = $temp['name'];
									}	
									echo CHtml::dropDownList('id_branch','',$list_branch,array('class'=>'form-control','required'=>'required','options'=>array($selected_branch=>array('selected'=>true))));
								?>			
							</div>
		   				</div>
		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Bệnh nhân:</span>
							<div class="col-md-8">
							<input disabled type="text" class="form-control" value="<?php echo $model->fullname;?>">			
							</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Ngày gửi:</span>
							<div class="col-md-8">
								<?php
									if($labo['sent_date']){
										$sent_date =  date_format(date_create($labo['sent_date']),'Y-m-d'); 
									}else{
										$sent_date = date("Y-m-d");
									} 
								?>
								<input required type="text" class="form-control" id="sent_date" name="sent_date" value="<?php echo $sent_date;?>">			
							</div>
		   				</div>
		      		</div>
		      		<div class="col-md-6">
		      			<div class="form-group">
		   					<span class="col-md-4 control-label">Nha sĩ:</span>
							<div class="col-md-8">
								<?php 
									if($labo['id_dentist']){
										$selected = $labo['id_dentist'];
									}else{
										$selected = Yii::app()->user->getState('group_id')==Yii::app()->params['id_group_dentist']?yii::app()->user->getState('user_id'):"";
									} 
									$listdata = array();
									foreach($model->getListDentists() as $temp){
										$listdata[$temp['id']] = $temp['name'];
									}		
									echo CHtml::dropDownList('id_dentist','',$listdata,array('class'=>'form-control','required'=>'required','options'=>array($selected=>array('selected'=>true))));
								?>			
							</div>
		   				</div>					   				
						<div class="form-group">
							<span class="col-md-4 control-label">Giới tính:</span>
							<div class="col-md-3" style="padding-right:0px;">
								<input disabled type="text" class="form-control" value="<?php if($model->gender == 0) echo "Nam"; else echo "Nữ";?>">			
							</div>
	   						<span class="col-md-2 control-label">Tuổi:</span>
							<div class="col-md-3">
								<input disabled type="text" class="form-control" value="<?php echo date("Y") - date('Y',strtotime($model->birthdate));?>">			
							</div>				   						
	   					</div>					   						
		   				
		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Ngày nhận:</span>
							<div class="col-md-8">
								<?php 
									if($labo['received_date']){
										$received_date =  date_format(date_create($labo['received_date']),'Y-m-d'); 
									}else{
										$received_date = date("Y-m-d");
									} 
								?>
								<input required type="text" class="form-control" id="received_date" name="received_date" value="<?php echo $received_date;?>">			
							</div>
		   				</div>
		      		</div>
		      	</div>
				<div class="row">
					<div class="col-md-12">						                
						<label class="control-label">Chỉ định của bác sĩ</label>
						<textarea required class="form-control" id="assign" name="assign" rows="4"><?php echo $labo['assign']; ?></textarea>									
					</div>								
				</div>	
				<div class="row margin-top-15">
					<div class="col-md-12">						                
						<label class="control-label">Ghi chú</label>
						<textarea class="form-control" id="n0te" name="n0te"><?php echo $labo['note']; ?></textarea>
						<script>	
						CKEDITOR.replace( 'n0te', {										
						    height: 70,														    			    
						    toolbarGroups: [                                                     
						        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
						        { name: 'paragraph',   groups: [ 'list', 'indent' ] },
						        { name: 'links' }                                              
						    ]
						});								
						</script>									
					</div>								
				</div>			
				<div class="modal-footer" style="padding: 15px 0px 0px 0px;border-top:none;">
					<?php if($labo['id']){ ?>
				  		<button type="button" class="btn print_lab btn-green fl">In lab</button>
		          	<?php } ?>
		          	<?php
				      	$group_id =  Yii::app()->user->getState('group_id'); 
				      	if($group_id==1 || $group_id ==8){ 
				      		if($labo['id']){
			      	?>
				      	<span id="cancelLaob" class="btn btn-danger" onclick="deleteLabo(<?php echo $labo['id']; ?>)">Xóa labo</span>
				    <?php }} ?>
		          	<button type="submit" class="btn btn-primary">Lưu</button>
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
		        </div>	  
	      	</form>
	    </div>
	</div>
</div>

<script>
	$(function () {
	    $( "#sent_date" ).datepicker({
	        changeMonth: true,
	        changeYear: true,       
	        dateFormat: 'yy-mm-dd'
	    });
	    $( "#received_date" ).datepicker({
	        changeMonth: true,
	        changeYear: true,       
	        dateFormat: 'yy-mm-dd'
	    });
	});
	/************* form labo *************/	
		$('#frm-lab').submit(function(e) {
		    $('.cal-loading').fadeIn('fast');
		    e.preventDefault();
		    var formData = new FormData($("#frm-lab")[0]);
		    CKEDITOR.instances.n0te.updateElement(); 
		    formData.append('note',document.getElementById( 'n0te' ).value); 
		    formData.append('id_history_group',$('#id_mhg').val()); 
		    formData.append('id_customer',$('#id_customer').val());
		    if (!formData.checkValidity || formData.checkValidity()) {
		        jQuery.ajax({           
		            type:"POST",
		            url: baseUrl+'/itemsMedicalRecords/AccountsCus/setSessionAddLab',   
		            data:formData,
		            datatype:'json',
		            success:function(data){  
		                e.stopPropagation(); 
		                $('#labModal').modal('hide');  
		                $('.cal-loading').fadeOut('slow');  
		                if(data != 1){
		                	$(".modal-backdrop").remove(); 
			                $("body").removeClass('modal-open'); 
			                $("body").css('padding-right','0');
			                $('#tab_medical_records').html(data);
		                }       
		            },
		            error: function(data) {
		                alert("Error occured. Please try again!");
		            },
		            cache: false,
		            contentType: false,
		            processData: false
		        });
		    }
		    return false;
		});
	/************* xóa labo *************/
		function deleteLabo(id_labo){
		    var id_mhg 		= $('#id_mhg').val();
		   	var id_customer = $('#id_customer').val();
		    if(confirm("Bạn có thực sự muốn xóa?")) {
		        $.ajax({
		            type    : "POST",
		            url     : baseUrl+'/itemsMedicalRecords/AccountsCus/deleteLabo',
		            data    : {
		                "id_labo"         : id_labo,
		                'id_mhg'          : id_mhg,
		                'id_customer'     : id_customer,
		            },
		            success: function (data) {
		                $("#labModal").modal('hide'); 
		                $(".modal-backdrop").remove(); 
		                $("body").removeClass('modal-open'); 
		                $("body").css('padding-right','0');
		                $('#tab_medical_records').html(data);
		            }
		        });
		    }
		}
	/************* print labo *************/
		$('.print_lab').on('click',function(e){
	        var id_customer         		= $("#id_customer").val();
	        var id_medical_history_lab  	= $("#id_medical_history_lab").val();   
	        if (id_medical_history_lab) {
	            var url="<?php echo CController::createUrl('AccountsCus/exportLabo')?>?id_customer="+id_customer+"&id_medical_history="+id_medical_history_lab;
	            window.open(url,'name') 
	        };
	                      
	    });
</script>