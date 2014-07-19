<?php

class AdminController extends BackEndController
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
                    'actions'=>array('index','view','changepassword','changestatus','updateaccount','autocompleteemail','autocompletelogin_name','userlist'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		$contact = new UserContact;
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
		
		//EPassValidator::getLevel();
		//print_r($_POST);exit;
		if(isset($_POST[Globals::FLD_NAME_USER]))
		{
			$model->attributes=$_POST[Globals::FLD_NAME_USER];
			$model->{Globals::FLD_NAME_USER_TYPE} = Globals::DEFAULT_VAL_USER_TYPE_ADMIN;
			$contact->{Globals::FLD_NAME_CONTACT_ID} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL];
			$contact->{Globals::FLD_NAME_CONTACT_TYPE} = Globals::DEFAULT_VAL_E_CAP;
			$contact->{Globals::FLD_NAME_IS_PRIMARY} = Globals::DEFAULT_VAL_1;
			$contact->{Globals::FLD_NAME_IS_LOGIN_ALLOWED} = Globals::DEFAULT_VAL_1;
			$contact->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
			$dataEmail[Globals::FLD_NAME_E] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL];
			$dataEmail[Globals::FLD_NAME_TYPE] = Globals::DEFAULT_VAL_P;
			$data[Globals::FLD_NAME_EMAILS][] = $dataEmail;
			
			if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_PHONE])
			{
				$dataPhone[Globals::FLD_NAME_P] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_PHONE];
				$dataPhone[Globals::FLD_NAME_TYPE] = Globals::DEFAULT_VAL_P;
				$data[Globals::FLD_NAME_PHS][] = $dataPhone;
			}
			
			$data = json_encode( $data );
			$model->{Globals::FLD_NAME_CONTACT_INFO} = $data;
			$model->{Globals::FLD_NAME_LOGIN_NAME} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_LOGIN_NAME];
			$model->{Globals::FLD_NAME_GENDER} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GENDER];
			$model->{Globals::FLD_NAME_IS_ADMIN} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_IS_ADMIN];
			$model->{Globals::FLD_NAME_STATUS} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_STATUS];
                        if(@$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_USER_ROLE_ID])
                        {
                            $roleIds = implode(',', $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_USER_ROLE_ID]);
                            $model->{Globals::FLD_NAME_USER_ROLE_ID} = $roleIds;
                        }
                            
                          
//                            if(@$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_USER_FRONT_ROLE_ID])
//                            $model->{Globals::FLD_NAME_USER_FRONT_ROLE_ID} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_USER_FRONT_ROLE_ID];
                            
                            
			$model->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
			if($model->{Globals::FLD_NAME_IS_ADMIN} == Globals::DEFAULT_VAL_0)
			$model->scenario = Globals::HAS_ROLE_INSERT;
			//print_r($model->attributes);exit;
			if($model->save())
			{
				$contact->{Globals::FLD_NAME_USER_ID}  = $model->primaryKey;
                                // Start for Update user search field
                                CommonUtility::updateUserSearchField($model->primaryKey);
                                // End for Update user search field
				$contact->save();
				Yii::app()->user->setFlash('success',Yii::t('admin_admin','admin_user_added_text'));
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
		$model->scenario = 'update';
		$criteria = new CDbCriteria;
		$criteria->condition = 'contact_id = "'.CommonUtility::getUserPhoneNumber($model->{Globals::FLD_NAME_USER_ID}).'" OR contact_id = "'.CommonUtility::getUserEmail($model->{Globals::FLD_NAME_USER_ID}).'"';
		$contact = UserContact::model()->find($criteria);
		//print_r($contact);exit;
		//$contact = UserContact::model->find("contact_id =?",CommonUtility::getUserEmail($id));
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		if(isset($_POST[Globals::FLD_NAME_USER]))
		{
			$model->attributes=$_POST[Globals::FLD_NAME_USER];
			//print_r($contact);exit;
			$contact->{Globals::FLD_NAME_CONTACT_ID}=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL];
			$contact->{Globals::FLD_NAME_CONTACT_TYPE} = Globals::DEFAULT_VAL_E_CAP;
			$contact->{Globals::FLD_NAME_IS_PRIMARY} =Globals::DEFAULT_VAL_1;
			$contact->{Globals::FLD_NAME_IS_LOGIN_ALLOWED} =Globals::DEFAULT_VAL_1;
			$contact->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
			$dataEmail[Globals::FLD_NAME_E] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL];
			$dataEmail[Globals::FLD_NAME_TYPE] = Globals::DEFAULT_VAL_P;
			$data[Globals::FLD_NAME_EMAILS][] = $dataEmail;
			
			if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_PHONE])
			{
				$dataPhone[Globals::FLD_NAME_P] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_PHONE];
				$dataPhone[Globals::FLD_NAME_TYPE] = Globals::DEFAULT_VAL_P;
				$data[Globals::FLD_NAME_PHS][] = $dataPhone;
			}
			
			$data = json_encode( $data );
			$model->{Globals::FLD_NAME_CONTACT_INFO}=$data;
                        
                        
                   
			$model->{Globals::FLD_NAME_LOGIN_NAME} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_LOGIN_NAME];
			$model->{Globals::FLD_NAME_GENDER} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GENDER];
			$model->{Globals::FLD_NAME_IS_ADMIN} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_IS_ADMIN];
			$model->{Globals::FLD_NAME_STATUS} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_STATUS];
                        
                        
                       if(@$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_USER_ROLE_ID])
                        {
                            $roleIds = implode(',', $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_USER_ROLE_ID]);
                            $model->{Globals::FLD_NAME_USER_ROLE_ID} = $roleIds;
                        }
                            
			//print_r($model->user_roleid);exit;
			$model->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
			if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_IS_ADMIN] == Globals::DEFAULT_VAL_0)
			{
			$model->scenario = Globals::HAS_ROLE_UPDATE;
			
			}
			if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_IS_ADMIN]==Globals::DEFAULT_VAL_1)
			{
			$model->user_roleid = Globals::DEFAULT_VAL_NULL;
			}
			$model->status= $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_STATUS];
			if($model->save())
			{                            
                             // Start for Update user search field
                                CommonUtility::updateUserSearchField($id);
                                // End for Update user search field
                                
				if($contact->{Globals::FLD_NAME_CONTACT_ID}!=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL])
				{
					$contact->save();
				}
				Yii::app()->user->setFlash('success',Yii::t('admin_admin','admin_user_update_text'));
				$this->redirect(array('admin'));
			}
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdateAccount()
	{
		$model=$this->loadModel(Yii::app()->user->id);
		// Uncomment the following line if AJAX validation is needed
      
      $contactEmail = UserContact::model()->findByAttributes(array(Globals::FLD_NAME_USER_ID=>$model->{Globals::FLD_NAME_USER_ID},Globals::FLD_NAME_CONTACT_TYPE=>Globals::DEFAULT_VAL_CONTACT_EMAILTYPE,Globals::FLD_NAME_IS_PRIMARY=>Globals::DEFAULT_VAL_CONTACT_IS_PRIMARY));
		$model->setScenario(Globals::UPDATE_ACCOUNT);
      $contactEmail->setScenario(Globals::UPDATE_ACCOUNT);
      $this->performAjaxValidation($contactEmail);
      //$email = GetRequest::getUserPrimearyEmail($model->{Globals::FLD_NAME_USER_ID});
      $phone = GetRequest::getUserPrimearyPhone($model->{Globals::FLD_NAME_USER_ID});
      //$model->{Globals::FLD_NAME_EMAIL} = $email;
      $model->{Globals::FLD_NAME_USER_PHONE} = $phone;
		if(isset($_POST[Globals::FLD_NAME_USER]))
		{
			$model->attributes=$_POST[Globals::FLD_NAME_USER];
			if($model->save())
			{
			   if(isset($_POST[Globals::FLD_NAME_USER_CONTACT]))
		       {
		            
                   //$userContact = new UserContact();
//                   $userContact->{Globals::FLD_NAME_USER_ID} = $model->{Globals::FLD_NAME_USER_ID};
//                   $userContact->{Globals::FLD_NAME_CONTACT_ID} = $_POST[Globals::FLD_NAME_USER_CONTACT][Globals::FLD_NAME_CONTACT_ID];
//                   $userContact->{Globals::FLD_NAME_IS_PRIMARY} = Globals::DEFAULT_VAL_CONTACT_IS_PRIMARY;
//                   $userContact->{Globals::FLD_NAME_CONTACT_TYPE} = Globals::DEFAULT_VAL_CONTACT_EMAILTYPE;
                     $contactEmail->attributes=$_POST[Globals::FLD_NAME_USER_CONTACT];
                     
                     if($contactEmail->save())
            			{
            			   if(isset($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_USER_PHONE]))
            		       {
            		             UserContact::model()->deleteAll(Globals::FLD_NAME_USER_ID.'=:id AND '.Globals::FLD_NAME_CONTACT_TYPE.'=:phone', array(':id' => $model->{Globals::FLD_NAME_USER_ID},':phone' => Globals::DEFAULT_VAL_CONTACT_PHONETYPE));
                               $userContact = new UserContact();
                               $userContact->{Globals::FLD_NAME_USER_ID} = $model->{Globals::FLD_NAME_USER_ID};
                               $userContact->{Globals::FLD_NAME_CONTACT_ID} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_USER_PHONE];
                               $userContact->{Globals::FLD_NAME_IS_PRIMARY} = Globals::DEFAULT_VAL_CONTACT_IS_PRIMARY;
                               $userContact->{Globals::FLD_NAME_CONTACT_TYPE} = Globals::DEFAULT_VAL_CONTACT_PHONETYPE;
                               $userContact->save();
            		       }
                        
            				Yii::app()->user->setFlash('success',Yii::t('admin_admin','account_update_text'));
            				$this->redirect(array('updateaccount'));
                     }
		       }
			   
			}
		}
      
		$this->render('updateaccount',array(
				'model'=>$model,
            'contactEmail'=>$contactEmail,
		));
	}
	
	public function actionChangePassword()
	{   
            $model=$this->loadModel(Yii::app()->user->id);
            $model->setScenario(Globals::CHANGE_PASSWORD);
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST[Globals::FLD_NAME_USER]))
            {
                $model->password=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NEW_PASSWORD];
                $model->attributes = $_POST[Globals::FLD_NAME_USER];
                if($model->save())
                {
                    Yii::app()->user->setFlash('success',Yii::t('admin_admin','password_change_msg_text'));
                    $this->redirect(array('changepassword'));
                }
            }
            $this->render('changepassword',array('model'=>$model));
        }
	  
	public function actionUserChangePassword($id)
	{

		$model=$this->loadModel($id);
		$model->setScenario(Globals::USER_CHANGE_PASSWORD);
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		if(isset($_POST[Globals::FLD_NAME_USER]))
		{               
			$model->attributes = $_POST[Globals::FLD_NAME_USER];
			$model->password=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NEW_PASSWORD];
			if($model->save())
			{
				Yii::app()->user->setFlash('success','Admin user password has been changed successfully.');
				$this->redirect(array('admin'));
			}
		}
		$this->render('userchangepassword',array('model'=>$model));
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$deleteSttaus=$this->loadModel($id)->delete();
		if($deleteSttaus)
		{
			CommonUtility::setFlashMsg('flash-success','Admin user has been deleted successfully');
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET[Globals::FLD_NAME_AJAX]))
			$this->redirect(isset($_POST[Globals::FLD_NAME_RETURN_URL]) ? $_POST[Globals::FLD_NAME_RETURN_URL] : array(Globals::FLD_NAME_USER));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $dataProvider=new CActiveDataProvider(Globals::FLD_NAME_USER);
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
            ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            if (isset($_GET[Globals::FLD_NAME_USER_DATA_SESSION]))
            {
                Yii::app()->user->setState(Globals::FLD_NAME_USER_DATA_SESSION,(int)$_GET[Globals::FLD_NAME_USER_DATA_SESSION]);
                unset($_GET[Globals::FLD_NAME_USER_DATA_SESSION]); // would interfere with pager and repetitive page size change
            }
			$model = new User('search');
//		echo '<pre>';
//                print_r($model);exit;	
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET[Globals::FLD_NAME_USER]))
            	$model->attributes = $_GET[Globals::FLD_NAME_USER];
            $currentRequest = Yii::app()->user->getState(Globals::FLD_NAME_PAGE_URL);
			//print_r($currentRequest);exit;
            $fillFields = Globals::DEFAULT_VAL_NULL;
            if(isset($currentRequest))
            {
                $fillFields = CommonUtility::createArray($currentRequest);
            }
			//print_r($fillFields);exit;
            $this->render('admin',array('model'=>$model,'fillFields'=>$fillFields));
	}
        
        public function actionUserList()
	{
           
            $model = new User('search');
//		echo '<pre>'	;
//                print_r($model);
//                exit;
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET[Globals::FLD_NAME_USER]))
            	$model->attributes = $_GET[Globals::FLD_NAME_USER];
            $currentRequest = Yii::app()->user->getState(Globals::FLD_NAME_PAGE_URL);
//			print_r($currentRequest);exit;
            $fillFields = Globals::DEFAULT_VAL_NULL;
            if(isset($currentRequest))
            {
                $fillFields = CommonUtility::createArray($currentRequest);
            }
			//print_r($fillFields);exit;
            $this->render('admin',array('model'=>$model,'fillFields'=>$fillFields,'is_admin' => '0'));
	}
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Admin the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
            $model=User::model()->findByPk($id);
            if($model===null)
                throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
            return $model;
	}
	public function actionAutoCompletelogin_name()
	{
	   //echo 'test';exit;
	   if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
	   {
			/* q is the default GET variable name that is used by
			/ the autocomplete widget to pass in user input
			*/
		  $name = $_GET[Globals::FLD_NAME_Q]; 
					// this was set with the "max" attribute of the CAutoComplete widget
		  $limit = $_GET[Globals::FLD_NAME_LIMIT]; 
		  // getAutoCompleteData($name,$tableName,$fieldName,$limit)
		  CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_USER,Globals::FLD_NAME_LOGIN_NAME,$limit);
		  
	   }
	}
	public function actionAutoCompleteEmail()
	{
	   
	   if(Yii::app()->request->isAjaxRequest && isset($_GET[Globals::FLD_NAME_Q]))
	   {
			/* q is the default GET variable name that is used by
			/ the autocomplete widget to pass in user input
			*/
			$name = $_GET[Globals::FLD_NAME_Q]; 
			// this was set with the "max" attribute of the CAutoComplete widget
			$limit = $_GET[Globals::FLD_NAME_LIMIT]; 
			CommonUtility::getAutoCompleteData($name,Globals::FLD_NAME_USER_CONTACT,Globals::FLD_NAME_CONTACT_ID,$limit);
	   }
	}
	/**
	 * Performs the AJAX validation.
	 * @param Admin $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
            if(isset($_POST[Globals::FLD_NAME_AJAX]) && ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_ADMIN_FORM))
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
}
