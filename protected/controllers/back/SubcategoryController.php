<?php

class SubcategoryController extends BackEndController
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
				'actions'=>array('index','view','autocompletename'),
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
		$model=new Subcategory;
		$locale = new SubcategoryLocale;
		//CommonUtility::selectNextPriority(Globals::FLD_NAME_SUB_CATEGORY,Globals::FLD_NAME_SUB_CATEGORY_PRIORITY);
		//exit;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($locale);

		if(isset($_POST[Globals::FLD_NAME_SUB_CATEGORY]))
		{
			$subcategory_priority=$_POST[Globals::FLD_NAME_SUB_CATEGORY][Globals::FLD_NAME_SUB_CATEGORY_PRIORITY];
		
			$model->attributes=$_POST[Globals::FLD_NAME_SUB_CATEGORY];
                        $locale->attributes=$_POST[Globals::FLD_NAME_SUB_CATEGORY_LOCALE];
			
			if($model->save())
			{
				$locale->subcategory_id = $model->primaryKey; 
				$locale->language_id = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
				if($locale->save())
				{
					$insertedId=$model->getPrimaryKey();
					CommonUtility::resetMasterPriorities(Globals::FLD_NAME_SUB_CATEGORY,$subcategory_priority,$insertedId,Globals::FLD_NAME_SUB_CATEGORY_PRIORITY,Globals::FLD_NAME_SUB_CATEGORY_ID);
					Yii::app()->user->setFlash('success',Yii::t('blog','Subcategory has been added successfully.'));
					$this->redirect(array('admin'));
				}
			}
		}
		$this->maxPriority=CommonUtility::selectNextPriority(Globals::FLD_NAME_SUB_CATEGORY,Globals::FLD_NAME_SUB_CATEGORY_PRIORITY);
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
				if($act== Globals::DEFAULT_VAL_DO_DELETE)
				{
					$model->delete();
				}
				if($act== Globals::DEFAULT_VAL_DO_ACTION)
				{
					$model->subcategory_status = Globals::DEFAULT_VAL_1;
				}
				if($act== Globals::DEFAULT_VAL_DO_IN_ACTION)
				{
					$model->subcategory_status = Globals::DEFAULT_VAL_0;         
				}         
				$model->save();
			}
			if($act== Globals::DEFAULT_VAL_DO_DELETE)
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
                $locale = SubCategoryLocale::model()->findByAttributes(array(Globals::FLD_NAME_SUB_CATEGORY_ID=>$model->subcategory_id,Globals::FLD_NAME_LANGUAGE_ID=>Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE)));

		// comment the following line if AJAX validation is not needed
		$this->performAjaxValidation($locale);

		if(isset($_POST[Globals::FLD_NAME_SUB_CATEGORY]))
		{
			$subcategory_priority=$_POST[Globals::FLD_NAME_SUB_CATEGORY][Globals::FLD_NAME_SUB_CATEGORY_PRIORITY];
			$model->attributes=$_POST[Globals::FLD_NAME_SUB_CATEGORY];
                         $locale->attributes=$_POST[Globals::FLD_NAME_SUB_CATEGORY_LOCALE];
			CommonUtility::resetMasterPriorities(Globals::FLD_NAME_SUB_CATEGORY,$subcategory_priority,$id,Globals::FLD_NAME_SUB_CATEGORY_PRIORITY,Globals::FLD_NAME_SUB_CATEGORY_ID,'edit');
                        if ($model->validate() && $locale->validate()) 
			{
                            if($model->update())
                            {
                                if($locale->update())
                                {
                                    Yii::app()->user->setFlash('success',Yii::t('blog','Subcategory has been updated successfully.'));
                                    $this->redirect(array('admin'));
                                }
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
                $deleteSttausLocal = SubcategoryLocale::model()->deleteAll('subcategory_id=:id', array(':id' => $id));
		$deleteSttaus=$this->loadModel($id)->delete();
		if($deleteSttaus)
		{
			CommonUtility::setFlashMsg('flash-success','Subcategory has been deleted successfully.');
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
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_SUB_CATEGORY);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if (isset($_GET['subcategoryDataSession']))
		{
			Yii::app()->user->setState('subcategoryDataSession',(int)$_GET['subcategoryDataSession']);
			unset($_GET['subcategoryDataSession']); // would interfere with pager and repetitive page size change
		}
		
		$model=new Subcategory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[Globals::FLD_NAME_SUB_CATEGORY]))
			$model->attributes=$_GET[Globals::FLD_NAME_SUB_CATEGORY];

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


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Subcategory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Subcategory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        public function actionAutoCompleteName()
        {
           
           if(Yii::app()->request->isAjaxRequest && isset($_GET['q']))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */
               $name = $_GET['q']; 
                        // this was set with the "max" attribute of the CAutoComplete widget
              $limit = $_GET['limit']; 
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_SUB_CATEGORY_LOCALE,'subcategory_name',$limit,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));
              
           }
        }
	/**
	 * Performs the AJAX validation.
	 * @param Subcategory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='subcategory-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
