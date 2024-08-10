
<?php
	$listTreatmentWork = '';
	if($MedicalHistory['id']){
		$listTreatmentWork = Customer::model()->getListTreatmentWorkAll($MedicalHistory['id']);
	}
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content quote-container">
	    <div class="modal-header sHeader">
	        <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close">
	        	<span aria-hidden="true">×</span>
	        </button>
	        <h3 id="modalTitle" class="modal-title">Quá trình điều trị</h3>
	    </div>
	    <div class="modal-body">
	        <div class="row">
	        	<form id="frm-save-medical-history" onsubmit="return false;" class="form-horizontal">
	                <input type="hidden" id="id_medical_history" name="id_medical_history" value="<?php echo $MedicalHistory['id'];?>">
                	<div class="col-xs-12">
                		<div class="row"  id="containerTreatment">
                			<?php if($data_tooth){ ?>
	                			<div class="col-xs-12" data-treatment="0">
				                	<div class="col-md-6 margin-top-10">
				                		<label class="control-label">Số răng:</label>
				                		<select name="tooth_numbers[0][]" class="form-control tooth_numbers" multiple>
				                			<?php
				                				$list_tooth = Customer::model()->getListTooth();
				                				foreach ($list_tooth as $t) {
				                			?>
												<option value="<?php echo $t; ?>" <?php searchForId($t, $data_tooth); ?>>
													<?php echo $t; ?>
												</option>
											<?php }?>

										</select>
				                	</div>
				                	<div class="col-md-6 margin-top-10">
										<label class="control-label">Công tác điều trị:</label>
										<textarea required class="form-control treatment_work" name="treatment_work[]" rows="3" placeholder="Công tác điều trị"></textarea>
									</div>
									<div class="col-xs-12">
										<button onclick="removeTreatment(0);" class="btn sbtnAdd margin-top-10">
											<span class="glyphicon glyphicon-minus"></span>
										</button>
									</div>
								</div>
							<?php }else{ ?>
							<?php if($listTreatmentWork){ ?>
							<?php foreach ($listTreatmentWork as $w => $TreatmentWork) { ?>
								<div class="col-xs-12" data-treatment="<?php echo $w; ?>">
				                	<div class="col-md-6 margin-top-10">
				                		<label class="control-label">Số răng:</label>
				                		<select name="tooth_numbers[<?php echo $w ?>][]" class="form-control tooth_numbers" multiple>
				                			<?php
				                				$tooth_numbers = explode(',', $TreatmentWork['tooth_numbers']);
				                				$list_tooth = Customer::model()->getListTooth();
				                				foreach ($list_tooth as $t) {
				                			?>
												<option value="<?php echo $t; ?>" <?php searchForId($t, $tooth_numbers); ?>>
													<?php echo $t; ?>
												</option>
											<?php }?>

										</select>
				                	</div>
				                	<div class="col-md-6 margin-top-10">
										<label class="control-label">Công tác điều trị:</label>
										<textarea required class="form-control treatment_work" name="treatment_work[]" rows="3" placeholder="Công tác điều trị"><?php echo $TreatmentWork['treatment_work']; ?></textarea>
									</div>
								</div>
							<?php } ?>
							<?php }else{ ?>
								<div class="col-xs-12" data-treatment="0">
				                	<div class="col-md-6 margin-top-10">
				                		<label class="control-label">Số răng:</label>
				                		<select name="tooth_numbers[0][]" class="form-control tooth_numbers" multiple>
				                			<?php
				                				$list_tooth = Customer::model()->getListTooth();
				                				foreach ($list_tooth as $t) {
				                			?>
												<option value="<?php echo $t; ?>">
													<?php echo $t; ?>
												</option>
											<?php }?>
										</select>
				                	</div>
				                	<div class="col-md-6 margin-top-10">
										<label class="control-label">Công tác điều trị:</label>
										<textarea required class="form-control treatment_work" name="treatment_work[]" rows="3" placeholder="Công tác điều trị"></textarea>
									</div>
								</div>
							<?php }?>
							<?php }?>
						</div>
					</div>
					<div class="col-md-12 margin-top-15">
						<div class="col-xs-12">
							<button id="addTreatment" class="btn sbtnAdd ">
								<span class="glyphicon glyphicon-plus"></span>
								Thêm công tác điều trị
							</button>
						</div>
					</div>
					<div class="col-xs-12">
	               		<div class="col-md-6 margin-top-15">
	               			<div class="row">
			               		<div class="col-xs-12 form-group">
									<label class="col-md-5 control-label">Bác sĩ điều trị:</label>
									<div class="col-md-7">
										<div class="row">
											<?php
						                    	if($MedicalHistory['id_dentist']){
													$selected = $MedicalHistory['id_dentist'];
												}else{
													$selected = Yii::app()->user->getState('group_id')==Yii::app()->params['id_group_dentist']?yii::app()->user->getState('user_id'):"";
												}
												$listdata = array();
												foreach($model->getListDentists() as $temp){
													$listdata[$temp['id']] = $temp['name'];
												}

												echo CHtml::dropDownList('id_dentist','',$listdata,array('class'=>'form-control id_dentist','required'=>'required','options'=>array($selected=>array('selected'=>true))));
											?>
										</div>
									</div>
								</div>
							</div>
						<?php if(!$MedicalHistory['id']){ ?>
							<div class="form-group">
								<label class="col-md-5 control-label">Toa thuốc:</label>
								<div class="btn oUpdates" id="action-prescription" data-toggle="modal" data-target="#prescriptionModal">Thêm toa thuốc</div>
							</div>
							<div class="form-group hidden">
								<label class="col-md-5 control-label">Lab:</label>
								<div class="btn oUpdates" data-toggle="modal" data-target="#labModal">Thêm lab</div>
							</div>
						<?php } ?>
							<div class="form-group">
				                <div class="checkbox col-md-12">
				                    <label>
				                        <input id="status_success" name="status_success" type="checkbox" value="true"> Cập nhật trạng thái hoàn tất
				                    </label>
				                </div>
				            </div>
	                	</div>
	                	<div class="col-md-6 margin-top-15">
	                		<div class="col-md-12">
		                		<span class="fl" style="margin-right: 10px;">
									<a class="btn_plus create_appt" id="create_appt_cus"></a>
								</span>
								<span class="fl">
									<button class="oUpdates" id="get_newest_schedule">
										Cập nhật lịch hẹn
									</button>
								</span>
							</div>
							<div class="col-md-10 margin-top-10">
								<textarea name="newest_schedule" id="newest_schedule" class="form-control" readonly="true" rows="5"><?php echo $MedicalHistory['newest_schedule'];?></textarea>
	                		</div>

							<div class="clearfix"></div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-xs-6">
						<div class="col-md-12">
	        				<label class="col-md-4 control-label">Ngày tạo:</label>
	        				<div class="col-md-8">
	        					<?php
	        						$createdate = $MedicalHistory['createdate'];
	        					?>
	        					<input  class=" form-control" id="createdate" name="createdate" placeholder="Ngày tạo" value="<?php echo date_format(date_create($createdate),'Y-m-d');?>">
	        				</div>
	        			</div>
						<div class="col-md-12 hidden" style="margin-top: 10px; margin-bottom: 10px;">
							<label class="col-md-4 control-label">Ngày giờ tái khám:</label>
							<div class="col-md-8">
								<input class="form-control" id="reviewdate" name="reviewdate" type="text" placeholder="Ngày giờ tái khám">
							</div>
						</div>
						<div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;">
							<label class="col-md-4 control-label">Ghi chú:</label>
							<div class="col-md-8">
								<textarea id="description" name="description" class="form-control" rows="3" placeholder="Ghi chú"><?php echo $MedicalHistory['description']; ?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12">
		                <div class="col-xs-12 text-right">
			                <button id="addnewMedicalHistory" class="new-gray-btn new-green-btn">Xác nhận</button>
	                    	<button class="cancelNewStaff new-gray-btn cancel" data-dismiss="modal" aria-label="Close">Hủy</button>
		                </div>
			        </div>
	            </form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$(".tooth_numbers").select2({
		    placeholder: "Số răng",
		    allowClear: true
		});
	});
	$(function () {
	   	$('.createdate').datetimepicker({
	      format: 'YYYY-MM-DD HH:mm:ss',
	      defaultDate: moment().format('YYYY-MM-DD HH:mm:ss'),
	    });
	   	$('#reviewdate').datetimepicker({
	      format: 'YYYY-MM-DD HH:mm:ss',
	    });
	});
/*************Thêm số răng và công tác điều trị ***************/
	$('#addTreatment').click(function (e) {
	    e.preventDefault();
	    var lastDataTreatment = $('#containerTreatment > div').last().data('treatment');
	    var data_treatment    = lastDataTreatment + 1;
	    $('#containerTreatment').append($('<div class="col-xs-12" data-treatment="'+data_treatment+'">')
	        .append($('<div class="col-md-6 margin-top-10">')
	            .append('<label class="control-label">Số răng:</label>')
	            .append($('<select name="tooth_numbers['+data_treatment+'][]" class="form-control tooth_numbers" multiple>')
	                .append('<option value="11">11</option>')
	                .append('<option value="12">12</option>')
	                .append('<option value="13">13</option>')
	                .append('<option value="14">14</option>')
	                .append('<option value="15">15</option>')
	                .append('<option value="16">16</option>')
	                .append('<option value="17">17</option>')
	                .append('<option value="18">18</option>')
	                .append('<option value="21">21</option>')
	                .append('<option value="22">22</option>')
	                .append('<option value="23">23</option>')
	                .append('<option value="24">24</option>')
	                .append('<option value="25">25</option>')
	                .append('<option value="26">26</option>')
	                .append('<option value="27">27</option>')
	                .append('<option value="28">28</option>')
	                .append('<option value="31">31</option>')
	                .append('<option value="32">32</option>')
	                .append('<option value="33">33</option>')
	                .append('<option value="34">34</option>')
	                .append('<option value="35">35</option>')
	                .append('<option value="36">36</option>')
	                .append('<option value="37">37</option>')
	                .append('<option value="38">38</option>')
	                .append('<option value="41">41</option>')
	                .append('<option value="42">42</option>')
	                .append('<option value="43">43</option>')
	                .append('<option value="44">44</option>')
	                .append('<option value="45">45</option>')
	                .append('<option value="46">46</option>')
	                .append('<option value="47">47</option>')
	                .append('<option value="48">48</option>')
	                .append('<option value="51">51</option>')
	                .append('<option value="52">52</option>')
	                .append('<option value="53">53</option>')
	                .append('<option value="54">54</option>')
	                .append('<option value="55">55</option>')
	                .append('<option value="61">61</option>')
	                .append('<option value="62">62</option>')
	                .append('<option value="63">63</option>')
	                .append('<option value="64">64</option>')
	                .append('<option value="65">65</option>')
	                .append('<option value="71">71</option>')
	                .append('<option value="72">72</option>')
	                .append('<option value="73">73</option>')
	                .append('<option value="74">74</option>')
	                .append('<option value="75">75</option>')
	                .append('<option value="81">81</option>')
	                .append('<option value="82">82</option>')
	                .append('<option value="83">83</option>')
	                .append('<option value="84">84</option>')
	                .append('<option value="85">85</option>')
	            )

	            .append($('<button onclick="removeTreatment('+data_treatment+');" class="btn sbtnAdd margin-top-10">')
	                .append('<span class="glyphicon glyphicon-minus"></span>')
	            )

	        )

	        .append($('<div class="col-md-6 margin-top-10">')
	            .append('<label class="control-label">Công tác điều trị:</label>')
	            .append('<textarea required class="form-control" name="treatment_work[]" rows="3" placeholder="Công tác điều trị"></textarea>')
	        )
	    );

	    $(".tooth_numbers").select2({
	        placeholder: "Số răng",
	        allowClear: true
	    });
	    e.stopPropagation();
	});
/*************Remove số răng và công tác điều trị *************/
	function removeTreatment(data_treatment){
	    var evt = window.event || arguments.callee.caller.arguments[0];
	    evt.preventDefault();
	    $('div[data-treatment]').each(function(index, element) {
	        if ( $(this).attr('data-treatment') == data_treatment ) {
	          $(this).remove();
	        }
	    });
	    evt.stopPropagation();
	}
/*************lịch hẹn trong quá trình điều trị *************/
	$('.create_appt').click(function (e) {
        $.ajax({
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSchedule/calendar/createScheduleInCustomer')?>",
            data: {
                id_customer: '<?php echo $id_customer; ?>',
                id_quotation: $('#id_quotation').val(),
            },
            success:function(data){
                if(data){
                    $("#CalendarModal").html(data);
                    $('#CalendarModal').modal('show');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    });
/*************Cập nhật lịch hẹn *************/
	$('#get_newest_schedule').click(function(e){
        e.preventDefault();
        $.ajax({
            type    : "POST",
            url     : baseUrl+'/itemsCustomers/Accounts/GetNewetSchedule',
            data    : {"id_customer": $("#id_customer").val()},
            dataType: 'json',
            success: function (data) {
                var string = "";
                if(data) {
                    $.each(data, function(k,v){
                        string += v + "\n";
                    });
                }
                console.log(string);
                $('#newest_schedule').val(string);
            }
        });
    })
/*************form lưu quá trình điều trị *************/
	$('#frm-save-medical-history').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($("#frm-save-medical-history")[0]);
        formData.append('id_customer', $('#id_customer').val());
        formData.append('id_history_group', $('#id_mhg').val());

        if (!formData.checkValidity || formData.checkValidity()) {
			$('.cal-loading').fadeIn('fast');
            jQuery.ajax({
                type: "POST",
				url: baseUrl + '/itemsMedicalRecords/AccountsCus/saveMedicalHistory',
				data: formData,
				datatype: 'json',
                success:function(data) {
                   	$("#add-treatment-process-modal").removeClass("in");
                   	$(".modal-backdrop").remove();
                   	$('#add-treatment-process-modal').modal('hide');
                   	$("body").removeClass('modal-open');
                   	$("body").css('padding-right', '0');
                   	$('#tab_medical_records').html(data);
                   	e.stopPropagation();
                   	$('.cal-loading').fadeOut('fast');
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

	$( "#createdate" ).datepicker({
        changeMonth: true,
        changeYear: true,       
        dateFormat: 'yy-mm-dd',
        yearRange: '1900:+0'
    });
</script>
<?php
   function searchForId($id, $array) {
       foreach ($array as $key) {
           if ($key == $id) {
               echo 'selected';
           }
       }
       echo null;
    }
?>