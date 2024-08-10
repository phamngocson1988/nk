<?php

class ReportingLaboController extends Controller
{
	public $layout='/layouts/main_sup';

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

	public function actionView()
	{
		$model = new Branch();
		$this->render('view',array("model"=>$model));
	}

	public function actionTypeReport() 
	{
		$search_user = isset($_POST['search_user'])?$_POST['search_user']:false;
		$fromtime = isset($_POST['fromtime'])?$_POST['fromtime']:false;
		$totime = isset($_POST['totime'])?$_POST['totime']:false;
		$full_fromtime = date_format(date_create_from_format('d/m/Y', $fromtime), 'Y-m-d')." 00:00:00";
		$full_totime = date_format(date_create_from_format('d/m/Y', $totime), 'Y-m-d')." 23:59:59";
		$search_cus = isset($_POST['search_cus'])?$_POST['search_cus']:false;
		$labo = isset($_POST['labo'])?$_POST['labo']:false;
		$title = $this->getTitleReport($search_cus, $search_user, $labo, $fromtime, $totime);
		$data = LaboHistory::model()->getListLabo($search_cus, $search_user, $labo, $full_fromtime, $full_totime);
        $this->renderPartial('detail_report', array('title' => $title, 'total' => count($data),'data' => $data));
	}

	public function getTitleReport($search_cus, $search_user, $labo, $fromtime, $totime)
	{
		$string = '';
		$string .= $fromtime . ' đến ' . $totime;
		if ($search_user == "") {
			$string .= ", Tất cả bác sĩ";
		} else {
			$search_user = explode(',', $search_user);
			$string .= ', Bác sĩ: ';
			foreach ($search_user as $key => $value) {
				$userList =  GpUsers::model()->findByPk($value);
				$string .= $userList->name;
				if ($key < count($search_user) - 1) {
					$string .= ',';
				}
			}
		}
		if ($search_cus == "") {
			$string .= ", Tất cả khách hàng";
		} else {
			$customerList = Customer::model()->findByPk($search_cus);
			if ($customerList) {
				$string .= ', Khách hàng: ' . $customerList->fullname;
			}
		}
		if ($labo == "") {
			$string .= ", Tất cả Labo";
		} else {
			$labo = explode(',', $labo);
			$string .= ', Labo: ' ;
			foreach ($labo as $key => $value) {
				$laboList = ListLabo::model()->findByPk($value);
				if ($laboList) {
					$string .= $laboList->name;
				}
				if ($key < count($search_user) - 1) {
					$string .= ',';
				}
			}	
		}
		return $string;
	}

	public function actionPrintListLabo($search_cus, $search_user, $labo, $fromtime, $totime) {
		$title = $this->getTitleReport($search_cus, $search_user, $labo, $fromtime, $totime);
		$full_fromtime = date_format(date_create_from_format('d/m/Y', $fromtime), 'Y-m-d')." 00:00:00";
		$full_totime = date_format(date_create_from_format('d/m/Y', $totime), 'Y-m-d')." 23:59:59";
		$data = LaboHistory::model()->getListLabo($search_cus, $search_user, $labo, $full_fromtime, $full_totime);
		$filename   			  = 'list_labo.pdf';
		$html2pdf = Yii::app()->ePdf->HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 0);
        $html2pdf->WriteHTML($this->renderPartial('export_list_labo', array('data'=>$data, 'total' => count($data), 'title' => $title), true));
		$html2pdf->Output($filename, 'I');
		$this->renderPartial('export_list_labo', array('data'=>$data, 'total' => count($data), 'title' => $title), true);
	}

	public function actionPrintLabo($id) {
		if ($id) {
			$labo = LaboHistory::model()->getLabo($id);
			if ($labo) {
				$filename   			  = 'labo.pdf';
				$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A5', 'en', true, 'UTF-8', 0);
		        $html2pdf->WriteHTML($this->renderPartial('export_labo', array('labo'=>$labo), true));
				$html2pdf->Output($filename, 'I');	
			}
		}
	}

}