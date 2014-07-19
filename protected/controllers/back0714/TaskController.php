<?php

class TaskController extends BackEndController
{
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
    public function accessRules()
	{
		$perform = $this->Permissions();
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','autocompletename','admin','autocompletepostername','autocompletelocation'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>$perform,
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','view'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        public function actionAdmin()
	{        
        if (isset($_GET[Globals::FLD_NAME_TASK_DATA_SESSION]))
            {
                Yii::app()->user->setState(Globals::FLD_NAME_TASK_DATA_SESSION,(int)$_GET[Globals::FLD_NAME_TASK_DATA_SESSION]);
                unset($_GET[Globals::FLD_NAME_TASK_DATA_SESSION]); // would interfere with pager and repetitive page size change
            }
            $model=new Task('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET[Globals::FLD_NAME_TASK]))
                    $model->attributes=$_GET[Globals::FLD_NAME_TASK];
            $currentRequest = Yii::app()->user->getState(Globals::FLD_NAME_PAGE_URL);
            $fillFields = Globals::DEFAULT_VAL_NULL;;
            if(isset($currentRequest))
            {
                $fillFields = CommonUtility::createArray($currentRequest);
            }
            $this->render('admin',array(
                    'model'=>$model,
                    'fillFields'=>$fillFields,
            ));
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
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_TASK,'title',$limit,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));

           }
        }
        
        public function actionAutocompletepostername()
        {

           if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */

                $name = $_GET[Globals::FLD_NAME_Q];
                        // this was set with the "max" attribute of the CAutoComplete widget
              $limit = $_GET[Globals::FLD_NAME_LIMIT];
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_USER,'firstname',$limit);

           }
        }
        
        public function actionAutocompletelocation()
        {

           if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */

                $name = $_GET[Globals::FLD_NAME_Q];
                        // this was set with the "max" attribute of the CAutoComplete widget
              $limit = $_GET[Globals::FLD_NAME_LIMIT];
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_TASK_LOCATION,'location_geo_area',$limit);

           }
        }
        
        public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
        public function loadModel($id)
	{
		$model=Task::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	}
}