<?php 
class SettingController extends BackEndController
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
				'actions'=>array('index','view','autocompletesettingkey','autocompletesettingvalue','UpdateSiteSettings'),
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
		$model=new Setting;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_SETTING]))
		{
			$model->attributes=$_POST[Globals::FLD_NAME_SETTING];
			if($model->save())
                        {
                            Yii::app()->user->setFlash('success',Yii::t('blog','Setting has been Added successfully.'));
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

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST[Globals::FLD_NAME_SETTING]))
		{
			$model->attributes=$_POST[Globals::FLD_NAME_SETTING];
			if($model->update())
                        {
                            Yii::app()->user->setFlash('success',Yii::t('blog','Setting has been updated successfully.'));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
//            echo Yii::app()->setting->setting_type;exit;
//                $setting_type = Yii::app()->user->setting_type;
//		$dataProvider = new CActiveDataProvider( // declare a new dataprovider
//                'Setting', // declare the type of Model you want to query and display
//                array( // here we build the SQL 'where' clause
//                    'criteria' => array( // this is just building a CDbCriteria object
//                    'condition' => 'setting_type=:setting_type', // look for content with the user_id we pass in
//                    'params' => array(':setting_type' => $setting_type), // pass in (bind) user's id to the query
//                    //'order'=>'date_modified DESC', // add your sort order if you want?
//                    //'with'=>'commentCount', // join in your commentCount table?
//                    )
//                )
//                );
       $dataProvider=new CActiveDataProvider('Setting');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            $model=new Setting('search');
		$model->unsetAttributes();  // clear any default values
                $siteSettingType = Setting::model()->siteSettingType(Globals::FLD_NAME_POSTER_SETTING_ALFABET);
                
		if(isset($_POST['submit']))
                {
                    foreach ($_POST['setting'] as $settingId => $settingValue) 
                    {
//                        echo $settingId;
//                        echo $settingValue;
//                        echo $_POST['Setting['.$model->setting_id.']'];
                        $model=$this->loadModel($settingId);
                        $model->setting_value = $_POST['setting'][$settingId];
                        if(!$model->isNewRecord)
                        {
                            if($model->update())
                            {
                                //$this->redirect(array('admin'));
                            }
                        } 
                    }
                }
                
		$this->render('admin',array(
			'model'=>$model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Setting the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Setting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Setting $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='setting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
