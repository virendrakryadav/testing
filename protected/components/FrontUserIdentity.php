<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class FrontUserIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{

	//$user=User::model()->find('email=?',array($this->username));
	$criteria = new CDbCriteria;
	$criteria->condition= Globals::FLD_NAME_CONTACT_ID.'="'.$this->username.'" and '.Globals::FLD_NAME_CONTACT_TYPE.'="'.Globals::DEFAULT_VAL_CONTACT_TYPE.'" and '.Globals::FLD_NAME_IS_LOGIN_ALLOWED.'="'.Globals::DEFAULT_VAL_IS_LOGIN_ALLOWED.'"';
//              $criteria->params=array(':id'=>$this->username);
	$email = UserContact::model()->find($criteria);
	if(empty($email))
	{
		$this->errorCode=Globals::ERROR_EMAIL_INVALID;
	}
	else
	{
		$user=User::model()->find(Globals::FLD_NAME_USER_ID.'=?',array($email->{Globals::FLD_NAME_USER_ID}));
                if($user===null)
		{
			$this->errorCode=Globals::ERROR_EMAIL_INVALID;
		}
		//else if(!$user->validatePassword($this->password))
//		else if ((md5($this->password.Yii::app()->params[Globals::FLD_NAME_SALT])) !== $user->password) 
//		{
//			$this->errorCode=Globals::ERROR_PASSWORD_INVALID;
//		}
		else if ((md5($this->password.Yii::app()->params["salt"])) !== $user->password)
		{
                    $this->errorCode = Globals::ERROR_PASSWORD_INVALID;
		}                                 
                
                else if ($user->status !== Globals::DEFAULT_VAL_USER_STATUS )
		{
                    //$this->errorCode=self::ERROR_PASSWORD_INVALID;
                    $this->errorCode = Globals::ERROR_STATUS_DEACTIVE;
		}
		//else if ($user->is_verify !== '1')
			// $this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->{Globals::FLD_NAME_USER_ID};
			if($user->firstname)
			{
				Yii::app()->user->setState(Globals::FLD_NAME_USER_FULLNAME,$user->firstname." ".$user->lastname);
			}
			else
			{
				Yii::app()->user->setState(Globals::FLD_NAME_USER_FULLNAME,$this->username);
			}
                        User::model()->updateByPk($user->{Globals::FLD_NAME_USER_ID}, array('last_accessed_at' => new CDbExpression('NOW()')));
                        if($user->user_type == Globals::DEFAULT_VAL_USER_TYPE_ADMIN)
                        {
                            Yii::app()->user->setState('super' , $user->is_admin);
                            Yii::app()->user->setState('superAdminId',$user->{Globals::FLD_NAME_USER_ID});
                            
                        }
                        if(isset($user->user_roleid))
                        {
                            $role_id = $user->user_roleid;
                        }
                        else 
                        {
                            $role_id = 1;
                        }
//                        $role=Roles::model()->find('role_id=?',array($role_id));
//                        if(isset($role))
//                        {
//                            $permissions = $role->role_permission;
//                            $permissions = CJSON::decode($permissions);
//                            //$this->permission = $permissions;
//                          
//                            Yii::app()->user->setState('permission',$permissions);
//                        }
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
                                    $permissions = $role->{Globals::FLD_NAME_ROLE_PERMISSION_FRONT};
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
                        
                        $virtualdoer['permission_val'] = $user->{Globals::FLD_NAME_IS_VIRTUALDOER_LICENSE};
                        $virtualdoer['permission_status'] = 0;
                        if($user->{Globals::FLD_NAME_IS_VIRTUALDOER_LICENSE} == 1)
                        {
                            $virtualdoer['permission_status'] = 1;
                        }     
                        
                        $inpersondoer['permission_val'] = $user->{Globals::FLD_NAME_IS_INPERSONDOER_LICENSE};
                        $inpersondoer['permission_status'] = 0;
                        if($user->{Globals::FLD_NAME_IS_INPERSONDOER_LICENSE} == 1)
                        {
                            $inpersondoer['permission_status'] = 1;
                        } 
                        
                        $instantdoer['permission_val'] = $user->{Globals::FLD_NAME_IS_INSTANTDOER_LICENSE};
                        $instantdoer['permission_status'] = 0;
                        if($user->{Globals::FLD_NAME_IS_INSTANTDOER_LICENSE} == 1)
                        {
                            $instantdoer['permission_status'] = 1;
                        }  
                        
                        $premiumdoer['permission_val'] = $user->{Globals::FLD_NAME_IS_PREMIUMDOER_LICENSE};
                        $premiumdoer['permission_status'] = 0;
                        if($user->{Globals::FLD_NAME_IS_PREMIUMDOER_LICENSE} == 1)
                        {
                            $premiumdoer['permission_status'] = 1;
                        }   
                        
                        $poster['permission_val'] = $user->{Globals::FLD_NAME_IS_POSTER_LICENSE};
                        $poster['permission_status'] = 0;
                        if($user->{Globals::FLD_NAME_IS_POSTER_LICENSE} == 1)
                        {
                            $poster['permission_status'] = 1;
                        }                        
                        
                        Yii::app()->user->setState('is_virtualdoer_license',$virtualdoer);
                        Yii::app()->user->setState('is_inpersondoer_license',$inpersondoer);
                        Yii::app()->user->setState('is_instantdoer_license',$instantdoer);
                        Yii::app()->user->setState('is_premiumdoer_license',$premiumdoer);
                        Yii::app()->user->setState('is_poster_license',$poster);
                        
                        
                        Yii::app()->user->setState('actionUserId',$user->{Globals::FLD_NAME_USER_ID});
                        Yii::app()->user->setState('user_type',CommonUtility::getUserRoleType());
			Yii::app()->user->setState(Globals::FLD_NAME_LANGUAGE,Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE]);
			//$this->_name=$user->firstname." ".$user->lastname;
			
                         
			$this->errorCode=Globals::ERROR_NONE;
		}
	}
		return $this->errorCode;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}