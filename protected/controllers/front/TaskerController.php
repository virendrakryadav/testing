<?php

class TaskerController extends Controller
{
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
	public function accessRules()
	{
            
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('ajaxgetpreferredlocationlist',),
				'users' => array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('invitetasker','invitenow','getaverage','viewprofile','taskersmapview', 'proposaldetail','hiremepopup',
                                    'proposaldetailtasker','mytasks','setpotential','confirmhiringbydoer',
                                    'unsetpotential','setpotentialsave','unsetpotentialsave','markread','markunread','savefilter','savefiltertaskproposal','savefilterform','savefiltertaskproposalform','loadfilterstask','filterformmytasks','savefiltermytasks','getactionfilter',
                                    'savebookmark','taskpreview','inviteuserpopup','tasklist','getcategories','getsubcategories','deletesearchfilter','getcategoriesfilter','projectcompletion','displayposterrating','saveposterrating','paymentfordoer'),
				'users' => array('@'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actions()
	{
		return array(	
		);
	}

        public function actionGetaverage()
	{
                CommonUtility::startProfiling();
                $average = Globals::DEFULT_FIXED_PRICE;
                $latitude = $_POST[Globals::FLD_NAME_LATITUDE];
                $longitude = $_POST[Globals::FLD_NAME_LONGITUDE];
                $range = $_POST[Globals::FLD_NAME_RANGE];
                $type = $_POST[Globals::FLD_NAME_TYPE];
                if(is_numeric($range) && $range>1)
                {
                        try
                        {
                            $locationRange = CommonUtility::geologicalPlaces($latitude,$longitude,$range);
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
                        }
                        try
                        {
                            $dataProvider=TaskLocation::getTaskListAverage($locationRange,$type);
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
                        }
                        if(!empty($dataProvider))
                            {
                                try
                                {
                                    $average = CommonUtility::getAverage($dataProvider);
                                }
                                catch(Exception $e)
                                {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ) );
                                }
                            }
                    }
                echo $average;
//                exit();
                CommonUtility::endProfiling();
	}

	public function actionInviteTasker()
	{	
                CommonUtility::startProfiling();
                $task_id = $_GET[Globals::FLD_NAME_TASKID];
                $category_id = $_GET[Globals::FLD_NAME_CATEGORY_ID];
                try
                {
                    $data = GetRequest::getTaskerListForInvite( $task_id , $category_id );
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ,"Category ID" => $category_id) );
                }
                $dataProvider = $data['data'];
                $taskLocation = $data['location'];
            //    print_r($taskLocation);
                $task = $data['task'];
                $this->layout = '//layouts/noheader';
                $this->render('invitetasker', 
                        array(  'task'=>$task,
                            'task_id'=>$task_id,
                            'category_id'=>$category_id,
                                'taskLocation'=>$taskLocation,
                                'dataProvider'=>$dataProvider,
                                ));
                CommonUtility::endProfiling();
            
	}
    /**
    * hiremepopup action 
    * @params task_tasker_id
    * @return html hire terms  
    * @var
    */
    public function actionHireMePopup()
    {
        CommonUtility::startProfiling();
        try
        {
            $taskTaskerId = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
            $taskTasker = TaskTasker::model()->findByPk($taskTaskerId);
            $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $message = new Inbox();
            $hireMe = $this->renderPartial('partial/_tasker_hireme_popup',  array( 'taskTasker' => $taskTasker, 'task' => $task , 'message' => $message) , true , false);
              echo CJSON::encode(array(
                                               'status'=>'success',
                                               'html' => $hireMe
                              ));
        }
        catch(Exception $e)
        {     
            //catch exception
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg );
        }
        CommonUtility::endProfiling();
    }
    
    /**
    * hiremepopup action 
    * @params task_tasker_id
    * @return html hire terms  
    * @var
    */
    public function actionConfirmHiringByDoer()
    {
        CommonUtility::startProfiling();
        try
        {
            $taskTaskerId = $_GET[Globals::FLD_NAME_TASK_TASKER_ID];
            $taskTasker = TaskTasker::model()->findByPk($taskTaskerId);
        }
        catch(Exception $e)
        {     
            //catch exception
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg );
        }
        if($taskTasker->{Globals::FLD_NAME_TASKER_ID} == Yii::app()->user->id && $taskTasker->{Globals::FLD_NAME_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_HIRING)
        {
            
            try
            {
                $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
                $message = new Inbox();
                $message->scenario = 'approve_proposal';
                $this->layout = '//layouts/noheader'; 
                $this->render('confirm_hiring_by_doer',  array( 'taskTasker' => $taskTasker, 'task' => $task , 'message' => $message));
            }
            catch(Exception $e)
            {     
                //catch exception
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg );
            }
        }
        else
        {
            throw new CHttpException(Globals::DEFAULT_VAL_404,Yii::t('tasker_createtask','page_not_exist'));
        }
        
        CommonUtility::endProfiling();
    }

      public function actionInviteNow()
      {
          CommonUtility::startProfiling();
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
			
                $model = new TaskTasker();
                $task = $this->loadModel($_POST[Globals::FLD_NAME_TASK_ID]);
                //$model->attributes = $_POST[Globals::FLD_NAME_TASK];
                $model->{Globals::FLD_NAME_TASK_ID} = $_POST[Globals::FLD_NAME_TASK_ID];

                $model->{Globals::FLD_NAME_TASKER_ID} = $_POST[Globals::FLD_NAME_USER_ID];
                $model->{Globals::FLD_NAME_SELECTION_TYPE} = Globals::DEFAULT_VAL_INVITE;
                $model->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} = $_POST[Globals::FLD_NAME_LOCATION_LATITUDE];
                $model->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} = $_POST[Globals::FLD_NAME_LOCATION_LONGITUDE];
                $model->{Globals::FLD_NAME_TASKER_IN_RANGE} = $_POST[Globals::FLD_NAME_TASKER_IN_RANGE];
                $task->{Globals::FLD_NAME_INVITED_CNT} += 1;
                try
                {
                        if(!$model->save())
                        {
                                     throw new Exception(Yii::t('tasker_createtask','unexpected_error'));
                        }

                        if(!$task->update())
                        {
                                     throw new Exception(Yii::t('tasker_createtask','unexpected_error'));
                        }
//                   

                        echo CJSON::encode(array(
                                               'errorCode'=>'success'
                              ));
                }
                catch(Exception $e)
                {
                             echo $e->getMessage();
                             if (CommonUtility::IsTraceEnabled())
                             {
                                     Yii::trace('Executing actionInviteNow() method','TaskerController');
                             }
                             Yii::log('Tasker.InviteNow: reason:-'.$msg,CLogger::LEVEL_ERROR ,'TaskerController');
                }
		   


//               if($model->save())
//                {
//                    echo CJSON::encode(array(
//                              'errorCode'=>'success'
//                     ));
//                }
				Yii::app()->end();
            
            CommonUtility::endProfiling();
        }

        protected function performAjaxValidation($model)
	{
           
            if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX] === Globals::DEFAULT_VAL_CONTACT_INFORMATION_FORM)
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            
        }
	public function loadModel($id)
	{
            
            $model=Task::model()->findByPk($id);
            if($model===null)
                throw new CHttpException(Globals::DEFAULT_VAL_404,Yii::t('tasker_createtask','page_not_exist'));
            return $model;
            
	}
	public function loadModelUser($id)
	{
            
            $model=User::model()->findByPk($id);
            if($model===null)
                throw new CHttpException(Globals::DEFAULT_VAL_404,Yii::t('tasker_createtask','page_not_exist'));
            return $model;
            
	}
   
   public function actionViewProfile()
   {
      CommonUtility::startProfiling();
      if(isset($_GET[Globals::FLD_NAME_USERID])){
         $id = $_GET[Globals::FLD_NAME_USERID];
         $user = User::model()->findByPk($id);
         if(isset($user)){
            $this->render('taskerprofile', array(
               'model' => $user, 
           
               ));
         }else{
            
         }
      }
    
      CommonUtility::endProfiling();
   }
   public function actionTaskersMapView()
    {	
            CommonUtility::startProfiling();
            $task_id = $_POST[Globals::FLD_NAME_TASKID];
            $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
            try
            {
                $data = GetRequest::getTaskerListForInvite( $task_id , $category_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ,"Category ID" => $category_id) );
            }
            //print_r($data);
            $dataProvider = $data['data'];
            $taskLocation = $data['location'];
            $task = $data['task'];
            $users =  $dataProvider->getdata();

            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            $this->renderPartial('_taskersmapview', 
                    array(  'task'=>$task,
                            'taskLocation'=>$taskLocation,
                            'users'=>$users,
                            ),false,true);

            CommonUtility::endProfiling();

    }
   public function actionInviteUserPopup()
   {
       CommonUtility::startProfiling();
       //$task_id = $_POST[Globals::FLD_NAME_TASK_ID];
       $user_id = $_POST[Globals::FLD_NAME_USER_ID];
       $distance = $_POST['distance'];
       $user = User::model()->findByPk($user_id);
       //$task = Task::model()->findByPk($task_id);
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
       $this->renderPartial('_taskermappopup', 
                    array(  //'task'=>$task,
                            'distance'=>$distance,
                            'data'=>$user,
                            ),false,true);
       CommonUtility::endProfiling();
   }
   
   public function actionProposalDetail(){
      CommonUtility::startProfiling();
      Yii::app()->clientScript->registerCoreScript('jquery');     
      Yii::app()->clientScript->registerCoreScript('jquery.ui'); 
      Yii::app()->clientScript->registerCoreScript('yiiactiveform');
      $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/fileuploader.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/chosen.jquery.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery.ui.timepicker.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery-ui-timepicker-addon.js");
      try{
      @$task_id = $_GET[Globals::FLD_NAME_TASK_ID];
      @$task_tasker_id = $_GET[Globals::FLD_NAME_TASK_TASKER_ID];
      @$currentTasker = $_GET['currentaskers'];
      $task = Task::model()->with('taskcategory', 'category', 'categorylocale')->findByPk($task_id);
      $model =  $model=User::model()->findByPk($task->{Globals::FLD_NAME_CREATER_USER_ID});
        $task_tasker = TaskTasker::model()->findByPk($task_tasker_id);
       // $taskTasker = new TaskTasker();
        if(!$currentTasker)
        {
           $currentTasker = $task_tasker->{Globals::FLD_NAME_TASKER_ID};
        }
      $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID => $task_id));
      $taskall = new TaskTasker();
       $message = new Inbox();
      try
      {
        $proposals = $taskall->getProposalsOfTasks( $task_id  );
      }
      catch(Exception $e)
      {             
              $msg = $e->getMessage();
              CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
      } 
      try
      {
          $reviewFilter = array(
              'pageSize' => Globals::PAGE_SIZE_REVIEW_PROPOSAL_DETAIL
          );
        $reviews = $taskall->getReviewsOfTasker( $currentTasker , $reviewFilter  );
      }
      catch(Exception $e)
      {             
              $msg = $e->getMessage();
              CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
      } 
      try 
        {
            $filters = array(
                Globals::FLD_NAME_TASK_ID => $task_id,
                Globals::FLD_NAME_FROM_USER_ID => $currentTasker,
                Globals::FLD_NAME_CREATER_USER_ID => $task->{Globals::FLD_NAME_CREATER_USER_ID},
            );
            
        
            $messagesOnTask = $message->getMessagesOnTask($filters);
    
            
            
        } 
        catch (Exception $e) 
        {
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id) );
        }
      $proposalsDetail = $taskall->getProposalsOfTasks( $task_id  , '','','','','','','',array(),'','','1');
      $this->layout = '//layouts/noheader';  
      $this->render('proposaldetail', array('task' => $task,'proposals'=>$proposals , 'proposalsDetail' => $proposalsDetail , 'message' => $message,
                            'messagesOnTask' => $messagesOnTask,
                            'model'=>$model,
                            'currentTasker' => $currentTasker,
          'reviews' => $reviews
              ));
      }catch(Exception $e){
         $msg = $e->getMessage();
              CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) ); 
      }
      CommonUtility::endProfiling();
   }
    public function actionProposalDetailTasker()
    {
        CommonUtility::startProfiling();
        Yii::app()->clientScript->registerCoreScript('jquery');     
        Yii::app()->clientScript->registerCoreScript('jquery.ui'); 
        Yii::app()->clientScript->registerCoreScript('yiiactiveform');
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile(Yii::app()->baseUrl."/js/fileuploader.js");
        $cs->registerScriptFile(Yii::app()->baseUrl."/js/chosen.jquery.js");
        $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery.ui.timepicker.js");
        $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery-ui-timepicker-addon.js");
        try
        {
            @$task_id = $_GET[Globals::FLD_NAME_TASK_ID];
            @$task_tasker_id = $_GET[Globals::FLD_NAME_TASK_TASKER_ID];
            $task = Task::model()->with('taskcategory', 'category', 'categorylocale')->findByPk($task_id);
            
            $task_tasker = TaskTasker::model()->findByPk($task_tasker_id);
            $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID => $task_id));
            
            @$quickFilter = $_GET[Globals::FLD_NAME_QUICK_FILTER];
            @$taskerName = $_GET[Globals::FLD_NAME_USER_NAME];
            //@$taskerRank = $_GET[Globals::FLD_NAME_USER][Globals::FLD_NAME_RANK];
            
            @$minPrice = $_GET[Globals::FLD_NAME_MINPRICE];
            @$maxPrice = $_GET[Globals::FLD_NAME_MAXPRICE];
            @$rating = $_GET[Globals::FLD_NAME_RATING];
            @$taskerInRange = $_GET[Globals::FLD_NAME_TASKER_IN_RANGE];
            @$all = $_GET[Globals::FLD_NAME_TASK_TASKER][Globals::DEFAULT_VAL_ALL];
            @$locations = $_GET[Globals::FLD_NAME_PROPOSAL_LOCATIONS];
            
            $taskall = new TaskTasker();
            try
            {
                $getAllProposalsInDefualtOrder = $taskall->getProposalsOfTasks( $task_id  ,'','','','','','','',array(),'','','',true);
                $proposalIds = GetRequest::getAllProposalsIdsOfTask($getAllProposalsInDefualtOrder->getData());
               // print_r($proposalIds);
                if( $quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE ) 
                {
                    try
                    {
                        $filterArray = GetRequest::getPotentialTaskerOfUser();
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                }
                $proposals = $taskall->getProposalsOfTasks( $task_id , $quickFilter , $taskerName ,$minPrice , $maxPrice , $taskerInRange , $locations ,$rating);
                $prices = $taskall->getMaxAndMinPriceOfProposalsForTask( $task_id );
                $maxPrice = intval($prices[Globals::FLD_NAME_MAXPRICE]);
                $minPrice = intval($prices[Globals::FLD_NAME_MINPRICE]);
//                $proposals = $taskall->getProposalsOfTasks( $task_id  );
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
            }
            //$proposalsDetail = $taskall->getProposalsOfTasks( $task_id  , '','','','','','','','1' );
            $this->layout = '//layouts/noheader';  
//            $this->render('proposaldetailtasker', array('task' => $task,'proposals'=>$proposals , 'task_tasker' => $task_tasker));
            $this->render('proposaldetailtasker',array('task'=>$task , 'proposals' => $proposals ,  'maxPrice' => $maxPrice ,'minPrice' => $minPrice , 'taskLocation' => $taskLocation
                ,'proposalIds' => $proposalIds, 'task_tasker' => $task_tasker));
        }
        catch(Exception $e)
        {
         
        }
        CommonUtility::endProfiling();
   }
    public function actionTasklist()
    {        
        CommonUtility::startProfiling();
            $userLicenseType = Yii::app()->user->getState('user_type');
            if($userLicenseType == 'p' || $userLicenseType == 'non')
                throw new CHttpException(ErrorCode::ERROR_CODE_IS_POSTER_LICENSE,Yii::t('poster_createtask','To fiend a project you need doer license.'));
        
            
            
           /// Yii::app()->clientScript->scriptMap['searchMyPoposals'] = false;
            $model = new Task();
            $model->unsetAttributes();
            $filterArray = '';
            $category_id = '';
           // echo $_GET["taskType"];
//            $userLicense = array();
            $userLicense = CommonUtility::getUserLicense();
//            print_r($userLicense);
            @$subCategoryName = $_GET[Globals::FLD_NAME_SUBCATEGORYNAME];
            @$quickFilter = $_GET[Globals::FLD_NAME_QUICK_FILTER];
            @$taskTitle = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE];
            @$startDate = $_GET[Globals::FLD_NAME_CREATED_AT];
            @$minPrice = $_GET[Globals::FLD_NAME_MINPRICE];
            @$maxPrice = $_GET[Globals::FLD_NAME_MAXPRICE];
            @$maxDate = $_GET[Globals::FLD_NAME_MAXDATE];
            @$minDate = $_GET[Globals::FLD_NAME_MINDATE];
            @$rating = $_GET[Globals::FLD_NAME_RATING];
            @$skills = $_GET[Globals::FLD_NAME_SKILLS_SMALL];
            @$hired = $_GET[Globals::FLD_NAME_HIRED];
            @$jobs = $_GET[Globals::FLD_NAME_JOBS];
            
           // @$endingToday = $_GET[Globals::FLD_NAME_ENDING_TODAY];
            @$taskKind = $_GET[Globals::FLD_NAME_TASKTYPE];
            @$locations = $_GET[Globals::FLD_NAME_TASKLOCATIONS];
            @$categoryName = $_GET[Globals::FLD_NAME_CATEGORYNAME];
            @$sort = $_GET[Globals::FLD_NAME_SORT];
            
            @$duration = $_GET['duration'];
            @$ending = $_GET['ending'];
            @$proposals = $_GET['proposals'];
            @$relationships = $_GET['relationships'];
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/fileuploader.js");
            try
            {
                
                
                if(isset($categoryName))
                {
                    try
                    {
                        $category_id = CommonUtility::getCategoryIdFromString($categoryName);
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                    try
                    {
                        $filterArray = CommonUtility::getChildCategorysIdsFromParent($category_id);
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                 //   print_r($filterArray);
                }
                 if(isset($subCategoryName))
                {
                    try
                    {
                        $filterArray = CommonUtility::getCategoryIdFromString($subCategoryName , true); // true for get multiple
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                   
                   // print_r($filterArray);
                }
                if( $quickFilter == Globals::FLD_NAME_PREVIOUSLY_WORKED )
                {
                    try
                    {
                        $filterArray = GetRequest::taskerPreviouslyWorkedTasksPosters( Yii::app()->user->id );
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                }
                if( $quickFilter == Globals::FLD_NAME_TASKER_IN_RANGE  ) 
                {
                    //$logedInUser = $this->loadModel(Yii::app()->user->id);
                   $logedInUser = User::model()->findByPk(Yii::app()->user->id);
                    $userLat = $logedInUser->{Globals::FLD_NAME_LOCATION_LATITUDE};
                    $userLng = $logedInUser->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                    try
                    {
                        $filterArray =  CommonUtility::geologicalPlaces( $userLat , $userLng , Globals::DEFAULT_VAL_TASK_FILTER_NEARBY_RANGE );
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                    //  print_r($filterArray);
                }
                if( $quickFilter == Globals::FLD_NAME_RANK ) 
                {
                   // $filterArray = GetRequest::highlyRatedPosters();
                }
                if( $quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE ) 
                {
                    try
                    {
                        $filterArray = GetRequest::getPotentialTaskOfUser();
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                }
                if( isset( $skills ) && count( $skills ) > 0 && $skills[0] != ''  )
                {
                    try
                    {
                        $filterArray = GetRequest::getTaskBySkills($skills);
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                }
                $startDateArray = array();
                $endDateArray = array();
                $date5toold = "";
                $fielterFiend = "";
                $dateAddOrRemover = "";
                if(isset($duration) && $duration !="")
                {
                    $dateAddOrRemover = "-";
                    $valueArray = GetRequest::getStartAndEndDateForSearch($duration,$dateAddOrRemover);  
                    $startDateArray = $valueArray[1];
                    $endDateArray = $valueArray[2];
                    $date5toold = $valueArray[3];
                    $fielterFiend = "created_at";
                }                
                if(isset($ending) && $ending !="")
                {
                    $dateAddOrRemover = "+";
                    $valueArray = GetRequest::getStartAndEndDateForSearch($ending,$dateAddOrRemover ,'too');  
                    $startDateArray = $valueArray[1];
                    $endDateArray = $valueArray[2];
                    $date5toold = $valueArray[3];
                    $fielterFiend = "end_date";
                }   
                $startLimit = array();
                $endLimit = array();
                if(isset($proposals) && $proposals !="")
                {
                    $getProposal = GetRequest::getProposal($proposals);
                    $startLimit = $getProposal[1];
                    $endLimit = $getProposal[2];
                }  
                
                if(isset($relationships) && $relationships !="")
                {                    
                    $array = explode('-', $relationships);  
                    if (!in_array("all", $array))
                    {
                        if (in_array("work_with_before", $array))
                        {                        
                            try
                            {
                                $filterArray = GetRequest::taskerPreviouslyWorkedTasksPosters( Yii::app()->user->id );
                                $quickFilter = Globals::FLD_NAME_PREVIOUSLY_WORKED;
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                            }
                        }  
                    }
                }
                
                $taskList = $model->getTaskList( 
                                                $quickFilter  ,
                                                $minPrice ,
                                                $maxPrice ,
                                                $minDate , 
                                                $maxDate , 
                                                $rating ,
                                                $taskKind ,
                                                $taskTitle , 
                                                $startDate , 
                                                $filterArray , 
                                                $locations , 
                                                $category_id , 
                                                $skills ,
                                                $sort,
                                                $startDateArray,
                                                $endDateArray,
                                                $date5toold,
                                                $fielterFiend,
                                                $startLimit,
                                                $endLimit,
                                                $userLicense,
                                                array( Globals::FLD_NAME_HIRED => $hired , Globals::FLD_NAME_JOBS => $jobs)
                                                );
                $prices = $model -> getMaxAndMinPriceOfTask();
                $maxPrice = intval($prices[Globals::FLD_NAME_MAX_PRICE]);
                $minPrice = intval($prices[Globals::FLD_NAME_MIN_PRICE]);
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
            }
            if(isset($_GET[Globals::FLD_NAME_BLOGS]))
                    $model->attributes = $_GET[Globals::FLD_NAME_BLOGS];
//            $data = $taskList->getData;
//            $data = CJSON::encode($data);            
             $this->layout = '//layouts/noheader'; 
            if (Yii::app()->request->isAjaxRequest) 
            {
               $this->renderPartial('tasklist',array('task'=>$taskList, 'maxPrice' => $maxPrice ,'minPrice' => $minPrice), false , false);
                Yii::app()->end();
            }
            else
            {
                    $this->render('tasklist',array('task'=>$taskList, 'maxPrice' => $maxPrice ,'minPrice' => $minPrice ,
//                        'data' => $data 
                        ));
            }
            CommonUtility::endProfiling();
    }
     public function actionMyTasks()
   {
        CommonUtility::startProfiling();
         $task = new Task();
        $filterArray = '';
        $category_id = '';
        @$subCategoryName = $_GET[Globals::FLD_NAME_SUBCATEGORYNAME];
//        @$state = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE];
        @$state = $_GET[Globals::FLD_NAME_TASK_STATE];
        @$taskKind = $_GET[Globals::FLD_NAME_TASKTYPE];
        @$categoryName = $_GET[Globals::FLD_NAME_CATEGORYNAME];
        @$skills = $_GET[Globals::FLD_NAME_SKILLS];
        @$rating = $_GET[Globals::FLD_NAME_RATING];
        @$minPrice = $_GET[Globals::FLD_NAME_MINPRICE];
        @$maxPrice = $_GET[Globals::FLD_NAME_MAXPRICE];
        @$maxDate = $_GET[Globals::FLD_NAME_MAXDATE];
        @$minDate = $_GET[Globals::FLD_NAME_MINDATE];
        @$sort = $_GET[Globals::FLD_NAME_SORT];
          @$taskTitle = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE];
        try
        {
            if( isset( $skills ) && count( $skills ) > 0 && $skills[0] != ''  )
            {
                $filterArray = GetRequest::getTaskBySkills($skills , Yii::app()->user->id );
               // print_r($filterArray);
            }
            if(isset($categoryName))
            {
                try
                {
                    $category_id = CommonUtility::getCategoryIdFromString($categoryName);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                }
                try
                {
                    $filterArray = CommonUtility::getChildCategorysIdsFromParent($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                }
                
            }
            if(isset($subCategoryName))
            {
                try
                {
                    $filterArray = CommonUtility::getCategoryIdFromString($subCategoryName , true); // true for get multiple
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                }

                // print_r($filterArray);
            }
            try
            {
                $taskList = $task->getMyTaskListAsTasker($state , $taskKind , $category_id , $filterArray , $skills , $rating ,$minPrice , $maxPrice , $minDate  , $maxDate , $sort , $taskTitle);
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
            }
            try
            {
                $prices = $task -> getMaxAndMinPriceOfTask();
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
            }       
            $maxPrice = intval($prices[Globals::FLD_NAME_MAX_PRICE]);
            $minPrice = intval($prices[Globals::FLD_NAME_MIN_PRICE]);
            
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
        }
        $this->layout = '//layouts/noheader';
        if (Yii::app()->request->isAjaxRequest) 
            {
            
               $this->renderPartial('mytasks',array('mytasklist'=>$taskList ,  'maxPrice' => $maxPrice ,'minPrice' => $minPrice), false , false);
                Yii::app()->end();
            }
            else
            {
                    $this->render('mytasks',array('mytasklist'=>$taskList ,  'maxPrice' => $maxPrice ,'minPrice' => $minPrice));
            }

        CommonUtility::endProfiling();
       
   }
//    public function actionSetPotential()
//   {
//        CommonUtility::startProfiling();
//        $taskId = $_POST[Globals::FLD_NAME_TASKID];
//        $userId = Yii::app()->user->id;
//        $bookmark = new UserBookmark();
//        $bookmark->{Globals::FLD_NAME_USER_ID} = $userId;
//        $bookmark->{Globals::FLD_NAME_BOOKMARK_TYPE} = Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK;
//        $bookmark->{Globals::FLD_NAME_BOOKMARK_SUBTYPE} = Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE;
//        $bookmark->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
//        $bookmark->{Globals::FLD_NAME_TASK_ID} = $taskId;
//        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//        try
//        {
//                if(!$bookmark->save())
//                {                            
//                        throw new Exception(Yii::t('tasker_createtask','unexpected_error'));
//                }
//            $data = $this->renderPartial('_unsetpotential',array(  'taskId'=>$taskId),true,true);
//           
//            echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
//               
//        }
//        catch(Exception $e)
//        {
//                echo $msg = $e->getMessage();
//                CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $taskId ,"User ID" => Yii::app()->user->id) );
//
//        }
//        
//        
//        
//        $otherInfo = array( 
//                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK_TASK,
//                        //  Globals::FLD_NAME_COMMENTS => '',
//                    );
////        Activity for user
//        try
//        {
//            CommonUtility::addUserActivity( $userId , Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK , $otherInfo );
//        }
//        catch(Exception $e)
//        {             
//                $msg = $e->getMessage();
//                if (CommonUtility::IsTraceEnabled())
//                {
//                        Yii::trace('Executing actionSetPotential() method','TaskerController');
//                }
//                Yii::log('Tasker.SetPotential: reason:-'.$msg,CLogger::LEVEL_ERROR ,'TaskerController');
//        } 
//        
//        
//        
//        $otherInfo = array( 
//                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK_TASK,
//                        //  Globals::FLD_NAME_COMMENTS => '',
//                );
//        try
//        {
//                CommonUtility::addTaskActivity($taskId , Yii::app()->user->id , Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK , $otherInfo );
//        }
//        catch(Exception $e)
//        {             
//                $msg = $e->getMessage();
//                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$taskId) );
//        }
//        CommonUtility::endProfiling();
//       
//   }
    
    
   public function actionSaveBookmark()
   {
        CommonUtility::startProfiling();
//        print_r($_POST);exit;
        $id = $_POST[Globals::FLD_NAME_ID];
        $type = $_POST[Globals::FLD_NAME_BOOKMARK_TYPE];
        $userId = Yii::app()->user->id;
        
        $bookmark = new UserBookmark();
        $bookmark->{Globals::FLD_NAME_USER_ID} = $userId;
        $bookmark->{Globals::FLD_NAME_BOOKMARK_TYPE} = $type;
        $bookmark->{Globals::FLD_NAME_BOOKMARK_SUBTYPE} = Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE;
        $bookmark->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
        if($type == Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK)
            $bookmark->{Globals::FLD_NAME_TASK_ID} = $id;
        if($type == Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER)
            $bookmark->{Globals::FLD_NAME_BOOKMARK_USER_ID} = $id;
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//        print_r($bookmark);exit;
        try
        {
            if(!$bookmark->save())
            {               
                throw new Exception(Yii::t('tasker_createtask','unexpected_error'));
            }
            $data = $this->renderPartial('_savebookmark',array('bookmark_type'=>$type,'id'=>$id),true,true);
        }
        catch(Exception $e)
        {
                echo $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "ID" => $id ,"User ID" => Yii::app()->user->id) );

        }
        
        
        
        $otherInfo = array( 
                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK_TASK,
                        //  Globals::FLD_NAME_COMMENTS => '',
                    );
//        Activity for user
        try
        {
            CommonUtility::addUserActivity( $userId , Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK , $otherInfo );
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                if (CommonUtility::IsTraceEnabled())
                {
                        Yii::trace('Executing actionSaveBookmark() method','TaskerController');
                }
                Yii::log('Tasker.SaveBookmark: reason:-'.$msg,CLogger::LEVEL_ERROR ,'TaskerController');
        } 
        
        
        
        $otherInfo = array( 
                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK_TASK,
                        //  Globals::FLD_NAME_COMMENTS => '',
                );
        try
        {
                CommonUtility::addTaskActivity($id , Yii::app()->user->id , Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK , $otherInfo );
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"D" =>$id) );
        }
        echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
        CommonUtility::endProfiling();
       
   }
   
   public function actionSetPotential()
   {
        CommonUtility::startProfiling();
//        print_r($_POST);exit;
        $id = $_POST[Globals::FLD_NAME_ID];
        $type = $_POST[Globals::FLD_NAME_BOOKMARK_TYPE];
        @$saveTitle = $_POST['saveText'];
        @$removeTitle = $_POST['removeText'];
        @$saveClass = $_POST['saveClass'];
        @$removeClass = $_POST['removeClass'];
        $options = array(
                'saveText' => $saveTitle,
                'removeText' => $removeTitle,
                'saveClass' => $saveClass,
                'removeClass' => $removeClass
            );
        $userId = Yii::app()->user->id;
        
        $bookmark = new UserBookmark();
        $bookmark->{Globals::FLD_NAME_USER_ID} = $userId;
        $bookmark->{Globals::FLD_NAME_BOOKMARK_TYPE} = $type;
        $bookmark->{Globals::FLD_NAME_BOOKMARK_SUBTYPE} = Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE;
        $bookmark->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
        if($type == Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK)
            $bookmark->{Globals::FLD_NAME_TASK_ID} = $id;
        if($type == Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER)
            $bookmark->{Globals::FLD_NAME_BOOKMARK_USER_ID} = $id;
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//        print_r($bookmark);exit;
        try
        {
            if(!$bookmark->save())
            {               
                throw new Exception(Yii::t('tasker_createtask','unexpected_error'));
            }
            
            $data = $this->renderPartial('_unsetpotential',array('bookmark_type'=>$type,'id'=>$id, 'options' => $options),true,true);
        }
        catch(Exception $e)
        {
                echo $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "ID" => $id ,"User ID" => Yii::app()->user->id) );

        }
        
        
        
        $otherInfo = array( 
                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK_TASK,
                        //  Globals::FLD_NAME_COMMENTS => '',
                    );
//        Activity for user
        try
        {
            CommonUtility::addUserActivity( $userId , Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK , $otherInfo );
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                if (CommonUtility::IsTraceEnabled())
                {
                        Yii::trace('Executing actionSetPotential() method','TaskerController');
                }
                Yii::log('Tasker.SetPotential: reason:-'.$msg,CLogger::LEVEL_ERROR ,'TaskerController');
        } 
        
        
        
        $otherInfo = array( 
                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK_TASK,
                        //  Globals::FLD_NAME_COMMENTS => '',
                );
        try
        {
                CommonUtility::addTaskActivity($id , Yii::app()->user->id , Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK , $otherInfo );
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"D" =>$id) );
        }
        echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
        CommonUtility::endProfiling();
       
   }
//   public function actionUnsetPotential()
//   {
//        CommonUtility::startProfiling();
//        $taskId = $_POST[Globals::FLD_NAME_TASKID];
//        $userId = Yii::app()->user->id;
//        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//        try
//        {
//            UserBookmark::model()->deleteAllByAttributes(array(Globals::FLD_NAME_TASK_ID => $taskId, Globals::FLD_NAME_USER_ID =>$userId , Globals::FLD_NAME_BOOKMARK_TYPE => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK , Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE));
//            $data = $this->renderPartial('_setpotential',array(  'taskId'=>$taskId),true,true);
//          
//            echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
//        }
//        catch(Exception $e)
//        {
//                echo $msg = $e->getMessage();
//                CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $taskId ,"User ID" => Yii::app()->user->id) );
//
//        }
//        
//        CommonUtility::endProfiling();
//       
//   }
   
   public function actionUnsetPotential()
   {
        CommonUtility::startProfiling();
        
        $id = $_POST[Globals::FLD_NAME_ID];
        $type = $_POST[Globals::FLD_NAME_BOOKMARK_TYPE];
        @$saveTitle = $_POST['saveText'];
        @$removeTitle = $_POST['removeText'];
        @$saveClass = $_POST['saveClass'];
        @$removeClass = $_POST['removeClass'];
        $options = array(
                'saveText' => $saveTitle,
                'removeText' => $removeTitle,
                'saveClass' => $saveClass,
                'removeClass' => $removeClass
            );
//        echo $type;exit;
        $userId = Yii::app()->user->id;
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        try
        {
            if($type == Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK)
                UserBookmark::model()->deleteAllByAttributes(array(Globals::FLD_NAME_TASK_ID => $id, Globals::FLD_NAME_USER_ID =>$userId , Globals::FLD_NAME_BOOKMARK_TYPE => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK , Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE));
            else
                UserBookmark::model()->deleteAllByAttributes(array(Globals::FLD_NAME_BOOKMARK_USER_ID => $id, Globals::FLD_NAME_USER_ID =>$userId , Globals::FLD_NAME_BOOKMARK_TYPE => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER , Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE));
            $data = $this->renderPartial('_setpotential',array('bookmark_type'=>$type,'id'=>$id , 'options' => $options),true,true);
          
            echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
        }
        catch(Exception $e)
        {
                echo $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "ID" => $id ,"User ID" => Yii::app()->user->id) );

        }
        
        CommonUtility::endProfiling();
       
   }
   
   public function actionSetPotentialSave()
   {
        CommonUtility::startProfiling();
//        print_r($_POST);exit;
        $savebutton = $_POST['savebutton'];
        $id = $_POST[Globals::FLD_NAME_ID];
        $type = $_POST[Globals::FLD_NAME_BOOKMARK_TYPE];
        $userId = Yii::app()->user->id;
        
        $bookmark = new UserBookmark();
        $bookmark->{Globals::FLD_NAME_USER_ID} = $userId;
        $bookmark->{Globals::FLD_NAME_BOOKMARK_TYPE} = $type;
        $bookmark->{Globals::FLD_NAME_BOOKMARK_SUBTYPE} = Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE;
        $bookmark->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
        if($type == Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK)
            $bookmark->{Globals::FLD_NAME_TASK_ID} = $id;
        if($type == Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER)
            $bookmark->{Globals::FLD_NAME_BOOKMARK_USER_ID} = $id;
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//        print_r($bookmark);exit;
        try
        {
            if(!$bookmark->save())
            {               
                throw new Exception(Yii::t('tasker_createtask','unexpected_error'));
            }
            $data = $this->renderPartial('_unsetpotential',array('bookmark_type'=>$type,'id'=>$id,'savebutton'=>$savebutton),true,true);
        }
        catch(Exception $e)
        {
                echo $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "ID" => $id ,"User ID" => Yii::app()->user->id) );

        }
        
        
        
        $otherInfo = array( 
                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK_TASK,
                        //  Globals::FLD_NAME_COMMENTS => '',
                    );
//        Activity for user
        try
        {
            CommonUtility::addUserActivity( $userId , Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK , $otherInfo );
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                if (CommonUtility::IsTraceEnabled())
                {
                        Yii::trace('Executing actionSetPotential() method','TaskerController');
                }
                Yii::log('Tasker.SetPotential: reason:-'.$msg,CLogger::LEVEL_ERROR ,'TaskerController');
        } 
        
        
        
        $otherInfo = array( 
                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK_TASK,
                        //  Globals::FLD_NAME_COMMENTS => '',
                );
        try
        {
                CommonUtility::addTaskActivity($id , Yii::app()->user->id , Globals::USER_ACTIVITY_SUBTYPE_BOOKMARK , $otherInfo );
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"D" =>$id) );
        }
        echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
        CommonUtility::endProfiling();
       
   }
   
   public function actionUnsetPotentialSave()
   {
        CommonUtility::startProfiling();
        $savebutton = $_POST['savebutton'];
        $id = $_POST[Globals::FLD_NAME_ID];
        $type = $_POST[Globals::FLD_NAME_BOOKMARK_TYPE];
//        echo $type;exit;
        $userId = Yii::app()->user->id;
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        try
        {
            if($type == Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK)
                UserBookmark::model()->deleteAllByAttributes(array(Globals::FLD_NAME_TASK_ID => $id, Globals::FLD_NAME_USER_ID =>$userId , Globals::FLD_NAME_BOOKMARK_TYPE => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK , Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE));
            else
                UserBookmark::model()->deleteAllByAttributes(array(Globals::FLD_NAME_BOOKMARK_USER_ID => $id, Globals::FLD_NAME_USER_ID =>$userId , Globals::FLD_NAME_BOOKMARK_TYPE => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER , Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE));
            $data = $this->renderPartial('_setpotential',array('bookmark_type'=>$type,'id'=>$id,'savebutton'=>$savebutton),true,true);
          
            echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
        }
        catch(Exception $e)
        {
                echo $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "ID" => $id ,"User ID" => Yii::app()->user->id) );

        }
        
        CommonUtility::endProfiling();
       
   }
   
   public function actionMarkRead()
   {
        CommonUtility::startProfiling();
        $taskId = $_POST[Globals::FLD_NAME_TASKID];
        $userId = Yii::app()->user->id;
        $bookmark = new UserBookmark();
        $bookmark->{Globals::FLD_NAME_USER_ID} = $userId;
        $bookmark->{Globals::FLD_NAME_BOOKMARK_TYPE} = Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK;
        $bookmark->{Globals::FLD_NAME_BOOKMARK_SUBTYPE} = Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_MARK_READ;
        $bookmark->{Globals::FLD_NAME_TASK_ID} = $taskId;
        $bookmark->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        try
        {
                if(!$bookmark->save())
                {                            
                        throw new Exception(Yii::t('tasker_createtask','unexpected_error'));
                }
            $data = $this->renderPartial('_markunread',array(  'taskId'=>$taskId),true,true);
           
            echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
               
        }
        catch(Exception $e)
        {
                echo $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $taskId ,"User ID" => Yii::app()->user->id) );

        }
        CommonUtility::endProfiling();
   }
    public function actionMarkUnread()
   {
        CommonUtility::startProfiling();
        $taskId = $_POST[Globals::FLD_NAME_TASKID];
        $userId = Yii::app()->user->id;
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        try
        {
            UserBookmark::model()->deleteAllByAttributes(array(Globals::FLD_NAME_TASK_ID => $taskId, Globals::FLD_NAME_USER_ID =>$userId , Globals::FLD_NAME_BOOKMARK_TYPE => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK , Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_MARK_READ));
            $data = $this->renderPartial('_markread',array(  'taskId'=>$taskId),true,true);
          
            echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
        }
        catch(Exception $e)
        {
                echo $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $taskId ,"User ID" => Yii::app()->user->id) );

        }
        
        CommonUtility::endProfiling();
       
   }
   public function actionGetCategories()
   {
        CommonUtility::startProfiling();
        $taskType = $_POST[Globals::FLD_NAME_TASKTYPE];
         $maxPrice = $_POST[Globals::FLD_NAME_MAX_PRICE];
          $minPrice = $_POST[Globals::FLD_NAME_MIN_PRICE];
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        try
        {
            $this->renderPartial('_getfilters',array(  'taskType'=>$taskType , 'maxPrice' => $maxPrice ,'minPrice' => $minPrice),false,true);
//            echo  $error = CJSON::encode(array('status'=>'success','html'=>$data));
        }
        catch(Exception $e)
        {
            echo $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array("User ID" => Yii::app()->user->id) );

        }
        
        CommonUtility::endProfiling();
       
   }
   public function actiongetsubcategories()
   {
        CommonUtility::startProfiling();
        $category_id = $_POST[Globals::FLD_NAME_CATID];
       
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        try
        {
            $categoryList = Category::getChildCategoryByID($category_id);
            $html = $this->renderPartial('_getsubcategoriesfilters',array('categoryList' => $categoryList , 'parentCategory' => $category_id ),true);
            echo  $error = CJSON::encode(array('status'=>'success','html'=>$html));
        }
        catch(Exception $e)
        {
            echo $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array("User ID" => Yii::app()->user->id) );

        }
        
        CommonUtility::endProfiling();
       
   }
   
   public function actionSaveFilterForm()
   {
        CommonUtility::startProfiling();
        $filter_type = $_POST[Globals::FLD_NAME_FILTER_TYPE];
        $userAtrib = new UserAttrib();
        $userAtrib->scenario = 'savefilter';
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
       // Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        $this->renderPartial('_savefilter',array( 'userAtrib'=>$userAtrib , 'filter_type'=>$filter_type ),false,true);
        CommonUtility::endProfiling();
       
   }
//   public function actionsavefiltertaskproposalform()
//   {
//        CommonUtility::startProfiling();
//        $userAtrib = new UserAttrib();
//        $userAtrib->scenario = 'savefilter';
//        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//       // Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
//        $this->renderPartial('_savefilter',array( 'userAtrib'=>$userAtrib ),false,true);
//        CommonUtility::endProfiling();
//       
//   }
//   public function actionsavefiltertaskproposal()
//   {
//        CommonUtility::startProfiling();
//        $userAtrib = new UserAttrib();
//        $userAtrib->scenario = 'savefilter';
//        if(isset($_POST[Globals::FLD_NAME_USER_ATTRIB]))
//        {
//            if(Yii::app()->request->isAjaxRequest)
//            {
//                $error =  CActiveForm::validate(array($userAtrib));
//                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
//                {
//                        CommonUtility::setErrorLog($userAtrib->getErrors(),get_class($userAtrib));
//                        echo $error;
//                        Yii::app()->end();
//                }
//            }
//        }
//        try
//        {
//            $userAtrib->{Globals::FLD_NAME_USER_ID} = Yii::app()->user->id;
//            $userAtrib->{Globals::FLD_NAME_ATTRIB_TYPE} = Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS;
//            $userAtrib->{Globals::FLD_NAME_ATTRIB_DESC} = $_POST[Globals::FLD_NAME_USER_ATTRIB][Globals::FLD_NAME_ATTRIB_DESC];
//            $userAtrib->{Globals::FLD_NAME_VAL_STR} = $_SERVER['HTTP_REFERER'];
//            if(!$userAtrib->save())
//            {                            
//                throw new Exception("Unexpected error !!! save filter in task search..");
//            }
//            $insertedId = $userAtrib->getPrimaryKey();
//            echo  $error = CJSON::encode(array(
//                    'status'=>'success',
//                ));
//        }
//        catch(Exception $e)
//        {
//                $msg = $e->getMessage();
//                CommonUtility::catchErrorMsg( $msg , array( "UserAttrib ID" => $insertedId ,"User ID" => Yii::app()->user->id) );
//
//        }
//        CommonUtility::endProfiling();
//       
//   }
   public function actionSaveFilter()
   {
        CommonUtility::startProfiling();
        $userAtrib = new UserAttrib();
        $userAtrib->scenario = 'savefilter';
        if(isset($_POST[Globals::FLD_NAME_USER_ATTRIB]))
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                $error =  CActiveForm::validate(array($userAtrib));
                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                {
                        CommonUtility::setErrorLog($userAtrib->getErrors(),get_class($userAtrib));
                        echo $error;
                        Yii::app()->end();
                }
            }
        }
        try
        {
            $userAtrib->{Globals::FLD_NAME_USER_ID} = Yii::app()->user->id;
            $userAtrib->{Globals::FLD_NAME_ATTRIB_TYPE} = $_POST[Globals::FLD_NAME_FILTER_TYPE];
            $userAtrib->{Globals::FLD_NAME_ATTRIB_DESC} = $_POST[Globals::FLD_NAME_USER_ATTRIB][Globals::FLD_NAME_ATTRIB_DESC];
            $userAtrib->{Globals::FLD_NAME_VAL_STR} = $_SERVER['HTTP_REFERER'];
            if(!$userAtrib->save())
            {                            
                throw new Exception("Unexpected error !!! save filter in task search..");
            }
            $insertedId = $userAtrib->getPrimaryKey();
            echo  $error = CJSON::encode(array(
                    'status'=>'success',
                ));
        }
        catch(Exception $e)
        {
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "UserAttrib ID" => $insertedId ,"User ID" => Yii::app()->user->id) );

        }
        CommonUtility::endProfiling();
       
   }
    public function actionLoadFiltersTask()
    {
            CommonUtility::startProfiling();
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  
            try
            {   
                $attribType = $_GET[Globals::FLD_NAME_ATTRIB_TYPE];
                $filters = UserAttrib::getUserSavedFilters($attribType);
            }
            catch(Exception $e)
            {
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg );
            }
            $this->renderPartial('loadfilterstask',array(
                'filters' => $filters
                                    ),false,true);
            CommonUtility::endProfiling();
    }
   
   public function actionfilterformmytasks()
   {
        CommonUtility::startProfiling();
        $userAtrib = new UserAttrib();
        $userAtrib->scenario = 'savefilter';
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
       // Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        //$action = "filterformmytasks";
        $this->renderPartial('_savefilter',array( 'userAtrib'=>$userAtrib ),false,true);
       CommonUtility::endProfiling();
       
   }
   public function actiongetactionfilter()
   {
        CommonUtility::startProfiling();
       
       
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            try
            {   
                @$filterType = $_POST[Globals::FLD_NAME_FILTER_TYPE];
              @$reset = $_POST['reset'];
            }
            catch(Exception $e)
            {
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg );
            }
           
            $html = $this->renderPartial('//tasker/_actionfilters',array('filter_type' => $filterType , 'reset' => $reset),true,true);
            echo  $error = CJSON::encode(array(
                    'status'=>'success',
                 'html'=>$html,
                ));
       CommonUtility::endProfiling();
       
   }
   public function actiongetcategoriesfilter()
   {
        CommonUtility::startProfiling();
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        $maxPrice = $_POST[Globals::FLD_NAME_MAX_PRICE];       
        $minPrice = $_POST[Globals::FLD_NAME_MIN_PRICE];
        $filter_type = $_POST[Globals::FLD_NAME_FILTER_TYPE];
        $taskName = '';
        
        $rating = '';
        $date = '';
        $html = $this->renderPartial('//tasker/_getfiltersaftercategory',array('maxPrice' => $maxPrice ,'minPrice' => $minPrice , 'filter_type' => $filter_type , 'rating' => $rating , 'date' => $date , 'taskName' => $taskName),true,true);
        echo  $error = CJSON::encode(array(
                    'status'=>'success',
                 'html'=>$html,
                ));
       CommonUtility::endProfiling();
       
   }
   
   public function actiondeletesearchfilter()
   {
        CommonUtility::startProfiling();
       $attribType = $_POST[Globals::FLD_NAME_ATTRIB_TYPE];
       $attribDesc = $_POST[Globals::FLD_NAME_ATTRIB_DESC];
       $userId = $_POST[Globals::FLD_NAME_USER_ID];
       try
        {   
               $deleteFilter = UserAttrib::model()->deleteAll(Globals::FLD_NAME_ATTRIB_TYPE.'=:type AND '.Globals::FLD_NAME_ATTRIB_DESC.'=:desc AND '.Globals::FLD_NAME_USER_ID.'=:id',
                array(':id' => $userId,':type' => $attribType,':desc' => $attribDesc));
                if(!$deleteFilter)
                {                            
                    throw new Exception("Unexpected error !!! in delete filter.");
                }
                echo  $error = CJSON::encode(array(
                    'status'=>'success',
                ));
        }
        catch(Exception $e)
        {
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg );
        }
      
       CommonUtility::endProfiling();
       
   }
    public function actionsavefiltermytasks()
    {
       CommonUtility::startProfiling();
        $userAtrib = new UserAttrib();
        $userAtrib->scenario = 'savefilter';
        if(isset($_POST[Globals::FLD_NAME_USER_ATTRIB]))
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                $error =  CActiveForm::validate(array($userAtrib));
                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                {
                        CommonUtility::setErrorLog($userAtrib->getErrors(),get_class($userAtrib));
                        echo $error;
                        Yii::app()->end();
                }
            }
        }
        try
        {
            $userAtrib->{Globals::FLD_NAME_USER_ID} = Yii::app()->user->id;
            $userAtrib->{Globals::FLD_NAME_ATTRIB_TYPE} = Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER_MYTASKS;
            $userAtrib->{Globals::FLD_NAME_ATTRIB_DESC} = $_POST[Globals::FLD_NAME_USER_ATTRIB][Globals::FLD_NAME_ATTRIB_DESC];
            $userAtrib->{Globals::FLD_NAME_VAL_STR} = $_SERVER['HTTP_REFERER'];
            if(!$userAtrib->save())
            {                            
                throw new Exception("Unexpected error !!! save filter in task search..");
            }
            $insertedId = $userAtrib->getPrimaryKey();
            echo  $error = CJSON::encode(array(
                    'status'=>'success',
                ));
        }
        catch(Exception $e)
        {
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "UserAttrib ID" => $insertedId ,"User ID" => Yii::app()->user->id) );

        }
        CommonUtility::endProfiling();
       
   }
   
    public function actionProjectCompletion()
    {
        CommonUtility::startProfiling();
        $model = User::model()->findByPk(Yii::app()->user->id);
        $task_id = $_GET[Globals::FLD_NAME_TASK_ID];
        $task = Task::model()->findByPk($task_id);
        $rating = array();
        $isTaskerSelected = TaskTasker::isTaskerSelectedForTask($task_id,Yii::app()->user->id);
        try
        {
            $rating = UserRating::getPosterRatingByTasker($task_id);
            //code
        }
        catch(Exception $e)
        {     
            //catch exception
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg );
        }
//        echo '<pre>';
//        print_r($rating);
//        exit;
        if(empty($rating) && $isTaskerSelected)
        {
            $this->layout = '//layouts/noheader';
            $this->render('projectcompletion' , array( 'task' => $task , 'model' => $model,'rating' => $rating));
        }
        else
        {
            $this->redirect(array('/index/dashboard'));
        }
        CommonUtility::endProfiling();
    }
    
     public function actionSavePosterRating()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('SavePosterRating','application.controller.PosterController');
        }
        if($_POST)
        {
//            echo '<pre>';
//            print_r($_POST);
//            exit;
            $tasker_average_rating =$_POST[Globals::FLD_NAME_PROJECT_COMPLATE_OVER_RT];
            $poster_id = $_POST[Globals::FLD_NAME_PROJECT_COMPLATE_POSTER_ID];
            $task_id = $_POST[Globals::FLD_NAME_TASK_ID];
             $taskerDetail = $this->loadModelUser(Yii::app()->user->id);
//            $taskTasker = TaskTasker::model()->findByAttributes(array('task_id' =>$task_id,'tasker_id' =>Yii::app()->user->id));
//            
//            echo '<pre>';
//            print_r($taskTasker);
//            exit;
            
            try
            {
                if($_POST[Globals::FLD_NAME_PROJECT_COMPLATE_RECEIPT_COUNT]>Globals::DEFAULT_VAL_0)
                {
                    for($i=0;$i<$_POST[Globals::FLD_NAME_PROJECT_COMPLATE_RECEIPT_COUNT];$i++)
                    {
                        $taskTasker= TaskTaskerReceipt::getTaskTaskerId($poster_id, $task_id);
                        $imageName = array_values($_POST[Globals::FLD_NAME_PROJECT_COMPLATE_IMAGE_NAME]);
                        
                        //image move 
                        
                        $fileWithFolder = $taskerDetail->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$imageName[$i];
                        
                        try
                        {
                                $moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$taskerDetail->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$imageName[$i]);
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Action name" =>'save user rating') );
                        }
                        
                        
                        //Crop here
                        try
                        {
                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Action name" =>'save user rating') );
                        }
                        try
                        {
                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Action name" =>'save user rating') );
                        }
                        try
                        {
                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Action name" =>'save user rating') );
                        }
                        try
                        {
                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Action name" =>'save user rating') );
                        }
                        
//                        $attachment = $taskerDetail->profile_folder_name.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$imageName[$i];
//                        $attachment = $imageName[$i];
                        $receiptAmount = array_values($_POST[Globals::FLD_NAME_RECEIPT_AMOUNT]);
                        $receipt_amount = $receiptAmount[$i];
                        $taskTaskerReceipt = new TaskTaskerReceipt();
//                        $taskTaskerReceipt->{Globals::FLD_NAME_TASK_TASKER_ID} = Yii::app()->user->id;
                        $taskTaskerReceipt->{Globals::FLD_NAME_TASK_TASKER_ID} = $taskTasker[Globals::FLD_NAME_TASK_TASKER_ID];
                        $taskTaskerReceipt->{Globals::FLD_NAME_TASKER_RECEIPT_ATTACHMENT} = $fileWithFolder;
                        $taskTaskerReceipt->{Globals::FLD_NAME_RECEIPT_AMOUNT} = $receipt_amount;
                        $taskTaskerReceipt->{Globals::FLD_NAME_CREATED_AT} = new CDbExpression('NOW()');
                        if(!$taskTaskerReceipt->save())
                        {
                            throw new Exception(Yii::t('poster_savevirtualtask','tasker receipt amount not update'));
                        }
                    }
                }                
                if($_POST[Globals::FLD_NAME_PROJECT_COMPLATE_EXPENSE_COUNT]>0)
                {
                    for($i=0;$i<$_POST[Globals::FLD_NAME_PROJECT_COMPLATE_EXPENSE_COUNT];$i++)
                    {
                        $taskTasker= CommonUtility::getTaskTaskerId($poster_id, $task_id);
                        $expenseAmount = array_values($_POST[Globals::FLD_NAME_PROJECT_COMPLATE_EXPENSE_AMOUNT]);
                        $expense_amount = $expenseAmount[$i];
                        $expenseLabel = array_values($_POST[Globals::FLD_NAME_PROJECT_COMPLATE_EXPENSE_LABEL]);
                        $expense_reason = $expenseLabel[$i];
                        $taskTaskerReceipt = new TaskTaskerReceipt();
//                        $taskTaskerReceipt->{Globals::FLD_NAME_TASK_TASKER_ID} = Yii::app()->user->id;
                        $taskTaskerReceipt->{Globals::FLD_NAME_TASK_TASKER_ID} = $taskTasker[Globals::FLD_NAME_TASK_TASKER_ID];
                        $taskTaskerReceipt->{Globals::FLD_NAME_RECEIPT_AMOUNT} = $expense_amount;
                        $taskTaskerReceipt->{Globals::FLD_NAME_RECEIPT_REASON} = $expense_reason;
                        $taskTaskerReceipt->{Globals::FLD_NAME_CREATED_AT} = new CDbExpression('NOW()');
                        if(!$taskTaskerReceipt->save())
                        {
                            throw new Exception(Yii::t('poster_savevirtualtask','tasker receipt amount not update'));
                        }
                    }
                }
                    
                $userRating = new UserRating();           
                $userRating->{Globals::FLD_NAME_TASK_ID} = $task_id;
                $userRating->{Globals::FLD_NAME_RATING_FOR} = Globals::FLD_NAME_POSTER_RATING_ALFABET;
                $userRating->{Globals::FLD_NAME_BY_USER_ID} = Yii::app()->user->id;
                $userRating->{Globals::FLD_NAME_FOR_USER_ID} = $poster_id;
                $userRating->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                if( !$userRating->save())
                {   
                    throw new Exception(Yii::t('poster_savevirtualtask','user rating not save'));
                }
                $insertedId = $userRating->getPrimaryKey();

                foreach($_POST[Globals::FLD_NAME_RATING] as $id=>$rating)
                {
                    if($rating!=0)
                    {
                        $userRatingDetail = new UserRatingDetail();
                        $userRatingDetail->{Globals::FLD_NAME_USER_RATING_TRNO} = $insertedId;
                        $userRatingDetail->{Globals::FLD_NAME_RATING_ID} = $id;
                        $userRatingDetail->{Globals::FLD_NAME_RATING} = $rating;
                        if(!$userRatingDetail->save())
                        {   
                            throw new Exception(Yii::t('poster_savevirtualtask','user rating detail not save'));
                        }
                    }
                }
                $user = $this->loadModelUser($poster_id);
                $min_max_rating = CommonUtility::getMinAndMaxRating($poster_id,$tasker_average_rating);
                $user->{Globals::FLD_NAME_TASKER_RATING_MIN_AS_POSTER} = $min_max_rating[Globals::FLD_NAME_PROJECT_COMPLATE_MIN_RATING];
                $user->{Globals::FLD_NAME_TASKER_RATING_MAX_AS_POSTER} = $min_max_rating[Globals::FLD_NAME_PROJECT_COMPLATE_MAX_RATING];
                $user->{Globals::FLD_NAME_TASKER_RATING_TOTAL_AS_POSTER} += $tasker_average_rating;
                $user->{Globals::FLD_NAME_TASKER_RATING_COUNT_AS_POSTER} += 1;
                $avg_rating = $user->{Globals::FLD_NAME_TASKER_RATING_TOTAL_AS_POSTER}/$user->{Globals::FLD_NAME_TASKER_RATING_COUNT_AS_POSTER};
                $user->{Globals::FLD_NAME_TASKER_RATING_AVG_AS_POSTER} = $avg_rating;
                if( !$user->update())
                {   
                    throw new Exception(Yii::t('poster_saveposterrating','user rating as poster not save'));
                }
                echo CJSON::encode(array(
                    'status'=>'success'
                ));
            }
            catch(Exception $e)
            {
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );  
            }       
        }
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('SavePosterRating','application.controller.PosterController');
        }
    }
    
    public function actionDisplayPosterRating()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('DisplayPosterRating','application.controller.PosterController');
        }
        if($_POST)
        {
            $id = $_POST['id'];
            $rating = $_POST['rating'];
            try
            {
                $posterRating = UtilityHtml::getDisplayRating($rating);
//                $posterRating = '<div id="abcd">gfhjgfhjdgsfsfgsdg<div>';
            }
            catch(Exception $e)
            {
                            echo $e->getMessage();
                            if (CommonUtility::IsTraceEnabled())
                            {
                                    Yii::trace('Executing actionDisplayPosterRating() method','PosterController');
                            }
                            Yii::log('Poster.DisplayPosterRating: reason:-'.$msg,CLogger::LEVEL_ERROR ,'PosterController');
            }      
            if($posterRating)
            {
                
                echo CJSON::encode(array(
                    'status'=>'success',
                    'html'=>$posterRating
                ));
            }
        }
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('DisplayPosterRating','application.controller.PosterController');
        }
    }
    
     public function actionPaymentForDoer()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('PaymentForDoer','application.controller.PosterController');
        }
        if($_POST)
        {
//            echo '<pre>';
//            print_r($_POST);
//            exit;
            $project_price = $_POST['project_price'];
            $service_fee = $_POST['service_fee'];
            $receipt_amount = $_POST['receipt_amount'];
            $bonus = $_POST['bonus'];
            $totalPaymentAmount = CommonUtility::totalPaymentAmount(array('task_price'=>$project_price,'service_fee'=>$service_fee,'receipt_amount'=>$receipt_amount,'bonus' => $bonus));
//            echo '<pre>';
//            print_r($totalPaymentAmount);
            if($totalPaymentAmount)
            {
                echo CJSON::encode(array(
                    'status'=>'success',
                    'totalPaymentAmount' => $totalPaymentAmount
                ));
            }
            else
            {
                echo CJSON::encode(array(
                    'status'=>'error'
                ));
            }
        }
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('PaymentForDoer','application.controller.PosterController');
        }
        
    }
}