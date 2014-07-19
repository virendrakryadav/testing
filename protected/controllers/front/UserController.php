<?php

class UserController extends Controller
{
	/**
	 * Declares class-based actions.
	 */ 
    public function filters() 
    {
        return array(
            'accessControl', // perform access control for CRUD operationstail
        );
    }
    public function accessRules()
	{
         $perform = $this->Permissions();
         //print_r($perform);
            return array(
                array(
                    'allow',  // allow all users to perform 'index' and 'view' actions
                    'actions'=>array(
                                        'contactinformation','getchatfield',
                                        'getmobilefield','getemailfield','getsocialfield','getcertffield',
                                        'editaccount','editaccountupdate','deleteaccountupdate','accountpreference',
                                        'editpaypalaccount','editpaypalaccountupdate','deletepaypalaccount',
                                        'creditaccountsetting','userupdatecontactinformation','userupdatepersonalinformation',
                                        'userupdateaboutus','craetefolder','userupdatesetting','useraddportfolio',
                                        'userviewportfolio','uploadportfolioimage','changepublicstatus','userupdateportfolio',
                                        'removeportfolioimage','updateportfolio','userdeleteportfolio','getlog','selectusersession',
                                        'settings','accountsetting','changepassword'
                                    ),
                    'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                            'actions'=>$perform,
                            'users'=>array('@'),
                ),
                
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
            );
	}
	public function actions()
	{
            return array(

            );
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	
	public function actionContactInformation()
	{	
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('ContactInformation','application.controller.UserController');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $model->scenario = Globals::CONTACT_INFORMATION;
            $this->performAjaxValidation($model);
            if(isset($_POST[Globals::FLD_NAME_USER]))
            {
               $data = array();
               $totalMobile = $_POST[Globals::FLD_NAME_TOTAL_MOBILE_ID];
               $totalEmail = $_POST[Globals::FLD_NAME_TOTAL_EMAIL_ID];
               $totalChat = $_POST[Globals::FLD_NAME_TOTAL_CHAT_ID];
               $totalSocial = $_POST[Globals::FLD_NAME_TOTAL_SOCIAL_ID];
               $mobileErr = Globals::DEFAULT_VAL_0;
               $emailErr = Globals::DEFAULT_VAL_0;
               $chatErr = Globals::DEFAULT_VAL_0;
               $socialErr = Globals::DEFAULT_VAL_0;
               $updateRows = Globals::DEFAULT_VAL_0;

                if(isset($model->{Globals::FLD_NAME_CONTACT_INFO}))
                {
                    $previuosData = $model->{Globals::FLD_NAME_CONTACT_INFO};
                }
                for($i=Globals::DEFAULT_VAL_0;$i<=$totalMobile;$i++)
                {
                   $insertInto = Globals::DEFAULT_VAL_1;
                   if(isset($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_MOBILE_.$i][Globals::FLD_NAME_MOBILE]))
                   {

                       if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_MOBILE_.$i][Globals::FLD_NAME_MOBILE] !=Globals::DEFAULT_VAL_NULL)
                       {
                           for($j=Globals::DEFAULT_VAL_0;$j<=$totalMobile;$j++)
                            {
                               if(isset($data[Globals::FLD_NAME_PHS][$j]))
                               {
                                    if(in_array($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_MOBILE_.$i][Globals::FLD_NAME_MOBILE], $data[Globals::FLD_NAME_PHS][$j]))
                                    {
                                        $insertInto = Globals::DEFAULT_VAL_0;
                                        $mobileErr = Globals::DEFAULT_VAL_1;
                                    }
                               }
                           }
                           if($insertInto==Globals::DEFAULT_VAL_1)
                           {
                                $dataMobile[Globals::DEFAULT_VAL_P] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_MOBILE_.$i][Globals::FLD_NAME_MOBILE];
                                if($i==Globals::DEFAULT_VAL_1)
                                {
                                    $dataMobile[Globals::FLD_NAME_TYPE] = Globals::DEFAULT_VAL_P;
                                }
                                else 
                                {
                                    $dataMobile[Globals::FLD_NAME_TYPE] =Globals::DEFAULT_VAL_S;
                                }
                                $data[Globals::FLD_NAME_PHS][] = $dataMobile;
                                $updateRows = Globals::DEFAULT_VAL_1;

                           }
                       }
                   }
                }
                for($i=Globals::DEFAULT_VAL_0;$i<=$totalEmail;$i++)
                {
                   $insertInto = Globals::DEFAULT_VAL_1;
                   if(isset($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL_.$i][Globals::FLD_NAME_EMAIL]))
                   {
                       if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL_.$i][Globals::FLD_NAME_EMAIL] !=Globals::DEFAULT_VAL_NULL)
                       {
                           for($j=Globals::DEFAULT_VAL_0;$j<=$totalEmail;$j++)
                            {
                               if(isset($data[Globals::FLD_NAME_EMAILS][$j]))
                               {
                                    if(in_array($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL_.$i][Globals::FLD_NAME_EMAIL], $data[Globals::FLD_NAME_EMAILS][$j]))
                                    {
                                        $insertInto = Globals::DEFAULT_VAL_0;
                                        $emailErr = Globals::DEFAULT_VAL_1;
                                    }
                               }
                           }
                           if($insertInto==Globals::DEFAULT_VAL_1)
                           {
                                $dataEmail[Globals::FLD_NAME_E] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL_.$i][Globals::FLD_NAME_EMAIL];
                                if($i==Globals::DEFAULT_VAL_1)
                                {
                                    $dataEmail[Globals::FLD_NAME_TYPE] = Globals::DEFAULT_VAL_P;
                                }
                                else 
                                {
                                    $dataEmail[Globals::FLD_NAME_TYPE] = Globals::DEFAULT_VAL_S;
                                }
                                $data[Globals::FLD_NAME_EMAILS][] = $dataEmail;
                                $updateRows = Globals::DEFAULT_VAL_1;
                           }
                       }
                   }
                }
                for($i=Globals::DEFAULT_VAL_0;$i<=$totalChat;$i++)
                {
                   $insertInto = Globals::DEFAULT_VAL_1;
                   if(isset($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CHAT_ID_.$i][Globals::FLD_NAME_CHAT_ID]))
                   {
                       if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CHAT_ID_.$i][Globals::FLD_NAME_CHAT_ID] !=Globals::DEFAULT_VAL_NULL)
                       {
                           for($j=Globals::DEFAULT_VAL_0;$j<=$totalChat;$j++)
                            {
                               if(isset($data[Globals::FLD_NAME_CHAT_IDS][$j]))
                               {
                                    if( in_array($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CHAT_ID_.$i][Globals::FLD_NAME_CHAT_ID], $data[Globals::FLD_NAME_CHAT_IDS][$j]) && 
                                        in_array($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CHAT_ID_.$i][Globals::FLD_NAME_CHAT_ID_OF], $data[Globals::FLD_NAME_CHAT_IDS][$j]))
                                    {
                                        $insertInto = Globals::DEFAULT_VAL_0;
                                        $chatErr = Globals::DEFAULT_VAL_1;
                                    }
                               }
                           }
                           if($insertInto==Globals::DEFAULT_VAL_1)
                           {
                                $dataChat[Globals::FLD_NAME_ID] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CHAT_ID_.$i][Globals::FLD_NAME_CHAT_ID];
                                $dataChat[Globals::FLD_NAME_TYPE] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CHAT_ID_.$i][Globals::FLD_NAME_CHAT_ID_OF];
                                $data[Globals::FLD_NAME_CHAT_IDS][] = $dataChat;
                                $updateRows = Globals::DEFAULT_VAL_1;
                           }
                       }
                   }
                }
                for($i=Globals::DEFAULT_VAL_0;$i<=$totalSocial;$i++)
                {
                    $insertInto = Globals::DEFAULT_VAL_1;
                    if(isset($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SOCIAL_.$i][Globals::FLD_NAME_SOCIAL]))
                    {
                       if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SOCIAL_.$i][Globals::FLD_NAME_SOCIAL] !=Globals::DEFAULT_VAL_NULL)
                       {
                           for($j=Globals::DEFAULT_VAL_0;$j<=$totalSocial;$j++)
                            {
                               if(isset($data[Globals::FLD_NAME_SOCIAL_IDS][$j]))
                               {
                                    if( in_array($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SOCIAL_.$i][Globals::FLD_NAME_SOCIAL], $data[Globals::FLD_NAME_SOCIAL_IDS][$j]) && 
                                        in_array($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SOCIAL_.$i][Globals::FLD_NAME_SOCIAL_OF], $data[Globals::FLD_NAME_SOCIAL_IDS][$j]))
                                    {
                                        $insertInto = Globals::DEFAULT_VAL_0;
                                        $socialErr = Globals::DEFAULT_VAL_1;

                                    }
                               }
                           }
                           if($insertInto==Globals::DEFAULT_VAL_1)
                           {
                                $dataSocial[Globals::FLD_NAME_ID] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SOCIAL_.$i][Globals::FLD_NAME_SOCIAL];
                                $dataSocial[Globals::FLD_NAME_TYPE] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SOCIAL_.$i][Globals::FLD_NAME_SOCIAL_OF];
                                $data[Globals::FLD_NAME_SOCIAL_IDS][] = $dataSocial;
                               // $updateRows = 1;
                           }
                       }
                    }
                }
                $data = CJSON::encode( $data );
                if($previuosData == $data)
                {
                    $updateRows=Globals::DEFAULT_VAL_0;
                }
                else 
                {
                    $updateRows=Globals::DEFAULT_VAL_1;
                }
                $model->{Globals::FLD_NAME_CONTACT_INFO}=$data;
                try
                {
                        if(!$model->update())
                        {
                                echo $error = CJSON::encode(array(
                                        'status'=>'not',
                                ));
                                throw new Exception(Yii::t('user_contactinformation','unexpected_error'));
                        }
                         $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_CONTACTINFO,
                                            //  Globals::FLD_NAME_COMMENTS => '',
                                     );
                        try
                        {
                            CommonUtility::addUserActivity( Yii::app()->user->id , Globals::USER_ACTIVITY_TYPE_PROFILE_UPDATE , $otherInfo );
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                        }
                        echo $error = CJSON::encode(array(
                                'status'=>'success',
                                'mobileErr'=>$mobileErr,
                                'emailErr'=>$emailErr,
                                'chatErr'=>$chatErr,
                                'socialErr'=>$socialErr,
                                'updateRows'=>$updateRows,
                        ));
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        if (CommonUtility::IsTraceEnabled())
                        {
                                Yii::trace('Executing actionContactInformation() method','UserController');
                        }
                        Yii::log('User.ContactInformation: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
                }    
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('ContactInformation');
            }
	}
	public function actionGetChatField()
        {       
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('GetChatField','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $nextnum =  $_POST[Globals::FLD_NAME_NUM];
            $nextnum++;
            try
            {
                UtilityHtml::userGetChatField($model,$nextnum,Globals::DEFAULT_VAL_NULL);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('GetChatField');
            }
	}
	public function actionGetSocialField()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('GetSocialField','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $nextnum =  $_POST[Globals::FLD_NAME_NUM];
            $nextnum++;
            try
            {
                UtilityHtml::userGetSocialField($model,$nextnum,Globals::DEFAULT_VAL_NULL);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('GetSocialField');
            }
	}
	public function actionGetMobileField()
	{    
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('GetMobileField','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $nextnum =  $_POST[Globals::FLD_NAME_NUM];
            $nextnum++;
            if($nextnum <= Globals::DEFAULT_VAL_2)
            {
                    try
                    {
                         UtilityHtml::userGetMobileField($model,$nextnum);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,"Task ID" => $task_id ,"Category ID" => $category_id) );
                    }
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('GetMobileField');
            }
	}
	public function actionGetCertfField()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('GetCertfField','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $nextnum =  $_POST[Globals::FLD_NAME_NUM];
            $nextnum++;
            try
            {
                UtilityHtml::userGetCertfField($model,$nextnum,Globals::DEFAULT_VAL_NULL);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('GetCertfField');
            }
	}
	
	public function actionGetEmailField()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('GetEmailField','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $nextnum =  $_POST[Globals::FLD_NAME_NUM];
            $nextnum++;
            if($nextnum <= Globals::DEFAULT_VAL_2)
            {
                try
                {
				UtilityHtml::userGetEmailField($model,$nextnum);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                }
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('GetEmailField');
            }
	}
	public function actionGetlog()
	{
		//Yii::beginProfile('Getlog','application.controller.UserController.ajax');
//           print_r($_POST['errorLogVal']);
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('Getlog','application.controller.UserController');
                }
		$str = '';
                @$errorLog = $_POST['errorLog'];
		$tolatError = count($errorLog);
		for($i=0;$i<$tolatError;$i++)
		{
			if($errorLog[$i] != '')
				{
					$str.= '['.$errorLog[$i].']'.'['.$_POST['errorLogVal'][$i].'],';
				}
		}
//            echo $str;
		$controllerAndAction = $this->getUniqueId().'.'.$this->action->id;
		if (CommonUtility::IsTraceEnabled())
		{
			Yii::trace('Executing actionContactInformation() method','UserController');
		}
		Yii::log($str,CLogger::LEVEL_ERROR ,$controllerAndAction);
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::endProfile('Getlog');
                }
	}

	public function actionEditAccount()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('EditAccount','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $model->scenario = Globals::ACCOUNT_DETAIL;
            @$card_id = $_POST[Globals::FLD_NAME_CARD_ID];
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $this->renderPartial('editaccount',array('model'=>$model,Globals::FLD_NAME_CARD_ID=>$card_id),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('EditAccount');
            }
	}
	
	//partial/_profile2
	public function actionEditPaypalAccount()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('EditPaypalAccount','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $model->scenario = Globals::PAYPAL_ACCOUNT_DETAIL;
            @$paypal_id = $_POST[Globals::FLD_NAME_PAYPAL_ID];
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $this->renderPartial('editpaypalaccount',array('model'=>$model,Globals::FLD_NAME_PAYPAL_ID=>$paypal_id),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('EditPaypalAccount');
            }
	}
	public function actionAccountPreference()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('AccountPreference','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $model->scenario = Globals::ACCOUNT_DETAIL;
            @$card_id = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_ACCOUNT_PREFERENCE];
			if(isset($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}))
            {
                $preferences = CJSON::decode($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}, true);
            }
            if(isset($preferences[Globals::FLD_NAME_CARD]))
            {
                foreach ($preferences[Globals::FLD_NAME_CARD] as $index=>$card)
                {
                   $preferences[Globals::FLD_NAME_CARD][$index][Globals::FLD_NAME_PREFERENCE]=Globals::DEFAULT_VAL_0;
                }
            }
            if(isset($preferences[Globals::FLD_NAME_PAYPAL]))
            {
                foreach ($preferences[Globals::FLD_NAME_PAYPAL] as $index=>$card)
                {
                   $preferences[Globals::FLD_NAME_PAYPAL][$index][Globals::FLD_NAME_PREFERENCE]=Globals::DEFAULT_VAL_0;
                }
            }
            if (strpos($card_id,Globals::FLD_NAME_CARD_) !== false) 
            {
                $card_id = str_replace(Globals::FLD_NAME_CARD_, Globals::DEFAULT_VAL_NULL, $card_id);
                $preferences[Globals::FLD_NAME_CARD][$card_id][Globals::FLD_NAME_PREFERENCE] = Globals::DEFAULT_VAL_1;
            }
            else 
            {
                $card_id = str_replace(Globals::FLD_NAME_PAYPAL_, Globals::DEFAULT_VAL_NULL, $card_id);
                $preferences[Globals::FLD_NAME_PAYPAL][$card_id][Globals::FLD_NAME_PREFERENCE] = Globals::DEFAULT_VAL_1;
            }
            $preferences = CJSON::encode( $preferences );
            $model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}=$preferences;
            try
            {
                    try
                    {
                        $model->update();
                    }
                    catch(Exception $e)
                    {
                     $msg = $e->getMessage();
                     CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id, 'hideoutput' => true) );
                     throw new Exception(Yii::t('user_accountpreference','unexpected_error'));
                    }
                    
                    
                    $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_ACCOUNT_PREFERENCE,
                                            //  Globals::FLD_NAME_COMMENTS => '',
                                     );
                    try
                    {
                        CommonUtility::addUserActivity( Yii::app()->user->id , Globals::USER_ACTIVITY_TYPE_PROFILE_UPDATE , $otherInfo );
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                    echo $error = CJSON::encode(array('status'=>'success'));
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    if (CommonUtility::IsTraceEnabled())
                    {
                        Yii::trace('Executing actionContactInformation() method','UserController');
                    }
                    CommonUtility::catchErrorMsg( 'User.AccountPreference: reason:-'.$msg , array( "User ID" => Yii::app()->user->id, 'UserController' ) );
                    //Yii::log('User.AccountPreference: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
            }    
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('AccountPreference');
            }
	}
	public function actionDeleteAccountUpdate()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('DeleteAccountUpdate','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $model->scenario = Globals::ACCOUNT_DETAIL;
            @$card_id = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_ID];
            if(isset($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}))
            {
                $preferences = CJSON::decode($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}, true);
            }
            if($preferences[Globals::FLD_NAME_CARD][$card_id][Globals::FLD_NAME_PREFERENCE]==Globals::DEFAULT_VAL_1)
            {
                echo $error = CJSON::encode(array(  'status'=>'success',    Globals::FLD_NAME_PREFERENCE=>Globals::FLD_NAME_PREFERENCE));
                Yii::app()->end();
            }
            unset($preferences[Globals::FLD_NAME_CARD][$card_id]);
            $preferences = CJSON::encode( $preferences );
            $model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}=$preferences;
            try
            {
//                if(!$model->update())
//                {
//                        throw new Exception(Yii::t('user_deleteaccountupdate','unexpected_error'));
//                }
                try
                    {
                    $model->update();
                    }
                    catch (Exception $e){
                        $msg =$e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id, 'hideoutput' => true) );
                        throw new Exception(Yii::t('user_deleteaccountupdate','unexpected_error'));
                    }
                $otherInfo = array( 
                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_DELETE_ACCOUNT,
                        //  Globals::FLD_NAME_COMMENTS => '',
                );
                try
                {
                    CommonUtility::addUserActivity( Yii::app()->user->id , Globals::USER_ACTIVITY_TYPE_PROFILE_UPDATE , $otherInfo );
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                }
                echo $error = CJSON::encode(array(  'status'=>'success',    Globals::FLD_NAME_PREFERENCE=>'not'));
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    if (CommonUtility::IsTraceEnabled())
                    {
                            Yii::trace('Executing actionContactInformation() method','UserController');
                    }
                    Yii::log('User.DeleteAcountUpdate: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
            }    
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('DeleteAccountUpdate');
            }
	}
	public function actionDeletePaypalAccount()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('DeletePaypalAccount','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            @$paypal_id = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_PAYPAL_ID];
            if(isset($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}))
            {
                $preferences = CJSON::decode($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}, true);
            }
            if($preferences[Globals::FLD_NAME_PAYPAL][$paypal_id][Globals::FLD_NAME_PREFERENCE]==Globals::DEFAULT_VAL_1)
            {
                echo $error = CJSON::encode(array('status'=>'success',  Globals::FLD_NAME_PREFERENCE=>Globals::FLD_NAME_PREFERENCE ));
                Yii::app()->end();
            }
            unset($preferences[Globals::FLD_NAME_PAYPAL][$paypal_id]);
            $preferences = CJSON::encode( $preferences );
            $model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}=$preferences;
            try
            {
                    if(!$model->update())
                    {
                            throw new Exception(Yii::t('user_deletepaypalaccount','unexpected_error'));
                    }
                    $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_DELETE_PAYAPL_ACCOUNT,
                                            //  Globals::FLD_NAME_COMMENTS => '',
                                     );
                    try
                    {
                        CommonUtility::addUserActivity( Yii::app()->user->id , Globals::USER_ACTIVITY_TYPE_PROFILE_UPDATE , $otherInfo );
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                echo $error = CJSON::encode(array('status'=>'success'));
            }
			catch(Exception $e)
			{             
				$msg = $e->getMessage();
				if (CommonUtility::IsTraceEnabled())
				{
					Yii::trace('Executing actionContactInformation() method','UserController');
				}
				Yii::log('User.DeletePaypalAccount: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
			}    
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('DeletePaypalAccount');
            }
	}
	public function actionEditAccountUpdate()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('EditAccountUpdate','application.controller.UserController.ajax');
            }
            $model = $this->loadModel(Yii::app()->user->id);
            $model->scenario = Globals::ACCOUNT_DETAIL;
            $error = Globals::DEFAULT_VAL_NULL;
            
            if(Yii::app()->request->isAjaxRequest)
            {
                //print_r($_POST[Globals::FLD_NAME_USER]);
                $error =  CActiveForm::validate($model);
                if($error!=Globals::DEFAULT_VAL_NULL_ARRAY)
                {
                        CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                        echo $error;
                        Yii::app()->end();
                }
            }
            $this->performAjaxValidation($model);
            if(isset($_POST[Globals::FLD_NAME_USER]))
            {       
                $card_id = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_ID];
                $preferences=array();
                $dataCard = array();
                if(isset($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}))
                {
                        $preferences = CJSON::decode($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}, true);
                }
                if($preferences==Globals::DEFAULT_VAL_1 || $preferences==Globals::DEFAULT_VAL_0)
                {
                        $preferences = array();
                }
                $dataCard[Globals::FLD_NAME_NAME] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_NAME];
                $dataCard[Globals::FLD_NAME_NUMBER] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_NUMBER];
                $dataCard[Globals::FLD_NAME_MONTH] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_EXPIRE_MONTH];
                $dataCard[Globals::FLD_NAME_YEAR] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_EXPIRE_YEAR];
                $dataCard[Globals::FLD_NAME_CVV] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_CVV];
              
                $dataCard[Globals::FLD_NAME_TYPE] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_NUMBER_HIDDEN];
                $dataCard[Globals::FLD_NAME_PREFERENCE] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_PREFERENCE_HIDDEN];
                if(empty($preferences))
                {
                        $dataCard[Globals::FLD_NAME_PREFERENCE] = Globals::DEFAULT_VAL_1;
                }
                
               
                try
                {
                    $pay = new Payment;
                    if($card_id == Globals::DEFAULT_VAL_NULL)
                    {
                        if($model->{Globals::FLD_NAME_PAYMENT_CUSTOMER_ID})
                        {
                            $payerId = $model->{Globals::FLD_NAME_PAYMENT_CUSTOMER_ID};
                            $ccinfo = array(
                            'customerId' => $payerId,
                            "number" =>  $dataCard[Globals::FLD_NAME_NUMBER],
                            "expirationMonth" => $dataCard[Globals::FLD_NAME_MONTH],
                            "expirationYear" => $dataCard[Globals::FLD_NAME_YEAR],
                            "cvv" => $dataCard[Globals::FLD_NAME_CVV],
                            'cardholderName' => $dataCard[Globals::FLD_NAME_NAME]
                            );
                            $pay->creditCard = $ccinfo;
                            $result = $pay->createBtCreditCardAccount();
                            if($result)
                            {
                               // CommonUtility::pre($result);
                                //customer created successfully now update table
                                if($result['status'] == 'success')
                                {
                                        $model->{Globals::FLD_NAME_PAYMENT_CUSTOMER_ID} = $result['data']['creditCard']['customerId'];  
                                        $dataCard[Globals::FLD_NAME_TOKEN] = $result['data']['creditCard']['token'];  
                                }
                                else
                                {
                                    if($result['data']['errors'])
                                    {
                                        foreach( $result['data']['errors'] as $errorMsg )
                                        {
                                            if($errorMsg['attribute'] == 'expirationMonth')
                                            {
                                                $errorSrting['User_card_expire_month'] = $errorMsg['message'];
                                            }
                                            if($errorMsg['attribute'] == 'number')
                                            {
                                                $errorSrting['User_card_name'] = $errorMsg['message'];
                                            }
                                            if($errorMsg['attribute'] == 'cvv')
                                            {
                                                $errorSrting['User_card_cvv'] = $errorMsg['message'];
                                            }
                                            if($errorMsg['attribute'] == 'expirationYear')
                                            {
                                                $errorSrting['User_card_expire_year'] = $errorMsg['message'];
                                            }

                                        }
                                         if(!isset($errorSrting))
                                         $errorSrting['User_card_other_error'] = $errorMsg['message'];
                                      echo CJSON::encode($errorSrting);
                                       // {"User_card_name":["Card name cannot be blank."],"User_card_number":["Card number cannot be blank."],"User_card_expire_month":["Expiration must be greater than 'May \/ 2014'"]}
                                       Yii::app()->end();
                                    }
                                }
                            } 
                            else
                            {
                            throw new Exception(Yii::t('user_editaccountupdate','unexpected_error'));
                            }
                        
                        }
                        else
                        {
                            $payerId = CommonUtility::createPaymentCustomerId(Yii::app()->user->id, false, 6, '');
                            $userPayAccountCustomer = array(
                            'id' => $payerId ,
                            'firstName' => $model->{Globals::FLD_NAME_FIRSTNAME},
                            'lastName' => $model->{Globals::FLD_NAME_LASTNAME},
                            'company' => '',
                            'email' => $model->{Globals::FLD_NAME_PRIMARY_EMAIL},
                            'phone' => $model->{Globals::FLD_NAME_PRIMARY_PHONE},
                            'fax' => '',
                            'website' => ''
                            );
                            $userPayAccountBilling = array(
                            'firstName' =>    $model->{Globals::FLD_NAME_FIRSTNAME},
                            'lastName' =>     $model->{Globals::FLD_NAME_LASTNAME},
                            'company' => '',
                            'streetAddress' => $model->{Globals::FLD_NAME_BILLADDR_STREET1},
                            'extendedAddress' => $model->{Globals::FLD_NAME_BILLADDR_STREET2},
                            'locality' => '',
                            'region' => '',
                            'postalCode' => $model->{Globals::FLD_NAME_BILLADDR_ZIPCODE},
                            'countryCodeAlpha2' => $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE},
                            );

                            $userPayAccountCc = array(
                            "number" =>  $dataCard[Globals::FLD_NAME_NUMBER],
                            "expirationMonth" => $dataCard[Globals::FLD_NAME_MONTH],
                            "expirationYear" => $dataCard[Globals::FLD_NAME_YEAR],
                            "cvv" => $dataCard[Globals::FLD_NAME_CVV],
                            'cardholderName' => $dataCard[Globals::FLD_NAME_NAME]
                            );
                            $pay->customer = $userPayAccountCustomer;
                            $pay->creditCard = $userPayAccountCc;
                            $result = $pay->createBtCustomerAccount();

                            if($result)
                            {
                               //
                                //customer created successfully now update table
                                if($result['status'] == 'success')
                                {
                                        $model->{Globals::FLD_NAME_PAYMENT_CUSTOMER_ID} = $result['data']['customerId'];  
                                        $dataCard[Globals::FLD_NAME_TOKEN] = $result['data']['token'];  
                                }
                                else
                                {
                                    if($result['data']['errors'])
                                    {
                                        foreach( $result['data']['errors'] as $errorMsg )
                                        {
                                            if($errorMsg['attribute'] == 'expirationMonth')
                                            {
                                                $errorSrting['User_card_expire_month'] = $errorMsg['message'];
                                            }
                                            if($errorMsg['attribute'] == 'number')
                                            {
                                                $errorSrting['User_card_name'] = $errorMsg['message'];
                                            }
                                            if($errorMsg['attribute'] == 'cvv')
                                            {
                                                $errorSrting['User_card_cvv'] = $errorMsg['message'];
                                            }
                                            if($errorMsg['attribute'] == 'expirationYear')
                                            {
                                                $errorSrting['User_card_expire_year'] = $errorMsg['message'];
                                            }

                                        }
                                         if(!isset($errorSrting))
                                         $errorSrting['User_card_other_error'] = $errorMsg['message'];
                                      echo CJSON::encode($errorSrting);
                                       // {"User_card_name":["Card name cannot be blank."],"User_card_number":["Card number cannot be blank."],"User_card_expire_month":["Expiration must be greater than 'May \/ 2014'"]}
                                       Yii::app()->end();
                                    }
                                }
                            } 
                            else
                            {
                            throw new Exception(Yii::t('user_editaccountupdate','unexpected_error'));
                            }

                        }
                        $preferences[Globals::FLD_NAME_CARD][] = $dataCard;
                    }
                    else 
                    {  
                        $dataCard[Globals::FLD_NAME_TOKEN] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_TOKEN];
                        $ccinfo = array(
                        'token' => $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_TOKEN],
                        "number" =>  $dataCard[Globals::FLD_NAME_NUMBER],
                        "expirationMonth" => $dataCard[Globals::FLD_NAME_MONTH],
                        "expirationYear" => $dataCard[Globals::FLD_NAME_YEAR],
                        "cvv" => $dataCard[Globals::FLD_NAME_CVV],
                        'cardholderName' => $dataCard[Globals::FLD_NAME_NAME],
                        'options' => array(
                             'verifyCard' => true
                         )    
                        );
                        $pay->creditCard = $ccinfo;
                        $result = $pay->updateBtCreditCardAccount();
                        CommonUtility::pre($result);
                        if($result['status'] == 'success')
                        {
                               // CommonUtility::pre($result);
                                $model->{Globals::FLD_NAME_PAYMENT_CUSTOMER_ID} = $result['data']['creditCard']['customerId'];  
                                
                        }
                        else
                        {
                           // CommonUtility::pre($result);
                            if($result['data']['errors'])
                            {
                                foreach( $result['data']['errors'] as $errorMsg )
                                {
                                    if($errorMsg['attribute'] == 'expirationMonth')
                                    {
                                        $errorSrting['User_card_expire_month'] = $errorMsg['message'];
                                    }
                                    if($errorMsg['attribute'] == 'number')
                                    {
                                        $errorSrting['User_card_name'] = $errorMsg['message'];
                                    }
                                    if($errorMsg['attribute'] == 'cvv')
                                    {
                                        $errorSrting['User_card_cvv'] = $errorMsg['message'];
                                    }
                                    if($errorMsg['attribute'] == 'expirationYear')
                                    {
                                        $errorSrting['User_card_expire_year'] = $errorMsg['message'];
                                    }

                                }
                                if(!isset($errorSrting))
                                $errorSrting['User_card_other_error'] = $errorMsg['message'];
                                echo CJSON::encode($errorSrting);
                              // {"User_card_name":["Card name cannot be blank."],"User_card_number":["Card number cannot be blank."],"User_card_expire_month":["Expiration must be greater than 'May \/ 2014'"]}
                              Yii::app()->end();
                           }
                       }
                        $preferences[Globals::FLD_NAME_CARD][$card_id] = $dataCard;
                    }
                   // print_r($preferences);
                    $preferences = CJSON::encode( $preferences );
                    $model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING} = $preferences;
                    
                    try
                    {
                        $model->update();  
                    }
                    catch(Exception $e) {
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id, 'hideoutput' => true) );
                        throw new Exception(Yii::t('user_editaccountupdate','unexpected_error'));
                    }
                    
                    
                    $otherInfo = array( 
                                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_ACCOUNT_UPDATE,
                                        //  Globals::FLD_NAME_COMMENTS => '',
                                    );
                    try
                    {
                        CommonUtility::addUserActivity( Yii::app()->user->id , Globals::USER_ACTIVITY_TYPE_PROFILE_UPDATE , $otherInfo );
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                    $error = CJSON::encode(array( 'status'=>'success'));
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        if (CommonUtility::IsTraceEnabled())
                        {
                                Yii::trace('Executing actionContactInformation() method','UserController');
                        }
                       CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id, 'UserController' ) );
                        //Yii::log('User.EditAccountUpdate: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
                }    
            }
//            echo  $error;
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('EditAccountUpdate');
            }
	}
	public function actionEditPaypalAccountUpdate()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('EditPaypalAccountUpdate','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $model->scenario = Globals::PAYPAL_ACCOUNT_DETAIL;
            $error = Globals::DEFAULT_VAL_NULL;
            if(Yii::app()->request->isAjaxRequest)
            {
              $error =  CActiveForm::validate($model);
              if($error!=Globals::DEFAULT_VAL_NULL_ARRAY)
              {
			  	  CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                  echo $error;
                  Yii::app()->end();
              }
            }
            $this->performAjaxValidation($model);
            if(isset($_POST[Globals::FLD_NAME_USER]))
            {       
                @$paypal_id = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_PAYPAL_ID];
                $preferences=array();
                if(isset($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}))
                {
                    $preferences = CJSON::decode($model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}, true);
                }
                if($preferences==Globals::DEFAULT_VAL_1 || $preferences==Globals::DEFAULT_VAL_0)
                {
                    $preferences=array();
                }
                $dataCard[Globals::FLD_NAME_EMAIL] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_PAYPAL_EMAIL];
                $dataCard[Globals::FLD_NAME_PREFERENCE] =$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CARD_PREFERENCE_HIDDEN];
                if(empty($preferences))
                {
                    $dataCard[Globals::FLD_NAME_PREFERENCE] =Globals::DEFAULT_VAL_1;
                }
                if($paypal_id== Globals::DEFAULT_VAL_NULL)
                {
                    $preferences[Globals::FLD_NAME_PAYPAL][] = $dataCard;
                }
                else 
                {  
                    $preferences[Globals::FLD_NAME_PAYPAL][$paypal_id] = $dataCard;
                }
                $preferences = CJSON::encode( $preferences );
				//print_r($preferences);exit;
                $model->{Globals::FLD_NAME_CREDIT_ACCOUNT_SETTING}=$preferences;
                try
                {
                    try
                    {
                    $model->update();
                    }
                    catch (Exception $e){
                        $msg =$e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id, 'hideoutput' => true) );
                        throw new Exception(Yii::t('user_editpaypalaccountupdate','unexpected_error'));
                    }
//                    if(!$model->update())
//                    {
//                            throw new Exception(Yii::t('user_editpaypalaccountupdate','unexpected_error'));
//                    }
                    $otherInfo = array( 
                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_UPDATE_PAYAPL_ACCOUNT,
                        //  Globals::FLD_NAME_COMMENTS => '',
                    );
                    try
                    {
                        CommonUtility::addUserActivity( Yii::app()->user->id , Globals::USER_ACTIVITY_TYPE_PROFILE_UPDATE , $otherInfo );
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                    $error = CJSON::encode(array( 'status'=>'success'));
                }
                catch(Exception $e)
                {             
                        $msg = $e->getMessage();
                        if (CommonUtility::IsTraceEnabled())
                        {
                                Yii::trace('Executing actionContactInformation() method','UserController');
                        }
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ,'UserController' ) );
                        //Yii::log('User.EditPaypalAccountUpdate: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
                }    
            }
            echo  $error;
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('EditPaypalAccountUpdate');
            }
	}
        
        public function actionUploadPortfolioImage()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UploadPortfolioImage','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder = Globals::FRONT_USER_PORTFOLIO_TEMP_PATH;
            $allowedExtensions = Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES];// User Image allow
            $sizeLimit = Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE];// maximum file size in bytes'
            $fileNameSlugBefore = $model->{Globals::FLD_NAME_USER_ID}.Globals::DEFAULT_VAL_UNDERSCORE.time();
            $fileNameSlugAfter = Globals::FRONT_USER_TASK_IMAGE_NAME_SLUG;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder,false,$fileNameSlugBefore,$fileNameSlugAfter);
            $return = htmlspecialchars(CJSON::encode($result), ENT_NOQUOTES);
            $fileSize=filesize($folder.$result[Globals::FLD_NAME_FILENAME]);//GETTING FILE SIZE
            $fileName=$result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME
            
            echo $fileName;// it's array
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UploadPortfolioImage');
            }
        }
        public function actionUploadPortfolioVideo()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UploadPortfolioVideo','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder = Globals::FRONT_USER_PORTFOLIO_TEMP_PATH;
            $allowedExtensions = Yii::app()->params[Globals::FLD_NAME_ALLOW_VIDEOS];// User Image allow
            $sizeLimit = Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE];// maximum file size in bytes'
            $fileNameSlugBefore = $model->{Globals::FLD_NAME_USER_ID}.Globals::DEFAULT_VAL_UNDERSCORE.time();
            $fileNameSlugAfter = Globals::FRONT_USER_TASK_IMAGE_NAME_SLUG;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder,false,$fileNameSlugBefore,$fileNameSlugAfter);
            $return = htmlspecialchars(CJSON::encode($result), ENT_NOQUOTES);
            $fileSize=filesize($folder.$result[Globals::FLD_NAME_FILENAME]);//GETTING FILE SIZE
            $fileName=$result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME

            echo $fileName;// it's array
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UploadPortfolioVideo');
            }
        }
	public function actionCreditAccountSetting()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('CreditAccountSetting','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            $this->renderPartial('//partial/_account', array('model'=>$model),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('CreditAccountSetting');
            }
	}
	public function actionUserUpdateContactInformation()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserUpdateContactInformation','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            $this->renderPartial('//partial/_profile2', array('model'=>$model),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserUpdateContactInformation');
            }
	}
	public function actionUserUpdatePersonalInformation()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserUpdatePersonalInformation','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            $this->renderPartial('//partial/_updateprofile', array('model'=>$model),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserUpdatePersonalInformation');
            }
	}
	public function actionUserUpdateAboutUs()
	{   
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserUpdateAboutUs','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            $this->renderPartial('//partial/_aboutus', array('model'=>$model),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserUpdateAboutUs');
            }
	}
	public function actionUserUpdateSetting()
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserUpdateSetting','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.ui.timepicker.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            $this->render('//partial/_setting', array('model'=>$model),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserUpdateSetting');
            }
	}
	
	public function actionUserViewPortfolio()//add portfolio --mukul
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserViewPortfolio','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task = new Task();
            $taskCategory = new TaskCategory();
//            $taskReference = new TaskReference();
            $taskSpeciality = new TaskSpeciality();
            $this->performAjaxValidation($task);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
            //Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
            
            
            $this->renderPartial('//partial/_viewportfoliotabs', 
                            array(
                                            'model'=>$model,
                                            'task'=>$task,
                                            'taskCategory'=>$taskCategory,
//                                            'taskReference'=>$taskReference,
                                            'taskSpeciality'=>$taskSpeciality,
                                                    ),false,false);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserViewPortfolio');
            }
	}
        
	public function actionUserAddPortfolio()//add portfolio --mukul
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserAddPortfolio','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task = new Task();
             $task->scenario = Globals::ADD_PORTFOLIO;
            $taskCategory = new TaskCategory();
//            $taskReference = new TaskReference();
            $taskSpeciality = new TaskSpeciality();
            $this->performAjaxValidation($task);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            
            $this->renderPartial('//partial/_addportfolio', 
                            array(
                                            'model'=>$model,
                                            'task'=>$task,
                                            'taskCategory'=>$taskCategory,
//                                            'taskReference'=>$taskReference,
                                            'taskSpeciality'=>$taskSpeciality,
                                                    ),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserAddPortfolio');
            }
	}
        public function actionAddPortfolio()//add portfolio --mukul
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('AddPortfolio','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task = new Task();
//            $taskReference = new TaskReference();
            $task->scenario = Globals::ADD_PORTFOLIO;
            if(Yii::app()->request->isAjaxRequest)
            {
                $error =  CActiveForm::validate(array($task));
                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                {
                    CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                                    echo $error;
                    Yii::app()->end();
                }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK]))
            {
                
                $task->attributes=$_POST[Globals::FLD_NAME_TASK];
                try
                {
                     $task->{Globals::FLD_NAME_TASK_FINISHED_ON} = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON]);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                }
                if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                {
                    foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE] as $image)
                    {
                        $fileWithFolder = $model->profile_folder_name.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$image;
                        $attachment[Globals::FLD_NAME_TYPE]=Globals::DEFAULT_VAL_IMAGE_TYPE;
                        $attachment[Globals::FLD_NAME_FILE]=$fileWithFolder;
                        $attachment[Globals::FLD_NAME_UPLOAD_ON]= date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME);
                        try
                        {
                            CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->profile_folder_name.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                        }
                        $fileInfo[]=$attachment;
//                        CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
////                     
//                        CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
                    }
                }
                if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_VIDEO]))
                {
                    $video = $_POST[Globals::FLD_NAME_PORTFOLIO_VIDEO];
                    $attachment[Globals::FLD_NAME_TYPE]=Globals::DEFAULT_VAL_VIDEO_TYPE;
                    $attachment[Globals::FLD_NAME_FILE]=$model->profile_folder_name.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$video;
                    $attachment[Globals::FLD_NAME_UPLOAD_ON]= date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME);
                    try
                    {
                        CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->profile_folder_name.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$video);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                    $fileInfo[]=$attachment;
                }
                $images = CJSON::encode( $fileInfo );
                $task->{Globals::FLD_NAME_TASK_ATTACHMENTS}=$images;
                $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_F;
                $task->{Globals::FLD_NAME_IS_EXTERNAL} = Globals::DEFAULT_VAL_IS_EXTERNAL;
                $task->{Globals::FLD_NAME_REF_DONE_BY_NAME} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_REF_DONE_BY_NAME];
                $task->{Globals::FLD_NAME_REF_DONE_BY_PHONE} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_REF_DONE_BY_PHONE];
                $task->{Globals::FLD_NAME_REF_DONE_BY_EMAIL} = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_REF_DONE_BY_EMAIL];
                
                $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
                try
                {
                    
                        if(!$task->save())
                        {                            
                                throw new Exception(Yii::t('user_addportfolio','unexpected_error'));
                        }
                        $insertedId = $task->getPrimaryKey();
//                    $taskReference->{Globals::FLD_NAME_TASK_ID}=$insertedId;
//                    $taskReference->attributes=$_POST[Globals::FLD_NAME_TASK_REFERENCE];
//                    if( $taskReference->save())
//                    {
//                        $taskKey = $insertedId."/".$_POST[Globals::FLD_NAME_TASK_REFERENCE][Globals::FLD_NAME_REF_EMAIL];
//                        $confirmTask = Globals::FRONT_USER_CONFIRM_TASK_URL."?id=".CommonUtility::encrypt($taskKey);
                        try
                        {
                            $confirmTask = CommonUtility::getConfirmTaskURI($insertedId);
                            $to = $task->{Globals::FLD_NAME_REF_DONE_BY_EMAIL};
                            $subject = "Need varification for the job";
                            $message = "Need varification for the job for testing";
                            $body = "Please click on the to confirm the task <br/><a href='".$confirmTask."' target=_blank>".$confirmTask."</a>";
                            $sendMail = CommonUtility::SendMail($to,$subject,$message,$body);
                                
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                        }

                                        //echo CommonUtility::decrypt($str,Globals::ENCRYPTION_KEY); 
                        echo  $error = CJSON::encode(array(
                                                        'status'=>'save_success_message',
                                                        'confirmTaskUrl'=>$confirmTask
                                                        ));
//                    }
					
                    }
                    catch(Exception $e)
                    {             
                            $msg = $e->getMessage();
                            if (CommonUtility::IsTraceEnabled())
                            {
                                    Yii::trace('Executing actionContactInformation() method','UserController');
                            }
                            Yii::log('User.AddPortfolio: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
                    }    
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('AddPortfolio');
            }
        }
        public function actionUpdatePortfolio()//add portfolio --mukul
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UpdatePortfolio','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task_id = $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_ID];
            $task=Task::model()->findByPk($task_id);
//            $taskReference = TaskReference::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID=>$task_id));
//            $task->scenario = Globals::INSERT_NOTO;
            $task->scenario = Globals::ADD_PORTFOLIO;
            if(Yii::app()->request->isAjaxRequest)
            {
              $error =  CActiveForm::validate(array($task));
              if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
              {
		  CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                  echo $error;
                  Yii::app()->end();
              }
            }
            if(isset($_POST[Globals::FLD_NAME_TASK]))
            {
                
                $task->attributes=$_POST[Globals::FLD_NAME_TASK];
               // echo $_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON];
                try
                {
                    $task->{Globals::FLD_NAME_TASK_FINISHED_ON} = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,$_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_FINISHED_ON]);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                }
                $fileInfo = array();
                
                if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE]))
                {
                    foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE_REMOVE] as $image)
                    {
                        
                        if(!in_array($image, $_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                        {
                            //echo $image;
                            $filePath = Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR.$model->profile_folder_name."/".$image;
                            @unlink($filePath);
                        }
                    }
                }
                
               // exit;
                if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE]))
                {
                    foreach ($_POST[Globals::FLD_NAME_PORTFOLIO_IMAGE] as $image)
                    {
                        
                        $attachment[Globals::FLD_NAME_TYPE]=Globals::DEFAULT_VAL_IMAGE_TYPE;
                        $attachment[Globals::FLD_NAME_FILE]=$model->profile_folder_name.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$image;
                        $attachment[Globals::FLD_NAME_UPLOAD_ON]= date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME);
                        try
                        {
                            CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->profile_folder_name.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$image);
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                        }
                        $fileInfo[]=$attachment;
                    }
                }
                
                if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_VIDEO_REMOVE]))
                {
                    $videoOld=$_POST[Globals::FLD_NAME_PORTFOLIO_VIDEO_REMOVE];
                    if($videoOld != $_POST[Globals::FLD_NAME_PORTFOLIO_VIDEO])
                        {
                            //echo $image;
                            $videoPath = Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR.$model->profile_folder_name."/".$videoOld;
                            @unlink($videoPath);
                        }
                }
                //exit;
                if(isset($_POST[Globals::FLD_NAME_PORTFOLIO_VIDEO]))
                {
                    $video = $_POST[Globals::FLD_NAME_PORTFOLIO_VIDEO];
                    $attachment[Globals::FLD_NAME_TYPE]=Globals::DEFAULT_VAL_VIDEO_TYPE;
                    $attachment[Globals::FLD_NAME_FILE]=$model->profile_folder_name.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$video;
                    $attachment[Globals::FLD_NAME_UPLOAD_ON]= date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME);
                    try
                    {
                        CommonUtility::moveFileToNewLocation(Globals::FRONT_USER_PORTFOLIO_BASE_TEMP_PATH,Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$model->profile_folder_name.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR],$video);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id ) );
                    }
                    $fileInfo[]=$attachment;
                }
                $images = CJSON::encode( $fileInfo );
                $task->{Globals::FLD_NAME_TASK_ATTACHMENTS}=$images;
                $task->{Globals::FLD_NAME_CREATER_USER_ID} = Yii::app()->user->id;
                $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_F;
                $task->{Globals::FLD_NAME_LANGUAGE_CODE}=Yii::app()->params[Globals::FLD_NAME_DEFAULT_LANGUAGE];
				try
				{
					if(!$task->save())
					{   
						throw new Exception(Yii::t('user_updateportfolio','unexpected_error'));
					}
					$insertedId=$task->getPrimaryKey();
	//                    $taskReference->{Globals::FLD_NAME_TASK_ID}=$insertedId;
	//                    $taskReference->attributes=$_POST[Globals::FLD_NAME_TASK_REFERENCE];
	//                    if( $taskReference->save())
	//                    {
						  echo  $error = CJSON::encode(array(
									  'status'=>'save_success_message'
									));
	//                    }
				}
				catch(Exception $e)
				{             
					$msg = $e->getMessage();
					if (CommonUtility::IsTraceEnabled())
					{
						Yii::trace('Executing actionContactInformation() method','UserController');
					}
					Yii::log('User.UpdatePortfolio: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
				}    
			
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UpdatePortfolio');
            }
        }
        
        public function actionUserUpdatePortfolio()//add portfolio --mukul
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserUpdatePortfolio','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $task_id = $_GET[Globals::FLD_NAME_ID];
            $task = Task::model()->findByPk($task_id);
            $task->scenario = Globals::ADD_PORTFOLIO;
            //$taskReference = TaskReference::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
            $this->performAjaxValidation($task);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
	

            $this->renderPartial('//partial/_addportfolio', 
                            array(
                                    'model'=>$model,
                                    'task'=>$task,
                                   // 'taskReference'=>$taskReference,
                                ),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserUpdatePortfolio');
            }
        }
        
        public function actionUserDeletePortfolio()//manage status --mukul
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('UserDeletePortfolio','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $id=$_GET[Globals::FLD_NAME_ID];
            $task = Task::model()->findByPk($id);
            
            $attachments = $task->{Globals::FLD_NAME_TASK_ATTACHMENTS};
            $attachments=CJSON::decode($attachments);
            foreach ($attachments as $file)
            {
                $fileName = $file[Globals::FLD_NAME_FILE];
                $filePath = Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR.$file[Globals::FLD_NAME_FILE];
                @unlink($filePath);
                //CommonUtility::unlinkImages(Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR,$model->profile_folder_name,$fileName);
               //exit;
            }
            //$deletetaskRefrence = TaskReference::model()->deleteAll(Globals::FLD_NAME_TASK_ID.'=:id', array(':id' => $id));
            $deletetask = Task::model()->deleteAll(Globals::FLD_NAME_TASK_ID.'=:id', array(':id' => $id));
            try
			{
				if(!$model->update())
				{
					throw new Exception(Yii::t('user_contactinformation','unexpected_error'));
				}
				echo CHtml::encode(Yii::t('index_updateprofile_portfolio','txt_portfolio_delete_msg'));
            }
			catch(Exception $e)
			{             
				$msg = $e->getMessage();
				if (CommonUtility::IsTraceEnabled())
				{
					Yii::trace('Executing actionContactInformation() method','UserController');
				}
				Yii::log('User.ContactInformation: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
				
			}  
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('UserDeletePortfolio');
            }
                 
	}
    public function actionChangePublicStatus()//manage status --mukul
	{
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('ChangePublicStatus','application.controller.UserController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $status = $_GET[Globals::FLD_NAME_STATUS];
            $id=$_GET[Globals::FLD_NAME_ID];
            $task=Task::model()->findByPk($id);
            if(Yii::app()->request->isAjaxRequest)
            {
              $error =  CActiveForm::validate(array($task));
              if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
              {
                   CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                  echo $error;
                  Yii::app()->end();
              }
            }
            $success = $task->saveAttributes(array(Globals::FLD_NAME_IS_PUBLIC  => $status));
            try
            {
                if(!$success)
                {
                        throw new Exception(Yii::t('user_changepublicstatus','unexpected_error'));
                }
                echo CHtml::encode(Yii::t('index_updateprofile_portfolio','txt_portfolio_status_msg'));
            }
            catch(Exception $e)
            {             
                    $msg = $e->getMessage();
                    if (CommonUtility::IsTraceEnabled())
                    {
                            Yii::trace('Executing actionContactInformation() method','UserController');
                    }
                    Yii::log('User.ChangePublicStatus: reason:-'.$msg,CLogger::LEVEL_ERROR ,'UserController');
            }    
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('ChangePublicStatus');
            }
	}
    public function actionRemovePortfolioImage()//remove image  --mukul
	{
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::beginProfile('RemovePortfolioImage','application.controller.UserController.ajax');
                }
		$image=$_GET[Globals::DEFAULT_VAL_IMAGE_TYPE];
		@unlink(Globals::FOLDER_BACK_PATH.$image);
                if(CommonUtility::IsProfilingEnabled())
                {
                    Yii::endProfile('RemovePortfolioImage');
                }
	}
	protected function performAjaxValidation($model)
	{
		if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX] === Globals::DEFAULT_VAL_CONTACT_INFORMATION_FORM)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
    }
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	}
    public function actionfrontaccess()
    {
        CommonUtility::startProfiling();
        $model=new User('search');
        if (isset($_GET[Globals::FLD_NAME_USER_DATE_SESSION]))
        {
                Yii::app()->user->setState(Globals::FLD_NAME_USER_DATE_SESSION,(int)$_GET[Globals::FLD_NAME_USER_DATE_SESSION]);
                unset($_GET[Globals::FLD_NAME_USER_DATE_SESSION]); // would interfere with pager and repetitive page size change
        }

        $model->unsetAttributes();  // clear any default values
        if(isset($_GET[Globals::FLD_NAME_USER]))
                $model->attributes=$_GET[Globals::FLD_NAME_USER];


       
        $this->render('selectuser',array(
                'model'=>$model,
            
        ));
        CommonUtility::endProfiling();
    }
    public function actionselectusersession()
    {
        CommonUtility::startProfiling();
       
        if (isset($_GET[Globals::FLD_NAME_ID]))
        {
            Yii::app()->user->id = $_GET[Globals::FLD_NAME_ID] ;
        }
        $this->redirect(Yii::app()->createUrl('index/updateprofile'));

        CommonUtility::endProfiling();
    }
    
    public function actionSettings()
    {
        CommonUtility::startProfiling();
        $model = new User();
        $this->layout = '//layouts/noheader'; 
        $this->render('settings',array('model'=>$model));
        CommonUtility::endProfiling();
    }
    
    public function actionAccountSetting()
    {
        CommonUtility::startProfiling();
        $model = new User();
        $this->layout = '//layouts/noheader'; 
        $this->render('accounts',array('model'=>$model));
        CommonUtility::endProfiling();
    }
    
    public function actionChangePassword()
    {
        CommonUtility::startProfiling();
        
        if(!isset(Yii::app()->user->id))
        {
                $this->redirect(array('index/index'));
        }
        else
        {
                $this->pageTitle = MetaTag::INDEX_CHANGEPASSWORD_PAGE_TITLE;
                Yii::app()->clientScript->registerMetaTag(MetaTag::INDEX_CHANGEPASSWORD_PAGE_KEYWORD, 'keywords');
                Yii::app()->clientScript->registerMetaTag(MetaTag::INDEX_CHANGEPASSWORD_PAGE_DESCRIPTION, 'description');

                $model=$this->loadModel(Yii::app()->user->id);
                // Uncomment the following line if AJAX validation is needed
                $model->scenario=Globals::CHANGE_PASSWORD;
                $this->performAjaxValidation($model);
                if(isset($_POST[Globals::FLD_NAME_USER]))
                {
                    //print_r($_POST[Globals::FLD_NAME_USER]);
                        if(Yii::app()->request->isAjaxRequest)
                        {
                            $error =  CActiveForm::validate($model);
                            if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                            {
                                    CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                                    if($error!='[]')
                                    echo $error;
                                    Yii::app()->end();
                            }
                        }
                        $model->attributes=$_POST[Globals::FLD_NAME_USER];
                        $model->{Globals::FLD_NAME_PASSWORD}=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NEW_PASSWORD];
                        // $valid=$model->validate();
                        try
                        {
                                if(!$model->save())
                                {
                                        echo CJSON::encode(array(
                                                                                    'status'=>'not'
                                                        ));
                                        throw new Exception(Yii::t('user_changepassword','unexpected_error'));
                                }
                                $otherInfo = array( 
                                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_CHANGE_PASSWORD,
                                        //  Globals::FLD_NAME_COMMENTS => '',
                                    );
                                try
                                {
                                    CommonUtility::addUserActivity( Yii::app()->user->id , Globals::USER_ACTIVITY_TYPE_PROFILE_UPDATE , $otherInfo );
                                }
                                catch(Exception $e)
                                {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg($msg);
                                }
                                echo CJSON::encode(array(
                                            'status'=>'success'
                                ));
                                Yii::app()->end();
                                //Yii::app()->user->setFlash('success','Password change successfully.');
                                //$this->redirect(array('dashboard'));
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg($msg);
                        }   
                }
                $this->layout = '//layouts/noheader'; 
                $this->render('changepassword',array('model'=>$model),false,true);
        }
        CommonUtility::endProfiling();
    }
}