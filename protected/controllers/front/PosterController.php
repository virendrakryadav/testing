<?php
class PosterController extends Controller
{
    public function filters() 
    {
        return array(
            'accessControl', // perform access control for CRUD operationstail
        );
    }
    public function accessRules()
    { 
            return array(
                    array('allow', 
                        // allow all users to perform 'index' and 'view' actions
                            'actions'=>array('ajaxgetpreferredlocationlist','taskpreview','submitconfirmtask','setconfirmtaskpage'),
                            'users'=>array('*'),
                    ),
                    array('allow', // allow authenticated user to perform 'create' and 'update' actions
                            'actions'=>array('createtask','loadvirtualtask','loadinpersontask','loadinstanttask','getsubcategories','getsubcategoriespopup','selectcategory','loadtaskdetailfrom','loadtaskformdatabycategory',
                                'gettemplatedetail','getrecenttasktemplatedetail','updateproject','projectcompletion','inviteuserpopup','savevirtualtask','uploadtaskfiles','bidenddatedroopdown','sethiringoff',
                                'switchjobtype','switchjobtypepopup','modifytermsandpayment','uploadfileintaskdetail','deleteuploadedfile','bulkactionuploadedfile',
                                'gettaskerdetails','taskdetail','projectdetail','applyForTask','thankyouafterpostingproject','accepthiringoffer','rejecthiringoffer',
                                
                                'loadcategoryform','loadvirtualtaskpreview','loadcategoryformtoupdate','editvirtualtask','loadpreviuostask','loadtemplatecategory',
                                'saveinpersontask','loadinpersontaskpreview','editinpersontask','saveinstanttask',
                                'loadinstanttaskpreview','editinstanttask','publishtask','createtaskbackup',
                                'browsetemplatecategory','taskersetmap','saveproposal','confirmtask', 'viewprofile','loadproposalpreview','proposal',
                                'editproposal','publishproposal','proposalaccept','proposalreject','mytaskslist','ajaxMyTaskslist','viewtaskpopup','validateproposal','testpopover','savereview','reviewbox',
                                'viewallproposals','autoinvite','ajaxpopup','edittask','canceltask','mytasks','findtasker','filterformmytasks','savefiltermytasks',
                                'proposalshowinterest','gettaskerlistfilters','getproposalslistfilters' ,'canceltaskform','uploadreceiptfiles','invitedoer','projectcomplationbyposter','displayposterrating','uploadtaskerreceipt','deleteuploadedreceiptfile','paymentfordoer','cancelacceptedbydoer'),
                                'users'=>array('@'),
                    ),
                    array('deny',  // deny all users
                            'users'=>array('*'),
                    ),
            );
    }

    public function actions()
    {
            return array(	 );
    }	
    
    public function actionCreateTask()
    {	
            CommonUtility::startProfiling();
            $userLicenseType = Yii::app()->user->getState('user_type'); 
           
            if($userLicenseType == 't' || $userLicenseType == 'non')
                throw new CHttpException(ErrorCode::ERROR_CODE_IS_POSTER_LICENSE,Yii::t('poster_createtask','To create project you need poster license.'));
            
            $countryCode ='';
            $region_id ='';
            $users = '';
            $locationRange = array();
            $tasker = new User();
            $repeat = 0;
            $model = $this->loadModel(Yii::app()->user->id);
            if(isset($_GET[Globals::FLD_NAME_TASK_ID]))
            {
                $task_id = $_GET[Globals::FLD_NAME_TASK_ID];
                if(isset($_GET['repeat']))
                {
                    $repeat = $_GET['repeat'];
                }
                
                try
                {
                    $task = Task::model()->findByPk($task_id);
                }
                catch(Exception $e)
                {
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );  
                }
                
                try
                {
                    $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
                }
                catch(Exception $e)
                {
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );  
                }
                
                try
                {
                    $taskCategory = TaskCategory::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
                }
                catch(Exception $e)
                {
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );  
                }
                
                switch ($task->{Globals::FLD_NAME_TASK_KIND}) /// insert values according to task type
                {
                    case Globals::DEFAULT_VAL_I :

                        $task->scenario = Globals::INSTANT_TASK;
                        break;
                    
                    case Globals::DEFAULT_VAL_P :

                        $task->scenario = Globals::INPERSON_TASK;
                        break;

                    default:

                        $task->scenario = Globals::VIRTUAL_TASK;
                        break;
                }
                
                $category_id = $taskCategory->{Globals::FLD_NAME_CATEGORY_ID};
//                 $pagentCategory = Category::getParentCategoryChild($category_id);
//                 print_r($pagentCategory);
                try
                {
                $category = Category::getCategoryListByID($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                }
                
                try
                {
                        $skill = Skill::getSkillsOfCategory($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                }
                
                try
                {
                        $questions = CategoryQuestion::getQuestionsOfCategory($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                }
                
                try
                {
                    $subCategories =  Category::getChildCategoryByID($category[0]->{Globals::FLD_NAME_CATEGORY_PARENT_ID});
                    if(!$subCategories)
                    {
                        throw new Exception("no categories found");
                    }
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                }
           
                $editTaskPartials["categories_slider"]  = $this->renderPartial('partial/_categories_slider',array( 'subCategories' => $subCategories ,'category_id' => $category_id) , true , true);
                $editTaskPartials["category_id"] = $category_id;
                $editTaskPartials["parent_id"] = $category[0]->{Globals::FLD_NAME_CATEGORY_PARENT_ID};
                $editTaskPartials["category_name"] = CommonUtility::getCategoryName($category_id);
                $editTaskPartials["category_img"] = CommonUtility::getCategoryImageURI($category_id);
                try
                {
                    $taskType = $task->{Globals::FLD_NAME_TASK_KIND};
                    $taskList = Task::getUserTaskListByTypeandCategory( $taskType , $category_id );
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
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
                    //exit;
                    $countryCode = $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE};
                    $region_id = $model->{Globals::FLD_NAME_BILLADDR_REGION_ID};
                }
              try
                {

                    $usersData = $tasker->getUsers( '', '' , $countryCode , $region_id , $locationRange );
                    $users =  $usersData->getdata();
                    
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                
                $editTaskPartials["previusTask"] = $this->renderPartial('partial/_recent_task_templates',array('recentTasks'=>$taskList),true,false);
                $editTaskPartials["skills"] = $this->renderPartial('partial/_task_detail_form_skills',  array(  'skill'=>$skill,'task' => $task ),true,false);
                $editTaskPartials["template"] = $this->renderPartial('partial/_loadtemplatecategory',array('model'=> $category ),true,false);
                $editTaskPartials["questions"] = $this->renderPartial('partial/_task_detail_form_questions',  array( 'questions'=>$questions,'task' => $task  ),true,false);
                
                
            }
            else
            {
                $task = new Task();
                $task->scenario = Globals::VIRTUAL_TASK;
                $taskLocation = new TaskLocation();
                $editTaskPartials = '';
            }
            
            
           // Yii::app()->clientScript->scriptMap['bootstrap-switch.js'] = false;
           
            Yii::app()->clientScript->registerCoreScript('jquery');     
            Yii::app()->clientScript->registerCoreScript('jquery.ui'); 
            Yii::app()->clientScript->registerCoreScript('yiiactiveform');
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/fileuploader.js");
             $cs->registerScriptFile(Yii::app()->baseUrl."/js/chosen.jquery.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery.ui.timepicker.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery-ui-timepicker-addon.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/bootstrap-timepicker.min.js");
            
    
            //$cs->registerScriptFile(Yii::app()->baseUrl."/js/bootstrap-switch-custom.js");
       
          // 

            $filterArray = '';
            $order = '';

            // echo $_GET["taskType"];
            
            @$quickFilter = $_GET[Globals::FLD_NAME_QUICK_FILTER];
            @$taskTitle = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE];
            @$startDate = $_GET[Globals::FLD_NAME_CREATED_AT];
            @$minPrice = $_GET[Globals::FLD_NAME_MINPRICE];
            @$maxPrice = $_GET[Globals::FLD_NAME_MAXPRICE];
            @$maxDate = $_GET[Globals::FLD_NAME_MAXDATE];
            @$minDate = $_GET[Globals::FLD_NAME_MINDATE];
            @$rating = $_GET[Globals::FLD_NAME_RATING];
            @$skills = $_GET[Globals::FLD_NAME_MULTISKILLS];
            @$taskerName = $_GET[Globals::FLD_NAME_USER_NAME];
            @$taskKind = $_GET[Globals::FLD_NAME_TASKTYPE];
            @$locations = $_GET[Globals::FLD_NAME_LOCATIONS];
            @$active_within = $_GET[Globals::FLD_NAME_ACTIVE_WITHIN];
            @$completed_projects = $_GET[Globals::FLD_NAME_COMPLETED_PROJECTS];
            @$average_price = $_GET[Globals::FLD_NAME_AVERAGE_PRICE];
            
            if(!isset($quickFilter))
            {
                $quickFilter = Globals::FLD_NAME_ACCOUNT_TYPE;
            }
            
            try
            { 
               if($skills)
               {
                    try
                    {
                        $filterArray = GetRequest::getTaskerBySkills($skills);
                        $order = 'orderByIds';
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    } 
                }
                if( $quickFilter == Globals::FLD_NAME_PREVIOUSLY_WORKED )
                {
                    try
                    {
                        $filterArray = GetRequest::prevouslyHiredTaskerByPosterOnlyIds( Yii::app()->user->id );
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                }
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
                if( $quickFilter == Globals::FLD_NAME_SELECTION_TYPE ) 
                {
                    try
                    {
                        $filterArray = GetRequest::getInvitedTaskersByUser();
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                }
                $criteria = array( 
                                 Globals::FLD_NAME_QUICK_FILTER => $quickFilter , 
                                 Globals::FLD_NAME_USER_NAME => $taskerName,
                                 Globals::FLD_NAME_RATING => $rating,
                                 Globals::FLD_NAME_LOCATIONS => $locations,
                                 Globals::FLD_NAME_FILTER_ARRAY => $filterArray  ,
                                 'sort' => $order,
                                 'pageSize' => 6 ,
                                 Globals::FLD_NAME_ACTIVE_WITHIN => $active_within ,
                                 Globals::FLD_NAME_COMPLETED_PROJECTS =>$completed_projects ,
                                 Globals::FLD_NAME_AVERAGE_PRICE => $average_price ,
                    ); 
                 $taskerList = $tasker->getTaskerList($criteria); 
               
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
            }


            $this->layout = '//layouts/noheader';
            $this->render('createtask' , array( 'task' => $task , 'users' => $users, 'taskLocation' => $taskLocation , 'taskerList' => $taskerList  , 'model' => $model , 'editTaskPartials' => $editTaskPartials , 'repeat' => $repeat));
            CommonUtility::endProfiling();

    }
       /**
    * load data according to category in task form
    * @params no parameters
    * @return string demo action does not return anything
    * @var
    */
     public function actionLoadTaskFormDataByCategory()
    {
        CommonUtility::startProfiling();
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false; 
        Yii::app()->clientScript->scriptMap['chosen.jquery.js'] = false; 
        $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
        $taskType = $_POST[Globals::FLD_NAME_TASKTYPE];
        $task = new Task();
         
        $category = Category::getCategoryListByID($category_id);
        try
        {
            $skill = Skill::getSkillsOfCategory($category_id);
            
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
        }
        
        try
        {
            $questions = CategoryQuestion::getQuestionsOfCategory($category_id);
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
        }
        $return["status"] = 'success';
        $return["category_id"] = $category_id;
        $return["category_name"] = CommonUtility::getCategoryName($category_id);
        $return["category_img"] = CommonUtility::getCategoryImageURI($category_id);
        
        $return["default_min_price"] = $category[0]->{Globals::FLD_NAME_DEFAULT_MIN_PRICE};
        $return["default_max_price"] = $category[0]->{Globals::FLD_NAME_DEFAULT_MAX_PRICE};
        
       
        if($category[0]->{Globals::FLD_NAME_DEFAULT_ESTIMATED_HOURS} > Globals::DEFAULT_VAL_MIN_WORK_HRS)
        {
            $return["default_estimated_hours"] = $category[0]->{Globals::FLD_NAME_DEFAULT_ESTIMATED_HOURS};
        }
        else
        {
             $return["default_estimated_hours"] = Globals::DEFAULT_VAL_MIN_WORK_HRS;
        }
        try
        {
            switch ($taskType) 
            {
                case Globals::DEFAULT_VAL_INPERSON:
                $taskType = Globals::DEFAULT_VAL_TASK_KIND_INPERSON;
                break;

                case Globals::DEFAULT_VAL_INSTANT:
                $taskType = Globals::DEFAULT_VAL_TASK_KIND_INSTANT;
                break;

                default:
                $taskType = Globals::DEFAULT_VAL_TASK_KIND_VIRTUAL;
                break;
            }
            $taskList = Task::getUserTaskListByTypeandCategory( $taskType , $category_id );
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
        }
        $return["previusTask"] = $this->renderPartial('partial/_recent_task_templates',array('recentTasks'=>$taskList),true,true);
        $return["skills"] = $this->renderPartial('partial/_task_detail_form_skills',  array(  'skill'=>$skill,'task' => $task ),true,true);
        $return["template"] = $this->renderPartial('partial/_loadtemplatecategory',array('model'=> $category ),true,true);
        $return["questions"] = $this->renderPartial('partial/_task_detail_form_questions',  array( 'questions'=>$questions,'task' => $task  ),true,true);
        echo CJSON::encode($return);
//        $return["taskLocation"] = $this->renderPartial('partial/_task_detail_form_location',  array(   'taskLocation'=>$taskLocation, ),true,true);
//        $return["questions"] = $this->renderPartial('partial/_task_detail_form_questions',  array(   'questions'=>$questions, ),true,true);
        
        CommonUtility::endProfiling();
    }
    /**
    * get list of subcategories of parent category
    * @params category_id
    * @return array categories
    * @var
    */
     public function actionGetSubCategories()
    {
        CommonUtility::startProfiling();
        try
        {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false; 
            @$category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
            if($category_id != '')
            {
                $subCategories =  Category::getChildCategoryByID($category_id);
                if(!$subCategories)
                {
                    throw new Exception("no categories found");
                }
                $categoriesSlider = $this->renderPartial('partial/_categories_slider',array( 'subCategories' => $subCategories ,'category_id' => $category_id) , true , true);
                $return["status"] = 'success';
                $return["html"] = $categoriesSlider;
                $return["category_id"] = $category_id;

                        // var_dump($return);
                
                //code
            }
            else
            {
                $return["status"] = 'success';
                $return["html"] = '';
                $return["category_id"] = '';
            }
            echo CJSON::encode($return);
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
    * get list of subcategories of parent category
    * @params category_id
    * @return array categories for popup
    * @var
    */
     public function actionGetSubCategoriesPopup()
    {
        CommonUtility::startProfiling();
        try
        {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false; 
            Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false; 
            Yii::app()->clientScript->scriptMap['jquery.yiilistview.js'] = false; 
          if(isset($_GET[Globals::FLD_NAME_CATEGORY_ID]))
          {
                @$category_id = $_GET[Globals::FLD_NAME_CATEGORY_ID];
                Yii::app()->user->setState('category_id_search',$category_id);
          }
          else
          {
                $category_id =  Yii::app()->user->getState('category_id_search');
                Yii::app()->user->getState('category_id_search');
          }
           
           
           @$category_name= $_GET[Globals::FLD_NAME_CATEGORY_NAME];
           // $subCategories =  Category::getChildCategoryByID($category_id);
            $category = new Category();
            $filterArray = array(
                Globals::FLD_NAME_CATEGORY_ID => $category_id,
                Globals::FLD_NAME_CATEGORY_NAME => $category_name
            );
            $subCategories = $category->getChildCategoryByIDDataprovider($filterArray);
            if(!$subCategories)
            {
                throw new Exception("no categories found");
            }
            $categoriesSlider = $this->renderPartial('partial/_categories_popup',array( 'subCategories' => $subCategories ,'category_id' => $category_id) , false , true);
//            $return["status"] = 'success';
//            $return["html"] = $categoriesSlider;
//                    // var_dump($return);
//            echo CJSON::encode($return);
            //code
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
    * select category for task creation
    * @params category_id
    * @return array selected category view
    * @var
    */
     public function actionSelectCategory()
    {
        CommonUtility::startProfiling();
        try
        {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false; 
            $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
           
            $selectedCategory = $this->renderPartial('partial/_selected_category',array('category_id' => $category_id) , true , true);
            $return["status"] = 'success';
            $return["html"] = $selectedCategory;
                    // var_dump($return);
            echo CJSON::encode($return);
            //code
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
    * load task type virtual and virtual
    * @params no
    * @return view for virtual categories
    * @var
    */
    public function actionLoadVirtualTask()
    {	      
        CommonUtility::startProfiling();

        if(isset($_POST[Globals::FLD_NAME_TASKID]))
        {
                $task = Task::model()->findByPk($_POST[Globals::FLD_NAME_TASKID]);
                $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
        }
        else 
        {
                $task = new Task();
                $category_id = '';
        }
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
        //                   / $taskList = $this->actionLoadPreviuosTask("v");

        try
        {
                $taskList = Task::getUserTaskListByTypeandCategory(Globals::DEFAULT_VAL_V);			
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );

        }	
        //  $previousTask = $this->renderPartial('_loadpreviuostask',array('model'=>$taskList , Globals::FLD_NAME_FORM_TYPE_SML=>Globals::DEFAULT_VAL_V),true,true);
        $virtualTaskCategory = $this->renderPartial('partial/_virtualtask',array( 'task'=>$task,Globals::FLD_NAME_CATEGORY_ID=>$category_id),true,true);
        //   $return["previusTask"] = $previousTask;
        $return["virtual"] = $virtualTaskCategory;
        // var_dump($return);
        echo CJSON::encode($return);
                   
                    
        CommonUtility::endProfiling();
    }
    /**
    * load task type virtual and virtual
    * @params no
    * @return view for virtual categories
    * @var
    */
    public function actionLoadTaskDetailFrom()
    {	
                CommonUtility::startProfiling();
                $task = new Task();
                $countryCode ='';
                $region_id ='';
                $locationRange = array();
                //$category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
                $type = $_POST[Globals::FLD_NAME_FORM_TYPE];    
                Yii::import('ext.bootstrap.widgets.TbActiveForm'); 
//                $form = new  TbActiveForm();
                $form = $_POST[Globals::FLD_NAME_FORM];    
                $form = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $form);
                  //  var_dump(unserialize($data));
                 $form = unserialize($form);
               // $category = Category::getCategoryListByID($category_id);
// print_r($category);
//                exit();
//                $taskSkill = new TaskSkill();
//                $taskQuestion = new TaskQuestion();
                 $taskLocation = new TaskLocation();
                 $tasker = new User();
//                try
//                {
//                    $skill = Skill::getSkillsOfCategory($category_id);
//                }
//                catch(Exception $e)
//                {             
//                        $msg = $e->getMessage();
//                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
//                }
//                try
//                {
//                    $questions = CategoryQuestion::getQuestionsOfCategory($category_id);
//                }
//                catch(Exception $e)
//                {             
//                        $msg = $e->getMessage();
//                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
//                }
                $model = $this->loadModel(Yii::app()->user->id);
               
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
                //print_r($skill);
                //exit();
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
                Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
                Yii::app()->clientScript->scriptMap['chosen.jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.ui.timepicker.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui-timepicker-addon.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui-i18n.min.js'] = false;
                Yii::app()->clientScript->scriptMap['bootstrap-timepicker.min.js'] = false;
               // Yii::app()->clientScript->scriptMap['bootstrap-switch.js'] = false;
                Yii::app()->clientScript->scriptMap['bootstrap-datepicker.js'] = false;

                
              
               // $return["template"] = $this->renderPartial('_loadtemplatecategory',array('model'=> $category ),true,true);
            
                $return["status"] = 'success';
                try
                {
                    $usersData = $tasker->getUsers( '', '' , $countryCode , $region_id , $locationRange );
                    $users =  $usersData->getdata();
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                
               if($type == Globals::DEFAULT_VAL_INSTANT)
               {
//                    try
//                    {
//                        $taskList = Task::getUserTaskListByTypeandCategory( 'i' , $category_id );
//                    }
//                    catch(Exception $e)
//                    {             
//                            $msg = $e->getMessage();
//                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
//                    }
//                    $return["previusTask"] = $this->renderPartial('_loadpreviuostask',array('model'=>$taskList , Globals::FLD_NAME_FORM_TYPE_SML=> 'i' ),true,true);
                    $task->scenario = Globals::INSTANT_TASK;
                    
                    $return["form"] = $this->renderPartial('partial/_instant_task_detail_from', 
                            array(  'task' =>$task,
                                    Globals::FLD_NAME_MODEL =>$model,
                                    'users' =>$users,
                                    'taskLocation'=>$taskLocation,
                                    Globals::FLD_NAME_FORM=>$form,
                                   // 'questions'=>$questions,
                                    
                                ),true,true);
               }
               elseif($type==Globals::DEFAULT_VAL_INPERSON)
               {
//                    try
//                    {
//                        $viewallproposals = Task::getUserTaskListByTypeandCategory( Globals::DEFAULT_VAL_P , $category_id );
//                    }
//                    catch(Exception $e)
//                    {             
//                        $msg = $e->getMessage();
//                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
//                    }
//                    $return["previusTask"] = $this->renderPartial('_loadpreviuostask',array('model'=>$taskList , Globals::FLD_NAME_FORM_TYPE_SML=> 'p' ),true,true);
                    $task->scenario = Globals::INPERSON_TASK;
                    $return["form"] = $this->renderPartial('partial/_inperson_task_detail_from', 
                            array(  
                                    'task'=>$task,
//                                    'model'=>$model,
//                                    'form'=>$form,
//                                    'category'=>$category,
                                    'taskLocation'=>$taskLocation,
//                                    'skill'=>$skill,
//                                    'questions'=>$questions,
//                                    Globals::FLD_NAME_TASK =>$task,
                                    Globals::FLD_NAME_MODEL =>$model,
                                    Globals::FLD_NAME_FORM=>$form,
                                ),true,true);
               }
                else 
                {
//					try
//					{
//                    	$taskList = Task::getUserTaskListByTypeandCategory( Globals::DEFAULT_VAL_V , $category_id );
//					}
//					catch(Exception $e)
//					{             
//						$msg = $e->getMessage();
//						CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
//					}
//                    $return["previusTask"] = $this->renderPartial('_loadpreviuostask',array('model'=>$taskList , Globals::FLD_NAME_FORM_TYPE_SML=> 'v' ),true,true);
                    $task->scenario = Globals::VIRTUAL_TASK;
                    $return["form"] = $this->renderPartial('partial/_virtual_task_detail_from', 
                            array(  
                                    'task'=>$task,
//                                    'model'=>$model,
//                                    'form'=>$form,
//                                    'category'=>$category,
                                    'taskLocation'=>$taskLocation,
//                                    'skill'=>$skill,
//                                    'questions'=>$questions,
//                                    Globals::FLD_NAME_TASK =>$task,
                                    Globals::FLD_NAME_MODEL =>$model,
                                    Globals::FLD_NAME_FORM=>$form,
                                ),true,true);
                }
                echo CJSON::encode($return);
                CommonUtility::endProfiling();
            
	}
     
    /**
    * get category tempate data on task creation
    * @params category_id , templateId
    * @return string demo action does not return anything
    * @var
    */
    public function actionGettemplatedetail()
    {        
        CommonUtility::startProfiling();
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  
        $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];  
        $templateId = $_POST[Globals::FLD_NAME_TEMPLATEID];
        
        try
        {
            $category = Category::getCategoryListByID($_POST[Globals::FLD_NAME_CATEGORY_ID]);  
            if($category)
            {
                foreach ($category as $cat) 
                {
                    $template = json_decode($cat->categorylocale[Globals::FLD_NAME_TASK_TEMPLATES], true);
                    $return["title"] =  $template[$templateId][Globals::FLD_NAME_TITLE];
                    $return["description"] =  $template[$templateId][Globals::FLD_NAME_DESC];
                }
            }
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" => $category_id ) );
        }
        $msg = "";
        if (CommonUtility::IsDebugEnabled())
        {
                Yii::log('Successfully page loaded', CLogger::LEVEL_INFO, 'PosterController.Templatedetail');
        } 
        $return["status"] = 'success';
       
       // $return["questions"] = $this->renderPartial('partial/_task_detail_form_questions',  array(   'questions'=>$questions, ),true,true);
         echo CJSON::encode($return);
        //$this->renderPartial('templatedetail',array( 'category'=>$category,'msg'=>$msg,'templateId'=>$_GET[Globals::FLD_NAME_TEMPLATEID]),false,true);
        CommonUtility::endProfiling();
    }
    /**
    * save virtual task
    * @params category_id and form data
    * @return json success or error
    * @var
    */
    public function actionSaveVirtualTask()
        {
            CommonUtility::startProfiling();
            $model = $this->loadModel(Yii::app()->user->id);
            $task = new Task();
            $taskCategory = new TaskCategory();
            $taskLocation = new TaskLocation();
            @$taskType = $_POST[Globals::FLD_NAME_SELECTED_TASKTYPE];
            $scenario = $taskType.Globals::FLD_NAME_TASK;
            $task->scenario = $scenario; /// set scenario according to task type
            if(Yii::app()->request->isAjaxRequest)
            {
                    $error =  CActiveForm::validate(array($task));
                    if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                    {
                        // For logging 
                        CommonUtility::setErrorLog($task->getErrors(),get_class($task));
                        echo $error;
                        Yii::app()->end();
                    }
            }
            //exit;
            if(isset($_POST[Globals::FLD_NAME_TASK]))
            {
                    $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                    $task->attributes=$_POST[Globals::FLD_NAME_TASK];
                    @$to_publish = $_GET[Globals::FLD_NAME_PUBLIC];
                    $task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                    @$autoinvite = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_AUTO];
                    switch ($taskType) /// insert values according to task type
                    {
                        case Globals::DEFAULT_VAL_INSTANT :
                           //
                            $task->{Globals::FLD_NAME_TITLE} = CommonUtility::truncateText( $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_DESCRIPTION] , Globals::DEFAULT_VAL_TASK_TITLE_LENGTH , false) ;
                            $endHours = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_END_TIME];
                            $endDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH , strtotime("+".$endHours."hours"));
                            $endTime = date(Globals::DEFAULT_VAL_END_TIME_FORMATE , strtotime("+".$endHours."hours"));
                            $task->{Globals::FLD_NAME_END_TIME} = $endTime;
                            $task->{Globals::FLD_NAME_TASK_END_DATE} = $endDate;
                            
                        
                            if($autoinvite)
                            {
                                $task->{Globals::FLD_NAME_SELECTION_TYPE} = Globals::FLD_NAME_AUTO;
                               
                            }
                            $task->{Globals::FLD_NAME_TASK_KIND} = Globals::DEFAULT_VAL_I;
                            $task->{Globals::FLD_NAME_WORK_HRS} = $endHours;

                            break;
                        case Globals::DEFAULT_VAL_INPERSON :
                           
                            $task->{Globals::FLD_NAME_TASK_KIND} = Globals::DEFAULT_VAL_P;
                            //$task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime("+".$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION] ));
                            //$task->{Globals::FLD_NAME_BID_DURATION} =  @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION];
                            break;

                        default:
                           // $task->{Globals::FLD_NAME_TASK_START_DATE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_START_DATE];
                            $task->{Globals::FLD_NAME_TASK_END_DATE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_END_DATE];
                            $task->{Globals::FLD_NAME_TASK_KIND} = Globals::DEFAULT_VAL_V;
                            //$task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_BID_CLOSE_DATE];
                            $task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime("+".$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION] ));
                            $task->{Globals::FLD_NAME_BID_DURATION} =  @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION];

                            break;
                    }
                    

                        $task->{Globals::FLD_NAME_VALID_FROM_DT} = date(Globals::DEFAULT_VAL_DATE_FORMATE_YMD);
                        $task->{Globals::FLD_NAME_BID_START_DATE}  = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
  

                    //$task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} =CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_BID_CLOSE_DATE]);
                    $task->{Globals::FLD_NAME_PRICE}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PRICE];
                    $task->{Globals::FLD_NAME_IS_PREMIUM_TASK} = @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_IS_PREMIUM_TASK];
                    $task->{Globals::FLD_NAME_IS_HIGHLIGHTED} = @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_IS_HIGHLIGHTED];
                    $task->{Globals::FLD_NAME_PAYMENT_MODE} = @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PAYMENT_MODE];
                    $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                    $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_O;
                    $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                    $task->{Globals::FLD_NAME_CREATOR_ROLE}=Globals::DEFAULT_VAL_P;
                    
                    $task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                    
                    if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                    {
                        foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE] as $image)
                        {
                            try
                            {
                                    $extension = CommonUtility::getExtension($image);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                            }
                            try
                            {
                                    $type = CommonUtility::getFileType($extension);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                            }
                            
                            
                            $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$image;
                            $attachment[Globals::FLD_NAME_TYPE]=$type;
                            $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                            $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
                            $attachment[Globals::FLD_NAME_UPLOADED_BY]= Yii::app()->user->id;
                            $filename = explode('.', $image);
                            $attachment[Globals::FLD_NAME_FILESIZE]= $_POST[$filename[0]."_size"];
                            $attachment[Globals::FLD_NAME_IS_PUBLIC]= Globals::DEFAULT_VAL_0;
                           // $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
                            try
                            {
                                    $moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                            }
                            $fileInfo[]=$attachment;
                            
                            if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
                            {
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                                    }
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                                    }
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                                    }
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                                    }
                            }
                        }
                        $files = CJSON::encode( $fileInfo );
                        $task->{Globals::FLD_NAME_TASK_ATTACHMENTS} = $files;
                        $task->{Globals::FLD_NAME_SPACE_QUOTA_USED} = $_POST['uploadPortfolioImage_totalFileSizeUsed'];
                        
                    }
                    try
                    {
//                        try
//                        {
//                            $task->save();
//                        } 
//                        catch (Exception $ex) 
//                        {
//                            print_r($ex);
//                            throw new Exception($ex."----".Yii::t('poster_savevirtualtask','project not save'));
//                        }
                        // $task->save();
                        if( !$task->save())
                        {   
                            throw new Exception(Yii::t('poster_savevirtualtask','project not save'));
                        }
                        $insertedId=$task->getPrimaryKey();
                        $model->{Globals::FLD_NAME_TASK_POST_CNT} += 1;
                        $model->{Globals::FLD_NAME_TASK_POST_TOTAL_PRICE} += $task->{Globals::FLD_NAME_PRICE};
                        $model->{Globals::FLD_NAME_TASK_POST_TOTAL_HOURS} += $task->{Globals::FLD_NAME_WORK_HRS};
                        if( !$model->update())
                        {   
                            throw new Exception(Yii::t('poster_savevirtualtask','user detail'));
                        }
                        $taskCategory->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                        $taskCategory->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                        $taskCategory->{Globals::FLD_NAME_CATEGORY_ID} = $category_id;
                        $taskCategory->{Globals::FLD_NAME_STATUS}  = Globals::DEFAULT_VAL_O;
                        $taskCategory->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;

//                        echo $_POST[Globals::FLD_NAME_TASK_LOCATION]["location_type"];
//                        exit;
                        if(!$taskCategory->save())
                        {
                                throw new Exception(Yii::t('poster_savevirtualtask','task category'));
                        }
                        if($autoinvite)
                        {

                            $limit = Globals::DEFAULT_VAL_AUTO_INVATATION_BY_SYSTEM; 
                            $autoInvitation = GetRequest::autoInvitation( $insertedId , $category_id , $limit );
                            if(empty($autoInvitation))
                            {
                                    throw new Exception(Yii::t('poster_saveinperson','unexpected_error'));
                            }
                        }
                       
                        @$skills = $_POST[Globals::FLD_NAME_MULTISKILLS];
                        if($skills)
                        {
                                foreach ($skills as $skill)
                                {
                                        $taskSkill = new TaskSkill();
                                        $taskSkill->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                        $taskSkill->{Globals::FLD_NAME_SKILL_ID}  = $skill;
                                        $taskSkill->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                        if(!$taskSkill->save())
                                        {
                                                throw new Exception(Yii::t('poster_savevirtualtask','task skills'));
                                        }
                                        //echo $skill;
                                }
                        }
                        @$questions = $_POST[Globals::FLD_NAME_MULTI_CAT_QUESTION];
                        if($questions)
                        {
                                foreach ($questions as $question)
                                {
                                    $questionDetail = explode("--", $question);
                                    if($questionDetail[0] != '')
                                    {
                                        $questionId = $questionDetail[0];
                                    }
                                    else
                                    {
                                        $questionId = 0;
                                    }
                                  
                                    $questionDesc = $questionDetail[1];
                                        $taskQuestion = new TaskQuestion();
                                        $taskQuestion->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                        if(isset($questionId))
                                        $taskQuestion->{Globals::FLD_NAME_QUESTION_ID}  = $questionId;
                                        
                                        $taskQuestion->{Globals::FLD_NAME_TASK_QUESTION_DESC}  = $questionDesc;
                                        
                                        $taskQuestion->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                        if(!$taskQuestion->save())
                                        {
                                                throw new Exception(Yii::t('poster_savevirtualtask','save question'));
                                        }
                                        //echo $question;
                                }
                        }
                        
                        /////
                        
                        @$invitedTaskers = $_POST[Globals::FLD_NAME_INVITEDTASKERS];
                        
                        if($invitedTaskers)
                        {
                            $invitedTaskers = array_unique($invitedTaskers);
                                foreach ($invitedTaskers as $invitedTasker)
                                {
//                                    $latitude1 = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
//                                    $longitude1 = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
//                                    $latitude2 = $task->{Globals::FLD_NAME_LOCATION_LATITUDE};
//                                    $longitude2 = $task->{Globals::FLD_NAME_LOCATION_LONGITUDE};
//                                    $getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);

                                    $tasker = new TaskTasker();
                                    $task = Task::model()->findByPk($insertedId);
                                    //$model->attributes = $_POST[Globals::FLD_NAME_TASK];
                                    $tasker->{Globals::FLD_NAME_TASK_ID} = $insertedId;

                                    $tasker->{Globals::FLD_NAME_TASKER_ID} = $invitedTasker;
                                    $tasker->{Globals::FLD_NAME_SELECTION_TYPE} = Globals::DEFAULT_VAL_INVITE;
                                    $tasker->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                                    $tasker->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} =  $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
                                    $tasker->{Globals::FLD_NAME_TASKER_LOCATION_GEO_AREA} = $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE};
                                    $tasker->{Globals::FLD_NAME_IS_INVITED} = Globals::DEFAULT_VAL_IS_INVITED_ACTIVE;
                                   
                                    //$model->{Globals::FLD_NAME_TASKER_IN_RANGE} = $_POST[Globals::FLD_NAME_TASKER_IN_RANGE];
                                    $task->{Globals::FLD_NAME_INVITED_CNT} += 1;
                                    try
                                    {
                                        if(!$tasker->save())
                                        {
                                                     throw new Exception(Yii::t('tasker_createtask','invite tasker'));
                                        }
                                        $task_tasker_id = $tasker->getPrimaryKey();
                                        
                                            $alert = new UserAlert();
                                            try
                                            {
                                                $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                                            }
                                            catch(Exception $e)
                                            {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task Tasker ID" => $task_tasker_id) );
                                            }
                                            $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                                            $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_TASKER_INVITED;
                                            $alert->{Globals::FLD_NAME_FOR_USER_ID} = $tasker->{Globals::FLD_NAME_TASKER_ID}; 
                                            $alert->{Globals::FLD_NAME_BY_USER_ID} =  Yii::app()->user->id;
                                            $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                                            $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                            if(!$alert->save())
                                            {   
                                                throw new Exception(Yii::t('poster_saveproposal','user alert'));   
                                            }
                                        /////////////////
                                        if(!$task->update())
                                        {
                                                     throw new Exception(Yii::t('tasker_createtask','update task'));
                                        }
                                        
                                            
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
                                }
                        }
                        
                
                        
                        
                        /////

                        if(isset ($_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION]))
                        {
                                @$locations = $_POST[Globals::FLD_NAME_MULTI_LOCATIONS];
                                if($locations)
                                {
                                        foreach ($locations as $location)
                                        {
                                                $taskLocation = new TaskLocation();
                                                $taskLocation->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                                if($_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C)
                                                {
                                                        $taskLocation->{Globals::FLD_NAME_COUNTRY_CODE} = $location;
                                                }
                                                elseif($_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_R)
                                                {
                                                        $taskLocation->{Globals::FLD_NAME_REGION_ID} = $location;
                                                }
                                                $taskLocation->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;

                                                $taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION} = $_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION];
                                                $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE} = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
                                                $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE} = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                                                if(!$taskLocation->save())
                                                {
                                                        throw new Exception(Yii::t('poster_savevirtualtask','task location'));
                                                }
                                        }
                                }
                        }// exit;
                        $otherInfo = array( 
                                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::TASK_ACTIVITY_SUBTYPE_TASK_VIRTUAL,
                                      //  Globals::FLD_NAME_COMMENTS => '',
                                );
                        try
                        {
                                $detailUrl = CommonUtility::getPosterThankyouPageUrl($insertedId);
                                CommonUtility::addTaskActivity($insertedId , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_CREATE , $otherInfo );
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                        }
                        echo  $error = CJSON::encode(array(
                                        'status'=>'success',
                                        'tack_id'=>$insertedId,
                                        'category_id'=>$category_id,
                                        'detailUrl' => $detailUrl
                                ));

    //echo 'hiii';
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" =>Yii::app()->user->id ,"Category ID" =>$category_id) );
                }    
            }
            CommonUtility::endProfiling();
            
        }
    /**
    * update project
    * @params task_id category_id and form data
    * @return json success or error
    * @var
    */
    public function actionUpdateProject()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('EditVirtualTask','application.controller.PosterController');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task_id = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
            $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                
            $task=Task::model()->findByPk($task_id);
            $taskCategory = TaskCategory::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
            $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
            @$taskType = $_POST[Globals::FLD_NAME_SELECTED_TASKTYPE];
            $scenario = $taskType.Globals::FLD_NAME_TASK;
            $task->scenario = $scenario;
            if(Yii::app()->request->isAjaxRequest)
            {
                $error =  CActiveForm::validate(array($task));
                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                {
                    // for logging
                    CommonUtility::setErrorLog($task->getErrors(),get_class($task));
                    echo $error;
                    Yii::app()->end();
                }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK]))
            {
                    $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                    $task->attributes=$_POST[Globals::FLD_NAME_TASK];
					$task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                        
                    switch ($taskType) /// insert values according to task type
                    {
                        case Globals::DEFAULT_VAL_INSTANT :
                           
                           $task->{Globals::FLD_NAME_TITLE} = CommonUtility::truncateText( $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_DESCRIPTION] , Globals::DEFAULT_VAL_TASK_TITLE_LENGTH , false) ;
                            $endHours = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_END_TIME];
                            $endDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH , strtotime("+".$endHours."hours"));
                            $endTime = date(Globals::DEFAULT_VAL_END_TIME_FORMATE , strtotime("+".$endHours."hours"));
                            $task->{Globals::FLD_NAME_END_TIME} = $endTime;
                            $task->{Globals::FLD_NAME_TASK_END_DATE} = $endDate;

                            @$autoinvite = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_AUTO];

                            if($autoinvite)
                            {
                                $task->{Globals::FLD_NAME_SELECTION_TYPE} = Globals::FLD_NAME_AUTO;
    //                                $limit = Globals::DEFAULT_VAL_AUTO_INVATATION_BY_SYSTEM; 
    //                                $autoInvitation = GetRequest::autoInvitation( $insertedId , $category_id , $limit );
    //                                if(empty($autoInvitation))
    //                                {
    //                                        //throw new Exception(Yii::t('poster_saveinperson','unexpected_error'));
    //                                }
                            }
                            $task->{Globals::FLD_NAME_TASK_KIND} = Globals::DEFAULT_VAL_I;
                            $task->{Globals::FLD_NAME_WORK_HRS} = $endHours;

                            break;
                        case Globals::DEFAULT_VAL_INPERSON :
                           
                            $task->{Globals::FLD_NAME_TASK_KIND} = Globals::DEFAULT_VAL_P;
                            
//                            $task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime("+".$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION] ));
//                            $task->{Globals::FLD_NAME_BID_DURATION} =  @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION];
                            break;

                        default:
                           // $task->{Globals::FLD_NAME_TASK_START_DATE}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_START_DATE];
                            $task->{Globals::FLD_NAME_TASK_END_DATE}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_END_DATE];
                            $task->{Globals::FLD_NAME_TASK_KIND} = Globals::DEFAULT_VAL_V;
                            $task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime("+".$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION] ));
                            $task->{Globals::FLD_NAME_BID_DURATION} =  @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION];
                            //$task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_BID_CLOSE_DATE];
                            break;
                    }
                          
                    //$task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} =CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_BID_CLOSE_DATE]);
                    @$to_publish = $_GET[Globals::FLD_NAME_PUBLIC];
                    if(isset($to_publish))
                    {
                        $task->{Globals::FLD_NAME_VALID_FROM_DT} = date(Globals::DEFAULT_VAL_DATE_FORMATE_YMD);
                        $task->{Globals::FLD_NAME_BID_START_DATE}  = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                        
                    }
                    if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_START_TODAY]))
                    {
                        $task->{Globals::FLD_NAME_BID_START_DATE}  = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                    }
//                    $task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION]));
                    $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                    $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_O;
                    $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                    $task->{Globals::FLD_NAME_CREATOR_ROLE}=Globals::DEFAULT_VAL_P;
                   
                    $task->{Globals::FLD_NAME_IS_PREMIUM_TASK} = @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_IS_PREMIUM_TASK];
                    $task->{Globals::FLD_NAME_IS_HIGHLIGHTED} = @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_IS_HIGHLIGHTED];
                    $task->{Globals::FLD_NAME_PAYMENT_MODE} = @$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PAYMENT_MODE];
                    
                    
                    if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PRICE]))
                    $task->{Globals::FLD_NAME_PRICE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PRICE];
                   
                    if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                    {
                        foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE] as $image)
                        {
                            try
                            {
                                    $extension = CommonUtility::getExtension($image);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id ) );
                            }
                            try
                            {
                                    $type = CommonUtility::getFileType($extension);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                            }
                            $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$image;
                            $attachment[Globals::FLD_NAME_TYPE]=$type;
                            $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                            $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
                            $attachment[Globals::FLD_NAME_UPLOADED_BY]= Yii::app()->user->id;
                            $filename = explode('.', $image);
                            $attachment[Globals::FLD_NAME_FILESIZE]= $_POST[$filename[0]."_size"];
                            $attachment[Globals::FLD_NAME_IS_PUBLIC]= Globals::DEFAULT_VAL_0;
                            try
                            {
                                    $moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                            }
                            $fileInfo[]=$attachment;

                            if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
                            {
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                                    }
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                                    }
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                                    }
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                                    }
                            }
                        }
                        $files = CJSON::encode( $fileInfo );
                        $task->{Globals::FLD_NAME_TASK_ATTACHMENTS}=$files;
                        $task->{Globals::FLD_NAME_SPACE_QUOTA_USED} = $_POST['uploadPortfolioImage_totalFileSizeUsed'];
                    }
                    
                    if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE])  )
                    {
                        foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE] as $image)
                        {
                            
                            if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                            {
                                
                                if(!in_array($image, $_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                                {
                                    try
                                    {
                                            CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME},$image);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                                    }
                                }
                            }
                            else
                            {//echo $image;
                                    try
                                    {//echo $image;
                                            CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME},$image);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                                    }
                                    
                                    $task->{Globals::FLD_NAME_TASK_ATTACHMENTS} = NULL;
                            }
                        }
                    }
                    try
                    {
                            if(! $task->update())
                            {
                                    throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
                            }

//                            $taskCategory->{Globals::FLD_NAME_CATEGORY_ID} =$category_id;
//                            $taskCategory->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
//                            if(!$taskCategory->update())
//                            {
//                                    throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
//                            }
                            $insertedId = $task->getPrimaryKey();
                            TaskLocation::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                            
                            if(isset ($_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION]))
                            {
                                @$locations = $_POST[Globals::FLD_NAME_MULTI_LOCATIONS];
                                if($locations)
                                {
                                        foreach ($locations as $location)
                                        {
                                                $taskLocation = new TaskLocation();
                                                $taskLocation->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                                if($_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C)
                                                {
                                                        $taskLocation->{Globals::FLD_NAME_COUNTRY_CODE} = $location;
                                                }
                                                elseif($_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_R)
                                                {
                                                        $taskLocation->{Globals::FLD_NAME_REGION_ID} = $location;
                                                }
                                                $taskLocation->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;

                                                $taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION} = $_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION];
                                                $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE} = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
                                                $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE} = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                                                if(!$taskLocation->save())
                                                {
                                                        throw new Exception(Yii::t('poster_savevirtualtask','unexpected_error'));
                                                }
                                        }
                                }
                            }// exit;
                        
                        
                         
                            @$skills = $_POST[Globals::FLD_NAME_MULTISKILLS];
                            if($skills)
                            {
                                   // TaskSkill::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                                    foreach ($skills as $skill)
                                    {
                                        $hasSkill = TaskSkill::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$insertedId , Globals::FLD_NAME_SKILL_ID => $skill ));
                                        if(!$hasSkill)
                                        {
                                            $taskSkill = new TaskSkill();
                                            $taskSkill->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                            $taskSkill->{Globals::FLD_NAME_SKILL_ID}  = $skill;
                                            $taskSkill->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                            if(!$taskSkill->save())
                                            {
                                                    throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
                                            }
                                        }
                                    }
                            }
                            
                            
                        @$questions = $_POST[Globals::FLD_NAME_MULTI_CAT_QUESTION];
                        if($questions)
                        {
                                TaskQuestion::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                                foreach ($questions as $question)
                                {
                                    $questionDetail = explode("--", $question);
                                    if($questionDetail[0] != '')
                                    {
                                        $questionId = $questionDetail[0];
                                    }
                                    else
                                    {
                                        $questionId = 0;
                                    }
                                  
                                    $questionDesc = $questionDetail[1];
                                        $taskQuestion = new TaskQuestion();
                                        $taskQuestion->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                        if(isset($questionId))
                                        $taskQuestion->{Globals::FLD_NAME_QUESTION_ID}  = $questionId;
                                        
                                        $taskQuestion->{Globals::FLD_NAME_TASK_QUESTION_DESC}  = $questionDesc;
                                        
                                        $taskQuestion->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                        if(!$taskQuestion->save())
                                        {
                                                throw new Exception(Yii::t('poster_savevirtualtask','save question'));
                                        }
                                        //echo $question;
                                }
                        }
                        
                            
                        @$invitedTaskers = $_POST[Globals::FLD_NAME_INVITEDTASKERS];
                        TaskTasker::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                        if($invitedTaskers)
                        {
                            $invitedTaskers = array_unique($invitedTaskers);
                                foreach ($invitedTaskers as $invitedTasker)
                                {
//                                    $latitude1 = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
//                                    $longitude1 = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
//                                    $latitude2 = $task->{Globals::FLD_NAME_LOCATION_LATITUDE};
//                                    $longitude2 = $task->{Globals::FLD_NAME_LOCATION_LONGITUDE};
//                                    $getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);

                                    $tasker = new TaskTasker();
                                  
                                    //$model->attributes = $_POST[Globals::FLD_NAME_TASK];
                                    $tasker->{Globals::FLD_NAME_TASK_ID} = $insertedId;

                                    $tasker->{Globals::FLD_NAME_TASKER_ID} = $invitedTasker;
                                    $tasker->{Globals::FLD_NAME_SELECTION_TYPE} = Globals::DEFAULT_VAL_INVITE;
                                    $tasker->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                                    $tasker->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
                                    $tasker->{Globals::FLD_NAME_TASKER_LOCATION_GEO_AREA} = $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE};
                                   
                                    //$model->{Globals::FLD_NAME_TASKER_IN_RANGE} = $_POST[Globals::FLD_NAME_TASKER_IN_RANGE];
                                    $task->{Globals::FLD_NAME_INVITED_CNT} += 1;
                                    try
                                    {
                                        if(!$tasker->save())
                                        {
                                                     throw new Exception(Yii::t('tasker_createtask','invite tasker'));
                                        }

                                        if(!$task->update())
                                        {
                                                     throw new Exception(Yii::t('tasker_createtask','update task'));
                                        }
                                            
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
                                }
                        }
                        
                        try
                        {
                                $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                        }
                        try
                        {
                                CommonUtility::sendAlertToAllTaskers( $insertedId , $alertType , Globals::ALERT_DESC_TASK_EDITED );  
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                        }
                        $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::TASK_ACTIVITY_SUBTYPE_TASK_VIRTUAL,
                                            //  Globals::FLD_NAME_COMMENTS => '',
                                        );
                        try
                        {
                            //$detailUrl = CommonUtility::getTaskDetailURI($insertedId);	
                            $detailUrl = CommonUtility::getPosterCurrentryHiringUrl();	
                            
                                CommonUtility::addTaskActivity($insertedId , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_UPDATE , $otherInfo );
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                        }
                        Yii::app()->user->setFlash('success',Yii::t('poster_createtask', 'Project updated successfully.'));

                            echo  $error = CJSON::encode(array(
                                    'status'=>'success',
                                    'tack_id'=>$task_id,
                                    'category_id'=>$category_id,
                                        'detailUrl' => $detailUrl
                            ));
                            
                            
						
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $task_id  ,"User ID" => Yii::app()->user->id) );
                    }    
            }
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('EditVirtualTask');
            }
            
        }
        
     /**
    * get category tempate data on task creation
    * @params category_id , templateId
    * @return string demo action does not return anything
    * @var
    */
    public function actionGetRecentTaskTemplateDetail()
    {        
         CommonUtility::startProfiling();
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  
        @$task_id = $_POST[Globals::FLD_NAME_TASK_ID];  
        
        if($task_id != '')
        {
            try
            {
                $task = Task::model()->findByPk($task_id);
                if($task===null)
                    throw new Exception('task id null');
                $return[Globals::FLD_NAME_TITLE] = $task->{Globals::FLD_NAME_TITLE};
                $return[Globals::FLD_NAME_DESCRIPTION] = $task->{Globals::FLD_NAME_DESCRIPTION};
                $return[Globals::FLD_NAME_IS_PREMIUM_TASK] = $task->{Globals::FLD_NAME_IS_PREMIUM_TASK};
                $return[Globals::FLD_NAME_PRICE] = $task->{Globals::FLD_NAME_PRICE};
                $return[Globals::FLD_NAME_TASK_MIN_PRICE] = $task->{Globals::FLD_NAME_TASK_MIN_PRICE};
                $return[Globals::FLD_NAME_TASK_MAX_PRICE] = $task->{Globals::FLD_NAME_TASK_MAX_PRICE};
                $return[Globals::FLD_NAME_TASK_CASH_REQUIRED] =  $task->{Globals::FLD_NAME_TASK_CASH_REQUIRED};
                $return[Globals::FLD_NAME_WORK_HRS] = $task->{Globals::FLD_NAME_WORK_HRS};
                $return[Globals::FLD_NAME_PAYMENT_MODE] = $task->{Globals::FLD_NAME_PAYMENT_MODE};
                $return[Globals::FLD_NAME_IS_HIGHLIGHTED] = $task->{Globals::FLD_NAME_IS_HIGHLIGHTED};
                $return[Globals::FLD_NAME_IS_PUBLIC] = $task->{Globals::FLD_NAME_IS_PUBLIC};
                $return[Globals::FLD_NAME_PAYMENT_MODE] = $task->{Globals::FLD_NAME_PAYMENT_MODE};
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
               
            }
        }
        else
        {
                $return[Globals::FLD_NAME_TITLE] = '';
                $return[Globals::FLD_NAME_DESCRIPTION] = '';
                $return[Globals::FLD_NAME_IS_PREMIUM_TASK] = '';
                $return[Globals::FLD_NAME_PRICE] = Globals::DEFAULT_VAL_MIN_PRICE;
                $return[Globals::FLD_NAME_TASK_MIN_PRICE] = Globals::DEFAULT_VAL_MIN_PRICE;
                $return[Globals::FLD_NAME_TASK_MAX_PRICE] = Globals::DEFAULT_VAL_MIN_PRICE;
                $return[Globals::FLD_NAME_TASK_CASH_REQUIRED] =  Globals::DEFAULT_VAL_MIN_PRICE;
                $return[Globals::FLD_NAME_WORK_HRS] = Globals::DEFAULT_VAL_WORK_HRS;
                $return[Globals::FLD_NAME_PAYMENT_MODE] = Globals::DEFAULT_VAL_PAYMENT_MODE_HOURLY;
                $return[Globals::FLD_NAME_IS_HIGHLIGHTED] = '';
                $return[Globals::FLD_NAME_IS_PUBLIC] = '1';
               
        }
        $msg = "";
        if (CommonUtility::IsDebugEnabled())
        {
                Yii::log('Successfully page loaded', CLogger::LEVEL_INFO, 'PosterController.Templatedetail');
        } 
        $return["status"] = 'success';
       
       // $return["questions"] = $this->renderPartial('partial/_task_detail_form_questions',  array(   'questions'=>$questions, ),true,true);
         echo CJSON::encode($return);
        //$this->renderPartial('templatedetail',array( 'category'=>$category,'msg'=>$msg,'templateId'=>$_GET[Globals::FLD_NAME_TEMPLATEID]),false,true);
        CommonUtility::endProfiling();
    }
    
    /**
    * poster rating review given by tasker 
    * @params no parameters
    * @return string demo action does not return anything
    * @var
    */
    public function actionProjectCompletion()
    {
        CommonUtility::startProfiling();        
        $task_tasker_id = $_GET[Globals::FLD_NAME_TASK_TASKER_ID];
        $taskTasker = TaskTasker::model()->with('task')->findByPk($task_tasker_id);
        $task_id = $taskTasker->{Globals::FLD_NAME_TASK_ID};
        $task = Task::model()->findByPk($task_id);
        $model = $this->loadModel($taskTasker->{Globals::FLD_NAME_TASKER_ID});
        $rating = array();
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
        
        if($taskTasker->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED && $task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id)
        {
            $this->layout = '//layouts/noheader';
            $this->render('projectcompletion' , array( 'task' => $task ,'taskTasker'=>$taskTasker, 'model' => $model,'rating' => $rating));
        }
        else
        {
            $this->redirect(array('/index/dashboard'));
        }
        CommonUtility::endProfiling();
    }
    
      /**
    * get infowidow of tasker information on google map
    * @params tasker_id
    * @return string of tasker detail
    * @var
    */
    public function actionInviteUserPopup()
   {
       CommonUtility::startProfiling();
       //$task_id = $_POST[Globals::FLD_NAME_TASK_ID];
       $user_id = $_POST[Globals::FLD_NAME_USER_ID];
       $distance = $_POST[Globals::FLD_NAME_DISTANCE];
       $user = User::model()->findByPk($user_id);
       //$task = Task::model()->findByPk($task_id);
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        $return["status"] = 'success';
        $return["html"] = $this->renderPartial('partial/_tasker_map_popup', 
                    array(  //'task'=>$task,
                            Globals::FLD_NAME_DISTANCE=>$distance,
                            'data'=>$user,
                            ),true,true);
        echo CJSON::encode($return);
       CommonUtility::endProfiling();
   }
   
       /**
    * Bid end date droop down 
    * @params task end date
    * @return droop down of bid end day list
    * @var
    */
    public function actionBidEndDateDroopDown()
    {
        CommonUtility::startProfiling();
        try
        {
            $endDate = $_POST[Globals::FLD_NAME_TASK_END_DATE];
            $bidDuration = Globals::getbidDurationArray();
            
            
            $today = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
            $timeDifference = CommonUtility::differenceBitweenTwoDates($today , $endDate);
           

                //printf("%d years, %d months, %d days\n", $years, $months, $days);
            if( $timeDifference['days'] < 7 && $timeDifference['months'] == 0 )
            {
                $bidDuration = Globals::getbidDurationArray('day');
             
                        
            }
            elseif( $timeDifference['days'] < 15 && $timeDifference['months'] == 0  )
            {
                $bidDuration = Globals::getbidDurationArray('week');
            }
            elseif( $timeDifference['days'] < 30 && $timeDifference['months'] == 0  )
            {
                $bidDuration = Globals::getbidDurationArray('hmonth');
            }
//            elseif( $months >= 1 )
//            {
//                $bidDuration = Globals::getbidDurationArray('hmonth');
//            }
            $bidDroopDown =  CHtml:: dropDownList(Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_BID_DURATION.']','' ,$bidDuration, array(
            'empty' => Yii::t('poster_createtask','txt_task_select_bid_duration'),
            'onchange'=>'getBidCloseDate(this.value , "#taskBidCloseDate")',
            'class' => 'form-control'));
            $return["status"] = 'success';
            $return["duration"] = $bidDroopDown;

            echo CJSON::encode($return);

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
    * set hiring off for task
    * @params task_id
    * @return json success
    * @var
    */
    public function actionSetHiringOff()
    {
        CommonUtility::startProfiling();
        try
        {
            $taskId= $_POST[Globals::FLD_NAME_TASK_ID];
            $task = Task::model()->findByPk($taskId);
            $task->{Globals::FLD_NAME_HIRING_CLOSED} = Globals::DEFAULT_VAL_HIRING_CLOSED_ACTIVE;
            if( !$task->update())
            {   
                throw new Exception(Yii::t('poster_savevirtualtask','project not updated'));
            }
            $return["status"] = 'success';
            
            echo CJSON::encode($return);

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
    * call popup to switch job type to hourly
    * @params task_id
    * @return json success
    * @var
    */
    public function actionSwitchJobTypePopup()
    {
        CommonUtility::startProfiling();
        try
        {
            $taskId = $_POST[Globals::FLD_NAME_TASK_ID];
            $paymentMode = $_POST[Globals::FLD_NAME_PAYMENT_MODE];
            $task = Task::model()->findByPk($taskId);

            $return["status"] = 'success';
            $return["html"] = $this->renderPartial('partial/_switch_jobtype_hourly',array(  'task'=>$task, 'paymentMode'=>$paymentMode, ),true,true);
            echo CJSON::encode($return);

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
    * call popup to switch job type to hourly
    * @params task_id
    * @return json success
    * @var
    */
    public function actionModifyTermsAndPayment()
    {
        CommonUtility::startProfiling();
        try
        {
            $taskId = $_POST[Globals::FLD_NAME_TASK_ID];
            $user_id = $_POST[Globals::FLD_NAME_USER_ID];
            $task = Task::model()->findByPk($taskId);

            $return["status"] = 'success';
            $return["html"] = $this->renderPartial('partial/_modify_terms_payment',array(  'task'=>$task, 'user_id'=>$user_id, ),true,true);
            echo CJSON::encode($return);

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
    * Task detail page for poster and tasker
    * @params task id 
    * @return view for task list page
    * @var
    */
    public function actionTaskDetail()
    {
        CommonUtility::startProfiling();
        $task_id = $_GET[Globals::FLD_NAME_TASKID];
        $taskType = $_GET[Globals::FLD_NAME_TASKTYPE];
        @$sort = $_GET[Globals::FLD_NAME_SORT];
        @$currentTasker = $_GET['currentaskers'];
        $key = '';
        if(isset($_POST[Globals::FLD_NAME_KEY]))
        {
            $key = $_POST[Globals::FLD_NAME_KEY];
        }          
        
        $task = Task::model()->with('taskcategory','category','categorylocale')->findByPk($task_id);

        $message = new Inbox();
        $taskImage = CommonUtility::getTaskImageForShare($task->{Globals::FLD_NAME_TASK_ID});
        Yii::app()->clientScript->registerMetaTag($taskImage, '', null, array('id'=>'meta_og_image', 'property' => 'og:image'), 'meta_og_image');
        Yii::app()->clientScript->registerMetaTag($task->{Globals::FLD_NAME_TITLE}, '', null, array('id'=>'meta_og_title', 'property' => 'og:title'), 'meta_og_title');
        Yii::app()->clientScript->registerMetaTag(Yii::app()->getBaseUrl(true), '', null, array('id'=>'meta_og_site_name', 'property' => 'og:site_name'), 'meta_og_site_name');
        Yii::app()->clientScript->registerMetaTag($task->{Globals::FLD_NAME_DESCRIPTION}, '', null, array('id'=>'meta_og_description', 'property' => 'og:description'), 'meta_og_description');
        try
        {
            $question = TaskQuestion::getTaskQuestion($task->{Globals::FLD_NAME_TASK_ID});
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id) );
        }
        $taskTasker = new TaskTasker();  
        try
        {
                $taskSkills = CommonUtility::getTaskSkillsIdCommaSeprated($task_id);
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id) );
        }
        //// get messages
        try 
        {
                $filters = array(
                Globals::FLD_NAME_TASK_ID => $task_id,
                Globals::FLD_NAME_FROM_USER_ID => $currentTasker,
                Globals::FLD_NAME_CREATER_USER_ID => $task->{Globals::FLD_NAME_CREATER_USER_ID},
            );
            
        if($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id )
        {
            $messagesOnTask = $message->getMessagesOnTask($filters);
        }
        else 
        {
           $messagesOnTask = $message->getMessagesOnTaskByTasker( Yii::app()->user->id  , $filters );
           $currentTasker = Yii::app()->user->id;
        }
           
            
            
        } 
        catch (Exception $e) 
        {
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id) );
        }
        try 
        {
            
            $attachments = Task::getFiles( $task_id , $currentTasker);
            
        } 
        catch (Exception $e) 
        {
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id) );
        }
        

        $taskQuestionReply = new TaskQuestionReply();
        $taskTasker->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
        $taskQuestionReply->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
        $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
        $currentUser = '';
        if( Yii::app()->user->id )
           $currentUser = $this->loadModel(Yii::app()->user->id);

        try
        {
            $task_tasker = new TaskTasker();
            $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID => $task_id));
            $proposals = $task_tasker->getProposalsOfTasks( $task_id  ,'','','','','','','',array(),$sort,'','',true);
            $proposalIds = GetRequest::getAllProposalsIdsOfTask($proposals->getData());
            //$proposals = GetRequest::getProposalsByTask($task->{Globals::FLD_NAME_TASK_ID},$task->{Globals::FLD_NAME_CREATER_USER_ID} , Globals::DEFAULT_VAL_TASK_DETAIL_PORPOSAL_SIDE_BAR_LIMIT ); 
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id) );
        }
        try
        {
            $relatedTask = Task::getRelatedTaskListByTypeandCategory($taskType,$task,$task_id,$taskSkills);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id) );
        }
        try
        {
            $isTaskerSelected =  TaskTasker::isTaskerSelectedForTask ($task->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id) );
        }             //print_r($relatedTask);
        
        $this->layout = '//layouts/noheader';
        if($isTaskerSelected)
        {
                $this->render('projectdetail_doer',
                    array( 'task'=>$task,
                            'model'=>$model,
                            'question'=>$question,
                            'taskQuestionReply'=>$taskQuestionReply,
                            'key'=>$key,
                            'taskTasker'=>$taskTasker,
                            'taskLocation' => $taskLocation,
                            'proposals'=>$proposals,
                            'relatedTask'=>$relatedTask,
                            'taskType'=>$taskType,
                            'proposalIds' => $proposalIds,
                            'currentUser'=>$currentUser,
                            'message' => $message,
                            'messagesOnTask' => $messagesOnTask,
                            'attachments' => $attachments
                        ));
        }
        else
        {
            $this->render('projectdetail',
                    array( 'task'=>$task,
                            'model'=>$model,
                            'question'=>$question,
                            'taskQuestionReply'=>$taskQuestionReply,
                            'key'=>$key,
                            'taskTasker'=>$taskTasker,
                            'taskLocation' => $taskLocation,
                            'proposals'=>$proposals,
                            'relatedTask'=>$relatedTask,
                            'taskType'=>$taskType,
                            'proposalIds' => $proposalIds,
                            'currentUser'=>$currentUser,
                            'message' => $message,
                            'messagesOnTask' => $messagesOnTask,
                            'attachments' => $attachments
                ));
        }
        
        CommonUtility::endProfiling();

    }
    public function actionApplyForTask()
    {
        CommonUtility::startProfiling();        
        $task_id = $_POST[Globals::FLD_NAME_TASKID];   
        @$task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER_ID]; 
        @$taskList = $_POST['taskList']; 
        if(!isset($taskList))
        {
            $taskList = 'true';
        }
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//        Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;                
        
        $task = Task::model()->with('taskcategory','category','categorylocale')->findByPk($task_id);
        
        $taskType = $task->{Globals::FLD_NAME_TASK_KIND};
        if(isset($task_tasker_id))
        {
            $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);;
        }
        else
        {
            $taskTasker = new TaskTasker();
        }
        //print_r($taskTasker);
        $taskTasker->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
        
        $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
        
        $isProposed = TaskTasker::isUserProposed(Yii::app()->user->id, $task->{Globals::FLD_NAME_TASK_ID}, $model->user_id);
        
        $taskQuestionReply = new TaskQuestionReply();
        
        $taskQuestionReply->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
        
        $task_tasker = new TaskTasker();
        $bidStatus = ($taskType == Globals::DEFAULT_VAL_I) ? 
                UtilityHtml::getBidStatusInstant($task->{Globals::FLD_NAME_END_TIME}) :                       
                UtilityHtml::getBidStatus($task->{Globals::FLD_NAME_TASK_FINISHED_ON});
        
        $isInvited =   TaskTasker::isTaskerInvitedForTask( $task->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id);
                
        $currentUser = '';
        if( Yii::app()->user->id )
           $currentUser = $this->loadModel(Yii::app()->user->id);
        
        $proposal = $this->renderPartial('//poster/_proposal', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply, 'isProposed' => $isProposed,   'currentUser'=>$currentUser,'bidStatus' => $bidStatus,'isInvited'=>$isInvited , 'taskList' => $taskList) , true , true);
        echo  $error = CJSON::encode(array(
                                            'status'=>'success',
                                            'html'=>$proposal,
                                            'title'=> " - ".$task->{Globals::FLD_NAME_TITLE},
                                    ));
        CommonUtility::endProfiling();
    }
    
     /**
    * upload attachments in task detail page for doer or poster
    * @params task_id , tasker_id , files
    * @return json success
    * @var
    */
     public function actionUploadFileInTaskDetail()
    {
        CommonUtility::startProfiling();
        if(isset($_POST[Globals::FLD_NAME_TASK]))
        {
            $task_id =  $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
            $tasker_id =  $_POST['currentaskers'];
            $task = Task::model()->findByPk($task_id);
            $model = $this->loadModel(Yii::app()->user->id);
            $taskTasker = TaskTasker::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id , Globals::FLD_NAME_TASKER_ID => $tasker_id ));
           // echo $task->{Globals::FLD_NAME_END_TIME};
           // echo CommonUtility::leftTimingInstant($task->{Globals::FLD_NAME_END_TIME});
            try
            {
                $fileInfo = CJSON::decode($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS});
                          
                if(isset($_POST[Globals::FLD_NAME_PROPOSALATTACHMENTS]))
                {
                        foreach ($_POST[Globals::FLD_NAME_PROPOSALATTACHMENTS] as $attachfile)
                        {
                                try
                                {
                                        $extension = CommonUtility::getExtension($attachfile);
                                }
                                catch(Exception $e)
                                {             
                                        $msg = $e->getMessage();
                                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                }
                                try
                                {
                                        $type = CommonUtility::getFileType($extension);
                                }
                                catch(Exception $e)
                                {             
                                        $msg = $e->getMessage();
                                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                }
                                $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$attachfile;
                                $attachment[Globals::FLD_NAME_TYPE]=$type;
                                $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                                $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
                                $attachment[Globals::FLD_NAME_UPLOADED_BY]= Yii::app()->user->id;
                                $filename = explode('.', $attachfile);
                                $attachment[Globals::FLD_NAME_FILESIZE]= $_POST[$filename[0]."_size"];
                                $attachment[Globals::FLD_NAME_IS_PUBLIC]= Globals::DEFAULT_VAL_0;
                                try
                                {
                                    $moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$attachfile);
                                }
                                catch(Exception $e)
                                {             
                                        $msg = $e->getMessage();
                                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                }
                                $fileInfo[]=$attachment;

                                if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
                                { 
                                        try
                                        {
                                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
                                        }
                                        catch(Exception $e)
                                        {             
                                                $msg = $e->getMessage();
                                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                        }
                                        try
                                        {
                                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
                                        }
                                        catch(Exception $e)
                                        {             
                                                $msg = $e->getMessage();
                                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                        }
                                        try
                                        {
                                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                                        }
                                        catch(Exception $e)
                                        {             
                                                $msg = $e->getMessage();
                                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                        }
                                        try
                                        {
                                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                                        }
                                        catch(Exception $e)
                                        {             
                                                $msg = $e->getMessage();
                                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                        }
                                }
                        }
                        
                        $files = CJSON::encode( $fileInfo );
                        
                        $taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS} = $files;
                        $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER} += $_POST['uploadProposalAttachments_totalFileSizeUsed'];
                        $task->{Globals:: FLD_NAME_SPACE_QUOTA_DOER} +=  $_POST['uploadProposalAttachments_totalFileSizeUsed'];

                    }
                    try
                    {
                        if(! $taskTasker->update())
                        {   
                                throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                        }
                        $insertedId=$taskTasker->getPrimaryKey(); 
                        if(! $task->update())
                        {   
                                throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                        }
                        echo  $error = CJSON::encode(array(
                                                            'status'=>'save_success_message',
                                                            'task_id'=>$task_id,
                                                            'task_tasker_id'=>$insertedId,
                                                            ));
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $task_id ,"Task Tasker ID " => $insertedId ) );
                    }    

        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
        }
    }

    CommonUtility::endProfiling();
}
        
 /**
    * delete uploaded file by uplopaded user 
    * @params filename , task_is , tasker_id
    * @return json success msg
    * @var
    */
     public function actionDeleteUploadedFile()
    {
        CommonUtility::startProfiling();
        try
        {
            $task_id =  $_GET[Globals::FLD_NAME_TASK_ID];
            $tasker_id =  $_GET[Globals::FLD_NAME_TASKER_ID];
            $fileName =  $_GET[Globals::FLD_NAME_FILE];
            $task = Task::model()->findByPk($task_id);
            $taskTasker = TaskTasker::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id , Globals::FLD_NAME_TASKER_ID => $tasker_id ));
            $fileSize = 0;
            $files = CJSON::decode($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS});
            foreach($files as $index => $file)
            {
                //echo $file[Globals::FLD_NAME_FILE];
                if($file[Globals::FLD_NAME_FILE] == $fileName )
                {
                  //  echo $fileName;
                    //echo $index;
                        $fileSize = $file[Globals::FLD_NAME_FILESIZE];
                        $filePath = Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR.$fileName;
                        $fileData = explode('/',$fileName);
                        CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$fileData[0],$fileData[1]);
                       // @unlink($filePath);
                        unset($files[$index]);
                  
                }
            }
            try
            {
                $taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS} = CJSON::encode($files);
                $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER} -= $fileSize;
                $task->{Globals:: FLD_NAME_SPACE_QUOTA_DOER} -=  $fileSize;
                        
                if(! $taskTasker->update())
                {   
                        throw new Exception(Yii::t('poster_saveproposal','remove image task tasker'));   
                }
                $insertedId=$taskTasker->getPrimaryKey(); 
                if(! $task->update())
                {   
                        throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                }
                echo  $error = CJSON::encode(array(
                                                    'status'=>'success',
                                                    'task_id'=>$task_id,
                                                    'task_tasker_id'=>$insertedId,
                                                    ));
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $task_id ,"Task Tasker ID " => $insertedId ) );
            } 
           // echo $fileName;
//            $fileInfo[Globals::FLD_NAME_FILE][]
//            if(!in_array($image, $_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
//                        {
//                            //echo $image;
//                            $filePath = Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR.$model->profile_folder_name."/".$image;
//                            @unlink($filePath);
//                        }
            
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
    * bulk actions on files  
    * @params  task_id , tasker_id form data
    * @return json success msg
    * @var
    */
     public function actionBulkActionUploadedFile()
    {
        CommonUtility::startProfiling();
        try
        {
            $task_id =  $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
            $tasker_id =  $_POST['currentaskers'];
            $filesAction =  $_POST['filesAction'];
            $filesName =  $_POST[Globals::FLD_NAME_FILE];
            
            $task = Task::model()->findByPk($task_id);
            $taskTasker = TaskTasker::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id , Globals::FLD_NAME_TASKER_ID => $tasker_id ));
            $fileSize = 0;
            $files = CJSON::decode($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS});
            if($filesAction == 'delete')
            {
                $fileDeleted = 0;
                $fileNotDeleted = 0;
                $fileSize = 0;
                foreach($files as $index => $file)
                {
                    if(in_array($file[Globals::FLD_NAME_FILE], $filesName))
                    {
                        if($file[Globals::FLD_NAME_UPLOADED_BY] == Yii::app()->user->id )
                        {
                            $fileSize += $file[Globals::FLD_NAME_FILESIZE];
                            $filePath = Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR.$file[Globals::FLD_NAME_FILE];
                            $fileData = explode('/',$file[Globals::FLD_NAME_FILE]);
                            CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$fileData[0],$fileData[1]);
                            unset($files[$index]);
                            $fileDeleted++;
                        }
                        
                    }
                    
                    
                }
               $totalFiltes =  count($filesName);
               $fileNotDeleted = $totalFiltes - $fileDeleted;
                try
                {
                    $taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS} = CJSON::encode($files);
                    $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER} -= $fileSize;
                    $task->{Globals:: FLD_NAME_SPACE_QUOTA_DOER} -=  $fileSize;

                    if(! $taskTasker->update())
                    {   
                            throw new Exception(Yii::t('poster_saveproposal','remove image task tasker'));   
                    }
                    $insertedId=$taskTasker->getPrimaryKey(); 
                    if(! $task->update())
                    {   
                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                    }
                    echo  $error = CJSON::encode(array(
                                                        'status'=>'success',
                                                        'fileDeleted'=>$fileDeleted,
                                                        'fileNotDeleted'=>$fileNotDeleted,
                                                        ));
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $task_id ,"Task Tasker ID " => $insertedId ) );
                } 
            }
            
            
          
           // echo $fileName;
//            $fileInfo[Globals::FLD_NAME_FILE][]
//            if(!in_array($image, $_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
//                        {
//                            //echo $image;
//                            $filePath = Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR.$model->profile_folder_name."/".$image;
//                            @unlink($filePath);
//                        }
            
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
    * get information related to tasker
    * @params  task_id , tasker_id 
    * @return json taker info
    * @var
    */
     public function actionGetTaskerDetails()
    {
        CommonUtility::startProfiling();
        $tasker_id = $_POST[Globals::FLD_NAME_TASKER_ID];
        $task_id =  $_POST[Globals::FLD_NAME_TASK_ID];
        $task = Task::model()->findByPk($task_id);
        $taskTasker = TaskTasker::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id , Globals::FLD_NAME_TASKER_ID => $tasker_id ));
        
        try
        {
           $user = User::model()->findByPk($tasker_id);
           
           
           $userData['firstname'] = $user->{Globals::FLD_NAME_FIRSTNAME};
           $userData['lastname'] = $user->{Globals::FLD_NAME_LASTNAME};
           $userData['name'] = CommonUtility::getUserFullName($tasker_id);
           $userData['taskerprofile'] = CommonUtility::getTaskerProfileURI( $tasker_id );
           $userData['image'] = CommonUtility::getThumbnailMediaURI($tasker_id, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_100);
           
           $spaceQuataUsed = round($taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER} /(1024 *1024));
           $totalSpaceAllowed = LoadSetting::getSettingValue(Globals::SETTING_KEY_SPACE_QUOTA_ALLOWED);
           
           $userData['spacequotabar'] = ( $spaceQuataUsed  / $totalSpaceAllowed )* 100;
           $userData['spacequota'] = CommonUtility::getFormatSizeUnitsFromBytes($taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER});
           $userData['spacequotainbites'] = $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER};
           $userData['status'] = 'success';
           echo CJSON::encode($userData);
           
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
    * thankyou action after posting project
    * @params task_id
    * @return 
    * @var
    */
     public function actionThankYouAfterPostingProject()
    {
        CommonUtility::startProfiling();
        try
        {
            $task_id = $_GET[Globals::FLD_NAME_TASK_ID];
            $task=Task::model()->findByPk($task_id);
            //code
                $this->layout = '//layouts/noheader';
                $this->render('thankyou_afterposting',
                    array( 
                        'task' => $task
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
    * accept proposal by poster
    * @params task_tasker_id
    * @return json success or error msg
    * @var
    */
    public function actionProposalAccept()
    {
            CommonUtility::startProfiling();
            if(isset($_POST[Globals::FLD_NAME_INBOX]))
            {
                
                $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASK_TASKER_ID]; // get task tasker id
                $message = new Inbox();
                $messageFlow = new InboxUser();
                $message->scenario = 'approve_proposal';
                $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
                $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
                //process validation
                if(Yii::app()->request->isAjaxRequest)
                {
                    $error =  CActiveForm::validate(array($message));
                    if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                    {
                            CommonUtility::setErrorLog($message->getErrors(),get_class($message));
                            echo $error;
                            Yii::app()->end();
                    }
                }
//            try
//            {
//                $proposals = GetRequest::getProposalsByTask($task->{Globals::FLD_NAME_TASK_ID},$task->{Globals::FLD_NAME_CREATER_USER_ID} , Globals::DEFAULT_VAL_TASK_DETAIL_PORPOSAL_SIDE_BAR_LIMIT );    
//            }
//            catch(Exception $e)
//            {             
//                $msg = $e->getMessage();
//                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
//            }
                $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                if($taskTasker)
                {

                    $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_HIRING;
                    $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER} += $task->{Globals::FLD_NAME_SPACE_QUOTA_USED};
                    
                    try
                    {
                        //update task tasker info
                        if( !$taskTasker->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        // updating task proposal count
                        $task->{Globals::FLD_NAME_PROPOSALS_ACCPT_CNT} += 1;
                        if( !$task->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        $taskCreatorUserId = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_CREATER_USER_ID];
                        // send initial message to doer
                        $message->{Globals::FLD_NAME_TO_USER_IDS} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_TO_USER_IDS]; 
                        $message->{Globals::FLD_NAME_MSG_TYPE} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_MSG_TYPE];
                        $message->{Globals::FLD_NAME_TASK_ID} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                        $message->{Globals::FLD_NAME_FROM_USER_ID} = Yii::app()->user->id;
                        $message->{Globals::FLD_NAME_SUBJECT} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_SUBJECT];
                        $message->{Globals::FLD_NAME_IS_PUBLIC} = Globals::DEFAULT_VAL_MSG_IS_PUBLIC_INACTIVE;
                        $message->{Globals::FLD_NAME_BODY} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_BODY];
                        if(!$message->save())
                        {                            
                            throw new Exception("Unexpected error !!! save message..");
                        }
                        $insertedId = $message->getPrimaryKey();
                        // message flow for poser
                        $messageFlow->{Globals::FLD_NAME_USER_ID} = $taskCreatorUserId;
                        $messageFlow->{Globals::FLD_NAME_MSG_FLOW} = Globals::DEFAULT_VAL_MSG_FLOW_SENT;
                        $messageFlow->{Globals::FLD_NAME_MSG_ID} = $insertedId;
                        $messageFlow->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_READ;
                        if(!$messageFlow->save())
                        {                            
                            throw new Exception("Unexpected error !!! save message flow of user...");
                        }
                        
                        // message flow for doer
                        $messageFlowRecived = new InboxUser();
                        $messageFlowRecived->{Globals::FLD_NAME_USER_ID} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_TO_USER_IDS]; 
                        $messageFlowRecived->{Globals::FLD_NAME_MSG_FLOW} = Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED;
                        $messageFlowRecived->{Globals::FLD_NAME_MSG_ID} = $insertedId;
                        $messageFlowRecived->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_NOT_READ;
                        if(!$messageFlowRecived->save())
                        {                            
                            throw new Exception("Unexpected error !!! save message flow recived of user...");
                        }
                        // send notification to doer
                        $alert = new UserAlert();
                        try
                        {
                            $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                        }
                        $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                        $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_ACCEPT_PROPOSAL;
                        $alert->{Globals::FLD_NAME_FOR_USER_ID} = $taskTasker->{Globals::FLD_NAME_TASKER_ID};   
                        $alert->{Globals::FLD_NAME_BY_USER_ID} = Yii::app()->user->id; 
                        $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                        $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        if(!$alert->save())
                        {   
                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                        }
                        // add user activity
                        $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
                                                //  Globals::FLD_NAME_COMMENTS => '',
                                            );
                        try
                        {
                            CommonUtility::addTaskActivity($taskTasker->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_ACCEPT , $otherInfo );
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                        }
                        $html = $this->renderPartial('//tasker/_hireme',array('tasker_status' => $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} , 'tasker_id' => $taskTasker->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $task_tasker_id ) , true);
                        echo $error = CJSON::encode(array(
                                'status'=>'success',
                                'html'=>$html
                        ));
                }
                catch(Exception $e)
                {
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "Task Tasker ID " => $task_tasker_id ) );
                }
            }
        }
           
        CommonUtility::endProfiling();
    }
    /**
    * accept hiring offer by doer
    * @params task_tasker_id
    * @return json success or error
    * @var
    */
    public function actionAcceptHiringOffer()
    {
            CommonUtility::startProfiling();
            if(isset($_POST[Globals::FLD_NAME_INBOX]))
            {
                
                $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASK_TASKER_ID];
                $message = new Inbox();
                $messageFlow = new InboxUser();
                $message->scenario = 'approve_proposal';
                $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
                $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
                if(Yii::app()->request->isAjaxRequest)
                {
                    $error =  CActiveForm::validate(array($message));
                    if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                    {
                            CommonUtility::setErrorLog($message->getErrors(),get_class($message));
                            echo $error;
                            Yii::app()->end();
                    }
                }

                $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                if($taskTasker)
                {
                    $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_SELECTED;
                    
                    try
                    {
                        //update task tasker
                        if( !$taskTasker->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        //update task status
                        $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_TASK_STATE_ASSIGNED;
                        $task->{Globals::FLD_NAME_TASK_ASSIGNED_ON} = new CDbExpression('NOW()');
                        if( !$task->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        $taskCreatorUserId = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_CREATER_USER_ID];
                        //// add message
                        $message->{Globals::FLD_NAME_TO_USER_IDS} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_TO_USER_IDS]; 
                        $message->{Globals::FLD_NAME_MSG_TYPE} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_MSG_TYPE];
                        $message->{Globals::FLD_NAME_TASK_ID} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                        $message->{Globals::FLD_NAME_FROM_USER_ID} = Yii::app()->user->id;
                        $message->{Globals::FLD_NAME_SUBJECT} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_SUBJECT];
                        $message->{Globals::FLD_NAME_IS_PUBLIC} = Globals::DEFAULT_VAL_MSG_IS_PUBLIC_INACTIVE;
                        $message->{Globals::FLD_NAME_BODY} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_BODY];
                        if(!$message->save())
                        {                            
                            throw new Exception("Unexpected error !!! save message..");
                        }
                        $insertedId = $message->getPrimaryKey();
                        //// message flow for poster
                        $messageFlow->{Globals::FLD_NAME_USER_ID} = $taskCreatorUserId;
                        $messageFlow->{Globals::FLD_NAME_MSG_FLOW} = Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED;
                        $messageFlow->{Globals::FLD_NAME_MSG_ID} = $insertedId;
                        $messageFlow->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_NOT_READ;
                        if(!$messageFlow->save())
                        {                            
                            throw new Exception("Unexpected error !!! save message flow of user...");
                        }
                        
                         //// message flow for doer
                        $messageFlowRecived = new InboxUser();
                        $messageFlowRecived->{Globals::FLD_NAME_USER_ID} = Yii::app()->user->id;
                        $messageFlowRecived->{Globals::FLD_NAME_MSG_FLOW} = Globals::DEFAULT_VAL_MSG_FLOW_SENT;
                        $messageFlowRecived->{Globals::FLD_NAME_MSG_ID} = $insertedId;
                        $messageFlowRecived->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_READ;
                        if(!$messageFlowRecived->save())
                        {                            
                            throw new Exception("Unexpected error !!! save message flow recived of user...");
                        }
                         //// send notification to poster
                        $alert = new UserAlert();
                        try
                        {
                            $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                        }
                        $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                        $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_HIRING_OFFER_ACCEPT;
                        $alert->{Globals::FLD_NAME_FOR_USER_ID} = $taskCreatorUserId;
                        $alert->{Globals::FLD_NAME_BY_USER_ID} = Yii::app()->user->id; 
                        $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                        $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        if(!$alert->save())
                        {   
                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                        }
                        
                        //// add to user activity
                        $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
                                                //  Globals::FLD_NAME_COMMENTS => '',
                                            );
                        try
                        {
                            CommonUtility::addTaskActivity($taskTasker->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_HIRING_OFFER_ACCEPT , $otherInfo );
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( 'hideoutput' => true ,"User ID" => Yii::app()->user->id , "Task Tasker ID" => $task_tasker_id) );
                        }

                        //$html = $this->renderPartial('//tasker/_hireme',array('tasker_status' => $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} , 'tasker_id' => $taskTasker->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $task_tasker_id ) , true);
                        echo $error = CJSON::encode(array(
                                'status'=>'success',
                              //  'html'=>$html
                        ));
                }
                        
             
                catch(Exception $e)
                {
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "Task Tasker ID " => $task_tasker_id ) );
                }
            }
            }
           
            CommonUtility::endProfiling();
    }
     /**
    * accept hiring offer by doer
    * @params task_tasker_id
    * @return json success or error
    * @var
    */
    public function actionRejectHiringOffer()
    {
        CommonUtility::startProfiling();
             
        $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASK_TASKER_ID];
        $message = new Inbox();
        $messageFlow = new InboxUser();

        $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
        $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});

        $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        if($taskTasker)
        {
            $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_REJECTED;

            try
            {
                //update task tasker
                if( !$taskTasker->update())
                {   
                        throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                }
                  $taskCreatorUserId = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_CREATER_USER_ID];

                 //// send notification to poster
                $alert = new UserAlert();
                try
                {
                    $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                }
                $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_HIRING_OFFER_REJECT;
                $alert->{Globals::FLD_NAME_FOR_USER_ID} = $taskCreatorUserId;
                $alert->{Globals::FLD_NAME_BY_USER_ID} = Yii::app()->user->id; 
                $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                if(!$alert->save())
                {   
                    throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                }
                //$html = $this->renderPartial('//tasker/_hireme',array('tasker_status' => $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} , 'tasker_id' => $taskTasker->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $task_tasker_id ) , true);
                echo $error = CJSON::encode(array(
                        'status'=>'success',
                      //  'html'=>$html
                ));
            }
            catch(Exception $e)
            {
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "Task Tasker ID " => $task_tasker_id ) );
            }
        }
        CommonUtility::endProfiling();
    }
    //
//======================================================================================================================================
//======================================================================================================================================
//======================================================================================================================================
    /**
    * demo action 
    * @params no parameters
    * @return string demo action does not return anything
    * @var
    */
     public function actionDemo()
    {
        CommonUtility::startProfiling();
        try
        {
            //code
        }
        catch(Exception $e)
        {     
            //catch exception
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg );
        }
        CommonUtility::endProfiling();
    }
    
    
    public function actiontaskpreview()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('taskpreview','application.controller.PosterController');
        }
        $this->render('taskpreview');
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('taskpreview','application.controller.PosterController');
        }
    }

   
        
    public function loadModel($id)
    {
            $model=User::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,Yii::t('poster_createtask','page_not_exist'));
            return $model;
    }
    public function actionCreateTaskBackup()
    {	
        try
        {
            //echo $_GET['test'];
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('CreateTask','application.controller.PosterController');
            }
            if (CommonUtility::IsTraceEnabled())
            {
                Yii::trace('Executing actionCreateTask() method','PosterController');
            }
            if (CommonUtility::IsDebugEnabled())
            {
                Yii::log('Successfully Page Loaded', CLogger::LEVEL_INFO, 'PosterController.CreateTask');
            }
            $this->render('createtaskbackup');
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('CreateTask');
            }
        }
        catch(Exception $e)
        {
            
            if (CommonUtility::IsTraceEnabled())
            {
                    Yii::trace('Executing actionCreateTaskBackup() method','PosterController');
            }
            Yii::log('Poster.CreateTask: reason '.$e->getMessage(),CLogger::LEVEL_ERROR ,'PosterController');
        }
    }
   
   
    
    public function actionLoadVirtualTaskPreview()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('LoadVirtualTaskPreview','application.controller.PosterController');
            }
            $task_id = $_POST[Globals::FLD_NAME_TASKID];
            $key = '';
            if(isset($_POST[Globals::FLD_NAME_KEY]))
            {
                $key = $_POST[Globals::FLD_NAME_KEY];
            }
            $category_id  = $_POST[Globals::FLD_NAME_CATEGORY_ID];

            $task=Task::model()->findByPk($task_id);
            $model=$this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
            try
            {
                    $category = Category::getCategoryListByID($category_id);
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id,"Category ID" =>$category_id) );

            }
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
            $this->renderPartial('partial/_virtualtaskpreview', 
                                    array( 'task'=>$task,
                                            'model'=>$model,
                                            'category'=>$category,
                                            'key'=>$key
                                            ),false,true);
			
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('LoadVirtualTaskPreview');
            }
    }
    public function actionLoadInpersonTaskPreview()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('LoadInpersonTaskPreview','application.controller.PosterController');
            }
            $task_id = $_POST[Globals::FLD_NAME_TASKID];
            $category_id  = $_POST[Globals::FLD_NAME_CATEGORY_ID];
            $task=Task::model()->findByPk($task_id);
            $model=$this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
            
            try
            {
                    $category = Category::getCategoryListByID($category_id);
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id,"Category ID" =>$category_id) );

            }
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
            $this->renderPartial('inpersontaskpreview', 
                                    array( 'task'=>$task,
                                            'model'=>$model,
                                            'category'=>$category
                                            ),false,true);
		
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('LoadInpersonTaskPreview');
            }
    }
    public function actionLoadInstantTaskPreview()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('LoadInstantTaskPreview','application.controller.PosterController');
            }
            $task_id = $_POST[Globals::FLD_NAME_TASKID];
            $category_id  = $_POST[Globals::FLD_NAME_CATEGORY_ID];
            $task=Task::model()->findByPk($task_id);
            $model=$this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
            
			try
			{
				$category = Category::getCategoryListByID($category_id);
			}
			catch(Exception $e)
			{             
				$msg = $e->getMessage();
				CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id,"Category ID" =>$category_id) );
			   
			}
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
			$this->renderPartial('instanttaskpreview', 
						array( 'task'=>$task,
							'model'=>$model,
							'category'=>$category
							),false,true);
			
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('LoadInstantTaskPreview');
            }
    }
        
    public function actionSaveInpersonTask()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('SaveInpersonTask','application.controller.PosterController');
        }
        $model=$this->loadModel(Yii::app()->user->id);
        $task = new Task();
                    //print_r($task);exit;
        $taskCategory = new TaskCategory();
        $taskLocation = new TaskLocation();
        $task->scenario = Globals::INPERSON_TASK;
        if(isset($_POST[Globals::FLD_NAME_TASK]))
        {
//                    $fordeletererows = array();
//                    $fordeletere = array();
			if(Yii::app()->request->isAjaxRequest)
			{
					$error =  CActiveForm::validate(array($task,$taskLocation));
											// print_r($error);exit;
					if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
					{
						// For logging 
						CommonUtility::setErrorLog($task->getErrors(),get_class($task));
						echo $error;

						Yii::app()->end();
					}


			}
            try
            { 
                if($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_ID_SOURCE] == 1)
                {
                    $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_USER;

                }
                else if($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_ID_SOURCE] == 0)
                {
                    $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_AUTO;
                }
                else
                {
                    $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_BID;
                }
                $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                $task->attributes=$_POST[Globals::FLD_NAME_TASK];
                @$to_publish = $_GET[Globals::FLD_NAME_PUBLIC];
                if(isset($to_publish))
                {
                    $task->{Globals::FLD_NAME_VALID_FROM_DT} = date(Globals::DEFAULT_VAL_DATE_FORMATE_YMD);

                }
                try
                {
                        //$task->{Globals::FLD_NAME_TASK_FINISHED_ON}=CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON]);
                        $task->{Globals::FLD_NAME_TASK_FINISHED_ON}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON];
             
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                }
                $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_O;

                $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                $task->{Globals::FLD_NAME_CREATOR_ROLE}=Globals::DEFAULT_VAL_P;
                $task->{Globals::FLD_NAME_TASK_KIND}=Globals::DEFAULT_VAL_P;
                $task->{Globals::FLD_NAME_PAYMENT_MODE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PAYMENT_MODE];
                    $task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                {
                    foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE] as $image)
                    {
                        try
                        {
                            $extension = CommonUtility::getExtension($image);
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                        }
                        try
                        {
                            $type = CommonUtility::getFileType($extension);
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                        }
						
                        $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$image;
                        $attachment[Globals::FLD_NAME_TYPE]=$type;
                        $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                        $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
						try
						{
                        	$moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
						}
                        $fileInfo[]=$attachment;
						
                        if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
                        {
                            try
                            {
                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                            }
                            try
                            {
                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                            }
                            try
                            {
                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                            }
                            try
                            {
                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                            }
                        }
                    }
                    $files = CJSON::encode( $fileInfo );
                    $task->{Globals::FLD_NAME_TASK_ATTACHMENTS}=$files;
                }
                                                           
                    if(!$task->save())
                    {                            
                        throw new Exception(Yii::t('poster_saveinpersontask','unexpected_error'));
                    }
                    $insertedId = $task->getPrimaryKey();
                    $model->{Globals::FLD_NAME_TASK_POST_CNT} += 1;
                    $model->{Globals::FLD_NAME_TASK_POST_TOTAL_PRICE} += $task->{Globals::FLD_NAME_PRICE};
                    $model->{Globals::FLD_NAME_TASK_POST_TOTAL_HOURS} += $task->{Globals::FLD_NAME_WORK_HRS};
                    if( !$model->update())
                    {   
                        throw new Exception(Yii::t('poster_savevirtualtask','unexpected_error'));
                    }
//                            $fordeletere[Globals::FLD_NAME_TABLE_NAME] = get_class($task);
//                            $fordeletere[Globals::FLD_NAME_PRIMARY_KEY] = $task->tableSchema->primaryKey;;
//                            $fordeletere[Globals::FLD_NAME_PRIMARY_KEY_VALUE] = $insertedId;
//                            $fordeletererows[] = $fordeletere;

                        $taskCategory->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                        $taskCategory->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                        $taskCategory->{Globals::FLD_NAME_CATEGORY_ID} = $category_id;
                        $taskCategory->{Globals::FLD_NAME_STATUS}  = Globals::DEFAULT_VAL_O;
                                                $taskCategory->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;

                        if(!$taskCategory->save())
                        {                            
                            throw new Exception(Yii::t('poster_saveinpersontask','unexpected_error'));
                        }


                    $taskLocation->{Globals::FLD_NAME_TASK_ID}  = $insertedId;

//                                $insertedIdcat=$taskCategory->getPrimaryKey();

//                                $fordeletere[Globals::FLD_NAME_TABLE_NAME] = get_class($taskCategory);
//                                $fordeletere[Globals::FLD_NAME_PRIMARY_KEY] = 'task_id';
//                                $fordeletere[Globals::FLD_NAME_PRIMARY_KEY_VALUE] = $insertedId;
//                                $fordeletererows[] = $fordeletere;

                    $taskLocation->attributes = $_POST[Globals::FLD_NAME_TASK_LOCATION];
                    @$skills = $_POST[Globals::FLD_NAME_MULTISKILLS];
                    if($skills)
                    {
                        foreach ($skills as $skill)
                        {
                            $taskSkill = new TaskSkill();
                            $taskSkill->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                            $taskSkill->{Globals::FLD_NAME_SKILL_ID}  = $skill;
                                                            $taskSkill->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                            if(!$taskSkill->save())
                            {                            
                                    throw new Exception(Yii::t('poster_saveinpersontask','unexpected_error'));
                            }
                            //echo $skill;

                        }
                    }
                    @$questions = $_POST[Globals::FLD_NAME_MULTI_CAT_QUESTION];
                    if($questions)
                    {
                        foreach ($questions as $question)
                        {
                            $taskQuestion = new TaskQuestion();
                            $taskQuestion->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                            $taskQuestion->{Globals::FLD_NAME_QUESTION_ID}  = $question;
                                                            $taskQuestion->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                            if(!$taskQuestion->save())
                            {                            
                                    throw new Exception(Yii::t('poster_saveinpersontask','unexpected_error'));
                            }
                            //echo $question;
                        }
                    }
                // exit;

                    if(!$taskLocation->save())
                    {                            
                        throw new Exception(Yii::t('poster_saveinpersontask','unexpected_error'));
                    }

//                                    print_r($fordeletererows);
//                                    CommonUtility::forDeleteRows($fordeletererows);                                            
//                                    exit();
                    $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::TASK_ACTIVITY_SUBTYPE_TASK_INPERSON,
                                            //  Globals::FLD_NAME_COMMENTS => '',
                                        );
					try
					{
						CommonUtility::addTaskActivity($insertedId , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_CREATE , $otherInfo );
					}
					catch(Exception $e)
					{             
						$msg = $e->getMessage();
						CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
					}
                    
				
                    if(isset($to_publish))
                    {
                        if( $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::DEFAULT_VAL_AUTO ) 
                        {
                            $limit = Globals::DEFAULT_VAL_AUTO_INVATATION_BY_SYSTEM; 
                            $autoInvitation = GetRequest::autoInvitation( $insertedId , $category_id , $limit );
                            if(empty($autoInvitation))
                            {
                                    //throw new Exception(Yii::t('poster_saveinperson','unexpected_error'));
                            }
                        }
                    }
                    echo  $error = CJSON::encode(array(
                            'status'=>'success',
                            'task_id'=> $insertedId,
                            'category_id'=> $category_id
                        ));

                        //echo 'hiii';

                }
                catch(Exception $e)
                {
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $insertedId ,"User ID" => Yii::app()->user->id) );
                        
                }
        }

        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('SaveInpersonTask');
        }

    }
    public function actionPublishTask()
    {
        if(CommonUtility::IsProfilingEnabled())
        { 
            Yii::beginProfile('PublishTask','application.controller.PosterController');
        }
        if(isset($_POST[Globals::FLD_NAME_TASK]))
        {
            try
            {
                $task_id = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                $task = Task::model()->findByPk($task_id);
                $category_id = $_POST[Globals::FLD_NAME_TASK_CATEGORY_ID];
                $task->{Globals::FLD_NAME_VALID_FROM_DT} = date(Globals::DEFAULT_VAL_DATE_FORMATE_YMD);
                if( $task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_V )
                {
                    $task->{Globals::FLD_NAME_BID_START_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                    $task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime($task->{Globals::FLD_NAME_BID_DURATION} ));
                    $task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                }  
                if( !$task->save() )
                {
                            throw new Exception(Yii::t('poster_publishtask','unexpected_error'));
                }
                $insertedId=$task->getPrimaryKey();
                if( $task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_V )
                {
                    $activity_subtype = Globals::TASK_ACTIVITY_SUBTYPE_TASK_VIRTUAL;
                }
                elseif( $task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_P )
                {
                    $activity_subtype = Globals::TASK_ACTIVITY_SUBTYPE_TASK_INPERSON;
                }
                else
                {
                    $activity_subtype = Globals::TASK_ACTIVITY_SUBTYPE_TASK_INSTANT;
                }
                $otherInfo = array( 
                                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => $activity_subtype ,
                                        //  Globals::FLD_NAME_COMMENTS => '',
                                    );
                try
                {
                    CommonUtility::addTaskActivity($insertedId , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_PUBLISH , $otherInfo );
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $insertedId ,"User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ) );
                } 
				
                if( $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::DEFAULT_VAL_AUTO ) 
                {
                    $limit = Globals::DEFAULT_VAL_AUTO_INVATATION_BY_SYSTEM; 
                   
                    try
                    {
                            GetRequest::autoInvitation( $task_id , $category_id , $limit );
                    }
                    catch(Exception $e)
                    {             
                                    $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $insertedId ,"User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                    } 
                }
                
                echo  $error = CJSON::encode(array(
                                                            'status'=>'success',
                                                            'tack_id'=>$insertedId,
                                                            'category_id'=>$category_id
                                                    ));
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $insertedId ,"User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                //                Yii::log($msg,CLogger::LEVEL_ERROR ,'PosterController.Templatedetail');

                } 

//                if($task->save())
//                {   
//                    $insertedId=$task->getPrimaryKey();
//                    echo  $error = CJSON::encode(array(
//                                        'status'=>'success',
//                                        'tack_id'=>$insertedId,
//                                        'category_id'=>$category_id
//                                    ));
//                }
        }
        if(CommonUtility::IsProfilingEnabled())
        { 
            Yii::endProfile('PublishTask');
        }
    }
    public function actionEditInpersonTask()
    {
        if(CommonUtility::IsProfilingEnabled())
        { 
            Yii::beginProfile('EditInpersonTask','application.controller.PosterController');
        }
        $model=$this->loadModel(Yii::app()->user->id);
        $task_id = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
        //$category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
        $task=Task::model()->findByPk($task_id);
        $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
        $taskCategory = TaskCategory::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
        $task->scenario = Globals::INPERSON_TASK;
        if(Yii::app()->request->isAjaxRequest)
        {
            $error =  CActiveForm::validate(array($task,$taskLocation));
            if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
            {
                //for logging
                CommonUtility::setErrorLog($task->getErrors(),get_class($task));
                echo $error;
                Yii::app()->end();
            }
        }

        if(isset($_POST[Globals::FLD_NAME_TASK]))
        {
            try
            {
                @$category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                $task->attributes=$_POST[Globals::FLD_NAME_TASK];
                @$to_publish = $_GET[Globals::FLD_NAME_PUBLIC];
                                    $task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                if(isset($to_publish))
                {
                    $task->{Globals::FLD_NAME_VALID_FROM_DT} = date(Globals::DEFAULT_VAL_DATE_FORMATE_YMD);
                    if( $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::DEFAULT_VAL_AUTO ) 
                    {
                        $limit = Globals::DEFAULT_VAL_AUTO_INVATATION_BY_SYSTEM; 
                        try
                        {   
                                if(isset($category_id))
                                GetRequest::autoInvitation( $task_id , $category_id , $limit );
                        }
                        catch(Exception $e)
                        {             
                                        $msg = $e->getMessage();
                                                CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $task_id ,"User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                        //                Yii::log($msg,CLogger::LEVEL_ERROR ,'PosterController.Templatedetail');

                        } 
                    }
                }
                if($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_ID_SOURCE] == 1)
                {
                    $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_USER;
                }
                else if($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_ID_SOURCE] == 0)
                {
                    $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_AUTO;
                }
                else
                {
                    $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_BID;
                }
                if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON]))
                {
                    try
                    {
                  //  $task->{Globals::FLD_NAME_TASK_FINISHED_ON}=CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON]);
                        $task->{Globals::FLD_NAME_TASK_FINISHED_ON} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON];			
                    
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                    }
                }
                $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_O;
                $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                $task->{Globals::FLD_NAME_CREATOR_ROLE}=Globals::DEFAULT_VAL_P;
                $task->{Globals::FLD_NAME_TASK_KIND}=Globals::DEFAULT_VAL_P;
                $task->{Globals::FLD_NAME_PAYMENT_MODE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PAYMENT_MODE];
                if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                {
                    foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE] as $image)
                    {
                        try
                        {
                                $extension = CommonUtility::getExtension($image);
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id,"Task ID" => $task_id) );
                        }
                        try
                        {
                                $type = CommonUtility::getFileType($extension);
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id , "Task ID" => $task_id) );
                        }
                        $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$image;
                        $attachment[Globals::FLD_NAME_TYPE]=$type;
                        $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                        $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
						try
						{
							$moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
						}
                        $fileInfo[]=$attachment;
                        if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
                        {
                            try
                            {
                                    CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                            }
                            try
                            {
                                    CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id , "Task ID" => $task_id) );
                            }
                            try
                            {
                                    CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                            }
                            try
                            {
                                    CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id , "Task ID" => $task_id) );
                            }
                        }
                    }
                    $files = CJSON::encode( $fileInfo );
                    $task->{Globals::FLD_NAME_TASK_ATTACHMENTS}=$files;
                }
                if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE]))
                {
                    foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE] as $image)
                    {

                        if(!in_array($image, $_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                        {
                            try
                            {
                                CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME},$image);
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id , "Task ID" => $task_id) );
                            }
                        }
                    }
                }
                
                    if( !$task->update())
                    {   
                        throw new Exception(Yii::t('poster_editinpersontask','unexpected_error'));
                    }
                    if(isset($category_id))
                    $taskCategory->{Globals::FLD_NAME_CATEGORY_ID} =$category_id;
                    $taskCategory->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                    if(!$taskCategory->update())
                    {
                            throw new Exception(Yii::t('poster_editinpersontask','unexpected_error'));
                    }
                    $insertedId=$task->getPrimaryKey();
                    $taskLocation->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                    $taskLocation->attributes = $_POST[Globals::FLD_NAME_TASK_LOCATION];
                    $taskLocation->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;

                   
                    @$skills = $_POST[Globals::FLD_NAME_MULTISKILLS];
                    if($skills)
                    {
                            // TaskSkill::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                            foreach ($skills as $skill)
                            {
                                $hasSkill = TaskSkill::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$insertedId , Globals::FLD_NAME_SKILL_ID => $skill ));
                                if(!$hasSkill)
                                {
                                    $taskSkill = new TaskSkill();
                                    $taskSkill->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                    $taskSkill->{Globals::FLD_NAME_SKILL_ID}  = $skill;
                                    $taskSkill->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                    if(!$taskSkill->save())
                                    {
                                            throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
                                    }
                                }

                                    //echo $skill;
                            }
                    }
                    @$questions = $_POST[Globals::FLD_NAME_MULTI_CAT_QUESTION];
                    if($questions)
                    {
                                //TaskQuestion::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                            foreach ($questions as $question)
                            {
                                $hasQuestion = TaskQuestion::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$insertedId , Globals::FLD_NAME_QUESTION_ID => $question ));
                                if(!$hasQuestion)
                                {
                                    $taskQuestion = new TaskQuestion();
                                    $taskQuestion->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                    $taskQuestion->{Globals::FLD_NAME_QUESTION_ID}  = $question;
                                    $taskQuestion->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                    if(!$taskQuestion->save())
                                    {
                                            throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
                                    }
                                }
                                                        //echo $question;
                            }
                    }
                    if( !$taskLocation->update())
                    {   
                            throw new Exception(Yii::t('poster_editinpersontask','unexpected_error'));
                    }
                    try
                    {
                            $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id , "Task ID" => $task_id) );
                    }
                    try
                    {
                        CommonUtility::sendAlertToAllTaskers( $insertedId , $alertType , Globals::ALERT_DESC_TASK_EDITED );  
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id , "Task ID" => $task_id) );
                    }

                    try
                    {
                            $otherInfo = array( Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::TASK_ACTIVITY_SUBTYPE_TASK_INPERSON );
                            CommonUtility::addTaskActivity($insertedId , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_UPDATE , $otherInfo );
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id,"Task ID" => $task_id) );
                    }
					
                    echo  $error = CJSON::encode(array(
                                    'status'=>'success',
                                    'task_id'=>$insertedId,
                                    'category_id'=>$category_id
                            ));
                                                                        //echo 'hiii';
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                         CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $insertedId, "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ) );
    //                Yii::log($msg,CLogger::LEVEL_ERROR ,'PosterController.Templatedetail');
                       
                } 
            }
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('EditInpersonTask');
            }
        }
        
        public function actioncanceltaskform()
        {
            CommonUtility::startProfiling();
            $task_id = $_POST[Globals::FLD_NAME_TASKID];
            @$taskStatus = $_POST[Globals::FLD_NAME_TASKSTATUS];
            @$refresh = $_POST['refresh'];
            $task = Task::model()->findByPk($task_id);
            $task->scenario = 'cancelTask';
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $html = $this->renderPartial('_canceltaskform',array('task'=>$task , 'refresh' => $refresh, 'taskStatus'=>@$taskStatus),true,true);
            echo  $error = CJSON::encode(array(
                            'status'=>'success',
                            'html'=>$html,                            
                           
                    ));
             CommonUtility::endProfiling();
        }
        public function actionCancelTask()
        {
             CommonUtility::startProfiling();
            $task_id = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
            $task = Task::model()->findByPk($task_id);
            
            $taskStatus  = $task->{Globals::FLD_NAME_TASK_STATE};
                                    
            $task->scenario = 'cancelTask';
            if(Yii::app()->request->isAjaxRequest)
            {
              $error =  CActiveForm::validate(array($task));
              if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
              {
                   // For logging                          
                  CommonUtility::setErrorLog($task->getErrors(),get_class($task));
                  echo $error;
                  Yii::app()->end();
              }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK]))
            {
                $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_TASK_STATE_CANCELED;
                $task->{Globals::FLD_NAME_TASK_CANCEL_REASON} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_CANCEL_REASON];
                try
                {
                    if($taskStatus != Globals::DEFAULT_VAL_TASK_STATE_ASSIGNED)
                    {
                        if( !$task->update())
                        {   
                            throw new Exception(Yii::t('poster_editinpersontask','unexpected_error'));
                        }
                    }
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id  , "Task ID" => $task_id) );
                }
                try
                {
                        $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id  , "Task ID" => $task_id) );
                }
                try
                {
                    CommonUtility::sendAlertToAllTaskers( $task_id , $alertType , Globals::ALERT_DESC_TASK_CANCELED );  
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task ID" => $task_id) );
                }
                try
                {
                    CommonUtility::updateTaskerStatusOnCanceled($task_id);  
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task ID" => $task_id) );
                }

                try
                {
                    $activitySubType = UtilityHtml::GetActivitySubType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        $otherInfo = array( Globals::FLD_NAME_ACTIVITY_SUBTYPE => $activitySubType );
                        
                        if($taskStatus != Globals::DEFAULT_VAL_TASK_STATE_ASSIGNED)
                        {
                            CommonUtility::addTaskActivity($task_id , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_CANCEL , $otherInfo );
                        }
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id,"Task ID" => $task_id) );
                }

            echo  $error = CJSON::encode(array(
                            'status'=>'success',
                            'task_id'=>$task_id,
                           
                    ));
            }
            CommonUtility::endProfiling();
        }
        
        public function actionSaveInstantTask()
        {
            
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('SaveInstantTask','application.controller.PosterController');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task = new Task();
            $taskCategory = new TaskCategory();
            
            $taskLocation = new TaskLocation();
            $task->scenario = Globals::INSTANT_TASK;
            if(Yii::app()->request->isAjaxRequest)
            {
              $error =  CActiveForm::validate(array($task,$taskLocation));
              if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
              {
                   // For logging                          
                  CommonUtility::setErrorLog($task->getErrors(),get_class($task));
                  echo $error;
                  Yii::app()->end();
              }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK]))
            {
                    $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                    $task->attributes=$_POST[Globals::FLD_NAME_TASK];
                    @$to_publish = $_GET[Globals::FLD_NAME_PUBLIC];
					$task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                    
                    if($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_ID_SOURCE] == 1)
                    {
                        $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_USER;
                    }
                    else if($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_ID_SOURCE] == 0)
                    {
                        $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_AUTO;
                    }
                    else
                    {
                        $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_BID;
                    }
                    //$task->{Globals::FLD_NAME_TASK_FINISHED_ON}=CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON]);
                    $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                    $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_O;
                    $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                    $task->{Globals::FLD_NAME_CREATOR_ROLE}=Globals::DEFAULT_VAL_P;
                    $task->{Globals::FLD_NAME_TASK_KIND}=Globals::DEFAULT_VAL_I;
                    $task->{Globals::FLD_NAME_PAYMENT_MODE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PAYMENT_MODE];
                    
                    $endDateTime = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_END_TIME];
                    $end_date = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH , strtotime($endDateTime));
                    $end_time = date(Globals::DEFAULT_VAL_TIME_FORMATE , strtotime($endDateTime));
                    $task->{Globals::FLD_NAME_END_TIME} = $end_time;
                    $task->{Globals::FLD_NAME_END_TIME} = str_replace(":", "", $task->{Globals::FLD_NAME_END_TIME});
                    $task->{Globals::FLD_NAME_TASK_END_DATE} = $end_date;
					$task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                    
                    if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                    {
                        foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE] as $image)
                        {
                            try
							{
								$extension = CommonUtility::getExtension($image);
							}
							catch(Exception $e)
							{             
								$msg = $e->getMessage();
								CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
							}
							try
							{
								$type = CommonUtility::getFileType($extension);
							}
							catch(Exception $e)
							{             
								$msg = $e->getMessage();
								CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
							}
                            $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$image;
                            $attachment[Globals::FLD_NAME_TYPE]=$type;
                            $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                            $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
							try
							{
								$moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
							}
							catch(Exception $e)
							{             
								$msg = $e->getMessage();
								CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
							}
                           
                            $fileInfo[]=$attachment;
                            
							if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
							{
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
								}
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
								}
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
								}
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
								}
							}
                        }
                        $files = CJSON::encode( $fileInfo );
                        $task->{Globals::FLD_NAME_TASK_ATTACHMENTS}=$files;
                    }
                    try
                    {
                        if(isset($to_publish))
                        {
                            $task->{Globals::FLD_NAME_VALID_FROM_DT} = date(Globals::DEFAULT_VAL_DATE_FORMATE_YMD);
                        }
                        if( !$task->save())
                        {  
                            throw new Exception(Yii::t('poster_saveinstanttask','unexpected_error'));
                        }
                        $insertedId=$task->getPrimaryKey();
                        $model->{Globals::FLD_NAME_TASK_POST_CNT} += 1;
                    $model->{Globals::FLD_NAME_TASK_POST_TOTAL_PRICE} += $task->{Globals::FLD_NAME_PRICE};
                    $model->{Globals::FLD_NAME_TASK_POST_TOTAL_HOURS} += $task->{Globals::FLD_NAME_WORK_HRS};
                        if( !$model->update())
                        {   
                            throw new Exception(Yii::t('poster_savevirtualtask','unexpected_error'));
                        }
                        $taskCategory->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                        $taskCategory->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                        $taskCategory->{Globals::FLD_NAME_CATEGORY_ID} =$category_id;
                        $taskCategory->{Globals::FLD_NAME_STATUS}  = Globals::DEFAULT_VAL_O;
                        $taskCategory->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        if(!$taskCategory->save())
                        {
                           throw new Exception(Yii::t('poster_saveinstanttask','unexpected_error'));
                        }
                        $taskLocation->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                        $taskLocation->attributes = $_POST[Globals::FLD_NAME_TASK_LOCATION];
                        $taskLocation->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        if(!$taskLocation->save())
                        {
                                throw new Exception(Yii::t('poster_saveinstanttask','unexpected_error'));
                        }
                            $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::TASK_ACTIVITY_SUBTYPE_TASK_INSTANT,
                                                //  Globals::FLD_NAME_COMMENTS => '',
                                            );
                       	try
						{
					    	CommonUtility::addTaskActivity($insertedId , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_CREATE , $otherInfo );
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
						}
						
                        if(isset($to_publish))
                        {
                            if( $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::DEFAULT_VAL_AUTO ) 
                            {
                                $limit = Globals::DEFAULT_VAL_AUTO_INVATATION_BY_SYSTEM; 
                                GetRequest::autoInvitation( $insertedId , $category_id , $limit );
                            }
                        }
                        echo  $error = CJSON::encode(array(
                                        'status'=>'success',
                                        'tack_id'=>$insertedId,
                                        'category_id'=>$category_id
                                ));
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $insertedId  ,"User ID" =>Yii::app()->user->id) );
                       
                    }    
            }
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('SaveInstantTask');
            }
            
        }
        public function actionEditInstantTask()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('EditInstantTask','application.controller.PosterController');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task_id = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
            $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                
            $task=Task::model()->findByPk($task_id);
            $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
            $taskCategory = TaskCategory::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
            $task->scenario = Globals::INSTANT_TASK;
            if(Yii::app()->request->isAjaxRequest)
            {
              $error =  CActiveForm::validate(array($task,$taskLocation));
              if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
              {
                // For logging 
                  CommonUtility::setErrorLog($task->getErrors(),get_class($task));
                  echo $error;
                  Yii::app()->end();
              }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK]))
            {
                    $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                    $task->attributes=$_POST[Globals::FLD_NAME_TASK];
                    @$to_publish = $_GET[Globals::FLD_NAME_PUBLIC];
					$task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                    
                    if($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_ID_SOURCE] == 1)
                    {
                        $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_USER;
                    }
                    else if($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_ID_SOURCE] == 0)
                    {
                        $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_AUTO;
                    }
                    else
                    {
                        $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_BID;
                    }
                    //$task->{Globals::FLD_NAME_TASK_FINISHED_ON}=CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON]);
                    $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                    $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_O;
                    $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                    $task->{Globals::FLD_NAME_CREATOR_ROLE}=Globals::DEFAULT_VAL_P;
                    $task->{Globals::FLD_NAME_TASK_KIND}=Globals::DEFAULT_VAL_I;
                    $task->{Globals::FLD_NAME_PAYMENT_MODE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PAYMENT_MODE];
                    $task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                    if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_END_TIME]))
                    {
                        $endDateTime = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_END_TIME];
                        $end_date = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH , strtotime($endDateTime));
                        $end_time = date(Globals::DEFAULT_VAL_TIME_FORMATE , strtotime($endDateTime));
                        $task->{Globals::FLD_NAME_END_TIME} = $end_time;
                        $task->{Globals::FLD_NAME_END_TIME} = str_replace(":", "", $task->{Globals::FLD_NAME_END_TIME});

                        $task->{Globals::FLD_NAME_TASK_END_DATE} = $end_date;
                    }                    
                                        
                    
                    if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                    {
                        foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE] as $image)
                        {
                            try
							{
								$extension = CommonUtility::getExtension($image);
							}
							catch(Exception $e)
							{             
								$msg = $e->getMessage();
								CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id , "Task ID" => $task_id) );
							}
							try
							{
								$type = CommonUtility::getFileType($extension);
							}
							catch(Exception $e)
							{             
								$msg = $e->getMessage();
								CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
							}
                            $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$image;
                            $attachment[Globals::FLD_NAME_TYPE]=$type;
                            $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                            $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
                           try
							{
								$moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
							}
							catch(Exception $e)
							{             
								$msg = $e->getMessage();
								CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
							}
                            $fileInfo[]=$attachment;
							
							if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
							{
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
								}
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
								}
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
								}
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
								}
							}
                        }
                        $files = CJSON::encode( $fileInfo );
                        $task->{Globals::FLD_NAME_TASK_ATTACHMENTS}=$files;
                    }
                    if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE]))
                    {
                        foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE] as $image)
                        {
                            if(!in_array($image, $_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                            {
                                try
								{
									CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME},$image);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
								}
                            }
                        }
                    }
                    try
                    {
                        if(isset($to_publish))
                        {
                            $task->{Globals::FLD_NAME_VALID_FROM_DT} = date(Globals::DEFAULT_VAL_DATE_FORMATE_YMD);
                            if( $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::DEFAULT_VAL_AUTO ) 
                            {
                                $limit = Globals::DEFAULT_VAL_AUTO_INVATATION_BY_SYSTEM; 
								try
								{
                                	GetRequest::autoInvitation( $task_id , $category_id , $limit );
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
								}
                            }
                        }
                        if( !$task->update())
                        {
                            throw new Exception(Yii::t('poster_editinstanttask','unexpected_error'));
                        }
                        $insertedId=$task->getPrimaryKey();
                        $taskCategory->{Globals::FLD_NAME_CATEGORY_ID} =$category_id;
						$taskCategory->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;

                        if(!$taskCategory->update())
                        {
                            throw new Exception(Yii::t('poster_editinstanttask','unexpected_error'));
                        }
                        $taskLocation->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                        $taskLocation->attributes = $_POST[Globals::FLD_NAME_TASK_LOCATION];
                        $taskLocation->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        if(!$taskLocation->update())
                        {
                            throw new Exception(Yii::t('poster_editinstanttask','unexpected_error'));
                        }
						try
						{
							$alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
						}
						try
						{
							CommonUtility::sendAlertToAllTaskers( $insertedId , $alertType , Globals::ALERT_DESC_TASK_EDITED );  
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
						}
                                                $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::TASK_ACTIVITY_SUBTYPE_TASK_INSTANT,
                                                //  Globals::FLD_NAME_COMMENTS => '',
                                                );
						try
						{
							CommonUtility::addTaskActivity($insertedId , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_UPDATE , $otherInfo );
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id, "Task ID" => $task_id) );
						}
                        echo  $error = CJSON::encode(array(
                                        'status'=>'success',
                                        'tack_id'=>$insertedId,
                                        'category_id'=>$category_id
                                ));
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                           CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $insertedId ,"User ID"=>Yii::app()->user->id,"Category ID" => $category_id ) );
                    }    
            }
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('EditInstantTask');
            }
            
        }
        
        
        public function actionEditVirtualTask()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('EditVirtualTask','application.controller.PosterController');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task_id = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
            $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                
            $task=Task::model()->findByPk($task_id);
            $taskCategory = TaskCategory::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
            $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
            $task->scenario = Globals::VIRTUAL_TASK;
            if(Yii::app()->request->isAjaxRequest)
            {
                $error =  CActiveForm::validate(array($task));
                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                {
                    // for logging
                    CommonUtility::setErrorLog($task->getErrors(),get_class($task));
                    echo $error;
                    Yii::app()->end();
                }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK]))
            {
                    $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID_VALUE];
                    $task->attributes=$_POST[Globals::FLD_NAME_TASK];
					$task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                    if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_START_DATE]))
                    {
                        try
                        {
                       //     $task->{Globals::FLD_NAME_TASK_START_DATE}=CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_START_DATE]);
                        $task->{Globals::FLD_NAME_TASK_START_DATE}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_START_DATE];

                            
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                        }
                    }
                    if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_END_DATE]))
                    {
                        try
                        {
                            //$task->{Globals::FLD_NAME_TASK_END_DATE}=CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_END_DATE]);
                            $task->{Globals::FLD_NAME_TASK_END_DATE}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_END_DATE];

                            
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
                        }
                    }                    
                    //$task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} =CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_BID_CLOSE_DATE]);
                    @$to_publish = $_GET[Globals::FLD_NAME_PUBLIC];
                    if(isset($to_publish))
                    {
                        $task->{Globals::FLD_NAME_VALID_FROM_DT} = date(Globals::DEFAULT_VAL_DATE_FORMATE_YMD);
                        $task->{Globals::FLD_NAME_BID_START_DATE}  = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                        
                    }
                    if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_START_TODAY]))
                    {
                        $task->{Globals::FLD_NAME_BID_START_DATE}  = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                    }
                    $task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION]));
                    $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                    $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_O;
                    $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                    $task->{Globals::FLD_NAME_CREATOR_ROLE}=Globals::DEFAULT_VAL_P;
                    $task->{Globals::FLD_NAME_TASK_KIND}=Globals::DEFAULT_VAL_V;
                    if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PRICE]))
                    $task->{Globals::FLD_NAME_PRICE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PRICE];
                    if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PAYMENT_MODE]))
                    $task->{Globals::FLD_NAME_PAYMENT_MODE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PAYMENT_MODE];
                    if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                    {
                        foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE] as $image)
                        {
                            try
                            {
                                    $extension = CommonUtility::getExtension($image);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id ) );
                            }
                            try
                            {
                                    $type = CommonUtility::getFileType($extension);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                            }
                            $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$image;
                            $attachment[Globals::FLD_NAME_TYPE]=$type;
                            $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                            $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
                            try
                            {
                                    $moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                            }
                            $fileInfo[]=$attachment;

                            if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
                            {
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
								}
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
								}
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
								}
								try
								{
									CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
								}
							}
                        }
                        $files = CJSON::encode( $fileInfo );
                        $task->{Globals::FLD_NAME_TASK_ATTACHMENTS}=$files;
                    }
                    
                    if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE])  )
                    {
                        foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE] as $image)
                        {
                            
                            if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                            {
                                
                                if(!in_array($image, $_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                                {
                                    try
                                    {
                                            CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME},$image);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                                    }
                                }
                            }
                            else
                            {//echo $image;
                                    try
                                    {//echo $image;
                                            CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME},$image);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
                                    }
                                    
                                    $task->{Globals::FLD_NAME_TASK_ATTACHMENTS} = NULL;
                            }
                        }
                    }
                    try
                    {
                            if(! $task->update())
                            {
                                    throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
                            }

                            $taskCategory->{Globals::FLD_NAME_CATEGORY_ID} =$category_id;
                            $taskCategory->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                            if(!$taskCategory->update())
                            {
                                    throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
                            }
                            $insertedId=$task->getPrimaryKey();
//TaskLocation::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                            if(isset ($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PREFERRED_LOCATION_CHECK]))
                            {
                                    if(isset ($_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION]))
                                    {
                                            @$locations = $_POST[Globals::FLD_NAME_MULTI_LOCATIONS];

                                            if($locations)
                                            {
                                                 $_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION];
                                                   //TaskLocation::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                                                    foreach ($locations as $location)
                                                    {
                                                        //echo $location;
                                                        if( $location != '' )
                                                        {
                                                            //$hasCountry = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$insertedId , Globals::FLD_NAME_COUNTRY_CODE => $location ));
                                                                $hasCountry = TaskLocation::model()->findAll(array(
                                                                'condition'=> Globals::FLD_NAME_TASK_ID .'=:task AND '.Globals::FLD_NAME_COUNTRY_CODE .' = :location OR '.Globals::FLD_NAME_REGION_ID .' = :location ',
                                                                'params'=>array(':task'=>$insertedId , ':location'=> $location),
                                                            ));
  
															if(!$hasCountry)
															{
																$_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION];
																$taskLocation = new TaskLocation();
																$taskLocation->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
																$taskLocation->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
																if($_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C )
																{
																		$taskLocation->{Globals::FLD_NAME_COUNTRY_CODE} = $location;
																}
																elseif($_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_R )
																{
																		$taskLocation->{Globals::FLD_NAME_REGION_ID} = $location;
																}
																$taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION} = $_POST[Globals::FLD_NAME_TASK_LOCATION][Globals::FLD_NAME_IS_LOCATION_REGION];
																if(!$taskLocation->save())
																{
																		throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
																}
															}
                                                        }
                                                    }
                                            }
                                    }
                            }
                            @$skills = $_POST[Globals::FLD_NAME_MULTISKILLS];
                            if($skills)
                            {
                                   // TaskSkill::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                                    foreach ($skills as $skill)
                                    {
                                        $hasSkill = TaskSkill::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$insertedId , Globals::FLD_NAME_SKILL_ID => $skill ));
                                        if(!$hasSkill)
                                        {
                                            $taskSkill = new TaskSkill();
                                            $taskSkill->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                            $taskSkill->{Globals::FLD_NAME_SKILL_ID}  = $skill;
                                            $taskSkill->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                            if(!$taskSkill->save())
                                            {
                                                    throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
                                            }
                                        }
                                            
                                            //echo $skill;
                                    }
                            }
                            @$questions = $_POST[Globals::FLD_NAME_MULTI_CAT_QUESTION];
                            if($questions)
                            {
                                        //TaskQuestion::model()->deleteAll('task_id=:id', array(':id' => $insertedId));
                                    foreach ($questions as $question)
                                    {
                                        $hasQuestion = TaskQuestion::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$insertedId , Globals::FLD_NAME_QUESTION_ID => $question ));
                                        if(!$hasQuestion)
                                        {
                                            $taskQuestion = new TaskQuestion();
                                            $taskQuestion->{Globals::FLD_NAME_TASK_ID}  = $insertedId;
                                            $taskQuestion->{Globals::FLD_NAME_QUESTION_ID}  = $question;
                                            $taskQuestion->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                            if(!$taskQuestion->save())
                                            {
                                                    throw new Exception(Yii::t('poster_editvirtualtask','unexpected_error'));
                                            }
                                        }
								//echo $question;
                                    }
                            }
                        try
						{
							$alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
						}
						try
						{
							CommonUtility::sendAlertToAllTaskers( $insertedId , $alertType , Globals::ALERT_DESC_TASK_EDITED );  
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
						}
                        $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::TASK_ACTIVITY_SUBTYPE_TASK_VIRTUAL,
                                            //  Globals::FLD_NAME_COMMENTS => '',
                                        );
                        try
						{
							CommonUtility::addTaskActivity($insertedId , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_UPDATE , $otherInfo );
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id ,"Task ID" => $task_id) );
						}
                            echo  $error = CJSON::encode(array(
                                    'status'=>'success',
                                    'tack_id'=>$insertedId,
                                    'category_id'=>$category_id
                            ));
						
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $insertedId  ,"User ID" => Yii::app()->user->id) );
                    }    
            }
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('EditVirtualTask');
            }
            
        }
        public function actionLoadInpersonTask()
	{	
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('LoadInpersonTask','application.controller.PosterController');
                }
               
                if(isset($_POST[Globals::FLD_NAME_TASKID]))
                {
                    $task= Task::model()->findByPk($_POST[Globals::FLD_NAME_TASKID]);
                    $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
                    
                }
                else 
                {
                    $task = new Task();
                    $category_id = '';
                }
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
				try
				{
                	$taskList = Task::getUserTaskListByTypeandCategory(Globals::DEFAULT_VAL_P);
				}
				catch(Exception $e)
				{             
					$msg = $e->getMessage();
					CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
				}
                //$previousTask = $this->renderPartial('partial/_loadpreviuostask',array('model'=>$taskList , Globals::FLD_NAME_FORM_TYPE_SML=>'p'),true,true);
                $inpersonTaskCategory =  $this->renderPartial('partial/_inpersontask', array( 'task'=>$task,'category_id'=>$category_id ),true,true);
             //   $return["previusTask"] = $previousTask;
                $return["inperson"] = $inpersonTaskCategory;
                    // var_dump($return);
                echo CJSON::encode($return);
                
                if(CommonUtility::IsProfilingEnabled())
                { 
                    Yii::endProfile('LoadInpersonTask');
                }
            
	}
        public function actionLoadInstantTask()
	{	
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('LoadInstantTask','application.controller.PosterController');
                }
                if(isset($_POST[Globals::FLD_NAME_TASKID]))
                {
                    $task=Task::model()->findByPk($_POST[Globals::FLD_NAME_TASKID]);
                    $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
                    
                }
                else 
                {
                    $task = new Task();
                    $category_id = '';
                }
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
//                Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
//                Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
//                Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
				try
				{
                	$taskList = Task::getUserTaskListByTypeandCategory(Globals::DEFAULT_VAL_I);
				}
				catch(Exception $e)
				{             
					$msg = $e->getMessage();
					CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
				}
                //$previousTask = $this->renderPartial('partial/_loadpreviuostask',array('model'=>$taskList , Globals::FLD_NAME_FORM_TYPE_SML=>'i'),true,true);
                
                $catg2 = new Category();
                
                
                $instantTaskCategory =  $this->renderPartial('partial/_instanttask', array( 'task'=>$task,'category_id'=>$category_id, 'testcarouselProvider'=> $catg2->getInstantCategoryList2() ),true,true);
                //$return["previusTask"] = $previousTask;
                $return["instant"] = $instantTaskCategory;
                echo CJSON::encode($return);
                if(CommonUtility::IsProfilingEnabled())
                { 
                    Yii::endProfile('LoadInstantTask');
                }
            
	}
        
        public function actionLoadCategoryFormToUpdate()
	{	
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('LoadCategoryForm','application.controller.PosterController');
                }
                $task_id = $_POST[Globals::FLD_NAME_TASKID];
                @$onlyform = $_POST[Globals::FLD_NAME_ONLYFORM];
                $task=Task::model()->findByPk($task_id);
                $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
                if(!$taskLocation)
                {
                    $taskLocation = new TaskLocation();
                }
                $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
                $type = $_POST[Globals::FLD_NAME_FORM_TYPE];
                $model=$this->loadModel(Yii::app()->user->id);
                try
                {
                        $category = Category::getCategoryListByID($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Category ID" => $category_id) );
                }
                try
                {
                        $skill = Skill::getSkillsOfCategory($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id, "Category ID" => $category_id) );
                }
                try
                {
                        $questions = CategoryQuestion::getQuestionsOfCategory($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id, "Category ID" => $category_id) );
                }
                
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
                Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
                Yii::app()->clientScript->scriptMap['chosen.jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.ui.timepicker.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui-timepicker-addon.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui-i18n.min.js'] = false;
                
               $return["template"] = $this->renderPartial('_loadtemplatecategory',array('model'=> $category ),true,true);
            
            
               if($type==Globals::DEFAULT_VAL_INSTANT)
               {
                    try
                    {
                        $taskList = Task::getUserTaskListByTypeandCategory( Globals::DEFAULT_VAL_I , $category_id );
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id, "Category ID" => $category_id) );
                    }
                    $return["previusTask"] = $this->renderPartial('_loadpreviuostask',array('model'=>$taskList , Globals::FLD_NAME_FORM_TYPE_SML=> 'i' ),true,true);
                    $task->scenario = Globals::INSTANT_TASK;
                    $return["form"] = $this->renderPartial('instanttaskform', 
                            array(  'task'=>$task,
                                    'model'=>$model,
                                    'category'=>$category,
                                    'taskLocation'=>$taskLocation,
                                    'skill'=>$skill,
                                    'questions'=>$questions,
                                    
                                ),true,true);
               }
               elseif($type==Globals::DEFAULT_VAL_INPERSON)
               {
                try
                {
                        $taskList = Task::getUserTaskListByTypeandCategory( Globals::DEFAULT_VAL_P , $category_id );
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id, "Category ID" => $category_id) );
                }
                    $return["previusTask"] = $this->renderPartial('_loadpreviuostask',array('model'=>$taskList , Globals::FLD_NAME_FORM_TYPE_SML=> 'p' ),true,true);
                    $task->scenario = Globals::INPERSON_TASK;
                    $return["form"] = $this->renderPartial('inpersontaskform', 
                            array(  'task'=>$task,
                                    'model'=>$model,
                                    'category'=>$category,
                                    'taskLocation'=>$taskLocation,
                                    'skill'=>$skill,
                                    'questions'=>$questions,
                                ),true,true);
               }
                else 
                {
                    try
                    {
                        $taskList = Task::getUserTaskListByTypeandCategory( Globals::DEFAULT_VAL_V , $category_id );
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id, "Category ID" => $category_id) );
                    }
                    $return["previusTask"] = $this->renderPartial('_loadpreviuostask',array('model'=>$taskList , Globals::FLD_NAME_FORM_TYPE_SML=> 'v' ),true,true);
                    $task->scenario = Globals::VIRTUAL_TASK;
                    $return["form"] = $this->renderPartial('virtualtaskform', 
                            array(  'task'=>$task,
                                    'model'=>$model,
                                    'category'=>$category,
                                    'taskLocation'=>$taskLocation,
                                    'skill'=>$skill,
                                    'questions'=>$questions,
                                ),true,true);
                }
                if($onlyform)
                {
                    $return = $return["form"];
                }
                echo CJSON::encode($return);
               	if(CommonUtility::IsProfilingEnabled())
                { 
                    Yii::endProfile('LoadCategoryForm');
                }
            
	}
        
        
         public function actionEditTask()
	{	
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('EditTask','application.controller.PosterController');
                }
                $task_id = $_POST[Globals::FLD_NAME_TASKID];
               
                $task = Task::model()->findByPk($task_id);
                $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
                if(!$taskLocation)
                {
                    $taskLocation = new TaskLocation();
                }
                $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
                $type = $_POST[Globals::FLD_NAME_FORM_TYPE];
                $model=$this->loadModel(Yii::app()->user->id);
                try
                {
                        $category = Category::getCategoryListByID($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Category ID" => $category_id) );
                }
                try
                {
                        $skill = Skill::getSkillsOfCategory($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id, "Category ID" => $category_id) );
                }
                try
                {
                        $questions = CategoryQuestion::getQuestionsOfCategory($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id, "Category ID" => $category_id) );
                }
                
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
                Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
                Yii::app()->clientScript->scriptMap['chosen.jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.ui.timepicker.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui-timepicker-addon.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery-ui-i18n.min.js'] = false;
                
               if($type==Globals::DEFAULT_VAL_INSTANT)
               {
                   $return["form"] = $this->renderPartial('instanttaskeditform', 
                            array(  'task'=>$task,
                                    'model'=>$model,
                                    'category'=>$category,
                                    'taskLocation'=>$taskLocation,
                                    'skill'=>$skill,
                                    'questions'=>$questions,
                                    
                                ),true,true);
               }
               elseif($type==Globals::DEFAULT_VAL_INPERSON)
               {
                   $task->scenario = Globals::INPERSON_TASK;
                    $return["form"] = $this->renderPartial('inpersontaskeditform', 
                            array(  'task'=>$task,
                                    'model'=>$model,
                                    'category'=>$category,
                                    'taskLocation'=>$taskLocation,
                                    'skill'=>$skill,
                                    'questions'=>$questions,
                                ),true,true);
               }
                else 
                {
                    $task->scenario = Globals::VIRTUAL_TASK;
                    $return["form"] = $this->renderPartial('virtualtaskeditform', 
                            array(  'task'=>$task,
                                    'model'=>$model,
                                    'category'=>$category,
                                    'taskLocation'=>$taskLocation,
                                    'skill'=>$skill,
                                    'questions'=>$questions,
                                ),true,true);
                }
               
                echo CJSON::encode($return);
               	if(CommonUtility::IsProfilingEnabled())
                { 
                    Yii::endProfile('EditTask');
                }
            
	}
        
        public function actionSetConfirmTaskPage()
	{		
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('SetConfirmTaskPage','application.controller.PosterController.ajax');
            }
            $task_id =  $_POST[Globals::FLD_NAME_TASKID];
            $task=Task::model()->findByPk($task_id);
            $model=$this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
            
            $this->renderPartial('_confirmtask', 
                            array(
                                    'model'=>$model,
                                    'task'=>$task,
                                ),false,true);
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('SetConfirmTaskPage');
            }
        }
	public function actionConfirmTask()
	{	
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('ConfirmTask','application.controller.PosterController');
                }
                if(isset($_GET[Globals::FLD_NAME_TASKID]))
                {
                    $task_id =  $_GET[Globals::FLD_NAME_TASKID];
                    
                    $task=Task::model()->findByPk($task_id);
                    if(isset($task))
                    {
                        $model=$this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});

                        $this->render('confirmtask',array(
                                                            'model'=>$model,
                                                            'task'=>$task,
                                                        ));
                    }
                    else 
                    {
                        $this->redirect(array('index/index'));
                    }
                }
                else 
                {
                    $this->redirect(array('index/index'));
                }
                    //if (Utils::IsTraceEnabled())
                    //{
                            Yii::trace('Executing actionCreateTask() method','PosterController');
                    //}

                    //if (Utils::IsDebugEnabled())
                    //{
                            Yii::log('Successfully Page Loaded', CLogger::LEVEL_INFO, 'PosterController.ConfirmTask');
                    //}
                if(CommonUtility::IsProfilingEnabled())
                {	 
                    Yii::endProfile('ConfirmTask');
                }
	}
        public function actionSubmitConfirmTask()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
            	Yii::beginProfile('SubmitConfirmTask','application.controller.PosterController');
            }
            $taskReference =  Task::model()->findByPk($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID]);
            $taskReference->scenario = Globals::CONFIRM_TASK;
            //print_r($_POST);
            if(Yii::app()->request->isAjaxRequest)
            {
              $error =  CActiveForm::validate(array($taskReference));
              if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
              {
                  // For logging 
                  CommonUtility::setErrorLog($taskReference->getErrors(),get_class($taskReference));
                  echo $error;
                  Yii::app()->end();
              }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK]))
            {
                    $taskReference->{Globals::FLD_NAME_RANK}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_RANK];
                    $taskReference->{Globals::FLD_NAME_REF_REMARKS}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_REF_REMARKS];
                    $taskReference->{Globals::FLD_NAME_REF_VERIFICATION_STATUS} = Globals::DEFAULT_VAL_C ;
                    //$taskReference->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                    if(! $taskReference->update())
                    {   
                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                    }                      
                    echo  $error = CJSON::encode(array(
                                            'status'=>'save_success_message'
                                        ));
                   
            }
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('SubmitConfirmTask');
            }
        }
        public function actionAjaxGetPreferredLocationList()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('AjaxGetPreferredLocationList','application.controller.PosterController');
            }
            $preferred_location = $_POST[Globals::FLD_NAME_IS_LOCATION_REGION];
            $locations = array();
            $placeholder = CHtml::encode(Yii::t('tasker_createtask', 'txt_select_location'));
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['chosen.jquery.js'] = false;
            if($preferred_location == Globals::DEFAULT_VAL_R)
            {
                try
                {
                    $locations = CommonUtility::getRegionsList();
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
                }
                if($locations)
                {
                     $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_region'));
                }
                else 
                {
                    $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_region_not_found'));
                }
            }
            elseif ($preferred_location == Globals::DEFAULT_VAL_C) 
            {
                try
                {
                    $locations = CommonUtility::getCountryList();
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
                }
                $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
            }
            $this->renderPartial('_chusen',array('locations'=>$locations,'placeholder'=>$placeholder),false,true);
			if(CommonUtility::IsProfilingEnabled())
        	{ 
            	Yii::endProfile('AjaxGetPreferredLocationList');
			}
        }
        
        public function actionUploadTaskFiles()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UploadTaskFiles','application.controller.PosterController.ajax');
            }
            $maxUploadFileSize = LoadSetting::getMaxUploadFileSize();;
            $minUploadFileSize = LoadSetting::getSettingValue(Globals::SETTING_KEY_MIN_UPLOAD_FILE_SIZE);
   
            $model=$this->loadModel(Yii::app()->user->id);
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder = Globals::FRONT_USER_PORTFOLIO_TEMP_PATH;
            $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
            $allowedExtensions = $allowArray;//allowDocuments User Image allow
            $sizeLimit = $maxUploadFileSize;// maximum file size in bytes'
            $fileNameSlugBefore = $model->{Globals::FLD_NAME_USER_ID}.Globals::DEFAULT_VAL_UNDERSCORE.time();
            $fileNameSlugAfter = Globals::FRONT_USER_USER_IMAGE_NAME_SLUG;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder,false,$fileNameSlugBefore,$fileNameSlugAfter);
            $return = htmlspecialchars(CJSON::encode($result), ENT_NOQUOTES);
            $fileSize=filesize($folder.$result[Globals::FLD_NAME_FILENAME]);//GETTING FILE SIZE
            $fileName = $result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME
            
            echo $return;// it's array
            
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('UploadTaskFiles');
            }
        }
        public function actionLoadPreviuosTask($formType)
        {  
            if(CommonUtility::IsProfilingEnabled())
            {                      
            	Yii::beginProfile('LoadPreviuosTask','application.controller.PosterController.ajax');
            }
    		try
                {
                    $taskList =  Task::getUserTaskListByTypeandCategory($_POST);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
                }
            return $taskList;
            if(CommonUtility::IsProfilingEnabled())
            { 
            	Yii::endProfile('LoadPreviuosTask');
            }
            
        }
        public function actionLoadTemplateCategory()
        {
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::beginProfile('LoadTemplateCategory','application.controller.PosterController.ajax');
            }
            $category = "";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            if(!empty($_POST[Globals::FLD_NAME_CATEGORY_ID]))
            {
                try
                {
                    $category = Category::getCategoryListByID($_POST[Globals::FLD_NAME_CATEGORY_ID]);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task ID" => $_POST[Globals::FLD_NAME_CATEGORY_ID]) );
                }
            }
            $this->renderPartial('_loadtemplatecategory',array('model'=>$category),false,true);
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('LoadTemplateCategory');
            }
        }
        public function actionBrowseTemplateCategory()
        {
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::beginProfile('BrowseTemplateCategory','application.controller.PosterController.ajax');
            }
            $category = "";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            if(!empty($_POST[Globals::FLD_NAME_CATEGORY_ID]))
            {
				try
				{
                	$category = Category::getCategoryListByID($_POST[Globals::FLD_NAME_CATEGORY_ID]);
				}
				catch(Exception $e)
				{             
					$msg = $e->getMessage();
					CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task ID" => $_POST[Globals::FLD_NAME_CATEGORY_ID]) );
				}
            }
            $this->renderPartial('_browsetemplatecategory',array('model'=>$category),false,true);
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('BrowseTemplateCategory');
            }
        }
        public function actionTaskerSetMap()
        {
			if(CommonUtility::IsProfilingEnabled())
        	{ 
           		Yii::beginProfile('TaskerSetMap','application.controller.PosterController.ajax');
			}
            @$lat = $_POST[Globals::FLD_NAME_LAT];
            @$lng = $_POST[Globals::FLD_NAME_LNG];
            @$address = $_POST[Globals::FLD_NAME_ADDRESS];
            @$range = $_POST[Globals::FLD_NAME_RANGE];
            $location = '';
            $model=$this->loadModel(Yii::app()->user->id);
            $locationRange ='';
            $getUsers = 0;
            
            if($lat && $lng)
            {
                $getUsers = 1;
            }
            else 
            {
                if(isset($model->{Globals::FLD_NAME_LOCATION_LATITUDE}) && isset($model->{Globals::FLD_NAME_LOCATION_LONGITUDE}) )
                {
                    $lat = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
                    $lng = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                    $getUsers = 1;
                }
                else 
                {
					try
					{
                    	$addtess = CommonUtility::getAddressAndLatLngFromIp();
					}
					catch(Exception $e)
					{             
						$msg = $e->getMessage();
						CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
					}
                    if($addtess)
                    {
                        $lat = $addtess[Globals::FLD_NAME_LAT];
                        $lng = $addtess[Globals::FLD_NAME_LNG];
                    }
                    $getUsers = 1;
                    
                }
            }
            if($getUsers == 1)
            {
				try
				{
                	$locationRange = CommonUtility::geologicalPlaces($lat,$lng,$range);
				}
				catch(Exception $e)
				{             
					$msg = $e->getMessage();
					CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
				}
				try
				{
                	$users=User::getUsersByLatLng($locationRange);
				}
				catch(Exception $e)
				{             
					$msg = $e->getMessage();
					CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
				}
            }
             //print_r($locationRange);
            if($users)
            {
               // print_r($users);
                foreach ($users as $user) 
                {   
                   
                    $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_USER_ID] = $user->{Globals::FLD_NAME_USER_ID};
                    $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_LNG] = $user->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                    $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_LAT] = $user->{Globals::FLD_NAME_LOCATION_LATITUDE};
                    $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_COUNTRY_CODE] = $user->{Globals::FLD_NAME_COUNTRY_CODE};
                }
            }
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            //print_r($location);
            $this->renderPartial('_map',array('lat'=>$lat,'lng'=>$lng,'address'=>$address,'range'=>$range,'location'=>$location,
                                                'model'=>$model
                ),false,true);
			if(CommonUtility::IsProfilingEnabled())
        	{ 
            	Yii::endProfile('TaskerSetMap');
			}
        }

        
        public function actionValidateProposal()
	{
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::beginProfile('ValidateProposal','application.controller.PosterController');
            }
            $taskTasker = new TaskTasker();
            $taskTasker->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
            if(Yii::app()->request->isAjaxRequest)
            {
                $error =  CActiveForm::validate(array($taskTasker));
                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                {
                  // For logging 
                  CommonUtility::setErrorLog($taskTasker->getErrors(),get_class($taskTasker));
                  echo $error;
                  Yii::app()->end();
                }
                if(isset($_POST[Globals::FLD_NAME_TASK_TASKER]))
                {
                    echo  $error = CJSON::encode(array(
                                                        'status'=>'save_success_message',
                                                        
                                                        ));
                }
            }
            
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('ValidateProposal');
            }
        }
        public function actionSaveProposal()
	{
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::beginProfile('SaveProposal','application.controller.PosterController');
            }
            $taskTasker = new TaskTasker();
            $taskQuestionReply = new TaskQuestionReply();
            
            $model=$this->loadModel(Yii::app()->user->id);
            $taskTasker->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
            $taskQuestionReply->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
            //print_r($_POST);
            @$questionsReply = $_POST[Globals::FLD_NAME_TASK_QUESTION_REPLY];
            if(Yii::app()->request->isAjaxRequest)
            {
                $error =  CActiveForm::validate(array($taskTasker,$taskQuestionReply));
                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                {
                    // For logging 
                    CommonUtility::setErrorLog($taskTasker->getErrors(),get_class($taskTasker));
                    echo $error;
                    Yii::app()->end();
                }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK_TASKER]))
            {
                    $task_id =  $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                    $task = Task::model()->findByPk($task_id);
                    $isProposed = TaskTasker::isUserProposed(Yii::app()->user->id, $task_id, $task->{Globals::FLD_NAME_CREATER_USER_ID});
                    if(!$isProposed)
                    {
                        echo  $error = CJSON::encode(array(
                                                            'status'=>'save_success_message',
                                                            'task_id'=>$task_id,
                                                           // 'task_tasker_id'=>$insertedId,
                                                            ));
                                                            Yii::app()->end();
                    }
                   // echo $task->{Globals::FLD_NAME_END_TIME};
                   // echo CommonUtility::leftTimingInstant($task->{Globals::FLD_NAME_END_TIME});
                    try
                    {
                            if(CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE}) > 0 || CommonUtility::leftTimingInstant($task->{Globals::FLD_NAME_END_TIME}) > 0 )
                            {

                                    $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
                                    $taskTasker->{Globals::FLD_NAME_TASK_ID} = $task_id ;
                                    $taskTasker->{Globals::FLD_NAME_TASKER_ID} = Yii::app()->user->id;
    //							$taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_DRAFT;
                                    $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE} = Globals::DEFAULT_VAL_TASKER_SELECTION_TYPE_BID;
                                    $taskTasker->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                                    $taskTasker->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
                                    if( isset($model->{Globals::FLD_NAME_LOCATION_LONGITUDE}) && isset($model->{Globals::FLD_NAME_LOCATION_LATITUDE}) && 
                                        isset($taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE}) && isset($taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE}) )
                                    {
                                        try
                                        {
                                            $getDistance = CommonUtility::calDistance(  $model->{Globals::FLD_NAME_LOCATION_LONGITUDE}, 
                                            $model->{Globals::FLD_NAME_LOCATION_LATITUDE}, 
                                            $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE},
                                            $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE} );
                                        }
                                        catch(Exception $e)
                                        {             
                                                $msg = $e->getMessage();
                                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                        }
                                        $taskTasker->{Globals::FLD_NAME_TASKER_IN_RANGE} = $getDistance;
                                    }
                                    $taskTasker->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS} = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASKER_POSTER_COMMENTS];
                                    $taskTasker->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                    $taskTasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASKER_PROPOSED_COST];
                                    $taskTasker->{Globals::FLD_NAME_PROPOSED_DURATION} = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_PROPOSED_DURATION];
                                    $taskTasker->{Globals::FLD_NAME_PROPOSED_COMPLETION_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime("+".$_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_PROPOSED_DURATION] ));

                                    ///attachments///
                                    if(isset($_POST[Globals::FLD_NAME_PROPOSALATTACHMENTS]))
                                    {
                                            foreach ($_POST[Globals::FLD_NAME_PROPOSALATTACHMENTS] as $attachfile)
                                            {
                                                    try
                                                    {
                                                        $extension = CommonUtility::getExtension($attachfile);
                                                    }
                                                    catch(Exception $e)
                                                    {             
                                                        $msg = $e->getMessage();
                                                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                                    }
                                                    try
                                                    {
                                                        $type = CommonUtility::getFileType($extension);
                                                    }
                                                    catch(Exception $e)
                                                    {             
                                                        $msg = $e->getMessage();
                                                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                                    }
                                                    $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$attachfile;
                                                    $attachment[Globals::FLD_NAME_TYPE]=$type;
                                                    $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                                                    $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
                                                    $attachment[Globals::FLD_NAME_UPLOADED_BY]= Yii::app()->user->id;
                                                    $filename = explode('.', $attachfile);
                                                    $attachment[Globals::FLD_NAME_FILESIZE]= $_POST[$filename[0]."_size"];
                                                    $attachment[Globals::FLD_NAME_IS_PUBLIC]= Globals::DEFAULT_VAL_0;
                                                    try
                                                    {
                                                            $moveFile = CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$attachfile);
                                                    }
                                                    catch(Exception $e)
                                                    {             
                                                            $msg = $e->getMessage();
                                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                                    }
                                                    $fileInfo[]=$attachment;

                                                    if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
                                                    { 
                                                        try
                                                        {
                                                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
                                                        }
                                                        catch(Exception $e)
                                                        {             
                                                                $msg = $e->getMessage();
                                                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                                        }
                                                        try
                                                        {
                                                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
                                                        }
                                                        catch(Exception $e)
                                                        {             
                                                                $msg = $e->getMessage();
                                                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                                        }
                                                        try
                                                        {
                                                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                                                        }
                                                        catch(Exception $e)
                                                        {             
                                                                $msg = $e->getMessage();
                                                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                                        }
                                                        try
                                                        {
                                                                CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                                                        }
                                                        catch(Exception $e)
                                                        {             
                                                                $msg = $e->getMessage();
                                                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                                        }
                                                    }
                                            }
                                            $files = CJSON::encode( $fileInfo );
                                            $taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS} = $files;
                                            $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER} += $_POST['uploadProposalAttachments_totalFileSizeUsed'];
                                            $task->{Globals:: FLD_NAME_SPACE_QUOTA_DOER} +=  $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER};

                                    }
                                    try
                                    {
//                                        print_r($taskTasker);
//                                        exit;
                                            if(! $taskTasker->save())
                                            {   
                                                    throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                                            }
                                            $insertedId=$taskTasker->getPrimaryKey(); 
								

                                            if(isset($_POST["TaskQuestionReply"]))
                                            {
                                                foreach ($_POST["TaskQuestionReply"] as $question_id => $answers)
                                                {
                                                    $taskQuestionReply = new TaskQuestionReply();
                                                    $taskQuestionReply->{Globals::FLD_NAME_TASK_ID} = $task_id ;
                                                    $taskQuestionReply->{Globals::FLD_NAME_TASKER_ID} = Yii::app()->user->id; 
                                                    $taskQuestionReply->{Globals::FLD_NAME_TASK_QUESTION_ID} = $question_id ;
                                                    if(isset($answers[Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC]))
                                                    {
                                                        $taskQuestionReply->{Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC} = $answers[Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC] ;
                                                    }
                                                    if(isset($answers[Globals::FLD_NAME_REPLY_YESNO]))
                                                    {
                                                        $taskQuestionReply->{Globals::FLD_NAME_REPLY_YESNO} = $answers[Globals::FLD_NAME_REPLY_YESNO] ;
                                                    }

                                                    $taskQuestionReply->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                                    if(! $taskQuestionReply->save())
                                                    {   
                                                        throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                                                    }
                                                }
                                            }
                                            $currentAvgRating = $task->{Globals::FLD_NAME_PROPOSALS_AVG_RATING};
                                            $currentAvgPrice = $task->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE};
                                            try
                                            {
                                                $newAvgPrice =  CommonUtility::getAvg( $currentAvgPrice , $task->{Globals::FLD_NAME_PROPOSALS_CNT} , $taskTasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} );
                                            }
                                            catch(Exception $e)
                                            {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                            }
                                            try
                                            {
                                                $newAvgRating =  CommonUtility::getAvg( $currentAvgRating , $task->{Globals::FLD_NAME_PROPOSALS_CNT} , $model->{Globals::FLD_NAME_TASK_DONE_RANK} );
                                            }
                                            catch(Exception $e)
                                            {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                            }
                                            $task->{Globals::FLD_NAME_PROPOSALS_CNT} += 1;
                                            $task->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE} = $newAvgPrice;
                                            $task->{Globals::FLD_NAME_PROPOSALS_AVG_RATING} = $newAvgRating;
                                            $task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;


                                            //for update task average experiance                                                                
                                            CommonUtility::updateTaskAverageExperience($task->{Globals::FLD_NAME_TASK_ID});
                                            //for update task average experiance

                                            if(! $task->save())
                                            {   
                                                    throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                                            }

                                            $alert = new UserAlert();
                                            try
                                            {
                                                    $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                                            }
                                            catch(Exception $e)
                                            {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                            }
                                            $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                                            $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_CREATE_PROPOSAL;
                                            $alert->{Globals::FLD_NAME_FOR_USER_ID} = $task->{Globals::FLD_NAME_CREATER_USER_ID};
                                            $alert->{Globals::FLD_NAME_BY_USER_ID} = Yii::app()->user->id;
                                            $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $insertedId;
                                            $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;


                                            if(!$alert->save())
                                            {   
                                                    throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                                            }
							   
					
                                            $otherInfo = array( 
                                                                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
                                                                                            //  Globals::FLD_NAME_COMMENTS => '',
                                                                                    );
                                            try
                                            {
                                                    CommonUtility::addTaskActivity($task_id , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_CREATE , $otherInfo );
                                            }
                                            catch(Exception $e)
                                            {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                            }
                                            Yii::app()->user->setFlash('success',Yii::t('flashmessages', 'txt_bid_success'));
                                            echo  $error = CJSON::encode(array(
                                                                                'status'=>'save_success_message',
                                                                                'task_id'=>$task_id,
                                                                                'task_tasker_id'=>$insertedId,
                                                                                ));
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                                                            CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $task_id ,"Task Tasker ID " => $insertedId ) );
                                    }    
                            }
                            else
                            {
                                              echo  $error = CJSON::encode(array(
                                                                      'status'=>'bid_closed'
                                                                    ));
                            }
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                    }
            }
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('SaveProposal');
            }
        }
        public function actionEditProposal()
	{
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::beginProfile('EditProposal','application.controller.PosterController');
            }
            
            $tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASKER_ID];
            $task_id =  $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
             @$task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASK_TASKER_ID];
            //$taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
            $taskTasker = TaskTasker::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id , Globals::FLD_NAME_TASKER_ID => $tasker_id ));

            $taskQuestionReply = new TaskQuestionReply();
            $model = $this->loadModel(Yii::app()->user->id);
            $taskTasker->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
            $taskQuestionReply->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
           // print_r($_POST);
            
            if(Yii::app()->request->isAjaxRequest)
            {
              $error =  CActiveForm::validate(array($taskTasker,$taskQuestionReply));
              if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
              {
                  // For logging 
                  CommonUtility::setErrorLog($taskTasker->getErrors(),get_class($taskTasker));
                  echo $error;
                  Yii::app()->end();
              }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK_TASKER]))
            {
                    
                $task=Task::model()->findByPk($task_id);
                if(!$task_tasker_id)
                {
                    $isProposed = TaskTasker::isUserProposed(Yii::app()->user->id, $task_id, $task->{Globals::FLD_NAME_CREATER_USER_ID});
                    if(!$isProposed)
                    {
                        echo  $error = CJSON::encode(array(
                                                            'status'=>'save_success_message',
                                                            'task_id'=>$task_id,
                                                           // 'task_tasker_id'=>$insertedId,
                                                            ));
                                                            Yii::app()->end();
                    }
                }
                try
                {
                    if(CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE}) > 0 || CommonUtility::leftTimingInstant($task->{Globals::FLD_NAME_END_TIME}) > 0 )
                    {
                            $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
                            $taskTasker->{Globals::FLD_NAME_TASK_ID} = $task_id ;
                            $taskTasker->{Globals::FLD_NAME_TASKER_ID} = Yii::app()->user->id;
                            $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_DRAFT;
                            $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE} = Globals::DEFAULT_VAL_TASKER_SELECTION_TYPE_BID;
                            $taskTasker->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                            $taskTasker->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
                            $taskTasker->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                            if( isset($model->{Globals::FLD_NAME_LOCATION_LONGITUDE}) && isset($model->{Globals::FLD_NAME_LOCATION_LATITUDE}) && 
                                    isset($taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE}) && isset($taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE}) )
                            {
                                    try
                                    {
                                            $getDistance = CommonUtility::calDistance(  $model->{Globals::FLD_NAME_LOCATION_LONGITUDE}, 
                                                                                                                            $model->{Globals::FLD_NAME_LOCATION_LATITUDE}, 
                                                                                                                            $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE},
                                                                                                                            $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE} );
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                    }
                                    $taskTasker->{Globals::FLD_NAME_TASKER_IN_RANGE} = $getDistance;
                            }
                            $taskTasker->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS} = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASKER_POSTER_COMMENTS];
                            $taskTasker->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                            $taskTasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASKER_PROPOSED_COST];
                            $taskTasker->{Globals::FLD_NAME_PROPOSED_DURATION} = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_PROPOSED_DURATION];
                            $taskTasker->{Globals::FLD_NAME_PROPOSED_COMPLETION_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime("+".$_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_PROPOSED_DURATION] ));
                            ///attachments///
                            if(isset($_POST[Globals::FLD_NAME_PROPOSALATTACHMENTS]))
                            {
                                foreach ($_POST[Globals::FLD_NAME_PROPOSALATTACHMENTS] as $attachfile)
                                {
                                       // echo $attachfile;
                                            try
                                            {
                                                    $extension = CommonUtility::getExtension($attachfile);
                                            }
                                            catch(Exception $e)
                                            {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                            }
                                            try
                                            {
                                                    $type = CommonUtility::getFileType($extension);
                                            }
                                            catch(Exception $e)
                                            {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                            }
                                            $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$attachfile;
                                            //$fileWithFolder = $attachfile;
                                            $attachment[Globals::FLD_NAME_TYPE]=$type;
                                            $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                                            $attachment[Globals::FLD_NAME_UPLOAD_ON]= time();
                                            $attachment[Globals::FLD_NAME_UPLOADED_BY]= Yii::app()->user->id;
                                            $filename = explode('.', $attachfile);
                                            $attachment[Globals::FLD_NAME_FILESIZE]= $_POST[$filename[0]."_size"];
                                            $attachment[Globals::FLD_NAME_IS_PUBLIC]= Globals::DEFAULT_VAL_0;
                                            try
                                            {
                                                    CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$attachfile);
                                            }
                                            catch(Exception $e)
                                            {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                            }
                                            $fileInfo[]=$attachment;

                                            if($type == Globals::DEFAULT_VAL_IMAGE_TYPE)
                                            {
                                                    try
                                                    {
                                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
                                                    }
                                                    catch(Exception $e)
                                                    {             
                                                            $msg = $e->getMessage();
                                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                                    }
                                                    try
                                                    {
                                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
                                                    }
                                                    catch(Exception $e)
                                                    {             
                                                            $msg = $e->getMessage();
                                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                                    }
                                                    try
                                                    {
                                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                                                    }
                                                    catch(Exception $e)
                                                    {             
                                                            $msg = $e->getMessage();
                                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                                    }
                                                    try
                                                    {
                                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                                                    }
                                                    catch(Exception $e)
                                                    {             
                                                            $msg = $e->getMessage();
                                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                                    }
                                            }
                                    }
                                    $files = CJSON::encode( $fileInfo );
                                    $taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS} = $files;
                                    $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER} += $_POST['uploadProposalAttachments_totalFileSizeUsed'];
                                    $task->{Globals:: FLD_NAME_SPACE_QUOTA_DOER} +=  $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER};

                            }
                            if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE]))
                            {
                                    foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE] as $image)
                                    {

                                        if(!in_array($image, $_POST[Globals::FLD_NAME_PROPOSALATTACHMENTS]))
                                        {
                                            try
                                            {
                                                    CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME},$image);
                                            }
                                            catch(Exception $e)
                                            {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                            }
                                        }
                                    }
                            }
                            try
                            {
                                if( !$taskTasker->update())
                                {   
                                                throw new Exception(Yii::t('poster_editproposal','unexpected_error'));
                                }
                                    $insertedId=$taskTasker->getPrimaryKey(); 
                                    if(isset($_POST[Globals::FLD_NAME_TASK_QUESTION_REPLY]))
                                    {
                                        TaskQuestionReply::model()->deleteAll('task_id=:id AND tasker_id=:tasker', array(':id' => $task_id,':tasker' => $taskTasker->tasker_id));
                                        foreach ($_POST[Globals::FLD_NAME_TASK_QUESTION_REPLY] as $question_id => $answers)
                                        {
                                                $taskQuestionReply = new TaskQuestionReply();
                                                $taskQuestionReply->{Globals::FLD_NAME_TASK_ID} = $task_id ;
                                                $taskQuestionReply->{Globals::FLD_NAME_TASKER_ID} = Yii::app()->user->id; 
                                                $taskQuestionReply->{Globals::FLD_NAME_TASK_QUESTION_ID} = $question_id ;
                                                if(isset($answers[Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC]))
                                                {
                                                        $taskQuestionReply->{Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC} = $answers[Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC] ;
                                                }
                                                if(isset($answers[Globals::FLD_NAME_REPLY_YESNO]))
                                                {
                                                        $taskQuestionReply->{Globals::FLD_NAME_REPLY_YESNO} = $answers[Globals::FLD_NAME_REPLY_YESNO] ;
                                                }

                                                $taskQuestionReply->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                                if(! $taskQuestionReply->save())
                                                {   

                                                        throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                                                }
                                        }
                                    }
                                                                
                                    $currentAvgRating = $task->{Globals::FLD_NAME_PROPOSALS_AVG_RATING};
                                    $currentAvgPrice = $task->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE};
                                    try
                                    {
                                        $newAvgPrice =  CommonUtility::getAvg( $currentAvgPrice , $task->{Globals::FLD_NAME_PROPOSALS_CNT} , $taskTasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} );
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                    }
                                    try
                                    {
                                        $newAvgRating =  CommonUtility::getAvg( $currentAvgRating , $task->{Globals::FLD_NAME_PROPOSALS_CNT} , $model->{Globals::FLD_NAME_TASK_DONE_RANK} );
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                    }
                                    $task->{Globals::FLD_NAME_PROPOSALS_CNT} += 1;
                                    $task->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE} = $newAvgPrice;
                                    $task->{Globals::FLD_NAME_PROPOSALS_AVG_RATING} = $newAvgRating;
                                    $task->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;

                                     //for update task average experiance                                                                
                                    CommonUtility::updateTaskAverageExperience($task->{Globals::FLD_NAME_TASK_ID});
                                    //for update task average experiance
                                                                
                                    if(! $task->save())
                                    {   
                                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                                    }
                                    $alert = new UserAlert();
                                    try
                                    {
                                            $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                                    }
                                    $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                                    $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_CREATE_PROPOSAL;
                                    $alert->{Globals::FLD_NAME_FOR_USER_ID} = $task->{Globals::FLD_NAME_CREATER_USER_ID};
                                    $alert->{Globals::FLD_NAME_BY_USER_ID} = Yii::app()->user->id;
                                    $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $insertedId;
                                    $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;


                                    if(!$alert->save())
                                    {   
                                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                                    }

                                    $otherInfo = array( 
                                                    Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
                                                                                    //  Globals::FLD_NAME_COMMENTS => '',
                                                    );
                                    try
                                    {
                                            CommonUtility::addTaskActivity($task_id , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_UPDATE , $otherInfo );
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                                    }
                                    Yii::app()->user->setFlash('success',Yii::t('flashmessages', 'txt_bid_success'));

                                    echo  $error = CJSON::encode(array(
                                                    'status'=>'save_success_message',
                                                    'task_id'=>$task_id,
                                                    'task_tasker_id'=>$insertedId,

                                    ));
                            }
                            catch(Exception $e)
                            {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $task_id ,"Task Tasker ID " => $insertedId ) );
                            }   
                        }
                        else
                        {
                                          echo  $error = CJSON::encode(array(
                                                                  'status'=>'bid_closed'
                                          ));
                        }
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
                }
            }
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('EditProposal');
            }
        }
    public function actionLoadProposalPreview()
    {
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::beginProfile('LoadProposalPreview','application.controller.PosterController');
            }
            
            $task_id = $_POST[Globals::FLD_NAME_TASKID];
            @$is_published = $_POST[Globals::FLD_NAME_IS_PUBLISHED]; 
            
            $task=Task::model()->findByPk($task_id);
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
            $task_tasker=TaskTasker::model()->findByPk($task_tasker_id);
            try
            {
                $question = TaskQuestion::getTaskQuestion($task_id);
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
            }
            $model=$this->loadModel($task_tasker->{Globals::FLD_NAME_TASKER_ID});
            
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
           
            Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
           
            $this->renderPartial('_proposalpreview',array(
                                                            'task_tasker_id' => $task_tasker_id,
                                                            'taskTasker' => $task_tasker,
                                                            'question' => $question,
                                                            'model' => $model,
                                                            'task' => $task,
                                                            'task_id' => $task_id,
                                                            'is_pubilshed' => $is_published,
                
                                                         
                ),false,true);
				if(CommonUtility::IsProfilingEnabled())
        		{ 
                	Yii::endProfile('LoadProposalPreview');
				}
    }
    public function actionProposal()
    {
            if(CommonUtility::IsProfilingEnabled())
            { 
                    Yii::beginProfile('Proposal','application.controller.PosterController');
            }
            $task_id = $_POST[Globals::FLD_NAME_TASKID];
            @$is_published = $_POST[Globals::FLD_NAME_IS_PUBLISHED];
            
            $task=Task::model()->findByPk($task_id);
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASKTASKER];
			try
			{
            	$proposals = GetRequest::getProposalsByTask($task->{Globals::FLD_NAME_TASK_ID},$task->{Globals::FLD_NAME_CREATER_USER_ID} , Globals::DEFAULT_VAL_TASK_DETAIL_PORPOSAL_SIDE_BAR_LIMIT );   
			}
			catch(Exception $e)
			{             
				$msg = $e->getMessage();
				CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
			}
           
            $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
			try
			{
            	$question =  TaskQuestion::getTaskQuestion($task_id);
			}
			catch(Exception $e)
			{             
				$msg = $e->getMessage();
				CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
			}

            $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
            $currentUser = $this->loadModel(Yii::app()->user->id);
            $taskQuestionReply = new TaskQuestionReply();
            $taskTasker->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
            $taskQuestionReply->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
           if(isset($is_published))
           {
                     $this->renderPartial('_proposalpublished',array(
                     Globals::FLD_NAME_TASK_TASKER_ID => $task_tasker_id,
                     Globals::FLD_NAME_TASKTASKER => $taskTasker,
                     Globals::FLD_NAME_QUESTION => $question,
                     Globals::FLD_NAME_MODEL => $model,
                     Globals::FLD_NAME_TASK => $task,
                     Globals::FLD_NAME_TASK_QUESTION_REPLY => $taskQuestionReply,
                     Globals::FLD_NAME_TASK_ID => $task_id,
                     Globals::FLD_NAME_PROPOSALS => $proposals,
                     Globals::FLD_NAME_CURRENTUSER=>$currentUser,
                     
                      ),false,true);
           }
           else
           {
                     $this->renderPartial('_proposalfrom',array(
//                     'task_tasker_id' => $task_tasker_id,
//                     'taskTasker' => $taskTasker,
//                     'question' => $question,
//                     'model' => $model,
//                     'task' => $task,
//                     'taskQuestionReply' => $taskQuestionReply,
//                     'task_id' => $task_id,
//                     'currentUser'=>$currentUser,
                     Globals::FLD_NAME_TASK_TASKER_ID => $task_tasker_id,
                     Globals::FLD_NAME_TASKTASKER => $taskTasker,
                     Globals::FLD_NAME_QUESTION => $question,
                     Globals::FLD_NAME_MODEL => $model,
                     Globals::FLD_NAME_TASK => $task,
                     Globals::FLD_NAME_TASK_QUESTION_REPLY => $taskQuestionReply,
                     Globals::FLD_NAME_TASK_ID => $task_id,
                     Globals::FLD_NAME_PROPOSALS => $proposals,
                     Globals::FLD_NAME_CURRENTUSER=>$currentUser,
                         ),false,true);
           }
            if(CommonUtility::IsProfilingEnabled())
            { 
                	Yii::endProfile('Proposal');
            }
    }
    public function actionPublishProposal()
    {
        if(CommonUtility::IsProfilingEnabled())
        { 
            Yii::beginProfile('PublishProposal','application.controller.PosterController');
        }
        $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER]['task_tasker_id'];
        $taskTasker=TaskTasker::model()->findByPk($task_tasker_id);
        if(isset($_POST[Globals::FLD_NAME_TASK_TASKER]))
        {
                $task_id =  $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                $task=Task::model()->findByPk($task_id);
				try
				{
					if(CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE}) > 0 || CommonUtility::leftTimingInstant($task->{Globals::FLD_NAME_END_TIME}) > 0 )
					{
	
						$taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = 'a';
						try
						{
								if( !$taskTasker->update())
								{   
										throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
								}
								$otherInfo = array( 
													Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
													//  Globals::FLD_NAME_COMMENTS => '',
												);
								try
								{
									CommonUtility::addTaskActivity($task_id , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_PUBLISH , $otherInfo );
								}
								catch(Exception $e)
								{             
									$msg = $e->getMessage();
									CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
								}
								echo $error = CJSON::encode(array(
										'status'=>'save_success_message',
										'task_id'=>$task_id,
										'task_tasker_id'=>$task_tasker_id,
								));
						}
						catch(Exception $e)
						{
								$msg = $e->getMessage();
								CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $task_id ,"Task Tasker ID " => $task_tasker_id ) );
	
						}
					}
					else
					{
						echo  $error = CJSON::encode(array(
								'status'=>'bid_closed'
						));
					}
				}
				catch(Exception $e)
				{             
					$msg = $e->getMessage();
					CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id) );
				}
        }
        if(CommonUtility::IsProfilingEnabled())
        { 
            Yii::endProfile('PublishProposal');
        }
   }
   
    
    public function actionproposalshowinterest()
    {
            CommonUtility::startProfiling();
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
            $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
            $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
            if($taskTasker)
            {
                $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_DRAFT;
                try
                {
                        if( !$taskTasker->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','updating task tasker'));
                        }
                        $alert = new UserAlert();
                        try
                        {
                            $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task Tasker ID" => $task_tasker_id) );
                        }
                        $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                        $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_SHOW_INTEREST_PROPOSAL;
                        $alert->{Globals::FLD_NAME_FOR_USER_ID} = $taskTasker->{Globals::FLD_NAME_TASKER_ID}; 
                        $alert->{Globals::FLD_NAME_BY_USER_ID} =  Yii::app()->user->id;
                        $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                        $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        if(!$alert->save())
                        {   
                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                        }
                         $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
                                                //  Globals::FLD_NAME_COMMENTS => '',
                                            );
//                        try
//                        {
//                            
//                                CommonUtility::addTaskActivity($taskTasker->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_SHOW_INTEREST , $otherInfo );
//                        }
//                        catch(Exception $e)
//                        {             
//                                $msg = $e->getMessage();
//                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id, "Task Tasker ID" => $task_tasker_id) );
//                        }
                         $html = $this->renderPartial('//tasker/_notinterested',array('tasker_status' => $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} , 'tasker_id' => $taskTasker->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $task_tasker_id ) , true);
                        $accept = $this->renderPartial('//tasker/_hireme',array('tasker_status' => $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} , 'tasker_id' => $taskTasker->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $task_tasker_id ) , true);

                         echo $error = CJSON::encode(array(
                                'status'=>'success',
                                'html'=>$html,
                             'accept' => $accept
                        ));
                }
                catch(Exception $e)
                {
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array("Task Tasker ID " => $task_tasker_id ) );
//                        if (CommonUtility::IsTraceEnabled())
//                        {
//                                        Yii::trace('Executing actionProposalReject() method','PosterController');
//                        }
//                        Yii::log('Poster.PublishProposal: reason:-'.$msg,CLogger::LEVEL_ERROR ,'PosterController');
                }
            }
            CommonUtility::endProfiling();
    }
    public function actionProposalReject()
    {
            if(CommonUtility::IsProfilingEnabled())
            { 
                    Yii::beginProfile('ProposalReject','application.controller.PosterController');
            }
    
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
            $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
            $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
            if($taskTasker)
            {
                $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_REJECTED;
                try
                {
                        if( !$taskTasker->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        $alert = new UserAlert();
                        try
                        {
                            $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                        }
                        $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                        $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_REJECT_PROPOSAL;
                        $alert->{Globals::FLD_NAME_FOR_USER_ID} = $taskTasker->{Globals::FLD_NAME_TASKER_ID}; 
                        $alert->{Globals::FLD_NAME_BY_USER_ID} =  Yii::app()->user->id;
                        $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                        $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        if(!$alert->save())
                        {   
                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                        }
                         $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
                                                //  Globals::FLD_NAME_COMMENTS => '',
                                            );
                        try
                        {
                                CommonUtility::addTaskActivity($taskTasker->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_REJECT , $otherInfo );
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                        }
                         $html = $this->renderPartial('//tasker/_notinterested',array('tasker_status' => $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} , 'tasker_id' => $taskTasker->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $task_tasker_id ) , true);
                        echo $error = CJSON::encode(array(
                                'status'=>'success',
                                'html'=>$html
                        ));
                }
                catch(Exception $e)
                {
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array("Task Tasker ID " => $task_tasker_id ) );
//                        if (CommonUtility::IsTraceEnabled())
//                        {
//                                        Yii::trace('Executing actionProposalReject() method','PosterController');
//                        }
//                        Yii::log('Poster.PublishProposal: reason:-'.$msg,CLogger::LEVEL_ERROR ,'PosterController');
                }
            }
            
           
            if(CommonUtility::IsProfilingEnabled())
            { 
                	Yii::endProfile('ProposalReject');
            }
    }
	
	public function actionMyTaskslist()
	{
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('MyTaskslist','application.controller.PosterController');
                }
                $task = new Task();
                @$state = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE];
                try
                {
                    $taskList = $task->getMyTaskListAsPoster($state);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                }
                $this->render('mytaskslist',array('task'=>$taskList));
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::endProfile('MyTaskslist');
                }
	}
	
//	public function actionajaxMyTaskslist()
//	{
//                if(CommonUtility::IsProfilingEnabled())
//                {
//                    Yii::beginProfile('ajaxMyTaskslist','application.controller.PosterController');
//                }
//                $task = new Task();
//                
//                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
//                Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
//                Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
//                Yii::app()->clientScript->scriptMap['jquery.yiilistview.js'] = false;
//                Yii::app()->clientScript->scriptMap['jquery.placeholder.js'] = false;
//                $this->render('_ajaxmytaskslist',array('task'=>$taskList,'state' =>$state,'task'=>$task));
//                if(CommonUtility::IsProfilingEnabled())
//                {
//                    Yii::endProfile('ajaxMyTaskslist');
//                }
//	}
        public function actionViewTaskPopup()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('ViewTaskPopup','application.controller.PosterController');
            }
            if(isset($_POST[Globals::FLD_NAME_TASK_ID]))
            {
                $task = Task::model()->findByPk($_POST[Globals::FLD_NAME_TASK_ID]);
                $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
            }
            $this->render('taskdetailpopup',array( 'task' => $task  , 'model' => $model));
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('ViewTaskPopup');
            }
	}
    
        public function actionViewProfile()
        {
            echo 'test';
        }
        public function actionTestPopover()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('TestPopover','application.controller.PosterController');
            }
           $this->renderPartial('_popovertest',array(
                                
                      ),false,true);
           if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('TestPopover');
            }
        }
		
		public function actionSaveReview()
		{
			if(CommonUtility::IsProfilingEnabled())
                        {
                            Yii::beginProfile('SaveReview','application.controller.PosterController');
                        }
			//print_r($_POST['Task']['tasker_review_comments']);exit;
			if(isset($_POST[Globals::FLD_NAME_TASK]))
			{
				$model = Task::model()->findByPk($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID]);
				//print_r($model);exit;
				
				if(@$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_REVIEW_COMMENTS])
				{
					$model->{Globals::FLD_NAME_TASKER_REVIEW_COMMENTS} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASKER_REVIEW_COMMENTS];
					$model->{Globals::FLD_NAME_TASKER_REVIEW_DT} = date(DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME);
				}
				else
				{
					@$model->{Globals::FLD_NAME_POSTER_REVIEW_COMMENTS} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_POSTER_REVIEW_COMMENTS];
					$model->{Globals::FLD_NAME_POSTER_REVIEW_DT} = date(DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME);
				}
			   // $model->user_id = Yii::app()->user->id;
			   try
			   {
					if($model->save())
					{
						$model = Task::model()->findByPk($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID]);
						try
						{
							$getReviews = UtilityHtml::getReviews($model);
						}
						catch(Exception $e)
						{             
							$msg = $e->getMessage();
							CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
						}
						echo CJSON::encode(array(
						'status'=>'success',  
						'reviews'=>  $getReviews,                  
						));
					}
					else
					{
						echo CJSON::encode(array(
						'status'=>'not',
						));
						throw new Exception(Yii::t('poster_savereview','unexpected_error'));
					} 
				}
				catch(Exception $e)
				{
					$msg = $e->getMessage();
					CommonUtility::catchErrorMsg( $msg , array("Task ID " => $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID] ) );
//					if (CommonUtility::IsTraceEnabled())
//					{
//						Yii::trace('Executing actionSaveReview() method','PosterController');
//					}
//					Yii::log('Poster.SaveReview: reason:-'.$msg,CLogger::LEVEL_ERROR ,'PosterController');
				}
			}
			else
			{
				echo CJSON::encode(array(
				'status'=>'not',
				));
			}               
			Yii::app()->end(); 
                                                      
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('SaveReview');
            }
		}
		
        public function actionReviewBox()
        {		
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('ReviewBox','application.controller.PosterController');
            }
            $id = $_GET[Globals::FLD_NAME_ID];   
            $user_type = $_GET[Globals::FLD_NAME_USER_TYPE];   
            if(isset($_GET[Globals::FLD_NAME_ID]))  
            {
                    $model= Task::model()->findByPk($id);          
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            }
            $this->renderPartial('reviewbox',array('model'=>$model,'user_type'=>$user_type),false,true);     
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('ReviewBox');
            }            

        }
        public function actionViewAllProposals()
        {		
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('ViewAllProposals','application.controller.PosterController');
            }
            @$task_id = $_GET[Globals::FLD_NAME_TASKID];
            $filterArray = '';
            $task = Task::model()->with('taskcategory','category','categorylocale')->findByPk($task_id);
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
             @$sort = $_GET[Globals::FLD_NAME_SORT];
             @$interest = $_GET[Globals::FLD_NAME_INTEREST];
           // print_r($locations);
            
            Yii::app()->clientScript->registerCoreScript('jquery');     
            Yii::app()->clientScript->registerCoreScript('jquery.ui'); 
            Yii::app()->clientScript->registerCoreScript('yiiactiveform');
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/fileuploader.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/chosen.jquery.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery.ui.timepicker.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery-ui-timepicker-addon.js");
            
            
            $mytask = new Task(); 
            $myTasks = $mytask->getMyTaskListAsPoster(Globals::DEFAULT_VAL_TASK_STATE_OPEN , Globals::DEFAULT_VAL_MY_TASK_LIST_LIMIT , false);
            $task_tasker = new TaskTasker();
            try
            {
                $getAllProposalsInDefualtOrder = $task_tasker->getProposalsOfTasks( $task_id  ,'','','','','','','',array(),'','','',true);
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
            
                if(isset($all))
                {
                    $proposals = $getAllProposalsInDefualtOrder;
                }
                else
                {
                    $values = array(
                       Globals::FLD_NAME_INTEREST => $interest,
                        'filterArray' => $filterArray
                    );
                    
                    $proposals = $task_tasker->getProposalsOfTasks( $task_id , $quickFilter , $taskerName ,$minPrice , $maxPrice , $taskerInRange , $locations ,$rating , $values , $sort );
                }                                
                $prices = $task_tasker -> getMaxAndMinPriceOfProposalsForTask( $task_id );
                $maxPrice = intval($prices[Globals::FLD_NAME_MAXPRICE]);
                $minPrice = intval($prices[Globals::FLD_NAME_MINPRICE]);
            	
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id ) );
            }
            $this->layout = '//layouts/noheader'; 
            $this->render('viewallproposals',array('task'=>$task , 'proposals' => $proposals ,  'maxPrice' => $maxPrice ,'minPrice' => $minPrice , 'taskLocation' => $taskLocation
                , "myTasks" => $myTasks ,'proposalIds' => $proposalIds));
                
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('ViewAllProposals');
            }
        }
        
        
        public function actionAutoInvite()
        {		
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('AutoInvite','application.controller.PosterController');
            }
            $msg = '';
            try
            {
                $task_id = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                $category_id = $_POST[Globals::FLD_NAME_TASK_CATEGORY_ID];    
                $limit = Globals::DEFAULT_VAL_AUTO_INVATATION_BY_SYSTEM; 
                               
                try
                {
                    $code = GetRequest::autoInvitation( $task_id , $category_id , $limit );
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Category ID" => $category_id) );                        
                }
                ///   
                if($code == '')
                {
                    echo CJSON::encode(array(
                        'status'=>'error'
                    ));
                }
                else
                {
                   echo CJSON::encode(array(
                        'status'=>'success'
                    )); 
                }
               
                
            }
            catch(Exception $e)
            {
                    //echo $e->getMessage();
                    CommonUtility::catchErrorMsg( $e->getMessage() , array("Task ID " => $task_id , 'Category ID' => $category_id ) );
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('AutoInvite');
            }
        }
        
        public function actionAjaxPopUp()
        {
           // echo 'test';exit;
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('AjaxPopUp','application.controller.PosterController');
            }
            $data = $_POST[Globals::FLD_NAME_ID];
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
     
            $result["html"] = $this->renderPartial('partial/_popupprofilecomplete',array('data' => $data) ,true,true);
            echo CJSON::encode($result);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('AjaxPopUp','application.controller.PosterController');
            }
        }
   
   public function actionMyTasks()
   {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('MyTasks','application.controller.PosterController');
        }
         Yii::app()->clientScript->registerCoreScript('jquery');     
            Yii::app()->clientScript->registerCoreScript('jquery.ui'); 
            Yii::app()->clientScript->registerCoreScript('yiiactiveform');
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/fileuploader.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/chosen.jquery.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery.ui.timepicker.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery-ui-timepicker-addon.js");
        $task = new Task();
        $filterArray = '';
        $category_id = '';
        @$subCategoryName = $_GET[Globals::FLD_NAME_SUBCATEGORYNAME];
//        @$state = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE];
        @$state = $_GET[Globals::FLD_NAME_TASK_STATE];
        @$taskKind = $_GET[Globals::FLD_NAME_TASKTYPE];
        @$categoryName = $_GET[Globals::FLD_NAME_CATEGORYNAME];
        @$skills = $_GET[Globals::FLD_NAME_TASK_SKILLS];
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
                try
                {
                    $filterArray = GetRequest::getTaskBySkills($skills , Yii::app()->user->id );
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id  ) );
                }
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
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id  ) );
                }
                try
                {
                    $filterArray = CommonUtility::getChildCategorysIdsFromParent($category_id);
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" => $category_id) );
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
                $taskList = $task->getMyTaskListAsPoster($state , $taskKind , $category_id , $filterArray , $skills , $rating ,$minPrice , $maxPrice , $minDate  , $maxDate , $sort , $taskTitle );
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
            
        
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('MyTasks');
        }
       
   } 
   
   public function actionFindTasker()
   {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('FindTasker');
        }
        
        $isPremiumLicense = Yii::app()->user->getState('is_poster_license');
           
            if(!$isPremiumLicense)
                throw new CHttpException(ErrorCode::ERROR_CODE_IS_POSTER_LICENSE,Yii::t('poster_createtask','To fiend a doer you need poster license.'));
        
        $tasker = new User();
        $model=$this->loadModel(Yii::app()->user->id);
        $filterArray = '';
        $mostexperienced = '';
        // echo $_GET["taskType"];
        @$quickFilter = $_GET[Globals::FLD_NAME_QUICK_FILTER];
        @$taskTitle = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE];
        @$startDate = $_GET[Globals::FLD_NAME_CREATED_AT];
        @$minPrice = $_GET[Globals::FLD_NAME_MINPRICE];
        @$maxPrice = $_GET[Globals::FLD_NAME_MAXPRICE];
        @$maxDate = $_GET[Globals::FLD_NAME_MAXDATE];
        @$minDate = $_GET[Globals::FLD_NAME_MINDATE];
        @$rating = $_GET[Globals::FLD_NAME_RATING];
        @$skills = $_GET[Globals::FLD_NAME_SKILLS_SMALL];
        @$taskerName = $_GET[Globals::FLD_NAME_USER_NAME];
        @$taskKind = $_GET[Globals::FLD_NAME_TASKTYPE];
        @$locations = $_GET[Globals::FLD_NAME_LOCATIONS];
        
        @$sort = $_GET[Globals::FLD_NAME_SORT];
        
        try
        {
            if( $quickFilter == Globals::FLD_NAME_TASK_DONE_CNT )
            {
                $mostexperienced = Globals::FLD_NAME_TASK_DONE_CNT;
            }
            if( $quickFilter == Globals::FLD_NAME_PREVIOUSLY_WORKED )
            {
                try
                {
                    $filterArray = GetRequest::prevouslyHiredTaskerByPosterOnlyIds( Yii::app()->user->id );
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                }
            }
//            if( $quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE ) 
//            {
//                try
//                {
//                    $filterArray = GetRequest::getPotentialTaskerOfUser();
//                }
//                catch(Exception $e)
//                {             
//                        $msg = $e->getMessage();
//                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
//                }
//            }
//            if( $quickFilter == Globals::FLD_NAME_SELECTION_TYPE ) 
//            {
//                try
//                {
//                    $filterArray = GetRequest::getInvitedTaskersByUser();
//                }
//                catch(Exception $e)
//                {             
//                        $msg = $e->getMessage();
//                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
//                }
//            }
           // print_r($filterArray);
            $criteria = array( 
                            Globals::FLD_NAME_QUICK_FILTER => $quickFilter , 
                            Globals::FLD_NAME_USER_NAME => $taskerName,
                            Globals::FLD_NAME_RATING => $rating,
                            Globals::FLD_NAME_LOCATIONS => $locations,
                            Globals::FLD_NAME_SORT => $sort,
                            Globals::FLD_NAME_MOST_EXPERIENCED => $mostexperienced,
                
                                'filterArray' => $filterArray   ); 
//          print_r($criteria);
//          exit();
            $taskerList = $tasker->getTaskerList($criteria);            
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
        }
        try
        {
            $taskList = Task::getMyPostedTaskList();
        }
        catch(Exception $e)
        {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
        } 
        $this->layout = '//layouts/noheader'; 
        $this->render('taskerlist',array('taskerList'=>$taskerList,'taskList' => $taskList , 'model' => $model));
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('FindTasker');
        }
   }
   public function actionfilterformmytasks()
   {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('filterformmytasks','application.controller.PosterController');
        }
        $userAtrib = new UserAttrib();
        $userAtrib->scenario = 'savefilter';
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
       // Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        //$action = "filterformmytasks";
        $this->renderPartial('//tasker/_savefilter',array( 'userAtrib'=>$userAtrib ),false,true);
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('filterformmytasks');
        }
       
   }
   public function actionsavefiltermytasks()
   {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('savefiltermytasks','application.controller.PosterController');
        }
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
            $userAtrib->{Globals::FLD_NAME_ATTRIB_TYPE} = Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS;
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
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('savefiltermytasks');
        }
       
   }
   public function actiongettaskerlistfilters()
   {
        CommonUtility::startProfiling();
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        Yii::app()->clientScript->scriptMap['chosen.jquery.js'] = false;
        $rating = $_POST[Globals::FLD_NAME_RATING];       
        $taskerName = $_POST[Globals::FLD_NAME_TASKERNAME];
       
        $html = $this->renderPartial('_findtaskersfiltes',array('taskerName' => $taskerName ,'rating' => $rating),true,true);
        echo  $error = CJSON::encode(array(
                    'status'=>'success',
                 'html'=>$html,
                ));
       CommonUtility::endProfiling();
       
   }
   public function actiongetproposalslistfilters()
   {
        CommonUtility::startProfiling();
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        Yii::app()->clientScript->scriptMap['chosen.jquery.js'] = false;
        $rating = $_POST[Globals::FLD_NAME_RATING];       
        $taskerName = $_POST[Globals::FLD_NAME_TASKERNAME];
        $maxPriceValue = $_POST[Globals::FLD_NAME_MAXPRICEVALUE];       
        $minPriceValue = $_POST[Globals::FLD_NAME_MINPRICEVALUE];
        $maxPrice = $_POST[Globals::FLD_NAME_MAXPRICE];       
        $minPrice = $_POST[Globals::FLD_NAME_MINPRICE];
        $isFieldAccessByTaskTypeVirtual= $_POST['isFieldAccessByTaskTypeVirtual'];
        
        $html = $this->renderPartial('_viewallproposalsfilters',array('rating' => $rating, 'taskerName' => $taskerName , 'maxPriceValue' => $maxPriceValue , 'minPriceValue' => $minPriceValue , 'maxPrice' => $maxPrice , 'minPrice' => $minPrice , 'isFieldAccessByTaskTypeVirtual' => $isFieldAccessByTaskTypeVirtual),true,true);
        echo  $error = CJSON::encode(array(
                    'status'=>'success',
                    'html'=>$html,
                ));
       CommonUtility::endProfiling();
       
   }
   
    public function actionUploadTaskerReceipt()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('UploadTaskerReceipt','application.controller.PosterController.ajax');
        }
        if($_POST)
        {
            
            $model = new TaskTaskerReceipt();
            $task_id = $_POST[Globals::FLD_NAME_TASK_ID];
            $attachment = $_POST[Globals::FLD_NAME_PROPOSALATTACHMENTS][0];
            $model->{Globals::FLD_NAME_TASK_TASKER_ID} = Yii::app()->user->id;
            $model->{Globals::FLD_NAME_TASKER_RECEIPT_ATTACHMENT} = $attachment;
            try
            {
                if(!$model->save())
                {
                                throw new Exception(Yii::t('tasker_createtask','upload tasker receipt'));
                }
                $task_tasker_receipt_id = $model->getPrimaryKey();

            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task Tasker Receipt ID" => $task_tasker_receipt_id) );
            }
            echo CJSON::encode(array(
                'status'=>'success'
            ));
        }
        if(CommonUtility::IsProfilingEnabled())
        { 
            Yii::endProfile('UploadTaskerReceipt');
        }
    }
    public function actionInvitedoer()
    {
        CommonUtility::startProfiling();
        
        $task_id = $_POST['task_id'];
        $doer_id = $_POST['doer_id'];
        
        $model = $this->loadModel(Yii::app()->user->id);
        
        $tasker = new TaskTasker();
        $task = Task::model()->findByPk($task_id);
        $tasker->{Globals::FLD_NAME_TASK_ID} = $task_id;

        $tasker->{Globals::FLD_NAME_TASKER_ID} = $doer_id;        
        $tasker->{Globals::FLD_NAME_SELECTION_TYPE} = Globals::DEFAULT_VAL_INVITE;
        $tasker->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
        $tasker->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
        $tasker->{Globals::FLD_NAME_TASKER_LOCATION_GEO_AREA} = $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE};
        $tasker->{Globals::FLD_NAME_IS_INVITED} = 1;

        $task->{Globals::FLD_NAME_INVITED_CNT} += 1;
        try
        {
            if(!$tasker->save())
            {
                            throw new Exception(Yii::t('tasker_createtask','invite tasker'));
            }
            $task_tasker_id = $tasker->getPrimaryKey();

                $alert = new UserAlert();
                try
                {
                    $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task Tasker ID" => $task_tasker_id) );
                }
                $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_TASKER_INVITED;
                $alert->{Globals::FLD_NAME_FOR_USER_ID} = $tasker->{Globals::FLD_NAME_TASKER_ID}; 
                $alert->{Globals::FLD_NAME_BY_USER_ID} =  Yii::app()->user->id;
                $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                if(!$alert->save())
                {   
                    throw new Exception(Yii::t('poster_saveproposal','user alert'));   
                }
            /////////////////
            if(!$task->update())
            {
                            throw new Exception(Yii::t('tasker_createtask','update task'));
            }


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
    }
    
    public function actionProjectcomplationbyposter()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Projectcomplationbyposter','application.controller.PosterController');
        }
        if($_POST)
        {               
            $receiptsIds = $_POST[Globals::FLD_NAME_PROJECT_COMPLATE_RECEIPT_IDS];
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
            $tasker_id = $_POST[Globals::FLD_NAME_TASKER_ID];
            $over_rt = $_POST[Globals::FLD_NAME_PROJECT_COMPLATE_OVER_RT];            
            $ratings148 = $_POST[Globals::FLD_NAME_PROJECT_COMPLATE_RATING_1];
            $ratings151 = $_POST[Globals::FLD_NAME_PROJECT_COMPLATE_RATING_2];
            $total_payment = $_POST[Globals::FLD_NAME_PROJECT_COMPLATE_TOTAL_PAYMENT];            
            $project_price = $_POST[Globals::FLD_NAME_PROJECT_COMPLATE_PROJECT_PRICE];
            $bonusval = $_POST[Globals::FLD_NAME_PROJECT_COMPLATE_BONUS_VALUE];
            
            CommonUtility::updateTaskerReceipt($receiptsIds);
            
            $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
            $taskTasker->{Globals::FLD_NAME_TASKER_TOTAL_AMOUNT_RECEIVED} = $total_payment;
            $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_FINISHED;            
            
            if( !$taskTasker->Update())
            {   
                throw new Exception(Yii::t('poster_saveposterrating','Task amount as tasker in tasktasker not update'));
            }
            
            $user = $this->loadModel($tasker_id);
            $min_max_rating = CommonUtility::getMinAndMaxRatingForTasker($tasker_id,$over_rt);
            $user->{Globals::FLD_NAME_TASKER_RATING_MIN_AS_TASKER} = $min_max_rating[Globals::FLD_NAME_PROJECT_COMPLATE_MIN_RATING];
            $user->{Globals::FLD_NAME_TASKER_RATING_MAX_AS_TASKER} = $min_max_rating[Globals::FLD_NAME_PROJECT_COMPLATE_MAX_RATING];
            $user->{Globals::FLD_NAME_TASKER_RATING_TOTAL_AS_TASKER} += $over_rt;
            $user->{Globals::FLD_NAME_TASKER_RATING_COUNT_AS_TASKER} += Globals::DEFAULT_VAL_1;
            $avg_rating = $user->{Globals::FLD_NAME_TASKER_RATING_TOTAL_AS_TASKER}/$user->{Globals::FLD_NAME_TASKER_RATING_COUNT_AS_TASKER};
            $user->{Globals::FLD_NAME_RATING_AVG_AS_TASKER} = $avg_rating;
            if( !$user->update())
            {   
                throw new Exception(Yii::t('poster_saveposterrating','user rating as tasker not save'));
            }
                        
            echo CJSON::encode(array(
                'status'=>'success'
            ));
        }
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Projectcomplationbyposter','application.controller.PosterController');
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
    
    public function actionDeleteUploadedReceiptFile()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('DeleteUploadedReceiptFile','application.controller.PosterController');
        }
        if($_POST)
        {
            $receipt_id = $_POST[Globals::FLD_NAME_RECEIPT_ID];
            $model = new TaskTaskerReceipt();
            TaskTaskerReceipt::model()->deleteByPk($receipt_id);
            echo CJSON::encode(array(
                'status'=>'success'
            ));
        }
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('DeleteUploadedReceiptFile','application.controller.PosterController');
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
    
    public function actionCancelacceptedbydoer()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Cancelacceptedbydoer','application.controller.PosterController');
        }
        $tasktaskerid = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
        
         $taskTasker = TaskTasker::model()->findByPK($tasktaskerid);
         $taskTasker->task_cancel_accept_doer = 1;    
         $taskTasker->task_cancel_accept_doer_date = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME) ; 
         
         if(!$taskTasker->Update())
         {
             throw new Exception(Yii::t('poster_saveproposal','Cancel accepted by doer'));  
         }
         
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Cancelacceptedbydoer','application.controller.PosterController');
        }
    }      
}