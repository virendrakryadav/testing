<?php 
class UserApi{
   
   public static function user_login($params){

      //CommonUtility::pre($params);
      try{
         /*if(empty($params['data'])){
            throw new Exception('InvalidInputData', 200);
         }
         
         if(empty($params['data']['username']) || empty($params['data']['password'])){
            throw new Exception('InvalidParameter', 200);
         }
         
         if(empty($params['device_id'])){
            throw new Exception('MissingDeviceId', 200);
         }
         */
         //check email validity
         
//         CommonUtility::pre($params);
         
            @$email = $params['signin_id'];
            @$password = $params['pwd'];
            @$deviceId = $params['device_id'];
   		
            if(isset($email) && isset($password)){
            
            //check user authentication
            try
            {
                $criteria = new CDbCriteria;
                $criteria->condition= Globals::FLD_NAME_CONTACT_ID.'="'.$email.'" and '.Globals::FLD_NAME_CONTACT_TYPE.'="'.Globals::DEFAULT_VAL_CONTACT_TYPE.'" and '.Globals::FLD_NAME_IS_LOGIN_ALLOWED.'="'.Globals::DEFAULT_VAL_IS_LOGIN_ALLOWED.'"';        
                $email = UserContact::model()->find($criteria);
                if(empty($email))
                {
                        throw new Exception("UserLoginFailed");
                }
                else
                {
                    $user = User::model()->find(Globals::FLD_NAME_USER_ID.'=?',array($email->{Globals::FLD_NAME_USER_ID}));
                    if($user === null)
                    {
                           throw new Exception("UserLoginFailed");
                    }
                    else if ((md5($password.Yii::app()->params["salt"])) !== $user->password)
                    {
                        throw new Exception("UserLoginFailed");
                    }                                 
                    else if ($user->status !== Globals::DEFAULT_VAL_USER_STATUS )
                    {
                        throw new Exception("UserLoginFailed");
                    }
                    else if ($user->is_verified !== Globals::DEFAULT_VAL_IS_VERIFIED )
                    {
                       throw new Exception("UserLoginFailed");
                    }   
                    else
                    {
                        $userDetail = array();
                        $userDetail['user_id'] = $user->user_id; 
                        $userDetail['signin_id'] = $email->{Globals::FLD_NAME_CONTACT_ID}; 
                        $userDetail['firstname'] = $user->firstname; 
                        $userDetail['lastname'] = $user->lastname; 
                        $userDetail['account_type'] = $user->account_type; 
                        
                        $date = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                        $date->modify('+30 day');
                        $expiry = $date->format('Y-m-d H:i:s');

                        $token = self::createToken($deviceId, $user->user_id, strtotime($expiry));
                        $userDetail['user_token'] = $token; 
//                        $data = array('token' => $token, 'userDetail' => $userDetail);
                        return json_encode(array('status' => 'ok', 'data' => $userDetail, 'status_code' => 'UserLoginSuccess'));
                    }
                }
                
            }
            catch(Exception $e)
            {
                return json_encode(array('status' => 'error', 'data' => '', 'status_code' => $e->getMessage()));
            }            
         }
      }catch(Exception $e){
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => $e->getMessage()));
      }
      
   }
   
   
   
   private static function createToken($deviceId, $userId, $expiry){

       $string = 'deviceid__'.$deviceId . ':::uid__' . $userId . ':::expiry__' . $expiry;
       $encKey = Yii::app()->getSecurityManager()->getEncryptionKey();
       $token = base64_encode(Yii::app()->securityManager->encrypt( $string, $encKey ));
    
       //self::validateToken($token) ? 'true' : 'false';
       return $token;
   }
   
   public function validateToken($token){
      try{
         if(empty($token)){
            return false;
            //throw new Exception('InvalidToken', 200);
         }else{
            $encKey = Yii::app()->getSecurityManager()->getEncryptionKey();
            $tokenString = Yii::app()->securityManager->decrypt( base64_decode($token ), $encKey);
//            echo $tokenString;exit;
            list($deviceId, $userId, $expiry ) = explode(':::', $tokenString);
            $deviceId = explode('__', $deviceId[1]);
            $userId = explode('__', $userId[1]);
            $expiry = explode('__', $expiry[1]);
            $curtime = date('Y-m-d H:i:s');
            $curtime = strtotime($curtime);
            
            if((int) $curtime < (int) $expiry){
              return true; 
            }else{
               return false;
            }
         }
         
      }catch(Exception $e){
         echo $e->getMessage();
         
         return false;
         //return json_encode(array('status' => 'error', 'data' => '', 'status_code' => $e->getMessage()));
      }
      
   }
   
   public static function get_user($params){

       
//      CommonUtility::pre($params);
      //print_r(self::createToken('123', '316', '2014-06-28 08:53:44'));
      
      try{
  /*       if(empty($params['data'])){
            throw new Exception('InvalidInputData', 200);
         }
*/
            if(empty($params['device_id'])){
                throw new Exception('MissingDeviceId', 200);
            }
            //echo $params['token'];
            if(!self::validateToken($params['token'])){
                throw new Exception('InvalidToken', 200);
            }

            //getuserdetails

            $data = array('data1' => 'Data1', 'data2' => 'Data2');
        return json_encode(array('status' => 'ok', 'data' => $data, 'status_code' => 'UserLoginSuccess'));
        }
        catch(Exception $e){
            $extraInfo = array('hideoutput' => true);
            $extraInfo['errorCode'] = $e->getMessage();
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg($msg, $extraInfo);

            return json_encode(array('status' => 'error', 'data' => '', 'status_code' => $e->getMessage()));
      }
      
   }   
   public static function user_logout($params){

      //CommonUtility::pre($params);
      //print_r(self::createToken('123', '316', '2014-06-28 08:53:44'));
      
      try
       {
         if(empty($params['device_id'])){
            throw new Exception('MissingDeviceId', 200);
         }
         if(!self::validateToken($params['token'])){
            throw new Exception('InvalidToken', 200);
         }
         
         //getuserdetails

        $data = array('data1' => 'Data1', 'data2' => 'Data2');
        return json_encode(array('status' => 'ok', 'data' => $data, 'status_code' => 'UserLoginSuccess'));
      }
      catch(Exception $e){
         $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => $e->getMessage()));
      }
      
   }   
   
    public static function get_category($params)
   {
       try{
//         if(empty($params['device_id'])){
//            throw new Exception('MissingDeviceId', 200);
//         }
         //echo $params['token'];
//         if(!self::validateToken($params['user_token'])){
//            throw new Exception('InvalidToken', 200);
//         }
         //getcategories
            @$taskType = $params['task_type'];
            @$languageCode = $params['language_code'];
            if(isset($taskType) && isset($languageCode)){
                $categories = Category::getCategoryListByTypeForApi($taskType,$languageCode);
                if(empty($categories))
                {
                    throw new Exception("CategoryListFailed");
                }
                else
                {
                    $categoryDetail = array();
                    $categoryList = array();
                    foreach($categories as $category)
                    {
                        $categoryData['category_id'] = $category->category_id; 
                        $categoryData['category_name'] = $category['categorylocale']->category_name; 
                        $categoryData['category_image'] = $category['categorylocale']->category_image; 
                        $categoryData['category_description'] = $category['categorylocale']->category_desc; 
                        $categoryData['subcategory_count'] = $category->subcategory_cnt; 
                        $categoryList[] = $categoryData;
                    }
                    $categoryDetail = $categoryList;
                    return json_encode(array('status' => 'ok', 'data' => $categoryDetail, 'status_code' => 'CategoryListSuccess'));
                }
            }
      }
      catch(Exception $e){
         $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'CategoryListFailed'));
      }
   }
   
    public static function get_subcategory($params)
   {
       try{
//         if(empty($params['device_id'])){
//            throw new Exception('MissingDeviceId', 200);
//         }
         //echo $params['token'];
//         if(!self::validateToken($params['user_token'])){
//            throw new Exception('InvalidToken', 200);
//         }
         //getsubcategories
            @$taskType = $params['task_type'];   
            @$categoryId = $params['category_id'];
            @$languageCode = $params['language_code'];
            if(isset($taskType) && isset($languageCode)){
                $categories = Category::getSubCategoryListByTypeForApi($taskType,$categoryId,$languageCode);
                if(empty($categories))
                {
                    throw new Exception("CategoryListFailed");
                }
                else
                {
                    $categoryDetail = array();
                    $categoryList = array();
                    foreach($categories as $category)
                    {
                        $categoryData['category_id'] = $category->category_id; 
//                        $categoryData['parent_id'] = $category->parent_id; 
                        $categoryData['category_name'] = $category['categorylocale']->category_name; 
                        $categoryData['category_image'] = $category['categorylocale']->category_image; 
                        $categoryData['category_description'] = $category['categorylocale']->category_desc; 
//                        $categoryData['subcategory_count'] = $category->subcategory_cnt; 
                        $categoryList[] = $categoryData;
                    }
                    $categoryDetail = $categoryList;
                    return json_encode(array('status' => 'ok', 'data' => $categoryDetail, 'status_code' => 'CategoryListSuccess'));
                }
            }
      }
      catch(Exception $e){
         $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'CategoryListFailed'));
      }
   }
   
   
    public static function get_country($params)
   {
       try{
//         if(empty($params['device_id'])){
//            throw new Exception('MissingDeviceId', 200);
//         }
         //echo $params['token'];
//         if(!self::validateToken($params['user_token'])){
//            throw new Exception('InvalidToken', 200);
//         }
         //getcountries
//            $taskType = $params['task_type'];   
//            $categoryId = $params['category_id'];
            @$languageCode = $params['language_code'];
            if(isset($languageCode)){
                $countries = Country::getCountryListWithoutCache($languageCode);
                if(empty($countries))
                {
                    throw new Exception("CountryListFailed");
                }
                else
                {
                    $countryDetail = array();
                    $countryList = array();
                    foreach($countries as $country)
                    {
                        $countryData['country_code'] = $country['countrylocale']->country_code; 
                        $countryData['country_name'] = $country['countrylocale']->country_name; 
                        $countryList[] = $countryData;
                    }
                    $countryDetail = $countryList;
                    return json_encode(array('status' => 'ok', 'data' => $countryDetail, 'status_code' => 'CountryListSuccess'));
                }
            }
      }
      catch(Exception $e){
         $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'CountryListFailed'));
      }
   }
   
    public static function get_state($params)
   {
       try{
//         if(empty($params['device_id'])){
//            throw new Exception('MissingDeviceId', 200);
//         }
         //echo $params['token'];
//         if(!self::validateToken($params['user_token'])){
//            throw new Exception('InvalidToken', 200);
//         }
         //getstates
            @$countryCode = $params['country_code'];
            @$languageCode = $params['language_code'];
            if(isset($languageCode) && isset($countryCode)){
    //                if(!self::validateToken($params['user_token'])){
    //                    throw new Exception('InvalidToken', 200);
    //                }
                $states = StateLocale::getStatesByCountryCode($countryCode,$languageCode);
                if(empty($states))
                {
                    throw new Exception("StateListFailed");
                }
                else
                {
                    $statesDetail = array();
                    $statesList = array();
                    foreach($states as $state)
                    {
                        $stateData['state_id'] = $state->state_id; 
                        $stateData['country_code'] = $state->country_code; 
                        $stateData['state_name'] = $state->state_name; 
                        $stateList[] = $stateData;
                    }
                    $stateDetail = $stateList;
                    return json_encode(array('status' => 'ok', 'data' => $stateDetail, 'status_code' => 'StateListSuccess'));
                }
            }
      }
      catch(Exception $e){
         $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'StateListFailed'));
      }
   }
 
   public function search_projects($params)
   {
       try{
           @$search_term = $params['search_term'];
           @$languageCode = $params['language_code'];
           @$category = $params['category_id'];
//           if(isset($search_term)){
//             if(!self::validateToken($params['user_token'])){
//                throw new Exception('InvalidToken', 200);
//             }
           $searchParameters = array(
               'search_term' => $search_term,
               'category' => $category,
               'languageCode' => $languageCode,
            );
            $projects = Task::searchProjects($searchParameters);
            if(empty($projects)){
                throw new Exception("ProjectSearchFailed");
            }
            else{
                $projectsDetail = array();
                $projectsList = array();
                foreach($projects as $project)
                {
                    $projectData['project_id'] = $project->{Globals::FLD_NAME_TASK_ID}; 
                    $projectData['project_title'] = $project->{Globals::FLD_NAME_TITLE}; 
                    $projectData['project_description'] = $project->{Globals::FLD_NAME_DESCRIPTION}; 
                    $projectData['posted_at'] = $project->{Globals::FLD_NAME_CREATED_AT};  
                    $projectData['is_premium'] = $project->{Globals::FLD_NAME_IS_PREMIUM_TASK}; 
                    $projectData['proposals_count'] = $project->{Globals::FLD_NAME_PROPOSALS_CNT}; 
                    $projectData['proposals_avg_price'] = $project->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE}; 
                    $taskCategory = TaskCategory::getTaskCategoryName($project->{Globals::FLD_NAME_TASK_ID});
                    if(empty($taskCategory)){
                        throw new Exception("ProjectSearchFailed");
                    }
                    else{
                        $projectData['category'] = $taskCategory[0]['categorylocale']->{Globals::FLD_NAME_CATEGORY_NAME}; 
                    }
                    $taskSkills = TaskSkill::getTaskSkills($project->{Globals::FLD_NAME_TASK_ID});
                    if(empty($taskSkills)){
                        $projectData['skills_data'] = array(); 
                    }
                    else{
                        $projectSkill = array();
                        foreach($taskSkills as $taskSkill){
                            $skillData['project_skills'] = $taskSkill['skilllocale']->{Globals::FLD_NAME_SKILL_DESC};
                            $projectSkill[] = $skillData;
                        }
                        $projectData['skills_data'] = $projectSkill; 
                    }

                    $taskLocation = CommonUtility::getTaskPreferredLocations($project->{Globals::FLD_NAME_TASK_ID});
                    if(empty($taskCategory)){
                        $projectData['project_location'] = 'Anywhere'; 
                    }
                    else{
                        $projectData['project_location'] = $taskLocation; 
                    }
                    $projectData['posted_by'] = $project['user']->{Globals::FLD_NAME_FIRSTNAME}." ".$project['user']->{Globals::FLD_NAME_LASTNAME}; 
                    $projectList[] = $projectData;
                }
                $projectDetail = $projectList;
                return json_encode(array('status' => 'ok', 'data' => $projectDetail, 'status_code' => 'ProjectSearchSuccess'));
            }
//           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'ProjectSearchFailed'));
       }
   }
   
   public function search_doers($params)
   {
       try{
           @$search_term = $params['search_term'];
//             if(!self::validateToken($params['user_token'])){
//                throw new Exception('InvalidToken', 200);
//             }
           $searchParameters = array(
                    Globals::FLD_NAME_QUICK_FILTER => '' , 
                    Globals::FLD_NAME_USER_NAME => $search_term,
                    Globals::FLD_NAME_RATING => '',
                    Globals::FLD_NAME_LOCATIONS => '',
                    Globals::FLD_NAME_SORT => '',
                    Globals::FLD_NAME_MOST_EXPERIENCED => '',
            );
            $user = new User;
            $dataProvider = $user->getTaskerList($searchParameters);
            $doers = User::model()->findAll($dataProvider->criteria);
            if(empty($doers)){
                throw new Exception("DoerSearchFailed");
            }
            else{
                $doersDetail = array();
                $doersList = array();
                foreach($doers as $doer)
                {
                    $doerData['doer_id'] = $doer->{Globals::FLD_NAME_USER_ID}; 
                    $doerData['doer_name'] = $doer->{Globals::FLD_NAME_FIRSTNAME}." ".$doer->{Globals::FLD_NAME_LASTNAME}; 
                    $doerData['tagline'] = $doer->{Globals::FLD_NAME_TAGLINE}; 
                    $doerData['doer_dob'] = $doer->{Globals::FLD_NAME_DATE_OF_BIRTH};  
                    $doerData['account_type'] = $doer->{Globals::FLD_NAME_ACCOUNT_TYPE};  
                    $doerImage = CommonUtility::getThumbnailMediaURI($doer->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180);
                    $doerData['doer_image'] = $doerImage;
                    $workLocation = CommonUtility::getUserCurrentWorkLocations($doer->{Globals::FLD_NAME_USER_ID});
                    $workLocation = empty($workLocation) ? 'Anywhere':$workLocation;
                    $doerData['doer_work_location'] = $workLocation; 
                    
                    $description = CommonUtility::getUserDescription($doer->{Globals::FLD_NAME_USER_ID});
                    $doerData['doer_description'] = $description; 
                    
                    $userSkills = UserSpeciality::getUserSkills($doer->{Globals::FLD_NAME_USER_ID});
                    if(empty($userSkills)){
                        $doerData['skills_data'] = array(); 
                    }
                    else{
                        $doerSkill = array();
                        foreach($userSkills as $userSkill){
                            $skillData['project_skills'] = $userSkill['skilllocale']->{Globals::FLD_NAME_SKILL_DESC};
                            $doerSkill[] = $skillData;
                        }
                        $doerData['skills_data'] = $doerSkill; 
                    }
                    $doerList[] = $doerData;
                }
                $doerDetail = $doerList;
                return json_encode(array('status' => 'ok', 'data' => $doerDetail, 'status_code' => 'DoerSearchSuccess'));
            }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'DoerSearchFailed'));
       }
   }
   
   public function forgot_password($params)
   {
       try{
           @$userId = $params['user_id'];
           @$verificationCode = $params['ver_code'];
           @$password = $params['pwd'];
           if(isset($userId))
           {
    //         if(!self::validateToken($params['user_token'])){
    //            throw new Exception('InvalidToken', 200);
    //         }
               $user = User::model()->findByPk($userId);
               if(empty($user)){
                    throw new Exception("ForgotPasswordFailed");
               }
               else{
                    if(isset($verificationCode)){
                       if($verificationCode == $user[Globals::FLD_NAME_VERIFICATION_CODE]){
                           return json_encode(array('status' => 'ok', 'data' => '', 'status_code' => 'ForgotPasswordSuccess'));
                       }
                       else{
                           throw new Exception("ForgotPasswordFailed");
                       }
                    }
                    else if(isset($password) && $password!=''){
                            $newPassword = md5($password.Yii::app()->params["salt"]);
                            $user->{Globals::FLD_NAME_PASSWORD}= $newPassword;
                            if(!$user->update()){
                                throw new Exception('ForgotPasswordFailed');
                            }	
                            else{
                                return json_encode(array('status' => 'ok', 'data' => '', 'status_code' => 'ForgotPasswordSuccess'));
                            }
                    }
                    else{
                        $verificationcode = CommonUtility::generateVerificationCode();
                        $user->{Globals::FLD_NAME_VERIFICATION_CODE}= $verificationcode;
                        $data['verification_code'] = $verificationcode;
                        if(!$user->update()){
                            throw new Exception('ForgotPasswordFailed');
                        }	
                        else{
                            return json_encode(array('status' => 'ok', 'data' => $data, 'status_code' => 'ForgotPasswordSuccess'));
                        }
                    }
               }
           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'ForgotPasswordFailed'));
       }
   }
   
   public function change_password($params)
   {
       try{
           $userId = $params['user_id'];
           $password = $params['pwd'];
           $newPassword = $params['new_pwd'];
           if(isset($userId) && isset($password) && isset($newPassword))
           {
    //         if(!self::validateToken($params['user_token'])){
    //            throw new Exception('InvalidToken', 200);
    //         }
               $user = User::getUserByIdAndPassword($userId,$password);
               if(empty($user)){
                   throw new Exception("ChangePasswordFailed");
               }
               else{
                   $newPassword = md5($newPassword.Yii::app()->params["salt"]);
                   $user->password = $newPassword;
                   if(!$user->update())
                   {
                       throw new Exception("ChangePasswordFailed");
                   }	
                   else
                   {
                       return json_encode(array('status' => 'ok', 'data' => '', 'status_code' => 'ChangePasswordSuccess'));
                   }
               }
           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'ChangePasswordFailed'));
       }
   }
   
   public function view_proposal($params)
   {
       try{
           @$userType = $params['user_type'];
           @$userId = $params['user_id'];
           @$taskId = $params['task_id'];
           if(isset($userType) && isset($taskId) && isset($userId))
           {
    //         if(!self::validateToken($params['user_token'])){
    //            throw new Exception('InvalidToken', 200);
    //         }
               $taskTasker = new TaskTasker;
               if($userType==Globals::DEFAULT_VAL_CREATOR_ROLE_POSTER)
               {
                   $dataProvider = $taskTasker->getProposalsOfTasks($taskId);
                   $proposals = TaskTasker::model()->findAll($dataProvider->criteria);
               }
               else if($userType==Globals::DEFAULT_VAL_CREATOR_ROLE_TASKER)
               {
                   $result[0] = $taskTasker->getUserProposalForTask($taskId,$userId);
                   $proposals = empty($result[0]) ? '' : $result;
               }
               if(empty($proposals))
               {
                   throw new Exception('ViewProposalFailed');
               }
               else
               {
                    $proposalDetail = array(); 
                    $proposalList = array();
                    foreach($proposals as $proposal)
                    {
                        $proposalData['task_tasker_id'] = $proposal->{Globals::FLD_NAME_TASK_TASKER_ID}; 
                        $proposalData['task_id'] = $proposal->{Globals::FLD_NAME_TASK_ID}; 
                        $proposalData['tasker_id'] = $proposal->{Globals::FLD_NAME_TASKER_ID}; 
                        $taskerImage = CommonUtility::getThumbnailMediaURI($proposal->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180);
                        $proposalData['tasker_image'] = $taskerImage;
                        $workLocation = CommonUtility::getUserCurrentWorkLocations($proposal->{Globals::FLD_NAME_TASKER_ID});
                        $workLocation = empty($workLocation) ? 'Anywhere':$workLocation;
                        $proposalData['tasker_work_location'] = $workLocation; 

                        $description = CommonUtility::getUserDescription($proposal->{Globals::FLD_NAME_TASKER_ID});
                        $proposalData['tasker_description'] = $description; 

                        $userSkills = UserSpeciality::getUserSkills($proposal->{Globals::FLD_NAME_TASKER_ID});
                        if(empty($userSkills)){
                            $proposalData['skills_data'] = array(); 
                        }
                        else{
                            $proposalSkill = array();
                            foreach($userSkills as $userSkill){
                                $skillData['project_skills'] = $userSkill['skilllocale']->{Globals::FLD_NAME_SKILL_DESC};
                                $proposalSkill[] = $skillData;
                            }
                            $proposalData['skills_data'] = $proposalSkill; 
                        }
                        $attachments = CommonUtility::getTaskAttachmentFiles($proposal->{Globals::FLD_NAME_TASKER_ATTACHMENTS});
                        $proposalAttachment = array();
                        foreach ($attachments as $index => $file) 
                        {
                            $key = str_replace($proposal['user']->profile_folder_name. "/", '', $file);
                            $fileUrl = CommonUtility::getProposalAttachmentURI($proposal->{Globals::FLD_NAME_TASK_TASKER_ID},$key);
                            $attachmentData['proposal_attachment'] = $fileUrl;
                            $proposalAttachment[] = $attachmentData;
                        }
                        $proposalData['attachment_data'] = $proposalAttachment; 
                        $questions = TaskQuestion::getTaskQuestion($taskId);
                        if(empty($questions))
                        {
                            $proposalData['question_data'] = array(); 
                            $proposalData['answer_data'] = array(); 
                        }
                        else
                        {
                            $answers = CommonUtility::getQuestionAnswerByTasker($taskId, $proposal->{Globals::FLD_NAME_TASKER_ID});
                            if(empty($answers))
                            {
                                $proposalData['question_data'] = array(); 
                                $proposalData['answer_data'] = array(); 
                            }
                            else
                            {
                                $questionList = array();
                                $answerList = array();
                                foreach($questions as $question)
                                {
                                    $taskQuestion['task_question'] = $question['categoryquestionlocale']->question_desc;
                                    $taskAnswer['task_question_answer'] = $answers[$question->{Globals::FLD_NAME_TASK_QUESTION_ID}];
                                    $questionList[] = $taskQuestion;
                                    $answerList[] = $taskAnswer;
                                }
                                $proposalData['question_data'] = $questionList; 
                                $proposalData['answer_data'] = $answerList; 
                            }
                        }
                        $proposalList[] = $proposalData;
                    }
                    $proposalDetail = $proposalList;    
                    return json_encode(array('status' => 'ok', 'data' => $proposalDetail, 'status_code' => 'ViewProposalSuccess'));
               }
           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo  );
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'ViewProposalFailed'));
       }
   }
   
   public function user_licence($params)
   {
       try{
           @$userId = $params['user_id'];
           if(isset($userId)){
               $user = User::model()->findByPk($userId);
               if(empty($user)){
                   throw new Exception('UserLicenceFailed');
               }
               else{
                   $licenceData = array();
                   $licence['is_virtualdoer_licence'] = $user->is_virtualdoer_license;
                   $licence['is_inpersondoer_license'] = $user->is_inpersondoer_license;
                   $licence['is_instantdoer_license'] = $user->is_instantdoer_license;
                   $licence['is_premiumdoer_license'] = $user->is_premiumdoer_license;
                   $licence['is_poster_license'] = $user->is_poster_license;
                   $licenceData['user_licence'] = $licence;
                   return json_encode(array('status' => 'ok', 'data' => $licenceData, 'status_code' => 'UserLicenceSuccess'));
               }
           }
           else{
               throw new Exception('UserLicenceFailed');
           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo);
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'UserLicenceFailed'));
       }
   }
   
   public function my_projects($params)
   {
       try{
           @$userId = $params['user_id'];
           if(isset($userId)){
               $user = User::model()->findByPk($userId);
               if(empty($user)){
                   throw new Exception('MyProjectsFailed');
               }
               else{
                   $task = new Task();
                   $projectAsPoster = $task->getUserTaskList($userId);
                   foreach($projectAsPoster as $posterProject)
                   {
                       $posterData['task_id'] = $posterProject->{Globals::FLD_NAME_TASK_ID};
                       $posterData['title'] = $posterProject->{Globals::FLD_NAME_TITLE};
                       $posterData['description'] = $posterProject->{Globals::FLD_NAME_DESCRIPTION};
                       $posterData['price'] = $posterProject->{Globals::FLD_NAME_PRICE};
                       $posterData['price_currency'] = $posterProject->{Globals::FLD_NAME_PRICE_CURRENCY};
                       $posterData['description'] = $posterProject->{Globals::FLD_NAME_DESCRIPTION};
                       $posterData['posted_date'] = $posterProject->{Globals::FLD_NAME_CREATED_AT};
                       $posterData['proposals_average_price'] = $posterProject->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE};
                       $posterData['total_proposals'] = $posterProject->{Globals::FLD_NAME_PROPOSALS_CNT};
                       $posterData['is_premium'] = $posterProject->{Globals::FLD_NAME_IS_PREMIUM_TASK};
                       $posterData['task_assigned_on'] = $posterProject->{Globals::FLD_NAME_TASK_ASSIGNED_ON};
                       $taskCategory = TaskCategory::getTaskCategoryName($posterProject->{Globals::FLD_NAME_TASK_ID});
                       if(empty($taskCategory)){
                            throw new Exception("MyProjectsFailed");
                       }
                       else{
                            $posterData['category'] = $taskCategory[0]['categorylocale']->{Globals::FLD_NAME_CATEGORY_NAME}; 
                       }
                       $taskSkills = TaskSkill::getTaskSkills($posterProject->{Globals::FLD_NAME_TASK_ID});
                       if(empty($taskSkills)){
                            $posterData['skills_data'] = array(); 
                       }
                       else{
                            $projectSkill = array();
                            foreach($taskSkills as $taskSkill){
                                $skillData['project_skills'] = $taskSkill['skilllocale']->{Globals::FLD_NAME_SKILL_DESC};
                                $projectSkill[] = $skillData;
                            }
                            $posterData['skills_data'] = $projectSkill; 
                       }
                       $taskLocation = CommonUtility::getTaskPreferredLocations($posterProject->{Globals::FLD_NAME_TASK_ID});
                       if(empty($taskCategory)){
                            $posterData['project_location'] = 'Anywhere'; 
                       }
                       else{
                            $posterData['project_location'] = $taskLocation; 
                       }
                       $posterProjectList[] = $posterData;
                   }
                   $projectAsTasker = $task->getTaskAsTasker($userId);
                   foreach($projectAsTasker as $taskerProject)
                   {
                       $taskerData['task_id'] = $taskerProject->{Globals::FLD_NAME_TASK_ID};
                       $taskerData['title'] = $taskerProject->{Globals::FLD_NAME_TITLE};
                       $taskerData['description'] = $taskerProject->{Globals::FLD_NAME_DESCRIPTION};
                       $taskerData['price'] = $taskerProject->{Globals::FLD_NAME_PRICE};
                       $taskerData['price_currency'] = $taskerProject->{Globals::FLD_NAME_PRICE_CURRENCY};
                       $taskerData['description'] = $taskerProject->{Globals::FLD_NAME_DESCRIPTION};
                       $taskerData['posted_date'] = $taskerProject->{Globals::FLD_NAME_CREATED_AT};
                       $taskerData['proposals_average_price'] = $taskerProject->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE};
                       $taskerData['total_proposals'] = $taskerProject->{Globals::FLD_NAME_PROPOSALS_CNT};
                       $taskerData['is_premium'] = $taskerProject->{Globals::FLD_NAME_IS_PREMIUM_TASK};
                       $taskerData['task_assigned_on'] = $taskerProject->{Globals::FLD_NAME_TASK_ASSIGNED_ON};
                       $taskCategory = TaskCategory::getTaskCategoryName($taskerProject->{Globals::FLD_NAME_TASK_ID});
                       if(empty($taskCategory)){
                            throw new Exception("MyProjectsFailed");
                       }
                       else{
                            $taskerData['category'] = $taskCategory[0]['categorylocale']->{Globals::FLD_NAME_CATEGORY_NAME}; 
                       }
                       $taskSkills = TaskSkill::getTaskSkills($taskerProject->{Globals::FLD_NAME_TASK_ID});
                       if(empty($taskSkills)){
                            $taskerData['skills_data'] = array(); 
                       }
                       else{
                            $projectSkill = array();
                            foreach($taskSkills as $taskSkill){
                                $skillData['project_skills'] = $taskSkill['skilllocale']->{Globals::FLD_NAME_SKILL_DESC};
                                $projectSkill[] = $skillData;
                            }
                            $taskerData['skills_data'] = $projectSkill; 
                       }
                       $taskLocation = CommonUtility::getTaskPreferredLocations($taskerProject->{Globals::FLD_NAME_TASK_ID});
                       if(empty($taskCategory)){
                            $taskerData['project_location'] = 'Anywhere'; 
                       }
                       else{
                            $taskerData['project_location'] = $taskLocation; 
                       }
                       $taskerProjectList[] = $taskerData;
                   }
                   $projectData['project_as_poster'] = $posterProjectList;
                   $projectData['project_as_tasker'] = $posterProjectList;
//                   echo '<pre>';
//                   print_r($projectData);
//                   exit;
                   return json_encode(array('status' => 'ok', 'data' => $projectData, 'status_code' => 'MyProjectsSuccess'));
               }
           }
           else{
               throw new Exception('MyProjectsFailed');
           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo);
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'MyProjectsFailed'));
       }
   }
   
   public function is_suspended($params){
       try{
           @$userId = $params['user_id'];
           @$userType = $params['user_type']; // i-individual,t-team
           if(isset($userId) && isset($userType)){
               
           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo);
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'IsSuspendedFailed'));
       }
   }
   
   public function bookmark_user($params){
       try{
           @$userId = $params['user_id'];
           @$bookmarkUserId = $params['bookmark_user_id'];
           if(isset($userId) && isset($bookmarkUserId)){
               $user = User::model()->findByPk($userId);
               if(empty($userId)){
                   throw new Exception('BookmarkUserFailed');
               }
               else{
                   $bookmarkUser = User::model()->findByPk($bookmarkUserId);
                   if(empty($bookmarkUser)){
                        throw new Exception('BookmarkUserFailed');
                   }
                   else{
                       $userBookMark = UserBookmark::model()->findByAttributes(array('bookmark_user_id' => $bookmarkUserId,'user_id' => $userId));
                       if(empty($userBookMark)){
                            $userBookMark = new UserBookmark;
                            $userBookMark[Globals::FLD_NAME_BOOKMARK_USER_ID] = $bookmarkUserId;
                            $userBookMark[Globals::FLD_NAME_USER_ID] = $userId;
                            $userBookMark[Globals::FLD_NAME_CREATED_BY] = $userId;
                            $userBookMark[Globals::FLD_NAME_BOOKMARK_TYPE] = Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER;
                            $userBookMark[Globals::FLD_NAME_BOOKMARK_SUBTYPE] = Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE;
                            if(!$userBookMark->save()){
                                    throw new Exception('BookmarkUserFailed');
                            }
                            else{
                                    return json_encode(array('status' => 'ok', 'data' => '', 'status_code' => 'BookmarkUserSuccess'));
                            }
                       }
                       else{
                            UserBookmark::model()->DeleteByPk($userBookMark->{Globals::FLD_NAME_BOOKMARK_ID});
                            return json_encode(array('status' => 'ok', 'data' => '', 'status_code' => 'BookmarkUserSuccess'));
                       }
                   }
               }
           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo);
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'BookmarkUserFailed'));
       }
   }
   
   public function bookmark_project($params){
       try{
           @$userId = $params['user_id'];
           @$taskId = $params['project_id'];
           if(isset($taskId) && isset($userId)){
               $user = User::model()->findByPk($userId);
               if(empty($userId)){
                   throw new Exception('BookmarkProjectFailed');
               }
               else{
                   $task = Task::model()->findByPk($taskId);
                   if(empty($task)){
                        throw new Exception('BookmarkProjectFailed');
                   }
                   else{
                        $userBookMark = UserBookmark::model()->findByAttributes(array('task_id' => $taskId,'user_id' => $userId));
                        if(empty($userBookMark)){
                            $userBookMark = new UserBookmark;
                            $userBookMark[Globals::FLD_NAME_USER_ID] = $userId;
                            $userBookMark[Globals::FLD_NAME_TASK_ID] = $taskId;
                            $userBookMark[Globals::FLD_NAME_CREATED_BY] = $userId;
                            $userBookMark[Globals::FLD_NAME_BOOKMARK_TYPE] = Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK;
                            $userBookMark[Globals::FLD_NAME_BOOKMARK_SUBTYPE] = Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE;
                            if(!$userBookMark->save()){
                                throw new Exception('BookmarkProjectFailed');
                            }
                            else{
                                return json_encode(array('status' => 'ok', 'data' => '', 'status_code' => 'BookmarkProjectSuccess'));
                            }
                        }
                        else{
                            UserBookmark::model()->DeleteByPk($userBookMark->{Globals::FLD_NAME_BOOKMARK_ID});
                            return json_encode(array('status' => 'ok', 'data' => '', 'status_code' => 'BookmarkProjectSuccess'));
                        }
                   }
               }
           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo);
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'BookmarkProjectFailed'));
       }
   }
   
   public function bookmark_user_for_project($params){
       try{
           @$userId = $params['user_id'];
           @$taskId = $params['project_id'];
           @$bookmarkUserId = $params['bookmark_user_id'];
           if(isset($userId) && isset($taskId) && isset($bookmarkUserId)){
               $user = User::model()->findByPk($userId);
               if(empty($userId)){
                   throw new Exception('BookmarkUserForProjectFailed');
               }
               else{
                   $task = Task::model()->findByPk($taskId);
                   if(empty($task)){
                        throw new Exception('BookmarkUserForProjectFailed');
                   }
                   else{
                       $user = User::model()->findByPk($bookmarkUserId);
                       if(empty($userId)){
                            throw new Exception('BookmarkUserForProjectFailed');
                       }
                       else{
                            $userBookMark = UserBookmark::model()->findByAttributes(array('task_id' => $taskId,'user_id' => $userId,'bookmark_user_id' => $bookmarkUserId));
                            if(empty($userBookMark)){
                                $userBookMark = new UserBookmark;
                                $userBookMark[Globals::FLD_NAME_BOOKMARK_USER_ID] = $bookmarkUserId;
                                $userBookMark[Globals::FLD_NAME_USER_ID] = $userId;
                                $userBookMark[Globals::FLD_NAME_TASK_ID] = $taskId;
                                $userBookMark[Globals::FLD_NAME_CREATED_BY] = $userId;
                                $userBookMark[Globals::FLD_NAME_BOOKMARK_SUBTYPE] = Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE;
                                if(!$userBookMark->save()){
                                    throw new Exception('BookmarkUserForProjectFailed');
                                }
                                else{
                                    return json_encode(array('status' => 'ok', 'data' => '', 'status_code' => 'BookmarkUserForProjectSuccess'));
                                }
                            }
                            else{
                                UserBookmark::model()->DeleteByPk($userBookMark->{Globals::FLD_NAME_BOOKMARK_ID});
                                return json_encode(array('status' => 'ok', 'data' => '', 'status_code' => 'BookmarkUserForProjectSuccess'));
                            }
                       }
                   }
               }
           }
       }
       catch(Exception $e){
           $extraInfo = array('hideoutput' => true);
         $extraInfo['errorCode'] = $e->getMessage();
         $msg = $e->getMessage();
         CommonUtility::catchErrorMsg( $msg, $extraInfo);
         
         return json_encode(array('status' => 'error', 'data' => '', 'status_code' => 'BookmarkUserForProjectFailed'));
       }
   }
}
