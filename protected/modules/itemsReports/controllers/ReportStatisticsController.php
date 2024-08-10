<?php

class ReportStatisticsController extends Controller
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
		$GpUsers = new GpUsers();
		$dentist = $GpUsers->ListUser(3);
		$service = new CsService();
		$listService = $service->ListService();
		$serviceType = new CsServiceType();
		$listserviceType = $serviceType->ListServiceType();
		$this->render('view',
			array(
				"dentist"=>$dentist,
				"listService"=>$listserviceType,
			)
		);
	}

	public function actionShowStatistics(){
		$fromtime = $_POST['fromtime'];
		$totime = $_POST['totime'];
		$dentist = $_POST['dentist'];
		$dichvu = $_POST['dichvu'];

		$invoiceDetail = new InvoiceDetail();
		$list = $invoiceDetail->showHoadon($fromtime,$totime,$dentist,$dichvu);

		$CsServiceType = new CsServiceType();
		$listCsServiceType = $CsServiceType->ListServiceType();

		$arrayServiceType = array();
		foreach ($listCsServiceType as $key => $value) {
			$arrayServiceType[$value['id']] = $value['name'];
		}

		$arrayList = array();
		foreach ($list as $key => $value) {
			$arrayList[$value["id"]] = $value["sum"];
		}

		$this->renderPartial('hoadon',
			array(
				"arrayList"=>$arrayList,
				"arrayServiceType"=>$arrayServiceType,
				"dichvu"=>$dichvu,
			)
		);
	}

	public function actionShowdeal(){
		$fromtime = $_POST['fromtime'];
		$totime = $_POST['totime'];
		$dentist = $_POST['dentist'];
		$dichvu = $_POST['dichvu'];
		$invoiceDetail = new InvoiceDetail();
		$list = $invoiceDetail->showGiaodich($fromtime,$totime,$dentist,$dichvu);
		$CsServiceType = new CsServiceType();
		$listCsServiceType = $CsServiceType->ListServiceType();

		$arrayServiceType = array();
		foreach ($listCsServiceType as $key => $value) {
			$arrayServiceType[$value['id']] = $value['name'];
		}
		$arrayList = array();
		foreach ($list as $key => $value) {
			$item = array();
			$item["doanhso"] = $value["amount"];
			$item["luong"] = $value["luong"];
			$arrayList[$value["id"]] = $item;
		}

		$this->renderPartial('giaodich',
			array(
				"arrayList"=>$arrayList,
				"listServiceType"=>$arrayServiceType,
				"dichvu"=>$dichvu,
			)
		);
		
	}
}
