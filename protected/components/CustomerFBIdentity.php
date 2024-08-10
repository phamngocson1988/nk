<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CustomerFBIdentity extends CUserIdentity
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
        
		$data = Customer::model()->findByAttributes(array('id_fb'=>$idFB));

        if($data === null){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
			$this->errorMessage = 'Incorrect id facebook.';
        }
        else {
			if($data->status == '-1') {
			     //if user is blocked
    			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
    			$this->errorMessage = 'Your login has been blocked. Please contact the Support nha khoa 2000.';
    			return $this->errorCode;
			}
            else {
                Yii::app()->user->setState('customer_id', $data->id);
    			Yii::app()->user->setState('customer_name', $data->fullname);
    			Yii::app()->session['guest'] = false;

                $this->errorCode=self::ERROR_NONE;

				return $this->errorCode;
            }
		}
        
		return !$this->errorCode;

    }

}