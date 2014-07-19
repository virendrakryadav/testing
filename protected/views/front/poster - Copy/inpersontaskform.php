<?php echo CommonScript::loadPopOverHide(); ?>
<?php echo CommonScript::loadTaskFormScriptFixedPrice(); ?>
<?php echo CommonScript::loadAddressScript("TaskLocation_location_geo_area", "TaskLocation_location_latitude", "TaskLocation_location_longitude"); ?>
<?php echo CommonScript::loadTaskFormScript($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION},$task->{Globals::FLD_NAME_TASK_ATTACHMENTS}) ?>
<?php
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'virtualtask-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
Yii::import('ext.chosen.Chosen');
$is_public = CommonUtility::getFormPublic($task->{Globals::FLD_NAME_VALID_FROM_DT});
?>
<div class="controls-row pdn2" >
    <div class="cat_border">
        <div class="cat_type">
            <i class="task_icon2 inperson2"></i><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_inperson_task')) ?>
        </div>
        <div class="cat_heading"><img src="<?php echo CommonUtility::getCategoryImageURI($category[0]->categorylocale->category_id)?>"><?php echo $category[0]->categorylocale->category_name ?>
            <input type="hidden" name="category_id_value" value="<?php echo $category[0]->categorylocale->category_id ?>" >
        </div>
        <div class="change_cat">
            <?php
            if (!isset($task->{Globals::FLD_NAME_TASK_ID})) 
            {
               
                echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_change_category')), Yii::app()->createUrl('poster/loadinpersontask'),
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'success' => 'function(data){
                                       
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.inperson);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadInpersonTaskShort");
                                                                }'), 
                            array('id' => 'loadInpersonTaskCategoryChange', 'class' => 'cat_btn','live'=>false));
            }
            else 
            {
                echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_change_category')), Yii::app()->createUrl('poster/loadinpersontask'),
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'data'=>array('taskId'=>$task->{Globals::FLD_NAME_TASK_ID},'category_id'=>$category[0]->categorylocale->category_id),'type'=>'POST',
                                    'success' => 'function(data){
                                       
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.inperson);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadInpersonTaskShort");
                                                                }'), 
                            array('id' => 'loadInpersonTaskCategoryChange', 'class' => 'cat_btn','live'=>false)); 
               
            }
            ?>
        </div>
    </div>
    <div class="controls-row pdn3">
        <div class="step_row">
            <div class="step1 active">
                <span class="nubr"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_state_1')) ?></span><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_create_your_task')) ?>
            </div>
            <div class="step1"><span class="nubr"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_state_2')) ?></span>
                <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_preview')) ?>
            </div>
        </div>
        <!--Instant task left form part start here-->
        <div class="task_boxleft">
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/title-ic.png"></div>
                <div class="span5 nopadding">
                    <?php echo $form->labelEx($task,Globals::FLD_NAME_TITLE, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_task_title')))); ?>
                    <div class="span5 nopadding">
                        <?php echo $form->textField($task, Globals::FLD_NAME_TITLE, array('class' => 'span5', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_title')),'readonly'=>$is_public)); ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_TITLE); ?>
                    </div>
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"> <?php echo CHtml::encode(Yii::t('poster_createtask', 'help_task_msg')) ?></span>
                </div>
            </div>
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/dic-ic.png"></div>
                <div class="span5 nopadding">
                    <div class="span2  nopadding">
                        <?php echo $form->labelEx($task,Globals::FLD_NAME_DESCRIPTION, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_task_description')))); ?>
                    </div>
                    <div class="span3 rightalign ">
                        <span >
                        <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_browse_template')),Yii::app()->createUrl('poster/browsetemplatecategory'),array('data'=>array(Globals::FLD_NAME_CATEGORY_ID =>$category[0]->categorylocale->category_id ,Globals::FLD_NAME_FORM_TYPE=>Globals::DEFAULT_VAL_V),'type'=>'POST','success' => 'function(data){$(\'#templatdiv\').html(data);showPopup();}'), array('id'=>'templateDetailBrowseadf'.$category[0]->categorylocale->category_id,'live'=>false)); ?>
                        </span> 
                    </div>
                    <div class="span5 nopadding">
                           <?php 
                        if( $is_public == true )
                        {
                            ?>
                        <div class="partfix">
                            <?php
                             echo '<textarea id="Task_description_nonedit" class="span5" name="Task[description_nonedit]" readonly="readonly">'.$task->{Globals::FLD_NAME_DESCRIPTION}.'</textarea>';
                            echo '<textarea id="Task_description_editable" name="Task[description_editable]" placeholder="'.CHtml::encode(Yii::t('poster_createtask', 'txt_task_description_update')).'" rows="4" maxlength="'.Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH.'" class="span5 var"></textarea>';
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
                    <div class="span3  nopadding">
                        <div  id="addAttachmentHead" onclick="slideImages();" class="span3 adattach">
                            <a>
                                <i class="icon-plus-sign"></i>
                                <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_add_attachment')) ?>
                            </a>
                        </div>
                    </div>
                    <div class="span2 rightalign" style="float: right"><span id="wordcount">
                            <?php
				$totelstringlength = Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH;
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                                $srtlength = strlen($task->{Globals::FLD_NAME_DESCRIPTION});
                                $totelstringlength = $totelstringlength-$srtlength;
                                echo $totelstringlength;
				?>
                        </span></div>                    
                <div class="span5 nopadding">
                    <div id="loadAttachment" style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo Yii::t('poster_createtask', 'block'); ?> ">
                        <?php
                        $success = CommonScript::loadAttachmentSuccess('uploadPortfolioImage','takeImagesPortfolio','portfolioimages');
                        $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
                        CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIX_FILE_SIZE], $success);
                        ?>
                        <?php //echo $form->error($task,'image'); ?>
                        <div id="takeImagesPortfolio"  style="display: <?php
                        if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo Yii::t('poster_createtask', 'block'); else
                            echo Yii::t('poster_createtask', 'none');
                        ?> ">
                        <?php
                            if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                                echo UtilityHtml::getAttachmentsOnEdit($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name,$task->{Globals::FLD_NAME_TASK_ID});
                        ?>
                        </div>
                    </div>
                </div>
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_description_msg')) ?></span>
                </div>
            </div>
            <div class="controls-row cnl_space" >
                <div class="name_ic"><img src="../images/map-ic.png"></div>
                <div class="span5 nopadding">
                    <label class="required"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_need_tasker_at')); ?></label>
                    <div class="span3 nopadding yui3-skin-sam">
                        <?php echo $form->textField($taskLocation,  Globals::FLD_NAME_LOCATION_GEO_AREA, array('class' => 'span3', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_enter_address')),'readonly'=>$is_public)); ?>
                        <?php echo $form->error($taskLocation, Globals::FLD_NAME_LOCATION_GEO_AREA); ?>
                        <?php echo $form->hiddenField($taskLocation, Globals::FLD_NAME_LOCATION_LATITUDE); ?>
                        <?php echo $form->hiddenField($taskLocation, Globals::FLD_NAME_LOCATION_LONGITUDE); ?>
                    </div>
                    <div class="startby span1">
                        <?php 
                        if(isset($task->{Globals::FLD_NAME_TASKER_IN_RANGE})) $range = $task->{Globals::FLD_NAME_TASKER_IN_RANGE};
                        else $range = Globals::DEFAULT_VAL_MILES;
                        echo $form->textFieldControlGroup($task, Globals::FLD_NAME_TASKER_IN_RANGE, array('labelOptions' => array("label" => false),'class'=>'priceininper','value'=>$range, 'append' => 'Miles','onblur'=>'callMap(TaskLocation_location_latitude.value,TaskLocation_location_longitude.value,this.value);','placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Enter Range')),
                            //'readonly'=>$is_public
                            )); ?>
                        <?php //echo $form->textField($task, 'Globals::FLD_NAME_TASKER_IN_RANGE, array('class' => 'span1 startby nomargin','onblur'=>'callMap(TaskLocation_location_latitude.value,TaskLocation_location_longitude.value,this.value);', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Enter Range')))); ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_TASKER_IN_RANGE); ?>
                    </div> 
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_tasker_range')); ?></span>
                </div>
            </div>
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/time_ic.png"></div>
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
                        <div class="startby span2">
                            <?php echo $form->textField($task, Globals::FLD_NAME_WORK_HRS, array('class' => 'span2 startby nomargin', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_hours')),'readonly'=>$is_public)); ?>
                            <?php echo $form->error($task, Globals::FLD_NAME_WORK_HRS); ?>
                        </div>
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_task_hours')); ?></span>
                </div>
            </div>
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/card-ic.png"></div>
                <div class="span5 nopadding">
                    <?php echo $form->labelEx($task, Globals::FLD_NAME_PRICE, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_i_am_willing_to_pay')))); ?>
                    <div class="span3 nopadding">
                    <?php //echo $form->textField($task, 'price', array('prepend' => '$', 'class' => 'span2', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', '$0')))); ?>
                    <?php echo $form->textFieldControlGroup($task, Globals::FLD_NAME_PRICE, array('labelOptions' => array("label" => false),'class'=>'pricein', 'prepend' => '$','placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Enter Amount')),'readonly'=>$is_public)); ?>
                    <?php echo $form->error($task, Globals::FLD_NAME_PRICE); ?>
                    </div>
                    <div class=" span">
                        <?php 
                        $task->{Globals::FLD_NAME_PAYMENT_MODE} =  Globals::DEFAULT_VAL_B  ;
                        $payment_mode = array('f' => CHtml::encode(Yii::t('poster_createtask', 'txt_fixed_price')), 'b' => CHtml::encode(Yii::t('poster_createtask', 'txt_open_bid'))); ?>
                        <?php echo $form->radioButtonList($task,Globals::FLD_NAME_PAYMENT_MODE, $payment_mode, array('class' => '','disabled'=>$is_public)); ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_PAYMENT_MODE); ?>
                    </div> 
                    <div class="span4 nopadding" id="pricetext" style="display: none"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_this_task_requires')); ?> <span class="blue_text" id="fixeprice1"><?php echo Globals::DEFAULT_CURRENCY.Globals::DEFULT_FIXED_PRICE; ?></span>&ndash; <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_do_you_have')); ?> <span class="blue_text" id="fixeprice2"><?php echo Globals::DEFAULT_CURRENCY.Globals::DEFULT_FIXED_PRICE; ?></span> <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_to_use_on_this_task')); ?></div>
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_enter_offer_amount')); ?></span>
                </div>
            </div>
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/vis-ic.png"></div>
                <div class="span5 nopadding">
                    <?php echo $form->labelEx($task,Globals::FLD_NAME_IS_PUBLIC, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_posting_visibility')))); ?>
                    <?php $payment_mode = array(Globals::DEFAULT_VAL_1 => CHtml::encode(Yii::t('poster_createtask', 'txt_public_visible_to_everyone')), Globals::DEFAULT_VAL_0 => CHtml::encode(Yii::t('poster_createtask', 'txt_private_only_candidates_i_invite_can_respond'))); ?>
                    <div class="span4 nopadding">
                    <?php echo $form->radioButtonList($task, Globals::FLD_NAME_IS_PUBLIC, $payment_mode, array('checkValue' => Globals::DEFAULT_VAL_1, 'class' => '','disabled'=>$is_public)); ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_IS_PUBLIC); ?>
                    </div> </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_task_visible_to')); ?></span>
                </div>
            </div>
            <?php
            if(isset($skill) && $skill!='' )
            {
                $skills = CHtml::listData($skill, Globals::FLD_NAME_SKILL_ID, 'skilllocale.skill_desc');
            }
            
            $taskSelectedQuestion = CommonUtility::getSelectedQuestion($task->{Globals::FLD_NAME_TASK_ID});
            $question = CHtml::listData($questions, Globals::FLD_NAME_QUESTION_ID, 'categoryquestionlocale.question_desc');
            if(!empty($skills))
            {
            ?>
            <div id="advanceOptionHeader" onclick="slideIt();" class="h5 bottom_border"><img src="../images/portlet-collapse-icon.png"><span><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_show')); ?></span></div>
            <div id="advanceOption"  >
               <?php
                if(isset($skill) && $skill!='' )
                {
                  $skills = CHtml::listData($skill, Globals::FLD_NAME_SKILL_ID, 'skilllocale.skill_desc');
                }
                if (!empty($skills)) 
                {
                    ?>
                    <div class="controls-row cnl_space">
                        <div class="name_ic"><img src="../images/vis-ic.png"></div>
                        <div class="span5 nopadding">
                            <?php echo $form->labelEx($task, Globals::FLD_NAME_IS_PUBLIC, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_request_specific_skills')))); ?>
                            <?php
                                    $taskSelected = CommonUtility::getSelectedSkills($task->{Globals::FLD_NAME_TASK_ID});
                                    if($is_public == true)
                                    {
                                        echo Chosen::multiSelect(Globals::FLD_NAME_MULTISKILLS."_1", $taskSelected, $skills, array(
                                        'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_skills')),
                                        'disabled'=>$is_public,
                                        'options' => array( 'displaySelectedOptions' => false,),
                                        'class'=>'span5'
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
                                        'class'=>'span5'
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
                        <div class="name_ic"><img src="../images/vis-ic.png"></div>
                        <div class="span5 nopadding">
                            <?php echo $form->labelEx($task, Globals::FLD_NAME_IS_PUBLIC, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_set_up_questions')))); ?>
                            <?php
                                if($is_public == true)
                                {
                                     echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_CAT_QUESTION."_1", $taskSelectedQuestion, $question, array(
                                    'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_question')),
                                    'disabled'=>$is_public,
                                    'options' => array('displaySelectedOptions' => FALSE,),
                                    'class'=>'span5'
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
                                'class'=>'span5'
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
            <?php
            }
            ?>
        </div>
               <div class="task_boxright">
                    <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_need_tasker')); ?></h3>
                    </div>
            <div class="boxright_in">
                <div class="span3 nopadding">
                <?php
                    $payment_mode = array( Globals::DEFAULT_VAL_1 => CHtml::encode(Yii::t('poster_createtask', 'lbl_do_you_want_to_select_tasker')), Globals::DEFAULT_VAL_0 => CHtml::encode(Yii::t('poster_createtask', 'lbl_auto_select_by_system')));
                    if($task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::FLD_NAME_USER_SMALL)
                        $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_1;
                    else if($task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::FLD_NAME_AUTO)
                        $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_0;
                    else
                        $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_0;
                ?>
                <?php echo $form->radioButtonList($task,Globals::FLD_NAME_TASKER_ID_SOURCE , $payment_mode, array('checkValue' => Globals::DEFAULT_VAL_1, 'class' => '','disabled'=>$is_public)); ?>
                </div> 
                
                <div id="loadmap" class="">
                <?php 
                $location = '';
                $locationRange ='';
                if(isset($taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE} ) && isset($taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE} ))
                {
                   $lat = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
                   $lng = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                   $range = $task->tasker_in_range;
                }
                else 
                {
                    $addtess = CommonUtility::getAddressAndLatLngFromIp();
                    if($addtess)
                    {
                        $lat = $addtess[Globals::FLD_NAME_LAT];
                        $lng = $addtess[Globals::FLD_NAME_LNG];
                    }
                }
                if(!isset($task->tasker_in_range))  $range = Globals::DEFAULT_VAL_MILES;
                $locationRange = CommonUtility::geologicalPlaces($lat,$lng,$range);
                $users=User::getUsersByLatLng($locationRange);
                if($users)
                {
                    foreach ($users as $user) 
                    {   
                        $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_USER_ID] = $user->{Globals::FLD_NAME_USER_ID};
                        $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_LNG] = $user->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                        $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_LAT] = $user->{Globals::FLD_NAME_LOCATION_LATITUDE};
                        $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_COUNTRY_CODE] = $user->{Globals::FLD_NAME_COUNTRY_CODE};
                    }
                }
                $this->renderPartial('_map',array(
                    'lat'=>$lat,'lng'=>$lng,
                    'task'=>$task,'form'=>$form,'model'=>$model,'location'=>$location,), false, true) ?>
                </div>
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
                                    
                                    $.ajax({
                                            url      : "' . Yii::app()->createUrl('poster/loadinpersontaskpreview') . '",
                                            data     : { '.Globals::FLD_NAME_TASKID.': data.task_id , '.Globals::FLD_NAME_CATEGORY_ID.': data.category_id },
                                            type     : "POST",
                                            dataType : "html",
                                            cache    : false,
                                            success  : function(html)
                                            {
                                                loadPreview();
                                                jQuery("#loadpreview").html(html);
                                                jQuery("#templateCategory").hide();
                                            },
                                            error:function(){
                                                alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                            }
                                        });

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

                                            $.ajax({
                                                    url      : "' . Yii::app()->createUrl('poster/loadinpersontaskpreview') . '",
                                                    data     : { '.Globals::FLD_NAME_TASKID.': data.task_id , '.Globals::FLD_NAME_CATEGORY_ID.': data.category_id },
                                                    type     : "POST",
                                                    dataType : "html",
                                                    cache    : false,
                                                    success  : function(html)
                                                    {
                                                        loadPreview();
                                                        jQuery("#loadpreview").html(html);

                                                    },
                                                    error:function(){
                                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    }
                                                });

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








