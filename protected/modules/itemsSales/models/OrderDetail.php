<?php

/** 
 * This is the model class for table "order_detail". 
 * 
 * The followings are the available columns in table 'order_detail': 
 * @property integer $id
 * @property integer $id_order
 * @property integer $id_service
 * @property integer $id_product
 * @property integer $id_discount
 * @property integer $id_voucher
 * @property string $description
 * @property integer $id_user
 * @property integer $id_author
 * @property string $create_date
 * @property string $confirm_date
 * @property double $unit_price
 * @property double $amount
 * @property integer $teeth
 * @property integer $qty
 * @property double $tax
 * @property integer $status
 */ 
class OrderDetail extends CActiveRecord
{ 
    /** 
     * @return string the associated database table name 
     */ 
    public function tableName() 
    { 
        return 'order_detail'; 
    } 

    /** 
     * @return array validation rules for model attributes. 
     */ 
    public function rules() 
    { 
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array(
            array('id_order, id_service, id_product, id_discount, id_voucher, id_user, id_author, teeth, qty, status', 'numerical', 'integerOnly'=>true),
            array('unit_price, amount, tax', 'numerical'),
            array('description', 'length', 'max'=>255),
            array('confirm_date', 'safe'),
            // The following rule is used by search(). 
            // @todo Please remove those attributes that should not be searched. 
            array('id, id_order, id_service, id_product, id_discount, id_voucher, description, id_user, id_author, create_date, confirm_date, unit_price, amount, teeth, qty, tax, status', 'safe', 'on'=>'search'),
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
            'id_order' => 'Id Order',
            'id_service' => 'Id Service',
            'id_product' => 'Id Product',
            'id_discount' => 'Id Discount',
            'id_voucher' => 'Id Voucher',
            'description' => 'Description',
            'id_user' => 'Id User',
            'id_author' => 'Id Author',
            'create_date' => 'Create Date',
            'confirm_date' => 'Confirm Date',
            'unit_price' => 'Unit Price',
            'amount' => 'Amount',
            'teeth' => 'Teeth',
            'qty' => 'Qty',
            'tax' => 'Tax',
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
        $criteria->compare('id_order',$this->id_order);
        $criteria->compare('id_service',$this->id_service);
        $criteria->compare('id_product',$this->id_product);
        $criteria->compare('id_discount',$this->id_discount);
        $criteria->compare('id_voucher',$this->id_voucher);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('id_user',$this->id_user);
        $criteria->compare('id_author',$this->id_author);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('confirm_date',$this->confirm_date,true);
        $criteria->compare('unit_price',$this->unit_price);
        $criteria->compare('amount',$this->amount);
        $criteria->compare('teeth',$this->teeth);
        $criteria->compare('qty',$this->qty);
        $criteria->compare('tax',$this->tax);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider($this, array( 
            'criteria'=>$criteria, 
        )); 
    } 

    /** 
     * Returns the static model of the specified AR class. 
     * Please note that you should have this exact method in all your CActiveRecord descendants! 
     * @param string $className active record class name. 
     * @return OrderDetail the static model class 
     */ 
    public static function model($className=__CLASS__) 
    { 
        return parent::model($className); 
    } 
}