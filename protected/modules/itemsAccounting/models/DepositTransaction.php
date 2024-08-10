<?php

/**
 * This is the model class for table "deposit_transaction".
 *
 * The followings are the available columns in table 'deposit_transaction':
 * @property string $id
 * @property string $id_customer
 * @property string $id_invoice
 * @property string $code_invoice
 * @property double $amount
 * @property integer $type
 * @property integer $status
 * @property string $id_author
 * @property string $create_date
 * @property string $note
 */
class DepositTransaction extends CActiveRecord
{
	#region --- PARAMS
	const DEPOSIT_INCREASE = 1;
    const DEPOSIT_DECREASE = 2;
	const DEPOSIT_PAY_INVOICE = 3;
	const DEPOSIT_ADD_INVOICE = 4;

    static $_type = array(
        1 => array(
            'name' => "Thêm deposit (+)",
            'calculation' => '+'
        ),
        2 => array(
            'name' => "Rút deposit (-)",
            'calculation' => '-'
        ),
        3 => array(
            'name' => "Thanh toán hóa đơn (-)",
            'calculation' => '-'
		),
		4 => array(
            'name' => "Thêm deposit từ hóa đơn (+)",
            'calculation' => '+'
        )
    );

    static $_typeUpdate = array(self::DEPOSIT_INCREASE, self::DEPOSIT_DECREASE);
	static $_typePay = array(self::DEPOSIT_PAY_INVOICE);
	static $_typeIncrease = array(self::DEPOSIT_INCREASE, self::DEPOSIT_ADD_INVOICE);
	static $_typeDescrease = array(self::DEPOSIT_DECREASE, self::DEPOSIT_PAY_INVOICE);
	#endregion

	#region --- INIT
	public function tableName()
	{
		return 'deposit_transaction';
	}

	public function rules()
	{
		return array(
			array('type, status', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('id_customer, id_invoice, id_author', 'length', 'max'=>10),
			array('code_invoice', 'length', 'max'=>15),
			array('create_date, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_customer, id_invoice, code_invoice, amount, type, status, id_author, create_date, note', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'GpUsers', 'id_author'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_customer' => 'Id Customer',
			'id_invoice' => 'Id Invoice',
			'code_invoice' => 'Code Invoice',
			'amount' => 'Amount',
			'type' => 'Type',
			'status' => 'Status',
			'id_author' => 'Id Author',
			'create_date' => 'Create Date',
		);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	#endregion

	#region --- DANH SACH DEPOSIT CUA KHACH HANG
	public function getList($curpage, $limit, $dataSearch = array()) {
		$start_point = $limit * ($curpage - 1);
		$deposit = new DepositTransaction();

        $criteria = new CDbCriteria();

		if (isset($dataSearch['time']) && $dataSearch['time']) {
			$time = $dataSearch['time'];

			if ($time == 5) {
				$criteria->addCondition("'" . $dataSearch['start'] . "' <= Date(t.create_date)");
				$criteria->addCondition("'" . $dataSearch['end'] . "' >= Date(t.create_date)");
			} else if ($time == 2) {
				$today = date('Y-m-d');
				$criteria->addCondition('DATE(t.create_date) = :create_date');
				$criteria->params = array(':create_date' => $today);
			} else if ($time == 3) {
				$day = date('Y-m-d', strtotime(date('Y-m-d') . ' - 7 day'));
				$criteria->addCondition('DATE(t.create_date) >= :create_date');
				$criteria->params = array(':create_date' => $day);
			} else if ($time == 4) {
				$month = date('m', strtotime(date('Y-m-d') . ' - 1 month'));
				$criteria->addCondition('MONTH(t.create_date) = :create_date');
				$criteria->params = array(':create_date' => $month);
			}
		}

		if (isset($dataSearch['id_customer']) && $dataSearch['id_customer']) {
			$criteria->addCondition('id_customer = ' . $dataSearch['id_customer']);
		}

		if (isset($dataSearch['code_invoice']) && $dataSearch['code_invoice']) {
			$criteria->addSearchCondition('code_invoice', $dataSearch['code_invoice'], true);
		}

        $criteria->addCondition('t.status >= 0');
        $count = $deposit->count($criteria);
        $page = ceil($count / $limit);

        $criteria->order  = 't.create_date DESC';
        $criteria->limit  = $limit;
        $criteria->offset = $start_point;

        $data = $deposit->with(array(
			'user' => array('select' => 'name')
		))->findAll($criteria);

        return array('count' => $count, 'page' => $page, 'data' => $data);
	}
	#endregion

	#region --- CAP NHAT DEPOSIT CUA KHACH HANG
	public function updateCustomerDeposit($data) {
		$id_customer = isset($data['id_customer']) ? $data['id_customer'] : false;
		if (!$id_customer) {
			return array('status' => 0, 'error-message' => 'Không có thông tin khách hàng');
		}

		$amount = isset($data['amount_update']) ? $data['amount_update'] : 0;
        if ($amount <= 0) {
            return array('status' => 0, 'error-message' => 'Số tiền deposit nhỏ hơn 0!');
		}

		$type = isset($data['type']) ? $data['type'] : false;
		$cal = isset(self::$_type[$type]['calculation']) ? (self::$_type[$type]['calculation']) : false;
		if (!$cal) {
            return array('status' => 0, 'error-message' => 'Thông tin cập nhật deposit không hợp lệ!');
        }

		$customer = Customer::model()->find(array(
			'select' => 'deposit',
			'condition' => "id = $id_customer"
		));
		if (!$customer) {
			return array('status' => 0, 'error-message' => 'Không tồn tại thông tin khách hàng');
		}

		$amount_deposit = isset($data['amount_deposit']) ? $data['amount_deposit'] : 0;
		$customer_deposit = $customer->deposit;

		if ($cal == '+' && ($amount + $customer_deposit) != $amount_deposit) {
			return array('status' => 0, 'error-message' => 'Số tiền deposit không hợp lệ!');
		} else if ($cal == '-' && ($customer_deposit - $amount) != $amount_deposit) {
			return array('status' => 0, 'error-message' => 'Số tiền deposit không hợp lệ!');
		}

		$deposit = new DepositTransaction();
		$deposit->attributes = $data;
		$deposit->id_author = Yii::app()->user->getState('user_id');
		$deposit->create_date = date('Y-m-d H:i:s');
		$deposit->amount = $amount;

		$trans = Yii::app()->db->beginTransaction();
		$result = array();

		try {
			if (!($deposit->validate() && $deposit->save())) {
				$result = array('status' => 0, 'error-message' => $deposit->getErrors(), 'model' => 'deposite_transaction');
				throw new Exception("Error Processing Request", 1);
			}

			if ($customer->updateByPk($id_customer, array('deposit' => $amount_deposit)) == 0) {
				$result = array('status' => 0, 'error-message' => 'Không có thông tin cập nhật', 'model' => 'customer');
				throw new Exception("Error Processing Request", 1);
			}

			$data = $deposit->attributes;

			$data['user_name'] = '';

			$user = GpUsers::model()->find(array(
				'select' => 'name',
				'condition' => 'id = ' . $deposit->id_author
			));
			if ($user) {
				$data['user_name'] = $user->name;
			}

			$data['type_name'] = self::$_type[$data['type']]['name'];

			$result = array('status' => 1, 'data' => $data);

			$trans->commit();
		} catch(Exception $e) {
			$message = $e->getMessage();

			Yii::log($message, CLogger::LEVEL_ERROR, 'updateCustomerDeposit');
			$trans->rollback();
		}

		return $result;
	}
	#endregion

	#region --- CAP NHAT DEPOSIT HOA DON CUA KHACH HANG
	public function updateCustomerInvoiceDeposit($data) {
		$id_customer = isset($data['id_customer']) ? $data['id_customer'] : false;
		if (!$id_customer) {
			return array('status' => 0, 'error-message' => 'Không có thông tin khách hàng');
		}

		$amount = isset($data['amount']) ? $data['amount'] : 0;
        if ($amount <= 0) {
            return array('status' => 0, 'error-message' => 'Số tiền deposit nhỏ hơn 0!', 'amount' => CJSON::encode($data));
		}

		$type = isset($data['type']) ? $data['type'] : false;
		$cal = isset(self::$_type[$type]['calculation']) ? (self::$_type[$type]['calculation']) : false;
		if (!$cal) {
            return array('status' => 0, 'error-message' => 'Thông tin cập nhật deposit không hợp lệ!');
        }

		$customer = Customer::model()->find(array(
			'select' => 'deposit',
			'condition' => "id = $id_customer"
		));
		if (!$customer) {
			return array('status' => 0, 'error-message' => 'Không tồn tại thông tin khách hàng');
		}

		$customer_deposit = $customer->deposit + $amount;

		if ($cal == '+' && ($customer->deposit + $amount) >= 0) {
			$customer_deposit = $customer->deposit + $amount;
		} else if ($cal == '-' && ($customer->deposit - $amount) >= 0) {
			$customer_deposit = $customer->deposit - $amount;
		} else {
			return array('status' => 0, 'error-message' => 'Số tiền cập nhật deposit không hợp lệ.', 'model' => 'deposite_transaction');
		}

		$deposit = new DepositTransaction();
		$deposit->attributes = $data;
		$deposit->id_author = Yii::app()->user->getState('user_id');
		$deposit->create_date = date('Y-m-d H:i:s');
		$deposit->amount = $amount;

		if (!($deposit->validate() && $deposit->save())) {
			return array('status' => 0, 'error-message' => $deposit->getErrors(), 'model' => 'deposite_transaction');
		}

		if ($customer->updateByPk($id_customer, array('deposit' => $customer_deposit)) == 0) {
			return array('status' => 0, 'error-message' => 'Không có thông tin cập nhật', 'model' => 'customer');
		}

		return array('status' => 1);
	}
	#endregion
}