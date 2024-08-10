<?php

class PurchaseRequisitionController extends Controller
{ 
	public $layout='/layouts/view';
	public $pageTitle = 'NhaKhoa2000 - Phiếu đề xuất';

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

	public function actionCreate(){
		if (isset($_POST['PurchaseRequisition']) && isset($_POST['PurchaseRequisitionDetail'])) {
			$data = PurchaseRequisition::model()->createPurchaseRequisition($_POST['PurchaseRequisition'], $_POST['PurchaseRequisitionDetail']);
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
			$purchaseRequisition 			= new PurchaseRequisition();
			$purchaseRequisitionDetail 		= new PurchaseRequisitionDetail();
			$this->renderPartial('create', array(
				'listRepository'				=>$listRepository,
				'purchaseRequisition'			=>$purchaseRequisition,
				'purchaseRequisitionDetail'		=>$purchaseRequisitionDetail
			));
		}
	}

	public function actionGetListMaterial(){
		$page 			= isset($_POST['page'])?$_POST['page']:1;
		$search 		= isset($_POST['q'])?$_POST['q']:'';
	    $materialList 	= CsMaterial::model()->searchMaterial($page,$search);
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
	public function actionloadPurchaseRequisition(){
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
		$data 				= PurchaseRequisition::model()->getListPurchaseRequisition($page, $limit,$searchRepository, $searchCode, $time_fisrt, $time_last,$searchStatus);
		$countData	= $data['count'];
		$listData 	= $data['data']; 
		$pageList 	= 0;
		$listDetail = array();
		$idPurchaseRequisition = '';
		if($countData){
			$action 	= 'paging';
			$pageList 	= VQuotations::model()->paging($page, $countData, $limit, $action,'');
			foreach ($listData as $key => $value) {
				$idPurchaseRequisition .= $value['id'].',';
			}
			$idPurchaseRequisition 		= substr($idPurchaseRequisition, 0, -1);
			$listDetail 				= PurchaseRequisitionDetail::model()->getListDetail($idPurchaseRequisition);
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

	public function actionUpdate(){
		if (isset($_POST['PurchaseRequisition']) && isset($_POST['PurchaseRequisitionDetail'])) {
			$data = PurchaseRequisition::model()->updatePurchaseRequisition($_POST['PurchaseRequisition'], $_POST['PurchaseRequisitionDetail']);
		}else{
			$id				= isset($_POST['id_purchase_requisition']) 			? $_POST['id_purchase_requisition'] 			: '';
			if($id){
				$infoItem 	= PurchaseRequisition::model()->findByPk($id);
				if(!$infoItem){
					echo -1;
					exit();// không tồn tại phiếu đề xuất
				}else{
					$repository 	= Repository::model()->findByPk($infoItem->id_repository);
					$user 			= GpUsers::model()->findByPk($infoItem->id_user);
					$infoItemDetail = PurchaseRequisitionDetail::model()->getListDetail($id);
					$infoItemDetail = CJSON::encode($infoItemDetail);
					$purchaseRequisitionDetail 		= new PurchaseRequisitionDetail();
				}	
				$this->renderPartial('update', array(
					'infoItem'					=> $infoItem,
					'repository'				=> $repository,
					'user'						=> $user,
					'infoItemDetail'			=> $infoItemDetail,
					'purchaseRequisitionDetail'	=> $purchaseRequisitionDetail
				));
			}
		}	
	}

	public function actionDelete(){
		$id_purchase_requisition 		= isset($_POST['id_purchase_requisition']) 			? $_POST['id_purchase_requisition'] 			: '';
		if(!$id_purchase_requisition) {
			echo 0;			// Phiếu đề xuất không tồn tại
			exit;
		}
		$trans = Yii::app()->db->beginTransaction();
		try {
			$delItem 		= PurchaseRequisition::model()->updateByPk($id_purchase_requisition,array('status'=>-1));
			$delItemDetail 	= PurchaseRequisitionDetail::model()->updateAll(array('status'=>-1),"id_purchase_requisition = $id_purchase_requisition");

			if($delItem && $delItemDetail)
				echo 1;			// xóa thành công

			$trans->commit();
		}
		catch (Exception $e) {
			$trans->rollback();
           	echo $e;			// error process
        }
	}

	public function actionGoodsReceipt(){
		$id 	= isset($_POST['id_purchase_requisition']) 	? $_POST['id_purchase_requisition'] : '';
		if(!$id){
			echo -1;// Phiếu đề xuất không tồn tại
			exit;
		}else{
			$infoItem 			= PurchaseRequisition::model()->findByPk($id);
			$infoItemDetail 	= PurchaseRequisitionDetail::model()->getListDetail($id);
			$goodsReceipt 		= new GoodsReceipt();
			$goodsReceiptDetail = new GoodsReceiptDetail();
			$listRepository 	= Repository::model()->findAll('status=1');
			if($infoItem && $infoItemDetail){
				$this->renderPartial('goods_receipt', array(
					'infoItem'			=> $infoItem,
					'infoItemDetail'	=> $infoItemDetail,
					'goodsReceipt'		=> $goodsReceipt,
					'goodsReceiptDetail'=> $goodsReceiptDetail,
					'listRepository'	=> $listRepository
				));
			}
		}
	}
	public function actionCreateGR(){
		if (isset($_POST['GoodsReceipt']) && isset($_POST['GoodsReceiptDetail'])) {
			$id_purchase_requisition 	= isset($_POST['GoodsReceipt']['id_purchase_requisition']) 	? $_POST['GoodsReceipt']['id_purchase_requisition'] : '';
			
			$updateStatus 		= PurchaseRequisition::model()->updateByPk($id_purchase_requisition,array('status'=>1));
			$updateStatusDetail	= PurchaseRequisitionDetail::model()->updateAll(array('status'=>1),"id_purchase_requisition = $id_purchase_requisition");
			if($updateStatus && $updateStatusDetail){
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
			}
			
		}
	}

}