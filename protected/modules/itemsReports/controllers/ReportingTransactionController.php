<?php

class ReportingTransactionController extends Controller
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
		
		$this->render('view');

	}

	public function actionTypeReport()
	{

		$transaction_invoice = new TransactionInvoice();

  		$listTransactionInvoice = $transaction_invoice->getFilterListTransactionInvoice($_POST['lstUser'],$_POST['from_date'],$_POST['to_date'],$_POST['debt']);
  		// echo "<pre>";
  		// print_r($listTransactionInvoice);
  		// echo "</pre>";
  		// exit();
  
		$this->renderPartial('executive',array('listTransactionInvoice'=>$listTransactionInvoice));
			
	}

	public function actionExport()
	{

		$transaction_invoice = new TransactionInvoice();

  		$listTransactionInvoice = $transaction_invoice->getFilterListTransactionInvoice($_GET['lstUser'],$_GET['fromtime'],$_GET['totime'],$_GET['debt']);

		$filename   			  = 'transaction.pdf';

        $html2pdf   			  = Yii::app()->ePdf->HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 0);
        
        $html2pdf->WriteHTML($this->renderPartial('export_transaction', array('listTransactionInvoice'=>$listTransactionInvoice), true));
		
		$html2pdf->Output($filename, 'I');
	}

}
