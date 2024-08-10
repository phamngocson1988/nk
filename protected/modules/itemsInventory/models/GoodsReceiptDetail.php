<?php

/**
 * This is the model class for table "goods_receipt_detail".
 *
 * The followings are the available columns in table 'goods_receipt_detail':
 * @property integer $id
 * @property integer $id_goods_receipt
 * @property integer $id_material
 * @property string $unit
 * @property integer $qty
 * @property double $amount
 * @property double $sumamount
 * @property string $expiration_date
 * @property string $create_date
 * @property string $update_date
 * @property integer $status
 */
class GoodsReceiptDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'goods_receipt_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_goods_receipt, id_material, qty, status', 'numerical', 'integerOnly'=>true),
			array('amount, sumamount', 'numerical'),
			array('unit', 'length', 'max'=>50),
			array('expiration_date, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_goods_receipt, id_material, unit, qty, amount, sumamount, expiration_date, create_date, update_date, status', 'safe', 'on'=>'search'),
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
			'id_goods_receipt' => 'Id Goods Receipt',
			'id_material' => 'Id Material',
			'unit' => 'Unit',
			'qty' => 'Qty',
			'amount' => 'Amount',
			'sumamount' => 'Sumamount',
			'expiration_date' => 'Expiration Date',
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
		$criteria->compare('id_goods_receipt',$this->id_goods_receipt);
		$criteria->compare('id_material',$this->id_material);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('sumamount',$this->sumamount);
		$criteria->compare('expiration_date',$this->expiration_date,true);
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
	 * @return GoodsReceiptDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
