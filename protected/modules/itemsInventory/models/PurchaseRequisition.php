<?php

/**
 * This is the model class for table "purchase_requisition".
 *
 * The followings are the available columns in table 'purchase_requisition':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $id_repository
 * @property integer $id_user
 * @property string $create_date
 * @property string $update_date
 * @property string $note
 * @property integer $status
 */
class PurchaseRequisition extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchase_requisition';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_repository, id_user, status', 'numerical', 'integerOnly'=>true),
			array('code, name', 'length', 'max'=>255),
			array('create_date, update_date, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, id_repository, id_user, create_date, update_date, note, status', 'safe', 'on'=>'search'),
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
			'code' => 'Mã phiếu đề xuất',
			'name' => 'Tên phiếu đề xuất',
			'id_repository' => 'Kho đề xuất',
			'id_user' => 'Người lập phiếu',
			'create_date' => 'Ngày lập phiếu',
			'update_date' => 'Ngày chỉnh sửa',
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
		$criteria->compare('id_repository',$this->id_repository);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
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
	 * @return PurchaseRequisition the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCodeNumber() {
    $fromdate 	= date("Y-m-01", strtotime("first day of this month"));
    $todate		= date("Y-m-t", strtotime("last day of this month"));
    $date 		= date('Y-m');
    $code 		= 'PDX';
    $code 	   .= str_replace(array('-',' ',':'),'', $date);
    $num 		= PurchaseRequisition::model()->count(array( 'condition'=>"create_date BETWEEN '".$fromdate."' AND '" . $todate. "'")) + 1;
    $codenum 	= str_pad($num, '4' ,'0', STR_PAD_LEFT);
    $code 	   .= $codenum;
    return $code;
  }

	public function createPurchaseRequisition($data = array(), $dataDetail = array()){
    if (empty($data) || !is_array($data)) {
      return array('status' => 'error', 'message' => 'Thông tin phiếu đề xuất không tồn tại !');
    }
    if (empty($dataDetail) || !is_array($dataDetail)) {
      return array('status' => 'error', 'message' => 'Chi tiết phiếu đề xuất không tồn tại!');
    }
    $purchaseRequisition 				      = new PurchaseRequisition();
    $purchaseRequisition->attributes 	= $data;
    $purchaseRequisition->code 			  = $this->getCodeNumber();
    $purchaseRequisition->update_date  = date('Y-m-d H:i:s');
    unset($purchaseRequisition->create_date);
   	if ($purchaseRequisition->validate() && $purchaseRequisition->save()) {
   		foreach ($dataDetail as $k => $val) {
   			$purchaseRequisitionDetail 							= new PurchaseRequisitionDetail();
        $purchaseRequisitionDetail->attributes  = $val;
        $purchaseRequisitionDetail->id_purchase_requisition = $purchaseRequisition->id;
        $purchaseRequisitionDetail->status      = $purchaseRequisition->status;
        $purchaseRequisitionDetail->update_date = date('Y-m-d H:i:s');
       	$purchaseRequisitionDetail->save();
   		}
   		return array('status' => 'successful', 'data' => array(
        'purchaseRequisition' 		=> $purchaseRequisition->attributes
      ));
   	}else {
      return array('status' => 'error', 'message' => $quote->getErrors());
    }
	}

	public function updatePurchaseRequisition($data = array(), $dataDetail = array()){
    if (empty($data) || !is_array($data)) {
      return array('status' => 'error', 'message' => 'Thông tin phiếu đề xuất không tồn tại!');
    }

    if (empty($dataDetail) || !is_array($dataDetail)) {
      return array('status' => 'error', 'message' => 'Chi tiết phiếu đề xuất không tồn tại !');
    }
   	$id = isset($data['id']) ? $data['id'] : false;
   	if(!$id){
   		return array('status' => 'error', 'message' => 'Thông tin phiếu đề xuất không tồn tại!');
   	}
   	$infoItem = PurchaseRequisition::model()->findByPk($id);
   	if(!$infoItem){
   		return array('status' => 'error', 'message' => 'Thông tin phiếu đề xuất không tồn tại!');
   	}
    $infoItem->name     = $data['name'];
   	$infoItem->note 		= $data['note'];
    $infoItem->status   = $data['status'];
   	$infoItem->update_date 	= date('Y-m-d H:i:s');
   	if ($infoItem->validate() && $infoItem->save()) {
   		foreach ($dataDetail as $k => $val) {
   			if ($val['id']) {
   				$id_item = $val['id'];
   				$infoDetail = PurchaseRequisitionDetail::model()->findByPk($id_item);
   			}else {
          $infoDetail = new PurchaseRequisitionDetail();
        }
        $infoDetail->attributes 	= $val;
        $infoDetail->id_purchase_requisition 	= $id;
        $infoDetail->update_date  = date('Y-m-d H:i:s');
        $infoDetail->save();
   		}
   		return array('status' => 'successful', 'data' => array(
        'purchaseRequisition' 		=> $infoItem->attributes
      ));
   	}else {
      return array('status' => 'error', 'message' => $infoItem->getErrors());
    }
	}

	public function getListPurchaseRequisition($page, $limit, $searchRepository, $searchCode, $time_fisrt, $time_last,$searchStatus){
		$start_point = $limit*($page-1);
		$p = new VPurchaseRequisition;           
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

  public function getTimeSearch($type,$fromtime, $totime){
    $time_fisrt = '';
    $time_last  = '';
    if($type == 1) {// hôm nay
      $time_fisrt   = date('Y-m-d');
      $time_last    = date('Y-m-d');
    }elseif ($type == 2) {//trong tuần
      $time_fisrt = date('Y-m-d',strtotime('monday this week'));
      $time_last = date('Y-m-d',strtotime('sunday this week')); 
    }
    elseif($type == 3){// trong tháng 
      $time_fisrt = date("Y-m-01", strtotime("first day of this month"));
      $time_last  = date("Y-m-t", strtotime("last day of this month"));
    }
    elseif($type == 4){// tháng trước 
      $time_fisrt = date("Y-m-d", strtotime('first day of last month'));
      $time_last  = date("Y-m-d", strtotime('last day of last month'));
    }elseif($type == 5){// chọn thời gian
      $time_fisrt = $fromtime;
      $time_last  = $totime;
    }
   

    return array('time_fisrt'=>$time_fisrt,'time_last'=>$time_last);
  }
}
