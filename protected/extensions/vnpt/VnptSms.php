<?php
class VnptSms extends CApplicationComponent {
    private $_api = 'http://14.241.253.96:8083/brandnamews.asmx?wsdl';
    public $username;
	public $password;
	public $brandname; 
    public $loaitin = 1;
    public $enable = true;

    protected function getClient() {
        return new SoapClient($this->_api);
    } 

    public function send($phone, $message, $sendType) {
        if (!$this->enable) throw new Exception('VNPT SMS Service is disabled.'); 

        $client = $this->getClient();
        $params = array(
            "username" => $this->username,
            "password" => $this->password,
            "phonenumber" => $phone,
            "message" => $message,
            "brandname" => $this->brandname,
            "loaitin" => $this->loaitin
        );
	  	$smsResult = $client->__soapCall($sendType, array('parameters' => $params));
	    return  $smsResult;
    }

}