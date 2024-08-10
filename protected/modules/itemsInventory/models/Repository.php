<?php

/**
 * This is the model class for table "repository".
 *
 * The followings are the available columns in table 'repository':
 * @property integer $id
 * @property integer $id_branch
 * @property string $code
 * @property string $name
 * @property string $address
 * @property string $description
 * @property integer $type_repository
 * @property string $create_date
 * @property string $update_date
 * @property integer $status
 */
class Repository extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repository';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, id_branch, type_repository, status', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>50),
			array('name', 'length', 'max'=>255),
			array('address', 'length', 'max'=>1000),
			array('description, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_branch, code, name, address, description, type_repository, create_date, update_date, status', 'safe', 'on'=>'search'),
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
			'id_branch' => 'Chi nhánh',
			'code' => 'Mã kho',
			'name' => 'Tên kho',
			'address' => 'Địa chỉ',
			'description' => 'Mô tả',
			'type_repository' => 'Loại kho',
			'create_date' => 'Ngày tạo',
			'update_date' => 'Ngày chỉnh sửa',
			'status' => 'Trạng thái',
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
		$group_id =  Yii::app()->user->getState('group_id');
		$type_repository = '';
		if($group_id== 21){
			$type_repository = 2;
		}else if($group_id== 22){
			$type_repository = 3;
		}
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('id_branch',$this->id_branch);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type_repository',$type_repository);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('status',1);
		$criteria->order = 'create_date ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Repository the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getNameBranch($id_branch){
		$name = '';	
		$data = Branch::model()->findByPK($id_branch);
		if($data){
			$name = $data->name;
		}
		return $name;
	}


	public function getSource() {
            return $this->sourceOptions[$this->type_repository];
    }

    public function getSourceOptions() {
            return array(
                    1 => 'Kho tổng',
                    2 => 'Kho cơ sở',
                    3 => 'Kho tầng',
            );
    }
}
