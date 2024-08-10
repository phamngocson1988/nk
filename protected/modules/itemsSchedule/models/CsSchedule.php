<?php

/**
 * This is the model class for table "cs_schedule".
 *
 * The followings are the available columns in table 'cs_schedule':
 * @property integer $id
 * @property string $code
 * @property string $code_confirm
 * @property integer $id_customer
 * @property integer $id_dentist
 * @property integer $id_author
 * @property integer $id_branch
 * @property integer $id_chair
 * @property integer $id_service
 * @property integer $lenght
 * @property string $start_time
 * @property string $end_time
 * @property string $create_date
 * @property string $change_date
 * @property integer $id_group_history
 * @property integer $id_quotation
 * @property integer $id_invoice
 * @property integer $source
 * @property integer $status
 * @property integer $active
 * @property integer $status_customer
 * @property integer $id_note
 * @property string $note
 * @property integer $remain
 */
class CsSchedule extends CActiveRecord
{
	// 0:CN 1:T2 2:T3 3:T4 4:T5 5:T6 6:T7
	public $status_arr = array(
		'1'  => 'Lịch mới',
		'2'  => 'Đang chờ',
		'5'  => 'Bỏ về',
		'3'  => 'Điều trị',
		'4'  => 'Hoàn tất',
		'0'	 => 'Không làm việc',
		'-1' => 'Hẹn lại',
		'-2' => 'Bỏ hẹn',
		'6'	 => 'Vào khám',
		'7'  => 'Xác nhận',
	);
	public $stN = array(
		'2'  => 'Đang chờ',
		'1'  => 'Lịch mới',
	);
	// lich moi
	public $st1 = array(
		'1'  => 'Lịch mới',
		'7'  => 'Xác nhận',
		'2'  => 'Đang chờ',
		'-1' => 'Hẹn lại',
		'-2' => 'Bỏ hẹn',
	);

	// xac nhan
	public $st7 = array(
		'7'  => 'Xác nhận',
		'2'  => 'Đang chờ',
		'3'  => 'Điều trị',
		'5'  => 'Bỏ về',
	);
	// dang cho
	public $st2 = array(
		'2'  => 'Đang chờ',
		'3'  => 'Điều trị',
		'5'  => 'Bỏ về',
	);
	// dieu tri
	public $st3 = array(
		'5'  => 'Bỏ về',
		'3'  => 'Điều trị',
		'4'  => 'Hoàn tất',
	);
	public $st0 = array(
		'1'  => 'Lịch mới',
		'2'  => 'Đang chờ',
		'-2' => 'Bỏ hẹn',
	);
	// bo ve
	public $st5 = array(
		'5'  => 'Bỏ về',
		'3'  => 'Điều trị',
		'2'  => 'Đang chờ',
	);

	// lich moi cho phong kham
	public $stEN = array(
		'6' => 'Vào khám',
		'1' => 'Lịch mới',
	);
	public $stE0 = array(
		'1'  => 'Lịch mới',
		'2'  => 'Vào khám',
		'-2' => 'Bỏ hẹn',
	);
	// lich moi
	public $stE1 = array(
		'1'  => 'Lịch mới',
		'7'  => 'Xác nhận',
		'-2' => 'Bỏ hẹn',
		'-1' => 'Hẹn lại',
	);
	// xac nhan
	public $stE7 = array(
		'7'  => 'Xác nhận',
		'6' => 'Vào khám',
	);
	// vao kham cho phong kham
	public $stE2 = array(
		'6' => 'Vào khám',
		'4' => 'Hoàn tất',
		'5' => 'Bỏ về',
	);
	// bo ve
	public $stE5 = array(
		'5' => 'Bỏ về',
		'7' => 'Vào khám',
	);

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cs_schedule';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_customer, id_dentist, id_author, id_branch, id_chair, id_service, lenght, id_group_history, id_quotation, id_invoice, source, status, active, status_customer, id_note, remain', 'numerical', 'integerOnly'=>true),
            array('code, code_confirm', 'length', 'max'=>45),
            array('start_time, end_time, change_date, note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, code_confirm, id_customer, id_dentist, id_author, id_branch, id_chair, id_service, lenght, start_time, end_time, create_date, change_date, id_group_history, id_quotation, id_invoice, source, status, active, id_note, note, remain', 'safe', 'on'=>'search'),
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
            'code' => 'Code',
            'code_confirm' => 'Code Confirm',
            'id_customer' => 'Id Customer',
            'id_dentist' => 'Id Dentist',
            'id_author' => 'Id Author',
            'id_branch' => 'Id Branch',
            'id_chair' => 'Id Chair',
            'id_service' => 'Id Service',
            'lenght' => 'Lenght',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'create_date' => 'Create Date',
            'change_date' => 'Change Date',
            'id_group_history' => 'Id Group History',
            'id_quotation' => 'Id Quotation',
            'id_invoice' => 'Id Invoice',
            'source' => 'Source',
            'status' => 'Status',
            'active' => 'Active',
            'id_note' => 'Id Note',
            'note' => 'Note',
            'remain' => 'Remain',
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
        $criteria->compare('code',$this->code,true);
        $criteria->compare('code_confirm',$this->code_confirm,true);
        $criteria->compare('id_customer',$this->id_customer);
        $criteria->compare('id_dentist',$this->id_dentist);
        $criteria->compare('id_author',$this->id_author);
        $criteria->compare('id_branch',$this->id_branch);
        $criteria->compare('id_chair',$this->id_chair);
        $criteria->compare('id_service',$this->id_service);
        $criteria->compare('lenght',$this->lenght);
        $criteria->compare('start_time',$this->start_time,true);
        $criteria->compare('end_time',$this->end_time,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('change_date',$this->change_date,true);
        $criteria->compare('id_group_history',$this->id_group_history);
        $criteria->compare('id_quotation',$this->id_quotation);
        $criteria->compare('id_invoice',$this->id_invoice);
        $criteria->compare('source',$this->source);
        $criteria->compare('status',$this->status);
        $criteria->compare('active',$this->active);
        $criteria->compare('id_note',$this->id_note);
        $criteria->compare('note',$this->note,true);
        $criteria->compare('remain',$this->remain);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CsSchedule the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function getColorSch($status, $online=0) {
		$col = '';
		if ($online) {
			$col = 'rgb(102,255,255)';
		} else {
			switch ($status) {
				case '1':		// lịch mới
					$col = 'rgb(0, 176, 240)';
					break;
				case '2':		// đang chờ
					$col = 'rgb(255, 255, 0)';
					break;
				case '3':		// điều trị
					$col = 'rgb(0, 255, 0)';
					break;
				case '4':		// hoàn tất
					$col = 'rgb(255, 0, 0)';
					break;
				case '5':		// bỏ về
					$col = 'rgb(228, 108, 10)';
					break;
				case '-1':		// hẹn lại
					$col = 'rgb(24, 24, 163)';
					break;
				case '-2':		//Không đến
					$col = '#965050';
					break;
				case '0':		//Không làm việc
					$col = '#b4b4b4';
					break;
				case '6':		// vào khám
					$col = 'rgb(0, 255, 0)';
					break;
				case '7':		//xac nhan
					$col = 'rgb(255, 51, 204)';
					break;

				default:
					$col = 'rgba(184, 59, 59, 0.75)';
					break;
			}
		}

		return $col;
	}

	public function getBranchList() {
		return Branch::model()->findAllByAttributes(array('status'=>1));
	}

	// danh sach lich hen
	public function getListSchedule($id_dentist = '' ,$id_author = '' ,$id_branch = '',$id_chair = '', $order = '', $id_customer = '', $start_time = '', $end_time = '', $page = 1) {
		$limit = 5000;
		$start_point = $limit * ($page-1);
		$status = 0;

		$cs = new VSchedule;
		$v = new CDbCriteria();

		$v->addCondition('t.status_active = 1');
		$v->addCondition('t.group_id = 3');

		if ($start_time && $end_time) {
			// if($id_branch) {
			// 	$v->addCondition("id_branch = $id_branch");
			// }
			//$v->addCondition("date(start_time) >= '$start_time' AND date(end_time) <= '$end_time'");

			// if (!$id_dentist && !$id_customer) {
			// 	$strConditionTimeOff = "(id_branch IS NULL ";
			// 	$strConditionTimeOff .= " AND (start_time <= '$start_time 00:00:01' AND '$start_time 00:00:01' <= end_time ) ";
        	// 	$strConditionTimeOff .= " OR (start_time <= '$end_time 23:59:00' AND '$end_time 23:59:00' <= end_time))";
        	// 	$v->addCondition($strConditionTimeOff, 'OR');
			// }

			/**
			 * Replace all above command.
			 * Reduce query time from 1.3s to 142ms
			 * Reduce scan rows from all (238k) to 296
			 * Demo query on 2024-01-08
			 */
			$v->addCondition("start_time between '$start_time 00:00:00' and '$end_time 23:59:59' or end_time BETWEEN '$start_time 00:00:00' AND '$end_time 23:59:59'");
		}

		if($id_dentist) {
			$v->addCondition('id_dentist = ' . $id_dentist);
		}
		if($id_author)
			$v->addCondition('id_author = '. $id_author);
		if($id_branch)
			$v->addCondition("id_branch = $id_branch");
		if($id_chair)
			$v->addCondition('id_chair = '. $id_chair);
		if($id_customer)
			$v->addCondition('id_customer = '. $id_customer);

		if($order) {
			$v->order = $order;
		} else {
			$v->order = "start_time DESC";
		}

		$v->limit = $limit;
		$v->offset = $start_point;

	    return $cs->findAll($v);
	}

	// lấy danh sách bác sỹ có mã dịch vụ là $id_service
	public function getServiceDentists($id_service) {
		$dentistList = CsServiceUsers::model()->findAllByAttributes(array('id_service'=>$id_service, 'st'=>1));
		if($dentistList) {
			return $dentistList;
		} else {
			return -1; // dịch vụ không có bác sỹ
		}

	}

	// get all list services with id_dentist
	public function getDentistServices($curpage,$id_dentist,$searchService)
	{
		//$start_point=10*($curpage-1);
		$cs = new VServicesHours;
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();
		if($id_dentist==0)
		{
			$v->addSearchCondition('service_code', $searchService, true);
			$v->addSearchCondition('service_name', $searchService, true, 'OR');
		}
		else
		{
			$v->addCondition('t.id_dentist = :id_dentist');
			$v->params = array(':id_dentist' => $id_dentist);
			$v->addSearchCondition('service_code', $searchService, true);
			$v->addSearchCondition('service_name', $searchService, true, 'OR');
		}
	    $v->order= 'id_service DESC';
		$v->group = 'id_service';
	   /* $v->limit = 20;
	    $v->offset = $start_point;*/
	    $q->mergeWith($v);

	    return $cs->findAll($v);
	}

	// lay bac sy co id_chair
	public function getDentistChair($id_chair, $start)
	{
		if(!$id_chair)
			return -1;

		$time = DateTime::createFromFormat('Y-m-d H:i:s', $start)->format('H:i:s');
		$dow = DateTime::createFromFormat('Y-m-d H:i:s', $start)->format('w');

		$dentist = VServicesHours::model()->find(array(
			'select'		=> 	'id_dentist, dentist_name, chair_type',
			'condition'		=>	"`id_chair` = $id_chair AND `start` <= '$time' AND '$time' <= `end` AND dow = $dow",
		));

		return $dentist;
	}

	public function checkServiceDentist($id_dentist,$id_service)
	{
		$check = CsServiceUsers::model()->findByAttributes(array('id_dentist'=>$id_dentist,'id_service'=>$id_service));
		if($check)
			return 1;  // bác sỹ có dịch vụ
		return 0; // bác sỹ không có dịch vụ
	}

	/**** kiểm tra thời gian làm việc của bác sỹ ****/
	public function checkWorkingTime($id_dentist, $start_time, $end_time, $id_chair = '')
	{
		$start = date('H:i:s',strtotime($start_time));
		$end = date('H:i:s',strtotime($end_time));
		$dow = date('w', strtotime($start_time));

		if($end < $start) return 0;

		// $timework = VWorkHours::model()->find(array(
		// 	'select' => '*',
		// 	'condition' => '(id_dentist = "'.$id_dentist.'" OR id_chair = "'.$id_chair.'") AND dow = '.$dow.' AND start <= "'.$start.'" AND end >= "'. $end. '"',
		// 	'order' => 'chair_type',
		// ));

		$conDentist = 'id_dentist = "'.$id_dentist.'"';
		if ($id_chair) {
			$conDentist = 'id_chair = "'.$id_chair.'"';
		}

		$timework = CsScheduleChair::model()->find(array(
			'select' => 'id_branch, id_chair, id_dentist, status',
			'condition' => $conDentist . ' AND dow = '.$dow.' AND `start` <= "'.$start.'" AND `end` >= "'. $end. '"',
			'order' => 'status DESC'
		));

		if (!$timework) {
			return 0;  // bác sỹ không có ca làm việc
		}

		$timeOff = CsScheduleTimeOff::model()->find(array(
			'select' => '*',
			'condition' => 'id_dentist = "'.$id_dentist.'" AND start <= "'.$start_time.'" AND end >= "'. $end_time. '"',
		));

		if ($timeOff) {
			return -1;
		}

		return array(
			'id_branch' => $timework->id_branch,
			'id_chair' => $timework->id_chair,
			'id_dentist' => $timework->id_dentist,
		);
	}

	public function checkTimeRelax($id_dentist,$start_time,$end_time)
	{
		$start 	= date_format(date_create($start_time),'H:i:s');
		$end 	= date_format(date_create($end_time),'H:i:s');
		$dow 	= date_format(date_create($start_time),'w');

		$timeR = CsScheduleRelax::model()->find(array(
			'select'    => '*',
			'condition' => "id_dentist = $id_dentist AND dow = $dow AND (start <= '$start' AND '$end' <= end)",
		));
		if(!$timeR)
			return 1;
		else
			return 0;
	}

	/**** kiểm tra trang thai lich hen cua khach hang ****/
	public function checkScheduleStatus($id_customer, $id)
	{
		if(!$id_customer || !$id)
			return -1;

		$sch = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cs_schedule')
            ->where('id_customer=:id_customer', array(':id_customer' => $id_customer))
            ->andWhere('id != '. $id)
            ->andWhere('status IN (2,6,3)')
            ->andWhere('active = 1')
            ->queryAll();

        if(!$sch) {
        	return 1;		// thoa
        }
        return 0;			// khong thoa
	}

	/**** kiểm tra lịch hẹn trùng ****/
	public function checkScheduleEvent($time_start,$time_end,$id_dentist,$id_schedule = 0)
	{
		$start_time = date('Y-m-d H:i:s',strtotime($time_start) + 1);
		$end_time 	= date('Y-m-d H:i:s',strtotime($time_end) - 1);

		if($start_time >= $end_time)
			return -1;			// thời gian bắt đầu nhỏ hơn kết thúc

		$schedule = CsSchedule::model()->find(array(
			'select'    => 'id_dentist, id, status',
			'condition' => 'id_dentist = '.$id_dentist.' AND id != '.$id_schedule.' AND active > 0 AND status >= 0 AND status != 4 AND (((start_time <="' .$start_time. '" AND end_time >= "' .$start_time. '") OR (start_time <= "' .$end_time. '" AND end_time >= "'.$end_time.'")) OR "' . $start_time .'" = DATE_ADD(start_time, INTERVAL 1 SECOND) OR ("'.$start_time.'" <= start_time AND end_time <= "'.$end_time.'"))',
		));

		if(!$schedule || ($schedule->id == $id_schedule && $id_schedule != 0))
			return 1;		// thỏa
		return $schedule->attributes;			// đã có lịch hẹn
	}

	// Ngoai web font end / facebook dat lich
	public function addNewScheduleCheck($newSchedule = array('code'=>'', 'code_confirm'=>'','phone'=>'', 'id_customer'=>'', 'id_dentist'=>'', 'id_author'=>'', 'id_branch'=>'', 'id_chair'=>'0', 'id_service'=>'', 'lenght' => '', 'start_time'=>'', 'end_time'=>'', 'status'=>'', 'source'=>0 ,'active'=>'', 'id_note' => '', 'note'=>''))
	{
		$sch 					= new CsSchedule();
		$sch->attributes		= $newSchedule;

		if($sch->code == '')
			$sch->code	=	$this->createCodeSchedule(date('Y-m-d'));

		if($sch->id_service == '')
			$sch->id_service = 139;

		if($sch->validate()){
			$checkTime = $this->checkWorkingTime($sch->id_dentist,$sch->start_time,$sch->end_time);
			if(!$checkTime)
				return array('status' => '-1', 'error-message' => 'Bác sỹ không có lịch làm việc!');		// bác sỹ không làm việc

			$checkSchedule = $this->checkScheduleEvent($sch->start_time,$sch->end_time,$sch->id_dentist,0);
			if(!$checkSchedule)
				return array('status' => '-2', 'error-message' => 'Có lịch hẹn trùng!');			// có lịch trùng

			if(isset($newSchedule['note']) && (!isset($newSchedule['id_note']) || !$newSchedule['id_note'])){
				$note = CustomerNote::model()->addnote(array(
					'note'    => $newSchedule['note'],
					'id_user' => Yii::app()->user->getState('user_id'),
					'id_customer' => $sch->id_customer,
					'flag'      => 1,			// 1: lich hen
					'important' => 0,
					'status'    => 1,
				));
			}

			if(!$sch->save())
				return array('status' => '0', 'error-message' => 'Có lỗi xảy ra!');		// có lỗi xảy ra

			return array('status' => '1', 'success' => $sch->attributes);
		}
		return array('status' => '-5', 'error-message' => 'Dữ liệu không đúng định dạng!');			// có lỗi xảy ra
	}

	// lich hen ke tiep
	public function addNextScheduleCheck($id_customer, $id_dentist, $id_branch, $start_time, $len, $id_group_history, $id_author, $note = '', $id_quote = '')
	{
		if(!$id_customer || !$id_dentist || !$id_branch || !$start_time || !$len || !$id_group_history) {
			return array('status' => '0', 'error-message' => 'Không đủ dữ liệu!');
		}
		$date_format = "Y-m-d H:i:s";
		$date = date_create($start_time);

		$start_time = date_format($date,$date_format);

		if(isset($start_time['status']) && $start_time['status'] == 0) {
			return array('status' => '0', 'error-message' => 'Thời gian không đúng định dạng!');
		}

		$end_time = date_add($date, date_interval_create_from_date_string($len . " minutes"));
		$end_time = date_format($end_time,$date_format);

		$checkTime = $this->checkWorkingTime($id_dentist,$start_time,$end_time);
		if(!$checkTime)
			return array('status' => '-1', 'error-message' => 'Nha sỹ không làm việc!');		// bác sỹ không làm việc

		$id_chair = $checkTime['id_chair'];

		$checkRelax = $this->checkTimeRelax($id_dentist,$start_time,$end_time);
		if(!$checkRelax)
			return array('status' => '-1', 'error-message' => 'Nha sỹ không làm việc');			// thoi gian nghi trua

		$checkSchedule = $this->checkScheduleEvent($start_time,$end_time,$id_dentist,0);
		if(!$checkSchedule)
			return array('status' => '-2', 'error-message' => 'Có lịch hẹn trùng!');			// có lịch trùng

		$sch = new CsSchedule();

		$sch->id_customer      = $id_customer;
		$sch->id_dentist       = $id_dentist;
		$sch->id_author        = $id_author;
		$sch->id_branch        = $id_branch;
		$sch->start_time       = $start_time;
		$sch->end_time         = $end_time;
		$sch->lenght           = $len;
		$sch->id_group_history = $id_group_history;
		$sch->id_quotation     = $id_quote;
		$sch->note             = $note;

		$sch->id_chair   = $id_chair;
		$sch->id_service = '210';
		$sch->code       = $this->createCodeSchedule();
		$sch->status     = 1;
		$sch->active     = 1;

		if($sch->validate() && $sch->save()) {
			$soap = new SoapService();
			$soap->webservice_server_ws("getAddNewNotiSchedule",array('1','317db7dbff3c4e6ec4bdd092f3b220a8',$sch->id_author,$id_dentist,$sch->id,'add'));

			return array('status' => '1', 'id_schedule' => $sch->id);
		}
		return array('status' => '-3', 'error-message' => $sch->getErrors());
	}

// Admin Dat lich
	public function addNewSchedule($newSchedule = array('code'=>'', 'code_confirm'=>'', 'id_customer'=>'', 'id_dentist'=>'', 'id_author'=>'', 'id_branch'=>'', 'id_chair'=>'', 'id_service'=>'', 'lenght' => '', 'start_time'=>'', 'end_time'=>'', 'status'=>'', 'active'=>'', 'note'=>''))
	{
		$sch 					= new CsSchedule();
		$sch->attributes		= $newSchedule;

		if($sch->code == '')
			$sch->code	=	$this->createCodeSchedule(date('Y-m-d'));

		unset($sch->create_date);

		if($sch->validate() && $sch->save()){
			return array('id' => $sch->id, 'data' => $sch->attributes);
		}

		return 0;
	}

	public function updateNextScheduleCheck($id_schedule, $id_dentist, $len, $start_time, $id_author, $note = '')
	{
		if(!$id_schedule || !$id_dentist || !$start_time || !$len) {
			return array('status' => '0', 'error-message' => 'Không đủ dữ liệu!');
		}
		$date_format = "Y-m-d H:i:s";
		$date = date_create($start_time);

		$start_time = date_format($date,$date_format);

		if(isset($start_time['status']) && $start_time['status'] == 0) {
			return array('status' => '0', 'error-message' => 'Thời gian không đúng định dạng!');
		}

		$end_time = date_add($date, date_interval_create_from_date_string($len . " minutes"));
		$end_time = date_format($end_time,$date_format);

		$up = $this->updateScheduleCheck(array(
				'id'         =>$id_schedule,
				'id_dentist' => $id_dentist,
				'lenght'     => $len,
				'start_time' => $start_time,
				'end_time'   => $end_time,
				'note'       => $note,
				'id_author'  => $id_author,
		));

		if($up['status'] == 1){
			$soap = new SoapService();
			$soap->webservice_server_ws("getAddNewNotiSchedule",array('1','317db7dbff3c4e6ec4bdd092f3b220a8',$id_author,$id_dentist,$id_schedule,'update'));
		}
		return $up;
	}

	public function updateScheduleCheck($updateSchedule = array('id'=>'', 'id_dentist'=>'', 'id_branch'=>'', 'id_chair'=>'', 'id_service'=>'', 'lenght' => '', 'start_time'=>'', 'end_time'=>'', 'id_author'=>'', 'status'=>'', 'active'=>'', 'note'=>''))
	{
		if(!$updateSchedule['id'])
			return -1; 			// ko co id

		$sch = CsSchedule::model()->findByPk($updateSchedule['id']);

		// thay doi thoi gian, thay doi bac sy
		if(strtotime($sch->start_time) != strtotime($updateSchedule['start_time']) ||
			strtotime($sch->end_time) != strtotime($updateSchedule['end_time'])	|| $sch->id_dentist != $updateSchedule['id_dentist'])
		{
			$checkTime = $this->checkWorkingTime($updateSchedule['id_dentist'],$updateSchedule['start_time'],$updateSchedule['end_time']);

			if($checkTime == 0)
				return array('status' => '-1', 'error-message' => 'Nha sỹ không làm việc!');		// bác sỹ không làm việc

			if($updateSchedule['id_chair'] == '' || !isset($updateSchedule['id_chair']))
				$updateSchedule['id_chair'] = $checkTime['id_chair'];

			$checkRelax = $this->checkTimeRelax($id_dentist,$start_time,$end_time);
			if(!$checkRelax)
				return array('status' => '-1', 'error-message' => 'Nha sỹ không làm việc');			// thoi gian nghi trua

			$checkSchedule = $this->checkScheduleEvent($updateSchedule['start_time'],$updateSchedule['end_time'],$updateSchedule['id_dentist'],$updateSchedule['id']);
			if($checkSchedule == 0)
				return array('status' => '-2', 'error-message' => 'Có lịch hẹn trùng!');			// có lịch trùng
		}

		$sch->attributes		= $updateSchedule;

		if($sch->validate() && $sch->save()){
			return array('status' => '1', 'id_schedule' => $sch->id, 'success' => $sch->attributes);
		}
		else
			return array('status' => '-3', 'error-message' => $sch->getErrors());
	}


	public function updateSchedule($updateSchedule = array()) {
		if (!$updateSchedule['id']) {
			return -1;
		}

		$sch = CsSchedule::model()->findByPk($updateSchedule['id']);

		if(!$sch) {
			return -2;
		}

		// co ma note -> update
		if($sch->id_customer){
			if($sch->id_note && isset($updateSchedule['note'])) {
				$note = CustomerNote::model()->updatenote($sch->id_note, $updateSchedule['note']);
			}
			elseif(isset($updateSchedule['note']) && $updateSchedule['note'] != '')  {
				$note = CustomerNote::model()->addnote(array(
					'note'        => $updateSchedule['note'],
					'id_user'     => Yii::app()->user->getState('user_id'),
					'id_customer' => $sch->id_customer,
					'flag'        => 1,			// 1: lich hen
					'important'   => 0,
					'status'      => 1,
				));

				if(isset($note['id']))
					$updateSchedule['id_note'] = $note['id'];
			}

		}

		if(isset($updateSchedule['id_quotation']) && $updateSchedule['id_quotation']){
			if(!isset($updateSchedule['id_invoice']) || !$updateSchedule['id_invoice']){
				$lstInvOld = Invoice::model()->findByAttributes(
								array('id_quotation' => $updateSchedule['id_quotation']),
								array('order'=>'create_date DESC')
							);

				if($lstInvOld)
					$updateSchedule['id_invoice'] = $lstInvOld->id;
			}
		}

		unset($updateSchedule['id_author']);
		$sch->attributes = $updateSchedule;

		if ($sch->validate() && $sch->save()) {
			if ($sch->status == 4) {
				$date = DateTime::createFromFormat('Y-m-d H:i:s', $sch->start_time);
				if ($date) {
					Customer::model()->updateLastTreatment($sch->id_customer, $date->format('Y-m-d'));
					CustomerScheduleRemind::model()->updateDateRemindTime(($sch->id_customer));
				}
			}
			return array('id'=>$sch->id,'data'=>$sch->attributes);
		} else {
			return 0;		// có lỗi xảy ra
		}
	}

	// cap nhat ma xac nhan
	public function updateCodeConfirm($id_schedule)
	{
		if(!$id_schedule)
			return -1;

		$codeCF = $this->codeConfirm();

		$up = CsSchedule::model()->updateByPk($id_schedule, array('code_confirm'=>$codeCF));

		if($up) {
			return $codeCF;
		}
		return 0;
	}

	// cap nhat ma code xac thuc
	public function updateScheduleCode($updateSchedule = array('status'=>'', 'active'=>'','id'=>'','code'=>''))
	{
		if(!$updateSchedule['id'] || !$updateSchedule['code'])
			return -1; 			// ko co id

		$sch 					= CsSchedule::model()->findByPk($updateSchedule['id']);
		if($sch->active == -1) {
			return array('status'=>-1,'error'=>'Có lỗi xảy ra. Xin vui lòng thử lại sau!');
		}
		if($sch->code_confirm != $updateSchedule['code'])
			return array('status'=>0,'error'=>'Mã xác thực không trùng khớp!');

		$sch->status = $updateSchedule['status'];
		$sch->active = $updateSchedule['active'];

		if($sch->validate() && $sch->save()){
			return array('status'=>1,'data'=>$sch->attributes);
		}
		else
			return array('status'=>-1,'error'=>'Có lỗi xảy ra. Xin vui lòng thử lại sau!');		// có lỗi xảy ra
	}

	public function cancelSchedule($id_schedule)
	{
		if(!$id_schedule) {
			return -1;		// ko có mã lich hen
		}

		$cancel = CsSchedule::model()->updateByPk($id_schedule, array('status'=>-1));

		if($cancel)
			return 1;
		return 0;
	}

	public function codeConfirm($len = 4) {
		$str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = '';
		$strlen = strlen($str);
		for ($i=0; $i < $len ; $i++) {
			$code .= $str[rand(0,$strlen-1)];
		}
		return $code;
	}

	public function createCodeSchedule($date='')
	{
		if($date == '')
			$date = date('Y-m-d');

		$date = date('Y-m-d', strtotime($date));
		$str = '01234567789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$strlen = strlen($str);
		$codelen = 4;
		$code = '';
		for ($i=0; $i < $codelen ; $i++) {
			$code .= $str[rand(0,$strlen-1)];
		}
		$schenum = CsSchedule::model()->count(array('condition' => 'date(create_date)="'.$date.'"')) + 1;
		$codenum = str_pad($schenum, '4' ,'0', STR_PAD_LEFT);
		$code .= $codenum;
		return $code;
	}

	public function getSchedule($id_schedule)
	{
		return CsSchedule::model()->findByPk($id_schedule);
	}

	/* up code schedule
		active
	*/
	public function upCode($code_number,$status, $active) {
		$rs = CsSchedule::model()->findByAttributes(array('code'=>$code_number));
		if($rs) {
			$con = Yii::app()->db;
			$sql="UPDATE cs_schedule SET status='$status',active='$active' WHERE code='$code_number'";
			$data=$con->createCommand($sql)->execute();
			if($data){
				SoapService::soap_server_ws("getKeyWordProductListByLine",array(1,"317db7dbff3c4e6ec4bdd092f3b220a8",$rs->id_author,$rs->id_dentist,$rs->id));
				return 1;		// cập nhật thành công
			}
			else{
				return 0;		// cập nhật thất bại
			}
		}
		return -1;				// không có mã code number trong lịch
	}

	public function getBlankTime($id_branch, $id_service, $id_dentist='', $start_date, $end_date, $len = '', $chair_type = '', $book_onl = '') {
		$format 	= 'Y-m-d';
		$max_num 	= 3;

		if(!$start_date || !$end_date || !$id_service)
			return -1;	// ko du du lieu

		$start = DateTime::createFromFormat($format, $start_date)->format($format);
		$end   = DateTime::createFromFormat($format, $end_date)->format($format);

		if(!$start || !$end) {
			return -2;		// thời gian bắt đầu và kết thúc không đúng định dạng
		}

		$con  = '1=1';
		$conS = '(("'.$start.'" <= DATE(start_time) AND DATE(start_time) <= "'.$end.'") OR (DATE(start_time) <= "'.$start.'" AND "'.$end.'" <= DATE(end_time)))';
		$conR = "1=1";

		// thoi gian cho ghe kham
		if($chair_type == 1){
			$con .= " AND chair_type = 1";
		}

		if($book_onl){
			$con .= " AND dentist_book_onl = 1";
		}

		if($id_branch){
			$con  .= ' AND id_branch = '.$id_branch;
			$conR .= " AND id_branch = $id_branch";
			$conS .= ' AND id_branch = '.$id_branch;
		}

		if($id_dentist){		// khám có chọn bác sỹ
			$con  .= " AND id_dentist = $id_dentist ";
			$conS .= ' AND id_dentist = '.$id_dentist;
			$conR .= " AND id_dentist = $id_dentist";
		}
		else {		// kham khong chon bac sy
			$con .= " AND id_service = $id_service ";
		}

		// thời gian làm việc
		$worktime = Yii::app()->db->createCommand("
			SELECT 	id_dentist, dow, start, end, id_chair, chair_type, id_branch
			FROM 	v_services_hours
			WHERE 	$con AND `status` = 1 ORDER BY dow, start, id_dentist
		")->queryAll();

		// thời gian có lịch hẹn
		$schtime = Yii::app()->db->createCommand("
			SELECT 	id_dentist, id_chair, chair_type, id_service, start_time, end_time, DAYOFWEEK(start_time)-1 as dow, DATE(start_time) AS day
			FROM 	v_schedule
			WHERE 	$conS AND status >= 0 AND status_active >= 1 ORDER BY id_dentist, start_time
		")->queryAll();

		// thoi gian nghỉ trua cua bac sy - thieu id_chair
		$timeRelax = Yii::app()->db->createCommand("
			SELECT 	id_dentist, dow, start, end
			FROM 	cs_schedule_relax
			WHERE 	$conR ORDER BY start, id_dentist
		")->queryAll();

		$day  = new DateTime($start);
		$end  = new DateTime($end);
		$lenD = 0;
		$free = array();
		$f    = 0;

		if($len == '')
			$len = CsService::model()->findByPk($id_service)->length;

		// lich nghi phep
		$schOff = array_filter($schtime,function($v){
					if(!$v['id_chair'] && $v['id_service'] == 0)
							return true;
				});

		$dateOff = array();
		if($schOff){
			foreach ($schOff as $key => $value) {
				$startOff = new DateTime($value['start_time']);
				$endOff   = new DateTime($value['end_time']);

				while($startOff <= $endOff){
					$dateOff[] = $startOff->format('Y-m-d');
					$startOff = date_add($startOff, date_interval_create_from_date_string('1 days'));
				}
			}
		}

		while ($day <= $end) {
			$start_check = $day->format('Y-m-d');
			$dow = $day->format('w');
			$time = 0;
			if(!in_array($start_check,$dateOff)){
				if($id_dentist) {
					// thời gian làm việc của bác sỹ theo ngày
					$timeW = array_filter($worktime,function($v) use ($dow,$id_dentist){
						if($v['dow'] == $dow && $v['id_dentist'] == $id_dentist)
								return true;
					});
					// thời gian lịch hẹn có bác sỹ theo ngày
					$timeS = array_filter($schtime,function($v) use ($dow,$id_dentist){
						if($v['dow'] == $dow && $v['id_dentist'] == $id_dentist)
								return true;
					});

					// thoi gian nghi trua theo ngay
					$timeR = array_filter($timeRelax,function($v) use ($dow,$id_dentist){
						if($v['dow'] == $dow && $v['id_dentist'] == $id_dentist)
								return true;
					});
				}

				else {
					$timeW = array_filter($worktime,function($v) use (&$dow,$id_service){
						if($v['dow'] == $dow)
								return true;
					});

					// thời gian lịch hẹn có dịch vụ là khám tư vấn
					$timeS = array_filter($schtime,function($v) use (&$dow,$id_service){
						if($v['dow'] == $dow){
								return true;
							}
					});

					$timeR = array_filter($timeRelax,function($v) use ($dow,$id_dentist){
						if($v['dow'] == $dow)
								return true;
					});
				}

				$timeAF = $this->getTimeAfterRelax($timeW,$timeR,$id_dentist);
				$free1  = $this->getTime($timeAF,$timeS,$len);

				$time   = $this->rangeTime($free1,$len,-1,0);
			}

			$free[] = array(
				'dow'  => $dow,
				'day'  => $day->format('Y-m-d'),
				'len'  => $len + $lenD,
				'time' => $time,
			);

			date_add($day,new DateInterval('P1D'));
		}

		return $free;
	}

	// thoi gian trong = thoi gian lam viec - thoi gian nghi trua
	function getTimeAfterRelax($timeWork, $timeRelax, $id_dentist){
		$time = array();
		if($id_dentist){
			foreach ($timeWork as $key => $val) {
				$st    = date('H:i:s',strtotime($val['start']));
				$en    = date('H:i:s',strtotime($val['end']));

				foreach ($timeRelax as $key => $value) {
					$str = date('H:i:s',strtotime($value['start']));
					$enr = date('H:i:s',strtotime($value['end']));

					$ck = $this->checkTime($st, $en, $str, $enr);

					switch ($ck) 	{
						case '1':			// nam giua
							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$st,
								'end'        => $str,
								'id_branch'	=> $val['id_branch'],
							);

							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$enr,
								'end'        => $en,
								'id_branch'	=> $val['id_branch'],
							);
							break;
						case '2':			// trung bat dau
							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$enr,
								'end'        => $en,
								'id_branch'	=> $val['id_branch'],
							);
							break;
						case '3':			// trung ket thuc
							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$st,
								'end'        => $str,
								'id_branch'	=> $val['id_branch'],
							);
							break;
						default:
							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$st,
								'end'        => $en,
								'id_branch'	=> $val['id_branch'],
							);
							break;
					}
				}
			}
		}
		else {
			foreach ($timeWork as $key => $val) {
				$st    = date('H:i:s',strtotime($val['start']));
				$en    = date('H:i:s',strtotime($val['end']));

				$id_dentist = $val['id_dentist'];

				$timeR = array_filter($timeRelax,function($v) use ($id_dentist){
					if($v['id_dentist'] == $id_dentist)
							return true;
				});

				foreach ($timeR as $key => $value) {
					$str = date('H:i:s',strtotime($value['start']));
					$enr = date('H:i:s',strtotime($value['end']));

					$ck = $this->checkTime($st, $en, $str, $enr);

					switch ($ck) 	{
						case '1':			// nam giua
							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$st,
								'end'        => $str,
								'id_branch'	=> $val['id_branch'],
							);

							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$enr,
								'end'        => $en,
								'id_branch'	=> $val['id_branch'],
							);
							break;
						case '2':			// trung bat dau
							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$enr,
								'end'        => $en,
								'id_branch'	=> $val['id_branch'],
							);
							break;
						case '3':			// trung ket thuc
							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$st,
								'end'        => $str,
								'id_branch'	=> $val['id_branch'],
							);
							break;
						default:
							$time[] = array(
								'id_dentist' =>	$val['id_dentist'],
								'id_chair'   => $val['id_chair'],
								'dow'        =>	$val['dow'],
								'start'      =>	$st,
								'end'        => $en,
								'id_branch'	=> $val['id_branch']  ,
							);
							break;
					}
				}
			}
		}


		return $time;
	}
	// lấy lịch hẹn và thời gian trống
	function getTime($timeW,$timeS,$len){
		if($timeW == '' || empty($timeW))
			return 0;			// lịch ko có bác sỹ làm việc theo dịch vụ

		foreach ($timeW as $key => $val) {
			$wst[]     = date('H:i:s',strtotime($val['start']));
			$wen[]     = date('H:i:s',strtotime($val['end']));
			$dentist[] = $val['id_dentist'];
			$chair[]   = $val['id_chair'];
			$branch[]  = $val['id_branch'];
		}

		$start_free = $wst[0];	// thời gian trống bắt đầu = thời gian bắt đầu làm việc
		$end_free   = $wen[0];	// thời gian trống kết thúc = thời gian kết thúc làm việc
		$id_dentist = $dentist[0];
		$id_chair   = $chair[0];
		$id_branch  = $branch[0];
		$free       = array();
		$s          = 0;		// biến chạy thời gian làm việc
		$f          = 0;

		foreach ($timeS as $key => $val){
			$st = date('H:i:s',strtotime($val['start_time']));
			$en = date('H:i:s',strtotime($val['end_time']));

			if($id_dentist != $val['id_dentist']){
				$free[]     = $start_free.'-'.$end_free.'-'.$id_dentist.'-'.$id_chair.'-'.$id_branch;
				$s          = $s + 1;
				if(isset($wst[$s])) {
					$start_free = $wst[$s];
					$end_free   = $wen[$s];
					$id_dentist = $dentist[$s];
					$id_chair   = $chair[$s];
					$id_branch = $branch[$s];
				}
				else {
					$start_free = '';
					$end_free   = '';
					$id_dentist = '';
					$id_chair   = '';
					$id_branch = '';
				}
			}

			$check = $this->checkTime($start_free,$end_free,$st,$en);

			switch ($check) {
				case 1: 		// lịch hẹn nằm giữa thời gian trống
					$free[]     = $start_free.'-'.$st.'-'.$id_dentist.'-'.$id_chair.'-'.$id_branch;
					$start_free = $en;
					break;

				case 2: 		// lịch hẹn trùng thời gian bắt đầu
					$start_free = $en;
					break;

				case 3: case -2: 		// lịch hẹn trùng thời gian kết thúc
					$free[]  = $start_free.'-'.$st.'-'.$id_dentist.'-'.$id_chair.'-'.$id_branch;
					$s          = $s+1;
					if(isset($wst[$s])) {
						$start_free = $wst[$s];
						$end_free   = $wen[$s];
						$id_dentist = $dentist[$s];
						$id_chair   = $chair[$s];
						$id_branch = $branch[$s];
					}
					else {
						$start_free = '';
						$end_free   = '';
						$id_dentist = '';
						$id_chair   = '';
						$id_branch = '';
					}
					break;

				case 4: 		// lịch hẹn trùng cả hai
					$s          = $s+1;
					if(isset($wst[$s])) {
						$start_free = $wst[$s];
						$end_free   = $wen[$s];
						$id_dentist = $dentist[$s];
						$id_chair   = $chair[$s];
						$id_branch = $branch[$s];
					}
					else {
						$s          = 	$s+1;
						$start_free =  	'';
						$end_free   = 	'';
						$id_dentist =  	'';
						$id_chair   = 	'';
						$id_branch = '';
					}
					break;

				case -4:		// thời gian trống nằm trước thời gian lịch hẹn
					$free[] = $start_free.'-'.$end_free.'-'.$id_dentist.'-'.$id_chair.'-'.$id_branch;
					$s      = $s+1;

					if(isset($wst[$s])) {
						$start_free = $wst[$s];
						$end_free   = $wen[$s];
						$id_dentist = $dentist[$s];
						$id_chair = $chair[$s];
						$id_branch = $branch[$s];
					}
					else {
						$start_free =  	'';
						$end_free   = 	'';
						$id_dentist =  	'';
						$id_chair = '';
						$id_branch = '';
					}

					if($start_free < $st) {
						$free[] = $start_free.'-'.$st.'-'.$id_dentist.'-'.$id_chair.'-'.$id_branch;
					}
					$start_free       = $en;
					break;

				default:				// lịch hẹn ko nằm trong thời gian trống
					$free[] = $start_free.'-'.$end_free.'-'.$id_dentist.'-'.$id_chair.'-'.$id_branch;
					$s      = $s+1;
					if(isset($wst[$s])) {
						$start_free = $wst[$s];
						$end_free   = $wen[$s];
						$id_dentist = $dentist[$s];
						$id_chair   = $chair[$s];
						$id_branch = $branch[$s];
					}
					else {
						$start_free =  	'';
						$end_free   = 	'';
						$id_dentist =  	'';
						$id_chair   = '';
						$id_branch = '';
					}
					break;
			}
		}
		// kiểm tra thời gian còn lại
		if($start_free < $end_free)
		{
			$free[] = $start_free.'-'.$end_free.'-'.$id_dentist.'-'.$id_chair.'-'.$id_branch;
		}
		// thời gian trống ko có lịch hẹn
		if($s < count($wst)-1)
		{
			while ($s < count($wst)-1) {
				$s      = $s +1;
				$free[] = $wst[$s].'-'.$wen[$s].'-'.$dentist[$s].'-'.$chair[$s].'-'.$id_branch;
			}
		}
		return $free;
	}
	// kiểm tra lịch hẹn với thời gian trống
	function checkTime($start_free, $end_free, $start_sch, $end_sch) {
		if($start_free <= $start_sch && $end_sch <= $end_free) {
			if($start_free == $start_sch && $end_sch == $end_free)
				return 4;		// lịch hẹn trùng cả hai
			if($start_free == $start_sch)
				return 2;		// lịch hẹn trùng thời gian bắt đầu
			if($end_sch == $end_free)
				return 3;		// lịch hẹn trùng thời gian kết thúc
			return 1;			// lịch hẹn không trùng với mốc thời gian bắt đầu hay kết thúc
		}
		else {
			if($start_free <= $start_sch && $start_sch <= $end_free)
				return -2;		// thời gian bắt đầu của lịch hẹn nằm trong thời gian trống
			if($start_free <= $end_sch && $end_sch <= $end_free)
				return -3;		// thời gian kết thúc của lịch hẹn nằm trong thời gian trống
			if($end_free < $start_sch)
				return -4;		// thời gian trống nằm trước thời gian lịch hẹn
			if($start_free > $end_sch)
				return -5;		// thời gian trống nằm sau lịch hẹn
			return -1;		// lịch hẹn ko nằm trong thời gian trống
		}
	}
	// lay gia tri gan nhat
	function getNestValue($arr, $val)
	{
		sort($arr);
		$test = $arr;

		$t = 0;
		while (isset($arr[$t])) {
			$l = $t;
			$h = $t+1;
			if(!isset($arr[$h]) && $arr[$l] < $val){
				return $l;
				break;
			}
			if($arr[$l] < $val && $val < $arr[$h]){
				return $l;
				break;
			}
			else
				$t++;
		}
	}

	// sắp xếp lịch trống
	function rangeTime($free1,$len,$free2,$lenD) {
		$time = array();
		$ti   = 0;
		$r    = 0;
		$maxT = array();
		$minT = array();
		if($free1 == 0 || empty($free1))
			return 0;		// ko có dữ liệu
		if($free2 == -1) { // ko tồn tại bác sỹ thứ 2
			foreach ($free1 as $key => $val) {

				$t          = explode('-', $val);
				$start      = date('H:i:s',strtotime($t[0]));
				$end        = date('H:i:s',strtotime($t[1]));
				$id_dentist = $t[2];
				$id_chair   = $t[3];
				$id_branch = $t[4];

				if(in_array($start, $minT) || in_array($end, $maxT)){
					continue;
				}
				else{
					$minT[] = $start;
					$maxT[] = $end;

					while (strtotime($start)+$len*60 <= strtotime($end)) {
						$time[] = $start.'.'.date('H:i:s',strtotime($start)+$len*60).'.'.$id_dentist.'-'.$id_chair.'-'.$len.'-'.$id_branch;
						$start = date('H:i:s',strtotime($start)+$len*60);
					}
				}
			}
		}
		else {
			if($free2 == 0 || empty($free2))
				return 0;		// ko có dữ liệu
			// free1: thời gian khám
			foreach ($free1 as $key => $val) {
				$t = explode('-', $val);
				$start1[] = date('H:i:s',strtotime($t[0]));
				$end1[] = date('H:i:s',strtotime($t[1]));
				$subdentist[]  = $t[2];
				$subchair[] = $t[3];
			}

			$st1 = $start1[0];
			$en1 = $end1[0];
			$id_subchair = $subchair[0];
			$id_subdentist = $subdentist[0];
			$s = 0;
			// free2: thời gian tư vấn với bác sỹ chọn
			foreach ($free2 as $key => $val) {
				$t = explode('-', $val);
				$start2 = date('H:i:s',strtotime($t[0]));
				$end2 = date('H:i:s',strtotime($t[1]));
				$id_dentist = $t[2];
				$id_chair = $t[3];


				$chk = $this->checkTime($st1, $en1, $start2, $end2);

				if($chk == -1){
					($s<count($start1)-1)?($s = $s+1):'';
					$st1 = $start1[$s];
					$en1 = $end1[$s];
					$id_subchair = $subchair[$s];
					$id_subdentist = $subdentist[$s];
					continue;
				}
				else
				{
					while (strtotime($st1)+$len*60 <= strtotime($en1)) {
						$st_temp = date('H:i:s',strtotime($st1)+$len*60);

						$st_ex = $st1;
						$en_ex = $st_temp;
						$st_tr = $st_temp;
						$en_tr = date('H:i:s',strtotime($st_temp)+$lenD*60);

						$check = $this->checkTime($start2, $end2, $st_tr, $en_tr);
						if($check > 0) {
							$time[$ti++] = $st_ex.'.'.$en_tr.'.'.$id_dentist.'-'.$id_chair.'-'.$lenD.'.'.$id_subdentist.'-'.$id_subchair.'-'.$len;
						}
						if($check == -4)
							break;
						$st1 = date('H:i:s',strtotime($st1)+$len*60);
					}
					($s<count($start1)-1)?($s = $s+1):'';
					$st1 = $start1[$s];
					$en1 = $end1[$s];
					$id_subchair = $subchair[$s];
					$id_subdentist = $subdentist[$s];
				}
			}
		}
		if(empty($time))
			$time = 0;
		return $time;
	}

	public function getCodeActive($code_schedule) {
		return CsSchedule::model()->find(array('code'=>$code_schedule))->code_confirm;
	}

	public function saveNotificationSchedule($id_author,$id_dentist,$id_schedule,$action){
		if($id_schedule){
			SoapService::soap_server_ws("getAddNewNotiSchedule",array(1,"317db7dbff3c4e6ec4bdd092f3b220a8",
				$id_author,$id_dentist,$id_schedule,$action));
		}

	}

	// function getSmsConnectInfo($id_branch) {
	// 	if($id_branch == 1) {
	// 	    return array(
	// 	    	'url' => 'http://14.241.253.96:8083/brandnamews.asmx?wsdl',
	// 	    	'username' => 'nhakhoa2000ws',
	// 	    	'password' => 'NhaKhoa2@o0*#',
	// 	    	'brandname' => 'NhaKhoa2000',
	// 	    	'loaitin' => 1
	// 	    );
	// 	}
	// 	else {
	// 		return array(
	// 	    	'url' => 'http://14.241.253.96:8083/brandnamews.asmx?wsdl',
	// 	    	'username' => 'nhakhoa2000ws',
	// 	    	'password' => 'NhaKhoa2@o0*#',
	// 	    	'brandname' => 'NhaKhoa2000',
	// 	    	'loaitin' => 1
	// 	    );
	// 	}
	// }

	function sendSms($phone,$message,$id_branch) {
	    // $SmsConnectInfo = $this->getSmsConnectInfo($id_branch);
	    // $username = $SmsConnectInfo['username'];
	    // $password = $SmsConnectInfo['password'];

	    // $brandname = $SmsConnectInfo['brandname'];
	    // $loaitin = $SmsConnectInfo['loaitin'];

	    // $client = new SoapClient($SmsConnectInfo['url']);

	  	$phone = CsLead::model()->getVnPhone($phone);
	  	// $params = array("username"=>$username,"password"=>$password,"phonenumber"=>$phone,"message"=>$message,"brandname"=>$brandname,"loaitin"=>$loaitin);

	  	// $smsResult = $client->__soapCall('SendMt', array('parameters' => $params));
		$smsResult = Yii::app()->sms->send($phone, $message, 'SendMt');
		return  $smsResult->SendMtResult;
    }

    function TimeJson()
	{
		$cs = new CsScheduleChair;
		$v  = new CDbCriteria();

		// thoi gian lam viec
		$v->addCondition("status = 1");
		$v->addCondition("id_chair IS NOT NULL");
		$v->group  = 'id_branch, id_dentist, dow, start, end';

		$time      = $cs->findAll($v);

		$dentist   = GpUsers::model()->findAllByAttributes(array('group_id' => 3));

		// danh sach chi nhanh
		$branch    = Branch::model()->findAll();

		// danh sach ghe
		$chair 		= Chair::model()->findAll();

		// thoi gian nghi trua cua bac sy
		$timeBreak = CsScheduleRelax::model()->findAll();

		$timeD = array();		// thoi gian bac sy
		$timeC = array();		// thoi gian ghe
		$t = 0;

		// thoi gian nghi cua nha sy
		foreach ($branch as $k => $br) {
			$id_br      = $br['id'];
			// loc du lieu theo chi nhanh
			$timeBranch = array_filter($time, function ($v) use ($id_br){
				return $v['id_branch'] == $id_br;
			});

			if($timeBranch) {
				foreach ($dentist as $key => $value) {
					$id_dentist  = $value['id'];
					// loc du lieu theo nha sy
					$timeDentist = array_filter($timeBranch, function($v) use ($id_dentist){
						if($v['id_dentist'] == $id_dentist)
							return true;
					});

					/*return $timeDentist;

					if(!$timeDentist) {
						continue;
					}*/

					$timeBr = array_filter($timeBreak, function($v) use ($id_dentist){
						if($v['id_dentist'] == $id_dentist)
							return true;
					});

					// loc du lieu theo ngay trong tuan
					$timeD[] = array(
						'id_den'    => $id_dentist,
						'den'		=> $value['name'],
						'id_branch' => $id_br,
						'time'      => $this->timeBreakJson($br,$timeDentist,$timeBr),
					);
				}
			}
		}

		// thoi gian nghi cua ghe
		foreach ($branch as $k => $br) {
			$id_br      = $br['id'];
			// danh sach ghe theo chi nhanh
			$timeBranch = array_filter($time, function ($v) use ($id_br){
				return $v['id_branch'] == $id_br;
			});

			if($timeBranch) {
				foreach ($chair as $key => $value) {
					$id_chair  = $value['id'];

					// danh sach thoi gian theo ghe kham
					$timeChair = array_filter($timeBranch, function($v) use ($id_chair){
						if($v['id_chair'] == $id_chair)
							return true;
					});

					if($timeChair) {
						$timeC[] = array(
							'id_chair'  => $id_chair,
							'id_branch' => $id_br,
							'time'      => $this->timeBreakChair($br, $timeChair),
						);
					}
				}
			}
		}

		$f = file_put_contents(Yii::getPathOfAlias('webroot').DS.'time.json',json_encode(array('dentist'=>$timeD, 'chair' => $timeC)));

		return array('dentist'=>$timeD, 'chair' => $timeC);
	}

	function timeBreakChair($branch, $timeChair)
	{
		// thoi gian lam viec cua chi nhanh
		$brWS = $branch['start_work'];
		$brWE = $branch['end_work'];

		$maxW      = 6;
		$dow       = 0;
		$timeBreak = array();

		while ($dow <= $maxW) {
			// thoi gian lam viec
			$timeWC = array_filter($timeChair, function ($k) use ($dow) {
			 	return $k['dow'] == $dow;
			});

			usort($timeWC, function($a, $b) {
			    return $a['start'] - $b['start'];
			});

			$start = $brWS;
			$end   = $brWE;
			$stW   = $brWS;
			$enW   = $brWE;

			if(!$timeWC) {
				$timeBreak[] = $dow . "-".$start."-".$end;
			}
			else {
				foreach ($timeWC as $key => $value) {
					$stC = $value['start'];
					$enC = $value['end'];

					$chk = $this->checkTime($stW, $enW, $stC, $enC);

					switch ($chk) {
						case '1':		// Chair work khong nam trong thoi gian vat dau hay ket thuc
							$timeBreak[] = $dow . "-".$stW."-".$stC;
							$stW = $enC;
							break;
						case '2':		// Chair work trung moc thoi gian bat dau
							$stW = $enC;
							break;
						case '3':		// Chair work trung moc thoi gian ket thuc
							$timeBreak[] = $dow . "-".$stW."-".$stC;
							$stW = $enC;
							break;
						case '4':		// Chair work trung ca 2
							$stW = $enC;
							break;
						default:
							# code...
							break;
					}
				}
				if($enW != $stW) {
					$timeBreak[] = $dow . "-".$stW."-".$enW;
				}
			}
			$dow ++;
		}
		return $timeBreak;
	}

	function timeBreakJson($branch, $time, $timeBr)
	{
		// thoi gian lam viec cua chi nhanh
		$brWS = $branch['start_work'];
		$brWE = $branch['end_work'];

		$maxW      = 6;
		$dow       = 0;
		$timeBreak = array();

		while ($dow <= $maxW) {
			// thoi gian lam viec
			$timeW = array_filter($time, function ($k) use ($dow) {
			 	return $k['dow'] == $dow && $k['status'] == 1;
			});

			// thoi gian nghi
			$timeB = array_filter($timeBr, function($k) use ($dow) {
				return $k['dow'] == $dow;
			});

			$start = $brWS;
			$end   = $brWE;

			$stW = $brWS;
			$enW = $brWE;

			if(!$timeW) {
				$timeBreak[] = $dow . "-".$start."-".$end;
			}
			else {
				$timeTemp = array();
				$st = $brWS;
				$en = $brWE;
				foreach ($timeB as $key => $value) {
					$timeBreak[] = $value['dow'] . "-".$value['start']."-".$value['end'];
				}

				foreach ($timeW as $key => $v) {

					$stD = $v['start'];
					$enD = $v['end'];

					$ck = $this->checkTime($st, $en, $stD, $enD);
					switch ($ck) {
						case '1':		// nam trong va khong trung thoi gian
							$timeBreak[] = $v['dow'] . "-".$st."-".$stD;
							$st = $enD;
							break;
						case '2':		// trung thoi gian bat dau
							$st = $enD;
							break;
						case '3':		// trung thoi gian ket thuc
							$timeBreak[] = $v['dow'] . "-".$st."-".$stD;
							$st = $enD;
							break;
						case '4':		// trung ca 2
							$st = $enD;
							break;
						default:
							//$st = $
							break;
					}
				}
				if($st < $en)
					$timeBreak[] = $v['dow'] . "-".$st."-".$en;
			}
			$dow ++;
		}
		return $timeBreak;
	}

	public function getTotalSchedule($branch,$month,$year) //Tổng số lịch hẹn
	{
		$con = Yii::app()->db;
		$sql = "select count(code) as totalSchedule from cs_schedule where 1 = 1";
		if ($branch) {
			$sql.=" and id_branch=$branch";
		}

		if($month && $year){
			$sql.= " and (month(cs_schedule.`create_date`)='$month' and year(cs_schedule.`create_date`)='$year')";
		}

		$data = $con->createCommand($sql)->queryAll();
		if ($data) {
			return $data[0]['totalSchedule'];
		}
		else
			return 0;
	}

	public function getTotalTimeCure($branch,$month,$year)//tổng số giờ điều trị
	{
		$con = Yii::app()->db;
		$sql = "select SUM(lenght) as totalTime from cs_schedule where 1 = 1 and (status=3 or status=4)";
		if ($branch) {
			$sql.=" and id_branch=$branch";
		}

		if($month && $year){
			$sql.= " and (month(cs_schedule.`create_date`)='$month' and year(cs_schedule.`create_date`)='$year')";
		}

		$data = $con->createCommand($sql)->queryAll();
		if ($data) {
			return (int)$data[0]['totalTime'];
		}
		else
			return 0;
	}
	public function getTotalTimesCure($branch,$status,$month,$year)//tổng số điều trị hoặc tổng số điều trị hoàn tất
	{
		$con = Yii::app()->db;
		$sql = "select count(code) as totalTimesCure from cs_schedule where 1 = 1";
		if ($status) {
			$sql.=" and status =$status";
		}
		else
			$sql.=" and (status =3 or status = 4)";
		if ($branch) {
			$sql.=" and id_branch=$branch";
		}
		if($month && $year){
			$sql.= " and (month(cs_schedule.`create_date`)='$month' and year(cs_schedule.`create_date`)='$year')";
		}
		$data = $con->createCommand($sql)->queryAll();
		if ($data) {
			return $data[0]['totalTimesCure'];
		}
		else
			return 0;
	}
	public function customerSpend($lstUser,$branch,$type_time,$to_date)
	{
		$con = Yii::app()->db;
		$sql = 'select customer.`fullname`, COUNT(DISTINCT cs_schedule.`id_service`) AS Service_number ,COUNT(cs_schedule.code) AS Schedule_number, SUM(DISTINCT quotation.`sum_amount`) AS sum_amount FROM cs_schedule LEFT JOIN customer ON cs_schedule.`id_customer`=customer.`id` LEFT JOIN quotation ON cs_schedule.`id_customer` = quotation.`id_customer`WHERE 1=1';
		if ($lstUser) {
			$sql.=" and cs_schedule.`id_dentist`=$lstUser";
		}
		if ($branch) {
			$sql.=" and cs_schedule.`id_branch`=$branch";
		}
		if ($type_time) {
			if ($type_time == 1) {
				$time = date('Y-m-d');
				$sql.= " and DATE(cs_schedule.`create_date`)=$time";
			}
			else if ($type_time == 2)
			{
				$time_fisrt = date('Y-m-d',strtotime('monday this week'));
				$time_last = date('Y-m-d',strtotime('sunday this week'));
				$sql.= " and (DATE(cs_schedule.`create_date`)>=$time_fisrt and DATE(cs_schedule.`create_date`)<=$time_last)";
			}
			else if ($type_time==3)
			{
				$time = date('m',strtotime(date('Y-m-d')));
				$sql.= " and MONTH(cs_schedule.`create_date`) = $time";
			}
			else if ($type_time==4)
			{
				$time = date('m',strtotime(date('Y-m-d'). ' - 1 month')); //tháng trước
	            $sql.=" and MONTH(cs_schedule.`create_date`) = $time";
			}
		}
		$sql.=" GROUP BY cs_schedule.`id_customer`";
		// print_r($sql);
		// exit();
		$data = $con->createCommand($sql)->queryAll();
		if ($data) {
			return $data;
		}
	}
	public function totalCustomerSpend($lstUser,$branch,$type_time,$to_date)
	{
		$con = Yii::app()->db;
		$sql = 'select COUNT(cs_schedule.code) AS Schedule_number,COUNT(DISTINCT cs_schedule.`id_service`) AS Service_number , SUM(DISTINCT quotation.`sum_amount`) AS sum_amount FROM cs_schedule LEFT JOIN customer ON cs_schedule.`id_customer`=customer.`id` LEFT JOIN quotation ON cs_schedule.`id_customer` = quotation.`id_customer`WHERE 1=1 ';
		if ($lstUser) {
			$sql.=" and cs_schedule.`id_dentist`=$lstUser";
		}
		if ($branch) {
			$sql.=" and cs_schedule.`id_branch`=$branch";
		}
		if ($type_time) {
			if ($type_time == 1) {
				$time = date('Y-m-d');
				$sql.= " and DATE(cs_schedule.`create_date`)=$time";
			}
			else if ($type_time == 2)
			{
				$time_fisrt = date('Y-m-d',strtotime('monday this week'));
				$time_last = date('Y-m-d',strtotime('sunday this week'));
				$sql.= " and (DATE(cs_schedule.`create_date`)>=$time_fisrt and DATE(cs_schedule.`create_date`)<=$time_last)";
			}
			else if ($type_time==3)
			{
				$time = date('m',strtotime(date('Y-m-d')));
				$sql.= " and MONTH(cs_schedule.`create_date`) = $time";
			}
			else if ($type_time==4)
			{
				$time = date('m',strtotime(date('Y-m-d'). ' - 1 month')); //tháng trước
	            $sql.=" and MONTH(cs_schedule.`create_date`) = $time";
			}
		}
		$data = $con->createCommand($sql)->queryAll();
		if ($data) {
			return $data;
		}
	}
	// tong thoi gian lich hen
	public function getSumSchedule($id_branch,$id_dentist,$from_date,$to_date)
	{


		if(!$from_date || !$to_date){
			return -1;		// khong du du lieu
		}


		$start_date = new DateTime($from_date);
		$start_date = date_format($start_date, 'Y-m-d');

		$end_date 	= new DateTime($to_date);
		$end_date 	= date_format($end_date, 'Y-m-d');

		if(!$start_date || !$end_date)
			return -2;		// dinh dang thoi gian khong dung

		$con = "'$start_date' <= DATE(start_time) AND DATE(end_time) <= '$end_date' AND status > 0";

		if($id_dentist)
			$con .= " AND id_dentist = $id_dentist";
		if($id_branch)
			$con .= " AND id_branch = $id_branch";
		$sch = CsSchedule::model()->findAll(array(
				'select'  => '*',
				'condition' => $con,
			));

		$maxTime = 0;
		foreach ($sch as $key => $value) {
			$st = date_create($value['start_time']);
			$en = date_create($value['end_time']);

			$timeSch = date_diff($st,$en);

			$minutes = $timeSch->days * 24 * 60;
			$minutes += $timeSch->h * 60;
			$minutes += $timeSch->i;
			$maxTime += $minutes;

		}
		return $maxTime;
	}
	// tong thoi gian lam viec - tra ve so phut
	public function getSumWork($id_branch,$id_dentist,$from_date,$to_date)
	{
		if(!$id_branch || !$from_date || !$to_date)
			return -1;		// khong du du lieu
		$start = DateTime::createFromFormat('Y-m-d', $from_date);
		$end   = DateTime::createFromFormat('Y-m-d', $to_date);

		if(!$start || !$end)
			return -2;		// dinh dang thoi gian khong dung

		$start_date = $start->format('Y-m-d');
		$end_date   = $end->format('Y-m-d');

		$start_week = $start->format('w'); 	// 3
		$end_week   = $end->format('w');	// 4
		$num_date = date_diff($end, $start)->d;

		$con = "id_branch = $id_branch AND status = 1";
		if($id_dentist)
		{
			$con .= " AND id_dentist = $id_dentist";
		}

		$work = CsScheduleChair::model()->findAll(array(
			'select'    => '*',
			'condition' => $con,
			));

		$maxTime = 0;

		$t = 0;
		while ($t < $num_date) {
			$dow = date_format($start, 'w');

			$tw = array_filter($work, function ($k) use ($dow){
				return $k['dow'] == $dow;
			});

			if($tw) {
				foreach ($tw as $key => $value) {
					$st = date_create($value['start']);
					$en = date_create($value['end']);

					$timeSch = date_diff($st,$en);

					$minutes = $timeSch->days * 24 * 60;	// ngay
					$minutes += $timeSch->h * 60;
					$minutes += $timeSch->i;
					$maxTime += $minutes;
				}
			}
			$start = date_add($start, date_interval_create_from_date_string("1 days"));
			$t++;
		}

		$unTime = 0;

		$con1 = "'$start_date' <= DATE(start_time) AND DATE(end_time) <= '$end_date' AND status = 0 AND active = 1 AND id_branch = $id_branch";
		if($id_dentist)
		{
			$con1 .= " AND id_dentist = $id_dentist";
		}

		$sch = CsSchedule::model()->findAll(array(
				'select' => '*',
				'condition' => $con1,
			));

		foreach ($sch as $key => $value) {
			$st = date_create($value['start_time']);
			$en = date_create($value['end_time']);

			$timeSch = date_diff($st,$en);

			$minutes = $timeSch->days * 24 * 60;
			$minutes += $timeSch->h * 60;
			$minutes += $timeSch->i;
			$unTime  += $minutes;
		}

		return $maxTime - $unTime;
	}

	public function checkCustomerSchedule($id_customer)
	{
		if(!$id_customer)
			return null;
		$cs = new CsSchedule;

		$v = new CDbCriteria();
		$now = date('Y-m-d');

		$v->addCondition("id_customer = $id_customer");
		$v->addCondition("active = 1");
		$v->addCondition("status IN (3,6)");

	    return $cs->findAll($v);
	}

	public function searchCustomer($curpage, $limit, $search) {
		$start_point = $limit * ($curpage - 1);
		$model = new Customer;
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.status = 1');

		if (date_create_from_format('d/m/Y', $search)) {
			$criteria->addCondition('birthdate = "' . date_format(date_create_from_format('d/m/Y', $search), 'Y-m-d') . '"');
		} else {
			$criteria->addSearchCondition('fullname', $search, true);
			$criteria->addSearchCondition('code_number', $search, true, 'OR');
			$criteria->addSearchCondition('phone', $search, true, 'OR');
		}

		$criteria->order = 'id';
		$criteria->limit = $limit;
		$criteria->offset = $start_point;

		return $model->findAll($criteria);
	}

	public function getListCustomerSpend($lstUser,$branch,$type_time,$fromdate,$todate)
	{
		$con = Yii::app()->db;
		$sql="select customer.`id`,customer.`fullname`,v_quotations.`sum_amount`,cs_schedule.`id_dentist`,COUNT( DISTINCT v_quotation_detail.`id_service`) AS totalService, COUNT( DISTINCT cs_schedule.`code`) AS totalSchedule FROM ((customer JOIN v_quotations ON customer.`id`=v_quotations.`id_customer`)LEFT JOIN v_quotation_detail ON v_quotations.`id`=v_quotation_detail.`id_quotation`) LEFT JOIN cs_schedule ON customer.`id`=cs_schedule.`id_customer` WHERE 1=1";
		if ($lstUser) {
			$sql.=" and cs_schedule.`id_dentist`=$lstUser";
		}
		if ($branch) {
			$sql.=" and v_quotations.`id_branch`=$branch";
		}
		if ($type_time) {
			if ($type_time == 1) {
				$time = date('Y-m-d');
				$sql.= " and DATE(v_quotations.`create_date`)='$time'";
			}
			else if ($type_time == 2)
			{
				$time_fisrt = date('Y-m-d',strtotime('monday this week'));
				$time_last = date('Y-m-d',strtotime('sunday this week'));
				$sql.= " and (DATE(v_quotations.`create_date`)>='$time_fisrt' and DATE(v_quotations.`create_date`)<='$time_last')";
			}
			else if ($type_time==3)
			{
				$time = date('m',strtotime(date('Y-m-d')));
				$sql.= " and MONTH(v_quotations.`create_date`) = '$time'";
			}
			else if ($type_time==4)
			{
				$time = date('m',strtotime(date('Y-m-d'). ' - 1 month')); //tháng trước
	            $sql.=" and MONTH(v_quotations.`create_date`) = '$time'";
			}
			else if($type_time==5)
			{
				$sql.= " and (DATE(v_quotations.`create_date`)>='$fromdate' and DATE(v_quotations.`create_date`)<='$todate')";
			}
		}
		$sql.=" GROUP BY customer.`id`";
		$data = $con->createCommand($sql)->queryAll();
		if ($data) {
			return $data;
		}
	}

	public function getDentistTimeOff($sdate, $edate, $id_branch, $id_dentist, $id_chair, $type)
	{
		// type 1: nha sy, 2 ghe kham
		// get record for dentist time off
		$dentist = "";
		if ($id_dentist) {
			$dentist = " AND t.id_dentist = $id_dentist";
		}
		$dentistTimeOff = Yii::app()->db->createCommand("
			SELECT 	t.id_dentist, u.name, t.start, t.end
			FROM 	cs_schedule_time_off AS t
			JOIN 	gp_users AS u ON t.id_dentist = u.id
			WHERE 	'$sdate' <= DATE(t.end) AND DATE(t.start) <= '$edate' AND t.id_branch = $id_branch $dentist
		")->queryAll();

		if (!$dentistTimeOff){ return array(); }

		$scheduleTimeOff = array();

		if ($type == 1) {
			foreach ($dentistTimeOff as $key => $v) {
				$schedule = array(
					'id'    => 'timeOff'.$v['id_dentist'],
					'title' => $v['name'],
					'start' => $v['start'],
					'end'   => $v['end'],

					'resourceId'  => $v['id_dentist'],
					'rendering'   => 'background',
					'backgroundColor' => 'rgba(128,128,128,0.3)',
					'borderColor'     => 'rgba(128,128,128,0.3)',
				);
				$scheduleTimeOff[] = $schedule;
			}
			return $scheduleTimeOff;
		}

		$sDateFormat 	= new DateTime($sdate);
		$eDateFormat 	= new DateTime($edate);

		$dowString = "";
		while ($sDateFormat <= $eDateFormat) {
			if (strpos($dowString, date_format($sDateFormat, 'w')) !== false) {
 			   break;
			}
			$dowString .= date_format($sDateFormat, 'w') . ',';
			$sDateFormat = date_add($sDateFormat, date_interval_create_from_date_string('1 days'));
		}
		$dowString = rtrim($dowString,",");

		$dentistString = "";
		foreach ($dentistTimeOff as $key => $v) {
			if (strpos($dentistString, $v['id_dentist']) !== false || $v['id_dentist'] == '') {
 			   continue;
			}
			$dentistString .= $v['id_dentist'] . ",";
		}
		$dentistString = rtrim($dentistString,",");

		// get record for time working
		$chair = "";
		if ($id_chair) {
			$chair = " AND c.id_chair = $id_chair";
		}

		$timeWork = Yii::app()->db->createCommand("
			SELECT 	c.id_dentist, c.dow, c.start, c.end, c.id_chair
			FROM 	cs_schedule_chair AS c
			WHERE 	dow IN ($dowString) AND id_dentist IN ($dentistString) AND id_chair IS NOT NULL AND status = 1 AND c.id_branch = $id_branch $chair
			ORDER BY c.id_dentist , c.dow , c.start
		")->queryAll();

		if (!$timeWork){ return array(); }

		// handling record
		$eDateFormat 	= new DateTime($edate);
		$eDateFormat 	= date_add($eDateFormat, date_interval_create_from_date_string(' 23 hours + 59 minutes'));

		foreach ($dentistTimeOff as $key => $value) {
			$id_dentist = $value['id_dentist'];
			$start 	= (date_create($sdate) < date_create($value['start'])) ? date_create($value['start']) 	: date_create($sdate);
			$end 	= ($eDateFormat > date_create($value['end'])) 	? date_create($value['end']) 	: $eDateFormat;

			while($start <= $end) {
				$dow 	= date_format($start,'w');
				$date 	= date_format($start,'Y-m-d');

				$timeWorkWithDow = array_filter($timeWork, function ($val) use ($dow, $id_dentist){
					return ($val['id_dentist'] == $id_dentist && $val['dow'] == $dow);
				});

				$schedule = array();
				foreach ($timeWorkWithDow as $k => $v) {
					$sOff = (date_format($start,'H:i:s') > $v['start']) ? date_format($start,'H:i:s') : $v['start'];
					$eOff = $v['end'];
					if (date_format($start,'Ymd') == date_format($end,'Ymd')) {
						$eOff = (date_format($end,'H:i:s') < $v['end'])	? date_format($end,'H:i:s')   : $v['end'];
					}

					if ($sOff > $eOff) {
						continue;
					}

					$schedule = array(
						'id'    => 'timeOff'.$v['id_dentist'],
						'title' => $value['name'],
						'start' => $date.' '.$sOff,
						'end'   => $date.' '.$eOff,

						'resourceId'  => $v['id_chair'],
						'rendering'   => 'background',
						'backgroundColor' => 'rgba(128,128,128,0.3)',
						'borderColor'     => 'rgba(128,128,128,0.3)',
					);
					$scheduleTimeOff[] = $schedule;
				}
				$start = date_add($start, date_interval_create_from_date_string('1 days'));
			}
		}

		return $scheduleTimeOff;
	}

	public function getFutureScheduleOfCustomer($id_customer, $date = '') {
		if ($date == '') {$date = date('Y-m-d');}

		if (!$id_customer) {return array('status' => 0, 'error' => 'Không có mã khách hàng!');}

		$schedule = CsSchedule::model()->findAll(array(
			'select'    => '*',
			'condition' => "id_customer = $id_customer AND date(start_time) > '$date' AND active = 1 AND status > 0"
		));

		return array('status' => 1, 'data' => $schedule);
	}
}