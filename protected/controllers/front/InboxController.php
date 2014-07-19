<?php
class InboxController extends Controller
{
   public function filters() 
    {
        return array(
            'accessControl', // perform access control for CRUD operationstail
        );
    }
    
    /**
     * Declares class-based actions.
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('makemsgpublic'),
                'users'=>array('*'),
            ),
             array('allow', // allow authenticated user to perform 'create' and 'update' actions
                            'actions'=>array('messagesave','loadsendmessageform','makemsgunread','makemsgread','index','taskusers','messagesaveinmsgbox','deletemessages'),
                                'users'=>array('@'),
                    ),
            array('deny',  // deny all users
                //'actions'=>array('index'),
                'users'=>array('*'),
            ),
        );
    }
    
    
     /**
    * all messages of user
    * @params user id
    * @return message 
    * @var
    */
    public function actionIndex()
    {
        CommonUtility::startProfiling();
        $task = new Task;
        $user = new User;
        $inbox = new Inbox;
        @$state = $_GET[Globals::FLD_NAME_TASK_STATE];
        @$currentTask = $_GET[Globals::FLD_NAME_TASK];
        @$toUserIds = $_GET[Globals::FLD_NAME_TO_USER_IDS];
        @$fromUserId = $_GET[Globals::FLD_NAME_FROM_USER_ID];
        @$creatorUser = $_GET[Globals::FLD_NAME_CREATER_USER_ID];
        @$msgType =  $_GET[Globals::FLD_NAME_MSG_TYPE];
        @$title = $_GET[Globals::FLD_NAME_TITLE];
        $currentTaskList = array();
        try
        {
            
            try
            {
               $filters = array(
                Globals::FLD_NAME_TASK_STATE =>  $state ,
                       Globals::FLD_NAME_TITLE => $title,
                   'pageSize' => 15,
                );
                $taskList = $inbox->getUserRecentMessages(Yii::app()->user->id , $filters);
               
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
            }
 //exit;
            
            try
            {
                $tasks = $taskList->getData();
                if($tasks)
                {
               
                    if(!$currentTask)
                    {
                        $currentTask = $tasks[0][Globals::FLD_NAME_TASK_ID];
                         
                    }
                    if(!$creatorUser)
                    {
                        $creatorUser = $tasks[0][Globals::FLD_NAME_FROM_USER_ID];
                        
                    }
                     if(!$fromUserId)
                    {
                        $fromUserId = $tasks[0][Globals::FLD_NAME_FROM_USER_ID];
                        
                    }
                    if(!$toUserIds)
                    {
                        $toUserIds = $tasks[0][Globals::FLD_NAME_TO_USER_IDS];
                    }
                    
                }
               // print_r($currentTask);
                if(!empty($currentTask))
                {
                    $currentTaskList = Task::model()->findByPk($currentTask);
                }
                else
                {
                    $currentTaskList = new Task();
                }
               // print_r($currentTaskList);
               // exit;
                $filters = array(
                    Globals::FLD_NAME_TASK_ID => $currentTask,
                    Globals::FLD_NAME_CREATER_USER_ID => $creatorUser,
                    Globals::FLD_NAME_MSG_TYPE => $msgType,
                );
                
                $taskMessages = $inbox->getMessagesThreadOfUser( $fromUserId  , $toUserIds , $filters);
                        
//                if( $creatorUser == Yii::app()->user->id)
//                {
//                    $taskMessages = $inbox->getMessagesOnTask($filters);
//                }
//                else
//                {
//                    $taskMessages = $inbox->getMessagesOnTaskByTasker( Yii::app()->user->id , $filters);
//                }
               

                
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
            }
            try
            {
               $retatedUsers = User::getRelatedUsersOfUser(Yii::app()->user->id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
            }
    //exit;
            $this->layout = '//layouts/noheader'; 
            $this->render('inbox',array('taskList' => $taskList , 'taskMessages' => $taskMessages , 'currentTaskList' => $currentTaskList , 'currentTask' => $currentTask , 
                        'inbox' => $inbox,
                        'fromUserId' => $fromUserId ,
                        'toUserIds' => $toUserIds,
                'retatedUsers' => $retatedUsers
           
));
            
            
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
        }
     
        CommonUtility::endProfiling();
    }
    /**
    * get users of task
    * @params Task id 
    * @return users
    * @var
    */
     public function actionTaskUsers()
    {
        CommonUtility::startProfiling();
        try
        {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['chosen.jquery.js'] = false;
            
            $taskId = $_POST[Globals::FLD_NAME_TASK_ID];
           
            $task = Task::model()->with('taskcategory','category','categorylocale')->findByPk($taskId);
            $userDetail = array();
            if($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id )
            {
                $taskUsers =  TaskTasker::getAllProposalsOfTask($taskId);
                if($taskUsers)
                {
                    foreach ( $taskUsers as $taskUser )
                    {
                        $userDetail[$taskUser->{Globals::FLD_NAME_TASKER_ID}] = CommonUtility::getUserFullName($taskUser->{Globals::FLD_NAME_TASKER_ID});
                    }
                }
            }
            else
            {
                $userDetail[$task->{Globals::FLD_NAME_CREATER_USER_ID}] = CommonUtility::getUserFullName($task->{Globals::FLD_NAME_CREATER_USER_ID});
            }
            $usersHtml = $this->renderPartial('partial/_task_users', array( 'userDetail' => $userDetail ) , true , true);
            //code
            echo  $error = CJSON::encode(array(
                        'status'=>'success',
                'task_creator_user_id' => $task->{Globals::FLD_NAME_CREATER_USER_ID},
                        'html' => $usersHtml
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
    * get sent message form in task detail page
    * @params Task id , to user id
    * @return message comment form
    * @var
    */
     public function actionLoadSendMessageForm()
    {
        CommonUtility::startProfiling();
        try
        {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $taskId = $_POST[Globals::FLD_NAME_TASKID];
            $toUserId = $_POST['toUserId'];
            $task = Task::model()->with('taskcategory','category','categorylocale')->findByPk($taskId);
            $message = new Inbox();
             
            $newMsg = $this->renderPartial('//poster/partial/_view_send_messages', array( 'task' => $task , 'message' => $message , 'toUserId' => $toUserId) , true , true);
            //code
            echo  $error = CJSON::encode(array(
                        'status'=>'success',
                        'html' => $newMsg
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
    * change msg property private to public 
    * @params msg id
    * @return json success
    * @var
    */
     public function actionMakeMsgPublic()
    {
        CommonUtility::startProfiling();
        try
        {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $msgId = $_POST[Globals::FLD_NAME_MSG_ID];
            $message = $this->loadModel($msgId);
            
            $message->{Globals::FLD_NAME_IS_PUBLIC} = Globals::DEFAULT_VAL_MSG_IS_PUBLIC_ACTIVE;
            if(!$message->save())
            {                            
                throw new Exception("Unexpected error !!! setmessage to public..");
            }
            echo  $error = CJSON::encode(array(
                        'status'=>'success',
                       
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
    * change msg property to unread
    * @params msg id , user id
    * @return json success
    * @var
    */
    public function actionMakeMsgUnread()
    {
        CommonUtility::startProfiling();
        try
        {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $msgId = $_POST[Globals::FLD_NAME_MSG_ID];
            $userId = $_POST[Globals::FLD_NAME_USER_ID];
            
            $inboxUser = InboxUser::model()->findByAttributes(array(Globals::FLD_NAME_MSG_ID => $msgId , Globals::FLD_NAME_USER_ID => $userId ));
            $inboxUser->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_NOT_READ;
            if(!$inboxUser->save())
            {                            
                throw new Exception("Unexpected error !!! setmessage to unread..");
            }
            echo  $error = CJSON::encode(array(
                        'status'=>'success',
                      
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
    * change msg property to read
    * @params msg id , user id
    * @return json success
    * @var
    */
    public function actionMakeMsgRead()
    {
        CommonUtility::startProfiling();
        try
        {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $msgId = $_POST[Globals::FLD_NAME_MSG_ID];
            $userId = $_POST[Globals::FLD_NAME_USER_ID];
            $inboxUser = InboxUser::model()->findByAttributes(array(Globals::FLD_NAME_MSG_ID => $msgId , Globals::FLD_NAME_USER_ID => $userId ));
            $inboxUser->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_READ;
            if(!$inboxUser->save())
            {                            
                throw new Exception("Unexpected error !!! setmessage to unread..");
            }
            echo  $error = CJSON::encode(array(
                        'status'=>'success',
                      
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
    * delete messages 
    * @params user_id , msg_id
    * @return success or error
    * @var
    */
     public function actionDeleteMessages()
    {
        CommonUtility::startProfiling();
        try
        {
            if(isset($_POST['deleteMsg']))
            {
                foreach ( $_POST['deleteMsg'] as $msg) 
                {
                    $inboxUser = InboxUser::model()->findByAttributes(array(Globals::FLD_NAME_MSG_ID =>$msg , Globals::FLD_NAME_USER_ID => Yii::app()->user->id ));
                    $inboxUser->{Globals::FLD_NAME_IS_DELETE} = Globals::DEFAULT_VAL_IS_DELETE_ACTIVE;
                    $inboxUser->update();
                     
                }
                echo  $error = CJSON::encode(array(
                        'status'=>'success',
                      
                    ));
            }
            else
            {
                echo  $error = CJSON::encode(array(
                        'status'=>'error',
                      
                    ));
            }
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
    
  
    public function actionInboxDetail()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Inbox Detail','application.controller.InboxController');
        }
        $task = new Task;
//        $taskState = @$_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE];
        try
        {
            $taskList = $task->getMyInboxTaskListAsPoster();
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
        }
        $this->layout = '//layouts/noheader'; 
        $this->render('//inbox_detail/inbox_detail',array('taskList' => $taskList));
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Inbox Detail','application.controller.InboxController');
        }
    }
    
    public function actionMessageSave()
    {
        CommonUtility::startProfiling();
        $message = new Inbox();
        $messageFlow = new InboxUser();
        if(isset($_POST[Globals::FLD_NAME_INBOX]))
        {
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
            try
            {
               $taskId = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
               @$replyMsg = $_POST['replyMsg'];
                
                $task = Task::model()->with('taskcategory','category','categorylocale')->findByPk($taskId);

                $taskCreatorUserId = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_CREATER_USER_ID];
                if(isset($_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_TO_USER_IDS]))
                {
                    if(is_array($_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_TO_USER_IDS]))
                    {
                        $toUserIds = implode(',', $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_TO_USER_IDS]);
                    }
                    else
                    {
                        $toUserIds = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_TO_USER_IDS];
                    }
                    $message->{Globals::FLD_NAME_TO_USER_IDS} = $toUserIds; 
                }
                if(isset($_POST[Globals::FLD_NAME_TO_USER_IDS]))
                {
                    if(is_array($_POST[Globals::FLD_NAME_TO_USER_IDS]))
                    {
                        $toUserIds = implode(',', $_POST[Globals::FLD_NAME_TO_USER_IDS]);
                    }
                    else
                    {
                        $toUserIds = $_POST[Globals::FLD_NAME_TO_USER_IDS];
                    }
                    $message->{Globals::FLD_NAME_TO_USER_IDS} = $toUserIds; 
                }
                $message->{Globals::FLD_NAME_MSG_TYPE} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_MSG_TYPE];
                $message->{Globals::FLD_NAME_TASK_ID} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                $message->{Globals::FLD_NAME_FROM_USER_ID} = Yii::app()->user->id;
                $message->{Globals::FLD_NAME_SUBJECT} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_SUBJECT];
                $message->{Globals::FLD_NAME_IS_PUBLIC} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_IS_PUBLIC];
                $message->{Globals::FLD_NAME_BODY} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_BODY];
                
                
                if(!$message->save())
                {                            
                    throw new Exception("Unexpected error !!! save message..");
                }
                
                $recived = 0;
                $posterMsgFlow = Globals::DEFAULT_VAL_MSG_FLOW_SENT;
                $reciverMsgFlow = Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED;
                if($taskCreatorUserId != Yii::app()->user->id  )
                {
                    $recived = 1;
                    $userIdToRecived = Yii::app()->user->id;
                    $posterMsgFlow = Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED;
                    $reciverMsgFlow = Globals::DEFAULT_VAL_MSG_FLOW_SENT;
                }
                else if($replyMsg == 1)
                {
                    $recived = 1;
                    $userIdToRecived = $message->{Globals::FLD_NAME_TO_USER_IDS};  
                }
                
                
                $insertedId = $message->getPrimaryKey();
                
                $messageFlow->{Globals::FLD_NAME_USER_ID} = $taskCreatorUserId;
                $messageFlow->{Globals::FLD_NAME_MSG_FLOW} = $posterMsgFlow;
                $messageFlow->{Globals::FLD_NAME_MSG_ID} = $insertedId;
                $messageFlow->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_READ;
                if(!$messageFlow->save())
                {                            
                    throw new Exception("Unexpected error !!! save message flow of user...");
                }
                
                if($recived == 1)
                {
                   
                            
                    $messageFlowRecived = new InboxUser();
                    $messageFlowRecived->{Globals::FLD_NAME_USER_ID} = $userIdToRecived;
                    $messageFlowRecived->{Globals::FLD_NAME_MSG_FLOW} = $reciverMsgFlow;
                    $messageFlowRecived->{Globals::FLD_NAME_MSG_ID} = $insertedId;
                    $messageFlowRecived->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_NOT_READ;
                    if(!$messageFlowRecived->save())
                    {                            
                        throw new Exception("Unexpected error !!! save message flow recived of user...");
                    }
                }
                
                $insertedMsg = Inbox::model()->findByPk($insertedId);
                $newMsg = $this->renderPartial('//poster/partial/_view_messages',array('data' => $insertedMsg , 'task' => $task) , true , true);
                echo  $error = CJSON::encode(array(
                        'status' => 'success',
                        'newMsg' => $newMsg
                    ));
            }
            catch(Exception $e)
            {
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "UserAttrib ID" => $insertedId ,"User ID" => Yii::app()->user->id) );
            }
        }
        
        CommonUtility::endProfiling();
    }
    public function actionMessageSaveInMsgBox()
    {
        CommonUtility::startProfiling();
        $message = new Inbox();
        $messageFlow = new InboxUser();
         $message->scenario = 'save_message_msg_box';
        if(isset($_POST[Globals::FLD_NAME_INBOX]))
        {
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
            try
            {
                $taskId = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                @$replyMsg = $_POST['replyMsg'];
                $model = User::model()->findByPk(Yii::app()->user->id);
                $task = Task::model()->findByPk($taskId);
                if(isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_CREATER_USER_ID]))
                {
                    $taskCreatorUserId = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_CREATER_USER_ID];
                }
                else
                {
                    $taskCreatorUserId = Yii::app()->user->id;
                }
                $message->{Globals::FLD_NAME_TASK_ID} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
                if(isset($_POST[Globals::FLD_NAME_TO_USER_IDS]) && $_POST[Globals::FLD_NAME_TO_USER_IDS] != '')
                {
                    $tOUserIds = $_POST[Globals::FLD_NAME_TO_USER_IDS];
                    $message->{Globals::FLD_NAME_TASK_ID} = '';
                    
                }
                elseif(isset($_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_TO_USER_IDS]))
                {
                    $tOUserIds = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_TO_USER_IDS];
                }
                if(isset($tOUserIds))
                {
                    if(is_array($tOUserIds))
                    {
                        $toUserIds = implode(',', $tOUserIds);
                    }
                    else
                    {
                        $toUserIds = $tOUserIds;
                    }
                    $message->{Globals::FLD_NAME_TO_USER_IDS} = $toUserIds; 
                }
                $message->{Globals::FLD_NAME_MSG_TYPE} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_MSG_TYPE];
                
                $message->{Globals::FLD_NAME_FROM_USER_ID} = Yii::app()->user->id;
                $message->{Globals::FLD_NAME_SUBJECT} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_SUBJECT];
                $message->{Globals::FLD_NAME_IS_PUBLIC} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_IS_PUBLIC];
                $message->{Globals::FLD_NAME_BODY} = $_POST[Globals::FLD_NAME_INBOX][Globals::FLD_NAME_BODY];
                
                ///attachments///
                
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
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$message->{Globals::FLD_NAME_TASK_ID}) );
                            }
                            try
                            {
                                    $type = CommonUtility::getFileType($extension);
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$message->{Globals::FLD_NAME_TASK_ID}) );
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
                                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$message->{Globals::FLD_NAME_TASK_ID}) );
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
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$message->{Globals::FLD_NAME_TASK_ID}) );
                                    }
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$message->{Globals::FLD_NAME_TASK_ID}) );
                                    }
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$message->{Globals::FLD_NAME_TASK_ID}) );
                                    }
                                    try
                                    {
                                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                                    }
                                    catch(Exception $e)
                                    {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" =>$message->{Globals::FLD_NAME_TASK_ID}) );
                                    }
                                }
                            }
                            $files = CJSON::encode( $fileInfo );
                            $message->{Globals::FLD_NAME_TASKER_ATTACHMENTS} = $files;
                            if($taskId)
                            {
                                if(isset($tOUserIds))
                                {
                                    if(is_array($tOUserIds))
                                    {
                                        foreach ($tOUserIds  as $toUserId)
                                        {
                                                $taskTasker = TaskTasker::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$taskId , Globals::FLD_NAME_TASKER_ID => $toUserId ));
                                                $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER} += $_POST['uploadPortfolioImage_totalFileSizeUsed'];
                                                if(! $taskTasker->update())
                                                {   
                                                        throw new Exception(Yii::t('poster_saveproposal','update task tasker'));   
                                                }
                                        }
                                    }
                                    else
                                    {
                                        $toUserId =  $tOUserIds;
                                        $taskTasker = TaskTasker::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$taskId , Globals::FLD_NAME_TASKER_ID => $toUserId ));
                                        $taskTasker->{Globals::FLD_NAME_SPACE_QUOTA_USED_DOER} += $_POST['uploadPortfolioImage_totalFileSizeUsed'];
                                        if(! $taskTasker->update())
                                        {   
                                                throw new Exception(Yii::t('poster_saveproposal','update task tasker'));   
                                        }
                                    }



                                    $task->{Globals:: FLD_NAME_SPACE_QUOTA_DOER} +=  $_POST['uploadPortfolioImage_totalFileSizeUsed'];
                                    if(! $task->update())
                                    {   
                                            throw new Exception(Yii::t('poster_saveproposal','update task'));   
                                    }
                                }
                            }
                    }
                      
//                print_r($message);
//                exit;
                if(!$message->save())
                {                            
                    throw new Exception("Unexpected error !!! save message..");
                }
                
                $recived = 0;
                $posterMsgFlow = Globals::DEFAULT_VAL_MSG_FLOW_SENT;
                $reciverMsgFlow = Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED;
                if($taskCreatorUserId != Yii::app()->user->id  )
                {
                    $recived = 1;
                    $userIdToRecived = Yii::app()->user->id;
                    $posterMsgFlow = Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED;
                    $reciverMsgFlow = Globals::DEFAULT_VAL_MSG_FLOW_SENT;
                }
                else if($replyMsg == 1)
                {
                    $recived = 1;
                    $userIdToRecived = $message->{Globals::FLD_NAME_TO_USER_IDS};  
                }
                $insertedId = $message->getPrimaryKey();
                
                $messageFlow->{Globals::FLD_NAME_USER_ID} = $taskCreatorUserId;
                $messageFlow->{Globals::FLD_NAME_MSG_FLOW} = $posterMsgFlow;
                $messageFlow->{Globals::FLD_NAME_MSG_ID} = $insertedId;
                $messageFlow->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_READ;
                if(!$messageFlow->save())
                {                            
                    throw new Exception("Unexpected error !!! save message flow of user...");
                }
                if($recived == 1)
                {
                    if(isset($tOUserIds))
                    {
                        if(is_array($tOUserIds))
                            {
                                foreach ($tOUserIds  as $toUserId)
                                {
                                    $messageFlowRecived = new InboxUser();
                                    $messageFlowRecived->{Globals::FLD_NAME_USER_ID} = $toUserId;
                                    $messageFlowRecived->{Globals::FLD_NAME_MSG_FLOW} = $reciverMsgFlow;
                                    $messageFlowRecived->{Globals::FLD_NAME_MSG_ID} = $insertedId;
                                    $messageFlowRecived->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_NOT_READ;
                                    if(!$messageFlowRecived->save())
                                    {                            
                                        throw new Exception("Unexpected error !!! save message flow recived of user...");
                                    }
                                }
                            }
                            else
                            {
                                $toUserId =  $tOUserIds;
                                $messageFlowRecived = new InboxUser();
                                $messageFlowRecived->{Globals::FLD_NAME_USER_ID} = $toUserId;
                                $messageFlowRecived->{Globals::FLD_NAME_MSG_FLOW} = $reciverMsgFlow;
                                $messageFlowRecived->{Globals::FLD_NAME_MSG_ID} = $insertedId;
                                $messageFlowRecived->{Globals::FLD_NAME_IS_READ} = Globals::DEFAULT_VAL_MSG_IS_NOT_READ;
                                if(!$messageFlowRecived->save())
                                {                            
                                    throw new Exception("Unexpected error !!! save message flow recived of user...");
                                }
                            }
                            
                        
                    }
                }
                
                $insertedMsg = Inbox::model()->findByPk($insertedId);
                $newMsg = $this->renderPartial('partial/_task_messages_list',array('data' => $insertedMsg , 'task' => $task) , true , true);
                echo  $error = CJSON::encode(array(
                        'status' => 'success',
                        'newMsg' => $newMsg
                    ));
            }
            catch(Exception $e)
            {
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
            }
        }
        
        CommonUtility::endProfiling();
    }
     
    
    public function actionUpdateImage()
        {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            //$folder=Yii::app()->request->baseUrl . "/media/category";// folder for uploaded files
            $folder = Globals::FRONT_USER_PORTFOLIO_TEMP_PATH;
            $allowedExtensions = Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES];//array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit = Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE];// maximum file size in bytes
//            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
//            $result = $uploader->handleUpload($folder);
            $fileNameSlugBefore = Yii::app()->user->id."_".time();
            $fileNameSlugAfter = Globals::FRONT_USER_USER_IMAGE_NAME_SLUG;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder,false,$fileNameSlugBefore,$fileNameSlugAfter);

//            $fileSize=filesize($folder.$result[Globals::FLD_NAME_FILENAME]);//GETTING FILE SIZE
//            $baseUrl = Globals::BASH_URL;
            $fileName=$result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME
            
//            $fileNamePath=$baseUrl.'/'.$folder.$result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME
            //$result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $fileName;// it's array
            //exit ();
        }
    public function loadModel($id)
    {
            $model=Inbox::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,Yii::t('poster_createtask','page_not_exist'));
            return $model;
    }
    
}