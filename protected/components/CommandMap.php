<?php

/**
 * It contains all functions mapping with their related classes
 */
class CommandMap 
{
    const ERROR_CODE_USER_DETAIL = 'error_code_user_detail';
    
     public  $msgCodes = array(
      'CommandNotFound' => 'E1001',
      'InvalidInputData' => 'E1002',
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
   
   public static function getFnClass($fn){
      if(empty($fn)){
         return false;
      }
      
      $class_fns = array(
         'user_login' => 'UserApi',
         'user_logout' => 'UserApi',
         'user_register' => 'UserApi',
         'get_user' => 'UserApi',
         'get_category' => 'UserApi',
         'get_subcategory' => 'UserApi',
         'get_country' => 'UserApi',
         'get_state' => 'UserApi',
         'search_projects' => 'UserApi',
         'forgot_password' => 'UserApi',
         'change_password' => 'UserApi',
         'search_doers' => 'UserApi',
         'view_proposal' => 'UserApi',
         'user_licence' => 'UserApi',
         'my_projects' => 'UserApi',
         'bookmark_user' => 'UserApi',
         'bookmark_project' => 'UserApi',
         'bookmark_user_for_project' => 'UserApi',
      );
      
      if(array_key_exists($fn, $class_fns)){
         return $class_fns[$fn];
      }
   }
    
    
    public function  __destruct() {
        // disconnect from the network

        //echo ' was destroyed' . PHP_EOL;
    }
    
}