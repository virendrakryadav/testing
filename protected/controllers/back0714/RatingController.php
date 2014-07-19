<?php

class RatingController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $maxPriority;
        public $created_by;
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
				'actions'=>array('index','view','autocompleteratingdescription'),
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
		$model = new Rating;
                $locale = new RatingLocale;
		// Uncomment the following line if AJAX validation is needed 
//		$this->performAjaxValidation($model);
		$this->performAjaxValidation($locale);
                if(isset($_POST[Globals::FLD_NAME_RATING_UCFIRST]))
                  {   
			//$rating_priority=$_POST[Globals::FLD_NAME_RATING_LOCALE][Globals::FLD_NAME_RATING_PRIORITY];
                        $model->attributes = $_POST[Globals::FLD_NAME_RATING_UCFIRST];
                        $locale->attributes=$_POST[Globals::FLD_NAME_RATING_LOCALE];
                        $model->{Globals::FLD_NAME_STATUS} = $_POST[Globals::FLD_NAME_RATING_LOCALE][Globals::FLD_NAME_STATUS];
                            if($model->save())
                            {
                            $insertedId=$model->getPrimaryKey();
                            $locale->{Globals::FLD_NAME_RATING_ID} = $insertedId;
                            $locale->{Globals::FLD_NAME_RATING_DESC} = $_POST[Globals::FLD_NAME_RATING_LOCALE][Globals::FLD_NAME_RATING_DESC];
                            $locale->{Globals::FLD_NAME_RATING_PRIORITY} = $_POST[Globals::FLD_NAME_RATING_LOCALE][Globals::FLD_NAME_RATING_PRIORITY];
                            $locale->{Globals::FLD_NAME_LANGUAGE_CODE} = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
                                if($locale->save())
                                {
                                   //CommonUtility::resetMasterPriorities(Globals::FLD_NAME_RATING_LOCALE,$rating_priority,$locale->{Globals::FLD_NAME_RATING_ID},Globals::FLD_NAME_RATING_PRIORITY,Globals::FLD_NAME_RATING_ID);
                                    Yii::app()->user->setFlash('success',Yii::t('blog','Rating has been added successfully.'));
                                    $this->redirect(array('admin'));
                                } 
                            }
                    }
                $this->maxPriority=CommonUtility::selectNextPriority(Globals::FLD_NAME_RATING_LOCALE,Globals::FLD_NAME_RATING_PRIORITY);
		$this->render('create',array(
			'model'=>$model,
                        'locale'=>$locale,
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
                //$locale = RatingLocale::model()->findByAttributes(array(Globals::FLD_NAME_RATING_ID=>$model->{Globals::FLD_NAME_RATING_ID})); 
                $locale = RatingLocale::model()->findByAttributes(array(Globals::FLD_NAME_RATING_ID=>$model->rating_id,Globals::FLD_NAME_LANGUAGE_CODE=>Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE)));        
//              $this->performAjaxValidation($model);
                $this->performAjaxValidation($locale);
		if(isset($_POST[Globals::FLD_NAME_RATING_UCFIRST]))
		{
//                      $rating_priority=$_POST[Globals::FLD_NAME_RATING_LOCALE][Globals::FLD_NAME_RATING_PRIORITY];
			$model->attributes=$_POST[Globals::FLD_NAME_RATING_UCFIRST];
                        $locale->attributes=$_POST[Globals::FLD_NAME_RATING_LOCALE];
                        $model->{Globals::FLD_NAME_STATUS} = $_POST[Globals::FLD_NAME_RATING_LOCALE][Globals::FLD_NAME_STATUS];
                        //$model->{Globals::FLD_NAME_RATING} = strtoupper($_POST[Globals::FLD_NAME_RATING_UCFIRST][Globals::FLD_NAME_RATING_ID]);
                        //$locale->{Globals::FLD_NAME_RATING_LOCALE} = strtoupper($_POST[Globals::FLD_NAME_RATING_LOCALE][Globals::FLD_NAME_RATING_ID]);
			if($model->Update())
			{
                            if($locale->update())
                                    {
                                    Yii::app()->user->setFlash('success',Yii::t('blog','Rating has been updated successfully.'));
                                    $this->redirect(array('admin'));
                                    }
			}
		}
                $this->render('update',array(
			'model'=>$model,
                        'locale'=>$locale,
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
				echo '<div class="flash-success">Rating has been deleted successfully</div>';
				}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_RATING);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Rating('search');                
                if (isset($_GET['ratingDataSession']))
		{
			Yii::app()->user->setState('ratingDataSession',(int)$_GET['ratingDataSession']);
			unset($_GET['ratingDataSession']); // would interfere with pager and repetitive page size change
		}
				
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[Globals::FLD_NAME_RATING]))
		$model->attributes=$_GET[Globals::FLD_NAME_RATING];

		$currentRequest = Yii::app()->user->getState('pageUrl'); 
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
       
        public function actionAutoCompleteRatingDescription()
        {
            if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
            {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */
              $name = $_GET[Globals::FLD_NAME_Q]; 
              $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_RATING_LOCALE,Globals::FLD_NAME_RATING_DESC,$limit);
            }
           
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
		$model=Rating::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BlockedIp $model the model to be validated
	 */
 
        
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rating-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}