<?php

/**
 * This is the model class for table "p_images".
 *
 * The followings are the available columns in table 'p_images':
 * @property integer $id
 * @property integer $id_type
 * @property string $name
 * @property string $url_action
 * @property string $name_upload
 * @property string $update_time
 * @property integer $status_hidden
 */
class PImages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_type', 'required'),
			array('id_type, status_hidden', 'numerical', 'integerOnly'=>true),
			array('name,name_en, url_action, name_upload', 'length', 'max'=>200),
			array('data_upload', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_type, name,name_en, url_action, name_upload, update_time,data_upload, status_hidden', 'safe', 'on'=>'search'),
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
			'rel_type' => array(self::BELONGS_TO,'PImagesType','id_type'),
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
			'name' => 'Name',
			'name_en'=>'Name En',
			'url_action' => 'Url Action',
			'name_upload' => 'Name Upload',
			'update_time' => 'Update Time',
			'data_upload' =>'Data Upload',
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
		$criteria->order = "update_time DESC";
		$criteria->compare('id',$this->id);
		$criteria->compare('id_type',$this->id_type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('url_action',$this->url_action,true);
		$criteria->compare('name_upload',$this->name_upload,true);
		$criteria->compare('data_upload',$this->data_upload,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('status_hidden',$this->status_hidden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function ImageUserValidation($attribute,$param){
    	if(is_object($this->image)){
    		list($width, $height) = getimagesize($this->image->tempname);
    		if($width!=1000 || $height!=1000)
    			$this->addError('image','Image size should be 1000*1000 dimension');
    	}
    }
	public function saveImageScaleAndCrop($fileImageUpload,$w='1000',$h='1000',$imageUploadSource,$imageNameUpload){
			
            $image = new EasyImage($fileImageUpload);
   //          echo ($imageUploadSource."lg/".$imageNameUpload);
			// exit();
            // $image->scaleAndCrop($w, $h);
            $image->save($imageUploadSource."lg/".$imageNameUpload);

            $image = new EasyImage($fileImageUpload);
            $image->scaleAndCrop($w/2, $h/2);
            $image->save($imageUploadSource."md/".$imageNameUpload);

            $image = new EasyImage($fileImageUpload);
            $image->scaleAndCrop($w/4, $h/4);
            $image->save($imageUploadSource."sm/".$imageNameUpload);

            return true;
    }

    public function deleteImageScaleAndCrop($fileImageDelete){

    	   unlink("upload/images/lg/".$fileImageDelete);
		   unlink("upload/images/md/".$fileImageDelete);
		   unlink("upload/images/sm/".$fileImageDelete);
    }
}
