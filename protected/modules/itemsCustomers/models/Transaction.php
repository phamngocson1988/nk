<?php

/**
 * This is the model class for table "transaction".
 *
 * The followings are the available columns in table 'transaction':
 * @property integer $id
 * @property string $code_number
 * @property string $code_number_old
 * @property integer $billing_number
 * @property string $date
 * @property string $tooth
 * @property string $account_code
 * @property string $description
 * @property integer $fee
 * @property string $provider_code
 * @property integer $payment_number
 */
class Transaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('billing_number, fee, payment_number', 'numerical', 'integerOnly'=>true),
			array('code_number, code_number_old', 'length', 'max'=>20),
			array('tooth, account_code, description, provider_code', 'length', 'max'=>255),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code_number, code_number_old, billing_number, date, tooth, account_code, description, fee, provider_code, payment_number', 'safe', 'on'=>'search'),
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
			'code_number' => 'Code Number',
			'code_number_old' => 'Code Number Old',
			'billing_number' => 'Billing Number',
			'date' => 'Date',
			'tooth' => 'Tooth',
			'account_code' => 'Account Code',
			'description' => 'Description',
			'fee' => 'Fee',
			'provider_code' => 'Provider Code',
			'payment_number' => 'Payment Number',
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
		$criteria->compare('code_number',$this->code_number,true);
		$criteria->compare('code_number_old',$this->code_number_old,true);
		$criteria->compare('billing_number',$this->billing_number);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('tooth',$this->tooth,true);
		$criteria->compare('account_code',$this->account_code,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('provider_code',$this->provider_code,true);
		$criteria->compare('payment_number',$this->payment_number);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function update_transaction($page,$limit){
		$cug_p = ($page - 1) * $limit;
		$data =  	Yii::app()->db->createCommand()
            ->select('t.*')
            ->from('transaction t')
            ->limit($limit, $cug_p-1)
            ->queryAll();
           //return $data;
        if($data){
        	$code_new = '';
        	foreach ($data as $key => $v) {
        		if(strlen($v['code_number_old']) == 8){
        			$code_new = '10'.$v['code_number_old'];
        		}elseif(strlen($v['code_number_old']) == 9){
        			$code_new = '1'.$v['code_number_old'];
        		}

        		if($v['code_number'] != $code_new){
	        		$update = Transaction::model()->findByPk($v['id']);
	        		$update->code_number = $code_new;
	        		$update->save();
	        	}
        	}
        }
	}
}
