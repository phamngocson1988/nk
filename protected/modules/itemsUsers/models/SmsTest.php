<?php

/**
 * This is the model class for table "sms_test".
 *
 * The followings are the available columns in table 'sms_test':
 * @property integer $id
 * @property string $id_sms
 * @property integer $id_author
 * @property string $author
 * @property integer $id_customer
 * @property string $customer
 * @property string $phone
 * @property string $content
 * @property string $create_date
 * @property integer $type
 * @property string $id_schedule
 * @property integer $id_branch
 * @property integer $source
 * @property integer $status
 * @property integer $flag
 */
class SmsTest extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sms_test';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_author, id_customer, type, id_branch, source, status, flag', 'numerical', 'integerOnly'=>true),
			array('id_sms, author, customer, content', 'length', 'max'=>255),
			array('phone, id_schedule', 'length', 'max'=>20),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_sms, id_author, author, id_customer, customer, phone, content, create_date, type, id_schedule, id_branch, source, status, flag', 'safe', 'on'=>'search'),
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
			'id_sms' => 'Id Sms',
			'id_author' => 'Id Author',
			'author' => 'Author',
			'id_customer' => 'Id Customer',
			'customer' => 'Customer',
			'phone' => 'Phone',
			'content' => 'Content',
			'create_date' => 'Create Date',
			'type' => 'Type',
			'id_schedule' => 'Id Schedule',
			'id_branch' => 'Id Branch',
			'source' => 'Source',
			'status' => 'Status',
			'flag' => 'Flag',
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
		$criteria->compare('id_sms',$this->id_sms,true);
		$criteria->compare('id_author',$this->id_author);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('id_customer',$this->id_customer);
		$criteria->compare('customer',$this->customer,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('id_schedule',$this->id_schedule,true);
		$criteria->compare('id_branch',$this->id_branch);
		$criteria->compare('source',$this->source);
		$criteria->compare('status',$this->status);
		$criteria->compare('flag',$this->flag);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmsTest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
