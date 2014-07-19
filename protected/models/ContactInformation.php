<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ContactInformation extends CFormModel
{
	public $chat_id;
	

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('chat_id', 'required'),
			// rememberMe needs to be a boolean
			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'chat_id'=> Yii::t('label_model', 'lbl_chat_id'),
		);
	}

	
       
}
