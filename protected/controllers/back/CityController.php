<?php
class CityController extends BackEndController
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
				'actions'=>array('index','view','ajaxgetcity','autocompletename'),
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
        public function actionAjaxGetCity()
        {
            if(isset($_POST[Globals::FLD_NAME_LANGUAGE]) && $_POST[Globals::FLD_NAME_LANGUAGE] !='')
            {
                    $language = $_POST[Globals::FLD_NAME_LANGUAGE];				
            }
            else
            {
                    $language =Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
            }
            $criteria = new CDbCriteria();
            $criteria->condition = "region_id ='".$_POST[Globals::FLD_NAME_REGION_ID]."'";
            $criteria->addCondition('language_code ="'.$language.'"');
            $city = CityLocale::model()->findAll($criteria,array('order' => Globals::FLD_NAME_CITY_PRIORITY));
            $data=CHtml::listData($city,'city_id','city_name');
            echo CHtml::tag('option',array('value'=>''),CHtml::encode('--Select City--'),true);
            foreach($data as $city_id=>$city_name)
            {
                echo CHtml::tag('option',array('value'=>$city_id),CHtml::encode($city_name),true);
            }
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
		$model=new City;
		$locale = new CityLocale;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$this->performAjaxValidation($locale);
		if(isset($_POST[Globals::FLD_NAME_CITY_LOCALE]))
		{       
			$city_priority=$_POST[Globals::FLD_NAME_CITY_LOCALE][Globals::FLD_NAME_CITY_PRIORITY];
//			$model->attributes=$_POST[Globals::FLD_NAME_CITY_CAP];
			$locale->attributes=$_POST[Globals::FLD_NAME_CITY_LOCALE];
			if($model->save())
			{   
				$insertedId=$model->getPrimaryKey();
				$locale->city_id = $insertedId;
				$locale->{Globals::FLD_NAME_LANGUAGE_CODE} = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
				if($locale->save())
				{
					CommonUtility::resetMasterPriorities(Globals::FLD_NAME_CITY_LOCALE,$city_priority,$insertedId,Globals::FLD_NAME_CITY_PRIORITY,'city_id',Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));
					Yii::app()->user->setFlash('success',Yii::t('blog','City has been added successfully.'));
					$this->redirect(array('admin'));
				}
			}
		}

		$this->maxPriority=CommonUtility::selectNextPriority(Globals::FLD_NAME_CITY_LOCALE,Globals::FLD_NAME_CITY_PRIORITY);
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
                $locale = CityLocale::model()->findByAttributes(array('city_id'=>$model->city_id,'language_code'=>Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE)));
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $this->performAjaxValidation($locale);
//                echo '<pre>';
//                print_r($model);exit;
		if(isset($_POST[Globals::FLD_NAME_CITY_LOCALE]))
		{
                    $state_priority=$_POST[Globals::FLD_NAME_CITY_LOCALE][Globals::FLD_NAME_CITY_PRIORITY];
			//$model->attributes=$_POST[Globals::FLD_NAME_CITY_CAP];
                        $locale->attributes=$_POST[Globals::FLD_NAME_CITY_LOCALE];
			CommonUtility::resetMasterPriorities(Globals::FLD_NAME_CITY_LOCALE,$state_priority,$id,Globals::FLD_NAME_CITY_PRIORITY,'city_id','edit');
                        
			//$model->attributes=$_POST[Globals::FLD_NAME_CITY_CAP];
                        
                        if( $model->update() )
			{
                            
                            if($locale->update())
                            {
				Yii::app()->user->setFlash('success',Yii::t('blog','City has been updated successfully.'));
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
                    $hasforeign = User::model()->findByAttributes(array('city_id'=>$id));
                    if($hasforeign)
                    {
                        throw new Exception("Relation Restriction."); 
                    }
                    $deleteSttausLocal = CityLocale::model()->deleteAll('city_id=:id', array(':id' => $id));
                    $deleteSttaus=$this->loadModel($id)->delete();
                    if($deleteSttaus)
                    {
                            CommonUtility::setFlashMsg('flash-success','City has been deleted successfully');
                    }
		}
		catch(Exception $e)
		{
			 CommonUtility::setFlashMsg('flash-notice','This city has been assigned to any User (Relation Restriction).');
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
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_CITY_CAP);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if (isset($_GET[Globals::FLD_NAME_CITY_DATA_SESSION]))
		{
			Yii::app()->user->setState(Globals::FLD_NAME_CITY_DATA_SESSION,(int)$_GET[Globals::FLD_NAME_CITY_DATA_SESSION]);
			unset($_GET[Globals::FLD_NAME_CITY_DATA_SESSION]); // would interfere with pager and repetitive page size change
		}
		$model=new City('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[Globals::FLD_NAME_CITY_CAP]))
			$model->attributes=$_GET[Globals::FLD_NAME_CITY_CAP];
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
	 * @return City the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=City::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	}
        public function actionAutoCompleteName()
        {
           
           if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */
               
                $name = $_GET[Globals::FLD_NAME_Q]; 
                        // this was set with the "max" attribute of the CAutoComplete widget
              $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_CITY_LOCALE,'city_name',$limit,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));
              
           }
        }
        /*public function actionAjaxGetCity()
        {
            $criteria = new CDbCriteria();
            $criteria->condition = "citylocale.language_id =:language";
            $criteria->condition = "t.region_id ='".$_POST[Globals::FLD_NAME_REGION_ID]."'";
            $criteria->params = array(':language' => Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE) );
            $city = City::model()->with(Globals::FLD_NAME_CITY_LOCALE)->findAll($criteria,array('order' => Globals::FLD_NAME_CITY_PRIORITY));
            $data=CHtml::listData($city,'city_id','citylocale.city_name');
            //echo CHtml::tag('option',array('value'=>''),CHtml::encode('--Select City--'),true);
            foreach($data as $city_id=>$city_name)
            {
                echo CHtml::tag('option',array('value'=>$city_id),CHtml::encode($city_name),true);
            }
        }*/
	/**
	 * Performs the AJAX validation.
	 * @param City $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX] === Globals::DEFAULT_VAL_CITY_FORM)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
?>