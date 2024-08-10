<?php

class TimeKeepingController extends Controller
{
	public $layout='/layouts/main_sup';

	public function actionView()
	{
		$CsServiceTypeTk = CsServiceTypeTk::model()->findAll('st=:st',array(':st'=>1));
		$model 		   = new GpUsers;
		$cur_page      = 1;
		$lpp           = 200;
		$search_params = ' and group_id = 3 ';
		$orderBy 	   = '`name` ASC ';
		$id = 1 ;
		$data  = $model->searchStaffs('','',' '.$search_params.' order by '.$orderBy,$lpp,$cur_page);
		$this->render('view',array('id_user'=>$id,'list_data'=>$data,'CsServiceTypeTk'=>$CsServiceTypeTk));
	}
	public function actionSearchList()
	{
		$CsServiceTypeTk = CsServiceTypeTk::model()->findAll('st=:st',array(':st'=>1));
		$model 		   = new GpUsers;
		$cur_page      = 1;
		$lpp           = 200;
		$search_params = ' and group_id = 3 ';
		$orderBy 	   = '`name` ASC ';
		if($_POST['type'] == 1 && $_POST['value']){
			$search_params= 'AND (`name` LIKE "%'.$_POST['value'].'%" )';
		}
		if($_POST['type']== 4 && $_POST['value']){
			$search_params= 'AND (`code` LIKE "%'.$_POST['value'].'%" )';
			$orderBy = '`code` DESC ';
		}
		if($_POST['group_id']==3){
			$search_params.= 'AND (`id`='.$_POST["id_user"].')';
		}
		if($_POST['type'] == 1){
			$orderBy 	   = ' `name` ASC ';
		}else if($_POST['type'] == 2){
			$orderBy = ' `id` DESC ';
		}

		if ($_POST['id_branch']) 
		{
			$search_params .= ' AND (`id_branch` LIKE "%'.$_POST['id_branch'].'%" ) ';
		}

		if ($_POST['id_group']) 
		{
			$search_params .= ' AND (`group_id` LIKE "%'.$_POST['id_group'].'%" ) ';
		}

		if ($_POST['book_onl'] >= 0) 
		{
			$search_params .= ' AND (`book_onl` LIKE "%'.$_POST['book_onl'].'%" ) ';
		}

		if ($_POST['block'] >= 0) 
		{
			$search_params .= ' AND (`block` LIKE "%'.$_POST['block'].'%" ) ';
		}
		/*
		if ($_POST['searchService'] and $_POST['searchService']!=''){
			$search_params= 'AND (`name` LIKE "'.$_POST['searchService'].'%" )';
		}*/
		$data = $model->searchStaffs('','',' '.$search_params.' order by '.$orderBy,$lpp,$cur_page);
		$this->renderPartial('search_list',array('list_data'=>$data));
	}
	public function actionSearchList2()
	{
		$CsServiceTypeTk = CsServiceTypeTk::model()->findAll('st=:st',array(':st'=>1));
		$model 		   = new GpUsers;
		$cur_page      = 1;
		$lpp           = 200;
		$search_params = ' and group_id = 3 ';
		$orderBy 	   = '`name` ASC ';
		$id = 1 ;
		if($_POST['id_user'] and $_POST['id_user']!=''){
			$search_params .= ' AND (`id` = "'.$_POST['id_user'].'" )';
			$id = $_POST['id_user'];
		}
		if($_POST['searchService2'] and $_POST['searchService2']!=''){
			$CsServiceTypeTk = CsServiceTypeTk::model()->findAll("st=:st and name like '".$_POST['searchService2']."%' ",array(':st'=>1));
		}
		$data  = $model->searchStaffs('','',' '.$search_params.' order by '.$orderBy,$lpp,$cur_page);
		$this->renderPartial('list_member',array('id_user'=>$id,'list_data'=>$data,'CsServiceTypeTk'=>$CsServiceTypeTk));
	}
	public function actionSearchListComison()
	{
		$CsServiceTypeTk = CsServiceTypeTk::model()->findAll('st=:st',array(':st'=>1));
		$model 		   = new GpUsers;
		$cur_page      = 1;
		$lpp           = 200; 
		$search_params = ' and group_id = 3 ';
		$id = 1 ;
		if($_POST['id'] and $_POST['id']!=''){
			$search_params .= ' AND (`id` = "'.$_POST['id'].'" )';
			$id = $_POST['id'];
		}
		$data  = $model->searchStaffs('','',$search_params,$lpp,$cur_page);
		$this->renderPartial('list_member',array('id_user'=>$id,'list_data'=>$data,'CsServiceTypeTk'=>$CsServiceTypeTk));
	}
	/*
	public function actionSearchListStaffs()
	{
		$model 		   = new GpUsers;
		$cur_page      = isset($_POST['cur_page'])?$_POST['cur_page']:1;
		$lpp           = 200;
		$search_params = '';
		$orderBy 	   = '`name` ASC ';
		if ($_POST['id_branch']) 
		{
			$search_params .= ' AND (`id_branch` LIKE "%'.$_POST['id_branch'].'%" ) ';
		}
		$data  = $model->searchStaffs('','',' '.$search_params.' order by '.$orderBy,$lpp,$cur_page);
		$this->renderPartial('search_list',array('list_data'=>$data));

	}*/
	public function actionAddNewTimeKeeping() 
	{ 
	    
		$CsService = CsService::model()->findAll("id not in (select b.id_cs_service from cs_service_tk b where b.st = 1) and status = 1");
		$CsServiceTypeTk = new CsServiceTypeTk;
		$id_user_add = 1;
        if(isset($_POST['ajax']) && $_POST['ajax']==='addNewTimeKeeping'){
			echo CActiveForm::validate($CsServiceTypeTk);
			Yii::app()->end();
		}
		if(isset($_POST['id_user'])){
			$id_user_add = $_POST['id_user'];
		}
        if(isset($_POST['CsServiceTypeTk'])){
			$date = date('dmyHis');
            $CsServiceTypeTk->attributes=$_POST['CsServiceTypeTk'];
			$CsServiceTypeTk->st = 1;
			if($CsServiceTypeTk->validate()){
                if($CsServiceTypeTk->save()){
                    if(isset($_POST['list_service'])){
						$ka = '';
						for($i=0;$i<count($_POST['list_service']);$i++){
							$CsServiceTk = new CsServiceTk;
							$CsServiceTk->id_service_type_tk = $CsServiceTypeTk->id;
							$CsServiceTk->id_cs_service = $_POST['list_service'][$i];
							$CsServiceTk->st = 1;
							$CsServiceTk->save();
						    //$ka .= $_POST['list_service'][$i];
						}
					}
					if(isset($_POST['id_user_add'])){
						$model = new GpUsers;
						$CsServiceTypeTk1 = CsServiceTypeTk::model()->findAll('st=:st',array(':st'=>1));
						$search_params = ' and group_id = 3 AND (`id` = "'.$_POST['id_user_add'].'" )';
						$data  = $model->searchStaffs('','',$search_params,200,1);
						$id = $_POST['id_user_add'];
						$this->renderPartial('list_member',array('id_user'=>$id,'list_data'=>$data,'CsServiceTypeTk'=>$CsServiceTypeTk1));
					}
                    Yii::app()->end();
                }
            }
        }
        $this->renderPartial('frm_add',array('id_user_add'=>$id_user_add,'CsServiceTypeTk'=>$CsServiceTypeTk),false,true);
	}
	public function actionUpdateTimeKeeping()
	{
		$CsService = CsService::model()->findAll("id not in (select b.id_cs_service from cs_service_tk b where b.st = 1) and status = 1");
        $CsServiceTypeTk = new CsServiceTypeTk;
		$id_user_update = 1;
        if(isset($_POST['id'])){
			$CsServiceTypeTk = CsServiceTypeTk::model()->findByPk($_POST['id']);
			//$CsService = CsService::model()->findAll("id not in (select b.id_cs_service from cs_service_tk b where b.id_service_type_tk <> :st)",array(':st'=>$_POST['id']));
        }

        if(isset($_POST['ajax']) && $_POST['ajax']==='updateTimeKeeping')
		{
			echo CActiveForm::validate($CsServiceTypeTk);
			Yii::app()->end();
		}
		if(isset($_POST['id_user']))
		{
			$id_user_update = $_POST['id_user'];
		}

        if(isset($_POST['CsServiceTypeTk'])){
            $updateHeader = CsServiceTypeTk::model()->findByPk($_POST['id_ser']);
            $updateHeader->attributes = $_POST['CsServiceTypeTk'];
			$updateHeader->st = 1;
		
            if($updateHeader->validate()){

                if($updateHeader->update()){

                    if(isset($_POST['list_service'])){
                    	
						$ka = '';
						CsServiceTk::model()->deleteStatus("id_service_type_tk = '".$_POST['id_ser']."'");
						for($i=0;$i<count($_POST['list_service']);$i++){
							
							$CsServiceTk = new CsServiceTk;
							$CsServiceTk->id_service_type_tk = $_POST['id_ser'];
							$CsServiceTk->id_cs_service = $_POST['list_service'][$i];
							$CsServiceTk->st = 1;
							$CsServiceTk->save();
						    //$ka .= $_POST['list_service'][$i];
						}
						echo $updateHeader->name;
					}
                    Yii::app()->end();
                } 
            }
        }
        $this->renderPartial('frm_update',array('id_user_update'=>$id_user_update,'CsService'=>$CsService,'CsServiceTypeTk'=>$CsServiceTypeTk),false,true);
    
	}
	public function actionChangePercent()
	{
		if(isset($_POST['id_user']) and isset($_POST['id_service_type']) and isset($_POST['text_change'])){
			$CsPercentTk = CsPercentTk::model()->findAll('st = 1 and id_gp_users=:st and id_service_type_tk=:dd',array(':st'=>$_POST['id_user'],':dd'=>$_POST['id_service_type']));
		    if(!$CsPercentTk || count($CsPercentTk)==0){
				$CsPercentTk = new CsPercentTk;
				$CsPercentTk->id_gp_users = $_POST['id_user'];
				$CsPercentTk->id_service_type_tk = $_POST['id_service_type'];
				$CsPercentTk->percent = $_POST['text_change'];
				$CsPercentTk->st = 1;
				$CsPercentTk->save();
				echo $_POST['text_change'];
				Yii::app()->end();
			}else{
				$CsPercentTk = CsPercentTk::model()->findByPk($CsPercentTk[0]['id']);
				$CsPercentTk->percent = $_POST['text_change'];	
				$CsPercentTk->update();
				echo $_POST['text_change'];
				Yii::app()->end();
			}
		}
	}
	public function actionSearchTimeKeeping()
	{
		$model 		   = new CsServiceTypeTk;
		$cur_page      = isset($_POST['cur_page'])?$_POST['cur_page']:1;
		$lpp           = 20;
		$search_params = ' AND st = 1 ';
		$orderBy 	   = '`name` ASC ';		 

		if ($_POST['value']) 
		{
			$search_params= 'AND (`name` LIKE "%'.$_POST['value'].'%" ) OR (`id` LIKE "%'.$_POST['value'].'%" )';
		}

		$data  = $model->searchServiceTypeTk('','',' '.$search_params.' order by '.$orderBy,$lpp,$cur_page);
		if($cur_page > $data['paging']['cur_page']){	
			echo '<script>stopped = true; </script>';	
			Yii::app()->end();
		}
		$this->renderPartial('search_list',array('list_data'=>$data,'page'=>$data['paging']['cur_page']));
	}
	/*
	public function actionAddNewTimeKeeping()
	{
	
		if($_POST['customerNewName'])
		{	
			$CsServiceTypeTk = new CsServiceTypeTk;		
			$CsServiceTypeTk->name = $_POST['customerNewName'];					
			$CsServiceTypeTk->st = 1;
			if($CsServiceTypeTk->save()){	
				echo $CsServiceTypeTk->name;
			}else{
				echo 0;		
			}
		}
	}*/ 
	public function actionDeleteTimeKeeping()
	{
		if($_POST['id']){
			$CsServiceTypeTk = CsServiceTypeTk::model()->findByPk($_POST['id']);		
			$CsServiceTypeTk->st=0;					
			if($CsServiceTypeTk->update()){
				CsPercentTk::model()->deleteStatus("id_service_type_tk = '".$_POST['id']."'");
				CsServiceTk::model()->deleteStatus("id_service_type_tk = '".$_POST['id']."'");
				if(isset($_POST['id_user_update'])){
					$model = new GpUsers;
					$CsServiceTypeTk1 = CsServiceTypeTk::model()->findAll('st=:st',array(':st'=>1));
					$search_params = ' and group_id = 3 AND (`id` = "'.$_POST['id_user_update'].'" )';
					$data  = $model->searchStaffs('','',$search_params,200,1);
					$id = $_POST['id_user_update'];
					$this->renderPartial('list_member',array('id_user'=>$id,'list_data'=>$data,'CsServiceTypeTk'=>$CsServiceTypeTk1));
				}
				Yii::app()->end();
			}		 
		}
	}
	
	public function actionUpdateServiceType()
	{
		$CsServiceTypeTk = CsServiceTypeTk::model()->findByPk($_POST['id_service_type']);		
		$CsServiceTypeTk->name=$_POST['servicetypeNewName'];
		$CsServiceTypeTk->st=1;		
		$CsServiceTypeTk->update();
		
		echo "1";
		exit;
			
	}
	
}
