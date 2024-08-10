<?php

/**
 * This is the model class for table "v_customer_schedule_remind".
 *
 * The followings are the available columns in table 'v_customer_schedule_remind':
 * @property string $id
 * @property string $id_customer
 * @property string $code_number
 * @property string $fullname
 * @property integer $id_branch
 * @property string $phone
 * @property string $last_day
 * @property string $date_remind
 * @property integer $durations
 * @property integer $durations_type
 * @property string $date_remind_time
 * @property integer $isSendSms
 */

class VCustomerScheduleRemind extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_customer_schedule_remind';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('id_branch, durations, durations_type, isSendSms', 'numerical', 'integerOnly'=>true),
            array('id, id_customer', 'length', 'max'=>10),
            array('code_number', 'length', 'max'=>30),
            array('fullname', 'length', 'max'=>255),
            array('phone', 'length', 'max'=>20),
            array('last_day, date_remind, date_remind_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_customer, code_number, fullname, id_branch, phone, last_day, date_remind, durations, durations_type, date_remind_time, isSendSms', 'safe', 'on'=>'search'),
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
            'code_number' => 'Code Number',
            'fullname' => 'Fullname',
            'id_branch' => 'Id Branch',
            'phone' => 'Phone',
            'last_day' => 'Last Day',
            'date_remind' => 'Date Remind',
            'durations' => 'Durations',
            'durations_type' => 'Durations Type',
            'date_remind_time' => 'Date Remind Time',
            'isSendSms' => 'Is Send Sms',
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
        $criteria->compare('code_number',$this->code_number,true);
        $criteria->compare('fullname',$this->fullname,true);
        $criteria->compare('id_branch',$this->id_branch);
        $criteria->compare('phone',$this->phone,true);
        $criteria->compare('last_day',$this->last_day,true);
        $criteria->compare('date_remind',$this->date_remind,true);
        $criteria->compare('durations',$this->durations);
        $criteria->compare('durations_type',$this->durations_type);
        $criteria->compare('date_remind_time',$this->date_remind_time,true);
        $criteria->compare('isSendSms',$this->isSendSms);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VCustomerScheduleRemind the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
