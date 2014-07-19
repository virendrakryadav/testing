<?php

class IndexController extends Controller
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
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('login','register','verify','index',),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                            'actions'=>array('selectuser','selectusersession','dashboard','updateprofilecontactinformation','updateimage','updatevideouser','playvideo','deleteschedule','editschedule'),
                            'users'=>array('@'),
                ),
//            array('deny',  // deny all users
//                'actions'=>array(),
//                'users'=>array('*'),
//            ),
        );
    }

    public function actions()
    {
        return array(
            'oauth' => array(
        // the list of additional properties of this action is below
        'class'=>'ext.hoauth.HOAuthAction',
        // Yii alias for your user's model, or simply class name, when it already on yii's import path
        // default value of this property is: User
        'model' => 'User', 
        // map model attributes to attributes of user's social profile
        // model attribute => profile attribute
        // the list of avaible attributes is below
        'attributes' => array(
          'contact_id' => 'email',
          'firstname' => 'firstName',
          'lastname' => 'lastName',
          'gender' => 'genderShort',
         // 'birthday' => 'birthDate',
          // you can also specify additional values, 
          // that will be applied to your model (eg. account activation status)
          'status' => 'a',
        ),
      ),
      // this is an admin action that will help you to configure HybridAuth 
      // (you must delete this action, when you'll be ready with configuration, or 
      // specify rules for admin role. User shouldn't have access to this action!)
      'oauthadmin' => array(
        'class'=>'ext.hoauth.HOAuthAdminAction',
      ),
        
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        
        if(CommonUtility::IsProfilingEnabled())
        {
           Yii::beginProfile('Index','application.controller.IndexController');
        }

        $this->pageTitle = MetaTag::INDEX_INDEX_PAGE_TITLE;
        Yii::app()->clientScript->registerMetaTag(MetaTag::INDEX_INDEX_PAGE_KEYWORD, 'keywords');
        Yii::app()->clientScript->registerMetaTag(MetaTag::INDEX_INDEX_PAGE_DESCRIPTION, 'description');
        Yii::app()->clientScript->registerCoreScript('yiiactiveform');
        $invitation = new InvitationEmail();
        
        // $this->layout = '//layouts/noheader';
        $this->render('index' , array('invitation' => $invitation));
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Index');
        }
    }
    public function actionKeepAlive()
    {
        echo 'OK';  
        Yii::app()->end();
    }
    public function actionDashboard()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Dashboard','application.controller.IndexController');
        }

        $this->pageTitle = MetaTag::INDEX_DASHBOARD_PAGE_TITLE;
        Yii::app()->clientScript->registerMetaTag(MetaTag::INDEX_DASHBOARD_PAGE_KEYWORD, 'keywords');
        Yii::app()->clientScript->registerMetaTag(MetaTag::INDEX_DASHBOARD_PAGE_DESCRIPTION, 'description');

        if(!isset(Yii::app()->user->id))
        {
            $this->redirect(array('index/index'));
        }
        else
        {
            $this->render('dashboard');
        }
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Dashboard');
        }
    }	
    
    
    public function actionUpdateImage()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('UpdateImage','application.controller.IndexController.ajax');
        }

        $model=$this->loadModel(Yii::app()->user->id);
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $folder = Globals::FRONT_USER_IMAGE_VIDEO_UPLOAD_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR];
        $allowedExtensions = Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES];// User Image allow
        $sizeLimit = Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE];// maximum file size in bytes'
        $fileNameSlugBefore = $model->{Globals::FLD_NAME_USER_ID}."_".time();
        $fileNameSlugAfter = Globals::FRONT_USER_USER_IMAGE_NAME_SLUG;
        
        
        //exit;
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder,false,$fileNameSlugBefore,$fileNameSlugAfter);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        $fileSize=filesize($folder.$result[Globals::FLD_NAME_FILENAME]);//GETTING FILE SIZE
        $fileName=$result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME
        $fileWithFolder = $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}."/".$fileName;
        if(!empty($model->{Globals::FLD_NAME_PROFILE_INFO}))
        {
            $profile_info = json_decode($model->{Globals::FLD_NAME_PROFILE_INFO}, true);
            $oldImage= $profile_info[Globals::FLD_NAME_PIC];
            try
            {
                CommonUtility::unlinkImages(Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH,$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME},$oldImage);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg($msg);
            }
            $profile_info[Globals::FLD_NAME_PIC]=$fileWithFolder;
        }
        else
        {
            $profile_info[Globals::FLD_NAME_PIC]=$fileWithFolder;
            $profile_info[Globals::FLD_NAME_VIDEO]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_URL]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_WEBURL]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_URL_ISPUBLIC]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_WEBURL_ISPUBLIC]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_VIDEO_ISPUBLIC]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_PIC_ISPUBLIC]=Globals::DEFAULT_VAL_NULL;
        }
        $profile_info = json_encode( $profile_info );
//        echo $fileWithFolder;
//        exit;
        try
        {
            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_DEFAULT,$fileWithFolder);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg($msg);
        }
        try
        {
            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35,$fileWithFolder);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg($msg);
        }
        try
        {
            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50,$fileWithFolder);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg($msg);
        }
        try
        {
            CommonUtility::createThumbnailImage(Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180,$fileWithFolder);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg($msg);
        }
        
        $imgPath = Globals::FRONT_USER_VIEW_IMAGE_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$fileName;
        Yii::app()->user->setState(Globals::FLD_NAME_USER_IMAGE,$imgPath);
        $model->{Globals::FLD_NAME_PROFILE_INFO}=$profile_info;
		try
		{
			if(!$model->update())
			{
				echo CJSON::encode(array(
							  'status'=>'not'
				));
				throw new Exception(Yii::t('index_updateimage','unexpected_error'));
			}
                        $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_IMAGE_CHANGE,
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
                        
			if (CommonUtility::IsDebugEnabled())
			{
				Yii::log('Successfully image uploaded', CLogger::LEVEL_INFO, 'IndexController.UpdateImage');
			}
		}
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg($msg);
                }
        
        echo $fileName;// it's array
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('UpdateImage');
        }
    }
         
    public function actionUpdateVideoUser()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('UpdateVideoUser','application.controller.IndexController.ajax');
        }

        $model=$this->loadModel(Yii::app()->user->id);
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $folder=Globals::FRONT_USER_IMAGE_VIDEO_UPLOAD_FLD_PATH.$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR];// folder for uploaded files
        $allowedExtensions = Yii::app()->params[Globals::FLD_NAME_ALLOW_VIDEOS];//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE];// maximum file size in bytes
        $fileNameSlugBefore = $model->{Globals::FLD_NAME_USER_ID}."_".time();
        $fileNameSlugAfter = Globals::FRONT_USER_USER_IMAGE_NAME_SLUG;
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder,false,$fileNameSlugBefore,$fileNameSlugAfter);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        $fileSize=filesize($folder.$result[Globals::FLD_NAME_FILENAME]);//GETTING FILE SIZE
        $fileName=$result[Globals::FLD_NAME_FILENAME];//GETTING FILE NAME
        if(!empty($model->{Globals::FLD_NAME_PROFILE_INFO}))
        {
            $profile_info = json_decode($model->{Globals::FLD_NAME_PROFILE_INFO}, true);
            $oldVideo = $profile_info[Globals::FLD_NAME_VIDEO];
            $profile_info[Globals::FLD_NAME_VIDEO]=$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}."/".$fileName;
            @unlink(Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$oldVideo);
            $profile_info = json_encode( $profile_info );
        }
        else
        {
            $profile_info[Globals::FLD_NAME_FILENAME]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_VIDEO]=$model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}."/".$fileName;
            $profile_info[Globals::FLD_NAME_URL]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_WEBURL]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_URL_ISPUBLIC]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_WEBURL_ISPUBLIC]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_VIDEO_ISPUBLIC]=Globals::DEFAULT_VAL_NULL;
            $profile_info[Globals::FLD_NAME_PIC_ISPUBLIC]=Globals::DEFAULT_VAL_NULL;
            $profile_info = json_encode( $profile_info );
        }
        $model->{Globals::FLD_NAME_PROFILE_INFO}=$profile_info;
        try
		{
			if(!$model->update())
			{
				echo CJSON::encode(array(
							  'status'=>'not'
				));
				throw new Exception(Yii::t('index_updatevideouser','unexpected_error'));
			}
			if (CommonUtility::IsDebugEnabled())
			{
				Yii::log('Successfully video uploaded', CLogger::LEVEL_INFO, 'IndexController.UpdateVideoUser');
			}
                        $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_VIDEO_CHANGE,
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
		}
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg($msg);
                }
        echo $return;// it's array
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('UpdateVideoUser');
        }
    }

    public function actionPlayVideo()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('PlayVideo','application.controller.IndexController.ajax');
        }
        @$url = $_REQUEST[Globals::FLD_NAME_URL];
        $videoPath = $url;
        @$path = $_REQUEST[Globals::FLD_NAME_PATH];
        @$video = $_REQUEST[Globals::FLD_NAME_VIDEO];
        if(isset($path) && isset($video) )
        {
            $setVideoPath = "..".$path.$video;
            if (file_exists($setVideoPath))
            {
                $videoPath = $path.$video;
            }
            else
            {
                $videoPath = $url;
            }
        }

        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        Yii::app()->clientScript->scriptMap['mediaelement-and-player.js'] = false;
        $this->renderPartial('playvideo',array('video'=>$videoPath),false,true);
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('PlayVideo');
        }
     }
	
    public function actionUpdateProfile()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('UpdateProfile','application.controller.IndexController');
        }
        if(!isset(Yii::app()->user->id))
        {
            $this->redirect(array('index/index'));
        }
        else
        {
            $user_id = Yii::app()->user->id;
            $notificationsetting = UserNotification::getNotificationByUserId($user_id);            
            
            
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile(Yii::app()->baseUrl."/js/chosen.jquery.js");
                
            $this->pageTitle = MetaTag::INDEX_UPDATEPROFILE_PAGE_TITLE;
            Yii::app()->clientScript->registerMetaTag(MetaTag::INDEX_UPDATEPROFILE_PAGE_KEYWORD, 'keywords');
            Yii::app()->clientScript->registerMetaTag(MetaTag::INDEX_UPDATEPROFILE_PAGE_DESCRIPTION, 'description');

            $model=$this->loadModel(Yii::app()->user->id);
            $task= new Task();
            $countryLocale= CountryLocale::model()->with('country')->findAll(array('order' => Globals::FLD_NAME_COUNTRY_PRIORITY));
            $notifications = new UserAlert();
            // Uncomment the following line if AJAX validation is needed
            $model->scenario=Globals::UPDATE_PROFILE;
            $this->performAjaxValidation($model);
			
            if(isset($_POST[Globals::FLD_NAME_USER]))
            {
                if(Yii::app()->request->isAjaxRequest)
                {
                        $error =  CActiveForm::validate($model);
                        if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                        {
                                // For logging 
                                CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                                echo $error;

                                Yii::app()->end();
                        }
                }
//            if(Yii::app()->request->isAjaxRequest)
//            {
//                if(!$model->validate())
//                {
//                            $error = CActiveForm::validate($model);
//                            if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
//                            {
//                                CommonUtility::setErrorLog($model->getErrors(),get_class($model));
//                                if($error!='[]')
//                                    echo $error;
//                                Yii::app()->end();
//                            }
//                    }
//            }
                $model->attributes=$_POST[Globals::FLD_NAME_USER];
               // $model->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
				
                $profileinfo = json_decode($model->{Globals::FLD_NAME_PROFILE_INFO});
                if(!empty($profileinfo))
                {
                    $profileinfo->{Globals::FLD_NAME_WEBURL} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_WEBURL];
                    $profileinfo->{Globals::FLD_NAME_WEBURL_ISPUBLIC} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_WEBURL_ISPUBLIC];
                    $profileinfo->{Globals::FLD_NAME_URL} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_URL];
                    $profileinfo->{Globals::FLD_NAME_URL_ISPUBLIC} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_URL_ISPUBLIC];
                }
                else
                {
                    $profileinfo[Globals::FLD_NAME_PIC] = Globals::DEFAULT_VAL_NULL;
                    $profileinfo[Globals::FLD_NAME_VIDEO] = Globals::DEFAULT_VAL_NULL;
                    $profileinfo[Globals::FLD_NAME_URL] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_URL];
                    $profileinfo[Globals::FLD_NAME_WEBURL] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_WEBURL];
                    $profileinfo[Globals::FLD_NAME_URL_ISPUBLIC] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_URL_ISPUBLIC];
                    $profileinfo[Globals::FLD_NAME_WEBURL_ISPUBLIC] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_WEBURL_ISPUBLIC];
                    $profileinfo[Globals::FLD_NAME_VIDEO_ISPUBLIC] = Globals::DEFAULT_VAL_NULL;
                    $profileinfo[Globals::FLD_NAME_PIC_ISPUBLIC] =  Globals::DEFAULT_VAL_NULL;
                }
                $model->{Globals::FLD_NAME_PROFILE_INFO} = json_encode($profileinfo);
				
				try
				{
					$sessionName = 'not';
					if(!$model->save())
					{
						throw new Exception(Yii::t('index_updateprofile','error to save user info'));
					}
                                        
                                        // Start for Update user search field
                                            CommonUtility::updateUserSearchField(Yii::app()->user->id);
                                        // End for Update user search field
                                        
					if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_FIRSTNAME] != Globals::DEFAULT_VAL_NULL)
					{
						Yii::app()->user->setState(Globals::FLD_NAME_USER_FULLNAME,$model->{Globals::FLD_NAME_FIRSTNAME}." ".$model->{Globals::FLD_NAME_LASTNAME});
						$sessionName = ''.$model->{Globals::FLD_NAME_FIRSTNAME}." ".$model->{Globals::FLD_NAME_LASTNAME}.'';
					}
                                        $otherInfo = array( 
                                                        Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_PROFILE_CHANGE,
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
                                                'status'=>'success',
                                            'sessionname'=>$sessionName,
					));
					if (CommonUtility::IsDebugEnabled())
					{
						Yii::log('Successfully Page submitted', CLogger::LEVEL_INFO, 'IndexController.UpdateProfile');
					}
					Yii::app()->end();
					
				}
                                catch(Exception $e)
                                {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg($msg);
                                }
            }
            
            $skills = Skill::getSkills();
            if(empty($skills))
            {
               $skills = array();   
            }
			//echo '<pre>';
			//print_r($skills);
			//echo '<pre>';
            //print_r($countryLocale);
            $this->render('updateprofile',array('model'=>$model,'task'=>$task, 'skills' => $skills , 'notifications' => $notifications,'countryLocale' => $countryLocale,'notificationsetting'=>$notificationsetting),false,true);
        }
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('UpdateProfile');
        }
    }

    public function actionAddressInfo()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('AddressInfo','application.controller.IndexController.ajax');
            }
            if(!isset(Yii::app()->user->id))
            {
                    $this->redirect(array('index/index'));
            }
            else
            {
                    $model=$this->loadModel(Yii::app()->user->id);
                    $model->scenario='addressinfo';
                    $this->performAjaxValidation($model);
                    if(isset($_POST[Globals::FLD_NAME_USER]))
                    {
                            if(Yii::app()->request->isAjaxRequest)
                            {
                                    if(!$model->validate())
                                    {
                                            $error = CActiveForm::validate($model);
                                            if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                                            {
                                                CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                                                if($error!='[]')
                                                echo $error;
                                                Yii::app()->end();
                                            }
                                    }
                            }
							
                            $model->attributes = $_POST[Globals::FLD_NAME_USER];

                            $model->{Globals::FLD_NAME_BILLADDR_STREET1} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_STREET1];
                            $model->{Globals::FLD_NAME_BILLADDR_STREET2} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_STREET2];
                            $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_COUNTRY_CODE];
                            $model->{Globals::FLD_NAME_BILLADDR_REGION_ID} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_REGION_ID];
                            $model->{Globals::FLD_NAME_BILLADDR_REGION_ISPUBLIC} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_REGION_ISPUBLIC];
                            $model->{Globals::FLD_NAME_BILLADDR_STATE_ID} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_STATE_ID];
                            $model->{Globals::FLD_NAME_BILLADDR_STATE_ISPUBLIC} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_STATE_ISPUBLIC];
                            $model->{Globals::FLD_NAME_BILLADDR_CITY_ID} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_CITY_ID];
                            $model->{Globals::FLD_NAME_BILLADDR_CITY_ISPRIVATE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_CITY_ISPRIVATE];
                            $model->{Globals::FLD_NAME_BILLADDR_ZIPCODE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_BILLADDR_ZIPCODE];
                            //print_r($model);
                            if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_ISSAME] != "1")
                            {
                                    $model->scenario='addressinfogeo';
                                    $model->{Globals::FLD_NAME_GEOADDR_ISSAME} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_ISSAME];

                                    $model->{Globals::FLD_NAME_GEOADDR_STREET1} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_STREET1];
                                    $model->{Globals::FLD_NAME_GEOADDR_STREET2} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_STREET2];
                                    $model->{Globals::FLD_NAME_GEOADDR_COUNTRY_CODE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_COUNTRY_CODE];
                                    $model->{Globals::FLD_NAME_GEOADDR_REGION_ID} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_REGION_ID];
                                    $model->{Globals::FLD_NAME_GEOADDR_REGION_ISPUBLIC} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_REGION_ISPUBLIC];
                                    $model->{Globals::FLD_NAME_GEOADDR_STATE_ID} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_STATE_ID];
                                    $model->{Globals::FLD_NAME_GEOADDR_STATE_ISPUBLIC} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_STATE_ISPUBLIC];
                                    $model->{Globals::FLD_NAME_GEOADDR_CITY_ID} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_CITY_ID];
                                    $model->{Globals::FLD_NAME_GEOADDR_CITY_ISPRIVATE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_CITY_ISPRIVATE];
                                    $model->{Globals::FLD_NAME_GEOADDR_ZIPCODE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_ZIPCODE];
                            }
                            if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_ISSAME] == "1")
                            {
                                    $model->{Globals::FLD_NAME_GEOADDR_ISSAME} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_GEOADDR_ISSAME];
                                    $model->{Globals::FLD_NAME_GEOADDR_STREET1} = Globals::DEFAULT_VAL_NULL;
                                    $model->{Globals::FLD_NAME_GEOADDR_STREET2} = Globals::DEFAULT_VAL_NULL;
                                    $model->{Globals::FLD_NAME_GEOADDR_COUNTRY_CODE} = Globals::DEFAULT_VAL_NULL;
                                    $model->{Globals::FLD_NAME_GEOADDR_REGION_ID} = Globals::DEFAULT_VAL_NULL;
                                    $model->{Globals::FLD_NAME_GEOADDR_REGION_ISPUBLIC} = Globals::DEFAULT_VAL_NULL;
                                    $model->{Globals::FLD_NAME_GEOADDR_STATE_ID} = Globals::DEFAULT_VAL_NULL;
                                    $model->{Globals::FLD_NAME_GEOADDR_STATE_ISPUBLIC} = Globals::DEFAULT_VAL_NULL;
                                    $model->{Globals::FLD_NAME_GEOADDR_CITY_ID} = Globals::DEFAULT_VAL_NULL;
                                    $model->{Globals::FLD_NAME_GEOADDR_CITY_ISPRIVATE} = Globals::DEFAULT_VAL_NULL;
                                    $model->{Globals::FLD_NAME_GEOADDR_ZIPCODE} = Globals::DEFAULT_VAL_NULL;
                            }
                            $countryName = "";
                            $regionName = "";
                            $stateName = "";
                            $cityName = "";
                            
                            try
                            {
                                $country = CountryLocale::getCountryByID( $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} );
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
                            if( $country )
                            {
                                $countryName = $country[0][Globals::FLD_NAME_COUNTRY_NAME];
                                $countryName .= " , ";
                            }
                            try
                            {
                                $region = RegionLocale::getRegionByID( $model->{Globals::FLD_NAME_BILLADDR_REGION_ID} );
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
                            if( $region )
                            {
                                $regionName = $region[0][Globals::FLD_NAME_REGION_NAME];
                                $regionName .= " , ";
                            }
                            try
                            {
                                $state = StateLocale::getStateById( $model->{Globals::FLD_NAME_BILLADDR_STATE_ID} );
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
                            if( $state )
                            {
                                $stateName = $state[0][Globals::FLD_NAME_STATE_NAME];
                                $stateName .= " , ";
                            }
                            try
                            {
                                $city = CityLocale::getCityByID( $model->{Globals::FLD_NAME_BILLADDR_CITY_ID} );
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
                            if( $city )
                            {
                                $cityName = $city[0][Globals::FLD_NAME_CITY_NAME];
                                $cityName .= " , ";
                            }
                           $address = $model->{Globals::FLD_NAME_BILLADDR_STREET1}.", ".$model->{Globals::FLD_NAME_BILLADDR_STREET2}.", ".
                            $cityName.$regionName.$stateName.$countryName;
                            $latlng = GoogleWebService::GetLatLon( $address );
                            $model->{Globals::FLD_NAME_LOCATION_LATITUDE} =  $latlng[Globals::FLD_NAME_LAT];
                            $model->{Globals::FLD_NAME_LOCATION_LONGITUDE} = $latlng[Globals::FLD_NAME_LNG];
                            //print_r( $latlng );
                            //$valid=$model->validate();
                           try
                            {
                                if(!$model->save())
                                {
                                        echo CJSON::encode(array(
                                                    'status'=>'error'
                                        ));
                                        throw new Exception(Yii::t('index_addressinfo','unexpected_error'));
                                }
                                $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_ADDRESS,
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
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }

                    }
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('AddressInfo');
            }
    }
	
	
    public function actionAboutUs()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('AboutUs','application.controller.IndexController.ajax');
            }

            if(!isset(Yii::app()->user->id))
            {
                    $this->redirect(array('index/index'));
            }
            else
            {             
//                 $for_search = "";
                 $model=$this->loadModel(Yii::app()->user->id);
                 $model->scenario=Globals::ABOUT_US;
                 
//                 $for_search = $model->for_search;
                 
                 $userspeciality = new UserSpeciality;
                 $certificateErr = 0;
                 $this->performAjaxValidation($model);
                 if(isset($_POST[Globals::FLD_NAME_USER]))
                 {
                        if(Yii::app()->request->isAjaxRequest)
                        {
                                if(!$model->validate())
                                {
                                        $error = CActiveForm::validate($model);
                                        if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                                        {
                                            CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                                                echo $error;
                                            Yii::app()->end();
                                        }
                                }
                        }
                      $aboutme[Globals::FLD_NAME_ABOUTME]=User::filterPostalCode($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_ABOUT_ME]);
                      for($CertfId=1;$CertfId <= $_POST[Globals::FLD_NAME_TOTAL_CERTF_ID];$CertfId++)
                      {       $insertInto = 1;
                              if(!empty($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CERTIFICATE_ID_.$CertfId][Globals::FLD_NAME_CERTIFICATE]))
                              {
                                  for($j=0;$j<=$_POST[Globals::FLD_NAME_TOTAL_CERTF_ID];$j++)
                                  {
                                     if(isset($aboutme[Globals::FLD_NAME_CERTIFICATE_VAL][$j]))
                                     {
                                          if( in_array(User::filterPostalCode($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CERTIFICATE_ID_.$CertfId][Globals::FLD_NAME_CERTIFICATE]), $aboutme[Globals::FLD_NAME_CERTIFICATE_VAL][$j]) &&
                                              in_array(User::filterPostalCode($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CERTIFICATE_ID_.$CertfId][Globals::FLD_NAME_CERTIFICATE_ID_OF]), $aboutme[Globals::FLD_NAME_CERTIFICATE_VAL][$j]))
                                          {
                                              $insertInto = 0;
                                              $certificateErr = 1;
                                          }
                                     }
                                  }
                                  if($insertInto==1)
                                  {
                                      $certificate[Globals::FLD_NAME_CERTIFICATE] = User::filterPostalCode($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CERTIFICATE_ID_.$CertfId][Globals::FLD_NAME_CERTIFICATE]);
                                      $certificate[Globals::FLD_NAME_CERTIFICATE_ID_OF] = User::filterPostalCode($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CERTIFICATE_ID_.$CertfId][Globals::FLD_NAME_CERTIFICATE_ID_OF]);
                                      //$certificateVal[] = $certificate;
                                      $aboutme[Globals::FLD_NAME_CERTIFICATE_VAL][] = $certificate;
                                  }
                              }
                      }
                      if(!isset($aboutme[Globals::FLD_NAME_CERTIFICATE_VAL]))
                      {
                          $aboutme[Globals::FLD_NAME_CERTIFICATE_VAL]=Globals::DEFAULT_VAL_NULL;
                      }
                      $aboutme = json_encode($aboutme);
 
                     @$skills = $_POST[Globals::FLD_NAME_MULTISKILLS.'user'];
                    /// print_r($skills);
                        if($skills)
                        {
                                UserSpeciality::model()->deleteAll('user_id=:id', array(':id' => Yii::app()->user->id));
//                                $getSkillNameForSearch = SkillLocale::getSkillByArray($skills);
                                foreach ($skills as $skill)
                                {
                                        $userSkill = new UserSpeciality();
                                        $userSkill->{Globals::FLD_NAME_USER_ID}  = Yii::app()->user->id;
                                        $userSkill->{Globals::FLD_NAME_SKILL_ID}  = $skill;
                                        $userSkill->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                        if(!$userSkill->save())
                                        {
                                                echo CJSON::encode(array(
                                                                                            'status'=>'not'
                                                                ));
                                                throw new Exception(Yii::t('index_aboutus','unexpected_error'));
                                        }
                                }
                        }
                       
                        @$locations = $_POST[Globals::FLD_NAME_MULTILOCATION];
                        if($locations)
                        {
                                UserWorkLocation::model()->deleteAll('user_id=:id', array(':id' => Yii::app()->user->id));
//                                $getLocationNameForSearch = CountryLocale::getLoactionByArray($locations);
                                foreach ($locations as $locations)
                                {
                                        $userLocation = new UserWorkLocation();
                                        $userLocation->{Globals::FLD_NAME_USER_ID}  = Yii::app()->user->id;
                                        $userLocation->{Globals::FLD_NAME_COUNTRY_CODE}  = $locations;
                                        $userLocation->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                                        if(!$userLocation->save())
                                        {
                                                echo CJSON::encode(array(
                                                                                            'status'=>'not'
                                                                ));
                                                throw new Exception(Yii::t('index_aboutus','unexpected_error'));
                                        }
                                }
                        }     
                      /*
                      //print_r($_POST['multiskills']);
                      $userSkill = UserSpeciality::model()->findAll('user_id=?',array(Yii::app()->user->id));

                      if(!empty($userSkill))
                      {
                           $totalSkill = count($userSkill);
                           for($skillsField=0;$skillsField<$totalSkill;$skillsField++)
                           {
                                   $array[] = $userSkill[$skillsField]->skill_id;
                           }
                      }
                      for($SkillsId=1; $SkillsId <= count($_POST[Globals::FLD_NAME_MULTISKILLS]);$SkillsId++)
                      {
                           $userAddSkill = UserSpeciality::model()->find('skill_id='.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SKILLS_ID.$SkillsId.Globals::FLD_NAME_SKILLS].' and user_id='.Yii::app()->user->id);
                           if(empty($userAddSkill))
                           {

                                $userspeciality->setIsNewRecord(true);
                                $userspeciality->{Globals::FLD_NAME_USER_ID}=Yii::app()->user->id;
                                $userspeciality->{Globals::FLD_NAME_SKILL_ID}=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SKILLS_ID.$SkillsId.Globals::FLD_NAME_SKILLS];
                                $userspeciality->{Globals::FLD_NAME_COUNTRY_CODE}=$model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE};
                                $userspeciality->{Globals::FLD_NAME_STATE_ID}=$model->{Globals::FLD_NAME_BILLADDR_STATE_ID};
                                $userspeciality->{Globals::FLD_NAME_REGION_ID}=$model->{Globals::FLD_NAME_BILLADDR_REGION_ID};
                                $userspeciality->{Globals::FLD_NAME_CITY_ID}=$model->{Globals::FLD_NAME_BILLADDR_CITY_ID};
                                $userspeciality->save();
                           }
                           unset( $array[array_search($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SKILLS_ID.$SkillsId.Globals::FLD_NAME_SKILLS], $array)] );
                      }
                      $array = array_values($array);
                      $totelRow = count($array);
                      for($deleteRow=0; $deleteRow < $totelRow; $deleteRow++)
                      {
                              $userDeleteSkill = UserSpeciality::model()->find('skill_id='.$array[$deleteRow].' and user_id ='.Yii::app()->user->id);
                              $userDeleteSkill->delete();
                      }*/
                      $model->attributes=$_POST[Globals::FLD_NAME_USER];
                      try
                      {
                        $model->{Globals::FLD_NAME_ABOUT_ME} = User::filterPostalCode($aboutme);
                      }
                      catch(Exception $e)
                      {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg($msg);
                      }
                      $model->{Globals::FLD_NAME_WORK_START_YEAR} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_WORK_START_YEAR];
                      $model->{Globals::FLD_NAME_TAGLINE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_TAGLINE];
                      $model->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
//                      $for_search = $getSkillNameForSearch.$getLocationNameForSearch;
//                      $model->for_search = $for_search;
                    try
                    {
                            if(!$model->save())
                            {
                                echo CJSON::encode(array(
                                                            'status'=>'not'
                                ));
                                throw new Exception(Yii::t('index_aboutus','unexpected_error'));
                            }
                            
                            // Start for Update user search field
                                CommonUtility::updateUserSearchField(Yii::app()->user->id);
                             // End for Update user search field
                            
                            $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_ABOUTUS,
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
                                'status'=>'success',
                                'certificateErr'=>$certificateErr

                         ));
                        Yii::app()->end();
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg($msg);
                    }
              }
         }
         if(CommonUtility::IsProfilingEnabled())
         {
             Yii::endProfile('AboutUs');
         }
    }

    public function actionSetting()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Setting','application.controller.IndexController.ajax');
            }
            if(!isset(Yii::app()->user->id))
            {
                    $this->redirect(array('index/index'));
            }
            else
            {
                    $model=$this->loadModel(Yii::app()->user->id);
                    $model->scenario=Globals::SETTING;
                    $this->performAjaxValidation($model);
                    if(isset($_POST[Globals::FLD_NAME_USER]))
                    {
                        if(Yii::app()->request->isAjaxRequest)
                        {
                                $error =  CActiveForm::validate($model);
                                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                                {
                                        // For logging 
                                        CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                                        echo $error;

                                        Yii::app()->end();
                                }
                        }
                        @$schedule_id = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SCHEDULE_ID];
                        //exit;
                            if(isset($model->{Globals::FLD_NAME_PREFERECES_SETTING}))
                            {
                                    $newarray = json_decode($model->{Globals::FLD_NAME_PREFERECES_SETTING}, true);
                            }
                            $model->attributes=$_POST[Globals::FLD_NAME_USER];
                            $model->{Globals::FLD_NAME_TIMEZONE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_TIMEZONE];
                            $model->{Globals::FLD_NAME_STARTUP_PAGE} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_STARTUP_PAGE];

                            $model->{Globals::FLD_NAME_NOTIFY_BY_SMS} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NOTIFY_BY_SMS];
                            $model->{Globals::FLD_NAME_NOTIFY_BY_EMAIL} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NOTIFY_BY_EMAIL];
                            $model->{Globals::FLD_NAME_NOTIFY_BY_CHAT} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NOTIFY_BY_CHAT];
                            $model->{Globals::FLD_NAME_NOTIFY_BY_FB} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NOTIFY_BY_FB];
                            $model->{Globals::FLD_NAME_NOTIFY_BY_TW} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NOTIFY_BY_TW];
                            $model->{Globals::FLD_NAME_NOTIFY_BY_GPLUS} = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NOTIFY_BY_GPLUS];
							$model->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;

                            $contact_by=Globals::DEFAULT_VAL_NULL;
                            if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CONTACT_BY_CHAT] == 1)
                            {
                                    $contact_by[]=Globals::DEFAULT_VAL_C;
                            }
                            if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CONTACT_BY_EMAIL] == 1)
                            {
                                    $contact_by[]=Globals::DEFAULT_VAL_E;
                            }
                            if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_CONTACT_BY_PHONE] == 1)
                            {
                                    $contact_by[]=Globals::DEFAULT_VAL_P;
                            }

                            /*$contact_by[]=Globals::DEFAULT_VAL_C;
                            $contact_by[]=Globals::DEFAULT_VAL_E;
                            $contact_by[]=Globals::DEFAULT_VAL_P;*/
                           // echo $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SELECT_DAYS];
                            if(isset($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SELECT_DAYS]))
                            {
                            if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SELECT_DAYS]==Globals::DEFAULT_VAL_ALL || $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SELECT_DAYS]==Globals::DEFAULT_VAL_DAYS )
                            {
                                $workDays=Globals::DEFAULT_VAL_NULL;
                                if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SELECT_DAYS]==Globals::DEFAULT_VAL_ALL)
                                {
                                    $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_MON;
                                    $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                    $workDays[]=$work;
                                    $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_TUE;
                                    $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                    $workDays[]=$work;
                                    $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_WED;
                                    $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                    $workDays[]=$work;
                                    $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_THU;
                                    $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                    $workDays[]=$work;
                                    $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_FRI;
                                    $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                    $workDays[]=$work;
                                    $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_SAT;
                                    $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                    $workDays[]=$work;
                                    $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_SUN;
                                    $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                    $workDays[]=$work;
                                }
                                else
                                {
                                   if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_MON]==1)
                                    {

                                        $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_MON;
                                        $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                        $workDays[]=$work;
                                    }
                                    if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_TUE]==1)
                                    {
                                        $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_TUE;
                                        $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                        $workDays[]=$work;
                                    }
                                    if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_WED]==1)
                                    {
                                        $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_WED;
                                        $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                        $workDays[]=$work;
                                    }
                                    if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_THU]==1)
                                    {
                                        $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_THU;
                                        $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                        $workDays[]=$work;
                                    }
                                    if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_FRI]==1)
                                    {
                                        $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_FRI;
                                        $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                        $workDays[]=$work;
                                    }
                                    if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SAT]==1)
                                    {
                                        $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_SAT;
                                        $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                        $workDays[]=$work;
                                    }
                                    if($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_SUN]==1)
                                    {
                                        $work[Globals::FLD_NAME_DAYS]=Globals::DEFAULT_VAL_SUN;
                                        $work[Globals::FLD_NAME_HRS]=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_START_TIME].Globals::DEFAULT_VAL_DASH.$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_END_TIME];
                                        $workDays[]=$work;
                                    }
                                }
                                if($schedule_id !=Globals::DEFAULT_VAL_NULL)
                                {
                                    $newarray[Globals::FLD_NAME_WORK_HRS][$schedule_id] = $workDays;
                                }
                                else
                                {
                                    $newarray[Globals::FLD_NAME_WORK_HRS][] = $workDays;
                                }
                            }
                            }
                            $newarray[Globals::FLD_NAME_CONTACT_BY] = $contact_by;
                            $newarray[Globals::FLD_NAME_REF_CHECK_BY] = $contact_by;
                            $newarray = json_encode($newarray);
                            //$prefereces = json_encode($prefereces);

                            //echo $prefereces;
                            //exit();
                            $model->{Globals::FLD_NAME_PREFERECES_SETTING} = $newarray;
                            $model->{Globals::FLD_NAME_NOTIFY_BY_GPLUS}= $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_NOTIFY_BY_GPLUS];
                            try
                            {
                                    if(!$model->save())
                                    {
                                            echo CJSON::encode(array(
                                                                                        'status'=>'not'
                                            ));
                                            throw new Exception(Yii::t('index_setting','unexpected_error'));
                                    }
                                    $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_SETTING,
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
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
                    }
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Setting');
            }
    }
    public function actionDeleteSchedule()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('DeleteSchedule','application.controller.IndexController.ajax');
            }

            $model=$this->loadModel(Yii::app()->user->id);
            @$schedule_id = $_GET[Globals::FLD_NAME_SCHEDULE_ID];
            if(isset($model->{Globals::FLD_NAME_PREFERECES_SETTING}))
            {
                    echo $model->{Globals::FLD_NAME_PREFERECES_SETTING};
                    $schedule = json_decode($model->{Globals::FLD_NAME_PREFERECES_SETTING}, true);
            }
            unset($schedule[Globals::FLD_NAME_WORK_HRS][$schedule_id]);
            $schedule = json_encode( $schedule );
            echo $model->{Globals::FLD_NAME_PREFERECES_SETTING}=$schedule;
            try
            {
                    if(!$model->update())
                    {   
                            echo CJSON::encode(array(
                                        'status'=>'not'
                            ));
                            throw new Exception(Yii::t('index_deleteschedule','unexpected_error'));
                    }    
                    $otherInfo = array( 
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_PROFILE_DELETE_SCHEDULE,
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
                    echo $error = CJSON::encode(array(
                                              'status'=>'success'
                                            ));
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg($msg);
            } 
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('DeleteSchedule');
            }
    }
    public function actionEditSchedule()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('EditSchedule','application.controller.IndexController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            @$schedule_id = $_GET[Globals::FLD_NAME_SCHEDULE_ID];
            if(isset($model->{Globals::FLD_NAME_PREFERECES_SETTING}))
            {
                    $model->{Globals::FLD_NAME_PREFERECES_SETTING};
                    $schedule = json_decode($model->{Globals::FLD_NAME_PREFERECES_SETTING}, true);
            }

            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.ui.timepicker.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;


            $this->renderPartial('scheduleform',array('model'=>$model,Globals::FLD_NAME_SCHEDULE_ID=>$schedule_id),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('EditSchedule');
            }
    }
    public function actionGetCertificatefield()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('GetCertificatefield','application.controller.IndexController.ajax');
            }
            $model=$this->loadModel(Yii::app()->user->id);
            $nextnum =  $_POST[Globals::FLD_NAME_NUM];
            $nextnum++;
            try
            {
                UtilityHtml::userGetCertificatefield($model,$nextnum,Globals::DEFAULT_VAL_NULL);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg($msg);
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('GetCertificatefield');
            }
    }

    public function actionGetSkillsfield()
    {
            Yii::beginProfile('GetSkillsfield','application.controller.IndexController.ajax');

            $model=$this->loadModel(Yii::app()->user->id);
            $nextnum =  $_POST[Globals::FLD_NAME_NUM];
            $nextnum++;
            try
            {
                UtilityHtml::userGetSkillsfield($model,$nextnum);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg($msg);
            }
            Yii::endProfile('GetSkillsfield');
    }

    public function actionChangePassword()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('ChangePassword','application.controller.IndexController');
            }

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
                    $this->render('changepassword',array('model'=>$model),false,true);
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('ChangePassword');
            }
    }

    public function actionRegister()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Register','application.controller.IndexController.ajax');
            }
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            if(isset(Yii::app()->user->id))
            {
                    $this->redirect(array('index/dashboard'));
            }
            else
            {
                
                    $model= new User;
                    $contact = new UserContact;
                    $model->scenario = Globals::REGISTER;
                    $this->performAjaxValidation($model);
                    if(isset($_POST[Globals::FLD_NAME_USER]))
                    {
                            if(Yii::app()->request->isAjaxRequest)
                            {
                                $error =  CActiveForm::validate($model);
                                if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                                {
                                    CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                                    echo $error;
                                    Yii::app()->end();
                                }
                            }
                            $model->attributes=$_POST[Globals::FLD_NAME_USER];
                            $contact->{Globals::FLD_NAME_CONTACT_ID}=$_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL];
                            $contact->{Globals::FLD_NAME_CONTACT_TYPE} = Globals::DEFAULT_VAL_E_CAP;
                            $contact->{Globals::FLD_NAME_IS_PRIMARY} =Globals::DEFAULT_VAL_1;
                            $contact->{Globals::FLD_NAME_IS_LOGIN_ALLOWED} =Globals::DEFAULT_VAL_1;
                            $contact->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                            $model->{Globals::FLD_NAME_IS_VERIFIED} = Globals::DEFAULT_VAL_0;
//                             $model->{Globals::FLD_NAME_IS_VERIFIED} = 1;
//                             $model->status = 'a';
                            $model->{Globals::FLD_NAME_SOURCE_APP}  = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                            $location = City::getCity();
                            if($location)
                            {
                                    $model->{Globals::FLD_NAME_COUNTRY_CODE} = $location[Globals::FLD_NAME_COUNTRY_CODE];
                                    $model->{Globals::FLD_NAME_STATE_ID} = $location[Globals::FLD_NAME_STATE_ID];
                                    $model->{Globals::FLD_NAME_REGION_ID} = $location[Globals::FLD_NAME_REGION_ID];
                                    $model->{Globals::FLD_NAME_CITY_ID} = $location[Globals::FLD_NAME_CITY_ID];
                                    $model->{Globals::FLD_NAME_COUNTRY_CODE} = $location[Globals::FLD_NAME_COUNTRY_CODE];
                                    $model->{Globals::FLD_NAME_STATE_ID} = $location[Globals::FLD_NAME_STATE_ID];
                                    $model->{Globals::FLD_NAME_REGION_ID} = $location[Globals::FLD_NAME_REGION_ID];
                                    $model->{Globals::FLD_NAME_CITY_ID} = $location[Globals::FLD_NAME_CITY_ID];
                            }
                            $model->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}=rand(Globals::DEFAULT_VAL_START_RAND, Globals::DEFAULT_VAL_END_RAND);
                            $dataEmail[Globals::FLD_NAME_E] = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL];
                            $dataEmail[Globals::FLD_NAME_TYPE] = Globals::DEFAULT_VAL_P;
                            $data[Globals::FLD_NAME_EMAILS][] = $dataEmail;
                            $data = json_encode( $data );
                            $model->{Globals::FLD_NAME_CONTACT_INFO}=$data;
                            //$valid=$model->validate();
                            // Code for email
                            //end
                            try
                            {
                                $verificationcode = CommonUtility::generateVerificationCode();
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
                            $timestamp = date('Y-m-d H:i:s',time());
                            $model->{Globals::FLD_NAME_VERIFICATION_CODE}  = $verificationcode;
                            try
                            {
                                    if(!$model->save())
                                    {
                                            echo CJSON::encode(array(
                                                   'status'=>'not'
                                                    ));
                                            throw new Exception(Yii::t('index_register','unexpected_error'));
                                    }
                                    $insertId = $model->getPrimaryKey();
                                    //Start for notification setting
                                    
                                    $notificationsetting = Notification::model()->findall();
                                    $totlenot = count($notificationsetting);
                                    if($totlenot > 0)
                                    {
                                        $i=1;
                                        foreach($notificationsetting as $notificationsettings)
                                        {
                                            $usernotificationsetting[$i] = new UserNotification();
                                            $usernotificationsetting[$i]->notification_id = $notificationsettings['notification_id'];
                                            $usernotificationsetting[$i]->user_id = $insertId;
                                            $usernotificationsetting[$i]->save();
                                            $i++;
                                        }
                                    }                                                                        
                                    //End for notification setting
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
                            $contact->{Globals::FLD_NAME_USER_ID}  = $model->primaryKey;
                            try
                            {
                                if(!$contact->save())
                                {
                                        echo CJSON::encode(array(
                                                    'status'=>'not'
                                                                ));
                                        throw new Exception(Yii::t('index_register','unexpected_error'));
                                }
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }

                            
                            $otherInfo = array( 
                                    Globals::FLD_NAME_ACTIVITY_SUBTYPE => Globals::USER_ACTIVITY_SUBTYPE_REGISTER,
                                    //  Globals::FLD_NAME_COMMENTS => '',
                                );
                            try
                            {
                                CommonUtility::addUserActivity( $insertId , Globals::USER_ACTIVITY_SUBTYPE_REGISTER , $otherInfo );
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
 //                                   Register Mail part start here                                    
                                    
                            $encrypt_ver_code = Yii::app()->getSecurityManager()->encrypt($verificationcode);
                            $encrypt_email = Yii::app()->getSecurityManager()->encrypt($_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL]);
                            $encrypt_timestamp = Yii::app()->getSecurityManager()->encrypt($timestamp);                          
                            $userLink = Yii::app()->createAbsoluteUrl("index/verify",array("email"=>$encrypt_email,"verificationcode"=>$encrypt_ver_code,"t"=>$encrypt_timestamp));  
                            try
                            {
                                $to = $_POST[Globals::FLD_NAME_USER][Globals::FLD_NAME_EMAIL];
                                $subject = Globals::MAIL_REGISTER_CONFIRMATION;
                                $message = $userLink;
                                try
                                {
                                    $body = CommonUtility::mailBodyForRegister($userLink);
                                }
                                catch(Exception $e)
                                {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg($msg);
                                }
                                try
                                {
                                    //$sendMail = CommonUtility::SendMail($to,$subject,$message,$body);   
                                }
                                catch(Exception $e)
                                {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg($msg);
                                }

                                if($sendMail==1) 
                                {
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
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
                            if (CommonUtility::IsDebugEnabled())
                            {
                                    Yii::log('User register successfully', CLogger::LEVEL_INFO, 'IndexController.Register');
                            }
                            
                            Yii::app()->end();
                    }        
            }
            $this->renderPartial('register',array(
                    'model'=>$model,
                    'contact'=>$contact),false,true);
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Register');
            }
    }
    
    public function actionVerify()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Verify','application.controller.IndexController');
        }
        if($_GET[Globals::FLD_NAME_EMAIL]!='')
        {
            $encrypt_email = $_GET[Globals::FLD_NAME_EMAIL];                        
        }
        if($_GET[Globals::FLD_NAME_VERIFICATIONCODE])
        {
            $encrypt_ver_code = $_GET[Globals::FLD_NAME_VERIFICATIONCODE];                        
        }
        if($_GET['t'])
        {
            $encrypt_timestamp = $_GET['t'];                     
        }
        $verificationcode = Yii::app()->getSecurityManager()->decrypt($encrypt_ver_code);
        $email = Yii::app()->getSecurityManager()->decrypt($encrypt_email);
        $timestamp = date('Y-m-d H:i:s',strtotime(Yii::app()->getSecurityManager()->decrypt($encrypt_timestamp)));  
        
        //$user = new User;
        try
        {
            $model = UserContact::findByEmailWithdetail($email);            
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg($msg);
        }
        //$model->user->{Globals::FLD_NAME_IS_VERIFIED} = Globals::DEFAULT_VAL_1;
        
        $currenttime = date("Y-m-d H:i:s");                            
        $expiry_time = date('Y-m-d H:i:s', strtotime($timestamp .'+'.Globals::DEFAULT_HOURS_FOR_RESETPASSWORD_MAIL));  
        if($model->user->{Globals::FLD_NAME_IS_VERIFIED} == 1)
        {
            $this->render('verify',array('msg'=>CHtml::encode(Yii::t('index_register','txt_your_registration_link_has_been_expired'))));
        }
        else
        {
            if($currenttime > $expiry_time)
            {
                try
                {
                    $verificationcode = CommonUtility::generateVerificationCode();
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg($msg);
                }
                $timestamp = date('Y-m-d H:i:s',time());
            // $model->{Globals::FLD_NAME_VERIFICATION_CODE}  = $verificationcode;
                User::model()->updateByPk($model->user->{Globals::FLD_NAME_USER_ID}, array(
                    Globals::FLD_NAME_VERIFICATION_CODE => $verificationcode,

                ));
    //                                   Register Mail part start here                                    

                $encrypt_ver_code = Yii::app()->getSecurityManager()->encrypt($verificationcode);
                $encrypt_email = Yii::app()->getSecurityManager()->encrypt($model->{Globals::FLD_NAME_CONTACT_ID});
                $encrypt_timestamp = Yii::app()->getSecurityManager()->encrypt($timestamp);                          
                $userLink = Yii::app()->createAbsoluteUrl("index/verify",array("email"=>$encrypt_email,"verificationcode"=>$encrypt_ver_code,"t"=>$encrypt_timestamp));  

                $to = $model->{Globals::FLD_NAME_CONTACT_ID};
                $subject = Globals::MAIL_REGISTER_CONFIRMATION;
                $message = $userLink;
                try
                {
                    $body = CommonUtility::mailBodyForRegister($userLink);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg($msg);
                }
                $msg = CHtml::encode(Yii::t('index_register','txt_your_registration_link_has_been_expired_send_mail_again'));
                $this->render('verify',array('msg'=>$msg,'to' => $to,'subject' => $subject,'message' => $message,'body' => $body));
            }
            else
            {
                if($model->user->{Globals::FLD_NAME_VERIFICATION_CODE} == $verificationcode)
                {
                    User::model()->updateByPk($model->user->{Globals::FLD_NAME_USER_ID}, array(
                        Globals::FLD_NAME_IS_VERIFIED => Globals::DEFAULT_VAL_1,
                        Globals::FLD_NAME_STATUS => Globals::DEFAULT_VAL_ACTIVE_STATUS_ALFABET,

                    ));
                    $this->render('verify',array('msg'=>CHtml::encode(Yii::t('index_register','txt_you_are_verified'))));
                }
                else
                {
                    $this->render('verify',array('msg'=>CHtml::encode(Yii::t('index_register','txt_not_success'))));
                }  
            }
        }
       
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Verify');
        }
    }
    public function actionLogin()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Login','application.controller.IndexController.ajax');
            }
            
            if(isset(Yii::app()->user->id))
            {
                    $this->redirect(array('index/dashboard'));
            }
            else
            {
                    $model=new FrontLoginForm;
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                    //print_r($_POST);exit;
                    // if it is ajax validation request
                    if(isset($_POST[Globals::FLD_NAME_AJAX]) && $_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_LOGIN_FORM)
                    {
                            echo CActiveForm::validate($model);
                            Yii::app()->end();
                    }

                    // collect user input data
                    if(isset($_POST[Globals::FLD_NAME_FRONT_LOGIN_FORM]))
                    {
                            $model->attributes=$_POST[Globals::FLD_NAME_FRONT_LOGIN_FORM];
                            //print_r($_POST);exit;
                            $currentPage = $_POST[Globals::FLD_NAME_CURRENT_PAGE];
                            if($model->validate())
                            {
                               /*print_r($model->login());
                               exit();*/
                            if($model->login() == Globals::ERROR_NONE)
                               {
                                      $cookieUsernameFront = new CHttpCookie(Globals::FLD_NAME_FRONT_USER_NAME, $_POST[Globals::FLD_NAME_FRONT_LOGIN_FORM][Globals::FLD_NAME_EMAIL]);
                                      $cookiePasswordFront = new CHttpCookie(Globals::FLD_NAME_FRONT_USER_PASSWORD, $_POST[Globals::FLD_NAME_FRONT_LOGIN_FORM][Globals::FLD_NAME_PASSWORD]);
                                      $cookierememberMeFront = new CHttpCookie(Globals::FLD_NAME_FRONT_USER_REMEMBER_ME, $_POST[Globals::FLD_NAME_FRONT_LOGIN_FORM][Globals::FLD_NAME_REMEMBER_ME]);
                                      if($_POST[Globals::FLD_NAME_FRONT_LOGIN_FORM][Globals::FLD_NAME_REMEMBER_ME] == Globals::DEFAULT_VAL_1)
                                        {
                                                $cookieUsernameFront->expire = time() + (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
                                                $cookiePasswordFront->expire = time() + (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
                                                $cookierememberMeFront->expire = time() + (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days

                                                Yii::app()->request->cookies[Globals::FLD_NAME_FRONT_USER_NAME] = $cookieUsernameFront;
                                                Yii::app()->request->cookies[Globals::FLD_NAME_FRONT_USER_PASSWORD] = $cookiePasswordFront;
                                                Yii::app()->request->cookies[Globals::FLD_NAME_FRONT_USER_REMEMBER_ME] = $cookierememberMeFront;
                                        }
                                        else
                                        {
                                                $cookieUsernameFront->expire = time() - (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
                                                $cookiePasswordFront->expire = time() - (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
                                                $cookierememberMeFront->expire = time() - (Globals::DEFAULT_VAL_3600*Globals::DEFAULT_VAL_24*Globals::DEFAULT_VAL_30); // 30 days
                                                Yii::app()->request->cookies[Globals::FLD_NAME_FRONT_USER_NAME] = $cookieUsernameFront;
                                                Yii::app()->request->cookies[Globals::FLD_NAME_FRONT_USER_PASSWORD] = $cookiePasswordFront;
                                                Yii::app()->request->cookies[Globals::FLD_NAME_FRONT_USER_REMEMBER_ME] = $cookierememberMeFront;
                                        }
                                        //do anything here
                                        try
                                        {
                                            CommonUtility::addUserActivity( Yii::app()->user->id , Globals::USER_ACTIVITY_TYPE_LOGIN  );
                                        }
                                        catch(Exception $e)
                                        {             
                                            $msg = $e->getMessage();
                                            CommonUtility::catchErrorMsg($msg);
                                        }
                                        if($currentPage == Yii::app()->createUrl('index/index'))
                                        {
                                            $location = Yii::app()->createUrl('index/dashboard');
                                        }
                                        else
                                            $location = $currentPage;
                                       //echo $location;exit;
                                             echo CJSON::encode(array(
                                                      'errorCode'=>'success',
                                                      'location' => $location,
                                             ));
                                             if (CommonUtility::IsDebugEnabled())
                                            {
                                                Yii::log('User login successfully', CLogger::LEVEL_INFO, 'IndexController.Login');
                                            }
                               }
                            else{
                                 
								  if (CommonUtility::IsDebugEnabled())
									{ 
									if($model->login() == Globals::ERROR_EMAIL_INVALID)
									{
										$str = Globals::EMAIL_INVALID_MSG;
									}
									elseif($model->login() == Globals::ERROR_PASSWORD_INVALID)
									{
										$str = Globals::PASSWORD_INVALID_MSG;
									}
									elseif($model->login() == Globals::ERROR_STATUS_DEACTIVE)
									{
										$str = Globals::STATUS_DEACTIVE_MSG;
									}
									//$str = "[".$model->login()."]";
									  $str.= "[".$_POST[Globals::FLD_NAME_FRONT_LOGIN_FORM][Globals::FLD_NAME_EMAIL]."]";
									  //$str.= "[".$_POST[Globals::FLD_NAME_FRONT_LOGIN_FORM][Globals::FLD_NAME_PASSWORD]."]";
									  if (CommonUtility::IsTraceEnabled())
									  {
										  Yii::trace('Executing actionLogin() method','IndexController');
									  }
									  Yii::log($str,CLogger::LEVEL_ERROR ,'IndexController.login');
									}
								  
								  echo CJSON::encode(array(
                                          	'errorCode'=>$model->login()
                                             ));
                               }
                             Yii::app()->end();
                            }
                            else
                            {
                                    $error = CActiveForm::validate($model);
                                    if($error!='[]')
                                            echo $error;
                                    Yii::app()->end();
                            }
                    }
                    // display the login form
                    $this->renderPartial('login',array('model'=>$model),false,true);
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Login');
            }
    }

    
    public function actionForgotPassword()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('Forgotpassword','application.controller.IndexController.ajax');
        }
        $model= new User;
        //Generate New Password
        try
        {
            $verificationcode = CommonUtility::generateVerificationCode();
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg($msg);
        }
        $timestamp = date('Y-m-d H:i:s',time());
        //echo $verificationcode;
        $model->scenario=Globals::FORGOT_PASSWORD;
        $this->performAjaxValidation($model);
        if(isset($_POST[Globals::FLD_NAME_USER]))
        {
                $model->attributes=$_POST[Globals::FLD_NAME_USER];
                $valid=$model->validate();
                $user = User::model()->with('usercontact')->find('usercontact.contact_id=?',array($model->{Globals::FLD_NAME_EMAIL}));
                if($valid)
                {
                        if($user)
                        {
                            //$user->
//                            echo $verificationcode;
                            $user->{Globals::FLD_NAME_VERIFICATION_CODE}= $verificationcode;
                            try
                            {
                                if(!$user->update())
                                {
                                    echo CJSON::encode(array(
                                        'status'=>'not'
                                    ));
                                    //throw new Exception(Yii::t('index_forgotpassword','unexpected_error'));
                                }
                            }
                            catch(Exception $e)
                            {
                                $msg = $e->getMessage();
                                if (CommonUtility::IsTraceEnabled())
                                {
                                        Yii::trace('Executing actionForgotpassword() method','IndexController');
                                }
                                Yii::log('Index.Forgotpassword: reason:-'.$msg,CLogger::LEVEL_ERROR ,'IndexController');
                            }
                            
//                            $encrypt_ver_code = trim(CommonUtility::encrypt_decrypt('encrypt', base64_encode($verificationcode)));
//                            $encrypt_email = trim(CommonUtility::encrypt_decrypt('encrypt', base64_encode($user->usercontact['contact_id'])));
//                            $encrypt_timestamp = trim(CommonUtility::encrypt_decrypt('encrypt', base64_encode($timestamp)));
//                            $encrypt_ver_code = base64_encode($verificationcode);
//                            $encrypt_email = base64_encode($user->usercontact['contact_id']);
//                            $encrypt_timestamp = base64_encode($timestamp);
                            $encrypt_ver_code = Yii::app()->getSecurityManager()->encrypt($verificationcode);
                            $encrypt_email = Yii::app()->getSecurityManager()->encrypt($user->usercontact[Globals::FLD_NAME_CONTACT_ID]);
                            $encrypt_timestamp = Yii::app()->getSecurityManager()->encrypt($timestamp);                          
                            $userLink = Yii::app()->createAbsoluteUrl("index/resetpassword",array("email"=>$encrypt_email,"verificationcode"=>$encrypt_ver_code,"t"=>$encrypt_timestamp));  
                            
                            // $user->password = $newPassword;
                            try
                            {
                                $to = $user->usercontact[Globals::FLD_NAME_CONTACT_ID];
                                $subject = Globals::MAIL_RESET_PASSWORD;
                                $message = $userLink;
                                try
                                {
                                    $body = CommonUtility::mailBody($userLink);
                                }
                                catch(Exception $e)
                                {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg($msg);
                                }
                                try
                                {
                                    $sendMail = CommonUtility::SendMail($to,$subject,$message,$body);
                                }
                                catch(Exception $e)
                                {             
                                    $msg = $e->getMessage();
                                    CommonUtility::catchErrorMsg($msg);
                                }
                                //echo $sendMail;exit;
                                if($sendMail==1)
                                {
                                    echo CJSON::encode(array(
                                        'status'=>'success'
                                    ));
                                }
                                else
                                {
                                    echo CJSON::encode(array(
                                        'status'=>'not'
                                    ));
                                    throw new Exception(Yii::t('index_forgotpassword','unexpected_error'));
                                }
                            }
                            catch(Exception $e)
                            {             
                                    $msg = $e->getMessage();
                                    if (CommonUtility::IsTraceEnabled())
                                    {
                                            Yii::trace('Executing actionForgotpassword() method','IndexController');
                                    }
                                    Yii::log('Index.Forgotpassword: reason:-'.$msg,CLogger::LEVEL_ERROR ,'IndexController');
                            }    

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
                            CommonUtility::setErrorLog($model->getErrors(),get_class($model));
                            $error = CActiveForm::validate($model);
                            if($error!='[]')
                                    echo $error;
                            Yii::app()->end();
                        }
        }
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        //Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            $this->renderPartial('forgotpassword',array('model'=>$model),false,true);
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('Forgotpassword');
        }
	
    }
public function actionResetPassword()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('ResetPassword','application.controller.IndexController.ajax');
            }

            if(isset(Yii::app()->user->id))
            {
                    $this->redirect(array('index/dashboard'));
            }
            else
            {
                $model = new User;
                $resetPassword= new ResetPasswordForm;
                $contact= new UserContact;   
                if($_GET[Globals::FLD_NAME_EMAIL]!='')
                {
                    $encrypt_email = $_GET[Globals::FLD_NAME_EMAIL];                        
                }
                if($_GET[Globals::FLD_NAME_VERIFICATIONCODE])
                {
                    $encrypt_ver_code = $_GET[Globals::FLD_NAME_VERIFICATIONCODE];                        
                }
                if($_GET['t'])
                {
                    $encrypt_timestamp = $_GET['t'];                     
                }

                $verificationcode = Yii::app()->getSecurityManager()->decrypt($encrypt_ver_code);
                $email = Yii::app()->getSecurityManager()->decrypt($encrypt_email);
                $timestamp = date('Y-m-d H:i:s',strtotime(Yii::app()->getSecurityManager()->decrypt($encrypt_timestamp)));                
                //Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                //Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

                $this->render('resetpassword',array('model'=>$model,'contact'=>$contact,'resetPassword' => $resetPassword,'email' => $email,'verificationcode'=>$verificationcode,'timestamp'=>$timestamp));
            }

            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('ResetPassword');
            }

    }
	
    public function actionSavePassword()
    {
            $resetPassword= new ResetPasswordForm;
            if($_POST['ResetPasswordForm'])
            {
                    if(Yii::app()->request->isAjaxRequest)
                    {
                        $error =  CActiveForm::validate($resetPassword);
                        if($error!= Globals::DEFAULT_VAL_NULL_ARRAY)
                        {
                                CommonUtility::setErrorLog($resetPassword->getErrors(),get_class($resetPassword));
                                echo $error;
                                Yii::app()->end();
                        }
                    }

                    try
                    {
                            $email = $_POST['ResetPasswordForm'][Globals::FLD_NAME_EMAIL];
                            $verificationcode = $_POST['ResetPasswordForm'][Globals::FLD_NAME_VERIFICATIONCODE];                           
                            $timestamp = $_POST['ResetPasswordForm'][Globals::FLD_NAME_TIMESTAMP];
                            try
                            {
                                $checkUser = User::CheckUser($email,$verificationcode);                                                        
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg($msg);
                            }
                            $currenttime = date("Y-m-d H:i:s");                            
                            $expiry_time = date('Y-m-d H:i:s', strtotime($timestamp .'+'.Globals::DEFAULT_HOURS_FOR_RESETPASSWORD_MAIL));                            
                            if(empty($checkUser))
                            {
                                echo CJSON::encode(array(
                                        'status'=>'not'
                                ));
                                if (CommonUtility::IsDebugEnabled())
                                { 
                                    Yii::log('Index.Resetpassword: reason:-'.Yii::t('index_forgotpassword','txt_user_not_found').'['.$email.']',CLogger::LEVEL_ERROR ,'IndexController');
                                } 
//                                CommonUtility::catchErrorMsg( Yii::t('index_forgotpassword','txt_user_not_found') , array( "User ID" => $email) );                                   
                                Yii::app()->end();
                            }
                            else
                            {                                
                                if($currenttime > $expiry_time)
                                {
                                    try
                                    {
                                        $verificationcode = CommonUtility::generateVerificationCode();
                                    }
                                    catch(Exception $e)
                                    {             
                                        $msg = $e->getMessage();
                                        CommonUtility::catchErrorMsg($msg);
                                    }
                                    $checkUser->{Globals::FLD_NAME_VERIFICATION_CODE} = $verificationcode;
                               
                                    $timestamp = time();

                                    $encrypt_ver_code = Yii::app()->getSecurityManager()->encrypt($verificationcode);
                                    $encrypt_email = Yii::app()->getSecurityManager()->encrypt($checkUser->usercontact[Globals::FLD_NAME_CONTACT_ID]);
                                    $encrypt_timestamp = Yii::app()->getSecurityManager()->encrypt($timestamp); 

                                    $userLink = Yii::app()->createAbsoluteUrl("index/resetpassword",array("email"=>$encrypt_email,"verificationcode"=>$encrypt_ver_code,"t"=>$encrypt_timestamp)); 
                                    $to = $email;
                                    $subject = Globals::MAIL_RESET_PASSWORD;
                                    $message = $userLink;
                                    try
                                    {
                                        $body = CommonUtility::mailBody($userLink);
                                    }
                                    catch(Exception $e)
                                    {             
                                        $msg = $e->getMessage();
                                        CommonUtility::catchErrorMsg($msg);
                                    }
                                    try
                                    {
                                        $sendMail = CommonUtility::SendMail($to,$subject,$message,$body);
                                    }
                                    catch(Exception $e)
                                    {             
                                        $msg = $e->getMessage();
                                        CommonUtility::catchErrorMsg($msg);
                                    }
                                    if($sendMail==1)
                                    {
                                        echo CJSON::encode(array(
                                            'status'=>'timeout'
                                        ));
                                        if (CommonUtility::IsDebugEnabled())
                                        { 
                                            Yii::log('Index.Resetpassword: reason:-'.Yii::t('index_forgotpassword','txt_success_msg_your_verification_code_has_been_expired').'['.$email.']',CLogger::LEVEL_ERROR ,'IndexController');
                                        }   
//                                        CommonUtility::catchErrorMsg( Yii::t('index_forgotpassword','txt_success_msg_your_verification_code_has_been_expired') , array( "User ID" => $email) );                                         
                                        Yii::app()->end();
                                    }
                                    else
                                    {
                                        echo CJSON::encode(array(
                                            'status'=>'not'
                                        ));
                                        throw new Exception(Yii::t('index_resetpassword','unexpected_error'));
                                        Yii::app()->end();
                                    }
                                }                                                        
                                else
                                {                                                                                   
                                    $checkUser->{Globals::FLD_NAME_PASSWORD} = $_POST['ResetPasswordForm'][Globals::FLD_NAME_PASSWORD];
                                    if(!$checkUser->update())
                                    {
                                            echo CJSON::encode(array(
                                                'status'=>'not'
                                            ));
                                            throw new Exception(Yii::t('index_resetpassword','unexpected_error'));
                                            Yii::app()->end();
                                    }
                                    else
                                    {
                                        echo CJSON::encode(array(
                                                'status'=>'success'
                                        ));
                                        if (CommonUtility::IsDebugEnabled())
                                        { 
                                            Yii::log('Index.Resetpassword: reason:-'.Yii::t('index_forgotpassword','txt_success_msg_your_password_has_been_reset_successfully').'['.$email.']',CLogger::LEVEL_INFO ,'IndexController');
                                        }                                                                                
                                        Yii::app()->end();
                                    }
                                }
                            }  
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        if (CommonUtility::IsTraceEnabled())
                        {
                            Yii::trace('Executing actionResetpassword() method','IndexController');
                        }                                               
                        CommonUtility::catchErrorMsg( $msg , array( "User ID" => $checkUser->user_id) );                   
                    }    
            }
    }
    protected function performAjaxValidation($model)
    {
        if(isset($_POST[Globals::FLD_NAME_AJAX]) && (
                    ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_LOGIN_FORM)
                    || ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_REGISTER_FORM)
                    || ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_UPDATEFROFILE_FORM)
                    || ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_FORGOT_PASSWORD_FORM)
                    || ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_UPDATE_PROFILE_FORM)
                    || ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_CHANGE_PASSWORD_FORM)
                    || ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_UPLOAD_VIDEO_FORM)
                    || ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_ADDRESSINFO_FORM)
                    || ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_ABOUTUS_FORM)
                    || ($_POST[Globals::FLD_NAME_AJAX]===Globals::DEFAULT_VAL_UPLOAD_FORM)))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionError()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Error','application.controller.IndexController');
            }
            $controllerName=Yii::app()->controller->id;
            $actionName=Yii::app()->controller->action->id;
            if($error=Yii::app()->errorHandler->error)
            {
                if (CommonUtility::IsTraceEnabled())
                {
                        Yii::trace('Executing actionLogin() method','IndexController');
                }
                Yii::log('Error Message', CLogger::LEVEL_ERROR, $controllerName.'.'.$actionName);
                if(Yii::app()->request->isAjaxRequest)
                {
                        echo $error[Globals::FLD_NAME_MESSAGE];
                }
                else
                {
                   // print_r ($error);
                    switch($error['code'])
                    {
                     case ErrorCode::ERROR_CODE_IS_POSTER_LICENSE:
                            $this->layout = '//layouts/noheader';
                            $this->render('//error/poster_license', $error);
                            
                            break;

                        default:
                            $this->render('//error/error', $error);
                            break;   
                    }
               
                       
                }
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Error');
            }
    }

    public function actionProposalAccept()
    {
            if(CommonUtility::IsProfilingEnabled())
            { 
                    Yii::beginProfile('ProposalAccept','application.controller.IndexController');
            }
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
            $alert_id = $_POST[Globals::FLD_NAME_ALERT_ID];
            $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
            $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
            
            $proposals = GetRequest::getProposalsByTask($task->{Globals::FLD_NAME_TASK_ID},$task->{Globals::FLD_NAME_CREATER_USER_ID});    
            $model = $this->loadModel($task->{Globals::FLD_NAME_CREATER_USER_ID});
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            
            if($taskTasker)
            {
                $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_SELECTED;
                $task->{Globals::FLD_NAME_TASK_STATE} = Globals::DEFAULT_VAL_TASK_STATE_ASSIGNED;
                try
                {
                        if( !$taskTasker->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        if( !$task->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        $userAlert = UserAlert::model()->findByPk($alert_id);
                        if($userAlert)
                        {
                            $userAlert->{Globals::FLD_NAME_IS_SEEN} = Globals::DEFAULT_VAL_NOTIFICATION_SEEN;
                            $userAlert->{Globals::FLD_NAME_SEEN_AT} = new CDbExpression('NOW()');
                            $userAlert->{Globals::FLD_NAME_SEEN_FROM_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                            if( !$userAlert->update())
                            {   
                                    throw new Exception(Yii::t('poster_proposalreject','unexpected_error'));
                            }
                        }
                        $alert = new UserAlert();
                        try
                        {
                            $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg($msg , array('task_tasker_id' => $task_tasker_id));
                        }
                        $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                        $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_ACCEPT_PROPOSAL;
                        $alert->{Globals::FLD_NAME_FOR_USER_ID} = $taskTasker->{Globals::FLD_NAME_TASKER_ID};   
                        $alert->{Globals::FLD_NAME_BY_USER_ID} = Yii::app()->user->id; 
                        $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                        $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                       
                        if(!$alert->save())
                        {   
                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                        }
                        $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
                                                //  Globals::FLD_NAME_COMMENTS => '',
                                            );
                        try
                        {
                            CommonUtility::addTaskActivity($taskTasker->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_ACCEPT , $otherInfo );
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg($msg , array('task_tasker_id' => $task_tasker_id));
                        }
                        echo CJSON::encode(array(
                                              'status'=>'success'
                                     ));
                        
                        
                }
                catch(Exception $e)
                {
                        $msg = $e->getMessage();

                        if (CommonUtility::IsTraceEnabled())
                        {
                                        Yii::trace('Executing actionProposalAccept() method','IndexController');
                        }
                        Yii::log('Index.ProposalAccept: reason:-'.$msg,CLogger::LEVEL_ERROR ,'IndexController');
                }
            }
            
           
            if(CommonUtility::IsProfilingEnabled())
            { 
                	Yii::endProfile('ProposalAccept');
            }
    }
    public function actionProposalReject()
    {
            if(CommonUtility::IsProfilingEnabled())
            { 
                    Yii::beginProfile('ProposalReject','application.controller.IndexController');
            }
    
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
            $alert_id = $_POST[Globals::FLD_NAME_ALERT_ID];
            $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
            $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
            if($taskTasker)
            {
                $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_REJECTED;
                try
                {
                        if( !$taskTasker->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        $userAlert = UserAlert::model()->findByPk($alert_id);
                        if($userAlert)
                        {
                            $userAlert->{Globals::FLD_NAME_IS_SEEN} = Globals::DEFAULT_VAL_NOTIFICATION_SEEN;
                            $userAlert->{Globals::FLD_NAME_SEEN_AT} = new CDbExpression('NOW()');
                            $userAlert->{Globals::FLD_NAME_SEEN_FROM_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                            if( !$userAlert->update())
                            {   
                                    throw new Exception(Yii::t('poster_proposalreject','unexpected_error'));
                            }
                        }
                        $alert = new UserAlert();
                        try
                        {
                            $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg($msg , array('task_tasker_id' => $task_tasker_id));
                        }
                        $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                        $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_REJECT_PROPOSAL;
                        $alert->{Globals::FLD_NAME_FOR_USER_ID} = $taskTasker->{Globals::FLD_NAME_TASKER_ID}; 
                        $alert->{Globals::FLD_NAME_BY_USER_ID}  =  Yii::app()->user->id;
                        $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                        $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        if(!$alert->save())
                        {   
                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                        }
                        $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
                                                //  Globals::FLD_NAME_COMMENTS => '',
                                            );
                        try
                        {
                            CommonUtility::addTaskActivity($taskTasker->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_REJECT , $otherInfo );
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg($msg);
                        }
                        echo $error = CJSON::encode(array(
                                'status'=>'success',
                        ));
                }
                catch(Exception $e)
                {
                        $msg = $e->getMessage();

                        if (CommonUtility::IsTraceEnabled())
                        {
                                        Yii::trace('Executing actionProposalReject() method','IndexController');
                        }
                        Yii::log('Index.ProposalReject: reason:-'.$msg,CLogger::LEVEL_ERROR ,'IndexController');
                }
            }
            
           
            if(CommonUtility::IsProfilingEnabled())
            { 
                	Yii::endProfile('ProposalReject');
            }
    }
    public function actionProposalRejectByUser()
    {
            if(CommonUtility::IsProfilingEnabled())
            { 
                    Yii::beginProfile('ProposalRejectByUser','application.controller.IndexController');
            }
    
            $task_tasker_id = $_POST[Globals::FLD_NAME_TASK_TASKER_ID];
            $taskTasker = TaskTasker::model()->findByPk($task_tasker_id);
            $task = Task::model()->findByPk($taskTasker->{Globals::FLD_NAME_TASK_ID});
            if($taskTasker)
            {
                $taskTasker->{Globals::FLD_NAME_TASKER_STATUS} = Globals::DEFAULT_VAL_TASK_STATUS_REJECTED;
                try
                {
                        if( !$taskTasker->update())
                        {   
                                throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                        }
                        $alert = new UserAlert();
                        try
                        {
                            $alertType = UtilityHtml::GetAlertType(array(Globals::FLD_NAME_TASK_KIND => $task->{Globals::FLD_NAME_TASK_KIND}));
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
                        }
                        $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alertType;
                        $alert->{Globals::FLD_NAME_ALERT_DESC} = Globals::ALERT_DESC_REJECT_PROPOSAL_BY_USER;
                        $alert->{Globals::FLD_NAME_FOR_USER_ID} = $task->{Globals::FLD_NAME_CREATER_USER_ID}; 
                        $alert->{Globals::FLD_NAME_BY_USER_ID} =  Yii::app()->user->id;
                        $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
                        $alert->{Globals::FLD_NAME_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
                        if(!$alert->save())
                        {   
                            throw new Exception(Yii::t('poster_saveproposal','unexpected_error'));   
                        }
                        $otherInfo = array( 
                                                Globals::FLD_NAME_ACTIVITY_SUBTYPE => $taskTasker->{Globals::FLD_NAME_SELECTION_TYPE},
                                                //  Globals::FLD_NAME_COMMENTS => '',
                                            );
                        CommonUtility::addTaskActivity($taskTasker->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id , Globals::TASK_ACTIVITY_TYPE_PROPOSAL_REJECT , $otherInfo );
                        echo $error = CJSON::encode(array(
                                'status'=>'success',
                        ));
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
                }
            }
            
           
            if(CommonUtility::IsProfilingEnabled())
            { 
                	Yii::endProfile('ProposalRejectByUser');
            }
    }
    
     public function actionIsSeenTrue()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('IsSeenTrue','application.controller.IndexController');
            }
           
            $alert_id = $_POST[Globals::FLD_NAME_ALERT_ID];
            $alert = UserAlert::model()->findByPk($alert_id);
            $alert->scenario=Globals::SCENARIO_NOTIFICATION_SEENTRUE;
            $alert->{Globals::FLD_NAME_IS_SEEN} = Globals::DEFAULT_VAL_NOTIFICATION_SEEN;
            $alert->{Globals::FLD_NAME_SEEN_FROM_SOURCE_APP} = Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB;
            $alert->{Globals::FLD_NAME_SEEN_AT} = new CDbExpression('NOW()');
            try
            {
                if( !$alert->save())
                {   
                        throw new Exception(Yii::t('poster_publishproposal','unexpected_error'));
                }
                echo $error = CJSON::encode(array(
                                'status'=>'success',
                        ));
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
            }
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('IsSeenTrue');
            }
    }
    public function actionLogout()
    {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Logout','application.controller.IndexController');
            }
            try
            {
                CommonUtility::addUserActivity( Yii::app()->user->id , Globals::USER_ACTIVITY_TYPE_LOGOUT );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
            }
            Yii::app()->user->logout(false);
            
            
            $this->redirect(array('index/index'));
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::endProfile('Logout');
            }
    }

    //Password Generater
    function generate_password($length = 8)
    {
            $chars = Globals::RAND_PASS_GEN_STRING;
            $password = substr( str_shuffle( $chars ), 0, $length );
            return $password;
    }
    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
   
    public function actionsendmail()
    {
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('sendmail','application.controller.IndexController');
        }
        //print_r($_POST);exit;
        $to = $_POST[Globals::FLD_NAME_TO];
        $subject = $_POST[Globals::FLD_NAME_SUBJECT];
        $message = $_POST[Globals::FLD_NAME_MESSAGE];
        $body = $_POST[Globals::FLD_NAME_BODY];
        //echo $to;exit;
        try
        {
            $sendMail = CommonUtility::SendMail($to,$subject,$message,$body); 
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg , array( "User ID" => Yii::app()->user->id) );
        }
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        if($sendMail==1) 
        {
            echo CJSON::encode(array(
                    'status'=>'success'
            ));  
        
            $this->renderPartial('verify',array('msg' => CHtml::encode(Yii::t('index_register','txt_you_are_verified'))));
        }
        else
        {
            echo CJSON::encode(array(
                    'status'=>'not'
            ));

           // $this->renderPartial('verify',array('msg' => CHtml::encode(Yii::t('index_register','txt_not_success'))));
        }
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('sendmail');
        }
        
    }
    
//    public function actionAjaxPopUp()
//        {
//            
//            if(CommonUtility::IsProfilingEnabled())
//            {
//                Yii::beginProfile('AjaxPopUp','application.controller.IndexController');
//            }
//            @$to = $_POST["to"];
//            @$subject = $_POST["subject"];
//            @$message = $_POST["message"];
//            @$body = $_POST["body"];
//            @$msg = $_POST["msg"];
//            //print_r($data["msg"]);exit;
//            if (CommonUtility::IsDebugEnabled())
//            {
//                    Yii::log($msg, CLogger::LEVEL_INFO, 'IndexController.AjaxPopUp');
//            } 
//            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
//            $result["html"] = $this->renderPartial('_verify',array('msg' => $msg,'msg' => $msg,'to' => $to,'subject' => $subject,'message' => $message,'body' => $body) ,true,true);
//            echo CJSON::encode($result);
//            if(CommonUtility::IsProfilingEnabled())
//            {
//                Yii::endProfile('AjaxPopUp','application.controller.IndexController');
//            }
//        }
//        
//        public function actionAjaxPopUpForReVerification()
//        {
//            //echo 'test';exit;
//            if(CommonUtility::IsProfilingEnabled())
//            {
//                Yii::beginProfile('AjaxPopUpForReVerification','application.controller.IndexController');
//            }
////            @$to = $_POST["to"];
////            @$subject = $_POST["subject"];
////            @$message = $_POST["message"];
////            @$body = $_POST["body"];
//            @$msg = $_POST[Globals::FLD_NAME_MSG];
//            //echo $msg;exit;
//            //print_r($data["msg"]);exit;
//            if (CommonUtility::IsDebugEnabled())
//            {
//                    Yii::log($msg, CLogger::LEVEL_INFO, 'IndexController.AjaxPopUpForReVerification');
//            } 
//            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.metadata.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.rating.js'] = false;
//            $result["html"] = $this->renderPartial('_verify',array('msg' => $msg),true,truev);
//            echo CJSON::encode($result);
//            if(CommonUtility::IsProfilingEnabled())
//            {
//                Yii::endProfile('AjaxPopUpForReVerification','application.controller.IndexController');
//            }
//        }
        
        public function actionVerifidLogin()
        {
            $this->render('login');
        }
}