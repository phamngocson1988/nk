<?php

/**
 * This is the model class for table "customer_relation_social".
 *
 * The followings are the available columns in table 'customer_relation_social':
 * @property integer $id
 * @property string $customer_1
 * @property string $customer_2
 * @property integer $id_relation
 * @property integer $status
 */
class CustomerRelationSocial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_relation_social';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_relation, status', 'numerical', 'integerOnly'=>true),
			array('customer_1', 'length', 'max'=>255),
			array('customer_2', 'length', 'max'=>225),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_1, customer_2, id_relation, status', 'safe', 'on'=>'search'),
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
			'customer_1' => 'Customer 1',
			'customer_2' => 'Customer 2',
			'id_relation' => 'Id Relation',
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
		$criteria->compare('customer_1',$this->customer_1,true);
		$criteria->compare('customer_2',$this->customer_2,true);
		$criteria->compare('id_relation',$this->id_relation);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerRelationSocial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
