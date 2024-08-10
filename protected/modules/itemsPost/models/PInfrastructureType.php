<?php

/**
 * This is the model class for table "p_infrastructure_type".
 *
 * The followings are the available columns in table 'p_infrastructure_type':
 * @property integer $id
 * @property string $name
 * @property string $upload_name
 * @property integer $status_hidden
 */
class PInfrastructureType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_infrastructure_type';
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
			array('status_hidden', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, upload_name, status_hidden', 'safe', 'on'=>'search'),
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
			'upload_name' => 'Upload Name',
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
		$criteria->compare('upload_name',$this->upload_name,true);
		$criteria->compare('status_hidden',$this->status_hidden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PInfrastructureType the static model class
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

    	   unlink("upload/infrastructure_type/lg/".$fileImageDelete);
		   unlink("upload/infrastructure_type/md/".$fileImageDelete);
		   unlink("upload/infrastructure_type/sm/".$fileImageDelete);
    }
}
