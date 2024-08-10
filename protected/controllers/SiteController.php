<?php

class SiteController extends HController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
    protected function beforeAction($action) {
        
        if($action->id == 'login' || $action->id == 'register' || $action->id == 'ticket' ){
                $this->layout = '//layouts/home_col1';
        }
        else{
            $this->layout = '//layouts/home_col1';
        }
        return parent::beforeAction($action);
    }

/*	public function actionTestSend(){
        $regId   = 'dLcxT0tlJMM:APA91bHNRPs-XQXCNQyCAr_o-B1zuv7AYwJZNysLMQEgNU7gXXYTsSLrbeAyTydgXYME0k6SKcNTlDTUlGOYBTjdNU39OU1NoAu30mxqgYdfttMDgjKk7hmBtR3v4gopTcX8PKlDh-3i';
        $title   = "Dat lich hen";
        $message = "Ban co lich moi tu khach hang";
        $data    = "dang cap nhat";

        $model      = new CsNotifications();
        $response   = $model->sendPush($regId,$title,$message,$data);
        var_dump($response);
    }*/

	public function actionIndex()
	{
	/*	echo "asdas";
		exit;
		$soap = new SoapService();
		$soapResult = $soap->saveTooth("2", "317db7dbff3c4e6ec4bdd092f3b220a8", "72072", "20", [{"tooth_number":"27","tooth_data":"1"}], [{"tooth_number":"27","id_image":"matnhai-8-27", "src_image":"decay-matnhai27-trongtrai.png","type_image":"matnhai","style_image":"position: absolute;top: 0;left: 0;width:100%; height: auto;"}], [{"tooth_number":"27","id_i":"ketluan-8-27", "conclude":"Mặt nhai (X)"}], [{"tooth_number":"27", "note":"Ghi chu rang 27"}]);
		echo "<pre>";
		print_r($soapResult);
		echo "</pre>";
		exit;
		$this->render('index');*/

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

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				//$this->redirect(Yii::app()->user->returnUrl);
                
                
                if(Yii::app()->user->getState('queue_login') == '1') {
			        $this->redirect(array('site/registerextension'));
			    }
                Yii::app()->user->setState('registered', true);
				$this->redirect(Yii::app()->user->returnUrl);
            }
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		$UserManager = new UserManager;
		$UserManager->saveHistoryLogout(Yii::app()->user->getState("history_login_id"));
		Yii::app()->user->logout();
		$this->redirect(array('site/login'));
	}



}