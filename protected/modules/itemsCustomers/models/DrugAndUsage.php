<?php

/**
 * This is the model class for table "drug_and_usage".
 *
 * The followings are the available columns in table 'drug_and_usage':
 * @property integer $id
 * @property integer $id_prescription
 * @property string $drug_name
 * @property integer $times
 * @property integer $dosage
 */
class DrugAndUsage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'drug_and_usage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_prescription, drug_name, times, dosage', 'required'),
			array('id_prescription, times', 'numerical', 'integerOnly'=>true),
			array('drug_name, dosage', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_prescription, drug_name, times, dosage', 'safe', 'on'=>'search'),
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
			'id_prescription' => 'Id Prescription',
			'drug_name' => 'Drug Name',
			'times' => 'Times',
			'dosage' => 'Dosage',
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
		$criteria->compare('id_prescription',$this->id_prescription);
		$criteria->compare('drug_name',$this->drug_name,true);
		$criteria->compare('times',$this->times);
		$criteria->compare('dosage',$this->dosage);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DrugAndUsage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
