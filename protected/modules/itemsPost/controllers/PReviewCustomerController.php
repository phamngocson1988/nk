<?php

class PReviewCustomerController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';
	public $link = '';

	public function init() {
        $this->link = Yii::app()->params['url_base_http']."/itemsPost/PReviewCustomer/update/id/"; 
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
	public function actions()
	{	
	    return array(
	        'toggle' => array(
	            'class'=>'booster.actions.TbToggleAction',
	            'modelName' => 'PReviewCustomer',
	        )
	    );
	}
	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{

		$model=new PReviewCustomer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PReviewCustomer']))
		{

			$model->attributes=$_POST['PReviewCustomer'];
			if($_FILES['PReviewCustomer'] && $_FILES['PReviewCustomer']['error']["r_img"] == 0)
			{
	            $model->r_img    = $_FILES['PReviewCustomer'];
	        }
	        if($_FILES['PReviewCustomer']['error']["r_img"] == 0)
		    {


		        $fileImageUpload       = $_FILES['PReviewCustomer']['tmp_name']['r_img'];

		        
		        $fileTypeUpload        = explode('/',$_FILES['PReviewCustomer']["type"]["r_img"]);

		        $imageNameUpload       = date("dmYHis").'.'.$fileTypeUpload[1];

		        $imageUploadSource     = Yii::getPathOfAlias('webroot').'/upload/post/review/'; 

		        
		        $resultImage = $model->saveImageScaleAndCrop($fileImageUpload,500,500,$imageUploadSource,$imageNameUpload);

		        $model->r_img          = Null;
		        
		        if($resultImage){
		            $model->r_img = $imageNameUpload;
		        } 

		    }
			if($model->save()){
                echo '<script type="text/javascript">'; 
                echo 'alert("Lưu thành công");'; 
                echo 'window.location.href = "'.$this->link.$model->id.'";';
                echo '</script>';
        		//$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['PReviewCustomer']))
		{
			$oldImage        = $model->r_img;
			$model->attributes=$_POST['PReviewCustomer'];
			if($_FILES['PReviewCustomer'] && $_FILES['PReviewCustomer']['error']["r_img"] == 0){
	        	$model->r_img    = $_FILES['PReviewCustomer'];
	    	}
	    	if($_FILES['PReviewCustomer']['error']["r_img"] == 0){

	            $fileImageUpload       = $_FILES['PReviewCustomer']['tmp_name']['r_img'];
	            $fileTypeUpload        = explode('/',$_FILES['PReviewCustomer']["type"]["r_img"]);
	            
	            $imageNameUpload       = date("dmYHis").'.'.$fileTypeUpload[1];
	            $imageUploadSource     = Yii::getPathOfAlias('webroot').'/upload/post/review/'; 

	            $resultImage = $model->saveImageScaleAndCrop($fileImageUpload,500,500,$imageUploadSource,$imageNameUpload);

	            if($resultImage){
	                if($oldImage){
	                    $model->deleteImageScaleAndCrop($oldImage);
	                }
	                $model->r_img = $imageNameUpload;
	            }else{
	                $model->r_img = "";
	            }    

	    	}
			if($model->save()){
                echo '<script type="text/javascript">'; 
                echo 'alert("Lưu thành công");'; 
                echo 'window.location.href = "'.$this->link.$model->id.'";';
                echo '</script>';
        		//$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('PReviewCustomer');
		$this->render('index',array(
		'dataProvider'=>$dataProvider,
		));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new PReviewCustomer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PReviewCustomer']))
		$model->attributes=$_GET['PReviewCustomer'];

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
		$model=PReviewCustomer::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='preview-customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
