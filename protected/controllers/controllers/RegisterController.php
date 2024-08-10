<?php

class RegisterController extends HController
{
	public $layout = '//layouts/home_book';
	
	public function actionIndex()
	{
		$model = new Customer();
			
		if(isset($_POST['Customer'])){

			$model = $model->registerCustomer(
								array(	
										'phone'				=>$_POST['Customer']['phone'],
										'password'			=>$_POST['Customer']['password'],
										'repeatpassword'	=>$_POST['Customer']['repeatpassword'],
										'fullname' 			=>$_POST['Customer']['fullname'],
										'address'			=>$_POST['Customer']['address'],
										'email'				=>$_POST['Customer']['email'],
										'id_country'		=>$_POST['Customer']['id_country'],
										'gender'			=>$_POST['Customer']['gender'],
										'birthdate'			=>$birthdate,
										'source'			=> 0, // dang ky tu website nhakhoa2000.com
										'status'			=> 1
								));


			if($model->id){
				
				Yii::app()->user->setFlash('success');
				
				//Yii::app()->user->setState('customer_id',$model->id);
              //  echo Yii::app()->user->getFlash('success');
               // echo Yii::app()->user->getState('customer_id'); 
			}

	
		}

		$this->render('index',array('model'=>$model));
	}
	public function codesms($length) 
	{
	    $keys = array_merge(range(0,9));
	    $key = "";
	    for($i=0; $i < $length; $i++) {
	        $key .= $keys[mt_rand(0, count($keys) - 1)];
	    }
	    return $key;
	}

	public function actionRegister()
	{
	
		$model = new Customer();
		$code_sms = $this->codesms(4);
		//print_r($code);
		//exit();
		// $date=date_format(date_create($_POST['birthdate']),"Y-m-d");
		
		$date = date('Y-m-d',strtotime(str_replace('/', '-',$_POST['birthdate'])));
		//echo date_format($date,"Y/m/d H:i:s");
		if(isset($_POST['email'])){
			$test = Customer::model()->findAllByAttributes(array('email'=>$_POST['email']));
			if ($test) {
				echo  -1;
				exit();
			}
			$test_phone = $model->test_phone($_POST['phone']);

			if($test_phone == 0){
				echo -2;
				exit();
			}
			$text = 'Ma xac nhan cua ban la: ' .$code_sms;

			$send = Sms::model()->sendSms($_POST['phone'],$text,'1', '','', '','','');

			$data = $model->registerCustomer(
								array(	
										'phone'				=>$_POST['phone'],
										'password'			=>$_POST['password'],
										'repeatpassword'	=>$_POST['repeatpassword'],
										'fullname' 			=>$_POST['fullname'],
										'address'			=>$_POST['address'],
										'email'				=>$_POST['email'],
										'id_country'		=>$_POST['id_country'],
										'gender'			=>$_POST['gender'],
										'birthdate'			=>$date,
										'source'			=> 0, // dang ky tu website nhakhoa2000.com
										'status'			=> -1,
										'code_sms'			=>$code_sms,
				
								));
				$search = Customer::model()->findAllByAttributes(array('email'=>$_POST['email']));
				
			if($search){
				echo $search['0']['id'];
				exit();
			}else{
				echo "0";
				exit();
			}
			
		}
		$this->render('index',array('model'=>$model));
	}
	public function actionTestEmail(){
		if (isset($_POST['email'])) {
			$data = Customer::model()->findAllByAttributes(array('email'=>$_POST['email']));
			if ($data) {
				return 1;
			}
		}
	}
	public function actionTestWs(){

		$soap = new SoapService();		
	
	  	//$soapResult= $soap->webservice_server_ws('addMedicalHistory',array("2", "317db7dbff3c4e6ec4bdd092f3b220a8", "5", "39", "6", "6", "1", "Lấy dấu", "", "2017-02-23 10:00:00", "20", "", ""));

	  	$soapResult= $soap->webservice_server_ws('savePrescription',array("2", "317db7dbff3c4e6ec4bdd092f3b220a8", "39", "28", "Cần dùng thuốc", array("Thuốc ABC","Thuốc XYZ"), array("3","2"), array("2","2"), "", ""));
	  
		echo "<pre>";
		print_r($soapResult);
		echo "</pre>";
		exit;
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	public function actionCheckCodesms()
	{
		$id = $_POST['id'];
		$code = $_POST['code'];
		if($code !=""){
			$check = Customer::model()->checkcodesms($id,$code);
			if ($check) {
				$update = Customer::model()->updateByPk($id,array('status'=>0));
				echo 1;
				exit();
			}else{
				echo 0;
				exit();
			}

		}
	}
	public function actionSendAgain()
	{
		$id = $_POST['id'];
		$search = Customer::model()->findAllByAttributes(array('id'=>$id));

		$code_sms = $this->codesms(4);
		$text = 'Ma xac nhan cua ban la: ' .$code_sms;
		$send = Sms::model()->sendSms($search['0']['phone'],$text,'1', '','', '','','');
		$update = Customer::model()->updateByPk($id,array('code_sms'=>$code_sms));

	}
}