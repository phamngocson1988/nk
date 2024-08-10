<?php

class ChairCalendarController extends Controller{
	public $layout='/layouts/main_sup';

	public function actionView(){
		$group_id = Yii::app()->user->getState("group_id");
		$addRole = 0; $upRole = 0; $delRole = 0;
		if ($group_id != 4) {
			$addRole = 1; $upRole = 1; $delRole = 1;
		}
		$this->render('view',array('addRole' => $addRole, 'upRole' => $upRole, 'delRole' => $delRole));
	}
	public function actionShowChair(){
		if(isset($_POST['branch_search']) && isset($_POST['dow_search']) && $_POST['dow_search'] != ''){
			//$chairList = Chair::model()->showChairWithDow($_POST['dow_search']);
			//$chairList = CsScheduleChair::model()->findAll("id_branch = :id AND status = 1 AND id_chair <> '' GROUP BY id_chair",array(':id'=>$_POST['branch_search'])); 
			$chairList = Chair::model()->findAll("id_branch = :id AND status = 1",array(':id'=>$_POST['branch_search'])); 
			if($chairList || count($chairList) != 0){ 
				$chair = array();
				foreach($chairList as $value){ 
					$Chair_arr = Chair::model()->findAll('id_branch = :id and status = :st and id = :dd',array(':id'=>$_POST['branch_search'],':st'=>1,':dd'=>$value['id']));
					if($Chair_arr || count($Chair_arr)>0){
						$chair[] = array(
							'id'    => $value['id'],
							//'id'    => $value['id_chair'],
							'text'  => $Chair_arr[0]['name'],
							'title' => $Chair_arr[0]['name'],
						);
					}
				}
				echo json_encode($chair);
			}else{
				echo -1;
			}
		}else{
			echo -1;
		}
	}
	public function actionShowEvents(){
		$chairList = "";
		$events = array();
		if(isset($_POST['branch_search']) && isset($_POST['dow_search']) && $_POST['dow_search'] != ''){
			$chairList = Chair::model()->showChairWithDow2($_POST['dow_search'], $_POST['branch_search']);
		}
		if(isset($chairList) || count($chairList) > 0){
			foreach($chairList as $value){
				if($value['id_chair'] != ''){
					$events[] = $this->eventArr($value);
				}
			} 
			//echo '<pre>';
			//print_r($events); 
			//echo '</pre>';
			$jstr = json_encode($events);
			echo $jstr;
		}else{
			echo -1;
		}
	}
	public function actionUpdateChair(){
		$CsScheduleChair = new CsScheduleChair;
        if(isset($_POST['id'])){
			$CsScheduleChair = CsScheduleChair::model()->findByPk($_POST['id']);
        }
        if(isset($_POST['idChair'])){
            $updateHeader = CsScheduleChair::model()->findByPk($_POST['idChair']);
			$updateHeader->id_branch=$_POST['update_id_branch'];
			$updateHeader->id_dentist=$_POST['update_id_user'];	
			
            if($updateHeader->validate()){
                if($updateHeader->update(false)){
					/*
					$country = CsScheduleTimeOff::model()->findAll('id_cs_schedule_chair=:st',array(':st'=>$_POST['idChair']));
					if($_POST['chk_date'] != 0){ 
						if($country && count($country)>0){
							
							$record_time_off = CsScheduleTimeOff::model()->findByPk($country[0]['id']);
							$record_time_off->id_dentist= $_POST['update_id_user'];
							$record_time_off->id_branch = $_POST['update_id_branch'];
							$record_time_off->date = $_POST['date_update'];
							$record_time_off->update(false);
							
						}else{
							//$icsc ,$id_dentist ,$id_user ,$id_branch ,$start ,$end ,$date
					        $co1 = CsScheduleChair::model()->findAll('id=:st',array(':st'=>$_POST['idChair']));
							if($co1 && count($co1)>0){
								$this->saveCSTO(
									$_POST['idChair'], $_POST['update_id_user'],
									$_POST['user_id'], $_POST['update_id_branch'], $co1[0]['start'],
									$co1[0]['end'], $_POST['date_update']
								);
							}
						}
					}else{
						if($country && count($country)>0){
							$chairList = Chair::model()->deleteCSTO($country[0]['id']);
						}
					}*/
					
                    echo 1;
                    Yii::app()->end();
                }else{
					echo 0;
                    Yii::app()->end();
				} 
            }else{
				echo 0;
				Yii::app()->end();
			}
        }
        CsSchedule::model()->TimeJson();
        $this->renderPartial('update',array('CsScheduleChair'=>$CsScheduleChair));
	}
	public function actionUpdateTimeChair(){
		if(isset($_POST['id_dentist']) && isset($_POST['dow']) && isset($_POST['branch']) && isset($_POST['id']) && isset($_POST['start']) && isset($_POST['end'])){
            $updateHeader = CsScheduleChair::model()->findByPk($_POST['id']);
			$updateHeader->start = $_POST['start'];
			$updateHeader->end = $_POST['end'];	
			
			$csc1 = CsScheduleChair::model()->findAll('id <> :ii AND id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id > START AND :id < END',array(':ii' => $_POST['id'],':ib' => $_POST['branch'],':do' => $_POST['dow'],':id' => $_POST['start'],':dentist' => $_POST['id_dentist']));
			$csc2 = CsScheduleChair::model()->findAll('id <> :ii AND id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id > START AND :id < END',array(':ii' => $_POST['id'],':ib' => $_POST['branch'],':do' => $_POST['dow'],':id' => $_POST['end'],':dentist' => $_POST['id_dentist']));
			
			$csc3 = CsScheduleChair::model()->findAll('id <> :ii AND id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id < START AND :id1 > START',array(':ii' => $_POST['id'],':ib' => $_POST['branch'],':do' => $_POST['dow'],':id' => $_POST['start'],':id1' => $_POST['end'],':dentist' => $_POST['id_dentist']));
			$csc4 = CsScheduleChair::model()->findAll('id <> :ii AND id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id < END AND :id1 > END',array(':ii' => $_POST['id'],':ib' => $_POST['branch'],':do' => $_POST['dow'],':id' => $_POST['start'],':id1' => $_POST['end'],':dentist' => $_POST['id_dentist']));
			
			if(count($csc1)>0 || count($csc2)>0 || count($csc3)>0 || count($csc4)>0){
				echo -1; 
				Yii::app()->end();
			}
			
            if($updateHeader->validate()){
                if($updateHeader->update(false)){
				    /*
					$country = CsScheduleTimeOff::model()->findAll('id_cs_schedule_chair=:st',array(':st'=>$_POST['id']));
					
					if($country && count($country)>0){
							
						$record_time_off = CsScheduleTimeOff::model()->findByPk($country[0]['id']);
						$record_time_off->start= $_POST['start'];
						$record_time_off->end = $_POST['end'];
						$record_time_off->update(false);
						
					}*/
					
                    CsSchedule::model()->TimeJson();
					echo 1;
                    Yii::app()->end();
                }else{
					echo 0;
                    Yii::app()->end();
				} 
            }else{
				echo 0;
				Yii::app()->end();
			}
        }
	}
	public function actionUpdateTimeChair2(){ 
		if(isset($_POST['id_dentist']) && isset($_POST['dow']) && isset($_POST['branch']) && isset($_POST['id']) && isset($_POST['start']) && isset($_POST['end'])){
            $updateHeader = CsScheduleChair::model()->findByPk($_POST['id']);
			$updateHeader->start = $_POST['start'];
			$updateHeader->end=$_POST['end'];
			$updateHeader->id_chair=$_POST['id_chair'];		
            
			$csc1 = CsScheduleChair::model()->findAll('id <> :ii AND id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id > START AND :id < END',array(':ii' => $_POST['id'],':ib' => $_POST['branch'],':do' => $_POST['dow'],':id' => $_POST['start'],':dentist' => $_POST['id_dentist']));
			$csc2 = CsScheduleChair::model()->findAll('id <> :ii AND id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id > START AND :id < END',array(':ii' => $_POST['id'],':ib' => $_POST['branch'],':do' => $_POST['dow'],':id' => $_POST['end'],':dentist' => $_POST['id_dentist']));
			
			$csc3 = CsScheduleChair::model()->findAll('id <> :ii AND id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id < START AND :id1 > START',array(':ii' => $_POST['id'],':ib' => $_POST['branch'],':do' => $_POST['dow'],':id' => $_POST['start'],':id1' => $_POST['end'],':dentist' => $_POST['id_dentist']));
			$csc4 = CsScheduleChair::model()->findAll('id <> :ii AND id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id < END AND :id1 > END',array(':ii' => $_POST['id'],':ib' => $_POST['branch'],':do' => $_POST['dow'],':id' => $_POST['start'],':id1' => $_POST['end'],':dentist' => $_POST['id_dentist']));
			
			if(count($csc1)>0 || count($csc2)>0 || count($csc3)>0 || count($csc4)>0){
				echo -1; 
				Yii::app()->end();
			}
			
            if($updateHeader->validate()){
                if($updateHeader->update(false)){
                    
                    CsSchedule::model()->TimeJson();
					/*
					$country = CsScheduleTimeOff::model()->findAll('id_cs_schedule_chair=:st',array(':st'=>$_POST['id']));
					
					if($country && count($country)>0){
							
						$record_time_off = CsScheduleTimeOff::model()->findByPk($country[0]['id']);
						$record_time_off->start= $_POST['start'];
						$record_time_off->end = $_POST['end'];
						$record_time_off->update(false);
						
					}*/
					echo 1;
                    Yii::app()->end();
                }else{
					echo 0;
                    Yii::app()->end();
				} 
            }else{
				echo 0;
				Yii::app()->end();
			}
        }
	}
	public function actionChangeUser(){
		//echo 'aaa';exit;
		
		if(isset($_POST['id']) && $_POST['id'] != ""){
			$GpUsers = GpUsers::model()->findAll('id_branch=:st and group_id = 3 order by `name` ASC ',array(':st'=>$_POST['id']));
			$text = ''; 
			foreach($GpUsers as $gt){
				$text .= "<option value='".$gt['id']."'>".$gt['name']."</option>";
			}
			echo "<select class='form-control' id='update_id_user' name='update_id_user'><option selected value=''>--Chọn--</option>".$text."</select>
			<script>
			setTimeout(function(){
			$('#update_id_user').select2({
				placeholder: 'Chọn Bác Sĩ',
				width: '100%'
			});}, 500);
			</script>";
			Yii::app()->end();
		}
	}
	public function actionSaveChangeUser(){
		//echo 'aaa';exit;
		
		if(isset($_POST['id']) && $_POST['id'] != ""){
			$GpUsers = GpUsers::model()->findAll('id_branch=:st and group_id = 3 order by `name` ASC ',array(':st'=>$_POST['id']));
			$text = ''; 
			foreach($GpUsers as $gt){
				$text .= "<option value='".$gt['id']."'>".$gt['name']."</option>";
			}
			echo "<select class='form-control' id='save_id_user' name='save_id_user'><option selected value=''>--Chọn--</option>".$text."</select>
			<script>
			setTimeout(function(){
			$('#save_id_user').select2({
				placeholder: 'Chọn Bác Sĩ',
				width: '100%'
			});}, 500);
			</script>";
			
		}
	} 
	public function actionSaveChair(){
		$id_chair = "";
		$start = "";
		$end = "";
		$dow_search_save = "";
		$branch_search_save = "";		
        if(isset($_POST['branch_search_save']) && isset($_POST['id_chair']) && isset($_POST['dow_search_save']) && isset($_POST['start']) && isset($_POST['end'])){
			$id_chair = $_POST['id_chair'];
			$start = $_POST['start'];
			$end = $_POST['end'];
			$dow_search_save = $_POST['dow_search_save'];
			$branch_search_save = $_POST['branch_search_save'];
		}
        if(isset($_POST['save_id_branch']) && isset($_POST['save_id_user'])){
			$ck = 0;
			
			$CsScheduleChair = new CsScheduleChair;
			$CsScheduleChair->id_dentist = $_POST['save_id_user'];
			$CsScheduleChair->id_branch = $_POST['save_id_branch'];
			
			$CsScheduleChair->dow = $_POST['dow_search_save1'];
			$CsScheduleChair->id_chair = $_POST['id_chair1']; 
			$CsScheduleChair->start = $_POST['start1'];
			$CsScheduleChair->end = $_POST['end1'];
			$CsScheduleChair->id_service = "";
			$CsScheduleChair->note = "";
			$CsScheduleChair->status = 1;
			
			$csc1 = CsScheduleChair::model()->findAll('id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id > START AND :id < END',array(':ib' => $_POST['save_id_branch'],':do' => $_POST['dow_search_save1'],':id' => $_POST['start1'],':dentist' => $_POST['save_id_user']));
			$csc2 = CsScheduleChair::model()->findAll('id_chair <> "" AND id_dentist = :dentist AND id_branch = :ib AND dow = :do AND STATUS = 1 AND :id > START AND :id < END',array(':ib' => $_POST['save_id_branch'],':do' => $_POST['dow_search_save1'],':id' => $_POST['end1'],':dentist' => $_POST['save_id_user']));
			
			if($csc1 || $csc2){
				echo -1;
				Yii::app()->end();
			}
            if($CsScheduleChair->validate()){ 
                if($CsScheduleChair->save(false)){
                    
                    CsSchedule::model()->TimeJson();
					//$icsc ,$id_dentist ,$id_user ,$id_branch ,$start ,$end ,$date
					/*
					if($_POST['chk_date_s'] != 0){ 
						$this->saveCSTO(
							$CsScheduleChair->id, $_POST['save_id_user'],
							$_POST['user_id'], $_POST['save_id_branch'], $_POST['start1'],
							$_POST['end1'], $_POST['dates_update']
						);
					}*/
					echo 1;
                    Yii::app()->end();
                }else{
					echo 0;
                    Yii::app()->end();
				}
            }else{
				echo 0;
				Yii::app()->end();
			}
        }
        $this->renderPartial('save',array('branch_search_save'=>$branch_search_save,'id_chair'=>$id_chair,'start'=>$start,'end'=>$end,'dow_search_save'=>$dow_search_save));
	}
	public function actionDeleteChair(){
		$chairList = "";
		if(isset($_POST['idChair']) && $_POST['idChair'] != ''){
			$chairList = Chair::model()->deleteChair2($_POST['idChair']);
			/*
			$country = CsScheduleTimeOff::model()->findAll('id_cs_schedule_chair=:st',array(':st'=>$_POST['idChair']));
			
            if($country && count($country)>0){
				$chairList = Chair::model()->deleteCSTO($country[0]['id']);
			}*/
			
			CsSchedule::model()->TimeJson();
			
			echo 1;
			Yii::app()->end();
		}
	}
	public function actionAddChair(){
        if(isset($_POST['add_id_branch']) && isset($_POST['add_name_chair']) && isset($_POST['add_type_chair'])){
			$Chair = new Chair;
			$Chair->id_branch = $_POST['add_id_branch'];
			$Chair->name = $_POST['add_name_chair'];
			$Chair->type = $_POST['add_type_chair'];
			$Chair->status = 1;
		    $c = Chair::model()->findAll('name=:st',array(':st'=>trim($_POST['add_name_chair'])));
			if($c && count($c)>0){ 
				echo -1;
				Yii::app()->end();
			}
            if($Chair->validate()){ 
                if($Chair->save(false)){
                    echo 1;
                    Yii::app()->end();
                }else{
					echo 0;
                    Yii::app()->end();
				}
            }else{
				echo 0;
				Yii::app()->end();
			}
        }
        $this->renderPartial('add_chair',array());
	}
	public function eventArr($events){
        $GpUsers = GpUsers::model()->findAll('id=:st',array(':st'=>$events['id_dentist']));
		$name = $GpUsers && count($GpUsers)>0?$GpUsers[0]['name']:"No Name";
		$color = '#5799b9';
		/*
		$country = CsScheduleTimeOff::model()->findAll('id_cs_schedule_chair=:st',array(':st'=>$events['id']));
		if($country && count($country)>0){
			$color = '#a4c8d9';  
		}*/
		return array(
		 	// schedule
			'id'    => $events['id'],//hiện
			'title' => $name,//hiện 
			'start' => $events['start'],//hiện
			'end'   => $events['end'],//hiện
			
			'id_dentist' => $events['id_dentist'],
			'dow_type'    => $events['dow'],
			'id_service' => $events['id_service'],
			'id_chair' => $events['id_chair'], 
			'id_branch'   => $events['id_branch'],
			'note'      => $events['note'],
			'status' => $events['status'],
			'backgroundColor' => $color,
			//'backgroundColor' => '#a4c8d9',
			// resource
			'resourceId'   => $events['id_chair'],
	 	);
	}
	public function saveCSTO($icsc ,$id_dentist ,$id_user ,$id_branch ,$start ,$end ,$date){
		
		$record_time_off = new CsScheduleTimeOff();
		$record_time_off->id_cs_schedule_chair= $icsc;
	    $record_time_off->id_dentist= $id_dentist;
	    $record_time_off->id_user= $id_user;
	    $record_time_off->id_branch = $id_branch;
	    $record_time_off->start = $start;
		$record_time_off->end = $end;
	    $record_time_off->date = $date;
	    $record_time_off->save(false);

	}
	/*
	public function updateCSTO($id, $icsc ,$id_dentist ,$id_user ,$id_branch ,$start ,$end ,$date){
		
		$record_time_off = CsScheduleTimeOff::model()->findByPk($id);
		
		$record_time_off->id_cs_schedule_chair= $icsc;
	    $record_time_off->id_dentist= $id_dentist;
	    $record_time_off->id_user= $id_user;
	    $record_time_off->id_branch = $id_branch;
	    $record_time_off->start = $start;
		$record_time_off->end = $end;
	    $record_time_off->date = $date;
	    $record_time_off->update();

	}*/
	
}?>