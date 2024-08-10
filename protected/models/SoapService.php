<?php
class SoapService
{
	function webservice_server_ws($function_name,$param)
	{
		return; // for test ipcc
		// try {
		// 	$client = new SoapClient(Yii::app()->params['url_base_http']."/ws_nhakhoa2000/soap/ws", array('cache_wsdl' => "WSDL_CACHE_NONE"));
		// 	$result = $client->$function_name(CJSON::encode($param)); 
        //     return CJSON::decode($result);
		// } catch (SoapFault $fault) {
		// 	trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
		// }
	}

	function ipcc_server_ws($function_name,$param)
	{
		return; // for test ipcc
		// try {
		// 	$client = new SoapClient(Yii::app()->params['Soap_ipcc'], array('cache_wsdl' => "WSDL_CACHE_NONE"));
		// 	$result = $client->$function_name(CJSON::encode($param)); 
        //     return CJSON::decode($result);
		// } catch (SoapFault $fault) {
		// 	trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
		// }
	}
}
?>