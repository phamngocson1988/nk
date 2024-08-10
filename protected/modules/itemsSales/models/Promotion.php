<?php

/**
 * This is the model class for table "promotion".
 *
 * The followings are the available columns in table 'promotion':
 * @property integer $id
 * @property integer $id_company
 * @property string $name
 * @property string $images
 * @property integer $code
 * @property string $description
 * @property double $sum_amount
 * @property integer $type_price
 * @property double $price
 * @property integer $status
 * @property integer $id_user
 * @property string $start_date
 * @property string $end_date
 */
class Promotion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promotion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_date, end_date', 'required'),
			array('id_company, code, type_price, status, id_user', 'numerical', 'integerOnly'=>true),
			array('sum_amount, price', 'numerical'),
			array('name', 'length', 'max'=>100),
			array('images, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_company, name, images, code, description, sum_amount, type_price, price, status, id_user, start_date, end_date', 'safe', 'on'=>'search'),
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
			'id_company' => 'Id Company',
			'name' => 'Name',
			'images' => 'Images',
			'code' => 'Code',
			'description' => 'Description',
			'sum_amount' => 'Sum Amount',
			'type_price' => 'Type Price',
			'price' => 'Price',
			'status' => 'Status',
			'id_user' => 'Id User',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
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
		$criteria->compare('id_company',$this->id_company);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('code',$this->code);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('sum_amount',$this->sum_amount);
		$criteria->compare('type_price',$this->type_price);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Promotion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function saveImageScaleAndCrop($fileImageUpload,$w='500',$h='280',$imageUploadSource,$imageNameUpload){
    		
            $image = new EasyImage($fileImageUpload);
            $image->scaleAndCrop(500, 280);
           	$img = $image->save($imageUploadSource."lg/".$imageNameUpload);
 
            $image = new EasyImage($fileImageUpload);
            $image->scaleAndCrop(500/2, 280/2);
            $image->save($imageUploadSource."md/".$imageNameUpload);

            $image = new EasyImage($fileImageUpload);
            $image->scaleAndCrop(500/4, 280/4);
            $image->save($imageUploadSource."sm/".$imageNameUpload);

            return true;
    }
    public function geteditdetail($id){
    	$con = Yii::app()->db;
		$sql = "SELECT * from promotion where id =  ".$id;
		$data = $con->createCommand($sql)->queryAll();
    	return $data;
    }
    public function selectpromotion($id){
    	$con = Yii::app()->db;
		$sql = "select * from  promotion_value  where  id_promotion =".$id;
		

    	$data = $con->createCommand($sql)->queryAll();
    	return $data;
    	
    }	
    public function getdelete($id){
    	$con = Yii::app()->db;
		$sql = "DELETE FROM `promotion_value` WHERE `id_promotion` ='62'" ;
    	$data = $con->createCommand($sql);
    	
    	return $data;
    	
    }
    public function getdealuser(){
		$con = Yii::app()->db;
		$sql = "SELECT * from promotion where  and 1 = 1 ";
		$data = $con->createCommand($sql)->queryAll();
    	return $data;
	}
	public function getsegment(){
		$con = Yii::app()->db;
		$sql = "SELECT * FROM `segment` WHERE `status` = 1";
		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}
	public function getbranch(){
		$con = Yii::app()->db;
		$sql = "SELECT * FROM `branch` WHERE `status` = 1";
		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}
	public function getbranchfor($id){
		$result = array();
		$data = PromotionBranch::model()->findAllByAttributes(array("id_promotion"=>$id));
		if($data && count($data) > 0){
			foreach ($data as $key => $value) {
				$result[$value['id_branch']] = $value['id'];
			}
		}
		return $result;

	}
	public function getsegmentfor($id){
		$result = array();
		$data = PromotionSegment::model()->findAllByAttributes(array("id_promotion"=>$id));
		if($data && count($data) > 0){
			foreach ($data as $key => $value) {
				$result[$value['id_segment']] = $value['id'];
			}
		}
		return $result;

	}
	public function getsegmentforeach($id){
		
		$data = PromotionBranch::model()->findAllByAttributes(array("id_promotion"=>$id));
		
		return $data;

	}
	public function getdeletesegment($id){
		
		$data = PromotionBranch::model()->findAllByAttributes(array("id_promotion"=>$id));
		
		return $data;

	}
	/*searchPromotion*/
	 public function searchPromotion($and_conditions='',$or_conditions='',$additional='', $lpp='10', $cur_page='1')
	{

		$lpp_org = $lpp;

		$con = Yii::app()->db;

		$sql = "select count(*) from promotion where 1 = 1  ";

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

		$sql = "select * from promotion where 1 = 1  ";
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
	/*endsearch*/
/*3/1*/
public function searchcrouppromotion($id){
		
		$result = array();
		$data = Promotion::model()->findAllByAttributes(array("id_croup"=>$id));
		return array('data'=>$data);

	
	
	}
public function getget(){
		$con = Yii::app()->db;
		$result = array();
		$sql = "SELECT 
		 * from promotion where 1 = 1 ";
		$data = $con->createCommand($sql)->queryAll();
    	return array('data'=>$data);
	}
	/*Lê Minh Vương*/
	public static function getproduct(){
		$con = Yii::app()->db;
    	$sql = "select * from product where 1 = 1 ";
    	$data = $con->createCommand($sql)->queryAll();
    	return $data ;
	}
	public static function getservice(){
		$con = Yii::app()->db;
    	$sql = "select * from cs_service where 1 =1 ";
    	$data = $con->createCommand($sql)->queryAll();
    	return $data ;
	}
	public static function getpriceservice($id){
		$con = Yii::app()->db;
    	$sql = "select price from cs_service where `id` ='".$id."' ";
    	$data = $con->createCommand($sql)->queryAll();
    	return $data ;
	}
	public static function getpriceproduct($id){
		$con = Yii::app()->db;
    	$sql = "select price from product where `id` ='".$id."' ";
    	$data = $con->createCommand($sql)->queryAll();
    	return $data;
	}
	/*End Lê Minh Vương*/

	// lay danh sach khuyen mai hien hanh
	public function getActivePromotion($id_branch, $id_segment, $lstServices, $lstProducts)
	{
		$now = date('Y-m-d H:i:s');
		$atPro = Promotion::model()->findAll(array(
			'select'	=>	'*',
			'condition' =>	"start_date <= '$now' AND '$now' <= end_date AND status = 2",
		));

		$id_del = array();

		if($atPro){
			// xet dieu kien chi nhanh
			$pro_branch_str = "";
			$id_pro_branch  = array();

			// xet dieu kien nhom khach hang
			$pro_seg_str = "";
			$id_pro_seg = array();

			// xet dieu kien san pham dich vu
			$pro_item_str = "";
			$id_pro_item = array();
			$lstProducts = substr($lstProducts,0,-1);
			$lstServices = substr($lstServices,0,-1);

			foreach ($atPro as $key => $v) {
				$id_promotion = $v['id'];

				// co yeu cau chi nhanh
				if($v['type_branch'] == 1){
					$id_pro_branch[] = $id_promotion;
					$pro_branch_str .= "(id_promotion = $id_promotion AND id_branch = $id_branch) OR ";
				}

				// co yeu cau nhom khach hang
				if($v['type_segment'] == 1){
					$id_pro_seg[] = $id_promotion;
					$pro_seg_str .= "(id_promotion = $id_promotion AND id_segment = $id_segment) OR ";
				}

				// co yeu cau san pham dich vu
				if($v['type_service'] == 1){					
					$id_pro_item[] = $id_promotion;
					$srch_pd = ($lstProducts) ? " id_product IN ($lstProducts)" : "";
					$srch_sv = ($lstServices) ? " id_service IN ($lstServices)" : "";
					$srch = ($srch_pd) ? $srch_pd ." OR ". $srch_sv : $srch_sv;
					if($srch_sv || $srch_pd){
						$pro_item_str .= "(id_promotion = $id_promotion AND ( $srch)) OR ";
					}
				}
			}

			$con = Yii::app()->db;

			// thong tin khuyen mai co dieu kien chi nhanh
			if($pro_branch_str){
				if($id_branch){
					$pro_branch_str = substr($pro_branch_str,0,-3);
					$sqlb = "select id_promotion as id from promotion_branch where $pro_branch_str";
			    	$pro_branch = $con->createCommand($sqlb)->queryAll();
					
					$temp = array_filter($pro_branch, function($v) use (&$id_pro_branch){
						$key = array_search($v['id'],$id_pro_branch);
						unset($id_pro_branch[$key]);
						return true;
					});
				}

				$id_del = array_merge($id_del, $id_pro_branch);
			}

			// thong tin khuyen mai co dieu kien nhom khach hang
			if($pro_seg_str){
				if($id_segment) {
					$pro_seg_str = substr($pro_seg_str,0,-3);
			    	$sqls = "select id_promotion as id from promotion_segment where $pro_seg_str";
			    	$pro_seg = $con->createCommand($sqls)->queryAll();
					
					$temp = array_filter($pro_seg, function($v) use (&$id_pro_seg){
						$key = array_search($v['id'],$id_pro_seg);
						unset($id_pro_seg[$key]);
						return true;
					});
				}

				$id_del = array_merge($id_del, $id_pro_seg);
			}

			// thong tin khuyen mai co dieu kien san pham dich vu
			$lstItem = array();

			if($pro_item_str){
				$pro_item_str = substr($pro_item_str,0,-3);
		    	$sqli = "select id_promotion as id, id_service, id_product from promotion_product where $pro_item_str";
		    	$pro_item = $con->createCommand($sqli)->queryAll();
		    	$id_pro_item_f = $id_pro_item;
				
				$lstItem = array_filter($pro_item, function($v) use ($id_pro_item, &$id_pro_item_f){
					$key = array_search($v['id'],$id_pro_item);
					unset($id_pro_item_f[$key]);
					
					if($key >= 0){
						return true;
					}
				});

				$id_del = array_merge($id_del, $id_pro_item_f);
			}
			if(!empty($id_del)){
				$atPro = array_filter($atPro, function($v) use ($id_del){
					if(!in_array($v['id'], $id_del)){
						return true;
					}
				});

				if($lstItem){
					$lstItem = array_filter($lstItem, function($v) use ($id_del){
						if(!in_array($v['id'], $id_del)){
							return true;
						}
					});
				}
			}
			
		}
		return array('promotion' => $atPro, 'item' => $lstItem);
	}
}
