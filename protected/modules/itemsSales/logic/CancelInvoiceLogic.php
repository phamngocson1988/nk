<?php
if (!function_exists('array_column')) {
    function array_column($array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = is_object($subArray)?$subArray->$columnKey: $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $index = is_object($subArray)?$subArray->$indexKey: $subArray[$indexKey];
                    $result[$index] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $index = is_object($subArray)?$subArray->$indexKey: $subArray[$indexKey];
                    $result[$index] = is_object($subArray)?$subArray->$columnKey: $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}


class CancelInvoiceLogic extends CFormModel
{
	/** invoice detail id **/
	public $id;

	/** Percent cancel/change **/
	public $percent;

	/** InvoiceDetail **/
	protected $_invoiceDetail;

	/** Invoice **/
	protected $_invoice;


	public function rules()
	{
		return array(
			array(array('id', 'percent'), 'required'),
			array('percent', 'numerical', 'integerOnly' => true, 'min' => 1),
			array('id', 'validateInvoiceDetail')
		);
	}

	public function validateInvoiceDetail($attribute, $params)
	{
		$invoice_detail = $this->getInvoiceDetail();
		if (!$invoice_detail) {
	        return $this->addError($attribute, 'Invoice Detail không tồn tại');
	  	}
	  	if ($invoice_detail->status == InvoiceDetail::STATUS_CANCEL) {
	        return $this->addError($attribute, 'Invoice Detail đã bị huỷ');
	  	}
	  	$invoice = $this->getInvoice();
	  	if (!$invoice) {
	  		return $this->addError($attribute, 'Invoice không tồn tại');
	  	}
	  	// if ($invoice->confirm != Invoice::STATUS_CONFIRM) {
	  	// 	return $this->addError($attribute, 'Invoice chưa được xác nhận');
	  	// }
	}

	public function getInvoiceDetail()
	{
		if (!$this->_invoiceDetail) {
			$this->_invoiceDetail = InvoiceDetail::model()->findByPk($this->id);
		}
		return $this->_invoiceDetail;
	}

	public function getInvoice()
	{
		$invoice_detail = $this->getInvoiceDetail();
		if (!$this->_invoice && $invoice_detail) {
			$this->_invoice = Invoice::model()->findByPk($invoice_detail->id_invoice);
		}
		return $this->_invoice;
	}

	/**
	 * Update Invoice detail status to -1
	 * Update amount of invoice detail
	 * Update balance of invoice
	 * Update transaction invoice (update PKC and create HoanTien)
	 */
	public function run() 
	{
		if (!$this->validate()) {
			$errors = $this->getErrors();
			print_r($errors);die;
			return false;
		}
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$invoicedetail = $this->getInvoiceDetail();
			$invoice = $this->getInvoice();
			$now = date('Y-m-d H:i:s');
			$percent = $this->percent;
			$refund = ($invoicedetail->amount / 100) * $percent;
			$totalDecrease = ($invoicedetail->unit_price * $invoicedetail->qty) * ($percent / 100);
			$discountDecrease = ($invoicedetail->unit_price * $invoicedetail->qty) * ($invoicedetail->percent_decrease / 100) * ($percent / 100);

			// Invoice detail
			$invoicedetail->status = InvoiceDetail::STATUS_CANCEL;
	        $invoicedetail->percent_change = $percent;
	        $invoicedetail->amount = $invoicedetail->amount * (100 - $percent) / 100;
	        $invoicedetail->save();

	        // Invoice
			$invoice->total = $invoice->total - $totalDecrease;
			$invoice->amount_reduced = $invoice->amount_reduced - $discountDecrease;
			$invoice->sum_amount = $invoice->total - $invoice->amount_reduced;
			$invoice->save();

			if ($invoice->confirm != Invoice::STATUS_CONFIRM) {
				// Update PKC Transation
				$criteria = new CDbCriteria();
				$criteria->addCondition('id_invoice = :id_invoice');
				$criteria->addCondition('id_service = :id_service');
				$criteria->addCondition('id_user = :id_user');
				$criteria->addCondition('debt = :debt');
				$criteria->params[':id_invoice'] = $invoicedetail->id_invoice;
				$criteria->params[':id_service'] = $invoicedetail->id_service;
				$criteria->params[':id_user'] = $invoicedetail->id_user;
				$criteria->params[':debt'] = TransactionInvoice::PhongKhamChuyen;
				$pkcTransactions = TransactionInvoice::model()->findAll($criteria);
				foreach ($pkcTransactions as $pkcTransaction) {
					$pkcTransaction->amount = $pkcTransaction->amount * (100 - $percent) / 100;
					$pkcTransaction->save();
				}

				// Create HoanTien receipt
				$receipt = new Receipt();
				$receipt->pay_type = 1;
				$receipt->code = Receipt::model()->createCodeRecept();
				$receipt->id_author = Yii::app()->user->getState('user_id');
				$receipt->author_name = Yii::app()->user->getState('name');
				$receipt->pay_date = $now;
				$receipt->id_invoice = $invoice->id;
				$receipt->pay_amount = $refund;
				$receipt->pay_sum = $refund;
				$receipt->curr_amount = $refund;
				$receipt->is_company = 0;
				$receipt->save();

				// Create Payment slip
	        	$viewInvoiceDetail = VInvoiceDetail::model()->findByAttributes(array('id' => $this->id));
				$description = "HUỶ DỊCH VỤ HÓA ĐƠN SỐ " . $invoice->code . ". " . $viewInvoiceDetail->code_service . " - " . $viewInvoiceDetail->services_name . " - " .$viewInvoiceDetail->user_name . " - ". $viewInvoiceDetail->amount . ' - ' . $refund;

				$description = sprintf("HUỶ DỊCH VỤ HÓA ĐƠN SỐ %s. %s - %s - %s - %s - %s", $invoice->code, $viewInvoiceDetail->code_service, $viewInvoiceDetail->services_name, $viewInvoiceDetail->user_name, $viewInvoiceDetail->amount, $refund);
				VReceivable::model()->AddnewReceivableAccount(array(
		            'id_customer' => $invoice->id_customer,
		            'description' => $description,
		            'amount' => $refund,
		            'order_number' => $invoice->code,
		            'id_user' => Yii::app()->user->getState('user_id'),
		            'received_date' => date('Y-m-d'),
		            'type' => 3,
		        ));


				// Create HoanTien transaction
				$serviceTransaction = TransactionInvoice::model()->findByAttributes(array(
					'id_invoice' => $invoicedetail->id_invoice, 
					'id_service' => $invoicedetail->id_service, 
					'id_user' => $invoicedetail->id_user
				));
				if ($serviceTransaction) {
					$refundTransaction = new TransactionInvoice();
					$refundTransaction->attributes = $serviceTransaction->attributes;
					$refundTransaction->percent = 0;
					$refundTransaction->create_date = $now;
					$refundTransaction->confirm_date = $now;
					$refundTransaction->pay_date = $now;
					$refundTransaction->amount = $refund;
					$refundTransaction->debt = TransactionInvoice::HoanTra;
					$refundTransaction->status = 1;
					$refundTransaction->id_receipt = $receipt->id;
					$refundTransaction->save();
				}
			}
		    $transaction->commit();
		    // actions to do on success (redirect, alert, etc.)
		    return true;
		} catch (Exception $e) {
		    $transaction->rollBack();
		    // other actions to perform on fail (redirect, alert, etc.)
		    $this->addError('id', $e->getMessage());
		    return false;
		} 
	}
}