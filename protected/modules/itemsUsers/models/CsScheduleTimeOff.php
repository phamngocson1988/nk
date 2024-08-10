<?php

/** 
 * This is the model class for table "cs_schedule_time_off". 
 * 
 * The followings are the available columns in table 'cs_schedule_time_off': 
 * @property integer $id
 * @property integer $id_cs_schedule_chair
 * @property integer $id_dentist
 * @property integer $id_user
 * @property integer $id_branch
 * @property string $start
 * @property string $end
 * @property string $date
 * @property string $note
 * @property integer $status
 */  
class CsScheduleTimeOff extends CActiveRecord
{
	/** 
     * @return string the associated database table name 
     */ 
    public function tableName() 
    { 
        return 'cs_schedule_time_off'; 
    } 

    /** 
     * @return array validation rules for model attributes. 
     */ 
    public function rules() 
    { 
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array( 
            array('id_dentist, id_user, id_branch', 'required'),
            array('id_cs_schedule_chair, id_dentist, id_user, id_branch, status', 'numerical', 'integerOnly'=>true),
            array('date', 'length', 'max'=>25),
            array('note', 'length', 'max'=>200),
            array('start, end', 'safe'),
            // The following rule is used by search(). 
            // @todo Please remove those attributes that should not be searched. 
            array('id, id_cs_schedule_chair, id_dentist, id_user, id_branch, start, end, date, note, status', 'safe', 'on'=>'search'),
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
            'id_cs_schedule_chair' => 'Id Cs Schedule Chair',
            'id_dentist' => 'Id Dentist',
            'id_user' => 'Id User',
            'id_branch' => 'Id Branch',
            'start' => 'Start',
            'end' => 'End',
            'date' => 'Date',
            'note' => 'Note',
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
        $criteria->compare('id_cs_schedule_chair',$this->id_cs_schedule_chair);
        $criteria->compare('id_dentist',$this->id_dentist);
        $criteria->compare('id_user',$this->id_user);
        $criteria->compare('id_branch',$this->id_branch);
        $criteria->compare('start',$this->start,true);
        $criteria->compare('end',$this->end,true);
        $criteria->compare('date',$this->date,true);
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
     * @return CsScheduleTimeOff the static model class 
     */ 
    public static function model($className=__CLASS__) 
    { 
        return parent::model($className); 
    }
	
	public function searchCsScheduleTimeOff($and_conditions='',$or_conditions='',$additional='', $lpp='5', $cur_page='1') {
       
        $lpp_org = $lpp;
        $con = Yii::app()->db;
        $sql = "select count(*) from cs_schedule_time_off where 1=1 ";
         
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
        
        $sql = "select * from cs_schedule_time_off where 1=1 ";
        
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
	public function deleteCsScheduleTimeOff($id){ 
        $con=Yii::app()->db;
		$sql = "DELETE FROM cs_schedule_time_off WHERE id = '$id'";
        //$sql = "update mawb set mawb_status_id=$st where id='$id'";
        $data=$con->createCommand($sql)->execute();
        return $data;
    }
}