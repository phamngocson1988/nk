<?php
/**
 * This is the model class for table "insurance_transaction".
 *
 * The followings are the available columns in table 'insurance_transaction':
 * @property string $id
 * @property string $id_insurance
 * @property double $amount
 * @property integer $type
 * @property integer $status
 * @property string $reason
 * @property string $create_date
 * @property string $id_author
 */

class InsuranceTransaction extends CActiveRecord
{
	#region --- PARAMS
	const INSURANCE_INCREASE = 1;
    const INSURANCE_DECREASE = 2;
    const INSURANCE_PAY = 3;
    const INSURANCE_INVOICE = 4;

    static $_type = array(
        1 => array(
            'name' => "Thêm công nợ BH (+)",
            'calculation' => '+'
        ),
        2 => array(
            'name' => "Giảm công nợ BH (-)",
            'calculation' => '-'
        ),
        3 => array(
            'name' => "Bảo hiểm thanh toán (-)",
            'calculation' => '-'
        ),
        4 => array(
            'name' => "Thêm công nợ BH từ HĐ (+)",
            'calculation' => '-'
        ),
    );

    static $_typeUpdate = array(self::INSURANCE_INCREASE, self::INSURANCE_DECREASE);
    static $_typePay = array(self::INSURANCE_PAY);
	#endregion

	#region --- INIT
	public function tableName() {
		return 'insurance_transaction';
	}

	public function rules() {
		return array(
            array('type', 'numerical', 'integerOnly'=>true),
            array('amount, status', 'numerical'),
            array('id_insurance, id_author', 'length', 'max'=>10),
            array('reason', 'length', 'max'=>255),
            array('create_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_insurance, amount, type, status, reason, create_date, id_author', 'safe', 'on'=>'search'),
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
            'employee' => array(self::BELONGS_TO, 'GpUsers', 'id_author'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'id_insurance' => 'Id Insurance',
            'amount' => 'Amount',
            'type' => 'Type',
            'status' => 'Status',
            'reason' => 'Reason',
            'create_date' => 'Create Date',
            'id_author' => 'Id Author',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InsuranceTransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
    }
	#endregion

    #region --- CAP NHAT BAO HIEM - THEM CONG NO BAO HIEM
    public function addInsuranceTransaction($data = array()) {
        $id_insurance = isset($data['id_insurance']) ? $data['id_insurance'] : false;
        $type = isset($data['type']) ? $data['type'] : false;
        $amount_update = isset($data['amount_update']) ? $data['amount_update'] : 0;
        $amount_change = isset($data['amount_change']) ? $data['amount_change'] : 0;

        $cal = isset(self::$_type[$type]['calculation']) ? (self::$_type[$type]['calculation']) : false;

        if (!$id_insurance || !$type || !$cal || $amount_update <= 0 || $amount_change <= 0) {
            return array('status' => 0, 'error-message' => 'Thông tin cập nhật công nợ bảo hiểm không hợp lệ!', 'data' => $id_insurance);
        }

        $insurance = Insurance::model()->findByPk($id_insurance);
        if (!$insurance) {
            return array('status' => 0, 'error-message' => 'Thông tin bảo hiểm không tồn tại!');
        }

        if ($insurance->amount <= 0) {
            return array('status' => 0, 'error-message' => 'Công nợ bảo hiểm nhỏ hơn 0!');
        }

        $balance = $insurance->balance;
        $sum_amount_update = $insurance->amount;

        if ($cal == '+') {
            $sum_amount_update = $insurance->amount + $amount_change;
            $balance = $insurance->balance + $amount_change;
        } else if($cal == '-') {
            $sum_amount_update = $insurance->amount - $amount_change;
            $balance = $insurance->balance - $amount_change;
        }

        if ($sum_amount_update != $amount_update) {
            return array('status' => 0, 'error-message' => 'Giá trị cập nhật công nợ BH không hợp lệ!');
        }

        $insurance_transaction = new InsuranceTransaction();
        $insurance_transaction->attributes = $data;
        $insurance_transaction->id_insurance = $id_insurance;
        $insurance_transaction->amount = $amount_change;
        $insurance_transaction->type = $type;
        $insurance_transaction->create_date = date('Y-m-d H:i:s');
        $insurance_transaction->id_author = Yii::app()->user->getState('user_id');

        $trans = Yii::app()->db->beginTransaction();
        $result = array();

        try {
            if (!($insurance_transaction->validate() && $insurance_transaction->save())) {
                $result = array('status' => 0, 'error-message' => $insurance_transaction->getErrors(), 'modal' => 'insurance_transaction');
                throw new Exception("Error Processing Request", 1);
            }

            $insurance->amount = $sum_amount_update;
            $insurance->balance = $balance;

            if (!($insurance->validate() && $insurance->save())) {
                $result = array('status' => 0, 'error-message' => $insurance_transaction->getErrors(), 'modal' => 'insurance');
                throw new Exception("Error Processing Request", 1);
            }

            $result = array('status' => 1, 'data' => $insurance->attributes);

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

        return $result;
    }
    #endregion

    #region --- THANH TOAN CONG NO BAO HIEM
    public function paidInsuranceTransaction($data = array()) {
        $id_insurance = isset($data['id_insurance']) ? $data['id_insurance'] : false;
        $type = isset($data['type']) ? $data['type'] : InsuranceTransaction::INSURANCE_PAY;
        $amount_pay = isset($data['amount_paid']) ? $data['amount_paid'] : 0;
        $amount_balance = isset($data['amount_balance']) ? $data['amount_balance'] : 0;

        if (!$id_insurance || $amount_pay <= 0 || $amount_balance < 0) {
            return array('status' => 0, 'error-message' => 'Thông tin thanh toán công nợ bảo hiểm không hợp lệ!');
        }

        $insurance = Insurance::model()->findByPk($id_insurance);
        if (!$insurance) {
            return array('status' => 0, 'error-message' => 'Thông tin bảo hiểm không tồn tại!');
        }

        if ($insurance->amount <= 0) {
            return array('status' => 0, 'error-message' => 'Công nợ bảo hiểm nhỏ hơn 0!');
        }

        if ($amount_pay > $insurance->amount) {
            return array('status' => 0, 'error-message' => 'Bảo hiểm thanh tóan lớn hơn công nợ hiện tại!');
        }

        if ($amount_pay + $amount_balance != $insurance->balance) {
            return array('status' => 0, 'error-message' => 'Giá trị thanh toán công nợ BH không hợp lệ!', 'data1' => ($amount_pay + $amount_balance), 'data2' => $insurance->amount);
        }

        $insurance->balance = $amount_balance;

        $insurance_transaction = new InsuranceTransaction();
        $insurance_transaction->attributes = $data;
        $insurance_transaction->id_insurance = $id_insurance;
        $insurance_transaction->amount = $amount_pay;
        $insurance_transaction->type = $type;
        $insurance_transaction->create_date = date('Y-m-d H:i:s');
        $insurance_transaction->id_author = Yii::app()->user->getState('user_id');

        $trans = Yii::app()->db->beginTransaction();
        $result = array();

        try {
            if (!($insurance_transaction->validate() && $insurance_transaction->save())) {
                $result = array('status' => 0, 'error-message' => $insurance_transaction->getErrors(), 'modal' => 'insurance_transaction');
                throw new Exception("Error Processing Request", 1);
            }

            if (!($insurance->validate() && $insurance->save())) {
                $result = array('status' => 0, 'error-message' => $insurance_transaction->getErrors(), 'modal' => 'insurance');
                throw new Exception("Error Processing Request", 1);
            }

            $result = array('status' => 1, 'data' => $insurance->attributes);

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

        return $result;
    }
    #endregion
}
