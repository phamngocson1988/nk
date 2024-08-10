<?php

/**
 * This is the model class for table "product_inventory_increase".
 *
 * The followings are the available columns in table 'product_inventory_increase':
 * @property integer $id
 * @property integer $id_product
 * @property integer $id_branch
 * @property integer $available
 * @property string $expiry_date
 * @property integer $stock
 * @property integer $status
 */
class ProductInventoryIncrease extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_inventory_increase';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, id_branch, available, status', 'required'),
			array('id_product, id_branch, available, stock, status', 'numerical', 'integerOnly'=>true),
			array('expiry_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_product, id_branch, available, expiry_date, stock, status', 'safe', 'on'=>'search'),
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
			'id_product' => 'Id Product',
			'id_branch' => 'Id Branch',
			'available' => 'Available',
			'expiry_date' => 'Expiry Date',
			'stock' => 'Stock',
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
		$criteria->compare('id_product',$this->id_product);
		$criteria->compare('id_branch',$this->id_branch);
		$criteria->compare('available',$this->available);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductInventoryIncrease the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function checkProductExpired($id_product){ // check san pham het han
		if (!$id_product) {
			return -2;
		}
		$to_date = date('Y-m-d');
		$q = new ProductInventoryIncrease;
        $v  = new CDbCriteria();
        $v->addCondition('stock >0');
        $v->addCondition('id_product = ' . $id_product);
        $v->addCondition('expiry_date >= ' . $to_date);
        $data = $q->findAll($v);

        if($data){
        	$sum_stock = 0;
        	foreach ($data as $key => $value) {
        		$sum_stock += $value['stock']; 
        	}

        	return $sum_stock;

        }else
        return -3;
	}

	public function updateStockProductIncrease( $id_product, $available){

		$product_increase = ProductInventoryIncrease::model()->findAllByAttributes(array('id_product'=>$id_product), array('order'=>'expiry_date ASC'));

		foreach($product_increase as $key => $value){
		 	$stock = $value->stock;
		 	$available = $available - $stock;
		 	if($available>=0){
		 		$value->stock = 0;
		 		$value->save();
		 		if($available==0){
		 			break;
		 		}
		 	}else{
		 		$available = $available *(-1);
		 		$value->stock =$available;
		 		$value->save();
		 	}

		 	
		}
	}
}
