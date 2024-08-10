<?php

class ProfileController extends HController
{
	public $layout = '//layouts/home_book';
	
	public function actionIndex()
	{
		if (yii::app()->user->getState('customer_id')) {
			
			$id_cus = yii::app()->user->getState('customer_id');
			$model  = $this->loadModel($id_cus);
			$sch    = CsSchedule::model()->getListSchedule('','','','','start_time DESC',$id_cus);
			$treatment    = Customer::model()->checkTreatment($id_cus);

			$this->render('index',array('model'=>$model,'listSch'=>$sch, 'treatment'=>$treatment));	
		}
		else{
			$this->redirect(Yii::app()->baseUrl);
		}        		
	}

	public function actionEdit_info()
	{	
		$data = Customer::model()->findbypk(yii::app()->user->getState('customer_id'));		
		if(isset($_POST['save_info']))
		{
			//$ext     = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			//$rnd     = date("dmYHis").uniqid();
			//$newName = $rnd.'.'.$ext;			
			//$image=$_FILES["image"]["error"]==0?$newName:$data['image'];			
			$fullname=$_POST['fullname'];
			$gender=$_POST['gender'];
			$birthdate=$_POST['birthdate'];
			$identity_card_number=$_POST['identity_card_number'];
			$id_country=$_POST['id_country'];
			$phone=$_POST['phone'];
			$phone=yii::app()->user->getState('customer_id')?Customer::model()->getVnPhone($phone):CsLeadCustomer::model()->getVnPhone($phone);
			$email=$_POST['email'];
			$address=$_POST['address'];
			$id_job=$_POST['id_job'];
			$position=$_POST['position'];
			$organization=$_POST['organization'];
			$note=$_POST['note'];			
			$kq=Customer::model()->update_customer_profile($fullname,$address,$phone,$email,$id_country,$gender,$birthdate,$id_job,$position,$organization,$note,$identity_card_number,yii::app()->user->getState('customer_id'));
			if($kq)
			{
				
				$this->redirect(Yii::app()->baseUrl.'/profile');
			}
			$this->redirect(Yii::app()->baseUrl.'/profile');
		}
		
	}
	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=Customer::model()->findByPk($id);		
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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

	public function actionEdit_pass(){
		if($_POST['password_old'] =='' || $_POST['password_new']=='' || $_POST['password_new_confirm']=='')
		{
			echo "0";
			exit();
		}else{
			$password_old = md5($_POST['password_old']);
			$password_new = md5($_POST['password_new']);
			$password_new_confirm = md5($_POST['password_new_confirm']);
			$data = Customer::model()->changePassword($password_old,$password_new,$password_new_confirm);
			echo $data;
		}

	}

	public function actionUpdateCustomerImage()
    {
		if(isset($_POST['id']))
		{
			$id      = $_POST['id'];
			$model   = Customer::model()->findBypk($id);		
			$ext     = pathinfo($_FILES['image123']['name'], PATHINFO_EXTENSION);
			$rnd     = date("dmYHis").uniqid();
			$newName = $rnd.'.'.$ext;
			$image   = $_FILES["image123"]["error"]==0?$newName:$model['image'];
			$kq      = Customer::model()->updateByPk($id, array('image'=>$image));	

			if($kq)
			{
				if($_FILES["image123"]["error"]==0)
				{
					if($model['image'] != "" && $model['image'] != "no_image.png" && $model['image'] != "no_avatar.png")
					{
						unlink(Yii::app()->basePath.'/../upload/customer/avatar/'.$model['image']);
					}
					move_uploaded_file($_FILES["image123"]["tmp_name"],"./upload/customer/avatar/$image");
				}

			}	

			$this->renderPartial('customer_image',array('model'=>$model),false,true);	
		}
	}

	public function actionUpdateCustomerImageDefault()
	{
		if(isset($_POST['id']))
		{
			$id      = $_POST['id'];
			$model   = Customer::model()->findBypk($id);	
			$kq      = Customer::model()->updateByPk($id, array('image'=>null));	

			if($kq)
			{
				
				if($model['image'] != "" && $model['image'] != "no_image.png" && $model['image'] != "no_avatar.png")
				{
					unlink(Yii::app()->basePath.'/../upload/customer/avatar/'.$model['image']);
				}	

			}	

			$this->renderPartial('customer_image',array('model'=>$model),false,true);	
		}
	}
	public function actionUpdateWebcamImage()
	{
		if(isset($_GET['id']))
		{
			$id      = $_GET['id'];
			$model   = Customer::model()->findBypk($id);		
			$ext     = pathinfo($_FILES['webcam']['name'], PATHINFO_EXTENSION);
			$rnd     = date("dmYHis").uniqid();
			$newName = $rnd.'.'.$ext;
			$image   = $_FILES["webcam"]["error"]==0?$newName:$model['image'];
			$kq      = Customer::model()->updateByPk($id, array('image'=>$image));	

			if($kq)
			{
				if($_FILES["webcam"]["error"]==0)
				{
					if($model['image'] != "" && $model['image'] != "no_image.png" && $model['image'] != "no_avatar.png")
					{
						unlink(Yii::app()->basePath.'/../upload/customer/avatar/'.$model['image']);
					}
					move_uploaded_file($_FILES["webcam"]["tmp_name"],"./upload/customer/avatar/$image");
				}

			}	

			$this->renderPartial('customer_image',array('model'=>$model),false,true);	
		}
	}
	public function actionDetailTreatment()
	{
		if(isset($_POST['id']) && isset($_POST['id_customer']))
		{	
			$model = Customer::model()->findByPk($_POST['id_customer']);	
			$treatment= CsMedicalHistoryGroup::model()->findByPk($_POST['id']);	
			$this->renderPartial('profile_medical_record',array(
				'model'=>$model,'treatment'=>$treatment
			),false,true);
		}
	}


	public function convert_vi_to_en($str) {
	  $str = str_replace('.','',$str);
	  $str = str_replace(' ','-',$str);
	  $str = str_replace('?','',$str);
	  $str = str_replace('"','',$str);
	  $str = str_replace(',','',$str);
	  $str = str_replace("'",'',$str);
	  $str = str_replace('!','',$str);
	  $str = str_replace(':','',$str);
	  $str = str_replace('/','',$str);
	  $str = str_replace('@','',$str);
	  $str = str_replace('$','',$str);
	  $str = str_replace('%','',$str);
	  $str = str_replace('*','',$str);
	  $str = str_replace('(','',$str);
	  $str = str_replace(')','',$str);
	  $str = str_replace('[','',$str);
	  $str = str_replace(']','',$str);
	  $str = str_replace('<','',$str);
	  $str = str_replace('>','',$str);
	  $str = str_replace('_','',$str);
	  $str = str_replace('+','',$str);
	  $str = str_replace('=','',$str);
	  $str = str_replace('#','',$str);
	  $str = str_replace('^','',$str);
	  $str = str_replace('&','',$str);
	  $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
	  $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	  $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	  $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	  $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	  $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	  $str = preg_replace("/(đ)/", 'd', $str);
	  $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
	  $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	  $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	  $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
	  $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	  $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	  $str = preg_replace("/(Đ)/", 'D', $str);
	  $str = strtolower($str); 
	  return $str;
	}
}