<?php

/**
 * This is the model class for table "payable_receiver".
 *
 * The followings are the available columns in table 'payable_receiver':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $in_words
 * @property string $description
 * @property integer $status
 */
class PaReceiver extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pa_receiver';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description', 'required', 'message'=>"{attribute} không được để trống!"),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name, address, in_words', 'length', 'max'=>100),
			array('phone', 'length', 'max'=>20),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, phone, address, in_words, description, status', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'phone' => 'Phone',
			'address' => 'Address',
			'in_words' => 'In Words',
			'description' => 'Description',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('in_words',$this->in_words,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PayableReceiver the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
