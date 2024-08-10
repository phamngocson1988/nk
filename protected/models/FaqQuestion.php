<?php

/**
 * This is the model class for table "faq_question".
 *
 * The followings are the available columns in table 'faq_question':
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $phone
 * @property string $img
 * @property string $content
 * @property string $answer
 * @property string $create_date
 * @property integer $status
 */
class FaqQuestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'faq_question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, name, content', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('email, name, img', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>20),
			array('answer, create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, name, phone, img, content, answer, create_date, status', 'safe', 'on'=>'search'),
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
			'email' => 'Email',
			'name' => 'Name',
			'phone' => 'Phone',
			'img' => 'Img',
			'content' => 'Content',
			'answer' => 'Answer',
			'create_date' => 'Create Date',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FaqQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function page_list($curpage,$pages)
	{
		$page_list="";		       	
        
		if(($curpage-1)>0)
		{			
			$page_list.='<span onclick="paging('.$curpage.'-1);" class="div_trang">'."<a title='Về trang trước'> <span class='glyphicon glyphicon-menu-left'></span></a></span>";
		}				
		$vtdau=max($curpage-3,1);
		$vtcuoi=min($curpage+3,$pages);				
		for($i=$vtdau;$i<=$vtcuoi;$i++)
		{
			if($i==$curpage)
			{
				$page_list.='<span style="background:#5DB746;"  class="div_trang">'."<a style='color:#FFFFFF;'>".$i."</a></span>";
			}
			else
			{
				$page_list.='<span onclick="paging('.$i.');" class="div_trang">'."<a  title='Trang ".$i."'>".$i."</a></span>";
			}
		}
		if(($curpage+1)<=$pages)
		{
			$page_list.='<span onclick="paging('.$curpage.'+1);" class="div_trang">'."<a title='Đến trang sau'> <span class='glyphicon glyphicon-menu-right'></span></a></span>";
		}	
	    return $page_list;
	}

	public function loadData($curpage,$limit)
	{
		$start_point=$limit*($curpage-1);
		$faq_q 	= new FaqQuestion;		
		$q 		= new CDbCriteria(array('condition'=>'published="true"'));
		$v 		= new CDbCriteria();
		$v->addCondition('t.status = 1');					
	    $v->order 	= 'id DESC';
	    $v->limit 	= $limit;
	    $v->offset 	= $start_point;
	    $q->mergeWith($v);   
	    return $faq_q->findAll($v);
	}
}
