<?php
class NewsController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';
	public $link = '';


	public function init() {
		$this->link = Yii::app()->params['url_base_http']."/itemsPost/news/update/id/"; 
	}

	function change_file($target,$newcopy,$w,$h,$ext)
		{
			list($w_orig,$h_orig)=getimagesize($target);
			$scale_ratio=$w_orig/$h_orig;
			if(($w/$h)>$scale_ratio)
			{
				$w=$h*$scale_ratio;
			}else
			{
				$h=$w*$scale_ratio;
			}
			$img="";
			if($ext=="png" || $ext=="PNG")
			{
				$img=imagecreatefrompng($target);
			}else
			if($ext=="gif" || $ext=="GIF")
			{
				$img=imagecreatefromgif($target);
			}else
			if($ext=="jpg" || $ext=="JPG")
			{
				$img=imagecreatefromjpeg($target);
			}
			$tci=imagecreatetruecolor($w,$h);
			$whiteBackground = imagecolorallocate($tci, 255, 255, 255);
			imagefill($tci,0,0,$whiteBackground);
			imagecopyresampled($tci,$img,0,0,0,0,$w,$h,$w_orig,$h_orig);
			imagejpeg($tci,$newcopy,80);
			
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
	            'modelName' => 'News',
	        )
	    );
	}
	public function actionAjax_news_line()
	{
	    if($_POST['idtype'])
	    {
	      $idtype = $_POST['idtype'];

	      $listnews = NewsLine::model()->findAllByAttributes(array('id_news_type'=>$idtype));

	            if($listnews){
	                echo "<option value='' selected='selected'>Select News Type</option>";
	                foreach($listnews as $temp){
	        echo '<option value="'.$temp['id'].'">'.$temp['name'].'</option>';
	                }
	            }
	            else{
	                echo "<option value=''>ALL</option>";
	            }
	    }
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
		
		$model=new News;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['News']))
		{
			$filext="";
		    $model->attributes=$_POST['News'];
		    $model->id_news_type = 1;
			$hinh=$_FILES["News_images"]["error"]==0?$_FILES["News_images"]["name"]:"";

			if($hinh != ""){
				$duoi = explode('.',$hinh);
				$filext=($duoi[1]=="png" or $duoi[1]=="PNG" or $duoi[1]=="jpg" or $duoi[1]=="JPG" or $duoi[1]=="gif" or $duoi[1]=="GIF")?$duoi[1]:"";
			}
			
			$model->id_user=Yii::app()->user->getState("user_id");
			if($filext!=""){
				$day_h =date("dmyhis");
			
			    $ten_hinh=$day_h.'.'.$filext;
				
				$m_hinh = explode('.',$hinh);

				$imageNameUpload	=	$day_h.'.'.$m_hinh[1];
				
				$fileImageUpload       = $_FILES['News_images']['tmp_name'];

				$imageUploadSource     = Yii::getPathOfAlias('webroot').'/upload/post/new/'; 

	            $resultImage = $model->saveImageScaleAndCrop($fileImageUpload,1200,600,$imageUploadSource,$imageNameUpload);
				
				if($resultImage)
					$model->image = $ten_hinh;
			}
		
			$model->createdate=date('c');
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

	   	$oldImage        = $model->image;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['News']))
		{
			$hinh=$_FILES["News_images"]["error"]==0?$_FILES["News_images"]["name"]:"";
			$model->attributes=$_POST['News'];
			$model->id_news_type = 1;
			$filext="";
			if($hinh != ""){
				$duoi = explode('.',$hinh);
				$filext=($duoi[1]=="png" or $duoi[1]=="PNG" or $duoi[1]=="jpg" or $duoi[1]=="JPG" or $duoi[1]=="gif" or $duoi[1]=="GIF")?$duoi[1]:"";
			}
			if($filext!=""){
				$day_h =date("dmyhis");
				$ten_hinh=$day_h.'.'.$filext;

				$fileImageUpload       = $_FILES['News_images']['tmp_name'];

		        $imageNameUpload       = $ten_hinh;

		        $imageUploadSource     = Yii::getPathOfAlias('webroot').'/upload/post/new/'; 

		        $resultImage = $model->saveImageScaleAndCrop($fileImageUpload,1200,900,$imageUploadSource,$imageNameUpload);

		        if($resultImage){
		            if($oldImage){
		                $model->deleteImageScaleAndCrop($oldImage);
		            }
		            $model->image = $imageNameUpload;
		        }else{
		            $model->image = "";
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
		$this->render('update',array('model'=>$model));
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
			$image =News::model()->findAll('id=:st',array(':st'=>$id));
			   if(count($image)!=0 and $image[0]['image']!=""){
				   $xoa=$image[0]['image'];
				   unlink(Yii::app()->basePath.'/../upload/post/new/lg/'.$xoa);
				   unlink(Yii::app()->basePath.'/../upload/post/new/md/'.$xoa);
				   unlink(Yii::app()->basePath.'/../upload/post/new/sm/'.$xoa);
			   }
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
		$dataProvider=new CActiveDataProvider('News');
		$this->render('index',array(
		'dataProvider'=>$dataProvider,
		));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
		$model->attributes=$_GET['News'];

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
		$model=News::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
