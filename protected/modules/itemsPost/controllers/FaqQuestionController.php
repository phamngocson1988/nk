<?php

class FaqQuestionController extends Controller
{
    /**
    * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
    * using two-column layout. See 'protected/views/layouts/column2.php'.
    */
    public $layout='//layouts/column2';
    public $link = '';

    public function init() {
        $this->link = Yii::app()->params['url_base_http']."/itemsPost/FaqQuestion/update/id/"; 
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
                'modelName' => 'FaqQuestion',
            )
        );
    }
    
    /**
    * Manages all models.
    */
    public function actionAdmin()
    {
        $model=new FaqQuestion('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['FaqQuestion']))
        $model->attributes=$_GET['FaqQuestion'];
        $this->render('admin',array(
        'model'=>$model,
        ));
    }

    public function actionCreate()
    {
        $model=new FaqQuestion;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['FaqQuestion']))
        {
            $model->attributes=$_POST['FaqQuestion'];
            $ext         = pathinfo($_FILES['faq_img']['name'], PATHINFO_EXTENSION);
            $rnd         = date("dmYHis").uniqid();
            $newName     = $rnd.'.'.$ext;
            if($_FILES["faq_img"]["error"]==0)
            {
                move_uploaded_file($_FILES["faq_img"]["tmp_name"],"./upload/post/faq/$newName");
                $model->img     = $newName;
            }
            if($model->save()){
                echo '<script type="text/javascript">'; 
                echo 'alert("Lưu thành công");'; 
                echo 'window.location.href = "'.$this->link.$model->id.'";';
                echo '</script>';
            }
        }

        $this->render('create',array(
        'model'=>$model,
        ));
    }

    public function actionUpdate($id)
    {
        $model      = $this->loadModel($id);
        $img_old    = $model->img;

        if(isset($_POST['FaqQuestion']))
        {
            $model ->attributes = $_POST['FaqQuestion'];
            $ext     = pathinfo($_FILES['faq_img']['name'], PATHINFO_EXTENSION);
            $rnd     = date("dmYHis").uniqid();
            $newName = $rnd.'.'.$ext;
            $image   = $_FILES["faq_img"]["error"]==0?$newName:$model['img'];
            $model->img     = $image;
            if($model->save()){
                if($_FILES["faq_img"]["error"]==0)
                {
                    if($img_old != "")
                    {
                        unlink(Yii::app()->basePath.'/../upload/post/faq/'.$img_old);
                    }
                    move_uploaded_file($_FILES["faq_img"]["tmp_name"],"./upload/post/faq/$image");
                }

                echo '<script type="text/javascript">'; 
                echo 'alert("Lưu thành công");'; 
                echo 'window.location.href = "'.$this->link.$model->id.'";';
                echo '</script>';
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
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer the ID of the model to be loaded
    */
    public function loadModel($id)
    {
        $model=FaqQuestion::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='faq-question-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
