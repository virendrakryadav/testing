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
                            'actions'=>array('ajaxgetpreferredlocationlist','taskpreview','taskdetail','submitconfirmtask','setconfirmtaskpage'),
                            'users'=>array('*'),
                    ),
                    array('allow', // allow authenticated user to perform 'create' and 'update' actions
                            'actions'=>array('createtask','loadvirtualtask','loadinpersontask','loadinstanttask','getsubcategories','getsubcategoriespopup','selectcategory',
                                
                                
                                
                                
                                'savevirtualtask','uploadtaskfiles'
                                ,'loadcategoryform','loadvirtualtaskpreview','loadcategoryformtoupdate','editvirtualtask','loadpreviuostask','loadtemplatecategory'
                                ,'saveinpersontask','loadinpersontaskpreview','editinpersontask','saveinstanttask',
                                'loadinstanttaskpreview','editinstanttask','gettemplatedetail','publishtask','createtaskbackup',
                                'browsetemplatecategory','taskersetmap','saveproposal','confirmtask', 'viewprofile','loadproposalpreview','proposal'
                                ,'editproposal','publishproposal','proposalaccept','proposalreject','mytaskslist','ajaxMyTaskslist','viewtaskpopup','validateproposal','testpopover','savereview','reviewbox',
                                'viewallproposals','autoinvite','ajaxpopup','edittask','canceltask','mytasks','findtasker','filterformmytasks','savefiltermytasks',
                                'proposalshowinterest','gettaskerlistfilters','getproposalslistfilters' ,'canceltaskform',),
                            'users'=>array('@'),
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
     public function actionCreateTask()
    {	
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('CreateTask','application.controller.PosterController');
            }
            $task = new Task();
            Yii::app()->clientScript->registerCoreScript('jquery');     
            Yii::app()->clientScript->registerCoreScript('jquery.ui'); 
            Yii::app()->clientScript->registerCoreScript('yiiactiveform');
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/fileuploader.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/chosen.jquery.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery.ui.timepicker.js");
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/jquery-ui-timepicker-addon.js");

           

            $this->layout = '//layouts/noheader';
            $this->render('createtask');
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('CreateTask');
            }

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
            $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
            $subCategories =  Category::getChildCategoryByID($category_id);
            if(!$subCategories)
            {
                throw new Exception("no categories found");
            }
            $categoriesSlider = $this->renderPartial('partial/_categories_slider',array( 'subCategories' => $subCategories ,'category_id' => $category_id) , true , true);
            $return["status"] = 'success';
            $return["html"] = $categoriesSlider;
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
            $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
            $subCategories =  Category::getChildCategoryByID($category_id);
            if(!$subCategories)
            {
                throw new Exception("no categories found");
            }
            $categoriesSlider = $this->renderPartial('partial/_categories_popup',array( 'subCategories' => $subCategories ,'category_id' => $category_id) , true , true);
            $return["status"] = 'success';
            $return["html"] = $categoriesSlider;
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
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('LoadVirtualTask','application.controller.PosterController');
        }

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
                   
                    
                    if(CommonUtility::IsProfilingEnabled())
                    {
                            Yii::endProfile('LoadVirtualTask');
                    }

    }
    public function actionLoadCategoryForm()
	{	
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('LoadCategoryForm','application.controller.PosterController');
                }
                $task = new Task();
                
                $category_id = $_POST[Globals::FLD_NAME_CATEGORY_ID];
                $type = $_POST[Globals::FLD_NAME_FORM_TYPE];               
                $category = Category::getCategoryListByID($category_id);
// print_r($category);
//                exit();
//                $taskSkill = new TaskSkill();
//                $taskQuestion = new TaskQuestion();
                $taskLocation = new TaskLocation();
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
                $model=$this->loadModel(Yii::app()->user->id);
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
                

                
              
                $return["template"] = $this->renderPartial('_loadtemplatecategory',array('model'=> $category ),true,true);
            
            
               if($type==Globals::DEFAULT_VAL_INSTANT)
               {
			   		try
					{
                    	$taskList = Task::getUserTaskListByTypeandCategory( 'i' , $category_id );
					}
					catch(Exception $e)
					{             
						$msg = $e->getMessage();
						CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
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
						CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
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
						CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
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
                echo CJSON::encode($return);
                if(CommonUtility::IsProfilingEnabled())
                { 
                    Yii::endProfile('LoadCategoryForm');
                }
            
	}
    //selectcategory
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

    public function actionGettemplatedetail()
    {        
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Gettemplatedetail','application.controller.PosterController');
        }
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  
        $category_id = $_GET[Globals::FLD_NAME_CATEGORY_ID];               
        
        try
        {
            $category = Category::getCategoryListByID($_GET[Globals::FLD_NAME_CATEGORY_ID]);  
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
        $this->renderPartial('templatedetail',array( 'category'=>$category,'msg'=>$msg,'templateId'=>$_GET[Globals::FLD_NAME_TEMPLATEID]),false,true);
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Gettemplatedetail');
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
			$this->renderPartial('virtualtaskpreview', 
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
            @$refresh = $_POST['refresh'];
            $task = Task::model()->findByPk($task_id);
            $task->scenario = 'cancelTask';
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $html = $this->renderPartial('_canceltaskform',array('task'=>$task , 'refresh' => $refresh),true,true);
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
                    if( !$task->update())
                        {   
                            throw new Exception(Yii::t('poster_editinpersontask','unexpected_error'));
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
                    $activitySubType = UtilityHtml::GetActivitySubType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        $otherInfo = array( Globals::FLD_NAME_ACTIVITY_SUBTYPE => $activitySubType );
                        CommonUtility::addTaskActivity($task_id , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_TASK_CANCEL , $otherInfo );
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
        public function actionSaveVirtualTask()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('SaveVirtualTask','application.controller.PosterController');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task = new Task();
            
            $taskCategory = new TaskCategory();
            
            $taskLocation = new TaskLocation();
            $task->scenario = Globals::VIRTUAL_TASK;
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
                    if(isset($to_publish))
                    {
                        $task->{Globals::FLD_NAME_VALID_FROM_DT} = date(Globals::DEFAULT_VAL_DATE_FORMATE_YMD);
                        $task->{Globals::FLD_NAME_BID_START_DATE}  = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                        $task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_BID_DURATION]));
                    }
                   	try
					{
                    //$task->{Globals::FLD_NAME_TASK_START_DATE}=CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_START_DATE]);
                        $task->{Globals::FLD_NAME_TASK_START_DATE}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_START_DATE];
			
                    
                                        }
					catch(Exception $e)
					{             
						$msg = $e->getMessage();
						CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );
					}
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
                    //$task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} =CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_BID_CLOSE_DATE]);
                    $task->{Globals::FLD_NAME_PRICE}=$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PRICE];
                    $task->{Globals::FLD_NAME_PAYMENT_MODE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_PAYMENT_MODE];
                    $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                    $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_O;
                    $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                    $task->{Globals::FLD_NAME_CREATOR_ROLE}=Globals::DEFAULT_VAL_P;
                    $task->{Globals::FLD_NAME_TASK_KIND}=Globals::DEFAULT_VAL_V;
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
                        $task->{Globals::FLD_NAME_TASK_ATTACHMENTS} = $files;
                    }
                    try
                    {
                        if( !$task->save())
                        {   
                            throw new Exception(Yii::t('poster_savevirtualtask','unexpected_error'));
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

//                        echo $_POST[Globals::FLD_NAME_TASK_LOCATION]["location_type"];
//                        exit;
                        if(!$taskCategory->save())
                        {
                                throw new Exception(Yii::t('poster_savevirtualtask','unexpected_error'));
                        }

                        TaskSkill::model()->deleteAll(Globals::FLD_NAME_TASK_ID.'=:id', array(':id' => $insertedId));
                        TaskQuestion::model()->deleteAll(Globals::FLD_NAME_TASK_ID.'=:id', array(':id' => $insertedId));
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
                                                throw new Exception(Yii::t('poster_savevirtualtask','unexpected_error'));
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
                                                throw new Exception(Yii::t('poster_savevirtualtask','unexpected_error'));
                                        }
                                        //echo $question;
                                }
                        }

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
                                                if(!$taskLocation->save())
                                                {
                                                        throw new Exception(Yii::t('poster_savevirtualtask','unexpected_error'));
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
                                        'category_id'=>$category_id
                                ));

    //echo 'hiii';
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "Task ID" => $insertedId ,"User ID" =>Yii::app()->user->id ,"Category ID" =>$category_id) );
                }    
            }
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('SaveVirtualTask');
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
            $model=$this->loadModel(Yii::app()->user->id);
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder = Globals::FRONT_USER_PORTFOLIO_TEMP_PATH;
            $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
            $allowedExtensions = $allowArray;//allowDocuments User Image allow
            $sizeLimit = Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE];// maximum file size in bytes'
            $fileNameSlugBefore = $model->{Globals::FLD_NAME_USER_ID}.Globals::DEFAULT_VAL_UNDERSCORE.time();
            $fileNameSlugAfter = Globals::FRONT_USER_USER_IMAGE_NAME_SLUG;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder,false,$fileNameSlugBefore,$fileNameSlugAfter);
            $return = htmlspecialchars(CJSON::encode($result), ENT_NOQUOTES);
            $fileSize=filesize($folder.$result[Globals::FLD_NAME_FILENAME]);//GETTING FILE SIZE
            $fileName=$result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME
            
            echo $fileName;// it's array
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
        public function actionTaskDetail()
	{
                if(CommonUtility::IsProfilingEnabled())
                { 
                        Yii::beginProfile('Taskdetail','application.controller.PosterController');
                }
                
//                Yii::app()->clientScript->registerMetaTag('mogtasdasdasdas', 'sdf', null, array('id'=>'meta_og_title', 'property' => 'og:title'), 'meta_og_title');
//                Yii::app()->clientScript->registerMetaTag('/greencometdev/images/logo.jpg', '', null, array('id'=>'meta_og_image', 'property' => 'og:image'), 'meta_og_image');
//                Yii::app()->clientScript->registerMetaTag('mogsasdadasdasdn', 'sdff', null, array('id'=>'meta_og_site_name', 'property' => 'og:site_name'), 'meta_og_site_name');
//                Yii::app()->clientScript->registerMetaTag('mogdasdasdasdasdasdasd', 'sdfsd', null, array('id'=>'meta_og_description', 'property' => 'og:description'), 'meta_og_description');
                $task_id = $_GET[Globals::FLD_NAME_TASKID];
                $taskType = $_GET[Globals::FLD_NAME_TASKTYPE];
                $key = '';
                if(isset($_POST[Globals::FLD_NAME_KEY]))
                {
                    $key = $_POST[Globals::FLD_NAME_KEY];
                }          
                
                $task = Task::model()->with('taskcategory','category','categorylocale')->findByPk($task_id);
                
               
                
                $taskImage = CommonUtility::getTaskImageForShare($task->{Globals::FLD_NAME_TASK_ID});
                
                Yii::app()->clientScript->registerMetaTag($taskImage, '', null, array('id'=>'meta_og_image', 'property' => 'og:image'), 'meta_og_image');

                Yii::app()->clientScript->registerMetaTag($task->{Globals::FLD_NAME_TITLE}, '', null, array('id'=>'meta_og_title', 'property' => 'og:title'), 'meta_og_title');
                //Yii::app()->clientScript->registerMetaTag(CommonUtility::getPublicImageUri( "sprite.png" ), '', null, array('id'=>'meta_og_image', 'property' => 'og:image'), 'meta_og_image');
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
				//echo '<pre>';
                //print_r($task);exit;  
              //  print_r($proposals);
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
				// echo '<pre>';
				// print_r($taskSkills);exit;
                $taskQuestionReply = new TaskQuestionReply();
                $taskTasker->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
                $taskQuestionReply->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
                $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
                $currentUser = '';
                if( Yii::app()->user->id )
                   $currentUser = $this->loadModel(Yii::app()->user->id);
               
                
				//print_r($model);
                try
                {
                    $proposals = GetRequest::getProposalsByTask($task->{Globals::FLD_NAME_TASK_ID},$task->{Globals::FLD_NAME_CREATER_USER_ID} , Globals::DEFAULT_VAL_TASK_DETAIL_PORPOSAL_SIDE_BAR_LIMIT ); 
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
				//print_r($relatedTask);
                $this->render('taskdetail',
                            array( 'task'=>$task,
                                    'model'=>$model,
                                    'question'=>$question,
                                    'taskQuestionReply'=>$taskQuestionReply,
                                
                                    'key'=>$key,
                                    'taskTasker'=>$taskTasker,
                                    'proposals'=>$proposals,
                                    'relatedTask'=>$relatedTask,
                                    'taskType'=>$taskType,
                                    'currentUser'=>$currentUser,
                ));
            if(CommonUtility::IsProfilingEnabled())
            { 
                Yii::endProfile('Taskdetail');
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
                   // echo $task->{Globals::FLD_NAME_END_TIME};
                   // echo CommonUtility::leftTimingInstant($task->{Globals::FLD_NAME_END_TIME});
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
							}
							try
							{
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
										$taskQuestionReply->{Globals::FLD_NAME_QUESTION_ID} = $question_id ;
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
            
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER][Globals::FLD_NAME_TASK_TASKER_ID];
         
            $taskTasker=TaskTasker::model()->findByPk($task_tasker_id);
            
            $taskQuestionReply = new TaskQuestionReply();
            $model = $this->loadModel(Yii::app()->user->id);
            $taskTasker->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
            $taskQuestionReply->scenario = Globals::SCENARIO_TASKER_SAVE_PROPOSAL;
            //print_r($_POST);
            
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
            }
            if(isset($_POST[Globals::FLD_NAME_TASK_TASKER]))
            {
                    $task_id =  $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                    $task=Task::model()->findByPk($task_id);
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
											foreach ($_POST["TaskQuestionReply"] as $question_id => $answers)
											{
												$taskQuestionReply = new TaskQuestionReply();
												$taskQuestionReply->{Globals::FLD_NAME_TASK_ID} = $task_id ;
												$taskQuestionReply->{Globals::FLD_NAME_TASKER_ID} = Yii::app()->user->id; ;
												$taskQuestionReply->{Globals::FLD_NAME_QUESTION_ID} = $question_id ;
												if(isset($answers[Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC]))
												{
													$taskQuestionReply->{Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC} = $answers[Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC] ;
												}
												if(isset($answers[Globals::FLD_NAME_REPLY_YESNO]))
												{
													$taskQuestionReply->{Globals::FLD_NAME_REPLY_YESNO} = $answers[Globals::FLD_NAME_REPLY_YESNO] ;
												}
												$taskQuestionReply->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
												if( !$taskQuestionReply->save())
												{   
														throw new Exception(Yii::t('poster_editproposal','unexpected_error'));
												}
											}
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
                     'task_tasker_id' => $task_tasker_id,
                     'taskTasker' => $taskTasker,
                     'question' => $question,
                     'model' => $model,
                     'task' => $task,
                     'taskQuestionReply' => $taskQuestionReply,
                     'task_id' => $task_id,
                     'proposals' => $proposals,
                         'currentUser'=>$currentUser,
                     
                      ),false,true);
           }
           else
           {
                     $this->renderPartial('_proposalfrom',array(
                     'task_tasker_id' => $task_tasker_id,
                     'taskTasker' => $taskTasker,
                     'question' => $question,
                     'model' => $model,
                     'task' => $task,
                     'taskQuestionReply' => $taskQuestionReply,
                     'task_id' => $task_id,
                         'currentUser'=>$currentUser,
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
    public function actionProposalAccept()
    {
            if(CommonUtility::IsProfilingEnabled())
            { 
                    Yii::beginProfile('ProposalAccept','application.controller.PosterController');
            }
    
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
            
            $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
            $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
            try
			{
            	$proposals = GetRequest::getProposalsByTask($task->{Globals::FLD_NAME_TASK_ID},$task->{Globals::FLD_NAME_CREATER_USER_ID} , Globals::DEFAULT_VAL_TASK_DETAIL_PORPOSAL_SIDE_BAR_LIMIT );    
			}
			catch(Exception $e)
			{             
				$msg = $e->getMessage();
				CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
			}
            $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            
            if($taskTasker)
            {
                $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_SELECTED;
                $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_TASK_STATE_ASSIGNED;
                $task->{Globals::FLD_NAME_PROPOSALS_ACCPT_CNT} += 1;
                try
                {
                        if( !$taskTasker->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        if( !$task->update())
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
                        $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_ACCEPT_PROPOSAL;
                        $alert->{Globals::FLD_NAME_FOR_USER_ID} = $taskTasker->{Globals::FLD_NAME_TASKER_ID};   
                        $alert->{Globals::FLD_NAME_BY_USER_ID} = Yii::app()->user->id; 
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
                            CommonUtility::addTaskActivity($taskTasker->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_ACCEPT , $otherInfo );
                        }
                        catch(Exception $e)
                        {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$task_id , "Task Tasker ID" => $task_tasker_id) );
                        }
//                        $this->renderPartial('_proposalpublished',array(
//                                'task_tasker_id' => $task_tasker_id,
//                                'taskTasker' => $taskTasker,
//                                'model' => $model,
//                                'proposals' => $proposals,
//                             'task' => $task,
//
//                      ),false,true);
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
            
           
            if(CommonUtility::IsProfilingEnabled())
            { 
                	Yii::endProfile('ProposalAccept');
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
            if (CommonUtility::IsDebugEnabled())
            {
                    Yii::log($data, CLogger::LEVEL_INFO, 'PosterController.AjaxPopUp');
            } 
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
            $result["html"] = $this->renderPartial('_popupprofilecomplete',array('data' => $data) ,true,true);
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
        @$state = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE];
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
        //echo '<pre>';
        //print_r($taskList);exit;
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
        $tasker = new User();
        $model=$this->loadModel(Yii::app()->user->id);
        $filterArray = '';

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
        try
        {
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
           // print_r($filterArray);
            $criteria = array( 
                            Globals::FLD_NAME_QUICK_FILTER => $quickFilter , 
                            Globals::FLD_NAME_USER_NAME => $taskerName,
                            Globals::FLD_NAME_RATING => $rating,
                            Globals::FLD_NAME_LOCATIONS => $locations,
                
                                'filterArray' => $filterArray   ); 
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
        $maxPriceValue = $_POST['maxPriceValue'];       
        $minPriceValue = $_POST['minPriceValue'];
        $maxPrice = $_POST['maxPrice'];       
        $minPrice = $_POST['minPrice'];
        $isFieldAccessByTaskTypeVirtual= $_POST['isFieldAccessByTaskTypeVirtual'];
        
        $html = $this->renderPartial('_viewallproposalsfilters',array('rating' => $rating, 'taskerName' => $taskerName , 'maxPriceValue' => $maxPriceValue , 'minPriceValue' => $minPriceValue , 'maxPrice' => $maxPrice , 'minPrice' => $minPrice , 'isFieldAccessByTaskTypeVirtual' => $isFieldAccessByTaskTypeVirtual),true,true);
        echo  $error = CJSON::encode(array(
                    'status'=>'success',
                    'html'=>$html,
                ));
       CommonUtility::endProfiling();
       
   }
}