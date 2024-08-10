<?php

class StockTransferController extends Controller
{	
	public $layout 		='/layouts/view';
	public $pageTitle 	='NhaKhoa2000 - Phiếu chuyển kho';

	public function actionAdmin(){
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
		if (isset($_POST['StockTransfer']) && isset($_POST['StockTransferDetail'])) {
			$trans 	= Yii::app()->db->beginTransaction();
			$result = array();
			try {
				$result = StockTransfer::model()->createStockTransfer($_POST['StockTransfer'], $_POST['StockTransferDetail']);
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
			$listRepository 	= array();
			if($group_id == 21){
				$type_repository = 1;
				$listRepository = Repository::model()->findAll(array(
					'condition' => 'type_repository > :type_repository AND status = :status AND id_branch = :id_branch',
					'params' => array(':type_repository' => $type_repository, ':status' => '1', ':id_branch'=>$user_branch),
				));
			}
			else if($group_id == 22){
				$type_repository = 2;
				$listRepository = Repository::model()->findAll(array(
					'condition' => 'type_repository > :type_repository AND status = :status AND id_branch = :id_branch',
					'params' => array(':type_repository' => $type_repository, ':status' => '1', ':id_branch'=>$user_branch),
				));
			}else{
				$listRepository = Repository::model()->findAll('status = 1');
			}

			$stockTransfer 			= new StockTransfer();
			$stockTransferDetail 	= new StockTransferDetail();
			$this->renderPartial('create', array(
				'listRepository'		=>$listRepository,
				'stockTransfer'			=>$stockTransfer,
				'stockTransferDetail'	=>$stockTransferDetail
			));
		}
	}
	public function actionGetListMaterial(){
		$page 			= isset($_POST['page'])?$_POST['page']:1;
		$search 		= isset($_POST['q'])?$_POST['q']:'';
		$id_repository 	= isset($_POST['id_repository'])?$_POST['id_repository']:'';
		$date   		= date("Y-m-d"); 
	    $materialList 	= MaterialStock::model()->searchListMaterialStock($search, $id_repository, $date);
	    if(!$materialList) 
	    {
	    	echo -1;
	    	exit();
	    }
		foreach ($materialList as $key => $value) {
			$material[] = array(
				'id' 				=> $value['id_material'],
				'text' 				=> $value['name_material'],
				'unit'				=> $value['unit'],
				'qty'				=> $value['qty'],
				'amount'			=> $value['amount'],
				'expiration_date'	=> $value['expiration_date'],
			);
		}
		echo json_encode($material);
	}

	public function actionLoadData(){
		$searchTime 		= isset($_POST['searchTime']) 			? $_POST['searchTime'] 			: '';
		$fromtime 			= isset($_POST['fromtime']) 			? $_POST['fromtime'] 			: '';
		$totime 			= isset($_POST['totime']) 				? $_POST['totime'] 				: '';
		$getTime 			= PurchaseRequisition::model()->getTimeSearch($searchTime,$fromtime, $totime);
		$time_fisrt 		= $getTime['time_fisrt'];
		$time_last 			= $getTime['time_last'];
		$searchRepositoryTransfer 	= isset($_POST['searchRepositoryTransfer']) ? $_POST['searchRepositoryTransfer'] 	: '';
		$searchRepositoryReceipt 	= isset($_POST['searchRepositoryReceipt']) 	? $_POST['searchRepositoryReceipt'] 	: '';
		$page        		= isset($_POST['page'])					? $_POST['page'] 				: 1;
		$limit      		= isset($_POST['limit'])				? $_POST['limit'] 				: 10;
		$searchStatus 		= isset($_POST['searchStatus']) 		? $_POST['searchStatus'] 		: '';
		$searchCode 		= isset($_POST['searchCode']) 			? $_POST['searchCode'] 			: '';
		$data 				= StockTransfer::model()->getListStockTransfer($page,$limit,$searchRepositoryTransfer,$searchRepositoryReceipt, $searchCode, $time_fisrt, $time_last,$searchStatus);
		$countData	= $data['count'];
		$listData 	= $data['data']; 
		$pageList 	= 0;
		$listDetail = array();
		$idStockTransfer = '';
		if($countData){
			$action 	= 'paging';
			$pageList 	= VQuotations::model()->paging($page, $countData, $limit, $action,'');
			foreach ($listData as $key => $value) {
				$idStockTransfer .= $value['id'].',';
			}
			$idStockTransfer= substr($idStockTransfer, 0, -1);
			$listDetail 	= StockTransfer::model()->getListDetail($idStockTransfer);
		}
		$group_id 	=  Yii::app()->user->getState('group_id');
		$this->renderPartial('list_data', array(
			'countData' 	=>$countData, 
			'listData' 		=>$listData,
			'pageList' 		=>$pageList, 
			'listDetail' 	=>$listDetail,
			'group_id' 		=>$group_id
		));
	}

	public function actionDelete(){
		$id_stock_transfer 	= isset($_POST['id_stock_transfer']) ? $_POST['id_stock_transfer']: '';
		if(!$id_stock_transfer) {
			echo 0;			// Phiếu không tồn tại
			exit;
		}
		$trans = Yii::app()->db->beginTransaction();
		try {
			$delItem 		= StockTransfer::model()->updateByPk($id_stock_transfer,array('status'=>-1));
			$delItemDetail 	= StockTransferDetail::model()->updateAll(array('status'=>-1),"id_stock_transfer = $id_stock_transfer");

			if($delItem && $delItemDetail)
				echo 1;			// xóa thành công

			$trans->commit();
		}
		catch (Exception $e) {
			$trans->rollback();
           	echo $e;			// error process
        }
	}

	public function actionConfirm(){
		$date = date('Y-m-d H:i:s');
		$id_stock_transfer 	= isset($_POST['id_stock_transfer']) ? $_POST['id_stock_transfer']: '';
		if(!$id_stock_transfer) {
			echo 0;			// Phiếu không tồn tại
			exit;
		}
		$trans = Yii::app()->db->beginTransaction();
		try {
			$upItem 		= StockTransfer::model()->updateByPk($id_stock_transfer,array('status'=>2, 'confirmation_date'=>$date));
			$upItemDetail 	= StockTransferDetail::model()->updateAll(array('status'=>2),"id_stock_transfer = $id_stock_transfer AND status = 1");
			if($upItem && $upItemDetail){
				$updateStock  = StockTransfer::model()->updateStock($id_stock_transfer);
				if ($updateStock['status'] == 'fail') {
					echo $updateStock['error-message'];
				}else{
					echo 1;	
				}
			}
			$trans->commit();
		}
		catch (Exception $e) {
			$trans->rollback();
           	echo $e;			// error process
        }
	}

	public function actionUpdate(){
		if (isset($_POST['StockTransfer']) && isset($_POST['StockTransferDetail'])) {
			$trans 	= Yii::app()->db->beginTransaction();
			$result = array();
			try {
				$result = StockTransfer::model()->updateStockTransfer($_POST['StockTransfer'], $_POST['StockTransferDetail']);
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
			$id 	= isset($_POST['id_stock_transfer']) ? $_POST['id_stock_transfer']: '';
			if($id){
				$infoItem 	= StockTransfer::model()->findByPk($id);
				if(!$infoItem){
					echo -1;
					exit();// không tồn tại
				}else{
					$repositoryTransfer = Repository::model()->findByPk($infoItem->id_repository_transfer);
					$repositoryReceipt 	= Repository::model()->findByPk($infoItem->id_repository_receipt);
					$user 				= GpUsers::model()->findByPk($infoItem->id_user);
					$infoItemDetail 	= StockTransfer::model()->getListDetail($id);
					$infoItemDetail 	= CJSON::encode($infoItemDetail);
					$stockTransferDetail= new StockTransferDetail();
				}	
				$this->renderPartial('update', array(
					'infoItem'					=> $infoItem,
					'repositoryTransfer'		=> $repositoryTransfer,
					'repositoryReceipt'			=> $repositoryReceipt,
					'user'						=> $user,
					'infoItemDetail'			=> $infoItemDetail,
					'stockTransferDetail'		=> $stockTransferDetail
				));
			}
		}
		
	}
 
}