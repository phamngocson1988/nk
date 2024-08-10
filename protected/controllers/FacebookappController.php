<?php

class FacebookappController extends HController
{
	public $layout = '//layouts/fbapp';
	
	public function actionIndex()
	{
		$session = Yii::app()->session;
		unset($session['book']);
	
		$this->render('index');
	}

	public function actionFbCustomer()
	{
		$session = Yii::app()->session;

		if(!isset($session['book']) || empty($session['book']))
			$this->redirect('index');
		
		$model = new Customer();

		if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false)
		{
			$id_customer = Yii::app()->user->getState('customer_id');
			$model = Customer::model()->findByPk($id_customer);
		}
		
		$this->render('fbCustomer',array('model'=>$model,'phone'=>$model->phone));
	}

	public function actionFbRegisterCus() {

		$model 		= 	new Customer();

		if (isset($_POST['Customer'])) {
			$register = $model->registerCustomer(array(	
					'fullname' 			=>	$_POST['Customer']['fullname'],
					'password'			=>	$_POST['Customer']['password'],
					'repeatpassword'	=>	$_POST['Customer']['repeatpassword'],
					'address'			=>	$_POST['Customer']['address'],
					'phone'				=>	$_POST['Customer']['phone'],
					'email'				=>	$_POST['Customer']['email'],
					'gender'			=>	$_POST['Customer']['gender'],
					'birthdate'			=>	$_POST['Customer']['birthdate'],
					'source'			=> 	1, // dang ky tu website nhakhoa2000.com
					'status'			=> 	1
			));

			
			if($register){
				$login 				=	new LoginCustomerForm;
				$login->username 	= 	$register->phone;
				$login->password 	= 	$_POST['Customer']['password'];
				$login->login();

				if($login) {
					// tao lich moi
					$addSch 		= 	$this->addSchedule($register->id);

					// gui tin xac thuc
					if($addSch) {
						$send 	= 	$this->sendSMS($register->phone,$addSch->code_confirm,$addSch->id_branch,$register->id,$addSch->id);

						$this->redirect('fbVerify');
					}
					else {
						$this->redirect('fbCustomer',array('model'=>$model));
					}
				}
			}
		}
	}

	public function actionFbEditCus() 
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
        	
        	if($model->phone == $username && $model->password == md5($password)) {
        		$model->attributes 	= 	$_POST['Customer'];
        		
        		$model->password 	= 	$old;

        		if($model->updateByPk($id_customer,$model->attributes)) {
            		$this->redirect('fbCustomer',array('phone'=>$username));
        		}
        	}
        }
	}

	public function actionFbLogin()
	{
		$model = new LoginCustomerForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='frm-login-customer')
		{
			echo CActiveForm::validate($loginCustomer);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginCustomerForm']))
		{
			$model->attributes = $_POST['LoginCustomerForm'];

			// validate user input and redirect to the previous page if valid
			if(!$model->validate() && $model->login()){
				Yii::app()->user->setState('registered', true);
				echo "1";
				Yii::app()->end();
			}
		}

		$this->renderPartial('fbLogin',array('model'=>$model));
	}

	function addSchedule($id_customer)
	{
		$session 	= Yii::app()->session;

		if(!isset($session['book']) || empty($session['book']))
			return -1;

		$book 		= $session['book'];

		$start_time = date('Y-m-d',strtotime($book[0]['day'])) .' ' .$book[0]['time'];
		$end_time 	= date('Y-m-d H:i:s', strtotime($start_time)+(int)$book[0]['len']*60);

		// dat lich hen
		$addSch = CsSchedule::model()->addNewScheduleCheck(array(
			'code'			=>	CsSchedule::model()->createCodeSchedule(date('Y-m-d')),
			'code_confirm'	=>	CsSchedule::model()->codeConfirm(), 
			'id_customer'	=>	$id_customer, 
			'id_dentist'	=>	$book[0]['id_dentist'], 
			'id_author'		=>	0, 			// khách hàng
			'id_branch'		=>	$book[0]['id_branch'], 
			'id_chair'		=>	$book[0]['id_chair'],
			'id_service'	=>	$book[0]['id_service'],
			'lenght' 		=> 	$book[0]['len'], 
			'start_time'	=>	$start_time,
			'end_time'		=>	$end_time, 
			'status'		=>	0,			// chua xac thuc 
			'active'		=>	0,			// chua active
		));

		return $addSch;
	}

	public function actionAddSchedules()
	{
		$phone = isset($_POST['phone']) ? $_POST['phone'] : false;

		if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false) {
			$id_customer = Yii::app()->user->getState('customer_id');
		}
		else
			$this->redirect('index');

		$addSch 	= 	$this->addSchedule($id_customer);


		if($addSch) {
			$send 	= 	$this->sendSMS($phone,$addSch->code_confirm,$addSch->id_branch,$id_customer,$addSch->id);

			if($send > 6)
				echo 1;
			else
				echo -1;

			exit;
		}
	}

	public function actionSessionBook()
	{
		$book 				= isset($_POST['book'])	?	$_POST['book']		:	false;

		$session 			= Yii::app()->session;
		$session['book'] 	= $book;
	}

	public function actionFbVerify()
	{
		$session 		=		Yii::app()->session;

		if(!isset($session['sms']) || empty($session['sms']))
			$this->redirect('index');

		$sms 			= 		$session['sms'];

		$this->render('fbVerify');
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

			$upSchStatus 	=	CsSchedule::model()->updateSchedule(array(
				'id'		=>	$sms['id_schedule'],
				'status'	=>	1,
				'active'	=>	1
			));

			$upCodeCus 		=	Customer::model()->update_code_customer($sms['id_customer']);

			if($upSchStatus && $upCodeCus) {
				echo 1;				// xác thực
				unset($session['sms']);

				Yii::app()->user->setState('customer_id', null);
        		Yii::app()->user->setState('customer_name', null);
        		Yii::app()->session['guest'] = true;

				exit;
			}
			else {
				echo -2;			// ko cap nhat ma code dc
				exit;
			}
		}
		else {
			echo -1;			// ko xác thực
			exit;
		}
	}

	public function sendSMS($phone,$code_confirm,$id_branch,$id_customer,$id_schedule)
	{
		$session 		=	Yii::app()->session;

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
		if($sms['id_customer']!='72018')
			$rs = CsSchedule::model()->sendSms($phone,$message,$id_branch);
		else
			$rs = 10;

		return $rs;
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
		if($sms['id_customer']!='72018')
			$rs = CsSchedule::model()->sendSms($phone,$message,$id_branch);
		else
			$rs = 10;

		echo $rs;
	}
}