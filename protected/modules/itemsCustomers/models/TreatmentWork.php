<?php

/**
 * This is the model class for table "treatment_work".
 *
 * The followings are the available columns in table 'treatment_work':
 * @property integer $id
 * @property integer $id_medical_history
 * @property string $treatment_work
 * @property string $tooth_numbers
 */
class TreatmentWork extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'treatment_work';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_medical_history, treatment_work', 'required'),
			array('id_medical_history', 'numerical', 'integerOnly'=>true),
			array('treatment_work, tooth_numbers', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_medical_history, treatment_work, tooth_numbers', 'safe', 'on'=>'search'),
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
			'id_medical_history' => 'Id Medical History',
			'treatment_work' => 'Treatment Work',
			'tooth_numbers' => 'Tooth Numbers',
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
		$criteria->compare('id_medical_history',$this->id_medical_history);
		$criteria->compare('treatment_work',$this->treatment_work,true);
		$criteria->compare('tooth_numbers',$this->tooth_numbers,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TreatmentWork the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
