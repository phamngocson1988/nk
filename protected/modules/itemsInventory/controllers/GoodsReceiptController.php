<?php

class GoodsReceiptController extends Controller
{
	public $layout='/layouts/view';
	public $pageTitle = 'NhaKhoa2000 - Nhập kho';
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

	public function actionLoadData(){
		$searchTime 		= isset($_POST['searchTime']) 			? $_POST['searchTime'] 			: '';
		$searchRepository 	= isset($_POST['searchRepository']) 	? $_POST['searchRepository'] 	: '';
		$searchCode 		= isset($_POST['searchCode']) 			? $_POST['searchCode'] 			: '';
		$fromtime 			= isset($_POST['fromtime']) 			? $_POST['fromtime'] 			: '';
		$totime 			= isset($_POST['totime']) 				? $_POST['totime'] 				: '';
		$page        		= isset($_POST['page'])					? $_POST['page'] 				: 1;
		$limit      		= isset($_POST['limit'])				? $_POST['limit'] 				: 10;
		$searchStatus 		= isset($_POST['searchStatus']) 		? $_POST['searchStatus'] 		: '';
		$getTime 			= PurchaseRequisition::model()->getTimeSearch($searchTime,$fromtime, $totime);
		$time_fisrt 		= $getTime['time_fisrt'];
		$time_last 			= $getTime['time_last'];
		$data 				= GoodsReceipt::model()->getListGoodsReceipt($page,$limit,$searchRepository, $searchCode, $time_fisrt, $time_last,$searchStatus);
		$countData	= $data['count'];
		$listData 	= $data['data']; 
		$pageList 	= 0;
		$listDetail = array();
		$idGoodsReceipt = '';
		if($countData){
			$action 	= 'paging';
			$pageList 	= VQuotations::model()->paging($page, $countData, $limit, $action,'');
			foreach ($listData as $key => $value) {
				$idGoodsReceipt .= $value['id'].',';
			}
			$idGoodsReceipt = substr($idGoodsReceipt, 0, -1);
			$listDetail 	= GoodsReceipt::model()->getListDetail($idGoodsReceipt);
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
		$id_goods_receipt 	= isset($_POST['id_goods_receipt']) ? $_POST['id_goods_receipt']: '';
		if(!$id_goods_receipt) {
			echo 0;			// Phiếu không tồn tại
			exit;
		}
		$trans = Yii::app()->db->beginTransaction();
		try {
			$delItem 		= GoodsReceipt::model()->updateByPk($id_goods_receipt,array('status'=>-1));
			$delItemDetail 	= GoodsReceiptDetail::model()->updateAll(array('status'=>-1),"id_goods_receipt = $id_goods_receipt");

			if($delItem && $delItemDetail)
				echo 1;			// xóa thành công

			$trans->commit();
		}
		catch (Exception $e) {
			$trans->rollback();
           	echo $e;			// error process
        }
	}

	public function actionCreate(){
		if (isset($_POST['GoodsReceipt']) && isset($_POST['GoodsReceiptDetail'])) {
			$trans 	= Yii::app()->db->beginTransaction();
			$result = array();
			try {
				$result = GoodsReceipt::model()->createGoodsReceipt($_POST['GoodsReceipt'], $_POST['GoodsReceiptDetail']);
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
			$goodsReceipt 		= new GoodsReceipt();
			$goodsReceiptDetail = new GoodsReceiptDetail();
			$this->renderPartial('create', array(
				'listRepository'	=>$listRepository,
				'goodsReceipt'		=>$goodsReceipt,
				'goodsReceiptDetail'=>$goodsReceiptDetail
			));
		}
	} 

	public function actionUpdate(){
		if (isset($_POST['GoodsReceipt']) && isset($_POST['GoodsReceiptDetail'])) {
			$trans 	= Yii::app()->db->beginTransaction();
			$result = array();
			try {
				$result = GoodsReceipt::model()->updateGoodsReceipt($_POST['GoodsReceipt'], $_POST['GoodsReceiptDetail']);
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
			$id				= isset($_POST['id_goods_receipt']) 			? $_POST['id_goods_receipt'] 			: '';
			if($id){
				$infoItem 	= GoodsReceipt::model()->findByPk($id);
				if(!$infoItem){
					echo -1;
					exit();// không tồn tại phiếu đề xuất
				}else{
					$repository 	= Repository::model()->findByPk($infoItem->id_repository);
					$user 			= GpUsers::model()->findByPk($infoItem->id_user);
					$infoItemDetail = GoodsReceipt::model()->getListDetail($id);
					$infoItemDetail = CJSON::encode($infoItemDetail);
					$goodsReceiptDetail 		= new GoodsReceiptDetail();
				}	
				$this->renderPartial('update', array(
					'infoItem'					=> $infoItem,
					'repository'				=> $repository,
					'user'						=> $user,
					'infoItemDetail'			=> $infoItemDetail,
					'goodsReceiptDetail'		=> $goodsReceiptDetail
				));
			}
		}	
	}

	public function actionGetListMaterial(){
		$page 			= isset($_POST['page'])?$_POST['page']:1;
		$search 		= isset($_POST['q'])?$_POST['q']:'';
		$status 		= 0;
		$group_id 		=  Yii::app()->user->getState('group_id');
		if($group_id == 21 || $group_id == 22){
			$status = 1;
		}
	    $materialList 	= CsMaterial::model()->searchMaterial($page,$search, $status);
	    if(!$materialList)
	    {
	    	echo -1;
	    	exit();
	    }
		foreach ($materialList as $key => $value) {
			$material[] = array(
				'id' 	=> $value['id'],
				'text' 	=> $value['name'],
				'unit'	=> $value['unit'],
			);
		}
		echo json_encode($material);
	}
}