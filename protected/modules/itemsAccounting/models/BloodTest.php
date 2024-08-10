<?php

/**
 * This is the model class for table "blood_test".
 *
 * The followings are the available columns in table 'blood_test':
 * @property string $id
 * @property string $id_customer
 * @property double $amount
 * @property integer $type
 * @property integer $status
 * @property string $id_author
 * @property string $create_date
 * @property string $note
 */
class BloodTest extends CActiveRecord
{
	#region --- PARAMS
	const BLOODTEST_RECEIPT = 1;
    const BLOODTEST_REFUND = 2;

    static $_type = array(
        1 => array(
            'name' => "Phiếu thu (+)",
            'calculation' => '+'
        ),
        2 => array(
            'name' => "Phiếu trả (-)",
            'calculation' => '-'
        )
    );

	static $_typeBloodTest = array(self::BLOODTEST_RECEIPT, self::BLOODTEST_REFUND);
	static $_receipt = array(self::BLOODTEST_RECEIPT);
	static $_refund = array(self::BLOODTEST_REFUND);
	#endregion

	#region --- INIT
/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blood_test';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, status', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('id_customer, id_author', 'length', 'max'=>10),
			array('note', 'length', 'max'=>255),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_customer, amount, type, status, id_author, create_date, note', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'GpUsers', 'id_author'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_customer' => 'Id Customer',
			'amount' => 'Amount',
			'type' => 'Type',
			'status' => 'Status',
			'id_author' => 'Id Author',
			'create_date' => 'Create Date',
			'note' => 'Note',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_customer',$this->id_customer,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);
		$criteria->compare('id_author',$this->id_author,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BloodTest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	#endregion

	#region --- DANH SACH XET NGHIEM MAU CUA KHACH HANG
	public function getList($curpage, $limit, $dataSearch = array()) {
		$start_point = $limit * ($curpage - 1);
		$bloodTest = new BloodTest();

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

        $criteria->addCondition('t.status >= 0');
        $count = $bloodTest->count($criteria);
        $page = ceil($count / $limit);

        $criteria->order  = 't.create_date DESC';
        $criteria->limit  = $limit;
        $criteria->offset = $start_point;

        $data = $bloodTest->with(array(
			'user' => array('select' => 'name')
		))->findAll($criteria);

        return array('count' => $count, 'page' => $page, 'data' => $data);
	}
	#endregion

	#region --- TAO PHIEU THU / TRA CHI PHI XET NGHIEM MAU
	public function addBloodTest($data) {
		$id_customer = isset($data['id_customer']) ? $data['id_customer'] : false;
		if (!$id_customer) {
			return array('status' => 0, 'error-message' => 'Không có thông tin khách hàng');
		}

		$amount = isset($data['amount_update']) ? $data['amount_update'] : 0;
        if ($amount <= 0) {
            return array('status' => 0, 'error-message' => 'Chi phí xét nghiệm nhỏ hơn 0!');
		}

		$type = isset($data['type']) ? $data['type'] : false;
		$cal = isset(self::$_type[$type]['calculation']) ? (self::$_type[$type]['calculation']) : false;
		if (!$cal) {
            return array('status' => 0, 'error-message' => 'Thông tin cập nhật chi phí xét nghiệm không hợp lệ!');
        }

		$customer = Customer::model()->find(array(
			'select' => 'id',
			'condition' => "id = $id_customer"
		));
		if (!$customer) {
			return array('status' => 0, 'error-message' => 'Không tồn tại thông tin khách hàng');
		}

		$bloodTest = new BloodTest();
		$bloodTest->attributes = $data;
		$bloodTest->id_author = Yii::app()->user->getState('user_id');
		$bloodTest->create_date = date('Y-m-d H:i:s');
		$bloodTest->amount = $amount;

		$trans = Yii::app()->db->beginTransaction();
		$result = array();

		try {
			if (!($bloodTest->validate() && $bloodTest->save())) {
				$result = array('status' => 0, 'error-message' => $bloodTest->getErrors(), 'model' => 'bloodTeste_transaction');
				throw new Exception("Error Processing Request", 1);
			}

			$data = $bloodTest->attributes;

			$data['user_name'] = '';

			$user = GpUsers::model()->find(array(
				'select' => 'name',
				'condition' => 'id = ' . $bloodTest->id_author
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

	#region --- CAP NHAT XET NGHIEM MAU HOA DON CUA KHACH HANG
	public function updateCustomerInvoiceDeposit($data) {
		$id_customer = isset($data['id_customer']) ? $data['id_customer'] : false;
		if (!$id_customer) {
			return array('status' => 0, 'error-message' => 'Không có thông tin khách hàng');
		}

		$amount = isset($data['amount']) ? $data['amount'] : 0;
        if ($amount <= 0) {
            return array('status' => 0, 'error-message' => 'Số tiền bloodTest nhỏ hơn 0!', 'amount' => CJSON::encode($data));
		}

		$type = isset($data['type']) ? $data['type'] : false;
		$cal = isset(self::$_type[$type]['calculation']) ? (self::$_type[$type]['calculation']) : false;
		if (!$cal) {
            return array('status' => 0, 'error-message' => 'Thông tin cập nhật bloodTest không hợp lệ!');
        }

		$customer = Customer::model()->find(array(
			'select' => 'bloodTest',
			'condition' => "id = $id_customer"
		));
		if (!$customer) {
			return array('status' => 0, 'error-message' => 'Không tồn tại thông tin khách hàng');
		}

		$customer_bloodTest = $customer->bloodTest + $amount;

		if ($cal == '+' && ($customer->bloodTest + $amount) >= 0) {
			$customer_bloodTest = $customer->bloodTest + $amount;
		} else if ($cal == '-' && ($customer->bloodTest - $amount) >= 0) {
			$customer_bloodTest = $customer->bloodTest - $amount;
		} else {
			return array('status' => 0, 'error-message' => 'Số tiền cập nhật bloodTest không hợp lệ.', 'model' => 'bloodTeste_transaction');
		}

		$bloodTest = new BloodTest();
		$bloodTest->attributes = $data;
		$bloodTest->id_author = Yii::app()->user->getState('user_id');
		$bloodTest->create_date = date('Y-m-d H:i:s');
		$bloodTest->amount = $amount;

		if (!($bloodTest->validate() && $bloodTest->save())) {
			return array('status' => 0, 'error-message' => $bloodTest->getErrors(), 'model' => 'bloodTeste_transaction');
		}

		if ($customer->updateByPk($id_customer, array('bloodTest' => $customer_bloodTest)) == 0) {
			return array('status' => 0, 'error-message' => 'Không có thông tin cập nhật', 'model' => 'customer');
		}

		return array('status' => 1);
	}
	#endregion
}
