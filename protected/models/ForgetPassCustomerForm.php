<?php
/**
* 
*/
class ForgetPassCustomerForm extends CFormModel
{
	public $email;
	
	public function rules(){
		return array(
			// email required
			array('email', 'required'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'email'=>'Email',
		);
	}
}