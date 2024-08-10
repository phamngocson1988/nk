<?php

/**
 * This is the model class for table "stock_transfer".
 *
 * The followings are the available columns in table 'stock_transfer':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $id_user
 * @property integer $id_repository_transfer
 * @property integer $id_repository_receipt
 * @property double $sum_amount
 * @property string $create_date
 * @property string $update_date
 * @property string $confirmation_date
 * @property string $note
 * @property integer $status
 */
class StockTransfer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock_transfer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_repository_transfer, id_repository_receipt, status', 'numerical', 'integerOnly'=>true),
			array('sum_amount', 'numerical'),
			array('code, name', 'length', 'max'=>255),
			array('create_date, update_date, confirmation_date, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, id_user, id_repository_transfer, id_repository_receipt, sum_amount, create_date, update_date, confirmation_date, note, status', 'safe', 'on'=>'search'),
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
			'id_user' => 'Người lập phiếu',
			'id_repository_transfer' => 'Kho chuyển',
			'id_repository_receipt' => 'Kho nhận',
			'sum_amount'	=> 'Tổng tiền',
			'create_date' => 'Ngày lập phiếu',
			'update_date' => 'Ngày chỉnh sửa',
			'confirmation_date' => 'Ngày xác nhận',
			'note' => 'Ghi chú',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_repository_transfer',$this->id_repository_transfer);
		$criteria->compare('id_repository_receipt',$this->id_repository_receipt);
		$criteria->compare('sum_amount',$this->sum_amount);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('confirmation_date',$this->confirmation_date,true);
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
	 * @return StockTransfer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getCodeNumber() {
    	$fromdate 	= date("Y-m-01", strtotime("first day of this month"));
    	$todate		= date("Y-m-t", strtotime("last day of this month"));
    	$date 		= date('Y-m');
   	 	$code 		= 'CK';
    	$code 	   .= str_replace(array('-',' ',':'),'', $date);
    	$num 		= StockTransfer::model()->count(array( 'condition'=>"create_date BETWEEN '".$fromdate."' AND '" . $todate. "'")) + 1;
    	$codenum 	= str_pad($num, '4' ,'0', STR_PAD_LEFT);
    	$code 	   .= $codenum;
    	return $code;
  	}
	public function createStockTransfer($data = array(), $dataDetail = array()){
		if (empty($data) || !is_array($data)) {
	      	return array('status' => 'error', 'message' => 'Thông tin chuyển kho không tồn tại !');
	    }
	    if (empty($dataDetail) || !is_array($dataDetail)) {
	      	return array('status' => 'error', 'message' => 'Chi tiết chuyển kho không tồn tại !');
	    }
	    $stockTransfer 				= new StockTransfer();
	    $stockTransfer->attributes 	= $data;
	    $stockTransfer->code 		= $this->getCodeNumber();
	    $stockTransfer->status 		= 1;
	    unset($stockTransfer->create_date);
	    $stockTransfer->update_date 	= date('Y-m-d H:i:s');
	    $detailArr 		= array();
	    if ($stockTransfer->validate()) {
	    	foreach ($dataDetail as $k => $val) {
	   			$stockTransferDetail = new StockTransferDetail();
		        $stockTransferDetail->attributes  = $val;
		       	if($stockTransferDetail->validate()){
		       		$detailArr[] = $stockTransferDetail;
		       	}else{
		       		return array('status' => 'fail', 'error-message' => $stockTransferDetail->getErrors());
		       	}
		   	}
	    }else{
	    	return array('status' => 'fail', 'error-message' => $stockTransfer->getErrors());
	    }
	    if($stockTransfer->save()){
	   		foreach ($detailArr as $key => $v) {
	   			$v->id_stock_transfer 	= $stockTransfer->id;
		        $v->status     	 		= $stockTransfer->status;
		        $v->update_date 		= date('Y-m-d H:i:s');
		        $v->expiration_date 	= date("Y-m-d", strtotime(str_replace('/', '-',$v['expiration_date'])));
		        $v->save();	     
	   		}
	   	}
	    return array('status' 	=> 'successful', 'data' => array(
            'stockTransfer' 	=> $stockTransfer->attributes
        ));
	}

	public function getListStockTransfer($page,$limit,$searchRepositoryTransfer,$searchRepositoryReceipt, $searchCode, $time_fisrt, $time_last,$searchStatus){
		$start_point = $limit*($page-1);
		$p = new VStockTransfer;           
	    $q = new CDbCriteria(array(
	    'condition'=>'published="true"'
	    ));
	    $v = new CDbCriteria(); 
	    if($searchStatus){
	      	$v->addCondition('t.status='.$searchStatus);
	    }else{
	    	$v->addCondition('t.status >=1');
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
	    if($searchRepositoryTransfer){
	    	$v->addCondition('id_repository_transfer ='. $searchRepositoryTransfer);
	    }
	    if($searchRepositoryReceipt){
	    	$v->addCondition('id_repository_receipt ='. $searchRepositoryReceipt);
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
	public function getListDetail($idStockTransfer){
		$connection=Yii::app()->db;
        $sql = "SELECT a.`id`,a.`id_stock_transfer`, a.`qty`, a.`unit`,a.`status`,a.`expiration_date`, a.`amount`, a.`sum_amount`, b.`id` as id_material, b.`name` as name_material, b.`code` as code_material FROM stock_transfer_detail a  INNER JOIN cs_material b WHERE a.`id_material` = b.`id` AND a.`status` >=0 AND (id_stock_transfer IN(".$idStockTransfer."))";
        $command = $connection->createCommand($sql);
        $query = $command->queryAll();
		return $query;
	}

	public function updateStockTransfer($data = array(), $dataDetail = array()){

		if (empty($data) || !is_array($data)) {
	      	return array('status' => 'error', 'message' => 'Thông tin chuyển kho không tồn tại!');
	    }
	    if (empty($dataDetail) || !is_array($dataDetail)) {
	      	return array('status' => 'error', 'message' => 'Chi tiết chuyển kho không tồn tại!');
	    }
	    $id = isset($data['id']) ? $data['id'] : false;
	    if(!$id){
	   		return array('status' => 'error', 'message' => 'Thông tin chuyển kho không tồn tại!');
	   	}
	   	$stockTransfer = StockTransfer::model()->findByPk($id);
	   	if(!$stockTransfer){
	   		return array('status' => 'error', 'message' => 'Thông tin chuyển kho không tồn tại!');
	   	}
	   	$stockTransfer->name     	= $data['name'];
	   	$stockTransfer->note 		= $data['note'];
	    $stockTransfer->status   	= 1;
	   	$stockTransfer->update_date = date('Y-m-d H:i:s');
	   	$stockTransfer->sum_amount 	= $data['sum_amount'];
	   	$detailArr 		= array();
	   	if ($stockTransfer->validate()) {
	   		foreach ($dataDetail as $k => $val) {
	   			$id_item = $val['id'];
	   			if($id_item){
	                $stockTransferDetail = StockTransferDetail::model()->findByPk($id_item);
	                if(!$stockTransferDetail){
	                	$stockTransferDetail = new StockTransferDetail();
	                    unset($stockTransferDetail->create_date);
			   		}
			    }else{
			    	$stockTransferDetail = new StockTransferDetail();
		            unset($stockTransferDetail->create_date);
			    }
			   	if ($val['status'] == -1) {
                    $stockTransferDetail->status = -1;
                }else {
                    $stockTransferDetail->attributes = $val;
                    $stockTransferDetail->status = $stockTransfer->status;
                }
		   		if ($stockTransferDetail->validate()) {
			   		$detailArr[] 	=  $stockTransferDetail;
			   	}else{
		       		return array('status' => 'fail', 'error-message' => $stockTransferDetail->getErrors());
		       	}
		   	}
	   	}else{
	    	return array('status' => 'fail', 'error-message' => $stockTransfer->getErrors());
	    }
	    if($stockTransfer->save()){
	   		foreach ($detailArr as $key => $v) {
	   			$v->id_stock_transfer 	= $stockTransfer->id;
		        $v->update_date 		= date('Y-m-d H:i:s');
		        $v->expiration_date 	= date( "Y-m-d", strtotime( str_replace('/', '-',$v['expiration_date']) ) );
		        $v->save();      
	   		}
	   	}
	   	return array('status' 	=> 'successful', 'data' => array(
            'goodsReceipt' 		=> $stockTransfer->attributes
        ));
	}

	public function updateStock($id_stock_transfer){
		$stockTransfer 			= StockTransfer::model()->findByPk($id_stock_transfer);
		$stockTransferDetail 	= StockTransfer::model()->getListDetail($id_stock_transfer);
		$dataPlus 	= array();
		$dataMinus 	= array();
		$arrayNew 	= array();
		$strErr 	= '';
		if($stockTransfer && $stockTransferDetail){
			foreach ($stockTransferDetail as $key => $value) {
				if($value['status'] ==2){
					$checkStock = MaterialStock::model()->checkMaterialStock($value['id_material'], $stockTransfer['id_repository_transfer'], $value['expiration_date']);
					if($checkStock >= $value['qty']){
						$dataPlus[$key]['id_repository']	= $stockTransfer['id_repository_receipt'];
						$dataPlus[$key]['id_material'] 		= $value['id_material'];
						$dataPlus[$key]['qty'] 				= $value['qty'];
						$dataPlus[$key]['amount'] 			= $value['amount'];
						$dataPlus[$key]['expiration_date'] 	= $value['expiration_date'];
						$dataPlus[$key]['type'] 			= '+';
						$dataPlus[$key]['status'] 			= 2; //nhận kho

						$dataMinus[$key]['id_repository'] 	= $stockTransfer['id_repository_transfer'];
						$dataMinus[$key]['id_material'] 	= $value['id_material'];
						$dataMinus[$key]['qty'] 			= '-'.$value['qty'];
						$dataMinus[$key]['amount'] 			= $value['amount'];
						$dataMinus[$key]['expiration_date'] = $value['expiration_date'];
						$dataMinus[$key]['type'] 			= '-';
						$dataMinus[$key]['status'] 			= -4; //chuyển kho
					}else{
						$strErr .= $value['name_material'].', ';
						$strErr = substr($strErr, 0, -2);
					}
				}
			}
			if($strErr == ''){
				$arrayNew = array_merge($dataPlus,$dataMinus);
				if($arrayNew){
					foreach ($arrayNew as $key => $v) {

			   			$materialStock = new MaterialStock();
			   			$materialStock->id_repository 	= $v['id_repository'];
			   			$materialStock->id_material 	= $v['id_material'];
			   			$materialStock->qty 			= $v['qty'];
			   			$materialStock->amount 			= $v['amount'];
			   			$materialStock->expiration_date = $v['expiration_date'];
			   			$materialStock->type 			= $v['type'];
			   			$materialStock->status 			= $v['status'];
			   			$materialStock->save();
			   		}
			   		return array('status' => 'successful', 'error-message' =>'Thành công');
				}else{
					return array('status' => 'fail', 'error-message' =>'Thông tin chuyển kho không tồn tại !');
				}
			}else{
				return array('status' => 'fail', 'error-message' =>'Nguyên vật liệu: '.$strErr.' không đủ số lượng trong kho để thực hiện chuyển kho');
			}
		}else{
			return array('status' => 'fail', 'error-message' =>'Thông tin chuyển kho không tồn tại !');
		}
	}
}
