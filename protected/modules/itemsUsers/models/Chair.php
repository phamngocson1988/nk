<?php

/**
 * This is the model class for table "chair".
 *
 * The followings are the available columns in table 'chair':
 * @property integer $id
 * @property integer $id_branch
 * @property string $name
 * @property string $description
 * @property integer $type
 * @property integer $status
 */
class Chair extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'chair';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_branch, type, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_branch, name, description, type, status', 'safe', 'on'=>'search'),
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
			'id_branch' => 'Id Branch',
			'name' => 'Name',
			'description' => 'Description',
			'type' => 'Type',
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
		$criteria->compare('id_branch',$this->id_branch);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchChair($and_conditions='',$or_conditions='',$additional='', $lpp='5', $cur_page='1'){
       
        $lpp_org = $lpp;
        $con = Yii::app()->db;
        $sql = "select count(*) from chair where 1=1 ";
         
        if($and_conditions and is_array($and_conditions)){
            foreach($and_conditions as $k => $v){
                $sql .= " and $k like '$v%'";
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
        };
        
        $num_row = $con->createCommand($sql)->queryScalar();
        
        
        if(!$num_row) return array('paging'=>array('num_row'=>'0','num_page'=>'1','cur_page'=>$cur_page ='1','lpp'=>$lpp,'start_num'=>1),'data'=>'');
        
        if($lpp == 'all'){
            $lpp = $num_row;
        }
        if($num_row < $lpp){
            $cur_page = 1;
            $num_page = 1;
            $lpp = $num_row;
            $start = 0;
        }else{
            
            $num_page = ceil($num_row/$lpp);
            if($cur_page >= $num_page){
                $cur_page = $num_page;

                $lpp = $num_row - ($num_page - 1) * $lpp_org;
            } 
            $start = ($cur_page - 1) * $lpp_org;
        }
        
        $sql = "select * from chair where 1=1 ";
        
        if($and_conditions and is_array($and_conditions)){
            foreach($and_conditions as $k => $v){
                $sql .= " and $k like '$v%'";
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
    public function deleteChair($id){ 
        $con=Yii::app()->db;
		$sql = "DELETE FROM chair WHERE id = '$id'";
        //$sql = "update mawb set mawb_status_id=$st where id='$id'";
        $data=$con->createCommand($sql)->execute();
        return $data;
    }
	public function showChairWithDow($id ,$ib){ 
        $con=Yii::app()->db;
		$sql = "SELECT * FROM `cs_schedule_chair` WHERE id_branch='$ib' AND dow='$id' AND STATUS=1 AND id_chair <> '' GROUP BY id_chair";
        //$sql = "update mawb set mawb_status_id=$st where id='$id'";
        $data=$con->createCommand($sql)->queryAll();
        return $data;
    }
	public function showChairWithDow2($id ,$ib){ 
        $con=Yii::app()->db;
		$sql = "SELECT * FROM `cs_schedule_chair` WHERE id_branch='$ib' AND dow='$id' AND STATUS=1 AND id_chair <> ''";
        //$sql = "update mawb set mawb_status_id=$st where id='$id'";
        $data=$con->createCommand($sql)->queryAll();
        return $data;
    }
	
	public function deleteCSTO($id){ 
        $con=Yii::app()->db;
		$sql = "DELETE FROM cs_schedule_time_off WHERE id = '$id'";
        $data=$con->createCommand($sql)->execute();
        return $data;
    }
	
	public function deleteChair2($id){ 
        $con=Yii::app()->db;
		$sql = "UPDATE cs_schedule_chair SET status = 0 WHERE id = '$id'";
        //$sql = "update mawb set mawb_status_id=$st where id='$id'";
        $data=$con->createCommand($sql)->execute();
        return $data;
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Chair the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
