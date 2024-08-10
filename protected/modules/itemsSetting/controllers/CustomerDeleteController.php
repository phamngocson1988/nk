<?php

class CustomerDeleteController extends Controller
{
		public $layout='/layouts/main_sup';
		public function filters()
		{
			return array(
			'accessControl', // perform access control for CRUD operations
			);
		}

		public function accessRules()
		{
			return parent::accessRules();
		}

		public function actionView(){
			
			$this->render('view');
		}


		public function actionSearchCustomer(){
			$page           = isset($_POST['page'])			?$_POST['page']	:1;
			$limit          = isset($_POST['limit'])		?$_POST['limit']	:15;
			$searchCode     = isset($_POST['searchCode'])	?$_POST['searchCode']	:'';
			$data 			= Customer::model()->getListCustomerDelete($page,$limit,$searchCode);
			$list_data   	= $data['data'];
			$count          = $data['count'];
			$page_list 		= '';
			if(!$list_data) {
				$list_data = -1;
			}
			else{
				$action      = 'searchCustomer';
				$param       = "";
				$page_list   = VQuotations::model()->paging($page,$count,$limit,$action,$param);
			}
			$this->renderPartial('searchCustomer', array('list_data'=>$list_data, 'page_list'=>$page_list));
		}

		public function actionUpdateSttCustomer(){
			$id          = isset($_POST['id'])		?$_POST['id']	:'';
			if($id){
				$customer=Customer::model()->findByPk($id);	
				if($customer){
					$customer->user_delete = '';	
					$customer->status=1;					
					$customer->update();	
					echo 1;
					exit;
				}else{
					echo -1;
				}
			}else{
				echo -1;
			}
		}
}