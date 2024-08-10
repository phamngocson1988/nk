<?php

/**
 * This is the model class for table "transaction_invoice".
 *
 * The followings are the available columns in table 'transaction_invoice':
 * @property integer $id
 * @property integer $id_invoice
 * @property integer $id_service
 * @property integer $id_customer
 * @property integer $id_service_type_tk
 * @property integer $id_receipt
 * @property integer $percent
 * @property string $description
 * @property integer $id_user
 * @property integer $id_author
 * @property string $create_date
 * @property string $confirm_date
 * @property string $pay_date
 * @property double $unit_price
 * @property double $amount
 * @property string $teeth
 * @property integer $qty
 * @property double $tax
 * @property integer $debt
 * @property integer $status
 * @property integer $priority_pay
 */
class TransactionInvoice extends CActiveRecord
{
	const ThanhToan = 0;
	const ConNo = 1;
	const PhongKhamChuyen = 2;
	const HoanTra = 3;
	const Delay = 4;
	const NHAN = 5;
	const CHUYEN = 6;
	const KhuyenMai = 7;

	public $sum;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transaction_invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_invoice, id_service, id_customer', 'required'),
			array('id_invoice, id_service, id_customer, id_service_type_tk, percent, id_user, id_author, qty, debt, status, priority_pay', 'numerical', 'integerOnly'=>true),
			array('unit_price, amount, tax', 'numerical'),
			array('description, teeth', 'length', 'max'=>255),
			array('confirm_date, pay_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_invoice, id_service, id_customer, id_service_type_tk, percent, description, id_user, id_author, create_date, confirm_date, pay_date, unit_price, amount, teeth, qty, tax, debt, status', 'safe', 'on'=>'search'),
			array('id_receipt', 'safe')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_invoice' => 'Id Invoice',
			'id_service' => 'Id Service',
			'id_customer' => 'Id Customer',
			'id_service_type_tk' => 'Id Service Type Tk',
			'percent' => 'Percent',
			'description' => 'Description',
			'id_user' => 'Id User',
			'id_author' => 'Id Author',
			'create_date' => 'Create Date',
			'confirm_date' => 'Confirm Date',
			'pay_date' => 'Pay Date',
			'unit_price' => 'Unit Price',
			'amount' => 'Amount',
			'teeth' => 'Teeth',
			'qty' => 'Qty',
			'tax' => 'Tax',
			'debt' => 'Debt',
			'status' => 'Status',
		);
	}

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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_invoice',$this->id_invoice);
		$criteria->compare('id_service',$this->id_service);
		$criteria->compare('id_customer',$this->id_customer);
		$criteria->compare('id_service_type_tk',$this->id_service_type_tk);
		$criteria->compare('percent',$this->percent);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_author',$this->id_author);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('confirm_date',$this->confirm_date,true);
		$criteria->compare('pay_date',$this->pay_date,true);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('teeth',$this->teeth,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('tax',$this->tax);
		$criteria->compare('debt',$this->debt);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransactionInvoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getListTransactionInvoice($id_user)
    {
        return $data = Yii::app()->db->createCommand()
                ->select('transaction_invoice.*')
                ->from('transaction_invoice')
                ->where('id_user=:id_user', array(':id_user' => $id_user))
                ->order('transaction_invoice.id_service_type_tk ASC')
                ->queryAll();

    }

    public function getFilterListTransactionInvoice($id_user,$from_date,$to_date,$debt)
    {

	    $con = Yii::app()->db;

		$sql = " select transaction_invoice.*, cs_service.id_service_type, invoice.code
				from transaction_invoice
				left join cs_service
				on transaction_invoice.id_service = cs_service.id
				left join invoice
				on transaction_invoice.id_invoice = invoice.id
				where 1 = 1 ";

		if ($id_user) {

			$sql .=	" and transaction_invoice.id_user = '" . $id_user . "' ";

		}

		if ($from_date) {

			$from_date = date('Y-m-d',strtotime(str_replace('/', '-',$from_date)));

			$sql .=	" and DATE(transaction_invoice.create_date) >= '" . $from_date . "' ";

		}

		if ($to_date) {

			$to_date = date('Y-m-d',strtotime(str_replace('/', '-',$to_date)));

			$sql .=	" and DATE(transaction_invoice.create_date) <= '" . $to_date . "' ";

		}

		$debt = (array)$debt;
		$debt = array_filter($debt);
 		if (count($debt)) {
 			$debtString = "'" . implode("','", $debt) . "'";
			$sql .=	" and transaction_invoice.debt IN (". $debtString . ")";

		}

		$sql .=	" order by cs_service.id_service_type, invoice.code desc ";

		$data = $con->createCommand($sql)->queryAll();

		return $data;

    }

    public function getListTransactionInvoiceOfCustomer($id_customer, $id_invoice)
    {

    	if ($id_invoice) {

    		$data = Yii::app()->db->createCommand()
	                ->select('transaction_invoice.*, cs_service.id_service_type, cs_service.code')
	                ->from('transaction_invoice')
	                ->where('id_customer=:id_customer', array(':id_customer' => $id_customer))
	                ->andWhere('id_invoice=:id_invoice', array(':id_invoice' => $id_invoice))
	                ->leftJoin('cs_service', 'transaction_invoice.id_service = cs_service.id')
	                ->order('transaction_invoice.id desc')
	                ->queryAll();

    	} else {

	        $data = Yii::app()->db->createCommand()
	                ->select('transaction_invoice.*, cs_service.id_service_type, cs_service.code')
	                ->from('transaction_invoice')
	                ->where('id_customer=:id_customer', array(':id_customer' => $id_customer))
	                ->leftJoin('cs_service', 'transaction_invoice.id_service = cs_service.id')
	                ->order('transaction_invoice.id desc')
	                ->queryAll();

        }

        return $data;

    }

    public function deleteTransactionInvoice($id) {
        if(!$id) {
			return  array('status' => 'Fail', 'error-message'=>'id not invalid');
		}

		if (TransactionInvoice::model()->deleteByPk($id)) {
			return array('status' => 'successful');
		}

		return  array('status' => 'Fail', 'error-message'=>'delete failed');
    }

    public function updateTransactionInvoice($dataTransactionInvoice = array('id'=>'', 'id_service'=>'','id_customer'=>'', 'percent' =>'', 'amount'=>'', 'create_date'=>'', 'pay_date'=>'','debt'=>''))
    {

    	if(!$dataTransactionInvoice['id']) {

			return  array('status' => 'Fail', 'error-message'=>'id not invalid');

 		}

 		if(!$dataTransactionInvoice['id_service']) {

			return  array('status' => 'Fail', 'error-message'=>'id_service not invalid');

 		}

 		if(!$dataTransactionInvoice['id_customer']) {

			return  array('status' => 'Fail', 'error-message'=>'id_customer not invalid');

 		}

 		if($dataTransactionInvoice['percent'] == "") {

			return  array('status' => 'Fail', 'error-message'=>'percent not invalid');

 		}

		if($dataTransactionInvoice['amount'] == "") {

			return  array('status' => 'Fail', 'error-message'=>'amount not invalid');

 		}

 		if(!$dataTransactionInvoice['create_date']) {

			return  array('status' => 'Fail', 'error-message'=>'create_date not invalid');

 		}

 		if($dataTransactionInvoice['debt'] == "") {

			return  array('status' => 'Fail', 'error-message'=>'debt not invalid');

 		}

 		$pay_date = $dataTransactionInvoice['pay_date'] ? date('Y-m-d H:i:s',strtotime(str_replace('/', '-',$dataTransactionInvoice['pay_date']))) : null;

		if (TransactionInvoice::model()->updateByPk($dataTransactionInvoice['id'], array('id_service' => $dataTransactionInvoice['id_service'], 'id_customer' => $dataTransactionInvoice['id_customer'], 'percent' => $dataTransactionInvoice['percent'], 'description' => CsService::model()->findByPk($dataTransactionInvoice['id_service'])->name, 'amount' => $dataTransactionInvoice['amount'], 'create_date' => $dataTransactionInvoice['create_date'], 'pay_date' => $pay_date, 'debt' => $dataTransactionInvoice['debt']))) {

			return  array('status' => 'successful');

		}

		return  array('status' => 'Fail', 'error-message'=>'update failed');

    }

    public function updateTransactionInvoiceOfCustomer($dataTransactionInvoice = array('id'=>'', 'id_service'=>'','id_user'=>'', 'percent' =>'', 'amount'=>'', 'create_date'=>'', 'pay_date'=>'','debt'=>''))
    {

    	if(!$dataTransactionInvoice['id']) {

			return  array('status' => 'Fail', 'error-message'=>'id not invalid');

 		}

 		if(!$dataTransactionInvoice['id_service']) {

			return  array('status' => 'Fail', 'error-message'=>'id_service not invalid');

 		}

 		if(!$dataTransactionInvoice['id_user']) {

			return  array('status' => 'Fail', 'error-message'=>'id_user not invalid');

 		}

 		if($dataTransactionInvoice['percent'] == "") {

			return  array('status' => 'Fail', 'error-message'=>'percent not invalid');

 		}

		if($dataTransactionInvoice['amount'] == "") {

			return  array('status' => 'Fail', 'error-message'=>'amount not invalid');

 		}

 		if(!$dataTransactionInvoice['create_date']) {

			return  array('status' => 'Fail', 'error-message'=>'create_date not invalid');

 		}

 		if($dataTransactionInvoice['debt'] == "") {

			return  array('status' => 'Fail', 'error-message'=>'debt not invalid');

 		}

 		$pay_date = $dataTransactionInvoice['pay_date'] ? date('Y-m-d H:i:s',strtotime(str_replace('/', '-',$dataTransactionInvoice['pay_date']))) : null;

		if (TransactionInvoice::model()->updateByPk($dataTransactionInvoice['id'], array('id_service' => $dataTransactionInvoice['id_service'], 'id_user' => $dataTransactionInvoice['id_user'], 'percent' => $dataTransactionInvoice['percent'], 'description' => CsService::model()->findByPk($dataTransactionInvoice['id_service'])->name, 'amount' => $dataTransactionInvoice['amount'], 'create_date' => $dataTransactionInvoice['create_date'], 'pay_date' => $pay_date, 'debt' => $dataTransactionInvoice['debt']))) {

			return  array('status' => 'successful');

		}

		return  array('status' => 'Fail', 'error-message'=>'update failed');

    }

    public function changeIdService($id_service,$id_user)
    {

		$price = Yii::app()->db->createCommand()
                ->select('cs_service.price')
                ->from('cs_service')
                ->where('cs_service.status = 1')
                ->andWhere('cs_service.id=:id_service', array(':id_service' => $id_service))
                ->queryRow();

        $price = $price?$price['price']:"";

        $id_service_type_tk = Yii::app()->db->createCommand()
                ->select('cs_service_tk.id_service_type_tk')
                ->from('cs_service_tk')
                ->where('cs_service_tk.st = 1')
                ->andWhere('cs_service_tk.id_cs_service=:id_cs_service', array(':id_cs_service' => $id_service))
                ->queryRow();


        if ($id_service_type_tk) {

        	$percent = Yii::app()->db->createCommand()
                ->select('cs_percent_tk.percent')
                ->from('cs_percent_tk')
                ->where('cs_percent_tk.st = 1')
                ->andWhere('cs_percent_tk.id_service_type_tk=:id_service_type_tk', array(':id_service_type_tk' => $id_service_type_tk['id_service_type_tk']))
                ->andWhere('cs_percent_tk.id_gp_users=:id_gp_users', array(':id_gp_users' => $id_user))
                ->queryRow();

	  	    $percent = $percent?$percent['percent']:"";

	    } else {

	    	$percent = "";

	    }

        $data = array('price' => $price, 'percent' => $percent);

        return  $data;

    }


}
