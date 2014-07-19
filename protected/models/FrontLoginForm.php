<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class FrontLoginForm extends CFormModel
{
	public $email;
	public $password;
	public $rememberMe;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and password are required
			array('email, password', 'required'),
			array('email', 'email'),
			//array('terms_agree', 'required', 'requiredValue' => 1, 'message' => 'You have to check this checkbox'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>Yii::t('label_model', 'lbl_rememberMe'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
            if(!$this->hasErrors())
            {
                    $this->_identity=new FrontUserIdentity($this->{Globals::FLD_NAME_EMAIL},$this->{Globals::FLD_NAME_PASSWORD});
                   	return $this->_identity->authenticate();
				    //if(!$this->_identity->authenticate())
                    //$this->addError('password','Incorrect email or password.');
            }    
	}

	/**
	 * Logs in the user using the given email and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new FrontUserIdentity($this->{Globals::FLD_NAME_EMAIL},$this->{Globals::FLD_NAME_PASSWORD});
			$this->_identity->authenticate();
		}

       
                //exit ();
		if($this->_identity->errorCode===Globals::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days  
                        
                   //     print_r($this->_identity);
//                        exit;
			Yii::app()->user->login($this->_identity,$duration);
			//return true;
		}
		 return $this->_identity->errorCode;
		//else
			//return false;
	}
}
