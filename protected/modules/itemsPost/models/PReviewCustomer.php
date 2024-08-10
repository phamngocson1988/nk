<?php

/**
 * This is the model class for table "p_review_customer".
 *
 * The followings are the available columns in table 'p_review_customer':
 * @property integer $id
 * @property string $r_name
 * @property string $r_img
 * @property string $r_content
 * @property integer $status_hidden
 */
class PReviewCustomer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_review_customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('r_name, r_img, r_content,content_en', 'required'),
			array('status_hidden', 'numerical', 'integerOnly'=>true),
			array('r_name, name_en', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, r_name, name_en, r_img, r_content,content_en, status_hidden', 'safe', 'on'=>'search'),
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
			'r_name' => "Name Vi ",
			'name_en'=>'Name En',
			'r_img' => 'Image',
			'r_content' => 'Content',
			'content_en'=>'Content En',
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
		$criteria->compare('r_name',$this->r_name,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('r_img',$this->r_img,true);
		$criteria->compare('r_content',$this->r_content,true);
		$criteria->compare('content_en',$this->content_en,true);
		$criteria->compare('status_hidden',$this->status_hidden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PReviewCustomer the static model class
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

    	   unlink("upload/post/review/lg/".$fileImageDelete);
		   unlink("upload/post/review/md/".$fileImageDelete);
		   unlink("upload/post/review/sm/".$fileImageDelete);
    }
}
