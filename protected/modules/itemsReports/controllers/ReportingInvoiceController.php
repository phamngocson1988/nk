<?php

class ReportingInvoiceController extends Controller
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

		$v_invoice = new VInvoice();

  		$listInvoice = $v_invoice->getFilterListInvoice($_POST['from_date'],$_POST['to_date'],'',$_POST['id_segment']);
  
		$this->renderPartial('executive',array('listInvoice'=>$listInvoice));
			
	}

	public function actionExport()
	{

		$v_invoice = new VInvoice();

  		$listInvoice = $v_invoice->getFilterListInvoice($_GET['from_date'],$_GET['to_date'],'',$_GET['id_segment']);

		$filename   			  = 'invoice.pdf';

        $html2pdf   			  = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);
        
        $html2pdf->WriteHTML($this->renderPartial('export_invoice', array('listInvoice'=>$listInvoice), true));
		
		$html2pdf->Output($filename, 'I');
	}

}
