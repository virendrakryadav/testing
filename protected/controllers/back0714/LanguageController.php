<?php

class LanguageController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
   public $maxPriority;
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
				'actions'=>array('index','view','autocompletename','autocompletecode'),
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
		$model=new Language;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_LANGUAGE_CAP]))
		{   
         $priority=$_POST[Globals::FLD_NAME_LANGUAGE_CAP][Globals::FLD_NAME_LANGUAGE_PRIORITY];
			$model->attributes=$_POST[Globals::FLD_NAME_LANGUAGE_CAP];
			if($model->save())
         {
            //clear cache
            CommonUtility::clearCache(Globals::$cacheKeys['GET_LANGUAGE_LIST']);
            
            $insertedId=$model->getPrimaryKey();
            CommonUtility::resetMasterPriorities(Globals::FLD_NAME_LANGUAGE_CAP,$priority,$insertedId,Globals::FLD_NAME_LANGUAGE_PRIORITY,Globals::FLD_NAME_LANGUAGE_CODE);
            Yii::app()->user->setFlash('success',Yii::t('blog','Language has been added successfully.'));
            $this->redirect(array('admin'));
         }
		}
                $this->maxPriority=CommonUtility::selectNextPriority(Globals::FLD_NAME_LANGUAGE_CAP,Globals::FLD_NAME_LANGUAGE_PRIORITY);
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

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_LANGUAGE_CAP]))
		{
         $priority=$_POST[Globals::FLD_NAME_LANGUAGE_CAP][Globals::FLD_NAME_LANGUAGE_PRIORITY];  
			$model->attributes=$_POST[Globals::FLD_NAME_LANGUAGE_CAP];
         CommonUtility::resetMasterPriorities(Globals::FLD_NAME_LANGUAGE_CAP,$priority,$id,Globals::FLD_NAME_LANGUAGE_PRIORITY,Globals::FLD_NAME_LANGUAGE_CODE,NULL,'edit');
			if($model->save())
         {
            //clear cache
            CommonUtility::clearCache(Globals::$cacheKeys['GET_LANGUAGE_LIST']);
            Yii::app()->user->setFlash('success',Yii::t('blog','Language has been updated successfully.'));
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
		if($this->loadModel($id)->delete())
      {
         //clear cache
         CommonUtility::clearCache(Globals::$cacheKeys['GET_LANGUAGE_LIST']);
      }

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET[Globals::FLD_NAME_AJAX]))
      {
			$this->redirect(isset($_POST[Globals::FLD_NAME_RETURN_URL]) ? $_POST[Globals::FLD_NAME_RETURN_URL] : array('admin'));
      }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_LANGUAGE_CAP);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
      if (isset($_GET[Globals::FLD_NAME_LANGUAGE_DATE_SESSION]))
		{
			Yii::app()->user->setState(Globals::FLD_NAME_LANGUAGE_DATE_SESSION,(int)$_GET[Globals::FLD_NAME_LANGUAGE_DATE_SESSION]);
			unset($_GET[Globals::FLD_NAME_LANGUAGE_DATE_SESSION]); // would interfere with pager and repetitive page size change
		}
		$model=new Language('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[Globals::FLD_NAME_LANGUAGE_CAP]))
      {
         $model->attributes=$_GET[Globals::FLD_NAME_LANGUAGE_CAP];
      }
			
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

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Language the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Language::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	}
   public function actionAutoCompleteName()
   {
      if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
      {
         $name = $_GET[Globals::FLD_NAME_Q]; 
         $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
         CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_LANGUAGE_CAP,Globals::FLD_NAME_LANGUAGE_NAME,$limit);
      }
   }
   public function actionAutoCompleteCode()
   {
      if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
      {
         $name = $_GET[Globals::FLD_NAME_Q]; 
         $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
         CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_LANGUAGE_CAP,Globals::FLD_NAME_LANGUAGE_CODE,$limit);
      }
   }
	/**
	 * Performs the AJAX validation.
	 * @param Language $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX]=== Globals::DEFAULT_VAL_LANGUAGE_FORM)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
