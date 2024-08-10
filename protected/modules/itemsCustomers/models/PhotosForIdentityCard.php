<?php

/**
 * This is the model class for table "photos_for_identity_card".
 *
 * The followings are the available columns in table 'photos_for_identity_card':
 * @property integer $id
 * @property integer $id_customer
 * @property string $name
 * @property string $created_at
 */
class PhotosForIdentityCard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'photos_for_identity_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_customer, name', 'required'),
			array('id_customer', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_customer, name, created_at', 'safe', 'on'=>'search'),
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
			'id_customer' => 'Id Customer',
			'name' => 'Name',
			'created_at' => 'Created At',
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
		$criteria->compare('id_customer',$this->id_customer);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PhotosForIdentityCard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function addNewPhotosForIdentityCard($id_customer,$name){	  		

 		$photos_for_identity_card = new PhotosForIdentityCard;

 		$data = $photos_for_identity_card->findByAttributes(array('id_customer'=>$id_customer,'name'=>$name));

 		if($data) {		

			return;	

		} 		
		
		$photos_for_identity_card->id_customer               = $id_customer;

		$photos_for_identity_card->name                      = $name;

		if ($photos_for_identity_card->validate() && $photos_for_identity_card->save()) {

			return;

		}	
	  
    }

    public function getPhotosForIdentityCard($id_customer) 
	{		
		return  $data   = Yii::app()->db->createCommand()
                ->select('photos_for_identity_card.id,photos_for_identity_card.name')
                ->from('photos_for_identity_card')          
                ->where('photos_for_identity_card.id_customer =:id_customer', array(':id_customer' => $id_customer))     
                ->queryAll();
	}

}
