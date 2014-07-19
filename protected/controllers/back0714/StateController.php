<?php

class StateController extends BackEndController
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
				'actions'=>array('index','view','autocompletestatename','ajaxgetstate'),
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
		$model=new State;
                $locale = new StateLocale;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($locale);
                //$this->performAjaxValidation($model);
		if(isset($_POST[Globals::FLD_NAME_STATE_LOCALE]))
		{
			$state_priority=$_POST[Globals::FLD_NAME_STATE_LOCALE][Globals::FLD_NAME_STATE_PRIORITY];
                        $locale->attributes=$_POST[Globals::FLD_NAME_STATE_LOCALE];
			if($model->save())
			{
                            $locale->state_id = $model->primaryKey; 
                            $locale->{Globals::FLD_NAME_LANGUAGE_CODE} = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
                            if($locale->save())
                            {
				$insertedId=$model->getPrimaryKey();
                                CommonUtility::resetMasterPriorities(Globals::FLD_NAME_STATE_LOCALE,$state_priority,$insertedId,Globals::FLD_NAME_STATE_PRIORITY,Globals::FLD_NAME_STATE_ID,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));

				//CommonUtility::resetMasterPriorities(Globals::FLD_NAME_STATE,$state_priority,$insertedId,Globals::FLD_NAME_STATE_PRIORITY,Globals::FLD_NAME_STATE_ID);
				Yii::app()->user->setFlash('success',Yii::t('blog','State has been added successfully.'));
				$this->redirect(array('admin'));
                            }
			}
		}
		$this->maxPriority=CommonUtility::selectNextPriority(Globals::FLD_NAME_STATE_LOCALE,Globals::FLD_NAME_STATE_PRIORITY);
		$this->render('create',array(
			'model'=>$model,
                        'locale'=>$locale,
		));
	}
	
	public function actionAjaxupdate()
	{
	    $act = $_GET[Globals::FLD_NAME_ACT];
		$autoIdAll = $_POST[Globals::FLD_NAME_AUTO_ID];
		if(count($autoIdAll)> Globals::DEFAULT_VAL_0)
		{
			foreach($autoIdAll as $autoId)
			{
				$model=$this->loadModel($autoId);
				//if($act=='doDelete')
				//{
					//$model->delete();
				//}
				if($act== Globals::DEFAULT_VAL_DO_ACTION)
				{
					$model->state_status = Globals::DEFAULT_VAL_1;
				}
				if($act== Globals::DEFAULT_VAL_DO_IN_ACTION)
				{
					$model->state_status = Globals::DEFAULT_VAL_0;         
				}         
				$model->save();
			}
			if($act== Globals::DEFAULT_VAL_DO_DELETE)
			{
				CommonUtility::setFlashMsg('flash-success','State(s) has been deleted successfully.');
			}
			if($act==Globals::DEFAULT_VAL_DO_ACTION)
			{
				CommonUtility::setFlashMsg('flash-success','State(s) has been activated successfully.');
			}
			if($act== Globals::DEFAULT_VAL_DO_IN_ACTION)
			{
				CommonUtility::setFlashMsg('flash-success','State(s) has been in-activated successfully.');
			}    
		}
		else
		{
			CommonUtility::setFlashMsg('flash-notice','Please select atleast one state.');
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                $locale = StateLocale::model()->findByAttributes(array(Globals::FLD_NAME_STATE_ID=>$model->state_id,Globals::FLD_NAME_LANGUAGE_CODE=>Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE)));
                
                
		// comment the following line if AJAX validation is not needed
		//$this->performAjaxValidation($locale);
                $this->performAjaxValidation($locale);
                        
		if(isset($_POST[Globals::FLD_NAME_STATE_LOCALE]))
		{
			$state_priority=$_POST[Globals::FLD_NAME_STATE_LOCALE][Globals::FLD_NAME_STATE_PRIORITY];
//			$model->attributes=$_POST[Globals::FLD_NAME_STATE];
                        $locale->attributes=$_POST[Globals::FLD_NAME_STATE_LOCALE];
			CommonUtility::resetMasterPriorities(Globals::FLD_NAME_STATE_LOCALE,$state_priority,$id,Globals::FLD_NAME_STATE_PRIORITY,Globals::FLD_NAME_STATE_ID,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE),'edit');
//			if( $model->update() )
//			{
                            if($locale->update())
                            {
				Yii::app()->user->setFlash('success',Yii::t('blog','State has been updated successfully.'));
				$this->redirect(array('admin'));
                            }
//			}
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
            try
		{
                    $hasforeign = RegionLocale::model()->findByAttributes(array(Globals::FLD_NAME_STATE_ID=>$id,Globals::FLD_NAME_LANGUAGE_CODE=>Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE)));
                    if($hasforeign)
                    {
                        throw new Exception("Relation Restriction."); 
                    }
                    $deleteSttausLocal = StateLocale::model()->deleteAll('state_id=:id', array(':id' => $id));
                    $deleteSttaus=$this->loadModel($id)->delete();
                    if($deleteSttaus)
                    {
						CommonUtility::setFlashMsg('flash-success','State has been deleted successfully.');
                    }
		}
		catch(Exception $e)
		{
			CommonUtility::setFlashMsg('flash-notice','This state has been assigned to any Region (Relation Restriction).');
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET[Globals::FLD_NAME_AJAX]))
			$this->redirect(isset($_POST[Globals::FLD_NAME_RETURN_URL]) ? $_POST[Globals::FLD_NAME_RETURN_URL] : array('admin'));
	}

	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_STATE);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if (isset($_GET[Globals::FLD_NAME_STATE_DATE_SESSION]))
		{
			Yii::app()->user->setState(Globals::FLD_NAME_STATE_DATE_SESSION,(int)$_GET[Globals::FLD_NAME_STATE_DATE_SESSION]);
			unset($_GET[Globals::FLD_NAME_STATE_DATE_SESSION]); // would interfere with pager and repetitive page size change
		}
		
		$model=new State('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[Globals::FLD_NAME_STATE]))
			$model->attributes=$_GET[Globals::FLD_NAME_STATE];

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
	 * @return State the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=State::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	}
        public function actionAutoCompleteStateName()
        {
           if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */
              $name = $_GET[Globals::FLD_NAME_Q]; 
              $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_STATE_LOCALE,Globals::FLD_NAME_STATE_NAME,$limit,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));

           }
           
        }
        public function actionAjaxGetState()
        {
            
            $criteria = new CDbCriteria();
            $criteria->condition = "statelocale.language_code =:language";
            $criteria->condition = "statelocale.country_code ='".$_POST[Globals::FLD_NAME_COUNTRY_CODE]."'";
            $criteria->params = array(':language' => Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE) );
            $state = State::model()->with('statelocale')->findAll($criteria,array('order' => Globals::FLD_NAME_STATE_PRIORITY));
            $data=CHtml::listData($state,Globals::FLD_NAME_STATE_ID,'statelocale.state_name');
            echo CHtml::tag('option',array('value'=>''),CHtml::encode('--Select State--'),true);
            foreach($data as $state_id=>$state_name)
            {
                echo CHtml::tag('option',array('value'=>$state_id),CHtml::encode($state_name),true);
            }
        }
	/**
	 * Performs the AJAX validation.
	 * @param State $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX] === Globals::DEFAULT_VAL_STATE_FORM)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
