<?php

class StaffController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='/layouts/main_sup';

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

	public function actionView()
	{
		$this->render('view');
	}

	public function actionSearchListStaffs()
	{

		$model 		   = new GpUsers;
		$cur_page      = isset($_POST['cur_page'])?$_POST['cur_page']:1;
		$lpp           = 200;
		$search_params = '';
		$orderBy 	   = '`name` ASC ';

		if (Yii::app()->user->getState("group_id") != 1 && Yii::app()->user->getState("group_id") != 2 ) 
		{
			$search_params= ' AND (`id` = "'.Yii::app()->user->getState("user_id").'" )';
		}

		if (Yii::app()->user->getState("group_id") == 1 || Yii::app()->user->getState("group_id") == 2) {

			if ($_POST['type'] == 1 && $_POST['value']) 
			{
				$search_params= 'AND (`name` LIKE "%'.$_POST['value'].'%" )';
			}

			if ($_POST['type']== 4 && $_POST['value']) 
			{
				$search_params= 'AND (`code` LIKE "%'.$_POST['value'].'%" )';
				$orderBy = '`code` DESC ';
			}
			if ($_POST['group_id']==3) {
				$search_params.= 'AND (`id`='.$_POST["id_user"].')';
			}

			if ($_POST['type'] == 1) {

				$orderBy 	   = ' `name` ASC ';

			} elseif ($_POST['type'] == 2) {

				$orderBy = ' `id` DESC ';

			}

			if ($_POST['id_branch']) 
			{
				$search_params .= ' AND (`id_branch` LIKE "%'.$_POST['id_branch'].'%" ) ';
			}

			if ($_POST['id_group']) 
			{
				$search_params .= ' AND (`group_id` LIKE "%'.$_POST['id_group'].'%" ) ';
			}

			if ($_POST['book_onl'] >= 0) 
			{
				$search_params .= ' AND (`book_onl` LIKE "%'.$_POST['book_onl'].'%" ) ';
			}

			if ($_POST['block'] >= 0) 
			{
				$search_params .= ' AND (`block` LIKE "%'.$_POST['block'].'%" ) ';
			}

		}

		$data  = $model->searchStaffs('','',' '.$search_params.' order by '.$orderBy,$lpp,$cur_page);

		$this->renderPartial('search_list',array('list_data'=>$data));

	}

	public function actionDetailStaff()
	{
		if(isset($_POST['id']))
		{
			$model = GpUsers::model()->findByPk($_POST['id']);
			$group_user = GpGroup::model()->findAll();
			$data = CsScheduleChair::model()->findAllByAttributes(array('id_dentist'=>$_POST['id']));
			if(!$data)
			{
				$id_dentist = $_POST['id'];
				$start = "08:00:00";
				$end = "20:00:00";
				$id_branch = "1";
				CsScheduleChair::model()->insertNewStaff($id_dentist,$start,$end,$id_branch);
			}

			$data_time_break = CsScheduleRelax::model()->findAllByAttributes(array('id_dentist'=>$_POST['id']));
			if(!$data_time_break)
			{
				$id_dentist = $_POST['id'];
				$start = "12:00:00";
				$end = "13:30:00";
				$id_branch = "1";
				CsScheduleRelax::model()->insertNewStaff($id_dentist,$start,$end,$id_branch);
			}
			$data_time_off = CsSchedule::model()->findAll(array(
				'select' => '*',
				'condition' => "id_service = 0 AND lenght IS NULL AND active = 1 AND id_dentist = ". $_POST['id']
			));
			$working_list = CsScheduleChair::model()->findAllByAttributes(array('id_dentist'=>$_POST['id']),array('group'=>'dow'));

			$this->renderPartial('staff_information',array('group_user'=>$group_user,'time_off_list'=>$data_time_off,'model'=>$model,'working_list'=>$working_list,'id_dentist'=>$_POST['id']),false,false);
		}
	}
	public function actionGetListChair()
	{
		
		if(isset($_POST['chair']) && $_POST['chair'])
		{
			$id = $_POST['id'];
			$start = strtotime($_POST['start']);
			$end = strtotime($_POST['end']);

			$dow = $_POST['dow'];
			$branch = $_POST['branch'];
			$chair = $_POST['chair'];
			$dentist=$_POST['dentist'];
			$resulf = 0;
			//0 : ĐƯƠC phép đặt
			// 1 : KHÔNG cho phép đặt

			// lấy danh sách bác sĩ đã đặt này trong 1 ngày cùng 1 cơ sở
			$list_chair = CsScheduleChair::model()->get_chair($chair,$branch,$start,$end,$dow);
			// lấy số ghế của bác sĩ trong 1 ngày
			$list_chair_dentist = CsScheduleChair::model()->get_dentist($dentist,$dow);

			// kiêm tra : 1 ghế không cho phép 2 bác sĩ đặt

			if($list_chair && $chair !== "NULL")
			{
				foreach ($list_chair as $data) 
				{
					if ($data['id_dentist'] != $dentist) 
					{

						$time_start_db = strtotime($data['start']);
						$time_end_db = strtotime($data['end']);

						if( ($time_start_db < $start && $start < $time_end_db) || ($time_start_db < $end && $end < $time_end_db) || ($time_start_db >= $start && $time_end_db <= $end) )
						{
								$resulf = 1;
								$dataresulf = GpUsers::model()->findByPk($data['id_dentist']);
								print_r($dataresulf['name']);
								exit(); //ghế này đã được đặt
						}
					}
				}
				if($resulf==0)
				{
					CsScheduleChair::model()->updateChair($id,$_POST['chair']);
					print_r($resulf);
				}
			}
			else 
			{
				CsScheduleChair::model()->updateChair($id,$_POST['chair']);
				print_r($resulf);
			}
		}
		
		
	}
	public function actionUpdateBranch()
	{
		// echo ($_POST['id']);
		if(isset($_POST['value']) && $_POST['value'])
		{
			$id = $_POST['id'];
			CsScheduleChair::model()->updateBranch($id,$_POST['value']);
			$list_chair = Chair::model()->findAllByAttributes(array('id_branch'=>$_POST['value']));
			$list_option ="";
			$list_option.='<option value="">Chọn</option>';
			foreach ($list_chair as $value) {
				$list_option.='<option value='.$value['id'].'>'.$value['name'].'</option>';
			}
			echo $list_option;
		}
	}
	public function actionAddNewTime()
	{
		if(isset($_POST['id_dentist']) && $_POST['id_dentist'])
		{   
			$count_record = count(CsScheduleChair::model()->findAllByAttributes(array('id_dentist'=>$_POST['id_dentist'],'dow'=>$_POST['dow'])));
			
			$count_record+=1;

			$id_dentist = $_POST['id_dentist'];
			$dow = $_POST['dow'];
			$time_start = $_POST['time_start'];
			$time_end = $_POST['time_end'];
			$branch = $_POST['branch'];

			$record_new = CsScheduleChair::model()->insertNewTime($id_dentist,$dow,$time_start,$time_end,$branch);
			CsSchedule::model()->TimeJson();
			$this->renderPartial('view_add_new',array('record'=>$record_new,'count_record'=>$count_record));
		}	
	}
	public function actionDeleteTime()
	{
		if(isset($_POST['id']) && $_POST['id'])
		{
			CsScheduleChair::model()->deleteTime($_POST['id']);
			CsSchedule::model()->TimeJson();
		}
	}
	public function actionChangeStatus()
	{
		if(isset($_POST['id_dentist']) && $_POST['id_dentist'])
		{
			CsScheduleChair::model()->updateStatus($_POST['status'],$_POST['id_dentist'],$_POST['dow']);
			CsScheduleRelax::model()->updateStatus($_POST['status'],$_POST['id_dentist'],$_POST['dow']);
			CsSchedule::model()->TimeJson();

		}
	}
	public function actionChangeTimeStart()
	{
		if(isset($_POST['time_start']) && $_POST['time_start'])
		{
			$id = $_POST['id_start'];

			$start = strtotime($_POST['time_start']);
			$end = strtotime($_POST['time_end']);
			$dow = $_POST['dow'];
			$branch = $_POST['branch'];
			$chair = $_POST['chair'];
			$dentist=$_POST['dentist'];
			$resulf = 0;
			// lấy danh sách bác sĩ đã đặt này trong 1 ngày cùng 1 cơ sở
			$list_chair = CsScheduleChair::model()->get_chair($chair,$branch,$start,$end,$dow);
			if($list_chair  && $chair !== "NULL") // nếu đã có Bác Sĩ đặt
			{
				foreach ($list_chair as $item) 
				{
					if ($item['id_dentist'] != $dentist) 
					{
						$time_start_db = strtotime($item['start']);
						$time_end_db = strtotime($item['end']);
						if(($time_start_db < $start && $start < $time_end_db) || ($time_start_db < $end && $end < $time_end_db) || ($time_start_db >= $start && $time_end_db <= $end) ){
							$dataresulf = GpUsers::model()->findByPk($item['id_dentist']);
							echo "Thời gian không hợp lệ !".$dataresulf['name']." đã đặt ghế này!";
							exit(); //ghế này đã được đặt
						}
					}
				}
				$update_time =  CsScheduleChair::model()->updateTimeStart($id,$_POST['time_start']);
				CsSchedule::model()->TimeJson();
				if($update_time) echo 'Cập nhật thời gian thành công !'; 
			}
			else { // nếu chưa có Bác sĩ nào đặt
				$update_time =  CsScheduleChair::model()->updateTimeStart($id,$_POST['time_start']);
				CsSchedule::model()->TimeJson();
				if($update_time) echo 'Cập nhật thời gian thành công !'; 
			}
			
		}
	}
	public function actionChangeTimeEnd()
	{
		if(isset($_POST['time_end_end']) && $_POST['time_end_end'])
		{
			$id = $_POST['id_end'];
			$start = strtotime($_POST['time_start_end']);
			$end = strtotime($_POST['time_end_end']);
			$dow = $_POST['dow'];
			$branch = $_POST['branch'];
			$chair = $_POST['chair'];
			$dentist=$_POST['dentist'];

			$resulf = 0;
			$list_chair = CsScheduleChair::model()->get_chair($chair,$branch,$start,$end,$dow);

			if($list_chair  && $chair !== "NULL")
			{
				foreach ($list_chair as $item) 
				{
					if ($item['id_dentist'] != $dentist) 
					{
						$time_start_db = strtotime($item['start']);
						$time_end_db = strtotime($item['end']);
						if( ($time_start_db < $start && $start < $time_end_db) || ($time_start_db < $end && $end < $time_end_db) || ($time_start_db >= $start && $time_end_db <= $end) ){
							$dataresulf = GpUsers::model()->findByPk($item['id_dentist']);
							echo "Thời gian không hợp lệ !".$dataresulf['name']." đã đặt ghế này!";
							exit(); //ghế này đã được đặt
						}
					}
				}
				
				$updata_time = CsScheduleChair::model()->updateTimeEnd($id,$_POST['time_end_end']);
				CsSchedule::model()->TimeJson();
				if($updata_time) echo 'Cập nhật thời gian thành công !';
			}
			else
			{
				$updata_time = CsScheduleChair::model()->updateTimeEnd($id,$_POST['time_end_end']);
				CsSchedule::model()->TimeJson();
				if($updata_time) echo 'Cập nhật thời gian thành công !';
			}
		}
	}
	public function actionAddNewBreak()
	{
		if(isset($_POST['id_dentist']) && $_POST['id_dentist'])
		{
			$id_dentist = $_POST['id_dentist'];
			$dow = $_POST['dow'];
			$id_branch = "1";
			$time_start= $_POST['time_start'];
			$time_end = $_POST['time_end'];

			$test_before_insert = CsScheduleChair::model()->findAllByAttributes(array('id_dentist'=>$id_dentist,'dow'=>$dow));
			$record_relax_cur = CsScheduleRelax::model()->findAllByAttributes(array('id_dentist'=>$id_dentist,'dow'=>$dow));
			if(count($test_before_insert) == 1)
			{
				if($record_relax_cur)
				{
					$resulf = 1;
					print_r($resulf);
				}
				else
				{
					$relax_record = CsScheduleRelax::model()->insertTimeRelax($id_dentist,$id_branch,$dow,$time_start,$time_end);
					$this->renderPartial('view_add_relax',array('relax_record'=>$relax_record));
				}
			}
			else {
				$resulf = 1;
				print_r($resulf);
			}
		}
	}
	public function actionRemoveTimeRelax()
	{
		if(isset($_POST['id']) && $_POST['id'])
		{
			$command = Yii::app()->db->createCommand();
			$command->delete('cs_schedule_relax', 'id=:id', array(':id'=>$_POST['id']));
			print_r("Success !");
		}
	}

	public function actionAddTimeOff()
	{
		if(isset($_POST['id_dentist']) && $_POST['id_dentist'])
		{
			$start_date    = $_POST['start_date'];
			$end_date      = $_POST['end_date'];
			$note_time_off = $_POST['note_time_off'];
			$id_dentist    = $_POST['id_dentist'];
			$group_id      = $_POST['group_id'];
			$id_author     = Yii::app()->user->getState("user_id");

			$check = CsSchedule::model()->checkScheduleEvent($start_date,$end_date,$id_dentist,0);

			if(!$check){
				echo 0;
				exit;
			}

		    $timeoff = CsSchedule::model()->addNewSchedule(array(
				'id_dentist' => $id_dentist, 
				'id_author'  => $id_author, 
				'id_branch'  => '', 
				'id_chair'   => '0', 
				'id_service' => '0',
				'start_time' => $start_date, 
				'end_time'   => $end_date, 
				'status'     => '0',
				'source'     => 0 ,
				'active'     => '1', 
				'note'       => $note_time_off
		    ));

		    if($timeoff == 0)
		    {
		    	echo "-1";
		    	exit;
		    }

		    if($group_id == 3){
		    	$soap = new SoapService();
				$soap->webservice_server_ws("getAddNewNotiSchedule",array('1','317db7dbff3c4e6ec4bdd092f3b220a8',$id_author,$id_dentist,$timeoff['id'],'add'));
		    }

		    $this->renderPartial('view_add_time_off',array('record_time_off'=>$timeoff['data']));
		}
	}

	public function actionUpdateTimeOff()
	{
		$id_time_off = isset($_POST['id']) ? $_POST['id'] : false;
		$id_dentist  = isset($_POST['id_dentist']) ? $_POST['id_dentist'] : false;

		if(!$id_time_off || !$id_dentist){
			echo -1;
			exit;
		}

		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : false;
		$end_date   = isset($_POST['end_date']) ? $_POST['end_date'] : false;
		$note       = isset($_POST['note_time_off']) ? $_POST['note_time_off'] : false;
		$group_id       = isset($_POST['group_id']) ? $_POST['group_id'] : false;
		$id_author     = Yii::app()->user->getState("user_id");

		$check = CsSchedule::model()->checkScheduleEvent($start_date,$end_date,$id_dentist,$id_time_off);

		if(!$check){
			echo 0;
			exit;
		}

		$upTimeOff = CsSchedule::model()->updateSchedule(array(
			'id'         =>$id_time_off,
			'id_dentist' =>$id_dentist,
			'start_time' =>$start_date,
			'end_time'   =>$end_date,
			'note'       =>$note
		));

		if($upTimeOff == 0) {
	    	echo "-1";
	    	exit;
	    }

	    if($group_id == 3){
	    	$soap = new SoapService();
			$soap->webservice_server_ws("getAddNewNotiSchedule",array('1','317db7dbff3c4e6ec4bdd092f3b220a8',$id_author,$id_dentist,$upTimeOff['id'],'update'));
	    }

	    $this->renderPartial('view_add_time_off',array('record_time_off'=>$upTimeOff['data']));
	}

	public function actionShowUpdate()
	{
		if(isset($_POST['id']) && $_POST['id'])
		{
			$data_time_off_record = CsScheduleTimeOff::model()->findAllByAttributes(array('id_dentist'=>$_POST['id']));
			$this->renderPartial('staff_information',array('data_time_off_record'=>$data_time_off_record));
		}
	}
	public function actionDeleteTimeOff()
	{
		if(isset($_POST['id']) && $_POST['id'])
		{
			$data = CsSchedule::model()->updateSchedule(array(
				'id'     =>$_POST['id'],
				'active' => -2
			));
			if($data != 0) {
				$group_id       = isset($_POST['group_id']) ? $_POST['group_id'] : false;
				$id_author     = Yii::app()->user->getState("user_id");
				$id_dentist  = isset($_POST['id_dentist']) ? $_POST['id_dentist'] : false;

				if($group_id == 3){
			    	$soap = new SoapService();
					$soap->webservice_server_ws("getAddNewNotiSchedule",array('1','317db7dbff3c4e6ec4bdd092f3b220a8',$id_author,$id_dentist,$_POST['id'],'update'));
			    }

			 	print_r("Success !"); 
			}
		}
	}
	public function actionUpdateServiceUsers()
	{
		if(isset($_POST))
		{

			$co 			=true;
			$id_dentist 	= $_POST['id_dentist'];	
			$name_user 		= $_POST['name_user'];
			$username 		= $_POST['username'];
			$password 		= $_POST['confirm_pass'];
			$email 			= $_POST['email'];
			$branch 		= $_POST['branch_user'];
			$group_user 	= $_POST['group_user'];
			$block 			= $_POST['block_user'];
			$code 			= $_POST['code'];

		
			if (isset($_POST['list_service'])) {
				$list_service_user = $_POST['list_service'];
			}else{
				$list_service_user="";
			}

			$exp 			= $_POST['staff_exp'];
			$diploma 		= $_POST['staff_diploma'];
			$certificate 	= $_POST['staff_certificate'];
			$hinh 			= $_FILES["staffimageinput"]["error"]==0?$_FILES["staffimageinput"]["name"]:"";

			$data 			= GpUsers::model()->findByPk($id_dentist);

			// $hinh_user = $_POST['hinh_user_name'];
			if($hinh == "")
			{
				$co = false;
			}
			if($co)
			{
				if($data['image'] == "")
				{
					$fileImageUpload = $_FILES["staffimageinput"]["tmp_name"];

					$fileTypeUpload  = explode('/',$_FILES['staffimageinput']["type"]);

					$imageNameUpload       = date("dmYHis").'.'.$fileTypeUpload[1];
					$imageUploadSource     = Yii::getPathOfAlias('webroot').'/upload/users/'; 

					$resultImage =  GpUsers::model()->saveImageScaleAndCrop($fileImageUpload,500,500,$imageUploadSource,$imageNameUpload);
				}
				else 
				{
					$fileImageUpload = $_FILES["staffimageinput"]["tmp_name"];

					$fileTypeUpload  = explode('/',$_FILES['staffimageinput']["type"]);

					$imageNameUpload       = date("dmYHis").'.'.$fileTypeUpload[1];
					$imageUploadSource     = Yii::getPathOfAlias('webroot').'/upload/users/'; 

					$resultImage =  GpUsers::model()->saveImageScaleAndCrop($fileImageUpload,500,500,$imageUploadSource,$imageNameUpload);

					GpUsers::model()->deleteImageScaleAndCrop($data['image']);
				}
				GpUsers::model()->updateImgUpload($id_dentist,$imageNameUpload);

			}

			// Cập nhật danh sach dịch vụ của bs
			if($list_service_user)
			{
				
				$command = Yii::app()->db->createCommand();
				$command->delete('cs_service_users', 'id_dentist=:id_dentist', array(':id_dentist'=>$_POST['id_dentist']));
				for ($i=0; $i < count($list_service_user) ; $i++) 
				{ 
					$command->insert('cs_service_users',array(
							'id_dentist'=>$_POST['id_dentist'],
							'id_service'=>$list_service_user[$i],
							)
						);
				}
			}else{
				$command = Yii::app()->db->createCommand();
				$command->delete('cs_service_users', 'id_dentist=:id_dentist', array(':id_dentist'=>$_POST['id_dentist']));
				// CsServiceUsers::model()->deleteServiceUser($id_dentist);
			}


			$reponse = GpUsers::model()->updateUserFull($name_user,$username,$password,$email,$branch,$group_user,$block,$exp,$diploma,$certificate,$id_dentist,$code,$data);
			if($reponse){
				echo "Success !";exit;
			}
			echo "Error !";exit;
		}
		else {
			echo "Error !";
		}
	}

	public function actionTestPassOld()
	{
		if(isset($_POST['pass_old']) && $_POST['pass_old'])
		{
			$data = GpUsers::model()->findByPk($_POST['id_dentist']);
			$pass_old = md5($_POST['pass_old']);
			if($data['password'] == $pass_old)
			{
				$result = 1;	
			}
			else
			{
				$result = 0;
				
			}
			print_r($result);
		}
	}

	//add user goal
	public function actionAddGoal()
	{ 	
		if($_POST['year'] && $_POST['month'] && $_POST['user_id'] && $_POST['revenue_target']&& $_POST['new_account_target'] && $_POST['appointment_target']&& $_POST['worktime_target']&&$_POST['check_td'])
		{		
			$result = CsTarget::model()->addGoal($_POST['year'],$_POST['month'],$_POST['user_id'],$_POST['revenue_target'], $_POST['new_account_target'],$_POST['appointment_target'],$_POST['worktime_target'],$_POST['check_td']);
			echo $result;
			
		} 

	}

	public function actionEditGoal(){
		$model = new CsTarget;
		$id = $_POST['id'];	
		$data = $model->findByAttributes(array('id'=>$_POST['id']));
		$this->renderPartial('update_goal',array('data'=>$data));
	}

	public function actionUpdateGoal()
	{ 	
		if(isset($_POST['id_goal']))
		{	$result = new CsTarget;	
			$result = CsTarget::model()->updateGoal($_POST['id_goal'],$_POST['month'],$_POST['revenue_target'], $_POST['new_account_target'],$_POST['appointment_target'],$_POST['worktime_target']);
			print_r( $result);
			
		} 

	}

	public function actionAddNewStaff()
	{ 	

		if($_POST['staffNewName'] && $_POST['staffNewAccount'] && $_POST['staffNewPassword'] && $_POST['staffNewGroupId']) {

			$result = GpUsers::model()->addNewStaff($_POST['staffNewName'],$_POST['staffNewAccount'],$_POST['staffNewPassword'],$_POST['staffNewGroupId']);
			
			echo $result;

		}	

	}

	public function actionDeleteStaff()
	{		
		$result=GpUsers::model()->deleteByPk($_POST['id']);	
		echo $result;
		exit;
	}

	public function actionUpdateStaffName()
	{
		$staff=GpUsers::model()->findByPk($_POST['id_staff']);	
		$staff->name=$_POST['staffName'];					
		$staff->update();	
		echo 1;
		exit;
			
	}

	public function actionLoadDoctorSalary()
	{

		$transaction_invoice = new TransactionInvoice();

  		$listTransactionInvoice = $transaction_invoice->getListTransactionInvoice($_POST['id_user']);

		$this->renderPartial('tbody_doctor_salary',array('listTransactionInvoice'=>$listTransactionInvoice));
			
	}

	public function actionDeleteTransactionInvoice()
	{			
		
		$result = TransactionInvoice::model()->deleteTransactionInvoice($_POST['id']);	

			
		echo json_encode($result);			
			
	}

	public function actionUpdateTransactionInvoice(){	
		$result = TransactionInvoice::model()->updateTransactionInvoice(array('id' => $_POST['id'], 'id_service' => $_POST['id_service'], 'id_customer' => $_POST['id_customer'], 'percent' => $_POST['percent'], 'amount' => str_replace('.','',$_POST['amount']), 'create_date' => date('Y-m-d H:i:s',strtotime(str_replace('/', '-',$_POST['create_date']))), 'pay_date' => date('Y-m-d H:i:s',strtotime(str_replace('/', '-',$_POST['pay_date']))), 'debt' => $_POST['debt']));			
		echo json_encode($result);
			
	} 
	public function actionAddTransactionInvoice(){	
		$TransactionInvoice = new TransactionInvoice();
		$TransactionInvoice->id_invoice = $_POST['add_id_invoice'];
		$TransactionInvoice->id_service = $_POST['add_id_service'];
		$CsService = CsService::model()->findAll('id=:st',array(':st'=>$_POST['add_id_service']));
		$TransactionInvoice->description = $CsService[0]['name'];
		$TransactionInvoice->id_user = $_POST['add_id_user'];
		$TransactionInvoice->id_author = $_POST['add_id_author'];
		
		$TransactionInvoice->amount = $_POST['add_amount'];
		$TransactionInvoice->id_customer = $_POST['add_id_customer'];
		$TransactionInvoice->id_service_type_tk = $_POST['add_id_service_type_tk'];
		$TransactionInvoice->percent = $_POST['add_percent'];
		if($_POST['add_pay_date'] != ""){
			$TransactionInvoice->pay_date = $_POST['add_pay_date'];
		}
		$TransactionInvoice->create_date = date('Y-m-d H:i:s');
		$TransactionInvoice->debt = $_POST['add_debt'];
		if($_POST['add_debt'] == 1){ 
			$TransactionInvoice->type = 0;
		}else{
			$TransactionInvoice->type = 1;
		}
		if($TransactionInvoice->save()){
			echo 1;
		}else{ 
			echo 0;
		}
		
		//echo json_encode($result);	
	}

}
