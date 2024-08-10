<?php

class ProductServiceController extends Controller
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

	public function actionView()
	{
		$cst = new CsServiceType;
		$this->render('view',array('cst'=>$cst));
	}

	public function actionDetailServiceType()
	{	
		if(isset($_POST['id']) && isset($_POST['curpage'])) 
		{
			$csservice = new CsService;									
			$id_service_type=$_POST['id'];
			$curpage=$_POST['curpage'];	
			$searchService=isset($_POST['searchService'])?$_POST['searchService']:"";			
			$limit=15;
			$criteria = new CDbCriteria();	
			$criteria->addCondition('t.status = 1');	
			if($id_service_type==0) 
			{
				
			}
			else
			{
				$criteria->addCondition('t.id_service_type = :id_service_typ3');
				$criteria->params = array(':id_service_typ3' => $id_service_type);
			}
			$criteria2 = new CDbCriteria();
			$criteria2->addSearchCondition('code', $searchService, true);
			$criteria2->addSearchCondition('name', $searchService, true, 'OR');	
			$criteria->mergeWith($criteria2);
			$count=$id_service_type==0?count($csservice->findAll($criteria)):count($csservice->findAll($criteria));	              	
			$pages=(($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;		   
			$page_list="";		       	
			if(($curpage!=1)&&($curpage))
			{
				$page_list.='<span onclick="pagination(1,'.$id_service_type.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Trang đầu'><<</a></span>";
			}
			if(($curpage-1)>0)
			{			
				$page_list.='<span onclick="pagination('.$curpage.'-1,'.$id_service_type.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Về trang trước'><</a></span>";
			}				
			$vtdau=max($curpage-3,1);
			$vtcuoi=min($curpage+3,$pages);				
			for($i=$vtdau;$i<=$vtcuoi;$i++)
			{
				if($i==$curpage)
				{
					$page_list.='<span style="background:rgba(115, 149, 158, 0.80);"  class="div_trang">'."<b style='color:#FFFFFF;'>".$i."</b></span>";
				}
				else
				{
					$page_list.='<span onclick="pagination('.$i.','.$id_service_type.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Trang ".$i."'>".$i."</a></span>";
				}
			}
			if(($curpage+1)<=$pages)
			{
				$page_list.='<span onclick="pagination('.$curpage.'+1,'.$id_service_type.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Đến trang sau'>></a></span>";
				$page_list.='<span onclick="pagination('.$pages.','.$id_service_type.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Đến trang cuối'>>></a></span>";
			}	

			$lst=$page_list;       	
			$cs=$csservice->service_list_pagination($curpage,$limit,$id_service_type,$searchService); 

			$this->renderPartial('detail_service_type',array('cs'=>$cs,'lst'=>$lst),false,true);
		}
	}

	public function actionAddService()
	{	
		
		if(CsService::model()->findAll('code=:st',array(':st'=>$_POST['Service_Code']))==true){
			echo '-1';
			exit;	
		}
		$flag_price 					= isset($_POST['flag_price_s'])?$_POST['flag_price_s']:1;
		$csservice 						= new CsService;
		$csservice->id_service_type 	= $_POST['ServiceCategoryId'];
		$csservice->code 				= $_POST['Service_Code'];
		$csservice->name 				= $_POST['Service_Name'];
		$csservice->name_en 			= $_POST['Service_Name_En'];
		$csservice->price 				= str_replace('.','',$_POST['Service_Price']);
		$csservice->description 		= $_POST['Service_Description'];
		$csservice->length 				= $_POST['Service_Length'];	
		$csservice->status_hiden 		= isset($_POST['Service_Booking'])?1:0;
		$csservice->color 				= $_POST['Service_Color'];
		$csservice->point_donate 		= $_POST['Service_Point_Donate'];
		$csservice->point_exchange 		= $_POST['Service_Point_Exchange'];
		$csservice->tax 				= $_POST['Service_Tax'];
		$csservice->stt_show 			= $_POST['stt_show'];
		$csservice->priority_pay 		= $_POST['priority_pay'];
		$csservice->flag_price 			= $flag_price;

		if ($csservice->save()) {
			if(isset($_POST['example-enableCollapsibleOptGroups-enableClickableOptGroups']))
			{
				$id_service=$csservice->findByAttributes(array('id_service_type'=>$_POST['ServiceCategoryId'],'code'=>$_POST['Service_Code'],'name'=>$_POST['Service_Name']));	
				for ($i=0;$i<count($_POST['example-enableCollapsibleOptGroups-enableClickableOptGroups']);$i++) 
				{		
					$csserviceusers=new CsServiceUsers;				
					$csserviceusers->id_dentist=$_POST['example-enableCollapsibleOptGroups-enableClickableOptGroups'][$i];
					$csserviceusers->id_service=$id_service['id'];
					$csserviceusers->save();		
				}
			}

			$priceBookList = PriceBook::model()->findAll();
			foreach ($priceBookList as $priceBook) {
				$priceBookService = new PricebookService;
				$priceBookService->id_pricebook = $priceBook->id;
				$priceBookService->id_service 	= $csservice->id;
				$priceBookService->id_service_type = $csservice->id_service_type;
				$priceBookService->code 		= $csservice->code;
				$priceBookService->name 		= $csservice->name;
				$priceBookService->price 		= (100 - $priceBook->percent_discount)*($csservice->price)/100;
				$priceBookService->doctor_salary 	= (($priceBook->percent_doctor)*($csservice->price))/100;
				$priceBookService->description 	= $csservice->description;
				$priceBookService->length 		= $csservice->length;	
				$priceBookService->createdate 	= date('Y-m-d H:i:s',time());
				$priceBookService->status_hiden = $csservice->status_hiden;
				$priceBookService->color 		= $csservice->color;
				$priceBookService->point_donate = $csservice->point_donate;
				$priceBookService->point_exchange 	= $csservice->point_exchange;
				$priceBookService->tax 			= $csservice->tax;
				$priceBookService->flag 	= 0;
				$priceBookService->selected 	= 0;
				$priceBookService->priority_pay = $csservice->priority_pay;
				$priceBookService->flag_price 	= $csservice->flag_price;
				$priceBookService->save();
			}
			echo '1';
		} else {
			echo '-1';
		}
		exit;		
		
	}	

	public function actionAddServiceType(){
		$csservicetype=new CsServiceType;	
		$csservicetype->code=$_POST['serviceNewCode'];		
		$csservicetype->name=$_POST['serviceNewName'];
		$csservicetype->priority_pay=$_POST['serviceNewPriority'];				
		$csservicetype->save();
		
		echo "1";
		exit;
	}

	public function actionUpdateServiceType() {
		$csservicetype=CsServiceType::model()->findByPk($_POST['id_service_type']);		
		$csservicetype->name=$_POST['servicetypeNewName'];
		$csservicetype->priority_pay=$_POST['servicetypeNewPriority'];
		$csservicetype->update();

		$upService = CsService::model()->updateAll(array('priority_pay'=>$_POST['servicetypeNewPriority']), "id_service_type = ". $_POST['id_service_type']);
		$upService = PricebookService::model()->updateAll(array('priority_pay'=>$_POST['servicetypeNewPriority']), "id_service_type = ". $_POST['id_service_type']);
		
		echo "1";
		exit;
		
	}

	public function actionDeleteServiceType()
	{
		$csservicetype=CsServiceType::model()->findByPk($_POST['id']);	
		$csservicetype->code=0;		
		$csservicetype->status=0;					
		$csservicetype->update();		
		CsService::model()->updateAll(array('code'=>0,'status'=>0),'id_service_type="'.$_POST['id'].'"');
		echo "1";
		exit;
		
	}

	public function actionUpdateService()
	{		
		$flag_price = isset($_POST['flag_price'])?$_POST['flag_price']:1;

		$criteria=new CDbCriteria;
		$criteria->condition = "id != :id AND code = :code";
		$criteria->params = array (
			':id' => $_POST['id_service'], ':code' => $_POST['code_service'],
		);
		if(CsService::model()->findAll($criteria)==true){
			echo '-1';
			exit;	
		}
		$csservice 						= CsService::model()->findByPk($_POST['id_service']);
		$csservice->id_service_type 	= $_POST["id_service_type_".$_POST['id_service'].""];	
		$csservice->code 				= $_POST['code_service'];
		$csservice->name 				= $_POST['name_service'];
		$csservice->name_en 			= $_POST['name_en_service'];
		$csservice->price 				= str_replace('.','',$_POST['price_service']);
		$csservice->description 		= $_POST['description_service'];
		$csservice->length 				= $_POST['length_service'];
		$csservice->status_hiden 		= isset($_POST['booking_service'])?1:0;
		$csservice->color 				= $_POST['color_service'];
		$csservice->point_donate 		= $_POST['point_buy_service'];
		$csservice->point_exchange 		= $_POST['point_change_service'];
		$csservice->tax 				= $_POST['tax_service'];
		$csservice->stt_show 			= $_POST['stt_show'];
		$csservice->priority_pay 		= $_POST['priority_pay'];
		$csservice->flag_price 			= $flag_price;
		$csservice->update();

		$upService = PricebookService::model()->updateAll(array('priority_pay'=>$_POST['priority_pay']), "id_service = ". $_POST['id_service']);
		
		CsServiceUsers::model()->deleteAllByAttributes(array('id_service'=>$_POST['id_service']));		
		if(isset($_POST['example-enableCollapsibleOptGroups-enableClickableOptGroup']))
		{
			for ($i=0;$i<count($_POST['example-enableCollapsibleOptGroups-enableClickableOptGroup']);$i++) 
			{		
				$csserviceusers=new CsServiceUsers;				
				$csserviceusers->id_dentist=$_POST['example-enableCollapsibleOptGroups-enableClickableOptGroup'][$i];
				$csserviceusers->id_service=$_POST['id_service'];
				$csserviceusers->save();		
			}
		}

		echo $_POST['code_service'];
		exit;		
		
	}

	public function actionDeleteService()
	{		
		$csservice = CsService::model()->findByPk($_POST['id']);
		$csservice->status=0;
		$csservice->code=0;
		$csservice->update();
		CsServiceUsers::model()->deleteAllByAttributes(array('id_service'=>$_POST['id']));

		//delete service in each price book
		PricebookService::model()->deleteAllByAttributes(array('id_service'=>$_POST['id']));
		echo '1';
		exit;			
	}

	public function actionServiceListByGroup()
	{		
		$data = CsService::model()->getServiceListByGroup($_POST['id']);

		$ServiceType = CsServiceType::model()->ListServiceType();
		$ArrayServiceType = array();
		foreach ($ServiceType as $key => $value) {
			$ArrayServiceType[$value["id"]] = $value["name"];
		}

		$this->renderPartial('excel_service_table',array('data'=>$data,"ArrayServiceType"=>$ArrayServiceType),false,true);

	}
	

	/*------------------------------------------LMV---------------------------------------------------------*/
	public function actionCountservice()
	{
		if($_POST['id'] != 0){
			$data = count(CsService::model()->findAllByAttributes(array("id_service_type"=>$_POST['id'])));
			echo '('.$data.')';
			exit();
		}else{
			$data = count(CsService::model()->findAll());
			echo '('.$data.')';
			exit();
		}
	}


}
