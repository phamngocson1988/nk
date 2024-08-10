<?php

class BookController extends HController
{
	public $layout = '//layouts/home_book';

	public function actionIndex() {
		$session = Yii::app()->session;
		unset($session['book']);
		$session['bookOld'] = '';
		$sch = NULL;
		if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false) {
			$criteria = new CDbCriteria();
			$criteria->addCondition('DATE(start_time) >= CURDATE()');
			$criteria->addCondition("status_active >= 0");
			$criteria->addInCondition('status', array(1, 7));
			$criteria->addCondition("id_customer = " . Yii::app()->user->getState('customer_id'));

			$sch = VSchedule::model()->find($criteria);

			if($sch) {
				$session['bookOld'] = $sch->attributes;
			}
		}

		$this->render('index', array('sch'=>$sch));
	}

	// get list services available
	public function actionGetServicesList() {
		$id_branch = isset($_POST['id_branch'])?$_POST['id_branch']:1;

		$servicesList = VServicesHours::model()->getServiceList($id_branch);
		$servicesL = array();

		if($servicesList){
			foreach ($servicesList as $key => $value) {
					$servicesL[] = array(
						'id' => $value['id'],
						'name' => $value['name'],
						'len' => $value['length'],
					);
			}
		}
		echo json_encode($servicesL);
	}

	// get free time for booking online
	public function actionGetExamTime() {
		$id_branch  = isset($_POST['id_branch'])	?	$_POST['id_branch']	:1;
		$id_service = isset($_POST['id_service'])	?	$_POST['id_service']:0;
		$id_dentist = isset($_POST['id_dentist'])	?	$_POST['id_dentist']:0;
		$start      = isset($_POST['start'])		?	$_POST['start']		:0;
		$end        = isset($_POST['end'])			?	$_POST['end']		:0;
		$len        = isset($_POST['len'])			?	$_POST['len']		:5;
		$chair_type = isset($_POST['chair_type'])	?	$_POST['chair_type']		:1;

		if($id_branch && $id_service && $start && $end){
			$time 	= CsSchedule::model()->getBlankTime($id_branch,$id_service,$id_dentist,$start,$end,$len,$chair_type,1);
		}
		else
			$time 	= 0;		// ko đủ dữ liệu đầu vào

		echo json_encode($time);
	}

	// get list dentist working and book onl
	public function actionGetDentistBook() {
		$id_branch  = isset($_POST['id_branch']) ? $_POST['id_branch']:1;
		$id_service = isset($_POST['id_service']) ? $_POST['id_service']:0;

		if(!$id_branch) {
			echo -1;
			exit;
		}

		$dentistL = GpUsers::model()->findAllByAttributes(array('book_onl'=>1,'group_id'=>3, 'id_branch'=> $id_branch));

		if(!$dentistL) {
			echo -1;
			exit;
		}

		foreach ($dentistL as $key => $value) {
			$dentists[] = array(
				'id'   => $value['id'],
				'name' => $value['name'],
			);
		}
		echo json_encode($dentists);
	}

	public function actionSessionBooking() {
		$book = isset($_POST['book']) ?	$_POST['book']	:	false;

		$session         = Yii::app()->session;
		$session['book'] = $book;
	}

	public function actionRegister_info(){
		$session = Yii::app()->session;

		$lang = Yii::app()->request->getParam('lang','');
   	 	if($lang == ''){
      	  $lang =  'vi';
    	}
    	Yii::app()->setLanguage($lang);

		if(!isset($session['book']) || empty($session['book']))
			$this->redirect(array('book/index/lang/'.$lang));

		$model = new Customer();

		if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false)
		{
			$id_customer = Yii::app()->user->getState('customer_id');
			$model       = Customer::model()->findByPk($id_customer);
		}

		$this->render('register_info',array('model'=>$model));
	}

	public function actionCreate_cus() {
		$model 		= 	new Customer();

		if (isset($_POST['Customer'])) {

			$cus = $this->addCustomer($_POST['Customer']);

			if(isset($cus['status']) && $cus['status'] == 0) {
				echo json_encode($cus);
				exit;
			}

			if(isset($cus['status']) && $cus['status'] == 1){
				$login 				=	new LoginCustomerForm;
				$login->username 	= 	$cus['data']['email'];
				$login->password 	= 	$_POST['Customer']['password'];
				$login->login();

				if($login) {
					// tao lich moi
					$addSch 		= 	$this->addSch($cus['data']['id']);

					// gui tin xac thuc
					if($addSch) {
						$send 	= 	$this->sendSMS($cus['data']['phone'],$addSch['success']['code_confirm'],$addSch['success']['id_branch'],$cus['data']['id'],$addSch['success']['id']);

						echo 1;
					}
				}
			}
		}
	}

	public function actionUpdate_cus()
	{
		if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false) {
			$id_customer = Yii::app()->user->getState('customer_id');
		}
		else
			$this->redirect('index');

		$model = Customer::model()->findByPk($id_customer);

        if(isset($_POST['Customer']))
        {
        	$username 			=	$_POST['Customer']['phone'];
        	$password 			= 	$_POST['Customer']['password'];

        	$old 				=	$model->password;

        	if($model->phone == $email && $model->password == md5($password)) {
        		$model->attributes 	= 	$_POST['Customer'];

        		$model->password 	= 	$old;

        		if($model->updateByPk($id_customer,$model->attributes)) {
            		$this->redirect('register_info',array('userphone'=>$model->phone));
        		}
        	}
        }
	}

	public function actionLogAccFbGg() {
		$userId  = isset($_POST['uId'])	?	$_POST['uId'] : '';
		$typeLog = isset($_POST['typeLog'])	?	$_POST['typeLog'] : '';

		// dang nhap facebook
		if($typeLog == 1) {
			$loginFB       = new LoginCustomerFBForm;
			$loginFB->idFB = $userId;
			$log           = $loginFB->login();
		}
		// dang nhap google
		elseif ($typeLog == 2) {
			$loginGG       = new LoginCustomerGGForm;
			$loginGG->idGG = $userId;
			$log           = $loginGG->login();
		}

		echo json_encode($log);
	}

	public function actionUpCusFBGG()
	{
		$model 		= 	new Customer();

		if (isset($_POST['Customer'])) {
			$cus = $this->addCustomer($_POST['Customer']);

			if(isset($cus['status']) && $cus['status'] == 0) {
				echo json_encode($cus);
				exit;
			}

			if(isset($cus['status']) && $cus['status'] == 1){
				// dang nhap bang facebook
				if($_POST['Customer']['id_fb']) {
					$loginFB       = new LoginCustomerFBForm;
					$loginFB->idFB = $_POST['Customer']['id_fb'];
					$log           = $loginFB->login();
				}
				// dang nhap google
				elseif ($_POST['Customer']['id_gg']) {
					$loginGG       = new LoginCustomerGGForm;
					$loginGG->idGG = $_POST['Customer']['id_fb'];
					$log           = $loginGG->login();
				}
			}
		}
	}

	public function actionAddSchedules()
	{
		if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false) {
			$id_customer = Yii::app()->user->getState('customer_id');
		}
		else
			$this->redirect('index');

		$session 	= Yii::app()->session;

		$oldSch = '';

		$addSch 	= 	$this->addSch($id_customer);

		if($addSch['status'] == 1 && isset($session['bookOld']) && !empty($session['bookOld'])) {
			$bookOld = $session['bookOld'];
			$start_time = $bookOld['start_time'];
			$end_time = date_format(date_modify(date_create($start_time), '+ 5 minutes'), 'Y-m-d H:i:s');
			$oldSch = CsSchedule::model()->updateSchedule(array('id' => $bookOld['id'], 'end_time'=> $end_time, 'lenght' => 5, 'status' => -1 ));
		}

		echo json_encode(array('new'=>$addSch,'old'=>$oldSch));
	}

	public function addSch($id_customer)
	{
		$session 	= Yii::app()->session;

		if(!isset($session['book']) || empty($session['book']))
			return -1;

		$book 		= $session['book'];
		$id_note = '';

		if($book[0]['note']) {
			$note = CustomerNote::model()->addnote(array(
					'note'        => $book[0]['note'],
					'id_user'     => 0,
					'id_customer' => $id_customer,
					'flag'        => 1,			// 1: lich hen
					'important'   => 0,
					'status'      => 1,
			));
			if(isset($note['id']))
				$id_note = $note['id'];
		}
		elseif (isset($session['bookOld']) && isset($session['bookOld']['id_note']) && $session['bookOld']['id_note']) {
			$id_note =  $session['bookOld']['id_note'] ;
		}

		$start_time = date('Y-m-d',strtotime($book[0]['day'])) .' ' .$book[0]['time'];
		$end_time 	= date('Y-m-d H:i:s', strtotime($start_time)+(int)$book[0]['len']*60);

		// dat lich hen
		$addSch = CsSchedule::model()->addNewScheduleCheck(array(
			'code'         =>	CsSchedule::model()->createCodeSchedule(date('Y-m-d')),
			'code_confirm' =>	CsSchedule::model()->codeConfirm(),
			'id_customer' =>	$id_customer,
			'id_dentist' =>	$book[0]['id_dentist'],
			'id_author'  =>	0, 			// khách hàng
			'id_branch'  =>	$book[0]['id_branch'],
			'id_chair' =>	$book[0]['id_chair'],
			'id_service' =>	$book[0]['id_service'],
			'lenght' => 	$book[0]['len'],
			'start_time' =>	$start_time,
			'end_time' =>	$end_time,
			'id_note' => 	$id_note,
			'source' =>	1,
			'status' =>	1,			// chua xac thuc
			'active' =>	1,			// chua active
			));

		return $addSch;
	}

	public function actionVerify_schedule()
	{
		$session 		=	Yii::app()->session;

		/*if(!isset($session['sms']) || empty($session['sms']))
			$this->redirect('index');*/

		$this->render('verify_schedule');
	}

	public function actionCheckCode()
	{
		$session 			=		Yii::app()->session;
		if(!isset($session['sms']) || empty($session['sms'])) {
			$this->redirect('index');
		}

		$code_confirm_cus 	=		isset($_POST['code_confirm_cus'])	? 	$_POST['code_confirm_cus']	:	false;
		if(!$code_confirm_cus) {
			echo 0;			// ko tồn tại mã xác thực do khách nhập
			Yii::app()->end;
		}

		$sms 			= 		$session['sms'];

		$sch 			= 		CsSchedule::model()->getSchedule($sms['id_schedule']);

		$code_confirm 	=		$sch->code_confirm;

		if($code_confirm == $code_confirm_cus) {

			$upSchStatus 	=	CsSchedule::model()->updateScheduleCode(array(
				'id'     =>	$sms['id_schedule'],
				'status' =>	1,
				'active' =>	1,
				'code'   => $code_confirm_cus,
			));

			if($upSchStatus['status'] == 1){
				$upCodeCus 		=	Customer::model()->update_code_customer($sms['id_customer']);
			}

			if($upSchStatus['status'] == 1 && $upCodeCus) {
				$ms = 'Cam on quy khach da dat lich hen tai Nha Khoa 2000';
				$rs = $this->sms($sms['phone'],$ms,$sms['id_branch']);
				echo json_encode(array('st'=>1,'dt'=>$upSchStatus['data']));
				unset($session['sms']);
				exit;
			}
			else {
				echo json_encode($upSchStatus);			// ko cap nhat ma code dc
				exit;
			}
		}
		else {
			echo 0;			// nhap sai ma
			exit;
		}
	}

	public function sendSMS($phone,$code_confirm,$id_branch,$id_customer,$id_schedule)
	{
		$session 		=	Yii::app()->session;

		if(isset($session['book']))
			unset($session['book']);

		$sms = array(
			'code_cf'		=> 	$code_confirm,
			'phone'			=>	$phone,
			'id_branch'		=>	$id_branch,
			'id_customer'	=>	$id_customer,
			'id_schedule'	=>	$id_schedule,
			'times'			=>	1,
		);

		$session['sms']		= 	$sms;

		$message = 'Ma xac nhan lich hen Nha Khoa 2000: ' . $sms['code_cf'];
		if($sms['phone']!='84123456789')
			$rs = $this->sms($phone,$message,$id_branch);
		else
			$rs = 1;

		return 1;
	}

	function sms($phone, $content,$id_branch)
	{
		if(!$phone || !$content)
			return 0;
		$rs = CsSchedule::model()->sendSms($phone,$content,$id_branch);

		if($rs > 6) {
			$save = Sms::model()->saveSMS(array('id_sms'=>$rs,'phone'=>'phone','content'=>$content,'flag'=>'1','status'=>'1'));
		}
		else
			$save = Sms::model()->saveSMS(array('id_sms'=>'','phone'=>$phone,'content'=>$content,'flag'=>'1','status'=>$rs));
		return 1;
	}

	public function actionSendAgain()
	{
		$session 		=	Yii::app()->session;
		if(!isset($session['sms']) || empty($session['sms'])) {
			$this->redirect('index');
		}

		$sms 				=	$session['sms'];
		$times 				=	$sms['times'];

		if($times >= 3) {
			echo -2;	// gui qua 3 lan
			exit;
		}

		$upCodeConfirm 	=	CsSchedule::model()->updateSchedule(array(
				'id'			=> $sms['id_schedule'],
				'code_confirm' 	=> CsSchedule::model()->codeConfirm(),
			));

		if($upCodeConfirm) {
			$sms['code_cf'] 	=	$upCodeConfirm->code_confirm;
			$sms['times']		=	$times + 1;

			$session['sms']		=	$sms;
		}
		else {
			echo -1;		// loi cap nhat
			exit;
		}

		$message = 'Ma xac nhan lich hen Nha Khoa 2000: ' . $sms['code_cf'];
		/*if($sms['id_customer']!='72018')
			//$rs = CsSchedule::model()->sendSms($phone,$message,$id_branch);
		else*/
			//$send 	= 	$this->sendSMS($register->phone,$sms['code_cf'],$addSch->id_branch,$register->id,$sms['id_schedule']);
			$rs = 1;

		echo $rs;
	}

	public function actionCancelSchedule()
	{
		$id_sch = isset($_POST['id_sch'])	?	$_POST['id_sch']	:	false;

		$can = CsSchedule::model()->cancelSchedule($id_sch);

		echo $can;
	}

	public function actionGetNoti()
	{
		$id_author   = isset($_POST['id_author']) ? $_POST['id_author'] : 2;
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

	function addCustomer($dataCustomer)
	{
		$cus                       = new Customer();
		$cus->attributes           = $dataCustomer;
		$cus->phone_sms            = $cus->phone;
		$cus->id_source            = 8;
		$dataCustomer['id_source'] = 8;

		if(!$cus->validate()) {
			$error = $cus->getErrors();
			if(isset($error['email'])){
				$cusDb = $cus->findByAttributes(array('email'=>$dataCustomer['email']));

				// co thong tin dang nhap bang facebook va google - chua co thong tin tai khoan bookOke
				if($cusDb->username == '')
				{
					if ($cusDb->id_fb == '' || $cusDb->id_gg == '') {
						return array('status' => -1, 'email' => $dataCustomer['email'], 'id'=>$cusDb->id, 'name' => $cusDb->fullname);
					}
				}
				// co thong tin tai khoan bookoke - dang nhap bang facebook va google
				else
				{
					if((isset($dataCustomer['id_fb']) && $dataCustomer['id_fb']) || (isset($dataCustomer['id_gg']) && $dataCustomer['id_gg']))
					{
						$session  =	Yii::app()->session;
						$book     = $session['book'];
						if(isset($dataCustomer['id_fb']) && $dataCustomer['id_fb'])
							$book['id_fb'] = $dataCustomer['id_fb'];
						if(isset($dataCustomer['id_gg']) && $dataCustomer['id_gg'])
							$book['id_gg'] = $dataCustomer['id_gg'];
						$session['book'] = $book;
						return array('status' => -1, 'email' => $dataCustomer['email'], 'id'=>$cusDb->id, 'name' => $cusDb->fullname);
					}
				}
			}
			return array('status'=>0, 'error'=> $cus->getErrors());
		}

		if(isset($dataCustomer['id_fb']) && !$dataCustomer['id_fb']){
			unset($cus->id_fb);
			unset($dataCustomer['id_fb']);
		}
		elseif (isset($dataCustomer['id_gg']) && !$dataCustomer['id_gg']) {
			unset($cus->id_gg);
			unset($dataCustomer['id_gg']);
		}

		$phone = CsLead::model()->getVnPhone($cus->phone);
		$idLead = CsLead::model()->findByAttributes(array('phone'=>$phone));

		// ton tai so phone trong CsLead
		if($idLead) {
			$cusNew = CustomerLead::model()->addCustomerLead($dataCustomer,$idLead->id);
		}
		// khong ton tai so phone trong CsLead
		else {
			$cusNew = CustomerLead::model()->addlead($cus->attributes);
		}

		return $cusNew;
	}
}