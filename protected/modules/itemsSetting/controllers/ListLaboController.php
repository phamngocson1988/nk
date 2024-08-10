<?php
class ListLaboController extends Controller{
	
	public $layout='/layouts/main_sup';

	public function actionView(){
		$labo = new ListLabo;
        $this->render('view', array('labo'=>$labo));
	}
	public function actionLoadData()
	{
		$page 			= isset($_POST['page'])?$_POST['page']:1;
		$limit 			= isset($_POST['limit'])?$_POST['limit']:15;
		$search_name 	= isset($_POST['search_name'])?$_POST['search_name']:'';
		$search_phone 	= isset($_POST['search_phone'])?$_POST['search_phone']:'';	
		$listData 		= ListLabo::model()->searchLabo($page,$limit,$search_name,$search_phone);
		$listLabo 		= $listData['data'];
		$count 			= $listData['count'];
		$page_list 		= 0;
		if(!$listLabo) {
			$listLabo = -1;
		}
		else{
			$action = 'loadLabo';
			$param = "'$search_name','$search_phone'";
			$page_list = VQuotations::model()->paging($page,$count,$limit,$action,$param);
		}

		$this->renderPartial('list_labo',
			array(
				'listLabo'=>$listLabo,
				'page_list' => $page_list,
		));
	}


	public function actionCreate(){
		$labo = new ListLabo;
	    if(isset($_POST['ListLabo'])){
	        $labo->attributes 	= $_POST['ListLabo'];
			$error 				= ListLabo::model()->findAll('name=:st',array(':st'=>trim($_POST['ListLabo']['name'])));
			if($error || count($error)>0){
				echo -1;
				exit;
			}
	
	        if($labo->validate() && $labo->save()){
	            echo 1;
	            exit;
	        }else{
	        	print_r($labo->getErrors());
	        	exit;
	        }
	    }
	}

	public function actionDelete() {
		$id 	= isset($_POST['id'])?$_POST['id']:false;
		$del 	= ListLabo::model()->updateByPk($id,array('status'=>-1));
		if($del){
			echo 1;			// xóa thành công
		}
	}

	public function actionUpdate(){
		$id 		= isset($_POST['id'])?$_POST['id']:false;
		$labo 		= ListLabo::model()->findByPk($id);
		$this->renderPartial('update', array('labo'=>$labo));

	}

	public function actionSaveUpdate(){
		
		$criteria=new CDbCriteria;
		$criteria->condition = "id != :id AND name = :name";
		$criteria->params = array (
		    ':id' => $_POST['id_labo'], ':name' => $_POST['ListLabo']['name'],
		);
		if(ListLabo::model()->findAll($criteria)==true){
			echo -1;
			exit;	
		}

		$labo = ListLabo::model()->findByPk($_POST['id_labo']);
	    if(isset($_POST['ListLabo'])){
	        $labo->attributes=$_POST['ListLabo'];
	        if($labo->validate() && $labo->save()){
	            echo 1;
	            exit;
	        }else{
	        	print_r($labo->getErrors());
	        	exit;
	        }
	    }
	}

}