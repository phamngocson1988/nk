<?php
class AdvertiseController extends Controller
{	
	public $link = '';

	public function init() {
		$this->link = Yii::app()->params['url_base_http']."/itemsPost/advertise/update/id/";
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
		imagecopyresampled($tci,$img,0,0,0,0,$w,$h,$w_orig,$h_orig);
		imagejpeg($tci,$newcopy,80);
		
	}
	public $layout='//layouts/column2';
	public function filters()
	{
		return array('accessControl');
	}

	public function accessRules()
	{
		return parent::accessRules();
	}

	public function actionView($id)
	{
		$this->render('view',array('model'=>$this->loadModel($id),));
	}
	public function actionCreate()
	{
		$model=new Advertise;
		if(isset($_POST['Advertise']))
		{
			$filext="";
		    $model->attributes=$_POST['Advertise'];

			$hinh=$_FILES["Advertise_images"]["error"]==0?$_FILES["Advertise_images"]["name"]:"";
			if($hinh != ""){
				$filext  = pathinfo($_FILES['Advertise_images']['name'], PATHINFO_EXTENSION);
			}
			if($filext!=""){
				$day_h =date("dmyhis");
				$ten_hinh=$day_h.'.'.$filext;
				$kq=move_uploaded_file($_FILES["Advertise_images"]["tmp_name"],"upload/post/slider/lg/$ten_hinh");
				
				$img = new SimpleImage("upload/post/slider/lg/$ten_hinh");
				$width=ceil($img->getWidth()/2);
				$height=ceil($img->getHeight()/2);
				$img->resize($width,$height);
				$img->save("upload/post/slider/md/$ten_hinh");	
				
				$img = new SimpleImage("upload/post/slider/md/$ten_hinh");
				$width=ceil($img->getWidth()/2);
				$height=ceil($img->getHeight()/2);
				$img->resize($width,$height);
				$img->save("upload/post/slider/sm/$ten_hinh");
				
				$model->image= $ten_hinh;
			}
			
			if($model->save()){
				echo '<script type="text/javascript">'; 
				echo 'alert("Lưu thành công");'; 
				echo 'window.location.href = "'.$this->link.$model->id.'";';
				echo '</script>';
				//$this->redirect(array('view','id'=>$model->id));
			}
		}
		$this->render('create',array('model'=>$model,));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Advertise']))
		{
		    $hinh=$_FILES["Advertise_images"]["error"]==0?$_FILES["Advertise_images"]["name"]:"";
			$model->attributes=$_POST['Advertise'];
			$filext="";
			if($hinh != ""){
				$filext  = pathinfo($_FILES['Advertise_images']['name'], PATHINFO_EXTENSION);
			}
		    if($filext!=""){
				
				$day_h =date("dmyhis");
				$ten_hinh=$day_h.'.'.$filext;
				$kq=move_uploaded_file($_FILES["Advertise_images"]["tmp_name"],"upload/post/slider/lg/$ten_hinh");
				
				$img = new SimpleImage("upload/post/slider/lg/$ten_hinh");
				$width=ceil($img->getWidth()/2);
				$height=ceil($img->getHeight()/2);
				$img->resize($width,$height);
				$img->save("upload/post/slider/md/$ten_hinh");	
				
				$img = new SimpleImage("upload/post/slider/md/$ten_hinh");
				$width=ceil($img->getWidth()/2);
				$height=ceil($img->getHeight()/2);
				$img->resize($width,$height);
				$img->save("upload/post/slider/sm/$ten_hinh");
				
				$model->image= $ten_hinh;
			
				$xoa_hinh =isset($_POST['image_name'])?$_POST['image_name']:"";
				if($xoa_hinh!=""){
				   unlink("upload/post/slider/lg/$xoa_hinh");
				   unlink("upload/post/slider/md/$xoa_hinh");
				   unlink("upload/post/slider/sm/$xoa_hinh");
				}
			}
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

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
		    $image =Advertise::model()->findAll('id=:st',array(':st'=>$id));
		    if(count($image)!=0 and $image[0]['image']!=""){
			   $xoa=$image[0]['image'];
			   unlink(Yii::app()->basePath.'/../upload/post/slider/lg/'.$xoa);
			   unlink(Yii::app()->basePath.'/../upload/post/slider/md/'.$xoa);
			   unlink(Yii::app()->basePath.'/../upload/post/slider/sm/'.$xoa);
		    } 
		    $this->loadModel($id)->delete();
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Advertise');
		$this->render('index',array('dataProvider'=>$dataProvider,));
	}

	public function actionAdmin()
	{
		$model=new Advertise('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Advertise']))
		$model->attributes=$_GET['Advertise'];

		$this->render('admin',array('model'=>$model,)); 
	}

	public function loadModel($id)
	{
		$model=Advertise::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
			return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='advertise-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
