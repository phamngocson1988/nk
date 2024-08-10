<?php

/**
 * This is the model class for table "cs_service".
 *
 * The followings are the available columns in table 'cs_service':
 * @property integer $id
 * @property integer $id_service_type
 * @property string $code
 * @property string $name
 * @property string $name_en
 * @property double $price
 * @property string $due_price
 * @property string $image
 * @property string $description
 * @property string $content
 * @property string $length
 * @property string $createdate
 * @property integer $status_hiden
 * @property integer $status
 * @property string $color
 * @property integer $point_donate
 * @property integer $point_exchange
 * @property string $tax
 * @property integer $flag
 * @property integer $stt_show
 * @property integer $time_value_of_money
 * @property integer $priority_pay
 */
class CsService extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cs_service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_service_type, code, name', 'required'),
			array('id_service_type, status_hiden, status, point_donate, point_exchange, flag, stt_show, time_value_of_money, priority_pay,flag_price', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('code', 'length', 'max'=>25),
			array('name, name_en, image, color', 'length', 'max'=>255),
			array('due_price', 'length', 'max'=>100),
			array('description', 'length', 'max'=>500),
			array('length', 'length', 'max'=>10),
			array('tax', 'length', 'max'=>12),
			array('content, createdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_service_type, code, name, name_en, price, due_price, image, description, content, length, createdate, status_hiden, status, color, point_donate, point_exchange, tax, flag, stt_show, time_value_of_money,flag_price', 'safe', 'on'=>'search'),
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
			'id_service_type' => 'Id Service Type',
			'code' => 'Code',
			'name' => 'Name',
			'name_en' => 'Name En',
			'price' => 'Price',
			'due_price' => 'Due Price',
			'image' => 'Image',
			'description' => 'Description',
			'content' => 'Content',
			'length' => 'Length',
			'createdate' => 'Createdate',
			'status_hiden' => 'Status Hiden',
			'status' => 'Status',
			'color' => 'Color',
			'point_donate' => 'Point Donate',
			'point_exchange' => 'Point Exchange',
			'tax' => 'Tax',
			'flag' => 'Flag',
			'stt_show' => 'Stt Show',
			'time_value_of_money' => 'Time Value Of Money',
			'flag_price' =>'flag_price',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('due_price',$this->due_price,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('length',$this->length,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('status_hiden',$this->status_hiden);
		$criteria->compare('status',$this->status);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('point_donate',$this->point_donate);
		$criteria->compare('point_exchange',$this->point_exchange);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('flag',$this->flag);
		$criteria->compare('stt_show',$this->stt_show);
		$criteria->compare('time_value_of_money',$this->time_value_of_money);
		$criteria->compare('flag_price',$this->flag_price);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CsService the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getListDentists(){

		$data   = Yii::app()->db->createCommand()
		->select('*')
		->from('gp_users')
		->where('gp_users.group_id=:group_id', array(':group_id' => 3))               
		->queryAll();

		return	$data;
	}

	public function service_list_pagination($curpage,$numPerPage,$id_service_type,$searchService,$hide_group=false)
	{
		$start_point=$numPerPage*($curpage-1);
		$cs = new CsService;		
		$criteria = new CDbCriteria();	
		$criteria->addCondition('t.status = 1');
		$criteria2 = new CDbCriteria;

		if($id_service_type==0) {
			$criteria2->addSearchCondition('code', $searchService, true);
			$criteria2->addSearchCondition('name', $searchService, true, 'OR');
		} else {
			$criteria->addCondition('t.id_service_type = :id_service_type');
			$criteria->params = array(':id_service_type' => $id_service_type);
			$criteria2->addSearchCondition('code', $searchService, true);
			$criteria2->addSearchCondition('name', $searchService, true, 'OR');
		}

		if ($hide_group) {
			$criteria->addCondition('t.id_service_type NOT IN (12,62)');
		}

		$criteria->order  = 'code ASC, id_service_type ASC, stt_show ASC, id ASC'; // stt_show
		$criteria->limit  = $numPerPage;
		$criteria->offset = $start_point;
		$criteria->mergeWith($criteria2);  
		
		return $cs->findAll($criteria);
	}

	public function revenueService($lstUser,$branch,$type_time,$fromdate,$todate,$service_type)
	{
		$data[]="";
		if ($service_type) {
			$ListService = CsService::model()->findAllByAttributes(array('id_service_type'=>$service_type));
		}
		else if($lstUser){
			$ListService = VServices::model()->findAllByAttributes(array('id_dentist'=>$lstUser));
		}
		else{
			$ListService = CsService::model()->findAllByAttributes(array('status'=>1));
		}
		$i = 0;
		$totalSchedule_1			= 0;
		$schedule_online_1 			= 0;
		$lenghtSchedule_1 			= 0;
		$totalCustomerService_1		= 0;
		$totalQuotationService_1	= 0;
		$totalServices_1 			= 0;
		
		foreach ($ListService as $value) {
			$totalSchedule = CsService::model()->service_totalSchedule($value['id'],$lstUser,$branch,$type_time,$fromdate,$todate,''); 
			$schedule_online = CsService::model()->service_totalSchedule($value['id'],$lstUser,$branch,$type_time,$fromdate,$todate,'1');
			$lenghtSchedule = CsService::model()->service_lenghtSchedule($value['id'],$lstUser,$branch,$type_time,$fromdate,$todate); 
			$totalCustomerService = CsService::model()->service_totalCustomer($value['id'],$lstUser,$branch,$type_time,$fromdate,$todate);
			$totalQuotationService = CsService::model()->service_sumQuotation($value['id'],$lstUser,$branch,$type_time,$fromdate,$todate);
			$totalServices = CsService::model()->service_totalServices($value['id'],$lstUser,$branch,$type_time,$fromdate,$todate);
			$data[$i] = array('name'=>$value['name'],'totalSchedule'=>$totalSchedule,'lenghtSchedule'=>$lenghtSchedule,'totalCustomerService'=>$totalCustomerService,'totalServices'=>$totalServices,'price'=>$value['price'],'totalQuotationService'=>$totalQuotationService);
			$totalSchedule_1			+= $totalSchedule;
			$schedule_online_1			+= $schedule_online;
			$lenghtSchedule_1			+= $lenghtSchedule;
			$totalCustomerService_1		+= $totalCustomerService;
			$totalQuotationService_1 	+= $totalQuotationService;
			$totalServices_1 			+= $totalServices;
			$i++;
		}
		//$data[$i] = array('name'=>'Tổng','totalSchedule'=>$totalSchedule_1,'lenghtSchedule'=>$lenghtSchedule_1,'totalCustomerService'=>$totalCustomerService_1,'totalServices'=>$totalServices_1,'price'=>'','totalInvoiceService'=>$totalInvoiceService_1);
		return $data;
	}
	public function service_totalSchedule($lstService,$lstUser,$branch,$type_time,$fromdate,$todate,$source) //Số lịch hẹn
	{
		$con = Yii::app()->db;
		$sql = "select count(*) as totalSchedule from v_schedule where 1 = 1 ";
		if ($lstUser) {
			$sql.=" and id_dentist=$lstUser";
		}
		if ($lstService) {
			$sql.=" and id_service=$lstService";
		}
		if ($branch) {
			$sql.=" and id_branch=$branch";
		}
		if ($source) {
			$sql.=" and source > 0";
		}
		if ($type_time) {
			if ($type_time == 1) {
				$time = date('Y-m-d');
				$sql.= " and DATE(create_date)='$time'";
			}
			else if ($type_time == 2)
			{
				$time_fisrt = date('Y-m-d',strtotime('monday this week'));
				$time_last = date('Y-m-d',strtotime('sunday this week'));
				$sql.= " and (DATE(v_schedule.`create_date`)>='$time_fisrt' and DATE(v_schedule.`create_date`)<='$time_last')";
			}
			else if ($type_time==3)
			{
				$time = date('m',strtotime(date('Y-m-d')));
				$sql.= " and MONTH(create_date)='$time'";
			}
			else if ($type_time==4)
			{
				$time = date('m',strtotime(date('Y-m-d') . ' - 1 month')); //tháng trước
				$sql.=" and MONTH(create_date) ='$time'";
			}
			else if($type_time==5)
			{
				$sql.= " and (DATE(v_schedule.`create_date`)>='$fromdate' and DATE(v_schedule.`create_date`)<='$todate')";
			}
		}
		$data = $con->createCommand($sql)->queryAll();
		return $data[0]['totalSchedule'];
	}
	public function service_lenghtSchedule($lstService,$lstUser,$branch,$type_time,$fromdate,$todate) //thời lượng
	{
		$con = Yii::app()->db;
		$sql = "select sum(lenght) as lenght from v_schedule where 1 = 1 ";
		if ($lstUser) {
			$sql.=" and id_dentist=$lstUser";
		}
		if ($lstService) {
			$sql.=" and id_service=$lstService";
		}
		if ($branch) {
			$sql.=" and id_branch=$branch";
		}
		if ($type_time) {
			if ($type_time == 1) {
				$time = date('Y-m-d');
				$sql.= " and DATE(create_date)='$time'";
			}
			else if ($type_time == 2)
			{
				$time_fisrt = date('Y-m-d',strtotime('monday this week'));
				$time_last = date('Y-m-d',strtotime('sunday this week'));
				$sql.= " and (DATE(v_schedule.`create_date`)>='$time_fisrt' and DATE(v_schedule.`create_date`)<='$time_last')";
			}
			else if ($type_time==3)
			{
				$time = date('m',strtotime(date('Y-m-d')));
				$sql.= " and MONTH(create_date)='$time'";
			}
			else if ($type_time==4)
			{
				$time = date('m',strtotime(date('Y-m-d') . ' - 1 month')); //tháng trước
				$sql.=" and MONTH(create_date) ='$time'";
			}
			else if($type_time==5)
			{
				$sql.= " and (DATE(v_schedule.`create_date`)>='$fromdate' and DATE(v_schedule.`create_date`)<='$todate')";
			}
		}
		$data = $con->createCommand($sql)->queryAll();
		return $data[0]['lenght'];
	}
	public function service_totalCustomer($lstService,$lstUser,$branch,$type_time,$fromdate,$todate) //khách hàng
	{
		$con = Yii::app()->db;
		$sql = "select count(id_customer) as totalCustomerService from v_schedule where 1 = 1 ";
		if ($lstUser) {
			$sql.=" and id_dentist=$lstUser";
		}
		if ($lstService) {
			$sql.=" and id_service=$lstService";
		}
		if ($branch) {
			$sql.=" and id_branch=$branch";
		}
		if ($type_time) {
			if ($type_time == 1) {
				$time = date('Y-m-d');
				$sql.= " and DATE(create_date)='$time'";
			}
			else if ($type_time == 2)
			{
				$time_fisrt = date('Y-m-d',strtotime('monday this week'));
				$time_last = date('Y-m-d',strtotime('sunday this week'));
				$sql.= " and (DATE(v_schedule.`create_date`)>='$time_fisrt' and DATE(v_schedule.`create_date`)<='$time_last')";
			}
			else if ($type_time==3)
			{
				$time = date('m',strtotime(date('Y-m-d')));
				$sql.= " and MONTH(create_date)='$time'";
			}
			else if ($type_time==4)
			{
				$time = date('m',strtotime(date('Y-m-d') . ' - 1 month')); //tháng trước
				$sql.=" and MONTH(create_date) ='$time'";
			}
			else if($type_time==5)
			{
				$sql.= " and (DATE(v_schedule.`create_date`)>='$fromdate' and DATE(v_schedule.`create_date`)<='$todate')";
			}
		}
		$data = $con->createCommand($sql)->queryAll();
		return $data[0]['totalCustomerService'];
	}

	public function service_totalServices($lstService,$lstUser,$branch,$type_time,$fromdate,$todate) //Số lượng dịch vụ
	{
		$con = Yii::app()->db;
		$sql = "select sum(qty) as totalServices from v_quotation_detail where 1 = 1 ";
		if ($lstUser) {
			$sql.=" and id_user=$lstUser";
		}
		if ($lstService) {
			$sql.=" and id_service=$lstService";
		}
		if ($branch) {
			$sql.=" and id_branch=$branch";
		}
		
		if ($type_time) {
			if ($type_time == 1) {
				$time = date('Y-m-d');
				$sql.= " and DATE(create_date)='$time'";
			}
			else if ($type_time == 2)
			{
				$time_fisrt = date('Y-m-d',strtotime('monday this week'));
				$time_last = date('Y-m-d',strtotime('sunday this week'));
				$sql.= " and (DATE(v_quotation_detail.`create_date`)>='$time_fisrt' and DATE(v_quotation_detail.`create_date`)<='$time_last')";
			}
			else if ($type_time==3)
			{
				$time = date('m',strtotime(date('Y-m-d')));
				$sql.= " and MONTH(create_date)='$time'";
			}
			else if ($type_time==4)
			{
				$time = date('m',strtotime(date('Y-m-d') . ' - 1 month')); //tháng trước
				$sql.=" and MONTH(create_date) ='$time'";
			}
			else if($type_time==5)
			{
				$sql.= " and (DATE(v_quotation_detail.`create_date`)>='$fromdate' and DATE(v_quotation_detail.`create_date`)<='$todate')";
			}
		}
		$data = $con->createCommand($sql)->queryAll();
		return $data[0]['totalServices'];
	}
	public function service_sumQuotation($lstService,$lstUser,$branch,$type_time,$fromdate,$todate) // doanh thu
	{
		$con = Yii::app()->db;
		$sql = "select sum(amount) as totalQuotation from v_quotation_detail where 1 = 1 ";
		if ($lstUser) {
			$sql.=" and id_user=$lstUser";
		}
		if ($lstService) {
			$sql.=" and id_service=$lstService";
		}
		if ($branch) {
			$sql.=" and id_branch=$branch";
		}
		
		if ($type_time) {
			if ($type_time == 1) {
				$time = date('Y-m-d');
				$sql.= " and DATE(create_date)='$time'";
			}
			else if ($type_time == 2)
			{
				$time_fisrt = date('Y-m-d',strtotime('monday this week'));
				$time_last = date('Y-m-d',strtotime('sunday this week'));
				$sql.= " and (DATE(v_quotation_detail.`create_date`)>='$time_fisrt' and DATE(v_quotation_detail.`create_date`)<='$time_last')";
			}
			else if ($type_time==3)
			{
				$time = date('m',strtotime(date('Y-m-d')));
				$sql.= " and MONTH(create_date)='$time'";
			}
			else if ($type_time==4)
			{
				$time = date('m',strtotime(date('Y-m-d') . ' - 1 month')); //tháng trước
				$sql.=" and MONTH(create_date) ='$time'";
			}
			else if($type_time==5)
			{
				$sql.= " and (DATE(v_quotation_detail.`create_date`)>='$fromdate' and DATE(v_quotation_detail.`create_date`)<='$todate')";
			}
		}
		$data = $con->createCommand($sql)->queryAll();
		return $data[0]['totalQuotation'];
	}

	public function getServiceListByGroup($id_service_type)
	{
		
		$cs_service = new CsService;	

		$criteria = new CDbCriteria();	

		$criteria->addCondition('status = 1');
		
		if($id_service_type)
		{
			$criteria->addCondition('id_service_type = :id_service_type');
			$criteria->params = array(':id_service_type' => $id_service_type);
		}				

		$criteria->order  = 'stt_show ASC , id ASC';		
		
		return $cs_service->findAll($criteria);
		
	}

	public function ListService(){
		$list = CsService::model()->findAll();
		return $list;
	}

	public function AddService($array){
		$CsService = new CsService();
		$CsService->attributes = $array;
		$kq = $CsService->save();
		return $CsService->getErrors();
	}
}
