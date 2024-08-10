<script type="text/javascript">

function isValidEmailAddress(emailAddress){var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;return pattern.test(emailAddress);};
function isValidPhoneNumber(phoneNumber){var pattern = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;return pattern.test(phoneNumber);}

var baseUrl = $('#baseUrl').val();
function addChair(){
	
	$.ajax({ 
		type    : "post",
		url: baseUrl+'/itemsSetting/ChairCalendar/AddChair',
		success: function(data){
			//alert(data);
			$('.content_add_chair').html(data);	
			$("#modalAdd").modal({backdrop: true});
			//return false;
		},
		error: function(data) {
			alert("Error occured.Please try again!");
		},
	});
}
function loadResources(){
	    
	var baseUrl = $('#baseUrl').val();
	var dow_search 	= $('#dow_search').val();
	var branch_search = $('#branch_search').val();
	if(dow_search == ""){
		return false;
	}
	$('.cal_loading').fadeIn('fast');
	
	$.ajax({
		type    : "post",
		dataType: 'json',
		url     : baseUrl+'/itemsSetting/ChairCalendar/ShowChair',
		data    : {
			dow_search	: dow_search,
			branch_search : branch_search,
		},
		success: function(data){
			if(data == -1){ 
				//loadResources(); 
				$('#content_calender').fullCalendar('destroy');
				$('#content_calender').html('<h1>Không có dữ liệu !!!</h1>');
				return false;
			}
			$('#content_calender').html('');
			$('#content_calender').fullCalendar('destroy');
			loadCalendar(data);
			//showEvents(id_dentist,id_patient,id_branch,id_chair,type);
		},
		error: function(data){
			loadResources();
		}
	});
	setTimeout(function(){
		showEvents(dow_search ,branch_search);
	}, 500);
}
function showEvents(dow_search ,branch_search){
	$('.cal-loading').fadeIn('fast');
	//alert('aa');
	var baseUrl = $('#baseUrl').val();
	$.ajax({
		type: "post", 
		dataType: 'json',
		url: baseUrl+'/itemsSetting/ChairCalendar/ShowEvents',
		data: {
				dow_search  : dow_search,
				branch_search  : branch_search
		},
		success: function(data) {
			/*
			$('#content_calender').fullCalendar( 'removeEvents', function (e) {
				return e.className != 'breakTime';
			});*/ 
			if(data == -1){ 
				alert('Sai');
				return false;
			}else{
				$('#content_calender').fullCalendar('addEventSource',data);
				$('.cal-loading').fadeOut('fast');
				$('.fc-short').removeClass('fc-short');
			}
		},
	});
}

function loadCalendar(re='') {
	var addRole = '<?php echo $addRole; ?>';
	var upRole = '<?php echo $upRole; ?>';
	var delRole = '<?php echo $delRole; ?>';

	var height_calendar = $('#height_calendar').val(); 
	var baseUrl = $('#baseUrl').val();
	$('#content_calender').fullCalendar({
		schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',

		allDaySlot   : false,
		titleFormat  : 'DD MMMM - YYYY',
		contentHeight: 510,//truyền height
		nowIndicator : true,
		aspectRatio  : 10,
		
		minTime: '08:00',
		maxTime: '20:00',
		/*scrollTime: current,*/ 
		
		header: {
			left  : '',
			center: '',
			right : '',
		},

		defaultView: 'agendaDay',
		views: {
			day:  {
				columnFormat   : 'dddd - DD/MM',
				titleFormat    : 'dddd, DD/MM/YYYY',
				slotLabelFormat: 'HH:mm',
				slotDuration   : "00:10:00",
				//snapDuration   : '00:05:00',
			}
		},

		editable    : true,
		selectable  : true,
		selectHelper: true,
		resources        : re,
		eventOverlap: false,
		//chỉnh width
		viewRender: function( view, element ) {
			$(".fc-view-container").css('min-width',$('th.fc-resource-cell').length*110);
			width = ($('.fc-resource-cell').outerWidth()) ? $('.fc-resource-cell').outerWidth() : $('.fc-day-header').outerWidth();
			$('.text-time').text("");
		},
		eventRender: function(event, element) { 
			
		},
		
		/*********** Sự kiện khi click chuột ***********/
		eventClick: function(calEvent, jsEvent, view) {
			//alert(calEvent.id);
			//updateChair(calEvent.id); 
			//alert(calEvent.id);
			$.ajax({ 
				type    : "post",
				url: baseUrl+'/itemsSetting/ChairCalendar/UpdateChair',
				data    : {
					id	: calEvent.id,
				},
				success: function(data){
					//alert(data);
					$('.content_update_chair').html(data);	
					$("#modalUpdate").modal({backdrop: true});
					if(upRole == 0){
						$("#updateChairButton").hide();
					}
					if(delRole == 0){
						$("#deleteChairButton").hide();
					}
					//return false;
				},
				error: function(data) {
					alert("Error occured.Please try again!");
				},
			});
		},

		/* Sự kiện kéo thả 
		*  thay đổi thời gian lịch 
		*  thay đổi nha sỹ
		*  -> kiem tra thoi gian lam viec cua nha sy + lich hen trung
		*/
		eventDrop: function(event, delta, revertFunc, jsEvent, ui, view ) {
			if (upRole == 0) {
				revertFunc();
				return;
			}
			//alert(event.id_chair);
			var dow 	= $('#dow_search').val();
			var branch = $('#branch_search').val();
			var start = moment(event.start,"HH:mm:ss").format();
			var end = moment(event.end,"HH:mm:ss").format();
			mang1 = start.split("T");
			mang2 = end.split("T");
			//alert(event.id_dentist);
			//alert(mang1[1]);
			//alert(mang2[1]);
			
			$.ajax({ 
				type    : "post",
				url: baseUrl+'/itemsSetting/ChairCalendar/UpdateTimeChair2',
				data    : {
					id	: event.id,
					id_chair: event.resourceId,
					start : mang1[1],
					end	: mang2[1],
					dow : dow,
					branch : branch,
					id_dentist : event.id_dentist,
				},
				success: function(data){
					if(data==0){
						revertFunc();
					}else if(data == -1){
						alert("Bác sĩ này hiện đã có lịch ở ghế khác ,xin chọn lại bác sĩ !");
						revertFunc();
					}else{ 
						alert("Thành công !!!");
					}
				},
				error: function(data) {
					alert("Error occured.Please try again!");
				},
			});
		},
		/*********** Thay đổi kích thước sự kiện ***********/
		eventResize: function( event, delta, revertFunc, jsEvent, ui, view ) {
			if (upRole == 0) {
				revertFunc();
				return;
			}

			var dow 	= $('#dow_search').val();
			var branch = $('#branch_search').val();
			
		    var start = moment(event.start,"HH:mm:ss").format();
			var end = moment(event.end,"HH:mm:ss").format();
			
			mang1 = start.split("T");
			mang2 = end.split("T");
			
			$.ajax({ 
				type    : "post",
				url: baseUrl+'/itemsSetting/ChairCalendar/UpdateTimeChair',
				data    : {
					id	: event.id,
					start : mang1[1],
					end	: mang2[1],
					dow : dow,
					branch : branch,
					id_dentist : event.id_dentist,
				},
				success: function(data){
					if(data == 0){
						revertFunc();
					}else if(data == -1){
						alert("Bác sĩ này hiện đã có lịch ở ghế khác ,xin chọn lại bác sĩ !");
						revertFunc();
					}else{
						alert("Thành công !!!");
					}
				},
				error: function(data) {
					alert("Error occured.Please try again!");
				},
			});
			/*
			$('.btn_close').click(function (e) {
				e.preventDefault();
				revertFunc();//trả về vị trí ban đầu
			})*/

		},
		/*********** Tạo sự kiện mới - nhấp chuột vào thời gian trống ***********/
		select: function(start, end, jsEvent, view, resource) {
			if (addRole == 0) {
				return;
			}
			var start = moment(start,"HH:mm:ss").format();
			var end = moment(end,"HH:mm:ss").format();
			var dow_search_save = $("#dow_search").val();
			var branch_search_save = $("#branch_search").val();
			mang1 = start.split("T");
			mang2 = end.split("T");
			if($("#dow_search").val() == ""){
				alert("Xin chọn thứ !!!"); 
				
				return false;
			}
			//alert(dow_search_save);
			
			$.ajax({ 
				type    : "post",
				url: baseUrl+'/itemsSetting/ChairCalendar/SaveChair',
				data    : {
					id_chair	: resource.id,
					dow_search_save	: dow_search_save,
					branch_search_save	: branch_search_save,
					start	: mang1[1],
					end	: mang2[1],
				},
				success: function(data){
					//alert(data);
					if(data != 0){
						$('.content_save_chair').html(data);	
						$("#modalSave").modal({backdrop: true});
					}else{
						alert("Error occured.Please try again!");
					}
					
					//return false;
				},
				error: function(data) {
					alert("Error occured.Please try again!");
				},
			});
			/*
			var start_time = moment(start).format('YYYY-MM-DD HH:mm:ss');

			if($('.popover').length) {
				$('.popover').popover('hide');
			}*/
		}

	});
	//show dữ liệu
}
$( document ).ready(function(){
	
});


</script>
