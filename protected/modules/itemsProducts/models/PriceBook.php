<?php

/**
 * This is the model class for table "price_book".
 *
 * The followings are the available columns in table 'price_book':
 * @property integer $id
 * @property string $name
 * @property integer $id_segment
 * @property integer $percent_discount
 * @property integer $percent_doctor
 * @property string $currency_code
 * @property string $start_time
 * @property string $end_time
 * @property string $createdate
 * @property integer $effect
 * @property integer $status
 */
class PriceBook extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'price_book';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, id_segment, percent_discount, percent_doctor, currency_code, effect', 'required'),
			array('id_segment, percent_discount, percent_doctor, effect, status', 'numerical', 'integerOnly'=>true),
			array('name, currency_code', 'length', 'max'=>255),
			array('start_time, end_time, createdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, id_segment, percent_discount, percent_doctor, currency_code, start_time, end_time, createdate, effect, status', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'id_segment' => 'Id Segment',
			'percent_discount' => 'Percent Discount',
			'percent_doctor' => 'Percent Doctor',
			'currency_code' => 'Currency Code',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'createdate' => 'Createdate',
			'effect' => 'Effect',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('id_segment',$this->id_segment);
		$criteria->compare('percent_discount',$this->percent_discount);
		$criteria->compare('percent_doctor',$this->percent_doctor);
		$criteria->compare('currency_code',$this->currency_code,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('effect',$this->effect);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PriceBook the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("and", "to", "of", "das", "dos", "I", "II", "III", "IV", "V", "VI"))
	{    
		$string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
		foreach ($delimiters as $dlnr => $delimiter) {
			$words = explode($delimiter, $string);
			$newwords = array();
			foreach ($words as $wordnr => $word) {
				if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
	                // check exceptions list for any words that should be in upper case
					$word = mb_strtoupper($word, "UTF-8");
				} elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
	                // check exceptions list for any words that should be in upper case
					$word = mb_strtolower($word, "UTF-8");
				} elseif (!in_array($word, $exceptions)) {
	                // convert to uppercase (non-utf8 only)
					$word = ucfirst($word);
				}
				array_push($newwords, $word);
			}
			$string = join($delimiter, $newwords);
		}
		return $string;
	}		

	public function searchPriceBook($and_conditions='',$or_conditions='',$additional='', $lpp='10', $cur_page='1')
	{
		$lpp_org = $lpp;

		$con = Yii::app()->db;

		$sql = "select count(*) from price_book where 1 = 1 ";

		if($and_conditions and is_array($and_conditions)){
			foreach($and_conditions as $k => $v){
				$sql .= " and $k = '$v'";
			}
		}elseif($and_conditions){
			$sql .= " and $and_conditions";
		}

		if($or_conditions and is_array($or_conditions)){
			foreach($or_conditions as $k => $v){
				$sql .= " or $k = '$v'";
			}
		}elseif($or_conditions){
			$sql .= " or $or_conditions";
		}

		if($additional){
			$sql .= " $additional";
		}

		$num_row = $con->createCommand($sql)->queryScalar();
		

		if(!$num_row) return array('paging'=>array('num_row'=>'0','num_page'=>'1','cur_page'=>$cur_page,'lpp'=>$lpp,'start_num'=>1),'data'=>'');

		if($lpp == 'all'){
			$lpp = $num_row;
		}

		//  Page 1
		if( $num_row < $lpp){
			$cur_page = 1;
			$num_page = 1;
			$lpp      = $num_row;
			$start    = 0 ;

		}else{
			// Tinh so can phan trang
			$num_page =  ceil($num_row/$lpp);

			// So trang hien tai lon hon tong so ph�n trang mot page
			if($cur_page >=  $num_page){
				$cur_page = $num_page;
				$lpp      =  $num_row - ( $num_page - 1 ) * $lpp_org;

			}
			$start = ($cur_page -1) * $lpp_org;
		}

		$sql = "select * from price_book where 1 = 1  ";
		if($and_conditions and is_array($and_conditions)){
			foreach($and_conditions as $k => $v){
				$sql .= " and $k = '$v'";
			}
		}elseif($and_conditions){
			$sql .= " and $and_conditions";
		}

		if($or_conditions and is_array($or_conditions)){
			foreach($or_conditions as $k => $v){
				$sql .= " or $k = '$v'";
			}
		}elseif($or_conditions){
			$sql .= " or $or_conditions";
		}

		if($additional){
			$sql .= " $additional";
		}

		$sql .= " limit ".$start.",".$lpp;


		$data = $con->createCommand($sql)->queryAll();

		return array('paging'=>array('num_row'=>$num_row,'num_page'=>$num_page,'cur_page'=>$cur_page,'lpp'=>$lpp_org,'start_num'=>$start+1),'data'=>$data);
	}	

	public function getListSegment(){
		return Segment::model()->findAll();	
	}

	public function getListService(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('status = 1');
		$criteria->order= 'id DESC';
		return CsService::model()->findAll($criteria);	
	}

	public function getSelectedService($id_pricebook,$id_service){

		if(!$id_pricebook){
			return -1; 
		}

		if(!$id_service){
			return -2; 
		}

		$data = PricebookService::model()->findByAttributes(array('id_pricebook'=>$id_pricebook,'id_service'=>$id_service,'selected'=>1));

		if ($data) {
			return "selected";
		}

		return "";

	}

	public function getListServiceType(){		
		$criteria = new CDbCriteria(); 
		$criteria->addCondition('status = 1');
		$criteria->order= 'id DESC';
		return CsServiceType::model()->findAll($criteria);	
	}

	public function getListServiceUserSelected($id_service){		
		if(!$id_service){
			return -1; 
		}

		return CsServiceUsers::model()->findAllByAttributes(array('id_service'=>$id_service));	
	}

	public function getListDentists(){

		$data   = Yii::app()->db->createCommand()
		->select('*')
		->from('gp_users')
		->where('gp_users.status_hidden=:status_hidden and gp_users.ct_status=:ct_status', array(':status_hidden' => 1, 'ct_status' =>0))
		->order(array('gp_users.stt_status','gp_users.image desc'))
		->queryAll();

		return	$data;
	}

	public function getCount($id_pricebook,$search_service){

		if(!$id_pricebook){
			return -1; 
		}

		$criteria = new CDbCriteria();      
		$criteria->addCondition('status = 1'); 
		$criteria->addCondition('id_pricebook = :id_pricebook');
		$criteria->params = array(':id_pricebook' => $id_pricebook);  
		$criteria2 = new CDbCriteria;    	
		$criteria2->addSearchCondition('code', $search_service, true);
		$criteria2->addSearchCondition('name', $search_service, true, 'OR');	
		$criteria->mergeWith($criteria2);	

		return count(PricebookService::model()->findAll($criteria));	
	}

	public function pageList($curpage,$pages,$id_pricebook)
	{
		$page_list="";	

		if(($curpage!=1)&&($curpage))
		{
			$page_list.='<span onclick="pagination(1,'.$id_pricebook.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Trang đầu'><<</a></span>";
		}
		if(($curpage-1)>0)
		{			
			$page_list.='<span onclick="pagination('.$curpage.'-1,'.$id_pricebook.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Về trang trước'><</a></span>";
		}				
		$vtdau=max($curpage-3,1);
		$vtcuoi=min($curpage+3,$pages);				
		for($i=$vtdau;$i<=$vtcuoi;$i++)
		{
			if($i==$curpage)
			{
				$page_list.='<span style="background:rgba(115, 149, 158, 0.80);"  class="div_trang">'."<b style='color:#FFFFFF;'>".$i."</b></span>";
			}
			else
			{
				$page_list.='<span onclick="pagination('.$i.','.$id_pricebook.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Trang ".$i."'>".$i."</a></span>";
			}
		}
		if(($curpage+1)<=$pages)
		{
			$page_list.='<span onclick="pagination('.$curpage.'+1,'.$id_pricebook.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Đến trang sau'>></a></span>";
			$page_list.='<span onclick="pagination('.$pages.','.$id_pricebook.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Đến trang cuối'>>></a></span>";
		}	

		return $page_list;
	}

	public function listPagination($curpage,$limit,$id_pricebook,$search_service)
	{
		
		$criteria = new CDbCriteria();	
		$criteria->addCondition('status = 1');
		$criteria->addCondition('id_pricebook = :id_pricebook');
		$criteria->params = array(':id_pricebook' => $id_pricebook);	
		$criteria2 = new CDbCriteria;
		$criteria2->addSearchCondition('code', $search_service, true);
		$criteria2->addSearchCondition('name', $search_service, true, 'OR');	
		$criteria->mergeWith($criteria2);	
		$criteria->order = 'id DESC';
		$criteria->limit = $limit;
		$criteria->offset = 20*($curpage-1); 	  
		
		return PricebookService::model()->findAll($criteria);
	}

	public function addNewPriceBook($data = array('name'=>'', 'id_segment'=>'', 'id_service'=>'', 'percent_discount'=>'', 'percent_doctor'=>'', 'currency_code'=>'', 'start_time'=>'', 'end_time'=>'', 'effect'=>'')){

		if(!$data['name']){
			return -1; 
		} 

		if(!$data['id_segment']){
			return -2; 
		}  

		if(!$data['id_service']){
			return -3; 
		} 		

		if(!$data['currency_code']){
			return -4; 
		} 

		if($data['percent_discount'] == ""){
			return -5; 
		} 

		if($data['percent_doctor'] == ""){
			return -6; 
		} 

		$model       = new PriceBook;
		
		$model->attributes       = $data;	

		if($model->validate() && $model->save()){
			$list_service = Yii::app()->db->createCommand()
			->select('cs_service.*')
			->from('cs_service')	            		               
			->queryAll(); 	     	
			
			if ($list_service) {

				foreach ($list_service as $key => $value)
				{				
					$pricebook_service                = new PricebookService;	
					$pricebook_service->id_pricebook  = $model->id;
					$pricebook_service->id_service    = $value['id'];
					$pricebook_service->attributes    = $value;

					if (in_array($value['id'], $data['id_service'])) {

						$pricebook_service->price    = $value['price'] - ($value['price'] * $data['percent_discount'] / 100);

						$pricebook_service->selected = 1; 
						    ////////*********//////////
						$pricebook_service->doctor_salary = $value['price'] * $data['percent_doctor'] / 100;
					}

					elseif (strpos(strtolower($value['name']), 'phim') !== false) {

						$pricebook_service->doctor_salary = 0; 

					} else {
						$pricebook_service->doctor_salary = 0; 
							//$pricebook_service->doctor_salary = $value['price'] * $data['percent_doctor'] / 100;
					}

					$pricebook_service->save();
				}

			}	

			return $model->id;	

			
			

		}else{

			return 0;

		}	   
		
	}



	public function updatePriceBook($data = array('id'=>'', 'name'=>'', 'id_segment'=>'', 'id_service'=>'', 'percent_discount'=>'', 'percent_doctor'=>'', 'currency_code'=>'', 'start_time'=>'', 'end_time'=>'', 'effect'=>'')){

		if(!$data['id']){
			return -1; 
		}

		if(!$data['name']){
			return -2; 
		} 

		if(!$data['id_segment']){
			return -3; 
		}  

		if(!$data['id_service']){
			return -4; 
		} 		

		if(!$data['currency_code']){
			return -5; 
		} 

		if($data['percent_discount'] == ""){
			return -6; 
		} 

		if($data['percent_doctor'] == ""){
			return -7; 
		} 

		
		$model             = PriceBook::model()->findByPk($data['id']);

		$model->attributes = $data;


		if($model->validate() && $model->save()){
			

			$delete = PricebookService::model()->deleteAllByAttributes(array("id_pricebook"=>$model->id));

			if ($delete) {   

				$list_service = Yii::app()->db->createCommand()
				->select('cs_service.*')
				->from('cs_service')	            		               
				->queryAll(); 	     	

				if ($list_service) {

					foreach ($list_service as $key => $value)
					{	 			
						$pricebook_service                = new PricebookService;	
						$pricebook_service->id_pricebook  = $model->id;
						$pricebook_service->id_service    = $value['id'];
						$pricebook_service->attributes    = $value;

						if (in_array($value['id'], $data['id_service'])) {

							$pricebook_service->price    = $value['price'] - ($value['price'] * $data['percent_discount'] / 100);

							$pricebook_service->selected = 1; 
							$pricebook_service->doctor_salary = $value['price'] * $data['percent_doctor'] / 100;
						}
						else if (strpos(strtolower($value['name']), 'phim') !== false) {

							$pricebook_service->doctor_salary = 0; 
						} else {
							$pricebook_service->doctor_salary = 0; 
						}

						$pricebook_service->save();
					}

				}	

			} else {


				return 0;
				
			}
			

			return $model->id;	

		}else{

			return 0;

		}	   
		
	}

	public function deletePriceBook($id_pricebook){

		if(!$id_pricebook){
			return -1; 
		}  

		$model = PriceBook::model()->deleteByPk($id_pricebook);

		if ($model == 1) {	

			PricebookService::model()->deleteAllByAttributes(array("id_pricebook"=>$id_pricebook));
			
			return 1;

		}else{
			return 0;
		} 		  
		
	}

	public function updateService($data = array('id_pricebook_service'=>'', 'price'=>'', 'doctor_salary'=>'', 'tax'=>'', 'priority_pay'=>1, 'flag_price'=>'')){

		if(!$data['id_pricebook_service']){
			return -1; 
		}  		

		$pricebook_service = PricebookService::model()->findByPk($data['id_pricebook_service']);	  
		$pricebook_service->attributes = $data;

		if($pricebook_service->update()){
			return $pricebook_service->code;
		}
	}

	public function deleteService($id_pricebook_service){

		if(!$id_pricebook_service){
			return -1; 
		}  

		return PricebookService::model()->deleteByPk($id_pricebook_service); 		  
		
	}
	public function updateNewPriceBook($data = array('id'=>'', 'id_service'=>'', 'percent_discount'=>'', 'percent_doctor'=>'')){
		if(!$data['id']){
			return -1; 
		}
		if(!$data['id_service']){
			return -4; 
		} 		
		if($data['percent_discount'] == ""){
			return -6; 
		} 
		if($data['percent_doctor'] == ""){
			return -7; 
		}

		$model             = PriceBook::model()->findByPk($data['id']);

		$transaction = Yii::app()->db->beginTransaction();
		try {
			$list_service = Yii::app()->db->createCommand()
			->select('cs_service.*')
			->from('cs_service')	            	               
			->queryAll(); 	     

			if ($list_service) {
				foreach ($list_service as $key => $value){
					if (in_array($value['id'], $data['id_service'])) {
						$pricebook_service = PricebookService::model()->findByAttributes(
							array(
								"id_service"=>$value['id'],
								"id_pricebook"=>$model->id,
							)
						);	
						if ($pricebook_service) {
							$price = $value['price'];
							if ($data['percent_discount']!="0") {
								$price = $value['price'] - ($value['price'] * $data['percent_discount'] / 100);
							}
							$pricebook_service->price    = $price;

							$pricebook_service->selected = 1; 
							$doctor_salary =0;
							if ($data['percent_doctor']!="0") {
								$doctor_salary = $value['price'] * $data['percent_doctor'] / 100;
							}
							$pricebook_service->doctor_salary = $doctor_salary;

							$pricebook_service->update();
						} else {
							// insert service to price book service if not exist
							$priceBookService = new PricebookService;
							$priceBookService->id_pricebook = $model->id;
							$priceBookService->id_service 	= $value['id'];
							$priceBookService->id_service_type = $value['id_service_type'];
							$priceBookService->code 		= $value['code'];
							$priceBookService->name 		= $value['name'];
							$priceBookService->price 		= (100 - $data['percent_discount'])*($value['price'])/100;
							$priceBookService->doctor_salary 	= $data['percent_doctor']*$value['price']/100;
							$priceBookService->description 	= $value['description'];
							$priceBookService->length 		= $value['length'];	
							$priceBookService->createdate 	= date('Y-m-d H:i:s',time());
							$priceBookService->status_hiden = $value['status_hiden'];
							$priceBookService->color 		= $value['color'];
							$priceBookService->point_donate = $value['point_donate'];
							$priceBookService->point_exchange 	= $value['point_exchange'];
							$priceBookService->tax 			= $value['tax'];
							$priceBookService->flag 	= 0;
							$priceBookService->selected 	= 0;
							$priceBookService->priority_pay = $value['priority_pay'];
							$priceBookService->flag_price 	= $value['flag_price'];
							$priceBookService->save();
						}
					}
				}
			}
			$transaction->commit();
			return $model->id;	
		} catch (Exception $e) {
			$transaction->rollBack();
			var_dump("expression");
			echo $e->getMessage();
		}
	}


}
