<?php

/**
 * This is the model class for table "v_invoice".
 *
 * The followings are the available columns in table 'v_invoice':
 * @property integer $id
 * @property integer $acount_no
 * @property integer $id_order
 * @property integer $id_author
 * @property string $author_name
 * @property integer $id_branch
 * @property string $branch_name
 * @property integer $id_customer
 * @property string $customer_name
 * @property string $pay_date
 * @property string $sum_amount
 * @property string $sum_tax
 * @property string $balance
 * @property string $note
 * @property integer $status
 */

class VInvoice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('author_name, branch_name', 'required'),
			array('id, acount_no, id_order, id_author, id_branch, id_customer, status', 'numerical', 'integerOnly'=>true),
			array('author_name', 'length', 'max'=>128),
			array('branch_name, customer_name', 'length', 'max'=>255),
			array('sum_amount, sum_tax, balance', 'length', 'max'=>12),
			array('pay_date, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, acount_no, id_order, id_author, author_name, id_branch, branch_name, id_customer, customer_name, pay_date, sum_amount, sum_tax, balance, note, status', 'safe', 'on'=>'search'),
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
			'acount_no' => 'Acount No',
			'id_order' => 'Id Order',
			'id_author' => 'Id Author',
			'author_name' => 'Author Name',
			'id_branch' => 'Id Branch',
			'branch_name' => 'Branch Name',
			'id_customer' => 'Id Customer',
			'customer_name' => 'Customer Name',
			'pay_date' => 'Pay Date',
			'sum_amount' => 'Sum Amount',
			'sum_tax' => 'Sum Tax',
			'balance' => 'Balance',
			'note' => 'Note',
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
		$criteria->compare('acount_no',$this->acount_no);
		$criteria->compare('id_order',$this->id_order);
		$criteria->compare('id_author',$this->id_author);
		$criteria->compare('author_name',$this->author_name,true);
		$criteria->compare('id_branch',$this->id_branch);
		$criteria->compare('branch_name',$this->branch_name,true);
		$criteria->compare('id_customer',$this->id_customer);
		$criteria->compare('customer_name',$this->customer_name,true);
		$criteria->compare('pay_date',$this->pay_date,true);
		$criteria->compare('sum_amount',$this->sum_amount,true);
		$criteria->compare('sum_tax',$this->sum_tax,true);
		$criteria->compare('balance',$this->balance,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VInvoice the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function searchInvoice($curpage, $limit, $searchObj = array()) {
        $start_point = $limit * ($curpage - 1);
        $p = new VInvoice;
        $count = 0;

        $q = new CDbCriteria();
        $v = new CDbCriteria();

        if (isset($searchObj['time']) && $searchObj['time']) {
            $invoice_time = $searchObj['time'];
            if ($invoice_time == 5) {
                $v->addCondition($searchObj['start'] . " <= Date(create_date)");
                $v->addCondition($searchObj['end'] . " >= Date(create_date)");
            } else if ($invoice_time == 2) {              // hôm nay
                $time = date('Y-m-d');
                $v->addCondition('DATE(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            } else if ($invoice_time == 3) {         // 7 ngày trước
                $time = date('Y-m-d', strtotime(date('Y-m-d') . ' - 7 day'));
                $v->addCondition('DATE(create_date) >= :create_date');
                $v->params = array(':create_date' => $time);
            } else {                               // tháng trước
                $time = date('m', strtotime(date('Y-m-d')));
                $v->addCondition('MONTH(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
        }

        if (isset($searchObj['branch']) && $searchObj['branch']) {
            $v->addCondition('id_branch =' . $searchObj['branch']);
        }

        if (isset($searchObj['id_customer']) && $searchObj['id_customer']) {
            $v->addCondition('id_customer = ' . $searchObj['id_customer']);
        }

        if (isset($searchObj['code']) && $searchObj['code']) {
            $v->addSearchCondition('code', $searchObj['code'], true);
        }

        if (isset($searchObj['id']) && $searchObj['id']) {
            $v->addCondition('id = ' . $searchObj['id']);
        }

        if (isset($searchObj['confirm']) && $searchObj['confirm'] != '') {
            $v->addCondition('confirm = ' . $searchObj['confirm']);
        }

        $v->addCondition('status >= 0 AND status != 10');
        $count = $p->count($v);
        $page = ceil($count / $limit);

        $v->order  = 'create_date DESC';
        $v->limit  = $limit;
        $v->offset = $start_point;
        $q->mergeWith($v);

        $data = $p->findAll($v);

        return array('count' => $count, 'page' => $page, 'data' => $data);
    }

    public function searchInvoiceForCus($curpage, $lpp, $id_customer)
    {
    	if(!$id_customer)
    		return -1;

        $start_point = $lpp*($curpage-1);

        $p = new VInvoice;

        $v = new CDbCriteria();

        $v->addCondition("id_customer = $id_customer");

        $tolItem = count($p->findAll($v));
        $tolPage = ceil($tolItem/$lpp);

        $v->order= 'id DESC';
        $v->limit = $lpp;
        $v->offset = $start_point;

        $data = $p->findAll($v);

        return array('tolItem'=>$tolItem, 'tolPage'=>$tolPage, 'data'=>$data);
    }

     public function search_invoicedetail($curpage,$limit,$type,$branch,$search_time,$lstUser,$fromtime="",$totime="")
    {
         $start_point=$limit*($curpage-1);
        $p = new VInvoice;
        $q = new CDbCriteria(array(
        'condition'=>'published="true"'
        ));
        $v = new CDbCriteria();
        if($type==2){
            $v->addCondition('t.status >=0');
        }elseif($type==3){
             $v->addCondition('t.balance >0');
        }
        $time = 0;

        if($search_time) {       // thời gian
            if($search_time == 1) {              // hôm nay
                $time = date('Y-m-d');
                $v->addCondition('DATE(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
            elseif ($search_time == 2) {         // trong tuan
                $time_fisrt = date('Y-m-d',strtotime('monday this week'));
                $time_last = date('Y-m-d',strtotime('sunday this week'));
                $v->addCondition('DATE(create_date) >="'. $time_fisrt .'" AND DATE(create_date) <="'.$time_last.'"');
            }
            elseif($search_time == 3){                               // trong tháng
                $time = date('m',strtotime(date('Y-m-d')));
                $v->addCondition('MONTH(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
            elseif($search_time == 4){
                $time = date('m',strtotime(date('Y-m-d') . ' - 1 month')); //tháng trước
                $v->addCondition('MONTH(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }elseif($search_time == 5){
                $v->addCondition('DATE(create_date) >="'. $fromtime .'" AND DATE(create_date) <="'.$totime.'"');
            }
        }
        if($branch) {
            $v->addCondition('id_branch ='. $branch);
        }
               $count=count($p->findAll($v));

        $v->order= 'id ASC';

        $v->limit = $limit;
        $v->offset = $start_point;
        $q->mergeWith($v);

        $data = $p->findAll($v);

        return array('count'=>$count,'data'=>$data);
    }


     public function search_exportinvoice($type,$branch,$search_time,$lstUser,$fromtime,$totime)
    {
        $p = new VInvoice;
        $q = new CDbCriteria(array(
        'condition'=>'published="true"'
        ));
        $v = new CDbCriteria();
        if($type==2){
        $v->addCondition('t.status >=0');
        }elseif($type==3){
             $v->addCondition('t.balance >0');
        }
        $time = 0;

        if($search_time) {       // thời gian
            if($search_time == 1) {              // hôm nay
                $time = date('Y-m-d');
                $v->addCondition('DATE(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
            elseif ($search_time == 2) {         // 7 ngày trước
                $time_fisrt = date('Y-m-d',strtotime('monday this week'));
                $time_last = date('Y-m-d',strtotime('sunday this week'));

                $v->addCondition('DATE(create_date) >="'. $time_fisrt .'" AND DATE(create_date) <="'.$time_last.'"');
            }
            elseif($search_time == 3){                               // trong tháng
                $time = date('m',strtotime(date('Y-m-d')));
                $v->addCondition('MONTH(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
            elseif($search_time == 4){
                $time = date('m',strtotime(date('Y-m-d') . ' - 1 month')); //tháng trước
                $v->addCondition('MONTH(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }elseif($search_time == 5){
                $v->addCondition('DATE(create_date) >="'. $fromtime .'" AND DATE(create_date) <="'.$totime.'"');
            }
        }
        if($branch) {
            $v->addCondition('id_branch ='. $branch);
        }
               $count=count($p->findAll($v));

        $v->order= 'id ASC';

        $q->mergeWith($v);

        $data = $p->findAll($v);

        return array('count'=>$count,'data'=>$data);
    }

    public function getFilterListInvoice($from_date,$to_date,$id_segment,$text_segment)
    {

        $con = Yii::app()->db;

        $sql = " select v_invoice.*
                from v_invoice
                where 1 = 1 ";

        if ($from_date) {

            $from_date = date('Y-m-d',strtotime(str_replace('/', '-',$from_date)));

            $sql .= " and DATE(create_date) >= '" . $from_date . "' ";

        }

        if ($to_date) {

            $to_date = date('Y-m-d',strtotime(str_replace('/', '-',$to_date)));

            $sql .= " and DATE(create_date) <= '" . $to_date . "' ";

        }

        if ($id_segment) {

            $sql .= " and v_invoice.id_segment = '" . $id_segment . "' ";

        }

        if ($text_segment) {

            $sql .= " and v_invoice.name_price_book = '" . $text_segment . "' ";

        }

        $sql .= " order by create_date desc";

        $data = $con->createCommand($sql)->queryAll();

        return $data;

    }

    //báo cáo doanh thu theo sản phẩm
    public function listProductOfInvoice($search_user,$search_branch,$search_time,$fromtime,$totime, $search_product){
        $data[]="";
        if($search_product){
            foreach ($search_product as $key) {

            }
        }else{
            return -1;
        }
    }
    public function searchProductOfInvoice($search_user,$search_branch,$search_time,$fromtime,$totime, $id_product)
    {
        $p = new VInvoice;
        $q = new CDbCriteria(array(
        'condition'=>'published="true"'
        ));
        $v = new CDbCriteria();
        $v->addCondition('t.status >= 0');
        $time = 0;
        if($search_time) {       // thời gian
            if($search_time == 1) {              // hôm nay
                $time = date('Y-m-d');
                $v->addCondition('DATE(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
            elseif ($search_time == 2) {         // 7 ngày trước
                $time_fisrt = date('Y-m-d',strtotime('monday this week'));
                $time_last = date('Y-m-d',strtotime('sunday this week'));

                $v->addCondition('DATE(create_date) >="'. $time_fisrt .'" AND DATE(create_date) <="'.$time_last.'"');
            }
            elseif($search_time == 3){                               // trong tháng
                $time = date('m',strtotime(date('Y-m-d')));
                $v->addCondition('MONTH(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
            elseif($search_time == 4){
                $time = date('m',strtotime(date('Y-m-d') . ' - 1 month')); //tháng trước
                $v->addCondition('MONTH(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }elseif($search_time == 5){
                $v->addCondition('DATE(create_date) >="'. $fromtime .'" AND DATE(create_date) <="'.$totime.'"');
            }
        }
        if($search_branch) {
            $v->addCondition('id_branch ='. $search_branch);
        }
        if($search_user) {
            $v->addCondition('id_author ='. $search_user);
        }
        if($id_product) {
            $v->addCondition('id_product ='. $id_product);
        }
        $count=count($p->findAll($v));
        $v->order= 'id ASC';
        $q->mergeWith($v);
        $data = $p->findAll($v);
        return $data ;
    }

}
