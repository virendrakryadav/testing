<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ResetPasswordForm extends CFormModel
{
	//public $email;
	public $password;
	public $repeatpassword;
	//public $rememberMe;
	//private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and password are required
			array('password,repeatpassword', 'required'),
                        array('repeatpassword', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"),
			//array('email', 'email'),
			//array('terms_agree', 'required', 'requiredValue' => 1, 'message' => 'You have to check this checkbox'),
			// rememberMe needs to be a boolean
			//array('rememberMe', 'boolean'),
			// password needs to be authenticated
			//array('password,confirm_password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			//'rememberMe'=>Yii::t('label_model', 'lbl_rememberMe'),
//                    'password' => 'New Password',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	
	/**
	 * Logs in the user using the given email and password in the model.
	 * @return boolean whether login is successful
	 */
	
}
