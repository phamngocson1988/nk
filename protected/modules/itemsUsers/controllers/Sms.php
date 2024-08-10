<?php

/**
 * This is the model class for table "sms".
 *
 * The followings are the available columns in table 'sms':
 * @property integer $id
 * @property string $id_sms
 * @property integer $id_author
 * @property string $author
 * @property integer $id_customer
 * @property string $customer
 * @property string $phone
 * @property string $content
 * @property string $create_date
 * @property integer $type
 * @property string $id_schedule
 * @property integer $id_branch
 * @property integer $source
 * @property integer $status
 * @property integer $flag
 */
class Sms extends CActiveRecord {
    #region --- PARAMS
    const TYPE_NOTI = 1;
    const TYPE_ACCOUNT = 2;
    const TYPE_SCHEDULE = 3;
    const TYPE_AUTO_BIRTHDATE = 4;
    const TYPE_AUTO_SCHEDULE = 5;

    const SOURCE_CUSTOMER = 1;
    const SOURCE_USER = 2;
    const SOURCE_SYSTEM = 3;

    public $sendSMSError = array(
        '0'    =>  'invalid username or password',
        '-1'   =>  'invalid brandname',
        '-2'   =>  'invalid phonenumber',
        '-3'   =>  'Brandname chua khai bao ',
        '-4'   =>  'Partner chua khai bao ',
        '-5'   =>  'template chua khai bao',
        '-6'   =>  'login telco system fail',
        '-7'   =>  'error sending sms to telco',
        '-100' =>  'database error',
        '1'    =>  'success'
    );
    #endregion

    #region --- INIT
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sms';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_author, id_customer, type, id_branch, source, status, flag', 'numerical', 'integerOnly'=>true),
            array('id_sms, author, customer, content', 'length', 'max'=>255),
            array('phone, id_schedule', 'length', 'max'=>20),
            array('create_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_sms, id_author, author, id_customer, customer, phone, content, create_date, type, id_schedule, id_branch, source, status, flag', 'safe', 'on'=>'search'),
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
            'id_sms' => 'Id Sms',
            'id_author' => 'Id Author',
            'author' => 'Author',
            'id_customer' => 'Id Customer',
            'customer' => 'Customer',
            'phone' => 'Phone',
            'content' => 'Content',
            'create_date' => 'Create Date',
            'type' => 'Type',
            'id_schedule' => 'Id Schedule',
            'id_branch' => 'Id Branch',
            'source' => 'Source',
            'status' => 'Status',
            'flag' => 'Flag',
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
        $criteria->compare('id_sms',$this->id_sms,true);
        $criteria->compare('id_author',$this->id_author);
        $criteria->compare('author',$this->author,true);
        $criteria->compare('id_customer',$this->id_customer);
        $criteria->compare('customer',$this->customer,true);
        $criteria->compare('phone',$this->phone,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('type',$this->type);
        $criteria->compare('id_schedule',$this->id_schedule,true);
        $criteria->compare('id_branch',$this->id_branch);
        $criteria->compare('source',$this->source);
        $criteria->compare('status',$this->status);
        $criteria->compare('flag',$this->flag);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sms the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    #endregion

    #region --- CHUOI KET NOI SMS
    // function getSmsConnectInfo($id_branch) {
    //     return array(
    //         'url'       => 'http://14.241.253.96:8083/bsmsws.asmx?wsdl',
    //         'username'  => 'nk2000cs1ws',
    //         'password'  => 'NK2o0o^Cs!',
    //         'brandname' => 'NhaKhoa2000',
    //         'loaitin'   => 1
    //     );
    // }
    #endregion

    #region --- GUI TIN NHAN
    /**
     * số id (khác {2,3,4,5,6}) : thành công (ghi nhận id này để truy vấn trạng  thái của tin nhắn gửi đến các nhà mạng).
     * 2:  Sai số điện thọai
     * 3:  Lỗi database.
     * 4:  Username/ password không đúng.
     * 5:  Sai loại tin
     * 6:  Sai brandname
     */
    function sendSms($phone, $text, $id_branch, $id_author, $author, $id_customer, $customer, $id_schedule, $type = 1, $source = 1)
    {
        if(!$id_branch) {
            return -1;      // ko co ma tin nhan
        }

        // $SmsConnectInfo = $this->getSmsConnectInfo($id_branch);
        // $username  = $SmsConnectInfo['username'];
        // $password  = $SmsConnectInfo['password'];
        // $brandname = $SmsConnectInfo['brandname'];
        // $loaitin   = $SmsConnectInfo['loaitin'];

        // $client = new SoapClient($SmsConnectInfo['url']);

        $phone  = CsLead::model()->getVnPhone($phone);
        // $params = array("username"=>$username,"password"=>$password,"phonenumber"=>$phone,"message"=>$text,"brandname"=>$brandname,"loaitin"=>$loaitin);

        // $smsResult = $client->__soapCall('SendBrandSms', array('parameters' => $params));
        $smsResult = Yii::app()->sms->send($phone, $text, 'SendBrandSms');

        $idSms     = $smsResult->SendBrandSmsResult;

        $id_sms = 0;
        $status = 1;
        $smsRs = ($smsResult->SendBrandSmsResult)*-1;
        // gui thanh cong: id_Sms > 7 && id_sms != 100
        if(!isset($this->sendSMSError[$smsRs])) {
            $id_sms = $smsRs*-1;
        }
        else {
            $status = $smsRs;
        }

        $save = $this->saveSMS(array(
            'id_sms'      => $id_sms,
            'id_author'   => $id_author,
            'author'      => $author,
            'phone'       => $phone,
            'content'     => $text,
            'type'        => $type,      // 1: thong bao, 2: tai khoan, 3: lich hen
            'source'      => $source,    // 1: NV, 2: KH
            'status'      => $status,    // 1: thanh cong
            'id_customer' => $id_customer,
            'customer'    => $customer,
            'id_schedule' => $id_schedule,
            'flag'        => 1,
            'id_branch'   => $id_branch,
        ));

        return $status;
    }
    #endregion

    function saveSMS($smss = array('id_sms'=>'','id_author'=>'','author'=>'','phone'=>'','content'=>'','type'=>'','source'=>'','status'=>'','id_customer'=>'','customer'=>'', 'id_schedule'=>'','flag'=>1))
    {
        $sms                =   new Sms();
        $sms->attributes    =   $smss;

        if($sms->validate()) {
            $save = $sms->save();
            return array('status'=>$save, 'sms'=>$sms->attributes);
        }
        return array('status'=>-1, 'sms'=>$sms->getErrors());
    }

    public function searchSms($curpage,$limit,$time,$phone,$ct)
    {
        $start_point = $limit*($curpage-1);

        $p           = new Sms;
        $q           = new CDbCriteria(array(
        'condition'=>'published="true"'
        ));

        $v     = new CDbCriteria();
        $v->addCondition('flag >= 0');
        if($time) {
            if($time == 2) {              // hôm nay
                $time = date('Y-m-d');
                $v->addCondition('DATE(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
            elseif ($time == 3) {         // 7 ngày trước
                $time = date('Y-m-d',strtotime(date('Y-m-d') . ' - 7 day'));
                $v->addCondition('DATE(create_date) >= :create_date');
                $v->params = array(':create_date' => $time);
            }
            else {                               // tháng trước
                $time = date('m',strtotime(date('Y-m-d')));
                $v->addCondition('MONTH(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
        }
        if($phone) {
            $v->addSearchCondition('phone',$phone,true);
        }
        if($ct) {
            $v->addSearchCondition('content',$ct,true);
        }
        $count =count($p->findAll($v));

        $v->order = 'id DESC';
        $v->limit  = $limit;
        $v->offset = $start_point;
        $q->mergeWith($v);

        $data = $p->findAll($v);

        return array('count'=>$count,'data'=>$data);
    }

    public function delSms($id)
    {
        return Sms::model()->updateByPk($id, array('flag' =>-1));
    }

    public function addSms($smss = array('id_sms'=>'','phone'=>'','content'=>'','flag'=>'','status'=>''))
    {
        $sms                =   new Sms();
        $sms->attributes    =   $smss;

        if($sms->validate()) {
            return $sms->save();
        }
        return 0;
    }

/*****Gui mail******/
    public function sendMail($mailTo,$title,$email_content)
    {
        $mail = Yii::app()->Smtpmail;
        $mail->IsSMTP();
        $mail->Host = "mail.nhakhoa2000.vn";
        $mail->Port = 465; // or 587
        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

        $mail->Username = "support@nhakhoa2000.vn";
        $mail->Password = "6789@abc";
        $mail->IsHTML(true); // if you are going to send HTML formatted emails
        $mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
        $mail->SetFrom("support@nhakhoa2000.vn",'NhaKhoa2000 Support');
        $mail->Subject = $title;
        $mail->Body = $email_content;
        $mail->AddAddress($mailTo);
        $mail->CharSet = "utf-8";
        if(!$mail->Send()) {
            return 0;
        } else {
            return 1;
        }
    }

    public function filterCustomer($curpage, $limit, $type, $dateStart, $dateEnd)
    {
        $start_point = $limit*($curpage-1);

        $p = new Customer;

        $v = new CDbCriteria();
        $v->addCondition('status = 1');

        if($type == 1) {    // loc the ngay sinh nhat
            $v->addCondition("'$dateStart' <= DATE_FORMAT(birthdate, '%c-%d') AND DATE_FORMAT(birthdate, '%c-%d') <= '$dateEnd'");
        }
        else {              // loc theo ngay kham cuoi
            $v->addCondition("'$dateStart' <= DATE_FORMAT(lastdate, '%c-%d') AND DATE_FORMAT(lastdate, '%c-%d') <= '$dateEnd'");
        }

        $sumRow =count($p->findAll($v));
        $sumPage = ceil($sumRow/$limit);

        $v->limit  = $limit;
        $v->offset = $start_point;

        $data = $p->findAll($v);

        return array('sumRow'=> $sumRow, 'sumPage'=>$sumPage,'data'=>$data);
    }
}