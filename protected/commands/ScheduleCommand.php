<?php

class ScheduleCommand extends CConsoleCommand {
    public function run($args) {
        Yii::log("------ ScheduleCommand", 'info', "crontab");

        $this->schedulerSMS($args[0]);
    }

    #region --- SETTING SEND BY DATE
	public function schedulerSMS($type) {
		if (!in_array($type, SettingSms::$_TYPE)) {
			Yii::log("SettingAutoSMS: Loại tin nhắn không hợp lệ!", "error", "crontab");
		}

		try {
			$function = "configSMS".SettingSms::$_TYPE_FUNCTION[$type];
            SettingSms::model()->$function();

		} catch(Exception $e) {
			Yii::log("SettingAutoSMS: Có lỗi xảy ra!" . CJSON::encode($e), "error", "crontab");
		}
	}
	#endregion
}