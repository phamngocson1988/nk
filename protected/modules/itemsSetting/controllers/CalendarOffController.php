<?php

class CalendarOffController extends Controller{
	public $layout='/layouts/main_sup';

	public function actionView(){
		$group_id = Yii::app()->user->getState('group_id');
		$addRole = 0; $upRole = 0; $delRole = 0;

		if ($group_id != 4) {
			$addRole = 1; $delRole = 1; $upRole = 1;
		}

		$lastmonth = mktime(0, 0, 0, date("m"), date("d")-1,   date("Y"));
		//echo date('d/m/Y', $lastmonth).'<br>';
		$dt = date('Ymd', $lastmonth);
		$csto = CsScheduleTimeOff::model()->findAll('status = :st',array(':st'=>1));
		foreach($csto as $gt){
			$start = explode(' ', trim($gt['start']));
			$end = explode(' ', trim($gt['end']));
			$s = str_replace('-', '', $start[0]);
			$e = str_replace('-', '', $end[0]);
			if(trim($dt) >= trim($s) || trim($dt) >= trim($e)){
				CsScheduleTimeOff::model()->deleteCsScheduleTimeOff($gt['id']); 
			}
		}
		$listdata = CsScheduleTimeOff::model()->searchCsScheduleTimeOff();
        $this->render('view',array('listdata'=>$listdata,'addRole'=>$addRole, 'upRole' => $upRole, 'delRole'=>$delRole));
	}
	public function actionChangeBS(){
		if(isset($_POST['st']) && $_POST['st'] != ''){
			$GpUsers = GpUsers::model()->findAll('group_id=:st and id_branch=:tt order by `name` ASC ',array(':tt'=>$_POST['st'],':st'=>3));
		    $tt = "<option value=''>".'--Chọn Bác Sĩ--'."</option>";
			if(count($GpUsers)>0){
				foreach($GpUsers as $gt){
					 $tt .= "<option value='".$gt['id']."'>".$gt['name']."</option>";
				}
				echo '<select class="form-control" id="'.$_POST['tb'].'" name="'.$_POST['tb'].'">'.$tt.'</select>'."<script> $('".'#'.$_POST['tb']."').select2({placeholder: 'Bác sĩ',width: '100%',});</script>";
			}else{
				echo '<select class="form-control" disabled>'."<option value=''>--Chọn bác sĩ--</option>".'</select>';
			}
		}else{
			echo '<select class="form-control" disabled>'."<option value=''>--Chọn bác sĩ--</option>".'</select>';
		}
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
        if(isset($_REQUEST['search_statusHeader']) && $_REQUEST['search_statusHeader'] !=""){
            $search_params.=" and id_branch = '".$_REQUEST['search_statusHeader']."'";
        }
		if(isset($_REQUEST['search_BS']) && $_REQUEST['search_BS'] !=""){
            $search_params.=" and id_dentist = '".$_REQUEST['search_BS']."'";
        }
        $listdata = CsScheduleTimeOff::model()->searchCsScheduleTimeOff("","",$search_params,$lpp,$cur_page);
        $this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata),false,true);
	}
	public function actionAdd()
	{ 
	    $CsScheduleTimeOff = new CsScheduleTimeOff;
		if(isset($_REQUEST['lpp'])){
        	$lpp=$_REQUEST['lpp'];
        }else{
        	$lpp=5;
        }
        if(isset($_POST['ajax']) && $_POST['ajax']==='addInsurrance')
		{
			echo CActiveForm::validate($CsScheduleTimeOff);
			Yii::app()->end();
		}
        if(isset($_POST['add_cn'])){
			//date('Y-m-d H:i:s') 
			$time_add1 = $_POST['time_add1']==''?'00:00:00':$_POST['time_add1'];
			$date_add1 = explode('/', $_POST['date_add1']);
			$time1 = $date_add1[2].'-'.$date_add1[1].'-'.$date_add1[0].' '.$time_add1;
			$arr1 = $date_add1[2].$date_add1[1].$date_add1[0];
			 
			$time_add2 = $_POST['time_add2']==''?'23:59:00':$_POST['time_add2'];
			$date_add2 = explode('/', $_POST['date_add2']);
			$time2 = $date_add2[2].'-'.$date_add2[1].'-'.$date_add2[0].' '.$time_add2;
			$arr2 = $date_add2[2].$date_add2[1].$date_add2[0];
			
			$CsScheduleTimeOff->start = $time1; 
			$CsScheduleTimeOff->end = $time2;
			
			$CsScheduleTimeOff->id_branch = $_POST['add_cn'];
			$CsScheduleTimeOff->id_dentist = $_POST['name_add'];
			$CsScheduleTimeOff->id_user = Yii::app()->user->getState('user_id');
            //checkDate 
			$cd = $this->chkDate(trim($_POST['name_add']) ,trim($arr1) ,trim($arr2));
			if($cd != 1){
				echo 0; 
				Yii::app()->end();
			}
		    if($CsScheduleTimeOff->validate()){
                if($CsScheduleTimeOff->save(false)){
					$listdata = CsScheduleTimeOff::model()->searchCsScheduleTimeOff();
					$this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata),false,true);
					Yii::app()->end();
                } 
            }
        }
        $this->renderPartial('add',array('CsScheduleTimeOff'=>$CsScheduleTimeOff),false,true);
	}
	public function actionUpdate()
	{
        $CsScheduleTimeOff = new CsScheduleTimeOff;
		if(isset($_REQUEST['lpp'])){
        	$lpp=$_REQUEST['lpp'];
        }else{
        	$lpp=5;
        }
        if(isset($_POST['idhead'])){
			$CsScheduleTimeOff = CsScheduleTimeOff::model()->findByPk($_POST['idhead']);
        }
        if(isset($_POST['ajax']) && $_POST['ajax']==='updateInsurrance')
		{
			echo CActiveForm::validate($CsScheduleTimeOff);
			Yii::app()->end();
		}
        if(isset($_POST['up_cn'])){
            $updateHeader = CsScheduleTimeOff::model()->findByPk($_POST['headId']);
			
			$time_up1 = $_POST['time_up1']==''?'00:00:00':$_POST['time_up1'];
			$date_up1 = explode('/', $_POST['date_up1']);
			$time1 = $date_up1[2].'-'.$date_up1[1].'-'.$date_up1[0].' '.$time_up1;
			$arr1 = $date_up1[2].$date_up1[1].$date_up1[0];
			 
			$time_up2 = $_POST['time_up2']==''?'23:59:00':$_POST['time_up2'];
			$date_up2 = explode('/', $_POST['date_up2']);
			$time2 = $date_up2[2].'-'.$date_up2[1].'-'.$date_up2[0].' '.$time_up2;
			$arr2 = $date_up2[2].$date_up2[1].$date_up2[0];
			
			$updateHeader->start = $time1;
			$updateHeader->end = $time2;
			
			$updateHeader->id_branch = $_POST['up_cn'];
			$updateHeader->id_dentist = $_POST['name_up'];
			$updateHeader->id_user = Yii::app()->user->getState('user_id');
			//checkDate 
			$cd = $this->chkDateUp($_POST['headId'] ,trim($_POST['name_up']) ,trim($arr1) ,trim($arr2));
			
			if($cd != 1){
				echo 0; 
				Yii::app()->end();
			}
            if($updateHeader->validate()){
                if($updateHeader->update(false)){
                    $listdata = CsScheduleTimeOff::model()->searchCsScheduleTimeOff();
                    $this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata),false,true);
                    Yii::app()->end();
                } 
            }
        }
        $this->renderPartial('update',array('CsScheduleTimeOff'=>$CsScheduleTimeOff),false,true);
    
	}
	public function actionDelete()
	{
        if(isset($_POST['idhead'])){
			//$MAboutIntro = MAboutIntro::model()->findByPk($_POST['idhead']);
			
			CsScheduleTimeOff::model()->deleteCsScheduleTimeOff($_POST['idhead']); 
			
			$listdata = CsScheduleTimeOff::model()->searchCsScheduleTimeOff();  
			$lpp=5;
			$this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata),false,true);
			Yii::app()->end(); 
        }
		
	}
	
	public function chkDate($id_dentist ,$s1 ,$e1){
		$csto = CsScheduleTimeOff::model()->findAll('id_dentist = :id and status = :st',array(':id'=>$id_dentist, ':st'=>1));
		$c = 1;
		foreach($csto as $gt){
			$start = explode(' ', trim($gt['start']));
			$end = explode(' ', trim($gt['end']));
			$s = str_replace('-', '', $start[0]);
			$e = str_replace('-', '', $end[0]);
			if(trim($s1) == $s || trim($s1) == $e || trim($e1) == $s || trim($e1) == $e){
				$c = 2;
			}else if(trim($s1) > $s && trim($s1) < $e){
				$c = 3;
			}else if(trim($e1) > $s && trim($e1) < $e){
				$c = 4;
			}else if(trim($s) > $s1 && trim($s) < $e1){
				$c = 5;
			}else if(trim($e) > $s1 && trim($e) < $e1){
				$c = 6;
			}
		}
		return $c;
	}
	public function chkDateUp($id ,$id_dentist ,$s1 ,$e1){
		$csto = CsScheduleTimeOff::model()->findAll('id <> :id and id_dentist = :ident and status = :st',array(':id'=>$id, ':ident'=>$id_dentist, ':st'=>1));
		$c = 1;
		foreach($csto as $gt){
			$start = explode(' ', trim($gt['start']));
			$end = explode(' ', trim($gt['end']));
			$s = str_replace('-', '', $start[0]);
			$e = str_replace('-', '', $end[0]);
			if(trim($s1) == $s || trim($s1) == $e || trim($e1) == $s || trim($e1) == $e){
				$c = 2;
			}else if(trim($s1) > $s && trim($s1) < $e){
				$c = 3;
			}else if(trim($e1) > $s && trim($e1) < $e){
				$c = 4;
			}else if(trim($s) > $s1 && trim($s) < $e1){
				$c = 5;
			}else if(trim($e) > $s1 && trim($e) < $e1){
				$c = 6;
			}
		}
		return $c;
	}
	
}?>