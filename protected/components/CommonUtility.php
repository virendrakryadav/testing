<?php
/**c
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CommonUtility extends CComponent
{	 
	//Reset master priorities
	public function resetMasterPriorities($className,$currentPriority=Globals::DEFAULT_VAL_PRIORITY,$currentRecordId,$priorityField,$primaryField,$languageCode=NULL,$task=Globals::DEFAULT_VAL_ADD)
	{

		$model=new $className;
		if($task==Globals::DEFAULT_VAL_EDIT)
		{
			$criteria=new CDbCriteria;
			$criteria->select=$priorityField;  // only select the priority column
			$criteria->condition= $primaryField.'=:currentRecordId';
                        if($languageCode !=NULL)
                        {
                            $criteria->addCondition('language_code = "'.$languageCode.'"');
                        }
			$criteria->params=array(':currentRecordId'=>$currentRecordId);
			$dataRow=$model::model()->findAll($criteria); // $params is not needed
			$oldpriority=$dataRow[0]->$priorityField;
			if($oldpriority==$currentPriority)
			{
				return 0;
			}
		}
		
		$criteria=new CDbCriteria;
		//$criteria->select=$priorityField;  // only select the priority column
		$criteria->condition= $priorityField.'>=:currentPriority and '.$primaryField.'<>:currentRecordId';
		if($languageCode !=NULL)
                {
                    $criteria->addCondition('language_code = "'.$languageCode.'"');
                }

                //$criteria->condition= $primaryField.'<>:currentRecordId';
		$criteria->params=array(':currentPriority'=>$currentPriority,':currentRecordId'=>$currentRecordId);
		$criteria->order= $priorityField.' asc';
		$dataRows=$model::model()->findAll($criteria); // $params is not needed
		$editPriority=$currentPriority;

		for($i=0;$i<count($dataRows);$i++)
		{
			$editId=$dataRows[$i]->$primaryField;			
                        if($languageCode !=NULL)
                        {
                            $model = $model::model()->findByAttributes(array($primaryField=>$editId,Globals::FLD_NAME_LANGUAGE_CODE=>$languageCode));
                        }
                        else
                        {
                            $model=$this->loadModel($editId);                         
                        }

			if($i==0)
			{
				$editPriority=$dataRows[$i]->$priorityField;
			}		

			if($editPriority==Globals::DEFAULT_VAL_NULL)
			{
				$editPriority=$currentPriority;
			}
			++$editPriority;
			$model->saveAttributes(array($priorityField=>$editPriority));			
		}			
	}	
         public function setErrorLog($errors,$modelName)
        {             
             $controllerAndAction = $this->getUniqueId().'.'.$this->action->id;
             $str = '';
             foreach($errors as $key => $error)
                 {
                    $total_error = count($errors[$key]);
                    for($i=0;$i<$total_error;$i++)
                    {
                        $str.= "[".$errors[$key][$i]."]";
                        if($key != Globals::FLD_NAME_PASSWORD && $key != Globals::FLD_NAME_REPEAT_PASSWORD)
                        {
                            $str.= "[".$_POST[$modelName][$key]."],";
                        }
                        else
                        {
                            $str.= "[],";
                        }
                    }
     
                 }
             if (CommonUtility::IsDebugEnabled())
                {
                    Yii::log($str,CLogger::LEVEL_ERROR ,$controllerAndAction);
                }
        }
        
        
        public function getFormPublic($data)
        {
            if ($data != Globals::DEFAULT_VAL_VALID_FROM_DT ) 
            {
                $is_public = true;
            }
            else
            {
                $is_public = false;
            }
            return $is_public;
        }
        
        public function updateTaskAverageExperience($taskid = '')
        {            
            $task = Task::model()->findbyPk($taskid);
            $taskers = TaskTasker::getAllProposalsOfTask($taskid);
            $totletasker = count($taskers);
            $totletask = 0;
            foreach($taskers as $tasker)
            {
                $totletask = $totletask+$tasker->user->task_done_cnt;
            }           
            $averageExp = $totletask/$totletasker;            
            $task->proposals_avg_experience = $averageExp;                        
            try
            {
                $task->Update();
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsggetCategoryName( $msg  );
            }            
           return true;
        }
        
        public function forDeleteRows($data)
        {
            if(!empty($data))
            {
                $totletable = count($data)-1;
                for($i=$totletable;$i>=0;$i--)
                {
//                      echo $data[$i][Globals::FLD_NAME_TABLE_NAME];
//                    $modelname = $data[$i][Globals::FLD_NAME_TABLE_NAME];
//                    echo"<br>";
//                    $modelname::model()->deleteAll($data[$i][Globals::FLD_NAME_PRIMARY_KEY].' = '.$data[$i][Globals::FLD_NAME_PRIMARY_KEY_VALUE]);
                }
            }
        }



       public function calDistance($longitude2,$latitude2,$longitude1,$latitude1)
	{
			$radius      = Globals::DEFAULT_VAL_RADIUS;      // Earth's radius (miles)
			$pi          = Globals::DEFAULT_VAL_PI;
			$deg_per_rad = Globals::DEFAULT_VAL_DEG_PER_RAD;  // Number of degrees/radian (for conversion)
                        $earth_radius = Globals::DEFAULT_VAL_EARTH_RADIUS;

			$dLat = deg2rad(( (double) $latitude2) - ( (double) $latitude1));
			$dLon = deg2rad(( (double) $longitude2) - ( (double) $longitude1));

			$att = sin($dLat/2) * sin($dLat/2) + cos(deg2rad((double)$latitude1)) * cos(deg2rad( (double)$latitude2)) * sin($dLon/2) * sin($dLon/2);
			$ctt = 2 * asin(sqrt($att));
			$dtt = $earth_radius * $ctt;

//			return $dtt*1.6; // for km
                        return round($dtt, 2) ;
			

	}






    public function selectNextPriority($className,$matchField)
	{
            $model = new $className;
            $criteria=new CDbCriteria;
            $criteria->select=$matchField;
            $criteria->order = $matchField.' DESC';
            if($className !=Globals::FLD_NAME_LANGUAGE_CAP)
            {
                $criteria->addCondition('language_code = "'.Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE).'"');
            }
            $dataRow=$model::model()->findAll($criteria);
            if($dataRow)
            {
                    $nextPriority=$dataRow[0]->$matchField+1;
                    return $nextPriority;
            }
            return false;
	}
	
	//// Mukul's ////
        public function filterUrl($urlString)
	{
            $routeURL = Globals::BASH_URL.Globals::ADMIN_URL.Yii::app()->controller->id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].Yii::app()->controller->action->id;
            
            $urlString = str_replace($routeURL.'?', Globals::DEFAULT_VAL_NULL, $urlString);
            $urlString = str_replace('&ajax=state-grid', Globals::DEFAULT_VAL_NULL, $urlString);
            $urlString = trim($urlString);
            Yii::app()->user->setState(Globals::FLD_NAME_PAGE_URL, $urlString);
            return $urlString;
	}
	public function chackRelationForDeleteAction($relationTable,$forginkey,$forginkeyVal)
        {
            if(is_array($relationTable))
            {
                $totleRelation =  count($relationTable);
                $relationTablename = '';
                $result = '';
                for($i=0;$i<$totleRelation;$i++)
                {
                    $hasforeign = $relationTable[$i]::model()->findByAttributes(array($forginkey=>$forginkeyVal));
                    if(!empty($hasforeign))
                        {
                            $relationTablename = $relationTable[$i];
                            break;
                        }
                }
            }
            else
            {
                $hasforeign = $relationTable::model()->findByAttributes(array($forginkey=>$forginkeyVal));
                $relationTablename = $relationTable;
            }
            $result[Globals::FLD_NAME_RELATION_NAME_SML_N] = $relationTablename;
            $result[Globals::FLD_NAME_HAS_FOREIGN] = $hasforeign;
            return $result;
        }
        public function createArray($urlString)
	{
            
                $urlString = preg_split("/[&=]/", $urlString);
                // print_r($urlString);
                $previousUrl = Yii::app()->request->urlReferrer;
                $host = $_SERVER[Globals::HTTP_HOST];
                $previousUrl = str_replace($host, Globals::DEFAULT_VAL_NULL, $previousUrl);
                $previousUrl = str_replace(Globals::HTTP_THREE_SLASH, Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR], $previousUrl);
                $routeURL = Yii::app()->request->requestUri;
                $baseUrl = Yii::app()->createUrl(Yii::app()->urlManager->parseUrl(Yii::app()->request));
                $urlString = str_replace($previousUrl.Globals::QUESTION_MARK_FOR_URL, Globals::DEFAULT_VAL_NULL, $urlString);
                $urlString = str_replace($routeURL.Globals::QUESTION_MARK_FOR_URL, Globals::DEFAULT_VAL_NULL, $urlString);
                $urlString = str_replace($routeURL, Globals::DEFAULT_VAL_NULL, $urlString);
                $urlString = str_replace($baseUrl.Globals::QUESTION_MARK_FOR_URL, Globals::DEFAULT_VAL_NULL,$urlString );
                $urlString = str_replace($baseUrl, Globals::DEFAULT_VAL_NULL,$urlString );
           
                $return = array(); 
		foreach($urlString as $index => $request)
		{
                    if($index%2 == 0)
                    {
                            $return[$request]=Globals::DEFAULT_VAL_NULL;
                    }
                    else 
                    {
                            $return[$urlString[$index - 1]]=$request;
                    }

		}
		return $return;
	}
        public  function createValue($className,$value , $class = '' )
	{
           if(empty($class)) $class =  ucfirst($this->id);
            if( $class == 'Admin')
            {
                    $class = 'User';
                   
            } 
		 $value = $class.'['.$value.']';
               
		if($className != Globals::DEFAULT_VAL_NULL)
		{
			if(isset($className[$value]))
			{
				return $className[$value];
			}
			else 
			{
				return Globals::DEFAULT_VAL_NULL;
			}
		}
		else 
		{
			return Globals::DEFAULT_VAL_NULL;
		}
	}
	
	public function mainScripts()
	{
            $script =   " 
                <script>
                    function afterdelete(data)
                    {
                            $(\"#flash_messages\").html(\"\");
                            $(\"#flash_messages\").append(data);
                    }
                    function reloadGrid(data)
                    {
                            $.fn.yiiGridView.update('data-grid');
                            $(\"#flash_messages\").html(\"\");
                            $(\"#flash_messages\").append(data);
                            return false;
                    }
                    function ischecked()
                    {
                             var atLeastOneIsChecked = $('input[name=\"autoId[]\"]:checked').length > 0;

                            if (!atLeastOneIsChecked)
                            {
                                    alert('".Yii::t('commonutlity','select_atleast_one_rec_msg_text')."');
                                    return false;
                            }
                            else
                            {
                                    return true;
                            }
                    }
                    function checkForDeletion()
                    {
                            if(ischecked())
                            {
                                    return window.confirm('".Yii::t('commonutlity','sure_you_delete_the_rec_msg_text')."');
                            }
                            
                    }
//                    function checkForDeletion()
//                    {
//                            if(!ischecked())
//                            {
//                                    return false;	
//                            }
//                            else if (window.confirm('".Yii::t('commonutlity','sure_you_delete_the_rec_msg_text')."'))
//                            {
//                                    return true;
//                            }
//                    }

                </script>
            ";
            echo $script;
        }
    
	public function searchSessionScript($grid)
	{
            $currentRequest =  Yii::app()->user->getState(Globals::FLD_NAME_PAGE_URL);
            //$currentRequest =$_SESSION['11fa452d417770b5cc0ef107ad8e391dpageUrl']; 
            if(isset($currentRequest))
            {   
                try
                {
                    $currentRequest = CommonUtility::filterUrl($currentRequest);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsggetCategoryName( $msg  );
                }

            }
            //$class =  ucfirst($this->id);
            Yii::app()->clientScript->registerScript('search', "
                   
                    $('.search-button').click(function(){
                       
                        $('.search-form').toggle();
                            return false;
                        });
                        $('.search-form form').submit(function(){
                            $('#$grid').yiiGridView('update', {
                                    data: $(this).serialize()
                        });
                        return false;
                    });

                    $('#form-reset-button').click(function()
                    {
                            var form = $(this).closest('form').attr('id');
                            $('#'+form+' input, #'+form+' select').each(function(i, o)
                            {
                                     if (($(o).attr('type') != 'submit') && ($(o).attr('type') != 'reset')) $(o).val('');
                            });
                       $(\".keys\").attr('title', '');
                            $.fn.yiiGridView.update('$grid', {data: $('#'+form).serialize()});
                    
                            return false;
                    
                    });
                   
                    $( document ).ready(function() {
                                    $.fn.yiiGridView.update('$grid', {data:'$currentRequest'});
                    });
                
                    ");
            $script =   "   
                            <script>
                                $( document ).ajaxSuccess(function() {
           
                                    $( '.summary' ).prepend( '<div class=\"setPagerDrop\"></div>');

                                    $( '#$grid' ).append( '<div class=\"formactions\"></div>');
            
            
                                    var urlValue = $('.keys').attr('title');
                                    urlValue = urlValue.replace(/&/gi,\"urlBreak\"); 
                                    var xhr =  $.ajax({
                                                        type: \"GET\",
                                                        url: '".Yii::app()->createUrl('/common/ajaxseturlsession')."',
                                                        data: 	\"url=\" + urlValue + \"&is_ajax=\" + 1,
                                                        global: false,
                                                        success: function(html)
                                                        {
                                                         //alert(html);
                                                            $(\".setPagerDrop\").html(html);
                                                            
                                                            $('input[type=checkbox]').uniform();
                                                            
                                                            var percentageToScroll = 100;
                                                            var percentage = percentageToScroll/100;
                                                            var height = $(document).scrollTop();
                                                            var scrollAmount = height * (1 - percentage);
                                                            if ($('#flash_messages div').hasClass('flash-success') || 
                                                                $('#flash_messages div').hasClass('flash-error') || 
                                                                $('#flash_messages div').hasClass('flash-notice'))
                                                            {
                                                           
                                                                $('html,body').animate({ scrollTop: scrollAmount }, 'slow', function () {});
                                                              
                                                            }
                                                        }

                                                    });
                                 
                                });
                                
                            </script>
                        ";
                try
                {
                    CommonUtility::mainScripts();
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                
                
            echo $script;
            
	}
//        public function activeMenu()
//	{
//            $result = '<script> 
//                        $(document).ready(function(){ ';
//                            $requestURI =  Yii::app()->urlManager->parseUrl(Yii::app()->request);
//                            if($requestURI == Globals::INDEXiNDEX)
//                            {
//                                   $result .= '$(".index ").addClass("active");';
//                            }
//                            $activeClasses = explode(Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR], $requestURI);
//                            if($activeClasses[0]== Globals::FLD_NAME_ADMIN_SML)
//                            {
//                                $activeClasses[0] = Globals::FLD_NAME_ADMINUSER_SML;
//                            }
//                                
//                            $result .= '
//                                        $(".page-sidebar ul li.'.$activeClasses[0].' ").closest("li.parent").addClass(\'active\');
//                                        $(".page-sidebar ul li.'.$activeClasses[0].' ").closest(\'li.parent\').addClass(\'current\');
//                                        $(".current a span.mastersarrow").addClass("open");
//                                      
//                                        $(".page-sidebar ul li.'.$activeClasses[0].'").addClass("active");
//                                        $(".page-sidebar ul li.'.$activeClasses[0].'").addClass("open");
//                                          $(".page-sidebar ul li.'.$activeClasses[0].' .arrow ").addClass("open");  
//
//                                        $(".page-sidebar ul li.'.$activeClasses[0].' .'.$activeClasses[1].'").addClass("active");
//                        }); 
//                        function backUrl()
//                        {
//                                window.location.href="admin";
//                        }
//                        function backUrlReferer()
//                        {
//                                window.location.href="'.@$_SERVER[Globals::HTTP_REFERER].'";
//                        }
//                        jQuery(document).ready(function() {       
//			   App.init();
//		});
//                 $(document).on(\'click\', \'#flash_messages\', function () { 
//         $("#flash_messages div").remove();
//         // As I see the input is direct child of the div
//    });
//                        	
//                    </script>';
//           echo $result ;
//                            
//        }
        
       
//        public function loadCssFiles()
//	{
//            $baseUrl = Globals::BASH_URL;
//            $css =  '
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/screen.css" media="screen, projection" />
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/print.css" media="print" />
//                        <!--[if lt IE 8]>
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/ie.css" media="screen, projection" />
//                        <![endif]-->
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/main.css" />
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/form.css" />
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/font-awesome/css/font-awesome.min.css" />
//
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/style.css" /> 
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/style-responsive.css" />
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/default.css" />
//
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/bootstrap.min.css" /> 
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/bootstrap-responsive.min.css" />
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/uniform.default.css" />   
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/login.css" />
//                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/style-metro.css" />
//                    ';
//            echo $css;
//        }
//        public function loadScriptFiles()
//	{
//            $baseUrl = Globals::BASH_URL;
//            $css =  '   <script type="text/javascript" src="'.$baseUrl.'/js/jquery-1.10.1.min.js"></script>
//                        <script type="text/javascript" src="'.$baseUrl.'/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
//                        <script type="text/javascript" src="'.$baseUrl.'/js/bootstrap.min.js"></script>
//                        <script type="text/javascript" src="'.$baseUrl.'/js/twitter-bootstrap-hover-dropdown.min.js"></script>
//                        <script  type="text/javascript" src="'.$baseUrl.'/js/jquery-slimscroll/jquery.slimscroll.min.js"></script>
//                        <script type="text/javascript" src="'.$baseUrl.'/js/login.js"></script>
//                        <script type="text/javascript" src="'.$baseUrl.'/js/app.js"></script>';
//            echo $css;
//        }
        
        
        public  function autocomplete($name,$url,$limit,$value,$class,$size=Globals::AUTO_COMPLETE_SIZE,$maxLength=Globals::AUTO_COMPLETE_MAX_LENGTH , $className = '')
	{
            if(!$className)
            {
		$className =  ucfirst($this->id);
                if( $className == 'Admin')
                {
                        $className = 'User';
                        if($name == 'email')
                        {
                            $name == 'contact_id';
                        }
                }    
            }
                try
                {
                    $value = CommonUtility::createValue($value,$name);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                $name = $className.'['.$name.']';
                 //echo $url;exit;       
		$this->widget('CAutoComplete',
                  array(
                                 //name of the html field that will be generated
                     'name'=>$name, 
                                 //replace controller/action with real ids
                     'url'=>array($url),   //array('roles/autocompletelookup'), 
                     'max'=>$limit, //10, //specifies the max number of items to display
                      'value'=> $value,//CommonUtility::createValue($fillFields,'role_name'),
                                 //specifies the number of chars that must be entered 
                                 //before autocomplete initiates a lookup
                     'minChars'=>1, 
                    // 'delay'=>2, //number of milliseconds before lookup occurs
                     'matchCase'=>true, //match case when performing a lookup?

                                 //any additional html attributes that go inside of 
                                 //the input field can be defined here
                     'htmlOptions'=>array('size'=>Globals::DEFAULT_VAL_40,'class'=>$class), 


                     ));
	}
        public function getAutoCompleteData($name,$tableName,$fieldName,$limit,$where=NULL)
	{
            $criteria = new CDbCriteria;
            $criteria->condition = Globals::DEFAULT_VAL_NULL.$fieldName." LIKE :sterm";
            if($where!=NULL)
            {
                $criteria->addCondition('language_code = "'.$where.'" ');
            }
            if($tableName == Globals::FLD_NAME_ADMIN)
            {
                $criteria->addCondition('user_id!="'.Yii::app()->params[Globals::FLD_NAME_SUPER_ADMINID].'" ');   
            }
            $criteria->params = array(":sterm"=>"%$name%");
            $criteria->limit = $limit;
            $criteria->group = $fieldName;
            $autocompleteArray = $tableName::model()->findAll($criteria);
			//print_r( $autocompleteArray);exit;
            $returnVal = Globals::DEFAULT_VAL_NULL;
            foreach($autocompleteArray as $autocomplete)
            {
                $returnVal .= $autocomplete->getAttribute($fieldName).Globals::DEFAULT_VAL_SLACE_N;
            }
            echo $returnVal;
	}
        public function passwordValidationFormScript()
	{
            $result =   "
                        <script>
                            $(document).ready(function(){
                                $('input').on('blur', function()
                                {
        
                                    if($(this).val() == '')
                                    {                                       
                                        var thisID = this.id;
                                        $(this).parent().addClass(\"error\");
                                        var  thisName = thisID.replace(\"Admin_\",\"\"); 
                                        thisName = thisName.replace(\"User_\",\"\");
                                        document.getElementById(thisID+\"_em_\").style.display='';
                                        $.ajax({
                                            type: \"GET\",
                                            url: \"".Yii::app()->createUrl(Globals::COMMON_AJAX_GET_FIELD_LABEL)."\",
                                            data: 	\"thisname=\" + thisName + \"&model=".ucfirst($this->id)."&is_ajax=\" + 1,
                                            success: function(html)
                                            {
                                                document.getElementById(thisID+\"_em_\").innerHTML =html+\" cannot be blank.\";
                                            }
                                        });
                                    }
                                });
	
                            });
                        </script>
                        ";
            echo $result;
        }
        public function updateProfileValidation()
	{
            $result =   "
                        <script>
                            $(document).ready(function(){
                                $('input').on('blur', function()
                                {
                                    if(this.id != 'User_lastname')
                                    {
                                            if($(this).val() == '')
                                            {
                                                //alert(this.id);
                                                    var thisID = this.id;
                                                    
                                                    var  thisName = thisID.replace(\"User_\",\"\"); 
                                                    
                                                    $.ajax({
                                                            type: \"GET\",
                                                            url: \"".Yii::app()->createUrl(Globals::COMMON_FRONT_AJAX_GET_FIELD_LABEL)."\",
                                                            data: 	\"thisname=\" + thisName + \"&model=".ucfirst($this->id)."&is_ajax=\" + 1,
                                                            success: function(html)
                                                            {
                                                                    //alert('fghdfg');
                                                                    document.getElementById(thisID+\"_em_\").style.display='';
                                                                    document.getElementById(thisID+\"_em_\").innerHTML =html+\" cannot be blank.\";
                                                                    $(this).parent().addClass(\"error\");
                                                            }
                                                    });
                                            }
                                    }
                                });
	
                            });
                        </script>
                        ";
            echo $result;
        }
    public function updateContactInformationValidation()
	{
            $result =   "
                        <script>
                               function addmore()
                               {
                                   var num = $('#chatnum').val();
                                    $('#chatcontainer .addRemove #addmore ').attr('onclick', 'return false');
                                    $.ajax({
                                            type: \"POST\",
                                            url: '".Globals::BASH_URL."/user/getchatfield',
                                            data: {'num':num},
                                            success: function(data) {
                                                $('#chatcontainer').append(data);
                                                num++;
                                                $('#chatcontainer #fields').html('<input type=\"hidden\" id=\"chatnum\" name=\"totalChatId\" value=\"'+num+'\"/>');
                                                if(num==1)
                                                {
                                                    $( \"#chatcontainer .addRemove #remScnt \").css(\"display\", \"none\");
                                                }
                                                else
                                                {
                                                    $( \"#chatcontainer .addRemove #remScnt \").css(\"display\", \"inline\");
                                                }
                                                $('#chatcontainer .addRemove #addmore ').attr('onclick', 'addmore();');
                                            },
                                            dataType: 'html'
                                    });

                               }
                               function addmoresocial()
                               {
                                   var num = $('#socialnum').val();
                                   $('#socialcontainer .addRemove #addmore ').attr('onclick', 'return false');
                                        $.ajax({
                                            type: \"POST\",
                                            url: '".Globals::BASH_URL."/user/getsocialfield',
                                            data: {'num':num},
                                            success: function(data) {
                                                $('#socialcontainer').append(data);
                                                num++;
                                                $('#socialcontainer #fields').html('<input type=\"hidden\" id=\"socialnum\" name=\"totalSocialId\" value=\"'+num+'\"/>');
                                                if(num==1){ $( \"#socialcontainer .addRemove #remSocial \").css(\"display\", \"none\");}
                                                else{ $( \"#socialcontainer .addRemove #remSocial \").css(\"display\", \"inline\"); }
                                                $('#socialcontainer .addRemove #addmore ').attr('onclick', 'addmoresocial();');
                                            },
                                            dataType: 'html'
                                        });

                               }
                               function addmoremobile()
                               {
                                    var num = $('#mobilenum').val();
                                    $('#mobilecontainer .addRemove #addmoremobile ').attr('onclick', 'return false');
                                    if(num<=1)
                                    {
                                        $.ajax({
                                            type: \"POST\",
                                            url: '".Globals::BASH_URL."/user/getmobilefield',
                                            data: {'num':num},
                                            success: function(data) {
                                                $('#mobilecontainer').append(data);
                                                num++;
                                                $('#mobilecontainer #fields').html('<input type=\"hidden\" id=\"mobilenum\" name=\"totalMobileId\" value=\"'+num+'\"/>');
                                                if(num==1)
                                                { 
                                                    $( \"#mobilecontainer .addRemove #remMobile \").css(\"display\", \"none\");
                                                    $( \"#mobilecontainer .addRemove #addmoremobile \").css(\"display\", \"inline\");
                                                }
                                                else
                                                { 
                                                    $( \"#mobilecontainer .addRemove #remMobile \").css(\"display\", \"inline\"); 
                                                     $( \"#mobilecontainer .addRemove #addmoremobile \").css(\"display\", \"none\");
                                                }
                                                $('#mobilecontainer .addRemove #addmoremobile ').attr('onclick', 'addmoremobile()');
                                            },
                                            dataType: 'html'
                                        });
                                    }
                               }
                               function addmoreemail()
                               {
                                    var num = $('#emailnum').val();
                                    $('#emailcontainer .addRemove #addmore ').attr('onclick', 'return false');
                                    if(num<=1)
                                    {
                                        $.ajax({
                                            type: \"POST\",
                                            url: '".Globals::BASH_URL."/user/getemailfield',
                                            data: {'num':num},
                                            success: function(data) {
                                                $('#emailcontainer').append(data);
                                                num++;
                                                $('#emailcontainer #fields').html('<input type=\"hidden\" id=\"emailnum\" name=\"totalEmailId\" value=\"'+num+'\"/>');
                                                if(num==1)
                                                {
                                                    $( \"#emailcontainer .addRemove #remEmail \").css(\"display\", \"none\");
                                                    $( \"#emailcontainer .addRemove #addmore \").css(\"display\", \"inline\");
                                                }
                                                else
                                                { 
                                                    $( \"#emailcontainer .addRemove #remEmail \").css(\"display\", \"inline\");
                                                    $( \"#emailcontainer .addRemove #addmore \").css(\"display\", \"none\"); 
                                                }
                                                $('#emailcontainer .addRemove #addmore ').attr('onclick','addmoreemail()');
                                            },
                                            dataType: 'html'
                                        });
                                    }
                               }
                               function validateForm(contactInfo)
                               {                                  
                                    var errorLogVal = new Array();
                                    var errorLog = new Array();
                                    var errorLogName = new Array();
                                    var ret = true;
                                    var checkMobile = new Array();
                                    var checkEmail = new Array();
                                    var checkChat = new Array();
                                   
                                    var checkSocial = new Array();
                                   
                                    var formElements = new Array();
                                    $('#contactinformation-form input, #contactinformation-form select').each(function(){
                                        formElements.push($(this));
                                    });
                                    //alert(formElements);
                                    
                                    for (i=0; i<formElements.length; i++)
                                    {
                                        if($(formElements[i]).hasClass('mobile'))
                                        {
                                            var mobileVal =  formElements[i].val();
                                 
                                            
                                            var msg = '';
                                            if(checkMobile.indexOf(mobileVal) > -1)
                                            {
                                                msg = '".Yii::t('commonutlity','cont_insert_dub_mobile_msg_text')."';
                                            }
                                            checkMobile[i] = mobileVal;
                                            /*if(isNaN(mobileVal))  
                                            {  
                                                   msg = '".Yii::t('commonutlity','mobile_must_num_msg_text')."';
                                            } */
                                            if(mobileVal.length < 10 && mobileVal.length > 0)
                                            {
                                                   msg = '".Yii::t('commonutlity','mobile_too_short_msg_text')."';
                                            }
                                            if(msg !='')
                                            {
                                                errorLogName[i]='mobile_id_'+i;
                                                errorLog[i] = msg;
//                                                alert(errorLog['abc_'+i]);
                                                $(formElements[i]).next('.help-block').text(msg);
                                                $(formElements[i]).next('.help-block').css(\"display\", \"inline\");
                                                $(formElements[i]).addClass('hasError');
                                                ret = false;
                                            }
                                            else
                                            {
                                                $(formElements[i]).next('.help-block').text(msg);
                                                $(formElements[i]).next('.help-block').css(\"display\", \"none\");
                                                $(formElements[i]).removeClass('hasError');
                                            }

                                        }                                         
                                        if($(formElements[i]).hasClass('email'))
                                        {
                                            
                                            var emailVal = formElements[i].val();
                                            var msg = '';
                                            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                                            
                                            if(checkEmail.indexOf(emailVal) > -1)
                                            {
                                                msg = '".Yii::t('commonutlity','duplicate_email_msg_text')."';
                                            }
                                            checkEmail[i] = emailVal;
                                            if(!regex.test(emailVal) && emailVal.length > 0 )  
                                            {   
                                                var msg = '".Yii::t('commonutlity','invalid_email_msg_text')."';
                                            } 
                                            else if(emailVal.length < 3 && emailVal.length > 0)
                                            {
                                                var msg = '".Yii::t('commonutlity','email_too_short_msg_text')."';
                                            }
                                            if(msg !='')
                                            {
                                                errorLog[i] = msg;
                                                errorLogName[i]='email_id_'+i;
                                                //error['email_id'+i] = msg;
                                                $(formElements[i]).next('.help-block').text(msg);
                                                $(formElements[i]).next('.help-block').css(\"display\", \"inline\");
                                                $(formElements[i]).addClass('hasError');
                                                ret = false;
                                            }
                                            else
                                            {
                                                $(formElements[i]).next('.help-block').text(msg);
                                                $(formElements[i]).next('.help-block').css(\"display\", \"none\");
                                                $(formElements[i]).removeClass('hasError');
                                            }
                                        }
                                        if($(formElements[i]).hasClass('chat'))
                                        {
                                           
                                            var cahtVal =formElements[i].val();
                                             var chatvalof = $(formElements[i]).next('select').val();
                                            var msg = '';

                                            if($('#User_chat_id_2_chat_id').length)
                                            {
                                                if(checkChat.indexOf(cahtVal+'-'+chatvalof) > -1 )
                                                {
                                                        msg = '".Yii::t('commonutlity','duplicate_chat_msg_text')."';
                                                }
                                                checkChat[i] = cahtVal+'-'+chatvalof;
                                                if(cahtVal == '')
                                                {
                                                    var msg = '".Yii::t('commonutlity','blank_chat_msg_text')."';
                                                    $(formElements[i]).addClass('hasError');
                                                }

                                                if(msg !='' )
                                                {
                                                    errorLog[i] = msg;
                                                    errorLogName[i]='chat_id_'+i;
                                                    //error['chat_id'+i] = msg;
                                                    $(formElements[i]).next('select').next('.help-block').text(msg);
                                                    $(formElements[i]).next('select').next('.help-block').css(\"display\", \"inline\");
                                                    ret = false;
                                                }
                                                else
                                                {
                                                    $(formElements[i]).next('select').next('.help-block').text('');
                                                    $(formElements[i]).next('select').next('.help-block').css(\"display\", \"none\");

                                                }
                                            }
                                            else
                                            {
                                                $(formElements[i]).next('select').next('.help-block').text('');
                                                $(formElements[i]).next('select').next('.help-block').css(\"display\", \"none\");

                                            }

                                        }
                                        if($(formElements[i]).hasClass('social'))
                                        {
                                           
                                            var socialVal = formElements[i].val();
                                            var socialValof = $(formElements[i]).next('select').val();
                                            var msg = '';
                                            if($('#User_social_2_social').length)
                                            {
                                                if(checkSocial.indexOf(socialVal+'-'+socialValof) > -1)
                                                {
                                                    msg = '".Yii::t('commonutlity','duplicate_social_msg_text')."';
                                                }
                                                checkSocial[i] = socialVal+'-'+socialValof;
                    
                                                if(socialVal == '')
                                                {
                                                    var msg = '".Yii::t('commonutlity','blank_social_msg_text')."';
                                                    $(formElements[i]).addClass('hasError');
                                                }

                                                if(msg !='')
                                                {
                                                    errorLog[i] = msg;
                                                    errorLogName[i]='social_id_'+i;
                                                    //error['social_id'+i] = msg;
                                                    $(formElements[i]).next('select').next('.help-block').text(msg);
                                                    $(formElements[i]).next('select').next('.help-block').css(\"display\", \"inline\");
                                                    ret = false;
                                                }
                                                else
                                                {
                                                    $(formElements[i]).next('select').next('.help-block').text('');
                                                    $(formElements[i]).next('select').next('.help-block').css(\"display\", \"none\");

                                                }
                                            }
                                            else
                                            {
                                                $(formElements[i]).next('select').next('.help-block').text('');
                                                $(formElements[i]).next('select').next('.help-block').css(\"display\", \"none\");

                                            }
                                        }
                                        //alert(formElements[i].val());
                                        errorLogVal[i]=formElements[i].val();
                                        //alert(i);
                                        
                                    }
                                    if(ret==false)
                                        {
                                            $(\".changepas_bnt\").removeClass(\"loading\");
                                        }
                                        $.ajax({
                                            type: \"POST\",
                                            url: '".Globals::BASH_URL."/user/getlog',
                                            data: {'errorLog':errorLog,'errorLogName':errorLogName,'errorLogVal':errorLogVal},
                                            success: function(data) {
//                                               alert(data)
                                            },
                                            dataType: 'html'
                                        });
//                                        alert(errorLog['mobile_id_1']);
                                    return ret;
//                                    return errorLog;
                               }

                               $(function() {
                                    if($('#chatnum').val()==1)  { $( \"#chatcontainer .addRemove #remScnt \").css(\"display\", \"none\");      }
                                    if($('#mobilenum').val()==1){ $( \"#mobilecontainer .addRemove #remMobile \").css(\"display\", \"none\");  }
                                    if($('#mobilenum').val()==2){ $( \"#mobilecontainer .addRemove #addmoremobile \").css(\"display\", \"none\");  }
                                    if($('#emailnum').val()==1) { $( \"#emailcontainer .addRemove #remEmail \").css(\"display\", \"none\");    }
                                    if($('#emailnum').val()==2) { $( \"#emailcontainer .addRemove #addmore \").css(\"display\", \"none\");    }

                                    if($('#socialnum').val()==1){ $( \"#socialcontainer .addRemove #remSocial \").css(\"display\", \"none\");  }
                            
//    $('#remScnt').live('click', function() 
//    { 
//        $( \"#chatcontainer .removeControl\" ).last().remove();
//        var num = $('#chatnum').val();
//        num--;
//        $('#chatcontainer #fields').html('<input type=\"hidden\" id=\"chatnum\" name=\"totalChatId\" value=\"'+num+'\"/>');
//        if(num==1)
//        {
//            $( \"#chatcontainer .addRemove #remScnt \").css(\"display\", \"none\");
//            $('#User_chat_id_1_chat_id').next('select').next('.help-block').text('');
//            $('#User_chat_id_1_chat_id').next('select').next('.help-block').css(\"display\", \"none\");
//        }
//        else
//        {
//            $( \"#chatcontainer .addRemove #remScnt \").css(\"display\", \"inline\");
//        }
//    });
//    $('#remMobile').live('click', function() { 
//        $( \"#mobilecontainer .removeControl\" ).last().remove();
//        var num = $('#mobilenum').val();
//        num--;
//        $('#mobilecontainer #fields').html('<input type=\"hidden\" id=\"mobilenum\" name=\"totalMobileId\" value=\"'+num+'\"/>');
//        if(num==1)
//        { 
//        $( \"#mobilecontainer .addRemove #remMobile \").css(\"display\", \"none\");
//        $( \"#mobilecontainer .addRemove #addmoremobile \").css(\"display\", \"inline\");
//        }
//        else
//        { 
//        $( \"#mobilecontainer .addRemove #remMobile \").css(\"display\", \"inline\"); 
//         $( \"#mobilecontainer .addRemove #addmoremobile \").css(\"display\", \"none\");
//        }
//    });
//     $('#remEmail').live('click', function() { 
//            $( \"#emailcontainer .removeControl\" ).last().remove();
//            var num = $('#emailnum').val();
//            num--;
//            $('#emailcontainer #fields').html('<input type=\"hidden\" id=\"emailnum\" name=\"totalEmailId\" value=\"'+num+'\"/>');
//            if(num==1)
//            {
//                $( \"#emailcontainer .addRemove #remEmail \").css(\"display\", \"none\");
//                $( \"#emailcontainer .addRemove #addmore \").css(\"display\", \"inline\");
//            }
//            else
//            { 
//                $( \"#emailcontainer .addRemove #remEmail \").css(\"display\", \"inline\");
//                $( \"#emailcontainer .addRemove #addmore \").css(\"display\", \"none\"); 
//            }
//    });
//
//     $('#remSocial').live('click', function() { 
//            $( \"#socialcontainer .removeControl\" ).last().remove();
//            var num = $('#socialnum').val();
//            num--;
//            $('#socialcontainer #fields').html('<input type=\"hidden\" id=\"socialnum\" name=\"totalSocialId\" value=\"'+num+'\"/>');
//            if(num==1)
//            {
//                $(\"#socialcontainer .addRemove #remSocial \").css(\"display\", \"none\");
//                $('#User_social_1_social').next('select').next('.help-block').text('');
//                $('#User_social_1_social').next('select').next('.help-block').css(\"display\", \"none\");
//            }
//            else
//            {
//                $(\"#socialcontainer .addRemove #remSocial \").css(\"display\", \"inline\");
//            }
//    });


                                     
                                });
                                    $('.mobile').live('blur', function() { 

                                                var msg = '';
                                              /*if(isNaN(this.value))  
                                              {  
                                                  var msg = '".Yii::t('commonutlity','mobile_must_num_msg_text')."';
                                                  $(this).next('.help-block').css(\"display\", \"inline\");
                                                  $(this).addClass('hasError');
                                              } */
                                              if(this.value.length < 10 && this.value.length > 0)
                                              {
                                                  var msg = '".Yii::t('commonutlity','mobile_too_short_msg_text')."';
                                                  $(this).next('.help-block').css(\"display\", \"inline\");
                                                  $(this).addClass('hasError');
                                              }
                                              else
                                              {
                                                  var msg = ''

                                                  $(this).next('.help-block').css(\"display\", \"none\");
                                                  $(this).removeClass('hasError');
                                              }
                                            $(this).next('.help-block').text(msg);
                                    });
                                    $('.email').live('blur', function() { 

                                                var msg = '';
                                                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                                                if(!regex.test(this.value) && this.value.length > 0 )  
                                                {   
                                                      var msg = '".Yii::t('commonutlity','invalid_email_msg_text')."';
                                                      $(this).next('.help-block').css(\"display\", \"inline\");
                                                      $(this).addClass('hasError');
                                                } 
                                                else if(this.value.length < 3 && this.value.length > 0)
                                                {
                                                      var msg = '".Yii::t('commonutlity','email_too_short_msg_text')."';
                                                      $(this).next('.help-block').css(\"display\", \"inline\");
                                                      $(this).addClass('hasError');
                                                }
                                                else
                                                {
                                                      var msg = ''
                                                      $(this).next('.help-block').css(\"display\", \"none\");
                                                      $(this).removeClass('hasError');
                                                }
                                               $(this).next('.help-block').text(msg);

                                    });
                                   // $('#contactinformation-form').validate_popover({ popoverPosition: 'top' });
                            </script>
                        ";
            echo $result;
        }
    public function updateAboutUsValidation()
	{
            $result =   "
                        <script>
                            $(document).ready(function()
                                    {
                                            $('#User_about_me').keyup(function(){

                                            /*if($(this).val().match(/^[ \s]/)){
                                                    return false;
                                                    //alert('space not allow');
                                                    //t.value=t.value.replace(/\s/g,'');
                                              }*/
                                            var vall = $(this).val().length;
                                            var total=1000;
                                            total = total-vall;
                                            //alert(total);
                                            $('#wordcount').html('".Yii::t('commonutlity','remaining_character_text')."'+total);
                                            });
                                    });
                               function addmoreCertificate()
                               {
                                   var num = $('#certfnum').val();
                                   $('#certificateCon .addRemove #addmore ').attr('onclick', 'return false');
                                        $.ajax({
                                            type: \"POST\",
                                            url: '".Globals::BASH_URL."/index/getcertificatefield',
                                            data: {'num':num},
                                            success: function(data) {
                                                $('#certificateCon').append(data);
                                                num++;
                                                $('#certificateCon #fields').html('<input type=\"hidden\" id=\"certfnum\" name=\"totalCertfId\" value=\"'+num+'\"/>');
                                                if(num==1)
                                                {
                                                    $( \"#certificateCon .addRemove #remCertf \").css(\"display\", \"none\");
                                                }
                                                else
                                                {
                                                    $( \"#certificateCon .addRemove #remCertf \").css(\"display\", \"inline\");
                                                }
                                                $('#certificateCon .addRemove #addmore ').attr('onclick', 'addmoreCertificate()');
                                            },
                                            dataType: 'html'
                                        });

                               }
//                               function addmoreCertificate()
//                               {
//                                   var num = 1;
//                                   var num = $('#certfnum_'+num).val();
//                                   var total = $('#total_cert').val();
//                                   $('#certificateCon .addRemove #addmore ').attr('onclick', 'return false');
//                                        $.ajax({
//                                            type: \"POST\",
//                                            url: '".Globals::BASH_URL."/index/getcertificatefield',
//                                            data: {'num':num,'total':total},
//                                            success: function(data) {
//                                                $('#certificateCon').append(data);
//                                                num++;
//                                                total++;
//                                                $('#certificateCon #total').html('<input type=\"hidden\" id=\"total_cert\" name=\"total_cert\" value=\"'+total+'\"/>');
//                                                if(total==1)
//                                                {
//                                                    if(num==1)
//                                                    {
//                                                        $( \"#certificateCon .addRemove #remCertf \").css(\"display\", \"none\");
//                                                    }
//                                                    else
//                                                    {
//                                                        $( \"#certificateCon .addRemove #remCertf \").css(\"display\", \"inline\");
//                                                    }
//                                                }
//                                                else
//                                                {
//                                                    if(num==1)
//                                                    {
//                                                        $( \"#certificateCon .addRemove #addmore \").css(\"display\", \"none\");
//                                                    }
//                                                    else
//                                                    {
//                                                        $( \"#certificateCon .addRemove #addmore \").css(\"display\", \"inline\");
//                                                    }
//                                                }
//                                                $('#certificateCon .addRemove #addmore ').attr('onclick', 'addmoreCertificate()');
//                                            },
//                                            dataType: 'html'
//                                        });
//
//                               }
                               function addmoreSkills()
                               {
                                   var num = $('#skillsnum').val();
                                   $('#skillscontainer .addRemove #addmore ').attr('onclick', 'return false');
                                        $.ajax({
                                            type: \"POST\",
                                            url: '".Globals::BASH_URL."/index/getskillsfield',
                                            data: {'num':num},
                                            success: function(data) {
                                                $('#skillscontainer').append(data);
                                                num++;
                                                $('#skillscontainer #fields').html('<input type=\"hidden\" id=\"skillsnum\" name=\"totalSkillsId\" value=\"'+num+'\"/>');
                                                if(num==1){ $( \"#skillscontainer .addRemove #remSkills \").css(\"display\", \"none\");}
                                                else{ $( \"#skillscontainer .addRemove #remSkills \").css(\"display\", \"inline\"); }
                                            $('#skillscontainer .addRemove #addmore ').attr('onclick', 'addmoreSkills()');
                                            },
                                            dataType: 'html'
                                        });

                               }
                               function validateFormAboutUs()
                               {
                                   //alert('fctghfc');
                                   var elements = document.forms['aboutus-form'].elements;
                                   var ret = true;
                                    var checkcertificate = new Array();
                                    var checkskills = new Array();
                                    for (i=0; i<elements.length; i++)
                                    {
                                        if($('#'+document.forms['aboutus-form'].elements[i].id).hasClass('certificate'))
                                        {
                                            //alert(certificateId);
                                            var certificateId = document.forms['aboutus-form'].elements[i].id;
                                            var certificateVal = document.forms['aboutus-form'].elements[i].value;
                                            var msg = '';
                                            var certificateValYear = $('#'+certificateId).next('select').val();
                                            
                                            if($('#User_certificate_id_2_certificate').length)
                                            {
                                            //
                                            
                                                if(checkcertificate.indexOf(certificateVal+'-'+certificateValYear) > -1)
                                                {
                                                    msg = '".Yii::t('commonutlity','duplicate_certificate_msg_text')."';
                                                }
                                                checkcertificate[i] = certificateVal+'-'+certificateValYear;
                                                if(certificateVal == '')
                                                {
                                                    var msg = '".Yii::t('commonutlity','blank_certificate_msg_text')."';
                                                    $('#'+certificateId).addClass('hasError');
                                                }
                                                if(msg !='' )
                                                {
                                                    $('#'+certificateId).next('select').next('.help-block').text(msg);
                                                    $('#'+certificateId).next('select').next('.help-block').css(\"display\", \"inline\");
                                                    ret = false;
                                                }
                                                else
                                                {
                                                    $('#'+certificateId).next('select').next('.help-block').text('');
                                                    $('#'+certificateId).next('select').next('.help-block').css(\"display\", \"none\");

                                                }
                                            }
                                            else
                                            {
                                                $('#'+certificateId).next('select').next('.help-block').text('');
                                                $('#'+certificateId).next('select').next('.help-block').css(\"display\", \"none\");

                                            }

                                        }
                                    $('#User_about_me_em_').css('display','none');
                                    if($('#User_about_me').val().length < 10)
                                            {
                                                    $('#User_about_me_em_').css('display','block');
                                                    $('#User_about_me_em_').html('".Yii::t('commonutlity','description_short_msg_text')."');
                                                     ret = false;
                                            }
                                            if($('#User_about_me').val().match(/^[ \s]/)){
                                                    $('#User_about_me_em_').css('display','block');
                                                    $('#User_about_me_em_').html('".Yii::t('commonutlity','space_not_allowed_msg_text')."');
                                                     ret = false;
                                            }

                                    if($('#'+document.forms['aboutus-form'].elements[i].id).hasClass('skills'))
                                        {
                                            //alert(skillsId);
                                            var skillsId = document.forms['aboutus-form'].elements[i].id;
                                            var skillsVal = document.forms['aboutus-form'].elements[i].value;
                                            var msg = '';

                                            if($('#User_skills_id_2_skills').length)
                                            {
                                               // alert(skillsId);
                                               if(checkskills.indexOf(skillsVal) > -1)
                                                {
                                                    msg = '".Yii::t('commonutlity','duplicate_skills_msg_text')."';
                                                }
                                                checkskills[i] = skillsVal;
                                                
                                                if(skillsVal == '')
                                                {
                                                    var msg = '".Yii::t('commonutlity','blank_skills_msg_text')."';
                                                    $('#'+skillsId).addClass('hasError');
                                                }
                                                if(msg !='' )
                                                {
                                                    $('#'+skillsId).next('.help-block').text(msg);
                                                    $('#'+skillsId).next('.help-block').css(\"display\", \"inline\");
                                                    ret = false;
                                                }
                                                else
                                                {
                                                    $('#'+skillsId).next('.help-block').text('');
                                                    $('#'+skillsId).next('.help-block').css(\"display\", \"none\");

                                                }
                                            }
                                            else
                                            {
                                                $('#'+skillsId).next('.help-block').text('');
                                                $('#'+skillsId).next('.help-block').css(\"display\", \"none\");

                                            }

                                        }
                                    }
                                    if(ret==false)
                                        {
                                            $(\".changepas_bnt\").removeClass(\"loading\");
                                        }
										//alert(ret);
                                    return ret;

                               }

                               $(function() {
                                    if($('#certfnum').val()==1)  { $( \"#certificateCon .addRemove #remCertf \").css(\"display\", \"none\");      }
                                    if($('#skillsnum').val()==1){ $( \"#skillscontainer .addRemove #remSkills \").css(\"display\", \"none\");  }
                                   
//                                     $('#remCertf').live('click', function() { 
//                                        $( \"#certificateCon .removeControl\" ).last().remove();
//                                        var num = $('#certfnum').val();
//                                        num--;
//                                        $('#certificateCon #fields').html('<input type=\"hidden\" id=\"certfnum\" name=\"totalCertfId\" value=\"'+num+'\"/>');
//                                        if(num==1)
//                                        {
//                                            $( \"#certificateCon .addRemove #remCertf \").css(\"display\", \"none\");
//                                            $('#User_certificate_id_1_certificate_id').next('select').next('.help-block').text('');
//                                            $('#User_certificate_id_1_certificate_id').next('select').next('.help-block').css(\"display\", \"none\");
//                                        }
//                                        else
//                                        {
//                                            $( \"#certificateCon .addRemove #remCertf \").css(\"display\", \"inline\");
//                                        }
//                                    });
//                                     $('#remSkills').live('click', function() { 
//                                            $( \"#skillscontainer .removeControl\" ).last().remove();
//                                            var num = $('#skillsnum').val();
//                                            num--;
//                                            $('#skillscontainer #fields').html('<input type=\"hidden\" id=\"skillsnum\" name=\"totalSkillsId\" value=\"'+num+'\"/>');
//                                            if(num==1)
//                                            {
//                                                $(\"#skillscontainer .addRemove #remSkills \").css(\"display\", \"none\");
//                                                $('#User_skills_1_skills').next('select').next('.help-block').text('');
//                                                $('#User_skills_1_skills').next('select').next('.help-block').css(\"display\", \"none\");
//                                            }
//                                            else
//                                            {
//                                                $( \"#skillscontainer .addRemove #remSkills \").css(\"display\", \"inline\");
//                                            }
//                                    });
                                });
                                    //$('#aboutus-form').validate_popover({ popoverPosition: 'top' });
                            </script>
                        ";
            echo $result;
        }   
        public  function getUploader($name,$action = '',$allowedExtensions = '',$maxlimit = '',$minlimit = '',$success=NULL)
	{
            $action = empty($action) ? Yii::app()->createUrl('poster/uploadtaskfiles') : $action;
            $allowedExtensions = empty($allowedExtensions) ?  array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]) : $allowedExtensions;
            $maxlimit = empty($maxlimit) ? LoadSetting::getMaxUploadFileSize() : $maxlimit;
            $minlimit = empty($minlimit) ? LoadSetting::getSettingValue(Globals::SETTING_KEY_MIN_UPLOAD_FILE_SIZE) : $minlimit;
            
            $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                                                                'id'=>$name,
                                                                'config'=>array(
                                                                'action'=>$action,
                                                                'allowedExtensions'=>$allowedExtensions,//array("jpg","jpeg","gif","exe","mov" and etc...
                                                                'sizeLimit'=>$maxlimit,// maximum file size in bytes
                                                                'minSizeLimit'=>$minlimit,// minimum file size in bytes
                                                                'dataType'=>'json',
                                                                'onComplete'=>"js:function(id, fileName, responseJSON)
                                                                { ".$success." }",
                                                                //'messages'=>array(
                                                                //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                                                //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                                                //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                                                //                  'emptyError'=>"{file} is empty, please select files again without it.",
                                                                //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                                                //                 ),
                                                                //'showMessage'=>"js:function(message){ alert(message); }"
                                                                )
            ));
            echo CHtml::hiddenField($name.'_totalFileSize', $maxlimit);
            echo CHtml::hiddenField($name.'_totalFileSizeUsed', 0);
            echo CHtml::hiddenField($name.'_totalFileSizeLimit', 0);
            echo CHtml::hiddenField($name.'_totalMaxFileSizeLimit', LoadSetting::getSpaceQuotaAllowed());
	}
        public function getAjaxSubmitButton($name,$action,$class,$id,$success=Globals::DEFAULT_VAL_NULL,$before=Globals::DEFAULT_VAL_NULL)
	{
            $id = $id.uniqid();
            echo CHtml::ajaxSubmitButton($name,$action,array(
			   'type'=>'POST',
			   'dataType'=>'json',
			   'success'=>'js:function(data){
                               $("#'.$id.'").removeClass("loading");
				   '.$success.'
			   }',
                            'beforeSend'=>'function(){   
                                $("#'.$id.'").addClass("loading");
                                    $(".help-block").css("display", "none");
                                   '.$before.'
                              }'
			),array('class'=>$class,'id' => $id ,'live'=>false));
	}
    
	public function changeDateFormate($newFormate,$date)
	{
//		$date=DateTime::createFromFormat($currentFormate,$date);
//		echo  $date->format($newFormate);
                //echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($date, 'yyyy-MM-dd'),'medium',null);
                //return Yii::app()->format->date(strtotime($date));
                
               return date ($newFormate, strtotime($date));
               return $date;
	}
    
	public function moveFileToNewLocation($source,$destination,$file)
	{
            if (@copy($source.$file, $destination.$file)) 
            {
                    @unlink($source.$file);
            }
	}                     
        public function getUrlFromJson($json,$type,$size=Globals::DEFAULT_VAL_NULL)//size : 80x80
	{
            if($json)
            {
                $jsonArray = CJSON::decode($json);
                if($type == Globals::FLD_NAME_VIDEO)
                {
                   return Globals::FRONT_USER_VIEW_IMAGE_PATH.$jsonArray[Globals::FLD_NAME_VIDEO];
                }
                elseif($type == Globals::FLD_NAME_PIC && $jsonArray[Globals::FLD_NAME_PIC] )
                {
                    
                    if($size!= Globals::DEFAULT_VAL_NULL && file_exists(Globals::FRONT_USER_MEDIA_BASE_PATH.$jsonArray[Globals::FLD_NAME_PIC])  )
                    {
                        $imageInfo = explode('.', $jsonArray[Globals::FLD_NAME_PIC]);
                        $image = str_replace(Globals::FRONT_USER_USER_IMAGE_NAME_SLUG, Globals::DEFAULT_VAL_NULL, $imageInfo[0]);
                       // exit;
                        $ext = $imageInfo[1];
                        $imageFullName =$image."_".$size.".".$ext;
                        if (file_exists(Globals::FRONT_USER_MEDIA_BASE_PATH.$imageFullName)) 
                        {
                           return Globals::FRONT_USER_VIEW_IMAGE_PATH.$imageFullName;
                        } 
                        else
                        {
                            $imagestatus = self::createThumbnailImage($size , $jsonArray[Globals::FLD_NAME_PIC] );
                            if($imagestatus)
                            {
                              return Globals::FRONT_USER_VIEW_IMAGE_PATH.$imagestatus;
                            }
                        }
                    }
                    else
                    {
                        return Globals::FRONT_USER_VIEW_IMAGE_PATH.$jsonArray[Globals::FLD_NAME_PIC];
                    }
                }
            }
	}
        public function getPortfolioAttachmentUrlFromJson($json,$type,$size=Globals::DEFAULT_VAL_NULL)
	{
            if($json )
            {
                $imgUrl='';
                $jsonArray=CJSON::decode($json);
                if(isset($jsonArray))
                {
                    foreach($jsonArray as $file )
                    {
                        if($type==Globals::FLD_NAME_VIDEO)
                        {
                                if($file[Globals::FLD_NAME_TYPE]==Globals::FLD_NAME_VIDEO)
                                 $imgUrl[$file[Globals::FLD_NAME_FILE]] =  Globals::FRONT_USER_VIEW_IMAGE_PATH.$file[Globals::FLD_NAME_FILE];
                        }
                        elseif($type==Globals::DEFAULT_VAL_IMAGE_TYPE)
                        {
                                if($file[Globals::FLD_NAME_TYPE]==Globals::DEFAULT_VAL_IMAGE_TYPE)
                                {
                                    if($size!=Globals::DEFAULT_VAL_NULL)
                                    {
                                        $imageInfo = explode('.', $file[Globals::FLD_NAME_FILE]);
                                        $image = str_replace(Globals::FRONT_USER_USER_IMAGE_NAME_SLUG, Globals::DEFAULT_VAL_NULL, $imageInfo[0]);
                                        $ext = $imageInfo[1];
                                        $imageFullName =$image."_".$size.".".$ext;
                                        if (file_exists(Globals::FRONT_USER_MEDIA_BASE_PATH.$imageFullName)) 
                                        {
                                           $imgUrl[$file[Globals::FLD_NAME_FILE]] =  Globals::FRONT_USER_VIEW_IMAGE_PATH.$imageFullName;
                                        } 
                                        else
                                        {
                                            $imagestatus = self::createThumbnailImage($size , $file[Globals::FLD_NAME_FILE] );
                                            if($imagestatus)
                                            {
                                             $imgUrl[$file[Globals::FLD_NAME_FILE]] = Globals::FRONT_USER_VIEW_IMAGE_PATH.$imagestatus;
                                            }
                                          
                                        }
                                    }
                                    else
                                    {
                                        
                                        $imgUrl[$file[Globals::FLD_NAME_FILE]] = Globals::FRONT_USER_VIEW_IMAGE_PATH.$file[Globals::FLD_NAME_FILE];
                                    }
                                }
                        }
                        else
                        {
                            if($file[Globals::FLD_NAME_TYPE]!=Globals::DEFAULT_VAL_IMAGE_TYPE &&  $file[Globals::FLD_NAME_TYPE]!=Globals::FLD_NAME_VIDEO )
                            {
                                $imgUrl[$file[Globals::FLD_NAME_FILE]] =  Globals::FRONT_USER_VIEW_IMAGE_PATH.$file[Globals::FLD_NAME_FILE];
                            
                            }
                        }
                    }
                    //$imgUrl = array_unique($imgUrl);
                    return $imgUrl;
                }
            }
	}
        public function getTaskAttachmentFiles($json)
	{
            if($json )
            {
                $imgUrl='';
                $jsonArray=CJSON::decode($json);
                if(isset($jsonArray))
                {
                    foreach($jsonArray as $file )
                    {
                       
                        $imgUrl[] = $file[Globals::FLD_NAME_FILE];
                        
                    }
                    //$imgUrl = array_unique($imgUrl);
                    return $imgUrl;
                }
            }
	}
        public function getPortfolioAttachmentFileTypes($json)
	{
            if($json )
            {
                $type='';
                $jsonArray=CJSON::decode($json);
                if(isset($jsonArray))
                {
                    
                        foreach($jsonArray as $file )
                        {
                             $type[] = $file[Globals::FLD_NAME_TYPE];
                        }
                    
                }
                return $type;
            }
                
        }
        public function getTaskAttachmentURI($id,$file)
        {
            try
            {
                $categoryName = strtolower ( self::getTaskCategoryNameOnUrl($id) );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $task = GetRequest::getTaskById($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($task)
            {
               $taskType =  strtolower( $task[0]->{Globals::FLD_NAME_TASK_KIND});
               $taskTitle =  strtolower($task[0]->{Globals::FLD_NAME_TITLE});
               $taskTitle = str_replace(" ","-",$taskTitle);
               $taskTitle = str_replace("/","-",$taskTitle);
            }
            
            return Globals::FRONT_USER_TASK_URI.$taskType."/".$categoryName."/".$taskTitle."/".$id."/".$file;
        }
        public function getProposalAttachmentURI($id,$file)
        {
            try
            {
                $taskTasker = GetRequest::getProposalById($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $task = GetRequest::getTaskById($taskTasker[Globals::FLD_NAME_TASK_ID]);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $categoryName = strtolower ( self::getTaskCategoryNameOnUrl($taskTasker[Globals::FLD_NAME_TASK_ID]));
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            
            
            if($task)
            {
               $taskType =  strtolower( $task[0]->{Globals::FLD_NAME_TASK_KIND});
               $taskTitle =  strtolower($task[0]->{Globals::FLD_NAME_TITLE});
               $taskTitle = str_replace(" ","-",$taskTitle);
               $taskTitle = str_replace("/","-",$taskTitle);
            }
            
            return Globals::FRONT_USER_TASK_URI.$taskType."/".$categoryName."/".$taskTitle."/".$taskTasker[Globals::FLD_NAME_TASK_ID]."/".$id."/".$file."/".Globals::DEFAULT_VAL_TASK_PROPOSAL_IMAGE_URL_SLUG;
        }
        public function getprofilePicMediaURI($id)
        {
            try
            {
                $username = CommonUtility::getImageNameOnUrl($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return Globals::FRONT_USER_PIC_MEDIA_URL.$id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
        }
        public function getThumbnailMediaURI($id,$size=Globals::IMAGE_THUMBNAIL_DEFAULT)
        {
            try
            {
                $username = CommonUtility::getImageNameOnUrl($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return Globals::FRONT_USER_SMALLPIC_MEDIA_URL.$size.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
        }
        
        public function getUserNameOnUrl($id)
        {
            $model=User::model()->findByPk($id);
            $userContact=UserContact::model()->findByAttributes(array(Globals::FLD_NAME_USER_ID=>$id,Globals::FLD_NAME_CONTACT_TYPE=>Globals::DEFAULT_VAL_E_CAP));
            //print_r($userContact);exit;
            if(isset($model))
            {
                if(isset($model->{Globals::FLD_NAME_FIRSTNAME}) && $model->{Globals::FLD_NAME_FIRSTNAME}!=Globals::DEFAULT_VAL_NULL)
                {
                    return $username = $model->{Globals::FLD_NAME_FIRSTNAME}."-".$model->{Globals::FLD_NAME_LASTNAME}; 
                }
                else 
                {
                    return $username = strstr($userContact[Globals::FLD_NAME_CONTACT_ID], Globals::DEFAULT_VAL_ATTHERATE, true); 
                }
            }
        }
        
        public function getTaskerProfileURI($id)
        {
            try
            {
                $username = CommonUtility::getUserNameOnUrl($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return Globals::FRONT_TASKER_PROFILE_URI.$id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
        }
        public function getVideoMediaURI($id)
        {
            try
            {
                $username = CommonUtility::getImageNameOnUrl($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return Globals::FRONT_USER_VIDEO_MEDIA_URL.$id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
        }
        public function getLoginUserName($id)
        {
           $model=User::model()->findByPk($id);
            $userContact=UserContact::model()->findByAttributes(array(Globals::FLD_NAME_USER_ID=>$id,Globals::FLD_NAME_CONTACT_TYPE=>Globals::DEFAULT_VAL_E_CAP));
            if(isset($model))
            {
                if(isset($model->{Globals::FLD_NAME_FIRSTNAME}) && $model->{Globals::FLD_NAME_FIRSTNAME}!=Globals::DEFAULT_VAL_NULL)
                {
                    $userfullname = ucfirst($model->{Globals::FLD_NAME_FIRSTNAME})." ".ucfirst($model->{Globals::FLD_NAME_LASTNAME}); 
                    if(strlen($userfullname) > Globals::DEFAULT_USER_LOGIN_NAME_LENGTH)
                        return $username = ucfirst($model->{Globals::FLD_NAME_FIRSTNAME});
                    else if(strlen($model->{Globals::FLD_NAME_FIRSTNAME})>Globals::DEFAULT_USER_LOGIN_NAME_LENGTH)
                    {
                        $userShortName = commonUtility::truncateText($model->{Globals::FLD_NAME_FIRSTNAME},Globals::DEFAULT_USER_LOGIN_NAME_LENGTH);
                        return $username = $userShortName."...";
                    }
                    else
                        return $username =  ucfirst($model->{Globals::FLD_NAME_FIRSTNAME})." ".ucfirst($model->{Globals::FLD_NAME_LASTNAME}); 
                }
                else 
                {
                    //return $username = $userContact->contact_id; 
                   return $username = strstr($userContact[Globals::FLD_NAME_CONTACT_ID], Globals::DEFAULT_VAL_ATTHERATE, true);
                }
            }
        }
        public function getImageNameOnUrl($id)
        {
            $model=User::model()->findByPk($id);
            $userContact=UserContact::model()->findByAttributes(array(Globals::FLD_NAME_USER_ID=>$id,Globals::FLD_NAME_CONTACT_TYPE=>Globals::DEFAULT_VAL_E_CAP));
            if(isset($model))
            {
                if(isset($model->{Globals::FLD_NAME_FIRSTNAME}) && $model->{Globals::FLD_NAME_FIRSTNAME}!=Globals::DEFAULT_VAL_NULL)
                {
                    return $username = $model->{Globals::FLD_NAME_FIRSTNAME}."-".$model->{Globals::FLD_NAME_LASTNAME}; 
                }
                else 
                {
                    return $username = strstr($userContact[Globals::FLD_NAME_CONTACT_ID], Globals::DEFAULT_VAL_ATTHERATE, true); 
                }
            }
        }
        public function getTaskNameOnUrl($id)
        {
            $model=Task::model()->findByPk($id);
            //$userContact=UserContact::model()->findByAttributes(array(Globals::FLD_NAME_USER_ID=>$id,'contact_type'=>'E'));
            if(isset($model))
            {
                $taskTitle = str_replace(" ", "-", $model->{Globals::FLD_NAME_TITLE});
                $taskTitle = str_replace("/", "-", $taskTitle);
                $taskTitle = str_replace("---", "-", $taskTitle);
                
                return strtolower($taskTitle);
            }
        }
        public function getTaskName($id)
        {
            $model=Task::model()->findByPk($id);
            //$userContact=UserContact::model()->findByAttributes(array(Globals::FLD_NAME_USER_ID=>$id,'contact_type'=>'E'));
            if(isset($model))
            {
                return ucwords(strtolower($model->{Globals::FLD_NAME_TITLE}));
            }
        }
        public function getCategoryNameOnUrl($id)
        {
            $model = CategoryLocale::model()->findByAttributes(array(Globals::FLD_NAME_CATEGORY_ID =>$id));
            if(isset($model))
            {
                $categoryName = str_replace(" ", "-", $model->{Globals::FLD_NAME_CATEGORY_NAME});
                $categoryName = str_replace("/", "-", $categoryName);
                $categoryName = str_replace("---", "-", $categoryName);
                 $name = $model->{Globals::FLD_NAME_CATEGORY_ID}."-".$categoryName;
                return $name = strtolower($name);
            }
        }
        public function getCategoryName($id)
        {
            $model = CategoryLocale::model()->findByAttributes(array(Globals::FLD_NAME_CATEGORY_ID =>$id));
            if(isset($model))
            {
                $name = $model->{Globals::FLD_NAME_CATEGORY_NAME};
              
                return $name = ucfirst($name);
            }
        }
        public function getUserFullName($id , $fullName = false)
        {
            $model=User::model()->findByPk($id);
            $userContact=UserContact::model()->findByAttributes(array(Globals::FLD_NAME_USER_ID=>$id,Globals::FLD_NAME_CONTACT_TYPE=>Globals::DEFAULT_VAL_E_CAP));
            if(isset($model))
            {
                if(isset($model->{Globals::FLD_NAME_FIRSTNAME}) && $model->{Globals::FLD_NAME_FIRSTNAME}!=Globals::DEFAULT_VAL_NULL)
                {
                    if($fullName == false)
                    {
                        $lastnameOneCor = substr($model->{Globals::FLD_NAME_LASTNAME}, 0,1);   
                    }
                    else
                    {
                        $lastnameOneCor = $model->{Globals::FLD_NAME_LASTNAME};
                    }
                    return $username = ucfirst($model->{Globals::FLD_NAME_FIRSTNAME})." ".ucfirst($lastnameOneCor); 
                }
                else 
                {
                    //return $username = $userContact->contact_id; 
                   $username = strstr($userContact[Globals::FLD_NAME_CONTACT_ID], Globals::DEFAULT_VAL_ATTHERATE, true);
                   return $username = ucfirst($username);
                }
            }
        }
         public function getUsersNameByMultipleIds($ids , $fullName = false)
        {
//             $names = '';
//             if($ids)
//             {
//                 $ids = explode(',', $ids);
//                 
//                 foreach( $ids as $id)
//                 {
//                     
//                    $names .=  self::getUserFullName($id , $fullName);
//                    if(count)
//                    {
//                         $names .= ',';
//                    }
//                 }
//             }
//             return $names;
             return '';
            
        }
        public function getUserPhoneNumber($id)
        {
            $model=User::model()->findByPk($id);
            $contactNotFound =  ""; 
            if(isset($model))
            {
                if(isset($model->{Globals::FLD_NAME_CONTACT_INFO}))
                {
                    $jsonArray=CJSON::decode($model->{Globals::FLD_NAME_CONTACT_INFO});
                    if(isset($jsonArray))
                    {
                        
                        if(isset($jsonArray[Globals::FLD_NAME_PHS]))
                        
                        {
                            foreach( $jsonArray[Globals::FLD_NAME_PHS] as $phone)
                            {
                                if($phone[Globals::FLD_NAME_TYPE]==Globals::DEFAULT_VAL_P)
                                {
                                    return $phone[Globals::DEFAULT_VAL_P];
                                }
                            }
                        }
                    }
                }
                return $contactNotFound;
                
            }
        }
        public function getUserDescription($id)
        {
            $model=User::model()->findByPk($id);
            $descriptionNotFound =  ""; 
            if(isset($model))
            {
                if(isset($model->{Globals::FLD_NAME_ABOUT_ME}))
                {
                    $jsonArray=CJSON::decode($model->{Globals::FLD_NAME_ABOUT_ME});
                    if(isset($jsonArray))
                    {
                        
                        if(isset($jsonArray[Globals::FLD_NAME_ABOUTME]))
                        {
                           return $jsonArray[Globals::FLD_NAME_ABOUTME];
                        }
                    }
                }
                return $descriptionNotFound;
                
            }
        }
        public function getUserWorkPreferences($id)
        {
            $model=User::model()->findByPk($id);
            $found =  ""; 
            if(isset($model))
            {
                if(isset($model->{Globals::FLD_NAME_PREFERECES_SETTING}))
                {
                    $jsonArray=CJSON::decode($model->{Globals::FLD_NAME_PREFERECES_SETTING});
                    if(isset($jsonArray))
                    {
                        if(isset($jsonArray[Globals::FLD_NAME_WORK_HRS]))
                        {
                            return $jsonArray[Globals::FLD_NAME_WORK_HRS];
                        }
                    }
                }
                return $found;
            }
        }
        
        public function getUserEmail($id)
        {
            $contactNotFound =  ""; 
            $userContact=UserContact::model()->findByAttributes(array(Globals::FLD_NAME_USER_ID=>$id,Globals::FLD_NAME_CONTACT_TYPE=>Globals::DEFAULT_VAL_E_CAP));
            if(isset($userContact))
            {
                    return $username = $userContact->{Globals::FLD_NAME_CONTACT_ID}; 
            }
            return $contactNotFound;
        }
 
        public function encrypt($pure_string) 
        {
            $encryption_key = Globals::ENCRYPTION_KEY;
            $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC),MCRYPT_DEV_URANDOM);
            $encrypted = base64_encode($iv . mcrypt_encrypt(MCRYPT_RIJNDAEL_256,hash(Globals::DEFAULT_VAL_SHA_256, $encryption_key, true),$pure_string,MCRYPT_MODE_CBC,$iv));
            return $encrypted ;
        }

        /**
         * Returns decrypted original string
         */
        public function decrypt($encrypted_string ) 
        {
            $encryption_key = Globals::ENCRYPTION_KEY;
            $data = base64_decode($encrypted_string);
            $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
            $decrypted =   rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256,hash(Globals::DEFAULT_VAL_SHA_256, $encryption_key, true),substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)),
                            MCRYPT_MODE_CBC,$iv),"\0");
            return $decrypted;
        }
        
        public function createThumbnailImage($size,$imageFile , $imagePath = '') 
        {
            
            //empty($imagePath) ? Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR : $imagePath;
            if(empty($imagePath)) $imagePath = Globals::FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR;
            $size = self::getImageThumbnailSize($size); // to get image size to create thumbnail
            
            $imageInfo = explode('.', $imageFile);
            $image = str_replace(Globals::FRONT_USER_USER_IMAGE_NAME_SLUG, Globals::DEFAULT_VAL_NULL, $imageInfo[0]);
            $ext = $imageInfo[1];
            $imageFullName =$image."_".$size.".".$ext;
            $sizes = explode(Globals::DEFAULT_VAL_IMAGE_DIMENSION_SEPRATOR, $size);
            $thumb = new Thumbnailphoto( $imagePath.$imageFile);
            $thumb->size($sizes[0],$sizes[1]);
            $thumb->process();
            $imageStatus = $thumb->save( $imagePath.$imageFullName);
            if($imageStatus)
            {
                return $imageFullName;
            }
            
        }
        public function getImageThumbnailSize($size) 
        {
            $imagsSizes = Globals::getThumbnailImageSizes();
            $keySize = str_replace(Globals::DEFAULT_VAL_IMAGE_DIMENSION_SEPRATOR, '', $size);
            if($imagsSizes)
            {
                foreach( $imagsSizes as $imgsize)
                {
                    $newSizes = str_replace(Globals::DEFAULT_VAL_IMAGE_DIMENSION_SEPRATOR, '', $imgsize);
                    if( $newSizes > $keySize )
                    {
                        $sizeToCreate = $imgsize;
                         break;
                    }

                }
                if(!isset($sizeToCreate))
                {
                    $sizeToCreate = end($imagsSizes);
                }
                $size = $sizeToCreate;
            }
           
           return $size;
        }
        
        public function unlinkImages($path,$midFolder,$image) 
        {
            if($image)
            {
                $files = scandir($path.$midFolder);
                if($files)
                {
                    foreach ($files as $file)
                    {
                        $imageInfo = explode('.', $image);
                        $imageName = str_replace(Globals::FRONT_USER_USER_IMAGE_NAME_SLUG, Globals::DEFAULT_VAL_NULL, $imageInfo[0]);
                        if( $imageName )
                        {
                            if ( strpos($midFolder.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$file, $imageName) !== false )
                            {
                            // Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$midFolder.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$file;
                                @unlink(Globals::FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH.$midFolder.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$file);
                            }
                        }
                    }
                }
            }
        }
        public function getConfirmTaskURI($tackId)
        {
            try
            {
                $username = CommonUtility::getTaskNameOnUrl($tackId);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return Globals::FRONT_USER_CONFIRM_TASK_URL.$tackId.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
        }
        public function getCategoryImageURI($id)
        {
            try
            {
                $username = CommonUtility::getCategoryNameOnUrl($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return Globals::CATEGORY_IMAGE_URI.$id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
        }
        public function getCategoryThumbnailImageURI($id,$size)
        {
            try
            {
                $username = CommonUtility::getCategoryNameOnUrl($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return Globals::CATEGORY_IMAGE_URI.$size.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
        }
        public function getTaskImageURI($id)
        {
            try
            {
                $username = CommonUtility::getTaskNameOnUrl($id);
                
                ///
                $model=Task::model()->findByPk($id);
                $taskCategory = TaskCategory::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$id));
                
                if(!empty($model->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                {
                    $imagePath = Globals::TASK_IMAGE_URI.$id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
                }
                else 
                {
                    try
                    {
                        $imagePath = self::getCategoryImageURI($taskCategory->{Globals::FLD_NAME_CATEGORY_ID});
                       
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                }
            ////
            
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $imagePath;
                
                
                //
//            }
//            catch(Exception $e)
//            {             
//                $msg = $e->getMessage();
//                CommonUtility::catchErrorMsg( $msg  );
//            }
//            return Globals::TASK_IMAGE_URI.$id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
        }
        
        public function getTaskThumbnailImageURI($id,$size)
        {
            $imagePath = "";
            try
            {
                $username = CommonUtility::getTaskNameOnUrl($id);
               //// 
                $model=Task::model()->findByPk($id);
                $taskCategory = TaskCategory::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$id));
                
                if(!empty($model->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                {
                    $imagePath = Globals::TASK_IMAGE_URI.$size.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$id.Yii::app()->params[Globals::FLD_NAME_PATHSEPARATOR].$username;
                }
                else 
                {
                    try
                    {
                        $imagePath = self::getCategoryImageURI($taskCategory->{Globals::FLD_NAME_CATEGORY_ID});
                       
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                }
            ////
            
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $imagePath;
        }
    //// Mukul's code End////
	
	//// Gajendra's////
	public function setFlashMsg($class,$msg)
	{
		// Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You successfully read this important alert message.');
		echo '<div class="'.$class.'">'.$msg.'</div>';
	}
	//// Gajendra's code End////
	
	public function IsDebugEnabled()
	{
		if (YII_DEBUG==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function IsTraceEnabled()
	{
		if (YII_TRACE_LEVEL>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
   
   public static function IsProfilingEnabled()
	{
		if (YII_PROFILE == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
   
    public function getFileDispOptions($ext, $isFileName = false){
      if(!ext){
         return false;
      }
      if($isFileName){
         $ext = pathinfo($ext, PATHINFO_EXTENSION);
      }
      $files = Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS];
      $extensions = array_keys($files);
      if(in_array($ext, $extensions)){
         return $files[$ext];
      }
      return false;
    }
    public function agoTiming($date)
    {
        $time = strtotime($date);
        $time = time() - $time; // to get the time since that moment

        $tokens = array (
            31536000 => Globals::DEFAULT_VAL_YEAR,
            2592000 => Globals::DEFAULT_VAL_MONTH,
            604800 => Globals::DEFAULT_VAL_WEEK,
            86400 => Globals::DEFAULT_VAL_DAY,
            3600 => Globals::DEFAULT_VAL_HOUR,
            60 => Globals::DEFAULT_VAL_MINUTE,
            1 => Globals::DEFAULT_VAL_SECOND
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }
    public function leftTiming_OLD($date)
    {
        $finishedOn = strtotime($date);
        $now = time();
        $timeleft = $finishedOn-$now;
        $daysleft = round((($timeleft/24)/60)/60); //probably...
        return $daysleft;

    }
    public function leftTiming($date)
    {
            $today = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);

            $diff = abs(strtotime($date) - strtotime($today));

            $daysleft['y'] = floor($diff / (365*60*60*24));
            $daysleft['m'] = floor(($diff - $daysleft['y'] * 365*60*60*24) / (30*60*60*24));
            $daysleft['d'] = floor(($diff - $daysleft['y'] * 365*60*60*24 - $daysleft['m']*30*60*60*24)/ (60*60*24));
           // $daysleft['time']  =  self::timeleft( $date ) ;
        return $daysleft;

    }
    
    
    public function leftTimingInstant($time)
    {
        $time = substr($time, 0, 2) . ':' . substr($time, 2);
        $start = time();
        $stop = strtotime($time);
        $diff = ($stop - $start);
        $diff/60; //Echoes 65 min
        return round($diff,  Globals::DEFAULT_VAL_NUMBER_ROUND);
    }
    
    public function timeleft( $endtime=null) 
   {
        $startdate= time();
        $enddate= $endtime ;

        $diff=strtotime($enddate)-$startdate;

        // immediately convert to days
        $temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day

        // days
        $days=floor($temp);  $temp=24*($temp-$days);
        // hours
        $hours=floor($temp);  $temp=60*($temp-$hours);
        // minutes
        $minutes=floor($temp);  $temp=60*($temp-$minutes);
        // seconds
        $seconds=floor($temp); 
        $left[Globals::DEFAULT_VAL_DATE_FORMATE_D] = $days;
        $left[Globals::DEFAULT_VAL_DATE_FORMATE_H] = $hours;
        $left[Globals::DEFAULT_VAL_DATE_FORMATE_M] = $minutes;
        $left[Globals::DEFAULT_VAL_DATE_FORMATE_S] = $seconds;

        return $left;

}
    public function getPublicDetail($flag)
    {
        if($flag==1)
        {
            return Yii::t('commonutlity','public_all_text');
        }
        elseif($flag==0)
        {
            return Yii::t('commonutlity','public_invited_text');
        }
        else
        {
            return "-";
        }
    }
    
    
    public function getExtension($fileName)
    {
         $file = explode(".", strtolower($fileName));
         return $file[1];
    }
    public function getFileType($extension)
    {
        $getTypeArray = Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS];
         return $getTypeArray[$extension][Globals::FLD_NAME_TYPE];
    }
    public  function getSelectedSkills($task_id)
    {
        $taskSelected = '';
        if(isset($task_id))
        {
            try
            {
                $selectedSkills = TaskSkill::getTaskSkills($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($selectedSkills)
            {
                foreach ($selectedSkills as $selected)
                {
                   $taskSelected[] = $selected->skill_id;
                }
                
            }
        }
       
        return $taskSelected;
    }
    
    public function getUserSelectedSkills($user_id)
    {
        $userSelected = '';
        if(isset($user_id))
        {
            try
            {
                $selectedSkills = UserSpeciality::getUserSkills($user_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($selectedSkills)
            {
                foreach ($selectedSkills as $selected)
                {
                   $userSelected[] = $selected->skill_id;
                }
                
            }
        }
       
        return $userSelected;
    }
	
	public function getUserSelectedCountryList($user_id)
	{
		$userSelected = '';
        if(isset($user_id))
        {
            try
            {
                $selectedLocations = UserWorkLocation::getUserLocation($user_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
			//print_r($selectedLocations);exit;
            if($selectedLocations)
            {
                foreach ($selectedLocations as $selected)
                {
                   $userSelected[] = $selected;
                }
                return  $userSelected;
            }
        }
       
        return $userSelected;
	}
        
    public function getUserWorkLocations($user_id)
    {
        $userSelected = '';
        if(isset($user_id))
        {
            try
            {
                $selectedLocations = UserWorkLocation::getUserLocationName($user_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            $count = 0;
            if(!empty($selectedLocations))
            {
                foreach ($selectedLocations as $selected)
                {
                    if($count == count($selectedLocations))
                    {
                           $userSelected .= "".$selected." ";
                    }
                    else 
                    {
                       $userSelected .= "".$selected.", ";
                    }
                    $count++;
                }
            }
            return substr($userSelected, 0, -2);
        }
    }
     public function getUserCurrentWorkLocations($user_id)
    {
        $location  = '';
        if(isset($user_id))
        {
            try
            {
                $user = User::model()->findByPk($user_id);
                if($user)
                {
                    if($user->{Globals::FLD_NAME_BILLADDR_CITY_ID})
                    {
                       $city =  City::model()->with('citylocale')->findByPk($user->{Globals::FLD_NAME_BILLADDR_CITY_ID});
                       $location = $city->citylocale->{Globals::FLD_NAME_CITY_NAME};
                    }
                    else if($user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE})
                    {
                       $country =  Country::model()->with('countrylocale')->findByPk($user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE});
                       $location = $country->countrylocale->{Globals::FLD_NAME_COUNTRY_NAME};
                    }
                }
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            
        }
        return $location;
    }
   /*     
    public function getSelectedLocations($task_id)
    {
        $taskSelectedLocations = '';
        $is_location_region = '';
        $returnData='';
        if(isset($task_id))
        {
            $selected = TaskLocation::getTaskLocations($task_id);
            if($selected)
            {
                foreach ($selected as $select)
                {
                    if($select->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_C)
                    {
                        $taskSelectedLocations[] = $select->{Globals::FLD_NAME_COUNTRY_CODE};
                    }
                    elseif($select->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_R)
                    {
                        $taskSelectedLocations[] = $select->{Globals::FLD_NAME_REGION_ID};
                    }
                    $is_location_region = $select->{Globals::FLD_NAME_IS_LOCATION_REGION};
                   
                }
                $returnData[Globals::FLD_NAME_IS_LOCATION_REGION]= $is_location_region;
                $returnData[Globals::FLD_NAME_LOCATIONS]= $taskSelectedLocations;
            }
        }
        
        
        
        return $returnData;
    }
    */
    public function getTaskPreferredLocations($task_id)
    {
        $taskPreferredLocations = '';
        $is_location_region = '';
        $returnData='';
        if(isset($task_id))
        {
            try
            {
                $selected = TaskLocation::getTaskLocations($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($selected)
            {
                foreach ($selected as $select)
                {
                    if($select->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_C)
                    {
                        $taskPreferredLocations[] = $select->{Globals::FLD_NAME_COUNTRY_CODE};
                    }
                    elseif($select->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_R)
                    {
                        $taskPreferredLocations[] = $select->{Globals::FLD_NAME_REGION_ID};
                    }
                    $is_location_region = $select->{Globals::FLD_NAME_IS_LOCATION_REGION};
                   
                }
                $returnData[Globals::FLD_NAME_IS_LOCATION_REGION]= $is_location_region;
                $returnData[Globals::FLD_NAME_LOCATIONS]= $taskPreferredLocations;
            }
        }
        return $returnData;
    }
    
    public function getSelectedLocationsToView($task_id)
    {
        $taskSelectedLocations = '';
        $is_location_region = '';
        $returnData='';
        if(isset($task_id))
        {
            try
            {
                $selected = TaskLocation::getTaskLocations($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($selected)
            {
                foreach ($selected as $select)
                {
                    if($select->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_C)
                    {
                        $taskSelectedLocations[] = $select->countrylocale->{Globals::FLD_NAME_COUNTRY_NAME};
                    }
                    elseif($select->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_R)
                    {
                        $taskSelectedLocations[] = $select->regionlocale->{Globals::FLD_NAME_REGION_NAME};
                    }
                    $is_location_region = $select->{Globals::FLD_NAME_IS_LOCATION_REGION};
                   
                }
                $returnData[Globals::FLD_NAME_IS_LOCATION_REGION]= $is_location_region;
                $returnData[Globals::FLD_NAME_LOCATIONS]= $taskSelectedLocations;
            }
        }
        
        
        
        return $returnData;
    }
    public function getRegionsList()
    {
       
        $returnData=array();
        try
        {
            $region = Region::getRegionList();
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if($region)
        {
            $data=CHtml::listData($region,Globals::FLD_NAME_REGION_ID,'regionlocale.region_name');
            foreach($data as $region_id=>$region_name)
            {
                $returnData[$region_id] = $region_name;
            }
        }
        return $returnData;
    }
     public function getCountryList()
    {
       
        $returnData='';
        /*if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('getCountryList_2','getRequest-getCountryList--withoutcache');
        }
        $countries = Country::getCountryList();
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('getCountryList_2');
        }
        
        
        
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('getCountryList','getRequest-getCountryList-cachetest');
        }
            //GetRequest::getCountryList();
            $countries = Country::getCountryListWithCache();
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('getCountryList');
        }
        
        
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile('getCountryList3','getRequest-getCountryList-Indirect____cachetest');
        }
            GetRequest::getCountryList();
            //$countries = Country::getCountryListWithCache();
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::endProfile('getCountryList3');
        }
        */
        //$countries = GetRequest::getCountryListWithoutCache();
        try
        {
            $countries = Country::getCountryList();
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        $data=CHtml::listData($countries,Globals::FLD_NAME_COUNTRY_CODE,'countrylocale.country_name');
		//$i=0;
         foreach($data as $country_code=>$country_name)
        {
            $returnData[$country_code] = $country_name;
        }
        return $returnData;
    }
	
	
	/* public function getCountryListForProfile)
    {
       
        $returnData='';
        $countries = Country::getCountryList();
        $data=CHtml::listData($countries,Globals::FLD_NAME_COUNTRY_CODE,'countrylocale.country_name');
		//$i=0;
         foreach($data as $country_code=>$country_name)
        {
            $returnData[$country_code] = $country_name;
        }
        return $returnData;
    }*/
    public function getSelectedQuestion($task_id)
    {
        $taskSelectedQuestion = '';
        if(isset($task_id))
        {
            try
            {
                $selectedQuestion = TaskQuestion::getTaskQuestion($task_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($selectedQuestion)
            {
                foreach ($selectedQuestion as $selected)
                {
                   $taskSelectedQuestion[] = $selected->{Globals::FLD_NAME_QUESTION_ID};
                }
                
            }
        }
        
        return $taskSelectedQuestion;
    }
    public function getLocationDropdownData($preferred_location)
    {
           $list = array();
            if($preferred_location == Globals::DEFAULT_VAL_R)
            {
                try
                {
                    $region = Region::getRegionList();
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                $data=CHtml::listData($region,Globals::FLD_NAME_COUNTRY_CODE,'regionlocale.region_name');
                $list[""] = Yii::t('commonutlity','select_region_text');
                if($data)
                {
                    foreach($data as $region_id=>$region_name)
                    {
                        $list[$region_id] =  $region_name;
                    }
                }
            }
            elseif ($preferred_location == Globals::DEFAULT_VAL_C) 
            {
                try
                {
                   $country = Country::getCountryList();
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                $data=CHtml::listData($country,Globals::FLD_NAME_COUNTRY_CODE,'countrylocale.country_name');
                $list[""] = Yii::t('commonutlity','select_country_text');
                if($data)
                {
                    foreach($data as $country_code=>$country_name)
                    {
                        $list[$country_code] =  $country_name;
                        
                    }
                }
            }
            return $list;
    }
    public function getCategoryImageUrl($categoryImage,$size=Globals::DEFAULT_VAL_NULL)//size : 80x80
	{
                if($categoryImage)
                {
                    $imagePath = Globals::CATEGORY_IMAGE_BASE_PATH.$categoryImage;
                    if($size!=Globals::DEFAULT_VAL_NULL)
                    {
                        $imageInfo = explode('.', $categoryImage);
                        $image = str_replace(Globals::FRONT_USER_USER_IMAGE_NAME_SLUG, Globals::DEFAULT_VAL_NULL, $imageInfo[0]);
                        $ext = $imageInfo[1];
                        $imageFullName =$image."_".$size.".".$ext;
                        if (file_exists(Globals::CATEGORY_IMAGE_BASE_PATH.$imageFullName)) 
                        {
                           return Globals::CATEGORY_IMAGE_VIEW_PATH.$imageFullName;
                        } 
                        else
                        {
                            $imagestatus = self::createThumbnailImage($size , $categoryImage , Globals::CATEGORY_IMAGE_BASE_PATH );
//                            $sizes = explode(Globals::DEFAULT_VAL_IMAGE_DIMENSION_SEPRATOR, $size);
//                            $thumb=new Thumbnailphoto(Globals::FRONT_USER_MEDIA_CATEGORY_BASE_PATH_BY_ROOTDIR.$categoryImage);
//                            $thumb->size($sizes[0],$sizes[1]);
//                            $thumb->process();
//                            $status=$thumb->save(Globals::FRONT_USER_MEDIA_CATEGORY_BASE_PATH_BY_ROOTDIR.$imageFullName);
                            if($imagestatus)
                            {
                              return Globals::CATEGORY_IMAGE_VIEW_PATH.$imagestatus;
                            }
                        }
                    }
                    else
                    {
                        return Globals::CATEGORY_IMAGE_VIEW_PATH.$categoryImage;
                    }
                }
//                else
//                {
//                   //return CommonUtility::getCategoryImageUrl(Globals::IMAGE_CATEGORY_AVATAR,$size);
//                }
                 
            
        }
       public function getDEFAULTImageUrl($imageDEFAULT,$size=Globals::DEFAULT_VAL_NULL,$path)//size : 80x80
	{
                if($imageDEFAULT)
                {
                    $imagePath = $path.$imageDEFAULT;
                    if($size != Globals::DEFAULT_VAL_NULL)
                    {
                        $imageInfo = explode('.', $imageDEFAULT);
                        $image = str_replace(Globals::FRONT_USER_USER_IMAGE_NAME_SLUG, Globals::DEFAULT_VAL_NULL, $imageInfo[0]);
                        $ext = $imageInfo[1];
                        $imageFullName =$image."_".$size.".".$ext;
                        if (file_exists($path.$imageFullName)) 
                        {
                           return $path.$imageFullName;
                        } 
                        else
                        {
                            
                            $sizes = explode(Globals::DEFAULT_VAL_IMAGE_DIMENSION_SEPRATOR, $size);
                            $thumb=new Thumbnailphoto("..".$path.$imageDEFAULT);
                            $thumb->size($sizes[0],$sizes[1]);
                            $thumb->process();
                            $status=$thumb->save("..".$path.$imageFullName);
                            if($status)
                            {
                              return $path.$imageFullName;
                            }
                        }
                    }
                    else
                    {
                        return $path.$imageDEFAULT;
                    }
                }
            
        } 
        
        public function getTaskImageURL($task_id,$size='')
	{
            $model=Task::model()->findByPk($task_id);
            $taskCategory = TaskCategory::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID =>$task_id));
            $imagePath = "";
            if(!empty($model->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
            {
                try
                {
                    $attachment =  self::getPortfolioAttachmentUrlFromJson($model->{Globals::FLD_NAME_TASK_ATTACHMENTS},Globals::DEFAULT_VAL_IMAGE_TYPE,$size);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                if($attachment)
                {
                    foreach ($attachment as $image) 
                    {
                        $takeimage = $image;
                    }
                    $imagePath = $takeimage;
                }
            }
            else if(!empty($taskCategory->{Globals::FLD_NAME_CATEGORY_ID}))
            {
                $category = CategoryLocale::model()->findByAttributes(array(Globals::FLD_NAME_CATEGORY_ID =>$taskCategory->{Globals::FLD_NAME_CATEGORY_ID}));
                try
                {
                    $imagePath = CommonUtility::getCategoryImageUrl($category->{Globals::FLD_NAME_CATEGORY_IMAGE},$size);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
            }
            return $imagePath;
	}
       public function getTaskAttachmentURL($task_id,$fileName)
	{
            $model=Task::model()->findByPk($task_id);
            $path = "";
            $files ='';
            if(!empty($model->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
            {
                try
                {
                    $attachment =  self::getTaskAttachmentFiles($model->{Globals::FLD_NAME_TASK_ATTACHMENTS});
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                if($attachment)
                {
                    foreach ($attachment as $image) 
                    {
                        $names = explode('/', $image);
                        if($fileName == $names[1] )
                        {
                            $files  = Globals::FRONT_USER_VIEW_IMAGE_PATH.$image;
                        }
                    }
                    $path = $files;
                }
            }
            return $path;
	}
        public function getProposalAttachmentURL($id,$fileName)
	{
            try
            {
                $model = GetRequest::getProposalById($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            $path = "";
            $files ='';
            if(!empty($model->{Globals::FLD_NAME_TASKER_ATTACHMENTS}))
            {
                try
                {
                    $attachment =  self::getTaskAttachmentFiles($model->{Globals::FLD_NAME_TASKER_ATTACHMENTS});
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                if($attachment)
                {
                    foreach ($attachment as $image) 
                    {
                        $names = explode('/', $image);
                        if($fileName == $names[1] )
                        {
                            $files  = Globals::FRONT_USER_VIEW_IMAGE_PATH.$image;
                        }
                    }
                    $path = $files;
                }
            }
            return $path;
	}
        public function getTaskAttachmentImageThumbURL( $task_id , $fileName )
	{
            $model=Task::model()->findByPk($task_id);
          
            $path = "";
            $files ='';
            if(!empty($model->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
            {
                try
                {
                    $attachment =  self::getTaskAttachmentFiles($model->{Globals::FLD_NAME_TASK_ATTACHMENTS});
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                if($attachment)
                {
                    foreach ($attachment as $image) 
                    {
                     
                        $names = explode('/', $image);
                        if($fileName == $names[1] )
                        {
                            $imageInfo = explode('.', $image);
                            $imageNew= str_replace(Globals::FRONT_USER_USER_IMAGE_NAME_SLUG, Globals::DEFAULT_VAL_NULL, $imageInfo[0]);
                            $ext = $imageInfo[1];
                            
                             $imageFullName =$imageNew."_".Globals::IMAGE_THUMBNAIL_DEFAULT.".".$ext;
                            if (file_exists(Globals::FRONT_USER_MEDIA_BASE_PATH.$imageFullName)) 
                            {
                                 $files =  Globals::FRONT_USER_VIEW_IMAGE_PATH.$imageFullName;
                            } 
                            else 
                            {
                                $imagestatus = self::createThumbnailImage( Globals::IMAGE_THUMBNAIL_DEFAULT , $image );
                                if($imagestatus)
                                {
                                   $files  = Globals::FRONT_USER_VIEW_IMAGE_PATH.$imagestatus;
                                }
                               // $files  = Globals::FRONT_USER_VIEW_IMAGE_PATH.$imageFullName;
                            }
                            
                        }
                        
                    }
                    
                    $path = $files;
                }
                
            }
            return $path;
	}
        public function getProposalAttachmentImageThumbURL( $id , $fileName )
	{
            try
            {
                $model = GetRequest::getProposalById($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            //echo $fileName;
            $path = "";
            $files ='';
            if(!empty($model->{Globals::FLD_NAME_TASKER_ATTACHMENTS}))
            {
                try
                {
                    $attachment =  self::getTaskAttachmentFiles($model->{Globals::FLD_NAME_TASKER_ATTACHMENTS});
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                if($attachment)
                {
                    foreach ($attachment as $image) 
                    {
                     
                        $names = explode('/', $image);
                        if($fileName == $names[1] )
                        {
                            //print_r($names);
                            $imageInfo = explode('.', $image);
                            $imageNew = str_replace(Globals::FRONT_USER_USER_IMAGE_NAME_SLUG, Globals::DEFAULT_VAL_NULL, $imageInfo[0]);
                            $ext = $imageInfo[1];
                            $imageFullName = $imageNew."_".Globals::IMAGE_THUMBNAIL_DEFAULT.".".$ext;
                            if (file_exists(Globals::FRONT_USER_MEDIA_BASE_PATH.$imageFullName)) 
                            {
                                echo $files =  Globals::FRONT_USER_VIEW_IMAGE_PATH.$imageFullName;
                            } 
                            else 
                            {
                                $files  = Globals::FRONT_USER_VIEW_IMAGE_PATH.$image;
                            }
                            
                        }
                        
                    }
                    
                    $path = $files;
                }
                
            }
            return $path;
	}
                                        
        public function geologicalPlaces($lat,$lon,$range)
	{
		$range = (float)$range;
                $lat = (float)$lat;
                $lon = (float)$lon;
                $lat_range = $range/69.172;
		$lon_range = abs($range/(cos($lon) * 69.172)); # here we do a little extra for longitude
		$returnData[Globals::FLD_NAME_MIN_LAT] = $lat - $lat_range; # $mile_radius would be 5 for our example, $lat is the fixed latitude for our zip code
		$returnData[Globals::FLD_NAME_MAX_LAT] = $lat + $lat_range;
		$returnData[Globals::FLD_NAME_MIN_LON] = $lon - $lon_range;
		$returnData[Globals::FLD_NAME_MAX_LON] = $lon + $lon_range;
                
		return $returnData;
	}

        public function getAverage($dataProvider)
	{
            $totleTask = count($dataProvider);
            $fixPrice = 0;
            foreach($dataProvider as $data)
            {
//              echo $data->task->{Globals::FLD_NAME_PRICE}.'<br>';
                $fixPrice = $fixPrice+$data->task->{Globals::FLD_NAME_PRICE};
            }
            $avragePrice = $fixPrice/$totleTask;
//            echo $avragePrice;
//            exit();
		return round($avragePrice);
	}
        public function getAddressAndLatLngFromIp()
        {
                $ip = $_SERVER[Globals::REMOTE_ADDR];
                $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
//                print_r($details);
                $data[Globals::FLD_NAME_COUNTRY_CODE] = '';
                $data[Globals::FLD_NAME_STATE_ID] = '';
                $data[Globals::FLD_NAME_REGION_ID] = '';
                $data[Globals::FLD_NAME_CITY_ID] = '';
                $data[Globals::FLD_NAME_LAT] = '0';
                $data[Globals::FLD_NAME_LNG] = '0';
                if($details)
                {
                    if(isset($details->country))
                    {
                        $data[Globals::FLD_NAME_COUNTRY_CODE] = trim($details->country);  
                    }
                    if(isset($details->region))
                    {
                        $data[Globals::FLD_NAME_STATE_ID] = trim($details->region);
                        $data[Globals::FLD_NAME_REGION_ID] = trim($details->region);
                    }
                    if(isset($details->city))
                    {
                        $data[Globals::FLD_NAME_CITY_ID] = trim($details->city); 
                    }
                    if(isset($details->loc))
                    {
                        if($details->loc != '')
                        {
                            $loc = explode(',', $details->loc); 
                            $data[Globals::FLD_NAME_LAT] = trim($loc[0]);
                            $data[Globals::FLD_NAME_LNG] = trim($loc[1]);
                        }
                    }
                }
                return $data;
        }
        public function getYearFromDate($date)
        {
           return $year = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y,  strtotime($date));
        }
        public function getMonthFromDate($date)
        {
           return $month = date(Globals::DEFAULT_VAL_DATE_FORMATE_M,  strtotime($date));
        }
        public function getDayFromDate($date)
        {
           return $day = date(Globals::DEFAULT_VAL_DATE_FORMATE_D,  strtotime($date));
        }
        public function getCurrentDate()
        {
           return $date = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME);
        }
        public function getQuestionAnswerByTasker($task_id, $tasker_id)
        {
            $queAnsewes = Globals::DEFAULT_VAL_NULL;
            try
            {
                $answers = TaskQuestionReply::getQuestionAnswerByTasker($task_id, $tasker_id );
//                echo"<pre>";
//                print_r($answers);
//                exit;
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($answers)
            {
                $i=1;
                foreach($answers as $answer)
                {
                    if($answer->{Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC} != '')
                    {
                        $queAnsewes[$answer->{Globals::FLD_NAME_TASK_QUESTION_ID}] = $answer->{Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC};
                    }
                    elseif($answer->{Globals::FLD_NAME_REPLY_YESNO} != '')
                    {
                        $queAnsewes[$answer->{Globals::FLD_NAME_TASK_QUESTION_ID}] = $answer->{Globals::FLD_NAME_REPLY_YESNO};
                    }
                    $i++;
                }
            }
            return $queAnsewes;
        }
        
        public function getTaskDetailURI($id)
        {
            try
            {
                $categoryName = strtolower (self::getTaskCategoryNameOnUrl($id) );
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            try
            {
                $task = Task::getTaskById($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($task)
            {
               $taskType = Globals::EXTERNAL_TASK_TYPE;
               $taskType =  (strtolower( $task[0]->{Globals::FLD_NAME_TASK_KIND}) === '') ? $taskType : strtolower( $task[0]->{Globals::FLD_NAME_TASK_KIND});
               $taskTitle =  strtolower($task[0]->{Globals::FLD_NAME_TITLE});
               $taskTitle = str_replace(" ","-",$taskTitle);
               $taskTitle = str_replace("/","-",$taskTitle);
               
               //$taskTitle = preg_replace('/\/ /', '-', $taskTitle);                                             
              // $categoryName = str_replace("/","-",$categoryName);

               $categoryName = ($categoryName === 'cat-' ) ? $categoryName.'external' : $categoryName;
               return Globals::FRONT_USER_TASK_URI.$taskType."/".$categoryName."/".$taskTitle."/".$id;
            }
            return true;
            
        }
        public function getTaskCategoryNameOnUrl($id)
        {
            $category_name = '';
            try
            {
                $category = TaskCategory::getTaskCategoryName($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($category)
            {
               $category_name = $category[0]->{Globals::FLD_NAME_CATEGORY_LOCALE_SMALL}->{Globals::FLD_NAME_CATEGORY_NAME};
               $parentId = $category[0]->{Globals::FLD_NAME_CATEGORY_SMALL}->{Globals::FLD_NAME_CATEGORY_PARENT_ID};
               if( $parentId != NULL || $parentId != '' )
               {
                    try
                    {
                        $categoryParent = Category::getCategoryListByID($parentId);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                  if($categoryParent)
                  {
                     $category_name = $parentId."-".$categoryParent[0]->{Globals::FLD_NAME_CATEGORY_LOCALE_SMALL}->{Globals::FLD_NAME_CATEGORY_NAME}."/".Globals::URL_SUBCATEGORY_TYPE_SLUG.$category[0]->{Globals::FLD_NAME_CATEGORY_LOCALE_SMALL}->{Globals::FLD_NAME_CATEGORY_ID}."-".$category_name;
                  }
               }
            }
            $category_name = Globals::URL_CATEGORY_TYPE_SLUG.str_replace(" ","-",$category_name);
            //$category_name = preg_replace('/\/ /', '-', $category_name);
            return $category_name;
        }
         public function getCategoryNameOnUrlById($id)
        {
            $category_name = '';
            try
            {
                $category = Category::getCategoryListByID($id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if($category)
            {
                $category_id = $category[0]->{Globals::FLD_NAME_CATEGORY_LOCALE_SMALL}->{Globals::FLD_NAME_CATEGORY_ID};
                $category_name = $category[0]->{Globals::FLD_NAME_CATEGORY_LOCALE_SMALL}->{Globals::FLD_NAME_CATEGORY_NAME};
                $parentId = $category[0]->{Globals::FLD_NAME_CATEGORY_PARENT_ID};
               if( $parentId != NULL || $parentId != '' )
               {
                    try
                    {
                        $categoryParent = Category::getCategoryListByID($parentId);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                    if($categoryParent)
                    {
                        
                        $category_name = $categoryParent[0]->{Globals::FLD_NAME_CATEGORY_LOCALE_SMALL}->{Globals::FLD_NAME_CATEGORY_ID}."-".$categoryParent[0]->{Globals::FLD_NAME_CATEGORY_LOCALE_SMALL}->{Globals::FLD_NAME_CATEGORY_NAME}."/".Globals::URL_SUBCATEGORY_TYPE_SLUG.$category_id."-".$category_name;
                    }
               }
            }
            $category_name = "/".Globals::URL_CATEGORY_TYPE_SLUG.str_replace(" ","-",$category_name);
            //$category_name = preg_replace('/\/ /', '-', $category_name);
            return $category_name;
        }
        public function getParentCategoryURI($id)
        {
            $category_name = '';
            $taskType = Globals::DEFAULT_VAL_TASK_TYPE;
            $model = CategoryLocale::model()->findByAttributes(array(Globals::FLD_NAME_CATEGORY_ID =>$id));
            if(isset($model))
            {
                $category_name =  $model->category_name;
                $category_name = Globals::URL_CATEGORY_TYPE_SLUG.$id."-".str_replace(" ","-",$category_name);
                $category_name =  strtolower($category_name);
            }
            //return Globals::FRONT_USER_TASK_URI.$taskType."/".$category_name;
            return "/".$category_name;

           
        }
         public function getParentCategoryURL($id , $taskType = '')
        {
            $category_name = '';
            $taskType = empty($taskType) ? Globals::DEFAULT_VAL_TASK_TYPE : $taskType;
           
            $model = CategoryLocale::model()->findByAttributes(array(Globals::FLD_NAME_CATEGORY_ID =>$id));
            if(isset($model))
            {
                $category_name =  $model->category_name;
                $category_name = Globals::URL_CATEGORY_TYPE_SLUG.$id."-".str_replace(" ","-",$category_name);
                $category_name =  strtolower($category_name);
            }
            return Globals::FRONT_USER_TASK_URI.$taskType."/".$category_name;
            //return "/".$category_name;

           
        }
        public function getChildCategoryURL($id , $taskType = '')
        {
            $category_name = '';
            $taskType = empty($taskType) ? Globals::DEFAULT_VAL_TASK_TYPE : $taskType;
           
            $category = CategoryLocale::model()->findByAttributes(array(Globals::FLD_NAME_CATEGORY_ID =>$id));
           
            if($category)
            {
               $category_name = $category->{Globals::FLD_NAME_CATEGORY_NAME};
               $parentId = $category->{Globals::FLD_NAME_CATEGORY_PARENT_ID};
               if( $parentId != NULL || $parentId != '' )
               {
                    try
                    {
                        $categoryParent = Category::getCategoryListByID($parentId);
                    }
                    catch(Exception $e)
                    {             
                        $msg = $e->getMessage();
                        CommonUtility::catchErrorMsg( $msg  );
                    }
                  if($categoryParent)
                  {
                     $category_name = $parentId."-".$categoryParent[0]->{Globals::FLD_NAME_CATEGORY_LOCALE_SMALL}->{Globals::FLD_NAME_CATEGORY_NAME}."/".Globals::URL_SUBCATEGORY_TYPE_SLUG.$category->{Globals::FLD_NAME_CATEGORY_ID}."-".$category_name;
                  }
               }
            }
            $category_name = Globals::URL_CATEGORY_TYPE_SLUG.str_replace(" ","-",$category_name);
            //$category_name = preg_replace('/\/ /', '-', $category_name);
        
            return Globals::FRONT_USER_TASK_URI.$taskType."/".$category_name;
        

           
        }
        public function getChildCategoryURI($id)
        {
            $category_name = '';
            $taskType = Globals::DEFAULT_VAL_TASK_TYPE;
            $model = CategoryLocale::model()->findByAttributes(array(Globals::FLD_NAME_CATEGORY_ID =>$id));
            if(isset($model))
            {
                $category_name =  $model->category_name;
                $category_name = Globals::URL_CATEGORY_TYPE_SLUG.$id."-".str_replace(" ","-",$category_name);
                $category_name =  strtolower($category_name);
            }
            //return Globals::FRONT_USER_TASK_URI.$taskType."/".$category_name;
            return "/".$category_name;

           
        }
        public function getTaskListURI()
        {
            return Globals::FRONT_USER_TASK_URI;
        }
        public function getMyTaskListURI()
        {
            return Globals::FRONT_MY_USER_TASK_URI;
        }
        public function getMyTaskListURIAsDoer()
        {
            return Globals::FRONT_MY_USER_TASK_URI_AS_DOER;
        }
        public function CheckFileType( $fileName )
        {
            if( $fileName)
            {
                $filenames = explode('.', $fileName);
                $extension = $filenames[1];
                $fileTypesArray = Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS];
                if( isset($fileTypesArray[$extension] ))
                {
                    return $fileType = $fileTypesArray[$extension][Globals::FLD_NAME_TYPE];
                }
            }
            return true;
        }
        public function getTaskAttachmentSmallImageURL( $fileUrl)
        {
            return $fileUrl."/".Globals::DEFAULT_VAL_TASK_SMALL_IMAGE_URL_SLUG;
        }
        public function getTaskProposalAttachmentSmallImageURL( $fileUrl)
        {
            return $fileUrl."/".Globals::DEFAULT_VAL_TASK_PROPOSAL_SMALL_IMAGE_URL_SLUG;
        }
		
    public function getUserRoleName($role_ids = '')
    {
        $role_name = '';
        if(isset($role_ids))
        {
            $roles = explode(',', $role_ids);
            if($roles)
            {
                foreach($roles as $role_id)
                {
                    
                    $model = Roles::model()->findByPk($role_id);
                   
                    if($model)
                    {
                        if($role_id == end($roles))
                        $role_name .= $model->role_name.'  ';
                        else
                            $role_name .= $model->role_name.' ,<br/> ';
                    }
                }
            }
        }
            
        echo  $role_name;
    }
    public function getUserSelectedRoles($role_ids = '')
    {
        $roles = '';
        if(isset($role_ids))
        {
            $roles = explode(',', $role_ids);
            
        }
            
        return  $roles;
    }
		
    public function pre($array)
    {
         echo '<pre>';
         print_r($array);
         echo '</pre>';
    }
    public function catchErrorMsg( $msg , $array = '' , $controller = '' , $action = '' )
    {
        $controller = empty($controller) ? Yii::app()->controller->id : $controller ;
        $action = empty($action) ? Yii::app()->controller->action->id  : $action ;
        $exrta = '';
        $showOutput = (isset($array['hideoutput']) && $array['hideoutput']) ? false : true; 
        if( $array )
        { 
         if(isset($array['hideoutput'])){
            unset($array['hideoutput']);
         }
            foreach( $array as $key => $val )
            { 
                $exrta .=  " ".$key ." = ".$val.","; 
            } 
        }
        $exrta .= " User ID = ". Yii::app()->user->id."," ;
        //$exrta .= " URL = ".$_SERVER['HTTP_REFERER'].",";
        
        if (CommonUtility::IsTraceEnabled()) Yii::trace('Executing action'.$action.'() method',$controller."Controller");
        Yii::log( $controller.'.'.$action.':  reason:-'.$msg.' ExtraInfo: '.$exrta ,CLogger::LEVEL_ERROR , $controller."Controller" );
        
        if($showOutput){
            echo  $error = CJSON::encode( array( 'status'=>'error',  'msg'=>$msg )); 
        }
        
    }
    public function getPublicImageUri( $image )
    {
        return Globals::PUBLIC_IMAGE_URI.$image;
    }
	
   /**
    * clear cahce of given key
    */
    public function clearCache($cache_keys)
    {
        if(!empty($cache_keys) && is_string($cache_keys))
        {
            Yii::app()->cache->delete($cache_keys);
        }
        if(!empty($cache_keys) && is_array($cache_keys))
        {
            foreach($cache_keys as $cache_key)
            {
                //print_r(Yii::app()->cache->get($cache_key));
                Yii::app()->cache->delete($cache_key);  
            }
        }
      //exit('cache clear in commonutility');
   }
   
   
   public function updateUserSearchField($userId)
    {
        $model = User::getUserByPk($userId);
        $for_search = $model->firstname.','.$model->lastname.',';
        $totlecountskill = count($model->userspecialityHasMany); 
        if($totlecountskill > 0)
        {
            foreach($model->userspecialityHasMany as $skill)
            {
               $skillData = SkillLocale::model()->find($skill->skill_id);               
               $for_search .= $skillData->skill_desc.',';
            }
        }
        $totlecountlocation = count($model->userworklocationHasMany); 
        if($totlecountlocation > 0)
        {
            foreach($model->userworklocationHasMany as $location)
            {
                if(!empty($location->country_code))
                {                  
                    $locationCountry = CountryLocale::model()->findByAttributes(array('country_code'=>$location->country_code));                    
                    $for_search.= $locationCountry->country_name.",";
                }
                if(!empty($location->state_id))
                {
                    $locationState = StateLocale::model()->findByAttributes(array('state_id'=>$location->state_id));
                   $for_search.= $locationState->state_name.",";
                }
                if(!empty($location->region_id))
                {
                    $locationRegion = RegionLocale::model()->findByAttributes(array('region_id'=>$location->region_id));
                    $for_search.= $locationRegion->region_name.",";
                }
                if(!empty($location->city_id))
                {
                    $locationCity = CityLocale::model()->findByAttributes(array('city_id'=>$location->city_id));
                    $for_search.= $locationCity->city_name.",";
                }
            }
        }        
        $model->for_search = $for_search;                
        if(!$model->Update())
        {                            
           throw new Exception(Yii::t('commonutlity','unexpected_error_update_user_search_field'));
           //  return false;
        }
        
        return true;
    }
   
   
    public function addTaskActivity($task_id , $by_user_id = '', $activity_type , array $otherInfo = array())
    {
        $by_user_id = empty($by_user_id) ? Yii::app()->user->id : $by_user_id ;
        $otherInfo = array_merge(array(
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => '',
                                            Globals::FLD_NAME_COMMENTS => '',
                                            Globals::FLD_NAME_SOURCE_APP => Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB,
                                        ), $otherInfo ); 
        
        $activity = new TaskActivity();
        $activity->{Globals::FLD_NAME_TASK_ID} = $task_id;
        $activity->{Globals::FLD_NAME_BY_USER_ID} = $by_user_id;
        $activity->{Globals::FLD_NAME_ACTIVITY_TYPE} = $activity_type;
        $activity->{Globals::FLD_NAME_ACTIVITY_SUBTYPE} = $otherInfo[Globals::FLD_NAME_ACTIVITY_SUBTYPE];
        $activity->{Globals::FLD_NAME_COMMENTS} = $otherInfo[Globals::FLD_NAME_COMMENTS];
        $activity->{Globals::FLD_NAME_SOURCE_APP} = $otherInfo[Globals::FLD_NAME_SOURCE_APP];
        if(!$activity->save())
        {                            
           throw new Exception(Yii::t('commonutlity','unexpected_error_task_activity'));
           //  return false;
        }
        return true;
    }
     public function addUserActivity( $by_user_id = '', $activity_type , array $otherInfo = array())
    {
        $by_user_id = empty($by_user_id) ? Yii::app()->user->id : $by_user_id ;
        $otherInfo = array_merge(array(
                                            Globals::FLD_NAME_ACTIVITY_SUBTYPE => '',
                                            Globals::FLD_NAME_COMMENTS => '',
                                            Globals::FLD_NAME_SOURCE_APP => Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB,
                                        ), $otherInfo ); 
      
        $activity = new UserActivity();
       
        $activity->{Globals::FLD_NAME_BY_USER_ID} = $by_user_id;
        $activity->{Globals::FLD_NAME_ACTIVITY_TYPE} = $activity_type;
        $activity->{Globals::FLD_NAME_ACTIVITY_SUBTYPE} = $otherInfo[Globals::FLD_NAME_ACTIVITY_SUBTYPE];
        $activity->{Globals::FLD_NAME_COMMENTS} = $otherInfo[Globals::FLD_NAME_COMMENTS];
        $activity->{Globals::FLD_NAME_SOURCE_APP} = $otherInfo[Globals::FLD_NAME_SOURCE_APP];
        if(!$activity->save())
        {                            
           throw new Exception(Yii::t('commonutlity','unexpected_error_user_activity'));
           //  return false;
        }
        return true;
    }
    public  function updateTaskerStatusOnCanceled($teskid)
    {
        $taskerWitchInvOrBideds = TaskTasker::getSelectedTaskerForTaskWichInvitedOrBided($teskid);
        $userSr = 1;
        foreach($taskerWitchInvOrBideds as $taskerWitchInvOrBided)
        {
            $taskTasker[$userSr] = TaskTasker::model()->findByPK($taskerWitchInvOrBided->task_tasker_id);
            $taskTasker[$userSr]->is_cancelled = 1;
            $taskTasker[$userSr]->task_cancel_date = new CDbExpression('NOW()');
            if(!$taskTasker[$userSr]->Update())
            {
                throw new Exception(Yii::t('commonutlity','unexpected_error_user_tasker_task_status_update')); 
            }
            $userSr++;
        }
    }
    public  function addUserAlert( $alert_type , $alert_desc , $for_user_id , $task_tasker_id = '' , $source_app = '' )
    {
        $source_app = empty($source_app) ? Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB : $source_app ;
        $alert = new UserAlert();
        $alert->{Globals::FLD_NAME_ALERT_TYPE} = $alert_type;
        $alert->{Globals::FLD_NAME_ALERT_DESC} = $alert_desc;
        $alert->{Globals::FLD_NAME_FOR_USER_ID} = $for_user_id;
        $alert->{Globals::FLD_NAME_BY_USER_ID} = Yii::app()->user->id;
        $alert->{Globals::FLD_NAME_TASK_TASKER_ID} = $task_tasker_id;
        $alert->{Globals::FLD_NAME_SOURCE_APP} = $source_app;
        if(!$alert->save())
        {   
            throw new Exception(Yii::t('commonutlity','unexpected_error_user_alert'));   
        }
        return true;
    }
    public function sendAlertToAllTaskers( $task_id , $alert_type , $alert_desc )
    {
        try
        {
            $taskers = TaskTasker::getActiveTaskerForTask( $task_id );
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if( $taskers )
        {
            //echo $tasker->{Globals::FLD_NAME_TASKER_ID};
            foreach( $taskers as $tasker)
            {
                try
                {
                    self::addUserAlert( $alert_type , $alert_desc , $tasker->{Globals::FLD_NAME_TASKER_ID} , $tasker->{Globals::FLD_NAME_TASK_TASKER_ID});
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
            }
        }
      //   return true;
        //
    }
    //////trim string turncate
    public function truncateText( $string , $length , $more = true)
    {
        if(strlen($string) > $length )
        {
            $dots = '';
            if( $more == true ) $dots = '...';
            $substring = preg_replace('/\s+?(\S+)?$/', '', substr($string , 0, $length ));
            if (strlen($string) > $length )  $substring =  $substring.$dots;
        }
        else
        {
            $substring = $string;
        }
        
        return $substring;
    }
	
	public function getTaskSkillsIdCommaSeprated($task_id)
	{
		$result =array();
		$model = TaskSkill::model()->findAll(array('condition' => Globals::FLD_NAME_TASK_ID.' ="'.$task_id.'"'));
		if($model)
		{
			$i=0;
			foreach($model as $entry)
			{
				$result[$i] = $entry->{Globals::FLD_NAME_SKILL_ID}.',';
				$i++;
			}
			
			//print_r($result);exit;
			return $result;
		}
	}
        
        
        public function formatedViewDate( $date , $formate = '' )
        {
           $formate = empty( $formate ) ? Globals::DEFAULT_VAL_DATE_FORMATE_D_MMM_Y  : $formate;
            return Yii::app()->dateFormatter->format( $formate ,strtotime( $date ));
        }
        public function formatedViewTime( $date , $formate = '' )
        {
           $formate = empty( $formate ) ? Globals::DEFAULT_VAL_END_TIME_FORMATE_TO_VIEW  : $formate;
            return Yii::app()->dateFormatter->format( $formate ,strtotime( $date ));
        }
        public function intVal( $price )
        {
            return intval($price);
        }
        public function SendMail($to,$subject,$message,$body)
        {
			//echo $to;exit;
            $name = Globals::MAIL_NAME_GREEN_COMET;
            $from = Globals::MAIL_FROM;
            
            $mail = new YiiMailer();
           // $mail->setView('Mail');
            $mail->setData(array(Globals::FLD_NAME_MESSAGE => $message,Globals::FLD_NAME_NAME => $name ));
            $mail->setFrom($from, $name);
            $mail->setReplyTo($from, $name);
            $mail->setTo($to);
            $mail->setSubject($subject);
            $mail->setBody($body);
            $mail->isHTML(true);
            $mail->IsSMTP();
            $mail->SMTPSecure = Globals::MAIL_SMTP_SECURE;
            $mail->Host = Globals::MAIL_HOST;
            $mail->Port = Globals::MAIL_PORT;
            $mail->SMTPAuth = Globals::MAIL_SMTP_AUTH;
            $mail->Username = Globals::MAIL_USER_NAME;
            $mail->Password = Globals::MAIL_PASSWORD;

           // error_reporting(E_ALL);
            try
            {
                $sendmail = $mail->send();
                if($sendmail)
                {
                    return $sendmail;
                }
                else
                {
                    return false;     
                }
            }
            catch(Exception $e)
            {
                CommonUtility::pre($e);
                return false;     
            }
            
        }
        
        public function generateVerificationCode()
        {
            $characters = Globals::DEFAULT_VAL_RANDOM_STRING;
            $length = 10;
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }
        
        public function encrypt_decrypt($action,$string)
        {
            $output = false;
            $key = 'My strong random secret key';
            // initialization vector 
            $iv = md5(md5($key));
            if( $action == 'encrypt' ) 
            {
                $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
                $output = base64_encode($output);
            }
            else if( $action == 'decrypt' )
            {
                $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
                $output = rtrim($output, "");
            }
            return $output;
        }
        public function isTaskStateCancel($task_state)
        {
            $state = true;
            if( $task_state == Globals::DEFAULT_VAL_TASK_STATE_CANCELED )
            {
                $state = false;
            }
            return $state;
        }
        
        public function cancelStatus($task_state)
        {
            $state = true;
            if( $task_state == Globals::DEFAULT_VAL_TASK_STATE_CANCELED )
            {
                $state = false;
            }
            if( $task_state == Globals::DEFAULT_VAL_TASK_STATE_FINISHED )
            {
                $state = false;
            }
            if( $task_state == Globals::DEFAULT_VAL_TASK_STATE_UNDER_SUSPENDED )
            {
                $state = false;
            }
            return $state;
        }              
        public function isFieldAccessByTaskTypeVirtual($task_kind)
        {
            $task_kind;
            $isFieldAccessByTaskTypeVirtual = true;
            if( $task_kind == Globals::DEFAULT_VAL_TASK_KIND_VIRTUAL )
            {
                $isFieldAccessByTaskTypeVirtual = false;
            }
            return $isFieldAccessByTaskTypeVirtual;
        }
        public function displayRating($name , $rating_value)
        {
                $rating = Globals::DEFAULT_VAL_RATING_MULITIPLY*$rating_value;
                $this->widget('CStarRating',array('name'=>$name,
                'starCount'=>Globals::DEFAULT_VAL_STAR_RATING_TYPE,
                'readOnly'=>true,
//                'htmlOptions'=>array('style' => 'margin:0 auto;'),
                //'resetText'=>'',
                'value'=>$rating,
                    
            //  'callback'=>'function(){  $(\'#TaskReference_rank\').val($(this).val()); }',
                ));                                                        
        }
        public function displayOverAllRating($name , $rating_value)
        {
                $rating = Globals::DEFAULT_VAL_RATING_MULITIPLY*$rating_value;
                $this->widget('CStarRating',array('name'=>$name,
                'starCount'=>Globals::DEFAULT_VAL_STAR_RATING_TYPE,
                'maxRating'=> Globals::DEFAULT_VAL_STAR_RATING_TYPE,
                'readOnly'=>true,
//                'htmlOptions'=>array('style' => 'margin:0 auto;'),
                //'resetText'=>'',
                'value'=>$rating,
                    
            //  'callback'=>'function(){  $(\'#TaskReference_rank\').val($(this).val()); }',
                ));                                                        
        }
    
        public function mailBody($link)
        {
            $result = '';
            if($link)
            {
                $result .= "To Reset your password you need to click on the link given below";
                $result .= "<br/>";
                $result .= "<a href='".$link."' target=_blank>".$link."</a>";
            }
            return $result;                                                  
        }
        public function mailBodyForRegister($link)
        {
            $result = '';
            if($link)
            {
                $result .= "To Confirm your registration you need to click on the link given below";
                $result .= "<br/>";
                $result .= "<a href='".$link."' target=_blank>".$link."</a>";
            }
            return $result;
                                        
        }
        public function getAvg( $current , $currentCount , $newamount )
        {
            $total = $current*$currentCount;
            $totalNew = $total + $newamount;    
            $newAvg = $totalNew / ( $currentCount + 1 );
            return $newAvg;
        }
        
        public function getCategoryIdFromString( $string , $multiple = false )
        {
            if($string)
            {
                preg_match_all('!\d+!', $string, $ids);
                //            print_r($ids[0]);
                //            exit;
                if($multiple)
                return  $category_id = $ids[0];
                else
                return  $category_id = $ids[0][0];
            }
             return  array(0);
        }
       
        public function getChildCategorysIdsFromParent( $cat_id )
        {
            $categoryID = array();
            $categoryID[] = $cat_id;
            try
            {
                $categories = Category::getChildCategoryByID($cat_id);
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            if( $categories )
            {
                foreach( $categories as $category)
                {
                        $categoryID[] = $category->{Globals::FLD_NAME_CATEGORY_ID};
                }
            }
           //print_r($categoryID);
            return  $categoryID;
        }
        
        public function timezoneList()
        {
            //$result = '';
//            $result = array(
//                [Pacific/Midway] => (GMT-11:00) Midway Island, Samoa 
//                [America/Adak] => (GMT-10:00) Hawaii-Aleutian 
//                [Etc/GMT+10] => (GMT-10:00) Hawaii 
//                [Pacific/Marquesas] => (GMT-09:30) Marquesas Islands 
//                [Pacific/Gambier] => (GMT-09:00) Gambier Islands 
//                [America/Anchorage] => (GMT-09:00) Alaska 
//                [America/Ensenada] => (GMT-08:00) Tijuana, Baja California 
//                [Etc/GMT+8] => (GMT-08:00) Pitcairn Islands 
//                [America/Los_Angeles] => (GMT-08:00) Pacific Time (US & Canada) 
//                [America/Denver] => (GMT-07:00) Mountain Time (US & Canada) 
//                [America/Chihuahua] => (GMT-07:00) Chihuahua, La Paz, Mazatlan 
//                [America/Dawson_Creek] => (GMT-07:00) Arizona 
//                [America/Belize] => (GMT-06:00) Saskatchewan, Central America 
//                [America/Cancun] => (GMT-06:00) Guadalajara, Mexico City, Monterrey 
//                [Chile/EasterIsland] => (GMT-06:00) Easter Island 
//                [America/Chicago] => (GMT-06:00) Central Time (US & Canada) 
//                [America/New_York] => (GMT-05:00) Eastern Time (US & Canada) 
//                [America/Havana] => (GMT-05:00) Cuba 
//                [America/Bogota] => (GMT-05:00) Bogota, Lima, Quito, Rio Branco 
//                [America/Caracas] => (GMT-04:30) Caracas 
//                [America/Santiago] => (GMT-04:00) Santiago 
//                [America/La_Paz] => (GMT-04:00) La Paz 
//                [Atlantic/Stanley] => (GMT-04:00) Faukland Islands 
//                [America/Campo_Grande] => (GMT-04:00) Brazil 
//                [America/Goose_Bay] => (GMT-04:00) Atlantic Time (Goose Bay) 
//                [America/Glace_Bay] => (GMT-04:00) Atlantic Time (Canada) 
//                [America/St_Johns] => (GMT-03:30) Newfoundland 
//                [America/Araguaina] => (GMT-03:00) UTC-3 
//                [America/Montevideo] => (GMT-03:00) Montevideo 
//                [America/Miquelon] => (GMT-03:00) Miquelon, St. Pierre 
//                [America/Godthab] => (GMT-03:00) Greenland 
//                [America/Argentina/Buenos_Aires] => (GMT-03:00) Buenos Aires 
//                [America/Sao_Paulo] => (GMT-03:00) Brasilia 
//                [America/Noronha] => (GMT-02:00) Mid-Atlantic 
//                [Atlantic/Cape_Verde] => (GMT-01:00) Cape Verde Is 
//                [Atlantic/Azores] => (GMT-01:00) Azores 
//                [Pacific/Kiritimati] => (GMT+14:00) Kiritimati 
//                [Pacific/Tongatapu] => (GMT+13:00) Nuku'alofa 
//                [Pacific/Chatham] => (GMT+12:45) Chatham Islands 
//                [Etc/GMT-12] => (GMT+12:00) Fiji, Kamchatka, Marshall Is 
//                [Pacific/Auckland] => (GMT+12:00) Auckland, Wellington 
//                [Asia/Anadyr] => (GMT+12:00) Anadyr, Kamchatka 
//                [Pacific/Norfolk] => (GMT+11:30) Norfolk Island 
//                [Etc/GMT-11] => (GMT+11:00) Solomon Is., New Caledonia 
//                [Asia/Magadan] => (GMT+11:00) Magadan 
//                [Australia/Lord_Howe] => (GMT+10:30) Lord Howe Island 
//                [Asia/Vladivostok] => (GMT+10:00) Vladivostok 
//                [Australia/Hobart] => (GMT+10:00) Hobart 
//                [Australia/Brisbane] => (GMT+10:00) Brisbane 
//                [Australia/Darwin] => (GMT+09:30) Darwin 
//                [Australia/Adelaide] => (GMT+09:30) Adelaide 
//                Asia/Yakutsk] => (GMT+09:00) Yakutsk 
//                [Asia/Seoul] => (GMT+09:00) Seoul 
//                [Asia/Tokyo] => (GMT+09:00) Osaka, Sapporo, Tokyo 
//                [Australia/Eucla] => (GMT+08:45) Eucla 
//                [Australia/Perth] => (GMT+08:00) Perth 
//                [Asia/Irkutsk] => (GMT+08:00) Irkutsk, Ulaan Bataar 
//                [Asia/Hong_Kong] => (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi 
//                [Asia/Krasnoyarsk] => (GMT+07:00) Krasnoyarsk 
//                [Asia/Bangkok] => (GMT+07:00) Bangkok, Hanoi, Jakarta 
//                [Asia/Rangoon] => (GMT+06:30) Yangon (Rangoon) 
//                [Asia/Novosibirsk] => (GMT+06:00) Novosibirsk 
//                [Asia/Dhaka] => (GMT+06:00) Astana, Dhaka 
//                [Asia/Katmandu] => (GMT+05:45) Kathmandu 
//                [Asia/Kolkata] => (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi 
//                [Asia/Tashkent] => (GMT+05:00) Tashkent 
//                [Asia/Yekaterinburg] => (GMT+05:00) Ekaterinburg 
//                [Asia/Kabul] => (GMT+04:30) Kabul 
//                [Asia/Yerevan] => (GMT+04:00) Yerevan 
//                [Asia/Dubai] => (GMT+04:00) Abu Dhabi, Muscat 
//                [Asia/Tehran] => (GMT+03:30) Tehran 
//                [Africa/Addis_Ababa] => (GMT+03:00) Nairobi 
//                [Europe/Moscow] => (GMT+03:00) Moscow, St. Petersburg, Volgograd 
//                [Asia/Damascus] => (GMT+02:00) Syria 
//                [Europe/Minsk] => (GMT+02:00) Minsk 
//                [Asia/Jerusalem] => (GMT+02:00) Jerusalem 
//                [Africa/Blantyre] => (GMT+02:00) Harare, Pretoria 
//                [Asia/Gaza] => (GMT+02:00) Gaza 
//                [Africa/Cairo] => (GMT+02:00) Cairo 
//                [Asia/Beirut] => (GMT+02:00) Beirut 
//                [Africa/Windhoek] => (GMT+01:00) Windhoek 
//                [Africa/Algiers] => (GMT+01:00) West Central Africa 
//                [Europe/Brussels] => (GMT+01:00) Brussels, Copenhagen, Madrid, Paris 
//                [Europe/Belgrade] => (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague 
//                [Europe/Amsterdam] => (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna 
//                [Africa/Abidjan] => (GMT+00:00) Monrovia, Reykjavik 
//                [Europe/London] => (GMT+00:00) Greenwich Mean Time : London 
//                [Europe/Lisbon] => (GMT+00:00) Greenwich Mean Time : Lisbon 
//                [Europe/Dublin] => (GMT+00:00) Greenwich Mean Time : Dublin 
//                [Europe/Belfast] => (GMT+00:00) Greenwich Mean Time : Belfast 
//                );

        }
        
   public static function projectStatusDate($data){
      $projectStatusDate = array();
      if(!empty($data)){
         try
         {
            switch($data->state){
                case 'o':   //open
                $projectStatusDate['label'] = 'txt_taskstatus_o';
                $projectStatusDate['date'] = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT});
                break;
                case 'f':   //finished
                $projectStatusDate['label'] = 'txt_taskstatus_f';
                $projectStatusDate['date'] = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_TASK_FINISHED_ON});
                break;

                case 'a':   //assigned
                $projectStatusDate['label'] = 'txt_taskstatus_a';
                $projectStatusDate['date'] = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT});
               // $projectStatusDate['date'] = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_TASK_ASSIGNED_ON});
                break;
                //case 'c':   //cancelled
    //               $projectStatusDate['label'] = 'txt_taskstatus_c';
    //               $projectStatusDate['date'] = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_TASK_END_DATE});
    //            break;
    //            case 'd':   //dispute
    //               $projectStatusDate['label'] = 'txt_taskstatus_d';
    //               $projectStatusDate['date'] = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_TASK_END_DATE});
    //            break;
    //            case 's':   //suspend
    //               $projectStatusDate['label'] = 'txt_taskstatus_s';
    //               $projectStatusDate['date'] = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_TASK_END_DATE});
    //            break;
                default:
                $projectStatusDate['label'] = 'txt_taskstatus_o';
                $projectStatusDate['date'] = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT});
            }
         }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
      }
      return $projectStatusDate;
   }
    public static function isUserLogin()
    {
        $isLogin = false;
        if(Yii::app()->user->id)
            $isLogin = true;
        return $isLogin;
    }
    public static function IsTaskStateOpen($state)
    {
        $isOpen = false;
        if( $state == Globals::DEFAULT_VAL_TASK_STATUS_OPEN )
            $isOpen = true;
        return $isOpen;
    }
    public static function startProfiling( $action = '' , $controller = '' )
    {
        $controller = empty( $controller ) ? Yii::app()->controller->id  : $controller;
        $action = empty( $action ) ? Yii::app()->controller->action->id  : $action;
        if(CommonUtility::IsProfilingEnabled())
        {
            Yii::beginProfile($action, 'application.controller.'.$controller.'Controller');
        }
    }
    public static function endProfiling( $action = '' )
    {
       
        $action = empty( $action ) ? Yii::app()->controller->action->id  : $action;
        if(CommonUtility::isProfilingEnabled())
        {
            Yii::endProfile($action);
        }
    }
    public static function isPremium( $user_id )
    {
        try
        {
            $isPremium = User::isPremiumUser( $user_id );
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        return $isPremium;
    }
    public static function isPremiumTask( $task_id )
    {
        try
        {
            $isPremium = Task::isPremiumTask( $task_id );
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        return $isPremium;
    }
    
    public static function getUserAccountType( $code )
    {
        try
        {
            switch ($code) 
            {
                case Globals::DEFAULT_VAL_ACCOUNT_TYPE_REGULAR:
                    $account_type = Globals::DEFAULT_VAL_ACCOUNT_TYPE_REGULAR_VAL;
                    break;
                case Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM:
                    $account_type = Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM_VAL;
                    break;
                case Globals::DEFAULT_VAL_ACCOUNT_TYPE_SUPER_PREMIUM:
                    $account_type = Globals::DEFAULT_VAL_ACCOUNT_TYPE_SUPER_PREMIUM_VAL;
                    break;
                default:
                    $account_type = Globals::DEFAULT_VAL_NO_ACCOUNT_TYPE;
                    break;
            }
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        return $account_type;
    }
    
    
//    public function getAcco
    public function createorDeleteBookmark($type,$id,$inTasker=false , $options = array())
    {
        switch ($type) 
        {
            case Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK:
                $selectTypeID = Globals::FLD_NAME_TASK_ID;
                break;

            default:
                $selectTypeID = Globals::FLD_NAME_BOOKMARK_USER_ID;
                break;
        }

        $parameters = array
        (
                        $selectTypeID => $id , 
                        Globals::FLD_NAME_USER_ID => Yii::app()->user->id ,
                        Globals::FLD_NAME_BOOKMARK_TYPE => $type , 
                        Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE 
        );
        
        try
        {
            $isBookMark = UserBookmark::isBookMarkByUser($parameters);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if($isBookMark)
        {
            $url = '_unsetpotential';
            if($inTasker==true)
                $url = '//tasker/_unsetpotential';
        }
        else
        {
            $url = '_setpotential';
            if($inTasker==true)
                $url = '//tasker/_setpotential';
        }
        $return = $this->renderPartial($url,array('bookmark_type' => $type,'id'=> $id , 'options' => $options));
        return $return;
    }
    
    public function createorSaveProject($type,$id,$inTasker=false)
    {
        switch ($type) 
        {
            case Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK:
                $selectTypeID = Globals::FLD_NAME_TASK_ID;
                break;

            default:
                $selectTypeID = Globals::FLD_NAME_BOOKMARK_USER_ID;
                break;
        }

        $parameters = array
        (
                        $selectTypeID => $id , 
                        Globals::FLD_NAME_USER_ID => Yii::app()->user->id ,
                        Globals::FLD_NAME_BOOKMARK_TYPE => $type , 
                        Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE 
        );
        
        try
        {
            $isBookMark = UserBookmark::isBookMarkByUser($parameters);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        if($isBookMark)
        {
            $url = '_unsetpotential';
            if($inTasker==true)
                $url = '//tasker/_unsetpotential';
        }
        else
        {
            $url = '_setpotential';
            if($inTasker==true)
                $url = '//tasker/_setpotential';
        }
        $return = $this->renderPartial($url,array('bookmark_type' => $type,'id'=> $id,'savebutton'=>'savebutton' ));
        return $return;
    }
    
    public function saveBookmark($type,$id,$inTasker=false)
    {
        switch ($type) 
        {
            case Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK:
                $selectTypeID = Globals::FLD_NAME_TASK_ID;
                break;

            default:
                $selectTypeID = Globals::FLD_NAME_BOOKMARK_USER_ID;
                break;
        }

        $parameters = array
        (
                        $selectTypeID => $id , 
                        Globals::FLD_NAME_USER_ID => Yii::app()->user->id ,
                        Globals::FLD_NAME_BOOKMARK_TYPE => $type , 
                        Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE 
        );
        
        try
        {
            $isBookMark = UserBookmark::isBookMarkByUser($parameters);
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        $return = '';
//        if($isBookMark)
//        {
////            $url = '_unsetpotential';
////            if($inTasker==true)
////                $url = '//tasker/_removebookmark';
//        }
//        else
//        {
            $url = '_savebookmark';
            if($inTasker==true)
                $url = '//tasker/_savebookmark';
            $return = $this->renderPartial($url,array('bookmark_type' => $type,'id'=> $id , 'isBookMark' => $isBookMark ));
//        }
        return $return;
    }
    public function getProposalListURI($task_id)
    {
        return Yii::app()->createUrl('poster/viewallproposals')."/taskId/".$task_id;
    }
    
    public function getInstantFielEndTime($endtime,$enddate)
    {
        $time = $endtime;
        $timeNew = substr($time, 0, 2) . ':' . substr($time, 2);
        $endDate = $enddate;
        $timeNew = $endDate." ".$timeNew;  
        return $timeNew;
    }
    public function getTaskImageForShare($id)
    {
        $image = CommonUtility::getTaskImageURI($id);
        $taskImage = CommonUtility::getPublicImageUri(Globals::DEFUALT_TASK_SHARE_IMAGE);
        if($image)
        {
            $imagedata = getimagesize($image);
            $width = $imagedata[0];
           $height = $imagedata[1];
            $minWidth = Globals::SHARE_IMAGE_MIN_WIDTH;
            $minHeight = Globals::SHARE_IMAGE_MIN_HEIGHT;
            if($width > $minWidth && $height > $minHeight)
            {
                $taskImage =  $image;
            }
        }
        
        return $taskImage;
        
    }
    public function getPrenmissionToAccessUser($controller , $action )
    {
        $hasPermission = false;
        $permission =  Yii::app()->user->getState('permission');
        if(isset($permission[$controller][$action]))
        {
            $hasPermission = true;
        }
        
        return $hasPermission;
    }
    function margePremissionsArray( array $array1 , array $array2 )
    {
        $output = array();
        foreach ($array1 as $key => $value) 
        {
            if(isset($array2[$key]))
            {
                $output[$key] = array_merge($value, $array2[$key]);
            }
            else
            {
                $output[$key] = $value;
            }
        }
        foreach ($array2 as $key => $value) 
        {
            if(isset($array1[$key]))
            {
                $output[$key] = array_merge($value, $array1[$key]);
            }
            else
            {
                $output[$key] = $value;
            }
        }
        return $output ;
    }
    /**
     * 
     *validate current user to post task or other works
     * 
     */
    public function validateUser()
        {
            try
            {
                $result = CommonUtility::checkUserValidations();
              
            }
            catch(Exception $e)
            {             
                $msg = $e->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            
            if($result['status'] == 'error')
            {
                try
                {
                    $data = CommonScript::popupScript($result);
                }
                catch(Exception $e)
                {             
                    $msg = $e->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }
                return $data;
            }
        }
    /**
     * 
     *validate current user to post task or other works
     * 
     */
    public function checkUserValidations()
    {
        $userValidation = '';
        $userValidation['status'] = 'success';
        
        $isUserSuspended = self::isUserSuspended();
        if($isUserSuspended['status'] == 'error')
        {
            $userValidation['status'] = 'error';
            $userValidation['error_code'][] = $isUserSuspended['error_code'];
        }
        
        
        $isUserProfileComplete = self::isUserProfileComplete();
        if($isUserProfileComplete['status'] == 'error')
        {
            $userValidation['status'] = 'error';
            $userValidation['error_code'][] = $isUserProfileComplete['error_code'];
        }
        
        
        $isUserHasCleanBackground = self::isUserHasCleanBackground();
        if($isUserHasCleanBackground['status'] == 'error')
        {
            $userValidation['status'] = 'error';
            $userValidation['error_code'][] = $isUserHasCleanBackground['error_code'];
        }
        return $userValidation;
       
        

        
    }
    /**
     * 
     * check user is suspended
     * 
     */
    public function isUserSuspended()
    {
        $result['status'] = 'success';
        $result['error_code'] = '';
        return $result;
    }
    /**
     * 
     * check user profile details
     * 
     */
    public function isUserProfileComplete()
    {
        $result = '';
        try 
        {
            $model = User::model()->findByPk(Yii::app()->user->id);
            $result['status'] = 'success';
            $result['error_code'] = '';
            /// varify user profile detail
            if( $model->{Globals::FLD_NAME_FIRSTNAME} == '' || $model->{Globals::FLD_NAME_PRIMARY_EMAIL} == '' || $model->{Globals::FLD_NAME_PRIMARY_PHONE} == '' )
            {
                $result['error_code'][ErrorCode::ERROR_CODE_USER_DETAIL] = 1;
                $result['status'] = 'error';
            }

             /// varify user address detail
            if( $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} == "" || $model->{Globals::FLD_NAME_BILLADDR_STATE_ID} == "" || $model->{Globals::FLD_NAME_BILLADDR_REGION_ID}=="" || $model->{Globals::FLD_NAME_BILLADDR_CITY_ID}=="")
            {
                $result['error_code'][ErrorCode::ERROR_CODE_USER_ADDRESS] = 1;
                $result['status'] = 'error';
            }
             /// varify user payment account detail
            if( $model->{Globals::FLD_NAME_PAYMENT_CUSTOMER_ID} == "" )
            {
                $result['error_code'][ErrorCode::ERROR_CODE_USER_PAYMENT] = 1;
                $result['status'] = 'error';
            }
        } 
        catch (Exception $exc) 
        {
            $msg = $exc->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
        return $result;
        
    }
    /**
     * 
     * check user to not belongs to criminal activiti 
     * 
     */
    public function isUserHasCleanBackground()
    {
        $result['status'] = 'success';
        $result['error_code'] = '';
        return $result;
    }
    /**
     * 
     * Although this function's purpose is to just make the ID short - and not so much secure,
     * you can optionally supply a password to make it harder to calculate the corresponding numeric ID
     */
    public static function createPaymentCustomerId($in, $to_num = false, $pad_up = false, $passKey = null){
      
    $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    if ($passKey !== null) {
        
        for ($n = 0; $n<strlen($index); $n++) {
            $i[] = substr( $index,$n ,1);
        }

        $passhash = hash('sha256',$passKey);
        $passhash = (strlen($passhash) < strlen($index))
            ? hash('sha512',$passKey)
            : $passhash;

        for ($n=0; $n < strlen($index); $n++) {
            $p[] =  substr($passhash, $n ,1);
        }

        array_multisort($p,  SORT_DESC, $i);
        $index = implode($i);
    }

    $base  = strlen($index);

    if ($to_num) {
        // Digital number  <<--  alphabet letter code
        $in  = strrev($in);
        $out = 0;
        $len = strlen($in) - 1;
        for ($t = 0; $t <= $len; $t++) {
            $bcpow = bcpow($base, $len - $t);
            $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
        }

        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $out -= pow($base, $pad_up);
            }
        }
        $out = sprintf('%F', $out);
        $out = substr($out, 0, strpos($out, '.'));
    } else {
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $in += pow($base, $pad_up);
            }
        }

        $out = "";
        for ($t = floor(log($in, $base)); $t >= 0; $t--) {
            $bcp = bcpow($base, $t);
            $a   = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in  = $in - ($a * $bcp);
        }
        $out = strrev($out); // reverse
    }

    ///return $out;
    return Yii::app()->user->id;
    }
    public function getProposalDetailPageForTaskerUrl($task_id ,$task_tasker_id )
    {
        return Yii::app()->createUrl('tasker/proposaldetailtasker')."/task_id/".$task_id."/task_tasker_id/".$task_tasker_id;
    }
    public function getTaskerProjectsUrl()
    {
        return Yii::app()->createUrl('tasker/mytasks');
    }
    public function getTaskerApplyProjectsUrl()
    {
        return Yii::app()->createUrl('tasker/mytasks')."?state=o";
    }
    public function getTaskerSavedProjectsUrl()
    {
        return Yii::app()->createUrl('tasker/mytasks')."?state=o";
    }
    public function getTaskerActiveProjectsUrl()
    {
        return Yii::app()->createUrl('tasker/mytasks')."?state=a";
    }
    public function getPosterActiveProjectsUrl()
    {
        return Yii::app()->createUrl('poster/mytasks')."?state=a";
    }
    public function getTaskerCompletedProjectsUrl()
    {
        return Yii::app()->createUrl('tasker/mytasks')."?state=f";
    }
    public function getPosterCompletedProjectsUrl()
    {
        return Yii::app()->createUrl('poster/mytasks')."?state=f";
    }
    public function getPosterCurrentryHiringUrl()
    {
        return Yii::app()->createUrl('poster/mytasks')."?state=o";
    }
    public function getPosterAllProjectsUrl()
    {
        return Yii::app()->createUrl('poster/mytasks');
    }
    
    public function getPosterSearchMembersUrl()
    {
        return Yii::app()->createUrl('poster/findtasker');
    }
    public function getTaskUpdateUrl($id)
    {
        return Yii::app()->createUrl('poster/createtask').'/task_id/'.$id;
    }
    public function getCreateTaskUrl()
    {
        return Yii::app()->createUrl('poster/createtask');
    }
    public function getTaskSearchUrlByTaskTitle($title)
    {
        return Yii::app()->createUrl('public/tasks').'?Task[title]='.$title;
    }
    public function getTaskSearchUrlByUserJobs($user_id)
    {
        return Yii::app()->createUrl('public/tasks').'?jobs='.$user_id;
    }
    public function getTaskSearchUrlByUserHired($user_id)
    {
        return Yii::app()->createUrl('public/tasks').'?hired='.$user_id;
    }
    public function getTaskerAllProjectsUrl()
    {
        return Yii::app()->createUrl('tasker/mytasks');
    }
     public function getProposalDetailPageForPosterUrl($task_id ,$task_tasker_id )
    {
        return Yii::app()->createUrl('tasker/proposaldetail')."/task_id/".$task_id."/task_tasker_id/".$task_tasker_id;
    }
     public function getTaskEditUrl($task_id)
    {
        return Yii::app()->createUrl('poster/createtask')."/task_id/".$task_id;
    }
    public function getTaskRepeatUrl($task_id)
    {
        return Yii::app()->createUrl('poster/createtask')."/task_id/".$task_id.'/repeat/1';
    }
     public function getPosterTaskRequestUrl($task_id)
    {
        return Yii::app()->createUrl('poster/projectcompletion')."/task_id/".$task_id;
    }
     public function getDoerTaskRequestUrl($task_id)
    {
        return Yii::app()->createUrl('tasker/projectcompletion')."/task_id/".$task_id;
    }
     public function getPosterThankyouPageUrl($task_id)
    {
        return Yii::app()->createUrl('poster/thankyouafterpostingproject')."/task_id/".$task_id;
    }
     public function getProposalAcceptConfirmByDoer($task_tasker_id)
    {
        return Yii::app()->createUrl('tasker/confirmhiringbydoer')."/task_tasker_id/".$task_tasker_id;
    }
    public function getUserDeshboadUrl()
    {
        return Yii::app()->createUrl('index/dashboard');
    }
    
    /*   return min and max rating as poster
     */
    
       public function getMinAndMaxRating($id,$rating)
        {
            $get_rating = array();
            try
            {
                $user = User::model()->findByPk($id);
                if($user)
                {
                    $min_rating = $user->rating_min_as_poster;
                    if($min_rating > $rating || $min_rating == 0)
                        $min_rating = $rating;

                    $max_rating = $user->rating_max_as_poster;
                    if($max_rating < $rating  || $max_rating == 0)
                        $max_rating = $rating;

                    $get_rating['min_rating'] = $min_rating;
                    $get_rating['max_rating'] = $max_rating;
                }
            } 
            catch (Exception $exc) 
            {
                $msg = $exc->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $get_rating;

        }
       public function getMinAndMaxRatingForTasker($id,$rating)
        {
            $get_rating = array();
            try
            {
                $user = User::model()->findByPk($id);
                if($user)
                {
                    $min_rating = $user->rating_min_as_tasker;
                    if($min_rating > $rating || $min_rating == 0)
                        $min_rating = $rating;

                    $max_rating = $user->rating_max_as_tasker;
                    if($max_rating < $rating  || $max_rating == 0)
                        $max_rating = $rating;

                    $get_rating['min_rating'] = $min_rating;
                    $get_rating['max_rating'] = $max_rating;
                }
            } 
            catch (Exception $exc) 
            {
                $msg = $exc->getMessage();
                CommonUtility::catchErrorMsg( $msg  );
            }
            return $get_rating;

        }
        public function getImageDisplayName($imageNameInDb)
        {
            $newImageName = explode("_", $imageNameInDb, 3);
           // print_r($newImageName);
            $imageName = ucfirst(strtolower(str_replace(Globals::FRONT_USER_USER_IMAGE_NAME_SLUG, '', $newImageName[2])));
            return ucfirst($imageName);
        }
      
	

        function getFormatSizeUnitsFromBytes($bytes)
        {
            if ($bytes >= 1073741824)
            {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024)
            {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1)
            {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1)
            {
                $bytes = $bytes . ' byte';
            }
            else
            {
                $bytes = '0 bytes';
            }

            return $bytes;
        }
        function getDateTimeFromTimeStamp($timeStamp)
        {
           
            $date = new DateTime("@$timeStamp");
            return self::formatedViewDate($date->format('Y-m-d H:i:s'));
           
        }
        
        public function getTaskNameByTaskTaskerId($id)
        {
            $model=TaskTasker::model()->findByPk($id);
            //$userContact=UserContact::model()->findByAttributes(array(Globals::FLD_NAME_USER_ID=>$id,'contact_type'=>'E'));
//            echo '<pre>';
//            print_r($model);
            
            if(isset($model))
            {
                return ucwords(strtolower($model['Task'][Globals::FLD_NAME_TITLE]));
            }
        }
    public function getDefaultSelected($valuearray = "",$value="")
    {
       $array = explode('-', $valuearray);      
       if (in_array($value, $array))
        {
            echo 'checked=""';
        }        
    }
    
    public function getServiceFee()
    {
        return Globals::DEFAULT_VAL_MIN_APPROVED_COST;
    }
    
    public function totalPaymentAmount(array $options=array())
    {
//        echo '<pre>';
//        print_r($options);
//        $task_id = $options[Globals::FLD_NAME_TASK_ID];
        $task_price = $options['task_price'];
        $service_fee = $options['service_fee'];
        $receipt_amount = $options['receipt_amount'];
        $bonus = $options['bonus'];
        $service_amount = ($task_price*$service_fee)/100;
        $sub_total = $receipt_amount+($task_price - $service_amount);
        $total_paymant_amount = $bonus+$sub_total;
        return array('service_amount' => $service_amount,'sub_total' => $sub_total,'total_paymant_amount' => $total_paymant_amount,);
    }
    public function totalPaymentAmountForPoster(array $options=array())
    {
//        echo '<pre>';
//        print_r($options);
//        $task_id = $options[Globals::FLD_NAME_TASK_ID];
        $task_price = $options['task_price'];
//        $service_fee = $options['service_fee'];
        $receipt_amount = $options['receipt_amount'];
        $bonus = $options['bonus'];
//        $service_amount = ($task_price*$service_fee)/100;
        $sub_total = $receipt_amount+$task_price;
        $total_paymant_amount = $bonus+$sub_total;
        return array('sub_total' => $sub_total,'bonus' => $bonus,'total_paymant_amount' => $total_paymant_amount);
    }
    
        
    public function getToolTipForDoerReviewPage($rating_desc)
    {
        $tooltip = '';
        if($rating_desc == 'Payment')
        {
                $tooltip = Yii::t('user_alert','payment_tooltip');
        }
        else if($rating_desc == 'Communication')
        {
                $tooltip = Yii::t('user_alert','communication_tooltip');
        }
        else if($rating_desc == 'Support')
        {
                $tooltip = Yii::t('user_alert','support_tooltip');
        }
        else
        {
                $tooltip = Yii::t('user_alert','work_again_tooltip');
        }
        return $tooltip;
    }
     public function differenceBitweenTwoDates($start , $end)
     {
            $start = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);

            $diff = abs(strtotime($end) - strtotime($start));

            $difference['years'] = floor($diff / (365*60*60*24));
            $difference['months'] = floor(($diff - $difference['years'] * 365*60*60*24) / (30*60*60*24));
            $difference['days']  = floor(($diff - $difference['years'] * 365*60*60*24 - $difference['months']*30*60*60*24)/ (60*60*24));
            return $difference;
     }
     public function getUserRoleType()
     {
         $userRole = "";
         $virtualdoer = Yii::app()->user->getState('is_virtualdoer_license');
         $inpersondoer = Yii::app()->user->getState('is_inpersondoer_license');
         $instantdoer = Yii::app()->user->getState('is_instantdoer_license');
         $premiumdoer = Yii::app()->user->getState('is_premiumdoer_license');
         $poster = Yii::app()->user->getState('is_poster_license');
         if(($virtualdoer['permission_status'] == 1 || $inpersondoer['permission_status'] == 1) && $poster['permission_status'] == 1)
         {
             $userRole = "b";
         }
         else if($virtualdoer['permission_status'] == 1 || $inpersondoer['permission_status'] == 1)
         {
             $userRole = "t";
         }
         else if($poster['permission_status'] == 1)
         {
             $userRole = "p";
         }
         else
         {
             $userRole = 'non';
         }
         return $userRole;
     }
     
     public function getUserLicense()
     {
         $userLicense = array();
         $virtualdoer = Yii::app()->user->getState('is_virtualdoer_license');
         $inpersondoer = Yii::app()->user->getState('is_inpersondoer_license');
         $instantdoer = Yii::app()->user->getState('is_instantdoer_license');
         $premiumdoer = Yii::app()->user->getState('is_premiumdoer_license');
         $poster = Yii::app()->user->getState('is_poster_license');
         if($virtualdoer['permission_status'] == 1)
         {
             $userLicense[] = 'v';
         }
          if($inpersondoer['permission_status'] == 1 )
         {
             $userLicense[] = 'p';
         }
//          if($instantdoer == 1)
//         {
//             $userLicense[] = 'i';
//         }         
         return $userLicense;
     }
     public function projectStartDate($taskID)
     {
          $startDate = '';
        $task = Task::model()->findbyPk($taskID);
       
         if($task)
         {
            if($task->{Globals::FLD_NAME_TASK_ASSIGNED_ON})
            {
                $startDate = CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_ASSIGNED_ON});
            }
            else
            {
                 $startDate = CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
            }
         }
         return $startDate;
     }
     public function createArrayForNotification($data)
     {
         $array = array();
         $datas = $data->getData();
         foreach ($datas as $data)
         {
             $array[$data->alert_id] =  date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH,strtotime($data->created_at));
         }
         $array = array_unique($array);
         return $array;
     }
     public function createArrayForTaskReceipt($data)
     {
         $array = "";
         $datas = $data->getData();
         foreach ($datas as $data)
         {
             $array.=  $data->{Globals::FLD_NAME_TASK_TASKER_RECEIPT_ID}.',';
         }
         return substr($array,0, -1);
     }
     public function getUserPrimationStatus($val)
     {
         if($val['permission_status'] == 1)
         {
             return true;
         }
         else
         {
             return false;
         }
     }
     public function updateTaskerReceipt($receiptsIds)
     {
         $receiptsIds = explode(',', $receiptsIds);
         $countreceipt = count($receiptsIds);
         if($countreceipt > 0)
         {
             for($i=0;$i<$countreceipt;$i++)
             {
                try
                 {
                    $updateReceipt[$i] = TaskTaskerReceipt::model()->findByPk($receiptsIds[$i]);
                    $updateReceipt[$i]->{Globals::FLD_NAME_TASKER_RECEIPT_STATUS} = Globals::DEFAULT_VAL_1;
                    $updateReceipt[$i]->{Globals::FLD_NAME_TASKER_RECEIPT_APPROVED_AMOUNT} = $updateReceipt[$i]->{Globals::FLD_NAME_RECEIPT_AMOUNT};
                    $updateReceipt[$i]->{Globals::FLD_NAME_TASKER_RECEIPT_APPROVED_ON} = new CDbExpression('NOW()');
                    $updateReceipt[$i]->Update();
                 }
                catch (Exception $exc) 
                {
                    $msg = $exc->getMessage();
                    CommonUtility::catchErrorMsg( $msg  );
                }                 
             }
         }
     }
     public function getTaskTaskerId($poster_id, $task_id)
    {
         $poster_id = $_POST['poster_id'];
         $task_id = $_POST['task_id'];
            
         $taskTasker = TaskTasker::model()->findByAttributes(array('task_id' =>$task_id,'tasker_id' =>Yii::app()->user->id));
         return $taskTasker;
    }
    public function getLinkOfNotification($taskTaskerId , $atertDesc)
    {
        $link = '';
        try
        {
            $taskTasker = TaskTasker::model()->findByPk($taskTaskerId);
            if($taskTasker)
            {
                $proposalDetailUrl = CommonUtility::getProposalDetailPageForPosterUrl($taskTasker[Globals::FLD_NAME_TASK_ID],$taskTaskerId);
                $proposalConfirmUrl = CommonUtility::getProposalAcceptConfirmByDoer($taskTaskerId);
                $taskDetailUrl = CommonUtility::getTaskDetailURI($taskTasker[Globals::FLD_NAME_TASK_ID]);
                switch($atertDesc)
                {
                    case Globals::ALERT_DESC_CREATE_PROPOSAL:
                        $link = $proposalDetailUrl;
                        break;
                    case Globals::ALERT_DESC_ACCEPT_PROPOSAL:
                        $link = $proposalConfirmUrl;
                        break;
                    case Globals::ALERT_DESC_REJECT_PROPOSAL:
                        $link = $proposalDetailUrl;
                        break;
                    case Globals::ALERT_DESC_TASK_EDITED:
                        $link = $taskDetailUrl;
                        break;
                    case Globals::ALERT_DESC_TASK_CANCELED:
                        $link = $taskDetailUrl;
                        break;
                    case Globals::ALERT_DESC_TASKER_INVITED:
                        $link = $taskDetailUrl;
                        break;
                    default:
                        $link = $taskDetailUrl;
                        break;
                }
            }
        }
        catch (Exception $exc) 
        {
            $msg = $exc->getMessage();
            CommonUtility::catchErrorMsg( $msg , array('hideoutput' => true )  );
        } 
        return $link;
    }
//   public function getUserLicenceByUserId($user_id)
//    {
//        $user = User::model()->findByPk();
//        $
//    }
     
}