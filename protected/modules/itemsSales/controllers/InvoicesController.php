<?php
class InvoicesController extends Controller {
	#region --- VARIABLE
	public $layout = '/layouts/view';

	public $invoice_type = array(
		'0' => '',
		'1' => 'Tiền mặt',
		'2' => 'Thẻ tín dụng',
		'3' => 'Chuyển khoản',
		'4' => 'Bảo hiểm bảo lãnh',
	);

	public $invoice_type_vi = array(
		'0' => '',
		'1' => 'Tiền mặt',
		'2' => 'Thẻ tín dụng',
		'3' => 'Chuyển khoản',
		'4' => 'Bảo hiểm bảo lãnh',
	);

	public $invoice_type_en = array(
		'0' => '',
		'1' => 'Cash',
		'2' => 'Credit Card',
		'3' => 'Transfer',
		'4' => 'Insurance',
	);
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
	#endregion

	#region --- VIEW - INDEX
	public function actionView($id = '', $code_number = '') {
		$branch = Branch::model()->findAll();
		$branchList = CHtml::listData($branch, 'id', 'name');

		$customer = array();
		if ($code_number) {
			$customer = Customer::model()->findByAttributes(array('code_number' => $code_number));
			if ($customer)
				$customer = $customer->attributes;
		}

		$this->render('view', array('id' => $id, 'branch' => $branchList, 'customer' => $customer));
	}
	#endregion

	#region --- DANH SACH HOA DON
	public function actionLoadInvoice() {
		#region --- PHAN QUYEN
		// phan quyen
		$group_id = Yii::app()->user->getState('group_id');
		$rolePay = 0;
		$rolePrint = 0;
		$roleDel = 0;
		// cskh - operation
		if ($group_id == 5) {
			$rolePay = 1;
			$rolePrint = 1;
		}
		//ke toan
		elseif ($group_id == 11 || $group_id == 16) {
			$rolePay = 1;
			$rolePrint = 1;
			$roleDel = 1;
		}
		// tiep tan
		elseif ($group_id == 4) {
			$rolePay = 1;
			$rolePrint = 1;
			$roleDel = 1;
		}
		// dieu hanh + admin
		elseif ($group_id == 1 || $group_id == 2 || $group_id == 11) {
			$rolePay = 1;
			$rolePrint = 1;
			$roleDel = 1;
		}
		#endregion

		#region --- BIEN
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
		$id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : '';
		#endregion

		$Invoice = VInvoice::model()->searchInvoice($page, $limit, $_POST);

		$InvoiceList = $Invoice['data'];
		$count = $Invoice['count'];

		$page_list = 0;
		$sum = '';

		if ($count == 0) {
			$InvoiceList = -1;
		} else {
			$action = 'pagingInvoice';

			$page_list = VQuotations::model()->paging($page, $count, $limit, $action, '');

			$condition = '';

			if ($count > 0) {
				$first_id = end($InvoiceList)->id;
				$last_id = reset($InvoiceList)->id;

				$condition .= " $first_id <= id_invoice AND id_invoice <= $last_id ORDER BY id AND status >= 0";
			}

			if ($id_customer) {
				$sum = Customer::model()->getSumBalance($id_customer);
			}
		}

		$this->renderPartial(
			'invoicesList',
			array(
				'InvoiceList' => $InvoiceList,
				'page_list' => $page_list,
				'invoice_type' => $this->invoice_type,
				'count' => $count,
				'rolePay' => $rolePay,
				'rolePrint' => $rolePrint,
				'roleDel' => $roleDel,
				'sumBalance' => $sum,
			)
		);
	}
	#endregion

	#region --- XAC NHAN HOA DON - LAYOUT
	public function actionShowConfirmInvoiceModal() {
		$id_invoice = isset($_POST['id_invoice']) ? $_POST['id_invoice'] : false;
		if (!$id_invoice) {
			echo "-1"; exit;
		}

		$invoice = Invoice::model()->findByPk($id_invoice);
		if (!$invoice) {
			echo "-1"; exit;
		}

		$listInvoiceDetail = VInvoiceDetail::model()->findAll(array(
			'select' => 'id, unit_price, qty, id_service, services_name, amount, flag_price',
			'condition' => "id_invoice = $id_invoice AND status >= 0",
		));

		$partner = Partner::model()->findAll(array(
			'select' => 'id, name, id_price_book',
			'condition' => 'status = 1'
		));

		$this->renderPartial('confirm_invoice_modal', array(
			'invoice' => $invoice,
			'listInvoiceDetail' => $listInvoiceDetail,
			'partnerList' => $partner,
		));
	}
	#endregion

	#region --- XAC NHAN HOA DON
	public function actionConfirmInvoice() {
		$result = Invoice::model()->confirmInvoice($_POST);
		echo json_encode($result);
	}
	#endregion

	#region --- THANH TOAN HOA DON - LAYOUT
	public function actionInvoicesPayLayout() {
		$id_invoice = isset($_POST['id_invoice']) ? $_POST['id_invoice'] : false;

		if (!$id_invoice) {
			echo -1; exit;
		}

		$invoice = Invoice::model()->findByPk($id_invoice);
		$receipt = new Receipt();

		$customer = Customer::model()->find(array(
			'select' => "deposit",
			'condition' => "id = " . $invoice->id_customer
		));

		$this->renderPartial('invoicePay', array(
			'inv' => $invoice,
			'rpt' => $receipt,
			'deposit' => $customer->deposit
		));
	}
	#endregion

	#region --- THANH TOAN HOA DON
	public function actionInvoicesPay() {
		$id_invoice = isset($_POST['Invoice']['id']) ? $_POST['Invoice']['id'] : false;
		$invoice = isset($_POST['Invoice']) ? $_POST['Invoice'] : false;

		if (!(isset($_POST['Receipt']) && $invoice)) {
			echo -1; exit;
		}

		$invoiceModel = Invoice::model()->findByPk($id_invoice);

		if (!$invoiceModel) {
			echo -2; exit;
		}

		$trans = Yii::app()->db->beginTransaction();

		try {
			$sumInsurance = isset($_POST['Receipt']['sum_insurance']) ? (int)$_POST['Receipt']['sum_insurance'] : 0;
			$pay_amount = isset($_POST['Receipt']['pay_amount']) ? (int)$_POST['Receipt']['pay_amount'] : 0;
			$pay_promotion = isset($_POST['Receipt']['pay_promotion']) ? (int)$_POST['Receipt']['pay_promotion'] : 0;

			$total_amount = $pay_amount + $pay_promotion;

			#region --- HOA DON - INVOICE
			if ($sumInsurance) {
				$invoiceModel->sum_insurance = $sumInsurance;
				$invoiceModel->balance = $invoiceModel->balance - $invoiceModel->sum_insurance;
			} else {
				if ($invoiceModel->balance < $pay_amount) {
					$pay_amount = $invoiceModel->balance - $pay_promotion;
					$invoiceModel->balance = 0;
				} else {
					$invoiceModel->balance = $invoiceModel->balance - $total_amount;
				}
            }

			if ($invoiceModel->isVat == 0 && isset($invoice['checkVat']) && $invoice['checkVat'] == 1) {
				$invoiceModel->date_vat = $invoice['date_vat'];
				$invoiceModel->place_vat = $invoice['place_vat'];
                $invoiceModel->isVat = 1;
			}

			if (!($invoiceModel->validate() && $invoiceModel->save())) {
				throw new Exception("Cập nhật thông tin hóa đơn thất bại!", 1);
			}
			#endregion

			$receipt = new Receipt();

			#region --- GHI CHU
			if ($_POST['Invoice']['note']) {
				$note = CustomerNote::model()->addnote(array(
					'note' => $invoice['note'],
					'id_user' => $invoiceModel->id_author,
					'id_customer' => $invoiceModel->id_customer,
					'flag' => 6,   // 6: thanh toán hóa đơn
					'important' => 0,
					'status' => 1,
				));

				if ($note != -1) $receipt->id_note = $note['id'];
			}
			#endregion

			#region --- RECEIPT
			$receipt->attributes = $_POST['Receipt'];

			$receipt->code = Receipt::model()->createCodeRecept();
			$receipt->id_author = Yii::app()->user->getState('user_id');
			$receipt->author_name = Yii::app()->user->getState('name');
			$receipt->pay_date = date('Y-m-d H:i:s');
			$receipt->id_invoice = $invoiceModel->id;
			$receipt->pay_amount = $pay_amount;
			$receipt->pay_sum = $total_amount;

			if ($sumInsurance) {
				$receipt->pay_amount = $sumInsurance;
				$receipt->pay_insurance = $sumInsurance;
				$receipt->pay_sum = $sumInsurance;
			}

			if ($receipt->pay_type != 2) {
				$receipt->card_val = null;
				$receipt->card_percent = null;
				$receipt->card_type = null;
			}

			if ($receipt->pay_type != 2 && $receipt->pay_type != 3) {
				$receipt->is_company = 0;
			}

			if (!($receipt->validate() && $receipt->save())) {
				throw new Exception("Cập nhật thông tin phiếu thu thất bại!", 1);
			}
			#endregion

			#region --- PHIEU THU - PAYABLE
			$payAcc = VPayable::model()->AddnewPayableAccount(array(
				'id_customer' => $invoiceModel->id_customer,
				'description' => 'THANH TOÁN HÓA ĐƠN SỐ ' . $invoiceModel->code,
				'amount' => $receipt->pay_sum,
				'currency' => 'VND',
				'order_number' => $invoiceModel->code,
				'id_user' => Yii::app()->user->getState('user_id'),
				'payment_status' => $receipt->pay_type,
				'type' => 0,
			));

			if ($payAcc['status'] == 0) {
				throw new Exception("error payable account!");
			}
			#endregion

			#region --- INVOICE TRANSACTION - GIAO DICH
			$transaction_invoice = new TransactionInvoice();
			$pay_amount = (int)$receipt->pay_amount;
			$pay_promotion = (int)$receipt->pay_promotion;

			$listTransactionInvoice = $transaction_invoice->findAllByAttributes(array(
				'id_invoice' => $id_invoice,
				'debt' => TransactionInvoice::ConNo,
			), array('order' => 'priority_pay ASC, id ASC'));

			foreach ($listTransactionInvoice as $key => $value) {
				if ($pay_amount <= 0 && $pay_promotion <= 0) { break; }

				$value_amount = (int)$value['amount'];

				#region --- PROMOTION
				if ($pay_promotion >= $value_amount) {
					$transaction = $transaction_invoice->updateByPk($value['id'], array(
						"debt" => TransactionInvoice::KhuyenMai,
						"pay_date" => date("Y-m-d H:i:s"),
						'id_author' => Yii::app()->user->getState('user_id'),
						'pay_date' => date('Y-m-d H:i:s'),
						'id_receipt' => $receipt->id
					));

					if (!$transaction) {
						throw new Exception("Cập nhật giao dịch khuyến mãi thất bại!", 1);
					}

					$pay_promotion = $pay_promotion - $value_amount;
					continue;
				} else if ($pay_promotion > 0) {
					$promotionTransaction = new TransactionInvoice();
					$promotionTransaction->attributes = $value->attributes;
					$promotionTransaction->amount = $pay_promotion;
					$promotionTransaction->pay_date = date('Y-m-d H:i:s');
					$promotionTransaction->id_author = Yii::app()->user->getState('user_id');
					$promotionTransaction->debt = TransactionInvoice::KhuyenMai;
					$promotionTransaction->id_receipt = $receipt->id;
					unset($promotionTransaction->create_date);

					if (!($promotionTransaction->validate() && $promotionTransaction->save())) {
						throw new Exception("Cập nhật giao dịch khuyến mãi thất bại!", 1);
					}

					$value_amount -= $pay_promotion;
					$pay_promotion = 0;

					if ($pay_amount <= 0) {
						$updateTransaction = $transaction_invoice->updateByPk($value['id'], array(
							"amount" => $value_amount
						));

						if (!$updateTransaction) {
							throw new Exception("Cập nhật giao dịch nợ thất bại!", 1);
						}
						continue;
					}
				}
				#endregion

				#region --- PAID
				if ($pay_amount >= $value_amount) {
					$updateTransaction = $transaction_invoice->updateByPk($value['id'], array(
						"amount" => $value_amount,
						"debt" => TransactionInvoice::ThanhToan,
						"pay_date" => date("Y-m-d H:i:s"),
						'id_author' => Yii::app()->user->getState('user_id'),
						'id_receipt' => $receipt->id
					));

					if (!$updateTransaction) {
						throw new Exception("Cập nhật giao dịch thanh toán thất bại!", 1);
					}

					$pay_amount = $pay_amount - $value_amount;
					continue;
				} else if ($pay_amount > 0) {
					$payTransaction = new TransactionInvoice();
					$payTransaction->attributes = $value->attributes;
					$payTransaction->amount = $pay_amount;
					$payTransaction->pay_date = date('Y-m-d H:i:s');
					$payTransaction->id_author = Yii::app()->user->getState('user_id');
					$payTransaction->debt = TransactionInvoice::ThanhToan;
					$payTransaction->id_receipt = $receipt->id;

					unset($payTransaction->create_date);

					if (!($payTransaction->validate() && $payTransaction->save())) {
						throw new Exception("Cập nhật giao dịch khuyến mãi thất bại!", 1);
					}

					$updateTransaction = $transaction_invoice->updateByPk($value['id'], array(
						"amount" => $value_amount - $pay_amount
					));

					$pay_amount = 0; // paid all for current transaction
					if (!$updateTransaction) {
						throw new Exception("Cập nhật giao dịch thanh toán thất bại!", 1);
					}
				}
				#endregion
			}
			#endregion

            #region --- INSURANCE DEBT
            if ($receipt->pay_type == 4 && $sumInsurance) {
                $insuranceDebt = Insurance::model()->addInsuranceDebt(array(
					'id_branch' => $invoiceModel->id_branch,
                    'id_customer' => $invoiceModel->id_customer,
					'id_invoice' => $invoiceModel->id,
					'code_invoice' => $invoiceModel->code,
                    'id_partner' => $invoiceModel->partnerID,
					'amount' => $sumInsurance,
					'source' => Insurance::INVOICE
                ));

                if ($insuranceDebt['status'] == 0) {
                    Yii::log($insuranceDebt, CLogger::LEVEL_ERROR, 'ADD_INSURANCE_DEBT');
                    throw new Exception("Cập nhật công nợ bảo hiểm thất bại!", 1);
				}
			}
            #endregion

			#region --- DEPOSITE
			if (($receipt->pay_type == 1 || $receipt->pay_type == 2) && isset($_POST['deposit']) && $_POST['deposit'] > 0) {
				$deposit = DepositTransaction::model()->updateCustomerInvoiceDeposit(array(
					'id_customer' => $invoiceModel->id_customer,
					'id_invoice' => $invoiceModel->id,
					'code_invoice' => $invoiceModel->code,
					'amount' => $_POST['deposit'],
					'type' => DepositTransaction::DEPOSIT_ADD_INVOICE
				));

				if ($deposit['status'] == 0) {
                    Yii::log($deposit, CLogger::LEVEL_ERROR, 'ADD_DEPOSITE_INVOICE');
                    throw new Exception("Cập nhật deposit thất bại!", 1);
				}
			}

			if ($receipt->pay_type == 5) {
				$deposite = DepositTransaction::model()->updateCustomerInvoiceDeposit(array(
					'id_customer' => $invoiceModel->id_customer,
					'id_invoice' => $invoiceModel->id,
					'code_invoice' => $invoiceModel->code,
					'amount' => $receipt->pay_amount,
					'type' => DepositTransaction::DEPOSIT_PAY_INVOICE
				));

				if ($deposite['status'] == 0) {
                    Yii::log($deposite, CLogger::LEVEL_ERROR, 'DEPOSIT_PAID');
                    throw new Exception("Cập nhật deposithiểm thất bại!", 1);
				}
			}
			#endregion

			echo $invoiceModel->id;
			$trans->commit();

		} catch(Exception $e) {
			$trans->rollback();
			echo $e->getMessage();
        }

		Yii::app()->end();
	}
	#endregion

	#region --- XOA HOA DON
	public function actionInvoicesDelConfirm() {
		$id_author = Yii::app()->user->getState('user_id');
		$result = Invoice::model()->delInvoice($_POST['id_invoice'], $_POST['id_invoice_detail'], $_POST['id_service'], $_POST['accept_del'], $_POST['id_user'], $_POST['teeth'], $_POST['unit_price'], $_POST['qty'], $_POST['percent_decrease'], $_POST['amount'], $id_author, $_POST['code_service'], $_POST['services_name'], $_POST['user_name']);
		echo json_encode($result);
	}
	#endregion

	#region --- XOA HOA DON - GIAO DIEN HIEN THI
	public function actionInvoicesDel() {
		if (isset($_POST['id_invoice'])) {
			$id_invoice = $_POST['id_invoice'];
		} else {
			echo "-1";
			exit;
		}

		$invoice = Invoice::model()->findByPk($id_invoice);

		$attribs = array('id_invoice' => $id_invoice);

		$criteria = new CDbCriteria(array('order' => 'id_service ASC'));

		$listInvoiceDetail = VInvoiceDetail::model()->findAllByAttributes($attribs, $criteria);

		$this->renderPartial('delete_invoice_modal', array(
			'invoice' => $invoice,
			'listInvoiceDetail' => $listInvoiceDetail,
		));
	}
	#endregion

	#region --- XAC NHAN HOA DON - THONG TIN HOA DON SAU KHI CHON DOI TAC
	public function actionGetNewListInvoiceDetail() {
		$id_pricebook = isset($_POST['id_pricebook']) ? $_POST['id_pricebook'] : false;
		$id_invoice = isset($_POST['id_invoice']) ? $_POST['id_invoice'] : false;

		if (!$id_pricebook && !$id_invoice) {
			echo -1; exit;
		}

		$criteria = new CDbCriteria();
		$criteria->select = 't.id_service, t.price';
		$criteria->join = 'LEFT JOIN `invoice_detail` as id on t.id_service = id.id_service';
		$criteria->condition = "id_pricebook = $id_pricebook AND id.id_invoice = $id_invoice";

		$listPricebookService = PricebookService::model()->findAll($criteria);

		echo CJSON::encode($listPricebookService);
		exit;
	}
	#endregion

	#region --- IN HOA DON
	public function actionERpt() {
		$id = isset($_GET['id']) ? $_GET['id'] : false;
		$idRpt = isset($_GET['idRpt']) ? $_GET['idRpt'] : 0;
		$lang = isset($_GET['lang']) ? $_GET['lang'] : 'vi';

		if ($id) {
			$invoice = VInvoice::model()->findByAttributes(array('id' => $id));
			$ivDetail = VInvoiceDetail::model()->findAllByAttributes(array('id_invoice' => $id), 'status >= 0');

			if ($idRpt == 0) {
				$rpt = Receipt::model()->findAllByAttributes(array('id_invoice' => $id));
			} else {
				$rpt = Receipt::model()->findByPk($idRpt);
			}

			$branch = Branch::model()->findByPk($invoice->id_branch);
			$cus = Customer::model()->findByPk($invoice->id_customer);

			$schedule = CsSchedule::model()->getFutureScheduleOfCustomer($invoice->id_customer);
			$futureSchedule = CHtml::listData($schedule['data'], 'id', function ($val) {
				return date_format(date_create($val->start_time), 'H:i') . ' - ' . date_format(date_create($val->end_time), 'H:i d/m/Y');
			});

			$filename = 'PhieuThu.pdf';

			$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A5', 'en', true, 'UTF-8');
			$html2pdf->pdf->SetTitle('Phieu thu');

			Yii::app()->setLanguage($lang);

			$html2pdf->WriteHTML($this->renderPartial('export_invoices', array('invoice' => $invoice, 'ivDetail' => $ivDetail, 'rpt' => $rpt, 'branch' => $branch, 'cus' => $cus, 'schedule' => $futureSchedule, 'lang' => $lang), true));

			$html2pdf->Output($filename, 'I');
		}
	}
	#endregion

	#region --- IN PHIEU THU
	public function actionPrintReceipt() {
		$id = isset($_GET['id']) ? $_GET['id'] : false;
		$idRpt = isset($_GET['idRpt']) ? $_GET['idRpt'] : 0;
		$lang = isset($_GET['lang']) ? $_GET['lang'] : 'vi';

		if (!$id) {
			echo "Không tồn tại thông tin hóa đơn.";
			exit;
		}

		$invoice = Invoice::model()->find(array(
			'select' => 'code, id_branch, id_customer, sum_amount, sum_insurance, balance',
			'condition' => 'id =' . $id
		));

		if (!$invoice) {
			echo "Thông tin hóa đơn không chính xác.";
			exit;
		}

		Yii::app()->setLanguage($lang);

		$ivDetail = VInvoiceDetail::model()->findAll(array(
			'select' => 'id_service, services_name, services_name_en, description, qty, unit_price, amount, percent_decrease',
			'condition' => "id_invoice = $id AND status >= 0"
		));

		$branch = Branch::model()->find(array(
			'select' => 'address, hotline1, hotline2',
			'condition' => 'id = ' . $invoice->id_branch
		));

		$cus = Customer::model()->find(array(
			'select' => 'code_number, fullname, birthdate, address, deposit',
			'condition' => 'id = ' . $invoice->id_customer
		));

		$allRpt = Receipt::model()->findAll(array(
			'select' => 'pay_amount, pay_date, pay_type',
			'condition' => "id_invoice =  $id",
			'order' => 'pay_date'
		));

		$rpt = null;
		if ($idRpt) {
			$rpt = Receipt::model()->find(array(
				'select' => 'author_name, pay_date, pay_amount, pay_insurance',
				'condition' => "id = $idRpt AND id_invoice = $id"
			));
		}

		$schedule = CsSchedule::model()->getFutureScheduleOfCustomer($invoice->id_customer);
		$futureSchedule = CHtml::listData($schedule['data'], 'id', function ($val) {
			return date_format(date_create($val->start_time), 'H:i') . ' - ' . date_format(date_create($val->end_time), 'H:i d/m/Y');
		});

		$filename = 'PhieuThu.pdf';

		$html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A5', 'en', true, 'UTF-8');
		$html2pdf->pdf->SetTitle('Phieu thu');

		$html2pdf->WriteHTML($this->renderPartial('print_receipt_vi', array(
			'invoice' => $invoice,
			'ivDetail' => $ivDetail,
			'idRpt' => $idRpt,
			'rpt' => $rpt,
			'branch' => $branch,
			'cus' => $cus,
			'allReceipt' => $allRpt,
			'schedule' => $futureSchedule,
			'lang' => $lang
		), true));

		$html2pdf->Output($filename, 'I');
	}
	#endregion

	#region --- GUI MAIL
	public function actionSendMailInvoice() {
		$mailTo = isset($_POST['mailTo']) ? $_POST['mailTo'] : false;
		$id = isset($_POST['id_inv']) ? $_POST['id_inv'] : false;
		$idRpt = isset($_POST['id_rct']) ? $_POST['id_rct'] : 0;
		$lang = isset($_POST['lang']) ? $_POST['lang'] : 'vi';

		if (!$id) {
			echo "0";
			exit;
		}

		$invoice = VInvoice::model()->findByAttributes(array('id' => $id));
		$ivDetail = VInvoiceDetail::model()->findAllByAttributes(array('id_invoice' => $id), 'status >= 0');
		if ($idRpt == 0) {
			$rpt = Receipt::model()->findAllByAttributes(array('id_invoice' => $id));
		} else {
			$rpt = Receipt::model()->findByPk($idRpt);
		}

		$branch = Branch::model()->findByPk($invoice->id_branch);
		$cus = Customer::model()->findByPk($invoice->id_customer);

		$view = ($lang == 'vi') ? 'send_invoiceMail' : 'send_invoiceMail';

		$email_content = $this->renderPartial($view, array('invoice' => $invoice, 'ivDetail' => $ivDetail, 'rpt' => $rpt, 'branch' => $branch, 'cus' => $cus), true);
		$title = "Nhakhoa2000 Support";

		$mail = Sms::model()->sendMail($mailTo, $title, $email_content);

		echo $mail;
	}
	#endregion

    #region --- LAYOUT - TAO / CAP NHAT HOA DON
    public function actionInvoiceLayout() {
        #region --- PHAN QUYEN HOP DONG
		$group_id = Yii::app()->user->getState('group_id');
		$createQuote = 0;
		// bac sỹ
		if($group_id == 3 || $group_id == 17){ $createQuote = 1; }
		// tiep tan
		elseif ($group_id == 4 || $group_id == 16) { $createQuote = 1; }
		// dieu hanh + admin
		elseif ($group_id == 1 || $group_id == 2 || $group_id == 11) { $createQuote = 1; }
        #endregion

        $id_group_history = isset($_POST['id_mhg']) ? $_POST['id_mhg'] : '';
		$id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : 0;
		$id_schedule = isset($_POST['id_schedule']) ? $_POST['id_schedule'] : 0;
        $teeth = isset($_POST['teeth']) ? $_POST['teeth'] : '';
        $id_invoice = isset($_POST['id_invoice']) ? $_POST['id_invoice'] : false;

        $invoice = null; $invoiceDetail = null; $isUpdate = true;
        $customerObj = array();

        if ($id_invoice) {
            $invoice = Invoice::model()->findByAttributes(array('id' => $id_invoice, 'confirm' => 0));
            if ($invoice) {
                $id_customer = $invoice->id_customer;
                $invoiceDetail = InvoiceDetail::model()->findAllByAttributes(array('id_invoice' => $id_invoice), "status >= 0");
            }
        }

        if (!$invoice || !$invoiceDetail) {
            $invoice = new Invoice();
            $invoiceDetail = new InvoiceDetail();
            $isUpdate = false;
        }

		if ($id_customer) {
			$customer = Customer::model()->findByPk($id_customer);
			if ($customer) {
				$customerObj[] = array(
					'id' => $id_customer,
					'fullname' => $customer->fullname
				);
			}
        }

        if ($isUpdate == true) {
            $invoice_new = new InvoiceDetail();

            return $this->renderPartial('update', array(
                'invoice' => $invoice,
                'invoice_detail' => CJSON::encode($invoiceDetail),
                'invoice_new' => $invoice_new,

                'branchList' => $this->getBranchList(),
                'userList' => CJSON::encode($this->getUserList()),

                'customerObj' => $customerObj,

                'teeth' => $teeth,
                'id_schedule' => $id_schedule,

                'createQuote' => $createQuote,
            ));
        }

        return $this->renderPartial('create', array(
            'branchList' => $this->getBranchList(),

            'invoice' => $invoice,
            'invoice_detail' => $invoiceDetail,

            'id_customer' => $id_customer,
            'customerObj' => $customerObj,

            'id_group_history' => $id_group_history,
            'id_schedule' => $id_schedule,
            'teeth' => $teeth,
            'createQuote' => $createQuote,
        ));
    }
    #endregion

	#region --- TAO MOI HOA DON
	public function actionCreate() {
		if (isset($_POST['Invoice']) && isset($_POST['InvoiceDetail'])) {
			$trans = Yii::app()->db->beginTransaction();
			$result = array();
			try {
				$invoice = Invoice::model()->updateInvoice($_POST['Invoice'], $_POST['InvoiceDetail']);

				$result = $invoice;
				if ($invoice['status'] == 'fail') {
					throw new Exception("Error Processing Request", 1);
				}

				$trans->commit();
			} catch(Exception $e) {
				$message = $e->getMessage();
				if(empty($result)) {
					$result = $e->getMessage();
				} else {
					$message = $result['error-message'];
				}
				Yii::log($message, CLogger::LEVEL_ERROR, 'application');
				$trans->rollback();
			}
			echo json_encode($result);
		}
	}
	#endregion

	#region --- CAP NHAT HOA DON
	public function actionUpdateInvoice() {
		#region --- XU LY CAP NHAT BAO GIA
		if (isset($_POST['Invoice']) && isset($_POST['InvoiceDetail'])) {
			$trans = Yii::app()->db->beginTransaction();
			$result = array();
			try {

				$invoice = Invoice::model()->updateInvoice($_POST['Invoice'], $_POST['InvoiceDetail']);

				$result = $invoice;
				if ($invoice['status'] == 'fail') {
					throw new Exception("Error Processing Request", 1);
				}

				$trans->commit();
			} catch(Exception $e) {
				$message = $e->getMessage();
				if(empty($result)) {
					$result = $e->getMessage();
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

	#region --- LAY THONG TIN CHI TIET DICH VU
	public function actionGetInvoiceDetail() {
		$id = isset($_POST['id_invoice_detail']) ? $_POST['id_invoice_detail'] : false;

		if (!$id) {
			echo CJSON::encode(array());
			exit;
		}

		$invoiceDetail = VInvoiceDetail::model()->find(array(
			'select' => 'id, amount, id_quotation_item, id_invoice, id_service, teeth, qty, id_user, user_name, status, IFNULL(percent_change, 0) as percent_change',
			'condition' => 'id = ' . $id
		));

		if ($invoiceDetail->status == -2) {
			$invoiceDetailChange = VInvoiceDetail::model()->find(array(
				'select' => 'id, amount, user_name, IFNULL(percent_change, 0) as percent_change',
				// 'condition' => "id_quotation_item = " . $invoiceDetail->id_quotation_item . " AND id_invoice = " . $invoiceDetail->id_invoice . " AND id_service = " . $invoiceDetail->id_service . " AND teeth = " . $invoiceDetail->teeth . " AND qty = " .$invoiceDetail->qty . " AND id > " . $invoiceDetail->invoiceDetail
				'condition' => "id_invoice = " . $invoiceDetail->id_invoice . " AND id_service = " . $invoiceDetail->id_service . " AND status = -3 ",
				'order' => 'id desc'
			));

			echo CJSON::encode($invoiceDetailChange);
		} else {
			echo CJSON::encode($invoiceDetail);
		}
	}
	#endregion

	#region --- KIEM TRA HOA DON THEO DOT DIEU TRI
	public function actionCheckInvoiceWithHistoryGroup() {
		$id_mhg = isset($_POST['id_mhg']) ? $_POST['id_mhg'] : false;

		if(!$id_mhg) {echo 0;}
		$today = date('Y-m-d');
		$invoice = Invoice::model()->findByAttributes(array('id_group_history' => $id_mhg), " '$today 00:00:01' <= create_date AND create_date <= '$today 23:59:59' AND status >= 0 AND code IS NULL");

		if ($invoice) {
			echo $invoice->id;
		} else {
			echo 0;
		}
	}
	#endregion

	#region --- TRANSACTION - HUY DICH VU
	public function actionTransCancel() {
		$data = $_POST;

		$trans = Yii::app()->db->beginTransaction();
		$result = array();

		try {
			$result = Invoice::model()->transactionCancel($data);

			if ($result['status'] == 0) {
				throw new Exception("Error Processing Request", 1);
			}

			$trans->commit();
		} catch(Exception $e) {
			$message = $e->getMessage();

			if (!$result['error-message']) {
				$result = $message;
			} else {
				$message = $result['error-message'];
			}

			Yii::log($message, CLogger::LEVEL_ERROR, 'application');
			$trans->rollback();
		}
		echo json_encode($result);
	}

	public function actionTransCancel1() {
		$id = $_POST['id'];
		$percent = $_POST['percent'];
		$result = array();
		$logic = new CancelInvoiceLogic;
		$logic->attributes = array('id' => $id, 'percent' => $percent);
		if (!$logic->run()) {
			$errors = $logic->getErrors();
			$error = reset(reset($errors));
			Yii::log($message, CLogger::LEVEL_ERROR, 'application');
			$result = array('status' => 0, 'error-message' => $message, 'errors' => $errors);

		} else {
	        $result = array('status' => 1);
		}
		echo json_encode($result);

	}
	#endregion

	#region --- TRANSACTION - CHUYEN DICH VU
	public function actionTransChange() {
		$data = $_POST;

		$trans = Yii::app()->db->beginTransaction();
		$result = array();

		try {
			$result = Invoice::model()->transactionChange($data);

			if ($result['status'] == 0) {
				throw new Exception("Error Processing Request", 1);
			}

			$trans->commit();
		} catch(Exception $e) {
			$message = $e->getMessage();

			if (!isset($result['error-message']) || !$result['error-message']) {
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