<?php

/**
 * It contains all message code variables , those we use in application
 */
class MessageCode 
{
   //starting with 'E' means Error
   //starting with 'M' means Message
   //starting with 'S' means Success

     //error cods//
    const ERROR_CODE_USER_DETAIL = 'error_code_user_detail';
    const ERROR_CODE_USER_ADDRESS = 'error_code_user_address';
    const ERROR_CODE_USER_PAYMENT = 'error_code_user_payment';
    
    const ERROR_CODE_IS_POSTER_LICENSE = 'ED101';
    const ERROR_TEXT_IS_POSTER_LICENSE = 'Invalid license (POSTER)';
      
     const ERROR_CODE_IS_VIRTUALDOER_LICENSE = 'ED102';
     const ERROR_CODE_IS_INPERSONDOER_LICENSE = 'ED103';
     const ERROR_CODE_IS_INSTANTDOER_LICENSE = 'ED104';
     const ERROR_CODE_IS_PREMIUMDOER_LICENSE = 'ED105';
     
     
     
     public  $msgCodes = array(
      'CommandNotFound' => 'E1001',
      'InvalidInputData' => 'E1002',
      'InvalidToken' => 'E1003',
      'MissingDeviceId' => 'E1004',
      'UserLoginFailed' => 'E1005',
      'CategoryListFailed' => 'E1006',
      'InvalidTaskType' => 'E1007',
      'CountryListFailed' => 'E1008',
      'StateListFailed' => 'E1009',
      'ProjectSearchFailed' => 'E1010',
      'ForgotPasswordFailed' => 'E1011',
      'ChangePasswordFailed' => 'E1012',
      'DoerSearchFailed' => 'E1013',
      'ViewProposalFailed' => 'E1014',
      'UserLicenceFailed' => 'E1015',
      'MyProjectsFailed' => 'E1016',
      'BookmarkUserFailed' => 'E1017',
      'BookmarkProjectFailed' => 'E1018',
      'BookmarkUserForProjectFailed' => 'E1019',
      
      
      
      //Payment related messages
      'InvalidMerchantDetail' => 'E1008',
      
      
      'SuccessCommand' => 'S1001',
      'UserLoginSuccess' => 'S1002',
      'CategoryListSuccess' => 'S1003',
      'CountryListSuccess' => 'S1004',
      'StateListSuccess' => 'S1005',
      'ProjectSearchSuccess' => 'S1006',
      'ForgotPasswordSuccess' => 'S1007',
      'ChangePasswordSuccess' => 'S1008',
      'DoerSearchSuccess' => 'S1009',
      'ViewProposalSuccess' => 'S1010',
      'UserLicenceSuccess' => 'S1011',
      'MyProjectsSuccess' => 'S1012',
      'BookmarkUserSuccess' => 'S1013',
      'BookmarkProjectSuccess' => 'S1014',
      'BookmarkUserForProjectSuccess' => 'S1015',
      
      'UnknownStatus' => 'U1001',
     );
     
     private $_errorMsg = array(
       'CommandNotFound' => 'E1001',
     );
     private $_successMsg = array(
      'SuccessCommand' => 'S1001',
     );
     private $_InfoMsg = array();
     
/*
     public function __construct(){
      
      //$msgCodes = array_merge(self::$_errorMsg, self::$_successMsg, self::$_InfoMsg);
      
      //$msgCodes = Yii::app()->cache->get('MessageCodes');
      //if($msgCode === false){
         
         
      //   $msgCodes = Yii::app()->cache->set('MessageCodes', self::msgCodes);
      //}else{
      //   $msgCodes = Yii::app()->cache->get('MessageCodes');
      //}
      //return $msgCodes;
      
      return $this->msgCodes;
     }
   
   */
    public function __get($name)
    {
      //echo $name;
       // echo "Getting {$name}\n";
        if (array_key_exists($name, $this->msgCodes)) {
            return $this->msgCodes[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
    
    
    public function  __destruct() {
        // disconnect from the network

        //echo ' was destroyed' . PHP_EOL;
    }
    
   //public function getMessageCode()  
}