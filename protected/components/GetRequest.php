<?php
/**
 * GetRequest represents the data form modles.
 * 
 */
class GetRequest extends CComponent
{	 
      public function getUserPrimearyEmail($id)
      {
        try
        {
            $email = UserContact::getUserPrimearyContact($id,Globals::DEFAULT_VAL_CONTACT_EMAILTYPE);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
         return $email;
      }
      public function getUserPrimearyPhone($id)
      {
        try
        {
            $email = UserContact::getUserPrimearyContact($id,Globals::DEFAULT_VAL_CONTACT_PHONETYPE);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
         return $email;
      }
      public function getProposalById($id)
      {
        try
        {
             $taskTasker = TaskTasker::getProposalById($id);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        return $taskTasker;
      }
      public function getTaskById($id)
      {
        try
        {
            $task = Task::getTaskById($id);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
         return $task;
      }
      public function getTaskerRecentTasks($id , $limit = '-1')
      {
         try
         {
            $task = TaskTasker::getTaskerRecentTasks($id , $limit);
         }
         catch(Exception $e)
         {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
         }
         return $task;
      }
      public function getTaskerHiredByUser( $tasker_id )
      {
         try
         {
            $taskerHired = TaskTasker::getTaskerHiredByUser( $tasker_id );
         }
         catch(Exception $e)
         {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
         }
         return $taskerHired;
      }
    public function getProposalsByTask($task_id , $user_id , $limit = '-1' )
    {  
        try
        {
            $proposals = TaskTasker::getProposalsByTask( $task_id , $user_id , $limit );
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        return $proposals;
    }
    public function getInvitedTaskerForTask($task_id)
    {  
        try
        {
            $taskers = TaskTasker::getInvitedTaskerForTask($task_id);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        return $taskers;
    }
    public function getTaskerListForInvite( $task_id , $category_id , $limit = '-1' )
    {  
        $taskLocation = Globals::DEFAULT_VAL_NULL;
        $dataProvider = Globals::DEFAULT_VAL_NULL;
        $countryCode = Globals::DEFAULT_VAL_NULL;
        $region_id = Globals::DEFAULT_VAL_NULL;
        $skills = array();
        $locationRange = '';
        $users =new User();
        $task = Task::model()->findByPk( $task_id );
        $model =  User::model()->findByPk(Yii::app()->user->id);
        $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID => $task_id ));
        try
        {
            $taskSkills = TaskSkill::getTaskSkills( $task_id , array("t.".Globals::FLD_NAME_SKILL_ID) );
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        //print_r($taskLocation);
        if( !$taskSkills )
        {
            try
            {
                $taskSkills = Skill::getSkillsOfCategory( $category_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
        }
        if( $taskSkills )
        {
            foreach ( $taskSkills as $skill)
            {
                $skills[] = $skill->{Globals::FLD_NAME_SKILL_ID};
            }
        }
        if(!empty($model))
        {
            if($model->{Globals::FLD_NAME_LOCATION_LATITUDE} && $model->{Globals::FLD_NAME_LOCATION_LONGITUDE})
            {
                try
                {

                    $locationRange = CommonUtility::geologicalPlaces($model->{Globals::FLD_NAME_LOCATION_LATITUDE},$model->{Globals::FLD_NAME_LOCATION_LONGITUDE},Globals::DEFAULT_VAL_TASK_FILTER_NEARBY_RANGE);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
            }
            $countryCode = $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE};
            $region_id = $model->{Globals::FLD_NAME_BILLADDR_REGION_ID};
        }
        if(!empty($taskLocation))
        {
            if($taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE} && $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE})
            {
                try
                {
                    $locationRange = CommonUtility::geologicalPlaces($taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE},$taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE},$task->{Globals::FLD_NAME_TASKER_IN_RANGE});
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
            }
            $countryCode = $taskLocation->{Globals::FLD_NAME_COUNTRY_CODE};
            $region_id = $taskLocation->{Globals::FLD_NAME_REGION_ID};
        }
        
        $dataProvider = $users->getUsers( $skills, $task_id , $countryCode , $region_id , $locationRange , $limit );
        
         $return["data"] = $dataProvider ;
         $return["location"] = $model ;
         $return["task"] = $task ;
         return $return;
    }
    public function autoInvitation( $task_id , $category_id , $limit = '-1' )
    { 
        try
        {
            $data = self::getTaskerListForInvite( $task_id , $category_id , $limit );
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        
        $dataProvider = $data['data'];
        $taskLocation = $data['location'];
        $task = $data['task'];
        $users = $dataProvider->getData();
        //print_r($users);
        $count = 0; 
        $code = '';
        foreach( $users as $user )
        {
            if( $count < $limit )
            {
                $isinvited = TaskTasker::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id , Globals::FLD_NAME_TASKER_ID => $user->{Globals::FLD_NAME_USER_ID} ));
                if( !$isinvited )
                {
                    $model = new TaskTasker();
                    $latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
                    $longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                    $latitude2 = $user->{Globals::FLD_NAME_LOCATION_LATITUDE} ;
                    $longitude2 = $user->{Globals::FLD_NAME_LOCATION_LONGITUDE} ;
                    try
                    {
                        $getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }

                    $model->{Globals::FLD_NAME_TASK_ID} = $task_id;
                    $model->{Globals::FLD_NAME_TASKER_ID} = $user->{Globals::FLD_NAME_USER_ID};
                    $model->{Globals::FLD_NAME_SELECTION_TYPE} = Globals::DEFAULT_VAL_INVITE;
                    $model->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} = $longitude2;
                    $model->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} = $latitude2;
                    $model->{Globals::FLD_NAME_TASKER_IN_RANGE} = $getDistance;
                    $task->{Globals::FLD_NAME_INVITED_CNT} += 1;
                    if(!$model->save())
                    {
                        throw new Exception(Yii::t('commonutility','unexpected_error_for_task_tasker'));
                    }
                    else
                    {
                        $code = 'success';
                    }
                    $task_tasker_id = $model->getPrimaryKey();
                    if(!$task->update())
                    {
                        throw new Exception(Yii::t('commonutility','unexpected_error_for_task_counter'));
                    }
                }
                else
                {
                    $task_tasker_id = $isinvited->{Globals::FLD_NAME_TASK_TASKER_ID};
                }
                try
                {
                    $alert_type = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                $alert_desc = Globals::ALERT_DESC_TASKER_INVITED;
                try
                {
                    CommonUtility::addUserAlert( $alert_type , $alert_desc , $user->{Globals::FLD_NAME_USER_ID} , $task_tasker_id  );
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
            }
            else
            {
                    break; 
            }
            $count++;
        }        
        return $code;
    }
     public function taskerPreviouslyWorkedTasksPosters( $tasker_id )
    { 
         $users = '';
         try
         {
            $recentTasks =  TaskTasker::taskerPreviouslyWorkedTasks( $tasker_id );
         }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if( $recentTasks )
        {
            foreach( $recentTasks as $recentTask)
            {
                $users[] = $recentTask->task->{Globals::FLD_NAME_CREATER_USER_ID};
            }
        }
        return $users;
     }
     public function prevouslyHiredTaskerByPosterOnlyIds( $user_id )
    { 
         $users = array();
         try
         {
            $taskers =  TaskTasker::prevouslyHiredTaskerByPoster( $user_id );
         }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if( $taskers )
        {
            foreach( $taskers as $tasker)
            {
                $users[] = $tasker->{Globals::FLD_NAME_TASKER_ID};
            }
        }
        return $users;
     }
     
     public function getPotentialTaskOfUser()
    { 
        $tasks = '';
        try
        {
            $potentialTask =  UserBookmark::getpotentialTaskOfUser();
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if( $potentialTask )
        {
            foreach( $potentialTask as $task)
            {
                $tasks[] = $task->{Globals::FLD_NAME_TASK_ID};
            }
        }
        return $tasks;
     }
     public function getPotentialTaskerOfUser()
    { 
        $taskers = '';
        try
        {
            $potentialTaskers =  UserBookmark::getpotentialTaskerOfUser();
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if( $potentialTaskers )
        {
            foreach( $potentialTaskers as $potentialTasker)
            {
                $taskers[] = $potentialTasker->{Globals::FLD_NAME_BOOKMARK_USER_ID};
            }
        }
        return $taskers;
     }
      public function getInvitedTaskersByUser()
    { 
        $taskers = '';
        try
        {
            $invitedTaskers =  TaskTasker::getInvitedTaskersByUser();
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if( $invitedTaskers )
        {
            foreach( $invitedTaskers as $potentialTasker)
            {
                $taskers[] = $potentialTasker->{Globals::FLD_NAME_TASKER_ID};
            }
        }
        return $taskers;
     }
    public function getTaskBySkills($skills , $user_id = '')
    { 
        $tasks = '';
        try
        {
            $skillsTasks =  TaskSkill::getTaskIdsBySkills($skills , $user_id);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if( $skillsTasks )
        {
            foreach( $skillsTasks as $skill)
            {
                $tasks[] = $skill->{Globals::FLD_NAME_TASK_ID};
            }
        }
        return $tasks;
     }
     
     public function getTaskerBySkills($skills)
    { 
        $usersIds = '';
        try
        {
           
            $users =  UserSpeciality::getTaskersBySkils($skills);
           
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if( $users )
        {
            foreach( $users as $user)
            {
                $usersIds[] = $user->{Globals::FLD_NAME_USER_ID};
            }
        }
        return $usersIds;
     }
     
     public function highlyRatedPosters()
    { 
//         $users = '';
//        $recentTasks =  TaskTasker::taskerPreviouslyWorkedTasks( $tasker_id );
//        if( $recentTasks )
//        {
//            foreach( $recentTasks as $recentTask)
//            {
//                $users[] = $recentTask->task->{Globals::FLD_NAME_CREATER_USER_ID};
//            }
//        }
//        return $users;
     }
     public function getAllProposalsIdsOfTask($data)
    { 
        $porposals = '';
        
        if( $data )
        {
            foreach( $data as $porposal)
            {
                $porposals[] = $porposal->{Globals::FLD_NAME_TASK_TASKER_ID};
            }
        }
        return $porposals;
     }
    public function getTaskerHiredCount($tasker_id ,$user = '')
    { 
        $count = 0;
       $hired =  TaskTasker::getTaskerHiredByUser($tasker_id , $user);
      
       if($hired != '')
        $count = count($hired);
       
       return $count;
    }
    public function manageSubCategoryCountForParentCategory()
    { 
       $parentCategories =  Category::getParentCategory();
       if($parentCategories)
       {
           foreach($parentCategories as $parentCategory)
           {
               $model = $this->loadModel($parentCategory->{Globals::FLD_NAME_CATEGORY_ID});
               $childCategories = Category::getChildCategoryByID($parentCategory->{Globals::FLD_NAME_CATEGORY_ID});
               if($childCategories)
               {
                    $subCategoryCount = count($childCategories);
               }
               else
               {
                   $subCategoryCount = '0';
               }
               $success = $model->saveAttributes(array(Globals::FLD_NAME_SUB_CATEGORY_CNT => $subCategoryCount));
            
           }
       }
    }
     
    /*
    public function getCountryList()
    {
     //Yii::app()->cache->delete('getCountryList_'.Yii::app()->user->getState('language'));
       if(CommonUtility::IsProfilingEnabled())
       {
         //Yii::beginProfile('GetRequest.getCountryList',Yii::app()->controller->id.'.'.Yii::app()->action->id);
         Yii::beginProfile('GetRequest.getCountryList','GetRequest.getCountryList');
       }
       $userLang = Yii::app()->user->getState('language');
       $countries = Yii::app()->cache->get('getCountryList_'.$userLang);

       if($countries === false)
       {
         $countries = Country::getCountryList();
         Yii::app()->cache->set('getCountryList_'.$userLang, $countries);
       }

      if(empty($countries))
      {
         $defaultLang = GLOBALS::DEFAULT_LANGUAGE;
         $countries = Country::getCountryList($defaultLang);
         Yii::app()->cache->set('getCountryList_'.$userLang, $countries);
      }
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::endProfile('GetRequest.getCountryList');
      }
      return $countries;
    }  
    */
    public function getStartAndEndDateForSearch($duration,$dateAddOrRemover,$seprator = 'to')
    {
        $arrayReturn = array();
        $startDateArray = array();
        $endDateArray = array();
        $date5toold = "";
        $durationArray = explode( '-',$duration);
        $durationcount = count($durationArray);
        $durationcount = $durationcount-1;   
        for($i=0; $i<$durationcount; $i++)
        {                        
            $inarray = explode($seprator,$durationArray[$i]);                        

            if($durationcount == 1 && $durationArray[$i] == '5'.$seprator.'old' )
            {
                $date5toold =  date( "Y-m-d", strtotime( $dateAddOrRemover.@$inarray[0]." day" ));
            }
            else
            {
                if(@$inarray[1] !='old')
                {                               
                        $startDateArray[$i] =date( "Y-m-d", strtotime( $dateAddOrRemover.@$inarray[0]." day" )); 
                        $endDateArray[$i] =date( "Y-m-d", strtotime( $dateAddOrRemover.@$inarray[1]." day" ));                                                                 
                }
                else 
                {
                    $startDateArray[$i] =date( "Y-m-d", strtotime( $dateAddOrRemover.@$inarray[0]." day" )); 
                    $endDateArray[$i] =@$inarray[1];  
                }
                if($inarray[0] == '1')
                {   
                    $startDateArray[$i] =date( "Y-m-d"); 
                }                                              
                if(@$inarray[1] =='1')
                {   
                    $endDateArray[$i] =date( "Y-m-d"); 
                } 
            }
        }
        $arrayReturn[1] = $startDateArray;
        $arrayReturn[2] = $endDateArray;
        $arrayReturn[3] = $date5toold;
        return $arrayReturn;
    }
    public function getProposal($proposals)
    {
        $startLimit = array();
        $endLimit = array();
        $proposalsArray = explode( '-',$proposals);
        $proposalscount = count($proposalsArray);
        $proposalscount = $proposalscount-1;   
        for($i=0; $i<$proposalscount; $i++)
        {
            $inarray = explode('to',$proposalsArray[$i]);                                   
            $startLimit[$i] = @$inarray[0];
            $endLimit[$i] = @$inarray[1];                           
        }
        $arrayReturn[1] = $startLimit;
        $arrayReturn[2] = $endLimit;        
        return $arrayReturn;
    }
}