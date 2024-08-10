<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CustomerIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the phone and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

    private $_id;

    public function authenticate() {

		$email = strtolower($this->username);
        
		$data = Customer::model()->findByAttributes(array('email'=>$email));

        if($data === null){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
			$this->errorMessage = 'Email chưa đăng ký tài khoản. Vui lòng đăng ký tài khoản.';
        }
        else {
			if($data->status == '-1') {
			     //if user is blocked
    			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
    			$this->errorMessage = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với Nha Khoa 2000 đễ được hỗ trợ.';
    			return $this->errorCode;
                //Your login has been blocked. Please contact the Support nha khoa 2000.
			}
            else {
                
    			if($data->password !== md5($this->password)) { //if password not match
        			$this->errorCode = self::ERROR_PASSWORD_INVALID;
        			$this->errorMessage = 'Mật khẩu không đúng.';
    			}
    			else {

                    Yii::app()->user->setState('customer_id', $data->id);
        			Yii::app()->user->setState('customer_name', $data->fullname);
        			Yii::app()->session['guest'] = false;

                    $this->errorCode=self::ERROR_NONE;

                  

					return $this->errorCode;
    			}
            }
		}
        
		return $this->errorCode;

    }

}