<?php

/**
 * This is the model class for table "v_stock_transfer".
 *
 * The followings are the available columns in table 'v_stock_transfer':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $id_repository_transfer
 * @property string $repository_transfer
 * @property integer $id_repository_receipt
 * @property string $repository_receipt
 * @property integer $id_user
 * @property string $name_user
 * @property string $note
 * @property integer $status
 * @property double $sum_amount
 * @property string $create_date
 * @property string $update_date
 */
class VStockTransfer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_stock_transfer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, id_repository_transfer, id_repository_receipt, id_user, status', 'numerical', 'integerOnly'=>true),
			array('sum_amount', 'numerical'),
			array('code, name, repository_transfer, repository_receipt', 'length', 'max'=>255),
			array('name_user', 'length', 'max'=>128),
			array('note, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, id_repository_transfer, repository_transfer, id_repository_receipt, repository_receipt, id_user, name_user, note, status, sum_amount, create_date, update_date', 'safe', 'on'=>'search'),
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
			'id_repository_transfer' => 'Id Repository Transfer',
			'repository_transfer' => 'Repository Transfer',
			'id_repository_receipt' => 'Id Repository Receipt',
			'repository_receipt' => 'Repository Receipt',
			'id_user' => 'Id User',
			'name_user' => 'Name User',
			'note' => 'Note',
			'status' => 'Status',
			'sum_amount' => 'Sum Amount',
			'create_date' => 'Create Date',
			'update_date' => 'Update Date',
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
		$criteria->compare('id_repository_transfer',$this->id_repository_transfer);
		$criteria->compare('repository_transfer',$this->repository_transfer,true);
		$criteria->compare('id_repository_receipt',$this->id_repository_receipt);
		$criteria->compare('repository_receipt',$this->repository_receipt,true);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('name_user',$this->name_user,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('sum_amount',$this->sum_amount);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VStockTransfer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
