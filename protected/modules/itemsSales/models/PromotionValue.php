<?php

/**
 * This is the model class for table "promotion_value".
 *
 * The followings are the available columns in table 'promotion_value':
 * @property integer $id
 * @property integer $id_promotion
 * @property integer $type_value
 * @property double $start_value
 * @property double $end_value
 * @property double $percent_value
 */
class PromotionValue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promotion_value';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_promotion, type_value', 'numerical', 'integerOnly'=>true),
			array('start_value, end_value, percent_value', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_promotion, type_value, start_value, end_value, percent_value', 'safe', 'on'=>'search'),
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
			'id_promotion' => 'Id Promotion',
			'type_value' => 'Type Value',
			'start_value' => 'Start Value',
			'end_value' => 'End Value',
			'percent_value' => 'Percent Value',
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
		$criteria->compare('id_promotion',$this->id_promotion);
		$criteria->compare('type_value',$this->type_value);
		$criteria->compare('start_value',$this->start_value);
		$criteria->compare('end_value',$this->end_value);
		$criteria->compare('percent_value',$this->percent_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PromotionValue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getvalue($id){
		
    	$con = Yii::app()->db;
    	$sql ="select * from promotion_value where id_promotion = ".$id;
    	$data = $con->createCommand($sql)->queryAll();
    	return $data;
	}
}
