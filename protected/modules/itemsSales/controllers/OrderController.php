<?php

class OrderController extends Controller
{
	public $pay_type = array(
		'0'		=>		'',
		'1'		=>		'Tiền mặt',
		'2'		=>		'Thẻ tín dụng',
		'3'		=>		'Chuyển khoản'
	);
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	// public $layout='//layouts/main';
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

	public function actionView() {
		$branch = Branch::model()->findAll();
		$branchList = CHtml::listData($branch, 'id', 'name');

		$this->render('view',array('branch'=>$branchList));
	}
	public function actionGetProductList() 
	{
		$page = isset($_POST['page'])?$_POST['page']:1;
		$search = isset($_POST['q'])?$_POST['q']:'';
	    
	    $productList = Product::model()->product_list_pagination($page,0,$search);

	    if(!$productList)
	    {
	    	echo -1;
	    	exit();
	    }
		foreach ($productList as $key => $value) {
			$product[] = array(
				'id' => $value['id'],
				'text' => $value['name'],
				'price'=> $value['price'],
				'stock'=> $value['stock'],
			);
		}
		
		echo json_encode($product);
	}

	public function actionLoadOrder()
	{
		$page = isset($_POST['page'])?$_POST['page']:1;
		$limit = isset($_POST['limit'])?$_POST['limit']:15;
		$order_time = isset($_POST['order_time'])?$_POST['order_time']:'';
		$order_branch = isset($_POST['order_branch'])?$_POST['order_branch']:1;
		$order_customer = isset($_POST['order_customer'])?$_POST['order_customer']:'';
		$order_code = isset($_POST['order_code'])?$_POST['order_code']:'';
		$id = isset($_POST['id'])?$_POST['id']:'';
		$Order = VOrder::model()->searchOrder($page,$limit,$order_time,$order_branch,$order_customer,$order_code);
		$OrderList = $Order['data'];
		$count = $Order['count'];
		
		$OrderDetail = -1;
		$page_list = 0;

		if(!$OrderList) {
			$OrderList = -1;
		}
		else{
			$action = 'loadOrder';
			$param = "'$id','$order_time','$order_branch','$order_customer','$order_code'";
			$page_list = VQuotations::model()->paging($page,$count,$limit,$action,$param);
	       	
			$first_id = end($OrderList)->id;
			$last_id = reset($OrderList)->id;

			$condition = " $first_id <= id_order AND id_order <= $last_id AND status >= 0";

			$OrderDetail = VOrderDetail::model()->searchOrderDetail($condition);
		}

		$this->renderPartial('orderList',
			array(
				'orderList'=>$OrderList,
				'orderDetail'=>$OrderDetail,
				'page_list' => $page_list,
		));
	}
	//huy don hàng
	public function actionDeleteOrder() {
		$id_order = isset($_POST['id_order'])?$_POST['id_order']:false;
		$trans = Yii::app()->db->beginTransaction();
		try {
			$delOrder = Order::model()->updateByPk($id_order,array('status'=>4));
			$delOrderDetail = OrderDetail::model()->updateAll(array('status'=>4),"id_order = $id_order");

			if($delOrder && $delOrderDetail )
				echo 1;			// xóa thành công

			$trans->commit();
		}
		catch (Exception $e) {
			$trans->rollback();
           	echo $e;			// error process
        }
	}
//create order
	public function actionCreate()
	{
		$code_number = isset($_POST['code_number'])?$_POST['code_number']:'';
		$id_customer = isset($_POST['id_customer'])?$_POST['id_customer']:'';
		$id_product  = isset($_POST['id_product'])?$_POST['id_product']:'';
		$i = 1;
		$product = '';
		if($id_product) {
			$product = Product::model()->findByPk($id_product)->attributes;
		}
		$order = new Order();
		$orderdetail = new OrderDetail();
		$order_recipient = new OrderRecipient();
		if(isset($_POST['ajax']) && $_POST['ajax']==='frm-order')
        {
            echo CActiveForm::validate($order);
            Yii::app()->end();
        }
        if(isset($_POST['Order'])){
        	//order
        	$order = new Order;
        	$order_items = array();
			$order_item_validate = true;
			$order->attributes = $_POST['Order'];
			$status = $_POST['Order']['status'];
			$id_branch = $_POST['Order']['id_branch'];
			//OrderRecipient
			$order_recipient = new OrderRecipient();
			$order_recipient->attributes = $_POST['OrderRecipient'];
			//Order detail
			if(isset($_POST['OrderDetail'])) {
				foreach ($_POST['OrderDetail'] as $key => $order_item) {
					$orderdetail = new OrderDetail;
					$orderdetail->attributes = $order_item;
					if(!$orderdetail->validate()) {
						$order_item_validate= false;
					}
					else {
						$order_items[] = $orderdetail;	
					}	
				}
				if($order_item_validate && $order->validate()) {
					$trans = Yii::app()->db->beginTransaction();

					try {
						$codeorder = Order::model()->createCodeOrder();
						$order->code = $codeorder;
						$order->save();
						$order_recipient->id_order = $order->id;
						$order_recipient->save();

						foreach ($order_items as $order_item) {
							$order_item->id_order = $order->id;
							$order_item->status = $status;
							$order_item->save();
						}
						//cap nhat lai so luong san pham 
						// if($status==3){
						// 	$product = Product::model()->updateStockOrder($order->id, $status, $id_branch);
						// }
						
						$trans->commit();

					}

					catch (Exception $e) {
	                    $trans->rollback();
	                    Yii::app()->user->setFlash('error', "Error occurred");
	                    
	                    echo "-1";		// thất bại

	                   	Yii::app()->end();
	                }
	                echo "1";
	                Yii::app()->end();
				}
			}
        }

		$this->renderPartial('create',
			array(
				'order'				=>	$order,
				'orderdetail'		=>	$orderdetail,
				'i' 				=> 	$i,
				'product'			=>  $product,
				'id_customer'		=>	$id_customer,
				'order_recipient'   =>  $order_recipient,
				'code_number'		=>  $code_number,
				
			));
	}
	//update order
	public function actionUpdateOrder()
	{ 
	$id_order = isset($_POST['id_order'])?$_POST['id_order']:false;
	$code_number = isset($_POST['code_number'])?$_POST['code_number']:'';
	if($id_order){
		$order = VOrder::model()->findByAttributes(array('id'=>$id_order));
		$criteria=new CDbCriteria; 
		$criteria->condition = "id_order = $id_order AND status >= 0";
		$criteria->order= 'status';
		$orderdetail = VOrderDetail::model()->findAll($criteria);
		$order_up = new OrderDetail();
		$count = count($orderdetail);
	}elseif (isset($_POST['VOrder'])) {
		
			$order_details = array();		
			$check = true;
			$id_order = $_POST['VOrder']['id'];
			$order_new_validate = true;
			$status = $_POST['VOrder']['status'];
			$id_branch = $_POST['VOrder']['id_branch'];
			if(isset($_POST['VOrder'])){
				$order = Order::model()->findByPk($id_order);
				$order_id = $order->id; 
				$order->attributes 	=	$_POST['VOrder'];
				$order->status= $status;
				$order_recipient = OrderRecipient::model()->findByPk($order_id);
				$order_recipient->name_recipient= $_POST['VOrder']['name_recipient'];
				$order_recipient->phone_recipient= $_POST['VOrder']['phone_recipient'];
				$order_recipient->address_recipient= $_POST['VOrder']['address_recipient'];
					foreach ($_POST['VOrderDetail'] as $key => $order_detail_old) {
						$id = $order_detail_old['id'];
						$order_s = OrderDetail::model()->findByPk($id);
						$order_s->status = $status;
						$order_s->save();
						if($order_detail_old['del']==1) {
							OrderDetail::model()->deleteAll('id = ' .$id);	
						}
					}

				if(isset($_POST['OrderDetail'])) {
					foreach ($_POST['OrderDetail'] as $key => $order_detail) {
						$order_detail_new = new OrderDetail();
						$order_detail_new->attributes = $order_detail;
						$order_detail_new->id_order = $id_order;
						$order_detail_new->status = $status;
						if(!$order_detail_new->validate())
							$order_new_validate = false;
						else 
							$order_details[] = $order_detail_new;
					}
				}
			}

			if($order_new_validate && $order->validate()) {
				$trans = Yii::app()->db->beginTransaction();

				try {
					$order->save();
					$order_recipient->save();
					foreach ($order_details as $key => $value) {
						$value->save();
					}
					//cap nhat lai so luong san pham
					// if($status==3){
					// 	$product = Product::model()->updateStockOrder($id_order, $status, $id_branch);
					// }

					$trans->commit();
				}
				catch (Exception $e) {
                    $trans->rollback();
                    $check = false;
                   	echo "-1";		// thất bại
                   	Yii::app()->end();
                }

                if($check) {
                	echo 1;			// thành công

                	Yii::app()->end();
                }
			}
		}
		$this->renderPartial('update', array('order'=>$order, 'orderdetail'=>$orderdetail,'i'=>$count,'order_up'=>$order_up,'code_number'=>$code_number));
	}
	
	
	public function actionExportOrder(){
		$id_order = isset($_GET['id_order'])?$_GET['id_order']:false;
		if($id_order){
		   	$order 			= VOrder::model()->findByAttributes(array('id'=>$id_order));
		   	$orderDetail 	= VOrderDetail::model()->findAllByAttributes(array('id_order'=>$id_order));
		   	$branch 		= Branch::model()->findByPk($order->id_branch);
		   	$cus 			= Customer::model()->findByPk($order->id_customer);
		   	$filename = 'DonHang.pdf';
		    $html2pdf 		= Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);
		    $html2pdf->WriteHTML($this->renderPartial('export_order', array('order'=>$order,'orderDetail'=>$orderDetail,'branch'=>$branch,'cus'=>$cus), true));
		    $html2pdf->Output($filename, 'I');
		}
	}
public function actionGetCustomerList()
	{
		$page = isset($_POST['page'])?$_POST['page']:1;
		$search = isset($_POST['q'])?$_POST['q']:'';
	    $item = 20;
	    $customerList = Receipt::model()->searchCustomer($page,$item, $search);
	    $customer = array();
	    
	    	foreach ($customerList as $key => $value) {
				$customer[] = array(
					'id'                   => $value['id'],
					'text'                 => $value['fullname'],
					'code_number'          => $value['code_number'],	
					'phone'                => $value['phone'],
					'img'                  => $value['image'],
					'email'                => $value['email'],
					'gender'               => $value['gender'],
					'birthdate'            => $value['birthdate'],
					'identity_card_number' => $value['identity_card_number'],
					'id_country'           => $value['id_country'],
					'adr'                  => $value['address'],
				);
			}
		echo json_encode($customer);
	}


	public function actionChangeCustomer(){
		$id_customer = $_POST['id_customer'];
		$data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('customer')
                    ->where('customer.id=:id', array(':id'=> $id_customer))
                    ->queryRow();
		echo json_encode($data);
	}




}
