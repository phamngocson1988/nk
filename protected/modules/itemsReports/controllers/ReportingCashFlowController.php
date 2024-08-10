<?php

class ReportingCashFlowController extends Controller
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
	public function accessRules() {
		return parent::accessRules();
	}

	public function actionView() {
		$partner = Partner::model()->findAllByAttributes(array('status' => 1));
		$this->render('view', array('partner' => $partner));
	}

	public function actionTypeReport() {
		$receipt = new Receipt();
  		$listReceipt = $receipt->getFilterListReceipt(
			$_POST['from_date'], $_POST['to_date'], $_POST['pay_type'], $_POST['trans_name'], $_POST['partner']
		);
		$this->renderPartial('executive',array('listReceipt'=>$listReceipt));
	}

	public function actionExport(){
		$receipt = new Receipt();
  		$listReceipt = $receipt->getFilterListReceipt($_GET['from_date'],$_GET['to_date'],$_GET['pay_type'],$_GET['trans_name']);
		$filename = 'receipt.pdf';
        $html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);
        $html2pdf->WriteHTML($this->renderPartial('export_receipt', array('listReceipt'=>$listReceipt), true));
		$html2pdf->Output($filename, 'I');
	}

}
