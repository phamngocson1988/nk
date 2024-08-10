<?php 
/**
* 
*/
class ReportingOrderProductController extends Controller
{
	public $layout='/layouts/main_sup';

	public function accessRules()
	{
		return parent::accessRules();
	}

	public function actionView()
	{
		$this->render('view');
	}

	public function actionTypeReport(){
		$search_branch 	= isset($_POST['search_branch'])?$_POST['search_branch']:'';
		$search_time 	= isset($_POST['search_time'])?$_POST['search_time']:'';
		$search_product = isset($_POST['search_product'])?$_POST['search_product']:'';
		$fromtime 		= isset($_POST['fromtime'])?$_POST['fromtime']:'';
		$totime 		= isset($_POST['totime'])?$_POST['totime']:'';
		$status 		= isset($_POST['search_status'])?$_POST['search_status']:'';
		
		$data 		= VOrderDetail::model()->searchListOrderDetail($search_branch,$search_time,$search_product,$fromtime,$totime,$status);
		$count 		= $data['count'];
		$list_data 	= $data['data'];
		$this->renderPartial("view_search",array('list_data'=>$list_data,'count'=>$count));
	}

	public function actionExportPDF()
	{ 
		
		$search_branch 	= isset($_GET['branch'])?$_GET['branch']:false;
		$search_time 	= isset($_GET['search_time'])?$_GET['search_time']:false;
		$search_product = isset($_GET['product'])?$_GET['product']:false;
		$fromtime 		= isset($_GET['fromtime'])?$_GET['fromtime']:false;
		$totime 		= isset($_GET['totime'])?$_GET['totime']:false;
		$status 		= isset($_GET['status'])?$_GET['status']:false;

		$data 		= VOrderDetail::model()->searchListOrderDetail($search_branch,$search_time,$search_product,$fromtime,$totime,$status);
		$count 		= $data['count'];
		$list_data 	= $data['data'];

		$filename = 'DanhSachSanPham.pdf';
		$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);
	    $html2pdf->WriteHTML($this->renderPartial('exports', array('list_data'=>$list_data,'count'=>$count), true));
	    $html2pdf->Output($filename, 'D');
	}
	public function actionExportPrint()
	{ 
		
		$search_branch 	= isset($_GET['branch'])?$_GET['branch']:false;
		$search_time 	= isset($_GET['search_time'])?$_GET['search_time']:false;
		$search_product = isset($_GET['product'])?$_GET['product']:false;
		$fromtime 		= isset($_GET['fromtime'])?$_GET['fromtime']:false;
		$totime 		= isset($_GET['totime'])?$_GET['totime']:false;
		$status 		= isset($_GET['status'])?$_GET['status']:false;

		$data 		= VOrderDetail::model()->searchListOrderDetail($search_branch,$search_time,$search_product,$fromtime,$totime,$status);
		$count 		= $data['count'];
		$list_data 	= $data['data'];

		$filename = 'DanhSachSanPham.pdf';
		$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);
	    $html2pdf->WriteHTML($this->renderPartial('exports', array('list_data'=>$list_data,'count'=>$count), true));
	    $html2pdf->Output($filename, 'I');
	}
	
}