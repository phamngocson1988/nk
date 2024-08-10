
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker/css/datepicker.css" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker/js/bootstrap-datepicker.js" charset="utf-8"></script>

<?php
	$baseUrl = Yii::app()->getBaseUrl();
	$controller = Yii::app()->getController()->getAction()->controller->id;
	$action = Yii::app()->getController()->getAction()->controller->action->id;

	$lang = Yii::app()->request->getParam('lang', '');
	if ($lang != '') {
		Yii::app()->session['lang'] = $lang;
	} else {
		if (isset(Yii::app()->session['lang'])) {
			$lang = Yii::app()->session['lang'];
		} else {
			$lang = 'vi';
		}
	}
	Yii::app()->setLanguage($lang);
?>

<style type="text/css">
	#bk_info{
		padding-bottom: 35px;
	}

	#bk_schedule {
		position: relative;
	}

	.cal-loading {
		position: absolute;
	    width: 100%;
	    height: 300%;
	    z-index: 9999;
	    background: url('<?php echo $baseUrl; ?>/images/icon_sb_left/loading.gif') 50% 50% no-repeat rgba(221,221,221,0.5);
	    background-size: 8% auto;
	}
	.upcase_txt {text-transform: uppercase;}
	table.ext_bk td:hover:before {content: '<?php echo Yii::t("translate", "book_hover"); ?>'}
</style>

<div class="container" id="bk_step">
	<div class="row">
		<div class="col-sm-12">
			<div class="row" id="bk_st_tt">
				<h3 class="upcase_txt"><?php echo Yii::t('translate', 'booking'); ?></h3>

				<div id="bk_action">
					<ul class="list-inline">
						<li class="bk_fn"><a href="<?php echo $baseUrl . '/book/index/lang/' . $lang; ?>" class="upcase_txt">1. <?php echo Yii::t('translate', 'book_appointment'); ?></a></li>
						<li><a href="#<?php //echo $baseUrl.'/book/register_info/lang/'.$lang; ?>" class="upcase_txt">2. <?php echo Yii::t('translate', 'book_register'); ?></a></li>
						<!-- <li><a href="<?php //echo $baseUrl; ?>/index.php/book/verify_schedule">3. XÁC NHẬN LỊCH HẸN</a></li> -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="bk_step_num">1</div>

<div class="container" id="bk_info">
	<div class="row">
		<div class="col-sm-12 ">
			<div class="row">
				<div class="col-md-4" id="bk_select">
					<form method="get" accept-charset="utf-8">
						<input type="hidden" id="chair_type" value="<?php echo isset($sch->chair_type) ? $sch->chair_type : 1; ?>">

						<?php
							$readOnly = '';
							if ($sch != NULL){
								$readOnly = "readOnly";
							}
						?>

						<div class="form-group">
							<?php echo Yii::t('translate','book_branch'); ?>

							<?php
								$Branch = array();
								if ($sch) {
									$list_data = Branch::model()->findByPk($sch->id_branch);

									$Branch[$list_data->id] = $list_data->name . ' - ' . $list_data->address;
								} else {
									$list_data = Branch::model()->findAllByAttributes(array('status' => '1'));

									foreach ($list_data as $temp) {
										$Branch[$temp['id']] = $temp['name'] . ' - ' . $temp['address'];
									}
								}

								echo CHtml::dropDownList('book_br', '', $Branch, array('class' => 'form-control', $readOnly => $readOnly));
							?>
						</div>

						<div class="form-group">
							<?php echo Yii::t('translate','book_service'); ?>
							<select <?php echo $readOnly; ?> name="" id="book_sv" class="form-control">
								<?php if ($sch): ?>
									<option data-len="<?php echo $sch->lenght; ?>" value="<?php echo $sch->id_service; ?>"><?php echo $sch->name_service; ?></option>
								<?php else: ?>
									<option value="">Chọn dịch vụ</option>
								<?php endif ?>
							</select>
						</div>

						<div class="form-group">
							<?php echo Yii::t('translate','book_date'); ?>
							<input type="text" placeholder="Chọn ngày khám" class="form-control datepicker" id="book_d">
						</div>

						<div class="form-group">
							<?php echo Yii::t('translate','book_dentist'); ?>
							<select <?php echo $readOnly; ?> name="" id="book_dt" class="form-control">
								<?php if ($sch): ?>
									<option value="<?php echo $sch->id_dentist; ?>"><?php echo $sch->name_dentist; ?></option>
								<?php else: ?>
									<option value=""><?php echo Yii::t('translate','book_choose_dentist'); ?></option>
								<?php endif ?>
							</select>
						</div>
					</form>
				</div>

				<div class="col-md-8 text-center" id="bk_schedule">
					<div class="row cal-loading"></div>

					<button class="arr glyphicon glyphicon-menu-right" id="bk_rt"></button>
					<button class="arr glyphicon glyphicon-menu-left" id="bk_lt"></button>

					<div class="table-responsive">
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
							<span><?php echo Yii::t('translate', 'book_free_time'); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
/*** list danh sách dịch vụ theo chi nhánh ***/
	function getService(id_branch) {
		return $.ajax({
			type :'POST',
			dataType : 'json',
			url : '<?php echo CController::createUrl('book/getServicesList'); ?>',
			data : {id_branch : id_branch},
		    success:function(data){
				$('#book_sv').empty();

				$('#book_sv').append('<option value="0"><?php echo Yii::t("translate","book_service"); ?></option>');

		    	if(data.length == 0){
		    		return;
				}

		    	$.each(data,function(i,u){
	            	$('#book_sv').append('<option value="'+u.id+'" data-len="'+u.len+'">'+u.name+'</option>');
		    	})
		    },
	    });
	}

/*** list danh sách bác sỹ theo chi nhánh ***/
	function getDentist(id_branch,id_service) {
		return $.ajax({
		    type:'POST',
		    dataType: 'json',
		    url: '<?php echo CController::createUrl('book/getDentistBook'); ?>',
		    data: {
		    	id_branch : id_branch,
		    	id_service: id_service,
		    },
		    success:function(data){
		    	$('#book_dt').empty();
				$('#book_dt').append('<option value="0"><?php echo Yii::t("translate","book_dentist"); ?></option>');

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
	function createDate(date, id_branch, id_service, id_dentist, len, note){
		chair_type = $('#chair_type').val();
			if(chair_type == 1)
				len = '';

		var week  = moment(date).format('WW');
		var month = moment(date).format('MM');
		var year  = moment(date).format('YYYY');
		var start = moment(date).startOf('isoweek');
		var end   = moment(date).endOf('isoweek');

		var thead = $('table#book_time tbody');
		var tbody = $('table#book_ct tbody');

		var timeday = '';
		var col = 7;					// số ngày trong tuần

		$('.cal-loading').fadeIn('fast');
		var getBlock = $.ajax({
		    type:'POST',
		    dataType: 'json',
		    url: '<?php echo CController::createUrl('book/getExamTime'); ?>',
		    data: {
				id_branch : id_branch,
				id_service: id_service,
				id_dentist: id_dentist,
				start     : moment(start).format('YYYY-MM-DD'),
				end       : moment(end).format('YYYY-MM-DD'),
				len       : len,
				chair_type:chair_type,
		    },
		});

		$('#book_tt').html('<?php echo Yii::t("translate","week"); ?>  ' + week + ' - <?php echo Yii::t("translate","month"); ?>  ' + month + ' - <?php echo Yii::t("translate","year"); ?>  ' + year);

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

			$('.cal-loading').fadeOut('slow');

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

				m 			= main.split("-");

				var dentist_name = $('#book_dt option:selected').text();
				var service_name = $('#book_sv option:selected').text();
				var branch_name  = $('#book_br option:selected').text();

				note ='';
				if($('#book_dt option:selected').val() != 0)
					note = $('#book_dt option:selected').text();

				var book 		= 	[];

				book.push({
					id_dentist: m[0],
					id_branch : id_branch,
					branch    : branch_name,
					id_service: id_service,
					service   : service_name,
					id_chair  : m[1],
					day       : $(this).data('day'),
					time      : $(this).data('time'),
					len       : m[2],
					chair_type: chair_type,
					note      : note,
				});

				$.ajax({
					url: '<?php echo CController::createUrl('book/sessionBooking'); ?>',
					type: 'post',
					data: {
						book: book,
					},
					success: function(data){
						location.href = '<?php echo $baseUrl."/book/register_info/lang/".$lang; ?>';
					}
				})
			});
		});
	}
/*** table title header day ****/
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
	function createViewDate (date,time,duration){
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
	/***** khoi tao du lieu *****/
		moment.locale('<?php echo $lang; ?>' );
		<?php if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false): ?>
			today = moment();
		var date = today;

	/***** danh sach dich vu theo chi nhanh *****/
		var id_branch = $('#book_br').val();

		<?php if (!$sch): ?>
			getService(id_branch);
			getDentist(id_branch);
		<?php endif ?>

	/***** tao thoi gian dat lich hen *****/
		setTimeout(function (e) {
			id_service = $('#book_sv').val();
			id_dentist = $('#book_dt').val();
			len = $('#book_sv option:selected').data("len");
			createDate(date,id_branch,id_service,id_dentist,len);
		}, 1500);

	/***** datepicker - ngay den kham *****/
		$('.datepicker').datepicker({
			minDate: 0,
			dateFormat: 'dd/mm/yy',
		});
		$('#book_d').val(today.format('DD/MM/YY'));

	/***** change branch - thoi doi chi nhanh *****/
		$('#book_br').change(function() {
			id_branch  = $('#book_br').val();
			getService(id_branch);

			getDentist(id_branch, id_service);

			setTimeout(function (e) {
				id_service = $('#book_sv').val();
				id_dentist = $('#book_dt').val();
				len = $('#book_sv option:selected').data("len");
				createDate(date,id_branch,id_service,id_dentist,len);
			}, 500);
		});

	/***** change service - thay doi dich vu *****/
		$('#book_sv').change(function() {
			id_branch = $('#book_br').val();
			id_service = $('#book_sv').val();
			len = $('#book_sv option:selected').data("len");
			day = date;

			//getDentist(id_branch,id_service);
			createDate(day,id_branch,id_service,'',len);
		});

	/***** change date - thay doi ngay den kham *****/
		$('#book_d').change(function(){
			id_branch  = $('#book_br').val();
			id_service = $('#book_sv').val();
			//id_dentist = $('#book_dt').val();
			len = $('#book_sv option:selected').data("len");
			getdate    = $('#book_d').datepicker('getDate');
			date       = getdate;
			id_dentist = 0;

			createDate(date,id_branch,id_service,id_dentist,len);
		});

	/***** change dentist - thay doi nha sy *****/
		$('#book_dt').change(function() {

			/*id_branch  = $('#book_br').val();
			id_service = $('#book_sv').val();
			len = $('#book_sv option:selected').data("len");
			day        = $('#book_d').datepicker('getDate');
			id_dentist = $('#book_dt').val();

			createDate(day,id_branch,id_service,id_dentist,len);*/
		});

	/***** next week - thoi gian tuan ke tiep ********/
		$('#bk_rt').click(function(){
			id_branch  = $('#book_br').val();
			id_service = $('#book_sv').val();
			id_dentist = $('#book_dt').val();
			len = $('#book_sv option:selected').data("len");
			next       = moment(date).add(1, 'weeks').startOf('isoWeek');
			date       = next;

			createDate(next,id_branch,id_service,id_dentist,len);
		});

	/***** last week - thoi gian tuan truoc ********/
		$('#bk_lt').click(function(){
			id_branch  = $('#book_br').val();
			id_service = $('#book_sv').val();
			id_dentist = $('#book_dt').val();
			len = $('#book_sv option:selected').data("len");
			pre        = moment(date).subtract(1, 'weeks').startOf('isoWeek');
			date       = pre;

			createDate(pre,id_branch,id_service,id_dentist,len);
		});
		<?php else: ?>
			$('#login-customer-modal').css({
				background: 'rgba(128, 128, 128, 0.6)',
			});
			$('.cal-loading').fadeOut('fast');
			$('#login-customer-modal').modal("show");

		<?php endif ?>

		$('#login-customer-modal').on('hidden.bs.modal', function () {
		  	location.href = '<?php echo Yii::app()->params['url_base_http'] ?>';
		})
})
</script>