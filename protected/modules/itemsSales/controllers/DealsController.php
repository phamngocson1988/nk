<?php

class DealsController extends Controller
{
	public $layout='/layouts/view';

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

	public function actionview()
	{
		
		$this->render('view');
	}

	/*LMV*/
	public function actioncompany(){
		$model = new Promotion;
		if(isset($_POST['id'])){
					$id = $_POST['id'];

				}

				$data = $model->getproduct();
				

				$this->renderPartial('product',array('model'=>$data),false,false);
	}
	public function actionservice(){
		$model = new Promotion;
		if(isset($_POST['id'])){
					$id = $_POST['id'];

				}

				$data = $model->getservice();
				

				$this->renderPartial('service',array('model'=>$data),false,false);
	}
	public function actioneditdeals(){
		$model = new Promotion;
		if(isset($_POST['id'])){
			$id = $_POST['id'];
		}
		$data = $model->geteditdetail($id);
		$this->renderPartial('edit',array('data'=>$data),false,false);
	}

	public function actionaddprod(){
		if(isset($_POST['company']) and $_POST['company']!=''){
			$model = new Promotion;

			$data = $model->getproduct($_POST['company']);
			if($data){
				$mang= '<select class="form-control DealsProduct" id="DealsProduct" name="DealsProduct[]" style="float:left;" onchange="productsdeal(this)">
                    <option value="0">Chọn sản phẩm</option>';
                    
                foreach ($data as $value) {
                	$mang.='<option value='.$value['id'].'>'.$value['name'].'</option>';
                }
                $mang.='</select>';
                echo $mang;
			}else{
				echo '<select class="form-control" id="DealsProduct" style="float:left;">
                    <option>Chọn sản phẩm</option></select>';
			}
		}else{
			echo '<select class="form-control" id="DealsProduct" style="float:left;">
                    <option value="0">Chọn sản phẩm</option></select>';
		}
	}
	public function actionaddser(){
		if(isset($_POST['company']) and $_POST['company']!=''){
			$model = new Promotion;

			$data = $model->getservice();
			if($data){
				$mang1= '<select class="form-control DealsService" id="DealsService" name="DealsService[]" style="float:left;" onchange="servicedeal(this)">
                        <option>Chọn dịch vụ</option>';
                    
                foreach ($data as $value) {
                	$mang1.='<option value='.$value['id'].'>'.$value['name'].'</option>';
                }
                $mang1.='</select>';
                echo $mang1;
			}else{
				echo '<select class="form-control" id="DealsProduct" style="float:left;">
                    <option>Chọn dịch vụ</option></select>';
			}
		}else{
			echo '<select class="form-control" id="DealsProduct" style="float:left;">
                    <option>Chọn dịch vụ</option></select>';
		}
	}
	public function actionprice(){
		if(isset($_POST['value']) && $_POST['value'] != ''){
			$model = new Promotion;
			$data = $model->getpriceservice($_POST['value']);
			echo $data[0]['price'];
			//print_r($data);
			//echo implode('', $data);
		}
	}
	public function actionpriceproduct(){
		if(isset($_POST['value']) && $_POST['value'] != ''){
			$model = new Promotion;
			$data = $model->getpriceproduct($_POST['value']);
			echo $data[0]['price'];
			//print_r($data);
			//echo implode('', $data);
		}
	}
	public function actiondetail(){
		$model = new PromotionProduct();
		$data =$model->getget();
		
		
		$this->renderPartial('detail',array('model'=>$data),false,false);

	}
	public function actionDetailpromotion(){
		$model = new Promotion();
		
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			
		}

		$data = $model->findByPk($id);
		
		$this->renderPartial('detail_promotion',array('v'=>$data),false,false);
	}
	
	public function actiondetailcroup(){
		$model = new CroupPromotion();
		$data =$model->getcroup();
		
		
		$this->renderPartial('search_croup',array('model'=>$data),false,false);

	}
	

public function actionaddcroup()
{
		$model = new CroupPromotion;
		if(isset($_POST['name'])){
			$name = $_POST['name'];
			$model->name = $_POST['name'];
			$data = CroupPromotion::model()->findAllByAttributes(array("name"=>$name));
		if(count($data) > 0){
			echo "0";
			exit();
		}else{
			$model->insert();
			echo "1";
			exit();
			}
		}
		echo "0";
		exit();
	
}
/*searchpromotion*/
public function actionSearchPromotion()
{

	$model 		   = new Promotion;
	$cur_page      = isset($_POST['cur_page'])?$_POST['cur_page']:1;
	$lpp           = 32;
	$search_params = '';
	$orderBy 	   = '`name` ASC ';

	

	if ($_POST['value']) 
	{
		$search_params= 'AND (`name` LIKE "%'.$_POST['value'].'%" )';
	}
	
	$data  = $model->searchPromotion('','',' '.$search_params.' order by '.$orderBy,$lpp,$cur_page);
	

	$this->renderPartial('search_deals',array('list_data'=>$data));

}

/*end*/
public function actionchitietnhom(){
	$model 		   = new Promotion;
if(isset($_POST['id']) && $_POST['id']==0){
	$data  = $model->getget();
} else{
	$data  = $model->searchcrouppromotion($_POST['id']);

}
$this->renderPartial('search_deals',array('list_data'=>$data));
	
}
public function actiondeletecroup(){

	if (isset($_POST['id']) ) {
		# code...
	$id = $_POST['id'];
	CroupPromotion::model()->deleteAllByAttributes(array('id'=>$id));
	Promotion::model()->deleteAllByAttributes(array('id_croup'=>$id));
	echo "1";
	exit();
	}
	echo "0";
	exit();
}
/*add croup_promotion*/
/*5/1/2017*/
public function actiontestname(){
	echo "1";
	exit();
}
public function actiontestnamecroup(){
	if(isset($_POST['name'])){
		$name = $_POST['name'];
		$data = CroupPromotion::model()->findAllByAttributes(array("name"=>$name));
		if(count($data) > 0){
			echo 1;
			exit();
		}
		echo 0;
		exit();
	}
}
public function actionallservice(){
	if (isset($_POST['vl'])) {

		$vl = $_POST['vl'];
		if($vl == 0){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
	}
}
/*end*/
/*add*/
public function actionaddDeals(){
			
				
				
		$value = new PromotionValue;
		$model = new Promotion;
		$user = Yii::app()->user->getState('user_id');
				$date = explode('-', $_POST['daterange']);
				$type_price = $_POST['type_price'];
				$model->name = $_POST['dealsName'];
				/*$model->id_company= '42';*/
				$model->type_price=$_POST['type_price'];
				$model->status = $_POST['status_deal'];
				$model->start_date = date("Y-m-d H:i:s", strtotime($date[0]));
				$model->end_date = date("Y-m-d H:i:s A", strtotime($date[1]));
				$model->id_croup =$_POST['croup_promotion']; 
				$model->id_user = $user;

				if ($_POST['type_price'] == 1){
					$model->price = $_POST['value_promotion1'];
				}
				elseif ($_POST['type_price'] == 2){
					$model->price = $_POST['value_promotion2'];
				}
				elseif ($_POST['type_price'] == 3){
					$model->price = $_POST['value_promotion3'];
				}
				if($_FILES["fileUpload"]["error"]==0)
					{	
						$fileImageUpload       = $_FILES['fileUpload']['tmp_name'];

				        $fileTypeUpload        = explode('/',$_FILES['fileUpload']["type"]);
				        
				        $imageNameUpload       = date("dmYHis").'.'.$fileTypeUpload[1];

				        $imageUploadSource     = Yii::getPathOfAlias('webroot').'/upload/deals/'; 

				        $resultImage = $model->saveImageScaleAndCrop($fileImageUpload,500,500,$imageUploadSource,$imageNameUpload);
				       
				        $model->images= $imageNameUpload;
					}
				if(isset($_POST['customer'])){
					$model->type_segment = "1";
				}
				if(isset($_POST['store'])){
					$model->type_branch = "1";
				}		
				$model->insert();
				$id_promotion = $model->id;
				if(isset($_POST['customer'])){
					for($s=0; $s<count($_POST['customer']); $s++){
						$segment = new PromotionSegment;
						$segment->id_promotion = $id_promotion;
						$segment->id_segment = $_POST['customer'][$s];
						$segment->insert();
					}
				}
				if(isset($_POST['store'])){
					for($t=0; $t<count($_POST['store']); $t++){
						$branch = new PromotionBranch;
						$branch->id_promotion = $id_promotion;
						$branch->id_branch = $_POST['store'][$t];
						$branch->insert();
					}
				}
				if($type_price == 4){
					for ($p=0; $p<count($_POST['start_value']); $p++) {
						$value = new PromotionValue;
						$value->id_promotion = $id_promotion;
						$value->type_value = $_POST['type_value'];
						$value->start_value =  $_POST['start_value'][$p];
						$value->end_value =$_POST['end_value'][$p];
						$value->percent_value=$_POST['percent_value'][$p];
						$value->insert();
					}
					
				}
				if($_POST['all_service'] == 1){
				if(isset($_POST['list_service'])){
					if ($_POST['list_service'] != ''):
					$result = array();
					$svv = array();
					$service = CsService::model()->findAll();

					if($_POST['list_service'] && count($_POST['list_service']) > 0){
					$update = $model->updateByPk($id_promotion, array('type_service'=>"1"));
					for ($i=0; $i < count($_POST['list_service']) ; $i++) { 
							$result[$_POST['list_service'][$i]] = $i;

						}
					for ($i=0; $i < count($service) ; $i++) { 
							if(array_key_exists($service[$i]['id'],$result) == false){
								
								$Deals = new PromotionProduct();
								$Deals->id_promotion = $id_promotion;
								$Deals->id_service = $service[$i]['id'];
								$Deals->price = null;
								$Deals->number = null;
								$Deals->insert();
							}
							echo $id_promotion;
						}
						
						
					}
					endif;
					}else{	
				if(isset($_POST['DealsService'])){
				$servicefor = $_POST['DealsService'];
				if($id_promotion != "" && $servicefor !="" ){
					$update = $model->updateByPk($id_promotion, array('type_service'=>"1"));
					for ($i=0; $i < count($servicefor) ; $i++) { 
					$Deals = new PromotionProduct();
					
					$Deals->id_promotion = $id_promotion;

					$Deals->id_service = $servicefor[$i];
					
					$Deals->price = $_POST['DealsPrice'][$i];
					$Deals->number = $_POST['number'][$i];
					$Deals->insert();
						}
						 
					}
					echo $id_promotion;
					}
				}
				if(isset($_POST['DealsProduct'])){
				$product = $_POST['DealsProduct'];
				if($id_promotion != "" && $product !="" ){
					$update = $model->updateByPk($id_promotion, array('type_product'=>"1"));
					for ($j=0; $j < count($product) ; $j++) { 
					$Deals = new PromotionProduct();
					$Deals->id_promotion = $id_promotion;
					$Deals->id_product = $product[$j];
					$Deals->price = $_POST['DealsPricepr'][$j];
					$Deals->number = $_POST['numberpro'][$j];
					$Deals->insert();
						}
						echo $id_promotion;
					 
					}
				}
			}else{
				echo "1";
				exit();
			}
				
			
	
}	

/*end*/
/*edit*/
	public function actionupdateDeals(){
		$model = new Promotion;
		$user = Yii::app()->user->getState('user_id');
			if(isset($_POST['id_promotion'])){

				$date = explode('-', $_POST['daterangeedit']);
				$id = $_POST['id_promotion'];
				$type_price = $_POST['type_price_edit'];
				$name = $_POST['dealsNameedit'];
				$id_company="42";
				$id_croup = $_POST['croup_edit'];
				$status = $_POST['status_deal_edit'];
				$start_date = date("Y-m-d H:i:s", strtotime($date[0]));
				$end_date = date("Y-m-d H:i:s A", strtotime($date[1]));
				
				
				//echo substr($date[0],10)."<br>";
				if ($_POST['type_price_edit'] == 1){
					$update = $model->updateByPk($id, array('name'=>$name,'id_company'=>$id_company,'type_price'=>$_POST['type_price_edit'],'price'=>$_POST['value_promotion1_edit'],'start_date'=>$start_date, 'end_date'=>$end_date, 'status'=>$status,'id_croup'=>$id_croup));
					
				}
				elseif ($_POST['type_price_edit'] == 2){
					$update = $model->updateByPk($id, array('name'=>$name,'id_company'=>$id_company,'type_price'=>$_POST['type_price_edit'],'price'=>preg_replace('([^a-zA-Z0-9])', '',  $_POST['value_promotion2_edit']),'start_date'=>$start_date, 'end_date'=>$end_date, 'status'=>$status,'id_croup'=>$id_croup));
					
				}
				elseif ($_POST['type_price_edit'] == 3){
					$update = $model->updateByPk($id, array('name'=>$name,'id_company'=>$id_company,'type_price'=>$_POST['type_price_edit'],'price'=>preg_replace('([^a-zA-Z0-9])', '',  $_POST['value_promotion3_edit']),'start_date'=>$start_date, 'end_date'=>$end_date, 'status'=>$status,'id_croup'=>$id_croup));
					
				}
				if($_FILES["fileUploadedit"]["error"]==0)
					{
							
						if($_POST['images_promotion']!="" && $_POST['images_promotion']!="no_image.png" && $_POST['images_promotion']!="no_avatar.png")
						{
							unlink( Yii::getPathOfAlias('webroot').'/upload/deals/lg/'.$_POST['images_promotion']);
							unlink( Yii::getPathOfAlias('webroot').'/upload/deals/sm/'.$_POST['images_promotion']);
							unlink( Yii::getPathOfAlias('webroot').'/upload/deals/md/'.$_POST['images_promotion']);
						}

						$fileImageUpload       = $_FILES['fileUploadedit']['tmp_name'];

				        $fileTypeUpload        = explode('/',$_FILES['fileUploadedit']["type"]);
				        
				        $imageNameUpload       = date("dmYHis").'.'.$fileTypeUpload[1];

				        $imageUploadSource     = Yii::getPathOfAlias('webroot').'/upload/deals/'; 

				        $resultImage = $model->saveImageScaleAndCrop($fileImageUpload,500,500,$imageUploadSource,$imageNameUpload);

				        
				       $update = $model->updateByPk($id, array('images'=>$imageNameUpload));

        				
					}	
				
				if(isset($_POST['store_edit'])){
					$update = $model->updateByPk($id, array('type_branch'=>"1"));
					$dranch = $model->getsegmentforeach($id);
					if ($dranch != "") {
						PromotionBranch::model()->deleteAllByAttributes(array('id_promotion'=>$id));
					}
					for($b=0; $b < count($_POST['store_edit']); $b++){
						$branch = new PromotionBranch;
						$branch->id_promotion = $id;
						$branch->id_branch = $_POST['store_edit'][$b];
						$branch->insert();
					}
				}else{
					$update = $model->updateByPk($id, array('type_branch'=>"0"));
					$dranch = $model->getsegmentforeach($id);
					if ($dranch != "") {
						PromotionBranch::model()->deleteAllByAttributes(array('id_promotion'=>$id));
					}
				}
				if (isset($_POST['customer_edit'])) {
					$update = $model->updateByPk($id, array('type_segment'=>"1"));
					$segment_sl = $model->getdeletesegment($id);
					if($segment_sl != ""){
						PromotionSegment::model()->deleteAllByAttributes(array('id_promotion'=>$id));
					}
					for($s=0; $s < count($_POST['customer_edit']); $s++){
						$segment = new PromotionSegment;
						$segment->id_promotion = $id;
						$segment->id_segment = $_POST['customer_edit'][$s];
						$segment->insert();
					}

				}
				else{
					$update = $model->updateByPk($id, array('type_segment'=>"0"));
					$dranch = $model->getsegmentforeach($id);
					if ($dranch != "") {
						PromotionSegment::model()->deleteAllByAttributes(array('id_promotion'=>$id));
					}
				}
				if($type_price == 4){
					
					$delete = $model->selectpromotion($id);

					if(count($delete)>0){
						PromotionValue::model()->deleteAllByAttributes(array('id_promotion'=>$id));
						}
					
					for ($i=0; $i < count($_POST['start_value_edit']) ; $i++) {
					$value = new PromotionValue();
					$value->id_promotion = $id;
					$value->type_value = $type_price;
					$value->start_value = $_POST['start_value_edit'][$i];
					$value->end_value =  $_POST['end_value_edit'][$i];
					$value->percent_value=$_POST['percent_value_edit'][$i];
					$value->insert();
					
					}
					$update = $model->updateByPk($id, array('name'=>$name,'id_company'=>$id_company,'type_price'=>$type_price,'price'=>"",'start_date'=>$start_date, 'end_date'=>$end_date, 'status'=>$status, 'id_croup'=>$id_croup));
				}
				 
				
					
					$Deals = new PromotionProduct();
					$delete = $Deals->deleteservice($id);
					if(count($delete)>0){
						PromotionProduct::model()->deleteAllByAttributes(array('id_promotion'=>$id));
					}
				if($_POST['all_service_edit'] == 1){
				if (isset($_POST['DealsService'])) {
						# code...
				$update = $model->updateByPk($id, array('type_service'=>"1"));	
				if($id != ""){
					$servicefor = $_POST['DealsService'];
					for ($a=0; $a < count($servicefor) ; $a++) { 

					$Deals = new PromotionProduct();
					
					$Deals->id_promotion = $id;

					$Deals->id_service = $servicefor[$a];
					
					$Deals->price = $_POST['DealsPrice_edit'][$a];
					$Deals->number = $_POST['number_edit'][$a];
					$Deals->insert();
						}
						
					}
					}
			if(isset($_POST['DealsProduct'])) {
					$update = $model->updateByPk($id, array('type_product'=>"1"));
					$Deals = new PromotionProduct();
					$Product = $_POST['DealsProduct'];
					for ($i=0; $i < count($Product) ; $i++) { 

					$Deals = new PromotionProduct();
					
					$Deals->id_promotion = $id;

					$Deals->id_service = $Product[$i];
					
					$Deals->price = $_POST['DealsPricepr_edit'][$i];
					$Deals->number = $_POST['numberpro_edit'][$i];
					$Deals->insert();
						}
						
					}
					echo $id;
					exit();
				}else{
					$update = $model->updateByPk($id, array('type_product'=>"0"));
					$update = $model->updateByPk($id, array('type_service'=>"0"));
					echo $id;
					exit();
				}
			}
	}
/*end*/
}