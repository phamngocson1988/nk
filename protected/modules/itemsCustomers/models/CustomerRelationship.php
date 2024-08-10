<?php

/**
 * This is the model class for table "customer_relationship".
 *
 * The followings are the available columns in table 'customer_relationship':
 * @property integer $id
 * @property integer $customer_1
 * @property integer $customer_2
 * @property integer $id_relationship
 * @property string $create_date
 * @property integer $status
 */
class CustomerRelationship extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_relationship';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_1, customer_2, id_relationship, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_1, customer_2, id_relationship, create_date, status', 'safe', 'on'=>'search'),
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
			'customer_1' => 'Customer 1',
			'customer_2' => 'Customer 2',
			'id_relationship' => 'Id Relationship',
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
		$criteria->compare('customer_1',$this->customer_1);
		$criteria->compare('customer_2',$this->customer_2);
		$criteria->compare('id_relationship',$this->id_relationship); 
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
	 * @return CustomerRelationship the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//thêm mối quan hệ trong gia đình
	//thêm mối quan hệ trong gia đình
	public function addRelationFamily($id_customer,$customer_relation,$relation_family) 
	{
		if(!$relation_family){
			return -1; 
 		}
		if(!$customer_relation){
			return -2; 
 		}
 		if(!$id_customer){
			return 0; 
 		}
 		
 		$customerRelationship  = new CustomerRelationship;
 		$customerRelationship->customer_1 = $id_customer;
 		$customerRelationship->customer_2 = $customer_relation;
 		$customerRelationship->id_relationship = $relation_family;

	 	if($customerRelationship->validate()) {
						
			if($customerRelationship->save()) {

				$customerRelationship_new  = new CustomerRelationship;
				$customerRelationship_new->customer_2 = $customerRelationship->customer_1;
				$customerRelationship_new->customer_1 = $customerRelationship->customer_2;
				if($customerRelationship->id_relationship ==1)
				{
					$customerRelationship_new->id_relationship = 3;
				}
				elseif($customerRelationship->id_relationship ==3)
				{
					$customerRelationship_new->id_relationship = 1;
				}
				elseif ( $customerRelationship->id_relationship == 2|| $customerRelationship->id_relationship == 4|| $customerRelationship->id_relationship == 5) {
					$customerRelationship_new->id_relationship =$customerRelationship->id_relationship;
				}
				
				$customerRelationship_new->save();
				return 1;
			}
				return 0;
		}
		else 
		 return $customerRelationship->getErrors();
	}

	public function addRelationSocial($id_customer,$customer_relation_social,$relation_social) 
	{
		if(!$relation_social){
			return -1; 
 		}
		if(!$customer_relation_social){
			return -2; 
 		}
 		if(!$id_customer){
			return 0; 
 		}
 		
 		$customerRelationship  = new CustomerRelationSocial;
 		$customerRelationship->customer_1 = $id_customer;
 		$customerRelationship->customer_2 = $customer_relation_social;
 		$customerRelationship->id_relation = $relation_social;

	 	if($customerRelationship->validate()) {
						
			if($customerRelationship->save()) {

				$customerRelationship_new  = new CustomerRelationSocial;
				$customerRelationship_new->customer_2 = $customerRelationship->customer_1;
				$customerRelationship_new->customer_1 = $customerRelationship->customer_2;
				$customerRelationship_new->id_relation = $relation_social;
				$customerRelationship_new->save();
				return 1;
			}
				return 0;
		}
		else 
		return $customerRelationship->getErrors();
	}

	public function listCustomerRelationFamily($id_customer){

		$data =VRelationFamily::model()->findAllByAttributes(array('customer_1' =>$id_customer,'status'=>'1'));
		$relation_1 = array();
		$relation_2 = array();
		$relation_3 = array();
		$relation_4 = array();
		$relation_5 = array();

		foreach ($data as $key => $value) {
			if($value['id_relationship'] ==1){
				$relation_1[] = $value['id'];
			}
			else if($value['id_relationship'] ==2){
				$relation_2[] = $value['id'];
			}
			else if($value['id_relationship'] ==3){
				$relation_3[] = $value['id'];
			}
			else if($value['id_relationship'] ==4){
				$relation_4[] = $value['id'];
			}
			else if($value['id_relationship'] ==5){
				$relation_5[] = $value['id'];
			}

		}
		return array('relation_1'=>$relation_1,'relation_2'=>$relation_2,'relation_3'=>$relation_3,'relation_4'=>$relation_4,'relation_5'=>$relation_5);

	}

	public function inforRelationFamily($id){
		return VRelationFamily::model()->findByAttributes(array('id'=>$id));
	}
}
