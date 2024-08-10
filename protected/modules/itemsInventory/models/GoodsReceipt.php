<?php

/**
 * This is the model class for table "goods_receipt".
 *
 * The followings are the available columns in table 'goods_receipt':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $id_purchase_requisition
 * @property integer $id_user
 * @property integer $id_repository
 * @property string $note
 * @property double $sum_amount
 * @property string $create_date
 * @property string $update_date
 * @property integer $status
 */
class GoodsReceipt extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'goods_receipt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_purchase_requisition, id_user, id_repository, status', 'numerical', 'integerOnly'=>true),
			array('sum_amount', 'numerical'),
			array('code', 'length', 'max'=>50),
			array('name', 'length', 'max'=>255),
			array('note, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, id_purchase_requisition, id_user, id_repository, note, sum_amount, create_date, update_date, status', 'safe', 'on'=>'search'),
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
			'code' => 'Mã phiếu',
			'name' => 'Tên phiếu',
			'id_purchase_requisition' => 'Phiếu đề xuất',
			'id_user' => 'Người lập phiếu',
			'id_repository' => 'Kho',
			'note' => 'Ghi chú',
			'sum_amount' => 'Tổng tiền',
			'create_date' => 'Ngày lập phiếu',
			'update_date' => 'Ngày chỉnh sửa',
			'status' => 'Trạng thái nhập kho ',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('id_purchase_requisition',$this->id_purchase_requisition);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_repository',$this->id_repository);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('sum_amount',$this->sum_amount);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GoodsReceipt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCodeNumber() {
    	$fromdate 	= date("Y-m-01", strtotime("first day of this month"));
    	$todate		= date("Y-m-t", strtotime("last day of this month"));
    	$date 		= date('Y-m');
   	 	$code 		= 'NK';
    	$code 	   .= str_replace(array('-',' ',':'),'', $date);
    	$num 		= GoodsReceipt::model()->count(array( 'condition'=>"create_date BETWEEN '".$fromdate."' AND '" . $todate. "'")) + 1;
    	$codenum 	= str_pad($num, '4' ,'0', STR_PAD_LEFT);
    	$code 	   .= $codenum;
    	return $code;
  	}
	public function createGoodsReceipt($data = array(), $dataDetail = array()){
		if (empty($data) || !is_array($data)) {
	      	return array('status' => 'error', 'message' => 'Thông tin nhập kho không tồn tại!');
	    }
	    if (empty($dataDetail) || !is_array($dataDetail)) {
	      	return array('status' => 'error', 'message' => 'Chi tiết nhập kho không tồn tại!');
	    }
    	$goodsReceipt 				= new GoodsReceipt();
	    $goodsReceipt->attributes 	= $data;
	    $goodsReceipt->code 		= $this->getCodeNumber();
	    unset($goodsReceipt->create_date);
	    $goodsReceipt->update_date 	= date('Y-m-d H:i:s');
	    $detailArr 		= array();
	    $detailArrNew 	= array();
	    if ($goodsReceipt->validate()) {
	    	foreach ($dataDetail as $k => $val) {
	   			$goodsReceiptDetail = new GoodsReceiptDetail();
		        $goodsReceiptDetail->attributes  = $val;
		       	if($goodsReceiptDetail->validate()){
		       		$detailArr[] = $goodsReceiptDetail;
		       	}else{
		       		return array('status' => 'fail', 'error-message' => $goodsReceiptDetail->getErrors());
		       	}
		   	}
	    }else{
	    	return array('status' => 'fail', 'error-message' => $goodsReceipt->getErrors());
	    }
	   	if($goodsReceipt->save()){
	   		foreach ($detailArr as $key => $v) {
	   			$v->id_goods_receipt 	= $goodsReceipt->id;
		        $v->status     	 		= $goodsReceipt->status;
		        $v->update_date 		= date('Y-m-d H:i:s');
		        $v->expiration_date 	= date( "Y-m-d", strtotime( str_replace('/', '-',$v['expiration_date']) ) );
		        $v->save();	     
		        if($v->status == 1){
		        	$detailArrNew[] 	= $v->attributes;
		        }   
	   		}
	   	}
	   	if($goodsReceipt->status ==1 && $detailArrNew){
	   		foreach ($detailArrNew as $key => $value) {
	   			$materialStock = new MaterialStock();
	   			$materialStock->id_repository 	= $goodsReceipt->id_repository;
	   			$materialStock->id_material 	= $value['id_material'];
	   			$materialStock->qty 			= $value['qty'];
	   			$materialStock->amount 			= $value['amount'];
	   			$materialStock->expiration_date = $value['expiration_date'];
	   			$materialStock->type 			= '+';
	   			$materialStock->status 			= 1;
	   			$materialStock->save();
	   		}
	   	}
	   	return array('status' 	=> 'successful', 'data' => array(
            'goodsReceipt' 		=> $goodsReceipt->attributes
        ));
	}

	public function getListGoodsReceipt($page, $limit, $searchRepository, $searchCode, $time_fisrt, $time_last,$searchStatus){

		$start_point = $limit*($page-1);
		$p = new VGoodsReceipt;           
	    $q = new CDbCriteria(array(
	    'condition'=>'published="true"'
	    ));
	    $v = new CDbCriteria(); 
	    if($searchStatus ==='0' ||  $searchStatus >0){
	      	$v->addCondition('t.status='.$searchStatus);
	    }else{
	      	$v->addCondition('t.status >=0');
	    }
	   	if($time_fisrt && $time_last){
	    	$v->addCondition('DATE(create_date) >="'. $time_fisrt .'" AND DATE(create_date) <="'.$time_last.'"');
	    }
	    elseif($time_fisrt){
	      $v->addCondition('DATE(create_date) ="'. $time_fisrt.'"');
	    }
	    elseif($time_last){
	      $v->addCondition('DATE(create_date) ="'. $time_last.'"');
	    }

	    if($searchRepository){
	    	$v->addCondition('id_repository ='. $searchRepository);
	    }
	    if($searchCode) {
	    	$v->addSearchCondition('code', $searchCode, true);
	    }
	    $count 		= count($p->findAll($v));
	    $v->order 	= 'id DESC';
	    $v->limit 	= $limit;
	    $v->offset 	= $start_point;
	    $q->mergeWith($v);
	    $data = $p->findAll($v);
	    return array('count'=>$count,'data'=>$data);
	}

	public function getListDetail($idGoodsReceipt){
		$connection=Yii::app()->db;
        $sql = "SELECT a.`id`,a.`id_goods_receipt`, a.`qty`, a.`unit`,a.`status`,a.`expiration_date`, a.`amount`, a.`sumamount`, b.`id` as id_material, b.`name` as name_material, b.`code` as code_material FROM goods_receipt_detail a  INNER JOIN cs_material b WHERE a.`id_material` = b.`id` AND a.`status` >=0 AND (id_goods_receipt IN(".$idGoodsReceipt."))";
        $command = $connection->createCommand($sql);
        $query = $command->queryAll();
		return $query;
	}

	public function updateGoodsReceipt($data = array(), $dataDetail = array()){
		if (empty($data) || !is_array($data)) {
	      	return array('status' => 'error', 'message' => 'Thông tin nhập kho không tồn tại!');
	    }
	    if (empty($dataDetail) || !is_array($dataDetail)) {
	      	return array('status' => 'error', 'message' => 'Chi tiết nhập kho không tồn tại!');
	    }
	    $id = isset($data['id']) ? $data['id'] : false;
	    if(!$id){
	   		return array('status' => 'error', 'message' => 'Thông tin nhập kho không tồn tại!');
	   	}
	   	$goodsReceipt = GoodsReceipt::model()->findByPk($id);
	   	if(!$goodsReceipt){
	   		return array('status' => 'error', 'message' => 'Thông tin nhập kho không tồn tại!');
	   	}
	   	$goodsReceipt->name     	= $data['name'];
	   	$goodsReceipt->note 		= $data['note'];
	    $goodsReceipt->status   	= $data['status'];
	   	$goodsReceipt->update_date 	= date('Y-m-d H:i:s');
	   	$goodsReceipt->sum_amount 	= $data['sum_amount'];
	   	$detailArr = array();
	   	$detailArrNew = array();
	   	if ($goodsReceipt->validate()) {
	   		foreach ($dataDetail as $k => $val) {
	   			$id_item = $val['id'];
	   			if($id_item){
	                $goodsReceiptDetail = GoodsReceiptDetail::model()->findByPk($id_item);
	                if(!$goodsReceiptDetail){
	                	$goodsReceiptDetail = new GoodsReceiptDetail();
	                    unset($goodsReceiptDetail->create_date);
			   		}
			    }else{
			    	$goodsReceiptDetail = new GoodsReceiptDetail();
		            unset($goodsReceiptDetail->create_date);
			    }
			   	if ($val['status'] == -1) {
                    $goodsReceiptDetail->status = -1;
                } else {
                    $goodsReceiptDetail->attributes = $val;
                    $goodsReceiptDetail->status = $goodsReceipt->status;
                }
		   		if ($goodsReceiptDetail->validate()) {
			   		$detailArr[] 	=  $goodsReceiptDetail;
			   	}else{
		       		return array('status' => 'fail', 'error-message' => $goodsReceiptDetail->getErrors());
		       	}
		   	}
	   	}else{
	    	return array('status' => 'fail', 'error-message' => $goodsReceipt->getErrors());
	    }
	   
	    if($goodsReceipt->save()){
	   		foreach ($detailArr as $key => $v) {
	   			$v->id_goods_receipt 	= $goodsReceipt->id;
		        $v->update_date 		= date('Y-m-d H:i:s');
		        $v->expiration_date 	= date( "Y-m-d", strtotime( str_replace('/', '-',$v['expiration_date']) ) );
		        if($v->status == 1){
		        	$detailArrNew[] 	= $v->attributes;
		        } 
		        $v->save();      
	   		}
	   	}
	   	if($goodsReceipt->status ==1 && $detailArrNew){
	   		foreach ($detailArrNew as $key => $value) {
	   			$materialStock = new MaterialStock();
	   			$materialStock->id_repository 	= $goodsReceipt->id_repository;
	   			$materialStock->id_material 	= $value['id_material'];
	   			$materialStock->qty 			= $value['qty'];
	   			$materialStock->amount 			= $value['amount'];
	   			$materialStock->expiration_date = $value['expiration_date'];
	   			$materialStock->type 			= '+';
	   			$materialStock->status 			= 1;
	   			$materialStock->save();
	   		}
	   	}
	   	return array('status' 	=> 'successful', 'data' => array(
            'goodsReceipt' 		=> $goodsReceipt->attributes
        ));
	}
}
