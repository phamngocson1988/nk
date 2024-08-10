<?php

class ReportingTreatmentController extends Controller
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


	public function actionView(){
		$GpUsers = new GpUsers();
		$dentist = $GpUsers->ListUser(3);
		$listserviceType = CsServiceType::model()->ListServiceType();
		$listCsService =  CsService::model()->findAll(array("condition"=> "status != 0"));

		$this->render('view',
			array(
				"dentist"=>$dentist,
				"listserviceType"=>$listserviceType,
				"listCsService"=>$listCsService,
			)
		);
	}

	public function actionShowTreatment(){
		$fromtime = $_POST['fromtime'];
		$totime = $_POST['totime'];
		$dentist = $_POST['dentist'];

		$serviceType = new CsServiceType();
		$listserviceType = $serviceType->ListServiceType();
		$arrayServiceType = array();
		foreach ($listserviceType as $key => $value) {
			$arrayServiceType[$value['id']] = $value['name'];
		}


		$invoiceDetail = new InvoiceDetail();
		$list = $invoiceDetail->showDieuTri($fromtime,$totime,$dentist);
		
		$ListDentist = GpUsers::model()->ListUser(3);
		$dentist = explode(",",$dentist);
		$nameDentist = array();

		foreach ($ListDentist as $key => $value) {
			$nameDentist[$value["id"]] = $value["name"];
		}

		$this->renderPartial('Treatment',
			array(
				"arrayList"=>$list,
				"arrayServiceType"=>$arrayServiceType,
				"fromtime"=>$fromtime,
				"totime"=>$totime,
				"dentist"=>$dentist,
				"nameDentist"=>$nameDentist,
			)
		);
	}

	public function actionShowDetailTreatment(){
		$fromtime = $_POST['fromtime'];
		$totime = $_POST['totime'];
		$dentist = $_POST['dentist'];
		$status = $_POST['status'];

		$serviceType = new CsServiceType();
		$listserviceType = $serviceType->ListServiceType();

		$service = CsService::model()->findAll();
		$arrayService = array();
		foreach ($service as $key => $value) {
			$item = array();
			$item["name"] = $value["name"];
			$item["code"] = $value["code"];
			$arrayService[$value["id"]]= $item;
		}

		$dichvu = "";
		$arrayServiceType = array();
		foreach ($listserviceType as $key => $value) {
			$dichvu .= $value["id"].","; 
			$arrayServiceType[$value['id']] = $value['name'];
		}
		$invoiceDetail = new InvoiceDetail();


		$list = $invoiceDetail->showDetailDieuTri($fromtime,$totime,$dentist,$status);

		$sum = 0;
		$ListDentist = GpUsers::model()->ListUser(3);
		$dentist = explode(",",$dentist);
		$nameDentist = array();
		$serviceTypeShow = array();
		
		foreach ($list as $key => $value) {
			if (!in_array($value["id_service_type"], $serviceTypeShow)) {
				$serviceTypeShow[$value["id_service_type"]] = $value["id_service_type"];
			}
		}

		foreach ($ListDentist as $key => $value) {
			$nameDentist[$value["id"]] = $value["name"];
		}

		$this->renderPartial('detailTreatment',
			array(
				"serviceTypeShow"=>$serviceTypeShow,
				"arrayList"=>$list,
				"arrayServiceType"=>$arrayServiceType,
				"list"=>$list,
				"arrayService"=>$arrayService,
				"fromtime"=>$fromtime,
				"totime"=>$totime,
				"dentist"=>$dentist,
				"nameDentist"=>$nameDentist,
			)
		);
	}


}
