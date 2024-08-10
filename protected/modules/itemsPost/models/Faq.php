<?php

/**
 * This is the model class for table "faq".
 *
 * The followings are the available columns in table 'faq':
 * @property integer $id
 * @property integer $id_faq_type
 * @property integer $id_faq_line
 * @property string $question
 * @property string $answer
 * @property integer $status_hiden
 * @property integer $status
 */
class Faq extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question, answer,answer_en', 'required'),
			array('id_faq_type, id_faq_line, status_hiden, status', 'numerical', 'integerOnly'=>true),
			array('question, question_en', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_faq_type, id_faq_line, question, question_en, answer, answer_en, status_hiden, status', 'safe', 'on'=>'search'),
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
			'rel_line' => array(self::BELONGS_TO,'FaqLine','id_faq_line'),
			'rel_type' => array(self::BELONGS_TO,'FaqType','id_faq_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_faq_type' => 'Id Faq Type',
			'id_faq_line' => 'Id Faq Line',
			'question' => 'Question',
			'answer' => 'Answer',
			'question_en' => 'Question EN',
			'answer_en' => 'Answer EN',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_faq_type',$this->id_faq_type);
		$criteria->compare('id_faq_line',$this->id_faq_line);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('question_en',$this->question_en,true);
		$criteria->compare('answer_en',$this->answer_en,true);
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
	 * @return Faq the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function page_list($curpage,$pages)
	{
		$page_list="";		       	
        if(($curpage!=1)&&($curpage))
		{
			$page_list.='<span onclick="paging(1);" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Trang đầu'><<</a></span>";
		}
		if(($curpage-1)>0)
		{			
			$page_list.='<span onclick="paging('.$curpage.'-1);" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Về trang trước'><</a></span>";
		}				
		$vtdau=max($curpage-3,1);
		$vtcuoi=min($curpage+3,$pages);				
		for($i=$vtdau;$i<=$vtcuoi;$i++)
		{
			if($i==$curpage)
			{
				$page_list.='<span style="background:rgba(115, 149, 158, 0.80);"  class="div_trang">'."<b style='color:#FFFFFF;'>".$i."</b></span>";
			}
			else
			{
				$page_list.='<span onclick="paging('.$i.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Trang ".$i."'>".$i."</a></span>";
			}
		}
		if(($curpage+1)<=$pages)
		{
			$page_list.='<span onclick="paging('.$curpage.'+1);" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Đến trang sau'>></a></span>";
			$page_list.='<span onclick="paging('.$pages.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Đến trang cuối'>>></a></span>";
		}	
	    return $page_list;
	}

	public function faq_list_pagination($curpage,$limit)
	{
		$start_point=$limit*($curpage-1);
		$faq = new Faq;		
		$q = new CDbCriteria(array('condition'=>'published="true"'));
		$v = new CDbCriteria();					
	    $v->order= 'id DESC';
	    $v->limit = $limit;
	    $v->offset = $start_point;
	    $q->mergeWith($v);   
	    return $faq->findAll($v);
	}
}
