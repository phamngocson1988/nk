<div id="alert-success" style="position: fixed;top: 50px;right: 0px;"></div>

<?php /*
<input id="id_quotation" type="hidden" value="<?php echo $model->checkNewestTreatmentExistQuotation($model->id);?>">
*/ ?>

<div class="appointmentsTabContent tabContentHolder">

	<div id="appointmentOverAllDetails" class="appointmentDetails pull-right">		
		<span class="fl" style="margin-right: 10px;">
			<?php if($list_schedule == 0) echo $list_schedule; else echo count($list_schedule);?>  lịch hẹn 
			<span class=""></span>
		</span>
		<span class="fl" style=" margin-top: -11px;margin-right: 10px;" data-original-title="" title="">
			<a class="btn_plus create_appt" id="createAppt"></a>
		</span>	
	</div>
	<div class="clearfix"></div>

	<div class="appointmentListHolder">
		<ul id="appointmentList" class="appointmentList">
			<?php 
			$nodata = 0;
			$now = date('Y-m-d');
			if(!empty($list_schedule)) {
				foreach($list_schedule as $l_s) {
					$status = array();
					$status = $sch->status_arr;
					$color = $sch->getColorSch($l_s['status']);
				?>

				<li id="s<?php echo $l_s['id'];?>" class="hasHoverStyles" style="margin-bottom:15px;border-left: 2px solid <?php echo $color;?>;">
					<span class="fl appointment_status_icon" style="margin: 10px 1px 0 7px;"><i class="fa fa-calendar"></i>  </span>
					<div class="fl" style="width:77%;">
						<h2 style="font-weight: normal;font-size: 16px;margin-bottom: 10px;"><?php echo date('d/m/Y H:i:s',strtotime($l_s['start_time']));?> - <?php echo date('H:i:s',strtotime($l_s['end_time']));?></h2>
						<label style="font-weight: normal;line-height: 7px;">
							<div style="width: 100%;padding: 0px;margin-top: 2px;">
								<span class="fl" style="margin-bottom: 4px; display: inline-block;width: 85px;">Dịch vụ</span>
								<span style="display: inline-block;">: <?php echo $l_s['name_service'];?></span>
							</div>
							<br>
							<div style="width: 100%;padding: 0px;margin-top: 3px;">
								<span style="display: inline-block;width: 85px;">Bác sỹ</span>
								<span>: <?php echo $l_s['name_dentist']; ?></span>
							</div>
						</label>
					</div>

	            <?php
					echo CHtml::dropDownList('status_schedule','',$status,array('onchange'=>'updateStatusSchedule('.$l_s['id'].','.$l_s['id_customer'].','.$l_s['id_dentist'].');','class'=>'form-control custProfileInput yellow_hover blue_focus fl','id'=>'status_schedule_'.$l_s['id'],'style'=>'width:121px;','options'=>array($l_s['status']=>array('selected'=>true))));
					?>
					<div class="clearfix"></div>
				</li>
			<?php  }}
				else { $nodata = 1; }				
			?>
		</ul>
		<?php if($nodata){ ?>
			<div class="no-data" style="display: table-cell; vertical-align: middle;text-align: center;">
				<div style="text-align: center;">
					<img src="<?php Yii::app()->params['image_url']; ?>/images/no-data.png" style="width:200px; height: auto;"><br>
					<p style="color: #464646; font-size: 15px;">Không có dữ liệu !</p>
				</div>
			</div>
		<?php } ?>
	</div>
</div>