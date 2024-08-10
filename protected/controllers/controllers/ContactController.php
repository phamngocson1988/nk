<?php

class ContactController extends HController
{
	public $layout = '//layouts/home_col1';
	
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionSendContent()
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$content = $_POST['content'];
		$command = Yii::app()->db->createCommand();
		$data = $command->insert('contact',array(
			'name'	=>$name,
			'email' => $email,
			'phone' => $phone,
			'content' => $content
		));
		if($data)
		{
			echo "Cám ơn quý khách đã góp ý! Hân hạnh phục vụ quý khách!";
		}
		else{
			echo "Không thể gửi email";
		}
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

	
}