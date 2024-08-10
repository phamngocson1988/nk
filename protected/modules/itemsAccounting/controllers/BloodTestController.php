<?php

class BloodTestController extends Controller
{
    public function actionIndex() {
        $this->render('view_customer');
    }

    #region --- INIT
    public function init() {
        Yii::app()->setComponents(
            array('messages' => array(
                'class' => 'CPhpMessageSource',
                'basePath' => 'protected/modules/itemsAccounting/messages',
            ))
        );
    }
    #endregion

    #region --- TAB CHI PHI XET NGHIEM BEN TAB KHACH HANG
	public function actionLoadTabBloodTest() {
        $id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : false;
        if (!$id_customer) {
            echo ""; exit;
        }

        $this->renderPartial('customer_view', array('id_customer' => $id_customer));
    }
    #endregion

    #region --- TAB DANH SACH CHI PHI XET NGHIEM BEN KHACH HANG
	public function actionLoadTabList() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 15;
        $dataSearch = isset($_POST) ? $_POST : array();

        if (!isset($dataSearch['id_customer'])) {
            echo ""; exit;
        }

		$bloodTest = BloodTest::model()->getList($page, $limit, $dataSearch);
        $page_list = VQuotations::model()->paging($page, $bloodTest['count'], $limit, 'bloodTestPaging', '');

        $this->renderPartial('customer_list', array('bloodTest' => $bloodTest, 'page_list' => $page_list));
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
            'select' => 'id, code_number, fullname',
            'condition' => "id = $id_customer"
        ));

        if (!$customerObj) {
            echo ""; exit;
        }

        $customer = array(
            'id_customer' => $customerObj->id,
            'code_number' => $customerObj->code_number,
            'fullname' => $customerObj->fullname,
        );

        $this->renderPartial('customer_create', array('customer' => $customer));
	}
	#endregion

    #region --- TAO MOI - THAO TAC
	public function actionAdd() {
		$data = isset($_POST) ? $_POST : array();
		$bloodTest = BloodTest::model()->addBloodTest($data);
		echo CJSON::encode($bloodTest);
	}
	#endregion

    #region --- IN
    public function actionPrint() {
        $id = isset($_GET['id']) ? $_GET['id'] : false;
        $id_customer = isset($_GET['idc']) ? $_GET['idc'] : false;
        $lang = isset($_GET['lang']) ? $_GET['lang'] : 'vi';

        if (!$id || !$id_customer) {
            echo 'Thông tin không hợp lệ';
            exit;
        }

        $bloodTest = BloodTest::model()->find(array(
            'select' => 'create_date, amount, id_author, type',
            'condition' => "id = $id AND id_customer = $id_customer"
        ));

        if (!$bloodTest) {
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
            'condition' => "id = " . $bloodTest->id_author
        ));

        if (!$author) {
            echo 'Thông tin không hợp lệ';
            exit;
        }

        $filename = 'ChiPhiXetNghiemMau.pdf';

        $html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A5', 'en', true, 'UTF-8');

        $html2pdf->pdf->SetTitle('Chi phí xét nghiệm máu');
        Yii::app()->setLanguage($lang);

        $html2pdf->WriteHTML($this->renderPartial('print', array('bloodTest' => $bloodTest, 'customer' => $customer, 'author' => $author), true));
        $html2pdf->Output($filename, 'I');
    }
    #endregion
}