<?php

/**
 * This is the model class for table "order_recipient".
 *
 * The followings are the available columns in table 'order_recipient':
 * @property integer $id
 * @property integer $id_order
 * @property string $phone_recipient
 * @property string $name_recipient
 * @property string $address_recipient
 * @property string $email_recipient
 * @property string $create_date
 * @property integer $status
 */
class OrderRecipient extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_recipient';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id_order',  'required'),
			array('id_order,id_customer, status', 'numerical', 'integerOnly'=>true),
			array('phone_recipient', 'length', 'max'=>20),
			array('name_recipient, address_recipient, email_recipient', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_order,id_customer, phone_recipient, name_recipient, address_recipient, email_recipient, create_date, status', 'safe', 'on'=>'search'),
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
			'id_order' => 'Id Order',
			'id_customer' => 'Id Customer',
			'phone_recipient' => 'Phone Recipient',
			'name_recipient' => 'Name Recipient',
			'address_recipient' => 'Address Recipient',
			'email_recipient' => 'Email Recipient',
			'create_date' => 'Create Date',
			'status' => 'Status',
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
		$criteria->compare('id_order',$this->id_order);
		$criteria->compare('id_customer',$this->id_customer);
		$criteria->compare('phone_recipient',$this->phone_recipient,true);
		$criteria->compare('name_recipient',$this->name_recipient,true);
		$criteria->compare('address_recipient',$this->address_recipient,true);
		$criteria->compare('email_recipient',$this->email_recipient,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderRecipient the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
