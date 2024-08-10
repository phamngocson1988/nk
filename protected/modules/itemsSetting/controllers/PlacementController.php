<?php

class PlacementController extends Controller
{
	public $layout='/layouts/main_sup';

	public function actionView()
	{
		$this->render('view',array());
	}
	public function actionSearchList()
	{
		$model 		   = new Chair;
		$cur_page      = 1;
		$lpp           = 200;
		$search_params = ' and status = 1 ';
		$orderBy 	   = '`name` ASC ';
		if (isset($_POST['searchNameCustomer']) && $_POST['searchNameCustomer'] != "") 
		{
			$search_params .= 'AND (`name` LIKE "%'.$_POST['searchNameCustomer'].'%" )';
		}
        if (isset($_POST['iptSearchBranch']) && $_POST['iptSearchBranch'] != "") 
		{
			$search_params .= ' AND (`id_branch` = "'.$_POST['iptSearchBranch'].'" ) ';
		}
		if (isset($_POST['iptSearchGhe']) && $_POST['iptSearchGhe'] != "") 
		{
			$search_params .= ' AND (`type` = "'.$_POST['iptSearchGhe'].'" ) ';
		}
		$data = $model->searchChair('','',$search_params.' order by '.$orderBy,$lpp,$cur_page);
		$this->renderPartial('search_list',array('list_data'=>$data));
	}
	public function actionNewChair()
	{
		if(isset($_POST['type_branch']) && isset($_POST['name_chair']) && isset($_POST['type_chair'])){
			$model = new Chair;
			$model->id_branch = $_POST['type_branch'];
			$model->name = $_POST['name_chair'];
			$model->type = $_POST['type_chair'];
			$model->status = 1;
			$model->save();
			echo $model->id;
		}
	}
	public function actionUpdateChair()
	{
		if(isset($_POST['headId']) && $_POST['chair_name_up'] != ""){
			$model = Chair::model()->findByPk($_POST['headId']);
			$model->id_branch = $_POST['chair_branch_up'];
			$model->name = $_POST['chair_name_up'];
			$model->type = $_POST['chair_type_up'];
			if($model->validate()){
                if($model->update(false)){
                    echo $_POST['chair_name_up'];
                    Yii::app()->end();
                } 
            }else{
				echo 0;
				Yii::app()->end();
			}
		}else{
			echo 0;
			Yii::app()->end();
		}
	}
	public function actionDeleteChair()
	{
		if(isset($_POST['id']))
		{
			$Chair = Chair::model()->deleteChair($_POST['id']);
			if($Chair){
				echo 1;
			}else{
				echo 0;
			}
			
		}
	}
	public function actionDetailChair()
	{
		if(isset($_POST['id'])){
			$Chair = Chair::model()->findByPk($_POST['id']);
			$working_list = CsScheduleChair::model()->findAllByAttributes(array('id_chair'=>$_POST['id']),array('group'=>'dow'));
			$this->renderPartial('chair_information',array('id_chair'=>$_POST['id'],'working_list'=>$working_list,'Chair'=>$Chair));
		}
	}
	
}
