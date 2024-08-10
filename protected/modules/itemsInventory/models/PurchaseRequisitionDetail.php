<?php

/**
 * This is the model class for table "purchase_requisition_detail".
 *
 * The followings are the available columns in table 'purchase_requisition_detail':
 * @property integer $id
 * @property integer $id_purchase_requisition
 * @property integer $id_material
 * @property integer $qty
 * @property string $unit
 * @property string $create_date
 * @property string $update_date
 * @property integer $status
 */
class PurchaseRequisitionDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchase_requisition_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_purchase_requisition, id_material, qty, status', 'numerical', 'integerOnly'=>true),
			array('unit', 'length', 'max'=>50),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_purchase_requisition, id_material, qty, unit, create_date, update_date, status', 'safe', 'on'=>'search'),
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
			'id_purchase_requisition' => 'Id Purchase Requisition',
			'id_material' => 'Id Material',
			'qty' => 'Qty',
			'unit' => 'Unit',
			'create_date' => 'Create Date',
			'update_date' => 'Update Date',
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
		$criteria->compare('id_purchase_requisition',$this->id_purchase_requisition);
		$criteria->compare('id_material',$this->id_material);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PurchaseRequisitionDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getListDetail($id_purchase_requisition){
		$connection=Yii::app()->db;
        $sql = "SELECT a.`id`,a.`id_purchase_requisition`, a.`qty`, a.`unit`,a.`status`,b.`id` as id_material, b.`name` as name_material, b.`code` as code_material FROM purchase_requisition_detail a  INNER JOIN cs_material b WHERE a.`id_material` = b.`id` AND a.`status` >=0 AND (id_purchase_requisition IN(".$id_purchase_requisition."))";
        $command = $connection->createCommand($sql);
        $query = $command->queryAll();
		return $query;
	}
}
