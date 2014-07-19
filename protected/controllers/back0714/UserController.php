<?php

class UserController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
            $perform = $this->Permissions();
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','autocompleteemail','taskproposallist','suspendpopup','passwordchange'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>$perform,
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            if($id)
            {
                if($id != Yii::app()->user->getState('userDetailid'))
                {
                    Yii::app()->user->setState('userDetailid',(int)$id);
                    Yii::app()->user->setState(Globals::FLD_NAME_PAGE_URL , ''); 
                }
            }
            $id = Yii::app()->user->getState('userDetailid');
            $model = $this->loadModel($id);
            $task = new Task();
            if (isset($_GET['taskDataSession']))
            {
                Yii::app()->user->setState('taskDataSession',(int)$_GET['taskDataSession']);
                unset($_GET['taskDataSession']); // would interfere with pager and repetitive page size change
            }
                try
                {
                    $taskList = $task->searchPostedTasks($id);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg );
                }
                try
                {
                    $taskListAsTasker = $task->searchDoneTasks($id);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg );
                }
            
           
            $currentRequest = Yii::app()->user->getState(Globals::FLD_NAME_PAGE_URL); 
            $fillFields = Globals::DEFAULT_VAL_NULL;
            if(isset($currentRequest))
            {
                $fillFields = CommonUtility::createArray($currentRequest); 
            }
            $fillFields['id']= $id;
            //print_r($fillFields);
            $this->render('view',array(
                            'model'=>$model,
                            'task' => $task,
                            'taskList' => $taskList,
                'fillFields'=>$fillFields,
                'taskListAsTasker' => $taskListAsTasker
            ));
	}
        public function actiontaskproposallist()
	{
             CommonUtility::startProfiling();
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
              //  print_r($proposals);
            $this->renderPartial('taskporposals',array(
                                'proposals' => $proposals
                      ),false,true);
             CommonUtility::endProfiling();
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_USER]))
		{
                        $date_of_birth = new DateTime($_POST[Globals::FLD_NAME_DATE_OF_BIRTH]);
                        $date_of_birth = $date_of_birth->format('Y-m-d H:i:s');
                    
			$model->attributes=$_POST[Globals::FLD_NAME_USER];
                        $model->{Globals::FLD_NAME_IS_VERIFIED}= Globals::DEFAULT_VAL_1;
                        $model->{Globals::FLD_NAME_SOURCE_APP}= Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        
                        $model->{Globals::FLD_NAME_PRIMARY_PHONE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_PRIMARY_PHONE];
                        $model->{Globals::FLD_NAME_DATE_OF_BIRTH} = $date_of_birth;
                        $model->{Globals::FLD_NAME_GENDER} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GENDER];
			if($model->save())
                        {
                            // Start for Update user search field
                            CommonUtility::updateUserSearchField($model->primaryKey);
                            // End for Update user search field
                            Yii::app()->user->setFlash('success',Yii::t('blog','User has been added successfully.'));
                            $this->redirect(array('admin'));
                        }
                }

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        public function actionSuspendpopup()
	{
		$suspenduser = new UserActivity;
                $suspenduser->scenario = 'suspanded';
                $by_user_id = Yii::app()->user->id;                                
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                if(isset($_POST['UserActivity']['of_user_id']))
                {
                    $of_user_id = $_POST['UserActivity']['of_user_id'];
                }
                else
                {
                    $of_user_id = $_POST['userid'];
                }
                

		if(isset($_POST['UserActivity']))
		{   
                    $suspenduser->attributes = $_POST['UserActivity'];
                    $suspenduser->by_user_id = $by_user_id;
                    $suspenduser->of_user_id = $_POST['UserActivity']['of_user_id'];
                    $suspenduser->activity_type = 'suspend';
                    $suspenduser->comments = $_POST['UserActivity']['comments'];
                    $error = CActiveForm::validate($suspenduser);                    
                    if($error == '[]')
                    {
                        if($suspenduser->save())
                        {
                            echo CJSON::encode(array(
                                'errorCode'=>'success',
                            ));
                        }
                        Yii::app()->end();
                    }
                    else
                    {
                         if($error!='[]')
                                echo $error;
                        Yii::app()->end();
                    }                                                                                              
                }                
		$this->renderPartial('suspendpopup',array(
			'suspenduser'=>$suspenduser,
                        'by_user_id'=>$by_user_id,
                        'of_user_id'=>$of_user_id,
		),false,true);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);                 
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_USER]))
		{
//                    echo '<pre>';                    
//                    print_r($_POST);
//                    exit;                        
                        $date_of_birth = new DateTime($_POST[Globals::FLD_NAME_DATE_OF_BIRTH]);
                        $date_of_birth = $date_of_birth->format('Y-m-d H:i:s');
                        $aboutme[Globals::FLD_NAME_ABOUTME]=User::filterPostalCode($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_ABOUT_ME]);
                        if(!isset($aboutme[Globals::FLD_NAME_CERTIFICATE_VAL]))
                        {
                            $aboutme[Globals::FLD_NAME_CERTIFICATE_VAL]=Globals::DEFAULT_VAL_NULL;
                        }
                        $aboutme = json_encode($aboutme);
			$model->attributes=$_POST[Globals::FLD_NAME_USER];
                        $model->{Globals::FLD_NAME_ABOUT_ME} = $aboutme;
                        
                        $model->{Globals::FLD_NAME_PRIMARY_PHONE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_PRIMARY_PHONE];
                        $model->{Globals::FLD_NAME_DATE_OF_BIRTH} = $date_of_birth;
                        $model->{Globals::FLD_NAME_GENDER} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GENDER];
                        
			if($model->Update())
                        {
                                // Start for Update user search field
                                CommonUtility::updateUserSearchField($id);
                                // End for Update user search field
                                Yii::app()->user->setFlash('success',Yii::t('blog','User has been updated successfully.'));
				$this->redirect(array('admin'));
                        }
                }

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		CommonUtility::setFlashMsg('flash-success','User has been deleted successfully.');
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET[Globals::FLD_NAME_AJAX]))
			$this->redirect(isset($_POST[Globals::FLD_NAME_RETURN_URL]) ? $_POST[Globals::FLD_NAME_RETURN_URL] : array('admin'));
	}
//        public function actionUserChangePassword($id)
//        {
//
//            $model=$this->loadModel($id);
//            $model->setScenario(Globals::USER_CHANGE_PASSWORD);
//            // Uncomment the following line if AJAX validation is needed
//            $this->performAjaxValidation($model);
//            
//            if(isset($_POST[Globals::FLD_NAME_USER]))
//            {               
//                $model->attributes = $_POST[Globals::FLD_NAME_USER];
//                $model->password=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NEW_PASSWORD];
//                if($model->save())
//                {
//                    Yii::app()->user->setFlash('success','User password has been changed successfully.');
//                    $this->redirect(array('admin'));
//                }
//            }
//            $this->render('userchangepassword',array('model'=>$model));
//        }
        
        public function actionPasswordchange($id)
	{

		$model=$this->loadModel($id);
		$model->setScenario('passwordchange');
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		if(isset($_POST[Globals::FLD_NAME_USER]))
		{               
			$model->attributes = $_POST[Globals::FLD_NAME_USER];
			$model->password=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NEW_PASSWORD];
			if($model->Update())
			{
				Yii::app()->user->setFlash('success','Admin user password has been changed successfully.');
				$this->redirect(array('admin'));
			}
		}
		$this->render('passwordchange',array('model'=>$model));
	}
        
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_USER);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
                if (isset($_GET[Globals::FLD_NAME_USER_DATE_SESSION]))
		{
			Yii::app()->user->setState(Globals::FLD_NAME_USER_DATE_SESSION,(int)$_GET[Globals::FLD_NAME_USER_DATE_SESSION]);
			unset($_GET[Globals::FLD_NAME_USER_DATE_SESSION]); // would interfere with pager and repetitive page size change
		}
                
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[Globals::FLD_NAME_USER]))
			$model->attributes=$_GET[Globals::FLD_NAME_USER];
                
                
                $currentRequest = Yii::app()->user->getState(Globals::FLD_NAME_PAGE_URL); 
		$fillFields = Globals::DEFAULT_VAL_NULL;
		if(isset($currentRequest))
		{
                    $fillFields = CommonUtility::createArray($currentRequest); 
		}
		$this->render('admin',array(
			'model'=>$model,
                    'fillFields'=>$fillFields,
		));
	}
        public function actionAutoCompleteEmail()
        {
           
           if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */
              $name = $_GET[Globals::FLD_NAME_Q]; 
                        // this was set with the "max" attribute of the CAutoComplete widget
              $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
              // getAutoCompleteData($name,$tableName,$fieldName,$limit)
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_USER,Globals::FLD_NAME_EMAIL,$limit);
              
           }
        }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST[Globals::FLD_NAME_AJAX]) 
                        && $_POST[Globals::FLD_NAME_AJAX] === Globals::DEFAULT_VAL_USER_FORM 
                        && $_POST[Globals::FLD_NAME_AJAX] === 'suspend-form'
                        && $_POST[Globals::FLD_NAME_AJAX] === 'user-changepassword')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
