<?php

/**
 * This is the model class for table "insurance".
 *
 * The followings are the available columns in table 'insurance':
 * @property string $id
 * @property string $code
 * @property integer $id_branch
 * @property string $id_customer
 * @property string $id_invoice
 * @property string $code_invoice
 * @property integer $id_partner
 * @property double $amount
 * @property double $balance
 * @property integer $source
 * @property integer $status
 * @property string $create_date
 * @property string $id_author
 * @property string $note
 * @property string $delete_date
 * @property string $delete_author
 */

class Insurance extends CActiveRecord
{
	#region --- PARAMS
	const INVOICE = 1;
    const OTHER = 2;

    static $_type = array(
        1 => "Hóa đơn",
        2 => "Khác",
    );

    static $_typeInsurance = array(self::OTHER);
	#endregion

    #region --- INIT
    public function tableName()
	{
		return 'insurance';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_branch, id_partner, source, status', 'numerical', 'integerOnly'=>true),
            array('amount, balance', 'numerical'),
            array('code, id_customer, id_invoice, code_invoice, id_author, delete_author', 'length', 'max'=>10),
            array('note', 'length', 'max'=>255),
            array('create_date, delete_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, id_branch, id_customer, id_invoice, code_invoice, id_partner, amount, balance, source, status, create_date, id_author, note, delete_date, delete_author', 'safe', 'on'=>'search'),
        );
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'customer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'id_branch'),
			'partner' => array(self::BELONGS_TO, 'Partner', 'id_partner'),
		);
	}

	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'code' => 'Code',
            'id_branch' => 'Id Branch',
            'id_customer' => 'Id Customer',
            'id_invoice' => 'Id Invoice',
            'code_invoice' => 'Code Invoice',
            'id_partner' => 'Id Partner',
            'amount' => 'Amount',
            'balance' => 'Balance',
            'source' => 'Source',
            'status' => 'Status',
            'create_date' => 'Create Date',
            'id_author' => 'Id Author',
            'note' => 'Note',
            'delete_date' => 'Delete Date',
            'delete_author' => 'Delete Author',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    #endregion

    #region --- TAO MA GIAO DICH
    public function createCode() {
        $date = date('Y-m-d');

        $code = str_replace(array('-', ' ', ':'), '', substr($date, 2));
        $num = Insurance::model()->count(array('condition' => 'date(create_date) ="' . $date . '"')) + 1;

        $codenum = str_pad($num, '3', '0', STR_PAD_LEFT);
        $code .= $codenum;
        return $code;
    }
    #endregion

	#region --- DANH SACH CONG NO BAO HIEM
	public function getList($curpage, $limit, $dataSearch = array()) {
		$start_point = $limit * ($curpage - 1);
		$transaction = new Insurance();

        $criteria = new CDbCriteria();

        if (isset($dataSearch['code']) && $dataSearch['code']) {
            $criteria->addCondition("t.code = " . $dataSearch['code']);
        } else {
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

            if (isset($dataSearch['id_branch']) && $dataSearch['id_branch']) {
                $criteria->addCondition('t.id_branch =' . $dataSearch['id_branch']);
            }

            if (isset($dataSearch['id_customer']) && $dataSearch['id_customer']) {
                $criteria->addCondition('id_customer = ' . $dataSearch['id_customer']);
            }

            if (isset($dataSearch['code_invoice']) && $dataSearch['code_invoice']) {
                $criteria->addSearchCondition('code_invoice', $dataSearch['code_invoice'], true);
            }

            if (isset($dataSearch['id_partner']) && $dataSearch['id_partner']) {
                $criteria->addCondition('id_partner = '. $dataSearch['id_partner']);
            }
        }

        $criteria->addCondition('t.status >= 0');
        $count = $transaction->count($criteria);
        $page = ceil($count / $limit);

        $criteria->order  = 't.create_date DESC';
        $criteria->limit  = $limit;
        $criteria->offset = $start_point;

        $data = $transaction->with(array(
			'customer' => array('select' => 'code_number, fullname'),
			'branch' => array('select' => 'name'),
			'partner' => array('select' => 'name'),
		))->findAll($criteria);

        return array('count' => $count, 'page' => $page, 'data' => $data);
	}
	#endregion

	#region --- THEM CONG NO BAO HIEM
    public function addInsuranceDebt($data = array()) {
        $id_customer = isset($data['id_customer']) ? $data['id_customer'] : false;
        if (!$id_customer) {
            return array('status' => 0, 'error-message' => 'Thông tin khách hàng không hợp lệ!');
        }

        $checkCus = Customer::model()->countByAttributes(array('id' => $id_customer, 'status' => 1));
        if ($checkCus <= 0) {
            return array('status' => 0, 'error-message' => 'Thông tin khách hàng không tồn tại!');
        }

        $source = isset($data['source']) ? $data['source'] : self::INVOICE;
        $id_invoice = isset($data['id_invoice']) ? $data['id_invoice'] : false;
        $code_invoice = isset($data['code_invoice']) ? $data['code_invoice'] : false;

        if ($source == self::INVOICE) {
            if (!$id_invoice && !$code_invoice) {
                return array('status' => 0, 'error-message' => 'Thông tin hóa đơn không hợp lệ!');
            }

            $inv = null;
            if ($id_invoice) {
                $inv = Invoice::model()->find(array(
                    'select' => 'id, code',
                    'condition' => "id = $id_invoice AND status >= 0"
                ));
            }

            if (!$inv && $code_invoice) {
                $inv = Invoice::model()->find(array(
                    'select' => 'id, code',
                    'condition' => "code = '$code_invoice' AND status >= 0"
                ));
            }

            if (!$inv) {
                return array('status' => 0, 'error-message' => 'Thông tin hóa đơn không tồn tại!');
            }

            $data['code_invoice'] = $inv->code;
            $data['id_invoice'] = $inv->id;
        }

		$id_partner = isset($data['id_partner']) ? $data['id_partner'] : false;
        if ($id_partner) {
            $checkPartner = Partner::model()->countByAttributes(array('id' => $id_partner, 'status' => 1));
			if ($checkPartner <= 0) {
				return array('status' => 0, 'error-message' => 'Thông tin đối tác bảo hiểm không tồn tại!');
			}
        }

        $amount = isset($data['amount']) ? $data['amount'] : 0;
        if ($amount <= 0) {
            return array('status' => 0, 'error-message' => 'Giá trị công nợ bảo hiểm không hợp lệ!');
        }

        $insurance = new Insurance();

        $insurance->attributes = $data;
        $insurance->balance = $insurance->amount;
        $insurance->create_date = date('Y-m-d H:i:s');
        $insurance->id_author = Yii::app()->user->getState('user_id');
        $insurance->code = $this->createCode();

        if (!($insurance->validate() && $insurance->save())) {
            return array('status' => 0, 'error-message' => $insurance->getErrors(), 'model' => 'insurance');
            throw new Exception("Error Processing Request", 1);
        }

        $insuranceTrans = new InsuranceTransaction();
        $insuranceTrans->attributes = $data;
        $insuranceTrans->id_insurance = $insurance->id;
        $insuranceTrans->type = InsuranceTransaction::INSURANCE_INVOICE;
        $insuranceTrans->create_date = date('Y-m-d H:i:s');
        $insuranceTrans->id_author = Yii::app()->user->getState('user_id');
        $insuranceTrans->reason = "Thêm công nợ bảo hiểm từ hóa đơn #" . $insurance->code_invoice;

        if (!($insuranceTrans->validate() && $insuranceTrans->save())) {
            return array('status' => 0, 'error-message' => $insuranceTrans->getErrors(), 'model' => 'insuranceTransaction');
            throw new Exception("Error Processing Request", 1);
        }

        return array('status' => 1, 'code' => $insurance->code);
	}
	#endregion
}
