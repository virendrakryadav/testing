<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UtilityHtml extends CComponent
{	 
	//Active / In-active button in data grids
	public function getStatusImage($status, $className, $id, $fieldName, $language, $pkName)
	{
		$url=  Globals::URL_COMMON_CHANGESTATUS;
		if ($status == Globals::DEFAULT_VAL_ACTIVE_STATUS_NUMBER || strtolower($status) == Globals::DEFAULT_VAL_ACTIVE_STATUS_YES) 
		{
			$image=CHtml::image(Globals::IMAGE_STATUS_ACTIVE, CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_inactive')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_inactive'))));
			echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
				  array( 'type' => 'POST', 'success' => "reloadGrid",// reloadGrid is a function to refresh grid 
				  'cache'=>false,
				),
				array( //htmlOptions
				'href' => Yii::app()->createUrl( $url.'?id='.$id.'&status='.Globals::DEFAULT_VAL_DEACTIVE_STATUS_NUMBER.'&classname='.$className.'&fieldName='.$fieldName.'&language='.$language.'&pkName='.$pkName),
				)
			);		
		}
		else
		{
			$image=CHtml::image(Globals::IMAGE_STATUS_INACTIVE , CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_active')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_active'))));
			echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
				 array( 'type' => 'POST', 'success' => "reloadGrid",
				 'cache'=>false,
				),
				array( 
				//htmlOptions
				'href' => Yii::app()->createUrl( $url.'?id='.$id.'&status='.Globals::DEFAULT_VAL_ACTIVE_STATUS_NUMBER.'&classname='.$className.'&fieldName='.$fieldName.'&language='.$language.'&pkName='.$pkName),
				)
		  	);	
		}
	}

        public function deleteActionForSkill($skillid = "",$category = "")
        {
            $url= Globals::URL_DELETE_SKILL;            
            $image=CHtml::image(Globals::BASE_URL_PUBLIC_IMAGE_DIR.Globals::IMAGE_DELETE_ACTIVE);
            echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
                        array( 'type' => 'POST', 'success' => "reloadGrid",
                        'cache'=>false,
                    	'data' => array( 'skill_id' => $skillid, 'category_id' => $category)
                    ),
                    array( //htmlOptions
                        'href' => Yii::app()->createUrl($url),
                    )
            );		
        }
        public function getStatusImageForAandN($status, $className, $id, $fieldName, $language, $pkName)
	{
		$url=  Globals::URL_COMMON_CHANGESTATUS;
		if ($status == Globals::DEFAULT_VAL_ACTIVE_STATUS_ALFABET || strtolower($status) == Globals::DEFAULT_VAL_ACTIVE_STATUS_YES)
		{
			$image=CHtml::image(Globals::IMAGE_STATUS_ACTIVE, CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_inactive')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_inactive'))));
			echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
				  array( 'type' => 'POST', 'success' => "reloadGrid",
				  'cache'=>false,
				//	'data' => array( 'id' => $id, 'status' => 0)
				),
				array( //htmlOptions
				'href' => Yii::app()->createUrl( $url.'?id='.$id.'&status='.Globals::DEFAULT_VAL_DEACTIVE_STATUS_ALFABET_FOR_URL.'&classname='.$className.'&fieldName='.$fieldName.'&language='.$language.'&pkName='.$pkName),
				)
			);
		}
                else if($status == Globals::DEFAULT_VAL_SUSPEND_STATUS_ALFABET)
		{
			$image=CHtml::image(Globals::IMAGE_STATUS_SUSPEND, CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_active')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_active'))));			
                        echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
				 array( 'type' => 'POST', 'success' => "reloadGrid",
				 'cache'=>false,
				//	'data' => array( 'id' => $id, 'status' => 1)
				),
				array(
				//htmlOptions
				'href' => Yii::app()->createUrl( $url.'?id='.$id.'&status='.Globals::DEFAULT_VAL_ACTIVE_STATUS_ALFABET_FOR_URL.'&classname='.$className.'&fieldName='.$fieldName.'&language='.$language.'&pkName='.$pkName),
				)
		  	);
		}
		else
		{
			$image=CHtml::image(Globals::IMAGE_STATUS_INACTIVE, CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_active')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_active'))));
			echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
				 array( 'type' => 'POST', 'success' => "reloadGrid",
				 'cache'=>false,
				//	'data' => array( 'id' => $id, 'status' => 1)
				),
				array(
				//htmlOptions
				'href' => Yii::app()->createUrl( $url.'?id='.$id.'&status='.Globals::DEFAULT_VAL_ACTIVE_STATUS_ALFABET_FOR_URL.'&classname='.$className.'&fieldName='.$fieldName.'&language='.$language.'&pkName='.$pkName),
				)
		  	);
		}
	}
        // Get Rating For poster and tasker
        public function getRatingFor($rating_for, $className, $id, $fieldName, $language, $pkName)
        { 
          if ($rating_for == 'p')
          {
              echo "Poster";
          }
          else
          {
              echo "Doer";
          }
        }
        // Rating for Dropdown for Poster and Tasker (p & t)
        public function getRatingDropdownPosterandTasker($model, $id, $value)
	{
		$className=get_class($model);
		$dropdownName=$className.'['.$id.']';
		echo CHtml::dropDownList($dropdownName, $id,
		array(
			""=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_select_rating_for')),
                        Globals::FLD_NAME_POSTER_RATING_ALFABET =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_poster'))
                    , Globals::FLD_NAME_TASKER_RATING_ALFABET  =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_tasker'))                    
		),
		//array('class'=>'m-wrap span12'),
		array('options'=>array($value =>array('selected'=>true)))
		);
	}
               
        // Setting type Dropdown for Poster,Tasker, Admin and User(p,t,a,u)
        public function getSettingDropdownSettingType($model, $id, $value)
	{
		$className=get_class($model);
		$dropdownName=$className.'['.$id.']';
		echo CHtml::dropDownList($dropdownName, $id,
		array(
			""=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_select_setting_type')),
                        Globals::FLD_NAME_POSTER_SETTING_ALFABET =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_poster'))
                        , Globals::FLD_NAME_TASKER_SETTING_ALFABET  =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_doer')) 
                        , Globals::FLD_NAME_ADMIN_SETTING_ALFABET  =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_admin')) 
                        , Globals::FLD_NAME_USER_SETTING_ALFABET  =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_user')) 
		),
		//array('class'=>'m-wrap span12'),
		array('options'=>array($value =>array('selected'=>true)))
		);
	}
        
//	public function getUserImage($image)
//	{
//                $baseUrl = Yii::app()->request->baseUrl;
//                $imageUrl=$baseUrl.'/images/uploads/'.$image;
//                echo CHtml::image($imageUrl, 'No Image',array('width'=>60, 'height'=>60));
//		
//	}
        public function setStrlength($str,$limit)
        {
            if(!empty ($str))
            {
                echo substr($str,0,$limit);
                if(strlen($str)> $limit)
                {
                    echo CHtml::encode(Yii::t('components_utilityhtml', 'txt_after_short_string'));
                }
            }
        }
        
        public function showLilitedStr($str,$limit)
        {
            $string="";
            if(!empty ($str))
            {
                $stringCut = substr($str, 0, $limit);
                $string = substr($stringCut, 0, strrpos($stringCut, ' ')); 
            }
            return $string;
        }
        
        public function getPaymentMode($payment_mode)
	{           
                if($payment_mode == Globals::DEFAULT_VAL_PAYMENT_MODE)
                {
                    echo CHtml::encode(Yii::t('components_utilityhtml', 'txt_fixed_price')); 
                }
                else
                {
                    echo CHtml::encode(Yii::t('components_utilityhtml', 'txt_open_bid')); 
                }            
	}

        public function getQuestionInputType($val , $id , $form , $model , $value='', $class ='' )
	{
                if($val == Globals::DEFAULT_VAL_QUESTION_TYPE_LODICAL)
                    {
                        if( isset($value) )
                        {
                            $model->{Globals::FLD_NAME_REPLY_YESNO} = $value;
                        }
                        $ans = array(Globals::DEFAULT_VAL_ANSWERE_YES => CHtml::encode(Yii::t('components_utilityhtml', 'txt_yes')), Globals::DEFAULT_VAL_ANSWERE_NO => CHtml::encode(Yii::t('components_utilityhtml', 'txt_no')));
                        
                       
                         echo $form->radioButtonList($model, "[".$id."]".Globals::FLD_NAME_REPLY_YESNO, $ans, array('value'=>$value )); 
                       echo $form->error($model,"[".$id."]".Globals::FLD_NAME_REPLY_YESNO,array('class' => 'invalid'));

                    }
                else if($val == Globals::DEFAULT_VAL_QUESTION_TYPE_ONLINE)
                    {
                       
                        echo $form->textField($model, "[".$id."]".Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC, array('class' => $class,'value'=>$value));
                        echo $form->error($model,"[".$id."]".Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC,array('class' => 'invalid'));
                    }
                else
                    {
                      echo  $form->textField($model,"[".$id."]".Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC, array('class' => $class,'value'=>$value));
                      echo $form->error($model,"[".$id."]".Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC,array('class' => 'invalid'));

                        //echo '<input type="text" name="question_'.$id.'" id="question_'.$id.'">';
                    }
	}

        public function getPublicMode($public)
	{           
                if($public == 1)
                {
                    echo CHtml::encode(Yii::t('components_utilityhtml', 'txt_public')); 
                }
                else
                {
                    echo CHtml::encode(Yii::t('components_utilityhtml', 'txt_private')); 
                }           
	}

        public function getTaskStatus($state)
	{            
//                if($state == Globals::DEFAULT_VAL_TASK_STATUS_OPEN)
//                {
//                    echo CHtml::encode(Yii::t('components_utilityhtml', 'txt_open'));
//                }
//                else
//                {
//                    echo CHtml::encode(Yii::t('components_utilityhtml', 'txt_not_open'));
//                }
                
                switch($state){
                    case 'o':
                        echo ucfirst (CHtml::encode(Yii::t('components_utilityhtml', 'txt_open')));
                    break;
                    case 'c':
                        echo ucfirst (CHtml::encode(Yii::t('components_utilityhtml', 'cancelled')));
                    break;
                    case 'a':
                        echo ucfirst (CHtml::encode(Yii::t('components_utilityhtml', 'assigned to tasker')));
                    break;
                    case 'f':
                        echo ucfirst (CHtml::encode(Yii::t('components_utilityhtml', 'finished')));
                    break;
                    case 'd':
                        echo ucfirst (CHtml::encode(Yii::t('components_utilityhtml', 'under dispute')));
                    break;
                    case 's':
                        echo ucfirst (CHtml::encode(Yii::t('components_utilityhtml', 'suspended')));
                    break;
                }
                
	}

        public function getUserName($id)
	{
            try
            {
                echo CommonUtility::getUserFullName($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
	}
        public function getReceivedUserName($id,$status)
	{
            try
            {
                if($status)
                {
                    
                    echo $username =  CommonUtility::getUserFullName($id);
//                    if(empty($username))
//                    {
//                        echo CommonUtility::getUserFullName($id);
//                    }
                }
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
	}


//        public function getCategoryImage($image)
//	{
//            if(!empty($image))
//                {
//                    $imageName =  Globals::BASH_URL.'/'.Globals::CATEGORY_IMAGE_UPLOAD_PATH.$image;
//                }
//            else
//                {
//                    $imageName = "../images/prv_img.jpg";
//                }
//            return $imageName;
//	}

//        public function getTemplateImage($taskImage,$categoryImage)
//	{
//            $imagePath = '';
//            if(!empty($taskImage))
//                {
////                    $imageName =  Globals::BASH_URL.'/'.Globals::CATEGORY_IMAGE_UPLOAD_PATH.$image;
//                    $imageName =  json_decode($taskImage,true);
//                    $totelArray = count($imageName);
//                    for($i=0;$i<$totelArray;$i++)
//                    {
//                        if(isset($imageName[$i]['type']))
//                            {
//                                if($imageName[$i]['type'] == "image")
//                                {
//    //                                echo $imageName[$i]['type'];
//                                    $imagePath =  Globals::FRONT_USER_VIEW_IMAGE_PATH.$imageName[$i]['file'];
//                                    break;
//                                }
//                                else
//                                {
//                                   $imagePath = "../images/prv_img.jpg";
//                                }
//                            }
//                    }
//                }
//            else if(!empty($categoryImage))
//                {
//                    $imagePath =  Globals::BASH_URL.'/'.Globals::CATEGORY_IMAGE_UPLOAD_PATH.$categoryImage;
////                      $imageName =  $categoryImage;
//                }
//            else
//                {
//                    $imagePath = "../images/prv_img.jpg";
//                }
////                print_r($imagePath);
//            return $imagePath;
//	}


//        public function getVideo($video)
//	{
//            if($video!='')
//            {
//                $baseUrl = Yii::app()->request->baseUrl;
//                $videoUrl=$baseUrl.'/video/'.$video;
//                
//               echo  CHtml::link("Click to view", $videoUrl);
//            }
//            else
//            {
//                echo 'No Video';
//            }
//                        
//              //  echo CHtml::image($imageUrl, 'No Image',array('width'=>60, 'height'=>60));
//		
//	}
        
        public function getStatusDropdown($model, $id, $value)
	{
		$className=get_class($model);
		$dropdownName=$className.'['.$id.']';
		echo CHtml::dropDownList($dropdownName, $id,
		array(
			""=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_select_status')),
                        Globals::DEFAULT_VAL_ACTIVE_STATUS_NUMBER =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_active'))
                    , Globals::DEFAULT_VAL_DEACTIVE_STATUS_NUMBER  =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_inactive'))
		),
		//array('class'=>'m-wrap span12'),
		array('options'=>array($value =>array('selected'=>true)))
		);
	}
        // Status for Active,In-active and Suspend
        public function getStatusDropdownAandNandS($model, $id, $value)
	{
		$className=get_class($model);
		$dropdownName=$className.'['.$id.']';
		echo CHtml::dropDownList($dropdownName, $id,
		array(
			""=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_select_status')),
                        Globals::DEFAULT_VAL_ACTIVE_STATUS_ALFABET =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_active'))
                    , Globals::DEFAULT_VAL_DEACTIVE_STATUS_ALFABET  =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_inactive'))
                    , Globals::DEFAULT_VAL_SUSPEND_STATUS_ALFABET  =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_suspend'))
		),
		//array('class'=>'m-wrap span12'),
		array('options'=>array($value =>array('selected'=>true)))
		);
	}
        
        // Status for Active and In-active (a & n)
        public function getStatusDropdownAandN($model, $id, $value)
	{
		$className=get_class($model);
		$dropdownName=$className.'['.$id.']';
		echo CHtml::dropDownList($dropdownName, $id,
		array(
			""=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_select_status')),
                        Globals::DEFAULT_VAL_ACTIVE_STATUS_ALFABET =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_active'))
                    , Globals::DEFAULT_VAL_DEACTIVE_STATUS_ALFABET  =>CHtml::encode(Yii::t('components_utilityhtml', 'txt_inactive'))                    
		),
		//array('class'=>'m-wrap span12'),
		array('options'=>array($value =>array('selected'=>true)))
		);
	}
    
	public function getLanguageDropdown($model, $id, $value='')
	{
                $className=get_class($model);
		$dropdownName=$className.'['.$id.']';
            
		$list = CHtml::listData(Language::getLanguageList(),  Globals::FLD_NAME_LANGUAGE_CODE, Globals::FLD_NAME_LANGUAGE_NAME);
                
		
		echo CHtml::dropDownList($dropdownName, Globals::FLD_NAME_LANGUAGE_CODE,$list,
		array('options'=>array($value =>array('selected'=>true),
                        ))
		);
                
               
		
	}
	public function flashMessage()
	{
                $flash_messages= '<div id="flash_messages">';
                //$flash_messages .= CJSON::nameValue("message", $response[0]);
                $flashMessages = Yii::app()->user->getFlashes();
                if ($flashMessages)
                {
                    foreach($flashMessages as $key => $message)
                    {
                        $flash_messages .= '<div class="flash-' . $key . ' ">' . $message . "</div>\n";
                        
                    }
                }
                $flash_messages .='</div>';
                echo $flash_messages;
        }
     
	 /**mukul's
	 * @param  $permissions role id.
	 * @return the table of controllers and actions
	 */
        
	public function renderPermissions($permissions)
	{
		  
		$theCellValue = '';
		if(isset($permissions) )
		{
			
			$permissions = CJSON::decode($permissions);
                        
			if(isset($permissions))
                        {
                            foreach($permissions as $permissionIndex => $permission)
                            {
                                    $theCellValue .= '';
                                    $theCellValue .= '<span class="roleLabel"><strong >'.$permissionIndex.'</strong></span><span class="roleList">';
                                    $permissionLength = count($permission);
                                    $i=1;
                                    if($permission)
                                    {
                                    foreach($permission as $actionIndex => $action)
                                    {
                                            if($permissionLength==$i)
                                            {
                                                    $theCellValue .= ''.$actionIndex.''; 
                                            }
                                            else 
                                            {
                                                    $theCellValue .= ''.$actionIndex.','; 
                                            }
                                            $i++;
                                    }
                                    }

                                    $theCellValue .= '</span><div class="clear"></div>';
                            }
                        }
			 $theCellValue .= '';
		}
		
		return $theCellValue;    
	}
	
	public function getPasswordImage($id)
	{
            $image=CHtml::image(Globals::IMAGE_PASSWORD_CHANGE, 
                    CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_change_password')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_change_password')),'width'=>'18','height'=>'15'));
            echo CHtml::link($image,array('/admin/userchangepassword?id='.$id), array('class'=>'hover'));

	}	
        public function getFrontUserPasswordImage($id)
	{
            $image=CHtml::image(Globals::IMAGE_PASSWORD_CHANGE, CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_change_password')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_change_password')),'width'=>'18','height'=>'15'));
            echo CHtml::link($image,array('/user/passwordchange?id='.$id), array('class'=>'hover'));

	}
        public function getUserDetailLink($id)
	{
            $name = CommonUtility::getUserFullName( $id );
            echo CHtml::link($name,array('/admin/user/view?id='.$id), array('class'=>'hover'));

	}
        public function setUserSessionLink($id)
	{
            $name = CommonUtility::getUserFullName( $id );
            echo CHtml::link($name,array('/user/selectusersession?id='.$id), array('class'=>'hover'));

	}
        public function getRegisteredDate($date)
        {
            $reg_date = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME,strtotime($date));
            echo $reg_date;
        }
        public function getSalutionDropdown($model,$id,$value)
	{
		$className=get_class($model);
		$dropdownName=$className.'['.$id.']';
		echo CHtml::dropDownList($dropdownName, $id,
		array(
                        'Mr.'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_mr')),
                        'Mrs.'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_mrs')),
                        'Miss.'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_miss')),
                        'Ms.'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_ms')),
                        'Dr.'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_dr')),
                        'Prof.'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_prof')),
                        'Rev.'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_rev')),
                    ),
		array('options'=>array($value =>array('selected'=>true)))
		
		);
	}
        
        public function getGender($genderSlug)
	{
            $gender = "-";
            if($genderSlug == Globals::DEFAULT_VAL_USER_GENDER_MALE)
            {
                $gender = CHtml::encode(Yii::t('components_utilityhtml', 'txt_male'));
            }
            elseif($genderSlug == Globals::DEFAULT_VAL_USER_GENDER_FEMALE)
            {
                $gender = CHtml::encode(Yii::t('components_utilityhtml', 'txt_female'));
            }
            return $gender;  
        }
        public function getChatDropdown($model,$id,$value,$class)
	{
		$className=get_class($model);
		$dropdownName=$className.$id;
		echo CHtml::dropDownList($dropdownName, $id,
		array(
			'Skype'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_skype')),
                        'Gmail'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_gmail')),
                        'Yahoo'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_yahoo')),
                        'Outlook'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_outlok')),
		),
		array('options'=>array($value =>array('selected'=>true)),
                    'class'=>$class)
		
		);
//                          $this->widget('ext.bootstrap-select.TbSelect',array(
//       'name' => $dropdownName,
//       'data' => array(
//			'Skype'=>'Skype','Gmail'=>'Gmail','Yahoo'=>'Yahoo','Outlook'=>'Outlook'
//		),
//                  
//       'htmlOptions' => array(
//           //'multiple' => true,
//           'options'=>array($value =>array('selected'=>true)),
//           'class'=>'span1'
//       ),
//));
//                          
	}
	
	 public function getWeakDropdown($model,$id,$value,$class)
	{
		$className=get_class($model);
		$dropdownName=$className.$id;
		echo CHtml::dropDownList($dropdownName, $id,
		array(
                    'all'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_all_days')),
                    'mon'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_monday')),
                    'tue'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_tuesday')),
                    'wed'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_wednesday')),
                    'thu'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_thursday')),
                    'fri'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_friday')),
                    'sat'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_saturday')),
                    'sun'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_sunday')),
		),
		array('options'=>array($value =>array('selected'=>true)),
                    'class'=>$class)
		
		);
	}
	 public function getCertificateDropdown($model,$id,$value,$class)
	{
		$className=get_class($model);
		$currentYear = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y);
		for($i= Globals::DEFAULT_VAL_CALENDER_START_YEAR;$i<=$currentYear;$i++)
                {
                    $array[$i]=$i;
                }
		$dropdownName=$className.$id;
		echo CHtml::dropDownList($dropdownName, $id,
		$array,
		array('options'=>array($value =>array('selected'=>true)),
                    'class'=>$class)
		
		);
	}
	public function getYearDropdown($model,$id,$value,$class)
	{
		$className=get_class($model);
		$currentYear =date(Globals::DEFAULT_VAL_DATE_FORMATE_Y);
                $array[""]=CHtml::encode(Yii::t('components_utilityhtml', 'txt_please_choose_year'));
		for($i=Globals::DEFAULT_VAL_CALENDER_START_YEAR;$i<=$currentYear;$i++)
                {
                    $array[$i]=$i;
                }
		$dropdownName=$className.'['.$id.']';
		echo CHtml::dropDownList($dropdownName, $id,
		$array,
		array('options'=>array($value =>array('selected'=>true)),
                    'class'=>$class)
		);
	}
	
	public function getCategoryDropdown($model,$id,$value)
	{
		$className=get_class($model);
		//$currentYear = date("Y");
		$list = CHtml::listData(Category::getCategoryList(),'category_id', 'categorylocale.category_name');
		//for($i=1940;$i<=$currentYear;$i++){
			//$list[]='';
			//}
		$dropdownName=$className.'['.$id.']';
		echo CHtml::dropDownList($dropdownName, $id,
		$list,
		array('options'=>array($value =>array('selected'=>true)),
                    'class'=>'span3 skills')
		
		);
                
	}
        public function getSocialDropdown($model,$id,$value)
	{
		$className=get_class($model);
		$dropdownName=$className.$id;
		echo CHtml::dropDownList($dropdownName, $id,
		array(
                    'Facebook'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_facebook')),
                    'Flicker'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_flicker')),
                    'Google+'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_google_plus')),
                    'Orkut'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_orkut')),
		),
		array('options'=>array($value =>array('selected'=>true)),
                    'class'=>'space form-control')
		
		);

	}
         public function getmonthDropdown($model,$id,$value)
	{
		$className=get_class($model);
		$dropdownName=$className.$id;
		echo CHtml::dropDownList($dropdownName, $id,
		array(
                    '1'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_jan')),
                    '2'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_feb')),
                    '3'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_mar')),
                    '4'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_apr')),
                    '5'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_may')),
                    '6'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_june')),
                    '7'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_july')),
                    '8'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_aug')),
                    '9'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_sept')),
                    '10'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_oct')),
                    '11'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_nov')),
                    '12'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_dec')),
		),
		array('options'=>array($value =>array('selected'=>true)),
                    'class'=>'form-control')
		
		);
	}
        public function getExpireYearDropdown($model,$id,$value)
	{
		$className=get_class($model);
		$currentYear = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y);
		for($i=$currentYear;$i<=$currentYear+Globals::DEFAULT_VAL_EXPERIANCE_YEAR_PLUS;$i++){
			$array[$i]=$i;
			}
		$dropdownName=$className.$id;
		echo CHtml::dropDownList($dropdownName, $id,
		$array,
		array('options'=>array($value =>array('selected'=>true)),
                    'class'=>'form-control')
		
		);
                
//                $this->widget('ext.bootstrap-select.TbSelect',array(
//       'name' => $dropdownName,
//       'data' => $array,
//                  
//       'htmlOptions' => array(
//           //'multiple' => true,
//           'options'=>array($value =>array('selected'=>true)),
//           'class'=>'span3'
//       ),
//));
                
                
	}
        public function userGetTemplateField($model,$num,$value='')
	{
           echo '               
                <div class="row-fluid removeControl" id="template'.$num.'">
               <div class="control-group">               
                    <label class="control-label" for="CategoryLocale_category_id_'.$num.'_title">Title</label>                          
                    <div class="controls">
                        <div class="span6 nopadding">
                        <input size="60" maxlength="250" class="span6 nopadding" value="" name="CategoryLocale[category_id_'.$num.'][title]" id="CategoryLocale_category_id_'.$num.'_title" type="text">                                                
                        </div>
                        <div class="span1 nopadding">
                        <a href="javascript:void(0)" id="addmore" onclick="addmoreCatTemplate('.$num.');" ><img src="'.Yii::app()->request->baseUrl.'/images/add-btn.png"></img></a>
                            <a href="javascript:void(0)" id="remTmpl" onclick="deleteTemplate('.$num.')">                    
                            <img src="'.Yii::app()->request->baseUrl.'/images/remove-btn.png"></img></a>
                        </div>
                        <span class="help-inline">
                        <div class="errorMessage" id="CategoryLocale_title_em_" style="display:none">
                        </div>
                        </span>
                    </div>                    
                </div>
                <div class="control-group">
                    <label class="control-label" for="CategoryLocale_category_id_'.$num.'_description">Description</label>                            
                    <div class="controls">
                    <textarea class="span7" maxlength="1000" rows="8" style="width: 468px; height: 131px;" name="CategoryLocale[category_id_'.$num.'][description]" id="CategoryLocale_category_id_'.$num.'_description"></textarea>                                        
                    <span class="help-inline"><div class="errorMessage" id="CategoryLocale_description_em_" style="display:none"></div></span></div>
                </div>
                </div>                                             
';   
	}
        
        public function userGetChatField($model,$num,$value='')
	{
            echo '  <div class="removeControl span4 nopadding">
                            <input id="User_chat_id_'.$num.'_chat_id" placeholder="'.CHtml::encode(Yii::t('components_utilityhtml', 'txt_chat_id {n}',$num)).'" class="span2 chat" type="text" value="" name="User[chat_id_'.$num.'][chat_id]">';
            try
            {
                UtilityHtml::getChatDropdown($model,'[chat_id_'.$num.'][chatidof]',$value,'space');
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            echo '          <span  class="help-block error" style="display: none"></span>
                    </div>';
   
	}
        public function userGetSocialField($model,$num,$value='')
	{
            echo '  <div class="removeControl span4 nopadding">
                            <input id="User_social_'.$num.'_social" placeholder="'.CHtml::encode(Yii::t('components_utilityhtml', 'txt_social_id {n}',$num)).'" class="span2 social" type="text" value="" name="User[social_'.$num.'][social]">';
            try
            {
                UtilityHtml::getSocialDropdown($model,'[social_'.$num.'][socialof]',$value);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            echo '          <span  class="help-block error" style="display: none"></span>
                    </div>';
	}
        public function userGetMobileField($model,$num)
	{
             echo ' <div class="removeControl span4 nopadding">
                            <input id="User_mobile_'.$num.'_mobile" placeholder="'.CHtml::encode(Yii::t('components_utilityhtml', 'txt_mobile_number {n}',$num)).'" class="span3 mobile number" type="text" value="" name="User[mobile_'.$num.'][mobile]">
                            <span  class="help-block error" style="display: none"></span>
                    </div>';
	}
        public function userGetCertfField($model,$nextnum,$value='')
	{
            echo '  <div class="removeControl span4 nopadding">
                    <input id="User_certificate_id_'.$nextnum.'_certificate" class="span2" type="text" name="User[certificate_id_'.$nextnum.'][certificate]" placeholder="'.CHtml::encode(Yii::t('components_utilityhtml', 'txt_enter_your_tag_line')).'">';
            try
            {
                UtilityHtml::getCertificateDropdown($model,'[certificate_id_'.$nextnum.'][certificateidof]',$value,'space');
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            echo '   <span  class="help-block error" style="display: none"></span></div>';
	}
        public function userGetEmailField($model,$nextnum)
	{
                echo '<div class="removeControl span4 nopadding">
                            <input id="User_email_'.$nextnum.'_email" placeholder="'.CHtml::encode(Yii::t('components_utilityhtml', 'txt_email_address {n}',$nextnum)).'" class="span3 email" type="text" value="" name="User[email_'.$nextnum.'][email]">
                            <span  class="help-block error" style="display: none"></span>
                        </div>
                        ';
	}
        public function userGetCertificatefield($model,$nextnum,$value='')
	{
            echo '  <div class="removeControl span4 nopadding">
                            <input id="User_certificate_id_'.$nextnum.'_certificate" placeholder="'.CHtml::encode(Yii::t('components_utilityhtml', 'txt_your_certificate {n}',$nextnum)).'" class="span2 certificate" type="text" value="" name="User[certificate_id_'.$nextnum.'][certificate]">';
            try
            {
                UtilityHtml::getCertificateDropdown($model,'[certificate_id_'.$nextnum.'][certificateidof]',$value,'space');
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            echo '      <span  class="help-block error" style="display: none"></span>
                    </div>';
	}
//        public function userGetCertificatefield($model,$nextnum,$value='')
//	{
//            echo '  <div class="removeControl span4 nopadding">
//                            <input id="User_certificate_id_'.$nextnum.'_certificate" placeholder="'.CHtml::encode(Yii::t('components_utilityhtml', 'txt_your_certificate {n}',$nextnum)).'" class="span2 certificate" type="text" value="" name="User[certificate_id_'.$nextnum.'][certificate]">';
//                            UtilityHtml::getCertificateDropdown($model,'[certificate_id_'.$nextnum.'][certificateidof]',$value,'space');
//            echo '      <span  class="help-block error" style="display: none"></span>
//                    </div>';
//            echo '  <div class="addRemove">
//                        <a href="javascript:void(0)" id="addmore" onclick="addmoreCertificate();" ><img src="'.Yii::app()->request->baseUrl.'/images/add-btn.png"></img></a>
//                        <a href="javascript:void(0)" id="remCertf"><img src="'.Yii::app()->request->baseUrl.'/images/remove-btn.png"></img></a>
//                    </div>
//                    <div id="fields"><input type="hidden" id="certfnum_'.$nextnum.'" name="totalCertfId" value="'.$nextnum.'"/></div>';
//                    
//	}
   
   
       public function getCategoryTemplatefield($model,$nextnum,$value='')
	{
           try
           {
                echo '  <div class="removeControl span4 nopadding">
                            <input id="User_certificate_id_'.$nextnum.'_certificate" placeholder="'.CHtml::encode(Yii::t('components_utilityhtml', 'txt_your_certificate {n}',$nextnum)).'" class="span2 certificate" type="text" value="" name="User[certificate_id_'.$nextnum.'][certificate]">';
                            UtilityHtml::getCertificateDropdown($model,'[certificate_id_'.$nextnum.'][certificateidof]',$value,'space');
                echo '      <span  class="help-block error" style="display: none"></span>
                    </div>';
           }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
	}
   
   
        public function userGetSkillsfield($model,$nextnum)
	{
            try
            {
             echo '<div class="removeControl span4 nopadding"><select id="User_skills_id_'.$nextnum.'_skills" name="User[skills_id_'.$nextnum.'_skills]" class ="span3 skills" >';
                            echo self::getCategoryListNasted('','');
				//UtilityHtml::getCategoryDropdown($model,'skills_id_'.$nextnum.'_skills',$model->work_start_year);
                            echo '</select><span  class="help-block error" style="display: none"></span>
                    </div>
                        ';
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
	}
        public function getPublicImage($status, $className, $id, $fieldName,$pkName,$grid)
	{
		$url='user/changepublicstatus';
		if ($status == Globals::DEFAULT_VAL_ACTIVE_STATUS_NUMBER || strtolower($status) == Globals::DEFAULT_VAL_ACTIVE_STATUS_YES ) 
		{
			$image=CHtml::image(Globals::IMAGE_STATUS_ACTIVE, CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_inactive')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_inactive'))));
			echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
				  array( 'type' => 'POST', 'success' => "function(data){ reloadGrid(data,'".$grid."') }",
				  'cache'=>false,
				),
				array( //htmlOptions
				'href' => Yii::app()->createUrl( $url.'?id='.$id.'&status=0&classname='.$className.'&fieldName='.$fieldName.'&pkName='.$pkName),
				'id'=>'changepublicstatus'.$grid
                                    )
			);		
		}
		else
		{
			$image=CHtml::image(Globals::IMAGE_STATUS_INACTIVE, CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_active')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'lbl_click_here_to_active'))));
			echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
				 array( 'type' => 'POST', 'success' => "function(data){ reloadGrid(data,'".$grid."') }",
				 'cache'=>false,
				),
				array( 
                                        'href' => Yii::app()->createUrl( $url.'?id='.$id.'&status=1&classname='.$className.'&fieldName='.$fieldName.'&pkName='.$pkName),
                                        'id'=>'changepublicstatus'.$grid
                                    )
		  	);	
		}
	}
        public function getUpdateImage($task ,$status)
	{
		$url='user/userupdateportfolio';
                try
                {
                    if($status=='p')
                    {
                            $image=CHtml::image(CommonUtility::getPublicImageUri(Globals::IMAGE_EDIT_ACTIVE), CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_edit')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_edit'))));
                            echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
                                    array( 'type' => 'POST', 'success' => 'function(data){$(\'#addContent\').html(data);}',
                                    'cache'=>false,
                                    ),
                                    array( //htmlOptions
                                    'href' => Yii::app()->createUrl( $url.'?id='.$task),
                                        'id'=>'updateportfolio'
                                    )
                            );	
                    }
                    else
                    {
                        $image = CHtml::image(CommonUtility::getPublicImageUri(Globals::IMAGE_EDIT_INACTIVE), CHtml::encode(Yii::t('components_utilityhtml', 'txt_varified_task_not_editable')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_varified_task_not_editable'))));
                            echo CHtml::Link($image, '',
                                    array( 'type' => 'POST', 'success' => 'function(data){$(\'#addContent\').html(data);}',
                                    'cache'=>false,
                                    ),
                                    array( //htmlOptions

                                        'disabled' =>true
                                    )
                            );
                    }
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
		
	}
        public function getDeleteImage($task ,$status,$grid)
	{
		$url='user/userdeleteportfolio';
                try
                {
                    $image=CHtml::image(CommonUtility::getPublicImageUri(Globals::IMAGE_DELETE_ACTIVE), CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_delete')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_delete'))));
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
                            array( 'type' => 'POST', 'success' => "function(data){ reloadGrid(data,'".$grid."') }",
                            'cache'=>false,
                        ),
                        array( //htmlOptions
                        'href' => Yii::app()->createUrl( $url.'?id='.$task),
                            'confirm'=> CHtml::encode(Yii::t('components_utilityhtml', 'txt_are_you_sure_to_delete_this_task')),
                            'id'=>'deleteportfolio'.$grid
                        )
                );	
	
	}
        public function taskSkills($task_id)
        {
            $return = "";
            try
            {
                $skills = TaskSkill::getTaskSkills($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            $count = 0;
            $return .= "<ul>";
  			//echo $return;exit;
            foreach ($skills as $skill)
            {
                
                $return .= "<li>".$skill->skilllocale->skill_desc."</li>";
                if($count%Globals::DEFAULT_VAL_SKILLS_DISPLAY_IN_COLUMN == 0)
                {
                    $return .= "</ul><ul>";
                }
                $count++;
            }
            $return .= "</ul>";
            return $return;
        }
        public function taskSkillsCommaSeparated($task_id)
        {
            $return = "";
            try
            {
                $skills = TaskSkill::getTaskSkills($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            $count = 0;            
  			//echo $return;exit;
            foreach ($skills as $skill)
            {
                
                $return .= $skill->skilllocale->skill_desc.", ";
                if($count%Globals::DEFAULT_VAL_SKILLS_DISPLAY_IN_COLUMN == 0)
                {
                    $return .= "";
                }
                $count++;
            }                             
            return substr($return, 0, -2);
        }
        public function getAttachments($attachments,$fileFolder,$id)
        {
            $return = "";
            if (isset($attachments)) 
                {
                    try
                    {
                        $attachmentFile = CommonUtility::getTaskAttachmentFiles($attachments);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                    $imageCount = 0;
                    if (isset($attachmentFile) && $attachmentFile != '') 
                    {
                        foreach ($attachmentFile as $index => $file) 
                        {
                            $key = str_replace($fileFolder. "/", '', $file);
                            try
                            {
                                $fileUrl = CommonUtility::getTaskAttachmentURI($id,$key);
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg  );
                            }
                            try
                            {
                                $fileType = CommonUtility::CheckFileType( $key );
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg  );
                            }
                
                            try
                            {
                                $return .=  '<div class="postedbyAttachments imagesPreview">';
                                switch ($fileType)
                                {
                                    case Globals::DEFAULT_VAL_IMAGE_TYPE: 

                                                    $smallImage = CommonUtility::getTaskAttachmentSmallImageURL($fileUrl);
                                                    $return .= '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_IMAGE.'" ></a>';
                                            break;

                                    case Globals::DEFAULT_VAL_VIDEO_TYPE: 
                                        //echo $fileUrl;
                                                    $return .=   ''.CHtml::ajaxLink('<img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_VIDEO_IMAGE.'" >', Yii::app()->createUrl('index/playvideo')."?url=".$fileUrl,
                                                                array('success'=>'function(data){ $(\'#playVideo\').css("display","block");$(\'#playVideo\').html(data);}'),array('id' => "attachmentVideo".$imageCount));

                                            break;
                                    case Globals::DEFAULT_VAL_DOC_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_DOC_IMAGE.'" ></a>';
                                                    break;

                                    case Globals::DEFAULT_VAL_EXCEL_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_EXCEL_IMAGE.'" ></a>';
                                                    break;


                                    case Globals::DEFAULT_VAL_PDF_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_PDF_IMAGE.'" ></a>';
                                                    break;   

                                    case Globals::DEFAULT_VAL_ZIP_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_ZIP_IMAGE.'" ></a>';
                                                    break; 
                                    case Globals::DEFAULT_VAL_PPT_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_PPT_IMAGE.'" ></a>';
                                                    break;

                                    default: 
                                                $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::IMAGE_DOWNLOAD.'" ><p>'.$fileType.'</p></a>';
                                }///
                                $return .=  ' <span class="attachFileName">'.CommonUtility::getImageDisplayName($key).'</span></div>';
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg  );
                            }
                            
                            $imageCount++;
                        }
                        $return .=   '<div id="playVideo" class="window" style="display: none"></div>';
                    }
                      
                }
                
           return $return;
                        
        }
        public function getProposalAttachments($attachments,$fileFolder,$id)
        {
            $return = "";
            if (isset($attachments)) 
                {
                    try
                    {
                        $attachmentFile = CommonUtility::getTaskAttachmentFiles($attachments);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                    $imageCount = 0;
                    if (isset($attachmentFile) && $attachmentFile != '') 
                    {
                        foreach ($attachmentFile as $index => $file) 
                        {
                            $key = str_replace($fileFolder. "/", '', $file);
                            try
                            {
                                $fileUrl = CommonUtility::getProposalAttachmentURI($id,$key);
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg  );
                            }
                            try
                            {
                                $fileType = CommonUtility::CheckFileType( $key );
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg  );
                            }
                
                            try
                            {
                                
                                $return .=  '<div class="postedbyAttachments imagesPreview">';
                                switch ($fileType)
                                {
                                    case Globals::DEFAULT_VAL_IMAGE_TYPE: 

                                                    $smallImage = CommonUtility::getTaskAttachmentSmallImageURL($fileUrl);
                                                    $return .= '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_IMAGE.'" ></a>';
                                            break;

                                    case Globals::DEFAULT_VAL_VIDEO_TYPE: 
                                        //echo $fileUrl;
                                                    $return .=   ''.CHtml::ajaxLink('<img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_VIDEO_IMAGE.'" >', Yii::app()->createUrl('index/playvideo')."?url=".$fileUrl,
                                                                array('success'=>'function(data){ $(\'#playVideo\').css("display","block");$(\'#playVideo\').html(data);}'),array('id' => "attachmentVideo".$imageCount));

                                            break;
                                    case Globals::DEFAULT_VAL_DOC_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_DOC_IMAGE.'" ></a>';
                                                    break;

                                    case Globals::DEFAULT_VAL_EXCEL_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_EXCEL_IMAGE.'" ></a>';
                                                    break;


                                    case Globals::DEFAULT_VAL_PDF_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_PDF_IMAGE.'" ></a>';
                                                    break;   

                                    case Globals::DEFAULT_VAL_ZIP_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_ZIP_IMAGE.'" ></a>';
                                                    break; 
                                    case Globals::DEFAULT_VAL_PPT_TYPE : 
                                                    $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_PPT_IMAGE.'" ></a>';
                                                    break;

                                    default: 
                                                $return .=   '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::IMAGE_DOWNLOAD.'" ><p>'.$fileType.'</p></a>';
                                }///
                                $return .=  ' <span class="attachFileName">'.CommonUtility::getImageDisplayName($key).'</span></div>';
                                
                                /////////////////////////
//                                switch ($fileType)
//                                {
//                                    case Globals::DEFAULT_VAL_IMAGE_TYPE: 
//
//                                                    $smallImage = CommonUtility::getTaskProposalAttachmentSmallImageURL($fileUrl);
//                                                    $return .= '<div class="postedby"><a target="_blank" href="'.$fileUrl.'" ><img src="'.$smallImage.'" ><p>'.$fileType.'</p></a></div>';
//                                            break;
//
//                                    case Globals::DEFAULT_VAL_VIDEO_TYPE: 
//                                                    $return .=   '<div class="postedby">'.CHtml::ajaxLink('<img style="height: 80px; width: 80px;" src="'.Globals::IMAGE_DOWNLOAD.'" ><p>'.$fileType.'</p>', Yii::app()->createUrl('index/playvideo')."?url=".$fileUrl,
//                                                                array('success'=>'function(data){ $(\'#playVideo\').css("display","block");$(\'#playVideo\').html(data);}'),array('id' => "proposalAttachmentVideo".$imageCount)).'</div>';
//
//                                            break;
//
//                                    default: 
//                                                $return .=   '<div class="postedby"> <a target="_blank" href="'.$fileUrl.'" ><img style="height: 80px; width: 80px;" src="'.Globals::IMAGE_DOWNLOAD.'" ><p>'.$fileType.'</p></a></div>';
//                                }////////////////////
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg  );
                            }
                            
                            $imageCount++;
                        }
                        $return .=   '<div id="playVideo" class="window" style="display: none"></div>';
                    }
                      
                }
                
           return $return;
                        
        }
        
       
        
        public function getAttachmentsOnEdit($attachments,$fileFolder,$id,$name='portfolioimages', $type = 'task')
        {
            
            $return = "";
            if (isset($attachments)) 
                {
//                    try
//                    {
//                        $attachmentFile = CommonUtility::getTaskAttachmentFiles($attachments);
//                    }
//                    catch(Exception $e)
//                    {             
//                        $msg = $e->getMessage();
//                        CommonUtility::catchErrorMsg( $msg  );
//                    }
                    $imageCount = 0;
                    if (isset($attachments) && $attachments != '') 
                    {
                         $attachmentFile = CJSON::decode($attachments);
                        foreach ($attachmentFile as $index => $file) 
                        {
                            $key = str_replace($fileFolder. "/", '', $file[Globals::FLD_NAME_FILE]);
                            if($type == 'proposal')
                            {
                                $fileUrl = CommonUtility::getProposalAttachmentURI($id,$key);
                            }
                            else
                            {
                                $fileUrl = CommonUtility::getTaskAttachmentURI($id,$key);
                            }
                            //
                              //  $fileUrl = '';    
                            $fileType = CommonUtility::CheckFileType( $key );
                            $fileDetail = explode('.', $key);
                            $fileName = $fileDetail[0];
                         
                                   
                                   
                            $return .= ' <input type="hidden" name="portfolioimagestoremove[]" value="'.$key.'" />
                                                <div class="imagesPreview postedby '.$fileName.'" id="'.$fileName.'">';
                            try
                            {
                                switch ($fileType)
                                {
                                    case Globals::DEFAULT_VAL_IMAGE_TYPE: 

                                                    $smallImage = CommonUtility::getTaskAttachmentSmallImageURL($fileUrl);
                                                    $return .= '<a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.$smallImage.'" /></a>';

                                                    break;

                                    case Globals::DEFAULT_VAL_VIDEO_TYPE: 

                                                    $return .=   CHtml::ajaxLink('<img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_VIDEO_IMAGE.'" >', Yii::app()->createUrl('index/playvideo')."?url=".$fileUrl,
                                                            array('success'=>'function(data){ $(\'#playVideo\').css("display","block");$(\'#playVideo\').html(data);}'),array('id' => "attachmentVideo".$imageCount));
                                                    break;

                                    case Globals::DEFAULT_VAL_DOC_TYPE : 

                                                    $return .= ' <a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_DOC_IMAGE.'" ></a>';
                                                    break;

                                    case Globals::DEFAULT_VAL_EXCEL_TYPE : 
                                                    $return .= ' <a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_EXCEL_IMAGE.'" ></a>';
                                                    break;

                                    case Globals::DEFAULT_VAL_PDF_TYPE : 
                                                    $return .= ' <a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_PDF_IMAGE.'" ></a>';
                                                    break;   
                                    case Globals::DEFAULT_VAL_ZIP_TYPE : 
                                                    $return .= ' <a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_ZIP_IMAGE.'" ></a>';
                                                    break; 
                                    case Globals::DEFAULT_VAL_PPT_TYPE : 
                                                    $return .= ' <a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_PPT_IMAGE.'" ></a>';
                                                    break;
                                    default: 
                                                    $return .= ' <a target="_blank" href="'.$fileUrl.'" ><img style="height: 50px; width: 40px;" src="'.Globals::IMAGE_DOWNLOAD.'" ><p>'.$fileType.'</p></a>';
                                }///
                            }
                            catch(Exception $e)
                            {             
                                $msg = $e->getMessage();
                                CommonUtility::catchErrorMsg( $msg  );
                            }
                            $return .= '    <input type="hidden" name="'.$name.'[]" value="'.$key.'" />
                                            <input type="hidden" value="'.$file[Globals::FLD_NAME_FILESIZE].'" name="'.$fileName.'_size" id="'.$fileName.'_size">
                                            <span class="attachFileName">'.CommonUtility::getImageDisplayName($key).'</span>
                                            <a class="removeAttachment" title="click here to remove file" onclick="$(this).parent().remove();"><img src="'.Globals::IMAGE_REMOVE.'" ></a>
                                        </div>';
                            $imageCount++;
                        }
                    }
                }
           return $return;
           
           ////
//            $return = "";
//            if (isset($attachments)) 
//                {
//                    $allowArray = Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS];
//                    foreach ($allowArray as $extension)
//                    {
//                        $typeArr[] = $extension[Globals::FLD_NAME_TYPE];
//                    }
//                    $allawTypes = array_unique($typeArr);
//                    $fileTypesInArray = CommonUtility::getPortfolioAttachmentFileTypes($attachments);
//                    $key = '';
//            
////                    foreach ($attachments as $attachment)
////                    {
////                        echo $attachment;
////                    }
//                    foreach ($allawTypes as $type)
//                    {
//                        
//                        if(in_array($type, $fileTypesInArray))
//                        {
//                            //echo $type;
//                            $attachmentFile = CommonUtility::getPortfolioAttachmentUrlFromJson($attachments, $type,  Globals::IMAGE_THUMBNAIL_DEFAULT);
//                            $imageCount = 0;
//                            if (isset($attachmentFile) && $attachmentFile != '') 
//                            {
//                                foreach ($attachmentFile as $index => $file) 
//                                {
//                                    echo $file;
//                                  echo $key = str_replace($fileFolder. "/", '', $index);
//                                   $return .= ' <input type="hidden" name="portfolioimagestoremove[]" value="'.$key.'" />
//                                                <div class="imagesPreview postedby ">';
//                                    if($type == 'image')
//                                    {
//                                         $return .= '<a target="_blank" href="'.$file.'" ><img  src="'.$file.'" /><p>'.$type.'</p></a>';
//                                    }
//                                    elseif ($type == 'video') 
//                                    {
//                                        $return .=   CHtml::ajaxLink('<img style="height: 80px; width: 80px;" src="'.Globals::IMAGE_DOWNLOAD.'" ><p>'.$type.'</p>', Yii::app()->createUrl('index/playvideo')."?url=".$file,
//                                                        array('success'=>'function(data){ $(\'#playVideo\').css("display","block");$(\'#playVideo\').html(data);}'),array('id' => "attachmentVideo".$imageCount));
//                                    }
//                                    elseif ($type == 'doc' ) 
//                                    {
//                                        $return .= ' <a target="_blank" href="'.$file.'" ><img style="height: 50px; width: 40px;" src="'.Globals::ATTACHMENT_TYPE_DOC_IMAGE.'" ><p>'.$type.'</p></a>';
//                                    }
//                                    else
//                                    {
//                                        $return .= ' <a target="_blank" href="'.$file.'" ><img style="height: 50px; width: 40px;" src="'.Globals::IMAGE_DOWNLOAD.'" ><p>'.$type.'</p></a>';
//                                    }
//                                    $return .= '<input type="hidden" name="'.$name.'[]" value="'.$key.'" />
//                                                <a class="removeAttachment" title="click here to remove file" onclick="$(this).parent().remove();"><img src="'.Globals::IMAGE_REMOVE.'" ></a>
//                                                </div>';
//                                    $imageCount++;
//                                }
//                            }
//                        }
//                        
//                    }
//                }
//                
//           return $return;
                        
        }
        public function userSkills($id , $class='' , $countLi = Globals::DEFAULT_VAL_SKILLS_DISPLAY_IN_COLUMN  )
        {
            $return = "";
            try
            {
                $skills = UserSpeciality::getSkills($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            $count = 1;
            
            if(!empty($skills))
            {
                $return .= "<div class = '".$class."'><ul>";
                foreach ($skills as $skill)
                {

                    $return .= "<li>".$skill."</li>";
                    if($count%$countLi == 0)
                    {
                        $return .= "</ul>
                            </div><div class = '".$class."'><ul>";
                    }
                    $count++;
                }
                $return .= "</ul></div>";
            }
            
            return $return;
        }
        public function userSkillsCommaSeprated($id)
        {
            $return = "";
            try
            {
                $skills = UserSpeciality::getSkills($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            //print_r($skills);exit;
            $count = 1;
            if(!empty($skills))
            {
                foreach ($skills as $skill)
                {
                    if($count == count($skills))
                    {
                           $return .= "".$skill." ";
                    }
                    else 
                    {
                       $return .= "".$skill.", ";
                    }
                    $count++;
                }
            }
            //echo $return;exit;
            return $return;
        }
        
        function getPriceOfTask($task_id)
	{
                $returnData= '';
                $model=Task::model()->findByPk( $task_id );
                if($model)
                {
//                    $returnData= '<span class="point">';
//                    $returnData .= Globals::DEFAULT_CURRENCY.intval($model->{Globals::FLD_NAME_PRICE});
//                    $returnData .= '</span><br/>';
//                    //echo $model->{Globals::FLD_NAME_PAYMENT_MODE};
                    if($model->{Globals::FLD_NAME_PAYMENT_MODE} == 'f')
                    {
                        $returnData .=  CHtml::encode(Yii::t('poster_createtask', 'Fixed')); 
                    }
                    elseif ($model->{Globals::FLD_NAME_PAYMENT_MODE} == 'b') 
                    {
                        $returnData .=  CHtml::encode(Yii::t('poster_createtask', 'Open bid')); 
                    }
                    elseif ($model->{Globals::FLD_NAME_PAYMENT_MODE} == 'h') 
                    {
                        $returnData .=  CHtml::encode(Yii::t('poster_createtask', 'Hourly')); 
                    }
                }
		return $returnData;
	}
        function getBidStatus($date)
	{
                $returnData= '';
                if($date)
                {   
                    try
                    {
                        $timeLeft=CommonUtility::leftTiming($date);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                    if($timeLeft > 0)
                    {
                        $returnData= '<span class="point">';
                        $returnData .= $timeLeft;
                        $returnData .= '</span><br/>';
                        $returnData .=  CHtml::encode(Yii::t('poster_createtask', 'txt_days_left'));; 
                    }
                    elseif($timeLeft == 0)
                    {
                        $returnData= '<span class="">';
                        $returnData .= CHtml::encode(Yii::t('poster_createtask', 'txt_task_ends_today'));
                        $returnData .= '</span>';
                    }
                    else
                    {
                        $returnData= '<span class="">';
                        $returnData .= CHtml::encode(Yii::t('poster_createtask', 'txt_task_closed'));
                        $returnData .= '</span>';
                    }
                }
                else 
                {
                    $returnData= '<span class="">';
                    $returnData .= CHtml::encode(Yii::t('poster_createtask', 'txt_task_bid_not_started'));
                    $returnData .= '</span>';
                }
		return $returnData;
	}
        function getBidStatusInstant($time)
	{
                try
                {
                    $timeLeft = CommonUtility::timeleft($time);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                if($timeLeft['d']>0)
                {
                        $returnData= '<span class="point">';
                        $returnData .= $timeLeft['d'];
                        $returnData .= '</span><br/>';
                        $returnData .=  CHtml::encode(Yii::t('components_utilityhtml', 'txt_days_left'));
                    
                }
                elseif($timeLeft['h']>0)
                {
                        $returnData= '<span class="point">';
                        $returnData .= $timeLeft['h'];
                        $returnData .= '</span><br/>';
                        $returnData .=  CHtml::encode(Yii::t('components_utilityhtml', 'txt_hours_left'));;
                }
                elseif($timeLeft['m']>0)
                {
                        $returnData= '<span class="point">';
                        $returnData .= $timeLeft['m'];
                        $returnData .= '</span><br/>';
                        $returnData .=  CHtml::encode(Yii::t('components_utilityhtml', 'txt_minutes_left'));;
                }
                else
                {
                        $returnData= '<span class="">';
                        $returnData .= CHtml::encode(Yii::t('poster_createtask', 'txt_task_closed'));
                        $returnData .= '</span>';
                }
               
		return $returnData;
	}
        
        function getAjaxLoading($id)
	{
             $returnData= '<div  class="loadingOverlay hideLoader" id="'.$id.'" ></div>';
             $returnData.= '<div class="loaderImg hideLoader">
                                <img src="'.Globals::IMAGE_AJAX_LOADING.'">
                            </div>';
                       
                        return $returnData;
        }
        public function getVirtualTaskCategoryListNasted($selected_cat_id='',$level_string='')
	{  
            $select_str='';
            if(!$level_string)
            {
                $level_string='';
            }
            try
            {
                $category = Category::getVirtualCategoryListParentOnly();
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $select_str = self::getCreateCategoryOptionsNasted($category,$selected_cat_id,$level_string);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $select_str; 
                        
        } 
        public function getCategoryListNastedInTaskSearch($taskType = '' , $selected_cat_id='' , $level_string='')
	{  
            $select_str='';
            if(!$level_string)
            {
                $level_string='';
            }
            if( $taskType == Globals::DEFAULT_VAL_TASK_TYPE)
            {
                $taskType = '';
            }
           // echo $taskType;
            try
            {
                $category = Category::getParentCategory($taskType);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $select_str = self::getCreateCategoryCheckboxNested($category,$selected_cat_id,$level_string);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $select_str; 
                        
        } 
        public function getUserSkillsListInTaskSearch( $user_id )
	{  
            $select_str='';
            try
            {
                $skills = UserSpeciality::getUserSkills( $user_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
           
            if ($skills) 
            {
                foreach ($skills as $skill) 
                {
                    $select_str .= '<div class="advnc_row3"><label class="checkbox chkcolor">'.CHtml::checkBox("skills[]", false ,array('id' =>"skill_".$skill->skilllocale->{Globals::FLD_NAME_SKILL_ID} , 'value'=>$skill->skilllocale->{Globals::FLD_NAME_SKILL_ID} , 'class' => 'skills') ).$skill->skilllocale->{Globals::FLD_NAME_SKILL_DESC}.'</label></div>';
//                    
                }
            }
            return $select_str; 
                        
        } 
         public function getCreateCategoryCheckboxNested($category,$selected_cat_id='',$level_string='')
	{  
            $select_str = '';
            if ($category) 
            {
                foreach ($category as $parentcat) 
                {
                    $select_str .= $level_string.'<div id="catIdRow_'.$parentcat["categorylocale"]["category_id"].'" class="advnc_row3"><label class="checkbox chkcolor">'.CHtml::link($parentcat["categorylocale"]["category_name"],CommonUtility::getParentCategoryURI($parentcat["categorylocale"]["category_id"]),array('id' => Globals::URL_CATEGORY_TYPE_SLUG.$parentcat["categorylocale"]["category_id"] , 'data-id' =>$parentcat["categorylocale"]["category_id"] )).'</label></div>
                        <div class="advnc_col6"></div>
';
                }
            }
            return $select_str;
                        
        } 
         public function getCategoryChildCheckBox($notIn,$cat_id, $selected_cat_id, $level_string) 
        {
            $select_str='';
            if(!$level_string)
            {
                $level_string='';
            }
            try
            {
                $cat_arr = Category::getChildCategoryByID($cat_id , $notIn);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if ($cat_arr) 
            {
                foreach ($cat_arr as $cat) 
                {
                    
                    $select_str .= $level_string.'<div class="advnc_col6"><label class = "checkbox chkcolor">'.CHtml::checkBox("category_".$cat->categorylocale->category_id, false ).$cat->categorylocale->category_name.'</label></div>';
//
//                    $shift = Globals::DEFAULT_VAL_CATEGORY_DROPDOWN_IMAGE_PADDING + strlen($level_string);
//                    $shiftData = Globals::DEFAULT_VAL_CATEGORY_DROPDOWN_DATA_PADDING + strlen($level_string);
//                    $select_str.="<option style=\"background: url(".CommonUtility::getCategoryThumbnailImageURI($cat->categorylocale->category_id,  Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35 ).") ".$shift."px no-repeat;padding: 10px 0 10px  ".$shiftData."px;\" value={$cat->categorylocale->category_id}";
//                    if($selected_cat_id==$cat->categorylocale->category_id)
//                        $select_str.= ' selected';
//                    $select_str.=">{$level_string}{$cat->categorylocale->category_name}</option>";
                    $select_str.= self::getCategoryChildCheckBox($notIn,$cat->categorylocale->category_id, $selected_cat_id, $level_string.'&nbsp&nbsp&nbsp&nbsp');
                }
            }
            else
            {
                return false;
            }
            return $select_str;
        }
        public function getCategoryChild($notIn,$cat_id, $selected_cat_id, $level_string) 
        {
            $select_str='';
            if(!$level_string)
            {
                $level_string='';
            }
            try
            {
                $cat_arr = Category::getChildCategoryByID($cat_id , $notIn);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if ($cat_arr) 
            {
                foreach ($cat_arr as $cat) 
                {
                    $shift = Globals::DEFAULT_VAL_CATEGORY_DROPDOWN_IMAGE_PADDING + strlen($level_string);
                    $shiftData = Globals::DEFAULT_VAL_CATEGORY_DROPDOWN_DATA_PADDING + strlen($level_string);
                    $select_str.="<option style=\"background: url(".CommonUtility::getCategoryThumbnailImageURI($cat->categorylocale->category_id,  Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35 ).") ".$shift."px no-repeat;padding: 10px 0 10px  ".$shiftData."px;\" value={$cat->categorylocale->category_id}";
                    if($selected_cat_id==$cat->categorylocale->category_id)
                        $select_str.= ' selected';
                    $select_str.=">{$level_string}{$cat->categorylocale->category_name}</option>";
                    $select_str.= self::getCategoryChild($notIn,$cat->categorylocale->category_id, $selected_cat_id, $level_string.'&nbsp&nbsp&nbsp&nbsp');
                }
            }
            else
            {
                return false;
            }
            return $select_str;
        }
        public function getCategoryListNasted($notIn='',$selected_cat_id='',$level_string='')
	{  
            $select_str='';
           if(!$level_string)
            {
                $level_string='';
            }
            try
            {
                $category = Category::getParentCategory($notIn);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $select_str = self::getCreateCategoryOptionsNasted($category,$selected_cat_id,$level_string);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $select_str;        
        }  
        public function getCreateCategoryOptionsNasted($category,$selected_cat_id='',$level_string='')
	{  
            $select_str = '';
            if ($category) 
            {
                foreach ($category as $parentcat) 
                {
                    try
                    {
                        $select_str.="<option disabled='disabled' style=\"background: url(".CommonUtility::getCategoryThumbnailImageURI($parentcat->categorylocale->category_id, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35).") left no-repeat;padding: 10px 0 10px 40px;\" value={$parentcat->categorylocale->category_id}";
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                    if($selected_cat_id==$parentcat->categorylocale->category_id)
                    $select_str.= ' selected';
                    $select_str.=">{$level_string}{$parentcat->categorylocale->category_name}</option>";
                    try
                    {
                        $select_str.= self::getCategoryChild('',$parentcat->categorylocale->category_id, $selected_cat_id, $level_string.'&nbsp&nbsp&nbsp&nbsp');
                
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                }
            }
            return $select_str;
                        
        } 
        public function getCategoryListArray()
	{        
            $parentArray = array();            
            $parentCategories = Category::getCategoryListParentOnly(); 
            foreach($parentCategories as $parentCategory)
            {
                $chieldcategories = Category::getChildCategoryByID($parentCategory['category_id']);
                $chieldArray = array();
                foreach($chieldcategories as $chieldcategory)
                {
                    $chieldArray[$chieldcategory['category_id']] = $chieldcategory['categorylocale']['category_name'];
                }
                $parentArray[$parentCategory['categorylocale']['category_name']] = $chieldArray;
            }
            return $parentArray;
        } 
        
        
         public function getTaskDetailLink($task_id)
	{
            echo  CHtml::link(CHtml::encode(Yii::t('components_utilityhtml', 'txt_view_task')), CommonUtility::getTaskDetailURI($task_id), array('class' => ''));
         }
         public function getTaskState($state , $type = 'small')
        {
            $result = '';
           
            switch($state)
            {
                case Globals::DEFAULT_VAL_TASK_STATUS_OPEN:
                        $result = "<div class='item_labelblue'><span class='task_label_text3'>".Yii::t('components_utilityhtml', 'txt_open')."</span></div>";
                        break;
                case Globals::DEFAULT_VAL_TASK_STATUS_CANCELED:
                        $result = "<div class='item_labelblack'><span class='task_label_text3'>".Yii::t('components_utilityhtml', 'cancel_text')."</span></div>";
                        break;
                case Globals::DEFAULT_VAL_TASK_STATUS_FINISHED:
                        $result = "<div class='item_label'><span class='task_label_text3'>".Yii::t('components_utilityhtml', 'txt_close')."</span></div>";
                        break;
                default :
                     $result = "<div class='item_labelgreen'><span class='task_label_text3'>".Yii::t('components_utilityhtml', 'txt_awarded')."</span></div>";
            }
           return $result;
        }
        public function getTaskCategory($state,$data)
        {
            $result = '';
            try
            {
                $category  = TaskCategory::getTaskCategoryName($data->{Globals::FLD_NAME_TASK_ID});
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $taskers = GetRequest::getInvitedTaskerForTask($data->{Globals::FLD_NAME_TASK_ID});
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            switch($state)
            {
                 case Globals::DEFAULT_VAL_TASK_STATUS_OPEN:
                        if($category)
                        {
                            $result .= CHtml::encode(Yii::t('poster_createtask', 'lbl_task_category')).":";
                            $result .= "<span class='greentext'>".$category[0]->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME}."</span>";
                        }
                        $result .= "|".CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')).":";
                        if( $data->{Globals::FLD_NAME_INVITED_CNT} > 0)
                        {
                            $result .= "<span class='greentext popovercontent' id='lbl_invited".$data->{Globals::FLD_NAME_TASK_ID}."' title='".Yii::t('components_utilityhtml', 'txt_invited_taskers')."' data-placement='left' data-poload='".Yii::app()->createUrl('commonfront/invitedtaskerspopover')."?".Globals::FLD_NAME_TASK_ID."=".$data->{Globals::FLD_NAME_TASK_ID}."'>".$data->{Globals::FLD_NAME_INVITED_CNT}."</span>";
                        }
                        else
                        {
                            $result .= "<span class='greentext' id='lbl_invited".$data->{Globals::FLD_NAME_TASK_ID}."' >".$data->{Globals::FLD_NAME_INVITED_CNT}."</span>";
                        }
                        $result .= "|".CHtml::encode(Yii::t('poster_createtask', 'lbl_accepted')).":";
                        $result .= "<span class='greentext' id='lbl_accepted".$data->{Globals::FLD_NAME_TASK_ID}."' data-placement='left' title='ajax:testnew.html'>".$data->{Globals::FLD_NAME_INVITED_CNT}."</span>";
                        $result .= "|".CHtml::encode(Yii::t('poster_createtask', 'lbl_responded')).":";
                        $result .= "<span class='greentext'>".$data->{Globals::FLD_NAME_INVITED_CNT}."</span>";
                        break;
                case Globals::DEFAULT_VAL_TASK_STATUS_CANCELED:
                        $result = CHtml::encode(Yii::t('poster_createtask', 'lbl_task_category')).":
                        <span class='greentext'>".$category[0]->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME}."</span>";
                        break;
                case Globals::DEFAULT_VAL_TASK_STATUS_FINISHED:
                        $getRatingStar = UtilityHtml::ratingstar($data->{Globals::FLD_NAME_RANK});
                        $result .= CHtml::encode(Yii::t('poster_createtask', 'lbl_task_done_by')).":";
                        $result .= "<span class='greentext'>".$data->{Globals::FLD_NAME_REF_DONE_BY_NAME}."</span>";
                        $result .= "|".CHtml::encode(Yii::t('poster_createtask', 'lbl_task_work_duration')).":";
                        $result .= "<span class='greentext'>".$data->{Globals::FLD_NAME_INVITED_CNT}."</span>";
                        $result .= "|".CHtml::encode(Yii::t('poster_createtask', 'lbl_task_budget')).":";
                        $result .= "<span class='greentext'>".Globals::DEFAULT_CURRENCY.$data->{Globals::FLD_NAME_PRICE}."</span>";
                        $result .= "|<a href='#'>".CHtml::encode(Yii::t('poster_createtask', 'lbl_task_read_review'))."</a>";
                        $result .= "|<span class='taskrete'>". $getRatingStar ."</span>"; ;
                        break;
                default :
                        $result .= CHtml::encode(Yii::t('poster_createtask', 'lbl_task_awarded_to')).":";
                        $result .= "<span class='greentext'>".$data->{Globals::FLD_NAME_REF_DONE_BY_NAME}."</span>";
                        $result .= "|".CHtml::encode(Yii::t('poster_createtask', 'lbl_task_work_duration')).":";
                        $result .= "<span class='greentext'>".$data->{Globals::FLD_NAME_INVITED_CNT}."</span>";
                        $result .= "|".CHtml::encode(Yii::t('poster_createtask', 'lbl_task_budget')).":";
                        $result .= "<span class='greentext'>".Globals::DEFAULT_CURRENCY.$data->{Globals::FLD_NAME_PRICE}."</span>";
            }
            return $result;
        }
		
        public function invitedTaskers($task_id)
        {
                $result= '';
                $model=TaskTasker::model()->with('user')->findAll('task_id=?', array($task_id));
                if($model)
                {
                        for($i=0;$i<count($model);$i++)
                        {
                                $user_id = $model[$i]->user->user_id;
                                //print_r($user_id);
                                $returnData = "<ul><li><img src='".CommonUtility::getThumbnailMediaURI($user_id,Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50)."'>".ucwords($model[$i]['user']['firstname'])." ".ucwords($model[$i]['user']['lastname'])."</li></ul>";
                                $result = $result.$returnData;
                        }
                        return $result;
                }

        }
        public function GetAlertType( array $type )
        {
            if(isset($type[Globals::FLD_NAME_TASK_KIND]))
            {
                switch ($type[Globals::FLD_NAME_TASK_KIND]) 
                {
                    case Globals::DEFAULT_VAL_I :
                        return Globals::ALERT_TYPE_INSTANT;
                        break;

                    case Globals::DEFAULT_VAL_P :
                        return Globals::ALERT_TYPE_INPERSON;
                        break;

                    case Globals::DEFAULT_VAL_V :
                        return Globals::ALERT_TYPE_VIRTUAL;
                        break;

                    default:
                            return Globals::ALERT_TYPE_OTHER;
                        break;
                }
            }

        }
        public function GetActivitySubType( array $type )
        {
            if(isset($type[Globals::FLD_NAME_TASK_KIND]))
            {
                switch ($type[Globals::FLD_NAME_TASK_KIND]) 
                {
                    case Globals::DEFAULT_VAL_I :
                        return Globals::TASK_ACTIVITY_SUBTYPE_TASK_INSTANT;
                        break;

                    case Globals::DEFAULT_VAL_P :
                        return Globals::TASK_ACTIVITY_SUBTYPE_TASK_INPERSON;
                        break;

                    case Globals::DEFAULT_VAL_V :
                        return Globals::TASK_ACTIVITY_SUBTYPE_TASK_VIRTUAL;
                        break;

                    default:
                            return Globals::TASK_ACTIVITY_SUBTYPE_OTHER;
                        break;
                }
            }

        }
		
        public function ratingstar($rating)
        {
                $result = '';
                for ($i=0;$i<$rating;$i++)
                {
                        $result .= "<img src='".CommonUtility::getPublicImageUri( "star.png" )."' >";
                }

                return $result;
        }
        public function getUserFullNameWithPopover( $user_id , $placement = 'bottom' , $url = '')
        {      
            $url = empty($url) ? CommonUtility::getTaskerProfileURI( $user_id ) : $url;
            try
            {
                $name = CommonUtility::getUserFullName( $user_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $result = '<a href="'.$url.'" class="popovercontent"  
                data-placement="'.$placement.'" 
                data-poload="'.Yii::app()->createUrl('commonfront/userprofilepopover').'?'.Globals::FLD_NAME_USER_ID.'='.$user_id.'">'.
                    $name.'</a>';
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $result;
        }
        
        public function getUserNameWithPopover( $user_id , $placement = 'bottom' , $url = '')
        {      
            $url = empty($url) ? CommonUtility::getTaskerProfileURI( $user_id ) : $url;
            try
            {
                $name = CommonUtility::getLoginUserName( $user_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $result = '<a href="'.$url.'" class="popovercontent"  
                data-placement="'.$placement.'" 
                data-poload="'.Yii::app()->createUrl('commonfront/userprofilepopover').'?'.Globals::FLD_NAME_USER_ID.'='.$user_id.'">'.
                    $name.'</a>';
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $result;
        }
        
        public function getUserFullNameWithPopoverAsPoster( $user_id , $placement = 'bottom')
        {     
            try
            {
                $name = CommonUtility::getUserFullName( $user_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $result = '<a target="_blank" href="'.CommonUtility::getTaskerProfileURI( $user_id ).'" class="popovercontent"  
                data-placement="'.$placement.'" 
                data-poload="'.Yii::app()->createUrl('commonfront/userprofilepopoverasposter').'?'.Globals::FLD_NAME_USER_ID.'='.$user_id.'">'.
                    $name.'</a>';
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $result;
        }
        public function getConnectMePopover($placement = 'bottom')
        {     
            
            try
            {
                $result = '<a href="#" class="popovercontent"  
                data-placement="'.$placement.'" 
                data-poload="'.Yii::app()->createUrl('commonfront/connectmepopover').'"><img src="'.CommonUtility::getPublicImageUri("connect.png").'" ></a>';
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $result;
        }
        
        public function getUserLocationWithPopover( $user_id , $country_code , $placement = 'bottom' , $class = '' , $mapImg = true )
        {       
            try
            {
                $name = CommonUtility::getUserFullName( $user_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
//                $result = '<span class="'.$class.'"  data-placement="'.$placement.'" title="'.CommonUtility::getUserFullName($user_id).'" 
//                        data-poload="'.Yii::app()->createUrl('commonfront/userlocationpopover').'?'.Globals::FLD_NAME_USER_ID.'='.$user_id.'" >';
                
                $result = '<span class="'.$class.'"   >';
                
                
                
                if( $mapImg == true )
                {
                    $result .= '<i class="icon-map-marker"></i>';
                }
                $result .= $country_code.'</span>';
                return $result;
        }
		
        public function getUserProfileImageWithPopover( $user_id , $placement = 'bottom', $class='')
        {       
				//echo $class;
            try
            {
                $name = CommonUtility::getUserFullName( $user_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $image = CommonUtility::getThumbnailMediaURI($user_id, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $result = '<a href="'.CommonUtility::getTaskerProfileURI( $user_id ).'" class="popovercontent" 
                    data-placement="'.$placement.'" 
                    data-poload="'.Yii::app()->createUrl('commonfront/userprofilepopover').'?'.Globals::FLD_NAME_USER_ID.'='.$user_id.'"><img class="'.$class.'" src="'.$image.'" width="60" height="60"></a>';
						//print_r($result);exit;
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
                return $result;
        }
		
        public function getReviews($task)
        {
			$result = '';
		
			if(!empty($task))
			{	
				if($task->{Globals::FLD_NAME_TASK_STATE} == DEFAULT_VAL_TASK_STATE_FINISHED)
				{
					if($task->{Globals::FLD_NAME_POSTER_REVIEW_COMMENTS}!='')
					{
						$result .= "<div class='taskreview'><h4 style='color:#0088CC;'>";
                                                try
                                                {
                                                    $result .= CommonUtility::getUserFullName($task->{Globals::FLD_NAME_CREATER_USER_ID});
                                                }
                                                catch(Exception $e)
                                                {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg  );
                                                }
						$result .= "</h4><p>";
						$result .= $task->{Globals::FLD_NAME_POSTER_REVIEW_COMMENTS};
						$result .= "</p></div>";
					}
					if($task->{Globals::FLD_NAME_TASKER_REVIEW_COMMENTS}!='')
					{
					
						$result .= "<div class='taskreview'><h4 style='color:#0088CC;'>";
                                                try
                                                {
                                                    $result .= CommonUtility::getUserFullName($task->{Globals::FLD_NAME_TASKER_USER_ID});
                                                }
                                                catch(Exception $e)
                                                {             
                                                    $msg = $e->getMessage();
                                                    CommonUtility::catchErrorMsg( $msg  );
                                                }
						$result .= "</h4><p>";
						$result .= $task->{Globals::FLD_NAME_TASKER_REVIEW_COMMENTS};
						$result .= "</p></div>";
					}
					if($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id)
					{
						if($task->{Globals::FLD_NAME_POSTER_REVIEW_COMMENTS}=='')
						{
							$result .= "<div id='write_review'>";
							$result .= CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_write_review')), 
							Yii::app()->createUrl('poster/reviewbox?id='.$task->{Globals::FLD_NAME_TASK_ID}.'&'.Globals::FLD_NAME_USER_TYPE.'=p'),
								array(
									'complete' => 'function(){                                                   
									$("#write_review").show(),
									$("#write_review").addClass("write_review");}',
									'update'=>'#write_review',
								), 
								array('id' => 'review'));
								$result .= "</div>";
						}
					}
					else if($task->{Globals::FLD_NAME_TASKER_USER_ID} == Yii::app()->user->id)
					{
						if($task->{Globals::FLD_NAME_TASKER_REVIEW_COMMENTS}=='')
						{
							$result .= "<div id='write_review'>";
							$result .= CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_write_review')), 
							Yii::app()->createUrl('poster/reviewbox?id='.$task->{Globals::FLD_NAME_TASK_ID}.'&'.Globals::FLD_NAME_USER_TYPE.'=t'),
								array(
									'complete' => 'function(){                                                   
									$("#write_review").show(),
									$("#write_review").addClass("write_review");}',
									'update'=>'#write_review',
								), 
								array('id' => 'review'));
								$result .= "</div>";
						}
					}
					else
					{
						$result .='';
					}
				}
					//print_r($result);exit;
					return $result;
			}
        }
        
        public function getTaskPreferedLocations($task_id)
        {
            $locationsList = '';
            $locationType = '';
            $data ='';
            //$locations = '';
            $locations = CommonUtility::getSelectedLocationsToView( $task_id ); 
            if( $locations )
            {
                if( $locations[Globals::FLD_NAME_IS_LOCATION_REGION] = Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY )
                {
                    $locationType = CHtml::encode(Yii::t('components_utilityhtml', 'lbl_country'));
                }
                elseif( $locations[Globals::FLD_NAME_IS_LOCATION_REGION] = Globals::DEFAULT_VAL_IS_LOCATION_REGION_REGION )
                {
                    $locationType = CHtml::encode(Yii::t('components_utilityhtml', 'lbl_region'));
                }
                else
                {
                    $locationType = CHtml::encode(Yii::t('components_utilityhtml', 'Other'));
                }
               
                if( $locations["locations"])
                {
                    $data .= '<div class="controls-row">'; 
                    $data .= '<div class="praposal_price">';
                    $data .= "Prefered Location : ";
                    $data .= '<span class="prpl_price">'.$locationType.'</span>';
                    $data .= '</div>'; 
                    $data .= '<ul>'; 
                    foreach( $locations["locations"] as $location )
                    {
                       $data .=  '<li>'.$location.'</li>';
                    }
                    $data .= '</ul>'; 
                    $data .= '</div>'; 
                }
                
            }
            return $data;
        }
        
        public function getPopup($id = 'loadpopupForAllTasks' , $class = 'windowpoposal taskdetailpopup' )
        {
             $data = '  <div id="overlay" onclick="closepopup();" class="overlayPopup " style="display: none" ></div>
                        <div id="'.$id.'" class="'.$class.'" style="display: none" ></div>';
             return $data;
        }  

         public function getPopupNotClose($id = 'loadpopupForProfileAddress' , $class = 'windowpoposal taskdetailpopup1' )
        {
             $data = '  <div id="overlayProfile" class="overlayPopup " style="display: none" ></div>
                        <div id="'.$id.'" class="'.$class.'" style="display: none" ></div>';
             return $data;
        }  
        
        
        
        public function popupforUserReVerification($msg)
        {
            //$result = CommonUtility::checkProfile();
//            $result['to'] = $to;
//            $result['subject'] = $subject;
//            $result['message'] = $message;
//            $result['body'] = $body;
            $result['msg'] = $msg;
//            if($result['success'] == 'false')
//            {
            //print_r($result);exit;
            try
            {
                $data = CommonScript::popupScriptForReRegistration($result);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $data;
//            }
        }
        
        public function popupforUserVerification($msg,$to='',$subject='',$message='',$body='')
        {
            //$result = CommonUtility::checkProfile();
            $result['to'] = $to;
            $result['subject'] = $subject;
            $result['message'] = $message;
            $result['body'] = $body;
            $result['msg'] = $msg;
//            if($result['success'] == 'false')
//            {
            try
            {
                $data = CommonScript::popupScriptForRegistration($result);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
                return $data;
//            }
        }
        
        public function getTaskType( $taskKind = '' )
        {
            switch ( $taskKind ) {
                case Globals::DEFAULT_VAL_I :
                        return ucfirst ( Globals::DEFAULT_VAL_INSTANT);
                        break;

                    case Globals::DEFAULT_VAL_P :
                        return ucfirst ( Globals::DEFAULT_VAL_IN_PERSON);
                        break;

                    case Globals::DEFAULT_VAL_V :
                        return ucfirst ( Globals::DEFAULT_VAL_VIRTUAL);
                        break;

                    default:
                            return ucfirst ( Globals::DEFAULT_VAL_OTHER);
                        break;
            }
        }
        public function getCategoryName( $category_id )
        {
            $categoryName = '';
            try
            {
                $category =  Category::getCategoryListByID( $category_id );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if( $category )
            {
                $categoryName = $category[0]->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME};
            }
            return $categoryName;
        }
        public function getSelectedLocationsInComma($task_id)
        {
            try
            {
                $taskLocations = CommonUtility::getTaskPreferredLocations($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            $locations = CHtml::encode(Yii::t('components_utilityhtml', 'Anywhere'));
            if( isset($taskLocations[Globals::FLD_NAME_IS_LOCATION_REGION]) && isset($taskLocations[Globals::FLD_NAME_LOCATIONS]) && $taskLocations[Globals::FLD_NAME_LOCATIONS] != '' )
            {
               $locationsArr = $taskLocations[Globals::FLD_NAME_LOCATIONS];
               
               switch($taskLocations[Globals::FLD_NAME_IS_LOCATION_REGION]){
                  case Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY: 
                    $locations = implode(", ", $locationsArr );
                 
                    foreach ($locationsArr as $key => $location) 
                    {
                        try
                        {
                            $country = CountryLocale::getCountryByID( $location );
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg  );
                        }
                        if($country)
                        {
                            $locationRegionArr[] = $country[0]->{Globals::FLD_NAME_COUNTRY_NAME};
                            $locations = implode(", ", $locationRegionArr );
                        }
                    }
                  break;    
                  case Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY: 
                  
                    foreach ($locationsArr as $key => $location) 
                    {
                        try
                        {
                            $region = RegionLocale::getRegionByID( $location );
                        }
                        catch(Exception $e)
                        {             
                            $msg = $e->getMessage();
                            CommonUtility::catchErrorMsg( $msg  );
                        }
                        $locationRegionArr[] = $region[0]->{Globals::FLD_NAME_REGION_NAME};
                    }
                    
                    $locations = implode(", ", $locationRegionArr );
                  break;
                  default:
                     $locations = implode(", ", $locationsArr );
               }
            }
           /* if(isset($taskLocations[Globals::FLD_NAME_IS_LOCATION_REGION])){
               if( $taskLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY )
               {
                   if( isset($taskLocations[Globals::FLD_NAME_LOCATIONS]) && $taskLocations[Globals::FLD_NAME_LOCATIONS] != '' )
                   {
                       $locationsArr = $taskLocations[Globals::FLD_NAME_LOCATIONS];
                       $locations = implode(", ", $locationsArr );
                   }
               }
               elseif( $taskLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_IS_LOCATION_REGION_REGION )
               {
                   if( isset($taskLocations[Globals::FLD_NAME_LOCATIONS]) && $taskLocations[Globals::FLD_NAME_LOCATIONS] != '' )
                   {
                       $locationsArr = $taskLocations[Globals::FLD_NAME_LOCATIONS];
                       foreach ($locationsArr as $key => $location) 
                       {
                           $region = RegionLocale::getRegionByID( $location );
                           $locationRegionArr[] = $region[0]->{Globals::FLD_NAME_REGION_NAME};
                       }
                       
                       $locations = implode(", ", $locationRegionArr );
                   }
               }
            }*/
            return $locations;
        }
        
        public function getControllerandAction()
        {
            $return = '';
            $controller_id = Yii::app()->controller->id;
            $action_id = Yii::app()->controller->action->id;
            $return = $controller_id."_".$action_id;
            return $return;
        }
        public function getSortingDropDownProposalList( $name = 'sort' , array $options = array() )
        {
            $options = array_merge(array('class' => 'span2', 'id' => $name), $options );
            return CHtml::dropDownList( $name , '' , Globals::getProposalSearchSortingAttributes(),$options );
        }
        public function getSortingDropDownNotificationList( $name = 'sort' , array $options = array(),$sort='' )
        {
            $options = array_merge(array('class' => 'span2', 'id' => $name), $options );
            return CHtml::dropDownList( $name , $sort , Globals::getNotificationSearchSortingAttributes(),$options );
        }
        public function getSortingDropDownTaskSearch( $name = 'sort' , array $options = array() ,$value = "" )
        {
            $options = array_merge(array('class' => 'span2', 'id' => $name), $options );
            return CHtml::dropDownList( $name , $value , Globals::getTaskSearchSortingAttributes(),$options );
        }
        public function getSortingDropDownTaskSearchForDoer( $name = 'sort' , array $options = array() ,$value = "" )
        {
            $options = array_merge(array('class' => 'span2', 'id' => $name), $options );
            return CHtml::dropDownList( $name , $value , Globals::getTaskSearchSortingForDoerAttributes(),$options );
        }
        public function getSortingDropDownDoerSearch( $name = 'sort' , array $options = array() ,$value='')
        {
            $options = array_merge(array('class' => 'span2', 'id' => $name), $options );
            return CHtml::dropDownList( $name , $value , Globals::getDoerSearchSortingAttributes(),$options );
        }
        public function getSearchFilterList( $type )
        {
            $filterlist = '<a id="loadfilters"  href="#" class="filter_btn alwaysAjax popovercontent " onclick="return false"  
                        data-placement="bottom" 
                        data-poload="'.Yii::app()->createUrl('tasker/loadfilterstask').'?'.Globals::FLD_NAME_ATTRIB_TYPE.'='.$type.'">'.Yii::t('components_utilityhtml', 'lbl_load_filter').'</a>';
        
            return $filterlist;
        }
        public function isTaskerInvitedForTask( $task_id , $user_id )
        {
            $isInvited = '';
            try
            {   
                $invited = TaskTasker::isTaskerInvitedForTask($task_id, $user_id);
                if($invited)
                    $isInvited .= '<a href="#" title="'.Yii::t('tasklist', 'you invited').'" ><img src="'.CommonUtility::getPublicImageUri( "bell.png" ).'"></a>';
                else
                    $isInvited .= '<a href="#" title="'.Yii::t('tasklist', 'you not invited').'" ><img src="'.CommonUtility::getPublicImageUri( "bell-gray.png" ).'"></a>';
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $isInvited;
            //<div class="total_task4"><span class="countbox"><img src="../images/bell-gray.png"></span></div>
        }
        public function displayPrice( $price )
        {
            //$priceVal = Yii::t('components_utilityhtml', 'not available');
            $priceVal = 0;
            $price = intval($price);
//            if($price > 0)
//            {
                $priceVal = Globals::DEFAULT_CURRENCY.$price;
//            }
            return $priceVal;
        }
        public function displayBonus( $bonus )
        {
            //$priceVal = Yii::t('components_utilityhtml', 'not available');
            $bonusVal = 0;
            $bonus = intval($bonus);
//            if($price > 0)
//            {
                $bonusVal = Globals::DEFAULT_CURRENCY.$bonus;
//            }
            return $bonusVal;
        }
        public function getTaskTypeDropDown( $name , $selected = '' , array $options = array()   )
        {
            $options = array_merge(array('options' => array( $selected   =>array('selected'=>true)), 'id' => $name, 'class'=>'form-control mrg5'), $options );
            
                echo CHtml::dropDownList($name, '',  Globals::gettaskTypeAttributes(), $options);
        }
        public function getPayWithDropDown( $name , $selected = '' , array $options = array()   )
        {
            $options = array_merge(array('options' => array( $selected   =>array('selected'=>true)), 'id' => $name, 'class'=>'col-md-4 pdn-top-bot3'), $options );
            
                echo CHtml::dropDownList($name, '',  Globals::getPayWithAttributes(), $options);
        }
        public function getSearchByRating( $name , $value = '' , $filterType = '' )
        {
            $this->widget('CStarRating',array('name'=>$name,
            'starCount'=> Globals::DEFAULT_VAL_STAR_RATING_TYPE,
            'maxRating'=> Globals::DEFAULT_VAL_STAR_RATING_TYPE,
            'value' => $value,
       
            //'allowEmpty' =>true,
                'callback'=>'function(){ 
                try
                {
                $(\'#rating\').val($(this).val());
                }
                catch(err)
                {
                    $(\'#rating\').val("");
                }
                var data = $("#rating").serialize();    
                SearchFunc(data);
                loadfilters("'.$filterType.'");
                }',
        
            ));
            echo CHtml::hiddenField('rating', '', array('id' => 'rating'));
        }
        public function getDisplayRating( $value = "" )
        {
            $ratingPercentage = round(($value/Globals::DEFAULT_VAL_STAR_RATING_TYPE)*100);
            $rating = "<div class='rating_bar' style='margin:0 auto;'><div  class='rating' style='width:".$ratingPercentage."%;'></div></div>";
            return $rating;
        }
        public function getInstantNavigationLinks( $type )
        {
            $menusLinks = array();
            if($type == Globals::DEFAULT_VAL_USER_ROLE_POSTER)
            {
                $menusLinks = array( 'New task' => Yii::app()->createUrl('poster/createtask'),
                                    'Open tasks' => Yii::app()->createUrl('poster/mytasks').'?Task[state]=o',
                                    'Current tasks' => Yii::app()->createUrl('poster/mytasks').'?Task[state]=a',
                                    'Completed tasks' => Yii::app()->createUrl('poster/mytasks').'?Task[state]=f',
                                    'All tasks' => Yii::app()->createUrl('poster/mytasks'),
                                    'Favorite Taskers' => Yii::app()->createUrl('poster/findtasker'),
                    );
            }
            elseif($type == Globals::DEFAULT_VAL_USER_ROLE_TASKER)
            {
                $menusLinks = array(    'New task' => Yii::app()->createUrl('poster/createtask'),
                                        'Open tasks' => Yii::app()->createUrl('tasker/mytasks').'?Task[state]=o',
                                        'Current tasks' => Yii::app()->createUrl('tasker/mytasks').'?Task[state]=a',
                                        'Completed tasks' => Yii::app()->createUrl('tasker/mytasks').'?Task[state]=f',
                                        'All tasks' => Yii::app()->createUrl('tasker/mytasks'),
                                        'Favorite Posters' => '#',
                    );
            }
            return  $menusLinks;
        }
        public function getInstantNavigationLinksNotifications( $type )
        {
            $menusLinks = array();
            if($type == Globals::DEFAULT_VAL_USER_ROLE_POSTER)
            {
                $menusLinks = array( 'Search Members' => Yii::app()->createUrl('#'),
                                    'Currently Hiring' => Yii::app()->createUrl('#'),
                                    'Active Projects' => Yii::app()->createUrl('#'),
                                    'Completed Projects' => Yii::app()->createUrl('#'),
                                    'All Projects' => Yii::app()->createUrl('#'),
                    );
            }
            return  $menusLinks;
        }
        
        public function getInstantNavigationLinksProposals( $type )
        {
            $menusLinks = array();
            if($type == Globals::DEFAULT_VAL_USER_NOTIFICATION)
            {
                $menusLinks = array( 'All Notifications' => Yii::app()->createUrl('#'),
                                    'Doer' => Yii::app()->createUrl('#'),
                                    'Poster' => Yii::app()->createUrl('#'),
                                    'System' => Yii::app()->createUrl('#'),
                                    'Other' => Yii::app()->createUrl('#'),
                    );
            }
            return  $menusLinks;
        }
        
         public function getTaskStateArray()
         {
              return array(''=>ucfirst('all'),'o'=>ucfirst('open for bid'),'c'=>ucfirst('cancelled'),'a'=>ucfirst('assigned to tasker'),'f'=>ucfirst('finished'),'d'=>ucfirst('under dispute'),'s'=>ucfirst('suspended'));
         }
//        public function getTaskDoneCount( $value )
//        {
//            $taskCompleted =  $priceVal = Yii::t('components_utilityhtml', 'not available');
//            
//        }

         public function getProposalFilters()
         {
             $filters = array();
             
             $filters = array('Previously hired' => '#',
                                'Premium task' => '#',
                                'Highly rated' => '#',
                                'Potential' => '#',
                                'Most valued' => '#',
                                'Invited' => '#',
            );
             return $filters;
         }
         
         public function getTaskUpdateUrl($id)
         {
             $result = '';
             $url = Yii::app()->createUrl('poster/createtask').'/task_id/'.$id;
             $result .= '<a href="'.$url.'" class="btn-u btn-u-lg rounded btn-u-red display-b">Edit</a>';
             return $result;
         }
         
        public function posterReviewRating( $name , array $options = array())
        {
            $options['id'] = empty($options['id']) ? $name : $options['id'];
            $options['task_id'] = empty($options['task_id']) ? '' : $options['task_id'];
            $options['poster_id'] = empty($options['poster_id']) ? '' : $options['poster_id'];
            $options['rating_id'] = empty($options['rating_id']) ? '' : $options['rating_id'];
            $options['value'] = empty($options['value']) ? '' : $options['value'];
            $options['callback'] = empty($options['callback']) ? '' : $options['callback'];
            $options['allowEmpty'] = empty($options['allowEmpty']) ? '' : $options['allowEmpty'];
            $overallRt = '0';
            $this->widget('CStarRating',array(
            'id' => $options['id'],
            'name'=>$name,
            'starCount'=> Globals::DEFAULT_VAL_STAR_RATING_TYPE,
            'maxRating'=> Globals::DEFAULT_VAL_STAR_RATING_TYPE,
            'value' => $options['value'],
            'allowEmpty' =>$options['allowEmpty'],
            'callback'=>'js:function(){ 
                
                   
                try
                {
                    $(\'#rating'.$options['id'].'\').val($(this).val());
                        var ratingId = $(this).parent().attr(\'id\');
                   
                        $("#"+ratingId+" .rating-cancel").on(\'click\',function(){
                                $(\'#rating'.$options['id'].'\').val("");
                               calculateAverageRating();
                               //var reset'.$options['id'].' = 0;
                        });
                        calculateAverageRating();
                        
                }
                catch(err)
                {
                    $(\'#rating'.$options['id'].'\').val("");
                }
            }',
        
            ));
            echo CHtml::hiddenField('rating['.$options['id'].']', 0, array('id' => 'rating'.$options['id'],'class' => 'posterreviewratingfield'));
        }
        public function getFileTypeImage($fileType)
        {
            $return = '';
             switch ($fileType)
            {
                case Globals::DEFAULT_VAL_IMAGE_TYPE: 

                                
                                $return .= '<img style="height: 40px; width: 32px;" src="'.Globals::ATTACHMENT_TYPE_IMAGE.'" >';
                        break;

                case Globals::DEFAULT_VAL_VIDEO_TYPE: 
                    //echo $fileUrl;
                                $return .=   '<img style="height: 40px; width: 32px;" src="'.Globals::ATTACHMENT_TYPE_VIDEO_IMAGE.'" >';

                        break;
                case Globals::DEFAULT_VAL_DOC_TYPE : 
                                $return .=   '<img style="height: 40px; width: 32px;" src="'.Globals::ATTACHMENT_TYPE_DOC_IMAGE.'" >';
                                break;

                case Globals::DEFAULT_VAL_EXCEL_TYPE : 
                                $return .=   '<img style="height: 40px; width: 32px;" src="'.Globals::ATTACHMENT_TYPE_EXCEL_IMAGE.'" >';
                                break;


                case Globals::DEFAULT_VAL_PDF_TYPE : 
                                $return .=   '<img style="height: 40px; width: 32px;" src="'.Globals::ATTACHMENT_TYPE_PDF_IMAGE.'" >';
                                break;   

                case Globals::DEFAULT_VAL_ZIP_TYPE : 
                                $return .=   '<img style="height: 40px; width: 32px;" src="'.Globals::ATTACHMENT_TYPE_ZIP_IMAGE.'" >';
                                break; 
                case Globals::DEFAULT_VAL_PPT_TYPE : 
                                $return .=   '<img style="height: 40px; width: 32px;" src="'.Globals::ATTACHMENT_TYPE_PPT_IMAGE.'" >';
                                break;

                default: 
                            $return .=   '<img style="height: 40px; width: 32px;" src="'.Globals::IMAGE_DOWNLOAD.'" >';
                    break;
            }///
            return $return;
        }
//        public function getActionsTaskDetailFile( $uploadedBy )
//        {
//            <a href="#"><img src="../images/del-ic.png"></a> <a href="#"><img src="../images/attach-download.png"></a>
//        }
        public function getActionsTaskDetailFile($fileId ,$taskId , $taskerId , $isPoster , $taskTaskerId, $file, $uploadedBy , $grid )
	{
		$url='commonfront/filedownload';
               
                $imageDownload = CHtml::image(CommonUtility::getPublicImageUri('attach-download.png'), CHtml::encode(Yii::t('components_utilityhtml', 'Click here to download')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'Click here to download'))));
                $fileWithoutFolder = explode('/', $file);
                $fileFullUrl = CommonUtility::getProposalAttachmentURI($taskTaskerId,$fileWithoutFolder[1]);
                echo '<a target="_blank" title ="'.CHtml::encode(Yii::t('components_utilityhtml', 'Click here to download')).'" href="'.Yii::app()->createUrl( $url."?filename=".$file).'"><i class="fa fa-download"></i></a>&nbsp;&nbsp;';
                
                if($uploadedBy == Yii::app()->user->id && $isPoster == Globals::DEFAULT_VAL_IS_POSTER_INACTIVE )
                {
                    //$image=CHtml::image(CommonUtility::getPublicImageUri('del-ic.png'), CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_delete')), array('title'=>CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_delete'))));

//                    echo CHtml::ajaxLink($image, 'js:$(this).attr("href")',
//                                array( 'type' => 'POST', 'success' => "function(data){ $('#".$grid."').yiiGridView.update('".$grid."'); }",
//                                'cache'=>false,
//                            ),
//                            array( //htmlOptions
//                            'href' => Yii::app()->createUrl( $url.'?file='.$file."&task_id=".$taskId."&tasker_id=".$taskerId),
//                                'confirm'=> CHtml::encode(Yii::t('components_utilityhtml', 'txt_are_you_sure_to_delete_this_task')),
//                                'id'=>'deletefile'.uniqid().$fileId,
//                            )
//                    );
                    
                     echo '<a  title ="'.CHtml::encode(Yii::t('components_utilityhtml', 'txt_click_here_to_delete')).'"  onclick="return deleteFileProjectLive(\''.$file.'\' , \''.$taskId.'\' , \''.$taskerId.'\' );" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a>';
                }

               
                
                               
	}
        public function getFileNameInGrid($taskerId , $isPoster ,$uploadedBy, $file )
	{
                $file = CommonUtility::getImageDisplayName($file);
		if($uploadedBy == Yii::app()->user->id && $isPoster == Globals::DEFAULT_VAL_IS_POSTER_INACTIVE )
                {
                    echo '<span class="color-blue">'.$file.'</span>';
                    
                }
                else
                {
                      echo '<span class="">'.$file.'</span>';
                }
                               
	}
        public function getNotificationTypeClass($type = '')
        {
            $class = 'warning2';
            switch ($type)
            {
                case 'proposal_show_interest':
                    $class = "warning2";
                    break;
                case 'proposal_rejected':
                    $class = "warning2";
                    break;
                case 'proposal_rejected_by_tasker':
                    $class = "success";
                    break;
                case 'task_canceled':
                    $class = "warning2";
                    break;
                case 'proposal_accepted':
                    $class = "warning2";
                    break;
                case 'proposal_created':
                    $class = "success";
                    break;
                case 'task_edited':
                    $class = "warning2";
                    break;
                case 'tasker_invited':
                    $class = "warning2";
                    break;
            }
            return $class;
        }
        public function taskSharePopover($task_id , $text = 'share' , $class = '' , $id = 'sharePopover')
        {
              echo '<a id="'.$id."_".$task_id.'" href="#" class"'.$class.' " data-placement="bottom" data-poload="'.Yii::app()->createUrl('commonfront/tasksharepopover') . "?" . Globals::FLD_NAME_TASK_ID . "=" .$task_id.'">'.$text.'</a>';

        }
        
}