<?php

class ScheduleRemindCommand extends CConsoleCommand {
    public function run($args) {
		Yii::log("------ ScheduleRemindCommand", 'info', "crontab");

		SettingSms::model()->sendSMSRemind();
	}
}
