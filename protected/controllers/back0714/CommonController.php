<?php

class CommonController extends BackEndController
{
	public function actionIndex()
	{
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
        public function actionAjaxSetUrlSession()
        {
            Yii::app()->user->setState(Globals::FLD_NAME_PAGE_URL,NULL);
            $url = $_GET[Globals::FLD_NAME_URL];
            $url = str_replace(Globals::DEFAULT_VAL_URL_BREAK, Globals::DEFAULT_VAL_AND, $url);
            Yii::app()->user->setState(Globals::FLD_NAME_PAGE_URL,$url);
            
            // to show dropdown for page rows selection
          //  UtilityHtml::getPagerDropdown('pageSizeCountry');
          
        }
        public function actionAjaxGetFieldLabel()
        {
            
            $thisname = $_GET[Globals::FLD_NAME_THIS_NAME];
            $model = new $_GET[Globals::FLD_NAME_MODEL];
            $label = CHtml::activeLabel($model,$thisname);
            echo strip_tags($label);
        }

	public function loadModel($classname, $id)
	{
		$model=$classname::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(Globals::DEFAULT_VAL_404,'The requested page does not exist.');
		return $model;
	}

	public function actionChangestatus()
	{
		$id=$_GET[Globals::FLD_NAME_ID];
		$status=$_GET[Globals::FLD_NAME_STATUS];
		$classname=$_GET[Globals::FLD_NAME_CLASS_NAME];
		$fieldName=$_GET[Globals::FLD_NAME_FIELD_NAME];
		$language=@$_GET[Globals::FLD_NAME_LANGUAGE];
		$pkName=$_GET[Globals::FLD_NAME_PK_NAME];
                
                
		if (isset($id) || $id!= Globals::DEFAULT_VAL_NULL || $status!= Globals::DEFAULT_VAL_NULL)
		{
			if($language != Globals::DEFAULT_VAL_NULL)
			{
				$model = $classname::model()->findByAttributes(array($pkName=>$id,'language_code'=>$language));
			}
			else 
			{
				$model=$this->loadModel($classname,$id);
			}
			$model->$fieldName = $status;         
			$success = $model->saveAttributes(array($fieldName => $status));
			if ($success)
			{
					$classname = str_replace(Globals::DEFAULT_VAL_LOCALE, "", $classname);
					if ($classname == Globals::FLD_NAME_ADMIN)
					{
						$classname = Globals::FLD_NAME_ADMIN_USER;
					}
					if ($status==Globals::DEFAULT_VAL_1)
					{
							CommonUtility::setFlashMsg('flash-success',$classname.' has been Activated successfully.');
					}
					else
					{
							CommonUtility::setFlashMsg('flash-success',$classname.' has been In-activated successfully.');
					}
			}
			else
			{
					CommonUtility::setFlashMsg('flash-notice','Unable to process, Please try again after some time.');
			}
		}
		else
		{
			CommonUtility::setFlashMsg('flash-notice','Invalid record.');
		}
	}
    public function actionAjaxupdate()
	{
		$act = $_GET[Globals::FLD_NAME_ACT];
		$autoIdAll = $_POST[Globals::FLD_NAME_AUTO_ID];
		$className = $_GET[Globals::FLD_NAME_CLASS_NAME_N_CAP];
		$fieldName = $_GET[Globals::FLD_NAME_FIELD_NAME];
		$tableName = @$_GET[Globals::FLD_NAME_RELATION_NAME];
		$pkName = @$_GET[Globals::FLD_NAME_PK_NAME];
		$language = @$_POST[Globals::FLD_NAME_LANGUAGE];
		$super = $_GET[Globals::FLD_NAME_SUPER];
		$hasLacale = @$_GET[Globals::FLD_NAME_HAS_LOCALE];
		
	   // print_r($language);
		if($act== Globals::DEFAULT_VAL_DO_DELETE)
		{
			if($super != Globals::DEFAULT_VAL_1)
			{
				$permission =  Yii::app()->user->getState(Globals::FLD_NAME_PERMISSION);
				if(!isset($permission[$className][Globals::FLD_NAME_DELETE]))
				{
					CommonUtility::setFlashMsg('flash-error','You are not authorized to perform this action.');
					die();
				} 
			}
		}
		if(count($autoIdAll) > Globals::DEFAULT_VAL_0)
		{
			$isDelete = Globals::DEFAULT_VAL_0;
			$notDelete= Globals::DEFAULT_VAL_0;
			$update=Globals::DEFAULT_VAL_0;
			foreach($autoIdAll as $index => $autoId)
			{
				if(isset($language))
				{
					$model = $className::model()->findByAttributes(array($pkName=>$autoId,'language_code'=>$language[$index]));
				}
				else 
				{
					$model=$this->loadModel($className,$autoId);
					//$model = $className::model()->findByAttributes(array($pkName=>$autoId));
				}
				if($act== Globals::DEFAULT_VAL_DO_DELETE)
				{   
                                    try
                                    {
                                        if($tableName)
                                        {
                                            if($pkName == Globals::FLD_NAME_ROLE_ID)
                                            {
                                                $pkNameChild = Globals::FLD_NAME_USER_ROLE_ID;
                                            }
                                            else
                                            {
                                                $pkNameChild = $pkName;
                                            }                                            
                                            $relationTable = $tableName;
                                            $forginkey = $pkNameChild;
                                            $forginkeyVal = $autoId;
                                            $result =  CommonUtility::chackRelationForDeleteAction($relationTable,$forginkey,$forginkeyVal);

//                                            $hasforeign = $tableName::model()->findByAttributes(array($pkNameChild=>$autoId));
//                                            if($hasforeign)                                            
                                            if($result['hasforeign'])
                                            {
                                                throw new Exception("Relation Restriction."); 
                                            }                                            
                                            if($hasLacale)
                                            {
                                             $success = $model->delete();
                                            }
                                            else
                                            {
                                               $deleteLocal = $className::model()->deleteAll(Globals::DEFAULT_VAL_NULL.$pkName.'=:id', array(':id' => $autoId));
                                                $classLocale = str_replace(Globals::DEFAULT_VAL_LOCALE, "", $className);
                                                //$success = $model->delete();
                                                if(@class_exists($classLocale))
                                                {
                                                    $success = $classLocale::model()->deleteAll(Globals::DEFAULT_VAL_NULL.$pkName.'=:id', array(':id' => $autoId));
                                                }
                                            }
                                            
                                        }
                                        else 
                                        { 
                                            $success = $model->delete();
                                        }
                                        
                                           
                                      
                                        if($success)
                                        {
                                            $isDelete++;
                                        }
                                    }
                                    catch (Exception $e)
                                    {          
                                       $notDelete++;
                                    }
				}
				if($act == Globals::DEFAULT_VAL_DO_ACTION)
				{
					$status= Globals::DEFAULT_VAL_1;
					$update=Globals::DEFAULT_VAL_1;
				}
				if($act== Globals::DEFAULT_VAL_DO_IN_ACTION)
				{
					$status= Globals::DEFAULT_VAL_0;
					$update=Globals::DEFAULT_VAL_1;
				} 
				if($update==Globals::DEFAULT_VAL_1)
				{
					$success = $model->saveAttributes(array($fieldName => $status));
					if($success)
					{
						$isDelete++;
					}
					else
					{                                   
					   $notDelete++;
					}
				}
			}
                        $className = str_replace(Globals::DEFAULT_VAL_LOCALE, "", $className);
                        if($className == Globals::DEFAULT_VAL_ROLES)
                        {
                            $className = Globals::DEFAULT_VAL_ROLE;
                        }
                        if($className == Globals::FLD_NAME_ADMIN)
                        {
                            $className = Globals::FLD_NAME_ADMIN_USER;
                        }
			if($act==Globals::DEFAULT_VAL_DO_DELETE)
			{
                            if($isDelete > Globals::DEFAULT_VAL_0  )
                            {
								CommonUtility::setFlashMsg('flash-success',$isDelete.' '.$className.'(s) has been deleted successfully.');
                            }
                            if( $notDelete > Globals::DEFAULT_VAL_0 )
                            {
								CommonUtility::setFlashMsg('flash-notice',$notDelete.' '.$className.'(s) could not be deleted (Relation Restriction).');
                            }
                                
                        }
			if($act==Globals::DEFAULT_VAL_DO_ACTION)
			{
                            if($isDelete > Globals::DEFAULT_VAL_0  )
                            {
								CommonUtility::setFlashMsg('flash-success',$isDelete.' '.$className.'(s) has been activated successfully.');
                            }
                            if( $notDelete > Globals::DEFAULT_VAL_0 )
                            {
								CommonUtility::setFlashMsg('flash-notice',$notDelete.' '.$className.'(s) has been already activated.');
                            }
			}
			if($act== Globals::DEFAULT_VAL_DO_IN_ACTION)
			{
                            if($isDelete > Globals::DEFAULT_VAL_0  )
                            {
								CommonUtility::setFlashMsg('flash-success',$isDelete.' '.$className.'(s) has been In-activated successfully.');
                            }
                            if( $notDelete > Globals::DEFAULT_VAL_0 )
                            {
								CommonUtility::setFlashMsg('flash-notice',$notDelete.' '.$className.'(s) has been already In-activated.');
                            }
			}    
		}
		else
		{
			CommonUtility::setFlashMsg('flash-notice','Please select atleast one record.');
		}
	}

 public function actionAjaxupdateaStatusAandN()
	{
		$act = $_GET[Globals::FLD_NAME_ACT];
		$autoIdAll = $_POST[Globals::FLD_NAME_AUTO_ID];
		$className = $_GET[Globals::FLD_NAME_CLASS_NAME_N_CAP];
		$fieldName = $_GET[Globals::FLD_NAME_FIELD_NAME];
		$tableName = @$_GET[Globals::FLD_NAME_RELATION_NAME];
		$pkName = @$_GET[Globals::FLD_NAME_PK_NAME];
		$language = @$_POST[Globals::FLD_NAME_LANGUAGE];
		$super = $_GET[Globals::FLD_NAME_SUPER];
		$hasLacale = @$_GET[Globals::FLD_NAME_HAS_LOCALE];

	   // print_r($language);
		if($act== Globals::DEFAULT_VAL_DO_DELETE)
		{
			if($super != Globals::DEFAULT_VAL_1)
			{
				$permission =  Yii::app()->user->getState(Globals::FLD_NAME_PERMISSION);
				if(!isset($permission[$className][Globals::FLD_NAME_DELETE]))
				{
					CommonUtility::setFlashMsg('flash-error','You are not authorized to perform this action.');
					die();
				}
			}
		}
		if(count($autoIdAll) > Globals::DEFAULT_VAL_0)
		{
			$isDelete = Globals::DEFAULT_VAL_0;
			$notDelete= Globals::DEFAULT_VAL_0;
			$update=Globals::DEFAULT_VAL_0;
			foreach($autoIdAll as $index => $autoId)
			{
				if(isset($language))
				{
					$model = $className::model()->findByAttributes(array($pkName=>$autoId,'language_code'=>$language[$index]));
				}
				else
				{
					$model=$this->loadModel($className,$autoId);
					//$model = $className::model()->findByAttributes(array($pkName=>$autoId));
				}
				if($act== Globals::DEFAULT_VAL_DO_DELETE)
				{
                                    try
                                    {
                                        if($tableName)
                                        {
                                            if($pkName = Globals::FLD_NAME_ROLE_ID)
                                            {
                                                $pkNameChild = Globals::FLD_NAME_USER_ROLE_ID;
                                            }
                                            else
                                            {
                                                $pkNameChild = $pkName;
                                            }
                                            $hasforeign = $tableName::model()->findByAttributes(array($pkNameChild=>$autoId));
                                            if($hasforeign)
                                            {
                                                throw new Exception("Relation Restriction.");
                                            }
                                            if($hasLacale)
                                            {
                                             $success = $model->delete();
                                            }
                                            else
                                            {
                                               $deleteLocal = $className::model()->deleteAll(Globals::DEFAULT_VAL_NULL.$pkName.'=:id', array(':id' => $autoId));
                                                $classLocale = str_replace(Globals::DEFAULT_VAL_LOCALE, "", $className);
                                                //  $success = $model->delete();
                                                if(@class_exists($classLocale))
                                                {
                                                    $success = $classLocale::model()->deleteAll(Globals::DEFAULT_VAL_NULL.$pkName.'=:id', array(':id' => $autoId));
                                                }
                                            }

                                        }
                                        else
                                        {
                                            $success = $model->delete();
                                        }



                                        if($success)
                                        {
                                            $isDelete++;
                                        }
                                    }
                                    catch (Exception $e)
                                    {
                                       $notDelete++;
                                    }
				}
				if($act == Globals::DEFAULT_VAL_DO_ACTION)
				{
					$status= Globals::DEFAULT_VAL_A;
					$update=Globals::DEFAULT_VAL_1;
				}
				if($act== Globals::DEFAULT_VAL_DO_IN_ACTION)
				{
					$status= Globals::DEFAULT_VAL_N;
					$update=Globals::DEFAULT_VAL_1;
				}
				if($update==Globals::DEFAULT_VAL_1)
				{
					$success = $model->saveAttributes(array($fieldName => $status));
					if($success)
					{
						$isDelete++;
					}
					else
					{
					   $notDelete++;
					}
				}
			}
                        $className = str_replace(Globals::DEFAULT_VAL_LOCALE, "", $className);
                        if($className == Globals::DEFAULT_VAL_ROLES)
                        {
                            $className = Globals::DEFAULT_VAL_ROLE;
                        }
                        if($className == Globals::FLD_NAME_ADMIN)
                        {
                            $className = Globals::FLD_NAME_ADMIN_USER;
                        }
			if($act==Globals::DEFAULT_VAL_DO_DELETE)
			{
                            if($isDelete > Globals::DEFAULT_VAL_0  )
                            {
								CommonUtility::setFlashMsg('flash-success',$isDelete.' '.$className.'(s) has been deleted successfully.');
                            }
                            if( $notDelete > Globals::DEFAULT_VAL_0 )
                            {
								CommonUtility::setFlashMsg('flash-notice',$notDelete.' '.$className.'(s) has been not deleted (Relation Restriction).');
                            }

                        }
			if($act==Globals::DEFAULT_VAL_DO_ACTION)
			{
                            if($isDelete > Globals::DEFAULT_VAL_0  )
                            {
								CommonUtility::setFlashMsg('flash-success',$isDelete.' '.$className.'(s) has been activated successfully.');
                            }
                            if( $notDelete > Globals::DEFAULT_VAL_0 )
                            {
								CommonUtility::setFlashMsg('flash-notice',$notDelete.' '.$className.'(s) has been already activated.');
                            }
			}
			if($act== Globals::DEFAULT_VAL_DO_IN_ACTION)
			{
                            if($isDelete > Globals::DEFAULT_VAL_0  )
                            {
								CommonUtility::setFlashMsg('flash-success',$isDelete.' '.$className.'(s) has been In-activated successfully.');
                            }
                            if( $notDelete > Globals::DEFAULT_VAL_0 )
                            {
								CommonUtility::setFlashMsg('flash-notice',$notDelete.' '.$className.'(s) has been already In-activated.');
                            }
			}
		}
		else
		{
			CommonUtility::setFlashMsg('flash-notice','Please select atleast one record.');
		}
	}
}