<?php

class IndexController extends BackEndController
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->layout='column1';
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->layout='column1';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error[Globals::FLD_NAME_MESSAGE];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{		
		if(isset(Yii::app()->user->id))
		{
			$this->redirect(array('index/index'));
		}
		else
		{
			$model=new LoginForm;
			if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX] === Globals::DEFAULT_VAL_LOGIN_FORM)
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
	
			// collect user input data
			if(isset($_POST[Globals::FLD_NAME_LOGIN_FORM]))
			{
				$model->attributes=$_POST[Globals::FLD_NAME_LOGIN_FORM];
				// validate user input and redirect to the previous page if valid
				if($model->validate())
				{
					if($model->login())
					{
						//$this->redirect(Yii::app()->user->returnUrl);
						$cookieUsername = new CHttpCookie(Globals::FLD_NAME_USER_NAME, $_POST[Globals::FLD_NAME_LOGIN_FORM][Globals::FLD_NAME_USER_NAME]);
						$cookiePassword = new CHttpCookie(Globals::FLD_NAME_PASSWORD, $_POST[Globals::FLD_NAME_LOGIN_FORM][Globals::FLD_NAME_PASSWORD]);
						$cookierememberMe = new CHttpCookie(Globals::FLD_NAME_REMEMBER_ME, $_POST[Globals::FLD_NAME_LOGIN_FORM][Globals::FLD_NAME_REMEMBER_ME]);
						if($_POST[Globals::FLD_NAME_LOGIN_FORM][Globals::FLD_NAME_REMEMBER_ME] == Globals::DEFAULT_VAL_1)
						{
							$cookieUsername->expire = time() + (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
							$cookiePassword->expire = time() + (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
							$cookierememberMe->expire = time() + (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
							
							Yii::app()->request->cookies[Globals::FLD_NAME_USER_NAME] = $cookieUsername;
							Yii::app()->request->cookies[Globals::FLD_NAME_PASSWORD] = $cookiePassword;
							Yii::app()->request->cookies[Globals::FLD_NAME_REMEMBER_ME] = $cookierememberMe;
						}
						else
						{
							$cookieUsername->expire = time() - (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
							$cookiePassword->expire = time() - (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
							$cookierememberMe->expire = time() - (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
							Yii::app()->request->cookies[Globals::FLD_NAME_USER_NAME] = $cookieUsername;
							Yii::app()->request->cookies[Globals::FLD_NAME_PASSWORD] = $cookiePassword;
							Yii::app()->request->cookies[Globals::FLD_NAME_REMEMBER_ME] = $cookierememberMe;
						}
						 echo CJSON::encode(array(
						  'status'=>'success'
						 ));
					}
					else
					{
						echo CJSON::encode(array(
							  'status'=>'not'
						 ));
					 }
						Yii::app()->end();
				}
				else
				{					
					$error = CActiveForm::validate($model);
					if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
						echo $error;
					Yii::app()->end();
				}
			}
			// display the login form		
			$this->render('login',array('model'=>$model),false,true);
		}
	}
        public function actionAutoLogin()
	{		
			$model=new LoginForm;
			if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX] === Globals::DEFAULT_VAL_LOGIN_FORM)
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
	
			// collect user input data
			if(isset($_POST[Globals::FLD_NAME_LOGIN_FORM]))
			{
				$model->attributes=$_POST[Globals::FLD_NAME_LOGIN_FORM];
				// validate user input and redirect to the previous page if valid
				if($model->validate())
				{
					if($model->login())
					{
						$cookieUsername = new CHttpCookie(Globals::FLD_NAME_USER_NAME, $_POST[Globals::FLD_NAME_LOGIN_FORM][Globals::FLD_NAME_USER_NAME]);
						$cookiePassword = new CHttpCookie(Globals::FLD_NAME_PASSWORD, $_POST[Globals::FLD_NAME_LOGIN_FORM][Globals::FLD_NAME_PASSWORD]);
						$cookieUsername->expire = time() - (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
						$cookiePassword->expire = time() - (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
						Yii::app()->request->cookies[Globals::FLD_NAME_USER_NAME] = $cookieUsername;
						Yii::app()->request->cookies[Globals::FLD_NAME_PASSWORD] = $cookiePassword;
						 
						 echo CJSON::encode(array(
						  'status'=>'success'
						 ));
					}
					else
					{
						echo CJSON::encode(array(
							  'status'=>'not'
						 ));
					 }
						Yii::app()->end();
				}
				else
				{					
					$error = CActiveForm::validate($model);
					if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
						echo $error;
					Yii::app()->end();
				}
			}
			// display the login form		
			$this->renderPartial('autologin',array('model'=>$model),false,true);
//		}
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		
		/*$prefix =  Yii::app()->user->getStateKeyPrefix();
		session_unset($_SESSION[''.$prefix.'last_login']);
		session_unset($_SESSION[''.$prefix.'super']);
		session_unset($_SESSION[''.$prefix.'language']);
		session_unset($_SESSION[''.$prefix.'permission']);
		session_unset($_SESSION[''.$prefix.'_id']);
		session_unset($_SESSION[''.$prefix.'_name']);
		session_unset($_SESSION[''.$prefix.'type']);
		session_unset($_SESSION[''.$prefix.'_states']);
		session_unset($_SESSION[''.$prefix.'_timeout']);*/
		Yii::app()->user->logout();
		$this->redirect(array('index/login'));
	}
}