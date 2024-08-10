<?php

/**
 * This is the model class for table "labo_history".
 *
 * The followings are the available columns in table 'labo_history':
 * @property integer $id
 * @property integer $id_customer
 * @property integer $id_labo
 * @property string description
 * @property string sent_person
 * @property string sent_tray
 * @property string receive_person 
 * @property string receive_tray
 * @property string receive_date
 * @property string security
 * @property string receive_assistant
 * @property string create_date
 */
class LaboHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'labo_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sent_date, id_user, id_customer, id_labo', 'required'),
			array('id_user, id_customer, id_labo', 'numerical', 'integerOnly'=>true),
			array('description, sent_person, sent_tray, receive_person, receive_tray, receive_date, security, receive_assistant, create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, id_customer, id_labo, description, sent_date, sent_person, sent_tray, receive_person, receive_tray, receive_date, security, receive_assistant, create_date', 'safe', 'on'=>'search'),
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
			'id_user' => 'User ID', 
			'id_customer' => 'Customer ID', 
			'id_labo' => 'Labo ID', 
			'description' => 'Description', 
			'sent_person' => 'Sent Person', 
			'sent_tray' => 'Sent Tray', 
			'receive_person' => 'Received Person', 
			'receive_tray' => 'Received Tray', 
			'receive_date' => 'Received Datetime', 
			'security' => 'Security', 
			'receive_assistant' => 'Received Assitant',
			'create_date' => 'Create Date'
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
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_customer',$this->id_customer);
		$criteria->compare('id_labo',$this->id_labo);
		$criteria->compare('description',$this->id_dentist);
		$criteria->compare('sent_date',$this->sent_date,true);
		$criteria->compare('sent_person',$this->sent_person,true);
		$criteria->compare('sent_tray',$this->sent_tray,true);
		$criteria->compare('receive_person',$this->receive_person,true);
		$criteria->compare('receive_tray',$this->receive_tray,true);
		$criteria->compare('receive_date',$this->receive_date,true);
		$criteria->compare('security',$this->security,true);
		$criteria->compare('receive_assistant',$this->receive_assistant,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Labo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getListLabo($search_cus, $search_user, $labo, $fromtime, $totime) {
		$query = Yii::app()->db->createCommand()
			->select('a.*,gp_users.name as gp_users_name,list_labo.name as labo_name,customer.fullname as customer_name,customer.code_number')
			->from('labo_history a')
			->where('a.create_date between :from_time and :to_time', array(':from_time' => $fromtime, ':to_time' => $totime))
			->andWhere('a.status = 1')
			->leftJoin('gp_users', 'gp_users.id = a.id_user')
			->leftJoin('list_labo', 'list_labo.id = a.id_labo')
			->leftJoin('customer', 'customer.id = a.id_customer')
			->order('a.create_date DESC');
		if ($search_cus) {
			$query->andWhere('a.id_customer=:id_customer', array(':id_customer' => $search_cus));
		}
		if ($search_user) {
			$query->andWhere(array('in','a.id_user', explode(',', $search_user)));
		}
		if ($labo) {
			$query->andWhere(array('in','a.id_labo', explode(',', $labo)));
		}
		return $query->queryAll();	
	}

	public function insertLaboHistory($dataLabo = array('id_customer' => '', 'id_user' => '', 'id_labo' => '', 'sent_date' => '', 'sent_person' => '', 'sent_tray' => '', 'receive_date' => '', 'receive_person' => '', 'receive_tray' => '', 'security' => '', 'receive_assistant' => '', 'description' => '', 'create_date' => '')) {
		$model                 = new LaboHistory();
		$model->attributes     = $dataLabo;
		if ($model->save())
			return $model->id;
		else
			return 0;
	}

	public function updateLaboHistory($id, $dataLabo = array('id_customer' => '', 'id_user' => '', 'id_labo' => '', 'sent_date' => '', 'sent_person' => '', 'sent_tray' => '', 'receive_date' => '', 'receive_person' => '', 'receive_tray' => '', 'security' => '', 'receive_assistant' => '', 'description' => '')) {
		$model = LaboHistory::model()->findByPk($id);
		$model->attributes     = $dataLabo;
		if ($model->update())
			return 1;
		else
			return 0;
	}

	public function getLabo($id) {
		$query = Yii::app()->db->createCommand()
			->select('a.*,gp_users.name as gp_users_name,list_labo.name as labo_name,customer.fullname as customer_name,customer.code_number')
			->from('labo_history a')
			->leftJoin('gp_users', 'gp_users.id = a.id_user')
			->leftJoin('list_labo', 'list_labo.id = a.id_labo')
			->leftJoin('customer', 'customer.id = a.id_customer')
			->where('a.id=:id', array(':id' => $id))
			->andWhere('a.status=1');
		$data = $query->queryAll();
		if ($data) {
			return $data[0];
		} else {
			return false;
		}
	}

	public function removeLaboHistory($id) {
		$model = LaboHistory::model()->findByPk($id);
		$model->status     = 0;
		if ($model->update())
			return 1;
		else
			return 0;
	}

	public function getLaboByCustomer($id_customer) {
		$query = Yii::app()->db->createCommand()
			->select('a.*,gp_users.name as gp_users_name,list_labo.name as labo_name,customer.fullname as customer_name,customer.code_number')
			->from('labo_history a')
			->leftJoin('gp_users', 'gp_users.id = a.id_user')
			->leftJoin('list_labo', 'list_labo.id = a.id_labo')
			->leftJoin('customer', 'customer.id = a.id_customer')
			->where('a.id_customer=:id_customer', array(':id_customer' => $id_customer))
			->andWhere('a.status=1');
		$data = $query->queryAll();
		if ($data) {
			return $data;
		} else {
			return false;
		}
	}
}
