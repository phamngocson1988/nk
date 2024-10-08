<?php

/**
 * This is the model class for table "product_line".
 *
 * The followings are the available columns in table 'product_line':
 * @property integer $id
 * @property integer $id_product_type
 * @property string $name
 * @property string $description
 * @property integer $status_proline
 * @property integer $status_hiden
 */
class ProductLine extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_line';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product_type', 'required'),
			array('id_product_type, status_proline, status_hiden', 'numerical', 'integerOnly'=>true),
			array('name, name_en', 'length', 'max'=>384),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_product_type, name,name_en, description, status_proline, status_hiden', 'safe', 'on'=>'search'),
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
			'rel_type' => array(self::BELONGS_TO,'ProductType','id_product_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_product_type' => 'Id Product Type',
			'name' => 'Name',
			'name_en'=>'Name en',
			'description' => 'Description',
			'status_proline' => 'Status Proline',
			'status_hiden' => 'Status Hiden',
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
		$criteria->compare('id_product_type',$this->id_product_type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status_proline',$this->status_proline);
		$criteria->compare('status_hiden',$this->status_hiden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductLine the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
