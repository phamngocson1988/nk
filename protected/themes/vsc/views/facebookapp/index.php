<?php $baseUrl = Yii::app()->getBaseUrl();  ?>
<?php include 'fb_app_css.php'; ?>

<pre>
	<?php
	$t = CsSchedule::model()->TimeJson();
	print_r($t);
	 ?>
</pre>

<?php exit; ?>

<div class="col-xs-12 fb_book">
	<div class="col-xs-12" id="bk_st_tt">
		<h4>ĐẶT LỊCH KHÁM</h4>
	</div>

	<div class="col-xs-12" id="fb_book_info">
		<div class="col-xs-6">
			<div class="form-group">
				Chọn phòng khám
				<?php
					$Branch = array();
					$list_data = Branch::model()->findAllByAttributes(array('status'=>'1'));							
					foreach($list_data as $temp){
						$Branch[$temp['id']] = $temp['name'] . ' - ' . $temp['address'];
					}
					echo CHtml::dropDownList('book_br','',$Branch,array('class'=>'form-control'));
				?>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				Chọn dịch vụ
				<select name="" id="book_sv" class="form-control">
					<option value="">Chọn dịch vụ</option>
				</select>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				Ngày đến khám
				<input type="text" name="" value="" placeholder="Chọn ngày khám" class="form-control datepicker" id="book_d">
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				Nha sỹ khám cho bạn
				<select name="" id="book_dt" class="form-control">
					<option value="">Chọn nha sỹ</option>
				</select>
			</div>
		</div>
	</div>

	<div class="col-xs-12" id="fb_book_time">
		<button class="arr glyphicon glyphicon-menu-right" id="bk_rt"></button>
		<button class="arr glyphicon glyphicon-menu-left" id="bk_lt"></button>
		<div class="table-responsive" style="margin: 0 10px;">
			<table class="table book_tb" id="book_time">
				<thead>
					<tr><th colspan="8" id="book_tt"></th></tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<div id="book_ct_s">
				<table class="table book_tb" id="book_ct">
					<tbody>
					</tbody>
				</table>
			</div>
			<div id="tfoot">
				<span>Đây là những giờ còn trống, nhấp vào ô thời gian tương ứng để đặt lịch</span>
			</div>
		</div>
	</div>
</div>


<script>
/*** list danh sách dịch vụ theo chi nhánh ***/
function getService(id_branch){
	$.ajax({
		timeout:3000,
	    type:'POST',
	    dataType: 'json',
	    url: '<?php echo CController::createUrl('book/getServicesList'); ?>',
	    data: {
	    	id_branch : id_branch,
	    },   
	    success:function(data){
	    	$('#book_sv').empty();
	    	if(data == -1)
	    		$('#book_sv').append('<option value="0">Chọn dịch vụ</option>');
	    	$.each(data,function(i,u){
            	$('#book_sv').append('<option value="'+u.id+'">'+u.name+'</option>');
	    	})
	    	
	    },
	    error: function(data){
		    console.log("error");
		    console.log(data);
	    }
    });
}

/*** list danh sách bác sỹ theo chi nhánh ***/
function getDentist(id_branch,id_service) {
	$.ajax({
		timeout:3000,
	    type:'POST',
	    dataType: 'json',
	    url: '<?php echo CController::createUrl('book/getDentistBook'); ?>',
	    data: {
	    	id_branch : id_branch,
	    	id_service: id_service,
	    },   
	    success:function(data){
	    	$('#book_dt').empty();
	    	$('#book_dt').append('<option value="0">Chọn nha sỹ</option>');
	    	$.each(data,function(i,u){
            	$('#book_dt').append('<option value="'+u.id+'">'+u.name+'</option>');
	    	})
	    	
	    },
	    error: function(data){
		    console.log("error");
		    console.log(data);
	    }
    });
}
/*** tạo table chọn lịch hẹn ***/
function createDate(date, id_branch, id_service, id_dentist){

	var week 		= 	moment(date).format('WW');
	var month 		= 	moment(date).format('MM');
	var year 		= 	moment(date).format('YYYY');
	var start 		= 	moment(date).startOf('isoweek');
	var end 		= 	moment(date).endOf('isoweek');

	var thead 		= 	$('table#book_time tbody');
	var tbody 		= 	$('table#book_ct tbody');

	var timeday = '';
	var col = 7;					// số ngày trong tuần

	var getBlock = $.ajax({
		timeout:3000,
	    type:'POST',
	    dataType: 'json',
	    url: '<?php echo CController::createUrl('book/getExamTime'); ?>',
	    data: {
	    	id_branch  	: id_branch,
	    	id_service 	: id_service,
	    	id_dentist 	: id_dentist,
	    	start 		: moment(start).format('YYYY-MM-DD'),
	    	end 		: moment(end).format('YYYY-MM-DD'),
	    },
	});

	$('#book_tt').html('Tuần ' + week + ' - Tháng ' + month + ' - Năm ' + year);

	var head = createViewHead(start,col);
	thead.html(head);

	var w = $(thead).width();
	
	$('#book_ct_s').css('width', w + 'px');
	$('#tfoot').css('width', w + 'px');

	var row ='<tr>';

	getBlock.done(function(data){
		for (var i=0; i<col; i++) {
			var day 	= 	moment(start).add(i,'day');
			var days 	= 	moment(day).format('YYYY-MM-DD');

			var block 	=	jQuery.grep(data,function(k,u){
				var fm 	= 	moment(k.day).format('YYYY-MM-DD');
				return days == fm;
			})
			
			row = row + createViewDate(day,block);
		}

		row = row + '<td class="srollbar"></td></tr>';
		tbody.html(row);

		if(350>$('#book_ct').height()) {
			$('.srollbar').css('min-width','14px');
		}
		else {
			$('.srollbar').css('min-width','0');
		}

		$(".ext_bk ").on("click", "td", function() {
			sub 			= $(this).data('sub');
			main 			= $(this).data('main');

			subdt 			= 0;
			subchair 		= 0;
			sublen 			= 0;

			if(sub!=0){
				s 			= sub.split("-");
				subdt 		= s[0];
				subchair 	= s[1];
				sublen 		= s[2];
			}

			// 0: dentist, 1: chair, 2: len time
			m 			= main.split("-");

			var dentist_name	= $('#book_dt option:selected').text();
			var service_name	= $('#book_sv option:selected').text();
			var branch_name		= $('#book_br option:selected').text();

			var book 		= 	[];

			book.push({
				id_dentist 	: 	m[0],
				id_branch   : 	id_branch, 
				branch  	: 	branch_name,
				id_service	: 	id_service,
				service 	: 	service_name,
				id_chair 	: 	m[1], 
				day 		: 	$(this).data('day'), 
				time 		: 	$(this).data('time'),
				len 	 	: 	m[2],
			});

			$.ajax({
				url: '<?php echo CController::createUrl('facebookapp/sessionBook'); ?>',
				type: 'post',
				data: {
					book: book,
				},
				success: function(data){
					console.log(data);
					location.href = '<?php echo $baseUrl; ?>/facebookapp/fbCustomer';
				},
				error: function(data){
					console.log('error');
					console.log(data);
				}
			})
		});
	});
}
/**** table title header day ****/
function createViewHead (start,col=7) {
	var th = '<tr>';

	for (var i=0; i<col; i++) {
		var date 	= moment(start).add(i,'day');
		th 			= th + '<th class="bk_tt"><span class="text_date">' + moment(date).format('dddd') +'</span></br><span class="small">' + moment(date).format('DD/MM/YY') + '</span></th>' ;
	}

	th = th + '<th class="bk_tt"></th></tr>';

	return th;
}
/*** table theo từng ngày trong đặt lịch ***/
function createViewDate (date,time,duration)
{
	var today 	= moment();
	var td 		= '<td><table class="ext_bk table">';

	$.each(time,function(key,val){
		day 	= val.day;
		dow 	= val.dow;

		$.each(val.time,function(i,u){
			t 		= u.split(".");
			var stw = moment(t[0],'HH:mm');
			var enw = moment(t[1],'HH:mm');
			var sub = 0;
			
			var main = t[2];

			if(typeof(t[3]) != "undefined" && t[3] !== null) {
				sub = t[3];
			}
			
			var viewTime = stw;

			if(date.isSameOrAfter(today,'day') && dow !=0){
				if(date.isSame(today,'day')){
					if(moment(viewTime) < moment().add('5','hour')){
						return true;
					}
				}	
				
				td = td + '<tr><td class="cl" data-sub='+sub+' data-main='+main+' data-day="'+moment(date).format('YYYY-MM-DD')+ '" data-time="' +moment(viewTime).format('HH:mm:ss') +'"><span>' + moment(viewTime).format('HH:mm') +
									'</span></td></tr>';
			}
		})
	})
	
	td = td + '</table></td>';
	return td;
}
</script>

<script>
$(document).ready(function(){
	moment.locale('vi');

	var today = moment();

	var date = today;
	var id_branch = $('#book_br').val();
	var id_service = $('#book_sv').val();
	var id_dentist = $('#book_dt').val();

	$('#book_d').val(today.format('DD/MM/YY'));

	/***** datepicker *****/
	$('.datepicker').datepicker({
		minDate: 0,
		dateFormat: 'dd/mm/yy',
	});

	/***** Lấy danh sách bác sỹ theo chi nhánh*****/
	getDentist(1,1);
	getService(1);

	/***** default day is today *******/
	createDate(today,1,1,'');

	/**** change branch *****/
	$('#book_br').change(function() {
		var id_branch = $('#book_br').val();
		var id_service = $('#book_sv').val();
		var id_dentist = $('#book_dt').val();
		var day = date;

		getDentist(id_branch,1);
		getService(id_branch);

		createDate(day,id_branch,1,id_dentist);
	});

	/**** change service *****/
	$('#book_sv').change(function() {
		var id_branch = $('#book_br').val();
		var id_service = $('#book_sv').val();
		var day = date;

		getDentist(id_branch,id_service);
		
		createDate(day,id_branch,id_service,'');
	});

	/**** change date *****/
	$('#book_d').change(function(){
		var id_branch = $('#book_br').val();
		var id_service = $('#book_sv').val();
		var id_dentist = $('#book_dt').val();
		
		var getdate = $('#book_d').datepicker('getDate');
		date = getdate;

		createDate(date,id_branch,id_service,id_dentist);
	});

	/**** change dentist *****/
	$('#book_dt').change(function() {
		var id_branch = $('#book_br').val();
		var id_service = $('#book_sv').val();
		var day = $('#book_d').datepicker('getDate');
		var id_dentist = $('#book_dt').val();

		createDate(day,id_branch,id_service,id_dentist);
	});

	/****** next week ********/
	$('#bk_rt').click(function(){
		var id_branch = $('#book_br').val();
		var id_service = $('#book_sv').val();
		var id_dentist = $('#book_dt').val();
		
		var next = moment(date).add(1, 'weeks').startOf('isoWeek');
		date = next;

		createDate(next,id_branch,id_service,id_dentist);
	});

	/****** last week ********/
	$('#bk_lt').click(function(){
		var id_branch = $('#book_br').val();
		var id_service = $('#book_sv').val();
		var id_dentist = $('#book_dt').val();

		var pre = moment(date).subtract(1, 'weeks').startOf('isoWeek');
		date = pre;

		createDate(pre,id_branch,id_service,id_dentist);
	});
})
</script>