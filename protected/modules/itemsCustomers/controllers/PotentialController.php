<?php

class PotentialController extends Controller
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

public function actionAdd()
{

if(isset($_POST['customerNewName']) && isset($_POST['customerNewPhone']))
	{	
		//$phone=$customer->getVnPhone($_POST['customerNewPhone']);
		
		$fullname = $_POST['customerNewName'];
		$data = CustomerLead::model()->addlead(array(
			'username'=>'',
			'password'=>'',
			'repeatpassword'=>'',
			'fullname'=>$fullname, 
			'address'=>'', 
			'phone'=>$_POST['customerNewPhone'],
			'phone_sms'=>'', 
			'email'=>'',
			'image'=>'', 
			'id_country'=>'',
			'id_city'=>'',
			'id_state'=>'' ,
			'id_source'=>'' ,
			'gender'=>'', 
			'birthdate'=>'', 
			'status'=>'0', 
			'identity_card_number'=>'',
			'id_fb'=>'', 
			'name_fb'=>'',
			'id_gg'=>'',
			'name_gg'=>'',
			));
		
		echo $data['status'];
		exit;	
	}
}
public function actionaddschedule(){
		$user = Yii::app()->user->getState('user_id');
		$model = new CsLeadActivity;
		$cuslead = new CustomerLead;
		$data = CustomerLead::model()->findAllByAttributes(array("id_customer"=>$_POST['id_cus']));
		$date_activity =strtotime($_POST['date_schedule'])  ;
		$id_lead = $data[0]->id;
		$datetime = date("Y-m-d H:i:s",$date_activity );
		
		if(isset($_POST['note']))
		{

			$model->note = $_POST['note'];
			$model->id_user = $user;
			$model->id_customer = $_POST['id_cus'];
			$model->id_lead = $data[0]->id_lead;
			$model->activity_date = $datetime;
			$model->date = date("Y-m-d H:i:s");
			$model->insert();
			$kq=CustomerLead::model()->updateByPk($id_lead, array('schedule_date'=>$datetime));	
			$note = $datetime."/".$_POST['note'];
			$data = CustomerNote::model()->addnote(array(
				'note'=>$note,
				'id_user'=>$user,
				'id_customer'=>$_POST['id_cus'],
				'flag'=>'5',
				'important'=>'',
				'status'=>'1'

				));
			echo $data['id_customer'];
			exit();
		}
		echo "-1";
		exit();
		
	}


public function actionUpdateCustomerImage()
{
	if(isset($_POST['id']))
	{
		$id=$_POST['id'];
		$data=Customer::model()->findBypk($id);
		$rnd = date("d-m-Y-H-i-s");			
		$image=$_FILES["image123"]["error"]==0?"{$rnd}-{$_FILES["image123"]["name"]}":$data['image'];
		$kq=Customer::model()->updateByPk($id, array('image'=>$image));	
		if($kq)
		{
			if($_FILES["image123"]["error"]==0)
			{
				if($data['image']!="" && $data['image']!="no_image.png" && $data['image']!="no_avatar.png")
				{
					unlink(Yii::app()->basePath.'/../upload/customer/avatar/'.$data['image']);
				}
				move_uploaded_file($_FILES["image123"]["tmp_name"],"./upload/customer/avatar/$image");
			}

		}	
		$model=Customer::model()->findBypk($id);
		$this->renderPartial('customer_image',array('model'=>$model),false,true);	
	}
}

public function actionUpdateCustomer()
{
	if(isset($_POST['id']))
	{
		$id=$_POST['id'];
		$fullname=$_POST['fullname'];
		$email=$_POST['email'];
		$phone=Customer::model()->getVnPhone($_POST['phone']);
		$gender=$_POST['gender'];
		$birthdate=$_POST['birthdate'];
		$identity_card_number=$_POST['identity_card_number'];
		$id_country=$_POST['id_country'];
		/*$id_job=$_POST['id_job'];
		$position=$_POST['position'];*/
		$organization=$_POST['organization'];
		$address=$_POST['address'];
		$data = CustomerLead::model()->updateCustomer($id,$fullname,$email,$phone,$gender,$birthdate,$identity_card_number,$id_country,$organization,$address);
		echo $data;
		exit();
	}

}

public function actionAdmin()
{

	$model = new Customer;
	$codeNumberExp = Yii::app()->user->getState('user_branch') . Customer::model()->getCodeNumberCustomer();

	$this->render('admin',array(
		'model'=>$model,
		'codeNumberExp' => $codeNumberExp,
	));
}

public function actionSearchCustomers()
{

	$model 		   = new CustomerLead;
	$cur_page      = isset($_POST['cur_page'])?$_POST['cur_page']:1;
	$lpp           = 20;
	$search_params = '';
	//$orderBy 	   = '`schedule_date` ASC ';

	if($_POST['type'] == 4){
		$orderBy = '`code_number` DESC ';
	}

	if ($_POST['value']) 
	{
		$search_params= 'AND (`fullname` LIKE "%'.$_POST['value'].'%" ) OR (`code_number` LIKE "%'.$_POST['value'].'%" )';
	}

	if (Yii::app()->user->getState('group_id') != 1) {
		$search_params .= " AND (id_branch = ".Yii::app()->user->getState('user_branch').") "; 
	}
	
	$data  = $model->searchOpportunity('','',' '.$search_params,$lpp,$cur_page);
	if($cur_page > $data['paging']['cur_page']){	
		echo '<script>stopped = true; </script>';	
		exit;
	}

	$this->renderPartial('search_sort',array('list_data'=>$data,'page'=>$data['paging']['cur_page']));

}

public function actionDetailCustomer()
{
	$model = new Customer();

	if(isset($_POST['id']))
	{
		$model 	= $model->findByPk($_POST['id']);	
	}
	$this->renderPartial('customer_info',array(
			'model'=>$model
	),false,false);
}
public function actionDetailhoatdong()
{
	$model = new CsLeadActivity();

	if(isset($_POST['id']))
	{
		$data 	= $_POST['id'];	
	}

		$this->renderPartial('chitiethoatdong',array(
			'id'=>$data
	),false,false);

}
	public function actionUpdateStatusCustomer(){
		if (isset($_POST['id_customer']) && isset($_POST['code_number'])) {

			$id_customer=$_POST['id_customer'];
			$code_number = $_POST['code_number'];
			
			$data = Customer::model()->updateToCustomer($id_customer,$code_number);
			echo  $data;
		}
	}

	public function actionGetCustomerList() {
		$model 		   = new CustomerLead;
		$cur_page      = isset($_POST['page'])?$_POST['page']:1;
		$search 	   = isset($_POST['q'])?$_POST['q']:1;	 
		$lpp           = 20;
		$search_params = '';
		if (date_create_from_format('d/m/Y', $search)) {
			$search_params = 'AND (`birthdate` = "' . date_format(date_create_from_format('d/m/Y', $search), 'Y-m-d') . '")';
		} else {
			$search_params= 'AND ((`fullname` LIKE "%'.$search.'%") OR (`phone` LIKE "%'.$search.'%") OR (`code_number` LIKE "%'.$search.'%"))';
		}
		if (Yii::app()->user->getState('group_id') != 1) {
			$search_params .= " AND (id_branch = ".Yii::app()->user->getState('user_branch').") "; 
		}
		$item = 50;
		$customerList  = $model->searchOpportunity('','',' '.$search_params,$lpp,$cur_page);
		$customer = array();
		if($customerList && $customerList['data']) {
			foreach ($customerList['data'] as $key => $value) {
				$customer[] = array(
					'id' => $value['id'],
					'text' => $value['fullname'],
					'birthdate' => $value['birthdate'],
					'phone' => $value['phone'],
					'address' => $value['address']
				);
			}
		}
		echo json_encode($customer);
	}
}

