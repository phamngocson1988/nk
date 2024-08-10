<?php

class HomeController extends HController
{
	public $layout = '//layouts/home_col1';
	public $pageOgImg =''; //images/thumnail-2000.JPG

	public function behaviors()
    {
        return array(
            'seo' => array('class' => 'ext.seo.components.SeoControllerBehavior'),
        );
    }

    public function filters()
    {
        return array(
            array('ext.seo.components.SeoFilter + view'), // apply the filter to the view-action
        );
    }
	public function actionIndex()
	{
		$data_seo = SeoData::model()->findAllByAttributes(array('name'=>'Home'));
		$data = PImages::model()->findAllByAttributes(array('id_type'=>3));
		$gioithieu = PInfrastructure::model()->findAllByAttributes(array('id_type'=>5));
	
		$this->render('index',array('data_seo'=>$data_seo,'img'=>$data,'gioithieu'=>$gioithieu));
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model =new LoginCustomerForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='frm-login-customer')
		{
			echo CActiveForm::validate($loginCustomer);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginCustomerForm']))
		{
			$model->attributes=$_POST['LoginCustomerForm'];


			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				Yii::app()->user->setState('registered', true);
				echo "success";
				Yii::app()->end();
			}
		}

		// display the login form
		//$this->redirect(Yii::app()->request->urlReferrer);
		$this->renderPartial('login-customers',array('model'=>$model));
	}
	public function actionForgetPass()
	{
		$this->renderPartial('forget-pass');
	}
	public function smtpsendmail($mailTo,$title,$AltBody,$email_content)
	{
		$mail = Yii::app()->Smtpmail;
		$mail->IsSMTP();
		$mail->Host = "mail92208.dotvndns.vn";
		$mail->Port = 465; // or 587
		$mail->SMTPDebug  = 1;
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		
		$mail->Username = "support@nhakhoa2000.vn";
		$mail->Password = "6789@abc";
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->SetFrom("info@nhakhoa2000.com",'NhaKhoa2000 Support');
		$mail->AltBody = $AltBody;
		$mail->Subject = $title;
		$mail->Body = $email_content;
		$mail->AddAddress($mailTo);
		$mail->CharSet = "utf-8";
		 if(!$mail->Send()) {
		    echo "Mailer Error: " . $mail->ErrorInfo;
		 } else {
		    echo "Chúng tôi vừa thông tin kích hoạt tài khoản vào địa chỉ ".$mailTo." ! Vui lòng vào mail kiểm tra và xác nhận";
		 }
	}
	public function actionReceivePass()
	{
		if (isset($_POST['email']) && $_POST['email']) {
			$email = $_POST['email'];
			$data = Customer::model()->findAllByAttributes(array('email'=>$email));
			if (!$data) {
				echo "1";
			}
			else{
				$activation=md5($email.time());
				$command = Yii::app()->db->createCommand();
				$data = $command->update('customer', array(
						'code_confirm'=>$activation,
						'status_confirm'=>0,
				),'email=:email',array('email'=>$_POST['email']));
				$title    = 'Xác nhận khôi phục mật khẩu tài khoản';
				//AltBody
				$AltBody ="Xác nhận khôi phục mật khẩu tài khoản!";
				//Noi dung gui mail
				$content  = $this->renderPartial('/home/receivePass',array('activation'=>$activation,'fullname'=>$data[0]['fullname'],'password'=>$_POST['pass']),true);
				$result = $this->smtpsendmail($_REQUEST['email'],$title,$AltBody,$content);
				print_r($result);
			}
			
		}
	}
	public function actionConfirmPass()
	{
		$activation = $_GET['activation'];
		$password = $_GET['passwordnew'];
		$get_confim = Customer::model()->findAllByAttributes(array('code_confirm'=>$activation));
		if ($get_confim) {
			if ($get_confim[0]['status_confirm']==1) {
				session_start();
				$_SESSION["activated"]="true";
				$this->redirect(Yii::app()->params['url_base_http']);
			}else{
				$command = Yii::app()->db->createCommand();
				$data = $command->update('customer', array(
						'status_confirm'=>1,
						'password'=>md5($password)
				),'code_confirm=:code_confirm',array('code_confirm'=>$activation));
				session_start();
				$_SESSION["activation"]="true";
				$this->redirect(Yii::app()->params['url_base_http']);
			}
		}else{
			session_start();
			$_SESSION["error_activated"]="true";
			$this->redirect(Yii::app()->params['url_base_http']);
		}
	}
	public function actionSendEmail()
	{
		$email = $_POST['email'];
		$command = Yii::app()->db->createCommand();
		$data = $command->insert('p_email',array(
			'email' => $email,
		));
		if($data)
		{
			echo "Đã nhận được Email ! Hân hạnh phục vụ quý khách!";
		}
		else{
			echo "Không thể gửi email";
		}
	}
	public function actionSearchAvatar()
	{
		$name= $_POST['current'];
		$data= PImages::model()->findAllByAttributes(array('name'=>$name,'id_type'=>7));
		if ($data) {
			print_r($data[0]['name_upload']);
			//print_r($data[0]['name_upload']);
		}
		
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{	
		Yii::app()->user->logout();
        $this->redirect(array('home/index'));
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
			else{
				if(Yii::app()->errorHandler->error['code'] == 404)
				    $this->renderPartial('404');
				else
				    $this->render('error', $error);
			}
		}
	}

	


}