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
        
   private $_masterMerchantAccount = '';
   protected $customer = array();
   public $creditCard = array();
   protected $billingAdd = array();
   protected $shippingAdd = array();
   public $options = array();
   protected $subMerchantId = '';
   protected $escrow = '';
   protected $merchantAccountType = 'individual';
   protected $address = array();
   private $data = array();
   public $transaction = array();
   
   public $subMerchant = array();

   public function setBtMasterMerchantAccount(){
      $this->_masterMerchantAccount = Yii::app()->params['braintreeapi']['merchant_id'];
   }
   
   public function getBtMasterMerchantAccount(){
      return $this->_masterMerchantAccount;
   }
   
   
   public function doBtTransaction(){
      
   }
   
   
   public function doBtEscrow(){
      $data = null;
      //CommonUtility::pre($this->options);
      if(!empty($this->options) && $this->options['holdInEscrow'] === true ){
         //$data = $this->prepareBtTransactionFromVault();
         
         $data = array_merge($this->transaction, $this->creditCard, array('options' => $this->options));
      }else{
         throw new Exception('InvalidEscrowRequestData');
      }
      
      CommonUtility::pre($data);
     // die();
      $bt = new BraintreeApi;
      $bt->options = $data;
      
      CommonUtility::pre($bt);
      try{
         $result = $bt->doTransaction();
         CommonUtility::pre($result);
         die('test');
         if ($res->success) {
            
               $createdAt = get_object_vars($res->transaction->createdAt);
               $updatedAt = get_object_vars($res->transaction->updatedAt);
               
               $creditCards = array();
               foreach($res->transaction->creditCards as $k=> $y){
                  $creditCards[$k] = $y;
                  foreach($y as $kk=>$yy){
                     //print_r($yy);   
                     $creditCards[$k] = $yy;
                  }
               }

               $transaction = array('transaction' => array('id' => $res->transaction->id,
                  'status' => $res->transaction->status,
               'type' => $res->transaction->type,
               'currencyIsoCode' => $res->transaction->currencyIsoCode,
               'amount' => $res->transaction->amount,
               'merchantAccountId' => $res->transaction->merchantAccountId,
               'orderId' => $res->transaction->orderId,
               'fax' => $res->transaction->fax,
               'website' => $res->transaction->website,
               'createdAt' => array('date' => $createdAt['date'], 
                        'timezone_type' => $createdAt['timezone_type'], 
                        'timezone' => $createdAt['timezone']
                        ),
               'updatedAt' => array('date' => $updatedAt['date'], 
                        'timezone_type' => $updatedAt['timezone_type'], 
                        'timezone' => $updatedAt['timezone']
                        ),
                'customer' => $res->transaction->customer,
                'billing' => $res->transaction->billing,
                'refundId' => $res->transaction->refundId,
                'refundIds' => $res->transaction->refundIds,
                'refundedTransactionId' => $res->transaction->refundedTransactionId,
                'settlementBatchId' => $res->transaction->settlementBatchId,
                'shipping' => $res->transaction->shipping,
                'customFields' => $res->transaction->customFields,
                'creditCards' => $creditCards,
                
                
                'planId' => $res->transaction->planId,
                'subscriptionId' => $res->transaction->subscriptionId,
                'addOns' => $res->transaction->addOns,
                'discounts' => $res->transaction->discounts,
                'descriptor' => $res->transaction->descriptor,
                'recurring' => $res->transaction->recurring,
                'channel' => $res->transaction->channel,
                'serviceFeeAmount' => $res->transaction->serviceFeeAmount,
                
                
                'escrowStatus' => $res->transaction->escrowStatus,
                'disbursementDetails' => $res->transaction->disbursementDetails,
                'disputes' => $res->transaction->disputes,
                'creditCardDetails' => $res->transaction->creditCardDetails,
                'customerDetails' => $res->transaction->customerDetails,
                'billingDetails' => $res->transaction->billingDetails,
                'shippingDetails' => $res->transaction->shippingDetails,
                'subscriptionDetails' => $res->transaction->subscriptionDetails,

                  
                  
                
                ),
                
                
         );

              // CommonUtility::pre($subMerchant);
                                               
               $response['status'] = 'success';
               $response['data'] = $subMerchant;
               return $response;
            } else {
               $msg = "Merchant account errors:";
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
                $extraInfo['hideoutput'] = true;
                if(!empty($this->data['subMerchant']['id'])){
                  $extraInfo['CustomerId'] = $this->data['subMerchant']['id'];
                }
//CommonUtility::pre($extraInfo);
               CommonUtility::catchErrorMsg( $msg, $extraInfo);
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
   }
   
   public function createBtSubMerchantAccount(){
      if(empty($this->subMerchant)){
         throw new Exception('InvalidMerchantDetail');
      }
      
      
      $this->data['subMerchant'] = $this->subMerchant;
      
      
      $merchant = new BraintreeApi;
      $merchant->options=$this->data;
      $response = array();
      //CommonUtility::pre($this->data);
      try{
       $result = $merchant->createMerchant();
       //CommonUtility::pre($result);
//die('test merchant');
            $res = $result['result'];
            if ($res->success) {

               
               $subMerchant = array('subMerchant' => array('id' => $res->merchantAccount->id,

                )
             
             );

              // CommonUtility::pre($subMerchant);
                                               
               $response['status'] = 'success';
               $response['data'] = $subMerchant;
               return $response;
            } else {
               $msg = "Merchant account errors:";
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
                $extraInfo['hideoutput'] = true;
                if(!empty($this->data['subMerchant']['id'])){
                  $extraInfo['CustomerId'] = $this->data['subMerchant']['id'];
                }
//CommonUtility::pre($extraInfo);
               CommonUtility::catchErrorMsg( $msg, $extraInfo);
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
   }
   
   
}


