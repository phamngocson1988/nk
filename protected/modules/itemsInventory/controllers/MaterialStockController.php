<?php

class MaterialStockController extends Controller
{	
	public $layout='/layouts/view';
	public $pageTitle = 'NhaKhoa2000 -Nguyên vật liệu trong kho';
	public function actionAdmin()
	{	
		$group_id 	=  Yii::app()->user->getState('group_id');
		$user_branch=  Yii::app()->user->getState('user_branch');
		$type_repository 	= '';
		$listRepository 	= array();
		if($group_id == 21){
			$type_repository = 2;
			$listRepository = Repository::model()->findAllByAttributes(array('type_repository'=>$type_repository,'id_branch'=>$user_branch, 'status'=>1));
		}
		else if($group_id == 22){
			$type_repository = 3;
			$listRepository = Repository::model()->findAllByAttributes(array('type_repository'=>$type_repository,'id_branch'=>$user_branch, 'status'=>1));
		}else{
			$listRepository = Repository::model()->findAll('status = 1');
		}
		$this->render('admin',array('listRepository'=>$listRepository));
	}

	public function actionLoadData(){
		$searchExpirationDate	= isset($_POST['searchExpirationDate']) ? $_POST['searchExpirationDate']: '';
		$searchRepository 		= isset($_POST['searchRepository']) 	? $_POST['searchRepository'] 	: '';
		$searchMaterial 		= isset($_POST['searchMaterial']) 		? $_POST['searchMaterial'] 		: '';
		$fromtime 				= isset($_POST['fromtime']) 			? $_POST['fromtime'] 			: '';
		$totime 				= isset($_POST['totime']) 				? $_POST['totime'] 				: '';
 		$getTime 				= PurchaseRequisition::model()->getTimeSearch($searchExpirationDate,$fromtime, $totime);
		$time_fisrt 			= $getTime['time_fisrt'];
		$time_last 				= $getTime['time_last'];
		$data 					= MaterialStock::model()->getListMaterialStock($searchRepository, $searchMaterial, $time_fisrt, $time_last);
		$this->renderPartial('list_data', array(
			'data' 			=>$data
		));
	}
}