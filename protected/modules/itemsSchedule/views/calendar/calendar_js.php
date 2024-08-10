<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/fullcalendar/fullcalendar.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/fullcalendar/scheduler.js" type="text/javascript"></script>
<script src='<?php echo Yii::app()->request->baseUrl; ?>/js/fullcalendar/locale/vi.js'></script>

<?php $baseUrl= Yii::app()->getBaseUrl(); ?>
<input type="hidden" id="idUserLog" value="<?php echo Yii::app()->user->getState('user_id'); ?>">
<input type="hidden" id="LayoutCalendar" value="1">
<style type="text/css">
	.changeW {
	    margin-left: -250px;
	    border-top: 1px solid rgb(102, 175, 233) !important;
	    width: 800px !important;
	}
	span.copySch {position: absolute; right: 5px; top: 160px; cursor: pointer; padding: 5px; border: 1px solid #999695; border-radius: 100%; color: #999695;}
	span.copySch:hover {color: #383535;}
</style>

<script>
/*********** const ***********/
	const TYPE_RESOURCE = {
		dentist: 1,
		chair  : 2,
	}

	var paramsShowEvent = {
		start_time   : '',
		end_time     : '',
		id_branch    : '',
		id_chair     : '',
		id_dentist   : '',
		id_customer  : '',
		type_resource: '',
		id_author    : ''
	}

/*********** get params defauls ***********/
	function getParamsDefaultCalendar(view) {
		var id_branch     = $("#id_branch").val();
		var type_resource = $('#sr_val').val();
		var id_resource   = $('#at_srch').val();

		var start_time  = moment(view.start).format('YYYY-MM-DD');
		var end_time    = moment(view.end).subtract(1, 'days').format('YYYY-MM-DD');

		var id_author = $('#srch_author').val();

		var id_dentist  = '';
		var id_chair    = '';
		if (type_resource == TYPE_RESOURCE.dentist) {
			id_dentist = id_resource;
		} else {
			id_chair   = id_resource;
		}

		return {
			'id_branch'    : id_branch,
			'type_resource': type_resource,
			'id_dentist'   : id_dentist,
			'id_chair'     : id_chair,
			'start_time'   : start_time,
			'end_time'     : end_time,
			'id_author'    : id_author
		}
	}

/*********** button right ***********/
	function btnRight() {
		$('.fc-right').addClass('col-md-5');
		$('.fc-left').addClass('col-md-4');
		right 	= 	'<div class="side-right pull-right padding-right-15"><select name="cal-view" id="cal-view" class="form-control"><option value="1">Ngày</option><option value="2">Tuần</option><option value="3">Tháng</option></select></div>';
		right 	+= 	'<div class="side-right pull-right"><select name="" id="srch_author" class="form-control"></select></div>';
		$('.fc-right').append(right);
	}

/*********** button center ***********/
	function btnCenter() {
		$('.fc-center h2').addClass('col-md-12');
		$('.fc-center h2').attr('id','cal_date');
		datepicker = '<input type="text" style="height: 0px; width: 0; border: 0px;" name="date" id="date">';

		$('.fc-center').append(datepicker);
		$('#date').datepicker({dateFormat: 'dd-mm-yy',numberOfMonths: 2,showButtonPanel: true});

		$('#cal_date').on('mouseover click',function(){
			$('#date').datepicker("show");
		});
		$('#cal_date').mouseleave(function(){
			var hover_date = $('.ui-datepicker').is(':hover');
			if(hover_date == false) {
				$("#date").datepicker('hide').blur();
			}
		})
		$('.ui-datepicker').mouseleave(function(){
			$("#date").datepicker('hide').blur();
		})
		$('#date').change(function(){
			var date = $('#date').datepicker('getDate');
			$('#calendar').fullCalendar('gotoDate',date);
		})
	}

/*********** change view ***********/
	function changeViews(views,id_source, type) {
		if(views == 1){ // ngày
			$('#calendar').fullCalendar('changeView','agendaDay');
		}
		if(views == 2){ //tuần
			if(id_source){
				$('#calendar').fullCalendar('changeView','agendaWeek');
				$('#cal-view').val(2);
			}
			else
				$('#calendar').fullCalendar('changeView','timelineOneWeek');
		}
		if(views == 3){ // tháng
			$('#calendar').fullCalendar('changeView','month');
		}
	}

/*********** lấy thông tin lịch hẹn và hiển thị trên lịch ***********/
	function showEvents(paramsShowEvent){
	  	return $.ajax({
			type    : "post",
			dataType: 'json',
			url     : '<?php echo CController::createUrl('calendar/showEvents'); ?>',
			data    : paramsShowEvent,
			success: function(data) {
				$('.cal-loading').fadeOut('fast');
				$('#calendar').fullCalendar('removeEvents');
				$('#calendar').fullCalendar('addEventSource',data);
			},
	    });
	}

/*********** Thời gian ko làm việc của bác sỹ ***********/
	function breakTime(view, id_resource, type) {
		$.ajax({
			type    : "post",
			dataType: 'json',
			url     : '<?php echo Yii::app()->getBaseUrl(); ?>/time.json',
			success: function (data) {
				if(type == 2) {		// ghe
					getBreakChair(data.chair, view, id_resource);
				}
				else if(type == 1) {
					getBreakTime(data.dentist, view, id_resource);
				}
			}
		})
	}
/*********** Thời gian ko làm việc của ghế ***********/
	function getBreakChair(data, view, id_resource) {
		time  = [];
		br    = $('#id_branch').val();
		today = $('#calendar').fullCalendar('getDate');

		$.each(data, function (v,k) {
			id_chair = k['id_chair'];
			if(view == 'agendaDay' && !id_resource && br == k['id_branch']) {
				day   = today.format('YYYY-MM-DD');
				dowN  = today.format('d');

				$.each(k.time, function (ke, va) {
					ti  = va.split('-')
					dow = ti[0];
					st  = ti[1];
					en  = ti[2];
					if(dowN == dow){
						time.push({
							resourceId: id_chair,
							id        : 'breakTime',
							className : 'breakTime',
							start     : day + ' ' + st,
							end       : day + ' ' + en,
							rendering : "background",
						});
					}
				})
			}
			else if(view == 'agendaWeek' && id_resource && br == k['id_branch']) {
				if(id_chair == id_resource ){
					day  = today.startOf('isoWeek');
					nDay = 1;
					date  = [];
					while(nDay <= 6) {
						date[nDay] = day.format('YYYY-MM-DD');
						day.add(1,'day');
						nDay ++;
					}


					$.each(k.time, function (ke, va) {
						ti  = va.split('-');
						dow = ti[0];
						st  = ti[1];
						en  = ti[2];

						if(dow == 0) {
							day  = today.endOf('isoWeek');
							time.push({
								resourceId: id_chair,
								id        : 'breakTime',
								className : 'breakTime',
								start     : day.format('YYYY-MM-DD') + ' ' + st,
								end       : day.format('YYYY-MM-DD') + ' ' + en,
								rendering : "background",
							});
						}
						else {
							time.push({
								resourceId: id_chair,
								id        : 'breakTime',
								className : 'breakTime',
								start     : date[dow] + ' ' + st,
								end       : date[dow] + ' ' + en,
								rendering : "background",
							});
						}
					})
				}
			}
		})
		if(time.length > 0) {
			setTimeout(function(){
				$('#calendar').fullCalendar('addEventSource',time);
			}, 500);
		}
	}
/*********** Thời gian ko làm việc ***********/
	function getBreakTime(data, view, id_resource) {
		time  = [];
		br    = $('#id_branch').val();
		today = $('#calendar').fullCalendar('getDate');
		today = moment(today);

		$.each(data, function (v,k) {
			id_den = k['id_den'];
			if(view == 'agendaDay' && !id_resource && br == k['id_branch']) {
				day   = today.format('YYYY-MM-DD');
				dowN  = today.format('d');

				$.each(k.time, function (ke, va) {
					ti  = va.split('-')
					dow = ti[0];
					st  = ti[1];
					en  = ti[2];
					if(dowN == dow){
						time.push({
							resourceId: id_den,
							id        : 'breakTime',
							className : 'breakTime',
							start     : day + ' ' + st,
							end       : day + ' ' + en,
							rendering : "background",
						});
					}
				})
			}
			if(view == 'agendaWeek' && id_resource && br == k['id_branch']) {
				if(id_den == id_resource ){
					day  = today.startOf('isoWeek');
					nDay = 1;
					date  = [];
					while(nDay <= 6) {
						date[nDay] = day.format('YYYY-MM-DD');
						day.add(1,'day');
						nDay ++;
					}

					$.each(k.time, function (ke, va) {
						ti  = va.split('-');
						dow = ti[0];
						st  = ti[1];
						en  = ti[2];

						if(dow == 0) {
							day  = today.endOf('isoWeek');
							time.push({
								resourceId: id_den,
								id        : 'breakTime',
								className : 'breakTime',
								start     : day.format('YYYY-MM-DD') + ' ' + st,
								end       : day.format('YYYY-MM-DD') + ' ' + en,
								rendering : "background",
							});
						}
						else {
							time.push({
								resourceId: id_den,
								id        : 'breakTime',
								className : 'breakTime',
								start     : date[dow] + ' ' + st,
								end       : date[dow] + ' ' + en,
								rendering : "background",
							});
						}
					})
				}
			}
		})
		if(time.length > 0) {
			setTimeout(function(){
				$('#calendar').fullCalendar('addEventSource',time);
			}, 100);
		}
	}
/*********** Thời gian nghi phep cua bac sy ***********/
	function dentistTimeOff(sDate, eDate, id_branch, id_resource, type) {
		$.ajax({
			type    : "post",
			dataType: 'json',
			url     : '<?php echo CController::createUrl('calendar/getDentistTimeOff'); ?>',
			data    : {
				sDate      : sDate,
				eDate      : eDate,
				id_branch  : id_branch,
				type       : type,
				id_resource: id_resource,
			},
			success: function (data) {
				$('#calendar').fullCalendar('addEventSource',data);
			}
		})
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
				id_author  : '<?php echo Yii::app()->user->getState('user_id'); ?>',
				id_dentist :id_dentist,
			}
	    })
	}
/*********** Hien thi lich moi ***********/
	function getNewSch(data) {

		if(typeof data == 'string') {
			dt          = $.parseJSON(data);
			id          = dt['id'];
			id_dentist  = dt['id_dentist'];
			id_chair    = dt['id_chair'];
			active      = dt['status_active'];
			start_time = dt['start_time'];
		}
		else if(typeof data == 'object') {
			id          = data['id'];
			id_dentist  = data['id_dentist'];
			id_chair    = data['id_chair'];
			active      = data['status_active'];
			start_time = data['start_time'];
		} else { return; }

		if(active < 0 && id) {
			$('#calendar').fullCalendar( 'removeEvents', id);
			return;
		}

		var type        = $('#sr_val').val();
		var id_resource = $('#at_srch').val();

		var start = $('#calendar').fullCalendar('getView').start;
		var end   = $('#calendar').fullCalendar('getView').end;

		if (!moment(start_time).isBetween(start, end, null, '[]')) {return;}

		if (id_resource) {
			if (type == TYPE_RESOURCE.dentist && id_resource != id_dentist) {return;}
			if (type == TYPE_RESOURCE.chair && id_resource != id_chair) {return;}
		}

		if (!moment(start_time).isSame(moment(),'day')) {
			return;
		}
		$.ajax({
			type    : "post",
			dataType: 'json',
			url     : '<?php echo CController::createUrl('calendar/getNewSch'); ?>',
			data    : {
				sch :data,
				type:type,
			},
			success: function(data) {
				console.log("newsch");
				$('#calendar').fullCalendar( 'removeEvents', data.id);
				$('#calendar').fullCalendar('renderEvent',data,true);

			},
	  });
	}
/*********** cap nhat lich hen ***********/
	function updateDrop(id_dentist, start_time, end_time, id_schedule, type, id_chair) {
		return $.ajax({
			type    :"POST",
			url     :"<?php echo CController::createUrl('calendar/eventDrop'); ?>",
			dataType:'json',
			data    : {
				id_dentist: id_dentist,
				start   : start_time,
				end     : end_time,
				id      : id_schedule,
				type    : type,
				id_chair: id_chair,
	        },
	    });
	}
/*********** cap nhat lich hen reschedule ***********/
	function reSchedule(id_customer, id_dentist, id_author, id_branch, id_chair, id_service, lenght, start_time, end_time, type) {
		return $.ajax({
			type    :"POST",
			url     :"<?php echo CController::createUrl('calendar/reSchedule'); ?>",
			dataType:'json',
			data    : {
				id_customer:  id_customer,
				id_dentist :  id_dentist,
				id_author  :  id_author,
				id_branch  :  id_branch,
				id_chair   :  id_chair,
				id_service :  id_service,
				lenght     :  lenght,
				start_time :  start_time,
				end_time   :  end_time,
				type       :  type,
	        },
	    });
	}
/*********** Danh sách nhan vien theo co so ***********/
	function userList(id_branch) {
		$('#srch_author').select2({
		    placeholder: {
		    	id: -1,
		    	text: 'Người tạo'
		    },
		    dropdownAutoWidth : true,
    		width: 'auto',
		    allowClear: true,
		    ajax: {
		        dataType : "json",
		        url      : '<?php echo CController::createUrl('calendar/getUserList'); ?>',
		        type     : "post",
		        delay    : 1000,
		        data : function (params) {
					return {
						q        : params.term, // search term
						page     : params.page || 1,
						id_branch: id_branch,
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
/*********** Danh sách bác sỹ ***********/
	function dentistList(id_branch,role) {
		if(!id_branch){
			id_branch = 1;
		}
		if(role){
			role = 1;
		}
		if(role == 0) {
			$('.search').select2({
			    placeholder: {
			    	id: -1,
			    	text: 'Xem tất cả'
			    },
			    width: '100%',
			    minimumResultsForSearch: Infinity,
			});
			return;
		}
		$('.search').select2({
		    placeholder: {
		    	id: -1,
		    	text: 'Xem tất cả'
		    },
		    width: '100%',
		    allowClear: true,
		    ajax: {
		        dataType : "json",
		        url      : '<?php echo CController::createUrl('calendar/getDentistList'); ?>',
		        type     : "post",
		        delay    : 1000,
		        data : function (params) {
					return {
						q: params.term, // search term
						page: params.page || 1,
						id_branch: id_branch,
					};
				},
				processResults: function (data, params) {
					params.page = params.page || 1;

					return {
						results: data,
						/*pagination: {
							more:true
						}*/
					};
				},
				cache: true,
		    },
		});
	}
/*********** Danh sách bác sỹ tạo lich **/
	function dentistListModal(id_branch, chair_type) {
		$('.sch_dentist').select2({
		    placeholder: {
		    	id: -1,
		    	text: 'Xem tất cả'
		    },
		    width: '100%',
		    ajax: {
		        dataType : "json",
		        url      : '<?php echo CController::createUrl('calendar/getDentistList'); ?>',
		        type     : "post",
		        delay    : 1000,
		        data : function (params) {
					return {
						q: params.term, // search term
						page: params.page || 1,
						id_branch: id_branch,
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
/*********** Thong tin bac sy va ghe ***********/
	function dentistChair(id_branch, id_chair, start_time, id_dentist) {
		time = moment(start_time).format('HH:mm:ss');
		dow  = moment(start_time).format('d');
	 	return $.ajax({
	     	type 		: "POST",
	        url 		: "<?php echo CController::createUrl('calendar/getDentistAndChair'); ?>",
	        dataType 	: 'json',
	        data 		: {
	        	id_branch : id_branch,
	        	id_chair  : id_chair,
	        	time      : time,
	        	dow       : dow,
	        	id_dentist: id_dentist,
	        },
	    });
	}
/*********** Danh sách dịch vụ ***********/
	function servicesList(id_dentist, chair_type, data, up, id_service) {
		if(id_service == 0) {
			$('.sch_service').select2({
				language: 'vi',
			   	placeholder: {
			    	id: -1,
			    	text: 'Xem tất cả'
			    },
			    width: '100%',
			    data: [{'id':0,'title':'Không làm việc'}],
			});
			return;
		}

		$('.sch_service').select2({
		   	placeholder: {
		    	id: -1,
		    	text: 'Xem tất cả'
		    },
		    width: '100%',
		    ajax: {
		        dataType : "json",
		        url      : '<?php echo CController::createUrl('calendar/getServiceList'); ?>',
		        type     : "post",
		        delay    : 1000,
		        data : function (params) {
					return {
						q         : params.term, // search term
						page      : params.page || 1,
						id_dentist: id_dentist,
						up        : up,
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
/*********** Danh sách ghế khám ***********/
	function chairList(id_branch) {
		$('.search').select2({
		    placeholder: {
		    	id: -1,
		    	text: 'Xem tất cả'
		    },
		    width: '100%',
		    allowClear: true,
		    ajax: {
		        dataType : "json",
		        url      : '<?php echo CController::createUrl('calendar/getChairList'); ?>',
		        type     : "post",
		        delay    : 1000,
		        data : function (params) {
					return {
						q: params.term, // search term
						page: params.page || 1,
						id_branch: id_branch,
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
/*********** Kiểm tra thời gian lich hen ***********/
	function checkTimeAjax(id_dentist, start_time, end_time, id_schedule, status_sch,id_customer, id_chair) {
	   $('.load-at').fadeIn('fast');
	   return $.ajax({
			type    : "POST",
			url     : "<?php echo CController::createUrl('calendar/checkTime'); ?>",
			dataType: 'json',
	        data   : {
				id_dentist : id_dentist,
				start      : start_time,
				end        : end_time,
				id_schedule: id_schedule,
				id_chair   : id_chair,
				status     : status_sch,
				id_customer: id_customer
	        },
	    });
	}

	function checkTime(data, acceptChange) {
	   	$('.load-at').fadeOut('fast');
	   	$('#step-1').addClass('unbtn');
	   	$('.up-sch').addClass('unbtn');

	   	$('#info_head').text('THÔNG BÁO!');
	   	/*********** Dinh dang thoi gian khong dung ***********/
	   		if(data.status == -1) {
	    		$('.group_time').addClass('errors');
	      		$('.chkT').val(0);
	   		}
	   	/*********** Nha sy khong lam viec ***********/
	   		else if(data.status == -2 && acceptChange == 0) {
	      		$('.group_time').addClass('errors');
	      		$($('.sch_dentist').data('select2').$container).addClass('errors');
	      		$('.chkT').val(0);
	      		$('#info_content').text('Bác sỹ không có ca làm việc!');
		  		$("#info").modal();
		  		return;
	   		}
	   	/*********** Lich hen trung ***********/
	   		else if(data.status == -3) {
	      		$('.group_time').addClass('errors');
	      		$('.chkT').val(0);
	      		$('#info_content').text('Có lịch hẹn trong khoảng thời gian này!');
		  		$("#info").modal();
	   		}
	   	/*********** Lich hen trung ***********/
	   		else if(data.status == -4) {
	      		$('.group_time').addClass('errors');
	      		$('.chkT').val(0);
	      		$('#info_content').text('Bác sỹ đang trong thời gian nghỉ phép!');
		  		$("#info").modal();
	   		}
	   	/*********** Co lich hen chua hoan tat trong ngay ***********/
	   		else if(data.status == -5) {
	      		$('.group_time').addClass('errors');
	      		$('.chkT').val(0);
	      		$('#info_content').text('Có lịch hẹn đang chờ hoặc chưa hoàn tất!');
		  		$("#info").modal();
	   		}
	   	/*********** Co the dat lich hen ***********/
	   		else if(data.status == 1 || acceptChange == 1) {
	      		$('#step-1').removeClass('unbtn');
	      		$('.up-sch').removeClass('unbtn');
	      		$('.branch').val($('#id_branch').val());

	      		if (acceptChange == 0) {
					var schIdBranch = (typeof data.data['id_branch'] != 'undefined') ? data.data['id_branch'] : $('#id_branch').val();
					var schIDChair = data.data['id_chair']

					if (!schIDChair) {
						var defaultType = $('#sr_val').val();
						if (defaultType == 2) {
							schIDChair = $('#CsSchedule_id_chair').val()
						}
					}

	      			$('.branch').val(schIdBranch);
	      			$('.chair').val(data.data['id_chair']);
	      		}

	      		$('.chkT').val(1);
	      		$('.group_time').removeClass('errors');

	      		if(data.codeNumberRemain){
	      			$('#Customer_code_number_remain').attr('title', data.codeNumberRemain);
	      			$('#Customer_code_number_remain').attr('data-original-title', data.codeNumberRemain);
	      			$('#Customer_code_number').val(data.codeNumberExp);
	      		}
	   		}
	}
/*********** Delete Schedule ***********/
	function delSch(id) {
	   return  $.ajax({
	      type       :  "POST",
	      url        :  "<?php echo CController::createUrl('calendar/delSch')?>",
	      data       :  {id_sch:id},
	      dataType   :  'json',
	   });
	}
	function delEv(id) {
		$('#cf_content').text('Bạn có muốn xóa lịch hẹn này không?');
		$('.cf_submit').addClass('cfDel');

		$('#confirm').modal();
		$('.cfDel').click(function (e) {
			$.when(delSch(id)).done(function (data) {
				$('#confirm').modal('hide');
				if(data == 0) {
	               $('#info_content').text('Có lỗi xảy ra! Xin vui lòng thử lại sau!');
	            }
	            else if(data == -1) {
	               $('#info_content').text('Dữ liệu không hợp lệ!');
	            }
	            else if(data == 1) {
	               $('#info_content').text('Lịch hẹn đã xóa thành công!');
	               event = $('#calendar').fullCalendar( 'clientEvents', id );

	               $('#calendar').fullCalendar( 'removeEvents', id );
	               getNoti(id,'update',userLog, event[0].id_dentist);
	            }
	            $('#update_sch_modal').modal("hide");
	            $("#info").modal();
			})
		})
	}
/*********** giao dien thong tin lich hen khong lam viec cua bac sy */
	function noWorkContent(calEvent, grId){
		var ev = [];
		var del= '';
		if(grId == 1 || grId == 2) {
			del = '<button type="button" style="border-radius: 4px;" class="btn delSch" onclick="delEv('+calEvent.id+')" id="">Xóa lịch</button>';
		}

		noti = '<a target="_blank" href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsUsers/Notifications/View?code='+calEvent.code_schedule+'">'+(calEvent.setBy?calEvent.setBy:"Khách hàng")+'</a>';

		var title = '<div id="title"><span id="pop-date">'+moment(calEvent.start).format('dddd, DD/MM/YYYY')+'</span><span style="float:right">'+moment(calEvent.start).format('hh:mm') + ' - ' + moment(calEvent.end).format('hh:mm')+'</span></div>';

		var content = 	'<div id="pop-content">' +
					'<table class="table" id="pop-tb1">' +
						'<tbody>' +
							'<tr>' +
								'<td class="text-right">Bác sỹ:</td><td>'+ (calEvent.dentist ? calEvent.dentist:'') +'</td>' +
							'</tr>' +
							'<tr>' +
								'<td class="text-right">Thời gian:</td><td>'+(calEvent.time?calEvent.time:'') +' phút </td>' +
							'</tr>' +
							'<tr>' +
								'<td class="text-right">Đặt bởi:</td><td>'+noti+'</td>' +
							'</tr>' +
							'<tr>' +
								'<td class="text-right">Trạng thái:</td><td>'+(calEvent.status_text?calEvent.status_text:'')+'</td>' +
							'</tr>' +
						'</tbody>' +
					'</table>' +
				'</div>' +
				'<div id="pop-footer">' +
					del+
					'<button type="" class="btn btn_view edit_sch pull-right"><img src="<?php echo $baseUrl; ?>/images/icon_sb_left/edit-def.png" alt=""> Chỉnh sửa</button>'+
				'</div>';

		ev = [title, content];
		return ev;
	}
/*********** giao dien thong tin lich hen cua khach hang ***********/
	function eventContent(calEvent){
		var ev = [];
		var link = "<?php echo $baseUrl; ?>/itemsCustomers/Accounts/admin?code_number="+calEvent.code_pt;

		if(calEvent.id_quotation) {		// xem báo giá
			quote_at = 'view_quote';
		}
		else {		// tạo báo giá
			quote_at = 'quote';
		}
		quote_btn = '';

		<?php if ($vewQuote == 1): ?>
			//quote_btn = '<button type="" class="btn btn_view pull-right '+quote_at+'"> Báo giá </button>';
			quote_btn = '<a class="btn btn_view" class="actionMedicalHistory" target="_blank" href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsSales/quotations/View?code_number='+calEvent.code_pt+'">Báo giá</a>';
		<?php endif ?>

		invoice_btn = '';

		noti = '<a target="_blank" href="<?php echo Yii::app()->getBaseUrl(); ?>/itemsUsers/Notifications/View?code='+calEvent.code_schedule+'">'+(calEvent.setBy?calEvent.setBy:"Khách hàng")+'</a>';

		<?php if ($viewInvoice == 1): ?>
				//invoice_btn = "<a href='"+"<?php //echo $baseUrl; ?>/itemsSales/invoices/View?id="+calEvent.id_invoice+"'  class='btn btn_view pull-right'>Hóa đơn</a>";
			invoice_btn = '<a target="_blank" class="btn btn_view" href="<?php //echo Yii::app()->getBaseUrl(); ?> /itemsSales/invoices/View?code_number='+calEvent.code_pt+'">Hóa đơn</a>';
		<?php endif ?>

		update_btn = "<td class='text-right' style='width: 20%; padding-right: 15px;'><a href='"+link+"' target='_blank' style='color: #93c541; font-weight: bold; font-size:1.2em;'><img style='width: 23px;' src='<?php echo $baseUrl; ?>/images/icon_sb_left/Hoso.png'></a></td>";
		if(!calEvent.code_pt){
			sale = '';
			update_btn = '';
		}

		var title = '<div id="title"><span id="pop-date">'+moment(calEvent.start).format('dddd, DD/MM/YYYY')+'</span><span style="float:right">'+moment(calEvent.start).format('hh:mm') + ' - ' + moment(calEvent.end).format('hh:mm')+'</span></div>';

		var content = 	'<div id="pop-content" class="evSch">' +
						'<table class="table" id="pop-tb2">' +
							'<tbody>' +
								'<tr>' +
									'<td>'+(calEvent.patient?calEvent.patient:'')+'</td>' + update_btn +
								'</tr>' +
								'<tr>' +
									'<td colspan="2">Mã ID:'+(calEvent.code_pt?calEvent.code_pt:'')+'</td>' +
								'</tr>' +
								'<tr>' +
									'<td>'+(calEvent.phone?calEvent.phone:'')+'</td>' +
									"<td class='text-right' style='width: 20%; padding-right: 15px;'><a href='' style='color: #93c541; font-weight: bold; font-size:1.2em;' id='calSms' data-toggle='modal' data-target='#sendsSmsPop'><img style='width: 23px;' src='<?php echo $baseUrl; ?>/images/medical_record/more_icon/phone_sms.jpg'></a></td>"+
								'</tr>' +
								'<tr>' +
									'<td colspan="2" style="color: red">'+(calEvent.cus_note?calEvent.cus_note:'')+'</td>' +
								'</tr>' +
							'</tbody>' +
						'</table>' +
						'<span id="acCopySch" class="fa fa-files-o copySch" aria-hidden="true"></span>' +
						'<table class="table" id="pop-tb1">' +
							'<tbody>' +
								'<tr>' +
									'<td class="text-right">Bác sỹ:</td><td>'+ (calEvent.dentist ? calEvent.dentist:'') +'</td>' +
								'</tr>' +
								'<tr>' +
									'<td class="text-right">Tên dịch vụ:</td><td>'+(calEvent.services?calEvent.services:'')+'</td>' +
								'</tr>' +
								'<tr>' +
									'<td class="text-right">Thời gian:</td><td>'+(calEvent.time?calEvent.time:'') +'phút </td>' +
								'</tr>' +
								'<tr>' +
									'<td class="text-right">Đặt bởi:</td><td>'+noti+'</td>' +
								'</tr>' +
								'<tr>' +
									'<td class="text-right">Ghi chú:</td><td>'+(calEvent.note?calEvent.note:'')+'</td>' +
								'</tr>' +
								'<tr>' +
									'<td class="text-right">Ngày đặt:</td><td>'+moment(calEvent.create_date).format('HH:mm:ss DD/MM/YYYY')+'</td>' +
								'</tr>' +
							'</tbody>' +
						'</table>' +
					'</div>' +
					'<div id="pop-footer">' +
						'<button type="" class="btn btn_view edit_sch"> Chỉnh sửa</button>'+
						quote_btn + invoice_btn +
					'</div>';

		ev = [title, content];
		return ev;
	}
/*********** get chair type ***********/
	function getChairType(id_chair, id_dentist, dow, time) {
		return $.ajax({
			url     : '<?php echo CController::createUrl('calendar/getChairType'); ?>',
			type    : 'POST',
			dataType: 'json',
			data    : {
				id_chair  : id_chair,
				id_dentist: id_dentist,
				dow       : dow,
				time      : time,
			}
		})
	}

/*********** Load calendar ***********/
	function loadCalendar(height, resources, id_resource, type) {
		defaultView = id_resource ? 'agendaWeek' : 'agendaDay';
		current     = moment().format('HH:mm:ss');
		grId        = '<?php echo $group_id; ?>';
		userLog     = $('#idUserLog').val();

		var id_branch = 1;

		$('#calendar').fullCalendar({
			/* ----------- Gia tri khoi tao ----------- */
				schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',

				allDaySlot   : false,
				titleFormat  : 'DD MMMM - YYYY',
				contentHeight: height,
				nowIndicator : true,
				aspectRatio  : 3.5,

				minTime: '08:00',
				maxTime: '20:00',
				scrollTime: moment().format('HH:mm:ss'),

				header: {
					left  : '',
					center: 'title',
					right : 'today,prev,next',
			  	},

				defaultView: defaultView,
				views: {
					month:{columnFormat: 'dddd', eventLimit: 5, titleFormat: ' MMMM - YYYY',},
					week: {
						columnFormat   : 'dddd - DD/MM',
						titleFormat    : 'DD MMMM - YYYY',
						slotLabelFormat: 'HH:mm',
						slotDuration   : "00:10:00",
						snapDuration   : '00:05:00'},
					day:  {
						columnFormat   : 'dddd - DD/MM',
						titleFormat    : 'dddd, DD/MM/YYYY',
						slotLabelFormat: 'HH:mm',
						slotDuration   : "00:10:00",
						snapDuration   : '00:05:00',
					},
					timelineOneWeek: {
						type           : 'timeline',
						duration       : { weeks: 1 },
						slotDuration   : { days: 1},
						slotLabelFormat: 'dddd, DD/MM'
					}
				},

				editable    : true,
				selectable  : true,
				selectHelper: true,

				resourceLabelText:'',
			  	resources        : resources,

			/* ----------- Giao dien khoi tao ----------- */
			  	viewRender: function(view, element) {
					var paramsDefault = getParamsDefaultCalendar(view);
					idCResource = $('#at_srch').val();

					id_branch = paramsDefault.id_branch;

			  		setTimeout(function() {
						paramsShowEvent["id_dentist"]    = paramsDefault.id_dentist;
						paramsShowEvent["id_chair"]      = paramsDefault.id_chair;
						paramsShowEvent["id_branch"]     = id_branch;
						paramsShowEvent["start_time"]    = paramsDefault.start_time;
						paramsShowEvent["end_time"]      = paramsDefault.end_time;
						paramsShowEvent["id_customer"]   = paramsDefault.id_customer;
						paramsShowEvent["type_resource"] = paramsDefault.type_resource;
						paramsShowEvent["id_author"]     = paramsDefault.id_author;

			  			showEvents(paramsShowEvent);

			  			setTimeout(function(){
			  				dentistTimeOff(paramsDefault.start_time, paramsDefault.end_time, paramsDefault.id_branch, idCResource, paramsDefault.type_resource);
			  			}, 200);
			  		}, 100);

			  		if(view.type == 'agendaDay' || view.type == 'agendaWeek') {
			  			breakTime(view.type, id_resource, type);
			  		}

			  		$(".fc-view-container").css('min-width',$('th.fc-resource-cell').length*110);
			  		var width = ($('.fc-resource-cell').outerWidth()) ? $('.fc-resource-cell').outerWidth() : $('.fc-day-header').outerWidth();
			  		$(".text-time").css('width', width);
			  		$('a.fc-event').removeClass('fc-short');
			  	},

			  	eventRender: function(event, element) {
		            element.find('.fc-title').append("<br/>" + event.services);
		            if(event.status_sch_customer == 0 && event.status != 0) {
		            	element.find('.fc-time').append('<span class="check_status_customer"></span>');
		            }
		        },

			  	eventAfterAllRender: function( view ) {
			  		$('.fc-agendaDay-button').click(function(){
			  			$("#calendar").css('min-width',$('.fc-resource-cell').length*110);
			  		});
			  		if(view.name == 'agendaWeek') {
			  			$('#cal-view').val(2);
			  		}
			  	},

			  	eventOverlap: function(stillEvent, movingEvent) {
			        if(stillEvent.className == 'breakTime' || stillEvent.status == 4 || stillEvent.status == 5 || stillEvent.start_time < 0)
			        	return true;
			    },

		/*********** Sự kiện khi click chuột ********** */
		  		eventClick: function(calEvent, jsEvent, view) {
				  	/*********** An pop up thong tin lich hen ***********/
				  		if($('.popover').length) {$('.popover').popover("hide");}
				  	/*********** Gia tri bien ***********/
				  		id_resource = $('#at_srch').val();
				  		type 		= 	$('#sr_val').val();
				  		id 			= 	calEvent.id;
				  		start 		=	calEvent.start;
				  	/*********** Thong tin lich hen: noi dung va vi tri hien thi ***********/
						if(calEvent.status == 0) { evContent = noWorkContent(calEvent, grId); }
			    		else { evContent = eventContent(calEvent); }

				    	placement = "auto right";
				    	if(view.name == 'agendaDay' && id_resource){ placement = "auto bottom"; }
				    	if(view.name == 'agendaDay') { container = ".fc-time-grid-container.fc-scroller"; }
				    	else if(view.name == 'timelineOneWeek'){ container = ".fc-scroller"; }
				    	else if(view.name == 'month'){ container = ".fc-container"; }
				    	else { container = ".fc-time-grid-container.fc-scroller"; }

				  		$(jsEvent.target).popover({
			                html 		: true,
			                title 		: evContent[0],
			                content 	: evContent[1],
			                container 	: container,
			                placement 	: placement,
			                trigger 	: 'focus',
			            }).popover("show");

			            maxH 		= $('#headerMenu').outerHeight(true) + $('.fc-toolbar').outerHeight(true) + $('.fc-head').outerHeight(true);

			            evOffset 	= $(this).offset();
			            evOffsetT	= parseInt(evOffset['top']);
			            evTop 		= parseInt($(this).css('top'));
			            evHg		= parseInt($(this).height());
			            poTop 		= parseInt($('.popover').css('top'));
			            poWd		= parseInt($('.popover').width());
			            hiddenCal 	= parseInt(evOffset['top']) - maxH;
			            hiddenCalAbs= Math.abs(hiddenCal);
			            halfPo 		= Math.ceil(poWd/2);
			            arrow 		= Math.ceil(evHg/2) + hiddenCalAbs;

			           	poW 	= parseInt($('.popover').css('left'));
			            left 	= parseInt($('.popover').css('left')) - 7;

			            if(view.name != 'month' || (view.name == 'agendaDay' && id_resource)){
				            if(hiddenCal == -1) {
				            	$('.popover').css({ top: '0px', });
				            	$('.arrow').css('top','13%');
				            }
				            else if(hiddenCal < 0) {
				            	$('.popover').css({top: (hiddenCalAbs + evTop) + 'px'});
				            	$('.arrow').css({top: '15px'});
				            }
				            else if(hiddenCalAbs < (halfPo + 10)) {
				            	$('.popover').css({top: (evTop - hiddenCalAbs) + 'px'});
				            	$('.arrow').css({top: arrow + 'px'});
				            }
			            }
		  	/*********** Gui tin nhan ***********/
		  		$('#calSms').unbind().click(function (e) {
		  			e.preventDefault();
		  			$('#Sms_phone').val(calEvent.phone);
		  			$('#Sms_id_cus').val(calEvent.id_patient);
		  			$("#Sms_cus").val(calEvent.patient);
		  			$("#Sms_id_sch").val(calEvent.codeSch);
		  		})
		  	/*********** Cap nhat lich hen  ***********/
		  		$('.edit_sch').unbind().click(function(e){
		  			if($('.popover').length) { $('.popover').popover('hide'); }

		  			$('.load-up-at').fadeIn('fast');
		  			$('.load-up-cus').fadeIn('fast');
		  			$('#CsSchedule_up_lenght').removeClass('errors');
	   				$('#CsSchedule_up_start_time').removeClass('errors');
		  			$('.nav-tabs a[href="#up-schedule"]').tab('show');
		  			$('.nav-tabs a[href="#up-info"]').tab('show');

		  			if(calEvent.status == 0) { $('.upCusShow').hide(); }

		  			$('.up-sch').attr('class','btn btn_book pull-right up-sch up_sch_cus unbtn');
		  			$('#update_sch_modal').modal("show");

		  			dentistListModal(id_branch,2);

		  			// lay ghe kham hien tai - cho phep thay doi ghe kham tu do
		  			isAcceptChange = 0;
		  			if(type == 2) {isAcceptChange = 1;}

		        	$.when(getInfoUp(id)).done(function (data) {
		        		infoUpSch(data['sch'],'','',isAcceptChange);
		        		infoUpCus(data['cus'],data['codeNumberRemain'],data['codeNumberExp']);
		        		infoUpAl(data['als']);
		        	})
		  		})
		  	/*********** Sao chep lich hen khi click vao nut sao chep  ***********/
		  		$('.copySch').unbind().click(function (e) {
					e.preventDefault();

					if($('.popover').length) { $('.popover').popover("hide"); }

					start_time = start.format('YYYY-MM-DD HH:mm:ss');
					chair_type = 2;

					$('.up-sch').attr('class','btn btn_book pull-right up-sch unbtn up_next');
					$("#confirm").modal('hide');
					$('#update_sch_modal').modal('show');
					$('.Csh_type').val(type);

					$.when(getInfoUp(calEvent.id)).done(function (data) {
						console.log(data);
		        		infoUpSch(data['sch'],'', 1);
		        		infoUpCus(data['cus'],data['codeNumberRemain'],data['codeNumberExp']);
		        		infoUpAl(data['als']);

		        		st = [];
						st = <?php echo json_encode($this->st0); ?>;

					   	stOp = '';
					   	if(st) {
					      	$.each(st, function (k, v) {
					      		if(k==1)
					         		stOp +=  '<option value="'+k+'" selected>'+v+'</option>';
					         	else
					         		stOp +=  '<option value="'+k+'">'+v+'</option>';
					      	})
					   	}

					  	$('#CsSchedule_up_status').html(stOp);
					  	$('#CsSchedule_up_id_author').val(userLog);
						$('#CsSchedule_up_start_time').val(start_time);
						$('#CsSchedule_up_lenght').removeClass('errors');
						$('#CsSchedule_up_id').val(0);
		        	});

		        	id_service = $('#CsSchedule_up_id_service').val();
		        	dentistListModal(id_branch, 2);
			  		servicesList(id_resource, 2);
				})
		  	},
		/*********** Keo tha lich hen -> cap nhat thoi gian + resource ***********/
		  	eventDrop: function(event, delta, revertFunc, jsEvent, ui, view ) {
		  		$(document).click(function (e) {
					if(!$('#confirm').hasClass('in') && !$('#update_sch_modal').hasClass('in')) {
						revertFunc();
					}
				});
		  	/****** An pop up thong tin lich hen *******/
		  		if($('.popover').length) {
					$('.popover').popover('hide');
				}
			/****** Dong pop up tao lich *******/
				$('.btn_close').click(function(e){
					e.preventDefault();
					revertFunc();
				})
			/****** Thong tin du lieu lich hen ban dau *******/
				type		= $('#sr_val').val();
		  		id_resource	= event.resourceId,
				start 		= event.start;
				end 		= event.end;
				dow 		= (event.start).format('d');
				id_schedule = event.id;
				id_service 	= event.id_service;

				id_dentist 	= '';
				id_chair  	= '';
				if(type == 1) { id_dentist = event.resourceId; }
				else if(type == 2) { id_chair = event.resourceId; }
			/****** Tuy chinh pop up thong bao ban dau *******/
				$('.cf_submit').attr('class',"btn btn-default cf_submit");
				$('#info_head').text('THÔNG BÁO!');
				$('#cf_head').text('THÔNG BÁO!');
			/****** Ghe kham va trang thai hoan tat*******/
				if(event.status == 4 && event.chair_type == 1) {
				/****** Lay loai ghe kham hay dieu tri *******/
					$.when(getChairType(id_chair, id_dentist, dow, start.format('YYYY-MM-DD HH:mm:ss'))).done(function (data) {
						if(data == 1) {
				  			$('#info_content').text('Bạn không có quyền dời lịch hẹn này!');
				  			$("#info").modal();
				  			revertFunc();
				  			return;
						} else {
				  			$('#cf_content').text('Bạn có muốn tạo lịch mới để tiếp tục điều trị không?');
				  			$("#confirm").modal();
				  			return;
						}
					});
					$('.cf_submit').addClass('evDup');
				}
			/****** Trang thai dieu tri, hoan tat *******/
				else if(event.status == 3 || event.status == 4) {
		  			$('#info_content').text('Bạn không có quyền dời lịch hẹn này!');
		  			$("#info").modal();
		  			revertFunc();
			   		return;
				}
			/****** Ghe kham va trang thai vao kham *******/
				else if(event.status == 6 && event.chair_type == 1){
					$.when(getChairType(id_chair, id_dentist, dow, start.format('YYYY-MM-DD HH:mm:ss'))).done(function (data) {
						if(data == 2) {
				  			$('#info_content').text('Bạn không có quyền dời lịch hẹn này!');
				  			$("#info").modal();
				  			revertFunc();
				  			return;
						}
						else {
				  			$('#cf_content').text('Bạn có muốn dời lịch không?');
				  			$("#confirm").modal();
				  			return;
						}
					});
					$('.cf_submit').addClass('evDro');
				}
			/****** Trang thai hen lai *******/
				else if(event.status == -1){
					$('.cf_submit').addClass('evReSch');
					$('#cf_content').text('Bạn có muốn tạo lịch hẹn không?');
					$("#confirm").modal();
				}
			/****** Trang thai con lai *******/
				else {
					$('.cf_submit').addClass('evDro');
		  			$('#cf_content').text('Bạn có muốn dời lịch không?');
		  			$("#confirm").modal();
				}
			/****** Tao lich hen moi: Ghe kham trang thai hoan tat. Ghe dieu tri chuyen thanh dang cho *******/
				$('.evDup').unbind().click(function (e) {
					e.preventDefault();

					start_time = start.format('YYYY-MM-DD HH:mm:ss');
					chair_type = 2;

					$('.up-sch').attr('class','btn btn_book pull-right up-sch unbtn up_next');
					$("#confirm").modal('hide');
					$('#update_sch_modal').modal('show');

				/****** Lay thong tin chi tiet lich hen cu va hien thi tren pop up date lich moi *******/
					$.when(getInfoUp(event.id)).done(function (data) {
		        		infoUpSch(data['sch'],'', 1);
		        		infoUpCus(data['cus'],data['codeNumberRemain'],data['codeNumberExp']);
		        		infoUpAl(data['als']);

		        		st = []; stOp = '';
						st = <?php echo json_encode($this->stN); ?>;

					   	if(st) {
					      	$.each(st, function (k, v) {
					      		if(k!=1){ 	stOp +=  '<option value="'+k+'" selected>'+v+'</option>'; }
					         	else 	{ 	stOp +=  '<option value="'+k+'">'+v+'</option>'; }
					      	});
					   	}

					  	$('#CsSchedule_up_status').html(stOp);
						$('#CsSchedule_up_start_time').val(start_time);
						$('#CsSchedule_up_lenght').removeClass('errors');
						$('#CsSchedule_up_id').val(0);
		        	});

				/****** Xem theo bac sy *******/
		        	if(type == 1){
		        		setTimeout(function () {
	  						resourceText = $('#calendar').fullCalendar( 'getResourceById', id_resource);
			  				$('#CsSchedule_up_id_dentist').html("<option value='"+id_resource+"'>"+resourceText.title+"</option>");
	  					}, 1000);

			  			dentistListModal(id_branch, 2);
			  			servicesList(id_resource, 2);

			  			len = event.time;

			  			if(len) {
		  					end = moment(start).add(len, 'm');
		  					end = moment(end).format('YYYY-MM-DD HH:mm:ss');
		  					$('#CsSchedule_up_end_time').val(end);

						    var ckT = '';

						    setTimeout(function () {
						    	ck = chkTime(id_dentist, id_services, start, len);
							    $.when(ck).done(function(){
							        ckT = $('.chkT').val();

							        if(ckT == 1) {
							        	$('#step-1').removeClass('unbtn');
							        }
							    });
							}, 1500);
		  				}
			  		}
			  	/****** Xem theo ghe kham *******/
			  		else {
						$.when(dentistChair(id_branch, event.resourceId, event.start, '')).then(function (data) {
							$('.load-at').fadeOut('fast');
			  				chair_type = '';
			  				id_dentist = '';

			  				if(data !=  0) {
			  					setTimeout(function () {
			  						chair_type = data.dentist['chair_type'];
			  						id_dentist = data.dentist['id_dentist'];
			  						$('#CsSchedule_up_id_dentist').html("<option value='"+data.dentist['id_dentist']+"'>"+data.dentist['dentist_name']+"</option>");
			  					}, 1000);
			  				}
			  				else {
				  				$('#CsSchedule_up_id_dentist').html('');
				  			}

				  			dentistListModal(id_branch, chair_type);
				  			len = event.time;

				  			if(len) {
			  					end = moment(start).add(len, 'm');
			  					end = moment(end).format('YYYY-MM-DD HH:mm:ss');
			  					$('#CsSchedule_up_end_time').val(end);

							    var ckT = '';

							    setTimeout(function () {
							    	ck = chkTime(id_dentist, id_services, start, len);
								    $.when(ck).done(function(){
								        ckT = $('.chkT').val();

								        if(ckT == 1) {
								        	$('#step-1').removeClass('unbtn');
								        }
								    });
								}, 1500);
			  				}
			  				else
			  					$('.up-sch').addClass('unbtn');
						});
					}
					revertFunc();
				})
			/****** Tao lich hen moi: Trang thai hen lai chuyen thanh lich moi *******/
				$('.evReSch').unbind().click(function(e){
					e.preventDefault();
					if(type == 1)
						id_dentist = event.resourceId;
					else if(type == 2)
						id_chair = event.resourceId;
					// kiem tra thoi gian lich hen
					// id_dentist, start_time, end_time, id_schedule, status_sch,id_customer, id_chair
					$.when(checkTimeAjax(id_dentist, start.format('YYYY-MM-DD HH:mm:ss'), end.format('YYYY-MM-DD HH:mm:ss'), 0, event.status, event.id_patient, id_chair)).done(function (data){

						$("#confirm").modal('hide');
						if(data.status == 1){
							revertFunc();
							$.when(reSchedule(event.id_patient, data.data['id_dentist'], userLog, id_branch, data.data['id_chair'], event.id_service, event.time, start.format('YYYY-MM-DD HH:mm:ss'), end.format('YYYY-MM-DD HH:mm:ss'), type)).done(function (data) {

								if(data){
									$('#calendar').fullCalendar( 'removeEvents', data.id );
				               		$('#calendar').fullCalendar( 'renderEvent', data, true );
				               		getNoti(data.id,'update',userLog, data.id_dentist);
								}
								else {
						  			$('#info_content').text('Có lỗi xảy ra! Xin vui lòng thử lại sau!');
									$("#info").modal('show');
								}
							});
						}
						else {
							$('#info_content').text(data.ms);
							$("#info").modal('show');
							revertFunc();
						}
					});
				})
	  		/****** Doi lich *******/
				$('.evDro').unbind().click(function(e){
					e.preventDefault();
					if(type == 1) {
						id_dentist = event.resourceId;
					}
					else if(type == 2) {
						id_chair = event.resourceId;
						id_dentist = event.id_dentist;
					}

					// kiem tra thoi gian lich hen
					$.when(checkTimeAjax(id_dentist, start.format('YYYY-MM-DD HH:mm:ss'), end.format('YYYY-MM-DD HH:mm:ss'), id_schedule, event.status, event.id_patient, id_chair)).done(function (data){
						$("#confirm").modal('hide');

						if(data.status == 1){
							if (type == 1) {
								id_chair = data.data['id_chair'];
								console.log(id_chair);
							}
							$.when(updateDrop(id_dentist, start.format('YYYY-MM-DD HH:mm:ss'), end.format('YYYY-MM-DD HH:mm:ss'), id_schedule, type, id_chair)).done(function (data) {

								if(data){
									$('#calendar').fullCalendar( 'removeEvents', data.id );
				               		$('#calendar').fullCalendar( 'renderEvent', data, true );
				               		getNoti(data.id,'update',userLog, data.id_dentist);
								}
								else {
						  			$('#info_content').text('Có lỗi xảy ra! Xin vui lòng thử lại sau!');
									$("#info").modal('show');
								}
							});
						}
						else {
							$('#info_content').text(data.ms);
							$("#info").modal('show');
							revertFunc();
						}
					});
				})
		  	},
		/*********** Thay đổi kích thước lich hen -> cap nhat thoi gian ***********/
		  	eventResize: function( event, delta, revertFunc, jsEvent, ui, view ) {
		  	/****** Tuy chinh pop up thong bao *******/
			 	$('#cf_head').text('Thông báo!');
	  			$('#cf_content').text('Bạn có muốn thay đổi thời gian không?');
	  			$("#confirm").modal();
	  			$('.cf_submit').attr('class',"btn btn-default cf_submit");
	  			$('.cf_submit').addClass('evRe');
	  		/****** Khong thay doi thoi gian *******/
	  			$('.btn_close').click(function (e) {
	  				e.preventDefault();
	  				revertFunc();
	  			})
	  		/****** Xac nhan thay doi thoi gian *******/
	  			$('.evRe').unbind().click(function (e) {
	  				e.preventDefault();
	  				$.ajax({
						type	 : "post",
						dataType : 'json',
						url	 	 : '<?php echo CController::createUrl('calendar/eventResize'); ?>',
						data	 : {
							id 		: event.id,
							end 	: event.end.format('YYYY-MM-DD HH:mm:ss'),
							len 	: event['end'].diff(event['start'],'m'),
						},
						success: function(data) {
							$("#confirm").modal('hide');
							if(!data) {
								$('#info_head').text('THÔNG BÁO!');
					  			$('#info_content').text('Cập nhật thất bại!');
					  			$("#info").modal();
					  			revertFunc();
							}
						},
					});
	  			})
		  	},
		/*********** Tạo sự kiện mới - nhấp chuột vào thời gian trống ***********/
			/* ----------- Tạo sự kiện mới - nhấp chuột vào thời gian trống ----------- */
		  		select: function(start, end, jsEvent, view, resource) {
		  			/****** Khong cho dat lich hen trong hinh thuc tuan tat ca bac sy va thang *******/
		  				if(view.name == 'timelineOneWeek' || view.name == 'month') { return; }

		  			/****** An pop up thong tin lich hen *******/
				  		if($('.popover').length) { $('.popover').popover('hide'); }

				  	/****** Kiem tra thoi gian tao lich *******/
				  		var start_time = moment(start).format('YYYY-MM-DD HH:mm:ss');

				  		if(moment().format('YYYY-MM-DD HH:mm:ss') > start_time) {
				  			$('#info_head').text('THÔNG BÁO!');
				  			$('#info_content').text('Thời gian không đúng!');
				  			$("#info").modal();
							return false;
						}

					/****** Khoi tao thong tin dat lich moi *******/
						$('.load-at').fadeIn('fast');
						$('.help-block.error').hide();

						servicesList(0, 1,'');
						dentistListModal(id_branch, 2);

				  		$('.nav-tabs a[href="#tab-schedule"]').tab('show');
				  		$('#step-1').addClass('unbtn');

				  		$('#create_sch_modal').modal('show');
				  		$('#CsSchedule_id_dentist').html('');
				  		$('#CsSchedule_id_service').html('');
				  		$('#CsSchedule_id_customer').html('');
				  		$('#CsSchedule_lenght').val(0);
				  		$('#CsSchedule_lenght').removeClass('errors');
			   			$('#CsSchedule_start_time').removeClass('errors');

			   			type = $('#sr_val').val();
			   		/****** Che do xem theo tuan *******/
				  		if(view.name == 'agendaWeek') {
							idResource = $('#at_srch').val();
							resource    = $('#at_srch').select2('data');
				  		/****** Hinh thuc xem nha sy - Lay ghe theo bac sy *******/
				  			if(type == 1) {
				  				$('#CsSchedule_id_dentist').html("<option value='"+idResource+"'>"+resource[0].text+"</option>");
				  				$.when(dentistChair(id_branch, '', start_time, idResource)).then(function (data) {
					  				if(data != 0) {
					  					$('#CsSchedule_id_chair').val(data.dentist['id_chair']);
					  				} else {
					  					$('#CsSchedule_id_chair').val('');
					  				}
					  				$('.load-at').fadeOut('fast');
					  			});
				  			}
				  		/****** Hinh thuc xem ghe kham - Thay doi ghe *******/
				  			else {
				  				$.when(dentistChair(id_branch, idResource, start_time, '')).then(function (data) {
					  				chair_type = ''; id_dentist = '';

					  				if(data !=  0) {
					  					chair_type = data.dentist['chair_type'];
					  					id_dentist = data.dentist['id_dentist'];
					  					$('#CsSchedule_id_dentist').html("<option value='"+data.dentist['id_dentist']+"'>"+data.dentist['dentist_name']+"</option>");
					  				} else {
					  					$('#CsSchedule_id_dentist').html('');
					  				}
					  				$('#CsSchedule_id_chair').val(idResource);
					  				$('#create_acceptChange').val(1);
					  				$('.load-at').fadeOut('fast');
					  			});
				  			}
				  		}
				  	/****** Che do xem theo ngay *******/
				  		else {
				  		/****** Hinh thuc xem nha sy - lay ghe theo bac sy *******/
					  		if(type == 1){
					  			$('#CsSchedule_id_dentist').html("<option value='"+resource.id+"'>"+resource.title+"</option>");
					  		/****** Lay thong tin ghe cua nha sy *******/
					  			$.when(dentistChair(id_branch, '', start_time, resource.id)).then(function (data) {
					  				if(data != 0) {
					  					$('#CsSchedule_id_chair').val(data.dentist['id_chair']);
					  				} else {
					  					$('#CsSchedule_id_chair').val('');
					  				}
					  				$('.load-at').fadeOut('fast');
					  			});
					  		}
					  	/****** Hinh thuc xem ghe kham - tuy chinh ghe *******/
					  		else {
					  		/****** Lay thong tin nha sy ngoi tren ghe *******/
					  			$.when(dentistChair(id_branch, resource.id, start_time, '')).then(function (data) {
					  				chair_type = ''; id_dentist = '';

					  				if(data != 0) {
					  					chair_type = data.dentist['chair_type'];
					  					id_dentist = data.dentist['id_dentist'];
					  					$('#CsSchedule_id_dentist').html("<option value='"+data.dentist['id_dentist']+"'>"+data.dentist['dentist_name']+"</option>");
					  				} else {
					  					$('#CsSchedule_id_dentist').html('');
					  				}
					  				$('#CsSchedule_id_chair').val(resource.id);
					  				$('#create_acceptChange').val(1);
					  				$('.load-at').fadeOut('fast');
					  			});
					  		}
					  	}
					/****** Lay loai ghe: ghe kham, ghe dieu tri *******/
					  	$var 	= $('#sr_val').val();
					  	id_dt 	= ''; id_chr 	= '';

					  	if(view.name == 'agendaWeek'){
					  		if($var == 1) { id_dt = $('#at_srch').val(); }
					  		else { id_chr = $('#at_srch').val(); }
					  	} else {
						  	if ($var == 1) { id_dt = resource.id; }		// nha sy
						  	else { id_chr = resource.id; }
					  	}

					  	isToday = start.isSame(moment(),'day');

					  	$.when(getChairType(id_chr, id_dt, start.format('d'), start.format('YYYY-MM-DD HH:mm:ss'))).done(function (data) {
							st = [];  stOp = '';

							if (!isToday){ st = <?php echo json_encode($this->st1); ?>;}			// hom nay
							else if(data == 1){ st = <?php echo json_encode($this->stEN); ?>; }		// ghe kham
							else { st = <?php echo json_encode($this->stN); ?>; }

							if(st) {
							    $.each(st, function (k, v) {
							      	if(k!=1) { stOp +=  '<option value="'+k+'" selected>'+v+'</option>'; }
							        else { stOp +=  '<option value="'+k+'">'+v+'</option>'; }
							    });
							}
							$('#CsSchedule_status').html(stOp);

							$('#CsSchedule_status').val(1);

							if(data == 1) { $('#CsSchedule_status').val(6); }
						});

					  	$('#Customer_code_number').removeClass('errors');
						$('#CsSchedule_start_time').val(start_time);
		  	},
		});

		btnRight(); btnCenter();
		userList(id_branch);

	/****** Thay doi dang xem cua lich: ngay, tuan, thang *******/
		$('#cal-view').change(function(){
			views = $('#cal-view').val();
			changeViews(views,id_resource);
		})

	/****** Lay lich hen theo nguoi tao *******/
		$('#srch_author').change(function(e){
			e.preventDefault();
			id_author 	= $('#srch_author').val();

			paramsShowEvent["id_author"] = id_author;
			showEvents(paramsShowEvent);
		});
	}
/*********** Load resources ***********/
	function loadResources(id_branch,id_resource,type){
		var height 	= 	$(window).height()-150;
		type 		= 	parseInt(type);

		var id_dentist 	= '';
		var id_patient 	= '';
		var id_chair	= '';

		switch(type) {
			case TYPE_RESOURCE.dentist:
				url = '<?php echo CController::createUrl('calendar/getDentistList'); ?>';
				id_dentist = id_resource;
				break;
			case TYPE_RESOURCE.chair:
				url = '<?php echo CController::createUrl('calendar/getChairList'); ?>';
				id_chair = id_resource;
				break;
			default:
				url = '<?php echo CController::createUrl('calendar/getDentistList'); ?>';
				break;
		}

		$('.cal_loading').fadeIn('fast');
		$.ajax({
			type    : "post",
			dataType: 'json',
			url     : url,
			data    : {
				id_resource : id_resource,
				id_branch 	: id_branch,
			},
			success: function(data) {
				$('.cal_loading').fadeOut('fast');
				if(data == -1) {
					loadResources(id_branch,'',1);
					return;
				}
				$('#calendar').fullCalendar('destroy');
				loadCalendar(height, data, id_resource, type);
			},
			error: function(data){
				alert("Có lỗi xảy ra, vui lòng thử lại sau!");
			}
		});
	}
</script>

<script>

$(document).ready(function () {
	$.fn.select2.defaults.set( "theme", "bootstrap");
	$('[data-toggle="tooltip"]').tooltip();

	$('.Csh_type').val(TYPE_RESOURCE.chair);

	var id_branch  = $('#id_branch').val();
	var userLog    = $('#idUserLog').val();
	var type       = 	1;			// bac sy
	var id_dentist = 	$('#at_srch').val();
	var role       = 	'<?php echo $role; ?>';

	if(role == 0) {
		id_dentist 		= '<?php echo $id_user; ?>';
		name_dentist 	= '<?php echo $name_user; ?>';
		loadResources(id_branch,id_dentist,1);
		dentistList(id_branch,role);
	} else {
		loadResources(id_branch,id_dentist,2);
		chairList(id_branch);
	}

	today 	= 	moment();
	$('.datetimepicker').datetimepicker({
		sideBySide 	: true,
		minDate 	: today.startOf('hour'),
		format 		: 'YYYY-MM-DD HH:mm:ss',
		stepping 	: 5,
	});

	$('.sch_dentist').change(function (e) {
		e.preventDefault();
		$('.sch_service').val(-1).trigger('change');
	})

	$('#id_branch').change(function (e) {
		e.preventDefault();

		id_branch = $('#id_branch').val();
		type      = parseInt($('#sr_val').val());

		switch(type) {
			case TYPE_RESOURCE.dentist: dentistList(id_branch);
				break;
			case TYPE_RESOURCE.chair: chairList(id_branch);
				break;
		}
		loadResources(id_branch,'',type);
	});

	$('#sr_val').change(function(e){
		e.preventDefault();

		id_branch = $('#id_branch').val();
		type      = parseInt($('#sr_val').val());

		switch(type) {
			case TYPE_RESOURCE.dentist: dentistList(id_branch);
				break;
			case TYPE_RESOURCE.chair: chairList(id_branch);
				break;
		}

		$('.Csh_type').val(type);
		$('#at_srch').val('-1').trigger('change');
	});

	$('.search').change(function(){
		id_branch   = $('#id_branch').val();
		type        = $('#sr_val').val();
		id_resource = $('#at_srch').val();

		loadResources(id_branch,id_resource,type);
	})
})
</script>