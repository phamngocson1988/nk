<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property integer $id_product_line
 * @property string $name
 * @property string $description
 * @property double $price
 * @property double $stock
 * @property double $discount
 * @property string $unit
 * @property string $createdate
 * @property string $postdate
 * @property integer $status_product
 * @property integer $status_hiden
 * @property string $instruction
 * @property string $code
 * @property double $cost_price
 * @property integer $point_donate
 * @property integer $point_exchange
 * @property string $tax
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product_line, name, price', 'required'),
			array('id_product_line, status_product, status_hiden, point_donate, point_exchange', 'numerical', 'integerOnly'=>true),
			array('price, stock, discount, cost_price', 'numerical'),
			array('name, name_en, unit', 'length', 'max'=>765),
			array('code', 'length', 'max'=>25),
			array('tax', 'length', 'max'=>12),
			array('description,description_en, createdate, postdate, instruction,instruction_en', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_product_line, name,name_en, description,description_en, price, stock, discount, unit, createdate, postdate, status_product, status_hiden, instruction,instruction_en, code, cost_price, point_donate, point_exchange, tax', 'safe', 'on'=>'search'),
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
			'rel_line' => array(self::BELONGS_TO,'ProductLine','id_product_line'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_product_line' => 'Id Product Line',
			'name' => 'Name',
			'name_en'=>'Name EN',
			'description' => 'Description',
			'description_en' => 'Description EN',
			'price' => 'Price',
			'stock' => 'Stock',
			'discount' => 'Discount',
			'unit' => 'Unit',
			'createdate' => 'Createdate',
			'postdate' => 'Postdate',
			'status_product' => 'Status Product',
			'status_hiden' => 'Status Hiden',
			'instruction' => 'Instruction',
			'instruction_en' => 'Instruction EN',
			'code' => 'Code',
			'cost_price' => 'Cost Price',
			'point_donate' => 'Point Donate',
			'point_exchange' => 'Point Exchange',
			'tax' => 'Tax',
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
		$criteria->compare('id_product_line',$this->id_product_line);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name',$this->name_en,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_en',$this->description_en,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('status_product',$this->status_product);
		$criteria->compare('status_hiden',$this->status_hiden);
		$criteria->compare('instruction',$this->instruction,true);
		$criteria->compare('instruction_en',$this->instruction_en,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('cost_price',$this->cost_price);
		$criteria->compare('point_donate',$this->point_donate);
		$criteria->compare('point_exchange',$this->point_exchange);
		$criteria->compare('tax',$this->tax,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



	public function product_list_pagination($curpage,$id_product_line,$searchProduct)
	{
		$start_point=20*($curpage-1);
		$p = new Product;			
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();	
		$v->addCondition('t.status_product = 1');
		if($id_product_line==0) 
		{
			$v->addSearchCondition('code', $searchProduct, true);
			$v->addSearchCondition('name', $searchProduct, true, 'OR');
		}
		else
		{
			$v->addCondition('t.id_product_line = :id_product_line');
			$v->params = array(':id_product_line' => $id_product_line);
			$v->addSearchCondition('code', $searchProduct, true);
			$v->addSearchCondition('name', $searchProduct, true, 'OR');
		} 
	    $v->order= 'id DESC';
	    $v->limit = 20;
	    $v->offset = $start_point;
	    $q->mergeWith($v);	    
	     
	    return $p->findAll($v);
	}

//add stock product 
	public function addStockProduct($id_product, $stock){

		if(!$id_product){
			return -3;
		}

		$product = Product::model()->findByPk($id_product);
		if($product){

			$stock_old = $product->stock;

			$product->stock = $stock + $stock_old;
			if($product->save()){
				return 3;
			}
		}
	}
	//update stock product
	public function updateStockProduct($id_product, $stock){

		if(!$id_product){
			return -3;
		}

		$product = Product::model()->findByPk($id_product);
		if($product){

			$stock_old = $product->stock;

			$product->stock = $stock_old - $stock ;
			if($product->save()){
				return 3;
			}
		}
	}
	
	// check san pham het han
	public function checkProductExpired($id_product, $id_branch){ 
		if (!$id_product) {
			return -2;
		}
		$to_date = date('Y-m-d');
		$q = new ProductInventoryIncrease;
        $v  = new CDbCriteria();
        $v->addCondition('stock > 0');
        $v->addCondition('id_product = ' . $id_product);
        $v->addCondition('id_branch = ' . $id_branch);
        $v->addCondition('DATE(expiry_date) <= :expiry_date');
        $v->params = array(':expiry_date' => $to_date);
        $data = $q->findAll($v);

        if($data){
        	$sum_stock = 0;
        	foreach ($data as $key => $value) {
        		$sum_stock += $value['stock']; 
        	}

        	return $sum_stock;

        }else
        return 1;
	}
//update stock Product Increase
	public function updateStockProductIncrease( $id_product, $available){ 

		$product_increase = ProductInventoryIncrease::model()->findAllByAttributes(array('id_product'=>$id_product), array('order'=>'expiry_date ASC'),array('condition' => 'status > :status','params' => array( ':status' => 0)));
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

//cap nhat stock product khi order complete
	public function updateStockOrder($id_order,$status,$id_branch)
	{
		if($status == 3){
			$order_detail_pr = OrderDetail::model()->findAllByAttributes(array('id_order'=>$id_order));
			foreach ($order_detail_pr as $key => $value) {
				$id_product = $value['id_product'];
				if($id_product){
					$decrease = new ProductInventoryDecrease;
					$decrease->id_branch = $id_branch;
					$decrease->id_product =$id_product;
					$decrease->available  =  $value['qty'];
					$decrease->status  =  5;
					if($decrease->insert()){
						$product = Product::model()->findByPk($id_product);
						$stock_old = $product['stock'];
						$product->stock = ($product['stock'] - $value['qty']);
						$product->save();
						$updateStockProductIncrease = Product::model()->updateStockProductIncrease($id_product, $value['qty']);

					}
					else{
						return -1;
					}
				}else{ return - 2;}
			}
		}
	}
	//search product website
	public function search_product_web($curpage,$type,$id_product_line)
	{
		$start_point=12*($curpage-1);
		$p = new Product;			
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();	
		$v->addCondition('t.status_product >= 0');
		if($id_product_line){

			$v->addCondition('t.id_product_line = :id_product_line');
			$v->params = array(':id_product_line' => $id_product_line);
		}
		if($type == 2){
	   	 $v->order= 'price DESC';
	    }
	    if($type == 3){
	   	 $v->order= 'price ASC';
	    }
	    if($type == 1){
	   	 $v->order= 'id ASC';
	    }
	    $v->limit = 12;
	    $v->offset = $start_point;
	    $q->mergeWith($v);	    
	     
	    return $p->findAll($v);
	}

	public function productSort($product_line, $idSP)
	{
	    $con = Yii::app()->db;
	    $sql = " SELECT c.id, c.name,c.name_en, c.price, d.name_upload,d.url_action from product_type a JOIN product_line b ON a.id = b.id_product_type JOIN product c ON b.id=c.id_product_line JOIN product_image d ON c.id = d.id_product where b.id = $product_line and c.id<>$idSP GROUP  BY c.id";
	    $sort = $con->createCommand($sql)->queryAll();
	    return $sort;
	}
}
