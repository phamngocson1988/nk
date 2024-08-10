<?php

class ReportingSalaryController extends Controller
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

		$this->render('view',
			array(
				"dentist"=>$dentist,
			)
		);
	}

	public function actionShowSalary(){
		$fromtime = $_POST['fromtime'];
		$totime = $_POST['totime'];
		$dentist = $_POST['dentist'];

		$serviceType = new CsServiceType();
		$listserviceType = $serviceType->ListServiceType();
		$dichvu = "";
		$arrayServiceType = array();
		foreach ($listserviceType as $key => $value) {
			$dichvu .= $value["id"].","; 
			$arrayServiceType[$value['id']] = $value['name'];
		}
		$dichvu = rtrim($dichvu,",");

		$invoiceDetail = new InvoiceDetail();
		$list = $invoiceDetail->showLuong($fromtime,$totime,$dentist);
		$arrayList = array();

		foreach ($list as $key => $value) {
			$CsServiceTk = CsServiceTk::model()->findByAttributes(array("id_cs_service"=>$value["id_service"],"st"=>1));
			$CsPercentTk = CsPercentTk::model()->findByAttributes(
				array(
					"id_service_type_tk"=>$CsServiceTk["id_service_type_tk"],
					"id_gp_users"=>$value["id_user"]
				)
			);
			$list[$key]["percent1"] = $CsPercentTk["percent"];
			if (!array_key_exists($value["id"], $arrayList)) {
				$item = array();
				$item["percent"] = array($CsPercentTk["percent"]);
				if ($value["debt"]!=6 && $value["debt"]!=3) {
					$item["sum"] = $value["amount"];
					$item["luong"] = ($value["amount"]/100)*$CsPercentTk["percent"];
				}else{
					$item["sum"] = -$value["amount"];
					$item["luong"] = -($value["amount"]/100)*$CsPercentTk["percent"];
				}
				$arrayList[$value["id"]] = $item;
			}else{
				$arrayList[$value["id"]]["percent"][] = $CsPercentTk["percent"];
				if ($value["debt"]!=6 && $value["debt"]!=3) {
					$arrayList[$value["id"]]["sum"] += $value["amount"];
					$arrayList[$value["id"]]["luong"] += ($value["amount"]/100)*$CsPercentTk["percent"];
				}else{
					$arrayList[$value["id"]]["sum"] -= $value["amount"];
					$arrayList[$value["id"]]["luong"] -= ($value["amount"]/100)*$CsPercentTk["percent"];
				}
			}

		}

		$ListDentist = GpUsers::model()->ListUser(3);
		$dentist = explode(",",$dentist);
		$nameDentist = array();

		foreach ($ListDentist as $key => $value) {
			$nameDentist[$value["id"]] = $value["name"];
		}
		
		$this->renderPartial('salary',
			array(
				"arrayList"=>$arrayList,
				"arrayServiceType"=>$arrayServiceType,
				"dichvu"=>$dichvu,
				"fromtime"=>$fromtime,
				"totime"=>$totime,
				"dentist"=>$dentist,
				"nameDentist"=>$nameDentist,
			)
		);
	}

	public function actionShowDetailSalary1(){

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
		if ($status == -1) {
			$status = "";
		}

		$list = $invoiceDetail->showDetailLuong($fromtime,$totime,$dentist,$status);

		$arrayList = array();
		$sum = 0;

		foreach ($list as $key => $value) {

			if (!in_array($value["id"], $arrayList)) {

				array_push($arrayList, $value["id"]);
			}
			//$sum = ($value["amount"]/100)*$value["percent"];
		}

		$ListDentist = GpUsers::model()->ListUser(3);
		$dentist = explode(",",$dentist);
		$nameDentist = array();

		foreach ($ListDentist as $key => $value) {
			$nameDentist[$value["id"]] = $value["name"];
		}

		$this->renderPartial('detailSalary',
			array(
				"arrayList"=>$arrayList,
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
	public function actionShowDetailSalary(){

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

		if ($status==-1) {
			$status="0,2,3,5,6";
		}
		$list = $invoiceDetail->showDetailLuong($fromtime,$totime,$dentist,$status);

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

		$this->renderPartial('detailSalary',
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
