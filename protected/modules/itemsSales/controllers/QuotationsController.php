<?php

class QuotationsController extends Controller {
	#region --- PARAMS
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='/layouts/view';
	#endregion

	#region --- INIT
	/**
	* @return array action filters
	*/
	public function filters() {
		return array('accessControl');
	}

	public function init() {
		Yii::app()->setComponents(
			array('messages' => array(
				'class' => 'CPhpMessageSource',
				'basePath' => 'protected/modules/itemsSales/messages',
			))
		);
    }

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules() {
		return parent::accessRules();
	}

	public function loadModel($id) {
		$model = VQuotations::model()->findByAttributes(array('id' => $id));
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	#endregion

	#region --- VIEW
	public function actionView($code_number="") {
		$branchList = $this->getBranchList();
		$userList = $this->getUserList();


		$customer = array();

		if ($code_number) {
			$customer = Customer::model()->findByAttributes(array('code_number' => $code_number));
			if ($customer) {
				$customer = $customer->attributes;
			}
		}

		$this->render('view', array('branch' => $branchList, 'customer' => $customer));
	}
	#endregion

	#region --- TAO BAO GIA
	public function actionCreate() {
		#region --- PHAN QUYEN BAO GIA
		$group_id = Yii::app()->user->getState('group_id');
		$createQuote = 0;
		// bac sỹ
		if($group_id == 3 || $group_id == 17){ $createQuote = 1; }
		// tiep tan
		elseif ($group_id == 4 || $group_id == 16) { $createQuote = 1; }
		// dieu hanh + admin
		elseif ($group_id == 1 || $group_id == 2 || $group_id == 11) { $createQuote = 1; }
		#endregion

		#region --- BIEN GIA TRI BAN DAU
		$id_group_history = isset($_POST['id_mhg']) ? $_POST['id_mhg'] : '';
		$id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : '';
		$id_schedule = isset($_POST['id_schedule']) ? $_POST['id_schedule'] : '';
		$teeth = isset($_POST['teeth']) ? $_POST['teeth'] : '';

		$customerSegment = array();
		$customerObj = array();

		if($id_customer) {
			$customer = Customer::model()->findByPk($id_customer);
			if ($customer) {
				$customerObj[] = array(
					'id' => $id_customer,
					'fullname' => $customer->fullname
				);
			}
			$customerSegment = Quotation::model()->getCusSeg($id_customer);
		}
		#endregion

		#region --- KHOI TAO BAO GIA
		$quote = new Quotation();
		$quote_services = new QuotationService();

		if (!isset($_POST['Quotation'])) {
			$this->renderPartial('create', array(
				'branchList' => $this->getBranchList(),

				'quote' => $quote,
				'quote_services' => $quote_services,

				'id_customer' => $id_customer,
				'customerObj' => $customerObj,
				'customerSegment' => $customerSegment,

				'id_group_history' => $id_group_history,
				'id_schedule' => $id_schedule,
				'teeth' => $teeth,
				'createQuote' => $createQuote,
			));
			exit;
		}
		#endregion

		#region --- XU LY TAO MOI BAO GIA
		if (isset($_POST['Quotation']) && isset($_POST['QuotationService'])) {
			$trans = Yii::app()->db->beginTransaction();
			$result = array();
			try {
				$quote = Quotation::model()->addQuotation($_POST['Quotation'], $_POST['QuotationService']);

				$result = $quote;
				if ($quote['status'] == 'fail') {
					throw new Exception("Error Processing Request", 1);
				}

				#region --- XU LY HOA DON KHI CO AP DUNG DIEU TRI
				if ($quote['data']['hasInvoice'] == true) {
					$invoiceData = $quote['data']['quotation'];
					$invoiceItemData = $quote['data']['quotationItem'];

					$invoiceData['id_quotation'] = $invoiceData['id'];
					$invoiceData['code_quotation'] = $invoiceData['code'];
					$invoiceData['id_schedule'] = $_POST['Quotation']['id_schedule'];

					$invoice = Invoice::model()->updateInvoice($invoiceData, $invoiceItemData);

					$result = $invoice;
					if ($invoice['status'] == 'fail') {
						throw new Exception("Error Processing Request", 1);
					}
				}
				#endregion

				$trans->commit();
			} catch(Exception $e) {
				$message = $e->getMessage();
				if($message) {
					$result = $message;
				} else {
					$message = $result['error-message'];
				}
				Yii::log($message, CLogger::LEVEL_ERROR, 'application');
				$trans->rollback();
			}
			echo json_encode($result);
		}
		#endregion
	}
	#endregion

	#region --- CAP NHAT BAO GIA
	public function actionUpdateQuotation() {
		#region --- PHAN QUYEN
		$group_id = Yii::app()->user->getState('group_id');
		$createQuote = 0;
		// bac sỹ
		if($group_id == 3){
			$createQuote = 1;
		}
		// tiep tan
		elseif ($group_id == 4 || $group_id == 17 || $group_id == 16) {
			$createQuote = 1;
		}
		elseif ($group_id == 1 || $group_id == 2) {
			$createQuote = 1;
		}
		#endregion

		#region --- BIEN
		$id_quotation = isset($_POST['id_quotation']) ? $_POST['id_quotation'] : false;
		$teeth = isset($_POST['teeth']) ? $_POST['teeth'] : '';
		$id_schedule = isset($_POST['id_schedule']) ? $_POST['id_schedule'] : '';
		#endregion

		#region --- KHOI TAO CAP NHAT BAO GIA
		if ($id_quotation) {
			$quote = Quotation::model()->findByPk($id_quotation);

			if (!$quote) {
				echo -1;
				exit;
			}

			$currentSegment = "";
			$customerObj = array();

			if($quote->id_customer) {
				$customer = Customer::model()->findByPk($quote->id_customer);
				if ($customer) {
					$customerObj[] = array(
						'id' => $customer->id,
						'fullname' => $customer->fullname
					);
				}
				$currentSegment = Quotation::model()->getCusSeg($quote->id_customer);
			}

			$quote_services = QuotationService::model()->findAllByAttributes(array('id_quotation' => $id_quotation), "status >= 0");

			$quote_up = new QuotationService();

			$this->renderPartial('update', array(
					'quote' => $quote,
					'quote_services' => CJSON::encode($quote_services),
					'quote_up' => $quote_up,

					'branchList' => $this->getBranchList(),
					'userList' => CJSON::encode($this->getUserList()),

					'customerObj' => $customerObj,
					'customerSegment' => $currentSegment,

					'teeth' => $teeth,
					'id_schedule' => $id_schedule,

					'createQuote' => $createQuote,
				));
			exit;
		}
		#endregion

		#region --- XU LY CAP NHAT BAO GIA
		if (isset($_POST['Quotation']) && isset($_POST['QuotationService'])) {
			$trans = Yii::app()->db->beginTransaction();
			$result = array();
			try {
				$quote = Quotation::model()->updateQuotation($_POST['Quotation'], $_POST['QuotationService']);

				$result = $quote;
				if ($quote['status'] == 'fail') {
					throw new Exception("Error Processing Request", 1);
				}

				#region --- XU LY HOA DON KHI CO CHON AP DUNG DIEU TRI
				if ($quote['data']['hasInvoice']) {
					$invoiceData = $quote['data']['quotation'];
					$invoiceItemData = $quote['data']['quotationItem'];

					$invoiceData['id_quotation'] = $invoiceData['id'];
					$invoiceData['code_quotation'] = $invoiceData['code'];
					$invoiceData['id_schedule'] = $_POST['Quotation']['id_schedule'];

					$invoice = Invoice::model()->updateInvoice($invoiceData, $invoiceItemData);

					$result = $invoice;
					if ($invoice['status'] == 'fail') {
						throw new Exception("Error Processing Request", 1);
					}
				}
				#endregion

				$trans->commit();
			} catch(Exception $e) {
				$message = $e->getMessage();
				if($message) {
					$result = $message;
				} else {
					$message = $result['error-message'];
				}
				Yii::log($message, CLogger::LEVEL_ERROR, 'application');
				$trans->rollback();
			}
			echo json_encode($result);
		}
		#endregion
	}
	#endregion

	#region --- LAY DANH SACH KHACH HANG
	public function actionGetCustomerList() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$search = isset($_POST['q']) ? $_POST['q'] : '';
		$item = 10;

		$customerList = CsSchedule::model()->searchCustomer($page, $item, $search);
		$customer = array();

	    if($customerList) {
	    	foreach ($customerList as $key => $value) {
				$customer[] = array(
					'id' => $value['id'],
					'text' => $value['code_number'] . ' - '. $value['fullname'],
					'code_number' => $value['code_number'],
					'phone' => $value['phone'],
					'img' => $value['image'],
					'email' => $value['email'],
					'gender' => $value['gender'],
					'birthdate' => $value['birthdate'],
					'identity_card_number' => $value['identity_card_number'],
					'id_country' => $value['id_country'],
					'adr' => $value['address'],
				);
			}
	    }
		echo json_encode($customer);
	}
	#endregion

	public function actionGetInvoiceList() {
		$search =isset($_POST['q']) ? $_POST['q'] : '';
		$curpage = isset($_POST['page']) ? $_POST['page'] : 1;

		$limit = 10;
		$start_point = $limit * ($curpage - 1);
		$model = new Invoice;
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.status = 1');

		$criteria2 = new CDbCriteria;
		$criteria2->addSearchCondition('code', $search, true);

		$criteria->limit = $limit;
		$criteria->offset = $start_point;
		$criteria->mergeWith($criteria2);
		$invoiceList = $model->findAll($criteria);

		$invoice = array();
		if($invoiceList) {
	    	foreach ($invoiceList as $key => $value) {
				$invoice[] = array(
					'id' => $value['id'],
					'text' => $value['code'],
				);
			}
		}
		echo json_encode($invoice);
	}

	public function actionGetServicesList() {
		$page   = isset($_POST['page'])?$_POST['page']:1;
		$search = isset($_POST['q'])?$_POST['q']:'';
		$id_prB = isset($_POST['id_prB']) ?	$_POST['id_prB']:'';

		$servicesList = CsService::model()->service_list_pagination($page, 30, 0, $search, true);
		$group 		= array();
		$svGroupArray = array();
		$sv			= array();
		$services	= array();

		if($servicesList) {
			foreach ($servicesList as $key => $value) {
				$id_service_type = $value['id_service_type'];
				$svGroupArray[] = $id_service_type;
			}

			$svGroupArray = array_unique($svGroupArray);
		}

		if($svGroupArray) {
			foreach ($svGroupArray as $key => $value) {

				$groupValue = CsServiceType::model()->findByPk($value);

				$idGroup   = $value;
				$nameGroup = '';

				if ($groupValue) {
					$nameGroup = $groupValue->name;
				}

				$group = array_filter($servicesList, function($v) use ($idGroup){
					return $idGroup == $v['id_service_type'];
				});

				$svGroups = array();

				if($group) {
					foreach ($group as $k => $sv) {
						$svGroups[] = array(
							'id'    => (isset($sv['id_service'])) ? $sv['id_service'] : $sv['id'],
							'name'  => $sv['name'],
							'price' => $sv['price'],
							'tax'   => $sv['tax'],
							'code'  => $sv['code'],
							'text'  => $sv['code'],
							'flag_price' => $sv['flag_price'],	// 1: VND, 2: USD
						);
					}
				}

				if($svGroups) {
					$services[] = array(
						'text'     => $nameGroup,
						'children' => $svGroups,
					);
				}
			}
		}

		echo json_encode($services);
	}

	public function actionGetDentistList2()
	{
		$page = isset($_POST['page'])?$_POST['page']:1;
		$search = isset($_POST['q'])?$_POST['q']:'';

	    $item = 30;

	    $search_params= 'AND (`name` LIKE "%'.$search.'%" ) AND group_id = 3';

	    $dentistList = GpUsers::model()->searchStaffs('','',' '.$search_params,$item,$page);
	    if(!$dentistList)
	    {
	    	echo -1;exit();
	    }
		foreach ($dentistList['data'] as $key => $value) {
			$dentist[] = array(
				'id' => $value['id'],
				'text' => $value['name'],
			);
		}
		echo json_encode($dentist);
	}

	public function actionGetProductList()
	{
		$page = isset($_POST['page'])?$_POST['page']:1;
		$search = isset($_POST['q'])?$_POST['q']:'';

	    $productList = Product::model()->searchProduct($page,0,$search);

	    if(!$productList)
	    {
	    	echo -1;exit();
	    }
		foreach ($productList as $key => $value) {
			$product[] = array(
				'id' => $value['id'],
				'text' => $value['name'],
				'price'=> $value['price'],
				'tax'	=>$value['tax'],
			);
		}

		echo json_encode($product);
	}

	public function actionLoadQuotation() {
		$group_id = Yii::app()->user->getState('group_id');
		$delQuote = 0;		// xoa bao gia

		// dieu hanh + admin
		if ($group_id == 1 || $group_id == 2 || $group_id == 8 || $group_id == 16) {
			$delQuote = 1;
		}

		$id          = isset($_POST['id'])?$_POST['id']:'';
		$page        = isset($_POST['page'])?$_POST['page']:1;
		$limit       = isset($_POST['limit'])?$_POST['limit']:8;
		$time        = isset($_POST['time'])?$_POST['time']:'';
		$branch      = isset($_POST['branch'])?$_POST['branch']:1;
		$id_customer = isset($_POST['id_customer'])?$_POST['id_customer']:'';
		$code        = isset($_POST['code'])?$_POST['code']:'';
		$start       = isset($_POST['start'])?$_POST['start']:'';
		$end         = isset($_POST['end'])?$_POST['end']:'';

		$quotation = VQuotations::model()->searchQuotation($page, $limit, $time, $branch, $id_customer, $code, $start, $end);

		$quotationList = $quotation['data'];
		$count = $quotation['count'];

		$quotationDetail = -1;
		$page_list = 0;

		if(!$quotationList) {
			$quotationList = -1;
		} else {
			$action = 'pagingQuote';

			$page_list = VQuotations::model()->paging($page, $count, $limit, $action, '');
			$first_id  = end($quotationList)->id;
			$last_id   = reset($quotationList)->id;

			$condition = " $first_id <= id_quotation AND id_quotation <= $last_id AND status >= 0";

			$quotationDetail = VQuotationDetail::model()->searchQuotationDetail($condition);
		}

		$this->renderPartial('quotationList', array(
				'quotationList' => $quotationList,
				'quotationDetail' => $quotationDetail,
				'page_list' => $page_list,
				'delQuote' => $delQuote,
		));
	}


	// báo giá có đơn hàng ko dc xóa
	public function actionDeleteQuotation() {
		$id_quotation = isset($_POST['id_quotation'])?$_POST['id_quotation']:false;

		if(!$id_quotation) {
			echo 0;			// ko có mã báo giá
			exit;
		}

		$trans = Yii::app()->db->beginTransaction();
		try {
			$delQuote = Quotation::model()->updateByPk($id_quotation,array('status'=>-1));
			$delQuoteDetail = QuotationService::model()->updateAll(array('status'=>-1),"id_quotation = $id_quotation");

			if($delQuote && $delQuoteDetail)
				echo 1;			// xóa thành công

			$trans->commit();
		}
		catch (Exception $e) {
			$trans->rollback();
           	echo $e;			// error process
        }
	}

	public function actionExportQuatation() {
		$id_quotation = isset($_GET['id_quote']) ? $_GET['id_quote'] : false;
		$lang = isset($_GET['lang']) ? $_GET['lang'] : 'vi';

		if (!$id_quotation) {
			echo "Có lỗi xảy ra!";
			exit;
		}

		Yii::app()->setLanguage($lang);

		$quotation = VQuotations::model()->find(array(
			'select' => 'id_branch, id_customer, sum_tax, sum_amount, sum_amount_usd, note, create_date, code, customer_name ',
			'condition' => 'id = ' . $id_quotation
		));

		$quoteDetail = VQuotationDetail::model()->findAll(array(
			'select' => 'user_name, description, unit_price, tax, amount, flag_price, teeth, name_en, name_vi',
			'condition' => 'id_quotation = ' . $id_quotation
		));

		$cus = Customer::model()->find(array(
			'select' => 'birthdate, address',
			'condition' => 'id = ' . $quotation->id_customer
		));

		$branch = Branch::model()->find(array(
			'select' => 'address, hotline1, hotline2',
			'condition' => 'id = ' . $quotation->id_branch
		));

		$filename = 'BaoGia.pdf';

		$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 9);
		$html2pdf->pdf->SetTitle('Bao gia');

		$html2pdf->WriteHTML($this->renderPartial('export_quote', array(
			'quotation' => $quotation,
			'quoteDetail' => $quoteDetail,
			'branch' => $branch,
			'cus' => $cus,
			'lang' => $lang
		), true));

		$html2pdf->Output($filename, 'I');
	}

	public function actionGetPromotionList()
	{
		$id_branch   = isset($_POST['id_branch'])	?	$_POST['id_branch']	:	false;
		$id_segment  = isset($_POST['id_segment'])	?	$_POST['id_segment']:	false;
		$lstServices = isset($_POST['lstServices'])	?	$_POST['lstServices']:	false;
		$lstProducts = isset($_POST['lstProducts'])	?	$_POST['lstProducts']:	false;

		$pro     = Promotion::model()->getActivePromotion($id_branch, $id_segment, $lstServices, $lstProducts);
		$proList = array();

		if($pro['promotion']) {
			foreach ($pro['promotion'] as $key => $value) {
				$id = $value['id'];
				$items = array(); $itemp = array();
				if($value['type_service'] == 1){
					$temp = array_filter($pro['item'], function ($v) use ($id, &$items, &$itemp) {
						if($v['id'] == $id){
							if($v['id_service'])
								$items[] = $v['id_service'];
							else if($v['id_product'])
								$itemp[] = $v['id_product'];

							return true;
						}
					});
				}

				$proList[] = array('attr' => $value->attributes, 'service' => $items, 'product' => $itemp);
			}
		}

		echo json_encode($proList);
	}

	public function actionGetCustomerSegment()
	{
		$id_customer = isset($_POST['id_customer'])	?	$_POST['id_customer']	:	false;

		$cusSegList = array();
		$cusSeg      = Quotation::model()->getCusSeg($id_customer);

		echo json_encode($cusSeg);
	}

	public function actionCheckSVPD()
	{
		$data   = isset($_POST['data'])	?	$_POST['data']	:	false;
		$id_seg = isset($_POST['id_seg'])	?	$_POST['id_seg']	:	false;

		if(!$id_seg) {
			echo "-1";
			exit;
		}
		$priceBook = PriceBook::model()->findByAttributes(array('id_segment'=>$id_seg));

		if($priceBook) {
			$text = 'id_service';
			$con = "id_pricebook = ". $priceBook->id . " AND (";
		}
		else{
			$text = 'id';
			$con = '(';
		}

		$f = true;
		foreach ($data as $key => $value) {
			if($f == true){
				$con .= " $text = '$value' ";
				$f = false;
			}
			else
				$con .= " OR $text = '$value' ";
		}
		$con .= ')';

		if($priceBook) {
			$rs = PricebookService::model()->findAll(array(
				'select' => '*',
				'condition' => $con,
			));
		}
		else {
			$rs = CsService::model()->findAll(array(
				'select' => '*',
				'condition' => $con,
			));
		}


		$segSVPD = array();

		if($rs) {
			foreach ($rs as $key => $value) {
				$segSVPD[] = array(
					'id'    => isset($value['id_service']) ? $value['id_service'] : $value['id'],
					'name'  => $value['name'],
					'price' => $value['price'],
					'tax'   => $value['tax'],
				);
			}
		}

		echo json_encode($segSVPD);
	}

	public function actionSendMailQuotation()
	{
		$id_quotation = isset($_POST['id_quote'])	?	$_POST['id_quote']	:	false;
		$mailTo       = isset($_POST['mailTo'])		?	$_POST['mailTo']	:	false;

		if(!$id_quotation) {
			echo "0"; exit;
		}

	   	$quotation 		= VQuotations::model()->findByAttributes(array('id'=>$id_quotation));
	   	$quoteDetail 	= VQuotationDetail::model()->findAllByAttributes(array('id_quotation'=>$id_quotation));
	   	$branch 		= Branch::model()->findByPk($quotation->id_branch);
	   	$cus 			= Customer::model()->findByPk($quotation->id_customer);

		$title         ='NhaKhoa2000 support';

	    $email_content = $this->renderPartial('send_mail', array('quotation'=>$quotation,'quoteDetail'=>$quoteDetail,'branch'=>$branch,'cus'=>$cus), true);

		$mail          = Sms::model()->sendMail($mailTo,$title,$email_content);

		echo $mail;
	}

	public function actionGetNotiSales()
	{
		$id_author   = isset($_POST['id_author']) ? $_POST['id_author'] : Yii::app()->user->getState('user_id');
		$action      = isset($_POST['action']) ? $_POST['action'] : '';
		$id_schedule = isset($_POST['id_schedule']) ? $_POST['id_schedule'] : '';

		if(!$id_schedule) {
			echo "-1";
			exit;
		}

		$soap = new SoapService();
		$rs = $soap->webservice_server_ws("CsNotiSales",array('1','317db7dbff3c4e6ec4bdd092f3b220a8',$id_author,$id_schedule,$action));

		print_r($rs);
	}

/*****Lay thong tin bang gia******/
	public function actionGetPriceBook()
	{
		$id_seg   = isset($_POST['id_seg'])	?	$_POST['id_seg']	:	false;

		if(!$id_seg){
			echo "0";
			exit;
		}

		$now = date('Y-m-d H:i:s');

		$priceBook = PriceBook::model()->find(array(
			'select'	=> '*',
			'condition'	=> "id_segment = $id_seg AND effect = 1 AND ((start_time <= '$now' AND '$now' <= end_time) OR (start_time = '0000-00-00 00:00:00'))"
		));

		if($priceBook)
			echo json_encode($priceBook->attributes);
		else
			echo "0";
	}
}