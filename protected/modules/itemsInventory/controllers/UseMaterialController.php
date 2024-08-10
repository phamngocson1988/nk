<?php

class UseMaterialController extends Controller
{	
	public $layout='/layouts/view';
	public $pageTitle = 'NhaKhoa2000 - Xuất sử dụng';

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
		$this->render('admin',array(
			'listRepository'=>$listRepository,
			'group_id' 		=>$group_id
		));
	}

	public function actionCreate(){
		if (isset($_POST['CancelMaterial']) && isset($_POST['CancelMaterialDetail'])) {
			$trans 	= Yii::app()->db->beginTransaction();
			$result = array();
			try {
				$result = CancelMaterial::model()->createCancelMaterial($_POST['CancelMaterial'], $_POST['CancelMaterialDetail']);
				if ($result['status'] == 'fail') {
					throw new Exception("Error Processing Request");
				}
				$trans->commit();
			}
			catch (Exception $e) {
	           	$message = $e->getMessage();
				if($message) {
					$result = $message;
				}else{
					$message = $result['error-message'];
				}
				Yii::log('Error Processing Request: '.$message, \CLogger::LEVEL_ERROR, 'transaction');
				$trans->rollback();
	        }
	        echo json_encode($result);
	        exit();
		}else{
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
			$model 			= New CancelMaterial();
			$modelDetail 	= New CancelMaterialDetail();
			$this->renderPartial('create', array(
				'listRepository' =>$listRepository,
				'model'			 =>$model,
				'modelDetail'	 =>$modelDetail
			));
		}
	}
 
	public function actionGetListMaterial(){
		$page 			= isset($_POST['page'])?$_POST['page']:1;
		$search 		= isset($_POST['q'])?$_POST['q']:'';
		$id_repository 	= isset($_POST['id_repository'])?$_POST['id_repository']:'';
	    $materialList 	= MaterialStock::model()->searchListMaterialStock($search, $id_repository, '');
	    if(!$materialList) 
	    {
	    	echo -1;
	    	exit();
	    }
	    $i = 1;
		foreach ($materialList as $key => $value) {
			$material[] = array(
				'id' 				=> $value['id_material'].'-'.$i,
				'text' 				=> $value['name_material'],
				'unit'				=> $value['unit'],
				'qty'				=> $value['qty'],
				'amount'			=> $value['amount'],
				'expiration_date'	=> $value['expiration_date'],
			);
			$i++;
		}
		echo json_encode($material);
	} 

	public function actionLoadData(){
		$status 			= 1;
		$searchTime 		= isset($_POST['searchTime']) 			? $_POST['searchTime'] 			: '';
		$fromtime 			= isset($_POST['fromtime']) 			? $_POST['fromtime'] 			: '';
		$totime 			= isset($_POST['totime']) 				? $_POST['totime'] 				: '';
		$getTime 			= PurchaseRequisition::model()->getTimeSearch($searchTime,$fromtime, $totime);
		$time_fisrt 		= $getTime['time_fisrt'];
		$time_last 			= $getTime['time_last'];
		$searchRepository 	= isset($_POST['searchRepository']) 	? $_POST['searchRepository'] 	: '';
		$page        		= isset($_POST['page'])					? $_POST['page'] 				: 1;
		$limit      		= isset($_POST['limit'])				? $_POST['limit'] 				: 10;
		$searchCode 		= isset($_POST['searchCode']) 			? $_POST['searchCode'] 			: '';
		$data 				= CancelMaterial::model()->getListData($page,$limit,$searchRepository, $searchCode, $time_fisrt, $time_last,$status);
		$countData			= $data['count'];
		$listData 			= $data['data']; 
		$pageList 			= 0;
		$listDetail 		= array();
		$idCancelMaterial 	= '';
		if($countData){
			$action 	= 'paging';
			$pageList 	= VQuotations::model()->paging($page, $countData, $limit, $action,'');
			foreach ($listData as $key => $value) {
				$idCancelMaterial .= $value['id'].',';
			}
			$idCancelMaterial= substr($idCancelMaterial, 0, -1);
			$listDetail 	= CancelMaterial::model()->getListDetail($idCancelMaterial);
		}
		$this->renderPartial('list_data', array(
			'countData' 	=>$countData, 
			'listData' 		=>$listData,
			'pageList' 		=>$pageList, 
			'listDetail' 	=>$listDetail
		));
	}
}