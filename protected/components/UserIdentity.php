<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{

		$user=User::model()->find('LOWER(login_name)=?',array(strtolower($this->username)));

		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		//else if(!$user->validatePassword($this->password))
        else if ((md5($this->password.Yii::app()->params["salt"])) !== $user->password) 
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if ($user->status !== 'a')
			 $this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->{Globals::FLD_NAME_USER_ID};
			$this->username=$user->login_name;
                        Yii::app()->user->setState('last_login',$user->last_accessed_at);
//                        if($user->last_accessed_at == '')
//                        {
//                            Yii::app()->user->logout();
//                            Yii::app()->session->clear();
//                            $this->redirect('/index/login');
//                        }
                        User::model()->updateByPk($user->{Globals::FLD_NAME_USER_ID}, array('last_accessed_at' => new CDbExpression('NOW()')));
                        Yii::app()->user->setState('super',$user->is_admin);
                        
                      
                        
                        
                        Yii::app()->user->setState('language',Yii::app()->params['DEFAULTLanguage']);
                        if(isset($user->user_roleid))
                        {
                            
                            $role_id = $user->user_roleid;
                        }
                        else 
                        {
                            $role_id = 1;
                        }
                        $selectedRoles = CommonUtility::getUserSelectedRoles($role_id);
                        if($selectedRoles)
                        {
                            $permissionsArr = '';
                                 
                            $i = 1;
                            foreach ($selectedRoles as $roleId)
                            {
                                $role = Roles::model()->find('role_id=?',array($roleId));
                                if(isset($role))
                                {
                                    $permissions = $role->{Globals::FLD_NAME_ROLE_PERMISSION};
                                    if($permissionsArr)
                                    {
                                        $permissions = CJSON::decode($permissions);
                                        $permissionsArr = CommonUtility::margePremissionsArray( $permissionsArr , (array)$permissions  );
                                    }
                                    else
                                    {
                                        $permissionsArr = CJSON::decode($permissions);
                                    }
                                }
                            }
                          //  print_r($permissionsArr);
                            Yii::app()->user->setState('permission',$permissionsArr);
                        }
                        Yii::app()->user->setState('actionUserId',$user->{Globals::FLD_NAME_USER_ID});
			$this->setState('type',$user->is_admin);
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}