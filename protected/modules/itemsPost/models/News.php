<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property integer $id_user
 * @property string $title
 * @property string $image
 * @property string $description
 * @property string $content
 * @property string $createdate
 * @property string $postdate
 * @property integer $total_view
 * @property integer $status_hiden
 * @property integer $status
 */
class News extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_news_line', 'required'),
			array('id_user, id_news_line, id_news_type, total_view, status_hiden, status', 'numerical', 'integerOnly'=>true),
			array('title,title_en, image, description,description_en, tags', 'length', 'max'=>255),
			array('content,content_en, postdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, id_news_line, id_news_type, title,title_en, image, description,description_en, content,content_en, createdate, postdate, total_view, status_hiden, status, tags', 'safe', 'on'=>'search'),
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
		'rel_user' => array(self::BELONGS_TO,'GpUsers','id_user'),
		'rel_line' => array(self::BELONGS_TO,'NewsLine','id_news_line'),
		'rel_type' => array(self::BELONGS_TO,'PNewsType','id_news_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'Id User',
			'id_news_line' => 'News Line', 
			'id_news_type' => 'News Type',
			'title' => 'Title',
			'title_en'=>'Title EN',
			'image' => 'Image',
			'description' => 'Description',
			'content' => 'Content',
			'description_en' => 'Description EN',
			'content_en' => 'Content EN',
			'createdate' => 'Createdate',
			'postdate' => 'Postdate',
			'total_view' => 'Total View',
			'tags'		=>'Tags',
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

		$criteria->order = "createdate DESC";

		$criteria->compare('id',$this->id);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_news_line',$this->id_news_line);
		$criteria->compare('id_news_type',$this->id_news_type);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('title_en',$this->title_en,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_en',$this->description_en,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('content_en',$this->content_en,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('total_view',$this->total_view);
		$criteria->compare('tags',$this->tags);
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
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function saveImageScaleAndCrop($fileImageUpload,$w='1000',$h='1000',$imageUploadSource,$imageNameUpload){

            $image = new EasyImage($fileImageUpload);
            $image->scaleAndCrop($w, $h);
            $image->save($imageUploadSource."lg/".$imageNameUpload);

            $image = new EasyImage($fileImageUpload);
            $image->scaleAndCrop(600, 300);
            $image->save($imageUploadSource."md/".$imageNameUpload);

            $image = new EasyImage($fileImageUpload);
            $image->scaleAndCrop(317, 158);
            $image->save($imageUploadSource."sm/".$imageNameUpload);

            return true;
    }

    public function deleteImageScaleAndCrop($fileImageDelete){

    	   unlink("upload/post/new/lg/".$fileImageDelete);
		   unlink("upload/post/new/md/".$fileImageDelete);
		   unlink("upload/post/new/sm/".$fileImageDelete);
    }

    public function news_list_pagination($curpage,$search)
	{
		$start_point=10*($curpage-1);
		$p = new News;			
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();	
		$v->addCondition('t.status>=0');
		if($search) 
		{
			$v->addSearchCondition('title', $search, true);
		}
	    $v->order= 'id DESC';
	    $v->limit = 10;
	    $v->offset = $start_point;
	    $q->mergeWith($v);	    
	     
	    return $p->findAll($v);
	}
	public function news_list_pagination_en($curpage,$search)
	{
		$start_point=10*($curpage-1);
		$p = new News;			
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();	
		$v->addCondition('t.status>=0');
		if($search) 
		{
			$v->addSearchCondition('title_en', $search, true);
		}
	    $v->order= 'id DESC';
	    $v->limit = 10;
	    $v->offset = $start_point;
	    $q->mergeWith($v);	    
	     
	    return $p->findAll($v);
	}
}
