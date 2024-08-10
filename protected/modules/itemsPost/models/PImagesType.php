<?php

/**
 * This is the model class for table "p_images_type".
 *
 * The followings are the available columns in table 'p_images_type':
 * @property integer $id
 * @property string $name
 * @property integer $block
 * @property integer $status_hidden
 */
class PImagesType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_images_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('block, status_hidden', 'numerical', 'integerOnly'=>true),
			array('name,url_action,name_upload', 'length', 'max'=>100),
			array('url_action,name_upload', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name,url_action,name_upload, block, status_hidden', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'url_action' =>'Url Action',
			'name_upload' =>'Name Upload',
			'block' => 'Block',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_action',$this->url_action,true);
		$criteria->compare('name_upload',$this->name_upload,true);
		$criteria->compare('block',$this->block);
		$criteria->compare('status_hidden',$this->status_hidden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PImagesType the static model class
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

    	   unlink("upload/images_type/lg/".$fileImageDelete);
		   unlink("upload/images_type/md/".$fileImageDelete);
		   unlink("upload/images_type/sm/".$fileImageDelete);
    }
}
