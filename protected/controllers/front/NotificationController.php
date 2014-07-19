<?php
class NotificationController extends Controller
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
                'actions'=>array(),
                'users'=>array('*'),
            ),
            array('deny',  // deny all users
                'actions'=>array('index'),
                'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Index','application.controller.NotificationController');
        }
        @$sort = $_GET[Globals::FLD_NAME_SORT];
        $model=$this->loadModel(Yii::app()->user->id);
        $notifications = new UserAlert();
        $notifications = $notifications->getAllNotification($sort);
        
        $this->layout = '//layouts/noheader'; 
        $this->render('notification',array('model'=>$model,'notifications'=>$notifications));
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Index','application.controller.NotificationController');
        }
    }
    
    public function actionNotification()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Notification','application.controller.NotificationController');
        }
//        $task = new Task;
//        $taskState = @$_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE];
//        $taskList = $task->getMyInboxTaskListAsPoster();
        $model=$this->loadModel(Yii::app()->user->id);
        $notifications = new UserAlert();
        $this->layout = '//layouts/noheader';  
        $this->render('//notification_new/notification',array('model'=>$model,'notifications'=>$notifications));
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Notification','application.controller.NotificationController');
        }
    }
    
    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
    public function actionUserprimarydetail()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Userprimarydetail','application.controller.NotificationController');
        }        
        $user_id = Yii::app()->user->id;
        $model=User::model()->findByPk($user_id);
      
        $edittype = $_POST['edittype'];
        $divid = $_POST['divid'];
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $this->renderPartial('_userprimarydetail',array('model'=>$model,'edittype'=>$edittype,'divid'=>$divid),false,true);
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Userprimarydetail','application.controller.NotificationController');
        }
    }
    
    public function actionEdituserprimarydetail()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Edituserprimarydetail','application.controller.NotificationController');
        }        
        $user_id = Yii::app()->user->id;
        $model=User::model()->findByPk($user_id);
        if(isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            if(isset($_POST['User']['primary_email']))
            {
                $model->primary_email = $_POST['User']['primary_email'];
            }
            if(isset($_POST['User']['primary_phone']))
            {
                $model->primary_phone = $_POST['User']['primary_phone'];
            }           
            $model->Update();
            Yii::app()->end();
        }
        $edittype = $_POST['edittype'];
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $this->renderPartial('_edituserprimarydetail',array('model'=>$model,'edittype'=>$edittype),false,true);
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Edituserprimarydetail','application.controller.NotificationController');
        }
    }
    
    public function actionNotificationsetting()
    {        
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('NotificationSetting','application.controller.NotificationController');
        }
        $user_id = Yii::app()->user->id;
        $userNotCategory = new UserNotificationCategory();
        $userNotSkills = new UserNotificationSkill();
        $notification = UserNotification::getNotificationByUserId($user_id);
        $model=User::model()->findByPk($user_id);
        if($_POST)
        {
//            echo"<pre>";
//            print_r($_POST);
//            exit;
            try
               {            
                if(isset($_POST['postercount']) && $_POST['postercount'] > 0)
                {
                    for($poster = 1; $poster<$_POST['postercount']; $poster++)
                    {
                        if(isset($_POST['posteremail'.$poster]))
                        {
                            $postermodel[$poster] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['posternotid'.$poster],'user_id'=>$user_id));
                            $postermodel[$poster]->send_email = 1;
                            $postermodel[$poster]->update();
                        }  
                        else
                        {
                            $postermodel[$poster] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['posternotid'.$poster],'user_id'=>$user_id));
                            $postermodel[$poster]->send_email = 0;
                            $postermodel[$poster]->update();
                        }
                        if(isset($_POST['postersms'.$poster]))
                        {
                            $postermodel[$poster] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['posternotid'.$poster],'user_id'=>$user_id));
                            $postermodel[$poster]->send_sms = 1;
                            $postermodel[$poster]->update();
                        }  
                        else
                        {
                            $postermodel[$poster] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['posternotid'.$poster],'user_id'=>$user_id));
                            $postermodel[$poster]->send_sms = 0;
                            $postermodel[$poster]->update();
                        }
                    }
                }

                if(isset($_POST['doercount']) && $_POST['doercount'] > 0)
                {
                    for($doer = 1; $doer<$_POST['doercount']; $doer++)
                    {
                        if(isset($_POST['doeremail'.$doer]))
                        {
                            $doermodel[$doer] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['doernotid'.$doer],'user_id'=>$user_id));
                            $doermodel[$doer]->send_email = 1;
                            $doermodel[$doer]->update();
                        }  
                        else
                        {
                            $doermodel[$doer] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['doernotid'.$doer],'user_id'=>$user_id));
                            $doermodel[$doer]->send_email = 0;
                            $doermodel[$doer]->update();
                        }
                        if(isset($_POST['doersms'.$doer]))
                        {
                            $doermodel[$doer] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['doernotid'.$doer],'user_id'=>$user_id));
                            $doermodel[$doer]->send_sms = 1;
                            $doermodel[$doer]->update();
                        }  
                        else
                        {
                            $doermodel[$doer] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['doernotid'.$doer],'user_id'=>$user_id));
                            $doermodel[$doer]->send_sms = 0;
                            $doermodel[$doer]->update();
                        }
                    }
                }

                if(isset($_POST['systemcount']) && $_POST['systemcount'] > 0)
                {
                    for($system = 1; $system<$_POST['systemcount']; $system++)
                    {
                        if(isset($_POST['systememail'.$system]))
                        {
                            $systemmodel[$system] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['systemnotid'.$system],'user_id'=>$user_id));
                            $systemmodel[$system]->send_email = 1;
                            $systemmodel[$system]->update();
                        }  
                        else
                        {
                            $systemmodel[$system] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['systemnotid'.$system],'user_id'=>$user_id));
                            $systemmodel[$system]->send_email = 0;
                            $systemmodel[$system]->update();
                        }
                        if(isset($_POST['systemsms'.$system]))
                        {
                            $systemmodel[$system] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['systemnotid'.$system],'user_id'=>$user_id));
                            $systemmodel[$system]->send_sms = 1;
                            $systemmodel[$system]->update();
                        }  
                        else
                        {
                            $systemmodel[$system] = UserNotification::model()->findByAttributes(array('notification_id'=>$_POST['systemnotid'.$system],'user_id'=>$user_id));
                            $systemmodel[$system]->send_sms = 0;
                            $systemmodel[$system]->update();
                        }
                    }
                }                                                    
               }
               catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg($msg);
                }
            Yii::app()->end();
        }
        $this->layout = '//layouts/noheader';        
        $this->render('notificationsetting',
                array('notification'=>$notification,
                    'notificationsetting'=>$notification,
                    'model'=>$model,
                    'userNotCategory'=>$userNotCategory,
                    'userNotSkills'=>$userNotSkills));
        
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('NotificationSetting','application.controller.NotificationController');
        }
    }
}