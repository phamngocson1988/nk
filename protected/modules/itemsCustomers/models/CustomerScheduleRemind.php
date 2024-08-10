<?php

/**
 * This is the model class for table "customer_schedule_remind".
 *
 * The followings are the available columns in table 'customer_schedule_remind':
 * @property string $id
 * @property string $id_customer
 * @property integer $durations
 * @property integer $durations_type
 * @property string $id_author
 * @property integer $status
 * @property string $date_remind
 * @property string $date_remind_time
 * @property integer $isSendSms
 * @property string $created_at
 * @property string $updated_at
 */

class CustomerScheduleRemind extends CActiveRecord {
	#region --- PARAMS
	const ST_ACTIVE = 1;
	const ST_HIDE = 0;

	const TYPE_DATE = 1;
	const TYPE_WEEK = 2;
	const TYPE_MONTH = 3;
	const TYPE_YEAR = 4;

	static $_DURATION_TYPE_NAME = array(
		self::TYPE_DATE => 'Ngày',
		self::TYPE_WEEK => 'Tuần',
		self::TYPE_MONTH => 'Tháng',
		self::TYPE_YEAR => 'Năm'
	);

	static $_DURATION_FORMAT = array(
		self::TYPE_DATE => 'D',
		self::TYPE_WEEK => 'W',
		self::TYPE_MONTH => 'M',
		self::TYPE_YEAR => 'Y'
	);

	static $_DURATION_TYPE = array(self::TYPE_DATE, self::TYPE_WEEK, self::TYPE_MONTH, self::TYPE_YEAR);
	#endregion

	#region --- INIT
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_schedule_remind';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_remind', 'type', 'type' => 'date', 'allowEmpty' => true, 'dateFormat' => 'yyyy-MM-dd', 'dateFormat' => 'yyyy-MM-dd', 'message' => 'Ngày nhắc hẹn không đúng định dạng!'),
			array('durations', 'numerical', 'min' => 0, 'tooSmall' => 'Thời gian nhắc hẹn nhỏ hơn 0'),
			array('durations_type', 'in', 'range' => self::$_DURATION_TYPE, 'message' => "Hình thức nhắc hẹn không đúng định dạng!"),

			array('durations, durations_type, status, isSendSms', 'numerical', 'integerOnly'=>true),
            array('id_customer, id_author', 'length', 'max'=>10),
            array('date_remind, date_remind_time, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_customer, durations, durations_type, id_author, status, date_remind, date_remind_time, isSendSms, created_at, updated_at', 'safe', 'on'=>'search'),
        );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'id_customer' => 'Id Customer',
            'durations' => 'Durations',
            'durations_type' => 'Durations Type',
            'id_author' => 'Id Author',
            'status' => 'Status',
            'date_remind' => 'Date Remind',
            'date_remind_time' => 'Date Remin Time',
            'isSendSms' => 'Is Send Sms',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
        $criteria->compare('id_customer',$this->id_customer,true);
        $criteria->compare('date_remind',$this->date_remind,true);
        $criteria->compare('durations',$this->durations);
        $criteria->compare('durations_type',$this->durations_type);
        $criteria->compare('id_author',$this->id_author,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerScheduleRemind the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	#endregion

	#region --- CAP NHAT NHAC NHO
	public function updateRemind($data) {
		$id_customer = isset($data['id_customer']) ? $data['id_customer'] : false;
		if (!$id_customer) {
			return array('status' => 0, 'error-message' => 'Không có thông tin nhắc hẹn!');
		}

		$customer = Customer::model()->find(array(
			'select' => 'id, last_day',
			'condition' => "id = " . $id_customer
		));

		if (!$customer) {
			return array('status' => 0, 'error-message' => 'Không tồn tại thông tin khách hàng!');
		}

		$remind = CustomerScheduleRemind::model()->findByAttributes(array(
			'id_customer' => $id_customer
		));

		if (!$remind) {
			$remind = new CustomerScheduleRemind();
		}

		$isRemain = isset($data['isRemindSchedule']) ? $data['isRemindSchedule'] : 0;

		if ($remind->isNewRecord == false && $isRemain == self::ST_HIDE) {
			$remind->status = self::ST_HIDE;

			if ($remind->save(false)) {
				return array('status' => 1, 'data' => $remind->attributes);
			}
			return array('status' => 0, 'error-message' => $remind->getErrors());
		}

		$remind->attributes = $data;
		$remind->status = self::ST_ACTIVE;
		$remind->id_author = Yii::app()->user->getState('user_id');
		$remind->date_remind_time = NULL;
		$remind->isSendSms = 1;

		if ($customer->last_day) {
			$durations = $remind->durations;
			$durations_type = $remind->durations_type;

			if (!in_array($durations_type, self::$_DURATION_TYPE)) {
				return array('status' => 0, 'error-message' => "Thời gian không đúng định dạng!");
			}

			$format = self::$_DURATION_FORMAT[$durations_type];

			$date_remind_time = date_format(date_add(date_create($customer->last_day), new DateInterval("P".$durations.$format)), 'Y-m-d');
			$remind->date_remind_time = $date_remind_time;
			$remind->date_remind = $date_remind_time;
		}

		if (!$remind->date_remind || $remind->date_remind == 'Invalid date') {
			$remind->date_remind = NULL;
		}

		unset($remind->created_at);
		unset($remind->updated_at);

		if ($remind->isNewRecord) {
			$remind->created_at = date('Y-m-d H:i:s');
		}

		if ($remind->validate() && $remind->save()) {
			return array('status' => 1, 'data' => $remind->attributes);
		}
		return array('status' => 0, 'error-message' => $remind->getErrors());
	}
	#endregion

	#region --- UPATE LAST DAY REMIND
	public function updateDateRemindTime($id_customer) {
		if (!$id_customer) {
			return array('status' => 0, 'error-message' => 'Không có khách hàng!');
		}

		$customer = Customer::model()->find(array(
			'select' => 'id, last_day',
			'condition' => "id = " . $id_customer
		));

		if (!$customer || !$customer->last_day) {
			return array('status' => 0, 'error-message' => 'Không tồn tại thông tin khách hàng!');
		}

		$remind = CustomerScheduleRemind::model()->findByAttributes(array(
			'id_customer' => $id_customer,
			'status' => self::ST_ACTIVE
		));

		if (!$remind) {
			return array('status' => 0, 'error-message' => 'Không tồn tại thông tin khách hàng!');
		}

		$remind->date_remind_time = NULL;

		$durations = $remind->durations;
		$durations_type = $remind->durations_type;
		$remind->isSendSms = 1;

		if (!in_array($durations_type, self::$_DURATION_TYPE)) {
			return array('status' => 0, 'error-message' => "Thời gian không đúng định dạng!");
		}

		$format = self::$_DURATION_FORMAT[$durations_type];

		$date_remind_time = date_format(date_add(date_create($customer->last_day), new DateInterval("P".$durations.$format)), 'Y-m-d');
		$remind->date_remind_time = $date_remind_time;

		if ($remind->validate() && $remind->save()) {
			return array('status' => 1, 'data' => $remind->attributes);
		}
		return array('status' => 0, 'error-message' => $remind->getErrors());
	}
	#endregion
}