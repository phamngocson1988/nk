<style>
.btn {
color: black;
}
.profile_schedule {padding: 15px;}
#pf-AddSch {padding: 10px; margin-right: 5px;}
#pf_numSch {color: black;}
#sch_info {padding-top: 15px;}
.sch_icon {
	margin: 2px 0 0 6px;
    border: 1px solid #ccc;
    border-radius: 100%;
    height: 40px;
    text-align: center;
    width: 40px;
    padding: 6px 7px
}
#listSch li {
	margin-top: 10px;

}
#listSch li:hover {
	box-shadow: 3px 3px 7px lightgrey;
	border-top: 1px solid #ccc;
}
.lb0 {background: rgba(184, 59, 59, 0.74902);}
.lb4 {background: rgb(219, 207, 66);}
#sch_status {padding-top: 8px;}
</style>

<div class="profile_schedule">
	<div id="sch_new">								
		<button class="btn btn-default" id="pf-AddSch" type="button"><span class="fa fa-plus"></span></button> <!-- onclick="addSch()" -->
		<span id="pf_numSch" style="text-transform: lowercase;"><?php if($listSch==0) echo $listSch; else echo count($listSch);?> <?php echo Yii::t('translate','appointment'); ?> </span>
		<div id="apptLoading" class="loading"></div>
		<div class="clearfix"></div>
	</div>

	<div id="sch_info">
		<ul class="list-unstyled" id="listSch">
			<?php $new = 1;
				if (!$listSch): ?>
				<li><?php echo Yii::t('translate','book_no_data'); ?></li>

			<?php else: 
				$sch = new CsSchedule();
				
				$text  = $sch->status_arr;
			?>

				<?php foreach ($listSch as $key => $val):
					$col = CsSchedule::model()->getColorSch($val['status']);
					if($val['status'] == 1) $new = 0;
				?>
					<li class="col-xs-12" style="border-left: 5px solid <?php echo $col; ?>">
						<div class="col-xs-2 col-sm-1" style="padding: 0">
							<span class="sch_icon pull-left"><i class="fa fa-calendar"></i></span>
						</div>
						<div class="sch_detail col-xs-10 col-sm-9">
							<div class="sch_time"><b><?php echo date('H:i:s d/m/Y',strtotime($val['start_time'])); ?> - <?php //echo date('H:i:s',strtotime($val['end_time']));?></b></div>
							<div class="sch_dt"><?php echo Yii::t('translate','book_info_dentist'); ?>: <?php echo $val['name_dentist']; ?></div>
						</div>
						<div class="col-xs-6 col-sm-2 text-right hidden" id="sch_status" style="margin-top: 10px;">
							<?php if ($val['status'] == 1 || $val['status'] == 7): ?>
								<button type="button"><a href="<?php //echo Yii::app()->getBaseUrl().'book/'; ?>"> Dời lịch</a></button>
								<!-- <select name="" class="form-control actionSch" id="actSch" onchange="changeSch(<?php //echo $val['id']; ?>)">
									<option value="0">Chọn</option>
									<option value="1">Dời lịch</option>
									<option value="2">Hủy lịch</option>
								</select> -->
							<?php else: ?>
							<span class="label" style="background: <?php echo $col; ?>"><?php echo $text[$val['status']]; ?></span>
							<?php endif ?>
						</div>
					</li> 
				<?php endforeach ?>
			<?php endif ?>
		</ul>
	</div>
</div>

<!-- Modal -->
  <div class="modal" id="info-pop" role="dialog" style="display: none; padding-top: 15%;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title" id="info-head">Modal Header</h5>
        </div>
        <div class="modal-body" id="info-content">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
        	<span id="sch_act"></span>
          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        </div>
      </div>
      
    </div>
  </div>

<script>
schNew = <?php echo $new; ?>;
function addSch() {
	/*if(!schNew) {
		$('#info-head').text('Thông báo!');
		$('#info-content').text('Bạn có lịch hẹn mới. Tiếp tục đặt lịch?');
		$('#sch_act').html('<a href="<?php //echo Yii::app()->getBaseUrl(); ?>/book" class="btn btn-default">Xác nhận</a>');
		$('#info-pop').modal();
	}
	else*/
		location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/book';
}

function changeSch(id_sch) {
	act = $(this).val();
	console.log(act);
	if(act == 1) {	// doi lich
		$('.actionSch').val(0);
		location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/book';
	}
	else if (act == 2) {	// huy lich
		$('.actionSch').val(0);
		$('#info-head').text('Thông báo!');
		$('#info-content').text('Bạn có muốn hủy lịch hẹn này không?');
		$('#sch_act').html('<button type="button" class="btn btn-default" id="sch_cancel" onclick="cancelSch('+id_sch+')">Xác nhận</button>');
		$('#info-pop').modal("show");
	}
}

function cancelSch(id_sch) {
	$.ajax({ 
        type     :  "POST",
        url      :  "<?php echo CController::createUrl('book/cancelSchedule')?>",
        data     :  {
        	id_sch : id_sch,
        },
        success: function (data) {
        	$('#info-head').text('Thông báo!');
        	$('#sch_act').html('');
        	if(data == -1) {
				$('#info-content').text('Không tồn tại mã lịch hẹn!');
        	}
        	if(data == 0) {
        		$('#info-content').text('Có lỗi xảy ra! Vui lòng thử lại!');
        	}
        	if(data == 1) {
        		$('#info-content').text('Đã hủy lịch hẹn!');
        		location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/profile';
        	}
        	$('#info-pop').modal();
        }
    });
}
</script>