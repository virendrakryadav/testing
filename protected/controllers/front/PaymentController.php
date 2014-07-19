<?php

class PaymentController extends Controller
{
   
   var $demoCreditCardNumber = '4111111111111111';
   var $demoCcExpireMonth = '11';
   var $demoCcExpireYear = '2015';
   var $demoCcCvv = '111';
   
   var $demoCustomerData = array('firstName' => 'Virendra',
       'lastName' => 'Yadav',
       'company' => 'Jones Co.',
       'email' => 'vir.jones@example.com',
       'phone' => '281.330.8004',
       'fax' => '419.555.1235',
       'website' => 'http://example.com');
   var $demoCustomerWithCreditCard = false;    
       
	public function actionIndex()
	{
		$this->render('index');
	}

   public function actionPayment() {
      
      //$this->createMerchantAccount();     //working tested      //create merchant account for poster
      
   //$this->createCustomerAccount(); //create customer
  //$this->updateCustomerAccount(); //pass id which should be updated and data (two arguments)
  //$this->getCustomerAccount();
  //$this->searchCustomerAccount();      //incomplete
   //$this->createCcaccount();
   //$this->updateCcaccount();

        
      //$this->doEscrowTransaction();  
      $this->doTransaction();  
      //$this->doEscrowTransactionFromVault();
    }
    
    public function doTransaction(){
      
    }
    
    public function createMerchantAccount(){
      $merchant = array(
             'individual' => array(
             //'companyName' => 'not mentioned',
               'firstName' => 'Vicky',
               'lastName' => 'Doe',
               'email' => 'john.mts01@gmail.com',
               'phone' => '5553334444',
               'dateOfBirth' => '1981-11-19',
               'ssn' => '456-45-4567',
               'address' => array(
                 'streetAddress' => '111 Main St',
                 'locality' => 'Chicago',
                 'region' => 'IL',
                 'postalCode' => '60622'
               )
             ),
      'funding' => array(
      'destination' => 'bank',//Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
      'email' => 'john.mts01@gmail.com',
      'mobilePhone' => '5555555555',
      'accountNumber' => '1123581321',
      'routingNumber' => '071101307'
    ),
             'tosAccepted' => true,
             'masterMerchantAccountId' => "k54hhv2tkvyjdms8",
             'id' => "316"
         );

        $req = new Payment();
        $req->subMerchant = $merchant;
      
   try{
       $result = $req->createBtSubMerchantAccount($merchant);
       CommonUtility::pre($result);
   }catch(Exception $e){
      echo 'ERROR<br/>';
      CommonUtility::pre($e);
   }
/*
      $result = $result['result'];
      if ($result->success) {
          echo("Success! Customer ID: " . $result->customer->id);
      } else {
          echo("Validation errors:<br/>");
          foreach (($result->errors->deepAll()) as $error) {
              echo("- " . $error->message . "<br/><br/><br/>");
          }
      }*/
 }
 
 
 public function doEscrowTransaction(){

        $bt = new Payment();
        $bt->transaction = array(
                              'amount' => "100.00",
                              'merchantAccountId' => '316', //Yii::app()->params['braintreeapi']['merchant_id'],
                              'orderId' => 1234,
                              'serviceFeeAmount' => "10.00",
            );
        $bt->options = array(
                              'submitForSettlement' => true,
                              'holdInEscrow' => true,
                              // 'storeInVault' => true,
                               //'addBillingAddressToPaymentMethod' => true,
                              // 'storeShippingAddressInVault' => true,
                              //'storeInVaultOnSuccess' => true,
                              //'recurring' => true,
                             // 'useStoredPaymentMethod' => true,
            );
            
        $bt->creditCard = array(
          'creditCard' => array(
            'number' => "4009348888881881",
            'expirationDate' => "11/15",
          ),
          //'options' => array(
        //    'submitForSettlement' => true,
         // ),
         // 'serviceFeeAmount' => "10.00"
        );
        
      $r = $bt->doBtEscrow();
      CommonUtility::pre($r);
 }
 
 
    public function doEscrowTransactionFromVault(){
      
      
        $bt = new Payment();
        $bt->transaction = array(
                       'amount' => '100.00',
                       'customerId' => '66163146', //'24693473',
                       'paymentMethodToken' => '6h8chg',
                       
                     );
        $bt->options = array(
                           'submitForSettlement' => true,
                           'useStoredPaymentMethod' => true,
                           'holdInEscrow' => false,
                       );  
       // $bt->creditCard = array(
//            'number' => "4009348888881881",
//            'expirationDate' => "11/15",
//
//          //'options' => array(
//        //    'submitForSettlement' => true,
//         // ),
//         // 'serviceFeeAmount' => "10.00"
//        );
        
      $r = $bt->doBtEscrow();
      CommonUtility::pre($r);
 }
 
 public function updateCcaccount(){
   
      $ccinfo = array(
         'token' => '8mw83g',
          //'customerId' => '3161',
          'number' => '4012888888881881', //'5105105105105100',
          //'expirationDate' => '05/20',
          //'cvv' => '111',
          //'cardholderName' => 'The Cardholder'
          'options' => array(
              'verifyCard' => true,
              'makeDefault' => true,
          )    
      );
      
      try{
         $bt = new Payment();
         $bt->creditCard = $ccinfo;
         $r = $bt->updateBtCreditCardAccount();
         CommonUtility::pre($r);
      
      }catch(Exception $e){
         echo 'ERROR<br/>';
         CommonUtility::pre($e);
      }
 } 
    
   public function createCcaccount(){
   
      $ccinfo = array(
       'customerId' => '24693473',
       'number' => '4009348888881881',
       'expirationDate' => '05/20',
       'cardholderName' => 'The Cardholder',
       'options' => array(
         'makeDefault' => true,
         'failOnDuplicatePaymentMethod' => true,
       )
      );
      
      try{ 
         $bt = new Payment();
         $bt->creditCard = $ccinfo;
         $r = $bt->createBtCreditCardAccount();
         CommonUtility::pre($r);
      }catch(Exception $e){
            echo 'ERROR<br/>';
            CommonUtility::pre($e);
      }
 }  
    
    
///Incomplete
 public function searchCustomerAccount(){
    try{ 
      $id = '50140414';
        //$model = User::model()->findByPk(Yii::app()->user->id);
        $bt = new BraintreeApi;
        ////$r = $bt->findCustomer('24693473');
        CommonUtility::pre($r);
   
       $result = $customer->findCustomer($id);
       CommonUtility::pre($result);
   }catch(Exception $e){
      echo 'ERROR<br/>';
      CommonUtility::pre($e);
   }
   
/*
      $result = $result['result'];
      if ($result->success) {
          echo("Success! Customer ID: " . $result->customer->id);
      } else {
          echo("Validation errors:<br/>");
          foreach (($result->errors->deepAll()) as $error) {
              echo("- " . $error->message . "<br/><br/><br/>");
          }
      }*/
 }
 
 
 public function getCustomerAccount(){
   try{
      $bt = new Payment();
      $r = $bt->getBtCustomerAccount('24693473');
      CommonUtility::pre($r);
   }catch(Exception $e){
      echo 'ERROR<br/>';
      CommonUtility::pre($e);
   }
 }
 
 public function updateCustomerAccount(){
      $cust = array(
      'id' => '24693473',
      'firstName' => 'Rajesh',
       
   );
   //$cust = array_merge($cust, $this->demoCustomerData);
        //$model = User::model()->findByPk(Yii::app()->user->id);
        $req = new Payment();
        $req->customer = $cust;

   try{
       $result = $req->updateBtCustomerAccount();
       CommonUtility::pre($result);
   }catch(Exception $e){
      echo 'ERROR<br/>';
      echo $e->getMessage();
      echo $e->getCode();
      CommonUtility::pre($e);
   }

      
      if ($result['status'] === 'success') {
          CommonUtility::pre($result['data']);
      } else {
          echo("Validation errors:<br/>");
          CommonUtility::pre($result);
         // foreach (($result['data']['error']->deepAll()) as $error) {
              //echo("- " . $error->message . "<br/><br/><br/>");
          //}
      }
 }
 
 /**
  * Create Customer
  * @param requires blank array to generate only customer id. or array with/without id field 
  */
    
 public function createCustomerAccount(){
      $cust = array(
      //'id' => 'greencometz_'.Yii::app()->user->id,    //optional if specified, this id will be used to create customer 
       
   );
   $cust = array_merge($cust, $this->demoCustomerData);
   $this->demoCustomerWithCreditCard = true;
   if($this->demoCustomerWithCreditCard === true){
      $cust['creditCard'] = array('number' => $this->demoCreditCardNumber,
                                            'expirationMonth' => $this->demoCcExpireMonth,
                                            'expirationYear' => $this->demoCcExpireYear,
                                            'cvv' => $this->demoCcCvv,
                                            //'token' => 'customized_token'
                                       );
   }
        //$model = User::model()->findByPk(Yii::app()->user->id);
        //$customer = new BraintreeApi;
        //$customer->options['customer'] = $cust;
        //$customer->options['creditcard'] = $cust;
        
        $req = new Payment();
        $req->customer = $cust;
      
   try{
       $result = $req->createBtCustomerAccount($cust);
       CommonUtility::pre($result);
   }catch(Exception $e){
      echo 'ERROR<br/>';
      CommonUtility::pre($e);
   }
/*
      $result = $result['result'];
      if ($result->success) {
          echo("Success! Customer ID: " . $result->customer->id);
      } else {
          echo("Validation errors:<br/>");
          foreach (($result->errors->deepAll()) as $error) {
              echo("- " . $error->message . "<br/><br/><br/>");
          }
      }*/
 }

  public function createcustomerTest(){
   $payerId = CommonUtility::createPaymentCustomerId(Yii::app()->user->id, false, 6, '');
                    //check user payment customer id exist. If yes use that while adding additional credit card
                    //payment api - create customer account
                 
                    $user = $this->loadModel(Yii::app()->user->id);
                    $userPayAccountCustomer = array('id' => $payerId.'1' ,
                                     'firstName' => $user->{Globals::FLD_NAME_FIRSTNAME},
                                     'lastName' => $user->{Globals::FLD_NAME_LASTNAME},
                                     'company' => '',
                                     'email' => $user->{Globals::FLD_NAME_PRIMARY_EMAIL},
                                     'phone' => $user->{Globals::FLD_NAME_PRIMARY_PHONE},
                                     'fax' => '',
                                     'website' => ''
                                  );
                  $userPayAccountBilling = array(
                              'firstName' =>    $user->{Globals::FLD_NAME_FIRSTNAME},
                              'lastName' =>     $user->{Globals::FLD_NAME_LASTNAME},
                              'company' => '',
                              'streetAddress' => $user->{Globals::FLD_NAME_BILLADDR_STREET1},
                              'extendedAddress' => $user->{Globals::FLD_NAME_BILLADDR_STREET2},
                              'locality' => '',
                              'region' => '',
                              'postalCode' => $user->{Globals::FLD_NAME_BILLADDR_ZIPCODE},
                              'countryCodeAlpha2' => $user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE},
                          );
                          
                  $userPayAccountCc = array(
                       "number" => '4111111111111111',
                       "expirationMonth" => '111',
                       "expirationYear" => '20153',
                       "cvv" => '111',
                       
                     );
                          
                    //CommonUtility::pre($userPayAccountCustomer);
                    $pay = new Payment;
                    $pay->customer = $userPayAccountCustomer;
                    //$pay->billingAdd = $userPayAccountBilling;
                    $pay->creditCard = $userPayAccountCc;

                    $result = $pay->createCustomerBtAccount();
                   CommonUtility::pre($result);  
  }
  
  public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	} 
   
   
   
   //=============================================================================================================
   //UserPayment
   
   public function actionUserPayment(){
      UserPayment::createMerchantAccount(316);
   }
   
   
}