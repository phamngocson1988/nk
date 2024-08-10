<?php  $baseUrl = Yii::app()->baseUrl; ?>
<!-- bootstrap-fileinput-master -->
<link href="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/theme.css" media="all" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/sortable.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/fileinput.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap-fileinput-master/theme.js"></script>
<!-- end bootstrap-fileinput-master -->
<script src="<?php echo Yii::app()->baseUrl.'/ckeditor/ckeditor.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/html2canvas.js"></script>

<?php include('style.php'); ?>

<div class="col-xs-12 bg-w" id="tab-customer">
	<div class="col-sm-4 col-md-3 " id="left_tab">
		<a target="_blank" href="<?php echo $baseUrl . '/itemsCustomers/Accounts/admin?code_number=' . $model['code_number']; ?>">
			<div class="name_cus margin-top-5">
				<?php echo $model['fullname']; ?> - MKH:
				<?php echo $model['code_number']; ?>
			</div>
		</a>
	</div>
	<div class="col-sm-8 col-md-9" id="right_tab">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#tab_medical_records">Bệnh án</a>
			</li>
			<li>
				<a data-target="#createLaboModal" data-toggle="modal" href="#" class="btn_plus"></a>
			</li>
		</ul>
	</div>
</div>

<div class="col-xs-12 line"></div>
<div class="col-xs-12" id="tab_medical_records"></div>

<div class="modal" id="createLaboModal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header sHeader">
                <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3 id="info_head" class="modal-title">Thông tin giao nhận Labo</h3>
            </div>

            <div class="modal-body">
            	<form id="frm-labo" class="form-horizontal" onsubmit="return false;">
            		<input type="hidden" name="id_customer" value="<?php echo $model->id?>">
	            	<div class="margin-top-20">
		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Tên khách hàng:</span>
	   						<div class="col-md-8">
	   						<input disabled type="text" class="form-control" value="<?php echo $model->fullname;?>">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Mã khách hàng:</span>
	   						<div class="col-md-8">
	   						<input disabled type="text" class="form-control" value="<?php echo $model->code_number;?>">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Bác sĩ:</span>
	   						<div class="col-md-8">
	   						<?php 
	   							$selected=yii::app()->user->getState('group_id')==Yii::app()->params['id_group_dentist']?yii::app()->user->getState('user_id'):"";
	   							$listdata = array();				
								foreach($model->getListDentists() as $temp){
									$listdata[$temp['id']] = $temp['name'];
								}	
								echo CHtml::dropDownList('id_d3ntist','',$listdata,array('class'=>'form-control','required'=>'required','options'=>array($selected=>array('selected'=>true))));
							?>			
	   						</div>
		   				</div>
			   				 								   				
		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Labo: </span>
	   						<div class="col-md-8">
	   						<?php
	   							$listdata = array();				
								foreach(ListLabo::model()->findAll() as $temp){
									$listdata[$temp['id']] = $temp['name'];
								}	
								echo CHtml::dropDownList('id_labo','',$listdata,array('class'=>'form-control','required'=>'required'));
	   						?>		
	   						</div>
		   				</div>
		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Ngày giao:</span>
	   						<div class="col-md-8">
		   						<input required type="text" class="form-control col-sm-6" id="labo_sent_date" name="sent_date" value="<?php echo date("Y-m-d");?> 12:00:00">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Người giao:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" value="" name="sent_person">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Khay giao:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" value="" name="sent_tray">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Ngày nhận:</span>
	   						<div class="col-md-8">
		   						<input required type="text" class="form-control" id="labo_receive_date" name="receive_date" value="<?php echo date("Y-m-d");?> 12:00:00">			
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Người nhận:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" value="" name="receive_person">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Khay nhận:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" value="" name="receive_tray">
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Bảo vệ:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" id="security" name="security" value="">			
	   						</div>
		   				</div>

		   				<div class="form-group">
		   					<span class="col-md-4 control-label">Nha tá nhận:</span>
	   						<div class="col-md-8">
	   						<input type="text" class="form-control" id="receive_assistant" name="receive_assistant" value="">			
	   						</div>
		   				</div>

		   				<div class="row">
							<div class="col-md-12">						                
								<label class="control-label">Nội dung</label>
								<textarea required class="form-control" id="assign" name="description" rows="4"></textarea>		
							</div>								
						</div>

	          		</div>

					<div class="modal-footer" style="padding: 15px 0px 0px 0px;border-top:none;">
					  	<!-- <button type="button" class="btn print_lab">In lab</button> -->
			          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
			          	<?php
					      	$group_id =  Yii::app()->user->getState('group_id'); 
					      	if($group_id==1 || $group_id ==8){ 
				      	?>
					      	<span id="cancelLabo">
						    </span>
					    <?php } ?>
			          	<button type="submit" class="btn btn-primary">Lưu</button>
			        </div>
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    
    </div>
</div>

<script>
	var baseUrl = '<?php echo Yii::app()->baseUrl;?>';
	var id_customer = "<?php echo $model['id']; ?>";

	function loadMedicalRecords(id_cus, treatment) {
		$('.cal-loading').fadeIn('fast');
		$.ajax({
			type: "POST",
			url: baseUrl + "/itemsMedicalRecords/AccountsCus/loadMedicalRecords",
			data: {
				id_customer: id_cus,
				treatment: treatment,
			},
			success: function (data) {
				$('.cal-loading').fadeOut('slow');
				$('#tab_medical_records').html(data);
			},
		});
	}

	$(document).ready(function () {
		loadMedicalRecords(id_customer, '');
	});

	$(function () {
	    $( "#labo_sent_date" ).datetimepicker({
	    	dateFormat: 'yy-mm-dd',
	    	timeFormat: 'hh:mm:ss',
	        showSecond: false, 
	       	showTimezone: false,
	       	showMillisec: false,
	       	showMicrosec: false,
	    });
	    $( "#labo_receive_date" ).datetimepicker({
	        dateFormat: 'yy-mm-dd',
	    	timeFormat: 'hh:mm:ss',
	        showSecond: false, 
	       	showTimezone: false,
	       	showMillisec: false,
	       	showMicrosec: false,
	    });
	});

	$('#frm-labo').submit(function(e) {
	    $('.cal-loading').fadeIn('fast');
	    e.preventDefault();
	    var formData = new FormData($("#frm-labo")[0]);
	    if (!formData.checkValidity || formData.checkValidity()) {
	        jQuery.ajax({           
	            type:"POST",
	            url: baseUrl+'/itemsMedicalRecords/AccountsCus/saveLaboHistory',   
	            data:formData,
	            datatype:'json',
	            success:function(data){
	                e.stopPropagation(); 
	                $('#createLaboModal').modal('hide');  
	                $('.cal-loading').fadeOut('slow');  
	                if(data != 1){
	                	$(".modal-backdrop").remove(); 
		                $("body").removeClass('modal-open'); 
		                $("body").css('padding-right','0');
		                $('#tab_medical_records').html(data);
		                alert("Success!");
	                }    
	                loadMedicalRecords(id_customer, '');   
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
</script>

<script src="<?php echo Yii::app()->baseUrl.'/js/jquery-ui-timepicker-addon.js'; ?>"></script>
<link href="<?php echo $baseUrl; ?>/css/jquery-ui-timepicker-addon.css" media="all" rel="stylesheet" type="text/css"/>