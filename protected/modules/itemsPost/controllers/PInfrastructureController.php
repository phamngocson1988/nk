<?php

class PInfrastructureController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';
	public $link = '';

	public function init() {
		$this->link = Yii::app()->params['url_base_http']."/itemsPost/PInfrastructure/update/id/"; 
	}

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

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionView($id)
	{
		$this->render('view',array(
		'model'=>$this->loadModel($id),
		));
	}

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{
		$_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
		$_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl."/upload_post/"; // URL for the uploads folder
		$_SESSION['KCFINDER']['uploadDir'] = Yii::app()->basePath."/../upload_post/"; // path to the uploads
		$model=new PInfrastructure;
		if(isset($_POST['PInfrastructure']))
		{
			$model->attributes=$_POST['PInfrastructure'];
			
			if($model->save()){
                echo '<script type="text/javascript">'; 
                echo 'alert("Lưu thành công");'; 
                echo 'window.location.href = "'.$this->link.$model->id.'";';
                echo '</script>';
        		//$this->redirect(array('admin','id'=>$model->id));
            }
		}

		$this->render('create',array('model'=>$model,));
	}

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
		$_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl."/upload_post/"; // URL for the uploads folder
		$_SESSION['KCFINDER']['uploadDir'] = Yii::app()->basePath."/../upload_post/"; // path to the uploads
			
		if(isset($_POST['PInfrastructure']))
		{
			$model->attributes=$_POST['PInfrastructure'];
			if($model->save()){
                echo '<script type="text/javascript">'; 
                echo 'alert("Lưu thành công");'; 
                echo 'window.location.href = "'.$this->link.$id.'";';
                echo '</script>';
                //$this->redirect(array('view','id'=>$model->id));
            }
		}

		$this->render('update',array('model'=>$model,));
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PInfrastructure');
		$this->render('index',array('dataProvider'=>$dataProvider,));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new PInfrastructure('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PInfrastructure']))
		$model->attributes=$_GET['PInfrastructure'];
		$this->render('admin',array('model'=>$model,));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=PInfrastructure::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pinfrastructure-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
