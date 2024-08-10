<?php

class InsuranceDebtController extends Controller {
	#region --- PARAMS
	public $layout='/layouts/view';
	#endregion

	#region --- INIT
	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return parent::accessRules();
	}
	#endregion

	#region --- INDEX
	public function actionIndex($code = '') {
		$branch = Branch::model()->findAll();
		$branchList = CHtml::listData($branch, 'id', 'name');

		$customer = array();

		$this->render('view', array('branch' => $branchList, 'customer' => $customer, 'code' => $code));
	}
	#endregion

	#region --- LIST - PARTNER
	public function actionGetPatnerList() {
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$limit = 50;

		$list = Partner::model()->partnerList($page, $limit, $search);

		echo CJSON::encode($list);
	}
	#endregion

	#region --- DANH SACH CONG NO BAO HIEM
	public function actionLoadInsurance() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
		$dataSearch = isset($_POST) ? $_POST : array();

		$insurance = Insurance::model()->getList($page, $limit, $dataSearch);

		$page_list = VQuotations::model()->paging($page, $insurance['count'], $limit, 'insurancePaging', '');

		$this->renderPartial('list', array('data' => $insurance, 'page_list' => $page_list));
	}
	#endregion

	#region --- DANH SACH CHI TIET CONG NO BAO HIEM
	public function actionLoadInsuranceDetail() {
		$id_insurance = isset($_POST['id_insurance']) ? $_POST['id_insurance'] : false;

		$transaction = array();

		if ($id_insurance) {
			$transactionData = InsuranceTransaction::model()->with(array(
				'employee' => array('select' => 'name')
			))->findAllByAttributes(array('id_insurance' => $id_insurance));

			if ($transactionData) {
				foreach ($transactionData as $key => $value) {
					$data = $value->attributes;
					$data['author'] = (isset($value->employee)) ? $value->employee->name : '';
					$data['type_name'] = InsuranceTransaction::$_type[$value->type]['name'];

					$transaction[] = $data;
				}
			}
		}

		echo CJSON::encode($transaction);
	}
	#endregion

	#region --- TAO MOI - THAO TAC
	public function actionCreate() {
		$data = isset($_POST) ? $_POST : array();
		$transaction = Insurance::model()->addInsuranceDebt($data);
		echo CJSON::encode($transaction);
	}
	#endregion

	#region --- CAP NHAT - GIAO DIEN
	public function actionUpdateLayout() {
		$id_insurance = isset($_POST['id_insurance']) ? $_POST['id_insurance'] : false;
		if (!$id_insurance) {
			echo -1;
			exit;
		}

		$insurance = Insurance::model()->with(array(
			'customer' => array('select' => 'code_number, fullname'),
			'partner' => array('select' => 'name')
		))->findByPk($id_insurance);

		return $this->renderPartial('update', array(
			'insurance' => $insurance
		));
	}
	#endregion

	#region --- CAP NHAT - THAO TAC
	public function actionUpdate() {
		$data = isset($_POST) ? $_POST : array();

		$transaction = InsuranceTransaction::model()->addInsuranceTransaction($data);

		echo CJSON::encode($transaction);
	}
	#endregion

	#region --- THANH TOAN - GIAO DIEN
	public function actionPaidLayout() {
		$id_insurance = isset($_POST['id_insurance']) ? $_POST['id_insurance'] : false;
		if (!$id_insurance) {
			echo -1;
			exit;
		}

		$insurance = Insurance::model()->with(array(
			'customer' => array('select' => 'code_number, fullname'),
			'partner' => array('select' => 'name')
		))->findByPk($id_insurance);

		return $this->renderPartial('pay', array(
			'insurance' => $insurance
		));
	}
	#endregion

	#region --- THANH TOAN - THAO TAC
	public function actionPaid() {
		$data = isset($_POST) ? $_POST : array();
		$transaction = InsuranceTransaction::model()->paidInsuranceTransaction($data);
		echo CJSON::encode($transaction);
	}
	#endregion

	#region --- HUY - THAO TAC
	public function actionCancel() {
		$id_insurance = isset($_POST['id_insurance']) ? $_POST['id_insurance'] : false;
		if (!$id_insurance) {
			echo CJSON::encode(array('status' => 0, 'error-message' => 'Không có thông tin bảo hiểm cần hủy!'));
			exit;
		}

		$insurance = Insurance::model()->findByPk($id_insurance);
		if (!$insurance) {
			echo CJSON::encode(array('status' => 0, 'error-message' => 'Thông tin bảo hiểm không hợp lệ!'));
			exit;
		}

		$insurance->status = -1;
		$insurance->delete_date = date('Y-m-d H:i:s');
		$insurance->delete_author = Yii::app()->user->getState('user_id');

		if ($insurance->validate() && $insurance->save()) {
			echo CJSON::encode(array('status' => 1, 'data' => 'Hủy công nợ bảo hiểm thành công!!'));
			exit;
		}

		echo CJSON::encode(array('status' => 0, 'error-message' => 'Có lỗi xảy ra, xin vui lòng thử lại sau!'));
	}
	#endregion
}