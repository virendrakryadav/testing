<?php

class FrontrolesController extends BackEndController
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
				'actions'=>array('index','view','autocompletelookup'),
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
		$model=new Roles;
                $allModel[Globals::FLD_NAME_MODEL]=$model;
               // $models = Yii::app()->metadata->getModels(); 
//                $models = Yii::app()->params['rolesModelsFront']; #Get Models from params
//                foreach ($models as $index => $newModel)
//                {
//                    if(is_array($newModel))
//                    {
//                        
//                        $newModelVar = new $index;
//                        $allModel[strtolower($index)]=$newModelVar;
//                        //print_r($newModel);
//                    }
//                    else 
//                    {
//                        $newModelVar = new $newModel;
//                        $allModel[strtolower($newModel)]=$newModelVar;
//                    }
//                   
//                    
//
//                }
              //  exit;
		// Uncomment the following line if AJAX validation is needed
                $this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_ROLES]))
		{
			$role_name= $_POST[Globals::FLD_NAME_ROLES][Globals::FLD_NAME_ROLE_NAME];
			$model->setScenario(Globals::INSERT_NOTO);
			$model->attributes=$_POST[Globals::FLD_NAME_ROLES];
                       
			foreach( $_POST as $key => $value ) 
			{
				if( is_array( $value ) ) 
				{
					foreach( $value as $innerKey => $innerValue ) 
					{
                                            if(is_array($innerValue))
                                            {
                                                foreach( $innerValue as $innerActionKey => $innerActionValue ) 
                                                {
                                                    if( empty( $innerActionValue ) ) 
                                                    unset( $_POST[ $key ][ $innerKey ][ $innerActionKey ] );
                                                }
                                            }
						if( empty( $innerValue ) ) 
                                                unset( $_POST[ $key ][ $innerKey ] );
					}
				}
				if( empty( $_POST[ $key ] ) )
					unset( $_POST[ $key ] );
			}
			unset( $_POST[Globals::FLD_NAME_ROLES] );
			unset( $_POST[Globals::FLD_NAME_YT_0] );
			if(isset($_POST['back']))
			$serializeRolesBack = CJSON::encode($_POST['back']);
                        else
                        $serializeRolesBack = '';
                        
                        if(isset($_POST['front']))
                        $serializeRolesFront = CJSON::encode($_POST['front']);
                        else
                        $serializeRolesFront ='';
                            
                        

                        $model->{Globals::FLD_NAME_ROLE_NAME}= $role_name;
                    
                        $model->{Globals::FLD_NAME_ROLE_PERMISSION} = $serializeRolesBack;
                        $model->{Globals::FLD_NAME_ROLE_PERMISSION_FRONT} = $serializeRolesFront;
			if ($model->validate()) 
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success','Admin role has been added successfully.');
	
					$this->redirect(array('admin'));
				}
			}
		}
		$this->render('create',$allModel);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$allModel[Globals::FLD_NAME_MODEL]=$model;
		$models=Yii::app()->params[Globals::FLD_NAME_ROLES_MODELS]; #get modules 
//		foreach ($models as $index => $newModel)
//		{
//                     if(is_array($newModel))
//                    {
//                        
//                        $newModelVar = new $index;
//                        $allModel[strtolower($index)]=$newModelVar;
//                        //print_r($newModel);
//                    }
//                    else 
//                    {
//                        $newModelVar = new $newModel;
//                        $allModel[strtolower($newModel)]=$newModelVar;
//                    }
//
//		}
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_ROLES]))
		{
			$role_name= $_POST[Globals::FLD_NAME_ROLES][Globals::FLD_NAME_ROLE_NAME];
			
                        
                        
                        ////
                        
                        foreach( $_POST as $key => $value ) 
			{
				if( is_array( $value ) ) 
				{
					foreach( $value as $innerKey => $innerValue ) 
					{
                                            if(is_array($innerValue))
                                            {
                                                foreach( $innerValue as $innerActionKey => $innerActionValue ) 
                                                {
                                                    if( empty( $innerActionValue ) ) 
                                                    unset( $_POST[ $key ][ $innerKey ][ $innerActionKey ] );
                                                }
                                            }
						if( empty( $innerValue ) ) 
                                                unset( $_POST[ $key ][ $innerKey ] );
					}
				}
				if( empty( $_POST[ $key ] ) )
					unset( $_POST[ $key ] );
			}
			unset( $_POST[Globals::FLD_NAME_ROLES] );
			unset( $_POST[Globals::FLD_NAME_YT_0] );
                       if(isset($_POST['back']))
			$serializeRolesBack = CJSON::encode($_POST['back']);
                        else
                        $serializeRolesBack = '';
                        
                        if(isset($_POST['front']))
                        $serializeRolesFront = CJSON::encode($_POST['front']);
                        else
                        $serializeRolesFront ='';
                        

                        $model->{Globals::FLD_NAME_ROLE_NAME}= $role_name;
                    
                        $model->{Globals::FLD_NAME_ROLE_PERMISSION} = $serializeRolesBack;
                        $model->{Globals::FLD_NAME_ROLE_PERMISSION_FRONT} = $serializeRolesFront;
                        
                        
                        ////
		

			if($model->save())
			{
				Yii::app()->user->setFlash('success','Admin role has been updated successfully.');
				$this->redirect(array('admin'));
			}
		}
		$this->render('update',$allModel);
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
		   $deleteSttaus=$this->loadModel($id)->delete();
			if($deleteSttaus)
			{
				CommonUtility::setFlashMsg('flash-success','Admin role has been deleted successfully.');
			}
		}
		catch(CDbException $e)
		{
			CommonUtility::setFlashMsg('flash-notice','This role has been assigned to any Admin User (Relation Restriction).');
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
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_ROLES);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Roles('search');
		$model->unsetAttributes();  // clear any default values
                if (isset($_GET[Globals::FLD_NAME_ROLES_DATE_SESSION]))
		{
			Yii::app()->user->setState(Globals::FLD_NAME_ROLES_DATE_SESSION,(int)$_GET[Globals::FLD_NAME_ROLES_DATE_SESSION]);
			unset($_GET[Globals::FLD_NAME_ROLES_DATE_SESSION]); // would interfere with pager and repetitive page size change
		}
		if(isset($_GET[Globals::FLD_NAME_ROLES]))
			$model->attributes=$_GET[Globals::FLD_NAME_ROLES];

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
	 * @return Roles the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Roles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	}
    public function actionAutoCompleteLookup()
    {
        
       if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
       {
            /* q is the default GET variable name that is used by
            / the autocomplete widget to pass in user input
            */
          $name = $_GET[Globals::FLD_NAME_Q]; 
          $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
          CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_ROLES,Globals::FLD_NAME_ROLE_NAME,$limit);
              
       }
    }
	/**
	 * Performs the AJAX validation.
	 * @param Roles $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX]=== Globals::DEFAULT_VAL_ROLES_FORM)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
