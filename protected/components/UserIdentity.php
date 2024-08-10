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
            $group   = GpGroup::model()->findByPk($user->group_id);
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
                 
                    Yii::app()->user->setState('user_id', $user->id);
                    Yii::app()->user->setState('name', $user->name);
                    Yii::app()->user->setState('username', $user->username);

                    Yii::app()->user->setState('user_branch', $user->id_branch);

                    Yii::app()->user->setState('group_id', $group->id);
                    Yii::app()->user->setState('queue_login', $group->queues);
                    Yii::app()->user->setState('group_no', $group->group_no);
                    Yii::app()->user->setState('group_name', $group->group_name);
                    
                    
                    $isAdmin = ($group->group_no == 'admin')?true:false;
                    Yii::app()->user->setState('isAdmin', $isAdmin);

                    $isSuperAdmin = ($group->group_no == 'superadmin')?true:false;
                    Yii::app()->user->setState('isSuperAdmin', $isSuperAdmin);

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