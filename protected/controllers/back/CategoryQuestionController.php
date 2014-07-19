<?php

class CategoryQuestionController extends BackEndController
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
	$model= new CategoryQuestion;
        $locale = new CategoryQuestionLocale;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($locale);
		if(isset($_POST[Globals::FLD_NAME_CATEGORY_QUESTION_CAP]))
		{
                        $locale->attributes=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION_CAP];

                        $model->question_type=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION]['question_type'];
                        $model->question_for=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION]['question_for'];
                        $model->is_answer_must=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION]['is_answer_must'];
                        if($_POST[Globals::FLD_NAME_CATEGORY_QUESTION]['question_type'] != 'l')
                        {
                            $locale->expected_answer_desc=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION_CAP]['expected_answer_desc'];
                        }
                        else
                        {
                            $locale->expected_answer_logical=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION_CAP]['expected_answer_logical'];
                        }
                        if($locale->validate())
                        {
                            if($model->save())
                            {
                                $insertedId=$model->getPrimaryKey();
                                $locale->question_id = $insertedId;
                                $locale->{Globals::FLD_NAME_LANGUAGE_CODE} = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
                                if($locale->save())
                                {
                                    $this->redirect(array('admin'));
                                }
                            }
                        }
		}

		$this->render('create',array(
			'model'=>$model,
			'locale'=>$locale
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
                
                $locale = CategoryQuestionLocale::model()->findByAttributes(array('question_id'=>$model->question_id,'language_code'=>Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE)));
		$this->performAjaxValidation($locale);
		if(isset($_POST[Globals::FLD_NAME_CATEGORY_QUESTION_CAP]))
		{                    
                    $locale->attributes=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION_CAP];
                    $model->attributes=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION];

                    $model->question_type=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION]['question_type'];
                    $model->question_for=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION]['question_for'];
                    $model->is_answer_must=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION]['is_answer_must'];
                    if($_POST[Globals::FLD_NAME_CATEGORY_QUESTION]['question_type'] != 'l')
                    {
                        $locale->expected_answer_desc=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION_CAP]['expected_answer_desc'];
                    }
                    else
                    {
                        $locale->expected_answer_logical=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION_CAP]['expected_answer_logical'];
                    }
                         if( $model->update() )
			{                                                        
                            $locale->status=$_POST[Globals::FLD_NAME_CATEGORY_QUESTION_CAP]['status'];
                             if($locale->update())
                            {
				Yii::app()->user->setFlash('success',Yii::t('blog','Question has been updated successfully.'));
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
                    $relationTable = array('TaskQuestion');
                    $forginkey = 'question_id';
                    $forginkeyVal = $id;
                    $result =  CommonUtility::chackRelationForDeleteAction($relationTable,$forginkey,$forginkeyVal);
                    if($result['hasforeign'])
                    {
                        throw new Exception("Relation Restriction.");
                    }
                    $deleteSttausLocal = CategoryQuestionLocale::model()->deleteAll('question_id=:question_id', array(':question_id' => $id));
                    $deleteSttaus=$this->loadModel($id)->delete();
                    if($deleteSttaus)
                    {
                            CommonUtility::setFlashMsg('flash-success','Question has been deleted successfully');
                    }
		}
		catch(Exception $e)
		{
			 CommonUtility::setFlashMsg('flash-notice','This Question has been assigned to any '.$result['relationname'].' (Relation Restriction).');
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
		$dataProvider=new CActiveDataProvider(Globals::FLD_NAME_CATEGORY_QUESTION_CAP);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            if (isset($_GET[Globals::FLD_NAME_CATEGORY_QUESTION_DATA_SESSION]))
            {
                Yii::app()->user->setState(Globals::FLD_NAME_CATEGORY_QUESTION_DATA_SESSION,(int)$_GET[Globals::FLD_NAME_CATEGORY_QUESTION_DATA_SESSION]);
                unset($_GET[Globals::FLD_NAME_CATEGORY_QUESTION_DATA_SESSION]); // would interfere with pager and repetitive page size change
            }
            $model=new CategoryQuestion('search');
//            echo"<pre>";
//            print_r($model);
//            exit ();
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Categoryquestion']))
                    $model->attributes=$_GET['Categoryquestion'];
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
	 * @return CategoryQuestion the loaded model
	 * @throws CHttpException
	 */


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
              CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_CATEGORY_QUESTION_CAP,'question_desc',$limit,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));

           }
        }
        
	public function loadModel($id)
	{
		$model=CategoryQuestion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CategoryQuestion $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-question-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
