<?php
/**
 * This class manages payment relates tasks
 * 
 */
 class Payment extends CComponent
{
   private $demoCustomerInfo = array('firstName' => 'Mike',
                               'lastName' => 'Jones',
                               'company' => 'Jones Co.',
                               'email' => 'mike.jones@example.com',
                               'phone' => '281.330.8004',
                               'fax' => '419.555.1235',
                               'website' => 'http://example.com'
               );
   private $demoCcInfo = array(
                       "number" => '4111111111111111',
                       "expirationMonth" => '11',
                       "expirationYear" => '2015',
                       "cvv" => '111',
         );
   private $demoBillingAdd = array(
                              'firstName' => 'Drew',
                              'lastName' => 'Smith',
                              'company' => 'Smith Co.',
                              'streetAddress' => '1 E Main St',
                              'extendedAddress' => 'Suite 101',
                              'locality' => 'Chicago',
                              'region' => 'IL',
                              'postalCode' => '60622',
                              'countryCodeAlpha2' => 'US'
        );
        
   public $customer = array();
   public $creditCard = array();
   public $billingAdd = array();
   public $shippingAdd = array();
   public $options = array();
   private $data = array();
   public $transaction = array();
   
   public $failOnDuplicatePaymentMethod = true;
   public $verifyCard = true;
   private $merchantAccountId = null;
   public $submitForSettlement = true;
   private $amount = null;
   //public $response = array();
   
  // public $errors = array();

  // private function responseMessage(){
      
  // }
   
   public function setBtMerchantAccount(){
      $this->merchantAccountId = Yii::app()->params['braintreeapi']['merchant_id'];
   }
   
   public function getBtMerchantAccount(){
      return $this->merchantAccountId;
   }

   
   
   public function prepareBtTransaction(){
      $transaction = array();
      //$this->transactionInfo['amount'] = $this->amount;
      //$this->transactionInfo['orderId'] = $this->orderId;
      //$this->transactionInfo['merchantAccountId'] = $this->orderId;
      $transaction = array(
                     'amount' => '',
                     'merchantAccountId' => Yii::app()->params['braintreeapi']['merchant_id'],
               );
      
      $options = array(
                      'submitForSettlement' => true,
                    );
      
      if(!empty($this->transaction)){
         $this->data = array_merge($transaction, $this->transaction);
      }else{
         $this->data = $transaction;
      }
      
      if(!empty($this->customer)){
         $this->data['customer'] = $this->customer;
      }
      
      if(!empty($this->creditCard)){
         $this->data['creditCard'] = array_shift($this->creditCard);
      }
      
      if(!empty($this->billingAdd)){
         $this->data['billingAdd'] = $this->billingAdd;
      }
      
      if(!empty($this->shippingAdd)){
         $this->data['shippingAdd'] = $this->shippingAdd;
      }
      
      
      
      if(!empty($this->options)){
         $this->data['options'] = array_merge($options, $this->options);
      }else{
         $this->data['options'] = $options;
      }
      
      return $this->data;// = array_shift($this->data['transaction']);
   }
   
   public function prepareBtTransactionFromVault(){
      $transaction = array();
      //$this->transactionInfo['amount'] = $this->amount;
      //$this->transactionInfo['orderId'] = $this->orderId;
      //$this->transactionInfo['merchantAccountId'] = $this->orderId;
      $transaction = array('merchantAccountId' => Yii::app()->params['braintreeapi']['merchant_id'],);
      
      $options = array(
                      'submitForSettlement' => true,
                    );
      
     if(!empty($this->transaction)){
         $this->data = array_merge($transaction, $this->transaction);
      }else{
         $this->data = $transaction;
      }
      
      if(!empty($this->options)){
         $this->data['options'] = array_merge($options, $this->options);
      }else{
         $this->data['options'] = $options;
      }
      
      return $this->data;
   }
   
   public function doBtEscrow(){
      $data = null;
      CommonUtility::pre($this->options);
      if(!empty($this->options) && $this->options['holdInEscrow'] === true && $this->options['useStoredPaymentMethod'] === true){
         if(isset($this->options['useStoredPaymentMethod'])){
         echo 'test55';
            unset($this->options['useStoredPaymentMethod']);
            
         }
         $data = $this->prepareBtTransactionFromVault();

      }
      else{
         echo 'test1';
         
         if(isset($this->options['useStoredPaymentMethod'])){
         echo 'test2';
            unset($this->options['useStoredPaymentMethod']);
            
         }
         $data = $this->prepareBtTransaction();
      }
      CommonUtility::pre($data);
     // die();
      $bt = new BraintreeApi;
      $bt->options = $data;
      $result = $bt->doTransaction();
      
      CommonUtility::pre($result);
   }
   
   
   public function getBtCustomerAccount($id){
      if(empty($id)){
         $extraInfo = array('hideoutput' => true);
         $msg = 'Invalid Customer Id';
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         $errorMessages = array();
         $errorMessages[404]['message'] = $msg;
         $errorMessages[404]['code'] = 404;
         
         $response['status'] ='error';
         $response['data'] = array('errors' => $errorMessages);

         return $response;
      }
      
      try{
      
      $bt = new BraintreeApi;
      $result = $bt->findCustomer($id);
      $response = array();
      //CommonUtility::pre($result);

      
            if ($result['status']) {
               $res = $result['result'];
 
               $createdAt = get_object_vars($res->createdAt);
               $updatedAt = get_object_vars($res->updatedAt);

               $creditCards = array();
              foreach($res->creditCards as $k=> $y){
                  $creditCards[$k] = $y;
                  foreach($y as $kk=>$yy){
                     //Print_r($yy);   
                     $creditCards[$k] = $yy;
                  }
                  
               }

               $customer = //array('customer' => 
               array('id' => $res->id,
               'merchantId' => $res->merchantId,
               'firstName' => $res->firstName,
               'lastName' => $res->lastName,
               'company' => $res->company,
               'email' => $res->email,
               'phone' => $res->phone,
               'fax' => $res->fax,
               'website' => $res->website,
               'createdAt' => array('date' => $createdAt['date'], 
                        'timezone_type' => $createdAt['timezone_type'], 
                        'timezone' => $createdAt['timezone']
                        ),
               'updatedAt' => array('date' => $updatedAt['date'], 
                        'timezone_type' => $updatedAt['timezone_type'], 
                        'timezone' => $updatedAt['timezone']
                        ),
                'customFields' => $res->customFields,
               // ),
                'creditCards' => $creditCards
             
             );
          
              //  CommonUtility::pre($customer);

               $response['status'] = 'success';
               $response['data'] = array('customer' => $customer);
               return $response;
            } else {
               $msg = "get customer errors:";
                //echo("Payment validation errors:<br/>");
                $errorMessages = array();

               $errorMessages[0]['message'] = $result['result'];
               $response['status'] ='error';
               $response['data'] = array('errors' => $errorMessages);
               return $response;
            }
            
         }catch(Exception $e){
            $extraInfo = array('hideoutput' => true);
            $extraInfo['CustomerId'] = $id ;
            $extraInfo['errorCode'] = $e->getCode();
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg, $extraInfo  );
            
            throw new Exception($msg, $e->getCode());
         }
      
      //return false;
   }
   
   
   public function createBtCustomerAccount(){
      //CommonUtility::pre($this->customer);
      
      if(!empty($this->customer)){
         $this->data['customer'] = $this->customer;
      }
      
      if(!empty($this->creditCard)){
         $this->data['customer']['creditCard'] = $this->creditCard;
      }
      
      if(!empty($this->billingAdd)){
         $this->data['customer']['creditCard']['billingAddress'] = $this->billingAdd;
      }

      //CommonUtility::pre($this->data);
      //die('test');
      $customer = new BraintreeApi;
      $customer->options=$this->data;
      $response = array();
      try{
       $result = $customer->createCustomer();
      // CommonUtility::pre($result);

            $res = $result['result'];
            if ($res->success) {

               $createdAt = get_object_vars($res->customer->createdAt);
               $updatedAt = get_object_vars($res->customer->updatedAt);

               $creditCards = array();
               foreach($res->customer->creditCards as $k=> $y){
                  $creditCards[$k] = $y;
                  foreach($y as $kk=>$yy){
                     //print_r($yy);   
                     $creditCards[$k] = $yy;
                  }
               }
               
               $customer = array('customer' => array('id' => $res->customer->id,
               'merchantId' => $res->customer->merchantId,
               'firstName' => $res->customer->firstName,
               'lastName' => $res->customer->lastName,
               'company' => $res->customer->company,
               'email' => $res->customer->email,
               'phone' => $res->customer->phone,
               'fax' => $res->customer->fax,
               'website' => $res->customer->website,
               'createdAt' => array('date' => $createdAt['date'], 
                        'timezone_type' => $createdAt['timezone_type'], 
                        'timezone' => $createdAt['timezone']
                        ),
               'updatedAt' => array('date' => $updatedAt['date'], 
                        'timezone_type' => $updatedAt['timezone_type'], 
                        'timezone' => $updatedAt['timezone']
                        ),
                'customFields' => $res->customer->customFields,
                ),
                'creditCards' => $creditCards
             
             );

              // CommonUtility::pre($customer);
                                                                           
               $response['status'] = 'success';
               $response['data'] = $customer;
               return $response;
            } else {
               $msg = "Payment validation errors:";
                //echo("Payment validation errors:<br/>");
                $errorMessages = array();
                foreach (($res->errors->deepAll()) as $error) {
                  $errorMessages[$error->code]['attribute'] = $error->attribute;
                  $errorMessages[$error->code]['message'] = $error->message;
                  $errorMessages[$error->code]['code'] = $error->code;
                  
                  //echo $error->code;
                  //CommonUtility::pre($error);
                    $msg .= "- " . $error->message . ", ";
                    //echo("- " . $error->message . "<br/><br/><br/>");
                }
                
                $extraInfo = array();
                if(!empty($this->data['customer']['id'])){
                  $extraInfo = array('CustomerId' => $this->data['customer']['id']) ;
                }

                //CommonUtility::catchErrorMsg( $msg, $extraInfo);
               $response['status'] ='error';
               $response['data'] = array('errors' => $errorMessages);
               return $response;
            }

      }catch(Exception $e){
        $extraInfo = array('hideoutput' => true);
       // $extraInfo['CustomerId'] = $customerId ;
        $msg = $e->getMessage();
        CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
     }
      return false;
      
   }
   
   public function updateBtCustomerAccount(){
      //CommonUtility::pre($this->customer);
      
      if(!empty($this->customer)){
         $this->data['customer'] = $this->customer;
      }
      
      if(!empty($this->creditCard)){
         $this->data['customer']['creditCard'] = $this->creditCard;
      }
      
      if(!empty($this->billingAdd)){
         $this->data['customer']['creditCard']['billingAddress'] = $this->billingAdd;
      }
      
      $customerId = isset($this->customer['id']) ? $this->customer['id'] : '';
     
      if($customerId){
         $customerId = $this->customer['id'];
         unset($this->data['customer']['id']);
      }

      $customer = new BraintreeApi;
      $customer->options=$this->data;
      $response = array();
      try{
       $result = $customer->updateCustomer($customerId);
      // CommonUtility::pre($result);

            $res = $result['result'];
            if ($res->success) {

               $createdAt = get_object_vars($res->customer->createdAt);
               $updatedAt = get_object_vars($res->customer->updatedAt);

               $creditCards = array();
               foreach($res->customer->creditCards as $k=> $y){
                  $creditCards[$k] = $y;
                  foreach($y as $kk=>$yy){
                     $creditCards[$k] = $yy;
                  }
               }
               
               $customer = array('customer' => array('id' => $res->customer->id,
               'merchantId' => $res->customer->merchantId,
               'firstName' => $res->customer->firstName,
               'lastName' => $res->customer->lastName,
               'company' => $res->customer->company,
               'email' => $res->customer->email,
               'phone' => $res->customer->phone,
               'fax' => $res->customer->fax,
               'website' => $res->customer->website,
               'createdAt' => array('date' => $createdAt['date'], 
                        'timezone_type' => $createdAt['timezone_type'], 
                        'timezone' => $createdAt['timezone']
                        ),
               'updatedAt' => array('date' => $updatedAt['date'], 
                        'timezone_type' => $updatedAt['timezone_type'], 
                        'timezone' => $updatedAt['timezone']
                        ),
                'customFields' => $res->customer->customFields,
                ),
                'creditCards' => $creditCards
             
             );

               
              // CommonUtility::pre($customer);
                                                                           
               $response['status'] = 'success';
               $response['data'] = $customer;
               return $response;
            } else {
               $msg = "Payment validation errors:";
                //echo("Payment validation errors:<br/>");
                $errorMessages = array();
                foreach (($res->errors->deepAll()) as $error) {
                  $errorMessages[$error->code]['attribute'] = $error->attribute;
                  $errorMessages[$error->code]['message'] = $error->message;
                  $errorMessages[$error->code]['code'] = $error->code;
                  
                  //echo $error->code;
                  //CommonUtility::pre($error);
                    $msg .= "- " . $error->message . ", ";
                    //echo("- " . $error->message . "<br/><br/><br/>");
                }
                
                $extraInfo = array();
                if(!empty($this->data['customer']['id'])){
                  $extraInfo = array('CustomerId' => $this->data['customer']['id']) ;
                }
               $extraInfo = array('hideoutput' => true);
               CommonUtility::catchErrorMsg( $msg, $extraInfo);
               $response['status'] ='error';
               $response['data'] = array('errors' => $errorMessages);
               return $response;
            }

      }catch(Exception $e){
        $extraInfo = array('hideoutput' => true);
        $extraInfo['CustomerId'] = $customerId ;
        $extraInfo['errorCode'] = $e->getCode();
        $msg = $e->getMessage();
        CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         //$errorMessages = array();
//         $errorMessages[$error->code]['message'] = $msg;
//         $errorMessages[$error->code]['code'] = 404;
//         
//         $response['status'] ='error';
//         $response['data'] = array('errors' => $errorMessages);
            throw new Exception($msg, $e->getCode());
      }
      return false;
      
   }
   
   
   public function updateBtCreditCardAccount(){
      //CommonUtility::pre($this->customer);
      //$this->data['customer'] = array();
      //if(!empty($this->customer)){
      //   $this->data['customer'] = array_merge($this->data['customer'], $this->customer);
      //}
      

      if(!empty($this->creditCard)){
         $this->data['creditCard'] = $this->creditCard;
         $options = array('verifyCard' => $this->verifyCard);
         //$this->data['creditCard']['options']['verifyCard'] = $this->verifyCard;
         //$this->data['creditCard']['options']['makeDefault'] = false;
         $this->data['creditCard']['options'] = array_merge($options, $this->data['creditCard']['options']);
      }
      
      if(!empty($this->billingAdd)){
         $this->data['creditCard']['billingAddress'] = $this->billingAdd;
      }
      
      //CommonUtility::pre($this->data);
      //die();
     //print_r($this->creditCard);
     
      $token = isset($this->creditCard['token']) ? $this->creditCard['token'] : '';
     
      if(!$token){
         //echo 'token not found';
         $token = '';
      }else{
         $token = $this->data['creditCard']['token'];
         unset($this->data['creditCard']['token']);
      }

      //CommonUtility::pre($this->data);
  
      $cc = new BraintreeApi;
      $cc->options = array();
      $cc->options=$this->data;
      $response = array();

      try{

       $result = $cc->updateCreditCard($token);

       //CommonUtility::pre($result);
//CommonUtility::pre($this);
//die();
            $res = $result['result'];
            if ( $res->success) {
                
               foreach($res->creditCard as $creditCard){   }

               $response['status'] = 'success';
               $response['data'] = array('creditCard' => $creditCard);
               return $response;
            } else {
               $errorMessages = array();
               $extraInfo = array();
               $msg = "create credit card errors:<br/>";
                //echo("Payment validation errors:<br/>");
                //get_object_vars($res);
                
                //CommonUtility::pre($res);
                //echo get_class($res);
                //CommonUtility::pre($res->_attributes['message']);
                //if(isset($res['exception'])){
//                  $errorMessages['404']['message'] = 'Credit Card token not found';
//                  $errorMessages['404']['code'] = '404';
//                }else
                if(get_class($res) === 'Braintree_Result_Error' && ( (int)$res->_attributes['verification']['processorResponseCode'] >= 2000 && (int)$res->_attributes['verification']['processorResponseCode'] < 3000 ) ){
                  $errorMessages[$res->_attributes['verification']['processorResponseCode']]['message'] = $res->_attributes['verification']['processorResponseText'];
                  $errorMessages[$res->_attributes['verification']['processorResponseCode']]['code'] = (int)$res->_attributes['verification']['processorResponseCode'];
                  $msg .= ' message: '. $res->_attributes['verification']['processorResponseText'] . ' ,code: ' . $res->_attributes['verification']['processorResponseCode'];
                }else
                {
                   foreach (($res->errors->deepAll()) as $error) {
                     $errorMessages[$error->code]['attribute'] = $error->attribute;
                     $errorMessages[$error->code]['message'] = $error->message;
                     $errorMessages[$error->code]['code'] = $error->code;
                     $msg .= "- " . $error->message . ", ";
                   }  
                }
               
               $extraInfo = array('hideoutput' => true);
               $extraInfo['CreditCardToken'] = $token ;
               CommonUtility::catchErrorMsg( $msg, $extraInfo  );
                  
               $response['status'] ='error';
               $response['data'] = array('errors' => $errorMessages);
              // CommonUtility::pre($errorMessages);
               return $response;
            }

      }catch(Exception $e){
         //echo 'ERROR<br/>';
        // CommonUtility::pre($e);
         
        $msg = $e->getMessage();
        $extraInfo = array('hideoutput' => true);

        $extraInfo['CreditCardToken'] = $token ;
        
        CommonUtility::catchErrorMsg( $msg, $extraInfo  );
        throw new Exception($msg, $e->getCode()); 
      }
      return false;
      
   }
   
   
   
   
    public function createBtCreditCardAccount()
    {
      //CommonUtility::pre($this->customer);

      if(!empty($this->creditCard)){
         $this->data['creditCard'] = $this->creditCard;
         //$this->data['creditCard']['options']['failOnDuplicatePaymentMethod'] = $this->failOnDuplicatePaymentMethod;
        // $this->data['creditCard']['options']['verifyCard'] = $this->verifyCard;
         
         $options = array(
                     'verifyCard' => $this->verifyCard, 
                     'failOnDuplicatePaymentMethod' => $this->failOnDuplicatePaymentMethod
                  );
         $this->data['creditCard']['options'] = array_merge($options, $this->data['creditCard']['options']);
      }
      
      if(!empty($this->billingAdd)){
         $this->data['creditCard']['billingAddress'] = $this->billingAdd;
      }


      //CommonUtility::pre($this->data);
      //die('test');
      $bt = new BraintreeApi;
      $bt->options=$this->data;
      $response = array();
      try{
       $result = $bt->createCreditCard();
       //CommonUtility::pre($result);
//CommonUtility::pre($this);

            $res = $result['result'];
            if ($res->success) {

                foreach($res->creditCard as $creditCard){   }

               $response['status'] = 'success';
               $response['data'] = array('creditCard' => $creditCard);
               return $response;
            } else {
               $errorMessages = array();
               $extraInfo = array();
               $msg = "create credit card errors:<br/>";

               if(get_class($res) === 'Braintree_Result_Error' && ( (int)$res->_attributes['verification']['processorResponseCode'] >= 2000 && (int)$res->_attributes['verification']['processorResponseCode'] < 3000 ) ){
                  $errorMessages[$res->_attributes['verification']['processorResponseCode']]['message'] = $res->_attributes['verification']['processorResponseText'];
                  $errorMessages[$res->_attributes['verification']['processorResponseCode']]['code'] = (int)$res->_attributes['verification']['processorResponseCode'];
                  $msg .= ' message: '. $res->_attributes['verification']['processorResponseText'] . ' ,code: ' . $res->_attributes['verification']['processorResponseCode'];
                }else
                {

                   foreach (($res->errors->deepAll()) as $error) {
                     $errorMessages[$error->code]['attribute'] = $error->attribute;
                     $errorMessages[$error->code]['message'] = $error->message;
                     $errorMessages[$error->code]['code'] = $error->code;
                     
                     $msg .= "- " . $error->message . ", ";
                    //echo("- " . $error->message . "<br/><br/><br/>");
                   }  
                }

               
               $extraInfo = array('hideoutput' => true);
               $extraInfo['CustomerId'] = $this->data['customer']['id'] ;
               CommonUtility::catchErrorMsg( $msg, $extraInfo  );

               $response['status'] ='error';
               $response['data'] = array('errors' => $errorMessages);
               return $response;
            }

      }catch(Exception $e){
         //echo 'in Payment class file ERROR<br/>';
          CommonUtility::pre($e);
         $msg = $e->getMessage();
         $extraInfo = array('hideoutput' => true);
         //$extraInfo['CustomerId'] = $token ;
        
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         throw new Exception($msg, $e->getCode()); 
      }
      return false;
      
   }
}


