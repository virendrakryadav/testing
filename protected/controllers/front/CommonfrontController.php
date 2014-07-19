<?php

class CommonfrontController extends Controller
{
	public function actionIndex()
	{
            $this->render('index');
	}
        public function actionAjaxSetUrlSession()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('AjaxSetUrlSession','application.controller.CommonfrontController');
            }
            Yii::app()->user->setState(Globals::FLD_NAME_PAGE_URL,NULL);
            $url = $_GET[Globals::FLD_NAME_URL];
            $url = str_replace(Globals::DEFAULT_VAL_URL_BREAK, Globals::DEFAULT_VAL_AND, $url);
            Yii::app()->user->setState(Globals::FLD_NAME_PAGE_URL,$url);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('AjaxSetUrlSession');
            }
            // to show dropdown for page rows selection
          
        }
        public function actionAjaxGetFieldLabel()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('AjaxGetFieldLabel','application.controller.CommonfrontController');
            }
            $thisname = $_GET[Globals::FLD_NAME_THIS_NAME];
            $model = new User;
            $label = CHtml::activeLabel($model,$thisname);
            echo strip_tags($label);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('AjaxGetFieldLabel');
            }
        }
      
	public function loadModel($classname, $id)
	{
            $model=$classname::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
            return $model;
	}
	public function actionSetcurrentview()
	{
            $actionname = $_POST['actionname'];
            $currentView = $_POST['currentView'];            
            Yii::app()->user->setState($actionname,$currentView);            
            return true;
	}
        public function actionUserPic()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserPic','application.controller.CommonfrontController');
            }
//            $model=$this->loadModel($_GET['userId']);
            $model=User::model()->findByPk($_GET[Globals::FLD_NAME_USERID]);
            if(isset($model->{Globals::FLD_NAME_USER_ID}))
            {
                try
                {
                    $image = CommonUtility::getUrlFromJson($model->{Globals::FLD_NAME_PROFILE_INFO},Globals::FLD_NAME_PIC,Globals::DEFAULT_VAL_NULL);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => $model->{Globals::FLD_NAME_USER_ID}) );
                }
                if($image!=Globals::DEFAULT_VAL_NULL && file_exists(Globals::FOLDER_BACK_PATH.$image))
                {
                  $image = Globals::FOLDER_BACK_PATH.$image;
                }
                else
                {
                   $image = Globals::IMAGE_AVATAR;   
                }
            }
            else 
            {
                throw new CHttpException(404,'Content not found.');
            }
              
            //$image= '../greencometdev/media/8171/28_1392144425_task_uploaded.png';
            header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
            header(Globals::HEADER_CONTENT_LENGTH. filesize($image));
            readfile($image);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserPic');
            }
        }
		
	public function actionSmallPic()
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('SmallPic','application.controller.CommonfrontController');
            }
            $model = User::model()->findByPk($_GET[Globals::FLD_NAME_USERID]);
            @$size = $_GET[Globals::FLD_NAME_DIMENSION];
            if(isset($model->{Globals::FLD_NAME_USER_ID}))
            {
                try
                {
                    $image = CommonUtility::getUrlFromJson($model->{Globals::FLD_NAME_PROFILE_INFO},Globals::FLD_NAME_PIC,$size);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => $model->{Globals::FLD_NAME_USER_ID}) );
                }
                if($image!=Globals::DEFAULT_VAL_NULL && file_exists(Globals::FOLDER_BACK_PATH.$image) )
                {
                    $image = Globals::FOLDER_BACK_PATH.$image;
                }
                else
                {
                    $avatar = Globals::IMAGE_AVATAR;
                    try
                    {
                        $image = CommonUtility::getDEFAULTImageUrl($avatar,$size,Globals::BASE_URL_PUBLIC_IMAGE_DIR);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg($msg);
                    }
                     $image = Globals::FOLDER_BACK_PATH.$image;
                   //$image = Globals::IMAGE_AVATAR;   
                }
            }
            else 
            {
               // $image = Globals::IMAGE_NOT_FOUND;   
                 throw new CHttpException(404,'Content not found.');
            }
            header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
            header(Globals::HEADER_CONTENT_LENGTH. filesize($image));
            readfile($image);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('SmallPic');
            }
        }
        
	public function actionUserVideo()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserVideo','application.controller.CommonfrontController');
            }
            //$model=$this->loadModel($_GET['userId']);
            $model=User::model()->findByPk($_GET[Globals::FLD_NAME_USERID]);
            if(isset($model->{Globals::FLD_NAME_USER_ID}))
            {           
                try
                {
                    $video = CommonUtility::getUrlFromJson($model->{Globals::FLD_NAME_PROFILE_INFO},Globals::FLD_NAME_VIDEO);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => $model->{Globals::FLD_NAME_USER_ID}) );
                }
                if($video!=Globals::DEFAULT_VAL_NULL)
                {
                    header(Globals::HEADER_CONTENT_TYPE_VIDEO_MP4);
                   // header(Globals::HEADER_CONTENT_TYPE_VIDEO_MPEG);
                    header(Globals::HEADER_ACCEPT_RANGES_BYTES);
                    $video = Globals::FOLDER_BACK_PATH.$video;
                }
                else
                {
                    header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
                    $video = Globals::IMAGE_AVATAR;
                }
            }
            else 
            {
                 throw new CHttpException(404,'Content not found.');
            }
            //$video= '../greencometdev/media/9652/15_1392037120_uploaded.mp4';
            
            header(Globals::HEADER_CONTENT_LENGTH. filesize($video));
            readfile($video);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserVideo');
            }
        }
	
        

    public function actionCatPic()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('CatPic','application.controller.CommonfrontController');
            }
            $model = CategoryLocale::model()->findByAttributes(array("category_id" =>$_GET[Globals::FLD_NAME_CATGID]));
            @$size = $_GET[Globals::FLD_NAME_DIMENSION];
            if(isset($model->{Globals::FLD_NAME_CATEGORY_ID}))
            {
                try
                {
                    $image = CommonUtility::getCategoryImageUrl($model->{Globals::FLD_NAME_CATEGORY_IMAGE},$size);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => $model->{Globals::FLD_NAME_USER_ID} , "Category ID" => $_GET[Globals::FLD_NAME_CATGID]) );
                }
                if($image!=Globals::DEFAULT_VAL_NULL)
                {
                    $image = Globals::FOLDER_BACK_PATH.$image;
                }
                else
                {
                    $avatar = Globals::IMAGE_CATEGORY_AVATAR;
                    try
                    {
                        $image = CommonUtility::getCategoryImageUrl($avatar,$size);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task ID" => $task_id) );
                    }
                    $image = Globals::FOLDER_BACK_PATH.$image;
                }
            }
            else 
            {
                 throw new CHttpException(404,'Content not found.');
            }
            header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
            header(Globals::HEADER_CONTENT_LENGTH. filesize($image));
            readfile($image);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('CatPic');
            }
    }
    public function actionTaskPic()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('TaskPic','application.controller.CommonfrontController');
            }
            $model=Task::model()->findByPk($_GET[Globals::FLD_NAME_TASKID]);
            @$size = $_GET[Globals::FLD_NAME_DIMENSION];
            if(isset($model->{Globals::FLD_NAME_TASK_ID}))
            {
                try
                {
                    $image = CommonUtility::getTaskImageURL($model->{Globals::FLD_NAME_TASK_ID},$size);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => $model->{Globals::FLD_NAME_USER_ID}) );
                }
                if($image!=Globals::DEFAULT_VAL_NULL)
                {
                    $image = Globals::FOLDER_BACK_PATH.$image;
                }
                else
                {
                    $avatar = Globals::IMAGE_CATEGORY_AVATAR;
                    try
                    {
                        $image = CommonUtility::getCategoryImageUrl($avatar,$size);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => $model->{Globals::FLD_NAME_USER_ID}) );
                    }
                    $image = Globals::FOLDER_BACK_PATH.$image; 
                }
            }
            else 
            {
                 throw new CHttpException(404,'Content not found.');
            }
            header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
            header(Globals::HEADER_CONTENT_LENGTH. filesize($image));
            readfile($image);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('TaskPic');
            }
    }
    public function actionTaskAttachment()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('TaskAttachment','application.controller.CommonfrontController');
            }
            $task_id =$_GET[Globals::FLD_NAME_TASKID];
            $model=Task::model()->findByPk( $task_id );
            @$fileName = $_GET[Globals::FLD_NAME_FILENAME];
            @$taskTitle = $_GET[Globals::FLD_NAME_TASKTITLE];
            $downloadFileName = $task_id."_".$taskTitle."_".$fileName;
            if(isset($model->{Globals::FLD_NAME_TASK_ID}))
            {
               
                try
                {
                    $fileType = CommonUtility::CheckFileType( $fileName );
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task ID" => $task_id) );
                }
                try
                {
                    $file = CommonUtility::getTaskAttachmentURL($model->{Globals::FLD_NAME_TASK_ID},$fileName);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => $model->{Globals::FLD_NAME_USER_ID}) );
                }
               
                switch ($fileType)
                {
                      case Globals::DEFAULT_VAL_IMAGE_TYPE: 

                                    header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
                                    if($file != Globals::DEFAULT_VAL_NULL)
                                    {
                                        $file = Globals::FOLDER_BACK_PATH.$file;
                                    }
                                    else
                                    {
                                       $file = Globals::IMAGE_AVATAR;   
                                    }
                               break;
                               
                       case Globals::DEFAULT_VAL_VIDEO_TYPE: 

                                    if($file !=Globals::DEFAULT_VAL_NULL)
                                    {
                                        header(Globals::HEADER_CONTENT_TYPE_VIDEO_MP4);
                                        header(Globals::HEADER_ACCEPT_RANGES_BYTES);
                                        $file = Globals::FOLDER_BACK_PATH.$file;
                                    }
                                    else
                                    {
                                        header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
                                        $file = Globals::IMAGE_AVATAR;
                                    }
                               break;

                      default: 
                          
                            
 
                                    if($file !=Globals::DEFAULT_VAL_NULL)
                                    {
                                        
                                        $file = Globals::FOLDER_BACK_PATH.$file;
                                        
                                        header("Content-Type: application/force-download");
                                        header("Content-Disposition: inline; filename=\"".$downloadFileName."\"");
                                        header("Cache-Control: no-cache, must-revalidate");
                                        header("Pragma: no-cache");  
                            
                            
                                    }
                } 
                
                
                
                
            }
            else 
            {
                throw new CHttpException(404,'Content not found.');
            }
            header(Globals::HEADER_CONTENT_LENGTH. filesize($file));
            readfile($file);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('TaskAttachment');
            }
    }
      public function actionTaskAttachmentThumb()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('TaskAttachmentThumb','application.controller.CommonfrontController');
            }
            $task_id =$_GET[Globals::FLD_NAME_TASKID];
            $model=Task::model()->findByPk( $task_id );
            @$fileName = $_GET[Globals::FLD_NAME_FILENAME];
            @$taskTitle = $_GET[Globals::FLD_NAME_TASKTITLE];
            if(isset($model->{Globals::FLD_NAME_TASK_ID}))
            {
                try
                {
                    $file = CommonUtility::getTaskAttachmentImageThumbURL($model->{Globals::FLD_NAME_TASK_ID},$fileName);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ) );
                }
               
                if($file != Globals::DEFAULT_VAL_NULL)
                {
                    $file = Globals::FOLDER_BACK_PATH.$file;
                }
                else
                {
                   $file = Globals::IMAGE_AVATAR;   
                }
                
            }
            else 
            {
               
                throw new CHttpException(404,'Content not found.');
            }
            
            header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
            header(Globals::HEADER_CONTENT_LENGTH. filesize($file));
            readfile($file);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('TaskAttachmentThumb');
            }
    }
    public function actionProposalAttachment()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('ProposalAttachment','application.controller.CommonfrontController');
            }
            $id =$_GET[Globals::FLD_NAME_PROPOSALID];
            $model = GetRequest::getProposalById($id);
            $task_id = $model->{Globals::FLD_NAME_TASK_ID};
            try
            {
                $task = GetRequest::getTaskById($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ) );
            }
                
            @$fileName = $_GET[Globals::FLD_NAME_FILENAME];
            @$taskTitle = $_GET[Globals::FLD_NAME_TASKTITLE];
            $downloadFileName = $task_id."_".$taskTitle."_".$id."_".$fileName;
            if(isset($model->{Globals::FLD_NAME_TASK_ID}))
            {
                try
                {
                    $fileType = CommonUtility::CheckFileType( $fileName );
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ) );
                }
                try
                {
                    $file = CommonUtility::getProposalAttachmentURL($id,$fileName);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ) );
                }
               
                switch ($fileType)
                {
                      case Globals::DEFAULT_VAL_IMAGE_TYPE: 

                                    header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
                                    if($file != Globals::DEFAULT_VAL_NULL)
                                    {
                                        $file = Globals::FOLDER_BACK_PATH.$file;
                                    }
                                    else
                                    {
                                       $file = Globals::IMAGE_AVATAR;   
                                    }
                               break;
                               
                       case Globals::DEFAULT_VAL_VIDEO_TYPE: 

                                    if($file !=Globals::DEFAULT_VAL_NULL)
                                    {
                                        header(Globals::HEADER_CONTENT_TYPE_VIDEO_MP4);
                                        header(Globals::HEADER_ACCEPT_RANGES_BYTES);
                                        $file = Globals::FOLDER_BACK_PATH.$file;
                                    }
                                    else
                                    {
                                        header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
                                        $file = Globals::IMAGE_AVATAR;
                                    }
                               break;

                      default: 
                          
                            

                                    if($file !=Globals::DEFAULT_VAL_NULL)
                                    {
                                        
                                        $file = Globals::FOLDER_BACK_PATH.$file;
                                        
                                        header("Content-Type: application/force-download");
                                        header("Content-Disposition: inline; filename=\"".$downloadFileName."\"");
                                        header("Cache-Control: no-cache, must-revalidate");
                                        header("Pragma: no-cache");  
                                    }
                } 
            }
            else 
            {
                 throw new CHttpException(404,'Content not found.');
            }
            header(Globals::HEADER_CONTENT_LENGTH. filesize($file));
            readfile($file);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('ProposalAttachment');
            }
    }
    public function actionProposalAttachmentThumb()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('ProposalAttachmentThumb','application.controller.CommonfrontController');
            }
            
            $id = $_GET[Globals::FLD_NAME_PROPOSALID];
            try
            {
                $model = GetRequest::getProposalById($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Proposal ID" => $id ) );
            }
            $task_id = $model->{Globals::FLD_NAME_TASK_ID};
            try
            {
                $task = GetRequest::getTaskById($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ) );
            }
            
            @$fileName = $_GET[Globals::FLD_NAME_FILENAME];
            @$taskTitle = $_GET[Globals::FLD_NAME_TASKTITLE];
            if(isset($model->{Globals::FLD_NAME_TASK_ID}))
            {
                try
                {
                    $file = CommonUtility::getProposalAttachmentImageThumbURL($id,$fileName);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ) );
                }
                if($file != Globals::DEFAULT_VAL_NULL)
                {
                    $file = Globals::FOLDER_BACK_PATH.$file;
                }
                else
                {
                   $file = Globals::IMAGE_AVATAR;   
                }
            }
            else 
            {
                throw new CHttpException(404,'Content not found.'); 
            }
//            echo $file;
//            exit;
            header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
            header(Globals::HEADER_CONTENT_LENGTH. filesize($file));
            readfile($file);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('ProposalAttachmentThumb');
            }
    }
    public function actionPublicImage()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('PublicImage','application.controller.CommonfrontController');
            }
            @$fileName = $_GET[Globals::FLD_NAME_FILENAME];
            if($fileName)
            {
               //  $image = Globals::BASE_URL_IMAGE_DIR.$fileName;
                 $image = Globals::BASE_URL_PUBLIC_IMAGE_DIR.$fileName;
                if($image != Globals::DEFAULT_VAL_NULL)
                {
                    $image = Globals::FOLDER_BACK_PATH.$image;
                }
                else
                {
                   $image = Globals::IMAGE_NOT_FOUND; 
                }
            }
            else 
            {
                 throw new CHttpException(404,'Content not found.');
            }
            header(Globals::HEADER_CONTENT_TYPE_IMAGE_JPEG);
            header(Globals::HEADER_CONTENT_LENGTH. filesize($image));
            readfile($image);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('PublicImage');
            }
    }
    public function actionInvitedTaskersPopover()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('InvitedTaskersPopover','application.controller.CommonfrontController');
            }
            $task_id = $_GET[Globals::FLD_NAME_TASK_ID];
            $model = User::model()->findByPk( Yii::app()->user->id );
//            echo $task_id;
//            exit;
            try
            {
                $invited = GetRequest::getInvitedTaskerForTask($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ) );
            }
            $this->renderPartial('invitedtaskerspopover',array(
                                'invited' => $invited,
                                'model' => $model
                      ),false,true);
              if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('InvitedTaskersPopover');
            }
    }
    public function actionTaskProposalsPopover()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('TaskProposalsPopover','application.controller.CommonfrontController');
            }
            $task_id = $_GET[Globals::FLD_NAME_TASK_ID];
//            echo $task_id;
//            exit;
            try
            {
                $proposals = TaskTasker::getAllProposalsOfTask( $task_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ) );
            }
            $this->renderPartial('taskporposalspopover',array(
                                'proposals' => $proposals
                      ),false,true);
              if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('TaskProposalsPopover');
            }
    }
    public function actionUserProfilePopover()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserProfilePopover','application.controller.CommonfrontController');
            }
            $user_id = $_GET[Globals::FLD_NAME_USER_ID];
//            echo $task_id;
//            exit;
            $model = User::model()->findByPk( Yii::app()->user->id );
            $user = User::model()->findByPk( $user_id );
            $this->renderPartial('userprofilepopover',array(
                                'user' => $user,
                'model' => $model
                      ),false,true);
              if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserProfilePopover');
            }
    }
    public function actionUserProfilePopoverAsPoster()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserProfilePopoverAsPoster','application.controller.CommonfrontController');
            }
            $user_id = $_GET[Globals::FLD_NAME_USER_ID];
//            echo $task_id;
//            exit;
            $model = User::model()->findByPk( Yii::app()->user->id );
            $user = User::model()->findByPk( $user_id );
            $this->renderPartial('posterprofilepopover',array(
                                'user' => $user,
                                'model' => $model
                      ),false,true);
              if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserProfilePopoverAsPoster');
            }
    }
    public function actionUserLocationPopover()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserLocationPopover','application.controller.CommonfrontController');
            }
            $user_id = $_GET[Globals::FLD_NAME_USER_ID];
//            echo $task_id;
//            exit;
//            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//            Yii::app()->clientScript->scriptMap['gmap3.min.js'] = false;
            $model = User::model()->findByPk( Yii::app()->user->id );
            $user = User::model()->findByPk( $user_id );
            $this->renderPartial('userlocationpopover',array(
                                    'user' => $user,
                                    'model' => $model
                      ),false,true);
              if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserLocationPopover');
            }
    }
    public function actionTaskSkillsPopover()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('TaskSkillsPopover','application.controller.CommonfrontController');
            }
            $task_id = $_GET[Globals::FLD_NAME_TASK_ID];
            try
            {
                $skills = UtilityHtml::taskSkills($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task ID" => $task_id) );
            }
            $skills = ($skills== '<ul></ul>') ? CHtml::encode(Yii::t('poster_createtask','lbl_not_specified')) : $skills ; 

            $this->renderPartial('taskskillspopover',array(
                                    'skills' => $skills
                      ),false,true);
              if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('TaskSkillsPopover');
            }
    }
    public function actionTaskLocationsPopover()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('TaskLocationsPopover','application.controller.CommonfrontController');
            }
            $task_id = $_GET[Globals::FLD_NAME_TASK_ID];
            try
            {
                $locations = UtilityHtml::getTaskPreferedLocations( $task_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id , "Task ID" => $task_id) );
            }
            $locations = ($locations== '') ? CHtml::encode(Yii::t('poster_createtask','lbl_not_specified')) : $locations ; 

            $this->renderPartial('tasklocationspopover',array(
                                    'locations' => $locations
                      ),false,true);
              if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('TaskLocationsPopover');
            }
    }
    public function actionUserSkillsPopover()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserSkillsPopover','application.controller.CommonfrontController');
            }
            $user_id = $_GET[Globals::FLD_NAME_USER_ID];
            
     

            $this->renderPartial('userskillspopover',array(
                                    'user_id' => $user_id
                      ),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserSkillsPopover');
            }
    }
    public function actionTaskQueAnswerOfTasker()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('TaskQueAnswerOfTasker','application.controller.CommonfrontController');
            }
            $tasker_id = $_GET[Globals::FLD_NAME_TASKER_ID];
            $task_id = $_GET[Globals::FLD_NAME_TASK_ID];
     

            $this->renderPartial('taskqueansweroftasker',array(
                                    'task_id' => $task_id,'tasker_id' => $tasker_id
                      ),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('TaskQueAnswerOfTasker');
            }
    }
     public function actionTaskSharePopover()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('TaskSharePopover','application.controller.CommonfrontController');
            }
           
            $task_id = $_GET[Globals::FLD_NAME_TASK_ID];
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  

            $this->renderPartial('tasksharepopover',array(
                                    'task_id' => $task_id
                      ),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('TaskSharePopover');
            }
    }
    public function actionConnectMepopover()
    {          
        if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Connectmepopover','application.controller.CommonfrontController');
            }                       
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  

//            $this->renderPartial('connectmepopover',false,true);
            $this->renderPartial('connectmepopover', '',false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Connectmepopover');
            }
    }
    public function actionUserNotifications()
    {          
        if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Connectmepopover','application.controller.CommonfrontController');
            }                       
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  
            try
            {
                $userAlert = new UserAlert();
                $userNotification = $userAlert->getNotificationByUserIdForPopOver(Yii::app()->user->id);
            }
            catch(Exception $e)
            {
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Category ID" =>$category_id) );  
            }
            
            Yii::app()->clientScript->scriptMap['jquery.yiilistview.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
//            Yii::app()->clientScript->scriptMap['chosen.jquery.js'] = false;
            
//            echo '<pre>';
//            print_r($userNotification);
//            exit;
//            $this->renderPartial('connectmepopover',false,true);
//            $this->renderPartial('usernotifications',array('userNotification' => $userNotification),false,true);
            $this->renderPartial('usernotifications',array('userNotification' => $userNotification),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Connectmepopover');
            }
    }
    
    public function actionUserMessages()
    {          
        if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Connectmepopover','application.controller.CommonfrontController');
            }                       
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  

//            $this->renderPartial('connectmepopover',false,true);
            $this->renderPartial('usermessages', '',false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Connectmepopover');
            }
    }
    public function actionHiredPopover()
    {          
          CommonUtility::startProfiling();                     
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  
            $userId = $_GET[Globals::FLD_NAME_USER_ID];
            $tasks = TaskTasker::getTaskerHiredByUser($userId , '' ,array('limit' => Globals::DEFAULT_VAL_LIMIT_IN_POPOVER));
//            $this->renderPartial('connectmepopover',false,true);
            $this->renderPartial('hiredpopover', array( 'tasks' => $tasks , 'user_id' => $userId ),false,true);
            CommonUtility::endProfiling();
    }
     public function actionJobsPopover()
    {          
          CommonUtility::startProfiling();                     
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  
             $userId = $_GET[Globals::FLD_NAME_USER_ID];
            $tasks = TaskTasker::getTaskerRecentTasks($userId , Globals::DEFAULT_VAL_LIMIT_IN_POPOVER);

//            $this->renderPartial('connectmepopover',false,true);
            $this->renderPartial('jobspopover', array( 'tasks' => $tasks , 'user_id' => $userId),false,true);
            CommonUtility::endProfiling();
    }
     public function actionNetworkPopover()
    {          
          CommonUtility::startProfiling();                     
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  
//            $userId = $_GET[Globals::FLD_NAME_USER_ID];
//            $tasks = TaskTasker::getTaskerHiredByUser($userId);
//            
//            $this->renderPartial('connectmepopover',false,true);
            $this->renderPartial('networkpopover','',false,true);
            CommonUtility::endProfiling();
    }
    public function actionUserMenu()
    {          
        if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Connectmepopover','application.controller.CommonfrontController');
            }                       
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  

//            $this->renderPartial('connectmepopover',false,true);
            $this->renderPartial('usermenu', '',false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Connectmepopover');
            }
    }
    public function actionUserHelpMenu()
    {          
        if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Connectmepopover','application.controller.CommonfrontController');
            }                       
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;  

//            $this->renderPartial('connectmepopover',false,true);
            $this->renderPartial('userhelpmenu', '',false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Connectmepopover');
            }
    }
    
//Testing code starts here    
    public function actionsendmail()
    {          
      if(CommonUtility::IsProfilingEnabled())
      {
          Yii::beginProfile('sendmail','application.controller.CommonfrontController');
      } 

      @$to = $_POST['to'];
      @$subject = $_POST['subject'];
      @$message = 'test';
      @$body = $_POST['body'];
      if(!isset($to) || !isset($subject) || !isset($message) || !isset($body) )
      {
          echo CJSON::encode(array(
                                      'status'=>'error',
                                      'errormsg'=>"Please provide correct detail",
			));
         Yii::app()->end();
      }
      try
      {
          if(CommonUtility::SendMail($to,$subject,$message,$body))
          {
           echo CJSON::encode(array(
                                      'status'=>'success',
                                      'successmsg'=>"mail sent successfully",
			));
           }  else{
            throw new Exception('Mail couldn\'t be sent');
           }        
      } 
      catch (Exception $e) 
      {
           $msg = $e->getMessage();
              CommonUtility::catchErrorMsg( $msg  );
      }
      
      if(CommonUtility::IsProfilingEnabled())
      {
          Yii::endProfile('sendmail');
      }
    }
    
    public function actionsendmailtest()
    {          
      if(CommonUtility::IsProfilingEnabled())
      {
          Yii::beginProfile('sendmailtest','application.controller.CommonfrontController');
      }           
      if(isset($_POST['data']))
      {

         $data_string =  $_POST['data'];
         //echo Yii::app()->createUrl('commonfront/sendmailtestcurl');
       
         $url = 'http://107.182.163.219:8080//WebServices/service';
         //$url = Yii::app()->createAbsoluteUrl('commonfront/sendmailtestcurl');
         //$url = Yii::app()->createAbsoluteUrl('commonfront/sendmail');
         $a = array('cmd' => 'send_email', 'id'=> 'welcome_email', 'to' => 'virendra.yadav@aryavratinfotech.com', 'param'=> array('voboloURL'=>'www.vobolo.com', 'fullName'=>'ArchanaThapar'));
         //$a = array('subject' => 'send_email', 'body'=> 'welcome_email', 'to' => 'virendra.yadav@aryavratinfotech.com');
         /*$encoded = '';        
         foreach($a as $name => $value) {
           $encoded .= urlencode($name).'='.urlencode($value).'&';
         }
         $encoded = substr($encoded, 0, strlen($encoded)-1);
         */
         $ch = curl_init($url);                                                                      
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
          //curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);   
         curl_setopt($ch, CURLOPT_POSTFIELDS, 'data='.urlencode(json_encode($a)));                                                                  
         //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
         //curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
             //'Content-Type: application/json',                                                                                
             //'Content-Length: ' . strlen($a))                                                                       
         //);                                                            
   
   
         try{
            $result = curl_exec($ch);
            echo '<br/><br/><br/><br/><br/><br/><br/><br/>';
            print_r($result);  
         }catch(Exception $e){
         
            print_r($e);
         }

      }
      $this->render('sendmail', '');
      if(CommonUtility::IsProfilingEnabled())
      {
          Yii::endProfile('sendmailtest');
      }
    }
    
    
    
    
    public function actionsendmailtestcurl()
    {          
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('sendmailtestcurl','application.controller.CommonfrontController');
            }     
            if($_POST)
            {
                print_r($_POST['data']);
                echo 'success';
            }
         
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('sendmailtestcurl');
            }
    }
    public function actionGetUserDetails()
    {
        CommonUtility::startProfiling();
        $user_id = $_POST[Globals::FLD_NAME_USER_ID];
        try
        {
           $user = User::model()->findByPk($user_id);
           $userData['firstname'] = $user->{Globals::FLD_NAME_FIRSTNAME};
           $userData['lastname'] = $user->{Globals::FLD_NAME_LASTNAME};
           $userData['name'] = CommonUtility::getUserFullName($user_id);
           $userData['image'] = CommonUtility::getThumbnailMediaURI($user_id, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_100);
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
//testing code ends here
    public function actionPostertasklistpopover()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('postertasklistpopover','application.controller.CommonfrontController');
        }    
        $posterTasklists = Task::getMyPostedTaskList(10,'o');
        $doer_id = $_GET['doer_id'];
        $this->renderPartial('postertasklistpopover',array(
                                'posterTasklists' => $posterTasklists,
                                'doer_id'=>$doer_id
                      ),false,true);
        
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('postertasklistpopover');
        }
    }
    
    public function actionIsSeenNotification()
    {
//        echo 'test';exit;
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('isseennotification','application.controller.CommonfrontController');
        }   
//        echo '<pre>';
//        print_r($_POST);
        $alert_id = $_POST[Globals::FLD_NAME_ALERT_ID];
        $userAlert = UserAlert::model()->findByPk($alert_id);
        if($userAlert)
        {
            $userAlert->{Globals::FLD_NAME_IS_SEEN} = Globals::DEFAULT_VAL_NOTIFICATION_SEEN;
            $userAlert->{Globals::FLD_NAME_SEEN_AT} = new CDbExpression('NOW()');
            $userAlert->{Globals::FLD_NAME_SEEN_FROM_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
            if( !$userAlert->update())
            {   
                    throw new Exception(Yii::t('poster_proposalreject','unexpected_error'));
            }
            echo CJSON::encode(array(
                    'status'=>'success'
            ));
        }
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('isseennotification');
        }
    }
    
    public function actionFileDownload()
    {
        $file = $_GET[Globals::FLD_NAME_FILENAME];
        $fileUrl = Globals::FRONT_USER_MEDIA_BASE_PATH.$file;
        $file = CommonUtility::getImageDisplayName($file);
        if (file_exists($fileUrl)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileUrl));
            ob_clean();
            flush();
            readfile($fileUrl);
            exit;
        }
    }
    
    public function actionSetUserPrimation()
    {
        $return = 0;
        $type = $_POST['type'];
        $status = $_POST['status'];
        if($type != '' && $status != '')
        {
            switch ($type)
            {
                case 'v':
                    $virtualdoer = Yii::app()->user->getState('is_virtualdoer_license');
                    if($virtualdoer['permission_val'] == 1)
                    {
                        if($status == 1)
                        {
                            $virtualdoer['permission_status'] = 0;
                        }
                        else
                        {
                            $virtualdoer['permission_status'] = 1;
                        }
                        Yii::app()->user->setState('is_virtualdoer_license',$virtualdoer);
                        $return = 1;
                    }
                    break;
                case 'i':
                    $inpersondoer = Yii::app()->user->getState('is_inpersondoer_license');
                    $instantdoer = Yii::app()->user->getState('is_instantdoer_license');
                    if($inpersondoer['permission_val'] == 1)
                    {
                        if($status == 1)
                        {
                            $inpersondoer['permission_status'] = 0;
                            $$instantdoer['permission_status'] = 0;
                        }
                        else
                        {
                            $inpersondoer['permission_status'] = 1;
                            $instantdoer['permission_status'] = 1;
                        }
                        Yii::app()->user->setState('is_inpersondoer_license',$inpersondoer);
                        Yii::app()->user->setState('is_instantdoer_license',$instantdoer);
                        $return = 1;
                    }
                    break;
                case 'p':
                    $poster = Yii::app()->user->getState('is_poster_license');
                    if($poster['permission_val'] == 1)
                    {
                        if($status == 1)
                        {
                            $poster['permission_status'] = 0;
                        }
                        else
                        {
                            $poster['permission_status'] = 1;
                        }
                        Yii::app()->user->setState('is_poster_license',$poster);
                        $return = 1;
                    }
                    break;
                case 'prm':
                     $premiumdoer = Yii::app()->user->getState('is_premiumdoer_license');
                    if($premiumdoer['permission_val'] == 1)
                    {
                        if($status == 1)
                        {
                            $premiumdoer['permission_status'] = 0;
                        }
                        else
                        {
                            $premiumdoer['permission_status'] = 1;
                        }
                        Yii::app()->user->setState('is_premiumdoer_license',$premiumdoer);
                        $return = 1;
                    }
                    break;
                  default:
                      $return = 0;
            }            
        }
        if($return == 1)
        {
            Yii::app()->user->setState('user_type',CommonUtility::getUserRoleType());
        }
        echo $return;
        exit;
    }
    public function actionRatingDescriptionPopover()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('RatingDescriptionPopover','application.controller.CommonfrontController');
            }
            $tooltip = CommonUtility::getToolTipForDoerReviewPage($_POST['rating_desc']);
            echo $tooltip;
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('RatingDescriptionPopover');
            }
    }
    
}