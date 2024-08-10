<?php

/** 
 * This is the model class for table "invoice_payment". 
 * 
 * The followings are the available columns in table 'invoice_payment': 
 * @property integer $id
 * @property integer $id_invoice
 * @property double $pay_amount
 * @property double $pay_insurance
 * @property string $pay_date
 * @property integer $pay_type
 * @property double $pay_promotion
 */ 
class InvoicePayment extends CActiveRecord
{ 
    /** 
     * @return string the associated database table name 
     */ 
    public function tableName() 
    { 
        return 'invoice_payment'; 
    } 

    /** 
     * @return array validation rules for model attributes. 
     */ 
    public function rules() 
    { 
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array( 
            array('id_invoice, pay_type', 'numerical', 'integerOnly'=>true),
            array('pay_amount, pay_insurance, pay_promotion', 'numerical'),
            array('pay_date', 'safe'),
            // The following rule is used by search(). 
            // @todo Please remove those attributes that should not be searched. 
            array('id, id_invoice, pay_amount, pay_insurance, pay_date, pay_type, pay_promotion', 'safe', 'on'=>'search'), 
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
            'pay_insurance' => 'Pay Insurance',
            'pay_date' => 'Pay Date',
            'pay_type' => 'Pay Type',
            'pay_promotion' => 'Pay Promotion',
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
        $criteria->compare('pay_insurance',$this->pay_insurance);
        $criteria->compare('pay_date',$this->pay_date,true);
        $criteria->compare('pay_type',$this->pay_type);
        $criteria->compare('pay_promotion',$this->pay_promotion);

        return new CActiveDataProvider($this, array( 
            'criteria'=>$criteria, 
        )); 
    } 

    /** 
     * Returns the static model of the specified AR class. 
     * Please note that you should have this exact method in all your CActiveRecord descendants! 
     * @param string $className active record class name. 
     * @return InvoicePayment the static model class 
     */ 
    public static function model($className=__CLASS__) 
    { 
        return parent::model($className); 
    }

	public function searchPaymentDetail($conditional='')
	{
		$orderDetail = InvoicePayment::model()->findAll(array(
			'select' => '*',
			'condition' => $conditional,
		));

		return $orderDetail;
	}
}
