<?php

class ReportCustomersController extends Controller
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

	public function actionTypeReport() {
		$model = new Customer;
		$search_time = isset($_POST['search_time']) ? $_POST['search_time'] : '';
		$search_branch = isset($_POST['search_branch']) ? $_POST['search_branch'] : '';
		$search_user = isset($_POST['search_user']) ? $_POST['search_user'] : '';
		$search_type = isset($_POST['search_type']) ? $_POST['search_type'] : '';
		$fromtime = isset($_POST['fromtime']) ? $_POST['fromtime'] : '';
		$totime = isset($_POST['totime']) ? $_POST['totime'] : '';
		$group_service = isset($_POST['group_service']) ? $_POST['group_service'] : '';
		$service = isset($_POST['service']) ? $_POST['service'] : '';
		$source = isset($_POST['source']) ? $_POST['source'] : '';
		$customer = isset($_POST['customer']) ? $_POST['customer'] : '';
		$country = isset($_POST['country']) ? $_POST['country'] : '';
		$city = isset($_POST['city']) ? $_POST['city'] : '';
		$district = isset($_POST['district']) ? $_POST['district'] : '';

		if ($search_type == 1) {
			$cs = $model->getListCustomerOfTreatment($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$this->renderPartial('detail_report_treatment', array('cs' => $cs, 'title' => $title));

		} else if ($search_type == 2) {
			$cs = $model->getListCustomerNew($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$this->renderPartial('detail_report_date', array('cs' => $cs['data'], 'count' => $cs['count'], 'title' => $title));

		} else if ($search_type == 3) {
			$cs = $model->getListCustomerOfBirthdate($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$this->renderPartial('detail_report_birthdate', array('cs' => $cs['data'], 'count' => $cs['count'], 'title' => $title));

		} else if ($search_type == 6) {
			$cs = $model->getListCustomerOfNote($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$this->renderPartial('detail_note', array('cs' => $cs['data'], 'count' => $cs['count'], 'title' => $title));

		} else if ($search_type == 5) {
			$cs = $model->getListCustomerOfService($search_time, $search_user, $search_branch, $fromtime, $totime, $service, $group_service, $customer);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', $service, $fromtime, $totime);
			$this->renderPartial('detail_report_service', array('cs' => $cs['data'], 'count' => $cs['count'], 'title' => $title));

		} else if ($search_type == 7) {
			$cs = $model->getListCustomerOfSource($search_time, $search_branch, $fromtime, $totime, $source);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, $source, '', $fromtime, $totime);
			$this->renderPartial('detail_report_source', array('data' => $cs['data'], 'count' => $cs['count'], 'title' => $title));

		} else if ($search_type == 8) {
			$cs = $model->getListCustomerOfBalance($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$this->renderPartial('detail_report_balance', array('cs' => $cs, 'title' => $title));

		} else if ($search_type == 4) {
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$cs = $model->getListCustomerSpending($search_time, $search_user, $search_branch, $fromtime, $totime);
			$this->renderPartial('detail_report_spend', array('cs' => $cs, 'title' => $title));

		} else if ($search_type == 9) {
			$title = $model->getTitleReport($search_time, '', '', '', '', $fromtime, $totime);
			$cs = $model->getListCustomerDateOfTreatment($search_time, $fromtime, $totime);
			$this->renderPartial('detail_report_date_treatment', array('cs' => $cs, 'title' => $title));

		}  else if ($search_type == 10) {
			$datetime = isset($_POST['datetime']) ? $_POST['datetime'] : date('y-m-d');

			$title = $model->getTitleReport(5, '', $search_branch, '', '', $datetime, '');
			$data = $model->getListCustomerTreatmentAfter($search_branch, $datetime);

			$this->renderPartial('detail_report_treament_after', array('title' => $title, 'data' => $data));

		} else if ($search_type == 11) {
			$datetime = isset($_POST['datetime']) ? $_POST['datetime'] : date('y-m-d');

			$title = $model->getTitleReport(5, '', $search_branch, '', '', $datetime, '');
			$data = $model->getListCustomerTreatmentNot($search_branch, $datetime);

			$this->renderPartial('detail_report_treament_not', array('title' => $title, 'data' => $data));
		} else if ($search_type == 12) {
			$datetime = isset($_POST['datetime']) ? $_POST['datetime'] : date('y-m-d');
			$title = $model->getTitleReport(5, '', $search_branch, '', '', $datetime, '');
			$cs = $model->getListCustomerOfRemind($search_time, $search_user, $search_branch, $fromtime, $totime);
			$this->renderPartial('detail_report_remind', array('title' => $title, 'cs' => $cs['data'], 'count' => $cs['count']));
		} else if ($search_type == 13) {
			$title = $model->getTitleReport($search_time, '', $search_branch, '', '', $fromtime, $totime);
			$cs = $model->getListCustomerArea($search_time, $country, $city, $district, $fromtime, $totime);
			$this->renderPartial('detail_report_area', array('title' => $title, 'cs' => $cs['data'], 'count' => $cs['count']));
		} 
	}

	public function actionGetService(){
		$id = $_POST['id'];
        $listdata        = array();
        $listdata['']    = "Chọn dịch vụ";
        $User         = CsService::model()->findAllByAttributes(array('id_service_type'=>$id));
        foreach($User as $temp){
            $listdata[$temp['id']] =  $temp['name'];
        }
        echo CHtml::dropDownList('frm_search_dich_vu',10,$listdata,array('onChange'=>"search_cus(this);",'class'=>'Service form-control'));
	}

	public function actionTypePrint(){
		$model = new Customer;
		$search_time = isset($_GET['time']) ? $_GET['time'] : false;
		$search_branch = isset($_GET['branch']) ? $_GET['branch'] : false;
		$search_user = isset($_GET['lstUser']) ? $_GET['lstUser'] : false;
		$search_type = isset($_GET['type']) ? $_GET['type'] : false;
		$fromtime = isset($_GET['fromtime']) ? $_GET['fromtime'] : false;
		$totime = isset($_GET['totime']) ? $_GET['totime'] : false;
		$source = isset($_GET['source']) ? $_GET['source'] : false;
		$service = isset($_GET['service']) ? $_GET['service'] : false;
		$customer = isset($_GET['customer']) ? $_GET['customer'] : false;
		$filename = 'test.pdf';
		$html2pdf = Yii::app()->ePdf->HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 0);

		if ($search_type == 1) {
			$cs = $model->getListCustomerOfTreatment($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);

			$html2pdf->WriteHTML($this->renderPartial('ex_report_treatment', array('cs' => $cs, 'title' => $title), true));
		} else if ($search_type == 2) {
			$cs = $model->getListCustomerNew($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$html2pdf->WriteHTML($this->renderPartial('ex_report_date', array('cs' => $cs['data'], 'title' => $title), true));
		} else if ($search_type == 3) {
			$cs = $model->getListCustomerOfBirthdate($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$html2pdf->WriteHTML($this->renderPartial('ex_report_birthdate', array('cs' => $cs, 'title' => $title), true));
		} else if ($search_type == 4) {
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$cs = $model->getListCustomerSpending($search_time, $search_user, $search_branch, $fromtime, $totime);
			$html2pdf->WriteHTML($this->renderPartial('ex_report_spend', array('cs' => $cs, 'title' => $title), true));
		} else if ($search_type == 5) {
			$cs = $model->getListCustomerOfService($search_time, $search_user, $search_branch, $fromtime, $totime, $service, '', $customer);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', $service, $fromtime, $totime);
			$html2pdf->WriteHTML($this->renderPartial('ex_report_service', array('cs' => $cs['data'], 'count' => $cs['count'], 'title' => $title), true));
		} else if ($search_type == 6) {
			$cs = $model->getListCustomerOfNote($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$html2pdf->WriteHTML($this->renderPartial('ex_report_note', array('cs' => $cs['data'], 'count' => $cs['count'], 'title' => $title), true));
		} else if ($search_type == 7) {
			$cs = $model->getListCustomerOfSource($search_time, $search_branch, $fromtime, $totime, $source);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, $source, '', $fromtime, $totime);
			$html2pdf->WriteHTML($this->renderPartial('ex_report_source', array('cs' => $cs['data'], 'count' => $cs['count'], 'title' => $title), true));
		} else if ($search_type == 8) {
			$cs = $model->getListCustomerOfBalance($search_time, $search_user, $search_branch, $fromtime, $totime);
			$title = $model->getTitleReport($search_time, $search_user, $search_branch, '', '', $fromtime, $totime);
			$html2pdf->WriteHTML($this->renderPartial('ex_report_balance', array('cs' => $cs, 'title' => $title), true));
		} else if ($search_type == 9) {
			$title = $model->getTitleReport($search_time, '', '', '', '', $fromtime, $totime);
			$cs = $model->getListCustomerDateOfTreatment($search_time, $fromtime, $totime);
			$html2pdf->WriteHTML($this->renderPartial('ex_report_date_treatment', array('cs' => $cs, 'title' => $title), true));
		}

	    $html2pdf->Output($filename, 'I');
	}

	public function actionGetCustomerList() {
		$page = isset($_POST['page'])?$_POST['page']:1;
		$search = isset($_POST['q'])?$_POST['q']:'';

	    $item = 50;

	    $customerList = CsSchedule::model()->searchCustomer($page, $item, $search);
		$customer = array();

	    if($customerList) {
	    	foreach ($customerList as $key => $value) {
				$customer[] = array(
					'id' => $value['id'],
					'text' => $value['fullname'],
					'code_number' => $value['code_number'],
					'phone' => $value['phone'],
					'img' => $value['image'],
					'email' => $value['email'],
					'gender' => $value['gender'],
					'birthdate' => $value['birthdate'],
					'identity_card_number' => $value['identity_card_number'],
					'id_country' => $value['id_country'],
					'adr' => $value['address'],
				);
			}
	    }
		echo json_encode($customer);
	}

}
