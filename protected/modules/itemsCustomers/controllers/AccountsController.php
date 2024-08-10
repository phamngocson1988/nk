<?php

class AccountsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '/layouts/main_cus';

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
	public function accessRules()
	{
		return parent::accessRules();
	}

	public function actionAdmin()
	{
		$model       = new Customer();
		$code_number = '';

		if (isset($_GET['code_number'])) {
			$code_number = $_GET['code_number'];
		}

		$hintCodeNumber = implode(",", $model->getCodeNumberCustomerToday());
		$createCodeNumber = $model->getCodeNumberCustomer();
		$Localtionprovince = LocaltionProvince::model()->findAll();
		$remind = new CustomerScheduleRemind();

		$this->render('admin', array(
			'model'            => $model,
			'code_number'      => $code_number,
			'hintCodeNumber'   => $hintCodeNumber,
			'createCodeNumber' => $createCodeNumber,
			'Localtionprovince' => $Localtionprovince,
			'remind' => $remind
		));
	}

	#region --- DETAIL CUSTOMER
	public function actionDetailCustomer() {
		$model = new Customer();
		$Localtionprovince = LocaltionProvince::model()->findAll();
		$remind = false;

		if (isset($_POST['id'])) {
			$model     = $model->findByPk($_POST['id']);
			$treatment = $model->checkTreatment($_POST['id']);

			$remind = CustomerScheduleRemind::model()->find(array(
				'select' => 'durations, durations_type, date_remind, status',
				'condition' => "id_customer = " . $_POST['id']
			));
		} else {
			$treatment = 0;
		}

		if (!$remind) {
			$remind = new CustomerScheduleRemind();
			$remind->durations = 1;
		}

		$this->renderPartial('customer_info', array(
			'model'     => $model,
			'treatment' => $treatment,
			'Localtionprovince' => $Localtionprovince,
			'remind' => $remind
		), false, false);
	}
	#endregion

	public function actionTab() {
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
		}
		$this->renderPartial('tab', array(
			'model' => $this->loadModel($id),
		), false, true);
	}

	public function actionImportExcelIntoCustomer()
	{
		$this->render('import_excel_into_customer');
	}

	public function actionImportExcelIntoTransaction()
	{
		$this->render('import_excel_into_transaction');
	}

	public function actionAdd()
	{
		if ($_POST['customerNewCodeNumber'] && $_POST['customerNewName']) {
			$result = Customer::model()->addNewCustomer($_POST['customerNewCodeNumber'], $_POST['customerNewName'], $_POST['customerNewPhone'], Yii::app()->params['id_branch']);
			echo $result;
		}
	}

	public function actionAddNewMedicalHistory()
	{

		if (isset($_POST['id_customer']) && isset($_POST['id_mhg'])) {

			$model = Customer::model()->findByPk($_POST['id_customer']);

			$chk_medical_history = isset($_POST['chk']) ? $_POST['chk'] : "";

			$ipt_medical_history = isset($_POST['ipt']) ? $_POST['ipt'] : "";

			$checkMedicalHistory = $model->checkMedicalHistory($_POST['id_customer']);

			if ($checkMedicalHistory == 0) {
				$data = $model->addNewMedicalHistoryAlert($_POST['id_customer'], $chk_medical_history, $ipt_medical_history, yii::app()->user->getState('user_id'));
				$treatment = $model->checkTreatment($_POST['id_customer']);
			} else {
				$data = $model->updateMedicalHistoryAlert($_POST['id_customer'], $chk_medical_history, $ipt_medical_history);
				$treatment = CsMedicalHistoryGroup::model()->findByPk($_POST['id_mhg']);
			}

			$this->renderPartial('medical_record', array(
				'model' => $model, 'treatment' => $treatment
			), false, true);
		}
	}

	public function actionGetCustomerList()
	{
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$search = isset($_POST['q']) ? $_POST['q'] : '';

		$item = 20;
		$orderBy = "";
		$search_params = "";
		
		if ($search) {
			if (date_create_from_format('d/m/Y', $search)) {
				$search_params = 'AND (`birthdate` = "' . date_format(date_create_from_format('d/m/Y', $search), 'Y-m-d') . '")';
			} else {
				$search_params = 'AND ((`fullname` LIKE "%' . $search . '%" ) OR (`phone` LIKE "%'.$search.'%") OR (`code_number` LIKE "%'.$search.'%"))';	
			}	
		} else {
			if ($_POST['email']) {
				$search_params .= ' AND (`email` LIKE "%' . $_POST['email'] . '%" ) ';
			}

			if ($_POST['country']) {
				$search_params .= ' AND (`id_country` LIKE "%' . $_POST['country'] . '%" ) ';
			}

			if ($_POST['identity_card_number']) {
				$search_params .= ' AND (`identity_card_number` LIKE "%' . $_POST['identity_card_number'] . '%" ) ';
			}

			if ($_POST['source']) {
				$search_params .= ' AND (`id_source` LIKE "%' . $_POST['source'] . '%" ) ';
			}

			if ($_POST['segment']) {
				$listCustomerSegment = Customer::model()->getListCustomerByIdSegment($_POST['segment']);
				if (!empty($listCustomerSegment)) {
					$search_params .= ' AND ( ';
					foreach ($listCustomerSegment as $key => $value) {
						if ($key == 0) {
							$search_params .= ' (`code_number` LIKE "%' . $value['code_number'] . '%" ) ';
						} else {
							$search_params .= 'OR (`code_number` LIKE "%' . $value['code_number'] . '%" ) ';
						}
					}
					$search_params .= ') ';
				}
			}

			if ($_POST['type'] == 0) {
				if (yii::app()->user->getState('group_id') == 3) {
					$orderBy = 'FIELD(status_schedule,6,3,2,1,5,4,0,-1,-2,7) ';
				} else {
					$orderBy = '`status_schedule` DESC ';
				}
			} elseif ($_POST['type'] == 1) {
				$orderBy = '`fullname` ASC ';
			} elseif ($_POST['type'] == 2) {
				$orderBy = '`code_number` DESC ';
			}
		}

		if (Yii::app()->user->getState('group_id') != 1) {
			$search_params .= ' AND (`id_branch` = ' . Yii::app()->user->getState('user_branch') . ' )';
		}

		$customerList = Customer::model()->searchCustomersAccounts('', '', ' ' . $search_params, $orderBy, $item, $page);
		if (!$customerList || ($customerList && !$customerList['data'])) {
			echo -1;
			exit();
		}
		foreach ($customerList['data'] as $key => $value) {
			$customer[] = array(
				'code_number' => $value['code_number'],
				'id' => $value['id'],
				'text' => $value['fullname'],
				'birthdate' => $value['birthdate'],
				'phone' => $value['phone'],
				'address' => $value['address']
			);
		}
		echo json_encode($customer);
	}

	public function actionEditMedicalHistory()
	{
		if (isset($_POST['id_customer']) && isset($_POST['id_mhg'])) {
			$model = Customer::model()->findByPk($_POST['id_customer']);
			$id_mhg = $_POST['id_mhg'];
			$treatment = $model->checkTreatment($_POST['id_customer']);
			$this->renderPartial('frm_edit_mha', array('model' => $model, 'id_mhg' => $id_mhg, 'treatment' => $treatment));
		}
	}

	public function actionAddDentalStatus()
	{

		if (isset($_POST['id_customer']) && isset($_POST['id_mhg'])) {

			$result = ToothData::model()->saveTooth($_POST['id_customer'], $_POST['id_mhg'], json_decode($_POST['tooth_data']), json_decode($_POST['tooth_image']), json_decode($_POST['tooth_conclude']), json_decode($_POST['tooth_note']), json_decode($_POST['tooth_assign']));

			$model = Customer::model()->findByPk($_POST['id_customer']);

			$treatment = CsMedicalHistoryGroup::model()->findByPk($_POST['id_mhg']);

			$this->renderPartial('medical_record', array(
				'model' => $model, 'treatment' => $treatment
			), false, true);
		}
	}

	public function actionAddNewTreatment()
	{

		if (isset($_POST['id_customer'])) {
			$model = Customer::model()->findByPk($_POST['id_customer']);
			$data = $model->addTreatment($_POST['id_customer']);
			$treatment = $model->checkTreatment($_POST['id_customer']);
			$this->renderPartial('medical_record', array(
				'model' => $model, 'treatment' => $treatment
			), false, true);
		}
	}

	public function actionDetailTreatment()
	{
		if (isset($_POST['id']) && isset($_POST['id_customer'])) {
			$model = Customer::model()->findByPk($_POST['id_customer']);
			$treatment = CsMedicalHistoryGroup::model()->findByPk($_POST['id']);
			$this->renderPartial('medical_record', array(
				'model' => $model, 'treatment' => $treatment
			), false, true);
		}
	}

	public function actionUpdateTreatment()
	{

		if (isset($_POST['id']) && isset($_POST['id_customer'])) {
			$model = Customer::model()->findByPk($_POST['id_customer']);
			$treatment = CsMedicalHistoryGroup::model()->findByPk($_POST['id']);
			$data = Customer::model()->updateTreatment($_POST['id']);
			if ($data == 1) {
				$this->renderPartial('medical_record', array(
					'model' => $model, 'treatment' => $treatment
				), false, true);
			}
		}
	}

	public function actionUpdateCustomerImage()
	{
		if (isset($_POST['id'])) {
			$id      = $_POST['id'];
			$model   = Customer::model()->findByPk($id);
			$ext     = pathinfo($_FILES['image123']['name'], PATHINFO_EXTENSION);
			$rnd     = date("dmYHis") . uniqid();
			$newName = $rnd . '.' . $ext;
			$image   = $_FILES["image123"]["error"] == 0 ? $newName : $model['image'];
			$kq      = Customer::model()->updateByPk($id, array('image' => $image));

			if ($kq) {
				if ($_FILES["image123"]["error"] == 0) {
					if ($model['image'] != "" && $model['image'] != "no_image.png" && $model['image'] != "no_avatar.png") {
						@unlink(Yii::app()->basePath . '/../upload/customer/avatar/' . $model['image']);
					}
					move_uploaded_file($_FILES["image123"]["tmp_name"], "./upload/customer/avatar/$image");
				}
			}

			$this->renderPartial('customer_image', array('model' => $model), false, true);
		}
	}

	public function actionUpdateCustomerImageDefault()
	{
		if (isset($_POST['id'])) {
			$id      = $_POST['id'];
			$model   = Customer::model()->findBypk($id);
			$kq      = Customer::model()->updateByPk($id, array('image' => null));

			if ($kq) {

				if ($model['image'] != "" && $model['image'] != "no_image.png" && $model['image'] != "no_avatar.png") {
					@unlink(Yii::app()->basePath . '/../upload/customer/avatar/' . $model['image']);
				}
			}

			$this->renderPartial('customer_image', array('model' => $model), false, true);
		}
	}

	public function actionUpdateWebcamImage()
	{
		if (isset($_GET['id'])) {
			$id      = $_GET['id'];
			$model   = Customer::model()->findBypk($id);
			$ext     = pathinfo($_FILES['webcam']['name'], PATHINFO_EXTENSION);
			$rnd     = date("dmYHis") . uniqid();
			$newName = $rnd . '.' . $ext;
			$image   = $_FILES["webcam"]["error"] == 0 ? $newName : $model['image'];
			$kq      = Customer::model()->updateByPk($id, array('image' => $image));

			if ($kq) {
				if ($_FILES["webcam"]["error"] == 0) {
					if ($model['image'] != "" && $model['image'] != "no_image.png" && $model['image'] != "no_avatar.png") {
						unlink(Yii::app()->basePath . '/../upload/customer/avatar/' . $model['image']);
					}
					move_uploaded_file($_FILES["webcam"]["tmp_name"], "./upload/customer/avatar/$image");
				}
			}

			$this->renderPartial('customer_image', array('model' => $model), false, true);
		}
	}
	public function smtpsendmail($mailTo, $title, $AltBody, $email_content)
	{
		$mail = Yii::app()->Smtpmail;
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->SMTPDebug  = 1;
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

		$mail->Username = "dentailnhakhoa2000@gmail.com";
		$mail->Password = "callnex2015";
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->SetFrom("info@nhakhoa2000.com", 'NhaKhoa2000 Support');
		$mail->AltBody = $AltBody;
		$mail->Subject = $title;
		$mail->Body = $email_content;
		$mail->AddAddress($mailTo);
		$mail->CharSet = "utf-8";
		if (!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Chúng tôi vừa thông tin kích hoạt tài khoản vào địa chỉ " . $mailTo . " ! Vui lòng vào mail kiểm tra và xác nhận";
		}
	}
	public function actionSendMailCreateUser()
	{
		if (isset($_POST['email']) && $_POST['email']) {
			$email = $_POST['email'];
			$password = $_POST['pass'];
			$testemail = Customer::model()->findAllByAttributes(array('email' => $email));
			// print_r($testemail);
			// exit();
			if ($testemail != "") {
				$activation = md5($email . time());
				$command = Yii::app()->db->createCommand();
				$data = $command->update('customer', array(
					'code_confirm' => $activation,
					'username' => $email,
					'password' => md5($password),
				), 'id=:id', array(':id' => $_POST['id']));
				//Title
				$title    = 'XÁC NHẬN ĐĂNG KÍ TÀI KHOẢN';
				//AltBody
				$AltBody = "Xác nhận đăng kí tài khoản NhaKhoa2000 !";
				//Noi dung gui mail
				$content  = $this->renderPartial('/accounts/view_sendmailconfim', array('mail_info' => $_REQUEST, 'activation' => $activation), true);
				$result = $this->smtpsendmail($_REQUEST['email'], $title, $AltBody, $content);
			} else {
				echo "Email xác nhận đã gửi , vui lòng chờ !";
			}
		}
	}

	public function actionUpdateCustomer()
	{
		if (isset($_POST['id'])) {
			$model = new Customer;

			if (strlen($_POST['phone']) > 10) {
				echo -1;
				return;
			}

			$phone = $model->getVnPhone($_POST['phone']);

			$phone_sms = $model->getVnPhone($_POST['phone_sms']);

			if ($phone && !$model->TestPrefix($phone)) {
				echo -4;
				return;
			}

			if ($_POST['birthdate']) {
				$birthdate = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['birthdate'])));
			} else {
				$birthdate = null;
			}

			if ($_POST['last_day']) {
				$last_day = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['last_day'])));
			} else {
				$last_day = null;
			}

			$data = $model->updateCustomer($_POST['id'], $_POST['code_number'], $_POST['membership_card'], $_POST['fullname'], $_POST['email'], $phone, $phone_sms, $_POST['gender'], $birthdate, $_POST['identity_card_number'], $_POST['id_country'], $_POST['id_source'], $_POST['id_job'], $_POST['position'], $_POST['address'], $_POST['flag'], $last_day, $_POST['note'], $_POST['nickname'], $_POST["phone2"], $_POST["city"], $_POST["county"], $_POST['branch']);

			if ($data != -2) {
				CustomerScheduleRemind::model()->updateDateRemindTime($_POST['id']);
				echo '<div class = "alert alert-success" id="success-alert"><a href = "#" class = "close" data-dismiss = "alert" style="font-size: 22px; color:#333;">&times;</a><strong>Thành Công!</strong> Đã cập nhật...</div>';
				exit;
			}

			print_r($data);
		}
	}

	public function actionDeleteCustomer()
	{
		$customer = Customer::model()->findByPk($_POST['id']);
		$customer->user_delete = Yii::app()->user->getState('user_id');
		$customer->status = -1;
		$customer->update();
		echo 1;
		exit;
	}

	public function actionUpdateCustomerName()
	{
		$customer = Customer::model()->findByPk($_POST['id_customer']);
		$customer->fullname = $_POST['customerName'];
		$customer->update();
		echo 1;
		exit;
	}

	public function actionUpdateCodeMember()
	{
		if (isset($_POST['id'])) {
			$model = new CustomerMember;
			$id_customer = CustomerMember::model()->findByAttributes(array('id_customer' => $_POST['id']));
			if ($id_customer) {
				$data = $model->updateCusMember($_POST['id'], $_POST['membership_card'], 1);
				print_r($data);
			} else {
				$data = $model->insertCodeMember($_POST['id'], $_POST['membership_card'], 1);
				print_r($data);
			}
		}
	}
	public function actionUpdateCustomerSegment()
	{
		if (isset($_POST['id'])) {
			$model = new Customer;

			$model->updateCustomerSegment($_POST['id'], $_POST['id_segment']);
			echo '<div class = "alert alert-success" id="success-alert"><a href = "#" class = "close" data-dismiss = "alert" style="font-size: 22px; color:#333;">&times;</a><strong>Thành Công!</strong> Đã cập nhật...</div>';
		}
	}

	public function actionUpdateStatusSchedule()
	{
		if (isset($_POST['id']) && isset($_POST['id_customer']) && isset($_POST['status_schedule'])) {
			$check = 1;
			$st = $_POST['status_schedule'];

			if (in_array($st, array(2, 6, 3))) {
				$check = CsSchedule::model()->checkScheduleStatus($_POST['id_customer'], $_POST['id']);
			}

			if ($check) {
				$id_quotation = isset($_POST['id_quotation']) ? $_POST['id_quotation'] : 0;
				$result       = CsSchedule::model()->updateSchedule(array(
					'id'           => $_POST['id'],
					'status'       => $_POST['status_schedule'],
					'id_quotation' => $id_quotation
				));

				$data   = Customer::model()->updateStatusScheduleOfCustomer($_POST['id_customer'], $_POST['status_schedule']);

				if (isset($result['data']) && $result['data']['status'] == 4) {
					$date = DateTime::createFromFormat('Y-m-d H:i:s', $result['data']['start_time']);
					if ($date) {
						Customer::model()->updateLastTreatment($_POST['id_customer'], $date->format('Y-m-d'));
						CustomerScheduleRemind::model()->updateDateRemindTime($_POST['id_customer']);
					}
				}

				echo json_encode($result);
				exit;
			}

			echo $check;
		}
	}

	public function actionUpdateToExamination()
	{

		$result = Customer::model()->updateToExamination($_POST['id_customer']);

		echo json_encode($result);
	}

	public function actionUpdateEvaluateStateOfTartar()
	{
		if (isset($_POST['id']) && isset($_POST['evaluate_state_of_tartar'])) {
			$id     = $_POST['id'];
			$result = Customer::model()->updateEvaluateStateOfTartar($id, $_POST['evaluate_state_of_tartar']);
		}
	}

	// Load tab customer info
	public function actionLoadCustomerSchedule()
	{
		$id_customer = (isset($_POST["id_customer"])) ? $_POST["id_customer"] : false;

		if (!$id_customer) {
			echo "";
			exit;
		}

		$sch = new CsSchedule();
		$list_schedule = $sch->getListSchedule('', '', '', '', 'start_time DESC', $id_customer);
		$this->renderPartial('tab_appointment_schedule', array(
			'sch'           => $sch,
			'list_schedule' => $list_schedule,
		));
	}

	public function actionLoadMedicalReport()
	{
		$model = new Customer();
		if (isset($_POST['id_customer']) && $_POST['id_customer']) {
			$model     = $model->findByPk($_POST['id_customer']);
			$treatment = $model->checkTreatment($_POST['id_customer']);
		} else {
			$treatment = 0;
		}

		$this->renderPartial('medical_record', array(
			'model' => $model, 'treatment' => $treatment
		), false, false);
	}

	public function actionLoadTabDoctorSalary()
	{
		//$model = new Customer();
		$this->renderPartial('tab_doctor_salary', array(
			//'model'=>$model,
			'id_customer' => $_POST['id_customer'],
		), false, false);
	}

	public function actionLoadTabReceivable()
	{
		$id_customer = (isset($_POST["id_customer"])) ? $_POST["id_customer"] : false;
		$cur_page = (isset($_POST["page"])) ? $_POST["page"] : 1;

		if (!$id_customer) {
			echo "";
			exit;
		}

		$search_params = array('id_customer' => $id_customer);
		$lpp = 8;
		$status = 3;

		$list_data  = VReceivable::model()->SearchReceivableAccount($search_params, '', 'order by id desc', $lpp, $cur_page, $status, '');

		$this->renderPartial('tab_receivable', array(
			'receivable' => $list_data
		));
	}



	public function actionInsertUpdateCustomerInsurrance()
	{
		if ($_POST['code_insurrance']) {
			$id_customer = $_POST['id_customer'];
			$code_insurrance = $_POST['code_insurrance'];
			$type_insurrance = $_POST['type_insurrance'];
			$startdate = $_POST['startdate'];
			$enddate = $_POST['enddate'];
			$find_insurrance = CsCustomerInsurrance::model()->findByAttributes(array('id_customer' => $id_customer));
			if ($find_insurrance) {
				$updateInsurrance = CsCustomerInsurrance::model()->updateInsurrance($id_customer, $code_insurrance, $type_insurrance, $startdate, $enddate);
			} else {
				$insertInsurrance = CsCustomerInsurrance::model()->insertInsurrance($id_customer, $code_insurrance, $type_insurrance, $startdate, $enddate);
			}
		} else {

			CsCustomerInsurrance::model()->deleteAllByAttributes(array('id_customer' => $_POST['id_customer']));
		}
	}
	public function actionUpdateStatusInsurrance()
	{
		if (isset($_POST['id_customer'])) {
			$id_customer = $_POST['id_customer'];
			$insurrance_status = $_POST['insurrance_status'];
			$find_insurrance = CsCustomerInsurrance::model()->findByAttributes(array('id_customer' => $id_customer));
			if ($find_insurrance) {
				$updateStatusInsurrance = CsCustomerInsurrance::model()->updateStatusInsurrance($id_customer, $insurrance_status);
			}
		}
	}
	public function actionAddPlan()
	{
		$csmedicalhistoryplan = new CsMedicalHistoryPlan;
		if (isset($_POST['planNewName']) && isset($_POST['id_history_group']) && isset($_POST['id_dentist'])) {
			$csmedicalhistoryplan->name = $_POST['planNewName'];
			$csmedicalhistoryplan->id_history_gourp = $_POST['id_history_group'];
			$csmedicalhistoryplan->id_dentist =	$_POST['id_dentist'];
			$csmedicalhistoryplan->id_user =	yii::app()->user->getState('user_id');
			$csmedicalhistoryplan->createdate =	date('Y-m-d H:i:s');
			$csmedicalhistoryplan->save();
			$this->renderPartial('treatment_plan', array('id_history_group' => $_POST['id_history_group']), false, true);
		}
	}

	public function actionSaveMedicalHistory()
	{
		if ($_POST['treatment_work']) {
			$model = Customer::model()->findByPk($_POST['id_customer']);

			$id_shedule = '';

			$id_branch      = $model->getIdBranchByIdUser($_POST['id_dentist']);

			$tooth_numbers = isset($_POST['tooth_numbers']) ? $_POST['tooth_numbers'] : "";

			if ($_POST['id_medical_history']) {
				$data  = $model->updateMedicalHistory($_POST['id_medical_history'], $_POST['id_customer'], $_POST['id_history_group'], yii::app()->user->getState('user_id'), $_POST['id_dentist'], $id_branch, $_POST['treatment_work'], $tooth_numbers, $_POST['createdate'], $_POST['reviewdate'], $_POST['description'], $_POST['newest_schedule']);
			} else {
				$session_add_prescription = isset(Yii::app()->session['add_prescription']) ? Yii::app()->session['add_prescription'] : "";
				$session_add_lab          = isset(Yii::app()->session['add_lab']) ? Yii::app()->session['add_lab'] : "";
				$data                     = $model->addMedicalHistory($_POST['id_customer'], $_POST['id_history_group'], yii::app()->user->getState('user_id'), $_POST['id_dentist'], $id_branch, $_POST['treatment_work'], $tooth_numbers, $session_add_prescription, $session_add_lab, $_POST['createdate'], $_POST['reviewdate'], $_POST['description'], $_POST['newest_schedule']);

				if (isset($_POST['status_success'])) {

					$id_shedule    = $model->getIdScheduleByIdCustomer($_POST['id_customer']);

					if ($id_shedule) {

						$id_quotation   = $model->checkNewestTreatmentExistQuotation($_POST['id_customer']);

						$result         = CsSchedule::model()->updateSchedule(array('id' => $id_shedule, 'status' => 4, 'id_quotation' => $id_quotation));
					}
				}
			}

			$this->renderPartial('medical_history', array('model' => $model, 'id_mhg' => $_POST['id_history_group'], 'id_shedule' => $id_shedule));
		}
	}

	public function actionDeleteMedicalHistory()
	{
		if (isset($_POST['id']) && isset($_POST['id_history_group'])) {
			$model = new Customer;
			$data  = $model->deleteMedicalHistory($_POST['id']);

			if ($data == 1) {

				$this->renderPartial('medical_history', array('model' => $model, 'id_mhg' => $_POST['id_history_group']));
			}
		}
	}

	public function actionExportTreatmentRecords()
	{

		if ($_GET['id_customer'] && $_GET['id_medical_history_group']) {

			$model      			  = Customer::model()->findByPk($_GET['id_customer']);

			$list_ma    			  = $model->getListMedicalHistoryAlert($model->id);

			$list_m     			  = $model->getListMedicineAlert();

			$tooth_data 			  = new ToothData;

			$listToothStatus          = $tooth_data->getListToothStatus($model->id, $_GET['id_medical_history_group']);

			$listOnlyToothNote        = $tooth_data->getListOnlyToothNote($model->id, $_GET['id_medical_history_group']);

			$listTreatment 			  = VQuotations::model()->getListTreatmentOfQuotation(1, 20, $_GET['id_customer'], $_GET['id_medical_history_group']);

			$listTreatmentProcess     = $model->getListTreatmentProcessOfCustomer($_GET['id_medical_history_group']);

			$filename   			  = 'test.pdf';

			$html2pdf   			  = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);

			$html2pdf->WriteHTML($this->renderPartial('export_treatment_records', array('model' => $model, 'id_mhg' => $_GET['id_medical_history_group'], 'tooth_data' => $tooth_data, 'list_ma' => $list_ma, 'list_m' => $list_m, 'listToothStatus' => $listToothStatus, 'listOnlyToothNote' => $listOnlyToothNote, 'listTreatment' => $listTreatment, 'listTreatmentProcess' => $listTreatmentProcess), true));

			$html2pdf->Output($filename, 'I');
		}
	}

	public function actionExportTreatmentRecordsOfCustomer()
	{

		if ($_GET['id_customer'] && $_GET['id_medical_history_group']) {

			$model      			  = Customer::model()->findByPk($_GET['id_customer']);

			$list_ma    			  = $model->getListMedicalHistoryAlert($model->id);

			$list_m     			  = $model->getListMedicineAlert();

			$tooth_data 			  = new ToothData;

			$listToothStatus          = $tooth_data->getListToothStatus($model->id, $_GET['id_medical_history_group']);

			$listOnlyToothNote        = $tooth_data->getListOnlyToothNote($model->id, $_GET['id_medical_history_group']);

			$evaluateStateOfTartar    = Customer::model()->getEvaluateStateOfTartar($_GET['id_medical_history_group']);

			$filename   			  = 'test.pdf';

			$html2pdf   			  = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);

			$html2pdf->WriteHTML($this->renderPartial('export_treatment_records_of_customer', array('model' => $model, 'id_mhg' => $_GET['id_medical_history_group'], 'tooth_data' => $tooth_data, 'list_ma' => $list_ma, 'list_m' => $list_m, 'listToothStatus' => $listToothStatus, 'listOnlyToothNote' => $listOnlyToothNote, 'evaluateStateOfTartar' => $evaluateStateOfTartar), true));

			$html2pdf->Output($filename, 'I');
		}
	}

	public function actionExportProfile()
	{

		if ($_GET['id_customer']) {

			$model = Customer::model()->findByPk($_GET['id_customer']);

			$filename = 'test.pdf';

			$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);

			$html2pdf->WriteHTML($this->renderPartial('export_profile', array('model' => $model), true));

			$html2pdf->Output($filename, 'I');
		}
	}

	public function actionExportPrescription()
	{

		if ($_GET['id_customer'] && $_GET['id_medical_history']) {

			$model = Customer::model()->findByPk($_GET['id_customer']);

			$data  = Customer::model()->getMedicalHistoryById($_GET['id_medical_history']);

			$filename = 'test.pdf';

			$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);

			$html2pdf->WriteHTML($this->renderPartial('export_prescription', array('model' => $model, 'data' => $data), true));

			$html2pdf->Output($filename, 'I');
		}
	}

	public function actionExportLab()
	{

		if ($_GET['id_medical_history']) {

			$model = Customer::model()->findByPk($_GET['id_customer']);

			$data  = Customer::model()->getMedicalHistoryById($_GET['id_medical_history']);

			$filename = 'test.pdf';

			$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);

			$html2pdf->WriteHTML($this->renderPartial('export_lab', array('model' => $model, 'data' => $data), true));

			$html2pdf->Output($filename, 'I');
		}
	}

	public function actionView_frm_treatment()
	{
		if ($_POST['id']) {
			echo json_encode(Customer::model()->getMedicalHistoryById($_POST['id']));
		}
	}

	public function actionSetSessionAddPrescription()
	{

		if ($_POST['diagnose'] && $_POST['drug_name'] && $_POST['times'] && $_POST['dosage']) {

			if ($_POST['id_cs_medical_history']) {
				$data  = Customer::model()->savePrescription(array('id_group_history' => $_POST['id_history_group'], 'id_medical_history' => $_POST['id_cs_medical_history'], 'diagnose' => $_POST['diagnose'], 'drug_name' => $_POST['drug_name'], 'times' => $_POST['times'], 'dosage' => $_POST['dosage'], 'advise' => $_POST['advise'], 'examination_after' => $_POST['examination_after']));
			} else {
				Yii::app()->session['add_prescription'] = array('diagnose' => $_POST['diagnose'], 'drug_name' => $_POST['drug_name'], 'times' => $_POST['times'], 'dosage' => $_POST['dosage'], 'advise' => $_POST['advise'], 'examination_after' => $_POST['examination_after']);
			}
		}
	}

	public function actionSetSessionAddLab()
	{

		if ($_POST['id_br4nch'] && $_POST['id_d3ntist'] && $_POST['sent_date'] && $_POST['received_date'] && $_POST['assign']) {

			if ($_POST['id_cs_m3dical_history']) {
				$data  = Customer::model()->saveLab(array('id_group_history' => $_POST['id_history_group'], 'id_medical_history' => $_POST['id_cs_m3dical_history'], 'id_branch' => $_POST['id_br4nch'], 'id_dentist' => $_POST['id_d3ntist'], 'sent_date' => $_POST['sent_date'], 'received_date' => $_POST['received_date'], 'assign' => $_POST['assign'], 'note' => $_POST['note']));
			} else {
				Yii::app()->session['add_lab'] = array('id_branch' => $_POST['id_br4nch'], 'id_dentist' => $_POST['id_d3ntist'], 'sent_date' => $_POST['sent_date'], 'received_date' => $_POST['received_date'], 'assign' => $_POST['assign'], 'note' => $_POST['note']);
			}
		}
	}

	public function actionUnsetSessionAddPrescription()
	{

		unset(Yii::app()->session['add_prescription']);
	}

	public function actionUnsetSessionAddLab()
	{

		unset(Yii::app()->session['add_lab']);
	}

	public function actionView_medical_image()
	{
		if ($_POST['id_customer'] && $_POST['id_mhg']) {
			echo json_encode(Customer::model()->getListName($_POST['id_customer'], $_POST['id_mhg']));
		}
	}

	public function actionGetPhotosForIdentityCard()
	{

		$data = PhotosForIdentityCard::model()->getPhotosForIdentityCard($_POST['id_customer']);

		echo json_encode($data);
	}

	public function actionUpload()
	{

		// 'images' refers to your file input name attribute
		if (empty($_FILES['kartik-input-700'])) {
			echo json_encode(array('error' => 'No files found for upload.'));
			// or you can throw an exception
			return; // terminate
		}

		// get the files posted
		$images = $_FILES['kartik-input-700'];

		// get user id posted
		$userid = empty($_POST['userid']) ? '' : $_POST['userid'];

		// get user name posted
		$username = empty($_POST['username']) ? '' : $_POST['username'];

		// a flag to see if everything is ok
		$success = null;

		// file paths to store
		$paths = array();

		// Settings

		// get file names
		$filenames = $images['name'];

		// loop and process files
		for ($i = 0; $i < count($filenames); $i++) {
			$ext = explode('.', basename($filenames[$i]));
			$target = "upload/customer/dental_status/" . $_POST['code_number'] . DIRECTORY_SEPARATOR . $filenames[$i];
			if (Yii::app()->s3->upload( $images['tmp_name'][$i] , $target)) {
				$success = true;
				$paths[] = $target;
			} else {
				$success = false;
				break;
			}
		}

		// check and process based on successful status
		if ($success === true) {
			// call the function to save all data to database
			// code for the following function `save_data` is not
			// mentioned in this example

			for ($i = 0; $i < count($filenames); $i++) {

				$model       = new Customer;

				$id_user     = yii::app()->user->getState('user_id');

				$data        = $model->addCsMedicalImage($filenames[$i], $id_user, $_POST['id_customer'], $filenames[$i], $_POST['id_mhg']);
			}

			// store a successful response (default at least an empty array). You
			// could return any additional response info you need to the plugin for
			// advanced implementations.
			$output = array();
			// for example you can get the list of files uploaded this way
			// $output = ['uploaded' => $paths];
		} elseif ($success === false) {
			$output = array('error' => 'Error while uploading images. Contact the system administrator');
			// delete any uploaded files
			foreach ($paths as $file) {
				unlink($file);
			}
		} else {
			$output = array('error' => 'No files were processed.');
		}

		// return a json encoded response for plugin to process successfully
		$output = array('id_customer' => $_POST['id_customer']);
		echo json_encode($output);
	}
	public function actionUploadBk()
	{

		// 'images' refers to your file input name attribute
		if (empty($_FILES['kartik-input-700'])) {
			echo json_encode(array('error' => 'No files found for upload.'));
			// or you can throw an exception
			return; // terminate
		}

		// get the files posted
		$images = $_FILES['kartik-input-700'];

		// get user id posted
		$userid = empty($_POST['userid']) ? '' : $_POST['userid'];

		// get user name posted
		$username = empty($_POST['username']) ? '' : $_POST['username'];

		// a flag to see if everything is ok
		$success = null;

		// file paths to store
		$paths = array();

		// Settings
		$targetDir = Yii::app()->basePath . '/../upload/customer/dental_status/' . $_POST['code_number'];

		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// get file names
		$filenames = $images['name'];

		// loop and process files
		for ($i = 0; $i < count($filenames); $i++) {
			$ext = explode('.', basename($filenames[$i]));
			//$target = "upload/customer/dental_status/" .$_POST['code_number'] . DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
			$target = "upload/customer/dental_status/" . $_POST['code_number'] . DIRECTORY_SEPARATOR . $filenames[$i];
			if (move_uploaded_file($images['tmp_name'][$i], $target)) {
				$success = true;
				$paths[] = $target;
			} else {
				$success = false;
				break;
			}
		}

		// check and process based on successful status
		if ($success === true) {
			// call the function to save all data to database
			// code for the following function `save_data` is not
			// mentioned in this example

			for ($i = 0; $i < count($filenames); $i++) {

				$model       = new Customer;

				$id_user     = yii::app()->user->getState('user_id');

				$data        = $model->addCsMedicalImage($filenames[$i], $id_user, $_POST['id_customer'], $filenames[$i], $_POST['id_mhg']);
			}

			// store a successful response (default at least an empty array). You
			// could return any additional response info you need to the plugin for
			// advanced implementations.
			$output = array();
			// for example you can get the list of files uploaded this way
			// $output = ['uploaded' => $paths];
		} elseif ($success === false) {
			$output = array('error' => 'Error while uploading images. Contact the system administrator');
			// delete any uploaded files
			foreach ($paths as $file) {
				unlink($file);
			}
		} else {
			$output = array('error' => 'No files were processed.');
		}

		// return a json encoded response for plugin to process successfully
		$output = array('id_customer' => $_POST['id_customer']);
		echo json_encode($output);
	}

	public function actionUploadPhotosForIdentityCard()
	{

		// 'images' refers to your file input name attribute
		if (empty($_FILES['kartik-input-777'])) {
			echo json_encode(array('error' => 'No files found for upload.'));
			// or you can throw an exception
			return; // terminate
		}

		// get the files posted
		$images = $_FILES['kartik-input-777'];

		// get user id posted
		$userid = empty($_POST['userid']) ? '' : $_POST['userid'];

		// get user name posted
		$username = empty($_POST['username']) ? '' : $_POST['username'];

		// a flag to see if everything is ok
		$success = null;

		// file paths to store
		$paths = array();

		// Settings
		$targetDir = Yii::app()->basePath . '/../upload/customer/photos_for_identity_card/' . $_POST['code_number'];

		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// get file names
		$filenames = $images['name'];

		// loop and process files
		for ($i = 0; $i < count($filenames); $i++) {
			$ext = explode('.', basename($filenames[$i]));
			//$target = "upload/customer/dental_status/" .$_POST['code_number'] . DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
			$target = "upload/customer/photos_for_identity_card/" . $_POST['code_number'] . DIRECTORY_SEPARATOR . $filenames[$i];
			if (move_uploaded_file($images['tmp_name'][$i], $target)) {
				$success = true;
				$paths[] = $target;
			} else {
				$success = false;
				break;
			}
		}

		// check and process based on successful status
		if ($success === true) {
			// call the function to save all data to database
			// code for the following function `save_data` is not
			// mentioned in this example

			for ($i = 0; $i < count($filenames); $i++) {

				$photos_for_identity_card = new PhotosForIdentityCard;

				$photos_for_identity_card->addNewPhotosForIdentityCard($_POST['id_customer'], $filenames[$i]);
			}

			// store a successful response (default at least an empty array). You
			// could return any additional response info you need to the plugin for
			// advanced implementations.
			$output = array();
			// for example you can get the list of files uploaded this way
			// $output = ['uploaded' => $paths];
		} elseif ($success === false) {
			$output = array('error' => 'Error while uploading images. Contact the system administrator');
			// delete any uploaded files
			foreach ($paths as $file) {
				unlink($file);
			}
		} else {
			$output = array('error' => 'No files were processed.');
		}

		// return a json encoded response for plugin to process successfully
		$output = array('id_customer' => $_POST['id_customer']);
		echo json_encode($output);
	}

	public function actionFileDelete()
	{

		if (empty($_POST['id'])) {
			echo json_encode(array('error' => 'No files found for delete.'));
			// or you can throw an exception
			return; // terminate
		}

		// a flag to see if everything is ok
		$success = null;
		$uri = 'upload/customer/dental_status/'.$_POST['code_number'].'/'.$_POST['name'];
		if (Yii::app()->s3->deleteObject($uri)) {
			$success = true;
		} else {
			$success = false;
		}

		// check and process based on successful status
		if ($success === true) {

			CsMedicalImage::model()->deleteByPk($_POST['id']);

			$output = array();
		} elseif ($success === false) {
			$output = array('error' => 'Error while deleting images. Contact the system administrator');
		} else {
			$output = array('error' => 'No files were processed.');
		}

		// return a json encoded response for plugin to process successfully
		echo json_encode($output);
	}

	public function actionDeletePhotosForIdentityCard()
	{

		if (empty($_POST['id'])) {
			echo json_encode(array('error' => 'No files found for delete.'));
			// or you can throw an exception
			return; // terminate
		}

		// a flag to see if everything is ok
		$success = null;

		if (unlink(Yii::app()->basePath . '/../upload/customer/photos_for_identity_card/' . $_POST['code_number'] . '/' . $_POST['name'])) {
			$success = true;
		} else {
			$success = false;
		}

		// check and process based on successful status
		if ($success === true) {

			PhotosForIdentityCard::model()->deleteByPk($_POST['id']);

			$output = array();
		} elseif ($success === false) {
			$output = array('error' => 'Error while deleting images. Contact the system administrator');
		} else {
			$output = array('error' => 'No files were processed.');
		}

		// return a json encoded response for plugin to process successfully
		echo json_encode($output);
	}

	public function actionSaveDentalStatusImage()
	{

		// Settings
		$targetDir = Yii::app()->basePath . '/../upload/customer/dental_status_image/' . $_POST['code_number'];

		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		$image = $_POST['image'];

		$name = $_POST['code_number'] . "-" . $_POST['id_mhg'];

		$filename = $targetDir . "/" . $name;

		$image = str_replace('data:image/png;base64,', '', $image);

		$decoded = base64_decode($image);

		if (file_exists($filename)) {
			@unlink($filename);
		}

		file_put_contents("upload/customer/dental_status_image/" . $_POST['code_number'] . "/" . $name . ".png", $decoded, LOCK_EX);
	}

	public function actionSearchCustomers()
	{
		$model 		   = new Customer;
		$cur_page      = isset($_POST['cur_page']) ? $_POST['cur_page'] : 1;
		$lpp           = 20;
		$search_params = '';

		if ($_POST['type'] == 0) {
			if (yii::app()->user->getState('group_id') == 3) {
				$orderBy = 'FIELD(status_schedule,6,3,2,1,5,4,0,-1,-2,7) ';
			} else {
				$orderBy = '`status_schedule` DESC ';
			}
		} elseif ($_POST['type'] == 1) {
			$orderBy = '`fullname` ASC ';
		} elseif ($_POST['type'] == 2) {
			$orderBy = '`code_number` DESC ';
		}

		if ($_POST['value']) {
			if (is_numeric($_POST['value'])) {
				$search_params = 'AND ( (`code_number` LIKE "%' . $_POST['value'] . '%" ) OR (`phone` LIKE "%' . $model->getVnPhone($_POST['value']) . '%" )  ) ';
			} else {
				if (strpos($_POST['value'], '/') !== false) {
					$search_params = 'AND ( (`birthdate` LIKE "%' . date("Y-m-d", strtotime(str_replace('/', '-', $_POST['value']))) . '%" ) ) ';
				} else {
					$D = array("d", "D");
					if (strpos($_POST['value'], 'd') || strpos($_POST['value'], 'D')) {
						$value = str_replace($D, "đ", $_POST['value']);
						$search_params = 'AND ( (`fullname` LIKE "%' . $_POST['value'] . '%" or `fullname` LIKE "%' . $value . '%") ) ';
					} else {
						$search_params = 'AND ( (`fullname` LIKE "%' . $_POST['value'] . '%" ) ) ';
					}
					//$search_params= 'AND ( (`fullname` LIKE "%'.$_POST['value'].'%" ) ) ';
				}
			}
		}

		if ($_POST['email']) {
			$search_params .= 'AND (`email` LIKE "%' . $_POST['email'] . '%" ) ';
		}

		if ($_POST['country']) {
			$search_params .= 'AND (`id_country` LIKE "%' . $_POST['country'] . '%" ) ';
		}

		if ($_POST['identity_card_number']) {
			$search_params .= 'AND (`identity_card_number` LIKE "%' . $_POST['identity_card_number'] . '%" ) ';
		}

		if ($_POST['source']) {
			$search_params .= 'AND (`id_source` LIKE "%' . $_POST['source'] . '%" ) ';
		}


		if ($_POST['segment']) {
			$listCustomerSegment = $model->getListCustomerByIdSegment($_POST['segment']);

			if (!empty($listCustomerSegment)) {
				$search_params .= 'AND ( ';

				foreach ($listCustomerSegment as $key => $value) {
					if ($key == 0) {
						$search_params .= ' (`code_number` LIKE "%' . $value['code_number'] . '%" ) ';
					} else {
						$search_params .= 'OR (`code_number` LIKE "%' . $value['code_number'] . '%" ) ';
					}
				}
				$search_params .= ') ';
			}
		}

		if (yii::app()->user->getState('group_id') == 3) {
			if (is_numeric($_POST['value'])) {
				$data  = $model->searchCustomers('', '', ' ' . $search_params . ' group by id order by ' . $orderBy, $lpp, $cur_page);
			} else {
				$and_conditions['id_dentist'] = yii::app()->user->getState('user_id');
				$data  = $model->searchVSchedules($and_conditions, '', ' ' . $search_params . ' group by id_customer order by ' . $orderBy, $lpp, $cur_page);
			}
		} else {
			$data  = $model->searchCustomers('', '', ' ' . $search_params . ' group by id order by ' . $orderBy, $lpp, $cur_page);
		}

		if ($cur_page > $data['paging']['cur_page']) {
			echo '<script>stopped = true; </script>';
			exit;
		}

		$this->renderPartial('search_sort', array('list_data' => $data, 'page' => $data['paging']['cur_page']));
	}

	public function actionSearchCustomersCall()
	{
		if (isset($_POST['phone']) && $_POST['phone']) {
			$data = Customer::model()->findAllByAttributes(array('phone' => $_POST['phone']));
			if ($data) {
				print_r($data[0]['id']);
			} else {
				echo "0";
			}
		}
	}
	public function actionAddnote()
	{
		$user = Yii::app()->user->getState('user_id');
		if (isset($_POST['chk_important'])) {
			$important = '1';
		} else {
			$important = '0';
		}
		if (isset($_POST['note'])) {
			$note_customer = CustomerNote::model()->addnote(array(
				'note' => $_POST['note'],
				'id_user' => '',
				'id_customer' => $_POST['id_cus'],
				'flag' => $_POST['phanloai'],
				'important' => $important,
				'status' => $_POST['status'],
			));
			$data = CustomerNote::model()->searchnote('', '', $_POST['id_cus'], ''); //CustomerNote::model()->findAllByAttributes(array('id_customer'=>$_POST['id_cus']));
			$this->renderPartial('search_note', array('data' => $data), false, true);
			exit();
		}
		echo "-1";
		exit();
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = Customer::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionSearchnote()
	{
		$data = CustomerNote::model()->searchnote(
			$_POST['status_search'],
			$_POST['phanloai_search'],
			$_POST['id'],
			$_POST['date']
		);
		$this->renderPartial('search_note', array('data' => $data), false, true);
	}
	public function actionEditnote()
	{
		$model = new CustomerNote;
		$id = $_POST['id'];

		$data = $model->findAllByAttributes(array('id' => $_POST['id']));

		$this->renderPartial('tab_update_note', array('data' => $data[0]), false, true);
	}
	public function actionUpdatenote()
	{
		$id = $_POST['id'];
		$id_user = Yii::app()->user->getState('user_id');
		$data =  CustomerNote::model()->findAllByAttributes(array('id' => $_POST['id']));
		$id_customer = $data[0]->id_customer;
		$date = date('Y-m-d H:i:s');
		/*if (isset($_POST['chk_important_edit'])) {
			$important_edit = '1';
		}
		else{
			$important_edit = '0';
		}*/
		CustomerNote::model()->updateByPk($id, array('note' => $_POST['note_edit'], 'id_user' => $id_user, 'important' => 0, 'status' => $_POST['status_edit'], 'flag' => $_POST['phanloai_edit'], 'conform_date' => $date));
		$view = CustomerNote::model()->searchnote('', '', $id_customer, '');
		$this->renderPartial('search_note', array('data' => $view), false, true);
		exit();
	}
	/*-----------------------------------------------------------------END-----------------------------------------------*/
	//chinh sua customermember
	public function actionInsertMember()
	{
		if (isset($_POST['id'])) {
			$result = new CustomerMember;
			$result = CustomerMember::model()->insertMember($_POST['id'], $_POST['id_customer'], $_POST['code_member'], $_POST['create_date']);
			echo $result;
		}
	}

	public function actionGetCustomerList_1()
	{
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$search = isset($_POST['q']) ? $_POST['q'] : '';

		$item = 30;

		$search_params = 'AND (`fullname` LIKE "%' . $search . '%" ) OR (`phone` LIKE "%' . $search . '%" ) OR (`code_number` LIKE "%' . $search . '%" )';

		$customerList = Customer::model()->searchCustomers('', '', ' ' . $search_params, $item, $page);
		if (!$customerList) {
			echo -1;
			exit();
		}
		foreach ($customerList['data'] as $key => $value) {
			$customer[] = array(
				'id' => $value['id'],
				'text' => $value['fullname'] . '-' . $value['code_number'],
			);
		}
		echo json_encode($customer);
	}
	//add  relation family
	public function actionAddRelationFamily()
	{

		if ($_POST['relation_family'] && $_POST['customer_relation'] && $_POST['id_customer']) {

			$result = CustomerRelationship::model()->addRelationFamily($_POST['id_customer'], $_POST['customer_relation'], $_POST['relation_family']);

			echo $result;
		}
	}
	//add  relation social
	public function actionAddRelationSocial()
	{
		if ($_POST['relation_social'] && $_POST['customer_relation_social'] && $_POST['id_customer']) {
			$result = CustomerRelationship::model()->addRelationSocial($_POST['id_customer'], $_POST['customer_relation_social'], $_POST['relation_social']);

			echo $result;
		}
	}
	public function actionDeleteRelationFamily()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : false;

		if (!$id) {
			echo 0;			// ko có mã
			exit;
		}

		$trans = Yii::app()->db->beginTransaction();
		try {
			$del = CustomerRelationship::model()->updateByPk($id, array('status' => -1));


			if ($del)
				echo 1;			// xóa thành công

			$trans->commit();
		} catch (Exception $e) {
			$trans->rollback();
			echo $e;			// error process
		}
	}
	public function actionDeleteRelationSocial()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : false;

		if (!$id) {
			echo 0;			// ko có mã
			exit;
		}

		$trans = Yii::app()->db->beginTransaction();
		try {
			$del = CustomerRelationSocial::model()->updateByPk($id, array('status' => -1));


			if ($del)
				echo 1;			// xóa thành công

			$trans->commit();
		} catch (Exception $e) {
			$trans->rollback();
			echo $e;			// error process
		}
	}

	public function actionFormOldBalance()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : false;

		if (!$id) {
			exit;
		}

		$createOld = 1;
		$author_name = '';

		// kiem tra khach hang co no cu ko?
		$oldBalanceCheck = VInvoice::model()->findByAttributes(array('id_customer' => $id, 'status' => 2));
		$customer 	= array($id => Customer::model()->findByPk($id)->fullname);

		// ko co hoa don no cu => tao moi
		if (!$oldBalanceCheck) {
			$oldBalance = new Invoice;
			$oldBalanceDetail = new InvoiceDetail;
		}
		// co hoa don cu => cap nhat
		else {
			$oldBalanceDetailCheck = VInvoiceDetail::model()->findByAttributes(array('id_invoice' => $oldBalanceCheck->id));
			$oldBalance = new Invoice;
			$oldBalanceDetail = new InvoiceDetail;

			$oldBalance->attributes = $oldBalanceCheck->attributes;
			$oldBalance->id = $oldBalanceCheck->id;
			$oldBalance->create_date = $oldBalanceCheck->create_date;

			$oldBalanceDetail->attributes = $oldBalanceDetailCheck->attributes;
			$oldBalanceDetail->id = $oldBalanceDetailCheck->id;

			$author_name = $oldBalanceCheck->author_name;
		}

		$this->renderPartial('_formOldBalance', array(
			'oldBalance' => $oldBalance, 'oldBalanceDetail' => $oldBalanceDetail,
			'customer' => $customer, 'createOld' => $createOld,
			'author_name' => $author_name,
		));
	}

	public function actionAddOldBalance()
	{
		if (isset($_POST['Invoice']) && isset($_POST['InvoiceDetail'])) {
			$oldBalance = new Invoice;
			$oldBalance->attributes = $_POST['Invoice'];

			$oldBalanceDetail = new InvoiceDetail;
			$oldBalanceDetail->attributes = $_POST['InvoiceDetail'];

			$oldBalance->status = 2;
			$oldBalance->sum_amount = $oldBalanceDetail->amount;
			$oldBalance->sum_no_vat = $oldBalanceDetail->amount;
			$oldBalance->balance 	= $oldBalanceDetail->amount;
			$oldBalance->code 		= $oldBalance->createCodeInvoice();

			if ($oldBalance->validate()) {
				$oldBalance->save();

				$oldBalanceDetail->id_invoice = $oldBalance->id;
				$oldBalanceDetail->id_author = $oldBalance->id_author;
				$oldBalanceDetail->id_user = $oldBalance->id_author;

				$oldBalanceDetail->save();

				echo 1;
				exit;
			}
		}
		echo 0;
	}

	public function actionUpdateOldBalance() {
		if (isset($_POST['Invoice']) && isset($_POST['InvoiceDetail'])) {
			$oldBalance = Invoice::model()->findByPk($_POST['Invoice']['id']);

			if (!$oldBalance) {
				echo -1;
				exit;
			}

			$oldBalanceDetail = InvoiceDetail::model()->findByPk($_POST['InvoiceDetail']['id']);

			$oldBalance->attributes = $_POST['Invoice'];
			$oldBalanceDetail->attributes = $_POST['InvoiceDetail'];

			$oldBalance->sum_amount = $_POST['InvoiceDetail']['amount'];
			$oldBalance->sum_no_vat = $_POST['InvoiceDetail']['amount'];
			$oldBalance->balance 	= $_POST['InvoiceDetail']['amount'];

			$oldBalance->save();
			$oldBalanceDetail->save();

			echo 1;
			exit;
		}
		echo 0;
	}

	public function actionLoadDoctorSalary()
	{

		$transaction_invoice = new TransactionInvoice();

		$listTransactionInvoice = $transaction_invoice->getListTransactionInvoiceOfCustomer($_POST['id_customer'], $_POST['id_invoice']);

		$this->renderPartial('tbody_doctor_salary', array('listTransactionInvoice' => $listTransactionInvoice));
	}

	public function actionDeleteTransactionInvoice()
	{
		$result = TransactionInvoice::model()->deleteTransactionInvoice($_POST['id']);
		echo json_encode($result);
	}

	public function actionUpdateTransactionInvoice()
	{
		$result = TransactionInvoice::model()->updateTransactionInvoiceOfCustomer(array('id' => $_POST['id'], 'id_service' => $_POST['id_service'], 'id_user' => $_POST['id_user'], 'percent' => $_POST['percent'], 'amount' => str_replace('.', '', $_POST['amount']), 'create_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['create_date']))), 'pay_date' => $_POST['pay_date'], 'debt' => $_POST['debt']));
		echo json_encode($result);
	}

	public function actionChangeIdService()
	{

		$result = TransactionInvoice::model()->changeIdService($_POST['id_service'], $_POST['id_user']);

		echo json_encode($result);
	}

	public function actionChangeIdUser()
	{

		$result = TransactionInvoice::model()->changeIdService($_POST['id_service'], $_POST['id_user']);

		echo json_encode($result);
	}

	//Thành Dey
	public function actionLoadServiceSelect()
	{
		$CsServiceTk = CsServiceTk::model()->findAll('st=:st and id_cs_service=:dd', array(':st' => 1, ':dd' => $_POST['add_id_service']));
		$CsServiceTk1 = $CsServiceTk && count($CsServiceTk) > 0 ? $CsServiceTk[0]['id_service_type_tk'] : 0;

		$CsPercentTk = CsPercentTk::model()->findAll('st=:st and id_service_type_tk=:dd and id_gp_users=:tt', array(':tt' => $_POST['add_id_user'], ':st' => 1, ':dd' => $CsServiceTk1));
		$percent = $CsPercentTk && count($CsPercentTk) > 0 ? $CsPercentTk[0]['percent'] : 0;

		echo $_POST['add_id_service'] . '|' . $_POST['add_id_service_price'] . '|' . $CsServiceTk1 . '|' . $percent;
		exit;
	}
	public function actionAddTransactionInvoice()
	{
		$TransactionInvoice = new TransactionInvoice();
		$TransactionInvoice->id_invoice = $_POST['add_id_invoice'];
		$TransactionInvoice->id_service = $_POST['add_id_service'];
		$CsService = CsService::model()->findAll('id=:st', array(':st' => $_POST['add_id_service']));
		$TransactionInvoice->description = $CsService[0]['name'];
		$TransactionInvoice->id_user = $_POST['add_id_user'];
		$TransactionInvoice->id_author = $_POST['add_id_author'];

		$TransactionInvoice->amount = $_POST['add_amount'];
		$TransactionInvoice->id_customer = $_POST['add_id_customer'];
		$TransactionInvoice->id_service_type_tk = $_POST['add_id_service_type_tk'];
		$TransactionInvoice->percent = $_POST['add_percent'];
		if ($_POST['add_pay_date'] != "") {
			$TransactionInvoice->pay_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['add_pay_date'])));
		}
		$TransactionInvoice->create_date = date('Y-m-d H:i:s');
		$TransactionInvoice->debt = $_POST['add_debt'];
		/*
		if($_POST['add_debt'] == 1){
			$TransactionInvoice->type = 0;
		}else{
			$TransactionInvoice->type = 1;
		}*/
		if ($TransactionInvoice->save()) {
			echo 1;
		} else {
			echo 0;
		}

		//echo json_encode($result);
	}


	//tab sản phẩm
	public function actionLoadTabProduct()
	{
		$model = new Customer();
		if (isset($_POST['id_customer']) && $_POST['id_customer']) {
			$model 	= $model->findByPk($_POST['id_customer']);
		}

		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 15;
		$order_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : '';
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$Order = VOrder::model()->searchOrder($page, $limit, '', '', $order_customer, '');
		$OrderList = $Order['data'];
		$count = $Order['count'];
		$OrderDetail = -1;
		$page_list = 0;

		if (!$OrderList) {
			$OrderList = -1;
		} else {
			$action = 'loadOrder';
			$param = "'$id','','','$order_customer',''";
			$page_list = VQuotations::model()->paging($page, $count, $limit, $action, $param);

			$first_id = end($OrderList)->id;
			$last_id = reset($OrderList)->id;
			$condition = " $first_id <= id_order AND id_order <= $last_id AND status >= 0";
			$OrderDetail = VOrderDetail::model()->searchOrderDetail($condition);
		}

		$this->renderPartial('tab_product', array('model' => $model, 'orderList' => $OrderList, 'orderDetail' => $OrderDetail, 'page_list' => $page_list,));
	}

	//tab hoa don
	public function actionLoadTabInvoice()
	{
		$id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : "";
		$page        = isset($_POST['page'])	?	$_POST['page']	: 1;
		$limit       = 5;

		$InvoiceList = -1;

		if (!$id_customer) {
			return array('st' => -1, 'ms' => "No customer id");
		} else {
			$Invoice = VInvoice::model()->searchInvoice($page, $limit, array('id_customer' => $id_customer));
			$InvoiceList = $Invoice['data'];
		}

		$this->renderPartial('tab_treatment_history', array(
			'listInvoice'	=> $InvoiceList,
			'numPage' => $Invoice['page'],
			'page' => $page,
		));
	}

	public function actionGetNewetSchedule()
	{
		$id_customer = (isset($_POST['id_customer'])) ? $_POST['id_customer'] : false;

		if (!$id_customer) {
			echo "";
			exit;
		}

		$schedule = CsSchedule::model()->getFutureScheduleOfCustomer($id_customer);
		$futureSchedule = CHtml::listData($schedule['data'], 'id', function ($val) {
			return date_format(date_create($val->start_time), 'H:i') . ' - ' . date_format(date_create($val->end_time), 'H:i d/m/Y');
		});

		echo json_encode($futureSchedule);
	}


	//*********** xóa toa thuốc *************//
	public function actionDeletePrescription()
	{
		$id_prescription = (isset($_POST['id_prescription'])) ? $_POST['id_prescription'] : '';
		if ($id_prescription) {
			Prescription::model()->deleteByPk($_POST['id_prescription']);
			DrugAndUsage::model()->deleteAllByAttributes(array('id_prescription' => $id_prescription));
		}

		$model = new Customer();
		if (isset($_POST['id_customer']) && $_POST['id_customer']) {
			$model     = $model->findByPk($_POST['id_customer']);
			$treatment = $model->checkTreatment($_POST['id_customer']);
		} else {
			$treatment = 0;
		}

		$this->renderPartial('medical_record', array(
			'model' => $model, 'treatment' => $treatment
		), false, false);
	}

	//*********** xóa labo *************//
	public function actionDeleteLabo()
	{
		$id_labo = (isset($_POST['id_labo'])) ? $_POST['id_labo'] : '';
		if ($id_labo) {
			Labo::model()->deleteByPk($_POST['id_labo']);
		}

		$model = new Customer();
		if (isset($_POST['id_customer']) && $_POST['id_customer']) {
			$model     = $model->findByPk($_POST['id_customer']);
			$treatment = $model->checkTreatment($_POST['id_customer']);
		} else {
			$treatment = 0;
		}

		$this->renderPartial('medical_record', array(
			'model' => $model, 'treatment' => $treatment
		), false, false);
	}
	public function actionLoadCounty()
	{
		$id = $_POST["id"];
		$city = $_POST["city"];
		$county = $_POST["county"];

		$Localtiondistrict = LocaltionDistrict::model()->findAllByAttributes(
			array("provinceID" => $city),
			array(
				'order' => 'districtDescriptionVn ASC',
			)
		);
		$this->renderPartial(
			'county',
			array(
				'Localtiondistrict' => $Localtiondistrict,
				'id' => $id,
				'county' => $county,
			)
		);
	}

	public function actionLoadTabStatistical() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : false;

		if (!$id_customer) { exit; }

		#region --- SUMMARY
		$sumAmount = Invoice::model()->getSumInvoice($id_customer);
		$sumPayAmount = Invoice::model()->getSumPayInvoice($id_customer);
		$sumPromotionAmount = Invoice::model()->getSumPromotionInvoice($id_customer);
		$sumRefundAmount = Invoice::model()->getSumRefundInvoice($id_customer);
		$sumDebtAmount = Invoice::model()->getSumDebtInvoice($id_customer);
		#endregion

		#region --- DATA
		$dataInvoice = Invoice::model()->StatisticalInvoice1($id_customer);
		$dataReceipt = Invoice::model()->getListReceiptInvoice($id_customer);
		#endregion

		$this->renderPartial('statistical', array(
			'sumAmount' => $sumAmount,
			'sumPayAmount' => $sumPayAmount,
			'sumPromotionAmount' => $sumPromotionAmount,
			'sumRefundAmount' => $sumRefundAmount,
			'sumDebtAmount' => $sumDebtAmount,

			'dataInvoice' => $dataInvoice,
			'dataReceipt' => $dataReceipt,
		));
	}

	#region --- UPDATE CUSTOMER REMAIN SCHEDULE
	public function actionUpdateScheduleRemind() {
		$data = isset($_POST) ? $_POST : false;

		if (!$data) {
			echo CJSON::encode(array('status' => 0, 'error-message' => 'Không có thông tin cập nhật!'));
			exit;
		}

		$remind = CustomerScheduleRemind::model()->updateRemind($data);
		echo CJSON::encode($remind);
	}
	#endregion
	public function actionUpdateCountryOther(){

		$id = (isset($_POST["id"])) ? $_POST["id"] : 0 ;
		$CountryOther = (isset($_POST["CountryOther"])) ? $_POST["CountryOther"] : "";

		$kq = Customer::model()->updateByPk($id,array("country_other"=>$CountryOther));
		if($kq){
			echo 0;
			return;
		}
		echo 1;
	}

	
}
