<?php

class CallController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='/layouts/main_extension';


	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules()
	{
		return parent::accessRules();
	}

	public function actionView()
	{

		$this->render('view');
	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CsExtensionCall');
		$this->render('index',array(
		'dataProvider'=>$dataProvider,
		));
	}

	public function actionRegisterextension() {
   

		return; // for test ipcc
        $client = new SoapClient(Yii::app()->params['Soap_ipcc']);
        

        if(isset($_REQUEST['registerExtension'])) {

        

            $username = Yii::app()->user->getState('username'); // Tên user đăng nhập

            $login_ip = CHttpRequest::getUserHostAddress();

            $password = UserManager::getPasswordById(Yii::app()->user->getState('user_id'));


            $extensions = $_REQUEST['extensions']; // Số cuối cùng extensions
            
            $queues = $_REQUEST['queues']; // Hàng đợi

            $params = array('username'=>$username, 'password'=>$password, 'extensions'=>$extensions, 'queues'=>$queues, 'login_ip'=>$login_ip);
   		
            $result = $client->registerExtension(CJSON::encode($params));

         


            $arr = CJSON::decode($result); 
                
            if($arr['Response'] == 'Success') {

                Yii::app()->user->setState('registered', true);// gán chuyền biến
                Yii::app()->user->setState('id_register', '');
                Yii::app()->user->setState('id_register', $arr['id_register']['0']);
                Yii::app()->user->setState('extensions', '');
                Yii::app()->user->setState('extensions', $extensions);
                Yii::app()->user->setState('queues', '');
                Yii::app()->user->setState('queues', $queues);
                Yii::app()->user->setState('id_agent_break', '-1');
             
            //$this->redirect(array('/itemsDashBoard/DashBoardBusiness/index'));
                $this->redirect(array('/itemsSchedule/calendar/index'));
                Yii::app()->end();
            }
            else {
                Yii::app()->user->setState('registered', false);
            }
        }

        if(isset($_REQUEST['skip'])) {

            $username = Yii::app()->user->getState('username');
            $params = array('username'=>$username);

            $result = $client->getAgentLogin(CJSON::encode($params));
            $arr = CJSON::decode($result);
            
            if($arr && $arr['id_register'] > 0) {
                Yii::app()->user->setState('registered', true);
                Yii::app()->user->setState('id_register', $arr['id_register']);
                $extensions = $arr['extensions'];
                Yii::app()->user->setState('extensions', $extensions);

                $queues = explode('-', $arr['queues']);

                Yii::app()->user->setState('queues', $queues);
                Yii::app()->user->setState('id_agent_break', '-1');

                $this->redirect(array('/itemsDashBoard/DashBoardBusiness/index'));

                Yii::app()->end();
            }
            else {
                Yii::app()->user->setState('registered', false);
            }
        }

        $all_extension = CJSON::decode($client->getAllExtension());
        
        $extensions = CJSON::decode($client->getExtensions());

        $skip = false;
        	
        if(is_array($extensions) && $extensions){
            if(count($extensions) > 0){
                foreach($extensions as $ext){
                    if($ext['username'] == Yii::app()->user->getState('username')){                    
                        $skip = true;
                    }
                }   
            }
        }
        
        $queues = CJSON::decode($client->getQueueList());

        $this->render('registerextension', array('queues'=>$queues,'all_extension'=>$all_extension, 'extensions'=>$extensions, 'skip'=>$skip));
    }

    public function actionClickToCall(){

        if(isset($_POST['phone']) && $_POST['phone']){

            $id_register = Yii::app()->user->getState('id_register');
            $phone       = $_POST['phone'];
            $phone       = preg_replace("/[^0-9]/", "", $phone);
            $soapService = new SoapService();
            $prefix_phone  = substr($phone, 0, 2);
            if($prefix_phone == "84"){
                $phone =  '90'.substr($phone,2,strlen($phone));
            }
            $result      = $soapService->ipcc_server_ws('click_to_call_ws',array($id_register,$phone));
          
            if(is_array($result) and in_array('Success',$result)){
                echo 1;
            }else{
                echo -1;
            }

        }
    }

    public function actionBreakagent() {
		return; // for test ipcc
        $client = new SoapClient(Yii::app()->params['Soap_ipcc']);

        if(isset($_REQUEST['id_break'])) {

            $username       = Yii::app()->user->getState('username');
            $extensions     = Yii::app()->user->getState('extensions');
            $queues         = Yii::app()->user->getState('queues');
            $id_register    = Yii::app()->user->getState('id_register');
            $id_break       = $_REQUEST['id_break'];

            $params         = array('username'=>$username, 'extensions'=>$extensions, 'queues'=>$queues, 'id_break'=>$id_break, 'id_register'=>$id_register);
            $result         = $client->breakAgent(CJSON::encode($params));
            $arr            = CJSON::decode($result);
            extract($arr);

            if($Response == 'Success') {
                Yii::app()->user->setState('id_agent_break', $id_agent_break);
            }

            die($Response);

            Yii::app()->end();
        }

        $result = $client->getBreakTypeList();
        $arr = CJSON::decode($result);

        $breakTypeList = array();

        foreach($arr as $break) {
            $breakTypeList[$break['id']] = $break['name'];
        }

        $this->renderPartial('break', array('breakTypeList'=>$breakTypeList));
    }

    public function actionUnbreakagent() {

		return; // for test ipcc
        $client         = new SoapClient(Yii::app()->params['Soap_ipcc']);

        $username       = Yii::app()->user->getState('username');
        $extensions     = Yii::app()->user->getState('extensions');
        $queues         = Yii::app()->user->getState('queues');
        $id_agent_break = Yii::app()->user->getState('id_agent_break');
        $id_register    = Yii::app()->user->getState('id_register');

        $params         = array('username'=>$username, 'extensions'=>$extensions, 'queues'=>$queues, 'id_agent_break'=>$id_agent_break, 'id_register'=>$id_register);

        $result         = $client->unbreakAgent(CJSON::encode($params));
        $arr            = CJSON::decode($result);
        Yii::app()->user->setState('id_agent_break', '-1');
        extract($arr);

        die($Response);
    }


	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=CsExtensionCall::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cs-extension-call-form')
		{
		echo CActiveForm::validate($model);
		Yii::app()->end();
		}
	}
}
