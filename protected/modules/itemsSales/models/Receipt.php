<?php

/**
 * This is the model class for table "receipt".
 *
 * The followings are the available columns in table 'receipt':
 * @property integer $id
 * @property string $code
 * @property integer $id_invoice
 * @property double $pay_amount
 * @property double $pay_sum
 * @property double $pay_insurance
 * @property string $pay_date
 * @property integer $pay_type
 * @property integer $card_type
 * @property double $card_percent
 * @property double $card_val
 * @property double $pay_promotion
 * @property integer $is_company - 0/1 default 0
 * @property string $curr_unit
 * @property string $trans_name
 * @property double $curr_amount
 * @property double $curr_change
 * @property integer $id_note
 * @property integer $point
 * @property integer $id_author
 * @property string $author_name
 * @property double $currency
 * @property double $exchange_rate
 */
class Receipt extends CActiveRecord
{
	public $payType = array(
		'0' => '',
		'1' => 'Tiền mặt',
		'2' => 'Thẻ tín dụng',
		'3' => 'Chuyển khoản',
        '4' => 'Bảo hiểm bảo lãnh',
        '5' => 'Deposit',
	);
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'receipt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_invoice, pay_type, card_type, point, id_author', 'numerical', 'integerOnly'=>true),
			array('pay_amount, pay_sum, pay_insurance, card_percent, card_val, pay_promotion, curr_amount, curr_change, currency, exchange_rate', 'numerical'),
			array('curr_unit', 'length', 'max'=>5),
			array('pay_date, trans_name, code, author_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_invoice, id_note, pay_amount, pay_sum, pay_insurance, pay_date, pay_type, card_type, card_percent, card_val, pay_promotion, curr_unit, curr_amount, curr_change, trans_name', 'safe', 'on'=>'search'),
			array('is_company', 'safe')
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
			'pay_amount' => 'Pay Amount',
			'pay_sum' => 'Pay Sum',
			'pay_insurance' => 'Pay Insurance',
			'pay_date' => 'Pay Date',
			'pay_type' => 'Pay Type',
			'card_type' => 'Card Type',
			'card_percent' => 'Card Percent',
			'card_val' => 'Card Val',
			'pay_promotion' => 'Pay Promotion',
			'curr_unit' => 'Curr Unit',
			'curr_amount' => 'Curr Amount',
			'curr_change' => 'Curr Change',
			'id_note' => 'id_note',
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
		$criteria->compare('pay_amount',$this->pay_amount);
		$criteria->compare('pay_sum',$this->pay_sum);
		$criteria->compare('pay_insurance',$this->pay_insurance);
		$criteria->compare('pay_date',$this->pay_date,true);
		$criteria->compare('pay_type',$this->pay_type);
		$criteria->compare('card_type',$this->card_type);
		$criteria->compare('card_percent',$this->card_percent);
		$criteria->compare('card_val',$this->card_val);
		$criteria->compare('pay_promotion',$this->pay_promotion);
		$criteria->compare('curr_unit',$this->curr_unit,true);
		$criteria->compare('curr_amount',$this->curr_amount);
		$criteria->compare('curr_change',$this->curr_change);
		$criteria->compare('id_note',$this->id_note);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Receipt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchReceipt($conditional)
    {
        $receipt = Receipt::model()->findAll(array(
            'select'    => '*',
            'condition' => $conditional,
        ));

        return $receipt;
    }

    //yyyymmdd001
    public function createCodeRecept()
    {
        $date = date('Y-m-d');
        $code = str_replace(array('-',' ',':'),'',substr( $date, 2 ));
        $num = Receipt::model()->count(array('condition' => 'date(pay_date)="'.$date.'"')) + 1;
        $codenum = str_pad($num, '3' ,'0', STR_PAD_LEFT);
        $code .= $codenum;
        return $code;
    }



	public function searchCustomer($curpage,$limit,$search)
	{
		$start_point=20*($curpage-1);
		$p = new Customer;
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();
		if($search)
		{
			$v->addSearchCondition('fullname',$search,true);
	        $v->addSearchCondition('code_number',$search,true,'OR');
	        $phone = CsLead::model()->getVnPhone($search);
	        $v->addSearchCondition('phone',$phone,true,'OR');
		}
	    $v->order= 'id DESC';
	    $v->limit = $limit;
	    $v->offset = $start_point;
	    $q->mergeWith($v);

	    $data = $p->findAll($v);
	    return $data;
	}

	public function getFilterListReceipt($from_date, $to_date, $pay_type, $trans_name, $partner) {
        $con = Yii::app()->db;
        $sql = " select receipt.*, SUM(receipt.pay_amount) sum_pay_amount from receipt where 1 = 1 ";

        if ($from_date) {
            $from_date = date('Y-m-d',strtotime(str_replace('/', '-',$from_date)));
            $sql .= " and DATE(pay_date) >= '" . $from_date . "' ";
        }

        if ($to_date) {
            $to_date = date('Y-m-d',strtotime(str_replace('/', '-',$to_date)));
            $sql .= " and DATE(pay_date) <= '" . $to_date . "' ";
		}

		if ($partner) {
			$sql .= " and id_invoice IN (select id from invoice iv where iv.partnerID = $partner) ";
		}

        if ($pay_type) {
            $sql .= " and receipt.pay_type = '" . $pay_type . "' ";
        }

        if ($pay_type == 3) {
        	$sql .= " and receipt.trans_name = '" . $trans_name . "' ";
		}

		if ($pay_type == 3) {
        	$sql .= " and receipt.trans_name = '" . $trans_name . "' ";
        }

        $sql .= " group by receipt.id_invoice order by receipt.id_invoice desc ";
        $data = $con->createCommand($sql)->queryAll();

        return $data;
    }

    public function getPayReceipt($id_invoice) {
		$data = array();
		$receiptWidthInvoiceID = Receipt::model()->findAllByAttributes(array('id_invoice' => $id_invoice));

		$sumCash = 0;
		$sumCredit = 0;
		$sumTransfer = 0;
		$sumUSD = 0;

		if($receiptWidthInvoiceID) {
			foreach ($receiptWidthInvoiceID as $key => $val) {
				if($val->pay_type == 1) {$sumCash += $val->pay_amount;}
				if($val->pay_type == 2) {$sumCredit += $val->pay_amount;}
				if($val->pay_type == 3) {$sumTransfer += $val->pay_amount;}

				$sumUSD += $val->currency;
			}
		}

		$data["sum_cash"] = $sumCash;
		$data["sum_credit"] = $sumCredit;
		$data["sum_transfer"] = $sumTransfer;
		$data["sum_usd"] = $sumUSD;

		return $data;

    	// $con = Yii::app()->db;

        // $sql = " select SUM(receipt.pay_amount)
        //         from receipt
		// 		where receipt.id_invoice = '" . $id_invoice . "' ";

		// $sql1 = $sql . " and receipt.pay_type = 1 ";
		// $sql2 = $sql . " and receipt.pay_type = 2 ";
		// $sql3 = $sql . " and receipt.pay_type = 3 ";

		// $data["sum_cash"] = $con->createCommand($sql1)->queryScalar();
		// $data["sum_credit"] = $con->createCommand($sql2)->queryScalar();
		// $data["sum_transfer"] = $con->createCommand($sql3)->queryScalar();

		// return $data;
    }

}
