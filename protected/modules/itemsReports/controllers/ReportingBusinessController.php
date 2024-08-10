<?php

class ReportingBusinessController extends Controller
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

	public function actionTest(){
		echo "a";
	}

	public function actionView()
	{
		$model = new Branch();
		$this->render('view',array("model"=>$model));
	}
	public function actionGetTime()
	{
		if ($_POST['time']==1) // ngày hiện tại
		{
			$fromdate = date("d-m-Y");
			$todate= "";
		}
		else if($_POST['time']==2) // Tuần hiện tại
		{	
			$fromdate = date("d-m-Y",strtotime('monday this week'));
			$todate= date("d-m-Y",strtotime('sunday this week'));

		}
		else if($_POST['time']==3) //  tháng hiện tại
		{
		    $fromdate = date("01-m-Y", strtotime("first day of this month"));
		    $todate= date("t-m-Y", strtotime("last day of this month"));
		}
		else if($_POST['time']==4) // tháng trước
		{
			$fromdate = date("d-m-Y", strtotime('first day of last month'));
    		$todate= date("d-m-Y", strtotime('last day of last month'));
		}
		$arrayTime = array('fromdate' => $fromdate,'todate'=>$todate);
		print_r(json_encode($arrayTime));
	}
	public function actionTypeReport()
	{
		
		$branch = $_POST['branch'];
		if ($branch) 
		{
			//lấy tên cơ sở
			$dataBrach = Branch::model()->findAllByAttributes(array('id'=>$branch));
			$dataBrach = $dataBrach[0]['name'];
		}
		else {
			$dataBrach = "";
		}
		$lstUser = $_POST['lstUser'];
		if ($lstUser) {
			//lấy tên bác sĩ
			if ($branch) {
				$ListUser = GpUsers::model()->findAllByAttributes(array('id'=>$lstUser,'block'=>0,'group_id'=>3,'id_branch'=>$branch));
			}
			else{
				$ListUser = GpUsers::model()->findAllByAttributes(array('id'=>$lstUser,'block'=>0,'group_id'=>3));
			}
			
			$User = $ListUser[0]['name'];
		}
		else{
			if ($branch) {
				$ListUser = GpUsers::model()->findAllByAttributes(array('block'=>0,'group_id'=>3,' '=>$branch));
			}
			else{
				$ListUser = GpUsers::model()->findAllByAttributes(array('block'=>0,'group_id'=>3));
			}
			
			$User = "";
		}
		$fromdate = $_POST['from_date'];
		$todate = $_POST['to_date'];
		$type_time = $_POST['type_time_search'];
		$lstService = $_POST['lstService']; //search service
		$search_month = $_POST['search_month']; //search_month
		$search_year =(date('Y'));//search_year
		$datasearch = array('lstuser'=>$lstUser,'typeBranch'=>$branch,'typeTime'=>$type_time);
		
		if ($_POST['type']==0) 
		{ 
			$listStaff= VSchedule::model()->getLstStaffBussiess($lstUser,$branch,$type_time,$fromdate,$todate);
			$this->renderPartial("executive",array('fromdate'=>$fromdate, 'todate'=>$todate,'dataBrach' =>$dataBrach,'dataLstUser'=>$User,'search'=>$datasearch,'listStaff'=>$listStaff));
		}
		elseif($_POST['type']==1)
		{

			$this->renderPartial("monthly",array('fromdate'=>$fromdate, 'todate'=>$todate,'dataBrach' =>$dataBrach,'dataLstUser'=>$User,'lstUser'=>$lstUser,'type_time'=>$type_time,'id_branch'=>$branch,'search_month'=>$search_month,'search_year'=>$search_year));
		}
		elseif ($_POST['type']==2) {
			$totalSchedule=0;
			$totalService=0;
			$totalQuotation=0;
			$lstCustomer = CsSchedule::model()->getListCustomerSpend($lstUser,$branch,$type_time,$fromdate,$todate);
			if($lstCustomer)
			{
				foreach ($lstCustomer as $value) {
					$totalSchedule+=$value['totalSchedule'];
					$totalService+=$value['totalService'];
					$totalQuotation+=$value['sum_amount'];
				}
			}
				
			$dataTotal=array('total_Schedule'=>$totalSchedule,'total_Service'=>$totalService,'total_Quotation'=>$totalQuotation);
			$this->renderPartial("customerspend",array('fromdate'=>$fromdate, 'todate'=>$todate,'dataBrach' =>$dataBrach,'dataLstUser'=>$User,'search'=>$datasearch,'lstCustomer'=>$lstCustomer,'totalCustomerSpend'=>$dataTotal));
		}
		elseif ($_POST['type']==3) {
			$listService= CsService::model()->revenueService($lstUser,$branch,$type_time,$fromdate,$todate,$lstService);
			$this->renderPartial("servicerevenue",array('fromdate'=>$fromdate, 'todate'=>$todate,'dataBrach' =>$dataBrach,'dataLstUser'=>$User,'listStaff'=>$ListUser,'listService'=>$listService));
		}
		elseif($_POST['type']==4){
			$search_product 	= isset($_POST['search_product'])?$_POST['search_product']:'';
			$data = VInvoice::model()->listProductOfInvoice($lstUser,$branch,$type_time,$fromdate,$todate,$search_product);
			echo "<pre>";
			print_r($data);
			echo "</pre>";
			exit();
			$this->renderPartial("detail_search_product",array('fromdate'=>$fromdate, 'todate'=>$todate,'dataBrach' =>$dataBrach,'dataLstUser'=>$User,'listStaff'=>$ListUser));
			
		}
	}
	public function actionExport()
	{
		$search_time = isset($_GET['search_time'])?$_GET['search_time']:false;
		$fromtime = isset($_GET['fromtime'])?$_GET['fromtime']:false;
		$totime = isset($_GET['totime'])?$_GET['totime']:false;
		$search_branch = isset($_GET['branch'])?$_GET['branch']:false;
		$search_user = isset($_GET['lstUser'])?$_GET['lstUser']:false;
		$search_type = isset($_GET['type'])?$_GET['type']:false;
		$search_month = isset($_GET['search_month'])?$_GET['search_month']:false;//search_month
		$search_year =(date('Y'));//search_year
		$search_service = isset($_GET['search_service'])?$_GET['search_service']:false;//search_service
		$filename = 'Executive.pdf';
		$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);
		if ($search_type==0) {
			$listStaff= VSchedule::model()->getLstStaffBussiess($search_user,$search_branch,$search_time,$fromtime,$totime);
			$html2pdf->WriteHTML($this->renderPartial('exports_executive', array('listStaff'=>$listStaff,'branch'=>$search_branch,'user'=>$search_user,'search_time'=>$search_time,'fromtime'=>$fromtime,'totime'=>$totime), true));
		}
		else if ($search_type==1) {
			$html2pdf->WriteHTML($this->renderPartial('exports_monthly',array('id_branch'=>$search_branch,'search_user'=>$search_user,'search_time'=>$search_time,'fromtime'=>$fromtime,'totime'=>$totime,'s_month'=>$search_month,'search_year'=>$search_year), true));
		}
		else if ($search_type==2) {
			$totalSchedule=0;
			$totalService=0;
			$totalQuotation=0;
			$lstCustomer = CsSchedule::model()->getListCustomerSpend($search_user,$search_branch,$search_time,$fromtime,$totime);
			if($lstCustomer)
			{
				foreach ($lstCustomer as $value) {
					$totalSchedule+=$value['totalSchedule'];
					$totalService+=$value['totalService'];
					$totalQuotation+=$value['sum_amount'];
				}
			}
				
			$dataTotal=array('total_Schedule'=>$totalSchedule,'total_Service'=>$totalService,'total_Quotation'=>$totalQuotation);
			$html2pdf->WriteHTML($this->renderPartial('exports_customerspend', array('lstCustomer'=>$lstCustomer,'dataTotal'=>$dataTotal,'branch'=>$search_branch,'user'=>$search_user,'search_time'=>$search_time,'fromtime'=>$fromtime,'totime'=>$totime), true));
		}else if ($search_type==3) {

			$listService= CsService::model()->revenueService($search_user,$search_branch,$search_time,$fromtime,$totime,$search_service);
			$html2pdf->WriteHTML($this->renderPartial('exports_service',array('id_branch'=>$search_branch,'search_user'=>$search_user,'search_time'=>$search_time,'fromtime'=>$fromtime,'totime'=>$totime,'search_service'=>$search_service,'listService'=>$listService), true));
		}

		
		$html2pdf->Output($filename, 'I');
	}
	
	public function actionChangeBranch()
	{
		if (isset($_POST['dataBranch']) && $_POST['dataBranch']) {
			$listdata     = array();
	        $listdata[""] = "Tất cả";
	        $User         = GpUsers::model()->findAllByAttributes(array('block'=>0,'group_id'=>3,'id_branch'=>$_POST['dataBranch']));
	        foreach($User as $temp){
	            $listdata[$temp['id']] =  $temp['name'];
	        }
	        echo CHtml::dropDownList('frm_search_user_id','',$listdata,array('class'=>'form-control'));
		}
		else{
			$listdata     = array();
	        $listdata[""] = "Tất cả";
	        $User         = GpUsers::model()->findAllByAttributes(array('block'=>0,'group_id'=>3));
	        foreach($User as $temp){
	            $listdata[$temp['id']] =  $temp['name'];
	        }
	        echo CHtml::dropDownList('frm_search_user_id','',$listdata,array('class'=>'form-control'));
		}
		
	}
}
