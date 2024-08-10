<?php

/**
 * This is the model class for table "invoice".
 *
 * The followings are the available columns in table 'invoice':
 * @property integer $id
 * @property string $code
 * @property integer $id_quotation
 * @property string $code_quotation
 * @property integer $id_schedule
 * @property integer $id_author
 * @property integer $id_customer
 * @property integer $id_branch
 * @property integer $id_group_history
 * @property string $create_date
 * @property string $complete_date
 * @property double $sum_insurance
 * @property double $sum_amount
 * @property double $sum_amount_usd
 * @property double $sum_no_vat
 * @property double $sum_tax
 * @property double $vat
 * @property string $note
 * @property integer $isVat
 * @property string $date_vat
 * @property string $place_vat
 * @property double $balance
 * @property integer $status
 * @property integer $confirm
 * @property double $total
 * @property double $amount_reduced
 * @property string $name_price_book
 * @property double $percent_decrease
 * @property double $exchange
 * @property integer $partnerID
 */

class Invoice extends CActiveRecord {
    private $_maxInvoice = 718;

    #region --- PARAMS
        CONST FLAG_VND = 1;
        CONST FLAG_USD = 2;
    #endregion

    const STATUS_CONFIRM = 1;

    #region --- PARAMS
    static $invoice_type = array(
		'0' => '',
		'1' => 'Tiền mặt',
		'2' => 'Thẻ tín dụng',
		'3' => 'Chuyển khoản',
        '4' => 'Bảo hiểm bảo lãnh',
        '5' => 'Deposit',
	);

	static $invoice_type_vi = array(
		'0' => '',
		'1' => 'Tiền mặt',
		'2' => 'Thẻ tín dụng',
		'3' => 'Chuyển khoản',
        '4' => 'Bảo hiểm bảo lãnh',
        '5' => 'Deposit',
	);

	static $invoice_type_en = array(
		'0' => '',
		'1' => 'Cash',
		'2' => 'Credit Card',
		'3' => 'Transfer',
        '4' => 'Insurance',
        '5' => 'Deposit',
	);
    #endregion

    #region --- TABLE NAME
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'invoice';
    }
    #endregion

    #region --- RULES
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_quotation, id_schedule, id_author, id_customer, id_branch, id_group_history, status, confirm, partnerID', 'numerical', 'integerOnly'=>true),
            array('isVat, sum_insurance, sum_amount, sum_amount_usd, sum_no_vat, sum_tax, vat, balance, total, amount_reduced, percent_decrease, exchange', 'numerical'),
            array('code', 'length', 'max'=>45),
            array('code_quotation', 'length', 'max'=>20),
            array('place_vat', 'length', 'max'=>255),
            array('name_price_book', 'length', 'max'=>25),
            array('complete_date, note, date_vat', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, id_quotation, code_quotation, id_schedule, id_author, id_customer, id_branch, id_group_history, create_date, complete_date, sum_insurance, sum_amount, sum_amount_usd, sum_no_vat, sum_tax, vat, note, isVat, date_vat, place_vat, balance, status, confirm, total, amount_reduced, name_price_book, percent_decrease, exchange, partnerID', 'safe', 'on'=>'search'),
        );
    }
    #endregion

    #region --- RELATIONS
    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }
    #endregion

    #region --- ATTRIBUTE LABELS
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'id_schedule' => 'Id Schedule',
            'id_author' => 'Người tạo',
            'id_customer' => 'Khách hàng',
            'id_branch' => 'Chi nhánh',
            'id_group_history' => 'Id Group History',
            'create_date' => 'Ngày bắt đầu',
            'complete_date' => 'Ngày kết thúc',
            'sum_amount' => 'Sum Amount',
            'sum_no_vat' => 'Sum No Vat',
            'sum_tax' => 'Sum Tax',
            'vat' => 'Vat',
            'note' => 'Ghi chú',
            'date_vat' => 'Date Vat',
            'place_vat' => 'Place Vat',
            'balance' => 'Balance',
            'status' => 'Status',
            'confirm' => 'Confirm',
            'total' => 'Total',
            'amount_reduced' => 'Amount Reduced',
            'name_price_book' => 'Name Price Book',
            'percent_decrease' => 'Percent Decrease',
        );
    }
    #endregion

    #region --- SEARCH
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('code',$this->code,true);
        $criteria->compare('id_schedule',$this->id_schedule);
        $criteria->compare('id_author',$this->id_author);
        $criteria->compare('id_customer',$this->id_customer);
        $criteria->compare('id_branch',$this->id_branch);
        $criteria->compare('id_group_history',$this->id_group_history);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('complete_date',$this->complete_date,true);
        $criteria->compare('sum_amount',$this->sum_amount);
        $criteria->compare('sum_no_vat',$this->sum_no_vat);
        $criteria->compare('sum_tax',$this->sum_tax);
        $criteria->compare('vat',$this->vat);
        $criteria->compare('note',$this->note,true);
        $criteria->compare('date_vat',$this->date_vat,true);
        $criteria->compare('place_vat',$this->place_vat,true);
        $criteria->compare('balance',$this->balance);
        $criteria->compare('status',$this->status);
        $criteria->compare('confirm',$this->confirm);
        $criteria->compare('total',$this->total);
        $criteria->compare('amount_reduced',$this->amount_reduced);
        $criteria->compare('name_price_book',$this->name_price_book,true);
        $criteria->compare('percent_decrease',$this->percent_decrease);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    #endregion

    #region --- MODEL
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Invoice the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    #endregion

    #region --- TAO MA HOA DON - BUOC XAC NHAN
    public function createCodeInvoice(){
        $date = date('Y-m-d');
        $code = str_replace(array('-', ' ', ':'), '', substr($date, 2));
        $num = Invoice::model()->count(array('condition' => 'date(create_date) ="' . $date . '" AND code IS NOT NULL')) + 1;
        $codenum = str_pad($num, '3', '0', STR_PAD_LEFT);
        $code .= $codenum;
        return $code;
    }
    #endregion

    #region --- TAO HOA DON
    public function addInvoice($invoiceData = array(), $invoiceDetailData = array()) {
        if (!is_array($invoiceData) || empty($invoiceData)) {
            return array('status' => 'fail', 'error-message' => 'Không có thông tin hóa đơn');
        }

        if (!is_array($invoiceDetailData) || empty($invoiceDetailData)) {
            return array('status' => 'fail', 'error-message' => 'Không có thông tin dịch vụ hóa đơn');
        }

        $invoice = new Invoice();
        $invoice->attributes = $invoiceData;
        $invoice->create_date = date('Y-m-d H:i:s');
        $invoice->id_schedule = (isset($invoiceData['id_schedule']) && $invoiceData['id_schedule']) ? $invoiceData['id_schedule'] : 0;

        unset($invoice->code);
        unset($invoice->modified_date);

        $invoiceDetailArray = array();
        $sumAmount = 0;
        $sumAmountUSD = 0;

        if ($invoice->validate()) {
            foreach ($invoiceDetailData as $k => $val) {
                if ($val['status'] == 0) {
                    continue;
                }

                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->attributes = $val;
                $invoiceDetail->id_quotation_item = (isset($val['id_quotation_item']) && $val['id_quotation_item']) ? $val['id_quotation_item'] : 0;
                $invoiceDetail->id_author = $invoice->id_author;
                $invoiceDetail->status = 0;
                unset($invoiceDetail->create_date);

                if (!$invoiceDetail->id_quotation_item) {
                    unset($invoiceDetail->id_quotation_item);
                }

                if ($invoiceDetail->validate()) {
                    if ($invoiceDetail->flag_price == self::FLAG_VND) {
                        $sumAmount += $invoiceDetail->amount;
                    } else if ($invoiceDetail->flag_price == self::FLAG_USD){
                        $sumAmountUSD += $invoiceDetail->amount;
                    }

                    $invoiceDetailArray[] = $invoiceDetail;
                } else {
                    return array('status' => 'fail', 'error-message' => $invoiceDetail->getErrors());
                }
            }
        } else {
            return array('status' => 'fail', 'error-message' => $invoice->getErrors());
        }

        $invoice->sum_amount = $sumAmount;
        $invoice->sum_amount_usd = $sumAmountUSD;
        $invoice->balance = $sumAmount + $sumAmountUSD;

        if (empty($invoiceDetailArray)) {
            return array('status' => 'fail', 'error-message' => 'Hóa đơn không có dịch vụ!');
        }

        if ($invoice->save()) {
            $id_invoice = $invoice->id;
            foreach ($invoiceDetailArray as $key => $value) {
                $value->id_invoice = $id_invoice;
                if (!$value->save()) {
                    return array('status' => 'fail', 'error-message' => $value->getError());
                }
            }

            return array('status' => 'successful', 'data' => array(
                'invoice' => $invoice->attributes
            ));
        } else {
            return array('status' => 'fail', 'error-message' => $invoice->getErrors());
        }
    }
    #endregion

    #region --- CAP NHAT HOA DON
    public function updateInvoice($invoiceData = array(), $invoiceDetailData = array()) {
        if (!is_array($invoiceData) || empty($invoiceData)) {
            return array('status' => 'fail', 'error-message' => 'Không có thông tin hóa đơn');
        }

        if (!is_array($invoiceDetailData) || empty($invoiceDetailData)) {
            return array('status' => 'fail', 'error-message' => 'Không có thông tin dịch vụ hóa đơn');
        }

        $id_mhg = isset($invoiceData['id_group_history']) ? $invoiceData['id_group_history'] : false;
        if (!$id_mhg) {
            return $this->addInvoice($invoiceData, $invoiceDetailData);
        }

        $today = date('Y-m-d');
        $invoice = Invoice::model()->findByAttributes(array('id_group_history' => $id_mhg), " '$today 00:00:01' <= create_date AND create_date <= '$today 23:59:59' AND code IS NULL AND status >= 0");

        if (!$invoice) {
            return $this->addInvoice($invoiceData, $invoiceDetailData);
        }

        $invoiceDetailNum = InvoiceDetail::model()->countByAttributes(array('id_invoice' => $invoice->id));
        $invoiceDetailCancel = InvoiceDetail::model()->countByAttributes(array('id_invoice' => $invoice->id,'status' => -1));

        if (!$invoice->id_quotation || !$invoice->code_quotation) {
            $invoice->id_quotation = isset($invoiceData['id_quotation']) ? $invoiceData['id_quotation'] : 0;
            $invoice->code_quotation = isset($invoiceData['code_quotation']) ? $invoiceData['code_quotation'] : '';
        }

        $invoice->id_schedule = ($invoiceData['id_schedule']) ? $invoiceData['id_schedule'] : 0;
        $invoice->status = 0;

        $sumAmount = $invoice->sum_amount;
        $sumAmountUSD = $invoice->sum_amount_usd;

        if ($invoiceDetailNum == 0 || $invoiceDetailCancel == $invoiceDetailNum) {
            $invoice->create_date = date('Y-m-d H:i:s');
            $invoice->id_author = Yii::app()->user->getState('user_id');
            $sumAmount = 0;
            $sumAmountUSD = 0;
        }

        $invoiceDetailArray = array();

        if ($invoice->validate()) {
            foreach ($invoiceDetailData as $k => $val) {
                if ($val['status'] == 0 || !$val['code_service'] || !isset($val['id_service'])) {
                    continue;
                }

                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->attributes = $val;
                $invoiceDetail->id_author = $invoice->id_author;
                $invoiceDetail->id_quotation_item = (isset($val['id_quotation_item']) && $val['id_quotation_item']) ? $val['id_quotation_item'] : 0;
                $invoiceDetail->status = 0;
                unset($invoiceDetail->create_date);

                if ($invoiceDetail->validate()) {
                    if ($invoiceDetail->flag_price == self::FLAG_VND) {
                        $sumAmount += $invoiceDetail->amount;
                    } else if ($invoiceDetail->flag_price == self::FLAG_USD){
                        $sumAmountUSD += $invoiceDetail->amount;
                    }

                    $invoiceDetailArray[] = $invoiceDetail;
                } else {
                    return array('status' => 'fail', 'error-message' => $invoiceDetail->getErrors());
                }
            }
        } else {
            return array('status' => 'fail', 'error-message' => $invoice->getErrors());
        }

        $invoice->sum_amount = $sumAmount;
        $invoice->sum_amount_usd = $sumAmountUSD;
        $invoice->balance = $sumAmount + $sumAmountUSD;

        unset($invoice->modified_date);

        if ($invoice->save()) {
            $id_invoice = $invoice->id;
            foreach ($invoiceDetailArray as $key => $value) {
                $value->id_invoice = $id_invoice;

                if (!$value->save()) {
                    return array('status' => 'fail', 'error-message' => $value->getError());
                }
            }

            return array('status' => 'successful', 'data' => array(
                'invoice' => $invoice->attributes
            ));
        } else {
            return array('status' => 'fail', 'error-message' => $invoice->getErrors());
        }
    }
    #endregion

    #region --- XOA HOA DON
    public function delInvoice($id_invoice, $id_invoice_detail, $id_service, $accept, $id_user, $teeth, $unit_price, $qty, $percent_decrease, $amount, $id_author, $code_service, $name_services, $user_name) {
        if (!$id_invoice) {
            return array('status' => 'Fail', 'error-message' => 'id_invoice not invalid');
        }

        if (!$id_invoice_detail) {
            return array('status' => 'Fail', 'error-message' => 'id_invoice_detail not invalid');
        }

        if (!$id_service) {
            return array('status' => 'Fail', 'error-message' => 'id_service not invalid');
        }

        $total = 0;    // tong cong = unit_price * qty
        $amount_reduced = 0;    // tien giam: total - sum_amount
        $sum_amount = 0;    // thanh tien
        $sum_pay = 0;
        $des = '';
        $description_array = array();

        $invoice = Invoice::model()->findByPk($id_invoice);
        $id_service_del = '';

        // id_invoice_detail: mang id invoice detail
        foreach ($id_invoice_detail as $key => $value) {
            if (!in_array($value, $accept)) {continue;}

            $total += ($unit_price[$key] * $qty[$key]);
            $amount_reduced += $total * $percent_decrease[$key] / 100;
            $sum_amount += $amount[$key];
            $id_service_del .= (string)$id_service[$key] . ',';
            $is_user_condition = ($id_user[$key]) ? " AND id_user = '$id_user[$key]'" : " AND id_user IS NULL";

            if ($invoice->id_quotation) {
                $quotationDetail = QuotationService::model()->updateAll(array('status'=>0), "id_quotation = $invoice->id_quotation AND id_service = $id_service[$key] $is_user_condition AND teeth = '$teeth[$key]' AND status = 1");
            }

            $invoiceItemDel = InvoiceDetail::model()->updateByPk($id_invoice_detail[$key],array('status' => -1));

            $description_array[$id_service[$key]] = "$code_service[$key] - $name_services[$key] - $user_name[$key] - $amount[$key]";
        }

        if ($id_service_del[strlen($id_service_del)-1] == ',') {
            $id_service_del = substr($id_service_del, 0, strlen($id_service_del)-1);
        }

        // danh sach transaction can huy cua hoa don
        $trans = TransactionInvoice::model()->findAllByAttributes(array('id_invoice'=>$id_invoice), "id_service IN ($id_service_del)");
        $trans_pay = array();

        if ($trans) {
            foreach ($trans as $key => $value) {
                // Lay tong gia tri cua transaction co gia tri thanh toan do
                if ($value->debt == TransactionInvoice::ThanhToan) {
                    if (array_key_exists($value->id_service, $trans_pay)) {
                        $trans_pay[$value->id_service]->amount += $value->amount;
                    } else {
                        $trans_pay[$value->id_service] = $value;
                    }
                }

                // Tao transaction co gia tri am
                if ($value->debt == TransactionInvoice::PhongKhamChuyen) {
                    $trans_new             = new TransactionInvoice();
                    $trans_new->attributes = $value->attributes;
                    $trans_new->amount     = $value->amount*-1;
                    $trans_new->pay_date   = date('Y-m-d');
                    $trans_new->debt       = TransactionInvoice::HoanTra;
                    unset($trans_new->id);
                    $trans_new->save();
                }

                // Xoa transaction con no
                if ($value->debt == TransactionInvoice::ConNo) {
                    TransactionInvoice::model()->deleteByPk($value->id);
                }
            }
        }

        // danh sach transaction da thanh toan
        if ($trans_pay) {
            foreach ($trans_pay as $key => $value) {
                $description_array[$key] = $description_array[$key] . " - ". $value->amount.".";
                $sum_pay                 += $value->amount;

                $trans_new             = new TransactionInvoice();
                $trans_new->attributes = $value->attributes;
                $trans_new->amount     = $value->amount*-1;
                $trans_new->pay_date   = date('Y-m-d');
                $trans_new->debt       = TransactionInvoice::HoanTra;
                unset($trans_new->id);
                $trans_new->save();
            }
        }

        // huy hoa don
        if (count($accept) == count($id_invoice_detail)) {
            $sum_amount_cal = $sum_amount;
            $sum_pay        = $invoice->sum_amount - $invoice->balance;
            Invoice::model()->updateByPk($id_invoice, array('status'=>-1));
            $id_invoice = '';
        } else {
            $total          = $invoice->total - $total;
            $sum_amount_cal = $invoice->sum_amount - $sum_amount;
            $amount_reduced = $total - $sum_amount;
            $balance        = 0;
            // Tinh gia tri con no = tong co transaction con no
            $t = new CDbCriteria;
            $t->addCondition("id_invoice = $id_invoice");
            $t->addCondition("debt = " .TransactionInvoice::ConNo);
            $t->select  = "SUM(amount) as sum";
            $sumBalance = TransactionInvoice::model()->find($t);

            if ($sumBalance) {
                $balance = $sumBalance->sum;
            }

            Invoice::model()->updateByPk($id_invoice, array("total" => $total, "amount_reduced" => $amount_reduced, "sum_amount" => $sum_amount_cal, "balance" => $balance));
        }

        $des = implode(". ", $description_array);
        $receiverAccount = VReceivable::model()->AddnewReceivableAccount(array(
            'id_customer'   =>  $invoice->id_customer,
            'description'   =>  'HUỶ HOÁ ĐƠN SỐ '. $invoice->code . '. ' .$des,
            'amount'        =>  $sum_pay,
            'order_number'  =>  $invoice->code,
            'id_user'       =>  $id_author,
            'received_date' =>  date('Y-m-d'),
            'type'          =>  3,
        ));

        return array('status' => 'successful','id_invoice'=>$id_invoice);
    }
    #endregion

    #region --- XAC NHAN HOA DON
    public function confirmInvoice($data) {
        #region --- CHECK INPUT
        $id_invoice = isset($data['id_invoice']) ? $data['id_invoice'] : false;
        if (!$id_invoice) {
            return array('status' => 0, 'error-message' => 'Không tồn tại thông tin hóa đơn!');
        }

        if (!isset($data['InvoiceDetail']) && !$data['InvoiceDetail']) {
            return array('status' => 0, 'error-message' => 'Không tồn tại thông tin hóa đơn!');
        }

        if (!isset($data['id_customer']) && !$data['id_customer']) {
            return array('status' => 0, 'error-message' => 'Không tồn tại thông tin hóa đơn!');
        }

        $old_invoice = Invoice::model()->findByPk($id_invoice);
        if (!$old_invoice) {
            return array('status' => 0, 'error-message' => 'Không tồn tại thông tin hóa đơn!');
        }

        $detail_count = InvoiceDetail::model()->countByAttributes(array('id_invoice' => $id_invoice));
        if ($detail_count <= 0) {
            return array('status' => 0, 'error-message' => 'Không tồn tại thông tin hóa đơn!');
        }
        #endregion

        $id_price_book = isset($data['id_price_book']) ? $data['id_price_book']: false;
        $exchange_rate = isset($data['exchange_rate']) ? $data['exchange_rate']: 1;

        $isAllConfirm = true;

        $new_sum_amount = 0;
        $old_sum_amount = 0; $old_sum_amount_usd = 0;

        $trans = Yii::app()->db->beginTransaction();
        $result = array();

        try {
            #region --- INVOICE
            $new_invoice = $old_invoice;

            if ($detail_count > $data['check']) {
                $isAllConfirm = false;
                $new_invoice = new Invoice();
                $new_invoice->attributes = $old_invoice->attributes;
            }

            $new_invoice->attributes = $data;
            $new_invoice->code = $this->createCodeInvoice();
            $new_invoice->create_date = date('Y-m-d H:i:s');
            $new_invoice->confirm = 1;
            $new_invoice->exchange = $exchange_rate;
            $new_invoice->percent_decrease = $data['percent_decrease_of_invoice'];

            if (!$isAllConfirm) {
                unset($new_invoice->id);
            }

            unset($new_invoice->modified_date);

            if (!($new_invoice->validate() && $new_invoice->save())) {
                $result = array('status' => 0, 'error-message' => 'Cập nhật hóa đơn thất bại');
                throw new Exception("Error", 1);
            }

            $new_id_invoice = $new_invoice->id;
            #endregion

            foreach ($data['InvoiceDetail'] as $key => $value) {
                $id_invoice_detail = $value['id_invoice_detail'];
                $old_detail = InvoiceDetail::model()->findByAttributes(array('id' => $id_invoice_detail, 'id_invoice' => $id_invoice));
                $old_detail->amount_view = $old_detail->amount;

                #region --- CHECK INVOICE DETAIL
                if (!$old_detail) {
                    $result = array('status' => 0, 'error-message' => 'Chi tiết hóa đơn không hợp lệ.');
                    throw new Exception("Error", 1);
                }

                if (!isset($value['accept']) || $value['accept'] != 1) {
                    continue;
                }
                #endregion

                #region --- INVOICE DETAIL
                if ($old_detail->flag_price == self::FLAG_USD) {
                    $old_sum_amount_usd += $old_detail->amount_view;
                } else {
                    $old_sum_amount += $old_detail->amount_view;
                }

                $old_detail->attributes = $value;
                $old_detail->id_invoice = $new_id_invoice;
                $old_detail->id_author = Yii::app()->user->getState('user_id');
                $old_detail->status = 1;
                $old_detail->flag_price = self::FLAG_VND;

                if (!($old_detail->validate() && $old_detail->save())) {
                    $result = array('status' => 0, 'error-message' => 'Cập nhật chi tiết hóa đơn thất bại.');
                    throw new Exception("Error", 1);
                }

                $new_sum_amount += $old_detail->amount;
                #endregion

                #region --- TRANSACTION INVOICE
                $transaction_invoice = new TransactionInvoice();

                $transaction_invoice->attributes = $old_detail->attributes;
                $transaction_invoice->id_customer = $new_invoice->id_customer;
                $transaction_invoice->unit_price = $old_detail->amount;

                $transaction_invoice->id_author = Yii::app()->user->getState('user_id');
                $transaction_invoice->create_date = date('Y-m-d H:i:s');
                $transaction_invoice->pay_date = null;

                #region --- SERVICE TYPE TK
                $connection = Yii::app()->getDb();
                $command = $connection->createCommand("
                    SELECT serviceTk.id_service_type_tk, serviceTk.id_cs_service,  percent.percent, percent.id_gp_users
                    FROM cs_service_tk AS serviceTk
                    INNER JOIN cs_percent_tk AS percent ON serviceTk.id_service_type_tk = percent.id_service_type_tk
                    WHERE id_cs_service = '$transaction_invoice->id_service'
                    AND percent.id_gp_users = '$transaction_invoice->id_user'
                    AND serviceTk.st = 1
                ");
                $service_type = $command->queryRow();

                if (!empty($service_type)) {
                    $transaction_invoice->id_service_type_tk = $service_type['id_service_type_tk'];
                    $transaction_invoice->percent = (int)$service_type['percent'];
                }
                #endregion

                #region --- PRIORITY PAY
                $priority = Invoice::model()->checkServiceOfPriceBook($transaction_invoice->id_service, $id_price_book, $transaction_invoice->qty);

                if ($priority['priority_pay'] > 0) {
                    $transaction_invoice->priority_pay = $priority['priority_pay'];

                } else if ($priority['priority_pay'] == 0) {
                    $sv = CsService::model()->find(array(
                        'select' => 'priority_pay',
                        'condition' => 'id = ' . $transaction_invoice->id_service
                    ));
                    if ($sv) {
                        $transaction_invoice->priority_pay = $sv->priority_pay;
                    }
                }
                #endregion

                if (!($transaction_invoice->validate() && $transaction_invoice->save())) {
                    $result = array('status' => 0, 'error-message' => 'Cập nhật chi tiết giao dịch thất bại.');
                    throw new Exception("Error", 1);
                }

                #endregion

                #region --- TAO TRANSACTION PKC
                if ($priority['price'] > -1) {
                    $price = $priority['price'];

                    if ($old_detail->flag_price == self::FLAG_USD) {
                        $price = $price * $exchange_rate;
                    }

                    $transaction_PKC = new TransactionInvoice();
                    $transaction_PKC->attributes = $transaction_invoice->attributes;

                    $transaction_PKC->create_date = date('Y-m-d H:i:s');
                    $transaction_PKC->pay_date = date('Y-m-d');
                    $transaction_PKC->amount = $price;

                    $transaction_PKC->status = 0;
                    $transaction_PKC->debt = TransactionInvoice::PhongKhamChuyen;
                    $transaction_PKC->percent = $transaction_invoice->percent;

                    if (!($transaction_PKC->validate() && $transaction_PKC->save())) {
                        $result = array('status' => 0, 'error-message' => 'Cập nhật giao dịch PKC thất bại.');
                        throw new Exception("Error", 1);
                    }
                } else {
                    if ( $value['percent_decrease'] > 10 ) {
                        $pkcPercent = $value['percent_decrease'] - 10;
                        $price = $old_detail->unit_price * $old_detail->qty * $pkcPercent / 100;
                        $transaction_PKC = new TransactionInvoice();
                        $transaction_PKC->attributes = $transaction_invoice->attributes;

                        $transaction_PKC->create_date = date('Y-m-d H:i:s');
                        $transaction_PKC->pay_date = date('Y-m-d');
                        $transaction_PKC->amount = $price;

                        $transaction_PKC->status = 0;
                        $transaction_PKC->debt = TransactionInvoice::PhongKhamChuyen;
                        $transaction_PKC->percent = $pkcPercent;

                        if (!($transaction_PKC->validate() && $transaction_PKC->save())) {
                            $result = array('status' => 0, 'error-message' => 'Cập nhật giao dịch PKC thất bại.');
                            throw new Exception("Error", 1);
                        }
                    }
                }
                #endregion
            }

            #region --- HOA DON XAC NHAN
            $new_invoice->sum_amount = $new_sum_amount;
            $new_invoice->amount_reduced = $data['amount_reduced'];

            $new_invoice->sum_amount_usd = 0;
            $new_invoice->sum_insurance = 0;
            $new_invoice->balance = $new_sum_amount;

            $new_invoice->total = $new_sum_amount + $data['amount_reduced'];

            $new_invoice->save(false);
            #endregion

            #region --- HOA DON CHUA XAC NHAN
            if (!$isAllConfirm) {
                $sumInvoiceDetail = InvoiceDetail::model()->countByAttributes(array('id_invoice' => $old_invoice->id), "status != -1 AND percent_change != 100");

                if ($sumInvoiceDetail <= 0) {
                    $old_invoice->status = 10;
                } else {
                    $old_invoice->sum_amount = $old_invoice->sum_amount - $old_sum_amount;
                    $old_invoice->sum_amount_usd = $old_invoice->sum_amount_usd - $old_sum_amount_usd;

                    $old_invoice->balance = $old_invoice->sum_amount + $old_invoice->sum_amount_usd;
                    $new_invoice->total = $old_invoice->sum_amount + $old_invoice->sum_amount_usd;
                }

                $old_invoice->sum_insurance = 0;
                $old_invoice->amount_reduced = 0;

                if (!($old_invoice->validate() && $old_invoice->save())) {
                    $result = array('status' => 0, 'error-message' => 'Cập nhật hóa đơn chưa xác nhận thất bại.');
                    throw new Exception("Error", 1);
                }
            }
            #endregion

            $result = array('status' => 1, 'id_invoice' => $new_id_invoice);
            $trans->commit();
        } catch(Exception $e) {
            if (empty($result)) {
                $message = $e->getMessage();
            } else {
                $message = $result['error-message'];
            }
            Yii::log($message, CLogger::LEVEL_ERROR, 'INVOICE_CONFIRM');
            $trans->rollback();
        }

        return $result;
    }
    #endregion

    #region --- LAY GIA VA DO UU TIEN CUA BANG GIA
    public function checkServiceOfPriceBook($id_service, $id_price_book, $qty) {
        if (!$id_price_book || !$id_service) {
            return array('price' => -1, 'priority_pay' => 0);
        }

        $data = PricebookService::model()->find(array(
            'select' => 'priority_pay, doctor_salary',
            'condition' => "id_pricebook = $id_price_book AND id_service = $id_service"
        ));

        $price = -1;
        $priority_pay = 0;

        if ($data) {
            $priority_pay = $data['priority_pay'];
            $balance = $data['doctor_salary'];

            if ($balance > 0) {
                $price = $balance * $qty;
            }
        }
        return array('price' => $price, 'priority_pay' => $priority_pay);
    }
    #endregion

    #region --- LAY THONG TIN GIAO DICH
    private function getTransactionAll($id_customer, $id_invoice, $id_service, $id_user) {
        $condition = "id_customer = $id_customer AND id_invoice = $id_invoice AND id_service = $id_service";
        if ($id_user) {
            $condition .= " AND id_user = $id_user";
        }
        $transactionAll = TransactionInvoice::model()->findAll(array(
            'select' => '*',
            'condition' => $condition
        ));

        if (!$transactionAll) {
            return array();
        }

        $transTT = array(); $transNo = array(); $transPKC = array();
        $transHT = array(); $transDL = array(); $trans = array();

        $sumTT = 0; $sumNo = 0; $sumPKC = 0;

        foreach ($transactionAll as $key => $value) {
            $debt = $value->debt;

            if ($debt == TransactionInvoice::ThanhToan || $debt == TransactionInvoice::NHAN) {
                $transTT[] = $value;
                $sumTT += $value->amount;
            } else if ($debt == TransactionInvoice::ConNo) {
                $transNo[] = $value;
                $sumNo += $value->amount;
            }  else if ($debt == TransactionInvoice::PhongKhamChuyen) {
                $transPKC[] = $value;
                $sumPKC += $value->amount;
            } else if ($debt == TransactionInvoice::HoanTra) {
                $transHT[] = $value;
            } else if ($debt == TransactionInvoice::Delay) {
                $transDL[] = $value;
            } else {
                $trans[] = $value;
            }
        }

        return array('transTT' => $transTT, 'transNo' => $transNo, 'transPKC' => $transPKC, 'transHT' => $transHT, 'transDL' => $transDL, 'trans' => $trans, 'sumTT' => $sumTT, 'sumNo' => $sumNo, 'sumPKC' => $sumPKC);
    }
    #endregion

    #region --- HUY DICH VU
    public function transactionCancel($data) {
        $id = isset($data['id']) ? $data['id'] : false;
        $refund = isset($data['refund']) ? $data['refund'] : 0;
        $percent = isset($data['percent']) ? $data['percent'] : 0;

        $id_customer = isset($data['id_customer']) ? $data['id_customer'] : false;
        $id_mhg = isset($data['id_mhg']) ? $data['id_mhg'] : false;

        $transTT = array(); $transNo = array(); $transPKC = array();

        $sumTT = 0; $sumNo = 0; $sumPKC = 0;

        #region --- KIEM TRA DU LIEU DAU VAO
        if (!$id || !$id_customer || !$id_mhg) {
            return array('status' => 0, 'error-message' => 'Không có thông tin dịch vụ!');
        }

        if ($refund < 0 || $percent < 0) {
            return array('status' => 0, 'error-message' => 'Giá trị hoàn trả nhỏ hơn 0');
        }

        $invoice_detail = VInvoiceDetail::model()->findByAttributes(array('id' => $id));

        if (!$invoice_detail) {
            return array('status' => 0, 'error-message' => 'Không tồn tại thông tin dịch vụ!');
        }

        if ($invoice_detail->status == -1) {
            return array('status' => 0, 'error-message' => 'Dịch vụ đã hủy!');
        }

        $id_service = $invoice_detail->id_service;
        $id_invoice = $invoice_detail->id_invoice;
        $id_user = $invoice_detail->id_user;

        $invoice = Invoice::model()->findByPk($id_invoice);

        if (!$invoice || $invoice->id_group_history != $id_mhg) {
            return array('status' => 0, 'error-message' => 'Thông tin dịch vụ không hợp lệ!');
        }
        #endregion

        #region --- CAP NHAT DICH VU HUY - 1
        $invoicedetail = InvoiceDetail::model()->findByPk($invoice_detail['id']);

        $amount = $invoice_detail->amount;

        if ($invoicedetail->status == -1) {
            return array('status' => 0, 'error-message' => 'Không có dịch vụ được hủy!');
        }

        $invoicedetail->status = -1;
        $invoicedetail->confirm_date = date('Y-m-d H:i:s');
        $invoicedetail->percent_change = $percent;
        $invoicedetail->amount = $amount - ($amount * $percent/100);

        if (!($invoicedetail->validate() && $invoicedetail->save())) {
            return array('status' => 0, 'error-message' => 'Không có dịch vụ được hủy!');
        }
        #endregion

        $refund = $amount * $percent/100;
        $reason = isset($data['reason']) ? $data['reason'] : false;

        #region --- CAP NHAT THONG TIN HOA DON
        $balance = $invoice->balance - $refund;
        $invoice->balance = ($balance >= 0) ? $balance : 0;

        if ($percent == 100) {
            if ($invoice_detail->flag_price == 2) {
                $invoice->sum_amount_usd = $invoice->sum_amount_usd - $invoice_detail->amount;
            } else {
                $invoice->sum_amount = $invoice->sum_amount - $invoice_detail->amount;
            }
        } else {
            if ($invoice_detail->flag_price == 2) {
                $invoice->sum_amount_usd = $invoice->sum_amount_usd - $refund;
            } else {
                $invoice->sum_amount = $invoice->sum_amount - $refund;
            }
        }

        $invoice->total = $invoice->sum_amount + $invoice->sum_amount_usd;

        if ($invoice->confirm == 0) {
            $sumInvoiceDetail = InvoiceDetail::model()->countByAttributes(array('id_invoice' => $id_invoice), "status != -1 AND percent_change != 100");

            if ($sumInvoiceDetail <= 0) {
                $invoice->status = -1;
            }
        }

        if (!($invoice->validate() && $invoice->save())) {
            return array('status' => 0, 'error-message' => $invoice->getErrors());
        }
        #endregion

        #region --- LAY DANH SACH GIAO DICH
        $transactionAll = $this->getTransactionAll($id_customer, $id_invoice, $id_service, $id_user);
        if (!empty($transactionAll)) {
            $transTT = $transactionAll['transTT'];
            $transNo = $transactionAll['transNo'];
            $transPKC = $transactionAll['transPKC'];
            $transHT = $transactionAll['transHT'];
            $transDL = $transactionAll['transDL'];
            $trans = $transactionAll['trans'];

            $sumTT = $transactionAll['sumTT'];
            $sumNo = $transactionAll['sumNo'];
            $sumPKC = $transactionAll['sumPKC'];
        }
        #endregion

        #region --- DICH VU CHUA THANH TOAN
        if ($sumPKC > 0) {
            $refundPKC = $sumPKC * $percent / 100;
            $transactionPKC = $this->transNegativePKC($transPKC, $refundPKC);
            if ($transactionPKC['status'] == 0) {
                return $transactionPKC;
            }
        }
        if ($sumTT == 0 && empty($transTT)) {
            #region --- TRA = 100
            // if ($percent == 100 && $refund == $amount) {
                // $transactionPKC = $this->transNegativePKC($transPKC, $sumPKC);

                // if ($transactionPKC['status'] == 0) {
                //     return $transactionPKC;
                // }
            // }
            #endregion

            $transactionDelay = $this->createTransaction($transNo, $refund, TransactionInvoice::Delay);

            if ($transactionDelay['status'] == 0) {
                return $transactionDelay;
            }

            $transactionNo = $this->updateTransacton($transNo, $sumNo - $refund, TransactionInvoice::ConNo);

            if ($transactionNo['status'] == 0) {
                return $transactionNo;
            }

            return array('status' => 1, 'data' => $invoicedetail->attributes, 'reason' => $reason, 'confirm' => $invoice->confirm);
        }
        #endregion

        #region --- DICH VU THANH TOAN DU
        if ($sumTT == $amount && !empty($transTT)) {
            $transactionHT = $this->createTransaction($transTT, $refund, TransactionInvoice::HoanTra);

            if ($transactionHT['status'] == 0) {
                return $transactionHT;
            }

            // if ($percent == 100 && $refund == $sumTT) {
                // $transactionPKC = $this->transNegativePKC($transPKC, $sumPKC);

                // if ($transactionPKC['status'] == 0) {
                //     return $transactionPKC;
                // }
            // }

            $description = "HUỶ DỊCH VỤ HÓA ĐƠN SỐ " . $invoice->code . ". " . $invoice_detail->code_service . " - " . $invoice_detail->services_name . " - " .$invoice_detail->user_name . " - ". $invoice_detail->amount . ' - ' . $refund;

            $receiverAccount = $this->createReceiverAccount($invoice->id_customer, $invoice->code, $description, $refund);

            return array('status' => 1, 'data' => $invoicedetail->attributes, 'reason' => $reason, 'confirm' => $invoice->confirm);
        }
        #endregion

        #region --- DICH VU THANH TOAN CHUA DU
        else if ($sumTT > 0 && !empty($transTT)) {
            #region --- TRA = 100
            // if ($percent == 100 && $refund = $amount) {
                // $transactionPKC = $this->transNegativePKC($transPKC, $sumPKC);

                // if ($transactionPKC['status'] == 0) {
                //     return $transactionPKC;
                // }
            // }
            #endregion

            #region --- TRA < NO
            if ($refund < $sumNo) {
                $transactionDL = $this->createTransaction($transTT, $refund, TransactionInvoice::Delay);

                if ($transactionDL['status'] == 0) {
                    return $transactionDL;
                }

                $no = $sumNo - $refund;

                $transactionNo = $this->updateTransacton($transNo, $no, TransactionInvoice::ConNo);

                if ($transactionNo['status'] == 0) {
                    return $transactionNo;
                }

                return array('status' => 1, 'data' => $invoicedetail->attributes, 'reason' => $reason, 'confirm' => $invoice->confirm);
            }
            #endregion

            #region --- TRA = NO
            else if ($refund == $sumNo) {
                $transactionDL = $this->updateTransacton($transNo, $refund, TransactionInvoice::Delay);

                if ($transactionDL['status'] == 0) {
                    return $transactionDL;
                }

                return array('status' => 1, 'data' => $invoicedetail->attributes, 'reason' => $reason, 'confirm' => $invoice->confirm);
            }
            #endregion

            #region --- TRA > NO
            else if ($refund > $sumNo) {
                $dl = $amount - $sumTT;
                $transactionDL = $this->updateTransacton($transNo, $sumNo, TransactionInvoice::Delay);

                if ($transactionDL['status'] == 0) {
                    return $transactionDL;
                }

                $tr = $refund - $sumNo;

                if ($tr > 0) {
                    $transactionHT = $this->createTransaction($transTT, $tr, TransactionInvoice::HoanTra);

                    if ($transactionHT['status'] == 0) {
                        return $transactionHT;
                    }

                    $description = "HUỶ DỊCH VỤ HÓA ĐƠN SỐ " . $invoice->code . ". " . $invoice_detail->code_service . " - " . $invoice_detail->services_name . " - " .$invoice_detail->user_name . " - ". $invoice_detail->amount . ' - ' . $tr;

                    $receiverAccount = $this->createReceiverAccount($invoice->id_customer, $invoice->code, $description, $tr);
                }

                return array('status' => 1, 'data' => $invoicedetail->attributes, 'reason' => $reason, 'confirm' => $invoice->confirm);
            }
            #endregion
        }
        #endregion

        return array('status' => 0, 'error-message' => 'Error',);
    }
    #endregion

    #region --- CHUYEN DICH VU
    public function transactionChange($data) {
        $id = isset($data['id']) ? $data['id'] : false;
        $refund = isset($data['refund']) ? $data['refund'] : 0;
        $percent = isset($data['percent']) ? $data['percent'] : 0;
        $id_dentis = isset($data['id_dentist_receive']) ? $data['id_dentist_receive'] : false;

        $id_customer = isset($data['id_customer']) ? $data['id_customer'] : false;
        $id_mhg = isset($data['id_mhg']) ? $data['id_mhg'] : false;

        #region --- KIEM TRA DU LIEU DAU VAO
        if (!$id || !$id_customer || !$id_mhg || !$id_dentis) {
            return array('status' => 0, 'error-message' => 'Không có thông tin dịch vụ!');
        }

        if ($refund < 0 || $percent < 0) {
            return array('status' => 0, 'error-message' => 'Giá trị chuyển nhỏ hơn 0');
        }

        $invoice_detail = VInvoiceDetail::model()->findByAttributes(array('id' => $id));

        if (!$invoice_detail) {
            return array('status' => 0, 'error-message' => 'Không tồn tại thông tin dịch vụ!');
        }

        if ($invoice_detail->status == -1) {
            return array('status' => 0, 'error-message' => 'Dịch vụ đã hủy!');
        }

        // if ($invoice_detail->status == -2) {
        //     return array('status' => 0, 'error-message' => 'Dịch vụ đã chuyển!');
        // }

        $id_service = $invoice_detail->id_service;
        $id_invoice = $invoice_detail->id_invoice;
        $id_user = $invoice_detail->id_user;

        $invoice = Invoice::model()->findByPk($id_invoice);

        if (!$invoice || $invoice->id_group_history != $id_mhg) {
            return array('status' => 0, 'error-message' => 'Thông tin dịch vụ không hợp lệ!');
        }
        #endregion

        $amount = $invoice_detail->amount;

        if ($percent == 100 && $refund > $amount) {
            $refund = $amount;
        }

        #region --- CAP NHAT DICH VU Chuyen - 2
        $invoiceUpdate = array('status' => -2, 'confirm_date' => date('Y-m-d H:i:s'), 'percent_change' => $percent);

        $invoicedetail = InvoiceDetail::model()->updateByPk($invoice_detail['id'], $invoiceUpdate);

        if ($invoicedetail == 0) {
            return array('status' => 0, 'error-message' => 'Không có dịch vụ được chuyển!');
        }

        $invoiceDetailChange = new InvoiceDetail();
        $invoiceDetailChange->attributes = $invoice_detail->attributes;
        $invoiceDetailChange->percent_change = 100 - $percent;
        $invoiceDetailChange->id_user = $id_dentis;
        $invoiceDetailChange->status = -3;

        unset($invoiceDetailChange->create_date);

        $invoiceDetailChange->save(false);

        if ($invoice->confirm == 0) {
            return array('status' => 1, 'invoicedetail' => $invoice_detail->attributes, 'reason' => $data['reason']);
        }
        #endregion

        #region --- LAY DANH SACH GIAO DICH
        $transactionAll = $this->getTransactionAll($id_customer, $id_invoice, $id_service, $id_user);
        if (!empty($transactionAll)) {
            $transTT = $transactionAll['transTT'];
            $transNo = $transactionAll['transNo'];
            $transPKC = $transactionAll['transPKC'];
            $transHT = $transactionAll['transHT'];
            $transDL = $transactionAll['transDL'];
            $trans = $transactionAll['trans'];

            $sumTT = $transactionAll['sumTT'];
            $sumNo = $transactionAll['sumNo'];
            $sumPKC = $transactionAll['sumPKC'];
        } else {

        }
        #endregion

        #region --- CHUYEN < GIA DV
        if ($refund < $amount) {
            $trans = (empty($transTT)) ? ((!empty($transNo)) ? $transNo : array()) : $transTT;
            $transactionChuyen = $this->createTransaction($trans, $refund, TransactionInvoice::CHUYEN);

            if ($transactionChuyen['status'] == 0) {
                return $transactionChuyen;
            }

            $transactionNhan = $this->createTransaction($trans, $refund, TransactionInvoice::NHAN, $id_dentis);

            if ($transactionNhan['status'] == 0) {
                return $transactionNhan;
            }

            return array('status' => 1, 'invoicedetail' => $invoice_detail->attributes, 'reason' => $data['reason']);
        }
        #endregion

        #region --- CHUYEN = GIA DV
        else if ($refund == $amount) {
            $nhan = $amount - $sumNo;

            $trans = (empty($transTT)) ? ((!empty($transNo)) ? $transNo : array()) : $transTT;

            if ($nhan > 0) {
                $transactionChuyen = $this->createTransaction($trans, $nhan, TransactionInvoice::CHUYEN);
                if ($transactionChuyen['status'] == 0) {
                    return $transactionChuyen;
                }

                $transactionNhan = $this->createTransaction($trans, $nhan, TransactionInvoice::NHAN, $id_dentis);
                if ($transactionNhan['status'] == 0) {
                    return $transactionNhan;
                }
            }

            $transactionNo = $this->updateTransacton($transNo, $sumNo, TransactionInvoice::ConNo, $id_dentis);
            if ($transactionNo['status'] == 0) {
                return $transactionNo;
            }

            $transactionPKCAm = $this->createTransaction($transPKC, -1*$sumPKC, TransactionInvoice::PhongKhamChuyen);
            if ($transactionPKCAm['status'] == 0) {
                return $transactionPKCAm;
            }

            $transactionPKCDuong = $this->createTransaction($transPKC, $sumPKC, TransactionInvoice::PhongKhamChuyen, $id_dentis);
            if ($transactionPKCDuong['status'] == 0) {
                return $transactionPKCDuong;
            }

            return array('status' => 1, 'invoicedetail' => $invoice_detail->attributes, 'reason' => $data['reason']);
        }
        #endregion

        return array('status' => 0, 'error-message' => 'Error');
    }
    #endregion

    #region --- HUY DICH VU - TAO TRANSACTION AM CHO PKC
    private function transNegativePKC($transPKC, $sumPKC) {
        $transaction = isset($transPKC[0]) ? $transPKC[0] : false;

        if ($transaction) {
            $trans = new TransactionInvoice();
            $trans->attributes = $transaction->attributes;
            $trans->debt = TransactionInvoice::PhongKhamChuyen;
            $trans->amount = -1*$sumPKC;
            $trans->pay_date = date('Y-m-d H:i:s');

            unset($trans->create_date);

            if ($trans->validate() && $trans->save()) {
                return array('status' => 1);
            }
            return array('status' => 0, 'error-message' => $trans->getErrors());
        }
        return array('status' => 1);
    }
    #endregion

    #region --- HUY DICH VU - TAO TRANSACTION
    private function createTransaction($transData, $sum, $debt, $id_dentis = "") {
        $transaction = isset($transData[0]) ? $transData[0] : false;

        if ($transaction) {
            $trans = new TransactionInvoice();
            $trans->attributes = $transaction->attributes;
            $trans->debt = $debt;
            $trans->amount = $sum;

            if ($debt == TransactionInvoice::ThanhToan || $debt == TransactionInvoice::PhongKhamChuyen || $debt == TransactionInvoice::HoanTra) {
                $trans->pay_date = date('Y-m-d H:i:s');
            }

            if ($id_dentis) {
                $trans->id_user = $id_dentis;
            }

            unset($trans->create_date);

            if ($trans->validate() && $trans->save()) {
                return array('status' => 1);
            }
            return array('status' => 0, 'error-message' => $trans->getErrors());
        }
        return array('status' => 1);
    }
    #endregion

    #region --- HUY DICH VU - CAP NHAT TRANSACTION
    private function updateTransacton($transData, $sum, $debt, $id_dentist = '') {
        $transaction = isset($transData[0]) ? $transData[0] : false;

        if ($transaction) {
            $transaction->amount = $sum;
            $transaction->debt = $debt;

            if ($id_dentist) {
                $transaction->id_user = $id_dentist;
            }

            if ($transaction->validate() && $transaction->save()) {
                return array('status' => 1);
            }
            return array('status' => 0, 'error-message' => $transaction->getErrors());
        }
        return array('status' => 1);
    }
    #endregion

    #region --- TAO PHIEU CHI
    public function createReceiverAccount($id_customer, $invoiceCode, $description, $sum) {
        return VReceivable::model()->AddnewReceivableAccount(array(
            'id_customer' => $id_customer,
            'description' => $description,
            'amount' => $sum,
            'order_number' => $invoiceCode,
            'id_user' => Yii::app()->user->getState('user_id'),
            'received_date' => date('Y-m-d'),
            'type' => 3,
        ));
    }
    #endregion

    #region --- TONG CHI PHI HOA DON THEO KHACH HANG
    public function getSumInvoice($id_customer = false) {
        if (!$id_customer) { return 0; }

        $con = Yii::app()->db;

        $sql = "SELECT sum(sum_amount) AS sumInvoice FROM `invoice` WHERE `id_customer` = $id_customer AND `confirm` = 1 AND id > " . $this->_maxInvoice;
        $data = $con->createCommand($sql)->queryRow();
        return $data['sumInvoice'];
    }
    #endregion

    #region --- TONG THANH TOAN THEO KHACH HANG
    public function getSumPayInvoice($id_customer = false) {
        if (!$id_customer) { return 0; }

        $con = Yii::app()->db;

        $sql = "SELECT sum(pay_amount) AS sumInvoice FROM `v_receipt` WHERE `id_customer` = $id_customer AND id_invoice > " . $this->_maxInvoice;
        $data = $con->createCommand($sql)->queryRow();
        return $data['sumInvoice'];
    }
    #endregion

    #region --- TONG HOAN TRA THEO KHACH HANG
    public function getSumRefundInvoice($id_customer = false) {
        if (!$id_customer) { return 0; }

        $con = Yii::app()->db;

        $sql = "SELECT sum(amount) AS sumInvoice FROM transaction_invoice WHERE id_customer = $id_customer AND id_invoice > ". $this->_maxInvoice ." AND debt = " . TransactionInvoice::HoanTra;
        $data = $con->createCommand($sql)->queryRow();
        return $data['sumInvoice'];
    }
    #endregion

    #region --- TONG KHUYEN MAI THEO KHACH HANG
    public function getSumPromotionInvoice($id_customer = false) {
        if (!$id_customer) { return 0; }

        $con = Yii::app()->db;

        $sql = "SELECT sum(pay_promotion) AS sumInvoice FROM `v_receipt` WHERE `id_customer` = $id_customer AND id_invoice > " . $this->_maxInvoice;
        $data = $con->createCommand($sql)->queryRow();
        return $data['sumInvoice'];
    }
    #endregion

    #region --- TONG CONG NO THEO KHACH HANG
    public function getSumDebtInvoice($id_customer = false) {
        if (!$id_customer) { return 0; }

        $con = Yii::app()->db;

        $sql = "SELECT sum(amount) AS sumInvoice FROM transaction_invoice WHERE id_customer = $id_customer AND id_invoice > " . $this->_maxInvoice . " AND debt = " . TransactionInvoice::ConNo;
        $data = $con->createCommand($sql)->queryRow();
        return $data['sumInvoice'];
    }
    #endregion

    #region --- DANH SACH HOA DON THEO KHACH HANG
    public function StatisticalInvoice($id_customer) {
        $con = Yii::app()->db;
        $sql="SELECT date(`invoice_detail`.`create_date`) as `create_date`,`invoice_detail`.`amount`,`cs_service`.`code`,`cs_service`.`name`,`invoice_detail`.`teeth`,`invoice_detail`.`id_user` as `nameDoctor` ,`invoice`.`id_customer`,`invoice_detail`.`status`,`invoice`.`id` as `id`,`invoice_detail`.`percent_change` FROM `invoice`
        INNER JOIN `invoice_detail` ON `invoice_detail`.`id_invoice` = `invoice`.`id`
        INNER JOIN `cs_service` ON `invoice_detail`.`id_service` = `cs_service`.`id`
        WHERE `id_customer` = ".$id_customer."
        AND date(`invoice`.`create_date`) > '2019-02-20'
        AND `confirm` = 1 ORDER BY `invoice_detail`.`status` DESC";
        $data = $con->createCommand($sql)->queryAll();
        return $data;
    }

    public function StatisticalInvoice1($id_customer) {
        $con = Yii::app()->db;
        $sql="SELECT create_date, amount, code_service AS code, services_name AS name, teeth, id_user AS id_user, user_name AS nameDoctor, id_customer, status, id, percent_change FROM v_invoice_detail WHERE id_customer = $id_customer AND confirm = 1 AND id_invoice > " . $this->_maxInvoice;
        $data = $con->createCommand($sql)->queryAll();
        return $data;
    }
    #endregion

    #region --- DANH SACH THANH TOAN
    public function getListReceiptInvoice($id_customer) {
        $con = Yii::app()->db;
        $sql="SELECT pay_date, pay_type, pay_amount, pay_promotion, code, id_invoice FROM v_receipt WHERE id_customer = $id_customer AND pay_type != 5 AND id_invoice >= " . $this->_maxInvoice;
        $data = $con->createCommand($sql)->queryAll();
        return $data;

        $criteria = new CDbCriteria;
		$criteria->select = "pay_date, pay_type, pay_amount, pay_promotion, code, id_invoice";
		$criteria->addCondition("id_customer = $id_customer");
		$criteria->addCondition("date(pay_date) > '2019-02-20'");
		$criteria->addCondition("pay_type != 5");
        $dataReceipt = VReceipt::model()->findAll($criteria);

        return $dataReceipt;
    }
    #endregion


}