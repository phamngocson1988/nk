<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $id
 * @property integer $code_number
 * @property string $username
 * @property string $password
 * @property string $id_fb
 * @property string $name_fb
 * @property string $id_gg
 * @property string $name_gg
 * @property string $fullname
 * @property string $address
 * @property string $phone
 * @property string $phone_sms
 * @property string $email
 * @property string $image
 * @property string $device_id
 * @property integer $dentist_type
 * @property string $id_country
 * @property integer $id_city
 * @property integer $id_state
 * @property integer $id_source
 * @property string $zipcode
 * @property integer $gender
 * @property string $birthdate
 * @property string $createdate
 * @property string $activedate
 * @property integer $status
 * @property integer $status_schedule
 * @property integer $id_job
 * @property integer $position
 * @property string $organization
 * @property string $note
 * @property string $identity_card_number
 * @property string $home_phone
 * @property string $status_confirm
 * @property string $code_confirm
 * @property string $user_delete
 * @property double $deposit
 * @property integer $isSmsBirthdate
 */

class Customer extends CActiveRecord
{
	public $repeatpassword;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('phone, phone_sms, fullname', 'required', 'message'=>"{attribute} không được để trống!"),
			//array('username', 'match' ,'pattern'=>'/^[a-zA-Z][a-zA-Z0-9._]+$/i', 'message'=>'Tên tài khoản bao gồm chữ, số'),
			array('username', 'unique', 'message' => "Tài khoản đã tồn tại!"),
			array('email', 'unique', 'message' => "Email đã tồn tại!"),
			array('phone', 'numerical', 'message' => "Số điện thoại phải là số!"),

			array('phone', 'validatePhone'),

			array('email', 'email', 'message' => "Email không đúng định dạng!"),
			//array('phone, phone_sms', 'unique', 'message'=>"Số điện thoại đã tồn tại!"),
			array('code_number', 'length', 'max' => 30),
			array('id_city, id_state, id_source, gender, status, status_schedule,flag, id_job, position,status_confirm,user_delete', 'numerical', 'integerOnly' => true),
			array('password, fullname, address, email, image, id_country, organization, note, id_fb, name_fb, id_gg, name_gg,', 'length', 'max' => 255),
			array('phone, phone_sms, identity_card_number, home_phone', 'length', 'max' => 20),
			array('zipcode', 'length', 'max' => 16),
			array('birthdate, createdate,code_confirm', 'safe'),
			array('repeatpassword', 'compare', 'compareAttribute' => 'password', 'message' => "Mật khẩu không trùng khớp!"),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code_number, password, fullname, id_fb, name_fb, id_gg, name_gg, address, phone, phone_sms, email, image, id_country, id_city, id_state, id_source, zipcode, gender, birthdate, createdate, device_id, status, status_schedule,flag, id_job, position, organization, note, identity_card_number, home_phone, user_delete, deposit, isSmsBirthdate', 'safe', 'on' => 'search'),
			array('id_branch', 'safe')
		);
	}

	public function validatePhone()
	{
		$phone = $this->phone;

		if (!$phone) {
			return;
		}

		if (strlen($phone) != 10) {
			$this->addError('phone', 'Số điện thoại không đúng 10 số.');
			return;
		}

		$phone = Customer::model()->getVnPhone($phone);

		if (!Customer::model()->TestPrefix($phone)) {
			$this->addError('phone', 'Đầu số điện thoại không đúng.');
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code_number' => 'Code Number',
			'password' => 'Mật khẩu',
			'repeatpassword' => 'Nhập lại mật khẩu',
			'id_fb' => 'Id Fb',
			'name_fb' => 'Name Fb',
			'id_gg' => 'Id Gg',
			'name_gg' => 'Name Gg',
			'fullname' => 'Họ tên',
			'address' => 'Địa chỉ',
			'phone' => 'Số điện thoại',
			'phone_sms' => 'Phone Sms',
			'email' => 'Email',
			'image' => 'Image',
			'id_country' => 'Id Country',
			'id_city' => 'Id City',
			'id_state' => 'Id State',
			'id_source' => 'Id Source',
			'zipcode' => 'Zipcode',
			'gender' => 'Gender',
			'birthdate' => 'Ngày tháng năm sinh',
			'createdate' => 'Createdate',
			'device_id' => 'Device Id',
			'status' => 'Status',
			'status_schedule' => 'Status Schedule',
			'flag' => 'Flag',
			'id_job' => 'Id Job',
			'position' => 'Position',
			'organization' => 'Organization',
			'note' => 'Note',
			'identity_card_number' => 'Identity Card Number',
			'home_phone' => 'Home Phone',
			'code_confirm' => 'Code Confim',
			'status_confirm' => 'Status Confim',
			'user_delete'	=> 'User delete',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('code_number', $this->code_number);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('repeatpassword', $this->repeatpassword, true);
		$criteria->compare('id_fb', $this->id_fb, true);
		$criteria->compare('name_fb', $this->name_fb, true);
		$criteria->compare('id_gg', $this->id_gg, true);
		$criteria->compare('name_gg', $this->name_gg, true);
		$criteria->compare('fullname', $this->fullname, true);
		$criteria->compare('address', $this->address, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('phone_sms', $this->phone_sms, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('image', $this->image, true);
		$criteria->compare('id_country', $this->id_country, true);
		$criteria->compare('id_city', $this->id_city);
		$criteria->compare('id_state', $this->id_state);
		$criteria->compare('id_source', $this->id_source);
		$criteria->compare('zipcode', $this->zipcode, true);
		$criteria->compare('gender', $this->gender);
		$criteria->compare('birthdate', $this->birthdate, true);
		$criteria->compare('createdate', $this->createdate, true);
		$criteria->compare('device_id', $this->device_id, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('status_schedule', $this->status_schedule);
		$criteria->compare('flag', $this->flag);
		$criteria->compare('id_job', $this->id_job);
		$criteria->compare('position', $this->position);
		$criteria->compare('organization', $this->organization, true);
		$criteria->compare('note', $this->note, true);
		$criteria->compare('identity_card_number', $this->identity_card_number, true);
		$criteria->compare('home_phone', $this->home_phone, true);
		$criteria->compare('code_confirm', $this->code_confirm);
		$criteria->compare('status_confirm', $this->status_confirm);
		$criteria->compare('user_delete', $this->user_delete);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function getListSumCustomers()
	{

		$num_row = Yii::app()->db->createCommand()
			->select('Count(*)')
			->from('customer')
			->where('status=:status', array(':status' => '1'))
			->queryScalar();
		return $num_row;
	}

	public function getListSumCustomersByAppointment($id_dentist)
	{

		$num_row = Yii::app()->db->createCommand()
			->select('Count(*)')
			->from('v_schedule')
			->where('v_schedule.id_dentist=:id_dentist', array(':id_dentist' => $id_dentist))
			->group('v_schedule.id_customer')
			->queryScalar();
		return $num_row;
	}

	public function getlistServices()
	{
		return CsService::model()->findAllByAttributes(array('status' => 1));
	}
	public function getListDentists()
	{
		return GpUsers::model()->findAllByAttributes(array('group_id' => Yii::app()->params['id_group_dentist']));
	}
	public function getListBranch()
	{
		return Branch::model()->findAll();
	}

	public function getCountryByCode($code)
	{

		$data = CsCountry::model()->findByPk($code);

		return $data->country;
	}
	public function getSourceById($id_source)
	{

		$data = Source::model()->findByPk($id_source);

		return $data->name;
	}
	public function getSegmentById($id_segment)
	{

		$data = Segment::model()->findByPk($id_segment);

		return $data->name;
	}
	public function getJobById($id_job)
	{

		$data = Job::model()->findByPk($id_job);

		return $data->name;
	}

	public function getNameByIdBranch($id_branch)
	{

		if (!$id_branch) {
			return -1;
		}

		$data = Branch::model()->findByPk($id_branch);

		return $data->name;
	}
	public function getNameByIdDentist($id_dentist)
	{

		if (!$id_dentist) {
			return -1;
		}

		$data = GpUsers::model()->findByPk($id_dentist);

		return $data ? $data->name : '';
	}
	public function getListCountry()
	{
		$dataListDefault = array();
				// $dataListDefault[0] = array('code' => 'AU', 'country' => 'Australia');
		// $dataListDefault[1] = array('code' => 'CA', 'country' => 'Canada');
		// $dataListDefault[2] = array('code' => 'US', 'country' => 'United States');
		$dataListDefault[2] = array('code' => 'VK', 'country' => 'Việt kiều');
		$dataListDefault[3] = array('code' => 'VN', 'country' => 'Viet Nam');
		$dataListDefault[4] = array('code' => 'OTHER', 'country' => 'Other');
		return $dataListDefault;
		//return CsCountry::model()->findAllByAttributes(array('flag'=>1));
	}

	public function getListSource()
	{
		return Source::model()->findAll();
	}
	public function getListSegment()
	{
		return Segment::model()->findAll();
	}
	public function getSelectedSegment($id_customer)
	{

		if (!$id_customer) {
			return -1;
		}

		$data = CustomerSegment::model()->findByAttributes(array('id_customer' => $id_customer));

		if ($data) {
			return $data->id_segment;
		}

		return 0;
	}
	public function getListCustomerByIdSegment($id_segment)
	{

		return CustomerSegment::model()->findAllByAttributes(array('id_segment' => $id_segment));
	}
	public function getJob()
	{
		return Job::model()->findAll();
	}
	public function getInsurranceType()
	{
		return InsurranceType::model()->findAll();
	}
	public function getListMedicineAlert()
	{
		return MedicineAlert::model()->findAll();
	}
	public function getListDisease()
	{
		return Disease::model()->findAll();
	}
	public function checkFlagMedical($id_customer)
	{
		$data =	Customer::model()->findByPk($id_customer);
		return $data->flag;
	}

	public function getListMedicalHistory($id_history_group, $id_order_detail)
	{
		return $data = Yii::app()->db->createCommand()
			->select('cs_medical_history.*,gp_users.name gp_users_name')
			->from('cs_medical_history')
			->where('id_history_group=:id_history_group', array(':id_history_group' => $id_history_group))
			->andWhere('id_order_detail=:id_order_detail', array(':id_order_detail' => $id_order_detail))
			->leftJoin('gp_users', 'gp_users.id = cs_medical_history.id_dentist')
			->order('cs_medical_history.createdate DESC')
			->queryAll();
	}
	public function getListOrderDetail($id_customer)
	{
		return VOrderDetail::model()->findAllByAttributes(array("id_customer" => $id_customer));
	}
	public function existQuotation($id_customer, $id_mhg)
	{
		return VQuotations::model()->findByAttributes(array("id_customer" => $id_customer, "id_group_history" => $id_mhg));
	}
	public function getOrder($id)
	{
		return VOrder::model()->findByAttributes(array("id" => $id));
	}
	public function getListMedicalHistoryAlertOfCustomer($id_customer)
	{

		return $data   = Yii::app()->db->createCommand()
			->select('cs_medical_history_alert.id as id, cs_medical_history_alert.id_medicine_alert as id_medicine_alert, cs_medical_history_alert.note, medicine_alert.name as name_medicine_alert')
			->from('cs_medical_history_alert')
			->where('cs_medical_history_alert.id_customer=:id_customer', array(':id_customer' => $id_customer))
			->leftJoin('medicine_alert', 'medicine_alert.id = cs_medical_history_alert.id_medicine_alert')
			->queryAll();
	}
	public function getListMedicalHistoryAlert($id_customer)
	{

		$result = array();
		$data = CsMedicalHistoryAlert::model()->findAllByAttributes(array("id_customer" => $id_customer));
		if ($data && count($data) > 0) {
			foreach ($data as $key => $value) {
				$result[$value['id_medicine_alert']] = $value['note'];
			}
		}
		return $result;
	}
	public function getCustomerInsurrance($id_customer)
	{

		$model = new CsCustomerInsurrance();

		$data  = $model->findByAttributes(array('id_customer' => $id_customer, 'status' => 1));

		if ($data) {
			return $data;
		}
		return $model;
	}

	public function getVnPhone($phone)
	{
		$phone = preg_replace("/[^0-9]/", "", $phone); //remove none numberic
		if (strlen($phone) == 0)
			return "";
		if (strlen($phone) > 10)
			$phone = substr($phone, 0, 10);
		return $phone;
	}

	public function getCodeNumberCustomer()
	{
		$date      = date('Y-m-d');
		$id_branch = yii::app()->user->getState('user_branch');
		$con       = Yii::app()->db;

		$sql = "SELECT COUNT(*) FROM `customer` WHERE DATE(`createdate`) = DATE('$date') AND status = 1 AND id_branch = '$id_branch' ";
		$dem = $con->createCommand($sql)->queryScalar();

		$sql = "SELECT MAX(code_number) FROM `customer` WHERE status = 1 AND id_branch = '$id_branch' AND date(createdate) = '$date'";
		$max = substr($con->createCommand($sql)->queryScalar(), 1);

		if ($dem == 0) {
			$dem = '000';
		} else {
			if ($dem < 100) {
				$dem = '0' . $dem;
				if ($dem < 10) {
					$dem = '0' . $dem;
				}
			}
		}

		$create_date = str_replace(array('-', ' ', ':'), '', substr($date, 2));
		if ($dem > 0) {
			$order_code = $create_date . $dem;
		} else {
			$order_code = $create_date . $dem;
		}

		if ($order_code < $max) {
			return $max + 1;
		}

		return $order_code;
	}

	public function getCodeNumberCustomerToday()
	{
		$date      = date('Y-m-d');
		$id_branch = yii::app()->user->getState('user_branch');
		$con       = Yii::app()->db;

		$sql  = "SELECT code_number FROM `customer` WHERE DATE(`createdate`) = DATE('$date') AND status = 1 AND id_branch = '$id_branch' ";
		$data = $con->createCommand($sql)->queryAll();

		$listdata    = array();
		$code_number = $id_branch . date("y") . date("m") . date("d");

		$max1 = 0;
		$max2 = 0;

		foreach ($data as $key => $value) {

			if ($value['code_number'] < $code_number . "030" && $value['code_number'] >= $code_number . "000") {
				if ($max1 < $value['code_number']) {
					$max1 = $value['code_number'];
				}
			} elseif ($value['code_number'] >= $code_number . "030") {
				if ($max2 < $value['code_number']) {
					$max2 = $value['code_number'];
				}
			}
		}

		if ($max1) {
			$listdata[] = $max1;
		}

		if ($max2) {
			$listdata[] = $max2;
		}

		return $listdata;
	}

	public function getRelationshipLeadCustomer($id_lead, $id_customer, $source_status)
	{


		$model = new CustomerLead();

		if ($model->findByAttributes(array('id_lead' => $id_lead, 'id_customer' => $id_customer))) {

			$model->id_lead 	= $id_lead;
			$model->id_customer = $id_customer;
			$model->save(false);
		}
		return $model;
	}

	/* 	Dang ky khach hang => status = 0
		Dat lich thanh cong thi update => status = 1/ code_number

    */

	public function registerCustomer($dataCustomer = array('phone' => '', 'password' => '', 'repeatpassword' => '', 'fullname' => '', 'address' => '', 'email' => '', 'id_country' => '', 'gender' => '', 'birthdate' => '', 'source' => 1, 'status' => '', 'code_sms' => ''))
	{
		//return $dataCustomer['code_sms'];
		$model                 = new Customer();
		$model->attributes     = $dataCustomer;
		// $model->phone          = CsLead::model()->getVnPhone($model->phone);
		$model->phone_sms      = $model->phone;

		$model->repeatpassword = $dataCustomer['repeatpassword'];
		$model->password       = $model->password;
		$model->code_sms 	   = $dataCustomer['code_sms'];

		if ($model->validate()) {

			$id_lead = CsLead::model()->checkIdLeadPhone($dataCustomer['phone']);

			if ($id_lead) {
				$data =	CustomerLead::model()->addCustomerLead($dataCustomer, $id_lead);
				//return $data;
			} else {
				$data = CustomerLead::model()->addlead($dataCustomer);

				if ($data['status'] == 0) {
					$model->addError('phone', 'không hợp lệ.');
				}
			}
		}
		return  $model;
	}


	public function searchCustomers($and_conditions = '', $or_conditions = '', $additional = '', $lpp = '10', $cur_page = '1')
	{
		$lpp_org = $lpp;

		$con = Yii::app()->db;

		$sql = "select cs_schedule_edition.status status_schedule
			from customer
			left join ( select id_customer,status from cs_schedule where active = 1 and ( status = 2 OR status = 3 OR status = 6 ) order by status desc ) cs_schedule_edition
			on customer.id = cs_schedule_edition.id_customer
			where customer.status = 1 ";

		if ($and_conditions and is_array($and_conditions)) {
			foreach ($and_conditions as $k => $v) {
				$sql .= " and $k = '$v'";
			}
		} elseif ($and_conditions) {
			$sql .= " and $and_conditions";
		}

		if ($or_conditions and is_array($or_conditions)) {
			foreach ($or_conditions as $k => $v) {
				$sql .= " or $k = '$v'";
			}
		} elseif ($or_conditions) {
			$sql .= " or $or_conditions";
		}

		if ($additional) {
			$sql .= " $additional";
		}

		$num_row = count($con->createCommand($sql)->queryAll());


		if (!$num_row) return array('paging' => array('num_row' => '0', 'num_page' => '1', 'cur_page' => $cur_page, 'lpp' => $lpp, 'start_num' => 1), 'data' => '');

		if ($lpp == 'all') {
			$lpp = $num_row;
		}

		//  Page 1
		if ($num_row < $lpp) {
			$cur_page = 1;
			$num_page = 1;
			$lpp      = $num_row;
			$start    = 0;
		} else {
			// Tinh so can phan trang
			$num_page =  ceil($num_row / $lpp);

			// So trang hien tai lon hon tong so ph�n trang mot page
			if ($cur_page >=  $num_page) {
				$cur_page = $num_page;
				$lpp      =  $num_row - ($num_page - 1) * $lpp_org;
			}
			$start = ($cur_page - 1) * $lpp_org;
		}

		$sql = "select id,fullname,image,code_number,phone,email,gender,birthdate,identity_card_number,id_city,id_country,cs_schedule_edition.status status_schedule,address
			from customer
			left join ( select id_customer,status from cs_schedule where active = 1 and ( status = 2 OR status = 3 OR status = 6 ) order by status desc ) cs_schedule_edition
			on customer.id = cs_schedule_edition.id_customer
			where customer.status = 1 ";

		if ($and_conditions and is_array($and_conditions)) {
			foreach ($and_conditions as $k => $v) {
				$sql .= " and $k = '$v'";
			}
		} elseif ($and_conditions) {
			$sql .= " and $and_conditions";
		}

		if ($or_conditions and is_array($or_conditions)) {
			foreach ($or_conditions as $k => $v) {
				$sql .= " or $k = '$v'";
			}
		} elseif ($or_conditions) {
			$sql .= " or $or_conditions";
		}

		if ($additional) {
			$sql .= " $additional";
		}

		$sql .= " limit " . $start . "," . $lpp;


		$data = $con->createCommand($sql)->queryAll();

		return array('paging' => array('num_row' => $num_row, 'num_page' => $num_page, 'cur_page' => $cur_page, 'lpp' => $lpp_org, 'start_num' => $start + 1), 'data' => $data);
	}

	public function searchVSchedules($and_conditions = '', $or_conditions = '', $additional = '', $lpp = '10', $cur_page = '1')
	{
		$lpp_org = $lpp;

		$con = Yii::app()->db;

		$sql = "select status status_schedule from v_schedule where status_active = 1 and status >= 1 ";

		if ($and_conditions and is_array($and_conditions)) {
			foreach ($and_conditions as $k => $v) {
				$sql .= " and $k = '$v'";
			}
		} elseif ($and_conditions) {
			$sql .= " and $and_conditions";
		}

		if ($or_conditions and is_array($or_conditions)) {
			foreach ($or_conditions as $k => $v) {
				$sql .= " or $k = '$v'";
			}
		} elseif ($or_conditions) {
			$sql .= " or $or_conditions";
		}

		if ($additional) {
			$sql .= " $additional";
		}

		$num_row = count($con->createCommand($sql)->queryAll());


		if (!$num_row) return array('paging' => array('num_row' => '0', 'num_page' => '1', 'cur_page' => $cur_page, 'lpp' => $lpp, 'start_num' => 1), 'data' => '');

		if ($lpp == 'all') {
			$lpp = $num_row;
		}

		//  Page 1
		if ($num_row < $lpp) {
			$cur_page = 1;
			$num_page = 1;
			$lpp      = $num_row;
			$start    = 0;
		} else {
			// Tinh so can phan trang
			$num_page =  ceil($num_row / $lpp);

			// So trang hien tai lon hon tong so ph�n trang mot page
			if ($cur_page >=  $num_page) {
				$cur_page = $num_page;
				$lpp      =  $num_row - ($num_page - 1) * $lpp_org;
			}
			$start = ($cur_page - 1) * $lpp_org;
		}

		$sql = "select id_customer id,fullname,image_customer image,code_number,phone,status status_schedule from v_schedule where status_active = 1 and status >= 1 ";

		if ($and_conditions and is_array($and_conditions)) {
			foreach ($and_conditions as $k => $v) {
				$sql .= " and $k = '$v'";
			}
		} elseif ($and_conditions) {
			$sql .= " and $and_conditions";
		}

		if ($or_conditions and is_array($or_conditions)) {
			foreach ($or_conditions as $k => $v) {
				$sql .= " or $k = '$v'";
			}
		} elseif ($or_conditions) {
			$sql .= " or $or_conditions";
		}

		if ($additional) {
			$sql .= " $additional";
		}

		$sql .= " limit " . $start . "," . $lpp;


		$data = $con->createCommand($sql)->queryAll();

		return array('paging' => array('num_row' => $num_row, 'num_page' => $num_page, 'cur_page' => $cur_page, 'lpp' => $lpp_org, 'start_num' => $start + 1), 'data' => $data);
	}

	public function searchOpportunity($and_conditions = '', $or_conditions = '', $additional = '', $lpp = '10', $cur_page = '1')
	{
		$lpp_org = $lpp;

		$con = Yii::app()->db;

		$sql = "select count(*) from customer where status = 0 ";

		if ($and_conditions and is_array($and_conditions)) {
			foreach ($and_conditions as $k => $v) {
				$sql .= " and $k = '$v'";
			}
		} elseif ($and_conditions) {
			$sql .= " and $and_conditions";
		}

		if ($or_conditions and is_array($or_conditions)) {
			foreach ($or_conditions as $k => $v) {
				$sql .= " or $k = '$v'";
			}
		} elseif ($or_conditions) {
			$sql .= " or $or_conditions";
		}

		if ($additional) {
			$sql .= " $additional";
		}

		$num_row = $con->createCommand($sql)->queryScalar();


		if (!$num_row) return array('paging' => array('num_row' => '0', 'num_page' => '1', 'cur_page' => $cur_page, 'lpp' => $lpp, 'start_num' => 1), 'data' => '');

		if ($lpp == 'all') {
			$lpp = $num_row;
		}

		//  Page 1
		if ($num_row < $lpp) {
			$cur_page = 1;
			$num_page = 1;
			$lpp      = $num_row;
			$start    = 0;
		} else {
			// Tinh so can phan trang
			$num_page =  ceil($num_row / $lpp);

			// So trang hien tai lon hon tong so ph�n trang mot page
			if ($cur_page >=  $num_page) {
				$cur_page = $num_page;
				$lpp      =  $num_row - ($num_page - 1) * $lpp_org;
			}
			$start = ($cur_page - 1) * $lpp_org;
		}

		$sql = "select id,fullname,image,code_number,phone from customer where status = 0  ";
		if ($and_conditions and is_array($and_conditions)) {
			foreach ($and_conditions as $k => $v) {
				$sql .= " and $k = '$v'";
			}
		} elseif ($and_conditions) {
			$sql .= " and $and_conditions";
		}

		if ($or_conditions and is_array($or_conditions)) {
			foreach ($or_conditions as $k => $v) {
				$sql .= " or $k = '$v'";
			}
		} elseif ($or_conditions) {
			$sql .= " or $or_conditions";
		}

		if ($additional) {
			$sql .= " $additional";
		}

		$sql .= " limit " . $start . "," . $lpp;


		$data = $con->createCommand($sql)->queryAll();

		return array('paging' => array('num_row' => $num_row, 'num_page' => $num_page, 'cur_page' => $cur_page, 'lpp' => $lpp_org, 'start_num' => $start + 1), 'data' => $data);
	}

	public function update_customer($fullname, $address, $phone, $email, $id_country, $gender, $birthdate, $image, $id_job, $position, $organization, $note, $identity_card_number, $id)
	{
		$con = Yii::app()->db;
		$sql = "UPDATE customer SET fullname='$fullname',address='$address',phone='$phone',email='$email',id_country='$id_country',gender='$gender',birthdate='$birthdate',image='$image',id_job='$id_job',position='$position',organization='$organization',note='$note',identity_card_number='$identity_card_number' WHERE id='$id'";
		$data = $con->createCommand($sql)->execute();
		return $data;
	}
	public function update_customer_profile($fullname, $address, $phone, $email, $id_country, $gender, $birthdate, $id_job, $position, $organization, $note, $identity_card_number, $id)
	{
		$con = Yii::app()->db;
		$sql = "UPDATE customer SET fullname='$fullname',address='$address',phone='$phone',email='$email',id_country='$id_country',gender='$gender',birthdate='$birthdate',id_job='$id_job',position='$position',organization='$organization',note='$note',identity_card_number='$identity_card_number' WHERE id='$id'";
		$data = $con->createCommand($sql)->execute();
		return $data;
	}
	//đổi mật khẩu
	public function changePassword($password_old, $password_new, $password_new_confirm)
	{

		$customer = Customer::model()->findByPk(Yii::app()->user->getState('customer_id'));
		$password = $customer->password;
		if ($password == $password_old) {
			if ($password_new == $password_new_confirm) {
				$customer->password = $password_new;
				$customer->save(false);
				return 1;
			} else
				return -1;
		} else
			return -2;
	}
	public function update_code_customer($id_customer)
	{
		$code_number = Customer::model()->findByPk($id_customer)->code_number;
		if ($code_number == 0) {
			$code_number = $this->getCodeNumberCustomer();
			$con = Yii::app()->db;
			$sql = "UPDATE customer SET code_number = '$code_number', status = 1, activedate = NOW() WHERE id='$id_customer'";
			$data = $con->createCommand($sql)->execute();
			if ($data)
				return 1;		// cập nhật thành công
			else
				return 0;		// cập nhật thất bại
		} else
			return 1;		// đã có dữ liệu
	}

	public function getListSchedule($id_dentist = '', $id_patient = '', $id_branch = '', $id_chair = '')
	{
		$status = 0;
		$condition = '';
		if ($id_dentist) {
			$condition = $condition ? $condition . ' AND ' : $condition;
			$condition .= "id_dentist = " . $id_dentist;
		}
		if ($id_branch) {
			$condition = $condition ? $condition . ' AND ' : $condition;
			$condition .= "id_branch = " . $id_branch;
		}
		if ($id_chair) {
			$condition = $condition ? $condition . ' AND ' : $condition;
			$condition .= "id_chair = " . $id_chair;
		}
		if ($id_patient) {
			$condition = $condition ? $condition . ' AND ' : $condition;
			$condition .= "id_customer = " . $id_patient;
		}

		$condition = $condition ? $condition . ' AND ' : $condition;
		$condition .= "status > " . $status;

		$list = VSchedule::model()->findAll(array(
			'select' => '*',
			'order' => 'DATE(start_time)=DATE(NOW()) DESC, IF(DATE(start_time)=DATE(NOW()),start_time,DATE(NULL)) DESC, start_time DESC',
			'condition' => $condition,
		));

		if ($list)
			return $list;
		else
			return 0;
	}

	public function countMissAppointment($id_customer)
	{
		if (!$id_customer) {
			return;
		}

		$data = VSchedule::model()->findAllByAttributes(array('id_customer' => $id_customer, 'status' => -2));

		if ($data)
			return "<span style='color:gray;'>Bỏ hẹn: </span>" . count($data);
		else
			return "";
	}

	public function getSumBalance($id_customer)
	{
		if (!$id_customer) {
			return;
		}

		$debtArr = TransactionInvoice::model()->findAll(array(
			'select' => 'sum(amount) as amount',
			'condition' => "id_customer = $id_customer AND debt = " . TransactionInvoice::ConNo
		));

		if ($debtArr) {
			return "<span style='color:gray;'>Công nợ: </span>" . number_format($debtArr[0]['amount'], 0, ",", ".") . " VND";
		} else {
			return "";
		}
	}

	public function addNewCustomer($code_number, $fullname, $phone, $id_branch)
	{

		if (!$code_number) {
			return -4;
		}

		if (!is_numeric($code_number)) {
			return -6;
		}

		if (strlen($code_number) != 10) {
			return -7;
		}

		if (!$fullname) {
			return -1;
		}

		// if(!$phone){
		// 	return -2;
		// }

		if (!$id_branch) {
			return -3;
		}

		if (!$this->TestPrefix($phone)  && $phone != "") {
			return -8;
		}

		$customer = new Customer;

		if ($customer->findAllByAttributes(array('code_number' => $code_number)) == true) {
			return -5;
		}

		$phone    = $this->getVnPhone($phone);

		$customer->code_number = $code_number;
		$customer->id_branch   = $id_branch;
		$customer->fullname    = $fullname;
		$customer->phone       = $phone;
		$customer->phone_sms   = $phone;

		if ($customer->validate() && $customer->save()) {


			return $customer->id;
		}

		return 0;
	}

	// service

	public function getListMedicalHistoryGroupByCustomer($id_customer)
	{

		if (!$id_customer) {
			return -1;
		}

		return CsMedicalHistoryGroup::model()->getMedicalHistoryGroup($id_customer);
	}

	#region --- checkTreatment: KIEM TRA THONG TIN DOT DIEU TRI -
	/**
	 * Kiểm tra đợt điều trị chưa hoàn tất của khách hàng
	 *
	 * @param string $id_customer ID KH
	 * @return Object Thông tin đầy đủ của đợt điều trị
	 */
	public function checkTreatment($id_customer)
	{
		if (!$id_customer) {
			return -1;
		}

		$model = new CsMedicalHistoryGroup;

		$data = $model->findByAttributes(array('id_customer' => $id_customer, 'status' => 1));

		if (!$data) {
			return 0;
		}

		return $data;
	}
	#endregion

	public function checkAddNewTreatment($id_customer, $id_mhg = 0)
	{
		if (!$id_customer) {
			return -1;
		}

		if (!$id_mhg) {
			$data = $this->checkTreatment($id_customer);
			if ($data) {
				$id_mhg = $data->id;
			}
		}
		// $result = $this->checkChangeStatusProcess($id_customer);

		$checkStatusProcess = CsMedicalHistoryGroup::model()->findByAttributes(array('id' => $id_mhg, 'status_process' => 1));

		if (!$checkStatusProcess) {
			return 0;
		}

		return 1;
	}

	public function checkChangeStatusProcess($id_customer, $id_mhg = 0)
	{
		if (!$id_customer) {
			return -1;
		}

		if (!$id_mhg) {
			$data = $this->checkTreatment($id_customer);
			if ($data) {
				$id_mhg = $data->id;
			}
		}

		$listToothData = ToothData::model()->findByAttributes(array('id_group_history' => $id_mhg));
		$listMedicalHistory = CsMedicalHistory::model()->findByAttributes(array('id_history_group' => $id_mhg, 'status' => 1));

		if (!$listToothData || !$listMedicalHistory) {
			return 0;
		}

		return 1;
	}

	#region --- THEM MOI DOT DIEU TRI
	public function addTreatment($id_customer)
	{
		if (!$id_customer) {
			return -1;
		}

		$model = new CsMedicalHistoryGroup;

		$treatment = $this->checkTreatment($id_customer);

		$id_mhg = $treatment ? $treatment->id : false;

		if ($id_mhg) {
			$data = $model->findByPk($id_mhg);
			$data->status = 0;
			$data->update();
		}

		$model->id_customer = $id_customer;
		$model->name = count($model->findAllByAttributes(array('id_customer' => $id_customer))) + 1;
		$model->status = 1;
		$model->status_process = 0;

		unset($model->createdata);

		if ($model->save())
			return $model->id;
		else
			return 0;
	}
	#endregion

	public function addNewMedicalHistoryAlert($id_customer, $chk_medical_history, $ipt_medical_history, $id_dentist)
	{

		if (!$id_customer || !$id_dentist) {
			return -1;
		}


		if ($chk_medical_history) {

			for ($i = 0; $i < count($chk_medical_history); $i++) {
				$model = new CsMedicalHistoryAlert;
				$model->id_customer = $id_customer;
				$model->id_medicine_alert = $chk_medical_history[$i];
				if ($ipt_medical_history) {
					$model->note = $ipt_medical_history[$i];
				}
				$model->id_dentist = $id_dentist;
				$model->save();
			}
		}

		return 1;
	}

	public function checkMedicalHistory($id_customer)
	{

		if (!$id_customer) {
			return -1;
		}

		$data = CsMedicalHistoryAlert::model()->findByAttributes(array('id_customer' => $id_customer));

		if (!$data) {
			return 0;
		}

		return 1;
	}

	public function updateMedicalHistoryAlert($id_customer, $chk_medical_history, $ipt_medical_history)
	{

		if (!$id_customer) {
			return -1;
		}

		CsMedicalHistoryAlert::model()->deleteAllByAttributes(array('id_customer' => $id_customer));

		if ($chk_medical_history) {

			for ($i = 0; $i < count($chk_medical_history); $i++) {
				$model = new CsMedicalHistoryAlert;
				$model->id_customer = $id_customer;
				$model->id_medicine_alert = $chk_medical_history[$i];
				if ($ipt_medical_history) {
					$model->note = $ipt_medical_history[$i];
				}
				$model->save();
			}
		}

		return 1;
	}

	public function addDetailTreatment($id_customer, $id_mhg, $status_healthy, $chk_medical_history, $id_dentist)
	{

		if (!$id_customer || !$id_mhg || !$id_dentist) {
			return -1;
		}

		$data = CsMedicalHistoryGroup::model()->findByPk($id_mhg);
		$data->status_healthy = $status_healthy;
		if ($data->update() && $chk_medical_history) {

			for ($i = 0; $i < count($chk_medical_history); $i++) {
				$model = new CsMedicalHistoryAlert;
				$model->id_customer = $id_customer;
				$model->id_medicine_alert = $chk_medical_history[$i];
				$model->id_group_history = $id_mhg;
				$model->id_dentist = $id_dentist;
				$model->save();
			}
		}

		return 1;
	}

	public function updateTreatment($id_mhg)
	{

		if (!$id_mhg) {
			return -1;
		}

		$data = CsMedicalHistoryGroup::model()->findByPk($id_mhg);
		$data->status_process = 1;

		if ($data->update()) {

			return 1;
		}
	}

	public function getListTreatmentProcess($id_customer, $id_mhg)
	{
		if (!$id_customer || !$id_mhg) {
			return -1;
		}

		$listOrderDetail = Yii::app()->db->createCommand()
			->select('v_order_detail.id,v_order_detail.user_name,v_order_detail.services_name,v_order_detail.product_name,v_order_detail.create_date,v_order_detail.branch_name,v_order_detail.code')
			->from('v_order_detail')
			->where('v_order_detail.id_customer=:id_customer', array(':id_customer' => $id_customer))
			->andwhere('v_order_detail.id_group_history=:id_group_history', array(':id_group_history' => $id_mhg))
			->andwhere('v_order_detail.services_name!=""')
			->queryAll();

		if ($listOrderDetail) {
			$data = array();
			foreach ($listOrderDetail as $key => $value) {
				$listMedicalHistory = Yii::app()->db->createCommand()
					->select('v_medical_history.id,v_medical_history.gp_users_name,v_medical_history.createdate')
					->from('v_medical_history')
					->where('v_medical_history.id_history_group=:id_history_group', array(':id_history_group' => $id_mhg))
					->andWhere('v_medical_history.id_order_detail=:id_order_detail', array(':id_order_detail' => $value['id']))
					->andWhere('v_medical_history.status=1')
					->order('v_medical_history.createdate DESC')
					->queryAll();

				$data[$key] = array('id' => $value['id'], 'user_name' => $value['user_name'], 'services_name' => $value['services_name'], 'product_name' => $value['product_name'], 'create_date' => $value['create_date'], 'branch_name' => $value['branch_name'], 'code' => $value['code'], 'listMedicalHistory' => $listMedicalHistory);
			}
			return $data;
		}
	}

	public function getListTreatmentProcessOfCustomer($id_mhg)
	{
		if (!$id_mhg) {
			return -1;
		}

		$listTreatmentProcess = Yii::app()->db->createCommand()
			->select('v_medical_history.id,v_medical_history.gp_users_name,v_medical_history.description,v_medical_history.medicine_during_treatment,v_medical_history.createdate,v_medical_history.reviewdate,v_medical_history.id_dentist,v_medical_history.length_time,prescription.id id_prescription,labo.id id_labo')
			->from('v_medical_history')
			->where('v_medical_history.id_history_group=:id_history_group', array(':id_history_group' => $id_mhg))
			->andWhere('v_medical_history.status=1')
			->leftJoin('prescription', 'prescription.id_medical_history = v_medical_history.id')
			->leftJoin('labo', 'labo.id_medical_history = v_medical_history.id')
			->order('v_medical_history.createdate DESC')
			->queryAll();

		if ($listTreatmentProcess) {
			$data = array();
			foreach ($listTreatmentProcess as $key => $value) {
				$listTreatmentWork = Yii::app()->db->createCommand()
					->select('treatment_work.tooth_numbers,treatment_work.treatment_work')
					->from('treatment_work')
					->where('treatment_work.id_medical_history=:id_medical_history', array(':id_medical_history' => $value['id']))
					->queryAll();

				$data[$key] = array('id' => $value['id'], 'gp_users_name' => $value['gp_users_name'], 'description' => $value['description'], 'medicine_during_treatment' => $value['medicine_during_treatment'], 'createdate' => $value['createdate'], 'reviewdate' => $value['reviewdate'], 'id_dentist' => $value['id_dentist'], 'length_time' => $value['id_dentist'], 'id_prescription' => $value['id_prescription'], 'id_labo' => $value['id_labo'], 'listTreatmentWork' => $listTreatmentWork);
			}
			return $data;
		}
	}

	public function addMedicalHistory($id_customer, $id_history_group, $id_user, $id_dentist, $id_branch, $treatment_work, $tooth_numbers, $session_add_prescription, $session_add_lab, $createdate, $reviewdate, $description, $newest_schedule = '')
	{

		if (!$id_history_group || !$id_user || !$id_dentist || !$treatment_work) {
			return -1;
		}
		$createdate = $createdate . ' 00::00:00';
		$model = new CsMedicalHistory;
		$model->id_history_group = $id_history_group;
		$model->id_user          = $id_user;
		$model->id_dentist       = $id_dentist;
		$model->createdate 		 = $createdate;
		$model->reviewdate       = $reviewdate;
		$model->description      = $description;
		$model->newest_schedule  = $newest_schedule;

		if (!$model->reviewdate) {
			unset($model->reviewdate);
		}
		//unset($model->createdate);

		if ($model->save()) {

			for ($i = 0; $i < count($treatment_work); $i++) {
				$TreatmentWork                     = new TreatmentWork;
				$TreatmentWork->id_medical_history = $model->id;
				$TreatmentWork->treatment_work     = $treatment_work[$i];

				if (isset($tooth_numbers[$i]) && $tooth_numbers[$i]) {
					$TreatmentWork->tooth_numbers = implode(",", $tooth_numbers[$i]);
				}

				$TreatmentWork->save();
			}

			if ($session_add_prescription) {

				$data = new Prescription;
				$data->id_group_history   = $id_history_group;
				$data->id_medical_history = $model->id;
				$data->diagnose 		  = $session_add_prescription['diagnose'];
				$data->advise 		      = $session_add_prescription['advise'];
				$data->examination_after  = $session_add_prescription['examination_after'];

				if ($data->save()) {

					for ($i = 0; $i < count($session_add_prescription['drug_name']); $i++) {
						if ($session_add_prescription['drug_name'][$i] != "") {

							$result = new DrugAndUsage;
							$result->id_prescription   = $data->id;
							$result->drug_name   	   = $session_add_prescription['drug_name'][$i];
							$result->times   		   = $session_add_prescription['times'][$i];
							$result->dosage   		   = $session_add_prescription['dosage'][$i];
							$result->save();
						}
					}

					unset(Yii::app()->session['add_prescription']);
				}
			}

			if ($session_add_lab) {

				$labo = new Labo;
				$labo->id_group_history   = $id_history_group;
				$labo->id_medical_history = $model->id;
				$labo->attributes		  = $session_add_lab;

				if ($labo->validate() && $labo->save()) {

					unset(Yii::app()->session['add_lab']);
				}
			}

			return 1;
		}
	}

	public function updateMedicalHistory($id_medical_history, $id_customer, $id_history_group, $id_user, $id_dentist, $id_branch, $treatment_work, $tooth_numbers, $createdate, $reviewdate, $description, $newest_schedule = '')
	{

		if (!$id_medical_history || !$id_user || !$id_dentist || !$treatment_work) {
			return -1;
		}

		$model = CsMedicalHistory::model()->findByPk($id_medical_history);

		$model->id_user         = $id_user;
		$model->id_dentist      = $id_dentist;
		$model->createdate 		= $createdate;
		$model->reviewdate      = $reviewdate;
		$model->description     = $description;
		$model->newest_schedule = $newest_schedule;

		if ($model->update()) {

			TreatmentWork::model()->deleteAllByAttributes(array('id_medical_history' => $model->id));

			for ($i = 0; $i < count($treatment_work); $i++) {
				$TreatmentWork                     = new TreatmentWork;
				$TreatmentWork->id_medical_history = $model->id;
				$TreatmentWork->treatment_work     = $treatment_work[$i];

				if (isset($tooth_numbers[$i]) && $tooth_numbers[$i]) {
					$TreatmentWork->tooth_numbers = implode(",", $tooth_numbers[$i]);
				}

				$TreatmentWork->save();
			}

			return 1;
		}
	}

	public function deleteMedicalHistory($id_medical_history)
	{

		if (!$id_medical_history) {
			return -1;
		}

		$model = CsMedicalHistory::model()->findByPk($id_medical_history);;
		$model->status             = 0;

		if ($model->update()) {
			return 1;
		}
	}

	public function getMedicalHistoryById($id)
	{
		$getMedicalHistoryById = Yii::app()->db->createCommand()
			->select('cs_medical_history.id,cs_medical_history.createdate as createdate_cs_medical_history, cs_medical_history.id_dentist, cs_medical_history.description, cs_medical_history.length_time, cs_medical_history.medicine_during_treatment, cs_medical_history.reviewdate, cs_medical_history.id_note,cs_medical_history.newest_schedule, prescription.id id_prescription, prescription.diagnose, prescription.advise, prescription.examination_after, prescription.createdate, gp_users.name dentist, labo.id_branch, labo.id_dentist id_d3ntist, labo.sent_date, labo.received_date, labo.assign, labo.note,labo.id as id_labo')
			->from('cs_medical_history')
			->where('cs_medical_history.id =:id', array(':id' => $id))
			->leftJoin('prescription', 'prescription.id_medical_history = cs_medical_history.id')
			->leftJoin('labo', 'labo.id_medical_history = cs_medical_history.id')
			->leftJoin('gp_users', 'gp_users.id = cs_medical_history.id_dentist')
			->queryRow();

		$listTreatmentWork = Yii::app()->db->createCommand()
			->select('treatment_work.treatment_work, treatment_work.tooth_numbers')
			->from('treatment_work')
			->where('treatment_work.id_medical_history =:id_medical_history', array(':id_medical_history' => $id))
			->queryAll();

		$listDrugAndUsage = Yii::app()->db->createCommand()
			->select('drug_and_usage.drug_name, drug_and_usage.times, drug_and_usage.dosage')
			->from('drug_and_usage')
			->where('drug_and_usage.id_prescription =:id_prescription', array(':id_prescription' => $getMedicalHistoryById['id_prescription']))
			->queryAll();

		if ($getMedicalHistoryById['id_note'] && $getMedicalHistoryById['id_note'] > 0) {
			$data = CustomerNote::model()->findByPk($getMedicalHistoryById['id_note']);
			if ($data['status'] == -1) {
				$getMedicalHistoryById['description'] = '';
			} else {
				$getMedicalHistoryById['description'] = $data['note'];
			}
		}

		$getMedicalHistoryById['listTreatmentWork'] = $listTreatmentWork;

		$getMedicalHistoryById['listDrugAndUsage'] = $listDrugAndUsage;

		return $getMedicalHistoryById;
	}

	public function getListName($id_customer, $id_mhg)
	{
		return  $data   = Yii::app()->db->createCommand()
			->select('cs_medical_image.id,cs_medical_image.name')
			->from('cs_medical_image')
			->where('cs_medical_image.id_customer =:id_customer', array(':id_customer' => $id_customer))
			->andWhere('cs_medical_image.id_group_history =:id_group_history', array(':id_group_history' => $id_mhg))
			->queryAll();
	}

	#region --- LAY ID LICH HEN VAO KHAM/ DIEU TRI
	/**
	 * Lấy ID Schedule đang vào khám hoặc điều trị của khách hàng (1 KH chỉ có thể có 1 lịch điều trị hoặc vào khám)
	 *
	 * @param string $id_customer id KH
	 * @return string ID Lịch hẹn của  (chuỗi "" nếu không có lịch hẹn thoả)
	 */
	public function getIdScheduleByIdCustomer($id_customer)
	{
		$data = Yii::app()->db->createCommand()
			->select('cs_schedule.id')
			->from('cs_schedule')
			->where('cs_schedule.id_customer =:id_customer', array(':id_customer' => $id_customer))
			->andWhere('cs_schedule.status = 3 OR cs_schedule.status = 6')
			->andWhere('cs_schedule.active = 1')
			->queryRow();

		if ($data) {
			return $data['id'];
		}

		return "";
	}
	#endregion


	public function checkWaitingSchedule($id_customer)
	{
		$data   = Yii::app()->db->createCommand()
			->select('cs_schedule.id')
			->from('cs_schedule')
			->where('cs_schedule.id_customer =:id_customer', array(':id_customer' => $id_customer))
			->andWhere('cs_schedule.active = 1 AND cs_schedule.status = 2')
			->queryRow();

		if (!$data) {
			return 0;
		}

		return $data;
	}

	// dang ki khach hang admin
	public function addCustomer($dataCustomer = array())
	{
		$model = new Customer();

		if ($dataCustomer['code_number']) {
			if ($model->findAllByAttributes(array('code_number' => $dataCustomer['code_number'])) == true) {
				return -5;
			}

			$model->code_number = $dataCustomer['code_number'];
		} else {
			unset($dataCustomer['code_number']);
			$dataCustomer['status'] = 0;
		}

		$model->attributes = $dataCustomer;
		$model->repeatpassword = md5(Yii::app()->params['pass']);
		$model->password = md5(Yii::app()->params['pass']);

		if (isset($dataCustomer['email']) && $dataCustomer['email'] == '')
			unset($model->email);

		if (!isset($dataCustomer['phone_sms']) || !$dataCustomer['phone_sms']) {
			$model->phone_sms = $model->phone;
		}

		if ($model->validate() && $model->save()) {
			if (isset($dataCustomer['id_segment']) && $dataCustomer['id_segment']) {
				$customerSegment = new CustomerSegment();

				$customerSegment->attributes = $model->attributes;
				$customerSegment->id_customer = $model->id;

				$customerSegment->id_segment = $dataCustomer['id_segment'];

				$customerSegment->save(false);
			}

			if (!isset($dataCustomer['code_number'])) {

				$cs_lead = new CsLead;
				$cs_lead->phone = $model->phone;

				if ($cs_lead->validate() && $cs_lead->save()) {

					$relationshipLeadCustomer = CustomerLead::model()->getRelationshipLeadCustomer($cs_lead->id, $model->id);

					if ($relationshipLeadCustomer) {
						return array('status' => 1, 'data' => $model);
					}
				}
			}

			return array('status' => 1, 'data' => $model);
		} else {
			$error = $model->getErrors();
			if ($error !== '[]')
				return $error;
		}
	}

	public function checkCodeNumberExist($code_number)
	{
		if (Customer::model()->findAllByAttributes(array('code_number' => $code_number)) == true) {
			return 1;
		}

		return 0;
	}

	public function updateToCustomer($id, $code_number)
	{

		$customer = new Customer;

		if (!$id) {
			return -1;
		}

		if (!$code_number) {
			return -2;
		}

		if ($customer->findAllByAttributes(array('code_number' => $code_number)) == true) {

			return -3;
		}

		$result = $customer->updateByPk($id, array('code_number' => $code_number, 'status' => 1));

		if ($result) {
			//them dot dieu tri	1
			return $this->addTreatment($id);
			//end them dot dieu tri	1
		} else {

			return $result;
		}
	}

	public function addCsMedicalImage($name, $id_user, $id_customer, $name_upload, $id_mhg)
	{

		if (!$name || !$id_user || !$id_customer || !$name_upload || !$id_mhg) {
			return -1;
		}

		$model = new CsMedicalImage;

		$data = $model->findByAttributes(array('id_customer' => $id_customer, 'id_group_history' => $id_mhg, 'name' => $name));

		if ($data) {
			return 1;
		}

		$model->name                      = $name;
		$model->id_user                   = $id_user;
		$model->id_customer               = $id_customer;
		$model->id_group_history          = $id_mhg;
		$model->name_upload               = $name_upload;

		if ($model->save()) {
			return 1;
		}
	}

	public function checkToothData($id_mhg)
	{

		if (!$id_mhg) {
			return -1;
		}

		$model = new ToothData;

		$data = $model->findByAttributes(array('id_group_history' => $id_mhg));

		if (!$data) {
			return 0;
		}

		return 1;
	}

	public function getIdBranchByIdUser($id_user)
	{

		if (!$id_user) {
			return -1;
		}

		$model = new GpUsers;

		$data = $model->findByPk($id_user);

		if (!$data) {
			return 0;
		}

		return $data->id_branch;
	}

	public function updateCustomer($id_customer, $code_number, $membership_card, $fullname, $email, $phone, $phone_sms, $gender, $birthdate, $identity_card_number, $id_country, $id_source, $id_job, $position, $address, $flag, $last_day, $note, $nickname, $phone2, $city, $county, $branch)
	{
		if (!$id_customer) {
			return -1;
		}

		$model = new Customer;

		if ($email) {
			$search_email = $model->findAllByAttributes(array('email' => $email));
			if ($search_email && $search_email[0]['id'] != $id_customer) {
				return -2;
			}
		} else {
			$email = null;
		}

		return $result = $model->updateByPk($id_customer, array('code_number' => $code_number, 'membership_card' => $membership_card, 'fullname' => $fullname, 'email' => $email, 'phone' => $phone, 'phone_sms' => $phone_sms, 'gender' => $gender, 'birthdate' => $birthdate, 'identity_card_number' => $identity_card_number, 'id_country' => $id_country, 'id_source' => $id_source, 'flag' => $flag, 'id_job' => $id_job, 'position' => $position, 'address' => $address, 'last_day' => $last_day, 'note' => $note, 'nickname' => $nickname, 'phone2' => $phone2, 'city' => $city, 'county' => $county, 'id_branch' => $branch));
	}

	public function updateCustomerSegment($id_customer, $id_segment)
	{

		if (!$id_customer) {
			return -1;
		}

		$model = new CustomerSegment;

		if (!$id_segment) {
			return $result = $model->deleteAllByAttributes(array('id_customer' => $id_customer));
		}

		$data = $model->findByAttributes(array('id_customer' => $id_customer));

		if (!$data) {

			$customer = Yii::app()->db->createCommand()
				->select('customer.*')
				->from('customer')
				->where('id=:id', array(':id' => $id_customer))
				->queryAll();

			$model->id_customer = $id_customer;
			$model->id_segment  = $id_segment;
			$model->attributes 	= $customer[0];

			if ($model->validate() && $model->save()) {

				return 1;
			}
		}

		return $result = $model->updateByPk($data->id, array('id_segment' => $id_segment));
	}

	public function updateStatusScheduleOfCustomer($id_customer, $status_schedule)
	{

		if (!$id_customer || !$status_schedule) {
			return -1;
		}

		return $result = Customer::model()->updateByPk($id_customer, array('status_schedule' => $status_schedule));
	}

	public function checkNewestTreatmentExistQuotation($id_customer)
	{

		if (!$id_customer) {
			return -1;
		}

		$treatment = $this->checkTreatment($id_customer);

		$id_mhg = $treatment ? $treatment->id : $treatment;

		if ($id_mhg) {

			$data = $this->existQuotation($id_customer, $id_mhg);

			if (count($data) > 0) {
				return $data->id;
			} else {
				return '';
			}
		}

		return '';
	}

	public function checkExistPrescription($id_medical_history)
	{

		if (!$id_medical_history) {
			return -1;
		}

		$data = Prescription::model()->findByAttributes(array('id_medical_history' => $id_medical_history));

		if (!$data) {
			return 0;
		}

		return $data->id;
	}

	public function checkExistLabo($id_medical_history)
	{

		if (!$id_medical_history) {
			return -1;
		}

		$data = Labo::model()->findByAttributes(array('id_medical_history' => $id_medical_history));

		if (!$data) {
			return 0;
		}

		return $data->id;
	}

	public function savePrescription($savePrescription = array('id_group_history' => '', 'id_medical_history' => '', 'diagnose' => '', 'drug_name' => '', 'times' => '', 'dosage' => '', 'advise' => '', 'examination_after' => ''))
	{

		if (!$savePrescription['id_medical_history']) {
			return -1;
		}

		$mP    = new Prescription;

		$cEP   = $this->checkExistPrescription($savePrescription['id_medical_history']);

		if ($cEP == 0) {

			$mP->attributes = $savePrescription;

			if ($mP->validate() && $mP->save()) {

				for ($i = 0; $i < count($savePrescription['drug_name']); $i++) {
					$mDAU                    = new DrugAndUsage;
					$mDAU->id_prescription   = $mP->id;
					$mDAU->drug_name   	     = $savePrescription['drug_name'][$i];
					$mDAU->times   		     = $savePrescription['times'][$i];
					$mDAU->dosage   		 = $savePrescription['dosage'][$i];
					$mDAU->save();
				}

				return 1;
			} else {
				return 0;
			}
		} else {

			$uP              = Prescription::model()->findByPk($cEP);
			$uP->attributes	 = $savePrescription;

			if ($uP->validate() && $uP->save()) {

				DrugAndUsage::model()->deleteAllByAttributes(array('id_prescription' => $uP->id));

				for ($i = 0; $i < count($savePrescription['drug_name']); $i++) {
					$mDAU                    = new DrugAndUsage;
					$mDAU->id_prescription   = $uP->id;
					$mDAU->drug_name   	     = $savePrescription['drug_name'][$i];
					$mDAU->times   		     = $savePrescription['times'][$i];
					$mDAU->dosage   		 = $savePrescription['dosage'][$i];
					$mDAU->save();
				}

				return 1;
			} else {
				return 0;
			}
		}
	}

	public function saveLab($saveLab = array('id_group_history' => '', 'id_medical_history' => '', 'id_branch' => '', 'id_dentist' => '', 'sent_date' => '', 'received_date' => '', 'assign' => '', 'note' => ''))
	{

		if (!$saveLab['id_medical_history']) {
			return -1;
		}

		$mP    = new Labo;

		$cEP   = $this->checkExistLabo($saveLab['id_medical_history']);

		if ($cEP == 0) {

			$mP->attributes = $saveLab;

			if ($mP->validate() && $mP->save()) {


				return 1;
			} else {
				return 0;
			}
		} else {

			$uP              = Labo::model()->findByPk($cEP);
			$uP->attributes	 = $saveLab;

			if ($uP->validate() && $uP->save()) {

				return 1;
			} else {
				return 0;
			}
		}
	}

	public function getEvaluateStateOfTartar($id_mhg)
	{
		if (!$id_mhg) {
			return -1;
		}

		return $data = CsMedicalHistoryGroup::model()->findByPk($id_mhg);
	}

	public function updateEvaluateStateOfTartar($id_mhg, $evaluate_state_of_tartar)
	{
		if (!$id_mhg || !$evaluate_state_of_tartar) {
			return -1;
		}

		return $result = CsMedicalHistoryGroup::model()->updateByPk($id_mhg, array('evaluate_state_of_tartar' => $evaluate_state_of_tartar));
	}
	/*----------------------------------------------------------------------------------------------------------------------------------------*/
	/*LMV baocao customer*/
	/*public function getselect($time, $id_user, $location){
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.*, b.id_branch FROM customer a INNER JOIN cs_schedule b WHERE a.status = 1 ";
		if($time == 3  ){
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
		    $todate= date("Y-m-t", strtotime("last day of this month"));

			$sql.= " and   DATE(  a.`createdate` ) > '".$fromdate."' and  DATE(  a.`createdate` ) <  '".$todate."' ";

		}
		elseif($time == 1 ){
			$fromdate = date("Y-m-d");
			$sql.= " and   DATE(  a.`createdate` ) = '".$fromdate."'";

		}

		elseif($time == 5 ){
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
    		$todate= date("Y-m-d", strtotime('last day of last month'));

			$sql.= "  and   DATE(  `createdate` ) > '".$fromdate."' and  DATE(  `createdate` ) <  '".$todate."' ";

		}

		elseif($time == 2 ){
			$fromdate = date("Y-m-d",strtotime('monday this week'));
			$todate= date("Y-m-d",strtotime('sunday this week'));
			$sql.= " and   DATE(  a.`createdate` ) > '".$fromdate."' and  DATE(  a.`createdate` ) <  '".$todate."' ";
		}
		if($id_user != "" ){

			$sql.= " and  a.id = b.id_customer";


			$sql.=" and b.id_dentist = '".$id_user."'";



		}
		if ($location != '') {
			$sql.= " and b.id_branch = '".$location."'";
		}
			$sql .= " limit 0, 50";

		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}
	public function getselectprint($time, $id_user, $location){
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.*, b.id_branch FROM customer a INNER JOIN cs_schedule b WHERE a.status = 1 ";
		if($time == 3  ){
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
		    $todate= date("Y-m-t", strtotime("last day of this month"));

			$sql.= " and   DATE(  a.`createdate` ) > '".$fromdate."' and  DATE(  a.`createdate` ) <  '".$todate."' ";

		}
		elseif($time == 1 ){
			$fromdate = date("Y-m-d");
			$sql.= " and   DATE(  a.`createdate` ) = '".$fromdate."'";

		}

		elseif($time == 5 ){
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
    		$todate= date("Y-m-d", strtotime('last day of last month'));

			$sql.= "  and   DATE(  `createdate` ) > '".$fromdate."' and  DATE(  `createdate` ) <  '".$todate."' ";

		}

		elseif($time == 2 ){
			$fromdate = date("Y-m-d",strtotime('monday this week'));
			$todate= date("Y-m-d",strtotime('sunday this week'));
			$sql.= " and   DATE(  a.`createdate` ) > '".$fromdate."' and  DATE(  a.`createdate` ) <  '".$todate."' ";
		}
		if($id_user != "" ){

			$sql.= " and  a.id = b.id_customer";


			$sql.=" and b.id_dentist = '".$id_user."'";



		}
		if ($location != '') {
			$sql.= " and b.id_branch = '".$location."'";
		}
			$sql .= " limit 0, 50";

		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}*/
	/*birthdate*/
	/*public function getselectbirthdate($time, $id_user, $location){
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.*, b.id_branch FROM customer a INNER JOIN cs_schedule b WHERE a.status = 1 ";
		if($time == 3  ){
			$fromdate = date("m", strtotime("first day of this month"));
		    $todate= date("Y-m-t", strtotime("last day of this month"));

			$sql.= " and   MONTH(  a.`birthdate` ) = '".$fromdate."' ";

		}
		elseif($time == 1 ){
			$fromdate = date("m-d");
			$sql.= " and  DATE_FORMAT(a.`birthdate`, '%m-%d') = '".$fromdate."'";

		}
		elseif($time == 4 ){
			$fromdate = date("m-d", strtotime('first day of next month'));
    		$todate= date("m-d", strtotime('last day of next month'));

			$sql.= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '".$fromdate."' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '".$todate."' ";

		}

		elseif($time == 5 ){
			$fromdate = date("m-d", strtotime('first day of last month'));
    		$todate= date("m-d", strtotime('last day of last month'));

			$sql.= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '".$fromdate."' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '".$todate."' ";

		}

		elseif($time == 2 ){
			$fromdate = date("m-d",strtotime('monday this week'));
			$todate= date("m-d",strtotime('sunday this week'));
			$sql.= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '".$fromdate."' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '".$todate."' ";
		}



		if($id_user != "" ){

			$sql.= " and  a.id = b.id_customer";


			$sql.=" and b.id_dentist = '".$id_user."'";



		}
		if ($location != '') {
			$sql.= " and b.id_branch = '".$location."'";
		}
			$sql .= " limit 0, 50";

		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}

	public function getcountlichhen($id){
		$con = Yii::app()->db;
		$sql = "SELECT * FROM `v_quotations` WHERE id_customer = '".$id."'";
		$data = $con->createCommand($sql)->queryAll();
		return count($data);
	}
	public function getcountservice($id){
		$con = Yii::app()->db;
		$sql = " SELECT DISTINCT id_service FROM `v_invoice_detail` WHERE id_customer = '".$id."'";
		$data = $con->createCommand($sql)->queryAll();
		return count($data);
	}
	public function getsuminvoice($id){
		$con = Yii::app()->db;

		$sql = "SELECT SUM(sum_amount) AS sumnount FROM `v_invoice` WHERE id_customer = '".$id."'";
		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}*/
	/*----------------------------------------------------------------------------------------------------------------------------------------*/
	/*LMV baocao customer*/
	public function getselect($time, $id_user, $location, $date)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.*, b.id_branch FROM customer a INNER JOIN cs_schedule b WHERE a.status = 1 ";
		if ($time == 3) {
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));

			$sql .= " and   DATE(  a.`createdate` ) > '" . $fromdate . "' and  DATE(  a.`createdate` ) <  '" . $todate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("Y-m-d");
			$sql .= " and   DATE(  a.`createdate` ) = '" . $fromdate . "'";
		} elseif ($time == 5) {
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
			$todate = date("Y-m-d", strtotime('last day of last month'));

			$sql .= "  and   DATE(  `createdate` ) > '" . $fromdate . "' and  DATE(  `createdate` ) <  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("Y-m-d", strtotime('monday this week'));
			$todate = date("Y-m-d", strtotime('sunday this week'));
			$sql .= " and   DATE(  a.`createdate` ) > '" . $fromdate . "' and  DATE(  a.`createdate` ) <  '" . $todate . "' ";
		} elseif ($time == 0) {
			$date = explode('+', $date);
			$fromdate = date("Y-m-d", strtotime($date[0]));
			$todate = date("Y-m-d", strtotime($date[1]));
			$sql .= " and   DATE(  a.`createdate` ) > '" . $fromdate . "' and  DATE(  a.`createdate` ) <  '" . $todate . "' ";
		}
		/*
		elseif($time == 5 && $id_user == "" && $location != ''){
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
    		$todate= date("Y-m-d", strtotime('last day of last month'));


			$sql.= " and   DATE(  a.`createdate` ) > '".$fromdate."' and  DATE(  a.`createdate` ) <  '".$todate."' ";

			$sql.= " and a.id_branch = '".$location."'";


		}*/

		if ($id_user != "") {

			$sql .= " and  a.id = b.id_customer";


			$sql .= " and b.id_dentist = '" . $id_user . "'";
		}
		if ($location != '') {
			$sql .= " and b.id_branch = '" . $location . "'";
		}
		$sql .= " limit 0, 50";

		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}	/*print*/
	public function getselectprint($time, $id_user, $location, $date_start, $date_end)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.*, b.id_branch FROM customer a INNER JOIN cs_schedule b WHERE a.status = 1 ";
		if ($time == 0) {


			//$fromdate=date("Y-m-d", strtotime($date[0]));
			$todate = date("Y-m-d", strtotime($date_end));
			$fromdate = date("Y-m-d", strtotime($date_start));
			//$todate= date("Y-m-d", strtotime($date[0]));

			$sql .= " and   DATE(  a.`createdate` ) > '" . $fromdate . "' and  DATE(  a.`createdate` ) <  '" . $todate . "' ";
		} elseif ($time == 3) {
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));

			$sql .= " and   DATE(  a.`createdate` ) > '" . $fromdate . "' and  DATE(  a.`createdate` ) <  '" . $todate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("Y-m-d");
			$sql .= " and   DATE(  a.`createdate` ) = '" . $fromdate . "'";
		} elseif ($time == 5) {
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
			$todate = date("Y-m-d", strtotime('last day of last month'));

			$sql .= "  and   DATE(  `createdate` ) > '" . $fromdate . "' and  DATE(  `createdate` ) <  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("Y-m-d", strtotime('monday this week'));
			$todate = date("Y-m-d", strtotime('sunday this week'));
			$sql .= " and   DATE(  a.`createdate` ) > '" . $fromdate . "' and  DATE(  a.`createdate` ) <  '" . $todate . "' ";
		}

		/*
		elseif($time == 5 && $id_user == "" && $location != ''){
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
    		$todate= date("Y-m-d", strtotime('last day of last month'));


			$sql.= " and   DATE(  a.`createdate` ) > '".$fromdate."' and  DATE(  a.`createdate` ) <  '".$todate."' ";

			$sql.= " and a.id_branch = '".$location."'";


		}*/

		if ($id_user != "") {

			$sql .= " and  a.id = b.id_customer";


			$sql .= " and b.id_dentist = '" . $id_user . "'";
		}
		if ($location != '') {
			$sql .= " and b.id_branch = '" . $location . "'";
		}
		$sql .= " limit 0, 150";

		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}
	/*birthdate*/
	public function getselectbirthdate($time, $id_user, $location, $date)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.*, b.id_branch FROM customer a INNER JOIN cs_schedule b WHERE a.status = 1 ";
		if ($time == 3) {
			$fromdate = date("m", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));

			$sql .= " and   MONTH(  a.`birthdate` ) = '" . $fromdate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("m-d");
			$sql .= " and  DATE_FORMAT(a.`birthdate`, '%m-%d') = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("m-d", strtotime('first day of next month'));
			$todate = date("m-d", strtotime('last day of next month'));

			$sql .= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '" . $fromdate . "' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '" . $todate . "' ";
		} elseif ($time == 5) {
			$fromdate = date("m-d", strtotime('first day of last month'));
			$todate = date("m-d", strtotime('last day of last month'));

			$sql .= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '" . $fromdate . "' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("m-d", strtotime('monday this week'));
			$todate = date("m-d", strtotime('sunday this week'));
			$sql .= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '" . $fromdate . "' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '" . $todate . "' ";
		} elseif ($time == 0) {
			$date = explode('+', $date);
			$fromdate = date("m-d", strtotime($date[0]));
			$todate = date("m-d", strtotime($date[1]));
			$sql .= " and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '" . $fromdate . "' and   DATE_FORMAT(a.`birthdate`, '%m-%d') <  '" . $todate . "' ";
		}
		/*elseif($time == 0 ){
			$date = explode('+', $date);
			$fromdate=date("Y-m-d", strtotime($date[0]));
			$todate=date("Y-m-d", strtotime($date[1]));
			$sql.= " and   DATE(  a.`createdate` ) >= '".$fromdate."' and  DATE(  a.`createdate` ) =<  '".$todate."' ";
		}*/


		if ($id_user != "") {

			$sql .= " and  a.id = b.id_customer";


			$sql .= " and b.id_dentist = '" . $id_user . "'";
		}
		if ($location != '') {
			$sql .= " and b.id_branch = '" . $location . "'";
		}
		$sql .= " limit 0, 50";

		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}
	/*printbirthdate*/
	public function getselectbirthdateprint($time, $id_user, $location, $date_start, $date_end)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.*, b.id_branch FROM customer a INNER JOIN cs_schedule b WHERE a.status = 1 ";
		if ($time == 0) {


			//$fromdate=date("Y-m-d", strtotime($date[0]));
			$todate = date("m-d", strtotime($date_end));
			$fromdate = date("m-d", strtotime($date_start));
			//$todate= date("Y-m-d", strtotime($date[0]));

			$sql .= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '" . $fromdate . "' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '" . $todate . "' ";
		} elseif ($time == 3) {
			$fromdate = date("m", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));

			$sql .= " and   MONTH(  a.`birthdate` ) = '" . $fromdate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("m-d");
			$sql .= " and  DATE_FORMAT(a.`birthdate`, '%m-%d') = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("m-d", strtotime('first day of next month'));
			$todate = date("m-d", strtotime('last day of next month'));

			$sql .= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '" . $fromdate . "' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '" . $todate . "' ";
		} elseif ($time == 5) {
			$fromdate = date("m-d", strtotime('first day of last month'));
			$todate = date("m-d", strtotime('last day of last month'));

			$sql .= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '" . $fromdate . "' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("m-d", strtotime('monday this week'));
			$todate = date("m-d", strtotime('sunday this week'));
			$sql .= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') > '" . $fromdate . "' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <  '" . $todate . "' ";
		}
		/*elseif($time == 0 ){
			$date = explode('+', $date);
			$fromdate=date("Y-m-d", strtotime($date[0]));
			$todate=date("Y-m-d", strtotime($date[1]));
			$sql.= " and   DATE(  a.`createdate` ) >= '".$fromdate."' and  DATE(  a.`createdate` ) =<  '".$todate."' ";
		}*/


		if ($id_user != "") {

			$sql .= " and  a.id = b.id_customer";


			$sql .= " and b.id_dentist = '" . $id_user . "'";
		}
		if ($location != '') {
			$sql .= " and b.id_branch = '" . $location . "'";
		}
		$sql .= " limit 0, 50";

		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}
	public function getcountlichhen($id)
	{
		$con = Yii::app()->db;
		$sql = "SELECT * FROM `v_quotations` WHERE id_customer = '" . $id . "'";
		$data = $con->createCommand($sql)->queryAll();
		return count($data);
	}
	public function getcountservice($id)
	{
		$con = Yii::app()->db;
		$sql = " SELECT DISTINCT id_service FROM `v_invoice_detail` WHERE id_customer = '" . $id . "'";
		$data = $con->createCommand($sql)->queryAll();
		return count($data);
	}
	public function getsuminvoice($id)
	{
		$con = Yii::app()->db;

		$sql = "SELECT SUM(sum_amount) AS sumnount FROM `v_invoice` WHERE id_customer = '" . $id . "'";
		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}
	/*---------------------------------------------------------------------END------------------------------------------------------------------*/

	/*---------------------------------------------------------------------END------------------------------------------------------------------*/
	/*	public function insertCustomer($fullname,$phone,$email)
	{
		$itemCustomer = new Customer;
		$itemCustomer->fullname = $fullname;
		$itemCustomer->phone = $phone;
		$itemCustomer->email = $email;
		$itemCustomer->status = 0;
		if ($itemCustomer->save(false)) {
			return $itemCustomer->id;
		}
	}*/

	//thong ke
	public function getCustomerMember($id_customer)
	{
		if (!$id_customer) {
			return;
		}
		$data = CustomerMember::model()->findByAttributes(array('id_customer' => $id_customer));
		if ($data) {
			$id_member 		 = $data['id_member'];
			$member 		 =  Member::model()->findByAttributes(array('id' => $id_member));
			if ($member) {
				return array('member' => $member, 'data' => $data);
			} else
				return 0;
		} else
			return 0;
	}
	public function getCustomerSchedule($id_customer)
	{
		if (!$id_customer) {
			return;
		}
		$data = VSchedule::model()->findByAttributes(array('id_customer' => $id_customer), array('order' => 'create_date DESC'));
		$count = count(VSchedule::model()->findAllByAttributes(array('id_customer' => $id_customer)));
		$schedule_cancel = count(VSchedule::model()->findAllByAttributes(array('id_customer' => $id_customer, 'status' => '-1')));
		$schedule_noshow = count(VSchedule::model()->findAllByAttributes(array('id_customer' => $id_customer, 'status' => '-2')));
		if ($data) {
			return array('count' => $count, 'data' => $data, 'schedule_cancel' => $schedule_cancel, 'schedule_noshow' => $schedule_noshow);
		} else
			return 0;
	}
	public function getCustomerInvoice($id_customer)
	{
		if (!$id_customer) {
			return;
		}
		$data = (VInvoice::model()->findAllByAttributes(array('id_customer' => $id_customer)));
		if ($data) {

			$sum_amount = 0;

			foreach ($data as $key => $value) {
				$sum_amount += (int) ($value['sum_amount']);
			}
			if ($sum_amount) {
				return $sum_amount;
			} else
				return 0;
		} else
			return 0;
	}
	public function getCustomerReceipt($id_customer)
	{
		if (!$id_customer) {
			return;
		}
		$data = VReceipt::model()->findAllByAttributes(array('id_customer' => $id_customer));
		if ($data) {

			$sum = 0;

			foreach ($data as $key => $value) {
				$sum += (int) ($value['pay_amount']);
			}

			$count = count(VReceipt::model()->findAllByAttributes(array('id_customer' => $id_customer)));
			if ($count == 0) {
				return  0;
			} else {
				$avg_detail = $sum / $count;
				return $avg_detail;
			}
		} else
			return 0;
	}

	public function updateToExamination($id_customer)
	{

		$schedule = Yii::app()->db->createCommand()
			->select('id')
			->from('cs_schedule')
			->where('id_customer=:id_customer', array(':id_customer' => $id_customer))
			->andWhere('status=2')
			->queryAll();

		$con = Yii::app()->db;
		$sql = "UPDATE cs_schedule SET status=3 WHERE id_customer='$id_customer' AND status=2";
		$data = $con->createCommand($sql)->execute();

		if ($data == 1) {
			return $schedule;
		}
	}
	public function checkcodesms($id, $code)
	{
		$data = Yii::app()->db->createCommand()
			->select('*')
			->from('customer')
			->where('id=:id', array(':id' => $id))
			->andWhere('code_sms=:code_sms', array(':code_sms' => $code))
			->queryRow();

		if ($data) {
			return $data;
		}
	}
	public function test_phone($phone)
	{
		$vnphone = $this->getVnPhone($phone);
		$data = yii::app()->db->createCommand()
			->select('*')
			->from('customer')
			->where('phone=:phone', array(':phone' => $vnphone))
			->andwhere('status=:status', array(':status' => '-1'))
			->queryRow();
		if ($data) {
			return 0;
		}
		return 1;
	}

	public function changeCustomer($id_customer)
	{
		if (!$id_customer) {
			return -1;
		} else {
			$find_customer = Customer::model()->findByPk($id_customer);
			if ($find_customer) {
				$code_number = $this->getCodeNumberCustomer();
				$find_customer->code_number = $code_number;
				$find_customer->status = 1;
				$find_customer->update();
				return 1;
			} else
				return 0;
		}
	}

	public function getListDentiMax($code_number)
	{

		//return Transaction::model()->findAllByAttributes(array('code_number'=>$code_number));
		return $data = Yii::app()->db->createCommand()
			->select('transaction.*')
			->from('transaction')
			->where('transaction.code_number=:code_number', array(':code_number' => $code_number))
			->order('transaction.date DESC')
			->queryAll();
	}

	public function getListCustomerDelete($curpage, $limit, $searchCode)
	{
		$start_point = $limit * ($curpage - 1);
		$p = new Customer;
		$q = new CDbCriteria(array(
			'condition' => 'published="true"'
		));
		$v = new CDbCriteria();
		$v->addCondition('t.status = -1');
		if ($searchCode) {
			$v->addSearchCondition('code_number', $searchCode, true);
			$v->addSearchCondition('fullname', $searchCode, true, 'OR');
		}
		$count = count($p->findAll($v));
		$v->order = 'code_number DESC';
		$v->limit = $limit;
		$v->offset = $start_point;
		$q->mergeWith($v);
		$data = $p->findAll($v);
		return array('count' => $count, 'data' => $data);
	}

	/***************************** ReportCustomer **************************/

	//report source
	public function getListCustomerOfSource($search_time, $id_branch, $fromtime, $totime, $source)
	{
		$p = new Customer;
		$q = new CDbCriteria(array(
			'condition' => 'published="true"'
		));
		$v = new CDbCriteria();
		$v->addCondition('status =1');
		$time = 0;
		if ($search_time) {       // thời gian
			if ($search_time == 1) { // hôm nay
				$time = date('Y-m-d');
				$v->addCondition('DATE(createdate) = :createdate');
				$v->params = array(':createdate' => $time);
			} elseif ($search_time == 2) {         // trong tuần
				$time_fisrt = date('Y-m-d', strtotime('monday this week'));
				$time_last = date('Y-m-d', strtotime('sunday this week'));
				$v->addCondition('DATE(createdate) >="' . $time_fisrt . '" AND DATE(createdate) <="' . $time_last . '"');
			} elseif ($search_time == 3) { // trong tháng
				$time_fisrt = date("Y-m-01", strtotime("first day of this month"));
				$time_last = date("Y-m-t", strtotime("last day of this month"));
				$v->addCondition('DATE(createdate) >="' . $time_fisrt . '" AND DATE(createdate) <="' . $time_last . '"');
			} elseif ($search_time == 4) { //tháng trước
				$time_fisrt = date("Y-m-01", strtotime("first day of this month"));
				$time_last = date("Y-m-t", strtotime("last day of this month"));
				$v->addCondition('DATE(createdate) >="' . $time_fisrt . '" AND DATE(createdate) <="' . $time_last . '"');
			} elseif ($search_time == 5) {
				$v->addCondition('DATE(createdate) >="' . $fromtime . '" AND DATE(createdate) <="' . $totime . '"');
			}
		}
		if ($id_branch) {
			$v->addCondition('id_branch =' . $id_branch);
		}

		if ($source) {
			$v->addCondition('id_source =' . $source);
		}

		$count = count($p->findAll($v));

		$v->order = 'id ASC';
		$q->mergeWith($v);

		$data = $p->findAll($v);

		return array('count' => $count, 'data' => $data);
	}

	public function getListCustomerNew($time, $id_user, $id_branch, $fromtime, $totime)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT  a.* FROM customer a  WHERE a.status = 1 ";
		if ($time == 3) {
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));

			$sql .= " and   DATE(  a.`createdate` ) >= '" . $fromdate . "' and  DATE(  a.`createdate` ) <=  '" . $todate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("Y-m-d");
			$sql .= " and   DATE(  a.`createdate` ) = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
			$todate = date("Y-m-d", strtotime('last day of last month'));

			$sql .= "  and   DATE(  `createdate` ) >= '" . $fromdate . "' and  DATE(  `createdate` ) <=  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("Y-m-d", strtotime('monday this week'));
			$todate = date("Y-m-d", strtotime('sunday this week'));
			$sql .= " and   DATE(  a.`createdate` ) >= '" . $fromdate . "' and  DATE(  a.`createdate` ) <=  '" . $todate . "' ";
		} elseif ($time == 5) {
			$sql .= " and   DATE(  a.`createdate` ) >= '" . $fromtime . "' and  DATE(  a.`createdate` ) <=  '" . $totime . "' ";
		}
		if ($id_branch != '') {
			$sql .= " and a.id_branch = '" . $id_branch . "'";
		}

		$data = $con->createCommand($sql)->queryAll();
		$count = count($data);
		return array('count' => $count, 'data' => $data);
	}

	public function getListCustomerOfBirthdate($time, $id_user, $id_branch, $fromtime, $totime)
	{
		// return $totime;
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.* FROM customer a  WHERE a.status = 1";
		if ($time == 3) {
			$fromdate = date("m", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));

			$sql .= " and   MONTH(  a.`birthdate` ) = '" . $fromdate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("m-d");
			$sql .= " and  DATE_FORMAT(a.`birthdate`, '%m-%d') = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("m-d", strtotime('first day of last month'));
			$todate = date("m-d", strtotime('last day of last month'));

			$sql .= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') >= '" . $fromdate . "' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <=  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("m-d", strtotime('monday this week'));
			$todate = date("m-d", strtotime('sunday this week'));
			$sql .= "  and   DATE_FORMAT(a.`birthdate`, '%m-%d') >= '" . $fromdate . "' and  DATE_FORMAT(a.`birthdate`, '%m-%d') <=  '" . $todate . "' ";
		} elseif ($time == 5) {
			$fromdate = date("m-d", strtotime($fromtime));
			$todate = date("m-d", strtotime($totime));

			$sql .= " and   DATE_FORMAT(a.`birthdate`, '%m-%d') >= '" . $fromdate . "' and   DATE_FORMAT(a.`birthdate`, '%m-%d') <=  '" . $todate . "'";
		}
		if ($id_branch != '') {
			$sql .= " and a.id_branch = '" . $id_branch . "'";
		}
		$data = $con->createCommand($sql)->queryAll();
		$count = count($data);
		return array('count' => $count, 'data' => $data);
	}

	public function getListCustomerOfRemind($time, $id_user, $id_branch, $fromtime, $totime)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.*, b.date_remind FROM customer a INNER JOIN customer_schedule_remind b 
    	WHERE a.status = 1 AND b.status = 1 
    	AND a.`id` = b.`id_customer` ";
		if ($time == 3) {
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));

			$sql .= " and   DATE(  b.`date_remind` ) >= '" . $fromdate . "' and  DATE(  b.`date_remind` ) <=  '" . $todate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("Y-m-d");
			$sql .= " and   DATE(  b.`date_remind` ) = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
			$todate = date("Y-m-d", strtotime('last day of last month'));
			$sql .= "  and   DATE(  b.`date_remind` ) >= '" . $fromdate . "' and  DATE(  b.`date_remind` ) <=  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("Y-m-d", strtotime('monday this week'));
			$todate = date("Y-m-d", strtotime('sunday this week'));
			$sql .= " and   DATE(  b.`date_remind` ) >= '" . $fromdate . "' and  DATE(  b.`date_remind` ) <=  '" . $todate . "' ";
		} elseif ($time == 5) {
			$sql .= " and   DATE(  b.`date_remind` ) >= '" . $fromtime . "' and  DATE(  b.`date_remind` ) <=  '" . $totime . "' ";
		}

		if ($id_branch != '') {
			$sql .= " and a.id_branch = '" . $id_branch . "'";
		}

		$data = $con->createCommand($sql)->queryAll();
		$count = count($data);
		return array('count' => $count, 'data' => $data);
	}

	public function getListCustomerOfNote($time, $id_user, $id_branch, $fromtime, $totime)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.code_number, a.*,b.note, b.`status` AS note_status, b.`flag`, c.`name` AS user_name FROM customer a INNER JOIN customer_note b INNER JOIN gp_users c
    	WHERE a.status = 1
    	AND a.`id` = b.`id_customer`
    	AND b.`id_user` = c.`id`";
		if ($time == 3) {
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));

			$sql .= " and   DATE(  b.`create_date` ) >= '" . $fromdate . "' and  DATE(  b.`create_date` ) <=  '" . $todate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("Y-m-d");
			$sql .= " and   DATE(  b.`create_date` ) = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
			$todate = date("Y-m-d", strtotime('last day of last month'));
			$sql .= "  and   DATE(  b.`create_date` ) >= '" . $fromdate . "' and  DATE(  b.`create_date` ) <=  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("Y-m-d", strtotime('monday this week'));
			$todate = date("Y-m-d", strtotime('sunday this week'));
			$sql .= " and   DATE(  b.`create_date` ) >= '" . $fromdate . "' and  DATE(  b.`create_date` ) <=  '" . $todate . "' ";
		} elseif ($time == 5) {
			$sql .= " and   DATE(  b.`create_date` ) >= '" . $fromtime . "' and  DATE(  b.`create_date` ) <=  '" . $totime . "' ";
		}

		if ($id_user != "") {
			$sql .= " and b.id_user = '" . $id_user . "'";
		}

		if ($id_branch != '') {
			$sql .= " and a.id_branch = '" . $id_branch . "'";
		}

		$data = $con->createCommand($sql)->queryAll();
		$count = count($data);
		return array('count' => $count, 'data' => $data);
	}

	public function getListCustomerOfService($time, $id_user, $id_branch, $fromtime, $totime, $service, $group, $id_customer)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.*, b.`amount`,b.`id_user`,b.`id_service`,b.`description`,b.* FROM customer a INNER JOIN v_invoice_detail b   WHERE a.id = b.id_customer ";

		if ($time == 3) {
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));

			$sql .= " and   DATE(  b.create_date ) >= '" . $fromdate . "' and  DATE(  b.create_date ) <=  '" . $todate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("Y-m-d");
			$sql .= " and   DATE(  b.create_date ) = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
			$todate = date("Y-m-d", strtotime('last day of last month'));

			$sql .= "  and   DATE( b.create_date ) >= '" . $fromdate . "' and  DATE( b.create_date ) <=  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("Y-m-d", strtotime('monday this week'));
			$todate = date("Y-m-d", strtotime('sunday this week'));
			$sql .= " and   DATE(  b.create_date ) >= '" . $fromdate . "' and  DATE(  b.create_date ) <=  '" . $todate . "' ";
		} elseif ($time == 5) {
			$sql .= " and   DATE( b.create_date ) >= '" . $fromtime . "' and  DATE( b.create_date ) <=  '" . $totime . "' ";
		}
		if ($id_user != "") {
			$sql .= " and b.id_user = '" . $id_user . "'";
		}
		if ($id_branch != '') {
			$sql .= " and a.id_branch = '" . $id_branch . "'";
		}
		if ($service != '') {
			$sql .= " and b.id_service = " . $service;
		}
		if ($id_customer && $id_customer != 'null') {
			$sql .= " and b.id_customer = " . $id_customer;
		}
		$data = $con->createCommand($sql)->queryAll();

		$count = count($data);
		return array('count' => $count, 'data' => $data);
	}
	public function getListCustomerOfBalance($time, $id_user, $id_branch, $fromtime, $totime)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT a.*, b.`balance` FROM customer a INNER JOIN v_invoice b   WHERE balance > 0 AND a.id = b.id_customer ";

		if ($time == 3) {
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));
			$sql .= " and   DATE(b.`create_date`) >= '" . $fromdate . "' and  DATE(b.`create_date`) <=  '" . $todate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("Y-m-d");
			$sql .= " and   DATE(b.`create_date`) = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
			$todate = date("Y-m-d", strtotime('last day of last month'));

			$sql .= "  and   DATE(b.`create_date`) >= '" . $fromdate . "' and  DATE(b.`create_date`) <=  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("Y-m-d", strtotime('monday this week'));
			$todate = date("Y-m-d", strtotime('sunday this week'));
			$sql .= " and   DATE(b.`create_date`) >= '" . $fromdate . "' and  DATE(b.`create_date`) <=  '" . $todate . "' ";
		} elseif ($time == 5) {
			$sql .= " and   DATE(b.`create_date`) >= '" . $fromtime . "' and  DATE(b.`create_date`) <=  '" . $totime . "' ";
		}
		if ($id_user != "") {
			$sql .= " and b.`id_author` = '" . $id_user . "'";
		}
		if ($id_branch != '') {
			$sql .= " and b.`id_branch` = '" . $id_branch . "'";
		}
		$data = $con->createCommand($sql)->queryAll();
		$data_new = array();
		foreach ($data as $val) {
			if (!isset($data_new[$val['id']]))
				$data_new[$val['id']] = $val;
			else
				$data_new[$val['id']]['balance'] += $val['balance'];
		}
		$data_new = array_values($data_new);
		return $data_new;
	}

	public function getListCustomerOfTreatment($time, $id_user, $id_branch, $fromtime, $totime)
	{
		$con = Yii::app()->db;
		$sql = "SELECT DISTINCT  a.*  FROM customer a INNER JOIN v_schedule b   WHERE b.`status` = 4 AND a.id = b.id_customer ";
		if ($time == 3) {
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));
			$sql .= " and   DATE(b.`create_date`) >= '" . $fromdate . "' and  DATE(b.`create_date`) <=  '" . $todate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("Y-m-d");
			$sql .= " and   DATE(b.`create_date`) = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
			$todate = date("Y-m-d", strtotime('last day of last month'));

			$sql .= "  and   DATE(b.`create_date`) >= '" . $fromdate . "' and  DATE(b.`create_date`) <=  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("Y-m-d", strtotime('monday this week'));
			$todate = date("Y-m-d", strtotime('sunday this week'));
			$sql .= " and   DATE(b.`create_date`) >= '" . $fromdate . "' and  DATE(b.`create_date`) <=  '" . $todate . "' ";
		} elseif ($time == 5) {

			$sql .= " and   DATE(b.`create_date`) >= '" . $fromtime . "' and  DATE(b.`create_date`) <=  '" . $totime . "' ";
		}
		if ($id_user) {
			$sql .= " and b.`id_dentist` = '" . $id_user . "'";
		}
		if ($id_branch != '') {
			$sql .= " and b.`id_branch` = '" . $id_branch . "'";
		}
		$data = $con->createCommand($sql)->queryAll();
		$i = 0;
		foreach ($data as $key => $v) {
			$total = Customer::model()->getTotalTreatment($v['id'], $time, $id_user, $id_branch, $fromtime, $totime);
			$data[$i] = array('id' => $v['id'], 'code_number' => $v['code_number'], 'fullname' => $v['fullname'], 'birthdate' => $v['birthdate'], 'gender' => $v['gender'], 'email' => $v['email'], 'phone' => $v['phone'], 'address' => $v['address'], 'id_source' => $v['id_source'], 'total' => $total);
			$i++;
		}

		return $data;
	}
	public function getTotalTreatment($id_customer, $time, $id_user, $id_branch, $fromtime, $totime)
	{
		$con = Yii::app()->db;
		$sql = "SELECT   count(b.`id`)as total  FROM customer a INNER JOIN v_schedule b   WHERE b.`status` = 4 AND a.id = b.id_customer ";

		if ($time == 3) {
			$fromdate = date("Y-m-01", strtotime("first day of this month"));
			$todate = date("Y-m-t", strtotime("last day of this month"));
			$sql .= " and   DATE(b.`create_date`) >= '" . $fromdate . "' and  DATE(b.`create_date`) <=  '" . $todate . "' ";
		} elseif ($time == 1) {
			$fromdate = date("Y-m-d");
			$sql .= " and   DATE(b.`create_date`) = '" . $fromdate . "'";
		} elseif ($time == 4) {
			$fromdate = date("Y-m-d", strtotime('first day of last month'));
			$todate = date("Y-m-d", strtotime('last day of last month'));
			$sql .= "  and   DATE(b.`create_date`) >= '" . $fromdate . "' and  DATE(b.`create_date`) <=  '" . $todate . "' ";
		} elseif ($time == 2) {
			$fromdate = date("Y-m-d", strtotime('monday this week'));
			$todate = date("Y-m-d", strtotime('sunday this week'));
			$sql .= " and   DATE(b.`create_date`) >= '" . $fromdate . "' and  DATE(b.`create_date`) <=  '" . $todate . "' ";
		} elseif ($time == 5) {
			$sql .= " and   DATE(b.`create_date`) >= '" . $fromtime . "' and  DATE(b.`create_date`) <=  '" . $totime . "' ";
		}
		if ($id_user != "") {
			$sql .= " and b.`id_dentist` = '" . $id_user . "'";
		}
		if ($id_branch != '') {
			$sql .= " and b.`id_branch` = '" . $id_branch . "'";
		}
		if ($id_customer) {
			$sql .= " and b.`id_customer` = '" . $id_customer . "'";
		}
		$data = $con->createCommand($sql)->queryScalar();
		return $data;
	}

	public function getListCustomerSpending($type_time, $id_user, $id_branch, $fromtime, $totime)
	{
		$con = Yii::app()->db;
		$sql = "select customer.* ,v_quotations.`id` as id_quotation ,v_quotations.`sum_amount` FROM (customer JOIN v_quotations ON customer.`id`=v_quotations.`id_customer`) WHERE 1=1";
		if ($id_branch) {
			$sql .= " and v_quotations.`id_branch`=$id_branch";
		}
		if ($id_user) {
			$sql .= " and v_quotations.`id_author`=$id_user";
		}
		if ($type_time) {
			if ($type_time == 1) {
				$time = date('Y-m-d');
				$sql .= " and DATE(v_quotations.`create_date`)='$time'";
			} else if ($type_time == 2) {
				$time_fisrt = date('Y-m-d', strtotime('monday this week'));
				$time_last = date('Y-m-d', strtotime('sunday this week'));
				$sql .= " and (DATE(v_quotations.`create_date`)>='$time_fisrt' and DATE(v_quotations.`create_date`)<='$time_last')";
			} else if ($type_time == 3) {
				$time = date('m', strtotime(date('Y-m-d')));
				$sql .= " and MONTH(v_quotations.`create_date`) = '$time'";
			} else if ($type_time == 4) {
				$time = date('m', strtotime(date('Y-m-d') . ' - 1 month')); //tháng trước
				$sql .= " and MONTH(v_quotations.`create_date`) = '$time'";
			} else if ($type_time == 5) {
				$sql .= " and (DATE(v_quotations.`create_date`)>='$fromdate' and DATE(v_quotations.`create_date`)<='$todate')";
			}
		}
		$sql .= " GROUP BY customer.`id`";
		$data = $con->createCommand($sql)->queryAll();
		$i = 0;
		foreach ($data as $key => $v) {
			$totalInvoice = Customer::model()->getTotalInvoice($v['id_quotation']);
			$totalService = Customer::model()->getTotalService($v['id_quotation']);
			$payment 	  = $totalInvoice['sum_invoice'] - $totalInvoice['balance'];
			$data[$i] = array('id' => $v['id'], 'code_number' => $v['code_number'], 'fullname' => $v['fullname'], 'gender' => $v['gender'], 'email' => $v['email'], 'phone' => $v['phone'], 'address' => $v['address'], 'id_source' => $v['id_source'], 'id_quotation' => $v['id_quotation'], 'sum_amount' => $v['sum_amount'], 'totalInvoice' => $totalInvoice['totalInvoice'], 'sum_invoice' => $totalInvoice['sum_invoice'], 'balance' => $totalInvoice['balance'], 'totalService' => $totalService['totalService'], 'payment' => $payment);
			$i++;
		}
		return $data;
	}
	public function getTotalInvoice($id_quotation)
	{
		$con = Yii::app()->db;
		$sql = "select COUNT(invoice.`id`) AS totalInvoice, SUM(sum_amount) AS sum_invoice, SUM(balance) AS balance  FROM invoice WHERE id_quotation='$id_quotation'";
		$data = $con->createCommand($sql)->queryRow();
		return $data;
	}
	public function getTotalService($id_quotation)
	{
		$con = Yii::app()->db;
		$sql = "select COUNT(v_quotation_detail.`id_service`) AS totalService  FROM v_quotation_detail WHERE id_quotation='$id_quotation'";
		$data = $con->createCommand($sql)->queryRow();
		return $data;
	}

	public function getTitleReport($search_time, $user, $branch, $source, $service, $fromtime, $totime)
	{
		$string = '';
		if ($search_time == "1") {
			$fromdate = date("d-m-Y");
			$todate = "";
			$string .=  $fromdate;
		} elseif ($search_time == "2") {
			$fromdate = date("d-m-Y", strtotime('monday this week'));
			$todate = date("d-m-Y", strtotime('sunday this week'));
			$string .= $fromdate . ' đến ' . $todate;
		} elseif ($search_time == "3") {
			$fromdate = date("01-m-Y", strtotime("first day of this month"));
			$todate = date("t-m-Y", strtotime("last day of this month"));
			$string .= $fromdate . ' đến ' . $todate;
		} elseif ($search_time == "4") {
			$fromdate = date("d-m-Y", strtotime('first day of last month'));
			$todate = date("d-m-Y", strtotime('last day of last month'));
			$string .= $fromdate . ' đến ' . $todate;
		} else {
			$string .= $fromtime . ' đến ' . $totime;
		}
		if ($branch == "") {
			$string .= ", Tất cả vị trí";
		} else {
			$branchList =  Branch::model()->findByPk($branch);
			$string .= ', Văn phòng: ' . $branchList->name;
		}
		if ($user == "") {
			$string .= ", Tất cả nhân viên";
		} else {
			$userList =  GpUsers::model()->findByPk($user);
			if ($userList) {
				$string .= ', Bác sĩ: ' . $userList->name;
			}
		}
		if ($source) {
			$nameSource = Source::model()->findByPk($source);
			if ($nameSource) {
				$string .= ', Nguồn: ' . $nameSource->name;
			}
		}
		if ($service) {
			$nameService = CsService::model()->findByPk($service);
			if ($nameService) {
				$string .= ', Dịch vụ: ' . $nameService->name;
			}
		}
		return $string;
	}

	//ngày điều trị cuối cùng
	public function getListCustomerDateOfTreatment($search_time, $fromtime, $totime)
	{
		$p = new Customer;
		$q = new CDbCriteria(array(
			'condition' => 'published="true"'
		));
		$v = new CDbCriteria();
		$time = 0;
		if ($search_time) {       // thời gian
			if ($search_time == 1) { // hôm nay
				$time = date('Y-m-d');
				$v->addCondition('DATE(last_day) = :last_day');
				$v->params = array(':last_day' => $time);
			} elseif ($search_time == 2) {         // trong tuần
				$time_fisrt = date('Y-m-d', strtotime('monday this week'));
				$time_last = date('Y-m-d', strtotime('sunday this week'));
				$v->addCondition('DATE(last_day) >="' . $time_fisrt . '" AND DATE(last_day) <="' . $time_last . '"');
			} elseif ($search_time == 3) { // trong tháng
				$time_fisrt = date("Y-m-01", strtotime("first day of this month"));
				$time_last = date("Y-m-t", strtotime("last day of this month"));
				$v->addCondition('DATE(last_day) >="' . $time_fisrt . '" AND DATE(last_day) <="' . $time_last . '"');
			} elseif ($search_time == 4) { //tháng trước
				$time = date('m', strtotime(date('Y-m-d') . ' - 1 month'));
				$v->addCondition('MONTH(last_day) = :last_day');
				$v->params = array(':last_day' => $time);
			} elseif ($search_time == 5) {
				$v->addCondition('DATE(last_day) >="' . $fromtime . '" AND DATE(last_day) <="' . $totime . '"');
			}
		}
		$count = count($p->findAll($v));
		$v->order = 'last_day DESC';
		$q->mergeWith($v);
		$data = $p->findAll($v);
		return $data;
	}
	//////////////////////////// Hàm mới bên tab bệnh án /////////////////////

	public function getListInvoice($id_group_history, $id_customer, $search_tooth = '', $search_code_service = '')
	{

		$con = Yii::app()->db;
		$sql = "select v_invoice_detail.id, v_invoice_detail.id_invoice, v_invoice_detail.confirm, v_invoice_detail.code_service, v_invoice_detail.services_name,v_invoice_detail.teeth, v_invoice_detail.amount, v_invoice_detail.user_name, v_invoice_detail.create_date, v_invoice_detail.status as status_invoice, v_invoice_detail.percent_change, v_invoice_detail.note FROM v_invoice_detail WHERE 1 = 1";

		if ($id_customer) {
			$sql .= " and v_invoice_detail.`id_customer`= $id_customer";
		}

		if ($search_code_service || $search_tooth) {
			if ($search_code_service) {
				$sql .= " and v_invoice_detail.`code_service`= '$search_code_service'";
			}
			if ($search_tooth) {
				$sql .= " and (`v_invoice_detail`.`teeth` LIKE '%" . $search_tooth . "%' )";
			}
		} else {
			if ($id_group_history) {
				$sql .= " and v_invoice_detail.`id_group_history`= $id_group_history";
			}
		}
		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}

	public function getListTreatmentWork($id_group_history, $search_tooth = '', $id_customer)
	{
		$con = Yii::app()->db;
		$sql = "select v_treatment_work.*  FROM v_treatment_work WHERE status = 1";
		if ($search_tooth) {
			$sql .= " and (`v_treatment_work`.`tooth_numbers` LIKE '%" . $search_tooth . "%' )";
		} else {
			if ($id_group_history) {
				$sql .= " and v_treatment_work.`id_group_history`= $id_group_history";
			}
		}
		if ($id_customer) {
			$sql .= " and v_treatment_work.`id_customer`= $id_customer";
		}

		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}


	public function getListInvoiceAndTreatment($id_group_history, $id_customer, $search_tooth = '', $search_code_service = '')
	{
		$invoice = $this->getListInvoice($id_group_history, $id_customer, $search_tooth, $search_code_service);
		$treatment_work = $this->getListTreatmentWork($id_group_history, $search_tooth, $id_customer);

		if ($search_code_service) {
			$data = array_merge($invoice);
		} else {
			$data = array_merge($invoice, $treatment_work);
		}
		$new_published = array();
		foreach ($data as $key => $row) {
			$new_published[$key] = $row['create_date'];
		}
		array_multisort($new_published, SORT_DESC, $data);
		return $data;
	}

	public function getListTreatmentOfCustomer($id_mhg, $search_tooth)
	{
		$data = array();
		if (!$id_mhg) {
			return -1;
		}

		$listTreatmentProcess = Yii::app()->db->createCommand()
			->select('v_medical_history.id,v_medical_history.gp_users_name,v_medical_history.description,v_medical_history.medicine_during_treatment,v_medical_history.createdate ,v_medical_history.reviewdate,v_medical_history.id_dentist,v_medical_history.length_time')
			->from('v_medical_history')
			->where('v_medical_history.id_history_group=:id_history_group', array(':id_history_group' => $id_mhg))
			->andWhere('v_medical_history.status=1')

			->order('v_medical_history.createdate DESC')
			->queryAll();

		if ($listTreatmentProcess) {
			foreach ($listTreatmentProcess as $key => $value) {
				if ($search_tooth) {
					$listTreatmentWork = Yii::app()->db->createCommand()
						->select('treatment_work.tooth_numbers,treatment_work.treatment_work')
						->from('treatment_work')
						->where('treatment_work.id_medical_history= :id_medical_history', array(':id_medical_history' => $value['id']))
						->andWhere('treatment_work.tooth_numbers LIKE :tooth_numbers', array(':tooth_numbers' => '%' . $search_tooth . '%'))
						->queryAll();
				} else {
					$listTreatmentWork = Yii::app()->db->createCommand()
						->select('treatment_work.tooth_numbers,treatment_work.treatment_work')
						->from('treatment_work')
						->where('treatment_work.id_medical_history= :id_medical_history', array(':id_medical_history' => $value['id']))
						->queryAll();
				}
				if ($listTreatmentWork) {
					$data[$key] = array('id' => $value['id'], 'user_name' => $value['gp_users_name'], 'description' => $value['description'], 'medicine_during_treatment' => $value['medicine_during_treatment'], 'create_date' => $value['createdate'], 'reviewdate' => $value['reviewdate'], 'id_dentist' => $value['id_dentist'], 'length_time' => $value['id_dentist'], 'listTreatmentWork' => $listTreatmentWork);
				}
			}
		}
		return $data;
	}

	public function getListInvoiceAndTreatmentAll($id_group_history, $id_customer, $search_tooth = '', $search_code_service = '')
	{
		$invoice = $this->getListInvoice($id_group_history, $id_customer, $search_tooth, $search_code_service);
		$treatment_work = $this->getListTreatmentOfCustomer($id_group_history, $search_tooth);

		if ($search_code_service) {
			$data = array_merge($invoice);
		} else {
			$data = array_merge($invoice, $treatment_work);
		}
		foreach ($data as $key => $row) {
			$new_published[$key] = $row['create_date'];
		}
		if ($data) {
			array_multisort($new_published, SORT_DESC, $data);
		}
		return $data;
	}

	public function infoPrescription($id_medical_history)
	{
		$data = Prescription::model()->findByAttributes(array('id_medical_history' => $id_medical_history));
		return $data;
	}

	public function infoLabo($id_medical_history)
	{
		$data = Labo::model()->findByAttributes(array('id_medical_history' => $id_medical_history));
		return $data;
	}

	public function listDrugAndUsage($id_prescription)
	{
		$listDrugAndUsage = Yii::app()->db->createCommand()
			->select('drug_and_usage.drug_name, drug_and_usage.times, drug_and_usage.dosage')
			->from('drug_and_usage')
			->where('drug_and_usage.id_prescription =:id_prescription', array(':id_prescription' => $id_prescription))
			->queryAll();
		return $listDrugAndUsage;
	}

	public function getListTooth()
	{
		$tooth = array(
			'11' 	=> '11',
			'12' 	=> '12',
			'13'	=> '13',
			'14'	=> '14',
			'15'	=> '15',
			'16'	=> '16',
			'17'	=> '17',
			'18'	=> '18',
			'21' 	=> '21',
			'22' 	=> '22',
			'23'	=> '23',
			'24'	=> '24',
			'25'	=> '25',
			'26'	=> '26',
			'27'	=> '27',
			'28'	=> '28',
			'31' 	=> '31',
			'32' 	=> '32',
			'33'	=> '33',
			'34'	=> '34',
			'35'	=> '35',
			'36'	=> '36',
			'37'	=> '37',
			'38'	=> '38',
			'41' 	=> '41',
			'42' 	=> '42',
			'43'	=> '43',
			'44'	=> '44',
			'45'	=> '45',
			'46'	=> '46',
			'47'	=> '47',
			'48'	=> '48',
			'51' 	=> '51',
			'52' 	=> '52',
			'53'	=> '53',
			'54'	=> '54',
			'55'	=> '55',
			'61' 	=> '61',
			'62' 	=> '62',
			'63'	=> '63',
			'64'	=> '64',
			'65'	=> '65',
			'71' 	=> '71',
			'72' 	=> '72',
			'73'	=> '73',
			'74'	=> '74',
			'75'	=> '75',
			'81' 	=> '81',
			'82' 	=> '82',
			'83'	=> '83',
			'84'	=> '84',
			'85'	=> '85',
			'2H'	=> '2H',
		);
		return $tooth;
	}

	public function getListTreatmentWorkAll($id_medical_history)
	{
		$con = Yii::app()->db;
		$sql = "select treatment_work.*  FROM treatment_work ";
		if ($id_medical_history) {
			$sql .= " WHERE treatment_work.`id_medical_history`= $id_medical_history";
		}
		$data = $con->createCommand($sql)->queryAll();
		return $data;
	}

	public function TestPrefix($phone)
	{
		$prefix = substr($phone, 0, 3);

		$ValuePrefix = PhonePrefix::model()->findAllByAttributes(
			array(
				"prefix" => $prefix
			)
		);

		if (count($ValuePrefix) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updateLastTreatment($id_customer, $last_date = '')
	{
		if (!$last_date) {
			$last_date = date('Y-m-d');
		}

		if (!$id_customer) {
			return 0;
		}

		$customer = Customer::model()->updateByPk($id_customer, array(
			'last_day' => $last_date
		));

		if ($customer) {
			return 1;
		}
		return 0;
	}

	#region --- KHACH HANG KHONG DIEU TRI
	public function getListCustomerTreatmentNot($branch, $time) {
		if (!$time) { return 0; }

		$d = DateTime::createFromFormat('Y-m-d', $time);
		if (!($d && $d->format('Y-m-d') == $time)) {
			return 0;
		}

		$branchCondition = "";
		if ($branch) { $branchCondition = "AND quote.`id_branch` = $branch"; }

		$con = Yii::app()->db;
		$sql = "SELECT cus.`id` AS id_customer, code_number, fullname, birthdate, cus.`phone` AS phone, quote.`id`, quote_detail.`code_service` AS code_service, quote_detail.`id_user`, user.`name` AS `user_name`, quote_detail.`status`
		FROM customer AS cus
		INNER JOIN quotation AS quote ON quote.`id_customer` = cus.`id`
		INNER JOIN `quotation_service` AS quote_detail ON quote_detail.`id_quotation` = quote.`id`
		INNER JOIN `gp_users` AS user ON user.`id` = quote_detail.`id_user`
		WHERE DATE(quote.`create_date`) = '$time' $branchCondition";

		$list = $con->createCommand($sql)->queryAll();
		return $list;
	}
	#endregion

	// khach hang theo khu vuc
	public function getListCustomerArea($search_time, $country, $city, $district, $fromtime, $totime) {
		$p = new Customer;
		$q = new CDbCriteria(array(
			'condition' => 'published="true"'
		));
		$v = new CDbCriteria();
		$v->addCondition('status =1');

		if ($country) {
			$v->addCondition("id_country = '$country'");
		}

		if ($city) {
			if ($district) {
				$v->addCondition("county = '$district'");
			} else {
				$v->addCondition("city = '$city'");		
			}
		}
		if ($search_time) {       // thời gian
			if ($search_time == 1) { // hôm nay
				$time = date('Y-m-d');
				$v->addCondition('DATE(createdate) = :createdate');
				$v->params = array(':createdate' => $time);
			} elseif ($search_time == 2) {         // trong tuần
				$time_fisrt = date('Y-m-d', strtotime('monday this week'));
				$time_last = date('Y-m-d', strtotime('sunday this week'));
				$v->addCondition('DATE(createdate) >="' . $time_fisrt . '" AND DATE(createdate) <="' . $time_last . '"');
			} elseif ($search_time == 3) { // trong tháng
				$time_fisrt = date("Y-m-01", strtotime("first day of this month"));
				$time_last = date("Y-m-t", strtotime("last day of this month"));
				$v->addCondition('DATE(createdate) >="' . $time_fisrt . '" AND DATE(createdate) <="' . $time_last . '"');
			} elseif ($search_time == 4) { //tháng trước
				$time_fisrt = date("Y-m-01", strtotime("first day of this month"));
				$time_last = date("Y-m-t", strtotime("last day of this month"));
				$v->addCondition('DATE(createdate) >="' . $time_fisrt . '" AND DATE(createdate) <="' . $time_last . '"');
			} elseif ($search_time == 5) {
				$v->addCondition('DATE(createdate) >="' . $fromtime . '" AND DATE(createdate) <="' . $totime . '"');
			}
		}
		$count = count($p->findAll($v));
		$v->order = 'createdate DESC';
		$q->mergeWith($v);
		$data = $p->findAll($v);
		return array('count' => $count, 'data' => $data);
	}

	#region --- KHACH HANG SAU DIEU TRI
	public function getListCustomerTreatmentAfter($branch, $time) {
		if (!$time) { return 0; }

		$d = DateTime::createFromFormat('Y-m-d', $time);
		if (!($d && $d->format('Y-m-d') == $time)) {
			return 0;
		}

		$branchCondition = "";
		if ($branch) { $branchCondition = "AND sch.`id_branch` = $branch"; }

		$con = Yii::app()->db;
		$sql = "SELECT sch.`id` AS id_schedule, cus.`id` AS id_customer, sch.`id_branch` AS id_branch, ser.`code` AS `service_code`, ser.`name` AS `service_name`, cus.`code_number`, cus.`fullname`, cus.`birthdate`, cus.`phone`, sch.`start_time`
		FROM cs_schedule AS sch
		INNER JOIN customer AS cus ON cus.`id` = sch.`id_customer`
		INNER JOIN cs_service AS ser ON ser.`id` = sch.`id_service`
		WHERE DATE(`start_time`) = '$time' $branchCondition";

		$list = $con->createCommand($sql)->queryAll();

		return $list;
	}

	public function getNextScheduleTreatment($id_schedule, $id_customer, $branch) {
		$branchCondition = "";
		if ($branch) { $branchCondition = "AND sch.`id_branch` = $branch"; }

		$con = Yii::app()->db;
		$sql = "SELECT sch.`start_time`, sch.`lenght` AS `length` FROM cs_schedule AS sch
		WHERE id > $id_schedule AND DATE(`start_time`) > CURDATE() AND id_customer = $id_customer $branchCondition LIMIT 1";

		return $con->createCommand($sql)->queryRow();
	}

	public function getMedicalHistory($sch_date, $id_customer) {
		$con = Yii::app()->db;
		$sql = "SELECT id FROM cs_medical_history_group WHERE DATE(createdata) < DATE('$sch_date') AND id_customer = $id_customer LIMIT 1";

		return $con->createCommand($sql)->queryRow();
	}

	public function getPartner($id_mhg) {
		$con = Yii::app()->db;
		$sql = "SELECT `invoice`.`id` AS id_invoice, `partner`.id,  `partner`.`name` FROM invoice LEFT JOIN `partner` ON `partner`.`id` = `invoice`.`partnerID` WHERE `invoice`.`confirm` = 1 AND `invoice`.`status` >= 0 AND id_group_history = $id_mhg";

		return $con->createCommand($sql)->queryAll();
	}

	public function getDiagnostic($id_mhg) {
		$con = Yii::app()->db;
		$sql = "SELECT `tooth_conclude`.`tooth_number`, `conclude`, `assign`, `id_user` FROM `tooth_conclude`
		LEFT JOIN `tooth_assign` ON `tooth_assign`.`tooth_number` = `tooth_conclude`.`tooth_number` AND `tooth_conclude`.`id_group_history` = `tooth_assign`.`id_group_history`
		WHERE `tooth_conclude`.`id_group_history` = $id_mhg";

		return $con->createCommand($sql)->queryAll();
	}

	public function getInvoiceDetail($id_invoice) {
		$con = Yii::app()->db;
		$sql = "SELECT teeth, `code_service` AS treatment, `name` AS `user_name` FROM `invoice_detail` LEFT JOIN gp_users AS u ON `u`.id = `invoice_detail`.id_user WHERE id_invoice IN ('$id_invoice');";

		return $con->createCommand($sql)->queryAll();
	}

	public function getTreatmentDetail($id_group_history) {
		$con = Yii::app()->db;
		$sql = "SELECT tooth_numbers AS teeth, `treatment_work` AS treatment, `user_name` FROM `v_treatment_work` WHERE id_group_history = $id_group_history;";

		return $con->createCommand($sql)->queryAll();
	}

	public function searchCustomersAccounts($and_conditions = '', $or_conditions = '', $additional = '', $orderBy, $lpp = '10', $cur_page = '1')
	{
		$lpp_org = $lpp;

		$con = Yii::app()->db;

		$sql = "select id from customer where customer.status = 1 ";

		if ($and_conditions and is_array($and_conditions)) {
			foreach ($and_conditions as $k => $v) {
				$sql .= " and $k = '$v'";
			}
		} elseif ($and_conditions) {
			$sql .= " and $and_conditions";
		}

		if ($or_conditions and is_array($or_conditions)) {
			foreach ($or_conditions as $k => $v) {
				$sql .= " or $k = '$v'";
			}
		} elseif ($or_conditions) {
			$sql .= " or $or_conditions";
		}

		if ($additional) {
			$sql .= " $additional";
		}

		$num_row = count($con->createCommand($sql)->queryAll());


		if (!$num_row) return array('paging' => array('num_row' => '0', 'num_page' => '1', 'cur_page' => $cur_page, 'lpp' => $lpp, 'start_num' => 1), 'data' => '');

		if ($lpp == 'all') {
			$lpp = $num_row;
		}

		//  Page 1
		if ($num_row < $lpp) {
			$cur_page = 1;
			$num_page = 1;
			$lpp      = $num_row;
			$start    = 0;
		} else {
			// Tinh so can phan trang
			$num_page =  ceil($num_row / $lpp);

			// So trang hien tai lon hon tong so ph�n trang mot page
			if ($cur_page >=  $num_page) {
				$cur_page = $num_page;
				$lpp      =  $num_row - ($num_page - 1) * $lpp_org;
			}
			$start = ($cur_page - 1) * $lpp_org;
		}

		$sql = "select id,fullname,phone,birthdate,address,code_number 
			from customer
			where customer.status = 1 ";

		if ($and_conditions and is_array($and_conditions)) {
			foreach ($and_conditions as $k => $v) {
				$sql .= " and $k = '$v'";
			}
		} elseif ($and_conditions) {
			$sql .= " and $and_conditions";
		}

		if ($or_conditions and is_array($or_conditions)) {
			foreach ($or_conditions as $k => $v) {
				$sql .= " or $k = '$v'";
			}
		} elseif ($or_conditions) {
			$sql .= " or $or_conditions";
		}

		if ($additional) {
			$sql .= " $additional";
		}

		if ($orderBy) {
			$sql .= " order by ".$orderBy;
		}

		$sql .= " limit " . $start . "," . $lpp;

		$data = $con->createCommand($sql)->queryAll();

		return array('paging' => array('num_row' => $num_row, 'num_page' => $num_page, 'cur_page' => $cur_page, 'lpp' => $lpp_org, 'start_num' => $start + 1), 'data' => $data);
	}

	#endregion
}
