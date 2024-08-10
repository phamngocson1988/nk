<?php

/**
 * This is the model class for table "promotion".
 *
 * The followings are the available columns in table 'promotion':
 * @property integer $id
 * @property integer $id_user
 * @property string $title
 * @property string $image
 * @property string $description
 * @property string $content
 * @property string $createdate
 * @property string $postdate
 * @property integer $status_hiden
 * @property integer $status
 
 */
class Promotion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_promotion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, createdate', 'required'),
			array('id_user, status_hiden, status', 'numerical', 'integerOnly'=>true),
			array('title, image, description, title_en, description_en', 'length', 'max'=>255),
			array('content,content_en, postdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, title, image, description, content,title_en,description_en,content_en, createdate, postdate, status_hiden, status', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'image' => 'Image',
			'description' => 'Description',
			'content' => 'Content',
			'title_en'=>'Title EN',
			'description_en'=>'Description EN',
			'content_en'=>'Content EN',
			'createdate' => 'Createdate',
			'postdate' => 'Postdate',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('title_en',$this->title_en,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_en',$this->description_en,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('content_en',$this->content_en,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('postdate',$this->postdate,true);
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
	 * @return Promotion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getpromotion($vt=-1,$limit=-1)
	{
		$con = Yii::app()->db;
		$sql="select * from p_promotion ";
		if($vt>=0 && $limit>0)
		{
			$sql.="limit $vt,$limit";
		}
		$data = $con->createCommand($sql)->queryAll();
        return $data;
	}

	public function promotion_details($id) {
	 return Promotion::model()->findByAttributes(array('id'=>$id));

	}
	public function promotion_list_pagination($curpage,$search)
	{
		$start_point=10*($curpage-1);
		$p = new Promotion;			
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();	
		$v->addCondition('t.status >= 0');
		if($search){ 
		
			$v->addSearchCondition('name', $search, true);
			//$v->addSearchCondition('name', $searchProduct, true, 'OR');
		} 
	    $v->order= 'id DESC';
	    $v->limit = 10;
	    $v->offset = $start_point;
	    $q->mergeWith($v);	    
	     
	    return $p->findAll($v);
	}
}
