<?php

/**
 * This is the model class for table "material_stock".
 *
 * The followings are the available columns in table 'material_stock':
 * @property integer $id
 * @property integer $id_repository
 * @property integer $id_material
 * @property integer $qty
 * @property double $amount
 * @property string $expiration_date
 * @property string $type
 * @property string $note
 * @property string $create_date
 * @property integer $status
 */
class MaterialStock extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'material_stock';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_repository, id_material, qty, status', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('type', 'length', 'max'=>10),
			array('expiration_date, not e, create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_repository, id_material, qty, amount, expiration_date, type, note, create_date, status', 'safe', 'on'=>'search'),
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
			'id_repository' => 'Id Repository',
			'id_material' => 'Id Material',
			'qty' => 'Qty',
			'amount' => 'Amount',
			'expiration_date' => 'Expiration Date',
			'type' => 'Type',
			'note' => 'Note',
			'create_date' => 'Create Date',
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
		$criteria->compare('id_repository',$this->id_repository);
		$criteria->compare('id_material',$this->id_material);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('expiration_date',$this->expiration_date,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MaterialStock the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	} 
  
	public function getListMaterialStock($searchRepository, $searchMaterial, $time_fisrt, $time_last){
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT  a.*, b.`name` as name_material ,b.`code` as code_material, c.`name` as name_repository  FROM material_stock a INNER JOIN cs_material b ON a.`id_material` = b.`id` INNER JOIN repository c ON a.`id_repository` = c.`id`  WHERE 1=1 ";

		if($time_fisrt && $time_last){
	    	$sql.= " and   DATE(  a.`expiration_date` ) >= '".$time_fisrt."' and  DATE(  a.`expiration_date` ) <=  '".$time_last."'";
	    }
	    elseif($time_fisrt){
	      	$sql.= " and   DATE(  a.`expiration_date` ) = '".$time_fisrt."'";
	    }
	    elseif($time_last){
	      	$sql.= " and   DATE(  a.`expiration_date` ) = '".$time_last."'";
	    }

		if($searchRepository){
			$sql.= " and a.`id_repository` = '".$searchRepository."'";
		}
		if($searchMaterial){
			$sql.= " and a.`id_material` = '".$searchMaterial."'";
		}
		$data = $con->createCommand($sql)->queryAll();
		$countQty 		= array();
		$output 		= array();
		$arr_new  		= array();
		if($data){
			foreach($data as $r){
				$countQty[$r['id_material']][] = $r['qty'];
			}
			$countQty 	= array_map('array_sum', $countQty);
            foreach ($data as $key => $val) {
            	$totalQty = 0;
            	if($countQty){
            		if(isset($countQty[$val['id_material']])){
            			$totalQty 	+= $countQty[$val['id_material']];
            		}
            	}
            	$output[$val['id_material']]['name_repository'] = $val['name_repository'];
            	$output[$val['id_material']]['code_material'] 	= $val['code_material'];
            	$output[$val['id_material']]['name_material'] 	= $val['name_material'];
            	$output[$val['id_material']]['qty'] 			= $totalQty;
            	$output[$val['id_material']]['content'][]		= $val;
            }
            return array('status' => 'successful', 'data' => $output);
		}else{
			return array('status' => 'error', 'message' => 'Không có dữ liệu');
		}
	}

	public function searchListMaterialStock($searchMaterial,$idRepository, $date){
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT  a.*, b.`name` as name_material ,b.`code` as code_material, b.`unit`, c.`name` as name_repository  FROM material_stock a INNER JOIN cs_material b ON a.`id_material` = b.`id` INNER JOIN repository c ON a.`id_repository` = c.`id`  WHERE 1=1 ";

		if($idRepository){
			$sql.= " and a.`id_repository` = '".$idRepository."'";
		}
		if($searchMaterial){
			$sql.= " and (b.`name` LIKE '%".$searchMaterial."%' OR b.`code` LIKE '%".$searchMaterial."%')";
		}
		if($date){
			$sql.= " and   DATE(a.`expiration_date`) >= '".$date."'";
		}
		$sql.= " order by expiration_date asc";
		$data 		= $con->createCommand($sql)->queryAll();
		$arr_new  	= array();
		$countQty 	= array();
		if($data){
			foreach($data as $r){
				$countQty[$r['id_material'].'/'.$r['expiration_date'].'/'.$r['amount']][] = $r['qty'];
			}
			$countQty 	= array_map('array_sum', $countQty);
			foreach ($data as $key => $value) {
				$totalQty = 0;
            	if($countQty){
            		if(isset($countQty[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']])){
            			$totalQty 	+= $countQty[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']];
            		}
            	}
            	if($totalQty >0){
					$arr_new[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']]['id_material'] 	 = $value['id_material'];
					$arr_new[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']]['name_material']  = $value['name_material'];
					$arr_new[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']]['code_material']  = $value['code_material'];
					$arr_new[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']]['expiration_date']= $value['expiration_date'];
					$arr_new[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']]['amount']	 	 = $value['amount'];
					$arr_new[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']]['qty']	 	 	 = $totalQty;
					$arr_new[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']]['unit']	 	 	 = $value['unit'];
					$arr_new[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']]['id_repository']  = $value['id_repository'];
					$arr_new[$value['id_material'].'/'.$value['expiration_date'].'/'.$value['amount']]['name_repository']= $value['name_repository'];
				}
			}
		}
		return $arr_new;
	}

	public function checkMaterialStock($idMaterial,$idRepository, $expiration_date){
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT SUM(qty) as sum_qty FROM material_stock a INNER JOIN cs_material b ON a.`id_material` = b.`id` WHERE 1=1 ";

		if($idRepository){
			$sql.= " and id_repository = '".$idRepository."'";
		}
		if($idMaterial){
			$sql.= " and id_material = '".$idMaterial."'";
		}
		if($expiration_date){
			$sql.= " and DATE(expiration_date) = '".$expiration_date."'";
		}
		$data 		= $con->createCommand($sql)->queryScalar();
		return $data;
		
	}
}
