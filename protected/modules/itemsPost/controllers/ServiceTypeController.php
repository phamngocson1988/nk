<?php
class ServiceTypeController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';
	public $link = '';

	public function init() {
        $this->link = Yii::app()->params['url_base_http']."/itemsPost/serviceType/update/id/"; 
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
		$_SESSION['KCFINDER']['uploadDir'] = Yii::app()->basePath."/../upload_post/"; // path to the uploads folder

		$model=new ServiceType;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['ServiceType']))
		{
			$filext="";
			$hinh=$_FILES["ServiceType_image"]["error"]==0?$_FILES["ServiceType_image"]["name"]:"";
			$model->attributes=$_POST['ServiceType'];
			if($hinh != ""){
			$duoi = explode('.',$hinh);
			$filext=($duoi[1]=="png" or $duoi[1]=="PNG" or $duoi[1]=="jpg" or $duoi[1]=="JPG" or $duoi[1]=="gif" or $duoi[1]=="GIF")?$duoi[1]:"";
			}

			if($filext!=""){
				$day_h =date("dmyhis");
			    $ten_hinh=$day_h.'.'.$filext;
				$m_hinh = explode('.',$hinh);
				$ten_hinh=$day_h.'.'.$m_hinh[1];
				
				move_uploaded_file($_FILES["ServiceType_image"]["tmp_name"],"upload/post/serviceType/lg/$ten_hinh");
				
				$img = new SimpleImage("upload/post/serviceType/lg/$ten_hinh");
				$width=ceil($img->getWidth()/2);
				$height=ceil($img->getHeight()/2);
				$img->maxareafill($width,$height,255,255,255);
				$img->save("upload/post/serviceType/md/$ten_hinh");	
				
				$img = new SimpleImage("upload/post/serviceType/md/$ten_hinh");
				$width=ceil($img->getWidth()/2);
				$height=ceil($img->getHeight()/2);
				$img->maxareafill($width,$height,255,255,255);
				$img->save("upload/post/serviceType/sm/$ten_hinh");
				$model->image=$ten_hinh;
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
	    $_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
		$_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl."/upload_post/"; // URL for the uploads folder
		$_SESSION['KCFINDER']['uploadDir'] = Yii::app()->basePath."/../upload_post/"; // path to the uploads
		$model=$this->loadModel($id);
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['ServiceType']))
		{
			$hinh=$_FILES["ServiceType_image"]["error"]==0?$_FILES["ServiceType_image"]["name"]:"";
			$model->attributes=$_POST['ServiceType'];
			$filext="";
			if($hinh!=""){
				$day_h =date("dmyhis");
				$m_hinh = explode('.',$hinh);
				$ten_hinh=$day_h.'.'.$m_hinh[1];
				move_uploaded_file($_FILES["ServiceType_image"]["tmp_name"],"upload/post/serviceType/lg/$ten_hinh");
				
				$img = new SimpleImage("upload/post/serviceType/lg/$ten_hinh");
				$width=ceil($img->getWidth()/2);
				$height=ceil($img->getHeight()/2);
				$img->maxareafill($width,$height,255,255,255);
				$img->save("upload/post/serviceType/md/$ten_hinh");	
				
				$img = new SimpleImage("upload/post/serviceType/md/$ten_hinh");
				$width=ceil($img->getWidth()/2);
				$height=ceil($img->getHeight()/2);
				$img->maxareafill($width,$height,255,255,255);
				$img->save("upload/post/serviceType/sm/$ten_hinh");
				
				$model->image=$ten_hinh;
				$xoa_hinh =isset($_POST['image_name'])?$_POST['image_name']:"";
				
				if($xoa_hinh!=""){
					unlink("upload/post/serviceType/lg/$xoa_hinh");
					unlink("upload/post/serviceType/md/$xoa_hinh");
					unlink("upload/post/serviceType/sm/$xoa_hinh");
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
		   $image =ServiceType::model()->findAll('id=:st',array(':st'=>$id));
		   if(count($image)!=0 and $image[0]['image']!=""){
			   $xoa=$image[0]['image'];
			   unlink(Yii::app()->basePath.'/../upload/post/serviceType/lg/'.$xoa);
			   unlink(Yii::app()->basePath.'/../upload/post/serviceType/md/'.$xoa);
			   unlink(Yii::app()->basePath.'/../upload/post/serviceType/sm/'.$xoa);
			   //unlink("upload/post/promotion/$xoa");
		   }
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
		$dataProvider=new CActiveDataProvider('ServiceType');
		$this->render('index',array(
		'dataProvider'=>$dataProvider,
		));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		
		$model=new ServiceType('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['ServiceType']))
		   $model->attributes=$_GET['ServiceType'];
		
		$this->render('admin',array('model'=>$model),false,true);
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=ServiceType::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionBlock_Toggle()
	    {
			
	        $model = $this->loadModel($id);
	        // Uncomment the following line if AJAX validation is needed
	        // $this->performAjaxValidation($model);
	        
	        if (isset($_POST['ServiceType'])) {
	            $model->attributes = $_POST['ServiceType'];
	            if ($model->save())
	            {
	                $this->renderPartial('admin', array( 'model' => $model),false,true);
	            }
	        }
	        
	        $this->render('update', array(
	            'model' => $model
	        ));
	    }
	public function actionToggleBlock()
	    {
	        echo "asdasd";exit;
	    }

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='service-type-form')
		{
		echo CActiveForm::validate($model);
		Yii::app()->end();
		}
	}
}
