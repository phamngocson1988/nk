<?php

/** 
 * This is the model class for table "order". 
 * 
 * The followings are the available columns in table 'order': 
 * @property integer $id
 * @property string $code
 * @property integer $id_quotation
 * @property integer $id_author
 * @property integer $id_customer
 * @property integer $id_branch
 * @property string $create_date
 * @property string $complete_date
 * @property string $sum_amount
 * @property string $sum_tax
 * @property string $note
 * @property integer $id_invoice
 * @property integer $id_schedule
 * @property integer $status
 */ 
class Order extends CActiveRecord
{ 
    /** 
     * @return string the associated database table name 
     */ 
    public function tableName() 
    { 
        return 'order'; 
    } 

    /** 
     * @return array validation rules for model attributes. 
     */ 
    public function rules() 
    { 
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array( 
            //array('create_date', 'required'),
            array('id_quotation, id_author, id_customer, id_branch, id_group_history, status, payments', 'numerical', 'integerOnly'=>true),
            array('code', 'length', 'max'=>45),
            array('sum_amount, sum_tax', 'length', 'max'=>12),
            array('complete_date, note, id_schedule', 'safe'),
            // The following rule is used by search(). 
            // @todo Please remove those attributes that should not be searched. 
            array('id, code, id_quotation, id_author, id_customer, id_branch, id_group_history, create_date, complete_date, sum_amount, sum_tax,payments, note,  status', 'safe', 'on'=>'search'),
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
            'code' => 'Mã đơn hàng',
            'id_quotation' => 'Mã báo giá',
            'id_author' => 'Người tạo',
            'id_customer' => 'Khách hàng',
            'id_branch' => 'Văn phòng',
            'create_date' => 'Ngày tạo',
            'complete_date' => 'Ngày kết thúc',
            'sum_amount' => 'Tổng tiền',
            'sum_tax' => 'Bao gồm thuế',
            'note' => 'Ghi chú',
            'payments'=>'Hình thức thanh toán',
            'status' => 'Trạng thái',
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
        $criteria->compare('code',$this->code,true);
        $criteria->compare('id_quotation',$this->id_quotation);
        $criteria->compare('id_author',$this->id_author);
        $criteria->compare('id_customer',$this->id_customer);
        $criteria->compare('id_branch',$this->id_branch);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('complete_date',$this->complete_date,true);
        $criteria->compare('sum_amount',$this->sum_amount,true);
        $criteria->compare('sum_tax',$this->sum_tax,true);
        $criteria->compare('note',$this->note,true);
        $criteria->compare('payments',$this->payments,true);
        $criteria->compare('id_schedule',$this->id_schedule);
        $criteria->compare('balance',$this->balance,true);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider($this, array( 
            'criteria'=>$criteria, 
        )); 
    } 

    /** 
     * Returns the static model of the specified AR class. 
     * Please note that you should have this exact method in all your CActiveRecord descendants! 
     * @param string $className active record class name. 
     * @return Order the static model class 
     */ 
    public static function model($className=__CLASS__) 
    { 
        return parent::model($className); 
    } 
	
	//yyyymmdd001
    public function createCodeOrder()
    {
        $date = date('Y-m-d');
        $code = str_replace(array('-',' ',':'),'',substr( $date, 2 ));
        $num = Order::model()->count(array('condition' => 'date(create_date)="'.$date.'"')) + 1;
        $codenum = str_pad($num, '3' ,'0', STR_PAD_LEFT);
        $code .= $codenum;
        return $code;
    }

    public function shoppingCart($cart,$note,$name,$phone,$email,$address,$sumTotalCart,$id_customer){

        if(!$cart){
            return -1;
        }else {
            $order = new Order;
            $order->code            = Order::model()->createCodeOrder();
            $order->note            = $note;
            $order->sum_amount      = $sumTotalCart;
            $order->id_customer     = $id_customer;
            $order->status = 1;
            if($order->save(false)){
                $order_id   = $order->id;
                $order_code = $order->code;
                $customer_order = new OrderRecipient;
                $customer_order->id_order           = $order_id;
                $customer_order->id_customer        = $id_customer;
                $customer_order->name_recipient     = $_POST['name'];
                $customer_order->phone_recipient    = $_POST['phone'];
                $customer_order->email_recipient    = $_POST['email'];
                $customer_order->address_recipient  = $_POST['address'];
                $customer_order->save();

                if($cart && count($cart)>0)
                {
                    foreach($cart as $item)
                    {
                        $order_detail = new OrderDetail;
                        $order_detail->id_order     = $order_id;
                        $order_detail->id_product   = $item['id'];
                        $order_detail->qty          = $item['qty'];
                        $order_detail->unit_price   = $item['price'];
                        $order_detail->amount       = $item['amount'];
                        $order_detail->status = 1;
                        $order_detail->save(false);
                    }
                }
                echo $order_code;
            }
        }
    }
}