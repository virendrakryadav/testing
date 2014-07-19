<?php
class CountryController extends BackEndController
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
	
	//I have hide this because there is no need of access rules to define in every controller
	public function accessRules()
	{
        $perform = $this->Permissions();
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','autocompletecountrycode','autocompletecountryname'),
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
		$model=new Country;
		$locale = new CountryLocale;
		//CommonUtility::selectNextPriority(Globals::FLD_NAME_COUNTRY,'cou_priority');
		//exit;
		// Uncomment the following line if AJAX validation is needed
		
		$this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_COUNTRY]))
		{
			$cou_priority=$_POST[Globals::FLD_NAME_COUNTRY_LOCALE][Globals::FLD_NAME_COUNTRY_PRIORITY];
		
			$model->attributes=$_POST[Globals::FLD_NAME_COUNTRY];
			$locale->attributes=$_POST[Globals::FLD_NAME_COUNTRY_LOCALE];
			if($model->save())
			{   
			   //clear cache
                        CacheManagement::deleteCountryCache();
            
				$locale->{Globals::FLD_NAME_COUNTRY_CODE} = $_POST[Globals::FLD_NAME_COUNTRY][Globals::FLD_NAME_COUNTRY_CODE];
				$locale->{Globals::FLD_NAME_LANGUAGE_CODE} = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
				if($locale->save())
				{
					// $insertedId=$model->getPrimaryKey();
					CommonUtility::resetMasterPriorities(Globals::FLD_NAME_COUNTRY_LOCALE,$cou_priority,$locale->{Globals::FLD_NAME_COUNTRY_CODE},Globals::FLD_NAME_COUNTRY_PRIORITY,Globals::FLD_NAME_COUNTRY_CODE,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));
					Yii::app()->user->setFlash('success',Yii::t('blog','Country has been added successfully.'));
					$this->redirect(array('admin'));
				} 
				
			}
		}
		$this->maxPriority=CommonUtility::selectNextPriority(Globals::FLD_NAME_COUNTRY_LOCALE,Globals::FLD_NAME_COUNTRY_PRIORITY);
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
				//if($act==Globals::DEFAULT_VAL_DO_DELETE)
				//{
					//$model->delete();
				//}
				if($act== Globals::DEFAULT_VAL_DO_ACTION)
				{
					$model->country_status = Globals::DEFAULT_VAL_1;
				}
				if($act== Globals::DEFAULT_VAL_DO_IN_ACTION)
				{
					$model->country_status = Globals::DEFAULT_VAL_0;         
				}         
				if($model->save()){
				  //clear cache
                                CacheManagement::deleteCountryCache();
				}
            
			}
			if($act==Globals::DEFAULT_VAL_DO_DELETE)
			{
				CommonUtility::setFlashMsg('flash-success','Record(s) has been deleted successfully.');
			}
			if($act==Globals::DEFAULT_VAL_DO_ACTION)
			{
				CommonUtility::setFlashMsg('flash-success','Record(s) has been activated successfully.');
			}
			if($act== Globals::DEFAULT_VAL_DO_IN_ACTION)
			{
				CommonUtility::setFlashMsg('flash-success','Record(s) has been in-activated successfully.');
			}    
		}
		else
		{
			CommonUtility::setFlashMsg('flash-notice','Please select atleast one record.');
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
                $locale = CountryLocale::model()->findByAttributes(array(Globals::FLD_NAME_COUNTRY_CODE=>$model->{Globals::FLD_NAME_COUNTRY_CODE},'language_code'=>Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE)));
		// comment the following line if AJAX validation is not needed
		$this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_COUNTRY]))
		{
			$cou_priority=$_POST[Globals::FLD_NAME_COUNTRY_LOCALE][Globals::FLD_NAME_COUNTRY_PRIORITY];
			$model->attributes=$_POST[Globals::FLD_NAME_COUNTRY];
                        $locale->attributes=$_POST[Globals::FLD_NAME_COUNTRY_LOCALE];
			$model->{Globals::FLD_NAME_COUNTRY_CODE} = strtoupper($_POST[Globals::FLD_NAME_COUNTRY][Globals::FLD_NAME_COUNTRY_CODE]);
                        $locale->{Globals::FLD_NAME_COUNTRY_CODE} = strtoupper($_POST[Globals::FLD_NAME_COUNTRY][Globals::FLD_NAME_COUNTRY_CODE]);
			CommonUtility::resetMasterPriorities(Globals::FLD_NAME_COUNTRY_LOCALE,$cou_priority,$id,Globals::FLD_NAME_COUNTRY_PRIORITY,Globals::FLD_NAME_COUNTRY_CODE,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE),'edit');
			if($model->update())
			{
			   //clear cache
            CacheManagement::deleteCountryCache();
            
             if($locale->update())
             {
				Yii::app()->user->setFlash('success',Yii::t('blog','Country has been updated successfully.'));
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
		try
		{
        $hasforeign = StateLocale::model()->findByAttributes(array(Globals::FLD_NAME_COUNTRY_CODE=>$id));
        if($hasforeign)
        {
            throw new Exception("Relation Restriction."); 
        }
        $deleteSttausLocal = CountryLocale::model()->deleteAll('country_code=:id', array(':id' => $id));
        $deleteSttaus=$this->loadModel($id)->delete();
        if($deleteSttaus && $deleteSttausLocal)
        {
         //clear cache
         CacheManagement::deleteCountryCache();
			CommonUtility::setFlashMsg('flash-success','Country has been deleted successfully.');
        }
		}
		catch(Exception $e)
		{
//			header("HTTP/1.0 400 Relation Restriction");
//			echo "This country has been assigned to any State (Relation Restriction).\n";
			CommonUtility::setFlashMsg('flash-notice','This country has been assigned to any State (Relation Restriction).');

		}
		if(!isset($_GET[Globals::FLD_NAME_AJAX]))
			$this->redirect(isset($_POST[Globals::FLD_NAME_RETURN_URL]) ? $_POST[Globals::FLD_NAME_RETURN_URL] : array('admin'));

	}




	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_COUNTRY);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if (isset($_GET[Globals::FLD_NAME_COUNTRY_DATA_SESSION]))
		{
			Yii::app()->user->setState(Globals::FLD_NAME_COUNTRY_DATA_SESSION,(int)$_GET[Globals::FLD_NAME_COUNTRY_DATA_SESSION]);
			unset($_GET[Globals::FLD_NAME_COUNTRY_DATA_SESSION]); // would interfere with pager and repetitive page size change
		}
		$model=new Country('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[Globals::FLD_NAME_COUNTRY]))
		$model->attributes=$_GET[Globals::FLD_NAME_COUNTRY];

                $currentRequest = Yii::app()->user->getState(Globals::FLD_NAME_PAGE_URL); 
               // $currentRequest =$_SESSION['11fa452d417770b5cc0ef107ad8e391dpageUrl']; 
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
	 * @return Country the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Country::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	}
        
        public function actionAutoCompleteCountryCode()
        {
           
           if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */
               
                $name = $_GET[Globals::FLD_NAME_Q]; 
                        // this was set with the "max" attribute of the CAutoComplete widget
              $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_COUNTRY,Globals::FLD_NAME_COUNTRY_CODE,$limit);
              
           }
        }
        public function actionAutoCompleteCountryName()
        {
           
           if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */
              $name = $_GET[Globals::FLD_NAME_Q]; 
              $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_COUNTRY_LOCALE,'country_name',$limit,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));
           }
        }
	/**
	 * Performs the AJAX validation.
	 * @param Country $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX] === Globals::DEFAULT_VAL_COUNTRY_FORM)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
?>