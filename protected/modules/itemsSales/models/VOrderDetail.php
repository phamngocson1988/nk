<?php

/**
 * This is the model class for table "v_order_detail".
 *
 * The followings are the available columns in table 'v_order_detail':
 * @property integer $id_order
 * @property integer $id_service
 * @property string $services_name
 * @property integer $id_product
 * @property string $product_name
 * @property integer $id_user
 * @property string $user_name
 * @property string $create_date
 * @property string $unit_price
 * @property string $amount
 * @property integer $qty
 * @property string $tax
 * @property integer $status
 */
class VOrderDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_order_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_order, id_service', 'required'),
			array('id_order, id_service, id_product,id_branch, id_user, qty, status', 'numerical', 'integerOnly'=>true),
			array('services_name', 'length', 'max'=>255),
			array('product_name', 'length', 'max'=>765),
			array('user_name', 'length', 'max'=>128),
			array('unit_price, amount, tax', 'length', 'max'=>12),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_order, id_service, services_name, id_product,id_branch, product_name, id_user, user_name, create_date, unit_price, amount, qty, tax, status', 'safe', 'on'=>'search'),
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
			'id_order' => 'Id Order',
			'id_service' => 'Id Service',
			'services_name' => 'Services Name',
			'id_product' => 'Id Product',
			'id_branch' => 'Id Branch',
			'product_name' => 'Product Name',
			'id_user' => 'Id User',
			'user_name' => 'User Name',
			'create_date' => 'Create Date',
			'unit_price' => 'Unit Price',
			'amount' => 'Amount',
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

		$criteria->compare('id_order',$this->id_order);
		$criteria->compare('id_service',$this->id_service);
		$criteria->compare('services_name',$this->services_name,true);
		$criteria->compare('id_product',$this->id_product);
		$criteria->compare('id_branch',$this->id_branch);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('unit_price',$this->unit_price,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VOrderDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchOrderDetail($conditional='')
	{
		$orderDetail = VOrderDetail::model()->findAll(array(
			'select' => '*',
			'condition' => $conditional,
		));

		return $orderDetail;
	}

	public function searchListOrderDetail($search_branch,$search_time,$search_product,$fromtime,$totime,$status)
    {	
        $p = new VOrderDetail;           
        $q = new CDbCriteria(array(
        'condition'=>'published="true"'
        ));
        $v = new CDbCriteria();
        $v->addCondition('t.status >=0');
        $time = 0;

       if($search_time) {       // thời gian
            if($search_time == 1) {              // hôm nay
                $time = date('Y-m-d');
                $v->addCondition('DATE(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
            elseif ($search_time == 2) {         // trong tuần
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
            } elseif($search_time == 5){
            	$v->addCondition('DATE(create_date) >="'. $fromtime .'" AND DATE(create_date) <="'.$totime.'"');
            }
        }

        if($search_branch) {         // văn phòng
             $v->addCondition('id_branch ='. $search_branch);
         }

        if($search_product) {         //sanpham
            $v->addCondition('id_product = '. $search_product);
        }
         if($status) {         //trangthai
            $v->addCondition('status = '. $status);
        }
      	$count=count($p->findAll($v));
        $v->order= 'id DESC';
        $q->mergeWith($v);      
        $data = $p->findAll($v);
        return array('count'=>$count,'data'=>$data);
    }
}
