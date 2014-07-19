<?php

class BlockedipController extends BackEndController
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
				'actions'=>array('index','view','autocompleteipaddress'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Blockedip;

		// Uncomment the following line if AJAX validation is needed  
                $model->scenario = Globals::SCENARIO_DATE_VALIDATION;               
		$this->performAjaxValidation($model);
                 
		if(isset($_POST[Globals::FLD_NAME_BLOCKED_IP]))
		{                                        
			$model->attributes = $_POST[Globals::FLD_NAME_BLOCKED_IP];
                        $model->start_dt=$_POST[Globals::FLD_NAME_BLOCKED_IP][Globals::FLD_NAME_BLOCKED_IP_START_DATE];
                        $model->end_dt=$_POST[Globals::FLD_NAME_BLOCKED_IP][Globals::FLD_NAME_BLOCKED_IP_END_DATE];
			if($model->save())
                        {
                                Yii::app()->user->setFlash('success',Yii::t('blog','BlockedIp has been added successfully.'));
				$this->redirect(array('admin'));
                        }                                      
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}        
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                $model->scenario = Globals::SCENARIO_DATE_VALIDATION_ON_UPDATE;               		                
                $this->performAjaxValidation($model);
		if(isset($_POST[Globals::FLD_NAME_BLOCKED_IP]))
		{

			$model->attributes=$_POST[Globals::FLD_NAME_BLOCKED_IP];
                        $model->start_dt=$_POST[Globals::FLD_NAME_BLOCKED_IP][Globals::FLD_NAME_BLOCKED_IP_START_DATE];
                        $model->end_dt=$_POST[Globals::FLD_NAME_BLOCKED_IP][Globals::FLD_NAME_BLOCKED_IP_END_DATE];
			if($model->Update())
			{
				Yii::app()->user->setFlash('success',Yii::t('blog','BlockedIP has been updated successfully.'));
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
		$deleteStatus=$this->loadModel($id)->delete();
				if($deleteStatus)
				{
						echo '<div class="flash-success">BlockedIP has been deleted successfully</div>';
				}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET[Globals::FLD_NAME_AJAX]))
			$this->redirect(isset($_POST[Globals::FLD_NAME_RETURN_URL]) ? $_POST[Globals::FLD_NAME_RETURN_URL] : array(Globals::FLD_NAME_ADMIN_SML));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_BLOCKED_IP);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Blockedip(Globals::DEFAULT_VAL_SEARCH);                
                if (isset($_GET[Globals::BLOCKED_IP_SESSION_NAME]))
		{
			Yii::app()->user->setState(Globals::BLOCKED_IP_SESSION_NAME,(int)$_GET[Globals::BLOCKED_IP_SESSION_NAME]);
			unset($_GET[Globals::BLOCKED_IP_SESSION_NAME]); // would interfere with pager and repetitive page size change
		}
				
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[Globals::FLD_NAME_BLOCKED_IP]))
			$model->attributes=$_GET[Globals::FLD_NAME_BLOCKED_IP];

		$currentRequest = Yii::app()->user->getState(Globals::FLD_NAME_PAGE_URL); 
		$fillFields = "";
		if(isset($currentRequest))
		{
				$fillFields = CommonUtility::createArray($currentRequest); 
		}
		$this->render('admin',array(
			'model'=>$model,
                        'fillFields'=>$fillFields,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BlockedIp the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Blockedip::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BlockedIp $model the model to be validated
	 */
        
        public function actionAutoCompleteIpAddress()
        {
           if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */
              $name = $_GET[Globals::FLD_NAME_Q]; 
              $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_BLOCKED_IP,Globals::FLD_NAME_BLOCKED_IP_ADDRESS,$limit);

           }
           
        }
        
	protected function performAjaxValidation($model)
	{
		if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX]=== Globals::BLOCKED_IP_FORM_NAME)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}        
}
