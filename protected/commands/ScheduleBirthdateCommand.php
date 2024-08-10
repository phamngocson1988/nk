<?php

class ScheduleBirthdateCommand extends CConsoleCommand {
    public function run($args) {
		Yii::log("------ ScheduleBirthdateCommand", 'info', "crontab");
		SettingSms::model()->sendSMSBirthdate($args[0]);
	}
}
