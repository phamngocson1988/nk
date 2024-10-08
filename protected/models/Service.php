<?php

/**
 * This is the model class for table "p_service".
 *
 * The followings are the available columns in table 'p_service':
 * @property integer $id
 * @property integer $id_service_type
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $content
 * @property string $createdate
 * @property integer $status_hiden
 * @property integer $status
 */
class Service extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_service_type, name, createdate', 'required'),
			array('id_service_type, status_hiden, status', 'numerical', 'integerOnly'=>true),
			array('name, image', 'length', 'max'=>255),
			array('description', 'length', 'max'=>500),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_service_type, name, image, description, content, createdate, status_hiden, status', 'safe', 'on'=>'search'),
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
			'id_service_type' => 'Id Service Type',
			'name' => 'Name',
			'image' => 'Image',
			'description' => 'Description',
			'content' => 'Content',
			'createdate' => 'Createdate',
			'status_hiden' => 'Status Hiden',
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
		$criteria->compare('id_service_type',$this->id_service_type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('status_hiden',$this->status_hiden);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Service the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function service_details($id) {
		return Service::model()->findByAttributes(array('id'=>$id));

	}
	public function service_total_view()
	{	
		$con = Yii::app()->db;
		$sql="SELECT * from p_service  order by total_view DESC LIMIT 4";
		$data = $con->createCommand($sql)->queryAll();
        return $data;
	}

	
}
