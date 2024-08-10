<style>
	#CalendarModal .modal-dialog {width: 410px; padding-top: 50px;}
	#CalendarModal .modal-content {border-radius: 0;}
	#CalendarModal .modal-header {background: #0eb1dc; color: white; padding: 7px 25px; }
	#CalendarModal .modal-header h3 {font-size: 20px; line-height: 1.7em;; font-weight: normal;}
	#CalendarModal .modal-header .close {font-size: 36px; color: white; opacity: 1; font-weight: lighter;} 
	#CalendarModal .modal-body {padding: 0 15px;}

	#CalendarModal label {text-align: right;}

	#frm-create-sch-cus>ul.nav {
		background   : #f4f8fa; 
		border-bottom: 3px solid white; 
		padding      : 10px 20px 0px !important;
	}

	#frm-create-sch-cus>.nav li a {
		background : inherit;
		border     : 0;
		font-weight: bold;
		padding    : 10px 20px;
		font-size  : 12px;
	}

	#frm-create-sch-cus>.nav li a:hover {
		background: #f4f8fa !important;
	}

	#frm-create-sch-cus>.nav>li.active{
		border-bottom: 0;
	}

	#frm-create-sch-cus>.nav>li.active>a, 
	#frm-create-sch-cus>.nav>li.active>a:focus, 
	#frm-create-sch-cus>.nav>li.active>a:hover
	{  
	    font-weight: bold;
	    border: 0;
	    background: white;
	    background: inherit;
	    border-bottom: 3px solid #93c54c;
	    color: black;
	}
	#frm-create-sch-cus .tab-content{margin: 20px 0;}
	#frm-create-sch-cus .h4 {font-size: 16px; font-weight: normal;}

	#frm-create-sch-cus input[type='text'],
	#frm-create-sch-cus textarea,
	#frm-create-sch-cus select,
	#frm-create-sch-cus [class^='select2']
	{border-radius: 0;}
	#showTime {height: 200px; overflow: auto;}

	.blockTime {padding: 10px; border: 1px solid #ccc; cursor: pointer;}
	.blockTime:hover {background: #19a8e0; color: white;}
	.errorInp {border: 1px solid red;}
	#schErr {color: red; font-style: italic; text-align: center;}
</style>

<div class="modal-dialog">
	<div class="modal-content">
	<!-- header pop up -->
		<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">close</span></button>
        	<h3 id="modalTitle" class="modal-title">TẠO LỊCH HẸN</h3>
     	</div>

     <!-- content pop up -->
     	<div class="modal-body">
     		<div class="row">
     			<?php /** @var TbActiveForm $form */
			        $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
						'id'   => 'frm-create-sch-cus',
						'type' => 'horizontal',
						'enableAjaxValidation' => true,
						'clientOptions' => array(
							'validateOnSubmit' => true,
							'validateOnChange' => true,
							'validateOnType'   => true,
		                ),
						'htmlOptions' => array(  
							'enctype' => 'multipart/form-data'
		        	))); 

		        	echo $form->hiddenField($sch,'id_customer',array('value'=>$id_customer));
		        ?>                                           

		        <ul class="nav nav-tabs">
	               <li id="nav-info" class="active"><a data-toggle="tab" href="#sch_info">Thông tin</a></li>
	               <li id="nav-time"><a data-toggle="tab" href="#sch_time">Thời gian</a></li>
	            </ul>

	            <div class="tab-content">
	            	<div id="sch_info" class="tab-pane fade in active">
		               	<div class="col-xs-6 col-xs-offset-1">
		                    <div class="h4">Trạng thái lịch hẹn</div>
		               	</div>
		               	<div class="col-xs-4">
		                  	<?php 
		                     	echo $form->dropDownListGroup($sch, "status",array(
		                        	'wrapperHtmlOptions' => array('class' => 'col-xs-12',),
		                        	'widgetOptions'=>array(
		                           		'data' => CsSchedule::model()->st0,
		                           		'htmlOptions'=>array('required'=>false,'class'=>'')),
		                           	'labelOptions' => array("label" => false)
		                    )); ?>
		               	</div>
		               	<div class="clearfix"></div>

		               	<?php 
		               		echo $form->dropDownListGroup($sch, "id_dentist",array(
		                        	'wrapperHtmlOptions' => array('class' => 'col-xs-6',),
		                        	'widgetOptions'=>array(
		                           		'htmlOptions'=>array('required'=>true,'class'=>'srch_dentist')),
		                           	'labelOptions' => array("label" => 'Nha sỹ', 'class' => 'col-xs-4'
		                    )));

							echo $form->dropDownListGroup($sch, "id_service",array(
		                        	'wrapperHtmlOptions' => array('class' => 'col-xs-6',),
		                        	'widgetOptions'=>array(
		                           		'htmlOptions'=>array('required'=>true,'class'=>'srch_service')),
		                           	'labelOptions' => array("label" => 'Dịch vụ', 'class' => 'col-xs-4'
		                    )));

		                    echo $form->textFieldGroup($sch, 'lenght', array(
		                    	'wrapperHtmlOptions' => array('class' => 'col-xs-6',),
		                    	'widgetOptions' => array(
										'htmlOptions'=>array('required'=>true,'value'=>0,'class'=>'svLen')),
		                    	'labelOptions' => array("label" => 'Dịch vụ', 'class' => 'col-xs-4'),
		                    	'append' => 'phút'
		                    ));

		                     echo $form->textAreaGroup($sch,'note',array(
		                     	'wrapperHtmlOptions' => array('class' => 'col-xs-6',),
		                     	'widgetOptions'=>array(
		                     		'htmlOptions'=>array()),
		                        'labelOptions' => array("label" => 'Ghi chú','class' => 'col-xs-4')
		                  	));
		               	?>

		               	<div class="form-group">
		                    <div class="col-xs-10">
		                        <button type="button" class="btn btn_book pull-right col-xs-4 step_info" id="" style="color: white;">Tiếp tục</button>
		                    </div>  
		                </div>
		            </div>

		            <div id="sch_time" class="tab-pane">
		            	<div class="form-group">
		            		<label class="col-xs-4 control-label" for="CsSchedule_date">Ngày</label>
		            		<div class="col-xs-6">
		            			<input required="required" class="form-control" name="CsSchedule[date]" id="CsSchedule_date" type="text">
		            		</div>
		            	</div>

		            	<input type="hidden" name="CsSchedule[start_time]" id="CsSchedule_start_time">
		            	<input type="hidden" name="CsSchedule[end_time]" id="CsSchedule_end_time">
		            	<input type="hidden" name="CsSchedule[id_chair]" id="CsSchedule_id_chair">
		            	<input type="hidden" name="CsSchedule[id_author]" value="<?php echo Yii::app()->user->getState("user_id"); ?>" id="CsSchedule_id_author">
		            	<input type="hidden" name="CsSchedule[id_branch]" id="CsSchedule_id_branch">

		            	<div class='form-group'>
		            		<div class="col-xs-10 col-xs-offset-1 text-center">
		            			<p>Thời gian lịch hẹn: <span id="schTime"></span> phút</p>
		            		</div>
		            		<div class="col-xs-10 col-xs-offset-1" id="showTime">
		            			<div class="col-xs-12 text-center"> Bác sỹ không có lịch làm việc.</div>
							</div>

		                    <div class="col-xs-11" style="margin-top: 15px;">
		                        <button type="button" class="btn btn_book pull-right col-xs-4" id="step_time" style="color: white;">Đặt lịch</button>
		                    </div>
		            	</div>
		            </div>
	            </div>
	            <?php $this->endWidget(); unset($form); ?>
     		</div>
     	</div>
	</div>
</div>

<!-- pop up information -->
<div class="modal" id="sch_info_modal" role="dialog" style="padding-top: 60px;">
    <div class="modal-dialog">
  
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header sHeader">
                <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3 id="info_head" class="modal-title">Thông báo</h3>
            </div>

            <div class="modal-body">
                <p id="sch_content"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
/*********** Danh sách bác sỹ tạo lich **/
	function dentistList(id_branch) {
		$('.srch_dentist').select2({
		    placeholder: {
		    	id: -1,
		    	text: 'Xem tất cả'
		    },
		    //minimumResultsForSearch: Infinity,
		    width: '100%',
		    ajax: {
		        dataType : "json",
		        url      : '<?php echo CController::createUrl('calendar/GetDentistList'); ?>',
		        type     : "post",
		        delay    : 1000,
		        data : function (params) {
					return {
						id_branch: id_branch,
						check_mhg: <?php echo $check_mhg; ?>,
					};
				},
				processResults: function (data, params) {
					return {
						results: data,
					};
				},
				cache: true,
		    },
		});
	}
/*********** Danh sách dịch vụ ***********/
	function servicesList() {
		$('.srch_service').select2({
		   	placeholder: {
		    	id: -1,
		    	text: 'Xem tất cả'
		    },
		    minimumResultsForSearch: Infinity,
		    width: '100%',
		    ajax: {
		        dataType : "json",
		        url      : '<?php echo CController::createUrl('calendar/getServiceList'); ?>',
		        type     : "post",
		        delay    : 1000,
		        data : function (params) {
					return {
						q        : params.term, // search term
						page     : params.page || 1,
						up       : 1,
					};
				},
				processResults: function (data, params) {
					params.page = params.page || 1;

					return {
						results: data,
					};
				},
				cache: true,
		    },
		});
	}
/*********** Lay thoi gian trong theo ngay ***********/
	function showTime(data) {
		ti 	=	$('#showTime');
		opt = '';

		time = data.time;
		date = moment(data.day);
		day = moment(date,'YYYY-MM-DD').format('YYYY-MM-DD');
		
		$.each(time, function (k, v) {
			// v = 08:00:00.08:15:00.8-4-15
			str   =	v.split(".");

			start = moment(str[0],'HH:mm:ss').format('HH:mm:ss');
			end   = moment(str[1],'HH:mm:ss').format('HH:mm:ss');
			str1  = str[2].split("-");
			den   = str1[0];
			chair = str1[1];
			len   = str1[2];
			branch = str1[3];

			if(date.isSame(moment(),'day')){
				if(moment(start,'HH:mm:ss') < moment()){
					return true;
				}
			}

			opt = opt + '<div class="col-xs-3 text-center blockTime" id="time'+k+'" data-branch="'+branch+'" data-start="'+day+' '+start+'" data-end="'+day+' '+end+'" data-chair="'+chair+'">'+moment(start,'HH:mm:ss').format('HH:mm')+'</div>';
		})

		if(!opt)
			opt = '<div class="col-xs-12 text-center"> Bác sỹ không có lịch làm việc.</div>';

		ti.html(opt);
	}
	function getTimeForDent(id_den, time, len, id_ser) {
		$('#schTime').text(len);
		$.ajax({ 
	       	type     :"POST",
	       	url      :"<?php echo Yii::app()->createUrl('itemsSchedule/calendar/getTimeForDent'); ?>",
	       	dataType :'json',
	       	data: {
	          	id_den 	: 	id_den,
	          	id_ser	: 	id_ser,
	          	time 	: 	time,
	          	len 	: 	len,
	       	},
	       	success: function (data) {
	       		if(data.time != 0)
	       			showTime(data[0]);
	       		else 
	       			$('#showTime').html('<div class="col-xs-12 text-center"> Bác sỹ không có lịch làm việc.</div>');
	       	},
	    });
	}
/*********** Thong bao ***********/
	function getNoti(id_schedule, action, author, id_dentist) {
	    $.ajax({
			url     : '<?php echo CController::createUrl('calendar/getNoti'); ?>',
			type    : "post",
			dataType: 'json',
			data    : {
				id_schedule: id_schedule,
				action     : action,
				id_author  : author,
				id_dentist :id_dentist,
			}
	    })
	}
$(function () {
// khoi tao gia tri
	dentistList();
	servicesList();

	$('#CsSchedule_date').datetimepicker({
		format     : 'YYYY-MM-DD',
		defaultDate: moment().format('YYYY-MM-DD'),
		minDate    : moment().format('YYYY-MM-DD'),
	});
// nhom cua nguoi dang nhap
	<?php if (Yii::app()->user->getState('group_id') == 3): ?>
		$('.srch_dentist').html("<option value='"+<?php echo Yii::app()->user->getState('user_id'); ?>+"'>"+'<?php echo Yii::app()->user->getState('name'); ?>'+"</option>");
	<?php endif ?>
// nhom cua nguoi dang nhap
	$('.srch_dentist').change(function (e) {
		id_dentist = $('#CsSchedule_id_dentist').val();

		if(!id_dentist)
			$($('#CsSchedule_id_dentist').data('select2').$container).addClass('errorInp');
		else
			$($('#CsSchedule_id_dentist').data('select2').$container).removeClass('errorInp');
	})
// chon dich vu
	$('.srch_service').change(function (e) {
		sv  = $('.srch_service').select2('data');
        len   = sv[0].len;

        if(!sv)
        	$($('#CsSchedule_id_service').data('select2').$container).addClass('errorInp');
        else 
        	$($('#CsSchedule_id_service').data('select2').$container).removeClass('errorInp');

        $('.svLen').val(len);
	})
// chon thoi gian
	$('#CsSchedule_lenght').change(function(e) {
		len = $('#CsSchedule_lenght').val();

		if(!len)
			$('#CsSchedule_lenght').addClass('errorInp');
		else
			$('#CsSchedule_lenght').removeClass('errorInp');
	});
// change tab customer by tab menu
   $('.nav-tabs a[href="#sch_time"]').on("click", function(e) {
       e.preventDefault();

      	id_dentist     = $('#CsSchedule_id_dentist').val();
      	id_services    = $('#CsSchedule_id_service').val();
      	len            = $('#CsSchedule_lenght').val();

      	if(!id_dentist || !id_services || !len)
      	{
      		$($('#CsSchedule_id_dentist').data('select2').$container).addClass('errorInp');
      		$($('#CsSchedule_id_service').data('select2').$container).addClass('errorInp');
      		$('#CsSchedule_lenght').addClass('errorInp');
      		return false;
      	}

      	$('#CsSchedule_date').val(moment().format('YYYY-MM-DD'));

      	getTimeForDent(id_dentist, moment().format('YYYY-MM-DD'), len, id_services);
	});
// change tab customer by button
	$('.step_info').click(function(e) {
		console.log("cshcu");
		id_dentist     = $('.srch_dentist').val();
      	id_services    = $('.srch_service').val();
      	len            = $('.svLen').val();

      	if(!id_dentist || !id_services || !len)
      	{
      		$($('#CsSchedule_id_dentist').data('select2').$container).addClass('errorInp');
      		$($('#CsSchedule_id_service').data('select2').$container).addClass('errorInp');
      		$('#CsSchedule_lenght').addClass('errorInp');
      		return false;
      	}

      	$('#CsSchedule_date').val(moment().format('YYYY-MM-DD'));

      	$('.nav-tabs a[href="#sch_time"]').tab("show");
      	getTimeForDent(id_dentist, moment().format('YYYY-MM-DD'), len, id_services);
	});
// change start_time
	$('#CsSchedule_date').on('dp.change',function(){
	  	id_den 	= $('#CsSchedule_id_dentist').val();
	  	id_ser 	= $('#CsSchedule_id_service').val();
	  	date 	= $('#CsSchedule_date').val();
	  	len     = $('#CsSchedule_lenght').val();
	  
	  	getTimeForDent(id_den, date, len, id_ser);
	})
// chon thoi gian
	$('#showTime').on('click','.blockTime',function(e){
		id = $(this).attr('id');
		$('.blockTime').css({
			background: 'white',
			color     : 'black',
		})
		$('#'+id).css({
			background: '#19a8e0',
			color     : 'white',
		})

		start  = $(this).data('start');
		end    = $(this).data('end');
		chair  = $(this).data('chair');
		branch = $(this).data('branch');

		$('#CsSchedule_start_time').val(start);
		$('#CsSchedule_end_time').val(end);
		$('#CsSchedule_id_chair').val(chair);
		$('#CsSchedule_id_branch').val(branch);

	})
// dat lich hen
	$('#step_time').click(function(e) {
		var formData   = new FormData($("#frm-create-sch-cus")[0]);
         
        if (!formData.checkValidity || formData.checkValidity()) 
        {
            $.ajax({ 
				type    : "POST",
				url     : "<?php echo CController::createUrl('calendar/addNextSch')?>",
				data    : formData,
				dataType: "json",
				success: function(data){
					$('#CalendarModal').modal("hide");
					//$('#sch_info_modal').modal("show");

					if(data.status == 1){	// thanh cong
						id_schedule = data.success.id;
						action      = "add";
						author      = $('#CsSchedule_id_author').val();
						id_dentist  = data.success.id_dentist;

						$('#sch_content').text("Đặt lịch thành công!");

						getNoti(id_schedule, action, author, id_dentist);
					}
					else{
						$('#sch_content').text(data['error-message']);
						alert(data['error-message']);
					}
				},
				cache      : false,
				contentType: false,
				processData: false
		    });
        }
    })
})
</script>;