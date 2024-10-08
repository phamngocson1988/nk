<?php

/**
 * This is the model class for table "cs_schedule_relax".
 *
 * The followings are the available columns in table 'cs_schedule_relax':
 * @property integer $id
 * @property integer $id_time_work
 * @property integer $id_dentist
 * @property integer $dow
 * @property string $start
 * @property string $end
 * @property integer $status
 */
class CsScheduleRelax extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cs_schedule_relax';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_time_work, id_dentist, dow, status', 'numerical', 'integerOnly'=>true),
			array('start, end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_time_work, id_dentist, dow, start, end, status', 'safe', 'on'=>'search'),
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
			'id_time_work' => 'Id Time Work',
			'id_dentist' => 'Id Dentist',
			'dow' => 'Dow',
			'start' => 'Start',
			'end' => 'End',
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
		$criteria->compare('id_time_work',$this->id_time_work);
		$criteria->compare('id_dentist',$this->id_dentist);
		$criteria->compare('dow',$this->dow);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CsScheduleRelax the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function insertTimeRelax($id_dentist,$id_branch,$dow,$time_start,$time_end)
	{
		$relax_record = new CsScheduleRelax();
		$relax_record->id_dentist = $id_dentist;
		$relax_record->id_branch = $id_branch;
		$relax_record->dow = $dow;
		$relax_record->start = $time_start;
		$relax_record->end = $time_end;

		$relax_record->save(false);
		return $relax_record;
	}

	public function updateStatus($status,$id_dentist,$dow)
	{
		$command = Yii::app()->db->createCommand();
		$command->update('cs_schedule_relax',array('status'=>$status),'id_dentist=:x AND dow=:y',array(':x'=>$id_dentist,':y'=>$dow));
	}
	public function insertNewStaff($id_dentist,$start,$end,$id_branch)
	{
		$command = Yii::app()->db->createCommand();
		for($i=1;$i<=6;$i++){
			$command->insert('cs_schedule_relax',array(
				'id_dentist'=>$id_dentist,
				'dow'=>$i,
				'start'=>$start,
				'end'=>$end,
				'id_branch'=>$id_branch,
				)
			);
		}
	}
}
