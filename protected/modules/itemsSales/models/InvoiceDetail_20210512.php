<?php

/**
 * This is the model class for table "invoice_detail".
 *
 * The followings are the available columns in table 'invoice_detail':
 * @property integer $id
 * @property integer $id_invoice
 * @property integer $id_quotation_item
 * @property integer $id_service
 * @property string $code_service
 * @property string $description
 * @property integer $id_user
 * @property integer $id_author
 * @property string $create_date
 * @property string $confirm_date
 * @property double $unit_price
 * @property double $amount_view
 * @property double $amount
 * @property string $teeth
 * @property integer $qty
 * @property double $tax
 * @property double $percent_decrease
 * @property integer $status
 * @property integer $flag_price
 * @property integer $percent_change
 */
class InvoiceDetail extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'invoice_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_invoice, id_quotation_item, id_service, id_user, id_author, qty, status, flag_price', 'numerical', 'integerOnly'=>true),
            array('unit_price, amount_view, amount, tax, percent_decrease, percent_change', 'numerical'),
            array('code_service', 'length', 'max'=>100),
            array('description, teeth', 'length', 'max'=>255),
            array('confirm_date, note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_invoice, id_quotation_item, id_service, code_service, description, id_user, id_author, create_date, confirm_date, unit_price, amount_view, amount, teeth, qty, tax, percent_decrease, status, flag_price, note', 'safe', 'on'=>'search'),
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
            'id_quotation_item' => 'Id Quotation Item',
            'id_service' => 'Id Service',
            'code_service' => 'Code Service',
            'description' => 'Description',
            'id_user' => 'Id User',
            'id_author' => 'Id Author',
            'create_date' => 'Create Date',
            'confirm_date' => 'Confirm Date',
            'unit_price' => 'Unit Price',
            'amount_view' => 'Amount View',
            'amount' => 'Amount',
            'teeth' => 'Teeth',
            'qty' => 'Qty',
            'tax' => 'Tax',
            'percent_decrease' => 'Percent Decrease',
            'status' => 'Status',
            'flag_price' => 'Flag Price',
            'note'      => 'Note',
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
        $criteria->compare('id_quotation_item',$this->id_quotation_item);
        $criteria->compare('id_service',$this->id_service);
        $criteria->compare('code_service',$this->code_service,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('id_user',$this->id_user);
        $criteria->compare('id_author',$this->id_author);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('confirm_date',$this->confirm_date,true);
        $criteria->compare('unit_price',$this->unit_price);
        $criteria->compare('amount_view',$this->amount_view);
        $criteria->compare('amount',$this->amount);
        $criteria->compare('teeth',$this->teeth,true);
        $criteria->compare('qty',$this->qty);
        $criteria->compare('tax',$this->tax);
        $criteria->compare('percent_decrease',$this->percent_decrease);
        $criteria->compare('status',$this->status);
        $criteria->compare('flag_price',$this->flag_price);
        $criteria->compare('note',$this->note,true);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InvoiceDetail the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function showDetailDieuTri($fromtime,$totime,$dentist,$dichvu){
                $con = Yii::app()->db;
        $sql="SELECT `invoice`.`code`,`id_invoice`,`id_service`,`customer`.`fullname`,`id_user`,`cs_service`.`id_service_type`,DATE(`invoice`.`create_date`) AS `create_date`,`invoice_detail`.`amount`,`cs_service`.`code` AS code_service,`invoice_detail`.`teeth` FROM `invoice` INNER JOIN `invoice_detail` ON `invoice_detail`.`id_invoice` = `invoice`.`id` INNER JOIN `cs_service` ON `invoice_detail`.`id_service` = `cs_service`.`id`
INNER JOIN `cs_service_type` ON `cs_service`.`id_service_type` = `cs_service_type`.id
INNER JOIN `customer` ON `customer`.`id` = `invoice`.id_customer
        WHERE `invoice_detail`.`id_user` IN (".$dentist.")
        AND `invoice_detail`.`id_service` IN (".$dichvu.")
        AND `invoice`.`create_date` BETWEEN '".$fromtime." 00:00:00' AND '".$totime." 23:59:59' AND `confirm` = 1 ORDER BY `id_service` ASC";
        $list = $con->createCommand($sql)->queryAll();

        return $list;
    }

    public function showDetailDieuTriCSKH($create_date) {
        $con = Yii::app()->db;
        $sql="SELECT `invoice`.`code`,`id_customer`,`id_invoice`,`id_service`,`customer`.`fullname`, `invoice_detail`.`id_user`,`cs_service`.`id_service_type`,DATE(`invoice`.`create_date`) AS `create_date`,`invoice_detail`.`amount`,GROUP_CONCAT(`cs_service`.`code`) AS code_service,`invoice_detail`.`teeth`, `customer`.`code_number`, GROUP_CONCAT(`cs_service`.`name`) AS `treatment`, GROUP_CONCAT(`gp_users`.`name`) AS `treatment_doctor` 
        FROM `invoice` INNER JOIN `invoice_detail` ON `invoice_detail`.`id_invoice` = `invoice`.`id` INNER JOIN `cs_service` ON `invoice_detail`.`id_service` = `cs_service`.`id`
INNER JOIN `cs_service_type` ON `cs_service`.`id_service_type` = `cs_service_type`.id
INNER JOIN `customer` ON `customer`.`id` = `invoice`.id_customer
INNER JOIN `gp_users` ON `invoice_detail`.`id_user` = `gp_users`.`id` 
        WHERE DATE(`invoice`.`create_date`) = '".$create_date."' AND `confirm` = 1 GROUP BY `id_customer` ORDER BY `invoice`.id_customer ASC";
        $list = $con->createCommand($sql)->queryAll();

        return $list;
    }

    public function showDieuTri($fromtime,$totime,$dentist){

        $con = Yii::app()->db;
        $sql="SELECT `cs_service_type`.`id`,COUNT(`cs_service_type`.id) AS soluong,SUM(`invoice_detail`.`amount`) AS tong, SUM(`invoice_detail`.`amount`)/COUNT(`cs_service_type`.id) AS trungbinh FROM `invoice`
        INNER JOIN `invoice_detail` ON `invoice_detail`.`id_invoice` = `invoice`.`id`
        INNER JOIN `cs_service` ON `invoice_detail`.`id_service` = `cs_service`.`id`
        INNER JOIN `cs_service_type` ON `cs_service`.`id_service_type` = `cs_service_type`.id
        WHERE `invoice_detail`.`id_user` IN (".$dentist.")
        AND `invoice_detail`.`create_date` BETWEEN '".$fromtime." 00:00:00' AND '".$totime." 23:59:59' AND `confirm` = 1 GROUP BY `cs_service_type`.id";
        $list = $con->createCommand($sql)->queryAll();
        return $list;
    }

    public function ShowRevenue($fromtime,$totime,$dentist,$option = ""){
        $con = Yii::app()->db;
        $sql="SELECT `invoice`.`code`,`id_invoice`,`transaction_invoice`.`id_service`,`customer`.`fullname`,`transaction_invoice`.`description`,`id_user`,`cs_service`.`id_service_type` AS id,`transaction_invoice`.`create_date`,`transaction_invoice`.`amount`,`transaction_invoice`.`debt`,`cs_service`.`code` AS code_service,`teeth` FROM `transaction_invoice`
        INNER JOIN `cs_service` ON `cs_service`.`id` = `transaction_invoice`.`id_service`
        INNER JOIN `invoice` ON `invoice`.`id` = `transaction_invoice`.`id_invoice`
        INNER JOIN `customer` ON `customer`.`id` = `transaction_invoice`.`id_customer`
        WHERE `id_user` IN (".$dentist.")
        AND `transaction_invoice`.`debt` in (".$option.")
        AND `transaction_invoice`.`create_date` BETWEEN '".$fromtime." 00:00:00' AND '".$totime." 23:59:59' ORDER BY `id_service` ASC";
        $list = $con->createCommand($sql)->queryAll();
        return $list;
    }

    #region --- SHOW REVENUE 1
    public function ShowRevenue1($fromtime, $totime, $dentist, $option = "") {
        $con = Yii::app()->db;
        $sql = "SELECT `cs_service_type`.`id` AS id_service_type, cs_service_type.name AS name, sum(transaction_invoice.amount) AS sumAmount FROM transaction_invoice
        INNER JOIN `cs_service` ON `cs_service`.`id` = `transaction_invoice`.`id_service`
        INNER JOIN `cs_service_type` ON `cs_service_type`.`id` = `cs_service`.`id_service_type` AND cs_service_type.status = 1
        WHERE `transaction_invoice`.`create_date` BETWEEN '$fromtime 00:00:00' AND '$totime 23:59:59' AND `id_user` IN ($dentist) AND `transaction_invoice`.`debt` in ($option)
        GROUP BY id_service_type
        ORDER BY `id_service_type` ASC";

        $list = $con->createCommand($sql)->queryAll();
        return $list;
    }
    #endregion

    #region --- GET SUM REVENUE PROMROTION
    public function getSumPromotion($fromtime, $totime, $dentist, $option = "") {
        $con = Yii::app()->db;
        $sql = "SELECT sum(transaction_invoice.amount) AS sumAmount FROM transaction_invoice
        WHERE `transaction_invoice`.`create_date` BETWEEN '$fromtime 00:00:00' AND '$totime 23:59:59' AND `id_user` IN ($dentist) AND `transaction_invoice`.`debt` in (".TransactionInvoice::KhuyenMai.")";

        $list = $con->createCommand($sql)->queryRow();
        return $list;
    }
    #endregion

    #region --- GET SUM REVENUE
    public function getSumRevenue($fromtime, $totime, $dentist, $option = "") {
        $con = Yii::app()->db;
        $sql = "SELECT sum(transaction_invoice.amount) AS sumAmount FROM transaction_invoice
        WHERE `transaction_invoice`.`create_date` BETWEEN '$fromtime 00:00:00' AND '$totime 23:59:59' AND `id_user` IN ($dentist) AND `transaction_invoice`.`debt` in ($option)";

        $list = $con->createCommand($sql)->queryRow();
        return $list;
    }
    #endregion

    public function showDetailRevenue($fromtime,$totime,$dentist,$status){
        $con = Yii::app()->db;
        $sql="SELECT `invoice`.`code`,`id_invoice`,`transaction_invoice`.`id_service`,`customer`.`fullname`,`transaction_invoice`.`description`,`id_user`,`cs_service`.`id_service_type` AS id,date(`transaction_invoice`.`create_date`) AS `date`,`transaction_invoice`.`amount`,`transaction_invoice`.`debt`,`cs_service`.`code` AS code_service,`teeth` FROM `transaction_invoice`
        INNER JOIN `cs_service` ON `cs_service`.`id` = `transaction_invoice`.`id_service`
        INNER JOIN `invoice` ON `invoice`.`id` = `transaction_invoice`.`id_invoice`
        INNER JOIN `customer` ON `customer`.`id` = `transaction_invoice`.`id_customer`
        WHERE `id_user` IN (".$dentist.")
        AND `transaction_invoice`.`debt` in (".$status.")
        AND `transaction_invoice`.`create_date` BETWEEN '".$fromtime." 00:00:00' AND '".$totime." 23:59:59' ORDER BY `id_service` ASC";

        $list = $con->createCommand($sql)->queryAll();
        return $list;
    }
    public function showLuong($fromtime,$totime,$dentist){
        $con = Yii::app()->db;
        $sql="SELECT `id_service_type` AS `id`,`amount`,`percent`,`id_user`,`id_service`,`debt` FROM `transaction_invoice`
        INNER JOIN `cs_service` ON `cs_service`.`id` = `transaction_invoice`.`id_service`
        INNER JOIN `invoice` ON `invoice`.`id` = `transaction_invoice`.`id_invoice`
        INNER JOIN `customer` ON `customer`.`id` = `transaction_invoice`.`id_customer`
        WHERE `id_user` IN (".$dentist.")
        AND `transaction_invoice`.`debt` in (0,2,5,6)
        AND `transaction_invoice`.`create_date` BETWEEN '".$fromtime." 00:00:00' AND '".$totime." 23:59:59' ORDER BY `id_service` ASC";
        $list = $con->createCommand($sql)->queryAll();

        return $list;
    }

    public function showDetailLuong($fromtime,$totime,$dentist,$status){
        $con = Yii::app()->db;
        $sql="SELECT `invoice`.`code`,`id_invoice`,`transaction_invoice`.`id_service`,`customer`.`fullname`,`transaction_invoice`.`description`,`id_user`,`cs_service`.`id_service_type`,`transaction_invoice`.`create_date`,`transaction_invoice`.`amount`,`transaction_invoice`.`debt`,`cs_service`.`code` AS code_service,`teeth` FROM `transaction_invoice`
        INNER JOIN `cs_service` ON `cs_service`.`id` = `transaction_invoice`.`id_service`
        INNER JOIN `invoice` ON `invoice`.`id` = `transaction_invoice`.`id_invoice`
        INNER JOIN `customer` ON `customer`.`id` = `transaction_invoice`.`id_customer`
        WHERE `id_user` IN (".$dentist.")
        AND `transaction_invoice`.`debt` in (".$status.")
        AND `transaction_invoice`.`create_date` BETWEEN '".$fromtime." 00:00:00' AND '".$totime." 23:59:59' ORDER BY `id_service` ASC";
        $list = $con->createCommand($sql)->queryAll();
        return $list;
    }

    public function showHoadon($fromtime,$totime,$dentist,$dichvu){

        // $list = Yii::app()->db->createCommand()
        // ->select('id_service, sum(amount) AS amount')
        // ->from('invoice_detail')
        // ->where("create_date BETWEEN '".$fromtime." 00:00:00' AND '".$totime." 23:59:59' and id_service IN (".$dichvu.") AND id_user IN (".$dentist.")")
        // ->group('id_service')
        // ->queryAll();
        $con = Yii::app()->db;
        $sql="SELECT `cs_service_type`.id, SUM(`invoice_detail`.amount) as sum FROM `cs_service`
        INNER JOIN `cs_service_type` ON `cs_service`.`id_service_type` = `cs_service_type`.id
        INNER JOIN `invoice_detail` ON `cs_service`.`id` = `invoice_detail`.`id_service`
        WHERE `invoice_detail`.`id_user` IN (".$dentist.")
        AND `cs_service`.`id_service_type` IN (".$dichvu.")
        AND  `invoice_detail`.`create_date` BETWEEN '".$fromtime." 00:00:00' AND '".$totime." 23:59:59'
        GROUP BY `cs_service_type`.id";
        $list = $con->createCommand($sql)->queryAll();
        return $list;
    }

    public function showGiaodich($fromtime,$totime,$dentist,$dichvu){
        $con = Yii::app()->db;
        $sql="SELECT `cs_service_type`.id,SUM(`invoice_detail`.amount) as amount,SUM(`invoice_detail`.amount*`transaction_invoice`.`percent`/100) AS luong FROM `cs_service`
        INNER JOIN `cs_service_type` ON `cs_service`.`id_service_type` = `cs_service_type`.id
        INNER JOIN `invoice_detail` ON `cs_service`.`id` = `invoice_detail`.`id_service`
        INNER JOIN `transaction_invoice` ON `transaction_invoice`.`id_service` = `cs_service`.id
        WHERE `invoice_detail`.`id_user` IN (".$dentist.")
        AND `cs_service`.`id_service_type` IN (".$dichvu.")
        AND  `invoice_detail`.`create_date` BETWEEN '".$fromtime." 00:00:00' AND '".$totime." 23:59:59'
        GROUP BY `cs_service_type`.id";
        $list = $con->createCommand($sql)->queryAll();
        return $list;
    }
}
