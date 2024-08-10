<?php

class PriceBookController extends Controller
{
/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
public $layout='/layouts/main_sup';

/**
* @return array action filters
*/
public function filters()
{
	return array(
	'accessControl', // perform access control for CRUD operations
	);
}

/**
* Specifies the access control rules.
* This method is used by the 'accessControl' filter.
* @return array access control rules
*/
public function accessRules()
{
	return parent::accessRules();
}

public function actionAdmin()
{
	$model            = new PriceBook;

	$this->render('admin',array('model'=>$model));
}

public function actionSearchPriceBook()
{

	$model 		   = new PriceBook;
	$cur_page      = isset($_POST['cur_page'])?$_POST['cur_page']:1;
	$lpp           = 20;
	$search_params = '';	
	$orderBy 	   = '`name` ASC ';

	if($_POST['type'] == 4){
		$orderBy = '`id` DESC ';
	}

	if ($_POST['value']) 
	{
		$search_params= 'AND (`name` LIKE "%'.$_POST['value'].'%" ) OR (`id` LIKE "%'.$_POST['value'].'%" )';
	}


	$data  = $model->searchPriceBook('','',' '.$search_params.' order by '.$orderBy,$lpp,$cur_page);

	if($cur_page > $data['paging']['cur_page']){	
		echo '<script>stopped = true; </script>';	
		exit;
	}

	$this->renderPartial('search_sort',array('model'=>$model,'list_data'=>$data,'page'=>$data['paging']['cur_page']));

}

public function actionDetailPriceBook()
{
	$model = new PriceBook;	

	$lst = "";	

	$data = "";

	if(isset($_POST['id']) && isset($_POST['curpage']))
	{	
		$model 	        = $model->findByPk($_POST['id']);	

		$search_service = isset($_POST['searchService'])?$_POST['searchService']:"";

		$limit          = 20;  

		$count          = $model->getCount($_POST['id'],$search_service);

		$pages          = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;	 

		$lst            = $model->pageList($_POST['curpage'],$pages,$_POST['id']); 

		$data           = $model->listPagination($_POST['curpage'],$limit,$_POST['id'],$search_service);				

	}

	$this->renderPartial('detail_price_book',array('model'=>$model,'lst'=>$lst,'data'=>$data));
	
}

public function actionAddNewPriceBook()
{		

	$id_service = isset($_POST['id_service'])?$_POST['id_service']:"";
	
	if ($_POST['daterange']) {
		$time       = explode("-", $_POST['daterange']);	
		$start_time = date('Y-m-d H:i:s',strtotime($time[0]));
		$end_time   = date('Y-m-d H:i:s',strtotime($time[1]));
	}else {
		$start_time = "";
		$end_time   = "";
	}	

	$result = PriceBook::model()->addNewPriceBook(array('name' => $_POST['name'], 'id_segment' => $_POST['id_segment'], 'id_service' => $id_service, 'percent_discount' => $_POST['percent_discount'], 'percent_doctor' => $_POST['percent_doctor'], 'currency_code' => $_POST['currency_code'], 'start_time' => $start_time, 'end_time' => $end_time, 'effect' => $_POST['effect'])); 	

	print_r($result);

	exit;	
			
}

public function actionUpdatePriceBook()
{		
	
	if ($_POST['daterange']) {
		$time       = explode("-", $_POST['daterange']);	
		$start_time = date('Y-m-d H:i:s',strtotime($time[0]));
		$end_time   = date('Y-m-d H:i:s',strtotime($time[1]));
	}else {
		$start_time = "";
		$end_time   = "";
	}	

	$result = PriceBook::model()->updatePriceBook(array('id' => $_POST['id'], 'name' => $_POST['name'], 'id_segment' => $_POST['id_segment'], 'id_service' => $_POST['id_service'], 'percent_discount' => $_POST['percent_discount'], 'percent_doctor' => $_POST['percent_doctor'], 'currency_code' => $_POST['currency_code'], 'start_time' => $start_time, 'end_time' => $end_time, 'effect' => $_POST['effect'])); 	
	
	echo $result;

	exit;	
			
}

public function actionDeletePriceBook()
{	

	$result = PriceBook::model()->deletePriceBook($_POST['id']); 	
	
	echo $result;

	exit;	
			
}

public function actionUpdateService()
{	

	$price         = str_replace('.','',$_POST['price_service']);	
	$doctor_salary = str_replace('.','',$_POST['doctor_salary_service']);
	$priority_pay  = ($_POST['priority_pay']) ? $_POST['priority_pay'] : 1;
	$flag_price = isset($_POST['flag_price'])?$_POST['flag_price']:1;
	$result        = PriceBook::model()->updateService(array('id_pricebook_service' => $_POST['id_pricebook_service'], 'price' => $price, 'doctor_salary' => $doctor_salary, 'tax' => $_POST['tax_service'], 'priority_pay' => $priority_pay,'flag_price'=>$flag_price));

	echo $result;

	exit;		
		
}

public function actionDeleteService()
{		
	$result       = PriceBook::model()->deleteService($_POST['id']);

	echo $result;

	exit;					
}
/*------------------------------------------LMV---------------------------------------------------------*/
	public function actioncountservice()
	{
		if($_POST['id'] != 0){
			$data = count(PricebookService::model()->findAllByAttributes(array("id_pricebook"=>$_POST['id'])));
			echo '('.$data.')';
			exit();
		}else{
			$data = count(PricebookService::model()->findAll());
			echo '('.$data.')';
			exit();
		}
	}

	public function actionUpdateNewPriceBook(){
	$result = PriceBook::model()->updateNewPriceBook(
		array(
			'id' => $_POST['id'], 
			'id_service' => $_POST['id_service'], 
			'percent_discount' => $_POST['percent_discount'], 
			'percent_doctor' => $_POST['percent_doctor'],
		)
	);

	echo $result;
	exit;	
}
public function actionShowEditNewPriceBookModal(){
	$id = $_POST["id"];
	$model 		   = new PriceBook;
	$value=$model->findByPk($id);
	$this->renderPartial('popup_edit_new_price_book',
		array(
			'id' => $id,
			'model'=>$model,
			'value'=>$value
		)
	);
}
public function actionShowEditPriceBookModal(){
	$id = $_POST["id"];
	$model 		   = new PriceBook;
	$value=$model->findByPk($id);
	$this->renderPartial('popup_edit_price_book',
		array(
			'id' => $id,
			'model'=>$model,
			'value'=>$value
		)
	);
}
}

