<?php

class CalendarController extends Controller
{
// khoi tao bien
	public $layout = '//layouts/layouts_menu';
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
	// xac nhan
	public $st7 = array(
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
	// dang cho
	public $st2 = array(
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
	// dieu tri
	public $st3 = array(
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
	public $st0 = array(
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
	// bo ve
	public $st5 = array(
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

	// lich moi cho phong kham
	public $stEN = array(
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
	public $stE0 = array(
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
	// lich moi
	public $stE1 = array(
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
	// xac nhan
	public $stE7 = array(
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
	// vao kham cho phong kham
	public $stE2 = array(
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
	// bo ve
	public $stE5 = array(
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


	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
		'accessControl', // perform access control for CRUD operations
	);
	}
	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules() {
		return parent::accessRules();
	}

	public function actionIndex($id_dentist='') {
		$group_id =  Yii::app()->user->getState('group_id');
		$roleView = 1;		// xem tat ca lich hen
		$upSch = 0;		// cap nhat lich hen
		$delSch = 0;	// xoa lich
		$vewQuote = 0; 	// xem bao gia
		$upQuote = 0; 	// cap nhat bao gia
		$viewInvoice = 0; 	// xem hoa don

		// group bac sy
		if($group_id == 3){
			$roleView = 0; $upSch = 1; $delSch = 0;
			$vewQuote = 1; $upQuote	= 1; $viewInvoice = 1;
		}
		// group ke toan
		if($group_id == 11){
			$roleView	= 1; $upSch		= 0; $delSch      = 0;
			$vewQuote	= 1; $upQuote	= 1; $viewInvoice = 1;
		}
		// group tro thu
		elseif ($group_id == 12) {
			$roleView	= 1; $upSch		= 0; $delSch      = 0;
			$vewQuote	= 1; $upQuote	= 0; $viewInvoice = 0;
		}
		// group tiep tan
		elseif ($group_id == 4) {
			$roleView	= 1; $upSch		= 1; $delSch      = 0;
			$vewQuote	= 1; $upQuote	= 0; $viewInvoice = 1;
		}
		//group cskh
		elseif ($group_id == 5) {
			$roleView	= 1; $upSch		= 1; $delSch      = 0;
			$vewQuote	= 1; $upQuote	= 0; $viewInvoice = 1;
		}
		// group dieu hanh + admin
		elseif($group_id == 1 || $group_id == 2 || $group_id == 16){
			$roleView	= 1; $upSch		= 1; $delSch      = 1;
			$vewQuote	= 1; $upQuote	= 0; $viewInvoice = 1;
		}

		$BranchList = CsSchedule::model()->getBranchList();
		$branch = CHtml::listData($BranchList, 'id', 'name');

		$sourceList = Source::model()->findAll(array(
			'select' => 'id, name'
		));
		$source = CHtml::listData($sourceList, 'id', 'name');

		$sch = new CsSchedule();
		$cus = new Customer();
		$ct = CsCountry::model()->findAllByAttributes(array('flag'=>1));
		$country = CHtml::listData($ct,'code','country');
		$codeNumberExp = Yii::app()->user->getState('user_branch') . Customer::model()->getCodeNumberCustomer();

		$this->render('index',array(
			"status_sch"  =>	$this->status_arr,
			'role'        =>	$roleView,
			'id_user'     =>	Yii::app()->user->getState('user_id'),
			'name_user'   =>	Yii::app()->user->getState('name'),
			'branch'      =>	$branch,
			'sch'         => 	$sch,
			'cus'         =>	$cus,
			'group_id'    => 	$group_id,
			'upSch'       =>  	$upSch,
			'delSch'      =>  	$delSch,
			'vewQuote'    => 	$vewQuote,
			'upQuote'     => 	$upQuote,
			'viewInvoice' => 	$viewInvoice,
			'country'     => 	$country,
			'codeNumberExp' => $codeNumberExp,
			'source' => $source,
		));
	}

	public function actionGetDentistList() {
		$page 		= isset($_POST['page'])			?	$_POST['page']		:1;
		$search 	= isset($_POST['q'])			?	$_POST['q']			:'';
		$id_branch 	= isset($_POST['id_branch'])	?	$_POST['id_branch']	:'';
		$id_resource = isset($_POST['id_resource'])	?	$_POST['id_resource']	:'';

		$item = 50;
		$search_params = '';
		if($id_resource) {
			$search_params= "AND id = $id_resource AND group_id = 3";
		}
		else {
			if($id_branch)
				$search_params .= ' AND id_branch = ' .$id_branch;
			$search_params .= ' AND (`name` LIKE "%'.$search.'%" ) AND group_id = 3';
		}

		$dentistList = GpUsers::model()->searchStaffs('','',' '.$search_params,$item,$page);
		if(!$dentistList['data'])
		{
			echo -1;
			exit();
		}


		foreach ($dentistList['data'] as $key => $value) {
			$dentist[] = array(
				'id'    => $value['id'],
				'text'  => $value['name'],
				'title' => $value['name'],
			);
		}


		echo json_encode($dentist);
	}

	public function actionGetDentistAndChair()
	{
		$id_chair  = 	isset($_POST['id_chair'])	?	$_POST['id_chair']	:'';
		$id_branch = 	isset($_POST['id_branch'])	?	$_POST['id_branch']	:'';
		$time      = 	isset($_POST['time'])		?	$_POST['time']		:'';
		$dow       = 	isset($_POST['dow'])		?	$_POST['dow']		:'';
		$id_dentist= 	isset($_POST['id_dentist'])	?	$_POST['id_dentist']:'';

		if($time == '') { echo "0"; exit; }

		$time = date_add(date_create($time), date_interval_create_from_date_string("1 minutes"));
		$time = date_format($time, 'H:i:s');

		$chair = ""; $dentist = "";
		if ($id_chair){ $chair = " AND id_chair = $id_chair"; }
		if ($id_dentist) { $dentist = " AND id_dentist = $id_dentist"; }

		$infoDentistChair = VWorkHours::model()->find(array(
			'select'	=>	'*',
			'condition'	=>	"id_branch = $id_branch AND `start` <= '$time' AND '$time' <= `end` AND dow = $dow $dentist $chair",
		));

		if(!$infoDentistChair) { echo 0; exit; }

		echo json_encode(array('dentist'=>$infoDentistChair->attributes,'service'=>array(),'len'=>0));
		exit;
	}

	public function actionGetCustomersList() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$search = isset($_POST['q']) ? $_POST['q'] : '';

		$item = 50;

		$customerList = CsSchedule::model()->searchCustomer($page, $item, $search);
		$customer = array();

		if($customerList) {
			foreach ($customerList as $key => $value) {
				$customer[] = array(
					'id' => $value['id'],
					'text' => $value['fullname'],
					'code_number' => $value['code_number'],
					'phone' => $value['phone'],
					'img' => $value['image'],
					'email' => $value['email'],
					'gender' => $value['gender'],
					'birthdate' => $value['birthdate'],
					'identity_card_number' => $value['identity_card_number'],
					'id_country' => $value['id_country'],
					'id_source' => $value['id_source'],
					'address' => $value['address']
				);
			}
		}
		echo json_encode($customer);
	}

	public function actionGetCustomerSegment() {
		$id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : false;
		$id_segment = '';

		if ($id_customer) {
			$customerSegment = CustomerSegment::model()->find(array(
				'select' => 'id_segment',
				'condition' => "id_customer = '$id_customer'"
			));

			if ($customerSegment) {
				$id_segment = $customerSegment->id_segment;
			}
		}

		echo $id_segment;
	}

	public function actionGetServiceList()
	{
		$page 		= isset($_POST['page'])			?	$_POST['page']		:1;
		$search 	= isset($_POST['q'])			?	$_POST['q']			:'';
		$id_dentist = isset($_POST['id_dentist'])	?	$_POST['id_dentist']:'';
		$up         = isset($_POST['up'])			?	$_POST['up']		:0;

		$servicesList = CsService::model()->service_list_pagination(1,10,12,$search);

		if($up == 0) {
			$services[] = array(
				'id' 	=> '0',
				'text' 	=> 'Không làm việc',
				'len'	=> 30,
			);
		}

		if($servicesList) {
			foreach ($servicesList as $key => $value) {
				$services[] = array(
					'id' 	=> $value['id'],
					'text' 	=> $value['name'],
					'len'	=> $value['length'],
				);
			}
		}

		echo json_encode($services);
	}

	public function actionGetUserList()
	{
		$page      = isset($_POST['page'])		?	$_POST['page']		:1;
		$search    = isset($_POST['q'])			?	$_POST['q']			:'';
		$id_branch = isset($_POST['id_branch'])	?	$_POST['id_branch']	:'';

		$cs = new GpUsers;

		$v = new CDbCriteria();

		$v->addCondition('t.id_branch = :id_branch');
		$v->params = array(':id_branch' => $id_branch);
		$v->addSearchCondition('name', $search, true);

		$userList =  $cs->findAll($v);

		$users    = array();

		if($userList) {
			foreach ($userList as $key => $value) {
				$users[] = array(
					'id' 	=> $value['id'],
					'text' 	=> $value['name'],
					'len'	=> $value['name'],
				);
			}
		}

		echo json_encode($users);
	}

	public function actionAddBreak()
	{
		$type = isset($_POST['type'])?$_POST['type']:1;

		if(isset($_POST['CsSchedule'])){

			$sch = CsSchedule::model()->addNewSchedule(array(
				'id_dentist' =>	$_POST['CsSchedule']['id_dentist'],
				'id_author'  =>	$_POST['CsSchedule']['id_author'],
				'id_branch'  =>	$_POST['CsSchedule']['id_branch'],
				'id_chair'   =>	$_POST['CsSchedule']['id_chair'],
				'id_service' =>	0,
				'lenght'     =>	$_POST['CsSchedule']['lenght'],
				'start_time' =>	$_POST['CsSchedule']['start_time'],
				'end_time'   =>	$_POST['CsSchedule']['end_time'],
				'status'     =>	0,
				'active'     =>	1,
				'note'       =>	$_POST['CsSchedule']['note'],
			));

			$event  = VSchedule::model()->findByAttributes(array('id'=>$sch['id']));
			$events = $this->eventArr($event, $_POST['CsSchedule']['type']);
			echo json_encode($events);
		}
	}

	public function actionGetChairList()
	{
		$page = isset($_POST['page'])?$_POST['page']:1;
		$search = isset($_POST['q'])?$_POST['q']:'';
		$id_branch = isset($_POST['id_branch'])?$_POST['id_branch']:'';
		$id_resource = isset($_POST['id_resource'])	?	$_POST['id_resource']	:'';

		$item = 30;
		if($id_resource)
			$chairList = Chair::model()->findAllByAttributes(array('id'=>$id_resource));
		else {
			$cs = new Chair;
			$v = new CDbCriteria();
			$v->addCondition('id_branch = ' . $id_branch);
			$v->addCondition('status = 1');
			$v->order = "type, name";
			$chairList = $cs->findAll($v);
		}

		if(!$chairList)
		{
			echo -1;exit();
		}
		foreach ($chairList as $key => $value) {
			$chair[] = array(
				'id'    => $value['id'],
				'text'  => $value['name'],
				'title' => $value['name'],
			);
		}
		echo json_encode($chair);
	}

	public function actionGetBranchList()
	{
		$BranchList = CsSchedule::model()->getBranchList();

		foreach ($BranchList as $key => $value) {
			$branch[] = array(
				'id' => $value['id'],
				'text' => $value['name'],
			);
		}
		echo json_encode($branch);
	}

	public function actionGetResourcesDentistList()
	{
		$id_resource 	= isset($_POST['id_resource'])	?	$_POST['id_resource']	:	false;
		$id_branch 		= isset($_POST['id_branch'])	?	$_POST['id_branch']		:	1;

		$branch 	=	Branch::model()->findByPk($id_branch);

		$t = 0;

		$dentistL = VServicesHours::model()->getResourcesDentist($id_resource,$id_branch);

		if(!$dentistL) {
			echo "-1";
			exit;
		}

		foreach ($dentistL as $key => $value) {
			$id = $value['id_dentist'];
			$nextId = next($dentistL);

			if($id != $nextId['id_dentist']) {
				$dentist[] = array(
					'id' 			=> 	$value['id_dentist'],
					'title' 		=> 	$value['dentist_name'],
				);
				$t=0;
			}
		}

		echo json_encode(array('data'=>$dentist));
	}

	public function actionGetResourcesChairList()
	{
		$id_resource 	= isset($_POST['id_resource'])	?	$_POST['id_resource']	:	false;
		$id_branch 		= isset($_POST['id_branch'])	?	$_POST['id_branch']		:	1;

		$branch 	=	Branch::model()->findByPk($id_branch);


		if($id_resource){
			$chairList = Chair::model()->findByPk($id_resource);
			$chair[] = array(
				'id' => $chairList['id'],
				'title' => $chairList['name'],
			);
		}
		else {
			$chairList = Chair::model()->findAllByAttributes(array('id_branch'=>$id_branch));

			foreach ($chairList as $key => $value) {
				$chair[] = array(
					'id' => $value['id'],
					'title' => $value['name'],
				);
			}
		}
		echo json_encode(array('data'=>$chair));
	}

	public function actionCheckTime()
	{
		$id_dentist  = isset($_POST['id_dentist']) 	? $_POST['id_dentist'] 	: false;
		$id_chair    = isset($_POST['id_chair']) 	? $_POST['id_chair'] 	: false;
		$start       = isset($_POST['start']) ? $_POST['start'] : false;
		$end         = isset($_POST['end']) ? $_POST['end'] : false;
		$id_schedule = isset($_POST['id_schedule']) 	? $_POST['id_schedule'] : 0;
		$status      = isset($_POST['status']) 	? $_POST['status'] : 0;
		$id_customer = isset($_POST['id_customer']) 	? $_POST['id_customer'] : 0;

		$stat =	DateTime::createFromFormat('Y-m-d H:i:s', $start)->format('Y-m-d H:i:s');
		$end  =	DateTime::createFromFormat('Y-m-d H:i:s', $end)->format('Y-m-d H:i:s');

		if(!$start || !$end){
			echo json_encode(array('status'=>-1,'ms'=>'Thời gian không đúng định dạng!'));		// thoi gian khong dung
			exit;
		}

		$checkTime = CsSchedule::model()->checkWorkingTime($id_dentist,$start,$end,$id_chair);

		// if($checkTime == 0) {
		// 	echo json_encode(array('status'=>-2,'ms'=>'Bác sỹ không làm việc!'));		// bac sy khong lam viec
		// 	exit;
		// }

		if($checkTime == -1) {
			echo json_encode(array('status' => -4, 'ms' => 'Bác sỹ nghỉ phép!'));		// bac sy khong lam viec
			exit;
		}

		if(!$id_dentist) {
			$id_dentist = $checkTime['id_dentist'];
		}

		$check = CsSchedule::model()->checkScheduleEvent($start,$end,$id_dentist,$id_schedule);
		if($check != 1) {
			if($check['status'] != 0) {
				echo json_encode(array('status'=>-3, 'ms'=>'Có lịch hẹn trùng!'));		// lich hen trung
			} else {
				echo json_encode(array('status'=>-4, 'ms'=>'Bác sỹ trong thời gian nghỉ phép!', 'test' => json_encode($check)));		// lich hen trung
			}
			exit;
		}

		$checkSt = 1;
		if(in_array($status,array(2,6,3))){
			$checkSt = CsSchedule::model()->checkScheduleStatus($id_customer,$id_schedule);
		}

		if(!$checkSt){
			echo json_encode(array('status'=>-5,'ms'=>"Có lịch hẹn đang chờ hoặc chưa hoàn tất"));
			exit;
		}

		$codeNumberRemain = '';
		foreach (Customer::model()->getCodeNumberCustomerToday() as $value) {
			$codeNumberRemain .= $value.', ';
		}
		$codeNumberExp = Yii::app()->user->getState('user_branch') . Customer::model()->getCodeNumberCustomer();

		echo json_encode(array('status'=>1,'data'=>$checkTime, 'codeNumberRemain'=>$codeNumberRemain, 'codeNumberExp' => $codeNumberExp));
	}

	public function actionCheckScheduleEvent()
	{
		$id_dentist = isset($_POST['id_dentist']) ? $_POST['id_dentist'] : false;
		$start = isset($_POST['start']) ? $_POST['start'] : false;
		$end = isset($_POST['end']) ? $_POST['end'] : false;
		$id_schedule = isset($_POST['id_schedule']) ? $_POST['id_schedule'] : 0;

		if($id_dentist && $start && $end){
			echo $check = CsSchedule::model()->checkScheduleEvent($start,$end,$id_dentist,$id_schedule);
		}
		else {
			echo -1;		// không có đủ dữ liệu
		}
	}

	public function eventArr($events,$type)
	{
		$status	= $events['status'];
		$online = ($events['author']) ? 0 : 1;
		$color	= CsSchedule::model()->getColorSch($status,$online);

		if($status == 0) {
			$start_text = "Không làm việc";
		}
		else {
			$start_text = $this->status_arr[$events['status']];
		}

		if($type == 1) {
			$resourceId = $events['id_dentist'];
		}
		elseif($type == 2)
			$resourceId = $events['id_chair'];

		return array(
		 	// schedule
			'id'    => $events['id'],
			'title' => $events['fullname'],
			'start' => $events['start_time'],
			'end'   => $events['end_time'],
			'code_schedule' => $events['code_schedule'],
			'id_dentist' => $events['id_dentist'],
			'dentist'    => $events['name_dentist'],
			'id_service' => $events['id_service'],
			'services'   => $events['name_service'],
			'time'      => $events['lenght'],
			'id_author' => $events['id_author'],
			'setBy'     => ($events['author']) ? $events['author'] : "Khách hàng",
			'status'    => $events['status'],
			'status_text'     => $start_text,
			'backgroundColor' => $color,
			'borderColor'     => $color,
			'chair_type'      => $events['chair_type'],
			'note'			=> $events['note'],
			'create_date' => $events['create_date'],
			'status_sch_customer' => $events['status_sch_customer'],

			// customer
			'id_patient' => $events['id_customer'],
			'code_pt'    => $events['code_number'],
			'patient'    => $events['fullname'],
			'phone'      => $events['phone'],
			'img'        => $events['image_customer'],
			'cus_note'   => $events['cus_note'],

			// quotation
			'id_quotation' => $events['id_quotation'],
			'id_invoice'   => $events['id_invoice'],

			// resource
			'resourceId'   => $resourceId,
		);
	}

	// show all event
	public function actionShowEvents()
	{
		$dentist    = isset($_POST['id_dentist']) 	? $_POST['id_dentist'] : false;
		$id_author  = isset($_POST['id_author'])	? $_POST['id_author'] : false;
		$branch     = isset($_POST['id_branch']) 	? $_POST['id_branch'] 	: 1;
		$chair      = isset($_POST['id_chair']) 	? $_POST['id_chair'] 	: false;
		$type       = isset($_POST['type_resource']) 	? $_POST['type_resource'] 	: 2;
		$page       = isset($_POST['page']) 	? $_POST['page'] 	: 1;
		$start_time = isset($_POST['start_time']) 	? $_POST['start_time'] 	: '';
		$end_time   = isset($_POST['end_time']) 	? $_POST['end_time'] 	: '';

		// $id_dentist='',$id_author='',$id_branch='',$id_chair='', $order = '', $id_customer = '', $page = 1
		if($id_author){
			$schedule = CsSchedule::model()->getListSchedule('', $id_author, $branch, '', '', '', $start_time, $end_time, $page);
		}else{
			$schedule = CsSchedule::model()->getListSchedule($dentist, '', $branch, $chair, '', '', $start_time, $end_time, $page);
		}

		if(!$schedule) { echo 0; exit; }

		foreach ($schedule as $key => $value) {
			$events[] = $this->eventArr($value,$type);
		}

		$jstr = json_encode($events);
		echo $jstr;
	}

	public function actionAddEvent()
	{
		// type = 1 : bac sy, type = 2: ghe
		$type	= isset($_POST['type'])	? $_POST['type']	: 2;
		$id_customer	= 0;

		if (!isset($_POST['CsSchedule']['id_branch']) || $_POST['CsSchedule']['id_branch'] == 0 || !isset($_POST['CsSchedule']['id_chair']) && $_POST['CsSchedule']['id_chair'] == 0) {
			echo 0;
			exit;
		}

		if(isset($_POST['Customer'])){
			if(isset($_POST['Customer']['id']) && !$_POST['Customer']['id']) {
				$customer = Customer::model()->addCustomer(array(
					'fullname' =>	$_POST['Customer']['fullname'],
					'code_number' =>	$_POST['Customer']['code_number'],
					'phone' =>	$_POST['Customer']['phone'],
					'email' =>	$_POST['Customer']['email'],
					'id_country' =>	$_POST['Customer']['id_country'],
					'gender' =>	$_POST['Customer']['gender'],
					'birthdate' =>	$_POST['Customer']['birthdate'],
					'status' =>	($_POST['Customer']['code_number']) ? 1 : 0,
					'id_source' =>	$_POST['Customer']['id_source'],
				));

				if($customer <= 0){
					echo $customer;
					exit;
				}

				if(isset($customer['data']) && $customer['status'] == 1) {
					$data = $customer['data'];
					$id_customer 		=	$data->id;
				}
				else {
					echo json_encode(array('status'=>0,'error'=>$customer));
					exit;
				}
			}
			else if (isset($_POST['Customer']['id'])){
				$id_customer	=	$_POST['Customer']['id'];
			}
		}
		if (isset($_POST['CsSchedule']['id_customer']) && $id_customer == 0) {
			$id_customer = $_POST['CsSchedule']['id_customer'];
		}

		if(isset($_POST['CsSchedule']) && $id_customer) {
			$id_note = '';
			if($_POST['CsSchedule']['note']) {
				$note = CustomerNote::model()->addnote(array(
					'note'        => $_POST['CsSchedule']['note'],
					'id_user'     => $_POST['CsSchedule']['id_author'],
					'id_customer' => $id_customer,
						'flag'        => 1,			// 1: lich hen
						'important'   => 0,
						'status'      => 1,
					));
				if(isset($note['id']))
					$id_note = $note['id'];
			}

			$add 		= CsSchedule::model()->addNewSchedule(array(
				'id_customer'     =>	$id_customer,
				'id_dentist'      =>	$_POST['CsSchedule']['id_dentist'],
				'id_author'       =>	$_POST['CsSchedule']['id_author'],
				'id_branch'       =>	$_POST['CsSchedule']['id_branch'],
				'id_chair'        =>	$_POST['CsSchedule']['id_chair'],
				'id_service'      =>	$_POST['CsSchedule']['id_service'],
				'lenght'          =>	$_POST['CsSchedule']['lenght'],
				'start_time'      =>	$_POST['CsSchedule']['start_time'],
				'end_time'        =>	$_POST['CsSchedule']['end_time'],
				'status'          =>	$_POST['CsSchedule']['status'],
				'active'          =>	1,
				'status_customer' =>	$_POST['CsSchedule']['status_customer'],
				'id_note'         => 	$id_note,
			));

			if($add) {
				$cus_st	=	Customer::model()->updateStatusScheduleOfCustomer($id_customer,$_POST['CsSchedule']['status']);
			}

			$event = VSchedule::model()->findByAttributes(array('id'=>$add['id']));

			$events = $this->eventArr($event,$_POST['CsSchedule']['type']);
		}
		if(isset($_POST['CsMedicalHistoryAlert']) && $id_customer) {
			$med     =	$_POST['CsMedicalHistoryAlert']['id_medicine_alert'];
			$meNote  = 	$_POST['CsMedicalHistoryAlert']['note'];
			$md_his  =	array();
			$md_note = array();

			foreach ($med as $key => $value) {
				if($value != 0){
					$md_his[]  = $key;
					$md_note[] = $meNote[$key];
				}
			}

			$upMed 	=	Customer::model()->updateMedicalHistoryAlert($id_customer,$md_his,$md_note);
		}
		echo json_encode(array('status'=>1,'data'=>$events));
		exit;
	}

	public function actionMedicalAlert()
	{
		$id_customer 	= isset($_POST['id_customer']) 	? $_POST['id_customer'] 	: false;

		$al 		= 	CsMedicalHistoryAlert::model()->findAllByAttributes(array('id_customer'=>$id_customer));

		$als = array();

		foreach ($al as $key => $value) {
			$als[] = $value['id_medicine_alert'];
		}

		echo json_encode($als);

		exit;
		$id_customer 	= isset($_POST['id_customer']) 	? $_POST['id_customer'] 	: false;

		if($id_customer) {
			$al 		= 	CsMedicalHistoryAlert::model()->findAllByAttributes(array('id_customer'=>$id_customer), array('order'=>'id_medicine_alert ASC'));
			$cus_al 	= 	new CsMedicalHistoryAlert();
			$als = array();
			if($al) {
				foreach ($al as $key => $value) {
					$als[] = $value['id_medicine_alert'];
				}
			}
		}

		else {
			if(isset($_POST['CsMedicalHistoryAlert'])){

				$CsMedicalHistoryAlert = $_POST['CsMedicalHistoryAlert'];
				$id_customer 		= $CsMedicalHistoryAlert['id_customer'];
				$med 			=	$CsMedicalHistoryAlert['id_medicine_alert'];
				$md_his 	=	array();

				foreach ($med as $key => $value) {
					if($value != 0)
						$md_his[] = $key;
				}

				$upMed 	=	Customer::model()->updateMedicalHistoryAlert($id_customer,$md_his,'');

				if($upMed) {
					echo "1";
					exit;
				}
			}
		}

		$this->renderPartial('medicalAlert',array(
			'cus_al'			=>	$cus_al,
			'id_customer'		=>	$id_customer,
			'als'				=>	$als,
		));
	}

	public function actionUpdateEvent()
	{
		$id_schedule = isset($_POST['id_schedule']) ? $_POST['id_schedule'] : false;

		if($id_schedule) {
			$sch = VSchedule::model()->findByAttributes(array('id'=>$id_schedule));

			$cus = array();
			$als = array();
			$codeNumberRemain = '';
			$codeNumberExp = '';

			if($sch->id_customer) {
				if(strlen($sch->code_number) != 10){
					foreach (Customer::model()->getCodeNumberCustomerToday() as $value) {
						$codeNumberRemain .= $value.', ';
					}
					$codeNumberExp = Yii::app()->user->getState('user_branch') . Customer::model()->getCodeNumberCustomer();
				}
				$cus = Customer::model()->findByPk($sch->id_customer);
				$cus = $cus->attributes;

				$al  = 	CsMedicalHistoryAlert::model()->findAllByAttributes(array('id_customer'=>$sch->id_customer), array('order'=>'id_medicine_alert ASC'));

				if($al) {
					foreach ($al as $key => $value) {
						$als[$value['id_medicine_alert']] = $value['note'];
					}
				}
			}

			echo json_encode(array(
				'sch'	=>	$sch->attributes,
				'cus' =>	$cus,
				'als' =>	$als,
				'codeNumberRemain' => $codeNumberRemain,
				'codeNumberExp' => $codeNumberExp,
			));
			exit;
		}
		else {
			$up   = 0;
			$cus  = 0;
			$type = 2;

			if(isset($_POST['CsSchedule'])){
				// status == 6 || status == 2 || status == 4 || status == 3
				if($_POST['CsSchedule']['status'] == 6 || $_POST['CsSchedule']['status'] == 2 || $_POST['CsSchedule']['status'] == 4 || $_POST['CsSchedule']['status'] == 3){
					if(!$_POST['CsSchedule']['code_number'] && isset($_POST['Customer']['code_number']) && $_POST['Customer']['code_number']){
						$cus = Customer::model()->updateToCustomer($_POST['CsSchedule']['id_customer'], $_POST['Customer']['code_number']);

						if($cus == - 3){
							echo $cus;
							exit;
						}
					}
				}
				$up = CsSchedule::model()->updateSchedule(array(
					'id'              =>	$_POST['CsSchedule']['id'],
					'id_dentist'      =>	$_POST['CsSchedule']['id_dentist'],
					'id_branch'       =>	$_POST['CsSchedule']['id_branch'],
					'id_chair'        =>	$_POST['CsSchedule']['id_chair'],
					'id_service'      =>	$_POST['CsSchedule']['id_service'],
					'lenght'          =>	$_POST['CsSchedule']['lenght'],
					'start_time'      =>	$_POST['CsSchedule']['start_time'],
					'end_time'        =>	$_POST['CsSchedule']['end_time'],
					'status'          =>	$_POST['CsSchedule']['status'],
					'status_customer' =>	$_POST['CsSchedule']['status_customer'],
					'note'            =>	$_POST['CsSchedule']['note'],
					'id_author'       => 	Yii::app()->user->getState('user_id'),
					'id_customer' 		=> $_POST['CsSchedule']['id_customer'],
				));

				$type = $_POST['CsSchedule']['type'];

				if($up) {
					$up = VSchedule::model()->findByAttributes(array('id'=>$_POST['CsSchedule']['id']));
					if($up) {
						$cus_st	=	Customer::model()->updateStatusScheduleOfCustomer($up->id_customer,$_POST['CsSchedule']['status']);
					}

					$ev = $this->eventArr($up->attributes,$type);
					echo json_encode($ev);
					exit;
				}
			}
		}
	}

	public function actionSchCus()
	{
		$id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : false;

		if(!$id_customer) {
			$cus = new Customer();
		}
		else {
			$cus = Customer::model()->findByPk($id_customer);
		}

		if(isset($_POST['Customer'])) {
			$cus->attributes 		=	$_POST['customer'];

			if($cus->validate()) {
				return $cus->save();
			}
			else {

			}
		}
	}

	public function actionUpdateTimeEvent()
	{
		$id_schedule = isset($_POST['id_schedule']) ? $_POST['id_schedule'] : false;
		$id_resource = isset($_POST['id_resource']) ? $_POST['id_resource'] : false;
		$start = isset($_POST['start']) ? $_POST['start'] : false;
		$end = isset($_POST['end']) ? $_POST['end'] : false;

		$update = CsSchedule::model()->updateSchedule(array(
			'id'         =>$id_schedule,
			'id_dentist' =>$id_resource,
			'start_time' =>$start,
			'end_time'   =>$end
		));

		echo json_encode($update);
	}

	// change time event
	public function actionEventResize()
	{
		$end 		= isset($_POST['end']) 	? $_POST['end'] : false;
		$id 		= isset($_POST['id']) 	? $_POST['id'] 	: false;	// id_schedule
		$len 		= isset($_POST['len']) 	? $_POST['len'] : false;

		$len = str_replace('-','',$len);

		if($end && $id && $len) {
			$update = CsSchedule::model()->updateSchedule(array(
				'id'			=>	$id,
				'end_time'		=>	$end,
				'lenght'		=>	$len,
			));

			echo json_encode($update);
			exit;
		}
	}

	public function actionGetServiceForCus()
	{
		$id_quotation = isset($_POST['id_quotation']) ? $_POST['id_quotation'] : false;
		$sv = array();

		if(!$id_quotation) {
			$service = CsService::model()->findAllByAttributes(array('flag'=>1));

			foreach ($service as $key => $value) {
				$sv[] = array(
					'id'	=>	$value['id'],
					'name'	=>	$value['name'],
					'len'	=>	$value['length'],
				);
			}
		}
		else {
			$criteria 			= 	new CDbCriteria;
			$criteria->select 	= 	't.id, t.name , t.length ';
			$criteria->join 	= 	'JOIN quotation_service AS quo';
			$criteria->addCondition("quo.id_quotation = $id_quotation AND quo.id_service = t.id ");
			$resultSet    		=    CsService::model()->findAll($criteria);

			foreach ($resultSet as $key => $value) {
				$sv[] = array(
					'id'	=>	$value['id'],
					'name'	=>	$value['name'],
					'len'	=>	$value['length'],
				);
			}
		}

		echo json_encode($sv);
	}

	public function actionGetTimeForDent()
	{
		$id_service = isset($_POST['id_ser'])? $_POST['id_ser']: false;
		$id_dentist = isset($_POST['id_den'])? $_POST['id_den']: false;
		// Y-m-d
		$time = isset($_POST['time'])	? $_POST['time']: false;
		$len  = isset($_POST['len'])	? $_POST['len']	: '';

		if($id_service && $time){
			$time 	= CsSchedule::model()->getBlankTime('', $id_service, $id_dentist, $time, $time, $len);
		}
		else
			$time 	= 0;		// ko đủ dữ liệu đầu vào

		echo json_encode($time);
	}

	public function actionAddNextSch()
	{
		if(isset($_POST['CsSchedule'])) {
			$add 		= CsSchedule::model()->addNewScheduleCheck(array(
				'id_customer' =>$_POST['CsSchedule']['id_customer'],
				'id_dentist'  =>$_POST['CsSchedule']['id_dentist'],
				'id_author'   =>$_POST['CsSchedule']['id_author'],
				'id_branch'   =>$_POST['CsSchedule']['id_branch'],
				'id_chair'    =>$_POST['CsSchedule']['id_chair'],
				'id_service'  =>$_POST['CsSchedule']['id_service'],
				'lenght'      =>$_POST['CsSchedule']['lenght'],
				'start_time'  =>$_POST['CsSchedule']['start_time'],
				'end_time'    =>$_POST['CsSchedule']['end_time'],
				'status'      =>$_POST['CsSchedule']['status'],
				'active'      =>1,
				'note'        =>$_POST['CsSchedule']['note']
			));

			echo json_encode($add);
		}
	}

	public function actionGetInfoCus()
	{
		$id_cus 	= isset($_POST['id_cus'])		? $_POST['id_cus']		: false;

		if(!$id_cus) {
			echo -1;
			exit;
		}

		$cus = Customer::model()->findByPk($id_cus);

		if(!$cus) {
			echo 0;
			exit;
		}

		echo json_encode($cus->attributes);
	}

	public function actionDelSch()
	{
		$id_sch = isset($_POST['id_sch'])?$_POST['id_sch']:'';

		if(!$id_sch) {
			echo "-1";		// ko co ma lich hen
			exit;
		}

		$del = CsSchedule::model()->updateSchedule(array(
			'id'     => $id_sch,
			'active' => -2,
		));

		if($del)
			echo 1;
		else
			echo 0;
	}

	// drop events dời lịch
	public function actionEventDrop()
	{
		$start      = isset($_POST['start']) 		? $_POST['start'] 		: false;
		$end        = isset($_POST['end']) 			? $_POST['end'] 		: false;
		$id         = isset($_POST['id']) 			? $_POST['id'] 			: false;
		$id_dentist = isset($_POST['id_dentist']) 	? $_POST['id_dentist'] 	: false;
		$id_chair   = isset($_POST['id_chair']) 	? $_POST['id_chair'] 	: false;
		$type       = isset($_POST['type']) 		? $_POST['type'] 	: false;

		if($end && $id && $start && $id_dentist) {
			$update = CsSchedule::model()->updateSchedule(array(
				'id'         =>	$id,
				'end_time'   =>	$end,
				'start_time' => $start,
				'id_dentist' => $id_dentist,
				'id_chair'   => $id_chair,
			));

			if($update) {
				$up = VSchedule::model()->findByAttributes(array('id'=>$id));
				echo json_encode($this->eventArr($up,$type));
				exit;
			}
			echo 0;
		}
		echo "-1";
	}

	// update new event
	public function actionReSchedule()
	{
		$id_customer = isset($_POST['id_customer']) 	? $_POST['id_customer'] 	: false;
		$id_dentist  = isset($_POST['id_dentist']) 		? $_POST['id_dentist'] 		: false;
		$id_author   = isset($_POST['id_author']) 		? $_POST['id_author'] 		: false;
		$id_branch   = isset($_POST['id_branch']) 		? $_POST['id_branch'] 		: false;
		$id_chair    = isset($_POST['id_chair']) 		? $_POST['id_chair'] 		: false;
		$id_service  = isset($_POST['id_service']) 		? $_POST['id_service'] 		: false;
		$lenght      = isset($_POST['lenght']) 			? $_POST['lenght'] 			: false;
		$start_time  = isset($_POST['start_time']) 		? $_POST['start_time'] 		: false;
		$end_time    = isset($_POST['end_time']) 		? $_POST['end_time'] 		: false;
		$type        = isset($_POST['type']) 		? $_POST['type'] 		: false;


		if($start_time && $end_time && $id_dentist && $id_service && $id_customer) {
			$newSch = CsSchedule::model()->addNewScheduleCheck(array(
				'id_customer'  => $id_customer,
				'id_dentist'   => $id_dentist,
				'id_author'    => $id_author,
				'id_branch'    => $id_branch,
				'id_chair'     => $id_chair,
				'id_service'   => $id_service,
				'lenght'       => $lenght,
				'start_time'   => $start_time,
				'end_time'     => $end_time,
				'status'       => 1,
				'active'       => 1,
			));

			if($newSch['status'] == 1) {
				$up = VSchedule::model()->findByAttributes(array('id'=>$newSch['success']['id']));
				echo json_encode($this->eventArr($up,$type));
				exit;
			}
			echo $newSch['status'];
			exit;
		}
		echo "-1";
	}

	public function actionGetNoti()
	{
		$id_author   = isset($_POST['id_author']) ? $_POST['id_author'] : Yii::app()->user->getState('user_id');
		$action      = isset($_POST['action']) ? $_POST['action'] : '';
		$id_schedule = isset($_POST['id_schedule']) ? $_POST['id_schedule'] : '';
		$id_dentist  = isset($_POST['id_dentist']) ? $_POST['id_dentist'] : '';

		if(!$id_schedule) {
			echo "-1";
			exit;
		}

		$soap = new SoapService();
		$soap->webservice_server_ws("getAddNewNotiSchedule",array('1','317db7dbff3c4e6ec4bdd092f3b220a8',$id_author,$id_dentist,$id_schedule,$action));
	}

	public function actionGetNewSch()
	{
		$data = isset($_POST['sch']) ? $_POST['sch']: false;
		$type = isset($_POST['type']) ? $_POST['type']: 2;

		if($data) {
			$data = json_decode($data,true);

			$ev = $this->eventArr($data,$type);

			echo json_encode($ev);
			exit;
		}
		echo 0;
	}

	public function actionUpdateEventAllLayout()
	{
		$id_schedule = isset($_POST['id_schedule']) ?	$_POST['id_schedule'] : false;
		$group_id =  Yii::app()->user->getState('group_id');

		// ton tai ma lich hen - get layout view update schedule all layout
		if($id_schedule)
		{
			$sch = VSchedule::model()->findByAttributes(array('id'=>$id_schedule));
			if(!$sch)
			{
				echo json_encode(array('status' => -1, 'error' => 'Lịch hẹn không tồn tại!'));
				exit;
			}
			$cus = Customer::model()->findByPk($sch->id_customer);
			if(!$cus)
			{
				echo json_encode(array('status' => -2, 'error' => 'Khách hàng không tồn tại!'));
				exit;
			}
			$al = CsMedicalHistoryAlert::model()->findAllByAttributes(array('id_customer'=>$sch->id_customer));

			$statusArr = '';
			if($sch->status == 1)		//lich moi
			$statusArr = $this->st1;
			elseif($sch->status == 2)	// đã đến
			$statusArr = $this->st2;
			elseif ($sch->status == 3) 	//vào khám
			$statusArr = $this->st3;
			elseif ($sch->status == 5) 	//bỏ về
			$statusArr = $this->st5;
			else
				$statusArr = array($sch->status => $this->status_arr[$sch->status]);

			$this->renderPartial('update_event_all', array('sch'=>$sch,'cus'=>$cus,'al'=>$al,'stArr'=>$statusArr,'group_id'=>$group_id));
		}
	}

	public function actionGetChairType()
	{
		$id_chair = isset($_POST['id_chair']) ?	$_POST['id_chair'] : false;
		$id_dentist = isset($_POST['id_dentist']) ?	$_POST['id_dentist'] : false;
		$dow = isset($_POST['dow']) ?	$_POST['dow'] : false;
		$time = isset($_POST['time']) ?	$_POST['time'] : false;

		$chair_type = 0;

		if($id_chair) {
			$chair_type = Chair::model()->findByPk($id_chair)->type;
		} else if($id_dentist) {
			$getChairType = VServicesHours::model()->find(array(
				'select' => 'chair_type',
				'condition' => "id_dentist = $id_dentist AND dow = $dow AND START <= '$time' AND '$time' <= END GROUP BY id_dentist",
			));

			if ($getChairType) {
				$chair_type = $getChairType->chair_type;
			}
		}

		echo json_encode($chair_type);
	}

	public function actionUpdateMediAlert()
	{

		if(isset($_POST['CsMedicalHistoryAlert'])){
			$med     =	$_POST['CsMedicalHistoryAlert']['id_medicine_alert'];
			$meNote  = 	$_POST['CsMedicalHistoryAlert']['note'];
			$md_his  =	array();
			$md_note = array();
			$id_customer = $_POST['CsMedicalHistoryAlert']['id_customer'];

			foreach ($med as $key => $value) {
				if($value != 0){
					$md_his[]  = $key;
					$md_note[] = $meNote[$key];
				}
			}

			$upMed 	=	Customer::model()->updateMedicalHistoryAlert($id_customer,$md_his,$md_note);

			echo json_encode($upMed);

		}
	}

	public function actionCheckCustomerSchedule()
	{
		$id_customer = isset($_POST['id_customer']) ?	$_POST['id_customer'] : false;

		$sch = CsSchedule::model()->checkCustomerSchedule($id_customer);

		if($sch){
			foreach ($sch as $key => $value) {
				if($value['status'] != 1){
					echo 2;
					exit;
				}
			}
			echo 1;
			exit;
		}
		echo 0;
	}

	public function actionCreateScheduleInCustomer()
	{
		$id_customer = isset($_POST['id_customer']) ?	$_POST['id_customer'] : false;
		$id_branch = isset($_POST['id_branch']) ?	$_POST['id_branch'] : Yii::app()->user->getState('user_branch');

		if(!$id_customer){
			exit;
		}

		// lich hen moi
		$sch = new CsSchedule();

		//lay dot dieu tri moi nhat
		$newest_mhg = CsMedicalHistoryGroup::model()->findByAttributes(array('id_customer'=>$id_customer),array('order'=>'createdata DESC'));

		// co dot dieu tri va dot dieu tri chua hoan tat
		if($newest_mhg && $newest_mhg->status_process == 0){
			$check_mhg = 1;
		}
		// chua co dot dieu tri hoac dot dieu tri chua hoan tat
		else {
			$check_mhg = 0;
		}

		$this->renderPartial('createScheduleInCustomer', array('sch'=>$sch,'id_customer'=>$id_customer,'check_mhg'=>$check_mhg));
	}

	public function actionGetDentistListInCus()
	{
		$id_branch = isset($_POST['id_branch']) ?	$_POST['id_branch'] : Yii::app()->user->getState('user_branch');
		$check_mhg = isset($_POST['check_mhg'])	?	$_POST['check_mhg']	:'';

		// co dot dieu tri va dot dieu tri chua hoan tat
		if($check_mhg){
			// danh sach bac sy theo ghe dieu tri
			$dentist = VServicesHours::model()->getDentistTreatment($id_branch);
		}
	   	// chua co dot dieu tri hoac dot dieu tri chua hoan tat
		else {
			// danh sach bac sy theo ghe kham
			$dentist = VServicesHours::model()->getDentistExam($id_branch);
		}

		$dentistL = array();

		if($dentist){
			foreach ($dentist as $key => $value) {
				$dentistL[] = array(
					'id'    => $value['id_dentist'],
					'text'  => $value['dentist_name'],
					'title' => $value['dentist_name'],
				);
			}
		}
		echo json_encode($dentistL);
	}

	// kiem tra ma khach hang
	public function actionCheckCodeNumber(){
		$code_number = isset($_POST['code_number'])	?	$_POST['code_number']	:'';

		if(!$code_number){
			echo 0;
			exit;
		}

		$customer = Customer::model()->findByAttributes(array('code_number'=>$code_number));
		// fullname, code_number, birthday, phone, address

		if($customer){
			$customerInfo[] = array(
				'id' => $customer->id,
				'fullname'	=> $customer->fullname,
				'code_number' => $customer->code_number,
				'birthdate' => $customer->birthdate,
				'phone' => $customer->phone,
				'address'=> $customer->address,
			);

			echo json_encode($customerInfo);
			exit;
		}

		echo 1;
	}

	//getDentistTimeOff($date, $id_branch)
	public function actionGetDentistTimeOff()
	{
		$sDate = isset($_POST['sDate'])	?	$_POST['sDate']	:'';
		$eDate = isset($_POST['eDate'])	?	$_POST['eDate']	:'';
		$id_branch = isset($_POST['id_branch'])	?	$_POST['id_branch']	:1;
		$type = isset($_POST['type'])	?	$_POST['type']	:1;
		$id_resource = isset($_POST['id_resource'])	?	$_POST['id_resource']	:'';

		$id_dentist = '';
		$id_chair = '';

		// nha sy
		if ($type == 1){
			$id_dentist = $id_resource;
		} else {
			$id_chair = $id_resource;
		}

		echo json_encode(CsSchedule::model()->getDentistTimeOff($sDate, $eDate, $id_branch, $id_dentist, $id_chair, $type));
	}
	public function actionCheckPhone(){
		$phone = $_POST["phone"];
		if ($_POST["phone"]=="") {
			echo "true";
			exit();
		}
		$prefix = substr($phone,0,3);
		$ValuePrefix = PhonePrefix::model()->findAllByAttributes(
			array(
				"prefix"=>$prefix
			)
		);
		if (count($ValuePrefix)>0) {
			echo "true";
		}else{
			echo "false";
		}
	}
}