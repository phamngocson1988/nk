<?php

/**
 * This is the model class for table "cs_material".
 *
 * The followings are the available columns in table 'cs_material':
 * @property integer $id
 * @property integer $id_material_group
 * @property string $name
 * @property string $accounting
 * @property string $description
 * @property string $unit
 * @property string $create_date
 * @property string $update_date
 * @property integer $status
 */
class CsMaterial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cs_material';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'unique', 'message'=>"Mã nguyên vật liệu đã tồn tại!"),
			array('id_material_group, name', 'required'),
			array('id_material_group, status, status_hidden', 'numerical', 'integerOnly'=>true),
			array('name,unit', 'length', 'max'=>255),
			array('accounting, code', 'length', 'max'=>50),
			array('description', 'length', 'max'=>755),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_material_group, name, code, accounting, description, unit, create_date, update_date, status, status_hidden', 'safe', 'on'=>'search'),
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
			'id_material_group' => 'Nhóm nguyên vật liệu',
			'name' => 'Tên nguyên vật liệu',
			'code'	=> 'Mã nguyên vật liệu',
			'accounting' => 'Mã kế toán',
			'description' => 'Mô tả',
			'unit'		=> 'Đơn vị tính',
			'create_date' => 'Ngày tạo',
			'update_date' => 'Ngày chỉnh sửa',
			'status' => 'Trạng thái',
			'status_hidden'=> 'status_hidden',
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
		$criteria->compare('id_material_group',$this->id_material_group);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('accounting',$this->accounting,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('status_hidden',1);
		$criteria->order = 'create_date ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CsMaterial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getNameMaterialGroup($id_material_group){
		$name = '';	
		$data = CsMaterialGroup::model()->findByPK($id_material_group);
		if($data){
			$name = $data->name;
		}
		return $name;
	}

	public function searchMaterial($curpage,$search, $status='')
	{
		$start_point=20*($curpage-1);
		$cs = new CsMaterial;		
		$q = new CDbCriteria(array(
    	'condition'=>'published="true"'
		));
		$v = new CDbCriteria();	
		$v->addCondition('t.status_hidden >= 0');
		if($status>0){
			$v->addCondition('t.status='.$status);
	  	}

		$v->addSearchCondition('code', $search, true);
		$v->addSearchCondition('name', $search, true, 'OR');
	    $v->order= 'id DESC';
	    $v->limit = 20;
	    $v->offset = $start_point;
	    $q->mergeWith($v);	    
	     
	    return $cs->findAll($v);
	}

	
}
