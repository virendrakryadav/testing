<?php
$totelstringlength = Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH;

$srtlength = strlen($task->{Globals::FLD_NAME_DESCRIPTION});
$totelstringlength = $totelstringlength-$srtlength;                   
?>
    <?php echo CommonScript::loadPopOverHide(); ?>
<?php echo CommonScript::loadTaskFormScript($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION},$task->{Globals::FLD_NAME_TASK_ATTACHMENTS}) ?>
<?php echo CommonScript::loadRemainingCharScript("Task_description_editable","wordcount",$totelstringlength) ?>
<?php
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'virtualtask-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
       // 'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
Yii::import('ext.chosen.Chosen');
 $is_public = CommonUtility::getFormPublic($task->{Globals::FLD_NAME_VALID_FROM_DT});
 echo $form->hiddenField($task, Globals::FLD_NAME_TASKER_ID_SOURCE);
 echo $form->hiddenField($task, Globals::FLD_NAME_PAYMENT_MODE);
 

?>
<script>
    $( document ).ready(function() 
    {
        $("#Task_end_date").change(function(){
            var options = document.getElementById("Task_bid_duration").getElementsByTagName("option");
            var end_date = $("#Task_end_date").val();
            var date1 = new Date();
            var date2 = new Date(end_date);
            var timeDiff = Math.abs(date2.getTime() - date1.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
            
            options[2].disabled = false;
            options[3].disabled = false;
            options[4].disabled = false;
            if( diffDays < 7 )
            {
                options[2].disabled = true;
                options[3].disabled = true;
                options[4].disabled = true;
            }
            if( diffDays < 15 )
            {
                options[3].disabled = true;
                options[4].disabled = true;
            }
            if( diffDays < 30 )
            {
                options[4].disabled = true;
            }
        //   alert(diffDays);
        });
        
    }); 
</script>
<?php echo $form->hiddenField($taskLocation,  Globals::FLD_NAME_LOCATION_GEO_AREA); ?>

<?php echo $form->hiddenField($taskLocation, Globals::FLD_NAME_LOCATION_LATITUDE); ?>
<?php echo $form->hiddenField($taskLocation, Globals::FLD_NAME_LOCATION_LONGITUDE); ?>
<div class="controls-row pdn2">
   
    <div class="controls-row pdn3">
       
        <!--Instant task left form part start here-->
        <div class="task_editbox">
            

            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="<?php echo CommonUtility::getPublicImageUri("dic-ic.png") ?>"></div>
                <div class="span4 nopadding">
                    <div class="span3  nopadding">
                        <?php echo $form->labelEx($task, Globals::FLD_NAME_DESCRIPTION, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_task_description')))); ?>

                    </div>
                    <div class="span2 rightalign ">
                        
                        <span >
                        <?php //echo CHtml::ajaxLink(Yii::t('poster_createtask','lbl_browse_template'),Yii::app()->createUrl('poster/browsetemplatecategory'),array('data'=>array(Globals::FLD_NAME_CATEGORY_ID=>$category[0]->categorylocale->category_id ,'formType'=>'v'),Globals::FLD_NAME_TYPE=>'POST','success' => 'function(data){$(\'#templatdiv\').html(data);showPopup();}'), array('id'=>'templateDetailBrowse','live'=>false)); ?>
                        </span>
                            
                    </div>
                    <div class="span4 nopadding">
                        <?php 
                        if( $is_public == true )
                        {
                            ?>
                            <div class="partfix">
                                <?php
                                echo $task->{Globals::FLD_NAME_DESCRIPTION};
                                echo '<input type="hidden" id="Task_description_nonedit" value="'.$task->{Globals::FLD_NAME_DESCRIPTION}.'" >';

                                echo '<textarea id="Task_description_editable" name="Task[description_editable]" placeholder="'.CHtml::encode(Yii::t('poster_createtask', 'txt_task_description_update')).'" rows="4" maxlength="'.Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH.'" class="span4 var"></textarea>';
                                echo $form->hiddenField($task, Globals::FLD_NAME_DESCRIPTION ); 
                                ?>
                            </div>
                           <?php
                        }
                        else
                        {
                            echo $form->textArea($task, Globals::FLD_NAME_DESCRIPTION, array('class' => 'span5', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => 4, 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_description')))); 
                        }
                    ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_DESCRIPTION); ?>
                    </div>
                    <div class="span2  nopadding">
                        <div  id="addAttachmentHead" onclick="slideImages();" class="span3 adattach"> 
                            <a>
                                <i class="icon-plus-sign"></i>
                                <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_add_attachment')) ?>
                            </a>
                        </div>
                       
                    </div>
                    <div class="span2 rightalign ">
                        <div class="span2 wordcount3">
                        <span id="wordcount">
                           
                            <?php
				
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                                
                                echo $totelstringlength;
				
				?>
                        </span>
                            </div>
                    </div>
                    <div class="span4 nopadding">
                    
                    <div id="loadAttachment" style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; ?> ">

                        <?php //echo $form->label($task, CHtml::encode(Yii::t('poster_createtask', 'lbl_upload_attachment'))); ?>
                        <?php
                        $success = CommonScript::loadAttachmentSuccess('uploadPortfolioImage','takeImagesPortfolio','portfolioimages');
                        $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
                        CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIX_FILE_SIZE], $success);
                        ?>
                        <?php //echo $form->error($task,'image'); ?>
                        <div id="takeImagesPortfolio" class="" style="display: <?php
                        if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; else
                            echo 'none';
                        ?> ">
                                 <?php
                                 if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})) {
                                     echo UtilityHtml::getAttachmentsOnEdit($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name ,$task->{Globals::FLD_NAME_TASK_ID});
                                 }
                                 ?>

                        </div>

                    </div>
                </div>
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_description_msg')) ?></span>
                </div>
            </div>

              <div class="controls-row cnl_space">
                <div class="name_ic"><img src="<?php echo CommonUtility::getPublicImageUri("time_ic.png") ?>"></div>
                <div class="span5 nopadding">
                    <?php echo $form->labelEx($task, Globals::FLD_NAME_TASK_FINISHED_ON, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_finish_my_task_till')))); ?>
                    <div class="span3 nopadding">
                        <?php
                        $date = '';
                        $minDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                        if (isset($task->{Globals::FLD_NAME_TASK_FINISHED_ON})) 
                        {
                            $date = $task->{Globals::FLD_NAME_TASK_FINISHED_ON};
                          //  $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH, $date);
                            $minDate = $date;
                        }
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_TASK_FINISHED_ON.']',
                            'value' => $date,
                            // additional javascript options for the date picker plugin
                            'options' => array(
                                'dateFormat' => Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH,     // format of "2012-12-25"
                                'yearRange' => Globals::DEFAULT_VAL_DATE_YEAR_RANGE,     // range of year
                                'minDate' =>  $minDate, //date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH), // minimum date    // minimum date
                                'maxDate' => date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH, strtotime('+' . Globals::DEFAULT_VAL_MAX_YEAR_RANGE . ' years')),   // maximum date
                                'showOtherMonths' => true,      // show dates in other months
                                'selectOtherMonths' => true,    // can seelect dates in other months
                                'changeYear' => true,           // can change year
                                'changeMonth' => true, 
                               ),
                            'htmlOptions' => array(
                            'class' => 'span3',
                                'onkeydown' => 'return false',
                            'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'lbl_select_date')),
                            'readonly' => false,
                            ///'disabled'=>$is_public,
                                
                            ),
                        ));
                        ?> 
                        <?php echo $form->error($task, Globals::FLD_NAME_TASK_FINISHED_ON); ?>
                        </div>
                        
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_task_hours')); ?></span>
                </div>
            </div>
          
            
     
     
        </div>
        
        <div class="task_editbox2">
        
            <div id="advanceOptionHeader" onclick="slideIt();" class="h5 bottom_border"><img src="<?php echo CommonUtility::getPublicImageUri("portlet-collapse-icon.png") ?>"><span class="showoption"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_show')); ?> </span></div>
            <div id="advanceOption"  >
<!--                <div class="controls-row cnl_space">
                    <div class="name_ic"><img src="../images/map-ic.png"></div>
                    <div class="span4 nopadding">
                        <?php
                        $locationList = array();
                        $location_check = false;
                        $disabled_check = false;
                        $selectedLocation = '';
                        if (isset($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION})) {
                            $location_check = true;
                            if( $is_public == true)
                            {
                                $disabled_check = true;
                            }
                            $locationList = CommonUtility::getLocationDropdownData($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION});
                            if ($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_C) {
                                $selectedLocation = $taskLocation->{Globals::FLD_NAME_COUNTRY_CODE};
                            } elseif ($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_R) {
                                $selectedLocation = $taskLocation->{Globals::FLD_NAME_REGION_ID};
                            }
                        }
                        ?>
                        <?php echo $form->labelEx($task, Globals::FLD_NAME_PREFERRED_LOCATION, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_need_tasker_at')))); ?>
                     <div class="span4 nopadding">
                     <label class='checkbox visibil'>
					 <?php echo $form->checkBox($task, Globals::FLD_NAME_PREFERRED_LOCATION_CHECK, array('onchange' => 'setLocation(this.id);', 'checked' => $location_check,'disabled'=>$disabled_check,)); ?>
                        <?php echo $form->labelEx($task, Globals::FLD_NAME_PREFERRED_LOCATION_CHECK, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_i_prefer_tasker_from_certain_location')))); ?>
                        </label>
                        </div>
                        <div id="select_preferred_location" >
                        <?php $preferred_location = array(Globals::DEFAULT_VAL_C => CHtml::encode(Yii::t('poster_createtask', 'txt_country')), Globals::DEFAULT_VAL_R => CHtml::encode(Yii::t('poster_createtask', 'txt_regions'))); ?>
                        <?php
                                echo $form->radioButtonList($taskLocation, Globals::FLD_NAME_IS_LOCATION_REGION, $preferred_location,
                                array('checkValue' => '1',
                                    'disabled'=>$disabled_check, 
                                    'class' => '343',
									'separator' => " ",
'template'=>"<label class='radio spanweek'>{input}{label}</label>",
                                    'onChange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'data' => array(Globals::FLD_NAME_IS_LOCATION_REGION => 'js:this.value'),
                                    "url" => CController::createUrl('poster/ajaxgetpreferredlocationlist'),
                                    "success" =>    "function(response)
                                                        {
                                                            $('#multilocation').html(response);
                                                        }"
                                       ,
									    )),
                                ));
                        ?>           
                        <div id="multilocation" class="span5 nopadding">
                        <?php
                            $locationList = "";
                            $locations = array();
                            $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_location'));
                            $taskSelectedLocations = CommonUtility::getTaskPreferredLocations($task->{Globals::FLD_NAME_TASK_ID});
                            //print_r($taskSelectedLocations);
                            if($taskSelectedLocations)
                            {
                                if($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C)
                                {
                                    $locations = CommonUtility::getCountryList();
                                    
                                    $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
                                }
                                elseif($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_R)
                                {
                                    $locations = CommonUtility::getRegionsList();
                                    $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_region'));
                                }
                                $locationList = $taskSelectedLocations[Globals::FLD_NAME_LOCATIONS];
                            }
                            if($disabled_check == true)
                            {
                              //  print_r($locationList);
                                echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_LOCATIONS."_1", $locationList, $locations, array(
                                'data-placeholder' => $placeholder,
                                'disabled'=>$is_public,
                                'options' => array( 'displaySelectedOptions' => false, ),
                                'class'=>'span4'
                                ));
                                if($locationList != '')
                                {
                                    $locationList = array_flip($locationList);
                                    $locations = array_diff_key($locations, $locationList);
                                    $locationList = '';
                                }
                            }
                            echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_LOCATIONS, $locationList, $locations, array(
                            'data-placeholder' => $placeholder,
                            'options' => array(
                                'displaySelectedOptions' => false,
                                ),
                                'class'=>'span4'
                            ));
                        ?>
                        </div>
                            <?php echo $form->error($taskLocation, Globals::FLD_NAME_LOCATION_TYPE); ?>
                        </div>
                    </div>
                    <div class="help"><i class="icon-question-sign"></i>
                        <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_enter_preferred_tasker_location')); ?></span>
                    </div>
                </div>-->
                <?php
                if(isset($skill) && $skill!='' )
                {
                  $skills = CHtml::listData($skill, Globals::FLD_NAME_SKILL_ID, 'skilllocale.skill_desc');
                }
                if (!empty($skills)) 
                {
                    ?>
                    <div class="controls-row cnl_space">
                        <div class="name_ic"><img src="<?php echo CommonUtility::getPublicImageUri("skils-ic.png") ?>"></div>
                        <div class="span4 nopadding">
                            <?php echo $form->labelEx($task, Globals::FLD_NAME_IS_PUBLIC, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_request_specific_skills')))); ?>
                            <?php
                                    $taskSelected = CommonUtility::getSelectedSkills($task->{Globals::FLD_NAME_TASK_ID});
                                    if($is_public == true)
                                    {
                                        echo Chosen::multiSelect(Globals::FLD_NAME_MULTISKILLS."_1", $taskSelected, $skills, array(
                                        'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_skills')),
                                        'disabled'=>$is_public,
                                        'options' => array( 'displaySelectedOptions' => false,),
                                        'class'=>'span4'
                                        ));
                                        if( $taskSelected != '' )
                                        {
                                            $taskSelected = array_flip($taskSelected);
                                            $skills = array_diff_key($skills, $taskSelected);
                                            $taskSelected = '';
                                        }
                                    }
                                    echo Chosen::multiSelect(Globals::FLD_NAME_MULTISKILLS, $taskSelected, $skills, array(
                                        'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_skills')),
                                        'options' => array('displaySelectedOptions' => false ),
                                        'class'=>'span4'
                                    ));
                            ?>
                        </div>
                        <div class="help"><i class="icon-question-sign"></i>
                            <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_desired_skills')); ?></span>
                        </div>
                    </div>
                    <?php
                    }
                    $taskSelectedQuestion = CommonUtility::getSelectedQuestion($task->{Globals::FLD_NAME_TASK_ID});
                    $question = CHtml::listData($questions, Globals::FLD_NAME_QUESTION_ID, 'categoryquestionlocale.question_desc');
                    if (!empty($question)) 
                    {
                        ?>
                        <div class="controls-row cnl_space">
                        <div class="name_ic"><img src="<?php echo CommonUtility::getPublicImageUri("question-ic.png") ?>"></div>
                        <div class="span4 nopadding">
                            <?php echo $form->labelEx($task, Globals::FLD_NAME_IS_PUBLIC, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_set_up_questions')))); ?>
                            <?php
                                if($is_public == true)
                                {
                                     echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_CAT_QUESTION."_1", $taskSelectedQuestion, $question, array(
                                    'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_question')),
                                    'disabled'=>$is_public,
                                    'options' => array('displaySelectedOptions' => FALSE,),
                                    'class'=>'span4'
                                    ));
                                    if( $taskSelectedQuestion != '' )
                                    {
                                        $taskSelectedQuestion = array_flip($taskSelectedQuestion);
                                        $question = array_diff_key($question, $taskSelectedQuestion);
                                        $taskSelectedQuestion = '';
                                    }

                                }
                                echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_CAT_QUESTION, $taskSelectedQuestion, $question, array(
                                'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_question')),
                               
                                'options' => array('displaySelectedOptions' => FALSE,),
                                'class'=>'span4'
                                ));
                            ?>
                        </div>
                        <div class="help"><i class="icon-question-sign"></i>
                            <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_category_questions')); ?></span>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
            </div>
        </div>
        
    </div>
  
      <div class="controls-row cnl_space">
        <div class="btn_cont">
            <div class="ancor">
        <?php
        if($is_public)
        {
            echo $form->hiddenField($task, Globals::FLD_NAME_IS_PUBLIC);
            echo $form->hiddenField($task, Globals::FLD_NAME_PAYMENT_MODE);
            echo $form->hiddenField($task, Globals::FLD_NAME_TASKER_ID_SOURCE);
        }
        if (isset($task->{Globals::FLD_NAME_TASK_ID})) 
        {
            $action = "poster/editinpersontask";
            echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
        } 
        else 
        {
            $action = "poster/saveinpersontask";
        }
        $successUpdate = '
                                if(data.status==="success"){
                                    
                                   window.location.href = window.location.href;

                                   }else{
                                   $.each(data, function(key, val) {
                                                $("#virtualtask-form #"+key+"_em_").text(val);                                                    
                                                $("#virtualtask-form #"+key+"_em_").show();
                                                });
                                   }
                                ';
CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'lbl_save')), Yii::app()->createUrl($action), 'sign_bnt', 'useraddTask', $successUpdate);
?>
            </div>
        <div class="ancor">
            <?php
            $successUpdatePublish = '
                                        if(data.status==="success"){

                                           window.location.href = window.location.href;

                                           }else{
                                           $.each(data, function(key, val) {
                                                        $("#virtualtask-form #"+key+"_em_").text(val);                                                    
                                                        $("#virtualtask-form #"+key+"_em_").show();
                                                        });
                                           }
                                    ';

            if ($task->{Globals::FLD_NAME_VALID_FROM_DT} == Globals::DEFAULT_VAL_VALID_FROM_DT ) 
            {
                CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'lbl_publish')), Yii::app()->createUrl($action) . "?publish=1", 'ancor_bnt2', 'userPublishTask', $successUpdatePublish);
            }
            ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
