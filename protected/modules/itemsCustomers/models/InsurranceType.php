<?php

/** 
 * This is the model class for table "insurrance_type". 
 * 
 * The followings are the available columns in table 'insurrance_type': 
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $rate_discount
 * @property string $description
 */
class InsurranceType extends CActiveRecord
{ 
    /** 
     * @return string the associated database table name 
     */ 
    public function tableName() 
    { 
        return 'insurrance_type'; 
    } 

    /** 
     * @return array validation rules for model attributes. 
     */ 
    public function rules() 
    { 
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array( 
            array('code, name, rate_discount', 'required'),
            array('code', 'length', 'max'=>10),
            array('name', 'length', 'max'=>255),
            array('rate_discount', 'length', 'max'=>12),
            array('description', 'safe'),
            // The following rule is used by search(). 
            // @todo Please remove those attributes that should not be searched. 
            array('id, code, name, rate_discount, description', 'safe', 'on'=>'search'), 
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
            'code' => 'Code',
            'name' => 'Name',
            'rate_discount' => 'Rate Discount',
            'description' => 'Description',
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
        $criteria->compare('rate_discount',$this->rate_discount,true);
        $criteria->compare('description',$this->description,true);

        return new CActiveDataProvider($this, array( 
            'criteria'=>$criteria, 
        )); 
    } 

    /** 
     * Returns the static model of the specified AR class. 
     * Please note that you should have this exact method in all your CActiveRecord descendants! 
     * @param string $className active record class name. 
     * @return InsurranceType the static model class 
     */ 
    public static function model($className=__CLASS__) 
    { 
        return parent::model($className); 
    }
    public function searchInsurranceType($and_conditions='',$or_conditions='',$additional='', $lpp='5', $cur_page='1'){
       
        $lpp_org = $lpp;
        $con = Yii::app()->db;
        $sql = "select count(*) from insurrance_type where 1=1 ";
         
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
        
        $sql = "select * from insurrance_type where 1=1 ";
        
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
        
        $sql .= " order by id desc limit ".$start.",".$lpp;
        
        $data = $con->createCommand($sql)->queryAll();
        return array('paging'=>array('num_row'=>$num_row,'num_page'=>$num_page,'cur_page'=>$cur_page,'lpp'=>$lpp_org,'start_num'=>$start+1),'data'=>$data);
    }
	public function deleteInsurranceType($id){ 
        $con=Yii::app()->db;
		$sql = "DELETE FROM insurrance_type WHERE id = '$id'";
        //$sql = "update mawb set mawb_status_id=$st where id='$id'";
        $data=$con->createCommand($sql)->execute();
        return $data;
    }	
} 

