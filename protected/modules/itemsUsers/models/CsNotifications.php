<?php

/**
 * This is the model class for table "cs_notifications".
 *
 * The followings are the available columns in table 'cs_notifications':
 * @property integer $id
 * @property integer $id_author
 * @property integer $id_dentist
 * @property string $action
 * @property integer $flag
 * @property string $data
 * @property string $createdate
 * @property integer $status
 */
class CsNotifications extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cs_notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_author, id_dentist, flag, status', 'numerical', 'integerOnly'=>true),
			array('action', 'length', 'max'=>255),
			array('data, createdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_author, id_dentist, action, flag, data, createdate, status', 'safe', 'on'=>'search'),
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
			'id_author' => 'Id Author',
			'id_dentist' => 'Id Dentist',
			'action' => 'Action',
			'flag' => 'Flag',
			'data' => 'Data',
			'createdate' => 'Createdate',
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
		$criteria->compare('id_author',$this->id_author);
		$criteria->compare('id_dentist',$this->id_dentist);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('flag',$this->flag);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CsNotifications the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getListNotifications(){		

     $data   = Yii::app()->db->createCommand()
	        ->select('*')
	        ->from('v_notification')
	        ->order('v_notification.creatdate DESC')
	        ->limit(10)
	        ->queryAll();
        return $data;
	}

	public function getUserListNotifications($id_user){

		if($id_user && Yii::app()->user->getState('group_id') == Yii::app()->params['id_group_dentist']){
			$data   = Yii::app()->db->createCommand()
		        ->select('*')
		        ->from('v_notification')
				->where('v_notification.id_dentist=:id_dentist', array(':id_dentist' => $id_user))
		        ->limit(10)
		        ->order('v_notification.creatdate DESC')
		        ->queryAll();
		}else{
			$data   = Yii::app()->db->createCommand()
		        ->select('*')
		        ->from('v_notification')
		        ->limit(10)
		        ->order('v_notification.creatdate DESC')
		        ->queryAll();
		}
     
        return $data;
	}


	public function sendMail($mailHost,$mailPort,$username,$password,$mailFrom,$mailTo,$title,$email_content){
        
        $SM = Yii::app()->swiftMailer;
        
        // New transport 
        $Transport = $SM->smtpTransport($mailHost, $mailPort)
        ->setUsername($username)
        ->setPassword($password);
        
         // Mailer
        $Mailer = $SM->mailer($Transport);
        
        // New message
        $Message = $SM
            ->newMessage($title)
            ->setFrom($mailFrom)
            ->setTo($mailTo)
            ->addPart($email_content, 'text/html','utf-8');
        $result = $Mailer->send($Message);
        return $result;
    }
	
	public function getSumNotificationsNotSeen($id_user){
	if($id_user && Yii::app()->user->getState('group_id') == Yii::app()->params['id_group_dentist'] ){
		$data   = Yii::app()->db->createCommand()
	        ->select('COUNT(*)')
	        ->from('cs_notifications')
	        ->where('cs_notifications.id_dentist=:id_dentist', array(':id_dentist' => $id_user))
	        ->order('cs_notifications.createdate DESC')
	        ->queryScalar();
	}else{
		$data   = Yii::app()->db->createCommand()
	        ->select('COUNT(*)')
	        ->from('cs_notifications')
	        ->where('cs_notifications.id_author=:id_author', array(':id_author' => $id_user))
	        ->order('cs_notifications.createdate DESC')
	        ->queryScalar();
			
	}
	
	$data_watched   = Yii::app()->db->createCommand()
	        ->select('COUNT(*)')
	        ->from('cs_notifications_history')
	        ->where('cs_notifications_history.id_user=:id_user', array(':id_user' => $id_user))
	        ->queryScalar();
		
        return $data-$data_watched;
	}

	public function getUser($id_user){
		return GpUsers::model()->findByPk($id_user);
	}

	public function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
		$then = new DateTime( $datetime );
		$diff = (array) $now->diff( $then );

		$diff['w']  = floor( $diff['d'] / 7 );
		$diff['d'] -= $diff['w'] * 7;

		$string = array(
			'y' => 'năm',
			'm' => 'tháng',
			'w' => 'tuần',
			'd' => 'ngày',
			'h' => 'giờ',
			'i' => 'phút',
			's' => 'giây',
		);

		foreach( $string as $k => & $v )
		{
			if ( $diff[$k] )
			{
				$v = $diff[$k] . ' ' . $v .( $diff[$k] > 1 ? '' : '' );
			}
			else
			{
				unset( $string[$k] );
			}
		}

		if ( ! $full ) $string = array_slice( $string, 0, 1 );
		return $string ? implode( ', ', $string ) . ' trước' : 'just now';
	}
}
