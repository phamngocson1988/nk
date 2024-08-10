<?php

/**
 * This is the model class for table "v_services_hours".
 *
 * The followings are the available columns in table 'v_services_hours':
 * @property integer $id_dentist
 * @property string $dentist_name
 * @property integer $id_service
 * @property string $service_name
 * @property integer $dow
 * @property string $start
 * @property string $end
 * @property integer $id_chair
 * @property integer $chair_type
 * @property integer $id_branch
 */
class VServicesHours extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_services_hours';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dentist_name, service_name', 'required'),
			array('id_dentist, id_service, dow, id_chair, chair_type, id_branch', 'numerical', 'integerOnly'=>true),
			array('dentist_name', 'length', 'max'=>128),
			array('service_name', 'length', 'max'=>255),
			array('start, end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dentist, dentist_name, id_service, service_name, dow, start, end, id_chair, chair_type, id_branch', 'safe', 'on'=>'search'),
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
			'id_dentist' => 'Id Dentist',
			'dentist_name' => 'Dentist Name',
			'id_service' => 'Id Service',
			'service_name' => 'Service Name',
			'dow' => 'Dow',
			'start' => 'Start',
			'end' => 'End',
			'id_chair' => 'Id Chair',
			'chair_type' => 'Chair Type',
			'id_branch' => 'Id Branch',
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

		$criteria->compare('id_dentist',$this->id_dentist);
		$criteria->compare('dentist_name',$this->dentist_name,true);
		$criteria->compare('id_service',$this->id_service);
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('dow',$this->dow);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('id_chair',$this->id_chair);
		$criteria->compare('chair_type',$this->chair_type);
		$criteria->compare('id_branch',$this->id_branch);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VServicesHours the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDentistWork($id_branch = 1,$id_service = 1,$chair_type = 2) {
		if($id_service == 1){		// khám tư vấn - xem tất cả bác sỹ có thời gian làm việc
			$con = "id_service = $id_service AND chair_type = 1";
		}
		else {				// bác sỹ hiển thị theo dịch vụ
			$con = "id_service = $id_service AND chair_type = 2";
		}
		$dentistWork = Yii::app()->db->createCommand("SELECT DISTINCT `id_dentist` AS id, `dentist_name` AS name FROM `v_services_hours` WHERE `id_branch` = $id_branch AND $con")->queryAll();

		return $dentistWork;
	}

	public function getDentistWorkOnl($id_branch = 1, $id_service = 1, $searchDentist = '') {
		$sv = '';
		if($id_service) {
			$sv = " AND id_service = $id_service";
		}
		$dentistWork = Yii::app()->db->createCommand("
			SELECT DISTINCT `id_dentist` AS id, `dentist_name` AS name, dentist_image AS image, dentist_exp AS exp, dentist_diploma AS diploma, dentist_certificate AS cer
			FROM `v_services_hours`
			WHERE  `id_branch` = $id_branch AND `dentist_book_onl` = 1 $sv AND chair_type = 1"
		)->queryAll();

		return $dentistWork;
	}

	public function getServiceList($id_branch=1) {
		$serviceList = Yii::app()->db->createCommand("
			SELECT DISTINCT `id_service` AS id, `service_name` AS name, `service_length` as length, `service_code` as code, `service_price` as price, service_description AS description
			FROM `v_services_hours`
			WHERE `id_branch` = $id_branch AND status_hiden = 1
			ORDER BY id_service
		")->queryAll();
		return $serviceList;
	}

	public function getResourcesDentist($id_dentist = 0, $id_branch = 1) {
		//$start_point = 10*($curpage-1);
		$cs = new VServicesHours;

		$q = new CDbCriteria(array(
    		'condition'=>'published="true"'
		));

		$v = new CDbCriteria();
		$v->addCondition("dentist_branch = $id_branch");

		if($id_dentist)
		{
			$v->addCondition("id_dentist = $id_dentist");
		}
		$v->group = 'id_dentist, start, dow';
		$v->order = 'id_dentist, start, dow';
	    //$v->limit = 20;
	    //$v->offset = $start_point;
	    $q->mergeWith($v);

	    return $cs->findAll($v);
	}

	// lay danh sach bac sy trong ghe kham
	public function getDentistExam($id_branch = '')
	{
		$con = '';
		if($id_branch){
			$con = " AND id_branch = $id_branch";
		}
		$dentistList = Yii::app()->db->createCommand("
			SELECT *
			FROM `v_services_hours`
			WHERE chair_type = 1 $con
			GROUP BY id_dentist
		")->queryAll();
		return $dentistList;
	}

	// lay danh sach bac sy trong ghe dieu tri
	public function getDentistTreatment($id_branch = '')
	{
		$con = '';
		if($id_branch){
			$con = " AND id_branch = $id_branch";
		}
		$dentistList = Yii::app()->db->createCommand("
			SELECT *
			FROM `v_services_hours`
			WHERE chair_type != 1 $con
			GROUP BY id_dentist
		")->queryAll();
		return $dentistList;
	}
}
