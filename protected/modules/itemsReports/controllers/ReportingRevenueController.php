<?php

class ReportingRevenueController extends Controller
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

	public function actionShowRevenue(){
		$fromtime = $_POST['fromtime'];
		$totime = $_POST['totime'];
		$dentist = $_POST['dentist'];
		$option = $_POST['option'];

		$invoiceDetail = new InvoiceDetail();
		$list = $invoiceDetail->showRevenue1($fromtime, $totime, $dentist, $option);
		$sum = $invoiceDetail->getSumRevenue($fromtime, $totime, $dentist, $option);
		$promotion = 0;
		if ($option == 0) {
			$promotion = $invoiceDetail->getSumPromotion($fromtime, $totime, $dentist, $option);
		}


		$dentistList = GpUsers::model()->findAll(array(
			'select' => 'id, name',
			'condition' => "id IN (" . $dentist . ")"
		));

		$this->renderPartial('revenue', array(
			"data" => $list,
			"fromtime" => $fromtime,
			"totime" => $totime,
			"dentistList" => CHtml::listData($dentistList, 'id', 'name'),
			"option" => $option,
			'sum' => $sum,
			'promotion' => $promotion
		));
	}

	public function actionRevenueReport() {
		$fromtime = $_POST['fromtime'];
		$totime = $_POST['totime'];
		$dentist = $_POST['dentist'];

		$logic = new ReportingRevenueLogic;
		$logic->attributes = array('fromtime' => $fromtime, 'totime' => $totime, 'dentist' => $dentist);
		$list = $logic->getReport();
		$sum = $logic->getSum($list);
		$promotion = 0;
		$dentistList = array();
		if ($dentist) {
			$dentistList = GpUsers::model()->findAll(array(
				'select' => 'id, name',
				'condition' => "id IN (" . $dentist . ")"
			));
		}

		$this->renderPartial('report_revenue', array(
			"data" => $list,
			"fromtime" => $fromtime,
			"totime" => $totime,
			"dentistList" => CHtml::listData($dentistList, 'id', 'name'),
			'sum' => $sum,
			'promotion' => $promotion
		));
	}

	public function actionShowDetailRevenue(){

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

		$list = $invoiceDetail->showDetailRevenue($fromtime,$totime,$dentist,$status);

		$arrayList = array();
		$sum = 0;

		foreach ($list as $key => $value) {

			if (!in_array($value["id"], $arrayList)) {

				array_push($arrayList, $value["id"]);
			}

		}

		$ListDentist = GpUsers::model()->ListUser(3);
		$dentist = explode(",",$dentist);
		$nameDentist = array();

		foreach ($ListDentist as $key => $value) {
			$nameDentist[$value["id"]] = $value["name"];
		}

		$this->renderPartial('detailRevenue',
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

}
