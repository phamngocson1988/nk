<div class="modal-dialog" role="document">
  	<div class="modal-content">
	 	<div class="modal-header sHeader">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        <h3 id="modalTitle" class="modal-title">TOA THUỐC</h3>
    	</div>			       
	    <div class="modal-body">
	      <form id="frm-prescription" class="form-horizontal" onsubmit="return false;">
	      	<input type="hidden" id="id_medical_history_pre" name="id_medical_history_pre" value="<?php echo $id_medical_history; ?>">
	      	<div class="row">
	      		<div class="col-md-7">													
					<span class="input-group-addon text-left spn-dots">Họ và tên bệnh nhân: <?php echo $model->fullname;?></span>
				</div>	
				<div class="col-md-5">																		
					<span class="input-group-addon text-left spn-dots">tuổi: <?php if($model->birthdate != '0000-00-00' && $model->birthdate != '') echo date("Y") - date('Y',strtotime($model->birthdate));?></span>
				</div>	
	      	</div>

	      	<div class="row">
	      		<div class="col-md-12">															
					<span class="input-group-addon text-left spn-dots">Địa chỉ: <?php echo $model->address;?></span>
				</div>								
	      	</div>												
			<div class="input-group">
			  <span class="input-group-addon spn-dots">Chẩn đoán:</span>
			  <input required type="text" class="form-control ipt-dots" id="diagnose" name="diagnose" value="<?php echo $prescription['diagnose']; ?>">												 
			</div>

	      	<h4 class="text-center margin-top-30">THUỐC VÀ CÁCH SỬ DỤNG</h4>
	      	<div id="dntd">
	      		<?php 
	      			if($prescription['id']){ 
	      				$listDrugAndUsage = $model->listDrugAndUsage($prescription['id']);
	      				foreach ($listDrugAndUsage as $key => $value) {
	      		?>
		      		<div data-drug="<?php echo $key+1; ?>">
		          		<div class="input-group">
						  <span class="input-group-addon spn-dots"><?php echo $key+1; ?>.</span>
						  <input required type="text" class="form-control ipt-dots" name="drug_name[]" value="<?php echo $value['drug_name']; ?>">
						</div>				
						<div class="input-group">
						  <span class="input-group-addon dots spn-dots">Ngày</span>
						  <input required type="number" class="form-control ipt-dots text-align-right" name="times[]" value="<?php echo $value['times']; ?>">	
						  <span class="input-group-addon dots spn-dots">lần, mỗi lần:</span>
						  <input required type="text" class="form-control ipt-dots" name="dosage[]" value="<?php echo $value['dosage']; ?>">					  
						</div>
					</div>	
				<?php } ?>
				<?php }else{ ?>
					<div data-drug="1">
		          		<div class="input-group">
						  <span class="input-group-addon spn-dots">1.</span>
						  <input required type="text" class="form-control ipt-dots" name="drug_name[]">
						</div>				
						<div class="input-group">
						  <span class="input-group-addon dots spn-dots">Ngày</span>
						  <input required type="number" class="form-control ipt-dots text-align-right" name="times[]">	
						  <span class="input-group-addon dots spn-dots">lần, mỗi lần:</span>
						  <input required type="text" class="form-control ipt-dots" name="dosage[]">					  
						</div>
					</div>		
				<?php }?>						
			</div>
			<div class="margin-top-15">
				<button id="upAdd" class="btn sbtnAdd "><span class="glyphicon glyphicon-plus"></span> Thuốc</button>	
			</div>
			<div class="row margin-top-30">
				<div class="col-md-12">						                
					<label class="control-label">Lời dặn:</label>
					<textarea class="form-control" id="advise" name="advise"><?php echo $prescription['advise']; ?></textarea>
					<script>	
					CKEDITOR.replace( 'advise', {
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

			<div class="row">
				<div class="col-md-6">														
					<div class="input-group">
					  <span class="input-group-addon spn-dots">Tái khám sau</span>
					  <input type="number" class="form-control ipt-dots text-align-right" id="examination_after" name="examination_after" value="<?php echo $prescription['examination_after']; ?>">
					  <span class="input-group-addon spn-dots">ngày</span>							 
					</div>
				</div>									
			</div>							

			<div class="modal-footer" style="padding: 15px 0px 0px 0px;border-top:none;">
				<?php if($prescription['id']){ ?>
			  		<button type="button" class="btn print btn-green fl">In toa thuốc</button>
			  	<?php } ?>
		      	<?php
			      	$group_id =  Yii::app()->user->getState('group_id'); 
			      	if($group_id==1 || $group_id ==8){ 
			      		if($prescription['id']){
		      	?>
			      	<span id="cancelPrescription" class="btn btn-danger" onclick="deletePrescription(<?php echo $prescription['id']; ?>)">Xóa toa thuốc</span>
			    <?php } } ?>
	          	<button type="submit" class="btn btn-primary">Lưu</button>
	          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
	        </div>	
	      </form>
	    </div>
  	</div>
</div>

<script>
/************* Thêm danh sách thuốc *************/
	$('#upAdd').click(function (e) { 
	    e.preventDefault();
	    var lastDataDrug = $('#dntd > div').last().data('drug');
	    var data_drug    = lastDataDrug + 1;
	    $('#dntd').append($('<div data-drug="'+data_drug+'">')
	                .append($('<div class="input-group">')
	                .append('<span class="input-group-addon spn-dots">'+data_drug+'.</span>')
	                .append('<input required type="text" class="form-control ipt-dots" name="drug_name[]">')
	                )                
	                .append($('<div class="input-group">')
	                .append('<span class="input-group-addon dots spn-dots">Ngày</span>')
	                .append('<input required type="number" class="form-control ipt-dots text-align-right" name="times[]">')
	                .append('<span class="input-group-addon dots spn-dots">lần, mỗi lần:</span>')
	                .append('<input required type="text" class="form-control ipt-dots" name="dosage[]">')
	                .append($('<div class="input-group-addon dots spn-dots">')
	                .append($('<button onclick="minusDelete('+data_drug+');" class="btn sbtnAdd">')
	                .append('<span class="glyphicon glyphicon-minus"></span>')
	                            )
	                        )
	                )
	                ); 

	    e.stopPropagation();
	});
/************* xóa danh sách thuốc *************/
	function minusDelete(data_drug){
	    var evt = window.event || arguments.callee.caller.arguments[0];
	    evt.preventDefault();  
	    $('div[data-drug]').each(function(index, element) {         
	        if ( $(this).attr('data-drug') == data_drug ) {    
	          $(this).remove();
	        }
	    });
	    evt.stopPropagation();
	}
/************* form toa thuốc *************/	
	$('#frm-prescription').submit(function(e) {
	    $('.cal-loading').fadeIn('fast');
	    e.preventDefault();
	    var formData = new FormData($("#frm-prescription")[0]);
	    CKEDITOR.instances.advise.updateElement(); 
	   	formData.append('advise',document.getElementById( 'advise' ).value); 
	    formData.append('id_history_group',$('#id_mhg').val()); 
	    formData.append('id_customer',$('#id_customer').val());
	    if (!formData.checkValidity || formData.checkValidity()) {
	        jQuery.ajax({           
	            type:"POST",
	            url: baseUrl+'/itemsMedicalRecords/AccountsCus/setSessionAddPrescription',   
	            data:formData,
	            datatype:'json',
	            success:function(data){  
	                e.stopPropagation(); 
	                $('#prescriptionModal').modal('hide');  
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
/************* print toa thuốc *************/
	$('.print').on('click',function(e){
        var id_customer        = $("#id_customer").val();
        var id_medical_history = $("#id_medical_history_pre").val();   
        if (id_medical_history && id_medical_history) {
            var url="<?php echo CController::createUrl('AccountsCus/exportPrescription')?>?id_customer="+id_customer+"&id_medical_history="+id_medical_history;
            window.open(url,'name') 
        };
                      
    });
/************* xóa labo *************/
	function deletePrescription(id_prescription){
	    var id_mhg 		= $('#id_mhg').val();
	   	var id_customer = $('#id_customer').val();
	    if(confirm("Bạn có thực sự muốn xóa?")) {
	        $.ajax({
	            type    : "POST",
	            url     : baseUrl+'/itemsMedicalRecords/AccountsCus/deletePrescription',
	            data    : {
	                "id_prescription" : id_prescription,
	                'id_mhg'          : id_mhg,
	                'id_customer'     : id_customer,
	            },
	            success: function (data) {
	                $("#prescriptionModal").modal('hide'); 
	                $(".modal-backdrop").remove(); 
	                $("body").removeClass('modal-open'); 
	                $("body").css('padding-right','0');
	                $('#tab_medical_records').html(data);
	            }
	        });
	    }
	}

</script>