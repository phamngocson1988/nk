<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

    private $_id;

    public function authenticate() {
        //echo $this->username; exit;
        //$user = User::model()->findByAttributes(array('username'=>$this->username));
        $user_name=strtolower($this->username);
        $Manager =  new UserManager();
        
        $user= GpUsers::model()->find('LOWER(username)=?',array($user_name));
        
        if($user === null){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
			$this->errorMessage = 'Incorrect username or password.';
        }
        else {
			$user_id    = $user->id;
            $group_id   = GpUsers::model()->findByPk($user_id)->group_id;
            $group_no   = GpGroup::model()->findByPk($group_id)->group_no;
            $group_name = GpGroup::model()->findByPk($group_id)->group_name;
            //$queue_login = Role::getQueueLogin($group_id);
			if($user->block != 0) { 
			     //if user is blocked
    			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
    			$this->errorMessage = 'Your login has been blocked. Please contact the administrator.';
    			return $this->errorCode;
			}
            else {
                
    			if($user->password !== md5($this->password)) { //if password not match
        			$this->errorCode = self::ERROR_PASSWORD_INVALID;
        			$this->errorMessage = 'Incorrect username or password.';
    			}
    			else {
    			 
        			Yii::app()->user->setState('user_id', $user_id);
        			Yii::app()->user->setState('user_name', $user_name);
        			Yii::app()->user->setState('group_id', $group_id);
        			Yii::app()->user->setState('group_no', $group_no);
        			Yii::app()->user->setState('group_name', $group_name);
                    
                    $isAdmin = ($group_no == 'admin')?true:false;
                    Yii::app()->user->setState('isAdmin', $isAdmin);

                    $isSuperAdmin = ($group_no == 'superadmin')?true:false;
                    Yii::app()->user->setState('isSuperAdmin', $isSuperAdmin);

                    $isSuperAdmin = ($group_no == 'manager')?true:false;
                    Yii::app()->user->setState('isManager', $isSuperAdmin);

                    $this->errorCode=self::ERROR_NONE;
    			}
            }
		}
        $b = new CHttpRequest();
        $arr = array("username"=>$this->username,
                    "password"=>($this->errorCode != self::ERROR_NONE)?$this->password:'',
                    "ip"=>$b->getUserHostAddress(),
                    "error_code"=>$this->errorCode,
                    "error_msg"=>$this->errorMessage);

        //save in history login
        $history_login_id = $Manager->saveHistoryLogin($arr);
        Yii::app()->user->setState('history_login_id', $history_login_id);

		return !$this->errorCode;
    }
}