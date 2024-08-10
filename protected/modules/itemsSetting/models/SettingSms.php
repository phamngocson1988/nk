<?php

/**
 * This is the model class for table "setting_sms".
 *
 * The followings are the available columns in table 'setting_sms':
 * @property string $id
 * @property string $name
 * @property string $content
 * @property string $time_start
 * @property integer $type
 * @property integer $active
 * @property string $created_at
 * @property string $updated_at
 */

class SettingSms extends CActiveRecord {
	#region --- PARAMS
	const ST_ACTIVE = 1;
	const ST_UNACTIVE = 0;

	const TYPE_BIRTHDATE = 1;
	const TYPE_SCHEDULE = 2;

	static $_TYPE_NAME = array(
		self::TYPE_BIRTHDATE => 'Tin nhắn sinh nhật',
		self::TYPE_SCHEDULE => 'Tin nhắn nhắc hẹn'
	);

	static $_TYPE_FUNCTION = array(
		self::TYPE_BIRTHDATE => 'Birthdate',
		self::TYPE_SCHEDULE => 'Schedule'
	);

	static $_TYPE = array(self::TYPE_BIRTHDATE, self::TYPE_SCHEDULE);
	#endregion

	#region --- INIT
	public function tableName() {
		return 'setting_sms';
	}

	public function rules() {
		return array(
			array('type, active', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 200),
			array('content', 'length', 'max' => 255),
			array('time_start, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, content, time_start, type, active, created_at, updated_at', 'safe', 'on' => 'search'),
        );
	}

	public function relations() {
		return array();
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'time_start' => 'Time Start',
            'type' => 'Type',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
		);
	}

	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('time_start',$this->time_start,true);
        $criteria->compare('type',$this->type);
        $criteria->compare('active',$this->active);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	#endregion

	#region --- INSERT / UPDATE
	public function upsert($data) {
		$type = isset($data['type']) ? $data['type'] : false;
		if (!$type || !in_array($type, self::$_TYPE)) {
			return array('status' => 0, 'error-message' => 'Thông tin thiết lập không hợp lệ!');
		}

		$setting = SettingSms::model()->findByAttributes(array('type' => $type));
		if (isset($data['id']) && $setting && $data['id'] != $setting->id) {
			return array('status' => 0, 'error-message' => 'Thông tin thiết lập không chính xác!', 'tets' => $setting);
		}

		$hours = isset($data['hours']) ? $data['hours'] : 0;
		$minute = isset($data['minutes']) ? $data['minutes'] : 0;

		if (!$setting) {
			$setting = new SettingSms();
			$setting->created_at = date('Y-m-d H:i:s');
		}

		$setting->attributes = $data;
		$setting->time_start = date_format(date_create(sprintf("%02d", $hours) . ":" . sprintf("%02d", $minute)), 'H:i:s');

		unset($setting->updated_at);

		if ($setting->validate() && $setting->save()) {
			$hours = date_format(date_create($setting->time_start), 'H');
			$minute = date_format(date_create($setting->time_start), 'i');

			$this->addJob("schedule", $setting->active, array(
				'hours' => $hours,
				'minute' => $minute
			), array("'$setting->type'"));

			return array('status' => 1, 'data' => $setting->attributes);
		}
		return array('status' => 0, 'error-message' => $setting->getErrors());
	}
	#endregion

	#region --- CONFIG SEND SMS
	public function configSMSBirthdate() {
		$month = date('m');
		$day = date('d');

		$customerBirthDate = Customer::model()->count("MONTH(birthdate) = '$month' AND DAY(birthdate) = '$day' AND LENGTH(phone) = 10");

		$trans = Yii::app()->db->beginTransaction();

		try {
			$update = Customer::model()->updateAll(array(
				'isSmsBirthdate' => 1
			), "MONTH(birthdate) = '$month' AND DAY(birthdate) = '$day' AND LENGTH(phone) = 10");

			if ($update != $customerBirthDate) {
				throw new Exception("Khách hàng sinh nhật không đúng số lượng", 1);
			}

			$this->addJob("scheduleBirthdate", true, array(), array("'$customerBirthDate-$month-$day'"));

			$trans->commit();
		} catch(Exception $e) {
			$message = $e->getMessage();

			Yii::log("Birthdate! " . $message, "warning", "crontab");
			$trans->rollback();
		}
	}

	public function configSMSSchedule() {
		Yii::log("--- configSMSSchedule!", "info", "crontab");

		try {
			$this->addJob("scheduleRemind", true, array(), array());

		} catch(Exception $e) {
			$message = $e->getMessage();

			Yii::log("Schedule! " . $message, "warning", "crontab");
		}
	}
	#endregion

	#region --- SEND SMS
	public function sendSMSBirthdate($args) {
		$limit = 300;

		try {
			$setting = SettingSms::model()->find(array(
				'select' => 'content',
				'condition' => 'type = ' . self::TYPE_BIRTHDATE. ' AND active = 1'
			));

			if (!$setting) {
				Yii::log("sendSMSBirthdate: Không có thông tin thiết lập", "warning", "crontab");
				return;
			}

			$contentSms = $setting->content;

			$criteria = new CDbCriteria;
			$criteria->select = 'id, fullname, phone, id_branch';
			$criteria->condition = "isSmsBirthdate = 1";
			$criteria->limit = $limit;

			$birthdate = Customer::model()->findAll($criteria);

			if ($birthdate) {
				foreach ($birthdate as $value) {
					$curTime = date('s');
					if ($curTime >= 45) {
						Yii::log("send Birthdate!" . $curTime, "warning", "crontab");
						break;
					}

					$phone = $value->phone;

					if (strlen($phone) != 10) {
						Yii::log("sendSMSBirthdate: Số điện thoại không hợp lệ!" . $curTime, "warning", "crontab");
						$this->updateCustomerSendStatus($value->id);
						continue;
					}

					$smsResult = Sms::model()->sendSms($phone, $contentSms, $value->id_branch, 0, '', $value->id, $value->fullname, 0, Sms::TYPE_AUTO_BIRTHDATE, Sms::SOURCE_SYSTEM);

					if ($smsResult) {
						$this->updateCustomerSendStatus($value->id);
						Yii::log("sendSMSBirthdate: Gửi tin nhắn thành công đến $phone vào lúc $curTime", "info", "crontab");
					} else {
						Yii::log("sendSMSBirthdate: Không gửi được tin nhắn đến khách hàng $phone", "warning", "crontab");
					}
				}
			} else {
				$this->removeJob("scheduleBirthdate", $args);
				Yii::log("sendSMSBirthdate: Ngừng gửi tin nhắn", "warning", "crontab");
			}

		} catch(Exception $e) {
			Yii::log("send Birthdate!" . $e->getMessage(), "error", "crontab");
		}
	}

	public function sendSMSRemind() {
		$limit = 5;

		try {
			$setting = SettingSms::model()->find(array(
				'select' => 'content',
				'condition' => 'type = ' . self::TYPE_SCHEDULE. ' AND active = 1'
			));

			if (!$setting) {
				Yii::log("sendSMSRemind: Không có thông tin thiết lập", "warning", "crontab");
				return;
			}

			$contentSms = $setting->content;

			$criteria = new CDbCriteria;
			$criteria->select = 'id, id_customer, fullname, phone, id_branch, date_remind_time, date_remind';
			$criteria->addCondition("isSendSms = 1");
			$criteria->addCondition("(last_day IS NOT NULL AND date_remind_time = CURDATE()) OR (date_remind = CURDATE())");
			$criteria->limit = $limit;

			$remind = VCustomerScheduleRemind::model()->findAll($criteria);

			if ($remind) {
				foreach ($remind as $key => $value) {
					$curTime = date('s');
					if ($curTime >= 45) {
						Yii::log("send Remind!" . $curTime, "warning", "crontab");
						break;
					}

					$phone = $value->phone;

					if (strlen($phone) != 10) {
						Yii::log("sendSMSRemind: Số điện thoại không hợp lệ! " . $curTime, "warning", "crontab");
						$this->updateRemindSendStatus($value->id);
						continue;
					}

					if ($value->date_remind != null && $value->date_remind != date('Y-m-d')) {
						Yii::log("sendSMSRemind: Chưa tới thời gian nhắc hẹn! " . $curTime, "warning", "crontab");
						continue;
					}

					$smsResult = Sms::model()->sendSms($phone, $contentSms, $value->id_branch, 0, '', $value->id, $value->fullname, 0, Sms::TYPE_AUTO_SCHEDULE, Sms::SOURCE_SYSTEM);

					if ($smsResult) {
						$update = $this->updateRemindSendStatus($value->id);
						Yii::log("sendSMSRemind: Gửi tin nhắn thành công đến $phone vào lúc $curTime $update", "info", "crontab");
					} else {
						Yii::log("sendSMSRemind: Không gửi được tin nhắn đến khách hàng $phone", "warning", "crontab");
					}
				}
			} else {
				$this->removeJob("scheduleRemind");
				Yii::log("sendSMSRemind: Ngừng gửi tin nhắn", "warning", "crontab");
			}

			sleep(10);
		} catch(Exception $e) {
			Yii::log("send Birthdate!" . $e->getMessage(), "error", "crontab");
		}
	}
	#endregion

	#region --- UPDATE SEND STATUS
	private function updateCustomerSendStatus($id_customer) {
		return Customer::model()->updateByPk($id_customer, array('isSmsBirthdate' => 0));
	}

	private function updateRemindSendStatus($id) {
		return CustomerScheduleRemind::model()->updateByPk($id, array('isSendSms' => 0));
	}
	#endregion

	#region --- ADD JOB
	private function addJob($controller, $active = false, $time = array(), $params = array()) {
		$curJob = -1;
		$params1 = (!empty($params)) ? $params[0] : '';

		$cron = new Crontab('my_crontab');

		$jobs = $cron->getJobs();
		foreach($jobs as $key => $job) {
			$command = $job->getCommand();
			if (strpos($command, $controller) !== false && strpos($command, $params1) !== false) {
				$curJob = $key;
				break;
			}
		}

		if ($curJob > -1) {
			$cron->removeJob($curJob);
		}

		if ($active == self::ST_ACTIVE) {
			$hours = isset($time['hours']) ? $time['hours'] : '*';
			$minute = isset($time['minute']) ? $time['minute'] : '*';
			$day = isset($time['day']) ? $time['day'] : '*';

			$job = new CronApplicationJob('yiicmd', $controller, array(), $minute, $hours, $day);
			$job->setParams(array($params1));
			$cron->add($job);
		}

		$cron->saveCronFile();
		$cron->saveToCrontab();
	}
	#endregion

	#region --- REMOVE JOB
	private function removeJob($controller, $args = '') {
		$curJob = -1;

		$cron = new Crontab('my_crontab');

		$jobs = $cron->getJobs();
		foreach($jobs as $key => $job) {
			$command = $job->getCommand();
			if (strpos($command, $controller) !== false) {
				if (!$argc || ($args && strpos($command, $args) !== false)) {
					$curJob = $key;
				}
				break;
			}
		}

		if ($curJob > -1) {
			$cron->removeJob($curJob);
		}

		$cron->saveCronFile();
		$cron->saveToCrontab();
	}
	#endregion
}