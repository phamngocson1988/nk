<?php $baseUrl = Yii::app()->baseUrl;?>
<style type="text/css">
#imageUploader:hover i {
    display: inline;
}
#customerProfileDetail .camera {
    position: absolute;
    text-align: center;
    top: 35px;
    left: 46px;
    font-size: 3.5em;
    border-radius: 50%;
}

.camera {
	display: none;
    opacity: 0.8;
    cursor: pointer;
}
.btn:hover {
    color: #333;
    text-decoration: none;
}
.btn {
    color: white;
}
.btn_nhakhoa2000 {
    background: #10b1dd;
    color: white;
}

.btn {
    border-radius: 0;
}
.tilte_profile{display:inline-block;color: #94c640;font-weight: bold;padding: 30px 0 10px 0; text-align: left;font-size: 18px; text-transform: uppercase;}
@media (max-width:768px) {
	.tilte_profile{display:inline-block;color: #94c640;font-weight: bold;padding: 30px 0 10px 0; text-align: left;font-size: 14px;text-transform: uppercase;}
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-datetimepicker.min.css">

<script defer src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/webcam/webcam.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/html2canvas.js"></script>
			<div id="customerProfileDetail" class="customerProfileHolder" style="display: block;margin:30px auto;">
					<div class="col-xs-12 col-sm-12 col-md-3">
						<form class="col-md-2" id="imageUploader" enctype="multipart/form-data" style="margin:0px;">
							<?php include("customer_image.php");?>
						</form>
					</div>

					 
					<div class="col-xs-12 col-sm-12 col-md-9" style="padding-bottom:40px; ">
					   	<form class="form-horizontal" id="" action="Profile/Edit_info" method="post" enctype="multipart/form-data">
					   		<div class="col-xs-12 col-sm-12">
					   			<div class="row" >
						   			<div  class="col-xs-10 col-sm-6 tilte_profile" >1. <?php echo Yii::t('translate','customer_infor'); ?></> </div>				   			
						   			<div  class="col-xs-2 col-sm-6" style="padding: 30px 0 10px 0; ">
							   			<input type="submit" id="save_info" name="save_info" value="<?php echo Yii::t('translate','save_change'); ?>" style="float:right;margin-right: 30px;display:none;">
							   			<span id="edit_info" style="margin-right:30px;float:right;cursor:pointer;" class="glyphicon glyphicon-pencil"></span>	
						   			</div>
					   			</div>
					  			<div class="row">
					   				<div class="col-xs-12 col-md-6">
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','full_name'); ?></label>
					   						<div class="col-md-8">
					   							<input disabled required type="text" id="fullname" name="fullname" value="<?php echo $model->fullname;?>" class="form-control">
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','gender'); ?></label>
					   						<div class="col-md-8">
					   						<?php
												$listdata = array();
												if($lang=='vi'){
													$listdata[0] = "Nam";
													$listdata[1] = "Nữ";
												}else{
													$listdata[0] = "Male";
													$listdata[1] = "Female";
												}
												echo CHtml::dropDownList('gender','',$listdata,array('class'=>'form-control',"disabled"=>"disabled",'options'=>array($model->gender=>array('selected'=>true))));
											
											?>				
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','birthday'); ?></label>
					   						<div class="col-md-8">
					   							<input disabled required type="" id="birthdate" name="birthdate" value="<?php echo $model->birthdate;?>" class="form-control datetimepicker">					   							
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label">CMND</label>
					   						<div class="col-md-8">
					   							<input disabled type="text" pattern="\d{9,12}" id="identity_card_number" name="identity_card_number" value="<?php if(!empty($model->identity_card_number)) echo $model->identity_card_number;?>" class="form-control">
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','nationality'); ?></label>
					   						<div class="col-md-8">		
					   							<?php
													$country = array();
													$list_data = $model->getListCountry();

													foreach($list_data as $temp){
														$country[$temp['code']] = $temp['country'];
													}
													echo CHtml::dropDownList('id_country','',$country,array('class'=>'form-control',"disabled"=>"disabled",'options'=>array($model->id_country=>array('selected'=>true))));
												?>
					   						</div>
					   					</div>					   					
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','phone1'); ?></label>
					   						<div class="col-md-8">
					   							<input required disabled pattern="\d{6,12}" type="text" id="phone" name="phone" value="<?php echo $model->phone; ?>" class="form-control">
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label">Email</label>
					   						<div class="col-md-8">
					   							<input disabled type="email" id="email" name="email" value="<?php echo $model->email;?>" class="form-control">
					   						</div>
					   					</div>
					   				</div>
					   				<div class="col-xs-12 col-md-6">
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','address'); ?></label>
					   						<div class="col-md-8">
					   							<textarea disabled id="address" name="address" rows="3" class="form-control"><?php echo $model->address;?></textarea>
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','job_1'); ?></label>
					   						<div class="col-md-8">
					   							<?php
													$job = array();
													$list_data = $model->getJob();

													foreach($list_data as $temp){
														$job[$temp['id']] = $temp['name'];
													}
													echo CHtml::dropDownList('id_job','',$job,array('class'=>'form-control','empty' => Yii::t('translate','choose_job'),"disabled"=>"disabled",'options'=>array($model->id_job=>array('selected'=>true))));
												?>					   							
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','position'); ?></label>
					   						<div class="col-md-8">					   							
					   						<?php
												$listdata = array();
												$listdata[1] = "Nhân viên";
												$listdata[2] = "Quản lý";
												echo CHtml::dropDownList('position','',$listdata,array('class'=>'form-control','empty' => Yii::t('translate','choose_position'),"disabled"=>"disabled",'options'=>array($model->position=>array('selected'=>true))));
											?>		
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','organization'); ?></label>
					   						<div class="col-md-8">
					   							<input disabled type="text" id="organization" name="organization" value="<?php echo $model->organization;?>" class="form-control">
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','note_1'); ?></label>
					   						<div class="col-md-8">
					   							<textarea disabled id="note" name="note" class="form-control" rows="4"><?php echo $model->note;?></textarea>
					   						</div>
					   					</div>
					   				</div>				   				
					   			</div>
					   		</div>	
					   	</form>
					   
					  
					   <form class="form-horizontal" id="frm-edit_pass" method="post" enctype="multipart/form-data">
					   		<div class="col-xs-12 col-sm-12">
					   			<div class="row">
					   				<div  class="col-xs-10 col-sm-6 tilte_profile" >2. <?php echo Yii::t('translate','change_password'); ?></> </div>
					   				<div  class="col-xs-2 col-sm-6" style="padding: 30px 0 10px 0; ">
						   				<input type="submit" id="save_pass" name="save_pass" value="<?php echo Yii::t('translate','save_change'); ?>" style="float:right;margin-right: 30px;display:none;">
						   				<span id="edit_pass" style="margin-right:30px;float:right;cursor:pointer;" class="glyphicon glyphicon-pencil"></span>
						   			</div>
					   			</div>
						   		<div class="row">
					   				<div class="col-xs-12 col-md-6">
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','old_pass'); ?></label>
					   						<div class="col-md-8">
					   							<input disabled type="password" id="password_old" name="password_old" value="" class="form-control" >
					   						</div>
					   						<div id="error_pass" class="hidden col-md-8" style="color: red; margin-top: 10px; float:right;"><?php echo Yii::t('translate','err_pass'); ?>!</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','new_pass'); ?></label>
					   						<div class="col-md-8">
					   							<input disabled type="password" id="password_new" name="password_new" value="" class="form-control" >
					   						</div>
					   					</div>
					   					<div class="form-group">
					   						<label class="col-md-4 control-label"><?php echo Yii::t('translate','confirm_password'); ?></label>
					   						<div class="col-md-8">
					   							<input disabled type="password" id="password_new_confirm" name="password_new_confirm" value="" class="form-control" >
					   						</div>
					   						<div id="error_passnew" class="hidden col-md-8" style="color: red; margin-top: 10px; "><?php echo Yii::t('translate','err_pass1'); ?>!</div>
					   						<div id="error_tt" class="hidden col-md-8" style="color: red; margin-top: 10px; "><?php echo Yii::t('translate','err_pass2'); ?>!</div>
					   					</div>

					   				</div>
					   			</div>
				   			</div>
					   </form>
					</div>
					<div id="notify_sch" class="modal fade">
						<div class="modal-dialog" style="margin-top: 18%;">
					   		<div class="modal-content">
					   			<div class="modal-header">
					   				<?php echo Yii::t('translate','notify'); ?>
					   				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					   			</div>
					   			<div class="modal-body">
					   				<div id="noti_mess"><?php echo Yii::t('translate','change_password_success'); ?>!</div>
					   			</div>
					    	</div>
					    </div>
					</div>
			</div>
		   <script type="text/javascript">
		    $('#notify_sch').on('hidden.bs.modal', function () {
			  	location.href = '<?php echo Yii::app()->params['url_base_http'] ?>/profile';
			})

		   	$('#frm-edit_pass').submit(function(e) {
			    e.preventDefault();    
			    var formData = new FormData($("#frm-edit_pass")[0]);    
			    if (!formData.checkValidity || formData.checkValidity()) {
			    	//$('.cal-loading').fadeIn('fast');
			        jQuery.ajax({           
			            type:"POST",
			            url:"<?php echo CController::createUrl('profile/edit_pass')?>",   
			            data:formData,
			            datatype:'json',
			            success:function(data){  
			            console.log(data);                      
			                if(data == -1){  
			                   $("#error_passnew").removeClass('hidden');              
			                }else
			                $("#error_passnew").addClass('hidden'); 
			                if(data == -2){  
			                	$("#error_pass").removeClass('hidden');            
			                }else
			                $("#error_pass").addClass('hidden'); 
			                
			                if(data >= 1){ 
			                	$('#notify_sch').modal('show'); 
			                    
			                }
			                if(data == 0){ 
			                	 $("#error_tt").removeClass('hidden');      
			                }else
			                $("#error_tt").addClass('hidden');     
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

			function updateCustomerImage(id){

		    $("#webcamModal").removeClass("in");
		    $(".modal-backdrop").remove();
		    $('#webcamModal').modal('hide');
		    
		    var formData = new FormData($("#imageUploader")[0]);   
		    formData.append('id',id);    
		    if (!formData.checkValidity || formData.checkValidity()) {
		        jQuery.ajax({         
		            type:"POST",
		            url:"<?php echo CController::createUrl('profile/updateCustomerImage')?>",   
		            data:formData,
		            datatype:'json',
		            success:function(data){             
		              $("#imageUploader").html(data);
		              	location.href = '<?php echo Yii::app()->params['url_base_http'] ?>/profile';             
		                Webcam.reset(); 
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
		}
		function updateCustomerImageDefault(id){

		    $("#webcamModal").removeClass("in");
		    $(".modal-backdrop").remove();
		    $('#webcamModal').modal('hide');  

		    $.ajax({
		        type:'POST',
		        url:"<?php echo CController::createUrl('profile/updateCustomerImageDefault')?>",   
		        data: {"id":id},   
		        success:function(data){          
		            $("#imageUploader").html(data);                
		           	location.href = '<?php echo Yii::app()->params['url_base_http'] ?>/profile';
		            Webcam.reset();  
		        },
		        error: function(data){
		        console.log("error");
		        console.log(data);
		        }
		    });

		} 
		$(function () {

		   $('.datetimepicker').datetimepicker({ 
	          format: 'YYYY-MM-DD',
	          //minDate: moment().format('YYYY-MM-DD'),
	          defaultDate: moment().format('YYYY-MM-DD'),
	        });
		});
</script>
