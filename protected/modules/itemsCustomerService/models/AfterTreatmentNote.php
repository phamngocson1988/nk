<?php

/**
 * This is the model class for table "after_treatment_note".
 *
 * The followings are the available columns in table 'after_treatment_note':
 * @property integer $id
 * @property integer $id_customer
 * @property string $create_date
 * @property string $cs_time
 * @property string $feedback
 * @property string $quality
 * @property string $next_schedule
 * @property string $next_schedule_time
 * @property string $ref_customer
 * @property string $ref_customer_code
 * @property string $note
 * @property string $customer_fullname
 * @property string $diagnose
 * @property string $diagnose_doctor
 * @property string $treatment
 * @property string $treatment_doctor
 * @property string $no_treatment
 * @property string $no_treatment_doctor
 * @property string $partner
 */
class AfterTreatmentNote extends CActiveRecord
{
	public $appointmentList = array(
		'1'  => 'Kết thúc điều trị',
		'2'  => 'Tự liên lạc',
		'3'  => 'Có hẹn',
	);

	public $serviceCustomer = array(
		'KM'  => 'Khách mới',
		'DTT'  => 'Đang điều trị',
		'TK'  => 'Tái khám',
	);

	public $listQuality = array(
        'T' => 'TÌNH TRẠNG KHÁCH ỔN',
        'KLLD' => 'KHÔNG LIÊN LẠC ĐƯỢC',
        'TD' => 'KHÁCH HÀNG ĐAU Ê, THEO DÕI THÊM',
        'PN' => 'KHÁCH HÀNG PHÀN NÀN',
    );    

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'after_treatment_note';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_customer, create_date', 'required'),
			array('id, id_customer, appointment, code_number', 'numerical', 'integerOnly'=>true),
			array('cs_time, feedback, quality, next_schedule, next_schedule_time, ref_customer, ref_customer_code, note, service_code, code_number, customer_fullname, diagnose, diagnose_doctor, treatment, treatment_doctor, no_treatment, no_treatment_doctor, partner', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_customer, create_date, cs_time, feedback, quality, appointment, next_schedule, next_schedule_time, ref_customer, ref_customer_code, note, service_code, code_number, customer_fullname, diagnose, diagnose_doctor, treatment, treatment_doctor, no_treatment, no_treatment_doctor, partner', 'safe', 'on'=>'search'),
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
			'service_code' => 'Service code',
			'id_customer' => 'Id Customer',
			'code_number' => 'Code number',
			'create_date' => 'Create date',
			'cs_time' => 'Cs time',
			'feedback' => 'Feedback',
			'quality' => 'Quality',
			'appointment' => 'Appointment',
			'next_schedule' => 'Next schedule',
			'next_schedule_time' => 'Next schedule time',
			'ref_customer' => 'Reference Customer',
			'ref_customer_code' => 'Reference Customer Code',
			'note' => 'Note',
			'customer_fullname' => 'Customer fullname',
			'diagnose' => 'Diagnose',
			'diagnose_doctor' => 'Diagnose doctor',
			'treatment' => 'Treatment',
			'treatment_doctor' => 'Treatment doctor',
			'no_treatment' => 'No treatment',
			'no_treatment_doctor' => 'No treatment doctor',
			'partner' => 'Partner',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('service_code',$this->service_code);
		$criteria->compare('id_customer',$this->id_customer);
		$criteria->compare('id_group_history',$this->id_group_history);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('cs_time',$this->cs_time);
		$criteria->compare('feedback',$this->feedback);
		$criteria->compare('quality',$this->quality);
		$criteria->compare('appointment',$this->appointment);
		$criteria->compare('next_schedule',$this->next_schedule);
		$criteria->compare('next_schedule_time',$this->next_schedule_time);
		$criteria->compare('ref_customer',$this->ref_customer);
		$criteria->compare('ref_customer_code',$this->ref_customer_code);
		$criteria->compare('note',$this->note);
		$criteria->compare('code_number',$this->code_number);
		$criteria->compare('customer_fullname',$this->customer_fullname);
		$criteria->compare('diagnose',$this->diagnose);
		$criteria->compare('diagnose_doctor',$this->diagnose_doctor);
		$criteria->compare('treatment',$this->treatment);
		$criteria->compare('treatment_doctor',$this->treatment_doctor);
		$criteria->compare('no_treatment',$this->no_treatment);
		$criteria->compare('no_treatment_doctor',$this->no_treatment_doctor);
		$criteria->compare('partner',$this->partner);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Labo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function updateNote($id, $service_code, $cs_time, $feedback, $quality, $appointment, $next_schedule, $next_schedule_time, $ref_customer, $ref_customer_code, $note, $code_number, $customer_fullname, $diagnose, $diagnose_doctor, $treatment, $treatment_doctor, $no_treatment, $no_treatment_doctor, $partner) {
		if ($id) {
			$model = AfterTreatmentNote::model()->findByPk($id);
			$model->service_code = $service_code;
			$model->cs_time = $cs_time;
			$model->feedback = $feedback;
			$model->quality = $quality;
			$model->appointment = $appointment;
			$model->next_schedule = $next_schedule;
			$model->next_schedule_time = $next_schedule_time;
			$model->ref_customer = $ref_customer;
			$model->ref_customer_code = $ref_customer_code;
			$model->note = $note;
			$model->code_number = $code_number;
			$model->customer_fullname = $customer_fullname;
			$model->diagnose = $diagnose;
			$model->diagnose_doctor = $diagnose_doctor;
			$model->treatment = $treatment;
			$model->treatment_doctor = $treatment_doctor;
			$model->no_treatment = $no_treatment;
			$model->no_treatment_doctor = $no_treatment_doctor;
			$model->partner = $partner;
			if ($model->validate() && $model->save()) {
				return 1;
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}
}
