<?php

class SkillController extends BackEndController
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
				'actions'=>array('index','view','autocompletename','addskill'),
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
    public function actionAdmin()
	{
        if (isset($_GET[Globals::FLD_NAME_SKILL_DATA_SESSION]))
            {
                Yii::app()->user->setState(Globals::FLD_NAME_SKILL_DATA_SESSION,(int)$_GET[Globals::FLD_NAME_SKILL_DATA_SESSION]);
                unset($_GET[Globals::FLD_NAME_SKILL_DATA_SESSION]); // would interfere with pager and repetitive page size change
            }
            $model=new Skill('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET[Globals::FLD_NAME_SKILL]))
                    $model->attributes=$_GET[Globals::FLD_NAME_SKILL];
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

        public function actionAddskill()
        {
          $skillvalue = $_POST['skillvalue'];
          
          $skills = SkillLocale::model()->findByAttributes(array('skill_desc'=>$skillvalue));
          $getskillcount = count($skills);
          if($getskillcount > 0)
          {
             echo CJSON::encode(array(
                    'status'=>'error'
                ));
             Yii::app()->end();  
          }
          else 
          {
             $local = new SkillLocale(); 
             $model = new Skillid(); 
             
             $language = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
             if($model->save())
             {
                $insertedId = $model->getPrimaryKey();
                $local->skill_id = $insertedId;
                $local->language_code = $language;
                $local->skill_desc = $skillvalue;
                if($local->save())
                {
                    echo CJSON::encode(array(
                    'status'=>'success'
                    ));
                    Yii::app()->end(); 
                }  
                else
                {
                    echo CJSON::encode(array(
                        'status'=>'error'
                    ));
                    Yii::app()->end(); 
                }
             }
             else
             {
                 echo CJSON::encode(array(
                    'status'=>'error'
                ));
                Yii::app()->end(); 
             }
          }
        }
        public function actionCreate()
	{
            $model= new Skill;
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);                 
            if(isset($_POST[Globals::FLD_NAME_SKILL]))
            {                                   
                $model->attributes=$_POST[Globals::FLD_NAME_SKILL];
                $model->category_id=$_POST[Globals::FLD_NAME_SKILL]['category_id'];
                
                    if($model->save())
                        {
                            //clear cache
                            CacheManagement::deleteSkillCache();
                            Yii::app()->user->setFlash('success',Yii::t('blog','Skill and Category has been Relat successfully.'));
                            $this->redirect(array('admin'));                            
                        }
                }           
            $this->render('create',array(
                    'model'=>$model
            ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
//	public function actionUpdate($id)
//	{            
//            $model=$this->loadModel($id);                
//            $locale = SkillLocale::model()->findByAttributes(array('skill_id'=>$model->skill_id,'language_code'=>Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE)));
//            $this->performAjaxValidation($locale);
//            if(isset($_POST[Globals::FLD_NAME_SKILL_LOCALE]))
//            {
//                    $model->attributes=$_POST[Globals::FLD_NAME_SKILL_LOCALE];
//
//                    $locale->attributes=$_POST[Globals::FLD_NAME_SKILL_LOCALE];
//                    $model->attributes=$_POST[Globals::FLD_NAME_SKILL];
//                    $model->category_id=$_POST[Globals::FLD_NAME_SKILL]['category_id'];
//                    if($locale->validate())
//                    {
//                            if( $model->update() )
//                        {
//                                //clear cache
//                                CacheManagement::deleteSkillCache();
//
//                                if($locale->update())
//                            {
//                                Yii::app()->user->setFlash('success',Yii::t('blog','Skill has been updated successfully.'));
//                                $this->redirect(array('admin'));
//                            }
//                        }
//                    }
//            }
//
//            $this->render('update',array(
//                    'model'=>$model,
//                    'locale'=>$locale,
//            ));
//	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{       
            $skill_id = $_POST['skill_id'];
            $category_id = $_POST['category_id'];
               try
		{
//                    $deleteSttausLocal = Skill::model()->deleteAllByAttributes('skill_id=:skill_id', array(':skill_id' => $id));
//                    $deleteSttaus=$this->loadModel($id)->delete();
                    $deleteSttaus = Skill::model()->deleteAllByAttributes(array('skill_id'=>$skill_id,'category_id'=>$category_id));
                    if($deleteSttaus)
                    {
                        //clear cache
                        CacheManagement::deleteSkillCache();
            
                        CommonUtility::setFlashMsg('flash-success','Skill has been deleted successfully');
                    }
		}
		catch(Exception $e)
		{
			 CommonUtility::setFlashMsg('flash-notice','This Skill has been assigned to any (Relation Restriction).');
		}
//		if(!isset($_GET[Globals::FLD_NAME_AJAX]))
//			$this->redirect(isset($_POST[Globals::FLD_NAME_RETURN_URL]) ? $_POST[Globals::FLD_NAME_RETURN_URL] : array('admin'));
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
                CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_SKILL_LOCALE,'skill_desc',$limit,Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));

           }
        }

	public function loadModel($id)
	{
		$model=Skill::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='skill-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}