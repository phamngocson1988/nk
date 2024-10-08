<?php

class CustomerController extends Controller
{
/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
public $layout='//layouts/column2';

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

public function actionClickToCall()
{
	$id_register = Yii::app()->user->getState('id_register');
	$phone 		 = $_REQUEST['phone'];

	if($id_register && $phone){
		$result 	 = SoapService::soap_server_ipcc('click_to_call_ws',array($id_register,$phone));
		if(is_array($result) and in_array('Success',$result)){
			echo 1;
		}else{
			echo -1;
		}
	}
}

public function actionTab()
{
	if(isset($_POST['id'])){
		$id=$_POST['id'];
	}	

	$this->renderPartial('tab',array(
		'model'=>$this->loadModel($id),
	),false,true);
}

/**
* Creates a new model.
* If creation is successful, the browser will be redirected to the 'view' page.
*/
public function actionCreate()
{
	$model=new Customer;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

	if(isset($_POST['Customer']))
	{

		$rnd = date("d-m-Y-H-i-s");	

		$model->attributes=$_POST['Customer'];
		$model->createdate      = date('Y-m-d H:i:s');

		$uploadedFile=CUploadedFile::getInstance($model,'image');
		if($uploadedFile !== null)
		{		
	$fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
	$model->image = $fileName;		
}

if($model->save())
{

	if($uploadedFile !== null)
		$uploadedFile->saveAs(Yii::app()->basePath.'/../upload/customer/'.$fileName);

	$this->redirect(array('view','id'=>$model->id));
}

}

$this->render('create',array(
	'model'=>$model,
));
}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/
public function actionUpdate($id)
{
	$model=$this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

	if(isset($_POST['Customer']))
	{

		$rnd = date("d-m-Y-H-i-s");
		$_POST['Customer']['image'] = $model->image;
		$old_image=$model->image;

		$model->attributes=$_POST['Customer'];

		$uploadedFile=CUploadedFile::getInstance($model,'image');
		if($uploadedFile !== null)
		{
$fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
$model->image = $fileName;
}
if($model->save())
{
	if(!empty($uploadedFile))  // check if uploaded file is set or not
	{	
		if($old_image!="" && $old_image!="no_image.png")
		{
			unlink(Yii::app()->basePath.'/../upload/customer/'.$old_image);
		}
		$uploadedFile->saveAs(Yii::app()->basePath.'/../upload/customer/'.$fileName);
	}
	$this->redirect(array('view','id'=>$model->id));
}
}

$this->render('update',array(
	'model'=>$model,
));
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
		$model=$this->loadModel($id);
		unlink(Yii::app()->basePath.'/../upload/customer/'.$model->image);	
// we only allow deletion via POST request
		$this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
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
	$dataProvider=new CActiveDataProvider('Customer');
	$this->render('index',array(
		'dataProvider'=>$dataProvider,
	));
}

/**
* Manages all models.
*/
public function actionAdmin()
{
	$model=new Customer('search');
$model->unsetAttributes();  // clear any default values
if(isset($_GET['Customer']))
	$model->attributes=$_GET['Customer'];

$this->render('admin',array(
	'model'=>$model,
));
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
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
	if(isset($_POST['ajax']) && $_POST['ajax']==='customer-form')
	{
		echo CActiveForm::validate($model);
		Yii::app()->end();
	}
}

}
