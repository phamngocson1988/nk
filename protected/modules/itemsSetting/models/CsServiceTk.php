<?php

/** 
 * This is the model class for table "cs_service_tk". 
 * 
 * The followings are the available columns in table 'cs_service_tk': 
 * @property integer $id
 * @property integer $id_service_type_tk
 * @property integer $id_cs_service
 * @property integer $id_gp_users
 * @property string $name
 * @property string $price
 * @property string $createdate
 * @property integer $st
 * @property string $note
 */ 
class CsServiceTk extends CActiveRecord
{ 
    /** 
     * @return string the associated database table name 
     */ 
    public function tableName() 
    { 
        return 'cs_service_tk'; 
    } 

    /** 
     * @return array validation rules for model attributes. 
     */ 
    public function rules() 
    { 
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array( 
            array('id_service_type_tk, id_cs_service, id_gp_users, st', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>255),
            array('price', 'length', 'max'=>250),
            array('note', 'length', 'max'=>500),
            array('createdate', 'safe'),
            // The following rule is used by search(). 
            // @todo Please remove those attributes that should not be searched. 
            array('id, id_service_type_tk, id_cs_service, id_gp_users, name, price, createdate, st, note', 'safe', 'on'=>'search'),
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
            'id_service_type_tk' => 'Id Service Type Tk',
            'id_cs_service' => 'Id Cs Service',
            'id_gp_users' => 'Id Gp Users',
            'name' => 'Name',
            'price' => 'Price',
            'createdate' => 'Createdate',
            'st' => 'St',
            'note' => 'Note',
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
        $criteria->compare('id_service_type_tk',$this->id_service_type_tk);
        $criteria->compare('id_cs_service',$this->id_cs_service);
        $criteria->compare('id_gp_users',$this->id_gp_users);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('price',$this->price,true);
        $criteria->compare('createdate',$this->createdate,true);
        $criteria->compare('st',$this->st);
        $criteria->compare('note',$this->note,true);

        return new CActiveDataProvider($this, array( 
            'criteria'=>$criteria, 
        )); 
    }  

    /** 
     * Returns the static model of the specified AR class. 
     * Please note that you should have this exact method in all your CActiveRecord descendants! 
     * @param string $className active record class name. 
     * @return CsServiceTk the static model class 
     */ 
    public static function model($className=__CLASS__) 
    { 
        return parent::model($className); 
    }
	public function deleteStatus($text){
		$connection=Yii::app()->db;
		$sql = "update cs_service_tk SET st = 0 WHERE ".$text;
		$command=$connection->createCommand($sql);
		$command->execute();
	}	
} 
?>