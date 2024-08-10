<?php

class DepositController extends Controller
{
    public function actionIndex() {
        $this->render('view_customer');
    }

    public function init()
    {
        Yii::app()->setComponents(
            array('messages' => array(
                'class' => 'CPhpMessageSource',
                'basePath' => 'protected/modules/itemsAccounting/messages',
            ))
        );
    }

    #region --- TAB DEPOSIT BEN KHACH HANG
	public function actionLoadTabDeposit() {
        $id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : false;
        if (!$id_customer) {
            echo ""; exit;
        }

        $this->renderPartial('customer_view', array('id_customer' => $id_customer));
    }
    #endregion

    #region --- TAB DANH SACH DEPOSIT BEN KHACH HANG
	public function actionLoadTabList() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 15;
        $dataSearch = isset($_POST) ? $_POST : array();

        if (!isset($dataSearch['id_customer'])) {
            echo ""; exit;
        }

		$deposit = DepositTransaction::model()->getList($page, $limit, $dataSearch);
        $page_list = VQuotations::model()->paging($page, $deposit['count'], $limit, 'depositPaging', '');

        $sum_deposit = Customer::model()->find(array(
            'select' => 'deposit',
            'condition' => 'id = ' .$dataSearch['id_customer']
        ));

        $this->renderPartial('customer_list', array('deposit' => $deposit, 'sum_deposit' => $sum_deposit->deposit, 'page_list' => $page_list));
    }
    #endregion

    #region --- TAO MOI - GIAO DIEN
	public function actionUpdateLayout() {
        $id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : false;
        if (!$id_customer) {
            echo ""; exit;
        }

        $customer = array();
        $customerObj = Customer::model()->find(array(
            'select' => 'id, code_number, fullname, deposit',
            'condition' => "id = $id_customer"
        ));

        if (!$customerObj) {
            echo ""; exit;
        }

        $customer = array(
            'id_customer' => $customerObj->id,
            'code_number' => $customerObj->code_number,
            'fullname' => $customerObj->fullname,
            'deposit' => $customerObj->deposit,
        );

        $this->renderPartial('customer_create', array('customer' => $customer));
	}
	#endregion

    #region --- TAO MOI - THAO TAC
	public function actionUpdate() {
		$data = isset($_POST) ? $_POST : array();
		$deposit = DepositTransaction::model()->updateCustomerDeposit($data);
		echo CJSON::encode($deposit);
	}
	#endregion

    #region --- IN
    public function actionPrintDeposit() {
        $id = isset($_GET['id']) ? $_GET['id'] : false;
        $id_customer = isset($_GET['idc']) ? $_GET['idc'] : false;
        $lang = isset($_GET['lang']) ? $_GET['lang'] : 'vi';

        if (!$id || !$id_customer) {
            echo 'Thông tin không hợp lệ';
            exit;
        }

        $deposit = DepositTransaction::model()->find(array(
            'select' => 'create_date, amount, id_author, type',
            'condition' => "id = $id AND id_customer = $id_customer"
        ));

        if (!$deposit) {
            echo 'Thông tin không hợp lệ';
            exit;
        }

        $customer = Customer::model()->find(array(
            'select' => 'fullname',
            'condition' => "id = $id_customer"
        ));

        if (!$customer) {
            echo 'Thông tin không hợp lệ';
            exit;
        }

        $author = GpUsers::model()->find(array(
            'select' => 'name',
            'condition' => "id = " . $deposit->id_author
        ));

        if (!$author) {
            echo 'Thông tin không hợp lệ';
            exit;
        }

        $filename = 'DatCoc.pdf';

        $html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A5', 'en', true, 'UTF-8');

        $html2pdf->pdf->SetTitle('Biên nhận');
        Yii::app()->setLanguage($lang);

        $html2pdf->WriteHTML($this->renderPartial('print_deposit', array('deposit' => $deposit, 'customer' => $customer, 'author' => $author), true));
        $html2pdf->Output($filename, 'I');
    }
    #endregion
}