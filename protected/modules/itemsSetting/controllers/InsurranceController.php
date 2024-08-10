<?php

class InsurranceController extends Controller{
	public $layout='/layouts/main_sup';

	public function actionView(){
		$listdata = InsurranceType::model()->searchInsurranceType();
        $this->render('view',array('listdata'=>$listdata));
	}
	public function actionList()
	{ 
	    if(isset($_REQUEST['lpp'])){
        	$lpp=$_REQUEST['lpp'];
        }else{
        	$lpp=5;
        }
        $cur_page   = $_REQUEST['cur_page']?$_REQUEST['cur_page']:1;
        $search_params = "";
        if(isset($_REQUEST['search_descriptionHeader']) && $_REQUEST['search_descriptionHeader'] !=""){
            $search_params.=" and code like '".$_REQUEST['search_descriptionHeader']."%'";
        }
		if(isset($_REQUEST['search_statusHeader']) && $_REQUEST['search_statusHeader'] !=""){
            $search_params.=" and name like '".$_REQUEST['search_statusHeader']."%'";
        }
        $listdata = InsurranceType::model()->searchInsurranceType("","",$search_params,$lpp,$cur_page);
        $this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata),false,true);
	}
	public function actionAdd()
	{ 
	    $InsurranceType = new InsurranceType;
		if(isset($_REQUEST['lpp'])){
        	$lpp=$_REQUEST['lpp'];
        }else{
        	$lpp=5;
        }
        if(isset($_POST['ajax']) && $_POST['ajax']==='addInsurrance')
		{
			echo CActiveForm::validate($InsurranceType);
			Yii::app()->end();
		}
        if(isset($_POST['InsurranceType'])){
            $InsurranceType->attributes=$_POST['InsurranceType'];
			//$InsurranceType->st = $_POST['header_status'];
			$country = InsurranceType::model()->findAll('code=:st',array(':st'=>trim($_POST['InsurranceType']['code'])));
			$country2 = InsurranceType::model()->findAll('name=:st',array(':st'=>trim($_POST['InsurranceType']['name'])));
			if($country || count($country)>0){
				echo -1;
				Yii::app()->end();
			}
			if($country2 || count($country2)>0){
				echo -2;
				Yii::app()->end();
			}
			$InsurranceType->rate_discount = 0;
            if($InsurranceType->validate()){
                if($InsurranceType->save(false)){
                    $listdata = InsurranceType::model()->searchInsurranceType();
                    $this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata),false,true);
                    Yii::app()->end();
                }
            }
        }
        $this->renderPartial('add',array('InsurranceType'=>$InsurranceType),false,true);
	}
	public function actionUpdate()
	{
        $InsurranceType = new InsurranceType;
		if(isset($_REQUEST['lpp'])){
        	$lpp=$_REQUEST['lpp'];
        }else{
        	$lpp=5;
        }
        if(isset($_POST['idhead'])){
			$InsurranceType = InsurranceType::model()->findByPk($_POST['idhead']);
        }
        if(isset($_POST['ajax']) && $_POST['ajax']==='updateInsurrance')
		{
			echo CActiveForm::validate($InsurranceType);
			Yii::app()->end();
		}
        if(isset($_POST['InsurranceType'])){
            $updateHeader = InsurranceType::model()->findByPk($_POST['headId']);
            $updateHeader->attributes = $_POST['InsurranceType'];
			$updateHeader->rate_discount = 0;
			
			$country = InsurranceType::model()->findAll('code=:st',array(':st'=>trim($_POST['InsurranceType']['code'])));
			$country2 = InsurranceType::model()->findAll('name=:st',array(':st'=>trim($_POST['InsurranceType']['name'])));
			if($country || count($country)>=2){
				echo -1;
				Yii::app()->end();
			}
			if($country2 || count($country2)>=2){
				echo -2;
				Yii::app()->end();
			}
            if($updateHeader->validate()){
                if($updateHeader->update(false)){
                    $listdata = InsurranceType::model()->searchInsurranceType();
                    $this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata),false,true);
                    Yii::app()->end();
                } 
            }
        }
        $this->renderPartial('update',array('InsurranceType'=>$InsurranceType),false,true);
    
	}
	public function actionDelete()
	{
        if(isset($_POST['idhead'])){
			//$MAboutIntro = MAboutIntro::model()->findByPk($_POST['idhead']);
			
			InsurranceType::model()->deleteInsurranceType($_POST['idhead']); 
			
			$listdata = InsurranceType::model()->searchInsurranceType();  
			$lpp=5;
			$this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata),false,true);
			Yii::app()->end(); 
        }
		
	}
	
}?>