<?php
class UserPayment extends Payment{
   
   //Create account for poster
   public function createMerchantAccount($userId, $userType = 'i', array $data = array()){
      
      $user = User::model()->findByPk($userId);
      
      //CommonUtility::pre($user);
      //echo $user->user_id;
      
      $userType = 'c';
      
      //check if user is individual or company
      switch($userType){
         case 'i':   //individual user account
            $accountType = 'individual';
         break;
         case 'c':   //compnay account
            $accountType = 'business';
         break;
         default:
            $accountType = 'individual';
      }
      
      $ssn = !empty($user->ssn) ? $user->ssn : ''; //'456-45-4567'
      $cityName = '';
      if($user->{Globals::FLD_NAME_BILLADDR_CITY_ID})
     {
        $city =  City::model()->with('citylocale')->findByPk($user->{Globals::FLD_NAME_BILLADDR_CITY_ID});
        $cityName = $city->citylocale->{Globals::FLD_NAME_CITY_NAME};
     }
     
     $regionName = '';
      if($user->{Globals::FLD_NAME_BILLADDR_REGION_ID})
     {
        $region =  Region::model()->with('regionlocale')->findByPk($user->{Globals::FLD_NAME_BILLADDR_REGION_ID});
        $regionName = $region->regionlocale->{Globals::FLD_NAME_REGION_NAME};
     }
     
     $stateName = '';
     if($user->{Globals::FLD_NAME_BILLADDR_STATE_ID})
     {
        $state =  State::model()->with('statelocale')->findByPk($user->{Globals::FLD_NAME_BILLADDR_STATE_ID});
        $stateName = $state->statelocale->{Globals::FLD_NAME_STATE_NAME};
     }
     
     $streetAddress = $user->{Globals::FLD_NAME_BILLADDR_STREET1};
     $streetAddress .= !empty($user->{Globals::FLD_NAME_BILLADDR_STREET2}) ? ', ': ' ';
     $streetAddress .= $user->{Globals::FLD_NAME_BILLADDR_STREET2};
     
     
     
      $merchantIndividual = array(
             'individual' => array(
               'firstName' => $user->firstname,
               'lastName' => $user->lastname,
               'email' => $user->primary_email,
               'phone' => '5553334444', //$user->phone,
               'dateOfBirth' => date('Y-m-d', strtotime($user->date_of_birth)),
               'ssn' => $ssn,
               'address' => array(
                 'streetAddress' => $streetAddress, //'111 Main St',
                 'locality' =>  $cityName, //'Chicago',
                 'region' => $stateName,
                 'postalCode' => $user->{Globals::FLD_NAME_BILLADDR_ZIPCODE}
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
       'masterMerchantAccountId' => Yii::app()->params['braintreeapi']['master_merchant_id'],
       'id' => $user->user_id
   );
         
      $merchant = $merchantIndividual;
      echo $accountType;
      if($accountType === 'business'){
         $merchantBusiness = array('business' => array(
               'legalName' => 'Jane\'s Ladders',
               'dbaName' => 'Jane\'s Ladders',
               'taxId' => '98-7654321',
               'address' => array(
                 'streetAddress' => '111 Main St',
                 'locality' => 'Chicago',
                 'region' => 'IL',
                 'postalCode' => '60622'
               )
            )
         );
         
         $merchant = array_merge($merchantIndividual, $merchantBusiness);
      }   

CommonUtility::pre($merchant);
         try{
            
            $req = new Payment();
            $req->subMerchant = $merchant;
            $result = $req->createBtSubMerchantAccount($merchant);
            CommonUtility::pre($result);
            
         }catch(Exception $e){
            echo $e->getMessage();
         }
         
   }
   
   public function createCustomerAccount(){
      
   }
   
   //convert doer customer account in merchant account
   public function convertInMerchantAccount(){
      
   }
   
   
   
}