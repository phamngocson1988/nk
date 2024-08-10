<?php

/**
 * This is the model class for table "cancel_material".
 *
 * The followings are the available columns in table 'cancel_material':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $id_repository
 * @property integer $id_user
 * @property double $sum_amount
 * @property string $create_date
 * @property string $update_date
 * @property string $note
 * @property integer $status
 */
class CancelMaterial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cancel_material';
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
			array('sum_amount', 'numerical'),
			array('code, name', 'length', 'max'=>255),
			array('update_date, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, id_repository, id_user, sum_amount, create_date, update_date, note, status', 'safe', 'on'=>'search'),
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
			'name' => 'Tên Phiếu',
			'id_repository' => 'Kho',
			'id_user' => 'Người lập phiếu',
			'sum_amount' => 'Tổng tiền',
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
		$criteria->compare('sum_amount',$this->sum_amount);
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
	 * @return CancelMaterial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	//status = 1 sử dụng , 2 trả, 3 huỷ
	public function getCodeNumber($status) {
    	$fromdate 	= date("Y-m-01", strtotime("first day of this month"));
    	$todate		= date("Y-m-t", strtotime("last day of this month"));
    	$date 		= date('Y-m');
    	if($status ==1){ 
    		$code 		= 'SD';
    	}elseif($status ==2){
    		$code 		= 'XT';
    	}
    	elseif($status ==3){
    		$code 		= 'XH';
    	}
    	$code 	   .= str_replace(array('-',' ',':'),'', $date);
    	$num 		= CancelMaterial::model()->count(array( 'condition'=>"create_date BETWEEN '".$fromdate."' AND '" . $todate. "' and status = ".$status)) + 1;
    	$codenum 	= str_pad($num, '4' ,'0', STR_PAD_LEFT);
    	$code 	   .= $codenum;
    	return $code;
  	}

	public function createCancelMaterial($data = array(), $dataDetail = array()){

		if (empty($data) || !is_array($data)) {
	      	return array('status' => 'error', 'message' => 'Thông tin hủy kho không tồn tại !');
	    }
	    if (empty($dataDetail) || !is_array($dataDetail)) {
	      	return array('status' => 'error', 'message' => 'Chi tiết hủy kho không tồn tại !');
	    }
	    $cancelMaterial 			= new CancelMaterial();
	    $cancelMaterial->attributes = $data;
	    $cancelMaterial->code 		= $this->getCodeNumber($data['status']);
	    unset($cancelMaterial->create_date);
	    $cancelMaterial->update_date= date('Y-m-d H:i:s');
	    $detailArr 		= array();
	    $detailArrNew 	= array();
	    if ($cancelMaterial->validate()) {
	    	foreach ($dataDetail as $k => $val) {
	   			$cancelMaterialDetail 	= new CancelMaterialDetail();
	   			$id_material 			= explode("-", $val['id_material']);
		        $cancelMaterialDetail->attributes  	= $val;
		        $cancelMaterialDetail->id_material 	= $id_material[0];
		       	if($cancelMaterialDetail->validate()){
		       		$detailArr[] = $cancelMaterialDetail;
		       	}else{
		       		return array('status' => 'fail', 'error-message' => $cancelMaterialDetail->getErrors());
		       	}
		   	}
	    }else{
	    	return array('status' => 'fail', 'error-message' => $cancelMaterial->getErrors());
	    }
	    if($cancelMaterial->save()){
	   		foreach ($detailArr as $key => $v) {
	   			$v->id_material 		= $v['id_material'];
	   			$v->id_cancel_material 	= $cancelMaterial->id;
		        $v->status     	 		= $cancelMaterial->status;
		        $v->update_date 		= date('Y-m-d H:i:s');
		        $v->expiration_date 	= date( "Y-m-d", strtotime( str_replace('/', '-',$v['expiration_date']) ) );
		        $v->save();	     
		        $detailArrNew[] 		= $v->attributes; 
	   		}
	   	}
	   	if($detailArrNew){
	   		foreach ($detailArrNew as $key => $value) {
	   			$materialStock = new MaterialStock();
	   			$materialStock->id_repository 	= $cancelMaterial->id_repository;
	   			$materialStock->id_material 	= $value['id_material'];
	   			$materialStock->qty 			= '-'.$value['qty'];
	   			$materialStock->amount 			= $value['amount'];
	   			$materialStock->expiration_date = $value['expiration_date'];
	   			$materialStock->type 			= '-'; 
	   			if($cancelMaterial->status == 1){ // -1 sử dụng, -2 xuất trả, -3 huỷ, 
	   				$materialStock->status 		= -1; 
	   			}
	   			elseif($cancelMaterial->status == 2){ 
	   				$materialStock->status 		= -2;
	   			}
	   			else if($cancelMaterial->status == 3){
	   				$materialStock->status 		= -3; 
	   			}
	   			$materialStock->save();
	   		}
	   	}
	   	return array('status' 	=> 'successful', 'data' => array(
            'cancelMaterial' 	=> $cancelMaterial->attributes
        ));
	}

	public function getListData($page,$limit,$searchRepository, $searchCode, $time_fisrt, $time_last,$status){
		$start_point = $limit*($page-1);
		$p = new VCancelMaterial;           
	    $q = new CDbCriteria(array(
	    'condition'=>'published="true"'
	    ));
	    $v = new CDbCriteria(); 
	    if($status){
	      	$v->addCondition('t.status='.$status);
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

	public function getListDetail($idCancelMaterial){
		$connection=Yii::app()->db;
        $sql = "SELECT a.`id`,a.`id_cancel_material`, a.`qty`, a.`unit`,a.`status`,a.`expiration_date`, a.`amount`,a.`note`, b.`id` as id_material, b.`name` as name_material, b.`code` as code_material FROM cancel_material_detail a  INNER JOIN cs_material b WHERE a.`id_material` = b.`id` AND a.`status` >=0 AND (id_cancel_material IN(".$idCancelMaterial."))";
        $command = $connection->createCommand($sql);
        $query = $command->queryAll();
		return $query;
	}
}
