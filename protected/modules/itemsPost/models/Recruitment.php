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
 * @property integer $status_hot
 * @property integer $status_hiden
 * @property integer $status
 * @property string $requirement
 */
class Recruitment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_recruitment';
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
			array('id_user, total_view, status_hot, status_hiden, status', 'numerical', 'integerOnly'=>true),
			array('title, title_en, image', 'length', 'max'=>255),
			array('description,description_en,requirement', 'length', 'max'=>2000), 
			array('content,content_en, postdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, title,title_en, image, description,description_en, content,content_en, createdate, postdate, total_view, status_hot, status_hiden, status, requirement', 'safe', 'on'=>'search'),
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
			'id_user' => 'Id User',
			'title' => 'Title',
			'title_en'=>'Title EN',
			'image' => 'Image',
			'description' => 'Description',
			'description_en'=>'Description EN',
			'content' => 'Content',
			'content_en'=>'Content EN',
			'createdate' => 'Createdate',
			'postdate' => 'Postdate',
			'total_view' => 'Total View',
			'status_hot' => 'Status Hot',
			'status_hiden' => 'Status Hiden',
			'status' => 'Status',
			'requirement' => 'Requirement',
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
		$criteria->compare('total_view',$this->total_view);
		$criteria->compare('status_hot',$this->status_hot);
		$criteria->compare('status_hiden',$this->status_hiden);
		$criteria->compare('status',$this->status);
		$criteria->compare('requirement',$this->requirement,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PRecruitment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function updateRecruitment(){
        $con=Yii::app()->db;
        $sql="update p_recruitment set status_hot=0";
        $data=$con->createCommand($sql)->execute();
        return $data;
    }
	public function doc_recruitment($vt=-1,$limit=-1)
	{
		$con = Yii::app()->db;
		$sql="select * from p_recruitment where status_hot=0 order by  createdate ASC";
		if($vt>=0 && $limit>0)
		{
			$sql.=" limit $vt,$limit";
		}
		$data = $con->createCommand($sql)->queryAll();
        return $data;
	}

	public function recruitment_details($id) {
		return Recruitment::model()->findByAttributes(array('id'=>$id));

	}
	public function recruitment_total_view()
	{	
		$con = Yii::app()->db;
		$sql="SELECT * from p_recruitment  order by total_view DESC LIMIT 4";
		$data = $con->createCommand($sql)->queryAll();
        return $data;
	}

	public function recruitment_list_pagination($curpage,$search)
	{
		$start_point=10*($curpage-1);
		$p = new Recruitment;			
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();	
		$v->addCondition('t.status >= 0');
		if($search){ 
		
			$v->addSearchCondition('title', $search, true);
			//$v->addSearchCondition('name', $searchProduct, true, 'OR');
		} 
	    $v->order= 'id DESC';
	    $v->limit = 10;
	    $v->offset = $start_point;
	    $q->mergeWith($v);	    
	     
	    return $p->findAll($v);
	}
	public function recruitment_list_paginationEN($curpage,$search)
	{
		$start_point=10*($curpage-1);
		$p = new Recruitment;			
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();	
		$v->addCondition('t.status >= 0');
		if($search){ 
		
			$v->addSearchCondition('title_en', $search, true);
			//$v->addSearchCondition('name', $searchProduct, true, 'OR');
		} 
	    $v->order= 'id DESC';
	    $v->limit = 10;
	    $v->offset = $start_point;
	    $q->mergeWith($v);	    
	     
	    return $p->findAll($v);
	}
}
