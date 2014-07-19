<?php

class ApiController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
   
   private $_response = array();
   private $dataFormat = 'json';
   
   public $options = array('status' => 'ok', 'res_code' => '200', 'status_code' => '', 'msg' => '', 'tag' => '', 'data' => '');
   
   Const APPLICATION_ID = 'ASCCPE';
    
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
            $perform = $this->Permissions();
             
            return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions
                    'actions'=>array('index','view','changepassword','changestatus','updateaccount','autocompleteemail','autocompletelogin_name'),
                    'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions'=>$perform,
                    'users'=>array('@'),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array('api','delete'),
                    'users'=>array('api'),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
            );
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
   //echo 'API index function called<br/>';
/*   
   $reqq = array(
         'api_version' => '1',
         'device_id' => '123',
         //'user_id' => '316',
         //'cmd' => 'self_user_login',
         'cmd' => 'user_login',
         //'cmd' => '',
         'data' => array(
            'username' => 'mukulmedatwal@gmail.com',
            'password' => 'test@123',
      ),
      'tag' => '1'
      );
*/

//   $reqq = array(
//         'api_version' => '1',
//         'device_id' => '123',
//         'token' => 'yWH5tF+F9aI0N0UCUJ2vujtifjX9rHhZISTljqrxjr24/nA0vG4yH2ZMSSrzFwcywMGeYlEvhcBbsC/1dIkN1m/T+GWAFd9FvW33V8j3pYG3NPhNBs7o1LTlNAb71w/A',
//         //'cmd' => 'self_user_login',
//         'cmd' => 'get_user',
//         //'cmd' => '',
//         'data' => array(
//            'user_id' => '316',
//            //'password' => 'test@123',
//      ),
//      'tag' => '1'
//      );
   
//   $reqqq = "{'api_version':'1',
//      'cmd':'user_login',
//      'data':[{
//         'username':'mukulmedatwal@gmail.com',
//         'password':'test@123',
//      }],
//      'tag':'1',
//   }";

//   $req = json_encode($reqq);
//   $req = json_decode($req, true);
   //echo ErrorCode::ERROR_CODE_IS_VIRTUALDOER_LICENSE;
   //$a = new MessageCode();
   //echo $a->CommandNotFound;
//print_r(Yii::app()->request->getRawBody());
//die();
//$req =$_POST; 
   //$post = file_get_contents("php:input");
   //print_r($_GET);
   //$post = Yii::app()->request->getRawBody();
   //$post = Yii::app()->request->getPost();
    //print_r($post);
   //$req = $_GET;
   //$req = json_decode($post, true);
   //check if data is received as input
   //echo 'incoming data';
   //print_r($req);
   //die();
   $req = $_REQUEST['data'];
//   $req = $this->testGetCategories();
//   echo '<pre>';
//   print_r($req);exit;
   $req = CJSON::decode($req, true);
//  print_r($req);exit;
   if(empty($req) || empty($req['cmd'])){
      $options = array('status' => 'error', 
            'res_code' => '404', 
            'status_code' => 'CommandNotFound',
            'msg' => '', 
            'tag' => '', 
            'data' => ''
      );
      //CommonUtility::pre(CJSON::encode($options));
      $this->_sendResponse( $this->getResponseOptions($options) );
      Yii::app()->end();
      
      //echo '<pre>';
      // print_r(json_encode($options));
      //echo '</pre>';
   }
  // $options = array('status' => 'error', 'res_code' => '404', 'status_code' => '0', 'msg' => 'Command not found', 'tag' => '', 'data' => '');
   

   if(empty($req['cmd'])){
      $options = array('status' => 'error', 
            'res_code' => '501', 
            'status_code' => 'CommandNotFound', 
            'msg' => sprintf('%s Command not found', $req['cmd']), 
            'tag' => '', 
            'data' => ''
      );
      
      //CommonUtility::pre(json_encode($options));
      
      $this->_sendResponse( $this->getResponseOptions($options) );
      
      Yii::app()->end();
   }

   //if($req['cmd'] === 'user_login'){
  //    $r = call_user_func(array('UserApi', $req['cmd']), $req);
  // }



   //$r = call_user_func(CommandMap::getFnClass($req['cmd']).'::'.$req['cmd'], $req);
   
   
   try{
      if(CommandMap::getFnClass($req['cmd']) === '' || CommandMap::getFnClass($req['cmd']) === null){
         throw new Exception('Class function not found');
      }
      
      $r = call_user_func(array(CommandMap::getFnClass($req['cmd']), $req['cmd']), $req);
      
      $result = json_decode($r, true);

      $status_code = (!empty($result['status_code'])) ? $result['status_code'] : 'UnknownStatus'; 
      $options = array('status' => $result['status'], 
               'res_code' => '200', 
               'status_code' => $status_code, 
               //'msg' => sprintf('%s Command not found', $req['cmd']), 
               'tag' => '', 
               'data' => $result['data']
         );
            
   }catch(Exception $e){

      $options = array('status' => 'error', 
            'res_code' => '404', 
            'status_code' => 'CommandNotFound',
            'msg' => $e->getMessage(), 
            'tag' => '', 
            'data' => ''
      );
   }

   
   $this->_sendResponse( $this->getResponseOptions($options) );
   Yii::app()->end();

	}


   
   private function setToken($deviceId, $userId, $expiry){
      $string = $deviceId . $userId . $expiry;
      $encKey = Yii::app()->getSecurityManager()->getEncryptionKey();
      $token = utf8_encode(Yii::app()->securityManager->encrypt( $string, $encKey ));

   }
   
   
   function hash_compare($a, $b) { 
        if (!is_string($a) || !is_string($b)) { 
            return false; 
        } 
        
        $len = strlen($a); 
        if ($len !== strlen($b)) { 
            return false; 
        } 

        $status = 0; 
        for ($i = 0; $i < $len; $i++) { 
            $status |= ord($a[$i]) ^ ord($b[$i]); 
        } 
        return $status === 0; 
    } 

   
   
   public function getResponseOptions($options = array()){
      return array_merge($this->options, $options);  
   }
   
   
 private function _sendResponse($options = array())
   {

     $status_header = 'HTTP/1.1 ' . $options['res_code'] . ' ' . $options['res_code'];
     header($status_header);
     // and the content type
     header('Content-type: ' . $this->getContentType());

     if($options['status'] === 'error'){
         $res = array();
         $res['status'] = 'error';
         $res['err_code'] = self::_getStatusCode($options['status_code']);
         $res['err_msg'] = $options['status_code'];  
         $res['msg'] = $this->_getStatusCodeMessage($options['status_code']);
      
         if(isset($options['tag'])){
            $res['tag'] = $options['tag'];
         }
     }else{
         $res = array();
         $res['status'] = 'ok';
         $res['status_code'] = self::_getStatusCode($options['status_code']);
         $res['status_msg'] = $options['status_code'];     
         $res['msg'] = $this->_getStatusCodeMessage($options['status_code']);
         $res['data'] = $options['data'];
         if(isset($options['tag'])){
            $res['tag'] = $options['tag'];
         }
     }
//CommonUtility::pre($res);
      echo CJSON::encode($res);

    Yii::app()->end();
    
 
   }
   
    private function _getStatusCode($msgCode){
      $msg = new MessageCode();
      //echo 'kkkkkkk';
      //echo $msgCode;
      return $msg->$msgCode;
   }
   
   private function _getStatusCodeMessage($msgCode){
      $msg = new MessageCode;
       
      return Yii::t('api_index', self::_getStatusCode($msgCode));
   }
   
   protected function getContentType(){
      
      switch($this->dataFormat){
         case 'json':
            return 'application/json';
         break;
         case 'html':
            return 'text/html';
         break;
         default:
            return 'application/json';
      }
      
   }
	/**
	 * Performs the AJAX validation.
	 * @param Admin $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
      if(isset($_POST[Globals::FLD_NAME_AJAX]) && ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_ADMIN_FORM))
      {
          echo CActiveForm::validate($model);
          Yii::app()->end();
      }
	}
        
        private function testGetCategories()
        {
            $reqq = array(
                'api_version' => '1',
                'device_id' => '123',
                'token' => 'yWH5tF+F9aI0N0UCUJ2vujtifjX9rHhZISTljqrxjr24/nA0vG4yH2ZMSSrzFwcywMGeYlEvhcBbsC/1dIkN1m/T+GWAFd9FvW33V8j3pYG3NPhNBs7o1LTlNAb71w/A',
                //'cmd' => 'self_user_login',
                'cmd' => 'get_category',
                //'cmd' => '',
                'data' => array(
                    'user_id' => '316',
                    //'password' => 'test@123',
                ),
                'tag' => '1'
            );
            return json_encode($reqq);
        }
}
