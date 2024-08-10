<?php

/**
 * This is the model class for table "p_infrastructure".
 *
 * The followings are the available columns in table 'p_infrastructure':
 * @property integer $id
 * @property integer $id_type
 * @property string $title
 * @property string $content
 * @property string $date_upload
 * @property integer $status_hidden
 */
class PInfrastructure extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_infrastructure';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_type, title, content, content_en', 'required'),
			array('id_type, status_hidden', 'numerical', 'integerOnly'=>true),
			array('title, title_en', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_type, title, title_en, content,content_en, date_upload, status_hidden', 'safe', 'on'=>'search'),
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
			'id_type' => 'Id Type',
			'title' => 'Title',
			'title_en'=>'Title En',
			'content' => 'Content',
			'content_en'=>'Content En',
			'date_upload' => 'Date Upload',
			'status_hidden' => 'Status Hidden',
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
		$criteria->compare('id_type',$this->id_type);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('title_en',$this->title,true);
		$criteria->compare('content_en',$this->content,true);
		$criteria->compare('date_upload',$this->date_upload,true);
		$criteria->compare('status_hidden',$this->status_hidden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PInfrastructure the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
