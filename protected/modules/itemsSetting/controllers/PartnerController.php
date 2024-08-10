<?php
class PartnerController extends Controller{
	
	public $layout='/layouts/main_sup';

	public function actionView(){
		$partner = new Partner;
        $this->render('view', array('partner'=>$partner));
	}

	public function actionLoadPartner()
	{
		$page 			= isset($_POST['page'])?$_POST['page']:1;
		$limit 			= isset($_POST['limit'])?$_POST['limit']:15;
		$search_code 	= isset($_POST['search_code'])?$_POST['search_code']:'';
		$search_name 	= isset($_POST['search_name'])?$_POST['search_name']:1;	
		$listData 		= Partner::model()->searchPartner($page,$limit,$search_code,$search_name);
		$listPartner 	= $listData['data'];
		$count 			= $listData['count'];
		$page_list 		= 0;
		if(!$listPartner) {
			$listPartner = -1;
		}
		else{
			$action = 'loadPartner';
			$param = "'$search_code','$search_name'";
			$page_list = VQuotations::model()->paging($page,$count,$limit,$action,$param);
		}

		$this->renderPartial('listPartner',
			array(
				'listPartner'=>$listPartner,
				'page_list' => $page_list,
		));
	}

	public function actionCreate(){
		$partner = new Partner;
	    if(isset($_POST['Partner'])){
	        $partner->attributes=$_POST['Partner'];
			$error = Partner::model()->findAll('code=:st',array(':st'=>trim($_POST['Partner']['code'])));
			if($error || count($error)>0){
				echo -1;
				exit;
			}
	
	        if($partner->validate() && $partner->save()){
	            echo 1;
	            exit;
	        }else{
	        	print_r($partner->getErrors());
	        	exit;
	        }
	    }
	}
	public function actionDelete() {
		$id 	= isset($_POST['id'])?$_POST['id']:false;
		$del 	= Partner::model()->updateByPk($id,array('status'=>-1));
		if($del){
			echo 1;			// xóa thành công
		}
	}

	public function actionUpdate(){
		$id 		= isset($_POST['id'])?$_POST['id']:false;
		$partner 	= Partner::model()->findByPk($id);
		$this->renderPartial('update', array('partner'=>$partner));

	}
	public function actionSaveUpdate(){
		$partner = Partner::model()->findByPk($_POST['id_partner']);
	    if(isset($_POST['Partner'])){
	        $partner->attributes=$_POST['Partner'];
	        if($partner->validate() && $partner->save()){
	            echo 1;
	            exit;
	        }else{
	        	print_r($partner->getErrors());
	        	exit;
	        }
	    }
	}

}