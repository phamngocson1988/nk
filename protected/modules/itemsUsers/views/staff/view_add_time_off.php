<?php
	if(isset($record_time_off) && $record_time_off)
	{?>
<li id="time_off_<?php echo $record_time_off['id'] ?>" class="new-timeoff-list-li" onclick="show_update(<?php echo $record_time_off['id'] ?>)">
	<div class="row-fluid">
		<input id="<?php echo $record_time_off['id'] ?>" type="hidden" value="<?php echo $record_time_off['id'] ?>"></input>
		<div class="col-md-1">
			<div class="timeoff-icon-holder">
				<i class="glyphicon glyphicon-calendar"></i>
			</div>
		</div>
		<div class="col-md-11">
			<div class="new-timeoff-details-holder">
				<span style="color: #455862;font-size: 15px;">
					<input id="start_off_<?php echo $record_time_off['id'] ?>" type="hidden" value="<?php echo $record_time_off['start_time']; ?>"></input>
					<?php echo date_format(date_create($record_time_off['start_time']),'d/m/Y'); ?>
				</span>
				<span style="padding: 5px"> đến</span>
				<span style="color: #455862;font-size: 15px;">
					<input id="end_off_<?php echo $record_time_off['id'] ?>" type="hidden" value="<?php echo $record_time_off['end_time']; ?>"></input>
					<?php echo date_format(date_create($record_time_off['end_time']),'d/m/Y'); ?>
				</span>
				<div class="timeoff-list-details-noteslabel">
					<input id="note_off_<?php echo $record_time_off['id'] ?>" type="hidden" value="<?php echo $record_time_off['note']; ?>"></input>
					<?php echo $record_time_off['note']; ?></div>
			</div>
		</div>
		<div class="clear-fix" style="clear: both;"></div>
	</div>
</li>
	<?php }
?>
