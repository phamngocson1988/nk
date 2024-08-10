<?php

/**
 * This is the model class for table "service".
 *
 * The followings are the available columns in table 'service':
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
			array('id_service_type, name', 'required'),
			array('id_service_type,total_view, status_hiden, status, stt', 'numerical', 'integerOnly'=>true),
			array('name, image, name_en', 'length', 'max'=>255),
			array('content,content_en,description,description_en', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_service_type, name,name_en, image, description,description_en, content,content_en, total_view,createdate, status_hiden, status,stt', 'safe', 'on'=>'search'),
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
		     'rel_service_type' => array(self::BELONGS_TO,'ServiceType','id_service_type'),
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
			'name_en'=>'Name EN',
			'image' => 'Image',
			'description' => 'Description',
			'description_en' => 'Description En',
			'content' => 'Content',
			'content_en'=>'Content EN',
			'total_view'=>'Total View',
			'createdate' => 'Createdate',
			'status_hiden' => 'Status Hiden',
			'status' => 'Status',
			'stt'	=>'STT'
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
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_en',$this->description_en,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('content_en',$this->content_en,true);
		$criteria->compare('total_view',$this->total_view,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('status_hiden',$this->status_hiden);
		$criteria->compare('status',$this->status);
		$criteria->compare('stt',$this->stt);

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
	public function service_list_pagination($curpage,$search)
	{
		$start_point=10*($curpage-1);
		$p = new Service;			
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
	public function service_list_paginationEN($curpage,$search)
	{
		$start_point=10*($curpage-1);
		$p = new Service;			
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();	
		$v->addCondition('t.status >= 0');
		if($search){ 
		
			$v->addSearchCondition('name_en', $search, true);
			//$v->addSearchCondition('name', $searchProduct, true, 'OR');
		} 
	    $v->order= 'id DESC';
	    $v->limit = 10;
	    $v->offset = $start_point;
	    $q->mergeWith($v);	    
	     
	    return $p->findAll($v);
	}
}
