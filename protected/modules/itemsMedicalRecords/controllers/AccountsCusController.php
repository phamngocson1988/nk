<?php
class AccountsCusController extends Controller
{

	public $layout='/layouts/main_cus';
	public function filters()
	{
		return array(
		'accessControl', // perform access control for CRUD operations
	);
	}
	public function accessRules()
	{
		return parent::accessRules();
	}

	public function actionAdmin() {
		$model       = new Customer();
		$code_number = '';
		if(isset($_GET['code_number'])){
			$code_number = $_GET['code_number'];
			$model = Customer::model()->findByAttributes(array('code_number'=>$code_number));
		}
		$this->render('admin', array('model'  => $model));
	}

	#region --- LOAD TAB BENH AN
	public function actionLoadMedicalRecords() {
		$model = new Customer();
		if (isset($_POST['id_customer']) && $_POST['id_customer']) {
			$model = $model->findByPk($_POST['id_customer']);
			$treatment = $model->checkTreatment($_POST['id_customer']);
			if (!$treatment) {
				//kiểm tra có đợt điều trị hay chưa ?. nếu chưa có thì tạo mới
				$data = Customer::model()->addTreatment($_POST['id_customer']);
				if ($data) {
					$treatment = $model->checkTreatment($_POST['id_customer']);
				}
			}
		} else {
			$treatment = 0;
		}

		$this->renderPartial('tab_medical_record', array('model' => $model, 'treatment' => $treatment));
	}
	#endregion


	public function actionDetailTreatment(){
		if(isset($_POST['id']) && isset($_POST['id_customer']))
		{
			$model = Customer::model()->findByPk($_POST['id_customer']);
			$treatment= CsMedicalHistoryGroup::model()->findByPk($_POST['id']);
			$this->renderPartial('tab_medical_record',array('model'=>$model,'treatment'=>$treatment));
		}
	}

	public function actionUpdateTreatment(){

		if( isset($_POST['id']) && isset($_POST['id_customer']) )
		{
			$model = Customer::model()->findByPk($_POST['id_customer']);
			$treatment= CsMedicalHistoryGroup::model()->findByPk($_POST['id']);
			$data=Customer::model()->updateTreatment($_POST['id']);
			if ($data==1) {
				$this->renderPartial('tab_medical_record',array(
					'model'=>$model,'treatment'=>$treatment
				),false,true);
			}
		}
	}
	public function actionAddNewTreatment(){

		if( isset($_POST['id_customer']) )
		{
			$model = Customer::model()->findByPk($_POST['id_customer']);
			$data=$model->addTreatment($_POST['id_customer']);
			$treatment= $model->checkTreatment($_POST['id_customer']);
			$this->renderPartial('tab_medical_record',array('model'=>$model,'treatment'=>$treatment));
		}
	}

	public function actionView_medical_image(){
		if($_POST['id_customer'] && $_POST['id_mhg']){
			echo json_encode(Customer::model()->getListName($_POST['id_customer'],$_POST['id_mhg']));
		}
	}
	public function actionUpload(){
		if (empty($_FILES['kartik-upload-film'])) {
			echo json_encode(array('error'=>'No files found for upload.'));
			return;
		}
		$images = $_FILES['kartik-upload-film'];
		$userid = empty($_POST['userid']) ? '' : $_POST['userid'];
		$username = empty($_POST['username']) ? '' : $_POST['username'];
		$success = null;
		$paths= array();
		$filenames = $images['name'];
		for($i=0; $i < count($filenames); $i++){
			$ext = explode('.', basename($filenames[$i]));
			$target = "upload/customer/dental_status/" .$_POST['code_number'] . DIRECTORY_SEPARATOR . $filenames[$i];
			if (Yii::app()->s3->upload( $images['tmp_name'][$i] , $target)) {
				$success = true;
				$paths[] = $target;
			} else {
				$success = false;
				break;
			}
		}
		if ($success === true) {
			for($i=0; $i < count($filenames); $i++){
				$model       = new Customer;
				$id_user     = yii::app()->user->getState('user_id');
				$data        = $model->addCsMedicalImage($filenames[$i],$id_user,$_POST['id_customer'],$filenames[$i],$_POST['id_mhg']);
			}
			$output = array();
		} elseif ($success === false) {
			$output = array('error'=>'Error while uploading images. Contact the system administrator');
			foreach ($paths as $file) {
				unlink($file);
			}
		} else {
			$output = array('error'=>'No files were processed.');
		}
		$output = array('id_customer'=>$_POST['id_customer']);
		echo json_encode($output);

	}
	public function actionUploadBk(){
		if (empty($_FILES['kartik-upload-film'])) {
			echo json_encode(array('error'=>'No files found for upload.'));
			return;
		}
		$images = $_FILES['kartik-upload-film'];
		$userid = empty($_POST['userid']) ? '' : $_POST['userid'];
		$username = empty($_POST['username']) ? '' : $_POST['username'];
		$success = null;
		$paths= array();
		$targetDir = Yii::app()->basePath.'/../upload/customer/dental_status/'.$_POST['code_number'];
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}
		$filenames = $images['name'];
		for($i=0; $i < count($filenames); $i++){
			$ext = explode('.', basename($filenames[$i]));
			$target = "upload/customer/dental_status/" .$_POST['code_number'] . DIRECTORY_SEPARATOR . $filenames[$i];
			if(move_uploaded_file($images['tmp_name'][$i], $target)) {
				$success = true;
				$paths[] = $target;
			} else {
				$success = false;
				break;
			}
		}
		if ($success === true) {
			for($i=0; $i < count($filenames); $i++){
				$model       = new Customer;
				$id_user     = yii::app()->user->getState('user_id');
				$data        = $model->addCsMedicalImage($filenames[$i],$id_user,$_POST['id_customer'],$filenames[$i],$_POST['id_mhg']);
			}
			$output = array();
		} elseif ($success === false) {
			$output = array('error'=>'Error while uploading images. Contact the system administrator');
			foreach ($paths as $file) {
				unlink($file);
			}
		} else {
			$output = array('error'=>'No files were processed.');
		}
		$output = array('id_customer'=>$_POST['id_customer']);
		echo json_encode($output);

	}
	public function actionFileDeleteBk(){

		if (empty($_POST['id'])) {
			echo json_encode(array('error'=>'No files found for delete.'));
			return;
		}

		$success = null;
		
		if (unlink(Yii::app()->basePath.'/../upload/customer/dental_status/'.$_POST['code_number'].'/'.$_POST['name'])) {
			$success = true;
		} else {
			$success = false;
		}
		if ($success === true) {
			CsMedicalImage::model()->deleteByPk($_POST['id']);
			$output = array();
		} elseif ($success === false) {
			$output = array('error'=>'Error while deleting images. Contact the system administrator');
		} else {
			$output = array('error'=>'No files were processed.');
		}
		echo json_encode($output);

	}
	public function actionFileDelete(){

		if (empty($_POST['id'])) {
			echo json_encode(array('error'=>'No files found for delete.'));
			return;
		}

		$success = null;
		$uri = 'upload/customer/dental_status/'.$_POST['code_number'].'/'.$_POST['name'];
		if (Yii::app()->s3->deleteObject($uri)) {
			$success = true;
		} else {
			$success = false;
		}
		if ($success === true) {
			CsMedicalImage::model()->deleteByPk($_POST['id']);
			$output = array();
		} elseif ($success === false) {
			$output = array('error'=>'Error while deleting images. Contact the system administrator');
		} else {
			$output = array('error'=>'No files were processed.');
		}
		echo json_encode($output);

	}

	public function actionAddDentalStatus(){

		if( isset($_POST['id_customer']) && isset($_POST['id_mhg']) ){
			$result = ToothData::model()->saveToothNew($_POST['id_customer'], $_POST['id_mhg'], json_decode($_POST['tooth_data']), json_decode($_POST['tooth_image']), json_decode($_POST['tooth_conclude']),json_decode($_POST['assign_tooth']));

			$model = Customer::model()->findByPk($_POST['id_customer']);
			$treatment= CsMedicalHistoryGroup::model()->findByPk($_POST['id_mhg']);
			$this->renderPartial('tab_medical_record',array(
				'model'=>$model,'treatment'=>$treatment
			),false,true);

		}
	}

	public function actionGetListInvoiceAndTreatment(){
		$id_customer 			= isset($_POST['id_customer'])?$_POST['id_customer']:"";
		$id_mhg 				= isset($_POST['id_mhg'])?$_POST['id_mhg']:"";
		$search_tooth 			= isset($_POST['search_tooth'])?$_POST['search_tooth']:"";
		$search_code_service 	= isset($_POST['search_code_service'])?$_POST['search_code_service']:"";
		$data   = Customer::model()->getListInvoiceAndTreatment($id_mhg,$id_customer,$search_tooth,$search_code_service);

		if($data){
			// Just allow admin to cancel a paid invoice
			$isAdmin = Yii::app()->user->getState('isAdmin') || Yii::app()->user->getState('isSuperAdmin');
			$invoiceIds = array_map(function($invoice){
				return isset($invoice['id_invoice']) ? $invoice['id_invoice'] : null;
			}, $data);
			$invoiceIds = array_filter($invoiceIds);
			$invoiceIds = array_unique($invoiceIds);
			$allowCancel = [];
			if (!$isAdmin) {
				$invoices = Invoice::model()->findAllByPk($invoiceIds);
				foreach($invoices as $invoice) {
					$allowCancel[$invoice->id] = !$invoice->confirm; // paid invoice
				}
			} else {
				foreach($invoiceIds as $invoiceId) {
					$allowCancel[$invoiceId] = true;
				}
			}

			$this->renderPartial('ListInvoiceAndTreatment',array('data'=>$data, 'allowCancel' => $allowCancel));
			exit;
		}else{
			echo -1;
			exit;
		}

	}

	public function actionGetListInvoiceAndTreatmentAll(){
		$id_customer 			= isset($_POST['id_customer'])?$_POST['id_customer']:"";
		$id_mhg 				= isset($_POST['id_mhg'])?$_POST['id_mhg']:"";
		$search_tooth 			= isset($_POST['search_tooth'])?$_POST['search_tooth']:"";
		$search_code_service 	= isset($_POST['search_code_service'])?$_POST['search_code_service']:"";
		$data   = Customer::model()->getListInvoiceAndTreatmentAll($id_mhg,$id_customer,$search_tooth,$search_code_service);
		$this->renderPartial('ListInvoiceAndTreatmentAll',array('data'=>$data));
		exit;
	}

	public function actionExportTreatmentRecords(){
		if($_GET['id_customer'] && $_GET['id_medical_history_group']){
			$model      			  = Customer::model()->findByPk($_GET['id_customer']);
			$list_ma    			  = $model->getListMedicalHistoryAlert($model->id);
			$list_m     			  = $model->getListMedicineAlert();
			$tooth_data 			  = new ToothData;
			$listToothStatus          = $tooth_data->getListToothStatusNew($model->id,$_GET['id_medical_history_group']);
			$listTreatment 			  = VQuotations::model()->getListTreatmentOfQuotation(1, 20, $_GET['id_customer'], $_GET['id_medical_history_group']);
			$listTreatmentProcess     = $model->getListTreatmentProcessOfCustomer($_GET['id_medical_history_group']);
			$filename   			  = 'HoSoDieuTri.pdf';
			$html2pdf   			  = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);
			$html2pdf->WriteHTML($this->renderPartial('export_treatment_records', array('model'=>$model, 'id_mhg'=>$_GET['id_medical_history_group'], 'tooth_data'=>$tooth_data, 'list_ma'=>$list_ma, 'list_m'=>$list_m, 'listToothStatus'=>$listToothStatus, 'listTreatment'=>$listTreatment, 'listTreatmentProcess'=>$listTreatmentProcess), true));

			$html2pdf->Output($filename, 'I');

		}
	}
	public function actionSaveDentalStatusImage(){
		$targetDir = Yii::app()->basePath.'/../upload/customer/dental_status_image/'.$_POST['code_number'];
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}
		$image = $_POST['image'];
		$name = $_POST['code_number']."-".$_POST['id_mhg'];
		$filename = $targetDir."/".$name;
		$image = str_replace('data:image/png;base64,', '', $image);
		$decoded = base64_decode($image);
		if (file_exists($filename)) {
			@unlink($filename);
		}
		file_put_contents("upload/customer/dental_status_image/" . $_POST['code_number'] . "/" . $name . ".png", $decoded, LOCK_EX);

	}
	public function actionSetSessionAddPrescription(){
		if( $_POST['diagnose'] && $_POST['drug_name'] && $_POST['times'] && $_POST['dosage'] )
		{
			if($_POST['id_medical_history_pre']){
				$data  = Customer::model()->savePrescription(array('id_group_history' => $_POST['id_history_group'], 'id_medical_history' => $_POST['id_medical_history_pre'], 'diagnose' => $_POST['diagnose'], 'drug_name' => $_POST['drug_name'], 'times' => $_POST['times'], 'dosage' => $_POST['dosage'], 'advise' => $_POST['advise'], 'examination_after' => $_POST['examination_after']));
				if(isset($_POST['id_customer']) && $_POST['id_customer']) {
					$model 		= Customer::model()->findByPk($_POST['id_customer']);
					$treatment 	= CsMedicalHistoryGroup::model()->findByPk($_POST['id_history_group']);
					$this->renderPartial('tab_medical_record',array('model'=>$model,'treatment'=>$treatment));
				}
			}
			else{
				Yii::app()->session['add_prescription'] = array('diagnose' => $_POST['diagnose'], 'drug_name' => $_POST['drug_name'], 'times' => $_POST['times'], 'dosage' => $_POST['dosage'], 'advise' => $_POST['advise'], 'examination_after' => $_POST['examination_after']);
				echo 1;
			}

		}

	}
	public function actionSetSessionAddLab(){
		if( $_POST['id_branch'] && $_POST['id_dentist'] && $_POST['sent_date'] && $_POST['received_date'] && $_POST['assign'] )
		{
			if($_POST['id_medical_history_lab']){
				$data  = Customer::model()->saveLab(array('id_group_history' => $_POST['id_history_group'], 'id_medical_history' => $_POST['id_medical_history_lab'], 'id_branch' => $_POST['id_branch'], 'id_dentist' => $_POST['id_dentist'], 'sent_date' => $_POST['sent_date'], 'received_date' => $_POST['received_date'], 'assign' => $_POST['assign'], 'note' => $_POST['note']));

				if(isset($_POST['id_customer']) && $_POST['id_customer']) {
					$model 		= Customer::model()->findByPk($_POST['id_customer']);
					$treatment 	= CsMedicalHistoryGroup::model()->findByPk($_POST['id_history_group']);
					$this->renderPartial('tab_medical_record',array('model'=>$model,'treatment'=>$treatment));
				}
			}
			else{
				Yii::app()->session['add_lab'] = array('id_branch' => $_POST['id_branch'], 'id_dentist' => $_POST['id_dentist'], 'sent_date' => $_POST['sent_date'], 'received_date' => $_POST['received_date'], 'assign' => $_POST['assign'], 'note' => $_POST['note']);
				echo 1;
			}

		}
	}

	public function actionSetSessionAddLabo(){
		
	}

	public function actionUnsetSessionAddPrescription(){
		unset(Yii::app()->session['add_prescription']);
	}

	public function actionUnsetSessionAddLab(){
		unset(Yii::app()->session['add_lab']);
	}

	public function actionSaveMedicalHistory() {
		if ($_POST['treatment_work']) {
			$id_dentist = isset($_POST['id_dentist']) ? $_POST['id_dentist'] : '';

			$model = Customer::model()->findByPk($_POST['id_customer']);
			$id_shedule = '';
			$id_branch = $model->getIdBranchByIdUser($id_dentist);
			$tooth_numbers = isset($_POST['tooth_numbers']) ? $_POST['tooth_numbers'] : "";

			if ($_POST['id_medical_history']) {
				$data = $model->updateMedicalHistory($_POST['id_medical_history'], $_POST['id_customer'], $_POST['id_history_group'], yii::app()->user->getState('user_id'), $id_dentist, $id_branch, $_POST['treatment_work'], $tooth_numbers, $_POST['createdate'], $_POST['reviewdate'], $_POST['description'], $_POST['newest_schedule']);

			} else {
				$session_add_prescription = isset(Yii::app()->session['add_prescription']) ? Yii::app()->session['add_prescription'] : "";
				$session_add_lab = isset(Yii::app()->session['add_lab']) ? Yii::app()->session['add_lab'] : "";
				$data = $model->addMedicalHistory($_POST['id_customer'], $_POST['id_history_group'], yii::app()->user->getState('user_id'), $id_dentist, $id_branch, $_POST['treatment_work'], $tooth_numbers, $session_add_prescription, $session_add_lab, $_POST['createdate'], $_POST['reviewdate'], $_POST['description'], $_POST['newest_schedule']);

				if (isset($_POST['status_success'])) {
					$id_shedule = $model->getIdScheduleByIdCustomer($_POST['id_customer']);
					if ($id_shedule) {
						$id_quotation = $model->checkNewestTreatmentExistQuotation($_POST['id_customer']);

						$result = CsSchedule::model()->updateSchedule(array('id' => $id_shedule, 'status' => 4, 'id_quotation' => $id_quotation));
					}
				}
			}

			if (isset($_POST['id_customer']) && $_POST['id_customer']) {
				$model = Customer::model()->findByPk($_POST['id_customer']);
				$treatment = CsMedicalHistoryGroup::model()->findByPk($_POST['id_history_group']);
				$this->renderPartial('tab_medical_record', array('model' => $model, 'treatment' => $treatment));
			}
		}
	}

	public function actionDeleteMedicalHistory(){
		if( isset($_POST['id']) && isset($_POST['id_history_group']) )
		{
			$model = new Customer;
			$data  = $model->deleteMedicalHistory($_POST['id']);
			if ($data==1){
				if(isset($_POST['id_customer']) && $_POST['id_customer']) {
					$model 		= Customer::model()->findByPk($_POST['id_customer']);
					$treatment 	= CsMedicalHistoryGroup::model()->findByPk($_POST['id_history_group']);
					$this->renderPartial('tab_medical_record',array('model'=>$model,'treatment'=>$treatment));
				}
			}
		}
	}
	public function actionLoadViewLabo(){
		$id_customer 		= isset($_POST['id_customer'])?$_POST['id_customer']:"";
		$id_labo 			= isset($_POST['id_labo'])?$_POST['id_labo']:"";
		$id_medical_history = isset($_POST['id_medical_history'])?$_POST['id_medical_history']:"";
		$model  			= new Customer;
		$model 				= $model->findByPk($id_customer);
		$labo 				= new Labo;
		$labo 				= $labo->findByPk($id_labo);
		$this->renderPartial('view_labo',array('model'=>$model, 'labo'=>$labo, 'id_medical_history'=>$id_medical_history));
	}
	public function actionDeleteLabo(){
		$id_labo = (isset($_POST['id_labo'])) ? $_POST['id_labo'] : '';
		if($id_labo){
			Labo::model()->deleteByPk($_POST['id_labo']);
		}
		if(isset($_POST['id_customer']) && $_POST['id_customer']) {
			$model 		= Customer::model()->findByPk($_POST['id_customer']);
			$treatment 	= CsMedicalHistoryGroup::model()->findByPk($_POST['id_mhg']);
			$this->renderPartial('tab_medical_record',array('model'=>$model,'treatment'=>$treatment));
		}
	}
	public function actionExportLabo(){
		if($_GET['id_medical_history']){
			$model = Customer::model()->findByPk($_GET['id_customer']);
			$data  = Customer::model()->getMedicalHistoryById($_GET['id_medical_history']);
			$filename = 'Labo.pdf';
			$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);
			$html2pdf->WriteHTML($this->renderPartial('export_lab', array('model'=>$model,'data'=>$data), true));
			$html2pdf->Output($filename, 'I');

		}
	}

	public function actionLoadViewPrescription(){
		$id_customer 		= isset($_POST['id_customer'])?$_POST['id_customer']:"";
		$id_prescription 	= isset($_POST['id_prescription'])?$_POST['id_prescription']:"";
		$id_medical_history = isset($_POST['id_medical_history'])?$_POST['id_medical_history']:"";
		$model  			= new Customer;
		$model 				= $model->findByPk($id_customer);
		$prescription 		= new Prescription;
		$prescription 		= $prescription->findByPk($id_prescription);

		$this->renderPartial('view_prescription',array('model'=>$model, 'prescription'=>$prescription, 'id_medical_history'=>$id_medical_history));
	}

	public function actionExportPrescription(){
		if($_GET['id_customer'] && $_GET['id_medical_history']){
			$model = Customer::model()->findByPk($_GET['id_customer']);
			$data  = Customer::model()->getMedicalHistoryById($_GET['id_medical_history']);
			$filename = 'ToaThuoc.pdf';
			$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);
			$html2pdf->WriteHTML($this->renderPartial('export_prescription', array('model'=>$model,'data'=>$data), true));
			$html2pdf->Output($filename, 'I');

		}
	}

	public function actionDeletePrescription(){
		$id_prescription = (isset($_POST['id_prescription'])) ? $_POST['id_prescription'] : '';
		if($id_prescription){
			Prescription::model()->deleteByPk($_POST['id_prescription']);
			DrugAndUsage::model()->deleteAllByAttributes(array('id_prescription'=>$id_prescription));
		}

		if(isset($_POST['id_customer']) && $_POST['id_customer']) {
			$model 		= Customer::model()->findByPk($_POST['id_customer']);
			$treatment 	= CsMedicalHistoryGroup::model()->findByPk($_POST['id_mhg']);
			$this->renderPartial('tab_medical_record',array('model'=>$model,'treatment'=>$treatment));
		}
	}

	public function actionLoadViewTreatment(){
		$id_medical_history = isset($_POST['id_medical_history'])	?$_POST['id_medical_history']:"";
		$id_customer 		= isset($_POST['id_customer'])			?$_POST['id_customer']:"";
		$data_tooth 		= isset($_POST['data_tooth']) 			?$_POST['data_tooth']:"";
		if($data_tooth){
			$data_tooth = explode(',', $data_tooth);
		}
		$model 				= new Customer();
		$MedicalHistory 	= new CsMedicalHistory();
		if($id_medical_history){
			$MedicalHistory 	= $MedicalHistory->findByPk($id_medical_history);
		}
		$this->renderPartial('view_treatment_process', array('model'=>$model, 'MedicalHistory'=>$MedicalHistory, 'data_tooth'=>$data_tooth, 'id_customer'=>$id_customer));
	}

	public function actionDeletetooth(){
		$id = $_POST["id"];
		$id_customer = $_POST["id_customer"];
		$id_mhg = $_POST["id_mhg"];

		$transaction = Yii::app()->db->beginTransaction();

		try{
			$ToothConclude = new ToothConclude();
			$ToothAssign = new ToothAssign();
			$ToothData = new ToothData();
			$ToothImage = new ToothImage();

			$ToothConclude->deleteToothConclude($id,$id_customer,$id_mhg);
			$ToothAssign->deleteToothAssign($id,$id_customer,$id_mhg);
			$id_tooth = explode("_",$id);
			foreach ($id_tooth as $key => $value) {
				$ToothData->deleteToothData($value,$id_customer,$id_mhg);
				$ToothImage->deleteToothImage($value,$id_customer,$id_mhg);
			}
			$transaction->commit();
			echo "Bạn xóa thành công";
			exit;
		} catch (Exception $e) {
			$transaction->rollBack();
			echo $e->getMessage();
		}

		echo "<pre>";
		var_dump($_POST);
		echo "</pre>";
	}

	#region --- LAY DANH SACH BAC SY
	public function actionGetDentistList() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$search = isset($_POST['q']) ? $_POST['q'] : '';
		$item = 30;

	    $search_params= 'AND (`name` LIKE "%'.$search.'%" OR `code` LIKE "%'.$search.'%") AND group_id = 3';

		$dentistList = GpUsers::model()->searchStaffs('','',' '.$search_params,$item,$page);

	    if(!$dentistList) {
	    	echo -1;exit();
		}
		echo json_encode($dentistList);
	}
	#endregion

	public function actionUpdateNote(){
		$type 	= isset($_POST['type']) 	? $_POST['type'] : '';
		$id 	= isset($_POST['id']) 		? $_POST['id'] : '';
		$note 	= '';
		if($type == 1){
			$data = CsMedicalHistory::model()->findByPk($id);
			if($data){
				$note = $data['description'];
			}
		}
		else if($type == 2){
			$data = InvoiceDetail::model()->findByPk($id);
			if($data){
				$note = $data['note'];
			}
		}
		print_r($note);
	}

	public function actionSaveUpdateNote(){
		$type 		= isset($_POST['typeUpdate']) 		? $_POST['typeUpdate'] : '';
		$id 		= isset($_POST['idUpdate']) 		? $_POST['idUpdate'] : '';
		$dataNote 	= isset($_POST['dataNote']) 		? $_POST['dataNote'] : '';
		if($type == 1){
			$data = CsMedicalHistory::model()->updateByPk($id, array("description"=> $dataNote));
		}
		else if($type == 2){
			$data = InvoiceDetail::model()->updateByPk($id, array("note"=> $dataNote));
		}
		if(isset($_POST['id_customer']) && $_POST['id_customer']) {
			$model 		= Customer::model()->findByPk($_POST['id_customer']);
			$treatment 	= CsMedicalHistoryGroup::model()->findByPk($_POST['id_mhg']);
			$this->renderPartial('tab_medical_record',array('model'=>$model,'treatment'=>$treatment));
		}

	}

	public function actionSaveLaboHistory() {
		$dataLabo = array(
			'id_customer' => isset($_POST['id_customer'])?$_POST['id_customer']:'',
			'id_user' => isset($_POST['id_d3ntist'])?$_POST['id_d3ntist']:'',
			'id_labo' => isset($_POST['id_labo'])?$_POST['id_labo']:'',
			'sent_date' => isset($_POST['sent_date'])?$_POST['sent_date']:'',
			'sent_person' => isset($_POST['sent_person'])?$_POST['sent_person']:'',
			'sent_tray' => isset($_POST['sent_tray'])?$_POST['sent_tray']:'',
			'receive_date' => isset($_POST['receive_date'])?$_POST['receive_date']:'',
			'receive_person' => isset($_POST['receive_person'])?$_POST['receive_person']:'',
			'receive_tray' => isset($_POST['receive_tray'])?$_POST['receive_tray']:'',
			'security' => isset($_POST['security'])?$_POST['security']:'',
			'receive_assistant' => isset($_POST['receive_assistant'])?$_POST['receive_assistant']:'',
			'description' => isset($_POST['description'])?$_POST['description']:'',
			'create_date' => date('Y-m-d h:i:s', time())
		);
		if ($_POST['id_customer'] && $_POST['id_d3ntist'] && $_POST['id_labo']) {
			echo $id = LaboHistory::model()->insertLaboHistory($dataLabo);
		} else {
			echo -1;
		}
	}

	public function actionUpdateLaboHistory() {
		$dataLabo = array(
			'id_customer' => isset($_POST['labo_up_id_customer'])?$_POST['labo_up_id_customer']:'',
			'id_user' => isset($_POST['labo_up_id_d3ntist'])?$_POST['labo_up_id_d3ntist']:'',
			'id_labo' => isset($_POST['labo_up_id_labo'])?$_POST['labo_up_id_labo']:'',
			'sent_date' => isset($_POST['labo_up_sent_date'])?$_POST['labo_up_sent_date']:'',
			'sent_person' => isset($_POST['labo_up_sent_person'])?$_POST['labo_up_sent_person']:'',
			'sent_tray' => isset($_POST['labo_up_sent_tray'])?$_POST['labo_up_sent_tray']:'',
			'receive_date' => isset($_POST['labo_up_receive_date'])?$_POST['labo_up_receive_date']:'',
			'receive_person' => isset($_POST['labo_up_receive_person'])?$_POST['labo_up_receive_person']:'',
			'receive_tray' => isset($_POST['labo_up_receive_tray'])?$_POST['labo_up_receive_tray']:'',
			'security' => isset($_POST['labo_up_security'])?$_POST['labo_up_security']:'',
			'receive_assistant' => isset($_POST['labo_up_receive_assistant'])?$_POST['labo_up_receive_assistant']:'',
			'description' => isset($_POST['labo_up_description'])?$_POST['labo_up_description']:''
		);
		if ($_POST['labo_up_id']) {
			echo LaboHistory::model()->updateLaboHistory($_POST['labo_up_id'], $dataLabo);
		} else {
			echo -1;
		}
	}

	public function actionRemoveLaboHistory() {
		if ($_POST['id']) {
			echo LaboHistory::model()->removeLaboHistory($_POST['id']);
		} else {
			echo -1;
		}
	}

	public function actionGetLaboHistory() {
		if (isset($_POST['id']) && $_POST['id']) {
			$labo = LaboHistory::model()->getLabo($_POST['id']);
			if ($labo) {
				echo json_encode($labo);
			} else {
				echo -1;
			}
		} else {
			echo -1;
		}
	}
}
