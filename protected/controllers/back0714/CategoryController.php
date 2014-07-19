<?php

class CategoryController extends BackEndController
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
				'actions'=>array('index','view','autocompletename', 'getcategorytemplatefield'),
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
            $model=new Category;
            $locale = new CategoryLocale;
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($locale);

            if(isset($_POST['CategoryLocale']))
            {        
//               
//                print_r($template);
//                echo json_encode($template);
//                exit;
                //[{"title":"Restaurant Delivery","desc":"Provide th"}];
                $category_priority=$_POST['CategoryLocale']['category_priority'];
                    
                    //$model->attributes=$_POST['Category'];
                    $locale->attributes=$_POST['CategoryLocale'];
                    $locale->category_name = ucwords(strtolower($_POST['CategoryLocale']['category_name']));
                    
                    $template = array();
                    for($catTmpl = 1; $catTmpl <= $_POST[Globals::FLD_NAME_CATEGORY_TEMPLATE_TOTAL]; $catTmpl++)
                    {
                        $templatenew = array();
                        if(isset($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE]))
                        {
                            $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE] = trim($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE]);
                            $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION] = trim($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION]);

                            if(!empty($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE]) 
                            || !empty($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION]))
                            {
                                echo $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE];
                                echo $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION];

                                $templatenew['title'] = $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE];
                                $templatenew['desc'] = $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION];
                            }
                            if(!empty($templatenew)){
                                $template[] = $templatenew;
                            }
                        }
                    }

                    if(!empty($template)){
                        $locale->task_templates = json_encode($template);
                    }else{
                        $locale->task_templates = '';
                    }
                    
                    
//                    if(!empty($_POST['CategoryLocale']['title']) || !empty($_POST['CategoryLocale']['description']))
//                        {
//                            $template = array();
//                            $templatenew['title']=$_POST['CategoryLocale']['title'];
//                            $templatenew['desc']=$_POST['CategoryLocale']['description'];
//                            $template[] = $templatenew;
//                            $locale->task_templates = json_encode($template);
//                        }
                    $model->parent_id = $_POST['CategoryLocale']['parent_id'];

                    $model->is_virtual = $_POST[Globals::FLD_NAME_CATEGORY]['is_virtual'];
                    $model->is_inperson = $_POST[Globals::FLD_NAME_CATEGORY]['is_inperson'];
                    $model->is_instant = $_POST[Globals::FLD_NAME_CATEGORY]['is_instant'];
                    
                    $model->default_min_price = $_POST[Globals::FLD_NAME_CATEGORY]['default_min_price'];
                    $model->default_max_price = $_POST[Globals::FLD_NAME_CATEGORY]['default_max_price'];
                    $model->default_estimated_hours = $_POST[Globals::FLD_NAME_CATEGORY]['default_estimated_hours'];

                    if(!empty($_POST['imageNameHidden']))
                        {
                            $locale->category_image = $_POST['imageNameHidden'];

                            $image = $_POST['imageNameHidden'];
                               CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.'category/'.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
                            $fileWithFolder = 'category/'.$image;
                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
                            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                        }
                    if($locale->validate())
                    {
                        if($model->save())
                        {
                            GetRequest::manageSubCategoryCountForParentCategory();
                           //clear cache
                            
                            CacheManagement::deleteCategoryCache();
                            
                            $locale->category_id = $model->primaryKey;
                            $locale->{Globals::FLD_NAME_LANGUAGE_CODE} = Yii::app()->user->getState('language');
                            if($locale->save())
                            {
                                $insertedId=$model->getPrimaryKey();
                                CommonUtility::resetMasterPriorities('CategoryLocale',$category_priority,$insertedId,'category_priority','category_id',Yii::app()->user->getState('language'));

                                Yii::app()->user->setFlash('success',Yii::t('blog','Category has been added successfully.'));
                                $this->redirect(array('admin'));
                            }

                        }
                    }
            }
            $this->maxPriority=CommonUtility::selectNextPriority('CategoryLocale','category_priority');
            $this->render('create',array(
                    'model'=>$model,
                'locale'=>$locale,
            ));
	}




	public function actionAjaxupdate()
	{
	    $act = $_GET['act'];
		$autoIdAll = $_POST['autoId'];
		if(count($autoIdAll)>0)
		{
			foreach($autoIdAll as $autoId)
			{
				$model=$this->loadModel($autoId);
				if($act=='doDelete')
				{
					$model->delete();
				}
				if($act=='doActive')
				{
					$model->category_status = '1';
				}
				if($act=='doInactive')
				{
					$model->category_status = '0';         
				}         
				if($model->save()){
				   //clear cache
               CacheManagement::deleteCategoryCache();
				}
			}
			if($act=='doDelete')
			{
				CommonUtility::setFlashMsg('flash-success','Record(s) has been deleted successfully');
			}
			if($act=='doActive')
			{
				CommonUtility::setFlashMsg('flash-success','Record(s) has been activated successfully');
			}
			if($act=='doInactive')
			{
				CommonUtility::setFlashMsg('flash-success','Record(s) has been in-activated successfully');
			}    
		}
		else
		{
			CommonUtility::setFlashMsg('flash-notice','Please select atleast one record');
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
         public function actionUpdateImage()
        {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            //$folder=Yii::app()->request->baseUrl . "/media/category";// folder for uploaded files
            $folder = Globals::FRONT_USER_PORTFOLIO_TEMP_PATH;
            $allowedExtensions = Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES];//array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit = Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE];// maximum file size in bytes
//            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
//            $result = $uploader->handleUpload($folder);
            $fileNameSlugBefore = Yii::app()->user->id."_".time();
            $fileNameSlugAfter = Globals::FRONT_USER_USER_IMAGE_NAME_SLUG;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder,false,$fileNameSlugBefore,$fileNameSlugAfter);

//            $fileSize=filesize($folder.$result[Globals::FLD_NAME_FILENAME]);//GETTING FILE SIZE
//            $baseUrl = Globals::BASH_URL;
            $fileName=$result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME
            
//            $fileNamePath=$baseUrl.'/'.$folder.$result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME
            //$result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $fileName;// it's array
            //exit ();
        }
	public function actionUpdate($id)
	{				                               
                $model=$this->loadModel($id);
                $locale = CategoryLocale::model()->findByAttributes(array('category_id'=>$model->category_id,'language_code'=>Yii::app()->user->getState('language')));                
		// comment the following line if AJAX validation is not needed
		$this->performAjaxValidation($locale);
                
		if(isset($_POST['CategoryLocale']))
		{	
                    
                   
                
                    $template = array();
                    for($catTmpl = 1; $catTmpl <= $_POST[Globals::FLD_NAME_CATEGORY_TEMPLATE_TOTAL]; $catTmpl++)
                    {
                      $templatenew = array();
                      if(isset($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE]))
                      {
                         $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE] = trim($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE]);
                         $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION] = trim($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION]);

                         if(!empty($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE]) 
                         || !empty($_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION]))
                         {
                             echo $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE];
                             echo $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION];

                             $templatenew['title'] = $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_TITLE];
                             $templatenew['desc'] = $_POST[Globals::FLD_NAME_CATEGORY_LOCALE][Globals::FLD_NAME_CATEGORY_ID.'_'.$catTmpl][Globals::FLD_NAME_DESCRIPTION];
                         }
                         if(!empty($templatenew)){
                             $template[] = $templatenew;
                         }
                      }
                    }
       
       if(!empty($template)){
         $locale->task_templates = json_encode($template);
       }else{
         $locale->task_templates = '';
       }

        $category_priority=$_POST['CategoryLocale']['category_priority'];
//			$model->attributes=$_POST['Category'];
         $locale->attributes=$_POST['CategoryLocale'];
		 $locale->category_name = ucwords(strtolower($_POST['CategoryLocale']['category_name']));
         $model->attributes =$_POST['CategoryLocale'];
         $model->parent_id = $_POST['CategoryLocale']['parent_id'];
         $model->is_virtual = $_POST[Globals::FLD_NAME_CATEGORY]['is_virtual'];
         $model->is_inperson = $_POST[Globals::FLD_NAME_CATEGORY]['is_inperson'];
         $model->is_instant = $_POST[Globals::FLD_NAME_CATEGORY]['is_instant'];
         
         $model->default_min_price = $_POST[Globals::FLD_NAME_CATEGORY]['default_min_price'];
         $model->default_max_price = $_POST[Globals::FLD_NAME_CATEGORY]['default_max_price'];
         $model->default_estimated_hours = $_POST[Globals::FLD_NAME_CATEGORY]['default_estimated_hours'];
         
         if(!empty($_POST['imageNameHidden']))
         {                            
             $oldImage= $locale->category_image;
             if(!empty($oldImage))
              {
                  CommonUtility::unlinkImages(Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH,'category',$oldImage);
              }
             $locale->category_image = $_POST['imageNameHidden'];
             $image = $_POST['imageNameHidden'];
                CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.'category/'.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
             $fileWithFolder = 'category/'.$image;
             CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
             CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
         }
			CommonUtility::resetMasterPriorities('CategoryLocale',$category_priority,$id,'category_priority','category_id',Yii::app()->user->getState('language'),'edit');                    
                        
         if( $model->update() )
        {
              GetRequest::manageSubCategoryCountForParentCategory();
            //clear cache
             CacheManagement::deleteCategoryCache();
             if($locale->update())
             {   
                 Yii::app()->user->setFlash('success',Yii::t('blog','Category has been updated successfully.'));
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
           $relationTable = array('CategoryQuestionLocale','TaskCategory','Skill');
           $forginkey = 'category_id';
           $forginkeyVal = $id;
           $result =  CommonUtility::chackRelationForDeleteAction($relationTable,$forginkey,$forginkeyVal);                    
           if($result['hasforeign'])
           {
               throw new Exception("Relation Restriction."); 
           }
               $deleteSttausLocal = CategoryLocale::model()->deleteAll('category_id=:id', array(':id' => $id));
               $deleteSttaus=$this->loadModel($id)->delete();                    
           if($deleteSttaus)
           {
               GetRequest::manageSubCategoryCountForParentCategory();
               //clear cache
               CacheManagement::deleteCategoryCache();
                           
               CommonUtility::setFlashMsg('flash-success','Category has been deleted successfully');
           }
		}
		catch(Exception $e)
		{
         CommonUtility::setFlashMsg('flash-notice','This category has been assigned to any '.$result['relationname'].' (Relation Restriction).');

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
		$dataProvider=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
            
//                $model=new CategoryLocale('search');
//                $dataProvider=new CActiveDataProvider('Category');
//
//                $criteria = new CDbCriteria();
//
//                $model->unsetAttributes();  // clear any default values
//                if(isset($_GET['Category']))
//                {
//
//                       foreach($_GET['Category'] as $key=>$value) {
//                            $criteria -> compare($key, $value, true, 'AND');
//                       }
//                       $dataProvider = new CActiveDataProvider('Category', array('criteria' => $criteria));
//                }
 
        
		if (isset($_GET['categoryDataSession']))
		{
			Yii::app()->user->setState('categoryDataSession',(int)$_GET['categoryDataSession']);
			unset($_GET['categoryDataSession']); // would interfere with pager and repetitive page size change
		}
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$currentRequest = Yii::app()->user->getState('pageUrl'); 
		$fillFields = "";
		if(isset($currentRequest))
		{
				$fillFields = CommonUtility::createArray($currentRequest); 
		}
        
		$this->render('admin',array(
			'model'=>$model,
                        'fillFields'=>$fillFields,
                 //   'dataProvider'=>$dataProvider,
		));
	}
   
   
   
   public function actionGetCategoryTemplatefield()
    {
       $model=$this->loadModel(Yii::app()->user->id);
        $nextnum =  $_POST[Globals::FLD_NAME_NUM];
        $nextnum++;
        UtilityHtml::userGetTemplateField($model,$nextnum,Globals::DEFAULT_VAL_NULL);
//         $model=$this->loadModel($_POST[Globals::FLD_NAME_CATEGORY_ID]);
//         $locale = CategoryLocale::model()->findByAttributes(array('category_id'=>$model->category_id,'language_code'=>Yii::app()->user->getState('language')));
//         $nextnum =  $_POST[Globals::FLD_NAME_NUM];
//         $nextnum++;
//         $this->renderPartial('_categorytemplate',array('count'=>$nextnum, 'model'=>$model, 'locale'=>$locale),false,true);
    }
   

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        public function actionAutoCompleteName()
        {
           
           if(Yii::app()->request->isAjaxRequest && isset($_GET['q']))
           {
                $name = $_GET['q']; 
                $limit = $_GET['limit']; 
                CommonUtility::getAutoCompleteData($name,'CategoryLocale','category_name',$limit,Yii::app()->user->getState('language'));
           }
        }
	/**
	 * Performs the AJAX validation.
	 * @param Category $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
   
  
}
