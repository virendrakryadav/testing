<?php

class UserprofileController extends Controller
{
//    public function filters() {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//        );
//    }
//	public function accessRules()
//	{
//            
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('ajaxgetpreferredlocationlist','taskpreview'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('invitetasker','invitenow','getaverage','viewprofile'),
//				'users'=>array('@'),
//			),
//			
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}
	
	public function actions()
	{
		return array(	
		);
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
            
            $model=User::model()->findByPk($id);
            if($model===null)
                throw new CHttpException(Globals::DEFAULT_VAL_404,Yii::t('tasker_createtask','page_not_exist'));
            return $model;
            
	}
   
   public function actionViewTaskerProfile()
   {
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::beginProfile('ViewTaskerProfile', 'application.controller.UserProfileConroller');
      }
      $this->layout = '//layouts/noheader';
      if(isset($_GET[Globals::FLD_NAME_USERID])){
         $id = $_GET[Globals::FLD_NAME_USERID];
         $user = User::model()->findByPk($id);
            $this->render('taskerprofile', array(
               'model' => $user, 
               ));
      }
      if(CommonUtility::IsProfilingEnabled())
      {
        Yii::endProfile('ViewTaskerProfile');
      }
   }
   
   public function actionTaskerAboutMe()
	{
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('TasketAboutMe','application.controller.UserProfileConroller');
                }
                $user_id = $_POST[ Globals::FLD_NAME_USER_ID ];
               
                $model = $this->loadModel( $user_id );
               
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        
                $this->renderPartial('_taskeraboutme', 
                            array( 
                                'model'=>$model,
                               
                                ),false,true);
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::endProfile('TasketAboutMe');
                }
        }
        public function actionTaskerConnections()
	{
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('TaskerConnections','application.controller.UserProfileConroller');
                }
                $user_id = $_POST[ Globals::FLD_NAME_USER_ID ];
               
                $model = $this->loadModel( $user_id );
               
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        
                $this->renderPartial('_taskerconnections', 
                            array( 
                                'model'=>$model,
                               
                                ),false,true);
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::endProfile('TaskerConnections');
                }
        }
        public function actionTaskerTasks()
	{
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('TaskerTasks','application.controller.UserProfileConroller');
                }
                $user_id = $_POST[ Globals::FLD_NAME_USER_ID ];
               
                $model = $this->loadModel( $user_id );
               
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        
                $this->renderPartial('_taskertasks', 
                            array( 
                                'model'=>$model,
                               
                                ),false,true);
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::endProfile('TaskerTasks');
                }
        }
        public function actionTaskerReferences()
	{
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('TaskerReferences','application.controller.UserProfileConroller');
                }
                $user_id = $_POST[ Globals::FLD_NAME_USER_ID ];
               
                $model = $this->loadModel( $user_id );
               
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        
                $this->renderPartial('_taskerrefrences', 
                            array( 
                                'model'=>$model,
                               
                                ),false,true);
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::endProfile('TaskerReferences');
                }
        }
        public function actionTaskerGroups()
	{
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('TaskerGroups','application.controller.UserProfileConroller');
                }
                $user_id = $_POST[ Globals::FLD_NAME_USER_ID ];
               
                $model = $this->loadModel( $user_id );
               
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        
                $this->renderPartial('_taskergroups', 
                            array( 
                                'model'=>$model,
                               
                                ),false,true);
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::endProfile('TaskerGroups');
                }
        }
        public function actionLoadTaskerTaskPreview()
	{
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('LoadTaskerTaskPreview','application.controller.UserProfileConroller');
                }
                $task_id = $_POST[ Globals::FLD_NAME_TASKID ];
              
                $task = Task::model()->findByPk($task_id);
                $model = $this->loadModel( $task->{Globals::FLD_NAME_CREATER_USER_ID} );
               
               
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        
                $this->renderPartial('_taskertaskpreview', 
                            array( 
                                'task'=>$task,
                                'model'=>$model,
                               
                                ),false,true);
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::endProfile('LoadTaskerTaskPreview');
                }
        }
        
        public function truncateText( $title, $length , $more = true)
    {
        $dots = '';
        if( $more == true ) $dots = '...';
        $substring = preg_replace('/\s+?(\S+)?$/', '', substr($string , 0, $length ));
        if (strlen($title) > $length )  $substring =  $substring.$dots;
        return $substring;
    }
        
}